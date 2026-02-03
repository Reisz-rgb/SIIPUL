<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - SIIPUL</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <style>
        /* Variables */
        :root {
            --primary: #9E2A2B;       /* Red Maroon */
            --primary-dark: #781F1F;  /* Dark Red */
            --secondary: #64748B;     /* Slate Grey */
            --bg-body: #F1F5F9;       /* Slate 100 */
            --sidebar-width: 270px;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-body);
            color: #334155;
            overflow-x: hidden; /* Prevent horizontal scroll */
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #CBD5E1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #94A3B8; }

        /* Sidebar */
        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            position: fixed;
            top: 0; left: 0;
            background: #FFFFFF;
            border-right: 1px dashed #E2E8F0;
            z-index: 1050; /* Di atas konten utama */
            padding: 24px;
            display: flex; flex-direction: column;
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .sidebar-brand {
            display: flex; align-items: center; gap: 12px; padding-bottom: 30px;
            text-decoration: none; color: var(--primary);
        }
        
        .nav-label {
            font-size: 0.7rem; font-weight: 700; color: #94A3B8;
            text-transform: uppercase; letter-spacing: 0.08em;
            margin: 20px 0 10px 12px;
        }

        .nav-link {
            display: flex; align-items: center; gap: 12px; padding: 12px 16px;
            color: #64748B; border-radius: 12px; font-weight: 500;
            transition: all 0.2s; margin-bottom: 4px; text-decoration: none;
        }

        .nav-link:hover { background-color: #FEF2F2; color: var(--primary); }

        /* Active State */
        .nav-link.active {
            background: linear-gradient(90deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            box-shadow: 0 4px 12px rgba(158, 42, 43, 0.3);
        }
        .nav-link.active i { color: white; }

        /* Main Layout */
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            transition: margin-left 0.3s ease-in-out;
        }

        /* Hero Banner */
        .hero-banner {
            background: linear-gradient(135deg, var(--primary) 0%, #561616 100%);
            height: 280px;
            padding: 40px;
            color: white;
            border-bottom-left-radius: 30px;
            border-bottom-right-radius: 30px;
        }

        /* Glass Profile */
        .glass-profile {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            padding: 8px 16px;
            border-radius: 50px;
            color: white;
            display: flex; align-items: center; gap: 12px;
            cursor: pointer; transition: 0.2s;
        }
        .glass-profile:hover { background: rgba(255, 255, 255, 0.2); }

        /* Cards & Widgets */
        .dashboard-container {
            padding: 0 40px 40px 40px;
            margin-top: -80px; /* Overlap */
        }

        .card-stat {
            background: white; border: none; border-radius: 16px;
            padding: 24px; box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.06);
            height: 100%; transition: transform 0.2s;
        }
        .card-stat:hover { transform: translateY(-5px); }

        .stat-icon {
            width: 48px; height: 48px; border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.4rem; margin-bottom: 16px;
        }

        .card-content {
            background: white; border-radius: 16px;
            border: 1px solid #F1F5F9;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.02);
            overflow: hidden;
        }
        .card-header-custom {
            padding: 24px; border-bottom: 1px dashed #E2E8F0;
            display: flex; justify-content: space-between; align-items: center;
        }

        .list-item-custom {
            padding: 16px 24px; border-bottom: 1px solid #F8FAFC;
            transition: background 0.1s;
        }
        .list-item-custom:hover { background-color: #FDFDFD; }

        /* Mobile UX */
        .mobile-toggler { 
            display: none; color: white; font-size: 1.5rem; 
            border: none; background: none; margin-right: 15px; 
        }
        
        #sidebarOverlay {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0, 0, 0, 0.5); z-index: 1040;
            display: none; backdrop-filter: blur(2px);
        }

        @media (max-width: 992px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.show { transform: translateX(0); }
            .main-content { margin-left: 0; }
            .hero-banner { border-radius: 0; padding: 20px; height: auto; padding-bottom: 100px; }
            .dashboard-container { padding: 0 20px 20px 20px; }
            .mobile-toggler { display: block; }
        }
    </style>
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
                    <div>
                        <h2 class="fw-bold m-0 text-white">Dashboard Overview</h2>
                        <p class="text-white text-opacity-75 m-0 small mt-1">Pantau aktivitas cuti pegawai secara real-time.</p>
                    </div>
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

        <div class="dashboard-container">
            <div class="row g-4 mb-4">
                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="card-stat">
                        <div class="stat-icon" style="background: #EFF6FF; color: #3B82F6;">
                            <i class="bi bi-files"></i>
                        </div>
                        <div class="text-muted small fw-bold text-uppercase">Total Pengajuan</div>
                        <div class="fs-2 fw-bold text-dark mt-1">{{ $totalPengajuan ?? 0 }}</div>
                        <div class="small text-muted mt-2"><i class="bi bi-calendar me-1"></i> Sepanjang waktu</div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="card-stat">
                        <div class="stat-icon" style="background: #F0FDF4; color: #16A34A;">
                            <i class="bi bi-check-lg"></i>
                        </div>
                        <div class="text-muted small fw-bold text-uppercase">Disetujui</div>
                        <div class="fs-2 fw-bold text-dark mt-1">{{ $disetujui ?? 0 }}</div>
                        <div class="small text-success mt-2"><i class="bi bi-graph-up-arrow me-1"></i> Sukses</div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="card-stat">
                        <div class="stat-icon" style="background: #FFF7ED; color: #EA580C;">
                            <i class="bi bi-hourglass-split"></i>
                        </div>
                        <div class="text-muted small fw-bold text-uppercase">Perlu Review</div>
                        <div class="fs-2 fw-bold text-dark mt-1">{{ $menunggu ?? 0 }}</div>
                        <div class="small text-warning mt-2"><i class="bi bi-exclamation-circle me-1"></i> Menunggu</div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="card-stat">
                        <div class="stat-icon" style="background: #FEF2F2; color: #DC2626;">
                            <i class="bi bi-x-octagon"></i>
                        </div>
                        <div class="text-muted small fw-bold text-uppercase">Ditolak</div>
                        <div class="fs-2 fw-bold text-dark mt-1">{{ $ditolak ?? 0 }}</div>
                        <div class="small text-danger mt-2">Tidak disetujui</div>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="card-content mb-4 h-100">
                        <div class="card-header-custom bg-white">
                            <h6 class="m-0 fw-bold text-dark">Statistik Bulanan</h6>
                            <button class="btn btn-sm btn-outline-light text-muted border">
                                <i class="bi bi-download me-1"></i> Report
                            </button>
                        </div>
                        <div class="p-4" style="height: 320px;">
                            <canvas id="statsChart"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card-content h-100">
                        <div class="card-header-custom bg-white">
                            <h6 class="m-0 fw-bold text-dark">
                                Menunggu Persetujuan
                                @if(isset($menunggu) && $menunggu > 0)
                                    <span class="badge bg-danger rounded-pill ms-1">{{ $menunggu }}</span>
                                @endif
                            </h6>
                            <a href="{{ route('admin.kelola_pengajuan') }}" class="small text-decoration-none fw-bold" style="color: var(--primary);">View All</a>
                        </div>
                        
                        <div class="list-group list-group-flush">
                            @forelse($pendingRequests ?? [] as $request)
                                <div class="list-item-custom d-flex gap-3 align-items-center">
                                    <div class="rounded-circle bg-light d-flex align-items-center justify-content-center flex-shrink-0" style="width: 42px; height: 42px; color: var(--secondary); font-weight: 700;">
                                        {{ substr(optional($request->user)->name ?? '?', 0, 1) }}
                                    </div>
                                    <div style="flex: 1; min-width: 0;">
                                        <div class="fw-bold text-dark text-truncate">{{ optional($request->user)->name ?? 'User Tidak Dikenal' }}</div>
                                        <div class="small text-muted">
                                            {{ $request->jenis_cuti }} &bull; {{ $request->duration }} Hari
                                        </div>
                                    </div>
                                    <div>
                                        <a href="{{ route('admin.pengajuan.show', $request->id) }}" class="btn btn-sm btn-light border text-secondary fw-medium rounded-pill px-3">Review</a>
                                    </div>
                                </div>
                            @empty
                                <div class="p-5 text-center">
                                    <i class="bi bi-clipboard-check fs-1 text-muted opacity-25"></i>
                                    <p class="text-muted small m-0 mt-2">Tidak ada pengajuan baru.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-5 text-center">
                <p class="text-muted small opacity-50">&copy; 2026 Pemerintah Kabupaten Semarang. Hak Cipta Dilindungi.</p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <script>
        // Toggle Sidebar Mobile
        const toggleBtn = document.querySelector('.mobile-toggler');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');

        function toggleSidebar() {
            sidebar.classList.toggle('show');
            if(sidebar.classList.contains('show')) {
                overlay.style.display = 'block';
            } else {
                overlay.style.display = 'none';
            }
        }

        if(toggleBtn) {
            toggleBtn.addEventListener('click', toggleSidebar);
        }

        // Close when clicking overlay
        if(overlay) {
            overlay.addEventListener('click', function() {
                sidebar.classList.remove('show');
                overlay.style.display = 'none';
            });
        }

        // Chart Configuration
        const ctx = document.getElementById('statsChart').getContext('2d');
        const labels = @json($chartLabels ?? ['Jan', 'Feb', 'Mar']);
        const approvedData = @json($dataApproved ?? [0, 0, 0]);
        const pendingData = @json($dataPending ?? [0, 0, 0]);
        const rejectedData = @json($dataRejected ?? [0, 0, 0]);

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [
                    { label: 'Disetujui', data: approvedData, backgroundColor: '#16A34A', borderRadius: 6, barPercentage: 0.6 },
                    { label: 'Menunggu', data: pendingData, backgroundColor: '#EA580C', borderRadius: 6, barPercentage: 0.6 },
                    { label: 'Ditolak', data: rejectedData, backgroundColor: '#DC2626', borderRadius: 6, barPercentage: 0.6 }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { 
                    legend: { position: 'bottom', labels: { usePointStyle: true, padding: 20, boxWidth: 8 } },
                    tooltip: { backgroundColor: '#1e293b', padding: 12, cornerRadius: 8 }
                },
                scales: {
                    y: { 
                        beginAtZero: true, 
                        border: { display: false }, 
                        grid: { borderDash: [4, 4], color: '#f1f5f9' },
                        ticks: { font: { size: 11 } }
                    },
                    x: { 
                        grid: { display: false },
                        ticks: { font: { size: 11 } }
                    }
                }
            }
        });
    </script>
</body>
</html>