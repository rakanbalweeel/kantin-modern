{{--
==========================================================================
FORM TAMBAH KATEGORI (CREATE)
==========================================================================
Halaman ini berisi form untuk menambah kategori baru.
Form akan dikirim ke CategoryController@store via POST.

PENJELASAN FORM
---------------
- action: Route ke store method
- method: POST (untuk create)
- @csrf: Token keamanan wajib
- @error: Menampilkan pesan error validasi per field
- old('field'): Mengembalikan value jika validasi gagal
==========================================================================
--}}

@extends('layouts.app')

@section('title', 'Tambah Kategori')

@section('content')
<div class="py-6">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Back Button + Header --}}
        <div class="mb-6">
            <a href="{{ route('admin.categories.index') }}" 
               class="group inline-flex items-center text-gray-500 hover:text-indigo-600 transition-all duration-300">
                <span class="flex items-center justify-center w-10 h-10 rounded-xl bg-white shadow-md border border-gray-100 mr-3 group-hover:shadow-lg group-hover:border-indigo-200 group-hover:-translate-x-1 transition-all duration-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </span>
                <span class="font-medium">Kembali</span>
            </a>
            <h1 class="mt-4 text-2xl font-bold text-gray-900">Tambah Kategori Baru</h1>
            <p class="mt-1 text-gray-600">Buat kategori untuk mengelompokkan produk</p>
        </div>

        {{-- Form Card --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <form action="{{ route('admin.categories.store') }}" method="POST">
                {{-- CSRF Token - Wajib untuk keamanan --}}
                @csrf

                {{-- Nama Kategori --}}
                <div class="mb-6">
                    <label for="nama" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Kategori <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="nama" 
                        id="nama"
                        value="{{ old('nama') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('nama') border-red-500 @enderror"
                        placeholder="Contoh: Makanan Berat, Minuman, Snack"
                        required
                        autofocus
                    >
                    {{-- Pesan error jika validasi gagal --}}
                    @error('nama')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-sm text-gray-500">Nama kategori harus unik dan tidak boleh sama dengan kategori lain.</p>
                </div>

                {{-- Deskripsi --}}
                <div class="mb-6">
                    <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-2">
                        Deskripsi
                    </label>
                    <textarea 
                        name="deskripsi" 
                        id="deskripsi"
                        rows="4"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('deskripsi') border-red-500 @enderror"
                        placeholder="Deskripsi singkat tentang kategori ini (opsional)"
                    >{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Submit Buttons --}}
                <div class="flex items-center justify-end space-x-4 pt-4 border-t border-gray-200">
                    <a href="{{ route('admin.categories.index') }}" 
                       class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                        Batal
                    </a>
                    <button type="submit" 
                            class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                        Simpan Kategori
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
