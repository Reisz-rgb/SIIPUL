<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PegawaiController extends Controller
{
    /**
     * Menampilkan Daftar Pegawai
     */
    public function index(Request $request)
    {
        $query = User::where('role', 'user');

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('nip', 'LIKE', "%{$search}%")
                  ->orWhere('bidang_unit', 'LIKE', "%{$search}%");
            });
        }

        $pegawai = $query->latest()->paginate(10);
        return view('admin.kelola_pegawai', compact('pegawai'));
    }

    /**
     * Menampilkan Form Tambah
     */
    public function create()
    {
        return view('admin.tambah_pegawai'); 
    }

    /**
     * Proses Simpan Data Pegawai Baru
     */
    public function store(Request $request)
    {
        // Validasi
        $validated = $request->validate([
            'name'               => 'required|string|max:255',
            'nip'                => 'required|string|unique:users,nip',
            'phone'              => 'required|string|unique:users,phone',
            'email'              => 'nullable|email|unique:users,email',
            'jabatan'            => 'required|string|max:255',
            'bidang_unit'        => 'required|string|max:255',
            'join_date'          => 'nullable|date',
            'annual_leave_quota' => 'required|integer|min:0|max:30',
            'status'             => 'required|in:aktif,nonaktif',
        ], [
            'name.required'               => 'Nama wajib diisi',
            'nip.required'                => 'NIP wajib diisi',
            'nip.unique'                  => 'NIP sudah terdaftar',
            'phone.required'              => 'Nomor telepon wajib diisi',
            'phone.unique'                => 'Nomor telepon sudah terdaftar',
            'email.unique'                => 'Email sudah terdaftar',
            'jabatan.required'            => 'Jabatan wajib diisi',
            'bidang_unit.required'        => 'Unit kerja wajib diisi',
            'annual_leave_quota.required' => 'Kuota cuti wajib diisi',
            'annual_leave_quota.integer'  => 'Kuota cuti harus berupa angka',
        ]);

        // Bersihkan NIP dan phone
        $nip = preg_replace('/[^0-9]/', '', $request->nip);
        $phone = preg_replace('/[^0-9]/', '', $request->phone);

        // Simpan pegawai baru
        User::create([
            'name'               => $validated['name'],
            'nip'                => $nip,
            'phone'              => $phone,
            'email'              => $validated['email'],
            'jabatan'            => $validated['jabatan'],
            'bidang_unit'        => $validated['bidang_unit'],
            'join_date'          => $validated['join_date'],
            'status'             => $validated['status'],
            'annual_leave_quota' => $validated['annual_leave_quota'],
            'password'           => Hash::make($nip), // Password default = NIP
            'role'               => 'user',
        ]);

        return redirect()
            ->route('admin.kelola_pegawai')
            ->with('success', 'Pegawai berhasil ditambahkan! Password default = NIP pegawai.');
    }

    /**
     * Menampilkan Form Edit
     */
    public function edit($id)
    {
        $pegawai = User::findOrFail($id);
        return view('admin.edit_pegawai', compact('pegawai'));
    }

    /**
     * Proses Update Data
     */
    public function update(Request $request, $id)
    {
        $pegawai = User::findOrFail($id);

        $validated = $request->validate([
            'name'               => 'required|string|max:255',
            'nip'                => 'required|string|unique:users,nip,' . $id,
            'phone'              => 'required|string|unique:users,phone,' . $id,
            'email'              => 'nullable|email|unique:users,email,' . $id,
            'jabatan'            => 'required|string|max:255',
            'bidang_unit'        => 'required|string|max:255',
            'join_date'          => 'nullable|date',
            'annual_leave_quota' => 'required|integer|min:0|max:30',
            'status'             => 'required|in:aktif,nonaktif',
        ], [
            'name.required'               => 'Nama wajib diisi',
            'nip.required'                => 'NIP wajib diisi',
            'nip.unique'                  => 'NIP sudah terdaftar',
            'phone.required'              => 'Nomor telepon wajib diisi',
            'phone.unique'                => 'Nomor telepon sudah terdaftar',
            'email.unique'                => 'Email sudah terdaftar',
            'jabatan.required'            => 'Jabatan wajib diisi',
            'bidang_unit.required'        => 'Unit kerja wajib diisi',
            'annual_leave_quota.required' => 'Kuota cuti wajib diisi',
        ]);

        // Bersihkan NIP dan phone
        $nip = preg_replace('/[^0-9]/', '', $request->nip);
        $phone = preg_replace('/[^0-9]/', '', $request->phone);

        $pegawai->update([
            'name'               => $validated['name'],
            'nip'                => $nip,
            'phone'              => $phone,
            'email'              => $validated['email'],
            'jabatan'            => $validated['jabatan'],
            'bidang_unit'        => $validated['bidang_unit'],
            'join_date'          => $validated['join_date'],
            'status'             => $validated['status'],
            'annual_leave_quota' => $validated['annual_leave_quota'],
        ]);

        return redirect()
            ->route('admin.kelola_pegawai')
            ->with('success', 'Data pegawai berhasil diperbarui!');
    }

    /**
     * Hapus Data
     */
    public function destroy($id)
    {
        $pegawai = User::findOrFail($id);
        
        // Cek apakah pegawai memiliki pengajuan cuti
        if ($pegawai->cuti()->count() > 0) {
            return redirect()
                ->route('admin.kelola_pegawai')
                ->with('error', 'Tidak dapat menghapus pegawai yang memiliki riwayat pengajuan cuti!');
        }

        $pegawai->delete();

        return redirect()
            ->route('admin.kelola_pegawai')
            ->with('success', 'Pegawai berhasil dihapus!');
    }

    /**
     * Reset Password Pegawai (Bonus Feature)
     */
    public function resetPassword($id)
    {
        $pegawai = User::findOrFail($id);
        
        // Reset password ke NIP
        $pegawai->update([
            'password' => Hash::make($pegawai->nip)
        ]);

        return redirect()
            ->route('admin.kelola_pegawai')
            ->with('success', 'Password pegawai berhasil direset ke NIP!');
    }
}