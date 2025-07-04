<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\BukuWajib;
use App\Models\BukuNonWajib;
use App\Models\Peminjaman;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:super_admin']);
    }

    public function index()
    {
        $data = [
            'total_users' => User::count(),
            'total_admin' => User::role('admin')->count(),
            'total_siswa' => User::role('siswa')->count(),
            'total_buku_wajib' => BukuWajib::count(),
            'total_buku_non_wajib' => BukuNonWajib::count(),
            'total_peminjaman' => Peminjaman::count(),
            'peminjaman_aktif' => Peminjaman::where('status', 'dipinjam')->count(),
            'peminjaman_terlambat' => Peminjaman::where('status', 'terlambat')->count(),
        ];

        return view('superadmin.dashboard', compact('data'));
    }
}
