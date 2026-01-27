<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Cuti;
use App\Models\LeaveRequest;
use App\Models\LeaveBalance;

class UserController extends Controller
{

    /**
     * Show user dashboard
     */
    public function dashboard()
    {
        $user = Auth::user();
        $currentYear = now()->year;
        
        // Hitung saldo cuti dengan LeaveBalance
        $leaveBalance = LeaveBalance::calculateTotalAvailable($user->id, $currentYear);
        $totalQuota = $leaveBalance['n']['quota'];
        $usedLeave = $leaveBalance['n']['used'];
        $remainingLeave = $leaveBalance['total_available'];
        
        // Ambil riwayat pengajuan terbaru (3 terakhir) dari LeaveRequest
        $recentLeaves = LeaveRequest::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();
        
        // Hitung statistik status untuk donut chart
        $totalSubmissions = LeaveRequest::where('user_id', $user->id)->count();
        
        if ($totalSubmissions > 0) {
            $approvedCount = LeaveRequest::where('user_id', $user->id)
                ->where('status', LeaveRequest::STATUS_APPROVED)
                ->count();
            $pendingCount = LeaveRequest::where('user_id', $user->id)
                ->where('status', LeaveRequest::STATUS_PENDING)
                ->count();
            $rejectedCount = LeaveRequest::where('user_id', $user->id)
                ->where('status', LeaveRequest::STATUS_REJECTED)
                ->count();
            
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
    public function history(Request $request)
    {
        $user = Auth::user();
        
        // Filter berdasarkan status
        $status = $request->get('status', 'all');
        
        $query = LeaveRequest::where('user_id', $user->id)
            ->orderBy('created_at', 'desc');
        
        // Apply filter
        if ($status !== 'all') {
            $statusMap = [
                'approved' => LeaveRequest::STATUS_APPROVED,
                'pending' => LeaveRequest::STATUS_PENDING,
                'rejected' => LeaveRequest::STATUS_REJECTED,
            ];
            
            if (isset($statusMap[$status])) {
                $query->where('status', $statusMap[$status]);
            }
        }
        
        $leaves = $query->paginate(10);
        
        return view('user.RiwayatPage', compact('leaves', 'user', 'status'));
    }
}