<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes (SIIPUL - Sistem Informasi Pengajuan Cuti)
|--------------------------------------------------------------------------
*/

// --- 1. HALAMAN DEPAN & UMUM ---

Route::get('/', function () {
    return view('LandingPage');
})->name('landing');

Route::get('/hubungi-kami', function () {
    return view('HubungiKami');
})->name('contact');


// --- 2. AUTHENTICATION (LOGIN & REGISTER) ---

Route::get('/login', function () {
    return view('LoginPage');
})->name('login');

Route::post('/login', function () {
    return redirect()->route('user.dashboard');
})->name('login.process');

Route::get('/register', function () {
    return view('RegisterPage');
})->name('register');

/**
 * INI YANG KAMU BUTUH:
 * Setelah submit register, redirect ke halaman sukses.
 * (Nanti kalau sudah pakai database, logika simpan user taruh di sini / controller)
 */
Route::post('/register', function () {
    // contoh: validasi / simpan user (nanti)
    return redirect()->route('register.success');
})->name('register.process');

/**
 * Route untuk halaman sukses register
 */
Route::get('/register-success', function () {
    return view('RegisterSuccess');
})->name('register.success');

Route::get('/lupa-password', function () {
    return view('LupaPassword');
})->name('password.request');

Route::get('/link-reset-terkirim', function () {
    return view('kirimlink');
})->name('password.sent');


// --- 3. AREA PEGAWAI (USER DASHBOARD) ---

Route::get('/dashboarduser', function () {
    return view('UserDashboard');
})->name('user.dashboard');

Route::get('/profil', function () {
    return view('ProfilPage');
})->name('user.profile');

Route::get('/edit-profil', function () {
    return view('EditProfilPage');
})->name('user.profile.edit');

Route::get('/riwayat', function () {
    return view('RiwayatPage');
})->name('user.history');


// --- 4. FITUR PENGAJUAN CUTI (INTI APLIKASI) ---

Route::get('/pengajuan-cuti', function () {
    return view('pengajuan-cuti');
})->name('cuti.create');

Route::post('/pengajuan-cuti', function () {
    return view('PengajuanSukses');
})->name('cuti.store');


// --- 5. ADMIN (OPSIONAL) ---

Route::get('/dashboard', function () {
    return view('Dashboard');
})->name('admin.dashboard');
