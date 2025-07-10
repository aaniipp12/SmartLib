@extends('layouts.dashboard')

@section('title', 'Pengajuan Peminjaman')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Riwayat Pengajuan Peminjaman</h5>
                        <a href="{{ route('siswa.pengajuan-peminjaman.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Ajukan Peminjaman Baru
                        </a>
                    </div>
                    <div class="card-body">
                        @if ($pengajuan->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Kode Pengajuan</th>
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
                                                    <a href="{{ route('siswa.pengajuan-peminjaman.show', $item->id) }}"
                                                        class="btn btn-sm btn-outline-primary">
                                                        <i class="fas fa-eye"></i> Detail
                                                    </a>
                                                    @if ($item->status == 'pending')
                                                        <form
                                                            action="{{ route('siswa.pengajuan-peminjaman.cancel', $item->id) }}"
                                                            method="POST" class="d-inline">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="submit" class="btn btn-sm btn-outline-danger"
                                                                onclick="return confirm('Yakin ingin membatalkan pengajuan ini?')">
                                                                <i class="fas fa-times"></i> Batal
                                                            </button>
                                                        </form>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="d-flex justify-content-center">
                                {{ $pengajuan->links() }}
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-book fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">Belum ada pengajuan peminjaman</h5>
                                <p class="text-muted">Mulai ajukan peminjaman buku untuk kebutuhan belajar Anda</p>
                                <a href="{{ route('siswa.pengajuan-peminjaman.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Ajukan Peminjaman Pertama
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
