@extends('layouts.app')

@section('content')
<div class="container d-flex align-items-center justify-content-center" style="min-height: 100vh; font-family:'Poppins', sans-serif;">
    <div class="row justify-content-center w-100">
        <div class="col-md-5">
            <div class="card shadow-lg border-0 rounded-4" style="background-color:#fff;">

                {{-- Header --}}
                <div class="card-header text-center"
                     style="background: linear-gradient(135deg,rgb(161, 188, 255),rgb(141, 197, 252));
                            color:#fff;
                            border-top-left-radius:0.75rem;
                            border-top-right-radius:0.75rem;">

                    <img src="{{ asset('images/yasfat.png') }}" alt="Logo Sekolah" class="mb-2" width="70" style="object-fit:contain;">
                    <h4 class="fw-bold mb-0">Login Guru</h4>
                    <small>Silakan login menggunakan Email & password</small>
                </div>

                {{-- Body --}}
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('auth.login.guru.post') }}">
                        @csrf

                        {{-- Email --}}
                        <div class="mb-3">
                            <label for="email" class="form-label fw-bold">{{ __('Email') }}</label>
                            <input id="email" type="email"
                                class="form-control @error('email') is-invalid @enderror"
                                name="email" value="{{ old('email') }}" required autofocus
                                style="border-radius:0.5rem; border:1px solid #ced4da;">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Password --}}
                        <div class="mb-3">
                            <label for="password" class="form-label fw-bold">{{ __('Password') }}</label>
                            <input id="password" type="password"
                                class="form-control @error('password') is-invalid @enderror"
                                name="password" required
                                style="border-radius:0.5rem; border:1px solid #ced4da;">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Remember Me --}}
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember">
                            <label class="form-check-label fw-bold" for="remember">
                                {{ __('Ingat Saya') }}
                            </label>
                        </div>

                        {{-- Tombol Login --}}
                        <button type="submit" class="btn w-100 fw-bold"
                                style="background-color:#0d6efd; color:#fff; border:none; border-radius:0.5rem; transition:0.3s;"
                                onmouseover="this.style.backgroundColor='#0b5ed7';"
                                onmouseout="this.style.backgroundColor='#0d6efd';">
                            <i class="bi bi-box-arrow-in-right"></i> {{ __('Login') }}
                        </button>
                    </form>
                </div>

                {{-- Footer --}}
                <div class="card-footer text-center"
                     style="background-color:#f8f9fa; border-bottom-left-radius:0.75rem; border-bottom-right-radius:0.75rem; font-size:0.875rem;">
                    Belum punya akun?
                    <a href="{{ route('auth.register.guru') }}" class="text-decoration-none fw-bold" style="color:#0d6efd;">Register</a>
                    <br>
                    © {{ date('Y') }} <strong>Sekolah Kita</strong>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
