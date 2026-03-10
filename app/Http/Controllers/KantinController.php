<?php

namespace App\Http\Controllers;

/**
 * ============================================================================
 * CONTROLLER: KantinController
 * ============================================================================
 * 
 * PENJELASAN:
 * Controller untuk fitur-fitur penjaga kantin seperti:
 * - Dashboard dengan daftar pesanan masuk
 * - Menerima dan memproses pesanan dari pembeli
 * - Update status pesanan (one-way, tidak bisa kembali)
 * - Laporan keuangan
 * 
 * ALUR STATUS PESANAN (One-Way):
 * pending -> diproses -> selesai
 *                    -> batal
 * 
 * CATATAN: Status tidak bisa dikembalikan ke sebelumnya
 * ============================================================================
 */

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Setting;
use App\Models\Withdrawal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KantinController extends Controller
{
    /**
     * Dashboard Kantin
     * GET /kantin/dashboard
     * 
     * Menampilkan:
     * - Statistik pesanan hari ini
     * - Daftar pesanan pending (menunggu diproses)
     * - Daftar pesanan yang sedang diproses
     */
    public function dashboard()
    {
        // Statistik hari ini
        $stats = [
            'pesanan_pending' => Order::status('pending')->count(),
            'pesanan_diproses' => Order::status('diproses')->count(),
            'pesanan_selesai_hari_ini' => Order::today()->status('selesai')->count(),
            'pendapatan_hari_ini' => Order::today()->status('selesai')->sum('total'),
        ];

        // Pesanan pending (menunggu dikonfirmasi)
        $pendingOrders = Order::with(['user', 'orderDetails.product'])
            ->status('pending')
            ->oldest() // Yang lebih dulu masuk, ditampilkan lebih atas
            ->take(10)
            ->get();

        // Pesanan sedang diproses
        $processingOrders = Order::with(['user', 'orderDetails.product'])
            ->status('diproses')
            ->oldest()
            ->take(10)
            ->get();

        return view('kantin.dashboard', compact('stats', 'pendingOrders', 'processingOrders'));
    }

    /**
     * Daftar semua pesanan (untuk kantin)
     * GET /kantin/orders
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

        return view('kantin.orders.index', compact('orders'));
    }

    /**
     * Detail pesanan
     * GET /kantin/orders/{order}
     */
    public function showOrder(Order $order)
    {
        $order->load(['user', 'orderDetails.product']);
        return view('kantin.orders.show', compact('order'));
    }

    /**
     * Terima pesanan (ubah status dari pending ke diproses)
     * PATCH /kantin/orders/{order}/accept
     */
    public function acceptOrder(Order $order)
    {
        // Validasi: Hanya bisa terima jika status pending
        if ($order->status !== 'pending') {
            return back()->with('error', 'Pesanan ini sudah tidak berstatus pending.');
        }

        $order->updateStatus('diproses');

        return back()->with('success', "Pesanan {$order->kode_pesanan} diterima dan sedang diproses.");
    }

    /**
     * Selesaikan pesanan (ubah status dari diproses ke selesai)
     * PATCH /kantin/orders/{order}/complete
     */
    public function completeOrder(Order $order)
    {
        // Validasi: Hanya bisa selesaikan jika status diproses
        if ($order->status !== 'diproses') {
            return back()->with('error', 'Pesanan ini tidak dalam status diproses.');
        }

        $order->updateStatus('selesai');

        return back()->with('success', "Pesanan {$order->kode_pesanan} telah diselesaikan.");
    }

    /**
     * Batalkan pesanan
     * PATCH /kantin/orders/{order}/cancel
     * 
     * Catatan: Hanya bisa batalkan jika status pending atau diproses
     * Stok akan dikembalikan jika dibatalkan
     */
    public function cancelOrder(Order $order)
    {
        // Validasi: Tidak bisa membatalkan pesanan yang sudah selesai atau batal
        if (in_array($order->status, ['selesai', 'batal'])) {
            return back()->with('error', 'Pesanan ini tidak dapat dibatalkan.');
        }

        DB::transaction(function () use ($order) {
            // Kembalikan stok untuk semua produk dalam pesanan
            foreach ($order->orderDetails as $detail) {
                $detail->product->increaseStock($detail->jumlah);
            }
            
            // Update status menjadi batal
            $order->updateStatus('batal');
        });

        return back()->with('success', "Pesanan {$order->kode_pesanan} telah dibatalkan dan stok dikembalikan.");
    }

    /**
     * Laporan Keuangan
     * GET /kantin/reports
     */
    public function financialReport(Request $request)
    {
        // Default: bulan ini
        $startDate = $request->input('start_date', now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', now()->toDateString());

        // Total penjualan dalam periode
        $totalSales = Order::betweenDates($startDate, $endDate)
            ->where('status', 'selesai')
            ->sum('total');

        // Total subtotal (sebelum pajak)
        $totalSubtotal = Order::betweenDates($startDate, $endDate)
            ->where('status', 'selesai')
            ->sum('subtotal');

        // Total pajak
        $totalPajak = Order::betweenDates($startDate, $endDate)
            ->where('status', 'selesai')
            ->sum('pajak_nominal');

        // Jumlah transaksi
        $totalTransactions = Order::betweenDates($startDate, $endDate)
            ->where('status', 'selesai')
            ->count();

        // Pesanan batal
        $canceledOrders = Order::betweenDates($startDate, $endDate)
            ->where('status', 'batal')
            ->count();

        // Rata-rata per transaksi
        $averageTransaction = $totalTransactions > 0 
            ? round($totalSales / $totalTransactions) 
            : 0;

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
        $salesByCategory = DB::table('order_details')
            ->join('products', 'order_details.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->join('orders', 'order_details.order_id', '=', 'orders.id')
            ->where('orders.status', 'selesai')
            ->whereBetween('orders.created_at', [$startDate, $endDate . ' 23:59:59'])
            ->select(
                'categories.nama as category_name',
                DB::raw('SUM(order_details.subtotal) as total_revenue'),
                DB::raw('SUM(order_details.jumlah) as total_sold')
            )
            ->groupBy('categories.id', 'categories.nama')
            ->orderByDesc('total_revenue')
            ->get();

        return view('kantin.reports.index', compact(
            'startDate',
            'endDate',
            'totalSales',
            'totalSubtotal',
            'totalPajak',
            'totalTransactions',
            'canceledOrders',
            'averageTransaction',
            'topProducts',
            'dailySales',
            'salesByCategory'
        ));
    }

    // ========================================================================
    // WITHDRAWAL (PENARIKAN TUNAI)
    // ========================================================================

    /**
     * Halaman Penarikan Tunai
     * GET /kantin/withdrawals
     */
    public function withdrawals(Request $request)
    {
        $user = auth()->user();
        
        // Hitung saldo tersedia (dari penjualan selesai - withdrawal approved - pending)
        $totalPendapatan = Order::where('status', 'selesai')->sum('subtotal');
        $totalWithdrawn = Withdrawal::byUser($user->id)->status('approved')->sum('jumlah');
        $pendingWithdrawals = Withdrawal::byUser($user->id)->status('pending')->sum('jumlah');
        
        // Saldo tersedia = Total Pendapatan - Sudah Ditarik - Yang Sedang Pending
        $saldoTersedia = $totalPendapatan - $totalWithdrawn - $pendingWithdrawals;
        
        // Pastikan tidak negatif
        $saldoTersedia = max(0, $saldoTersedia);
        
        // Pajak withdrawal
        $pajakWithdrawal = Setting::get('pajak_withdrawal', 5); // Default 5%
        
        // Riwayat withdrawal
        $withdrawalHistory = Withdrawal::byUser($user->id)
            ->with('approver')
            ->latest()
            ->paginate(10);
        
        return view('kantin.withdrawals.index', compact(
            'totalPendapatan',
            'totalWithdrawn',
            'saldoTersedia',
            'pendingWithdrawals',
            'pajakWithdrawal',
            'withdrawalHistory'
        ));
    }

    /**
     * Proses Request Penarikan
     * POST /kantin/withdrawals
     */
    public function requestWithdrawal(Request $request)
    {
        $request->validate([
            'jumlah' => 'required|numeric|min:10000',
            'metode_pembayaran' => 'required|in:transfer,cash',
            'nama_bank' => 'required_if:metode_pembayaran,transfer',
            'nomor_rekening' => 'required_if:metode_pembayaran,transfer',
            'atas_nama' => 'required_if:metode_pembayaran,transfer',
        ], [
            'jumlah.required' => 'Jumlah penarikan harus diisi.',
            'jumlah.min' => 'Minimal penarikan Rp 10.000.',
            'metode_pembayaran.required' => 'Pilih metode pembayaran.',
            'nama_bank.required_if' => 'Nama bank harus diisi untuk transfer.',
            'nomor_rekening.required_if' => 'Nomor rekening harus diisi untuk transfer.',
            'atas_nama.required_if' => 'Nama pemilik rekening harus diisi untuk transfer.',
        ]);

        $user = auth()->user();
        
        // Hitung saldo tersedia
        $totalPendapatan = Order::where('status', 'selesai')->sum('subtotal');
        $totalWithdrawn = Withdrawal::byUser($user->id)->status('approved')->sum('jumlah');
        $pendingWithdrawals = Withdrawal::byUser($user->id)->status('pending')->sum('jumlah');
        $saldoTersedia = $totalPendapatan - $totalWithdrawn - $pendingWithdrawals;
        
        // Validasi saldo cukup
        if ($request->jumlah > $saldoTersedia) {
            return back()->with('error', 'Saldo tidak mencukupi. Saldo tersedia: Rp ' . number_format($saldoTersedia, 0, ',', '.'));
        }
        
        // Hitung pajak
        $pajakPersen = Setting::get('pajak_withdrawal', 5);
        $calculation = Withdrawal::calculateWithTax($request->jumlah, $pajakPersen);
        
        // Buat withdrawal request
        Withdrawal::create([
            'user_id' => $user->id,
            'kode_withdrawal' => Withdrawal::generateKode(),
            'jumlah' => $calculation['jumlah'],
            'pajak_persen' => $calculation['pajak_persen'],
            'pajak_nominal' => $calculation['pajak_nominal'],
            'jumlah_bersih' => $calculation['jumlah_bersih'],
            'status' => 'pending',
            'metode_pembayaran' => $request->metode_pembayaran,
            'nama_bank' => $request->nama_bank,
            'nomor_rekening' => $request->nomor_rekening,
            'atas_nama' => $request->atas_nama,
        ]);
        
        return back()->with('success', 'Permintaan penarikan sebesar Rp ' . number_format($request->jumlah, 0, ',', '.') . ' berhasil diajukan. Menunggu persetujuan admin.');
    }
}
