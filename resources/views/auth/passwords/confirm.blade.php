@extends('layouts.app')

@section('content')
<div class="container d-flex align-items-center justify-content-center"
     style="min-height: 100vh; font-family:'Poppins', sans-serif;">
    <div class="row justify-content-center w-100">
        <div class="col-md-5">
            <div class="card shadow-lg border-0 rounded-4" style="background-color:#fff;">
                <div class="card-header text-center"
                     style="background: linear-gradient(135deg,rgb(161, 188, 255),rgb(141, 197, 252)); color:#fff; border-top-left-radius:0.75rem; border-top-right-radius:0.75rem;">
                    <img src="{{ asset('images/yasfat.png') }}" alt="Logo Sekolah" class="mb-2" width="70" style="object-fit:contain;">
                    <h4 class="fw-bold mb-0">Konfirmasi Password</h4>
                    <small>Masukkan password Anda untuk melanjutkan</small>
                </div>

                <div class="card-body p-4">
                    <form method="POST" action="{{ route('password.confirm') }}">
                        @csrf

                        {{-- Input Password --}}
                        <div class="mb-3">
                            <label for="password" class="form-label">{{ __('Password') }}</label>
                            <input id="password" type="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   name="password" required autocomplete="current-password">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Tombol Konfirmasi --}}
                        <button type="submit" class="btn w-100 fw-bold"
                                style="background-color:#0d6efd; color:#fff; border:none; border-radius:0.5rem; transition:0.3s;"
                                onmouseover="this.style.backgroundColor='#0b5ed7';"
                                onmouseout="this.style.backgroundColor='#0d6efd';">
                            <i class="bi bi-shield-lock"></i> Konfirmasi Password
                        </button>
                    </form>

                    {{-- Link Lupa Password --}}
                    @if (Route::has('password.request'))
                        <div class="text-center mt-3">
                            <a class="text-decoration-none small fw-bold" href="{{ route('password.request') }}"
                               style="color:#0d6efd;">
                                <i class="bi bi-question-circle"></i> Lupa Password?
                            </a>
                        </div>
                    @endif
                </div>

                <div class="card-footer text-center"
                     style="background-color:#f8f9fa; border-bottom-left-radius:0.75rem; border-bottom-right-radius:0.75rem; font-size:0.875rem;">
                    © {{ date('Y') }} <strong>Sekolah Kita</strong>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
