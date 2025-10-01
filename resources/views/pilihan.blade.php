    @extends('layouts.app2')

    @section('content')
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #0d6efd, #6610f2);
            min-height: 100vh;
        }

        .logo-container {
            text-align: center;
            margin-bottom: 40px;
        }

        .logo-container img {
            width: 120px;
            height: 120px;
        }

        .card-option {
            background: rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(12px);
            border-radius: 12px;
            text-align: center;
            padding: 40px 20px;
            transition: transform 0.2s ease-in-out;
            cursor: pointer;
            color: white;
            min-width: 220px;
        }
        .card-option:hover {
            transform: translateY(-5px);
        }
        .card-option h4 {
            margin-top: 15px;
            font-weight: bold;
            color: #fff;
        }
        .card-option button {
            margin-top: 15px;
            width: 80%;
        }
        @media(max-width: 768px){
            .card-option {
                margin-bottom: 20px;
            }
        }
    </style>

    {{-- Content --}}
    <div class="d-flex align-items-center justify-content-center min-vh-100">
        <div class="container text-center">
        {{-- Logo --}}
        <div class="logo-container">
            <a onclick="window.location='{{ route('auth.login.admin') }}'">
                <img src="{{ asset('images/yasfat.png') }}" alt="Yasfat Logo">
            </a>
            <h2 class="fw-bold text-white mt-3">Sistem Pengumpulan HP Yasfat</h2>
            <p class="text-white-50">Silakan pilih role untuk masuk</p>
        </div>


            <div class="row justify-content-center g-4">

                {{-- Pilih Siswa --}}
                <div class="col-md-4 col-10">
                    <div class="card-option" onclick="window.location='{{ route('auth.login.siswa') }}'">
                        <i class="fas fa-user-graduate fa-3x text-white"></i>
                        <h4>Siswa</h4>
                        <button class="btn btn-primary">Masuk</button>
                    </div>
                </div>

                {{-- Pilih Guru --}}
                <div class="col-md-4 col-10">
                    <div class="card-option" data-bs-toggle="modal" data-bs-target="#guruPasswordModal">
                        <i class="fas fa-chalkboard-teacher fa-3x text-white"></i>
                        <h4>Guru</h4>
                        <button class="btn btn-primary">Masuk</button>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- Modal Password Guru --}}
    <div class="modal fade" id="guruPasswordModal" tabindex="-1" aria-labelledby="guruPasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4">
        <div class="modal-header">
            <h5 class="modal-title fw-bold" id="guruPasswordModalLabel">Masukkan Password Guru</h5>
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
