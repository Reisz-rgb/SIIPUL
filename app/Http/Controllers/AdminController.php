<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\LeaveRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
// Import Library Excel & PDF
use App\Exports\LaporanExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class AdminController extends Controller
{
    // ==========================================
    // 1. FITUR DOWNLOAD LAPORAN
    // ==========================================
    
    public function downloadExcel(Request $request)
    {
        // Pastikan file app/Exports/LaporanExport.php nanti dibuat
        return Excel::download(new LaporanExport($request), 'laporan_cuti.xlsx');
    }

    public function downloadPdf(Request $request)
    {
        $query = LeaveRequest::with('user');
        
        // Filter Tanggal
        if ($request->start_date && $request->end_date) {
            $query->whereBetween('start_date', [$request->start_date, $request->end_date]);
        }
        // Filter Status
        if ($request->status) {
            $query->where('status', $request->status);
        }
        
        $data = $query->get();

        // Pastikan file resources/views/admin/laporan_pdf.blade.php nanti dibuat
        $pdf = Pdf::loadView('admin.laporan_pdf', compact('data'));
        return $pdf->download('laporan_cuti.pdf');
    }

    // ==========================================
    // 2. DASHBOARD ADMIN
    // ==========================================

    public function dashboard()
    {
        // A. DATA KARTU STATISTIK
        $totalPengajuan = LeaveRequest::count();
        $disetujui      = LeaveRequest::where('status', 'approved')->count();
        $menunggu       = LeaveRequest::where('status', 'pending')->count();
        $ditolak        = LeaveRequest::where('status', 'rejected')->count();
        $totalPegawai   = User::where('role', 'user')->count();

        // B. DATA LIST MENUNGGU (5 Teratas)
        $pendingRequests = LeaveRequest::with('user')
                            ->where('status', 'pending')
                            ->orderBy('created_at', 'desc')
                            ->take(5)
                            ->get();

        // C. DATA LIST PEGAWAI (Untuk Dropdown Filter Laporan)
        $listPegawai = User::where('role', 'user')->orderBy('name')->get();

        // D. GRAFIK 6 BULAN TERAKHIR
        $chartLabels = [];
        $dataApproved = [];
        $dataRejected = [];
        $dataPending = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $monthName = $date->translatedFormat('M'); 
            $year = $date->year;
            $month = $date->month;

            array_push($chartLabels, $monthName);

            $dataApproved[] = LeaveRequest::whereYear('start_date', $year)
                                ->whereMonth('start_date', $month)
                                ->where('status', 'approved')->count();
            
            $dataRejected[] = LeaveRequest::whereYear('start_date', $year)
                                ->whereMonth('start_date', $month)
                                ->where('status', 'rejected')->count();

            $dataPending[] = LeaveRequest::whereYear('start_date', $year)
                                ->whereMonth('start_date', $month)
                                ->where('status', 'pending')->count();
        }

        // E. AKTIVITAS TERAKHIR
        $recentActivities = LeaveRequest::with('user')
                            ->whereNotNull('updated_at')
                            ->orderBy('updated_at', 'desc')
                            ->take(3)
                            ->get();

        return view('admin.dashboard_admin', compact(
            'totalPengajuan', 'disetujui', 'menunggu', 'ditolak', 'totalPegawai',
            'pendingRequests', 'listPegawai', 'recentActivities',
            'chartLabels', 'dataApproved', 'dataRejected', 'dataPending'
        ));
    }

    // ==========================================
    // 3. DETAIL & PROSES PENGAJUAN
    // ==========================================

    public function show($id)
    {
        $pengajuan = LeaveRequest::with('user')->findOrFail($id);
        return view('admin.detail_pengajuan', compact('pengajuan'));
    }

    public function updateStatus($id, Request $request)
    {
        // Validasi input
        $request->validate([
            'status' => 'required|in:approved,pending,rejected',
            'rejection_reason' => 'nullable|string'
        ]);

        // Cari data
        $pengajuan = LeaveRequest::findOrFail($id);

        // Update status
        $pengajuan->status = $request->status;
        
        // Simpan alasan jika ditolak, reset jika disetujui
        if ($request->status == 'rejected') {
            $pengajuan->rejection_reason = $request->rejection_reason;
        } else {
            $pengajuan->rejection_reason = null;
        }

        $pengajuan->save();

        // Redirect kembali
        return redirect()->back()->with('success', 'Keputusan berhasil disimpan!');
    }
}