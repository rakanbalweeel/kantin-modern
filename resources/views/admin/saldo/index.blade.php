{{--
==========================================================================
ADMIN - KELOLA TOP UP SALDO
==========================================================================
Halaman ini menampilkan semua request top up dari siswa untuk disetujui/ditolak admin.
==========================================================================
--}}

@extends('layouts.app')

@section('title', 'Kelola Top Up Saldo')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Header --}}
        <div class="mb-8">
            <h1 class="text-3xl font-extrabold bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-500 bg-clip-text text-transparent">
                Kelola Top Up Saldo
            </h1>
            <p class="mt-2 text-gray-500">Setujui atau tolak permintaan top up dari siswa</p>
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

        {{-- Stats Cards --}}
        @php
            $pendingCount = \DB::table('topup_requests')->where('status', 'pending')->count();
            $approvedToday = \DB::table('topup_requests')
                ->where('status', 'approved')
                ->whereDate('approved_at', today())
                ->sum('jumlah');
        @endphp
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-white/50 p-6">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-amber-100 rounded-xl flex items-center justify-center mr-4">
                        <i class="fas fa-clock text-amber-600 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Menunggu Persetujuan</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $pendingCount }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-white/50 p-6">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center mr-4">
                        <i class="fas fa-check-circle text-green-600 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Disetujui Hari Ini</p>
                        <p class="text-2xl font-bold text-gray-800">Rp {{ number_format($approvedToday, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-white/50 p-6">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-indigo-100 rounded-xl flex items-center justify-center mr-4">
                        <i class="fas fa-wallet text-indigo-600 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Total Siswa</p>
                        <p class="text-2xl font-bold text-gray-800">{{ \App\Models\User::where('role', 'siswa')->count() }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Table --}}
        <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-white/50 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100">
                <h2 class="text-lg font-bold text-gray-800 flex items-center">
                    <i class="fas fa-list mr-3 text-indigo-600"></i>
                    Daftar Request Top Up
                </h2>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Siswa</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Jumlah</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Tanggal</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($requests as $request)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex items-center justify-center text-white font-bold mr-3">
                                            {{ strtoupper(substr($request->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="font-semibold text-gray-800">{{ $request->name }}</p>
                                            <p class="text-sm text-gray-500">{{ $request->email }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-lg font-bold text-gray-800">Rp {{ number_format($request->jumlah, 0, ',', '.') }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="text-gray-800">{{ \Carbon\Carbon::parse($request->created_at)->format('d M Y') }}</p>
                                    <p class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($request->created_at)->format('H:i') }}</p>
                                </td>
                                <td class="px-6 py-4">
                                    @if($request->status === 'pending')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-700">
                                            <i class="fas fa-clock mr-1.5"></i>Menunggu
                                        </span>
                                    @elseif($request->status === 'approved')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700">
                                            <i class="fas fa-check mr-1.5"></i>Disetujui
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-700">
                                            <i class="fas fa-times mr-1.5"></i>Ditolak
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if($request->status === 'pending')
                                        <div class="flex items-center justify-center space-x-2">
                                            <form action="{{ route('admin.saldo.approve', $request->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" 
                                                        onclick="return confirm('Setujui top up ini?')"
                                                        class="px-4 py-2 bg-green-500 hover:bg-green-600 text-white rounded-lg font-medium transition-colors">
                                                    <i class="fas fa-check mr-1"></i>Setujui
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.saldo.reject', $request->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" 
                                                        onclick="return confirm('Tolak top up ini?')"
                                                        class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg font-medium transition-colors">
                                                    <i class="fas fa-times mr-1"></i>Tolak
                                                </button>
                                            </form>
                                        </div>
                                    @else
                                        <span class="text-gray-400 text-sm">Sudah diproses</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center">
                                    <div class="text-gray-400">
                                        <i class="fas fa-inbox text-5xl mb-4"></i>
                                        <p class="text-lg font-medium">Belum ada request top up</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($requests->hasPages())
                <div class="px-6 py-4 border-t border-gray-100">
                    {{ $requests->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
