<?php

/**
 * ============================================================================
 * MIGRATION: Create Order Details Table
 * ============================================================================
 * 
 * PENJELASAN:
 * Migration ini membuat tabel 'order_details' untuk menyimpan item-item 
 * dalam setiap pesanan (pivot table dengan data tambahan).
 * 
 * KONSEP ONE-TO-MANY (2 Relasi sekaligus):
 * 
 * ┌──────────────┐         ┌───────────────┐         ┌──────────────┐
 * │    Orders    │ 1     * │ Order_Details │ *     1 │   Products   │
 * ├──────────────┤─────────├───────────────┤─────────├──────────────┤
 * │ id           │◄────────│ order_id      │         │ id           │
 * │              │         │ product_id    │────────►│              │
 * │              │         │ jumlah        │         │              │
 * │              │         │ harga         │         │              │
 * │              │         │ subtotal      │         │              │
 * └──────────────┘         └───────────────┘         └──────────────┘
 * 
 * KENAPA ADA KOLOM 'harga'?
 * - Menyimpan harga saat transaksi terjadi
 * - Jika harga produk berubah di kemudian hari, history tetap akurat
 * - Ini adalah best practice untuk sistem e-commerce/POS
 * 
 * CONTOH DATA:
 * Order #1 (ORD-20260304-0001):
 * | order_id | product_id | jumlah | harga  | subtotal |
 * |----------|------------|--------|--------|----------|
 * | 1        | 1 (Nasi)   | 2      | 15000  | 30000    |
 * | 1        | 3 (Es Teh) | 2      | 5000   | 10000    |
 * Total pesanan = 40000
 * 
 * FOREIGN KEY CONSTRAINT:
 * - onDelete('cascade') pada order_id: jika order dihapus, detail ikut terhapus
 * - onDelete('restrict') pada product_id: produk tidak bisa dihapus jika ada di pesanan
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
        Schema::create('order_details', function (Blueprint $table) {
            // Primary Key
            $table->id();
            
            // Foreign Key ke tabel orders
            // CASCADE: Jika pesanan dihapus, semua detailnya ikut terhapus
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            
            // Foreign Key ke tabel products
            // RESTRICT: Produk tidak bisa dihapus jika masih ada di pesanan
            // Ini untuk menjaga integritas data history
            $table->foreignId('product_id')->constrained('products')->onDelete('restrict');
            
            // Jumlah produk yang dipesan
            $table->unsignedInteger('jumlah');
            
            // Harga satuan SAAT TRANSAKSI
            // Disimpan terpisah agar history tetap akurat walau harga berubah
            $table->unsignedInteger('harga');
            
            // Subtotal = jumlah × harga
            // Disimpan untuk efisiensi query (tidak perlu kalkulasi ulang)
            $table->unsignedBigInteger('subtotal');
            
            // Timestamps
            $table->timestamps();
            
            // Composite index untuk query detail pesanan
            $table->index(['order_id', 'product_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_details');
    }
};
