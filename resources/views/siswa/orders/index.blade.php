{{--
==========================================================================
RIWAYAT PESANAN - SISWA
==========================================================================
Halaman ini menampilkan semua pesanan yang pernah dibuat oleh siswa.
Siswa dapat melihat status, detail, dan membatalkan pesanan jika masih pending.
==========================================================================
--}}

@extends('layouts.app')

@section('title', 'Riwayat Pesanan')

@section('content')
<div class="py-6">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Header --}}
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Riwayat Pesanan</h1>
            <p class="mt-1 text-gray-600">Lihat semua pesanan yang pernah kamu buat</p>
        </div>

        {{-- Orders List --}}
        <div class="space-y-4">
            @forelse($orders as $order)
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    {{-- Order Header --}}
                    <div class="p-4 bg-gray-50 border-b border-gray-100 flex items-center justify-between">
                        <div>
                            <span class="font-bold text-gray-900">{{ $order->kode_pesanan }}</span>
                            <span class="text-sm text-gray-500 ml-2">
                                {{ $order->created_at->format('d M Y H:i') }}
                            </span>
                        </div>
                        @php
                            $statusColors = [
                                'pending' => 'bg-yellow-100 text-yellow-800',
                                'diproses' => 'bg-blue-100 text-blue-800',
                                'selesai' => 'bg-green-100 text-green-800',
                                'batal' => 'bg-red-100 text-red-800',
                            ];
                            $statusIcons = [
                                'pending' => '⏳',
                                'diproses' => '🔄',
                                'selesai' => '✅',
                                'batal' => '❌',
                            ];
                        @endphp
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $statusColors[$order->status] ?? 'bg-gray-100 text-gray-800' }}">
                            {{ $statusIcons[$order->status] ?? '' }} {{ ucfirst($order->status) }}
                        </span>
                    </div>

                    {{-- Order Items --}}
                    <div class="p-4">
                        <div class="space-y-2">
                            @foreach($order->orderDetails->take(3) as $detail)
                                <div class="flex justify-between items-center">
                                    <div class="flex items-center">
                                        @if($detail->product->gambar)
                                            <img src="{{ Storage::url($detail->product->gambar) }}" 
                                                 alt="{{ $detail->product->nama }}"
                                                 class="w-10 h-10 rounded-lg object-cover">
                                        @else
                                            <div class="w-10 h-10 rounded-lg bg-gray-100 flex items-center justify-center">
                                                <span>🍽️</span>
                                            </div>
                                        @endif
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-gray-900">{{ $detail->product->nama }}</p>
                                            <p class="text-xs text-gray-500">{{ $detail->jumlah }} x Rp {{ number_format($detail->harga, 0, ',', '.') }}</p>
                                        </div>
                                    </div>
                                    <span class="text-sm font-medium text-gray-900">
                                        Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                                    </span>
                                </div>
                            @endforeach
                            @if($order->orderDetails->count() > 3)
                                <p class="text-sm text-gray-500 italic">
                                    +{{ $order->orderDetails->count() - 3 }} item lainnya
                                </p>
                            @endif
                        </div>
                    </div>

                    {{-- Order Footer --}}
                    <div class="px-4 py-3 bg-gray-50 border-t border-gray-100 flex items-center justify-between">
                        <div>
                            <span class="text-sm text-gray-500">Total: </span>
                            <span class="text-lg font-bold text-indigo-600">
                                Rp {{ number_format($order->total, 0, ',', '.') }}
                            </span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <a href="{{ route('siswa.orders.show', $order) }}" 
                               class="px-4 py-2 text-indigo-600 hover:text-indigo-700 font-medium">
                                Lihat Detail
                            </a>
                            @if($order->status === 'pending')
                                <form action="{{ route('siswa.orders.cancel', $order) }}" 
                                      method="POST"
                                      onsubmit="return confirm('Yakin ingin membatalkan pesanan ini?')">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="px-4 py-2 text-red-600 hover:text-red-700 font-medium">
                                        Batalkan
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-12 text-center">
                    <span class="text-6xl">📋</span>
                    <h2 class="text-2xl font-bold text-gray-900 mt-4">Belum Ada Pesanan</h2>
                    <p class="text-gray-500 mt-2">Kamu belum pernah membuat pesanan</p>
                    <a href="{{ route('siswa.menu') }}" class="inline-flex items-center mt-6 px-6 py-3 bg-indigo-600 text-white rounded-lg font-semibold hover:bg-indigo-700">
                        Pesan Sekarang
                    </a>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        @if($orders->hasPages())
            <div class="mt-8">
                {{ $orders->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
