@extends('layouts.dashboard')

@section('title', 'Manajemen Kategori Buku - SmartLib')
@section('page-title', 'Manajemen Kategori Buku')

@section('content')
    <div class="row mb-4">
        <div class="col-md-8">
            <div class="d-flex gap-2">
                <a href="{{ route('admin.kategori-buku.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-2"></i>Tambah Kategori
                </a>
                <a href="{{ route('admin.buku-wajib.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-book me-2"></i>Buku Wajib
                </a>
                <a href="{{ route('admin.buku-non-wajib.index') }}" class="btn btn-outline-info">
                    <i class="bi bi-journal me-2"></i>Buku Non-Wajib
                </a>
            </div>
        </div>
        <div class="col-md-4">
            <form method="GET" class="d-flex">
                <input type="text" name="search" class="form-control" placeholder="Cari kategori..."
                    value="{{ request('search') }}">
                <button type="submit" class="btn btn-outline-primary ms-2">
                    <i class="bi bi-search"></i>
                </button>
            </form>
        </div>
    </div>

    <!-- Categories Table -->
    <div class="chart-card">
        <div class="chart-header">
            <h5 class="chart-title">Daftar Kategori Buku</h5>
            <span class="badge primary">{{ $kategori->total() }} kategori</span>
        </div>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Kategori</th>
                        <th>Jumlah Buku</th>
                        <th>Dibuat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kategori as $index => $kat)
                        <tr>
                            <td>{{ $kategori->firstItem() + $index }}</td>
                            <td>
                                <div class="fw-bold">{{ $kat->nama }}</div>
                            </td>
                            <td>
                                <span class="badge {{ $kat->buku_non_wajib_count > 0 ? 'success' : 'secondary' }}">
                                    {{ $kat->buku_non_wajib_count }} buku
                                </span>
                            </td>
                            <td>{{ $kat->created_at->format('d/m/Y') }}</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button"
                                        data-bs-toggle="dropdown">
                                        Aksi
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item" href="{{ route('admin.kategori-buku.show', $kat) }}">
                                                <i class="bi bi-eye me-2"></i>Detail
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('admin.kategori-buku.edit', $kat) }}">
                                                <i class="bi bi-pencil me-2"></i>Edit
                                            </a>
                                        </li>
                                        @if ($kat->buku_non_wajib_count == 0)
                                            <li>
                                                <hr class="dropdown-divider">
                                            </li>
                                            <li>
                                                <form method="POST"
                                                    action="{{ route('admin.kategori-buku.destroy', $kat) }}"
                                                    onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item text-danger">
                                                        <i class="bi bi-trash me-2"></i>Hapus
                                                    </button>
                                                </form>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4">
                                <div class="text-muted">
                                    <i class="bi bi-tags fs-1 d-block mb-2"></i>
                                    Tidak ada kategori ditemukan
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($kategori->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $kategori->links() }}
            </div>
        @endif
    </div>
@endsection
