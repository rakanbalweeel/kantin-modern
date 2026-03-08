



<?php $__env->startSection('title', 'Kelola Produk'); ?>

<?php $__env->startSection('content'); ?>
<?php
    $categoryStyles = [
        'Makanan Berat' => ['icon' => 'fa-drumstick-bite', 'gradient' => 'from-orange-500 to-red-500', 'bg' => 'bg-orange-100', 'text' => 'text-orange-700'],
        'Makanan Ringan' => ['icon' => 'fa-cookie-bite', 'gradient' => 'from-green-500 to-emerald-500', 'bg' => 'bg-green-100', 'text' => 'text-green-700'],
        'Minuman' => ['icon' => 'fa-glass-water', 'gradient' => 'from-blue-500 to-cyan-500', 'bg' => 'bg-blue-100', 'text' => 'text-blue-700'],
        'Snack' => ['icon' => 'fa-candy-cane', 'gradient' => 'from-pink-500 to-rose-500', 'bg' => 'bg-pink-100', 'text' => 'text-pink-700'],
    ];
    
    $totalProducts = $products->total();
    $lowStockCount = $products->filter(fn($p) => $p->stok <= 10 && $p->stok > 0)->count();
    $outOfStockCount = $products->filter(fn($p) => $p->stok <= 0)->count();
?>

