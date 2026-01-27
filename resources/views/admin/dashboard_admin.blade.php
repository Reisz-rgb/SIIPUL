<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - SIIPUL</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #9E2A2B;
            --primary-hover: #7F1D1D;
            --bg-body: #F3F4F6; /* Cool Gray */
            --sidebar-width: 260px;
            --border-color: #E5E7EB;
            --text-main: #111827;
            --text-muted: #6B7280;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-body);
            color: var(--text-main);
            overflow-x: hidden;
        }

        /* --- SIDEBAR --- */
        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            position: fixed;
            top: 0; left: 0;
            background: white;
            border-right: 1px solid var(--border-color);
            z-index: 1000;
            display: flex;
            flex-direction: column;
        }

        .sidebar-brand {
            padding: 24px;
            display: flex; align-items: center; gap: 12px;
            font-weight: 700; font-size: 1.25rem; color: var(--primary-color);
            text-decoration: none; border-bottom: 1px solid var(--border-color);
        }

        .nav-item {
            padding: 10px 24px;
            color: var(--text-muted);
            text-decoration: none;
            display: flex; align-items: center; gap: 12px;
            font-weight: 500;
            transition: all 0.2s;
            margin-bottom: 2px;
        }

        .nav-item:hover { color: var(--primary-color); background-color: #FEF2F2; }
        .nav-item.active { color: var(--primary-color); background-color: #FEF2F2; border-right: 3px solid var(--primary-color); }
        .nav-section-label {
            font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em;
            color: #9CA3AF; padding: 24px 24px 8px 24px; font-weight: 600;
        }

        /* --- MAIN CONTENT --- */
        .main-wrapper {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            display: flex; flex-direction: column;
        }

        /* --- TOP HEADER --- */
        .top-header {
            background: white;
            height: 70px;
            border-bottom: 1px solid var(--border-color);
            display: flex; align-items: center; justify-content: space-between;
            padding: 0 32px;
        }

        /* --- CARDS & WIDGETS --- */
        .content-area { padding: 32px; }

        .card-clean {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 12px;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            margin-bottom: 24px;
            overflow: hidden;
        }

        .stat-card {
            padding: 24px;
            display: flex; justify-content: space-between; align-items: flex-start;
        }
        .stat-title { font-size: 0.875rem; color: var(--text-muted); font-weight: 500; margin-bottom: 4px; }
        .stat-value { font-size: 1.75rem; font-weight: 700; color: var(--text-main); margin: 0; }
        .stat-icon {
            width: 48px; height: 48px; border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.25rem;
        }

        /* Activity Feed */
        .activity-item {
            padding: 16px 20px;
            border-bottom: 1px solid var(--border-color);
            display: flex; gap: 12px;
        }
        .activity-item:last-child { border-bottom: none; }
        .activity-dot {
            width: 10px; height: 10px; border-radius: 50%;
            margin-top: 6px; flex-shrink: 0;
        }

        /* Custom Form Elements */
        .form-control, .form-select {
            border-color: #D1D5DB; padding: 10px 14px; font-size: 0.9rem; border-radius: 8px;
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color); box-shadow: 0 0 0 3px rgba(158, 42, 43, 0.1);
        }

        /* User Dropdown */
        .user-menu-btn {
            display: flex; align-items: center; gap: 10px;
            padding: 6px 12px; border-radius: 8px;
            cursor: pointer; transition: background 0.2s;
            text-decoration: none; color: var(--text-main);
        }
        .user-menu-btn:hover { background-color: #F3F4F6; }
        .avatar-circle {
            width: 36px; height: 36px; background-color: var(--primary-color);
            color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center;
            font-weight: 600; font-size: 0.9rem;
        }

        @media (max-width: 992px) {
            .sidebar { transform: translateX(-100%); transition: transform 0.3s; }
            .main-wrapper { margin-left: 0; }
        }
    </style>
</head>
<body>

    <nav class="sidebar">
        <a href="#" class="sidebar-brand">
            <img src="{{ asset('logokabupatensemarang.png') }}" alt="Logo" width="32">
            <span>SIIPUL</span>
        </a>

        <div class="d-flex flex-column flex-grow-1 py-3">
            <div class="nav-section-label">UTAMA</div>
            <a href="#" class="nav-item active">
                <i class="bi bi-grid"></i> Dashboard
            </a>
            <a href="{{ route('admin.kelola_pengajuan') }}" class="nav-item">
                <i class="bi bi-journal-check"></i> Kelola Pengajuan
            </a>
            <a href="{{ route('admin.kelola_pegawai') }}" class="nav-item">
                <i class="bi bi-people"></i> Data Pegawai
            </a>

            <div class="nav-section-label">LAPORAN</div>
            <a href="{{ route('admin.laporan') }}" class="nav-item">
                <i class="bi bi-file-earmark-bar-graph"></i> Rekap Bulanan
            </a>
        </div>

        <div class="p-4 border-top">
            <div class="alert alert-light border mb-0 p-2 d-flex align-items-center gap-2">
                <i class="bi bi-database text-muted"></i>
                <div style="font-size: 0.75rem; line-height: 1.2;" class="text-muted">
                    Database Sinkron<br>
                    <strong>{{ $totalPengajuan }} Data</strong>
                </div>
            </div>
        </div>
    </nav>

    <div class="main-wrapper">
        
        <header class="top-header">
            <div class="d-flex align-items-center">
                <h5 class="m-0 fw-bold">Dashboard Overview</h5>
            </div>
            
            <div class="dropdown">
                <a href="#" class="user-menu-btn" data-bs-toggle="dropdown">
                    <div class="text-end d-none d-sm-block">
                        <div class="fw-bold" style="font-size: 0.9rem;">{{ Auth::user()->name }}</div>
                        <div class="text-muted" style="font-size: 0.75rem;">{{ ucfirst(Auth::user()->role) }}</div>
                    </div>
                    <div class="avatar-circle">{{ substr(Auth::user()->name, 0, 2) }}</div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow-sm border mt-2 p-2" style="border-radius: 8px;">
                    <li><a class="dropdown-item rounded" href="#">Profile Saya</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item rounded text-danger">Log Out</button>
                        </form>
                    </li>
                </ul>
            </div>
        </header>

        <div class="content-area">
            
            <div class="row g-4 mb-4">
                <div class="col-xl col-md-6"> <div class="card-clean stat-card h-100">
                        <div>
                            <div class="stat-title">Total Pengajuan</div>
                            <h2 class="stat-value">{{ $totalPengajuan }}</h2>
                            <small class="text-success fw-medium"><i class="bi bi-arrow-up-short"></i> All time</small>
                        </div>
                        <div class="stat-icon bg-primary bg-opacity-10 text-primary">
                            <i class="bi bi-files"></i>
                        </div>
                    </div>
                </div>

                <div class="col-xl col-md-6"> <div class="card-clean stat-card h-100">
                        <div>
                            <div class="stat-title">Disetujui</div>
                            <h2 class="stat-value">{{ $disetujui }}</h2>
                            <small class="text-muted">Permohonan sukses</small>
                        </div>
                        <div class="stat-icon bg-success bg-opacity-10 text-success">
                            <i class="bi bi-check-lg"></i>
                        </div>
                    </div>
                </div>

                <div class="col-xl col-md-6"> <div class="card-clean stat-card h-100">
                        <div>
                            <div class="stat-title">Ditolak</div>
                            <h2 class="stat-value text-danger">{{ $ditolak ?? 0 }}</h2> 
                            <small class="text-danger fw-medium">Permohonan ditolak</small>
                        </div>
                        <div class="stat-icon bg-danger bg-opacity-10 text-danger">
                            <i class="bi bi-x-circle"></i>
                        </div>
                    </div>
                </div>

                <div class="col-xl col-md-6"> <div class="card-clean stat-card h-100">
                        <div>
                            <div class="stat-title">Menunggu</div>
                            <h2 class="stat-value text-warning">{{ $menunggu }}</h2>
                            <small class="text-warning fw-medium">Perlu tindakan</small>
                        </div>
                        <div class="stat-icon bg-warning bg-opacity-10 text-warning">
                            <i class="bi bi-clock"></i>
                        </div>
                    </div>
                </div>

                <div class="col-xl col-md-6"> <div class="card-clean stat-card h-100">
                        <div>
                            <div class="stat-title">Pegawai Aktif</div>
                            <h2 class="stat-value">{{ $totalPegawai }}</h2>
                            <small class="text-muted">User terdaftar</small>
                        </div>
                        <div class="stat-icon bg-secondary bg-opacity-10 text-secondary">
                            <i class="bi bi-people"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-lg-8">
                    
                    <div class="card-clean p-4">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h6 class="fw-bold m-0">Statistik Cuti (6 Bulan)</h6>
                            <button class="btn btn-sm btn-outline-light text-muted border">
                                <i class="bi bi-download me-1"></i> Save Report
                            </button>
                        </div>
                        <div style="height: 320px;">
                            <canvas id="statsChart"></canvas>
                        </div>
                    </div>

                    <div class="card-clean">
                        <div class="p-3 px-4 border-bottom bg-light bg-opacity-25 d-flex justify-content-between align-items-center">
                            <h6 class="fw-bold m-0 text-dark">
                                <i class="bi bi-hourglass-split text-warning me-2"></i>Menunggu Persetujuan
                            </h6>
                            <span class="badge bg-warning text-dark rounded-pill">{{ $menunggu }} Pending</span>
                        </div>
                        
                        <div class="list-group list-group-flush">
                            @forelse($pendingRequests as $request)
                                <div class="list-group-item p-4 border-bottom">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="avatar-circle bg-light text-secondary" style="font-size: 0.8rem;">
                                                {{ substr($request->user->name, 0, 2) }}
                                            </div>
                                            <div>
                                                <h6 class="mb-1 fw-bold text-dark">{{ $request->user->name }}</h6>
                                                <div class="small text-muted mb-1">
                                                    {{ $request->jenis_cuti }} &bull; {{ $request->duration }} Hari
                                                </div>
                                                <div class="small text-secondary bg-light px-2 py-1 rounded d-inline-block">
                                                    {{ \Carbon\Carbon::parse($request->start_date)->format('d M') }} - 
                                                    {{ \Carbon\Carbon::parse($request->end_date)->format('d M Y') }}
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <a href="{{ route('admin.pengajuan.show', $request->id) }}" class="btn btn-sm btn-outline-dark">
                                                Review
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="p-5 text-center text-muted">
                                    <i class="bi bi-check-circle fs-1 text-light mb-3 d-block" style="color: #e5e7eb !important;"></i>
                                    Tidak ada pengajuan yang menunggu.
                                </div>
                            @endforelse
                        </div>
                        @if($menunggu > 0)
                        <div class="p-3 text-center bg-light bg-opacity-10">
                            <a href="{{ route('admin.kelola_pengajuan') }}" class="text-decoration-none fw-semibold" style="font-size: 0.9rem; color: var(--primary-color);">
                                Lihat Semua Pengajuan
                            </a>
                        </div>
                        @endif
                    </div>
                </div>

                <div class="col-lg-4">
                    
                    <div class="card-clean p-4">
                        <h6 class="fw-bold mb-3">Export Laporan</h6>
                        <form>
                            <div class="mb-3">
                                <label class="form-label small text-muted fw-bold">Periode Tanggal</label>
                                <div class="input-group">
                                    <input type="date" class="form-control" style="font-size: 0.8rem;">
                                    <span class="input-group-text bg-white text-muted">-</span>
                                    <input type="date" class="form-control" style="font-size: 0.8rem;">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small text-muted fw-bold">Filter</label>
                                <select class="form-select mb-2">
                                    <option value="">Semua Pegawai</option>
                                    @foreach($listPegawai as $pegawai)
                                        <option value="{{ $pegawai->id }}">{{ $pegawai->name }}</option>
                                    @endforeach
                                </select>
                                <select class="form-select">
                                    <option value="">Semua Status</option>
                                    <option value="approved">Disetujui</option>
                                    <option value="pending">Menunggu</option>
                                    <option value="rejected">Ditolak</option>
                                </select>
                            </div>
                            <div class="d-grid gap-2">
                                <button type="submit" formaction="{{ route('admin.download.excel') }}" class="btn btn-success text-white btn-sm py-2 fw-medium">
                                    <i class="bi bi-file-excel me-2"></i>Download Excel
                                </button>
                                <button type="submit" formaction="{{ route('admin.download.pdf') }}" class="btn btn-danger btn-sm py-2 fw-medium" style="background-color: #9E2A2B; border:none;">
                                    <i class="bi bi-file-pdf me-2"></i>Download PDF
                                </button>
                            </div>
                        </form>
                    </div>

                    <div class="card-clean">
                        <div class="p-3 border-bottom">
                            <h6 class="fw-bold m-0">Aktivitas Terakhir</h6>
                        </div>
                        <div class="bg-white">
                            @forelse($recentActivities as $activity)
                                <div class="activity-item">
                                    <div class="activity-dot {{ $activity->status == 'approved' ? 'bg-success' : ($activity->status == 'rejected' ? 'bg-danger' : 'bg-warning') }}"></div>
                                    <div>
                                        <div class="small text-dark fw-medium">
                                            {{ $activity->status == 'approved' ? 'Menyetujui cuti' : ($activity->status == 'rejected' ? 'Menolak cuti' : 'Pengajuan baru dari') }}
                                            <span class="fw-bold">{{ $activity->user->name }}</span>
                                        </div>
                                        <div class="text-muted" style="font-size: 0.75rem;">
                                            {{ $activity->jenis_cuti }} &bull; {{ $activity->updated_at->diffForHumans() }}
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="p-4 text-center small text-muted">Belum ada aktivitas.</div>
                            @endforelse
                        </div>
                    </div>

                </div>
            </div>
            
            <div class="text-center mt-4 mb-5">
                <small class="text-muted">&copy; 2026 Pemerintah Kabupaten Semarang. SIIPUL v2.0</small>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <script>
        const ctx = document.getElementById('statsChart').getContext('2d');
        const labels = @json($chartLabels);
        const dataApproved = @json($dataApproved);
        const dataRejected = @json($dataRejected);
        const dataPending = @json($dataPending);

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [
                    { label: 'Disetujui', data: dataApproved, backgroundColor: '#198754', borderRadius: 4, barPercentage: 0.6 },
                    { label: 'Ditolak', data: dataRejected, backgroundColor: '#dc3545', borderRadius: 4, barPercentage: 0.6 },
                    { label: 'Menunggu', data: dataPending, backgroundColor: '#ffc107', borderRadius: 4, barPercentage: 0.6 }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { 
                    legend: { position: 'bottom', labels: { usePointStyle: true, padding: 20 } } 
                },
                scales: {
                    y: { beginAtZero: true, grid: { borderDash: [2, 4], color: '#f3f4f6' }, ticks: { stepSize: 1 } },
                    x: { grid: { display: false } }
                }
            }
        });
    </script>
</body>
</html>