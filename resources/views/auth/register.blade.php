{{--
==========================================================================
HALAMAN REGISTER - RasaPelajar
==========================================================================
Modern dark theme matching landing page design
==========================================================================
--}}

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - RasaPelajar</title>
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
        
        .strength-bar {
            transition: all 0.3s ease;
        }
    </style>
</head>
<body class="bg-slate-950 text-white">
    <div class="hero-gradient min-h-screen flex items-center justify-center relative grid-pattern py-12" x-data="registerForm()">
        {{-- Decorative Elements --}}
        <div class="decoration-blob w-96 h-96 bg-orange-500/30 -top-48 -left-48 pulse-glow"></div>
        <div class="decoration-blob w-72 h-72 bg-blue-500/20 bottom-20 -right-36 pulse-glow" style="animation-delay: 2s;"></div>
        
        {{-- Floating Food Icons --}}
        <div class="absolute top-20 right-10 text-6xl opacity-20 float-animation hidden lg:block">🍜</div>
        <div class="absolute top-48 left-20 text-5xl opacity-20 float-animation-delayed hidden lg:block">🍛</div>
        <div class="absolute bottom-20 right-20 text-4xl opacity-20 float-animation hidden lg:block">🧃</div>
        <div class="absolute bottom-48 left-10 text-5xl opacity-20 float-animation-delayed hidden lg:block">🍲</div>

        <div class="max-w-md w-full mx-4 relative z-10">
            {{-- Register Card --}}
            <div class="glass-card rounded-3xl p-8 sm:p-10">
                {{-- Header --}}
                <div class="text-center mb-8">
                    <a href="{{ route('landing') }}" class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-orange-500 to-amber-500 rounded-2xl shadow-lg shadow-orange-500/30 transform hover:scale-105 transition duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </a>
                    <h2 class="mt-6 text-3xl font-extrabold text-white">Buat Akun Baru</h2>
                    <p class="mt-2 text-slate-400">Bergabung dengan <span class="gradient-text font-semibold">RasaPelajar</span></p>
                </div>

                {{-- Progress Steps --}}
                <div class="flex items-center justify-center mb-8">
                    <div class="flex items-center">
                        <div :class="step >= 1 ? 'bg-gradient-to-r from-orange-500 to-amber-500 text-white shadow-lg shadow-orange-500/30' : 'bg-slate-700 text-slate-400'" class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold transition-all duration-300">1</div>
                        <div :class="step >= 2 ? 'bg-gradient-to-r from-orange-500 to-amber-500' : 'bg-slate-700'" class="w-12 h-1 mx-1 rounded transition-all duration-300"></div>
                        <div :class="step >= 2 ? 'bg-gradient-to-r from-orange-500 to-amber-500 text-white shadow-lg shadow-orange-500/30' : 'bg-slate-700 text-slate-400'" class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold transition-all duration-300">2</div>
                        <div :class="step >= 3 ? 'bg-gradient-to-r from-orange-500 to-amber-500' : 'bg-slate-700'" class="w-12 h-1 mx-1 rounded transition-all duration-300"></div>
                        <div :class="step >= 3 ? 'bg-gradient-to-r from-orange-500 to-amber-500 text-white shadow-lg shadow-orange-500/30' : 'bg-slate-700 text-slate-400'" class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold transition-all duration-300">✓</div>
                    </div>
                </div>

                {{-- Alert Error --}}
                @if($errors->any())
                    <div class="mb-6 glass rounded-xl p-4 border-l-4 border-red-500">
                        <div class="flex items-start">
                            <span class="text-red-400 mr-3 mt-0.5">✕</span>
                            <div class="text-red-400 text-sm">
                                @foreach($errors->all() as $error)
                                    <p>{{ $error }}</p>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Form Register --}}
                <form action="{{ route('register') }}" method="POST" class="space-y-5" @submit="loading = true">
                    @csrf

                    {{-- Input Nama --}}
                    <div>
                        <label for="name" class="block text-sm font-semibold text-slate-300 mb-2">
                            Nama Lengkap
                        </label>
                        <input 
                            type="text" 
                            name="name" 
                            id="name"
                            x-model="name"
                            @input="updateStep()"
                            value="{{ old('name') }}"
                            class="input-dark w-full px-4 py-3.5 rounded-xl focus:outline-none @error('name') border-red-500 @enderror"
                            placeholder="Masukkan nama lengkap"
                            required
                            autofocus
                        >
                        @error('name')
                            <p class="mt-2 text-sm text-red-400 flex items-center">
                                <span class="mr-1">⚠</span> {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Input Email --}}
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
                                @input="updateStep()"
                                value="{{ old('email') }}"
                                class="input-dark w-full px-4 py-3.5 rounded-xl focus:outline-none @error('email') border-red-500 @enderror"
                                placeholder="email@sekolah.com"
                                required
                            >
                            <div class="absolute inset-y-0 right-0 flex items-center pr-4">
                                <template x-if="email && email.includes('@') && email.includes('.')">
                                    <span class="text-green-400">✓</span>
                                </template>
                            </div>
                        </div>
                        @error('email')
                            <p class="mt-2 text-sm text-red-400 flex items-center">
                                <span class="mr-1">⚠</span> {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Input Password --}}
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
                                @input="updateStep(); checkStrength()"
                                class="input-dark w-full px-4 py-3.5 rounded-xl focus:outline-none pr-12 @error('password') border-red-500 @enderror"
                                placeholder="Minimal 8 karakter"
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
                        
                        {{-- Password Strength --}}
                        <div x-show="password.length > 0" class="mt-3">
                            <div class="flex gap-1 mb-2">
                                <div class="h-1.5 flex-1 rounded-full transition-all duration-300"
                                     :class="passwordStrength >= 1 ? 'bg-red-500' : 'bg-slate-700'"></div>
                                <div class="h-1.5 flex-1 rounded-full transition-all duration-300"
                                     :class="passwordStrength >= 2 ? 'bg-orange-500' : 'bg-slate-700'"></div>
                                <div class="h-1.5 flex-1 rounded-full transition-all duration-300"
                                     :class="passwordStrength >= 3 ? 'bg-yellow-500' : 'bg-slate-700'"></div>
                                <div class="h-1.5 flex-1 rounded-full transition-all duration-300"
                                     :class="passwordStrength >= 4 ? 'bg-green-500' : 'bg-slate-700'"></div>
                            </div>
                            <p class="text-xs" :class="{
                                'text-red-400': passwordStrength === 1,
                                'text-orange-400': passwordStrength === 2,
                                'text-yellow-400': passwordStrength === 3,
                                'text-green-400': passwordStrength === 4
                            }" x-text="strengthText"></p>
                        </div>
                        
                        @error('password')
                            <p class="mt-2 text-sm text-red-400 flex items-center">
                                <span class="mr-1">⚠</span> {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Input Konfirmasi Password --}}
                    <div>
                        <label for="password_confirmation" class="block text-sm font-semibold text-slate-300 mb-2">
                            Konfirmasi Password
                        </label>
                        <div class="relative">
                            <input 
                                :type="showConfirmPassword ? 'text' : 'password'" 
                                name="password_confirmation" 
                                id="password_confirmation"
                                x-model="passwordConfirm"
                                @input="updateStep()"
                                class="input-dark w-full px-4 py-3.5 rounded-xl focus:outline-none pr-12"
                                placeholder="Ulangi password"
                                required
                            >
                            <button 
                                type="button" 
                                @click="showConfirmPassword = !showConfirmPassword"
                                class="absolute inset-y-0 right-0 flex items-center pr-4 text-slate-400 hover:text-orange-400 transition"
                            >
                                <span x-show="!showConfirmPassword" class="text-lg">👁️</span>
                                <span x-show="showConfirmPassword" class="text-lg">🙈</span>
                            </button>
                        </div>
                        <template x-if="passwordConfirm && password !== passwordConfirm">
                            <p class="mt-2 text-sm text-red-400 flex items-center">
                                <span class="mr-1">⚠</span> Password tidak cocok
                            </p>
                        </template>
                        <template x-if="passwordConfirm && password === passwordConfirm">
                            <p class="mt-2 text-sm text-green-400 flex items-center">
                                <span class="mr-1">✓</span> Password cocok
                            </p>
                        </template>
                    </div>

                    {{-- Submit Button --}}
                    <button 
                        type="submit"
                        :disabled="loading || (passwordConfirm && password !== passwordConfirm)"
                        class="btn-glow w-full bg-gradient-to-r from-orange-500 to-amber-500 text-white font-bold py-4 px-6 rounded-xl shadow-lg shadow-orange-500/30 hover:shadow-orange-500/50 transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center mt-6"
                    >
                        <template x-if="loading">
                            <svg class="animate-spin h-5 w-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </template>
                        <span x-text="loading ? 'Memproses...' : 'Daftar Sekarang'"></span>
                    </button>
                </form>

                {{-- Login Link --}}
                <div class="mt-8 text-center">
                    <p class="text-slate-400">
                        Sudah punya akun?
                        <a href="{{ route('login') }}" class="font-semibold gradient-text hover:underline">
                            Masuk disini
                        </a>
                    </p>
                </div>
            </div>

            {{-- Back to Home --}}
            <div class="mt-6 text-center">
                <a href="{{ route('landing') }}" class="inline-flex items-center text-slate-400 hover:text-white transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>

    <script>
        function registerForm() {
            return {
                name: '{{ old('name') }}',
                email: '{{ old('email') }}',
                password: '',
                passwordConfirm: '',
                showPassword: false,
                showConfirmPassword: false,
                loading: false,
                step: 1,
                passwordStrength: 0,
                strengthText: '',
                
                updateStep() {
                    if (this.name && this.email && this.email.includes('@')) {
                        this.step = 2;
                    }
                    if (this.password.length >= 8 && this.passwordConfirm === this.password) {
                        this.step = 3;
                    }
                },
                
                checkStrength() {
                    let strength = 0;
                    const pass = this.password;
                    
                    if (pass.length >= 8) strength++;
                    if (pass.match(/[a-z]/) && pass.match(/[A-Z]/)) strength++;
                    if (pass.match(/\d/)) strength++;
                    if (pass.match(/[^a-zA-Z\d]/)) strength++;
                    
                    this.passwordStrength = strength;
                    
                    const texts = ['', 'Lemah', 'Cukup', 'Kuat', 'Sangat Kuat'];
                    this.strengthText = texts[strength] || '';
                }
            }
        }
    </script>
</body>
</html>
