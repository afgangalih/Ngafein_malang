@extends('layouts.admin')

@section('title', 'Normalisasi — Ngafein Admin')

@section('content')
<div class="flex flex-col h-full space-y-6 pb-12">

    {{-- page header --}}
    <div class="flex flex-col">
        <h1 class="text-[1.5rem] font-black text-gray-900 tracking-tight">Normalisasi</h1>
        <p class="text-gray-500 text-[13px] font-medium mt-1">
            Hasil normalisasi matriks keputusan menggunkan metode SAW (Simple Additive Weighting)
        </p>
    </div>

    {{-- main card --}}
    <div class="bg-[#F5ECD7] rounded-[2rem] p-6 shadow-sm">

        {{-- card header --}}
        <div class="mb-6">
            <h2 class="text-[1.2rem] font-black text-gray-800 tracking-tight">
                Tabel Normalisasi
            </h2>
        </div>

        {{-- table --}}
        <div class="bg-[#EFE0C2] rounded-2xl overflow-hidden border border-[#D4B896] overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-[#C9A876] border-b-2 border-[#B89060]">
                        <th class="py-4 px-5 text-[12px] font-bold text-white border-r border-[#B89060] text-center">No</th>
                        <th class="py-4 px-5 text-[12px] font-bold text-white border-r border-[#B89060]">Nama Kafe</th>
                        <th class="py-4 px-5 text-[12px] font-bold text-white border-r border-[#B89060] text-center">Harga</th>
                        <th class="py-4 px-5 text-[12px] font-bold text-white border-r border-[#B89060] text-center">Rating</th>
                        <th class="py-4 px-5 text-[12px] font-bold text-white border-r border-[#B89060] text-center">Jarak</th>
                        <th class="py-4 px-5 text-[12px] font-bold text-white border-r border-[#B89060] text-center">Fasilitas</th>
                        <th class="py-4 px-5 text-[12px] font-bold text-white border-r border-[#B89060] text-center">Menu</th>
                        <th class="py-4 px-5 text-[12px] font-bold text-white text-center">Durasi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($normalisasi as $item)
                    <tr class="border-b border-[#D4B896] hover:bg-[#E8D5B5]/50 transition-colors">

                        <td class="py-4 px-5 text-[13px] font-bold text-gray-500 border-r border-[#D4B896] text-center">
                            {{ $loop->iteration }}.
                        </td>

                        <td class="py-4 px-5 text-[13px] font-semibold text-gray-800 border-r border-[#D4B896]">
                            {{ $item['nama'] }}
                        </td>

                        <td class="py-4 px-5 text-[13px] text-gray-700 border-r border-[#D4B896] text-center">
                            {{ number_format($item['harga'], 2) }}
                        </td>

                        <td class="py-4 px-5 text-[13px] text-gray-700 border-r border-[#D4B896] text-center">
                            {{ number_format($item['rating'], 2) }}
                        </td>

                        <td class="py-4 px-5 text-[13px] text-gray-700 border-r border-[#D4B896] text-center">
                            {{ number_format($item['jarak'], 2) }}
                        </td>

                        <td class="py-4 px-5 text-[13px] text-gray-700 border-r border-[#D4B896] text-center">
                            {{ number_format($item['fasilitas'], 2) }}
                        </td>

                        <td class="py-4 px-5 text-[13px] text-gray-700 border-r border-[#D4B896] text-center">
                            {{ number_format($item['menu'], 2) }}
                        </td>

                        <td class="py-4 px-5 text-[13px] text-gray-700 text-center">
                            {{ number_format($item['durasi'], 2) }}
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="py-16 text-center text-gray-400">
                            Data normalisasi belum tersedia
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- showing entries --}}
        <p class="text-[12px] text-gray-500 mt-3 px-1">
            Showing 1 to {{ count($normalisasi) }} of {{ count($normalisasi) }} entries
        </p>

        {{-- footer --}}
        <div class="mt-6 space-y-1">
            <p class="text-[13px] font-bold text-gray-700">Keterangan :</p>
            <p class="text-[13px] text-gray-600">
                Nilai sudah dinormalisasi ke skala 0 - 1
            </p>
        </div>

    </div>

</div>

@push('scripts')
<script src="https://unpkg.com/lucide@latest"></script>
<script>lucide.createIcons();</script>
@endpush

@endsection