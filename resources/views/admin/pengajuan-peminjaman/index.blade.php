@extends('layouts.dashboard')

@section('title', 'Kelola Pengajuan Peminjaman')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Kelola Pengajuan Peminjaman</h5>
                    </div>
                    <div class="card-body">
                        <!-- Filter Form -->
                        <form method="GET" class="mb-4">
                            <div class="row">
                                <div class="col-md-3">
                                    <select name="status" class="form-select">
                                        <option value="">Semua Status</option>
                                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>
                                            Pending</option>
                                        <option value="disetujui" {{ request('status') == 'disetujui' ? 'selected' : '' }}>
                                            Disetujui</option>
                                        <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>
                                            Ditolak</option>
                                        <option value="dipinjam" {{ request('status') == 'dipinjam' ? 'selected' : '' }}>
                                            Dipinjam</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <select name="jenis" class="form-select">
                                        <option value="">Semua Jenis</option>
                                        <option value="wajib" {{ request('jenis') == 'wajib' ? 'selected' : '' }}>Buku
                                            Wajib</option>
                                        <option value="non_wajib" {{ request('jenis') == 'non_wajib' ? 'selected' : '' }}>
                                            Buku Non-Wajib</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" name="search" class="form-control"
                                        placeholder="Cari kode pengajuan, nama siswa, atau NIS..."
                                        value="{{ request('search') }}">
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-primary w-100">
                                        <i class="fas fa-search"></i> Cari
                                    </button>
                                </div>
                            </div>
                        </form>

                        @if ($pengajuan->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Kode Pengajuan</th>
                                            <th>Siswa</th>
                                            <th>Kelas</th>
                                            <th>Jenis</th>
                                            <th>Jumlah Buku</th>
                                            <th>Tanggal Pengajuan</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pengajuan as $item)
                                            <tr>
                                                <td>
                                                    <strong>{{ $item->kode_pengajuan }}</strong>
                                                </td>
                                                <td>
                                                    <div>
                                                        <strong>{{ $item->user->name }}</strong><br>
                                                        <small class="text-muted">NIS: {{ $item->user->nis }}</small>
                                                    </div>
                                                </td>
                                                <td>{{ $item->user->kelas->nama_kelas }}</td>
                                                <td>
                                                    <span
                                                        class="badge {{ $item->jenis_peminjaman == 'wajib' ? 'bg-info' : 'bg-secondary' }}">
                                                        {{ $item->jenis_peminjaman == 'wajib' ? 'Buku Wajib' : 'Buku Non-Wajib' }}
                                                    </span>
                                                </td>
                                                <td>{{ $item->getTotalBuku() }} buku</td>
                                                <td>{{ $item->tanggal_pengajuan->format('d/m/Y H:i') }}</td>
                                                <td>
                                                    <span class="badge {{ $item->status_badge }}">
                                                        {{ $item->status_text }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <a href="{{ route('admin.pengajuan-peminjaman.show', $item->id) }}"
                                                        class="btn btn-sm btn-outline-primary">
                                                        <i class="fas fa-eye"></i> Detail
                                                    </a>
                                                    @if ($item->status == 'pending')
                                                        <div class="btn-group" role="group">
                                                            <button type="button" class="btn btn-sm btn-success"
                                                                onclick="approveModal({{ $item->id }}, '{{ $item->kode_pengajuan }}')">
                                                                <i class="fas fa-check"></i> Setujui
                                                            </button>
                                                            <button type="button" class="btn btn-sm btn-danger"
                                                                onclick="rejectModal({{ $item->id }}, '{{ $item->kode_pengajuan }}')">
                                                                <i class="fas fa-times"></i> Tolak
                                                            </button>
                                                        </div>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="d-flex justify-content-center">
                                {{ $pengajuan->appends(request()->query())->links() }}
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-clipboard-list fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">Tidak ada pengajuan peminjaman</h5>
                                <p class="text-muted">Belum ada pengajuan peminjaman dari siswa</p>
                            </div>
                        @endif
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
