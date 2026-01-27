<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pengajuan - SIIPUL</title>
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
            --success-green: #059669;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-body);
            color: var(--text-main);
            overflow-x: hidden;
        }

        /* Sidebar */
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

        /* --- STYLE HALAMAN DETAIL --- */
        .content-area { padding: 32px; max-width: 1000px; margin: 0 auto; width: 100%; }
        
        .btn-back {
            display: inline-flex; align-items: center; gap: 8px; 
            color: var(--text-muted); text-decoration: none; font-weight: 500; margin-bottom: 24px;
            transition: color 0.2s;
        }
        .btn-back:hover { color: var(--primary-color); }

        .card-clean {
            background: white; border: 1px solid var(--border-color);
            border-radius: 12px; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            padding: 32px; margin-bottom: 24px;
        }

        .section-header {
            font-size: 0.8rem; font-weight: 700; color: var(--text-muted);
            text-transform: uppercase; letter-spacing: 0.05em;
            margin-bottom: 16px; padding-bottom: 8px; border-bottom: 1px solid #F3F4F6;
        }

        .info-group { margin-bottom: 20px; }
        .info-label { font-size: 0.75rem; color: var(--text-muted); text-transform: uppercase; margin-bottom: 4px; }
        .info-value { font-size: 1rem; font-weight: 500; color: var(--text-main); }

        /* Status Badge */
        .badge-status {
            padding: 6px 14px; border-radius: 99px; font-size: 0.8rem; font-weight: 600;
            display: inline-flex; align-items: center; gap: 6px;
        }
        .badge-status::before { content: ""; width: 6px; height: 6px; border-radius: 50%; }
        .status-pending { background-color: #FFFBEB; color: #B45309; }
        .status-pending::before { background-color: #B45309; }
        .status-approved { background-color: #ECFDF5; color: #047857; }
        .status-approved::before { background-color: #047857; }
        .status-rejected { background-color: #FEF2F2; color: #B91C1C; }
        .status-rejected::before { background-color: #B91C1C; }

        /* File Attachment */
        .file-box {
            display: flex; align-items: center; justify-content: space-between;
            border: 1px solid var(--border-color); padding: 16px; border-radius: 8px;
            background-color: #F9FAFB;
        }

        /* Form Elements */
        .form-check-input:checked { background-color: var(--primary-color); border-color: var(--primary-color); }
        .btn-primary-custom {
            background-color: var(--primary-color); border: none; padding: 12px 24px;
            border-radius: 8px; color: white; font-weight: 600; width: 100%;
            transition: background-color 0.2s;
        }
        .btn-primary-custom:hover { background-color: var(--primary-hover); }

        .signature-area { margin-top: 40px; text-align: right; }
        .signature-box { display: inline-block; text-align: center; min-width: 200px; }

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
            <a href="{{ route('admin.kelola_pengajuan') }}" class="nav-item active">
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
    </nav>

    <div class="main-wrapper">
        
        <header class="top-header">
            <div class="d-flex align-items-center gap-3">
                <h5 class="m-0 fw-bold">Detail Pengajuan</h5>
            </div>
            
            <div class="dropdown">
                <a href="#" class="user-menu-btn" data-bs-toggle="dropdown">
                    <div class="text-end d-none d-sm-block">
                        <div class="fw-bold" style="font-size: 0.9rem;">{{ Auth::user()->name }}</div>
                        <div class="text-muted" style="font-size: 0.75rem;">{{ ucfirst(Auth::user()->role) }}</div>
                    </div>
                    <div class="avatar-circle">{{ substr(Auth::user()->name, 0, 2) }}</div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow-sm border mt-2 p-2 rounded-3">
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

            <a href="{{ route('admin.kelola_pengajuan') }}" class="btn-back">
                <i class="bi bi-arrow-left"></i> Kembali ke Daftar
            </a>

            @if(session('success'))
            <div class="alert alert-success d-flex align-items-center mb-4 border-0 shadow-sm" role="alert" style="background-color: #ECFDF5; color: #065F46;">
                <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                <div>{{ session('success') }}</div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            @if ($errors->any())
            <div class="alert alert-danger d-flex align-items-center mb-4 border-0 shadow-sm" role="alert" style="background-color: #FEF2F2; color: #991B1B;">
                <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
                <div>
                    <strong>Gagal Menyimpan!</strong>
                    <ul class="mb-0 ps-3 mt-1 small">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <div class="card-clean">
                <div class="d-flex justify-content-between align-items-start mb-4">
                    <div>
                        <h4 class="fw-bold mb-1">{{ $pengajuan->user->name }}</h4>
                        <div class="text-muted">{{ $pengajuan->user->jabatan ?? 'Pegawai' }}</div>
                    </div>
                    <div>
                        @if($pengajuan->status == 'approved')
                            <span class="badge-status status-approved">Disetujui</span>
                        @elseif($pengajuan->status == 'rejected')
                            <span class="badge-status status-rejected">Ditolak</span>
                        @else
                            <span class="badge-status status-pending">Menunggu</span>
                        @endif
                        <div class="text-muted small mt-1 text-end">ID: #{{ $pengajuan->id }}</div>
                    </div>
                </div>

                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="section-header">Data Pegawai</div>
                        <div class="row g-3">
                            <div class="col-6">
                                <div class="info-group">
                                    <div class="info-label">NIP</div>
                                    <div class="info-value">{{ $pengajuan->user->nip ?? '-' }}</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="info-group">
                                    <div class="info-label">Unit Kerja</div>
                                    <div class="info-value">{{ $pengajuan->user->bidang_unit ?? '-' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="section-header">Detail Cuti</div>
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="info-group">
                                    <div class="info-label">Jenis Cuti</div>
                                    <div class="info-value">{{ $pengajuan->jenis_cuti }}</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="info-group">
                                    <div class="info-label">Mulai</div>
                                    <div class="info-value">{{ $pengajuan->start_date->format('d M Y') }}</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="info-group">
                                    <div class="info-label">Selesai</div>
                                    <div class="info-value">{{ $pengajuan->end_date->format('d M Y') }}</div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="info-group mb-0">
                                    <div class="info-label">Total Durasi</div>
                                    <div class="info-value text-dark">{{ $pengajuan->duration }} Hari</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-12">
                        <div class="info-group">
                            <div class="info-label">Alasan Cuti</div>
                            <div class="info-value p-3 bg-light rounded border border-light">{{ $pengajuan->reason }}</div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="section-header">Lampiran Dokumen</div>
                        @if($pengajuan->file_path)
                            <div class="file-box">
                                <div class="d-flex align-items-center gap-3">
                                    <i class="bi bi-file-earmark-pdf-fill text-danger fs-3"></i>
                                    <div>
                                        <div class="fw-semibold">Dokumen Lampiran</div>
                                        <div class="small text-muted">Klik tombol untuk melihat dokumen</div>
                                    </div>
                                </div>
                                <a href="{{ asset('storage/' . $pengajuan->file_path) }}" target="_blank" class="btn btn-sm btn-outline-dark">
                                    Lihat <i class="bi bi-box-arrow-up-right ms-1"></i>
                                </a>
                            </div>
                        @else
                            <div class="text-muted fst-italic small">Tidak ada dokumen yang dilampirkan.</div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="card-clean">
                <div class="section-header text-primary border-bottom-0 mb-3" style="color: var(--primary-color);">
                    <i class="bi bi-pen me-2"></i> Keputusan Pejabat Berwenang
                </div>

                <form action="{{ route('admin.pengajuan.update', $pengajuan->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="d-flex flex-wrap gap-4 mb-4 p-3 rounded bg-light border">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="k_setuju" value="approved" {{ $pengajuan->status == 'approved' ? 'checked' : '' }}>
                            <label class="form-check-label fw-bold text-success" for="k_setuju">Disetujui</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="k_tangguh" value="pending" {{ $pengajuan->status == 'pending' ? 'checked' : '' }}>
                            <label class="form-check-label text-warning fw-medium" for="k_tangguh">Ditangguhkan</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="k_tolak" value="rejected" {{ $pengajuan->status == 'rejected' ? 'checked' : '' }}>
                            <label class="form-check-label fw-bold text-danger" for="k_tolak">Tidak Disetujui</label>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label small text-muted fw-bold">CATATAN / ALASAN (OPSIONAL)</label>
                        <textarea class="form-control" name="rejection_reason" rows="3" placeholder="Tuliskan catatan untuk pegawai jika diperlukan...">{{ $pengajuan->rejection_reason }}</textarea>
                    </div>

                    <div class="signature-area">
                        <div class="signature-box">
                            <div class="small text-muted mb-4">Pejabat Berwenang</div>
                            <div class="fw-bold text-dark text-decoration-underline">{{ Auth::user()->name ?? 'Administrator' }}</div>
                            <div class="small text-muted">NIP. {{ Auth::user()->nip ?? '-' }}</div>
                        </div>
                    </div>

                    <div class="mt-4 pt-3 border-top">
                        <button type="submit" class="btn-primary-custom shadow-sm">
                            <i class="bi bi-save me-2"></i> SIMPAN KEPUTUSAN
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>