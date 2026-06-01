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
        alternatifOpen: {{ (request()->routeIs('admin.cafe.*') || request()->routeIs('admin.fasilitas.*') || request()->routeIs('admin.menu.*') || request()->routeIs('admin.galeri.*')) ? 'true' : 'false' }},
        isActive(path) {
            return window.location.pathname === path;
        }
    }">

    {{-- HEADER --}}
    <div class="flex items-center justify-between px-4 h-20 flex-shrink-0">
        <div class="flex items-center gap-3 overflow-hidden">
            <img src="{{ asset('assets/images/logo-ngafein.png') }}" alt="Ngafein" class="flex-shrink-0 h-14 w-auto object-contain drop-shadow-md" />

            <div class="flex flex-col justify-center leading-none" x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen">
                <p class="text-white font-extrabold text-base uppercase tracking-wide leading-none">Ngafein</p>
                <p class="text-white/50 text-[9px] font-semibold uppercase tracking-[0.2em] mt-1 leading-none">Management</p>
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

        {{-- Persetujuan Kafe --}}
        <a href="{{ route('admin.approval.index') }}"
           class="flex items-center gap-4 px-4 py-3.5 rounded-2xl transition-all
           {{ request()->routeIs('admin.approval.*') ? 'bg-white text-[#B87A3D] shadow-lg' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
            <i data-lucide="check-square" class="w-5 h-5 flex-shrink-0"></i>
            <span x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen"
                  class="text-sm font-semibold whitespace-nowrap">Persetujuan Kafe</span>
        </a>

        {{-- Data Kriteria --}}
        <a href="{{ route('admin.kriteria.index') }}"
           class="flex items-center gap-4 px-4 py-3.5 rounded-2xl transition-all
           {{ request()->routeIs('admin.kriteria.*') ? 'bg-white text-[#B87A3D] shadow-lg' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
            <i data-lucide="layers" class="w-5 h-5 flex-shrink-0"></i>
            <span x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen"
                  class="text-sm font-semibold whitespace-nowrap">Data Kriteria</span>
        </a>

        {{-- Data Alternatif (accordion) --}}
        <div>
            {{-- Toggle label (expanded) --}}
            <button
                @click="alternatifOpen = !alternatifOpen"
                x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen"
                class="w-full flex items-center justify-between gap-4 px-4 py-3.5 rounded-2xl transition-all
                {{ (request()->routeIs('admin.cafe.*') || request()->routeIs('admin.fasilitas.*') || request()->routeIs('admin.menu.*') || request()->routeIs('admin.galeri.*')) ? 'bg-white/20 text-white' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                <div class="flex items-center gap-4">
                    <i data-lucide="coffee" class="w-5 h-5 flex-shrink-0"></i>
                    <span class="text-sm font-semibold whitespace-nowrap">Data Alternatif</span>
                </div>
                <div class="transition-transform duration-300 flex-shrink-0 flex items-center justify-center"
                     :class="alternatifOpen ? 'rotate-180' : ''">
                    <i data-lucide="chevron-down" class="w-4 h-4"></i>
                </div>
            </button>

            {{-- Icon only (collapsed) --}}
            <button
                @click="alternatifOpen = !alternatifOpen"
                x-show="!$store.sidebar.isExpanded && !$store.sidebar.isHovered && !$store.sidebar.isMobileOpen"
                class="w-full flex items-center justify-center px-4 py-3.5 rounded-2xl transition-all
                {{ (request()->routeIs('admin.cafe.*') || request()->routeIs('admin.fasilitas.*') || request()->routeIs('admin.menu.*') || request()->routeIs('admin.galeri.*')) ? 'bg-white/20 text-white' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                <i data-lucide="coffee" class="w-5 h-5"></i>
            </button>

            {{-- Sub-menu Data Alternatif --}}
            <div x-show="alternatifOpen && ($store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen)"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 -translate-y-2"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 translate-y-0"
                 x-transition:leave-end="opacity-0 -translate-y-2"
                 class="mt-1 ml-4 pl-4 border-l-2 border-white/20 space-y-1">

                <p class="text-[9px] font-black text-white/30 uppercase tracking-[0.15em] px-2 pt-2 pb-1">Alternatif</p>

                <a href="{{ route('admin.cafe.index') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all text-sm
                   {{ request()->routeIs('admin.cafe.*') ? 'bg-white text-[#B87A3D] shadow font-bold' : 'text-white/60 hover:bg-white/10 hover:text-white font-medium' }}">
                    <i data-lucide="store" class="w-4 h-4 flex-shrink-0"></i>
                    <span class="whitespace-nowrap">Daftar Kafe</span>
                </a>

                <a href="{{ route('admin.fasilitas.index') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all text-sm
                   {{ request()->routeIs('admin.fasilitas.*') ? 'bg-white text-[#B87A3D] shadow font-bold' : 'text-white/60 hover:bg-white/10 hover:text-white font-medium' }}">
                    <i data-lucide="check-square" class="w-4 h-4 flex-shrink-0"></i>
                    <span class="whitespace-nowrap">Fasilitas Kafe</span>
                </a>

                <a href="{{ route('admin.menu.index') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all text-sm
                   {{ request()->routeIs('admin.menu.*') ? 'bg-white text-[#B87A3D] shadow font-bold' : 'text-white/60 hover:bg-white/10 hover:text-white font-medium' }}">
                    <i data-lucide="clipboard-list" class="w-4 h-4 flex-shrink-0"></i>
                    <span class="whitespace-nowrap">Kategori Menu</span>
                </a>

                <a href="{{ route('admin.galeri.batch') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all text-sm
                   {{ request()->routeIs('admin.galeri.*') ? 'bg-white text-[#B87A3D] shadow font-bold' : 'text-white/60 hover:bg-white/10 hover:text-white font-medium' }}">
                    <i data-lucide="image-plus" class="w-4 h-4 flex-shrink-0"></i>
                    <span class="whitespace-nowrap">Batch Upload Foto</span>
                </a>
            </div>
        </div>

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
                <div class="transition-transform duration-300 flex-shrink-0 flex items-center justify-center"
                     :class="sawOpen ? 'rotate-180' : ''">
                    <i data-lucide="chevron-down" class="w-4 h-4"></i>
                </div>
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

        <a href="{{ route('admin.user.index') }}"
           class="flex items-center gap-4 px-4 py-3.5 rounded-2xl transition-all
           {{ request()->routeIs('admin.user.*') ? 'bg-white text-[#B87A3D] shadow-lg' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
            <i data-lucide="users" class="w-5 h-5 flex-shrink-0"></i>
            <span x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen"
                  class="text-sm font-semibold whitespace-nowrap">User Admin</span>
        </a>

        <a href="{{ route('admin.laporan.index') }}"
           class="flex items-center gap-4 px-4 py-3.5 rounded-2xl transition-all
           {{ request()->routeIs('admin.laporan.*') ? 'bg-white text-[#B87A3D] shadow-lg' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
            <i data-lucide="printer" class="w-5 h-5 flex-shrink-0"></i>
            <span x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered || $store.sidebar.isMobileOpen"
                  class="text-sm font-semibold whitespace-nowrap">Laporan</span>
        </a>

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
