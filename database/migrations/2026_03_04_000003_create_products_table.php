<?php

/**
 * ============================================================================
 * MIGRATION: Create Products Table
 * ============================================================================
 * 
 * PENJELASAN:
 * Migration ini membuat tabel 'products' untuk menyimpan data produk kantin.
 * 
 * KONSEP ONE-TO-MANY (2 Relasi):
 * 
 * RELASI 1: Category hasMany Products
 * ┌──────────────┐         ┌──────────────┐
 * │  Categories  │ 1     * │   Products   │
 * ├──────────────┤─────────├──────────────┤
 * │ id           │◄────────│ category_id  │
 * └──────────────┘         └──────────────┘
 * 
 * RELASI 2: Product hasMany OrderDetails
 * ┌──────────────┐         ┌───────────────┐
 * │   Products   │ 1     * │ Order_Details │
 * ├──────────────┤─────────├───────────────┤
 * │ id           │◄────────│ product_id    │
 * └──────────────┘         └───────────────┘
 * 
 * STRUKTUR TABEL:
 * - id: Primary key
 * - category_id: Foreign key ke tabel categories
 * - nama: Nama produk
 * - kode: Kode unik produk (untuk pencarian cepat)
 * - harga: Harga jual
 * - stok: Jumlah stok tersedia
 * - gambar: Path file gambar produk
 * - deskripsi: Penjelasan produk
 * ============================================================================
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            // Primary Key
            $table->id();
            
            // Foreign Key ke tabel categories
            // foreignId() otomatis membuat kolom category_id (bigint unsigned)
            // constrained() menambahkan foreign key constraint ke tabel 'categories'
            // onDelete('cascade') = jika kategori dihapus, semua produk ikut terhapus
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            
            // Kode produk - unik untuk identifikasi
            // Contoh: "MKN001", "MNM001"
            $table->string('kode', 20)->unique();
            
            // Nama produk
            // Contoh: "Nasi Goreng Spesial"
            $table->string('nama');
            
            // Harga dalam rupiah (tanpa desimal)
            // unsignedInteger karena harga tidak mungkin negatif
            $table->unsignedInteger('harga');
            
            // Stok produk
            // unsignedInteger karena stok tidak mungkin negatif
            // default(0) jika tidak diisi, stok = 0
            $table->unsignedInteger('stok')->default(0);
            
            // Path gambar produk (opsional)
            // Contoh: "products/nasi-goreng.jpg"
            $table->string('gambar')->nullable();
            
            // Deskripsi produk (opsional)
            $table->text('deskripsi')->nullable();
            
            // Timestamps
            $table->timestamps();
            
            // Index untuk pencarian cepat berdasarkan nama
            $table->index('nama');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
