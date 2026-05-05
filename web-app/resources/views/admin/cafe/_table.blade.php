<div class="overflow-x-auto">
    <table class="w-full border-collapse text-[14px] table-fixed">

        {{-- HEADER --}}
        <thead>
            <tr class="bg-[#C9A876] text-white">
                <th class="py-2 px-2 text-center w-[50px]">No</th>
                <th class="py-2 px-2 w-[40%]">Nama Kafe</th>
                <th class="py-2 px-2 text-center w-[80px]">Jarak</th>
                <th class="py-2 px-2 text-center w-[140px]">Operasional</th>
                <th class="py-2 px-2 text-center w-[200px]">Aksi</th>
            </tr>
        </thead>

        {{-- BODY --}}
        <tbody>
            @forelse($cafes as $index => $cafe)
            <tr class="border-b border-[#E5D3B3] hover:bg-[#E8D5B5]/40">

                {{-- NO --}}
                <td class="py-2 px-2 text-center text-gray-500">
                    {{ $cafes->firstItem() + $index }}
                </td>

                {{-- NAMA --}}
                <td class="py-2 px-2">
                    <div class="font-semibold text-gray-800 truncate">
                        {{ $cafe->nama_kafe }}
                    </div>
                    <div class="text-[12px] text-gray-500 truncate">
                        {{ $cafe->alamat }}
                    </div>
                </td>

                {{-- JARAK --}}
                <td class="py-2 px-2 text-center font-medium text-gray-700">
                    {{ $cafe->jarak }} km
                </td>

                {{-- JAM --}}
                <td class="py-2 px-2 text-center text-gray-700">
                    {{ $cafe->jam_buka }} - {{ $cafe->jam_tutup }}
                </td>

                {{-- AKSI --}}
                <td class="py-2 px-2">
                    <div class="flex justify-center gap-2">

                        {{-- DETAIL --}}
                        <a href="#"
                           class="flex items-center gap-1 px-2 py-1 text-[12px] rounded-md 
                                  bg-[#FEF6E7] text-[#8B5E34] hover:bg-[#E8D5B5]">
                            <i data-lucide="eye" class="w-4 h-4"></i>
                            <span>Detail</span>
                        </a>

                        {{-- EDIT --}}
                        <a href="{{ route('admin.cafe.edit', $cafe->id_kafe) }}"
                           class="flex items-center gap-1 px-2 py-1 text-[12px] rounded-md 
                                  bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white">
                            <i data-lucide="pencil" class="w-4 h-4"></i>
                            <span>Edit</span>
                        </a>

                        {{-- HAPUS --}}
                        <form action="{{ route('admin.cafe.destroy', $cafe->id_kafe) }}"
                              method="POST"
                              onsubmit="return confirm('Yakin hapus data ini?')">
                            @csrf
                            @method('DELETE')

                            <button
                                class="flex items-center gap-1 px-2 py-1 text-[12px] rounded-md 
                                       bg-red-50 text-red-600 hover:bg-red-600 hover:text-white">
                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                                <span>Hapus</span>
                            </button>
                        </form>

                    </div>
                </td>

            </tr>
            @empty
            <tr>
                <td colspan="5" class="py-6 text-center text-gray-400">
                    Data tidak ditemukan
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- PAGINATION --}}
<div class="flex justify-between items-center mt-4 text-[12px] text-gray-500">

    <div>
        Menampilkan {{ $cafes->firstItem() }} - {{ $cafes->lastItem() }} dari {{ $cafes->total() }}
    </div>

    <div class="flex items-center gap-1">

        {{-- PREV --}}
        @if ($cafes->onFirstPage())
            <span class="px-2 text-gray-300">&lt;</span>
        @else
            <a href="{{ $cafes->previousPageUrl() }}" class="px-2 text-[#B87A3D]">&lt;</a>
        @endif

        {{-- NUMBER --}}
        @php
            $last = $cafes->lastPage();
            $current = $cafes->currentPage();
        @endphp

        @for ($i = 1; $i <= min(5, $last); $i++)
            @if ($i == $current)
                <span class="px-2 py-1 bg-[#B87A3D] text-white rounded">
                    {{ $i }}
                </span>
            @else
                <a href="{{ $cafes->url($i) }}"
                   class="px-2 py-1 text-[#B87A3D] hover:bg-[#F5ECD7] rounded">
                    {{ $i }}
                </a>
            @endif
        @endfor

        @if ($last > 5)
            <span>...</span>
            <a href="{{ $cafes->url($last) }}" class="px-2 py-1 text-[#B87A3D]">
                {{ $last }}
            </a>
        @endif

        {{-- NEXT --}}
        @if ($cafes->hasMorePages())
            <a href="{{ $cafes->nextPageUrl() }}" class="px-2 text-[#B87A3D]">&gt;</a>
        @else
            <span class="px-2 text-gray-300">&gt;</span>
        @endif

    </div>
</div>