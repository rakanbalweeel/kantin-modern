



<?php $__env->startSection('title', 'Detail Produk'); ?>

<?php $__env->startSection('content'); ?>
<?php
    $categoryStyles = [
        'Makanan Berat' => ['icon' => 'fa-drumstick-bite', 'gradient' => 'from-orange-500 to-red-500', 'bg' => 'bg-orange-100', 'text' => 'text-orange-700'],
        'Makanan Ringan' => ['icon' => 'fa-cookie-bite', 'gradient' => 'from-green-500 to-emerald-500', 'bg' => 'bg-green-100', 'text' => 'text-green-700'],
        'Minuman' => ['icon' => 'fa-glass-water', 'gradient' => 'from-blue-500 to-cyan-500', 'bg' => 'bg-blue-100', 'text' => 'text-blue-700'],
        'Snack' => ['icon' => 'fa-candy-cane', 'gradient' => 'from-pink-500 to-rose-500', 'bg' => 'bg-pink-100', 'text' => 'text-pink-700'],
    ];
    $style = $categoryStyles[$product->category->nama] ?? ['icon' => 'fa-utensils', 'gradient' => 'from-indigo-500 to-purple-500', 'bg' => 'bg-indigo-100', 'text' => 'text-indigo-700'];
    
    $totalSold = $product->orderDetails->sum('jumlah');
    $totalRevenue = $product->orderDetails->sum('subtotal');
    $orderCount = $product->orderDetails->count();
    $avgQty = $orderCount > 0 ? round($totalSold / $orderCount, 1) : 0;
?>

