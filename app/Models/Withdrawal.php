<?php

namespace App\Models;

/**
 * ============================================================================
 * MODEL: Withdrawal
 * ============================================================================
 * 
 * PENJELASAN:
 * Model untuk permintaan penarikan tunai oleh penjaga kantin.
 * Setiap penarikan dikenakan pajak yang akan masuk ke admin.
 * 
 * RELASI:
 * - belongsTo User (penjaga kantin yang request)
 * - belongsTo User (admin yang approve)
 * 
 * STATUS:
 * - pending: Menunggu approval admin
 * - approved: Disetujui dan saldo sudah dipotong
 * - rejected: Ditolak oleh admin
 * ============================================================================
 */

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Withdrawal extends Model
{
    use HasFactory;

    /**
     * Mass Assignment Protection
     */
    protected $fillable = [
        'user_id',
        'kode_withdrawal',
        'jumlah',
        'pajak_persen',
        'pajak_nominal',
        'jumlah_bersih',
        'status',
        'catatan',
        'metode_pembayaran',
        'nomor_rekening',
        'nama_bank',
        'atas_nama',
        'approved_at',
        'approved_by',
    ];

    /**
     * Attribute Casting
     */
    protected $casts = [
        'jumlah' => 'decimal:2',
        'pajak_persen' => 'decimal:2',
        'pajak_nominal' => 'decimal:2',
        'jumlah_bersih' => 'decimal:2',
        'approved_at' => 'datetime',
    ];

    // ========================================================================
    // RELASI
    // ========================================================================

    /**
     * User yang melakukan withdrawal (Penjaga Kantin)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Admin yang menyetujui withdrawal
     */
    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    // ========================================================================
    // SCOPES
    // ========================================================================

    /**
     * Filter by status
     */
    public function scopeStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Filter by user
     */
    public function scopeByUser($query, int $userId)
    {
        return $query->where('user_id', $userId);
    }

    // ========================================================================
    // HELPER METHODS
    // ========================================================================

    /**
     * Generate kode withdrawal unik
     */
    public static function generateKode(): string
    {
        $prefix = 'WD';
        $date = now()->format('Ymd');
        $random = strtoupper(substr(uniqid(), -4));
        
        return "{$prefix}{$date}{$random}";
    }

    /**
     * Hitung pajak dan jumlah bersih
     */
    public static function calculateWithTax(float $jumlah, float $pajakPersen): array
    {
        $pajakNominal = $jumlah * ($pajakPersen / 100);
        $jumlahBersih = $jumlah - $pajakNominal;

        return [
            'jumlah' => $jumlah,
            'pajak_persen' => $pajakPersen,
            'pajak_nominal' => $pajakNominal,
            'jumlah_bersih' => $jumlahBersih,
        ];
    }

    /**
     * Check if withdrawal can be processed
     */
    public function canBeProcessed(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Approve withdrawal
     * 
     * CATATAN: Tidak perlu decrement saldo user karena saldo kantin
     * dihitung dinamis dari Orders selesai - Withdrawals approved.
     * Field users.saldo digunakan untuk saldo virtual siswa.
     */
    public function approve(int $adminId, ?string $catatan = null): bool
    {
        if (!$this->canBeProcessed()) {
            return false;
        }

        // Update status withdrawal
        // Saldo kantin dihitung dari: Orders selesai - Withdrawals approved
        // Tidak perlu decrement karena approved withdrawal sudah terhitung
        $this->update([
            'status' => 'approved',
            'approved_at' => now(),
            'approved_by' => $adminId,
            'catatan' => $catatan,
        ]);

        return true;
    }

    /**
     * Reject withdrawal
     */
    public function reject(int $adminId, ?string $catatan = null): bool
    {
        if (!$this->canBeProcessed()) {
            return false;
        }

        $this->update([
            'status' => 'rejected',
            'approved_at' => now(),
            'approved_by' => $adminId,
            'catatan' => $catatan,
        ]);

        return true;
    }

    /**
     * Get status badge class
     */
    public function getStatusBadgeAttribute(): array
    {
        return match($this->status) {
            'pending' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-700', 'icon' => 'fa-clock'],
            'approved' => ['bg' => 'bg-green-100', 'text' => 'text-green-700', 'icon' => 'fa-check-circle'],
            'rejected' => ['bg' => 'bg-red-100', 'text' => 'text-red-700', 'icon' => 'fa-times-circle'],
            default => ['bg' => 'bg-gray-100', 'text' => 'text-gray-700', 'icon' => 'fa-question-circle'],
        };
    }
}
