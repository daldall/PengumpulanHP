@extends('layouts.app')

@section('content')
<div class="login-wrapper d-flex align-items-center justify-content-center">
    
    {{-- Setengah lingkaran kiri --}}
    <div class="half-circle"></div>

    <div class="row justify-content-center w-100 position-relative mx-0">
        <div class="col-xl-4 col-lg-5 col-md-6 col-sm-8 col-11">
            <div class="login-card shadow-lg border-0 rounded-4 p-4 p-md-5">
                
                {{-- Header --}}
                <div class="text-center mb-4 mb-md-5">
                    <img src="{{ asset('images/yasfat.png') }}" alt="Logo Sekolah" class="mb-3 mb-md-4" width="70" style="object-fit:contain;">
                    <h4 class="fw-bold mb-0 text-white fs-4 fs-md-3">Daftar Akun Siswa</h4>
                    <small class="text-light fs-6">Isi data di bawah untuk registrasi</small>
                </div>

                {{-- Body --}}
                <form method="POST" action="{{ route('auth.register.siswa.post') }}">
                    @csrf

                    {{-- Nama --}}
                    <div class="mb-4">
                        <label for="name" class="form-label fw-bold text-white">{{ __('Nama Lengkap') }}</label>
                        <input id="name" type="text"
                               class="form-control @error('name') is-invalid @enderror"
                               name="name" value="{{ old('name') }}"
                               required autofocus>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- NIS --}}
                    <div class="mb-4">
                        <label for="nis" class="form-label fw-bold text-white">{{ __('NIS') }}</label>
                        <input id="nis" type="text"
                               class="form-control @error('nis') is-invalid @enderror"
                               name="nis" value="{{ old('nis') }}" required>
                        @error('nis')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Kelas --}}
                    <div class="mb-4">
                        <label for="kelas" class="form-label fw-bold text-white">{{ __('Kelas') }}</label>
                        <input id="kelas" type="text"
                               class="form-control @error('kelas') is-invalid @enderror"
                               name="kelas" value="{{ old('kelas') }}" required>
                        @error('kelas')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div class="mb-4">
                        <label for="password" class="form-label fw-bold text-white">{{ __('Password') }}</label>
                        <input id="password" type="password"
                               class="form-control @error('password') is-invalid @enderror"
                               name="password" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Konfirmasi Password --}}
                    <div class="mb-4">
                        <label for="password-confirm" class="form-label fw-bold text-white">{{ __('Konfirmasi Password') }}</label>
                        <input id="password-confirm" type="password"
                               class="form-control"
                               name="password_confirmation" required>
                    </div>

                    {{-- Tombol Register --}}
                    <button type="submit" class="btn w-100 fw-bold login-btn py-3">
                        <i class="bi bi-person-plus"></i> {{ __('Register') }}
                    </button>
                </form>

                {{-- Footer --}}
                <div class="text-center mt-4">
                    <p class="mb-1 text-white">
                        Sudah punya akun?
                        <a href="{{ route('auth.login.siswa') }}" class="fw-bold register-link">Login</a>
                    </p>
                    <span class="text-light">© {{ date('Y') }} <strong>SMK FATAHILLAH</strong></span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

html, body {
    height: 100%;
    width: 100%;
    overflow-x: hidden;
    background: linear-gradient(to bottom, #0d47a1, #6200ea);
}

/* Background Gradient */
.login-wrapper {
    min-height: 100vh;
    height: auto;
    width: 100vw;       
    margin: 0;         
    padding: 15px;        
    background: linear-gradient(to bottom, #0d47a1, #6200ea);
    position: relative;
    font-family: 'Poppins', sans-serif;
    box-sizing: border-box;
}

/* Lingkaran setengah di kiri */
.half-circle {
    position: absolute;
    top: 0;
    left: -290px;
    width: 680px;
    height: 680px;
    background: #00bfff;
    border-radius: 50%;
    z-index: 0;
}

/* Card Login */
.login-card {
    background: rgba(255, 255, 255, 0.05);
    backdrop-filter: blur(5px);
    border-radius: 15px;
    z-index: 1;
    max-width: 100%;
}

/* Form Control */
.form-control {
    padding: 12px 15px;
    font-size: 16px;
    border-radius: 8px;
    border: 1px solid rgba(255, 255, 255, 0.3);
    background: rgba(255, 255, 255, 0.1);
    color: white;
}

.form-control:focus {
    background: rgba(255, 255, 255, 0.15);
    border-color: #0d6efd;
    color: white;
    box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
}

.form-control::placeholder {
    color: rgba(255, 255, 255, 0.7);
}

/* Tombol Login */
button.login-btn {
    background: #0d6efd;
    border: 1px solid #00a2ff;
    color: #fff;
    border-radius: 8px;
    padding: 12px;
    transition: 0.3s;
    font-size: 16px;
}

button.login-btn:hover {
    background: #0b5ed7;
    transform: translateY(-1px);
}

/* Link Register */
.register-link {
    color: yellow;
    text-decoration: none;
}

.register-link:hover {
    text-decoration: underline;
}

/* Remove default bootstrap margins */
.row {
    margin: 0 !important;
}

.container-fluid, .container {
    padding: 0 !important;
    margin: 0 !important;
}

/* Responsive breakpoints */
@media (max-width: 576px) {
    .half-circle {
        display: none;
    }
    
    .login-wrapper {
        padding: 10px;
        min-height: 100vh;
    }
    
    .login-card {
        padding: 1.5rem !important;
    }
    
    .login-card img {
        width: 60px !important;
    }
    
    .login-card h4 {
        font-size: 1.3rem !important;
    }
    
    .form-control {
        padding: 10px 12px;
        font-size: 14px;
    }
    
    .login-btn {
        padding: 10px !important;
        font-size: 14px !important;
    }
}

@media (max-width: 768px) {
    .half-circle {
        left: -400px;
        width: 500px;
        height: 500px;
    }
    
    .login-wrapper {
        min-height: 100vh;
    }
}

@media (min-width: 992px) {
    .login-wrapper {
        padding: 20px;
        min-height: 100vh;
    }
}

/* Ensure full screen on all devices */
@media (max-height: 600px) {
    .login-wrapper {
        min-height: 100vh;
        height: auto;
    }
}
</style>