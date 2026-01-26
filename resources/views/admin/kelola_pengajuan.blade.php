<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Pengajuan Cuti - SIIPUL</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <style>
        :root {
            --primary-red: #A52A2A;
            --bg-light: #f8f9fa;
        }
        body { background-color: var(--bg-light); font-family: 'Segoe UI', sans-serif; }

        /* Navbar */
        .navbar-custom { background-color: var(--primary-red); color: white; }
        .navbar-brand { 
            font-weight: bold; font-size: 1.2rem; display: flex; align-items: center; gap: 10px; 
            color: white !important; 
        }
        .navbar-brand:hover { color: #e0e0e0 !important; }

        /* Profile Pill */
        .user-pill { 
            background: white; color: #333; padding: 5px 6px 5px 6px; 
            border-radius: 50px; display: flex; align-items: center; gap: 10px; 
            font-weight: 600; font-size: 0.9rem; text-decoration: none;
        }
        .avatar-circle {
            width: 32px; height: 32px; background-color: var(--primary-red);
            color: white; border-radius: 50%; display: flex;
            align-items: center; justify-content: center; font-size: 0.75rem; font-weight: bold;
        }

        /* Page Header */
        .page-header { display: flex; align-items: center; margin-bottom: 20px; position: relative; }
        .page-title { flex-grow: 1; text-align: center; font-size: 1.5rem; color: #444; font-weight: 500; }
        .btn-back-arrow { font-size: 1.5rem; color: #333; text-decoration: none; position: absolute; left: 0; }
        .btn-back-arrow:hover { color: var(--primary-red); }

        /* Filter Section */
        .filter-card { border: 1px solid #e0e0e0; border-radius: 8px; padding: 20px; background: white; margin-bottom: 20px; }
        
        /* Table Styling */
        .table-card { background: white; border: 1px solid #e0e0e0; border-radius: 8px; padding: 0; overflow: hidden; }
        .table thead th { background-color: #f9f9f9; font-weight: 600; color: #666; font-size: 0.9rem; border-bottom: 2px solid #eee; padding: 15px; }
        .table tbody td { padding: 15px; vertical-align: middle; font-size: 0.9rem; color: #333; border-bottom: 1px solid #eee; }
        
        /* Status Badges */
        .badge-status { padding: 5px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; display: inline-block; }
        .status-menunggu { background-color: #fff8e1; color: #ffc107; border: 1px solid #ffe69c; } /* Pending */
        .status-disetujui { background-color: #e6f8ef; color: #198754; border: 1px solid #c3e6cb; } /* Approved */
        .status-ditolak { background-color: #ffeef0; color: #dc3545; border: 1px solid #f5c6cb; } /* Rejected */

        /* Detail Button */
        .btn-detail-custom {
            color: #A52A2A; border: 1px solid #A52A2A; background: white;
            padding: 5px 15px; border-radius: 6px; font-size: 0.85rem; font-weight: 500;
            transition: all 0.2s; text-decoration: none; display: inline-block;
        }
        .btn-detail-custom:hover { background-color: #A52A2A; color: white; }

        /* NIP Small Text */
        .text-nip { font-size: 0.75rem; color: #888; display: block; margin-top: 2px; }

        /* Pagination Style Fix */
        .pagination { margin-bottom: 0; }
        .page-link { color: var(--primary-red); }
        .page-item.active .page-link { background-color: var(--primary-red); border-color: var(--primary-red); color: white; }
    </style>
</head>
<body>

    <nav class="navbar navbar-custom py-3">
        <div class="container-fluid px-4">
            <a class="navbar-brand" href="{{ route('admin.dashboard') }}">
                <img src="{{ asset('logokabupatensemarang.png') }}" alt="Logo" width="40" height="auto" class="d-inline-block align-text-top me-2"> 
                SIIPUL Dashboard
            </a>
            
            <div class="user-pill">
                <div class="avatar-circle">{{ substr(Auth::user()->name, 0, 2) }}</div> 
                <div style="line-height: 1.2;">
                    <span class="d-block">{{ Str::limit(Auth::user()->name, 20) }}</span>
                    <span class="d-block text-muted" style="font-size: 0.7rem; font-weight: normal;">Administrator</span>
                </div>
            </div>
        </div>
    </nav>

    <div class="container-fluid px-4 mt-4 mb-5">
        
        <div class="page-header">
            <a href="{{ route('admin.dashboard') }}" class="btn-back-arrow"><i class="bi bi-arrow-left"></i></a>
            <h4 class="page-title">Kelola Pengajuan Cuti</h4>
        </div>

        <div class="filter-card shadow-sm">
            <form action="{{ route('admin.kelola_pengajuan') }}" method="GET">
                <div class="row g-3">
                    <div class="col-md-8">
                        <label class="form-label small text-muted">Cari Pegawai</label>
                        <input type="text" name="search" value="{{ request('search') }}" class="form-control bg-light border-0" placeholder="Nama pegawai atau NIP lalu tekan Enter...">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small text-muted">Filter Status</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0"><i class="bi bi-funnel text-muted"></i></span>
                            <select name="status" class="form-select border-start-0 bg-light" onchange="this.form.submit()">
                                <option value="Semua" {{ request('status') == 'Semua' ? 'selected' : '' }}>Semua Status</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu</option>
                                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Disetujui</option>
                                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                            </select>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="table-card shadow-sm">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th style="width: 25%;">Nama Pegawai</th>
                            <th>Jenis Cuti</th>
                            <th>Periode</th>
                            <th>Durasi</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pengajuan as $item)
                        <tr>
                            <td>
                                <span class="fw-bold">{{ $item->user->name }}</span>
                                <span class="text-nip">{{ $item->user->nip ?? '-' }}</span>
                            </td>
                            <td>{{ $item->jenis_cuti }}</td>
                            <td>
                                {{ \Carbon\Carbon::parse($item->start_date)->format('d M Y') }} 
                                <span class="text-muted small">s/d</span> 
                                {{ \Carbon\Carbon::parse($item->end_date)->format('d M Y') }}
                            </td>
                            <td>
                                {{ \Carbon\Carbon::parse($item->start_date)->diffInDays(\Carbon\Carbon::parse($item->end_date)) + 1 }} Hari
                            </td>
                            <td>
                                @if($item->status == 'pending')
                                    <span class="badge-status status-menunggu">Menunggu</span>
                                @elseif($item->status == 'approved')
                                    <span class="badge-status status-disetujui">Disetujui</span>
                                @else
                                    <span class="badge-status status-ditolak">Ditolak</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.pengajuan.show', $item->id) }}" class="btn-detail-custom">Detail</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox display-4 d-block mb-3"></i>
                                Belum ada data pengajuan cuti yang sesuai.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="d-flex justify-content-end p-3">
                {{ $pengajuan->withQueryString()->links() }}
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>




