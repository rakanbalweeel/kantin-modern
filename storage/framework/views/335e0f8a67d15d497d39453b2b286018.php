



<?php $__env->startSection('title', 'Detail Pesanan'); ?>

<?php $__env->startSection('content'); ?>
<div class="py-8">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="mb-6">
            <a href="<?php echo e(route('siswa.orders.index')); ?>" 
               class="inline-flex items-center text-gray-500 hover:text-indigo-600 transition-colors duration-200 group">
                <div class="w-8 h-8 rounded-lg bg-white shadow-sm border border-gray-200 flex items-center justify-center mr-3 group-hover:border-indigo-300 group-hover:shadow-md transition-all duration-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </div>
                <span class="font-medium">Kembali ke Riwayat</span>
            </a>
        </div>

        
        <div class="bg-white rounded-3xl shadow-2xl border border-gray-100 overflow-hidden relative">
            
            <div class="absolute top-0 left-0 right-0 h-2 bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500"></div>
            
            
            <div class="bg-gradient-to-br from-indigo-600 via-purple-600 to-indigo-700 px-8 pt-10 pb-12 text-white text-center relative overflow-hidden">
                
                <div class="absolute inset-0 opacity-10">
                    <div class="absolute top-0 left-0 w-40 h-40 bg-white rounded-full -translate-x-1/2 -translate-y-1/2"></div>
                    <div class="absolute bottom-0 right-0 w-32 h-32 bg-white rounded-full translate-x-1/2 translate-y-1/2"></div>
                </div>
                
                <div class="relative">
                    <div class="w-20 h-20 mx-auto bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center mb-4 shadow-lg">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                        </svg>
                    </div>
                    <h1 class="text-3xl font-bold">RasaPelajar</h1>
                    <p class="text-indigo-200 text-sm mt-1">Sistem Informasi Kantin Sekolah</p>
                    
                    
                    <?php
                        $statusConfig = [
                            'pending' => [
                                'bg' => 'bg-amber-400',
                                'text' => 'text-amber-900',
                                'icon' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
                                'label' => 'Menunggu Konfirmasi'
                            ],
                            'diproses' => [
                                'bg' => 'bg-blue-400',
                                'text' => 'text-blue-900',
                                'icon' => '<svg class="w-4 h-4 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>',
                                'label' => 'Sedang Diproses'
                            ],
                            'selesai' => [
                                'bg' => 'bg-emerald-400',
                                'text' => 'text-emerald-900',
                                'icon' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
                                'label' => 'Selesai'
                            ],
                            'batal' => [
                                'bg' => 'bg-red-400',
                                'text' => 'text-red-900',
                                'icon' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
                                'label' => 'Dibatalkan'
                            ],
                        ];
                        $config = $statusConfig[$order->status] ?? $statusConfig['pending'];
                    ?>
                    <div class="mt-6">
                        <span class="inline-flex items-center space-x-2 px-4 py-2 rounded-full <?php echo e($config['bg']); ?> <?php echo e($config['text']); ?> font-semibold text-sm shadow-lg">
                            <?php echo $config['icon']; ?>

                            <span><?php echo e($config['label']); ?></span>
                        </span>
                    </div>
                </div>
            </div>

            
            <div class="px-8 py-6 border-b border-dashed border-gray-200 bg-gradient-to-b from-gray-50 to-white">
                <div class="grid grid-cols-2 gap-6">
                    <div class="space-y-1">
                        <p class="text-xs text-gray-400 uppercase tracking-wider font-medium">No. Pesanan</p>
                        <p class="font-bold text-gray-900 text-lg"><?php echo e($order->kode_pesanan); ?></p>
                    </div>
                    <div class="space-y-1 text-right">
                        <p class="text-xs text-gray-400 uppercase tracking-wider font-medium">Tanggal</p>
                        <p class="font-medium text-gray-900"><?php echo e($order->created_at->format('d M Y')); ?></p>
                        <p class="text-sm text-gray-500"><?php echo e($order->created_at->format('H:i')); ?> WIB</p>
                    </div>
                </div>
                
                
                <div class="mt-6 pt-4 border-t border-gray-100">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg shadow-indigo-200">
                            <span class="text-white font-bold"><?php echo e(strtoupper(substr($order->user->name, 0, 1))); ?></span>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900"><?php echo e($order->user->name); ?></p>
                            <p class="text-sm text-gray-500"><?php echo e($order->user->email); ?></p>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="px-8 py-6">
                <div class="flex items-center space-x-3 mb-6">
                    <div class="w-10 h-10 bg-gradient-to-br from-amber-400 to-orange-400 rounded-xl flex items-center justify-center shadow-lg shadow-amber-200">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-900">Detail Pesanan</h3>
                        <p class="text-sm text-gray-500"><?php echo e($order->orderDetails->count()); ?> item</p>
                    </div>
                </div>
                
                <div class="space-y-4">
                    <?php $__currentLoopData = $order->orderDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="flex items-start space-x-4 p-4 bg-gradient-to-r from-gray-50 to-indigo-50/30 rounded-xl border border-gray-100">
                            
                            <?php if($detail->product && $detail->product->gambar): ?>
                                <img src="<?php echo e(Storage::url($detail->product->gambar)); ?>" 
                                     alt="<?php echo e($detail->product->nama); ?>"
                                     class="w-14 h-14 rounded-xl object-cover ring-2 ring-white shadow-sm">
                            <?php else: ?>
                                <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-indigo-100 to-purple-100 flex items-center justify-center ring-2 ring-white shadow-sm flex-shrink-0">
                                    <svg class="w-7 h-7 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                    </svg>
                                </div>
                            <?php endif; ?>
                            
                            <div class="flex-1">
                                <p class="font-semibold text-gray-900"><?php echo e($detail->product->nama ?? 'Produk tidak tersedia'); ?></p>
                                <p class="text-sm text-gray-500 mt-0.5">
                                    <?php echo e($detail->jumlah); ?> × Rp <?php echo e(number_format($detail->harga, 0, ',', '.')); ?>

                                </p>
                            </div>
                            <span class="font-bold text-gray-900 text-lg">
                                Rp <?php echo e(number_format($detail->subtotal, 0, ',', '.')); ?>

                            </span>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>

            
            <?php if($order->catatan): ?>
                <div class="px-8 py-5 border-t border-gray-100">
                    <div class="flex items-start space-x-3 p-4 bg-amber-50 rounded-xl border border-amber-200">
                        <div class="w-8 h-8 bg-amber-400 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-amber-600 uppercase tracking-wider font-semibold mb-1">Catatan</p>
                            <p class="text-amber-800"><?php echo e($order->catatan); ?></p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            
            <div class="px-8 py-6 bg-gradient-to-br from-gray-50 to-indigo-50 border-t border-gray-200">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-gray-500">Subtotal</span>
                    <span class="font-medium text-gray-900">Rp <?php echo e(number_format($order->total, 0, ',', '.')); ?></span>
                </div>
                <div class="flex items-center justify-between mb-3">
                    <span class="text-gray-500">Biaya Layanan</span>
                    <span class="font-medium text-green-600">Gratis</span>
                </div>
                <div class="h-px bg-gradient-to-r from-transparent via-gray-300 to-transparent my-4"></div>
                <div class="flex items-center justify-between">
                    <span class="text-xl font-bold text-gray-900">Total Pembayaran</span>
                    <span class="text-3xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
                        Rp <?php echo e(number_format($order->total, 0, ',', '.')); ?>

                    </span>
                </div>
            </div>

            
            <div class="px-8 py-6 text-center border-t border-gray-200">
                <?php if($order->status === 'pending'): ?>
                    <div class="inline-flex items-center space-x-3 px-6 py-4 bg-amber-50 rounded-2xl border border-amber-200">
                        <div class="w-12 h-12 bg-gradient-to-br from-amber-400 to-orange-400 rounded-xl flex items-center justify-center shadow-lg shadow-amber-200">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div class="text-left">
                            <p class="font-semibold text-amber-800">Menunggu Konfirmasi</p>
                            <p class="text-sm text-amber-600">Pesanan akan segera diproses oleh kantin</p>
                        </div>
                    </div>
                <?php elseif($order->status === 'diproses'): ?>
                    <div class="inline-flex items-center space-x-3 px-6 py-4 bg-blue-50 rounded-2xl border border-blue-200">
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-400 to-cyan-400 rounded-xl flex items-center justify-center shadow-lg shadow-blue-200">
                            <svg class="w-6 h-6 text-white animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                            </svg>
                        </div>
                        <div class="text-left">
                            <p class="font-semibold text-blue-800">Sedang Diproses</p>
                            <p class="text-sm text-blue-600">Pesanan sedang disiapkan, mohon tunggu</p>
                        </div>
                    </div>
                <?php elseif($order->status === 'selesai'): ?>
                    <div class="inline-flex items-center space-x-3 px-6 py-4 bg-emerald-50 rounded-2xl border border-emerald-200">
                        <div class="w-12 h-12 bg-gradient-to-br from-emerald-400 to-green-400 rounded-xl flex items-center justify-center shadow-lg shadow-emerald-200">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div class="text-left">
                            <p class="font-semibold text-emerald-800">Pesanan Selesai!</p>
                            <p class="text-sm text-emerald-600">Silakan ambil pesanan di kantin</p>
                        </div>
                    </div>
                <?php elseif($order->status === 'batal'): ?>
                    <div class="inline-flex items-center space-x-3 px-6 py-4 bg-red-50 rounded-2xl border border-red-200">
                        <div class="w-12 h-12 bg-gradient-to-br from-red-400 to-rose-400 rounded-xl flex items-center justify-center shadow-lg shadow-red-200">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div class="text-left">
                            <p class="font-semibold text-red-800">Pesanan Dibatalkan</p>
                            <p class="text-sm text-red-600">Pesanan ini telah dibatalkan</p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            
            <div class="px-8 py-8 bg-gradient-to-br from-white via-gray-50 to-indigo-50/30 border-t border-gray-100">
                <div class="flex flex-col sm:flex-row justify-center items-center gap-4">
                    <?php if($order->status === 'pending'): ?>
                        <form action="<?php echo e(route('siswa.orders.cancel', $order)); ?>" 
                              method="POST"
                              onsubmit="return confirm('Yakin ingin membatalkan pesanan ini?')">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PATCH'); ?>
                            <button type="submit" 
                                    class="group relative inline-flex items-center justify-center px-8 py-4 overflow-hidden rounded-2xl bg-gradient-to-br from-red-50 to-rose-50 border-2 border-red-100 transition-all duration-300 hover:border-red-300 hover:shadow-lg hover:shadow-red-100 hover:-translate-y-0.5">
                                <span class="absolute inset-0 bg-gradient-to-r from-red-500 to-rose-500 opacity-0 group-hover:opacity-10 transition-opacity duration-300"></span>
                                <span class="relative flex items-center space-x-2">
                                    <span class="w-8 h-8 rounded-xl bg-gradient-to-br from-red-400 to-rose-500 flex items-center justify-center shadow-md shadow-red-200 group-hover:shadow-lg group-hover:shadow-red-300 transition-all duration-300">
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </span>
                                    <span class="font-bold text-red-600 group-hover:text-red-700 transition-colors duration-300">Batalkan Pesanan</span>
                                </span>
                            </button>
                        </form>
                    <?php endif; ?>
                    
                    <a href="<?php echo e(route('siswa.menu')); ?>" 
                       class="group relative inline-flex items-center justify-center px-10 py-4 overflow-hidden rounded-2xl bg-gradient-to-r from-indigo-600 via-purple-600 to-indigo-600 bg-[length:200%_100%] text-white font-bold transition-all duration-500 hover:bg-[position:100%_0] hover:shadow-2xl hover:shadow-indigo-300 hover:-translate-y-1 active:translate-y-0">
                        
                        <span class="absolute inset-0 overflow-hidden rounded-2xl">
                            <span class="absolute -left-full top-0 h-full w-1/2 bg-gradient-to-r from-transparent via-white/20 to-transparent skew-x-12 group-hover:left-full transition-all duration-1000 ease-out"></span>
                        </span>
                        
                        <span class="absolute -inset-1 rounded-2xl bg-gradient-to-r from-indigo-600 to-purple-600 opacity-30 blur-lg group-hover:opacity-50 transition-opacity duration-300"></span>
                        <span class="relative flex items-center space-x-3">
                            <span class="w-9 h-9 rounded-xl bg-white/20 backdrop-blur-sm flex items-center justify-center border border-white/30 shadow-inner">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                </svg>
                            </span>
                            <span class="text-lg">Pesan Lagi</span>
                            <svg class="w-5 h-5 transform group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                            </svg>
                        </span>
                    </a>
                </div>
                
                
                <div class="mt-6 flex items-center justify-center">
                    <div class="flex items-center space-x-4 text-sm text-gray-400">
                        <a href="<?php echo e(route('siswa.orders.index')); ?>" class="flex items-center hover:text-indigo-600 transition-colors duration-200">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                            Lihat Riwayat
                        </a>
                        <span class="w-1 h-1 rounded-full bg-gray-300"></span>
                        <a href="<?php echo e(route('siswa.saldo.index')); ?>" class="flex items-center hover:text-indigo-600 transition-colors duration-200">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                            </svg>
                            Cek Saldo
                        </a>
                    </div>
                </div>
            </div>

            
            <div class="px-8 py-4 bg-gradient-to-r from-gray-50 to-indigo-50 border-t border-gray-100 text-center">
                <p class="text-xs text-gray-400">
                    Terima kasih telah memesan di <span class="font-semibold text-indigo-600">RasaPelajar</span>
                </p>
                <div class="flex items-center justify-center space-x-2 mt-2">
                    <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                    <span class="text-xs text-gray-500">Transaksi aman & terverifikasi</span>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\kantin-modern\resources\views/siswa/orders/show.blade.php ENDPATH**/ ?>