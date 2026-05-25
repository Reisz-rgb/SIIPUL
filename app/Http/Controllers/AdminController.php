<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\LeaveRequest;
use App\Models\LeaveBalance;
use App\Exports\LaporanExport;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class AdminController extends Controller
{
    // =========================================================================
    // CONSTANTS
    // =========================================================================

    private const FILTER_PERIODS = [
        '1_bulan'  => ['months' => 1,  'label' => '1 Bulan Terakhir'],
        '3_bulan'  => ['months' => 3,  'label' => '3 Bulan Terakhir'],
        'tahun_ini' => ['year_start' => true, 'label' => null], // label dinamis
    ];

    // =========================================================================
    // DOWNLOAD LAPORAN
    // =========================================================================

    public function downloadExcel(Request $request)
    {
        return Excel::download(new LaporanExport($request), 'laporan_cuti.xlsx');
    }

    public function downloadPdf(Request $request)
    {
        [$startDate, $titlePeriode] = $this->resolvePeriodFilter($request->input('filter', '1_bulan'));

        $data = LeaveRequest::with('user')
            ->where('created_at', '>=', $startDate)
            ->when($request->filled('search'), fn ($q) =>
                $q->whereHas('user', fn ($u) => $u->where('name', 'LIKE', "%{$request->search}%"))
            )
            ->when($request->filled('bidang_unit'), fn ($q) =>
                $q->whereHas('user', fn ($u) => $u->where('bidang_unit', $request->bidang_unit))
            )
            ->get();

        return Pdf::loadView('admin.laporan_pdf', compact('data', 'titlePeriode'))
            ->download('laporan_cuti.pdf');
    }

    public function downloadLampiran($id)
    {
        $pengajuan = LeaveRequest::findOrFail($id);

        if (!$pengajuan->file_path) {
            return back()->with('error', 'Tidak ada lampiran untuk pengajuan ini.');
        }

        abort_unless(
            Storage::disk('private')->exists($pengajuan->file_path),
            404,
            'File lampiran tidak ditemukan.'
        );

        return Storage::disk('private')->download(
            $pengajuan->file_path,
            basename($pengajuan->file_path)
        );
    }

    // =========================================================================
    // DASHBOARD
    // =========================================================================

    public function dashboard()
    {
        $totalPegawai = User::where('role', 'user')->count();
        $listPegawai  = User::where('role', 'user')->orderBy('name')->get();

        $pendingActivation = User::where('role', 'user')
            ->where('status', 'nonaktif')
            ->latest()
            ->get();

        if (!Schema::hasTable('leave_requests')) {
            return $this->dashboardEmptyResponse($totalPegawai, $listPegawai, $pendingActivation);
        }

        $stats            = $this->getLeaveStats();
        $pendingRequests  = $this->getLatestPendingRequests();
        $recentActivities = $this->getRecentActivities();
        [$chartLabels, $dataApproved, $dataRejected, $dataPending] = $this->getChartData();

        return view('admin.dashboard_admin', [
            'totalPengajuan'    => $stats->total,
            'disetujui'         => $stats->approved,
            'menunggu'          => $stats->pending,
            'ditolak'           => $stats->rejected,
            'totalPegawai'      => $totalPegawai,
            'pendingRequests'   => $pendingRequests,
            'recentActivities'  => $recentActivities,
            'listPegawai'       => $listPegawai,
            'chartLabels'       => $chartLabels,
            'dataApproved'      => $dataApproved,
            'dataRejected'      => $dataRejected,
            'dataPending'       => $dataPending,
            'pendingActivation' => $pendingActivation,
        ]);
    }

    // =========================================================================
    // KELOLA PENGAJUAN
    // =========================================================================

    public function kelolaPengajuan(Request $request)
    {
        $pengajuan = LeaveRequest::with('user')
            ->when($request->filled('search'), fn ($q) =>
                $q->whereHas('user', fn ($u) =>
                    $u->where('name', 'like', "%{$request->search}%")
                      ->orWhere('nip', 'like', "%{$request->search}%")
                )
            )
            ->when(
                $request->filled('status') && $request->status !== 'Semua',
                fn ($q) => $q->where('status', $request->status)
            )
            ->latest()
            ->paginate(10);

        return view('admin.kelola_pengajuan', compact('pengajuan'));
    }

    public function show($id)
    {
        $pengajuan = LeaveRequest::with('user')->findOrFail($id);
        return view('admin.detail_pengajuan', compact('pengajuan'));
    }

    public function updateStatus($id, Request $request)
    {
        $validated = $request->validate([
            'status'           => 'required|in:approved,pending,rejected',
            'rejection_reason' => 'nullable|string',
        ]);

        DB::transaction(function () use ($id, $validated) {
            $pengajuan = LeaveRequest::lockForUpdate()->findOrFail($id);
            
            $pengajuan->update([
                'status'           => $validated['status'],
                'rejection_reason' => $validated['rejection_reason'] ?? null,
            ]);

            $this->syncAnnualLeaveBalance($pengajuan);
        });

        return back()->with('success', 'Keputusan berhasil disimpan!');
    }

    // =========================================================================
    // LAPORAN & ANALYTICS
    // =========================================================================

    public function laporan(Request $request)
    {
        // 1. Inisialisasi Query Dasar (Menggunakan $baseQuery agar sinkron)
        $baseQuery = LeaveRequest::query()->with('user');

        // 2. Ambil Input Filter (Default ke 'tahun_ini' jika tidak ada)
        $filter = $request->input('filter', 'tahun_ini');

        // 3. Logic Filter Berdasarkan Periode Waktu
        if ($filter == '1_bulan') {
            $baseQuery->where('created_at', '>=', now()->subMonth());
            $labelWaktu = '1 Bulan Terakhir';
        } elseif ($filter == '3_bulan') {
            $baseQuery->where('created_at', '>=', now()->subMonths(3));
            $labelWaktu = '3 Bulan Terakhir';
        } elseif ($filter == '6_bulan') {
            $baseQuery->where('created_at', '>=', now()->subMonths(6));
            $labelWaktu = '6 Bulan Terakhir';
        } elseif ($filter == 'tahun_ini') {
            $baseQuery->where('created_at', '>=', now()->startOfYear());
            $labelWaktu = 'Tahun Ini (Jan - Des)';
        } elseif ($filter == 'tahun_lalu') {
            $baseQuery->whereBetween('created_at', [
                now()->subYear()->startOfYear(),
                now()->subYear()->endOfYear()
            ]);
            $labelWaktu = 'Tahun Lalu';
        } else {
            $labelWaktu = 'Semua Periode';
        }

        // 4. Filter Berdasarkan Pencarian Nama Pegawai
        if ($request->filled('search')) {
            $search = $request->search;
            $baseQuery->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%");
            });
        }

        // 5. Filter Berdasarkan Bidang / Unit Kerja
        if ($request->filled('bidang_unit')) {
            $bidang = $request->bidang_unit;
            $baseQuery->whereHas('user', function ($q) use ($bidang) {
                $q->where('bidang_unit', $bidang);
            });
        }

        // 6. Eksekusi Query untuk Mengambil Data yang Sudah Terfilter
        $filteredData = $baseQuery->get();

        // 7. Hitung Statistik Utama (Angka Card Dashboard akan ikut dinamis)
        $total = $filteredData->count();
        $approved = $filteredData->where('status', 'approved')->count();
        $rejected = $filteredData->where('status', 'rejected')->count();
        $pending = $filteredData->where('status', 'pending')->count();

        // Hitung Persentase (Aman dari pembagian dengan angka nol)
        $persenApproved = $total > 0 ? round(($approved / $total) * 100) : 0;
        $persenRejected = $total > 0 ? round(($rejected / $total) * 100) : 0;
        $persenPending  = $total > 0 ? round(($pending / $total) * 100) : 0;

        // 8. Hitung Rata-Rata Durasi Proses Peninjauan (Selisih created_at sampai updated_at untuk status approved/rejected)
        $processedLeaves = $filteredData->whereIn('status', ['approved', 'rejected']);
        $totalDays = 0;
        $processedCount = $processedLeaves->count();

        foreach ($processedLeaves as $leave) {
            // Menghitung selisih hari dari pengajuan dibuat hingga disetujui/ditolak admin
            $totalDays += $leave->created_at->diffInDays($leave->updated_at);
        }
        $avgDays = $processedCount > 0 ? round($totalDays / $processedCount, 1) : 0;

        // 9. Statistik untuk Distribusi Grafik Jenis Cuti (Doughnut Chart)
        $jenisCutiGroup = $filteredData->groupBy('jenis_cuti');
        $chartLabels = [];
        $chartValues = [];

        foreach ($jenisCutiGroup as $jenis => $items) {
            $chartLabels[] = $jenis ?? 'Lainnya';
            $chartValues[] = $items->count();
        }

        // 10. Statistik Detail per Unit Kerja / Bidang untuk Tabel Bawah
        $unitStats = [];
        // Kelompokkan data berdasarkan bidang_unit milik relasi user
        $groupedByUnit = $filteredData->groupBy(function ($leave) {
            return $leave->user->bidang_unit ?? 'Tanpa Bidang / Eksternal';
        });

        foreach ($groupedByUnit as $unitName => $leaves) {
            $unitTotal = $leaves->count();
            $unitApproved = $leaves->where('status', 'approved')->count();
            $unitRejected = $leaves->where('status', 'rejected')->count();
            $unitPending = $leaves->where('status', 'pending')->count();
            
            $unitStats[] = [
                'name' => $unitName,
                'approved' => $unitApproved,
                'rejected' => $unitRejected,
                'pending' => $unitPending,
                'total' => $unitTotal,
                'rate' => $unitTotal > 0 ? round(($unitApproved / $unitTotal) * 100) : 0
            ];
        }

        // Urutkan tabel unit kerja berdasarkan jumlah pengajuan terbanyak
        usort($unitStats, function ($a, $b) {
            return $b['total'] <=> $a['total'];
        });

        // 11. Ambil Semua Daftar Bidang/Unit Unik untuk Isi Dropdown Filter
        $listBidang = User::whereNotNull('bidang_unit')
            ->where('bidang_unit', '!=', '')
            ->distinct()
            ->pluck('bidang_unit')
            ->toArray();

        // 12. Kembalikan data ke View Laporan
        return view('admin.laporan', compact(
            'total', 
            'approved', 
            'rejected', 
            'pending',
            'persenApproved', 
            'persenRejected', 
            'persenPending',
            'labelWaktu', 
            'avgDays', 
            'unitStats', 
            'chartLabels', 
            'chartValues', 
            'listBidang'
        ));
    }

    public function downloadAllExcel()
    {
        // Membuat objek request baru khusus dengan parameter mode = all_data
        $requestAll = new Request(['mode' => 'all_data']);
        
        return Excel::download(new LaporanExport($requestAll), 'rekap_semua_pengajuan_cuti.xlsx');
    }

    public function downloadAllPdf(Request $request)
    {
        // Tarik seluruh data pengajuan cuti tanpa batasan created_at atau user filter
        $data = LeaveRequest::with('user')
            ->orderBy('created_at', 'desc')
            ->get();

        $titlePeriode = "Semua Periode (Keseluruhan)";

        return Pdf::loadView('admin.laporan_pdf', compact('data', 'titlePeriode'))
            ->setPaper('a4', 'landscape')
            ->download('rekap_semua_pengajuan_cuti.pdf');
    }

    // =========================================================================
    // PRIVATE HELPERS
    // =========================================================================

    /**
     * Resolve filter periode → [Carbon $startDate, string $label]
     */
    private function resolvePeriodFilter(string $filter): array
    {
        return match ($filter) {
            '1_bulan'  => [Carbon::now()->subMonth(),      '1 Bulan Terakhir'],
            '3_bulan'  => [Carbon::now()->subMonths(3),    '3 Bulan Terakhir'],
            default    => [Carbon::now()->startOfYear(),   'Tahun Ini (' . date('Y') . ')'],
        };
    }

    public function activateUser(int $id)
    {
        $user = User::where('role', 'user')->findOrFail($id);
        $user->update(['status' => 'aktif']);

        return back()->with('success', "Akun {$user->name} berhasil diaktifkan.");
    }

    /**
     * Hitung persentase, safe dari division by zero.
     */
    private function percentage(int $part, int $total): float
    {
        return $total > 0 ? round(($part / $total) * 100, 1) : 0;
    }

    /**
     * Sinkronkan saldo cuti tahunan.
     */
    private function syncAnnualLeaveBalance(LeaveRequest $pengajuan): void
    {
        if (! $pengajuan->isAnnualLeave()) {
            return;
        }

        // Pastikan hanya admin/authorized role yang sampai ke sini
        // Gate check ada di middleware route, bukan di sini
        $year = $pengajuan->start_date->year;
        LeaveBalance::recalculateAnnualBalances((int) $pengajuan->user_id, $year);
    }

    /**
     * Aggregate statistik leave request (total, approved, pending, rejected).
     */
    private function getLeaveStats()
    {
        return LeaveRequest::selectRaw("
            COUNT(*) as total,
            SUM(status = 'approved') as approved,
            SUM(status = 'pending')  as pending,
            SUM(status = 'rejected') as rejected
        ")->first();
    }

    private function getLatestPendingRequests(int $limit = 5)
    {
        return LeaveRequest::with('user')
            ->where('status', 'pending')
            ->latest()
            ->limit($limit)
            ->get();
    }

    private function getRecentActivities(int $limit = 3)
    {
        return LeaveRequest::with('user')
            ->latest('updated_at')
            ->limit($limit)
            ->get();
    }

    /**
     * Bangun data grafik 6 bulan terakhir.
     * Returns [$labels, $approved, $rejected, $pending]
     */
    private function getChartData(): array
    {
        $start = Carbon::now()->subMonths(5)->startOfMonth();

        $chartRaw = LeaveRequest::selectRaw("
                YEAR(start_date)  as year,
                MONTH(start_date) as month,
                SUM(status = 'approved') as approved,
                SUM(status = 'rejected') as rejected,
                SUM(status = 'pending')  as pending
            ")
            ->where('start_date', '>=', $start)
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get()
            ->keyBy(fn ($row) => "{$row->year}-{$row->month}");

        $labels   = [];
        $approved = [];
        $rejected = [];
        $pending  = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $key  = "{$date->year}-{$date->month}";

            $labels[]   = $date->translatedFormat('M');
            $approved[] = $chartRaw[$key]->approved ?? 0;
            $rejected[] = $chartRaw[$key]->rejected ?? 0;
            $pending[]  = $chartRaw[$key]->pending  ?? 0;
        }

        return [$labels, $approved, $rejected, $pending];
    }

    /**
     * Response dashboard kosong saat tabel belum ada.
     */
    private function dashboardEmptyResponse(int $totalPegawai, $listPegawai, $pendingActivation)
    {
        return view('admin.dashboard_admin', [
            'totalPengajuan'   => 0,
            'disetujui'        => 0,
            'menunggu'         => 0,
            'ditolak'          => 0,
            'totalPegawai'     => $totalPegawai,
            'pendingRequests'  => collect(),
            'recentActivities' => collect(),
            'listPegawai'      => $listPegawai,
            'chartLabels'      => [],
            'dataApproved'     => [],
            'dataRejected'     => [],
            'dataPending'      => [],
            'pendingActivation' => $pendingActivation ?? collect(),
        ]);
    }
}