<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PengajuanPeminjaman;
use App\Models\Peminjaman;
use App\Models\DetailPeminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PengajuanPeminjamanController extends Controller
{
    public function index(Request $request)
    {
        $query = PengajuanPeminjaman::with(['user.kelas', 'detailPengajuan']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by jenis peminjaman
        if ($request->filled('jenis')) {
            $query->where('jenis_peminjaman', $request->jenis);
        }

        // Search by nama siswa or kode pengajuan
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('kode_pengajuan', 'like', '%' . $request->search . '%')
                  ->orWhereHas('user', function($userQuery) use ($request) {
                      $userQuery->where('nama', 'like', '%' . $request->search . '%')
                               ->orWhere('nis', 'like', '%' . $request->search . '%');
                  });
            });
        }

        $pengajuan = $query->orderBy('created_at', 'desc')->paginate(15);

        // Count pending pengajuan for badge
        $pendingCount = PengajuanPeminjaman::where('status', 'pending')->count();

        return view('admin.pengajuan-peminjaman.index', compact('pengajuan', 'pendingCount'));
    }

    public function show($id)
    {
        $pengajuan = PengajuanPeminjaman::with([
                'user.kelas',
                'detailPengajuan.bukuWajib', 
                'detailPengajuan.bukuNonWajib',
                'diprosesOleh'  // FIX: gunakan nama relationship yang benar
            ])
            ->findOrFail($id);

        return view('admin.pengajuan-peminjaman.show', compact('pengajuan'));
    }

    public function approve(Request $request, $id)
    {
        $request->validate([
            'catatan_admin' => 'nullable|string|max:500'
        ]);

        try {
            DB::beginTransaction();

            $pengajuan = PengajuanPeminjaman::with(['detailPengajuan', 'user'])->findOrFail($id);

            // Check if already processed
            if ($pengajuan->status !== 'pending') {
                return back()->with('error', 'Pengajuan sudah diproses sebelumnya!');
            }

            // Update pengajuan status
            $pengajuan->update([
                'status' => 'disetujui',
                'catatan_admin' => $request->catatan_admin,
                'tanggal_diproses' => Carbon::now(),
                'diproses_oleh' => Auth::id()
            ]);

            // Create peminjaman record - FIX: Properly set siswa_id and admin_id
            $peminjaman = Peminjaman::create([
                'siswa_id' => $pengajuan->user_id,  // FIX: Set siswa_id from pengajuan user_id
                'admin_id' => Auth::id(),           // FIX: Set admin_id from current admin
                'pengajuan_peminjaman_id' => $pengajuan->id,
                'tanggal_pinjam' => Carbon::now(),
                'tanggal_kembali' => Carbon::now()->addDays(7), // 7 days loan period
                'status' => 'dipinjam'
            ]);

            // Create detail peminjaman and update stock
            foreach ($pengajuan->detailPengajuan as $detail) {
                // Determine jenis_buku and buku_id
                $jenisBuku = $detail->buku_wajib_id ? 'wajib' : 'non_wajib';
                $bukuId = $detail->buku_wajib_id ?? $detail->buku_non_wajib_id;

                DetailPeminjaman::create([
                    'peminjaman_id' => $peminjaman->id,
                    'buku_id' => $bukuId,
                    'jenis_buku' => $jenisBuku,
                    'jumlah' => $detail->jumlah
                ]);

                // Update stock
                if ($detail->bukuWajib) {
                    $detail->bukuWajib->decrement('stok', $detail->jumlah);
                }
                
                if ($detail->bukuNonWajib) {
                    $detail->bukuNonWajib->decrement('stok', $detail->jumlah);
                }
            }

            // Update pengajuan status to dipinjam
            $pengajuan->update(['status' => 'dipinjam']);

            DB::commit();

            return redirect()->route('admin.pengajuan-peminjaman.index')
                           ->with('success', 'Pengajuan berhasil disetujui dan peminjaman telah dibuat!');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function reject(Request $request, $id)
    {
        $request->validate([
            'catatan_admin' => 'required|string|max:500'
        ]);

        $pengajuan = PengajuanPeminjaman::findOrFail($id);

        // Check if already processed
        if ($pengajuan->status !== 'pending') {
            return back()->with('error', 'Pengajuan sudah diproses sebelumnya!');
        }

        $pengajuan->update([
            'status' => 'ditolak',
            'catatan_admin' => $request->catatan_admin,
            'tanggal_diproses' => Carbon::now(),
            'diproses_oleh' => Auth::id()
        ]);

        return redirect()->route('admin.pengajuan-peminjaman.index')
                       ->with('success', 'Pengajuan berhasil ditolak!');
    }

    private function generateKodePeminjaman()
    {
        $prefix = 'PM';
        $date = Carbon::now()->format('Ymd');
        $lastNumber = Peminjaman::whereDate('created_at', Carbon::today())->count() + 1;
        
        return $prefix . $date . str_pad($lastNumber, 3, '0', STR_PAD_LEFT);
    }
}