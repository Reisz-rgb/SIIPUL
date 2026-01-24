<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Cuti;

class UserController extends Controller
{
    /**
     * Show user dashboard
     */
    public function dashboard()
    {
        $user = Auth::user();
        
        // Hitung statistik cuti
        $totalQuota = $user->annual_leave_quota ?? 12;
        $usedLeave = Cuti::where('user_id', $user->id)
            ->where('status', 'disetujui')
            ->sum('jumlah_hari');
        $remainingLeave = $totalQuota - $usedLeave;
        
        // Ambil riwayat pengajuan terbaru (3 terakhir)
        $recentLeaves = Cuti::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();
        
        // Hitung statistik status (untuk donut chart)
        $totalSubmissions = Cuti::where('user_id', $user->id)->count();
        $approvedCount = Cuti::where('user_id', $user->id)->where('status', 'disetujui')->count();
        $pendingCount = Cuti::where('user_id', $user->id)->where('status', 'pending')->count();
        $rejectedCount = Cuti::where('user_id', $user->id)->where('status', 'ditolak')->count();
        
        // Hitung persentase untuk donut
        if ($totalSubmissions > 0) {
            $approvedPercent = round(($approvedCount / $totalSubmissions) * 100);
            $pendingPercent = round(($pendingCount / $totalSubmissions) * 100);
            $rejectedPercent = round(($rejectedCount / $totalSubmissions) * 100);
        } else {
            $approvedPercent = $pendingPercent = $rejectedPercent = 0;
        }
        
        return view('user.UserDashboard', compact(
            'user',
            'totalQuota',
            'usedLeave',
            'remainingLeave',
            'recentLeaves',
            'approvedPercent',
            'pendingPercent',
            'rejectedPercent'
        ));
    }
    
    /**
     * Show user profile
     */
    public function profile()
    {
        $user = Auth::user();
        return view('user.ProfilPage', compact('user'));
    }
    
    /**
     * Show edit profile form
     */
    public function editProfile()
    {
        $user = Auth::user();
        return view('user.EditProfilPage', compact('user'));
    }
    
    /**
     * Update user profile
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:users,email,' . $user->id,
            'phone' => 'required|string|unique:users,phone,' . $user->id,
            'jabatan' => 'nullable|string|max:255',
            'bidang_unit' => 'nullable|string|max:255',
        ], [
            'name.required' => 'Nama wajib diisi',
            'email.unique' => 'Email sudah digunakan',
            'phone.required' => 'Nomor HP wajib diisi',
            'phone.unique' => 'Nomor HP sudah digunakan',
        ]);
        
        // Bersihkan phone
        $phone = preg_replace('/[^0-9]/', '', $request->phone);
        
        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $phone,
            'jabatan' => $validated['jabatan'],
            'bidang_unit' => $validated['bidang_unit'],
        ]);
        
        return redirect()
            ->route('user.profil')
            ->with('status', 'sukses');
    }
    
    /**
     * Show change password form
     */
    public function showChangePassword()
    {
        return view('user.ChangePassword');
    }
    
    /**
     * Update password
     */
    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'current_password.required' => 'Password lama wajib diisi',
            'password.required' => 'Password baru wajib diisi',
            'password.min' => 'Password minimal 6 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
        ]);
        
        $user = Auth::user();
        
        // Debug: Cek password hash
        \Log::info('Current Password Input: ' . $request->current_password);
        \Log::info('Stored Password Hash: ' . $user->password);
        \Log::info('Check Result: ' . (Hash::check($request->current_password, $user->password) ? 'TRUE' : 'FALSE'));
        
        // Cek password lama
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()
                ->back()
                ->withErrors(['current_password' => 'Password lama tidak sesuai. Gunakan password terakhir yang Anda set, atau gunakan NIP jika belum pernah mengubah password.'])
                ->withInput();
        }
        
        // Update password
        $user->update([
            'password' => Hash::make($request->password)
        ]);
        
        return redirect()
            ->route('user.profil')
            ->with('status', 'password_updated');
    }
    
    /**
     * Show user leave history
     */
    public function history()
    {
        $user = Auth::user();
        
        $leaves = Cuti::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('user.RiwayatPage', compact('leaves', 'user'));
    }
}