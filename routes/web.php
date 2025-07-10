<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;

// Admin Controllers
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\BukuWajibController;
use App\Http\Controllers\Admin\BukuNonWajibController;
use App\Http\Controllers\Admin\KategoriBukuController;
use App\Http\Controllers\Admin\PengajuanPeminjamanController as AdminPengajuanPeminjamanController;
use App\Http\Controllers\Admin\SiswaController;
use App\Http\Controllers\Admin\KelasController;
use App\Http\Controllers\Admin\LaporanController;

// SuperAdmin Controllers
use App\Http\Controllers\SuperAdmin\DashboardController as SuperAdminDashboardController;
use App\Http\Controllers\SuperAdmin\UserController;
use App\Http\Controllers\SuperAdmin\SystemController;

// Siswa Controllers
use App\Http\Controllers\Siswa\DashboardController as SiswaDashboardController;
use App\Http\Controllers\Siswa\PengajuanPeminjamanController as SiswaPengajuanPeminjamanController;
use App\Http\Controllers\Siswa\KatalogBukuController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Redirect root to login
Route::get('/', function () {
    return redirect()->route('login');
});

// Main dashboard route (redirects based on role)
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Super Admin Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified', 'role:super_admin'])
    ->prefix('superadmin')
    ->name('superadmin.')
    ->group(function () {
        Route::get('/dashboard', [SuperAdminDashboardController::class, 'index'])->name('dashboard');
        
        // User Management
        Route::resource('users', UserController::class);
        
        // System Settings
        Route::get('/system-settings', [SystemController::class, 'index'])->name('system.index');
        Route::patch('/system-settings', [SystemController::class, 'update'])->name('system.update');
    });

/*
|--------------------------------------------------------------------------
| Admin Routes (accessible by admin and super_admin)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified', 'role:admin|super_admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        
        // Data Management
        Route::resource('siswa', SiswaController::class);
        Route::resource('kelas', KelasController::class);
        
        // Book Management
        Route::resource('buku-wajib', BukuWajibController::class);
        Route::resource('buku-non-wajib', BukuNonWajibController::class);
        Route::resource('kategori-buku', KategoriBukuController::class);
        
        // Pengajuan Peminjaman Management
        Route::prefix('pengajuan-peminjaman')->name('pengajuan-peminjaman.')->group(function () {
            Route::get('/', [AdminPengajuanPeminjamanController::class, 'index'])->name('index');
            Route::get('/{id}', [AdminPengajuanPeminjamanController::class, 'show'])->name('show');
            Route::patch('/{id}/approve', [AdminPengajuanPeminjamanController::class, 'approve'])->name('approve');
            Route::patch('/{id}/reject', [AdminPengajuanPeminjamanController::class, 'reject'])->name('reject');
        });
        
        // Reports
        Route::prefix('laporan')->name('laporan.')->group(function () {
            Route::get('/', [LaporanController::class, 'index'])->name('index');
            Route::get('/peminjaman', [LaporanController::class, 'peminjaman'])->name('peminjaman');
            Route::get('/pengembalian', [LaporanController::class, 'pengembalian'])->name('pengembalian');
            Route::get('/export-pdf', [LaporanController::class, 'exportPdf'])->name('export-pdf');
            Route::get('/export-excel', [LaporanController::class, 'exportExcel'])->name('export-excel');
        });
    });

/*
|--------------------------------------------------------------------------
| Siswa Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified', 'role:siswa'])
    ->prefix('siswa')
    ->name('siswa.')
    ->group(function () {
        Route::get('/dashboard', [SiswaDashboardController::class, 'index'])->name('dashboard');
        
        // Katalog Buku
        Route::prefix('katalog-buku')->name('katalog-buku.')->group(function () {
            Route::get('/', [KatalogBukuController::class, 'index'])->name('index');
            Route::get('/search', [KatalogBukuController::class, 'search'])->name('search');
            Route::get('/{id}', [KatalogBukuController::class, 'show'])->name('show');
        });
        
        // Pengajuan Peminjaman
        Route::prefix('pengajuan-peminjaman')->name('pengajuan-peminjaman.')->group(function () {
            Route::get('/', [SiswaPengajuanPeminjamanController::class, 'index'])->name('index');
            Route::get('/create', [SiswaPengajuanPeminjamanController::class, 'create'])->name('create');
            
            // Pilih jenis buku
            Route::get('/pilih-buku-wajib', [SiswaPengajuanPeminjamanController::class, 'pilihBukuWajib'])->name('pilih-buku-wajib');
            Route::get('/pilih-buku-non-wajib', [SiswaPengajuanPeminjamanController::class, 'pilihBukuNonWajib'])->name('pilih-buku-non-wajib');
            
            // Store pengajuan
            Route::post('/store-buku-wajib', [SiswaPengajuanPeminjamanController::class, 'storeBukuWajib'])->name('store-buku-wajib');
            Route::post('/store-buku-non-wajib', [SiswaPengajuanPeminjamanController::class, 'storeBukuNonWajib'])->name('store-buku-non-wajib');
            
            // Detail dan aksi
            Route::get('/{id}', [SiswaPengajuanPeminjamanController::class, 'show'])->name('show');
            Route::patch('/{id}/cancel', [SiswaPengajuanPeminjamanController::class, 'cancel'])->name('cancel');
        });
    });

// Include authentication routes
require __DIR__.'/auth.php';