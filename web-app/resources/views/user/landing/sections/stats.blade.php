<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 relative z-20 mt-16 sm:mt-24 mb-24">
    <div class="bg-[#2B1A09] rounded-[2rem] p-8 sm:p-10 lg:p-12 shadow-2xl shadow-[#2B1A09]/40 border border-[#B87C39]/20 flex flex-col lg:flex-row items-center justify-between gap-10 lg:gap-6 xl:gap-10">
        <div class="flex-1 text-center lg:text-left">
            <h2 class="font-plus-jakarta text-2xl sm:text-3xl font-bold text-[#F0E0C0] mb-3 leading-tight">
                Eksplorasi Kafe <span class="text-[#B87C39] font-bold">Tanpa Batas</span>
            </h2>
            <p class="font-plus-jakarta text-[#F0E0C0]/75 text-base max-w-md mx-auto lg:mx-0 leading-relaxed">
                Temukan spot terbaik dengan ulasan jujur, foto terkini, dan fasilitas yang sesuai dengan kebutuhanmu.
            </p>
        </div>
        
        <div class="flex flex-col sm:flex-row flex-wrap items-center justify-center gap-8 sm:gap-10">
            <div class="flex items-center gap-8 sm:gap-10">
                <div class="text-center group cursor-default">
                    <span class="font-plus-jakarta block text-4xl sm:text-5xl font-bold text-[#B87C39] mb-1 group-hover:scale-110 transition-transform duration-300">
                        {{ $totalKafe ?? '120' }}+
                    </span>
                    <span class="font-plus-jakarta text-[11px] sm:text-xs font-bold text-[#B87C39]/60 uppercase tracking-widest">Kafe Terdaftar</span>
                </div>
                <div class="w-px h-16 bg-[#B87C39]/20"></div>
                <div class="text-center group cursor-default">
                    <span class="font-plus-jakarta block text-4xl sm:text-5xl font-bold text-[#B87C39] mb-1 group-hover:scale-110 transition-transform duration-300">
                        {{ number_format($avgRating ?? 4.8, 1) }}
                    </span>
                    <span class="font-plus-jakarta text-[11px] sm:text-xs font-bold text-[#B87C39]/60 uppercase tracking-widest">Rating Rata-rata</span>
                </div>
            </div>
            
            <a href="{{ route('user.explore.index') }}" class="font-plus-jakarta bg-[#B87C39] hover:bg-[#9a662e] text-white font-bold px-7 py-3.5 rounded-full transition-all duration-300 shadow-[0_0_20px_rgba(184,124,57,0.20)] flex items-center gap-2.5 mt-2 sm:mt-0 active:scale-95">
                <i data-lucide="search" class="w-4 h-4" stroke-width="2.5"></i> 
                Cari Rekomendasimu
            </a>
        </div>
    </div>
</div>