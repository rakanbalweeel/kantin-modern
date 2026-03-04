<?php

namespace App\Http\Requests;

/**
 * ============================================================================
 * FORM REQUEST: StoreCategoryRequest
 * ============================================================================
 * 
 * PENJELASAN:
 * Form Request digunakan untuk memvalidasi data sebelum masuk ke controller.
 * Ini memisahkan logika validasi dari controller (Single Responsibility).
 * 
 * KEUNTUNGAN FORM REQUEST:
 * 1. Controller lebih bersih dan fokus pada business logic
 * 2. Validasi bisa di-reuse di tempat lain
 * 3. Aturan validasi terdokumentasi dengan jelas
 * 4. Laravel otomatis redirect jika validasi gagal
 * 
 * CARA KERJA:
 * 1. Request masuk → Form Request memvalidasi
 * 2. Jika valid → lanjut ke controller
 * 3. Jika invalid → redirect back dengan error messages
 * ============================================================================
 */

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * 
     * PENJELASAN:
     * Method ini mengecek apakah user berhak melakukan request ini.
     * Return true = semua user bisa, atau tambahkan logika authorization.
     */
    public function authorize(): bool
    {
        // Hanya admin yang bisa membuat kategori
        return auth()->check() && auth()->user()->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     * 
     * PENJELASAN RULES:
     * - required: Wajib diisi
     * - string: Harus berupa string
     * - max:100: Maksimal 100 karakter
     * - unique:categories,nama: Nama harus unik di tabel categories
     * - nullable: Boleh kosong
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nama' => 'required|string|max:100|unique:categories,nama',
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

    /**
     * Custom attribute names for error messages
     */
    public function attributes(): array
    {
        return [
            'nama' => 'Nama Kategori',
            'deskripsi' => 'Deskripsi',
        ];
    }
}
