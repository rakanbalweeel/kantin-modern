



<?php $__env->startSection('title', 'Riwayat Pesanan'); ?>

<?php $__env->startSection('content'); ?>
<div class="py-8">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        
        
        <div class="mb-10">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div>
                    <div class="flex items-center space-x-3 mb-2">
                        <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg shadow-indigo-200">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold bg-gradient-to-r from-gray-900 via-indigo-900 to-purple-900 bg-clip-text text-transparent">
                                Riwayat Pesanan
                            </h1>
                            <p class="text-gray-500 text-sm mt-0.5">Lacak dan kelola semua pesananmu</p>
                        </div>
                    </div>
                </div>
                
                
                <?php if($orders->count() > 0): ?>
                <div class="flex items-center space-x-4 mt-4 md:mt-0">
                    <div class="bg-white/80 backdrop-blur-sm rounded-2xl px-5 py-3 shadow-sm border border-indigo-100">
                        <p class="text-xs text-gray-500 uppercase tracking-wider">Total Pesanan</p>
                        <p class="text-2xl font-bold text-indigo-600"><?php echo e($orders->total()); ?></p>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>

        
        <?php if($orders->count() > 0): ?>
        <div class="mb-6 flex items-center space-x-2 overflow-x-auto pb-2">
            <span class="text-sm text-gray-500 whitespace-nowrap">Filter:</span>
            <a href="<?php echo e(route('siswa.orders.index')); ?>" 
               class="px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 <?php echo e(!request('status') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-200' : 'bg-white text-gray-600 hover:bg-gray-50 border border-gray-200'); ?>">
                Semua
            </a>
            <a href="<?php echo e(route('siswa.orders.index', ['status' => 'pending'])); ?>" 
               class="px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 <?php echo e(request('status') == 'pending' ? 'bg-amber-500 text-white shadow-lg shadow-amber-200' : 'bg-white text-gray-600 hover:bg-gray-50 border border-gray-200'); ?>">
                Pending
            </a>
            <a href="<?php echo e(route('siswa.orders.index', ['status' => 'diproses'])); ?>" 
               class="px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 <?php echo e(request('status') == 'diproses' ? 'bg-blue-500 text-white shadow-lg shadow-blue-200' : 'bg-white text-gray-600 hover:bg-gray-50 border border-gray-200'); ?>">
                Diproses
            </a>
            <a href="<?php echo e(route('siswa.orders.index', ['status' => 'selesai'])); ?>" 
               class="px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 <?php echo e(request('status') == 'selesai' ? 'bg-emerald-500 text-white shadow-lg shadow-emerald-200' : 'bg-white text-gray-600 hover:bg-gray-50 border border-gray-200'); ?>">
                Selesai
            </a>
        </div>
        <?php endif; ?>

        
        <div class="space-y-5">
            <?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <?php
                    $statusConfig = [
                        'pending' => [
                            'bg' => 'bg-gradient-to-r from-amber-400 to-orange-400',
                            'text' => 'text-amber-700',
                            'light' => 'bg-amber-50',
                            'border' => 'border-amber-200',
                            'icon' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
                            'label' => 'Menunggu'
                        ],
                        'diproses' => [
                            'bg' => 'bg-gradient-to-r from-blue-400 to-cyan-400',
                            'text' => 'text-blue-700',
                            'light' => 'bg-blue-50',
                            'border' => 'border-blue-200',
                            'icon' => '<svg class="w-4 h-4 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>',
                            'label' => 'Diproses'
                        ],
                        'selesai' => [
                            'bg' => 'bg-gradient-to-r from-emerald-400 to-green-400',
                            'text' => 'text-emerald-700',
                            'light' => 'bg-emerald-50',
                            'border' => 'border-emerald-200',
                            'icon' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
                            'label' => 'Selesai'
                        ],
                        'batal' => [
                            'bg' => 'bg-gradient-to-r from-red-400 to-rose-400',
                            'text' => 'text-red-700',
                            'light' => 'bg-red-50',
                            'border' => 'border-red-200',
                            'icon' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
                            'label' => 'Dibatalkan'
                        ],
                    ];
                    $config = $statusConfig[$order->status] ?? $statusConfig['pending'];
                ?>
                
                <div class="group bg-white rounded-2xl shadow-sm hover:shadow-xl border border-gray-100 overflow-hidden transition-all duration-300 hover:-translate-y-1"
                     style="animation: fadeInUp 0.5s ease-out <?php echo e($index * 0.1); ?>s both;">
                    
                    
                    <div class="h-1.5 <?php echo e($config['bg']); ?>"></div>
                    
                    <div class="p-5 sm:p-6">
                        
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-5">
                            <div class="flex items-center space-x-4">
                                
                                <div class="w-14 h-14 <?php echo e($config['light']); ?> rounded-2xl flex items-center justify-center <?php echo e($config['border']); ?> border-2">
                                    <svg class="w-7 h-7 <?php echo e($config['text']); ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                    </svg>
                                </div>
                                
                                <div>
                                    <div class="flex items-center space-x-2">
                                        <h3 class="font-bold text-gray-900 text-lg"><?php echo e($order->kode_pesanan); ?></h3>
                                    </div>
                                    <div class="flex items-center space-x-2 mt-1">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        <span class="text-sm text-gray-500"><?php echo e($order->created_at->format('d M Y')); ?></span>
                                        <span class="text-gray-300">•</span>
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <span class="text-sm text-gray-500"><?php echo e($order->created_at->format('H:i')); ?> WIB</span>
                                    </div>
                                </div>
                            </div>
                            
                            
                            <div class="mt-3 sm:mt-0">
                                <span class="inline-flex items-center space-x-1.5 px-4 py-2 rounded-full text-sm font-semibold <?php echo e($config['light']); ?> <?php echo e($config['text']); ?> <?php echo e($config['border']); ?> border">
                                    <?php echo $config['icon']; ?>

                                    <span><?php echo e($config['label']); ?></span>
                                </span>
                            </div>
                        </div>
                        
                        
                        <div class="bg-gradient-to-br from-gray-50 to-slate-50 rounded-xl p-4 mb-5">
                            <div class="space-y-3">
                                <?php $__currentLoopData = $order->orderDetails->take(3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-3">
                                            <?php if($detail->product && $detail->product->gambar): ?>
                                                <img src="<?php echo e(Storage::url($detail->product->gambar)); ?>" 
                                                     alt="<?php echo e($detail->product->nama); ?>"
                                                     class="w-12 h-12 rounded-xl object-cover ring-2 ring-white shadow-sm">
                                            <?php else: ?>
                                                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-indigo-100 to-blue-100 flex items-center justify-center ring-2 ring-white shadow-sm">
                                                    <svg class="w-6 h-6 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                                    </svg>
                                                </div>
                                            <?php endif; ?>
                                            <div>
                                                <p class="font-medium text-gray-900"><?php echo e($detail->product->nama ?? 'Produk tidak tersedia'); ?></p>
                                                <p class="text-sm text-gray-500">
                                                    <?php echo e($detail->jumlah); ?> × Rp <?php echo e(number_format($detail->harga, 0, ',', '.')); ?>

                                                </p>
                                            </div>
                                        </div>
                                        <span class="font-semibold text-gray-900">
                                            Rp <?php echo e(number_format($detail->subtotal, 0, ',', '.')); ?>

                                        </span>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                
                                <?php if($order->orderDetails->count() > 3): ?>
                                    <div class="pt-2 border-t border-gray-200">
                                        <p class="text-sm text-gray-500 flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                            </svg>
                                            <?php echo e($order->orderDetails->count() - 3); ?> item lainnya
                                        </p>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between pt-4 border-t border-gray-100">
                            <div class="flex items-center space-x-2">
                                <span class="text-gray-500">Total Pembayaran:</span>
                                <span class="text-2xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
                                    Rp <?php echo e(number_format($order->total, 0, ',', '.')); ?>

                                </span>
                            </div>
                            
                            <div class="flex items-center space-x-2 mt-4 sm:mt-0">
                                <a href="<?php echo e(route('siswa.orders.show', $order)); ?>" 
                                   class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl font-medium text-sm hover:from-indigo-700 hover:to-purple-700 transition-all duration-200 shadow-lg shadow-indigo-200 hover:shadow-xl hover:shadow-indigo-300">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    Lihat Detail
                                </a>
                                
                                <?php if($order->status === 'pending'): ?>
                                    <form action="<?php echo e(route('siswa.orders.cancel', $order)); ?>" 
                                          method="POST"
                                          onsubmit="return confirm('Yakin ingin membatalkan pesanan ini?')">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('PATCH'); ?>
                                        <button type="submit" 
                                                class="inline-flex items-center px-5 py-2.5 bg-white border-2 border-red-200 text-red-600 rounded-xl font-medium text-sm hover:bg-red-50 hover:border-red-300 transition-all duration-200">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                            Batalkan
                                        </button>
                                    </form>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                
                <div class="bg-white rounded-3xl shadow-xl border border-gray-100 p-12 text-center">
                    <div class="w-32 h-32 mx-auto mb-6 bg-gradient-to-br from-indigo-100 to-blue-100 rounded-full flex items-center justify-center">
                        <svg class="w-16 h-16 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">Belum Ada Pesanan</h2>
                    <p class="text-gray-500 mb-8 max-w-sm mx-auto">
                        Kamu belum pernah membuat pesanan. Yuk mulai pesan makanan favoritmu!
                    </p>
                    <a href="<?php echo e(route('siswa.menu')); ?>" 
                       class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-2xl font-semibold hover:from-indigo-700 hover:to-purple-700 transition-all duration-200 shadow-xl shadow-indigo-200 hover:shadow-2xl hover:shadow-indigo-300 hover:-translate-y-1">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        Pesan Sekarang
                    </a>
                </div>
            <?php endif; ?>
        </div>

        
        <?php if($orders->hasPages()): ?>
            <div class="mt-10 flex justify-center">
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 px-2 py-2">
                    <?php echo e($orders->links()); ?>

                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\kantin-modern\resources\views/siswa/orders/index.blade.php ENDPATH**/ ?>