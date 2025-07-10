@extends('layouts.dashboard')

@section('title', 'Edit Kategori Buku - SmartLib')
@section('page-title', 'Edit Kategori Buku')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="chart-card">
                <div class="chart-header">
                    <h5 class="chart-title">Form Edit Kategori Buku</h5>
                    <a href="{{ route('admin.kategori-buku.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-2"></i>Kembali
                    </a>
                </div>

                <form method="POST" action="{{ route('admin.kategori-buku.update', $kategoriBuku) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Kategori <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama"
                            name="nama" value="{{ old('nama', $kategoriBuku->nama) }}" required
                            placeholder="Contoh: Novel, Sejarah, Biografi">
                        @error('nama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Nama kategori harus unik dan maksimal 100 karakter</div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-2"></i>Update
                        </button>
                        <a href="{{ route('admin.kategori-buku.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-x-circle me-2"></i>Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="chart-card">
                <div class="chart-header">
                    <h5 class="chart-title">Informasi Kategori</h5>
                </div>

                <ul class="info-list">
                    <li class="info-item">
                        <span class="info-label">Dibuat</span>
                        <span class="info-value">{{ $kategoriBuku->created_at->format('d/m/Y H:i') }}</span>
                    </li>
                    <li class="info-item">
                        <span class="info-label">Diperbarui</span>
                        <span class="info-value">{{ $kategoriBuku->updated_at->format('d/m/Y H:i') }}</span>
                    </li>
                    <li class="info-item">
                        <span class="info-label">Jumlah Buku</span>
                        <span class="badge primary">{{ $kategoriBuku->bukuNonWajib()->count() }} buku</span>
                    </li>
                    <li class="info-item">
                        <span class="info-label">ID</span>
                        <span class="info-value">#{{ $kategoriBuku->id }}</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endsection
