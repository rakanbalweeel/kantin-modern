<?php

namespace App\Models;

/**
 * ============================================================================
 * MODEL: OrderDetail
 * ============================================================================
 * 
 * PENJELASAN:
 * Model OrderDetail merepresentasikan item-item dalam sebuah pesanan.
 * Ini adalah tabel penghubung antara Order dan Product dengan data tambahan.
 * 
 * RELASI (OrderDetail memiliki 2 relasi belongsTo):
 * 
 * RELASI 1: Order hasMany OrderDetails (OrderDetail belongsTo Order)
 * RELASI 2: Product hasMany OrderDetails (OrderDetail belongsTo Product)
 * 
 * DIAGRAM:
 * ┌──────────────┐         ┌───────────────┐         ┌──────────────┐
 * │    Orders    │ 1     * │ Order_Details │ *     1 │   Products   │
 * ├──────────────┤─────────├───────────────┤─────────├──────────────┤
 * │ id           │◄────────│ order_id      │         │ id           │
 * │ kode_pesanan │         │ product_id    │────────►│ nama         │
 * │ total        │         │ jumlah        │         │ harga        │
 * └──────────────┘         │ harga         │         └──────────────┘
 *                          │ subtotal      │
 *                          └───────────────┘
 * 
 * KENAPA MENYIMPAN 'harga' DI ORDER_DETAILS?
 * - Harga produk bisa berubah setiap saat
 * - Kita perlu menyimpan harga SAAT TRANSAKSI terjadi
 * - Ini memastikan laporan dan history tetap akurat
 * 
 * CONTOH DATA:
 * | id | order_id | product_id | jumlah | harga | subtotal |
 * |----|----------|------------|--------|-------|----------|
 * | 1  | 1        | 1          | 2      | 15000 | 30000    |
 * | 2  | 1        | 3          | 1      | 5000  | 5000     |
 * 
 * Penjelasan: Order #1 berisi 2 Nasi Goreng dan 1 Es Teh
 * ============================================================================
 */

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderDetail extends Model
{
    use HasFactory;

    /**
     * Nama tabel di database
     */
    protected $table = 'order_details';

    /**
     * Mass Assignment Protection
     */
    protected $fillable = [
        'order_id',
        'product_id',
        'jumlah',
        'harga',
        'subtotal',
    ];

    /**
     * Attribute Casting
     */
    protected $casts = [
        'jumlah' => 'integer',
        'harga' => 'integer',
        'subtotal' => 'integer',
    ];

    // ========================================================================
    // RELASI belongsTo: OrderDetail belongsTo Order
    // ========================================================================

    /**
     * Relasi: OrderDetail belongsTo Order
     * 
     * PENJELASAN:
     * Setiap detail pesanan DIMILIKI oleh satu pesanan.
     * 
     * PENGGUNAAN:
     * $detail->order                  // Object Order
     * $detail->order->kode_pesanan    // Kode pesanan
     * $detail->order->user->name      // Nama siswa (chaining relasi)
     * 
     * @return BelongsTo
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    // ========================================================================
    // RELASI belongsTo: OrderDetail belongsTo Product
    // ========================================================================

    /**
     * Relasi: OrderDetail belongsTo Product
     * 
     * PENJELASAN:
     * Setiap detail pesanan MEREFERENSIKAN satu produk.
     * 
     * PENGGUNAAN:
     * $detail->product              // Object Product
     * $detail->product->nama        // Nama produk
     * $detail->product->category    // Object Category (nested relation)
     * 
     * @return BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    // ========================================================================
    // HELPER METHODS
    // ========================================================================

    /**
     * Hitung subtotal otomatis
     * 
     * PENGGUNAAN:
     * $detail->calculateSubtotal();
     * 
     * @return void
     */
    public function calculateSubtotal(): void
    {
        $this->subtotal = $this->jumlah * $this->harga;
        $this->save();
    }

    // ========================================================================
    // ACCESSOR (Computed Properties)
    // ========================================================================

    /**
     * Format harga dalam Rupiah
     * 
     * PENGGUNAAN:
     * echo $detail->harga_formatted; // Output: "Rp 15.000"
     */
    public function getHargaFormattedAttribute(): string
    {
        return 'Rp ' . number_format($this->harga, 0, ',', '.');
    }

    /**
     * Format subtotal dalam Rupiah
     * 
     * PENGGUNAAN:
     * echo $detail->subtotal_formatted; // Output: "Rp 30.000"
     */
    public function getSubtotalFormattedAttribute(): string
    {
        return 'Rp ' . number_format($this->subtotal, 0, ',', '.');
    }

    // ========================================================================
    // MODEL EVENTS (Boot Method)
    // ========================================================================

    /**
     * Boot method untuk model events
     * 
     * PENJELASAN:
     * Method ini otomatis dipanggil saat model di-load.
     * Kita gunakan untuk menghitung subtotal otomatis sebelum save.
     */
    protected static function boot()
    {
        parent::boot();

        // Event: Sebelum data disimpan (create/update)
        static::saving(function ($detail) {
            // Auto-calculate subtotal jika belum diset
            if (empty($detail->subtotal)) {
                $detail->subtotal = $detail->jumlah * $detail->harga;
            }
        });

        // Event: Setelah data disimpan
        static::saved(function ($detail) {
            // Update total di order induk
            $detail->order->calculateTotal();
        });

        // Event: Setelah data dihapus
        static::deleted(function ($detail) {
            // Update total di order induk
            $detail->order->calculateTotal();
        });
    }
}
