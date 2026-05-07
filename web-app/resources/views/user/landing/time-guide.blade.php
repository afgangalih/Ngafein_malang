<section>
    <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-12 gap-6">
        <div>
            <p class="text-[#B87C39] text-xs font-bold tracking-[0.2em] uppercase mb-3">Panduan Waktu</p>
            <h2 class="text-3xl md:text-4xl font-serif font-bold text-[#2B1A09]">Kapan Waktu Terbaik?</h2>
        </div>
        <p class="text-base text-[#2B1A09]/60 max-w-sm sm:text-right">
            Pilih ritme hari yang paling sesuai dengan aktivitasmu.
        </p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @php
            $h = now()->hour;
            $waktuGuide = [
                ['waktu' => '06:00 – 10:00', 'nama' => 'Pagi Sunyi', 'desc' => 'Udara segar, cocok untuk kerja fokus atau baca buku tanpa gangguan.', 'icon' => 'moon', 'on' => $h >= 6 && $h < 10],
                ['waktu' => '10:00 – 14:00', 'nama' => 'Morning Rush', 'desc' => 'Waktu produktif. Pas untuk meeting santai & diskusi ide bersama tim.', 'icon' => 'zap', 'on' => $h >= 10 && $h < 14],
                ['waktu' => '14:00 – 18:00', 'nama' => 'Golden Hour', 'desc' => 'Cahaya keemasan. Obrolan hangat dan foto instagramable dengan teman.', 'icon' => 'sun', 'on' => $h >= 14 && $h < 18],
                ['waktu' => '19:00 – 00:00', 'nama' => 'Night Mode', 'desc' => 'Remang lampu dan musik soft. Sempurna untuk melepas penat seharian.', 'icon' => 'moon', 'on' => $h >= 19 || $h < 6],
            ];
        @endphp

        @foreach($waktuGuide as $item)
        <div class="bg-white rounded-[2rem] p-8 border {{ $item['on'] ? 'border-[#B87C39] shadow-lg ring-1 ring-[#B87C39]/20' : 'border-gray-200' }} hover:border-[#B87C39]/40 hover:shadow-[0_15px_30px_-10px_rgba(0,0,0,0.05)] transition-all duration-300 flex flex-col">
            <div class="w-12 h-12 rounded-full {{ $item['on'] ? 'bg-[#B87C39] text-white' : 'bg-gray-50 text-[#B87C39]' }} flex items-center justify-center mb-6 border border-gray-100">
                <i data-lucide="{{ $item['icon'] }}" class="w-5 h-5"></i>
            </div>
            <div class="text-[10px] font-bold tracking-[0.15em] text-[#B87C39] mb-2 uppercase">{{ $item['waktu'] }}</div>
            <h4 class="text-lg font-bold text-[#2B1A09] mb-3">{{ $item['nama'] }}</h4>
            <p class="text-sm text-[#2B1A09]/60 leading-relaxed flex-1">{{ $item['desc'] }}</p>
        </div>
        @endforeach
    </div>
</section>
