<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SuperAdmin\DashboardController as SuperAdminDashboardController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Siswa\DashboardController as SiswaDashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('login');
});

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Protected Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Super Admin Routes
    Route::middleware(['role:super_admin'])->prefix('superadmin')->name('superadmin.')->group(function () {
        Route::get('/dashboard', [SuperAdminDashboardController::class, 'index'])->name('dashboard');
        
        // User Management Routes (akan ditambahkan nanti)
        // Route::resource('users', UserController::class);
        // Route::get('/system-settings', [SystemController::class, 'index'])->name('system.index');
    });
    
    // Admin Routes (accessible by admin and super_admin)
    Route::middleware(['role:admin|super_admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        
        // Admin specific routes (akan ditambahkan nanti)
        // Route::resource('siswa', SiswaController::class);
        // Route::resource('kelas', KelasController::class);
        // Route::resource('buku-wajib', BukuWajibController::class);
        // Route::resource('buku-non-wajib', BukuNonWajibController::class);
        // Route::resource('peminjaman', PeminjamanController::class);
    });
    
    // Siswa Routes
    Route::middleware(['role:siswa'])->prefix('siswa')->name('siswa.')->group(function () {
        Route::get('/dashboard', [SiswaDashboardController::class, 'index'])->name('dashboard');
        
        // Siswa specific routes (akan ditambahkan nanti)
        // Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
        // Route::get('/buku', [BukuController::class, 'index'])->name('buku.index');
        // Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman.index');
    });
});
