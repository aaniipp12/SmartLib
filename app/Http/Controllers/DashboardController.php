<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // Hapus __construct() method - middleware diterapkan di routes
    
    public function index()
    {
        $user = auth()->user();
        
        if ($user->hasRole('super_admin')) {
            return redirect()->route('superadmin.dashboard');
        } elseif ($user->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->hasRole('siswa')) {
            return redirect()->route('siswa.dashboard');
        }

        return view('dashboard');
    }
}