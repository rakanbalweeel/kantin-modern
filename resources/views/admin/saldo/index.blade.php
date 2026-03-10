{{--
==========================================================================
KELOLA SALDO SISWA - DARK THEME
==========================================================================
--}}

@extends('layouts.app')

@section('title', 'Kelola Saldo Siswa')

@section('content')
<div class="min-h-screen hero-gradient py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Success/Error Messages --}}
        @if(session('success'))
            <div class="mb-6 glass bg-emerald-500/10 border-emerald-500/30 text-emerald-400 px-6 py-4 rounded-2xl flex items-center" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)">
                <i class="fas fa-check-circle mr-3 text-xl"></i>
                <span class="font-medium flex-1">{{ session('success') }}</span>
                <button @click="show = false" class="text-emerald-400 hover:text-emerald-300"><i class="fas fa-times"></i></button>
            </div>
        @endif
        @if(session('error'))
            <div class="mb-6 glass bg-red-500/10 border-red-500/30 text-red-400 px-6 py-4 rounded-2xl flex items-center" x-data="{ show: true }" x-show="show">
                <i class="fas fa-exclamation-circle mr-3 text-xl"></i>
                <span class="font-medium flex-1">{{ session('error') }}</span>
                <button @click="show = false" class="text-red-400 hover:text-red-300"><i class="fas fa-times"></i></button>
            </div>
        @endif

        {{-- Header --}}
        <div class="mb-8">
            <div class="flex items-center">
                <div class="w-14 h-14 bg-gradient-to-br from-orange-500 to-amber-500 rounded-2xl flex items-center justify-center shadow-lg shadow-orange-500/20 mr-4">
                    <i class="fas fa-wallet text-white text-xl"></i>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-white">Kelola <span class="gradient-text">Saldo</span></h1>
                    <p class="text-slate-400 mt-1">Kelola saldo siswa dan request top-up</p>
                </div>
            </div>
        </div>

        {{-- Stats --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="glass-card rounded-2xl p-6 hover:bg-white/5 transition-all">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-400 mb-1">Total Siswa</p>
                        <p class="text-2xl font-bold text-white">{{ $students->total() }}</p>
                    </div>
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center">
                        <i class="fas fa-users text-white"></i>
                    </div>
                </div>
            </div>
            <div class="glass-card rounded-2xl p-6 hover:bg-white/5 transition-all">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-400 mb-1">Pending Top-up</p>
                        <p class="text-2xl font-bold text-yellow-400">{{ $pendingTopups ?? 0 }}</p>
                    </div>
                    <div class="w-12 h-12 bg-gradient-to-br from-yellow-500 to-amber-600 rounded-xl flex items-center justify-center">
                        <i class="fas fa-clock text-white"></i>
                    </div>
                </div>
            </div>
            <div class="glass-card rounded-2xl p-6 hover:bg-white/5 transition-all">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-400 mb-1">Total Saldo</p>
                        <p class="text-2xl font-bold text-emerald-400">Rp {{ number_format($totalSaldo ?? 0, 0, ',', '.') }}</p>
                    </div>
                    <div class="w-12 h-12 bg-gradient-to-br from-emerald-500 to-green-600 rounded-xl flex items-center justify-center">
                        <i class="fas fa-coins text-white"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Search --}}
        <div class="glass-card rounded-2xl p-6 mb-6">
            <form action="{{ route('admin.saldo.index') }}" method="GET" class="flex flex-wrap gap-4 items-end">
                <div class="flex-1 min-w-[250px]">
                    <label class="text-sm font-medium text-slate-300 mb-2 block">Cari Siswa</label>
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="Nama atau email siswa..."
                           class="w-full px-4 py-3 bg-slate-800/50 border border-slate-700 rounded-xl text-white placeholder-slate-500 focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 transition-all">
                </div>
                <button type="submit" class="px-6 py-3 bg-gradient-to-r from-orange-500 to-amber-500 text-white font-semibold rounded-xl shadow-lg shadow-orange-500/20 hover:shadow-orange-500/40 transition-all">
                    <i class="fas fa-search mr-2"></i> Cari
                </button>
            </form>
        </div>

        {{-- Students Table --}}
        <div class="glass-card rounded-2xl overflow-hidden">
            <div class="bg-gradient-to-r from-orange-500 to-amber-500 px-6 py-4">
                <h2 class="text-lg font-bold text-white flex items-center">
                    <i class="fas fa-list mr-2"></i> Daftar Siswa
                </h2>
            </div>
            
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="bg-slate-800/50">
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-400 uppercase">Siswa</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-400 uppercase">Saldo</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-slate-400 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-700/50">
                        @forelse($students as $student)
                            <tr class="hover:bg-white/5 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-gradient-to-br from-orange-500 to-amber-500 rounded-xl flex items-center justify-center mr-3">
                                            <span class="text-white font-bold text-sm">{{ strtoupper(substr($student->name, 0, 1)) }}</span>
                                        </div>
                                        <div>
                                            <p class="font-medium text-white">{{ $student->name }}</p>
                                            <p class="text-xs text-slate-500">{{ $student->email }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="font-bold text-emerald-400">Rp {{ number_format($student->saldo, 0, ',', '.') }}</span>
                                </td>
                                <td class="px-6 py-4 text-center" x-data="{ showModal: false, amount: '' }">
                                    <button @click="showModal = true" class="px-4 py-2 bg-gradient-to-r from-orange-500 to-amber-500 text-white rounded-xl shadow-lg shadow-orange-500/20 hover:shadow-orange-500/40 transition-all">
                                        <i class="fas fa-plus mr-2"></i> Top Up
                                    </button>
                                    
                                    {{-- Modal --}}
                                    <div x-show="showModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/70 backdrop-blur-sm" @click.self="showModal = false">
                                        <div class="glass-card rounded-2xl max-w-md w-full p-6" @click.stop>
                                            <h3 class="text-xl font-bold text-white mb-4">Top Up Saldo</h3>
                                            <p class="text-slate-400 mb-4">{{ $student->name }}</p>
                                            <form action="{{ route('admin.saldo.topup', $student) }}" method="POST">
                                                @csrf
                                                <div class="mb-4">
                                                    <label class="block text-sm font-medium text-slate-300 mb-2">Jumlah Top Up</label>
                                                    <div class="relative">
                                                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-500">Rp</span>
                                                        <input type="number" name="amount" x-model="amount" min="1000" class="w-full pl-12 pr-4 py-3 bg-slate-800/50 border border-slate-700 rounded-xl text-white focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20" placeholder="0" required>
                                                    </div>
                                                </div>
                                                <div class="flex gap-3">
                                                    <button type="button" @click="showModal = false" class="flex-1 px-4 py-3 bg-slate-700 text-slate-300 rounded-xl hover:bg-slate-600 transition">Batal</button>
                                                    <button type="submit" class="flex-1 px-4 py-3 bg-gradient-to-r from-orange-500 to-amber-500 text-white rounded-xl shadow-lg hover:shadow-orange-500/40 transition">Top Up</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-12 text-center">
                                    <div class="w-16 h-16 bg-slate-800 rounded-full flex items-center justify-center mx-auto mb-4">
                                        <i class="fas fa-users text-2xl text-slate-600"></i>
                                    </div>
                                    <p class="text-slate-400 font-medium">Tidak ada siswa ditemukan</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($students->hasPages())
                <div class="px-6 py-4 border-t border-slate-700">
                    {{ $students->withQueryString()->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
