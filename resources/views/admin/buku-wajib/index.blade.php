@extends('layouts.dashboard')

@section('title', 'Manajemen Buku Wajib - SmartLib')
@section('page-title', 'Manajemen Buku Wajib')

@section('content')
    <div class="row mb-4">
        <div class="col-md-8">
            <div class="d-flex gap-2">
                <a href="{{ route('admin.buku-wajib.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-2"></i>Tambah Buku Wajib
                </a>
                <a href="{{ route('admin.buku-non-wajib.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-journal me-2"></i>Buku Non-Wajib
                </a>
                <a href="{{ route('admin.kategori-buku.index') }}" class="btn btn-outline-info">
                    <i class="bi bi-tags me-2"></i>Kategori Buku
                </a>
            </div>
        </div>
        <div class="col-md-4">
            <form method="GET" class="d-flex">
                <input type="text" name="search" class="form-control" placeholder="Cari buku..."
                    value="{{ request('search') }}">
                <button type="submit" class="btn btn-outline-primary ms-2">
                    <i class="bi bi-search"></i>
                </button>
            </form>
        </div>
    </div>

    <!-- Filters -->
    <div class="chart-card mb-4">
        <div class="chart-header">
            <h5 class="chart-title">Filter</h5>
        </div>
        <form method="GET" class="row g-3">
            <input type="hidden" name="search" value="{{ request('search') }}">
            <div class="col-md-4">
                <select name="tingkat" class="form-select">
                    <option value="">Semua Tingkat</option>
                    @foreach ($tingkatList as $tingkat)
                        <option value="{{ $tingkat }}" {{ request('tingkat') == $tingkat ? 'selected' : '' }}>
                            Kelas {{ $tingkat }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <select name="mata_pelajaran" class="form-select">
                    <option value="">Semua Mata Pelajaran</option>
                    @foreach ($mataPelajaran as $mp)
                        <option value="{{ $mp }}" {{ request('mata_pelajaran') == $mp ? 'selected' : '' }}>
                            {{ $mp }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-funnel me-2"></i>Filter
                    </button>
                    <a href="{{ route('admin.buku-wajib.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-x-circle me-2"></i>Reset
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Books Table -->
    <div class="chart-card">
        <div class="chart-header">
            <h5 class="chart-title">Daftar Buku Wajib</h5>
            <span class="badge primary">{{ $bukuWajib->total() }} buku</span>
        </div>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Judul</th>
                        <th>Mata Pelajaran</th>
                        <th>Tingkat</th>
                        <th>Penerbit</th>
                        <th>Tahun</th>
                        <th>Stok</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bukuWajib as $index => $buku)
                        <tr>
                            <td>{{ $bukuWajib->firstItem() + $index }}</td>
                            <td>
                                <div class="fw-bold">{{ $buku->judul }}</div>
                                @if ($buku->isbn)
                                    <small class="text-muted">ISBN: {{ $buku->isbn }}</small>
                                @endif
                            </td>
                            <td>
                                <span class="badge primary">{{ $buku->mata_pelajaran }}</span>
                            </td>
                            <td>
                                <span class="badge success">Kelas {{ $buku->tingkat }}</span>
                            </td>
                            <td>{{ $buku->penerbit ?? '-' }}</td>
                            <td>{{ $buku->tahun_terbit ?? '-' }}</td>
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
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button"
                                        data-bs-toggle="dropdown">
                                        Aksi
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item" href="{{ route('admin.buku-wajib.show', $buku) }}">
                                                <i class="bi bi-eye me-2"></i>Detail
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('admin.buku-wajib.edit', $buku) }}">
                                                <i class="bi bi-pencil me-2"></i>Edit
                                            </a>
                                        </li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li>
                                            <form method="POST" action="{{ route('admin.buku-wajib.destroy', $buku) }}"
                                                onsubmit="return confirm('Yakin ingin menghapus buku ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger">
                                                    <i class="bi bi-trash me-2"></i>Hapus
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center py-4">
                                <div class="text-muted">
                                    <i class="bi bi-book fs-1 d-block mb-2"></i>
                                    Tidak ada buku wajib ditemukan
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($bukuWajib->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $bukuWajib->links() }}
            </div>
        @endif
    </div>
@endsection
