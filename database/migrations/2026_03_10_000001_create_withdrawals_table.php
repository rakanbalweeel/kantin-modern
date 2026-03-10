<?php

/**
 * ============================================================================
 * MIGRATION: Create Withdrawals Table
 * ============================================================================
 * 
 * PENJELASAN:
 * Tabel untuk menyimpan permintaan penarikan tunai oleh penjaga kantin.
 * Setiap penarikan akan dikenakan pajak yang masuk ke admin.
 * 
 * ALUR:
 * 1. Kantin request withdrawal
 * 2. Admin approve/reject
 * 3. Jika approve: saldo kantin berkurang, pajak tercatat
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
        Schema::create('withdrawals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('kode_withdrawal')->unique();
            $table->decimal('jumlah', 12, 2);              // Jumlah yang diminta
            $table->decimal('pajak_persen', 5, 2);         // Persentase pajak saat request
            $table->decimal('pajak_nominal', 12, 2);       // Nominal pajak
            $table->decimal('jumlah_bersih', 12, 2);       // Jumlah setelah pajak
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('catatan')->nullable();           // Catatan dari admin
            $table->string('metode_pembayaran')->nullable(); // Transfer bank, cash, dll
            $table->string('nomor_rekening')->nullable();
            $table->string('nama_bank')->nullable();
            $table->string('atas_nama')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('withdrawals');
    }
};
