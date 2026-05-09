@php
    $currentPath = '/' . request()->path();
@endphp

<aside id="sidebar"
    style="background-color: #b87c39;"
    class="fixed flex flex-col top-0 left-0 h-screen z-[99999] transition-all duration-300 ease-in-out border-r border-white/5 shadow-2xl"
    :class="{
        'w-[280px]': $store.sidebar.isExpanded || $store.sidebar.isMobileOpen || $store.sidebar.isHovered,
        'w-[80px]': !$store.sidebar.isExpanded && !$store.sidebar.isHovered,
        'translate-x-0': $store.sidebar.isMobileOpen,
        '-translate-x-full xl:translate-x-0': !$store.sidebar.isMobileOpen
    }"
    @mouseenter="if (!$store.sidebar.isExpanded) $store.sidebar.setHovered(true)"
    @mouseleave="$store.sidebar.setHovered(false)"
    x-data="{
        sawOpen: {{ request()->routeIs('admin.saw.*') ? 'true' : 'false' }},
        isActive(path) {
            return window.location.pathname === path;
        }
    }">

    {{-- HEADER --}}
    <div class="flex items-center justify-between px-6 h-20 flex-shrink-0">
        <div class="flex items-center gap-3 overflow-hidden">
            <div class="flex-shrink-0 w-10 h-10 rounded-2xl flex items-center justify-center bg-white/20 shadow-inner backdrop-blur-md">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
                    <path d="M18 8h1a4 4 0 0 1 0 8h-1M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8zM6 1v3M10 1v3M14 1v3"
                          stroke="white" stroke-width="2"/>
                </svg>
            </div>

            <div x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen">
                <p class="text-white font-extrabold text-lg uppercase">Ngafein</p>
                <p class="text-white/40 text-[9px] font-bold uppercase mt-1">Management</p>
            </div>
        </div>
    </div>

    {{-- MENU --}}
    <nav class="flex-1 overflow-y-auto py-8 px-4 space-y-1 no-scrollbar">

        {{-- Dashboard --}}
        <a href="{{ route('admin.dashboard') }}"
           class="flex items-center gap-4 px-4 py-3.5 rounded-2xl transition-all
           {{ request()->routeIs('admin.dashboard') ? 'bg-white text-[#B87A3D] shadow-lg' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
            <i data-lucide="layout-dashboard" class="w-5 h-5 flex-shrink-0"></i>
            <span x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen"
                  class="text-sm font-semibold whitespace-nowrap">Dashboard</span>
        </a>

        {{-- Data Kriteria --}}
        <a href="{{ route('admin.kriteria.index') }}"
           class="flex items-center gap-4 px-4 py-3.5 rounded-2xl transition-all
           {{ request()->routeIs('admin.kriteria.*') ? 'bg-white text-[#B87A3D] shadow-lg' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
            <i data-lucide="layers" class="w-5 h-5 flex-shrink-0"></i>
            <span x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen"
                  class="text-sm font-semibold whitespace-nowrap">Data Kriteria</span>
        </a>

        {{-- Data Alternatif --}}
        <a href="{{ route('admin.cafe.index') }}"
           class="flex items-center gap-4 px-4 py-3.5 rounded-2xl transition-all
           {{ request()->routeIs('admin.cafe.*') ? 'bg-white text-[#B87A3D] shadow-lg' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
            <i data-lucide="coffee" class="w-5 h-5 flex-shrink-0"></i>
            <span x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen"
                  class="text-sm font-semibold whitespace-nowrap">Data Alternatif</span>
        </a>

        {{-- Manajemen (accordion) --}}
        <div>
            {{-- Toggle label (expanded) --}}
            <button
                @click="sawOpen = !sawOpen"
                x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen"
                class="w-full flex items-center justify-between gap-4 px-4 py-3.5 rounded-2xl transition-all
                {{ request()->routeIs('admin.saw.*') ? 'bg-white/20 text-white' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                <div class="flex items-center gap-4">
                    <i data-lucide="settings-2" class="w-5 h-5 flex-shrink-0"></i>
                    <span class="text-sm font-semibold whitespace-nowrap">Proses saw</span>
                </div>
                <i data-lucide="chevron-down" class="w-4 h-4 transition-transform duration-200 flex-shrink-0"
                   :class="sawOpen ? 'rotate-180' : ''"></i>
            </button>

            {{-- Icon only (collapsed) --}}
            <button
                @click="sawOpen = !sawOpen"
                x-show="!$store.sidebar.isExpanded && !$store.sidebar.isHovered && !$store.sidebar.isMobileOpen"
                class="w-full flex items-center justify-center px-4 py-3.5 rounded-2xl transition-all
                {{ request()->routeIs('admin.saw.*') ? 'bg-white/20 text-white' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                <i data-lucide="settings-2" class="w-5 h-5"></i>
            </button>

            {{-- Sub-menu Proses SAW --}}
            <div x-show="sawOpen && ($store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen)"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 -translate-y-2"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 translate-y-0"
                 x-transition:leave-end="opacity-0 -translate-y-2"
                 class="mt-1 ml-4 pl-4 border-l-2 border-white/20 space-y-1">

                <p class="text-[9px] font-black text-white/30 uppercase tracking-[0.15em] px-2 pt-2 pb-1">Proses SAW</p>

                <a href="{{ route('admin.saw.index') }}?tab=matriks"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all text-sm
                   {{ request()->routeIs('admin.saw.*') && (request()->get('tab', 'matriks') === 'matriks') ? 'bg-white text-[#B87A3D] shadow font-bold' : 'text-white/60 hover:bg-white/10 hover:text-white font-medium' }}">
                    <i data-lucide="grid-3x3" class="w-4 h-4 flex-shrink-0"></i>
                    <span class="whitespace-nowrap">Matriks Keputusan</span>
                </a>

                <a href="{{ route('admin.saw.index') }}?tab=normalisasi"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all text-sm
                   {{ request()->routeIs('admin.saw.*') && request()->get('tab') === 'normalisasi' ? 'bg-white text-[#B87A3D] shadow font-bold' : 'text-white/60 hover:bg-white/10 hover:text-white font-medium' }}">
                    <i data-lucide="bar-chart-2" class="w-4 h-4 flex-shrink-0"></i>
                    <span class="whitespace-nowrap">Normalisasi</span>
                </a>

                <a href="{{ route('admin.saw.index') }}?tab=saw"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all text-sm
                   {{ request()->routeIs('admin.saw.*') && request()->get('tab') === 'saw' ? 'bg-white text-[#B87A3D] shadow font-bold' : 'text-white/60 hover:bg-white/10 hover:text-white font-medium' }}">
                    <i data-lucide="calculator" class="w-4 h-4 flex-shrink-0"></i>
                    <span class="whitespace-nowrap">Perhitungan SAW</span>
                </a>
            </div>
        </div>

    </nav>

    {{-- LOGOUT --}}
    <div class="p-4 border-t border-white/10 mt-auto">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit"
                class="w-full flex items-center gap-4 px-4 py-3.5 rounded-2xl text-white/70 hover:bg-white/10 hover:text-white transition-all">
                <i data-lucide="log-out" class="w-5 h-5 flex-shrink-0"></i>
                <span x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen"
                      class="text-sm font-semibold">Keluar Sistem</span>
            </button>
        </form>
    </div>

</aside>

{{-- OVERLAY MOBILE --}}
<div x-show="$store.sidebar.isMobileOpen"
     @click="$store.sidebar.setMobileOpen(false)"
     class="fixed inset-0 z-[99998] bg-black/60 backdrop-blur-md xl:hidden">
</div>

<script src="https://unpkg.com/lucide@latest"></script>
<script>
    lucide.createIcons();
</script>