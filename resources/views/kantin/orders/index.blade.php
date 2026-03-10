{{--
==========================================================================
KANTIN - DAFTAR PESANAN (DARK THEME)
==========================================================================
--}}

@extends('layouts.app')

@section('title', 'Daftar Pesanan - Kantin')

@section('content')
<div class="min-h-screen hero-gradient py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Success Message --}}
        @if(session('success'))
            <div class="mb-6 glass bg-emerald-500/10 border-emerald-500/30 text-emerald-400 px-6 py-4 rounded-2xl flex items-center" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)">
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
            <div class="mb-6 glass bg-red-500/10 border-red-500/30 text-red-400 px-6 py-4 rounded-2xl flex items-center" x-data="{ show: true }" x-show="show">
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
        <div class="mb-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div>
                    <h1 class="text-3xl font-extrabold text-white">
                        Daftar <span class="gradient-text">Pesanan</span>
                    </h1>
                    <p class="mt-1 text-slate-400">Kelola semua pesanan masuk</p>
                </div>
                <a href="{{ route('kantin.dashboard') }}" class="mt-4 md:mt-0 inline-flex items-center px-4 py-2 glass rounded-xl text-slate-300 hover:text-orange-400 hover:bg-white/10 transition-all">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali ke Dashboard
                </a>
            </div>
        </div>

        {{-- Filter --}}
        <div class="glass-card rounded-2xl p-6 mb-8">
            <form action="{{ route('kantin.orders.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-2">Cari</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Kode pesanan / Nama siswa" 
                           class="w-full px-4 py-2.5 rounded-xl bg-slate-800/50 border border-slate-700 text-white placeholder-slate-500 focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 transition-all">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-2">Status</label>
                    <select name="status" class="w-full px-4 py-2.5 rounded-xl bg-slate-800/50 border border-slate-700 text-white focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 transition-all">
                        <option value="" class="bg-slate-800">Semua Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }} class="bg-slate-800">Pending</option>
                        <option value="diproses" {{ request('status') == 'diproses' ? 'selected' : '' }} class="bg-slate-800">Diproses</option>
                        <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }} class="bg-slate-800">Selesai</option>
                        <option value="batal" {{ request('status') == 'batal' ? 'selected' : '' }} class="bg-slate-800">Batal</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-2">Tanggal</label>
                    <input type="date" name="date" value="{{ request('date') }}" 
                           class="w-full px-4 py-2.5 rounded-xl bg-slate-800/50 border border-slate-700 text-white focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 transition-all">
                </div>
                <div class="flex items-end gap-2">
                    <button type="submit" class="flex-1 px-6 py-2.5 bg-gradient-to-r from-orange-500 to-amber-500 text-white rounded-xl font-semibold shadow-lg shadow-orange-500/20 hover:shadow-orange-500/40 transition-all">
                        <i class="fas fa-search mr-2"></i> Cari
                    </button>
                    <a href="{{ route('kantin.orders.index') }}" class="px-4 py-2.5 bg-slate-700 text-slate-300 rounded-xl hover:bg-slate-600 transition-all">
                        <i class="fas fa-times"></i>
                    </a>
                </div>
            </form>
        </div>

        {{-- Status Legend --}}
        <div class="glass rounded-2xl p-4 mb-6 border border-orange-500/30 bg-orange-500/5">
            <div class="flex flex-wrap items-center gap-4">
                <span class="text-sm font-medium text-slate-300"><i class="fas fa-info-circle mr-1 text-orange-400"></i> Alur Status:</span>
                <div class="flex items-center gap-2">
                    <span class="px-3 py-1 bg-yellow-500/20 text-yellow-400 rounded-full text-xs font-medium border border-yellow-500/30">Pending</span>
                    <i class="fas fa-arrow-right text-slate-600 text-xs"></i>
                    <span class="px-3 py-1 bg-blue-500/20 text-blue-400 rounded-full text-xs font-medium border border-blue-500/30">Diproses</span>
                    <i class="fas fa-arrow-right text-slate-600 text-xs"></i>
                    <span class="px-3 py-1 bg-emerald-500/20 text-emerald-400 rounded-full text-xs font-medium border border-emerald-500/30">Selesai</span>
                </div>
                <span class="text-xs text-slate-500">| Status <span class="text-red-400 font-medium">tidak dapat</span> dikembalikan</span>
            </div>
        </div>

        {{-- Table --}}
        <div class="glass-card rounded-2xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gradient-to-r from-orange-500 to-amber-500 text-white">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Kode Pesanan</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Pembeli</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Items</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Total</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Pengambilan</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Status</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold">Waktu</th>
                            <th class="px-6 py-4 text-center text-sm font-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-700/50">
                        @forelse($orders as $order)
                            <tr class="hover:bg-white/5 transition-colors">
                                <td class="px-6 py-4">
                                    <span class="font-bold text-white font-mono">{{ $order->kode_pesanan }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-gradient-to-br from-orange-500 to-amber-500 rounded-xl flex items-center justify-center mr-3">
                                            <span class="text-white font-bold text-sm">{{ strtoupper(substr($order->user->name, 0, 1)) }}</span>
                                        </div>
                                        <div>
                                            <p class="font-medium text-white">{{ $order->user->name }}</p>
                                            <p class="text-xs text-slate-500">{{ $order->user->email }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-sm text-slate-400">{{ $order->orderDetails->sum('jumlah') }} item</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="font-bold text-orange-400">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium
                                        {{ $order->waktu_pengambilan === 'istirahat_1' ? 'bg-blue-500/20 text-blue-400 border border-blue-500/30' : 'bg-purple-500/20 text-purple-400 border border-purple-500/30' }}">
                                        <i class="fas fa-clock mr-1"></i>
                                        {{ $order->waktu_pengambilan === 'istirahat_1' ? 'Ist. 1' : 'Ist. 2' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                        $statusConfig = [
                                            'pending' => ['bg' => 'bg-yellow-500/20', 'text' => 'text-yellow-400', 'border' => 'border-yellow-500/30', 'icon' => 'fa-clock'],
                                            'diproses' => ['bg' => 'bg-blue-500/20', 'text' => 'text-blue-400', 'border' => 'border-blue-500/30', 'icon' => 'fa-spinner'],
                                            'selesai' => ['bg' => 'bg-emerald-500/20', 'text' => 'text-emerald-400', 'border' => 'border-emerald-500/30', 'icon' => 'fa-check-circle'],
                                            'batal' => ['bg' => 'bg-red-500/20', 'text' => 'text-red-400', 'border' => 'border-red-500/30', 'icon' => 'fa-times-circle'],
                                        ];
                                        $config = $statusConfig[$order->status] ?? $statusConfig['pending'];
                                    @endphp
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $config['bg'] }} {{ $config['text'] }} border {{ $config['border'] }}">
                                        <i class="fas {{ $config['icon'] }} mr-1"></i>
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-slate-300">{{ $order->created_at->format('d/m/Y') }}</div>
                                    <div class="text-xs text-slate-500">{{ $order->created_at->format('H:i') }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('kantin.orders.show', $order) }}" class="p-2 bg-slate-700 text-slate-300 rounded-lg hover:bg-orange-500/20 hover:text-orange-400 transition-all" title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        
                                        @if($order->status === 'pending')
                                            <form action="{{ route('kantin.orders.accept', $order) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="p-2 bg-emerald-500/20 text-emerald-400 rounded-lg hover:bg-emerald-500/30 transition-all" title="Terima">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </form>
                                        @endif
                                        
                                        @if($order->status === 'diproses')
                                            <form action="{{ route('kantin.orders.complete', $order) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="p-2 bg-emerald-500/20 text-emerald-400 rounded-lg hover:bg-emerald-500/30 transition-all" title="Selesaikan">
                                                    <i class="fas fa-check-double"></i>
                                                </button>
                                            </form>
                                        @endif
                                        
                                        @if(in_array($order->status, ['pending', 'diproses']))
                                            <form action="{{ route('kantin.orders.cancel', $order) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin membatalkan pesanan ini?')">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="p-2 bg-red-500/20 text-red-400 rounded-lg hover:bg-red-500/30 transition-all" title="Batalkan">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-12 text-center">
                                    <div class="w-16 h-16 bg-slate-800 rounded-full flex items-center justify-center mx-auto mb-4">
                                        <i class="fas fa-inbox text-2xl text-slate-600"></i>
                                    </div>
                                    <p class="text-slate-400 font-medium">Tidak ada pesanan ditemukan</p>
                                    <p class="text-sm text-slate-600">Coba ubah filter pencarian</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            {{-- Pagination --}}
            @if($orders->hasPages())
                <div class="px-6 py-4 border-t border-slate-700">
                    {{ $orders->withQueryString()->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
