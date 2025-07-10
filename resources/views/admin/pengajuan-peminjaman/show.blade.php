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
                        <!-- Informasi Siswa -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="card bg-light">
                                    <div class="card-header">
                                        <h6 class="mb-0">Informasi Siswa</h6>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-borderless mb-0">
                                            <tr>
                                                <td width="100"><strong>Nama:</strong></td>
                                                <td>{{ $pengajuan->user->name }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>NIS:</strong></td>
                                                <td>{{ $pengajuan->user->nis }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Kelas:</strong></td>
                                                <td>{{ $pengajuan->user->kelas->nama_kelas }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>NISN:</strong></td>
                                                <td>{{ $pengajuan->user->nisn ?? '-' }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card bg-light">
                                    <div class="card-header">
                                        <h6 class="mb-0">Informasi Pengajuan</h6>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-borderless mb-0">
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
                                </div>
                            </div>
                        </div>

                        @if ($pengajuan->tanggal_diproses)
                            <!-- Informasi Pemrosesan -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <div class="card bg-light">
                                        <div class="card-header">
                                            <h6 class="mb-0">Informasi Pemrosesan</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <table class="table table-borderless mb-0">
                                                        <tr>
                                                            <td width="150"><strong>Diproses Tanggal:</strong></td>
                                                            <td>{{ $pengajuan->tanggal_diproses->format('d/m/Y H:i') }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>Diproses Oleh:</strong></td>
                                                            <td>{{ $pengajuan->diprosesOleh->name ?? '-' }}</td>
                                                        </tr>
                                                    </table>
                                                </div>
                                                @if ($pengajuan->catatan_admin)
                                                    <div class="col-md-6">
                                                        <strong>Catatan Admin:</strong>
                                                        <div class="alert alert-info mt-2 mb-0">
                                                            {{ $pengajuan->catatan_admin }}
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Daftar Buku -->
                        <div class="row mb-4">
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
                                                <th>Stok Tersedia</th>
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
                                                        @php
                                                            $stok = $detail->bukuWajib
                                                                ? $detail->bukuWajib->stok
                                                                : $detail->bukuNonWajib->stok;
                                                        @endphp
                                                        <span
                                                            class="badge {{ $stok >= $detail->jumlah ? 'bg-success' : 'bg-danger' }}">
                                                            {{ $stok }} tersedia
                                                        </span>
                                                    </td>
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
                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('admin.pengajuan-peminjaman.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-arrow-left"></i> Kembali ke Daftar
                                    </a>

                                    @if ($pengajuan->status == 'pending')
                                        <div>
                                            <button type="button" class="btn btn-success me-2"
                                                onclick="approveModal({{ $pengajuan->id }}, '{{ $pengajuan->kode_pengajuan }}')">
                                                <i class="fas fa-check"></i> Setujui Pengajuan
                                            </button>
                                            <button type="button" class="btn btn-danger"
                                                onclick="rejectModal({{ $pengajuan->id }}, '{{ $pengajuan->kode_pengajuan }}')">
                                                <i class="fas fa-times"></i> Tolak Pengajuan
                                            </button>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Approve Modal -->
    <div class="modal fade" id="approveModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Setujui Pengajuan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="approveForm" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="modal-body">
                        <p>Yakin ingin menyetujui pengajuan <strong id="approveKode"></strong>?</p>
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i>
                            <strong>Catatan:</strong> Setelah disetujui, sistem akan otomatis membuat peminjaman dan
                            mengurangi stok buku.
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Catatan (Opsional):</label>
                            <textarea name="catatan_admin" class="form-control" rows="3" placeholder="Tambahkan catatan untuk siswa..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-check"></i> Setujui
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Reject Modal -->
    <div class="modal fade" id="rejectModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tolak Pengajuan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="rejectForm" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="modal-body">
                        <p>Yakin ingin menolak pengajuan <strong id="rejectKode"></strong>?</p>
                        <div class="mb-3">
                            <label class="form-label">Alasan Penolakan <span class="text-danger">*</span>:</label>
                            <textarea name="catatan_admin" class="form-control" rows="3" required
                                placeholder="Jelaskan alasan penolakan..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-times"></i> Tolak
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function approveModal(id, kode) {
                document.getElementById('approveKode').textContent = kode;
                document.getElementById('approveForm').action = `/admin/pengajuan-peminjaman/${id}/approve`;
                new bootstrap.Modal(document.getElementById('approveModal')).show();
            }

            function rejectModal(id, kode) {
                document.getElementById('rejectKode').textContent = kode;
                document.getElementById('rejectForm').action = `/admin/pengajuan-peminjaman/${id}/reject`;
                new bootstrap.Modal(document.getElementById('rejectModal')).show();
            }
        </script>
    @endpush
@endsection