<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="mb-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div class="flex items-center mb-4 md:mb-0">
                    <div class="w-14 h-14 bg-gradient-to-br from-indigo-600 to-purple-600 rounded-2xl flex items-center justify-center shadow-lg shadow-indigo-200 mr-4">
                        <i class="fas fa-utensils text-white text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold bg-gradient-to-r from-gray-800 to-gray-600 bg-clip-text text-transparent">Kelola Produk</h1>
                        <p class="text-gray-500 mt-1">Daftar semua menu makanan dan minuman</p>
                    </div>
                </div>
                <a href="<?php echo e(route('admin.products.create')); ?>" 
                   class="group inline-flex items-center px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold rounded-xl hover:from-indigo-700 hover:to-purple-700 shadow-lg shadow-indigo-200 hover:shadow-xl hover:-translate-y-0.5 transition-all duration-300">
                    <i class="fas fa-plus mr-2 group-hover:rotate-90 transition-transform duration-300"></i>
                    Tambah Produk
                </a>
            </div>
        </div>

        
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
            <div class="bg-white/80 backdrop-blur-sm rounded-2xl p-5 shadow-lg border border-white/50 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Total Produk</p>
                        <p class="text-2xl font-bold text-gray-800"><?php echo e($totalProducts); ?></p>
                    </div>
                    <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center">
                        <i class="fas fa-boxes-stacked text-white"></i>
                    </div>
                </div>
            </div>
            <div class="bg-white/80 backdrop-blur-sm rounded-2xl p-5 shadow-lg border border-white/50 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Stok Tersedia</p>
                        <p class="text-2xl font-bold text-emerald-600"><?php echo e($totalProducts - $lowStockCount - $outOfStockCount); ?></p>
                    </div>
                    <div class="w-12 h-12 bg-gradient-to-br from-emerald-500 to-green-600 rounded-xl flex items-center justify-center">
                        <i class="fas fa-check-circle text-white"></i>
                    </div>
                </div>
            </div>
            <div class="bg-white/80 backdrop-blur-sm rounded-2xl p-5 shadow-lg border border-white/50 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Stok Menipis</p>
                        <p class="text-2xl font-bold text-amber-600"><?php echo e($lowStockCount); ?></p>
                    </div>
                    <div class="w-12 h-12 bg-gradient-to-br from-amber-500 to-orange-600 rounded-xl flex items-center justify-center">
                        <i class="fas fa-exclamation-triangle text-white"></i>
                    </div>
                </div>
            </div>
            <div class="bg-white/80 backdrop-blur-sm rounded-2xl p-5 shadow-lg border border-white/50 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Stok Habis</p>
                        <p class="text-2xl font-bold text-red-600"><?php echo e($outOfStockCount); ?></p>
                    </div>
                    <div class="w-12 h-12 bg-gradient-to-br from-red-500 to-rose-600 rounded-xl flex items-center justify-center">
                        <i class="fas fa-times-circle text-white"></i>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-white/50 p-6 mb-6">
            <form action="<?php echo e(route('admin.products.index')); ?>" method="GET" class="flex flex-wrap gap-4 items-end">
                <div class="flex-1 min-w-[250px]">
                    <label class="text-sm font-medium text-gray-600 mb-2 block">Cari Produk</label>
                    <div class="relative">
                        <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <input type="text" name="search" value="<?php echo e(request('search')); ?>" 
                               placeholder="Nama atau kode produk..."
                               class="w-full pl-11 pr-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 transition-all duration-200">
                    </div>
                </div>
                <div class="w-56">
                    <label class="text-sm font-medium text-gray-600 mb-2 block">Kategori</label>
                    <select name="category" class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 transition-all duration-200 appearance-none cursor-pointer">
                        <option value="">Semua Kategori</option>
                        <?php $__currentLoopData = $categories ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($cat->id); ?>" <?php echo e(request('category') == $cat->id ? 'selected' : ''); ?>>
                                <?php echo e($cat->nama); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <button type="submit" class="px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold rounded-xl hover:from-indigo-700 hover:to-purple-700 shadow-md hover:shadow-lg transition-all duration-200 flex items-center">
                    <i class="fas fa-filter mr-2"></i>
                    Filter
                </button>
                <?php if(request()->hasAny(['search', 'category'])): ?>
                    <a href="<?php echo e(route('admin.products.index')); ?>" class="px-6 py-3 bg-gray-100 text-gray-600 font-medium rounded-xl hover:bg-gray-200 transition-all duration-200 flex items-center">
                        <i class="fas fa-times mr-2"></i>
                        Reset
                    </a>
                <?php endif; ?>
            </form>
        </div>

        
        <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-white/50 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="bg-gradient-to-r from-indigo-600 to-purple-600">
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                <i class="fas fa-box mr-2"></i>Produk
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                <i class="fas fa-tag mr-2"></i>Kategori
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                <i class="fas fa-money-bill mr-2"></i>Harga
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                <i class="fas fa-cubes mr-2"></i>Stok
                            </th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-white uppercase tracking-wider">
                                <i class="fas fa-cog mr-2"></i>Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <?php
                                $style = $categoryStyles[$product->category->nama] ?? ['icon' => 'fa-utensils', 'gradient' => 'from-gray-500 to-gray-600', 'bg' => 'bg-gray-100', 'text' => 'text-gray-700'];
                            ?>
                            <tr class="hover:bg-indigo-50/50 transition-colors duration-200">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <?php if($product->gambar): ?>
                                            <img src="<?php echo e(Storage::url($product->gambar)); ?>" 
                                                 alt="<?php echo e($product->nama); ?>"
                                                 class="w-14 h-14 rounded-xl object-cover shadow-md border-2 border-white">
                                        <?php else: ?>
                                            <div class="w-14 h-14 rounded-xl bg-gradient-to-br <?php echo e($style['gradient']); ?> flex items-center justify-center shadow-md">
                                                <i class="fas <?php echo e($style['icon']); ?> text-white text-lg"></i>
                                            </div>
                                        <?php endif; ?>
                                        <div class="ml-4">
                                            <p class="text-sm font-bold text-gray-800"><?php echo e($product->nama); ?></p>
                                            <p class="text-xs text-gray-500 font-mono bg-gray-100 px-2 py-0.5 rounded mt-1 inline-block"><?php echo e($product->kode); ?></p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold <?php echo e($style['bg']); ?> <?php echo e($style['text']); ?>">
                                        <i class="fas <?php echo e($style['icon']); ?> mr-1.5 text-xs"></i>
                                        <?php echo e($product->category->nama); ?>

                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-lg font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
                                        Rp <?php echo e(number_format($product->harga, 0, ',', '.')); ?>

                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <?php if($product->stok <= 0): ?>
                                        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold bg-red-100 text-red-700">
                                            <i class="fas fa-times-circle mr-1.5"></i>Habis
                                        </span>
                                    <?php elseif($product->stok <= 10): ?>
                                        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold bg-amber-100 text-amber-700">
                                            <i class="fas fa-exclamation-triangle mr-1.5"></i><?php echo e($product->stok); ?> tersisa
                                        </span>
                                    <?php else: ?>
                                        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700">
                                            <i class="fas fa-check-circle mr-1.5"></i><?php echo e($product->stok); ?> tersedia
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center justify-center space-x-1">
                                        
                                        <button type="button" 
                                                onclick="openStockModal(<?php echo e($product->id); ?>, '<?php echo e($product->nama); ?>', <?php echo e($product->stok); ?>)"
                                                class="w-9 h-9 bg-emerald-100 text-emerald-600 rounded-lg hover:bg-emerald-200 hover:scale-110 transition-all duration-200 flex items-center justify-center" 
                                                title="Update Stok">
                                            <i class="fas fa-boxes-stacked text-sm"></i>
                                        </button>
                                        
                                        
                                        <a href="<?php echo e(route('admin.products.show', $product)); ?>" 
                                           class="w-9 h-9 bg-gray-100 text-gray-600 rounded-lg hover:bg-gray-200 hover:scale-110 transition-all duration-200 flex items-center justify-center" 
                                           title="Lihat">
                                            <i class="fas fa-eye text-sm"></i>
                                        </a>
                                        
                                        
                                        <a href="<?php echo e(route('admin.products.edit', $product)); ?>" 
                                           class="w-9 h-9 bg-indigo-100 text-indigo-600 rounded-lg hover:bg-indigo-200 hover:scale-110 transition-all duration-200 flex items-center justify-center" 
                                           title="Edit">
                                            <i class="fas fa-edit text-sm"></i>
                                        </a>
                                        
                                        
                                        <form action="<?php echo e(route('admin.products.destroy', $product)); ?>" 
                                              method="POST" 
                                              class="inline"
                                              onsubmit="return confirm('Yakin ingin menghapus produk <?php echo e($product->nama); ?>?')">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" 
                                                    class="w-9 h-9 bg-red-100 text-red-600 rounded-lg hover:bg-red-200 hover:scale-110 transition-all duration-200 flex items-center justify-center" 
                                                    title="Hapus">
                                                <i class="fas fa-trash-alt text-sm"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="5" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center">
                                        <div class="w-20 h-20 bg-gradient-to-br from-gray-200 to-gray-300 rounded-full flex items-center justify-center mb-4">
                                            <i class="fas fa-utensils text-gray-400 text-3xl"></i>
                                        </div>
                                        <p class="text-lg font-semibold text-gray-600 mb-2">Belum Ada Produk</p>
                                        <p class="text-gray-400 mb-4">Mulai dengan menambahkan produk pertama</p>
                                        <a href="<?php echo e(route('admin.products.create')); ?>" 
                                           class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold rounded-xl hover:from-indigo-700 hover:to-purple-700 shadow-lg shadow-indigo-200 transition-all duration-300">
                                            <i class="fas fa-plus mr-2"></i>
                                            Tambah Produk
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            
            <?php if($products->hasPages()): ?>
                <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50">
                    <?php echo e($products->withQueryString()->links()); ?>

                </div>
            <?php endif; ?>
        </div>
    </div>
