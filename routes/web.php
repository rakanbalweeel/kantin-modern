<?php

/**
 * ============================================================================
 * WEB ROUTES - Sistem Informasi Kantin Sekolah
 * ============================================================================
 * 
 * STRUKTUR ROUTES:
 * 
 * 1. GUEST ROUTES (Tanpa Login)
 *    - Landing page (/)
 *    - Login (/login)
 *    - Register (/register)
 * 
 * 2. ADMIN ROUTES (Role: admin) - Prefix: /admin
 *    - Dashboard dengan statistik
 *    - CRUD Kategori (resource route)
 *    - CRUD Produk (resource route)
 *    - Kelola semua pesanan
 *    - Update status pesanan
 *    - Laporan penjualan
 * 
 * 3. SISWA ROUTES (Role: siswa) - Prefix: /siswa
 *    - Lihat menu produk
 *    - Buat pesanan
 *    - Lihat detail pesanan (struk)
 *    - Riwayat pesanan
 *    - Batalkan pesanan
 * 
 * ============================================================================
 * PENJELASAN ROUTE RESOURCE
 * ============================================================================
 * 
 * Route::resource('categories', CategoryController::class) membuat 7 routes:
 * 
 * | Method    | URI                        | Action  | Route Name               |
 * |-----------|----------------------------|---------|--------------------------|
 * | GET       | /admin/categories          | index   | admin.categories.index   |
 * | GET       | /admin/categories/create   | create  | admin.categories.create  |
 * | POST      | /admin/categories          | store   | admin.categories.store   |
 * | GET       | /admin/categories/{cat}    | show    | admin.categories.show    |
 * | GET       | /admin/categories/{cat}/edit | edit  | admin.categories.edit    |
 * | PUT/PATCH | /admin/categories/{cat}    | update  | admin.categories.update  |
 * | DELETE    | /admin/categories/{cat}    | destroy | admin.categories.destroy |
 * 
 * ============================================================================
 */

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaldoController;
use App\Http\Controllers\SettingController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Landing Page (Public)
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('landing');
})->name('landing');

