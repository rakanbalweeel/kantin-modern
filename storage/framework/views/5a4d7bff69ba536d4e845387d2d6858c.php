



<?php $__env->startSection('title', 'Detail Kategori'); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen hero-gradient py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="mb-6">
            <a href="<?php echo e(route('admin.categories.index')); ?>" 
               class="group inline-flex items-center text-slate-400 hover:text-orange-400 transition-all duration-300">
                <span class="flex items-center justify-center w-10 h-10 rounded-xl glass mr-3 group-hover:-translate-x-1 transition-all duration-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </span>
                <span class="font-medium">Kembali</span>
            </a>
        </div>

        
        <div class="glass-card rounded-2xl p-6 mb-8">
            <div class="flex items-start justify-between">
                <div class="flex items-center">
                    <div class="w-16 h-16 bg-gradient-to-br from-orange-500 to-amber-500 rounded-2xl flex items-center justify-center mr-4 shadow-lg shadow-orange-500/20">
                        <i class="fas fa-folder text-white text-2xl"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-white"><?php echo e($category->nama); ?></h1>
                        <p class="text-slate-400"><?php echo e($category->deskripsi ?: 'Tidak ada deskripsi'); ?></p>
                    </div>
                </div>
                <div class="flex space-x-2">
                    <a href="<?php echo e(route('admin.categories.edit', $category)); ?>" 
                       class="px-4 py-2 bg-amber-500/20 text-amber-400 rounded-xl hover:bg-amber-500/30 transition">
                        <i class="fas fa-edit mr-2"></i>Edit
                    </a>
                    <form action="<?php echo e(route('admin.categories.destroy', $category)); ?>" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="px-4 py-2 bg-red-500/20 text-red-400 rounded-xl hover:bg-red-500/30 transition">
                            <i class="fas fa-trash mr-2"></i>Hapus
                        </button>
                    </form>
                </div>
            </div>
            
            <div class="mt-6 grid grid-cols-2 gap-4">
                <div class="bg-slate-800/50 rounded-xl p-4">
                    <p class="text-sm text-slate-400 mb-1">Total Produk</p>
                    <p class="text-2xl font-bold text-orange-400"><?php echo e($category->products->count()); ?></p>
                </div>
                <div class="bg-slate-800/50 rounded-xl p-4">
                    <p class="text-sm text-slate-400 mb-1">ID Kategori</p>
                    <p class="text-2xl font-bold text-white"><?php echo e($category->id); ?></p>
                </div>
            </div>
        </div>

        
        <div class="glass-card rounded-2xl overflow-hidden">
            <div class="bg-gradient-to-r from-orange-500 to-amber-500 px-6 py-4">
                <h2 class="text-lg font-bold text-white flex items-center">
                    <i class="fas fa-utensils mr-2"></i> Produk dalam Kategori
                </h2>
            </div>
            
            <?php if($category->products->count() > 0): ?>
                <div class="divide-y divide-slate-700/50">
                    <?php $__currentLoopData = $category->products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="p-4 flex items-center justify-between hover:bg-white/5 transition-colors">
                            <div class="flex items-center">
                                <?php if($product->gambar): ?>
                                    <img src="<?php echo e(asset('storage/' . $product->gambar)); ?>" alt="<?php echo e($product->nama); ?>" class="w-12 h-12 rounded-xl object-cover mr-4">
                                <?php else: ?>
                                    <div class="w-12 h-12 bg-slate-700 rounded-xl flex items-center justify-center mr-4">
                                        <i class="fas fa-image text-slate-500"></i>
                                    </div>
                                <?php endif; ?>
                                <div>
                                    <p class="font-semibold text-white"><?php echo e($product->nama); ?></p>
                                    <p class="text-sm text-slate-400">Stok: <?php echo e($product->stok); ?></p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="font-bold text-orange-400">Rp <?php echo e(number_format($product->harga, 0, ',', '.')); ?></p>
                                <a href="<?php echo e(route('admin.products.show', $product)); ?>" class="text-sm text-slate-400 hover:text-orange-400">
                                    Lihat Detail →
                                </a>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php else: ?>
                <div class="p-12 text-center">
                    <div class="w-16 h-16 bg-slate-800 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-box-open text-2xl text-slate-600"></i>
                    </div>
                    <p class="text-slate-400">Belum ada produk dalam kategori ini</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\kantin-modern\resources\views/admin/categories/show.blade.php ENDPATH**/ ?>