



<?php $__env->startSection('title', 'Kelola Kategori'); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
            <div class="mb-4 sm:mb-0">
                <h1 class="text-3xl font-extrabold bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-500 bg-clip-text text-transparent">
                    Kelola Kategori
                </h1>
                <p class="mt-2 text-gray-500">Kelompokkan produk berdasarkan kategori</p>
            </div>
            <a href="<?php echo e(route('admin.categories.create')); ?>" 
               class="group inline-flex items-center px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold rounded-xl hover:from-indigo-700 hover:to-purple-700 shadow-lg shadow-indigo-200 hover:shadow-xl hover:-translate-y-0.5 transition-all duration-300">
                <span class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center mr-3 group-hover:scale-110 transition-transform">
                    <i class="fas fa-plus text-sm"></i>
                </span>
                Tambah Kategori
            </a>
        </div>

        
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
            <div class="bg-white/80 backdrop-blur-sm rounded-xl p-4 border border-white/50 shadow-sm hover:shadow-md transition-all">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-folder text-white"></i>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-gray-800"><?php echo e($categories->total()); ?></p>
                        <p class="text-xs text-gray-500">Total Kategori</p>
                    </div>
                </div>
            </div>
            <div class="bg-white/80 backdrop-blur-sm rounded-xl p-4 border border-white/50 shadow-sm hover:shadow-md transition-all">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-gradient-to-br from-emerald-500 to-green-600 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-utensils text-white"></i>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-gray-800"><?php echo e($categories->sum(fn($c) => $c->products_count ?? $c->products->count())); ?></p>
                        <p class="text-xs text-gray-500">Total Produk</p>
                    </div>
                </div>
            </div>
            <div class="bg-white/80 backdrop-blur-sm rounded-xl p-4 border border-white/50 shadow-sm hover:shadow-md transition-all">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-gradient-to-br from-amber-500 to-orange-600 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-star text-white"></i>
                    </div>
                    <div>
                        <?php
                            $topCategory = $categories->sortByDesc(fn($c) => $c->products_count ?? $c->products->count())->first();
                        ?>
                        <p class="text-sm font-bold text-gray-800 truncate"><?php echo e($topCategory?->nama ?? '-'); ?></p>
                        <p class="text-xs text-gray-500">Terpopuler</p>
                    </div>
                </div>
            </div>
            <div class="bg-white/80 backdrop-blur-sm rounded-xl p-4 border border-white/50 shadow-sm hover:shadow-md transition-all">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-cyan-600 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-chart-pie text-white"></i>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-gray-800"><?php echo e($categories->count() > 0 ? round($categories->sum(fn($c) => $c->products_count ?? $c->products->count()) / $categories->count(), 1) : 0); ?></p>
                        <p class="text-xs text-gray-500">Rata-rata/Kategori</p>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-white/50 overflow-hidden hover:shadow-xl transition-all duration-300">
            
            <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center mr-3">
                            <i class="fas fa-layer-group text-white"></i>
                        </div>
                        <div>
                            <h2 class="text-lg font-bold text-white">Daftar Kategori</h2>
                            <p class="text-sm text-white/70"><?php echo e($categories->total()); ?> kategori tersedia</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="bg-gray-50/80">
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                No
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                Kategori
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                Deskripsi
                            </th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">
                                Jumlah Produk
                            </th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <?php $__empty_1 = true; $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <?php
                                $icons = [
                                    'Makanan Berat' => ['icon' => 'fa-drumstick-bite', 'gradient' => 'from-orange-500 to-red-500', 'bg' => 'bg-orange-100'],
                                    'Makanan Ringan' => ['icon' => 'fa-cookie-bite', 'gradient' => 'from-green-500 to-emerald-500', 'bg' => 'bg-green-100'],
                                    'Minuman' => ['icon' => 'fa-glass-water', 'gradient' => 'from-blue-500 to-cyan-500', 'bg' => 'bg-blue-100'],
                                    'Snack' => ['icon' => 'fa-candy-cane', 'gradient' => 'from-pink-500 to-rose-500', 'bg' => 'bg-pink-100'],
                                ];
                                $config = $icons[$category->nama] ?? ['icon' => 'fa-utensils', 'gradient' => 'from-indigo-500 to-purple-500', 'bg' => 'bg-indigo-100'];
                            ?>
                            <tr class="group hover:bg-indigo-50/50 transition-colors duration-200">
                                <td class="px-6 py-5 whitespace-nowrap">
                                    <span class="w-8 h-8 inline-flex items-center justify-center bg-gray-100 rounded-lg text-sm font-bold text-gray-600 group-hover:bg-indigo-100 group-hover:text-indigo-600 transition-colors">
                                        <?php echo e($categories->firstItem() + $index); ?>

                                    </span>
                                </td>
                                <td class="px-6 py-5 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-12 h-12 bg-gradient-to-br <?php echo e($config['gradient']); ?> rounded-xl flex items-center justify-center mr-4 shadow-lg group-hover:scale-110 group-hover:rotate-3 transition-all duration-300">
                                            <i class="fas <?php echo e($config['icon']); ?> text-white text-lg"></i>
                                        </div>
                                        <div>
                                            <p class="font-bold text-gray-800 group-hover:text-indigo-600 transition-colors"><?php echo e($category->nama); ?></p>
                                            <p class="text-xs text-gray-400">ID: <?php echo e($category->id); ?></p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <p class="text-sm text-gray-600 max-w-xs">
                                        <?php echo e(Str::limit($category->deskripsi, 60) ?: '-'); ?>

                                    </p>
                                </td>
                                <td class="px-6 py-5 whitespace-nowrap text-center">
                                    <?php
                                        $productCount = $category->products_count ?? $category->products->count();
                                    ?>
                                    <span class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-bold <?php echo e($productCount > 0 ? 'bg-gradient-to-r from-indigo-500 to-purple-500 text-white shadow-lg shadow-indigo-200' : 'bg-gray-100 text-gray-500'); ?>">
                                        <i class="fas fa-box mr-2"></i>
                                        <?php echo e($productCount); ?> produk
                                    </span>
                                </td>
                                <td class="px-6 py-5 whitespace-nowrap">
                                    <div class="flex items-center justify-center space-x-2">
                                        
                                        <a href="<?php echo e(route('admin.categories.show', $category)); ?>" 
                                           class="w-10 h-10 inline-flex items-center justify-center bg-gray-100 hover:bg-blue-500 text-gray-600 hover:text-white rounded-xl transition-all duration-200 hover:scale-110 hover:shadow-lg" 
                                           title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        
                                        
                                        <a href="<?php echo e(route('admin.categories.edit', $category)); ?>" 
                                           class="w-10 h-10 inline-flex items-center justify-center bg-gray-100 hover:bg-amber-500 text-gray-600 hover:text-white rounded-xl transition-all duration-200 hover:scale-110 hover:shadow-lg" 
                                           title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        
                                        
                                        <form action="<?php echo e(route('admin.categories.destroy', $category)); ?>" 
                                              method="POST" 
                                              class="inline"
                                              onsubmit="return confirm('Yakin ingin menghapus kategori <?php echo e($category->nama); ?>? Semua produk dalam kategori ini juga akan terhapus!')">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" 
                                                    class="w-10 h-10 inline-flex items-center justify-center bg-gray-100 hover:bg-red-500 text-gray-600 hover:text-white rounded-xl transition-all duration-200 hover:scale-110 hover:shadow-lg" 
                                                    title="Hapus">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="5" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center">
                                        <div class="w-24 h-24 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full flex items-center justify-center mb-4">
                                            <i class="fas fa-folder-open text-4xl text-gray-300"></i>
                                        </div>
                                        <h3 class="text-xl font-bold text-gray-700 mb-2">Belum ada kategori</h3>
                                        <p class="text-gray-500 mb-4">Mulai dengan menambahkan kategori pertama</p>
                                        <a href="<?php echo e(route('admin.categories.create')); ?>" 
                                           class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold rounded-xl hover:from-indigo-700 hover:to-purple-700 shadow-lg shadow-indigo-200 hover:shadow-xl transition-all duration-300">
                                            <i class="fas fa-plus mr-2"></i>
                                            Tambah Kategori Pertama
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            
            <?php if($categories->hasPages()): ?>
                <div class="px-6 py-4 bg-gray-50/50 border-t border-gray-100">
                    <div class="flex items-center justify-between">
                        <p class="text-sm text-gray-600">
                            Menampilkan <span class="font-semibold"><?php echo e($categories->firstItem()); ?></span> - <span class="font-semibold"><?php echo e($categories->lastItem()); ?></span> dari <span class="font-semibold"><?php echo e($categories->total()); ?></span> kategori
                        </p>
                        <div class="flex space-x-2">
                            <?php echo e($categories->links()); ?>

                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\kantin-modern\resources\views/admin/categories/index.blade.php ENDPATH**/ ?>