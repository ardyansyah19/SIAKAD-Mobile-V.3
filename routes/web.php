<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MahasiswaController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Mahasiswa\JadwalController;
use App\Http\Controllers\Mahasiswa\KhsController;
use App\Http\Controllers\Mahasiswa\KrsController;
use App\Http\Controllers\Mahasiswa\UktController;
use App\Http\Controllers\MahasiswaHomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Halaman Utama -> arahkan ke login
|--------------------------------------------------------------------------
*/
Route::redirect('/', '/login');

/*
|--------------------------------------------------------------------------
| Rute Autentikasi (Login)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->name('login.store');
});

Route::post('/logout', [LoginController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| Rute Mahasiswa (tampilan mobile app)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'mahasiswa'])->prefix('mahasiswa')->name('mahasiswa.')->group(function () {
    Route::get('/beranda', [MahasiswaHomeController::class, 'index'])->name('beranda');

    Route::get('/profil', [MahasiswaHomeController::class, 'profil'])->name('profil');
    Route::get('/profil/edit', [MahasiswaHomeController::class, 'editProfil'])->name('profil.edit');
    Route::put('/profil', [MahasiswaHomeController::class, 'updateProfil'])->name('profil.update');

    Route::get('/jadwal', [JadwalController::class, 'index'])->name('jadwal');

    Route::get('/khs', [KhsController::class, 'index'])->name('khs');

    Route::get('/krs', [KrsController::class, 'index'])->name('krs');
    Route::post('/krs', [KrsController::class, 'store'])->name('krs.store');
    Route::delete('/krs/{krs}', [KrsController::class, 'destroy'])->name('krs.destroy');

    Route::get('/ukt', [UktController::class, 'index'])->name('ukt');
    Route::post('/ukt/{pembayaran}/bayar', [UktController::class, 'store'])->name('ukt.bayar');
});

/*
|--------------------------------------------------------------------------
| Rute Admin (dashboard & manajemen data mahasiswa)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('mahasiswa', MahasiswaController::class);
});
