<?php

namespace App\Http\Requests;

/**
 * ============================================================================
 * FORM REQUEST: StoreOrderRequest
 * ============================================================================
 * 
 * PENJELASAN:
 * Request untuk validasi pembuatan pesanan oleh siswa.
 * 
 * STRUKTUR DATA YANG DIHARAPKAN:
 * {
 *     "items": [
 *         {"product_id": 1, "jumlah": 2},
 *         {"product_id": 3, "jumlah": 1}
 *     ],
 *     "catatan": "Tidak pakai sambal"
 * }
 * 
 * VALIDASI YANG DILAKUKAN:
 * 1. items: Wajib ada dan berupa array
 * 2. items.*.product_id: Setiap item harus punya product_id yang valid
 * 3. items.*.jumlah: Setiap item harus punya jumlah > 0
 * 4. catatan: Opsional
 * 
 * VALIDASI STOK dilakukan di Controller (bukan di sini)
 * karena membutuhkan logic yang lebih kompleks.
 * ============================================================================
 */

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class StoreOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Hanya siswa yang bisa membuat pesanan
        return auth()->check() && auth()->user()->isSiswa();
    }

    /**
     * Handle a failed authorization attempt.
     */
    protected function failedAuthorization()
    {
        if ($this->expectsJson()) {
            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => 'Anda tidak memiliki izin untuk membuat pesanan.'
            ], 403));
        }

        parent::failedAuthorization();
    }

    /**
     * Handle a failed validation attempt.
     */
    protected function failedValidation(Validator $validator)
    {
        if ($this->expectsJson()) {
            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
                'errors' => $validator->errors()
            ], 422));
        }

        parent::failedValidation($validator);
    }

    /**
     * Get the validation rules that apply to the request.
     * 
     * PENJELASAN RULES:
     * - array: Harus berupa array
     * - min:1: Array minimal punya 1 item
     * - items.*: Validasi untuk setiap elemen dalam array
     * - exists:products,id: product_id harus ada di tabel products
     */
    public function rules(): array
    {
        return [
            // Items harus array dengan minimal 1 item
            'items' => 'required|array|min:1',
            
            // Validasi setiap item dalam array
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.jumlah' => 'required|integer|min:1',
            
            // Catatan opsional
            'catatan' => 'nullable|string|max:500',
            
            // Waktu pengambilan pesanan
            'waktu_pengambilan' => 'required|in:istirahat_1,istirahat_2',
        ];
    }

    /**
     * Custom validation messages (Bahasa Indonesia)
     */
    public function messages(): array
    {
        return [
            'items.required' => 'Pilih minimal 1 produk.',
            'items.array' => 'Format data tidak valid.',
            'items.min' => 'Pilih minimal 1 produk.',
            'items.*.product_id.required' => 'Produk wajib dipilih.',
            'items.*.product_id.exists' => 'Produk tidak ditemukan.',
            'items.*.jumlah.required' => 'Jumlah wajib diisi.',
            'items.*.jumlah.integer' => 'Jumlah harus berupa angka.',
            'items.*.jumlah.min' => 'Jumlah minimal 1.',
            'catatan.max' => 'Catatan maksimal 500 karakter.',
            'waktu_pengambilan.required' => 'Pilih waktu pengambilan pesanan.',
            'waktu_pengambilan.in' => 'Waktu pengambilan tidak valid.',
        ];
    }

    /**
     * Custom attribute names
     */
    public function attributes(): array
    {
        return [
            'items' => 'Produk',
            'items.*.product_id' => 'Produk',
            'items.*.jumlah' => 'Jumlah',
            'catatan' => 'Catatan',
            'waktu_pengambilan' => 'Waktu Pengambilan',
        ];
    }
}
