<?php

/**
 * ============================================================================
 * MIGRATION: Add Tax Fields to Orders Table
 * ============================================================================
 * 
 * PENJELASAN:
 * Menambahkan kolom untuk menyimpan informasi pajak pada pesanan:
 * - subtotal: Total harga sebelum pajak
 * - pajak_persen: Persentase pajak saat pesanan dibuat
 * - pajak_nominal: Nominal pajak dalam rupiah
 * - total: Total keseluruhan (subtotal + pajak)
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
        Schema::table('orders', function (Blueprint $table) {
            $table->integer('subtotal')->default(0)->after('kode_pesanan');
            $table->decimal('pajak_persen', 5, 2)->default(0)->after('subtotal');
            $table->integer('pajak_nominal')->default(0)->after('pajak_persen');
            // Kolom 'total' sudah ada, akan diupdate untuk menyimpan subtotal + pajak
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['subtotal', 'pajak_persen', 'pajak_nominal']);
        });
    }
};
