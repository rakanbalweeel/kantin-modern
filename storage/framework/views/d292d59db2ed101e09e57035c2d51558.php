



<?php $__env->startSection('title', 'Detail Pesanan - Kantin'); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen hero-gradient py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <?php if(session('success')): ?>
            <div class="mb-6 glass bg-emerald-500/10 border-emerald-500/30 text-emerald-400 px-6 py-4 rounded-2xl flex items-center" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)">
                <div class="w-10 h-10 bg-emerald-500/20 rounded-xl flex items-center justify-center mr-4">
                    <i class="fas fa-check-circle text-emerald-400 text-xl"></i>
                </div>
                <span class="font-medium flex-1"><?php echo e(session('success')); ?></span>
                <button @click="show = false" class="text-emerald-400 hover:text-emerald-300">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        <?php endif; ?>

        
        <?php if(session('error')): ?>
            <div class="mb-6 glass bg-red-500/10 border-red-500/30 text-red-400 px-6 py-4 rounded-2xl flex items-center" x-data="{ show: true }" x-show="show">
                <div class="w-10 h-10 bg-red-500/20 rounded-xl flex items-center justify-center mr-4">
                    <i class="fas fa-exclamation-circle text-red-400 text-xl"></i>
                </div>
                <span class="font-medium flex-1"><?php echo e(session('error')); ?></span>
                <button @click="show = false" class="text-red-400 hover:text-red-300">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        <?php endif; ?>

        
        <div class="mb-8">
            <a href="<?php echo e(route('kantin.orders.index')); ?>" class="inline-flex items-center text-slate-400 hover:text-orange-400 transition-colors mb-4">
                <i class="fas fa-arrow-left mr-2"></i> Kembali ke Daftar Pesanan
            </a>
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div>
                    <h1 class="text-3xl font-extrabold text-white">
                        Detail <span class="gradient-text">Pesanan</span>
                    </h1>
                    <p class="mt-1 text-slate-400 font-mono"><?php echo e($order->kode_pesanan); ?></p>
                </div>
                
                <?php
                    $statusConfig = [
                        'pending' => ['bg' => 'bg-yellow-500/20', 'text' => 'text-yellow-400', 'border' => 'border-yellow-500/30'],
                        'diproses' => ['bg' => 'bg-blue-500/20', 'text' => 'text-blue-400', 'border' => 'border-blue-500/30'],
                        'selesai' => ['bg' => 'bg-emerald-500/20', 'text' => 'text-emerald-400', 'border' => 'border-emerald-500/30'],
                        'batal' => ['bg' => 'bg-red-500/20', 'text' => 'text-red-400', 'border' => 'border-red-500/30'],
                    ];
                    $config = $statusConfig[$order->status] ?? $statusConfig['pending'];
                ?>
                <span class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-bold <?php echo e($config['bg']); ?> <?php echo e($config['text']); ?> border <?php echo e($config['border']); ?> mt-4 md:mt-0">
                    <i class="fas fa-circle text-xs mr-2"></i>
                    <?php echo e(ucfirst($order->status)); ?>

                </span>
            </div>
        </div>

        
        <?php if(in_array($order->status, ['pending', 'diproses'])): ?>
            <div class="glass-card rounded-2xl p-6 mb-8" x-data="{ showCancelModal: false, loading: false }">
                <h3 class="font-bold text-white mb-4">
                    <i class="fas fa-tasks mr-2 text-orange-400"></i> Aksi Pesanan
                </h3>
                
                <div class="flex flex-wrap gap-4">
                    <?php if($order->status === 'pending'): ?>
                        <form action="<?php echo e(route('kantin.orders.accept', $order)); ?>" method="POST" x-data="{ submitting: false }" @submit="submitting = true">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PATCH'); ?>
                            <button type="submit" :disabled="submitting" class="px-6 py-3 bg-gradient-to-r from-green-500 to-emerald-600 text-white rounded-xl font-semibold shadow-lg shadow-emerald-500/20 hover:shadow-emerald-500/40 transition-all flex items-center disabled:opacity-50">
                                <template x-if="submitting">
                                    <svg class="animate-spin h-5 w-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                </template>
                                <i class="fas fa-check mr-2" x-show="!submitting"></i> 
                                <span x-text="submitting ? 'Memproses...' : 'Terima Pesanan'"></span>
                            </button>
                        </form>
                    <?php endif; ?>
                    
                    <?php if($order->status === 'diproses'): ?>
                        <form action="<?php echo e(route('kantin.orders.complete', $order)); ?>" method="POST" x-data="{ submitting: false }" @submit="submitting = true">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PATCH'); ?>
                            <button type="submit" :disabled="submitting" class="px-6 py-3 bg-gradient-to-r from-emerald-500 to-green-600 text-white rounded-xl font-semibold shadow-lg shadow-emerald-500/20 hover:shadow-emerald-500/40 transition-all flex items-center disabled:opacity-50">
                                <template x-if="submitting">
                                    <svg class="animate-spin h-5 w-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                </template>
                                <i class="fas fa-check-double mr-2" x-show="!submitting"></i> 
                                <span x-text="submitting ? 'Memproses...' : 'Selesaikan Pesanan'"></span>
                            </button>
                        </form>
                    <?php endif; ?>
                    
                    <button @click="showCancelModal = true" type="button" class="px-6 py-3 bg-red-500/20 text-red-400 border border-red-500/30 rounded-xl font-semibold hover:bg-red-500/30 transition-all flex items-center">
                        <i class="fas fa-times mr-2"></i> Batalkan Pesanan
                    </button>
                </div>
                
                <div class="mt-4 p-3 bg-orange-500/10 border border-orange-500/30 rounded-xl text-sm text-orange-400">
                    <i class="fas fa-info-circle mr-1"></i>
                    <strong>Catatan:</strong> Status tidak dapat dikembalikan ke status sebelumnya setelah diubah.
                </div>

                
                <div x-show="showCancelModal" 
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/70 backdrop-blur-sm" 
                     @click.self="showCancelModal = false"
                     x-cloak>
                    <div class="glass-card rounded-2xl max-w-md w-full p-6" 
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 scale-90"
                         x-transition:enter-end="opacity-100 scale-100">
                        <div class="text-center mb-6">
                            <div class="w-16 h-16 bg-red-500/20 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-exclamation-triangle text-red-400 text-2xl"></i>
                            </div>
                            <h3 class="text-xl font-bold text-white mb-2">Batalkan Pesanan?</h3>
                            <p class="text-slate-400">Pesanan <strong class="text-white"><?php echo e($order->kode_pesanan); ?></strong> akan dibatalkan dan stok produk akan dikembalikan.</p>
                        </div>
                        <div class="flex gap-3">
                            <button @click="showCancelModal = false" class="flex-1 px-4 py-3 bg-slate-700 text-slate-300 rounded-xl font-semibold hover:bg-slate-600 transition-all">
                                Kembali
                            </button>
                            <form action="<?php echo e(route('kantin.orders.cancel', $order)); ?>" method="POST" class="flex-1" x-data="{ submitting: false }" @submit="submitting = true">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('PATCH'); ?>
                                <button type="submit" :disabled="submitting" class="w-full px-4 py-3 bg-red-500 text-white rounded-xl font-semibold hover:bg-red-600 transition-all disabled:opacity-50 flex items-center justify-center">
                                    <template x-if="submitting">
                                        <svg class="animate-spin h-5 w-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                    </template>
                                    <span x-text="submitting ? 'Membatalkan...' : 'Ya, Batalkan'"></span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            
            <div class="glass-card rounded-2xl p-6">
                <h3 class="font-bold text-white mb-4 flex items-center">
                    <div class="w-8 h-8 bg-blue-500/20 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-user text-blue-400"></i>
                    </div>
                    Informasi Pembeli
                </h3>
                <div class="space-y-3">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-gradient-to-br from-orange-500 to-amber-500 rounded-xl flex items-center justify-center mr-4">
                            <span class="text-white font-bold text-lg"><?php echo e(strtoupper(substr($order->user->name, 0, 1))); ?></span>
                        </div>
                        <div>
                            <p class="font-semibold text-white"><?php echo e($order->user->name); ?></p>
                            <p class="text-sm text-slate-400"><?php echo e($order->user->email); ?></p>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="glass-card rounded-2xl p-6">
                <h3 class="font-bold text-white mb-4 flex items-center">
                    <div class="w-8 h-8 bg-purple-500/20 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-clock text-purple-400"></i>
                    </div>
                    Informasi Waktu
                </h3>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-slate-400">Tanggal Pesan</span>
                        <span class="text-white font-medium"><?php echo e($order->created_at->locale('id')->isoFormat('D MMM Y')); ?></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-400">Waktu Pesan</span>
                        <span class="text-white font-medium"><?php echo e($order->created_at->format('H:i')); ?> WIB</span>
                    </div>
                    <div class="pt-3 mt-3 border-t border-slate-700">
                        <div class="flex justify-between items-center">
                            <span class="text-slate-400">Waktu Pengambilan</span>
                            <span class="px-3 py-1 rounded-full text-sm font-bold 
                                <?php echo e($order->waktu_pengambilan === 'istirahat_1' ? 'bg-blue-500/20 text-blue-400 border border-blue-500/30' : 'bg-purple-500/20 text-purple-400 border border-purple-500/30'); ?>">
                                <i class="fas fa-clock mr-1"></i>
                                <?php echo e($order->waktu_pengambilan_label); ?>

                            </span>
                        </div>
                    </div>
                    <?php if($order->updated_at != $order->created_at): ?>
                        <div class="flex justify-between">
                            <span class="text-slate-400">Terakhir Update</span>
                            <span class="text-white font-medium"><?php echo e($order->updated_at->locale('id')->isoFormat('D MMM Y, HH:mm')); ?></span>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        
        <div class="glass-card rounded-2xl overflow-hidden mb-8">
            <div class="bg-gradient-to-r from-orange-500 to-amber-500 px-6 py-4">
                <h3 class="font-bold text-white flex items-center">
                    <i class="fas fa-shopping-basket mr-2"></i> Detail Pesanan
                </h3>
            </div>
            <div class="divide-y divide-slate-700/50">
                <?php $__currentLoopData = $order->orderDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="p-6 flex items-center justify-between hover:bg-white/5 transition-colors">
                        <div class="flex items-center">
                            <?php if($detail->product && $detail->product->gambar): ?>
                                <img src="<?php echo e(asset('storage/' . $detail->product->gambar)); ?>" alt="<?php echo e($detail->product->nama); ?>" class="w-16 h-16 rounded-xl object-cover mr-4 border border-slate-700">
                            <?php else: ?>
                                <div class="w-16 h-16 bg-slate-800 rounded-xl flex items-center justify-center mr-4">
                                    <i class="fas fa-utensils text-slate-600 text-xl"></i>
                                </div>
                            <?php endif; ?>
                            <div>
                                <p class="font-semibold text-white"><?php echo e($detail->product->nama ?? 'Produk tidak tersedia'); ?></p>
                                <p class="text-sm text-slate-400">Rp <?php echo e(number_format($detail->harga, 0, ',', '.')); ?> x <?php echo e($detail->jumlah); ?></p>
                            </div>
                        </div>
                        <p class="font-bold text-orange-400">Rp <?php echo e(number_format($detail->subtotal, 0, ',', '.')); ?></p>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            
            
            <div class="bg-slate-800/50 p-6 border-t border-slate-700">
                <div class="space-y-2">
                    <div class="flex justify-between text-sm">
                        <span class="text-slate-400">Subtotal</span>
                        <span class="text-white">Rp <?php echo e(number_format($order->subtotal, 0, ',', '.')); ?></span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-slate-400">Pajak (<?php echo e($order->pajak_persen ?? 0); ?>%)</span>
                        <span class="text-white">Rp <?php echo e(number_format($order->pajak ?? 0, 0, ',', '.')); ?></span>
                    </div>
                    <div class="flex justify-between pt-2 border-t border-slate-700">
                        <span class="font-bold text-white text-lg">Total</span>
                        <span class="font-bold text-orange-400 text-lg">Rp <?php echo e(number_format($order->total, 0, ',', '.')); ?></span>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="glass-card rounded-2xl p-6">
            <h3 class="font-bold text-white mb-6 flex items-center">
                <div class="w-8 h-8 bg-emerald-500/20 rounded-lg flex items-center justify-center mr-3">
                    <i class="fas fa-history text-emerald-400"></i>
                </div>
                Timeline Status
            </h3>
            <div class="relative">
                <div class="absolute left-4 top-0 bottom-0 w-0.5 bg-slate-700"></div>
                <div class="space-y-6">
                    <div class="relative flex items-start pl-10">
                        <div class="absolute left-0 w-8 h-8 bg-emerald-500 rounded-full flex items-center justify-center">
                            <i class="fas fa-check text-white text-sm"></i>
                        </div>
                        <div>
                            <p class="font-medium text-white">Pesanan Dibuat</p>
                            <p class="text-sm text-slate-400"><?php echo e($order->created_at->locale('id')->isoFormat('D MMM Y, HH:mm')); ?></p>
                        </div>
                    </div>
                    
                    <?php if(in_array($order->status, ['diproses', 'selesai'])): ?>
                        <div class="relative flex items-start pl-10">
                            <div class="absolute left-0 w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center">
                                <i class="fas fa-cog text-white text-sm"></i>
                            </div>
                            <div>
                                <p class="font-medium text-white">Sedang Diproses</p>
                                <p class="text-sm text-slate-400">Pesanan sedang disiapkan</p>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <?php if($order->status === 'selesai'): ?>
                        <div class="relative flex items-start pl-10">
                            <div class="absolute left-0 w-8 h-8 bg-emerald-500 rounded-full flex items-center justify-center">
                                <i class="fas fa-check-double text-white text-sm"></i>
                            </div>
                            <div>
                                <p class="font-medium text-white">Pesanan Selesai</p>
                                <p class="text-sm text-slate-400"><?php echo e($order->updated_at->locale('id')->isoFormat('D MMM Y, HH:mm')); ?></p>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <?php if($order->status === 'batal'): ?>
                        <div class="relative flex items-start pl-10">
                            <div class="absolute left-0 w-8 h-8 bg-red-500 rounded-full flex items-center justify-center">
                                <i class="fas fa-times text-white text-sm"></i>
                            </div>
                            <div>
                                <p class="font-medium text-white">Pesanan Dibatalkan</p>
                                <p class="text-sm text-slate-400"><?php echo e($order->updated_at->locale('id')->isoFormat('D MMM Y, HH:mm')); ?></p>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\kantin-modern\resources\views/kantin/orders/show.blade.php ENDPATH**/ ?>