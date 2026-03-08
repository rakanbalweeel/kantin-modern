



<?php $__env->startSection('title', 'Kelola Top Up Saldo'); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        
        <div class="bg-gradient-to-r from-emerald-600 via-teal-600 to-cyan-500 rounded-2xl shadow-xl p-6 mb-8 relative overflow-hidden">
            
            <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full -mr-32 -mt-32"></div>
            <div class="absolute bottom-0 left-0 w-48 h-48 bg-white/10 rounded-full -ml-24 -mb-24"></div>
            <div class="absolute top-1/2 right-1/4 w-20 h-20 bg-white/5 rounded-full"></div>
            
            <div class="relative flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center">
                        <i class="fas fa-wallet text-3xl text-white"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl md:text-3xl font-bold text-white">Kelola Top Up Saldo</h1>
                        <p class="text-white/80 mt-1">Setujui atau tolak permintaan top up dari siswa</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <?php
                        $pendingCount = \DB::table('topup_requests')->where('status', 'pending')->count();
                    ?>
                    <?php if($pendingCount > 0): ?>
                        <div class="bg-white/20 backdrop-blur-sm px-4 py-2 rounded-xl animate-pulse">
                            <div class="flex items-center gap-2 text-white">
                                <i class="fas fa-bell"></i>
                                <span class="font-bold"><?php echo e($pendingCount); ?> Menunggu</span>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        
        <?php if(session('success')): ?>
            <div class="mb-6 bg-gradient-to-r from-emerald-500 to-green-500 text-white px-6 py-4 rounded-2xl shadow-lg flex items-center">
                <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center mr-4">
                    <i class="fas fa-check-circle text-xl"></i>
                </div>
                <div>
                    <p class="font-semibold">Berhasil!</p>
                    <p class="text-white/90 text-sm"><?php echo e(session('success')); ?></p>
                </div>
            </div>
        <?php endif; ?>

        <?php if(session('error')): ?>
            <div class="mb-6 bg-gradient-to-r from-red-500 to-rose-500 text-white px-6 py-4 rounded-2xl shadow-lg flex items-center">
                <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center mr-4">
                    <i class="fas fa-exclamation-circle text-xl"></i>
                </div>
                <div>
                    <p class="font-semibold">Error!</p>
                    <p class="text-white/90 text-sm"><?php echo e(session('error')); ?></p>
                </div>
            </div>
        <?php endif; ?>

        
        <?php
            $approvedToday = \DB::table('topup_requests')
                ->where('status', 'approved')
                ->whereDate('approved_at', today())
                ->sum('jumlah');
            $totalApproved = \DB::table('topup_requests')
                ->where('status', 'approved')
                ->sum('jumlah');
            $rejectedCount = \DB::table('topup_requests')->where('status', 'rejected')->count();
        ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            
            <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-white/50 p-6 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-500 flex items-center gap-2">
                            <i class="fas fa-clock text-amber-500"></i>
                            Menunggu Persetujuan
                        </p>
                        <p class="text-3xl font-bold text-gray-900 mt-2"><?php echo e($pendingCount); ?></p>
                        <div class="mt-2">
                            <?php if($pendingCount > 0): ?>
                                <span class="text-xs px-2 py-1 bg-amber-100 text-amber-600 rounded-full animate-pulse">
                                    <i class="fas fa-exclamation-circle mr-1"></i>Perlu Tindakan
                                </span>
                            <?php else: ?>
                                <span class="text-xs px-2 py-1 bg-gray-100 text-gray-500 rounded-full">
                                    <i class="fas fa-check mr-1"></i>Semua diproses
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="w-14 h-14 bg-gradient-to-br from-amber-500 to-orange-500 rounded-2xl flex items-center justify-center shadow-lg shadow-amber-200 group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-hourglass-half text-white text-xl"></i>
                    </div>
                </div>
            </div>

            
            <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-white/50 p-6 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-500 flex items-center gap-2">
                            <i class="fas fa-calendar-day text-emerald-500"></i>
                            Disetujui Hari Ini
                        </p>
                        <p class="text-2xl font-bold text-gray-900 mt-2">Rp <?php echo e(number_format($approvedToday, 0, ',', '.')); ?></p>
                        <div class="mt-2">
                            <span class="text-xs px-2 py-1 bg-emerald-100 text-emerald-600 rounded-full">
                                <i class="fas fa-arrow-up mr-1"></i>Hari ini
                            </span>
                        </div>
                    </div>
                    <div class="w-14 h-14 bg-gradient-to-br from-emerald-500 to-green-500 rounded-2xl flex items-center justify-center shadow-lg shadow-emerald-200 group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-check-double text-white text-xl"></i>
                    </div>
                </div>
            </div>

            
            <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-white/50 p-6 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-500 flex items-center gap-2">
                            <i class="fas fa-coins text-cyan-500"></i>
                            Total Disetujui
                        </p>
                        <p class="text-2xl font-bold text-gray-900 mt-2">Rp <?php echo e(number_format($totalApproved, 0, ',', '.')); ?></p>
                        <div class="mt-2">
                            <span class="text-xs px-2 py-1 bg-cyan-100 text-cyan-600 rounded-full">
                                <i class="fas fa-chart-line mr-1"></i>Total keseluruhan
                            </span>
                        </div>
                    </div>
                    <div class="w-14 h-14 bg-gradient-to-br from-cyan-500 to-blue-500 rounded-2xl flex items-center justify-center shadow-lg shadow-cyan-200 group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-money-bill-wave text-white text-xl"></i>
                    </div>
                </div>
            </div>

            
            <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-white/50 p-6 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-500 flex items-center gap-2">
                            <i class="fas fa-user-graduate text-violet-500"></i>
                            Total Siswa
                        </p>
                        <p class="text-3xl font-bold text-gray-900 mt-2"><?php echo e(\App\Models\User::where('role', 'siswa')->count()); ?></p>
                        <div class="mt-2">
                            <span class="text-xs px-2 py-1 bg-violet-100 text-violet-600 rounded-full">
                                <i class="fas fa-users mr-1"></i>Terdaftar
                            </span>
                        </div>
                    </div>
                    <div class="w-14 h-14 bg-gradient-to-br from-violet-500 to-purple-500 rounded-2xl flex items-center justify-center shadow-lg shadow-violet-200 group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-users text-white text-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-white/50 overflow-hidden">
            
            <div class="bg-gradient-to-r from-emerald-600 to-teal-600 p-5">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                            <i class="fas fa-list-alt text-white"></i>
                        </div>
                        <div>
                            <h2 class="text-lg font-bold text-white">Daftar Request Top Up</h2>
                            <p class="text-white/70 text-sm">Kelola permintaan pengisian saldo</p>
                        </div>
                    </div>
                    <span class="bg-white/20 px-3 py-1 rounded-full text-white text-sm">
                        <?php echo e($requests->total()); ?> request
                    </span>
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gradient-to-r from-gray-50 to-gray-100">
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                                <i class="fas fa-user mr-2 text-gray-400"></i>Siswa
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                                <i class="fas fa-money-bill mr-2 text-gray-400"></i>Jumlah
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                                <i class="fas fa-calendar mr-2 text-gray-400"></i>Tanggal
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                                <i class="fas fa-info-circle mr-2 text-gray-400"></i>Status
                            </th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-600 uppercase tracking-wider">
                                <i class="fas fa-cog mr-2 text-gray-400"></i>Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <?php $__empty_1 = true; $__currentLoopData = $requests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $request): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="hover:bg-gradient-to-r hover:from-emerald-50/50 hover:to-teal-50/50 transition-all duration-300 group">
                                <td class="px-6 py-5">
                                    <div class="flex items-center">
                                        <div class="w-12 h-12 bg-gradient-to-br from-emerald-500 to-teal-500 rounded-xl flex items-center justify-center text-white font-bold shadow-lg shadow-emerald-200 group-hover:scale-105 transition-transform duration-300">
                                            <?php echo e(strtoupper(substr($request->name, 0, 1))); ?>

                                        </div>
                                        <div class="ml-4">
                                            <p class="font-bold text-gray-900"><?php echo e($request->name); ?></p>
                                            <p class="text-sm text-gray-500 flex items-center gap-1">
                                                <i class="fas fa-envelope text-xs"></i>
                                                <?php echo e($request->email); ?>

                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="flex items-center gap-2">
                                        <div class="w-8 h-8 bg-emerald-100 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-coins text-emerald-600 text-sm"></i>
                                        </div>
                                        <span class="text-xl font-bold text-gray-900">Rp <?php echo e(number_format($request->jumlah, 0, ',', '.')); ?></span>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 bg-gray-100 rounded-xl flex items-center justify-center">
                                            <i class="fas fa-calendar-alt text-gray-500"></i>
                                        </div>
                                        <div>
                                            <p class="font-semibold text-gray-900"><?php echo e(\Carbon\Carbon::parse($request->created_at)->format('d M Y')); ?></p>
                                            <p class="text-xs text-gray-500 flex items-center gap-1">
                                                <i class="fas fa-clock"></i>
                                                <?php echo e(\Carbon\Carbon::parse($request->created_at)->format('H:i')); ?> WIB
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <?php if($request->status === 'pending'): ?>
                                        <span class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-bold bg-gradient-to-r from-amber-100 to-yellow-100 text-amber-700 border border-amber-200">
                                            <i class="fas fa-clock animate-pulse"></i>Menunggu
                                        </span>
                                    <?php elseif($request->status === 'approved'): ?>
                                        <span class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-bold bg-gradient-to-r from-emerald-100 to-green-100 text-emerald-700 border border-emerald-200">
                                            <i class="fas fa-check-circle"></i>Disetujui
                                        </span>
                                    <?php else: ?>
                                        <span class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-bold bg-gradient-to-r from-red-100 to-rose-100 text-red-700 border border-red-200">
                                            <i class="fas fa-times-circle"></i>Ditolak
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-5 text-center">
                                    <?php if($request->status === 'pending'): ?>
                                        <div class="flex items-center justify-center gap-2">
                                            <form action="<?php echo e(route('admin.saldo.approve', $request->id)); ?>" method="POST" class="inline">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('PATCH'); ?>
                                                <button type="submit" 
                                                        onclick="return confirm('Setujui top up Rp <?php echo e(number_format($request->jumlah, 0, ',', '.')); ?> untuk <?php echo e($request->name); ?>?')"
                                                        class="inline-flex items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-emerald-500 to-green-500 text-white rounded-xl font-semibold shadow-lg shadow-emerald-200 hover:shadow-xl hover:-translate-y-0.5 transition-all duration-300">
                                                    <i class="fas fa-check"></i>
                                                    <span>Setujui</span>
                                                </button>
                                            </form>
                                            <form action="<?php echo e(route('admin.saldo.reject', $request->id)); ?>" method="POST" class="inline">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('PATCH'); ?>
                                                <button type="submit" 
                                                        onclick="return confirm('Tolak top up dari <?php echo e($request->name); ?>?')"
                                                        class="inline-flex items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-red-500 to-rose-500 text-white rounded-xl font-semibold shadow-lg shadow-red-200 hover:shadow-xl hover:-translate-y-0.5 transition-all duration-300">
                                                    <i class="fas fa-times"></i>
                                                    <span>Tolak</span>
                                                </button>
                                            </form>
                                        </div>
                                    <?php else: ?>
                                        <div class="flex items-center justify-center gap-2 text-gray-400">
                                            <i class="fas fa-check-double"></i>
                                            <span class="text-sm">Sudah diproses</span>
                                        </div>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="5" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center">
                                        <div class="w-24 h-24 bg-gradient-to-br from-gray-100 to-gray-200 rounded-2xl flex items-center justify-center mb-4">
                                            <i class="fas fa-inbox text-gray-400 text-4xl"></i>
                                        </div>
                                        <p class="text-xl font-bold text-gray-500 mb-1">Belum ada request</p>
                                        <p class="text-gray-400 text-sm">Request top up dari siswa akan muncul di sini</p>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            
            <?php if($requests->hasPages()): ?>
                <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
                    <?php echo e($requests->links()); ?>

                </div>
            <?php endif; ?>
        </div>

        
        <div class="mt-8 bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-white/50 p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                <i class="fas fa-info-circle text-emerald-500"></i>
                Informasi Saldo Siswa
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <?php
                    $topSiswa = \App\Models\User::where('role', 'siswa')
                        ->orderByDesc('saldo')
                        ->take(3)
                        ->get();
                ?>
                <?php $__empty_1 = true; $__currentLoopData = $topSiswa; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $siswa): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="flex items-center gap-4 p-4 rounded-xl bg-gradient-to-r from-emerald-50 to-teal-50 border border-emerald-100">
                        <div class="w-12 h-12 bg-gradient-to-br from-emerald-500 to-teal-500 rounded-xl flex items-center justify-center text-white font-bold shadow-lg">
                            <?php echo e(strtoupper(substr($siswa->name, 0, 1))); ?>

                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-bold text-gray-900 truncate"><?php echo e($siswa->name); ?></p>
                            <p class="text-sm text-gray-500">Saldo: <span class="font-semibold text-emerald-600">Rp <?php echo e(number_format($siswa->saldo, 0, ',', '.')); ?></span></p>
                        </div>
                        <?php if($index === 0): ?>
                            <div class="w-8 h-8 bg-amber-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-crown text-amber-500"></i>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="col-span-3 text-center py-8 text-gray-500">
                        <i class="fas fa-users text-4xl mb-2"></i>
                        <p>Belum ada siswa terdaftar</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\kantin-modern\resources\views/admin/saldo/index.blade.php ENDPATH**/ ?>