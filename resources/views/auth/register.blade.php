{{--
==========================================================================
HALAMAN REGISTER (PENDAFTARAN SISWA)
==========================================================================
Halaman ini digunakan untuk pendaftaran akun baru.
Secara default, akun yang didaftarkan adalah SISWA.
Akun admin hanya bisa dibuat melalui seeder atau langsung ke database.

PENJELASAN
----------
Form ini menggunakan:
- @csrf: Token keamanan untuk mencegah CSRF attack
- @error: Directive untuk menampilkan pesan error validasi
- old('name'): Menampilkan kembali value sebelumnya jika validasi gagal
- password_confirmation: Field konfirmasi password (Laravel auto-check)
==========================================================================
--}}

@extends('layouts.app')

@section('title', 'Daftar Akun')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-indigo-500 to-purple-600 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full">
        {{-- Card Register --}}
        <div class="bg-white rounded-2xl shadow-xl p-8">
            {{-- Header --}}
            <div class="text-center mb-8">
                <a href="{{ route('landing') }}" class="inline-block">
                    <span class="text-5xl">🍽️</span>
                </a>
                <h2 class="mt-4 text-3xl font-bold text-gray-900">Daftar Akun</h2>
                <p class="mt-2 text-gray-600">Buat akun untuk mulai pesan makanan</p>
            </div>

            {{-- Form Register --}}
            <form action="{{ route('register') }}" method="POST" class="space-y-5">
                @csrf

                {{-- Input Nama --}}
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Lengkap
                    </label>
                    <input 
                        type="text" 
                        name="name" 
                        id="name"
                        value="{{ old('name') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('name') border-red-500 @enderror"
                        placeholder="Nama lengkap kamu"
                        required
                        autofocus
                    >
                    @error('name')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

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
                    >
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
                        placeholder="Minimal 8 karakter"
                        required
                    >
                    @error('password')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- 
                Input Konfirmasi Password
                -------------------------
                Field ini WAJIB bernama "password_confirmation" agar Laravel
                secara otomatis melakukan validasi 'confirmed' pada field password.
                Laravel akan membandingkan password dan password_confirmation.
                --}}
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                        Konfirmasi Password
                    </label>
                    <input 
                        type="password" 
                        name="password_confirmation" 
                        id="password_confirmation"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                        placeholder="Ulangi password"
                        required
                    >
                </div>

                {{-- Submit Button --}}
                <button 
                    type="submit"
                    class="w-full bg-indigo-600 text-white py-3 px-4 rounded-lg font-semibold hover:bg-indigo-700 focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition"
                >
                    Daftar
                </button>
            </form>

            {{-- Link ke Login --}}
            <p class="mt-6 text-center text-gray-600">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="text-indigo-600 font-semibold hover:text-indigo-500">
                    Masuk di sini
                </a>
            </p>
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
