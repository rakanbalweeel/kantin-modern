{{--
==========================================================================
RIWAYAT PESANAN - SISWA (DARK THEME)
==========================================================================
--}}

@extends('layouts.app')

@section('title', 'Riwayat Pesanan')

@section('content')
<div class="min-h-screen hero-gradient py-8">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Header Section --}}
        <div class="mb-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div class="flex items-center mb-4 md:mb-0">
                    <div class="w-14 h-14 bg-gradient-to-br from-orange-500 to-amber-500 rounded-2xl flex items-center justify-center shadow-lg shadow-orange-500/20 mr-4">
                        <i class="fas fa-clipboard-list text-white text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold text-white">Riwayat <span class="gradient-text">Pesanan</span></h1>
                        <p class="text-slate-400 mt-1">Lacak dan kelola semua pesananmu</p>
                    </div>
                </div>
                
                @if($orders->count() > 0)
                <div class="flex items-center space-x-3">
                    <div class="glass-card rounded-2xl px-5 py-3">
                        <p class="text-xs text-slate-500 uppercase tracking-wider">Total Pesanan</p>
                        <p class="text-2xl font-bold text-orange-400">{{ $orders->total() }}</p>
                    </div>
                </div>
                @endif
            </div>
        </div>

        {{-- Filter Tabs --}}
        @if($orders->count() > 0)
        <div class="glass rounded-2xl p-4 mb-8">
            <div class="flex flex-wrap items-center gap-3">
                <span class="text-sm text-slate-500">Filter:</span>
                <a href="{{ route('siswa.orders.index') }}" 
                   class="px-4 py-2 rounded-xl text-sm font-medium transition-all {{ !request('status') ? 'bg-gradient-to-r from-orange-500 to-amber-500 text-white shadow-lg shadow-orange-500/30' : 'bg-white/5 text-slate-300 hover:bg-white/10' }}">
                    <i class="fas fa-list mr-2"></i>Semua
                </a>
                <a href="{{ route('siswa.orders.index', ['status' => 'pending']) }}" 
                   class="px-4 py-2 rounded-xl text-sm font-medium transition-all {{ request('status') == 'pending' ? 'bg-yellow-500 text-white shadow-lg shadow-yellow-500/30' : 'bg-white/5 text-slate-300 hover:bg-white/10' }}">
                    <i class="fas fa-clock mr-2"></i>Pending
                </a>
                <a href="{{ route('siswa.orders.index', ['status' => 'diproses']) }}" 
                   class="px-4 py-2 rounded-xl text-sm font-medium transition-all {{ request('status') == 'diproses' ? 'bg-blue-500 text-white shadow-lg shadow-blue-500/30' : 'bg-white/5 text-slate-300 hover:bg-white/10' }}">
                    <i class="fas fa-sync-alt mr-2"></i>Diproses
                </a>
                <a href="{{ route('siswa.orders.index', ['status' => 'selesai']) }}" 
                   class="px-4 py-2 rounded-xl text-sm font-medium transition-all {{ request('status') == 'selesai' ? 'bg-emerald-500 text-white shadow-lg shadow-emerald-500/30' : 'bg-white/5 text-slate-300 hover:bg-white/10' }}">
                    <i class="fas fa-check-circle mr-2"></i>Selesai
                </a>
            </div>
        </div>
        @endif

        {{-- Orders List --}}
        <div class="space-y-5">
            @forelse($orders as $order)
                @php
                    $statusConfig = [
                        'pending' => [
                            'bg' => 'bg-yellow-500/20',
                            'text' => 'text-yellow-400',
                            'icon' => 'fa-clock',
                            'label' => 'Menunggu'
                        ],
                        'diproses' => [
                            'bg' => 'bg-blue-500/20',
                            'text' => 'text-blue-400',
                            'icon' => 'fa-sync-alt fa-spin',
                            'label' => 'Diproses'
                        ],
                        'selesai' => [
                            'bg' => 'bg-emerald-500/20',
                            'text' => 'text-emerald-400',
                            'icon' => 'fa-check-circle',
                            'label' => 'Selesai'
                        ],
                        'batal' => [
                            'bg' => 'bg-red-500/20',
                            'text' => 'text-red-400',
                            'icon' => 'fa-times-circle',
                            'label' => 'Dibatalkan'
                        ],
                    ];
                    $config = $statusConfig[$order->status] ?? $statusConfig['pending'];
                @endphp
                
                <div class="glass-card rounded-2xl overflow-hidden hover:bg-white/5 transition-all duration-300 group">
                    {{-- Order Header --}}
                    <div class="p-6 flex flex-col md:flex-row md:items-center justify-between border-b border-slate-700/50">
                        <div class="flex items-center mb-4 md:mb-0">
                            <div class="w-12 h-12 {{ $config['bg'] }} rounded-xl flex items-center justify-center mr-4">
                                <i class="fas {{ $config['icon'] }} {{ $config['text'] }} text-lg"></i>
                            </div>
                            <div>
                                <p class="font-bold text-white text-lg">#{{ $order->kode_pesanan }}</p>
                                <div class="flex items-center mt-1 text-sm text-slate-500">
                                    <i class="fas fa-calendar-alt mr-2"></i>
                                    {{ $order->created_at->locale('id')->isoFormat('dddd, D MMM Y') }}
                                    <span class="mx-2">•</span>
                                    <i class="fas fa-clock mr-2"></i>
                                    {{ $order->created_at->format('H:i') }}
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center space-x-3">
                            {{-- Pickup Time Badge --}}
                            @if($order->waktu_pengambilan)
                            <span class="px-3 py-2 {{ $order->waktu_pengambilan === 'istirahat_1' ? 'bg-blue-500/20 text-blue-400' : 'bg-purple-500/20 text-purple-400' }} rounded-xl text-sm font-medium flex items-center">
                                <i class="fas fa-clock mr-2"></i>
                                {{ $order->waktu_pengambilan === 'istirahat_1' ? 'Ist. 1' : 'Ist. 2' }}
                            </span>
                            @endif
                            <span class="px-4 py-2 {{ $config['bg'] }} {{ $config['text'] }} rounded-xl text-sm font-semibold flex items-center">
                                <i class="fas {{ $config['icon'] }} mr-2"></i>
                                {{ $config['label'] }}
                            </span>
                        </div>
                    </div>
                    
                    {{-- Order Items --}}
                    <div class="p-6">
                        <div class="flex flex-wrap gap-2 mb-4">
                            @foreach($order->details->take(3) as $detail)
                                <div class="glass rounded-lg px-3 py-2 text-sm text-slate-300">
                                    {{ $detail->product->nama ?? 'Produk' }} × {{ $detail->jumlah }}
                                </div>
                            @endforeach
                            @if($order->details->count() > 3)
                                <div class="glass rounded-lg px-3 py-2 text-sm text-slate-400">
                                    +{{ $order->details->count() - 3 }} lainnya
                                </div>
                            @endif
                        </div>
                        
                        <div class="flex flex-col md:flex-row md:items-center justify-between pt-4 border-t border-slate-700/50">
                            <div>
                                <p class="text-sm text-slate-500">Total Pembayaran</p>
                                <p class="text-2xl font-bold text-orange-400">Rp {{ number_format($order->total, 0, ',', '.') }}</p>
                            </div>
                            <div class="flex items-center space-x-3 mt-4 md:mt-0">
                                @if($order->status == 'pending')
                                    <form action="{{ route('siswa.orders.cancel', $order->id) }}" method="POST" 
                                          onsubmit="return confirm('Yakin ingin membatalkan pesanan ini?');">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" 
                                                class="px-4 py-2 bg-red-500/20 text-red-400 rounded-xl hover:bg-red-500/30 transition-all text-sm font-medium">
                                            <i class="fas fa-times mr-2"></i>Batalkan
                                        </button>
                                    </form>
                                @endif
                                <a href="{{ route('siswa.orders.show', $order->id) }}" 
                                   class="px-5 py-2 bg-gradient-to-r from-orange-500 to-amber-500 text-white rounded-xl shadow-lg shadow-orange-500/20 hover:shadow-orange-500/40 transition-all text-sm font-semibold">
                                    <i class="fas fa-eye mr-2"></i>Lihat Detail
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                {{-- Empty State --}}
                <div class="glass-card rounded-3xl p-12 text-center">
                    <div class="w-24 h-24 mx-auto bg-gradient-to-br from-orange-500/20 to-amber-500/20 rounded-full flex items-center justify-center mb-6">
                        <i class="fas fa-shopping-basket text-4xl text-orange-400"></i>
                    </div>
                    <h2 class="text-2xl font-bold text-white mb-2">Belum Ada Pesanan</h2>
                    <p class="text-slate-400 mb-8 max-w-sm mx-auto">
                        Kamu belum pernah memesan. Yuk mulai pesan makanan favoritmu!
                    </p>
                    <a href="{{ route('siswa.menu') }}" 
                       class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-orange-500 to-amber-500 text-white rounded-2xl font-semibold shadow-lg shadow-orange-500/30 hover:shadow-orange-500/50 hover:-translate-y-1 transition-all duration-300">
                        <i class="fas fa-utensils mr-3"></i>
                        Lihat Menu
                    </a>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        @if($orders->hasPages())
            <div class="mt-8 flex justify-center">
                {{ $orders->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
