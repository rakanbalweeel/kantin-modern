

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - RasaPelajar</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        .animate-blob {
            animation: blob 7s infinite;
        }
        .animation-delay-2000 {
            animation-delay: 2s;
        }
        .animation-delay-4000 {
            animation-delay: 4s;
        }
        @keyframes blob {
            0% { transform: translate(0px, 0px) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
            100% { transform: translate(0px, 0px) scale(1); }
        }
        .glass {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
        }
    </style>
</head>
<body class="min-h-screen">
    
    <div class="fixed inset-0 -z-10 overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-500"></div>
        <div class="absolute top-0 -left-4 w-72 h-72 bg-purple-300 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob"></div>
        <div class="absolute top-0 -right-4 w-72 h-72 bg-yellow-300 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-2000"></div>
        <div class="absolute -bottom-8 left-20 w-72 h-72 bg-pink-300 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-4000"></div>
    </div>

    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8" x-data="loginForm()">
        <div class="max-w-md w-full space-y-8">
            
            <div class="glass rounded-3xl shadow-2xl p-8 sm:p-10">
                
                <div class="text-center mb-8">
                    <a href="<?php echo e(route('landing')); ?>" class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl shadow-lg transform hover:scale-105 transition duration-300">
                        <span class="text-4xl">🍽️</span>
                    </a>
                    <h2 class="mt-6 text-3xl font-extrabold text-gray-900">Selamat Datang!</h2>
                    <p class="mt-2 text-gray-600">Masuk ke akun <span class="text-indigo-600 font-semibold">RasaPelajar</span></p>
                </div>

                
                <?php if(session('success')): ?>
                    <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg" x-data="{ show: true }" x-show="show" x-transition>
                        <div class="flex items-center">
                            <span class="text-green-500 mr-3">✓</span>
                            <p class="text-green-700 text-sm"><?php echo e(session('success')); ?></p>
                            <button @click="show = false" class="ml-auto text-green-500 hover:text-green-700">&times;</button>
                        </div>
                    </div>
                <?php endif; ?>

                
                <?php if(session('error')): ?>
                    <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg" x-data="{ show: true }" x-show="show" x-transition>
                        <div class="flex items-center">
                            <span class="text-red-500 mr-3">✕</span>
                            <p class="text-red-700 text-sm"><?php echo e(session('error')); ?></p>
                            <button @click="show = false" class="ml-auto text-red-500 hover:text-red-700">&times;</button>
                        </div>
                    </div>
                <?php endif; ?>

                
                <form action="<?php echo e(route('login')); ?>" method="POST" class="space-y-6" @submit="loading = true">
                    <?php echo csrf_field(); ?>

                    
                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                            📧 Email
                        </label>
                        <div class="relative">
                            <input 
                                type="email" 
                                name="email" 
                                id="email"
                                x-model="email"
                                value="<?php echo e(old('email')); ?>"
                                class="w-full px-4 py-3.5 bg-gray-50 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:bg-white transition duration-200 <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 bg-red-50 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                placeholder="email@sekolah.com"
                                required
                                autofocus
                            >
                            <div class="absolute inset-y-0 right-0 flex items-center pr-4">
                                <template x-if="email && email.includes('@')">
                                    <span class="text-green-500">✓</span>
                                </template>
                            </div>
                        </div>
                        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <span class="mr-1">⚠</span> <?php echo e($message); ?>

                            </p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    
                    <div>
                        <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                            🔒 Password
                        </label>
                        <div class="relative">
                            <input 
                                :type="showPassword ? 'text' : 'password'" 
                                name="password" 
                                id="password"
                                x-model="password"
                                class="w-full px-4 py-3.5 bg-gray-50 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:bg-white transition duration-200 pr-12 <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 bg-red-50 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                placeholder="••••••••"
                                required
                            >
                            <button 
                                type="button" 
                                @click="showPassword = !showPassword"
                                class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-500 hover:text-indigo-600 transition"
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
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <span class="mr-1">⚠</span> <?php echo e($message); ?>

                            </p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    
                    <div class="flex items-center justify-between">
                        <label class="flex items-center cursor-pointer group">
                            <input type="checkbox" name="remember" class="w-5 h-5 text-indigo-600 border-2 border-gray-300 rounded focus:ring-indigo-500 transition">
                            <span class="ml-2 text-sm text-gray-600 group-hover:text-gray-900 transition">Ingat saya</span>
                        </label>
                    </div>

                    
                    <button 
                        type="submit"
                        :disabled="loading"
                        class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 text-white py-4 px-6 rounded-xl font-bold text-lg hover:from-indigo-700 hover:to-purple-700 focus:ring-4 focus:ring-indigo-300 transition duration-300 transform hover:scale-[1.02] active:scale-[0.98] disabled:opacity-70 disabled:cursor-not-allowed flex items-center justify-center"
                    >
                        <template x-if="!loading">
                            <span class="flex items-center">
                                <span class="mr-2">🚀</span> Masuk Sekarang
                            </span>
                        </template>
                        <template x-if="loading">
                            <span class="flex items-center">
                                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Memproses...
                            </span>
                        </template>
                    </button>
                </form>

                
                <p class="mt-8 text-center text-gray-600">
                    Belum punya akun?
                    <a href="<?php echo e(route('register')); ?>" class="text-indigo-600 font-bold hover:text-indigo-500 hover:underline transition">
                        Daftar sekarang →
                    </a>
                </p>
            </div>

            
            <div class="flex justify-center">
                <a href="<?php echo e(route('landing')); ?>" 
                   class="group inline-flex items-center text-white/80 hover:text-white transition-all duration-300">
                    <span class="flex items-center justify-center w-10 h-10 rounded-xl bg-white/10 backdrop-blur-sm border border-white/20 mr-3 group-hover:bg-white/20 group-hover:-translate-x-1 transition-all duration-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </span>
                    <span class="font-medium">Kembali ke Beranda</span>
                </a>
            </div>
        </div>
    </div>

    <script>
        function loginForm() {
            return {
                email: '<?php echo e(old("email")); ?>',
                password: '',
                showPassword: false,
                loading: false
            }
        }
    </script>
</body>
</html>
<?php /**PATH C:\laragon\www\kantin-modern\resources\views/auth/login.blade.php ENDPATH**/ ?>