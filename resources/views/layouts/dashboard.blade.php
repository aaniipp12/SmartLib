<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SmartLib - Sistem Perpustakaan')</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
    @stack('styles')
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <a href="{{ route('dashboard') }}" class="logo">
                <i class="bi bi-book"></i>
                <span>SmartLib</span>
            </a>
        </div>
        <div class="sidebar-menu">
            <div class="menu-title">Menu</div>
            <div class="menu-item">
                <a href="{{ route('dashboard') }}" class="menu-link">
                    <i class="bi bi-speedometer2"></i>
                    <span>Dashboard</span>
                </a>
            </div>

            @if (auth()->check() && auth()->user()->hasRole('super_admin'))
                <div class="menu-title">Super Admin</div>
                <div class="menu-item">
                    <a href="#" class="menu-link">
                        <i class="bi bi-people"></i>
                        <span>Manajemen User</span>
                    </a>
                </div>
                <div class="menu-item">
                    <a href="#" class="menu-link">
                        <i class="bi bi-gear"></i>
                        <span>Pengaturan Sistem</span>
                    </a>
                </div>
            @endif

            @if (auth()->check() && (auth()->user()->hasRole('admin') || auth()->user()->hasRole('super_admin')))
                <div class="menu-title">Administrasi</div>
                <div class="menu-item">
                    <a href="#" class="menu-link">
                        <i class="bi bi-person-badge"></i>
                        <span>Data Siswa</span>
                    </a>
                </div>
                <div class="menu-item">
                    <a href="#" class="menu-link">
                        <i class="bi bi-building"></i>
                        <span>Data Kelas</span>
                    </a>
                </div>
                <div class="menu-item">
                    <a href="{{ route('admin.buku-wajib.index') }}" class="menu-link">
                        <i class="bi bi-book"></i>
                        <span>Buku Wajib</span>
                    </a>
                </div>
                <div class="menu-item">
                    <a href="{{ route('admin.buku-non-wajib.index') }}" class="menu-link">
                        <i class="bi bi-journal"></i>
                        <span>Buku Non-Wajib</span>
                    </a>
                </div>
                <div class="menu-item">
                    <a href="{{ route('admin.kategori-buku.index') }}" class="menu-link">
                        <i class="bi bi-tags"></i>
                        <span>Kategori Buku</span>
                    </a>
                </div>
                <div class="menu-item">
                    <a href="{{ route('admin.pengajuan-peminjaman.index') }}" class="menu-link">
                        <i class="bi bi-arrow-left-right"></i>
                        <span>Peminjaman</span>
                    </a>
                </div>
                <div class="menu-item">
                    <a href="#" class="menu-link">
                        <i class="bi bi-file-text"></i>
                        <span>Laporan</span>
                    </a>
                </div>
            @endif

            @if (auth()->check() && auth()->user()->hasRole('siswa'))
                <div class="menu-title">Siswa</div>
                <div class="menu-item">
                    <a href="#" class="menu-link">
                        <i class="bi bi-book"></i>
                        <span>Katalog Buku</span>
                    </a>
                </div>
                <div class="menu-item">
                    <a href="{{ route('siswa.pengajuan-peminjaman.index') }}" class="menu-link">
                        <i class="bi bi-list-check"></i>
                        <span>Peminjaman Saya</span>
                    </a>
                </div>
            @endif

            <div class="menu-title">Akun</div>
            <div class="menu-item">
                <a href="{{ route('profile.edit') }}" class="menu-link">
                    <i class="bi bi-person"></i>
                    <span>Profil Saya</span>
                </a>
            </div>
            <div class="menu-item">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a href="#" class="menu-link logout-btn"
                        onclick="event.preventDefault(); this.closest('form').submit();">
                        <i class="bi bi-box-arrow-right"></i>
                        <span>Logout</span>
                    </a>
                </form>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content" id="mainContent">
        <!-- Header -->
        <div class="header">
            <button class="sidebar-toggle" id="sidebarToggle">
                <i class="bi bi-list"></i>
            </button>
            <button class="sidebar-toggle d-md-none" id="mobileSidebarToggle">
                <i class="bi bi-list"></i>
            </button>
            <h1 class="page-title">@yield('page-title', 'Dashboard')</h1>
            <div class="header-right">
                <div class="user-info">
                    <div class="user-avatar">
                        {{ strtoupper(substr(auth()->user()->nama, 0, 1)) }}
                    </div>
                    <div>
                        <div style="font-weight: 600;">{{ auth()->user()->nama }}</div>
                        <div style="font-size: 12px; color: #6c757d;">
                            @if (auth()->user()->hasRole('super_admin'))
                                Super Administrator
                            @elseif(auth()->user()->hasRole('admin'))
                                Administrator
                            @else
                                Siswa
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Dashboard Content -->
        <div class="dashboard-content">
            @if (session('success'))
                <div class="alert alert-success">
                    <i class="bi bi-check-circle me-2"></i>
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">
                    <i class="bi bi-exclamation-circle me-2"></i>
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script src="{{ asset('js/dashboard.js') }}"></script>
    @stack('scripts')
</body>

</html>
