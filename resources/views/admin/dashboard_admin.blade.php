<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIIPUL Dashboard Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <style>
        /* ... (CSS tetap sama, copy paste style kamu di sini) ... */
        /* Saya persingkat biar muat */
        :root { --primary-red: #A52A2A; --bg-light: #f8f9fa; }
        body { background-color: var(--bg-light); font-family: 'Segoe UI', sans-serif; }
        .navbar-custom { background-color: var(--primary-red); color: white; }
        .navbar-brand { color: white !important; font-weight: bold; }
        .user-dropdown { background: white; border-radius: 50px; padding: 5px 10px; display: flex; align-items: center; gap: 10px; cursor: pointer; }
        .avatar-circle { width: 32px; height: 32px; background: var(--primary-red); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; }
        .stat-card { border: none; border-radius: 10px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); }
        .sidebar-card { border: none; border-radius: 10px; overflow: hidden; }
        .activity-item { position: relative; padding-left: 20px; margin-bottom: 15px; border-left: 2px solid #ddd; }
        .activity-item::before { content: ''; position: absolute; left: -5px; top: 0; width: 8px; height: 8px; border-radius: 50%; background: var(--primary-red); }
        .pending-item { border-bottom: 1px solid #eee; padding: 15px 0; }
        .badge-pending { background-color: #fff3cd; color: #856404; border: 1px solid #ffeeba; }
        .content-card { border: none; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.02); margin-bottom: 20px; }
        .text-blue { color: #0d6efd; } .text-green { color: #198754; } .text-yellow { color: #ffc107; } .text-red { color: #dc3545; }
    </style>
</head>
<body>

    <nav class="navbar navbar-custom py-3">
        <div class="container-fluid px-4">
            <a class="navbar-brand" href="#">
                <img src="{{ asset('logokabupatensemarang.png') }}" alt="Logo" width="40" class="d-inline-block align-text-top me-2"> 
                SIIPUL Dashboard
            </a>

            <div class="dropdown">
                <a href="#" class="user-dropdown text-decoration-none dropdown-toggle" id="profileDropdown" data-bs-toggle="dropdown">
                    <div class="avatar-circle">{{ substr(Auth::user()->name, 0, 2) }}</div>
                    <span>{{ Auth::user()->name }}</span>
                </a>
                
                <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
                    <li><h6 class="dropdown-header text-muted">Role: {{ ucfirst(Auth::user()->role) }}</h6></li>
                    <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i> Profile Saya</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="dropdown-item text-danger"><i class="bi bi-box-arrow-right me-2"></i>Log Out</button>
                    </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid px-4 mt-4">
        <div class="row">
            
            <div class="col-lg-3 mb-4">
                <div class="card sidebar-card shadow-sm mb-4">
                    <div class="card-header bg-white font-weight-bold py-3">Menu Cepat</div>
                    <div class="list-group list-group-flush">
                        <a href="{{ route('admin.kelola_pengajuan') }}"
                            class="list-group-item list-group-item-action">
                            <i class="bi bi-journal-text"></i> Kelola Pengajuan
                        </a>

                        <a href="{{ route('admin.kelola_pegawai') }}"
                            class="list-group-item list-group-item-action">
                            <i class="bi bi-people"></i> Kelola Pegawai
                         </a>

                        <a href="{{ route('admin.laporan') }}"
                            class="list-group-item list-group-item-action">
                            <i class="bi bi-bar-chart"></i> Laporan
                        </a>

                    </div>
                </div>

                <div class="card sidebar-card shadow-sm p-3">
                    <h6 class="mb-3 fw-bold">Aktivitas Terakhir</h6>
                    <div class="activity-list">
                        @forelse($recentActivities as $activity)
                            <div class="activity-item">
                                <span class="activity-title text-danger">
                                    {{ $activity->status == 'approved' ? 'Disetujui' : ($activity->status == 'rejected' ? 'Ditolak' : 'Pengajuan Baru') }}
                                </span>
                                <span class="activity-desc">{{ $activity->user->name }} - {{ $activity->jenis_cuti }}</span>
                                <div class="activity-time" style="font-size: 0.75rem; color: #999;">
                                    {{ $activity->updated_at->diffForHumans() }}
                                </div>
                            </div>
                        @empty
                            <small class="text-muted">Belum ada aktivitas.</small>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="col-lg-9">
                
                <div class="mb-4">
                    <h3 class="fw-bold">Selamat Datang, <span style="color: var(--primary-red);">{{ Auth::user()->name }}</span> !</h3>
                    <p class="text-muted">{{ Auth::user()->bidang_unit ?? 'Administrator' }}</p>
                </div>

                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="card stat-card p-3 h-100">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <p class="stat-label mb-1">Total Pengajuan</p>
                                    <h2 class="stat-value text-blue">{{ $totalPengajuan }}</h2>
                                    <small class="text-muted">Semua waktu</small>
                                </div>
                                <i class="bi bi-file-earmark-text fs-3 text-blue bg-light p-2 rounded"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card stat-card p-3 h-100">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <p class="stat-label mb-1">Disetujui</p>
                                    <h2 class="stat-value text-green">{{ $disetujui }}</h2>
                                    <small class="text-muted">Permohonan sukses</small>
                                </div>
                                <i class="bi bi-check-circle fs-3 text-green bg-light p-2 rounded"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card stat-card p-3 h-100">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <p class="stat-label mb-1">Menunggu</p>
                                    <h2 class="stat-value text-yellow">{{ $menunggu }}</h2>
                                    <small class="text-muted">Perlu tindakan</small>
                                </div>
                                <i class="bi bi-clock fs-3 text-yellow bg-light p-2 rounded"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card stat-card p-3 h-100">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <p class="stat-label mb-1">Total Pegawai</p>
                                    <h2 class="stat-value text-red">{{ $totalPegawai }}</h2>
                                    <small class="text-muted">User aktif</small>
                                </div>
                                <i class="bi bi-people fs-3 text-red bg-light p-2 rounded"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card content-card p-4">
                    <h5 class="mb-3 fw-bold">Download Rekap Laporan</h5>
                    <form>
                        <div class="row g-3 align-items-end">
                            <div class="col-md-3">
                                <label class="form-label small text-muted">Tanggal Mulai</label>
                                <input type="date" class="form-control">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label small text-muted">Tanggal Akhir</label>
                                <input type="date" class="form-control">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label small text-muted">Pegawai</label>
                                <select class="form-select">
                                    <option value="">Semua Pegawai</option>
                                    @foreach($listPegawai as $pegawai)
                                        <option value="{{ $pegawai->id }}">{{ $pegawai->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label small text-muted">Status</label>
                                <select class="form-select">
                                    <option value="">Semua Status</option>
                                    <option value="approved">Disetujui</option>
                                    <option value="pending">Menunggu</option>
                                    <option value="rejected">Ditolak</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6 d-grid">
                                <button type="submit" formaction="{{ route('admin.download.excel') }}" class="btn btn-success text-white">
                                    <i class="bi bi-file-excel"></i> Download Rekap Excel
                                </button>
                            </div>
                            <div class="col-md-6 d-grid">
                                <button type="submit" formaction="{{ route('admin.download.pdf') }}" class="btn btn-danger">
                                    <i class="bi bi-file-pdf"></i> Download PDF Surat
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="card content-card">
                    <div class="card-header-clean">
                        <i class="bi bi-exclamation-circle text-warning me-2"></i> Pengajuan Menunggu Persetujuan ({{ $menunggu }})
                    </div>
                    <div class="card-body p-0">
                        @forelse($pendingRequests as $request)
                            <div class="pending-item px-4">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="mb-0 fw-bold">{{ $request->user->name }}</h6>
                                        <small class="text-muted d-block">{{ $request->jenis_cuti }}</small>
                                        <small class="text-secondary" style="font-size: 0.8rem;">
                                            {{ \Carbon\Carbon::parse($request->start_date)->format('d M Y') }} 
                                            s/d 
                                            {{ \Carbon\Carbon::parse($request->end_date)->format('d M Y') }}
                                            ({{ $request->duration }} Hari)
                                        </small>
                                    </div>
                                    <div class="text-end">
                                        <span class="badge badge-pending mb-2">Menunggu</span>
                                        <br>
                                        <a href="{{ route('admin.pengajuan.show', $request->id) }}" class="btn btn-sm btn-outline-secondary">
                                            Lihat Detail
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="p-4 text-center text-muted">
                                Tidak ada pengajuan yang menunggu persetujuan.
                            </div>
                        @endforelse
                        
                        <div class="p-3 text-center border-top">
                            <a href="{{ route('admin.kelola_pengajuan') }}" class="text-danger text-decoration-none small fw-bold">
                Lihat Semua Pengajuan &rarr;
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card content-card p-4">
                    <h5 class="mb-4 fw-bold">Statistik Pengajuan (6 Bulan Terakhir)</h5>
                    <div style="height: 300px;">
                        <canvas id="statsChart"></canvas>
                    </div>
                </div>

                <div class="row mb-5">
                    <div class="col-md-6">
                        <div class="info-box blue">
                            <i class="bi bi-info-circle fs-4"></i>
                            <div>
                                <h6 class="fw-bold mb-1">Pemberitahuan</h6>
                                <p class="small mb-0">Ada <strong>{{ $menunggu }}</strong> pengajuan menunggu persetujuan Anda.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-box green">
                            <i class="bi bi-check-circle fs-4"></i>
                            <div>
                                <h6 class="fw-bold mb-1">Database Sinkron</h6>
                                <p class="small mb-0">Total {{ $totalPengajuan }} data cuti tercatat dalam sistem.</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <script>
        const ctx = document.getElementById('statsChart').getContext('2d');
        
        // Mengambil data dari PHP Controller ke JavaScript
        const labels = @json($chartLabels);
        const dataApproved = @json($dataApproved);
        const dataRejected = @json($dataRejected);
        const dataPending = @json($dataPending);

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels, // Label Bulan Otomatis
                datasets: [
                    {
                        label: 'Disetujui',
                        data: dataApproved, // Data Database
                        backgroundColor: '#198754', 
                        borderRadius: 4
                    },
                    {
                        label: 'Ditolak',
                        data: dataRejected, // Data Database
                        backgroundColor: '#dc3545', 
                        borderRadius: 4
                    },
                    {
                        label: 'Menunggu',
                        data: dataPending, // Data Database
                        backgroundColor: '#ffc107', 
                        borderRadius: 4
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { position: 'bottom' } },
                scales: {
                    y: { beginAtZero: true, ticks: { stepSize: 1 } }, // Biar angkanya bulat (gak ada 1.5 orang)
                    x: { grid: { display: false } }
                }
            }
        });
    </script>
</body>
</html>