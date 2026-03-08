



<?php $__env->startSection('title', 'Laporan Penjualan'); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        
        <div class="bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-500 rounded-2xl shadow-xl p-6 mb-8 relative overflow-hidden">
            
            <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full -mr-32 -mt-32"></div>
            <div class="absolute bottom-0 left-0 w-48 h-48 bg-white/10 rounded-full -ml-24 -mb-24"></div>
            <div class="absolute top-1/2 right-1/4 w-20 h-20 bg-white/5 rounded-full"></div>

            <div class="relative flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center">
                        <i class="fas fa-chart-line text-3xl text-white"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl md:text-3xl font-bold text-white">Laporan Penjualan</h1>
                        <p class="text-white/80 mt-1">Analisis penjualan kantin sekolah</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <div class="bg-white/20 backdrop-blur-sm px-4 py-2 rounded-xl">
                        <div class="flex items-center gap-2 text-white">
                            <i class="fas fa-calendar-alt"></i>
                            <span class="text-sm">
                                <?php if(isset($startDate) && isset($endDate)): ?>
                                    <?php echo e(\Carbon\Carbon::parse($startDate)->format('d M')); ?> - <?php echo e(\Carbon\Carbon::parse($endDate)->format('d M Y')); ?>

                                <?php else: ?>
                                    Semua Waktu
                                <?php endif; ?>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-white/50 p-6 mb-8">
            <form action="<?php echo e(route('admin.reports.sales')); ?>" method="GET">
                <div class="flex flex-col md:flex-row gap-4 items-end">
                    <div class="flex-1 grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="flex items-center gap-2 text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-calendar text-indigo-500"></i>
                                Dari Tanggal
                            </label>
                            <input type="date" name="start_date" value="<?php echo e($startDate ?? ''); ?>"
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300">
                        </div>
                        <div>
                            <label class="flex items-center gap-2 text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-calendar-check text-indigo-500"></i>
                                Sampai Tanggal
                            </label>
                            <input type="date" name="end_date" value="<?php echo e($endDate ?? ''); ?>"
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300">
                        </div>
                    </div>
                    <div class="flex gap-3">
                        <button type="submit" class="px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl hover:from-indigo-700 hover:to-purple-700 shadow-lg shadow-indigo-200 hover:shadow-xl hover:-translate-y-0.5 transition-all duration-300 flex items-center gap-2 font-medium">
                            <i class="fas fa-filter"></i>
                            Filter
                        </button>
                        <a href="<?php echo e(route('admin.reports.sales')); ?>" class="px-6 py-3 bg-gray-100 text-gray-600 rounded-xl hover:bg-gray-200 transition-all duration-300 flex items-center gap-2 font-medium">
                            <i class="fas fa-undo"></i>
                            Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>

        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            
            <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-white/50 p-6 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-500 flex items-center gap-2">
                            <i class="fas fa-coins text-emerald-500"></i>
                            Total Pendapatan
                        </p>
                        <p class="text-2xl font-bold text-gray-900 mt-2">
                            Rp <?php echo e(number_format($totalRevenue ?? 0, 0, ',', '.')); ?>

                        </p>
                        <div class="mt-2 flex items-center gap-1">
                            <span class="text-xs px-2 py-1 bg-emerald-100 text-emerald-600 rounded-full">
                                <i class="fas fa-arrow-up mr-1"></i>Pendapatan Bersih
                            </span>
                        </div>
                    </div>
                    <div class="w-14 h-14 bg-gradient-to-br from-emerald-500 to-green-500 rounded-2xl flex items-center justify-center shadow-lg shadow-emerald-200 group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-money-bill-wave text-white text-xl"></i>
                    </div>
                </div>
            </div>

            
            <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-white/50 p-6 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-500 flex items-center gap-2">
                            <i class="fas fa-receipt text-blue-500"></i>
                            Total Pesanan
                        </p>
                        <p class="text-2xl font-bold text-gray-900 mt-2"><?php echo e($totalOrders ?? 0); ?></p>
                        <div class="mt-2 flex items-center gap-1">
                            <span class="text-xs px-2 py-1 bg-blue-100 text-blue-600 rounded-full">
                                <i class="fas fa-check-circle mr-1"></i>Selesai
                            </span>
                        </div>
                    </div>
                    <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-indigo-500 rounded-2xl flex items-center justify-center shadow-lg shadow-blue-200 group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-clipboard-list text-white text-xl"></i>
                    </div>
                </div>
            </div>

            
            <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-white/50 p-6 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-500 flex items-center gap-2">
                            <i class="fas fa-shopping-cart text-purple-500"></i>
                            Total Item Terjual
                        </p>
                        <p class="text-2xl font-bold text-gray-900 mt-2"><?php echo e($totalItemsSold ?? 0); ?></p>
                        <div class="mt-2 flex items-center gap-1">
                            <span class="text-xs px-2 py-1 bg-purple-100 text-purple-600 rounded-full">
                                <i class="fas fa-box mr-1"></i>Unit
                            </span>
                        </div>
                    </div>
                    <div class="w-14 h-14 bg-gradient-to-br from-purple-500 to-pink-500 rounded-2xl flex items-center justify-center shadow-lg shadow-purple-200 group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-shopping-basket text-white text-xl"></i>
                    </div>
                </div>
            </div>

            
            <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-white/50 p-6 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-500 flex items-center gap-2">
                            <i class="fas fa-chart-bar text-amber-500"></i>
                            Rata-rata Pesanan
                        </p>
                        <p class="text-2xl font-bold text-gray-900 mt-2">
                            Rp <?php echo e(number_format($averageOrderValue ?? 0, 0, ',', '.')); ?>

                        </p>
                        <div class="mt-2 flex items-center gap-1">
                            <span class="text-xs px-2 py-1 bg-amber-100 text-amber-600 rounded-full">
                                <i class="fas fa-calculator mr-1"></i>Per Order
                            </span>
                        </div>
                    </div>
                    <div class="w-14 h-14 bg-gradient-to-br from-amber-500 to-orange-500 rounded-2xl flex items-center justify-center shadow-lg shadow-amber-200 group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-chart-pie text-white text-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            
            <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-white/50 overflow-hidden">
                <div class="bg-gradient-to-r from-cyan-500 to-blue-500 p-5">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                                <i class="fas fa-calendar-day text-white"></i>
                            </div>
                            <div>
                                <h2 class="text-lg font-bold text-white">Penjualan Harian</h2>
                                <p class="text-white/70 text-sm">Pendapatan per hari</p>
                            </div>
                        </div>
                        <?php if(isset($dailySales) && count($dailySales) > 0): ?>
                            <span class="bg-white/20 px-3 py-1 rounded-full text-white text-sm">
                                <?php echo e(count($dailySales)); ?> hari
                            </span>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="p-6">
                    <?php if(isset($dailySales) && count($dailySales) > 0): ?>
                        <div class="space-y-4 max-h-80 overflow-y-auto">
                            <?php $__currentLoopData = $dailySales; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $sale): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="flex items-center justify-between p-4 rounded-xl hover:bg-cyan-50 transition-colors duration-300 group <?php echo e($index === 0 ? 'bg-gradient-to-r from-cyan-50 to-blue-50 border border-cyan-100' : ''); ?>">
                                    <div class="flex items-center gap-4">
                                        <div class="w-12 h-12 bg-gradient-to-br <?php echo e($index === 0 ? 'from-cyan-500 to-blue-500' : 'from-gray-100 to-gray-200'); ?> rounded-xl flex items-center justify-center shadow-md">
                                            <i class="fas fa-calendar <?php echo e($index === 0 ? 'text-white' : 'text-gray-500'); ?>"></i>
                                        </div>
                                        <div>
                                            <p class="font-semibold text-gray-900"><?php echo e(\Carbon\Carbon::parse($sale->date)->format('d M Y')); ?></p>
                                            <div class="flex items-center gap-2 mt-1">
                                                <span class="text-xs px-2 py-0.5 bg-blue-100 text-blue-600 rounded-full">
                                                    <i class="fas fa-receipt mr-1"></i><?php echo e($sale->total_orders); ?> pesanan
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-bold text-lg <?php echo e($index === 0 ? 'text-cyan-600' : 'text-gray-900'); ?>">
                                            Rp <?php echo e(number_format($sale->total_revenue, 0, ',', '.')); ?>

                                        </p>
                                        <?php if($index === 0): ?>
                                            <span class="text-xs text-cyan-500">
                                                <i class="fas fa-crown mr-1"></i>Tertinggi
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-12">
                            <div class="w-20 h-20 bg-gradient-to-br from-gray-100 to-gray-200 rounded-2xl flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-chart-area text-gray-400 text-3xl"></i>
                            </div>
                            <p class="text-gray-500 font-medium">Belum ada data penjualan</p>
                            <p class="text-gray-400 text-sm mt-1">Data akan muncul setelah ada transaksi</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            
            <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-white/50 overflow-hidden">
                <div class="bg-gradient-to-r from-amber-500 to-orange-500 p-5">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                                <i class="fas fa-trophy text-white"></i>
                            </div>
                            <div>
                                <h2 class="text-lg font-bold text-white">Produk Terlaris</h2>
                                <p class="text-white/70 text-sm">Ranking penjualan produk</p>
                            </div>
                        </div>
                        <?php if(isset($topProducts) && count($topProducts) > 0): ?>
                            <span class="bg-white/20 px-3 py-1 rounded-full text-white text-sm">
                                Top <?php echo e(count($topProducts)); ?>

                            </span>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="p-6">
                    <?php if(isset($topProducts) && count($topProducts) > 0): ?>
                        <div class="space-y-4">
                            <?php $__currentLoopData = $topProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $rankColors = [
                                        0 => ['bg' => 'from-yellow-400 to-amber-500', 'ring' => 'ring-yellow-200', 'icon' => 'fa-crown'],
                                        1 => ['bg' => 'from-gray-400 to-gray-500', 'ring' => 'ring-gray-200', 'icon' => 'fa-medal'],
                                        2 => ['bg' => 'from-amber-600 to-amber-700', 'ring' => 'ring-amber-200', 'icon' => 'fa-award'],
                                    ];
                                    $rankStyle = $rankColors[$index] ?? ['bg' => 'from-gray-300 to-gray-400', 'ring' => 'ring-gray-100', 'icon' => 'fa-hashtag'];
                                ?>
                                <div class="flex items-center gap-4 p-4 rounded-xl hover:bg-amber-50 transition-colors duration-300 <?php echo e($index < 3 ? 'border border-amber-100 bg-gradient-to-r from-amber-50/50 to-orange-50/50' : ''); ?>">
                                    <div class="w-12 h-12 bg-gradient-to-br <?php echo e($rankStyle['bg']); ?> rounded-xl flex items-center justify-center shadow-lg ring-4 <?php echo e($rankStyle['ring']); ?>">
                                        <?php if($index < 3): ?>
                                            <i class="fas <?php echo e($rankStyle['icon']); ?> text-white"></i>
                                        <?php else: ?>
                                            <span class="text-white font-bold"><?php echo e($index + 1); ?></span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="font-semibold text-gray-900 truncate"><?php echo e($product->nama); ?></p>
                                        <div class="flex items-center gap-2 mt-1">
                                            <span class="text-xs px-2 py-0.5 bg-orange-100 text-orange-600 rounded-full">
                                                <i class="fas fa-fire mr-1"></i><?php echo e($product->total_sold); ?> terjual
                                            </span>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-bold text-gray-900">Rp <?php echo e(number_format($product->total_revenue, 0, ',', '.')); ?></p>
                                        <p class="text-xs text-gray-500">Pendapatan</p>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-12">
                            <div class="w-20 h-20 bg-gradient-to-br from-gray-100 to-gray-200 rounded-2xl flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-utensils text-gray-400 text-3xl"></i>
                            </div>
                            <p class="text-gray-500 font-medium">Belum ada data produk terlaris</p>
                            <p class="text-gray-400 text-sm mt-1">Data akan muncul setelah ada transaksi</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        
        <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-white/50 overflow-hidden">
            <div class="bg-gradient-to-r from-violet-500 to-purple-500 p-5">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                            <i class="fas fa-th-large text-white"></i>
                        </div>
                        <div>
                            <h2 class="text-lg font-bold text-white">Penjualan per Kategori</h2>
                            <p class="text-white/70 text-sm">Performa penjualan tiap kategori</p>
                        </div>
                    </div>
                    <?php if(isset($categorySales) && count($categorySales) > 0): ?>
                        <span class="bg-white/20 px-3 py-1 rounded-full text-white text-sm">
                            <?php echo e(count($categorySales)); ?> kategori
                        </span>
                    <?php endif; ?>
                </div>
            </div>
            <div class="p-6">
                <?php if(isset($categorySales) && count($categorySales) > 0): ?>
                    <?php
                        $categoryIcons = [
                            'Makanan Berat' => ['icon' => 'fa-drumstick-bite', 'gradient' => 'from-orange-500 to-red-500', 'shadow' => 'shadow-orange-200'],
                            'Makanan Ringan' => ['icon' => 'fa-cookie-bite', 'gradient' => 'from-yellow-500 to-amber-500', 'shadow' => 'shadow-yellow-200'],
                            'Minuman' => ['icon' => 'fa-glass-water', 'gradient' => 'from-cyan-500 to-blue-500', 'shadow' => 'shadow-cyan-200'],
                            'Snack' => ['icon' => 'fa-bowl-food', 'gradient' => 'from-pink-500 to-rose-500', 'shadow' => 'shadow-pink-200'],
                        ];
                        $maxRevenue = $categorySales->max('total_revenue') ?: 1;
                    ?>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <?php $__currentLoopData = $categorySales; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $catStyle = $categoryIcons[$category->nama] ?? ['icon' => 'fa-tag', 'gradient' => 'from-gray-500 to-gray-600', 'shadow' => 'shadow-gray-200'];
                                $percentage = ($category->total_revenue / $maxRevenue) * 100;
                            ?>
                            <div class="bg-gradient-to-br from-white to-gray-50 rounded-2xl p-5 border border-gray-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
                                <div class="flex items-center gap-3 mb-4">
                                    <div class="w-12 h-12 bg-gradient-to-br <?php echo e($catStyle['gradient']); ?> rounded-xl flex items-center justify-center shadow-lg <?php echo e($catStyle['shadow']); ?> group-hover:scale-110 transition-transform duration-300">
                                        <i class="fas <?php echo e($catStyle['icon']); ?> text-white text-lg"></i>
                                    </div>
                                    <h3 class="font-bold text-gray-900"><?php echo e($category->nama); ?></h3>
                                </div>

                                
                                <div class="mb-4">
                                    <div class="h-2 bg-gray-100 rounded-full overflow-hidden">
                                        <div class="h-full bg-gradient-to-r <?php echo e($catStyle['gradient']); ?> rounded-full transition-all duration-500" style="width: <?php echo e($percentage); ?>%"></div>
                                    </div>
                                </div>

                                <div class="space-y-3">
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm text-gray-500 flex items-center gap-1">
                                            <i class="fas fa-box text-xs"></i>
                                            Total Terjual
                                        </span>
                                        <span class="font-bold text-gray-900 bg-gray-100 px-2 py-1 rounded-lg text-sm"><?php echo e($category->total_sold); ?></span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm text-gray-500 flex items-center gap-1">
                                            <i class="fas fa-coins text-xs"></i>
                                            Pendapatan
                                        </span>
                                        <span class="font-bold bg-gradient-to-r <?php echo e($catStyle['gradient']); ?> bg-clip-text text-transparent">
                                            Rp <?php echo e(number_format($category->total_revenue, 0, ',', '.')); ?>

                                        </span>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php else: ?>
                    <div class="text-center py-12">
                        <div class="w-20 h-20 bg-gradient-to-br from-gray-100 to-gray-200 rounded-2xl flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-folder-open text-gray-400 text-3xl"></i>
                        </div>
                        <p class="text-gray-500 font-medium">Belum ada data penjualan per kategori</p>
                        <p class="text-gray-400 text-sm mt-1">Data akan muncul setelah ada transaksi</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        
        <div class="mt-8 bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-white/50 p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                <i class="fas fa-bolt text-amber-500"></i>
                Aksi Cepat
            </h3>
            <div class="flex flex-wrap gap-3">
                <button onclick="window.print()" class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-gray-600 to-gray-700 text-white rounded-xl hover:from-gray-700 hover:to-gray-800 shadow-lg shadow-gray-200 hover:shadow-xl hover:-translate-y-0.5 transition-all duration-300">
                    <i class="fas fa-print"></i>
                    <span>Cetak Laporan</span>
                </button>
                <a href="<?php echo e(route('admin.orders.index')); ?>" class="inline-flex items-center gap-2 px-5 py-2.5 bg-white border-2 border-gray-200 text-gray-700 rounded-xl hover:border-indigo-300 hover:bg-indigo-50 hover:-translate-y-0.5 transition-all duration-300">
                    <i class="fas fa-clipboard-list"></i>
                    <span>Lihat Pesanan</span>
                </a>
                <a href="<?php echo e(route('admin.products.index')); ?>" class="inline-flex items-center gap-2 px-5 py-2.5 bg-white border-2 border-gray-200 text-gray-700 rounded-xl hover:border-purple-300 hover:bg-purple-50 hover:-translate-y-0.5 transition-all duration-300">
                    <i class="fas fa-utensils"></i>
                    <span>Kelola Produk</span>
                </a>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\kantin-modern\resources\views/admin/reports/sales.blade.php ENDPATH**/ ?>