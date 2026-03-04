<?php

namespace Database\Seeders;

/**
 * ==========================================================================
 * DATABASE SEEDER - SISTEM INFORMASI KANTIN SEKOLAH
 * ==========================================================================
 * 
 * PENJELASAN:
 * -----------
 * Seeder ini membuat data awal (dummy data) untuk testing dan demo.
 * Data yang dibuat mencakup semua entitas dalam sistem.
 * 
 * CARA MENJALANKAN:
 * -----------------
 * Terminal: php artisan db:seed
 * Atau reset semua: php artisan migrate:fresh --seed
 * 
 * DATA YANG DIBUAT:
 * -----------------
 * 1. User - 1 Admin + 3 Siswa
 * 2. Category - 4 Kategori (Makanan Berat, Makanan Ringan, Minuman, Snack)
 * 3. Product - 12 Produk (3 per kategori)
 * 4. Order - 5 Pesanan demo dengan berbagai status
 * 5. OrderDetail - Detail dari pesanan
 * 
 * RELASI ONE-TO-MANY:
 * -------------------
 * - 1 Category memiliki banyak Product
 * - 1 User memiliki banyak Order
 * - 1 Order memiliki banyak OrderDetail
 * - 1 Product memiliki banyak OrderDetail
 * ==========================================================================
 */

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // ==========================================================================
        // 1. USERS (Admin dan Siswa)
        // ==========================================================================
        /**
         * Membuat akun demo untuk login.
         * Admin: Bisa akses semua fitur pengelolaan
         * Siswa: Hanya bisa pesan dan lihat pesanan sendiri
         */
        
        // Admin Kantin
        // Note: Password otomatis di-hash oleh cast 'hashed' di Model User
        $admin = User::create([
            'name' => 'Admin Kantin',
            'email' => 'admin@kantin.com',
            'password' => 'password',
            'role' => 'admin',
        ]);
        
        // Siswa Demo 1
        $siswa1 = User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@siswa.com',
            'password' => 'password',
            'role' => 'siswa',
        ]);
        
        // Siswa Demo 2
        $siswa2 = User::create([
            'name' => 'Siti Rahayu',
            'email' => 'siti@siswa.com',
            'password' => 'password',
            'role' => 'siswa',
        ]);
        
        // Siswa Demo 3
        $siswa3 = User::create([
            'name' => 'Ahmad Pratama',
            'email' => 'ahmad@siswa.com',
            'password' => 'password',
            'role' => 'siswa',
        ]);
        
        $this->command->info('✅ Users berhasil dibuat: 1 Admin, 3 Siswa');

        // ==========================================================================
        // 2. CATEGORIES (Kategori Produk)
        // ==========================================================================
        /**
         * Kategori digunakan untuk mengelompokkan produk.
         * Relasi: 1 Category -> Many Products
         */
        
        $makananBerat = Category::create([
            'nama' => 'Makanan Berat',
            'deskripsi' => 'Menu makanan utama yang mengenyangkan',
        ]);
        
        $makananRingan = Category::create([
            'nama' => 'Makanan Ringan',
            'deskripsi' => 'Camilan dan snack ringan',
        ]);
        
        $minuman = Category::create([
            'nama' => 'Minuman',
            'deskripsi' => 'Berbagai minuman segar dan hangat',
        ]);
        
        $snack = Category::create([
            'nama' => 'Snack',
            'deskripsi' => 'Jajanan pasar dan gorengan',
        ]);
        
        $this->command->info('✅ Categories berhasil dibuat: 4 Kategori');

        // ==========================================================================
        // 3. PRODUCTS (Produk)
        // ==========================================================================
        /**
         * Setiap produk WAJIB memiliki category_id (Foreign Key).
         * Ini adalah implementasi relasi One-to-Many.
         * 
         * Product belongsTo Category
         * Category hasMany Products
         */
        
        // === Makanan Berat ===
        $mieAyam = Product::create([
            'category_id' => $makananBerat->id,
            'kode' => 'MKN001',
            'nama' => 'Mie Ayam Special',
            'harga' => 15000,
            'stok' => 50,
            'deskripsi' => 'Mie ayam dengan topping ayam suwir yang melimpah',
        ]);
        
        $nasiGoreng = Product::create([
            'category_id' => $makananBerat->id,
            'kode' => 'MKN002',
            'nama' => 'Nasi Goreng',
            'harga' => 12000,
            'stok' => 40,
            'deskripsi' => 'Nasi goreng dengan telur dan kerupuk',
        ]);
        
        $bakso = Product::create([
            'category_id' => $makananBerat->id,
            'kode' => 'MKN003',
            'nama' => 'Bakso Komplit',
            'harga' => 13000,
            'stok' => 35,
            'deskripsi' => 'Bakso dengan mie, tahu, dan siomay',
        ]);
        
        // === Makanan Ringan ===
        Product::create([
            'category_id' => $makananRingan->id,
            'kode' => 'MKR001',
            'nama' => 'Siomay',
            'harga' => 8000,
            'stok' => 30,
            'deskripsi' => 'Siomay dengan bumbu kacang',
        ]);
        
        Product::create([
            'category_id' => $makananRingan->id,
            'kode' => 'MKR002',
            'nama' => 'Batagor',
            'harga' => 8000,
            'stok' => 30,
            'deskripsi' => 'Batagor goreng dengan bumbu kacang',
        ]);
        
        Product::create([
            'category_id' => $makananRingan->id,
            'kode' => 'MKR003',
            'nama' => 'Pempek',
            'harga' => 10000,
            'stok' => 25,
            'deskripsi' => 'Pempek dengan kuah cuko',
        ]);
        
        // === Minuman ===
        $esTeh = Product::create([
            'category_id' => $minuman->id,
            'kode' => 'MNM001',
            'nama' => 'Es Teh Manis',
            'harga' => 5000,
            'stok' => 100,
            'deskripsi' => 'Teh manis dingin yang menyegarkan',
        ]);
        
        Product::create([
            'category_id' => $minuman->id,
            'kode' => 'MNM002',
            'nama' => 'Es Jeruk',
            'harga' => 6000,
            'stok' => 80,
            'deskripsi' => 'Jeruk peras segar dengan es',
        ]);
        
        Product::create([
            'category_id' => $minuman->id,
            'kode' => 'MNM003',
            'nama' => 'Susu Coklat',
            'harga' => 7000,
            'stok' => 50,
            'deskripsi' => 'Susu coklat dingin',
        ]);
        
        // === Snack ===
        Product::create([
            'category_id' => $snack->id,
            'kode' => 'SNK001',
            'nama' => 'Gorengan Campur',
            'harga' => 5000,
            'stok' => 40,
            'deskripsi' => 'Tahu, tempe, bakwan',
        ]);
        
        $risoles = Product::create([
            'category_id' => $snack->id,
            'kode' => 'SNK002',
            'nama' => 'Risoles Mayo',
            'harga' => 4000,
            'stok' => 45,
            'deskripsi' => 'Risoles isi sayur dengan mayo',
        ]);
        
        Product::create([
            'category_id' => $snack->id,
            'kode' => 'SNK003',
            'nama' => 'Pisang Goreng',
            'harga' => 3000,
            'stok' => 60,
            'deskripsi' => 'Pisang goreng crispy',
        ]);
        
        $this->command->info('✅ Products berhasil dibuat: 12 Produk dalam 4 Kategori');

        // ==========================================================================
        // 4. ORDERS & ORDER DETAILS (Pesanan Demo)
        // ==========================================================================
        /**
         * Order menyimpan informasi pesanan keseluruhan.
         * OrderDetail menyimpan produk apa saja yang dipesan.
         * 
         * Relasi:
         * - Order belongsTo User (siswa yang memesan)
         * - Order hasMany OrderDetail
         * - OrderDetail belongsTo Order
         * - OrderDetail belongsTo Product
         * 
         * Alur pembuatan pesanan:
         * 1. Buat Order dengan user_id dan total
         * 2. Buat OrderDetail untuk setiap produk yang dipesan
         * 3. Kurangi stok produk
         */
        
        // === Order 1: Budi - Selesai (kemarin) ===
        $order1 = Order::create([
            'user_id' => $siswa1->id,  // Foreign Key ke Users
            'kode_pesanan' => Order::generateKodePesanan(),
            'total' => 32000,
            'status' => 'selesai',
            'catatan' => 'Tidak pakai sambal',
            'created_at' => Carbon::yesterday(),
        ]);
        
        // Detail Order 1
        OrderDetail::create([
            'order_id' => $order1->id,      // FK ke Orders
            'product_id' => $mieAyam->id,   // FK ke Products
            'jumlah' => 1,
            'harga' => $mieAyam->harga,
            'subtotal' => $mieAyam->harga * 1,
        ]);
        
        OrderDetail::create([
            'order_id' => $order1->id,
            'product_id' => $esTeh->id,
            'jumlah' => 2,
            'harga' => $esTeh->harga,
            'subtotal' => $esTeh->harga * 2,
        ]);
        
        OrderDetail::create([
            'order_id' => $order1->id,
            'product_id' => $risoles->id,
            'jumlah' => 2,
            'harga' => $risoles->harga,
            'subtotal' => $risoles->harga * 2,
        ]);
        
        // === Order 2: Siti - Diproses (hari ini) ===
        $order2 = Order::create([
            'user_id' => $siswa2->id,
            'kode_pesanan' => Order::generateKodePesanan(),
            'total' => 25000,
            'status' => 'diproses',
            'catatan' => null,
        ]);
        
        OrderDetail::create([
            'order_id' => $order2->id,
            'product_id' => $nasiGoreng->id,
            'jumlah' => 1,
            'harga' => $nasiGoreng->harga,
            'subtotal' => $nasiGoreng->harga * 1,
        ]);
        
        OrderDetail::create([
            'order_id' => $order2->id,
            'product_id' => $bakso->id,
            'jumlah' => 1,
            'harga' => $bakso->harga,
            'subtotal' => $bakso->harga * 1,
        ]);
        
        // === Order 3: Ahmad - Pending (hari ini) ===
        $order3 = Order::create([
            'user_id' => $siswa3->id,
            'kode_pesanan' => Order::generateKodePesanan(),
            'total' => 20000,
            'status' => 'pending',
            'catatan' => 'Tambah sambal',
        ]);
        
        OrderDetail::create([
            'order_id' => $order3->id,
            'product_id' => $mieAyam->id,
            'jumlah' => 1,
            'harga' => $mieAyam->harga,
            'subtotal' => $mieAyam->harga * 1,
        ]);
        
        OrderDetail::create([
            'order_id' => $order3->id,
            'product_id' => $esTeh->id,
            'jumlah' => 1,
            'harga' => $esTeh->harga,
            'subtotal' => $esTeh->harga * 1,
        ]);
        
        // === Order 4: Budi - Selesai (2 hari lalu) ===
        $order4 = Order::create([
            'user_id' => $siswa1->id,
            'kode_pesanan' => Order::generateKodePesanan(),
            'total' => 18000,
            'status' => 'selesai',
            'created_at' => Carbon::now()->subDays(2),
        ]);
        
        OrderDetail::create([
            'order_id' => $order4->id,
            'product_id' => $nasiGoreng->id,
            'jumlah' => 1,
            'harga' => $nasiGoreng->harga,
            'subtotal' => $nasiGoreng->harga * 1,
        ]);
        
        OrderDetail::create([
            'order_id' => $order4->id,
            'product_id' => $esTeh->id,
            'jumlah' => 1,
            'harga' => $esTeh->harga,
            'subtotal' => $esTeh->harga * 1,
        ]);
        
        // === Order 5: Siti - Batal ===
        Order::create([
            'user_id' => $siswa2->id,
            'kode_pesanan' => Order::generateKodePesanan(),
            'total' => 15000,
            'status' => 'batal',
            'created_at' => Carbon::now()->subDays(3),
        ]);
        
        $this->command->info('✅ Orders berhasil dibuat: 5 Pesanan dengan berbagai status');
        
        // ==========================================================================
        // RINGKASAN DATA
        // ==========================================================================
        $this->command->newLine();
        $this->command->info('=================================');
        $this->command->info('📊 RINGKASAN DATA DEMO');
        $this->command->info('=================================');
        $this->command->info('👤 Users: ' . User::count() . ' (1 Admin, 3 Siswa)');
        $this->command->info('📁 Categories: ' . Category::count());
        $this->command->info('🍽️ Products: ' . Product::count());
        $this->command->info('📋 Orders: ' . Order::count());
        $this->command->info('📝 Order Details: ' . OrderDetail::count());
        $this->command->newLine();
        $this->command->info('🔑 AKUN LOGIN DEMO:');
        $this->command->info('   Admin: admin@kantin.com / password');
        $this->command->info('   Siswa: budi@siswa.com / password');
        $this->command->info('=================================');
    }
}