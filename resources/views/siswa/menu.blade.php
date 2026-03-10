{{--
==========================================================================
MENU KANTIN - SISWA (Dark Theme)
==========================================================================
Modern dark theme matching landing page design
==========================================================================
--}}

@extends('layouts.app')

@section('title', 'Menu Kantin')

@section('content')
<div x-data="{
    cart: JSON.parse(localStorage.getItem('kantin_cart') || '[]'),
    showTopupModal: false,
    showNotification: false,
    notificationMessage: '',
    topupAmount: '',
    topupPresets: [25000, 50000, 100000, 200000],
    
    addToCart(product) {
        const existingIndex = this.cart.findIndex(item => item.id === product.id);
        if (existingIndex !== -1) {
            this.cart[existingIndex].qty++;
            this.showAlert(product.nama + ' ditambahkan (Qty: ' + this.cart[existingIndex].qty + ')');
        } else {
            this.cart.push({
                id: product.id,
                nama: product.nama,
                harga: product.harga,
                stok: product.stok,
                qty: 1
            });
            this.showAlert(product.nama + ' ditambahkan ke keranjang!');
        }
        this.saveCart();
    },
    
    showAlert(message) {
        this.notificationMessage = message;
        this.showNotification = true;
        setTimeout(() => { this.showNotification = false; }, 2000);
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
        window.dispatchEvent(new CustomEvent('cart-updated'));
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
    
    checkout() {
        if (this.cart.length === 0) {
            alert('Keranjang kosong!');
            return;
        }
        window.location.href = '{{ route('siswa.cart') }}';
    }
}" class="py-8">

    {{-- Notification Toast --}}
    <div x-show="showNotification" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform translate-y-2"
         x-transition:enter-end="opacity-100 transform translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed top-20 right-4 z-50 bg-gradient-to-r from-green-500 to-emerald-500 text-white px-6 py-3 rounded-xl shadow-lg shadow-green-500/30 flex items-center space-x-2">
        <i class="fas fa-check-circle"></i>
        <span x-text="notificationMessage"></span>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Header --}}
        <div class="mb-10 text-center lg:text-left">
            <div class="inline-flex items-center gap-2 glass rounded-full px-4 py-2 mb-4">
                <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                <span class="text-green-400 text-sm font-medium">Pesan langsung dari kantin</span>
            </div>
            <h1 class="text-4xl font-extrabold text-white mb-2">
                Menu <span class="bg-gradient-to-r from-orange-500 to-amber-400 bg-clip-text text-transparent">Kantin</span>
            </h1>
            <p class="text-slate-400 text-lg">Pilih makanan dan minuman favoritmu!</p>
        </div>

        <div class="flex flex-col lg:flex-row gap-8">
            {{-- SIDEBAR SALDO VIRTUAL --}}
            <div class="lg:w-80 order-2 lg:order-2">
                <div class="sticky top-24 space-y-5">
                    {{-- KARTU SALDO VIRTUAL --}}
                    <div class="relative overflow-hidden bg-gradient-to-br from-orange-500 via-amber-500 to-yellow-500 rounded-2xl shadow-2xl shadow-orange-500/20 p-6 text-white">
                        {{-- Background Pattern --}}
                        <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-white/10 rounded-full blur-2xl"></div>
                        <div class="absolute bottom-0 left-0 -mb-4 -ml-4 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
                        
                        <div class="relative flex items-center mb-5">
                            <div class="w-14 h-14 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center mr-4 shadow-lg">
                                <i class="fas fa-wallet text-2xl"></i>
                            </div>
                            <div>
                                <p class="text-white/70 text-sm font-medium">Saldo Virtual</p>
                                <h3 class="text-3xl font-bold tracking-tight">Rp {{ number_format(auth()->user()->saldo ?? 0, 0, ',', '.') }}</h3>
                            </div>
                        </div>
                        <hr class="border-white/20 my-4">
                        <div class="relative flex items-center justify-between text-sm">
                            <div class="flex items-center bg-white/10 px-3 py-1.5 rounded-full">
                                <i class="fas fa-user mr-2"></i>
                                <span class="font-medium">{{ auth()->user()->name }}</span>
                            </div>
                        </div>
                        
                        {{-- Tombol Top Up --}}
                        <button @click="showTopupModal = true" 
                                class="w-full mt-5 px-5 py-3 bg-white/20 hover:bg-white/30 backdrop-blur-sm rounded-xl font-semibold transition-all duration-300 flex items-center justify-center group">
                            <i class="fas fa-plus-circle mr-2 group-hover:scale-110 transition-transform"></i>
                            Top Up Saldo
                        </button>
                    </div>
                    
                    {{-- Kartu Informasi --}}
                    <div class="glass-card rounded-2xl p-6">
                        <h4 class="font-bold text-white mb-4 flex items-center text-lg">
                            <span class="w-8 h-8 bg-blue-500/20 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-info-circle text-blue-400"></i>
                            </span>
                            Informasi
                        </h4>
                        <ul class="space-y-3 text-sm text-slate-400">
                            <li class="flex items-start p-2 rounded-lg hover:bg-white/5 transition-colors">
                                <span class="w-5 h-5 bg-green-500/20 rounded-full flex items-center justify-center mr-3 mt-0.5 flex-shrink-0">
                                    <i class="fas fa-check text-green-400 text-xs"></i>
                                </span>
                                <span>Saldo digunakan untuk pembelian di kantin</span>
                            </li>
                            <li class="flex items-start p-2 rounded-lg hover:bg-white/5 transition-colors">
                                <span class="w-5 h-5 bg-green-500/20 rounded-full flex items-center justify-center mr-3 mt-0.5 flex-shrink-0">
                                    <i class="fas fa-check text-green-400 text-xs"></i>
                                </span>
                                <span>Top up saldo dapat menghubungi admin</span>
                            </li>
                            <li class="flex items-start p-2 rounded-lg hover:bg-white/5 transition-colors">
                                <span class="w-5 h-5 bg-green-500/20 rounded-full flex items-center justify-center mr-3 mt-0.5 flex-shrink-0">
                                    <i class="fas fa-check text-green-400 text-xs"></i>
                                </span>
                                <span>Semua transaksi tercatat aman</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            {{-- Products Grid --}}
            <div class="flex-1 order-1 lg:order-1">
                {{-- Category Filter --}}
                <div class="glass rounded-2xl p-4 mb-8">
                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('siswa.menu') }}" 
                           class="px-5 py-2.5 rounded-xl font-medium transition-all duration-300 {{ !request('category') ? 'bg-gradient-to-r from-orange-500 to-amber-500 text-white shadow-lg shadow-orange-500/30' : 'bg-white/5 text-slate-300 hover:bg-white/10 hover:text-white' }}">
                            <i class="fas fa-th-large mr-2"></i>Semua
                        </a>
                        @foreach($categories as $category)
                            @php
                                $icons = ['Makanan Berat' => 'fa-drumstick-bite', 'Makanan Ringan' => 'fa-cookie-bite', 'Minuman' => 'fa-glass-water', 'Snack' => 'fa-candy-cane'];
                                $icon = $icons[$category->nama] ?? 'fa-utensils';
                            @endphp
                            <a href="{{ route('siswa.menu', ['category' => $category->id]) }}" 
                               class="px-5 py-2.5 rounded-xl font-medium transition-all duration-300 {{ request('category') == $category->id ? 'bg-gradient-to-r from-orange-500 to-amber-500 text-white shadow-lg shadow-orange-500/30' : 'bg-white/5 text-slate-300 hover:bg-white/10 hover:text-white' }}">
                                <i class="fas {{ $icon }} mr-2"></i>{{ $category->nama }}
                            </a>
                        @endforeach
                    </div>
                </div>

                {{-- Products Grid --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6">
                    @forelse($products as $product)
                        @php
                            $categoryEmojis = [
                                'Makanan Berat' => '🍛',
                                'Makanan Ringan' => '🍿',
                                'Minuman' => '🥤',
                                'Snack' => '🍪',
                            ];
                            $defaultEmoji = $categoryEmojis[$product->category->nama] ?? '🍽️';
                            
                            $gradients = [
                                'Makanan Berat' => 'from-orange-500/20 via-amber-500/10 to-yellow-500/20',
                                'Makanan Ringan' => 'from-green-500/20 via-emerald-500/10 to-teal-500/20',
                                'Minuman' => 'from-blue-500/20 via-cyan-500/10 to-sky-500/20',
                                'Snack' => 'from-pink-500/20 via-rose-500/10 to-red-500/20',
                            ];
                            $defaultGradient = $gradients[$product->category->nama] ?? 'from-orange-500/20 via-amber-500/10 to-yellow-500/20';
                        @endphp
                        <div class="group glass-card rounded-2xl overflow-hidden hover:shadow-2xl hover:shadow-orange-500/10 hover:-translate-y-2 transition-all duration-500">
                            {{-- Image Container --}}
                            <div class="relative overflow-hidden">
                                @if($product->gambar)
                                    <img src="{{ Storage::url($product->gambar) }}" 
                                         alt="{{ $product->nama }}"
                                         class="w-full h-52 object-cover group-hover:scale-110 transition-transform duration-500">
                                @else
                                    <div class="w-full h-52 bg-gradient-to-br {{ $defaultGradient }} flex items-center justify-center relative overflow-hidden">
                                        <div class="absolute top-0 right-0 w-24 h-24 bg-white/5 rounded-full -mr-12 -mt-12"></div>
                                        <div class="absolute bottom-0 left-0 w-32 h-32 bg-white/5 rounded-full -ml-16 -mb-16"></div>
                                        <span class="text-7xl group-hover:scale-125 transition-transform duration-500 drop-shadow-lg">{{ $defaultEmoji }}</span>
                                    </div>
                                @endif
                                {{-- Category Badge --}}
                                <div class="absolute top-3 left-3">
                                    <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold glass text-white">
                                        <i class="fas fa-tag mr-1.5 text-orange-400"></i>{{ $product->category->nama }}
                                    </span>
                                </div>
                                {{-- Stock Badge --}}
                                <div class="absolute top-3 right-3">
                                    <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold {{ $product->stok > 10 ? 'bg-green-500' : ($product->stok > 0 ? 'bg-amber-500' : 'bg-red-500') }} text-white shadow-lg">
                                        <i class="fas {{ $product->stok > 0 ? 'fa-check-circle' : 'fa-times-circle' }} mr-1.5"></i>
                                        {{ $product->stok > 0 ? "Stok: {$product->stok}" : 'Habis' }}
                                    </span>
                                </div>
                            </div>
                            
                            {{-- Content --}}
                            <div class="p-5">
                                <h3 class="font-bold text-white text-lg mb-2 group-hover:text-orange-400 transition-colors">{{ $product->nama }}</h3>
                                <div class="flex items-center justify-between">
                                    <p class="text-2xl font-extrabold bg-gradient-to-r from-orange-400 to-amber-400 bg-clip-text text-transparent">
                                        Rp {{ number_format($product->harga, 0, ',', '.') }}
                                    </p>
                                    @if($product->stok > 0)
                                        <button 
                                            @click="addToCart({
                                                id: {{ $product->id }},
                                                nama: {{ json_encode($product->nama) }},
                                                harga: {{ $product->harga }},
                                                stok: {{ $product->stok }}
                                            })"
                                            class="relative inline-flex items-center px-5 py-3 bg-gradient-to-r from-orange-500 to-amber-500 text-white rounded-xl font-semibold hover:shadow-lg hover:shadow-orange-500/30 transform hover:scale-105 active:scale-95 transition-all duration-300">
                                            <i class="fas fa-plus mr-2"></i>
                                            Pesan
                                        </button>
                                    @else
                                        <button disabled class="px-5 py-3 bg-slate-700 text-slate-400 rounded-xl font-semibold cursor-not-allowed">
                                            <i class="fas fa-ban mr-2"></i>Habis
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full">
                            <div class="text-center py-16 glass-card rounded-2xl">
                                <span class="text-8xl mb-4 block">🍽️</span>
                                <h3 class="text-2xl font-bold text-white mb-2">Belum ada produk tersedia</h3>
                                <p class="text-slate-400">Tunggu update menu terbaru dari kantin ya!</p>
                            </div>
                        </div>
                    @endforelse
                </div>

                {{-- Pagination --}}
                @if($products->hasPages())
                    <div class="mt-10 flex justify-center">
                        <div class="glass rounded-2xl p-4">
                            {{ $products->withQueryString()->links() }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Modal Top Up Saldo --}}
    <div x-show="showTopupModal" 
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
        {{-- Backdrop --}}
        <div class="fixed inset-0 bg-black/80 backdrop-blur-sm" @click="showTopupModal = false"></div>
        
        {{-- Modal Content --}}
        <div class="relative min-h-screen flex items-center justify-center p-4">
            <div class="relative glass-card rounded-3xl shadow-2xl max-w-md w-full overflow-hidden"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                 @click.away="showTopupModal = false">
                
                {{-- Header --}}
                <div class="bg-gradient-to-r from-orange-500 via-amber-500 to-yellow-500 px-6 py-5 text-white">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center mr-4">
                                <i class="fas fa-wallet text-xl"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold">Top Up Saldo</h3>
                                <p class="text-white/70 text-sm">Isi saldo virtual kamu</p>
                            </div>
                        </div>
                        <button @click="showTopupModal = false" class="p-2 hover:bg-white/20 rounded-full transition-colors">
                            <i class="fas fa-times text-lg"></i>
                        </button>
                    </div>
                </div>
                
                {{-- Body --}}
                <form action="{{ route('siswa.saldo.topup') }}" method="POST" class="p-6">
                    @csrf
                    
                    {{-- Current Balance --}}
                    <div class="glass rounded-2xl p-4 mb-6">
                        <p class="text-slate-400 text-sm mb-1">Saldo Saat Ini</p>
                        <p class="text-2xl font-bold text-white">Rp {{ number_format(auth()->user()->saldo ?? 0, 0, ',', '.') }}</p>
                    </div>
                    
                    {{-- Preset Amount Buttons --}}
                    <div class="mb-5">
                        <label class="block text-slate-300 font-medium mb-3">Pilih Nominal</label>
                        <div class="grid grid-cols-2 gap-3">
                            <template x-for="preset in topupPresets" :key="preset">
                                <button type="button" 
                                        @click="topupAmount = preset"
                                        :class="topupAmount == preset ? 'ring-2 ring-orange-500 bg-orange-500/20 text-orange-400' : 'glass text-slate-300 hover:bg-white/10'"
                                        class="px-4 py-3 rounded-xl font-semibold transition-all duration-200">
                                    <span x-text="'Rp ' + new Intl.NumberFormat('id-ID').format(preset)"></span>
                                </button>
                            </template>
                        </div>
                    </div>
                    
                    {{-- Custom Amount Input --}}
                    <div class="mb-6">
                        <label class="block text-slate-300 font-medium mb-2">Atau Masukkan Nominal Lain</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 font-medium">Rp</span>
                            <input type="number" 
                                   name="jumlah" 
                                   x-model="topupAmount"
                                   min="10000" 
                                   max="1000000"
                                   placeholder="Min 10.000"
                                   class="w-full pl-12 pr-4 py-3 bg-white/5 border border-white/10 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all text-lg font-medium text-white placeholder-slate-500"
                                   required>
                        </div>
                        <p class="text-slate-500 text-xs mt-2">Minimal Rp 10.000 - Maksimal Rp 1.000.000</p>
                    </div>
                    
                    {{-- Info Box --}}
                    <div class="glass bg-amber-500/10 border-amber-500/30 rounded-xl p-4 mb-6">
                        <div class="flex items-start">
                            <i class="fas fa-info-circle text-amber-400 mt-0.5 mr-3"></i>
                            <div class="text-sm text-amber-300">
                                <p class="font-semibold mb-1">Cara Top Up:</p>
                                <ol class="list-decimal list-inside space-y-1 text-amber-400/80">
                                    <li>Ajukan request top up</li>
                                    <li>Hubungi admin untuk pembayaran</li>
                                    <li>Saldo otomatis masuk setelah disetujui</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                    
                    {{-- Submit Button --}}
                    <button type="submit" 
                            :disabled="!topupAmount || topupAmount < 10000"
                            :class="(!topupAmount || topupAmount < 10000) ? 'bg-slate-700 cursor-not-allowed text-slate-400' : 'bg-gradient-to-r from-orange-500 to-amber-500 hover:shadow-lg hover:shadow-orange-500/30 text-white'"
                            class="w-full py-4 rounded-xl font-bold text-lg transition-all duration-300 flex items-center justify-center">
                        <i class="fas fa-paper-plane mr-2"></i>
                        Ajukan Top Up
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- Floating Cart Button --}}
    <div x-show="cart.length > 0" 
         x-transition
         class="fixed bottom-6 right-6 z-40">
        <button @click="checkout()" 
                class="flex items-center space-x-3 bg-gradient-to-r from-orange-500 to-amber-500 text-white px-6 py-4 rounded-2xl shadow-2xl shadow-orange-500/30 hover:shadow-orange-500/50 transform hover:scale-105 transition-all duration-300">
            <div class="relative">
                <i class="fas fa-shopping-cart text-xl"></i>
                <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center font-bold" x-text="getTotalItems()"></span>
            </div>
            <div class="text-left">
                <p class="text-xs text-white/70">Total Belanja</p>
                <p class="font-bold" x-text="'Rp ' + formatRupiah(getTotal())"></p>
            </div>
            <i class="fas fa-arrow-right ml-2"></i>
        </button>
    </div>
</div>

@push('styles')
<style>
    .glass-card {
        background: rgba(255, 255, 255, 0.03);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.08);
    }
</style>
@endpush
@endsection
