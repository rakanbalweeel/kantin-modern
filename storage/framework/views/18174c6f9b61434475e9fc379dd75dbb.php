



<?php $__env->startSection('title', 'Riwayat Pesanan'); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen hero-gradient py-8">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        
        
        <div class="mb-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div class="flex items-center mb-4 md:mb-0">
                    <div class="w-14 h-14 bg-gradient-to-br from-orange-500 to-amber-500 rounded-2xl flex items-center justify-center shadow-lg shadow-orange-500/20 mr-4">
                        <i class="fas fa-clipboard-list text-white text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold text-white">Riwayat <span class="gradient-text">Pesanan</span></h1>
                        <p class="text-slate-400 mt-1">Lacak dan kelola semua pesananmu</p>
                    </div>
                </div>
                
                <?php if($orders->count() > 0): ?>
                <div class="flex items-center space-x-3">
                    <div class="glass-card rounded-2xl px-5 py-3">
                        <p class="text-xs text-slate-500 uppercase tracking-wider">Total Pesanan</p>
                        <p class="text-2xl font-bold text-orange-400"><?php echo e($orders->total()); ?></p>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>

        
        <?php if($orders->count() > 0): ?>
        <div class="glass rounded-2xl p-4 mb-8">
            <div class="flex flex-wrap items-center gap-3">
                <span class="text-sm text-slate-500">Filter:</span>
                <a href="<?php echo e(route('siswa.orders.index')); ?>" 
                   class="px-4 py-2 rounded-xl text-sm font-medium transition-all <?php echo e(!request('status') ? 'bg-gradient-to-r from-orange-500 to-amber-500 text-white shadow-lg shadow-orange-500/30' : 'bg-white/5 text-slate-300 hover:bg-white/10'); ?>">
                    <i class="fas fa-list mr-2"></i>Semua
                </a>
                <a href="<?php echo e(route('siswa.orders.index', ['status' => 'pending'])); ?>" 
                   class="px-4 py-2 rounded-xl text-sm font-medium transition-all <?php echo e(request('status') == 'pending' ? 'bg-yellow-500 text-white shadow-lg shadow-yellow-500/30' : 'bg-white/5 text-slate-300 hover:bg-white/10'); ?>">
                    <i class="fas fa-clock mr-2"></i>Pending
                </a>
                <a href="<?php echo e(route('siswa.orders.index', ['status' => 'diproses'])); ?>" 
                   class="px-4 py-2 rounded-xl text-sm font-medium transition-all <?php echo e(request('status') == 'diproses' ? 'bg-blue-500 text-white shadow-lg shadow-blue-500/30' : 'bg-white/5 text-slate-300 hover:bg-white/10'); ?>">
                    <i class="fas fa-sync-alt mr-2"></i>Diproses
                </a>
                <a href="<?php echo e(route('siswa.orders.index', ['status' => 'selesai'])); ?>" 
                   class="px-4 py-2 rounded-xl text-sm font-medium transition-all <?php echo e(request('status') == 'selesai' ? 'bg-emerald-500 text-white shadow-lg shadow-emerald-500/30' : 'bg-white/5 text-slate-300 hover:bg-white/10'); ?>">
                    <i class="fas fa-check-circle mr-2"></i>Selesai
                </a>
            </div>
        </div>
        <?php endif; ?>

        
        <div class="space-y-5">
            <?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <?php
                    $statusConfig = [
                        'pending' => [
                            'bg' => 'bg-yellow-500/20',
                            'text' => 'text-yellow-400',
                            'icon' => 'fa-clock',
                            'label' => 'Menunggu'
                        ],
                        'diproses' => [
                            'bg' => 'bg-blue-500/20',
                            'text' => 'text-blue-400',
                            'icon' => 'fa-sync-alt fa-spin',
                            'label' => 'Diproses'
                        ],
                        'selesai' => [
                            'bg' => 'bg-emerald-500/20',
                            'text' => 'text-emerald-400',
                            'icon' => 'fa-check-circle',
                            'label' => 'Selesai'
                        ],
                        'batal' => [
                            'bg' => 'bg-red-500/20',
                            'text' => 'text-red-400',
                            'icon' => 'fa-times-circle',
                            'label' => 'Dibatalkan'
                        ],
                    ];
                    $config = $statusConfig[$order->status] ?? $statusConfig['pending'];
                ?>
                
                <div class="glass-card rounded-2xl overflow-hidden hover:bg-white/5 transition-all duration-300 group">
                    
                    <div class="p-6 flex flex-col md:flex-row md:items-center justify-between border-b border-slate-700/50">
                        <div class="flex items-center mb-4 md:mb-0">
                            <div class="w-12 h-12 <?php echo e($config['bg']); ?> rounded-xl flex items-center justify-center mr-4">
                                <i class="fas <?php echo e($config['icon']); ?> <?php echo e($config['text']); ?> text-lg"></i>
                            </div>
                            <div>
                                <p class="font-bold text-white text-lg">#<?php echo e($order->kode_pesanan); ?></p>
                                <div class="flex items-center mt-1 text-sm text-slate-500">
                                    <i class="fas fa-calendar-alt mr-2"></i>
                                    <?php echo e($order->created_at->locale('id')->isoFormat('dddd, D MMM Y')); ?>

                                    <span class="mx-2">•</span>
                                    <i class="fas fa-clock mr-2"></i>
                                    <?php echo e($order->created_at->format('H:i')); ?>

                                </div>
                            </div>
                        </div>
                        <div class="flex items-center space-x-3">
                            
                            <?php if($order->waktu_pengambilan): ?>
                            <span class="px-3 py-2 <?php echo e($order->waktu_pengambilan === 'istirahat_1' ? 'bg-blue-500/20 text-blue-400' : 'bg-purple-500/20 text-purple-400'); ?> rounded-xl text-sm font-medium flex items-center">
                                <i class="fas fa-clock mr-2"></i>
                                <?php echo e($order->waktu_pengambilan === 'istirahat_1' ? 'Ist. 1' : 'Ist. 2'); ?>

                            </span>
                            <?php endif; ?>
                            <span class="px-4 py-2 <?php echo e($config['bg']); ?> <?php echo e($config['text']); ?> rounded-xl text-sm font-semibold flex items-center">
                                <i class="fas <?php echo e($config['icon']); ?> mr-2"></i>
                                <?php echo e($config['label']); ?>

                            </span>
                        </div>
                    </div>
                    
                    
                    <div class="p-6">
                        <div class="flex flex-wrap gap-2 mb-4">
                            <?php $__currentLoopData = $order->orderDetails->take(3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="glass rounded-lg px-3 py-2 text-sm text-slate-300">
                                    <?php echo e($detail->product->nama ?? 'Produk'); ?> × <?php echo e($detail->jumlah); ?>

                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php if($order->orderDetails->count() > 3): ?>
                                <div class="glass rounded-lg px-3 py-2 text-sm text-slate-400">
                                    +<?php echo e($order->orderDetails->count() - 3); ?> lainnya
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="flex flex-col md:flex-row md:items-center justify-between pt-4 border-t border-slate-700/50">
                            <div>
                                <p class="text-sm text-slate-500">Total Pembayaran</p>
                                <p class="text-2xl font-bold text-orange-400">Rp <?php echo e(number_format($order->total, 0, ',', '.')); ?></p>
                            </div>
                            <div class="flex items-center space-x-3 mt-4 md:mt-0">
                                <?php if($order->status == 'pending'): ?>
                                    <form action="<?php echo e(route('siswa.orders.cancel', $order->id)); ?>" method="POST" 
                                          onsubmit="return confirm('Yakin ingin membatalkan pesanan ini?');">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('PATCH'); ?>
                                        <button type="submit" 
                                                class="px-4 py-2 bg-red-500/20 text-red-400 rounded-xl hover:bg-red-500/30 transition-all text-sm font-medium">
                                            <i class="fas fa-times mr-2"></i>Batalkan
                                        </button>
                                    </form>
                                <?php endif; ?>
                                <a href="<?php echo e(route('siswa.orders.show', $order->id)); ?>" 
                                   class="px-5 py-2 bg-gradient-to-r from-orange-500 to-amber-500 text-white rounded-xl shadow-lg shadow-orange-500/20 hover:shadow-orange-500/40 transition-all text-sm font-semibold">
                                    <i class="fas fa-eye mr-2"></i>Lihat Detail
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                
                <div class="glass-card rounded-3xl p-12 text-center">
                    <div class="w-24 h-24 mx-auto bg-gradient-to-br from-orange-500/20 to-amber-500/20 rounded-full flex items-center justify-center mb-6">
                        <i class="fas fa-shopping-basket text-4xl text-orange-400"></i>
                    </div>
                    <h2 class="text-2xl font-bold text-white mb-2">Belum Ada Pesanan</h2>
                    <p class="text-slate-400 mb-8 max-w-sm mx-auto">
                        Kamu belum pernah memesan. Yuk mulai pesan makanan favoritmu!
                    </p>
                    <a href="<?php echo e(route('siswa.menu')); ?>" 
                       class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-orange-500 to-amber-500 text-white rounded-2xl font-semibold shadow-lg shadow-orange-500/30 hover:shadow-orange-500/50 hover:-translate-y-1 transition-all duration-300">
                        <i class="fas fa-utensils mr-3"></i>
                        Lihat Menu
                    </a>
                </div>
            <?php endif; ?>
        </div>

        
        <?php if($orders->hasPages()): ?>
            <div class="mt-8 flex justify-center">
                <?php echo e($orders->links()); ?>

            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\kantin-modern\resources\views/siswa/orders/index.blade.php ENDPATH**/ ?>