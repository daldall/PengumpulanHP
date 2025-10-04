@extends('layouts.app')

@section('content')
<div class="login-wrapper d-flex align-items-center justify-content-center">

    {{-- Setengah lingkaran kiri --}}
    <div class="half-circle"></div>

    <div class="row justify-content-center w-100 position-relative">
        <div class="col-md-4">
            <div class="login-card shadow-lg border-0 rounded-4 p-4">

                {{-- Header --}}
                <div class="text-center mb-4">
                    <img src="{{ asset('images/yasfat.png') }}" alt="Logo Sekolah" class="mb-3" width="70" style="object-fit:contain;">
                    <h4 class="fw-bold mb-0 text-white">Login Siswa</h4>
                    <small class="text-light">Silakan login menggunakan NIS & Password</small>
                </div>

                {{-- Body --}}
                <form method="POST" action="{{ route('auth.login.siswa.post') }}">
                    @csrf
                    {{-- NIS --}}
                    <div class="mb-3">
                        <label for="nis" class="form-label fw-bold text-white">NIS</label>
                        <input id="nis" type="text"
                               class="form-control @error('nis') is-invalid @enderror"
                               name="nis" value="{{ old('nis') }}" required autofocus>
                        @error('nis')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div class="mb-3">
                        <label for="password" class="form-label fw-bold text-white">Password</label>
                        <input id="password" type="password"
                               class="form-control @error('password') is-invalid @enderror"
                               name="password" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Remember Me --}}
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember">
                        <label class="form-check-label fw-bold text-white" for="remember">
                            Ingat Saya
                        </label>
                    </div>

                    {{-- Tombol Login --}}
                    <button type="submit" class="btn w-100 fw-bold login-btn">
                        <i class="bi bi-box-arrow-in-right"></i> Login
                    </button>
                </form>

                {{-- Footer --}}
                <div class="text-center mt-3" style="font-size:0.875rem; color:white;">
                    Belum punya akun?
                    <a href="{{ route('auth.register.siswa') }}" class="fw-bold register-link">Register</a>
                    <br>
                    © {{ date('Y') }} <strong>SMK FATAHILLAH</strong>
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
        overflow: hidden; /* biar tidak geser horizontal */
    }

    /* Background Gradient */
    .login-wrapper {
        min-height: 100vh;
        width: 100vw;
        margin: 0;
        padding: 0;
        background: linear-gradient(to bottom, #0d47a1, #6200ea);
        position: relative;
        font-family: 'Poppins', sans-serif;
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
    }

    /* Tombol Login */
    button.login-btn {
        background:  #0d6efd;
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

    @media (max-width: 768px) {
        .half-circle {
            display: none;
        }
    }
</style>
