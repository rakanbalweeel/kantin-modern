{{--
==========================================================================
MENU KANTIN - SISWA
==========================================================================
Halaman ini menampilkan daftar produk yang bisa dipesan siswa.
Menggunakan Alpine.js untuk fitur add to cart.

PENJELASAN ALPINE.JS
--------------------
x-data: Mendefinisikan reactive data dalam component
@click: Event listener untuk click
$store: Global store yang bisa diakses semua component
==========================================================================
--}}

@extends('layouts.app')

@section('title', 'Menu Kantin')

@section('content')
{{-- 
Alpine.js Store untuk Cart
--------------------------
Store ini menyimpan data cart dan bisa diakses dari mana saja.
Data disimpan di localStorage agar tidak hilang saat refresh.
--}}
<div x-data="{
    cart: JSON.parse(localStorage.getItem('kantin_cart') || '[]'),
    
    addToCart(product) {
        const existingIndex = this.cart.findIndex(item => item.id === product.id);
        if (existingIndex !== -1) {
            this.cart[existingIndex].qty++;
        } else {
            this.cart.push({
                id: product.id,
                nama: product.nama,
                harga: product.harga,
                stok: product.stok,
                qty: 1
            });
        }
        this.saveCart();
    },
    
    removeFromCart(productId) {
        this.cart = this.cart.filter(item => item.id !== productId);
        this.saveCart();
    },
    
    updateQty(productId, qty) {
        const item = this.cart.find(item => item.id === productId);
        if (item) {
            if (qty <= 0) {
                this.removeFromCart(productId);
            } else if (qty <= item.stok) {
                item.qty = qty;
                this.saveCart();
            }
        }
    },
    
    saveCart() {
        localStorage.setItem('kantin_cart', JSON.stringify(this.cart));
    },
    
    getTotal() {
        return this.cart.reduce((total, item) => total + (item.harga * item.qty), 0);
    },
    
    getTotalItems() {
        return this.cart.reduce((total, item) => total + item.qty, 0);
    },
    
    formatRupiah(number) {
        return new Intl.NumberFormat('id-ID').format(number);
    }
}" class="min-h-screen bg-gray-50">

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Header --}}
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Menu Kantin</h1>
                <p class="mt-1 text-gray-600">Pilih makanan dan minuman favoritmu!</p>
            </div>

            <div class="flex flex-col lg:flex-row gap-8">
                {{-- Products Grid --}}
                <div class="flex-1">
                    {{-- Category Filter --}}
                    <div class="flex flex-wrap gap-2 mb-6">
                        <a href="{{ route('siswa.menu') }}" 
                           class="px-4 py-2 rounded-full {{ !request('category') ? 'bg-indigo-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-100' }} transition">
                            Semua
                        </a>
                        @foreach($categories as $category)
                            <a href="{{ route('siswa.menu', ['category' => $category->id]) }}" 
                               class="px-4 py-2 rounded-full {{ request('category') == $category->id ? 'bg-indigo-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-100' }} transition">
                                {{ $category->nama }}
                            </a>
                        @endforeach
                    </div>

                    {{-- Products --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse($products as $product)
                            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition">
                                @if($product->gambar)
                                    <img src="{{ Storage::url($product->gambar) }}" 
                                         alt="{{ $product->nama }}"
                                         class="w-full h-48 object-cover">
                                @else
                                    <div class="w-full h-48 bg-gray-100 flex items-center justify-center">
                                        <span class="text-6xl">🍽️</span>
                                    </div>
                                @endif
                                <div class="p-4">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-indigo-100 text-indigo-800 mb-2">
                                        {{ $product->category->nama }}
                                    </span>
                                    <h3 class="font-bold text-gray-900">{{ $product->nama }}</h3>
                                    <p class="text-2xl font-bold text-indigo-600 mt-2">
                                        Rp {{ number_format($product->harga, 0, ',', '.') }}
                                    </p>
                                    <div class="flex items-center justify-between mt-4">
                                        <span class="text-sm {{ $product->stok > 0 ? 'text-green-600' : 'text-red-600' }}">
                                            {{ $product->stok > 0 ? "Stok: {$product->stok}" : 'Habis' }}
                                        </span>
                                        @if($product->stok > 0)
                                            <button 
                                                @click="addToCart({
                                                    id: {{ $product->id }},
                                                    nama: '{{ $product->nama }}',
                                                    harga: {{ $product->harga }},
                                                    stok: {{ $product->stok }}
                                                })"
                                                class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                                                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                                </svg>
                                                Pesan
                                            </button>
                                        @else
                                            <button disabled class="px-4 py-2 bg-gray-300 text-gray-500 rounded-lg cursor-not-allowed">
                                                Habis
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-3 text-center py-12">
                                <span class="text-6xl">🍽️</span>
                                <p class="mt-4 text-gray-500">Belum ada produk tersedia</p>
                            </div>
                        @endforelse
                    </div>

                    {{-- Pagination --}}
                    @if($products->hasPages())
                        <div class="mt-8">
                            {{ $products->withQueryString()->links() }}
                        </div>
                    @endif
                </div>

                {{-- Cart Sidebar --}}
                <div class="lg:w-96">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 sticky top-24">
                        <div class="p-6 border-b border-gray-200">
                            <div class="flex items-center justify-between">
                                <h2 class="text-lg font-bold text-gray-900">Keranjang</h2>
                                <span x-show="getTotalItems() > 0" 
                                      class="inline-flex items-center justify-center w-6 h-6 text-xs font-bold text-white bg-indigo-600 rounded-full"
                                      x-text="getTotalItems()"></span>
                            </div>
                        </div>

                        {{-- Cart Items --}}
                        <div class="max-h-96 overflow-y-auto">
                            <template x-if="cart.length === 0">
                                <div class="p-8 text-center text-gray-500">
                                    <span class="text-4xl">🛒</span>
                                    <p class="mt-2">Keranjang kosong</p>
                                    <p class="text-sm">Pilih menu untuk mulai memesan</p>
                                </div>
                            </template>

                            <template x-for="item in cart" :key="item.id">
                                <div class="p-4 border-b border-gray-100 hover:bg-gray-50">
                                    <div class="flex justify-between items-start mb-2">
                                        <h4 class="font-medium text-gray-900" x-text="item.nama"></h4>
                                        <button @click="removeFromCart(item.id)" class="text-red-500 hover:text-red-700">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                        </button>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center border border-gray-200 rounded-lg">
                                            <button @click="updateQty(item.id, item.qty - 1)" 
                                                    class="px-3 py-1 text-gray-500 hover:text-gray-700">-</button>
                                            <span class="px-3 py-1" x-text="item.qty"></span>
                                            <button @click="updateQty(item.id, item.qty + 1)"
                                                    :disabled="item.qty >= item.stok"
                                                    class="px-3 py-1 text-gray-500 hover:text-gray-700 disabled:opacity-50">+</button>
                                        </div>
                                        <span class="font-semibold text-indigo-600" x-text="'Rp ' + formatRupiah(item.harga * item.qty)"></span>
                                    </div>
                                </div>
                            </template>
                        </div>

                        {{-- Cart Footer --}}
                        <div x-show="cart.length > 0" class="p-6 border-t border-gray-200 bg-gray-50">
                            <div class="flex justify-between mb-4">
                                <span class="font-bold text-gray-900">Total</span>
                                <span class="text-xl font-bold text-indigo-600" x-text="'Rp ' + formatRupiah(getTotal())"></span>
                            </div>
                            <a href="{{ route('siswa.cart') }}" 
                               class="block w-full text-center px-6 py-3 bg-indigo-600 text-white rounded-lg font-semibold hover:bg-indigo-700 transition">
                                Checkout
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
