<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Code;
use App\Models\Pengumpulan;
use App\Models\User;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SiswaExport;
use Illuminate\Support\Str;

class GuruController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'guru']);
    }

    public function dashboard()
    {
        $today = Carbon::today('Asia/Jakarta');

        $kodeKumpul = Code::where('tanggal', $today)
            ->where('jenis', 'kumpul')
            ->first();

        $kodePengembalian = Code::where('tanggal', $today)
            ->where('jenis', 'pengembalian')
            ->first();

        $totalSiswa = User::where('role', 'siswa')->count();
        $sudahKumpul = Pengumpulan::whereDate('waktu_input', $today->toDateString())
            ->where('status', 'dikumpulkan')
            ->distinct('user_id')
            ->count();
        $sudahAmbil = Pengumpulan::whereDate('waktu_input', $today->toDateString())
            ->where('status', 'diambil')
            ->distinct('user_id')
            ->count();

        return view('guru.dashboard', compact(
            'kodeKumpul',
            'kodePengembalian',
            'totalSiswa',
            'sudahKumpul',
            'sudahAmbil'
        ));
    }

    public function generateCode(Request $request)
    {
        $tanggal = Carbon::today('Asia/Jakarta');
        $jenis = $request->jenis;

        // Hapus kode lama untuk hari ini
        Code::where('tanggal', $tanggal)
            ->where('jenis', $jenis)
            ->delete();

        // Generate kode random
        $kode = Code::generateKode($tanggal, $jenis);

        // Simpan kode baru (langsung aktif)
        Code::create([
            'kode' => $kode,
            'tanggal' => $tanggal,
            'jenis' => $jenis,
            'status' => 'aktif',
        ]);

        return redirect()->back()->with('success', 'Kode ' . $jenis . ' berhasil dibuat dan aktif');
    }

    public function toggleCode($id)
    {
        $code = Code::findOrFail($id);

        if ($code->status === 'aktif') {
            // Tutup kode
            $code->status = 'nonaktif';
        } else {
            // Aktifkan kembali kode
            $code->status = 'aktif';
        }

        $code->save();

        return redirect()->back()->with('success', 'Kode ' . $code->jenis . ' sekarang: ' . $code->status);
    }

    public function showCode($id)
    {
        $code = Code::findOrFail($id);

        return view('guru.code-show', [
            'code' => $code,
        ]);
    }

    public function monitoring(Request $request)
    {
        $today = Carbon::today('Asia/Jakarta');
        $search = $request->input('search');

        $query = User::where('role', 'siswa');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('nis', 'like', '%' . $search . '%')
                    ->orWhere('kelas', 'like', '%' . $search . '%');
            });
        }

        $siswa = $query->paginate(8);

        $statusSiswa = [];
        foreach ($siswa as $s) {
            $kumpul = Pengumpulan::where('user_id', $s->id)
                ->whereDate('waktu_input', $today->toDateString())
                ->where('status', 'dikumpulkan')
                ->first();

            $ambil = Pengumpulan::where('user_id', $s->id)
                ->whereDate('waktu_input', $today->toDateString())
                ->where('status', 'diambil')
                ->first();

            $status = 'belum_kumpul';
            if ($kumpul && $ambil) {
                $status = 'selesai';
            } elseif ($kumpul && !$ambil) {
                $status = 'kumpul_belum_ambil';
            }

            $statusSiswa[] = [
                'siswa' => $s,
                'status' => $status,
                'kumpul' => $kumpul,
                'ambil' => $ambil,
            ];
        }

        return view('guru.monitoring', compact('statusSiswa', 'siswa', 'search'));
    }

    public function inputManual(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'status' => 'required|in:dikumpulkan,diambil',
        ]);

        $today = Carbon::today('Asia/Jakarta');

        $exists = Pengumpulan::where('user_id', $request->user_id)
            ->whereDate('waktu_input', $today->toDateString())
            ->where('status', $request->status)
            ->exists();

        if ($exists) {
            return redirect()->back()->with('error', 'Status ini sudah ada untuk siswa hari ini');
        }

        $waktuInput = Carbon::now('Asia/Jakarta');

        Pengumpulan::create([
            'user_id' => $request->user_id,
            'kode' => null,
            'status' => $request->status,
            'metode' => 'manual',
            'waktu_input' => $waktuInput,
        ]);

        return redirect()->back()->with('success', 'Data berhasil disimpan');
    }

    public function exportExcel()
    {
        return Excel::download(new SiswaExport, 'data_siswa.xlsx');
    }

    public function exportPDF(Request $request)
    {
        $tanggal = $request->tanggal ?? Carbon::today('Asia/Jakarta')->toDateString();
        $date = Carbon::parse($tanggal)->setTimezone('Asia/Jakarta');

        $data = User::where('role', 'siswa')
            ->with(['pengumpulan' => function ($query) use ($date) {
                $query->whereDate('waktu_input', $date->toDateString());
            }])
            ->get();

        $laporan = [];
        foreach ($data as $siswa) {
            $kumpul = $siswa->pengumpulan->where('status', 'dikumpulkan')->first();
            $ambil = $siswa->pengumpulan->where('status', 'diambil')->first();

            $statusAkhir = 'Belum Kumpul';
            if ($kumpul && $ambil) {
                $statusAkhir = 'Selesai';
            } elseif ($kumpul && !$ambil) {
                $statusAkhir = 'Belum Ambil';
            }

            $laporan[] = [
                'nis' => $siswa->nis,
                'nama' => $siswa->name,
                'kelas' => $siswa->kelas,
                'jam_kumpul' => $kumpul ? $kumpul->waktu_input->format('H:i:s') : '-',
                'jam_ambil' => $ambil ? $ambil->waktu_input->format('H:i:s') : '-',
                'metode_kumpul' => $kumpul ? ucfirst($kumpul->metode) : '-',
                'metode_ambil' => $ambil ? ucfirst($ambil->metode) : '-',
                'status_akhir' => $statusAkhir,
            ];
        }

        try {
            $pdf = Pdf::loadView('guru.laporan-pdf', compact('laporan', 'date'));
            return $pdf->download('laporan-hp-' . $date->format('Y-m-d') . '.pdf');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error generating PDF: ' . $e->getMessage());
        }
    }
}
