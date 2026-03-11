



<?php $__env->startSection('title', 'Dashboard Admin'); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen hero-gradient py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="mb-10">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <h1 class="text-4xl font-extrabold text-white">
                        Dash<span class="gradient-text">board</span>
                    </h1>
                    <p class="mt-2 text-slate-400 text-lg">Selamat datang kembali, <span class="font-semibold text-white"><?php echo e(auth()->user()->name); ?></span>! 👋</p>
                </div>
                <div class="mt-4 lg:mt-0 flex items-center space-x-3">
                    <div class="px-4 py-2 glass rounded-xl text-sm text-slate-300">
                        <i class="fas fa-calendar-alt mr-2 text-orange-400"></i>
                        <?php echo e(\Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM Y')); ?>

                    </div>
                </div>
            </div>
        </div>

        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
            
            <div class="glass-card rounded-2xl p-6 hover:bg-white/5 transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-emerald-500 to-green-600 rounded-2xl flex items-center justify-center shadow-lg shadow-emerald-500/20">
                        <i class="fas fa-coins text-xl text-white"></i>
                    </div>
                    <span class="px-2 py-1 bg-emerald-500/20 text-emerald-400 rounded-lg text-xs font-medium">
                        <i class="fas fa-arrow-up mr-1"></i>Total
                    </span>
                </div>
                <p class="text-sm font-medium text-slate-400 mb-1">Total Pendapatan</p>
                <p class="text-2xl font-extrabold text-emerald-400">
                    Rp <?php echo e(number_format($stats['total_pendapatan'] ?? 0, 0, ',', '.')); ?>

                </p>
            </div>

            
            <div class="glass-card rounded-2xl p-6 hover:bg-white/5 transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl flex items-center justify-center shadow-lg shadow-blue-500/20">
                        <i class="fas fa-shopping-cart text-xl text-white"></i>
                    </div>
                    <span class="px-2 py-1 bg-blue-500/20 text-blue-400 rounded-lg text-xs font-medium">
                        <i class="fas fa-clock mr-1"></i>Hari Ini
                    </span>
                </div>
                <p class="text-sm font-medium text-slate-400 mb-1">Pesanan Hari Ini</p>
                <p class="text-2xl font-extrabold text-blue-400"><?php echo e($stats['pesanan_hari_ini'] ?? 0); ?></p>
            </div>

            
            <div class="glass-card rounded-2xl p-6 hover:bg-white/5 transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-pink-600 rounded-2xl flex items-center justify-center shadow-lg shadow-purple-500/20">
                        <i class="fas fa-boxes text-xl text-white"></i>
                    </div>
                </div>
                <p class="text-sm font-medium text-slate-400 mb-1">Total Produk</p>
                <p class="text-2xl font-extrabold text-purple-400"><?php echo e($stats['total_produk'] ?? 0); ?></p>
            </div>

            
            <div class="glass-card rounded-2xl p-6 hover:bg-white/5 transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-orange-500 to-amber-500 rounded-2xl flex items-center justify-center shadow-lg shadow-orange-500/20">
                        <i class="fas fa-user-graduate text-xl text-white"></i>
                    </div>
                </div>
                <p class="text-sm font-medium text-slate-400 mb-1">Total Siswa</p>
                <p class="text-2xl font-extrabold text-orange-400"><?php echo e($stats['total_siswa'] ?? 0); ?></p>
            </div>
        </div>

        
        <div class="glass-card rounded-2xl p-6 mb-10">
            <h3 class="font-bold text-white mb-4 flex items-center">
                <div class="w-8 h-8 bg-gradient-to-br from-orange-500 to-amber-500 rounded-lg flex items-center justify-center mr-3">
                    <i class="fas fa-bolt text-white text-sm"></i>
                </div>
                Menu Cepat
            </h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <a href="<?php echo e(route('admin.products.index')); ?>" class="glass rounded-xl p-4 text-center hover:bg-white/10 transition-all group">
                    <div class="w-12 h-12 mx-auto bg-purple-500/20 rounded-xl flex items-center justify-center mb-3 group-hover:bg-purple-500/30 transition-colors">
                        <i class="fas fa-box text-purple-400 text-xl"></i>
                    </div>
                    <p class="text-sm font-medium text-slate-300">Produk</p>
                </a>
                <a href="<?php echo e(route('admin.categories.index')); ?>" class="glass rounded-xl p-4 text-center hover:bg-white/10 transition-all group">
                    <div class="w-12 h-12 mx-auto bg-blue-500/20 rounded-xl flex items-center justify-center mb-3 group-hover:bg-blue-500/30 transition-colors">
                        <i class="fas fa-tags text-blue-400 text-xl"></i>
                    </div>
                    <p class="text-sm font-medium text-slate-300">Kategori</p>
                </a>
                <a href="<?php echo e(route('admin.orders.index')); ?>" class="glass rounded-xl p-4 text-center hover:bg-white/10 transition-all group">
                    <div class="w-12 h-12 mx-auto bg-amber-500/20 rounded-xl flex items-center justify-center mb-3 group-hover:bg-amber-500/30 transition-colors">
                        <i class="fas fa-receipt text-amber-400 text-xl"></i>
                    </div>
                    <p class="text-sm font-medium text-slate-300">Pesanan</p>
                </a>
                <a href="<?php echo e(route('admin.reports.sales')); ?>" class="glass rounded-xl p-4 text-center hover:bg-white/10 transition-all group">
                    <div class="w-12 h-12 mx-auto bg-emerald-500/20 rounded-xl flex items-center justify-center mb-3 group-hover:bg-emerald-500/30 transition-colors">
                        <i class="fas fa-chart-line text-emerald-400 text-xl"></i>
                    </div>
                    <p class="text-sm font-medium text-slate-300">Laporan</p>
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            
            <div class="glass-card rounded-2xl overflow-hidden">
                <div class="bg-gradient-to-r from-orange-500 to-amber-500 px-6 py-4 flex items-center justify-between">
                    <h3 class="font-bold text-white flex items-center">
                        <i class="fas fa-history mr-2"></i> Pesanan Terbaru
                    </h3>
                    <a href="<?php echo e(route('admin.orders.index')); ?>" class="text-white/80 hover:text-white text-sm">
                        Lihat Semua <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
                <div class="divide-y divide-slate-700/50">
                    <?php $__empty_1 = true; $__currentLoopData = $recentOrders ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <?php
                            $statusColors = [
                                'pending' => 'bg-yellow-500/20 text-yellow-400',
                                'diproses' => 'bg-blue-500/20 text-blue-400',
                                'selesai' => 'bg-emerald-500/20 text-emerald-400',
                                'batal' => 'bg-red-500/20 text-red-400',
                            ];
                        ?>
                        <div class="p-4 hover:bg-white/5 transition-colors">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-slate-700 rounded-xl flex items-center justify-center mr-3">
                                        <i class="fas fa-receipt text-orange-400"></i>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-white"><?php echo e($order->kode_pesanan); ?></p>
                                        <p class="text-sm text-slate-500"><?php echo e($order->user->name ?? 'Unknown'); ?></p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="font-bold text-orange-400">Rp <?php echo e(number_format($order->total, 0, ',', '.')); ?></p>
                                    <span class="px-2 py-1 <?php echo e($statusColors[$order->status] ?? $statusColors['pending']); ?> rounded-lg text-xs font-medium">
                                        <?php echo e(ucfirst($order->status)); ?>

                                    </span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="p-8 text-center">
                            <div class="w-16 h-16 bg-slate-800 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-inbox text-2xl text-slate-600"></i>
                            </div>
                            <p class="text-slate-400">Belum ada pesanan</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            
            <div class="glass-card rounded-2xl overflow-hidden">
                <div class="bg-gradient-to-r from-red-500 to-pink-600 px-6 py-4 flex items-center justify-between">
                    <h3 class="font-bold text-white flex items-center">
                        <i class="fas fa-exclamation-triangle mr-2"></i> Stok Menipis
                    </h3>
                    <a href="<?php echo e(route('admin.products.index')); ?>" class="text-white/80 hover:text-white text-sm">
                        Lihat Semua <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
                <div class="divide-y divide-slate-700/50">
                    <?php $__empty_1 = true; $__currentLoopData = $lowStockProducts ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="p-4 hover:bg-white/5 transition-colors">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-slate-700 rounded-xl flex items-center justify-center mr-3 overflow-hidden">
                                        <?php if($product->gambar): ?>
                                            <img src="<?php echo e(asset('storage/' . $product->gambar)); ?>" alt="<?php echo e($product->nama); ?>" class="w-full h-full object-cover">
                                        <?php else: ?>
                                            <i class="fas fa-box text-slate-500"></i>
                                        <?php endif; ?>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-white"><?php echo e($product->nama); ?></p>
                                        <p class="text-sm text-slate-500"><?php echo e($product->category->nama ?? 'No Category'); ?></p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <span class="px-3 py-1 bg-red-500/20 text-red-400 rounded-lg text-sm font-bold">
                                        <?php echo e($product->stok); ?> pcs
                                    </span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="p-8 text-center">
                            <div class="w-16 h-16 bg-slate-800 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-check-circle text-2xl text-emerald-500"></i>
                            </div>
                            <p class="text-slate-400">Semua stok aman!</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\kantin-modern\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>