{{--
==========================================================================
HALAMAN CHECKOUT / CART - SISWA
==========================================================================
Halaman ini menampilkan ringkasan keranjang belanja sebelum checkout.
Siswa bisa mereview pesanan, menambah catatan, dan konfirmasi pesanan.

PENJELASAN
----------
Data cart diambil dari localStorage (disimpan oleh halaman menu).
Form akan mengirim data ke OrderController@store untuk memproses pesanan.
==========================================================================
--}}

@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<div x-data="{
    cart: JSON.parse(localStorage.getItem('kantin_cart') || '[]'),
    catatan: '',
    loading: false,
    
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
    
    clearCart() {
        this.cart = [];
        localStorage.removeItem('kantin_cart');
    },
    
    getTotal() {
        return this.cart.reduce((total, item) => total + (item.harga * item.qty), 0);
    },
    
    getTotalItems() {
        return this.cart.reduce((total, item) => total + item.qty, 0);
    },
    
    formatRupiah(number) {
        return new Intl.NumberFormat('id-ID').format(number);
    },
    
    async submitOrder() {
        if (this.cart.length === 0) {
            alert('Keranjang kosong!');
            return;
        }
        
        this.loading = true;
        
        const items = this.cart.map(item => ({
            product_id: item.id,
            jumlah: item.qty
        }));
        
        try {
            const response = await fetch('{{ route('siswa.orders.store') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    items: items,
                    catatan: this.catatan
                })
            });
            
            const data = await response.json();
            
            if (data.success) {
                this.clearCart();
                window.location.href = data.redirect || '{{ route('siswa.orders.index') }}';
            } else {
                alert(data.message || 'Terjadi kesalahan saat memproses pesanan');
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Terjadi kesalahan. Silakan coba lagi.');
        }
        
        this.loading = false;
    }
}">

