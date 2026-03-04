{{--
==========================================================================
DETAIL PESANAN / STRUK - SISWA
==========================================================================
Halaman ini menampilkan detail lengkap pesanan dalam format struk/receipt.
==========================================================================
--}}

@extends('layouts.app')

@section('title', 'Detail Pesanan')

@section('content')
<div class="py-6">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Back Button --}}
        <div class="mb-6">
            <a href="{{ route('siswa.orders.index') }}" class="inline-flex items-center text-gray-600 hover:text-gray-900">
                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Kembali ke Riwayat Pesanan
            </a>
        </div>

        {{-- Receipt Card --}}
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
            {{-- Header --}}
            <div class="bg-gradient-to-r from-indigo-600 to-purple-600 p-6 text-white text-center">
                <span class="text-4xl">🍽️</span>
                <h1 class="text-2xl font-bold mt-2">RasaPelajar</h1>
                <p class="text-indigo-100 text-sm">Jl. Pendidikan No. 123</p>
            </div>

            {{-- Order Info --}}
            <div class="p-6 border-b border-gray-200">
                <div class="flex justify-between items-center mb-4">
                    <span class="text-gray-500">No. Pesanan</span>
                    <span class="font-bold text-gray-900">{{ $order->kode_pesanan }}</span>
                </div>
                <div class="flex justify-between items-center mb-4">
                    <span class="text-gray-500">Tanggal</span>
                    <span class="text-gray-900">{{ $order->created_at->format('d M Y H:i') }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-500">Status</span>
                    @php
                        $statusColors = [
                            'pending' => 'bg-yellow-100 text-yellow-800',
                            'diproses' => 'bg-blue-100 text-blue-800',
                            'selesai' => 'bg-green-100 text-green-800',
                            'batal' => 'bg-red-100 text-red-800',
                        ];
                    @endphp
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $statusColors[$order->status] ?? 'bg-gray-100 text-gray-800' }}">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>
            </div>

            {{-- Items --}}
            <div class="p-6 border-b border-gray-200">
                <h3 class="font-bold text-gray-900 mb-4">Detail Pesanan</h3>
                <div class="space-y-3">
                    @foreach($order->orderDetails as $detail)
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="font-medium text-gray-900">{{ $detail->product->nama }}</p>
                                <p class="text-sm text-gray-500">
                                    {{ $detail->jumlah }} x Rp {{ number_format($detail->harga, 0, ',', '.') }}
                                </p>
                            </div>
                            <span class="font-medium text-gray-900">
                                Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Total --}}
            <div class="p-6 bg-gray-50">
                <div class="flex justify-between items-center">
                    <span class="text-xl font-bold text-gray-900">Total</span>
                    <span class="text-2xl font-bold text-indigo-600">
                        Rp {{ number_format($order->total, 0, ',', '.') }}
                    </span>
                </div>
            </div>

            {{-- Catatan --}}
            @if($order->catatan)
                <div class="p-6 border-t border-gray-200">
                    <h3 class="font-bold text-gray-900 mb-2">Catatan</h3>
                    <p class="text-gray-600">{{ $order->catatan }}</p>
                </div>
            @endif

            {{-- Footer --}}
            <div class="p-6 bg-gray-50 text-center border-t border-gray-200">
                <p class="text-gray-500 text-sm">Terima kasih telah memesan!</p>
                @if($order->status === 'pending')
                    <p class="text-yellow-600 text-sm mt-2">
                        ⏳ Pesanan sedang menunggu diproses
                    </p>
                @elseif($order->status === 'diproses')
                    <p class="text-blue-600 text-sm mt-2">
                        🔄 Pesanan sedang diproses, mohon tunggu
                    </p>
                @elseif($order->status === 'selesai')
                    <p class="text-green-600 text-sm mt-2">
                        ✅ Pesanan sudah selesai, silakan ambil!
                    </p>
                @endif
            </div>

            {{-- Actions --}}
            <div class="p-6 border-t border-gray-200 flex justify-center space-x-4">
                @if($order->status === 'pending')
                    <form action="{{ route('siswa.orders.cancel', $order) }}" 
                          method="POST"
                          onsubmit="return confirm('Yakin ingin membatalkan pesanan ini?')">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="px-6 py-2 border border-red-300 text-red-600 rounded-lg hover:bg-red-50">
                            Batalkan Pesanan
                        </button>
                    </form>
                @endif
                <a href="{{ route('siswa.menu') }}" class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                    Pesan Lagi
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
