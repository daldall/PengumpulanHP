@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3>Edit Admin</h3>
    <div class="card p-3">
        <form action="{{ route('admin.admin.update', $admin->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Nama</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $admin->name) }}">
                @error('name') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $admin->email) }}">
                @error('email') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Role</label>
                <select name="role" class="form-control" required>
                    <option value="admin" {{ old('role', $admin->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="guru" {{ old('role', $admin->role) == 'guru' ? 'selected' : '' }}>Guru</option>
                    <option value="siswa" {{ old('role', $admin->role) == 'siswa' ? 'selected' : '' }}>Siswa</option>
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

            <button type="submit" class="btn btn-primary">Update Admin</button>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection
