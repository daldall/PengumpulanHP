@extends('layouts.app')

@section('content')
<div class="container d-flex align-items-center justify-content-center"
     style="min-height: 100vh; background: linear-gradient(135deg,rgb(161, 188, 255),rgb(141, 197, 252)); font-family:'Poppins', sans-serif;">
    <div class="row justify-content-center w-100">
        <div class="col-md-5">
            <div class="card shadow-lg border-0 rounded-4" style="background-color:#fff;">
                <div class="card-header text-center"
                     style="background: linear-gradient(135deg,rgb(161, 188, 255),rgb(141, 197, 252)); color:#fff; border-top-left-radius:0.75rem; border-top-right-radius:0.75rem;">
                    <img src="{{ asset('images/Sistem.png') }}"alt="Logo Sekolah" class="mb-2" width="70" style="object-fit:contain;">
                    <h4 class="fw-bold mb-0">Reset Password</h4>
                    <small>Silakan masukkan password baru Anda</small>
                </div>

                <div class="card-body p-4">
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">

                        {{-- Email --}}
                        <div class="mb-3">
                            <label for="email" class="form-label">{{ __('Email') }}</label>
                            <input id="email" type="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   name="email" value="{{ $email ?? old('email') }}" required autofocus>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Password Baru --}}
                        <div class="mb-3">
                            <label for="password" class="form-label">{{ __('Password Baru') }}</label>
                            <input id="password" type="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   name="password" required autocomplete="new-password">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Konfirmasi Password --}}
                        <div class="mb-3">
                            <label for="password-confirm" class="form-label">{{ __('Konfirmasi Password') }}</label>
                            <input id="password-confirm" type="password"
                                   class="form-control"
                                   name="password_confirmation" required autocomplete="new-password">
                        </div>

                        {{-- Tombol Reset --}}
                        <button type="submit" class="btn w-100 fw-bold"
                                style="background-color:#0d6efd; color:#fff; border:none; border-radius:0.5rem; transition:0.3s;"
                                onmouseover="this.style.backgroundColor='#0b5ed7';"
                                onmouseout="this.style.backgroundColor='#0d6efd';">
                            <i class="bi bi-arrow-repeat"></i> {{ __('Reset Password') }}
                        </button>
                    </form>
                </div>

                <div class="card-footer text-center"
                     style="background-color:#f8f9fa; border-bottom-left-radius:0.75rem; border-bottom-right-radius:0.75rem; font-size:0.875rem;">
                    <a href="{{ route('login') }}" class="text-decoration-none fw-bold" style="color:#0d6efd;">
                        <i class="bi bi-box-arrow-in-right"></i> Kembali ke Login
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
