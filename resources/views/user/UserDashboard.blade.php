<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Dashboard User - {{ config('app.name') }}</title>

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
      position: relative;
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
    }

    /* User Chip */
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

    /* --- DROPDOWN MENU --- */
    .dropdown-menu {
        position: absolute;
        top: 80px; right: 32px; width: 320px;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        border: 1px solid #e5e7eb;
        display: none;
        flex-direction: column;
        overflow: hidden;
        animation: fadeIn 0.2s ease-out;
    }
    .dropdown-menu.show { display: flex; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }

    .dd-header { padding: 20px; border-bottom: 1px solid #f3f4f6; display: flex; align-items: center; gap: 16px; }
    .dd-avatar-lg { width: 48px; height: 48px; background: var(--primary); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 18px; }
    .dd-info-sec { padding: 20px; border-bottom: 1px solid #f3f4f6; }
    .dd-label { font-size: 11px; color: #9ca3af; font-weight: 700; margin-bottom: 4px; text-transform: uppercase; }
    .dd-value { font-size: 14px; color: #111827; font-weight: 600; margin-bottom: 12px; }
    .dd-links { display: flex; flex-direction: column; }
    .dd-item { display: block; padding: 10px 15px; text-decoration: none; color: #333; transition: background 0.3s; background: none; border: none; width: 100%; text-align: left; font-size: inherit; cursor: pointer; }
    .dd-item:hover { background-color: #f8f9fa; color: #007bff; }
    .dd-item i { margin-right: 10px; width: 20px; }
    .dd-logout:hover { color: #dc3545; }

    /* --- CONTAINER --- */
    .container{ max-width:1400px; width: 95%; margin:30px auto; padding:0 20px 30px; flex: 1; }
    .welcome{ font-size:32px; font-weight:700; margin:10px 0 30px; color: #111827; }

    /* Stats & Grid */
    .stats{ display:grid; grid-template-columns:repeat(3, 1fr); gap:24px; margin-bottom:30px; }
    .stat{ background:var(--card); border:1px solid #fff; border-radius:12px; box-shadow:var(--shadow); padding:24px; min-height:120px; display:flex; justify-content:space-between; align-items:flex-start; transition: transform 0.2s; }
    .stat:hover{ transform: translateY(-2px); }
    .slabel{ font-size:14px; font-weight:600; color:#6b7280; }
    .svalue{ font-size:36px; font-weight:700; margin-top:12px; line-height: 1; }
    .ssub{ font-size:13px; color:var(--muted); margin-top:8px; }

    .grid{ display:grid; grid-template-columns: 350px 1fr; gap:30px; align-items:start; }
    .card{ background:var(--card); border:1px solid #fff; border-radius:12px; box-shadow:var(--shadow); padding:24px; }
    .card h3{ margin:0 0 20px; font-size:16px; font-weight:700; color:#374151; }

    /* Buttons */
    .btn{ width:100%; border-radius:8px; padding:14px 16px; border:1px solid var(--border); background:#fff; cursor:pointer; font-weight:600; display:flex; align-items:center; justify-content:center; gap:10px; font-size: 14px; transition: all 0.2s; box-shadow: 0 1px 2px rgba(0,0,0,0.05); text-decoration: none; color: var(--text); }
    .btn:hover{ transform: translateY(-1px); box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
    .btn-primary{ border:none; background:var(--primary); color:#fff; }
    .btn-primary:hover{ background: #711010; }
    .btn + .btn{ margin-top:16px; }

    /* Donut Chart */
    .donut-wrap{ display:flex; gap:20px; align-items:center; justify-content: center; padding: 10px 0;}
    .donut{ width:150px; height:150px; border-radius:50%; position:relative; }
    .donut::after{ content:""; position:absolute; inset:30px; background:#fff; border-radius:50%; }
    .legend{ display:flex; flex-direction:column; gap:12px; font-size:13px; color:#374151; font-weight:600; }
    .lg{ display:flex; align-items:center; gap:8px; }
    .dot{ width:12px; height:12px; border-radius:4px; }
    .dot.ok{ background:#22c55e; } .dot.pen{ background:#f59e0b; } .dot.rej{ background:#ef4444; }

    /* History List */
    .history-list-container { display: flex; flex-direction: column; gap: 16px; }
    .h-card { background: #fff; border-radius: 16px; padding: 20px 24px; display: flex; align-items: center; justify-content: space-between; border: 1px solid var(--border); box-shadow: 0 2px 4px rgba(0,0,0,0.03); transition: transform 0.2s; border-left: 6px solid #ccc; }
    .h-card:hover { transform: translateY(-3px); }
    .h-card[data-status="disetujui"] { border-left-color: var(--ok); }
    .h-card[data-status="pending"]  { border-left-color: var(--pen); }
    .h-card[data-status="ditolak"] { border-left-color: var(--rej); }

    .hc-left { display: flex; align-items: center; gap: 20px; }
    .st-icon-circle { width: 48px; height: 48px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 20px; }
    .st-ok { background: var(--ok-bg); color: var(--ok); }
    .st-pen { background: var(--pen-bg); color: var(--pen); }
    .st-rej { background: var(--rej-bg); color: var(--rej); }

    .hc-info h4 { font-size: 16px; font-weight: 700; color: #111; margin: 0 0 6px 0; }
    .hc-date { font-size: 13px; color: #555; display: flex; align-items: center; gap: 8px; }

    .hc-right { text-align: right; display: flex; flex-direction: column; align-items: flex-end; gap: 10px; }

    .duration-badge { font-size: 12px; font-weight: 600; background: #f3f4f6; padding: 6px 14px; border-radius: 8px; color: #374151; }
    .btn-detail-sm { font-size: 12px; font-weight: 600; color: var(--primary); background: transparent; border: 1.5px solid var(--primary); padding: 6px 16px; border-radius: 8px; cursor: pointer; transition: 0.2s; }
    .btn-detail-sm:hover { background: var(--primary); color: white; }

    .main-footer { background: var(--primary); color: rgba(255,255,255,0.8); text-align: center; padding: 16px; font-size: 13px; margin-top: 40px; }
    
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
    <div class="brand">
      <img src="{{ asset('logokabupatensemarang.png') }}" alt="Logo">
      <div>Dashboard</div>
    </div>

    {{-- User Info di Topbar --}}
    <div onclick="toggleDropdown()" class="userchip" id="userMenuBtn">
      <div class="userleft">
        <div>
          <div class="uname">{{ $user->name }}</div>
          <div class="urole">{{ $user->jabatan ?? 'Pegawai' }}</div>
        </div>
        <i class="fa-solid fa-chevron-down" style="font-size:10px; color:#6b7280;"></i>
      </div>
      <div class="avatar">{{ strtoupper(substr($user->name, 0, 2)) }}</div>
    </div>

    {{-- Dropdown Menu --}}
    <div class="dropdown-menu" id="userDropdown">
        <div class="dd-header">
            <div class="dd-avatar-lg">{{ strtoupper(substr($user->name, 0, 2)) }}</div>
            <div>
                <div class="uname" style="font-size:15px; color:#1f2937;">{{ $user->name }}</div>
                <div class="urole" style="font-size:12px;">{{ $user->jabatan ?? 'Pegawai' }}</div>
            </div>
        </div>
        <div class="dd-info-sec">
            <div class="dd-label">NIP</div>
            <div class="dd-value">{{ $user->nip }}</div>
            <div class="dd-label">Posisi</div>
            <div class="dd-value">{{ $user->jabatan ?? '-' }}</div>
        </div>
        <div class="dd-links">
          <a href="{{ route('user.profil') }}" class="dd-item"><i class="fa-regular fa-user"></i> Profil Saya</a>
          <a href="{{ route('user.riwayat') }}" class="dd-item"><i class="fa-regular fa-file-lines"></i> Riwayat Cuti</a>
          <form action="{{ route('logout') }}" method="POST" class="m-0">
              @csrf
              <button type="submit" class="dd-item dd-logout w-100 border-0 text-start">
                  <i class="fa-solid fa-arrow-right-from-bracket"></i> Log Out
              </button>
          </form>
        </div>
    </div>
  </div>

  <div class="container">
    <div class="welcome">Selamat Datang, &nbsp;{{ $user->name }} !</div>

    {{-- Stats Cards --}}
    <div class="stats">
      <div class="stat">
        <div>
            <div class="slabel">Total Cuti</div>
            <div class="svalue" style="color:var(--primary);">{{ $totalQuota }}</div>
            <div class="ssub">hari cuti per tahun</div>
        </div>
      </div>
      <div class="stat">
        <div>
            <div class="slabel">Cuti Digunakan</div>
            <div class="svalue" style="color:var(--ok);">{{ $usedLeave }}</div>
            <div class="ssub">dari {{ $totalQuota }} hari</div>
        </div>
      </div>
      <div class="stat">
        <div>
            <div class="slabel">Sisa Cuti</div>
            <div class="svalue" style="color:var(--rej);">{{ $remainingLeave }}</div>
            <div class="ssub">hari tersisa</div>
        </div>
      </div>
    </div>

    <div class="grid">
      <div>
        <div class="card">
          <h3>Aksi Cepat</h3>
          <a href="{{ route('user.cuti.create') }}" class="btn btn-primary">Ajukan Cuti</a>
          <a href="{{ url('/hubungi-kami') }}" class="btn">Hubungi Kami</a>
        </div>

        {{-- Donut Chart Dinamis --}}
        <div class="card" style="margin-top:24px;">
          <h3>Status Pengajuan</h3>
          <div class="donut-wrap">
            <div class="donut" style="background: conic-gradient(
                #22c55e 0 {{ $approvedPercent }}%, 
                #f59e0b {{ $approvedPercent }}% {{ $approvedPercent + $pendingPercent }}%, 
                #ef4444 {{ $approvedPercent + $pendingPercent }}% 100%
            );"></div>
            <div class="legend">
              <div class="lg"><span class="dot ok"></span> Disetujui ({{ $approvedPercent }}%)</div>
              <div class="lg"><span class="dot pen"></span> Pending ({{ $pendingPercent }}%)</div>
              <div class="lg"><span class="dot rej"></span> Ditolak ({{ $rejectedPercent }}%)</div>
            </div>
          </div>
        </div>
      </div>

      {{-- Recent Leave History --}}
        <div class="card">
            <h3>Riwayat Permintaan Cuti</h3>
            <div class="history-list-container">
                @forelse($recentLeaves as $leave)
                @php
                    $leaveData = [
                        'id' => 'CUTI-' . now()->year . '-' . str_pad($leave->id, 4, '0', STR_PAD_LEFT),
                        'status' => $leave->status == 'approved' ? 'Diterima' : ($leave->status == 'pending' ? 'Diproses' : 'Ditolak'),
                        'jenis' => $leave->jenis_cuti,
                        'mulai' => $leave->start_date->format('Y-m-d'),
                        'selesai' => $leave->end_date->format('Y-m-d'),
                        'alamat' => $leave->address ?? '-',
                        'kontak' => $leave->phone ?? '-',
                        'alasan' => $leave->reason,
                        'lampiran' => $leave->file_path ? basename($leave->file_path) : '-',
                        'catatan' => $leave->rejection_reason ?? '-'
                    ];
                @endphp
                
                <div class="h-card" data-status="{{ $leave->status }}">
                    <div class="hc-left">
                        <div class="st-icon-circle 
                            @if($leave->status == 'approved') st-ok 
                            @elseif($leave->status == 'pending') st-pen 
                            @else st-rej @endif">
                            <i class="fa-solid 
                                @if($leave->status == 'approved') fa-check 
                                @elseif($leave->status == 'pending') fa-clock 
                                @else fa-xmark @endif"></i>
                        </div>
                        <div class="hc-info">
                            <h4>{{ $leave->jenis_cuti }}</h4>
                            <div class="hc-date">
                                <i class="fa-regular fa-calendar"></i> 
                                {{ $leave->start_date->format('d M Y') }} - {{ $leave->end_date->format('d M Y') }}
                            </div>
                        </div>
                    </div>
                    <div class="hc-right">
                        <span class="duration-badge">{{ $leave->duration }} Hari</span>
                        <button class="btn-detail-sm" onclick="openModal(this)" data-leave='{{ json_encode($leaveData) }}'>
                            Lihat Detail
                        </button>
                    </div>
                </div>
                @empty
                <div style="text-align:center; padding: 40px 0; color: var(--muted);">
                    <i class="fa-regular fa-folder-open" style="font-size: 40px; margin-bottom: 10px; opacity: 0.3;"></i>
                    <p>Belum ada riwayat pengajuan cuti</p>
                </div>
                @endforelse
            </div>
            <a href="{{ route('user.riwayat') }}" style="display:block; text-align:center; margin-top:20px; color:var(--primary); text-decoration:none; font-weight:600;">Lihat Semua Riwayat</a>
        </div>
    </div>
  </div>

  <div class="main-footer">SIIPUL © 2024 | Disdikbudpora Kab Semarang</div>

{{-- MODAL --}}
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
              <select id="f_jenis" disabled>
                  <option>Cuti Tahunan</option>
                  <option>Cuti Sakit</option>
                  <option>Cuti Besar</option>
                  <option>Cuti Melahirkan</option>
                  <option>Cuti Karena Alasan Penting</option>
              </select>
          </div>
          <div class="field">
              <label>Lampiran</label>
              <div id="drop-area" class="drop-area disabled">
                  <span class="drop-icon">📂</span>
                  <span class="drop-text" id="drop-text-label">Drag & drop file surat di sini</span>
                  <input type="file" id="f_lampiran_input" hidden accept=".pdf,.jpg,.jpeg,.png">
                  <div id="file-name-display" class="file-name-display"></div>
              </div>
              <input type="hidden" id="f_lampiran_text">
          </div>
          <div class="field">
              <label>Tanggal Mulai</label>
              <input id="f_mulai" type="date" readonly />
          </div>
          <div class="field">
              <label>Tanggal Selesai</label>
              <input id="f_selesai" type="date" readonly />
          </div>
          <div class="field">
              <label>Alamat Selama Cuti</label>
              <input id="f_alamat" type="text" readonly />
          </div>
          <div class="field">
              <label>No. Kontak</label>
              <input id="f_kontak" type="text" readonly />
          </div>
          <div class="field full">
              <label>Alasan / Keterangan</label>
              <textarea id="f_alasan" readonly></textarea>
          </div>
          <div class="field full">
              <label>Catatan Admin</label>
              <textarea id="f_catatan" readonly style="background:#fffbe6; border-color:#ffe58f;"></textarea>
          </div>
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
    // --- DROPDOWN & MODAL SCRIPTS ---
    function toggleDropdown() { 
        document.getElementById("userDropdown").classList.toggle("show"); 
    }
    
    window.onclick = function(event) { 
        if (!event.target.closest('.userchip') && !event.target.closest('.dropdown-menu')) { 
            document.getElementById("userDropdown").classList.remove("show"); 
        } 
    }
    
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
        catatan: document.getElementById("f_catatan") 
    };
    
    let activeBtn = null; 
    let activeData = null;

    function openModal(btn){ 
          console.log('Button clicked:', btn);
          console.log('Data attribute:', btn.getAttribute("data-leave"));
          
          activeBtn = btn; 
          
          try {
              activeData = JSON.parse(btn.getAttribute("data-leave") || "{}");
              console.log('Parsed data:', activeData);
          } catch (error) {
              console.error('JSON parse error:', error);
              alert('Error: Data tidak valid');
              return;
          }
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

    function closeModal(){ 
        modal.classList.remove("open"); 
        document.body.style.overflow = ""; 
    }
    
    // Attach event listeners
    closeBtn.addEventListener("click", closeModal); 
    cancelBtn.addEventListener("click", closeModal); 
    
    // Close modal when clicking outside
    window.addEventListener('click', function(event) {
        if (event.target === modal) {
            closeModal();
        }
    });

    // --- SCRIPT NOTIFIKASI TOAST ---
    function closeToastNotif() {
        const toast = document.getElementById('msg-toast');
        toast.classList.remove('show');
    }

    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('notif') === 'terkirim') {
        const toast = document.getElementById('msg-toast');
        setTimeout(() => { toast.classList.add('show'); }, 100);
        setTimeout(() => { 
            closeToastNotif();
            window.history.replaceState(null, null, window.location.pathname);
        }, 5000);
    }
</script>
</body>
</html>