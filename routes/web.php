<?php

use Illuminate\Support\Facades\Route;

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

Route::post('/login', function () {
    // nanti: Auth::attempt(...)
    return redirect()->route('user.dashboard');
})->name('login.process');

Route::get('/register', fn () => view('auth.RegisterPage'))->name('register');

Route::post('/register', function () {
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
    Route::get('/profil', fn () => view('user.ProfilPage'))->name('profile');
    Route::get('/edit-profil', fn () => view('user.EditProfilPage'))->name('profile.edit');
    Route::get('/riwayat', fn () => view('user.RiwayatPage'))->name('history');

    Route::get('/pengajuan-cuti', fn () => view('user.pengajuan-cuti'))->name('cuti.create');
    Route::post('/pengajuan-cuti', fn () => view('user.PengajuanSuksesPage'))->name('cuti.store');
});



/*
|--------------------------------------------------------------------------
| ADMIN AREA
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', fn () => view('admin.dashboard_admin'))->name('dashboard');
    Route::get('/profil', fn () => view('admin.profil_admin'))->name('profil');

    Route::get('/kelola-pegawai', fn () => view('admin.kelola-pegawai'))->name('kelola_pegawai');
    Route::get('/laporan', fn () => view('admin.laporan'))->name('laporan');
    Route::get('/detail-pengajuan', fn () => view('admin.detail-pengajuan'))->name('detail_pengajuan');
    Route::get('/kelola-pengajuan', fn () => view('admin.kelola-pengajuan'))->name('kelola_pengajuan');
});
