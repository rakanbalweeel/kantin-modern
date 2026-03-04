{{--
==========================================================================
DETAIL KATEGORI (SHOW)
==========================================================================
Halaman ini menampilkan detail kategori beserta produk-produk di dalamnya.

PENJELASAN
----------
$category: Model Category yang di-load dengan relationship products
$category->products: Semua produk dalam kategori ini (One-to-Many)
==========================================================================
--}}

@extends('layouts.app')

@section('title', 'Detail Kategori')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Back Button + Header --}}
        <div class="mb-6">
            <a href="{{ route('admin.categories.index') }}" class="inline-flex items-center text-gray-600 hover:text-gray-900">
                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Kembali ke Daftar Kategori
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Info Kategori --}}
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h1 class="text-2xl font-bold text-gray-900 mb-4">{{ $category->nama }}</h1>
                    
                    @if($category->deskripsi)
                        <p class="text-gray-600 mb-4">{{ $category->deskripsi }}</p>
                    @endif

                    <div class="border-t border-gray-200 pt-4 space-y-3">
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-500">Jumlah Produk</span>
                            <span class="text-sm font-medium text-gray-900">{{ $category->products->count() }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-500">Dibuat</span>
                            <span class="text-sm font-medium text-gray-900">{{ $category->created_at->format('d M Y') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-500">Terakhir diubah</span>
                            <span class="text-sm font-medium text-gray-900">{{ $category->updated_at->format('d M Y') }}</span>
                        </div>
                    </div>

                    <div class="mt-6 space-y-2">
                        <a href="{{ route('admin.categories.edit', $category) }}" 
                           class="block w-full text-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                            Edit Kategori
                        </a>
                        <form action="{{ route('admin.categories.destroy', $category) }}" 
                              method="POST"
                              onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="w-full px-4 py-2 border border-red-300 text-red-600 rounded-lg hover:bg-red-50 transition">
                                Hapus Kategori
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Daftar Produk --}}
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                    <div class="p-6 border-b border-gray-200">
                        <div class="flex items-center justify-between">
                            <h2 class="text-lg font-bold text-gray-900">Produk dalam Kategori Ini</h2>
                            <a href="{{ route('admin.products.create') }}" 
                               class="text-sm text-indigo-600 hover:text-indigo-700">
                                + Tambah Produk
                            </a>
                        </div>
                    </div>

                    <div class="divide-y divide-gray-200">
                        @forelse($category->products as $product)
                            <div class="p-4 hover:bg-gray-50">
                                <div class="flex items-center">
                                    @if($product->gambar)
                                        <img src="{{ Storage::url($product->gambar) }}" 
                                             alt="{{ $product->nama }}"
                                             class="w-16 h-16 rounded-lg object-cover">
                                    @else
                                        <div class="w-16 h-16 rounded-lg bg-gray-100 flex items-center justify-center">
                                            <span class="text-2xl">🍽️</span>
                                        </div>
                                    @endif
                                    <div class="ml-4 flex-1">
                                        <h3 class="font-medium text-gray-900">{{ $product->nama }}</h3>
                                        <p class="text-sm text-gray-500">{{ $product->kode }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-semibold text-gray-900">
                                            Rp {{ number_format($product->harga, 0, ',', '.') }}
                                        </p>
                                        <p class="text-sm {{ $product->stok > 10 ? 'text-green-600' : ($product->stok > 0 ? 'text-yellow-600' : 'text-red-600') }}">
                                            Stok: {{ $product->stok }}
                                        </p>
                                    </div>
                                    <a href="{{ route('admin.products.edit', $product) }}" 
                                       class="ml-4 text-indigo-600 hover:text-indigo-700">
                                        Edit
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div class="p-8 text-center text-gray-500">
                                <span class="text-4xl">📦</span>
                                <p class="mt-2">Belum ada produk dalam kategori ini</p>
                                <a href="{{ route('admin.products.create') }}" 
                                   class="mt-2 inline-block text-indigo-600 hover:text-indigo-700">
                                    Tambah produk pertama →
                                </a>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
