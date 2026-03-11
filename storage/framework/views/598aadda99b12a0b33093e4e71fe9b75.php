



<?php $__env->startSection('title', 'Kelola Produk'); ?>

<?php $__env->startSection('content'); ?>
<?php
    $totalProducts = $products->total();
    $lowStockCount = $products->filter(fn($p) => $p->stok <= 10 && $p->stok > 0)->count();
    $outOfStockCount = $products->filter(fn($p) => $p->stok <= 0)->count();
?>

<div class="min-h-screen hero-gradient py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="mb-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div class="flex items-center mb-4 md:mb-0">
                    <div class="w-14 h-14 bg-gradient-to-br from-orange-500 to-amber-500 rounded-2xl flex items-center justify-center shadow-lg shadow-orange-500/20 mr-4">
                        <i class="fas fa-utensils text-white text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold text-white">Kelola <span class="gradient-text">Produk</span></h1>
                        <p class="text-slate-400 mt-1">Daftar semua menu makanan dan minuman</p>
                    </div>
                </div>
                <a href="<?php echo e(route('admin.products.create')); ?>" 
                   class="group inline-flex items-center px-6 py-3 bg-gradient-to-r from-orange-500 to-amber-500 text-white font-semibold rounded-xl shadow-lg shadow-orange-500/20 hover:shadow-orange-500/40 hover:-translate-y-0.5 transition-all duration-300">
                    <i class="fas fa-plus mr-2 group-hover:rotate-90 transition-transform duration-300"></i>
                    Tambah Produk
                </a>
            </div>
        </div>

        
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
            <div class="glass-card rounded-2xl p-5 hover:bg-white/5 transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-400 mb-1">Total Produk</p>
                        <p class="text-2xl font-bold text-white"><?php echo e($totalProducts); ?></p>
                    </div>
                    <div class="w-12 h-12 bg-gradient-to-br from-orange-500 to-amber-500 rounded-xl flex items-center justify-center">
                        <i class="fas fa-boxes-stacked text-white"></i>
                    </div>
                </div>
            </div>
            <div class="glass-card rounded-2xl p-5 hover:bg-white/5 transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-400 mb-1">Stok Tersedia</p>
                        <p class="text-2xl font-bold text-emerald-400"><?php echo e($totalProducts - $lowStockCount - $outOfStockCount); ?></p>
                    </div>
                    <div class="w-12 h-12 bg-gradient-to-br from-emerald-500 to-green-600 rounded-xl flex items-center justify-center">
                        <i class="fas fa-check-circle text-white"></i>
                    </div>
                </div>
            </div>
            <div class="glass-card rounded-2xl p-5 hover:bg-white/5 transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-400 mb-1">Stok Menipis</p>
                        <p class="text-2xl font-bold text-amber-400"><?php echo e($lowStockCount); ?></p>
                    </div>
                    <div class="w-12 h-12 bg-gradient-to-br from-amber-500 to-orange-600 rounded-xl flex items-center justify-center">
                        <i class="fas fa-exclamation-triangle text-white"></i>
                    </div>
                </div>
            </div>
            <div class="glass-card rounded-2xl p-5 hover:bg-white/5 transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-400 mb-1">Stok Habis</p>
                        <p class="text-2xl font-bold text-red-400"><?php echo e($outOfStockCount); ?></p>
                    </div>
                    <div class="w-12 h-12 bg-gradient-to-br from-red-500 to-rose-600 rounded-xl flex items-center justify-center">
                        <i class="fas fa-times-circle text-white"></i>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="glass-card rounded-2xl overflow-hidden">
            <div class="bg-gradient-to-r from-orange-500 to-amber-500 px-6 py-4">
                <h2 class="text-lg font-bold text-white flex items-center">
                    <i class="fas fa-list mr-2"></i> Daftar Produk
                </h2>
            </div>
            
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="bg-slate-800/50">
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-400 uppercase">Produk</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-400 uppercase">Kategori</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-400 uppercase">Harga</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-slate-400 uppercase">Stok</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-slate-400 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-700/50">
                        <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="hover:bg-white/5 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <?php if($product->gambar): ?>
                                            <img src="<?php echo e(asset('storage/' . $product->gambar)); ?>" alt="<?php echo e($product->nama); ?>" class="w-12 h-12 rounded-xl object-cover mr-4 border border-slate-700">
                                        <?php else: ?>
                                            <div class="w-12 h-12 bg-slate-700 rounded-xl flex items-center justify-center mr-4">
                                                <i class="fas fa-image text-slate-500"></i>
                                            </div>
                                        <?php endif; ?>
                                        <div>
                                            <p class="font-semibold text-white"><?php echo e($product->nama); ?></p>
                                            <p class="text-xs text-slate-500"><?php echo e(Str::limit($product->deskripsi, 30)); ?></p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 bg-orange-500/20 text-orange-400 rounded-lg text-sm border border-orange-500/30">
                                        <?php echo e($product->category->nama ?? '-'); ?>

                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="font-bold text-orange-400">Rp <?php echo e(number_format($product->harga, 0, ',', '.')); ?></span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <?php if($product->stok <= 0): ?>
                                        <span class="px-3 py-1 bg-red-500/20 text-red-400 rounded-lg text-sm border border-red-500/30">Habis</span>
                                    <?php elseif($product->stok <= 10): ?>
                                        <span class="px-3 py-1 bg-amber-500/20 text-amber-400 rounded-lg text-sm border border-amber-500/30"><?php echo e($product->stok); ?></span>
                                    <?php else: ?>
                                        <span class="px-3 py-1 bg-emerald-500/20 text-emerald-400 rounded-lg text-sm border border-emerald-500/30"><?php echo e($product->stok); ?></span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center space-x-2">
                                        <a href="<?php echo e(route('admin.products.show', $product)); ?>" class="w-10 h-10 inline-flex items-center justify-center bg-slate-700 hover:bg-blue-500 text-slate-300 hover:text-white rounded-xl transition-all" title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="<?php echo e(route('admin.products.edit', $product)); ?>" class="w-10 h-10 inline-flex items-center justify-center bg-slate-700 hover:bg-amber-500 text-slate-300 hover:text-white rounded-xl transition-all" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="<?php echo e(route('admin.products.destroy', $product)); ?>" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="w-10 h-10 inline-flex items-center justify-center bg-slate-700 hover:bg-red-500 text-slate-300 hover:text-white rounded-xl transition-all" title="Hapus">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center">
                                    <div class="w-16 h-16 bg-slate-800 rounded-full flex items-center justify-center mx-auto mb-4">
                                        <i class="fas fa-box-open text-2xl text-slate-600"></i>
                                    </div>
                                    <p class="text-slate-400 font-medium">Belum ada produk</p>
                                    <a href="<?php echo e(route('admin.products.create')); ?>" class="text-orange-400 hover:underline mt-2 inline-block">Tambah produk pertama</a>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            
            <?php if($products->hasPages()): ?>
                <div class="px-6 py-4 border-t border-slate-700">
                    <?php echo e($products->links()); ?>

                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\kantin-modern\resources\views/admin/products/index.blade.php ENDPATH**/ ?>