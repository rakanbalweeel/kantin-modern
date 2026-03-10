<?php

namespace App\Models;

/**
 * ============================================================================
 * MODEL: User
 * ============================================================================
 * 
 * PENJELASAN:
 * Model User merepresentasikan pengguna sistem kantin.
 * Ada 2 role: 'admin' (pengelola kantin) dan 'siswa' (pembeli)
 * 
 * RELASI ONE-TO-MANY:
 * ┌──────────────┐         ┌──────────────┐
 * │    Users     │ 1     * │    Orders    │
 * ├──────────────┤─────────├──────────────┤
 * │ id           │◄────────│ user_id      │
 * │ name         │         │ kode_pesanan │
 * │ role         │         │ total        │
 * └──────────────┘         └──────────────┘
 * 
 * Artinya: Satu User (Siswa) bisa membuat BANYAK Pesanan
 * 
 * HELPER METHODS:
 * - isAdmin(): Mengecek apakah user adalah admin
 * - isSiswa(): Mengecek apakah user adalah siswa
 */

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Mass Assignment Protection
     * Kolom yang diizinkan untuk diisi secara massal
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'saldo',
    ];

    /**
     * Hidden Attributes - disembunyikan saat convert ke JSON/Array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Attribute Casting
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // ========================================================================
    // RELASI ONE-TO-MANY: User hasMany Orders
    // ========================================================================

    /**
     * Relasi: User hasMany Orders
     * 
     * Satu user (siswa) bisa membuat banyak pesanan.
     * 
     * PENGGUNAAN:
     * $user->orders                    // Ambil semua pesanan user
     * $user->orders()->count()         // Hitung jumlah pesanan
     * $user->orders()->latest()        // Pesanan terbaru
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    // ========================================================================
    // HELPER METHODS
    // ========================================================================

    /**
     * Cek apakah user adalah Admin
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Cek apakah user adalah Siswa
     */
    public function isSiswa(): bool
    {
        return $this->role === 'siswa';
    }

    /**
     * Cek apakah user adalah Kantin (Penjaga Kantin)
     */
    public function isKantin(): bool
    {
        return $this->role === 'kantin';
    }

    /**
     * Get total pesanan user (Accessor)
     * Penggunaan: $user->total_orders
     */
    public function getTotalOrdersAttribute(): int
    {
        return $this->orders()->count();
    }

    /**
     * Get total belanja user dalam Rupiah (Accessor)
     * Penggunaan: $user->total_spent
     */
    public function getTotalSpentAttribute(): int
    {
        return $this->orders()->where('status', 'selesai')->sum('total');
    }

    // ========================================================================
    // RELASI: User hasMany Withdrawals (untuk Penjaga Kantin)
    // ========================================================================

    /**
     * Relasi: User hasMany Withdrawals
     * Hanya untuk user dengan role 'kantin'
     */
    public function withdrawals(): HasMany
    {
        return $this->hasMany(Withdrawal::class);
    }

    /**
     * Get total pendapatan kantin (dari pesanan selesai)
     * Penggunaan: $user->total_pendapatan
     */
    public function getTotalPendapatanAttribute(): int
    {
        if (!$this->isKantin()) {
            return 0;
        }
        return Order::where('status', 'selesai')->sum('subtotal');
    }

    /**
     * Get total withdrawal yang sudah disetujui
     */
    public function getTotalWithdrawalAttribute(): int
    {
        return $this->withdrawals()->where('status', 'approved')->sum('jumlah');
    }
}
