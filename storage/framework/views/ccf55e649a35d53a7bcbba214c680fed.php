



<?php $__env->startSection('title', 'Dashboard Admin'); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="mb-10">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <h1 class="text-4xl font-extrabold bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-500 bg-clip-text text-transparent">
                        Dashboard
                    </h1>
                    <p class="mt-2 text-gray-500 text-lg">Selamat datang kembali, <span class="font-semibold text-gray-700"><?php echo e(auth()->user()->name); ?></span>! 👋</p>
                </div>
                <div class="mt-4 lg:mt-0 flex items-center space-x-3">
                    <div class="px-4 py-2 bg-white/80 backdrop-blur-sm rounded-xl shadow-sm border border-white/50 text-sm text-gray-600">
                        <i class="fas fa-calendar-alt mr-2 text-indigo-500"></i>
                        <?php echo e(\Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM Y')); ?>

                    </div>
                </div>
            </div>
        </div>

        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
            
            <div class="group relative bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-white/50 p-6 hover:shadow-2xl hover:-translate-y-1 transition-all duration-300 overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-emerald-400/20 to-green-500/20 rounded-full -mr-16 -mt-16 group-hover:scale-125 transition-transform duration-500"></div>
                <div class="relative flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 mb-1">Total Pendapatan</p>
                        <p class="text-3xl font-extrabold bg-gradient-to-r from-emerald-600 to-green-600 bg-clip-text text-transparent">
                            Rp <?php echo e(number_format($stats['total_pendapatan'] ?? 0, 0, ',', '.')); ?>

                        </p>
                        <p class="text-xs text-gray-400 mt-2 flex items-center">
                            <span class="w-2 h-2 bg-green-500 rounded-full mr-2 animate-pulse"></span>
                            Pesanan selesai
                        </p>
                    </div>
                    <div class="w-16 h-16 bg-gradient-to-br from-emerald-500 to-green-600 rounded-2xl flex items-center justify-center shadow-lg shadow-green-200 group-hover:scale-110 group-hover:rotate-6 transition-all duration-300">
                        <i class="fas fa-coins text-2xl text-white"></i>
                    </div>
                </div>
            </div>

            
            <div class="group relative bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-white/50 p-6 hover:shadow-2xl hover:-translate-y-1 transition-all duration-300 overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-blue-400/20 to-indigo-500/20 rounded-full -mr-16 -mt-16 group-hover:scale-125 transition-transform duration-500"></div>
                <div class="relative flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 mb-1">Pesanan Hari Ini</p>
                        <p class="text-3xl font-extrabold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">
                            <?php echo e($stats['pesanan_hari_ini'] ?? 0); ?>

                        </p>
                        <p class="text-xs text-gray-400 mt-2 flex items-center">
                            <span class="w-2 h-2 bg-blue-500 rounded-full mr-2 animate-pulse"></span>
                            Transaksi aktif
                        </p>
                    </div>
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl flex items-center justify-center shadow-lg shadow-blue-200 group-hover:scale-110 group-hover:rotate-6 transition-all duration-300">
                        <i class="fas fa-shopping-cart text-2xl text-white"></i>
                    </div>
                </div>
            </div>

            
            <div class="group relative bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-white/50 p-6 hover:shadow-2xl hover:-translate-y-1 transition-all duration-300 overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-purple-400/20 to-pink-500/20 rounded-full -mr-16 -mt-16 group-hover:scale-125 transition-transform duration-500"></div>
                <div class="relative flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 mb-1">Total Produk</p>
                        <p class="text-3xl font-extrabold bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">
                            <?php echo e($stats['total_produk'] ?? 0); ?>

                        </p>
                        <p class="text-xs text-gray-400 mt-2 flex items-center">
                            <span class="w-2 h-2 bg-purple-500 rounded-full mr-2"></span>
                            Menu tersedia
                        </p>
                    </div>
                    <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-pink-600 rounded-2xl flex items-center justify-center shadow-lg shadow-purple-200 group-hover:scale-110 group-hover:rotate-6 transition-all duration-300">
                        <i class="fas fa-utensils text-2xl text-white"></i>
                    </div>
                </div>
            </div>

            
            <div class="group relative bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-white/50 p-6 hover:shadow-2xl hover:-translate-y-1 transition-all duration-300 overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-amber-400/20 to-orange-500/20 rounded-full -mr-16 -mt-16 group-hover:scale-125 transition-transform duration-500"></div>
                <div class="relative flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 mb-1">Total Siswa</p>
                        <p class="text-3xl font-extrabold bg-gradient-to-r from-amber-600 to-orange-600 bg-clip-text text-transparent">
                            <?php echo e($stats['total_siswa'] ?? 0); ?>

                        </p>
                        <p class="text-xs text-gray-400 mt-2 flex items-center">
                            <span class="w-2 h-2 bg-amber-500 rounded-full mr-2"></span>
                            Pengguna terdaftar
                        </p>
                    </div>
                    <div class="w-16 h-16 bg-gradient-to-br from-amber-500 to-orange-600 rounded-2xl flex items-center justify-center shadow-lg shadow-amber-200 group-hover:scale-110 group-hover:rotate-6 transition-all duration-300">
                        <i class="fas fa-user-graduate text-2xl text-white"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-10">
            
            <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-white/50 overflow-hidden hover:shadow-xl transition-all duration-300">
                <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center mr-3">
                                <i class="fas fa-receipt text-white"></i>
                            </div>
                            <h2 class="text-lg font-bold text-white">Pesanan Terbaru</h2>
                        </div>
                        <a href="<?php echo e(route('admin.orders.index')); ?>" class="text-sm text-white/80 hover:text-white transition-colors flex items-center group">
                            Lihat Semua 
                            <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                        </a>
                    </div>
                </div>
                <div class="divide-y divide-gray-100">
                    <?php $__empty_1 = true; $__currentLoopData = $recentOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="p-5 hover:bg-indigo-50/50 transition-colors duration-200 group">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="w-12 h-12 bg-gradient-to-br from-indigo-100 to-purple-100 rounded-xl flex items-center justify-center mr-4 group-hover:scale-110 transition-transform">
                                        <i class="fas fa-file-invoice text-indigo-600"></i>
                                    </div>
                                    <div>
                                        <p class="font-bold text-gray-800 group-hover:text-indigo-600 transition-colors"><?php echo e($order->kode_pesanan); ?></p>
                                        <p class="text-sm text-gray-500 flex items-center">
                                            <i class="fas fa-user mr-1.5 text-xs"></i>
                                            <?php echo e($order->user->name); ?>

                                        </p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="font-bold text-gray-900">
                                        Rp <?php echo e(number_format($order->total, 0, ',', '.')); ?>

                                    </p>
                                    <?php
                                        $statusConfig = [
                                            'pending' => ['class' => 'bg-gradient-to-r from-amber-400 to-yellow-500', 'icon' => 'fa-clock'],
                                            'diproses' => ['class' => 'bg-gradient-to-r from-blue-400 to-indigo-500', 'icon' => 'fa-spinner'],
                                            'selesai' => ['class' => 'bg-gradient-to-r from-emerald-400 to-green-500', 'icon' => 'fa-check'],
                                            'batal' => ['class' => 'bg-gradient-to-r from-red-400 to-rose-500', 'icon' => 'fa-times'],
                                        ];
                                        $config = $statusConfig[$order->status] ?? ['class' => 'bg-gray-400', 'icon' => 'fa-question'];
                                    ?>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold text-white shadow-sm <?php echo e($config['class']); ?>">
                                        <i class="fas <?php echo e($config['icon']); ?> mr-1.5 text-[10px]"></i>
                                        <?php echo e(ucfirst($order->status)); ?>

                                    </span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="p-12 text-center">
                            <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-inbox text-4xl text-gray-300"></i>
                            </div>
                            <p class="text-gray-500 font-medium">Belum ada pesanan</p>
                            <p class="text-sm text-gray-400 mt-1">Pesanan baru akan muncul di sini</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            
            <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-white/50 overflow-hidden hover:shadow-xl transition-all duration-300">
                <div class="bg-gradient-to-r from-rose-500 to-orange-500 px-6 py-4">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center mr-3">
                            <i class="fas fa-exclamation-triangle text-white"></i>
                        </div>
                        <div>
                            <h2 class="text-lg font-bold text-white">Stok Menipis</h2>
                            <p class="text-xs text-white/70">Produk dengan stok &lt; 10</p>
                        </div>
                    </div>
                </div>
                <div class="divide-y divide-gray-100 max-h-[400px] overflow-y-auto">
                    <?php $__empty_1 = true; $__currentLoopData = $lowStockProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="p-5 hover:bg-rose-50/50 transition-colors duration-200 group">
                            <div class="flex items-center">
                                <div class="relative">
                                    <div class="w-14 h-14 rounded-xl flex items-center justify-center font-bold text-white shadow-lg
                                        <?php echo e($product->stok < 5 ? 'bg-gradient-to-br from-red-500 to-rose-600' : 'bg-gradient-to-br from-amber-500 to-orange-500'); ?> group-hover:scale-110 transition-transform">
                                        <?php echo e($product->stok); ?>

                                    </div>
                                    <?php if($product->stok < 5): ?>
                                        <span class="absolute -top-1 -right-1 w-4 h-4 bg-red-500 rounded-full animate-ping"></span>
                                        <span class="absolute -top-1 -right-1 w-4 h-4 bg-red-500 rounded-full"></span>
                                    <?php endif; ?>
                                </div>
                                <div class="ml-4 flex-1">
                                    <p class="font-bold text-gray-800 group-hover:text-rose-600 transition-colors"><?php echo e($product->nama); ?></p>
                                    <p class="text-sm text-gray-500 flex items-center">
                                        <i class="fas fa-tag mr-1.5 text-xs"></i>
                                        <?php echo e($product->category->nama ?? '-'); ?>

                                    </p>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-bold <?php echo e($product->stok < 5 ? 'text-red-600' : 'text-amber-600'); ?>">
                                        <i class="fas fa-box mr-1"></i>
                                        Sisa <?php echo e($product->stok); ?> pcs
                                    </p>
                                    <p class="text-sm text-gray-500">Rp <?php echo e(number_format($product->harga, 0, ',', '.')); ?></p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="p-12 text-center">
                            <div class="w-20 h-20 bg-gradient-to-br from-emerald-100 to-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-check-circle text-4xl text-emerald-500"></i>
                            </div>
                            <p class="text-gray-700 font-bold text-lg">Semua stok aman!</p>
                            <p class="text-sm text-gray-400 mt-1">Tidak ada produk dengan stok menipis</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        
        <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-white/50 p-8 hover:shadow-xl transition-all duration-300">
            <div class="flex items-center mb-6">
                <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center mr-4 shadow-lg shadow-indigo-200">
                    <i class="fas fa-bolt text-white text-xl"></i>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-800">Aksi Cepat</h2>
                    <p class="text-sm text-gray-500">Pintasan menu yang sering digunakan</p>
                </div>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <a href="<?php echo e(route('admin.products.create')); ?>" class="group relative flex flex-col items-center p-6 bg-gradient-to-br from-indigo-50 to-purple-50 rounded-2xl hover:from-indigo-100 hover:to-purple-100 transition-all duration-300 hover:-translate-y-1 hover:shadow-lg overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-r from-indigo-600 to-purple-600 opacity-0 group-hover:opacity-10 transition-opacity"></div>
                    <div class="w-14 h-14 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl flex items-center justify-center mb-3 shadow-lg shadow-indigo-200 group-hover:scale-110 group-hover:rotate-6 transition-all duration-300">
                        <i class="fas fa-plus text-white text-xl"></i>
                    </div>
                    <span class="font-bold text-gray-700 group-hover:text-indigo-700 transition-colors">Tambah Produk</span>
                    <span class="text-xs text-gray-400 mt-1">Menu baru</span>
                </a>
                <a href="<?php echo e(route('admin.categories.create')); ?>" class="group relative flex flex-col items-center p-6 bg-gradient-to-br from-emerald-50 to-green-50 rounded-2xl hover:from-emerald-100 hover:to-green-100 transition-all duration-300 hover:-translate-y-1 hover:shadow-lg overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-r from-emerald-600 to-green-600 opacity-0 group-hover:opacity-10 transition-opacity"></div>
                    <div class="w-14 h-14 bg-gradient-to-br from-emerald-500 to-green-600 rounded-2xl flex items-center justify-center mb-3 shadow-lg shadow-emerald-200 group-hover:scale-110 group-hover:rotate-6 transition-all duration-300">
                        <i class="fas fa-folder-plus text-white text-xl"></i>
                    </div>
                    <span class="font-bold text-gray-700 group-hover:text-emerald-700 transition-colors">Tambah Kategori</span>
                    <span class="text-xs text-gray-400 mt-1">Kelompok menu</span>
                </a>
                <a href="<?php echo e(route('admin.orders.index')); ?>" class="group relative flex flex-col items-center p-6 bg-gradient-to-br from-blue-50 to-cyan-50 rounded-2xl hover:from-blue-100 hover:to-cyan-100 transition-all duration-300 hover:-translate-y-1 hover:shadow-lg overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-r from-blue-600 to-cyan-600 opacity-0 group-hover:opacity-10 transition-opacity"></div>
                    <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-cyan-600 rounded-2xl flex items-center justify-center mb-3 shadow-lg shadow-blue-200 group-hover:scale-110 group-hover:rotate-6 transition-all duration-300">
                        <i class="fas fa-clipboard-list text-white text-xl"></i>
                    </div>
                    <span class="font-bold text-gray-700 group-hover:text-blue-700 transition-colors">Kelola Pesanan</span>
                    <span class="text-xs text-gray-400 mt-1">Lihat & proses</span>
                </a>
                <a href="<?php echo e(route('admin.reports.sales')); ?>" class="group relative flex flex-col items-center p-6 bg-gradient-to-br from-rose-50 to-pink-50 rounded-2xl hover:from-rose-100 hover:to-pink-100 transition-all duration-300 hover:-translate-y-1 hover:shadow-lg overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-r from-rose-600 to-pink-600 opacity-0 group-hover:opacity-10 transition-opacity"></div>
                    <div class="w-14 h-14 bg-gradient-to-br from-rose-500 to-pink-600 rounded-2xl flex items-center justify-center mb-3 shadow-lg shadow-rose-200 group-hover:scale-110 group-hover:rotate-6 transition-all duration-300">
                        <i class="fas fa-chart-line text-white text-xl"></i>
                    </div>
                    <span class="font-bold text-gray-700 group-hover:text-rose-700 transition-colors">Laporan Penjualan</span>
                    <span class="text-xs text-gray-400 mt-1">Analisis data</span>
                </a>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\kantin-modern\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>