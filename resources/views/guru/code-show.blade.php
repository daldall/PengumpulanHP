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
            {!! QrCode::size(220)->generate(url('/pilihan')) !!}
        </div>

        {{-- Kode teks --}}
        <p class="display-5 fw-bold text-dark tracking-wide">
            {{ $code->kode }}
        </p>
    </div>

    {{-- Info waktu aktif --}}
    <div class="card mt-4 shadow-sm border-0 rounded-4 p-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h5 class="fw-bold mb-3 text-primary">Informasi Aktivasi</h5>
                <p class="mb-0">
                    <strong>Status:</strong>
                    <span class="badge {{ $code->status === 'aktif' ? 'bg-success' : 'bg-secondary' }} px-3 py-2 fs-6">
                        {{ ucfirst($code->status) }}
                    </span>
                </p>
            </div>

            {{-- Tombol toggle kode --}}
            <form method="POST" action="{{ route('guru.toggle-code', $code->id) }}">
                @csrf
                <button type="submit"
                    class="btn {{ $code->status === 'aktif' ? 'btn-danger' : 'btn-success' }} px-4 fw-bold rounded-pill">
                    <i class="fa {{ $code->status === 'aktif' ? 'fa-ban' : 'fa-check-circle' }}"></i>
                    {{ $code->status === 'aktif' ? 'Nonaktifkan' : 'Aktifkan' }}
                </button>
            </form>
        </div>
    </div>

    {{-- Tombol kembali --}}
    <div class="text-center mt-4">
        <a href="{{ route('guru.dashboard') }}"
           class="btn btn-outline-secondary px-5 py-2 fw-bold rounded-pill shadow-sm">
            <i class="fa fa-arrow-left me-2"></i> Kembali ke Dashboard
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
