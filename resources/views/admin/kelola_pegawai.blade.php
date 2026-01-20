<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Pegawai - SIIPUL</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <style>
        :root {
            --primary-red: #A52A2A;
            --bg-light: #f8f9fa;
        }
        body { background-color: var(--bg-light); font-family: 'Segoe UI', sans-serif; }

        /* Navbar sama dengan Dashboard */
        .navbar-custom { background-color: var(--primary-red); color: white; }
        
        /* Navbar Brand Putih */
        .navbar-brand { 
            font-weight: bold; 
            font-size: 1.2rem; 
            display: flex; 
            align-items: center; 
            gap: 10px;
            color: white !important; 
        }
        .navbar-brand:hover { color: #e0e0e0 !important; }

        /* Header Title Section */
        .page-header {
            display: flex; 
            align-items: center; 
            justify-content: space-between; 
            margin-bottom: 20px;
        }
        .header-left {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .btn-back-arrow { font-size: 1.5rem; color: #333; text-decoration: none; }
        .btn-back-arrow:hover { color: var(--primary-red); }

        /* Tombol Tambah Pegawai */
        .btn-add-custom {
            background-color: var(--primary-red);
            color: white;
            border: none;
            padding: 8px 20px;
            border-radius: 6px;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            transition: background-color 0.2s;
        }
        .btn-add-custom:hover {
            background-color: #8a2323; 
            color: white;
        }

        /* Filter Box */
        .filter-card { border: 1px solid #e0e0e0; border-radius: 8px; padding: 20px; background: white; margin-bottom: 20px; }
        
        /* Stats Cards */
        .stat-card-simple { background: white; border: 1px solid #e0e0e0; border-radius: 8px; padding: 20px; height: 100%; }
        .stat-num { font-size: 1.8rem; font-weight: 600; margin-top: 5px; margin-bottom: 0; }
        
        /* Table Styling */
        .table-card { background: white; border: 1px solid #e0e0e0; border-radius: 8px; padding: 0; overflow: hidden; }
        .table thead th { background-color: #f9f9f9; font-weight: 600; color: #555; font-size: 0.9rem; border-bottom: 2px solid #eee; padding: 15px; }
        .table tbody td { padding: 15px; vertical-align: middle; font-size: 0.9rem; color: #333; border-bottom: 1px solid #eee; }
        
        /* Badges */
        .badge-active { background-color: #e6f8ef; color: #198754; border: 1px solid #c3e6cb; border-radius: 20px; padding: 5px 12px; font-weight: 500; font-size: 0.8rem; }
        .badge-inactive { background-color: #f8f9fa; color: #6c757d; border: 1px solid #dee2e6; border-radius: 20px; padding: 5px 12px; font-weight: 500; font-size: 0.8rem; }

        /* Pagination Button */
        .page-btn { border: 1px solid #dee2e6; background: white; color: #333; padding: 6px 12px; border-radius: 4px; text-decoration: none; font-size: 0.9rem; }
        .page-btn.active { background-color: var(--primary-red); color: white; border-color: var(--primary-red); }
    </style>
</head>
<body>

    <nav class="navbar navbar-custom py-3">
        <div class="container-fluid px-4">
            <a class="navbar-brand" href="{{ route('admin.dashboard') }}">
                <img src="{{ asset('logokabupatensemarang.png') }}" alt="Logo" width="40" height="auto" class="d-inline-block align-text-top me-2"> 
                SIIPUL Dashboard
            </a>
            
            </div>
    </nav>

    <div class="container-fluid px-4 mt-4 mb-5">
        
        <div class="page-header">
            <div class="header-left">
                <a href="{{ route('admin.dashboard') }}" class="btn-back-arrow"><i class="bi bi-arrow-left"></i></a>
                <h4 class="mb-0 text-secondary">Kelola Pegawai</h4>
            </div>

            <a href="{{ route('admin.tambah_pegawai') }}" class="btn-add-custom shadow-sm">
                <i class="bi bi-plus-lg"></i> Tambah Pegawai
            </a>
        </div>

        <div class="filter-card shadow-sm">
            <div class="row g-3">
                <div class="col-md-8">
                    <label class="form-label small text-muted">Cari Pegawai</label>
                    <input type="text" class="form-control" placeholder="Nama pegawai atau NIP...">
                </div>
                <div class="col-md-4">
                    <label class="form-label small text-muted">Status</label>
                    <select class="form-select">
                        <option>Semua</option>
                        <option>Aktif</option>
                        <option>Non-aktif</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-4">
                <div class="stat-card-simple shadow-sm">
                    <span class="text-muted small">Total Pegawai</span>
                    <h3 class="stat-num text-danger">6</h3>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card-simple shadow-sm">
                    <span class="text-muted small">Pegawai Aktif</span>
                    <h3 class="stat-num text-success">5</h3>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card-simple shadow-sm">
                    <span class="text-muted small">Non-aktif</span>
                    <h3 class="stat-num text-warning">1</h3>
                </div>
            </div>
        </div>

        <div class="table-card shadow-sm">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>NIP</th>
                            <th>Posisi</th>
                            <th>Unit Kerja</th>
                            <th>Cuti</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="fw-bold">Budi Santoso</td>
                            <td>197801011999121001</td>
                            <td>Guru Matematika</td>
                            <td>SMP Negeri 1 Semarang</td>
                            <td>
                                8/12 <br> <span class="text-muted" style="font-size: 0.75rem">Sisa/Total</span>
                            </td>
                            <td><span class="badge-active">Aktif</span></td>
                            <td>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-sm btn-warning text-white" title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Siti Nurhaliza</td>
                            <td>198005152007012001</td>
                            <td>Guru Bahasa Indonesia</td>
                            <td>SMP Negeri 2 Semarang</td>
                            <td>
                                6/12 <br> <span class="text-muted" style="font-size: 0.75rem">Sisa/Total</span>
                            </td>
                            <td><span class="badge-active">Aktif</span></td>
                            <td>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-sm btn-warning text-white" title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Ahmad Wijaya</td>
                            <td>197805201989031005</td>
                            <td>Kepala Sekolah</td>
                            <td>SMP Negeri 1 Semarang</td>
                            <td>
                                10/12 <br> <span class="text-muted" style="font-size: 0.75rem">Sisa/Total</span>
                            </td>
                            <td><span class="badge-active">Aktif</span></td>
                            <td>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-sm btn-warning text-white" title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Rini Kusuma</td>
                            <td>198203071992032003</td>
                            <td>Guru Seni</td>
                            <td>SMP Negeri 3 Semarang</td>
                            <td>
                                4/12 <br> <span class="text-muted" style="font-size: 0.75rem">Sisa/Total</span>
                            </td>
                            <td><span class="badge-active">Aktif</span></td>
                            <td>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-sm btn-warning text-white" title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Eka Sutrisno</td>
                            <td>197912102005011007</td>
                            <td>Guru IPA</td>
                            <td>SMP Negeri 4 Semarang</td>
                            <td>
                                0/12 <br> <span class="text-muted" style="font-size: 0.75rem">Sisa/Total</span>
                            </td>
                            <td><span class="badge-inactive">Non-aktif</span></td>
                            <td>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-sm btn-warning text-white" title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Dwi Sentosa</td>
                            <td>197603052000031008</td>
                            <td>Guru Bahasa Inggris</td>
                            <td>SMP Negeri 2 Semarang</td>
                            <td>
                                9/12 <br> <span class="text-muted" style="font-size: 0.75rem">Sisa/Total</span>
                            </td>
                            <td><span class="badge-active">Aktif</span></td>
                            <td>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-sm btn-warning text-white" title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <div class="d-flex justify-content-between align-items-center p-3 border-top">
                <small class="text-muted">Menampilkan 6 dari 6 pegawai</small>
                <div>
                    <a href="#" class="page-btn me-1">Sebelumnya</a>
                    <a href="#" class="page-btn active me-1">1</a>
                    <a href="#" class="page-btn">Berikutnya</a>
                </div>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>