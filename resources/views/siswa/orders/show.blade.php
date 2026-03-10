{{--
==========================================================================
DETAIL PESANAN / STRUK - SISWA (DARK THEME)
==========================================================================
--}}

@extends('layouts.app')

@section('title', 'Detail Pesanan')

@section('content')
<div class="min-h-screen hero-gradient py-8">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Back Button --}}
        <div class="mb-6">
            <a href="{{ route('siswa.orders.index') }}" 
               class="inline-flex items-center text-slate-400 hover:text-orange-400 transition-colors duration-200 group">
                <div class="w-8 h-8 rounded-lg glass flex items-center justify-center mr-3 group-hover:bg-orange-500/20 transition-all duration-200">
                    <i class="fas fa-arrow-left text-sm"></i>
                </div>
                <span class="font-medium">Kembali ke Riwayat</span>
            </a>
        </div>

        {{-- Receipt Card --}}
        <div class="glass-card rounded-3xl overflow-hidden relative">
            {{-- Decorative Top Edge --}}
            <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-orange-500 via-amber-500 to-yellow-500"></div>
            
            {{-- Header --}}
            <div class="bg-gradient-to-br from-orange-500 via-amber-500 to-yellow-500 px-8 pt-10 pb-12 text-white text-center relative overflow-hidden">
                {{-- Background Pattern --}}
                <div class="absolute inset-0 opacity-10">
                    <div class="absolute top-0 left-0 w-40 h-40 bg-white rounded-full -translate-x-1/2 -translate-y-1/2"></div>
                    <div class="absolute bottom-0 right-0 w-32 h-32 bg-white rounded-full translate-x-1/2 translate-y-1/2"></div>
                </div>
                
                <div class="relative">
                    <div class="w-20 h-20 mx-auto bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center mb-4 shadow-lg">
                        <i class="fas fa-receipt text-4xl text-white"></i>
                    </div>
                    <h1 class="text-3xl font-bold">RasaPelajar</h1>
                    <p class="text-white/80 text-sm mt-1">Sistem Informasi Kantin Sekolah</p>
                    
                    {{-- Status Badge --}}
                    @php
                        $statusConfig = [
                            'pending' => [
                                'bg' => 'bg-yellow-400',
                                'text' => 'text-yellow-900',
                                'icon' => 'fa-clock',
                                'label' => 'Menunggu Konfirmasi'
                            ],
                            'diproses' => [
                                'bg' => 'bg-blue-400',
                                'text' => 'text-blue-900',
                                'icon' => 'fa-sync-alt fa-spin',
                                'label' => 'Sedang Diproses'
                            ],
                            'selesai' => [
                                'bg' => 'bg-emerald-400',
                                'text' => 'text-emerald-900',
                                'icon' => 'fa-check-circle',
                                'label' => 'Selesai'
                            ],
                            'batal' => [
                                'bg' => 'bg-red-400',
                                'text' => 'text-red-900',
                                'icon' => 'fa-times-circle',
                                'label' => 'Dibatalkan'
                            ],
                        ];
                        $config = $statusConfig[$order->status] ?? $statusConfig['pending'];
                    @endphp
                    <div class="mt-6">
                        <span class="inline-flex items-center space-x-2 px-4 py-2 rounded-full {{ $config['bg'] }} {{ $config['text'] }} font-semibold text-sm shadow-lg">
                            <i class="fas {{ $config['icon'] }}"></i>
                            <span>{{ $config['label'] }}</span>
                        </span>
                    </div>
                </div>
            </div>

            {{-- Order Info Section --}}
            <div class="px-8 py-6 border-b border-dashed border-slate-700 bg-gradient-to-b from-slate-800/50 to-transparent">
                <div class="grid grid-cols-2 gap-6">
                    <div class="space-y-1">
                        <p class="text-xs text-slate-500 uppercase tracking-wider font-medium">No. Pesanan</p>
                        <p class="font-bold text-white text-lg">{{ $order->kode_pesanan }}</p>
                    </div>
                    <div class="space-y-1 text-right">
                        <p class="text-xs text-slate-500 uppercase tracking-wider font-medium">Tanggal</p>
                        <p class="font-medium text-slate-300">{{ $order->created_at->format('d M Y') }}</p>
                        <p class="text-sm text-slate-500">{{ $order->created_at->format('H:i') }} WIB</p>
                    </div>
                </div>
            </div>

            {{-- Waktu Pengambilan Section --}}
            <div class="px-8 py-4 border-b border-dashed border-slate-700 bg-gradient-to-b from-blue-500/5 to-transparent">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center
                            {{ $order->waktu_pengambilan === 'istirahat_1' ? 'bg-blue-500/20' : 'bg-purple-500/20' }}">
                            <i class="fas fa-clock {{ $order->waktu_pengambilan === 'istirahat_1' ? 'text-blue-400' : 'text-purple-400' }}"></i>
                        </div>
                        <div>
                            <p class="text-xs text-slate-500 uppercase tracking-wider font-medium">Waktu Pengambilan</p>
                            <p class="font-bold {{ $order->waktu_pengambilan === 'istirahat_1' ? 'text-blue-400' : 'text-purple-400' }}">
                                {{ $order->waktu_pengambilan_label }}
                            </p>
                        </div>
                    </div>
                    @if($order->status === 'pending' || $order->status === 'diproses')
                        <span class="px-3 py-1 rounded-full text-xs font-semibold animate-pulse
                            {{ $order->waktu_pengambilan === 'istirahat_1' ? 'bg-blue-500/20 text-blue-400' : 'bg-purple-500/20 text-purple-400' }}">
                            <i class="fas fa-bell mr-1"></i>
                            Siapkan sebelum {{ $order->waktu_pengambilan === 'istirahat_1' ? '09:30' : '12:00' }}
                        </span>
                    @endif
                </div>
            </div>

            {{-- Items List --}}
            <div class="px-8 py-6">
                <h3 class="text-sm font-bold text-slate-400 uppercase tracking-wider mb-4 flex items-center">
                    <i class="fas fa-shopping-basket mr-2 text-orange-400"></i>
                    Detail Pesanan
                </h3>
                
                <div class="space-y-4">
                    @foreach($order->details as $detail)
                        <div class="flex items-center justify-between py-3 border-b border-slate-700/50 last:border-b-0">
                            <div class="flex items-center">
                                <div class="w-12 h-12 bg-gradient-to-br from-orange-500/20 to-amber-500/20 rounded-xl flex items-center justify-center mr-4">
                                    <span class="text-xl">🍽️</span>
                                </div>
                                <div>
                                    <p class="font-semibold text-white">{{ $detail->product->nama ?? 'Produk' }}</p>
                                    <p class="text-sm text-slate-500">
                                        Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }} × {{ $detail->jumlah }}
                                    </p>
                                </div>
                            </div>
                            <p class="font-bold text-orange-400">
                                Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                            </p>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Price Summary --}}
            <div class="px-8 py-6 bg-slate-800/30 border-t border-slate-700/50">
                <div class="space-y-3">
                    <div class="flex justify-between text-slate-400">
                        <span>Subtotal</span>
                        <span>Rp {{ number_format($order->subtotal ?? $order->total - ($order->pajak_nominal ?? 0), 0, ',', '.') }}</span>
                    </div>
                    @if(isset($order->pajak) && $order->pajak > 0)
                        <div class="flex justify-between text-slate-400">
                            <span>Pajak ({{ $order->pajak_persen ?? 0 }}%)</span>
                            <span>Rp {{ number_format($order->pajak, 0, ',', '.') }}</span>
                        </div>
                    @endif
                    <div class="pt-3 border-t border-dashed border-slate-700">
                        <div class="flex justify-between items-center">
                            <span class="text-lg font-bold text-white">Total</span>
                            <span class="text-2xl font-bold text-orange-400">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Notes --}}
            @if($order->catatan)
                <div class="px-8 py-4 border-t border-slate-700/50">
                    <div class="flex items-start space-x-3">
                        <div class="w-8 h-8 bg-blue-500/20 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-sticky-note text-blue-400 text-sm"></i>
                        </div>
                        <div>
                            <p class="text-xs text-slate-500 uppercase tracking-wider mb-1">Catatan</p>
                            <p class="text-slate-300 text-sm">{{ $order->catatan }}</p>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Footer --}}
            <div class="px-8 py-6 text-center border-t border-slate-700/50">
                <p class="text-slate-500 text-sm mb-1">Terima kasih telah memesan!</p>
                <p class="text-slate-600 text-xs">{{ $order->created_at->locale('id')->isoFormat('dddd, D MMMM Y - HH:mm') }} WIB</p>
            </div>

            {{-- Action Buttons --}}
            <div class="px-8 pb-8">
                <div class="flex flex-col sm:flex-row gap-3">
                    @if($order->status == 'pending')
                        <form action="{{ route('siswa.orders.cancel', $order->id) }}" method="POST" 
                              class="flex-1"
                              onsubmit="return confirm('Yakin ingin membatalkan pesanan ini?');">
                            @csrf
                            @method('PATCH')
                            <button type="submit" 
                                    class="w-full px-6 py-4 bg-red-500/20 text-red-400 rounded-2xl hover:bg-red-500/30 transition-all font-semibold">
                                <i class="fas fa-times mr-2"></i>Batalkan Pesanan
                            </button>
                        </form>
                    @endif
                    <a href="{{ route('siswa.menu') }}" 
                       class="flex-1 px-6 py-4 bg-gradient-to-r from-orange-500 to-amber-500 text-white rounded-2xl shadow-lg shadow-orange-500/20 hover:shadow-orange-500/40 transition-all font-semibold text-center">
                        <i class="fas fa-utensils mr-2"></i>Pesan Lagi
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
