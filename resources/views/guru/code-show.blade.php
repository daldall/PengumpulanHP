@extends('layouts.app')
@include('include.navbar')

@section('content')
<div class="container py-5">
    <div class="text-center mb-5">
        <h2 class="fw-bold text-primary">Kode {{ ucfirst($code->jenis) }}</h2>
        <small class="text-muted">{{ $code->tanggal->format('d M Y') }}</small>
    </div>

    {{-- Card utama --}}
    <div class="card shadow-lg border-0 rounded-4 p-4 text-center">

        {{-- QR Code --}}
        <div class="mb-3">
            {!! QrCode::size(220)->generate(url('/login/siswa/'.$code->kode)) !!}
        </div>

        {{-- Kode teks --}}
        <p class="display-5 fw-bold text-dark tracking-wide">
            {{ $code->kode }}
        </p>
    </div>

    {{-- Info waktu aktif --}}
    <div class="card mt-4 shadow-sm border-0 rounded-4 p-4">
        <h5 class="fw-bold mb-3 text-primary">Informasi Aktivasi</h5>
        <p><strong>Status:</strong>
            <span class="badge {{ $code->status === 'aktif' ? 'bg-success' : 'bg-secondary' }} px-3 py-2 fs-6">
                {{ ucfirst($code->status) }}
            </span>
        </p>
    </div>

    {{-- Tombol --}}
    <div class="text-center mt-4 d-flex justify-content-center gap-3">
        {{-- Tombol toggle kode --}}
        <form method="POST" action="{{ route('guru.toggle-code', $code->id) }}">
            @csrf
            <button type="submit"
                class="btn {{ $code->status === 'aktif' ? 'btn-outline-danger' : 'btn-outline-success' }} btn-lg px-4 fw-bold">
                <i class="fa {{ $code->status === 'aktif' ? 'fa-ban' : 'fa-check-circle' }}"></i>
                {{ $code->status === 'aktif' ? 'Nonaktifkan' : 'Aktifkan' }} Kode
            </button>
        </form>

        {{-- Tombol kembali --}}
        <a href="{{ route('guru.dashboard') }}" class="btn btn-outline-secondary btn-lg px-4 fw-bold">
            <i class="fa fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>

{{-- Inline CSS --}}
<style>
    .tracking-wide {
        letter-spacing: 4px;
    }
</style>
@endsection
