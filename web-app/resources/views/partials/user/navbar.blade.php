<nav class="fixed top-0 left-0 right-0 z-50 px-4 sm:px-6 lg:px-8 transition-all duration-500 ease-in-out"
     :class="scrolled ? 'bg-white/95 backdrop-blur-md shadow-md py-4 border-b border-gray-100' : 'bg-transparent py-8'">
    <div class="max-w-7xl mx-auto flex items-center justify-between">
        <!-- Logo Kiri -->
        <a href="/" class="flex items-center gap-4 group">
            <img src="{{ asset('assets/images/logo-ngafein.png') }}" 
                 alt="Ngafein Logo" 
                 class="h-14 sm:h-16 w-auto object-contain transition-transform duration-300 group-hover:scale-105">
            <span class="font-serif font-bold text-2xl sm:text-3xl tracking-tight transition-colors duration-500"
                  :class="scrolled ? '' : 'text-white'">
                <span :class="scrolled ? 'text-[#2B1A09]' : 'text-white'">Ngafe</span><span class="text-[#B87C39]">in</span><span class="text-[#B87C39]">.</span>
            </span>
        </a>
        
        <!-- Container Menu Desktop -->
        <div class="hidden md:flex items-center gap-10 text-[15px] font-bold transition-colors duration-500"
             :class="scrolled ? 'text-[#2B1A09]/80' : 'text-white'">
            <a href="#" class="transition-colors hover:text-[#B87C39]">Beranda</a>
            <a href="{{ route('user.explore.index') }}" class="transition-colors hover:text-[#B87C39]">Eksplorasi</a>
            <a href="#" class="transition-colors hover:text-[#B87C39]">Rekomendasi</a>
            <a href="#" class="transition-colors hover:text-[#B87C39]">Tentang</a>
        </div>
    </div>
</nav>
