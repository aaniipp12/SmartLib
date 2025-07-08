<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SuperAdmin\DashboardController as SuperAdminDashboardController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Siswa\DashboardController as SiswaDashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('login');
});

// Main dashboard route (will redirect based on role)
// Middleware diterapkan di sini, bukan di controller
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Profile routes (from Breeze)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Super Admin Routes
// Middleware diterapkan di route group, bukan di controller
Route::middleware(['auth', 'verified', 'role:super_admin'])->prefix('superadmin')->name('superadmin.')->group(function () {
    Route::get('/dashboard', [SuperAdminDashboardController::class, 'index'])->name('dashboard');
    
    // User Management Routes (akan ditambahkan nanti)
    // Route::resource('users', UserController::class);
    // Route::get('/system-settings', [SystemController::class, 'index'])->name('system.index');
});

// Admin Routes (accessible by admin and super_admin)
// Middleware diterapkan di route group, bukan di controller
Route::middleware(['auth', 'verified', 'role:admin|super_admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // Admin specific routes (akan ditambahkan nanti)
    // Route::resource('siswa', SiswaController::class);
    // Route::resource('kelas', KelasController::class);
    // Route::resource('buku-wajib', BukuWajibController::class);
    // Route::resource('buku-non-wajib', BukuNonWajibController::class);
    // Route::resource('peminjaman', PeminjamanController::class);
});

// Siswa Routes
// Middleware diterapkan di route group, bukan di controller
Route::middleware(['auth', 'verified', 'role:siswa'])->prefix('siswa')->name('siswa.')->group(function () {
    Route::get('/dashboard', [SiswaDashboardController::class, 'index'])->name('dashboard');
    
    // Siswa specific routes (akan ditambahkan nanti)
    // Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    // Route::get('/buku', [BukuController::class, 'index'])->name('buku.index');
    // Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman.index');
});

// Include Breeze auth routes
require __DIR__.'/auth.php';