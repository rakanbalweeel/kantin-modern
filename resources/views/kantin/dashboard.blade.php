{{--
==========================================================================
KANTIN DASHBOARD - DARK THEME
==========================================================================
--}}

@extends('layouts.app')

@section('title', 'Dashboard Kantin')

@section('content')
<div class="min-h-screen hero-gradient py-8" x-data="{ refreshing: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Success Message --}}
        @if(session('success'))
            <div class="mb-6 glass-card border-l-4 border-emerald-500 text-emerald-400 px-6 py-4 rounded-2xl flex items-center" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)">
                <div class="w-10 h-10 bg-emerald-500/20 rounded-xl flex items-center justify-center mr-4">
                    <i class="fas fa-check-circle text-emerald-400 text-xl"></i>
                </div>
                <span class="font-medium flex-1">{{ session('success') }}</span>
                <button @click="show = false" class="text-emerald-400 hover:text-emerald-300">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        @endif

        {{-- Error Message --}}
        @if(session('error'))
            <div class="mb-6 glass-card border-l-4 border-red-500 text-red-400 px-6 py-4 rounded-2xl flex items-center" x-data="{ show: true }" x-show="show">
                <div class="w-10 h-10 bg-red-500/20 rounded-xl flex items-center justify-center mr-4">
                    <i class="fas fa-exclamation-circle text-red-400 text-xl"></i>
                </div>
                <span class="font-medium flex-1">{{ session('error') }}</span>
                <button @click="show = false" class="text-red-400 hover:text-red-300">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        @endif

        {{-- Header --}}
        <div class="mb-10">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <h1 class="text-4xl font-extrabold text-white">
                        Dashboard <span class="gradient-text">Kantin</span>
                    </h1>
                    <p class="mt-2 text-slate-400 text-lg">Selamat datang, <span class="font-semibold text-white">{{ auth()->user()->name }}</span>! 👨‍🍳</p>
                </div>
                <div class="mt-4 lg:mt-0 flex items-center space-x-3">
                    <button @click="refreshing = true; window.location.reload()" 
                            class="px-4 py-2 glass rounded-xl text-slate-300 hover:text-orange-400 transition-all"
                            :class="{ 'animate-spin': refreshing }">
                        <i class="fas fa-sync-alt mr-2"></i>
                        Refresh
                    </button>
                    <div class="px-4 py-2 glass rounded-xl text-sm text-slate-300">
                        <i class="fas fa-calendar-alt mr-2 text-orange-400"></i>
                        {{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM Y') }}
                    </div>
                </div>
            </div>
        </div>

        {{-- Statistik Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
            {{-- Pesanan Pending --}}
            <div class="glass-card rounded-2xl p-6 hover:bg-white/5 transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-yellow-500 to-amber-500 rounded-2xl flex items-center justify-center shadow-lg shadow-yellow-500/20">
                        <i class="fas fa-clock text-xl text-white"></i>
                    </div>
                    <span class="px-2 py-1 bg-yellow-500/20 text-yellow-400 rounded-lg text-xs font-medium animate-pulse">
                        <i class="fas fa-bell mr-1"></i>Baru
                    </span>
                </div>
                <p class="text-sm font-medium text-slate-400 mb-1">Menunggu</p>
                <p class="text-3xl font-extrabold text-yellow-400">{{ $stats['pending'] ?? 0 }}</p>
            </div>

            {{-- Diproses --}}
            <div class="glass-card rounded-2xl p-6 hover:bg-white/5 transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl flex items-center justify-center shadow-lg shadow-blue-500/20">
                        <i class="fas fa-spinner fa-spin text-xl text-white"></i>
                    </div>
                </div>
                <p class="text-sm font-medium text-slate-400 mb-1">Diproses</p>
                <p class="text-3xl font-extrabold text-blue-400">{{ $stats['diproses'] ?? 0 }}</p>
            </div>

            {{-- Selesai Hari Ini --}}
            <div class="glass-card rounded-2xl p-6 hover:bg-white/5 transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-emerald-500 to-green-600 rounded-2xl flex items-center justify-center shadow-lg shadow-emerald-500/20">
                        <i class="fas fa-check-circle text-xl text-white"></i>
                    </div>
                </div>
                <p class="text-sm font-medium text-slate-400 mb-1">Selesai Hari Ini</p>
                <p class="text-3xl font-extrabold text-emerald-400">{{ $stats['selesai_hari_ini'] ?? 0 }}</p>
            </div>

            {{-- Pendapatan Hari Ini --}}
            <div class="glass-card rounded-2xl p-6 hover:bg-white/5 transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-orange-500 to-amber-500 rounded-2xl flex items-center justify-center shadow-lg shadow-orange-500/20">
                        <i class="fas fa-coins text-xl text-white"></i>
                    </div>
                </div>
                <p class="text-sm font-medium text-slate-400 mb-1">Pendapatan Hari Ini</p>
                <p class="text-2xl font-extrabold text-orange-400">Rp {{ number_format($stats['pendapatan_hari_ini'] ?? 0, 0, ',', '.') }}</p>
            </div>
        </div>

        {{-- Quick Actions --}}
        <div class="glass-card rounded-2xl p-6 mb-10">
            <h3 class="font-bold text-white mb-4 flex items-center">
                <div class="w-8 h-8 bg-gradient-to-br from-orange-500 to-amber-500 rounded-lg flex items-center justify-center mr-3">
                    <i class="fas fa-bolt text-white text-sm"></i>
                </div>
                Menu Cepat
            </h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <a href="{{ route('kantin.orders.index') }}" class="glass rounded-xl p-4 text-center hover:bg-white/10 transition-all group">
                    <div class="w-12 h-12 mx-auto bg-blue-500/20 rounded-xl flex items-center justify-center mb-3 group-hover:bg-blue-500/30 transition-colors">
                        <i class="fas fa-list text-blue-400 text-xl"></i>
                    </div>
                    <p class="text-sm font-medium text-slate-300">Semua Pesanan</p>
                </a>
                <a href="{{ route('kantin.reports') }}" class="glass rounded-xl p-4 text-center hover:bg-white/10 transition-all group">
                    <div class="w-12 h-12 mx-auto bg-emerald-500/20 rounded-xl flex items-center justify-center mb-3 group-hover:bg-emerald-500/30 transition-colors">
                        <i class="fas fa-chart-bar text-emerald-400 text-xl"></i>
                    </div>
                    <p class="text-sm font-medium text-slate-300">Laporan</p>
                </a>
                <a href="{{ route('kantin.withdrawals.index') }}" class="glass rounded-xl p-4 text-center hover:bg-white/10 transition-all group">
                    <div class="w-12 h-12 mx-auto bg-purple-500/20 rounded-xl flex items-center justify-center mb-3 group-hover:bg-purple-500/30 transition-colors">
                        <i class="fas fa-money-bill-wave text-purple-400 text-xl"></i>
                    </div>
                    <p class="text-sm font-medium text-slate-300">Tarik Saldo</p>
                </a>
                <a href="#pending-orders" class="glass rounded-xl p-4 text-center hover:bg-white/10 transition-all group">
                    <div class="w-12 h-12 mx-auto bg-yellow-500/20 rounded-xl flex items-center justify-center mb-3 group-hover:bg-yellow-500/30 transition-colors">
                        <i class="fas fa-clock text-yellow-400 text-xl"></i>
                    </div>
                    <p class="text-sm font-medium text-slate-300">Pesanan Pending</p>
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            {{-- Pesanan Pending --}}
            <div id="pending-orders" class="glass-card rounded-2xl overflow-hidden">
                <div class="bg-gradient-to-r from-yellow-500 to-amber-500 px-6 py-4 flex items-center justify-between">
                    <h3 class="font-bold text-white flex items-center">
                        <i class="fas fa-clock mr-2"></i> Menunggu Konfirmasi
                    </h3>
                    @if(isset($pendingOrders) && $pendingOrders->count() > 0)
                        <span class="px-3 py-1 bg-white/20 text-white rounded-full text-sm font-bold">
                            {{ $pendingOrders->count() }}
                        </span>
                    @endif
                </div>
                <div class="divide-y divide-slate-700/50 max-h-96 overflow-y-auto">
                    @forelse($pendingOrders ?? [] as $order)
                        <div class="p-4 hover:bg-white/5 transition-colors">
                            <div class="flex items-center justify-between mb-3">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-yellow-500/20 rounded-xl flex items-center justify-center mr-3">
                                        <i class="fas fa-receipt text-yellow-400"></i>
                                    </div>
                                    <div>
                                        <p class="font-bold text-white">{{ $order->kode_pesanan }}</p>
                                        <p class="text-sm text-slate-500">{{ $order->user->name ?? 'Unknown' }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="font-bold text-orange-400">Rp {{ number_format($order->total, 0, ',', '.') }}</p>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium mt-1
                                        {{ $order->waktu_pengambilan === 'istirahat_1' ? 'bg-blue-500/20 text-blue-400' : 'bg-purple-500/20 text-purple-400' }}">
                                        <i class="fas fa-clock mr-1"></i>
                                        {{ $order->waktu_pengambilan === 'istirahat_1' ? 'Ist. 1' : 'Ist. 2' }}
                                    </span>
                                </div>
                            </div>
                            <div class="flex items-center justify-between">
                                <p class="text-xs text-slate-500">
                                    <i class="fas fa-clock mr-1"></i>
                                    {{ $order->created_at->diffForHumans() }}
                                </p>
                                <div class="flex space-x-2">
                                    <form action="{{ route('kantin.orders.process', $order->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="px-3 py-1.5 bg-blue-500/20 text-blue-400 rounded-lg text-sm hover:bg-blue-500/30 transition-all">
                                            <i class="fas fa-play mr-1"></i> Proses
                                        </button>
                                    </form>
                                    <a href="{{ route('kantin.orders.show', $order->id) }}" class="px-3 py-1.5 bg-slate-700 text-slate-300 rounded-lg text-sm hover:bg-slate-600 transition-all">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="p-8 text-center">
                            <div class="w-16 h-16 bg-slate-800 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-inbox text-2xl text-slate-600"></i>
                            </div>
                            <p class="text-slate-400">Tidak ada pesanan pending</p>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- Pesanan Diproses --}}
            <div class="glass-card rounded-2xl overflow-hidden">
                <div class="bg-gradient-to-r from-blue-500 to-indigo-600 px-6 py-4 flex items-center justify-between">
                    <h3 class="font-bold text-white flex items-center">
                        <i class="fas fa-spinner fa-spin mr-2"></i> Sedang Diproses
                    </h3>
                    @if(isset($processingOrders) && $processingOrders->count() > 0)
                        <span class="px-3 py-1 bg-white/20 text-white rounded-full text-sm font-bold">
                            {{ $processingOrders->count() }}
                        </span>
                    @endif
                </div>
                <div class="divide-y divide-slate-700/50 max-h-96 overflow-y-auto">
                    @forelse($processingOrders ?? [] as $order)
                        <div class="p-4 hover:bg-white/5 transition-colors">
                            <div class="flex items-center justify-between mb-3">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-blue-500/20 rounded-xl flex items-center justify-center mr-3">
                                        <i class="fas fa-utensils text-blue-400"></i>
                                    </div>
                                    <div>
                                        <p class="font-bold text-white">{{ $order->kode_pesanan }}</p>
                                        <p class="text-sm text-slate-500">{{ $order->user->name ?? 'Unknown' }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="font-bold text-orange-400">Rp {{ number_format($order->total, 0, ',', '.') }}</p>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium mt-1
                                        {{ $order->waktu_pengambilan === 'istirahat_1' ? 'bg-blue-500/20 text-blue-400' : 'bg-purple-500/20 text-purple-400' }}">
                                        <i class="fas fa-clock mr-1"></i>
                                        {{ $order->waktu_pengambilan === 'istirahat_1' ? 'Ist. 1' : 'Ist. 2' }}
                                    </span>
                                </div>
                            </div>
                            <div class="flex items-center justify-between">
                                <p class="text-xs text-slate-500">
                                    <i class="fas fa-clock mr-1"></i>
                                    {{ $order->created_at->diffForHumans() }}
                                </p>
                                <div class="flex space-x-2">
                                    <form action="{{ route('kantin.orders.complete', $order->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="px-3 py-1.5 bg-emerald-500/20 text-emerald-400 rounded-lg text-sm hover:bg-emerald-500/30 transition-all">
                                            <i class="fas fa-check mr-1"></i> Selesai
                                        </button>
                                    </form>
                                    <a href="{{ route('kantin.orders.show', $order->id) }}" class="px-3 py-1.5 bg-slate-700 text-slate-300 rounded-lg text-sm hover:bg-slate-600 transition-all">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="p-8 text-center">
                            <div class="w-16 h-16 bg-slate-800 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-inbox text-2xl text-slate-600"></i>
                            </div>
                            <p class="text-slate-400">Tidak ada pesanan diproses</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
