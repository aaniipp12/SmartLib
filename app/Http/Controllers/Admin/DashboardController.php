<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\BukuWajib;
use App\Models\BukuNonWajib;
use App\Models\Peminjaman;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin|super_admin']);
    }

    public function index()
    {
        $data = [
            'total_siswa' => User::role('siswa')->count(),
            'total_buku_wajib' => BukuWajib::count(),
            'total_buku_non_wajib' => BukuNonWajib::count(),
            'total_peminjaman' => Peminjaman::count(),
            'peminjaman_aktif' => Peminjaman::where('status', 'dipinjam')->count(),
            'peminjaman_terlambat' => Peminjaman::where('status', 'terlambat')->count(),
            'peminjaman_hari_ini' => Peminjaman::whereDate('tanggal_pinjam', today())->count(),
        ];

        return view('admin.dashboard', compact('data'));
    }
}
