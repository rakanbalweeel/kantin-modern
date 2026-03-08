



<?php $__env->startSection('title', 'Kelola Pesanan'); ?>

<?php $__env->startSection('content'); ?>
<?php
    $statusConfig = [
        'pending' => ['icon' => 'fa-clock', 'gradient' => 'from-amber-500 to-yellow-500', 'bg' => 'bg-amber-100', 'text' => 'text-amber-700', 'border' => 'border-amber-200'],
        'diproses' => ['icon' => 'fa-spinner', 'gradient' => 'from-blue-500 to-indigo-500', 'bg' => 'bg-blue-100', 'text' => 'text-blue-700', 'border' => 'border-blue-200'],
        'selesai' => ['icon' => 'fa-check-circle', 'gradient' => 'from-emerald-500 to-green-500', 'bg' => 'bg-emerald-100', 'text' => 'text-emerald-700', 'border' => 'border-emerald-200'],
        'batal' => ['icon' => 'fa-times-circle', 'gradient' => 'from-red-500 to-rose-500', 'bg' => 'bg-red-100', 'text' => 'text-red-700', 'border' => 'border-red-200'],
    ];
?>

<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="mb-8">
            <div class="flex items-center">
                <div class="w-14 h-14 bg-gradient-to-br from-indigo-600 to-purple-600 rounded-2xl flex items-center justify-center shadow-lg shadow-indigo-200 mr-4">
                    <i class="fas fa-clipboard-list text-white text-xl"></i>
                </div>
                <div>
                    <h1 class="text-3xl font-bold bg-gradient-to-r from-gray-800 to-gray-600 bg-clip-text text-transparent">Kelola Pesanan</h1>
                    <p class="text-gray-500 mt-1">Daftar semua pesanan dari siswa</p>
                </div>
            </div>
        </div>

        
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
            <?php $__currentLoopData = ['pending' => 'Pending', 'diproses' => 'Diproses', 'selesai' => 'Selesai', 'batal' => 'Dibatalkan']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php $config = $statusConfig[$key]; ?>
                <div class="bg-white/80 backdrop-blur-sm rounded-2xl p-5 shadow-lg border border-white/50 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm <?php echo e($config['text']); ?> font-medium mb-1"><?php echo e($label); ?></p>
                            <p class="text-3xl font-bold text-gray-800"><?php echo e($stats[$key] ?? 0); ?></p>
                        </div>
                        <div class="w-14 h-14 bg-gradient-to-br <?php echo e($config['gradient']); ?> rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                            <i class="fas <?php echo e($config['icon']); ?> text-white text-xl <?php echo e($key === 'diproses' ? 'animate-spin' : ''); ?>"></i>
                        </div>
                    </div>
                    
                    <div class="mt-3 h-1.5 bg-gray-100 rounded-full overflow-hidden">
                        <?php 
                            $total = array_sum($stats ?? []);
                            $percentage = $total > 0 ? (($stats[$key] ?? 0) / $total) * 100 : 0;
                        ?>
                        <div class="h-full bg-gradient-to-r <?php echo e($config['gradient']); ?> rounded-full transition-all duration-500" style="width: <?php echo e($percentage); ?>%"></div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        
        <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-white/50 p-6 mb-6">
            <form action="<?php echo e(route('admin.orders.index')); ?>" method="GET" class="flex flex-wrap gap-4 items-end">
                <div class="flex-1 min-w-[250px]">
                    <label class="text-sm font-medium text-gray-600 mb-2 block">Cari Pesanan</label>
                    <div class="relative">
                        <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <input type="text" name="search" value="<?php echo e(request('search')); ?>" 
                               placeholder="Kode pesanan atau nama siswa..."
                               class="w-full pl-11 pr-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 transition-all duration-200">
                    </div>
                </div>
                <div class="w-48">
                    <label class="text-sm font-medium text-gray-600 mb-2 block">Status</label>
                    <div class="relative">
                        <i class="fas fa-filter absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <select name="status" class="w-full pl-11 pr-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 transition-all duration-200 appearance-none cursor-pointer">
                            <option value="">Semua Status</option>
                            <option value="pending" <?php echo e(request('status') == 'pending' ? 'selected' : ''); ?>>Pending</option>
                            <option value="diproses" <?php echo e(request('status') == 'diproses' ? 'selected' : ''); ?>>Diproses</option>
                            <option value="selesai" <?php echo e(request('status') == 'selesai' ? 'selected' : ''); ?>>Selesai</option>
                            <option value="batal" <?php echo e(request('status') == 'batal' ? 'selected' : ''); ?>>Dibatalkan</option>
                        </select>
                    </div>
                </div>
                <div class="w-48">
                    <label class="text-sm font-medium text-gray-600 mb-2 block">Tanggal</label>
                    <div class="relative">
                        <i class="fas fa-calendar absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <input type="date" name="date" value="<?php echo e(request('date')); ?>"
                               class="w-full pl-11 pr-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 transition-all duration-200">
                    </div>
                </div>
                <button type="submit" class="px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold rounded-xl hover:from-indigo-700 hover:to-purple-700 shadow-md hover:shadow-lg transition-all duration-200 flex items-center">
                    <i class="fas fa-search mr-2"></i>
                    Cari
                </button>
                <?php if(request()->hasAny(['search', 'status', 'date'])): ?>
                    <a href="<?php echo e(route('admin.orders.index')); ?>" class="px-6 py-3 bg-gray-100 text-gray-600 font-medium rounded-xl hover:bg-gray-200 transition-all duration-200 flex items-center">
                        <i class="fas fa-times mr-2"></i>
                        Reset
                    </a>
                <?php endif; ?>
            </form>
        </div>

        
        <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-white/50 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="bg-gradient-to-r from-indigo-600 to-purple-600">
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                <i class="fas fa-receipt mr-2"></i>Pesanan
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                <i class="fas fa-user mr-2"></i>Siswa
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                <i class="fas fa-box mr-2"></i>Items
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                <i class="fas fa-money-bill mr-2"></i>Total
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                <i class="fas fa-info-circle mr-2"></i>Status
                            </th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-white uppercase tracking-wider">
                                <i class="fas fa-cog mr-2"></i>Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <?php $config = $statusConfig[$order->status] ?? $statusConfig['pending']; ?>
                            <tr class="hover:bg-indigo-50/50 transition-colors duration-200">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-gradient-to-br <?php echo e($config['gradient']); ?> rounded-xl flex items-center justify-center mr-3 shadow-md">
                                            <i class="fas fa-shopping-bag text-white text-sm"></i>
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-indigo-600"><?php echo e($order->kode_pesanan); ?></p>
                                            <p class="text-xs text-gray-500 flex items-center mt-0.5">
                                                <i class="fas fa-clock mr-1"></i>
                                                <?php echo e($order->created_at->format('d M Y H:i')); ?>

                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-gradient-to-br from-gray-600 to-gray-700 rounded-full flex items-center justify-center mr-3 shadow-md">
                                            <span class="text-white font-bold text-sm"><?php echo e(substr($order->user->name, 0, 1)); ?></span>
                                        </div>
                                        <div>
                                            <p class="text-sm font-semibold text-gray-800"><?php echo e($order->user->name); ?></p>
                                            <p class="text-xs text-gray-500"><?php echo e($order->user->email); ?></p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-center">
                                        <p class="text-lg font-bold text-gray-800"><?php echo e($order->orderDetails->count()); ?></p>
                                        <p class="text-xs text-gray-500"><?php echo e($order->orderDetails->sum('jumlah')); ?> qty</p>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-lg font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
                                        Rp <?php echo e(number_format($order->total, 0, ',', '.')); ?>

                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold <?php echo e($config['bg']); ?> <?php echo e($config['text']); ?> <?php echo e($config['border']); ?> border">
                                        <i class="fas <?php echo e($config['icon']); ?> mr-1.5 <?php echo e($order->status === 'diproses' ? 'animate-spin' : ''); ?>"></i>
                                        <?php echo e(ucfirst($order->status)); ?>

                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <a href="<?php echo e(route('admin.orders.show', $order)); ?>" 
                                       class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-indigo-500 to-purple-500 text-white text-sm font-semibold rounded-lg hover:from-indigo-600 hover:to-purple-600 shadow-md hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200">
                                        <i class="fas fa-eye mr-2"></i>
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="6" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center">
                                        <div class="w-20 h-20 bg-gradient-to-br from-gray-200 to-gray-300 rounded-full flex items-center justify-center mb-4">
                                            <i class="fas fa-clipboard-list text-gray-400 text-3xl"></i>
                                        </div>
                                        <p class="text-lg font-semibold text-gray-600 mb-2">Belum Ada Pesanan</p>
                                        <p class="text-gray-400">Pesanan dari siswa akan muncul di sini</p>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            
            <?php if($orders->hasPages()): ?>
                <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50">
                    <?php echo e($orders->withQueryString()->links()); ?>

                </div>
            <?php endif; ?>
        </div>

        
        <div class="mt-8 bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-white/50 p-6">
            <div class="flex items-center justify-between flex-wrap gap-4">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-gradient-to-br from-emerald-500 to-green-600 rounded-xl flex items-center justify-center mr-4 shadow-lg">
                        <i class="fas fa-chart-pie text-white"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Total Pesanan Hari Ini</p>
                        <p class="text-2xl font-bold text-gray-800"><?php echo e($orders->where('created_at', '>=', now()->startOfDay())->count()); ?> pesanan</p>
                    </div>
                </div>
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-gradient-to-br from-amber-500 to-orange-600 rounded-xl flex items-center justify-center mr-4 shadow-lg">
                        <i class="fas fa-hourglass-half text-white"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Menunggu Diproses</p>
                        <p class="text-2xl font-bold text-amber-600"><?php echo e($stats['pending'] ?? 0); ?> pesanan</p>
                    </div>
                </div>
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center mr-4 shadow-lg">
                        <i class="fas fa-money-bill-wave text-white"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Total Pendapatan</p>
                        <p class="text-2xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
                            Rp <?php echo e(number_format($orders->where('status', 'selesai')->sum('total'), 0, ',', '.')); ?>

                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\kantin-modern\resources\views/admin/orders/index.blade.php ENDPATH**/ ?>