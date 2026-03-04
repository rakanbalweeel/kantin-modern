<?php

namespace App\Http\Middleware;

/**
 * ============================================================================
 * MIDDLEWARE: RoleMiddleware
 * ============================================================================
 * 
 * PENJELASAN:
 * Middleware ini mengontrol akses berdasarkan role user.
 * Middleware berjalan SEBELUM request mencapai controller.
 * 
 * ROLE YANG TERSEDIA:
 * - admin: Pengelola kantin (CRUD kategori, produk, lihat semua pesanan)
 * - siswa: Pembeli (buat pesanan, lihat riwayat pesanan sendiri)
 * 
 * CARA KERJA:
 * 1. Middleware menerima parameter role yang diizinkan
 * 2. Cek apakah user sudah login
 * 3. Cek apakah role user sesuai dengan yang diizinkan
 * 4. Jika sesuai, lanjutkan ke controller
 * 5. Jika tidak, tampilkan error 403 (Forbidden)
 * 
 * CONTOH PENGGUNAAN DI ROUTES:
 * Route::middleware(['role:admin'])->group(function() {
 *     // Hanya admin yang bisa akses
 * });
 * 
 * Route::middleware(['role:siswa'])->group(function() {
 *     // Hanya siswa yang bisa akses
 * });
 * ============================================================================
 */

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  ...$roles  Daftar role yang diizinkan (bisa lebih dari satu)
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        // Cek apakah user sudah login
        if (!auth()->check()) {
            // Jika belum login, redirect ke halaman login
            return redirect()->route('login')
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        // Ambil user yang sedang login
        $user = auth()->user();

        // Cek apakah role user ada dalam daftar role yang diizinkan
        if (!in_array($user->role, $roles)) {
            // Jika role tidak sesuai, tampilkan error 403 (Forbidden)
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        // Jika semua pengecekan lolos, lanjutkan request ke controller
        return $next($request);
    }
}
