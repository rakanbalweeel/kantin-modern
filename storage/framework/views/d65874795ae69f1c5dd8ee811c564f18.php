

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - RasaPelajar</title>
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
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        
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
        
        .decoration-blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(60px);
            opacity: 0.6;
        }
        
        .grid-pattern {
            background-image: 
                linear-gradient(rgba(255,255,255,0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.03) 1px, transparent 1px);
            background-size: 50px 50px;
        }
        
        .input-dark {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: white;
            transition: all 0.3s ease;
        }
        
        .input-dark:focus {
            background: rgba(255, 255, 255, 0.08);
            border-color: rgba(249, 115, 22, 0.5);
            box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.1);
        }
        
        .input-dark::placeholder {
            color: rgba(255, 255, 255, 0.4);
        }
    </style>
</head>
<body class="bg-slate-950 text-white">
    <div class="hero-gradient min-h-screen flex items-center justify-center relative grid-pattern" x-data="loginForm()">
        
        <div class="decoration-blob w-96 h-96 bg-orange-500/30 -top-48 -right-48 pulse-glow"></div>
        <div class="decoration-blob w-72 h-72 bg-blue-500/20 bottom-20 -left-36 pulse-glow" style="animation-delay: 2s;"></div>
        
        
        <div class="absolute top-20 left-10 text-6xl opacity-20 float-animation hidden lg:block">🍜</div>
        <div class="absolute top-32 right-20 text-5xl opacity-20 float-animation-delayed hidden lg:block">🍛</div>
        <div class="absolute bottom-20 left-20 text-4xl opacity-20 float-animation hidden lg:block">🧃</div>
        <div class="absolute bottom-32 right-10 text-5xl opacity-20 float-animation-delayed hidden lg:block">🍲</div>

        <div class="max-w-md w-full mx-4 relative z-10">
            
            <div class="glass-card rounded-3xl p-8 sm:p-10">
                
                <div class="text-center mb-8">
                    <a href="<?php echo e(route('landing')); ?>" class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-orange-500 to-amber-500 rounded-2xl shadow-lg shadow-orange-500/30 transform hover:scale-105 transition duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </a>
                    <h2 class="mt-6 text-3xl font-extrabold text-white">Selamat Datang!</h2>
                    <p class="mt-2 text-slate-400">Masuk ke akun <span class="gradient-text font-semibold">RasaPelajar</span></p>
                </div>

                
                <?php if(session('success')): ?>
                    <div class="mb-6 glass rounded-xl p-4 border-l-4 border-green-500" x-data="{ show: true }" x-show="show" x-transition>
                        <div class="flex items-center">
                            <span class="text-green-400 mr-3">✓</span>
                            <p class="text-green-400 text-sm flex-1"><?php echo e(session('success')); ?></p>
                            <button @click="show = false" class="text-green-400 hover:text-green-300">&times;</button>
                        </div>
                    </div>
                <?php endif; ?>

                
                <?php if(session('error')): ?>
                    <div class="mb-6 glass rounded-xl p-4 border-l-4 border-red-500" x-data="{ show: true }" x-show="show" x-transition>
                        <div class="flex items-center">
                            <span class="text-red-400 mr-3">✕</span>
                            <p class="text-red-400 text-sm flex-1"><?php echo e(session('error')); ?></p>
                            <button @click="show = false" class="text-red-400 hover:text-red-300">&times;</button>
                        </div>
                    </div>
                <?php endif; ?>

                
                <form id="login-form" action="<?php echo e(route('login')); ?>" method="POST" class="space-y-6" @submit="loading = true">
                    <?php echo csrf_field(); ?>

                    
                    <div>
                        <label for="email" class="block text-sm font-semibold text-slate-300 mb-2">
                            Email
                        </label>
                        <div class="relative">
                            <input 
                                type="email" 
                                name="email" 
                                id="email"
                                x-model="email"
                                value="<?php echo e(old('email')); ?>"
                                class="input-dark w-full px-4 py-3.5 rounded-xl focus:outline-none <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                placeholder="email@sekolah.com"
                                required
                                autofocus
                            >
                            <div class="absolute inset-y-0 right-0 flex items-center pr-4">
                                <template x-if="email && email.includes('@')">
                                    <span class="text-green-400">✓</span>
                                </template>
                            </div>
                        </div>
                        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-2 text-sm text-red-400 flex items-center">
                                <span class="mr-1">⚠</span> <?php echo e($message); ?>

                            </p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    
                    <div>
                        <label for="password" class="block text-sm font-semibold text-slate-300 mb-2">
                            Password
                        </label>
                        <div class="relative">
                            <input 
                                :type="showPassword ? 'text' : 'password'" 
                                name="password" 
                                id="password"
                                x-model="password"
                                class="input-dark w-full px-4 py-3.5 rounded-xl focus:outline-none pr-12 <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                placeholder="••••••••"
                                required
                            >
                            <button 
                                type="button" 
                                @click="showPassword = !showPassword"
                                class="absolute inset-y-0 right-0 flex items-center pr-4 text-slate-400 hover:text-orange-400 transition"
                            >
                                <span x-show="!showPassword" class="text-lg">👁️</span>
                                <span x-show="showPassword" class="text-lg">🙈</span>
                            </button>
                        </div>
                        <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-2 text-sm text-red-400 flex items-center">
                                <span class="mr-1">⚠</span> <?php echo e($message); ?>

                            </p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    
                    <div class="flex items-center justify-between">
                        <label class="flex items-center cursor-pointer group">
                            <input type="checkbox" name="remember" class="w-4 h-4 rounded border-slate-600 bg-slate-800 text-orange-500 focus:ring-orange-500 focus:ring-offset-0">
                            <span class="ml-2 text-sm text-slate-400 group-hover:text-slate-300 transition">Ingat saya</span>
                        </label>
                    </div>

                    
                    <button 
                        type="submit"
                        :disabled="loading"
                        class="btn-glow w-full bg-gradient-to-r from-orange-500 to-amber-500 text-white font-bold py-4 px-6 rounded-xl shadow-lg shadow-orange-500/30 hover:shadow-orange-500/50 transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center"
                    >
                        <template x-if="loading">
                            <svg class="animate-spin h-5 w-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </template>
                        <span x-text="loading ? 'Memproses...' : 'Masuk'"></span>
                    </button>
                </form>

                
                <div class="relative my-8">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-slate-700"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-4 bg-slate-900 text-slate-500">Akun Demo</span>
                    </div>
                </div>

                
                <div class="grid grid-cols-1 gap-3">
                    <button type="button" @click="fillDemo('admin@kantin.com', 'password')" 
                            class="glass hover:bg-white/10 px-4 py-3 rounded-xl flex items-center justify-between group transition-all duration-300">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-gradient-to-br from-red-500 to-rose-600 rounded-xl flex items-center justify-center mr-3">
                                <span class="text-white text-sm">👑</span>
                            </div>
                            <div class="text-left">
                                <p class="font-semibold text-white text-sm">Admin</p>
                                <p class="text-xs text-slate-400">admin@kantin.com</p>
                            </div>
                        </div>
                        <svg class="w-5 h-5 text-slate-500 group-hover:text-orange-400 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </button>
                    
                    <button type="button" @click="fillDemo('kantin@kantin.com', 'password')" 
                            class="glass hover:bg-white/10 px-4 py-3 rounded-xl flex items-center justify-between group transition-all duration-300">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-gradient-to-br from-orange-500 to-amber-600 rounded-xl flex items-center justify-center mr-3">
                                <span class="text-white text-sm">👨‍🍳</span>
                            </div>
                            <div class="text-left">
                                <p class="font-semibold text-white text-sm">Penjaga Kantin</p>
                                <p class="text-xs text-slate-400">kantin@kantin.com</p>
                            </div>
                        </div>
                        <svg class="w-5 h-5 text-slate-500 group-hover:text-orange-400 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </button>
                    
                    <button type="button" @click="fillDemo('budi@siswa.com', 'password')" 
                            class="glass hover:bg-white/10 px-4 py-3 rounded-xl flex items-center justify-between group transition-all duration-300">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center mr-3">
                                <span class="text-white text-sm">🎓</span>
                            </div>
                            <div class="text-left">
                                <p class="font-semibold text-white text-sm">Siswa</p>
                                <p class="text-xs text-slate-400">budi@siswa.com</p>
                            </div>
                        </div>
                        <svg class="w-5 h-5 text-slate-500 group-hover:text-orange-400 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </button>
                </div>

                
                <div class="mt-8 text-center">
                    <p class="text-slate-400">
                        Belum punya akun?
                        <a href="<?php echo e(route('register')); ?>" class="font-semibold gradient-text hover:underline">
                            Daftar sekarang
                        </a>
                    </p>
                </div>
            </div>

            
            <div class="mt-6 text-center">
                <a href="<?php echo e(route('landing')); ?>" class="inline-flex items-center text-slate-400 hover:text-white transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>

    <script>
        function loginForm() {
            return {
                email: '<?php echo e(old('email')); ?>',
                password: '',
                showPassword: false,
                loading: false,
                
                fillDemo(email, password) {
                    this.email = email;
                    this.password = password;
                    this.loading = true;
                    document.getElementById('email').value = email;
                    document.getElementById('password').value = password;
                    // Auto submit form after filling demo credentials
                    this.$nextTick(() => {
                        document.getElementById('login-form').submit();
                    });
                }
            }
        }
    </script>
</body>
</html>
<?php /**PATH C:\laragon\www\kantin-modern\resources\views/auth/login.blade.php ENDPATH**/ ?>