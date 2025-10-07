<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Sistem Pengumpulan HP</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <link href="https://fonts.bunny.net/css?family=Poppins:400,600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body style="font-family:'Poppins', sans-serif;">
    <div id="app">
        <main>
            @yield('content')
        </main>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Session Management Script -->
    <script>
        // Auto-refresh CSRF token setiap 10 menit
        setInterval(function() {
            fetch('/refresh-csrf', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.token) {
                    document.querySelector('meta[name="csrf-token"]').setAttribute('content', data.token);
                    // Update semua form CSRF token
                    document.querySelectorAll('input[name="_token"]').forEach(function(token) {
                        token.value = data.token;
                    });
                }
            })
            .catch(error => {
                console.log('CSRF refresh failed:', error);
            });
        }, 600000); // 10 menit

        // Warning sebelum session expired (5 menit sebelum expire)
        setInterval(function() {
            fetch('/refresh-csrf', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => {
                if (response.status === 401) {
                    // Session expired
                    alert('Session Anda akan segera berakhir. Harap simpan pekerjaan Anda.');
                    setTimeout(function() {
                        window.location.href = '/';
                    }, 30000); // Redirect setelah 30 detik
                }
            })
            .catch(error => {
                console.log('Session check failed:', error);
            });
        }, 660000); // 11 menit
    </script>
</body>
</html>
