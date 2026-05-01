@php
    $thumb = $k->gambar->first()?->link_gambar
        ?? 'https://images.unsplash.com/photo-1554118811-1e0d58224f24?auto=format&fit=crop&q=80&w=800';
    $hargaMin = number_format($k->harga_min, 0, ',', '.');
    
    // Mapping Fasilitas untuk Hover State
    $hasWifi = $k->fasilitas->contains(fn($f) => str_contains(strtolower($f->nama_fasilitas), 'wifi'));
    $hasPlug = $k->fasilitas->contains(fn($f) => str_contains(strtolower($f->nama_fasilitas), 'colokan'));
    $hasAC = $k->fasilitas->contains(fn($f) => str_contains(strtolower($f->nama_fasilitas), 'ac'));
@endphp

<a href="{{ route('user.cafe.detail', $k->id_kafe) }}"
   class="group relative block aspect-[4/5] rounded-[2rem] overflow-hidden shadow-xl hover:shadow-[#b87c39]/20 transition-all duration-500 bg-gray-900">
    
    {{-- Background Image --}}
    <img src="{{ $thumb }}" alt="{{ $k->nama_kafe }}"
         class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition-transform duration-1000">
    
    {{-- Dark Gradient Overlay (Normal State) --}}
    <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/20 to-transparent opacity-80 group-hover:opacity-40 transition-opacity duration-500"></div>

    {{-- Top Badge --}}
    <div class="absolute top-5 left-5">
        <div class="bg-black/40 backdrop-blur-md border border-white/20 text-white px-3 py-1.5 rounded-xl flex items-center gap-2">
            <i class="fa-solid fa-mug-hot text-[9px]"></i>
            <span class="text-[9px] font-bold uppercase tracking-widest">Cafe</span>
        </div>
    </div>

    {{-- Bottom Info (Normal State) --}}
    <div class="absolute bottom-6 left-6 right-6 group-hover:translate-y-10 group-hover:opacity-0 transition-all duration-500">
        <div class="mb-3">
            <h3 class="text-xl font-black text-white leading-tight mb-1 tracking-tight">
                {{ $k->nama_kafe }}
            </h3>
            <div class="flex items-center gap-2 text-white/70 text-[10px] font-medium">
                <i class="fa-solid fa-location-dot text-[#b87c39]"></i>
                <span>Malang, Indonesia</span>
            </div>
        </div>

        <div class="flex items-center justify-between pt-3 border-t border-white/10">
            <div class="flex flex-col">
                <div class="flex items-center gap-1 mb-0.5">
                    <span class="text-base font-black text-white">{{ number_format($k->rating, 1) }}</span>
                    <div class="flex text-[8px] text-amber-400">
                        @for($i = 0; $i < 5; $i++)
                            <i class="fa-solid fa-star {{ $i < round($k->rating) ? '' : 'text-gray-600' }}"></i>
                        @endfor
                    </div>
                </div>
                <span class="text-[8px] font-bold text-white/40 uppercase tracking-widest">Really Good</span>
            </div>
            <div class="text-right">
                <span class="block text-base font-black text-white">Rp {{ $hargaMin }}</span>
                <span class="text-[8px] font-bold text-white/40 uppercase tracking-widest">Start from</span>
            </div>
        </div>
    </div>

    {{-- Hover Detail State (Glassmorphism) --}}
    <div class="absolute inset-0 bg-black/40 backdrop-blur-xl opacity-0 group-hover:opacity-100 transition-all duration-500 p-8 flex flex-col justify-center">
        <div class="space-y-6">
            <div class="flex items-center justify-between group/item">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-white/10 flex items-center justify-center text-white border border-white/10">
                        <i class="fa-solid fa-wifi text-xs"></i>
                    </div>
                    <span class="text-xs font-bold text-white tracking-wide">Internet</span>
                </div>
                <span class="px-2 py-1 bg-black/40 rounded-lg text-[9px] font-black text-white border border-white/10 uppercase tracking-widest">
                    {{ $hasWifi ? 'Fast' : 'N/A' }}
                </span>
            </div>

            <div class="flex items-center justify-between group/item">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-white/10 flex items-center justify-center text-white border border-white/10">
                        <i class="fa-solid fa-plug text-xs"></i>
                    </div>
                    <span class="text-xs font-bold text-white tracking-wide">Outlets</span>
                </div>
                <span class="px-2 py-1 bg-black/40 rounded-lg text-[9px] font-black text-white border border-white/10 uppercase tracking-widest">
                    {{ $hasPlug ? 'Enough' : 'Limited' }}
                </span>
            </div>

            <div class="flex items-center justify-between group/item">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-white/10 flex items-center justify-center text-white border border-white/10">
                        <i class="fa-solid fa-couch text-xs"></i>
                    </div>
                    <span class="text-xs font-bold text-white tracking-wide">Comfort</span>
                </div>
                <span class="px-2 py-1 bg-black/40 rounded-lg text-[9px] font-black text-white border border-white/10 uppercase tracking-widest">
                    {{ $hasAC ? 'High' : 'Standard' }}
                </span>
            </div>

            <div class="pt-6">
                <button class="w-full bg-white text-black font-black py-3 rounded-xl text-[10px] uppercase tracking-[0.2em] shadow-xl hover:scale-105 transition-transform">
                    View Details
                </button>
            </div>
        </div>
    </div>
</a>
