{{-- resources/views/user/rekomendasi/partials/card-rekomendasi.blade.php --}}
<a href="{{ route('user.explore.detail', $kafe['id_kafe']) }}"
   @php
       $k = $kafe['model'];
       $isBlacklisted = Auth::check() && Auth::user()->blacklistedCafes->contains('id_kafe', $k->id_kafe);
   @endphp
   x-data="{ blacklisted: {{ $isBlacklisted ? 'true' : 'false' }} }"
   @blacklist-toggled.window="if ($event.detail.id === {{ $k->id_kafe }}) blacklisted = $event.detail.blacklisted"
   :class="blacklisted ? 'opacity-40 grayscale-[60%] hover:opacity-100 hover:grayscale-0 duration-300' : ''"
   class="kafe-card group relative bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-sm flex flex-col {{ $visibleCls }}"
   data-card-index="{{ $idx }}">

    <div class="relative h-52 overflow-hidden bg-gray-50 flex-shrink-0">
        @if($kafe['gambar'])
            <img src="{{ $kafe['gambar'] }}" alt="{{ $kafe['nama_kafe'] }}"
                 class="kafe-img w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" loading="lazy">
        @else
            <div class="w-full h-full flex items-center justify-center" style="background:#fdf8f3">
                <i data-lucide="coffee" class="w-14 h-14" style="color:#e5d5c0"></i>
            </div>
        @endif

        @if(!isset($engineError))
        <div class="absolute top-3.5 left-3.5 z-10">
            <span class="inline-flex items-center justify-center w-9 h-9 rounded-full text-white text-xs font-extrabold shadow-lg ring-[3px] ring-white/50 {{ $medalCls }}">
                #{{ $rank }}
            </span>
        </div>

        <div class="absolute top-3.5 right-3.5 z-10">
            <span class="inline-flex items-center gap-1 bg-white/90 backdrop-blur-sm text-[10px] font-bold px-2.5 py-1 rounded-full shadow-sm border border-white/60 text-[#B87C39]">
                <i data-lucide="cpu" class="w-2.5 h-2.5"></i>
                {{ $pct }}%
            </span>
        </div>
        @endif

        {{-- Compare Button (Bottom-Right of Image Overlay) --}}
        <div class="absolute bottom-3.5 right-3.5 z-20" @click.prevent.stop="">
            <button type="button" 
                    @click.prevent.stop="toggleCafe({
                        id: {{ $kafe['id_kafe'] }},
                        nama: '{{ addslashes($kafe['nama_kafe']) }}',
                        alamat: '{{ addslashes($kafe['alamat'] ?? '-') }}',
                        rating: '{{ $kafe['rating_raw'] }}',
                        jarak: '{{ $kafe['jarak_km'] }}',
                        jam: '{{ $kafe['jam_buka'] }} – {{ $kafe['jam_tutup'] }}',
                        harga: 'Rp {{ $rangeK }}',
                        skor: '{{ round($kafe['skor'] * 100) }}%',
                        perhitungan: '{{ $kafe['perhitungan'] }}',
                        rank: '#{{ $rank }}',
                        gambar: '{{ $kafe['gambar'] ?? 'https://images.unsplash.com/photo-1554118811-1e0d58224f24?auto=format&fit=crop&w=600&q=80' }}'
                    })"
                    class="w-9 h-9 rounded-full bg-white/95 backdrop-blur-sm shadow-md border border-gray-100 flex items-center justify-center transition-all duration-300 hover:scale-105 cursor-pointer focus:outline-none"
                    :class="selectedCafes.some(c => c.id === {{ $kafe['id_kafe'] }}) ? 'text-[#B87C39] border-[#B87C39] bg-[#B87C39]/10' : 'text-gray-400 hover:text-[#B87C39]'"
                    title="Bandingkan Kafe">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4"><path d="M16 3h5v5"/><path d="M8 3H3v5"/><path d="M21 16v5h-5"/><path d="M3 16v5h5"/><path d="M4 12h16"/></svg>
            </button>
        </div>

        <div class="absolute inset-x-0 bottom-0 h-16 pointer-events-none"
             style="background:linear-gradient(to top,rgba(0,0,0,.28),transparent)"></div>
    </div>

    <div class="p-5 flex flex-col flex-1 bg-white">
        <h3 class="font-bold text-gray-900 leading-snug mb-1 line-clamp-1 transition-colors group-hover:text-[#b87c39]" style="font-size:.97rem">{{ $kafe['nama_kafe'] }}</h3>
        <p class="text-[11px] text-gray-400 mb-4 line-clamp-1 flex items-center gap-1.5" style="font-weight:300">
            <i data-lucide="map-pin" class="w-3 h-3 flex-shrink-0" style="color:#b87c39"></i>
            {{ $kafe['alamat'] ?? '-' }}
        </p>

        <div class="flex items-center gap-3 pb-4 mb-4 border-b border-gray-50 text-xs font-medium text-gray-500">
            <span class="flex items-center gap-1">
                <i data-lucide="star" class="w-3.5 h-3.5" style="color:#f59e0b;fill:#f59e0b"></i>
                {{ $kafe['rating_raw'] }}
            </span>
            <span class="h-3 w-px bg-gray-200"></span>
            <span class="flex items-center gap-1">
                <i data-lucide="clock" class="w-3.5 h-3.5 text-gray-300"></i>
                {{ $kafe['jam_buka'] }} – {{ $kafe['jam_tutup'] }}
            </span>
            <span class="h-3 w-px bg-gray-200"></span>
            <span class="flex items-center gap-1">
                <i data-lucide="map-pin" class="w-3.5 h-3.5 text-gray-300"></i>
                {{ $kafe['jarak_km'] }} km
            </span>
        </div>

        @if(!isset($engineError))
        <div class="mb-5">
            <div class="flex justify-between items-center mb-1.5">
                <span class="text-[10px] font-semibold text-gray-300 uppercase tracking-wider">Skor SAW</span>
                <span class="text-[11px] font-bold" style="color:#b87c39">{{ $pct }}%</span>
            </div>
            <div class="w-full h-1 rounded-full bg-gray-100 overflow-hidden">
                <div class="saw-bar h-full rounded-full" data-width="{{ $pct }}"
                     style="width:0%;background:linear-gradient(to right,#e8c98a,#b87c39)"></div>
            </div>
        </div>
        @endif

        <div class="mt-auto flex items-end justify-between">
            <div>
                <p class="text-[10px] text-gray-400 mb-0.5" style="font-weight:300">Range Harga</p>
                <p class="font-bold text-gray-900" style="font-size:.97rem">
                    Rp {{ $rangeK }}
                </p>
            </div>
            <span class="inline-flex items-center gap-1.5 text-xs font-bold text-white px-4 py-2 rounded-xl transition-all group-hover:shadow-md group-hover:opacity-90"
                  style="background:#b87c39">
                Detail
                <i data-lucide="arrow-right" class="w-3.5 h-3.5 group-hover:translate-x-0.5 transition-transform"></i>
            </span>
        </div>
    </div>
</a>
