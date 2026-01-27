<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan & Analytics - SIIPUL</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        /* --- STYLE DASAR DASHBOARD (Konsisten) --- */
        :root {
            --primary-color: #9E2A2B;
            --primary-hover: #7F1D1D;
            --bg-body: #F3F4F6;
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

        /* Sidebar & Layout */
        .sidebar {
            width: var(--sidebar-width); height: 100vh; position: fixed; top: 0; left: 0;
            background: white; border-right: 1px solid var(--border-color); z-index: 1000;
            display: flex; flex-direction: column;
        }
        .sidebar-brand {
            padding: 24px; display: flex; align-items: center; gap: 12px;
            font-weight: 700; font-size: 1.25rem; color: var(--primary-color);
            text-decoration: none; border-bottom: 1px solid var(--border-color);
        }
        .nav-item {
            padding: 10px 24px; color: var(--text-muted); text-decoration: none;
            display: flex; align-items: center; gap: 12px; font-weight: 500; transition: all 0.2s;
            margin-bottom: 2px;
        }
        .nav-item:hover { color: var(--primary-color); background-color: #FEF2F2; }
        .nav-item.active { color: var(--primary-color); background-color: #FEF2F2; border-right: 3px solid var(--primary-color); }
        .nav-section-label {
            font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em;
            color: #9CA3AF; padding: 24px 24px 8px 24px; font-weight: 600;
        }
        
        .main-wrapper { margin-left: var(--sidebar-width); min-height: 100vh; display: flex; flex-direction: column; }
        
        /* Header */
        .top-header {
            background: white; height: 70px; border-bottom: 1px solid var(--border-color);
            display: flex; align-items: center; justify-content: space-between; padding: 0 32px;
        }
        .user-menu-btn { display: flex; align-items: center; gap: 10px; cursor: pointer; text-decoration: none; color: var(--text-main); }
        .avatar-header {
            width: 36px; height: 36px; background-color: var(--primary-color);
            color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center;
            font-weight: 600; font-size: 0.9rem;
        }

        /* --- CONTENT AREA & COMPONENTS --- */
        .content-area { padding: 32px; width: 100%; max-width: 1200px; margin: 0 auto; }
        
        .card-clean {
            background: white; border: 1px solid var(--border-color);
            border-radius: 12px; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            padding: 24px; height: 100%;
        }

        .btn-back-link {
            display: inline-flex; align-items: center; gap: 8px; 
            color: var(--text-muted); text-decoration: none; font-weight: 500; margin-right: 15px;
        }
        .btn-back-link:hover { color: var(--primary-color); }

        /* Filter & Inputs */
        .form-select-clean {
            border: 1px solid var(--border-color); border-radius: 8px; padding: 8px 14px;
            font-size: 0.9rem; color: var(--text-main); background-color: white;
            cursor: pointer;
        }
        
        /* Export Buttons */
        .btn-export {
            padding: 8px 16px; border-radius: 8px; font-size: 0.85rem; font-weight: 500;
            display: flex; align-items: center; gap: 8px; text-decoration: none; transition: 0.2s; border: 1px solid transparent;
        }
        .btn-export-pdf { background-color: #FEF2F2; color: #991B1B; border-color: #FECACA; }
        .btn-export-pdf:hover { background-color: #FEE2E2; color: #7F1D1D; }
        .btn-export-excel { background-color: #ECFDF5; color: #065F46; border-color: #A7F3D0; }
        .btn-export-excel:hover { background-color: #D1FAE5; color: #047857; }

        /* Stat Cards */
        .stat-label { font-size: 0.85rem; color: var(--text-muted); font-weight: 500; }
        .stat-value { font-size: 1.75rem; font-weight: 700; margin: 8px 0; color: var(--text-main); }
        .stat-desc { font-size: 0.75rem; color: #9CA3AF; }

        /* Progress Bars */
        .chart-title { font-weight: 600; font-size: 1rem; margin-bottom: 20px; color: var(--text-main); }
        .progress-label { display: flex; justify-content: space-between; font-size: 0.85rem; margin-bottom: 6px; color: var(--text-main); font-weight: 500; }
        .progress-custom { height: 8px; border-radius: 4px; background-color: #F3F4F6; margin-bottom: 20px; box-shadow: inset 0 1px 2px rgba(0,0,0,0.05); }
        
        /* Table Styles */
        .table-custom { width: 100%; border-collapse: separate; border-spacing: 0; }
        .table-custom th { 
            font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; 
            color: var(--text-muted); font-weight: 600; padding: 12px 16px; 
            background-color: #F9FAFB; border-bottom: 1px solid var(--border-color); 
        }
        .table-custom td { padding: 16px; vertical-align: middle; font-size: 0.9rem; border-bottom: 1px solid var(--border-color); }
        .table-custom tr:last-child td { border-bottom: none; }
        
        .badge-num { 
            display: inline-flex; align-items: center; justify-content: center;
            padding: 4px 10px; border-radius: 6px; font-size: 0.75rem; font-weight: 600; min-width: 40px; 
        }
        .bg-light-green { background-color: #ECFDF5; color: #059669; }
        .bg-light-red { background-color: #FEF2F2; color: #DC2626; }
        .bg-light-yellow { background-color: #FFFBEB; color: #D97706; }
        
        @media (max-width: 992px) {
            .sidebar { transform: translateX(-100%); transition: transform 0.3s; }
            .main-wrapper { margin-left: 0; }
        }
    </style>
</head>
<body>

    <nav class="sidebar">
        <a href="{{ route('admin.dashboard') }}" class="sidebar-brand">
            <img src="{{ asset('logokabupatensemarang.png') }}" alt="Logo" width="32">
            <span>SIIPUL</span>
        </a>

        <div class="d-flex flex-column flex-grow-1 py-3">
            <div class="nav-section-label">UTAMA</div>
            <a href="{{ route('admin.dashboard') }}" class="nav-item">
                <i class="bi bi-grid"></i> Dashboard
            </a>
            <a href="{{ route('admin.kelola_pengajuan') }}" class="nav-item">
                <i class="bi bi-journal-check"></i> Kelola Pengajuan
            </a>
            <a href="{{ route('admin.kelola_pegawai') }}" class="nav-item">
                <i class="bi bi-people"></i> Data Pegawai
            </a>

            <div class="nav-section-label">LAPORAN</div>
            <a href="{{ route('admin.laporan') }}" class="nav-item active">
                <i class="bi bi-file-earmark-bar-graph"></i> Rekap Bulanan
            </a>
        </div>
    </nav>

    <div class="main-wrapper">
        
        <header class="top-header">
            <div class="d-flex align-items-center gap-3">
                <h5 class="m-0 fw-bold">Rekap Laporan</h5>
            </div>
            
            <div class="dropdown">
                <a href="#" class="user-menu-btn" data-bs-toggle="dropdown">
                    <div class="text-end d-none d-sm-block">
                        <div class="fw-bold" style="font-size: 0.9rem;">{{ Auth::user()->name ?? 'Admin' }}</div>
                        <div class="text-muted" style="font-size: 0.75rem;">{{ ucfirst(Auth::user()->role) }}</div>
                    </div>
                    <div class="avatar-header">{{ substr(Auth::user()->name ?? 'A', 0, 2) }}</div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow-sm border mt-2 p-2 rounded-3">
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

            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
                <div class="d-flex align-items-center">
                    <a href="{{ route('admin.dashboard') }}" class="btn-back-link"><i class="bi bi-arrow-left fs-5"></i></a>
                    <div>
                        <h4 class="fw-bold mb-0">Analytics & Statistik</h4>
                        <div class="text-muted small">Data Periode: {{ $labelWaktu }}</div>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.download.pdf', request()->all()) }}" class="btn-export btn-export-pdf">
                        <i class="bi bi-file-earmark-pdf"></i> Download PDF
                    </a>
                    <a href="{{ route('admin.download.excel', request()->all()) }}" class="btn-export btn-export-excel">
                        <i class="bi bi-file-earmark-spreadsheet"></i> Export Excel
                    </a>
                </div>
            </div>

            <div class="card-clean mb-4 p-3 d-flex align-items-center gap-3">
                <label class="small text-muted fw-bold m-0"><i class="bi bi-funnel"></i> FILTER WAKTU:</label>
                <form action="{{ route('admin.laporan') }}" method="GET" class="flex-grow-1">
                    <select name="filter" class="form-select-clean" style="max-width: 250px;" onchange="this.form.submit()">
                        <option value="1_bulan" {{ $filter == '1_bulan' ? 'selected' : '' }}>1 Bulan Terakhir</option>
                        <option value="3_bulan" {{ $filter == '3_bulan' ? 'selected' : '' }}>3 Bulan Terakhir</option>
                        <option value="tahun_ini" {{ $filter == 'tahun_ini' ? 'selected' : '' }}>Tahun Ini</option>
                    </select>
                </form>
            </div>

            <div class="row g-3 mb-4">
                <div class="col-md-3">
                    <div class="card-clean">
                        <span class="stat-label">Total Pengajuan</span>
                        <h3 class="stat-value">{{ $total }}</h3>
                        <span class="stat-desc">Dalam periode ini</span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card-clean">
                        <span class="stat-label">Tingkat Persetujuan</span>
                        <h3 class="stat-value" style="color: #059669;">{{ $persenApproved }}%</h3>
                        <span class="stat-desc">{{ $approved }} dari {{ $total }} disetujui</span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card-clean">
                        <span class="stat-label">Rata-rata Proses</span>
                        <h3 class="stat-value" style="color: #D97706;">{{ $avgDays }} hari</h3>
                        <span class="stat-desc">Durasi review</span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card-clean">
                        <span class="stat-label">Sedang Menunggu</span>
                        <h3 class="stat-value" style="color: #2563EB;">{{ $pending }}</h3>
                        <span class="stat-desc">{{ $persenPending }}% dari total</span>
                    </div>
                </div>
            </div>

            <div class="row g-4 mb-4">
                <div class="col-md-6">
                    <div class="card-clean">
                        <h6 class="chart-title">Status Pengajuan</h6>
                        
                        <div class="mt-4">
                            <div class="progress-label">
                                <span>Disetujui</span> <span class="fw-bold text-success">{{ $approved }}</span>
                            </div>
                            <div class="progress progress-custom">
                                <div class="progress-bar bg-success" role="progressbar" style="width: {{ $persenApproved }}%"></div>
                            </div>

                            <div class="progress-label">
                                <span>Ditolak</span> <span class="fw-bold text-danger">{{ $rejected }}</span>
                            </div>
                            <div class="progress progress-custom">
                                <div class="progress-bar bg-danger" role="progressbar" style="width: {{ $persenRejected }}%"></div>
                            </div>

                            <div class="progress-label">
                                <span>Menunggu</span> <span class="fw-bold text-warning">{{ $pending }}</span>
                            </div>
                            <div class="progress progress-custom">
                                <div class="progress-bar bg-warning" role="progressbar" style="width: {{ $persenPending }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card-clean">
                        <h6 class="chart-title">Distribusi Jenis Cuti</h6>
                        <div style="height: 250px; display: flex; justify-content: center; position: relative;">
                            <canvas id="jenisCutiChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-clean p-0 overflow-hidden">
                <div class="p-4 border-bottom border-light">
                    <h6 class="chart-title mb-0">Statistik Detail per Unit Kerja</h6>
                </div>
                <div class="table-responsive">
                    <table class="table-custom mb-0">
                        <thead>
                            <tr>
                                <th style="padding-left: 24px;">Unit Kerja</th>
                                <th class="text-center">Disetujui</th>
                                <th class="text-center">Ditolak</th>
                                <th class="text-center">Menunggu</th>
                                <th class="text-center">Total</th>
                                <th class="text-end" style="padding-right: 24px;">Rate Setuju</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($unitStats as $stat)
                            <tr>
                                <td style="padding-left: 24px; font-weight: 500;">{{ $stat['name'] }}</td>
                                <td class="text-center"><span class="badge-num bg-light-green">{{ $stat['approved'] }}</span></td>
                                <td class="text-center"><span class="badge-num bg-light-red">{{ $stat['rejected'] }}</span></td>
                                <td class="text-center"><span class="badge-num bg-light-yellow">{{ $stat['pending'] }}</span></td>
                                <td class="text-center text-muted fw-bold">{{ $stat['total'] }}</td>
                                <td class="text-end fw-bold" style="padding-right: 24px; color: #059669;">{{ $stat['rate'] }}%</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">Belum ada data pengajuan pada periode ini.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Data dari Controller
        const labels = {!! json_encode($chartLabels) !!};
        const dataValues = {!! json_encode($chartValues) !!};

        // Inisialisasi Pie Chart
        const ctx = document.getElementById('jenisCutiChart').getContext('2d');
        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: labels.length ? labels : ['Belum ada data'],
                datasets: [{
                    data: dataValues.length ? dataValues : [1], 
                    backgroundColor: [
                        '#10B981', // Emerald 500
                        '#F59E0B', // Amber 500
                        '#EF4444', // Red 500
                        '#3B82F6', // Blue 500
                        '#6B7280', // Gray 500
                        '#8B5CF6'  // Violet 500
                    ],
                    borderWidth: 2,
                    borderColor: '#ffffff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { 
                            usePointStyle: true, 
                            boxWidth: 8, 
                            padding: 20,
                            font: { family: "'Inter', sans-serif", size: 11 }
                        }
                    },
                    tooltip: {
                        enabled: labels.length > 0
                    }
                }
            }
        });
    </script>
</body>
</html>