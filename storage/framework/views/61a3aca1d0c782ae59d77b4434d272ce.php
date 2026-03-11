



<?php $__env->startSection('title', 'Pengaturan Sistem'); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen hero-gradient py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="mb-10">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <h1 class="text-4xl font-extrabold text-white">
                        Pengaturan <span class="gradient-text">Sistem</span>
                    </h1>
                    <p class="mt-2 text-slate-400 text-lg">Kelola konfigurasi sistem kantin</p>
                </div>
                <a href="<?php echo e(route('admin.dashboard')); ?>" class="mt-4 lg:mt-0 inline-flex items-center px-4 py-2 glass rounded-xl text-slate-300 hover:text-orange-400 transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali ke Dashboard
                </a>
            </div>
        </div>

        
        <?php if(session('success')): ?>
        <div class="mb-6 glass bg-emerald-500/10 border-emerald-500/30 text-emerald-400 px-6 py-4 rounded-2xl flex items-center">
            <i class="fas fa-check-circle mr-3 text-xl"></i>
            <span class="font-medium"><?php echo e(session('success')); ?></span>
        </div>
        <?php endif; ?>
        <?php if($errors->any()): ?>
        <div class="mb-6 glass bg-red-500/10 border-red-500/30 text-red-400 px-6 py-4 rounded-2xl">
            <div class="flex items-center mb-2">
                <i class="fas fa-exclamation-circle mr-3 text-xl"></i>
                <span class="font-semibold">Terjadi kesalahan:</span>
            </div>
            <ul class="list-disc list-inside ml-8">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
        <?php endif; ?>

        <form action="<?php echo e(route('admin.settings.pajak')); ?>" method="POST" x-data="{ 
            selectedPajak: <?php echo e($pajak_persen); ?>, 
            selectedPajakWithdrawal: <?php echo e($pajak_withdrawal); ?>,
            loading: false 
        }" @submit="loading = true">
            <?php echo csrf_field(); ?>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                
                <div class="glass-card rounded-2xl p-6">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-amber-500 to-orange-600 rounded-xl flex items-center justify-center shadow-lg shadow-amber-500/20 mr-3">
                            <i class="fas fa-shopping-cart text-xl text-white"></i>
                        </div>
                        <div>
                            <h2 class="text-lg font-bold text-white">Pajak Transaksi</h2>
                            <p class="text-sm text-slate-400">Pajak untuk setiap pesanan</p>
                        </div>
                    </div>

                    <div class="mb-4 p-4 bg-amber-500/10 rounded-xl border border-amber-500/30">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs text-slate-400 mb-1">Pajak Saat Ini</p>
                                <p class="text-3xl font-extrabold text-amber-400"><?php echo e(number_format($pajak_persen, 1)); ?>%</p>
                            </div>
                            <div class="text-right text-sm">
                                <p class="text-slate-500">Contoh: Rp 100.000</p>
                                <p class="text-amber-400">Pajak: Rp <?php echo e(number_format(100000 * $pajak_persen / 100, 0, ',', '.')); ?></p>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-3">Pilih Persentase Baru</label>
                        <input type="range" name="pajak_persen" min="0" max="20" step="0.5" x-model="selectedPajak" 
                               class="w-full h-2 bg-slate-700 rounded-lg appearance-none cursor-pointer accent-orange-500">
                        <div class="flex justify-between text-sm text-slate-500 mt-2">
                            <span>0%</span>
                            <span class="text-orange-400 font-bold" x-text="selectedPajak + '%'"></span>
                            <span>20%</span>
                        </div>
                    </div>
                </div>

                
                <div class="glass-card rounded-2xl p-6">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-pink-600 rounded-xl flex items-center justify-center shadow-lg shadow-purple-500/20 mr-3">
                            <i class="fas fa-hand-holding-usd text-xl text-white"></i>
                        </div>
                        <div>
                            <h2 class="text-lg font-bold text-white">Pajak Penarikan</h2>
                            <p class="text-sm text-slate-400">Pajak untuk penarikan kantin</p>
                        </div>
                    </div>

                    <div class="mb-4 p-4 bg-purple-500/10 rounded-xl border border-purple-500/30">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs text-slate-400 mb-1">Pajak Saat Ini</p>
                                <p class="text-3xl font-extrabold text-purple-400"><?php echo e(number_format($pajak_withdrawal, 1)); ?>%</p>
                            </div>
                            <div class="text-right text-sm">
                                <p class="text-slate-500">Contoh: Rp 100.000</p>
                                <p class="text-purple-400">Pajak: Rp <?php echo e(number_format(100000 * $pajak_withdrawal / 100, 0, ',', '.')); ?></p>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-3">Pilih Persentase Baru</label>
                        <input type="range" name="pajak_withdrawal" min="0" max="20" step="0.5" x-model="selectedPajakWithdrawal" 
                               class="w-full h-2 bg-slate-700 rounded-lg appearance-none cursor-pointer accent-purple-500">
                        <div class="flex justify-between text-sm text-slate-500 mt-2">
                            <span>0%</span>
                            <span class="text-purple-400 font-bold" x-text="selectedPajakWithdrawal + '%'"></span>
                            <span>20%</span>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="mt-6 flex justify-end">
                <button type="submit" :disabled="loading" 
                        class="btn-glow px-8 py-4 bg-gradient-to-r from-orange-500 to-amber-500 text-white font-bold rounded-xl shadow-lg shadow-orange-500/30 hover:shadow-orange-500/50 hover:-translate-y-0.5 transition-all disabled:opacity-50 flex items-center">
                    <template x-if="loading">
                        <svg class="animate-spin h-5 w-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </template>
                    <i class="fas fa-save mr-2" x-show="!loading"></i>
                    <span x-text="loading ? 'Menyimpan...' : 'Simpan Pengaturan'"></span>
                </button>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\kantin-modern\resources\views/admin/settings/index.blade.php ENDPATH**/ ?>