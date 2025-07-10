<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\PengajuanPeminjaman;
use App\Models\DetailPengajuanPeminjaman;
use App\Models\BukuWajib;
use App\Models\BukuNonWajib;
use App\Models\KategoriBuku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PengajuanPeminjamanController extends Controller
{
    public function index()
    {
        $pengajuan = PengajuanPeminjaman::with(['detailPengajuan.bukuWajib', 'detailPengajuan.bukuNonWajib'])
                                      ->where('user_id', Auth::id())
                                      ->orderBy('created_at', 'desc')
                                      ->paginate(10);

        return view('siswa.pengajuan-peminjaman.index', compact('pengajuan'));
    }

    public function create()
    {
        return view('siswa.pengajuan-peminjaman.create');
    }

    public function pilihBukuWajib()
    {
        $user = Auth::user();
        $tingkat = $user->kelas->tingkat;
        
        $bukuWajib = BukuWajib::where('tingkat', $tingkat)
                             ->where('stok', '>', 0)
                             ->get();

        return view('siswa.pengajuan-peminjaman.pilih-buku-wajib', compact('bukuWajib', 'tingkat'));
    }

    public function pilihBukuNonWajib(Request $request)
    {
        $kategori = KategoriBuku::all();
        
        $query = BukuNonWajib::with('kategori')->where('stok', '>', 0);
        
        if ($request->filled('kategori_id')) {
            $query->where('kategori_id', $request->kategori_id);
        }
        
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('judul', 'like', '%' . $request->search . '%')
                  ->orWhere('penulis', 'like', '%' . $request->search . '%');
            });
        }
        
        $bukuNonWajib = $query->paginate(12);

        return view('siswa.pengajuan-peminjaman.pilih-buku-non-wajib', compact('bukuNonWajib', 'kategori'));
    }

    public function storeBukuWajib(Request $request)
    {
        $request->validate([
            'buku_ids' => 'required|array|min:1',
            'buku_ids.*' => 'exists:buku_wajib,id'
        ]);

        try {
            DB::beginTransaction();

            // Create pengajuan peminjaman
            $pengajuan = PengajuanPeminjaman::create([
                'kode_pengajuan' => PengajuanPeminjaman::generateKodePengajuan(),
                'user_id' => Auth::id(),
                'jenis_peminjaman' => 'wajib',
                'status' => 'pending',
                'tanggal_pengajuan' => Carbon::now()
            ]);

            // Create detail pengajuan
            foreach ($request->buku_ids as $bukuId) {
                DetailPengajuanPeminjaman::create([
                    'pengajuan_peminjaman_id' => $pengajuan->id,
                    'buku_wajib_id' => $bukuId,
                    'jumlah' => 1
                ]);
            }

            DB::commit();

            return redirect()->route('siswa.pengajuan-peminjaman.show', $pengajuan->id)
                           ->with('success', 'Pengajuan peminjaman buku wajib berhasil diajukan!');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Terjadi kesalahan saat mengajukan peminjaman: ' . $e->getMessage());
        }
    }

    public function storeBukuNonWajib(Request $request)
    {
        $request->validate([
            'buku_ids' => 'required|array|min:1',
            'buku_ids.*' => 'exists:buku_non_wajib,id',
            'jumlah' => 'required|array',
            'jumlah.*' => 'integer|min:1|max:3'
        ]);

        try {
            DB::beginTransaction();

            // Create pengajuan peminjaman
            $pengajuan = PengajuanPeminjaman::create([
                'kode_pengajuan' => PengajuanPeminjaman::generateKodePengajuan(),
                'user_id' => Auth::id(),
                'jenis_peminjaman' => 'non_wajib',
                'status' => 'pending',
                'tanggal_pengajuan' => Carbon::now()
            ]);

            // Create detail pengajuan
            foreach ($request->buku_ids as $bukuId) {
                $jumlah = $request->jumlah[$bukuId] ?? 1;
                
                DetailPengajuanPeminjaman::create([
                    'pengajuan_peminjaman_id' => $pengajuan->id,
                    'buku_non_wajib_id' => $bukuId,
                    'jumlah' => $jumlah
                ]);
            }

            DB::commit();

            return redirect()->route('siswa.pengajuan-peminjaman.show', $pengajuan->id)
                           ->with('success', 'Pengajuan peminjaman buku non-wajib berhasil diajukan!');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Terjadi kesalahan saat mengajukan peminjaman: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $pengajuan = PengajuanPeminjaman::with([
                'detailPengajuan.bukuWajib', 
                'detailPengajuan.bukuNonWajib',
                'diprosesOleh'
            ])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return view('siswa.pengajuan-peminjaman.show', compact('pengajuan'));
    }

    public function cancel($id)
    {
        $pengajuan = PengajuanPeminjaman::where('user_id', Auth::id())
                                      ->where('status', 'pending')
                                      ->findOrFail($id);

        $pengajuan->update(['status' => 'dibatalkan']);

        return redirect()->route('siswa.pengajuan-peminjaman.index')
                       ->with('success', 'Pengajuan peminjaman berhasil dibatalkan!');
    }
}