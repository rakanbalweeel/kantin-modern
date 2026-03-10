{{--
==========================================================================
DAFTAR PESANAN (INDEX) - ADMIN - DARK THEME
==========================================================================
--}}

@extends('layouts.app')

@section('title', 'Kelola Pesanan')

@section('content')
@php
    $statusConfig = [
        'pending' => ['icon' => 'fa-clock', 'bg' => 'bg-yellow-500/20', 'text' => 'text-yellow-400', 'border' => 'border-yellow-500/30'],
        'diproses' => ['icon' => 'fa-spinner', 'bg' => 'bg-blue-500/20', 'text' => 'text-blue-400', 'border' => 'border-blue-500/30'],
        'selesai' => ['icon' => 'fa-check-circle', 'bg' => 'bg-emerald-500/20', 'text' => 'text-emerald-400', 'border' => 'border-emerald-500/30'],
        'batal' => ['icon' => 'fa-times-circle', 'bg' => 'bg-red-500/20', 'text' => 'text-red-400', 'border' => 'border-red-500/30'],
    ];
@endphp

<div class="min-h-screen hero-gradient py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Header Section --}}
        <div class="mb-8">
            <div class="flex items-center">
                <div class="w-14 h-14 bg-gradient-to-br from-orange-500 to-amber-500 rounded-2xl flex items-center justify-center shadow-lg shadow-orange-500/20 mr-4">
                    <i class="fas fa-clipboard-list text-white text-xl"></i>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-white">Kelola <span class="gradient-text">Pesanan</span></h1>
                    <p class="text-slate-400 mt-1">Daftar semua pesanan dari siswa</p>
                </div>
            </div>
        </div>

        {{-- Stats Cards --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
            @foreach(['pending' => 'Pending', 'diproses' => 'Diproses', 'selesai' => 'Selesai', 'batal' => 'Dibatalkan'] as $key => $label)
                @php $config = $statusConfig[$key]; @endphp
                <div class="glass-card rounded-2xl p-5 hover:bg-white/5 transition-all duration-300 group">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm {{ $config['text'] }} font-medium mb-1">{{ $label }}</p>
                            <p class="text-3xl font-bold text-white">{{ $stats[$key] ?? 0 }}</p>
                        </div>
                        <div class="w-14 h-14 bg-gradient-to-br from-orange-500 to-amber-500 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                            <i class="fas {{ $config['icon'] }} text-white text-xl {{ $key === 'diproses' ? 'animate-spin' : '' }}"></i>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Filters --}}
        <div class="glass-card rounded-2xl p-6 mb-6">
            <form action="{{ route('admin.orders.index') }}" method="GET" class="flex flex-wrap gap-4 items-end">
                <div class="flex-1 min-w-[250px]">
                    <label class="text-sm font-medium text-slate-300 mb-2 block">Cari Pesanan</label>
                    <div class="relative">
                        <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-500"></i>
                        <input type="text" name="search" value="{{ request('search') }}" 
                               placeholder="Kode pesanan atau nama siswa..."
                               class="w-full pl-11 pr-4 py-3 bg-slate-800/50 border border-slate-700 rounded-xl text-white placeholder-slate-500 focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 transition-all">
                    </div>
                </div>
                <div class="w-48">
                    <label class="text-sm font-medium text-slate-300 mb-2 block">Status</label>
                    <select name="status" class="w-full px-4 py-3 bg-slate-800/50 border border-slate-700 rounded-xl text-white focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 transition-all">
                        <option value="" class="bg-slate-800">Semua Status</option>
                        <option value="pending" class="bg-slate-800" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="diproses" class="bg-slate-800" {{ request('status') == 'diproses' ? 'selected' : '' }}>Diproses</option>
                        <option value="selesai" class="bg-slate-800" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        <option value="batal" class="bg-slate-800" {{ request('status') == 'batal' ? 'selected' : '' }}>Dibatalkan</option>
                    </select>
                </div>
                <div class="w-48">
                    <label class="text-sm font-medium text-slate-300 mb-2 block">Tanggal</label>
                    <input type="date" name="date" value="{{ request('date') }}"
                           class="w-full px-4 py-3 bg-slate-800/50 border border-slate-700 rounded-xl text-white focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 transition-all">
                </div>
                <button type="submit" class="px-6 py-3 bg-gradient-to-r from-orange-500 to-amber-500 text-white font-semibold rounded-xl shadow-lg shadow-orange-500/20 hover:shadow-orange-500/40 transition-all flex items-center">
                    <i class="fas fa-search mr-2"></i> Cari
                </button>
            </form>
        </div>

        {{-- Orders Table --}}
        <div class="glass-card rounded-2xl overflow-hidden">
            <div class="bg-gradient-to-r from-orange-500 to-amber-500 px-6 py-4">
                <h2 class="text-lg font-bold text-white flex items-center">
                    <i class="fas fa-list mr-2"></i> Daftar Pesanan
                </h2>
            </div>
            
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="bg-slate-800/50">
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-400 uppercase">Kode Pesanan</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-400 uppercase">Pembeli</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-400 uppercase">Total</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-slate-400 uppercase">Status</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-400 uppercase">Waktu</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-slate-400 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-700/50">
                        @forelse($orders as $order)
                            @php $config = $statusConfig[$order->status] ?? $statusConfig['pending']; @endphp
                            <tr class="hover:bg-white/5 transition-colors">
                                <td class="px-6 py-4">
                                    <span class="font-bold text-white font-mono">{{ $order->kode_pesanan }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-gradient-to-br from-orange-500 to-amber-500 rounded-xl flex items-center justify-center mr-3">
                                            <span class="text-white font-bold text-sm">{{ strtoupper(substr($order->user->name ?? 'U', 0, 1)) }}</span>
                                        </div>
                                        <div>
                                            <p class="font-medium text-white">{{ $order->user->name ?? 'User' }}</p>
                                            <p class="text-xs text-slate-500">{{ $order->user->email ?? '' }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="font-bold text-orange-400">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $config['bg'] }} {{ $config['text'] }} border {{ $config['border'] }}">
                                        <i class="fas {{ $config['icon'] }} mr-1"></i>
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-slate-300">{{ $order->created_at->format('d/m/Y') }}</div>
                                    <div class="text-xs text-slate-500">{{ $order->created_at->format('H:i') }}</div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <a href="{{ route('admin.orders.show', $order) }}" class="px-4 py-2 bg-slate-700 text-slate-300 rounded-xl hover:bg-orange-500/20 hover:text-orange-400 transition-all inline-flex items-center">
                                        <i class="fas fa-eye mr-2"></i> Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <div class="w-16 h-16 bg-slate-800 rounded-full flex items-center justify-center mx-auto mb-4">
                                        <i class="fas fa-inbox text-2xl text-slate-600"></i>
                                    </div>
                                    <p class="text-slate-400 font-medium">Tidak ada pesanan ditemukan</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($orders->hasPages())
                <div class="px-6 py-4 border-t border-slate-700">
                    {{ $orders->withQueryString()->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
