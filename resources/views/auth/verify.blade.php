@extends('layouts.app')

@section('content')
<div class="container d-flex align-items-center justify-content-center" style="min-height: 100vh; font-family:'Poppins', sans-serif;">
    <div class="row justify-content-center w-100">
        <div class="col-md-5">
            <div class="card shadow-lg border-0 rounded-4" style="background-color:#fff;">
                <div class="card-header text-center" style="background: linear-gradient(135deg,rgb(161, 188, 255),rgb(141, 197, 252)); color:#fff; border-top-left-radius:0.75rem; border-top-right-radius:0.75rem;">
                    <img src="{{ asset('images/yasfat.png') }}" alt="Logo Sekolah" class="mb-2" width="70" style="object-fit:contain;">
                    <h4 class="fw-bold mb-0">Verifikasi Email</h4>
                    <small>Silakan cek email Anda untuk melanjutkan</small>
                </div>

                <div class="card-body p-4 text-center">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert" style="border-radius:0.5rem;">
                            {{ __('Link verifikasi baru telah dikirim ke alamat email Anda.') }}
                        </div>
                    @endif

                    <p class="mb-3">
                        {{ __('Sebelum melanjutkan, silakan cek email Anda untuk link verifikasi.') }}<br>
                        {{ __('Jika Anda tidak menerima email, klik tombol di bawah ini:') }}
                    </p>

                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn fw-bold w-100"
                                style="background-color:#0d6efd; color:#fff; border:none; border-radius:0.5rem; transition:0.3s;"
                                onmouseover="this.style.backgroundColor='#0b5ed7';"
                                onmouseout="this.style.backgroundColor='#0d6efd';">
                            <i class="bi bi-envelope-check"></i> {{ __('Kirim Ulang Email Verifikasi') }}
                        </button>
                    </form>
                </div>

                <div class="card-footer text-center" style="background-color:#f8f9fa; border-bottom-left-radius:0.75rem; border-bottom-right-radius:0.75rem; font-size:0.875rem;">
                    © {{ date('Y') }} <strong>Sekolah Kita</strong>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
