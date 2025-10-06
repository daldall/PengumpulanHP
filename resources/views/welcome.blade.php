@extends('layouts.app')

@section('content')
<div class="landing-wrapper d-flex align-items-center justify-content-center">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow-lg border-0 rounded-5 overflow-hidden"> <!-- Ubah border-radius -->

                    <!-- Header -->
                    <div class="text-center py-4 bg-gradient-primary text-white rounded-top-5">
                        <img src="{{ asset('images/yasfat.png') }}" alt="Logo SMK Fatahillah" width="100" class="mb-3">
                        <h1 class="fw-bold mb-0">Sistem Pengumpulan Handphone</h1>
                        <p class="lead mb-0">SMK Fatahillah Cileungsi</p>
                    </div>

                    <!-- Konten utama -->
                    <div class="card-body p-4 p-md-5">
                        <div class="row align-items-center">
                          <!-- Cara Penggunaan -->
                        <div class="col-lg-6 mb-4 mb-lg-0">
                            <h3 class="fw-bold mb-4 text-primary">Cara Penggunaan</h3>
                            <p class="lead mb-4">Panduan singkat cara menggunakan sistem pengumpulan dan pengambilan HP di SMK Fatahillah.</p>

                            <div class="features mb-4">
                                <div class="feature-item">
                                    <div class="feature-icon bg-primary bg-opacity-10 p-2 rounded-circle">
                                        <i class="fas fa-sign-in-alt text-primary"></i>
                                    </div>
                                    <div class="feature-text">
                                        <h5>Login Sistem</h5>
                                        <small>Masuk menggunakan NIS</small>
                                    </div>
                                </div>

                                <div class="feature-item">
                                    <div class="feature-icon bg-success bg-opacity-10 p-2 rounded-circle">
                                        <i class="fas fa-mobile-alt text-success"></i>
                                    </div>
                                    <div class="feature-text">
                                        <h5>Serahkan/Ambil HP</h5>
                                        <small>Scan QR code untuk menyerahkan atau mengambil HP</small>
                                    </div>
                                </div>

                                <div class="feature-item">
                                    <div class="feature-icon bg-info bg-opacity-10 p-2 rounded-circle">
                                        <i class="fas fa-history text-info"></i>
                                    </div>
                                    <div class="feature-text">
                                        <h5>Cek Riwayat</h5>
                                        <small>Lihat histori pengumpulan dan pengambilan HP</small>
                                    </div>
                                </div>
                            </div>
                            </div>

                            <!-- Login Box -->
                            <div class="col-lg-6">
                                <div class="login-box p-4 bg-light rounded-4 shadow-sm">
                                    <h4 class="text-center mb-4 fw-bold">Login Sistem</h4>

                                    @if(session('error'))
                                        <div class="alert alert-danger alert-dismissible fade show">
                                            {{ session('error') }}
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                        </div>
                                    @endif

                                    <form method="POST" action="{{ route('login') }}">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="login_id" class="form-label fw-bold">NIS / Email</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                                <input id="login_id" type="text" class="form-control @error('login_id') is-invalid @enderror"
                                                    name="login_id" value="{{ old('login_id') }}" required autofocus
                                                    placeholder="Masukkan NIS / Email">
                                            </div>
                                            @error('login_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="password" class="form-label fw-bold">Password</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                                                    name="password" required placeholder="Masukkan password">
                                            </div>
                                            @error('password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3 form-check">
                                            <input type="checkbox" class="form-check-input" id="remember" name="remember">
                                            <label class="form-check-label" for="remember">Ingat Saya</label>
                                        </div>

                                        <div class="d-grid">
                                            <button type="submit" class="btn btn-primary py-2 fw-bold">
                                                <i class="fas fa-sign-in-alt me-2"></i> Masuk
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="card-footer bg-light text-center py-3 rounded-bottom-5">
                        <p class="mb-0">© {{ date('Y') }} <strong>SMK Fatahillah</strong> - Sistem Pengumpulan HP</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* ----- GLOBAL ----- */
.landing-wrapper {
    min-height: 100vh;
    background: linear-gradient(135deg, #0d47a1, #6200ea);
    padding: 20px 10px;
}

.bg-gradient-primary {
    background: linear-gradient(to right, #0d47a1, #1976d2);
}

.login-box {
    transition: all 0.3s ease;
}

.login-box:hover {
    transform: translateY(-5px);
}

/* ----- FEATURES ----- */
.features {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.feature-item {
    display: flex;
    align-items: center;
    gap: 10px;
}

.feature-item .feature-icon {
    flex-shrink: 0;
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.feature-item .feature-text h5 {
    margin: 0;
    font-size: 1rem;
}

.feature-item .feature-text small {
    display: block;
    color: #6c757d;
}

/* ----- RESPONSIVE ----- */

/* Tablet */
@media (max-width: 991px) {
    .card-body .row.align-items-center {
        flex-direction: column-reverse;
        text-align: center;
        gap: 20px;
    }

    .card-body .col-lg-6 {
        width: 100%;
        border-radius: 15px;
    }

    .feature-item {
        justify-content: center;
        flex-direction: column;
        text-align: center;
    }

    .feature-item .feature-text h5 {
        font-size: 1rem;
    }

    .feature-item .feature-text small {
        font-size: 0.85rem;
    }

    .feature-icon {
        margin-bottom: 8px;
    }
}

/* HP / Small Devices */
@media (max-width: 576px) {
    .card-body {
        padding: 15px !important;
    }

    h3.fw-bold {
        font-size: 1.3rem;
    }

    .lead {
        font-size: 0.9rem;
    }

    .feature-item .feature-text h5 {
        font-size: 0.95rem;
    }

    .feature-item .feature-text small {
        font-size: 0.8rem;
    }

    .feature-icon {
        width: 30px;
        height: 30px;
    }

    .feature-icon i {
        font-size: 14px;
    }

    .login-box {
        padding: 15px !important;
    }

    .login-box h4 {
        font-size: 1.2rem;
    }

    .input-group-text i {
        font-size: 14px;
    }

    .btn {
        font-size: 0.9rem;
        padding: 0.375rem 0.75rem;
    }
}

/* Sangat kecil */
@media (max-width: 400px) {
    .card-footer {
        padding: 10px 5px;
        font-size: 0.8rem;
    }
}
</style>
@endsection
