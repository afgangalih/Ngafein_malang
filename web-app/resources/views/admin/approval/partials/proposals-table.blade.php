<div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-800 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 dark:bg-gray-850 border-b border-gray-100 dark:border-gray-800 text-[11px] font-bold text-gray-405 dark:text-gray-500 uppercase tracking-wider">
                    <th class="px-6 py-4 text-center w-16">No</th>
                    <th class="px-6 py-4">Kafe</th>
                    <th class="px-6 py-4">Pengusul</th>
                    <th class="px-6 py-4 text-center">Jarak</th>
                    <th class="px-6 py-4 text-center">Operasional</th>
                    <th class="px-6 py-4 text-center">Status</th>
                    <th class="px-6 py-4 text-center w-40">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-800 text-xs">
                <template x-for="(c, idx) in filteredProposals" :key="c.id">
                    <tr class="hover:bg-[#FAF8F5]/40 dark:hover:bg-gray-850/50 transition-colors">
                        <td class="px-6 py-4 text-center font-bold text-gray-400" x-text="idx + 1"></td>
                        <td class="px-6 py-4">
                            <div class="font-extrabold text-gray-900 dark:text-white text-sm" x-text="c.name"></div>
                            <div class="text-[11px] text-gray-400 mt-1 flex items-center gap-1">
                                <svg viewBox="0 0 24 24" class="w-3.5 h-3.5 text-[#B87C39] fill-none stroke-current" stroke-width="2"><path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"/><circle cx="12" cy="10" r="3"/></svg>
                                <span x-text="c.address"></span>
                            </div>
                            
                            <form :id="'form-approve-' + c.id" :action="'/admin/approval/' + c.id + '/approve'" method="POST" class="hidden">
                                @csrf
                            </form>
                            <form :id="'form-reject-' + c.id" :action="'/admin/approval/' + c.id + '/reject'" method="POST" class="hidden">
                                @csrf
                            </form>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-[#B87C39]/10 text-[#B87C39] flex items-center justify-center font-bold text-xs uppercase shrink-0 border border-[#B87C39]/20" x-text="c.user_name.slice(0, 2)"></div>
                                <div>
                                    <div class="font-bold text-gray-800 dark:text-gray-200 text-xs" x-text="c.user_name"></div>
                                    <div class="text-[10px] text-gray-400 mt-0.5" x-text="c.user_email"></div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center font-bold text-gray-600 dark:text-gray-300" x-text="c.distance + ' km'"></td>
                        <td class="px-6 py-4 text-center font-semibold text-gray-500 dark:text-gray-400" x-text="c.hours"></td>
                        <td class="px-6 py-4 text-center">
                            <template x-if="c.deleted">
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 font-bold rounded-lg border border-gray-200/50">Dihapus</span>
                            </template>
                            <template x-if="c.status === 'pending' && !c.deleted">
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-amber-50 dark:bg-amber-950/20 text-amber-700 dark:text-amber-500 font-bold rounded-lg border border-amber-200/50">Pending</span>
                            </template>
                            <template x-if="c.status === 'approved' && !c.deleted">
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-emerald-50 dark:bg-emerald-950/20 text-emerald-700 dark:text-emerald-500 font-bold rounded-lg border border-emerald-200/50">Disetujui</span>
                            </template>
                            <template x-if="c.status === 'rejected' && !c.deleted">
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-rose-50 dark:bg-rose-950/20 text-rose-700 dark:text-rose-500 font-bold rounded-lg border border-rose-200/50">Ditolak</span>
                            </template>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <button @click="openPanel('/admin/cafe/' + c.id, 'detail', c.id, c.status, c.deleted)"
                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-[#B87C39]/10 hover:bg-[#B87C39] text-[#B87C39] hover:text-white border border-[#B87C39]/20 rounded-lg font-bold text-[11px] transition-all cursor-pointer">
                                <svg viewBox="0 0 24 24" class="w-3.5 h-3.5 fill-none stroke-current" stroke-width="2.5"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7z"/><circle cx="12" cy="12" r="3"/></svg> Detail
                            </button>
                        </td>
                    </tr>
                </template>
                
                <tr x-show="filteredProposals.length === 0">
                    <td colspan="7" class="px-6 py-12 text-center text-gray-400 font-medium">
                        Tidak ada usulan kafe yang sesuai dengan kriteria filter pencarian.
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
