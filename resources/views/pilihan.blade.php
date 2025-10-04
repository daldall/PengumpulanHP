
@extends('layouts.app')

@section('content')
<style>
    body {
        margin: 0;
        padding: 0;
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(135deg, #0d6efd, #6610f2);
        min-height: 100vh;
    }

    .logo-container img {
        width: 140px;
        height: 140px;
        border-radius: 50%;
    }


    .logo-container h2 {
        color: #fff;
        font-weight: 600;
        margin-top: 20px;
        font-size: 1.8rem;
    }

    .logo-container p {
        color: rgba(255, 255, 255, 0.8);
        margin: 0;
        font-size: 1rem;
    }

    .card-option {
        background: rgba(255, 255, 255, 0.12);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 16px;
        color: white;
        transition: all 0.3s ease-in-out;
        cursor: pointer;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        position: relative;
        overflow: hidden;
    }

    .card-option::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
        transition: left 0.5s;
    }

    .card-option:hover::before {
        left: 100%;
    }

    .card-option:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
        background: rgba(255, 255, 255, 0.15);
    }

    .card-option .card-body {
        padding: 40px 30px;
        text-align: center;
    }

    .card-option i {
        display: block;
        margin-bottom: 20px;
        opacity: 0.9;
        color: white;
    }

    .card-option .card-title {
        margin: 0 0 20px 0;
        font-weight: 600;
        font-size: 1.3rem;
        color: #fff;
    }

    .card-option .btn-custom {
        width: 100%;
        padding: 12px 20px;
        border: none;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.2s ease;
        background: rgba(255, 255, 255, 0.2);
        color: #fff;
        backdrop-filter: blur(10px);
    }

    .card-option .btn-custom:hover {
        background: rgba(255, 255, 255, 0.3);
        transform: translateY(-2px);
        color: #fff;
    }

    /* Modal Styling */
    .modal-content {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(15px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        border-radius: 16px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
    }

    .modal-header {
        border-bottom: 1px solid rgba(0, 0, 0, 0.1);
    }

    .modal-title {
        color: #333;
        font-weight: 600;
    }

    .modal-body input {
        border: 1px solid rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        padding: 12px 15px;
        font-size: 1rem;
        transition: border-color 0.2s ease;
    }

    .modal-body input:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
    }

    .modal-footer {
        border-top: 1px solid rgba(0, 0, 0, 0.1);
        gap: 10px;
    }

    .modal-footer .btn {
        border-radius: 8px;
        padding: 10px 25px;
        font-weight: 500;
        transition: all 0.2s ease;
    }

    .modal-footer .btn-primary {
        background: linear-gradient(135deg, #0d6efd, #6610f2);
        border: none;
    }

    .modal-footer .btn-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(13, 110, 253, 0.3);
    }

    @media (max-width: 768px) {
        .logo-container h2 {
            font-size: 1.5rem;
        }

        .logo-container img {
            width: 120px;
            height: 120px;
        }

        .card-option .card-body {
            padding: 35px 25px;
        }
    }

    @media (max-width: 480px) {
        .card-option {
            margin-bottom: 20px;
        }
    }
</style>

{{-- Content --}}
<div class="d-flex align-items-center justify-content-center min-vh-100">
    <div class="container">
        {{-- Logo --}}
        <div class="logo-container text-center mb-5">
            <a href="{{ route('auth.login.admin') }}" class="text-decoration-none">
                <img src="{{ asset('images/Sistem.png') }}" alt="Yasfat Logo">
            </a>
            <h2>Sistem Pengumpulan HP Yasfat</h2>
            <p>Silakan pilih role untuk masuk</p>
        </div>

        <div class="row justify-content-center g-4">
            {{-- Pilih Siswa --}}
            <div class="col-lg-5 col-md-6 col-12">
                <div class="card-option card h-100" onclick="window.location='{{ route('auth.login.siswa') }}'">
                    <div class="card-body">
                        <i class="fas fa-user-graduate fa-3x mb-3"></i>
                        <h4 class="card-title">Siswa</h4>
                        <button class="btn btn-custom">Masuk Sebagai Siswa</button>
                    </div>
                </div>
            </div>

            {{-- Pilih Guru --}}
            <div class="col-lg-5 col-md-6 col-12">
                <div class="card-option card h-100" data-bs-toggle="modal" data-bs-target="#guruPasswordModal">
                    <div class="card-body">
                        <i class="fas fa-chalkboard-teacher fa-3x mb-3"></i>
                        <h4 class="card-title">Guru</h4>
                        <button class="btn btn-custom">Masuk Sebagai Guru</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal Password Guru --}}
<div class="modal fade" id="guruPasswordModal" tabindex="-1" aria-labelledby="guruPasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="guruPasswordModalLabel">Masukkan Pin Guru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('auth.guru.password.check') }}">
                @csrf
                <div class="modal-body">
                    <input type="password" name="guru_password" class="form-control" placeholder="Password Guru" required>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Masuk</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
