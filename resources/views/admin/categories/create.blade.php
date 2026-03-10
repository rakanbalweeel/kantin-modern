{{--
==========================================================================
FORM TAMBAH KATEGORI (CREATE) - DARK THEME
==========================================================================
--}}

@extends('layouts.app')

@section('title', 'Tambah Kategori')

@section('content')
<div class="min-h-screen hero-gradient py-8">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Back Button + Header --}}
        <div class="mb-6">
            <a href="{{ route('admin.categories.index') }}" 
               class="group inline-flex items-center text-slate-400 hover:text-orange-400 transition-all duration-300">
                <span class="flex items-center justify-center w-10 h-10 rounded-xl glass mr-3 group-hover:-translate-x-1 transition-all duration-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </span>
                <span class="font-medium">Kembali</span>
            </a>
            <h1 class="mt-4 text-2xl font-bold text-white">Tambah <span class="gradient-text">Kategori Baru</span></h1>
            <p class="mt-1 text-slate-400">Buat kategori untuk mengelompokkan produk</p>
        </div>

        {{-- Form Card --}}
        <div class="glass-card rounded-2xl p-6">
            <form action="{{ route('admin.categories.store') }}" method="POST">
                @csrf

                {{-- Nama Kategori --}}
                <div class="mb-6">
                    <label for="nama" class="block text-sm font-medium text-slate-300 mb-2">
                        Nama Kategori <span class="text-red-400">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="nama" 
                        id="nama"
                        value="{{ old('nama') }}"
                        class="w-full px-4 py-3 bg-slate-800/50 border border-slate-700 rounded-xl text-white placeholder-slate-500 focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 transition-all @error('nama') border-red-500 @enderror"
                        placeholder="Contoh: Makanan Berat, Minuman, Snack"
                        required
                        autofocus
                    >
                    @error('nama')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-sm text-slate-500">Nama kategori harus unik dan tidak boleh sama dengan kategori lain.</p>
                </div>

                {{-- Deskripsi --}}
                <div class="mb-6">
                    <label for="deskripsi" class="block text-sm font-medium text-slate-300 mb-2">
                        Deskripsi
                    </label>
                    <textarea 
                        name="deskripsi" 
                        id="deskripsi"
                        rows="4"
                        class="w-full px-4 py-3 bg-slate-800/50 border border-slate-700 rounded-xl text-white placeholder-slate-500 focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 transition-all @error('deskripsi') border-red-500 @enderror"
                        placeholder="Deskripsi singkat tentang kategori ini (opsional)"
                    >{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Submit Buttons --}}
                <div class="flex items-center justify-end space-x-4 pt-4 border-t border-slate-700">
                    <a href="{{ route('admin.categories.index') }}" 
                       class="px-6 py-2 bg-slate-700 text-slate-300 rounded-xl hover:bg-slate-600 transition">
                        Batal
                    </a>
                    <button type="submit" 
                            class="px-6 py-2 bg-gradient-to-r from-orange-500 to-amber-500 text-white rounded-xl shadow-lg shadow-orange-500/20 hover:shadow-orange-500/40 transition">
                        Simpan Kategori
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
