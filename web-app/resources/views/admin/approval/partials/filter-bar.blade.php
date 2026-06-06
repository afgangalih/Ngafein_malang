<div class="flex flex-col md:flex-row items-center justify-between gap-4 mb-5">
    <div class="relative">
        <svg viewBox="0 0 24 24" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-[#b0957a] fill-none stroke-current" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
        <input type="text" 
               x-model="searchQuery" 
               placeholder="Cari kafe atau pengusul..." 
               class="pl-9 pr-4 py-2 rounded-xl border border-[#D4B896] bg-white text-[13px] font-medium text-[#3d2f1f] placeholder-[#b0957a] outline-none focus:border-[#B87A3D] focus:ring-2 focus:ring-[#B87A3D]/20 transition-all w-56">
    </div>

    <div class="flex items-center gap-1 p-1 bg-white border border-[#D4B896] rounded-xl w-full md:w-auto overflow-x-auto whitespace-nowrap">
        <button @click="activeTab = 'all'" :class="activeTab === 'all' ? 'bg-[#B87C39] text-white' : 'text-[#5a4a35] hover:text-[#B87C39] bg-transparent'" class="px-3 py-1.5 rounded-xl font-extrabold text-xs cursor-pointer transition-all duration-200">Semua</button>
        <button @click="activeTab = 'pending'" :class="activeTab === 'pending' ? 'bg-amber-500 text-white' : 'text-[#5a4a35] hover:text-amber-600 bg-transparent'" class="px-3 py-1.5 rounded-xl font-extrabold text-xs cursor-pointer transition-all duration-200">Pending</button>
        <button @click="activeTab = 'approved'" :class="activeTab === 'approved' ? 'bg-emerald-500 text-white' : 'text-[#5a4a35] hover:text-emerald-600 bg-transparent'" class="px-3 py-1.5 rounded-xl font-extrabold text-xs cursor-pointer transition-all duration-200">Disetujui</button>
        <button @click="activeTab = 'rejected'" :class="activeTab === 'rejected' ? 'bg-rose-500 text-white' : 'text-[#5a4a35] hover:text-rose-600 bg-transparent'" class="px-3 py-1.5 rounded-xl font-extrabold text-xs cursor-pointer transition-all duration-200">Ditolak</button>
        <button @click="activeTab = 'deleted'" :class="activeTab === 'deleted' ? 'bg-gray-500 text-white' : 'text-[#5a4a35] hover:text-gray-700 bg-transparent'" class="px-3 py-1.5 rounded-xl font-extrabold text-xs cursor-pointer transition-all duration-200">Dihapus</button>
    </div>
</div>
