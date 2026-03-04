<?php

/**
 * ============================================================================
 * MIGRATION: Create Orders Table
 * ============================================================================
 * 
 * PENJELASAN:
 * Migration ini membuat tabel 'orders' untuk menyimpan pesanan siswa.
 * 
 * KONSEP ONE-TO-MANY (2 Relasi):
 * 
 * RELASI 1: User hasMany Orders
 * ┌──────────────┐         ┌──────────────┐
 * │    Users     │ 1     * │    Orders    │
 * ├──────────────┤─────────├──────────────┤
 * │ id           │◄────────│ user_id      │
 * │ name         │         │ kode_pesanan │
 * │ role: siswa  │         │ total        │
 * └──────────────┘         └──────────────┘
 * 
 * Artinya: 1 Siswa bisa membuat BANYAK Pesanan
 * 
 * RELASI 2: Order hasMany OrderDetails
 * ┌──────────────┐         ┌───────────────┐
 * │    Orders    │ 1     * │ Order_Details │
 * ├──────────────┤─────────├───────────────┤
 * │ id           │◄────────│ order_id      │
 * │ kode_pesanan │         │ product_id    │
 * │ total        │         │ subtotal      │
 * └──────────────┘         └───────────────┘
 * 
 * Artinya: 1 Pesanan bisa punya BANYAK Item/Produk
 * 
 * STRUKTUR TABEL:
 * - id: Primary key
 * - user_id: Siswa yang memesan (foreign key)
 * - kode_pesanan: Kode unik pesanan (ORD-20260304-0001)
 * - total: Total harga semua item
 * - status: Status pesanan (pending, diproses, selesai, batal)
 * - catatan: Catatan dari siswa (opsional)
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
        Schema::create('orders', function (Blueprint $table) {
            // Primary Key
            $table->id();
            
            // Foreign Key ke tabel users
            // onDelete('cascade') = jika user dihapus, semua pesanannya ikut terhapus
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            // Kode pesanan - unik dan auto-generated
            // Format: ORD-YYYYMMDD-XXXX
            // Contoh: ORD-20260304-0001
            $table->string('kode_pesanan', 30)->unique();
            
            // Total harga pesanan (jumlah semua subtotal detail)
            $table->unsignedBigInteger('total')->default(0);
            
            // Status pesanan
            // - pending: baru dibuat, belum diproses
            // - diproses: sedang diproses/disiapkan
            // - selesai: sudah selesai/diambil
            // - batal: pesanan dibatalkan
            $table->enum('status', ['pending', 'diproses', 'selesai', 'batal'])->default('pending');
            
            // Catatan dari siswa (opsional)
            // Contoh: "Tidak pakai sambal", "Level pedas 3"
            $table->text('catatan')->nullable();
            
            // Timestamps
            $table->timestamps();
            
            // Index untuk filter berdasarkan tanggal dan status
            $table->index('created_at');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
