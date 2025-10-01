@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3>Edit Siswa</h3>
    <div class="card p-3">
        <form action="{{ route('admin.siswa.update', $siswa->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Nama</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $siswa->name) }}">
                @error('name') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">NIS</label>
                <input type="text" name="nis" class="form-control" value="{{ old('nis', $siswa->nis) }}">
                @error('nis') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Kelas</label>
                <input type="text" name="kelas" class="form-control" value="{{ old('kelas', $siswa->kelas) }}">
                @error('kelas') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Role</label>
                <select name="role" class="form-control" required>
                    <option value="admin" {{ old('role', $siswa->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="guru" {{ old('role', $siswa->role) == 'guru' ? 'selected' : '' }}>Guru</option>
                    <option value="siswa" {{ old('role', $siswa->role) == 'siswa' ? 'selected' : '' }}>Siswa</option>
                </select>
                @error('role') <small class="text-danger">{{ $message }}</small> @enderror
            </div>


            <div class="mb-3">
                <label class="form-label">Password <small>(Kosongkan jika tidak ingin diubah)</small></label>
                <input type="password" name="password" class="form-control">
                @error('password') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="form-control">
            </div>

            <button type="submit" class="btn btn-primary">Update Siswa</button>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection
