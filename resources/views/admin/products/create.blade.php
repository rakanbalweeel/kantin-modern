{{--
==========================================================================
FORM TAMBAH PRODUK (CREATE) - DARK THEME
==========================================================================
--}}

@extends('layouts.app')

@section('title', 'Tambah Produk')

@section('content')
<div class="min-h-screen hero-gradient py-8">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Header --}}
        <div class="mb-6">
            <a href="{{ route('admin.products.index') }}" class="group inline-flex items-center text-slate-400 hover:text-orange-400 transition-all">
                <span class="flex items-center justify-center w-10 h-10 rounded-xl glass mr-3 group-hover:-translate-x-1 transition-all">
                    <i class="fas fa-arrow-left"></i>
                </span>
                <span class="font-medium">Kembali</span>
            </a>
            <h1 class="mt-4 text-2xl font-bold text-white">Tambah <span class="gradient-text">Produk Baru</span></h1>
            <p class="mt-1 text-slate-400">Tambahkan menu baru ke kantin</p>
        </div>

        {{-- Form Card --}}
        <div class="glass-card rounded-2xl p-6">
            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Nama --}}
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-slate-300 mb-2">Nama Produk <span class="text-red-400">*</span></label>
                        <input type="text" name="nama" value="{{ old('nama') }}" class="w-full px-4 py-3 bg-slate-800/50 border border-slate-700 rounded-xl text-white placeholder-slate-500 focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 @error('nama') border-red-500 @enderror" placeholder="Nama produk" required>
                        @error('nama')<p class="mt-1 text-sm text-red-400">{{ $message }}</p>@enderror
                    </div>

                    {{-- Kategori --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Kategori <span class="text-red-400">*</span></label>
                        <select name="category_id" class="w-full px-4 py-3 bg-slate-800/50 border border-slate-700 rounded-xl text-white focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 @error('category_id') border-red-500 @enderror" required>
                            <option value="" class="bg-slate-800">Pilih Kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" class="bg-slate-800" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')<p class="mt-1 text-sm text-red-400">{{ $message }}</p>@enderror
                    </div>

                    {{-- Harga --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Harga <span class="text-red-400">*</span></label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-500">Rp</span>
                            <input type="number" name="harga" value="{{ old('harga') }}" class="w-full pl-12 pr-4 py-3 bg-slate-800/50 border border-slate-700 rounded-xl text-white placeholder-slate-500 focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 @error('harga') border-red-500 @enderror" placeholder="0" min="0" required>
                        </div>
                        @error('harga')<p class="mt-1 text-sm text-red-400">{{ $message }}</p>@enderror
                    </div>

                    {{-- Stok --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Stok <span class="text-red-400">*</span></label>
                        <input type="number" name="stok" value="{{ old('stok', 0) }}" class="w-full px-4 py-3 bg-slate-800/50 border border-slate-700 rounded-xl text-white placeholder-slate-500 focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 @error('stok') border-red-500 @enderror" min="0" required>
                        @error('stok')<p class="mt-1 text-sm text-red-400">{{ $message }}</p>@enderror
                    </div>

                    {{-- Gambar --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Gambar Produk</label>
                        <input type="file" name="gambar" accept="image/*" class="w-full px-4 py-3 bg-slate-800/50 border border-slate-700 rounded-xl text-slate-300 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-orange-500 file:text-white hover:file:bg-orange-600 @error('gambar') border-red-500 @enderror">
                        @error('gambar')<p class="mt-1 text-sm text-red-400">{{ $message }}</p>@enderror
                    </div>

                    {{-- Deskripsi --}}
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-slate-300 mb-2">Deskripsi</label>
                        <textarea name="deskripsi" rows="3" class="w-full px-4 py-3 bg-slate-800/50 border border-slate-700 rounded-xl text-white placeholder-slate-500 focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 @error('deskripsi') border-red-500 @enderror" placeholder="Deskripsi produk (opsional)">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')<p class="mt-1 text-sm text-red-400">{{ $message }}</p>@enderror
                    </div>
                </div>

                {{-- Submit --}}
                <div class="flex items-center justify-end space-x-4 pt-6 mt-6 border-t border-slate-700">
                    <a href="{{ route('admin.products.index') }}" class="px-6 py-2 bg-slate-700 text-slate-300 rounded-xl hover:bg-slate-600 transition">Batal</a>
                    <button type="submit" class="px-6 py-2 bg-gradient-to-r from-orange-500 to-amber-500 text-white rounded-xl shadow-lg shadow-orange-500/20 hover:shadow-orange-500/40 transition">Simpan Produk</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
