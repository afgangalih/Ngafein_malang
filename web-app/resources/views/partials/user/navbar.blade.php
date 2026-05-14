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
        </div>
    </div>
</nav>
