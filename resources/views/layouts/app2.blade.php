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

        {{-- Navbar untuk semua role --}}
        <nav class="navbar navbar-expand-md shadow-sm" style="background: linear-gradient(135deg, #0d6efd, #6610f2);">
            <div class="container">
                {{-- Logo + Judul --}}
                <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}"
                   style="color:white; font-weight:600; gap:0.5rem;">
                    <img src="{{ asset('images/yasfat.png') }}" alt="Logo Sekolah" width="35" height="35" style="object-fit:contain;">
                    <span style="line-height:1; font-size:1rem;">Sistem Pengumpulan HP</span>
                </a>

                {{-- Hamburger --}}
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarContent" aria-controls="navbarContent"
                        aria-expanded="false" aria-label="Toggle navigation"
                        style="border-color:#000;">
                    <span class="navbar-toggler-icon"
                          style="background-image: url('data:image/svg+xml;charset=utf8,<svg viewBox=&quot;0 0 30 30&quot; xmlns=&quot;http://www.w3.org/2000/svg&quot;><path stroke=&quot;black&quot; stroke-width=&quot;2&quot; stroke-linecap=&quot;round&quot; stroke-miterlimit=&quot;10&quot; d=&quot;M4 7h22M4 15h22M4 23h22&quot;/></svg>');">
                    </span>
                </button>

                <div class="collapse navbar-collapse" id="navbarContent">
                    <ul class="navbar-nav ms-auto">
                        @auth

                            {{-- Logout --}}
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('logout') }}"
                                   style="color:white"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                   <i class="fa fa-sign-out-alt"></i> Logout
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        @endauth
                    </ul>
                </div>
            </div>
        </nav>

        {{-- Konten --}}
        <main class="py-5">
            @yield('content')
        </main>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
