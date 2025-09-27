<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\HomeController;

Route::get('/', function () {
    return redirect('/login');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

// Guru Routes
Route::middleware(['guru'])->prefix('guru')->name('guru.')->group(function () {
    Route::get('/dashboard', [GuruController::class, 'dashboard'])->name('dashboard');
    Route::post('/generate-code', [GuruController::class, 'generateCode'])->name('generate-code');
    Route::get('/code/{id}', [GuruController::class, 'showCode'])->name('show-code');
    Route::get('/monitoring', [GuruController::class, 'monitoring'])->name('monitoring');
    Route::post('/input-manual', [GuruController::class, 'inputManual'])->name('input-manual');
    Route::get('/export-pdf', [GuruController::class, 'exportPDF'])->name('export-pdf');
});

// Siswa Routes
Route::middleware(['siswa'])->prefix('siswa')->name('siswa.')->group(function () {
    Route::get('/dashboard', [SiswaController::class, 'dashboard'])->name('dashboard');
Route::post('/inputqr', [SiswaController::class, 'inputQR'])->name('inputqr');
    Route::get('/riwayat', [SiswaController::class, 'riwayat'])->name('riwayat');
    Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
});