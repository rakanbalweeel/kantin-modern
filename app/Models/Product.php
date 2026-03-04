<?php

namespace App\Models;

/**
 * ============================================================================
 * MODEL: Product
 * ============================================================================
 * 
 * PENJELASAN:
 * Model Product merepresentasikan produk makanan/minuman di kantin.
 * 
 * RELASI (Product terlibat dalam 2 relasi One-to-Many):
 * 
 * RELASI 1: Category hasMany Products (Product belongsTo Category)
 * ┌──────────────┐         ┌──────────────┐
 * │  Categories  │ 1     * │   Products   │
 * ├──────────────┤─────────├──────────────┤
 * │ id           │◄────────│ category_id  │ (Foreign Key)
 * └──────────────┘         └──────────────┘
 * 
 * RELASI 2: Product hasMany OrderDetails
 * ┌──────────────┐         ┌───────────────┐
 * │   Products   │ 1     * │ Order_Details │
 * ├──────────────┤─────────├───────────────┤
 * │ id           │◄────────│ product_id    │ (Foreign Key)
 * └──────────────┘         └───────────────┘
 * 
 * CONTOH DATA:
 * | id | category_id | kode   | nama           | harga | stok |
 * |----|-------------|--------|----------------|-------|------|
 * | 1  | 1           | MKN001 | Nasi Goreng    | 15000 | 50   |
 * | 2  | 1           | MKN002 | Mie Ayam       | 12000 | 30   |
 * | 3  | 2           | MNM001 | Es Teh Manis   | 5000  | 100  |
 * ============================================================================
 */

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    /**
     * Mass Assignment Protection
     */
    protected $fillable = [
        'category_id',
        'kode',
        'nama',
        'harga',
        'stok',
        'gambar',
        'deskripsi',
    ];

    /**
     * Attribute Casting
     * Mengubah tipe data saat diakses
     */
    protected $casts = [
        'harga' => 'integer',
        'stok' => 'integer',
    ];

    // ========================================================================
    // RELASI belongsTo: Product belongsTo Category
    // ========================================================================

    /**
     * Relasi: Product belongsTo Category
     * 
     * PENJELASAN:
     * Setiap produk DIMILIKI oleh satu kategori.
     * Ini adalah sisi "Many" dari relasi One-to-Many.
     * 
     * CARA KERJA:
     * Laravel akan mencari category dimana categories.id = products.category_id
     * 
     * PENGGUNAAN:
     * $product->category              // Object Category
     * $product->category->nama        // Nama kategori
     * $product->category_id           // ID kategori (foreign key)
     * 
     * CONTOH:
     * $nasiGoreng = Product::find(1);
     * echo $nasiGoreng->category->nama; // Output: "Makanan Berat"
     * 
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        // Parameter opsional:
        // belongsTo(Model, foreign_key, owner_key)
        // Default: belongsTo(Category::class, 'category_id', 'id')
        return $this->belongsTo(Category::class);
    }

    // ========================================================================
    // RELASI hasMany: Product hasMany OrderDetails
    // ========================================================================

    /**
     * Relasi: Product hasMany OrderDetails
     * 
     * PENJELASAN:
     * Satu produk bisa muncul di banyak detail pesanan.
     * Setiap kali produk dipesan, akan ada record di order_details.
     * 
     * PENGGUNAAN:
     * $product->orderDetails                    // Semua detail pesanan produk ini
     * $product->orderDetails()->count()         // Berapa kali produk ini dipesan
     * $product->orderDetails()->sum('jumlah')   // Total qty terjual
     * 
     * @return HasMany
     */
    public function orderDetails(): HasMany
    {
        return $this->hasMany(OrderDetail::class);
    }

    // ========================================================================
    // HELPER METHODS untuk Manajemen Stok
    // ========================================================================

    /**
     * Cek apakah stok tersedia
     * 
     * PENGGUNAAN:
     * if ($product->isAvailable()) { ... }
     * 
     * @return bool
     */
    public function isAvailable(): bool
    {
        return $this->stok > 0;
    }

    /**
     * Cek apakah stok mencukupi untuk jumlah tertentu
     * 
     * PENGGUNAAN:
     * if ($product->hasStock(5)) { 
     *     // Stok cukup untuk 5 item
     * }
     * 
     * @param int $quantity
     * @return bool
     */
    public function hasStock(int $quantity): bool
    {
        return $this->stok >= $quantity;
    }

    /**
     * Kurangi stok produk
     * 
     * PENGGUNAAN:
     * $product->decreaseStock(3); // Kurangi 3 stok
     * 
     * @param int $quantity
     * @return bool
     */
    public function decreaseStock(int $quantity): bool
    {
        if (!$this->hasStock($quantity)) {
            return false;
        }
        
        $this->stok -= $quantity;
        return $this->save();
    }

    /**
     * Tambah stok produk
     * 
     * PENGGUNAAN:
     * $product->increaseStock(10); // Tambah 10 stok
     * 
     * @param int $quantity
     * @return bool
     */
    public function increaseStock(int $quantity): bool
    {
        $this->stok += $quantity;
        return $this->save();
    }

    // ========================================================================
    // ACCESSOR (Computed Properties)
    // ========================================================================

    /**
     * Format harga dalam Rupiah
     * 
     * PENGGUNAAN:
     * echo $product->harga_formatted; // Output: "Rp 15.000"
     */
    public function getHargaFormattedAttribute(): string
    {
        return 'Rp ' . number_format($this->harga, 0, ',', '.');
    }

    /**
     * Get total qty terjual
     * 
     * PENGGUNAAN:
     * echo $product->total_sold; // Output: 150
     */
    public function getTotalSoldAttribute(): int
    {
        return $this->orderDetails()
            ->whereHas('order', function($query) {
                $query->where('status', 'selesai');
            })
            ->sum('jumlah');
    }

    // ========================================================================
    // SCOPE (Query Shortcuts)
    // ========================================================================

    /**
     * Scope: Hanya produk yang tersedia (stok > 0)
     * 
     * PENGGUNAAN:
     * Product::available()->get();
     */
    public function scopeAvailable($query)
    {
        return $query->where('stok', '>', 0);
    }

    /**
     * Scope: Filter berdasarkan kategori
     * 
     * PENGGUNAAN:
     * Product::byCategory(1)->get();
     */
    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }
}
