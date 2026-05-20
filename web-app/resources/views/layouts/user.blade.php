<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Ngafein') — Kopi dan Cerita di Setiap Sudut Kota</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/images/logo-ngafein.png') }}">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,400;1,700&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    
    <!-- Vite: CSS & JS (Tailwind 4 & Alpine.js) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    @stack('styles')
</head>
<body class="selection:bg-brand/20 selection:text-[#2B1A09]"
      x-data="{ 
        scrolled: false, 
        lightMode: @yield('navbar-light', 'false'),
        forceDarkText: @yield('navbar-dark-text', 'false')
      }"
      @scroll.window="scrolled = (window.pageYOffset > 50)">

    @include('partials.user.navbar')

    <main class="min-h-screen">
        @yield('content')
    </main>

    @include('partials.user.footer')

    <script>
        lucide.createIcons();
    </script>
    @stack('scripts')
</body>
</html>
