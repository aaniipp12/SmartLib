@extends('layouts.dashboard')

@section('title', 'Dashboard Siswa - SmartLib')
@section('page-title', 'Dashboard Siswa')

@section('content')
    <!-- Stats Cards -->
    <div class="stats-grid">
        <div class="stats-card primary">
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
                <i class="bi bi-arrow-up"></i> Tersedia untuk kelas Anda
            </div>
        </div>

        <div class="stats-card success">
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
                <i class="bi bi-arrow-up"></i> Koleksi lengkap tersedia
            </div>
        </div>

        <div class="stats-card warning">
            <div class="stats-header">
                <div>
                    <div class="stats-number">{{ $data['peminjaman_aktif'] }}</div>
                    <div class="stats-label">Sedang Dipinjam</div>
                </div>
                <div class="stats-icon">
                    <i class="bi bi-bookmark-check"></i>
                </div>
            </div>
            <div class="stats-change">
                <i class="bi bi-info-circle"></i> Buku yang sedang Anda pinjam
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
                @if ($data['peminjaman_terlambat'] > 0)
                    <i class="bi bi-exclamation-circle"></i> Segera kembalikan!
                @else
                    <i class="bi bi-check-circle"></i> Tidak ada keterlambatan
                @endif
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <!-- Informasi Kelas -->
            <div class="chart-card">
                <div class="chart-header">
                    <h5 class="chart-title">Informasi Kelas</h5>
                </div>

                @if (auth()->user()->kelas)
                    <div class="row">
                        <div class="col-md-6">
                            <ul class="info-list">
                                <li class="info-item">
                                    <span class="info-label">Kelas</span>
                                    <span class="badge primary">{{ auth()->user()->kelas->nama_lengkap }}</span>
                                </li>
                                <li class="info-item">
                                    <span class="info-label">Tahun Ajaran</span>
                                    <span class="info-value">{{ auth()->user()->kelas->tahun_ajaran }}</span>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <ul class="info-list">
                                <li class="info-item">
                                    <span class="info-label">NIS</span>
                                    <span class="info-value">{{ auth()->user()->nis }}</span>
                                </li>
                                <li class="info-item">
                                    <span class="info-label">NISN</span>
                                    <span class="info-value">{{ auth()->user()->nisn }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                @else
                    <div class="alert alert-warning">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        Anda belum terdaftar di kelas manapun. Silakan hubungi admin untuk pendaftaran kelas.
                    </div>
                @endif
            </div>

            <!-- Riwayat Peminjaman Terbaru -->
            <div class="chart-card">
                <div class="chart-header">
                    <h5 class="chart-title">Riwayat Peminjaman Terbaru</h5>
                    <a href="#" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Judul Buku</th>
                                <th>Tanggal Pinjam</th>
                                <th>Tanggal Kembali</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Matematika Kelas 7</td>
                                <td>15/12/2024</td>
                                <td>22/12/2024</td>
                                <td><span class="badge success">Dikembalikan</span></td>
                            </tr>
                            <tr>
                                <td>IPA Terpadu</td>
                                <td>10/12/2024</td>
                                <td>17/12/2024</td>
                                <td><span class="badge warning">Dipinjam</span></td>
                            </tr>
                            <tr>
                                <td>Bahasa Indonesia</td>
                                <td>05/12/2024</td>
                                <td>12/12/2024</td>
                                <td><span class="badge success">Dikembalikan</span></td>
                            </tr>
                        </tbody>
                    </table>
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
                <div class="profile-role">Siswa</div>
                @if (auth()->user()->kelas)
                    <div style="font-size: 14px; color: #6c757d; margin-top: 5px;">
                        {{ auth()->user()->kelas->nama_lengkap }}
                    </div>
                @endif
            </div>

            <!-- Quick Actions -->
            <div class="chart-card">
                <div class="chart-header">
                    <h5 class="chart-title">Menu Cepat</h5>
                </div>

                <div class="quick-actions">
                    <a href="#" class="action-btn primary">
                        <i class="bi bi-book"></i>
                        <span>Katalog Buku</span>
                    </a>
                    <a href="#" class="action-btn success">
                        <i class="bi bi-list-check"></i>
                        <span>Peminjaman Saya</span>
                    </a>
                    <a href="#" class="action-btn info">
                        <i class="bi bi-person"></i>
                        <span>Profil Saya</span>
                    </a>
                </div>
            </div>

            <!-- Ringkasan Peminjaman -->
            <div class="chart-card">
                <div class="chart-header">
                    <h5 class="chart-title">Ringkasan Peminjaman</h5>
                </div>

                <ul class="info-list">
                    <li class="info-item">
                        <span class="info-label">Total Peminjaman</span>
                        <span class="badge primary">{{ $data['riwayat_peminjaman'] }}</span>
                    </li>
                    <li class="info-item">
                        <span class="info-label">Sedang Dipinjam</span>
                        <span class="badge warning">{{ $data['peminjaman_aktif'] }}</span>
                    </li>
                    <li class="info-item">
                        <span class="info-label">Terlambat</span>
                        <span class="badge {{ $data['peminjaman_terlambat'] > 0 ? 'danger' : 'success' }}">
                            {{ $data['peminjaman_terlambat'] }}
                        </span>
                    </li>
                    <li class="info-item">
                        <span class="info-label">Denda</span>
                        <span class="info-value">Rp 0</span>
                    </li>
                </ul>

                @if ($data['peminjaman_terlambat'] > 0)
                    <div class="alert alert-warning mt-3">
                        <small>
                            <i class="bi bi-exclamation-triangle me-1"></i>
                            Anda memiliki {{ $data['peminjaman_terlambat'] }} peminjaman yang terlambat.
                            Segera kembalikan untuk menghindari denda.
                        </small>
                    </div>
                @endif
            </div>

            <!-- Tips -->
            <div class="chart-card">
                <div class="chart-header">
                    <h5 class="chart-title">Tips Perpustakaan</h5>
                </div>

                <div class="tips-content">
                    <div class="tip-item">
                        <i class="bi bi-lightbulb text-warning"></i>
                        <span>Kembalikan buku tepat waktu untuk menghindari denda</span>
                    </div>
                    <div class="tip-item">
                        <i class="bi bi-bookmark text-primary"></i>
                        <span>Gunakan bookmark untuk menandai halaman terakhir dibaca</span>
                    </div>
                    <div class="tip-item">
                        <i class="bi bi-shield-check text-success"></i>
                        <span>Jaga kebersihan dan kondisi buku dengan baik</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            .tips-content {
                padding: 10px 0;
            }

            .tip-item {
                display: flex;
                align-items: flex-start;
                margin-bottom: 15px;
                font-size: 14px;
            }

            .tip-item:last-child {
                margin-bottom: 0;
            }

            .tip-item i {
                margin-right: 10px;
                margin-top: 2px;
                font-size: 16px;
            }

            .table th {
                font-weight: 600;
                color: #495057;
                border-top: none;
                font-size: 14px;
            }

            .table td {
                font-size: 14px;
                vertical-align: middle;
            }
        </style>
    @endpush
@endsection
