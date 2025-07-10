@extends('layouts.dashboard')

@section('title', 'Detail Pengajuan Peminjaman')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Detail Pengajuan Peminjaman</h5>
                        <span class="badge {{ $pengajuan->status_badge }} fs-6">
                            {{ $pengajuan->status_text }}
                        </span>
                    </div>
                    <div class="card-body">
                        <!-- Informasi Pengajuan -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <td width="150"><strong>Kode Pengajuan:</strong></td>
                                        <td>{{ $pengajuan->kode_pengajuan }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Jenis Peminjaman:</strong></td>
                                        <td>
                                            <span
                                                class="badge {{ $pengajuan->jenis_peminjaman == 'wajib' ? 'bg-info' : 'bg-secondary' }}">
                                                {{ $pengajuan->jenis_peminjaman == 'wajib' ? 'Buku Wajib' : 'Buku Non-Wajib' }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Tanggal Pengajuan:</strong></td>
                                        <td>{{ $pengajuan->tanggal_pengajuan->format('d/m/Y H:i') }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Total Buku:</strong></td>
                                        <td>{{ $pengajuan->getTotalBuku() }} buku</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                @if ($pengajuan->tanggal_diproses)
                                    <table class="table table-borderless">
                                        <tr>
                                            <td width="150"><strong>Diproses Tanggal:</strong></td>
                                            <td>{{ $pengajuan->tanggal_diproses->format('d/m/Y H:i') }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Diproses Oleh:</strong></td>
                                            <td>{{ $pengajuan->diprosesOleh->name ?? '-' }}</td>
                                        </tr>
                                        @if ($pengajuan->catatan_admin)
                                            <tr>
                                                <td><strong>Catatan Admin:</strong></td>
                                                <td>
                                                    <div class="alert alert-info mb-0 p-2">
                                                        {{ $pengajuan->catatan_admin }}
                                                    </div>
                                                </td>
                                            </tr>
                                        @endif
                                    </table>
                                @endif
                            </div>
                        </div>

                        <!-- Status Timeline -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6>Status Timeline:</h6>
                                <div class="timeline">
                                    <div
                                        class="timeline-item {{ $pengajuan->status == 'pending' ? 'active' : 'completed' }}">
                                        <div class="timeline-marker"></div>
                                        <div class="timeline-content">
                                            <h6>Pengajuan Dibuat</h6>
                                            <small>{{ $pengajuan->tanggal_pengajuan->format('d/m/Y H:i') }}</small>
                                        </div>
                                    </div>

                                    @if ($pengajuan->status != 'pending')
                                        <div class="timeline-item completed">
                                            <div class="timeline-marker"></div>
                                            <div class="timeline-content">
                                                <h6>
                                                    @if ($pengajuan->status == 'disetujui' || $pengajuan->status == 'dipinjam')
                                                        Pengajuan Disetujui
                                                    @else
                                                        Pengajuan Ditolak
                                                    @endif
                                                </h6>
                                                <small>{{ $pengajuan->tanggal_diproses->format('d/m/Y H:i') }}</small>
                                            </div>
                                        </div>
                                    @endif

                                    @if ($pengajuan->status == 'dipinjam')
                                        <div class="timeline-item completed">
                                            <div class="timeline-marker"></div>
                                            <div class="timeline-content">
                                                <h6>Buku Dipinjam</h6>
                                                <small>Peminjaman telah dibuat</small>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Daftar Buku -->
                        <div class="row">
                            <div class="col-12">
                                <h6>Daftar Buku yang Diajukan:</h6>
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Judul Buku</th>
                                                <th>Penulis</th>
                                                <th>Jumlah</th>
                                                @if ($pengajuan->jenis_peminjaman == 'wajib')
                                                    <th>Mata Pelajaran</th>
                                                @else
                                                    <th>Kategori</th>
                                                @endif
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($pengajuan->detailPengajuan as $index => $detail)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $detail->judul_buku }}</td>
                                                    <td>{{ $detail->penulis }}</td>
                                                    <td>{{ $detail->jumlah }}</td>
                                                    <td>
                                                        @if ($detail->bukuWajib)
                                                            {{ $detail->bukuWajib->mata_pelajaran }}
                                                        @elseif($detail->bukuNonWajib)
                                                            {{ $detail->bukuNonWajib->kategori->nama_kategori }}
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('siswa.pengajuan-peminjaman.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-arrow-left"></i> Kembali ke Riwayat
                                    </a>

                                    @if ($pengajuan->status == 'pending')
                                        <form action="{{ route('siswa.pengajuan-peminjaman.cancel', $pengajuan->id) }}"
                                            method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-danger"
                                                onclick="return confirm('Yakin ingin membatalkan pengajuan ini?')">
                                                <i class="fas fa-times"></i> Batalkan Pengajuan
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            .timeline {
                position: relative;
                padding-left: 30px;
            }

            .timeline::before {
                content: '';
                position: absolute;
                left: 15px;
                top: 0;
                bottom: 0;
                width: 2px;
                background: #dee2e6;
            }

            .timeline-item {
                position: relative;
                margin-bottom: 20px;
            }

            .timeline-marker {
                position: absolute;
                left: -23px;
                top: 5px;
                width: 16px;
                height: 16px;
                border-radius: 50%;
                background: #dee2e6;
                border: 3px solid #fff;
            }

            .timeline-item.active .timeline-marker {
                background: #ffc107;
            }

            .timeline-item.completed .timeline-marker {
                background: #28a745;
            }

            .timeline-content h6 {
                margin-bottom: 5px;
                font-size: 14px;
            }

            .timeline-content small {
                color: #6c757d;
            }
        </style>
    @endpush
@endsection
