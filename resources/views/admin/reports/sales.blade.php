{{--
==========================================================================
LAPORAN PENJUALAN - ADMIN
==========================================================================
Halaman ini menampilkan laporan penjualan dengan filter tanggal.
Menampilkan:
- Total pendapatan
- Total pesanan
- Total item terjual
- Grafik penjualan harian
- Produk terlaris
==========================================================================
--}}

@extends('layouts.app')

@section('title', 'Laporan Penjualan')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Header --}}
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Laporan Penjualan</h1>
            <p class="mt-1 text-gray-600">Analisis penjualan kantin sekolah</p>
        </div>

        {{-- Date Filter --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 mb-6">
            <form action="{{ route('admin.reports.sales') }}" method="GET" class="flex flex-wrap gap-4 items-end">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Dari Tanggal</label>
                    <input type="date" name="start_date" value="{{ $startDate ?? '' }}"
                           class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Sampai Tanggal</label>
                    <input type="date" name="end_date" value="{{ $endDate ?? '' }}"
                           class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                </div>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                    Filter
                </button>
                <a href="{{ route('admin.reports.sales') }}" class="px-4 py-2 text-gray-500 hover:text-gray-700">
                    Reset
                </a>
            </form>
        </div>

        {{-- Summary Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Pendapatan</p>
                        <p class="text-2xl font-bold text-gray-900 mt-1">
                            Rp {{ number_format($totalRevenue ?? 0, 0, ',', '.') }}
                        </p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                        <span class="text-2xl">💰</span>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Pesanan</p>
                        <p class="text-2xl font-bold text-gray-900 mt-1">{{ $totalOrders ?? 0 }}</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                        <span class="text-2xl">📋</span>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Item Terjual</p>
                        <p class="text-2xl font-bold text-gray-900 mt-1">{{ $totalItemsSold ?? 0 }}</p>
                    </div>
                    <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                        <span class="text-2xl">🛒</span>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Rata-rata Pesanan</p>
                        <p class="text-2xl font-bold text-gray-900 mt-1">
                            Rp {{ number_format($averageOrderValue ?? 0, 0, ',', '.') }}
                        </p>
                    </div>
                    <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center">
                        <span class="text-2xl">📊</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            {{-- Daily Sales --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-lg font-bold text-gray-900">Penjualan Harian</h2>
                </div>
                <div class="p-6">
                    @if(isset($dailySales) && count($dailySales) > 0)
                        <div class="space-y-4">
                            @foreach($dailySales as $sale)
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="font-medium text-gray-900">{{ \Carbon\Carbon::parse($sale->date)->format('d M Y') }}</p>
                                        <p class="text-sm text-gray-500">{{ $sale->total_orders }} pesanan</p>
                                    </div>
                                    <p class="font-semibold text-indigo-600">
                                        Rp {{ number_format($sale->total_revenue, 0, ',', '.') }}
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center text-gray-500 py-8">
                            <span class="text-4xl">📊</span>
                            <p class="mt-2">Belum ada data penjualan</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Top Products --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-lg font-bold text-gray-900">Produk Terlaris</h2>
                </div>
                <div class="p-6">
                    @if(isset($topProducts) && count($topProducts) > 0)
                        <div class="space-y-4">
                            @foreach($topProducts as $index => $product)
                                <div class="flex items-center">
                                    <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-white
                                        {{ $index === 0 ? 'bg-yellow-500' : ($index === 1 ? 'bg-gray-400' : ($index === 2 ? 'bg-amber-600' : 'bg-gray-300')) }}">
                                        {{ $index + 1 }}
                                    </div>
                                    <div class="ml-4 flex-1">
                                        <p class="font-medium text-gray-900">{{ $product->nama }}</p>
                                        <p class="text-sm text-gray-500">{{ $product->total_sold }} terjual</p>
                                    </div>
                                    <p class="font-semibold text-gray-900">
                                        Rp {{ number_format($product->total_revenue, 0, ',', '.') }}
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center text-gray-500 py-8">
                            <span class="text-4xl">🍽️</span>
                            <p class="mt-2">Belum ada data produk terlaris</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Category Sales --}}
        <div class="mt-8 bg-white rounded-xl shadow-sm border border-gray-100">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-lg font-bold text-gray-900">Penjualan per Kategori</h2>
            </div>
            <div class="p-6">
                @if(isset($categorySales) && count($categorySales) > 0)
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        @foreach($categorySales as $category)
                            <div class="border border-gray-200 rounded-lg p-4">
                                <h3 class="font-medium text-gray-900 mb-2">{{ $category->nama }}</h3>
                                <div class="space-y-2">
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-500">Total Terjual</span>
                                        <span class="font-medium">{{ $category->total_sold }}</span>
                                    </div>
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-500">Pendapatan</span>
                                        <span class="font-medium text-indigo-600">Rp {{ number_format($category->total_revenue, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center text-gray-500 py-8">
                        <span class="text-4xl">📁</span>
                        <p class="mt-2">Belum ada data penjualan per kategori</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
