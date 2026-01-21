<?php

namespace App\Http\Controllers;

use App\Models\Cuti;
use Illuminate\Http\Request;

class CutiController extends Controller
{
    public function show($id)
    {
        // Ambil data cuti beserta user-nya
        $pengajuan = Cuti::with('user')->findOrFail($id);
        return view('admin.detail_pengajuan', compact('pengajuan'));
    }

    public function updateStatus(Request $request, $id)
    {
        $cuti = Cuti::findOrFail($id);

        // Mapping Keputusan Form ke Enum Database
        // Form Anda mungkin mengirim: 'disetujui', 'tidak_disetujui'
        // Tabel Anda menerima: 'disetujui', 'ditolak', 'pending'
        
        $statusBaru = 'pending';
        if ($request->keputusan == 'disetujui') {
            $statusBaru = 'disetujui';
        } elseif ($request->keputusan == 'tidak_disetujui') {
            $statusBaru = 'ditolak';
        }

        $cuti->status = $statusBaru;
        
        // Jika ada pertimbangan/alasan penolakan
        if ($request->has('pertimbangan')) {
            $cuti->keterangan_penolakan = $request->pertimbangan; // Simpan ke kolom keterangan_penolakan
        }

        $cuti->save();

        return response()->json(['message' => 'Status berhasil diperbarui']);
    }
}