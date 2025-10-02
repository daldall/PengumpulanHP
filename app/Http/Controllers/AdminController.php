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
        // Hitung total per role
        $totalGuru   = User::where('role', 'guru')->count();
        $totalSiswa  = User::where('role', 'siswa')->count();
        $totalAdmin  = User::where('role', 'admin')->count();

        // Ambil data per role
        $gurus  = User::where('role', 'guru')->get();
        $siswas = User::where('role', 'siswa')->get();
        $admins = User::where('role', 'admin')->get();

        // Ambil user terbaru
        $latestUsers = User::whereIn('role', ['guru', 'siswa', 'admin'])
                          ->orderBy('created_at', 'desc')
                          ->limit(5)
                          ->get();

        return view('admin.dashboard', compact(
            'totalGuru',
            'totalSiswa',
            'totalAdmin',
            'latestUsers',
            'gurus',
            'siswas',
            'admins'
        ));
    }

    // ================== CRUD GURU ==================
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
        $guru->role = $request->role;

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

    public function editGuru($id)
{
    $guru = User::findOrFail($id);
    return view('admin.guru_edit', compact('guru'));
}

    // ================== CRUD SISWA ==================
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
        $siswa->role = $request->role;
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

    public function editSiswa($id)
{
    $siswa = User::findOrFail($id);
    return view('admin.siswa_edit', compact('siswa'));
}

    // ================== CRUD ADMIN ==================
    public function storeAdmin(Request $request)
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
            'role' => 'admin',
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Admin berhasil ditambahkan!');
    }

    public function updateAdmin(Request $request, $id)
    {
        $admin = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->role = $request->role;
        if ($request->password) {
            $admin->password = Hash::make($request->password);
        }

        $admin->save();

        return redirect()->route('admin.dashboard')->with('success', 'Admin berhasil diupdate!');
    }

    public function deleteAdmin($id)
    {
        $admin = User::findOrFail($id);
        $admin->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Admin berhasil dihapus!');
    }

    public function editAdmin($id)
{
    $admin = User::findOrFail($id);
    return view('admin.admin_edit', compact('admin'));
}

    //search function admin siswa
    public function index(Request $request)
{
    $search = $request->input('search');

    $siswas = User::where('role', 'siswa')
        ->when($search, function ($query, $search) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('nis', 'like', "%{$search}%")
                  ->orWhere('kelas', 'like', "%{$search}%");
        })
        ->paginate(10);

    return view('admin.dashboard', compact('siswas'));
}

}

