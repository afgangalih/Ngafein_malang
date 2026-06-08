@php
    $thumb = $k->gambar->first()?->link_gambar
        ?? 'https://images.unsplash.com/photo-1554118811-1e0d58224f24?auto=format&fit=crop&q=80&w=800';
    $hargaMin = number_format($k->harga_min, 0, ',', '.');
    
    // Mapping Fasilitas untuk Hover State
    $hasWifi = $k->fasilitas->contains(fn($f) => str_contains(strtolower($f->nama_fasilitas), 'wifi'));
    $hasPlug = $k->fasilitas->contains(fn($f) => str_contains(strtolower($f->nama_fasilitas), 'colokan'));
    $hasAC = $k->fasilitas->contains(fn($f) => str_contains(strtolower($f->nama_fasilitas), 'ac'));
@endphp

@php
    $isBlacklisted = Auth::check() && Auth::user()->blacklistedCafes->contains('id_kafe', $k->id_kafe);
@endphp

<a href="{{ route('user.explore.detail', $k->id_kafe) }}"
   x-data="{ blacklisted: {{ $isBlacklisted ? 'true' : 'false' }} }"
   @blacklist-toggled.window="if ($event.detail.id === {{ $k->id_kafe }}) blacklisted = $event.detail.blacklisted"
   :class="blacklisted ? 'opacity-40 grayscale-[60%] hover:opacity-100 hover:grayscale-0 duration-300' : ''"
   class="group relative block aspect-[4/5] rounded-2xl sm:rounded-[2rem] overflow-hidden shadow-xl hover:shadow-[#b87c39]/20 transition-all duration-500 bg-gray-900">
    
    {{-- Background Image --}}
    <img src="{{ $thumb }}" alt="{{ $k->nama_kafe }}"
         class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition-transform duration-1000">
    
    {{-- Dark Gradient Overlay (Normal State) --}}
    <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/20 to-transparent opacity-80 group-hover:opacity-40 transition-opacity duration-500"></div>

    {{-- Top Badge --}}
    <div class="absolute top-3 left-3 sm:top-5 sm:left-5">
        <div class="bg-black/40 backdrop-blur-md border border-white/20 text-white px-2.5 py-1 sm:px-3 sm:py-1.5 rounded-lg sm:rounded-xl flex items-center gap-1.5 sm:gap-2">
            <i data-lucide="coffee" class="w-2.5 h-2.5 sm:w-3 sm:h-3 text-[#B87C39]"></i>
            <span class="text-[8px] sm:text-[9px] font-bold uppercase tracking-widest">Cafe</span>
        </div>
    </div>

    <x-user.ui.bookmark-button :kafe="$k" />
    <x-user.ui.blacklist-button :kafe="$k" />

    {{-- Bottom Info (Normal State) --}}
    <div class="absolute bottom-3.5 left-3.5 right-3.5 sm:bottom-6 sm:left-6 sm:right-6 group-hover:translate-y-10 group-hover:opacity-0 transition-all duration-500">
        <div class="mb-2 sm:mb-3">
            <h3 class="text-sm sm:text-base md:text-xl font-black text-white leading-tight mb-0.5 sm:mb-1 tracking-tight line-clamp-1">
                {{ $k->nama_kafe }}
            </h3>
            <div class="flex items-center gap-1.5 sm:gap-2 text-white/70 text-[9px] sm:text-[10px] font-medium">
                <i data-lucide="map-pin" class="w-2.5 h-2.5 sm:w-3 sm:h-3 text-[#b87c39]"></i>
                <span class="truncate">Malang, Indonesia</span>
            </div>
        </div>

        <div class="flex items-center justify-between pt-2 sm:pt-3 border-t border-white/10">
            <div class="flex flex-col">
                <div class="flex items-center gap-0.5 sm:gap-1 mb-0.5">
                    <span class="text-xs sm:text-sm md:text-base font-black text-white">{{ number_format($k->rating, 1) }}</span>
                    <div class="flex gap-0.5">
                        @for($i = 0; $i < 5; $i++)
                            <i data-lucide="star" class="w-2 h-2 sm:w-2.5 sm:h-2.5 {{ $i < round($k->rating) ? 'fill-amber-400 text-amber-400' : 'text-gray-600' }}"></i>
                        @endfor
                    </div>
                </div>
                <span class="text-[7px] sm:text-[8px] font-bold text-white/40 uppercase tracking-widest">Really Good</span>
            </div>
            <div class="text-right">
                <span class="block text-xs sm:text-sm md:text-base font-black text-white">Rp {{ $hargaMin }}</span>
                <span class="text-[7px] sm:text-[8px] font-bold text-white/40 uppercase tracking-widest">Start from</span>
            </div>
        </div>
    </div>

    {{-- Hover Detail State (Glassmorphism) --}}
    <div class="absolute inset-0 bg-black/40 backdrop-blur-xl opacity-0 group-hover:opacity-100 transition-all duration-500 p-4 sm:p-8 flex flex-col justify-center">
        <div class="space-y-3 sm:space-y-6">
            <div class="flex items-center justify-between group/item">
                <div class="flex items-center gap-2 sm:gap-3">
                    <div class="w-6.5 h-6.5 sm:w-8 sm:h-8 rounded-md sm:rounded-lg bg-white/10 flex items-center justify-center text-white border border-white/10">
                        <i data-lucide="wifi" class="w-3.5 h-3.5 sm:w-4 sm:h-4"></i>
                    </div>
                    <span class="text-[10px] sm:text-xs font-bold text-white tracking-wide">Internet</span>
                </div>
                <span class="px-1.5 py-0.5 sm:px-2 sm:py-1 bg-black/40 rounded-lg text-[8px] sm:text-[9px] font-black text-white border border-white/10 uppercase tracking-widest">
                    {{ $hasWifi ? 'Fast' : 'N/A' }}
                </span>
            </div>

            <div class="flex items-center justify-between group/item">
                <div class="flex items-center gap-2 sm:gap-3">
                    <div class="w-6.5 h-6.5 sm:w-8 sm:h-8 rounded-md sm:rounded-lg bg-white/10 flex items-center justify-center text-white border border-white/10">
                        <i data-lucide="zap" class="w-3.5 h-3.5 sm:w-4 sm:h-4"></i>
                    </div>
                    <span class="text-[10px] sm:text-xs font-bold text-white tracking-wide">Outlets</span>
                </div>
                <span class="px-1.5 py-0.5 sm:px-2 sm:py-1 bg-black/40 rounded-lg text-[8px] sm:text-[9px] font-black text-white border border-white/10 uppercase tracking-widest">
                    {{ $hasPlug ? 'Enough' : 'Limited' }}
                </span>
            </div>

            <div class="flex items-center justify-between group/item">
                <div class="flex items-center gap-2 sm:gap-3">
                    <div class="w-6.5 h-6.5 sm:w-8 sm:h-8 rounded-md sm:rounded-lg bg-white/10 flex items-center justify-center text-white border border-white/10">
                        <i data-lucide="armchair" class="w-3.5 h-3.5 sm:w-4 sm:h-4"></i>
                    </div>
                    <span class="text-[10px] sm:text-xs font-bold text-white tracking-wide">Comfort</span>
                </div>
                <span class="px-1.5 py-0.5 sm:px-2 sm:py-1 bg-black/40 rounded-lg text-[8px] sm:text-[9px] font-black text-white border border-white/10 uppercase tracking-widest">
                    {{ $hasAC ? 'High' : 'Standard' }}
                </span>
            </div>

            <div class="pt-3 sm:pt-6">
                <button class="w-full bg-white text-black font-black py-2.5 sm:py-3 rounded-lg sm:rounded-xl text-[9px] sm:text-[10px] uppercase tracking-[0.2em] shadow-xl hover:scale-105 transition-transform">
                    View Details
                </button>
            </div>
        </div>
    </div>
</a>
