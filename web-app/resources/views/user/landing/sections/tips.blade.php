@php
    $tips = [
        [
            'num' => '01',
            'tag' => '16:00 – 20:00',
            'judul' => 'Hindari Jam Ramai',
            'desc' => 'Kafe mulai padat dari sore ke malam. Datang sebelum jam 16.00 atau agak malam biar dapat tempat duduk yang nyaman.',
            'icon' => 'clock'
        ],
        [
            'num' => '02',
            'tag' => 'WiFi & Colokan',
            'judul' => 'Pilih Kafe WFC',
            'desc' => 'Cari kafe dengan WiFi cepat dan banyak colokan agar lebih nyaman kerja atau nugas berlama-lama tanpa khawatir baterai habis.',
            'icon' => 'wifi'
        ],
        [
            'num' => '03',
            'tag' => 'Cashless',
            'judul' => 'Siapkan Non-Tunai',
            'desc' => 'Banyak kafe modern mengutamakan QRIS atau e-wallet. Siapkan dari awal biar transaksi di kasir lebih cepat dan praktis.',
            'icon' => 'credit-card'
        ],
        [
            'num' => '04',
            'tag' => 'Sebelum 10:00',
            'judul' => 'Outdoor Pagi Hari',
            'desc' => 'Kafe outdoor paling enak sebelum cuaca terik. Nikmati udara segar dan cahaya pagi sebelum pukul 10.00 untuk mood booster.',
            'icon' => 'sun'
        ],
        [
            'num' => '05',
            'tag' => 'Area Parkir',
            'judul' => 'Cek Akses Parkir',
            'desc' => 'Kafe hits sering kali punya parkir terbatas. Datang lebih awal atau pastikan kafe pilihanmu memiliki lahan parkir yang memadai.',
            'icon' => 'car'
        ]
    ];
@endphp

<section class="w-full bg-[#ffffff] py-20 md:py-28 border-b border-[#6e4a2f]/10">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-[#fcfaf8] rounded-[3rem] p-8 sm:p-12 lg:p-16 border border-[#6e4a2f]/10 shadow-sm relative overflow-hidden">
            <div class="absolute -top-40 -right-40 w-96 h-96 bg-[#B87C39]/5 rounded-full blur-[100px] pointer-events-none"></div>

            <div class="text-center max-w-3xl mx-auto mb-14 relative z-10">
                <p class="font-plus-jakarta text-[#B87C39] text-xs font-bold tracking-[0.2em] uppercase mb-3">Panduan Ngopi</p>
                <h2 class="font-plus-jakarta text-3xl md:text-4xl font-bold text-[#2B1A09] mb-5">
                    5 Tips Ngopi di <span class="text-[#B87C39] font-bold">Malang</span>
                </h2>
                <p class="font-plus-jakarta text-[#3a2719]/60 text-base md:text-lg leading-relaxed">
                    Supaya sesi ngopi, nugas, atau nongkrong kamu makin nyaman, efisien, dan berkesan.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-6 relative z-10">
                @foreach($tips as $idx => $tip)
                <div class="bg-white rounded-[2rem] p-8 border border-[#6e4a2f]/10 hover:border-[#B87C39]/40 hover:shadow-[0_15px_30px_-10px_rgba(110,74,47,0.10)] transition-all duration-300 relative overflow-hidden group 
                    {{ $idx < 2 ? 'lg:col-span-3' : 'lg:col-span-2' }}">
                    
                    <div class="absolute -right-4 -bottom-6 font-plus-jakarta text-[140px] font-black text-[#6e4a2f]/4 group-hover:text-[#B87C39]/6 transition-colors duration-500 leading-none tracking-tighter select-none pointer-events-none z-0">
                        {{ $tip['num'] }}
                    </div>
                    
                    <div class="relative z-10 flex flex-col h-full">
                        <div class="w-14 h-14 rounded-2xl bg-[#fcfaf8] text-[#B87C39] flex items-center justify-center mb-6 border border-[#6e4a2f]/10 group-hover:bg-[#B87C39] group-hover:text-white transition-colors duration-300">
                            <i data-lucide="{{ $tip['icon'] }}" class="w-6 h-6"></i>
                        </div>
                        <div class="font-plus-jakarta text-[12px] font-bold tracking-[0.2em] text-[#B87C39] mb-3 uppercase">
                            {{ $tip['tag'] }}
                        </div>
                        <h4 class="font-plus-jakarta text-xl font-bold text-[#2B1A09] mb-3">
                            {{ $tip['judul'] }}
                        </h4>
                        <p class="font-plus-jakarta text-sm text-[#3a2719]/60 leading-relaxed flex-1 pr-6">
                            {{ $tip['desc'] }}
                        </p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>