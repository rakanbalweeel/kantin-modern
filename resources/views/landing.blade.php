<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RasaPelajar - Pesan Makanan Mudah & Cepat</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        .gradient-bg { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Navbar -->
    <nav class="fixed w-full bg-white/90 backdrop-blur-md shadow-sm z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <span class="text-2xl">🍽️</span>
                    <span class="ml-2 text-xl font-bold text-indigo-600">RasaPelajar</span>
                </div>
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#features" class="text-gray-600 hover:text-indigo-600">Fitur</a>
                    <a href="#menu" class="text-gray-600 hover:text-indigo-600">Menu</a>
                    <a href="#contact" class="text-gray-600 hover:text-indigo-600">Kontak</a>
                    
                    @auth
                        {{-- User sudah login --}}
                        <span class="text-gray-600">Halo, {{ auth()->user()->name }}</span>
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="text-indigo-600 font-semibold">Dashboard Admin</a>
                        @else
                            <a href="{{ route('siswa.menu') }}" class="text-indigo-600 font-semibold">Menu Kantin</a>
                        @endif
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600">Logout</button>
                        </form>
                    @else
                        {{-- User belum login --}}
                        <a href="{{ route('login') }}" class="text-indigo-600 font-semibold">Login</a>
                        <a href="{{ route('register') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">Daftar</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="gradient-bg pt-24 pb-20 md:pt-32 md:pb-32">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto">
                <div class="text-white">
                    <h1 class="text-4xl md:text-5xl font-bold leading-tight mb-6">
                        Pesan Makanan Kantin
                        <span class="text-yellow-300">Mudah & Cepat!</span>
                    </h1>
                    <p class="text-lg text-indigo-100 mb-8">
                        Tidak perlu antri lagi! Pesan makanan dan minuman favoritmu dari kantin sekolah melalui sistem online.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        @auth
                            {{-- User sudah login --}}
                            @if(auth()->user()->isAdmin())
                                <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center justify-center bg-white text-indigo-600 font-bold px-8 py-4 rounded-xl hover:bg-gray-100">
                                    Masuk Dashboard Admin
                                </a>
                            @else
                                <a href="{{ route('siswa.menu') }}" class="inline-flex items-center justify-center bg-white text-indigo-600 font-bold px-8 py-4 rounded-xl hover:bg-gray-100">
                                    Pesan Sekarang
                                </a>
                                <a href="{{ route('siswa.orders.index') }}" class="inline-flex items-center justify-center border-2 border-white text-white font-bold px-8 py-4 rounded-xl hover:bg-white/10">
                                    Lihat Pesanan Saya
                                </a>
                            @endif
                        @else
                            {{-- User belum login --}}
                            <a href="{{ route('register') }}" class="inline-flex items-center justify-center bg-white text-indigo-600 font-bold px-8 py-4 rounded-xl hover:bg-gray-100">
                                Daftar Sekarang
                            </a>
                            <a href="{{ route('login') }}" class="inline-flex items-center justify-center border-2 border-white text-white font-bold px-8 py-4 rounded-xl hover:bg-white/10">
                                Sudah Punya Akun? Login
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-gray-800 mb-4">Kenapa Pakai Kantin Online?</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Nikmati kemudahan pesan makanan kantin tanpa repot</p>
            </div>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="bg-gray-50 rounded-2xl p-8 text-center hover:shadow-lg transition">
                    <div class="w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <span class="text-3xl">⚡</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Cepat & Mudah</h3>
                    <p class="text-gray-600">Pesan dari HP, tidak perlu antri. Makanan siap saat istirahat!</p>
                </div>
                <div class="bg-gray-50 rounded-2xl p-8 text-center hover:shadow-lg transition">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <span class="text-3xl">📋</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Menu Lengkap</h3>
                    <p class="text-gray-600">Lihat semua menu kantin, harga, dan ketersediaan stok langsung.</p>
                </div>
                <div class="bg-gray-50 rounded-2xl p-8 text-center hover:shadow-lg transition">
                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <span class="text-3xl">📝</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Riwayat Pesanan</h3>
                    <p class="text-gray-600">Lihat semua pesanan sebelumnya dan pesan ulang dengan mudah.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Menu Preview -->
    <section id="menu" class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-gray-800 mb-4">Menu Populer</h2>
                <p class="text-gray-600">Beberapa menu favorit di kantin sekolah</p>
            </div>
            <div class="grid md:grid-cols-4 gap-6">
                @foreach([
                    ['🍜', 'Mie Ayam', 'Rp 12.000'],
                    ['🍛', 'Nasi Goreng', 'Rp 15.000'],
                    ['🍲', 'Bakso', 'Rp 13.000'],
                    ['🧃', 'Es Teh Manis', 'Rp 5.000'],
                ] as $item)
                <div class="bg-white rounded-xl p-6 shadow-md hover:shadow-lg transition text-center">
                    <span class="text-5xl">{{ $item[0] }}</span>
                    <h3 class="text-lg font-bold text-gray-800 mt-4">{{ $item[1] }}</h3>
                    <p class="text-indigo-600 font-semibold mt-2">{{ $item[2] }}</p>
                </div>
                @endforeach
            </div>
            <div class="text-center mt-12">
                <a href="{{ route('register') }}" class="inline-flex items-center bg-indigo-600 text-white px-8 py-4 rounded-xl font-bold hover:bg-indigo-700">
                    Lihat Menu Lengkap <span class="ml-2">→</span>
                </a>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="gradient-bg py-20">
        <div class="max-w-4xl mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold text-white mb-6">Siap Pesan Makanan?</h2>
            <p class="text-xl text-indigo-100 mb-8">Daftar sekarang dan nikmati kemudahan pesan makanan kantin!</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('register') }}" class="bg-white text-indigo-600 font-bold px-8 py-4 rounded-xl hover:bg-gray-100">
                    Daftar Sebagai Siswa
                </a>
                <a href="{{ route('login') }}" class="border-2 border-white text-white font-bold px-8 py-4 rounded-xl hover:bg-white/10">
                    Login
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer id="contact" class="bg-gray-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-3 gap-8">
                <div>
                    <div class="flex items-center space-x-2 mb-4">
                        <span class="text-2xl">🍽️</span>
                        <span class="text-xl font-bold">RasaPelajar</span>
                    </div>
                    <p class="text-gray-400">Sistem informasi kantin untuk kemudahan pesan makanan di sekolah.</p>
                </div>
                <div>
                    <h4 class="font-bold mb-4">Kontak</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li>📍 Jl. Pendidikan No. 123</li>
                        <li>📞 (021) 123-4567</li>
                        <li>📧 kantin@sekolah.sch.id</li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold mb-4">Demo Account</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><strong>Admin:</strong> admin@kantin.com</li>
                        <li><strong>Siswa:</strong> siswa@kantin.com</li>
                        <li><strong>Password:</strong> password</li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; {{ date('Y') }} RasaPelajar. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>
