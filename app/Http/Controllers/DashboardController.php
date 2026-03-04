<?php

namespace App\Http\Controllers;

/**
 * ============================================================================
 * CONTROLLER: DashboardController
 * ============================================================================
 * 
 * PENJELASAN:
 * Controller ini menangani fitur admin:
 * - Dashboard dengan statistik
 * - Melihat semua pesanan
 * - Update status pesanan
 * - Laporan penjualan
 * 
 * QUERY OPTIMIZATION:
 * - Menggunakan aggregate functions (sum, count) langsung di database
 * - Eager loading untuk relasi
 * - Index pada kolom yang sering di-filter (created_at, status)
 * ============================================================================
 */

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Dashboard Admin - Menampilkan statistik utama
     */
    public function index(): View
    {
        // Statistik umum
        $stats = [
            'total_categories' => Category::count(),
            'total_products' => Product::count(),
            'total_orders' => Order::count(),
            'total_users' => User::where('role', 'siswa')->count(),
        ];

        // Pendapatan hari ini
        $todayRevenue = Order::where('status', 'selesai')
            ->whereDate('created_at', today())
            ->sum('total');

        // Pendapatan bulan ini
        $monthlyRevenue = Order::where('status', 'selesai')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('total');

        // Pesanan terbaru (5 terakhir)
        $recentOrders = Order::with('user')
            ->latest()
            ->take(5)
            ->get();

        // Produk dengan stok rendah (< 10)
        $lowStockProducts = Product::with('category')
            ->where('stok', '<', 10)
            ->orderBy('stok')
            ->take(5)
            ->get();

        // Produk terlaris bulan ini
        $topProducts = Product::withCount(['orderDetails as sold' => function($query) {
                $query->whereHas('order', function($q) {
                    $q->where('status', 'selesai')
                      ->whereMonth('created_at', now()->month);
                });
            }])
            ->orderByDesc('sold')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'todayRevenue',
            'monthlyRevenue',
            'recentOrders',
            'lowStockProducts',
            'topProducts'
        ));
    }

    /**
     * Menampilkan semua pesanan (untuk admin)
     */
    public function orders(Request $request): View
    {
        $query = Order::with(['user', 'orderDetails']);

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan tanggal
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Search berdasarkan kode pesanan atau nama siswa
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('kode_pesanan', 'like', "%{$search}%")
                  ->orWhereHas('user', function($q2) use ($search) {
                      $q2->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $orders = $query->latest()->paginate(15);

        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Menampilkan detail pesanan (untuk admin)
     */
    public function showOrder(Order $order): View
    {
        $order->load(['user', 'orderDetails.product']);

        return view('admin.orders.show', compact('order'));
    }

    /**
     * Update status pesanan
     */
    public function updateOrderStatus(Request $request, Order $order): RedirectResponse
    {
        $request->validate([
            'status' => 'required|in:pending,diproses,selesai,batal',
        ]);

        $oldStatus = $order->status;
        $newStatus = $request->status;

        // Jika status berubah ke 'batal' dan sebelumnya bukan 'batal'
        // Kembalikan stok produk
        if ($newStatus === 'batal' && $oldStatus !== 'batal') {
            foreach ($order->orderDetails as $detail) {
                $detail->product->increment('stok', $detail->jumlah);
            }
        }

        // Jika status berubah dari 'batal' ke status lain
        // Kurangi stok kembali (jarang terjadi, tapi untuk kelengkapan)
        if ($oldStatus === 'batal' && $newStatus !== 'batal') {
            foreach ($order->orderDetails as $detail) {
                if (!$detail->product->hasStock($detail->jumlah)) {
                    return redirect()
                        ->back()
                        ->with('error', "Stok {$detail->product->nama} tidak mencukupi untuk mengaktifkan kembali pesanan ini.");
                }
            }
            
            foreach ($order->orderDetails as $detail) {
                $detail->product->decrement('stok', $detail->jumlah);
            }
        }

        $order->update(['status' => $newStatus]);

        return redirect()
            ->back()
            ->with('success', 'Status pesanan berhasil diperbarui!');
    }

    /**
     * Laporan Penjualan
     */
    public function salesReport(Request $request): View
    {
        // Default: bulan ini
        $startDate = $request->get('start_date', now()->startOfMonth()->toDateString());
        $endDate = $request->get('end_date', now()->toDateString());

        // Total penjualan
        $totalSales = Order::where('status', 'selesai')
            ->whereBetween('created_at', [$startDate, $endDate . ' 23:59:59'])
            ->sum('total');

        // Jumlah pesanan
        $totalOrders = Order::where('status', 'selesai')
            ->whereBetween('created_at', [$startDate, $endDate . ' 23:59:59'])
            ->count();

        // Penjualan per hari
        $dailySales = Order::where('status', 'selesai')
            ->whereBetween('created_at', [$startDate, $endDate . ' 23:59:59'])
            ->selectRaw('DATE(created_at) as date, SUM(total) as total, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Produk terlaris periode ini
        $topProducts = Product::withSum(['orderDetails as total_sold' => function($query) use ($startDate, $endDate) {
                $query->whereHas('order', function($q) use ($startDate, $endDate) {
                    $q->where('status', 'selesai')
                      ->whereBetween('created_at', [$startDate, $endDate . ' 23:59:59']);
                });
            }], 'jumlah')
            ->withSum(['orderDetails as total_revenue' => function($query) use ($startDate, $endDate) {
                $query->whereHas('order', function($q) use ($startDate, $endDate) {
                    $q->where('status', 'selesai')
                      ->whereBetween('created_at', [$startDate, $endDate . ' 23:59:59']);
                });
            }], 'subtotal')
            ->having('total_sold', '>', 0)
            ->orderByDesc('total_sold')
            ->take(10)
            ->get();

        // Penjualan per kategori
        $salesByCategory = Category::withSum(['products.orderDetails as total_revenue' => function($query) use ($startDate, $endDate) {
                $query->whereHas('order', function($q) use ($startDate, $endDate) {
                    $q->where('status', 'selesai')
                      ->whereBetween('created_at', [$startDate, $endDate . ' 23:59:59']);
                });
            }], 'subtotal')
            ->get();

        return view('admin.reports.sales', compact(
            'startDate',
            'endDate',
            'totalSales',
            'totalOrders',
            'dailySales',
            'topProducts',
            'salesByCategory'
        ));
    }
}
