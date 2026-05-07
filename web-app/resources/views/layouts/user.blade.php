<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Ngafein') — Kopi dan Cerita di Setiap Sudut Kota</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,400;1,700&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                        serif: ['Playfair Display', 'serif'],
                    },
                    colors: {
                        brand: {
                            DEFAULT: '#b87c39',
                            dark: '#9a662e',
                            light: '#c8a87a',
                            subtle: '#fdf8f3',
                        }
                    }
                }
            }
        }
    </script>
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        [x-cloak] { display: none !important; }
        .font-serif { font-family: 'Playfair Display', serif; }
        .font-sans { font-family: 'Plus Jakarta Sans', sans-serif; }
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
        
        /* Smooth Scrolling */
        html { scroll-behavior: smooth; }
    </style>
    
    @stack('styles')
</head>
<body class="min-h-screen bg-[#fcfcfc] text-[#2B1A09] font-sans selection:bg-[#B87C39]/20 selection:text-[#2B1A09]"
      x-data="{ 
        scrolled: false, 
        lightMode: @yield('navbar-light', 'false'),
        forceDarkText: @yield('navbar-dark-text', 'false')
      }"
      @scroll.window="scrolled = (window.pageYOffset > 50)">

    <!-- Navbar -->
    @include('partials.user.navbar')

    <main class="min-h-screen">
        @yield('content')
    </main>

    <!-- Footer -->
    @include('partials.user.footer')

    <script>
        // Initialize Lucide Icons
        lucide.createIcons();
    </script>
    @stack('scripts')
</body>
</html>
