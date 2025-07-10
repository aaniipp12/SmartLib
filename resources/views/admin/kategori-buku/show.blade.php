@extends('layouts.dashboard')

@section('title', 'Detail Kategori Buku - SmartLib')
@section('page-title', 'Detail Kategori Buku')

@section('content')
    <div class="row">
        <div class="col-lg-8">
            <div class="chart-card">
                <div class="chart-header">
                    <h5 class="chart-title">{{ $kategoriBuku->nama }}</h5>
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.kategori-buku.edit', $kategoriBuku) }}" class="btn btn-primary">
                            <i class="bi bi-pencil me-2"></i>Edit
                        </a>
                        <a href="{{ route('admin.kategori-buku.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left me-2"></i>Kembali
                        </a>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <ul class="info-list">
                            <li class="info-item">
                                <span class="info-label">Nama Kategori</span>
                                <span class="info-value">{{ $kategoriBuku->nama }}</span>
                            </li>
                            <li class="info-item">
                                <span class="info-label">Jumlah Buku</span>
                                <span class="badge {{ $kategoriBuku->buku_non_wajib_count > 0 ? 'success' : 'secondary' }}">
                                    {{ $kategoriBuku->buku_non_wajib_count }} buku
                                </span>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <ul class="info-list">
                            <li class="info-item">
                                <span class="info-label">Dibuat</span>
                                <span class="info-value">{{ $kategoriBuku->created_at->format('d/m/Y H:i') }}</span>
                            </li>
                            <li class="info-item">
                                <span class="info-label">Diperbarui</span>
                                <span class="info-value">{{ $kategoriBuku->updated_at->format('d/m/Y H:i') }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Daftar Buku dalam Kategori -->
            <div class="chart-card">
                <div class="chart-header">
                    <h5 class="chart-title">Buku dalam Kategori Ini</h5>
                    <a href="{{ route('admin.buku-non-wajib.create') }}" class="btn btn-sm btn-primary">
                        <i class="bi bi-plus me-2"></i>Tambah Buku
                    </a>
                </div>

                @if ($bukuNonWajib->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Judul</th>
                                    <th>Penulis</th>
                                    <th>Penerbit</th>
                                    <th>Stok</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($bukuNonWajib as $buku)
                                    <tr>
                                        <td>
                                            <div class="fw-bold">{{ $buku->judul }}</div>
                                            @if ($buku->isbn)
                                                <small class="text-muted">ISBN: {{ $buku->isbn }}</small>
                                            @endif
                                        </td>
                                        <td>{{ $buku->penulis ?? '-' }}</td>
                                        <td>{{ $buku->penerbit ?? '-' }}</td>
                                        <td>
                                            <span class="badge {{ $buku->stok > 0 ? 'success' : 'danger' }}">
                                                {{ $buku->stok }}
                                            </span>
                                        </td>
                                        <td>
                                            @if ($buku->stok > 0)
                                                <span class="badge success">Tersedia</span>
                                            @else
                                                <span class="badge danger">Habis</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <a href="{{ route('admin.buku-non-wajib.show', $buku) }}"
                                                    class="btn btn-outline-primary btn-sm">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.buku-non-wajib.edit', $buku) }}"
                                                    class="btn btn-outline-secondary btn-sm">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @if ($bukuNonWajib->hasPages())
                        <div class="d-flex justify-content-center mt-3">
                            {{ $bukuNonWajib->links() }}
                        </div>
                    @endif
                @else
                    <div class="text-center py-4">
                        <div class="text-muted">
                            <i class="bi bi-journal fs-1 d-block mb-2"></i>
                            Belum ada buku dalam kategori ini
                        </div>
                        <a href="{{ route('admin.buku-non-wajib.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus me-2"></i>Tambah Buku Pertama
                        </a>
                    </div>
                @endif
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
                                <div class="stats-number">{{ $kategoriBuku->buku_non_wajib_count }}</div>
                                <div class="stats-label">Total Buku</div>
                            </div>
                            <div class="stats-icon">
                                <i class="bi bi-book"></i>
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
                        <span class="info-label">ID</span>
                        <span class="info-value">#{{ $kategoriBuku->id }}</span>
                    </li>
                    <li class="info-item">
                        <span class="info-label">Dibuat</span>
                        <span class="info-value">{{ $kategoriBuku->created_at->format('d/m/Y H:i') }}</span>
                    </li>
                    <li class="info-item">
                        <span class="info-label">Diperbarui</span>
                        <span class="info-value">{{ $kategoriBuku->updated_at->format('d/m/Y H:i') }}</span>
                    </li>
                </ul>
            </div>

            <div class="chart-card">
                <div class="chart-header">
                    <h5 class="chart-title">Aksi</h5>
                </div>

                <div class="d-grid gap-2">
                    <a href="{{ route('admin.kategori-buku.edit', $kategoriBuku) }}" class="btn btn-primary">
                        <i class="bi bi-pencil me-2"></i>Edit Kategori
                    </a>
                    <a href="{{ route('admin.buku-non-wajib.create') }}?kategori_id={{ $kategoriBuku->id }}"
                        class="btn btn-success">
                        <i class="bi bi-plus me-2"></i>Tambah Buku
                    </a>
                    @if ($kategoriBuku->buku_non_wajib_count == 0)
                        <form method="POST" action="{{ route('admin.kategori-buku.destroy', $kategoriBuku) }}"
                            onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger w-100">
                                <i class="bi bi-trash me-2"></i>Hapus Kategori
                            </button>
                        </form>
                    @else
                        <button class="btn btn-danger w-100" disabled
                            title="Tidak dapat dihapus karena masih memiliki buku">
                            <i class="bi bi-trash me-2"></i>Hapus Kategori
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
