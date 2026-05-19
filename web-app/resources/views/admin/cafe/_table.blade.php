<div class="overflow-hidden rounded-lg border border-gray-200">
    <div class="overflow-x-auto">
        <table class="w-full min-w-[700px] text-left">
            <thead class="bg-[#6E4A22] text-white">
                <tr>
                    <th class="w-16 px-5 py-3 text-center text-xs font-bold uppercase tracking-wide">No</th>
                    <th class="px-5 py-3 text-xs font-bold uppercase tracking-wide">Nama Kafe</th>
                    <th class="w-24 px-5 py-3 text-center text-xs font-bold uppercase tracking-wide">Jarak</th>
                    <th class="w-44 px-5 py-3 text-center text-xs font-bold uppercase tracking-wide">Operasional</th>
                    <th class="w-44 px-5 py-3 text-center text-xs font-bold uppercase tracking-wide">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 bg-white">
                @forelse($cafes as $index => $cafe)
                <tr class="transition hover:bg-[#B87C39]/5">
                    <td class="px-5 py-4 text-center text-sm font-bold text-gray-500">
                        {{ $cafes->firstItem() + $index }}
                    </td>
                    <td class="px-5 py-4">
                        <div class="text-sm font-bold text-gray-900 truncate">{{ $cafe->nama_kafe }}</div>
                        <div class="text-xs font-medium text-gray-400 truncate mt-0.5">{{ $cafe->alamat }}</div>
                    </td>
                    <td class="px-5 py-4 text-center text-sm font-semibold text-gray-700">
                        {{ $cafe->jarak }} km
                    </td>
                    <td class="px-5 py-4 text-center text-sm font-semibold text-gray-700">
                        {{ $cafe->jam_buka }} – {{ $cafe->jam_tutup }}
                    </td>
                    <td class="px-5 py-4">
                        <div class="flex items-center justify-center gap-2">
                            <button
                                @click="openPanel('{{ route('admin.cafe.show', $cafe->id_kafe) }}', 'detail')"
                                class="inline-flex items-center gap-1.5 rounded-lg border border-gray-200 bg-white px-3 py-2 text-xs font-bold text-gray-600 transition hover:border-[#B87C39] hover:bg-[#B87C39]/5 hover:text-[#6E4A22]"
                                title="Lihat Detail">
                                <i data-lucide="eye" class="w-3.5 h-3.5"></i>
                                Detail
                            </button>
                            <button
                                @click="openPanel('{{ route('admin.cafe.edit', $cafe->id_kafe) }}', 'edit')"
                                class="inline-flex items-center gap-1.5 rounded-lg border border-[#B87C39]/30 bg-white px-3 py-2 text-xs font-bold text-[#6E4A22] transition hover:border-[#B87C39] hover:bg-[#B87C39] hover:text-white"
                                title="Edit Data">
                                <i data-lucide="pencil" class="w-3.5 h-3.5"></i>
                                Edit
                            </button>
                            <button
                                @click="confirmDelete({{ $cafe->id_kafe }})"
                                class="inline-flex items-center gap-1.5 rounded-lg border border-red-200 bg-white px-3 py-2 text-xs font-bold text-red-600 transition hover:bg-red-600 hover:text-white"
                                title="Hapus Data">
                                <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                Hapus
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-5 py-10 text-center text-sm font-semibold text-gray-500">
                        Belum ada data kafe.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-5 flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
    <p class="text-sm font-medium text-gray-500">
        Menampilkan {{ $cafes->firstItem() }} - {{ $cafes->lastItem() }} dari {{ $cafes->total() }} data
    </p>
    <div class="flex items-center gap-1">
        @if ($cafes->onFirstPage())
            <span class="px-3 py-1.5 rounded-lg text-sm font-bold text-gray-300 cursor-not-allowed">&lsaquo;</span>
        @else
            <a href="{{ $cafes->previousPageUrl() }}" class="px-3 py-1.5 rounded-lg text-sm font-bold text-[#B87C39] hover:bg-[#B87C39]/10 transition">&lsaquo;</a>
        @endif

        @php
            $last = $cafes->lastPage();
            $current = $cafes->currentPage();
        @endphp

        @for ($i = 1; $i <= min(5, $last); $i++)
            @if ($i == $current)
                <span class="px-3 py-1.5 rounded-lg text-sm font-bold bg-[#B87C39] text-white">{{ $i }}</span>
            @else
                <a href="{{ $cafes->url($i) }}" class="px-3 py-1.5 rounded-lg text-sm font-bold text-gray-600 hover:bg-[#B87C39]/10 hover:text-[#B87C39] transition">{{ $i }}</a>
            @endif
        @endfor

        @if ($last > 5)
            <span class="px-2 text-gray-400 text-sm">...</span>
            <a href="{{ $cafes->url($last) }}" class="px-3 py-1.5 rounded-lg text-sm font-bold text-gray-600 hover:bg-[#B87C39]/10 hover:text-[#B87C39] transition">{{ $last }}</a>
        @endif

        @if ($cafes->hasMorePages())
            <a href="{{ $cafes->nextPageUrl() }}" class="px-3 py-1.5 rounded-lg text-sm font-bold text-[#B87C39] hover:bg-[#B87C39]/10 transition">&rsaquo;</a>
        @else
            <span class="px-3 py-1.5 rounded-lg text-sm font-bold text-gray-300 cursor-not-allowed">&rsaquo;</span>
        @endif
    </div>
</div>
