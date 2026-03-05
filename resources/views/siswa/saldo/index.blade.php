{{--
==========================================================================
SISWA - SALDO VIRTUAL
==========================================================================
Halaman ini menampilkan informasi saldo dan riwayat top up siswa.
==========================================================================
--}}

@extends('layouts.app')

@section('title', 'Saldo Virtual')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Header --}}
        <div class="mb-8 text-center">
            <h1 class="text-3xl font-extrabold bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-500 bg-clip-text text-transparent">
                Saldo Virtual
            </h1>
            <p class="mt-2 text-gray-500">Kelola saldo virtual kamu di sini</p>
        </div>

        {{-- Alert Messages --}}
        @if(session('success'))
            <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl flex items-center">
                <i class="fas fa-check-circle mr-3"></i>
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl flex items-center">
                <i class="fas fa-exclamation-circle mr-3"></i>
                {{ session('error') }}
            </div>
        @endif

        {{-- Saldo Card --}}
        <div class="relative overflow-hidden bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-500 rounded-3xl shadow-2xl p-8 text-white mb-8"
             x-data="{ showTopup: false, topupAmount: '', topupPresets: [25000, 50000, 100000, 200000] }">
            {{-- Background Pattern --}}
            <div class="absolute top-0 right-0 -mt-8 -mr-8 w-40 h-40 bg-white/10 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 left-0 -mb-8 -ml-8 w-48 h-48 bg-white/10 rounded-full blur-3xl"></div>
            
            <div class="relative flex flex-col md:flex-row md:items-center md:justify-between">
                <div class="flex items-center mb-6 md:mb-0">
                    <div class="w-16 h-16 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center mr-5 shadow-lg">
                        <i class="fas fa-wallet text-3xl"></i>
                    </div>
                    <div>
                        <p class="text-white/70 text-sm font-medium mb-1">Saldo Virtual Kamu</p>
                        <h2 class="text-4xl font-bold tracking-tight">Rp {{ number_format($user->saldo ?? 0, 0, ',', '.') }}</h2>
                    </div>
                </div>
                <button @click="showTopup = !showTopup" 
                        class="px-6 py-3 bg-white/20 hover:bg-white/30 backdrop-blur-sm rounded-xl font-semibold transition-all duration-300 flex items-center justify-center">
                    <i class="fas fa-plus-circle mr-2"></i>
                    Top Up Saldo
                </button>
            </div>
            
            {{-- Top Up Form --}}
            <div x-show="showTopup" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 -translate-y-4"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 class="relative mt-8 pt-6 border-t border-white/20">
                <form action="{{ route('siswa.saldo.topup') }}" method="POST" class="space-y-4">
                    @csrf
                    <p class="font-medium mb-3">Pilih Nominal Top Up:</p>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-4">
                        <template x-for="preset in topupPresets" :key="preset">
                            <button type="button" 
                                    @click="topupAmount = preset"
                                    :class="topupAmount == preset ? 'bg-white text-indigo-600' : 'bg-white/20 hover:bg-white/30'"
                                    class="px-4 py-3 rounded-xl font-semibold transition-all duration-200">
                                <span x-text="'Rp ' + new Intl.NumberFormat('id-ID').format(preset)"></span>
                            </button>
                        </template>
                    </div>
                    <div class="flex flex-col md:flex-row gap-3">
                        <div class="flex-1">
                            <input type="number" 
                                   name="jumlah" 
                                   x-model="topupAmount"
                                   min="10000" 
                                   max="1000000"
                                   placeholder="Masukkan nominal lain (min Rp 10.000)"
                                   class="w-full px-4 py-3 bg-white/20 border border-white/30 rounded-xl placeholder-white/50 text-white focus:bg-white/30 focus:outline-none transition-all"
                                   required>
                        </div>
                        <button type="submit" 
                                :disabled="!topupAmount || topupAmount < 10000"
                                :class="(!topupAmount || topupAmount < 10000) ? 'bg-white/30 cursor-not-allowed' : 'bg-white hover:bg-white/90 text-indigo-600'"
                                class="px-6 py-3 rounded-xl font-semibold transition-all duration-300">
                            <i class="fas fa-paper-plane mr-2"></i>Ajukan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Riwayat Top Up --}}
        <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-white/50 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100">
                <h2 class="text-lg font-bold text-gray-800 flex items-center">
                    <i class="fas fa-history mr-3 text-indigo-600"></i>
                    Riwayat Top Up
                </h2>
            </div>
            
            <div class="divide-y divide-gray-100">
                @forelse($riwayatTopup as $topup)
                    <div class="px-6 py-4 flex items-center justify-between hover:bg-gray-50 transition-colors">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center mr-4
                                @if($topup->status === 'pending') bg-amber-100 text-amber-600
                                @elseif($topup->status === 'approved') bg-green-100 text-green-600
                                @else bg-red-100 text-red-600 @endif">
                                <i class="fas 
                                    @if($topup->status === 'pending') fa-clock
                                    @elseif($topup->status === 'approved') fa-check
                                    @else fa-times @endif"></i>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-800">Rp {{ number_format($topup->jumlah, 0, ',', '.') }}</p>
                                <p class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($topup->created_at)->format('d M Y, H:i') }}</p>
                            </div>
                        </div>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold
                            @if($topup->status === 'pending') bg-amber-100 text-amber-700
                            @elseif($topup->status === 'approved') bg-green-100 text-green-700
                            @else bg-red-100 text-red-700 @endif">
                            @if($topup->status === 'pending')
                                <i class="fas fa-clock mr-1.5"></i>Menunggu
                            @elseif($topup->status === 'approved')
                                <i class="fas fa-check mr-1.5"></i>Disetujui
                            @else
                                <i class="fas fa-times mr-1.5"></i>Ditolak
                            @endif
                        </span>
                    </div>
                @empty
                    <div class="px-6 py-12 text-center text-gray-400">
                        <i class="fas fa-inbox text-5xl mb-4"></i>
                        <p class="text-lg font-medium">Belum ada riwayat top up</p>
                        <p class="text-sm">Ajukan top up pertamamu!</p>
                    </div>
                @endforelse
            </div>
        </div>
        
        {{-- Info --}}
        <div class="mt-6 bg-blue-50 border border-blue-200 rounded-xl p-4">
            <div class="flex items-start">
                <i class="fas fa-info-circle text-blue-500 mt-0.5 mr-3"></i>
                <div class="text-sm text-blue-700">
                    <p class="font-semibold mb-1">Cara Top Up Saldo:</p>
                    <ol class="list-decimal list-inside space-y-1 text-blue-600">
                        <li>Klik tombol "Top Up Saldo" dan pilih nominal</li>
                        <li>Hubungi admin di kantin untuk pembayaran</li>
                        <li>Setelah admin menyetujui, saldo otomatis bertambah</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
