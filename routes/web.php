<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| PUBLIC AREA
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('LandingPage');
})->name('landing');

Route::get('/hubungi-kami', function () {
    return view('HubungiKami');
})->name('contact');


/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/

Route::get('/login', fn () => view('auth.LoginPage'))->name('login');

Route::post('/login', function (Request $request) {
    // nanti: Auth::attempt(...)
    return redirect()->route('admin.dashboard');
})->name('login.process');

Route::get('/register', fn () => view('auth.RegisterPage'))->name('register');

Route::post('/register', function (Request $request) {
    // nanti: simpan user
    return redirect()->route('register.success');
})->name('register.process');

Route::get('/register-success', fn () => view('auth.RegisterSuccess'))
    ->name('register.success');

Route::get('/lupa-password', fn () => view('auth.LupaPassword'))
    ->name('password.request');

Route::get('/link-reset-terkirim', fn () => view('auth.kirimlink'))
    ->name('password.sent');


/*
|--------------------------------------------------------------------------
| USER AREA
|--------------------------------------------------------------------------
*/

Route::prefix('user')->name('user.')->group(function () {

    Route::get('/dashboard', fn () => view('user.UserDashboard'))->name('dashboard');
    Route::get('/profil', fn () => view('user.ProfilPage'))->name('profil');
    Route::get('/edit-profil', fn () => view('user.EditProfilPage'))->name('profil.edit');
    Route::get('/riwayat', fn () => view('user.RiwayatPage'))->name('riwayat');

    // Route untuk Form Pengajuan Cuti
    Route::get('/pengajuan-cuti', fn () => view('user.pengajuan_cuti'))->name('cuti.create');

    // Route untuk Proses Simpan Cuti
    Route::post('/pengajuan-cuti', fn () => view('user.PengajuanSukses'))->name('cuti.store');
});


/*
|--------------------------------------------------------------------------
| ADMIN AREA
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->group(function () {

    // Dashboard & Profil
    Route::get('/dashboard', fn () => view('admin.dashboard_admin'))->name('dashboard');
    Route::get('/profil', fn () => view('admin.profil_admin'))->name('profil');

    // Kelola Pegawai
    Route::get('/kelola-pegawai', fn () => view('admin.kelola_pegawai'))->name('kelola_pegawai');

    // Tambah Pegawai (GET: Tampilkan Form)
    Route::get('/tambah-pegawai', fn () => view('admin.tambah_pegawai'))->name('tambah_pegawai');



    // Laporan & Pengajuan Cuti
    Route::get('/laporan', fn () => view('admin.laporan'))->name('laporan');
    Route::get('/kelola-pengajuan', fn () => view('admin.kelola_pengajuan'))->name('kelola_pengajuan');
    Route::get('/detail-pengajuan', fn () => view('admin.detail_pengajuan'))->name('detail_pengajuan');
});