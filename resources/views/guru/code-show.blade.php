@extends('layouts.app')
@include('include.navbar')
@section('content')
<div class="container py-4">
    <div class="text-center mb-4">
        <h2 class="fw-bold">Kode {{ ucfirst($code->jenis) }}</h2>
        <small class="text-muted">{{ $code->tanggal->format('d M Y') }}</small>
    </div>

    <div class="card shadow-lg rounded-4 p-4 d-flex flex-column align-items-center justify-content-center">
        {{-- QR Code --}}
        <div class="mb-3">
            {!! QrCode::size(220)->generate(url('/http://127.0.0.1:8000/login/siswa/'.$code->kode)) !!}
        </div>

        {{-- Kode teks --}}
        <p class="mb-0" style="font-size:2em; font-weight:bold; letter-spacing:2px;">
            {{ $code->kode }}
        </p>
    </div>

    <div class="card mt-4 shadow-sm rounded-4 p-3">
        <p class="mb-2"><strong>Aktif dari:</strong> <span class="text-success">{{ $code->aktif_dari }}</span></p>
        <p class="mb-2"><strong>Aktif sampai:</strong> <span class="text-danger">{{ $code->aktif_sampai }}</span></p>
    </div>

    <div class="text-center mt-3">
        <a href="{{ route('guru.dashboard') }}" class="btn btn-secondary fw-bold">
            <i class="fa fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>

{{-- Inline CSS --}}
<style>
    .card p {
        margin-bottom: 0.5rem;
        font-size: 1rem;
    }
</style>
@endsection
