<?php

namespace App\Models;

/**
 * ============================================================================
 * MODEL: Order
 * ============================================================================
 * 
 * PENJELASAN:
 * Model Order merepresentasikan pesanan yang dibuat oleh siswa.
 * 
 * RELASI (Order terlibat dalam 2 relasi One-to-Many):
 * 
 * RELASI 1: User hasMany Orders (Order belongsTo User)
 * ┌──────────────┐         ┌──────────────┐
 * │    Users     │ 1     * │    Orders    │
 * ├──────────────┤─────────├──────────────┤
 * │ id           │◄────────│ user_id      │ (Foreign Key)
 * └──────────────┘         └──────────────┘
 * Artinya: Satu Siswa bisa membuat BANYAK Pesanan
 * 
 * RELASI 2: Order hasMany OrderDetails
 * ┌──────────────┐         ┌───────────────┐
 * │    Orders    │ 1     * │ Order_Details │
 * ├──────────────┤─────────├───────────────┤
 * │ id           │◄────────│ order_id      │ (Foreign Key)
 * └──────────────┘         └───────────────┘
 * Artinya: Satu Pesanan bisa memiliki BANYAK Item
 * 
 * CONTOH:
 * Order #ORD-20260304-0001 memiliki:
 * - 2x Nasi Goreng = Rp 30.000
 * - 1x Es Teh = Rp 5.000
 * Total = Rp 35.000
 * ============================================================================
 */

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    /**
     * Mass Assignment Protection
     */
    protected $fillable = [
        'user_id',
        'kode_pesanan',
        'subtotal',
        'pajak_persen',
        'pajak_nominal',
        'total',
        'status',
        'catatan',
        'waktu_pengambilan',
    ];

    /**
     * Attribute Casting
     */
    protected $casts = [
        'subtotal' => 'integer',
        'pajak_persen' => 'decimal:2',
        'pajak_nominal' => 'integer',
        'total' => 'integer',
        'created_at' => 'datetime',
    ];

    /**
     * Status yang tersedia
     */
    const STATUS_PENDING = 'pending';
    const STATUS_DIPROSES = 'diproses';
    const STATUS_SELESAI = 'selesai';
    const STATUS_BATAL = 'batal';

    /**
     * Waktu Pengambilan yang tersedia
     */
    const WAKTU_ISTIRAHAT_1 = 'istirahat_1';
    const WAKTU_ISTIRAHAT_2 = 'istirahat_2';

    /**
     * Get label for waktu pengambilan
     */
    public function getWaktuPengambilanLabelAttribute(): string
    {
        return match($this->waktu_pengambilan) {
            'istirahat_1' => 'Istirahat 1 (09:30 - 10:00)',
            'istirahat_2' => 'Istirahat 2 (12:00 - 12:30)',
            default => 'Istirahat 1 (09:30 - 10:00)',
        };
    }

    // ========================================================================
    // RELASI belongsTo: Order belongsTo User
    // ========================================================================

    /**
     * Relasi: Order belongsTo User
     * 
     * PENJELASAN:
     * Setiap pesanan DIMILIKI oleh satu user (siswa).
     * Ini adalah sisi "Many" dari relasi One-to-Many.
     * 
     * PENGGUNAAN:
     * $order->user              // Object User
     * $order->user->name        // Nama siswa yang memesan
     * $order->user_id           // ID user (foreign key)
     * 
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // ========================================================================
    // RELASI hasMany: Order hasMany OrderDetails
    // ========================================================================

    /**
     * Relasi: Order hasMany OrderDetails
     * 
     * PENJELASAN:
     * Satu pesanan memiliki banyak item/detail.
     * Ini adalah sisi "One" dari relasi One-to-Many.
     * 
     * PENGGUNAAN:
     * $order->orderDetails                     // Semua item dalam pesanan
     * $order->orderDetails()->count()          // Jumlah jenis produk
     * $order->orderDetails()->sum('jumlah')    // Total qty semua item
     * 
     * CONTOH:
     * foreach ($order->orderDetails as $detail) {
     *     echo $detail->product->nama . " x " . $detail->jumlah;
     * }
     * 
     * @return HasMany
     */
    public function orderDetails(): HasMany
    {
        return $this->hasMany(OrderDetail::class);
    }

    // ========================================================================
    // STATIC METHODS
    // ========================================================================

    /**
     * Generate kode pesanan unik
     * 
     * FORMAT: ORD-YYYYMMDD-XXXX
     * Contoh: ORD-20260304-0001
     * 
     * CARA KERJA:
     * 1. Ambil tanggal hari ini
     * 2. Cari kode_pesanan terakhir hari ini
     * 3. Increment untuk mendapat nomor urut
     * 
     * @return string
     */
    public static function generateKodePesanan(): string
    {
        $date = now()->format('Ymd');
        $prefix = "ORD-{$date}-";
        
        // Cari kode terakhir hari ini
        $lastOrder = self::where('kode_pesanan', 'like', $prefix . '%')
            ->orderBy('kode_pesanan', 'desc')
            ->first();
        
        if ($lastOrder) {
            // Ambil nomor dari kode terakhir dan increment
            $lastNumber = (int) substr($lastOrder->kode_pesanan, -4);
            $number = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $number = '0001';
        }
        
        return $prefix . $number;
    }

    // ========================================================================
    // HELPER METHODS
    // ========================================================================

    /**
     * Hitung ulang total dari semua detail
     * 
     * PENGGUNAAN:
     * $order->calculateTotal();
     * 
     * @return void
     */
    public function calculateTotal(): void
    {
        $this->total = $this->orderDetails()->sum('subtotal');
        $this->save();
    }

    /**
     * Cek apakah pesanan bisa dibatalkan
     * Hanya bisa batal jika masih pending
     * 
     * @return bool
     */
    public function canBeCancelled(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }

    /**
     * Update status pesanan
     * 
     * @param string $status
     * @return bool
     */
    public function updateStatus(string $status): bool
    {
        $this->status = $status;
        return $this->save();
    }

    // ========================================================================
    // ACCESSOR (Computed Properties)
    // ========================================================================

    /**
     * Format total dalam Rupiah
     * 
     * PENGGUNAAN:
     * echo $order->total_formatted; // Output: "Rp 35.000"
     */
    public function getTotalFormattedAttribute(): string
    {
        return 'Rp ' . number_format($this->total, 0, ',', '.');
    }

    /**
     * Get total item dalam pesanan
     * 
     * PENGGUNAAN:
     * echo $order->total_items; // Output: 3
     */
    public function getTotalItemsAttribute(): int
    {
        return $this->orderDetails()->sum('jumlah');
    }

    /**
     * Get label status dengan warna (Bootstrap class)
     * 
     * PENGGUNAAN:
     * echo $order->status_badge;
     */
    public function getStatusBadgeAttribute(): string
    {
        $badges = [
            'pending' => 'bg-yellow-100 text-yellow-800',
            'diproses' => 'bg-blue-100 text-blue-800',
            'selesai' => 'bg-green-100 text-green-800',
            'batal' => 'bg-red-100 text-red-800',
        ];

        $labels = [
            'pending' => 'Menunggu',
            'diproses' => 'Diproses',
            'selesai' => 'Selesai',
            'batal' => 'Dibatalkan',
        ];

        $class = $badges[$this->status] ?? 'bg-gray-100 text-gray-800';
        $label = $labels[$this->status] ?? $this->status;

        return sprintf(
            '<span class="px-2 py-1 text-xs font-medium rounded-full %s">%s</span>',
            $class,
            $label
        );
    }

    // ========================================================================
    // SCOPE (Query Shortcuts)
    // ========================================================================

    /**
     * Scope: Filter by status
     * 
     * PENGGUNAAN:
     * Order::status('pending')->get();
     */
    public function scopeStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope: Pesanan hari ini
     * 
     * PENGGUNAAN:
     * Order::today()->get();
     */
    public function scopeToday($query)
    {
        return $query->whereDate('created_at', now()->toDateString());
    }

    /**
     * Scope: Pesanan dalam rentang tanggal
     * 
     * PENGGUNAAN:
     * Order::betweenDates('2026-03-01', '2026-03-31')->get();
     */
    public function scopeBetweenDates($query, $startDate, $endDate)
    {
        return $query->whereBetween('created_at', [$startDate, $endDate . ' 23:59:59']);
    }

    /**
     * Scope: Pesanan milik user tertentu
     * 
     * PENGGUNAAN:
     * Order::forUser(1)->get();
     */
    public function scopeForUser($query, int $userId)
    {
        return $query->where('user_id', $userId);
    }
}
