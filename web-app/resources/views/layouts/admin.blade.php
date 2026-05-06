<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Dashboard' }} | TailAdmin - Laravel Tailwind CSS Admin Dashboard Template</title>
    @vite(['resources/css/admin.css', 'resources/js/admin.js'])
    <style>
        body { opacity: 0; }
        body.ready { opacity: 1; }
        body:not(.ready) * { transition: none !important; }
    </style>
    <script>
        (function() {
            var t = localStorage.getItem('theme');
            if (t === 'dark' || (!t && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            }
        })();
    </script>
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.store('theme', {
                init() {
                    const savedTheme = localStorage.getItem('theme');
                    const systemTheme = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
                    this.theme = savedTheme || systemTheme;
                    this.updateTheme();
                },
                theme: 'light',
                toggle() {
                    this.theme = this.theme === 'light' ? 'dark' : 'light';
                    localStorage.setItem('theme', this.theme);
                    this.updateTheme();
                },
                updateTheme() {
                    const html = document.documentElement;
                    if (this.theme === 'dark') {
                        html.classList.add('dark');
                    } else {
                        html.classList.remove('dark');
                    }
                }
            });
            Alpine.store('sidebar', {
                isExpanded: window.innerWidth >= 1280, 
                isMobileOpen: false,
                isHovered: false,
                toggleExpanded() {
                    this.isExpanded = !this.isExpanded;
                    this.isMobileOpen = false;
                },
                toggleMobileOpen() {
                    this.isMobileOpen = !this.isMobileOpen;
                },
                setMobileOpen(val) {
                    this.isMobileOpen = val;
                },
                setHovered(val) {
                    if (window.innerWidth >= 1280 && !this.isExpanded) {
                        this.isHovered = val;
                    }
                }
            });
            Alpine.store('toast', {
                open: false,
                message: '',
                type: 'success',
                show(message, type = 'success') {
                    this.message = message;
                    this.type = type;
                    this.open = true;
                    setTimeout(() => { this.open = false }, 3500);
                }
            });
            Alpine.store('confirm', {
                open: false,
                title: 'Konfirmasi',
                message: 'Apakah Anda yakin?',
                type: 'primary',
                icon: 'help-circle',
                onConfirm: () => {},
                show(title, message, callback, type = 'primary', icon = 'help-circle') {
                    this.title = title;
                    this.message = message;
                    this.onConfirm = callback;
                    this.type = type;
                    this.icon = icon;
                    this.open = true;
                }
            });
        });
    </script>
</head>
<body
    x-init="$store.sidebar.isExpanded = window.innerWidth >= 1280;
    const checkMobile = () => {
        if (window.innerWidth < 1280) {
            $store.sidebar.setMobileOpen(false);
            $store.sidebar.isExpanded = false;
        } else {
            $store.sidebar.isMobileOpen = false;
            $store.sidebar.isExpanded = true;
        }
    };
    window.addEventListener('resize', checkMobile);
    $nextTick(() => { document.body.classList.add('ready'); });">
    @include('components.admin.toast')
    @include('components.admin.modal-confirm')
    <div class="flex flex-col min-h-screen">
        <div class="flex flex-1">
            @include('partials.admin.backdrop')
            @include('partials.admin.sidebar')
            <div class="flex flex-col min-h-screen flex-1 transition-all duration-300 ease-in-out"
            :class="{
                'xl:ml-[280px]': $store.sidebar.isExpanded || $store.sidebar.isHovered,
                'xl:ml-[80px]': !$store.sidebar.isExpanded && !$store.sidebar.isHovered,
                'ml-0': $store.sidebar.isMobileOpen
            }">
            @include('partials.admin.navbar')
            <div class="flex-1 p-4 mx-auto w-full max-w-(--breakpoint-2xl) md:p-6">
                @yield('content')
            </div>
        </div>
    </div>
    @include('partials.admin.footer')
    </div>
</body>
@stack('scripts')
</html>
