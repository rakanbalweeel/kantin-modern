



<?php $__env->startSection('title', 'Checkout'); ?>

<?php $__env->startSection('content'); ?>
<div x-data="{
    cart: JSON.parse(localStorage.getItem('kantin_cart') || '[]'),
    catatan: '',
    waktuPengambilan: 'istirahat_1',
    loading: false,
    pajakPersen: <?php echo e($pajak_persen ?? 0); ?>,
    
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
    
    clearCart() {
        this.cart = [];
        localStorage.removeItem('kantin_cart');
    },
    
    getSubtotal() {
        return this.cart.reduce((total, item) => total + (item.harga * item.qty), 0);
    },
    
    getPajak() {
        return Math.round(this.getSubtotal() * this.pajakPersen / 100);
    },
    
    getTotal() {
        return this.getSubtotal() + this.getPajak();
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
            const response = await fetch('<?php echo e(route('siswa.orders.store')); ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    items: items,
                    catatan: this.catatan,
                    waktu_pengambilan: this.waktuPengambilan
                })
            });
            
            const data = await response.json();
            
            if (data.success) {
                this.clearCart();
                window.location.href = data.redirect || '<?php echo e(route('siswa.orders.index')); ?>';
            } else {
                alert(data.message || 'Terjadi kesalahan saat memproses pesanan');
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Terjadi kesalahan. Silakan coba lagi.');
        }
        
        this.loading = false;
    }
}" class="py-8">

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="mb-8">
            <a href="<?php echo e(route('siswa.menu')); ?>" 
               class="inline-flex items-center text-slate-400 hover:text-orange-400 transition-colors duration-200 mb-6 group">
                <div class="w-8 h-8 rounded-lg glass flex items-center justify-center mr-3 group-hover:bg-orange-500/20 transition-all duration-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </div>
                <span class="font-medium">Kembali ke Menu</span>
            </a>
            
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div class="flex items-center space-x-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-orange-500 to-amber-500 rounded-2xl flex items-center justify-center shadow-lg shadow-orange-500/30">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold text-white">
                            Check<span class="text-orange-500">out</span>
                        </h1>
                        <p class="text-slate-400 mt-0.5">Review pesanan sebelum konfirmasi</p>
                    </div>
                </div>
                
                
                <div class="mt-4 md:mt-0" x-show="cart.length > 0">
                    <div class="inline-flex items-center space-x-3 glass rounded-2xl px-5 py-3">
                        <svg class="w-5 h-5 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                        <span class="text-sm text-slate-400">Total Item:</span>
                        <span class="font-bold text-orange-400" x-text="getTotalItems()"></span>
                    </div>
                </div>
            </div>
        </div>

        
        <template x-if="cart.length === 0">
            <div class="glass-card rounded-3xl p-12 text-center max-w-lg mx-auto">
                <div class="w-32 h-32 mx-auto mb-6 bg-gradient-to-br from-orange-500/20 to-amber-500/20 rounded-full flex items-center justify-center">
                    <svg class="w-16 h-16 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-white mb-2">Keranjang Kosong</h2>
                <p class="text-slate-400 mb-8 max-w-sm mx-auto">
                    Belum ada produk di keranjang. Yuk pilih makanan favoritmu!
                </p>
                <a href="<?php echo e(route('siswa.menu')); ?>" 
                   class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-orange-500 to-amber-500 text-white rounded-2xl font-semibold shadow-lg shadow-orange-500/30 hover:shadow-orange-500/50 hover:-translate-y-1 transition-all duration-300">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Lihat Menu
                </a>
            </div>
        </template>

        
        <template x-if="cart.length > 0">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <div class="lg:col-span-2 space-y-6">
                    
                    <div class="glass-card rounded-2xl overflow-hidden">
                        <div class="bg-gradient-to-r from-orange-500 to-amber-500 px-6 py-4">
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
                        
                        <div class="divide-y divide-white/10">
                            <template x-for="(item, index) in cart" :key="item.id">
                                <div class="p-5 hover:bg-white/5 transition-all duration-300">
                                    <div class="flex items-start justify-between">
                                        <div class="flex items-start space-x-4 flex-1">
                                            
                                            <div class="w-16 h-16 rounded-xl bg-gradient-to-br from-orange-500/20 to-amber-500/20 flex items-center justify-center flex-shrink-0">
                                                <svg class="w-8 h-8 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                                </svg>
                                            </div>
                                            
                                            <div class="flex-1">
                                                <h3 class="font-bold text-white text-lg" x-text="item.nama"></h3>
                                                <p class="text-slate-400 mt-1" x-text="'Rp ' + formatRupiah(item.harga) + ' / item'"></p>
                                                
                                                
                                                <div class="flex items-center mt-3 space-x-3">
                                                    <div class="flex items-center glass rounded-xl p-1">
                                                        <button @click="updateQty(item.id, item.qty - 1)" 
                                                                class="w-9 h-9 rounded-lg bg-white/10 flex items-center justify-center text-slate-400 hover:text-orange-400 hover:bg-orange-500/20 transition-all duration-200">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                                                            </svg>
                                                        </button>
                                                        <span class="w-12 text-center font-bold text-white" x-text="item.qty"></span>
                                                        <button @click="updateQty(item.id, item.qty + 1)"
                                                                :disabled="item.qty >= item.stok"
                                                                class="w-9 h-9 rounded-lg bg-white/10 flex items-center justify-center text-slate-400 hover:text-orange-400 hover:bg-orange-500/20 transition-all duration-200 disabled:opacity-40 disabled:cursor-not-allowed">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                                            </svg>
                                                        </button>
                                                    </div>
                                                    <span class="text-xs text-slate-500" x-text="'Stok: ' + item.stok"></span>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="flex flex-col items-end space-y-3 ml-4">
                                            <button @click="removeFromCart(item.id)" 
                                                    class="w-9 h-9 rounded-xl bg-red-500/20 text-red-400 flex items-center justify-center hover:bg-red-500/30 transition-all duration-200">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                            <div class="text-right">
                                                <p class="text-xs text-slate-500 uppercase tracking-wider">Subtotal</p>
                                                <span class="text-xl font-bold text-orange-400" 
                                                      x-text="'Rp ' + formatRupiah(item.harga * item.qty)"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>

                    
                    <div class="glass-card rounded-2xl overflow-hidden">
                        <div class="px-6 py-4 border-b border-white/10">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-gradient-to-br from-amber-400 to-orange-500 rounded-xl flex items-center justify-center shadow-lg shadow-amber-500/20">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-bold text-white">Catatan Pesanan</h3>
                                    <p class="text-sm text-slate-400">Opsional - tambahkan permintaan khusus</p>
                                </div>
                            </div>
                        </div>
                        <div class="p-6">
                            <textarea 
                                x-model="catatan"
                                rows="3"
                                class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200 resize-none text-white placeholder-slate-500"
                                placeholder="Contoh: Tidak pakai sambal, tambah sayur, pedas level 2, dll..."
                            ></textarea>
                        </div>
                    </div>

                    
                    <div class="glass-card rounded-2xl overflow-hidden">
                        <div class="px-6 py-4 border-b border-white/10">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg shadow-blue-500/20">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-bold text-white">Waktu Pengambilan</h3>
                                    <p class="text-sm text-slate-400">Pilih waktu untuk mengambil pesanan</p>
                                </div>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                
                                <label class="relative cursor-pointer group">
                                    <input type="radio" name="waktu_pengambilan" value="istirahat_1" x-model="waktuPengambilan" class="peer sr-only">
                                    <div class="p-4 rounded-xl border-2 transition-all duration-300
                                                border-white/10 bg-white/5
                                                peer-checked:border-blue-500 peer-checked:bg-blue-500/10
                                                group-hover:border-white/20 group-hover:bg-white/10">
                                        <div class="flex items-center justify-between mb-2">
                                            <span class="font-bold text-white">Istirahat 1</span>
                                            <div class="w-5 h-5 rounded-full border-2 flex items-center justify-center
                                                        border-white/30 peer-checked:border-blue-500
                                                        transition-all duration-300">
                                                <div class="w-2.5 h-2.5 rounded-full bg-blue-500 scale-0 peer-checked:scale-100 transition-transform duration-300"
                                                     :class="waktuPengambilan === 'istirahat_1' ? 'scale-100' : 'scale-0'"></div>
                                            </div>
                                        </div>
                                        <div class="flex items-center text-sm text-slate-400">
                                            <svg class="w-4 h-4 mr-2 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            09:30 - 10:00
                                        </div>
                                    </div>
                                </label>

                                
                                <label class="relative cursor-pointer group">
                                    <input type="radio" name="waktu_pengambilan" value="istirahat_2" x-model="waktuPengambilan" class="peer sr-only">
                                    <div class="p-4 rounded-xl border-2 transition-all duration-300
                                                border-white/10 bg-white/5
                                                peer-checked:border-purple-500 peer-checked:bg-purple-500/10
                                                group-hover:border-white/20 group-hover:bg-white/10">
                                        <div class="flex items-center justify-between mb-2">
                                            <span class="font-bold text-white">Istirahat 2</span>
                                            <div class="w-5 h-5 rounded-full border-2 flex items-center justify-center
                                                        border-white/30 peer-checked:border-purple-500
                                                        transition-all duration-300">
                                                <div class="w-2.5 h-2.5 rounded-full bg-purple-500 scale-0 peer-checked:scale-100 transition-transform duration-300"
                                                     :class="waktuPengambilan === 'istirahat_2' ? 'scale-100' : 'scale-0'"></div>
                                            </div>
                                        </div>
                                        <div class="flex items-center text-sm text-slate-400">
                                            <svg class="w-4 h-4 mr-2 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            12:00 - 12:30
                                        </div>
                                    </div>
                                </label>
                            </div>
                            
                            <div class="mt-4 p-3 bg-blue-500/10 border border-blue-500/30 rounded-xl">
                                <p class="text-sm text-blue-400 flex items-start">
                                    <svg class="w-4 h-4 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span>Pesanan akan disiapkan dan siap diambil pada waktu istirahat yang kamu pilih.</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                
                <div class="lg:col-span-1">
                    <div class="glass-card rounded-2xl sticky top-24 overflow-hidden">
                        
                        <div class="bg-gradient-to-r from-orange-500 to-amber-500 px-6 py-5">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <h2 class="text-lg font-bold text-white">Ringkasan Pesanan</h2>
                            </div>
                        </div>
                        
                        
                        <div class="p-6 space-y-4 max-h-64 overflow-y-auto">
                            <template x-for="item in cart" :key="item.id">
                                <div class="flex justify-between items-start py-2 border-b border-white/10 last:border-0">
                                    <div class="flex-1">
                                        <p class="font-medium text-white text-sm" x-text="item.nama"></p>
                                        <p class="text-xs text-slate-500 mt-0.5" x-text="item.qty + ' × Rp ' + formatRupiah(item.harga)"></p>
                                    </div>
                                    <span class="font-semibold text-white text-sm ml-4" x-text="'Rp ' + formatRupiah(item.harga * item.qty)"></span>
                                </div>
                            </template>
                        </div>
                        
                        
                        <div class="px-6 py-4 bg-white/5 border-t border-white/10">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-slate-400">Subtotal</span>
                                <span class="font-medium text-white" x-text="'Rp ' + formatRupiah(getSubtotal())"></span>
                            </div>
                            <template x-if="pajakPersen > 0">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-slate-400">
                                        Pajak (<span x-text="pajakPersen"></span>%)
                                    </span>
                                    <span class="font-medium text-amber-400" x-text="'+ Rp ' + formatRupiah(getPajak())"></span>
                                </div>
                            </template>
                            <div class="h-px bg-gradient-to-r from-transparent via-white/20 to-transparent my-3"></div>
                            <div class="flex items-center justify-between">
                                <span class="font-bold text-white text-lg">Total Bayar</span>
                                <span class="text-2xl font-bold text-orange-400" 
                                      x-text="'Rp ' + formatRupiah(getTotal())"></span>
                            </div>
                        </div>
                        
                        
                        <div class="px-6 py-4 border-t border-white/10">
                            <div class="flex items-center justify-between mb-3">
                                <span class="text-slate-400 text-sm">Saldo Anda</span>
                                <span class="font-bold text-white">Rp <?php echo e(number_format(auth()->user()->saldo ?? 0, 0, ',', '.')); ?></span>
                            </div>
                            <?php if((auth()->user()->saldo ?? 0) < 1): ?>
                                <div class="glass bg-red-500/10 border-red-500/30 rounded-xl p-3 mb-4">
                                    <p class="text-red-400 text-sm flex items-center">
                                        <i class="fas fa-exclamation-circle mr-2"></i>
                                        Saldo tidak mencukupi
                                    </p>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        
                        <div class="p-6 bg-white/5 border-t border-white/10">
                            <button 
                                @click="submitOrder()"
                                :disabled="loading"
                                class="w-full px-6 py-4 bg-gradient-to-r from-orange-500 to-amber-500 text-white rounded-xl font-bold text-lg disabled:opacity-50 disabled:cursor-not-allowed transition-all duration-300 shadow-lg shadow-orange-500/30 hover:shadow-orange-500/50 hover:-translate-y-0.5 flex items-center justify-center space-x-2">
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
                                        <svg class="animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        <span>Memproses...</span>
                                    </span>
                                </template>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </div>
</div>

<?php $__env->startPush('styles'); ?>
<style>
    .glass-card {
        background: rgba(255, 255, 255, 0.03);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.08);
    }
</style>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\kantin-modern\resources\views/siswa/cart.blade.php ENDPATH**/ ?>