@extends('layouts.dashboard')

@section('title', 'Ajukan Peminjaman Baru')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Pilih Jenis Peminjaman</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Buku Wajib -->
                            <div class="col-md-6 mb-4">
                                <div class="card h-100 border-primary">
                                    <div class="card-body text-center">
                                        <div class="mb-3">
                                            <i class="fas fa-graduation-cap fa-3x text-primary"></i>
                                        </div>
                                        <h5 class="card-title">Buku Wajib</h5>
                                        <p class="card-text text-muted">
                                            Pinjam semua buku wajib untuk tingkat kelas Anda.
                                            Sistem akan otomatis memilih semua buku yang diperlukan.
                                        </p>
                                        <div class="mb-3">
                                            <small class="text-info">
                                                <i class="fas fa-info-circle"></i>
                                                Untuk siswa tingkat {{ auth()->user()->kelas->tingkat }}
                                            </small>
                                        </div>
                                        <a href="{{ route('siswa.pengajuan-peminjaman.pilih-buku-wajib') }}"
                                            class="btn btn-primary btn-lg">
                                            <i class="fas fa-book"></i> Pilih Buku Wajib
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- Buku Non-Wajib -->
                            <div class="col-md-6 mb-4">
                                <div class="card h-100 border-success">
                                    <div class="card-body text-center">
                                        <div class="mb-3">
                                            <i class="fas fa-book-open fa-3x text-success"></i>
                                        </div>
                                        <h5 class="card-title">Buku Non-Wajib</h5>
                                        <p class="card-text text-muted">
                                            Pilih buku sesuai minat dan kebutuhan Anda.
                                            Anda dapat memilih beberapa buku dari berbagai kategori.
                                        </p>
                                        <div class="mb-3">
                                            <small class="text-info">
                                                <i class="fas fa-info-circle"></i>
                                                Maksimal 5 buku per pengajuan
                                            </small>
                                        </div>
                                        <a href="{{ route('siswa.pengajuan-peminjaman.pilih-buku-non-wajib') }}"
                                            class="btn btn-success btn-lg">
                                            <i class="fas fa-search"></i> Pilih Buku Non-Wajib
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="alert alert-info">
                                    <h6><i class="fas fa-info-circle"></i> Informasi Penting:</h6>
                                    <ul class="mb-0">
                                        <li>Setiap pengajuan akan direview oleh admin perpustakaan</li>
                                        <li>Masa peminjaman adalah 7 hari untuk semua jenis buku</li>
                                        <li>Pastikan mengembalikan buku tepat waktu untuk menghindari denda</li>
                                        <li>Anda dapat membatalkan pengajuan selama masih berstatus "Pending"</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="text-center mt-4">
                            <a href="{{ route('siswa.pengajuan-peminjaman.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali ke Riwayat
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
