{{--
==========================================================================
KANTIN - PENARIKAN TUNAI
==========================================================================
Halaman untuk penjaga kantin melakukan penarikan pendapatan.
Setiap penarikan dikenakan pajak yang masuk ke admin.
==========================================================================
--}}

@extends('layouts.app')

@section('title', 'Penarikan Tunai - Kantin')

@section('content')
<div class="min-h-screen hero-gradient py-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
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
                <div>
                    <h1 class="text-3xl font-extrabold text-white">
                        Penarikan <span class="gradient-text">Tunai</span>
                    </h1>
                    <p class="mt-1 text-slate-400">Tarik pendapatan kantin Anda</p>
                </div>
                <a href="{{ route('kantin.dashboard') }}" class="mt-4 md:mt-0 inline-flex items-center px-4 py-2 glass rounded-xl text-slate-300 hover:text-orange-400 hover:bg-white/10 transition-all">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali ke Dashboard
                </a>
            </div>
        </div>

        {{-- Summary Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            {{-- Total Pendapatan --}}
            <div class="glass-card rounded-2xl p-6 hover:bg-white/5 transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-emerald-500 to-green-600 rounded-2xl flex items-center justify-center shadow-lg shadow-emerald-500/20">
                        <i class="fas fa-coins text-xl text-white"></i>
                    </div>
                </div>
                <p class="text-sm font-medium text-slate-400 mb-1">Total Pendapatan</p>
                <p class="text-2xl font-extrabold text-emerald-400">
                    Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
                </p>
            </div>

            {{-- Sudah Ditarik --}}
            <div class="glass-card rounded-2xl p-6 hover:bg-white/5 transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl flex items-center justify-center shadow-lg shadow-blue-500/20">
                        <i class="fas fa-hand-holding-usd text-xl text-white"></i>
                    </div>
                </div>
                <p class="text-sm font-medium text-slate-400 mb-1">Sudah Ditarik</p>
                <p class="text-2xl font-extrabold text-blue-400">
                    Rp {{ number_format($totalWithdrawn, 0, ',', '.') }}
                </p>
            </div>

            {{-- Saldo Tersedia --}}
            <div class="relative rounded-2xl p-6 overflow-hidden bg-gradient-to-br from-orange-500/20 to-amber-500/20 border border-orange-500/30">
                <div class="absolute inset-0 bg-gradient-to-br from-orange-500/10 to-amber-500/10"></div>
                <div class="relative">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-orange-500 to-amber-500 rounded-2xl flex items-center justify-center shadow-lg shadow-orange-500/30">
                            <i class="fas fa-wallet text-xl text-white"></i>
                        </div>
                    </div>
                    <p class="text-sm font-medium text-orange-300 mb-1">Saldo Tersedia</p>
                    <p class="text-2xl font-extrabold text-orange-400">
                        Rp {{ number_format($saldoTersedia, 0, ',', '.') }}
                    </p>
                </div>
            </div>

            {{-- Pending --}}
            <div class="glass-card rounded-2xl p-6 hover:bg-white/5 transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-yellow-500 to-amber-600 rounded-2xl flex items-center justify-center shadow-lg shadow-yellow-500/20">
                        <i class="fas fa-clock text-xl text-white"></i>
                    </div>
                </div>
                <p class="text-sm font-medium text-slate-400 mb-1">Menunggu Approval</p>
                <p class="text-2xl font-extrabold text-yellow-400">
                    Rp {{ number_format($pendingWithdrawals, 0, ',', '.') }}
                </p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Form Penarikan --}}
            <div class="lg:col-span-1">
                <div class="glass-card rounded-2xl p-6" x-data="withdrawalForm()">
                    <h2 class="text-xl font-bold text-white mb-6 flex items-center">
                        <div class="w-10 h-10 bg-gradient-to-br from-orange-500 to-amber-500 rounded-xl flex items-center justify-center mr-3 shadow-lg shadow-orange-500/20">
                            <i class="fas fa-money-bill-wave text-white"></i>
                        </div>
                        Ajukan Penarikan
                    </h2>

                    <form action="{{ route('kantin.withdrawals.store') }}" method="POST" @submit="loading = true">
                        @csrf

                        {{-- Jumlah --}}
                        <div class="mb-6">
                            <label class="block text-sm font-semibold text-slate-300 mb-2">
                                Jumlah Penarikan
                            </label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-500 font-medium">Rp</span>
                                <input type="number" name="jumlah" x-model="jumlah" @input="calculateNet()"
                                       min="10000" max="{{ $saldoTersedia }}"
                                       class="w-full pl-12 pr-4 py-3 rounded-xl bg-slate-800/50 border border-slate-700 text-white placeholder-slate-500 focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 transition-all"
                                       placeholder="Minimal 10.000">
                            </div>
                            <p class="mt-2 text-xs text-slate-500">
                                <i class="fas fa-info-circle mr-1"></i>
                                Maksimal: Rp {{ number_format($saldoTersedia, 0, ',', '.') }}
                            </p>
                        </div>

                        {{-- Preview Pajak --}}
                        <div class="mb-6 p-4 bg-slate-800/50 rounded-xl border border-slate-700">
                            <div class="flex justify-between text-sm mb-2">
                                <span class="text-slate-400">Jumlah Penarikan</span>
                                <span class="font-medium text-white" x-text="'Rp ' + formatNumber(jumlah || 0)"></span>
                            </div>
                            <div class="flex justify-between text-sm mb-2">
                                <span class="text-slate-400">Pajak ({{ $pajakWithdrawal }}%)</span>
                                <span class="font-medium text-red-400" x-text="'- Rp ' + formatNumber(pajakNominal)"></span>
                            </div>
                            <div class="border-t border-slate-700 pt-2 mt-2">
                                <div class="flex justify-between">
                                    <span class="font-semibold text-slate-300">Yang Anda Terima</span>
                                    <span class="font-bold text-lg text-emerald-400" x-text="'Rp ' + formatNumber(jumlahBersih)"></span>
                                </div>
                            </div>
                        </div>

                        {{-- Metode Pembayaran --}}
                        <div class="mb-6">
                            <label class="block text-sm font-semibold text-slate-300 mb-2">
                                Metode Pembayaran
                            </label>
                            <div class="grid grid-cols-2 gap-3">
                                <label class="relative cursor-pointer">
                                    <input type="radio" name="metode_pembayaran" value="transfer" x-model="metode" class="peer sr-only">
                                    <div class="p-4 rounded-xl border border-slate-700 bg-slate-800/30 peer-checked:border-orange-500 peer-checked:bg-orange-500/10 transition-all text-center">
                                        <i class="fas fa-university text-xl text-slate-400 peer-checked:text-orange-400 mb-2 block"></i>
                                        <span class="text-sm font-medium text-slate-300">Transfer Bank</span>
                                    </div>
                                </label>
                                <label class="relative cursor-pointer">
                                    <input type="radio" name="metode_pembayaran" value="cash" x-model="metode" class="peer sr-only">
                                    <div class="p-4 rounded-xl border border-slate-700 bg-slate-800/30 peer-checked:border-orange-500 peer-checked:bg-orange-500/10 transition-all text-center">
                                        <i class="fas fa-money-bill text-xl text-slate-400 peer-checked:text-orange-400 mb-2 block"></i>
                                        <span class="text-sm font-medium text-slate-300">Tunai</span>
                                    </div>
                                </label>
                            </div>
                        </div>

                        {{-- Detail Bank (jika transfer) --}}
                        <div x-show="metode === 'transfer'" x-transition class="space-y-4 mb-6">
                            <div>
                                <label class="block text-sm font-semibold text-slate-300 mb-2">Nama Bank</label>
                                <select name="nama_bank" class="w-full px-4 py-3 rounded-xl bg-slate-800/50 border border-slate-700 text-white focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 transition-all">
                                    <option value="" class="bg-slate-800">Pilih Bank</option>
                                    <option value="BCA" class="bg-slate-800">BCA</option>
                                    <option value="BNI" class="bg-slate-800">BNI</option>
                                    <option value="BRI" class="bg-slate-800">BRI</option>
                                    <option value="Mandiri" class="bg-slate-800">Mandiri</option>
                                    <option value="CIMB" class="bg-slate-800">CIMB Niaga</option>
                                    <option value="Danamon" class="bg-slate-800">Danamon</option>
                                    <option value="BSI" class="bg-slate-800">BSI</option>
                                    <option value="Permata" class="bg-slate-800">Permata</option>
                                    <option value="DANA" class="bg-slate-800">DANA</option>
                                    <option value="OVO" class="bg-slate-800">OVO</option>
                                    <option value="GoPay" class="bg-slate-800">GoPay</option>
                                    <option value="ShopeePay" class="bg-slate-800">ShopeePay</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-300 mb-2">Nomor Rekening</label>
                                <input type="text" name="nomor_rekening" 
                                       class="w-full px-4 py-3 rounded-xl bg-slate-800/50 border border-slate-700 text-white placeholder-slate-500 focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 transition-all"
                                       placeholder="Masukkan nomor rekening">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-300 mb-2">Atas Nama</label>
                                <input type="text" name="atas_nama" 
                                       class="w-full px-4 py-3 rounded-xl bg-slate-800/50 border border-slate-700 text-white placeholder-slate-500 focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 transition-all"
                                       placeholder="Nama pemilik rekening">
                            </div>
                        </div>

                        {{-- Submit --}}
                        <button type="submit" :disabled="loading || jumlah < 10000 || jumlah > {{ $saldoTersedia }}"
                                class="btn-glow w-full py-4 bg-gradient-to-r from-orange-500 to-amber-500 text-white font-bold rounded-xl shadow-lg shadow-orange-500/30 hover:shadow-orange-500/50 hover:-translate-y-0.5 transition-all disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:translate-y-0 flex items-center justify-center">
                            <template x-if="loading">
                                <svg class="animate-spin h-5 w-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </template>
                            <i class="fas fa-paper-plane mr-2" x-show="!loading"></i>
                            <span x-text="loading ? 'Memproses...' : 'Ajukan Penarikan'"></span>
                        </button>
                    </form>
                </div>

                {{-- Info Pajak --}}
                <div class="mt-6 glass rounded-2xl p-6 border border-blue-500/30 bg-blue-500/5">
                    <div class="flex items-start">
                        <div class="w-10 h-10 bg-blue-500 rounded-xl flex items-center justify-center mr-4 flex-shrink-0">
                            <i class="fas fa-info-circle text-white"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-blue-400 mb-2">Informasi Pajak Penarikan</h3>
                            <ul class="text-sm text-blue-300/80 space-y-1">
                                <li><i class="fas fa-check mr-2 text-blue-400"></i>Pajak penarikan: {{ $pajakWithdrawal }}%</li>
                                <li><i class="fas fa-check mr-2 text-blue-400"></i>Pajak akan dipotong otomatis</li>
                                <li><i class="fas fa-check mr-2 text-blue-400"></i>Hasil pajak masuk ke admin</li>
                                <li><i class="fas fa-check mr-2 text-blue-400"></i>Minimal penarikan Rp 10.000</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Riwayat Penarikan --}}
            <div class="lg:col-span-2">
                <div class="glass-card rounded-2xl overflow-hidden">
                    <div class="bg-gradient-to-r from-slate-800 to-slate-700 px-6 py-4 border-b border-slate-700">
                        <h2 class="text-lg font-bold text-white flex items-center">
                            <i class="fas fa-history mr-2 text-orange-400"></i> Riwayat Penarikan
                        </h2>
                    </div>

                    <div class="divide-y divide-slate-700/50">
                        @forelse($withdrawalHistory as $withdrawal)
                            <div class="p-6 hover:bg-white/5 transition-colors">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <div class="flex items-center gap-3 mb-2">
                                            <span class="font-bold text-white font-mono">{{ $withdrawal->kode_withdrawal }}</span>
                                            @php $badge = $withdrawal->status_badge; @endphp
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium 
                                                @if($withdrawal->status === 'pending') bg-yellow-500/20 text-yellow-400 border border-yellow-500/30
                                                @elseif($withdrawal->status === 'approved') bg-emerald-500/20 text-emerald-400 border border-emerald-500/30
                                                @else bg-red-500/20 text-red-400 border border-red-500/30
                                                @endif">
                                                <i class="fas {{ $badge['icon'] }} mr-1"></i>
                                                {{ ucfirst($withdrawal->status) }}
                                            </span>
                                        </div>
                                        
                                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm mb-3">
                                            <div>
                                                <p class="text-slate-500">Jumlah</p>
                                                <p class="font-semibold text-white">Rp {{ number_format($withdrawal->jumlah, 0, ',', '.') }}</p>
                                            </div>
                                            <div>
                                                <p class="text-slate-500">Pajak ({{ $withdrawal->pajak_persen }}%)</p>
                                                <p class="font-semibold text-red-400">- Rp {{ number_format($withdrawal->pajak_nominal, 0, ',', '.') }}</p>
                                            </div>
                                            <div>
                                                <p class="text-slate-500">Diterima</p>
                                                <p class="font-semibold text-emerald-400">Rp {{ number_format($withdrawal->jumlah_bersih, 0, ',', '.') }}</p>
                                            </div>
                                            <div>
                                                <p class="text-slate-500">Metode</p>
                                                <p class="font-semibold text-white">
                                                    @if($withdrawal->metode_pembayaran === 'transfer')
                                                        {{ $withdrawal->nama_bank }}
                                                    @else
                                                        Tunai
                                                    @endif
                                                </p>
                                            </div>
                                        </div>

                                        <div class="flex items-center text-xs text-slate-500">
                                            <i class="fas fa-clock mr-1"></i>
                                            {{ $withdrawal->created_at->locale('id')->isoFormat('D MMM Y, HH:mm') }}
                                            @if($withdrawal->approved_at && $withdrawal->approver)
                                                <span class="mx-2">•</span>
                                                <span>{{ $withdrawal->status === 'approved' ? 'Disetujui' : 'Ditolak' }} oleh {{ $withdrawal->approver->name }}</span>
                                            @endif
                                        </div>

                                        @if($withdrawal->catatan)
                                            <div class="mt-2 p-2 bg-slate-800/50 rounded-lg text-sm text-slate-400 border border-slate-700">
                                                <i class="fas fa-comment mr-1"></i> {{ $withdrawal->catatan }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="p-12 text-center">
                                <div class="w-16 h-16 bg-slate-800 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i class="fas fa-hand-holding-usd text-2xl text-slate-600"></i>
                                </div>
                                <p class="text-slate-400 font-medium">Belum ada riwayat penarikan</p>
                                <p class="text-sm text-slate-600 mt-1">Ajukan penarikan pertama Anda</p>
                            </div>
                        @endforelse
                    </div>

                    @if($withdrawalHistory->hasPages())
                        <div class="px-6 py-4 border-t border-slate-700">
                            {{ $withdrawalHistory->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function withdrawalForm() {
    return {
        jumlah: '',
        metode: 'transfer',
        pajakPersen: {{ $pajakWithdrawal }},
        pajakNominal: 0,
        jumlahBersih: 0,
        loading: false,

        calculateNet() {
            const amount = parseFloat(this.jumlah) || 0;
            this.pajakNominal = amount * (this.pajakPersen / 100);
            this.jumlahBersih = amount - this.pajakNominal;
        },

        formatNumber(num) {
            return new Intl.NumberFormat('id-ID').format(Math.round(num));
        }
    }
}
</script>
@endsection
