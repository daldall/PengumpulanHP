@extends('layouts.app')
@include('include.navbar')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header text-center">
                    <h4 class="fw-bold">Dashboard Guru</h4>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div class="card bg-primary text-white">
                                <div class="card-body">
                                    <h5>Total Siswa</h5>
                                    <h2>{{ $totalSiswa }}</h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-success text-white">
                                <div class="card-body">
                                    <h5>Sudah Kumpul</h5>
                                    <h2>{{ $sudahKumpul }}</h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-warning text-white">
                                <div class="card-body">
                                    <h5>Sudah Ambil</h5>
                                    <h2>{{ $sudahAmbil }}</h2>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        {{-- Kode Kumpul --}}
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header fw-bold text-center">Kode Pengumpulan HP</div>
                                <div class="card-body text-center">
                                    @if($kodeKumpul)
                                        @if($kodeKumpul->status === 'aktif')
                                            <p class="text-success">Kode pengumpulan sedang aktif</p>
                                            <a href="{{ route('guru.show-code', $kodeKumpul->id) }}" class="btn btn-info">Lihat Kode</a>

                                            {{-- Tutup Kode --}}
                                            <form method="POST" action="{{ route('guru.toggle-code', $kodeKumpul->id) }}" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-danger">Tutup Kode</button>
                                            </form>
                                        @else
                                            <p class="text-warning">Kode pengumpulan sudah ditutup</p>
                                            <form method="POST" action="{{ route('guru.generate-code') }}">
                                                @csrf
                                                <input type="hidden" name="jenis" value="kumpul">
                                                <button type="submit" class="btn btn-primary">Generate Kode Baru</button>
                                            </form>
                                        @endif
                                    @else
                                        <p class="text-danger">Kode Kumpul belum dibuat</p>
                                        <form method="POST" action="{{ route('guru.generate-code') }}">
                                            @csrf
                                            <input type="hidden" name="jenis" value="kumpul">
                                            <button type="submit" class="btn btn-primary">Generate Kode Kumpul</button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- Kode Pengembalian --}}
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header fw-bold text-center">Kode Pengembalian HP</div>
                                <div class="card-body text-center">
                                    @if($kodePengembalian)
                                        @if($kodePengembalian->status === 'aktif')
                                            <p class="text-success">Kode pengembalian sedang aktif</p>
                                            <a href="{{ route('guru.show-code', $kodePengembalian->id) }}" class="btn btn-info">Lihat Kode</a>

                                            {{-- Tutup Kode --}}
                                            <form method="POST" action="{{ route('guru.toggle-code', $kodePengembalian->id) }}" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-danger">Tutup Kode</button>
                                            </form>
                                        @else
                                            <p class="text-warning">Kode pengembalian sudah ditutup</p>
                                            <form method="POST" action="{{ route('guru.generate-code') }}">
                                                @csrf
                                                <input type="hidden" name="jenis" value="pengembalian">
                                                <button type="submit" class="btn btn-success">Generate Kode Baru</button>
                                            </form>
                                        @endif
                                    @else
                                        <p class="text-danger">Kode Pengembalian belum dibuat</p>
                                        <form method="POST" action="{{ route('guru.generate-code') }}">
                                            @csrf
                                            <input type="hidden" name="jenis" value="pengembalian">
                                            <button type="submit" class="btn btn-success">Generate Kode Pengembalian</button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Input Manual -->
<div class="modal fade" id="inputManualModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Input Manual</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form method="POST" action="{{ route('guru.input-manual') }}">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Pilih Siswa</label>
                        <select name="user_id" class="form-control" required>
                            <option value="">-- Pilih Siswa --</option>
                            @foreach(App\Models\User::where('role', 'siswa')->get() as $siswa)
                                <option value="{{ $siswa->id }}">{{ $siswa->nis }} - {{ $siswa->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control" required>
                            <option value="">-- Pilih Status --</option>
                            <option value="dikumpulkan">Dikumpulkan</option>
                            <option value="diambil">Diambil</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<style>
      /* --- PERBAIKAN UTAMA --- */
      html {
        overflow-y: scroll; /* Scrollbar selalu ada agar layout tidak geser saat pagination */
    }

    .card {
        transition: all 0.2s ease-in-out;
    }

    .table > :not(caption) > * > * {
        vertical-align: middle;
    }

    /* Tata letak tombol di header agar sejajar */
    .action-group {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        align-items: center;
    }
</style>
@endsection
