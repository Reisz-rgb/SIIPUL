<?php

use Illuminate\Support\Facades\Route;

// Halaman Landing Page (Halaman yang pertama kali muncul)
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Authentication Routes
Route::get('/login', function () {
    return view('pages.auth.login');
})->name('login');

// Simulasi Login: Setelah submit login, diarahkan ke dashboard
Route::post('/login', function () {
    return redirect()->route('dashboard');
})->name('login.post');

Route::get('/register', function () {
    return view('pages.auth.register');
})->name('register');

// Dashboard Routes (Halaman yang diproteksi/setelah login)
Route::prefix('dashboard')->group(function () {
    
    Route::get('/', function () {
        return view('pages.dashboard.index');
    })->name('dashboard');
    
    Route::get('/cuti/create', function () {
        return view('pages.cuti.create');
    })->name('cuti.create');
    
    Route::get('/cuti/riwayat', function () {
        return view('pages.cuti.riwayat');
    })->name('cuti.riwayat');
    
    Route::get('/profile', function () {
        return view('pages.profile.index');
    })->name('profile');
});