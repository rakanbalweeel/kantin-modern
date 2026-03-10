{{--
==========================================================================
DETAIL PRODUK (SHOW) - DARK THEME
==========================================================================
--}}

@extends('layouts.app')

@section('title', 'Detail Produk')

@section('content')
<div class="min-h-screen hero-gradient py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Header --}}
        <div class="mb-6">
            <a href="{{ route('admin.products.index') }}" class="group inline-flex items-center text-slate-400 hover:text-orange-400 transition-all">
                <span class="flex items-center justify-center w-10 h-10 rounded-xl glass mr-3 group-hover:-translate-x-1 transition-all">
                    <i class="fas fa-arrow-left"></i>
                </span>
                <span class="font-medium">Kembali</span>
            </a>
        </div>

        {{-- Product Card --}}
        <div class="glass-card rounded-2xl overflow-hidden">
            <div class="md:flex">
                {{-- Image --}}
                <div class="md:w-1/3">
                    @if($product->gambar)
                        <img src="{{ asset('storage/' . $product->gambar) }}" alt="{{ $product->nama }}" class="w-full h-64 md:h-full object-cover">
                    @else
                        <div class="w-full h-64 md:h-full bg-slate-800 flex items-center justify-center">
                            <i class="fas fa-image text-6xl text-slate-600"></i>
                        </div>
                    @endif
                </div>
                
                {{-- Info --}}
                <div class="md:w-2/3 p-6">
                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <span class="px-3 py-1 bg-orange-500/20 text-orange-400 rounded-lg text-sm border border-orange-500/30">
                                {{ $product->category->nama ?? 'Tanpa Kategori' }}
                            </span>
                            <h1 class="mt-3 text-2xl font-bold text-white">{{ $product->nama }}</h1>
                        </div>
                        <div class="flex space-x-2">
                            <a href="{{ route('admin.products.edit', $product) }}" class="px-4 py-2 bg-amber-500/20 text-amber-400 rounded-xl hover:bg-amber-500/30 transition">
                                <i class="fas fa-edit mr-1"></i> Edit
                            </a>
                            <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-4 py-2 bg-red-500/20 text-red-400 rounded-xl hover:bg-red-500/30 transition">
                                    <i class="fas fa-trash mr-1"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                    
                    <p class="text-slate-400 mb-6">{{ $product->deskripsi ?: 'Tidak ada deskripsi' }}</p>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-slate-800/50 rounded-xl p-4">
                            <p class="text-sm text-slate-400 mb-1">Harga</p>
                            <p class="text-2xl font-bold text-orange-400">Rp {{ number_format($product->harga, 0, ',', '.') }}</p>
                        </div>
                        <div class="bg-slate-800/50 rounded-xl p-4">
                            <p class="text-sm text-slate-400 mb-1">Stok</p>
                            @if($product->stok <= 0)
                                <p class="text-2xl font-bold text-red-400">Habis</p>
                            @elseif($product->stok <= 10)
                                <p class="text-2xl font-bold text-amber-400">{{ $product->stok }}</p>
                            @else
                                <p class="text-2xl font-bold text-emerald-400">{{ $product->stok }}</p>
                            @endif
                        </div>
                    </div>
                    
                    <div class="mt-6 pt-6 border-t border-slate-700">
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <p class="text-slate-500">ID Produk</p>
                                <p class="text-white">{{ $product->id }}</p>
                            </div>
                            <div>
                                <p class="text-slate-500">Dibuat</p>
                                <p class="text-white">{{ $product->created_at->format('d M Y, H:i') }}</p>
                            </div>
                            <div>
                                <p class="text-slate-500">Terakhir Update</p>
                                <p class="text-white">{{ $product->updated_at->format('d M Y, H:i') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
