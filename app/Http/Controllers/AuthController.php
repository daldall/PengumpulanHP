<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

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

        // Debug info
        \Log::info('Login attempt', [
            'login_field' => $loginField,
            'login_id' => $request->login_id,
            'credentials' => $credentials
        ]);

        // Cek apakah user ada di database
        $user = User::where($loginField, $request->login_id)->first();
        if (!$user) {
            \Log::info('User not found', ['field' => $loginField, 'value' => $request->login_id]);
            return back()->withErrors([
                'login_id' => 'User tidak ditemukan.',
            ])->withInput($request->only('login_id'));
        }

        // Cek password
        if (!Hash::check($request->password, $user->password)) {
            \Log::info('Password mismatch', ['user_id' => $user->id]);
            return back()->withErrors([
                'login_id' => 'Password salah.',
            ])->withInput($request->only('login_id'));
        }

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            // Set initial last activity
            session(['last_activity' => time()]);

            \Log::info('Login successful', ['user_id' => Auth::id(), 'role' => Auth::user()->role]);

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

        \Log::error('Auth::attempt failed despite manual checks passing');
        return back()->withErrors([
            'login_id' => 'Login gagal. Silakan coba lagi.',
        ])->withInput($request->only('login_id'));
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
