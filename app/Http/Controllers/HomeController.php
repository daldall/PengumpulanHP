<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if (auth()->user()->role === 'guru') {
            return redirect()->route('guru.dashboard');
        }
        return redirect()->route('siswa.dashboard');
    }

}
