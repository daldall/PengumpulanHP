@extends('layouts.app')
@include('include.navbar')
@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
             <div class="card-header text-center">
            <h2 class="mb-4 text-center fw-bold">Dashboard Siswa</h2>

            {{-- Alerts --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show shadow-sm">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show shadow-sm">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{-- Status Pengumpulan & Pengambilan --}}
            <div class="row mb-4 g-4">
                <div class="col-md-6">
                    <div class="card shadow-sm border-0 {{ $kumpulHariIni ? 'border-success' : 'border-danger' }}">
                        <div class="card-header {{ $kumpulHariIni ? 'bg-success text-white' : 'bg-danger text-white' }}">
                            <i class="fas fa-mobile-alt me-2"></i> Status Pengumpulan HP
                        </div>
                        <div class="card-body">
                            @if($kumpulHariIni)
                                <h5 class="text-success"><i class="fas fa-check-circle me-2"></i>Sudah Dikumpulkan</h5>
                                <p><strong>Waktu:</strong> {{ $kumpulHariIni->waktu_input->format('H:i:s') }}<br>
                                <strong>Metode:</strong> {{ ucfirst($kumpulHariIni->metode) }}</p>
                            @else
                                <h5 class="text-danger"><i class="fas fa-times-circle me-2"></i>Belum Dikumpulkan</h5>
                                <p>HP belum dikumpulkan hari ini</p>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card shadow-sm border-0 {{ $ambilHariIni ? 'border-success' : 'border-warning' }}">
                        <div class="card-header {{ $ambilHariIni ? 'bg-success text-white' : 'bg-warning text-dark' }}">
                            <i class="fas fa-hand-holding me-2"></i> Status Pengambilan HP
                        </div>
                        <div class="card-body">
                            @if($ambilHariIni)
                                <h5 class="text-success"><i class="fas fa-check-circle me-2"></i>Sudah Diambil</h5>
                                <p><strong>Waktu:</strong> {{ $ambilHariIni->waktu_input->format('H:i:s') }}<br>
                                <strong>Metode:</strong> {{ ucfirst($ambilHariIni->metode) }}</p>
                            @else
                                <h5 class="text-warning"><i class="fas fa-hourglass-half me-2"></i>Belum Diambil</h5>
                                <p>HP belum diambil hari ini</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- Input Kode --}}
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-success text-white"><i class="fas fa-keyboard me-2"></i> Input Kode HP</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('siswa.inputqr') }}">
                        @csrf
                        <div class="mb-3">
                            <label>Kode HP</label>
                            <input type="text" class="form-control" name="code" placeholder="Masukkan kode HP" required>
                        </div>
                        <button class="btn btn-primary w-100 fw-bold">
                            <i class="fas fa-paper-plane me-1"></i> Submit
                        </button>
                    </form>
                </div>
            </div>

           

        </div>
    </div>
</div>
@endsection