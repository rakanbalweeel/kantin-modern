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
        // Topup requests with user data
        $requests = DB::table('topup_requests')
            ->join('users', 'topup_requests.user_id', '=', 'users.id')
            ->select('topup_requests.*', 'users.name', 'users.email')
            ->orderBy('topup_requests.created_at', 'desc')
            ->paginate(20);
        
        // Students list with saldo
        $students = User::where('role', 'siswa')
            ->orderBy('name')
            ->paginate(20, ['*'], 'students_page');
        
        // Count pending topups
        $pendingTopups = DB::table('topup_requests')
            ->where('status', 'pending')
            ->count();
        
        // Total saldo siswa
        $totalSaldo = User::where('role', 'siswa')->sum('saldo');
            
        return view('admin.saldo.index', compact('requests', 'students', 'pendingTopups', 'totalSaldo'));
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

    /**
     * [ADMIN] Top up saldo siswa langsung
     */
    public function adminTopup(Request $request, User $user)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1000|max:10000000',
        ], [
            'amount.required' => 'Jumlah top up harus diisi',
            'amount.min' => 'Minimal top up Rp 1.000',
            'amount.max' => 'Maksimal top up Rp 10.000.000',
        ]);

        if ($user->role !== 'siswa') {
            return back()->with('error', 'Hanya bisa top up untuk siswa');
        }

        DB::beginTransaction();
        try {
            // Tambah saldo user
            $user->increment('saldo', $request->amount);

            // Catat di topup_requests sebagai approved langsung
            DB::table('topup_requests')->insert([
                'user_id' => $user->id,
                'jumlah' => $request->amount,
                'status' => 'approved',
                'approved_at' => now(),
                'approved_by' => Auth::id(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::commit();
            return back()->with('success', "Berhasil top up Rp " . number_format($request->amount, 0, ',', '.') . " ke saldo {$user->name}");
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal top up: ' . $e->getMessage());
        }
    }
}
