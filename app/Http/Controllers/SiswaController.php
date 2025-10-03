<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Code;
use App\Models\Pengumpulan;
use Carbon\Carbon;

class SiswaController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'siswa']);
    }

    // ================== DASHBOARD ================== //
    public function dashboard()
    {
        $today = Carbon::now('Asia/Jakarta')->toDateString();
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

    // ================== INPUT QR MANUAL ================== //
    public function inputQR(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
        ]);

        return $this->prosesInput($request->code, 'kode');
    }

    // ================== INPUT QR OTOMATIS (SCAN QR) ================== //
    public function inputQRGet($codeId)
    {
        $code = Code::find($codeId);

        if (!$code) {
            return redirect()->route('siswa.dashboard')->with('error', 'Kode tidak valid');
        }

        return $this->prosesInput($code->kode, 'qrcode');
    }

    // ================== FUNGSI REUSABLE ================== //
    private function prosesInput($kode, $metode)
    {
        $code = Code::where('kode', $kode)->first();

        // Cek validitas kode
        if (!$code) {
            return back()->with('error', 'Kode tidak valid');
        }

        if (!$code->isActive()) {
            return back()->with('error', 'Kode sudah tidak aktif');
        }

        // Cek apakah kode sudah pernah dipakai user
        $exists = Pengumpulan::where('user_id', auth()->id())
            ->where('kode', $code->kode)
            ->exists();

        if ($exists) {
            return back()->with('error', 'Kode sudah pernah digunakan');
        }

        // Jika mencoba ambil HP tanpa kumpul dulu
        if ($code->jenis === 'pengembalian') {
            $sudahKumpul = Pengumpulan::where('user_id', auth()->id())
                ->whereDate('waktu_input', Carbon::now('Asia/Jakarta')->toDateString())
                ->where('status', 'dikumpulkan')
                ->exists();

            if (!$sudahKumpul) {
                return back()->with('error', 'Harus kumpul HP terlebih dahulu');
            }
        }

        // Tentukan status
        $status = $code->jenis === 'kumpul' ? 'dikumpulkan' : 'diambil';

        // Simpan data
        Pengumpulan::create([
            'user_id'     => auth()->id(),
            'kode'        => $code->kode,
            'status'      => $status,
            'metode'      => $metode,
            'waktu_input' => Carbon::now('Asia/Jakarta'),
        ]);

        $message = $status === 'dikumpulkan'
            ? 'HP berhasil dikumpulkan'
            : 'HP berhasil diambil';

        return redirect()->route('siswa.dashboard')->with('success', $message);
    }

    // ================== RIWAYAT ================== //
    public function riwayat()
    {
        $riwayat = Pengumpulan::where('user_id', auth()->id())
            ->with('code') // relasi ke model Code
            ->orderByDesc('waktu_input')
            ->paginate(10);

        return view('siswa.riwayat', compact('riwayat'));
    }
}
