<div class="flex flex-col md:flex-row md:items-center justify-between gap-6 border-b border-gray-200/60 pb-5 mb-10">
    <div class="flex items-center gap-8">
        <button @click="activeTab = 'favorites'" 
                :class="activeTab === 'favorites' ? 'border-[#B87C39] text-[#B87C39] font-extrabold' : 'border-transparent text-gray-400 hover:text-gray-700'" 
                class="pb-4 border-b-2 font-bold text-xs tracking-wider uppercase transition-all duration-300 cursor-pointer flex items-center gap-2 focus:outline-none">
            <span>Favorit Saya</span>
            <span class="px-2 py-0.5 text-[10px] font-bold rounded-md" 
                  :class="activeTab === 'favorites' ? 'bg-[#B87C39]/10 text-[#B87C39]' : 'bg-gray-100 text-gray-400'" 
                  x-text="cafes.filter(c => c.bookmarked && !c.blacklisted).length"></span>
        </button>
        <button @click="activeTab = 'blacklist'" 
                :class="activeTab === 'blacklist' ? 'border-red-500 text-red-600 font-extrabold' : 'border-transparent text-gray-400 hover:text-red-500'" 
                class="pb-4 border-b-2 font-bold text-xs tracking-wider uppercase transition-all duration-300 cursor-pointer flex items-center gap-2 focus:outline-none">
            <span>Blacklist</span>
            <span class="px-2 py-0.5 text-[10px] font-bold rounded-md" 
                  :class="activeTab === 'blacklist' ? 'bg-red-500/10 text-red-600' : 'bg-gray-100 text-gray-400'" 
                  x-text="cafes.filter(c => c.blacklisted).length"></span>
        </button>
    </div>

    <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 max-w-xl w-full md:w-auto">
        <div class="relative flex-grow sm:w-64">
            <span class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-gray-400">
                <svg viewBox="0 0 24 24" class="w-4 h-4 fill-none stroke-current" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
            </span>
            <input type="text" 
                   x-model="searchQuery" 
                   placeholder="Cari kafe..." 
                   class="w-full bg-white border border-gray-200/85 rounded-2xl pl-11 pr-4 py-2.5 text-xs font-semibold text-gray-700 placeholder-gray-400/80 outline-none focus:border-[#B87C39] transition-all shadow-sm">
        </div>

        <div class="relative sm:w-44">
            <select x-model="sortBy" 
                    class="w-full bg-white border border-gray-200/85 rounded-2xl px-4 py-2.5 text-xs font-bold text-gray-700 outline-none cursor-pointer focus:border-[#B87C39] transition-all appearance-none shadow-sm">
                <option value="default">Urutkan: Standar</option>
                <option value="rating">Rating Tertinggi</option>
                <option value="price-low">Harga: Murah - Mahal</option>
                <option value="price-high">Harga: Mahal - Murah</option>
            </select>
            <span class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-gray-400">
                <svg viewBox="0 0 24 24" class="w-3.5 h-3.5 fill-none stroke-current" stroke-width="2.5"><path d="m6 9 6 6 6-6"/></svg>
            </span>
        </div>
    </div>
</div>
