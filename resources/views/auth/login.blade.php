{{--
==========================================================================
HALAMAN LOGIN
==========================================================================
Halaman ini digunakan untuk autentikasi pengguna (admin dan siswa).
Menggunakan form yang mengirim email dan password ke AuthController@login.

PENJELASAN
----------
Form ini menggunakan:
- @csrf: Token keamanan untuk mencegah CSRF attack
- @error: Directive untuk menampilkan pesan error validasi
- old('email'): Menampilkan kembali value sebelumnya jika validasi gagal
==========================================================================
--}}

@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-indigo-500 to-purple-600 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full">
        {{-- Card Login --}}
        <div class="bg-white rounded-2xl shadow-xl p-8">
            {{-- Header --}}
            <div class="text-center mb-8">
                <a href="{{ route('landing') }}" class="inline-block">
                    <span class="text-5xl">🍽️</span>
                </a>
                <h2 class="mt-4 text-3xl font-bold text-gray-900">Selamat Datang!</h2>
                <p class="mt-2 text-gray-600">Masuk ke akun RasaPelajar</p>
            </div>

            {{-- Alert Error --}}
            @if(session('error'))
                <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Form Login --}}
            <form action="{{ route('login') }}" method="POST" class="space-y-6">
                {{-- 
                CSRF Token
                ----------
                Token ini wajib ada di setiap form POST untuk keamanan.
                Laravel akan menolak request jika token tidak valid.
                --}}
                @csrf

                {{-- Input Email --}}
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        Email
                    </label>
                    <input 
                        type="email" 
                        name="email" 
                        id="email"
                        value="{{ old('email') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('email') border-red-500 @enderror"
                        placeholder="email@sekolah.com"
                        required
                        autofocus
                    >
                    {{-- 
                    Error Message
                    -------------
                    @error directive akan menampilkan pesan error jika field email
                    tidak lolos validasi di controller
                    --}}
                    @error('email')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Input Password --}}
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                        Password
                    </label>
                    <input 
                        type="password" 
                        name="password" 
                        id="password"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('password') border-red-500 @enderror"
                        placeholder="••••••••"
                        required
                    >
                    @error('password')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Remember Me --}}
                <div class="flex items-center justify-between">
                    <label class="flex items-center">
                        <input type="checkbox" name="remember" class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                        <span class="ml-2 text-sm text-gray-600">Ingat saya</span>
                    </label>
                </div>

                {{-- Submit Button --}}
                <button 
                    type="submit"
                    class="w-full bg-indigo-600 text-white py-3 px-4 rounded-lg font-semibold hover:bg-indigo-700 focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition"
                >
                    Masuk
                </button>
            </form>

            {{-- Link ke Register --}}
            <p class="mt-6 text-center text-gray-600">
                Belum punya akun?
                <a href="{{ route('register') }}" class="text-indigo-600 font-semibold hover:text-indigo-500">
                    Daftar sekarang
                </a>
            </p>

            {{-- Demo Account Info --}}
            <div class="mt-8 p-4 bg-gray-50 rounded-lg">
                <p class="text-sm font-medium text-gray-700 mb-2">Demo Account:</p>
                <div class="text-sm text-gray-600 space-y-1">
                    <p><strong>Admin:</strong> admin@kantin.com</p>
                    <p><strong>Siswa:</strong> siswa@kantin.com</p>
                    <p><strong>Password:</strong> password</p>
                </div>
            </div>
        </div>

        {{-- Back to Home --}}
        <p class="mt-6 text-center">
            <a href="{{ route('landing') }}" class="text-white hover:text-indigo-200">
                ← Kembali ke Beranda
            </a>
        </p>
    </div>
</div>
@endsection
