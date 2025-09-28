<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Halaman Pilihan Siswa/Guru
    public function pilihan()
    {
        return view('pilihan');
    }

    // Login Siswa
    public function loginSiswa()
    {
        return view('auth.login_siswa');
    }

    // Register Siswa
    public function registerSiswa()
    {
        return view('auth.register_siswa');
    }

    // Login Guru
    public function loginGuru()
    {
        return view('auth.login_guru');
    }

    // Register Guru
    public function registerGuru()
    {
        return view('auth.register_guru');
    }

    // Cek password guru
    public function checkGuruPassword(Request $request)
    {
        $request->validate([
            'guru_password' => 'required'
        ]);

        if ($request->guru_password === 'guru123') {
            return redirect()->route('auth.login.guru');
        } else {
            return back()->withErrors(['guru_password' => 'Password guru salah!']);
        }
    }

    // LOGIN GURU POST
    public function loginGuruPost(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required','email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/guru/dashboard');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah',
        ]);
    }

    // LOGIN SISWA POST
    public function loginSiswaPost(Request $request)
    {
        $credentials = $request->validate([
            'nis' => ['required'],
            'password' => ['required'],
        ]);

        if (Auth::attempt(['nis'=>$request->nis,'password'=>$request->password])) {
            $request->session()->regenerate();
            return redirect()->intended('/siswa/dashboard');
        }

        return back()->withErrors([
            'nis' => 'NIS atau password salah',
        ]);
    }

    // REGISTER GURU POST
    public function registerGuruPost(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email'=> 'required|email|unique:users,email',
            'password'=>'required|string|min:8|confirmed',
        ]);

        User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
            'role'=>'guru',
        ]);

        return redirect()->route('auth.login.guru')->with('success','Akun guru berhasil dibuat');
    }

    // REGISTER SISWA POST
    public function registerSiswaPost(Request $request)
    {
        $request->validate([
            'name'=>'required|string|max:255',
            'nis'=>'required|string|max:20|unique:users,nis',
            'kelas'=>'required|string|max:20',
            'password'=>'required|string|min:8|confirmed',
        ]);

        User::create([
            'name'=>$request->name,
            'nis'=>$request->nis,
            'kelas'=>$request->kelas,
            'password'=>Hash::make($request->password),
            'role'=>'siswa',
        ]);

        return redirect()->route('auth.login.siswa')->with('success','Akun siswa berhasil dibuat');
    }
    // LOGOUT
    public function logout(Request $request)
    {
        $user = Auth::user(); // ambil data sebelum logout

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Arahkan sesuai role terakhir
        if ($user && $user->role === 'guru') {
            return redirect()->route('auth.login.guru')->with('success', 'Anda berhasil logout.');
        } elseif ($user && $user->role === 'siswa') {
            return redirect()->route('auth.login.siswa')->with('success', 'Anda berhasil logout.');
        }

        // fallback kalau ga ada user/role
        return redirect()->route('pilihan');
    }

}
