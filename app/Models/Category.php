<?php

namespace App\Models;

/**
 * ============================================================================
 * MODEL: Category
 * ============================================================================
 * 
 * PENJELASAN:
 * Model Category merepresentasikan kategori produk di kantin.
 * Contoh: Makanan Berat, Minuman, Snack, dll.
 * 
 * RELASI ONE-TO-MANY:
 * ┌──────────────┐         ┌──────────────┐
 * │  Categories  │ 1     * │   Products   │
 * ├──────────────┤─────────├──────────────┤
 * │ id           │◄────────│ category_id  │
 * │ nama         │         │ nama         │
 * │ deskripsi    │         │ harga        │
 * └──────────────┘         └──────────────┘
 * 
 * Artinya: Satu Kategori bisa memiliki BANYAK Produk
 * 
 * CONTOH:
 * Kategori "Makanan Berat" memiliki produk:
 * - Nasi Goreng
 * - Mie Ayam
 * - Bakso
 * 
 * BEST PRACTICE:
 * - hasMany() didefinisikan di model yang memiliki primary key (Category)
 * - belongsTo() didefinisikan di model yang memiliki foreign key (Product)
 * ============================================================================
 */

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    /**
     * Nama tabel di database
     * Laravel secara default akan mencari tabel 'categories' (plural)
     * Jika nama tabel berbeda, definisikan di sini
     */
    protected $table = 'categories';

    /**
     * Mass Assignment Protection
     * Kolom yang diizinkan untuk diisi secara massal
     */
    protected $fillable = [
        'nama',
        'deskripsi',
    ];

    // ========================================================================
    // RELASI ONE-TO-MANY: Category hasMany Products
    // ========================================================================

    /**
     * Relasi: Category hasMany Products
     * 
     * PENJELASAN:
     * Satu kategori memiliki banyak produk.
     * Ini adalah sisi "One" dari relasi One-to-Many.
     * 
     * CARA KERJA:
     * Laravel akan mencari semua products dimana products.category_id = categories.id
     * 
     * PENGGUNAAN:
     * $category->products                    // Collection semua produk
     * $category->products()->count()         // Hitung jumlah produk
     * $category->products()->get()           // Sama seperti $category->products
     * $category->products()->where(...)      // Query builder
     * 
     * CONTOH:
     * $makanan = Category::find(1);
     * foreach ($makanan->products as $product) {
     *     echo $product->nama;
     * }
     * 
     * @return HasMany
     */
    public function products(): HasMany
    {
        // Parameter opsional:
        // hasMany(Model, foreign_key, local_key)
        // Default: hasMany(Product::class, 'category_id', 'id')
        return $this->hasMany(Product::class);
    }

    // ========================================================================
    // ACCESSOR (Computed Properties)
    // ========================================================================

    /**
     * Get jumlah produk dalam kategori ini
     * 
     * PENGGUNAAN:
     * echo $category->products_count; // Output: 5
     */
    public function getProductsCountAttribute(): int
    {
        return $this->products()->count();
    }

    /**
     * Get total stok semua produk dalam kategori ini
     * 
     * PENGGUNAAN:
     * echo $category->total_stock; // Output: 150
     */
    public function getTotalStockAttribute(): int
    {
        return $this->products()->sum('stok');
    }
}
