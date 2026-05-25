<div class="rounded-2xl overflow-hidden border border-[#D4B896]">
    <div class="overflow-x-auto">
        <table class="w-full text-left" style="border-collapse:collapse">

            {{-- HEADER --}}
            <thead>
                <tr>
                    <th class="text-center"
                        style="width:60px;background:#C9A876;color:#fff;font-size:13px;font-weight:700;padding:12px 16px;border:none">
                        No
                    </th>

                    <th style="background:#C9A876;color:#fff;font-size:13px;font-weight:700;padding:12px 16px;border:none">
                        Nama Kafe
                    </th>

                    <th class="text-center"
                        style="width:100px;background:#C9A876;color:#fff;font-size:13px;font-weight:700;padding:12px 16px;border:none">
                        Jarak
                    </th>

                    <th class="text-center"
                        style="width:170px;background:#C9A876;color:#fff;font-size:13px;font-weight:700;padding:12px 16px;border:none">
                        Operasional
                    </th>

                    <th class="text-center"
                        style="width:210px;background:#C9A876;color:#fff;font-size:13px;font-weight:700;padding:12px 16px;border:none">
                        Aksi
                    </th>
                </tr>
            </thead>

            {{-- BODY --}}
            <tbody>
                @forelse($cafes as $index => $cafe)

                    <tr
                        style="{{ $index % 2 === 0 ? 'background:#F5ECD7' : 'background:#EFE0C2' }};border-bottom:1px solid #D4B896;transition:background .15s"
                        onmouseenter="this.style.background='#DFC9A0'"
                        onmouseleave="this.style.background='{{ $index % 2 === 0 ? '#F5ECD7' : '#EFE0C2' }}'">

                        {{-- NO --}}
                        <td class="text-center"
                            style="padding:10px 16px;font-size:13px;font-weight:700;color:#7a6248;border-bottom:1px solid #D4B896">
                            {{ $cafes->firstItem() + $index }}
                        </td>

                        {{-- NAMA + ALAMAT --}}
                        <td
                            style="padding:10px 16px;border-bottom:1px solid #D4B896">
                            
                            <div class="text-[13px] font-bold text-[#3d2f1f]">
                                {{ $cafe->nama_kafe }}
                            </div>

                            <div class="text-[12px] font-medium text-[#7a6248] mt-0.5">
                                {{ $cafe->alamat }}
                            </div>
                        </td>

                        {{-- JARAK --}}
                        <td class="text-center"
                            style="padding:10px 16px;font-size:13px;font-weight:700;color:#5f4b32;border-bottom:1px solid #D4B896">
                            {{ $cafe->jarak }} km
                        </td>

                        {{-- OPERASIONAL --}}
                        <td class="text-center"
                            style="padding:10px 16px;font-size:13px;font-weight:700;color:#5f4b32;border-bottom:1px solid #D4B896">
                            {{ $cafe->jam_buka }} – {{ $cafe->jam_tutup }}
                        </td>

                        {{-- AKSI --}}
                        <td class="text-center"
                            style="padding:10px 16px;border-bottom:1px solid #D4B896">

                            <div class="flex justify-center items-center gap-2">

                                {{-- DETAIL --}}
                                <button
                                    @click="openPanel('{{ route('admin.cafe.show', $cafe->id_kafe) }}', 'detail')"
                                    class="flex items-center gap-1.5 px-3 py-1.5 bg-white text-sky-600 hover:bg-sky-500 hover:text-white rounded-lg text-[12px] font-bold transition-all border border-sky-200">
                                    <i data-lucide="eye" class="w-3.5 h-3.5"></i>
                                    Detail
                                </button>

                                {{-- EDIT --}}
                                <button
                                    @click="openPanel('{{ route('admin.cafe.edit', $cafe->id_kafe) }}', 'edit')"
                                    class="flex items-center gap-1.5 px-3 py-1.5 bg-white text-[#B87A3D] hover:bg-[#B87A3D] hover:text-white rounded-lg text-[12px] font-bold transition-all border border-[#B87A3D]">
                                    <i data-lucide="pencil" class="w-3.5 h-3.5"></i>
                                    Edit
                                </button>

                                {{-- DELETE --}}
                                <button
                                    @click="confirmDelete({{ $cafe->id_kafe }})"
                                    class="flex items-center gap-1.5 px-3 py-1.5 bg-red-50 text-red-500 hover:bg-red-500 hover:text-white rounded-lg text-[12px] font-bold transition-all border border-red-200">
                                    <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                    Hapus
                                </button>

                            </div>
                        </td>
                    </tr>

                @empty
                    <tr>
                        <td colspan="5"
                            style="padding:40px 16px;text-align:center;font-size:13px;font-weight:600;color:#9a8068">
                            Belum ada data kafe.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- SHOWING ENTRIES --}}
<p class="text-[13px] text-gray-500 mt-4 px-1">
    Menampilkan {{ $cafes->firstItem() ?? 0 }}
    - {{ $cafes->lastItem() ?? 0 }}
    dari {{ $cafes->total() }} data
</p>

{{-- PAGINATION --}}
@if ($cafes->hasPages())
<div class="mt-3 flex items-center gap-1">

    @if ($cafes->onFirstPage())
        <span style="padding:4px 10px;border-radius:8px;font-size:13px;font-weight:700;color:#c9b99a;cursor:not-allowed">
            ‹
        </span>
    @else
        <a href="{{ $cafes->previousPageUrl() }}"
           style="padding:4px 10px;border-radius:8px;font-size:13px;font-weight:700;color:#7a6248;transition:background .15s"
           onmouseenter="this.style.background='#E8D5B5'"
           onmouseleave="this.style.background='transparent'">
            ‹
        </a>
    @endif

    @foreach ($cafes->getUrlRange(1, $cafes->lastPage()) as $page => $url)

        @if ($page == $cafes->currentPage())
            <span style="padding:4px 10px;border-radius:8px;font-size:13px;font-weight:700;background:#B87C39;color:#fff">
                {{ $page }}
            </span>
        @else
            <a href="{{ $url }}"
               style="padding:4px 10px;border-radius:8px;font-size:13px;font-weight:700;color:#7a6248;transition:background .15s"
               onmouseenter="this.style.background='#E8D5B5'"
               onmouseleave="this.style.background='transparent'">
                {{ $page }}
            </a>
        @endif

    @endforeach

    @if ($cafes->hasMorePages())
        <a href="{{ $cafes->nextPageUrl() }}"
           style="padding:4px 10px;border-radius:8px;font-size:13px;font-weight:700;color:#7a6248;transition:background .15s"
           onmouseenter="this.style.background='#E8D5B5'"
           onmouseleave="this.style.background='transparent'">
            ›
        </a>
    @else
        <span style="padding:4px 10px;border-radius:8px;font-size:13px;font-weight:700;color:#c9b99a;cursor:not-allowed">
            ›
        </span>
    @endif

</div>
@endif