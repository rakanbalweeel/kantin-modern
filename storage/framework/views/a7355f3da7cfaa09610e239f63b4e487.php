<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', 'RasaPelajar'); ?> - Sistem Informasi Kantin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>[x-cloak] { display: none !important; }</style>
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body class="bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 min-h-screen flex flex-col">
    <!-- Navigation Modern -->
    <nav class="bg-white/80 backdrop-blur-lg shadow-lg sticky top-0 z-50 border-b border-white/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="<?php echo e(route('landing')); ?>" class="flex items-center space-x-2 group">
                        <span class="text-2xl group-hover:scale-110 transition-transform duration-300">🍽️</span>
                        <span class="text-xl font-extrabold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">RasaPelajar</span>
                    </a>
                </div>
                
                <div class="hidden md:flex items-center space-x-4">
                    <?php if(auth()->guard()->check()): ?>
                        <?php if(auth()->user()->isAdmin()): ?>
                            <a href="<?php echo e(route('admin.dashboard')); ?>" class="px-3 py-2 text-gray-600 hover:text-indigo-600 <?php echo e(request()->routeIs('admin.dashboard') ? 'text-indigo-600 font-semibold' : ''); ?>">
                                <i class="fas fa-chart-line mr-1"></i> Dashboard
                            </a>
                            <a href="<?php echo e(route('admin.categories.index')); ?>" class="px-3 py-2 text-gray-600 hover:text-indigo-600 <?php echo e(request()->routeIs('admin.categories.*') ? 'text-indigo-600 font-semibold' : ''); ?>">
                                <i class="fas fa-tags mr-1"></i> Kategori
                            </a>
                            <a href="<?php echo e(route('admin.products.index')); ?>" class="px-3 py-2 text-gray-600 hover:text-indigo-600 <?php echo e(request()->routeIs('admin.products.*') ? 'text-indigo-600 font-semibold' : ''); ?>">
                                <i class="fas fa-utensils mr-1"></i> Produk
                            </a>
                            <a href="<?php echo e(route('admin.orders.index')); ?>" class="px-3 py-2 text-gray-600 hover:text-indigo-600 <?php echo e(request()->routeIs('admin.orders.*') ? 'text-indigo-600 font-semibold' : ''); ?>">
                                <i class="fas fa-shopping-cart mr-1"></i> Pesanan
                            </a>
                            <a href="<?php echo e(route('admin.reports.sales')); ?>" class="px-3 py-2 text-gray-600 hover:text-indigo-600 <?php echo e(request()->routeIs('admin.reports.*') ? 'text-indigo-600 font-semibold' : ''); ?>">
                                <i class="fas fa-chart-bar mr-1"></i> Laporan
                            </a>
                            <a href="<?php echo e(route('admin.saldo.index')); ?>" class="px-3 py-2 text-gray-600 hover:text-indigo-600 <?php echo e(request()->routeIs('admin.saldo.*') ? 'text-indigo-600 font-semibold' : ''); ?>">
                                <i class="fas fa-wallet mr-1"></i> Top Up
                            </a>
                        <?php else: ?>
                            <a href="<?php echo e(route('siswa.menu')); ?>" class="px-4 py-2 rounded-xl text-gray-600 hover:text-indigo-600 hover:bg-indigo-50 transition-all duration-300 <?php echo e(request()->routeIs('siswa.menu') ? 'text-indigo-600 font-semibold bg-indigo-50' : ''); ?>">
                                <i class="fas fa-utensils mr-1"></i> Menu
                            </a>
                            
                            <a href="<?php echo e(route('siswa.orders.index')); ?>" class="px-4 py-2 rounded-xl text-gray-600 hover:text-indigo-600 hover:bg-indigo-50 transition-all duration-300 <?php echo e(request()->routeIs('siswa.orders.*') ? 'text-indigo-600 font-semibold bg-indigo-50' : ''); ?>">
                                <i class="fas fa-history mr-1"></i> Riwayat
                            </a>
                            <a href="<?php echo e(route('siswa.saldo.index')); ?>" class="px-4 py-2 rounded-xl text-gray-600 hover:text-indigo-600 hover:bg-indigo-50 transition-all duration-300 <?php echo e(request()->routeIs('siswa.saldo.*') ? 'text-indigo-600 font-semibold bg-indigo-50' : ''); ?>">
                                <i class="fas fa-wallet mr-1"></i> Saldo
                            </a>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
                
                <div class="flex items-center">
                    <?php if(auth()->guard()->check()): ?>
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center space-x-3 px-3 py-2 rounded-xl text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition-all duration-300">
                                <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg shadow-indigo-200">
                                    <span class="text-white font-bold"><?php echo e(strtoupper(substr(auth()->user()->name, 0, 1))); ?></span>
                                </div>
                                <span class="hidden md:block font-medium"><?php echo e(auth()->user()->name); ?></span>
                                <i class="fas fa-chevron-down text-xs transition-transform duration-300" :class="{'rotate-180': open}"></i>
                            </button>
                            <div x-show="open" 
                                 @click.away="open = false" 
                                 x-cloak 
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 scale-95"
                                 x-transition:enter-end="opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-150"
                                 x-transition:leave-start="opacity-100 scale-100"
                                 x-transition:leave-end="opacity-0 scale-95"
                                 class="absolute right-0 mt-2 w-64 bg-white/95 backdrop-blur-lg rounded-2xl shadow-2xl overflow-hidden z-50 border border-white/50">
                                <div class="p-4 bg-gradient-to-r from-indigo-600 to-purple-600 text-white">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                                            <span class="text-xl font-bold"><?php echo e(strtoupper(substr(auth()->user()->name, 0, 1))); ?></span>
                                        </div>
                                        <div>
                                            <p class="font-bold"><?php echo e(auth()->user()->name); ?></p>
                                            <p class="text-xs text-white/70"><?php echo e(auth()->user()->email); ?></p>
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <span class="inline-flex items-center px-3 py-1 text-xs font-bold rounded-full <?php echo e(auth()->user()->isAdmin() ? 'bg-red-500/30 text-red-100' : 'bg-green-500/30 text-green-100'); ?>">
                                            <i class="fas <?php echo e(auth()->user()->isAdmin() ? 'fa-shield-alt' : 'fa-user-graduate'); ?> mr-1.5"></i>
                                            <?php echo e(auth()->user()->isAdmin() ? 'Administrator' : 'Siswa'); ?>

                                        </span>
                                    </div>
                                </div>
                                <div class="p-3">
                                    <form action="<?php echo e(route('logout')); ?>" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="w-full flex items-center justify-center px-4 py-3 text-red-600 bg-red-50 hover:bg-red-100 rounded-xl font-semibold transition-all duration-300">
                                            <i class="fas fa-sign-out-alt mr-2"></i> Keluar
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <a href="<?php echo e(route('login')); ?>" class="px-5 py-2.5 text-gray-600 hover:text-indigo-600 font-medium transition-colors">Login</a>
                        <a href="<?php echo e(route('register')); ?>" class="ml-2 px-5 py-2.5 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl font-semibold hover:shadow-lg hover:shadow-indigo-300 transform hover:-translate-y-0.5 transition-all duration-300">Daftar</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <!-- Flash Messages Modern -->
    <?php if(session('success')): ?>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
            <div class="bg-gradient-to-r from-green-500 to-emerald-500 text-white px-6 py-4 rounded-2xl shadow-lg shadow-green-200 flex items-center justify-between" 
                 x-data="{ show: true }" 
                 x-show="show" 
                 x-init="setTimeout(() => show = false, 5000)"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 transform -translate-y-2"
                 x-transition:enter-end="opacity-100 transform translate-y-0"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0">
                <div class="flex items-center">
                    <span class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center mr-4">
                        <i class="fas fa-check-circle text-xl"></i>
                    </span>
                    <span class="font-semibold"><?php echo e(session('success')); ?></span>
                </div>
                <button @click="show = false" class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center hover:bg-white/30 transition-colors">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
            <div class="bg-gradient-to-r from-red-500 to-pink-500 text-white px-6 py-4 rounded-2xl shadow-lg shadow-red-200 flex items-center">
                <span class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center mr-4">
                    <i class="fas fa-exclamation-circle text-xl"></i>
                </span>
                <span class="font-semibold"><?php echo e(session('error')); ?></span>
            </div>
        </div>
    <?php endif; ?>

    <?php if($errors->any()): ?>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
            <div class="bg-gradient-to-r from-red-500 to-pink-500 text-white px-6 py-4 rounded-2xl shadow-lg shadow-red-200">
                <div class="flex items-start">
                    <span class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center mr-4 flex-shrink-0">
                        <i class="fas fa-exclamation-triangle text-xl"></i>
                    </span>
                    <ul class="list-disc list-inside font-medium">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Main Content -->
    <main class="flex-grow max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full">
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <!-- Footer Modern -->
    <footer class="bg-white/80 backdrop-blur-lg border-t border-white/50 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex flex-col md:flex-row items-center justify-between">
                <div class="flex items-center space-x-2 mb-4 md:mb-0">
                    <span class="text-2xl">🍽️</span>
                    <span class="font-extrabold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">RasaPelajar</span>
                </div>
                <p class="text-gray-500 text-sm">
                    &copy; <?php echo e(date('Y')); ?> RasaPelajar. Sistem Informasi Kantin Sekolah.
                </p>
            </div>
        </div>
    </footer>

    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\laragon\www\kantin-modern\resources\views/layouts/app.blade.php ENDPATH**/ ?>