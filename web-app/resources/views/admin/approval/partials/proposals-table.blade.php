<div class="rounded-2xl overflow-hidden border border-[#D4B896]">
    <div class="overflow-x-auto">
        <table class="w-full min-w-[750px] text-left border-collapse" style="table-layout:fixed">
            <thead>
                <tr>
                    <th class="text-center" style="width:70px;background:#C9A876;color:#fff;font-size:13px;font-weight:700;padding:14px 16px;border:none">No</th>
                    <th style="background:#C9A876;color:#fff;font-size:13px;font-weight:700;padding:14px 16px;border:none">Kafe</th>
                    <th style="background:#C9A876;color:#fff;font-size:13px;font-weight:700;padding:14px 16px;border:none">Pengusul</th>
                    <th class="text-center" style="width:100px;background:#C9A876;color:#fff;font-size:13px;font-weight:700;padding:14px 16px;border:none">Jarak</th>
                    <th class="text-center" style="width:130px;background:#C9A876;color:#fff;font-size:13px;font-weight:700;padding:14px 16px;border:none">Operasional</th>
                    <th class="text-center" style="width:120px;background:#C9A876;color:#fff;font-size:13px;font-weight:700;padding:14px 16px;border:none">Status</th>
                    <th class="text-center" style="width:130px;background:#C9A876;color:#fff;font-size:13px;font-weight:700;padding:14px 16px;border:none">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <template x-for="(c, idx) in filteredProposals" :key="c.id">
                    <tr style="border-bottom:1px solid #D4B896;transition:background .15s"
                        :style="idx % 2 === 0 ? 'background:#F5ECD7' : 'background:#EFE0C2'"
                        onmouseover="this.style.background='#DFC9A0'"
                        :onmouseout="'this.style.background=' + (idx % 2 === 0 ? '\'#F5ECD7\'' : '\'#EFE0C2\'')">
                        
                        <td class="text-center font-bold text-[#7a6248]" style="padding:12px 16px;font-size:13px" x-text="idx + 1"></td>
                        <td style="padding:12px 16px;border-bottom:1px solid #D4B896">
                            <div class="font-extrabold text-[#3d2f1f] text-sm" x-text="c.name"></div>
                            <div class="text-[11px] text-[#5a4a35]/70 mt-1 flex items-center gap-1">
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
                        <td style="padding:12px 16px;border-bottom:1px solid #D4B896">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-[#B87C39]/10 text-[#B87C39] flex items-center justify-center font-bold text-xs uppercase shrink-0 border border-[#B87C39]/20" x-text="c.user_name.slice(0, 2)"></div>
                                <div>
                                    <div class="font-bold text-[#3d2f1f] text-xs" x-text="c.user_name"></div>
                                    <div class="text-[10px] text-gray-500" x-text="c.user_email"></div>
                                </div>
                            </div>
                        </td>
                        <td class="text-center font-bold text-[#3d2f1f]" style="padding:12px 16px" x-text="c.distance + ' km'"></td>
                        <td class="text-center font-semibold text-[#5a4a35]" style="padding:12px 16px" x-text="c.hours"></td>
                        <td class="text-center" style="padding:12px 16px">
                            <template x-if="c.deleted">
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-gray-100/80 text-gray-600 font-bold rounded-lg border border-gray-200">Dihapus</span>
                            </template>
                            <template x-if="c.status === 'pending' && !c.deleted">
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-amber-50 text-amber-700 font-bold rounded-lg border border-amber-200/50">Pending</span>
                            </template>
                            <template x-if="c.status === 'approved' && !c.deleted">
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-emerald-50 text-emerald-700 font-bold rounded-lg border border-emerald-200/50">Disetujui</span>
                            </template>
                            <template x-if="c.status === 'rejected' && !c.deleted">
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-rose-50 text-rose-700 font-bold rounded-lg border border-rose-200/50">Ditolak</span>
                            </template>
                        </td>
                        <td class="text-center" style="padding:12px 16px">
                            <div class="flex justify-center items-center">
                                <button @click="openPanel('/admin/cafe/' + c.id, 'detail', c.id, c.status, c.deleted)"
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white text-[#B87C39] hover:bg-[#B87C39] hover:text-white rounded-xl text-xs font-bold transition-all border border-[#B87C39] cursor-pointer">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                                    <span>Detail</span>
                                </button>
                            </div>
                        </td>
                    </tr>
                </template>
                
                <tr x-show="filteredProposals.length === 0">
                    <td colspan="7" class="text-center py-12 text-[#9a8068] bg-[#F5ECD7] font-semibold">
                        Tidak ada usulan kafe yang sesuai dengan kriteria filter pencarian.
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
