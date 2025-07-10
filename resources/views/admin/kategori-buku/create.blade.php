@extends('layouts.dashboard')

@section('title', 'Tambah Kategori Buku - SmartLib')
@section('page-title', 'Tambah Kategori Buku')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="chart-card">
                <div class="chart-header">
                    <h5 class="chart-title">Form Tambah Kategori Buku</h5>
                    <a href="{{ route('admin.kategori-buku.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-2"></i>Kembali
                    </a>
                </div>

                <form method="POST" action="{{ route('admin.kategori-buku.store') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Kategori <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama"
                            name="nama" value="{{ old('nama') }}" required
                            placeholder="Contoh: Novel, Sejarah, Biografi">
                        @error('nama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Nama kategori harus unik dan maksimal 100 karakter</div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-2"></i>Simpan
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
                    <h5 class="chart-title">Contoh Kategori</h5>
                </div>

                <div class="d-flex flex-wrap gap-2 mb-3">
                    <span class="badge primary">Novel</span>
                    <span class="badge success">Sejarah</span>
                    <span class="badge warning">Biografi</span>
                    <span class="badge info">Sains</span>
                    <span class="badge purple">Agama</span>
                    <span class="badge danger">Komik</span>
                </div>

                <div class="info-list">
                    <div class="info-item">
                        <i class="bi bi-lightbulb text-warning me-2"></i>
                        <span>Gunakan nama kategori yang mudah dipahami</span>
                    </div>
                    <div class="info-item">
                        <i class="bi bi-check-circle text-success me-2"></i>
                        <span>Kategori membantu mengorganisir buku non-wajib</span>
                    </div>
                    <div class="info-item">
                        <i class="bi bi-info-circle text-primary me-2"></i>
                        <span>Kategori tidak dapat dihapus jika masih memiliki buku</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
