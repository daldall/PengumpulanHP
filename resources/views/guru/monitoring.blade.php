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
                        {{-- Export Dropdown --}}
                        <div class="dropdown me-2">
                            <button class="btn btn-primary dropdown-toggle" type="button" id="exportDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-file-export me-1"></i> Export
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="exportDropdown">
                                <li>
                                    <a class="dropdown-item" href="{{ route('guru.export-excel') }}">
                                        <i class="fas fa-file-excel text-success me-2"></i> Excel
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('guru.export-pdf') }}">
                                        <i class="fas fa-file-pdf text-danger me-2"></i> PDF
                                    </a>
                                </li>
                            </ul>
                        </div>

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
                        <table class="table table-striped table-hover align-middle">
                            <thead class="bg-light">
                                <tr>
                                    <th class="text-center">No</th>
                                    <th>NIS</th>
                                    <th>Nama</th>
                                    <th>Kelas</th>
                                    <th>Jam Kumpul</th>
                                    <th>Jam Ambil</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($statusSiswa as $index => $data)
                                <tr>
                                    <td class="text-center">{{ $siswa->firstItem() + $index }}</td>
                                    <td>{{ $data['siswa']->nis }}</td>
                                    <td>{{ $data['siswa']->name }}</td>
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
                                    <td class="text-center">
                                        @if($data['status'] === 'selesai')
                                            <span class="badge bg-success">
                                                <i class="fas fa-check-circle"></i> Selesai
                                            </span>
                                        @elseif($data['status'] === 'kumpul_belum_ambil')
                                            <span class="badge bg-warning text-dark">
                                                <i class="fas fa-hourglass-half"></i> Belum Diambil
                                            </span>
                                        @else
                                            <span class="badge bg-danger">
                                                <i class="fas fa-times-circle"></i> Belum Dikumpulkan
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-2">
                                            @if(!$data['kumpul'])
                                                <form method="POST" action="{{ route('guru.input-manual') }}">
                                                    @csrf
                                                    <input type="hidden" name="user_id" value="{{ $data['siswa']->id }}">
                                                    <input type="hidden" name="status" value="dikumpulkan">
                                                    <button type="submit" class="btn btn-sm btn-outline-primary"
                                                        onclick="return confirm('Tandai sebagai dikumpulkan?')">
                                                        <i class="fas fa-upload"></i> Kumpulkan
                                                    </button>
                                                </form>
                                            @endif

                                            @if($data['kumpul'] && !$data['ambil'])
                                                <form method="POST" action="{{ route('guru.input-manual') }}">
                                                    @csrf
                                                    <input type="hidden" name="user_id" value="{{ $data['siswa']->id }}">
                                                    <input type="hidden" name="status" value="diambil">
                                                    <button type="submit" class="btn btn-sm btn-outline-success"
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
                                    <td colspan="8" class="text-center py-4">
                                        <i class="fas fa-info-circle me-1"></i> Data tidak ditemukan
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
<style>
/* --- Perataan dan Ukuran Tombol di Header --- */
.card-header .d-flex.align-items-center {
    gap: 0.5rem;
}

.card-header .btn,
.card-header .dropdown-toggle,
.card-header .form-control {
    height: 38px; /* tinggi seragam */
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.875rem;
}

.card-header .input-group-sm .form-control,
.card-header .input-group-sm .btn {
    height: 38px !important;
}

.card-header .dropdown .btn {
    padding: 0 1rem;
}

.card-header form {
    margin-bottom: 0;
}

.card-header .btn-outline-light {
    white-space: nowrap;
}

/* Supaya icon & teks rapi di tengah */
.card-header i {
    line-height: 1;
}

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