/*
|--------------------------------------------------------------------------
| Guest Routes (Belum Login)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    // Login
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    
    // Register
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

/*
|--------------------------------------------------------------------------
| Authenticated Routes (Harus Login)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    // Logout (semua role)
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    /*
    |----------------------------------------------------------------------
    | Admin Routes
    |----------------------------------------------------------------------
    | Prefix: /admin
    | Middleware: role:admin
    | Hanya user dengan role 'admin' yang bisa mengakses
    */
    Route::prefix('admin')
        ->middleware('role:admin')
        ->name('admin.')
        ->group(function () {
            
            // Dashboard
            Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
            
            // CRUD Kategori (Resource Route)
            Route::resource('categories', CategoryController::class);
            
            // CRUD Produk (Resource Route)
            Route::resource('products', ProductController::class);
            Route::patch('/products/{product}/stock', [ProductController::class, 'updateStock'])
                ->name('products.updateStock');
            
            // Pesanan (Admin bisa lihat semua)
            Route::get('/orders', [AdminController::class, 'orders'])->name('orders.index');
            Route::get('/orders/{order}', [AdminController::class, 'showOrder'])->name('orders.show');
            Route::patch('/orders/{order}/status', [AdminController::class, 'updateOrderStatus'])
                ->name('orders.updateStatus');
            
            // Laporan Penjualan
            Route::get('/reports/sales', [AdminController::class, 'salesReport'])->name('reports.sales');
            
            // Saldo Management (Admin)
            Route::get('/saldo', [SaldoController::class, 'adminIndex'])->name('saldo.index');
            Route::patch('/saldo/{id}/approve', [SaldoController::class, 'approve'])->name('saldo.approve');
            Route::patch('/saldo/{id}/reject', [SaldoController::class, 'reject'])->name('saldo.reject');
            Route::post('/saldo/{user}/topup', [SaldoController::class, 'adminTopup'])->name('saldo.topup');
            
            // Pengaturan Sistem (Settings)
            Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
            Route::post('/settings/pajak', [SettingController::class, 'updatePajak'])->name('settings.pajak');
            
            // Kelola Penarikan Tunai
            Route::get('/withdrawals', [AdminController::class, 'withdrawals'])->name('withdrawals.index');
            Route::get('/withdrawals/{withdrawal}', [AdminController::class, 'showWithdrawal'])->name('withdrawals.show');
            Route::patch('/withdrawals/{withdrawal}/approve', [AdminController::class, 'approveWithdrawal'])->name('withdrawals.approve');
            Route::patch('/withdrawals/{withdrawal}/reject', [AdminController::class, 'rejectWithdrawal'])->name('withdrawals.reject');
        });
    
    /*
    |----------------------------------------------------------------------
    | Kantin Routes (Penjaga Kantin)
    |----------------------------------------------------------------------
    | Prefix: /kantin
    | Middleware: role:kantin
    | Hanya user dengan role 'kantin' yang bisa mengakses
    | 
    | FITUR:
    | - Dashboard dengan pesanan masuk
    | - Menerima dan memproses pesanan
    | - Laporan keuangan
    | 
    | ALUR STATUS (One-Way):
    | pending -> diproses -> selesai
    |                    -> batal
    | Status TIDAK BISA dikembalikan ke sebelumnya
    */
    Route::prefix('kantin')
        ->middleware('role:kantin')
        ->name('kantin.')
        ->group(function () {
            
            // Dashboard - Pesanan Masuk
            Route::get('/dashboard', [\App\Http\Controllers\KantinController::class, 'dashboard'])->name('dashboard');
            
            // Daftar Semua Pesanan
            Route::get('/orders', [\App\Http\Controllers\KantinController::class, 'orders'])->name('orders.index');
            Route::get('/orders/{order}', [\App\Http\Controllers\KantinController::class, 'showOrder'])->name('orders.show');
            
            // Aksi Pesanan (One-Way Status Change)
            Route::patch('/orders/{order}/accept', [\App\Http\Controllers\KantinController::class, 'acceptOrder'])->name('orders.accept');
            Route::patch('/orders/{order}/complete', [\App\Http\Controllers\KantinController::class, 'completeOrder'])->name('orders.complete');
            Route::patch('/orders/{order}/cancel', [\App\Http\Controllers\KantinController::class, 'cancelOrder'])->name('orders.cancel');
            
            // Laporan Keuangan
            Route::get('/reports', [\App\Http\Controllers\KantinController::class, 'financialReport'])->name('reports');
            
            // Penarikan Tunai
            Route::get('/withdrawals', [\App\Http\Controllers\KantinController::class, 'withdrawals'])->name('withdrawals.index');
            Route::post('/withdrawals', [\App\Http\Controllers\KantinController::class, 'requestWithdrawal'])->name('withdrawals.store');
        });
    
    /*
    |----------------------------------------------------------------------
    | Siswa Routes
    |----------------------------------------------------------------------
    | Prefix: /siswa
    | Middleware: role:siswa,kantin
    | User dengan role 'siswa' atau 'kantin' bisa mengakses
    */
    Route::prefix('siswa')
        ->middleware('role:siswa,kantin')
        ->name('siswa.')
        ->group(function () {
            
            // Menu Produk
            Route::get('/menu', [OrderController::class, 'menu'])->name('menu');
            
            // Keranjang / Checkout
            Route::get('/cart', [OrderController::class, 'cart'])->name('cart');
            
            // Pesanan
            Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
            Route::get('/orders/history', [OrderController::class, 'history'])->name('orders.index');
            Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
            Route::patch('/orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
            
            // Saldo
            Route::get('/saldo', [SaldoController::class, 'index'])->name('saldo.index');
            Route::post('/saldo/topup', [SaldoController::class, 'requestTopup'])->name('saldo.topup');
        });
});
