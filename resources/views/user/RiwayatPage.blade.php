<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Riwayat Pengajuan Cuti</title>

  <style>
    /* --- 1. CSS VARIABLES & RESET (SAMA PERSIS DENGAN DASHBOARD) --- */
    :root{
      --primary:#8b1515; /* Merah Marun */
      --bg:#f3f5fb;
      --card:#ffffff;
      --border:#e6e8ef;
      --text:#111827;
      --muted:#6b7280;
      --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);

      --ok:#1f7a46;   --ok-bg: #dcfce7; 
      --pen:#b45309;  --pen-bg: #fef3c7; 
      --rej:#b91c1c;  --rej-bg: #fee2e2; 

      --blueSoft:#eef3ff; --blueBorder:#cfdcff;
      --greenSoft:#e9f8ef; --greenBorder:#c7edd6;
    }

    *{ box-sizing:border-box; }
    body{
      margin:0;
      font-family: Inter, system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif;
      background:var(--bg);
      color:var(--text);
      font-size: 15px; 
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }

    /* --- TOPBAR --- */
    .topbar{
      height:70px;
      background:var(--primary);
      color:#fff;
      display:flex;
      align-items:center;
      justify-content:space-between;
      padding:0 32px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
      position: sticky; top: 0; z-index: 50;
    }
    .header-left { display: flex; align-items: center; gap: 20px; }
    .back-btn { font-size: 18px; color: white; opacity: 0.9; transition: 0.2s; }
    .back-btn:hover { opacity: 1; transform: translateX(-3px); }
    .page-title { font-size: 18px; font-weight: 700; letter-spacing: 0.5px; display: flex; align-items: center; gap: 12px; }

    /* --- CONTAINER --- */
    .container{ max-width:1000px; width: 95%; margin:30px auto; padding:0 20px 30px; flex: 1; }
    
    /* Filter Section */
    .filter-section { margin-bottom: 30px; }
    .filter-label { font-size: 13px; font-weight: 700; color: var(--muted); margin-bottom: 12px; text-transform: uppercase; letter-spacing: 0.5px; }
    .filter-buttons { display: flex; gap: 10px; flex-wrap: wrap; }
    .filter-btn {
        border: 1px solid var(--border); background: white;
        padding: 8px 20px; border-radius: 99px;
        font-size: 14px; font-weight: 500; color: var(--muted);
        cursor: pointer; transition: all 0.2s;
    }
    .filter-btn:hover { background: #f9fafb; }
    .filter-btn.active { 
        background: var(--primary); color: white; border-color: var(--primary); 
        box-shadow: 0 4px 6px rgba(139, 21, 21, 0.2);
    }

    /* --- HISTORY CARD STYLES (SAMA DENGAN DASHBOARD) --- */
    .history-list-container { display: flex; flex-direction: column; gap: 16px; }

    .h-card {
        background: #fff;
        border-radius: 16px;
        padding: 20px 24px;
        display: flex; align-items: center; justify-content: space-between;
        border: 1px solid var(--border);
        box-shadow: 0 2px 4px rgba(0,0,0,0.03);
        transition: transform 0.2s, box-shadow 0.2s;
        position: relative;
    }
    .h-card:hover { transform: translateY(-3px); box-shadow: 0 12px 20px -5px rgba(0,0,0,0.08); }

    /* Status Border Colors */
    .h-card[data-status="approved"] { border-left: 6px solid var(--ok); }
    .h-card[data-status="pending"]  { border-left: 6px solid var(--pen); }
    .h-card[data-status="rejected"] { border-left: 6px solid var(--rej); }

    .hc-left { display: flex; align-items: center; gap: 20px; }
    
    .st-icon-circle {
        width: 48px; height: 48px;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 20px; flex-shrink: 0;
    }
    .st-ok { background: var(--ok-bg); color: var(--ok); }
    .st-pen { background: var(--pen-bg); color: var(--pen); }
    .st-rej { background: var(--rej-bg); color: var(--rej); }

    .hc-info h4 { font-size: 16px; font-weight: 700; color: #111; margin: 0 0 6px 0; }
    .hc-date { font-size: 13px; color: #555; display: flex; align-items: center; gap: 8px; }

    .hc-right { text-align: right; display: flex; flex-direction: column; align-items: flex-end; gap: 10px; }
    
    .duration-badge { 
        font-size: 12px; font-weight: 600; background: #f3f4f6; 
        padding: 6px 14px; border-radius: 8px; color: #374151; 
    }

    .btn-detail-sm {
        font-size: 12px; font-weight: 600; color: var(--primary);
        background: transparent; border: 1.5px solid var(--primary);
        padding: 6px 16px; border-radius: 8px; cursor: pointer; transition: 0.2s;
    }
    .btn-detail-sm:hover { background: var(--primary); color: white; }

    /* ========================================================== */
    /* MODAL FIX: AGAR BISA SCROLL (SAMA DENGAN DASHBOARD)        */
    /* ========================================================== */
    .modalOverlay{
      position:fixed; inset:0; background:rgba(0,0,0,.6); display:none; align-items:center; justify-content:center; z-index:9999; padding:20px; backdrop-filter: blur(2px); 
    }
    .modalOverlay.open{ display:flex; }
    
    .modal{
      width:100%; 
      max-width:850px; 
      background:#fff; 
      border-radius:16px; 
      overflow:hidden; 
      box-shadow:0 20px 50px rgba(0,0,0,.25); 
      border:1px solid rgba(0,0,0,.08); 
      animation: slideUp 0.3s ease-out;
      display: flex;
      flex-direction: column;
      max-height: 90vh; 
    }
    @keyframes slideUp { from { transform: translateY(20px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
    
    .modalHead{ 
      padding:18px 24px; 
      border-bottom:1px solid var(--border); 
      display:flex; align-items:center; justify-content:space-between; 
      background: #f9fafb;
      flex-shrink: 0; 
    }
    .modalHead h4{ margin:0; font-size:18px; font-weight:700; color: var(--text); }
    .xbtn{ width:36px; height:36px; border-radius:10px; border:1px solid var(--border); background:#fff; cursor:pointer; font-size:20px; display: flex; align-items: center; justify-content: center; color: #666; }
    
    .modalBody{ 
      padding:24px; 
      overflow-y: auto; 
      flex: 1; 
    }
    
    .formGrid{ display:grid; grid-template-columns:1fr 1fr; gap:16px; }
    .field{ display:flex; flex-direction:column; gap:8px; }
    .field label{ font-size:13px; font-weight:700; color:#374151; }
    .field input, .field select, .field textarea{ border:1px solid var(--border); border-radius:8px; padding:12px 14px; font-size:14px; outline:none; background:#fff; transition: border-color 0.2s; }
    .field textarea{ min-height:100px; resize:vertical; }
    .full{ grid-column:1/-1; }
    
    .modalActions{ 
      border-top:1px solid var(--border); 
      padding:16px 24px; 
      display:flex; justify-content:flex-end; gap:12px; 
      background: #f9fafb; 
      flex-shrink: 0; 
    }
    .btn2{ border-radius:8px; padding:12px 20px; cursor:pointer; font-weight:700; border:1px solid var(--border); background:#fff; font-size: 14px; }
    
    /* Tombol Perbaiki Pengajuan (Link) */
    .btn-edit-link {
        background: var(--primary); color: white;
        border: none; text-decoration: none; display: none; /* Hidden by default */
        align-items: center; gap: 8px;
    }
    .btn-edit-link:hover { background: #711010; }

    /* Drag Drop */
    .drop-area { border: 2px dashed var(--border); border-radius: 12px; padding: 24px; text-align: center; background: #fafafa; cursor: pointer; transition: all 0.2s; }
    .drop-icon { font-size: 32px; margin-bottom: 8px; display: block; opacity: 0.5; }

    @media (max-width: 980px){ 
        .container, .topbar{ padding: 0 16px; width: 100%; } 
        .h-card{ flex-direction: column; gap: 20px; align-items: flex-start; }
        .hc-right { width: 100%; flex-direction: row; justify-content: space-between; align-items: center; }
        .formGrid{ grid-template-columns:1fr; } 
    }

  </style>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
  
  <div class="topbar">
    <div class="header-left">
        <a href="{{ route('user.dashboard') }}" class="back-btn">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <div class="page-title">
            <i class="fa-solid fa-folder-open"></i> &nbsp;Riwayat Cuti
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

    <div class="history-list-container">
        
        <div class="h-card" data-status="approved">
            <div class="hc-left">
                <div class="st-icon-circle st-ok"><i class="fa-solid fa-check"></i></div>
                <div class="hc-info">
                    <h4>Cuti Tahunan</h4>
                    <div class="hc-date"><i class="fa-regular fa-calendar"></i> 2026-02-10 s/d 2026-02-12</div>
                </div>
            </div>
            <div class="hc-right">
                <span class="duration-badge">3 Hari</span>
                <button class="btn-detail-sm" onclick="openModal(this)" data-leave='{
                    "id":"CT-2026-0001",
                    "status":"Diterima",
                    "jenis":"Cuti Tahunan",
                    "mulai":"2026-02-10",
                    "selesai":"2026-02-12",
                    "alamat":"Semarang",
                    "kontak":"0812xxxxxxx",
                    "alasan":"Keperluan Keluarga",
                    "lampiran":"Formulir_Cuti.pdf",
                    "catatan":"Disetujui"
                }'>Lihat Detail</button>
            </div>
        </div>

        <div class="h-card" data-status="rejected">
            <div class="hc-left">
                <div class="st-icon-circle st-rej"><i class="fa-solid fa-xmark"></i></div>
                <div class="hc-info">
                    <h4>Cuti Sakit</h4>
                    <div class="hc-date"><i class="fa-regular fa-calendar"></i> 2026-01-25 s/d 2026-01-27</div>
                </div>
            </div>
            <div class="hc-right">
                <span class="duration-badge">3 Hari</span>
                <button class="btn-detail-sm" onclick="openModal(this)" data-leave='{
                    "id":"CS-2026-0002",
                    "status":"Ditolak",
                    "jenis":"Cuti Sakit",
                    "mulai":"2026-01-25",
                    "selesai":"2026-01-27",
                    "alamat":"Semarang",
                    "kontak":"0812xxxxxxx",
                    "alasan":"Sakit Demam Tinggi",
                    "lampiran":"surat_dokter_lama.pdf",
                    "catatan":"Mohon lampirkan surat dokter yang valid (Cap RS kurang jelas)"
                }'>Lihat Detail</button>
            </div>
        </div>

        <div class="h-card" data-status="pending">
            <div class="hc-left">
                <div class="st-icon-circle st-pen"><i class="fa-solid fa-clock"></i></div>
                <div class="hc-info">
                    <h4>Cuti Tahunan</h4>
                    <div class="hc-date"><i class="fa-regular fa-calendar"></i> 2026-03-15 s/d 2026-03-20</div>
                </div>
            </div>
            <div class="hc-right">
                <span class="duration-badge">6 Hari</span>
                <button class="btn-detail-sm" onclick="openModal(this)" data-leave='{
                    "id":"CT-2026-0003",
                    "status":"Diproses",
                    "jenis":"Cuti Tahunan",
                    "mulai":"2026-03-15",
                    "selesai":"2026-03-20",
                    "alamat":"Semarang",
                    "kontak":"0812xxxxxxx",
                    "alasan":"Urusan pribadi",
                    "lampiran":"Tiket.pdf",
                    "catatan":"-"
                }'>Lihat Detail</button>
            </div>
        </div>

    </div>

    <div style="text-align: center; margin-top: 60px; color: #999; font-size: 13px;">
        SIIPUL © 2026 | Disdikbudpora Kab Semarang
    </div>
  </div>

  <div class="modalOverlay" id="modal">
    <div class="modal">
      <div class="modalHead"><h4 id="modalTitle">Detail Pengajuan Cuti</h4><button class="xbtn" id="closeBtn">×</button></div>
      <div class="modalBody">
        <div id="statusAlert" style="margin-bottom:15px; padding:10px; border-radius:8px; font-size:13px; font-weight:700; display:none;"></div>
        <div class="formGrid">
          <div class="field"><label>ID Pengajuan</label><input id="f_id" type="text" readonly style="background:#f3f4f6; color:#6b7280;"/></div>
          <div class="field"><label>Status Saat Ini</label><input id="f_status" type="text" readonly style="font-weight:bold;"/></div>
          <div class="field"><label>Jenis Cuti</label><select id="f_jenis" disabled><option>Cuti Tahunan</option><option>Cuti Sakit</option><option>Cuti Besar</option><option>Cuti Melahirkan</option><option>Cuti Karena Alasan Penting</option></select></div>
          <div class="field"><label>Lampiran</label><div id="drop-area" class="drop-area disabled"><span class="drop-icon">📂</span><span class="drop-text" id="drop-text-label">Drag & drop file surat di sini</span><input type="file" id="f_lampiran_input" hidden accept=".pdf,.jpg,.jpeg,.png"><div id="file-name-display" class="file-name-display" style="margin-top:5px; font-weight:600; color:var(--primary);"></div></div><input type="hidden" id="f_lampiran_text"></div>
          <div class="field"><label>Tanggal Mulai</label><input id="f_mulai" type="date" readonly /></div>
          <div class="field"><label>Tanggal Selesai</label><input id="f_selesai" type="date" readonly /></div>
          <div class="field"><label>Alamat Selama Cuti</label><input id="f_alamat" type="text" readonly /></div>
          <div class="field"><label>No. Kontak</label><input id="f_kontak" type="text" readonly /></div>
          <div class="field full"><label>Alasan / Keterangan</label><textarea id="f_alasan" readonly></textarea></div>
          <div class="field full"><label>Catatan Admin</label><textarea id="f_catatan" readonly style="background:#fffbe6; border-color:#ffe58f;"></textarea></div>
        </div>
      </div>
      <div class="modalActions">
          <button class="btn2" id="cancelBtn">Tutup</button>
          
          <a href="{{ route('user.cuti.create') }}" id="btnEditLink" class="btn2 btn-edit-link">
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
        const cards = document.querySelectorAll('.h-card');
        cards.forEach(card => {
            if (status === 'all' || card.getAttribute('data-status') === status) {
                card.style.display = 'flex';
            } else {
                card.style.display = 'none';
            }
        });
    }

    // --- 2. MODAL LOGIC (COPIED EXACTLY FROM DASHBOARD) ---
    const modal = document.getElementById("modal");
    const closeBtn = document.getElementById("closeBtn");
    const cancelBtn = document.getElementById("cancelBtn");
    const modalTitle = document.getElementById("modalTitle");
    const statusAlert = document.getElementById("statusAlert");
    const dropArea = document.getElementById("drop-area");
    const fileInput = document.getElementById("f_lampiran_input");
    const fileNameDisplay = document.getElementById("file-name-display");
    const dropTextLabel = document.getElementById("drop-text-label");
    
    // Tombol di Footer Modal
    const btnEditLink = document.getElementById("btnEditLink");

    const f = { id: document.getElementById("f_id"), status: document.getElementById("f_status"), jenis: document.getElementById("f_jenis"), lampiranText: document.getElementById("f_lampiran_text"), mulai: document.getElementById("f_mulai"), selesai: document.getElementById("f_selesai"), alamat: document.getElementById("f_alamat"), kontak: document.getElementById("f_kontak"), alasan: document.getElementById("f_alasan"), catatan: document.getElementById("f_catatan") };
    let activeBtn = null; let activeData = null;

    function openModal(btn){ 
        activeBtn = btn; 
        activeData = JSON.parse(btn.getAttribute("data-leave") || "{}"); 
        
        // Populate Data
        f.id.value = activeData.id || ""; 
        f.status.value = activeData.status || ""; 
        f.jenis.value = activeData.jenis || "Cuti Tahunan"; 
        f.lampiranText.value = activeData.lampiran || ""; 
        f.mulai.value = activeData.mulai || ""; 
        f.selesai.value = activeData.selesai || ""; 
        f.alamat.value = activeData.alamat || ""; 
        f.kontak.value = activeData.kontak || ""; 
        f.alasan.value = activeData.alasan || ""; 
        f.catatan.value = activeData.catatan || ""; 
        fileInput.value = ""; 
        
        if(activeData.lampiran && activeData.lampiran !== "-"){ 
            fileNameDisplay.innerHTML = `📎 ${activeData.lampiran}`; 
            dropTextLabel.textContent = "File saat ini:"; 
        } else { 
            fileNameDisplay.innerHTML = ""; 
            dropTextLabel.textContent = "Tidak ada lampiran."; 
        } 
        
        configureViewMode(activeData.status); 
        modal.classList.add("open"); 
        document.body.style.overflow = "hidden"; 
    }

    function configureViewMode(status) { 
        // Semua input read-only karena ini detail view
        const inputs = [f.jenis, f.mulai, f.selesai, f.alamat, f.kontak, f.alasan];
        inputs.forEach(inp => inp.disabled = true); 
        dropArea.classList.add('disabled'); 
        fileInput.disabled = true; 
        
        // Default: Sembunyikan tombol edit
        btnEditLink.style.display = 'none';

        if (status === "Ditolak") { 
            modalTitle.textContent = "Detail Pengajuan (Ditolak)"; 
            f.status.style.color = "#b42318"; 
            statusAlert.style.display = "block"; 
            statusAlert.style.background = "#fde9ea"; 
            statusAlert.style.color = "#b42318"; 
            statusAlert.textContent = "Pengajuan ini ditolak. Silakan perbaiki data.";
            
            // TAMPILKAN TOMBOL PERBAIKI (Link)
            btnEditLink.style.display = 'inline-flex';

        } else if(status === "Diterima") { 
            modalTitle.textContent = "Detail Pengajuan"; 
            f.status.style.color = "#1f7a46"; 
            statusAlert.style.display = "block"; 
            statusAlert.style.background = "#e8f6ee"; 
            statusAlert.style.color = "#1f7a46"; 
            statusAlert.textContent = "Pengajuan ini telah disetujui."; 
        } else { 
            modalTitle.textContent = "Detail Pengajuan"; 
            f.status.style.color = "#a56a00"; 
            statusAlert.style.display = "block"; 
            statusAlert.style.background = "#fff2df"; 
            statusAlert.style.color = "#a56a00"; 
            statusAlert.textContent = "Pengajuan sedang dalam proses verifikasi."; 
        } 
    }

    function closeModal(){ modal.classList.remove("open"); document.body.style.overflow = ""; }
    
    document.querySelectorAll(".btn-detail-sm").forEach(btn => btn.addEventListener("click", ()=> openModal(btn))); 
    closeBtn.addEventListener("click", closeModal); 
    cancelBtn.addEventListener("click", closeModal); 
    window.onclick = function(event) { if (event.target === modal) { closeModal(); } }
  </script>
</body>
</html>