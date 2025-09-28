@extends('layouts.app')

@section('content')
<div class="register-wrapper d-flex align-items-center justify-content-center">

    {{-- Setengah lingkaran kiri --}}
    <div class="half-circle"></div>

    <div class="row justify-content-center w-100 position-relative">
        <div class="col-md-4">
            <div class="register-card shadow-lg border-0 rounded-4 p-4">

                {{-- Header --}}
                <div class="text-center mb-4">
                    <img src="{{ asset('images/yasfat.png') }}" 
                         alt="Logo Sekolah" 
                         class="mb-3" 
                         width="70" 
                         style="object-fit:contain;">
                    <h4 class="fw-bold mb-0 text-white">Daftar Akun Guru</h4>
                    <small class="text-light">Isi data di bawah untuk registrasi</small>
                </div>

                {{-- Body --}}
                <form method="POST" action="{{ route('auth.register.guru.post') }}">
                    @csrf

                    {{-- Nama --}}
                    <div class="mb-3">
                        <label for="name" class="form-label fw-bold text-white">Nama Lengkap</label>
                        <input id="name" type="text"
                               class="form-control @error('name') is-invalid @enderror"
                               name="name" value="{{ old('name') }}"
                               required autofocus>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div class="mb-3">
                        <label for="email" class="form-label fw-bold text-white">Email</label>
                        <input id="email" type="email"
                               class="form-control @error('email') is-invalid @enderror"
                               name="email" value="{{ old('email') }}"
                               required>
                        @error('email')
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

                    {{-- Konfirmasi Password --}}
                    <div class="mb-3">
                        <label for="password-confirm" class="form-label fw-bold text-white">Konfirmasi Password</label>
                        <input id="password-confirm" type="password"
                               class="form-control"
                               name="password_confirmation" required>
                    </div>

                    {{-- Tombol Register --}}
                    <button type="submit" class="btn w-100 fw-bold register-btn">
                        <i class="bi bi-person-plus"></i> Register
                    </button>
                </form>

                {{-- Footer --}}
                <div class="text-center mt-3" style="font-size:0.875rem; color:white;">
                    Sudah punya akun?
                    <a href="{{ route('auth.login.guru') }}" class="fw-bold register-link">Login</a>
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
    overflow: hidden;
}

/* Background Gradient */
.register-wrapper {
    min-height: 100vh;
    width: 100vw;       
    margin: 0;         
    padding: 25px;        
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

/* Card Register */
.register-card {
    background: rgba(255, 255, 255, 0.05);
    backdrop-filter: blur(5px);
    border-radius: 10px;
    z-index: 1;
}

/* Tombol Register */
button.register-btn {
    background: #0d6efd;
    border: 1px solid #00a2ff;
    color: #fff;
    border-radius: 6px;
    padding: 10px;
    transition: 0.3s;
}

button.register-btn:hover {
    background: #0b5ed7;
}

/* Link Login */
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
