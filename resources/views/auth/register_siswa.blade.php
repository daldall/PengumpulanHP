@extends('layouts.app')

@section('content')
<div class="login-wrapper d-flex align-items-center justify-content-center">
    
    {{-- Setengah lingkaran kiri --}}
    <div class="half-circle"></div>

    <div class="row justify-content-center w-100 position-relative mx-0">
        <div class="col-xl-3 col-lg-4 col-md-5 col-sm-7 col-10">
            <div class="login-card shadow-lg border-0 rounded-4 p-3 p-md-4">
                
                {{-- Header --}}
                <div class="text-center mb-3 mb-md-4">
                    <img src="{{ asset('images/yasfat.png') }}" alt="Logo Sekolah" class="mb-2 mb-md-3" width="60" style="object-fit:contain;">
                    <h4 class="fw-bold mb-0 text-white fs-5 fs-md-4">Daftar Akun Siswa</h4>
                    <small class="text-light">Isi data di bawah untuk registrasi</small>
                </div>

                {{-- Body --}}
                <form method="POST" action="{{ route('auth.register.siswa.post') }}">
                    @csrf

                    {{-- Nama --}}
                    <div class="mb-3">
                        <label for="name" class="form-label fw-bold text-white small">{{ __('Nama Lengkap') }}</label>
                        <input id="name" type="text"
                               class="form-control form-control-sm @error('name') is-invalid @enderror"
                               name="name" value="{{ old('name') }}"
                               required autofocus>
                        @error('name')
                            <div class="invalid-feedback small">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- NIS --}}
                    <div class="mb-3">
                        <label for="nis" class="form-label fw-bold text-white small">{{ __('NIS') }}</label>
                        <input id="nis" type="text"
                               class="form-control form-control-sm @error('nis') is-invalid @enderror"
                               name="nis" value="{{ old('nis') }}" required>
                        @error('nis')
                            <div class="invalid-feedback small">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Kelas --}}
                    <div class="mb-3">
                        <label for="kelas" class="form-label fw-bold text-white small">{{ __('Kelas') }}</label>
                        <input id="kelas" type="text"
                               class="form-control form-control-sm @error('kelas') is-invalid @enderror"
                               name="kelas" value="{{ old('kelas') }}" required>
                        @error('kelas')
                            <div class="invalid-feedback small">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div class="mb-3">
                        <label for="password" class="form-label fw-bold text-white small">{{ __('Password') }}</label>
                        <input id="password" type="password"
                               class="form-control form-control-sm @error('password') is-invalid @enderror"
                               name="password" required>
                        @error('password')
                            <div class="invalid-feedback small">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Konfirmasi Password --}}
                    <div class="mb-3">
                        <label for="password-confirm" class="form-label fw-bold text-white small">{{ __('Konfirmasi Password') }}</label>
                        <input id="password-confirm" type="password"
                               class="form-control form-control-sm"
                               name="password_confirmation" required>
                    </div>

                    {{-- Tombol Register --}}
                    <button type="submit" class="btn w-100 fw-bold login-btn">
                        <i class="bi bi-person-plus"></i> {{ __('Register') }}
                    </button>
                </form>

                {{-- Footer --}}
                <div class="text-center mt-3" style="font-size:0.75rem; color:white;">
                    Sudah punya akun?
                    <a href="{{ route('auth.login.siswa') }}" class="fw-bold register-link">Login</a>
                    <br>
                    <span class="d-block mt-1">© {{ date('Y') }} <strong>SMK FATAHILLAH</strong></span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<style>
    html, body {
        margin: 0;
        padding: 0;
        height: 100%;
        overflow-x: hidden; /* hanya hide horizontal scroll */
    }

    /* Background Gradient */
    .login-wrapper {
        min-height: 100vh;
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
        border-radius: 10px;
        z-index: 1;
        max-width: 100%;
    }

    /* Tombol Login */
    button.login-btn {
        background: #0d6efd;
        border: 1px solid #00a2ff;
        color: #fff;
        border-radius: 6px;
        padding: 10px;
        transition: 0.3s;
    }

    button.login-btn:hover {
        background: #0b5ed7;
    }

    /* Link Register */
    .register-link {
        color: yellow;
        text-decoration: none;
    }

    .register-link:hover {
        text-decoration: underline;
    }

    /* Responsive breakpoints */
    @media (max-width: 576px) {
        .half-circle {
            display: none;
        }
        
        .login-wrapper {
            padding: 10px;
        }
        
        .login-card {
            padding: 1rem !important;
        }
        
        .login-card img {
            width: 50px !important;
        }
        
        .login-card h4 {
            font-size: 1.1rem !important;
        }
    }

    @media (max-width: 768px) {
        .half-circle {
            left: -400px;
            width: 500px;
            height: 500px;
        }
    }

    @media (min-width: 992px) {
        .login-wrapper {
            padding: 20px;
        }
    }

    /* Form control responsive */
    @media (max-width: 576px) {
        .form-control-sm {
            font-size: 0.875rem;
            padding: 0.375rem 0.75rem;
        }
        
        .form-label {
            font-size: 0.8rem;
        }
    }
</style>