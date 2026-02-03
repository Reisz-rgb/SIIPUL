<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin - SIIPUL')</title>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    @stack('head')
</head>
<body>

    <div id="sidebarOverlay"></div>

    <nav class="sidebar" id="sidebar">
        <a href="#" class="sidebar-brand">
            <img src="{{ asset('logokabupatensemarang.png') }}" alt="Logo" width="36">
            <div style="line-height: 1.1;">
                <div style="font-weight: 800; font-size: 1.1rem; letter-spacing: -0.5px;">SIIPUL</div>
                <div style="font-size: 0.7rem; color: #94A3B8; font-weight: 500;">Kab. Semarang</div>
            </div>
        </a>

        <div style="overflow-y: auto; flex: 1;" class="custom-scrollbar">
            <div class="nav-label">Main Menu</div>

            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid-fill"></i> Dashboard
            </a>

            <a href="{{ route('admin.kelola_pengajuan') }}" class="nav-link {{ request()->routeIs('admin.kelola_pengajuan*') ? 'active' : '' }}">
                <i class="bi bi-file-earmark-text"></i> Pengajuan Cuti
                @if(isset($menunggu) && $menunggu > 0)
                    <span class="badge bg-danger rounded-pill ms-auto" style="font-size: 0.7rem">{{ $menunggu }}</span>
                @endif
            </a>

            <a href="{{ route('admin.kelola_pegawai') }}" class="nav-link {{ request()->routeIs('admin.kelola_pegawai*') ? 'active' : '' }}">
                <i class="bi bi-people"></i> Data Pegawai
            </a>

            <div class="nav-label">Laporan</div>
            <a href="{{ route('admin.laporan') }}" class="nav-link {{ request()->routeIs('admin.laporan*') ? 'active' : '' }}">
                <i class="bi bi-printer"></i> Rekapitulasi
            </a>
        </div>

        <div class="mt-auto pt-4 border-top border-dashed">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-outline-danger w-100 border-0 d-flex align-items-center gap-2 px-3 py-2 bg-light" style="font-size: 0.9rem;">
                    <i class="bi bi-box-arrow-left"></i> Keluar Aplikasi
                </button>
            </form>
        </div>
    </nav>

    <div class="main-content">

        <div class="hero-banner">
            <div class="d-flex justify-content-between align-items-start">
                <div class="d-flex align-items-center">
                    <button class="mobile-toggler">
                        <i class="bi bi-list"></i>
                    </button>

                    @hasSection('hero_left')
                        @yield('hero_left')
                    @else
                        <div>
                            <h2 class="fw-bold m-0 text-white">@yield('page_title', 'Dashboard Overview')</h2>
                            <p class="text-white text-opacity-75 m-0 small mt-1">@yield('page_subtitle', 'Pantau aktivitas cuti pegawai secara real-time.')</p>
                        </div>
                    @endif
                </div>

                <div class="dropdown">
                    <div class="glass-profile" data-bs-toggle="dropdown">
                        <div class="rounded-circle bg-white text-danger fw-bold d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                            {{ substr(Auth::user()->name ?? 'A', 0, 1) }}
                        </div>
                        <span class="d-none d-md-block small fw-medium">{{ Auth::user()->name ?? 'Admin' }}</span>
                        <i class="bi bi-chevron-down small d-none d-md-block"></i>
                    </div>
                    <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 mt-2 p-2 rounded-3">
                        <li><a class="dropdown-item rounded small" href="#">Profile Saya</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item rounded small text-danger">Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Toggle Sidebar (SAMA seperti versi admin original)
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        const toggler = document.querySelector('.mobile-toggler');

        function toggleSidebar() {
            sidebar.classList.toggle('show');
            overlay.style.display = sidebar.classList.contains('show') ? 'block' : 'none';
        }

        if (toggler) toggler.addEventListener('click', toggleSidebar);
        if (overlay) overlay.addEventListener('click', toggleSidebar);
    </script>

    @stack('scripts')
</body>
</html>
