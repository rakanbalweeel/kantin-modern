<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * ============================================================================
 * SALDO CONTROLLER
 * ============================================================================
 * 
 * Controller untuk mengelola saldo virtual siswa.
 * Fitur:
 * - Melihat saldo
 * - Request top up (siswa)
 * - Approve top up (admin)
 * - Riwayat transaksi saldo
 * ============================================================================
 */
class SaldoController extends Controller
{
    /**
     * Tampilkan halaman saldo siswa
     */
    public function index()
    {
        $user = Auth::user();
        $riwayatTopup = DB::table('topup_requests')
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
            
        return view('siswa.saldo.index', compact('user', 'riwayatTopup'));
    }

    /**
     * Simpan request top up dari siswa
     */
    public function requestTopup(Request $request)
    {
        $request->validate([
            'jumlah' => 'required|numeric|min:10000|max:1000000',
        ], [
            'jumlah.required' => 'Jumlah top up harus diisi',
            'jumlah.min' => 'Minimal top up Rp 10.000',
            'jumlah.max' => 'Maksimal top up Rp 1.000.000',
        ]);

        DB::table('topup_requests')->insert([
            'user_id' => Auth::id(),
            'jumlah' => $request->jumlah,
            'status' => 'pending',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->with('success', 'Request top up berhasil! Silakan hubungi admin untuk konfirmasi pembayaran.');
    }

    /**
     * [ADMIN] Tampilkan semua request top up
     */
    public function adminIndex()
    {
        $requests = DB::table('topup_requests')
            ->join('users', 'topup_requests.user_id', '=', 'users.id')
            ->select('topup_requests.*', 'users.name', 'users.email')
            ->orderBy('topup_requests.created_at', 'desc')
            ->paginate(20);
            
        return view('admin.saldo.index', compact('requests'));
    }

    /**
     * [ADMIN] Approve request top up
     */
    public function approve($id)
    {
        $topup = DB::table('topup_requests')->where('id', $id)->first();
        
        if (!$topup) {
            return back()->with('error', 'Request tidak ditemukan');
        }

        if ($topup->status !== 'pending') {
            return back()->with('error', 'Request sudah diproses sebelumnya');
        }

        DB::beginTransaction();
        try {
            // Update status request
            DB::table('topup_requests')
                ->where('id', $id)
                ->update([
                    'status' => 'approved',
                    'approved_at' => now(),
                    'approved_by' => Auth::id(),
                    'updated_at' => now(),
                ]);

            // Tambah saldo user
            User::where('id', $topup->user_id)->increment('saldo', $topup->jumlah);

            DB::commit();
            return back()->with('success', 'Top up berhasil disetujui! Saldo siswa telah ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memproses: ' . $e->getMessage());
        }
    }

    /**
     * [ADMIN] Reject request top up
     */
    public function reject($id)
    {
        $topup = DB::table('topup_requests')->where('id', $id)->first();
        
        if (!$topup || $topup->status !== 'pending') {
            return back()->with('error', 'Request tidak valid');
        }

        DB::table('topup_requests')
            ->where('id', $id)
            ->update([
                'status' => 'rejected',
                'updated_at' => now(),
            ]);

        return back()->with('success', 'Request top up ditolak.');
    }
}
