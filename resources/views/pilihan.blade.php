@extends('layouts.app2')

@section('content')
<div class="container d-flex align-items-center justify-content-center" style="min-height: 100vh; font-family:'Poppins', sans-serif;">
    <div class="row w-100 justify-content-center">

        {{-- Pilih Siswa --}}
        <div class="col-md-4 mb-3">
            <div class="card shadow-lg border-0 rounded-4 text-center p-4" style="cursor:pointer;" onclick="window.location='{{ route('auth.login.siswa') }}'">
                <div class="mb-3">
                    <i class="fas fa-user-graduate fa-3x text-primary"></i>
                </div>
                <h4 class="fw-bold">Siswa</h4>
                <p class="text-muted">Login/Register untuk siswa</p>
                <button class="btn btn-primary w-75 mt-2">Masuk</button>
            </div>
        </div>

        {{-- Pilih Guru --}}
        <div class="col-md-4 mb-3">
            <div class="card shadow-lg border-0 rounded-4 text-center p-4" style="cursor:pointer;" data-bs-toggle="modal" data-bs-target="#guruPasswordModal">
                <div class="mb-3">
                    <i class="fas fa-chalkboard-teacher fa-3x text-warning"></i>
                </div>
                <h4 class="fw-bold">Guru</h4>
                <p class="text-muted">Login/Register untuk guru</p>
                <button class="btn btn-warning w-75 mt-2">Masuk</button>
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
          <button type="submit" class="btn btn-warning">Masuk</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
