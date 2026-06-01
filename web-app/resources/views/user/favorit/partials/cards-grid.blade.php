<div class="relative min-h-[400px]">
    <div x-show="filteredCafes.length === 0" 
         class="flex flex-col items-center justify-center py-20 text-center bg-white border border-[#B87C39]/20 rounded-[2.5rem] p-8 shadow-sm">
        <div class="w-14 h-14 rounded-2xl bg-[#B87C39]/10 text-[#B87C39] border border-[#B87C39]/20 flex items-center justify-center mb-5">
            <svg viewBox="0 0 24 24" class="w-5 h-5 fill-none stroke-current" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg>
        </div>
        <h3 class="text-base font-bold text-gray-900 mb-1">Tidak Ada Kafe Ditemukan</h3>
        <p class="text-xs text-gray-500 max-w-xs leading-relaxed">
            Coba gunakan kata kunci pencarian yang lain atau periksa tab filter aktif Anda.
        </p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6" 
         x-show="filteredCafes.length > 0"
         x-transition:enter="transition ease-out duration-300 transform"
         x-transition:enter-start="opacity-0 translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200 transform"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 translate-y-4">
        
        <template x-for="cafe in filteredCafes" :key="cafe.id">
            <div @click="selectedCafe = cafe" 
                 class="group relative block aspect-[4/5] rounded-[2rem] overflow-hidden shadow-xl hover:shadow-[#B87C39]/20 transition-all duration-500 bg-gray-900 cursor-pointer transform hover:-translate-y-1">
                
                <img :src="cafe.image" :alt="cafe.name" class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition-transform duration-1000">
                
                <div class="absolute inset-0 bg-gradient-to-t from-black/95 via-black/30 to-transparent opacity-85 group-hover:opacity-70 transition-opacity duration-500"></div>

                <div class="absolute top-5 left-5 z-20">
                    <div class="bg-black/40 backdrop-blur-md border border-white/20 text-white px-3 py-1.5 rounded-xl flex items-center gap-2">
                        <svg viewBox="0 0 24 24" class="w-3 h-3 text-[#B87C39] fill-none stroke-current" stroke-width="2"><path d="M10 2v2M14 2v2M16 8a1 1 0 0 1 1 1v8a4 4 0 0 1-4 4H7a4 4 0 0 1-4-4V9a1 1 0 0 1 1-1h14a4 4 0 1 1 0 8h-1M6 2v2"/></svg>
                        <span class="text-[9px] font-bold uppercase tracking-widest" x-text="cafe.category"></span>
                    </div>
                </div>

                <div class="absolute top-5 right-5 z-20 flex items-center gap-1.5" @click.stop="">
                    <button @click.prevent="toggleBookmark(cafe)" 
                            class="w-10 h-10 rounded-xl flex items-center justify-center transition-all duration-300 group cursor-pointer focus:outline-none"
                            :class="cafe.bookmarked ? 'bg-white/95 border-[#B87C39] text-[#B87C39] shadow-md scale-105' : 'bg-black/40 backdrop-blur-md border border-white/20 text-white hover:bg-white/20'"
                            title="Simpan ke Favorit">
                        <svg viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"
                             :fill="cafe.bookmarked ? 'currentColor' : 'none'" class="w-4.5 h-4.5 transition-transform duration-300 text-current">
                            <path d="m19 21-7-4-7 4V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v16z"/>
                        </svg>
                    </button>

                    <button @click.prevent="toggleBlacklist(cafe)" 
                            class="w-10 h-10 rounded-xl flex items-center justify-center transition-all duration-300 group cursor-pointer focus:outline-none"
                            :class="cafe.blacklisted ? 'bg-red-500 border-red-500 text-white shadow-lg scale-105' : 'bg-black/40 backdrop-blur-md border border-white/20 text-white hover:border-red-500 hover:bg-red-500/20'"
                            title="Kecualikan dari Rekomendasi (Blacklist)">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4.5 h-4.5 transition-transform duration-300 text-current">
                            <circle cx="12" cy="12" r="10"/>
                            <line x1="4.93" y1="4.93" x2="19.07" y2="19.07"/>
                        </svg>
                    </button>
                </div>

                <div class="absolute bottom-6 left-6 right-6">
                    <div class="mb-3">
                        <h3 class="text-xl font-black text-white leading-tight mb-1 tracking-tight" x-text="cafe.name"></h3>
                        <div class="flex items-center gap-2 text-white/70 text-[10px] font-medium">
                            <svg viewBox="0 0 24 24" class="w-3 h-3 text-[#B87C39] fill-none stroke-current" stroke-width="2"><path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"/><circle cx="12" cy="10" r="3"/></svg>
                            <span x-text="cafe.location"></span>
                        </div>
                    </div>

                    <div class="flex items-center justify-between pt-3 border-t border-white/10">
                        <div class="flex flex-col">
                            <div class="flex items-center gap-1 mb-0.5">
                                <span class="text-base font-black text-white" x-text="cafe.rating"></span>
                                <div class="flex gap-0.5">
                                    <svg viewBox="0 0 24 24" fill="currentColor" class="w-2.5 h-2.5 text-amber-400"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                                </div>
                            </div>
                            <span class="text-[8px] font-bold text-white/40 uppercase tracking-widest" x-text="cafe.ratingLabel"></span>
                        </div>
                        <div class="text-right">
                            <span class="block text-base font-black text-white" x-text="cafe.priceLabel"></span>
                            <span class="text-[8px] font-bold text-white/40 uppercase tracking-widest">Start from</span>
                        </div>
                    </div>
                </div>

            </div>
        </template>
    </div>
</div>
