<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Sistem Pengumpulan HP') }}</title>
    <link href="https://fonts.bunny.net/css?family=Poppins:400,600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body style="font-family:'Poppins', sans-serif;">
    <div id="app">
        <nav class="navbar navbar-expand-md shadow-sm" style=" background: linear-gradient(135deg, #0d6efd, #6610f2);">
            <div class="container">
                {{-- Logo + Nama Sekolah --}}
                <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}" 
   style="color:white; font-weight:600; gap:0.5rem;">
    <img src="{{ asset('images/yasfat.png') }}" alt="Logo Sekolah" width="35" height="35" style="object-fit:contain;">
    <span style="line-height:1; font-size:1rem;">Sistem Pengumpulan HP</span>
</a>

<button class="navbar-toggler" type="button" data-bs-toggle="collapse" 
        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" 
        aria-expanded="false" aria-label="{{ __('Toggle navigation') }}"
        style="border-color:#000;">
    <span class="navbar-toggler-icon" 
          style="background-image: url('data:image/svg+xml;charset=utf8,<svg viewBox=&quot;0 0 30 30&quot; xmlns=&quot;http://www.w3.org/2000/svg&quot;><path stroke=&quot;black&quot; stroke-width=&quot;2&quot; stroke-linecap=&quot;round&quot; stroke-miterlimit=&quot;10&quot; d=&quot;M4 7h22M4 15h22M4 23h22&quot;/></svg>');">
    </span>
</button>



                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Menu (kosong) -->
                    <ul class="navbar-nav me-auto"></ul>

                    <!-- Right Menu -->
                    <ul class="navbar-nav ms-auto">
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link fw-bold" href="{{ route('login') }}" style="color:white;">
                                        <i class="fa fa-sign-in-alt"></i> Login
                                    </a>
                                </li>
                            @endif
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link fw-bold" href="{{ route('register') }}" style="color:white;">
                                        <i class="fa fa-user-plus"></i> Register
                                    </a>
                                </li>
                            @endif
                        @else
                            @if(auth()->user()->isGuru())
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('guru.dashboard') }}" style="color:white">
                                        <i class="fa fa-chalkboard-teacher"></i> Dashboard Guru
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('guru.monitoring') }}" style="color:white">
                                        <i class="fa fa-eye"></i> Monitoring
                                    </a>
                                </li>
                            @else
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('siswa.dashboard') }}" style="color:white">
                                        <i class="fa fa-user-graduate"></i> Dashboard Siswa
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('siswa.riwayat') }}" style="color:white">
                                        <i class="fa fa-history"></i> Riwayat
                                    </a>
                                </li>
                            @endif

                            {{-- Dropdown --}}
                            <li class="nav-item dropdown">
    <a id="navbarDropdown" class="nav-link dropdown-toggle fw-bold" href="#" role="button" 
       data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre
       style="color:white;">
        <i class="fa fa-user-circle"></i> {{ Auth::user()->name }}
    </a>

    <div class="dropdown-menu dropdown-menu-end" style="background-color:#fff; top: 100%; right: 0; margin:0; border-radius:0;">
        <a class="dropdown-item" href="{{ route('logout') }}"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
           style="color:#000; transition: color 0.3s;"
           onmouseover="this.style.color='#dc3545';"
           onmouseout="this.style.color='#000';">
            <i class="fa fa-sign-out-alt"></i> Logout
        </a>

        <!-- Form logout tersembunyi -->
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </div>
</li>


                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>