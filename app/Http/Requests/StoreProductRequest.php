<?php

namespace App\Http\Requests;

/**
 * ============================================================================
 * FORM REQUEST: StoreProductRequest
 * ============================================================================
 * 
 * PENJELASAN:
 * Request untuk validasi pembuatan produk baru.
 * 
 * VALIDASI YANG DILAKUKAN:
 * 1. category_id: Harus valid dan ada di tabel categories
 * 2. kode: Harus unik untuk identifikasi produk
 * 3. nama: Wajib diisi
 * 4. harga: Harus angka positif
 * 5. stok: Harus angka >= 0
 * 6. gambar: Opsional, harus file gambar
 * ============================================================================
 */

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     * 
     * PENJELASAN RULES:
     * - exists:categories,id: Memastikan category_id ada di tabel categories
     * - min:0: Nilai minimum
     * - image: Harus file gambar (jpg, jpeg, png, bmp, gif, svg, webp)
     * - mimes: Membatasi tipe file yang diizinkan
     * - max:2048: Maksimal ukuran file 2MB (dalam KB)
     */
    public function rules(): array
    {
        return [
            'category_id' => 'required|exists:categories,id',
            'kode' => 'required|string|max:20|unique:products,kode',
            'nama' => 'required|string|max:255',
            'harga' => 'required|integer|min:0',
            'stok' => 'required|integer|min:0',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'deskripsi' => 'nullable|string|max:1000',
        ];
    }

    /**
     * Custom validation messages (Bahasa Indonesia)
     */
    public function messages(): array
    {
        return [
            'category_id.required' => 'Kategori wajib dipilih.',
            'category_id.exists' => 'Kategori tidak valid.',
            'kode.required' => 'Kode produk wajib diisi.',
            'kode.unique' => 'Kode produk sudah digunakan.',
            'kode.max' => 'Kode produk maksimal 20 karakter.',
            'nama.required' => 'Nama produk wajib diisi.',
            'nama.max' => 'Nama produk maksimal 255 karakter.',
            'harga.required' => 'Harga wajib diisi.',
            'harga.integer' => 'Harga harus berupa angka.',
            'harga.min' => 'Harga tidak boleh negatif.',
            'stok.required' => 'Stok wajib diisi.',
            'stok.integer' => 'Stok harus berupa angka.',
            'stok.min' => 'Stok tidak boleh negatif.',
            'gambar.image' => 'File harus berupa gambar.',
            'gambar.mimes' => 'Format gambar harus: jpg, jpeg, png, atau webp.',
            'gambar.max' => 'Ukuran gambar maksimal 2MB.',
            'deskripsi.max' => 'Deskripsi maksimal 1000 karakter.',
        ];
    }

    /**
     * Custom attribute names
     */
    public function attributes(): array
    {
        return [
            'category_id' => 'Kategori',
            'kode' => 'Kode Produk',
            'nama' => 'Nama Produk',
            'harga' => 'Harga',
            'stok' => 'Stok',
            'gambar' => 'Gambar',
            'deskripsi' => 'Deskripsi',
        ];
    }
}
