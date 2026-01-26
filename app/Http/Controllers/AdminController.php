<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\LeaveRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

// Export
use App\Exports\LaporanExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class AdminController extends Controller
{
    /* =====================================================
     * 1. DOWNLOAD LAPORAN
     * ===================================================== */

    public function downloadExcel(Request $request)
    {
        return Excel::download(
            new LaporanExport($request),
            'laporan_cuti.xlsx'
        );
    }

    public function downloadPdf(Request $request)
    {
        $query = LeaveRequest::with('user');

        if ($request->filled(['start_date', 'end_date'])) {
            $query->whereBetween('start_date', [
                $request->start_date,
                $request->end_date
            ]);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $data = $query->get();

        return Pdf::loadView('admin.laporan_pdf', compact('data'))
            ->download('laporan_cuti.pdf');
    }

    /* =====================================================
     * 2. DASHBOARD ADMIN (SAFE + OPTIMIZED)
     * ===================================================== */

    public function dashboard()
    {
        $totalPegawai = User::where('role', 'user')->count();
        $listPegawai  = User::where('role', 'user')->orderBy('name')->get();

        /**
         * SAFETY NET
         * Kalau migration belum dijalankan
         */
        if (!Schema::hasTable('leave_requests')) {
            return view('admin.dashboard_admin', [
                'totalPengajuan' => 0,
                'disetujui' => 0,
                'menunggu' => 0,
                'ditolak' => 0,
                'totalPegawai' => $totalPegawai,
                'pendingRequests' => collect(),
                'recentActivities' => collect(),
                'listPegawai' => $listPegawai,
                'chartLabels' => [],
                'dataApproved' => [],
                'dataRejected' => [],
                'dataPending' => [],
            ]);
        }

        /* =====================
         * A. STATISTIK KARTU
         * ===================== */
        $stats = LeaveRequest::selectRaw("
                COUNT(*) as total,
                SUM(status = 'approved') as approved,
                SUM(status = 'pending') as pending,
                SUM(status = 'rejected') as rejected
            ")->first();

        /* =====================
         * B. PENDING TERBARU
         * ===================== */
        $pendingRequests = LeaveRequest::with('user')
            ->where('status', 'pending')
            ->latest()
            ->limit(5)
            ->get();

        /* =====================
         * C. AKTIVITAS TERAKHIR
         * ===================== */
        $recentActivities = LeaveRequest::with('user')
            ->latest('updated_at')
            ->limit(3)
            ->get();

        /* =====================
         * D. GRAFIK 6 BULAN (1 QUERY)
         * ===================== */
        $start = Carbon::now()->subMonths(5)->startOfMonth();

        $chartRaw = LeaveRequest::selectRaw("
                YEAR(start_date) as year,
                MONTH(start_date) as month,
                SUM(status = 'approved') as approved,
                SUM(status = 'rejected') as rejected,
                SUM(status = 'pending') as pending
            ")
            ->where('start_date', '>=', $start)
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get()
            ->keyBy(fn ($row) => "{$row->year}-{$row->month}");

        $chartLabels = [];
        $dataApproved = [];
        $dataRejected = [];
        $dataPending  = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $key  = $date->year . '-' . $date->month;

            $chartLabels[] = $date->translatedFormat('M');

            $dataApproved[] = $chartRaw[$key]->approved ?? 0;
            $dataRejected[] = $chartRaw[$key]->rejected ?? 0;
            $dataPending[]  = $chartRaw[$key]->pending ?? 0;
        }

        return view('admin.dashboard_admin', [
            'totalPengajuan' => $stats->total,
            'disetujui' => $stats->approved,
            'menunggu' => $stats->pending,
            'ditolak' => $stats->rejected,
            'totalPegawai' => $totalPegawai,
            'pendingRequests' => $pendingRequests,
            'recentActivities' => $recentActivities,
            'listPegawai' => $listPegawai,
            'chartLabels' => $chartLabels,
            'dataApproved' => $dataApproved,
            'dataRejected' => $dataRejected,
            'dataPending' => $dataPending,
        ]);
    }

    /* =====================================================
     * 3. DETAIL & UPDATE STATUS
     * ===================================================== */

    public function show($id)
    {
        $pengajuan = LeaveRequest::with('user')->findOrFail($id);
        return view('admin.detail_pengajuan', compact('pengajuan'));
    }

    public function updateStatus($id, Request $request)
    {
        $validated = $request->validate([
            'status' => 'required|in:approved,pending,rejected',
            'rejection_reason' => 'nullable|string'
        ]);

        $pengajuan = LeaveRequest::findOrFail($id);

        $pengajuan->status = $validated['status'];
        $pengajuan->rejection_reason =
            $validated['status'] === 'rejected'
                ? $validated['rejection_reason']
                : null;

        $pengajuan->save();

        return back()->with('success', 'Keputusan berhasil disimpan!');
    }

    public function kelolaPengajuan(Request $request)
    {
        // 1. Siapkan Query
        $query = LeaveRequest::with('user');

        // 2. Logika Pencarian (Nama atau NIP)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nip', 'like', "%{$search}%");
            });
        }

        // 3. Logika Filter Status
        if ($request->filled('status') && $request->status !== 'Semua') {
            $query->where('status', $request->status);
        }

        // 4. Ambil data dengan Pagination (10 data per halaman)
        // 'latest()' sama dengan orderBy('created_at', 'desc')
        $pengajuan = $query->latest()->paginate(10); 

        return view('admin.kelola_pengajuan', compact('pengajuan'));
    }
}
