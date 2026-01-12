{{-- resources/views/pengajuan-cuti.blade.php --}}

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIIPUL - Formulir Pengajuan Cuti</title>
    
    {{-- FontAwesome untuk Icon --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root{
            --primary: #8b1515; /* Merah Marun */
            --bg: #f3f5fb;
            --card: #ffffff;
            --border: #d1d5db;
            --text: #111827;
            --muted: #6b7280;
            --blue-bg: #dbeafe; /* Background Tips */
            --blue-text: #1e40af; /* Text Tips */
            --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            background: var(--bg);
            color: var(--text);
            font-size: 14px;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* --- HERO HEADER --- */
        .topbar {
            min-height: 280px; 
            background: var(--primary);
            color: #fff;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
            text-align: center;
            z-index: 1; 
        }

        .brand-hero {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
            margin-bottom: 60px; 
        }

        .brand-hero img {
            height: 75px;
            width: auto;
            object-fit: contain;
            filter: drop-shadow(0 4px 6px rgba(0,0,0,0.3));
            margin-bottom: 5px;
        }

        .brand-title {
            font-size: 28px;
            font-weight: 800;
            letter-spacing: 1px;
            margin: 0;
            line-height: 1.2;
        }

        .brand-subtitle {
            font-size: 14px;
            font-weight: 300;
            opacity: 0.9;
            margin: 0;
            letter-spacing: 0.5px;
        }

        /* User Chip */
        .userchip {
            position: absolute;
            top: 24px;
            right: 32px;
            display: flex; align-items: center; gap: 12px;
            background: #fff; 
            color: var(--text);
            padding: 6px 8px 6px 16px;
            border-radius: 999px;
            min-width: 200px;
            justify-content: space-between;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            transition: transform 0.2s;
        }
        .userchip:hover { transform: translateY(-2px); }
        .userleft { display: flex; align-items: center; gap: 12px; text-align: right; }
        .avatar {
            width: 38px; height: 38px; border-radius: 999px;
            background: var(--primary); color: #fff;
            display: flex; align-items: center; justify-content: center;
            font-weight: 600; font-size: 14px;
        }
        .uname { font-weight: 700; font-size: 14px; line-height: 1.2; }
        .urole { font-size: 12px; color: var(--muted); line-height: 1.2; }

        /* --- FORM CONTAINER --- */
        .container {
            max-width: 950px;
            width: 95%;
            margin: -70px auto 40px; 
            position: relative;
            z-index: 10; 
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            padding: 40px;
        }

        /* Header Form */
        .form-header-content {
            text-align: center;
            margin-bottom: 30px;
        }
        .form-title-text {
            font-size: 24px;
            font-weight: 800;
            color: #111;
            margin-bottom: 8px;
        }
        .form-subtitle-text {
            color: var(--muted);
            font-size: 14px;
        }

        /* Tombol Back */
        .back-btn {
            display: inline-flex;
            align-items: center;
            text-decoration: none;
            color: #111;
            font-size: 24px;
            margin-bottom: 20px;
            transition: color 0.2s;
            cursor: pointer;
        }
        .back-btn:hover { color: var(--primary); }

        /* Section Box */
        .section-box {
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 24px;
            background: #fdfdfd;
        }

        .section-title {
            font-size: 14px;
            font-weight: 800;
            color: var(--primary);
            margin-bottom: 16px;
            text-transform: uppercase;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        /* Inputs */
        .form-group { margin-bottom: 16px; }
        .form-label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 6px;
        }
        .required { color: #ef4444; margin-left: 2px; }

        .form-input, .form-textarea {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid var(--border);
            border-radius: 6px;
            font-size: 14px;
            outline: none;
            color: #374151;
            background: #fff;
            transition: all 0.2s;
        }
        .form-input:focus, .form-textarea:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(139, 21, 21, 0.1);
        }
        .form-input[readonly] {
            background-color: #f9fafb;
            color: #6b7280;
            cursor: default;
            border-color: #e5e7eb;
        }
        .form-textarea { min-height: 100px; resize: vertical; }

        /* Grids */
        .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        .grid-date { display: grid; grid-template-columns: 150px 1fr 1fr; gap: 20px; align-items: end; }
        .radio-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }

        /* Radio Item */
        .radio-item {
            display: flex; align-items: center; padding: 12px;
            border: 1px solid var(--border); border-radius: 6px; background: white; cursor: pointer;
        }
        .radio-item:hover { border-color: var(--primary); }
        .radio-item input { margin-right: 10px; width: 16px; height: 16px; accent-color: var(--primary); }
        .radio-label { font-size: 13px; font-weight: 500; }

        /* --- STYLE BARU UNTUK UPLOAD & TIPS --- */
        
        /* Upload Area */
        .upload-area {
            position: relative;
            border: 2px dashed #d1d5db;
            background: #f8fafc;
            border-radius: 8px;
            padding: 30px;
            text-align: center;
            transition: all 0.2s;
            cursor: pointer;
        }
        .upload-area:hover {
            border-color: var(--primary);
            background: #fff5f5;
        }
        .upload-area input[type="file"] {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0; left: 0;
            opacity: 0;
            cursor: pointer;
        }
        .upload-icon {
            font-size: 28px;
            color: #9ca3af;
            margin-bottom: 12px;
        }
        .upload-text {
            font-size: 14px;
            font-weight: 600;
            color: #4b5563;
        }
        .upload-hint {
            font-size: 12px;
            color: #9ca3af;
            margin-top: 6px;
        }

        /* Tips Box */
        .tips-box {
            background-color: var(--blue-bg);
            border: 1px solid #bfdbfe;
            border-radius: 8px;
            padding: 16px;
            margin-top: 20px;
            display: flex;
            gap: 15px;
            color: var(--blue-text);
        }
        .tips-icon {
            font-size: 18px;
            margin-top: 2px;
        }
        .tips-content h4 {
            margin: 0 0 5px 0;
            font-size: 14px;
            font-weight: 700;
        }
        .tips-content p {
            margin: 0;
            font-size: 13px;
            line-height: 1.5;
            opacity: 0.9;
        }


        /* Submit Button */
        .btn-submit {
            width: 100%; background: var(--primary); color: white; border: none; padding: 14px;
            border-radius: 8px; font-size: 16px; font-weight: 600; cursor: pointer;
            display: flex; align-items: center; justify-content: center; gap: 10px;
            transition: background 0.2s; margin-top: 20px;
        }
        .btn-submit:hover { background: #711010; }

        .footer-note { text-align: center; font-size: 12px; color: #9ca3af; margin-top: 15px; }

        @media (max-width: 768px) {
            .grid-2, .grid-date, .radio-grid { grid-template-columns: 1fr; }
            .container { margin-top: -40px; padding: 20px; }
            .topbar { min-height: auto; padding-bottom: 70px; }
            .userchip { position: relative; top: auto; right: auto; margin-top: 15px; width: 100%; }
        }
    </style>
</head>
<body>

    <div class="topbar">
        <div class="brand-hero">
            {{-- Pastikan file gambar ada di public folder --}}
            <img src="{{ asset('logokabupatensemarang.png') }}" alt="Logo Kab Semarang"> 
            
            <h1 class="brand-title">SIIPUL</h1>
            <p class="brand-subtitle">Sistem Informasi Pengajuan Cuti Online</p>
        </div>

        <div class="userchip">
            <div class="userleft">
                <div>
                    <div class="uname">{{ Auth::user()->name ?? 'Budi Santoso' }}</div>
                    <div class="urole">Guru Matematika</div>
                </div>
            </div>
            <div class="avatar">
                {{ substr(Auth::user()->name ?? 'BS', 0, 2) }}
            </div>
        </div>
    </div>

    <div class="container">
        
        <a href="{{ url('/dashboarduser') }}" class="back-btn">
            <i class="fa-solid fa-arrow-left"></i>
        </a>

        <div class="form-header-content">
            <h2 class="form-title-text">Formulir Pengajuan Cuti Pegawai</h2>
            <p class="form-subtitle-text">Silakan lengkapi data di bawah ini dengan benar</p>
        </div>

        {{-- Tambahkan enctype="multipart/form-data" untuk support upload file --}}
        <form action="{{ route('cuti.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- SECTION I: DATA PEGAWAI --}}
            <div class="section-box">
                <div class="section-title">I. DATA PEGAWAI</div>
                
                <div class="grid-2">
                    <div class="form-group">
                        <label class="form-label">Nama Lengkap <span class="required">*</span></label>
                        <input type="text" class="form-input" value="{{ Auth::user()->name ?? 'Budi Santoso, S.Pd.' }}" readonly>
                    </div>
                    <div class="form-group">
                        <label class="form-label">NIP <span class="required">*</span></label>
                        <input type="text" class="form-input" value="19800101 200501 1 005" readonly>
                    </div>
                </div>

                <div class="grid-2">
                    <div class="form-group">
                        <label class="form-label">Jabatan <span class="required">*</span></label>
                        <input type="text" class="form-input" value="Guru Ahli Pertama" readonly>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Masa Kerja <span class="required">*</span></label>
                        <div style="display: flex; gap: 10px;">
                            <div style="flex:1; display:flex; align-items:center; gap:5px;">
                                <input type="text" class="form-input" value="12" readonly> <span style="font-size:12px; color:#666;">Tahun</span>
                            </div>
                            <div style="flex:1; display:flex; align-items:center; gap:5px;">
                                <input type="text" class="form-input" value="04" readonly> <span style="font-size:12px; color:#666;">Bulan</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Unit Kerja <span class="required">*</span></label>
                    <input type="text" class="form-input" value="DISDIKBUDPORA KABUPATEN SEMARANG" readonly>
                </div>
            </div>

            {{-- SECTION II: JENIS CUTI --}}
            <div class="section-box">
                <div class="section-title">II. JENIS CUTI YANG DIAMBIL</div>
                
                <div class="radio-grid">
                    <label class="radio-item">
                        <input type="radio" name="jenis_cuti" value="Cuti Tahunan" checked>
                        <span class="radio-label">Cuti Tahunan</span>
                    </label>
                    <label class="radio-item">
                        <input type="radio" name="jenis_cuti" value="Cuti Besar">
                        <span class="radio-label">Cuti Besar</span>
                    </label>
                    <label class="radio-item">
                        <input type="radio" name="jenis_cuti" value="Cuti Sakit">
                        <span class="radio-label">Cuti Sakit</span>
                    </label>
                    <label class="radio-item">
                        <input type="radio" name="jenis_cuti" value="Cuti Melahirkan">
                        <span class="radio-label">Cuti Melahirkan</span>
                    </label>
                    <label class="radio-item">
                        <input type="radio" name="jenis_cuti" value="Cuti Alasan Penting">
                        <span class="radio-label">Cuti Karena Alasan Penting</span>
                    </label>
                    <label class="radio-item">
                        <input type="radio" name="jenis_cuti" value="Cuti Luar Tanggungan">
                        <span class="radio-label">Cuti di Luar Tanggungan Negara</span>
                    </label>
                </div>
            </div>

            {{-- SECTION III: ALASAN CUTI --}}
            <div class="section-box">
                <div class="section-title">III. ALASAN CUTI</div>
                <div class="form-group">
                    <label class="form-label">Uraian Alasan Cuti <span class="required">*</span></label>
                    <textarea name="alasan" class="form-textarea" placeholder="Jelaskan alasan pengambilan cuti secara detail..." required></textarea>
                </div>
            </div>

            {{-- SECTION IV: LAMA CUTI --}}
            <div class="section-box">
                <div class="section-title">IV. LAMANYA CUTI</div>
                <div class="grid-date">
                    <div class="form-group">
                        <label class="form-label">Selama (Hari)</label>
                        <input type="number" name="lama_hari" class="form-input" placeholder="0" min="1" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Mulai Tanggal</label>
                        <input type="date" name="tanggal_mulai" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">s/d Tanggal</label>
                        <input type="date" name="tanggal_selesai" class="form-input" required>
                    </div>
                </div>
            </div>

            {{-- SECTION V: CATATAN CUTI --}}
            <div class="section-box">
                <div class="section-title">V. CATATAN CUTI</div>
                <div style="overflow-x:auto;">
                    <table style="width:100%; border-collapse:collapse; font-size:13px;">
                        <thead>
                            <tr style="border-bottom:1px solid #eee; text-align:left; color:#666;">
                                <th style="padding:8px; width:20%;">Tahun</th>
                                <th style="padding:8px; width:30%;">Sisa Cuti</th>
                                <th style="padding:8px;">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="padding:8px; font-weight:600;">N-2</td>
                                <td style="padding:8px;"><input type="text" class="form-input" value="0" readonly></td>
                                <td style="padding:8px;"><input type="text" class="form-input" placeholder="Keterangan..." readonly></td>
                            </tr>
                            <tr>
                                <td style="padding:8px; font-weight:600;">N-1</td>
                                <td style="padding:8px;"><input type="text" class="form-input" value="0" readonly></td>
                                <td style="padding:8px;"><input type="text" class="form-input" placeholder="Keterangan..." readonly></td>
                            </tr>
                            <tr>
                                <td style="padding:8px; font-weight:600;">N (Tahun Berjalan)</td>
                                <td style="padding:8px;"><input type="text" class="form-input" value="12" readonly style="font-weight:bold; color:var(--primary);"></td>
                                <td style="padding:8px;"><input type="text" class="form-input" value="Sisa cuti tahun ini" readonly></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- SECTION VI: ALAMAT CUTI --}}
            <div class="section-box">
                <div class="section-title">VI. ALAMAT SELAMA MENJALANKAN CUTI</div>
                <div class="form-group">
                    <label class="form-label">Alamat Lengkap <span class="required">*</span></label>
                    <textarea name="alamat_cuti" class="form-textarea" style="min-height:80px;" placeholder="Jalan, RT/RW, Kelurahan, Kecamatan, Kota/Kabupaten..." required></textarea>
                </div>
                <div class="form-group">
                    <label class="form-label">Nomor Telepon / HP <span class="required">*</span></label>
                    <input type="text" name="no_telepon" class="form-input" placeholder="08xxxxxxxxxx" required>
                </div>
            </div>

            {{-- SECTION VII: DOKUMEN PENDUKUNG (BARU: SESUAI REQUEST) --}}
            <div class="section-box">
                <div class="section-title">VII. DOKUMEN PENDUKUNG (OPSIONAL)</div>

                {{-- Catatan Tambahan (Mirip kolom "Alasan Pengajuan Diperbaharui" di gambar) --}}
                <div class="form-group">
                    <label class="form-label">Catatan Tambahan</label>
                    <textarea name="catatan_tambahan" class="form-textarea" style="background:#f9fafb;" placeholder="Tambahkan catatan jika ada hal spesifik yang perlu disampaikan..."></textarea>
                </div>

                {{-- Upload Area (Mirip "Klik atau seret file" di gambar) --}}
                <div class="form-group">
                    <label class="form-label">Dokumen Lampiran (Surat Dokter, dll)</label>
                    <div class="upload-area">
                        <input type="file" name="dokumen_pendukung" id="fileUpload" accept=".pdf,.doc,.docx,.jpg,.png,.xls,.xlsx">
                        <div class="upload-icon">
                            <i class="fa-solid fa-arrow-up-from-bracket"></i>
                        </div>
                        <div class="upload-text">Klik atau seret file ke sini</div>
                        <div class="upload-hint">Supported: PDF, DOC, JPG, PNG, XLS (Maks 5MB)</div>
                    </div>
                </div>

                {{-- Tips Box (Mirip kotak biru di gambar) --}}
                <div class="tips-box">
                    <div class="tips-icon">
                        <i class="fa-regular fa-lightbulb"></i>
                    </div>
                    <div class="tips-content">
                        <h4>Tips:</h4>
                        <p>Pastikan Anda melengkapi semua dokumen pendukung (seperti surat keterangan sakit dari dokter) agar proses verifikasi berjalan lancar.</p>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn-submit">
                <i class="fa-solid fa-paper-plane"></i> &nbsp; Ajukan Permohonan Cuti
            </button>

            <p class="footer-note">
                Dengan menekan tombol ini, Anda menyatakan bahwa data yang diisi adalah benar dan dapat dipertanggungjawabkan.
            </p>

        </form>
    </div>

</body>
</html>