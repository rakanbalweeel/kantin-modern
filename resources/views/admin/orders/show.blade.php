{{--
==========================================================================
DETAIL PESANAN (SHOW) - ADMIN - DARK THEME
==========================================================================
--}}

@extends('layouts.app')

@section('title', 'Detail Pesanan')

@section('content')
@php
    $statusConfig = [
        'pending' => ['bg' => 'bg-yellow-500/20', 'text' => 'text-yellow-400', 'border' => 'border-yellow-500/30'],
        'diproses' => ['bg' => 'bg-blue-500/20', 'text' => 'text-blue-400', 'border' => 'border-blue-500/30'],
        'selesai' => ['bg' => 'bg-emerald-500/20', 'text' => 'text-emerald-400', 'border' => 'border-emerald-500/30'],
        'batal' => ['bg' => 'bg-red-500/20', 'text' => 'text-red-400', 'border' => 'border-red-500/30'],
    ];
    $config = $statusConfig[$order->status] ?? $statusConfig['pending'];
@endphp

<div class="min-h-screen hero-gradient py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Header --}}
        <div class="mb-6">
            <a href="{{ route('admin.orders.index') }}" class="group inline-flex items-center text-slate-400 hover:text-orange-400 transition-all">
                <span class="flex items-center justify-center w-10 h-10 rounded-xl glass mr-3 group-hover:-translate-x-1 transition-all">
                    <i class="fas fa-arrow-left"></i>
                </span>
                <span class="font-medium">Kembali</span>
            </a>
            <div class="mt-4 flex flex-col md:flex-row md:items-center md:justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-white">Detail <span class="gradient-text">Pesanan</span></h1>
                    <p class="mt-1 text-slate-400 font-mono">{{ $order->kode_pesanan }}</p>
                </div>
                <span class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-bold {{ $config['bg'] }} {{ $config['text'] }} border {{ $config['border'] }} mt-4 md:mt-0">
                    <i class="fas fa-circle text-xs mr-2"></i>
                    {{ ucfirst($order->status) }}
                </span>
            </div>
        </div>

        {{-- Info Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            {{-- Info Pembeli --}}
            <div class="glass-card rounded-2xl p-6">
                <h3 class="font-bold text-white mb-4 flex items-center">
                    <div class="w-8 h-8 bg-blue-500/20 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-user text-blue-400"></i>
                    </div>
                    Informasi Pembeli
                </h3>
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-gradient-to-br from-orange-500 to-amber-500 rounded-xl flex items-center justify-center mr-4">
                        <span class="text-white font-bold text-lg">{{ strtoupper(substr($order->user->name ?? 'U', 0, 1)) }}</span>
                    </div>
                    <div>
                        <p class="font-semibold text-white">{{ $order->user->name ?? 'User' }}</p>
                        <p class="text-sm text-slate-400">{{ $order->user->email ?? '' }}</p>
                    </div>
                </div>
            </div>

            {{-- Info Waktu --}}
            <div class="glass-card rounded-2xl p-6">
                <h3 class="font-bold text-white mb-4 flex items-center">
                    <div class="w-8 h-8 bg-purple-500/20 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-clock text-purple-400"></i>
                    </div>
                    Informasi Waktu
                </h3>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-slate-400">Tanggal Pesan</span>
                        <span class="text-white">{{ $order->created_at->locale('id')->isoFormat('D MMM Y, HH:mm') }}</span>
                    </div>
                    @if($order->updated_at != $order->created_at)
                        <div class="flex justify-between">
                            <span class="text-slate-400">Terakhir Update</span>
                            <span class="text-white">{{ $order->updated_at->locale('id')->isoFormat('D MMM Y, HH:mm') }}</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Order Items --}}
        <div class="glass-card rounded-2xl overflow-hidden mb-8">
            <div class="bg-gradient-to-r from-orange-500 to-amber-500 px-6 py-4">
                <h3 class="font-bold text-white flex items-center">
                    <i class="fas fa-shopping-basket mr-2"></i> Detail Pesanan
                </h3>
            </div>
            <div class="divide-y divide-slate-700/50">
                @foreach($order->orderDetails as $detail)
                    <div class="p-6 flex items-center justify-between hover:bg-white/5 transition-colors">
                        <div class="flex items-center">
                            @if($detail->product && $detail->product->gambar)
                                <img src="{{ asset('storage/' . $detail->product->gambar) }}" alt="{{ $detail->product->nama }}" class="w-16 h-16 rounded-xl object-cover mr-4 border border-slate-700">
                            @else
                                <div class="w-16 h-16 bg-slate-800 rounded-xl flex items-center justify-center mr-4">
                                    <i class="fas fa-utensils text-slate-600 text-xl"></i>
                                </div>
                            @endif
                            <div>
                                <p class="font-semibold text-white">{{ $detail->product->nama ?? 'Produk tidak tersedia' }}</p>
                                <p class="text-sm text-slate-400">Rp {{ number_format($detail->harga, 0, ',', '.') }} x {{ $detail->jumlah }}</p>
                            </div>
                        </div>
                        <p class="font-bold text-orange-400">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</p>
                    </div>
                @endforeach
            </div>
            
            {{-- Total --}}
            <div class="bg-slate-800/50 p-6 border-t border-slate-700">
                <div class="space-y-2">
                    <div class="flex justify-between text-sm">
                        <span class="text-slate-400">Subtotal</span>
                        <span class="text-white">Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-slate-400">Pajak ({{ $order->pajak_persen ?? 0 }}%)</span>
                        <span class="text-white">Rp {{ number_format($order->pajak ?? 0, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between pt-2 border-t border-slate-700">
                        <span class="font-bold text-white text-lg">Total</span>
                        <span class="font-bold text-orange-400 text-lg">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
