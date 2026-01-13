<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pengajuan Cuti - SIIPUL</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        /* --- 1. CSS VARIABLES & RESET --- */
        :root {
            --primary: #8b1515;   
            --bg: #f8f9fa;        
            --card-bg: #ffffff;
            --text-main: #1f2937;
            --text-muted: #6b7280;
            --border: #e5e7eb;

            /* Status Colors */
            --ok: #15803d;   --ok-bg: #dcfce7; --ok-border: #bbf7d0;
            --pen: #b45309;  --pen-bg: #fef3c7; --pen-border: #fde68a;
            --rej: #b91c1c;  --rej-bg: #fee2e2; --rej-border: #fecaca;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Inter', sans-serif; }
        body { background-color: var(--bg); color: var(--text-main); min-height: 100vh; display: flex; flex-direction: column; font-size: 15px; } /* Base font size naik */
        a { text-decoration: none; color: inherit; }

        /* --- 2. HEADER / TOPBAR --- */
        .topbar {
            background-color: var(--primary);
            height: 80px; /* Tinggi navbar ditambah */
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 40px; /* Padding kiri kanan ditambah */
            color: white;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);
            position: sticky; top: 0; z-index: 50;
        }
        .header-left { display: flex; align-items: center; gap: 24px; }
        .back-btn { font-size: 20px; color: white; opacity: 0.9; transition: 0.2s; }
        .back-btn:hover { opacity: 1; transform: translateX(-3px); }
        .page-title { font-size: 20px; font-weight: 600; letter-spacing: 0.5px; display: flex; align-items: center; gap: 12px; }
        .user-avatar { 
            width: 36px; height: 36px; /* Avatar diperbesar */
            background: white; color: var(--primary); 
            border-radius: 50%; display: flex; align-items: center; justify-content: center; 
            font-weight: 700; font-size: 15px; 
        }

        /* --- 3. MAIN CONTAINER --- */
        /* UPDATE: Max-width dibesarkan ke 1200px */
        .container { max-width: 1200px; margin: 50px auto; padding: 0 30px; flex: 1; width: 100%; }

        /* Filter Section */
        .filter-section { margin-bottom: 35px; }
        .filter-label { font-size: 14px; font-weight: 600; color: var(--text-muted); margin-bottom: 12px; text-transform: uppercase; letter-spacing: 0.5px; }
        .filter-buttons { display: flex; gap: 12px; flex-wrap: wrap; }
        .filter-btn {
            border: 1px solid var(--border);
            background: white;
            padding: 10px 24px; /* Tombol filter lebih besar */
            border-radius: 50px;
            font-size: 14px; font-weight: 500; color: var(--text-muted);
            cursor: pointer; transition: all 0.2s;
        }
        .filter-btn:hover { background: #f3f4f6; }
        .filter-btn.active { 
            background: var(--primary); color: white; border-color: var(--primary); 
            box-shadow: 0 4px 6px rgba(139, 21, 21, 0.2);
        }

        /* Card List */
        .history-list { display: flex; flex-direction: column; gap: 20px; }
        
        .card { 
            background: var(--card-bg); 
            border-radius: 16px; 
            padding: 30px 35px; /* Padding dalam card diperbesar */
            display: flex; align-items: center; justify-content: space-between; 
            border: 1px solid var(--border);
            box-shadow: 0 2px 4px rgba(0,0,0,0.03);
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .card:hover { transform: translateY(-3px); box-shadow: 0 12px 20px -5px rgba(0,0,0,0.08); }

        /* Status Colors on Cards */
        .card[data-status="approved"] { border-left: 6px solid var(--ok); }
        .card[data-status="pending"]  { border-left: 6px solid var(--pen); }
        .card[data-status="rejected"] { border-left: 6px solid var(--rej); }

        .card-left { display: flex; align-items: center; gap: 24px; } /* Jarak icon ke teks diperbesar */
        .status-icon-circle {
            width: 52px; height: 52px; /* Icon diperbesar */
            border-radius: 50%; 
            display: flex; align-items: center; justify-content: center;
            font-size: 22px; 
        }
        .st-ok { background: var(--ok-bg); color: var(--ok); }
        .st-pen { background: var(--pen-bg); color: var(--pen); }
        .st-rej { background: var(--rej-bg); color: var(--rej); }

        .card-info h4 { font-size: 18px; font-weight: 700; color: #111; margin-bottom: 6px; } /* Font judul diperbesar */
        .card-date { font-size: 14px; color: #555; display: flex; align-items: center; gap: 8px; }
        
        .card-right { text-align: right; display: flex; flex-direction: column; align-items: flex-end; gap: 12px; }
        .duration-badge { font-size: 13px; font-weight: 600; background: #f3f4f6; padding: 6px 14px; border-radius: 8px; color: #374151; }
        
        .btn-detail-sm {
            font-size: 13px; font-weight: 600; color: var(--primary); 
            background: transparent; border: 1.5px solid var(--primary);
            padding: 8px 18px; border-radius: 8px; cursor: pointer; transition: 0.2s;
        }
        .btn-detail-sm:hover { background: var(--primary); color: white; }


        /* --- 4. MODAL STYLE (OFFICIAL DOCUMENT LOOK) --- */
        .modal-overlay {
            position: fixed; inset: 0; background: rgba(0,0,0,0.6);
            display: none; align-items: center; justify-content: center;
            z-index: 1000; backdrop-filter: blur(3px);
            opacity: 0; transition: opacity 0.3s ease;
        }
        .modal-overlay.show { display: flex; opacity: 1; }

        /* UPDATE: Modal width dibesarkan ke 700px */
        .modal-box { 
            background: white; width: 100%; max-width: 700px; 
            border-radius: 20px; overflow: hidden; 
            box-shadow: 0 30px 60px -12px rgba(0,0,0,0.3);
            transform: translateY(20px); transition: transform 0.3s ease;
        }
        .modal-overlay.show .modal-box { transform: translateY(0); }

        .modal-header {
            padding: 25px 40px 15px 40px; display: flex; justify-content: space-between; align-items: center;
        }
        .modal-title { font-size: 20px; font-weight: 700; color: #111; }
        .modal-close { background: none; border: none; font-size: 28px; color: #999; cursor: pointer; }
        .modal-close:hover { color: #333; }

        /* Hero Status Section */
        .status-hero {
            padding: 30px 40px;
            display: flex; flex-direction: column; align-items: center; justify-content: center;
            text-align: center; margin: 0 40px 25px 40px;
            border-radius: 16px; gap: 12px;
        }
        /* Status Variants */
        .hero-approved { background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%); border: 1px solid #bbf7d0; }
        .hero-pending  { background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%); border: 1px solid #fde68a; }
        .hero-rejected { background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%); border: 1px solid #fecaca; }

        .hero-icon { font-size: 42px; margin-bottom: 8px; } /* Hero Icon diperbesar */
        .hero-approved .hero-icon { color: var(--ok); }
        .hero-pending .hero-icon  { color: var(--pen); }
        .hero-rejected .hero-icon { color: var(--rej); }

        .hero-title { font-weight: 700; font-size: 18px; color: #333; }
        .hero-desc { font-size: 14px; color: #555; max-width: 90%; line-height: 1.5; }

        /* Data Content */
        .modalBody { padding: 0 40px 40px 40px; max-height: 65vh; overflow-y: auto; }

        .info-group-title {
            font-size: 12px; font-weight: 700; color: #9ca3af; text-transform: uppercase;
            letter-spacing: 1px; margin-bottom: 16px; margin-top: 25px;
            display: flex; align-items: center; gap: 10px;
        }
        .info-group-title::after { content: ''; flex: 1; height: 1px; background: #e5e7eb; }

        .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 25px; }
        .info-item { display: flex; flex-direction: column; gap: 6px; }
        .info-label { font-size: 13px; color: #6b7280; font-weight: 500; }
        .info-value { font-size: 16px; color: #111; font-weight: 600; } /* Text value diperbesar */
        .full-width { grid-column: span 2; }

        .reason-box {
            background: #f9fafb; padding: 16px 20px; border-radius: 10px;
            border: 1px solid #e5e7eb; font-size: 15px; color: #374151; line-height: 1.6;
        }

        .file-badge {
            display: inline-flex; align-items: center; gap: 10px;
            background: #fff; border: 1px solid var(--border);
            padding: 10px 16px; border-radius: 10px;
            text-decoration: none; color: var(--text-main);
            font-size: 14px; font-weight: 500; transition: all 0.2s; cursor: pointer;
        }
        .file-badge:hover { border-color: var(--primary); background: #fff5f5; }
        .file-badge i { color: #e11d48; font-size: 16px; }

        .modal-footer {
            background: #f9fafb; padding: 20px 40px;
            border-top: 1px solid var(--border); display: flex; justify-content: flex-end; gap: 12px;
        }
        .btn-modal {
            padding: 12px 24px; border-radius: 8px; font-size: 14px; font-weight: 600;
            cursor: pointer; border: 1px solid var(--border); background: white; color: var(--text-main);
        }
        .btn-modal:hover { background: #f3f4f6; }
        
        /* Tombol Edit/Link Style */
        .btn-edit { 
            background: var(--primary); 
            color: white; 
            border: none; 
            display: none; 
            align-items: center; 
            justify-content: center;
            gap: 10px;
            text-decoration: none; 
        }
        .btn-edit:hover { background: #7a1212; color: white; }

        /* Responsive */
        @media (max-width: 768px) {
            .topbar { padding: 0 20px; }
            .container { padding: 0 20px; margin: 30px auto; }
            .card { flex-direction: column; align-items: flex-start; gap: 20px; padding: 25px; }
            .card-right { width: 100%; flex-direction: row; justify-content: space-between; align-items: center; }
            .info-grid { grid-template-columns: 1fr; }
            .full-width { grid-column: span 1; }
            .modal-box { width: 95%; }
        }
    </style>
</head>
<body>

    <div class="topbar">
        <div class="header-left">
            <a href="{{ url('/dashboarduser') }}" class="back-btn">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <div class="page-title">
                <i class="fa-solid fa-folder-open"></i> Riwayat Cuti
            </div>
        </div>
    </div>

    <div class="container">
        
        <div class="filter-section">
            <div class="filter-label"><i class="fa-solid fa-filter"></i> Filter Status</div>
            <div class="filter-buttons">
                <button class="filter-btn active" onclick="filterList('all', this)">Semua</button>
                <button class="filter-btn" onclick="filterList('approved', this)">Disetujui</button>
                <button class="filter-btn" onclick="filterList('pending', this)">Tertunda</button>
                <button class="filter-btn" onclick="filterList('rejected', this)">Ditolak</button>
            </div>
        </div>

        <div class="history-list">

            <div class="card" data-status="approved">
                <div class="card-left">
                    <div class="status-icon-circle st-ok"><i class="fa-solid fa-check"></i></div>
                    <div class="card-info">
                        <h4>Cuti Tahunan</h4>
                        <div class="card-date"><i class="fa-regular fa-calendar"></i> 10 Feb 2026 - 12 Feb 2026</div>
                    </div>
                </div>
                <div class="card-right">
                    <span class="duration-badge">3 Hari</span>
                    <button class="btn-detail-sm" onclick="openModal(this)"
                        data-details='{"id":"CT-260201", "status":"approved", "jenis":"Cuti Tahunan", "tanggal":"10 Feb 2026 - 12 Feb 2026", "durasi":"3 Hari", "alasan":"Acara keluarga di Surabaya.", "catatan":"", "lampiran":"Surat_Izin_Cuti.pdf"}'>
                        Lihat Detail
                    </button>
                </div>
            </div>

            <div class="card" data-status="pending">
                <div class="card-left">
                    <div class="status-icon-circle st-pen"><i class="fa-solid fa-clock"></i></div>
                    <div class="card-info">
                        <h4>Cuti Alasan Penting</h4>
                        <div class="card-date"><i class="fa-regular fa-calendar"></i> 15 Mar 2026 - 20 Mar 2026</div>
                    </div>
                </div>
                <div class="card-right">
                    <span class="duration-badge">6 Hari</span>
                    <button class="btn-detail-sm" onclick="openModal(this)"
                        data-details='{"id":"CAP-260305", "status":"pending", "jenis":"Cuti Alasan Penting", "tanggal":"15 Mar 2026 - 20 Mar 2026", "durasi":"6 Hari", "alasan":"Mengurus administrasi pendaftaran sekolah anak.", "catatan":"", "lampiran":"Undangan_Sekolah.pdf"}'>
                        Lihat Detail
                    </button>
                </div>
            </div>

            <div class="card" data-status="rejected">
                <div class="card-left">
                    <div class="status-icon-circle st-rej"><i class="fa-solid fa-xmark"></i></div>
                    <div class="card-info">
                        <h4>Cuti Sakit</h4>
                        <div class="card-date"><i class="fa-regular fa-calendar"></i> 25 Jan 2026 - 27 Jan 2026</div>
                    </div>
                </div>
                <div class="card-right">
                    <span class="duration-badge">3 Hari</span>
                    <button class="btn-detail-sm" onclick="openModal(this)"
                        data-details='{"id":"CS-260125", "status":"rejected", "jenis":"Cuti Sakit", "tanggal":"25 Jan 2026 - 27 Jan 2026", "durasi":"3 Hari", "alasan":"Demam tinggi dan flu berat.", "catatan":"Dokumen keterangan sakit tidak valid.", "lampiran":"Surat_Sakit_Dr.jpg"}'>
                        Lihat Detail
                    </button>
                </div>
            </div>

        </div> <div style="text-align: center; margin-top: 60px; color: #999; font-size: 13px;">
            SIIPUL © 2026 | Badan Kepegawaian Daerah
        </div>

    </div>

    <div class="modal-overlay" id="detailModal">
        <div class="modal-box">
            
            <div class="modal-header">
                <h4 class="modal-title">Rincian Pengajuan</h4>
                <button class="modal-close" onclick="closeModal()">×</button>
            </div>
    
            <div id="statusHero" class="status-hero">
                <i id="heroIcon" class="fa-solid fa-circle-check hero-icon"></i>
                <div>
                    <div id="heroTitle" class="hero-title">Disetujui</div>
                    <div id="heroDesc" class="hero-desc">Pengajuan Anda telah disetujui.</div>
                </div>
            </div>
    
            <div class="modalBody">
                
                <div class="info-group-title">Informasi Tiket</div>
                <div class="info-grid">
                    <div class="info-item">
                        <span class="info-label">ID Pengajuan</span>
                        <span class="info-value" id="m_id">#CT-0000</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Jenis Cuti</span>
                        <span class="info-value" id="m_jenis">-</span>
                    </div>
                    <div class="info-item full-width">
                        <span class="info-label">Tanggal Pelaksanaan</span>
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <span class="info-value" id="m_tanggal">-</span>
                            <span style="background:#eee; padding:3px 10px; border-radius:6px; font-size:12px; font-weight:600;" id="m_durasi">0 Hari</span>
                        </div>
                    </div>
                </div>
    
                <div class="info-group-title">Detail Kebutuhan</div>
                <div class="info-grid">
                    <div class="info-item full-width">
                        <span class="info-label" style="margin-bottom:6px;">Alasan Cuti</span>
                        <div class="reason-box" id="m_alasan">
                            -
                        </div>
                    </div>
    
                    <div class="info-item full-width" id="lampiranSection" style="display:none;">
                        <span class="info-label" style="margin-bottom:6px;">Dokumen Pendukung</span>
                        <div>
                            <div class="file-badge">
                                <i class="fa-solid fa-file-pdf"></i>
                                <span id="m_lampiran_name">dokumen.pdf</span>
                            </div>
                        </div>
                    </div>
                </div>
    
            </div>
    
            <div class="modal-footer">
                <button class="btn-modal" onclick="closeModal()">Tutup</button>
                
                <a href="{{ route('cuti.create') }}" id="btnEdit" class="btn-modal btn-edit">
                    <i class="fa-solid fa-pen-to-square"></i> Perbaiki Pengajuan
                </a>
            </div>
        </div>
    </div>


    <script>
        // --- 1. FILTER FUNCTION ---
        function filterList(status, btn) {
            document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            const cards = document.querySelectorAll('.card');
            cards.forEach(card => {
                if (status === 'all' || card.getAttribute('data-status') === status) {
                    card.style.display = 'flex';
                } else {
                    card.style.display = 'none';
                }
            });
        }

        // --- 2. MODAL FUNCTION ---
        function openModal(btn) {
            const data = JSON.parse(btn.getAttribute('data-details'));

            // Populate Text Data
            document.getElementById('m_id').textContent = '#' + data.id;
            document.getElementById('m_jenis').textContent = data.jenis;
            document.getElementById('m_tanggal').textContent = data.tanggal;
            document.getElementById('m_durasi').textContent = data.durasi;
            document.getElementById('m_alasan').textContent = data.alasan;

            // Handle Hero Section Styles
            const heroBox = document.getElementById('statusHero');
            const heroIcon = document.getElementById('heroIcon');
            const heroTitle = document.getElementById('heroTitle');
            const heroDesc = document.getElementById('heroDesc');
            
            // Ambil element link edit
            const btnEdit = document.getElementById('btnEdit');

            // Reset class lama
            heroBox.className = 'status-hero'; 
            
            // Default: Sembunyikan Link Edit
            btnEdit.style.display = 'none'; 

            // Switch Logic based on Status
            if (data.status === 'approved') {
                heroBox.classList.add('hero-approved');
                heroIcon.className = 'fa-solid fa-circle-check hero-icon';
                heroTitle.textContent = 'Permohonan Disetujui';
                heroDesc.textContent = data.catatan || 'Surat izin cuti telah diterbitkan.';
            } 
            else if (data.status === 'pending') {
                heroBox.classList.add('hero-pending');
                heroIcon.className = 'fa-solid fa-hourglass-half hero-icon';
                heroTitle.textContent = 'Menunggu Konfirmasi';
                heroDesc.textContent = data.catatan || 'Menunggu persetujuan atasan.';
            } 
            else if (data.status === 'rejected') {
                heroBox.classList.add('hero-rejected');
                heroIcon.className = 'fa-solid fa-circle-xmark hero-icon';
                heroTitle.textContent = 'Permohonan Ditolak';
                
                const rejectionNote = data.catatan || 'Berkas pengajuan belum lengkap.';
                heroDesc.innerHTML = `<span style="font-weight:700; color:#b91c1c;">Alasan:</span> ${rejectionNote}`;
                
                // Tampilkan tombol edit
                btnEdit.style.display = 'inline-flex';
            }

            // Handle Lampiran (Tampilkan untuk semua status)
            const lampiranSec = document.getElementById('lampiranSection');
            if(data.lampiran && data.lampiran !== "") {
                lampiranSec.style.display = 'block';
                document.getElementById('m_lampiran_name').textContent = data.lampiran;
            } else {
                lampiranSec.style.display = 'none';
            }

            // Show Modal
            document.getElementById('detailModal').classList.add('show');
            document.body.style.overflow = 'hidden'; 
        }

        function closeModal() {
            document.getElementById('detailModal').classList.remove('show');
            document.body.style.overflow = ''; 
        }

        window.onclick = function(event) {
            const modal = document.getElementById('detailModal');
            if (event.target === modal) { closeModal(); }
        }
    </script>
</body>
</html>