<?php

namespace App\Models;

/**
 * ============================================================================
 * MODEL: Setting
 * ============================================================================
 * 
 * PENJELASAN:
 * Model untuk menyimpan konfigurasi sistem seperti pajak, dll.
 * Menggunakan key-value pair untuk fleksibilitas.
 * 
 * PENGGUNAAN:
 * - Setting::get('pajak_persen')           // Ambil nilai pajak
 * - Setting::set('pajak_persen', 15)       // Set nilai pajak
 * - Setting::get('pajak_persen', 0)        // Dengan default value
 * ============================================================================
 */

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    use HasFactory;

    /**
     * Mass Assignment Protection
     */
    protected $fillable = [
        'key',
        'value',
        'label',
        'description',
    ];

    /**
     * Cache key prefix
     */
    const CACHE_PREFIX = 'setting_';

    /**
     * Ambil nilai setting berdasarkan key
     * 
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public static function get(string $key, $default = null)
    {
        return Cache::remember(self::CACHE_PREFIX . $key, 3600, function () use ($key, $default) {
            $setting = self::where('key', $key)->first();
            return $setting ? $setting->value : $default;
        });
    }

    /**
     * Set nilai setting
     * 
     * @param string $key
     * @param mixed $value
     * @param string|null $label
     * @param string|null $description
     * @return Setting
     */
    public static function set(string $key, $value, ?string $label = null, ?string $description = null): Setting
    {
        $setting = self::updateOrCreate(
            ['key' => $key],
            [
                'value' => $value,
                'label' => $label,
                'description' => $description,
            ]
        );

        // Clear cache
        Cache::forget(self::CACHE_PREFIX . $key);

        return $setting;
    }

    /**
     * Ambil persentase pajak
     * 
     * @return float
     */
    public static function getPajakPersen(): float
    {
        return (float) self::get('pajak_persen', 0);
    }

    /**
     * Hitung pajak dari subtotal
     * 
     * @param int $subtotal
     * @return array ['persen' => float, 'nominal' => int]
     */
    public static function hitungPajak(int $subtotal): array
    {
        $persen = self::getPajakPersen();
        $nominal = (int) round($subtotal * $persen / 100);

        return [
            'persen' => $persen,
            'nominal' => $nominal,
        ];
    }
}
