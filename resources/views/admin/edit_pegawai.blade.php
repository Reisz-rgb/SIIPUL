<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pegawai - SIIPUL</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    
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

        /* --- CONTENT AREA & FORM --- */
        .content-area { padding: 32px; width: 100%; max-width: 1000px; margin: 0 auto; }
        
        .card-clean {
            background: white; border: 1px solid var(--border-color);
            border-radius: 12px; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            padding: 32px; margin-bottom: 24px;
        }

        .btn-back-link {
            display: inline-flex; align-items: center; gap: 8px; 
            color: var(--text-muted); text-decoration: none; font-weight: 500; margin-right: 15px;
        }
        .btn-back-link:hover { color: var(--primary-color); }

        .form-label { font-weight: 500; font-size: 0.9rem; color: var(--text-main); margin-bottom: 8px; }
        
        .form-control-clean, .form-select-clean {
            border: 1px solid var(--border-color); border-radius: 8px; padding: 10px 14px;
            font-size: 0.95rem; color: var(--text-main); background-color: white;
            width: 100%; transition: border-color 0.2s, box-shadow 0.2s;
        }
        .form-control-clean:focus, .form-select-clean:focus { 
            border-color: var(--primary-color); outline: none; 
            box-shadow: 0 0 0 3px rgba(158, 42, 43, 0.1); 
        }

        /* Buttons */
        .btn-warning-custom {
            background-color: #F59E0B; border: none; padding: 12px 24px;
            border-radius: 8px; color: white; font-weight: 600; width: 100%;
            display: flex; align-items: center; justify-content: center; gap: 8px; transition: 0.2s;
        }
        .btn-warning-custom:hover { background-color: #D97706; color: white; transform: translateY(-1px); }
        
        .btn-secondary-custom {
            background-color: white; border: 1px solid var(--border-color); padding: 12px 24px;
            border-radius: 8px; color: var(--text-main); font-weight: 600; width: 100%;
            display: flex; align-items: center; justify-content: center; gap: 8px; text-decoration: none;
            transition: 0.2s;
        }
        .btn-secondary-custom:hover { background-color: #F9FAFB; border-color: #D1D5DB; color: var(--text-main); }

        .is-invalid { border-color: #DC2626 !important; }
        .invalid-feedback { font-size: 0.85rem; color: #DC2626; margin-top: 6px; }

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

            <div class="d-flex align-items-center mb-4">
                <a href="{{ route('admin.kelola_pegawai') }}" class="btn-back-link"><i class="bi bi-arrow-left fs-5"></i></a>
                <div>
                    <h4 class="fw-bold mb-0">Edit Pegawai</h4>
                    <div class="text-muted small">Perbarui informasi data diri pegawai</div>
                </div>
            </div>

            <div class="card-clean">
                <form id="formEditPegawai" action="{{ route('admin.pegawai.update', $pegawai->id) }}" method="POST">
                    @csrf
                    @method('PUT') 

                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="name" class="form-control-clean @error('name') is-invalid @enderror" 
                                   value="{{ old('name', $pegawai->name) }}" required>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label">NIP</label>
                            <input type="number" name="nip" class="form-control-clean @error('nip') is-invalid @enderror" 
                                   value="{{ old('nip', $pegawai->nip) }}" required>
                            @error('nip') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control-clean @error('email') is-invalid @enderror" 
                                   value="{{ old('email', $pegawai->email) }}" required>
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label">Nomor Telepon</label>
                            <input type="text" name="phone" class="form-control-clean @error('phone') is-invalid @enderror" 
                                   value="{{ old('phone', $pegawai->phone) }}" required>
                            @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label">Posisi / Jabatan</label>
                            <input type="text" name="jabatan" class="form-control-clean @error('jabatan') is-invalid @enderror" 
                                   value="{{ old('jabatan', $pegawai->jabatan) }}" required>
                            @error('jabatan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label">Unit Kerja</label>
                            <input type="text" name="bidang_unit" class="form-control-clean @error('bidang_unit') is-invalid @enderror" 
                                   value="{{ old('bidang_unit', $pegawai->bidang_unit) }}" required>
                            @error('bidang_unit') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        
                        <div class="col-md-12">
                             <label class="form-label">Status Akun</label>
                             <select name="status" class="form-select-clean">
                                 <option value="aktif" {{ old('status', $pegawai->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                 <option value="nonaktif" {{ old('status', $pegawai->status) == 'nonaktif' ? 'selected' : '' }}>Non-aktif</option>
                             </select>
                        </div>
                    </div>

                    <hr class="my-4 border-light">

                    <div class="row g-3">
                        <div class="col-md-6 order-md-2">
                            <button type="button" onclick="simpanPerubahan()" class="btn-warning-custom">
                                <i class="bi bi-pencil-square"></i> Update Data
                            </button>
                        </div>
                        <div class="col-md-6 order-md-1">
                            <a href="{{ route('admin.kelola_pegawai') }}" class="btn-secondary-custom">
                                Batal
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
        function simpanPerubahan() {
            // Cek validitas form HTML5 sederhana
            const form = document.getElementById('formEditPegawai');
            if(!form.checkValidity()) {
                form.reportValidity();
                return;
            }

            Swal.fire({
                title: 'Simpan Perubahan?',
                text: "Data pegawai akan diperbarui.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#F59E0B', // Warna Warning
                cancelButtonColor: '#6B7280', // Warna Secondary/Gray
                confirmButtonText: 'Ya, Update!',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Menyimpan...',
                        html: 'Mohon tunggu sebentar.',
                        allowOutsideClick: false,
                        didOpen: () => { Swal.showLoading() }
                    });
                    form.submit();
                }
            })
        }
    </script>
</body>
</html>