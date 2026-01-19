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
        
        .badge-status { background-color: #fff8e1; color: #ffc107; padding: 5px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: 600; border: 1px solid #ffe69c; }

        /* File Attachment */
        .file-item { display: flex; align-items: center; justify-content: space-between; border: 1px solid #eee; padding: 10px 15px; border-radius: 6px; margin-bottom: 10px; }
        .file-icon { font-size: 1.5rem; color: #dc3545; margin-right: 15px; }
        .file-name { font-weight: 600; font-size: 0.9rem; display: block; }
        .file-size { font-size: 0.75rem; color: #999; }

        /* Approval Section - DIPERBAIKI */
        .approval-section { border-top: 1px solid #eee; margin-top: 30px; padding-top: 20px; }
        .approval-title { color: #A52A2A; font-weight: bold; font-size: 1rem; margin-bottom: 20px; }
        .form-check-input:checked { background-color: #A52A2A; border-color: #A52A2A; }
        
        /* Signature Box - DIPERBAIKI (Pake Flexbox biar gak berantakan) */
        .signature-wrapper {
            display: flex;
            justify-content: flex-end; /* Memaksa ke kanan */
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

        /* Alert Animasi */
        .success-alert {
            position: fixed; top: 20px; left: 50%; transform: translateX(-50%) translateY(-100px);
            background-color: #d1e7dd; color: #0f5132; border: 1px solid #badbcc;
            padding: 15px 30px; border-radius: 50px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            z-index: 1050; opacity: 0; transition: all 0.5s cubic-bezier(0.68, -0.55, 0.27, 1.55);
            display: flex; align-items: center; gap: 10px; font-weight: 600;
        }
        .success-alert.show { transform: translateX(-50%) translateY(0); opacity: 1; }
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
                    <div class="avatar-circle">DS</div> <span>Drs. Sutrisno</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end mt-2">
                    <li><a class="dropdown-item" href="{{ route('admin.profil') }}">Profil Saya</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item text-danger" href="#">Keluar</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div id="successAlert" class="success-alert">
        <i class="bi bi-check-circle-fill fs-5"></i>
        Keputusan Berhasil Disimpan!
    </div>

    <div class="container-fluid px-4 mt-4 mb-5" style="max-width: 900px;">
        
        <div class="page-header">
            <a href="{{ route('admin.dashboard') }}" class="btn-back-arrow"><i class="bi bi-chevron-left"></i> Kembali</a>
        </div>

        <div class="detail-card shadow-sm">
            
            <div class="d-flex justify-content-between align-items-start mb-4">
                <div>
                    <h4 class="fw-bold mb-1">Budi Santoso</h4>
                    <p class="text-muted mb-2">Guru Matematika</p>
                    <span class="badge-status">Menunggu</span>
                    <span class="text-muted small ms-2">ID Pengajuan: #0081</span>
                </div>
            </div>

            <hr>

            <div class="section-title">I. DATA PEGAWAI</div>
            <div class="row g-3"> <div class="col-md-6">
                    <p class="data-label">NAMA</p>
                    <p class="data-value">Budi Santoso</p>
                </div>
                <div class="col-md-6">
                    <p class="data-label">NIP</p>
                    <p class="data-value">197801011999121001</p>
                </div>
                <div class="col-md-6">
                    <p class="data-label">JABATAN</p>
                    <p class="data-value">Guru Matematika</p>
                </div>
                <div class="col-md-6">
                    <p class="data-label">MASA KERJA</p>
                    <p class="data-value">12 Tahun</p>
                </div>
                <div class="col-12">
                    <p class="data-label">UNIT KERJA</p>
                    <p class="data-value">DISDIKBUDPORA KABUPATEN SEMARANG</p>
                </div>
            </div>

            <hr>

            <div class="row g-3">
                <div class="col-md-6">
                    <div class="section-title mt-0">II. JENIS CUTI YANG DIAMBIL</div>
                    <div class="p-2 bg-light border rounded d-inline-block">Cuti Tahunan</div>
                </div>
                <div class="col-md-6">
                    <div class="section-title mt-0">III. ALASAN CUTI</div>
                    <p class="data-value">Keperluan Pribadi</p>
                </div>
            </div>

            <hr>

            <div class="section-title">IV. LAMANYA CUTI</div>
            <div class="row g-3">
                <div class="col-md-4">
                    <p class="data-label">DURASI</p>
                    <p class="data-value">5 Hari</p>
                </div>
                <div class="col-md-4">
                    <p class="data-label">TANGGAL MULAI</p>
                    <p class="data-value">2024-05-20</p>
                </div>
                <div class="col-md-4">
                    <p class="data-label">TANGGAL SELESAI</p>
                    <p class="data-value">2024-05-25</p>
                </div>
            </div>

            <hr>

            <div class="section-title">V. CATATAN CUTI</div>
            <div class="row g-3">
                <div class="col-md-6">
                    <p class="data-label">TAHUN</p>
                    <p class="data-value">2024</p>
                </div>
                <div class="col-md-6">
                    <p class="data-label">SISA CUTI</p>
                    <p class="data-value">8 Hari</p>
                </div>
            </div>

            <hr>

            <div class="section-title">LAMPIRAN DOKUMEN</div>
            <div class="file-item">
                <div class="d-flex align-items-center">
                    <i class="bi bi-file-earmark-pdf-fill file-icon"></i>
                    <div>
                        <span class="file-name">Surat Keterangan Dokter.pdf</span>
                        <span class="file-size">200 KB</span>
                    </div>
                </div>
                <button class="btn btn-sm btn-outline-secondary">Lihat</button>
            </div>
            <div class="file-item">
                <div class="d-flex align-items-center">
                    <i class="bi bi-file-earmark-pdf-fill file-icon"></i>
                    <div>
                        <span class="file-name">Surat Permohonan Cuti.pdf</span>
                        <span class="file-size">150 KB</span>
                    </div>
                </div>
                <button class="btn btn-sm btn-outline-secondary">Lihat</button>
            </div>

        </div>

        <div class="detail-card shadow-sm">
            <form id="formKeputusan">
                
                <div class="approval-section pt-0 border-top-0 mt-0">
                    <h5 class="approval-title">VII. KEPUTUSAN PEJABAT YANG BERWENANG</h5>
                    <div class="d-flex flex-wrap gap-4 mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="keputusan" id="k_setuju" value="disetujui">
                            <label class="form-check-label" for="k_setuju">Disetujui</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="keputusan" id="k_ubah" value="perubahan">
                            <label class="form-check-label" for="k_ubah">Perubahan</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="keputusan" id="k_tangguh" value="ditangguhkan">
                            <label class="form-check-label" for="k_tangguh">Ditangguhkan</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="keputusan" id="k_tolak" value="tidak_disetujui">
                            <label class="form-check-label" for="k_tolak">Tidak Disetujui</label>
                        </div>
                    </div>

                    <div class="signature-wrapper">
                        <div class="signature-box">
                            <p class="mb-5 fw-bold">Pejabat Berwenang</p>
                            <p class="signature-name">Drs. Sutrisno</p>
                            <span class="signature-nip">NIP. 19680510 199003 1 004</span>
                        </div>
                    </div>
                </div>

                <div class="approval-section">
                    <h5 class="approval-title">VIII. PERTIMBANGAN ATASAN LANGSUNG</h5>
                    <div class="d-flex flex-wrap gap-4 mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="pertimbangan" id="p_setuju" value="disetujui">
                            <label class="form-check-label" for="p_setuju">Disetujui</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="pertimbangan" id="p_ubah" value="perubahan">
                            <label class="form-check-label" for="p_ubah">Perubahan</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="pertimbangan" id="p_tangguh" value="ditangguhkan">
                            <label class="form-check-label" for="p_tangguh">Ditangguhkan</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="pertimbangan" id="p_tolak" value="tidak_disetujui">
                            <label class="form-check-label" for="p_tolak">Tidak Disetujui</label>
                        </div>
                    </div>
                    
                    <div class="signature-wrapper">
                        <div class="signature-box">
                            <p class="mb-5 fw-bold">Sekretaris</p>
                            <p class="signature-name">Budi Riyanto, S.Pd.,M.Pd</p>
                            <span class="signature-nip">NIP. 19790902 200604 1 005</span>
                        </div>
                    </div>
                </div>

                <div class="mt-5">
                    <button type="button" onclick="simpanKeputusan()" class="btn btn-action-green shadow-sm">
                        <i class="bi bi-save me-2"></i> SIMPAN KEPUTUSAN
                    </button>
                </div>

            </form>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        function simpanKeputusan() {
            const alertBox = document.getElementById('successAlert');
            alertBox.classList.add('show');
            setTimeout(() => {
                alertBox.classList.remove('show');
            }, 3000);
        }
    </script>
</body>
</html>