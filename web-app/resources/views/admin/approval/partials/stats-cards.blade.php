<div class="grid grid-cols-2 lg:grid-cols-5 gap-4">
    <div class="bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-2xl p-5 shadow-sm">
        <div class="text-[10px] font-black uppercase text-gray-400 tracking-wider">Total Usulan</div>
        <div class="text-2xl font-extrabold text-gray-900 dark:text-white mt-1">{{ $totalCount }}</div>
    </div>
    <div class="bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-2xl p-5 shadow-sm border-l-4 border-l-amber-500">
        <div class="text-[10px] font-black uppercase text-amber-600 tracking-wider">Pending</div>
        <div class="text-2xl font-extrabold text-amber-600 mt-1">{{ $pendingCount }}</div>
    </div>
    <div class="bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-2xl p-5 shadow-sm border-l-4 border-l-emerald-500">
        <div class="text-[10px] font-black uppercase text-emerald-600 tracking-wider">Disetujui</div>
        <div class="text-2xl font-extrabold text-emerald-600 mt-1">{{ $approvedCount }}</div>
    </div>
    <div class="bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-2xl p-5 shadow-sm border-l-4 border-l-rose-500">
        <div class="text-[10px] font-black uppercase text-rose-600 tracking-wider">Ditolak</div>
        <div class="text-2xl font-extrabold text-rose-600 mt-1">{{ $rejectedCount }}</div>
    </div>
    <div class="bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-2xl p-5 shadow-sm border-l-4 border-l-gray-400">
        <div class="text-[10px] font-black uppercase text-gray-500 tracking-wider">Dihapus Admin</div>
        <div class="text-2xl font-extrabold text-gray-600 mt-1">{{ $deletedCount }}</div>
    </div>
</div>
