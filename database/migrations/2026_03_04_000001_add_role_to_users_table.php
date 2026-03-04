<?php

/**
 * ============================================================================
 * MIGRATION: Add Role to Users Table
 * ============================================================================
 * 
 * PENJELASAN:
 * Migration ini menambahkan kolom 'role' ke tabel users yang sudah ada.
 * 
 * TUJUAN:
 * - Membedakan antara Admin (pengelola kantin) dan Siswa (pembeli)
 * - Role digunakan untuk pembatasan akses (authorization)
 * 
 * KOLOM YANG DITAMBAHKAN:
 * - role: enum('admin', 'siswa') dengan default 'siswa'
 * 
 * ALUR KERJA:
 * 1. User baru register → otomatis jadi 'siswa'
 * 2. Admin dibuat manual melalui seeder atau ubah di database
 * ============================================================================
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Menambahkan kolom role ke tabel users
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Menambahkan kolom role setelah kolom email
            // enum() membatasi nilai yang valid hanya 'admin' atau 'siswa'
            // default('siswa') berarti jika tidak diisi, otomatis jadi siswa
            $table->enum('role', ['admin', 'siswa'])->default('siswa')->after('email');
        });
    }

    /**
     * Reverse the migrations.
     * Menghapus kolom role jika migration di-rollback
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });
    }
};
