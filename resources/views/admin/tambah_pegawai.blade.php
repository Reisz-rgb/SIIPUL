<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pegawai Baru - SIIPUL</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    
    <style>
        :root { --primary-red: #A52A2A; --bg-light: #f8f9fa; --input-bg: #f2f2f2; }
        body { background-color: var(--bg-light); font-family: 'Segoe UI', sans-serif; }
        .navbar-custom { background-color: var(--primary-red); color: white; }
        .navbar-brand { font-weight: bold; font-size: 1.2rem; display: flex; align-items: center; gap: 10px; color: white !important; }
        .user-pill { background: white; color: #333; padding: 5px 10px; border-radius: 50px; display: flex; align-items: center; gap: 10px; font-weight: 600; font-size: 0.9rem; }
        .avatar-circle { width: 32px; height: 32px; background-color: var(--primary-red); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.75rem; font-weight: bold; }
        .page-header { position: relative; margin-bottom: 30px; text-align: center; }
        .page-title { font-size: 1.5rem; color: #333; font-weight: 500; }
        .btn-back-arrow { position: absolute; left: 0; top: 50%; transform: translateY(-50%); font-size: 1.5rem; color: #333; text-decoration: none; }
        .form-card { background: white; border: 2px solid #3b82f6; border-radius: 10px; padding: 30px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
        .form-label { font-weight: 500; font-size: 0.9rem; color: #555; }
        .required-star { color: #dc3545; margin-left: 2px; }
        .form-control, .form-select { background-color: var(--input-bg); border: 1px solid #e0e0e0; border-radius: 6px; padding: 10px 15px; font-size: 0.95rem; }
        .info-box { background-color: #eef7ff; border: 1px solid #cce5ff; color: #555; padding: 15px; border-radius: 6px; font-size: 0.85rem; display: flex; gap: 10px; margin-top: 10px; margin-bottom: 20px; }
        .btn-save { background-color: #A52A2A; color: white; border: none; padding: 12px; border-radius: 6px; font-weight: 600; width: 100%; display: flex; align-items: center; justify-content: center; gap: 8px; transition: all 0.3s; }
        .btn-save:hover { background-color: #8a2323; transform: translateY(-2px); }
        .btn-cancel { background-color: white; color: #333; border: 1px solid #ddd; padding: 12px; border-radius: 6px; font-weight: 600; width: 100%; display: flex; align-items: center; justify-content: center; gap: 8px; text-decoration: none; }
        .is-invalid { border-color: #dc3545 !important; }
        .invalid-feedback { font-size: 0.85rem; color: #dc3545; display: block; margin-top: 5px; }
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

    <div class="container mt-4 mb-5" style="max-width: 900px;">
        <div class="page-header">
            <a href="{{ route('admin.kelola_pegawai') }}" class="btn-back-arrow"><i class="bi bi-arrow-left"></i></a>
            <h4 class="page-title">Tambah Pegawai Baru</h4>
        </div>

        <div class="form-card">
            <form id="formTambahPegawai" action="{{ route('admin.pegawai.store') }}" method="POST">

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <h6 class="alert-heading mb-2"><i class="bi bi-exclamation-triangle-fill me-2"></i>Ada Kesalahan!</h6>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
                @csrf
                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="form-label">Nama Lengkap <span class="required-star">*</span></label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                               placeholder="Masukkan nama lengkap" value="{{ old('name') }}" required>
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">NIP <span class="required-star">*</span></label>
                        <input type="number" name="nip" class="form-control @error('nip') is-invalid @enderror" 
                               placeholder="1978..." value="{{ old('nip') }}" required>
                        @error('nip') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Email <span class="required-star">*</span></label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                               placeholder="nama@didikbudpora.id" value="{{ old('email') }}" required>
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Nomor Telepon <span class="required-star">*</span></label>
                        <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" 
                               placeholder="08XXXXXXXXXX" value="{{ old('phone') }}" required>
                        @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Posisi / Jabatan <span class="required-star">*</span></label>
                        <input type="text" name="jabatan" class="form-control @error('jabatan') is-invalid @enderror" 
                               placeholder="Guru Matematika" value="{{ old('jabatan') }}" required>
                        @error('jabatan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Unit Kerja / Sekolah <span class="required-star">*</span></label>
                        <input type="text" name="bidang_unit" class="form-control @error('bidang_unit') is-invalid @enderror" 
                               placeholder="SMP Negeri 1 Semarang" value="{{ old('bidang_unit') }}" required>
                        @error('bidang_unit') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label">Tanggal Masuk</label>
                        <input type="date" name="join_date" class="form-control" value="{{ old('join_date') }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Kuota Cuti Tahunan <span class="required-star">*</span></label>
                        <input type="number" name="annual_leave_quota" class="form-control" value="{{ old('annual_leave_quota', 12) }}" required>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="aktif" selected>Aktif</option>
                            <option value="nonaktif">Non-aktif</option>
                        </select>
                    </div>
                </div>

                <div class="info-box mt-4">
                    <i class="bi bi-info-circle-fill text-primary fs-5"></i>
                    <div>
                        <strong>Catatan:</strong><br>
                        Pegawai akan otomatis aktif setelah disimpan.
                    </div>
                </div>

                <hr class="my-4">

                <div class="row g-3">
                    <div class="col-md-6">
                        <button type="button" onclick="simpanData()" class="btn btn-save">
                            <i class="bi bi-save"></i> Simpan Pegawai
                        </button>
                    </div>
                    <div class="col-md-6">
                        <a href="{{ route('admin.kelola_pegawai') }}" class="btn btn-cancel">
                            <i class="bi bi-x-lg"></i> Batal
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function simpanData() {
            // Validasi HTML5 manual (Cek apakah ada field kosong)
            const form = document.getElementById('formTambahPegawai');
            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }

            Swal.fire({
                title: 'Konfirmasi Simpan',
                text: "Pastikan data pegawai sudah benar.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#A52A2A',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Simpan!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Tampilkan Loading
                    Swal.fire({
                        title: 'Menyimpan...',
                        html: 'Mohon tunggu sebentar.',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    // Submit Form
                    form.submit();
                }
            });
        }
    </script>
</body>
</html>