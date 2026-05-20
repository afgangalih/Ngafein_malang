        <div class="overflow-hidden rounded-lg border border-gray-200">
            <div class="overflow-x-auto">
                <table class="w-full min-w-[750px] text-left">
                    <thead class="bg-[#6E4A22] text-white">
                        <tr>
                            <th class="w-20 px-5 py-3 text-center text-xs font-bold uppercase tracking-wide">No</th>
                            <th class="px-5 py-3 text-xs font-bold uppercase tracking-wide">Nama</th>
                            <th class="px-5 py-3 text-xs font-bold uppercase tracking-wide">Email</th>
                            <th class="w-56 px-5 py-3 text-center text-xs font-bold uppercase tracking-wide">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white">
                        @forelse ($users as $item)
                            <tr class="transition hover:bg-[#B87C39]/5">
                                <td class="px-5 py-4 text-center text-sm font-bold text-gray-500">{{ $users->firstItem() + $loop->index }}</td>
                                <td class="px-5 py-4 text-sm font-bold text-gray-900">{{ $item->name }}</td>
                                <td class="px-5 py-4 text-sm font-semibold text-gray-500">{{ $item->email }}</td>
                                <td class="px-5 py-4">
                                    <div class="flex items-center justify-center gap-2">
                                        <button type="button" @click="openEdit({ id: {{ $item->id }}, name: @js($item->name), email: @js($item->email) })" class="inline-flex items-center gap-1.5 rounded-lg border border-[#B87C39]/30 bg-white px-3 py-2 text-xs font-bold text-[#6E4A22] transition hover:border-[#B87C39] hover:bg-[#B87C39] hover:text-white">
                                            <i data-lucide="pencil" class="h-3.5 w-3.5"></i>
                                            Edit
                                        </button>
                                        @if(auth()->id() != $item->id)
                                        <button type="button" @click="confirmDelete({{ $item->id }}, @js($item->name))" class="inline-flex items-center gap-1.5 rounded-lg border border-red-200 bg-white px-3 py-2 text-xs font-bold text-red-600 transition hover:bg-red-600 hover:text-white">
                                            <i data-lucide="trash-2" class="h-3.5 w-3.5"></i>
                                            Hapus
                                        </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-5 py-10 text-center text-sm font-semibold text-gray-500">Belum ada data admin.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-5 flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
            <p class="text-sm font-medium text-gray-500">
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