<div class="py-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Header Section --}}
        <div class="mb-8">
            <a href="{{ route('siswa.menu') }}" 
               class="inline-flex items-center text-gray-500 hover:text-indigo-600 transition-colors duration-200 mb-6 group">
                <div class="w-8 h-8 rounded-lg bg-white shadow-sm border border-gray-200 flex items-center justify-center mr-3 group-hover:border-indigo-300 group-hover:shadow-md transition-all duration-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </div>
                <span class="font-medium">Kembali ke Menu</span>
            </a>
            
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div class="flex items-center space-x-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl flex items-center justify-center shadow-lg shadow-indigo-200">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold bg-gradient-to-r from-gray-900 via-indigo-900 to-purple-900 bg-clip-text text-transparent">
                            Checkout
                        </h1>
                        <p class="text-gray-500 mt-0.5">Review pesanan sebelum konfirmasi</p>
                    </div>
                </div>
                
                {{-- Cart Summary Badge --}}
                <div class="mt-4 md:mt-0" x-show="cart.length > 0">
                    <div class="inline-flex items-center space-x-3 bg-white/80 backdrop-blur-sm rounded-2xl px-5 py-3 shadow-sm border border-indigo-100">
                        <div class="flex items-center space-x-2">
                            <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                            </svg>
                            <span class="text-sm text-gray-500">Total Item:</span>
                            <span class="font-bold text-indigo-600" x-text="getTotalItems()"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Empty Cart --}}
        <template x-if="cart.length === 0">
            <div class="bg-white rounded-3xl shadow-xl border border-gray-100 p-12 text-center max-w-lg mx-auto">
                <div class="w-32 h-32 mx-auto mb-6 bg-gradient-to-br from-indigo-100 to-purple-100 rounded-full flex items-center justify-center">
                    <svg class="w-16 h-16 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">Keranjang Kosong</h2>
                <p class="text-gray-500 mb-8 max-w-sm mx-auto">
                    Belum ada produk di keranjang. Yuk pilih makanan favoritmu!
                </p>
                <a href="{{ route('siswa.menu') }}" 
                   class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-2xl font-semibold hover:from-indigo-700 hover:to-purple-700 transition-all duration-200 shadow-xl shadow-indigo-200 hover:shadow-2xl hover:shadow-indigo-300 hover:-translate-y-1">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Lihat Menu
                </a>
            </div>
        </template>

        {{-- Cart Content --}}
        <template x-if="cart.length > 0">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                {{-- Cart Items --}}
                <div class="lg:col-span-2 space-y-6">
                    {{-- Items Card --}}
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                        <div class="bg-gradient-to-r from-indigo-500 to-purple-500 px-6 py-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                        </svg>
                                    </div>
                                    <h2 class="text-lg font-bold text-white">Detail Pesanan</h2>
                                </div>
                                <span class="text-white/80 text-sm" x-text="cart.length + ' produk'"></span>
                            </div>
                        </div>
                        
                        <div class="divide-y divide-gray-100">
                            <template x-for="(item, index) in cart" :key="item.id">
                                <div class="p-5 hover:bg-gradient-to-r hover:from-gray-50 hover:to-indigo-50/30 transition-all duration-300"
                                     :style="'animation: fadeInUp 0.4s ease-out ' + (index * 0.1) + 's both'">
                                    <div class="flex items-start justify-between">
                                        <div class="flex items-start space-x-4 flex-1">
                                            {{-- Product Image Placeholder --}}
                                            <div class="w-16 h-16 rounded-xl bg-gradient-to-br from-indigo-100 to-purple-100 flex items-center justify-center flex-shrink-0 ring-2 ring-white shadow-sm">
                                                <svg class="w-8 h-8 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                                </svg>
                                            </div>
                                            
                                            <div class="flex-1">
                                                <h3 class="font-bold text-gray-900 text-lg" x-text="item.nama"></h3>
                                                <p class="text-gray-500 mt-1" x-text="'Rp ' + formatRupiah(item.harga) + ' / item'"></p>
                                                
                                                {{-- Quantity Controls --}}
                                                <div class="flex items-center mt-3 space-x-3">
                                                    <div class="flex items-center bg-gray-100 rounded-xl p-1">
                                                        <button @click="updateQty(item.id, item.qty - 1)" 
                                                                class="w-9 h-9 rounded-lg bg-white shadow-sm flex items-center justify-center text-gray-600 hover:text-indigo-600 hover:shadow-md transition-all duration-200">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                                                            </svg>
                                                        </button>
                                                        <span class="w-12 text-center font-bold text-gray-900" x-text="item.qty"></span>
                                                        <button @click="updateQty(item.id, item.qty + 1)"
                                                                :disabled="item.qty >= item.stok"
                                                                class="w-9 h-9 rounded-lg bg-white shadow-sm flex items-center justify-center text-gray-600 hover:text-indigo-600 hover:shadow-md transition-all duration-200 disabled:opacity-40 disabled:cursor-not-allowed">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                                            </svg>
                                                        </button>
                                                    </div>
                                                    <span class="text-xs text-gray-400" x-text="'Stok: ' + item.stok"></span>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="flex flex-col items-end space-y-3 ml-4">
                                            <button @click="removeFromCart(item.id)" 
                                                    class="w-9 h-9 rounded-xl bg-red-50 text-red-500 flex items-center justify-center hover:bg-red-100 hover:text-red-600 transition-all duration-200">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                            <div class="text-right">
                                                <p class="text-xs text-gray-400 uppercase tracking-wider">Subtotal</p>
                                                <span class="text-xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent" 
                                                      x-text="'Rp ' + formatRupiah(item.harga * item.qty)"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>

                    {{-- Catatan Card --}}
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-indigo-50/30">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-gradient-to-br from-amber-400 to-orange-400 rounded-xl flex items-center justify-center shadow-lg shadow-amber-200">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-bold text-gray-900">Catatan Pesanan</h3>
                                    <p class="text-sm text-gray-500">Opsional - tambahkan permintaan khusus</p>
                                </div>
                            </div>
                        </div>
                        <div class="p-6">
                            <textarea 
                                x-model="catatan"
                                rows="3"
                                class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:ring-4 focus:ring-indigo-100 focus:border-indigo-400 transition-all duration-200 resize-none"
                                placeholder="Contoh: Tidak pakai sambal, tambah sayur, pedas level 2, dll..."
                            ></textarea>
                        </div>
                    </div>
                </div>

                {{-- Order Summary Sidebar --}}
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 sticky top-24 overflow-hidden">
                        {{-- Summary Header --}}
                        <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-5">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <h2 class="text-lg font-bold text-white">Ringkasan Pesanan</h2>
                            </div>
                        </div>
                        
                        {{-- Items Summary --}}
                        <div class="p-6 space-y-4 max-h-64 overflow-y-auto">
                            <template x-for="item in cart" :key="item.id">
                                <div class="flex justify-between items-start py-2 border-b border-gray-100 last:border-0">
                                    <div class="flex-1">
                                        <p class="font-medium text-gray-900 text-sm" x-text="item.nama"></p>
                                        <p class="text-xs text-gray-400 mt-0.5" x-text="item.qty + ' × Rp ' + formatRupiah(item.harga)"></p>
                                    </div>
                                    <span class="font-semibold text-gray-900 text-sm ml-4" x-text="'Rp ' + formatRupiah(item.harga * item.qty)"></span>
                                </div>
                            </template>
                        </div>
                        
                        {{-- Total Section --}}
                        <div class="px-6 py-4 bg-gradient-to-br from-gray-50 to-indigo-50 border-t border-gray-100">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-gray-500">Subtotal</span>
                                <span class="font-medium text-gray-900" x-text="'Rp ' + formatRupiah(getTotal())"></span>
                            </div>
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-gray-500">Biaya Layanan</span>
                                <span class="font-medium text-green-600">Gratis</span>
                            </div>
                            <div class="h-px bg-gradient-to-r from-transparent via-gray-300 to-transparent my-3"></div>
                            <div class="flex items-center justify-between">
                                <span class="font-bold text-gray-900 text-lg">Total Bayar</span>
                                <span class="text-2xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent" 
                                      x-text="'Rp ' + formatRupiah(getTotal())"></span>
                            </div>
                        </div>
                        
                        {{-- Action Button --}}
                        <div class="p-6 bg-white border-t border-gray-100">
                            <button 
                                @click="submitOrder()"
                                :disabled="loading"
                                class="w-full px-6 py-4 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl font-bold text-lg hover:from-indigo-700 hover:to-purple-700 disabled:opacity-50 disabled:cursor-not-allowed transition-all duration-200 shadow-lg shadow-indigo-200 hover:shadow-xl hover:shadow-indigo-300 hover:-translate-y-0.5 flex items-center justify-center space-x-2">
                                <template x-if="!loading">
                                    <span class="flex items-center space-x-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        <span>Konfirmasi Pesanan</span>
                                    </span>
                                </template>
                                <template x-if="loading">
                                    <span class="flex items-center space-x-2">
                                        <svg class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        <span>Memproses...</span>
                                    </span>
                                </template>
                            </button>
                            
                            <div class="mt-4 flex items-center justify-center space-x-2 text-sm text-gray-400">
                                <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                </svg>
                                <span>Pesanan aman & terverifikasi</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </div>
</div>
</div>

<style>
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(15px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>
@endsection
