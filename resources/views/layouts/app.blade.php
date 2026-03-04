<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'RasaPelajar') - Sistem Informasi Kantin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>[x-cloak] { display: none !important; }</style>
    @stack('styles')
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('landing') }}" class="flex items-center space-x-2">
                        <span class="text-2xl">🍽️</span>
                        <span class="text-xl font-bold text-indigo-600">RasaPelajar</span>
                    </a>
                </div>
                
                <div class="hidden md:flex items-center space-x-4">
                    @auth
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="px-3 py-2 text-gray-600 hover:text-indigo-600 {{ request()->routeIs('admin.dashboard') ? 'text-indigo-600 font-semibold' : '' }}">
                                <i class="fas fa-chart-line mr-1"></i> Dashboard
                            </a>
                            <a href="{{ route('admin.categories.index') }}" class="px-3 py-2 text-gray-600 hover:text-indigo-600 {{ request()->routeIs('admin.categories.*') ? 'text-indigo-600 font-semibold' : '' }}">
                                <i class="fas fa-tags mr-1"></i> Kategori
                            </a>
                            <a href="{{ route('admin.products.index') }}" class="px-3 py-2 text-gray-600 hover:text-indigo-600 {{ request()->routeIs('admin.products.*') ? 'text-indigo-600 font-semibold' : '' }}">
                                <i class="fas fa-utensils mr-1"></i> Produk
                            </a>
                            <a href="{{ route('admin.orders.index') }}" class="px-3 py-2 text-gray-600 hover:text-indigo-600 {{ request()->routeIs('admin.orders.*') ? 'text-indigo-600 font-semibold' : '' }}">
                                <i class="fas fa-shopping-cart mr-1"></i> Pesanan
                            </a>
                            <a href="{{ route('admin.reports.sales') }}" class="px-3 py-2 text-gray-600 hover:text-indigo-600 {{ request()->routeIs('admin.reports.*') ? 'text-indigo-600 font-semibold' : '' }}">
                                <i class="fas fa-chart-bar mr-1"></i> Laporan
                            </a>
                        @else
                            <a href="{{ route('siswa.menu') }}" class="px-3 py-2 text-gray-600 hover:text-indigo-600 {{ request()->routeIs('siswa.menu') ? 'text-indigo-600 font-semibold' : '' }}">
                                <i class="fas fa-utensils mr-1"></i> Menu
                            </a>
                            <a href="{{ route('siswa.cart') }}" class="px-3 py-2 text-gray-600 hover:text-indigo-600 {{ request()->routeIs('siswa.cart') ? 'text-indigo-600 font-semibold' : '' }}">
                                <i class="fas fa-shopping-cart mr-1"></i> Keranjang
                            </a>
                            <a href="{{ route('siswa.orders.index') }}" class="px-3 py-2 text-gray-600 hover:text-indigo-600 {{ request()->routeIs('siswa.orders.*') ? 'text-indigo-600 font-semibold' : '' }}">
                                <i class="fas fa-history mr-1"></i> Riwayat
                            </a>
                        @endif
                    @endauth
                </div>
                
                <div class="flex items-center">
                    @auth
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center space-x-2 text-gray-700 hover:text-indigo-600">
                                <div class="w-8 h-8 bg-indigo-100 rounded-full flex items-center justify-center">
                                    <span class="text-indigo-600 font-semibold text-sm">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                                </div>
                                <span class="hidden md:block">{{ auth()->user()->name }}</span>
                                <i class="fas fa-chevron-down text-xs"></i>
                            </button>
                            <div x-show="open" @click.away="open = false" x-cloak class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 z-50">
                                <div class="px-4 py-2 border-b">
                                    <p class="text-sm font-semibold text-gray-800">{{ auth()->user()->name }}</p>
                                    <p class="text-xs text-gray-500">{{ auth()->user()->email }}</p>
                                    <span class="inline-block mt-1 px-2 py-0.5 text-xs rounded-full {{ auth()->user()->isAdmin() ? 'bg-red-100 text-red-600' : 'bg-green-100 text-green-600' }}">
                                        {{ auth()->user()->isAdmin() ? 'Admin' : 'Siswa' }}
                                    </span>
                                </div>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                        <i class="fas fa-sign-out-alt mr-2"></i> Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="px-4 py-2 text-gray-600 hover:text-indigo-600">Login</a>
                        <a href="{{ route('register') }}" class="ml-2 px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">Daftar</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)">
                <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
                <button @click="show = false" class="float-right"><i class="fas fa-times"></i></button>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg">
                <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
            </div>
        </div>
    @endif

    @if($errors->any())
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <!-- Main Content -->
    <main class="flex-grow max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 text-center text-gray-500 text-sm">
            &copy; {{ date('Y') }} RasaPelajar. Sistem Informasi Kantin.
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
