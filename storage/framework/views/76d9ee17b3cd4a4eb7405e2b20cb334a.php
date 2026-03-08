



<?php $__env->startSection('title', 'Detail Pesanan'); ?>

<?php
    // Status configuration
    $statusConfig = [
        'pending' => [
            'gradient' => 'from-amber-500 to-yellow-500',
            'bg' => 'bg-amber-50',
            'text' => 'text-amber-700',
            'border' => 'border-amber-200',
            'icon' => 'fa-clock',
            'label' => 'Menunggu'
        ],
        'diproses' => [
            'gradient' => 'from-blue-500 to-indigo-500',
            'bg' => 'bg-blue-50',
            'text' => 'text-blue-700',
            'border' => 'border-blue-200',
            'icon' => 'fa-spinner fa-spin',
            'label' => 'Diproses'
        ],
        'selesai' => [
            'gradient' => 'from-emerald-500 to-green-500',
            'bg' => 'bg-emerald-50',
            'text' => 'text-emerald-700',
            'border' => 'border-emerald-200',
            'icon' => 'fa-check-circle',
            'label' => 'Selesai'
        ],
        'batal' => [
            'gradient' => 'from-red-500 to-rose-500',
            'bg' => 'bg-red-50',
            'text' => 'text-red-700',
            'border' => 'border-red-200',
            'icon' => 'fa-times-circle',
            'label' => 'Dibatalkan'
        ],
    ];
    $currentStatus = $statusConfig[$order->status] ?? $statusConfig['pending'];
