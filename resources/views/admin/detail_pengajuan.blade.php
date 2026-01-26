<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pengajuan Cuti - SIIPUL</title>
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
        .user-dropdown { 
            background: white; color: #333; padding: 5px 6px; 
            border-radius: 50px; display: flex; align-items: center; 
            gap: 10px; font-weight: 600; font-size: 0.9rem; text-decoration: none;
        }
        .avatar-circle {
            width: 32px; height: 32px; background-color: var(--primary-red);
            color: white; border-radius: 50%; display: flex;
            align-items: center; justify-content: center; font-size: 0.75rem; font-weight: bold;
        }

        /* Header & Content */
        .page-header { display: flex; align-items: center; gap: 15px; margin-bottom: 20px; }
        .btn-back-arrow { font-size: 1.2rem; color: #333; text-decoration: none; font-weight: 500; }
        .btn-back-arrow:hover { color: var(--primary-red); }

        /* Card Styling */
        .detail-card { background: white; border: 1px solid #e0e0e0; border-radius: 8px; padding: 30px; margin-bottom: 20px; }
        .section-title { font-size: 0.9rem; font-weight: 700; color: #555; text-transform: uppercase; margin-bottom: 15px; margin-top: 20px; }
        .data-label { font-size: 0.75rem; color: #888; text-transform: uppercase; margin-bottom: 2px; }
        .data-value { font-size: 0.95rem; font-weight: 500; color: #333; margin-bottom: 15px; }
        
        /* Status Badge Logic */
        .badge-status { padding: 5px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: 600; border: 1px solid transparent; }
        .bg-pending { background-color: #fff8e1; color: #ffc107; border-color: #ffe69c; }
        .bg-approved { background-color: #d1e7dd; color: #0f5132; border-color: #badbcc; }
        .bg-rejected { background-color: #f8d7da; color: #842029; border-color: #f5c2c7; }

        /* File Attachment */
        .file-item { display: flex; align-items: center; justify-content: space-between; border: 1px solid #eee; padding: 10px 15px; border-radius: 6px; margin-bottom: 10px; }
        .file-icon { font-size: 1.5rem; color: #dc3545; margin-right: 15px; }
        .file-name { font-weight: 600; font-size: 0.9rem; display: block; }
        .file-size { font-size: 0.75rem; color: #999; }

        /* Approval Section */
        .approval-section { border-top: 1px solid #eee; margin-top: 30px; padding-top: 20px; }
        .approval-title { color: #A52A2A; font-weight: bold; font-size: 1rem; margin-bottom: 20px; }
        .form-check-input:checked { background-color: #A52A2A; border-color: #A52A2A; }
        
        .signature-wrapper {
            display: flex;
            justify-content: flex-end;
            margin-top: 40px;
        }
        .signature-box { 
            width: 300px; 
            text-align: center; 
            color: #333;
        }
        .signature-name { font-weight: bold; text-decoration: underline; margin-bottom: 0; }
        .signature-nip { font-size: 0.9rem; color: #555; }
        
        /* Buttons */
        .btn-action-green { background-color: #198754; color: white; border: none; padding: 12px 20px; border-radius: 6px; width: 100%; font-weight: 600; transition: all 0.3s; }
        .btn-action-green:hover { background-color: #146c43; transform: translateY(-2px); }
    </style>
</head>
<body>

    <nav class="navbar navbar-custom py-3">
        <div class="container-fluid px-4">
            <a class="navbar-brand" href="{{ route('admin.dashboard') }}">
                <img src="{{ asset('logokabupatensemarang.png') }}" alt="Logo" width="40" height="auto" class="d-inline-block align-text-top me-2"> 
                SIIPUL Dashboard
            </a>
            <div class="dropdown">
                <a href="#" class="user-dropdown dropdown-toggle" data-bs-toggle="dropdown">
                    <div class="avatar-circle">{{ substr(Auth::user()->name ?? 'A', 0, 1) }}</div> 
                    <span>{{ Auth::user()->name ?? 'Admin' }}</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end mt-2">
                    <li><a class="dropdown-item text-danger" href="#">Keluar</a></li>
                </ul>
            </div>
        </div>
    </nav>

    {{-- ALERT SUKSES --}}
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show m-4" role="alert" style="max-width: 900px;">
        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    {{-- ALERT ERROR (BARU DITAMBAHKAN) --}}
    @if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show m-4" role="alert" style="max-width: 900px;">
        <strong><i class="bi bi-exclamation-triangle-fill me-2"></i> Gagal Menyimpan!</strong>
        <ul class="mb-0 mt-2">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="container-fluid px-4 mt-4 mb-5" style="max-width: 900px;">
        
        <div class="page-header">
            <a href="{{ route('admin.dashboard') }}" class="btn-back-arrow"><i class="bi bi-chevron-left"></i> Kembali</a>
        </div>

        <div class="detail-card shadow-sm">
            
            <div class="d-flex justify-content-between align-items-start mb-4">
                <div>
                    <h4 class="fw-bold mb-1">{{ $pengajuan->user->name }}</h4>
                    <p class="text-muted mb-2">{{ $pengajuan->user->jabatan ?? 'Pegawai' }}</p>
                    
                    @if($pengajuan->status == 'approved')
                        <span class="badge-status bg-approved">Disetujui</span>
                    @elseif($pengajuan->status == 'rejected')
                        <span class="badge-status bg-rejected">Ditolak</span>
                    @else
                        <span class="badge-status bg-pending">Menunggu</span>
                    @endif

                    <span class="text-muted small ms-2">ID Pengajuan: #{{ $pengajuan->id }}</span>
                </div>
            </div>

            <hr>

            <div class="section-title">I. DATA PEGAWAI</div>
            <div class="row g-3"> 
                <div class="col-md-6">
                    <p class="data-label">NAMA</p>
                    <p class="data-value">{{ $pengajuan->user->name }}</p>
                </div>
                <div class="col-md-6">
                    <p class="data-label">NIP</p>
                    <p class="data-value">{{ $pengajuan->user->nip ?? '-' }}</p>
                </div>
                <div class="col-md-6">
                    <p class="data-label">JABATAN</p>
                    <p class="data-value">{{ $pengajuan->user->jabatan ?? '-' }}</p>
                </div>
                <div class="col-md-6">
                    <p class="data-label">UNIT KERJA</p>
                    <p class="data-value">{{ $pengajuan->user->bidang_unit ?? '-' }}</p>
                </div>
            </div>

            <hr>

            <div class="row g-3">
                <div class="col-md-6">
                    <div class="section-title mt-0">II. JENIS CUTI YANG DIAMBIL</div>
                    <div class="p-2 bg-light border rounded d-inline-block">{{ $pengajuan->jenis_cuti }}</div>
                </div>
                <div class="col-md-6">
                    <div class="section-title mt-0">III. ALASAN CUTI</div>
                    <p class="data-value">{{ $pengajuan->reason }}</p>
                </div>
            </div>

            <hr>

            <div class="section-title">IV. LAMANYA CUTI</div>
            <div class="row g-3">
                <div class="col-md-4">
                    <p class="data-label">DURASI</p>
                    <p class="data-value">{{ $pengajuan->duration }} Hari</p>
                </div>
                <div class="col-md-4">
                    <p class="data-label">TANGGAL MULAI</p>
                    <p class="data-value">{{ $pengajuan->start_date->format('d M Y') }}</p>
                </div>
                <div class="col-md-4">
                    <p class="data-label">TANGGAL SELESAI</p>
                    <p class="data-value">{{ $pengajuan->end_date->format('d M Y') }}</p>
                </div>
            </div>

            <hr>

            <div class="section-title">LAMPIRAN DOKUMEN</div>
            @if($pengajuan->file_path)
                <div class="file-item">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-file-earmark-pdf-fill file-icon"></i>
                        <div>
                            <span class="file-name">Dokumen Lampiran</span>
                            <span class="file-size">Klik lihat untuk mengunduh</span>
                        </div>
                    </div>
                    <a href="{{ asset('storage/' . $pengajuan->file_path) }}" target="_blank" class="btn btn-sm btn-outline-secondary">Lihat</a>
                </div>
            @else
                <p class="text-muted fst-italic">Tidak ada dokumen lampiran.</p>
            @endif

        </div>

        <div class="detail-card shadow-sm">
            <form action="{{ route('admin.pengajuan.update', $pengajuan->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="approval-section pt-0 border-top-0 mt-0">
                    <h5 class="approval-title">VII. KEPUTUSAN PEJABAT YANG BERWENANG</h5>
                    <div class="d-flex flex-wrap gap-4 mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="k_setuju" value="approved" {{ $pengajuan->status == 'approved' ? 'checked' : '' }}>
                            <label class="form-check-label fw-bold text-success" for="k_setuju">Disetujui</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="k_tangguh" value="pending" {{ $pengajuan->status == 'pending' ? 'checked' : '' }}>
                            <label class="form-check-label text-warning" for="k_tangguh">Ditangguhkan / Menunggu</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="k_tolak" value="rejected" {{ $pengajuan->status == 'rejected' ? 'checked' : '' }}>
                            <label class="form-check-label fw-bold text-danger" for="k_tolak">Tidak Disetujui</label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small text-muted">Catatan / Alasan Penolakan (Jika ada)</label>
                        <textarea class="form-control" name="rejection_reason" rows="2">{{ $pengajuan->rejection_reason }}</textarea>
                    </div>

                    <div class="signature-wrapper">
                        <div class="signature-box">
                            <p class="mb-5 fw-bold">Pejabat Berwenang</p>
                            <p class="signature-name">{{ Auth::user()->name ?? 'Administrator' }}</p>
                            <span class="signature-nip">NIP. {{ Auth::user()->nip ?? '-' }}</span>
                        </div>
                    </div>
                </div>

                <div class="mt-5">
                    <button type="submit" class="btn btn-action-green shadow-sm">
                        <i class="bi bi-save me-2"></i> SIMPAN KEPUTUSAN
                    </button>
                </div>

            </form>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>