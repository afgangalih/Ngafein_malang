<div class="bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-2xl p-4 flex flex-col md:flex-row items-center justify-between gap-4 shadow-sm">
    <div class="relative w-full md:max-w-xs">
        <svg viewBox="0 0 24 24" class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 fill-none stroke-current" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
        <input type="text" 
               x-model="searchQuery" 
               placeholder="Cari kafe atau pengusul..." 
               class="w-full pl-10 pr-4 py-2 bg-gray-50 dark:bg-gray-850 border border-gray-200 dark:border-gray-750 focus:border-[#B87C39] focus:bg-white rounded-xl text-xs font-semibold outline-none transition-all placeholder:text-gray-400">
    </div>

    <div class="flex items-center gap-1 p-1 bg-gray-50 dark:bg-gray-850 border border-gray-100 dark:border-gray-800 rounded-xl w-full md:w-auto overflow-x-auto whitespace-nowrap">
        <button @click="activeTab = 'all'" :class="activeTab === 'all' ? 'bg-[#B87C39] text-white' : 'text-gray-500 hover:text-gray-800'" class="px-3.5 py-1.5 rounded-lg font-bold text-xs cursor-pointer">Semua</button>
        <button @click="activeTab = 'pending'" :class="activeTab === 'pending' ? 'bg-amber-500 text-white' : 'text-gray-500 hover:text-amber-600'" class="px-3.5 py-1.5 rounded-lg font-bold text-xs cursor-pointer">Pending</button>
        <button @click="activeTab = 'approved'" :class="activeTab === 'approved' ? 'bg-emerald-500 text-white' : 'text-gray-500 hover:text-emerald-600'" class="px-3.5 py-1.5 rounded-lg font-bold text-xs cursor-pointer">Disetujui</button>
        <button @click="activeTab = 'rejected'" :class="activeTab === 'rejected' ? 'bg-rose-500 text-white' : 'text-gray-500 hover:text-rose-600'" class="px-3.5 py-1.5 rounded-lg font-bold text-xs cursor-pointer">Ditolak</button>
        <button @click="activeTab = 'deleted'" :class="activeTab === 'deleted' ? 'bg-gray-500 text-white' : 'text-gray-500 hover:text-gray-700'" class="px-3.5 py-1.5 rounded-lg font-bold text-xs cursor-pointer">Dihapus</button>
    </div>
</div>
