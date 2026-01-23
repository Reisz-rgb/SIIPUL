<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\AdminController;
    
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

    Route::get('/panduan-login', fn() => view('auth.PanduanLogin'))->name('panduan.login');    
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

Route::prefix('user')->name('user.')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', fn() => view('user.UserDashboard'))->name('dashboard');
    Route::get('/profil', fn() => view('user.ProfilPage'))->name('profil');
    Route::get('/edit-profil', fn() => view('user.EditProfilPage'))->name('profil.edit');
    Route::get('/riwayat', fn() => view('user.RiwayatPage'))->name('riwayat');

    // Pengajuan Cuti
    Route::get('/pengajuan-cuti', fn() => view('user.pengajuan_cuti'))->name('cuti.create');
    Route::post('/pengajuan-cuti', fn() => view('user.PengajuanSukses'))->name('cuti.store');
});

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Perhatikan: group ini sudah memberi awalan "admin." otomatis ke semua nama route di dalamnya
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // 1. DASHBOARD & PROFIL
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/profil', function() {
        return view('admin.profil_admin');
    })->name('profil');
    
    // 2. KELOLA PENGAJUAN CUTI (Detail & Update Status)
    Route::get('/pengajuan/{id}', [AdminController::class, 'show'])->name('pengajuan.show');
    Route::put('/pengajuan/{id}', [AdminController::class, 'updateStatus'])->name('pengajuan.update');

    // 3. DOWNLOAD LAPORAN (Excel & PDF)
    Route::get('/download-excel', [AdminController::class, 'downloadExcel'])->name('download.excel');
    Route::get('/download-pdf', [AdminController::class, 'downloadPdf'])->name('download.pdf');

    // 4. KELOLA PEGAWAI (Ini AMAN, tidak dihapus)
    Route::get('/kelola-pegawai', [PegawaiController::class, 'index'])->name('kelola_pegawai');
    Route::get('/tambah-pegawai', [PegawaiController::class, 'create'])->name('tambah_pegawai');
    Route::post('/pegawai/store', [PegawaiController::class, 'store'])->name('pegawai.store');
    Route::get('/pegawai/{id}/edit', [PegawaiController::class, 'edit'])->name('pegawai.edit');
    Route::put('/pegawai/{id}', [PegawaiController::class, 'update'])->name('pegawai.update');
    Route::delete('/pegawai/{id}', [PegawaiController::class, 'destroy'])->name('pegawai.destroy');
    Route::post('/pegawai/{id}/reset-password', [PegawaiController::class, 'resetPassword'])->name('pegawai.reset_password');
    
    // 5. VIEW LAINNYA
    Route::get('/laporan', function() { return view('admin.laporan'); })->name('laporan');
    Route::get('/kelola-pengajuan', function() { return view('admin.kelola_pengajuan'); })->name('kelola_pengajuan');
    Route::get('/detail-pengajuan', function() { return view('admin.detail_pengajuan'); })->name('detail_pengajuan');
});