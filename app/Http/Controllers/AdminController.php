<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function dashboard()
    {
        $totalGuru = User::where('role', 'guru')->count();
        $totalSiswa = User::where('role', 'siswa')->count();
        
        // Ambil semua guru dan siswa untuk ditampilkan di dashboard
        $guru = User::where('role', 'guru')->get();
        $siswa = User::where('role', 'siswa')->get();
        
        $latestUsers = User::whereIn('role', ['guru', 'siswa'])
                          ->orderBy('created_at', 'desc')
                          ->limit(5)
                          ->get();

        return view('admin.dashboard', compact('totalGuru', 'totalSiswa', 'latestUsers', 'guru', 'siswa'));
    }

    // CRUD Guru
    public function createGuru()
    {
        return view('admin.create_guru');
    }

    public function storeGuru(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'guru',
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Guru berhasil ditambahkan!');
    }

    public function editGuru($id)
    {
        $guru = User::findOrFail($id);
        return view('admin.edit_guru', compact('guru'));
    }

    public function updateGuru(Request $request, $id)
    {
        $guru = User::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $guru->name = $request->name;
        $guru->email = $request->email;
        
        if ($request->password) {
            $guru->password = Hash::make($request->password);
        }
        
        $guru->save();

        return redirect()->route('admin.dashboard')->with('success', 'Guru berhasil diupdate!');
    }

    public function deleteGuru($id)
    {
        $guru = User::findOrFail($id);
        $guru->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Guru berhasil dihapus!');
    }

    // CRUD Siswa
    public function createSiswa()
    {
        return view('admin.create_siswa');
    }

    public function storeSiswa(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'nis' => 'required|string|max:255|unique:users',
            'kelas' => 'required|string|max:255',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'nis' => $request->nis,
            'kelas' => $request->kelas,
            'password' => Hash::make($request->password),
            'role' => 'siswa',
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Siswa berhasil ditambahkan!');
    }

    public function editSiswa($id)
    {
        $siswa = User::findOrFail($id);
        return view('admin.edit_siswa', compact('siswa'));
    }

    public function updateSiswa(Request $request, $id)
    {
        $siswa = User::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'nis' => 'required|string|max:255|unique:users,nis,' . $id,
            'kelas' => 'required|string|max:255',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $siswa->name = $request->name;
        $siswa->nis = $request->nis;
        $siswa->kelas = $request->kelas;
        
        if ($request->password) {
            $siswa->password = Hash::make($request->password);
        }
        
        $siswa->save();

        return redirect()->route('admin.dashboard')->with('success', 'Siswa berhasil diupdate!');
    }

    public function deleteSiswa($id)
    {
        $siswa = User::findOrFail($id);
        $siswa->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Siswa berhasil dihapus!');
    }

    // Method untuk list (jika masih diperlukan)
    public function listGuru()
    {
        return redirect()->route('admin.dashboard');
    }

    public function listSiswa()
    {
        return redirect()->route('admin.dashboard');
    }
}