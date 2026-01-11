<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>SIIPUL Dashboard - User</title>

  <style>
    /* --- CSS VARIABLES & RESET --- */
    :root{
      --primary:#8b1515; /* Merah Marun */
      --bg:#f3f5fb;
      --card:#ffffff;
      --border:#e6e8ef;
      --text:#111827;
      --muted:#6b7280;
      --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);

      --ok:#1f7a46;   --okSoft:#e8f6ee;  
      --rej:#b42318;  --rejSoft:#fde9ea; 
      --pen:#a56a00;  --penSoft:#fff2df; 

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
      position: relative; /* Penting untuk dropdown */
      z-index: 50;
    }
    .brand{
      display:flex; align-items:center; gap:16px;
      font-weight:700;
      letter-spacing:.5px;
      font-size: 20px;
    }
    .brand img {
      height: 45px;
      width: auto;
      object-fit: contain;
      filter: drop-shadow(0 2px 4px rgba(0,0,0,0.2));
    }

    /* User Chip (Tombol Profil) */
    .userchip{
      display:flex; align-items:center; gap:12px;
      background:#fff;
      color: var(--text);
      padding:6px 8px 6px 16px;
      border-radius:999px;
      min-width:220px;
      justify-content:space-between;
      cursor: pointer;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
      text-decoration: none;
      user-select: none;
      transition: background 0.2s;
    }
    .userchip:hover { background: #f9fafb; }
    .userleft{ display:flex; align-items:center; gap:12px; text-align: right;}
    .avatar{
      width:38px; height:38px; border-radius:999px;
      background:var(--primary); color:#fff;
      display:flex; align-items:center; justify-content:center;
      font-weight:600; font-size:14px;
    }
    .uname{ font-weight:700; font-size:14px; line-height:1.2; }
    .urole{ font-size:12px; color:var(--muted); line-height:1.2; }

    /* --- DROPDOWN MENU (BARU) --- */
    .dropdown-menu {
        position: absolute;
        top: 80px; /* Jarak dari atas */
        right: 32px; /* Jarak dari kanan */
        width: 320px;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        border: 1px solid #e5e7eb;
        display: none; /* Hidden by default */
        flex-direction: column;
        overflow: hidden;
        animation: fadeIn 0.2s ease-out;
    }
    .dropdown-menu.show { display: flex; }
    
    @keyframes fadeIn { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }

    .dd-header {
        padding: 20px;
        border-bottom: 1px solid #f3f4f6;
        display: flex;
        align-items: center;
        gap: 16px;
    }
    .dd-avatar-lg {
        width: 48px; height: 48px;
        background: var(--primary);
        color: white;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-weight: 700; font-size: 18px;
    }
    .dd-info-sec {
        padding: 20px;
        border-bottom: 1px solid #f3f4f6;
    }
    .dd-label { font-size: 11px; color: #9ca3af; font-weight: 700; margin-bottom: 4px; text-transform: uppercase; }
    .dd-value { font-size: 14px; color: #111827; font-weight: 600; margin-bottom: 12px; }
    .dd-value:last-child { margin-bottom: 0; }

    .dd-links { padding: 8px 0; }
    .dd-item {
        display: flex; align-items: center; gap: 12px;
        padding: 12px 24px;
        color: #4b5563;
        text-decoration: none;
        font-size: 14px;
        font-weight: 500;
        transition: all 0.2s;
    }
    .dd-item:hover { background: #f9fafb; color: var(--primary); }
    .dd-item i { width: 18px; text-align: center; }
    
    .dd-logout {
        border-top: 1px solid #f3f4f6;
        color: #ef4444 !important;
    }
    .dd-logout:hover { background: #fef2f2; }


    /* --- CONTAINER --- */
    .container{
      max-width:1400px;
      width: 95%;
      margin:30px auto;
      padding:0 20px 30px;
      flex: 1; 
    }
    .welcome{
      font-size:32px;
      font-weight:700;
      margin:10px 0 30px;
      color: #111827;
    }

    /* --- STATS CARDS --- */
    .stats{
      display:grid;
      grid-template-columns:repeat(3, 1fr);
      gap:24px;
      margin-bottom:30px;
    }
    .stat{
      background:var(--card);
      border:1px solid #fff;
      border-radius:12px;
      box-shadow:var(--shadow);
      padding:24px;
      min-height:120px;
      display:flex;
      justify-content:space-between;
      align-items:flex-start;
      transition: transform 0.2s;
    }
    .stat:hover{ transform: translateY(-2px); }
    .slabel{ font-size:14px; font-weight:600; color:#6b7280; }
    .svalue{ font-size:36px; font-weight:700; margin-top:12px; line-height: 1; }
    .ssub{ font-size:13px; color:var(--muted); margin-top:8px; }
    .sicon{ font-size: 20px; opacity: 0.8; }

    /* --- MAIN GRID --- */
    .grid{
      display:grid;
      grid-template-columns: 350px 1fr;
      gap:30px;
      align-items:start;
    }
    .card{
      background:var(--card);
      border:1px solid #fff;
      border-radius:12px;
      box-shadow:var(--shadow);
      padding:24px;
    }
    .card h3{
      margin:0 0 20px;
      font-size:16px;
      font-weight:700;
      color:#374151;
    }

    /* Buttons */
    .btn{
      width:100%;
      border-radius:8px;
      padding:14px 16px;
      border:1px solid var(--border);
      background:#fff;
      cursor:pointer;
      font-weight:600;
      display:flex;
      align-items:center;
      justify-content:center;
      gap:10px;
      font-size: 14px;
      transition: all 0.2s;
      box-shadow: 0 1px 2px rgba(0,0,0,0.05);
      text-decoration: none; /* For anchor tags */
      color: var(--text);
    }
    .btn:hover{ transform: translateY(-1px); box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
    .btn-primary{
      border:none;
      background:var(--primary);
      color:#fff;
    }
    .btn-primary:hover{ background: #711010; }
    .btn + .btn{ margin-top:16px; }

    /* Donut Chart */
    .donut-wrap{ display:flex; gap:20px; align-items:center; justify-content: center; padding: 10px 0;}
    .donut{
      width:150px; height:150px;
      border-radius:50%;
      background: conic-gradient(#22c55e 0 82%, #f59e0b 82% 88%, #ef4444 88% 100%);
      position:relative;
    }
    .donut::after{
      content:"";
      position:absolute;
      inset:30px;
      background:#fff;
      border-radius:50%;
    }
    .legend{
      display:flex;
      flex-direction:column;
      gap:12px;
      font-size:13px;
      color:#374151;
      font-weight:600;
    }
    .lg{ display:flex; align-items:center; gap:8px; }
    .dot{ width:12px; height:12px; border-radius:4px; }
    .dot.ok{ background:#22c55e; }
    .dot.pen{ background:#f59e0b; }
    .dot.rej{ background:#ef4444; }

    /* History Items */
    .history-item{
      border:1px solid transparent;
      border-radius:8px;
      padding:16px 20px;
      display:flex;
      align-items:flex-start;
      justify-content:space-between;
      gap:16px;
      margin-bottom:16px;
    }
    .history-item:last-child{ margin-bottom:0; }
    .history-item.ok{ background:var(--okSoft); }
    .history-item.rej{ background:var(--rejSoft); }
    .history-item.pen{ background:var(--penSoft); }

    .h-left{ display:flex; gap:16px; align-items:flex-start; }
    .h-ico{
      width:24px; height:24px;
      border-radius:999px;
      display:flex; align-items:center; justify-content:center;
      font-weight:bold;
      font-size:14px;
      flex:0 0 auto;
      margin-top:2px;
      background:rgba(255,255,255,0.5);
    }
    .h-ico.ok{ color:var(--ok); border: 2px solid var(--ok); }
    .h-ico.rej{ color:var(--rej); border: 2px solid var(--rej); }
    .h-ico.pen{ color:var(--pen); border: 2px solid var(--pen); }
    
    .h-meta b{ display:block; font-size:15px; font-weight:700; color: #111; }
    .h-meta small{ display:block; margin-top:6px; color:#555; font-weight:500; font-size:13px; }

    .h-right{ display:flex; flex-direction:column; align-items:flex-end; gap:10px; min-width:140px; }
    .status{ font-size:12px; font-weight:700; margin-top:2px; }
    .status.ok{ color:var(--ok); }
    .status.rej{ color:var(--rej); }
    .status.pen{ color:var(--pen); }

    .btn-detail{
      border:none;
      background:rgba(255,255,255,0.6);
      color:#555;
      font-weight:600;
      font-size:12px;
      padding:6px 12px;
      border: 1px solid rgba(0,0,0,0.1);
      border-radius:6px;
      cursor:pointer;
      transition: all 0.2s;
    }
    .btn-detail:hover{ background: #fff; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }

    .seeall{ text-align:center; margin-top:24px; font-weight:600; color:var(--primary); font-size:14px; cursor: pointer; }
    .seeall:hover{ text-decoration: underline; }

    /* Bottom Info */
    .bottom{ display:grid; grid-template-columns:1fr 1fr; gap:30px; margin-top:30px; }
    .infoBox{ background:var(--blueSoft); border:1px solid var(--blueBorder); border-radius:12px; padding:24px; }
    .helpBox{ background:var(--greenSoft); border:1px solid var(--greenBorder); border-radius:12px; padding:24px; }
    .boxTitle{ display:flex; align-items:center; gap:10px; font-weight:700; margin-bottom:12px; font-size:16px; color:#1f2937; }
    .boxText{ font-size:14px; color:#374151; line-height:1.6; }

    /* Footer */
    .main-footer { background: var(--primary); color: rgba(255,255,255,0.8); text-align: center; padding: 16px; font-size: 13px; margin-top: 40px; }

    /* --- MODAL --- */
    .modalOverlay{
      position:fixed; inset:0;
      background:rgba(0,0,0,.6);
      display:none;
      align-items:center;
      justify-content:center;
      z-index:9999;
      padding:20px;
      backdrop-filter: blur(2px);
    }
    .modalOverlay.open{ display:flex; }
    .modal{
      width:100%; max-width:850px;
      background:#fff; border-radius:16px;
      overflow:hidden; box-shadow:0 20px 50px rgba(0,0,0,.25);
      border:1px solid rgba(0,0,0,.08);
      animation: slideUp 0.3s ease-out;
    }
    @keyframes slideUp { from { transform: translateY(20px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
    
    .modalHead{ padding:18px 24px; border-bottom:1px solid var(--border); display:flex; align-items:center; justify-content:space-between; background: #f9fafb; }
    .modalHead h4{ margin:0; font-size:18px; font-weight:700; color: var(--text); }
    .xbtn{ width:36px; height:36px; border-radius:10px; border:1px solid var(--border); background:#fff; cursor:pointer; font-size:20px; display: flex; align-items: center; justify-content: center; color: #666; }
    .xbtn:hover{ background: #f3f4f6; color: #000; }
    
    .modalBody{ padding:24px; }
    .formGrid{ display:grid; grid-template-columns:1fr 1fr; gap:16px; }
    .field{ display:flex; flex-direction:column; gap:8px; }
    .field label{ font-size:13px; font-weight:700; color:#374151; }
    .field input, .field select, .field textarea{
      border:1px solid var(--border); border-radius:8px; padding:12px 14px; font-size:14px; outline:none; background:#fff; transition: border-color 0.2s;
    }
    .field input:focus, .field select:focus, .field textarea:focus{ border-color: var(--primary); box-shadow: 0 0 0 3px rgba(139, 21, 21, 0.1); }
    .field input:disabled, .field select:disabled, .field textarea:disabled{ background-color: #f3f4f6; color: #6b7280; cursor: not-allowed; }
    .field textarea{ min-height:100px; resize:vertical; }
    .full{ grid-column:1/-1; }

    /* Drag Drop Area */
    .drop-area {
      border: 2px dashed var(--border); border-radius: 12px; padding: 24px; text-align: center; background: #fafafa; cursor: pointer; transition: all 0.2s;
    }
    .drop-area:hover, .drop-area.highlight { border-color: var(--primary); background: #fff9f9; }
    .drop-area.disabled { cursor: not-allowed; opacity: 0.6; background: #f3f4f6; border-color: #e5e7eb; }
    .drop-icon { font-size: 32px; margin-bottom: 8px; display: block; opacity: 0.5; }
    .drop-text { font-size: 13px; color: #6b7280; font-weight: 600; }
    .file-name-display { margin-top: 10px; font-size: 13px; font-weight: 700; color: var(--primary); }

    .modalActions{ border-top:1px solid var(--border); padding:16px 24px; display:flex; justify-content:flex-end; gap:12px; background: #f9fafb; }
    .btn2{ border-radius:8px; padding:12px 20px; cursor:pointer; font-weight:700; border:1px solid var(--border); background:#fff; font-size: 14px; }
    .btnSave{ border:none; background:var(--primary); color:#fff; }
    .btnSave:hover{ background: #701111; }

    @media (max-width: 980px){
      .stats, .grid, .bottom, .formGrid{ grid-template-columns:1fr; }
      .container, .topbar{ padding: 0 16px; width: 100%; }
      .history-item{ flex-direction: column; }
    }
  </style>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
  <div class="topbar">
    <div class="brand">
      <img src="{{ asset('logokabupatensemarang.png') }}" alt="Logo Kab Semarang">
      <div>SIIPUL Dashboard</div>
    </div>

    <div onclick="toggleDropdown()" class="userchip" id="userMenuBtn">
      <div class="userleft">
        <div>
          <div class="uname">Budi Santoso</div>
          <div class="urole">Guru Matematika</div>
        </div>
        <i class="fa-solid fa-chevron-down" style="font-size:10px; color:#6b7280;"></i>
      </div>
      <div class="avatar">BS</div>
    </div>

    <div class="dropdown-menu" id="userDropdown">
        <div class="dd-header">
            <div class="dd-avatar-lg">BS</div>
            <div>
                <div class="uname" style="font-size:15px; color:#1f2937;">Budi Santoso</div>
                <div class="urole" style="font-size:12px;">Guru Matematika</div>
            </div>
        </div>

        <div class="dd-info-sec">
            <div class="dd-label">NIP</div>
            <div class="dd-value">197801011999121001</div>
            
            <div class="dd-label">Posisi</div>
            <div class="dd-value">Guru Matematika</div>
        </div>

        <div class="dd-links">
            <a href="{{ url('/profil') }}" class="dd-item">
                <i class="fa-regular fa-user"></i> Profil Saya
            </a>
            <a href="{{ url('/riwayat') }}" class="dd-item">
                <i class="fa-regular fa-file-lines"></i> Riwayat Cuti
            </a>
            <a href="{{ url('/') }}" class="dd-item dd-logout">
                <i class="fa-solid fa-arrow-right-from-bracket"></i> Logout
            </a>
        </div>
    </div>
  </div>

  <div class="container">
    <div class="welcome">Selamat Datang, &nbsp;Budi Santoso !</div>

    <div class="stats">
      <div class="stat">
        <div>
          <div class="slabel">Total Cuti</div>
          <div class="svalue" style="color:var(--primary);">12</div>
          <div class="ssub">hari cuti per tahun</div>
        </div>
        <div class="sicon">📅</div>
      </div>
      <div class="stat">
        <div>
          <div class="slabel">Cuti Digunakan</div>
          <div class="svalue" style="color:var(--ok);">4</div>
          <div class="ssub">dari 12 hari</div>
        </div>
        <div class="sicon" style="color:var(--ok)">✅</div>
      </div>
      <div class="stat">
        <div>
          <div class="slabel">Sisa Cuti</div>
          <div class="svalue" style="color:var(--rej);">8</div>
          <div class="ssub">hari tersisa</div>
        </div>
        <div class="sicon" style="color:var(--rej)">⏱️</div>
      </div>
    </div>

    <div class="grid">
      <div>
        <div class="card">
          <h3>Aksi Cepat</h3>
          <a href="{{ url('/pengajuan-cuti') }}" class="btn btn-primary">📝 &nbsp; Ajukan Cuti</a>
          <button class="btn">👤 &nbsp; Hubungi Kami</button>
        </div>

        <div class="card" style="margin-top:24px;">
          <h3>Status Pengajuan Batasan</h3>
          <div class="donut-wrap">
            <div class="donut"></div>
            <div class="legend">
              <div class="lg"><span class="dot ok"></span> Aman (82%)</div>
              <div class="lg"><span class="dot pen"></span> Kritis (6%)</div>
              <div class="lg"><span class="dot rej"></span> Habis (12%)</div>
            </div>
          </div>
        </div>
      </div>

      <div class="card history">
        <div class="head">
          <h3>Riwayat Permintaan Cuti</h3>
        </div>

        <div class="history-item ok" id="item-CT-2026-0001">
          <div class="h-left">
            <div class="h-ico ok">✓</div>
            <div class="h-meta">
              <b class="jenis">Cuti Tahunan</b>
              <small class="tgl">2026-02-10 s/d 2026-02-12</small>
              <small class="ket">3 Hari</small>
            </div>
          </div>
          <div class="h-right">
            <div class="status ok statusText">Diterima</div>
            <button class="btn-detail"
              data-leave='{"id":"CT-2026-0001","status":"Diterima","jenis":"Cuti Tahunan","mulai":"2026-02-10","selesai":"2026-02-12","alamat":"Semarang","kontak":"0812xxxxxxx","alasan":"Keperluan Keluarga","lampiran":"Formulir_Cuti.pdf","catatan":"Disetujui"}'
            >Lihat</button>
          </div>
        </div>

        <div class="history-item rej" id="item-CS-2026-0002">
          <div class="h-left">
            <div class="h-ico rej">✕</div>
            <div class="h-meta">
              <b class="jenis">Cuti Sakit</b>
              <small class="tgl">2026-01-25 s/d 2026-01-27</small>
              <small class="ket">3 Hari. Perlu Surat Dokter</small>
            </div>
          </div>
          <div class="h-right">
            <div class="status rej statusText">Ditolak</div>
            <button class="btn-detail" style="background:#fff; border-color:var(--rej);"
              data-leave='{"id":"CS-2026-0002","status":"Ditolak","jenis":"Cuti Sakit","mulai":"2026-01-25","selesai":"2026-01-27","alamat":"Semarang","kontak":"0812xxxxxxx","alasan":"Sakit","lampiran":"surat_dokter_lama.pdf","catatan":"Mohon lampirkan surat dokter yang valid"}'
            >✏️ Edit</button>
          </div>
        </div>

        <div class="history-item pen" id="item-CT-2026-0003">
          <div class="h-left">
            <div class="h-ico pen">!</div>
            <div class="h-meta">
              <b class="jenis">Cuti Tahunan</b>
              <small class="tgl">2026-03-15 s/d 2026-03-20</small>
              <small class="ket">6 Hari</small>
            </div>
          </div>
          <div class="h-right">
            <div class="status pen statusText">Ditinjau</div>
            <button class="btn-detail"
              data-leave='{"id":"CT-2026-0003","status":"Diproses","jenis":"Cuti Tahunan","mulai":"2026-03-15","selesai":"2026-03-20","alamat":"Semarang","kontak":"0812xxxxxxx","alasan":"Urusan pribadi","lampiran":"Tiket.pdf","catatan":"-"}'
            >Lihat</button>
          </div>
        </div>

        <a href="{{ url('/riwayat') }}" class="seeall" style="display:block; text-decoration:none;">Lihat Semua Riwayat</a>
      </div>
    </div>

    <div class="bottom">
      <div class="infoBox">
        <div class="boxTitle">ⓘ &nbsp; Informasi Penting</div>
        <div class="boxText">
          Pastikan Anda mengajukan cuti minimal 7 hari sebelum tanggal pengajuan.
          Untuk keperluan mendesak, hubungi HRD Anda.
        </div>
      </div>
      <div class="helpBox">
        <div class="boxTitle">✅ &nbsp; Butuh Bantuan?</div>
        <div class="boxText">
          Hubungi kami melalui WhatsApp atau email untuk bantuan lebih lanjut jika mengalami kendala.
        </div>
      </div>
    </div>
  </div>

  <div class="main-footer">
    SIIPUL © 2024 | Disdikbudpora Kab Semarang
  </div>

  <div class="modalOverlay" id="modal">
    <div class="modal">
      <div class="modalHead">
        <h4 id="modalTitle">Detail Pengajuan Cuti</h4>
        <button class="xbtn" id="closeBtn">×</button>
      </div>

      <div class="modalBody">
        <div id="statusAlert" style="margin-bottom:15px; padding:10px; border-radius:8px; font-size:13px; font-weight:700; display:none;"></div>

        <div class="formGrid">
          <div class="field">
            <label>ID Pengajuan</label>
            <input id="f_id" type="text" readonly style="background:#f3f4f6; color:#6b7280;"/>
          </div>
          <div class="field">
            <label>Status Saat Ini</label>
            <input id="f_status" type="text" readonly style="font-weight:bold;"/>
          </div>
          <div class="field">
            <label>Jenis Cuti</label>
            <select id="f_jenis">
              <option>Cuti Tahunan</option>
              <option>Cuti Sakit</option>
              <option>Cuti Besar</option>
              <option>Cuti Melahirkan</option>
              <option>Cuti Karena Alasan Penting</option>
            </select>
          </div>
          <div class="field">
            <label>Lampiran</label>
            <div id="drop-area" class="drop-area">
              <span class="drop-icon">📂</span>
              <span class="drop-text" id="drop-text-label">Drag & drop file surat di sini</span>
              <input type="file" id="f_lampiran_input" hidden accept=".pdf,.jpg,.jpeg,.png">
              <div id="file-name-display" class="file-name-display"></div>
            </div>
            <input type="hidden" id="f_lampiran_text">
          </div>
          <div class="field">
            <label>Tanggal Mulai</label>
            <input id="f_mulai" type="date" />
          </div>
          <div class="field">
            <label>Tanggal Selesai</label>
            <input id="f_selesai" type="date" />
          </div>
          <div class="field">
            <label>Alamat Selama Cuti</label>
            <input id="f_alamat" type="text" />
          </div>
          <div class="field">
            <label>No. Kontak</label>
            <input id="f_kontak" type="text" />
          </div>
          <div class="field full">
            <label>Alasan / Keterangan</label>
            <textarea id="f_alasan"></textarea>
          </div>
          <div class="field full">
            <label>Catatan Admin</label>
            <textarea id="f_catatan" readonly style="background:#fffbe6; border-color:#ffe58f;"></textarea>
          </div>
        </div>
      </div>

      <div class="modalActions">
        <button class="btn2" id="cancelBtn">Tutup</button>
        <button class="btn2 btnSave" id="saveBtn">Simpan Perubahan</button>
      </div>
    </div>
  </div>

  <script>
    // --- DROPDOWN LOGIC ---
    function toggleDropdown() {
        document.getElementById("userDropdown").classList.toggle("show");
    }

    // Close dropdown if clicked outside
    window.onclick = function(event) {
        if (!event.target.closest('.userchip') && !event.target.closest('.dropdown-menu')) {
            document.getElementById("userDropdown").classList.remove("show");
        }
    }


    // --- MODAL LOGIC (Existing) ---
    const modal = document.getElementById("modal");
    const closeBtn = document.getElementById("closeBtn");
    const cancelBtn = document.getElementById("cancelBtn");
    const saveBtn = document.getElementById("saveBtn");
    const modalTitle = document.getElementById("modalTitle");
    const statusAlert = document.getElementById("statusAlert");
    const dropArea = document.getElementById("drop-area");
    const fileInput = document.getElementById("f_lampiran_input");
    const fileNameDisplay = document.getElementById("file-name-display");
    const dropTextLabel = document.getElementById("drop-text-label");

    const f = {
      id: document.getElementById("f_id"),
      status: document.getElementById("f_status"),
      jenis: document.getElementById("f_jenis"),
      lampiranText: document.getElementById("f_lampiran_text"), 
      mulai: document.getElementById("f_mulai"),
      selesai: document.getElementById("f_selesai"),
      alamat: document.getElementById("f_alamat"),
      kontak: document.getElementById("f_kontak"),
      alasan: document.getElementById("f_alasan"),
      catatan: document.getElementById("f_catatan"),
    };

    let activeBtn = null;
    let activeData = null;

    // --- DRAG & DROP LOGIC ---
    function setupFileUpload() {
      ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropArea.addEventListener(eventName, (e) => { e.preventDefault(); e.stopPropagation(); }, false);
      });
      ['dragenter', 'dragover'].forEach(() => dropArea.classList.add('highlight'));
      ['dragleave', 'drop'].forEach(() => dropArea.classList.remove('highlight'));
      dropArea.addEventListener('drop', (e) => {
        if(fileInput.disabled) return;
        const files = e.dataTransfer.files;
        if(files.length) handleFiles(files);
      });
      dropArea.addEventListener('click', () => { if(!fileInput.disabled) fileInput.click(); });
      fileInput.addEventListener('change', function() { handleFiles(this.files); });
    }

    function handleFiles(files) {
      if (files.length > 0) {
        fileNameDisplay.innerHTML = `📄 ${files[0].name} <span style="font-weight:400; color:#6b7280;">(Siap diupload)</span>`;
        dropTextLabel.textContent = "Ganti file?";
      }
    }
    setupFileUpload();

    // --- MODAL FUNCTIONS ---
    function openModal(btn){
      activeBtn = btn;
      activeData = JSON.parse(btn.getAttribute("data-leave") || "{}");

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
        dropTextLabel.textContent = "Belum ada lampiran. Drag & drop file di sini.";
      }

      const isEditable = (activeData.status === "Ditolak");
      configureEditMode(isEditable, activeData.status);

      modal.classList.add("open");
      document.body.style.overflow = "hidden";
    }

    function configureEditMode(editable, status) {
      const inputs = [f.jenis, f.mulai, f.selesai, f.alamat, f.kontak, f.alasan];
      if (editable) {
        modalTitle.textContent = "Perbaiki Pengajuan (Ditolak)";
        saveBtn.style.display = "block";
        cancelBtn.textContent = "Batal";
        inputs.forEach(inp => inp.disabled = false);
        dropArea.classList.remove('disabled');
        fileInput.disabled = false;
        f.status.style.color = "#b42318";
        statusAlert.style.display = "block";
        statusAlert.style.background = "#fde9ea";
        statusAlert.style.color = "#b42318";
        statusAlert.textContent = "Pengajuan ini ditolak. Silakan perbaiki data dan simpan ulang.";
      } else {
        modalTitle.textContent = "Detail Pengajuan";
        saveBtn.style.display = "none";
        cancelBtn.textContent = "Tutup";
        inputs.forEach(inp => inp.disabled = true);
        dropArea.classList.add('disabled');
        fileInput.disabled = true;
        
        if(status === "Diterima") {
           f.status.style.color = "#1f7a46";
           statusAlert.style.background = "#e8f6ee";
           statusAlert.style.color = "#1f7a46";
           statusAlert.textContent = "Pengajuan ini telah disetujui.";
        } else {
           f.status.style.color = "#a56a00";
           statusAlert.style.background = "#fff2df";
           statusAlert.style.color = "#a56a00";
           statusAlert.textContent = "Pengajuan sedang dalam proses verifikasi.";
        }
        statusAlert.style.display = "block";
      }
    }

    function closeModal(){
      modal.classList.remove("open");
      document.body.style.overflow = "";
    }

    document.querySelectorAll(".btn-detail").forEach(btn => btn.addEventListener("click", ()=> openModal(btn)));
    closeBtn.addEventListener("click", closeModal);
    cancelBtn.addEventListener("click", closeModal);
    
    saveBtn.addEventListener("click", ()=>{
      alert("Data perbaikan berhasil disimpan!");
      closeModal();
    });
  </script>
</body>
</html>