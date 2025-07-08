@extends('layouts.dashboard')

@section('title', 'Admin Dashboard - SmartLib')
@section('page-title', 'Admin Dashboard')

@section('content')
    <!-- Stats Cards -->
    <div class="stats-grid">
        <div class="stats-card primary">
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

        <div class="stats-card success">
            <div class="stats-header">
                <div>
                    <div class="stats-number">{{ $data['total_buku_wajib'] }}</div>
                    <div class="stats-label">Buku Wajib</div>
                </div>
                <div class="stats-icon">
                    <i class="bi bi-book"></i>
                </div>
            </div>
            <div class="stats-change positive">
                <i class="bi bi-arrow-up"></i> +5% dari bulan lalu
            </div>
        </div>

        <div class="stats-card purple">
            <div class="stats-header">
                <div>
                    <div class="stats-number">{{ $data['total_buku_non_wajib'] }}</div>
                    <div class="stats-label">Buku Non-Wajib</div>
                </div>
                <div class="stats-icon">
                    <i class="bi bi-journal"></i>
                </div>
            </div>
            <div class="stats-change positive">
                <i class="bi bi-arrow-up"></i> +12% dari bulan lalu
            </div>
        </div>

        <div class="stats-card danger">
            <div class="stats-header">
                <div>
                    <div class="stats-number">{{ $data['peminjaman_terlambat'] }}</div>
                    <div class="stats-label">Terlambat</div>
                </div>
                <div class="stats-icon">
                    <i class="bi bi-exclamation-triangle"></i>
                </div>
            </div>
            <div class="stats-change negative">
                <i class="bi bi-arrow-down"></i> -3% dari bulan lalu
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <!-- Aktivitas Peminjaman -->
            <div class="chart-card">
                <div class="chart-header">
                    <h5 class="chart-title">Aktivitas Peminjaman Hari Ini</h5>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button"
                            data-bs-toggle="dropdown">
                            Hari Ini
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Hari Ini</a></li>
                            <li><a class="dropdown-item" href="#">Minggu Ini</a></li>
                            <li><a class="dropdown-item" href="#">Bulan Ini</a></li>
                        </ul>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3 text-center">
                        <div class="stats-number text-info">{{ $data['peminjaman_hari_ini'] }}</div>
                        <div class="stats-label">Peminjaman Hari Ini</div>
                    </div>
                    <div class="col-md-3 text-center">
                        <div class="stats-number text-success">{{ $data['peminjaman_aktif'] }}</div>
                        <div class="stats-label">Peminjaman Aktif</div>
                    </div>
                    <div class="col-md-3 text-center">
                        <div class="stats-number text-primary">{{ $data['total_peminjaman'] }}</div>
                        <div class="stats-label">Total Peminjaman</div>
                    </div>
                    <div class="col-md-3 text-center">
                        <div class="stats-number text-danger">{{ $data['peminjaman_terlambat'] }}</div>
                        <div class="stats-label">Terlambat</div>
                    </div>
                </div>
            </div>

            <!-- Recent Activities -->
            <div class="chart-card">
                <div class="chart-header">
                    <h5 class="chart-title">Aktivitas Terbaru</h5>
                    <a href="#" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
                </div>

                <div class="activity-list">
                    <div class="activity-item">
                        <div class="activity-icon bg-primary">
                            <i class="bi bi-book"></i>
                        </div>
                        <div class="activity-content">
                            <div class="activity-title">Peminjaman buku "Matematika Kelas 7"</div>
                            <div class="activity-time">2 menit yang lalu</div>
                        </div>
                    </div>

                    <div class="activity-item">
                        <div class="activity-icon bg-success">
                            <i class="bi bi-arrow-return-left"></i>
                        </div>
                        <div class="activity-content">
                            <div class="activity-title">Pengembalian buku "IPA Terpadu"</div>
                            <div class="activity-time">15 menit yang lalu</div>
                        </div>
                    </div>

                    <div class="activity-item">
                        <div class="activity-icon bg-warning">
                            <i class="bi bi-person-plus"></i>
                        </div>
                        <div class="activity-content">
                            <div class="activity-title">Siswa baru terdaftar</div>
                            <div class="activity-time">1 jam yang lalu</div>
                        </div>
                    </div>
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
                <div class="profile-role">Administrator</div>
            </div>

            <!-- Quick Actions -->
            <div class="chart-card">
                <div class="chart-header">
                    <h5 class="chart-title">Menu Cepat</h5>
                </div>

                <div class="quick-actions">
                    <a href="#" class="action-btn primary">
                        <i class="bi bi-plus-circle"></i>
                        <span>Peminjaman Baru</span>
                    </a>
                    <a href="#" class="action-btn success">
                        <i class="bi bi-arrow-return-left"></i>
                        <span>Pengembalian</span>
                    </a>
                    <a href="#" class="action-btn info">
                        <i class="bi bi-book"></i>
                        <span>Tambah Buku</span>
                    </a>
                    <a href="#" class="action-btn warning">
                        <i class="bi bi-file-text"></i>
                        <span>Laporan</span>
                    </a>
                </div>
            </div>

            <!-- Today's Summary -->
            <div class="chart-card">
                <div class="chart-header">
                    <h5 class="chart-title">Ringkasan Hari Ini</h5>
                </div>

                <ul class="info-list">
                    <li class="info-item">
                        <span class="info-label">Peminjaman Baru</span>
                        <span class="badge primary">{{ $data['peminjaman_hari_ini'] }}</span>
                    </li>
                    <li class="info-item">
                        <span class="info-label">Pengembalian</span>
                        <span class="badge success">5</span>
                    </li>
                    <li class="info-item">
                        <span class="info-label">Denda Terkumpul</span>
                        <span class="info-value">Rp 25.000</span>
                    </li>
                    <li class="info-item">
                        <span class="info-label">Buku Tersedia</span>
                        <span
                            class="info-value">{{ $data['total_buku_wajib'] + $data['total_buku_non_wajib'] - $data['peminjaman_aktif'] }}</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            .activity-list {
                max-height: 300px;
                overflow-y: auto;
            }

            .activity-item {
                display: flex;
                align-items: center;
                padding: 15px 0;
                border-bottom: 1px solid #e9ecef;
            }

            .activity-item:last-child {
                border-bottom: none;
            }

            .activity-icon {
                width: 40px;
                height: 40px;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                color: white;
                margin-right: 15px;
            }

            .activity-content {
                flex: 1;
            }

            .activity-title {
                font-weight: 500;
                color: #495057;
                margin-bottom: 2px;
            }

            .activity-time {
                font-size: 12px;
                color: #6c757d;
            }
        </style>
    @endpush
@endsection
