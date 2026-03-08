{{--
==========================================================================
HALAMAN REGISTER - RasaPelajar
==========================================================================
Halaman pendaftaran dengan tampilan modern dan fitur lengkap.

FITUR:
- Show/hide password toggle
- Password strength indicator
- Real-time validation
- Animated background
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
    {{-- Animated Background --}}
    <div class="fixed inset-0 -z-10 overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-purple-600 via-pink-600 to-indigo-500"></div>
        <div class="absolute top-0 -left-4 w-72 h-72 bg-pink-300 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob"></div>
        <div class="absolute top-0 -right-4 w-72 h-72 bg-indigo-300 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-2000"></div>
        <div class="absolute -bottom-8 left-20 w-72 h-72 bg-yellow-300 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-4000"></div>
    </div>

    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8" x-data="registerForm()">
        <div class="max-w-md w-full space-y-8">
            {{-- Card Register --}}
            <div class="glass rounded-3xl shadow-2xl p-8 sm:p-10">
                {{-- Header --}}
                <div class="text-center mb-8">
                    <a href="{{ route('landing') }}" class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-purple-500 to-pink-600 rounded-2xl shadow-lg transform hover:scale-105 transition duration-300">
                        <span class="text-4xl">🍽️</span>
                    </a>
                    <h2 class="mt-6 text-3xl font-extrabold text-gray-900">Buat Akun Baru</h2>
                    <p class="mt-2 text-gray-600">Bergabung dengan <span class="text-purple-600 font-semibold">RasaPelajar</span></p>
                </div>

                {{-- Progress Steps --}}
                <div class="flex items-center justify-center mb-8">
                    <div class="flex items-center">
                        <div :class="step >= 1 ? 'bg-purple-600 text-white' : 'bg-gray-200 text-gray-500'" class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold transition">1</div>
                        <div :class="step >= 2 ? 'bg-purple-600' : 'bg-gray-200'" class="w-12 h-1 mx-1 transition"></div>
                        <div :class="step >= 2 ? 'bg-purple-600 text-white' : 'bg-gray-200 text-gray-500'" class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold transition">2</div>
                        <div :class="step >= 3 ? 'bg-purple-600' : 'bg-gray-200'" class="w-12 h-1 mx-1 transition"></div>
                        <div :class="step >= 3 ? 'bg-purple-600 text-white' : 'bg-gray-200 text-gray-500'" class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold transition">✓</div>
                    </div>
                </div>

                {{-- Form Register --}}
                <form action="{{ route('register') }}" method="POST" class="space-y-5" @submit="loading = true">
                    @csrf

                    {{-- Input Nama --}}
                    <div>
                        <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                            👤 Nama Lengkap
                        </label>
                        <input 
                            type="text" 
                            name="name" 
                            id="name"
                            x-model="name"
                            @input="updateStep()"
                            value="{{ old('name') }}"
                            class="w-full px-4 py-3.5 bg-gray-50 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 focus:bg-white transition duration-200 @error('name') border-red-500 bg-red-50 @enderror"
                            placeholder="Masukkan nama lengkap"
                            required
                            autofocus
                        >
                        @error('name')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <span class="mr-1">⚠</span> {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Input Email --}}
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
                                @input="updateStep()"
                                value="{{ old('email') }}"
                                class="w-full px-4 py-3.5 bg-gray-50 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 focus:bg-white transition duration-200 @error('email') border-red-500 bg-red-50 @enderror"
                                placeholder="email@sekolah.com"
                                required
                            >
                            <div class="absolute inset-y-0 right-0 flex items-center pr-4">
                                <template x-if="email && email.includes('@') && email.includes('.')">
                                    <span class="text-green-500">✓</span>
                                </template>
                            </div>
                        </div>
                        @error('email')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <span class="mr-1">⚠</span> {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Input Password --}}
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
                                @input="updateStep()"
                                class="w-full px-4 py-3.5 bg-gray-50 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 focus:bg-white transition duration-200 pr-12 @error('password') border-red-500 bg-red-50 @enderror"
                                placeholder="Minimal 8 karakter"
                                required
                            >
                            <button 
                                type="button" 
                                @click="showPassword = !showPassword"
                                class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-500 hover:text-purple-600 transition"
                            >
                                <span x-show="!showPassword" class="text-lg">👁️</span>
                                <span x-show="showPassword" class="text-lg">🙈</span>
                            </button>
                        </div>
                        {{-- Password Strength --}}
                        <div class="mt-2" x-show="password.length > 0">
                            <div class="flex gap-1 mb-1">
                                <div class="h-1 flex-1 rounded-full transition-all duration-300" :class="passwordStrength >= 1 ? 'bg-red-500' : 'bg-gray-200'"></div>
                                <div class="h-1 flex-1 rounded-full transition-all duration-300" :class="passwordStrength >= 2 ? 'bg-yellow-500' : 'bg-gray-200'"></div>
                                <div class="h-1 flex-1 rounded-full transition-all duration-300" :class="passwordStrength >= 3 ? 'bg-green-500' : 'bg-gray-200'"></div>
                                <div class="h-1 flex-1 rounded-full transition-all duration-300" :class="passwordStrength >= 4 ? 'bg-green-600' : 'bg-gray-200'"></div>
                            </div>
                            <p class="text-xs" :class="{'text-red-500': passwordStrength <= 1, 'text-yellow-500': passwordStrength == 2, 'text-green-500': passwordStrength >= 3}">
                                <span x-text="passwordStrengthText"></span>
                            </p>
                        </div>
                        @error('password')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <span class="mr-1">⚠</span> {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Input Konfirmasi Password --}}
                    <div>
                        <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
                            🔐 Konfirmasi Password
                        </label>
                        <div class="relative">
                            <input 
                                :type="showConfirmPassword ? 'text' : 'password'" 
                                name="password_confirmation" 
                                id="password_confirmation"
                                x-model="passwordConfirm"
                                @input="updateStep()"
                                class="w-full px-4 py-3.5 bg-gray-50 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 focus:bg-white transition duration-200 pr-12"
                                :class="{'border-green-500 bg-green-50': passwordConfirm && password === passwordConfirm, 'border-red-500 bg-red-50': passwordConfirm && password !== passwordConfirm}"
                                placeholder="Ulangi password"
                                required
                            >
                            <button 
                                type="button" 
                                @click="showConfirmPassword = !showConfirmPassword"
                                class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-500 hover:text-purple-600 transition"
                            >
                                <span x-show="!showConfirmPassword" class="text-lg">👁️</span>
                                <span x-show="showConfirmPassword" class="text-lg">🙈</span>
                            </button>
                        </div>
                        <p x-show="passwordConfirm && password !== passwordConfirm" class="mt-2 text-sm text-red-600 flex items-center">
                            <span class="mr-1">⚠</span> Password tidak sama
                        </p>
                        <p x-show="passwordConfirm && password === passwordConfirm" class="mt-2 text-sm text-green-600 flex items-center">
                            <span class="mr-1">✓</span> Password cocok
                        </p>
                    </div>

                    {{-- Terms --}}
                    <div class="flex items-start">
                        <input type="checkbox" required class="w-5 h-5 mt-0.5 text-purple-600 border-2 border-gray-300 rounded focus:ring-purple-500">
                        <span class="ml-2 text-sm text-gray-600">
                            Saya setuju dengan 
                            <a href="#" class="text-purple-600 hover:underline">Syarat & Ketentuan</a> 
                            dan 
                            <a href="#" class="text-purple-600 hover:underline">Kebijakan Privasi</a>
                        </span>
                    </div>

                    {{-- Submit Button --}}
                    <button 
                        type="submit"
                        :disabled="loading || (password !== passwordConfirm)"
                        class="w-full bg-gradient-to-r from-purple-600 to-pink-600 text-white py-4 px-6 rounded-xl font-bold text-lg hover:from-purple-700 hover:to-pink-700 focus:ring-4 focus:ring-purple-300 transition duration-300 transform hover:scale-[1.02] active:scale-[0.98] disabled:opacity-70 disabled:cursor-not-allowed flex items-center justify-center"
                    >
                        <template x-if="!loading">
                            <span class="flex items-center">
                                <span class="mr-2">🎉</span> Daftar Sekarang
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

                {{-- Link ke Login --}}
                <p class="mt-8 text-center text-gray-600">
                    Sudah punya akun?
                    <a href="{{ route('login') }}" class="text-purple-600 font-bold hover:text-purple-500 hover:underline transition">
                        Masuk di sini →
                    </a>
                </p>
            </div>

            {{-- Back to Home --}}
            <div class="flex justify-center">
                <a href="{{ route('landing') }}" 
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
        function registerForm() {
            return {
                name: '{{ old("name") }}',
                email: '{{ old("email") }}',
                password: '',
                passwordConfirm: '',
                showPassword: false,
                showConfirmPassword: false,
                loading: false,
                step: 1,
                get passwordStrength() {
                    let strength = 0;
                    if (this.password.length >= 8) strength++;
                    if (/[a-z]/.test(this.password) && /[A-Z]/.test(this.password)) strength++;
                    if (/\d/.test(this.password)) strength++;
                    if (/[^a-zA-Z0-9]/.test(this.password)) strength++;
                    return strength;
                },
                get passwordStrengthText() {
                    const texts = ['', 'Lemah', 'Cukup', 'Kuat', 'Sangat Kuat'];
                    return texts[this.passwordStrength] || 'Lemah';
                },
                updateStep() {
                    if (this.name && this.email && this.email.includes('@')) {
                        this.step = 2;
                    }
                    if (this.password.length >= 8 && this.password === this.passwordConfirm) {
                        this.step = 3;
                    }
                }
            }
        }
    </script>
</body>
</html>
