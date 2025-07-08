@extends('layouts.dashboard')

@section('title', 'Super Admin Dashboard - SmartLib')
@section('page-title', 'Super Admin Dashboard')

@section('content')
    <!-- Stats Cards -->
    <div class="stats-grid">
        <div class="stats-card primary">
            <div class="stats-header">
                <div>
                    <div class="stats-number">{{ $data['total_users'] }}</div>
                    <div class="stats-label">Total Users</div>
                </div>
                <div class="stats-icon">
                    <i class="bi bi-people"></i>
                </div>
            </div>
            <div class="stats-change positive">
                <i class="bi bi-arrow-up"></i> +12% dari bulan lalu
            </div>
        </div>

        <div class="stats-card success">
            <div class="stats-header">
                <div>
                    <div class="stats-number">{{ $data['total_admin'] }}</div>
                    <div class="stats-label">Total Admin</div>
                </div>
                <div class="stats-icon">
                    <i class="bi bi-person-badge"></i>
                </div>
            </div>
            <div class="stats-change positive">
                <i class="bi bi-arrow-up"></i> +5% dari bulan lalu
            </div>
        </div>

        <div class="stats-card warning">
            <div class="stats-header">
                <div>
                    <div class="stats-number">{{ $data['total_siswa'] }}</div>
                    <div class="stats-label">Total Siswa</div>
                </div>
                <div class="stats-icon">
                    <i class="bi bi-person-check"></i>
                </div>
            </div>
            <div class="stats-change positive">
                <i class="bi bi-arrow-up"></i> +8% dari bulan lalu
            </div>
        </div>

        <div class="stats-card info">
            <div class="stats-header">
                <div>
                    <div class="stats-number">{{ $data['total_buku_wajib'] + $data['total_buku_non_wajib'] }}</div>
                    <div class="stats-label">Total Buku</div>
                </div>
                <div class="stats-icon">
                    <i class="bi bi-book"></i>
                </div>
            </div>
            <div class="stats-change positive">
                <i class="bi bi-arrow-up"></i> +15% dari bulan lalu
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <!-- Peminjaman Stats -->
            <div class="chart-card">
                <div class="chart-header">
                    <h5 class="chart-title">Statistik Peminjaman</h5>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button"
                            data-bs-toggle="dropdown">
                            Bulan Ini
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Hari Ini</a></li>
                            <li><a class="dropdown-item" href="#">Minggu Ini</a></li>
                            <li><a class="dropdown-item" href="#">Bulan Ini</a></li>
                        </ul>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 text-center">
                        <div class="stats-number text-primary">{{ $data['total_peminjaman'] }}</div>
                        <div class="stats-label">Total Peminjaman</div>
                    </div>
                    <div class="col-md-4 text-center">
                        <div class="stats-number text-success">{{ $data['peminjaman_aktif'] }}</div>
                        <div class="stats-label">Peminjaman Aktif</div>
                    </div>
                    <div class="col-md-4 text-center">
                        <div class="stats-number text-danger">{{ $data['peminjaman_terlambat'] }}</div>
                        <div class="stats-label">Terlambat</div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="chart-card">
                <div class="chart-header">
                    <h5 class="chart-title">Aksi Cepat</h5>
                </div>

                <div class="quick-actions">
                    <a href="#" class="action-btn primary">
                        <i class="bi bi-person-plus"></i>
                        <span>Tambah User</span>
                    </a>
                    <a href="#" class="action-btn success">
                        <i class="bi bi-book-half"></i>
                        <span>Tambah Buku</span>
                    </a>
                    <a href="#" class="action-btn warning">
                        <i class="bi bi-gear"></i>
                        <span>Pengaturan</span>
                    </a>
                    <a href="#" class="action-btn info">
                        <i class="bi bi-file-text"></i>
                        <span>Laporan</span>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Profile Card -->
            <div class="profile-card">
                <div class="profile-avatar">
                    {{ strtoupper(substr(auth()->user()->nama, 0, 1)) }}
                </div>
                <div class="profile-name">{{ auth()->user()->nama }}</div>
                <div class="profile-role">Super Administrator</div>
            </div>

            <!-- System Info -->
            <div class="chart-card">
                <div class="chart-header">
                    <h5 class="chart-title">Informasi Sistem</h5>
                </div>

                <ul class="info-list">
                    <li class="info-item">
                        <span class="info-label">Versi Sistem</span>
                        <span class="badge primary">v1.0.0</span>
                    </li>
                    <li class="info-item">
                        <span class="info-label">Status Database</span>
                        <span class="badge success">Online</span>
                    </li>
                    <li class="info-item">
                        <span class="info-label">Backup Terakhir</span>
                        <span class="info-value">{{ date('d/m/Y H:i') }}</span>
                    </li>
                    <li class="info-item">
                        <span class="info-label">Storage</span>
                        <span class="info-value">2.5 GB / 10 GB</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endsection
