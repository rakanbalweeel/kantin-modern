<?php

namespace App\Http\Controllers;

/**
 * ============================================================================
 * CONTROLLER: AdminController
 * ============================================================================
 * 
 * PENJELASAN:
 * Controller untuk fitur-fitur admin seperti:
 * - Dashboard dengan statistik
 * - Melihat semua pesanan
 * - Update status pesanan
 * - Laporan penjualan
 * ============================================================================
 */

use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /**
     * Dashboard Admin
     * GET /admin/dashboard
     * 
     * STATISTIK:
     * - Total pendapatan (pesanan selesai)
     * - Jumlah pesanan hari ini
     * - Jumlah produk
     * - Jumlah siswa terdaftar
     * - Pesanan terbaru
     */
    public function dashboard()
    {
        // Statistik utama
        $stats = [
            'total_pendapatan' => Order::where('status', 'selesai')->sum('total'),
            'pesanan_hari_ini' => Order::today()->count(),
            'total_produk' => Product::count(),
            'total_siswa' => User::where('role', 'siswa')->count(),
            'pesanan_pending' => Order::status('pending')->count(),
        ];

        // Pesanan terbaru (5 terakhir)
        $recentOrders = Order::with('user')
            ->latest()
            ->take(5)
            ->get();

        // Produk dengan stok menipis (< 10) dengan relasi category
        $lowStockProducts = Product::with('category')
            ->where('stok', '<', 10)
            ->orderBy('stok')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentOrders', 'lowStockProducts'));
    }

    /**
     * Daftar semua pesanan (untuk admin)
     * GET /admin/orders
     */
    public function orders(Request $request)
    {
        $query = Order::with(['user', 'orderDetails']);

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->status($request->status);
        }

        // Filter berdasarkan tanggal
        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        // Pencarian berdasarkan kode pesanan atau nama siswa
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
     * Detail pesanan (untuk admin)
     * GET /admin/orders/{order}
     */
    public function showOrder(Order $order)
    {
        $order->load(['user', 'orderDetails.product']);
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Update status pesanan
     * PUT /admin/orders/{order}/status
     */
    public function updateOrderStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,diproses,selesai,batal',
        ]);

        $oldStatus = $order->status;
        $newStatus = $request->status;

        // Jika dibatalkan, kembalikan stok
        if ($newStatus === 'batal' && $oldStatus !== 'batal') {
            DB::transaction(function () use ($order) {
                foreach ($order->orderDetails as $detail) {
                    $detail->product->increaseStock($detail->jumlah);
                }
                $order->updateStatus('batal');
            });
        } else {
            $order->updateStatus($newStatus);
        }

        $statusLabels = [
            'pending' => 'Menunggu',
            'diproses' => 'Diproses',
            'selesai' => 'Selesai',
            'batal' => 'Dibatalkan',
        ];

        return back()->with('success', "Status pesanan diubah menjadi {$statusLabels[$newStatus]}.");
    }

    /**
     * Laporan Penjualan
     * GET /admin/reports/sales
     */
    public function salesReport(Request $request)
    {
        // Default: bulan ini
        $startDate = $request->input('start_date', now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', now()->toDateString());

        // Total penjualan dalam periode
        $totalSales = Order::betweenDates($startDate, $endDate)
            ->where('status', 'selesai')
            ->sum('total');

        // Jumlah transaksi
        $totalTransactions = Order::betweenDates($startDate, $endDate)
            ->where('status', 'selesai')
            ->count();

        // Produk terlaris
        $topProducts = DB::table('order_details')
            ->join('products', 'order_details.product_id', '=', 'products.id')
            ->join('orders', 'order_details.order_id', '=', 'orders.id')
            ->where('orders.status', 'selesai')
            ->whereBetween('orders.created_at', [$startDate, $endDate . ' 23:59:59'])
            ->select(
                'products.nama',
                DB::raw('SUM(order_details.jumlah) as total_sold'),
                DB::raw('SUM(order_details.subtotal) as total_revenue')
            )
            ->groupBy('products.id', 'products.nama')
            ->orderByDesc('total_sold')
            ->limit(10)
            ->get();

        // Penjualan per hari (untuk chart)
        $dailySales = Order::betweenDates($startDate, $endDate)
            ->where('status', 'selesai')
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(total) as total'),
                DB::raw('COUNT(*) as count')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Penjualan per kategori
        $categoryStats = DB::table('order_details')
            ->join('products', 'order_details.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->join('orders', 'order_details.order_id', '=', 'orders.id')
            ->where('orders.status', 'selesai')
            ->whereBetween('orders.created_at', [$startDate, $endDate . ' 23:59:59'])
            ->select(
                'categories.nama',
                DB::raw('SUM(order_details.subtotal) as total_revenue')
            )
            ->groupBy('categories.id', 'categories.nama')
            ->orderByDesc('total_revenue')
            ->get();

        return view('admin.reports.sales', compact(
            'startDate',
            'endDate',
            'totalSales',
            'totalTransactions',
            'topProducts',
            'dailySales',
            'categoryStats'
        ));
    }

    /**
     * Kelola Stok - Halaman utama
     * GET /admin/stock
     */
    public function stockManagement()
    {
        $products = Product::with('category')
            ->orderBy('stok')
            ->paginate(15);

        return view('admin.stock.index', compact('products'));
    }
}
