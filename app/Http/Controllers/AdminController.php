<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    // Dashboard Admin
    public function dashboard()
    {
        $totalGuru = User::where('role', 'guru')->count();
        $totalSiswa = User::where('role', 'siswa')->count();

        return view('admin.dashboard', compact('totalGuru', 'totalSiswa'));
    }

    // -----------------------------
    // CRUD GURU
    // -----------------------------

    // List Guru
    public function listGuru()
    {
        $gurus = User::where('role', 'guru')->get();
        return view('admin.guru.list', compact('gurus'));
    }

    // Form create guru
    public function createGuru()
    {
        return view('admin.guru.create');
    }

    // Store guru baru
    public function storeGuru(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'guru',
        ]);

        return redirect()->route('admin.guru.list')->with('success', 'Guru berhasil ditambahkan!');
    }

    // Edit guru
    public function editGuru($id)
    {
        $guru = User::findOrFail($id);
        return view('admin.guru.edit', compact('guru'));
    }

    // Update guru
    public function updateGuru(Request $request, $id)
    {
        $guru = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $guru->id,
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $guru->name = $request->name;
        $guru->email = $request->email;

        if ($request->password) {
            $guru->password = Hash::make($request->password);
        }

        $guru->save();

        return redirect()->route('admin.guru.list')->with('success', 'Data guru berhasil diperbarui!');
    }

    // Delete guru
    public function deleteGuru($id)
    {
        $guru = User::findOrFail($id);
        $guru->delete();

        return redirect()->route('admin.guru.list')->with('success', 'Guru berhasil dihapus!');
    }

    // -----------------------------
    // CRUD SISWA
    // -----------------------------

    // List Siswa
    public function listSiswa()
    {
        $siswa = User::where('role', 'siswa')->get();
        return view('admin.siswa.list', compact('siswa'));
    }

    // Form create siswa
    public function createSiswa()
    {
        return view('admin.siswa.create');
    }

    // Store siswa baru
    public function storeSiswa(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'siswa',
        ]);

        return redirect()->route('admin.siswa.list')->with('success', 'Siswa berhasil ditambahkan!');
    }

    // Edit siswa
    public function editSiswa($id)
    {
        $siswa = User::findOrFail($id);
        return view('admin.siswa.edit', compact('siswa'));
    }

    // Update siswa
    public function updateSiswa(Request $request, $id)
    {
        $siswa = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $siswa->id,
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $siswa->name = $request->name;
        $siswa->email = $request->email;

        if ($request->password) {
            $siswa->password = Hash::make($request->password);
        }

        $siswa->save();

        return redirect()->route('admin.siswa.list')->with('success', 'Data siswa berhasil diperbarui!');
    }

    // Delete siswa
    public function deleteSiswa($id)
    {
        $siswa = User::findOrFail($id);
        $siswa->delete();

        return redirect()->route('admin.siswa.list')->with('success', 'Siswa berhasil dihapus!');
    }
}
