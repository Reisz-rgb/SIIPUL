@extends('layouts.admin')

@section('title', "Dashboard Admin - SIIPUL")

@section('hero_left')

<div>
                        <h2 class="fw-bold m-0 text-white">Dashboard Overview</h2>
                        <p class="text-white text-opacity-75 m-0 small mt-1">Pantau aktivitas cuti pegawai secara real-time.</p>

@endsection


@push('head')
<style>
/* Variables */
        :root {
            --primary: #9E2A2B;       /* Red Maroon */
            --primary-dark: #781F1F;  /* Dark Red */
            --secondary: #64748B;     /* Slate Grey */
            --bg-body: #F1F5F9;       /* Slate 100 */
            --sidebar-width: 270px;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-body);
            color: #334155;
            overflow-x: hidden; /* Prevent horizontal scroll */
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #CBD5E1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #94A3B8; }

        /* Sidebar */
        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            position: fixed;
            top: 0; left: 0;
            background: #FFFFFF;
            border-right: 1px dashed #E2E8F0;
            z-index: 1050; /* Di atas konten utama */
            padding: 24px;
            display: flex; flex-direction: column;
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .sidebar-brand {
            display: flex; align-items: center; gap: 12px; padding-bottom: 30px;
            text-decoration: none; color: var(--primary);
        }
        
        .nav-label {
            font-size: 0.7rem; font-weight: 700; color: #94A3B8;
            text-transform: uppercase; letter-spacing: 0.08em;
            margin: 20px 0 10px 12px;
        }

        .nav-link {
            display: flex; align-items: center; gap: 12px; padding: 12px 16px;
            color: #64748B; border-radius: 12px; font-weight: 500;
            transition: all 0.2s; margin-bottom: 4px; text-decoration: none;
        }

        .nav-link:hover { background-color: #FEF2F2; color: var(--primary); }

        /* Active State */
        .nav-link.active {
            background: linear-gradient(90deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            box-shadow: 0 4px 12px rgba(158, 42, 43, 0.3);
        }
        .nav-link.active i { color: white; }

        /* Main Layout */
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            transition: margin-left 0.3s ease-in-out;
        }

        /* Hero Banner */
        .hero-banner {
            background: linear-gradient(135deg, var(--primary) 0%, #561616 100%);
            height: 280px;
            padding: 40px;
            color: white;
            border-bottom-left-radius: 30px;
            border-bottom-right-radius: 30px;
        }

        /* Glass Profile */
        .glass-profile {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            padding: 8px 16px;
            border-radius: 50px;
            color: white;
            display: flex; align-items: center; gap: 12px;
            cursor: pointer; transition: 0.2s;
        }
        .glass-profile:hover { background: rgba(255, 255, 255, 0.2); }

        /* Cards & Widgets */
        .dashboard-container {
            padding: 0 40px 40px 40px;
            margin-top: -80px; /* Overlap */
        }

        .card-stat {
            background: white; border: none; border-radius: 16px;
            padding: 24px; box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.06);
            height: 100%; transition: transform 0.2s;
        }
        .card-stat:hover { transform: translateY(-5px); }

        .stat-icon {
            width: 48px; height: 48px; border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.4rem; margin-bottom: 16px;
        }

        .card-content {
            background: white; border-radius: 16px;
            border: 1px solid #F1F5F9;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.02);
            overflow: hidden;
        }
        .card-header-custom {
            padding: 24px; border-bottom: 1px dashed #E2E8F0;
            display: flex; justify-content: space-between; align-items: center;
        }

        .list-item-custom {
            padding: 16px 24px; border-bottom: 1px solid #F8FAFC;
            transition: background 0.1s;
        }
        .list-item-custom:hover { background-color: #FDFDFD; }

        /* Mobile UX */
        .mobile-toggler { 
            display: none; color: white; font-size: 1.5rem; 
            border: none; background: none; margin-right: 15px; 
        }
        
        #sidebarOverlay {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0, 0, 0, 0.5); z-index: 1040;
            display: none; backdrop-filter: blur(2px);
        }

        @media (max-width: 992px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.show { transform: translateX(0); }
            .main-content { margin-left: 0; }
            .hero-banner { border-radius: 0; padding: 20px; height: auto; padding-bottom: 100px; }
            .dashboard-container { padding: 0 20px 20px 20px; }
            .mobile-toggler { display: block; }
        }
</style>
@endpush


@section('content')
<div class="dashboard-container">
            <div class="row g-4 mb-4">
                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="card-stat">
                        <div class="stat-icon" style="background: #EFF6FF; color: #3B82F6;">
                            <i class="bi bi-files"></i>
                        </div>
                        <div class="text-muted small fw-bold text-uppercase">Total Pengajuan</div>
                        <div class="fs-2 fw-bold text-dark mt-1">{{ $totalPengajuan ?? 0 }}</div>
                        <div class="small text-muted mt-2"><i class="bi bi-calendar me-1"></i> Sepanjang waktu</div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="card-stat">
                        <div class="stat-icon" style="background: #F0FDF4; color: #16A34A;">
                            <i class="bi bi-check-lg"></i>
                        </div>
                        <div class="text-muted small fw-bold text-uppercase">Disetujui</div>
                        <div class="fs-2 fw-bold text-dark mt-1">{{ $disetujui ?? 0 }}</div>
                        <div class="small text-success mt-2"><i class="bi bi-graph-up-arrow me-1"></i> Sukses</div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="card-stat">
                        <div class="stat-icon" style="background: #FFF7ED; color: #EA580C;">
                            <i class="bi bi-hourglass-split"></i>
                        </div>
                        <div class="text-muted small fw-bold text-uppercase">Perlu Review</div>
                        <div class="fs-2 fw-bold text-dark mt-1">{{ $menunggu ?? 0 }}</div>
                        <div class="small text-warning mt-2"><i class="bi bi-exclamation-circle me-1"></i> Menunggu</div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="card-stat">
                        <div class="stat-icon" style="background: #FEF2F2; color: #DC2626;">
                            <i class="bi bi-x-octagon"></i>
                        </div>
                        <div class="text-muted small fw-bold text-uppercase">Ditolak</div>
                        <div class="fs-2 fw-bold text-dark mt-1">{{ $ditolak ?? 0 }}</div>
                        <div class="small text-danger mt-2">Tidak disetujui</div>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="card-content mb-4 h-100">
                        <div class="card-header-custom bg-white">
                            <h6 class="m-0 fw-bold text-dark">Statistik Bulanan</h6>
                            <button class="btn btn-sm btn-outline-light text-muted border">
                                <i class="bi bi-download me-1"></i> Report
                            </button>
                        </div>
                        <div class="p-4" style="height: 320px;">
                            <canvas id="statsChart"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card-content h-100">
                        <div class="card-header-custom bg-white">
                            <h6 class="m-0 fw-bold text-dark">
                                Menunggu Persetujuan
                                @if(isset($menunggu) && $menunggu > 0)
                                    <span class="badge bg-danger rounded-pill ms-1">{{ $menunggu }}</span>
                                @endif
                            </h6>
                            <a href="{{ route('admin.kelola_pengajuan') }}" class="small text-decoration-none fw-bold" style="color: var(--primary);">View All</a>
                        </div>
                        
                        <div class="list-group list-group-flush">
                            @forelse($pendingRequests ?? [] as $request)
                                <div class="list-item-custom d-flex gap-3 align-items-center">
                                    <div class="rounded-circle bg-light d-flex align-items-center justify-content-center flex-shrink-0" style="width: 42px; height: 42px; color: var(--secondary); font-weight: 700;">
                                        {{ substr(optional($request->user)->name ?? '?', 0, 1) }}
                                    </div>
                                    <div style="flex: 1; min-width: 0;">
                                        <div class="fw-bold text-dark text-truncate">{{ optional($request->user)->name ?? 'User Tidak Dikenal' }}</div>
                                        <div class="small text-muted">
                                            {{ $request->jenis_cuti }} &bull; {{ $request->duration }} Hari
                                        </div>
                                    </div>
                                    <div>
                                        <a href="{{ route('admin.pengajuan.show', $request->id) }}" class="btn btn-sm btn-light border text-secondary fw-medium rounded-pill px-3">Review</a>
                                    </div>
                                </div>
                            @empty
                                <div class="p-5 text-center">
                                    <i class="bi bi-clipboard-check fs-1 text-muted opacity-25"></i>
                                    <p class="text-muted small m-0 mt-2">Tidak ada pengajuan baru.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-5 text-center">
                <p class="text-muted small opacity-50">&copy; 2026 Pemerintah Kabupaten Semarang. Hak Cipta Dilindungi.</p>
            </div>
        </div>
    </div>
@endsection


@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush
