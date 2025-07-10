@extends('layouts.dashboard')

@section('title', 'Pilih Buku Non-Wajib')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Pilih Buku Non-Wajib</h5>
                        <small class="text-muted">Pilih buku sesuai minat dan kebutuhan Anda</small>
                    </div>
                    <div class="card-body">
                        <!-- Filter Form -->
                        <form method="GET" class="mb-4">
                            <div class="row">
                                <div class="col-md-4">
                                    <select name="kategori_id" class="form-select">
                                        <option value="">Semua Kategori</option>
                                        @foreach ($kategori as $kat)
                                            <option value="{{ $kat->id }}"
                                                {{ request('kategori_id') == $kat->id ? 'selected' : '' }}>
                                                {{ $kat->nama_kategori }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" name="search" class="form-control"
                                        placeholder="Cari judul atau penulis..." value="{{ request('search') }}">
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-primary w-100">
                                        <i class="fas fa-search"></i> Cari
                                    </button>
                                </div>
                            </div>
                        </form>

                        @if ($bukuNonWajib->count() > 0)
                            <form action="{{ route('siswa.pengajuan-peminjaman.store-buku-non-wajib') }}" method="POST"
                                id="formPeminjaman">
                                @csrf

                                <div class="alert alert-info mb-4">
                                    <i class="fas fa-info-circle"></i>
                                    <strong>Informasi:</strong> Maksimal 5 buku per pengajuan. Anda dapat mengatur jumlah
                                    untuk setiap buku (maksimal 3 per judul).
                                </div>

                                <div class="row">
                                    @foreach ($bukuNonWajib as $buku)
                                        <div class="col-md-6 col-lg-4 mb-4">
                                            <div class="card h-100">
                                                <div class="card-body">
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input buku-checkbox" type="checkbox"
                                                            name="buku_ids[]" value="{{ $buku->id }}"
                                                            id="buku_{{ $buku->id }}">
                                                        <label class="form-check-label fw-bold"
                                                            for="buku_{{ $buku->id }}">
                                                            Pilih Buku Ini
                                                        </label>
                                                    </div>

                                                    <h6 class="card-title">{{ $buku->judul }}</h6>
                                                    <p class="card-text">
                                                        <small class="text-muted">
                                                            <strong>Penulis:</strong> {{ $buku->penulis }}<br>
                                                            <strong>Kategori:</strong>
                                                            {{ $buku->kategori->nama_kategori }}<br>
                                                            <strong>Penerbit:</strong> {{ $buku->penerbit }}<br>
                                                            <strong>Tahun:</strong> {{ $buku->tahun_terbit }}<br>
                                                            <strong>Stok:</strong>
                                                            <span
                                                                class="badge {{ $buku->stok > 5 ? 'bg-success' : ($buku->stok > 0 ? 'bg-warning' : 'bg-danger') }}">
                                                                {{ $buku->stok }} tersedia
                                                            </span>
                                                        </small>
                                                    </p>

                                                    <div class="jumlah-section" style="display: none;">
                                                        <label class="form-label">Jumlah:</label>
                                                        <select name="jumlah[{{ $buku->id }}]"
                                                            class="form-select form-select-sm">
                                                            @for ($i = 1; $i <= min(3, $buku->stok); $i++)
                                                                <option value="{{ $i }}">{{ $i }}
                                                                </option>
                                                            @endfor
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="row mt-4">
                                    <div class="col-12">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <span class="text-muted">Buku dipilih: <span
                                                        id="selectedCount">0</span>/5</span>
                                            </div>
                                            <div>
                                                <a href="{{ route('siswa.pengajuan-peminjaman.create') }}"
                                                    class="btn btn-secondary">
                                                    <i class="fas fa-arrow-left"></i> Kembali
                                                </a>
                                                <button type="submit" class="btn btn-primary" id="submitBtn" disabled>
                                                    <i class="fas fa-paper-plane"></i> Ajukan Peminjaman
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            <div class="d-flex justify-content-center mt-4">
                                {{ $bukuNonWajib->appends(request()->query())->links() }}
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-book fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">Tidak ada buku ditemukan</h5>
                                <p class="text-muted">Coba ubah filter atau kata kunci pencarian</p>
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
                const checkboxes = document.querySelectorAll('.buku-checkbox');
                const selectedCountSpan = document.getElementById('selectedCount');
                const submitBtn = document.getElementById('submitBtn');
                const maxBooks = 5;

                function updateSelectedCount() {
                    const selectedCheckboxes = document.querySelectorAll('.buku-checkbox:checked');
                    const count = selectedCheckboxes.length;

                    selectedCountSpan.textContent = count;
                    submitBtn.disabled = count === 0;

                    // Show/hide jumlah sections
                    checkboxes.forEach(checkbox => {
                        const jumlahSection = checkbox.closest('.card-body').querySelector('.jumlah-section');
                        if (checkbox.checked) {
                            jumlahSection.style.display = 'block';
                        } else {
                            jumlahSection.style.display = 'none';
                        }
                    });

                    // Disable unchecked checkboxes if max reached
                    if (count >= maxBooks) {
                        checkboxes.forEach(checkbox => {
                            if (!checkbox.checked) {
                                checkbox.disabled = true;
                            }
                        });
                    } else {
                        checkboxes.forEach(checkbox => {
                            checkbox.disabled = false;
                        });
                    }
                }

                checkboxes.forEach(checkbox => {
                    checkbox.addEventListener('change', updateSelectedCount);
                });

                // Initial update
                updateSelectedCount();
            });
        </script>
    @endpush
@endsection
