        <div class="rounded-2xl overflow-hidden border border-[#D4B896]">
            <div class="overflow-x-auto">
                <table class="w-full min-w-[750px] text-left" style="border-collapse:collapse;table-layout:fixed">
                    <thead>
                        <tr>
                            <th class="text-center" style="width:70px;background:#C9A876;color:#fff;font-size:13px;font-weight:700;padding:14px 16px;border:none">No</th>
                            <th style="background:#C9A876;color:#fff;font-size:13px;font-weight:700;padding:14px 16px;border:none">Nama</th>
                            <th style="background:#C9A876;color:#fff;font-size:13px;font-weight:700;padding:14px 16px;border:none">Email</th>
                            <th class="text-center" style="width:220px;background:#C9A876;color:#fff;font-size:13px;font-weight:700;padding:14px 16px;border:none">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $index => $item)
                            <tr style="
                                    border-bottom:1px solid #D4B896;
                                    transition:background .15s;
                                    background: {{ $index % 2 == 0 ? '#F5ECD7' : '#EFE0C2' }}
                                "
                                onmouseover="this.style.background='#DFC9A0'"
                                onmouseout="this.style.background='{{ $index % 2 == 0 ? '#F5ECD7' : '#EFE0C2' }}'">
                                <td class="text-center" style="padding:12px 16px;font-size:13px;font-weight:700;color:#7a6248;border-bottom:1px solid #D4B896">
                                    {{ $users->firstItem() + $index }}
                                </td>
                                <td style="padding:12px 16px;font-size:13px;font-weight:700;color:#3d2f1f;border-bottom:1px solid #D4B896">
                                    {{ $item->name }}
                                </td>
                                <td style="padding:12px 16px;font-size:13px;font-weight:600;color:#5a4a35;border-bottom:1px solid #D4B896">
                                    {{ $item->email }}
                                </td>
                                <td class="py-4 px-6 text-center border-b border-[#D4B896]">
                                    <div class="flex justify-center items-center gap-3">
                                        <button type="button" @click="openEdit({ id: {{ $item->id }}, name: @js($item->name), email: @js($item->email) })" 
                                            class="flex items-center gap-1.5 px-3 py-1.5 bg-white text-[#B87C39] hover:bg-[#B87C39] hover:text-white rounded-xl text-xs font-bold transition-all border border-[#B87C39] cursor-pointer">
                                            <i data-lucide="pencil" class="w-3.5 h-3.5"></i>
                                            <span>Edit</span>
                                        </button>
                                        @if(auth()->id() != $item->id)
                                        <button type="button" @click="confirmDelete({{ $item->id }}, @js($item->name))" 
                                            class="flex items-center gap-1.5 px-3 py-1.5 bg-red-50 text-red-500 hover:bg-red-500 hover:text-white rounded-xl text-xs font-bold transition-all border border-red-200 cursor-pointer">
                                            <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                            <span>Hapus</span>
                                        </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-10 text-sm font-semibold text-[#9a8068] bg-[#F5ECD7]">Belum ada data admin.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-5 flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
            <p class="text-[13px] text-gray-500 px-1">
                Menampilkan {{ $users->firstItem() ?? 0 }} - {{ $users->lastItem() ?? 0 }} dari {{ $users->total() }} data
            </p>
            <div class="flex items-center gap-1">
                @if ($users->onFirstPage())
                    <span class="px-3 py-1.5 rounded-lg text-sm font-bold text-gray-300 cursor-not-allowed">&lsaquo;</span>
                @else
                    <a href="{{ $users->previousPageUrl() }}" class="px-3 py-1.5 rounded-lg text-sm font-bold text-[#B87C39] hover:bg-[#B87C39]/10 transition">&lsaquo;</a>
                @endif

                @php
                    $last = $users->lastPage();
                    $current = $users->currentPage();
                @endphp

                @if ($last > 0)
                    @for ($i = 1; $i <= min(5, $last); $i++)
                        @if ($i == $current)
                            <span class="px-3 py-1.5 rounded-lg text-sm font-bold bg-[#B87C39] text-white">{{ $i }}</span>
                        @else
                            <a href="{{ $users->url($i) }}" class="px-3 py-1.5 rounded-lg text-sm font-bold text-gray-600 hover:bg-[#B87C39]/10 hover:text-[#B87C39] transition">{{ $i }}</a>
                        @endif
                    @endfor

                    @if ($last > 5)
                        <span class="px-2 text-gray-400 text-sm">...</span>
                        <a href="{{ $users->url($last) }}" class="px-3 py-1.5 rounded-lg text-sm font-bold text-gray-600 hover:bg-[#B87C39]/10 hover:text-[#B87C39] transition">{{ $last }}</a>
                    @endif
                @endif

                @if ($users->hasMorePages())
                    <a href="{{ $users->nextPageUrl() }}" class="px-3 py-1.5 rounded-lg text-sm font-bold text-[#B87C39] hover:bg-[#B87C39]/10 transition">&rsaquo;</a>
                @else
                    <span class="px-3 py-1.5 rounded-lg text-sm font-bold text-gray-300 cursor-not-allowed">&rsaquo;</span>
                @endif
            </div>
        </div>
