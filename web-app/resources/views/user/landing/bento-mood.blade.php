<section>
    <div class="text-center max-w-3xl mx-auto mb-14">
        <p class="text-[#B87C39] text-xs font-bold tracking-[0.2em] uppercase mb-3">Eksplorasi Suasana</p>
        <h2 class="text-3xl md:text-4xl font-serif font-bold text-[#2B1A09] mb-5">Suasana yang Tepat,<br/><span class="text-[#B87C39] italic">Cerita Berbeda.</span></h2>
        <p class="text-[#2B1A09]/60 text-base md:text-lg leading-relaxed">
            Setiap hari membawa mood yang berbeda. Temukan ruang yang paling mengerti kebutuhanmu hari ini.
        </p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 auto-rows-[minmax(280px,auto)]">
        
        <div class="lg:col-span-2 rounded-[2.5rem] p-10 lg:p-14 border border-gray-200 bg-white shadow-sm hover:shadow-[0_20px_40px_-15px_rgba(0,0,0,0.05)] transition-all duration-300 flex flex-col justify-between group relative overflow-hidden">
            <div class="absolute -right-10 -top-10 w-64 h-64 bg-gray-50 rounded-full blur-3xl opacity-50 pointer-events-none"></div>
            <div>
                <div class="w-16 h-16 rounded-full bg-gray-50 text-[#2B1A09] flex items-center justify-center mb-8 border border-gray-100 group-hover:scale-110 transition-transform duration-500">
                    <i data-lucide="laptop" class="w-7 h-7"></i>
                </div>
                <h3 class="text-2xl md:text-3xl font-bold text-[#2B1A09] mb-4">Fokus & Produktif</h3>
                <p class="text-base text-[#2B1A09]/60 leading-relaxed max-w-md">
                    Kurasi kafe dengan WiFi anti-lelet, meja ergonomis, dan colokan listrik di setiap sudut. Bebas *overthinking* saat mengejar deadline.
                </p>
            </div>
            <a href="{{ route('user.explore.index', ['suasana' => 'wfc']) }}" class="mt-10 flex items-center gap-3 text-sm font-bold text-[#B87C39] group-hover:text-[#2B1A09] transition-colors cursor-pointer w-max">
                Jelajahi WFC Spots
                <div class="w-8 h-8 rounded-full bg-[#B87C39]/10 flex items-center justify-center group-hover:bg-gray-100 transition-colors">
                    <i data-lucide="arrow-up-right" class="w-4 h-4"></i>
                </div>
            </a>
        </div>

       
        <div class="lg:col-span-1 rounded-[2.5rem] p-10 bg-[#2B1A09] shadow-xl hover:shadow-[0_20px_40px_-15px_rgba(43,26,9,0.4)] transition-all duration-300 flex flex-col justify-between group relative overflow-hidden">
            <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#B87C39_1px,transparent_1px)] [background-size:20px_20px] pointer-events-none"></div>
            <div class="relative z-10">
                <div class="w-14 h-14 rounded-full bg-white/10 text-white flex items-center justify-center mb-8 backdrop-blur-md group-hover:scale-110 transition-transform duration-500">
                    <i data-lucide="camera" class="w-6 h-6"></i>
                </div>
                <h3 class="text-2xl font-bold text-white mb-4">Estetik & Konten</h3>
                <p class="text-sm text-white/70 leading-relaxed">
                    Desain interior yang memanjakan mata dan pencahayaan alami yang sempurna untuk mempercantik *feed* kamu.
                </p>
            </div>
            <a href="{{ route('user.explore.index', ['suasana' => 'estetik']) }}" class="relative z-10 mt-10 flex items-center gap-3 text-sm font-bold text-[#B87C39] group-hover:text-white transition-colors cursor-pointer w-max">
                Lihat Spot Fotogenik
                <div class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center transition-colors">
                    <i data-lucide="arrow-up-right" class="w-4 h-4"></i>
                </div>
            </a>
        </div>

        
        <div class="lg:col-span-3 rounded-[2.5rem] p-10 lg:px-14 bg-[#B87C39] shadow-xl hover:shadow-[0_20px_40px_-15px_rgba(184,124,57,0.4)] transition-all duration-300 flex flex-col md:flex-row md:items-center justify-between group overflow-hidden relative">
            <div class="absolute top-0 right-0 w-1/2 h-full bg-gradient-to-l from-white/10 to-transparent pointer-events-none"></div>
            
            <div class="flex-1 relative z-10 mb-8 md:mb-0 md:pr-10">
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-14 h-14 rounded-full bg-white/20 text-white flex items-center justify-center backdrop-blur-md group-hover:rotate-12 transition-transform duration-500">
                        <i data-lucide="users" class="w-6 h-6"></i>
                    </div>
                    <h3 class="text-2xl md:text-3xl font-bold text-white">Santai & Komunal</h3>
                </div>
                <p class="text-base text-white/90 leading-relaxed max-w-2xl">
                    Tempat dengan area semi-outdoor sejuk, meja komunal yang lebar, dan suasana hangat yang cocok untuk ngobrol lepas sampai malam bersama teman-teman terdekat.
                </p>
            </div>

            <div class="relative z-10 shrink-0">
                <a href="{{ route('user.explore.index', ['suasana' => 'santai']) }}" class="bg-white text-[#B87C39] px-8 py-4 rounded-full font-bold text-sm hover:bg-[#2B1A09] hover:text-white transition-all duration-300 shadow-lg flex items-center gap-2">
                    Cari Tempat Nongkrong
                    <i data-lucide="chevron-right" class="w-4 h-4"></i>
                </a>
            </div>
        </div>
    </div>
</section>
