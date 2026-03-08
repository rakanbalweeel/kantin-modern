



<?php $__env->startSection('title', 'Edit Produk'); ?>

<?php $__env->startSection('content'); ?>
<?php
    $categoryStyles = [
        'Makanan Berat' => ['icon' => 'fa-drumstick-bite', 'gradient' => 'from-orange-500 to-red-500', 'bg' => 'from-orange-100 to-red-100'],
        'Makanan Ringan' => ['icon' => 'fa-cookie-bite', 'gradient' => 'from-green-500 to-emerald-500', 'bg' => 'from-green-100 to-emerald-100'],
        'Minuman' => ['icon' => 'fa-glass-water', 'gradient' => 'from-blue-500 to-cyan-500', 'bg' => 'from-blue-100 to-cyan-100'],
        'Snack' => ['icon' => 'fa-candy-cane', 'gradient' => 'from-pink-500 to-rose-500', 'bg' => 'from-pink-100 to-rose-100'],
    ];
    $style = $categoryStyles[$product->category->nama] ?? ['icon' => 'fa-utensils', 'gradient' => 'from-indigo-500 to-purple-500', 'bg' => 'from-indigo-100 to-purple-100'];
?>

<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
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
                
                <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -mr-16 -mt-16"></div>
                <div class="absolute bottom-0 left-0 w-24 h-24 bg-white/10 rounded-full -ml-12 -mb-12"></div>
                
                <div class="relative flex items-center">
                    <div class="w-16 h-16 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center shadow-lg mr-4">
                        <i class="fas fa-edit text-white text-2xl"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-white">Edit Produk</h1>
                        <p class="text-white/80 text-sm mt-1">Ubah informasi produk "<?php echo e($product->nama); ?>"</p>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-white/50 overflow-hidden hover:shadow-xl transition-all duration-300">
            <form action="<?php echo e(route('admin.products.update', $product)); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>

                <div class="p-8">
                    
                    <div class="mb-8 p-6 bg-gradient-to-br <?php echo e($style['bg']); ?> rounded-2xl border border-white/50">
                        <div class="flex items-center">
                            <?php if($product->gambar): ?>
                                <img src="<?php echo e(Storage::url($product->gambar)); ?>" 
                                     alt="<?php echo e($product->nama); ?>"
                                     class="w-16 h-16 rounded-xl object-cover shadow-lg border-2 border-white mr-4">
                            <?php else: ?>
                                <div class="w-16 h-16 bg-gradient-to-br <?php echo e($style['gradient']); ?> rounded-2xl flex items-center justify-center shadow-lg mr-4">
                                    <i class="fas <?php echo e($style['icon']); ?> text-white text-2xl"></i>
                                </div>
                            <?php endif; ?>
                            <div>
                                <p class="text-sm text-gray-500 mb-1">Produk saat ini</p>
                                <h3 class="text-xl font-bold text-gray-800"><?php echo e($product->nama); ?></h3>
                                <p class="text-sm text-gray-600 mt-1 font-mono"><?php echo e($product->kode); ?> • Rp <?php echo e(number_format($product->harga, 0, ',', '.')); ?></p>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        
                        <div>
                            <label for="kode" class="flex items-center text-sm font-semibold text-gray-700 mb-3">
                                <span class="w-8 h-8 bg-gradient-to-br from-gray-600 to-gray-700 rounded-lg flex items-center justify-center mr-2">
                                    <i class="fas fa-barcode text-white text-xs"></i>
                                </span>
                                Kode Produk <span class="text-red-500 ml-1">*</span>
                            </label>
                            <input 
                                type="text" 
                                name="kode" 
                                id="kode"
                                value="<?php echo e(old('kode', $product->kode)); ?>"
                                class="w-full px-5 py-4 bg-gray-50 border-2 border-gray-200 rounded-xl focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 transition-all duration-200 text-gray-800 font-mono <?php $__errorArgs = ['kode'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-400 bg-red-50 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                required
                            >
                            <?php $__errorArgs = ['kode'];
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

                        
                        <div>
                            <label for="nama" class="flex items-center text-sm font-semibold text-gray-700 mb-3">
                                <span class="w-8 h-8 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-lg flex items-center justify-center mr-2">
                                    <i class="fas fa-tag text-white text-xs"></i>
                                </span>
                                Nama Produk <span class="text-red-500 ml-1">*</span>
                            </label>
                            <input 
                                type="text" 
                                name="nama" 
                                id="nama"
                                value="<?php echo e(old('nama', $product->nama)); ?>"
                                class="w-full px-5 py-4 bg-gray-50 border-2 border-gray-200 rounded-xl focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 transition-all duration-200 text-gray-800 font-medium <?php $__errorArgs = ['nama'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-400 bg-red-50 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                required
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
                    </div>

                    
                    <div class="mt-6">
                        <label for="category_id" class="flex items-center text-sm font-semibold text-gray-700 mb-3">
                            <span class="w-8 h-8 bg-gradient-to-br from-amber-500 to-orange-600 rounded-lg flex items-center justify-center mr-2">
                                <i class="fas fa-folder text-white text-xs"></i>
                            </span>
                            Kategori <span class="text-red-500 ml-1">*</span>
                        </label>
                        <select 
                            name="category_id" 
                            id="category_id"
                            class="w-full px-5 py-4 bg-gray-50 border-2 border-gray-200 rounded-xl focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 transition-all duration-200 text-gray-800 cursor-pointer <?php $__errorArgs = ['category_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-400 bg-red-50 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                            required
                        >
                            <option value="">-- Pilih Kategori --</option>
                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($category->id); ?>" <?php echo e(old('category_id', $product->category_id) == $category->id ? 'selected' : ''); ?>>
                                    <?php echo e($category->nama); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php $__errorArgs = ['category_id'];
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

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">
                        
                        <div>
                            <label for="harga" class="flex items-center text-sm font-semibold text-gray-700 mb-3">
                                <span class="w-8 h-8 bg-gradient-to-br from-emerald-500 to-green-600 rounded-lg flex items-center justify-center mr-2">
                                    <i class="fas fa-money-bill text-white text-xs"></i>
                                </span>
                                Harga (Rp) <span class="text-red-500 ml-1">*</span>
                            </label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 font-semibold">Rp</span>
                                <input 
                                    type="number" 
                                    name="harga" 
                                    id="harga"
                                    value="<?php echo e(old('harga', $product->harga)); ?>"
                                    min="0"
                                    class="w-full pl-14 pr-5 py-4 bg-gray-50 border-2 border-gray-200 rounded-xl focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 transition-all duration-200 text-gray-800 font-bold <?php $__errorArgs = ['harga'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-400 bg-red-50 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    required
                                >
                            </div>
                            <?php $__errorArgs = ['harga'];
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

                        
                        <div>
                            <label for="stok" class="flex items-center text-sm font-semibold text-gray-700 mb-3">
                                <span class="w-8 h-8 bg-gradient-to-br from-blue-500 to-cyan-600 rounded-lg flex items-center justify-center mr-2">
                                    <i class="fas fa-boxes-stacked text-white text-xs"></i>
                                </span>
                                Stok <span class="text-red-500 ml-1">*</span>
                            </label>
                            <input 
                                type="number" 
                                name="stok" 
                                id="stok"
                                value="<?php echo e(old('stok', $product->stok)); ?>"
                                min="0"
                                class="w-full px-5 py-4 bg-gray-50 border-2 border-gray-200 rounded-xl focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 transition-all duration-200 text-gray-800 font-bold <?php $__errorArgs = ['stok'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-400 bg-red-50 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                required
                            >
                            <?php $__errorArgs = ['stok'];
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
                    </div>

                    
                    <div class="mt-6">
                        <label for="deskripsi" class="flex items-center text-sm font-semibold text-gray-700 mb-3">
                            <span class="w-8 h-8 bg-gradient-to-br from-pink-500 to-rose-600 rounded-lg flex items-center justify-center mr-2">
                                <i class="fas fa-align-left text-white text-xs"></i>
                            </span>
                            Deskripsi
                            <span class="ml-2 text-xs text-gray-400 font-normal">(opsional)</span>
                        </label>
                        <textarea 
                            name="deskripsi" 
                            id="deskripsi"
                            rows="3"
                            class="w-full px-5 py-4 bg-gray-50 border-2 border-gray-200 rounded-xl focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 transition-all duration-200 text-gray-800 resize-none <?php $__errorArgs = ['deskripsi'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-400 bg-red-50 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                            placeholder="Deskripsi singkat tentang produk ini"
                        ><?php echo e(old('deskripsi', $product->deskripsi)); ?></textarea>
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

                    
                    <div class="mt-6" x-data="imageUpload('<?php echo e($product->gambar ? Storage::url($product->gambar) : ''); ?>')">
                        <label class="flex items-center text-sm font-semibold text-gray-700 mb-3">
                            <span class="w-8 h-8 bg-gradient-to-br from-violet-500 to-purple-600 rounded-lg flex items-center justify-center mr-2">
                                <i class="fas fa-image text-white text-xs"></i>
                            </span>
                            Gambar Produk
                            <span class="ml-2 text-xs text-gray-400 font-normal">(opsional)</span>
                        </label>
                        
                        
                        <div x-show="imagePreview" class="mb-4">
                            <div class="relative inline-block">
                                <img :src="imagePreview" class="w-40 h-40 object-cover rounded-2xl shadow-lg border-4 border-white">
                                <button type="button" 
                                        @click="removeImage()" 
                                        class="absolute -top-2 -right-2 w-8 h-8 bg-gradient-to-br from-red-500 to-rose-600 text-white rounded-full shadow-lg flex items-center justify-center transition-all duration-200 hover:scale-110 hover:shadow-xl">
                                    <i class="fas fa-times text-sm"></i>
                                </button>
                            </div>
                            <p class="mt-2 text-sm text-gray-500" x-text="fileName || 'Gambar saat ini'"></p>
                        </div>

                        
                        <div x-show="!imagePreview"
                             class="relative mt-1 flex justify-center px-8 pt-10 pb-10 border-2 border-gray-200 border-dashed rounded-2xl hover:border-indigo-400 bg-gray-50 hover:bg-indigo-50/50 transition-all duration-300 cursor-pointer group"
                             :class="{ 'border-indigo-500 bg-indigo-50': isDragging }"
                             @dragover.prevent="isDragging = true"
                             @dragleave.prevent="isDragging = false"
                             @drop.prevent="handleDrop($event)"
                             @click="$refs.fileInput.click()">
                            <div class="space-y-4 text-center">
                                <div class="w-20 h-20 mx-auto bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl flex items-center justify-center shadow-lg shadow-indigo-200 group-hover:scale-110 transition-transform duration-300">
                                    <i class="fas fa-cloud-upload-alt text-white text-3xl"></i>
                                </div>
                                <div class="text-gray-600">
                                    <span class="font-semibold text-indigo-600">Klik untuk upload</span>
                                    <span> atau drag & drop gambar</span>
                                </div>
                                <p class="text-xs text-gray-400">PNG, JPG, WEBP • Maksimal 2MB</p>
                            </div>
                            <input x-ref="fileInput" 
                                   id="gambar" 
                                   name="gambar" 
                                   type="file" 
                                   class="hidden" 
                                   accept="image/jpeg,image/png,image/webp"
                                   @change="handleFileSelect($event)">
                        </div>
                        <?php $__errorArgs = ['gambar'];
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

                    
                    <div class="grid grid-cols-2 gap-4 mt-8">
                        <div class="bg-gradient-to-br from-indigo-50 to-purple-50 rounded-xl p-4 text-center border border-indigo-100">
                            <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-lg flex items-center justify-center mx-auto mb-2">
                                <i class="fas fa-calendar-plus text-white text-sm"></i>
                            </div>
                            <p class="text-xs text-gray-500 mb-1">Dibuat</p>
                            <p class="text-sm font-bold text-gray-800"><?php echo e($product->created_at->format('d M Y H:i')); ?></p>
                        </div>
                        <div class="bg-gradient-to-br from-amber-50 to-orange-50 rounded-xl p-4 text-center border border-amber-100">
                            <div class="w-10 h-10 bg-gradient-to-br from-amber-500 to-orange-600 rounded-lg flex items-center justify-center mx-auto mb-2">
                                <i class="fas fa-clock text-white text-sm"></i>
                            </div>
                            <p class="text-xs text-gray-500 mb-1">Terakhir diubah</p>
                            <p class="text-sm font-bold text-gray-800"><?php echo e($product->updated_at->format('d M Y H:i')); ?></p>
                        </div>
                    </div>
                </div>

                
                <div class="px-8 py-5 bg-gray-50/80 border-t border-gray-100 flex items-center justify-between">
                    <a href="<?php echo e(route('admin.products.show', $product)); ?>" 
                       class="text-sm text-indigo-600 hover:text-indigo-700 font-medium flex items-center group">
                        <i class="fas fa-eye mr-2 group-hover:scale-110 transition-transform"></i>
                        Lihat Detail Produk
                    </a>
                    <div class="flex items-center space-x-3">
                        <a href="<?php echo e(route('admin.products.index')); ?>" 
                           class="px-6 py-3 bg-white border-2 border-gray-200 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 hover:border-gray-300 transition-all duration-200">
                            Batal
                        </a>
                        <button type="submit" 
                                class="group px-8 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold rounded-xl hover:from-indigo-700 hover:to-purple-700 shadow-lg shadow-indigo-200 hover:shadow-xl hover:-translate-y-0.5 transition-all duration-300 flex items-center">
                            <i class="fas fa-save mr-2 group-hover:scale-110 transition-transform"></i>
                            Update Produk
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
                        <p class="font-semibold text-gray-800">Hapus Produk</p>
                        <p class="text-sm text-gray-500">Produk akan dihapus secara permanen dari sistem</p>
                    </div>
                    <form action="<?php echo e(route('admin.products.destroy', $product)); ?>" 
                          method="POST"
                          onsubmit="return confirm('PERINGATAN: Menghapus produk <?php echo e($product->nama); ?> akan menghapusnya secara permanen. Yakin ingin melanjutkan?')">
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

<?php $__env->startPush('scripts'); ?>
<script>
function imageUpload(existingImage = null) {
    return {
        imagePreview: existingImage || null,
        fileName: '',
        isDragging: false,
        isExisting: !!existingImage,
        
        handleFileSelect(event) {
            const file = event.target.files[0];
            if (file) this.previewFile(file);
        },
        
        handleDrop(event) {
            this.isDragging = false;
            const file = event.dataTransfer.files[0];
            if (file && file.type.startsWith('image/')) {
                this.$refs.fileInput.files = event.dataTransfer.files;
                this.previewFile(file);
            }
        },
        
        previewFile(file) {
            if (file.size > 2 * 1024 * 1024) {
                alert('Ukuran file maksimal 2MB!');
                return;
            }
            this.fileName = file.name;
            this.isExisting = false;
            const reader = new FileReader();
            reader.onload = (e) => { this.imagePreview = e.target.result; };
            reader.readAsDataURL(file);
        },
        
        removeImage() {
            this.imagePreview = null;
            this.fileName = '';
            this.isExisting = false;
            this.$refs.fileInput.value = '';
        }
    }
}
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\kantin-modern\resources\views/admin/products/edit.blade.php ENDPATH**/ ?>