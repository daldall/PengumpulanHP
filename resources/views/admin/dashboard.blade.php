@extends('layouts.app') <!-- sesuaikan dengan layout yang kamu punya -->

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Dashboard Admin</h2>

    <div class="row mb-4">
        <!-- Total Guru -->
        <div class="col-md-4">
            <div class="card text-white bg-primary mb-3">
                <div class="card-header">Total Guru</div>
                <div class="card-body">
                    <h5 class="card-title">{{ $totalGuru }}</h5>
                </div>
            </div>
        </div>

        <!-- Total Siswa -->
        <div class="col-md-4">
            <div class="card text-white bg-success mb-3">
                <div class="card-header">Total Siswa</div>
                <div class="card-body">
                    <h5 class="card-title">{{ $totalSiswa }}</h5>
                </div>
            </div>
        </div>
    </div>

    <!-- Latest Users -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">User Terbaru</div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Email / NIS</th>
                                <th>Role</th>
                                <th>Tanggal Dibuat</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($latestUsers as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>
                                    @if($user->role == 'siswa')
                                        {{ $user->nis }}
                                    @else
                                        {{ $user->email }}
                                    @endif
                                </td>
                                <td>{{ ucfirst($user->role) }}</td>
                                <td>{{ $user->created_at->format('d M Y') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <a href="{{ route('admin.guru.list') }}" class="btn btn-primary mt-2">Kelola Guru & Siswa</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection