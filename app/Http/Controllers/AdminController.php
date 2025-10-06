<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
// Import untuk fitur export
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\GuruExport;
use App\Exports\SiswaExport;
use Barryvdh\DomPDF\Facade\Pdf;

class AdminController extends Controller
{
    /**
     * Pastikan hanya admin yang bisa mengakses controller ini.
     */
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    /**
     * Menampilkan halaman dashboard utama untuk admin.
     * Method ini juga menangani logika untuk pencarian siswa.
     */
    public function dashboard(Request $request)
    {
        // Hitung total data untuk kartu statistik
        $totalGuru   = User::where('role', 'guru')->count();
        $totalSiswa  = User::where('role', 'siswa')->count();
        $totalAdmin  = User::where('role', 'admin')->count();

        // Tentukan tab aktif dari query parameter
        $activeTab = $request->query('tab', 'guru');

        // Ambil data guru dengan pagination dan tambahkan parameter tab
        $gurus = User::where('role', 'guru')
            ->orderBy('name')
            ->paginate(10, ['*'], 'guru_page')
            ->appends(['tab' => $activeTab]);

        $admins = User::where('role', 'admin')
            ->orderBy('name')
            ->paginate(10, ['*'], 'admin_page')
            ->appends(['tab' => $activeTab]);

        // Ambil kata kunci pencarian dari input form
        $search = $request->input('search');

        // Query untuk data siswa, dengan kondisi pencarian jika ada
        $siswas = User::where('role', 'siswa')
            ->when($search, function ($query, $search) {
                // Grupkan kondisi 'where' untuk logika pencarian yang benar
                return $query->where(function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('nis', 'like', "%{$search}%")
                      ->orWhere('kelas', 'like', "%{$search}%");
                });
            })
            ->orderBy('name')
            ->paginate(10, ['*'], 'siswa_page')
            ->appends(['search' => $search, 'tab' => $activeTab]); // Tambahkan parameter tab

        // Ambil 5 user terbaru yang ditambahkan
        $latestUsers = User::whereIn('role', ['guru', 'siswa', 'admin'])
                             ->orderBy('created_at', 'desc')
                             ->limit(5)
                             ->get();

        // Kirim semua data yang dibutuhkan ke view, termasuk activeTab
        return view('admin.dashboard', compact(
            'totalGuru',
            'totalSiswa',
            'totalAdmin',
            'latestUsers',
            'gurus',
            'siswas',
            'admins',
            'activeTab'
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

        return redirect()->route('admin.dashboard', ['tab' => 'guru'])->with('success', 'Guru berhasil ditambahkan!');
    }

    public function editGuru($id)
    {
        $guru = User::findOrFail($id);
        return view('admin.guru_edit', compact('guru'));
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

        if ($request->filled('password')) {
            $guru->password = Hash::make($request->password);
        }

        $guru->save();

        return redirect()->route('admin.dashboard', ['tab' => 'guru'])->with('success', 'Data guru berhasil diupdate!');
    }

    public function deleteGuru($id)
    {
        $guru = User::findOrFail($id);
        $guru->delete();

        return redirect()->route('admin.dashboard', ['tab' => 'guru'])->with('success', 'Guru berhasil dihapus!');
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

        return redirect()->route('admin.dashboard', ['tab' => 'siswa'])->with('success', 'Siswa berhasil ditambahkan!');
    }

    public function editSiswa($id)
    {
        $siswa = User::findOrFail($id);
        return view('admin.siswa_edit', compact('siswa'));
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

        if ($request->filled('password')) {
            $siswa->password = Hash::make($request->password);
        }

        $siswa->save();

        return redirect()->route('admin.dashboard', ['tab' => 'siswa'])->with('success', 'Data siswa berhasil diupdate!');
    }

    public function deleteSiswa($id)
    {
        $siswa = User::findOrFail($id);
        $siswa->delete();

        return redirect()->route('admin.dashboard', ['tab' => 'siswa'])->with('success', 'Siswa berhasil dihapus!');
    }


    public function exportGuruExcel()
    {
        return Excel::download(new GuruExport, 'data-guru-'.date('Y-m-d').'.xlsx');
    }

    public function exportGuruPDF()
    {
        $gurus = User::where('role', 'guru')->get();
        $pdf = PDF::loadView('exports.guru-pdf', ['gurus' => $gurus]);
        return $pdf->download('data-guru-'.date('Y-m-d').'.pdf');
    }

    public function exportSiswaExcel()
    {
        return Excel::download(new SiswaExport, 'data-siswa-'.date('Y-m-d').'.xlsx');
    }

    public function exportSiswaPDF()
    {
        $siswas = User::where('role', 'siswa')->get();
        $pdf = PDF::loadView('exports.siswa-pdf', ['siswas' => $siswas]);
        return $pdf->download('data-siswa-'.date('Y-m-d').'.pdf');
    }
}
