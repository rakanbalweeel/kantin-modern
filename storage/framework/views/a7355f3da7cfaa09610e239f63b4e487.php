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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                    },
                }
            }
        }
    </script>
    <style>
        [x-cloak] { display: none !important; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        
        .hero-gradient {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #0f172a 100%);
            position: relative;
        }
        
        .glass {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .glass-card {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }
        
        .gradient-text {
            background: linear-gradient(135deg, #f97316 0%, #fb923c 50%, #fbbf24 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .grid-pattern {
            background-image: 
                linear-gradient(rgba(255,255,255,0.02) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.02) 1px, transparent 1px);
            background-size: 50px 50px;
        }
        
        .nav-link {
            position: relative;
            transition: all 0.3s ease;
        }
        
        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 50%;
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, #f97316, #fbbf24);
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }
        
        .nav-link:hover::after,
        .nav-link.active::after {
            width: 100%;
        }
        
        .btn-glow {
            position: relative;
            overflow: hidden;
        }
        
        .btn-glow::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s ease;
        }
        
        .btn-glow:hover::before {
            left: 100%;
        }
        
        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: #1e293b;
        }
        
        ::-webkit-scrollbar-thumb {
            background: linear-gradient(180deg, #f97316, #fbbf24);
            border-radius: 4px;
        }
        
        /* Print Styles */
        @media print {
            body {
                background: white !important;
                color: black !important;
            }
            nav, .print\\:hidden {
                display: none !important;
            }
            .shadow-lg, .shadow-xl, .shadow-2xl {
                box-shadow: none !important;
            }
            .bg-gradient-to-r, .bg-gradient-to-br {
                background: #f3f4f6 !important;
            }
            .text-transparent {
                -webkit-text-fill-color: #1f2937 !important;
            }
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(180deg, #ea580c, #f59e0b);
        }
    </style>
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body class="bg-slate-950 text-white min-h-screen flex flex-col grid-pattern">
    <!-- Navigation Modern Dark -->
    <nav class="bg-slate-900/95 backdrop-blur-md sticky top-0 z-50 border-b border-white/10 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="<?php echo e(route('landing')); ?>" class="flex items-center space-x-3 group">
                        <div class="w-10 h-10 bg-gradient-to-br from-orange-500 to-amber-500 rounded-xl flex items-center justify-center shadow-lg shadow-orange-500/30 group-hover:scale-110 transition-transform duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                        <span class="text-xl font-bold text-white">Rasa<span class="text-orange-500">Pelajar</span></span>
                    </a>
                </div>
                
                <div class="hidden md:flex items-center space-x-1">
                    <?php if(auth()->guard()->check()): ?>
                        <?php if(auth()->user()->isAdmin()): ?>
                            <a href="<?php echo e(route('admin.dashboard')); ?>" class="nav-link px-4 py-2 text-slate-300 hover:text-white rounded-lg <?php echo e(request()->routeIs('admin.dashboard') ? 'active text-white' : ''); ?>">
                                <i class="fas fa-chart-line mr-2"></i>Dashboard
                            </a>
                            <a href="<?php echo e(route('admin.categories.index')); ?>" class="nav-link px-4 py-2 text-slate-300 hover:text-white rounded-lg <?php echo e(request()->routeIs('admin.categories.*') ? 'active text-white' : ''); ?>">
                                <i class="fas fa-tags mr-2"></i>Kategori
                            </a>
                            <a href="<?php echo e(route('admin.products.index')); ?>" class="nav-link px-4 py-2 text-slate-300 hover:text-white rounded-lg <?php echo e(request()->routeIs('admin.products.*') ? 'active text-white' : ''); ?>">
                                <i class="fas fa-utensils mr-2"></i>Produk
                            </a>
                            <a href="<?php echo e(route('admin.orders.index')); ?>" class="nav-link px-4 py-2 text-slate-300 hover:text-white rounded-lg <?php echo e(request()->routeIs('admin.orders.*') ? 'active text-white' : ''); ?>">
                                <i class="fas fa-shopping-cart mr-2"></i>Pesanan
                            </a>
                            <a href="<?php echo e(route('admin.reports.sales')); ?>" class="nav-link px-4 py-2 text-slate-300 hover:text-white rounded-lg <?php echo e(request()->routeIs('admin.reports.*') ? 'active text-white' : ''); ?>">
                                <i class="fas fa-chart-bar mr-2"></i>Laporan
                            </a>
                            <a href="<?php echo e(route('admin.saldo.index')); ?>" class="nav-link px-4 py-2 text-slate-300 hover:text-white rounded-lg <?php echo e(request()->routeIs('admin.saldo.*') ? 'active text-white' : ''); ?>">
                                <i class="fas fa-wallet mr-2"></i>Top Up
                            </a>
                            <a href="<?php echo e(route('admin.withdrawals.index')); ?>" class="nav-link px-4 py-2 text-slate-300 hover:text-white rounded-lg <?php echo e(request()->routeIs('admin.withdrawals.*') ? 'active text-white' : ''); ?>">
                                <i class="fas fa-hand-holding-usd mr-2"></i>Penarikan
                            </a>
                            <a href="<?php echo e(route('admin.settings.index')); ?>" class="nav-link px-4 py-2 text-slate-300 hover:text-white rounded-lg <?php echo e(request()->routeIs('admin.settings.*') ? 'active text-white' : ''); ?>">
                                <i class="fas fa-cog mr-2"></i>Setting
                            </a>
                        <?php elseif(auth()->user()->isKantin()): ?>
                            <a href="<?php echo e(route('kantin.dashboard')); ?>" class="nav-link px-4 py-2 text-slate-300 hover:text-white rounded-lg <?php echo e(request()->routeIs('kantin.dashboard') ? 'active text-white' : ''); ?>">
                                <i class="fas fa-home mr-2"></i>Dashboard
                            </a>
                            <a href="<?php echo e(route('kantin.orders.index')); ?>" class="nav-link px-4 py-2 text-slate-300 hover:text-white rounded-lg <?php echo e(request()->routeIs('kantin.orders.*') ? 'active text-white' : ''); ?>">
                                <i class="fas fa-clipboard-list mr-2"></i>Pesanan
                            </a>
                            <a href="<?php echo e(route('kantin.reports')); ?>" class="nav-link px-4 py-2 text-slate-300 hover:text-white rounded-lg <?php echo e(request()->routeIs('kantin.reports') ? 'active text-white' : ''); ?>">
                                <i class="fas fa-chart-line mr-2"></i>Laporan
                            </a>
                            <a href="<?php echo e(route('kantin.withdrawals.index')); ?>" class="nav-link px-4 py-2 text-slate-300 hover:text-white rounded-lg <?php echo e(request()->routeIs('kantin.withdrawals.*') ? 'active text-white' : ''); ?>">
                                <i class="fas fa-money-bill-wave mr-2"></i>Penarikan
                            </a>
                        <?php else: ?>
                            <a href="<?php echo e(route('siswa.menu')); ?>" class="nav-link px-4 py-2 text-slate-300 hover:text-white rounded-lg <?php echo e(request()->routeIs('siswa.menu') ? 'active text-white' : ''); ?>">
                                <i class="fas fa-utensils mr-2"></i>Menu
                            </a>
                            <a href="<?php echo e(route('siswa.orders.index')); ?>" class="nav-link px-4 py-2 text-slate-300 hover:text-white rounded-lg <?php echo e(request()->routeIs('siswa.orders.*') ? 'active text-white' : ''); ?>">
                                <i class="fas fa-history mr-2"></i>Riwayat
                            </a>
                            <a href="<?php echo e(route('siswa.saldo.index')); ?>" class="nav-link px-4 py-2 text-slate-300 hover:text-white rounded-lg <?php echo e(request()->routeIs('siswa.saldo.*') ? 'active text-white' : ''); ?>">
                                <i class="fas fa-wallet mr-2"></i>Saldo
                            </a>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
                
                <div class="flex items-center space-x-4">
                    <?php if(auth()->guard()->check()): ?>
                        
                        <?php if(auth()->user()->isSiswa()): ?>
                            <a href="<?php echo e(route('siswa.cart')); ?>" class="relative p-2 text-slate-300 hover:text-orange-400 transition-colors" x-data="{ count: 0 }" x-init="
                                count = JSON.parse(localStorage.getItem('kantin_cart') || '[]').reduce((t, i) => t + i.qty, 0);
                                window.addEventListener('cart-updated', () => {
                                    count = JSON.parse(localStorage.getItem('kantin_cart') || '[]').reduce((t, i) => t + i.qty, 0);
                                })
                            ">
                                <i class="fas fa-shopping-cart text-xl"></i>
                                <span x-show="count > 0" x-text="count" class="absolute -top-1 -right-1 w-5 h-5 bg-gradient-to-r from-orange-500 to-amber-500 text-white text-xs font-bold rounded-full flex items-center justify-center"></span>
                            </a>
                        <?php endif; ?>
                        
                        
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center space-x-3 glass px-3 py-2 rounded-xl hover:bg-white/10 transition-all duration-300">
                                <div class="w-9 h-9 bg-gradient-to-br from-orange-500 to-amber-500 rounded-lg flex items-center justify-center shadow-lg shadow-orange-500/20">
                                    <span class="text-white font-bold text-sm"><?php echo e(strtoupper(substr(auth()->user()->name, 0, 1))); ?></span>
                                </div>
                                <span class="hidden md:block font-medium text-white text-sm"><?php echo e(auth()->user()->name); ?></span>
                                <i class="fas fa-chevron-down text-xs text-slate-400 transition-transform duration-300" :class="{'rotate-180': open}"></i>
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
                                 class="absolute right-0 mt-2 w-72 glass-card rounded-2xl shadow-2xl overflow-hidden z-50">
                                <div class="p-4 bg-gradient-to-r from-orange-500 to-amber-500">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center">
                                            <span class="text-xl font-bold text-white"><?php echo e(strtoupper(substr(auth()->user()->name, 0, 1))); ?></span>
                                        </div>
                                        <div>
                                            <p class="font-bold text-white"><?php echo e(auth()->user()->name); ?></p>
                                            <p class="text-xs text-white/70"><?php echo e(auth()->user()->email); ?></p>
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <?php
                                            $roleConfig = [
                                                'admin' => ['bg' => 'bg-red-500/30', 'text' => 'text-red-100', 'icon' => 'fa-shield-alt', 'label' => 'Administrator'],
                                                'kantin' => ['bg' => 'bg-orange-900/50', 'text' => 'text-orange-100', 'icon' => 'fa-store', 'label' => 'Penjaga Kantin'],
                                                'siswa' => ['bg' => 'bg-green-500/30', 'text' => 'text-green-100', 'icon' => 'fa-user-graduate', 'label' => 'Siswa'],
                                            ];
                                            $config = $roleConfig[auth()->user()->role] ?? $roleConfig['siswa'];
                                        ?>
                                        <span class="inline-flex items-center px-3 py-1 text-xs font-bold rounded-full <?php echo e($config['bg']); ?> <?php echo e($config['text']); ?>">
                                            <i class="fas <?php echo e($config['icon']); ?> mr-1.5"></i>
                                            <?php echo e($config['label']); ?>

                                        </span>
                                    </div>
                                </div>
                                
                                <?php if(auth()->user()->isSiswa()): ?>
                                    <div class="p-4 border-b border-white/10">
                                        <div class="flex items-center justify-between">
                                            <span class="text-slate-400 text-sm">Saldo</span>
                                            <span class="font-bold text-white">Rp <?php echo e(number_format(auth()->user()->saldo ?? 0, 0, ',', '.')); ?></span>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                
                                <div class="p-3">
                                    <form action="<?php echo e(route('logout')); ?>" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="w-full flex items-center justify-center px-4 py-3 glass text-red-400 hover:bg-red-500/20 rounded-xl font-semibold transition-all duration-300">
                                            <i class="fas fa-sign-out-alt mr-2"></i> Keluar
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <a href="<?php echo e(route('login')); ?>" class="px-4 py-2 text-slate-300 hover:text-white font-medium transition-colors">Login</a>
                        <a href="<?php echo e(route('register')); ?>" class="btn-glow px-5 py-2.5 bg-gradient-to-r from-orange-500 to-amber-500 text-white rounded-xl font-semibold shadow-lg shadow-orange-500/30 hover:shadow-orange-500/50 transition-all duration-300">Daftar</a>
                    <?php endif; ?>
                    
                    
                    <button class="md:hidden p-2 text-slate-300 hover:text-white" x-data="{ mobileOpen: false }" @click="$dispatch('toggle-mobile-menu')">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
        </div>
        
        
        <div x-data="{ open: false }" @toggle-mobile-menu.window="open = !open" x-show="open" x-cloak class="md:hidden glass border-t border-white/10">
            <div class="px-4 py-4 space-y-2">
                <?php if(auth()->guard()->check()): ?>
                    <?php if(auth()->user()->isAdmin()): ?>
                        <a href="<?php echo e(route('admin.dashboard')); ?>" class="block px-4 py-3 rounded-xl text-slate-300 hover:text-white hover:bg-white/10 <?php echo e(request()->routeIs('admin.dashboard') ? 'bg-white/10 text-white' : ''); ?>">
                            <i class="fas fa-chart-line mr-3 w-5"></i>Dashboard
                        </a>
                        <a href="<?php echo e(route('admin.categories.index')); ?>" class="block px-4 py-3 rounded-xl text-slate-300 hover:text-white hover:bg-white/10">
                            <i class="fas fa-tags mr-3 w-5"></i>Kategori
                        </a>
                        <a href="<?php echo e(route('admin.products.index')); ?>" class="block px-4 py-3 rounded-xl text-slate-300 hover:text-white hover:bg-white/10">
                            <i class="fas fa-utensils mr-3 w-5"></i>Produk
                        </a>
                        <a href="<?php echo e(route('admin.orders.index')); ?>" class="block px-4 py-3 rounded-xl text-slate-300 hover:text-white hover:bg-white/10">
                            <i class="fas fa-shopping-cart mr-3 w-5"></i>Pesanan
                        </a>
                        <a href="<?php echo e(route('admin.reports.sales')); ?>" class="block px-4 py-3 rounded-xl text-slate-300 hover:text-white hover:bg-white/10">
                            <i class="fas fa-chart-bar mr-3 w-5"></i>Laporan
                        </a>
                        <a href="<?php echo e(route('admin.withdrawals.index')); ?>" class="block px-4 py-3 rounded-xl text-slate-300 hover:text-white hover:bg-white/10">
                            <i class="fas fa-hand-holding-usd mr-3 w-5"></i>Penarikan
                        </a>
                    <?php elseif(auth()->user()->isKantin()): ?>
                        <a href="<?php echo e(route('kantin.dashboard')); ?>" class="block px-4 py-3 rounded-xl text-slate-300 hover:text-white hover:bg-white/10">
                            <i class="fas fa-home mr-3 w-5"></i>Dashboard
                        </a>
                        <a href="<?php echo e(route('kantin.orders.index')); ?>" class="block px-4 py-3 rounded-xl text-slate-300 hover:text-white hover:bg-white/10">
                            <i class="fas fa-clipboard-list mr-3 w-5"></i>Pesanan
                        </a>
                        <a href="<?php echo e(route('kantin.reports')); ?>" class="block px-4 py-3 rounded-xl text-slate-300 hover:text-white hover:bg-white/10">
                            <i class="fas fa-chart-line mr-3 w-5"></i>Laporan
                        </a>
                        <a href="<?php echo e(route('kantin.withdrawals.index')); ?>" class="block px-4 py-3 rounded-xl text-slate-300 hover:text-white hover:bg-white/10">
                            <i class="fas fa-money-bill-wave mr-3 w-5"></i>Penarikan
                        </a>
                    <?php else: ?>
                        <a href="<?php echo e(route('siswa.menu')); ?>" class="block px-4 py-3 rounded-xl text-slate-300 hover:text-white hover:bg-white/10">
                            <i class="fas fa-utensils mr-3 w-5"></i>Menu
                        </a>
                        <a href="<?php echo e(route('siswa.orders.index')); ?>" class="block px-4 py-3 rounded-xl text-slate-300 hover:text-white hover:bg-white/10">
                            <i class="fas fa-history mr-3 w-5"></i>Riwayat
                        </a>
                        <a href="<?php echo e(route('siswa.saldo.index')); ?>" class="block px-4 py-3 rounded-xl text-slate-300 hover:text-white hover:bg-white/10">
                            <i class="fas fa-wallet mr-3 w-5"></i>Saldo
                        </a>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <!-- Flash Messages Modern Dark -->
    <?php if(session('success')): ?>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
            <div class="glass bg-green-500/10 border-green-500/30 text-green-400 px-6 py-4 rounded-2xl flex items-center justify-between" 
                 x-data="{ show: true }" 
                 x-show="show" 
                 x-init="setTimeout(() => show = false, 5000)"
                 x-transition>
                <div class="flex items-center">
                    <span class="w-10 h-10 bg-green-500/20 rounded-xl flex items-center justify-center mr-4">
                        <i class="fas fa-check-circle text-xl"></i>
                    </span>
                    <span class="font-semibold"><?php echo e(session('success')); ?></span>
                </div>
                <button @click="show = false" class="w-8 h-8 bg-green-500/20 rounded-lg flex items-center justify-center hover:bg-green-500/30 transition-colors">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
            <div class="glass bg-red-500/10 border-red-500/30 text-red-400 px-6 py-4 rounded-2xl flex items-center">
                <span class="w-10 h-10 bg-red-500/20 rounded-xl flex items-center justify-center mr-4">
                    <i class="fas fa-exclamation-circle text-xl"></i>
                </span>
                <span class="font-semibold"><?php echo e(session('error')); ?></span>
            </div>
        </div>
    <?php endif; ?>

    <?php if($errors->any()): ?>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
            <div class="glass bg-red-500/10 border-red-500/30 text-red-400 px-6 py-4 rounded-2xl">
                <div class="flex items-start">
                    <span class="w-10 h-10 bg-red-500/20 rounded-xl flex items-center justify-center mr-4 flex-shrink-0">
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
    <main class="flex-grow">
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <!-- Footer Modern Dark -->
    <footer class="glass border-t border-white/10 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex flex-col md:flex-row items-center justify-between">
                <div class="flex items-center space-x-3 mb-4 md:mb-0">
                    <div class="w-10 h-10 bg-gradient-to-br from-orange-500 to-amber-500 rounded-xl flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <span class="font-bold text-white">Rasa<span class="text-orange-500">Pelajar</span></span>
                </div>
                <p class="text-slate-500 text-sm">
                    &copy; <?php echo e(date('Y')); ?> RasaPelajar. Sistem Informasi Kantin Sekolah.
                </p>
            </div>
        </div>
    </footer>

    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\laragon\www\kantin-modern\resources\views/layouts/app.blade.php ENDPATH**/ ?>