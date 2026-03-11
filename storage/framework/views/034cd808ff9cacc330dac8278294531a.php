<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RasaPelajar - Pesan Makanan Mudah & Cepat</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
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
        html { scroll-behavior: smooth; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        
        /* Modern Gradient */
        .hero-gradient {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #0f172a 100%);
            position: relative;
            overflow: hidden;
        }
        
        .hero-gradient::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: 
                radial-gradient(ellipse 80% 50% at 50% -20%, rgba(120, 119, 198, 0.3), transparent),
                radial-gradient(ellipse 60% 40% at 80% 50%, rgba(255, 119, 48, 0.15), transparent),
                radial-gradient(ellipse 50% 30% at 20% 80%, rgba(56, 189, 248, 0.2), transparent);
        }
        
        /* Floating Animation */
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(5deg); }
        }
        
        @keyframes float-delayed {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-15px) rotate(-5deg); }
        }
        
        @keyframes pulse-glow {
            0%, 100% { opacity: 0.5; transform: scale(1); }
            50% { opacity: 0.8; transform: scale(1.05); }
        }
        
        .float-animation { animation: float 6s ease-in-out infinite; }
        .float-animation-delayed { animation: float-delayed 5s ease-in-out infinite 1s; }
        .pulse-glow { animation: pulse-glow 4s ease-in-out infinite; }
        
        /* Glassmorphism */
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
        
        /* Gradient Text */
        .gradient-text {
            background: linear-gradient(135deg, #f97316 0%, #fb923c 50%, #fbbf24 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        /* Modern Card Hover */
        .feature-card {
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        
        .feature-card:hover {
            transform: translateY(-8px);
        }
        
        .feature-card:hover .feature-icon {
            transform: scale(1.1) rotate(5deg);
        }
        
        .feature-icon {
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        
        /* Menu Card */
        .menu-card {
            transition: all 0.3s ease;
        }
        
        .menu-card:hover {
            transform: translateY(-5px) scale(1.02);
        }
        
        /* Button Glow Effect */
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
        
        /* Decorative elements */
        .decoration-blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(60px);
            opacity: 0.6;
        }
        
        /* Stats Counter */
        .stat-card {
            background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0.05) 100%);
        }
        
        /* Grid Pattern */
        .grid-pattern {
            background-image: 
                linear-gradient(rgba(255,255,255,0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.03) 1px, transparent 1px);
            background-size: 50px 50px;
        }
    </style>
</head>
<body class="bg-slate-950 text-white">
    <!-- Navbar -->
    <nav class="fixed w-full z-50 transition-all duration-300" x-data="{ scrolled: false, mobileOpen: false }" 
         @scroll.window="scrolled = window.pageYOffset > 50">
        <div :class="scrolled ? 'bg-slate-900/95 backdrop-blur-lg shadow-lg shadow-slate-900/50' : 'bg-transparent'" 
             class="transition-all duration-300">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-20">
                    <div class="flex items-center">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-gradient-to-br from-orange-500 to-amber-500 rounded-xl flex items-center justify-center shadow-lg shadow-orange-500/30">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                            </div>
                            <span class="text-xl font-bold text-white">Rasa<span class="text-orange-500">Pelajar</span></span>
                        </div>
                    </div>
                    
                    <!-- Desktop Menu -->
                    <div class="hidden md:flex items-center space-x-8">
                        <a href="#features" class="text-slate-300 hover:text-white transition-colors font-medium">Fitur</a>
                        <a href="#menu" class="text-slate-300 hover:text-white transition-colors font-medium">Menu</a>
                        <a href="#testimonials" class="text-slate-300 hover:text-white transition-colors font-medium">Testimoni</a>
                        <a href="#contact" class="text-slate-300 hover:text-white transition-colors font-medium">Kontak</a>
                        
                        <?php if(auth()->guard()->check()): ?>
                            <span class="text-slate-400">Halo, <?php echo e(auth()->user()->name); ?></span>
                            <?php if(auth()->user()->isAdmin()): ?>
                                <a href="<?php echo e(route('admin.dashboard')); ?>" class="text-orange-500 font-semibold hover:text-orange-400">Dashboard</a>
                            <?php else: ?>
                                <a href="<?php echo e(route('siswa.menu')); ?>" class="text-orange-500 font-semibold hover:text-orange-400">Menu</a>
                            <?php endif; ?>
                            <form action="<?php echo e(route('logout')); ?>" method="POST" class="inline">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="bg-red-500/20 text-red-400 px-4 py-2 rounded-lg hover:bg-red-500/30 transition border border-red-500/30">Logout</button>
                            </form>
                        <?php else: ?>
                            <a href="<?php echo e(route('login')); ?>" class="text-white font-semibold hover:text-orange-400 transition">Login</a>
                            <a href="<?php echo e(route('register')); ?>" class="bg-gradient-to-r from-orange-500 to-amber-500 text-white px-6 py-2.5 rounded-xl font-semibold hover:shadow-lg hover:shadow-orange-500/30 transition-all duration-300 hover:-translate-y-0.5">
                                Daftar
                            </a>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Mobile Menu Button -->
                    <div class="md:hidden flex items-center">
                        <button @click="mobileOpen = !mobileOpen" class="text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path x-show="!mobileOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                <path x-show="mobileOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
                
                <!-- Mobile Menu -->
                <div x-show="mobileOpen" x-transition class="md:hidden pb-4">
                    <div class="flex flex-col space-y-4">
                        <a href="#features" class="text-slate-300 hover:text-white">Fitur</a>
                        <a href="#menu" class="text-slate-300 hover:text-white">Menu</a>
                        <a href="#contact" class="text-slate-300 hover:text-white">Kontak</a>
                        <?php if(auth()->guard()->guest()): ?>
                            <a href="<?php echo e(route('login')); ?>" class="text-white font-semibold">Login</a>
                            <a href="<?php echo e(route('register')); ?>" class="bg-gradient-to-r from-orange-500 to-amber-500 text-white px-6 py-2.5 rounded-xl font-semibold text-center">Daftar</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-gradient min-h-screen flex items-center relative grid-pattern">
        <!-- Decorative Elements -->
        <div class="decoration-blob w-96 h-96 bg-orange-500/30 -top-48 -right-48 pulse-glow"></div>
        <div class="decoration-blob w-72 h-72 bg-blue-500/20 bottom-20 -left-36 pulse-glow" style="animation-delay: 2s;"></div>
        
        <!-- Floating Food Icons -->
        <div class="absolute top-32 left-10 text-6xl opacity-20 float-animation hidden lg:block">🍜</div>
        <div class="absolute top-48 right-20 text-5xl opacity-20 float-animation-delayed hidden lg:block">🍛</div>
        <div class="absolute bottom-32 left-32 text-4xl opacity-20 float-animation hidden lg:block">🧃</div>
        <div class="absolute bottom-48 right-40 text-5xl opacity-20 float-animation-delayed hidden lg:block">🍲</div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-32 relative z-10">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <!-- Left Content -->
                <div class="text-center lg:text-left">
                    <div class="inline-flex items-center gap-2 bg-orange-500/10 border border-orange-500/20 rounded-full px-4 py-2 mb-6">
                        <span class="w-2 h-2 bg-orange-500 rounded-full animate-pulse"></span>
                        <span class="text-orange-400 text-sm font-medium">Sistem Kantin Digital #1</span>
                    </div>
                    
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold leading-tight mb-6">
                        Pesan Makanan Kantin
                        <span class="block gradient-text mt-2">Mudah & Cepat!</span>
                    </h1>
                    
                    <p class="text-lg text-slate-400 mb-8 max-w-xl mx-auto lg:mx-0">
                        Tidak perlu antri lagi! Pesan makanan dan minuman favoritmu dari kantin sekolah melalui sistem online yang modern dan praktis.
                    </p>
                    
                    <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                        <?php if(auth()->guard()->check()): ?>
                            <?php if(auth()->user()->isAdmin()): ?>
                                <a href="<?php echo e(route('admin.dashboard')); ?>" class="btn-glow inline-flex items-center justify-center bg-gradient-to-r from-orange-500 to-amber-500 text-white font-bold px-8 py-4 rounded-2xl shadow-lg shadow-orange-500/30 hover:shadow-orange-500/50 transition-all duration-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h12a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V6z" />
                                    </svg>
                                    Dashboard Admin
                                </a>
                            <?php else: ?>
                                <a href="<?php echo e(route('siswa.menu')); ?>" class="btn-glow inline-flex items-center justify-center bg-gradient-to-r from-orange-500 to-amber-500 text-white font-bold px-8 py-4 rounded-2xl shadow-lg shadow-orange-500/30 hover:shadow-orange-500/50 transition-all duration-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    Pesan Sekarang
                                </a>
                                <a href="<?php echo e(route('siswa.orders.index')); ?>" class="inline-flex items-center justify-center glass text-white font-bold px-8 py-4 rounded-2xl hover:bg-white/10 transition-all duration-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                    Pesanan Saya
                                </a>
                            <?php endif; ?>
                        <?php else: ?>
                            <a href="<?php echo e(route('register')); ?>" class="btn-glow inline-flex items-center justify-center bg-gradient-to-r from-orange-500 to-amber-500 text-white font-bold px-8 py-4 rounded-2xl shadow-lg shadow-orange-500/30 hover:shadow-orange-500/50 transition-all duration-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                </svg>
                                Daftar Gratis
                            </a>
                            <a href="<?php echo e(route('login')); ?>" class="inline-flex items-center justify-center glass text-white font-bold px-8 py-4 rounded-2xl hover:bg-white/10 transition-all duration-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                                </svg>
                                Masuk Akun
                            </a>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Stats -->
                    <div class="grid grid-cols-3 gap-4 mt-12 max-w-md mx-auto lg:mx-0">
                        <div class="text-center">
                            <div class="text-2xl md:text-3xl font-bold text-white">500+</div>
                            <div class="text-sm text-slate-500">Siswa Aktif</div>
                        </div>
                        <div class="text-center border-x border-slate-800">
                            <div class="text-2xl md:text-3xl font-bold text-white">50+</div>
                            <div class="text-sm text-slate-500">Menu Tersedia</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl md:text-3xl font-bold text-white">4.9</div>
                            <div class="text-sm text-slate-500">Rating</div>
                        </div>
                    </div>
                </div>
                
                <!-- Right Content - Hero Image/Card -->
                <div class="relative hidden lg:block">
                    <div class="relative z-10">
                        <!-- Main Card -->
                        <div class="glass-card rounded-3xl p-6 max-w-sm mx-auto transform rotate-3 hover:rotate-0 transition-transform duration-500">
                            <div class="flex items-center justify-between mb-4">
                                <span class="text-slate-400 text-sm">Pesanan Aktif</span>
                                <span class="w-3 h-3 bg-green-500 rounded-full animate-pulse"></span>
                            </div>
                            <div class="space-y-4">
                                <div class="flex items-center gap-4 bg-slate-800/50 rounded-2xl p-3">
                                    <div class="w-14 h-14 bg-gradient-to-br from-orange-500/20 to-amber-500/20 rounded-xl flex items-center justify-center text-2xl">🍜</div>
                                    <div class="flex-1">
                                        <div class="font-semibold text-white">Mie Ayam Special</div>
                                        <div class="text-sm text-slate-400">x1 • Rp 15.000</div>
                                    </div>
                                </div>
                                <div class="flex items-center gap-4 bg-slate-800/50 rounded-2xl p-3">
                                    <div class="w-14 h-14 bg-gradient-to-br from-blue-500/20 to-cyan-500/20 rounded-xl flex items-center justify-center text-2xl">🧃</div>
                                    <div class="flex-1">
                                        <div class="font-semibold text-white">Es Teh Manis</div>
                                        <div class="text-sm text-slate-400">x2 • Rp 10.000</div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4 pt-4 border-t border-slate-700">
                                <div class="flex justify-between items-center">
                                    <span class="text-slate-400">Total</span>
                                    <span class="text-xl font-bold text-orange-500">Rp 25.000</span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Floating notification -->
                        <div class="absolute -top-4 -left-4 glass-card rounded-2xl p-4 float-animation">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-green-500/20 rounded-full flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-sm font-semibold text-white">Pesanan Siap!</div>
                                    <div class="text-xs text-slate-400">Ambil di counter 2</div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Floating rating -->
                        <div class="absolute -bottom-4 -right-4 glass-card rounded-2xl p-4 float-animation-delayed">
                            <div class="flex items-center gap-2">
                                <div class="flex text-amber-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                </div>
                                <span class="text-white font-semibold">4.9</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Scroll Indicator -->
        <div class="absolute bottom-8 left-1/2 -translate-x-1/2 animate-bounce">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
            </svg>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-24 bg-slate-900 relative overflow-hidden">
        <div class="absolute inset-0 grid-pattern opacity-50"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center mb-16">
                <span class="inline-block text-orange-500 font-semibold text-sm uppercase tracking-wider mb-4">Fitur Unggulan</span>
                <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Kenapa Pakai <span class="gradient-text">Kantin Online?</span></h2>
                <p class="text-slate-400 max-w-2xl mx-auto">Nikmati kemudahan pesan makanan kantin dengan berbagai fitur modern yang memudahkan aktivitasmu</p>
            </div>
            
            <div class="grid md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="feature-card glass-card rounded-3xl p-8 text-center group">
                    <div class="feature-icon w-20 h-20 bg-gradient-to-br from-orange-500/20 to-amber-500/20 rounded-2xl flex items-center justify-center mx-auto mb-6 border border-orange-500/20">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">Cepat & Mudah</h3>
                    <p class="text-slate-400">Pesan dari HP dalam hitungan detik. Tidak perlu antri, makanan siap saat istirahat!</p>
                </div>
                
                <!-- Feature 2 -->
                <div class="feature-card glass-card rounded-3xl p-8 text-center group">
                    <div class="feature-icon w-20 h-20 bg-gradient-to-br from-emerald-500/20 to-green-500/20 rounded-2xl flex items-center justify-center mx-auto mb-6 border border-emerald-500/20">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">Menu Lengkap</h3>
                    <p class="text-slate-400">Lihat semua menu kantin, harga, dan ketersediaan stok secara real-time.</p>
                </div>
                
                <!-- Feature 3 -->
                <div class="feature-card glass-card rounded-3xl p-8 text-center group">
                    <div class="feature-icon w-20 h-20 bg-gradient-to-br from-purple-500/20 to-violet-500/20 rounded-2xl flex items-center justify-center mx-auto mb-6 border border-purple-500/20">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">Saldo Digital</h3>
                    <p class="text-slate-400">Top up saldo dan bayar pesanan dengan mudah tanpa ribet bawa uang tunai.</p>
                </div>
                
                <!-- Feature 4 -->
                <div class="feature-card glass-card rounded-3xl p-8 text-center group">
                    <div class="feature-icon w-20 h-20 bg-gradient-to-br from-blue-500/20 to-cyan-500/20 rounded-2xl flex items-center justify-center mx-auto mb-6 border border-blue-500/20">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">Riwayat Pesanan</h3>
                    <p class="text-slate-400">Lacak semua pesanan dan pesan ulang menu favorit dengan satu klik.</p>
                </div>
                
                <!-- Feature 5 -->
                <div class="feature-card glass-card rounded-3xl p-8 text-center group">
                    <div class="feature-icon w-20 h-20 bg-gradient-to-br from-pink-500/20 to-rose-500/20 rounded-2xl flex items-center justify-center mx-auto mb-6 border border-pink-500/20">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-pink-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">Notifikasi Real-time</h3>
                    <p class="text-slate-400">Dapatkan pemberitahuan saat pesananmu siap diambil.</p>
                </div>
                
                <!-- Feature 6 -->
                <div class="feature-card glass-card rounded-3xl p-8 text-center group">
                    <div class="feature-icon w-20 h-20 bg-gradient-to-br from-amber-500/20 to-yellow-500/20 rounded-2xl flex items-center justify-center mx-auto mb-6 border border-amber-500/20">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">Aman & Terpercaya</h3>
                    <p class="text-slate-400">Transaksi aman dengan sistem yang sudah teruji.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Menu Preview -->
    <section id="menu" class="py-24 bg-slate-950 relative overflow-hidden">
        <div class="decoration-blob w-96 h-96 bg-orange-500/10 top-0 right-0"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center mb-16">
                <span class="inline-block text-orange-500 font-semibold text-sm uppercase tracking-wider mb-4">Menu Pilihan</span>
                <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Menu <span class="gradient-text">Populer</span></h2>
                <p class="text-slate-400">Beberapa menu favorit di kantin sekolah yang bisa kamu pesan</p>
            </div>
            
            <div class="grid md:grid-cols-4 gap-6">
                <?php $__currentLoopData = [
                    ['🍜', 'Mie Ayam Special', 'Rp 15.000', 'Mie ayam dengan topping ayam suwir melimpah', 'from-orange-500/20 to-red-500/20', 'border-orange-500/20'],
                    ['🍛', 'Nasi Goreng', 'Rp 12.000', 'Nasi goreng spesial dengan telur dan kerupuk', 'from-amber-500/20 to-yellow-500/20', 'border-amber-500/20'],
                    ['🍲', 'Bakso Komplit', 'Rp 13.000', 'Bakso dengan mie, tahu, dan siomay', 'from-red-500/20 to-pink-500/20', 'border-red-500/20'],
                    ['🧃', 'Es Teh Manis', 'Rp 5.000', 'Teh manis dingin yang menyegarkan', 'from-emerald-500/20 to-green-500/20', 'border-emerald-500/20'],
                ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="menu-card glass-card rounded-3xl p-6 text-center group cursor-pointer">
                    <div class="w-20 h-20 bg-gradient-to-br <?php echo e($item[4]); ?> rounded-2xl flex items-center justify-center mx-auto mb-4 <?php echo e($item[5]); ?> border">
                        <span class="text-4xl"><?php echo e($item[0]); ?></span>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-1"><?php echo e($item[1]); ?></h3>
                    <p class="text-xs text-slate-500 mb-3"><?php echo e($item[3]); ?></p>
                    <p class="text-orange-500 font-bold text-lg"><?php echo e($item[2]); ?></p>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            
            <div class="text-center mt-12">
                <a href="<?php echo e(route('register')); ?>" class="btn-glow inline-flex items-center bg-gradient-to-r from-orange-500 to-amber-500 text-white px-8 py-4 rounded-2xl font-bold shadow-lg shadow-orange-500/30 hover:shadow-orange-500/50 transition-all duration-300">
                    Lihat Semua Menu
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                    </svg>
                </a>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section id="testimonials" class="py-24 bg-slate-900 relative overflow-hidden">
        <div class="absolute inset-0 grid-pattern opacity-30"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center mb-16">
                <span class="inline-block text-orange-500 font-semibold text-sm uppercase tracking-wider mb-4">Testimoni</span>
                <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Apa Kata <span class="gradient-text">Mereka?</span></h2>
                <p class="text-slate-400">Pengalaman siswa menggunakan RasaPelajar</p>
            </div>
            
            <div class="grid md:grid-cols-3 gap-8">
                <?php $__currentLoopData = [
                    ['Budi Santoso', 'Kelas 12 IPA', 'Sangat membantu! Tidak perlu antri lagi saat istirahat. Tinggal pesan dari kelas, sampai kantin makanan sudah siap.', '👨‍🎓'],
                    ['Siti Rahayu', 'Kelas 11 IPS', 'Aplikasinya mudah banget dipakai. Saldo digital juga praktis, nggak perlu bawa uang cash kemana-mana.', '👩‍🎓'],
                    ['Ahmad Pratama', 'Kelas 10', 'Fitur riwayat pesanan keren! Bisa pesan ulang menu favorit dengan cepat. Recommended!', '👨‍🎓'],
                ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $testimonial): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="glass-card rounded-3xl p-8">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-14 h-14 bg-gradient-to-br from-orange-500/20 to-amber-500/20 rounded-full flex items-center justify-center text-2xl">
                            <?php echo e($testimonial[3]); ?>

                        </div>
                        <div>
                            <h4 class="font-bold text-white"><?php echo e($testimonial[0]); ?></h4>
                            <p class="text-sm text-slate-500"><?php echo e($testimonial[1]); ?></p>
                        </div>
                    </div>
                    <p class="text-slate-400 italic">"<?php echo e($testimonial[2]); ?>"</p>
                    <div class="flex text-amber-400 mt-4">
                        <?php for($i = 0; $i < 5; $i++): ?>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                        </svg>
                        <?php endfor; ?>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-24 bg-slate-950 relative overflow-hidden">
        <div class="decoration-blob w-96 h-96 bg-orange-500/20 top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 pulse-glow"></div>
        <div class="max-w-4xl mx-auto px-4 text-center relative z-10">
            <div class="glass-card rounded-3xl p-12 border border-orange-500/20">
                <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Siap Pesan Makanan?</h2>
                <p class="text-xl text-slate-400 mb-8">Daftar sekarang dan nikmati kemudahan pesan makanan kantin secara online!</p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="<?php echo e(route('register')); ?>" class="btn-glow bg-gradient-to-r from-orange-500 to-amber-500 text-white font-bold px-10 py-4 rounded-2xl shadow-lg shadow-orange-500/30 hover:shadow-orange-500/50 transition-all duration-300 inline-flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                        </svg>
                        Daftar Sekarang
                    </a>
                    <a href="<?php echo e(route('login')); ?>" class="glass text-white font-bold px-10 py-4 rounded-2xl hover:bg-white/10 transition-all duration-300 inline-flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                        </svg>
                        Login
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer id="contact" class="bg-slate-900 border-t border-slate-800 pt-16 pb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-8 mb-12">
                <div class="md:col-span-2">
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="w-10 h-10 bg-gradient-to-br from-orange-500 to-amber-500 rounded-xl flex items-center justify-center shadow-lg shadow-orange-500/30">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                        <span class="text-xl font-bold text-white">Rasa<span class="text-orange-500">Pelajar</span></span>
                    </div>
                    <p class="text-slate-400 mb-6 max-w-md">Sistem informasi kantin digital untuk kemudahan pesan makanan di sekolah. Modern, cepat, dan terpercaya.</p>
                    <div class="flex space-x-4">
                        <a href="#" class="w-10 h-10 glass rounded-lg flex items-center justify-center text-slate-400 hover:text-white hover:bg-white/10 transition">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        </a>
                        <a href="#" class="w-10 h-10 glass rounded-lg flex items-center justify-center text-slate-400 hover:text-white hover:bg-white/10 transition">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 5.079 3.158 9.417 7.618 11.162-.105-.949-.199-2.403.041-3.439.219-.937 1.406-5.957 1.406-5.957s-.359-.72-.359-1.781c0-1.663.967-2.911 2.168-2.911 1.024 0 1.518.769 1.518 1.688 0 1.029-.653 2.567-.992 3.992-.285 1.193.6 2.165 1.775 2.165 2.128 0 3.768-2.245 3.768-5.487 0-2.861-2.063-4.869-5.008-4.869-3.41 0-5.409 2.562-5.409 5.199 0 1.033.394 2.143.889 2.741.099.12.112.225.085.345-.09.375-.293 1.199-.334 1.363-.053.225-.172.271-.401.165-1.495-.69-2.433-2.878-2.433-4.646 0-3.776 2.748-7.252 7.92-7.252 4.158 0 7.392 2.967 7.392 6.923 0 4.135-2.607 7.462-6.233 7.462-1.214 0-2.354-.629-2.758-1.379l-.749 2.848c-.269 1.045-1.004 2.352-1.498 3.146 1.123.345 2.306.535 3.55.535 6.607 0 11.985-5.365 11.985-11.987C23.97 5.39 18.592.026 11.985.026L12.017 0z"/></svg>
                        </a>
                        <a href="#" class="w-10 h-10 glass rounded-lg flex items-center justify-center text-slate-400 hover:text-white hover:bg-white/10 transition">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                        </a>
                    </div>
                </div>
                
                <div>
                    <h4 class="font-bold text-white mb-4">Kontak</h4>
                    <ul class="space-y-3">
                        <li class="flex items-center text-slate-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            Jl. Pendidikan No. 123
                        </li>
                        <li class="flex items-center text-slate-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            (021) 123-4567
                        </li>
                        <li class="flex items-center text-slate-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            kantin@sekolah.sch.id
                        </li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="font-bold text-white mb-4">Demo Account</h4>
                    <div class="glass-card rounded-xl p-4">
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-slate-500">Admin:</span>
                                <span class="text-slate-300">admin@kantin.com</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-slate-500">Kantin:</span>
                                <span class="text-slate-300">kantin@kantin.com</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-slate-500">Siswa:</span>
                                <span class="text-slate-300">budi@siswa.com</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-slate-500">Password:</span>
                                <span class="text-slate-300">password</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="border-t border-slate-800 pt-8 flex flex-col md:flex-row justify-between items-center">
                <p class="text-slate-500 text-sm">&copy; <?php echo e(date('Y')); ?> RasaPelajar. All rights reserved.</p>
                <div class="flex space-x-6 mt-4 md:mt-0">
                    <a href="#" class="text-slate-500 hover:text-slate-300 text-sm transition">Privacy Policy</a>
                    <a href="#" class="text-slate-500 hover:text-slate-300 text-sm transition">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
<?php /**PATH C:\laragon\www\kantin-modern\resources\views/landing.blade.php ENDPATH**/ ?>