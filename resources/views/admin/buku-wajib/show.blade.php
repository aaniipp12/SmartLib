@extends('layouts.dashboard')

@section('title', 'Detail Buku Wajib - SmartLib')
@section('page-title', 'Detail Buku Wajib')

@section('content')
    <div class="row">
        <div class="col-lg-8">
            <div class="chart-card">
                <div class="chart-header">
                    <h5 class="chart-title">{{ $bukuWajib->judul }}</h5>
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.buku-wajib.edit', $bukuWajib) }}" class="btn btn-primary">
                            <i class="bi bi-pencil me-2"></i>Edit
                        </a>
                        <a href="{{ route('admin.buku-wajib.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left me-2"></i>Kembali
                        </a>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <ul class="info-list">
                            <li class="info-item">
                                <span class="info-label">Judul</span>
                                <span class="info-value">{{ $bukuWajib->judul }}</span>
                            </li>
                            <li class="info-item">
                                <span class="info-label">Mata Pelajaran</span>
                                <span class="badge primary">{{ $bukuWajib->mata_pelajaran }}</span>
                            </li>
                            <li class="info-item">
                                <span class="info-label">Tingkat Kelas</span>
                                <span class="badge success">Kelas {{ $bukuWajib->tingkat }}</span>
                            </li>
                            <li class="info-item">
                                <span class="info-label">Penerbit</span>
                                <span class="info-value">{{ $bukuWajib->penerbit ?? '-' }}</span>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <ul class="info-list">
                            <li class="info-item">
                                <span class="info-label">ISBN</span>
                                <span class="info-value">{{ $bukuWajib->isbn ?? '-' }}</span>
                            </li>
                            <li class="info-item">
                                <span class="info-label">Tahun Terbit</span>
                                <span class="info-value">{{ $bukuWajib->tahun_terbit ?? '-' }}</span>
                            </li>
                            <li class="info-item">
                                <span class="info-label">Stok</span>
                                <span class="badge {{ $bukuWajib->stok > 0 ? 'success' : 'danger' }}">
                                    {{ $bukuWajib->stok }}
                                </span>
                            </li>
                            <li class="info-item">
                                <span class="info-label">Status</span>
                                <span class="badge {{ $bukuWajib->stok > 0 ? 'success' : 'danger' }}">
                                    {{ $bukuWajib->stok > 0 ? 'Tersedia' : 'Habis' }}
                                </span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Kelas yang Menggunakan -->
            <div class="chart-card">
                <div class="chart-header">
                    <h5 class="chart-title">Kelas yang Menggunakan Buku Ini</h5>
                </div>

                <div class="d-flex flex-wrap gap-2">
                    @php
                        $kelasYangMenggunakan = \App\Models\Kelas::where('tingkat', $bukuWajib->tingkat)->get();
                    @endphp

                    @forelse($kelasYangMenggunakan as $kelas)
                        <span class="badge primary">{{ $kelas->nama_lengkap }}</span>
                    @empty
                        <span class="text-muted">Tidak ada kelas yang terdaftar untuk tingkat
                            {{ $bukuWajib->tingkat }}</span>
                    @endforelse
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
                        <span class="info-value">{{ $bukuWajib->created_at->format('d/m/Y H:i') }}</span>
                    </li>
                    <li class="info-item">
                        <span class="info-label">Diperbarui</span>
                        <span class="info-value">{{ $bukuWajib->updated_at->format('d/m/Y H:i') }}</span>
                    </li>
                    <li class="info-item">
                        <span class="info-label">ID</span>
                        <span class="info-value">#{{ $bukuWajib->id }}</span>
                    </li>
                </ul>
            </div>

            <div class="chart-card">
                <div class="chart-header">
                    <h5 class="chart-title">Aksi</h5>
                </div>

                <div class="d-grid gap-2">
                    <a href="{{ route('admin.buku-wajib.edit', $bukuWajib) }}" class="btn btn-primary">
                        <i class="bi bi-pencil me-2"></i>Edit Buku
                    </a>
                    <form method="POST" action="{{ route('admin.buku-wajib.destroy', $bukuWajib) }}"
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
