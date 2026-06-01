<nav class="fixed top-0 left-0 right-0 z-50 transition-[padding] duration-300 ease-out"
     :class="(scrolled || lightMode) ? 'py-3' : 'py-6'">
    
    {{-- Absolute Background Layer for Hardware-Accelerated Blur Transition --}}
    <div class="absolute inset-0 transition-opacity duration-300 ease-out"
         :class="(scrolled || lightMode) ? 'opacity-100 bg-white/85 backdrop-blur-xl border-b border-gray-200/60 shadow-sm' : 'opacity-0 bg-transparent border-b border-transparent'">
    </div>

    {{-- Navbar Content --}}
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between">
       
        <a href="/" class="flex items-center gap-4 group">
            <img src="{{ asset('assets/images/logo-ngafein.png') }}" 
                 alt="Ngafein Logo" 
                 class="h-14 sm:h-16 w-auto object-contain transition-transform duration-300 group-hover:scale-105">
            <span class="font-serif font-bold text-2xl sm:text-3xl tracking-tight">
                <span class="transition-colors duration-300" 
                      :class="(scrolled || lightMode || forceDarkText) ? 'text-gray-900' : 'text-white'">Ngafe</span><span class="text-[#B87C39]">in</span><span class="text-[#B87C39]">.</span>
            </span>
        </a>
        
        <div class="hidden md:flex items-center gap-10 text-[15px] font-semibold transition-colors duration-300"
             :class="(scrolled || lightMode) ? 'text-gray-800' : (forceDarkText ? 'text-gray-800' : 'text-white/90')">
            
            <a href="{{ route('user.home') }}" 
               class="transition-colors hover:text-[#B87C39] {{ request()->routeIs('user.home') ? 'text-[#B87C39]' : '' }}">
                Beranda
            </a>
            
            <a href="{{ route('user.explore.index') }}" 
               class="transition-colors hover:text-[#B87C39] {{ request()->routeIs('user.explore.*') ? 'text-[#B87C39]' : '' }}">
                Eksplorasi
            </a>
            
            <a href="{{ route('user.kafe.rekomendasi') }}" 
               class="transition-colors hover:text-[#B87C39] {{ request()->routeIs('user.kafe.rekomendasi') ? 'text-[#B87C39]' : '' }}">
                Rekomendasi
            </a>
            
            <a href="{{ route('user.about') }}" 
            class="transition-colors hover:text-[#B87C39] {{ request()->routeIs('user.about') ? 'text-[#B87C39]' : '' }}">
                Tentang
            </a>

            @guest
                <button @click="$dispatch('open-login-modal')" 
                        class="bg-[#B87C39] hover:bg-[#a66c2e] text-white text-[13px] font-bold px-5 py-2.5 rounded-full transition-all duration-300 cursor-pointer shadow-md hover:shadow-[#B87C39]/30">
                    Masuk
                </button>
            @endguest

            @auth
                <div x-data="{ open: false }" class="relative" @click.outside="open = false">
                    <button @click="open = !open" 
                            class="flex items-center gap-2 group focus:outline-none cursor-pointer">
                        <div class="w-8 h-8 rounded-full bg-[#B87C39]/20 text-[#B87C39] border border-[#B87C39]/30 flex items-center justify-center overflow-hidden shrink-0 transition-colors group-hover:bg-[#B87C39]/30">
                            <svg viewBox="0 0 24 24" class="w-4.5 h-4.5 fill-none stroke-current" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/>
                                <circle cx="12" cy="7" r="4"/>
                            </svg>
                        </div>
                        <svg viewBox="0 0 24 24" class="w-3.5 h-3.5 transition-transform duration-200 fill-none stroke-current" :class="open ? 'rotate-180' : ''" stroke-width="2.5"><path d="m6 9 6 6 6-6"/></svg>
                    </button>
                    <div x-show="open" 
                         x-transition 
                         class="absolute right-0 mt-3 w-48 bg-white border border-gray-100 rounded-2xl shadow-xl p-2 text-sm z-50 text-gray-800">
                        <div class="px-4 py-2 border-b border-gray-50 mb-1.5">
                            <p class="font-bold text-xs text-gray-900 truncate">{{ Auth::user()->name }}</p>
                            <p class="text-[10px] text-gray-400 truncate">{{ Auth::user()->email }}</p>
                        </div>
                        <a href="{{ route('user.favorit') }}" class="flex items-center gap-2 px-3 py-2 hover:bg-[#B87C39]/5 hover:text-[#B87C39] rounded-xl transition-all font-semibold text-xs">
                            <i data-lucide="bookmark" class="w-4 h-4 text-[#B87C39]"></i> Favorit Saya
                        </a>
                        <a href="{{ route('user.kafe.usulan') }}" class="flex items-center gap-2 px-3 py-2 hover:bg-[#B87C39]/5 hover:text-[#B87C39] rounded-xl transition-all font-semibold text-xs {{ request()->routeIs('user.kafe.usulan') ? 'bg-[#B87C39]/5 text-[#B87C39]' : '' }}">
                            <i data-lucide="history" class="w-4 h-4 text-[#B87C39]"></i> Usulan Saya
                        </a>
                        <a href="{{ route('user.kafe.tambah') }}" class="flex items-center gap-2 px-3 py-2 hover:bg-[#B87C39]/5 hover:text-[#B87C39] rounded-xl transition-all font-semibold text-xs">
                            <i data-lucide="plus-circle" class="w-4 h-4 text-[#B87C39]"></i> Tambah Kafe
                        </a>
                        @if(Auth::user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 px-3 py-2 hover:bg-[#B87C39]/5 hover:text-[#B87C39] rounded-xl transition-all font-semibold text-xs">
                                <i data-lucide="layout-dashboard" class="w-4 h-4 text-[#B87C39]"></i> Dashboard Admin
                            </a>
                        @endif
                        <form action="{{ route('logout') }}" method="POST" class="mt-1 border-t border-gray-50 pt-1">
                            @csrf
                            <button type="submit" class="w-full flex items-center gap-2 px-3 py-2 text-red-500 hover:bg-red-50 rounded-xl transition-all font-semibold text-xs text-left cursor-pointer">
                                <i data-lucide="log-out" class="w-4 h-4"></i> Keluar
                            </button>
                        </form>
                    </div>
                </div>
            @endauth
        </div>
    </div>
</nav>
