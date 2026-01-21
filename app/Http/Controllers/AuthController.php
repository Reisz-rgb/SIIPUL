<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Show login form
     */
    public function showLogin()
    {
        if (Auth::check()) {
            return $this->redirectBasedOnRole();
        }
        return view('auth.LoginPage');
    }

    /**
     * Process login
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nip' => 'required|string',
            'password' => 'required|string',
        ], [
            'nip.required' => 'NIP wajib diisi',
            'password.required' => 'Password wajib diisi',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Bersihkan NIP dari spasi dan karakter non-numeric
        $nip = preg_replace('/[^0-9]/', '', $request->nip);

        $credentials = [
            'nip' => $nip,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            
            return $this->redirectBasedOnRole();
        }

        return redirect()->back()
            ->withErrors(['login' => 'NIP atau password salah'])
            ->withInput();
    }

    /**
     * Show register form
     */
    public function showRegister()
    {
        if (Auth::check()) {
            return $this->redirectBasedOnRole();
        }
        return view('auth.RegisterPage');
    }

    /**
     * Process registration
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'nip' => 'required|string|unique:users,nip',
            'phone' => 'required|string|unique:users,phone',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'name.required' => 'Nama wajib diisi',
            'nip.required' => 'NIP wajib diisi',
            'nip.unique' => 'NIP sudah terdaftar',
            'phone.required' => 'Nomor HP wajib diisi',
            'phone.unique' => 'Nomor HP sudah terdaftar',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 6 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Bersihkan NIP dan phone
        $nip = preg_replace('/[^0-9]/', '', $request->nip);
        $phone = preg_replace('/[^0-9]/', '', $request->phone);

        // Cek apakah NIP ada di data pegawai yang sudah diimport
        $existingUser = User::where('nip', $nip)->first();

        if (!$existingUser) {
            return redirect()->back()
                ->withErrors(['nip' => 'NIP tidak ditemukan dalam database pegawai. Hubungi admin.'])
                ->withInput();
        }

        // Update user yang sudah ada dengan password dan phone baru
        $existingUser->update([
            'phone' => $phone,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('register.success');
    }

    /**
     * Logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    /**
     * Redirect based on user role
     */
    private function redirectBasedOnRole()
    {
        if (Auth::user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('user.dashboard');
    }
}