<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 py-8">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="mb-8">
            <a href="<?php echo e(route('admin.products.index')); ?>" 
               class="group inline-flex items-center text-gray-500 hover:text-indigo-600 transition-all duration-300">
                <span class="flex items-center justify-center w-12 h-12 rounded-xl bg-white/80 backdrop-blur-sm shadow-lg border border-white/50 mr-3 group-hover:shadow-xl group-hover:border-indigo-200 group-hover:-translate-x-1 transition-all duration-300">
                    <i class="fas fa-arrow-left"></i>
                </span>
                <span class="font-semibold">Kembali ke Daftar Produk</span>
            </a>
        </div>

        
        <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-white/50 overflow-hidden mb-8">
            <div class="bg-gradient-to-r <?php echo e($style['gradient']); ?> p-6 relative overflow-hidden">
                
                <div class="absolute top-0 right-0 w-40 h-40 bg-white/10 rounded-full -mr-20 -mt-20"></div>
                <div class="absolute bottom-0 left-0 w-32 h-32 bg-white/10 rounded-full -ml-16 -mb-16"></div>
                
                <div class="relative flex items-center">
                    <div class="w-16 h-16 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center shadow-lg mr-4">
                        <i class="fas <?php echo e($style['icon']); ?> text-white text-2xl"></i>
                    </div>
                    <div>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-white/20 text-white mb-2">
                            <i class="fas <?php echo e($style['icon']); ?> mr-1.5 text-xs"></i>
                            <?php echo e($product->category->nama); ?>

                        </span>
                        <h1 class="text-2xl font-bold text-white"><?php echo e($product->nama); ?></h1>
                        <p class="text-white/80 text-sm mt-1 font-mono"><?php echo e($product->kode); ?></p>
                    </div>
                </div>
            </div>
            
            
            <div class="p-8">
                <div class="flex flex-col lg:flex-row gap-8">
                    
                    <div class="lg:w-1/3">
                        <div class="aspect-square rounded-2xl overflow-hidden shadow-lg border-4 border-white">
                            <?php if($product->gambar): ?>
                                <img src="<?php echo e(Storage::url($product->gambar)); ?>" 
                                     alt="<?php echo e($product->nama); ?>"
                                     class="w-full h-full object-cover">
                            <?php else: ?>
                                <div class="w-full h-full bg-gradient-to-br <?php echo e($style['gradient']); ?> flex items-center justify-center">
                                    <i class="fas <?php echo e($style['icon']); ?> text-white text-6xl opacity-50"></i>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    
                    <div class="lg:w-2/3">
                        <div class="flex items-start justify-between mb-6">
                            <div>
                                <p class="text-sm text-gray-500 mb-1">Harga</p>
                                <p class="text-4xl font-bold bg-gradient-to-r <?php echo e($style['gradient']); ?> bg-clip-text text-transparent">
                                    Rp <?php echo e(number_format($product->harga, 0, ',', '.')); ?>

                                </p>
                            </div>
                            
                            <div>
                                <?php if($product->stok <= 0): ?>
                                    <span class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-semibold bg-red-100 text-red-700">
                                        <i class="fas fa-times-circle mr-2"></i>Stok Habis
                                    </span>
                                <?php elseif($product->stok <= 10): ?>
                                    <span class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-semibold bg-amber-100 text-amber-700">
                                        <i class="fas fa-exclamation-triangle mr-2"></i><?php echo e($product->stok); ?> Tersisa
                                    </span>
                                <?php else: ?>
                                    <span class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-semibold bg-emerald-100 text-emerald-700">
                                        <i class="fas fa-check-circle mr-2"></i><?php echo e($product->stok); ?> Tersedia
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <?php if($product->deskripsi): ?>
                            <div class="mb-6">
                                <p class="text-sm font-semibold text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-align-left mr-2 text-gray-400"></i>Deskripsi
                                </p>
                                <p class="text-gray-600 leading-relaxed bg-gray-50 rounded-xl p-4"><?php echo e($product->deskripsi); ?></p>
                            </div>
                        <?php endif; ?>
                        
                        
                        <div class="grid grid-cols-2 gap-4 mb-6">
                            <div class="bg-gradient-to-br from-indigo-50 to-purple-50 rounded-xl p-4 border border-indigo-100">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-lg flex items-center justify-center mr-3">
                                        <i class="fas fa-calendar-plus text-white text-sm"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500">Dibuat</p>
                                        <p class="text-sm font-bold text-gray-800"><?php echo e($product->created_at->format('d M Y')); ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-gradient-to-br from-amber-50 to-orange-50 rounded-xl p-4 border border-amber-100">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-gradient-to-br from-amber-500 to-orange-600 rounded-lg flex items-center justify-center mr-3">
                                        <i class="fas fa-clock text-white text-sm"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500">Terakhir diubah</p>
                                        <p class="text-sm font-bold text-gray-800"><?php echo e($product->updated_at->format('d M Y')); ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        
                        <div class="flex flex-wrap gap-3">
                            <a href="<?php echo e(route('admin.products.edit', $product)); ?>" 
                               class="group flex-1 inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold rounded-xl hover:from-indigo-700 hover:to-purple-700 shadow-lg shadow-indigo-200 hover:shadow-xl hover:-translate-y-0.5 transition-all duration-300">
                                <i class="fas fa-edit mr-2 group-hover:scale-110 transition-transform"></i>
                                Edit Produk
                            </a>
                            <a href="<?php echo e(route('admin.categories.show', $product->category)); ?>" 
                               class="inline-flex items-center justify-center px-6 py-3 bg-white border-2 border-gray-200 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 hover:border-gray-300 transition-all duration-200">
                                <i class="fas fa-folder mr-2"></i>
                                Lihat Kategori
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-white/50 overflow-hidden mb-8">
            <div class="px-8 py-5 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white">
                <h3 class="text-lg font-bold text-gray-800 flex items-center">
                    <div class="w-10 h-10 bg-gradient-to-br from-emerald-500 to-green-600 rounded-xl flex items-center justify-center mr-3">
                        <i class="fas fa-chart-line text-white"></i>
                    </div>
                    Statistik Penjualan
                </h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="bg-gradient-to-br from-indigo-50 to-purple-50 rounded-2xl p-5 border border-indigo-100 hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
                        <div class="flex items-center justify-between mb-3">
                            <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg shadow-indigo-200">
                                <i class="fas fa-shopping-cart text-white"></i>
                            </div>
                        </div>
                        <p class="text-sm text-gray-500 mb-1">Total Terjual</p>
                        <p class="text-3xl font-bold text-gray-800"><?php echo e($totalSold); ?></p>
                    </div>
                    <div class="bg-gradient-to-br from-emerald-50 to-green-50 rounded-2xl p-5 border border-emerald-100 hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
                        <div class="flex items-center justify-between mb-3">
                            <div class="w-12 h-12 bg-gradient-to-br from-emerald-500 to-green-600 rounded-xl flex items-center justify-center shadow-lg shadow-emerald-200">
                                <i class="fas fa-money-bill-wave text-white"></i>
                            </div>
                        </div>
                        <p class="text-sm text-gray-500 mb-1">Total Pendapatan</p>
                        <p class="text-2xl font-bold text-emerald-600">Rp <?php echo e(number_format($totalRevenue, 0, ',', '.')); ?></p>
                    </div>
                    <div class="bg-gradient-to-br from-amber-50 to-orange-50 rounded-2xl p-5 border border-amber-100 hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
                        <div class="flex items-center justify-between mb-3">
                            <div class="w-12 h-12 bg-gradient-to-br from-amber-500 to-orange-600 rounded-xl flex items-center justify-center shadow-lg shadow-amber-200">
                                <i class="fas fa-receipt text-white"></i>
                            </div>
                        </div>
                        <p class="text-sm text-gray-500 mb-1">Jumlah Order</p>
                        <p class="text-3xl font-bold text-gray-800"><?php echo e($orderCount); ?></p>
                    </div>
                    <div class="bg-gradient-to-br from-pink-50 to-rose-50 rounded-2xl p-5 border border-pink-100 hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
                        <div class="flex items-center justify-between mb-3">
                            <div class="w-12 h-12 bg-gradient-to-br from-pink-500 to-rose-600 rounded-xl flex items-center justify-center shadow-lg shadow-pink-200">
                                <i class="fas fa-calculator text-white"></i>
                            </div>
                        </div>
                        <p class="text-sm text-gray-500 mb-1">Rata-rata Qty/Order</p>
                        <p class="text-3xl font-bold text-gray-800"><?php echo e($avgQty); ?></p>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-red-100 overflow-hidden">
            <div class="px-6 py-4 bg-gradient-to-r from-red-500 to-rose-500">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center mr-3">
                        <i class="fas fa-exclamation-triangle text-white"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-white">Zona Berbahaya</h3>
                        <p class="text-sm text-white/70">Aksi ini tidak dapat dibatalkan</p>
                    </div>
                </div>
            </div>
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="font-semibold text-gray-800">Hapus Produk</p>
                        <p class="text-sm text-gray-500">Produk akan dihapus secara permanen dari sistem</p>
                    </div>
                    <form action="<?php echo e(route('admin.products.destroy', $product)); ?>" 
                          method="POST"
                          onsubmit="return confirm('Yakin ingin menghapus produk <?php echo e($product->nama); ?>? Tindakan ini tidak dapat dibatalkan.')">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" 
                                class="px-6 py-3 bg-white border-2 border-red-200 text-red-600 font-semibold rounded-xl hover:bg-red-50 hover:border-red-300 transition-all duration-200 flex items-center">
                            <i class="fas fa-trash-alt mr-2"></i>
                            Hapus Produk
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\kantin-modern\resources\views/admin/products/show.blade.php ENDPATH**/ ?>