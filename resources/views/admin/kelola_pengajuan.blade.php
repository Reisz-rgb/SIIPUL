<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Pengajuan - SIIPUL</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        /* --- COPY STYLE DARI DASHBOARD BIAR KONSISTEN --- */
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
            width: var(--sidebar-width);
            height: 100vh;
            position: fixed;
            top: 0; left: 0;
            background: white;
            border-right: 1px solid var(--border-color);
            z-index: 1000;
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
        .avatar-circle {
            width: 36px; height: 36px; background-color: var(--primary-color);
            color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center;
            font-weight: 600; font-size: 0.9rem;
        }

        /* --- STYLE KHUSUS HALAMAN INI --- */
        .content-area { padding: 32px; }
        
        .card-clean {
            background: white; border: 1px solid var(--border-color);
            border-radius: 12px; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }

        /* Filter Toolbar */
        .filter-toolbar {
            display: flex; gap: 16px; margin-bottom: 24px; align-items: center; flex-wrap: wrap;
        }
        .search-input { min-width: 300px; }
        
        /* Table Styling (SaaS Style) */
        .table { margin-bottom: 0; }
        .table thead th {
            background-color: #F9FAFB; color: var(--text-muted);
            font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em;
            padding: 16px 24px; border-bottom: 1px solid var(--border-color); border-top: none;
        }
        .table tbody td {
            padding: 16px 24px; vertical-align: middle;
            border-bottom: 1px solid var(--border-color); color: var(--text-main); font-size: 0.9rem;
        }
        .table tbody tr:last-child td { border-bottom: none; }
        .table tbody tr:hover { background-color: #F9FAFB; }

        /* Status Badge (Modern Pill) */
        .badge-status {
            padding: 4px 12px; border-radius: 99px; font-size: 0.75rem; font-weight: 600;
            display: inline-flex; align-items: center; gap: 6px;
        }
        .badge-status::before { content: ""; width: 6px; height: 6px; border-radius: 50%; }
        
        .status-pending { background-color: #FFFBEB; color: #B45309; }
        .status-pending::before { background-color: #B45309; }
        
        .status-approved { background-color: #ECFDF5; color: #047857; }
        .status-approved::before { background-color: #047857; }
        
        .status-rejected { background-color: #FEF2F2; color: #B91C1C; }
        .status-rejected::before { background-color: #B91C1C; }

        /* Pagination Customization */
        .pagination .page-link { color: var(--text-main); border-color: var(--border-color); font-size: 0.875rem; }
        .pagination .page-item.active .page-link { background-color: var(--primary-color); border-color: var(--primary-color); color: white; }

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
            <a href="#" class="nav-item active"> <i class="bi bi-journal-check"></i> Kelola Pengajuan
            </a>
            <a href="{{ route('admin.kelola_pegawai') }}" class="nav-item">
                <i class="bi bi-people"></i> Data Pegawai
            </a>

            <div class="nav-section-label">LAPORAN</div>
            <a href="{{ route('admin.laporan') }}" class="nav-item">
                <i class="bi bi-file-earmark-bar-graph"></i> Rekap Bulanan
            </a>
        </div>
    </nav>

    <div class="main-wrapper">
        
        <header class="top-header">
            <div class="d-flex align-items-center gap-3">
                <h5 class="m-0 fw-bold">Kelola Pengajuan Cuti</h5>
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

            <form action="{{ route('admin.kelola_pengajuan') }}" method="GET">
                <div class="filter-toolbar">
                    <div class="search-input flex-grow-1">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-search"></i></span>
                            <input type="text" name="search" value="{{ request('search') }}" class="form-control border-start-0 ps-0" placeholder="Cari nama pegawai atau NIP...">
                        </div>
                    </div>
                    <div style="min-width: 200px;">
                        <select name="status" class="form-select" onchange="this.form.submit()">
                            <option value="Semua" {{ request('status') == 'Semua' ? 'selected' : '' }}>Semua Status</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu</option>
                            <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Disetujui</option>
                            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                    </div>
                </div>
            </form>

            <div class="card-clean">
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>Pegawai</th>
                                <th>Jenis Cuti</th>
                                <th>Periode Tanggal</th>
                                <th>Durasi</th>
                                <th>Status</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pengajuan as $item)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="avatar-circle bg-light text-secondary border" style="width: 32px; height: 32px; font-size: 0.75rem;">
                                            {{ substr($item->user->name, 0, 2) }}
                                        </div>
                                        <div>
                                            <div class="fw-semibold text-dark">{{ $item->user->name }}</div>
                                            <div class="text-muted small" style="font-size: 0.75rem;">NIP: {{ $item->user->nip ?? '-' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $item->jenis_cuti }}</td>
                                <td>
                                    <div class="text-dark">{{ \Carbon\Carbon::parse($item->start_date)->format('d M Y') }}</div>
                                    <div class="text-muted small" style="font-size: 0.75rem;">
                                        s/d {{ \Carbon\Carbon::parse($item->end_date)->format('d M Y') }}
                                    </div>
                                </td>
                                <td>
                                    <span class="text-dark fw-medium">
                                        {{ \Carbon\Carbon::parse($item->start_date)->diffInDays(\Carbon\Carbon::parse($item->end_date)) + 1 }}
                                    </span> 
                                    <span class="text-muted small">Hari</span>
                                </td>
                                <td>
                                    @if($item->status == 'pending')
                                        <span class="badge-status status-pending">Menunggu</span>
                                    @elseif($item->status == 'approved')
                                        <span class="badge-status status-approved">Disetujui</span>
                                    @else
                                        <span class="badge-status status-rejected">Ditolak</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('admin.pengajuan.show', $item->id) }}" class="btn btn-sm btn-outline-dark fw-medium" style="font-size: 0.8rem;">
                                        Review Detail
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <div class="text-muted mb-2"><i class="bi bi-clipboard-x" style="font-size: 2rem;"></i></div>
                                    <h6 class="fw-bold text-dark">Data tidak ditemukan</h6>
                                    <p class="text-muted small mb-0">Coba ubah filter atau kata kunci pencarian Anda.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($pengajuan->hasPages())
                <div class="px-4 py-3 border-top d-flex justify-content-end align-items-center">
                    {{ $pengajuan->withQueryString()->links() }}
                </div>
                @endif
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>