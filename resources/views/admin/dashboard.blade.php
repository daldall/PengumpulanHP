@extends('layouts.app2')
@include('include.navbar')
@section('content')
<style>
    /* Biar tinggi minimal tab sama semua */
    .tab-content {
        min-height: 400px; /* atur sesuai kebutuhan */
    }

    /* Biar card statistik tingginya sama */
    .card {
        min-height: 120px;
    }

    /* Scroll horizontal kalau tabel kepanjangan */
    .table-responsive {
        margin-top: 10px;
    }
</style>

<div class="container mt-4">
    <h2 class="mb-4 fw-bold text-center">
        <i class="fas fa-tachometer-alt"></i> Dashboard Admin
    </h2>

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
        <li class="nav-item"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#guru"><i class="fas fa-chalkboard-teacher"></i> Guru</button></li>
        <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#siswa"><i class="fas fa-user-graduate"></i> Siswa</button></li>
    </ul>

    <div class="tab-content mt-3">
        <!-- GURU -->
        <div class="tab-pane fade show active" id="guru">
            <div class="d-flex justify-content-between mb-2">
                <h4>Daftar Guru</h4>
                <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modalAddGuru"><i class="fas fa-plus"></i> Tambah Guru</button>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead class="table-primary">
                        <tr><th>Nama</th><th>Email</th><th>Aksi</th></tr>
                    </thead>
                    <tbody>
                        @forelse($gurus as $guru)
                            <tr>
                                <td>{{ $guru->name }}</td>
                                <td>{{ $guru->email }}</td>
                                <td>
                                    <a href="{{ route('admin.guru.edit', $guru->id) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                                    <form action="{{ route('admin.guru.delete', $guru->id) }}" method="POST" style="display:inline-block">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty <tr><td colspan="3" class="text-center text-muted">Belum ada guru</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- SISWA -->
<div class="tab-pane fade" id="siswa">
    <div class="d-flex justify-content-between mb-2">
        <h4>Daftar Siswa</h4>
        <div class="d-flex gap-2">
            <input type="text" id="searchSiswa" class="form-control form-control-sm" placeholder="Cari siswa...">
            <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modalAddSiswa">
                <i class="fas fa-plus"></i> Tambah Siswa
            </button>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle" id="tableSiswa">
            <thead class="table-success">
                <tr><th>NIS</th><th>Nama</th><th>Kelas</th><th>Aksi</th></tr>
            </thead>
            <tbody>
                @forelse($siswas as $siswa)
                    <tr>
                        <td>{{ $siswa->nis }}</td>
                        <td>{{ $siswa->name }}</td>
                        <td>{{ $siswa->kelas }}</td>
                        <td>
                            <a href="{{ route('admin.siswa.edit', $siswa->id) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('admin.siswa.delete', $siswa->id) }}" method="POST" style="display:inline-block">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty 
                    <tr><td colspan="4" class="text-center text-muted">Belum ada siswa</td></tr>
                @endforelse
                <!-- script untuk search siswa-->
                <script>
                      document.getElementById("searchSiswa")?.addEventListener("keyup", function () {
                      const filter = this.value.toLowerCase();
                      const rows = document.querySelectorAll("#tableSiswa tbody tr");

                      rows.forEach(row => {
                      const text = row.textContent.toLowerCase();
                      row.style.display = text.includes(filter) ? "" : "none";
    });
});
</script>

            </tbody>
        </table>
    </div>
</div>


       
    </div>
</div>
@endsection
