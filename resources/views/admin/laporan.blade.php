<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan & Analytics - SIIPUL</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <style>
        :root {
            --primary-red: #A52A2A; /* Merah Bata */
            --bg-light: #f8f9fa;
        }
        body { background-color: var(--bg-light); font-family: 'Segoe UI', sans-serif; }

        /* --- Navbar (Sama dengan Dashboard) --- */
        .navbar-custom { background-color: var(--primary-red); color: white; }
        
        /* Navbar Brand Putih */
        .navbar-brand { 
            font-weight: bold; 
            font-size: 1.2rem; 
            display: flex; 
            align-items: center; 
            gap: 10px; 
            color: white !important; /* Tulisan jadi Putih */
        }
        .navbar-brand:hover { color: #e0e0e0 !important; }
        
        /* --- Page Header & Filter --- */
        .page-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; }
        .header-left { display: flex; align-items: center; gap: 15px; }
        .btn-back-arrow { font-size: 1.5rem; color: #333; text-decoration: none; }
        .btn-back-arrow:hover { color: var(--primary-red); }
        
        .btn-export {
            background-color: #A52A2A; color: white; border: none;
            padding: 8px 20px; border-radius: 6px; font-size: 0.9rem;
            display: flex; align-items: center; gap: 8px;
        }
        .btn-export:hover { background-color: #8a2323; color: white; }

        .filter-card { background: white; border: 1px solid #e0e0e0; border-radius: 8px; padding: 20px; margin-bottom: 20px; }

        /* --- Stats Cards --- */
        .stat-card-clean { background: white; border: 1px solid #e0e0e0; border-radius: 8px; padding: 20px; height: 100%; }
        .stat-val { font-size: 2rem; font-weight: bold; color: #A52A2A; margin: 5px 0; }
        .stat-desc { font-size: 0.8rem; color: #6c757d; }
        .text-green-small { color: #198754; font-size: 0.8rem; font-weight: 600; }
        
        /* --- Chart Cards --- */
        .chart-card { background: white; border: 1px solid #e0e0e0; border-radius: 8px; padding: 25px; margin-bottom: 20px; height: 100%; }
        .chart-title { font-weight: 600; margin-bottom: 25px; color: #444; }

        /* Progress Bar Custom */
        .progress-label { display: flex; justify-content: space-between; font-size: 0.85rem; margin-bottom: 5px; color: #555; }
        .progress-custom { height: 8px; border-radius: 10px; background-color: #f0f0f0; margin-bottom: 20px; }
        
        /* Table Detail */
        .table-custom th { font-size: 0.85rem; color: #666; font-weight: 600; background-color: white; border-bottom: 1px solid #eee; padding: 15px; }
        .table-custom td { padding: 15px; vertical-align: middle; font-size: 0.9rem; color: #333; border-bottom: 1px solid #eee; }
        .badge-num { 
            display: inline-block; padding: 4px 10px; border-radius: 4px; font-size: 0.8rem; font-weight: 600; min-width: 35px; text-align: center; 
        }
        .bg-light-green { background-color: #e6f8ef; color: #198754; }
        .bg-light-red { background-color: #ffeef0; color: #dc3545; }
        .bg-light-yellow { background-color: #fff8e1; color: #ffc107; }
        .text-danger-bold { color: #A52A2A; font-weight: bold; }

    </style>
</head>
<body>

    <nav class="navbar navbar-custom py-3">
        <div class="container-fluid px-4">
            <a class="navbar-brand" href="{{ route('admin.dashboard') }}">
                <img src="{{ asset('logokabupatensemarang.png') }}" alt="Logo" width="40" height="auto" class="d-inline-block align-text-top me-2"> 
                SIIPUL Dashboard
            </a>
            
            </div>
    </nav>

    <div class="container-fluid px-4 mt-4 mb-5">
        
        <div class="page-header">
            <div class="header-left">
                <a href="{{ route('admin.dashboard') }}" class="btn-back-arrow"><i class="bi bi-arrow-left"></i></a>
                <h4 class="mb-0 text-secondary">Laporan & Analytics</h4>
            </div>
            <button class="btn-export">
                <i class="bi bi-download"></i> Export Laporan
            </button>
        </div>

        <div class="filter-card shadow-sm">
            <label class="form-label small text-muted"><i class="bi bi-calendar3 me-1"></i> Rentang Waktu</label>
            <select class="form-select bg-light border-0" style="max-width: 300px;">
                <option>1 Bulan Terakhir</option>
                <option>3 Bulan Terakhir</option>
                <option>Tahun Ini</option>
            </select>
        </div>

        <div class="row mb-4 g-3">
            <div class="col-md-3">
                <div class="stat-card-clean shadow-sm">
                    <span class="text-muted small">Total Pengajuan</span>
                    <h3 class="stat-val">348</h3>
                    <span class="text-green-small">+5% dari bulan lalu</span>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card-clean shadow-sm">
                    <span class="text-muted small">Tingkat Persetujuan</span>
                    <h3 class="stat-val" style="color: #198754;">65%</h3>
                    <span class="stat-desc">227 dari 348 pengajuan</span>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card-clean shadow-sm">
                    <span class="text-muted small">Rata-rata Proses</span>
                    <h3 class="stat-val" style="color: #ffc107;">2.3 hari</h3>
                    <span class="stat-desc">Waktu review</span>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card-clean shadow-sm">
                    <span class="text-muted small">Menunggu</span>
                    <h3 class="stat-val" style="color: #0d6efd;">67</h3>
                    <span class="stat-desc">20% dari total</span>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-6">
                <div class="chart-card shadow-sm">
                    <h6 class="chart-title">Status Pengajuan</h6>
                    
                    <div class="progress-label">
                        <span>Disetujui</span> <span class="text-danger-bold">227</span>
                    </div>
                    <div class="progress progress-custom">
                        <div class="progress-bar bg-success" role="progressbar" style="width: 65%"></div>
                    </div>
                    <small class="text-muted d-block mb-3" style="margin-top: -15px;">65%</small>

                    <div class="progress-label">
                        <span>Ditolak</span> <span class="text-danger-bold">54</span>
                    </div>
                    <div class="progress progress-custom">
                        <div class="progress-bar bg-danger" role="progressbar" style="width: 15%"></div>
                    </div>
                    <small class="text-muted d-block mb-3" style="margin-top: -15px;">15%</small>

                    <div class="progress-label">
                        <span>Diproses</span> <span class="text-danger-bold">67</span>
                    </div>
                    <div class="progress progress-custom">
                        <div class="progress-bar bg-warning" role="progressbar" style="width: 20%"></div>
                    </div>
                    <small class="text-muted d-block mb-3" style="margin-top: -15px;">20%</small>
                </div>
            </div>

            <div class="col-md-6">
                <div class="chart-card shadow-sm">
                    <h6 class="chart-title">Distribusi Jenis Cuti</h6>
                    <div style="height: 250px; display: flex; justify-content: center;">
                        <canvas id="jenisCutiChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="chart-card shadow-sm p-0 overflow-hidden">
            <div class="p-4 pb-2">
                <h6 class="chart-title mb-0">Statistik Detail per Unit</h6>
            </div>
            <div class="table-responsive">
                <table class="table table-custom mb-0">
                    <thead>
                        <tr>
                            <th>Unit Kerja</th>
                            <th class="text-center">Disetujui</th>
                            <th class="text-center">Ditolak</th>
                            <th class="text-center">Diproses</th>
                            <th class="text-center">Total</th>
                            <th class="text-end">Tingkat Persetujuan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>SMP Negeri 1</td>
                            <td class="text-center"><span class="badge-num bg-light-green">45</span></td>
                            <td class="text-center"><span class="badge-num bg-light-red">8</span></td>
                            <td class="text-center"><span class="badge-num bg-light-yellow">6</span></td>
                            <td class="text-center">59</td>
                            <td class="text-end text-danger-bold">76.3%</td>
                        </tr>
                        <tr>
                            <td>SMP Negeri 2</td>
                            <td class="text-center"><span class="badge-num bg-light-green">38</span></td>
                            <td class="text-center"><span class="badge-num bg-light-red">5</span></td>
                            <td class="text-center"><span class="badge-num bg-light-yellow">4</span></td>
                            <td class="text-center">47</td>
                            <td class="text-end text-danger-bold">80.9%</td>
                        </tr>
                        <tr>
                            <td>SMP Negeri 3</td>
                            <td class="text-center"><span class="badge-num bg-light-green">42</span></td>
                            <td class="text-center"><span class="badge-num bg-light-red">7</span></td>
                            <td class="text-center"><span class="badge-num bg-light-yellow">8</span></td>
                            <td class="text-center">57</td>
                            <td class="text-end text-danger-bold">73.7%</td>
                        </tr>
                        <tr>
                            <td>SMP Negeri 4</td>
                            <td class="text-center"><span class="badge-num bg-light-green">35</span></td>
                            <td class="text-center"><span class="badge-num bg-light-red">6</span></td>
                            <td class="text-center"><span class="badge-num bg-light-yellow">5</span></td>
                            <td class="text-center">46</td>
                            <td class="text-end text-danger-bold">76.1%</td>
                        </tr>
                        <tr>
                            <td>SMP Negeri 5</td>
                            <td class="text-center"><span class="badge-num bg-light-green">67</span></td>
                            <td class="text-center"><span class="badge-num bg-light-red">28</span></td>
                            <td class="text-center"><span class="badge-num bg-light-yellow">38</span></td>
                            <td class="text-center">133</td>
                            <td class="text-end text-danger-bold">50.4%</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Inisialisasi Pie Chart
        const ctx = document.getElementById('jenisCutiChart').getContext('2d');
        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Cuti Tahunan', 'Izin', 'Cuti Sakit', 'Cuti Khusus'],
                datasets: [{
                    data: [45, 25, 20, 10], // Data dummy sesuai proporsi gambar
                    backgroundColor: [
                        '#198754', // Hijau (Cuti Tahunan)
                        '#ffc107', // Kuning (Izin)
                        '#dc3545', // Merah (Cuti Sakit)
                        '#0d6efd'  // Biru (Cuti Khusus)
                    ],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { usePointStyle: true, boxWidth: 8, padding: 20 }
                    }
                }
            }
        });
    </script>
</body>
</html>