</div>


<div id="stockModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm hidden items-center justify-center z-50">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md mx-4 overflow-hidden transform transition-all">
        
        <div class="bg-gradient-to-r from-emerald-500 to-green-600 px-6 py-4">
            <div class="flex items-center">
                <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center mr-3">
                    <i class="fas fa-boxes-stacked text-white"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-white">Update Stok</h3>
                    <p id="stockProductName" class="text-emerald-100 text-sm"></p>
                </div>
            </div>
        </div>
        
        <form id="stockForm" method="POST" class="p-6">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PATCH'); ?>
            
            <div class="mb-5">
                <label class="flex items-center text-sm font-semibold text-gray-700 mb-2">
                    <span class="w-6 h-6 bg-gray-200 rounded-md flex items-center justify-center mr-2">
                        <i class="fas fa-box text-gray-500 text-xs"></i>
                    </span>
                    Stok Saat Ini
                </label>
                <input type="text" id="currentStock" 
                       class="w-full px-4 py-3 bg-gray-100 border-2 border-gray-200 rounded-xl text-gray-600 font-semibold" 
                       readonly>
            </div>
            
            <div class="mb-6">
                <label for="newStock" class="flex items-center text-sm font-semibold text-gray-700 mb-2">
                    <span class="w-6 h-6 bg-emerald-100 rounded-md flex items-center justify-center mr-2">
                        <i class="fas fa-edit text-emerald-600 text-xs"></i>
                    </span>
                    Stok Baru
                </label>
                <input type="number" name="stok" id="newStock" min="0" required
                       class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:ring-4 focus:ring-emerald-100 focus:border-emerald-500 transition-all duration-200 font-semibold text-gray-800">
            </div>
            
            <div class="flex space-x-3">
                <button type="button" onclick="closeStockModal()" 
                        class="flex-1 px-6 py-3 bg-gray-100 text-gray-700 font-semibold rounded-xl hover:bg-gray-200 transition-all duration-200">
                    Batal
                </button>
                <button type="submit" 
                        class="flex-1 px-6 py-3 bg-gradient-to-r from-emerald-500 to-green-600 text-white font-semibold rounded-xl hover:from-emerald-600 hover:to-green-700 shadow-lg shadow-emerald-200 transition-all duration-200 flex items-center justify-center">
                    <i class="fas fa-save mr-2"></i>
                    Update Stok
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openStockModal(productId, productName, currentStock) {
    document.getElementById('stockModal').classList.remove('hidden');
    document.getElementById('stockModal').classList.add('flex');
    document.getElementById('stockProductName').textContent = productName;
    document.getElementById('currentStock').value = currentStock;
    document.getElementById('newStock').value = currentStock;
    document.getElementById('stockForm').action = `/admin/products/${productId}/stock`;
}

function closeStockModal() {
    document.getElementById('stockModal').classList.add('hidden');
    document.getElementById('stockModal').classList.remove('flex');
}

// Close modal on background click
document.getElementById('stockModal').addEventListener('click', function(e) {
    if (e.target === this) closeStockModal();
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\kantin-modern\resources\views/admin/products/index.blade.php ENDPATH**/ ?>