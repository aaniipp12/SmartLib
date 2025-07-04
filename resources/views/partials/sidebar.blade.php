<div id="sidebar" class="active">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header position-relative">
            <div class="d-flex justify-content-between align-items-center">
                <div class="logo">
                    <a href="{{ route('dashboard') }}">
                        <img src="{{ asset('assets/images/logo/logo.png') }}" alt="Logo" srcset="">
                    </a>
                </div>
                <div class="theme-toggle d-flex gap-2 align-items-center mt-2">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true"
                        role="img" class="iconify iconify--system-uicons" width="20" height="20"
                        preserveAspectRatio="xMidYMid meet" viewBox="0 0 21 21">
                        <g fill="none" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path
                                d="M10.5 14.5c2.219 0 4-1.763 4-3.982a4.003 4.003 0 0 0-4-4.018c-2.219 0-4 1.781-4 4c0 2.219 1.781 4 4 4zM4.136 4.136L5.55 5.55m9.9 9.9l1.414 1.414M1.5 10.5h2m14 0h2M4.135 16.863L5.55 15.45m9.899-9.9l1.414-1.415M10.5 19.5v-2m0-14v-2"
                                opacity=".3"></path>
                            <g transform="translate(-210 -1)">
                                <path d="M220.5 2.5v2m6.5.5l-1.5 1.5"></path>
                                <circle cx="220.5" cy="11.5" r="4"></circle>
                                <path d="m214 5l1.5 1.5m5 14v-2m6.5-.5l-1.5-1.5M214 18l1.5-1.5m-4-5h2m14 0h2"></path>
                            </g>
                        </g>
                    </svg>
                    <div class="form-check form-switch fs-6">
                        <input class="form-check-input me-0" type="checkbox" id="toggle-dark">
                        <label class="form-check-label"></label>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true"
                        role="img" class="iconify iconify--mdi" width="20" height="20" preserveAspectRatio="xMidYMid meet"
                        viewBox="0 0 24 24">
                        <path fill="currentColor"
                            d="m17.75 4.09l-2.53 1.94l.91 3.06l-2.63-1.81l-2.63 1.81l.91-3.06L8.25 4.09l3.25.02l1.01-3.02l1.01 3.02l3.25-.02zm-9.1 6.27L6.5 8.5l.85 2.85L5.8 9.52l-1.55 1.83l.85-2.85L3.35 6.5l2.65-.02l.8-2.48l.8 2.48L10.25 6.5l-1.6 1.86zm6.4 6.4l-.85 2.85l1.55-1.83l1.55 1.83l-.85-2.85L18 14.5l-2.65.02l-.8-2.48l-.8 2.48L11.1 14.5l1.95 2.26z">
                        </path>
                    </svg>
                </div>
                <div class="sidebar-toggler x">
                    <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                </div>
            </div>
        </div>
        <div class="sidebar-menu">
            <ul class="menu">
                <li class="sidebar-title">Menu</li>

                <!-- Dashboard -->
                <li class="sidebar-item {{ request()->routeIs('*.dashboard') ? 'active' : '' }}">
                    <a href="{{ route('dashboard') }}" class='sidebar-link'>
                        <i class="bi bi-grid-fill"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                @hasrole('super_admin')
                <!-- Super Admin Menu -->
                <li class="sidebar-title">Super Admin</li>
                
                <li class="sidebar-item {{ request()->routeIs('superadmin.users.*') ? 'active' : '' }}">
                    <a href="#" class='sidebar-link'>
                        <i class="bi bi-people-fill"></i>
                        <span>Manajemen User</span>
                    </a>
                </li>

                <li class="sidebar-item {{ request()->routeIs('superadmin.system.*') ? 'active' : '' }}">
                    <a href="#" class='sidebar-link'>
                        <i class="bi bi-gear-fill"></i>
                        <span>Pengaturan Sistem</span>
                    </a>
                </li>
                @endhasrole

                @if(auth()->check() && (auth()->user()->hasRole('admin') || auth()->user()->hasRole('super_admin')))
                <!-- Admin Menu -->
                <li class="sidebar-title">Administrasi</li>
                
                <li class="sidebar-item {{ request()->routeIs('admin.siswa.*') ? 'active' : '' }}">
                    <a href="#" class='sidebar-link'>
                        <i class="bi bi-person-badge-fill"></i>
                        <span>Data Siswa</span>
                    </a>
                </li>

                <li class="sidebar-item {{ request()->routeIs('admin.kelas.*') ? 'active' : '' }}">
                    <a href="#" class='sidebar-link'>
                        <i class="bi bi-building"></i>
                        <span>Data Kelas</span>
                    </a>
                </li>

                <li class="sidebar-item has-sub {{ request()->routeIs('admin.buku.*') ? 'active' : '' }}">
                    <a href="#" class='sidebar-link'>
                        <i class="bi bi-book-fill"></i>
                        <span>Manajemen Buku</span>
                    </a>
                    <ul class="submenu">
                        <li class="submenu-item">
                            <a href="#">Buku Wajib</a>
                        </li>
                        <li class="submenu-item">
                            <a href="#">Buku Non-Wajib</a>
                        </li>
                        <li class="submenu-item">
                            <a href="#">Kategori Buku</a>
                        </li>
                    </ul>
                </li>

                <li class="sidebar-item has-sub {{ request()->routeIs('admin.peminjaman.*') ? 'active' : '' }}">
                    <a href="#" class='sidebar-link'>
                        <i class="bi bi-arrow-left-right"></i>
                        <span>Peminjaman</span>
                    </a>
                    <ul class="submenu">
                        <li class="submenu-item">
                            <a href="#">Peminjaman Baru</a>
                        </li>
                        <li class="submenu-item">
                            <a href="#">Pengembalian</a>
                        </li>
                        <li class="submenu-item">
                            <a href="#">Riwayat Peminjaman</a>
                        </li>
                    </ul>
                </li>

                <li class="sidebar-item {{ request()->routeIs('admin.laporan.*') ? 'active' : '' }}">
                    <a href="#" class='sidebar-link'>
                        <i class="bi bi-file-earmark-text-fill"></i>
                        <span>Laporan</span>
                    </a>
                </li>
                @endif

                @hasrole('siswa')
                <!-- Siswa Menu -->
                <li class="sidebar-title">Siswa</li>
                
                <li class="sidebar-item {{ request()->routeIs('siswa.profile.*') ? 'active' : '' }}">
                    <a href="#" class='sidebar-link'>
                        <i class="bi bi-person-fill"></i>
                        <span>Profil Saya</span>
                    </a>
                </li>

                <li class="sidebar-item has-sub {{ request()->routeIs('siswa.buku.*') ? 'active' : '' }}">
                    <a href="#" class='sidebar-link'>
                        <i class="bi bi-book-fill"></i>
                        <span>Katalog Buku</span>
                    </a>
                    <ul class="submenu">
                        <li class="submenu-item">
                            <a href="#">Buku Wajib</a>
                        </li>
                        <li class="submenu-item">
                            <a href="#">Buku Non-Wajib</a>
                        </li>
                    </ul>
                </li>

                <li class="sidebar-item {{ request()->routeIs('siswa.peminjaman.*') ? 'active' : '' }}">
                    <a href="#" class='sidebar-link'>
                        <i class="bi bi-arrow-left-right"></i>
                        <span>Peminjaman Saya</span>
                    </a>
                </li>
                @endhasrole

                <!-- User Info -->
                <li class="sidebar-title">Akun</li>
                <li class="sidebar-item">
                    <div class="sidebar-link">
                        <i class="bi bi-person-circle"></i>
                        <span>{{ auth()->user()->nama ?? 'User' }}</span>
                        <small class="d-block text-muted">
                            @if(auth()->user()->hasRole('super_admin'))
                                Super Admin
                            @elseif(auth()->user()->hasRole('admin'))
                                Admin
                            @elseif(auth()->user()->hasRole('siswa'))
                                Siswa
                            @endif
                        </small>
                    </div>
                </li>

                <!-- Logout -->
                <li class="sidebar-item">
                    <a href="#" class='sidebar-link text-danger' onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="bi bi-box-arrow-right"></i>
                        <span>Logout</span>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
            </ul>
        </div>
    </div>
</div>
