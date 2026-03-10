<?php

namespace App\Http\Controllers;

/**
 * ============================================================================
 * CONTROLLER: SettingController
 * ============================================================================
 * 
 * PENJELASAN:
 * Controller untuk mengelola pengaturan sistem oleh admin.
 * Saat ini fokus pada pengaturan pajak, tapi bisa dikembangkan
 * untuk setting lainnya di masa depan.
 * ============================================================================
 */

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Halaman Pengaturan Sistem
     * GET /admin/settings
     */
    public function index()
    {
        $pajak_persen = Setting::get('pajak_persen', 0);
        $pajak_withdrawal = Setting::get('pajak_withdrawal', 5);
        
        return view('admin.settings.index', compact('pajak_persen', 'pajak_withdrawal'));
    }

    /**
     * Simpan Pengaturan Pajak
     * POST /admin/settings/pajak
     */
    public function updatePajak(Request $request)
    {
        $request->validate([
            'pajak_persen' => 'required|numeric|min:0|max:100',
            'pajak_withdrawal' => 'required|numeric|min:0|max:100',
        ], [
            'pajak_persen.required' => 'Persentase pajak transaksi harus diisi.',
            'pajak_persen.numeric' => 'Persentase pajak transaksi harus berupa angka.',
            'pajak_persen.min' => 'Persentase pajak transaksi minimal 0%.',
            'pajak_persen.max' => 'Persentase pajak transaksi maksimal 100%.',
            'pajak_withdrawal.required' => 'Persentase pajak penarikan harus diisi.',
            'pajak_withdrawal.numeric' => 'Persentase pajak penarikan harus berupa angka.',
            'pajak_withdrawal.min' => 'Persentase pajak penarikan minimal 0%.',
            'pajak_withdrawal.max' => 'Persentase pajak penarikan maksimal 100%.',
        ]);

        Setting::set(
            'pajak_persen',
            $request->pajak_persen,
            'Persentase Pajak Transaksi',
            'Persentase pajak yang akan dikenakan pada setiap transaksi'
        );
        
        Setting::set(
            'pajak_withdrawal',
            $request->pajak_withdrawal,
            'Persentase Pajak Penarikan',
            'Persentase pajak yang akan dipotong saat kantin menarik pendapatan'
        );

        return back()->with('success', 'Pengaturan pajak berhasil disimpan!');
    }
}
