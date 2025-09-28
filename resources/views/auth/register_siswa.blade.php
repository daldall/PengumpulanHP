@extends('layouts.app')

@section('content')
<div class="container d-flex align-items-center justify-content-center"
     style="min-height: 100vh; font-family:'Poppins', sans-serif;">

    <div class="row justify-content-center w-100">
        <div class="col-md-5">

            <div class="card shadow-lg border-0 rounded-4" style="background-color:#fff;">

                {{-- Header --}}
                <div class="card-header text-center"
                     style="background: linear-gradient(135deg,rgb(161, 188, 255),rgb(141, 197, 252));
                            color:#fff;
                            border-top-left-radius:0.75rem;
                            border-top-right-radius:0.75rem;">

                    <img src="{{ asset('images/yasfat.png') }}"
                         alt="Logo Sekolah"
                         class="mb-2"
                         width="70"
                         style="object-fit:contain;">

                    <h4 class="fw-bold mb-0">Daftar Akun Siswa</h4>
                    <small>Isi data di bawah untuk registrasi</small>
                </div>

                {{-- Body --}}
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('auth.register.siswa.post') }}">
                        @csrf

                        {{-- Nama --}}
                        <div class="mb-3">
                            <label for="name" class="form-label fw-bold">{{ __('Nama Lengkap') }}</label>
                            <input id="name" type="text"
                                   class="form-control @error('name') is-invalid @enderror"
                                   name="name" value="{{ old('name') }}"
                                   required autofocus>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- NIS --}}
                        <div class="mb-3">
                            <label for="nis" class="form-label fw-bold">{{ __('NIS') }}</label>
                            <input id="nis" type="text"
                                   class="form-control @error('nis') is-invalid @enderror"
                                   name="nis" value="{{ old('nis') }}" required>
                            @error('nis')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Kelas --}}
                        <div class="mb-3">
                            <label for="kelas" class="form-label fw-bold">{{ __('Kelas') }}</label>
                            <input id="kelas" type="text"
                                   class="form-control @error('kelas') is-invalid @enderror"
                                   name="kelas" value="{{ old('kelas') }}" required>
                            @error('kelas')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Password --}}
                        <div class="mb-3">
                            <label for="password" class="form-label fw-bold">{{ __('Password') }}</label>
                            <input id="password" type="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   name="password" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Konfirmasi Password --}}
                        <div class="mb-3">
                            <label for="password-confirm" class="form-label fw-bold">{{ __('Konfirmasi Password') }}</label>
                            <input id="password-confirm" type="password"
                                   class="form-control"
                                   name="password_confirmation" required>
                        </div>

                        {{-- Tombol Register --}}
                        <button type="submit"
                                class="btn w-100 fw-bold"
                                style="background-color:#0d6efd; color:#fff; border:none; border-radius:0.5rem;">
                            <i class="bi bi-person-plus"></i> {{ __('Register') }}
                        </button>
                    </form>
                </div>

                {{-- Footer --}}
                <div class="card-footer text-center"
                     style="background-color:#f8f9fa;
                            border-bottom-left-radius:0.75rem;
                            border-bottom-right-radius:0.75rem;
                            font-size:0.875rem;">
                    Sudah punya akun?
                    <a href="{{ route('auth.login.siswa') }}"
                       class="text-decoration-none fw-bold"
                       style="color:#0d6efd;">
                        Login
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
