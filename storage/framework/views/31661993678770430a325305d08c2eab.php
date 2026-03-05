



<?php $__env->startSection('title', 'Checkout'); ?>

<?php $__env->startSection('content'); ?>
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
                    catatan: this.catatan
                })
            });
            
            const data = await response.json();
            
            if (response.ok) {
                this.clearCart();
                window.location.href = '<?php echo e(route('siswa.orders.index')); ?>';
            } else {
                alert(data.message || 'Terjadi kesalahan saat memproses pesanan');
            }
        } catch (error) {
            alert('Terjadi kesalahan. Silakan coba lagi.');
        }
        
        this.loading = false;
    }
}">

<div class="py-6">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="mb-8">
            <a href="<?php echo e(route('siswa.menu')); ?>" class="inline-flex items-center text-gray-600 hover:text-gray-900 mb-4">
                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Kembali ke Menu
            </a>
            <h1 class="text-3xl font-bold text-gray-900">Checkout</h1>
            <p class="mt-1 text-gray-600">Review pesanan sebelum konfirmasi</p>
        </div>

        
        <template x-if="cart.length === 0">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-12 text-center">
                <span class="text-6xl">🛒</span>
                <h2 class="text-2xl font-bold text-gray-900 mt-4">Keranjang Kosong</h2>
                <p class="text-gray-500 mt-2">Belum ada produk di keranjang</p>
                <a href="<?php echo e(route('siswa.menu')); ?>" class="inline-flex items-center mt-6 px-6 py-3 bg-indigo-600 text-white rounded-lg font-semibold hover:bg-indigo-700">
                    Lihat Menu
                </a>
            </div>
        </template>

        
        <template x-if="cart.length > 0">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <div class="lg:col-span-2 space-y-4">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                        <div class="p-6 border-b border-gray-200">
                            <h2 class="text-lg font-bold text-gray-900">Detail Pesanan</h2>
                        </div>
                        <div class="divide-y divide-gray-100">
                            <template x-for="item in cart" :key="item.id">
                                <div class="p-4">
                                    <div class="flex items-center justify-between mb-4">
                                        <h3 class="font-semibold text-gray-900" x-text="item.nama"></h3>
                                        <button @click="removeFromCart(item.id)" class="text-red-500 hover:text-red-700 text-sm">
                                            Hapus
                                        </button>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-4">
                                            <span class="text-gray-500" x-text="'Rp ' + formatRupiah(item.harga) + ' x'"></span>
                                            <div class="flex items-center border border-gray-200 rounded-lg">
                                                <button @click="updateQty(item.id, item.qty - 1)" 
                                                        class="px-3 py-1 text-gray-500 hover:text-gray-700 hover:bg-gray-50">-</button>
                                                <span class="px-4 py-1 font-medium" x-text="item.qty"></span>
                                                <button @click="updateQty(item.id, item.qty + 1)"
                                                        :disabled="item.qty >= item.stok"
                                                        class="px-3 py-1 text-gray-500 hover:text-gray-700 hover:bg-gray-50 disabled:opacity-50">+</button>
                                            </div>
                                        </div>
                                        <span class="font-bold text-indigo-600 text-lg" x-text="'Rp ' + formatRupiah(item.harga * item.qty)"></span>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>

                    
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Catatan (opsional)
                        </label>
                        <textarea 
                            x-model="catatan"
                            rows="3"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500"
                            placeholder="Contoh: Tidak pakai sambal, tambah sayur, dll"
                        ></textarea>
                    </div>
                </div>

                
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 sticky top-24">
                        <div class="p-6 border-b border-gray-200">
                            <h2 class="text-lg font-bold text-gray-900">Ringkasan Pesanan</h2>
                        </div>
                        <div class="p-6 space-y-4">
                            <template x-for="item in cart" :key="item.id">
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600" x-text="item.nama + ' x' + item.qty"></span>
                                    <span class="font-medium" x-text="'Rp ' + formatRupiah(item.harga * item.qty)"></span>
                                </div>
                            </template>
                            <div class="border-t border-gray-200 pt-4">
                                <div class="flex justify-between">
                                    <span class="font-bold text-gray-900">Total</span>
                                    <span class="text-2xl font-bold text-indigo-600" x-text="'Rp ' + formatRupiah(getTotal())"></span>
                                </div>
                            </div>
                        </div>
                        <div class="p-6 bg-gray-50 rounded-b-xl">
                            <button 
                                @click="submitOrder()"
                                :disabled="loading"
                                class="w-full px-6 py-3 bg-indigo-600 text-white rounded-lg font-semibold hover:bg-indigo-700 disabled:opacity-50 disabled:cursor-not-allowed transition">
                                <span x-show="!loading">Konfirmasi Pesanan</span>
                                <span x-show="loading">Memproses...</span>
                            </button>
                            <p class="text-xs text-gray-500 text-center mt-2">
                                Dengan menekan tombol di atas, pesanan akan diproses
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </div>
</div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\kantin-modern\resources\views/siswa/cart.blade.php ENDPATH**/ ?>