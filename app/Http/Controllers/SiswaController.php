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
            'kode' => $code->kode,
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
}
