<?php

namespace App\Http\Requests;

/**
 * ============================================================================
 * FORM REQUEST: UpdateCategoryRequest
 * ============================================================================
 * 
 * PENJELASAN:
 * Request untuk validasi update kategori.
 * Berbeda dengan Store, Update perlu mengabaikan ID kategori saat ini
 * untuk validasi unique (agar nama sendiri tidak dianggap duplikat).
 * ============================================================================
 */

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
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
     * PENJELASAN unique:categories,nama,{id}:
     * - categories: nama tabel
     * - nama: kolom yang dicek unique
     * - {id}: ID yang dikecualikan (kategori yang sedang diedit)
     */
    public function rules(): array
    {
        // Ambil ID kategori dari route parameter
        $categoryId = $this->route('category')->id;

        return [
            // Unique tapi ignore ID saat ini
            'nama' => 'required|string|max:100|unique:categories,nama,' . $categoryId,
            'deskripsi' => 'nullable|string|max:500',
        ];
    }

    /**
     * Custom validation messages (Bahasa Indonesia)
     */
    public function messages(): array
    {
        return [
            'nama.required' => 'Nama kategori wajib diisi.',
            'nama.max' => 'Nama kategori maksimal 100 karakter.',
            'nama.unique' => 'Nama kategori sudah digunakan.',
            'deskripsi.max' => 'Deskripsi maksimal 500 karakter.',
        ];
    }
}
