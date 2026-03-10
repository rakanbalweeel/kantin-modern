<?php

/**
 * ============================================================================
 * MIGRATION: Add Waktu Pengambilan to Orders Table
 * ============================================================================
 * 
 * PENJELASAN:
 * Menambahkan kolom waktu_pengambilan untuk pilihan siswa
 * mengambil pesanan di istirahat 1 atau istirahat 2.
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
            $table->enum('waktu_pengambilan', ['istirahat_1', 'istirahat_2'])
                  ->default('istirahat_1')
                  ->after('catatan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('waktu_pengambilan');
        });
    }
};
