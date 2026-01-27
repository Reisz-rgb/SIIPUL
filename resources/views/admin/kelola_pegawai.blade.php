<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Pegawai - SIIPUL</title>
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

        /* --- CONTENT AREA --- */
        .content-area { padding: 32px; width: 100%; }
        
        .card-clean {
            background: white; border: 1px solid var(--border-color);
            border-radius: 12px; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            padding: 24px; margin-bottom: 24px;
        }

        /* Table Styling */
        .table-custom thead th {
            background-color: #F9FAFB; color: var(--text-muted); font-size: 0.75rem;
            font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em;
            border-bottom: 1px solid var(--border-color); padding: 12px 16px; border-top: none;
        }
        .table-custom tbody td {
            padding: 16px; vertical-align: middle; border-bottom: 1px solid #F3F4F6;
            color: var(--text-main); font-size: 0.9rem;
        }
        .table-custom tbody tr:last-child td { border-bottom: none; }
        
        .avatar-initials {
            width: 40px; height: 40px; background-color: #FEF2F2; color: var(--primary-color);
            border-radius: 50%; display: flex; align-items: center; justify-content: center;
            font-weight: 700; font-size: 0.9rem;
        }

        /* Status Badges */
        .badge-status { padding: 4px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; }
        .badge-active { background-color: #ECFDF5; color: #059669; border: 1px solid #D1FAE5; }
        .badge-inactive { background-color: #F3F4F6; color: #6B7280; border: 1px solid #E5E7EB; }

        /* Buttons & Form */
        .btn-primary-custom {
            background-color: var(--primary-color); border: none; padding: 10px 20px;
            border-radius: 8px; color: white; font-weight: 500; text-decoration: none;
            display: inline-flex; align-items: center; gap: 8px; transition: 0.2s;
        }
        .btn-primary-custom:hover { background-color: var(--primary-hover); color: white; }
        
        .btn-back-link {
            display: inline-flex; align-items: center; gap: 8px; 
            color: var(--text-muted); text-decoration: none; font-weight: 500; margin-right: 15px;
        }
        .btn-back-link:hover { color: var(--primary-color); }

        .form-control-clean {
            border: 1px solid var(--border-color); border-radius: 8px; padding: 10px 14px;
        }
        .form-control-clean:focus { border-color: var(--primary-color); box-shadow: 0 0 0 3px rgba(158, 42, 43, 0.1); }

        /* Pagination Fix */
        .pagination { margin-bottom: 0; }
        .page-item.active .page-link { background-color: var(--primary-color); border-color: var(--primary-color); }
        .page-link { color: var(--text-main); border-radius: 6px; margin: 0 2px; }

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
            <a href="{{ route('admin.kelola_pegawai') }}" class="nav-item active">
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
                <h5 class="m-0 fw-bold">Data Pegawai</h5>
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

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="d-flex align-items-center">
                    <a href="{{ route('admin.dashboard') }}" class="btn-back-link"><i class="bi bi-arrow-left fs-5"></i></a>
                    <div>
                        <h4 class="fw-bold mb-0">Kelola Pegawai</h4>
                        <div class="text-muted small">Daftar seluruh pegawai terdaftar</div>
                    </div>
                </div>
                <a href="{{ route('admin.tambah_pegawai') }}" class="btn-primary-custom shadow-sm">
                    <i class="bi bi-plus-lg"></i> Tambah Pegawai
                </a>
            </div>

            @if (session('success'))
                <div class="alert alert-success d-flex align-items-center mb-4 border-0 shadow-sm" role="alert" style="background-color: #ECFDF5; color: #065F46;">
                    <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                    <div>{{ session('success') }}</div>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger d-flex align-items-center mb-4 border-0 shadow-sm" role="alert" style="background-color: #FEF2F2; color: #991B1B;">
                    <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
                    <div>{{ session('error') }}</div>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="card-clean">
                <form action="{{ route('admin.kelola_pegawai') }}" method="GET">
                    <div class="row g-3 align-items-end">
                        <div class="col-md-9">
                            <label class="form-label small text-muted fw-bold">PENCARIAN</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0 border-muted text-muted"><i class="bi bi-search"></i></span>
                                <input type="text" name="search" class="form-control form-control-clean border-start-0 ps-0" placeholder="Cari nama pegawai atau NIP..." value="{{ request('search') }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-dark w-100 py-2 rounded-3 fw-medium">
                                Cari Data
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="card-clean p-0 overflow-hidden">
                <div class="table-responsive">
                    <table class="table table-custom mb-0">
                        <thead>
                            <tr>
                                <th class="ps-4">No</th>
                                <th>Nama & NIP</th>
                                <th>Posisi</th>
                                <th>Unit Kerja</th>
                                <th>Sisa Cuti</th>
                                <th>Status</th>
                                <th class="text-end pe-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pegawai as $p)
                            <tr>
                                <td class="ps-4">{{ $loop->iteration + $pegawai->firstItem() - 1 }}</td>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="avatar-initials">
                                            {{ substr($p->name, 0, 2) }}
                                        </div>
                                        <div>
                                            <span class="fw-bold d-block text-dark">{{ $p->name }}</span>
                                            <span class="text-muted small" style="font-family: monospace;">{{ $p->nip }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $p->jabatan ?? '-' }}</td>
                                <td>{{ $p->bidang_unit ?? '-' }}</td>
                                <td>
                                    <span class="fw-bold">{{ $p->annual_leave_quota ?? 12 }}</span>
                                    <span class="text-muted small">/ 12 Hari</span>
                                </td>
                                <td>
                                    @if($p->status == 'nonaktif')
                                        <span class="badge-status badge-inactive">Non-aktif</span>
                                    @else
                                        <span class="badge-status badge-active">Aktif</span>
                                    @endif
                                </td>
                                <td class="text-end pe-4">
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="{{ route('admin.pegawai.edit', $p->id) }}" class="btn btn-sm btn-outline-warning" title="Edit">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        
                                        <form id="delete-form-{{ $p->id }}" action="{{ route('admin.pegawai.destroy', $p->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            
                                            <button type="button" onclick="konfirmasiHapus({{ $p->id }})" class="btn btn-sm btn-outline-danger" title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <div class="text-muted opacity-50 mb-2"><i class="bi bi-inbox fs-1"></i></div>
                                    <p class="text-muted small mb-0">Belum ada data pegawai ditemukan.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center p-4 border-top bg-light bg-opacity-10">
                    <small class="text-muted mb-2 mb-md-0">
                        Menampilkan {{ $pegawai->firstItem() }} s/d {{ $pegawai->lastItem() }} dari {{ $pegawai->total() }} data
                    </small>
                    <div>
                        {{ $pegawai->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function konfirmasiHapus(id) {
            Swal.fire({
                title: 'Hapus Pegawai?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#9E2A2B', // Sesuaikan warna merah dashboard
                cancelButtonColor: '#6B7280',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            })
        }
    </script>

    @if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            confirmButtonColor: '#9E2A2B'
        });
    </script>
    @endif

    @if(session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: '{{ session('error') }}',
            confirmButtonColor: '#9E2A2B'
        });
    </script>
    @endif

</body>
</html>