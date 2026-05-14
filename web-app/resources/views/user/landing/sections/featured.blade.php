<section>
    <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-12 gap-6">
        <div>
            <p class="text-[#B87C39] text-xs font-bold tracking-[0.2em] uppercase mb-3">Kurasi Khusus</p>
            <h2 class="text-3xl md:text-4xl font-serif font-bold text-[#2B1A09]">Pilihan Bikin Betah</h2>
        </div>
        <a href="{{ route('user.explore.index') }}" class="text-base font-semibold text-[#2B1A09]/70 hover:text-[#B87C39] transition-colors flex items-center gap-2 group pb-1">
            Lihat Semua Kafe 
            <i data-lucide="chevron-right" class="w-5 h-5 group-hover:translate-x-1.5 transition-transform"></i>
        </a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 lg:gap-10">
        @foreach($kafeUnggulan as $kafe)
        <div class="group bg-white rounded-[2rem] overflow-hidden border border-gray-200 hover:border-[#B87C39]/30 hover:shadow-[0_20px_40px_-15px_rgba(184,124,57,0.15)] transition-all duration-500 flex flex-col">
            <div class="relative h-56 overflow-hidden bg-gray-100">
                @php
                    $gambarUtama = $kafe->gambar->first();
                    $urlGambar = $gambarUtama ? $gambarUtama->link_gambar : 'https://images.unsplash.com/photo-1554118811-1e0d58224f24?auto=format&fit=crop&w=600&q=80';
                @endphp
                <img src="{{ $urlGambar }}" 
                     alt="{{ $kafe->nama_kafe }}" 
                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-in-out">
                <div class="absolute top-4 left-4 bg-white/95 backdrop-blur-md px-3.5 py-1.5 rounded-full text-xs font-bold text-[#2B1A09] shadow-sm">
                    {{ $kafe->jarak ?? '0.8' }} km • Malang
                </div>
            </div>
            <div class="p-7 sm:p-8 flex flex-col flex-1">
                <h3 class="text-xl font-bold text-[#2B1A09] mb-2 group-hover:text-[#B87C39] transition-colors line-clamp-1">{{ $kafe->nama_kafe }}</h3>
                <p class="text-sm text-[#2B1A09]/60 mb-6 line-clamp-2 leading-relaxed">{{ $kafe->alamat }}</p>
                
                <div class="flex items-center gap-5 text-sm font-medium text-[#2B1A09]/70 mb-8 mt-auto">
                    <span class="flex items-center gap-2">
                        <i data-lucide="star" class="w-4 h-4 text-[#B87C39] fill-[#B87C39]"></i> 
                        {{ number_format($kafe->rating, 1) }}
                    </span>
                    <span class="flex items-center gap-2">
                        <i data-lucide="clock" class="w-4 h-4 text-gray-400"></i> 
                        {{ \Carbon\Carbon::parse($kafe->jam_buka)->format('H:i') }} - {{ \Carbon\Carbon::parse($kafe->jam_tutup)->format('H:i') }}
                    </span>
                </div>
                
                <div class="flex items-center justify-between border-t border-gray-100 pt-6">
                    <span class="text-base font-bold text-[#2B1A09]">
                        Rp {{ number_format($kafe->harga_min / 1000, 0) }}k - {{ number_format($kafe->harga_max / 1000, 0) }}k
                    </span>
                    <a href="{{ route('user.explore.detail', $kafe->id_kafe) }}" class="text-sm font-bold text-[#B87C39] hover:text-[#2B1A09] transition-colors flex items-center gap-1.5">
                        Detail <i data-lucide="chevron-right" class="w-4 h-4"></i>
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</section>
