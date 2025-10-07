<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Auth;

// ================== ROOT ================== //
Route::get('/', [AuthController::class, 'showLoginForm'])->name('home');

Route::get('/scan-code/{kode}/{jenis}', [SiswaController::class, 'scanCode'])->name('scan.code');

// ================== AUTH ================== //
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Route untuk refresh CSRF token
Route::post('/refresh-csrf', function () {
    return response()->json(['token' => csrf_token()]);
})->name('refresh.csrf');

// ================== ADMIN ================== //
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

       // Export routes
       Route::get('/guru/export-excel', [AdminController::class, 'exportGuruExcel'])->name('admin.guru.export-excel');
       Route::get('/guru/export-pdf', [AdminController::class, 'exportGuruPDF'])->name('admin.guru.export-pdf');
       Route::get('/siswa/export-excel', [AdminController::class, 'exportSiswaExcel'])->name('admin.siswa.export-excel');
       Route::get('/siswa/export-pdf', [AdminController::class, 'exportSiswaPDF'])->name('admin.siswa.export-pdf');
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
