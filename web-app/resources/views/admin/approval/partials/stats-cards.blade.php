<div class="grid grid-cols-2 lg:grid-cols-5 gap-4">
    <!-- Card 1: Total -->
    <div class="bg-white border border-[#D4B896] rounded-2xl p-4 shadow-sm hover:shadow-md hover:border-[#C9A876] transition-all duration-300 flex items-center justify-between gap-3 group">
        <div>
            <div class="text-[10px] font-bold uppercase text-[#7a6248] tracking-wider">Total Usulan</div>
            <div class="text-2xl font-black text-[#2B1A09] mt-0.5">{{ $totalCount }}</div>
        </div>
        <div class="w-10 h-10 rounded-xl bg-[#C9A876]/10 text-[#C9A876] flex items-center justify-center shrink-0 border border-[#C9A876]/20">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg>
        </div>
    </div>
    <!-- Card 2: Pending -->
    <div class="bg-white border border-[#D4B896] rounded-2xl p-4 shadow-sm hover:shadow-md hover:border-[#C9A876] transition-all duration-300 flex items-center justify-between gap-3 group">
        <div>
            <div class="text-[10px] font-bold uppercase text-[#7a6248] tracking-wider">Pending</div>
            <div class="text-2xl font-black text-amber-700 mt-0.5">{{ $pendingCount }}</div>
        </div>
        <div class="w-10 h-10 rounded-xl bg-amber-500/10 text-amber-700 flex items-center justify-center shrink-0 border border-amber-500/20">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
        </div>
    </div>
    <!-- Card 3: Approved -->
    <div class="bg-white border border-[#D4B896] rounded-2xl p-4 shadow-sm hover:shadow-md hover:border-[#C9A876] transition-all duration-300 flex items-center justify-between gap-3 group">
        <div>
            <div class="text-[10px] font-bold uppercase text-[#7a6248] tracking-wider">Disetujui</div>
            <div class="text-2xl font-black text-emerald-700 mt-0.5">{{ $approvedCount }}</div>
        </div>
        <div class="w-10 h-10 rounded-xl bg-emerald-500/10 text-emerald-700 flex items-center justify-center shrink-0 border border-emerald-500/20">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
        </div>
    </div>
    <!-- Card 4: Rejected -->
    <div class="bg-white border border-[#D4B896] rounded-2xl p-4 shadow-sm hover:shadow-md hover:border-[#C9A876] transition-all duration-300 flex items-center justify-between gap-3 group">
        <div>
            <div class="text-[10px] font-bold uppercase text-[#7a6248] tracking-wider">Ditolak</div>
            <div class="text-2xl font-black text-rose-700 mt-0.5">{{ $rejectedCount }}</div>
        </div>
        <div class="w-10 h-10 rounded-xl bg-rose-500/10 text-rose-700 flex items-center justify-center shrink-0 border border-rose-500/20">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
        </div>
    </div>
    <!-- Card 5: Deleted -->
    <div class="bg-white border border-[#D4B896] rounded-2xl p-4 shadow-sm hover:shadow-md hover:border-[#C9A876] transition-all duration-300 flex items-center justify-between gap-3 group">
        <div>
            <div class="text-[10px] font-bold uppercase text-[#7a6248] tracking-wider">Dihapus</div>
            <div class="text-2xl font-black text-gray-700 mt-0.5">{{ $deletedCount }}</div>
        </div>
        <div class="w-10 h-10 rounded-xl bg-gray-500/10 text-gray-700 flex items-center justify-center shrink-0 border border-gray-500/20">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
        </div>
    </div>
</div>
