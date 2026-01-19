<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIIPUL Dashboard Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <style>
        :root {
            --primary-red: #A52A2A; /* Warna merah bata sesuai header */
            --bg-light: #f8f9fa;
        }
        body { background-color: var(--bg-light); font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        
        /* --- Header / Navbar Styling --- */
        .navbar-custom { background-color: var(--primary-red); color: white; }
        
        /* PERBAIKAN DI SINI: Menambahkan color: white agar teks SIIPUL Dashboard jadi putih */
        .navbar-brand { 
            font-weight: bold; 
            font-size: 1.2rem; 
            display: flex; 
            align-items: center; 
            gap: 10px; 
            color: white !important; /* Memaksa warna putih */
        }
        .navbar-brand:hover { color: #e0e0e0 !important; } /* Efek hover sedikit abu-abu */
        
        /* --- Profile Dropdown (Fixed) --- */
        .user-dropdown { 
            background: white; 
            color: #333; 
            padding: 5px 6px 5px 6px; 
            border-radius: 50px; /* Bentuk Pil */
            display: flex; 
            align-items: center; 
            gap: 10px; 
            font-weight: 600; 
            font-size: 0.9rem;
            border: 1px solid rgba(255,255,255,0.2);
            cursor: pointer;
            transition: all 0.2s;
        }
        .user-dropdown:hover {
            background-color: #f1f1f1;
            color: var(--primary-red);
        }
        .user-dropdown::after {
            margin-left: 5px;
            margin-right: 10px;
            color: #888;
        }

        /* Avatar Bulat Sempurna */
        .avatar-circle {
            width: 32px;
            height: 32px;
            background-color: var(--primary-red);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            font-weight: bold;
            flex-shrink: 0;
        }

        /* --- Card Stats --- */
        .stat-card { border: none; border-radius: 10px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); transition: transform 0.2s; }
        .stat-card:hover { transform: translateY(-3px); }
        .stat-value { font-size: 2rem; font-weight: bold; margin-bottom: 0; }
        .stat-label { color: #6c757d; font-size: 0.9rem; }
        .text-blue { color: #0d6efd; }
        .text-green { color: #198754; }
        .text-yellow { color: #ffc107; }
        .text-red { color: #dc3545; }

        /* --- Sidebar Menu --- */
        .sidebar-card { border: none; border-radius: 10px; overflow: hidden; }
        .list-group-item { border: none; padding: 12px 20px; font-weight: 500; color: #555; }
        .list-group-item.active { background-color: var(--primary-red); border-color: var(--primary-red); color: white; }
        .list-group-item i { margin-right: 10px; }
        
        /* --- Timeline Activity --- */
        .activity-item { position: relative; padding-left: 20px; margin-bottom: 15px; border-left: 2px solid #ddd; }
        .activity-item::before { content: ''; position: absolute; left: -5px; top: 0; width: 8px; height: 8px; border-radius: 50%; background: var(--primary-red); }
        .activity-title { font-weight: bold; font-size: 0.9rem; display: block; }
        .activity-desc { font-size: 0.8rem; color: #666; }
        .activity-time { font-size: 0.75rem; color: #999; }

        /* --- Main Content Cards --- */
        .content-card { border: none; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.02); margin-bottom: 20px; }
        .card-header-clean { background: none; border-bottom: 1px solid #f0f0f0; padding: 15px 20px; font-weight: bold; color: #444; }
        
        /* --- Pending List --- */
        .pending-item { border-bottom: 1px solid #eee; padding: 15px 0; }
        .pending-item:last-child { border-bottom: none; }
        .badge-pending { background-color: #fff3cd; color: #856404; border: 1px solid #ffeeba; }

        /* --- Footer Info --- */
        .info-box { border-radius: 8px; padding: 15px; display: flex; gap: 15px; align-items: flex-start; }
        .info-box.blue { background-color: #e7f1ff; color: #0c5460; }
        .info-box.green { background-color: #d1e7dd; color: #0f5132; }
    </style>
</head>
<body>

    <nav class="navbar navbar-custom py-3">
        <div class="container-fluid px-4">
            <a class="navbar-brand" href="#">
                <img src="{{ asset('logokabupatensemarang.png') }}" 
                     alt="Logo Kabupaten Semarang" 
                     width="40" 
                     height="auto"
                     class="d-inline-block align-text-top me-2"> 
                SIIPUL Dashboard
            </a>

            <div class="dropdown">
                <a href="#" class="user-dropdown text-decoration-none dropdown-toggle" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="avatar-circle">DS</div>
                    <span>Drs. Sutrisno</span>
                </a>
                
                <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2" aria-labelledby="profileDropdown">
                    <li><h6 class="dropdown-header text-muted">Masuk sebagai Admin</h6></li>
                    <li><a class="dropdown-item" href="{{ route('admin.profil') }}"><i class="bi bi-person me-2"></i> Profile Saya</a></li>
                    <li><a class="dropdown-item" href="#"><i class="bi bi-gear me-2"></i> Pengaturan</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item text-danger" href="#"><i class="bi bi-box-arrow-right me-2"></i> Keluar</a></li>
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
                        <a href="{{ route('admin.kelola_pengajuan') }}" class="list-group-item list-group-item-action">
                            <i class="bi bi-journal-text"></i> Kelola Cuti
                        </a>
                        <a href="{{ route('admin.kelola_pegawai') }}" class="list-group-item list-group-item-action">
                            <i class="bi bi-people"></i> Kelola Pegawai
                        </a>
                        <a href="{{ route('admin.laporan') }}" class="list-group-item list-group-item-action">
                            <i class="bi bi-bar-chart"></i> Laporan
                        </a>
                    </div>
                </div>

                <div class="card sidebar-card shadow-sm p-3">
                    <h6 class="mb-3 fw-bold">Aktivitas Terakhir</h6>
                    <div class="activity-list">
                        <div class="activity-item">
                            <span class="activity-title text-danger">Persetujuan Cuti</span>
                            <span class="activity-desc">Bambang Irawan</span>
                            <div class="activity-time">Hari ini, 10:30 AM</div>
                        </div>
                        <div class="activity-item">
                            <span class="activity-title text-danger">Penolakan Izin</span>
                            <span class="activity-desc">Dwi Santoso</span>
                            <div class="activity-time">Hari ini, 09:15 AM</div>
                        </div>
                        <div class="activity-item">
                            <span class="activity-title text-danger">Pengajuan Baru</span>
                            <span class="activity-desc">Eka Sutrisno</span>
                            <div class="activity-time">Kemarin, 02:45 PM</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-9">
                
                <div class="mb-4">
                    <h3 class="fw-bold">Selamat Datang, <span style="color: var(--primary-red);">Drs. Sutrisno</span> !</h3>
                    <p class="text-muted">Dinas Pendidikan</p>
                </div>

                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="card stat-card p-3 h-100">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <p class="stat-label mb-1">Total Pengajuan</p>
                                    <h2 class="stat-value text-blue">348</h2>
                                    <small class="text-muted">Tahun ini</small>
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
                                    <h2 class="stat-value text-green">227</h2>
                                    <small class="text-muted">65% dari total</small>
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
                                    <h2 class="stat-value text-yellow">24</h2>
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
                                    <h2 class="stat-value text-red">156</h2>
                                    <small class="text-muted">Aktif</small>
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
                                    <option>Semua Pegawai</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label small text-muted">Status</label>
                                <select class="form-select">
                                    <option>Semua Status</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6 d-grid">
                                <button class="btn btn-success text-white"><i class="bi bi-file-excel"></i> Download Rekap Excel</button>
                            </div>
                            <div class="col-md-6 d-grid">
                                <button class="btn btn-danger"><i class="bi bi-file-pdf"></i> Download PDF Surat</button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="card content-card">
                    <div class="card-header-clean">
                        <i class="bi bi-exclamation-circle text-warning me-2"></i> Pengajuan Menunggu Persetujuan (4)
                    </div>
                    <div class="card-body p-0">
                        <div class="pending-item px-4">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="mb-0 fw-bold">Budi Santoso</h6>
                                    <small class="text-muted d-block">Cuti Tahunan</small>
                                    <small class="text-secondary" style="font-size: 0.8rem;">2024-05-20 s/d 2024-05-25 (5 Hari)</small>
                                    </div>
                                <div class="text-end">
                                    <span class="badge badge-pending mb-2">Menunggu</span>
                                    <br>
                                    <a href="{{ route('admin.detail_pengajuan') }}" class="btn btn-sm btn-outline-secondary">Lihat Detail</a>
                                </div>
                            </div>
                        </div>
                        <div class="pending-item px-4">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="mb-0 fw-bold">Siti Nurhaliza</h6>
                                    <small class="text-muted d-block">Cuti Sakit</small>
                                    <small class="text-secondary" style="font-size: 0.8rem;">2024-05-15 s/d 2024-05-17 (3 Hari)</small>
                                    </div>
                                <div class="text-end">
                                    <span class="badge badge-pending mb-2">Menunggu</span>
                                    <br>
                                    <a href="{{ route('admin.detail_pengajuan') }}" class="btn btn-sm btn-outline-secondary">Lihat Detail</a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="p-3 text-center border-top">
                            <a href="{{ route('admin.kelola_pengajuan') }}" class="text-danger text-decoration-none small fw-bold">Lihat Semua Pengajuan &rarr;</a>
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
                                <p class="small mb-0">Ada 24 pengajuan menunggu persetujuan Anda. Segera proses.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-box green">
                            <i class="bi bi-check-circle fs-4"></i>
                            <div>
                                <h6 class="fw-bold mb-1">Sistem Aktif</h6>
                                <p class="small mb-0">Semua modul berfungsi dengan baik. Sinkronisasi aman.</p>
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
        // Inisialisasi Chart mirip gambar
        const ctx = document.getElementById('statsChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
                datasets: [
                    {
                        label: 'Disetujui',
                        data: [12, 19, 3, 5, 2, 3],
                        backgroundColor: '#198754', 
                        borderRadius: 4
                    },
                    {
                        label: 'Ditolak',
                        data: [2, 3, 20, 5, 1, 4],
                        backgroundColor: '#dc3545', 
                        borderRadius: 4
                    },
                    {
                        label: 'Diproses',
                        data: [3, 10, 13, 15, 22, 30],
                        backgroundColor: '#ffc107', 
                        borderRadius: 4
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom' }
                },
                scales: {
                    y: { beginAtZero: true, grid: { borderDash: [2, 4] } },
                    x: { grid: { display: false } }
                }
            }
        });
    </script>
</body>
</html>