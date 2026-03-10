<?php

namespace App\Http\Controllers;

/**
 * ============================================================================
 * CONTROLLER: OrderController
 * ============================================================================
 * 
 * PENJELASAN:
 * Controller untuk mengelola pesanan siswa.
 * Ini adalah controller UTAMA yang mengimplementasikan logika bisnis pemesanan.
 * 
 * FITUR SISWA:
 * - Melihat menu (produk kantin)
 * - Membuat pesanan
 * - Melihat detail pesanan
 * - Melihat riwayat pesanan
 * 
 * LOGIKA PENTING:
 * 1. Validasi stok sebelum pesanan dibuat
 * 2. Gunakan DB::transaction untuk atomicity
 * 3. Kurangi stok otomatis setelah pesanan dibuat
 * 4. Hitung total otomatis
 * ============================================================================
 */

use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use App\Models\OrderDetail;
use App\Models\Setting;
use App\Http\Requests\StoreOrderRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Tampilkan halaman menu untuk siswa
     * GET /siswa/menu
     * 
     * PENJELASAN:
     * - Ambil semua produk yang stoknya > 0
     * - Kelompokkan berdasarkan kategori
     * - Eager load category untuk efisiensi
     */
    public function menu(Request $request)
    {
        // Ambil semua kategori untuk filter
        $categories = Category::orderBy('nama')->get();

        // Query produk dengan filter kategori jika ada
        $query = Product::with('category')->where('stok', '>', 0);

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        $products = $query->orderBy('nama')->paginate(12);

        return view('siswa.menu', compact('categories', 'products'));
    }

    /**
     * Tampilkan halaman keranjang/checkout
     * GET /siswa/cart
     */
    public function cart()
    {
        $pajak_persen = Setting::getPajakPersen();
        return view('siswa.cart', compact('pajak_persen'));
    }

    /**
     * Simpan pesanan baru
     * POST /siswa/orders
     * 
     * FLOW:
     * 1. Validasi input (dari StoreOrderRequest)
     * 2. Validasi stok untuk setiap item
     * 3. Mulai DB transaction
     * 4. Buat order baru
     * 5. Buat order details untuk setiap item
     * 6. Kurangi stok produk
     * 7. Commit transaction
     * 
     * PENJELASAN DB::transaction:
     * - Memastikan semua operasi berhasil atau tidak sama sekali
     * - Jika ada error, semua perubahan di-rollback
     * - Menjaga konsistensi data
     */
    public function store(StoreOrderRequest $request)
    {
        $items = $request->validated()['items'];
        $catatan = $request->validated()['catatan'] ?? null;
        $waktuPengambilan = $request->validated()['waktu_pengambilan'] ?? 'istirahat_1';

        // Validasi stok untuk setiap item
        $errors = [];
        foreach ($items as $item) {
            $product = Product::find($item['product_id']);
            
            if (!$product) {
                $errors[] = "Produk tidak ditemukan.";
                continue;
            }
            
            if (!$product->hasStock($item['jumlah'])) {
                $errors[] = "Stok {$product->nama} tidak mencukupi. Tersedia: {$product->stok}";
            }
        }

        if (!empty($errors)) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => implode(' ', $errors),
                    'errors' => $errors
                ], 422);
            }
            return back()->withErrors($errors)->withInput();
        }

        // Gunakan DB Transaction untuk atomicity
        try {
            $order = DB::transaction(function () use ($items, $catatan, $waktuPengambilan) {
                // 1. Hitung subtotal terlebih dahulu
                $subtotal = 0;

                // Pre-calculate subtotal
                foreach ($items as $item) {
                    $product = Product::find($item['product_id']);
                    $subtotal += $product->harga * $item['jumlah'];
                }

                // 2. Hitung pajak dari setting
                $pajak = Setting::hitungPajak($subtotal);
                $total = $subtotal + $pajak['nominal'];

                // 3. Buat order baru dengan informasi pajak
                $order = Order::create([
                    'user_id' => Auth::id(),
                    'kode_pesanan' => Order::generateKodePesanan(),
                    'subtotal' => $subtotal,
                    'pajak_persen' => $pajak['persen'],
                    'pajak_nominal' => $pajak['nominal'],
                    'total' => $total,
                    'status' => Order::STATUS_PENDING,
                    'catatan' => $catatan,
                    'waktu_pengambilan' => $waktuPengambilan,
                ]);

                // 4. Buat detail pesanan untuk setiap item
                foreach ($items as $item) {
                    $product = Product::find($item['product_id']);
                    
                    // Hitung subtotal item
                    $itemSubtotal = $product->harga * $item['jumlah'];

                    // Buat detail pesanan
                    OrderDetail::create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'jumlah' => $item['jumlah'],
                        'harga' => $product->harga, // Simpan harga saat ini
                        'subtotal' => $itemSubtotal,
                    ]);

                    // 5. Kurangi stok produk
                    $product->decreaseStock($item['jumlah']);
                }

                return $order;
            });

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Pesanan berhasil dibuat!',
                    'order' => $order,
                    'redirect' => route('siswa.orders.show', $order)
                ]);
            }

            return redirect()->route('siswa.orders.show', $order)
                ->with('success', 'Pesanan berhasil dibuat!');

        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan saat membuat pesanan: ' . $e->getMessage()
                ], 500);
            }
            return back()
                ->with('error', 'Terjadi kesalahan saat membuat pesanan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Tampilkan detail pesanan
     * GET /siswa/orders/{order}
     */
    public function show(Order $order)
    {
        // Pastikan siswa hanya bisa lihat pesanannya sendiri
        if ($order->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403, 'Anda tidak memiliki akses ke pesanan ini.');
        }

        $order->load(['orderDetails.product', 'user']);

        return view('siswa.orders.show', compact('order'));
    }

    /**
     * Tampilkan riwayat pesanan siswa
     * GET /siswa/orders
     */
    public function history(Request $request)
    {
        $query = Order::forUser(Auth::id())
            ->with(['orderDetails.product'])
            ->latest();

        // Filter by status if provided
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $orders = $query->paginate(10)->withQueryString();

        return view('siswa.orders.index', compact('orders'));
    }

    /**
     * Batalkan pesanan (hanya jika masih pending)
     * POST /siswa/orders/{order}/cancel
     */
    public function cancel(Order $order)
    {
        // Pastikan siswa hanya bisa batalkan pesanannya sendiri
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        // Cek apakah bisa dibatalkan
        if (!$order->canBeCancelled()) {
            return back()->with('error', 'Pesanan tidak dapat dibatalkan karena sudah diproses.');
        }

        // Gunakan transaction untuk kembalikan stok
        DB::transaction(function () use ($order) {
            // Kembalikan stok untuk setiap item
            foreach ($order->orderDetails as $detail) {
                $detail->product->increaseStock($detail->jumlah);
            }

            // Update status jadi batal
            $order->updateStatus(Order::STATUS_BATAL);
        });

        return back()->with('success', 'Pesanan berhasil dibatalkan.');
    }
}
