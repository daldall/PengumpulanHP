<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Helpers\DeviceDetector;
use Carbon\Carbon;

class AuthController extends Controller
{
    // Halaman utama dengan form login terpadu
    public function showLoginForm()
    {
        return view('welcome');
    }

    // Login Handler untuk semua tipe pengguna
    public function login(Request $request)
    {
        $request->validate([
            'login_id' => 'required',
            'password' => 'required',
        ]);

        // Cek apakah login menggunakan email atau NIS
        $loginField = filter_var($request->login_id, FILTER_VALIDATE_EMAIL) ? 'email' : 'nis';

        $credentials = [
            $loginField => $request->login_id,
            'password' => $request->password
        ];

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            // Set initial last activity
            session(['last_activity' => time()]);

            // Deteksi device dan browser
            $userAgent = $request->header('User-Agent');
            $deviceInfo = DeviceDetector::detect($userAgent);

            // Update informasi login user
            $user = Auth::user();
            $user->update([
                'last_device' => $deviceInfo['device'],
                'last_browser' => $deviceInfo['browser'],
                'last_login' => Carbon::now('Asia/Jakarta'),
            ]);

            // Cek apakah ada data scan dalam session untuk siswa
            if (Auth::user()->role === 'siswa' && session()->has('scan_kode') && session()->has('scan_jenis')) {
                $kode = session('scan_kode');
                $jenis = session('scan_jenis');
                session()->forget(['scan_kode', 'scan_jenis']);
                return redirect()->route('scan.code', ['kode' => $kode, 'jenis' => $jenis]);
            }

            // Redirect berdasarkan role
            switch (Auth::user()->role) {
                case 'admin':
                    return redirect()->route('admin.dashboard');
                case 'guru':
                    return redirect()->route('guru.dashboard');
                case 'siswa':
                    return redirect()->route('siswa.dashboard');
                default:
                    return redirect('/');
            }
        }

        return back()->withErrors([
            'login_id' => 'Kredensial yang diberikan tidak cocok dengan data kami.',
        ])->withInput($request->only('login_id', 'remember'));
    }

    // LOGOUT
    public function logout(Request $request)
    {
        $user = Auth::user();

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Menggunakan home daripada login untuk sesuai dengan web.php Anda
        return redirect()->route('home')->with('success', 'Anda berhasil logout.');
    }
}
