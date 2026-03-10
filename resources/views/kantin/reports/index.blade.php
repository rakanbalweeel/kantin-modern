{{--
==========================================================================
KANTIN - LAPORAN KEUANGAN (DARK THEME)
==========================================================================
--}}

@extends('layouts.app')

@section('title', 'Laporan Keuangan - Kantin')

@section('content')
<div class="min-h-screen hero-gradient py-8" id="report-container">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Header --}}
        <div class="mb-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div>
                    <h1 class="text-3xl font-extrabold text-white">
                        Laporan <span class="gradient-text">Keuangan</span>
                    </h1>
                    <p class="mt-1 text-slate-400">Analisis penjualan dan pendapatan kantin</p>
                </div>
                <div class="mt-4 md:mt-0 flex items-center space-x-3">
                    <button onclick="window.print()" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-emerald-500 to-green-600 text-white rounded-xl shadow-lg shadow-emerald-500/20 hover:shadow-emerald-500/40 transition-all print:hidden">
                        <i class="fas fa-print mr-2"></i> Cetak Laporan
                    </button>
                    <a href="{{ route('kantin.dashboard') }}" class="inline-flex items-center px-4 py-2 glass rounded-xl text-slate-300 hover:text-orange-400 hover:bg-white/10 transition-all print:hidden">
                        <i class="fas fa-arrow-left mr-2"></i> Kembali
                    </a>
                </div>
            </div>
        </div>

        {{-- Filter Periode --}}
        <div class="glass-card rounded-2xl p-6 mb-8 print:hidden">
            <form action="{{ route('kantin.reports') }}" method="GET" class="flex flex-wrap items-end gap-4">
                <div class="flex-1 min-w-[200px]">
                    <label class="block text-sm font-medium text-slate-300 mb-2">Tanggal Mulai</label>
                    <input type="date" name="start_date" value="{{ $startDate }}" 
                           class="w-full px-4 py-2.5 rounded-xl bg-slate-800/50 border border-slate-700 text-white focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 transition-all">
                </div>
                <div class="flex-1 min-w-[200px]">
                    <label class="block text-sm font-medium text-slate-300 mb-2">Tanggal Akhir</label>
                    <input type="date" name="end_date" value="{{ $endDate }}" 
                           class="w-full px-4 py-2.5 rounded-xl bg-slate-800/50 border border-slate-700 text-white focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 transition-all">
                </div>
                <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-orange-500 to-amber-500 text-white rounded-xl font-semibold shadow-lg shadow-orange-500/20 hover:shadow-orange-500/40 transition-all">
                    <i class="fas fa-filter mr-2"></i> Filter
                </button>
                <a href="{{ route('kantin.reports') }}" class="px-6 py-2.5 bg-slate-700 text-slate-300 rounded-xl hover:bg-slate-600 transition-all">
                    Reset
                </a>
            </form>
        </div>

        {{-- Summary Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            {{-- Total Pendapatan --}}
            <div class="glass-card rounded-2xl p-6 hover:bg-white/5 transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-emerald-500 to-green-600 rounded-2xl flex items-center justify-center shadow-lg shadow-emerald-500/20">
                        <i class="fas fa-coins text-xl text-white"></i>
                    </div>
                </div>
                <p class="text-sm font-medium text-slate-400 mb-1">Total Pendapatan</p>
                <p class="text-2xl font-extrabold text-emerald-400">
                    Rp {{ number_format($totalSales, 0, ',', '.') }}
                </p>
            </div>

            {{-- Total Transaksi --}}
            <div class="glass-card rounded-2xl p-6 hover:bg-white/5 transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl flex items-center justify-center shadow-lg shadow-blue-500/20">
                        <i class="fas fa-receipt text-xl text-white"></i>
                    </div>
                </div>
                <p class="text-sm font-medium text-slate-400 mb-1">Total Transaksi</p>
                <p class="text-2xl font-extrabold text-blue-400">
                    {{ $totalTransactions }}
                </p>
            </div>

            {{-- Rata-rata per Transaksi --}}
            <div class="glass-card rounded-2xl p-6 hover:bg-white/5 transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-pink-600 rounded-2xl flex items-center justify-center shadow-lg shadow-purple-500/20">
                        <i class="fas fa-chart-line text-xl text-white"></i>
                    </div>
                </div>
                <p class="text-sm font-medium text-slate-400 mb-1">Rata-rata Transaksi</p>
                <p class="text-2xl font-extrabold text-purple-400">
                    Rp {{ number_format($averageTransaction, 0, ',', '.') }}
                </p>
            </div>

            {{-- Pesanan Batal --}}
            <div class="glass-card rounded-2xl p-6 hover:bg-white/5 transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-red-500 to-pink-600 rounded-2xl flex items-center justify-center shadow-lg shadow-red-500/20">
                        <i class="fas fa-times-circle text-xl text-white"></i>
                    </div>
                </div>
                <p class="text-sm font-medium text-slate-400 mb-1">Pesanan Batal</p>
                <p class="text-2xl font-extrabold text-red-400">
                    {{ $canceledOrders }}
                </p>
            </div>
        </div>

        {{-- Detail Breakdown --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="glass-card rounded-2xl p-6">
                <div class="flex items-center mb-4">
                    <div class="w-10 h-10 bg-orange-500/20 rounded-xl flex items-center justify-center mr-3">
                        <i class="fas fa-shopping-basket text-orange-400"></i>
                    </div>
                    <span class="font-bold text-white">Subtotal Penjualan</span>
                </div>
                <p class="text-2xl font-bold text-white">Rp {{ number_format($totalSubtotal, 0, ',', '.') }}</p>
                <p class="text-sm text-slate-500 mt-1">Sebelum pajak</p>
            </div>
            
            <div class="glass-card rounded-2xl p-6">
                <div class="flex items-center mb-4">
                    <div class="w-10 h-10 bg-blue-500/20 rounded-xl flex items-center justify-center mr-3">
                        <i class="fas fa-percentage text-blue-400"></i>
                    </div>
                    <span class="font-bold text-white">Total Pajak</span>
                </div>
                <p class="text-2xl font-bold text-white">Rp {{ number_format($totalPajak, 0, ',', '.') }}</p>
                <p class="text-sm text-slate-500 mt-1">Dari semua transaksi</p>
            </div>
            
            <div class="relative rounded-2xl p-6 overflow-hidden bg-gradient-to-br from-orange-500/20 to-amber-500/20 border border-orange-500/30">
                <div class="flex items-center mb-4">
                    <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center mr-3">
                        <i class="fas fa-wallet text-white"></i>
                    </div>
                    <span class="font-bold text-white">Total Bersih</span>
                </div>
                <p class="text-2xl font-bold text-orange-400">Rp {{ number_format($totalSales, 0, ',', '.') }}</p>
                <p class="text-sm text-orange-300/70 mt-1">Pendapatan akhir</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            {{-- Produk Terlaris --}}
            <div class="glass-card rounded-2xl overflow-hidden">
                <div class="bg-gradient-to-r from-orange-500 to-amber-500 px-6 py-4">
                    <h3 class="font-bold text-white flex items-center">
                        <i class="fas fa-trophy mr-2"></i> Produk Terlaris
                    </h3>
                </div>
                <div class="divide-y divide-slate-700/50">
                    @forelse($topProducts as $index => $product)
                        <div class="p-4 flex items-center justify-between hover:bg-white/5 transition-colors">
                            <div class="flex items-center">
                                <span class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold mr-3
                                    {{ $index === 0 ? 'bg-yellow-500/20 text-yellow-400' : ($index === 1 ? 'bg-slate-500/20 text-slate-300' : ($index === 2 ? 'bg-amber-500/20 text-amber-400' : 'bg-slate-700 text-slate-400')) }}">
                                    {{ $index + 1 }}
                                </span>
                                <div>
                                    <p class="font-semibold text-white">{{ $product->nama }}</p>
                                    <p class="text-sm text-slate-500">{{ $product->total_sold }} terjual</p>
                                </div>
                            </div>
                            <p class="font-bold text-orange-400">Rp {{ number_format($product->total_revenue, 0, ',', '.') }}</p>
                        </div>
                    @empty
                        <div class="p-8 text-center">
                            <div class="w-16 h-16 bg-slate-800 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-chart-bar text-2xl text-slate-600"></i>
                            </div>
                            <p class="text-slate-400">Belum ada data penjualan</p>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- Penjualan per Kategori --}}
            <div class="glass-card rounded-2xl overflow-hidden">
                <div class="bg-gradient-to-r from-blue-500 to-indigo-600 px-6 py-4">
                    <h3 class="font-bold text-white flex items-center">
                        <i class="fas fa-tags mr-2"></i> Penjualan per Kategori
                    </h3>
                </div>
                <div class="divide-y divide-slate-700/50">
                    @forelse($salesByCategory as $category)
                        <div class="p-4 hover:bg-white/5 transition-colors">
                            <div class="flex items-center justify-between mb-2">
                                <span class="font-semibold text-white">{{ $category->category_name }}</span>
                                <span class="font-bold text-blue-400">Rp {{ number_format($category->total_revenue, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex items-center justify-between text-sm text-slate-500">
                                <span>{{ $category->total_sold }} item terjual</span>
                                @if($totalSales > 0)
                                    <span>{{ round(($category->total_revenue / $totalSales) * 100, 1) }}%</span>
                                @endif
                            </div>
                            @if($totalSales > 0)
                                <div class="mt-2 bg-slate-700 rounded-full h-2 overflow-hidden">
                                    <div class="bg-gradient-to-r from-blue-500 to-indigo-600 h-full rounded-full" 
                                         style="width: {{ ($category->total_revenue / $totalSales) * 100 }}%"></div>
                                </div>
                            @endif
                        </div>
                    @empty
                        <div class="p-8 text-center">
                            <div class="w-16 h-16 bg-slate-800 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-folder-open text-2xl text-slate-600"></i>
                            </div>
                            <p class="text-slate-400">Belum ada data kategori</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Penjualan Harian --}}
        <div class="glass-card rounded-2xl overflow-hidden">
            <div class="bg-gradient-to-r from-emerald-500 to-green-600 px-6 py-4">
                <h3 class="font-bold text-white flex items-center">
                    <i class="fas fa-calendar-alt mr-2"></i> Penjualan Harian
                </h3>
            </div>
            <div class="p-6">
                @if($dailySales->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b border-slate-700">
                                    <th class="text-left py-3 px-4 font-semibold text-slate-300">Tanggal</th>
                                    <th class="text-right py-3 px-4 font-semibold text-slate-300">Transaksi</th>
                                    <th class="text-right py-3 px-4 font-semibold text-slate-300">Pendapatan</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-700/50">
                                @foreach($dailySales as $day)
                                    <tr class="hover:bg-white/5 transition-colors">
                                        <td class="py-3 px-4 text-slate-300">
                                            {{ \Carbon\Carbon::parse($day->date)->locale('id')->isoFormat('dddd, D MMM Y') }}
                                        </td>
                                        <td class="py-3 px-4 text-right">
                                            <span class="px-3 py-1 bg-blue-500/20 text-blue-400 rounded-full text-sm font-medium">
                                                {{ $day->count }} transaksi
                                            </span>
                                        </td>
                                        <td class="py-3 px-4 text-right font-bold text-emerald-400">
                                            Rp {{ number_format($day->total, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="bg-emerald-500/10 font-bold border-t border-slate-700">
                                    <td class="py-3 px-4 text-white">Total</td>
                                    <td class="py-3 px-4 text-right text-slate-300">{{ $dailySales->sum('count') }} transaksi</td>
                                    <td class="py-3 px-4 text-right text-emerald-400">Rp {{ number_format($dailySales->sum('total'), 0, ',', '.') }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                @else
                    <div class="text-center py-12">
                        <div class="w-16 h-16 bg-slate-800 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-chart-area text-2xl text-slate-600"></i>
                        </div>
                        <p class="text-slate-400">Belum ada data penjualan untuk periode ini</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
