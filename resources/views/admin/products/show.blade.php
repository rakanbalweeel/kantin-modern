{{--
==========================================================================
DETAIL PRODUK (SHOW)
==========================================================================
Halaman ini menampilkan detail lengkap produk termasuk statistik penjualan.
==========================================================================
--}}

@extends('layouts.app')

@section('title', 'Detail Produk')

@section('content')
<div class="py-6">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Back Button --}}
        <div class="mb-6">
            <a href="{{ route('admin.products.index') }}" class="inline-flex items-center text-gray-600 hover:text-gray-900">
                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Kembali ke Daftar Produk
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="md:flex">
                {{-- Gambar Produk --}}
                <div class="md:flex-shrink-0">
                    @if($product->gambar)
                        <img src="{{ Storage::url($product->gambar) }}" 
                             alt="{{ $product->nama }}"
                             class="h-64 w-full md:w-64 object-cover">
                    @else
                        <div class="h-64 w-full md:w-64 bg-gray-100 flex items-center justify-center">
                            <span class="text-6xl">🍽️</span>
                        </div>
                    @endif
                </div>

                {{-- Info Produk --}}
                <div class="p-8 flex-1">
                    <div class="flex items-start justify-between">
                        <div>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800 mb-2">
                                {{ $product->category->nama }}
                            </span>
                            <h1 class="text-2xl font-bold text-gray-900">{{ $product->nama }}</h1>
                            <p class="text-sm text-gray-500 mt-1">{{ $product->kode }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-3xl font-bold text-indigo-600">
                                Rp {{ number_format($product->harga, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>

                    @if($product->deskripsi)
                        <p class="mt-4 text-gray-600">{{ $product->deskripsi }}</p>
                    @endif

                    {{-- Stok Info --}}
                    <div class="mt-6 flex items-center">
                        <span class="text-sm text-gray-500 mr-2">Stok:</span>
                        @if($product->stok <= 0)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                Habis
                            </span>
                        @elseif($product->stok <= 10)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                {{ $product->stok }} tersisa (Hampir habis)
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                {{ $product->stok }} tersedia
                            </span>
                        @endif
                    </div>

                    {{-- Actions --}}
                    <div class="mt-8 flex space-x-4">
                        <a href="{{ route('admin.products.edit', $product) }}" 
                           class="flex-1 text-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                            Edit Produk
                        </a>
                        <form action="{{ route('admin.products.destroy', $product) }}" 
                              method="POST"
                              class="flex-1"
                              onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="w-full px-4 py-2 border border-red-300 text-red-600 rounded-lg hover:bg-red-50 transition">
                                Hapus Produk
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Statistik --}}
            <div class="border-t border-gray-200 bg-gray-50 px-8 py-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Statistik Penjualan</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="bg-white p-4 rounded-lg">
                        <p class="text-sm text-gray-500">Total Terjual</p>
                        <p class="text-2xl font-bold text-gray-900">
                            {{ $product->orderDetails->sum('jumlah') }}
                        </p>
                    </div>
                    <div class="bg-white p-4 rounded-lg">
                        <p class="text-sm text-gray-500">Total Pendapatan</p>
                        <p class="text-2xl font-bold text-indigo-600">
                            Rp {{ number_format($product->orderDetails->sum('subtotal'), 0, ',', '.') }}
                        </p>
                    </div>
                    <div class="bg-white p-4 rounded-lg">
                        <p class="text-sm text-gray-500">Jumlah Order</p>
                        <p class="text-2xl font-bold text-gray-900">
                            {{ $product->orderDetails->count() }}
                        </p>
                    </div>
                    <div class="bg-white p-4 rounded-lg">
                        <p class="text-sm text-gray-500">Rata-rata Qty/Order</p>
                        <p class="text-2xl font-bold text-gray-900">
                            {{ $product->orderDetails->count() > 0 ? round($product->orderDetails->sum('jumlah') / $product->orderDetails->count(), 1) : 0 }}
                        </p>
                    </div>
                </div>
            </div>

            {{-- Info Timestamps --}}
            <div class="border-t border-gray-200 px-8 py-4 bg-gray-50">
                <p class="text-sm text-gray-500">
                    Dibuat: {{ $product->created_at->format('d M Y H:i') }} 
                    · Terakhir diubah: {{ $product->updated_at->format('d M Y H:i') }}
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
