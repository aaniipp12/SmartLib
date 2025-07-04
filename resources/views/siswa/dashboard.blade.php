@extends('layouts.app')

@section('title', 'Dashboard Siswa')
@section('page-title', 'Dashboard Siswa')
@section('page-subtitle', 'Selamat datang, ' . auth()->user()->nama)

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
@endsection

@section('content')
<section class="row">
    <div class="col-12 col-lg-9">
        <div class="row">
            <div class="col-6 col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body px-4 py-4-5">
                        <div class="row">
                            <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                <div class="stats-icon blue mb-2">
                                    <i class="iconly-boldBookmark"></i>
                                </div>
                            </div>
                            <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                <h6 class="text-muted font-semibold">Buku Wajib</h6>
                                <h6 class="font-extrabold mb-0">{{ $data['total_buku_wajib'] }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body px-4 py-4-5">
                        <div class="row">
                            <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                <div class="stats-icon green mb-2">
                                    <i class="iconly-boldBookmark"></i>
                                </div>
                            </div>
                            <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                <h6 class="text-muted font-semibold">Buku Non-Wajib</h6>
                                <h6 class="font-extrabold mb-0">{{ $data['total_buku_non_wajib'] }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body px-4 py-4-5">
                        <div class="row">
                            <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                <div class="stats-icon purple mb-2">
                                    <i class="iconly-boldDanger"></i>
                                </div>
                            </div>
                            <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                <h6 class="text-muted font-semibold">Sedang Dipinjam</h6>
                                <h6 class="font-extrabold mb-0">{{ $data['peminjaman_aktif'] }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body px-4 py-4-5">
                        <div class="row">
                            <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                <div class="stats-icon red mb-2">
                                    <i class="iconly-boldDanger"></i>
                                </div>
                            </div>
                            <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                <h6 class="text-muted font-semibold">Terlambat</h6>
                                <h6 class="font-extrabold mb-0">{{ $data['peminjaman_terlambat'] }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Informasi Kelas</h4>
                    </div>
                    <div class="card-body">
                        @if(auth()->user()->kelas)
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>Kelas:</strong> {{ auth()->user()->kelas->nama_lengkap }}</p>
                                    <p><strong>Tahun Ajaran:</strong> {{ auth()->user()->kelas->tahun_ajaran }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>NIS:</strong> {{ auth()->user()->nis }}</p>
                                    <p><strong>NISN:</strong> {{ auth()->user()->nisn }}</p>
                                </div>
                            </div>
                        @else
                            <div class="alert alert-warning">
                                <i class="bi bi-exclamation-triangle me-2"></i>
                                Anda belum terdaftar di kelas manapun. Silakan hubungi admin untuk pendaftaran kelas.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-12 col-lg-3">
        <div class="card">
            <div class="card-header">
                <h4>Menu Cepat</h4>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="#" class="btn btn-primary">
                        <i class="bi bi-book me-2"></i>Katalog Buku
                    </a>
                    <a href="#" class="btn btn-success">
                        <i class="bi bi-list-check me-2"></i>Peminjaman Saya
                    </a>
                    <a href="#" class="btn btn-info">
                        <i class="bi bi-person me-2"></i>Profil Saya
                    </a>
                </div>
            </div>
        </div>
        
        <div class="card mt-3">
            <div class="card-header">
                <h4>Riwayat Peminjaman</h4>
            </div>
            <div class="card-body">
                <p class="text-muted">Total peminjaman: <strong>{{ $data['riwayat_peminjaman'] }}</strong></p>
                @if($data['peminjaman_terlambat'] > 0)
                    <div class="alert alert-warning">
                        <small>Anda memiliki {{ $data['peminjaman_terlambat'] }} peminjaman yang terlambat.</small>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
