<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PasswordResetController extends Controller
{
    /**
     * Show forgot password form
     */
    public function showForgotPassword()
    {
        return view('auth.LupaPassword');
    }

    /**
     * Send reset link via SMS (simulasi)
     */
    public function sendResetLink(Request $request)
    {
        $request->validate([
            'phone' => 'required|string',
        ], [
            'phone.required' => 'Nomor HP wajib diisi',
        ]);

        $phone = preg_replace('/[^0-9]/', '', $request->phone);

        $user = User::where('phone', $phone)->first();

        if (!$user) {
            return redirect()->back()
                ->withErrors(['phone' => 'Nomor HP tidak terdaftar'])
                ->withInput();
        }

        // Generate token
        $token = Str::random(64);

        // Simpan token ke database
        DB::table('password_reset_tokens')->updateOrInsert(
            ['phone' => $phone],
            [
                'token' => Hash::make($token),
                'created_at' => now(),
            ]
        );

        // TODO: Kirim SMS dengan link reset
        // Untuk development, kita simpan token di session
        session(['reset_token' => $token, 'reset_phone' => $phone]);

        return redirect()->route('password.sent');
    }

    /**
     * Show reset password form
     */
    public function showResetForm(Request $request, $token)
    {
        return view('auth.ResetPassword', ['token' => $token]);
    }

    /**
     * Process password reset
     */
    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'phone' => 'required',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'password.required' => 'Password baru wajib diisi',
            'password.min' => 'Password minimal 6 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
        ]);

        $phone = preg_replace('/[^0-9]/', '', $request->phone);

        // Cek token
        $resetRecord = DB::table('password_reset_tokens')
            ->where('phone', $phone)
            ->first();

        if (!$resetRecord || !Hash::check($request->token, $resetRecord->token)) {
            return redirect()->back()
                ->withErrors(['token' => 'Token reset tidak valid']);
        }

        // Cek apakah token sudah expired (24 jam)
        if (now()->diffInHours($resetRecord->created_at) > 24) {
            return redirect()->back()
                ->withErrors(['token' => 'Token reset sudah kadaluarsa']);
        }

        // Update password
        $user = User::where('phone', $phone)->first();
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        // Hapus token
        DB::table('password_reset_tokens')->where('phone', $phone)->delete();

        return redirect()->route('login')
            ->with('success', 'Password berhasil direset. Silakan login.');
    }
}