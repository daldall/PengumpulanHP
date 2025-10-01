<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AdminController;


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


// Login Admin
Route::get('/login/admin', [AuthController::class, 'loginAdmin'])->name('auth.login.admin');
Route::post('/login/admin', [AuthController::class, 'loginAdminPost'])->name('auth.login.admin.post');

// Dashboard Admin (middleware admin)
Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // CRUD Guru
    Route::get('/guru', [AdminController::class, 'listGuru'])->name('guru.list');
    Route::get('/guru/create', [AdminController::class, 'createGuru'])->name('guru.create');
    Route::post('/guru/store', [AdminController::class, 'storeGuru'])->name('guru.store');
    Route::get('/guru/{id}/edit', [AdminController::class, 'editGuru'])->name('guru.edit');
    Route::put('/guru/{id}', [AdminController::class, 'updateGuru'])->name('guru.update');
    Route::delete('/guru/{id}', [AdminController::class, 'deleteGuru'])->name('guru.delete');

    // CRUD Siswa
    Route::get('/siswa', [AdminController::class, 'listSiswa'])->name('siswa.list');
    Route::get('/siswa/create', [AdminController::class, 'createSiswa'])->name('siswa.create');
    Route::post('/siswa/store', [AdminController::class, 'storeSiswa'])->name('siswa.store');
    Route::get('/siswa/{id}/edit', [AdminController::class, 'editSiswa'])->name('siswa.edit');
    Route::put('/siswa/{id}', [AdminController::class, 'updateSiswa'])->name('siswa.update');
    Route::delete('/siswa/{id}', [AdminController::class, 'deleteSiswa'])->name('siswa.delete');
});

// Guru Routes (middleware guru)
Route::middleware(['guru'])->prefix('guru')->name('guru.')->group(function () {
    Route::get('/dashboard', [GuruController::class, 'dashboard'])->name('dashboard');
    Route::post('/generate-code', [GuruController::class, 'generateCode'])->name('generate-code');
    Route::get('/code/{id}', [GuruController::class, 'showCode'])->name('show-code');
    Route::get('/monitoring', [GuruController::class, 'monitoring'])->name('monitoring');
    Route::post('/input-manual', [GuruController::class, 'inputManual'])->name('input-manual');
    Route::get('/export-pdf', [GuruController::class, 'exportPDF'])->name('export-pdf');
    Route::get('/export-excel', [GuruController::class, 'exportExcel'])->name('export-excel');
    Route::post('/toggle-code/{id}', [GuruController::class, 'toggleCode'])->name('toggle-code');
    Route::post('/close-and-generate', [GuruController::class, 'closeAndGenerate'])->name('close-and-generate');
});

// Siswa Routes (middleware siswa)
Route::middleware(['siswa'])->prefix('siswa')->name('siswa.')->group(function () {
    Route::get('/dashboard', [SiswaController::class, 'dashboard'])->name('dashboard');
    Route::post('/inputqr', [SiswaController::class, 'inputQR'])->name('inputqr');
    Route::get('/riwayat', [SiswaController::class, 'riwayat'])->name('riwayat');
    Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
});
