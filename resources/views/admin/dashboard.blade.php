{{--
==========================================================================
ADMIN DASHBOARD
==========================================================================
Halaman utama admin yang menampilkan ringkasan:
- Total Pendapatan
- Pesanan Hari Ini
- Total Produk
- Total Siswa
- Pesanan Terbaru
- Produk Stok Menipis

PENJELASAN DATA
---------------
$stats['total_pendapatan']: Sum dari total semua order yang selesai
$stats['pesanan_hari_ini']: Jumlah pesanan hari ini
$stats['total_produk']: Jumlah semua produk
$stats['total_siswa']: Jumlah user dengan role siswa
$stats['pesanan_pending']: Jumlah pesanan pending
$recentOrders: 5 pesanan terbaru
$lowStockProducts: Produk dengan stok menipis (< 10)
==========================================================================
--}}

@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Header --}}
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Dashboard</h1>
            <p class="mt-1 text-gray-600">Selamat datang kembali, {{ auth()->user()->name }}!</p>
        </div>

        {{-- Statistik Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            {{-- Total Pendapatan --}}
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Pendapatan</p>
                        <p class="text-2xl font-bold text-gray-900 mt-1">
                            Rp {{ number_format($stats['total_pendapatan'] ?? 0, 0, ',', '.') }}
                        </p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                        <span class="text-2xl">💰</span>
                    </div>
                </div>
            </div>

            {{-- Pesanan Hari Ini --}}
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Pesanan Hari Ini</p>
                        <p class="text-2xl font-bold text-gray-900 mt-1">{{ $stats['pesanan_hari_ini'] ?? 0 }}</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                        <span class="text-2xl">📋</span>
                    </div>
                </div>
            </div>

            {{-- Total Produk --}}
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Produk</p>
                        <p class="text-2xl font-bold text-gray-900 mt-1">{{ $stats['total_produk'] ?? 0 }}</p>
                    </div>
                    <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                        <span class="text-2xl">🍽️</span>
                    </div>
                </div>
            </div>

            {{-- Total Siswa --}}
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Siswa</p>
                        <p class="text-2xl font-bold text-gray-900 mt-1">{{ $stats['total_siswa'] ?? 0 }}</p>
                    </div>
                    <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center">
                        <span class="text-2xl">👨‍🎓</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            {{-- Pesanan Terbaru --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                <div class="p-6 border-b border-gray-100">
                    <div class="flex items-center justify-between">
                        <h2 class="text-lg font-bold text-gray-900">Pesanan Terbaru</h2>
                        <a href="{{ route('admin.orders.index') }}" class="text-sm text-indigo-600 hover:text-indigo-700">
                            Lihat Semua →
                        </a>
                    </div>
                </div>
                <div class="divide-y divide-gray-100">
                    @forelse($recentOrders as $order)
                        <div class="p-4 hover:bg-gray-50">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="font-medium text-gray-900">{{ $order->kode_pesanan }}</p>
                                    <p class="text-sm text-gray-500">{{ $order->user->name }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="font-semibold text-gray-900">
                                        Rp {{ number_format($order->total, 0, ',', '.') }}
                                    </p>
                                    @php
                                        $statusColors = [
                                            'pending' => 'bg-yellow-100 text-yellow-800',
                                            'diproses' => 'bg-blue-100 text-blue-800',
                                            'selesai' => 'bg-green-100 text-green-800',
                                            'batal' => 'bg-red-100 text-red-800',
                                        ];
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusColors[$order->status] ?? 'bg-gray-100 text-gray-800' }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="p-8 text-center text-gray-500">
                            Belum ada pesanan
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- Produk Stok Menipis --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                <div class="p-6 border-b border-gray-100">
                    <h2 class="text-lg font-bold text-gray-900">Stok Menipis</h2>
                </div>
                <div class="divide-y divide-gray-100">
                    @forelse($lowStockProducts as $index => $product)
                        <div class="p-4 hover:bg-gray-50">
                            <div class="flex items-center">
                                <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-white
                                    {{ $product->stok < 5 ? 'bg-red-500' : 'bg-yellow-500' }}">
                                    {{ $product->stok }}
                                </div>
                                <div class="ml-4 flex-1">
                                    <p class="font-medium text-gray-900">{{ $product->nama }}</p>
                                    <p class="text-sm text-gray-500">{{ $product->category->nama ?? '-' }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm {{ $product->stok < 5 ? 'text-red-600 font-semibold' : 'text-yellow-600' }}">
                                        Sisa {{ $product->stok }} pcs
                                    </p>
                                    <p class="text-sm text-gray-500">Rp {{ number_format($product->harga, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="p-8 text-center text-gray-500">
                            <span class="text-3xl">✅</span>
                            <p class="mt-2">Semua stok aman!</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Quick Actions --}}
        <div class="mt-8 bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-bold text-gray-900 mb-4">Aksi Cepat</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <a href="{{ route('admin.products.create') }}" class="flex items-center p-4 bg-indigo-50 rounded-lg hover:bg-indigo-100 transition">
                    <span class="text-2xl mr-3">➕</span>
                    <span class="font-medium text-indigo-700">Tambah Produk</span>
                </a>
                <a href="{{ route('admin.categories.create') }}" class="flex items-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition">
                    <span class="text-2xl mr-3">📁</span>
                    <span class="font-medium text-green-700">Tambah Kategori</span>
                </a>
                <a href="{{ route('admin.orders.index') }}" class="flex items-center p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition">
                    <span class="text-2xl mr-3">📋</span>
                    <span class="font-medium text-blue-700">Kelola Pesanan</span>
                </a>
                <a href="{{ route('admin.reports.sales') }}" class="flex items-center p-4 bg-purple-50 rounded-lg hover:bg-purple-100 transition">
                    <span class="text-2xl mr-3">📊</span>
                    <span class="font-medium text-purple-700">Laporan Penjualan</span>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
