@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Monitoring Status Siswa - {{ date('d/m/Y') }}</h5>
                        <a href="{{ route('guru.dashboard') }}" class="btn btn-sm btn-secondary">Kembali</a>
                    </div>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    
                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>NIS</th>
                                    <th>Nama</th>
                                    <th>Jam Kumpul</th>
                                    <th>Jam Ambil</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($statusSiswa as $index => $data)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $data['siswa']->nis }}</td>
                                    <td>{{ $data['siswa']->name }}</td>
                                    <td>
                                        @if($data['kumpul'])
                                            {{ $data['kumpul']->waktu_input->format('H:i:s') }}
                                            <small class="text-muted">({{ ucfirst($data['kumpul']->metode) }})</small>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($data['ambil'])
                                            {{ $data['ambil']->waktu_input->format('H:i:s') }}
                                            <small class="text-muted">({{ ucfirst($data['ambil']->metode) }})</small>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($data['status'] === 'selesai')
                                            <span class="badge badge-success">✅ Selesai </span>
                                        @elseif($data['status'] === 'kumpul_belum_ambil')
                                            <span class="badge badge-warning" style="color : black;">⏳ Belum Ambil</span>
                                        @else
                                            <span class="badge badge-danger" style="color: black;">❌ Belum Kumpul</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            @if(!$data['kumpul'])
                                                <form method="POST" action="{{ route('guru.input-manual') }}" class="d-inline">
                                                    @csrf
                                                    <input type="hidden" name="user_id" value="{{ $data['siswa']->id }}">
                                                    <input type="hidden" name="status" value="dikumpulkan">
                                                    <button type="submit" class="btn btn-outline-primary btn-sm" onclick="return confirm('Tandai sebagai dikumpulkan?')">
                                                        Kumpul
                                                    </button>
                                                </form>
                                            @endif
                                            
                                            @if($data['kumpul'] && !$data['ambil'])
                                                <form method="POST" action="{{ route('guru.input-manual') }}" class="d-inline">
                                                    @csrf
                                                    <input type="hidden" name="user_id" value="{{ $data['siswa']->id }}">
                                                    <input type="hidden" name="status" value="diambil">
                                                    <button type="submit" class="btn btn-outline-success btn-sm" onclick="return confirm('Tandai sebagai diambil?')">
                                                        Ambil
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection