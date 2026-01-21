<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pegawai - SIIPUL</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    
    <style>
        :root { --primary-red: #A52A2A; --bg-light: #f8f9fa; }
        body { background-color: var(--bg-light); font-family: 'Segoe UI', sans-serif; }
        .navbar-custom { background-color: var(--primary-red); color: white; }
        .form-card { background: white; border-radius: 10px; padding: 30px; border: 1px solid #ddd; }
        .btn-save { background-color: #ffc107; color: #000; border: none; padding: 10px 20px; font-weight: bold; width: 100%; }
        .btn-save:hover { background-color: #e0a800; }
        .btn-cancel { background-color: white; border: 1px solid #ddd; color: #333; width: 100%; display: block; text-align: center; padding: 10px; text-decoration: none; font-weight: bold;}
        .is-invalid { border-color: #dc3545 !important; }
        .invalid-feedback { color: #dc3545; font-size: 0.875em; margin-top: 0.25rem; }
    </style>
</head>
<body>

    <nav class="navbar navbar-custom py-3 mb-4">
        <div class="container">
            <span class="navbar-brand mb-0 h1">Edit Data Pegawai</span>
        </div>
    </nav>

    <div class="container mb-5" style="max-width: 900px;">
        <div class="form-card">
            <form id="formEditPegawai" action="{{ route('admin.pegawai.update', $pegawai->id) }}" method="POST">
                @csrf
                @method('PUT') 

                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                               value="{{ old('name', $pegawai->name) }}" required>
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label">NIP</label>
                        <input type="number" name="nip" class="form-control @error('nip') is-invalid @enderror" 
                               value="{{ old('nip', $pegawai->nip) }}" required>
                        @error('nip') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                               value="{{ old('email', $pegawai->email) }}" required>
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label">Nomor Telepon</label>
                        <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" 
                               value="{{ old('phone', $pegawai->phone) }}" required>
                        @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label">Jabatan</label>
                        <input type="text" name="jabatan" class="form-control @error('jabatan') is-invalid @enderror" 
                               value="{{ old('jabatan', $pegawai->jabatan) }}" required>
                        @error('jabatan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label">Unit Kerja</label>
                        <input type="text" name="bidang_unit" class="form-control @error('bidang_unit') is-invalid @enderror" 
                               value="{{ old('bidang_unit', $pegawai->bidang_unit) }}" required>
                        @error('bidang_unit') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    
                    <div class="col-md-12">
                         <label class="form-label">Status Akun</label>
                         <select name="status" class="form-select">
                             <option value="aktif" {{ old('status', $pegawai->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                             <option value="nonaktif" {{ old('status', $pegawai->status) == 'nonaktif' ? 'selected' : '' }}>Non-aktif</option>
                         </select>
                    </div>
                </div>

                <hr class="my-4">

                <div class="row g-3">
                    <div class="col-md-6">
                        <button type="button" onclick="simpanPerubahan()" class="btn btn-save">
                            <i class="bi bi-pencil-square"></i> Update Data
                        </button>
                    </div>
                    <div class="col-md-6">
                        <a href="{{ route('admin.kelola_pegawai') }}" class="btn btn-cancel">
                            Batal
                        </a>
                    </div>
                </div>
            </form>
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
                confirmButtonColor: '#ffc107',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Update!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Menyimpan...',
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