{{-- resources/views/user/rekomendasi/partials/comparison-modal.blade.php --}}
<div x-show="showModal"
     class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm"
     x-transition
     x-cloak>
    <div class="bg-white w-full max-w-4xl rounded-3xl md:rounded-[2.5rem] shadow-2xl border border-gray-100 overflow-hidden max-h-[90vh] flex flex-col animate-fade-up"
         @click.away="showModal = false">
        
        <!-- Modal Header -->
        <div class="p-4 md:p-8 border-b border-gray-100 flex items-center justify-between shrink-0 bg-[#FCFAF8]">
            <div class="flex items-center gap-2.5 md:gap-3.5">
                <div class="w-9 h-9 md:w-11 md:h-11 rounded-xl md:rounded-2xl bg-[#B87C39]/10 text-[#B87C39] flex items-center justify-center shadow-inner shrink-0">
                    <i data-lucide="git-compare" class="w-4.5 h-4.5 md:w-5 md:h-5"></i>
                </div>
                <div>
                    <h3 class="text-sm md:text-lg font-extrabold text-[#2B1A09] tracking-tight">Analisis Komparatif</h3>
                    <p class="text-[10px] md:text-xs text-gray-400 font-light mt-0.5">Perbandingan side-by-side berdasarkan parameter SAW</p>
                </div>
            </div>
            <button @click="showModal = false" class="w-7 h-7 md:w-8 md:h-8 flex items-center justify-center text-gray-400 hover:text-[#2B1A09] transition-colors rounded-full hover:bg-gray-200/50 cursor-pointer">
                <i data-lucide="x" class="w-4 h-4 md:w-5 md:h-5"></i>
            </button>
        </div>

        <!-- Modal Content (Scrollable Table) -->
        <div class="p-4 md:p-8 overflow-y-auto flex-1">
            
            <!-- Desktop/Tablet Scrollable Table View -->
            <div class="desktop-only-table overflow-x-auto scrollbar-hide -mx-4 md:mx-0 px-4 md:px-0">
                <table class="w-full min-w-[750px] border-collapse text-left table-fixed">
                    <thead>
                        <tr class="border-b border-gray-100">
                            <!-- Label column (Sticky on the left) -->
                            <th class="w-1/4 pb-6 pt-2 pr-4 text-xs font-bold text-gray-400 uppercase tracking-widest align-bottom sticky left-0 bg-white z-20">
                                Kriteria Evaluasi
                                <p class="text-[9px] text-gray-300 font-light lowercase mt-1 tracking-normal">nilai parameter & perhitungan saw</p>
                            </th>
                            
                            <!-- Cafe columns -->
                            <template x-for="cafe in selectedCafes" :key="cafe.id">
                                <th class="w-1/4 pb-6 px-3">
                                    <div class="bg-[#FCFAF8] rounded-2xl p-4 border border-gray-100 relative group transition-all hover:border-[#B87C39]/20 shadow-sm text-center">
                                        <div class="h-20 w-full rounded-xl overflow-hidden mb-3 relative bg-gray-50">
                                            <img :src="cafe.gambar" :alt="cafe.nama" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                            <span class="absolute top-2 left-2 inline-flex items-center justify-center w-6 h-6 rounded-full bg-white/95 text-[#B87C39] text-[10px] font-extrabold shadow-sm border border-gray-100" x-text="cafe.rank"></span>
                                        </div>
                                        <h4 class="font-bold text-[#2B1A09] text-xs line-clamp-1" x-text="cafe.nama"></h4>
                                        <p class="text-[9px] text-gray-400 mt-0.5 line-clamp-1 font-light" x-text="cafe.alamat"></p>
                                    </div>
                                </th>
                            </template>
                            
                            <!-- Fill empty column slots if less than 3 cafes selected -->
                            <template x-if="selectedCafes.length < 3">
                                <th class="w-1/4 pb-6 px-3">
                                    <div class="border border-dashed border-gray-200 rounded-2xl h-[162px] flex flex-col items-center justify-center text-center bg-gray-50/30">
                                        <i data-lucide="plus-circle" class="w-5 h-5 text-gray-300 mb-1"></i>
                                        <span class="text-[9px] text-gray-400">Pilih kafe lain</span>
                                    </div>
                                </th>
                            </template>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        
                        <!-- Row 1: Skor SAW -->
                        <tr class="hover:bg-[#FCFAF8]/40 transition-colors group">
                            <td class="py-4 pr-4 align-middle sticky left-0 bg-white group-hover:bg-[#FCFAF8]/40 transition-colors z-10">
                                <div class="flex items-center gap-2">
                                    <div class="w-7 h-7 rounded-lg bg-[#B87C39]/10 text-[#B87C39] flex items-center justify-center shrink-0">
                                        <i data-lucide="sparkles" class="w-4 h-4"></i>
                                    </div>
                                    <span class="text-xs font-bold text-[#2B1A09]">Skor SAW</span>
                                </div>
                            </td>
                            <template x-for="cafe in selectedCafes" :key="cafe.id">
                                <td class="py-4 px-3 text-center align-middle">
                                    <span class="inline-flex items-center justify-center px-3.5 py-1.5 rounded-full bg-[#B87C39] text-white text-xs font-extrabold shadow-sm" x-text="cafe.skor"></span>
                                </td>
                            </template>
                            <template x-if="selectedCafes.length < 3">
                                <td class="py-4 px-3"></td>
                            </template>
                        </tr>

                        <!-- Row 2: Harga Minimum -->
                        <tr class="hover:bg-[#FCFAF8]/40 transition-colors group">
                            <td class="py-4 pr-4 align-middle sticky left-0 bg-white group-hover:bg-[#FCFAF8]/40 transition-colors z-10">
                                <div class="flex items-center gap-2">
                                    <div class="w-7 h-7 rounded-lg bg-gray-100 text-gray-500 flex items-center justify-center shrink-0">
                                        <i data-lucide="banknote" class="w-4 h-4"></i>
                                    </div>
                                    <span class="text-xs font-bold text-gray-500">Harga Terendah</span>
                                </div>
                            </td>
                            <template x-for="cafe in selectedCafes" :key="cafe.id">
                                <td class="py-4 px-3 text-center align-middle text-xs font-bold text-[#2B1A09]" x-text="cafe.harga"></td>
                            </template>
                            <template x-if="selectedCafes.length < 3">
                                <td class="py-4 px-3"></td>
                            </template>
                        </tr>

                        <!-- Row 3: Jarak -->
                        <tr class="hover:bg-[#FCFAF8]/40 transition-colors group">
                            <td class="py-4 pr-4 align-middle sticky left-0 bg-white group-hover:bg-[#FCFAF8]/40 transition-colors z-10">
                                <div class="flex items-center gap-2">
                                    <div class="w-7 h-7 rounded-lg bg-gray-100 text-gray-500 flex items-center justify-center shrink-0">
                                        <i data-lucide="map-pin" class="w-4 h-4"></i>
                                    </div>
                                    <span class="text-xs font-bold text-gray-500">Jarak Lokasi</span>
                                </div>
                            </td>
                            <template x-for="cafe in selectedCafes" :key="cafe.id">
                                <td class="py-4 px-3 text-center align-middle text-xs font-bold text-[#2B1A09]" x-text="cafe.jarak + ' km'"></td>
                            </template>
                            <template x-if="selectedCafes.length < 3">
                                <td class="py-4 px-3"></td>
                            </template>
                        </tr>

                        <!-- Row 4: Rating -->
                        <tr class="hover:bg-[#FCFAF8]/40 transition-colors group">
                            <td class="py-4 pr-4 align-middle sticky left-0 bg-white group-hover:bg-[#FCFAF8]/40 transition-colors z-10">
                                <div class="flex items-center gap-2">
                                    <div class="w-7 h-7 rounded-lg bg-gray-100 text-gray-500 flex items-center justify-center shrink-0">
                                        <i data-lucide="star" class="w-4 h-4"></i>
                                    </div>
                                    <span class="text-xs font-bold text-gray-500">Rating</span>
                                </div>
                            </td>
                            <template x-for="cafe in selectedCafes" :key="cafe.id">
                                <td class="py-4 px-3 text-center align-middle text-xs font-bold text-[#2B1A09]">
                                    <div class="inline-flex items-center gap-1 justify-center">
                                        <i data-lucide="star" class="w-3.5 h-3.5 text-amber-400 fill-amber-400"></i>
                                        <span x-text="cafe.rating"></span>
                                    </div>
                                </td>
                            </template>
                            <template x-if="selectedCafes.length < 3">
                                <td class="py-4 px-3"></td>
                            </template>
                        </tr>

                        <!-- Row 5: Jam Operasional -->
                        <tr class="hover:bg-[#FCFAF8]/40 transition-colors group">
                            <td class="py-4 pr-4 align-middle sticky left-0 bg-white group-hover:bg-[#FCFAF8]/40 transition-colors z-10">
                                <div class="flex items-center gap-2">
                                    <div class="w-7 h-7 rounded-lg bg-gray-100 text-gray-500 flex items-center justify-center shrink-0">
                                        <i data-lucide="clock" class="w-4 h-4"></i>
                                    </div>
                                    <span class="text-xs font-bold text-gray-500">Jam Operasional</span>
                                </div>
                            </td>
                            <template x-for="cafe in selectedCafes" :key="cafe.id">
                                <td class="py-4 px-3 text-center align-middle text-xs font-bold text-[#2B1A09]" x-text="cafe.jam"></td>
                            </template>
                            <template x-if="selectedCafes.length < 3">
                                <td class="py-4 px-3"></td>
                            </template>
                        </tr>

                        <!-- Row 6: Formula Perhitungan -->
                        <tr class="hover:bg-[#FCFAF8]/40 transition-colors group">
                            <td class="py-4 pr-4 align-top pt-5 sticky left-0 bg-white group-hover:bg-[#FCFAF8]/40 transition-colors z-10">
                                <div class="flex items-center gap-2">
                                    <div class="w-7 h-7 rounded-lg bg-gray-100 text-gray-500 flex items-center justify-center shrink-0">
                                        <i data-lucide="cpu" class="w-4 h-4"></i>
                                    </div>
                                    <span class="text-xs font-bold text-gray-500">Formula SAW</span>
                                </div>
                            </td>
                            <template x-for="cafe in selectedCafes" :key="cafe.id">
                                <td class="py-4 px-3 align-middle">
                                    <div class="bg-[#FCFAF8] border border-gray-200/60 rounded-xl p-3 text-[10px] text-gray-500 font-mono break-all leading-relaxed shadow-inner max-w-[200px] mx-auto text-center" x-text="cafe.perhitungan"></div>
                                </td>
                            </template>
                            <template x-if="selectedCafes.length < 3">
                                <td class="py-4 px-3"></td>
                            </template>
                        </tr>

                    </tbody>
                </table>
            </div>

            <!-- Mobile View Card List (No Horizontal Collisions) -->
            <div class="mobile-only-cards space-y-4 max-h-[60vh] overflow-y-auto pr-1">
                <template x-for="cafe in selectedCafes" :key="cafe.id">
                    <div class="bg-[#FCFAF8] border border-gray-100 rounded-3xl p-5 shadow-sm relative group transition-all hover:border-[#B87C39]/20 text-left">
                        <!-- Header Info -->
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-7 h-7 rounded-full bg-[#B87C39] text-white text-xs font-black flex items-center justify-center shadow-sm" x-text="cafe.rank"></div>
                            <div class="min-w-0 flex-1">
                                <h4 class="font-bold text-xs text-[#2B1A09] truncate" x-text="cafe.nama"></h4>
                                <p class="text-[9px] text-gray-400 truncate font-light mt-0.5" x-text="cafe.alamat"></p>
                            </div>
                        </div>
                        
                        <!-- Parameters List -->
                        <div class="space-y-3 divide-y divide-gray-100/50">
                            <div class="flex justify-between items-center pt-2">
                                <span class="text-[9px] font-bold text-gray-400 uppercase tracking-wider">Skor SAW</span>
                                <span class="inline-flex items-center justify-center px-2.5 py-1 rounded-full bg-[#B87C39] text-white text-[10px] font-black" x-text="cafe.skor"></span>
                            </div>
                            <div class="flex justify-between items-center pt-2">
                                <span class="text-[9px] font-bold text-gray-400 uppercase tracking-wider">Harga Terendah</span>
                                <span class="text-[10px] font-bold text-[#2B1A09]" x-text="cafe.harga"></span>
                            </div>
                            <div class="flex justify-between items-center pt-2">
                                <span class="text-[9px] font-bold text-gray-400 uppercase tracking-wider">Jarak Lokasi</span>
                                <span class="text-[10px] font-bold text-[#2B1A09]" x-text="cafe.jarak + ' km'"></span>
                            </div>
                            <div class="flex justify-between items-center pt-2">
                                <span class="text-[9px] font-bold text-gray-400 uppercase tracking-wider">Rating</span>
                                <div class="inline-flex items-center gap-0.5 text-[10px] font-bold text-[#2B1A09]">
                                    <i data-lucide="star" class="w-3 h-3 text-amber-400 fill-amber-400"></i>
                                    <span x-text="cafe.rating"></span>
                                </div>
                            </div>
                            <div class="flex justify-between items-center pt-2">
                                <span class="text-[9px] font-bold text-gray-400 uppercase tracking-wider">Jam Operasional</span>
                                <span class="text-[10px] font-bold text-[#2B1A09]" x-text="cafe.jam"></span>
                            </div>
                            <div class="flex flex-col pt-3 gap-1.5 border-t border-gray-100">
                                <span class="text-[9px] font-bold text-gray-400 uppercase tracking-wider">Formula SAW</span>
                                <div class="bg-white border border-gray-200/60 rounded-xl p-2.5 text-[9px] text-gray-500 font-mono break-all leading-relaxed text-left" x-text="cafe.perhitungan"></div>
                            </div>
                        </div>
                    </div>
                </template>
            </div>

        </div>
        
        <!-- Modal Footer -->
        <div class="p-4 md:p-6 border-t border-gray-100 bg-[#FCFAF8] shrink-0 flex flex-col sm:flex-row items-center justify-between gap-4">
            <span class="text-[11px] text-gray-400 text-center sm:text-left">Metode Simple Additive Weighting (SAW)</span>
            <button @click="showModal = false" class="w-full sm:w-auto text-center justify-center bg-[#B87C39] hover:bg-[#a66c2e] text-white font-extrabold text-xs px-8 py-3.5 sm:py-3 rounded-xl transition-all shadow-md cursor-pointer">
                Selesai
            </button>
        </div>
    </div>
</div>
