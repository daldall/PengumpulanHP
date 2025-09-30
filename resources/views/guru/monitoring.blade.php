@extends('layouts.app')
@include('include.navbar')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-lg border-0 rounded-4">
                {{-- Header --}}
                <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center rounded-top-4">
                    <div>
                        <h5 class="mb-0 fw-bold">
                            <i class="fas fa-chart-line me-2"></i> Monitoring Status Siswa
                        </h5>
                        <small class="text-light">
                            {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('l, d F Y') }}
                        </small>

                    </div>
                    <div class="d-flex">
                        {{-- Search --}}
                        <form action="{{ route('guru.monitoring') }}" method="GET" class="me-2">
                            <div class="input-group input-group-sm">
                                <input type="text" name="search" class="form-control rounded-start-pill"
                                    placeholder="Cari NIS / Nama..." value="{{ request('search') }}">
                                <button type="submit" class="btn btn-primary rounded-end-pill">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </form>
                        <a href="{{ route('guru.dashboard') }}"
   class="btn btn-sm btn-outline-light d-flex align-items-center">
    <i class="fas fa-arrow-left me-1"></i> Kembali
</a>
                    </div>
                </div>

                {{-- Body --}}
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-striped table-hover align-middle text-center">
                            <thead class="bg-light">
                                <tr>
                                    <th>No</th>
                                    <th>NIS</th>
                                    <th>Nama</th>
                                    <th>Kelas</th>
                                    <th>Jam Kumpul</th>
                                    <th>Jam Ambil</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($statusSiswa as $index => $data)
                                <tr>
                                    <td>{{ $siswa->firstItem() + $index }}</td>
                                    <td>{{ $data['siswa']->nis }}</td>
                                    <td class="text-start">{{ $data['siswa']->name }}</td>
                                    <td>{{ $data['siswa']->kelas }}</td>
                                    <td>
                                        @if($data['kumpul'])
                                            {{ $data['kumpul']->waktu_input->format('H:i:s') }} <br>
                                            <small class="text-muted">
                                                <i class="fa-solid fa-hand"></i> {{ ucfirst($data['kumpul']->metode) }}
                                            </small>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($data['ambil'])
                                            {{ $data['ambil']->waktu_input->format('H:i:s') }} <br>
                                            <small class="text-muted">
                                                <i class="fa-solid fa-hand"></i> {{ ucfirst($data['ambil']->metode) }}
                                            </small>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($data['status'] === 'selesai')
                                            <span class="badge bg-success px-3 py-2">
                                                <i class="fas fa-check-circle"></i> Selesai
                                            </span>
                                        @elseif($data['status'] === 'kumpul_belum_ambil')
                                            <span class="badge bg-warning text-dark px-3 py-2">
                                                <i class="fas fa-hourglass-half"></i> Belum Diambil
                                            </span>
                                        @else
                                            <span class="badge bg-danger px-3 py-2">
                                                <i class="fas fa-times-circle"></i> Belum Dikumpulin
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-2">
                                            @if(!$data['kumpul'])
                                                <form method="POST" action="{{ route('guru.input-manual') }}">
                                                    @csrf
                                                    <input type="hidden" name="user_id" value="{{ $data['siswa']->id }}">
                                                    <input type="hidden" name="status" value="dikumpulkan">
                                                    <button type="submit" class="btn btn-sm btn-outline-primary rounded-pill"
                                                        onclick="return confirm('Tandai sebagai dikumpulkan?')">
                                                        <i class="fas fa-upload"></i> Kumpulin
                                                    </button>
                                                </form>
                                            @endif

                                            @if($data['kumpul'] && !$data['ambil'])
                                                <form method="POST" action="{{ route('guru.input-manual') }}">
                                                    @csrf
                                                    <input type="hidden" name="user_id" value="{{ $data['siswa']->id }}">
                                                    <input type="hidden" name="status" value="diambil">
                                                    <button type="submit" class="btn btn-sm btn-outline-success rounded-pill"
                                                        onclick="return confirm('Tandai sebagai diambil?')">
                                                        <i class="fas fa-download"></i> Ambil
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-4">
                                        <i class="fas fa-info-circle"></i> Data tidak ditemukan
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Footer dengan pagination --}}
                <div class="card-footer bg-light border-0 text-center">
                    {{ $siswa->appends(['search' => request('search')])->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
