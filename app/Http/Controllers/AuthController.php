<?php

namespace App\Http\Controllers;

/**
 * ============================================================================
 * CONTROLLER: AuthController
 * ============================================================================
 * 
 * PENJELASAN:
 * Controller ini menangani autentikasi user (login, register, logout).
 * 
 * FLOW AUTENTIKASI:
 * 1. User register → akun dibuat dengan role 'siswa'
 * 2. User login → validasi email & password
 * 3. Setelah login → redirect sesuai role (admin/siswa)
 * 4. Logout → session dihapus
 * ============================================================================
 */

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Tampilkan halaman login
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Proses login
     * 
     * FLOW:
     * 1. Validasi input (email & password)
     * 2. Coba autentikasi dengan Auth::attempt()
     * 3. Jika sukses → regenerate session → redirect sesuai role
     * 4. Jika gagal → kembali dengan error
     */
    public function login(Request $request)
    {
        // Validasi input
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
        ]);

        // Coba login
        if (Auth::attempt($credentials, $request->filled('remember'))) {
            // Regenerate session untuk keamanan
            $request->session()->regenerate();

            // Redirect sesuai role
            if (Auth::user()->isAdmin()) {
                return redirect()->route('admin.dashboard')
                    ->with('success', 'Selamat datang, Admin!');
            }

            return redirect()->route('siswa.menu')
                ->with('success', 'Selamat datang, ' . Auth::user()->name . '!');
        }

        // Login gagal
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    /**
     * Tampilkan halaman register
     */
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    /**
     * Proses registrasi
     * 
     * FLOW:
     * 1. Validasi input
     * 2. Buat user baru dengan role 'siswa'
     * 3. Auto login
     * 4. Redirect ke halaman menu siswa
     */
    public function register(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak sama.',
        ]);

        // Buat user baru (default role: siswa)
        // Note: Password otomatis di-hash oleh cast 'hashed' di Model User
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
            'role' => 'siswa', // Default siswa
        ]);

        // Auto login
        Auth::login($user);

        // Redirect ke menu siswa
        return redirect()->route('siswa.menu')
            ->with('success', 'Registrasi berhasil! Selamat datang, ' . $user->name . '!');
    }

    /**
     * Proses logout
     * 
     * FLOW:
     * 1. Logout user
     * 2. Invalidate session
     * 3. Regenerate token CSRF
     * 4. Redirect ke landing page
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('landing')
            ->with('success', 'Anda telah logout.');
    }
}
