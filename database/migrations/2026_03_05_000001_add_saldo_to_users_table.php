<?php

/**
 * ============================================================================
 * MIGRATION: Add Saldo to Users Table
 * ============================================================================
 * 
 * PENJELASAN:
 * Migration ini menambahkan kolom 'saldo' ke tabel users.
 * 
 * TUJUAN:
 * - Menyimpan saldo virtual siswa untuk transaksi di kantin
 * - Saldo bisa di-topup oleh admin
 * 
 * KOLOM YANG DITAMBAHKAN:
 * - saldo: decimal(12,2) dengan default 0
 * ============================================================================
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Menambahkan kolom saldo ke tabel users
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // decimal(12,2) artinya 12 digit total, 2 digit di belakang koma
            // Contoh: 9999999999.99 (maksimal ~10 miliar rupiah)
            $table->decimal('saldo', 12, 2)->default(0)->after('role');
        });
    }

    /**
     * Reverse the migrations.
     * Menghapus kolom saldo jika migration di-rollback
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('saldo');
        });
    }
};
