<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Ngafein')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Satoshi', 'sans-serif'],
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://api.fontshare.com/v2/css?f[]=satoshi@900,700,500,300,400&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body { font-family: 'Satoshi', sans-serif; }
    </style>
</head>
<body class="min-h-screen bg-[#fcfcfc] text-gray-800 font-sans">

    @include('partials.user.navbar')
 
     <main class="pb-20">
         @yield('content')
     </main>
 
     @include('partials.user.footer')

    @stack('scripts')
</body>
</html>
