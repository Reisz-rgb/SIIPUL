@extends('layouts.admin')
@section('title', 'Dashboard Admin - SIIPUL')

@push('styles')
<style>
    /* --- 1. CORE VARIABLES & LAYOUT (SAMA PERSIS KELOLA PEGAWAI) --- */
    :root {
        --primary: #9E2A2B;         
        --primary-dark: #781F1F;    
        --secondary: #64748B;
        --bg-body: #F1F5F9;         
        --sidebar-width: 270px;
    }

    body {
        font-family: 'Plus Jakarta Sans', sans-serif;
        background-color: var(--bg-body);
        color: #334155;
        overflow-x: hidden;
    }

    /* Custom Scrollbar */
    ::-webkit-scrollbar { width: 6px; height: 6px; }
    ::-webkit-scrollbar-track { background: transparent; }
    ::-webkit-scrollbar-thumb { background: #CBD5E1; border-radius: 10px; }
    ::-webkit-scrollbar-thumb:hover { background: #94A3B8; }

    /* --- SIDEBAR & OVERLAY --- */
    .sidebar {
        width: var(--sidebar-width);
        height: 100vh;
        position: fixed;
        background: #FFFFFF;
        border-right: 1px dashed #E2E8F0;
        z-index: 1050; /* Z-index disamakan */
        padding: 24px;
        display: flex; flex-direction: column;
        transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* --- HERO BANNER (MERAH) --- */
    .hero-banner {
        background: linear-gradient(135deg, var(--primary) 0%, #561616 100%);
        height: 280px; /* TINGGI SAMA */
        padding: 40px;
        color: white;
        border-bottom-left-radius: 30px;
        border-bottom-right-radius: 30px;
        position: relative;
        z-index: 1;
    }

    .glass-profile {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        padding: 8px 16px;
        border-radius: 50px;
        color: white;
        display: flex; align-items: center; gap: 12px;
        cursor: pointer;
        transition: 0.2s;
    }
    .glass-profile:hover { background: rgba(255, 255, 255, 0.2); }

    /* --- DASHBOARD CONTAINER (PUTIH) --- */
    .dashboard-container {
        padding: 0 40px 40px 40px; /* PADDING SAMA */
        margin-top: -80px;         /* OVERLAP SAMA */
        position: relative;
        z-index: 2;
    }

    /* --- CARD STYLES --- */
    .card-stat {
        background: white;
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.06);
        border: 1px solid #F1F5F9;
        height: 100%;
        display: flex; flex-direction: column; justify-content: space-between;
        transition: transform 0.2s;
    }
    .card-stat:hover { transform: translateY(-5px); }

    .card-content {
        background: white;
        border-radius: 16px;
        border: 1px solid #F1F5F9;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.06);
        overflow: hidden;
        height: 100%;
    }

    .card-header-custom {
        padding: 24px;
        border-bottom: 1px dashed #E2E8F0;
        background: #fff;
        display: flex; align-items: center; justify-content: space-between;
    }

    .stat-icon {
        width: 48px; height: 48px; border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.5rem; margin-bottom: 16px;
    }

    .list-item-custom {
        padding: 16px 24px; border-bottom: 1px solid #F1F5F9;
    }
    .list-item-custom:last-child { border-bottom: none; }

    /* Mobile Responsive */
    .mobile-toggler { display: none; color: white; font-size: 1.5rem; background: none; border: none; margin-right: 15px; }

    @media (max-width: 992px) {
        .hero-banner { padding: 20px; height: auto; padding-bottom: 100px; }
        .dashboard-container { padding: 0 20px 20px; }
        .mobile-toggler { display: block; }
    }
</style>
@endpush

@section('content')
    <div class="hero-banner">
        <div class="d-flex justify-content-between align-items-start">
            <div class="d-flex align-items-center">
                <button class="mobile-toggler">
                    <i class="bi bi-list"></i>
                </button>
                <div>
                    <div class="text-white text-opacity-75 small mb-1 fw-medium">
                        Admin <i class="bi bi-chevron-right mx-1" style="font-size: 0.7rem"></i> Overview
                    </div>
                    <h2 class="fw-bold m-0 text-white">Dashboard Overview</h2>
                </div>
            </div>
            
            <div class="dropdown">
                <div class="glass-profile" data-bs-toggle="dropdown">
                    <div class="rounded-circle bg-white text-danger fw-bold d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                        {{ substr(Auth::user()->name ?? 'A', 0, 1) }}
                    </div>
                    <span class="d-none d-md-block small fw-medium">{{ Auth::user()->name ?? 'Admin' }}</span>
                    <i class="bi bi-chevron-down small d-none d-md-block"></i>
                </div>
                 <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 mt-2 p-2 rounded-3">
                    <li><a class="dropdown-item rounded small" href="#">Profile Saya</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item rounded small text-danger">Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="dashboard-container">
        
        <div class="row g-4 mb-4">
            <div class="col-12 col-sm-6 col-xl-3">
                <div class="card-stat">
                    <div>
                        <div class="stat-icon" style="background: #EFF6FF; color: #3B82F6;">
                            <i class="bi bi-files"></i>
                        </div>
                        <div class="text-muted small fw-bold text-uppercase">Total Pengajuan</div>
                        <div class="fs-2 fw-bold text-dark mt-1">{{ $totalPengajuan ?? 0 }}</div>
                    </div>
                    <div class="small text-muted mt-3 pt-3 border-top border-light">
                        <i class="bi bi-calendar me-1"></i> Sepanjang waktu
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-xl-3">
                <div class="card-stat">
                    <div>
                        <div class="stat-icon" style="background: #F0FDF4; color: #16A34A;">
                            <i class="bi bi-check-lg"></i>
                        </div>
                        <div class="text-muted small fw-bold text-uppercase">Disetujui</div>
                        <div class="fs-2 fw-bold text-dark mt-1">{{ $disetujui ?? 0 }}</div>
                    </div>
                    <div class="small text-success mt-3 pt-3 border-top border-light">
                        <i class="bi bi-graph-up-arrow me-1"></i> Sukses
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-xl-3">
                <div class="card-stat">
                    <div>
                        <div class="stat-icon" style="background: #FFF7ED; color: #EA580C;">
                            <i class="bi bi-hourglass-split"></i>
                        </div>
                        <div class="text-muted small fw-bold text-uppercase">Perlu Review</div>
                        <div class="fs-2 fw-bold text-dark mt-1">{{ $menunggu ?? 0 }}</div>
                    </div>
                    <div class="small text-warning mt-3 pt-3 border-top border-light">
                        <i class="bi bi-exclamation-circle me-1"></i> Menunggu
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-xl-3">
                <div class="card-stat">
                    <div>
                        <div class="stat-icon" style="background: #FEF2F2; color: #DC2626;">
                            <i class="bi bi-x-octagon"></i>
                        </div>
                        <div class="text-muted small fw-bold text-uppercase">Ditolak</div>
                        <div class="fs-2 fw-bold text-dark mt-1">{{ $ditolak ?? 0 }}</div>
                    </div>
                    <div class="small text-danger mt-3 pt-3 border-top border-light">
                        <i class="bi bi-arrow-down me-1"></i> Tidak disetujui
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card-content h-100">
                    <div class="card-header-custom">
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
                    <div class="card-header-custom">
                        <h6 class="m-0 fw-bold text-dark">
                            Menunggu Persetujuan
                            @if(isset($menunggu) && $menunggu > 0)
                                <span class="badge bg-danger rounded-pill ms-1">{{ $menunggu }}</span>
                            @endif
                        </h6>
                        <a href="{{ route('admin.kelola_pengajuan') }}" class="small text-decoration-none fw-bold" style="color: var(--primary);">Lihat Semua</a>
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

        <div class="mt-5 text-center pb-4">
            <p class="text-muted small opacity-50">&copy; 2026 Pemerintah Kabupaten Semarang. Hak Cipta Dilindungi.</p>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const ctx = document.getElementById('statsChart').getContext('2d');
        const labels = @json($chartLabels ?? ['Jan', 'Feb', 'Mar']);
        
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [
                    { label: 'Disetujui', data: @json($dataApproved ?? [0,0,0]), backgroundColor: '#16A34A', borderRadius: 6, barPercentage: 0.6 },
                    { label: 'Menunggu', data: @json($dataPending ?? [0,0,0]), backgroundColor: '#EA580C', borderRadius: 6, barPercentage: 0.6 },
                    { label: 'Ditolak', data: @json($dataRejected ?? [0,0,0]), backgroundColor: '#DC2626', borderRadius: 6, barPercentage: 0.6 }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { 
                    legend: { position: 'bottom', labels: { usePointStyle: true, padding: 20, boxWidth: 8, font: {family: "'Plus Jakarta Sans', sans-serif"} } },
                    tooltip: { backgroundColor: '#1e293b', padding: 12, cornerRadius: 8 }
                },
                scales: {
                    y: { beginAtZero: true, border: { display: false }, grid: { borderDash: [4, 4], color: '#f1f5f9' }, ticks: { font: { size: 11 } } },
                    x: { grid: { display: false }, ticks: { font: { size: 11 } } }
                }
            }
        });
    });
</script>
@endpush