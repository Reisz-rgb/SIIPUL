<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PegawaiController extends Controller
{
    // 1. Menampilkan Daftar Pegawai
    public function index(Request $request)
    {
        // Fitur pencarian sederhana
        $query = User::where('role', 'user');

        if($request->has('search')){
            $query->where(function($q) use ($request){
                $q->where('name', 'LIKE', '%'.$request->search.'%')
                  ->orWhere('nip', 'LIKE', '%'.$request->search.'%');
            });
        }

        $pegawai = $query->latest()->paginate(10);
        return view('admin.kelola_pegawai', compact('pegawai'));
    }

    // 2. Menampilkan Form Tambah
    public function create()
    {
        return view('admin.tambah_pegawai'); 
    }

    // 3. Proses Simpan Data (SUDAH DIPERBAIKI)
    public function store(Request $request)
    {
        // A. Validasi (Sesuaikan nama dengan name="" di HTML)
        $request->validate([
            'name'        => 'required|string|max:255',
            'nip'         => 'required|numeric|unique:users,nip',
            'phone'       => 'required|numeric', // Hapus unique jika telepon boleh sama, atau biarkan jika wajib beda
            'email'       => 'required|email|unique:users,email',
            'jabatan'     => 'required|string', // UBAH position JADI jabatan
            'bidang_unit' => 'required|string', // UBAH unit_kerja JADI bidang_unit
            'annual_leave_quota' => 'required|numeric',
        ]);

        // B. Simpan ke Database
        User::create([
            'name'               => $request->name,
            'nip'                => $request->nip,
            'phone'              => $request->phone,
            'email'              => $request->email,
            'jabatan'            => $request->jabatan,     // Ambil dari input 'jabatan'
            'bidang_unit'        => $request->bidang_unit, // Ambil dari input 'bidang_unit'
            'join_date'          => $request->join_date,   // Tambahan tanggal masuk
            'status'             => $request->status,      // Tambahan status
            'annual_leave_quota' => $request->annual_leave_quota,
            'password'           => Hash::make('12345678'), 
            'role'               => 'user',
        ]);

        return redirect()->route('admin.kelola_pegawai')->with('success', 'Pegawai Berhasil Ditambahkan');
    }

    // 4. Menampilkan Form Edit
    public function edit($id)
    {
        $pegawai = User::findOrFail($id);
        return view('admin.edit_pegawai', compact('pegawai'));
    }

    // 5. Proses Update Data (SUDAH DIPERBAIKI)
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'nip'         => 'required|numeric|unique:users,nip,'.$id,
            'phone'       => 'required|numeric',
            'email'       => 'required|email|unique:users,email,'.$id,
            'jabatan'     => 'required|string', // Sesuaikan nama input
            'bidang_unit' => 'required|string', // Sesuaikan nama input
        ]);

        $pegawai = User::findOrFail($id);
        
        $pegawai->update([
            'name'        => $request->name,
            'nip'         => $request->nip,
            'phone'       => $request->phone,
            'email'       => $request->email,
            'jabatan'     => $request->jabatan,     // Sesuaikan
            'bidang_unit' => $request->bidang_unit, // Sesuaikan
            // Update data tambahan jika ada di form edit
            'annual_leave_quota' => $request->annual_leave_quota ?? $pegawai->annual_leave_quota,
        ]);

        return redirect()->route('admin.kelola_pegawai')->with('success', 'Pegawai Berhasil Diupdate');
    }

    // 6. Hapus Data
    public function destroy($id)
    {
        $pegawai = User::findOrFail($id);
        $pegawai->delete();

        return redirect()->route('admin.kelola_pegawai')->with('success', 'Pegawai Berhasil Dihapus');
    }
}