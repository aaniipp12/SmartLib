@extends('layouts.dashboard')

@section('title', 'Tambah Buku Wajib - SmartLib')
@section('page-title', 'Tambah Buku Wajib')

@section('content')
    <div class="row">
        <div class="col-lg-8">
            <div class="chart-card">
                <div class="chart-header">
                    <h5 class="chart-title">Form Tambah Buku Wajib</h5>
                    <a href="{{ route('admin.buku-wajib.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-2"></i>Kembali
                    </a>
                </div>

                <form method="POST" action="{{ route('admin.buku-wajib.store') }}">
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
                            <label for="mata_pelajaran" class="form-label">Mata Pelajaran <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('mata_pelajaran') is-invalid @enderror"
                                id="mata_pelajaran" name="mata_pelajaran" value="{{ old('mata_pelajaran') }}"
                                list="mata_pelajaran_list" required>
                            <datalist id="mata_pelajaran_list">
                                <option value="Bahasa Indonesia">
                                <option value="Matematika">
                                <option value="IPA">
                                <option value="IPS">
                                <option value="Bahasa Inggris">
                                <option value="Pendidikan Agama">
                                <option value="PKn">
                                <option value="Seni Budaya">
                                <option value="PJOK">
                                <option value="Prakarya">
                            </datalist>
                            @error('mata_pelajaran')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="tingkat" class="form-label">Tingkat Kelas <span
                                    class="text-danger">*</span></label>
                            <select class="form-select @error('tingkat') is-invalid @enderror" id="tingkat" name="tingkat"
                                required>
                                <option value="">Pilih Tingkat</option>
                                @foreach ($tingkatList as $tingkat)
                                    <option value="{{ $tingkat }}" {{ old('tingkat') == $tingkat ? 'selected' : '' }}>
                                        Kelas {{ $tingkat }}
                                    </option>
                                @endforeach
                            </select>
                            @error('tingkat')
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
                        <a href="{{ route('admin.buku-wajib.index') }}" class="btn btn-outline-secondary">
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
                        <i class="bi bi-book text-success me-2"></i>
                        <span>Buku wajib berlaku untuk semua kelas dalam tingkat yang dipilih</span>
                    </div>
                    <div class="info-item">
                        <i class="bi bi-layers text-warning me-2"></i>
                        <span>Contoh: Jika pilih Kelas 7, maka berlaku untuk 7A, 7B, 7C, dst</span>
                    </div>
                    <div class="info-item">
                        <i class="bi bi-hash text-info me-2"></i>
                        <span>ISBN harus unik untuk setiap buku</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
