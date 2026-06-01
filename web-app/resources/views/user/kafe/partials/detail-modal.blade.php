<div x-cloak 
     x-show="panelOpen" 
     class="fixed inset-0 z-[150] flex items-center justify-end">
    
    <div x-show="panelOpen" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="panelOpen = false" 
         class="absolute inset-0 bg-[#2B1A09]/45 backdrop-blur-sm">
    </div>

    <div x-show="panelOpen" 
         x-transition:enter="transition ease-out duration-300 transform"
         x-transition:enter-start="opacity-0 translate-x-full"
         x-transition:enter-end="opacity-100 translate-x-0"
         x-transition:leave="transition ease-in duration-200 transform"
         x-transition:leave-start="opacity-100 translate-x-0"
         x-transition:leave-end="opacity-0 translate-x-full"
         class="relative w-full max-w-lg bg-[#FAF8F5] h-full shadow-2xl flex flex-col justify-between overflow-y-auto custom-scrollbar p-6 sm:p-8 z-[151] border-l border-gray-100">
        
        <div class="flex items-center justify-between mb-6">
            <span class="px-3 py-1 bg-[#B87C39]/10 text-[#B87C39] text-[10px] font-bold rounded-xl uppercase tracking-wider" x-text="selectedCafe?.category || 'KAFe'"></span>
            <button @click="panelOpen = false" class="w-8 h-8 rounded-full hover:bg-gray-100 flex items-center justify-center text-gray-400 hover:text-gray-900 transition-colors focus:outline-none cursor-pointer">
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
                <h4 class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-3">Atribut & Spesifikasi (Usulan)</h4>
                <div class="bg-white border border-gray-100 rounded-2xl overflow-hidden shadow-sm divide-y divide-gray-50 text-xs">
                    <div class="flex items-center justify-between p-4 font-bold">
                        <span class="text-gray-400">Jarak Kampus</span>
                        <span class="text-[#2B1A09]" x-text="selectedCafe?.distance + ' km'"></span>
                    </div>
                    <div class="flex items-center justify-between p-4 font-bold">
                        <span class="text-gray-400">Rating Awal</span>
                        <span class="text-[#2B1A09]" x-text="selectedCafe?.rating"></span>
                    </div>
                    <div class="flex items-center justify-between p-4 font-bold">
                        <span class="text-gray-400">Harga Minimal</span>
                        <span class="text-[#2B1A09]" x-text="selectedCafe?.price_min"></span>
                    </div>
                    <div class="flex items-center justify-between p-4 font-bold">
                        <span class="text-gray-400">Harga Maksimal</span>
                        <span class="text-[#2B1A09]" x-text="selectedCafe?.price_max"></span>
                    </div>
                    <div class="flex items-center justify-between p-4 font-bold">
                        <span class="text-gray-400">Operasional</span>
                        <span class="text-[#2B1A09]" x-text="selectedCafe?.hours"></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="pt-6 border-t border-gray-100 flex justify-end">
            <button @click="panelOpen = false" class="px-6 py-3.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold rounded-xl text-xs transition-colors cursor-pointer text-center">
                Tutup Detail
            </button>
        </div>
    </div>
</div>
