<footer class="bg-[#2B1A09] pt-16 pb-8 mt-10 border-t border-[#B87C39]/20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex flex-col lg:flex-row justify-between items-center gap-10 border-b border-white/10 pb-10 mb-8">
            <!-- Bagian Kiri: Brand -->
            <div class="flex flex-col items-center lg:items-start text-center lg:text-left">
                <div class="flex items-center gap-4 mb-6">
                    <div class="bg-white p-3 rounded-2xl shadow-lg shadow-black/20">
                        <img src="{{ asset('assets/images/logo-ngafein.png') }}" 
                             alt="Ngafein Logo" 
                             class="h-10 w-auto object-contain">
                    </div>
                    <span class="font-serif font-bold text-2xl text-white tracking-wide">
                        Ngafe<span class="text-[#B87C39]">in</span>.
                    </span>
                </div>
                <p class="text-sm text-white/60 max-w-md leading-relaxed">
                    Ngafein adalah platform kurasi kafe dan tempat nongkrong di Kota Malang. Kami mengumpulkan, menilai, dan merekomendasikan kafe terbaik agar kamu tidak perlu bingung lagi mencari tempat yang pas. Tinggal datang, pesan, dan nikmati.
                </p>
            </div>

            <!-- Bagian Kanan: Link Navigasi -->
            <div class="flex flex-col items-center lg:items-start gap-3">
                <p class="text-[12px] font-bold text-[#B87C39] tracking-[0.15em] uppercase">Halaman</p>
                <div class="flex flex-wrap justify-center lg:justify-start gap-x-6 gap-y-2.5 text-sm font-semibold text-white/80">
                    <a href="{{ route('user.home') }}" class="hover:text-[#B87C39] transition-colors">Beranda</a>
                    <span class="text-white/20 hidden sm:inline">•</span>
                    <a href="{{ route('user.explore.index') }}" class="hover:text-[#B87C39] transition-colors">Eksplorasi</a>
                    <span class="text-white/20 hidden sm:inline">•</span>
                    <a href="{{ route('user.kafe.rekomendasi') }}" class="hover:text-[#B87C39] transition-colors">Rekomendasi</a>
                    <span class="text-white/20 hidden sm:inline">•</span>
                    <a href="{{ route('user.about') }}" class="hover:text-[#B87C39] transition-colors">Tentang Kami</a>
                </div>
            </div>
        </div>

        <!-- Bottom Bar -->
        <div class="flex flex-col items-center justify-center text-center">
            <p class="text-[11px] font-bold text-white/40 tracking-[0.1em] uppercase">
                © {{ date('Y') }} Sistem Rekomendasi Kafe Kota Malang
            </p>
        </div>
        
    </div>
</footer>