?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 py-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        
        
        <div class="mb-6">
            <a href="<?php echo e(route('admin.orders.index')); ?>" 
               class="group inline-flex items-center text-gray-500 hover:text-indigo-600 transition-all duration-300">
                <span class="flex items-center justify-center w-10 h-10 rounded-xl bg-white/80 backdrop-blur-sm shadow-lg border border-white/50 mr-3 group-hover:shadow-xl group-hover:border-indigo-200 group-hover:-translate-x-1 transition-all duration-300">
                    <i class="fas fa-arrow-left"></i>
                </span>
                <span class="font-medium">Kembali ke Daftar Pesanan</span>
            </a>
        </div>

        
        <div class="bg-gradient-to-r <?php echo e($currentStatus['gradient']); ?> rounded-2xl shadow-xl p-6 mb-6 relative overflow-hidden">
            
            <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full -mr-32 -mt-32"></div>
            <div class="absolute bottom-0 left-0 w-48 h-48 bg-white/10 rounded-full -ml-24 -mb-24"></div>
            
            <div class="relative flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center">
                        <i class="fas fa-receipt text-3xl text-white"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl md:text-3xl font-bold text-white"><?php echo e($order->kode_pesanan); ?></h1>
                        <div class="flex items-center gap-2 mt-1">
                            <i class="fas fa-calendar-alt text-white/70 text-sm"></i>
                            <span class="text-white/90 text-sm"><?php echo e($order->created_at->format('d F Y, H:i')); ?> WIB</span>
                        </div>
                    </div>
                </div>
                
                <div class="flex items-center gap-3">
                    <div class="bg-white/20 backdrop-blur-sm px-5 py-3 rounded-xl">
                        <div class="flex items-center gap-2">
                            <i class="fas <?php echo e($currentStatus['icon']); ?> text-white"></i>
                            <span class="text-white font-bold text-lg"><?php echo e($currentStatus['label']); ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
            
            <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-white/50 p-4 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-purple-500 rounded-xl flex items-center justify-center shadow-lg shadow-indigo-200">
                        <i class="fas fa-boxes text-white text-lg"></i>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-gray-900"><?php echo e($order->orderDetails->sum('jumlah')); ?></p>
                        <p class="text-xs text-gray-500">Total Item</p>
                    </div>
                </div>
            </div>

            
            <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-white/50 p-4 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-gradient-to-br from-cyan-500 to-blue-500 rounded-xl flex items-center justify-center shadow-lg shadow-cyan-200">
                        <i class="fas fa-utensils text-white text-lg"></i>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-gray-900"><?php echo e($order->orderDetails->count()); ?></p>
                        <p class="text-xs text-gray-500">Jenis Produk</p>
                    </div>
                </div>
            </div>

            
            <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-white/50 p-4 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-gradient-to-br from-emerald-500 to-green-500 rounded-xl flex items-center justify-center shadow-lg shadow-emerald-200">
                        <i class="fas fa-money-bill-wave text-white text-lg"></i>
                    </div>
                    <div>
                        <p class="text-xl font-bold text-gray-900">Rp <?php echo e(number_format($order->total, 0, ',', '.')); ?></p>
                        <p class="text-xs text-gray-500">Total Bayar</p>
                    </div>
                </div>
            </div>

            
            <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-white/50 p-4 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-gradient-to-br from-amber-500 to-orange-500 rounded-xl flex items-center justify-center shadow-lg shadow-amber-200">
                        <i class="fas fa-history text-white text-lg"></i>
                    </div>
                    <div>
                        <p class="text-xl font-bold text-gray-900"><?php echo e($order->created_at->diffForHumans(null, true)); ?></p>
                        <p class="text-xs text-gray-500">Yang Lalu</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <div class="lg:col-span-2 space-y-6">
                
                <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-white/50 overflow-hidden">
                    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 p-5">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                                <i class="fas fa-shopping-basket text-white"></i>
                            </div>
                            <div>
                                <h2 class="text-lg font-bold text-white">Detail Pesanan</h2>
                                <p class="text-white/70 text-sm"><?php echo e($order->orderDetails->count()); ?> produk dipesan</p>
                            </div>
                        </div>
                    </div>
                    <div class="divide-y divide-gray-100">
                        <?php $__currentLoopData = $order->orderDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="p-5 flex items-center gap-4 hover:bg-indigo-50/50 transition-all duration-300 group">
                                
                                <div class="w-8 h-8 bg-gradient-to-br from-indigo-100 to-purple-100 rounded-lg flex items-center justify-center text-indigo-600 font-bold text-sm group-hover:from-indigo-500 group-hover:to-purple-500 group-hover:text-white transition-all duration-300">
                                    <?php echo e($index + 1); ?>

                                </div>
                                
                                
                                <?php if($detail->product->gambar): ?>
                                    <img src="<?php echo e(Storage::url($detail->product->gambar)); ?>" 
                                         alt="<?php echo e($detail->product->nama); ?>"
                                         class="w-16 h-16 rounded-xl object-cover shadow-md group-hover:shadow-lg group-hover:scale-105 transition-all duration-300">
                                <?php else: ?>
                                    <div class="w-16 h-16 rounded-xl bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center shadow-md">
                                        <i class="fas fa-utensils text-gray-400 text-xl"></i>
                                    </div>
                                <?php endif; ?>
                                
                                
                                <div class="flex-1 min-w-0">
                                    <h3 class="font-semibold text-gray-900 group-hover:text-indigo-600 transition-colors"><?php echo e($detail->product->nama); ?></h3>
                                    <div class="flex items-center gap-2 mt-1">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-md bg-gray-100 text-gray-600 text-xs">
                                            <i class="fas fa-barcode mr-1"></i>
                                            <?php echo e($detail->product->kode); ?>

                                        </span>
                                        <span class="text-gray-400 text-sm">•</span>
                                        <span class="text-gray-500 text-sm"><?php echo e($detail->product->category->nama ?? 'Uncategorized'); ?></span>
                                    </div>
                                </div>
                                
                                
                                <div class="text-right">
                                    <div class="flex items-center justify-end gap-2 text-sm text-gray-500 mb-1">
                                        <span class="bg-indigo-100 text-indigo-600 px-2 py-0.5 rounded-md font-medium"><?php echo e($detail->jumlah); ?>x</span>
                                        <span>@ Rp <?php echo e(number_format($detail->harga, 0, ',', '.')); ?></span>
                                    </div>
                                    <p class="font-bold text-gray-900 text-lg">
                                        Rp <?php echo e(number_format($detail->subtotal, 0, ',', '.')); ?>

                                    </p>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    
                    
                    <div class="bg-gradient-to-r from-indigo-50 to-purple-50 p-5 border-t border-indigo-100">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <i class="fas fa-calculator text-indigo-500"></i>
                                <span class="text-gray-600 font-medium">Total Pembayaran</span>
                            </div>
                            <div class="text-right">
                                <p class="text-3xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
                                    Rp <?php echo e(number_format($order->total, 0, ',', '.')); ?>

                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                
                <?php if($order->catatan): ?>
                    <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-white/50 p-6">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-gradient-to-br from-amber-100 to-yellow-100 rounded-xl flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-sticky-note text-amber-500 text-xl"></i>
                            </div>
                            <div>
                                <h2 class="text-lg font-bold text-gray-900 mb-2">Catatan Pesanan</h2>
                                <p class="text-gray-600 bg-amber-50 rounded-xl p-4 border border-amber-100">
                                    <i class="fas fa-quote-left text-amber-300 mr-2"></i>
                                    <?php echo e($order->catatan); ?>

                                    <i class="fas fa-quote-right text-amber-300 ml-2"></i>
                                </p>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                
                <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-white/50 p-6">
                    <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <i class="fas fa-cogs text-gray-400"></i>
                        Aksi Cepat
                    </h2>
                    <div class="flex flex-wrap gap-3">
                        <button onclick="window.print()" class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-gray-600 to-gray-700 text-white rounded-xl hover:from-gray-700 hover:to-gray-800 shadow-lg shadow-gray-200 hover:shadow-xl hover:-translate-y-0.5 transition-all duration-300">
                            <i class="fas fa-print"></i>
                            <span>Cetak</span>
                        </button>
                        <a href="<?php echo e(route('admin.orders.index')); ?>" class="inline-flex items-center gap-2 px-5 py-2.5 bg-white border-2 border-gray-200 text-gray-700 rounded-xl hover:border-indigo-300 hover:bg-indigo-50 hover:-translate-y-0.5 transition-all duration-300">
                            <i class="fas fa-list"></i>
                            <span>Semua Pesanan</span>
                        </a>
                    </div>
                </div>
            </div>

            
            <div class="space-y-6">
                
                <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-white/50 overflow-hidden">
                    <div class="bg-gradient-to-r from-cyan-500 to-blue-500 p-4">
                        <h2 class="text-lg font-bold text-white flex items-center gap-2">
                            <i class="fas fa-user-graduate"></i>
                            Info Siswa
                        </h2>
                    </div>
                    <div class="p-5">
                        <div class="flex items-center gap-4">
                            <div class="w-16 h-16 bg-gradient-to-br from-cyan-100 to-blue-100 rounded-2xl flex items-center justify-center shadow-md">
                                <span class="text-3xl">👨‍🎓</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-bold text-gray-900 text-lg truncate"><?php echo e($order->user->name); ?></p>
                                <p class="text-gray-500 text-sm flex items-center gap-1">
                                    <i class="fas fa-envelope text-xs"></i>
                                    <?php echo e($order->user->email); ?>

                                </p>
                            </div>
                        </div>
                        
                        
                        <div class="mt-4 pt-4 border-t border-gray-100 space-y-3">
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-gray-500 flex items-center gap-2">
                                    <i class="fas fa-wallet text-cyan-500"></i>
                                    Saldo
                                </span>
                                <span class="font-semibold text-gray-900">Rp <?php echo e(number_format($order->user->saldo ?? 0, 0, ',', '.')); ?></span>
                            </div>
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-gray-500 flex items-center gap-2">
                                    <i class="fas fa-shopping-bag text-cyan-500"></i>
                                    Total Order
                                </span>
                                <span class="font-semibold text-gray-900"><?php echo e($order->user->orders->count()); ?> pesanan</span>
                            </div>
                        </div>
                    </div>
                </div>

                
                <?php if(!in_array($order->status, ['selesai', 'batal'])): ?>
                    <?php
                        // Define allowed next statuses based on current status
                        // Flow: pending -> diproses -> selesai (batal can be from any)
                        $allowedStatuses = [
                            'pending' => ['diproses', 'selesai', 'batal'],
                            'diproses' => ['selesai', 'batal'],
                        ];
                        $nextStatuses = $allowedStatuses[$order->status] ?? [];
                    ?>
                    <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-white/50 overflow-hidden">
                        <div class="bg-gradient-to-r from-violet-500 to-purple-500 p-4">
                            <h2 class="text-lg font-bold text-white flex items-center gap-2">
                                <i class="fas fa-exchange-alt"></i>
                                Update Status
                            </h2>
                        </div>
                        <div class="p-5">
                            
                            <div class="mb-4 p-3 rounded-xl <?php echo e($currentStatus['bg']); ?> <?php echo e($currentStatus['border']); ?> border-2">
                                <p class="text-xs text-gray-500 mb-1">Status Saat Ini</p>
                                <div class="flex items-center gap-2">
                                    <div class="w-6 h-6 bg-gradient-to-br <?php echo e($currentStatus['gradient']); ?> rounded-lg flex items-center justify-center">
                                        <i class="fas <?php echo e(str_replace(' fa-spin', '', $currentStatus['icon'])); ?> text-white text-xs"></i>
                                    </div>
                                    <span class="font-semibold <?php echo e($currentStatus['text']); ?>"><?php echo e($currentStatus['label']); ?></span>
                                </div>
                            </div>

                            <div class="flex items-center gap-2 mb-3">
                                <i class="fas fa-arrow-down text-gray-400"></i>
                                <span class="text-sm text-gray-500">Pilih status selanjutnya:</span>
                            </div>
                            
                            <form action="<?php echo e(route('admin.orders.updateStatus', $order)); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('PATCH'); ?>
                                
                                <div class="space-y-3 mb-4">
                                    <?php $__currentLoopData = $statusConfig; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $config): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if(in_array($key, $nextStatuses)): ?>
                                            <label class="flex items-center gap-3 p-3 rounded-xl border-2 cursor-pointer transition-all duration-300 border-gray-100 hover:border-gray-200 hover:bg-gray-50 hover:shadow-md">
                                                <input type="radio" name="status" value="<?php echo e($key); ?>" 
                                                       class="w-4 h-4 text-indigo-600 focus:ring-indigo-500">
                                                <div class="w-8 h-8 bg-gradient-to-br <?php echo e($config['gradient']); ?> rounded-lg flex items-center justify-center">
                                                    <i class="fas <?php echo e(str_replace(' fa-spin', '', $config['icon'])); ?> text-white text-sm"></i>
                                                </div>
                                                <div class="flex-1">
                                                    <span class="font-medium text-gray-700"><?php echo e($config['label']); ?></span>
                                                    <?php if($key == 'batal'): ?>
                                                        <p class="text-xs text-red-500">Pesanan akan dibatalkan</p>
                                                    <?php elseif($key == 'selesai'): ?>
                                                        <p class="text-xs text-emerald-500">Pesanan selesai & tidak bisa diubah</p>
                                                    <?php elseif($key == 'diproses'): ?>
                                                        <p class="text-xs text-blue-500">Pesanan sedang diproses</p>
                                                    <?php endif; ?>
                                                </div>
                                                <i class="fas fa-chevron-right text-gray-300"></i>
                                            </label>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>

                                
                                <div class="mb-4 p-3 rounded-xl bg-amber-50 border border-amber-200">
                                    <div class="flex items-start gap-2">
                                        <i class="fas fa-exclamation-triangle text-amber-500 mt-0.5"></i>
                                        <div>
                                            <p class="text-sm text-amber-700 font-medium">Perhatian!</p>
                                            <p class="text-xs text-amber-600">Status tidak dapat dikembalikan ke status sebelumnya setelah diupdate.</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <button type="submit" class="w-full px-4 py-3 bg-gradient-to-r from-violet-500 to-purple-500 text-white rounded-xl hover:from-violet-600 hover:to-purple-600 shadow-lg shadow-violet-200 hover:shadow-xl hover:-translate-y-0.5 transition-all duration-300 font-semibold flex items-center justify-center gap-2">
                                    <i class="fas fa-save"></i>
                                    Update Status
                                </button>
                            </form>
                        </div>
                    </div>
                <?php else: ?>
                    
                    <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-white/50 overflow-hidden">
                        <div class="bg-gradient-to-r <?php echo e($currentStatus['gradient']); ?> p-4">
                            <h2 class="text-lg font-bold text-white flex items-center gap-2">
                                <i class="fas fa-info-circle"></i>
                                Status Pesanan
                            </h2>
                        </div>
                        <div class="p-5 text-center">
                            <div class="w-20 h-20 bg-gradient-to-br <?php echo e($currentStatus['gradient']); ?> rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg">
                                <i class="fas <?php echo e(str_replace(' fa-spin', '', $currentStatus['icon'])); ?> text-white text-3xl"></i>
                            </div>
                            <p class="font-bold text-xl text-gray-900 mb-1"><?php echo e($currentStatus['label']); ?></p>
                            <p class="text-gray-500 text-sm">
                                <?php if($order->status == 'selesai'): ?>
                                    Pesanan telah selesai diproses
                                <?php else: ?>
                                    Pesanan telah dibatalkan
                                <?php endif; ?>
                            </p>
                        </div>
                    </div>
                <?php endif; ?>

                
                <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-white/50 overflow-hidden">
                    <div class="bg-gradient-to-r from-emerald-500 to-green-500 p-4">
                        <h2 class="text-lg font-bold text-white flex items-center gap-2">
                            <i class="fas fa-history"></i>
                            Timeline
                        </h2>
                    </div>
                    <div class="p-5">
                        <div class="relative">
                            
                            <div class="absolute left-4 top-0 bottom-0 w-0.5 bg-gradient-to-b from-emerald-200 to-blue-200"></div>
                            
                            <div class="space-y-6">
                                
                                <div class="flex items-start gap-4 relative">
                                    <div class="w-8 h-8 bg-gradient-to-br from-emerald-500 to-green-500 rounded-full flex items-center justify-center shadow-md z-10">
                                        <i class="fas fa-plus text-white text-xs"></i>
                                    </div>
                                    <div class="flex-1 bg-emerald-50 rounded-xl p-3 border border-emerald-100">
                                        <p class="font-semibold text-emerald-700">Pesanan Dibuat</p>
                                        <p class="text-xs text-emerald-600 flex items-center gap-1 mt-1">
                                            <i class="fas fa-clock"></i>
                                            <?php echo e($order->created_at->format('d M Y, H:i')); ?>

                                        </p>
                                    </div>
                                </div>
                                
                                <?php if($order->updated_at != $order->created_at): ?>
                                    
                                    <div class="flex items-start gap-4 relative">
                                        <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-indigo-500 rounded-full flex items-center justify-center shadow-md z-10">
                                            <i class="fas fa-sync-alt text-white text-xs"></i>
                                        </div>
                                        <div class="flex-1 bg-blue-50 rounded-xl p-3 border border-blue-100">
                                            <p class="font-semibold text-blue-700">Status Diperbarui</p>
                                            <p class="text-xs text-blue-600 flex items-center gap-1 mt-1">
                                                <i class="fas fa-clock"></i>
                                                <?php echo e($order->updated_at->format('d M Y, H:i')); ?>

                                            </p>
                                            <div class="mt-2 inline-flex items-center gap-1 px-2 py-1 rounded-md <?php echo e($currentStatus['bg']); ?> <?php echo e($currentStatus['text']); ?> text-xs font-medium">
                                                <i class="fas <?php echo e(str_replace(' fa-spin', '', $currentStatus['icon'])); ?>"></i>
                                                <?php echo e($currentStatus['label']); ?>

                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                
                                <?php if($order->status == 'selesai'): ?>
                                    
                                    <div class="flex items-start gap-4 relative">
                                        <div class="w-8 h-8 bg-gradient-to-br from-emerald-500 to-green-500 rounded-full flex items-center justify-center shadow-md z-10">
                                            <i class="fas fa-check text-white text-xs"></i>
                                        </div>
                                        <div class="flex-1 bg-emerald-50 rounded-xl p-3 border border-emerald-100">
                                            <p class="font-semibold text-emerald-700">Pesanan Selesai</p>
                                            <p class="text-xs text-emerald-600">Pesanan telah diselesaikan</p>
                                        </div>
                                    </div>
                                <?php elseif($order->status == 'batal'): ?>
                                    
                                    <div class="flex items-start gap-4 relative">
                                        <div class="w-8 h-8 bg-gradient-to-br from-red-500 to-rose-500 rounded-full flex items-center justify-center shadow-md z-10">
                                            <i class="fas fa-ban text-white text-xs"></i>
                                        </div>
                                        <div class="flex-1 bg-red-50 rounded-xl p-3 border border-red-100">
                                            <p class="font-semibold text-red-700">Pesanan Dibatalkan</p>
                                            <p class="text-xs text-red-600">Pesanan telah dibatalkan</p>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\kantin-modern\resources\views/admin/orders/show.blade.php ENDPATH**/ ?>