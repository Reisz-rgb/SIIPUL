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
    .duration-badge { font-size: 12px; font-weight: 600; background: #f3f4f6; padding: 6px 14px; border-radius: 8px; color: #374151; }
    .btn-detail-sm { font-size: 12px; font-weight: 600; color: var(--primary); background: transparent; border: 1.5px solid var(--primary); padding: 6px 16px; border-radius: 8px; cursor: pointer; transition: 0.2s; }
    .btn-detail-sm:hover { background: var(--primary); color: white; }

    .main-footer { background: var(--primary); color: rgba(255,255,255,0.8); text-align: center; padding: 16px; font-size: 13px; margin-top: 40px; }

    @media (max-width: 980px){ .stats, .grid{ grid-template-columns:1fr; } }
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

      <div class="card">
        <h3>Riwayat Permintaan Cuti</h3>
        <div class="history-list-container">
            @forelse($recentLeaves as $leave)
            <div class="h-card" data-status="{{ strtolower($leave->status) }}">
                <div class="hc-left">
                    <div class="st-icon-circle 
                        @if($leave->status == 'disetujui') st-ok 
                        @elseif($leave->status == 'pending') st-pen 
                        @else st-rej @endif">
                        <i class="fa-solid 
                            @if($leave->status == 'disetujui') fa-check 
                            @elseif($leave->status == 'pending') fa-clock 
                            @else fa-xmark @endif"></i>
                    </div>
                    <div class="hc-info">
                        <h4>{{ $leave->jenis_cuti }}</h4>
                        <div class="hc-date">
                            <i class="fa-regular fa-calendar"></i> 
                            {{ $leave->tanggal_mulai->format('d M Y') }} - {{ $leave->tanggal_selesai->format('d M Y') }}
                        </div>
                    </div>
                </div>
                <div class="hc-right">
                    <span class="duration-badge">{{ $leave->jumlah_hari }} Hari</span>
                    {{-- Pastikan fungsi showLeaveDetail didefinisikan di JS atau arahkan ke route --}}
                    <button class="btn-detail-sm" onclick="showLeaveDetail({{ $leave->id }})">Lihat Detail</button>
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

  <script>
    function toggleDropdown() { document.getElementById("userDropdown").classList.toggle("show"); }
    window.onclick = function(event) { if (!event.target.closest('.userchip')) { document.getElementById("userDropdown").classList.remove("show"); } }
    
    // Fungsi untuk memanggil detail (implementasikan sesuai kebutuhan Ajax/Modal Anda)
    function showLeaveDetail(id) {
        console.log("Melihat detail ID:", id);
        // Anda bisa mengarahkan ke halaman detail atau membuka modal via AJAX di sini
    }
  </script>
</body>
</html>