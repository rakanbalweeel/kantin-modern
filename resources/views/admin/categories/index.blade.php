{{--
==========================================================================
DAFTAR KATEGORI (INDEX) - DARK THEME
==========================================================================
--}}

@extends('layouts.app')

@section('title', 'Kelola Kategori')

@section('content')
<div class="min-h-screen hero-gradient py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
            <div class="mb-4 sm:mb-0">
                <h1 class="text-3xl font-extrabold text-white">
                    Kelola <span class="gradient-text">Kategori</span>
                </h1>
                <p class="mt-2 text-slate-400">Kelompokkan produk berdasarkan kategori</p>
            </div>
            <a href="{{ route('admin.categories.create') }}" 
               class="group inline-flex items-center px-6 py-3 bg-gradient-to-r from-orange-500 to-amber-500 text-white font-semibold rounded-xl shadow-lg shadow-orange-500/20 hover:shadow-orange-500/40 hover:-translate-y-0.5 transition-all duration-300">
                <span class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center mr-3 group-hover:scale-110 transition-transform">
                    <i class="fas fa-plus text-sm"></i>
                </span>
                Tambah Kategori
            </a>
        </div>

        {{-- Stats Summary --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
            <div class="glass-card rounded-xl p-4 hover:bg-white/5 transition-all">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-gradient-to-br from-orange-500 to-amber-500 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-folder text-white"></i>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-white">{{ $categories->total() }}</p>
                        <p class="text-xs text-slate-400">Total Kategori</p>
                    </div>
                </div>
            </div>
            <div class="glass-card rounded-xl p-4 hover:bg-white/5 transition-all">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-gradient-to-br from-emerald-500 to-green-600 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-utensils text-white"></i>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-white">{{ $categories->sum(fn($c) => $c->products_count ?? $c->products->count()) }}</p>
                        <p class="text-xs text-slate-400">Total Produk</p>
                    </div>
                </div>
            </div>
            <div class="glass-card rounded-xl p-4 hover:bg-white/5 transition-all">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-gradient-to-br from-amber-500 to-orange-600 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-star text-white"></i>
                    </div>
                    <div>
                        @php
                            $topCategory = $categories->sortByDesc(fn($c) => $c->products_count ?? $c->products->count())->first();
                        @endphp
                        <p class="text-sm font-bold text-white truncate">{{ $topCategory?->nama ?? '-' }}</p>
                        <p class="text-xs text-slate-400">Terpopuler</p>
                    </div>
                </div>
            </div>
            <div class="glass-card rounded-xl p-4 hover:bg-white/5 transition-all">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-cyan-600 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-chart-pie text-white"></i>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-white">{{ $categories->count() > 0 ? round($categories->sum(fn($c) => $c->products_count ?? $c->products->count()) / $categories->count(), 1) : 0 }}</p>
                        <p class="text-xs text-slate-400">Rata-rata/Kategori</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Table Card --}}
        <div class="glass-card rounded-2xl overflow-hidden">
            {{-- Table Header --}}
            <div class="bg-gradient-to-r from-orange-500 to-amber-500 px-6 py-4">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center mr-3">
                        <i class="fas fa-layer-group text-white"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-white">Daftar Kategori</h2>
                        <p class="text-sm text-white/70">{{ $categories->total() }} kategori tersedia</p>
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="bg-slate-800/50">
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-400 uppercase tracking-wider">No</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-400 uppercase tracking-wider">Kategori</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-400 uppercase tracking-wider">Deskripsi</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-slate-400 uppercase tracking-wider">Jumlah Produk</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-slate-400 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-700/50">
                        @forelse($categories as $index => $category)
                            @php
                                $icons = [
                                    'Makanan Berat' => ['icon' => 'fa-drumstick-bite', 'gradient' => 'from-orange-500 to-red-500'],
                                    'Makanan Ringan' => ['icon' => 'fa-cookie-bite', 'gradient' => 'from-green-500 to-emerald-500'],
                                    'Minuman' => ['icon' => 'fa-glass-water', 'gradient' => 'from-blue-500 to-cyan-500'],
                                    'Snack' => ['icon' => 'fa-candy-cane', 'gradient' => 'from-pink-500 to-rose-500'],
                                ];
                                $config = $icons[$category->nama] ?? ['icon' => 'fa-utensils', 'gradient' => 'from-orange-500 to-amber-500'];
                            @endphp
                            <tr class="group hover:bg-white/5 transition-colors duration-200">
                                <td class="px-6 py-5 whitespace-nowrap">
                                    <span class="w-8 h-8 inline-flex items-center justify-center bg-slate-700 rounded-lg text-sm font-bold text-slate-300 group-hover:bg-orange-500/20 group-hover:text-orange-400 transition-colors">
                                        {{ $categories->firstItem() + $index }}
                                    </span>
                                </td>
                                <td class="px-6 py-5 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-12 h-12 bg-gradient-to-br {{ $config['gradient'] }} rounded-xl flex items-center justify-center mr-4 shadow-lg group-hover:scale-110 group-hover:rotate-3 transition-all duration-300">
                                            <i class="fas {{ $config['icon'] }} text-white text-lg"></i>
                                        </div>
                                        <div>
                                            <p class="font-bold text-white group-hover:text-orange-400 transition-colors">{{ $category->nama }}</p>
                                            <p class="text-xs text-slate-500">ID: {{ $category->id }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <p class="text-sm text-slate-400 max-w-xs">
                                        {{ Str::limit($category->deskripsi, 60) ?: '-' }}
                                    </p>
                                </td>
                                <td class="px-6 py-5 whitespace-nowrap text-center">
                                    @php
                                        $productCount = $category->products_count ?? $category->products->count();
                                    @endphp
                                    <span class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-bold {{ $productCount > 0 ? 'bg-gradient-to-r from-orange-500 to-amber-500 text-white shadow-lg shadow-orange-500/20' : 'bg-slate-700 text-slate-400' }}">
                                        <i class="fas fa-box mr-2"></i>
                                        {{ $productCount }} produk
                                    </span>
                                </td>
                                <td class="px-6 py-5 whitespace-nowrap">
                                    <div class="flex items-center justify-center space-x-2">
                                        <a href="{{ route('admin.categories.show', $category) }}" 
                                           class="w-10 h-10 inline-flex items-center justify-center bg-slate-700 hover:bg-blue-500 text-slate-300 hover:text-white rounded-xl transition-all duration-200 hover:scale-110" 
                                           title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.categories.edit', $category) }}" 
                                           class="w-10 h-10 inline-flex items-center justify-center bg-slate-700 hover:bg-amber-500 text-slate-300 hover:text-white rounded-xl transition-all duration-200 hover:scale-110" 
                                           title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.categories.destroy', $category) }}" 
                                              method="POST" 
                                              class="inline"
                                              onsubmit="return confirm('Yakin ingin menghapus kategori {{ $category->nama }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="w-10 h-10 inline-flex items-center justify-center bg-slate-700 hover:bg-red-500 text-slate-300 hover:text-white rounded-xl transition-all duration-200 hover:scale-110" 
                                                    title="Hapus">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center">
                                        <div class="w-24 h-24 bg-slate-800 rounded-full flex items-center justify-center mb-4">
                                            <i class="fas fa-folder-open text-4xl text-slate-600"></i>
                                        </div>
                                        <h3 class="text-xl font-bold text-white mb-2">Belum ada kategori</h3>
                                        <p class="text-slate-400 mb-4">Mulai dengan menambahkan kategori pertama</p>
                                        <a href="{{ route('admin.categories.create') }}" 
                                           class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-orange-500 to-amber-500 text-white font-semibold rounded-xl shadow-lg shadow-orange-500/20 hover:shadow-orange-500/40 transition-all duration-300">
                                            <i class="fas fa-plus mr-2"></i>
                                            Tambah Kategori Pertama
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($categories->hasPages())
                <div class="px-6 py-4 border-t border-slate-700">
                    {{ $categories->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
