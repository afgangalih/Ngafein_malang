<nav class="bg-white/90 backdrop-blur-md sticky top-0 z-50 border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 md:px-8 py-4 flex items-center justify-between">
        <a href="/" class="text-xl font-extrabold text-gray-900 tracking-tighter flex-shrink-0">
            Ngafein<span class="text-[#b87c39]">.</span>
        </a>

        <div class="hidden md:flex items-center gap-8">
            <a href="{{ route('user.cafe.index') }}" class="text-[11px] font-black uppercase tracking-[0.2em] text-gray-500 hover:text-[#b87c39] transition-all">Explore</a>
            <a href="#" class="text-[11px] font-black uppercase tracking-[0.2em] text-gray-500 hover:text-[#b87c39] transition-all">Rekomendasi</a>
            <div class="h-4 w-[1px] bg-gray-200 mx-2"></div>
            <a href="/login" class="bg-gray-900 text-white text-[10px] font-black uppercase tracking-widest px-6 py-3 rounded-xl hover:bg-black transition-all shadow-lg shadow-gray-200">
                Admin Area
            </a>
        </div>

    </div>
</nav>
