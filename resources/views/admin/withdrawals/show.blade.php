{{--
==========================================================================
ADMIN - DETAIL PENARIKAN TUNAI - DARK THEME
==========================================================================
--}}

@extends('layouts.app')

@section('title', 'Detail Penarikan - Admin')

@section('content')
<div class="min-h-screen hero-gradient py-8">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Header --}}
        <div class="mb-8">
            <a href="{{ route('admin.withdrawals.index') }}" class="inline-flex items-center text-slate-400 hover:text-orange-400 transition-colors mb-4 group">
                <div class="w-8 h-8 rounded-lg glass flex items-center justify-center mr-3 group-hover:bg-orange-500/20 transition-all">
                    <i class="fas fa-arrow-left text-sm"></i>
                </div>
                <span class="font-medium">Kembali ke Daftar</span>
            </a>
            <h1 class="text-3xl font-bold text-white">
                Detail <span class="gradient-text">Penarikan</span>
            </h1>
        </div>

        {{-- Main Card --}}
        <div class="glass-card rounded-2xl overflow-hidden">
            {{-- Header with Status --}}
            <div class="bg-gradient-to-r from-orange-500 to-amber-500 px-6 py-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-orange-100 text-sm">Kode Penarikan</p>
                        <p class="text-2xl font-bold font-mono">{{ $withdrawal->kode_withdrawal }}</p>
                    </div>
                    @php
                        $statusConfig = [
                            'pending' => ['bg' => 'bg-yellow-400', 'text' => 'text-yellow-900', 'icon' => 'fa-clock'],
                            'approved' => ['bg' => 'bg-emerald-400', 'text' => 'text-emerald-900', 'icon' => 'fa-check-circle'],
                            'rejected' => ['bg' => 'bg-red-400', 'text' => 'text-red-900', 'icon' => 'fa-times-circle'],
                        ];
                        $config = $statusConfig[$withdrawal->status] ?? $statusConfig['pending'];
                    @endphp
                    <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold {{ $config['bg'] }} {{ $config['text'] }}">
                        <i class="fas {{ $config['icon'] }} mr-2"></i>
                        {{ ucfirst($withdrawal->status) }}
                    </span>
                </div>
            </div>

            <div class="p-6 space-y-6">
                {{-- Info Kantin --}}
                <div class="p-4 bg-orange-500/10 rounded-xl border border-orange-500/30">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-gradient-to-br from-orange-400 to-amber-500 rounded-xl flex items-center justify-center mr-4 shadow-lg shadow-orange-500/20">
                            <i class="fas fa-store text-xl text-white"></i>
                        </div>
                        <div>
                            <p class="text-sm text-slate-500">Penjaga Kantin</p>
                            <p class="font-bold text-white">{{ $withdrawal->user->name }}</p>
                            <p class="text-sm text-slate-400">{{ $withdrawal->user->email }}</p>
                        </div>
                    </div>
                </div>

                {{-- Detail Keuangan --}}
                <div class="space-y-4">
                    <h3 class="font-bold text-white flex items-center">
                        <i class="fas fa-calculator text-orange-400 mr-2"></i>
                        Rincian Keuangan
                    </h3>
                    
                    <div class="bg-slate-800/50 rounded-xl p-4 space-y-3 border border-slate-700">
                        <div class="flex justify-between">
                            <span class="text-slate-400">Jumlah Penarikan</span>
                            <span class="font-semibold text-white">Rp {{ number_format($withdrawal->jumlah, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-400">Pajak ({{ $withdrawal->pajak_persen }}%)</span>
                            <span class="font-semibold text-red-400">- Rp {{ number_format($withdrawal->pajak_nominal, 0, ',', '.') }}</span>
                        </div>
                        <div class="border-t border-slate-700 pt-3">
                            <div class="flex justify-between">
                                <span class="font-bold text-white">Jumlah Diterima</span>
                                <span class="font-extrabold text-xl text-emerald-400">Rp {{ number_format($withdrawal->jumlah_bersih, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Metode Pembayaran --}}
                <div class="space-y-4">
                    <h3 class="font-bold text-white flex items-center">
                        <i class="fas fa-credit-card text-blue-400 mr-2"></i>
                        Metode Pembayaran
                    </h3>
                    
                    <div class="bg-slate-800/50 rounded-xl p-4 border border-slate-700">
                        @if($withdrawal->metode_pembayaran === 'transfer')
                            <div class="flex items-center mb-4">
                                <div class="w-10 h-10 bg-blue-500/20 rounded-xl flex items-center justify-center mr-3">
                                    <i class="fas fa-university text-blue-400"></i>
                                </div>
                                <span class="font-semibold text-white">Transfer Bank</span>
                            </div>
                            <div class="space-y-2 text-sm pl-13">
                                <div class="flex justify-between">
                                    <span class="text-slate-400">Bank</span>
                                    <span class="text-white">{{ $withdrawal->nama_bank }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-slate-400">Nomor Rekening</span>
                                    <span class="text-white font-mono">{{ $withdrawal->nomor_rekening }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-slate-400">Atas Nama</span>
                                    <span class="text-white">{{ $withdrawal->atas_nama }}</span>
                                </div>
                            </div>
                        @else
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-green-500/20 rounded-xl flex items-center justify-center mr-3">
                                    <i class="fas fa-money-bill text-green-400"></i>
                                </div>
                                <span class="font-semibold text-white">Pembayaran Tunai</span>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Timeline --}}
                <div class="space-y-4">
                    <h3 class="font-bold text-white flex items-center">
                        <i class="fas fa-history text-purple-400 mr-2"></i>
                        Riwayat Status
                    </h3>
                    
                    <div class="space-y-3">
                        {{-- Request Created --}}
                        <div class="flex items-start">
                            <div class="w-8 h-8 bg-blue-500/20 rounded-full flex items-center justify-center mr-3 mt-0.5">
                                <i class="fas fa-paper-plane text-blue-400 text-xs"></i>
                            </div>
                            <div>
                                <p class="font-medium text-white">Permintaan Diajukan</p>
                                <p class="text-sm text-slate-500">{{ $withdrawal->created_at->locale('id')->isoFormat('dddd, D MMMM Y HH:mm') }} WIB</p>
                            </div>
                        </div>

                        {{-- Processed --}}
                        @if($withdrawal->approved_at)
                            <div class="flex items-start">
                                <div class="w-8 h-8 {{ $withdrawal->status === 'approved' ? 'bg-emerald-500/20' : 'bg-red-500/20' }} rounded-full flex items-center justify-center mr-3 mt-0.5">
                                    <i class="fas {{ $withdrawal->status === 'approved' ? 'fa-check' : 'fa-times' }} {{ $withdrawal->status === 'approved' ? 'text-emerald-400' : 'text-red-400' }} text-xs"></i>
                                </div>
                                <div>
                                    <p class="font-medium text-white">{{ $withdrawal->status === 'approved' ? 'Disetujui' : 'Ditolak' }} oleh {{ $withdrawal->approver->name ?? 'Admin' }}</p>
                                    <p class="text-sm text-slate-500">{{ $withdrawal->approved_at->locale('id')->isoFormat('dddd, D MMMM Y HH:mm') }} WIB</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Catatan --}}
                @if($withdrawal->catatan)
                    <div class="p-4 bg-slate-800/50 rounded-xl border border-slate-700">
                        <div class="flex items-start">
                            <div class="w-8 h-8 bg-slate-700 rounded-lg flex items-center justify-center mr-3 flex-shrink-0">
                                <i class="fas fa-comment text-slate-400 text-sm"></i>
                            </div>
                            <div>
                                <p class="text-xs text-slate-500 uppercase tracking-wider mb-1">Catatan</p>
                                <p class="text-slate-300">{{ $withdrawal->catatan }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Action Buttons for Pending --}}
                @if($withdrawal->status === 'pending')
                    <div class="flex gap-3 pt-4 border-t border-slate-700" x-data="{ showReject: false }">
                        <form action="{{ route('admin.withdrawals.approve', $withdrawal) }}" method="POST" class="flex-1">
                            @csrf
                            @method('PATCH')
                            <button type="submit" onclick="return confirm('Setujui penarikan ini? Pajak Rp {{ number_format($withdrawal->pajak_nominal, 0, ',', '.') }} akan masuk ke kas admin.')"
                                    class="w-full py-4 bg-gradient-to-r from-emerald-500 to-green-600 text-white rounded-xl font-semibold shadow-lg shadow-emerald-500/20 hover:shadow-emerald-500/40 transition-all flex items-center justify-center">
                                <i class="fas fa-check mr-2"></i> Setujui Penarikan
                            </button>
                        </form>
                        
                        <button @click="showReject = true"
                                class="flex-1 py-4 bg-red-500/20 text-red-400 border border-red-500/30 rounded-xl font-semibold hover:bg-red-500/30 transition-all flex items-center justify-center">
                            <i class="fas fa-times mr-2"></i> Tolak
                        </button>

                        {{-- Reject Modal --}}
                        <div x-show="showReject" x-cloak
                             class="fixed inset-0 bg-black/70 flex items-center justify-center z-50"
                             @click.self="showReject = false">
                            <div class="glass-card rounded-2xl w-full max-w-md p-6 m-4" @click.stop>
                                <h3 class="text-lg font-bold text-white mb-4 flex items-center">
                                    <div class="w-10 h-10 bg-red-500/20 rounded-xl flex items-center justify-center mr-3">
                                        <i class="fas fa-times-circle text-red-400"></i>
                                    </div>
                                    Tolak Penarikan
                                </h3>
                                <form action="{{ route('admin.withdrawals.reject', $withdrawal) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <div class="mb-4">
                                        <label class="block text-sm font-semibold text-slate-300 mb-2">
                                            Alasan Penolakan <span class="text-red-400">*</span>
                                        </label>
                                        <textarea name="catatan" rows="3" required
                                                  class="w-full px-4 py-3 rounded-xl bg-slate-800/50 border border-slate-700 text-white placeholder-slate-500 focus:border-red-500 focus:ring-2 focus:ring-red-500/20 transition-all"
                                                  placeholder="Jelaskan alasan penolakan..."></textarea>
                                    </div>
                                    <div class="flex gap-3">
                                        <button type="button" @click="showReject = false"
                                                class="flex-1 px-6 py-3 bg-slate-700 text-slate-300 rounded-xl hover:bg-slate-600 transition-colors font-medium">
                                            Batal
                                        </button>
                                        <button type="submit"
                                                class="flex-1 px-6 py-3 bg-red-500 text-white rounded-xl hover:bg-red-600 transition-colors font-medium">
                                            <i class="fas fa-times mr-2"></i> Tolak
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
