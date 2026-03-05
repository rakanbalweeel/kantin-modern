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
        });
    
    /*
    |----------------------------------------------------------------------
    | Siswa Routes
    |----------------------------------------------------------------------
    | Prefix: /siswa
    | Middleware: role:siswa
    | Hanya user dengan role 'siswa' yang bisa mengakses
    */
    Route::prefix('siswa')
        ->middleware('role:siswa')
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
