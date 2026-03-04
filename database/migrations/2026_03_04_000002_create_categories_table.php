<?php

/**
 * ============================================================================
 * MIGRATION: Create Categories Table
 * ============================================================================
 * 
 * PENJELASAN:
 * Migration ini membuat tabel 'categories' untuk menyimpan kategori produk.
 * 
 * KONSEP ONE-TO-MANY:
 * ┌──────────────┐         ┌──────────────┐
 * │  Categories  │ 1     * │   Products   │
 * ├──────────────┤─────────├──────────────┤
 * │ id           │         │ id           │
 * │ nama         │         │ category_id  │◄── Foreign Key
 * │ deskripsi    │         │ nama         │
 * └──────────────┘         └──────────────┘
 * 
 * RELASI: Category hasMany Products
 * - 1 Kategori bisa punya BANYAK Produk
 * - Contoh: Kategori "Makanan" punya produk Nasi Goreng, Mie Ayam, dll
 * 
 * STRUKTUR TABEL:
 * - id: Primary key auto increment
 * - nama: Nama kategori (wajib diisi, unique)
 * - deskripsi: Penjelasan kategori (opsional)
 * - timestamps: created_at dan updated_at
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
        Schema::create('categories', function (Blueprint $table) {
            // Primary Key - ID unik untuk setiap kategori
            $table->id();
            
            // Nama kategori - wajib diisi dan harus unik
            // Contoh: "Makanan Berat", "Minuman", "Snack"
            $table->string('nama')->unique();
            
            // Deskripsi kategori - opsional (nullable)
            // Contoh: "Makanan berat untuk makan siang"
            $table->text('deskripsi')->nullable();
            
            // Timestamps - Laravel otomatis mengisi created_at dan updated_at
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
