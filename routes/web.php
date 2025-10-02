<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Auth;

// ================== ROOT ================== //
Route::get('/', function () {
    return redirect()->route('auth.pilihan');
});

// ================== AUTH ================== //
Route::get('/pilihan', [AuthController::class, 'pilihan'])->name('auth.pilihan');

// ----- CEK PASSWORD GURU ----- //
Route::post('/guru/password/check', [AuthController::class, 'checkGuruPassword'])->name('auth.guru.password.check');

// ----- LOGIN & REGISTER SISWA ----- //
Route::get('/login/siswa', [AuthController::class, 'loginSiswa'])->name('auth.login.siswa');
Route::post('/login/siswa', [AuthController::class, 'loginSiswaPost'])->name('auth.login.siswa.post');

Route::get('/register/siswa', [AuthController::class, 'registerSiswa'])->name('auth.register.siswa');
Route::post('/register/siswa', [AuthController::class, 'registerSiswaPost'])->name('auth.register.siswa.post');

// ----- LOGIN & REGISTER GURU ----- //
Route::get('/login/guru', [AuthController::class, 'loginGuru'])->name('auth.login.guru');
Route::post('/login/guru', [AuthController::class, 'loginGuruPost'])->name('auth.login.guru.post');

Route::get('/register/guru', [AuthController::class, 'registerGuru'])->name('auth.register.guru');
Route::post('/register/guru', [AuthController::class, 'registerGuruPost'])->name('auth.register.guru.post');

// ----- LOGIN ADMIN ----- //
Route::get('/login/admin', [AuthController::class, 'loginAdmin'])->name('auth.login.admin');
Route::post('/login/admin', [AuthController::class, 'loginAdminPost'])->name('auth.login.admin.post');

// ----- LOGOUT ----- //
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ================== ADMIN ================== //
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // CRUD Guru
    Route::get('/guru/create', [AdminController::class, 'createGuru'])->name('admin.guru.create');
    Route::post('/guru/store', [AdminController::class, 'storeGuru'])->name('admin.guru.store');
    Route::get('/guru/edit/{id}', [AdminController::class, 'editGuru'])->name('admin.guru.edit');
    Route::put('/guru/update/{id}', [AdminController::class, 'updateGuru'])->name('admin.guru.update'); 
    Route::delete('/guru/delete/{id}', [AdminController::class, 'deleteGuru'])->name('admin.guru.delete');

    // CRUD Siswa
    Route::get('/siswa/create', [AdminController::class, 'createSiswa'])->name('admin.siswa.create');
    Route::post('/siswa/store', [AdminController::class, 'storeSiswa'])->name('admin.siswa.store');
    Route::get('/siswa/edit/{id}', [AdminController::class, 'editSiswa'])->name('admin.siswa.edit');
    Route::put('/siswa/update/{id}', [AdminController::class, 'updateSiswa'])->name('admin.siswa.update');
    Route::delete('/siswa/delete/{id}', [AdminController::class, 'deleteSiswa'])->name('admin.siswa.delete');

    // CRUD Admin
    Route::get('/admin/create', [AdminController::class, 'createAdmin'])->name('admin.admin.create');
    Route::post('/admin/store', [AdminController::class, 'storeAdmin'])->name('admin.admin.store');
    Route::get('/admin/edit/{id}', [AdminController::class, 'editAdmin'])->name('admin.admin.edit');
    Route::put('/admin/update/{id}', [AdminController::class, 'updateAdmin'])->name('admin.admin.update');
    Route::delete('/admin/delete/{id}', [AdminController::class, 'deleteAdmin'])->name('admin.admin.delete');
});

// ================== GURU ================== //
Route::middleware(['auth', 'guru'])->prefix('guru')->group(function () {
    Route::get('/dashboard', [GuruController::class, 'dashboard'])->name('guru.dashboard');
    Route::post('/generate-code', [GuruController::class, 'generateCode'])->name('guru.generate-code');
    Route::get('/show-code/{id}', [GuruController::class, 'showCode'])->name('guru.show-code');
    Route::get('/monitoring', [GuruController::class, 'monitoring'])->name('guru.monitoring');
    Route::post('/input-manual', [GuruController::class, 'inputManual'])->name('guru.input-manual');
    Route::get('/export-excel', [GuruController::class, 'exportExcel'])->name('guru.export-excel');
    Route::get('/export-pdf', [GuruController::class, 'exportPDF'])->name('guru.export-pdf');
    Route::post('/toggle-code/{id}', [GuruController::class, 'toggleCode'])->name('guru.toggle-code');
});

// ================== SISWA ================== //
Route::middleware(['auth', 'siswa'])->prefix('siswa')->group(function () {
    Route::get('/dashboard', [SiswaController::class, 'dashboard'])->name('siswa.dashboard');
    Route::post('/inputqr', [SiswaController::class, 'inputQR'])->name('siswa.inputqr');
    Route::get('/riwayat', [SiswaController::class, 'riwayat'])->name('siswa.riwayat');
});

// ================== DEFAULT LARAVEL AUTH ================== //
Auth::routes();
Route::get('/home', [HomeController::class, 'index'])->name('home');
