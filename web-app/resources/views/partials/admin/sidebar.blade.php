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

    <div class="flex items-center justify-between px-6 h-20 flex-shrink-0">
        <div class="flex items-center gap-3 overflow-hidden">
            <div class="flex-shrink-0 w-10 h-10 rounded-2xl flex items-center justify-center bg-white/20 shadow-inner backdrop-blur-md">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
                    <path d="M18 8h1a4 4 0 0 1 0 8h-1M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8zM6 1v3M10 1v3M14 1v3"
                          stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            <div x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen"
                 x-transition:enter="transition-opacity duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 class="min-w-0">
                <p class="text-white font-extrabold text-lg tracking-tight leading-none uppercase">Ngafein</p>
                <p class="text-white/40 text-[9px] font-bold tracking-[0.2em] uppercase mt-1">Management</p>
            </div>
        </div>
    </div>

    <nav class="flex-1 overflow-y-auto py-8 px-4 space-y-2 no-scrollbar">


        <a href="{{ route('admin.dashboard') }}"
           class="flex items-center gap-4 px-4 py-3.5 rounded-2xl transition-all duration-200 group relative
                  {{ request()->routeIs('admin.dashboard') ? 'bg-white text-[#B87A3D] shadow-lg shadow-[#B87A3D]/20' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
            @if(request()->routeIs('admin.dashboard'))
                <div class="absolute left-1 top-1/3 bottom-1/3 w-1 bg-[#B87A3D] rounded-full"></div>
            @endif
            <span class="flex-shrink-0 w-6 h-6 flex items-center justify-center transition-transform duration-300 group-hover:scale-110">
                <i data-lucide="layout-dashboard" class="w-5 h-5 {{ request()->routeIs('admin.dashboard') ? 'stroke-[2.5px]' : '' }}"></i>
            </span>
            <span x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen"
                  class="text-[13px] font-bold tracking-wide">
                Dashboard
            </span>
        </a>

        <a href="{{ route('admin.cafe.index') }}"
           class="flex items-center gap-4 px-4 py-3.5 rounded-2xl transition-all duration-200 group relative
                  {{ request()->routeIs('admin.cafe.*') ? 'bg-white text-[#B87A3D] shadow-lg shadow-[#B87A3D]/20' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
            @if(request()->routeIs('admin.cafe.*'))
                <div class="absolute left-1 top-1/3 bottom-1/3 w-1 bg-[#B87A3D] rounded-full"></div>
            @endif
            <span class="flex-shrink-0 w-6 h-6 flex items-center justify-center transition-transform duration-300 group-hover:scale-110">
                <i data-lucide="coffee" class="w-5 h-5 {{ request()->routeIs('admin.cafe.*') ? 'stroke-[2.5px]' : '' }}"></i>
            </span>
            <span x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen"
                  class="text-[13px] font-bold tracking-wide">
                Data Alternatif
            </span>
        </a>

        <a href="/admin/kriteria"
           class="flex items-center gap-4 px-4 py-3.5 rounded-2xl transition-all duration-200 group relative"
           :class="isActive('/admin/kriteria')
               ? 'bg-white text-[#b87c39] shadow-lg shadow-black/10'
               : 'text-white/60 hover:bg-white/10 hover:text-white'">
            <span class="flex-shrink-0 w-6 h-6 flex items-center justify-center">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/>
                    <polyline points="3.27 6.96 12 12.01 20.73 6.96"/>
                    <line x1="12" y1="22.08" x2="12" y2="12"/>
                </svg>
            </span>
            <span x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen"
                  class="text-[14px] font-bold tracking-wide whitespace-nowrap">
                Data Kriteria
            </span>
        </a>
    </nav>

    {{-- logout section --}}
    <div class="p-4 border-t border-white/10 mt-auto">
        <form action="{{ route('logout') }}" method="POST" class="w-full">
            @csrf
            <button type="submit" 
                    class="w-full flex items-center gap-4 px-4 py-3.5 rounded-2xl text-white/70 hover:bg-white/10 hover:text-white transition-all duration-200 group relative">
                <span class="flex-shrink-0 w-6 h-6 flex items-center justify-center transition-transform duration-300 group-hover:translate-x-1">
                    <i data-lucide="log-out" class="w-5 h-5"></i>
                </span>
                <span x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen"
                      class="text-[13px] font-bold tracking-wide">
                    Keluar Sistem
                </span>
            </button>
        </form>
    </div>


</aside>

<div x-show="$store.sidebar.isMobileOpen"
     @click="$store.sidebar.setMobileOpen(false)"
     style="display: none;"
     class="fixed inset-0 z-[99998] bg-black/60 backdrop-blur-md xl:hidden transition-opacity">
</div>
