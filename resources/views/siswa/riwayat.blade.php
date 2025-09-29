@extends('layouts.app')
@include('include.navbar')
@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center" 
                     style="border-top-left-radius:0.75rem; border-top-right-radius:0.75rem;">
                    <h5 class="mb-0 fw-bold">Riwayat Pengumpulan HP</h5>
                    <a href="{{ route('siswa.dashboard') }}" class="btn btn-sm btn-light fw-bold">Kembali</a>
                </div>

                <div class="card-body">
                    @if($riwayat->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Waktu</th>
                                        <th>Jenis</th>
                                        <th>Status</th>
                                        <th>Metode</th>
                                        <th>Kode</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($riwayat as $item)
                                    <tr style="transition: background 0.3s;">
                                        <td>{{ $item->waktu_input->format('d/m/Y') }}</td>
                                        <td>{{ $item->waktu_input->format('H:i:s') }}</td>
                                        <td>
                                            @if($item->code)
                                                <span class="badge bg-info text-dark">{{ ucfirst($item->code->jenis) }}</span>
                                            @else
                                                <span class="badge bg-secondary">Manual</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($item->status === 'dikumpulkan')
                                                <span class="badge bg-success">Dikumpulkan</span>
                                            @else
                                                <span class="badge bg-primary">Diambil</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge {{ $item->metode === 'kode' ? 'bg-info text-dark' : 'bg-warning text-dark' }}">
                                                {{ ucfirst($item->metode) }}
                                            </span>
                                        </td>
                                        <td>
                                        @if($item->code)
                                            <small class="text-muted">{{ $item->code->kode }}</small>
                                        @else
                                            <small class="text-muted">-</small>
                                        @endif
                                    </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center mt-3">
                            {{ $riwayat->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <h5 class="text-muted">Belum ada riwayat pengumpulan HP</h5>
                            <p class="text-muted">Riwayat akan muncul setelah Anda melakukan input kode HP</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Inline CSS tambahan --}}
<style>
    tbody tr:hover {
        background-color: #f1f3f5;
    }
    .table th, .table td {
        vertical-align: middle;
    }
</style>
@endsection