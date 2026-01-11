<?php

use Illuminate\Support\Facades\Route;

// Halaman Depan (Merah)
Route::get('/', function () {
    return view('LandingPage');
});

// Halaman Dashboard Admin/Umum
Route::get('/dashboard', function () {
    return view('Dashboard');
});

// --- AUTHENTICATION (LOGIN & REGISTER) ---

// 1. Tampilkan Halaman Login
Route::get('/login', function () {
    return view('LoginPage');
});

// 2. Proses Login (POST) - PERBAIKAN UTAMA DISINI
// Rute ini menangani saat tombol "Masuk" ditekan
Route::post('/login', function () {
    // Di sini nanti logika cek database (Auth::attempt)
    // Untuk sekarang, kita langsung redirect ke dashboard user
    return redirect('/dashboarduser');
});

// Halaman Register
Route::get('/register', function () {
    return view('RegisterPage');
});

// Halaman Lupa Password
Route::get('/lupa-password', function () {
    return view('LupaPassword');
});

// Halaman Konfirmasi Link Terkirim
Route::get('/link-reset-terkirim', function () {
    return view('kirimlink');
});

// --- USER DASHBOARD & PROFILE ---

// Halaman Profil Saya
Route::get('/profil', function () {
    return view('ProfilPage');
});

// Halaman Edit Profil
Route::get('/edit-profil', function () {
    return view('EditProfilPage');
});

// Halaman Dashboard User
Route::get('/dashboarduser', function () {
    return view('UserDashboard'); 
});

// --- FITUR PENGAJUAN CUTI ---

// 1. Tampilkan Form Pengajuan (GET)
Route::get('/pengajuan-cuti', function () {
    return view('pengajuan-cuti');
})->name('cuti.create');

// 2. Proses Submit Form Pengajuan (POST)
Route::post('/pengajuan-cuti', function () {
    return "Data cuti berhasil disubmit (Simulasi). Nanti akan masuk database.";
})->name('cuti.store');