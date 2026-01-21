<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\PegawaiController;
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
| AUTH - Guest Only
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    // Login
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.process');

    // Register
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.process');

    Route::get('/register-success', fn() => view('auth.RegisterSuccess'))
        ->name('register.success');

    // Password Reset
    Route::get('/lupa-password', [PasswordResetController::class, 'showForgotPassword'])
        ->name('password.request');
    Route::post('/lupa-password', [PasswordResetController::class, 'sendResetLink'])
        ->name('password.email');
    
    Route::get('/link-reset-terkirim', fn() => view('auth.kirimlink'))
        ->name('password.sent');
    
    Route::get('/reset-password/{token}', [PasswordResetController::class, 'showResetForm'])
        ->name('password.reset');
    Route::post('/reset-password', [PasswordResetController::class, 'reset'])
        ->name('password.update');
});

// Logout (authenticated only)
Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');


/*
|--------------------------------------------------------------------------
| USER AREA - Authenticated Users Only
|--------------------------------------------------------------------------
*/
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    
    // Dashboard & Profil
    Route::get('/dashboard', fn() => view('admin.dashboard_admin'))->name('dashboard');
    Route::get('/profil', fn() => view('admin.profil_admin'))->name('profil');

    // --- LOGIC PEGAWAI ---
    
    // 1. List Pegawai
    Route::get('/kelola-pegawai', [PegawaiController::class, 'index'])->name('kelola_pegawai');

    // 2. Tambah Pegawai
    Route::get('/tambah-pegawai', [PegawaiController::class, 'create'])->name('tambah_pegawai');
    Route::post('/pegawai', [PegawaiController::class, 'store'])->name('pegawai.store');

    // 3. Edit Pegawai
    Route::get('/pegawai/{id}/edit', [PegawaiController::class, 'edit'])->name('pegawai.edit');
    Route::put('/pegawai/{id}', [PegawaiController::class, 'update'])->name('pegawai.update');

    // 4. Hapus Pegawai (INI YANG KURANG)
    Route::delete('/pegawai/{id}', [PegawaiController::class, 'destroy'])->name('pegawai.destroy'); // <--- TAMBAHKAN INI

    // Menu Lainnya
    Route::get('/laporan', fn() => view('admin.laporan'))->name('laporan');
    Route::get('/kelola-pengajuan', fn() => view('admin.kelola_pengajuan'))->name('kelola_pengajuan');
    Route::get('/detail-pengajuan', fn() => view('admin.detail_pengajuan'))->name('detail_pengajuan');
});