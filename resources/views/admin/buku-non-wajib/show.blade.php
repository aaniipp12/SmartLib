@extends('layouts.dashboard')

@section('title', 'Detail Buku Non-Wajib - SmartLib')
@section('page-title', 'Detail Buku Non-Wajib')

@section('content')
    <div class="row">
        <div class="col-lg-8">
            <div class="chart-card">
                <div class="chart-header">
                    <h5 class="chart-title">{{ $bukuNonWajib->judul }}</h5>
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.buku-non-wajib.edit', $bukuNonWajib) }}" class="btn btn-primary">
                            <i class="bi bi-pencil me-2"></i>Edit
                        </a>
                        <a href="{{ route('admin.buku-non-wajib.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left me-2"></i>Kembali
                        </a>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <ul class="info-list">
                            <li class="info-item">
                                <span class="info-label">Judul</span>
                                <span class="info-value">{{ $bukuNonWajib->judul }}</span>
                            </li>
                            <li class="info-item">
                                <span class="info-label">Penulis</span>
                                <span class="info-value">{{ $bukuNonWajib->penulis ?? '-' }}</span>
                            </li>
                            <li class="info-item">
                                <span class="info-label">Kategori</span>
                                <span class="badge success">{{ $bukuNonWajib->kategori->nama ?? '-' }}</span>
                            </li>
                            <li class="info-item">
                                <span class="info-label">Penerbit</span>
                                <span class="info-value">{{ $bukuNonWajib->penerbit ?? '-' }}</span>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <ul class="info-list">
                            <li class="info-item">
                                <span class="info-label">ISBN</span>
                                <span class="info-value">{{ $bukuNonWajib->isbn ?? '-' }}</span>
                            </li>
                            <li class="info-item">
                                <span class="info-label">Tahun Terbit</span>
                                <span class="info-value">{{ $bukuNonWajib->tahun_terbit ?? '-' }}</span>
                            </li>
                            <li class="info-item">
                                <span class="info-label">Stok</span>
                                <span class="badge {{ $bukuNonWajib->stok > 0 ? 'success' : 'danger' }}">
                                    {{ $bukuNonWajib->stok }}
                                </span>
                            </li>
                            <li class="info-item">
                                <span class="info-label">Status</span>
                                <span class="badge {{ $bukuNonWajib->stok > 0 ? 'success' : 'danger' }}">
                                    {{ $bukuNonWajib->stok > 0 ? 'Tersedia' : 'Habis' }}
                                </span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Riwayat Peminjaman -->
            <div class="chart-card">
                <div class="chart-header">
                    <h5 class="chart-title">Riwayat Peminjaman</h5>
                </div>

                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Siswa</th>
                                <th>Tanggal Pinjam</th>
                                <th>Tanggal Kembali</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="4" class="text-center text-muted py-3">
                                    Belum ada riwayat peminjaman
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="chart-card">
                <div class="chart-header">
                    <h5 class="chart-title">Statistik</h5>
                </div>

                <div class="stats-grid">
                    <div class="stats-card primary">
                        <div class="stats-header">
                            <div>
                                <div class="stats-number">0</div>
                                <div class="stats-label">Total Dipinjam</div>
                            </div>
                            <div class="stats-icon">
                                <i class="bi bi-arrow-up-right"></i>
                            </div>
                        </div>
                    </div>

                    <div class="stats-card success">
                        <div class="stats-header">
                            <div>
                                <div class="stats-number">0</div>
                                <div class="stats-label">Sedang Dipinjam</div>
                            </div>
                            <div class="stats-icon">
                                <i class="bi bi-bookmark-check"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="chart-card">
                <div class="chart-header">
                    <h5 class="chart-title">Informasi Sistem</h5>
                </div>

                <ul class="info-list">
                    <li class="info-item">
                        <span class="info-label">Dibuat</span>
                        <span class="info-value">{{ $bukuNonWajib->created_at->format('d/m/Y H:i') }}</span>
                    </li>
                    <li class="info-item">
                        <span class="info-label">Diperbarui</span>
                        <span class="info-value">{{ $bukuNonWajib->updated_at->format('d/m/Y H:i') }}</span>
                    </li>
                    <li class="info-item">
                        <span class="info-label">ID</span>
                        <span class="info-value">#{{ $bukuNonWajib->id }}</span>
                    </li>
                </ul>
            </div>

            <div class="chart-card">
                <div class="chart-header">
                    <h5 class="chart-title">Aksi</h5>
                </div>

                <div class="d-grid gap-2">
                    <a href="{{ route('admin.buku-non-wajib.edit', $bukuNonWajib) }}" class="btn btn-primary">
                        <i class="bi bi-pencil me-2"></i>Edit Buku
                    </a>
                    <form method="POST" action="{{ route('admin.buku-non-wajib.destroy', $bukuNonWajib) }}"
                        onsubmit="return confirm('Yakin ingin menghapus buku ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-100">
                            <i class="bi bi-trash me-2"></i>Hapus Buku
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
