<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Sistem Pengumpulan HP</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    
    <!-- Google Fonts -->
    <link href="https://fonts.bunny.net/css?family=Poppins:300,400,500,600,700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'sans': ['Poppins', 'sans-serif'],
                    },
                }
            }
        }
    </script>
    
    <!-- Bootstrap JS only (no CSS) for modal functionality -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
      <style>
        /* Complete CSS reset and clean styling */
        * {
            text-decoration: none !important;
            border: none;
            box-sizing: border-box;
        }
        
        *::before, *::after {
            text-decoration: none !important;
            border: none !important;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
        }
        
        /* Remove ALL underlines and text decorations */
        a, button, span, div, p, h1, h2, h3, h4, h5, h6, label, input, select, textarea, li, td, th, i, em, strong, b {
            text-decoration: none !important;
            text-decoration-line: none !important;
            text-decoration-style: none !important;
            text-decoration-color: transparent !important;
            border-bottom: none !important;
            text-underline-offset: 0 !important;
        }
        
        /* Specific link styling */
        a:hover, a:focus, a:active, a:visited {
            text-decoration: none !important;
            border-bottom: none !important;
        }
        
        /* Remove focus outlines that might cause visual issues */
        *:focus {
            outline: none !important;
            box-shadow: none !important;
            text-decoration: none !important;
        }
        
        /* Clean input styling */
        input, select, textarea {
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            padding: 0.75rem;
            transition: all 0.2s;
            text-decoration: none !important;
            background: white;
        }
        
        input:focus, select:focus, textarea:focus {
            border-color: #10b981;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
            text-decoration: none !important;
        }
        
        /* Remove any default browser styling */
        button {
            border: none;
            background: none;
            cursor: pointer;
            text-decoration: none !important;
        }
        
        /* Ensure Font Awesome icons don't have underlines */
        .fas, .fa, .far, .fab, .fal, .fad, .fass, .fasl {
            text-decoration: none !important;
            border-bottom: none !important;
        }
        
        /* Override any Bootstrap remnants */
        .text-decoration-none {
            text-decoration: none !important;
        }
        
        /* Prevent any pseudo-element decorations */
        *::before, *::after {
            text-decoration: none !important;
            content: none;
        }
    </style>
</head>
<body class="bg-gray-50">
    <div id="app" class="min-h-screen">
        <main>
            @yield('content')
        </main>
    </div>

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

        // Auto-logout setelah 30 menit tidak aktif
        let inactivityTimer;
        
        function resetInactivityTimer() {
            clearTimeout(inactivityTimer);
            inactivityTimer = setTimeout(function() {
                alert('Sesi Anda telah berakhir. Silakan login kembali.');
                window.location.href = '/';
            }, 1800000); // 30 menit
        }
        
        // Reset timer pada aktivitas user
        document.addEventListener('mousemove', resetInactivityTimer);
        document.addEventListener('keypress', resetInactivityTimer);
        document.addEventListener('click', resetInactivityTimer);
        document.addEventListener('scroll', resetInactivityTimer);
        
        // Mulai timer
        resetInactivityTimer();

        // Device detection dan update
        function updateLastActivity() {
            const userAgent = navigator.userAgent;
            let device = 'Unknown';
            let browser = 'Unknown';
            
            // Deteksi device
            if (/Android/i.test(userAgent)) device = 'Android';
            else if (/iPhone/i.test(userAgent)) device = 'iPhone';
            else if (/iPad/i.test(userAgent)) device = 'iPad';
            else if (/Windows/i.test(userAgent)) device = 'Windows PC';
            else if (/Mac/i.test(userAgent)) device = 'Mac';
            else if (/Linux/i.test(userAgent)) device = 'Linux';
            
            // Deteksi browser
            if (/Chrome/i.test(userAgent)) browser = 'Chrome';
            else if (/Firefox/i.test(userAgent)) browser = 'Firefox';
            else if (/Safari/i.test(userAgent)) browser = 'Safari';
            else if (/Edge/i.test(userAgent)) browser = 'Edge';
            else if (/Opera/i.test(userAgent)) browser = 'Opera';
            
            // Kirim data ke server
            fetch('/update-activity', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    device: device,
                    browser: browser
                })
            });
        }
        
        // Update activity setiap 5 menit
        setInterval(updateLastActivity, 300000);
        
        // Update activity saat pertama kali load
        window.addEventListener('load', updateLastActivity);
    </script>
</body>
</html>
