



<?php $__env->startSection('title', 'Menu Kantin'); ?>

<?php $__env->startSection('content'); ?>

<div x-data="{
    cart: JSON.parse(localStorage.getItem('kantin_cart') || '[]'),
    showTopupModal: false,
    showNotification: false,
    notificationMessage: '',
    topupAmount: '',
    topupPresets: [25000, 50000, 100000, 200000],
    
    addToCart(product) {
        console.log('Adding to cart:', product);
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
        window.location.href = '<?php echo e(route('siswa.cart')); ?>';
    }
}" class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50">

    
    <div x-show="showNotification" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform translate-y-2"
         x-transition:enter-end="opacity-100 transform translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed top-20 right-4 z-50 bg-green-500 text-white px-6 py-3 rounded-xl shadow-lg flex items-center space-x-2">
        <i class="fas fa-check-circle"></i>
        <span x-text="notificationMessage"></span>
    </div>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="mb-10 text-center lg:text-left">
                <h1 class="text-4xl font-extrabold bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-500 bg-clip-text text-transparent">
                    Menu Kantin
                </h1>
                <p class="mt-2 text-gray-500 text-lg">Pilih makanan dan minuman favoritmu! 🍽️</p>
            </div>

            <div class="flex flex-col lg:flex-row gap-8">
                
                <div class="lg:w-80 order-2 lg:order-2">
                    <div class="sticky top-24 space-y-5">
                        
                        <div class="relative overflow-hidden bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-500 rounded-2xl shadow-2xl p-6 text-white transform hover:scale-[1.02] transition-all duration-300">
                            
                            <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-white/10 rounded-full blur-2xl"></div>
                            <div class="absolute bottom-0 left-0 -mb-4 -ml-4 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
                            
                            <div class="relative flex items-center mb-5">
                                <div class="w-14 h-14 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center mr-4 shadow-lg">
                                    <i class="fas fa-wallet text-2xl"></i>
                                </div>
                                <div>
                                    <p class="text-white/70 text-sm font-medium">Saldo Virtual</p>
                                    <h3 class="text-3xl font-bold tracking-tight">Rp <?php echo e(number_format(auth()->user()->saldo ?? 0, 0, ',', '.')); ?></h3>
                                </div>
                            </div>
                            <hr class="border-white/20 my-4">
                            <div class="relative flex items-center justify-between text-sm">
                                <div class="flex items-center bg-white/10 px-3 py-1.5 rounded-full">
                                    <i class="fas fa-user mr-2"></i>
                                    <span class="font-medium"><?php echo e(auth()->user()->name); ?></span>
                                </div>
                                <div class="flex items-center bg-white/10 px-3 py-1.5 rounded-full">
                                    <i class="fas fa-envelope mr-2"></i>
                                    <span class="font-medium text-xs"><?php echo e(Str::limit(auth()->user()->email, 15)); ?></span>
                                </div>
                            </div>
                            
                            
                            <button @click="showTopupModal = true" 
                                    class="w-full mt-5 px-5 py-3 bg-white/20 hover:bg-white/30 backdrop-blur-sm rounded-xl font-semibold transition-all duration-300 flex items-center justify-center group">
                                <i class="fas fa-plus-circle mr-2 group-hover:scale-110 transition-transform"></i>
                                Top Up Saldo
                            </button>
                        </div>
                        
                        
                        <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-white/50 p-6 hover:shadow-xl transition-all duration-300">
                            <h4 class="font-bold text-gray-800 mb-4 flex items-center text-lg">
                                <span class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-info-circle text-blue-600"></i>
                                </span>
                                Informasi
                            </h4>
                            <ul class="space-y-3 text-sm text-gray-600">
                                <li class="flex items-start p-2 rounded-lg hover:bg-green-50 transition-colors">
                                    <span class="w-5 h-5 bg-green-100 rounded-full flex items-center justify-center mr-3 mt-0.5 flex-shrink-0">
                                        <i class="fas fa-check text-green-500 text-xs"></i>
                                    </span>
                                    <span>Saldo digunakan untuk pembelian di kantin</span>
                                </li>
                                <li class="flex items-start p-2 rounded-lg hover:bg-green-50 transition-colors">
                                    <span class="w-5 h-5 bg-green-100 rounded-full flex items-center justify-center mr-3 mt-0.5 flex-shrink-0">
                                        <i class="fas fa-check text-green-500 text-xs"></i>
                                    </span>
                                    <span>Top up saldo dapat menghubungi admin</span>
                                </li>
                                <li class="flex items-start p-2 rounded-lg hover:bg-green-50 transition-colors">
                                    <span class="w-5 h-5 bg-green-100 rounded-full flex items-center justify-center mr-3 mt-0.5 flex-shrink-0">
                                        <i class="fas fa-check text-green-500 text-xs"></i>
                                    </span>
                                    <span>Semua transaksi tercatat aman</span>
                                </li>
                                <li class="flex items-start p-2 rounded-lg hover:bg-green-50 transition-colors">
                                    <span class="w-5 h-5 bg-green-100 rounded-full flex items-center justify-center mr-3 mt-0.5 flex-shrink-0">
                                        <i class="fas fa-check text-green-500 text-xs"></i>
                                    </span>
                                    <span>Riwayat dapat dilihat di menu Riwayat</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                
                <div class="flex-1 order-1 lg:order-1">
                    
                    <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg p-4 mb-8 border border-white/50">
                        <div class="flex flex-wrap gap-3">
                            <a href="<?php echo e(route('siswa.menu')); ?>" 
                               class="px-5 py-2.5 rounded-xl font-medium transition-all duration-300 <?php echo e(!request('category') ? 'bg-gradient-to-r from-indigo-600 to-purple-600 text-white shadow-lg shadow-indigo-200 scale-105' : 'bg-gray-100 text-gray-600 hover:bg-gray-200 hover:scale-105'); ?>">
                                <i class="fas fa-th-large mr-2"></i>Semua
                            </a>
                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $icons = ['Makanan Berat' => 'fa-drumstick-bite', 'Makanan Ringan' => 'fa-cookie-bite', 'Minuman' => 'fa-glass-water', 'Snack' => 'fa-candy-cane'];
                                    $icon = $icons[$category->nama] ?? 'fa-utensils';
                                ?>
                                <a href="<?php echo e(route('siswa.menu', ['category' => $category->id])); ?>" 
                                   class="px-5 py-2.5 rounded-xl font-medium transition-all duration-300 <?php echo e(request('category') == $category->id ? 'bg-gradient-to-r from-indigo-600 to-purple-600 text-white shadow-lg shadow-indigo-200 scale-105' : 'bg-gray-100 text-gray-600 hover:bg-gray-200 hover:scale-105'); ?>">
                                    <i class="fas <?php echo e($icon); ?> mr-2"></i><?php echo e($category->nama); ?>

                                </a>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>

                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6">
                        <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <?php
                                // Tentukan emoji/icon berdasarkan kategori
                                $categoryEmojis = [
                                    'Makanan Berat' => '🍛',
                                    'Makanan Ringan' => '🍿',
                                    'Minuman' => '🥤',
                                    'Snack' => '🍪',
                                ];
                                $defaultEmoji = $categoryEmojis[$product->category->nama] ?? '🍽️';
                                
                                // Tentukan gradient berdasarkan kategori
                                $gradients = [
                                    'Makanan Berat' => 'from-orange-100 via-amber-50 to-yellow-100',
                                    'Makanan Ringan' => 'from-green-100 via-emerald-50 to-teal-100',
                                    'Minuman' => 'from-blue-100 via-cyan-50 to-sky-100',
                                    'Snack' => 'from-pink-100 via-rose-50 to-red-100',
                                ];
                                $defaultGradient = $gradients[$product->category->nama] ?? 'from-indigo-100 via-purple-50 to-pink-100';
                            ?>
                            <div class="group bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-white/50 overflow-hidden hover:shadow-2xl hover:-translate-y-2 transition-all duration-500">
                                
                                <div class="relative overflow-hidden">
                                    <?php if($product->gambar): ?>
                                        <img src="<?php echo e(Storage::url($product->gambar)); ?>" 
                                             alt="<?php echo e($product->nama); ?>"
                                             class="w-full h-52 object-cover group-hover:scale-110 transition-transform duration-500">
                                    <?php else: ?>
                                        <div class="w-full h-52 bg-gradient-to-br <?php echo e($defaultGradient); ?> flex items-center justify-center relative overflow-hidden">
                                            
                                            <div class="absolute top-0 right-0 w-24 h-24 bg-white/30 rounded-full -mr-12 -mt-12"></div>
                                            <div class="absolute bottom-0 left-0 w-32 h-32 bg-white/20 rounded-full -ml-16 -mb-16"></div>
                                            <span class="text-7xl group-hover:scale-125 transition-transform duration-500 drop-shadow-lg"><?php echo e($defaultEmoji); ?></span>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                    
                                    <div class="absolute top-3 left-3">
                                        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold bg-white/90 backdrop-blur-sm text-indigo-700 shadow-lg">
                                            <i class="fas fa-tag mr-1.5"></i><?php echo e($product->category->nama); ?>

                                        </span>
                                    </div>
                                    
                                    <div class="absolute top-3 right-3">
                                        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold <?php echo e($product->stok > 10 ? 'bg-green-500' : ($product->stok > 0 ? 'bg-amber-500' : 'bg-red-500')); ?> text-white shadow-lg">
                                            <i class="fas <?php echo e($product->stok > 0 ? 'fa-check-circle' : 'fa-times-circle'); ?> mr-1.5"></i>
                                            <?php echo e($product->stok > 0 ? "Stok: {$product->stok}" : 'Habis'); ?>

                                        </span>
                                    </div>
                                </div>
                                
                                
                                <div class="p-5">
                                    <h3 class="font-bold text-gray-800 text-lg mb-2 group-hover:text-indigo-600 transition-colors"><?php echo e($product->nama); ?></h3>
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="text-sm text-gray-400 line-through" style="display: none;">Rp <?php echo e(number_format($product->harga * 1.1, 0, ',', '.')); ?></p>
                                            <p class="text-2xl font-extrabold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
                                                Rp <?php echo e(number_format($product->harga, 0, ',', '.')); ?>

                                            </p>
                                        </div>
                                        <?php if($product->stok > 0): ?>
                                            <button 
                                                @click="addToCart({
                                                    id: <?php echo e($product->id); ?>,
                                                    nama: <?php echo e(json_encode($product->nama)); ?>,
                                                    harga: <?php echo e($product->harga); ?>,
                                                    stok: <?php echo e($product->stok); ?>

                                                })"
                                                class="relative inline-flex items-center px-5 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl font-semibold hover:from-indigo-700 hover:to-purple-700 hover:shadow-lg hover:shadow-indigo-300 transform hover:scale-105 active:scale-95 transition-all duration-300">
                                                <i class="fas fa-plus mr-2"></i>
                                                Pesan
                                            </button>
                                        <?php else: ?>
                                            <button disabled class="px-5 py-3 bg-gray-200 text-gray-400 rounded-xl font-semibold cursor-not-allowed">
                                                <i class="fas fa-ban mr-2"></i>Habis
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <div class="col-span-full">
                                <div class="text-center py-16 bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg">
                                    <span class="text-8xl mb-4 block">🍽️</span>
                                    <h3 class="text-2xl font-bold text-gray-700 mb-2">Belum ada produk tersedia</h3>
                                    <p class="text-gray-500">Tunggu update menu terbaru dari kantin ya!</p>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>

                    
                    <?php if($products->hasPages()): ?>
                        <div class="mt-10 flex justify-center">
                            <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg p-4 border border-white/50">
                                <?php echo e($products->withQueryString()->links()); ?>

                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    
    <div x-show="showTopupModal" 
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
        
        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm" @click="showTopupModal = false"></div>
        
        
        <div class="relative min-h-screen flex items-center justify-center p-4">
            <div class="relative bg-white rounded-3xl shadow-2xl max-w-md w-full overflow-hidden"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                 x-transition:leave-end="opacity-0 scale-95 translate-y-4"
                 @click.away="showTopupModal = false">
                
                
                <div class="bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-500 px-6 py-5 text-white">
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
                
                
                <form action="<?php echo e(route('siswa.saldo.topup')); ?>" method="POST" class="p-6">
                    <?php echo csrf_field(); ?>
                    
                    
                    <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-2xl p-4 mb-6">
                        <p class="text-gray-500 text-sm mb-1">Saldo Saat Ini</p>
                        <p class="text-2xl font-bold text-gray-800">Rp <?php echo e(number_format(auth()->user()->saldo ?? 0, 0, ',', '.')); ?></p>
                    </div>
                    
                    
                    <div class="mb-5">
                        <label class="block text-gray-700 font-medium mb-3">Pilih Nominal</label>
                        <div class="grid grid-cols-2 gap-3">
                            <template x-for="preset in topupPresets" :key="preset">
                                <button type="button" 
                                        @click="topupAmount = preset"
                                        :class="topupAmount == preset ? 'ring-2 ring-indigo-500 bg-indigo-50 text-indigo-700' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
                                        class="px-4 py-3 rounded-xl font-semibold transition-all duration-200">
                                    <span x-text="'Rp ' + new Intl.NumberFormat('id-ID').format(preset)"></span>
                                </button>
                            </template>
                        </div>
                    </div>
                    
                    
                    <div class="mb-6">
                        <label class="block text-gray-700 font-medium mb-2">Atau Masukkan Nominal Lain</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 font-medium">Rp</span>
                            <input type="number" 
                                   name="jumlah" 
                                   x-model="topupAmount"
                                   min="10000" 
                                   max="1000000"
                                   placeholder="Min 10.000"
                                   class="w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all text-lg font-medium"
                                   required>
                        </div>
                        <p class="text-gray-400 text-xs mt-2">Minimal Rp 10.000 - Maksimal Rp 1.000.000</p>
                    </div>
                    
                    
                    <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 mb-6">
                        <div class="flex items-start">
                            <i class="fas fa-info-circle text-amber-500 mt-0.5 mr-3"></i>
                            <div class="text-sm text-amber-700">
                                <p class="font-semibold mb-1">Cara Top Up:</p>
                                <ol class="list-decimal list-inside space-y-1 text-amber-600">
                                    <li>Ajukan request top up</li>
                                    <li>Hubungi admin untuk pembayaran</li>
                                    <li>Saldo otomatis masuk setelah disetujui</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                    
                    
                    <button type="submit" 
                            :disabled="!topupAmount || topupAmount < 10000"
                            :class="(!topupAmount || topupAmount < 10000) ? 'bg-gray-300 cursor-not-allowed' : 'bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 shadow-lg hover:shadow-xl'"
                            class="w-full py-4 text-white rounded-xl font-bold text-lg transition-all duration-300 flex items-center justify-center">
                        <i class="fas fa-paper-plane mr-2"></i>
                        Ajukan Top Up
                    </button>
                </form>
            </div>
        </div>
    </div>

    
    <div x-show="cart.length > 0" 
         x-transition
         class="fixed bottom-6 right-6 z-40">
        <button @click="checkout()" 
                class="flex items-center space-x-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-6 py-4 rounded-2xl shadow-2xl hover:from-indigo-700 hover:to-purple-700 transform hover:scale-105 transition-all duration-300">
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\kantin-modern\resources\views/siswa/menu.blade.php ENDPATH**/ ?>