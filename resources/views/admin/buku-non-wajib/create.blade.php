@extends('layouts.dashboard')

@section('title', 'Tambah Buku Non-Wajib - SmartLib')
@section('page-title', 'Tambah Buku Non-Wajib')

@section('content')
    <div class="row">
        <div class="col-lg-8">
            <div class="chart-card">
                <div class="chart-header">
                    <h5 class="chart-title">Form Tambah Buku Non-Wajib</h5>
                    <a href="{{ route('admin.buku-non-wajib.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-2"></i>Kembali
                    </a>
                </div>

                <form method="POST" action="{{ route('admin.buku-non-wajib.store') }}">
                    @csrf

                    <div class="row">
                        <div class="col-md-8 mb-3">
                            <label for="judul" class="form-label">Judul Buku <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('judul') is-invalid @enderror" id="judul"
                                name="judul" value="{{ old('judul') }}" required>
                            @error('judul')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="tahun_terbit" class="form-label">Tahun Terbit</label>
                            <input type="number" class="form-control @error('tahun_terbit') is-invalid @enderror"
                                id="tahun_terbit" name="tahun_terbit" value="{{ old('tahun_terbit') }}" min="1900"
                                max="{{ date('Y') }}">
                            @error('tahun_terbit')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="penulis" class="form-label">Penulis</label>
                            <input type="text" class="form-control @error('penulis') is-invalid @enderror" id="penulis"
                                name="penulis" value="{{ old('penulis') }}">
                            @error('penulis')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="kategori_id" class="form-label">Kategori <span class="text-danger">*</span></label>
                            <select class="form-select @error('kategori_id') is-invalid @enderror" id="kategori_id"
                                name="kategori_id" required>
                                <option value="">Pilih Kategori</option>
                                @foreach ($kategori as $k)
                                    <option value="{{ $k->id }}"
                                        {{ old('kategori_id') == $k->id ? 'selected' : '' }}>
                                        {{ $k->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kategori_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="penerbit" class="form-label">Penerbit</label>
                            <input type="text" class="form-control @error('penerbit') is-invalid @enderror"
                                id="penerbit" name="penerbit" value="{{ old('penerbit') }}">
                            @error('penerbit')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="isbn" class="form-label">ISBN</label>
                            <input type="text" class="form-control @error('isbn') is-invalid @enderror" id="isbn"
                                name="isbn" value="{{ old('isbn') }}">
                            @error('isbn')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="stok" class="form-label">Stok <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('stok') is-invalid @enderror" id="stok"
                                name="stok" value="{{ old('stok', 1) }}" min="0" required>
                            @error('stok')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-2"></i>Simpan
                        </button>
                        <a href="{{ route('admin.buku-non-wajib.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-x-circle me-2"></i>Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="chart-card">
                <div class="chart-header">
                    <h5 class="chart-title">Panduan</h5>
                </div>

                <div class="info-list">
                    <div class="info-item">
                        <i class="bi bi-info-circle text-primary me-2"></i>
                        <span>Field dengan tanda (*) wajib diisi</span>
                    </div>
                    <div class="info-item">
                        <i class="bi bi-journal text-success me-2"></i>
                        <span>Buku non-wajib adalah buku bacaan umum untuk siswa</span>
                    </div>
                    <div class="info-item">
                        <i class="bi bi-tags text-warning me-2"></i>
                        <span>Pilih kategori yang sesuai dengan jenis buku</span>
                    </div>
                    <div class="info-item">
                        <i class="bi bi-hash text-info me-2"></i>
                        <span>ISBN harus unik untuk setiap buku</span>
                    </div>
                </div>
            </div>

            <div class="chart-card">
                <div class="chart-header">
                    <h5 class="chart-title">Kategori Tersedia</h5>
                </div>

                <div class="d-flex flex-wrap gap-2">
                    @foreach ($kategori as $k)
                        <span class="badge success">{{ $k->nama }}</span>
                    @endforeach
                </div>

                <div class="mt-3">
                    <a href="{{ route('admin.kategori-buku.create') }}" class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-plus me-2"></i>Tambah Kategori Baru
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
