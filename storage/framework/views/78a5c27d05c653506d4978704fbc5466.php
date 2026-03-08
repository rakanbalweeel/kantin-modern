



<?php $__env->startSection('title', 'Edit Kategori'); ?>

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
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="mb-8">
            <a href="<?php echo e(route('admin.categories.index')); ?>" 
               class="group inline-flex items-center text-gray-500 hover:text-indigo-600 transition-all duration-300">
                <span class="flex items-center justify-center w-12 h-12 rounded-xl bg-white/80 backdrop-blur-sm shadow-lg border border-white/50 mr-3 group-hover:shadow-xl group-hover:border-indigo-200 group-hover:-translate-x-1 transition-all duration-300">
                    <i class="fas fa-arrow-left"></i>
                </span>
                <span class="font-semibold">Kembali ke Daftar Kategori</span>
            </a>
        </div>

        
        <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-white/50 overflow-hidden mb-8">
            <div class="bg-gradient-to-r <?php echo e($config['gradient']); ?> p-6 relative overflow-hidden">
                
                <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -mr-16 -mt-16"></div>
                <div class="absolute bottom-0 left-0 w-24 h-24 bg-white/10 rounded-full -ml-12 -mb-12"></div>
                
                <div class="relative flex items-center">
                    <div class="w-16 h-16 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center shadow-lg mr-4">
                        <i class="fas fa-edit text-white text-2xl"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-white">Edit Kategori</h1>
                        <p class="text-white/80 text-sm mt-1">Ubah informasi kategori "<?php echo e($category->nama); ?>"</p>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-white/50 overflow-hidden hover:shadow-xl transition-all duration-300">
            <form action="<?php echo e(route('admin.categories.update', $category)); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>

                <div class="p-8">
                    
                    <div class="mb-8 p-6 bg-gradient-to-br <?php echo e($config['bg']); ?> rounded-2xl border border-white/50">
                        <div class="flex items-center">
                            <div class="w-16 h-16 bg-gradient-to-br <?php echo e($config['gradient']); ?> rounded-2xl flex items-center justify-center shadow-lg mr-4">
                                <i class="fas <?php echo e($config['icon']); ?> text-white text-2xl"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 mb-1">Kategori saat ini</p>
                                <h3 class="text-xl font-bold text-gray-800"><?php echo e($category->nama); ?></h3>
                                <p class="text-sm text-gray-600 mt-1"><?php echo e($category->products->count()); ?> produk terdaftar</p>
                            </div>
                        </div>
                    </div>

                    
                    <div class="mb-6">
                        <label for="nama" class="flex items-center text-sm font-semibold text-gray-700 mb-3">
                            <span class="w-8 h-8 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-lg flex items-center justify-center mr-2">
                                <i class="fas fa-tag text-white text-xs"></i>
                            </span>
                            Nama Kategori <span class="text-red-500 ml-1">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="nama" 
                            id="nama"
                            value="<?php echo e(old('nama', $category->nama)); ?>"
                            class="w-full px-5 py-4 bg-gray-50 border-2 border-gray-200 rounded-xl focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 transition-all duration-200 text-gray-800 font-medium <?php $__errorArgs = ['nama'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-400 bg-red-50 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                            placeholder="Contoh: Makanan Berat, Minuman, Snack"
                            required
                            autofocus
                        >
                        <?php $__errorArgs = ['nama'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-2 text-sm text-red-500 flex items-center">
                                <i class="fas fa-exclamation-circle mr-2"></i>
                                <?php echo e($message); ?>

                            </p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    
                    <div class="mb-8">
                        <label for="deskripsi" class="flex items-center text-sm font-semibold text-gray-700 mb-3">
                            <span class="w-8 h-8 bg-gradient-to-br from-emerald-500 to-green-600 rounded-lg flex items-center justify-center mr-2">
                                <i class="fas fa-align-left text-white text-xs"></i>
                            </span>
                            Deskripsi
                            <span class="ml-2 text-xs text-gray-400 font-normal">(opsional)</span>
                        </label>
                        <textarea 
                            name="deskripsi" 
                            id="deskripsi"
                            rows="4"
                            class="w-full px-5 py-4 bg-gray-50 border-2 border-gray-200 rounded-xl focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 transition-all duration-200 text-gray-800 resize-none <?php $__errorArgs = ['deskripsi'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-400 bg-red-50 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                            placeholder="Deskripsi singkat tentang kategori ini"
                        ><?php echo e(old('deskripsi', $category->deskripsi)); ?></textarea>
                        <?php $__errorArgs = ['deskripsi'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-2 text-sm text-red-500 flex items-center">
                                <i class="fas fa-exclamation-circle mr-2"></i>
                                <?php echo e($message); ?>

                            </p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    
                    <div class="grid grid-cols-3 gap-4 mb-8">
                        <div class="bg-gradient-to-br from-indigo-50 to-purple-50 rounded-xl p-4 text-center border border-indigo-100">
                            <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-lg flex items-center justify-center mx-auto mb-2">
                                <i class="fas fa-calendar-plus text-white text-sm"></i>
                            </div>
                            <p class="text-xs text-gray-500 mb-1">Dibuat</p>
                            <p class="text-sm font-bold text-gray-800"><?php echo e($category->created_at->format('d M Y')); ?></p>
                        </div>
                        <div class="bg-gradient-to-br from-amber-50 to-orange-50 rounded-xl p-4 text-center border border-amber-100">
                            <div class="w-10 h-10 bg-gradient-to-br from-amber-500 to-orange-600 rounded-lg flex items-center justify-center mx-auto mb-2">
                                <i class="fas fa-clock text-white text-sm"></i>
                            </div>
                            <p class="text-xs text-gray-500 mb-1">Diubah</p>
                            <p class="text-sm font-bold text-gray-800"><?php echo e($category->updated_at->format('d M Y')); ?></p>
                        </div>
                        <div class="bg-gradient-to-br from-emerald-50 to-green-50 rounded-xl p-4 text-center border border-emerald-100">
                            <div class="w-10 h-10 bg-gradient-to-br from-emerald-500 to-green-600 rounded-lg flex items-center justify-center mx-auto mb-2">
                                <i class="fas fa-box text-white text-sm"></i>
                            </div>
                            <p class="text-xs text-gray-500 mb-1">Produk</p>
                            <p class="text-sm font-bold text-gray-800"><?php echo e($category->products->count()); ?> item</p>
                        </div>
                    </div>
                </div>

                
                <div class="px-8 py-5 bg-gray-50/80 border-t border-gray-100 flex items-center justify-between">
                    <a href="<?php echo e(route('admin.categories.show', $category)); ?>" 
                       class="text-sm text-indigo-600 hover:text-indigo-700 font-medium flex items-center group">
                        <i class="fas fa-eye mr-2 group-hover:scale-110 transition-transform"></i>
                        Lihat Detail Kategori
                    </a>
                    <div class="flex items-center space-x-3">
                        <a href="<?php echo e(route('admin.categories.index')); ?>" 
                           class="px-6 py-3 bg-white border-2 border-gray-200 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 hover:border-gray-300 transition-all duration-200">
                            Batal
                        </a>
                        <button type="submit" 
                                class="group px-8 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold rounded-xl hover:from-indigo-700 hover:to-purple-700 shadow-lg shadow-indigo-200 hover:shadow-xl hover:-translate-y-0.5 transition-all duration-300 flex items-center">
                            <i class="fas fa-save mr-2 group-hover:scale-110 transition-transform"></i>
                            Update Kategori
                        </button>
                    </div>
                </div>
            </form>
        </div>

        
        <div class="mt-8 bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-red-100 overflow-hidden">
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
                        <p class="font-semibold text-gray-800">Hapus Kategori</p>
                        <p class="text-sm text-gray-500">Menghapus kategori akan menghapus semua <?php echo e($category->products->count()); ?> produk di dalamnya</p>
                    </div>
                    <form action="<?php echo e(route('admin.categories.destroy', $category)); ?>" 
                          method="POST"
                          onsubmit="return confirm('PERINGATAN: Menghapus kategori akan menghapus <?php echo e($category->products->count()); ?> produk di dalamnya. Yakin ingin melanjutkan?')">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" 
                                class="px-6 py-3 bg-white border-2 border-red-200 text-red-600 font-semibold rounded-xl hover:bg-red-50 hover:border-red-300 transition-all duration-200 flex items-center">
                            <i class="fas fa-trash-alt mr-2"></i>
                            Hapus Kategori
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\kantin-modern\resources\views/admin/categories/edit.blade.php ENDPATH**/ ?>