<?php

use Illuminate\Support\Facades\Route;

// Halaman Depan (Merah)
Route::get('/', function () {
    return view('LandingPage');
});

// Halaman Dashboard (Putih - Menu Layanan)
Route::get('/dashboard', function () {
    return view('Dashboard');
});
// Halaman Login (UPDATE BAGIAN INI)
Route::get('/login', function () {
    return view('LoginPage');
});
// Halaman Register (UPDATE BAGIAN INI)
Route::get('/register', function () {
    return view('RegisterPage');
});
// Halaman Lupa Password (UPDATE BAGIAN INI)
Route::get('/lupa-password', function () {
    return view('LupaPassword');
});

// Pastikan ini ada dan sama tulisannya
Route::get('/link-reset-terkirim', function () {
    return view('LinkResetTerkirim');
});