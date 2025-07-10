@extends('layouts.dashboard')

@section('title', 'Pilih Buku Wajib')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Buku Wajib Tingkat {{ $tingkat }}</h5>
                        <small class="text-muted">Pilih buku wajib yang ingin Anda pinjam</small>
                    </div>
                    <div class="card-body">
                        @if ($bukuWajib->count() > 0)
                            <form action="{{ route('siswa.pengajuan-peminjaman.store-buku-wajib') }}" method="POST">
                                @csrf

                                <div class="alert alert-info mb-4">
                                    <i class="fas fa-info-circle"></i>
                                    <strong>Informasi:</strong> Anda dapat memilih beberapa atau semua buku wajib sesuai
                                    kebutuhan.
                                </div>

                                <div class="row">
                                    @foreach ($bukuWajib as $buku)
                                        <div class="col-md-6 col-lg-4 mb-4">
                                            <div class="card h-100">
                                                <div class="card-body">
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input" type="checkbox" name="buku_ids[]"
                                                            value="{{ $buku->id }}" id="buku_{{ $buku->id }}">
                                                        <label class="form-check-label fw-bold"
                                                            for="buku_{{ $buku->id }}">
                                                            Pilih Buku Ini
                                                        </label>
                                                    </div>

                                                    <h6 class="card-title">{{ $buku->judul }}</h6>
                                                    <p class="card-text">
                                                        <small class="text-muted">
                                                            <strong>Penulis:</strong> {{ $buku->penulis }}<br>
                                                            <strong>Mata Pelajaran:</strong> {{ $buku->mata_pelajaran }}<br>
                                                            <strong>Penerbit:</strong> {{ $buku->penerbit }}<br>
                                                            <strong>Tahun:</strong> {{ $buku->tahun_terbit }}<br>
                                                            <strong>Stok:</strong>
                                                            <span
                                                                class="badge {{ $buku->stok > 5 ? 'bg-success' : ($buku->stok > 0 ? 'bg-warning' : 'bg-danger') }}">
                                                                {{ $buku->stok }} tersedia
                                                            </span>
                                                        </small>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="row mt-4">
                                    <div class="col-12">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <button type="button" class="btn btn-outline-primary" id="selectAll">
                                                    <i class="fas fa-check-square"></i> Pilih Semua
                                                </button>
                                                <button type="button" class="btn btn-outline-secondary" id="deselectAll">
                                                    <i class="fas fa-square"></i> Batal Pilih Semua
                                                </button>
                                            </div>
                                            <div>
                                                <a href="{{ route('siswa.pengajuan-peminjaman.create') }}"
                                                    class="btn btn-secondary">
                                                    <i class="fas fa-arrow-left"></i> Kembali
                                                </a>
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="fas fa-paper-plane"></i> Ajukan Peminjaman
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-book fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">Tidak ada buku wajib tersedia</h5>
                                <p class="text-muted">Saat ini tidak ada buku wajib yang tersedia untuk tingkat
                                    {{ $tingkat }}</p>
                                <a href="{{ route('siswa.pengajuan-peminjaman.create') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Kembali
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const selectAllBtn = document.getElementById('selectAll');
                const deselectAllBtn = document.getElementById('deselectAll');
                const checkboxes = document.querySelectorAll('input[name="buku_ids[]"]');

                selectAllBtn.addEventListener('click', function() {
                    checkboxes.forEach(checkbox => {
                        checkbox.checked = true;
                    });
                });

                deselectAllBtn.addEventListener('click', function() {
                    checkboxes.forEach(checkbox => {
                        checkbox.checked = false;
                    });
                });
            });
        </script>
    @endpush
@endsection
