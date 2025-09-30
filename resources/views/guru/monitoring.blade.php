@extends('layouts.app')
@include('include.navbar')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <h5 class="mb-0 me-3">
                            <i class="fas fa-chart-line"></i> Monitoring Status Siswa
                        </h5>
                        <small class="text-light">
                            {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
                        </small>
                    </div>
                    <div class="d-flex">
                        <!-- Form Search -->
                        <form action="{{ route('guru.monitoring') }}" method="GET" class="me-2">
                            <div class="input-group input-group-sm">
                                <input type="text" name="search" class="form-control"
                                       placeholder="Cari NIS / Nama..."
                                       value="{{ request('search') }}">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </form>
                        <a href="{{ route('guru.dashboard') }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle">
                            <thead class="table-white text-center">
                                <tr>
                                    <th style="width: 50px;">No</th>
                                    <th style="width: 120px;">NIS</th>
                                    <th>Nama</th>
                                    <th style="width: 150px;">Kelas</th>
                                    <th style="width: 150px;">Jam Kumpul</th>
                                    <th style="width: 150px;">Jam Ambil</th>
                                    <th style="width: 150px;">Status</th>
                                    <th style="width: 120px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($statusSiswa as $index => $data)
                                <tr>
                                    <td class="text-center">{{ $siswa->firstItem() + $index }}</td>
                                    <td class="text-center">{{ $data['siswa']->nis }}</td>
                                    <td>{{ $data['siswa']->name }}</td>
                                    <td class="text-center">{{ $data['siswa']->kelas }}</td>
                                    <td class="text-center">
                                        @if($data['kumpul'])
                                            {{ $data['kumpul']->waktu_input->format('H:i:s') }}
                                            <br>
                                            <small class="text-muted">
                                                <i class="fa-solid fa-hands"></i> {{ ucfirst($data['kumpul']->metode) }}
                                            </small>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($data['ambil'])
                                            {{ $data['ambil']->waktu_input->format('H:i:s') }}
                                            <br>
                                            <small class="text-muted">
                                                <i class="fa-solid fa-hands"></i> {{ ucfirst($data['ambil']->metode) }}
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
                                                <i class="fas fa-hourglass-half"></i> Belum  Diambil
                                            </span>
                                        @else
                                            <span class="badge bg-danger text-dark">
                                                <i class="fas fa-times-circle"></i> Belum Dikumpulin
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group btn-group-sm">
                                            @if(!$data['kumpul'])
                                                <form method="POST" action="{{ route('guru.input-manual') }}" class="d-inline">
                                                    @csrf
                                                    <input type="hidden" name="user_id" value="{{ $data['siswa']->id }}">
                                                    <input type="hidden" name="status" value="dikumpulkan">
                                                    <button type="submit" class="btn btn-outline-primary btn-sm"
                                                            onclick="return confirm('Tandai sebagai dikumpulkan?')">
                                                        <i class=""></i> Kumpulin
                                                    </button>
                                                </form>
                                            @endif

                                            @if($data['kumpul'] && !$data['ambil'])
                                                <form method="POST" action="{{ route('guru.input-manual') }}" class="d-inline">
                                                    @csrf
                                                    <input type="hidden" name="user_id" value="{{ $data['siswa']->id }}">
                                                    <input type="hidden" name="status" value="diambil">
                                                    <button type="submit" class="btn btn-outline-success btn-sm"
                                                            onclick="return confirm('Tandai sebagai diambil?')">
                                                        <i class=""></i> Ambil
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted">Data tidak ditemukan</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center mt-3">
                            {{ $siswa->appends(['search' => request('search')])->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
