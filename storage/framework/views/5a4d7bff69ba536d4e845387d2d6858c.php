



<?php $__env->startSection('title', 'Detail Kategori'); ?>

<?php $__env->startSection('content'); ?>
<?php
    $icons = [
        'Makanan Berat' => ['icon' => 'fa-drumstick-bite', 'gradient' => 'from-orange-500 to-red-500', 'bg' => 'from-orange-100 to-red-100'],
        'Makanan Ringan' => ['icon' => 'fa-cookie-bite', 'gradient' => 'from-green-500 to-emerald-500', 'bg' => 'from-green-100 to-emerald-100'],
        'Minuman' => ['icon' => 'fa-glass-water', 'gradient' => 'from-blue-500 to-cyan-500', 'bg' => 'from-blue-100 to-cyan-100'],
        'Snack' => ['icon' => 'fa-candy-cane', 'gradient' => 'from-pink-500 to-rose-500', 'bg' => 'from-pink-100 to-rose-100'],
    ];
    $config = $icons[$category->nama] ?? ['icon' => 'fa-utensils', 'gradient' => 'from-indigo-500 to-purple-500', 'bg' => 'from-indigo-100 to-purple-100'];
?>

<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="mb-8">
            <a href="<?php echo e(route('admin.categories.index')); ?>" 
               class="group inline-flex items-center text-gray-500 hover:text-indigo-600 transition-all duration-300">
                <span class="flex items-center justify-center w-12 h-12 rounded-xl bg-white/80 backdrop-blur-sm shadow-lg border border-white/50 mr-3 group-hover:shadow-xl group-hover:border-indigo-200 group-hover:-translate-x-1 transition-all duration-300">
                    <i class="fas fa-arrow-left"></i>
                </span>
                <span class="font-semibold">Kembali ke Daftar Kategori</span>
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="lg:col-span-1">
                <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-white/50 overflow-hidden hover:shadow-xl transition-all duration-300">
                    
                    <div class="bg-gradient-to-r <?php echo e($config['gradient']); ?> p-6 relative overflow-hidden">
                        
                        <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -mr-16 -mt-16"></div>
                        <div class="absolute bottom-0 left-0 w-24 h-24 bg-white/10 rounded-full -ml-12 -mb-12"></div>
                        
                        <div class="relative flex items-center">
                            <div class="w-20 h-20 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center shadow-lg">
                                <i class="fas <?php echo e($config['icon']); ?> text-white text-3xl"></i>
                            </div>
                            <div class="ml-4">
                                <h1 class="text-2xl font-bold text-white"><?php echo e($category->nama); ?></h1>
                                <p class="text-white/80 text-sm mt-1">ID: #<?php echo e($category->id); ?></p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="p-6">
                        <?php if($category->deskripsi): ?>
                            <div class="mb-6 p-4 bg-gradient-to-br <?php echo e($config['bg']); ?> rounded-xl">
                                <p class="text-gray-700"><?php echo e($category->deskripsi); ?></p>
                            </div>
                        <?php endif; ?>

                        
                        <div class="space-y-4 mb-6">
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl hover:bg-indigo-50 transition-colors group">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-lg flex items-center justify-center mr-3 group-hover:scale-110 transition-transform">
                                        <i class="fas fa-box text-white"></i>
                                    </div>
                                    <span class="text-gray-600">Jumlah Produk</span>
                                </div>
                                <span class="text-xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent"><?php echo e($category->products->count()); ?></span>
                            </div>
                            
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl hover:bg-green-50 transition-colors group">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-gradient-to-br from-emerald-500 to-green-600 rounded-lg flex items-center justify-center mr-3 group-hover:scale-110 transition-transform">
                                        <i class="fas fa-calendar-plus text-white"></i>
                                    </div>
                                    <span class="text-gray-600">Dibuat</span>
                                </div>
                                <span class="font-semibold text-gray-800"><?php echo e($category->created_at->format('d M Y')); ?></span>
                            </div>
                            
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl hover:bg-amber-50 transition-colors group">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-gradient-to-br from-amber-500 to-orange-600 rounded-lg flex items-center justify-center mr-3 group-hover:scale-110 transition-transform">
                                        <i class="fas fa-clock text-white"></i>
                                    </div>
                                    <span class="text-gray-600">Terakhir diubah</span>
                                </div>
                                <span class="font-semibold text-gray-800"><?php echo e($category->updated_at->format('d M Y')); ?></span>
                            </div>
                        </div>

                        
                        <div class="space-y-3">
                            <a href="<?php echo e(route('admin.categories.edit', $category)); ?>" 
                               class="group flex items-center justify-center w-full px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold rounded-xl hover:from-indigo-700 hover:to-purple-700 shadow-lg shadow-indigo-200 hover:shadow-xl hover:-translate-y-0.5 transition-all duration-300">
                                <i class="fas fa-edit mr-2 group-hover:scale-110 transition-transform"></i>
                                Edit Kategori
                            </a>
                            <form action="<?php echo e(route('admin.categories.destroy', $category)); ?>" 
                                  method="POST"
                                  onsubmit="return confirm('Yakin ingin menghapus kategori <?php echo e($category->nama); ?>? Semua produk dalam kategori ini juga akan terhapus!')">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" 
                                        class="group flex items-center justify-center w-full px-6 py-3 bg-white border-2 border-red-200 text-red-600 font-semibold rounded-xl hover:bg-red-50 hover:border-red-300 hover:shadow-lg transition-all duration-300">
                                    <i class="fas fa-trash-alt mr-2 group-hover:scale-110 transition-transform"></i>
                                    Hapus Kategori
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="lg:col-span-2">
                <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-white/50 overflow-hidden hover:shadow-xl transition-all duration-300">
                    
                    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center mr-3">
                                    <i class="fas fa-utensils text-white"></i>
                                </div>
                                <div>
                                    <h2 class="text-lg font-bold text-white">Produk dalam Kategori Ini</h2>
                                    <p class="text-sm text-white/70"><?php echo e($category->products->count()); ?> produk tersedia</p>
                                </div>
                            </div>
                            <a href="<?php echo e(route('admin.products.create')); ?>" 
                               class="inline-flex items-center px-4 py-2 bg-white/20 hover:bg-white/30 text-white font-medium rounded-xl transition-all duration-200">
                                <i class="fas fa-plus mr-2"></i>
                                Tambah Produk
                            </a>
                        </div>
                    </div>

                    <div class="divide-y divide-gray-100">
                        <?php $__empty_1 = true; $__currentLoopData = $category->products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <div class="p-5 hover:bg-indigo-50/50 transition-colors duration-200 group">
                                <div class="flex items-center">
                                    <?php if($product->gambar): ?>
                                        <img src="<?php echo e(Storage::url($product->gambar)); ?>" 
                                             alt="<?php echo e($product->nama); ?>"
                                             class="w-16 h-16 rounded-xl object-cover shadow-md group-hover:scale-105 transition-transform duration-300">
                                    <?php else: ?>
                                        <?php
                                            $productEmojis = [
                                                'Makanan Berat' => '🍛',
                                                'Makanan Ringan' => '🍿',
                                                'Minuman' => '🥤',
                                                'Snack' => '🍪',
                                            ];
                                            $emoji = $productEmojis[$category->nama] ?? '🍽️';
                                        ?>
                                        <div class="w-16 h-16 rounded-xl bg-gradient-to-br <?php echo e($config['bg']); ?> flex items-center justify-center shadow-md group-hover:scale-105 transition-transform duration-300">
                                            <span class="text-3xl"><?php echo e($emoji); ?></span>
                                        </div>
                                    <?php endif; ?>
                                    <div class="ml-4 flex-1">
                                        <h3 class="font-bold text-gray-800 group-hover:text-indigo-600 transition-colors"><?php echo e($product->nama); ?></h3>
                                        <p class="text-sm text-gray-500 flex items-center">
                                            <i class="fas fa-barcode mr-1.5 text-xs"></i>
                                            <?php echo e($product->kode); ?>

                                        </p>
                                    </div>
                                    <div class="text-right mr-4">
                                        <p class="text-lg font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
                                            Rp <?php echo e(number_format($product->harga, 0, ',', '.')); ?>

                                        </p>
                                        <?php
                                            $stockClass = $product->stok > 10 
                                                ? 'bg-gradient-to-r from-emerald-500 to-green-500' 
                                                : ($product->stok > 0 ? 'bg-gradient-to-r from-amber-500 to-yellow-500' : 'bg-gradient-to-r from-red-500 to-rose-500');
                                        ?>
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold text-white <?php echo e($stockClass); ?>">
                                            <i class="fas fa-box mr-1"></i>
                                            Stok: <?php echo e($product->stok); ?>

                                        </span>
                                    </div>
                                    <a href="<?php echo e(route('admin.products.edit', $product)); ?>" 
                                       class="w-10 h-10 inline-flex items-center justify-center bg-gray-100 hover:bg-indigo-500 text-gray-600 hover:text-white rounded-xl transition-all duration-200 hover:scale-110 hover:shadow-lg">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <div class="p-12 text-center">
                                <div class="w-24 h-24 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i class="fas fa-box-open text-4xl text-gray-300"></i>
                                </div>
                                <h3 class="text-xl font-bold text-gray-700 mb-2">Belum ada produk</h3>
                                <p class="text-gray-500 mb-4">Kategori ini belum memiliki produk</p>
                                <a href="<?php echo e(route('admin.products.create')); ?>" 
                                   class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold rounded-xl hover:from-indigo-700 hover:to-purple-700 shadow-lg shadow-indigo-200 hover:shadow-xl transition-all duration-300">
                                    <i class="fas fa-plus mr-2"></i>
                                    Tambah Produk Pertama
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                
                <?php if($category->products->count() > 0): ?>
                    <div class="grid grid-cols-3 gap-4 mt-6">
                        <div class="bg-white/80 backdrop-blur-sm rounded-xl p-4 border border-white/50 shadow-sm hover:shadow-md transition-all text-center">
                            <div class="w-10 h-10 bg-gradient-to-br from-emerald-500 to-green-600 rounded-lg flex items-center justify-center mx-auto mb-2">
                                <i class="fas fa-coins text-white"></i>
                            </div>
                            <p class="text-lg font-bold text-gray-800">Rp <?php echo e(number_format($category->products->sum('harga'), 0, ',', '.')); ?></p>
                            <p class="text-xs text-gray-500">Total Nilai Harga</p>
                        </div>
                        <div class="bg-white/80 backdrop-blur-sm rounded-xl p-4 border border-white/50 shadow-sm hover:shadow-md transition-all text-center">
                            <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-cyan-600 rounded-lg flex items-center justify-center mx-auto mb-2">
                                <i class="fas fa-boxes text-white"></i>
                            </div>
                            <p class="text-lg font-bold text-gray-800"><?php echo e($category->products->sum('stok')); ?></p>
                            <p class="text-xs text-gray-500">Total Stok</p>
                        </div>
                        <div class="bg-white/80 backdrop-blur-sm rounded-xl p-4 border border-white/50 shadow-sm hover:shadow-md transition-all text-center">
                            <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-pink-600 rounded-lg flex items-center justify-center mx-auto mb-2">
                                <i class="fas fa-calculator text-white"></i>
                            </div>
                            <p class="text-lg font-bold text-gray-800">Rp <?php echo e(number_format($category->products->avg('harga'), 0, ',', '.')); ?></p>
                            <p class="text-xs text-gray-500">Rata-rata Harga</p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\kantin-modern\resources\views/admin/categories/show.blade.php ENDPATH**/ ?>