<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Code;
use App\Models\Pengumpulan;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class SiswaController extends Controller
{
    public function __construct()
    {
        // Middleware hanya untuk method tertentu, kecuali scanCode
        $this->middleware(['auth', 'siswa'])->except(['scanCode']);
    }

    public function dashboard()
    {
        $today = Carbon::today('Asia/Jakarta');
        $user = auth()->user();

        $kumpulHariIni = Pengumpulan::where('user_id', $user->id)
            ->whereDate('waktu_input', $today)
            ->where('status', 'dikumpulkan')
            ->first();

        $ambilHariIni = Pengumpulan::where('user_id', $user->id)
            ->whereDate('waktu_input', $today)
            ->where('status', 'diambil')
            ->first();

        return view('siswa.dashboard', compact('kumpulHariIni', 'ambilHariIni'));
    }

    public function inputQR(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
        ]);

        $code = Code::where('kode', $request->code)->first();

        if (!$code) {
            return redirect()->back()->with('error', 'Kode tidak valid');
        }

        if (!$code->isActive()) {
            return redirect()->back()->with('error', 'Kode sudah tidak aktif');
        }

        // Cek apakah kode sudah pernah digunakan oleh user
        $exists = Pengumpulan::where('user_id', auth()->id())
            ->where('kode', $code->kode)
            ->exists();

        if ($exists) {
            return redirect()->back()->with('error', 'Kode sudah pernah digunakan');
        }

        // Jika mencoba ambil HP tanpa kumpul dulu
        if ($code->jenis === 'pengembalian') {
            $sudahKumpul = Pengumpulan::where('user_id', auth()->id())
                ->whereDate('waktu_input', Carbon::today('Asia/Jakarta'))
                ->where('status', 'dikumpulkan')
                ->exists();

            if (!$sudahKumpul) {
                return redirect()->back()->with('error', 'Harus kumpul HP terlebih dahulu');
            }
        }

        $status = $code->jenis === 'kumpul' ? 'dikumpulkan' : 'diambil';

        Pengumpulan::create([
            'user_id' => auth()->id(),
            'code_id' => $code->id,
            'status' => $status,
            'metode' => 'kode',
            'waktu_input' => Carbon::now('Asia/Jakarta'),
        ]);

        $message = $code->jenis === 'kumpul'
            ? 'HP berhasil dikumpulkan'
            : 'HP berhasil diambil';

        return redirect()->back()->with('success', $message);
    }

    public function riwayat()
    {
        $riwayat = Pengumpulan::where('user_id', auth()->id())
            ->with('code') // relasi ke model Code
            ->orderBy('waktu_input', 'desc')
            ->paginate(10);

        return view('siswa.riwayat', compact('riwayat'));
    }

    public function scanCode($kode, $jenis)
    {
        // Validasi kode terlebih dahulu
        $code = Code::where('kode', $kode)
            ->where('jenis', $jenis)
            ->where('status', 'aktif')
            ->where('tanggal', Carbon::today('Asia/Jakarta'))
            ->first();

        if (!$code) {
            // Jika kode tidak valid, redirect dengan pesan error
            return redirect()->route('home')
                ->with('error', 'Kode tidak valid atau sudah tidak aktif');
        }

        // Jika belum login, simpan data di session dan redirect ke login
        if (!Auth::check()) {
            session(['scan_kode' => $kode, 'scan_jenis' => $jenis]);
            return redirect()->route('home')
                ->with('message', 'Silakan login untuk melanjutkan proses pengumpulan/pengambilan HP');
        }

        // Jika sudah login tapi bukan siswa
        if (Auth::user()->role !== 'siswa') {
            return redirect()->back()
                ->with('error', 'Hanya siswa yang dapat memproses kode ini');
        }

        // Jika sudah login dan role = siswa, lanjutkan proses
        return $this->processQrCode($kode, $jenis);
    }

    private function processQrCode($kode, $jenis)
    {
        // Validasi kode lagi untuk memastikan
        $code = Code::where('kode', $kode)
            ->where('jenis', $jenis)
            ->where('status', 'aktif')
            ->where('tanggal', Carbon::today('Asia/Jakarta'))
            ->first();

        if (!$code) {
            return redirect()->route('siswa.dashboard')
                ->with('error', 'Kode tidak valid atau sudah tidak aktif');
        }

        // Cek pengambilan: pastikan sudah kumpul dulu
        if ($jenis === 'pengembalian') {
            $sudahKumpul = Pengumpulan::where('user_id', auth()->id())
                ->whereDate('waktu_input', Carbon::today('Asia/Jakarta'))
                ->where('status', 'dikumpulkan')
                ->exists();

            if (!$sudahKumpul) {
                return redirect()->route('siswa.dashboard')
                    ->with('error', 'Harus kumpul HP terlebih dahulu');
            }
        }

        $status = $jenis === 'kumpul' ? 'dikumpulkan' : 'diambil';

        // Cek apakah sudah pernah melakukan aktivitas yang sama hari ini
        $exists = Pengumpulan::where('user_id', auth()->id())
            ->whereDate('waktu_input', Carbon::today('Asia/Jakarta'))
            ->where('status', $status)
            ->exists();

        if ($exists) {
            $message = $jenis === 'kumpul'
                ? 'Anda sudah mengumpulkan HP hari ini'
                : 'Anda sudah mengambil HP hari ini';
            return redirect()->route('siswa.dashboard')->with('error', $message);
        }

        // Simpan data pengumpulan
        Pengumpulan::create([
            'user_id' => auth()->id(),
            'code_id' => $code->id,
            'status' => $status,
            'metode' => 'kode',
            'waktu_input' => Carbon::now('Asia/Jakarta'),
        ]);

        $message = $jenis === 'kumpul'
            ? 'HP berhasil dikumpulkan'
            : 'HP berhasil diambil';

        return redirect()->route('siswa.dashboard')->with('success', $message);
    }
}
