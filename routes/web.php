<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Auth;


// Redirect root ke halaman pilihan
Route::get('/', function () {
    return redirect()->route('auth.pilihan');
});

// Halaman Pilihan Siswa / Guru
Route::get('/pilihan', [AuthController::class, 'pilihan'])->name('auth.pilihan');

// Cek password guru sebelum login/register
Route::post('/guru/password/check', [AuthController::class, 'checkGuruPassword'])->name('auth.guru.password.check');

// Login/Register Siswa GET
Route::get('/login/siswa', [AuthController::class, 'loginSiswa'])->name('auth.login.siswa');
Route::get('/register/siswa', [AuthController::class, 'registerSiswa'])->name('auth.register.siswa');

// Login/Register Guru GET
Route::get('/login/guru', [AuthController::class, 'loginGuru'])->name('auth.login.guru');
Route::get('/register/guru', [AuthController::class, 'registerGuru'])->name('auth.register.guru');

// **Tambahkan POST routes untuk login & register**
Route::post('/login/guru', [AuthController::class, 'loginGuruPost'])->name('auth.login.guru.post');
Route::post('/login/siswa', [AuthController::class, 'loginSiswaPost'])->name('auth.login.siswa.post');
Route::post('/register/guru', [AuthController::class, 'registerGuruPost'])->name('auth.register.guru.post');
Route::post('/register/siswa', [AuthController::class, 'registerSiswaPost'])->name('auth.register.siswa.post');

// Auth bawaan Laravel (login/logout default)
Auth::routes();

// Home
Route::get('/home', [HomeController::class, 'index'])->name('home');

// Guru Routes (middleware guru)
Route::middleware(['guru'])->prefix('guru')->name('guru.')->group(function () {
    Route::get('/dashboard', [GuruController::class, 'dashboard'])->name('dashboard');
    Route::post('/generate-code', [GuruController::class, 'generateCode'])->name('generate-code');
    Route::get('/code/{id}', [GuruController::class, 'showCode'])->name('show-code');
    Route::get('/monitoring', [GuruController::class, 'monitoring'])->name('monitoring');
    Route::post('/input-manual', [GuruController::class, 'inputManual'])->name('input-manual');
    Route::get('/export-pdf', [GuruController::class, 'exportPDF'])->name('export-pdf');
    Route::get('/export-excel', [GuruController::class, 'exportExcel'])->name('export-excel');
});

// Siswa Routes (middleware siswa)
Route::middleware(['siswa'])->prefix('siswa')->name('siswa.')->group(function () {
    Route::get('/dashboard', [SiswaController::class, 'dashboard'])->name('dashboard');
    Route::post('/inputqr', [SiswaController::class, 'inputQR'])->name('inputqr');
    Route::get('/riwayat', [SiswaController::class, 'riwayat'])->name('riwayat');
    Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
});
