@extends('layouts.app2')
@include('include.navbar')

@section('content')
<style>
    /* Biar tinggi minimal tab sama semua */
    .tab-content {
        min-height: 400px;
    }

    /* Biar card statistik tingginya sama */
    .card {
        min-height: 120px;
    }

    /* Scroll horizontal kalau tabel kepanjangan */
    .table-responsive {
        margin-top: 10px;
    }

    /* Styling untuk export buttons */
    .dropdown-item {
        display: flex;
        align-items: center;
        padding: 8px 16px;
    }

    .dropdown-item:hover {
        background-color: #f8f9fa;
    }

    .dropdown-item i {
        margin-right: 8px;
        width: 20px;
        text-align: center;
    }
    /* CSS tambahan untuk sejajarkan button dan form */
    .action-controls {
        display: flex;
        flex-wrap: wrap;
        align-items: stretch;
        gap: 8px;
    }

    .action-controls .btn,
    .action-controls .input-group,
    .action-controls .form-control {
        height: 38px;
    }

    .action-controls .form-control {
        min-width: 200px;
    }

    .action-controls .btn {
        display: flex;
        align-items: center;
        justify-content: center;
        padding-left: 12px;
        padding-right: 12px;
    }

    /* Untuk layar kecil */
    @media (max-width: 768px) {
        .action-controls {
            width: 100%;
            justify-content: space-between;
        }

        .action-controls .form-control {
            min-width: 150px;
        }
    }
</style>

<div class="container mt-4">
    <h2 class="mb-4 fw-bold text-center">Dashboard Admin</h2>

    <!-- Statistik -->
    <div class="row mb-4 text-center">
        <div class="col-md-4">
            <div class="card bg-primary text-white shadow-sm border-0 d-flex align-items-center justify-content-center">
                <div class="card-body">
                    <h5><i class="fas fa-chalkboard-teacher"></i> Total Guru</h5>
                    <h2>{{ $totalGuru }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-success text-white shadow-sm border-0 d-flex align-items-center justify-content-center">
                <div class="card-body">
                    <h5><i class="fas fa-user-graduate"></i> Total Siswa</h5>
                    <h2>{{ $totalSiswa }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-dark text-white shadow-sm border-0 d-flex align-items-center justify-content-center">
                <div class="card-body">
                    <h5><i class="fas fa-user-shield"></i> Total Admin</h5>
                    <h2>{{ $totalAdmin }}</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabs -->
    <ul class="nav nav-tabs" role="tablist">
        <li class="nav-item">
            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#guru" type="button">
                <i class="fas fa-chalkboard-teacher"></i> Guru
            </button>
        </li>
        <li class="nav-item">
            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#siswa" type="button">
                <i class="fas fa-user-graduate"></i> Siswa
            </button>
        </li>
    </ul>

    <div class="tab-content mt-3">

       <!-- GURU -->
<div class="tab-pane fade show active" id="guru">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
        <h4 class="mb-0">Daftar Guru</h4>
        <div class="action-controls">
            <!-- Dropdown Export -->
            <div class="dropdown">
                <button class="btn btn-info dropdown-toggle" type="button" id="exportGuruDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-file-export me-1"></i> Export
                </button>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="exportGuruDropdown">
                    <li>
                        <a class="dropdown-item" href="{{ route('admin.guru.export-excel') }}">
                            <i class="fas fa-file-excel text-success"></i> Excel
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('admin.guru.export-pdf') }}">
                            <i class="fas fa-file-pdf text-danger"></i> PDF
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Tombol Tambah -->
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalAddGuru">
                <i class="fas fa-plus me-1"></i> Tambah Guru
            </button>
        </div>
    </div>

            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead class="table-primary">
                        <tr>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($gurus as $guru)
                            <tr>
                                <td>{{ $guru->name }}</td>
                                <td>{{ $guru->email }}</td>
                                <td>
                                    <a href="{{ route('admin.guru.edit', $guru->id) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                                    <form action="{{ route('admin.guru.delete', $guru->id) }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="text-center text-muted">Belum ada guru</td></tr>
                        @endforelse
                    </tbody>
                </table>
                <!-- Pagination Guru -->
                <div class="d-flex justify-content-end mt-2">
                    {{ $gurus->withQueryString()->links() }}
                </div>
            </div>
        </div>

       <!-- SISWA -->
<div class="tab-pane fade" id="siswa">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
        <h4 class="mb-0">Daftar Siswa</h4>
        <div class="action-controls">
            <!-- Pencarian -->
            <form action="{{ route('admin.dashboard') }}" method="GET" class="input-group">
                <input type="hidden" name="tab" value="siswa">
                <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Cari siswa...">
                <button class="btn btn-secondary">
                    <i class="fas fa-search"></i>
                </button>
            </form>

            <!-- Dropdown Export -->
            <div class="dropdown">
                <button class="btn btn-info dropdown-toggle" type="button" id="exportSiswaDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-file-export me-1"></i> Export
                </button>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="exportSiswaDropdown">
                    <li>
                        <a class="dropdown-item" href="{{ route('admin.siswa.export-excel') }}">
                            <i class="fas fa-file-excel text-success"></i> Excel
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('admin.siswa.export-pdf') }}">
                            <i class="fas fa-file-pdf text-danger"></i> PDF
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Tombol Tambah -->
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalAddSiswa">
                <i class="fas fa-plus me-1"></i> Tambah Siswa
            </button>
        </div>
    </div>

            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead class="table-success">
                        <tr>
                            <th>NIS</th>
                            <th>Nama</th>
                            <th>Kelas</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($siswas as $siswa)
                            <tr>
                                <td>{{ $siswa->nis }}</td>
                                <td>{{ $siswa->name }}</td>
                                <td>{{ $siswa->kelas }}</td>
                                <td>
                                    <a href="{{ route('admin.siswa.edit', $siswa->id) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                                    <form action="{{ route('admin.siswa.delete', $siswa->id) }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center text-muted">Belum ada siswa</td></tr>
                        @endforelse
                    </tbody>
                </table>
                <!-- Pagination Siswa -->
                <div class="d-flex justify-content-end mt-2">
                    {{ $siswas->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Guru (inline) -->
    <div class="modal fade" id="modalAddGuru" tabindex="-1" aria-labelledby="modalAddGuruLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="modalAddGuruLabel">Tambah Guru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.guru.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nama Guru</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Siswa (inline) -->
    <div class="modal fade" id="modalAddSiswa" tabindex="-1" aria-labelledby="modalAddSiswaLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="modalAddSiswaLabel">Tambah Siswa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.siswa.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">NIS</label>
                            <input type="text" name="nis" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nama Siswa</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Kelas</label>
                            <input type="text" name="kelas" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
<script>
 document.addEventListener('DOMContentLoaded', function() {
    // Cek parameter tab dari URL
    const urlParams = new URLSearchParams(window.location.search);
    const activeTab = urlParams.get('tab') || 'guru';

    // Tampilkan tab yang sesuai
    const tabToActivate = document.querySelector(`button[data-bs-target="#${activeTab}"]`);
    if (tabToActivate) {
        const tab = new bootstrap.Tab(tabToActivate);
        tab.show();
    }

    // Tambahkan handler untuk menyimpan tab aktif saat tab diubah
    document.querySelectorAll('button[data-bs-toggle="tab"]').forEach(function(element) {
        element.addEventListener('shown.bs.tab', function(e) {
            const targetId = e.target.getAttribute('data-bs-target').replace('#', '');
            const url = new URL(window.location);
            url.searchParams.set('tab', targetId);
            history.replaceState(null, '', url);
        });
    });
});
    </script>
@endsection
