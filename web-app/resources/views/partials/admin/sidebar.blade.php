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
    <nav class="flex-1 overflow-y-auto py-8 px-4 space-y-2 no-scrollbar">

        {{-- Dashboard --}}
        <a href="{{ route('admin.dashboard') }}"
           class="flex items-center gap-4 px-4 py-3.5 rounded-2xl transition-all
           {{ request()->routeIs('admin.dashboard') ? 'bg-white text-[#B87A3D] shadow-lg' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
            
            <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
            <span x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered">Dashboard</span>
        </a>

        {{-- Data Alternatif --}}
        <a href="{{ route('admin.cafe.index') }}"
           class="flex items-center gap-4 px-4 py-3.5 rounded-2xl transition-all
           {{ request()->routeIs('admin.cafe.*') ? 'bg-white text-[#B87A3D] shadow-lg' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
            
            <i data-lucide="coffee" class="w-5 h-5"></i>
            <span x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered">Data Alternatif</span>
        </a>

        {{-- Data Kriteria --}}
        <a href="{{ route('admin.kriteria.index') }}"
           class="flex items-center gap-4 px-4 py-3.5 rounded-2xl transition-all
           {{ request()->routeIs('admin.kriteria.*') ? 'bg-white text-[#B87A3D] shadow-lg' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
            
            <i data-lucide="layers" class="w-5 h-5"></i>
            <span x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered">Data Kriteria</span>
        </a>

        {{-- Matriks Keputusan --}}
        <a href="{{ route('admin.matriks-keputusan.index') }}"
           class="flex items-center gap-4 px-4 py-3.5 rounded-2xl transition-all
           {{ request()->routeIs('admin.matriks-keputusan.*') ? 'bg-white text-[#B87A3D] shadow-lg' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
            
            <i data-lucide="table" class="w-5 h-5"></i>
            <span x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered">Matriks Keputusan</span>
        </a>

        {{-- Normalisasi --}}
        <a href="{{ route('admin.normalisasi.index') }}"
           class="flex items-center gap-4 px-4 py-3.5 rounded-2xl transition-all
           {{ request()->routeIs('admin.normalisasi.*') ? 'bg-white text-[#B87A3D] shadow-lg' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
            
            <i data-lucide="bar-chart-2" class="w-5 h-5"></i>
            <span x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered">Normalisasi</span>
        </a>

        {{-- Perhitungan SAW --}}
        <a href="#"
           class="flex items-center gap-4 px-4 py-3.5 rounded-2xl transition-all text-white/70 hover:bg-white/10 hover:text-white">
            
            <i data-lucide="calculator" class="w-5 h-5"></i>
            <span x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered">Perhitungan SAW</span>
        </a>

    </nav>

    {{-- LOGOUT --}}
    <div class="p-4 border-t border-white/10 mt-auto">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit"
                class="w-full flex items-center gap-4 px-4 py-3.5 rounded-2xl text-white/70 hover:bg-white/10 hover:text-white transition-all">
                
                <i data-lucide="log-out" class="w-5 h-5"></i>
                <span x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered">Keluar Sistem</span>
            </button>
        </form>
    </div>

</aside>

{{-- OVERLAY MOBILE --}}
<div x-show="$store.sidebar.isMobileOpen"
     @click="$store.sidebar.setMobileOpen(false)"
     class="fixed inset-0 z-[99998] bg-black/60 backdrop-blur-md xl:hidden">
</div>