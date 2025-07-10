<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\BukuWajib;
use App\Models\BukuNonWajib;
use App\Models\Peminjaman;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Get buku wajib berdasarkan tingkat kelas siswa
        $bukuWajibCount = 0;
        if ($user->kelas) {
            $bukuWajibCount = BukuWajib::where('tingkat', $user->kelas->tingkat)->count();
        }
        
        $data = [
            'total_buku_wajib' => $bukuWajibCount,
            'total_buku_non_wajib' => BukuNonWajib::count(),
            'peminjaman_aktif' => Peminjaman::where('siswa_id', $user->id)
                                          ->where('status', 'dipinjam')
                                          ->count(),
            'riwayat_peminjaman' => Peminjaman::where('siswa_id', $user->id)->count(),
            'peminjaman_terlambat' => Peminjaman::where('siswa_id', $user->id)
                                               ->where('status', 'terlambat')
                                               ->count(),
        ];

        return view('siswa.dashboard', compact('data'));
    }
}