<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya - SIIPUL</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <style>
        :root {
            --primary-red: #A52A2A; /* Merah Bata */
            --bg-light: #f8f9fa;
        }
        body { background-color: white; font-family: 'Segoe UI', sans-serif; }

        /* Header Navigation */
        .top-header {
            background-color: var(--primary-red);
            color: white;
            padding: 15px 20px;
            font-weight: 500;
            font-size: 1.1rem;
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .btn-back { color: white; text-decoration: none; font-size: 1.2rem; }
        .btn-back:hover { color: #e0e0e0; }

        /* Kartu Merah Profil */
        .profile-banner-card {
            background-color: #A52A2A; 
            color: white;
            border-radius: 10px;
            padding: 30px;
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 30px;
        }
        .profile-avatar-large {
            width: 80px;
            height: 80px;
            background-color: white;
            color: #A52A2A;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            font-weight: bold;
        }

        /* Form Styling */
        .form-card {
            border: 1px solid #eee;
            border-radius: 10px;
            padding: 30px;
            margin-bottom: 30px;
            background: white;
        }
        .form-label-custom {
            font-size: 0.75rem;
            color: #888;
            font-weight: 600;
            margin-bottom: 5px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .form-control-custom {
            background-color: #f2f2f2; 
            border: none;
            padding: 12px 15px;
            border-radius: 6px;
        }
        .form-control-custom:focus {
            background-color: #e9e9e9;
            box-shadow: none;
        }

        /* Info Box Biru */
        .info-note {
            background-color: #eef7ff;
            border: 1px solid #dceeff;
            color: #555;
            padding: 20px;
            border-radius: 8px;
            font-size: 0.85rem;
            line-height: 1.6;
        }
        .info-note strong { color: #333; display: block; margin-bottom: 5px; font-size: 0.95rem; }

        /* Logout Button */
        .btn-logout-custom {
            border: 1px solid #ffcccc;
            color: #dc3545;
            background: white;
            padding: 10px 25px;
            border-radius: 6px;
            font-size: 0.9rem;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .btn-logout-custom:hover {
            background-color: #fff5f5;
            border-color: #dc3545;
        }

        /* --- TAMBAHAN STYLE UNTUK TOMBOL SIMPAN --- */
        .btn-save-custom {
            background-color: #198754; /* Hijau Sukses */
            color: white;
            border: none;
            padding: 10px 25px;
            border-radius: 6px;
            font-size: 0.9rem;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .btn-save-custom:hover {
            background-color: #146c43;
            color: white;
        }

        /* --- STYLE ALERT ANIMASI --- */
        .success-alert {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%) translateY(-100px); /* Mulai dari atas layar (tersembunyi) */
            background-color: #d1e7dd;
            color: #0f5132;
            border: 1px solid #badbcc;
            padding: 15px 30px;
            border-radius: 50px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            z-index: 1050;
            opacity: 0;
            transition: all 0.5s cubic-bezier(0.68, -0.55, 0.27, 1.55); /* Efek membal (bouncing) */
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 600;
        }
        
        .success-alert.show {
            transform: translateX(-50%) translateY(0); /* Muncul ke posisi normal */
            opacity: 1;
        }
    </style>
</head>
<body>

    <div class="top-header">
        <a href="{{ route('admin.dashboard') }}" class="btn-back"><i class="bi bi-chevron-left"></i></a>
        <span>Profil Saya</span>
    </div>

    <div id="successAlert" class="success-alert">
        <i class="bi bi-check-circle-fill fs-5"></i>
        Profil berhasil diperbarui!
    </div>

    <div class="container mt-4" style="max-width: 800px;">
        
        <div class="profile-banner-card">
            <div class="profile-avatar-large">DS</div>
            <div>
                <h4 class="mb-0 fw-bold">Drs. Sutrisno</h4>
                <small class="text-white-50">{{ ucfirst(Auth::user()->role) }}</small>
            </div>
        </div>

        <div class="form-card shadow-sm">
            <form id="profileForm">
                <div class="mb-4">
                    <label class="form-label-custom">
                        <i class="bi bi-person text-danger"></i> NAMA BARU :
                    </label>
                    <input type="text" class="form-control form-control-custom" value="Drs. Sutrisno">
                </div>

                <div class="mb-4">
                    <label class="form-label-custom">
                        <i class="bi bi-envelope text-danger"></i> EMAIL
                    </label>
                    <input type="email" class="form-control form-control-custom" value="sutrisno.dinas@example.com">
                </div>

                <div class="mb-2">
                    <label class="form-label-custom">
                        <i class="bi bi-archive text-danger"></i> FOTO
                    </label>
                    <div class="d-flex">
                        <input type="file" class="form-control form-control-custom w-auto">
                    </div>
                </div>
            </form>
        </div>

        <div class="info-note mb-4">
            <strong>Catatan</strong>
            Untuk mengubah data yang lebih kompleks seperti NIP, informasi kontak, silakan hubungi bagian HRD. Beberapa data mungkin diubah oleh administrator.
        </div>

        <div class="mb-5 d-flex justify-content-end gap-3">
            <button type="button" class="btn btn-save-custom" onclick="simpanProfil()">
                <i class="bi bi-save"></i> Simpan
            </button>
            <form action="{{ route('logout') }}" method="POST" id="logout-form">
                @csrf
                <button type="submit" class="btn btn-logout-custom">
                    <i class="bi bi-box-arrow-right"></i> Log Out
                </button>
            </form>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        function simpanProfil() {
            const alertBox = document.getElementById('successAlert');
            
            // 1. Munculkan Alert
            alertBox.classList.add('show');

            // 2. Hilangkan Alert setelah 3 detik
            setTimeout(() => {
                alertBox.classList.remove('show');
            }, 3000);
        }
    </script>
</body>
</html>