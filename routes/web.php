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

// Login/Register POST
Route::post('/login/siswa', [AuthController::class, 'postLoginSiswa'])->name('auth.login.siswa.post');
Route::post('/register/siswa', [AuthController::class, 'postRegisterSiswa'])->name('auth.register.siswa.post');
Route::post('/login/guru', [AuthController::class, 'postLoginGuru'])->name('auth.login.guru.post');
Route::post('/register/guru', [AuthController::class, 'postRegisterGuru'])->name('auth.register.guru.post');

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    
    // Guru CRUD Routes
    Route::get('/guru/create', [AdminController::class, 'createGuru'])->name('admin.guru.create');
    Route::post('/guru/store', [AdminController::class, 'storeGuru'])->name('admin.guru.store');
    Route::get('/guru/{id}/edit', [AdminController::class, 'editGuru'])->name('admin.guru.edit');
    Route::put('/guru/{id}/update', [AdminController::class, 'updateGuru'])->name('admin.guru.update');
    Route::delete('/guru/{id}/delete', [AdminController::class, 'deleteGuru'])->name('admin.guru.delete');
    
    // Siswa CRUD Routes
    Route::get('/siswa/create', [AdminController::class, 'createSiswa'])->name('admin.siswa.create');
    Route::post('/siswa/store', [AdminController::class, 'storeSiswa'])->name('admin.siswa.store');
    Route::get('/siswa/{id}/edit', [AdminController::class, 'editSiswa'])->name('admin.siswa.edit');
    Route::put('/siswa/{id}/update', [AdminController::class, 'updateSiswa'])->name('admin.siswa.update');
    Route::delete('/siswa/{id}/delete', [AdminController::class, 'deleteSiswa'])->name('admin.siswa.delete');
});

// Guru Routes
Route::middleware(['auth', 'guru'])->prefix('guru')->group(function () {
    Route::get('/dashboard', [GuruController::class, 'dashboard'])->name('guru.dashboard');
    Route::post('/generate-code', [GuruController::class, 'generateCode'])->name('guru.generate-code');
    Route::get('/show-code/{id}', [GuruController::class, 'showCode'])->name('guru.show-code');
    Route::get('/monitoring', [GuruController::class, 'monitoring'])->name('guru.monitoring');
    Route::post('/input-manual', [GuruController::class, 'inputManual'])->name('guru.input-manual');
    Route::get('/export-excel', [GuruController::class, 'exportExcel'])->name('guru.export-excel');
    Route::get('/export-pdf', [GuruController::class, 'exportPDF'])->name('guru.export-pdf');
});

// Siswa Routes
Route::middleware(['auth', 'siswa'])->prefix('siswa')->group(function () {
    Route::get('/dashboard', [SiswaController::class, 'dashboard'])->name('siswa.dashboard');
    Route::post('/input-qr', [SiswaController::class, 'inputQR'])->name('siswa.input-qr');
    Route::get('/riwayat', [SiswaController::class, 'riwayat'])->name('siswa.riwayat');
});

// Auth redirect untuk home
Auth::routes();
Route::get('/home', [HomeController::class, 'index'])->name('home');