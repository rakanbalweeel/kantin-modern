{{--
==========================================================================
FORM EDIT KATEGORI (EDIT)
==========================================================================
Halaman ini berisi form untuk mengedit kategori yang sudah ada.
Form akan dikirim ke CategoryController@update via PUT.

PERBEDAAN DENGAN CREATE
-----------------------
- action: Route ke update method dengan parameter $category
- @method('PUT'): Spoofing method karena form hanya support GET/POST
- value/textarea pre-filled dengan data $category yang sudah ada
==========================================================================
--}}

@extends('layouts.app')

@section('title', 'Edit Kategori')

@section('content')
<div class="py-6">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Back Button + Header --}}
        <div class="mb-6">
            <a href="{{ route('admin.categories.index') }}" class="inline-flex items-center text-gray-600 hover:text-gray-900">
                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Kembali
            </a>
            <h1 class="mt-4 text-2xl font-bold text-gray-900">Edit Kategori</h1>
            <p class="mt-1 text-gray-600">Ubah informasi kategori "{{ $category->nama }}"</p>
        </div>

        {{-- Form Card --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            {{-- 
            Route Model Binding
            --------------------
            $category otomatis di-inject oleh Laravel berdasarkan parameter di URL.
            route('admin.categories.update', $category) akan generate URL:
            /admin/categories/{category}
            --}}
            <form action="{{ route('admin.categories.update', $category) }}" method="POST">
                @csrf
                {{-- 
                Method Spoofing
                ---------------
                Laravel membutuhkan PUT method untuk update, tapi HTML form
                hanya support GET dan POST. @method('PUT') akan menambahkan
                hidden input <input type="hidden" name="_method" value="PUT">
                --}}
                @method('PUT')

                {{-- Nama Kategori --}}
                <div class="mb-6">
                    <label for="nama" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Kategori <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="nama" 
                        id="nama"
                        {{-- 
                        old('nama', $category->nama)
                        -----------------------------
                        Jika ada old data (validasi gagal), tampilkan old data.
                        Jika tidak ada, tampilkan data dari database ($category->nama).
                        --}}
                        value="{{ old('nama', $category->nama) }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('nama') border-red-500 @enderror"
                        placeholder="Contoh: Makanan Berat, Minuman, Snack"
                        required
                        autofocus
                    >
                    @error('nama')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
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
                    >{{ old('deskripsi', $category->deskripsi) }}</textarea>
                    @error('deskripsi')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Info Kategori --}}
                <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                    <p class="text-sm text-gray-600">
                        <strong>Dibuat:</strong> {{ $category->created_at->format('d M Y H:i') }}
                        <br>
                        <strong>Terakhir diubah:</strong> {{ $category->updated_at->format('d M Y H:i') }}
                        <br>
                        <strong>Jumlah produk:</strong> {{ $category->products->count() }} produk
                    </p>
                </div>

                {{-- Submit Buttons --}}
                <div class="flex items-center justify-end space-x-4 pt-4 border-t border-gray-200">
                    <a href="{{ route('admin.categories.index') }}" 
                       class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                        Batal
                    </a>
                    <button type="submit" 
                            class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                        Update Kategori
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
