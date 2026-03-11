



<?php $__env->startSection('title', 'Saldo Virtual'); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen hero-gradient py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="mb-8 text-center">
            <div class="inline-flex items-center gap-2 glass rounded-full px-4 py-2 mb-4">
                <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                <span class="text-green-400 text-sm font-medium">Saldo Aktif</span>
            </div>
            <h1 class="text-3xl font-extrabold text-white">
                Saldo <span class="gradient-text">Virtual</span>
            </h1>
            <p class="mt-2 text-slate-400">Kelola saldo virtual kamu di sini</p>
        </div>

        
        <?php if(session('success')): ?>
            <div class="mb-6 glass-card border-l-4 border-emerald-500 text-emerald-400 px-4 py-3 rounded-xl flex items-center">
                <i class="fas fa-check-circle mr-3"></i>
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>

        <?php if(session('error')): ?>
            <div class="mb-6 glass-card border-l-4 border-red-500 text-red-400 px-4 py-3 rounded-xl flex items-center">
                <i class="fas fa-exclamation-circle mr-3"></i>
                <?php echo e(session('error')); ?>

            </div>
        <?php endif; ?>

        
        <div class="relative overflow-hidden bg-gradient-to-br from-orange-500 via-amber-500 to-yellow-500 rounded-3xl shadow-2xl shadow-orange-500/20 p-8 text-white mb-8"
             x-data="{ showTopup: false, topupAmount: '', topupPresets: [25000, 50000, 100000, 200000] }">
            
            <div class="absolute top-0 right-0 -mt-8 -mr-8 w-40 h-40 bg-white/10 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 left-0 -mb-8 -ml-8 w-48 h-48 bg-white/10 rounded-full blur-3xl"></div>
            
            <div class="relative flex flex-col md:flex-row md:items-center md:justify-between">
                <div class="flex items-center mb-6 md:mb-0">
                    <div class="w-16 h-16 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center mr-5 shadow-lg">
                        <i class="fas fa-wallet text-3xl"></i>
                    </div>
                    <div>
                        <p class="text-white/70 text-sm font-medium mb-1">Saldo Virtual Kamu</p>
                        <h2 class="text-4xl font-bold tracking-tight">Rp <?php echo e(number_format($user->saldo ?? 0, 0, ',', '.')); ?></h2>
                    </div>
                </div>
                <button @click="showTopup = !showTopup" 
                        class="px-6 py-3 bg-white/20 hover:bg-white/30 backdrop-blur-sm rounded-xl font-semibold transition-all duration-300 flex items-center justify-center group">
                    <i class="fas fa-plus-circle mr-2 group-hover:scale-110 transition-transform"></i>
                    Top Up Saldo
                </button>
            </div>

            
            <div x-show="showTopup" x-collapse class="mt-6 pt-6 border-t border-white/20">
                <form action="<?php echo e(route('siswa.saldo.topup')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <p class="text-white/80 text-sm mb-4">Pilih atau masukkan nominal top up:</p>
                    
                    
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-4">
                        <template x-for="preset in topupPresets" :key="preset">
                            <button type="button" 
                                    @click="topupAmount = preset"
                                    :class="topupAmount == preset ? 'bg-white text-orange-600' : 'bg-white/20 text-white hover:bg-white/30'"
                                    class="px-4 py-3 rounded-xl font-semibold transition-all duration-300 text-sm">
                                Rp <span x-text="new Intl.NumberFormat('id-ID').format(preset)"></span>
                            </button>
                        </template>
                    </div>

                    
                    <div class="relative mb-4">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-700 font-medium">Rp</span>
                        <input type="number" name="jumlah" x-model="topupAmount" 
                               placeholder="Nominal lainnya" min="10000" step="1000"
                               class="w-full pl-12 pr-4 py-3 bg-white border-2 border-orange-300 rounded-xl text-slate-800 placeholder-slate-400 focus:border-orange-500 focus:ring-2 focus:ring-orange-300 transition-all">
                    </div>

                    <button type="submit" 
                            :disabled="!topupAmount || topupAmount < 10000"
                            class="w-full py-4 bg-white text-orange-600 rounded-xl font-bold hover:bg-white/90 transition-all disabled:opacity-50 disabled:cursor-not-allowed">
                        <i class="fas fa-paper-plane mr-2"></i>
                        Ajukan Top Up
                    </button>
                </form>
            </div>
        </div>

        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div class="glass-card rounded-2xl p-6">
                <h3 class="font-bold text-white mb-4 flex items-center">
                    <div class="w-8 h-8 bg-blue-500/20 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-info-circle text-blue-400"></i>
                    </div>
                    Cara Top Up
                </h3>
                <ul class="space-y-3 text-sm text-slate-400">
                    <li class="flex items-start p-2 rounded-lg hover:bg-white/5 transition-colors">
                        <span class="w-6 h-6 bg-orange-500/20 rounded-full flex items-center justify-center mr-3 mt-0.5 flex-shrink-0 text-orange-400 text-xs font-bold">1</span>
                        <span>Ajukan permintaan top up dengan nominal yang diinginkan</span>
                    </li>
                    <li class="flex items-start p-2 rounded-lg hover:bg-white/5 transition-colors">
                        <span class="w-6 h-6 bg-orange-500/20 rounded-full flex items-center justify-center mr-3 mt-0.5 flex-shrink-0 text-orange-400 text-xs font-bold">2</span>
                        <span>Lakukan pembayaran ke admin/tata usaha</span>
                    </li>
                    <li class="flex items-start p-2 rounded-lg hover:bg-white/5 transition-colors">
                        <span class="w-6 h-6 bg-orange-500/20 rounded-full flex items-center justify-center mr-3 mt-0.5 flex-shrink-0 text-orange-400 text-xs font-bold">3</span>
                        <span>Admin akan memverifikasi dan saldo akan otomatis bertambah</span>
                    </li>
                </ul>
            </div>

            <div class="glass-card rounded-2xl p-6">
                <h3 class="font-bold text-white mb-4 flex items-center">
                    <div class="w-8 h-8 bg-emerald-500/20 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-shield-alt text-emerald-400"></i>
                    </div>
                    Keuntungan
                </h3>
                <ul class="space-y-3 text-sm text-slate-400">
                    <li class="flex items-start p-2 rounded-lg hover:bg-white/5 transition-colors">
                        <span class="w-5 h-5 bg-green-500/20 rounded-full flex items-center justify-center mr-3 mt-0.5 flex-shrink-0">
                            <i class="fas fa-check text-green-400 text-xs"></i>
                        </span>
                        <span>Transaksi lebih cepat tanpa uang tunai</span>
                    </li>
                    <li class="flex items-start p-2 rounded-lg hover:bg-white/5 transition-colors">
                        <span class="w-5 h-5 bg-green-500/20 rounded-full flex items-center justify-center mr-3 mt-0.5 flex-shrink-0">
                            <i class="fas fa-check text-green-400 text-xs"></i>
                        </span>
                        <span>Riwayat transaksi tercatat dengan jelas</span>
                    </li>
                    <li class="flex items-start p-2 rounded-lg hover:bg-white/5 transition-colors">
                        <span class="w-5 h-5 bg-green-500/20 rounded-full flex items-center justify-center mr-3 mt-0.5 flex-shrink-0">
                            <i class="fas fa-check text-green-400 text-xs"></i>
                        </span>
                        <span>Aman dan terpercaya</span>
                    </li>
                </ul>
            </div>
        </div>

        
        <div class="glass-card rounded-2xl overflow-hidden">
            <div class="bg-gradient-to-r from-orange-500 to-amber-500 px-6 py-4">
                <h3 class="font-bold text-white flex items-center">
                    <i class="fas fa-history mr-2"></i> Riwayat Permintaan Top Up
                </h3>
            </div>
            <div class="divide-y divide-slate-700/50">
                <?php $__empty_1 = true; $__currentLoopData = $riwayatTopup ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $request): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php
                        $statusConfig = [
                            'pending' => ['bg' => 'bg-yellow-500/20', 'text' => 'text-yellow-400', 'icon' => 'fa-clock'],
                            'approved' => ['bg' => 'bg-emerald-500/20', 'text' => 'text-emerald-400', 'icon' => 'fa-check-circle'],
                            'rejected' => ['bg' => 'bg-red-500/20', 'text' => 'text-red-400', 'icon' => 'fa-times-circle'],
                        ];
                        $config = $statusConfig[$request->status] ?? $statusConfig['pending'];
                    ?>
                    <div class="p-4 hover:bg-white/5 transition-colors">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-10 h-10 <?php echo e($config['bg']); ?> rounded-xl flex items-center justify-center mr-4">
                                    <i class="fas <?php echo e($config['icon']); ?> <?php echo e($config['text']); ?>"></i>
                                </div>
                                <div>
                                    <p class="font-bold text-orange-400">Rp <?php echo e(number_format($request->jumlah, 0, ',', '.')); ?></p>
                                    <p class="text-sm text-slate-500"><?php echo e(\Carbon\Carbon::parse($request->created_at)->locale('id')->isoFormat('D MMM Y, HH:mm')); ?></p>
                                </div>
                            </div>
                            <span class="px-3 py-1 <?php echo e($config['bg']); ?> <?php echo e($config['text']); ?> rounded-lg text-sm font-medium">
                                <?php echo e(ucfirst($request->status)); ?>

                            </span>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="p-8 text-center">
                        <div class="w-16 h-16 bg-slate-800 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-inbox text-2xl text-slate-600"></i>
                        </div>
                        <p class="text-slate-400">Belum ada permintaan top up</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\kantin-modern\resources\views/siswa/saldo/index.blade.php ENDPATH**/ ?>