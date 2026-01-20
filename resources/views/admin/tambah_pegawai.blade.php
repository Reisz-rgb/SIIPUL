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
        :root {
            --primary-red: #A52A2A;
            --bg-light: #f8f9fa;
            --input-bg: #f2f2f2;
        }
        body { background-color: var(--bg-light); font-family: 'Segoe UI', sans-serif; }

        /* Navbar */
        .navbar-custom { background-color: var(--primary-red); color: white; }
        .navbar-brand { font-weight: bold; font-size: 1.2rem; display: flex; align-items: center; gap: 10px; color: white !important; }
        
        /* User Profile (Static) */
        .user-pill { background: white; color: #333; padding: 5px 10px; border-radius: 50px; display: flex; align-items: center; gap: 10px; font-weight: 600; font-size: 0.9rem; }
        .avatar-circle { width: 32px; height: 32px; background-color: var(--primary-red); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.75rem; font-weight: bold; }

        /* Page Header */
        .page-header { position: relative; margin-bottom: 30px; text-align: center; }
        .page-title { font-size: 1.5rem; color: #333; font-weight: 500; }
        .btn-back-arrow { position: absolute; left: 0; top: 50%; transform: translateY(-50%); font-size: 1.5rem; color: #333; text-decoration: none; }
        .btn-back-arrow:hover { color: var(--primary-red); }

        /* Form Styling */
        .form-card { background: white; border: 2px solid #3b82f6; border-radius: 10px; padding: 30px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
        .form-label { font-weight: 500; font-size: 0.9rem; color: #555; }
        .required-star { color: #dc3545; margin-left: 2px; }
        .form-control, .form-select { background-color: var(--input-bg); border: 1px solid #e0e0e0; border-radius: 6px; padding: 10px 15px; font-size: 0.95rem; }
        .form-control:focus, .form-select:focus { background-color: white; border-color: #3b82f6; box-shadow: 0 0 0 0.2rem rgba(59, 130, 246, 0.25); }

        /* Info Box */
        .info-box { background-color: #eef7ff; border: 1px solid #cce5ff; color: #555; padding: 15px; border-radius: 6px; font-size: 0.85rem; display: flex; gap: 10px; margin-top: 10px; margin-bottom: 20px; }

        /* Buttons */
        .btn-save { background-color: #A52A2A; color: white; border: none; padding: 12px; border-radius: 6px; font-weight: 600; width: 100%; display: flex; align-items: center; justify-content: center; gap: 8px; transition: all 0.3s; }
        .btn-save:hover { background-color: #8a2323; transform: translateY(-2px); box-shadow: 0 4px 8px rgba(165, 42, 42, 0.3); }
        
        .btn-cancel { background-color: white; color: #333; border: 1px solid #ddd; padding: 12px; border-radius: 6px; font-weight: 600; width: 100%; display: flex; align-items: center; justify-content: center; gap: 8px; text-decoration: none; transition: background 0.2s; }
        .btn-cancel:hover { background-color: #f8f9fa; }
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
                <div class="avatar-circle">DS</div> 
                <div style="line-height: 1.2;">
                    <span class="d-block">Drs. Sutrisno</span>
                    <span class="d-block text-muted" style="font-size: 0.7rem; font-weight: normal;">Administrator</span>
                </div>
                <i class="bi bi-chevron-down text-muted ms-2" style="font-size: 0.8rem;"></i>
            </div>
        </div>
    </nav>

    <div class="container mt-4 mb-5" style="max-width: 900px;">
        
        <div class="page-header">
            <a href="{{ route('admin.kelola_pegawai') }}" class="btn-back-arrow"><i class="bi bi-arrow-left"></i></a>
            <h4 class="page-title">Tambah Pegawai Baru</h4>
        </div>

        <div class="form-card">
            <form id="formTambahPegawai" action="#" method="POST"> 
                @csrf
                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="form-label">Nama Lengkap <span class="required-star">*</span></label>
                        <input type="text" class="form-control" placeholder="Masukkan nama lengkap" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">NIP <span class="required-star">*</span></label>
                        <input type="number" class="form-control" placeholder="197801011999121001" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Email <span class="required-star">*</span></label>
                        <input type="email" class="form-control" placeholder="nama@didikbudpora.id" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Nomor Telepon <span class="required-star">*</span></label>
                        <input type="text" class="form-control" placeholder="08XXXXXXXXXX" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Posisi <span class="required-star">*</span></label>
                        <input type="text" class="form-control" placeholder="Guru Matematika" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Unit Kerja / Sekolah <span class="required-star">*</span></label>
                        <input type="text" class="form-control" placeholder="SMP Negeri 1 Semarang" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Tanggal Masuk <span class="required-star">*</span></label>
                        <input type="date" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Kuota Cuti Tahunan <span class="required-star">*</span></label>
                        <input type="number" class="form-control" placeholder="12" value="12" required>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Status</label>
                        <select class="form-select">
                            <option value="aktif" selected>Aktif</option>
                            <option value="nonaktif">Non-aktif</option>
                        </select>
                    </div>
                </div>

                <div class="info-box mt-4">
                    <i class="bi bi-info-circle-fill text-primary fs-5"></i>
                    <div>
                        <strong>Catatan:</strong><br>
                        Pegawai akan menerima email aktivasi otomatis setelah data berhasil disimpan. Pastikan semua data telah diisi dengan benar.
                    </div>
                </div>

                <hr class="my-4" style="border-color: #eee;">

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
            // Tampilkan animasi Loading dulu (opsional, biar keren)
            let timerInterval;
            Swal.fire({
                title: 'Menyimpan Data...',
                html: 'Mohon tunggu sebentar.',
                timer: 1000, // Simulasi loading 1 detik
                timerProgressBar: true,
                didOpen: () => {
                    Swal.showLoading()
                },
                willClose: () => {
                    clearInterval(timerInterval)
                }
            }).then((result) => {
                // Setelah loading selesai, tampilkan pesan SUKSES
                if (result.dismiss === Swal.DismissReason.timer) {
                    Swal.fire({
                        title: 'Berhasil!',
                        text: 'Data pegawai baru berhasil disimpan.',
                        icon: 'success',
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#A52A2A' // Warna merah bata sesuai tema
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Di sini nanti submit form beneran ke server
                            // document.getElementById('formTambahPegawai').submit(); 
                            
                            // Untuk demo, kita redirect balik ke halaman kelola pegawai
                            window.location.href = "{{ route('admin.kelola_pegawai') }}";
                        }
                    });
                }
            });
        }
    </script>
</body>
</html>