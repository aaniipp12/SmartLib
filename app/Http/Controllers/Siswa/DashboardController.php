<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\BukuWajib;
use App\Models\BukuNonWajib;
use App\Models\Peminjaman;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:siswa']);
    }

    public function index()
    {
        $user = auth()->user();
        
        $data = [
            'total_buku_wajib' => BukuWajib::where('kelas_id', $user->kelas_id)->count(),
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
