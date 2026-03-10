{{--
==========================================================================
ADMIN - KELOLA PENARIKAN TUNAI - DARK THEME
==========================================================================
--}}

@extends('layouts.app')

@section('title', 'Kelola Penarikan - Admin')

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

        {{-- Validation Errors --}}
        @if($errors->any())
            <div class="mb-6 glass bg-red-500/10 border-red-500/30 text-red-400 px-6 py-4 rounded-2xl">
                <div class="flex items-center mb-2">
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    <span class="font-semibold">Terjadi kesalahan:</span>
                </div>
                <ul class="list-disc list-inside ml-4">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Header --}}
        <div class="mb-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div class="flex items-center mb-4 md:mb-0">
                    <div class="w-14 h-14 bg-gradient-to-br from-orange-500 to-amber-500 rounded-2xl flex items-center justify-center shadow-lg shadow-orange-500/20 mr-4">
                        <i class="fas fa-hand-holding-usd text-white text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold text-white">Kelola <span class="gradient-text">Penarikan</span></h1>
                        <p class="text-slate-400 mt-1">Kelola permintaan penarikan dari penjaga kantin</p>
                    </div>
                </div>
                <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-4 py-2 glass rounded-xl text-slate-300 hover:text-orange-400 transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali
                </a>
            </div>
        </div>

        {{-- Stats Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            {{-- Pending --}}
            <div class="relative rounded-2xl p-6 overflow-hidden bg-gradient-to-br from-yellow-500/20 to-amber-500/20 border border-yellow-500/30">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-yellow-500 to-amber-500 rounded-2xl flex items-center justify-center shadow-lg shadow-yellow-500/20">
                        <i class="fas fa-clock text-xl text-white"></i>
                    </div>
                    <span class="text-3xl font-extrabold text-yellow-400">{{ $stats['pending_count'] }}</span>
                </div>
                <p class="text-sm font-medium text-yellow-300/80 mb-1">Menunggu Approval</p>
                <p class="text-xl font-bold text-yellow-400">Rp {{ number_format($stats['pending'], 0, ',', '.') }}</p>
            </div>

            {{-- Approved Bulan Ini --}}
            <div class="glass-card rounded-2xl p-6 hover:bg-white/5 transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-emerald-500 to-green-600 rounded-2xl flex items-center justify-center shadow-lg shadow-emerald-500/20">
                        <i class="fas fa-check-circle text-xl text-white"></i>
                    </div>
                </div>
                <p class="text-sm font-medium text-slate-400 mb-1">Disetujui Bulan Ini</p>
                <p class="text-2xl font-extrabold text-emerald-400">
                    Rp {{ number_format($stats['approved_this_month'], 0, ',', '.') }}
                </p>
            </div>

            {{-- Total Pajak --}}
            <div class="glass-card rounded-2xl p-6 hover:bg-white/5 transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl flex items-center justify-center shadow-lg shadow-blue-500/20">
                        <i class="fas fa-coins text-xl text-white"></i>
                    </div>
                </div>
                <p class="text-sm font-medium text-slate-400 mb-1">Total Pajak Terkumpul</p>
                <p class="text-2xl font-extrabold text-blue-400">
                    Rp {{ number_format($stats['total_pajak_collected'], 0, ',', '.') }}
                </p>
            </div>

            {{-- Info --}}
            <div class="glass-card rounded-2xl p-6 hover:bg-white/5 transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-pink-600 rounded-2xl flex items-center justify-center shadow-lg shadow-purple-500/20">
                        <i class="fas fa-percentage text-xl text-white"></i>
                    </div>
                </div>
                <p class="text-sm font-medium text-slate-400 mb-1">Pajak Penarikan</p>
                <p class="text-2xl font-extrabold text-purple-400">
                    {{ \App\Models\Setting::get('pajak_withdrawal', 5) }}%
                </p>
            </div>
        </div>

        {{-- Filter --}}
        <div class="glass-card rounded-2xl p-6 mb-6">
            <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-slate-300 mb-2">Status</label>
                    <select name="status" onchange="this.form.submit()" class="w-full px-4 py-3 rounded-xl bg-slate-800/50 border border-slate-700 text-white focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 transition-all">
                        <option value="" class="bg-slate-800">Semua Status</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }} class="bg-slate-800">Pending</option>
                        <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }} class="bg-slate-800">Disetujui</option>
                        <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }} class="bg-slate-800">Ditolak</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-300 mb-2">Tanggal</label>
                    <input type="date" name="date" value="{{ request('date') }}" onchange="this.form.submit()"
                           class="w-full px-4 py-3 rounded-xl bg-slate-800/50 border border-slate-700 text-white focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 transition-all">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-300 mb-2">Cari</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Kode / Nama Kantin"
                           class="w-full px-4 py-3 rounded-xl bg-slate-800/50 border border-slate-700 text-white placeholder-slate-500 focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 transition-all">
                </div>
                <div class="flex items-end gap-2">
                    <button type="submit" class="flex-1 px-6 py-3 bg-gradient-to-r from-orange-500 to-amber-500 text-white rounded-xl font-semibold shadow-lg shadow-orange-500/20 hover:shadow-orange-500/40 transition-all">
                        <i class="fas fa-search mr-2"></i> Cari
                    </button>
                    @if(request()->hasAny(['status', 'date', 'search']))
                        <a href="{{ route('admin.withdrawals.index') }}" class="px-4 py-3 bg-slate-700 text-slate-300 rounded-xl hover:bg-slate-600 transition-colors">
                            <i class="fas fa-times"></i>
                        </a>
                    @endif
                </div>
            </form>
        </div>

        {{-- Table --}}
        <div class="glass-card rounded-2xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gradient-to-r from-orange-500 to-amber-500">
                            <th class="px-6 py-4 text-left text-sm font-semibold text-white">Kode</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-white">Kantin</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-white">Jumlah</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-white">Pajak</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-white">Bersih</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-white">Metode</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-white">Status</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-white">Tanggal</th>
                            <th class="px-6 py-4 text-center text-sm font-semibold text-white">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-700/50">
                        @forelse($withdrawals as $withdrawal)
                            <tr class="hover:bg-white/5 transition-colors" x-data="{ showReject: false }">
                                <td class="px-6 py-4">
                                    <span class="font-mono font-semibold text-white">{{ $withdrawal->kode_withdrawal }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-gradient-to-br from-orange-400 to-amber-500 rounded-xl flex items-center justify-center mr-3">
                                            <i class="fas fa-store text-white text-sm"></i>
                                        </div>
                                        <span class="font-medium text-slate-300">{{ $withdrawal->user->name }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="font-semibold text-white">Rp {{ number_format($withdrawal->jumlah, 0, ',', '.') }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-red-400 font-medium">
                                        - Rp {{ number_format($withdrawal->pajak_nominal, 0, ',', '.') }}
                                        <span class="text-xs text-slate-500">({{ $withdrawal->pajak_persen }}%)</span>
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="font-bold text-emerald-400">Rp {{ number_format($withdrawal->jumlah_bersih, 0, ',', '.') }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    @if($withdrawal->metode_pembayaran === 'transfer')
                                        <span class="text-sm text-slate-300">
                                            <i class="fas fa-university text-blue-400 mr-1"></i>
                                            {{ $withdrawal->nama_bank }}
                                        </span>
                                    @else
                                        <span class="text-sm text-slate-300">
                                            <i class="fas fa-money-bill text-green-400 mr-1"></i>
                                            Tunai
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                        $statusConfig = [
                                            'pending' => ['bg' => 'bg-yellow-500/20', 'text' => 'text-yellow-400', 'border' => 'border-yellow-500/30', 'icon' => 'fa-clock'],
                                            'approved' => ['bg' => 'bg-emerald-500/20', 'text' => 'text-emerald-400', 'border' => 'border-emerald-500/30', 'icon' => 'fa-check-circle'],
                                            'rejected' => ['bg' => 'bg-red-500/20', 'text' => 'text-red-400', 'border' => 'border-red-500/30', 'icon' => 'fa-times-circle'],
                                        ];
                                        $config = $statusConfig[$withdrawal->status] ?? $statusConfig['pending'];
                                    @endphp
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $config['bg'] }} {{ $config['text'] }} border {{ $config['border'] }}">
                                        <i class="fas {{ $config['icon'] }} mr-1"></i>
                                        {{ ucfirst($withdrawal->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-400">
                                    {{ $withdrawal->created_at->locale('id')->isoFormat('D MMM Y, HH:mm') }}
                                </td>
                                <td class="px-6 py-4">
                                    @if($withdrawal->status === 'pending')
                                        <div class="flex items-center justify-center gap-2">
                                            {{-- Approve Button --}}
                                            <form action="{{ route('admin.withdrawals.approve', $withdrawal) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" onclick="return confirm('Setujui penarikan ini? Pajak Rp {{ number_format($withdrawal->pajak_nominal, 0, ',', '.') }} akan masuk ke kas admin.')"
                                                        class="w-10 h-10 bg-emerald-500/20 text-emerald-400 border border-emerald-500/30 rounded-xl hover:bg-emerald-500/30 transition-colors flex items-center justify-center"
                                                        title="Setujui">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </form>
                                            
                                            {{-- Reject Button --}}
                                            <button @click="showReject = true"
                                                    class="w-10 h-10 bg-red-500/20 text-red-400 border border-red-500/30 rounded-xl hover:bg-red-500/30 transition-colors flex items-center justify-center"
                                                    title="Tolak">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>

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
                                    @else
                                        <div class="flex items-center justify-center">
                                            <a href="{{ route('admin.withdrawals.show', $withdrawal) }}"
                                               class="w-10 h-10 bg-blue-500/20 text-blue-400 border border-blue-500/30 rounded-xl hover:bg-blue-500/30 transition-colors flex items-center justify-center"
                                               title="Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="px-6 py-12 text-center">
                                    <div class="w-16 h-16 bg-slate-800 rounded-full flex items-center justify-center mx-auto mb-4">
                                        <i class="fas fa-hand-holding-usd text-2xl text-slate-600"></i>
                                    </div>
                                    <p class="text-slate-400 font-medium">Tidak ada data penarikan</p>
                                    <p class="text-sm text-slate-600 mt-1">Penarikan dari kantin akan muncul di sini</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($withdrawals->hasPages())
                <div class="px-6 py-4 border-t border-slate-700/50">
                    {{ $withdrawals->withQueryString()->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
