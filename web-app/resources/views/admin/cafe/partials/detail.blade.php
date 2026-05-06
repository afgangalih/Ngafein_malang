<div class="space-y-8 animate-fade-in">
    
    <!-- Gallery Section -->
    @if($kafe->gambar->count() > 0)
        <div class="space-y-3">
            <div class="aspect-video w-full rounded-2xl overflow-hidden border border-gray-100 shadow-sm bg-gray-50">
                <img id="main-image-preview" src="{{ $kafe->gambar->first()->link_gambar }}" class="w-full h-full object-cover transition-all duration-500">
            </div>
            @if($kafe->gambar->count() > 1)
                <div class="flex gap-2 overflow-x-auto pb-2 scrollbar-hide">
                    @foreach($kafe->gambar as $img)
                        <img src="{{ $img->link_gambar }}" 
                             onclick="document.getElementById('main-image-preview').src = this.src"
                             class="w-16 h-16 rounded-xl object-cover border-2 border-transparent hover:border-[#b87c39] cursor-pointer transition-all flex-shrink-0">
                    @endforeach
                </div>
            @endif
        </div>
    @endif

    <!-- Header & Rating -->
    <div class="border-b border-gray-100 pb-6">
        <h2 class="text-3xl font-black text-gray-900 tracking-tight leading-tight">{{ $kafe->nama_kafe }}</h2>
        <div class="flex items-center gap-2 mt-3">
            <div class="flex items-center text-[#b87c39]">
                @for($i=1; $i<=5; $i++)
                    <i data-lucide="star" class="w-4 h-4 {{ $i <= $kafe->rating ? 'fill-current' : 'text-gray-200' }}"></i>
                @endfor
            </div>
            <span class="text-sm font-bold text-gray-700">{{ $kafe->rating }}</span>
            <span class="text-gray-300">•</span>
            <span class="text-sm font-medium text-gray-500">{{ $kafe->jarak }} Km dari Pusat</span>
        </div>
    </div>

    <!-- Overview Grid -->
    <div class="grid grid-cols-2 gap-6">
        <div class="space-y-1">
            <p class="text-[11px] font-bold text-[#b87c39] uppercase tracking-wider">Estimasi Harga</p>
            <p class="text-base font-bold text-gray-800">
                Rp {{ number_format($kafe->harga_min, 0, ',', '.') }} - {{ number_format($kafe->harga_max, 0, ',', '.') }}
            </p>
        </div>
        <div class="space-y-1">
            <p class="text-[11px] font-bold text-[#b87c39] uppercase tracking-wider">Jam Operasional</p>
            <p class="text-base font-bold text-gray-800">{{ $kafe->jam_buka }} — {{ $kafe->jam_tutup }}</p>
        </div>
    </div>

    <!-- Address Section -->
    <div class="space-y-2">
        <p class="text-[11px] font-bold text-[#b87c39] uppercase tracking-wider">Lokasi</p>
        <p class="text-[13px] text-gray-600 leading-relaxed font-medium">
            {{ $kafe->alamat ?? 'Alamat belum diatur' }}
        </p>
        @if($kafe->link_maps)
            <a href="{{ $kafe->link_maps }}" target="_blank" class="inline-flex items-center gap-1.5 text-xs font-bold text-[#b87c39] hover:brightness-90 mt-1">
                <i data-lucide="map-pin" class="w-3.5 h-3.5"></i>
                Buka di Google Maps
            </a>
        @endif
    </div>

    <!-- Deskripsi -->
    @if($kafe->deskripsi)
        <div class="space-y-2 p-4 bg-gray-50 rounded-2xl border border-gray-100">
            <p class="text-[13px] text-gray-600 leading-relaxed italic">
                "{{ $kafe->deskripsi }}"
            </p>
        </div>
    @endif

    <!-- Content Split: Facilities & Menus -->
    <div class="grid grid-cols-1 gap-8 pt-2">
        
        <!-- Fasilitas -->
        <div class="space-y-4">
            <h4 class="text-sm font-black text-gray-900 flex items-center gap-2">
                <span class="w-1.5 h-1.5 rounded-full bg-[#b87c39]"></span>
                Fasilitas
            </h4>
            <div class="flex flex-wrap gap-2">
                @forelse($kafe->fasilitas as $f)
                    <span class="px-3 py-1.5 bg-white text-gray-700 text-[12px] font-semibold rounded-lg border border-gray-200 shadow-sm">
                        {{ $f->nama_fasilitas }}
                    </span>
                @empty
                    <p class="text-xs text-gray-400 italic">Belum ada fasilitas</p>
                @endforelse
            </div>
        </div>

        <!-- Menu -->
        <div class="space-y-4 pb-12">
            <h4 class="text-sm font-black text-gray-900 flex items-center gap-2">
                <span class="w-1.5 h-1.5 rounded-full bg-[#b87c39]"></span>
                Menu Andalan
            </h4>
            <ul class="grid grid-cols-2 gap-y-2 gap-x-4">
                @forelse($kafe->menus as $m)
                    <li class="flex items-center gap-2 text-[13px] text-gray-600 font-medium">
                        <i data-lucide="check" class="w-3.5 h-3.5 text-[#b87c39]"></i>
                        {{ $m->nama_menu }}
                    </li>
                @empty
                    <li class="text-xs text-gray-400 italic">Daftar menu belum tersedia</li>
                @endforelse
            </ul>
        </div>

    </div>

</div>
