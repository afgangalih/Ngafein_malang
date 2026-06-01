<div x-cloak 
     x-show="selectedCafe !== null" 
     class="fixed inset-0 z-[110] flex items-center justify-end">
    
    <div x-show="selectedCafe !== null" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="selectedCafe = null" 
         class="absolute inset-0 bg-[#2B1A09]/45 backdrop-blur-sm">
    </div>

    <div x-show="selectedCafe !== null" 
         x-transition:enter="transition ease-out duration-300 transform"
         x-transition:enter-start="opacity-0 translate-x-full"
         x-transition:enter-end="opacity-100 translate-x-0"
         x-transition:leave="transition ease-in duration-200 transform"
         x-transition:leave-start="opacity-100 translate-x-0"
         x-transition:leave-end="opacity-0 translate-x-full"
         class="relative w-full max-w-lg bg-[#FAF8F5] h-full shadow-2xl flex flex-col justify-between overflow-y-auto custom-scrollbar p-6 sm:p-8 z-[111] border-l border-gray-100">
        
        <div class="flex items-center justify-between mb-6">
            <span class="px-3 py-1 bg-[#B87C39]/10 text-[#B87C39] text-[10px] font-bold rounded-xl uppercase tracking-wider" x-text="selectedCafe?.category"></span>
            <button @click="selectedCafe = null" class="w-8 h-8 rounded-full hover:bg-gray-100 flex items-center justify-center text-gray-400 hover:text-gray-900 transition-colors focus:outline-none cursor-pointer">
                <svg viewBox="0 0 24 24" class="w-4 h-4 fill-none stroke-current" stroke-width="2.5"><line x1="18" x2="6" y1="6" y2="18"/><line x1="6" x2="18" y1="6" y2="18"/></svg>
            </button>
        </div>

        <div class="flex-grow space-y-6">
            <div class="aspect-video w-full rounded-3xl overflow-hidden bg-gray-100 shadow-sm border border-gray-200/20">
                <img :src="selectedCafe?.image" :alt="selectedCafe?.name" class="w-full h-full object-cover">
            </div>

            <div>
                <h2 class="text-2xl sm:text-3xl font-bold font-serif text-[#2B1A09] leading-tight mb-2" x-text="selectedCafe?.name"></h2>
                <div class="flex items-center gap-2 text-gray-500 text-xs">
                    <svg viewBox="0 0 24 24" class="w-3.5 h-3.5 text-[#B87C39] fill-none stroke-current" stroke-width="2"><path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"/><circle cx="12" cy="10" r="3"/></svg>
                    <span x-text="selectedCafe?.location"></span>
                </div>
            </div>

            <div>
                <p class="text-xs sm:text-sm text-gray-500 leading-relaxed font-light" x-text="selectedCafe?.description"></p>
            </div>

            <div>
                <h4 class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-3">Atribut & Spesifikasi (Kriteria SAW)</h4>
                <div class="bg-white border border-gray-100 rounded-2xl overflow-hidden shadow-sm divide-y divide-gray-50">
                    <div class="flex items-center justify-between p-4 text-xs font-bold">
                        <span class="text-gray-400">Atribut Harga (Cost)</span>
                        <span class="text-[#2B1A09]" x-text="selectedCafe?.priceLabel"></span>
                    </div>
                    <div class="flex items-center justify-between p-4 text-xs font-bold">
                        <span class="text-gray-400">Atribut Rating (Benefit)</span>
                        <span class="text-[#2B1A09] flex items-center gap-1">
                            <svg viewBox="0 0 24 24" fill="currentColor" class="w-3 h-3 text-amber-500"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                            <span x-text="selectedCafe?.rating"></span> (<span x-text="selectedCafe?.reviewCount"></span> reviews)
                        </span>
                    </div>
                    <div class="flex items-center justify-between p-4 text-xs font-bold">
                        <span class="text-gray-400">Kualitas Internet</span>
                        <span class="text-[#2B1A09]" x-text="selectedCafe?.amenities.internet"></span>
                    </div>
                    <div class="flex items-center justify-between p-4 text-xs font-bold">
                        <span class="text-gray-400">Kondisi Colokan</span>
                        <span class="text-[#2B1A09]" x-text="selectedCafe?.amenities.outlets"></span>
                    </div>
                    <div class="flex items-center justify-between p-4 text-xs font-bold">
                        <span class="text-gray-400">Tingkat Kenyamanan</span>
                        <span class="text-[#2B1A09]" x-text="selectedCafe?.amenities.comfort"></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="pt-6 border-t border-gray-100 flex items-center gap-3">
            <button @click.prevent="toggleBookmark(selectedCafe); selectedCafe = null" 
                    class="flex-grow bg-[#B87C39] hover:bg-[#a66c2e] text-white font-bold py-3.5 rounded-xl text-xs tracking-wider transition-all shadow-md shadow-[#B87C39]/10 cursor-pointer text-center">
                Simpan Ke Favorit
            </button>
            <button @click.prevent="toggleBlacklist(selectedCafe); selectedCafe = null" 
                    class="px-4 py-3.5 bg-red-50 text-red-600 hover:bg-red-100 font-bold rounded-xl text-xs transition-colors cursor-pointer text-center">
                Exclude Kafe
            </button>
        </div>
    </div>
</div>
