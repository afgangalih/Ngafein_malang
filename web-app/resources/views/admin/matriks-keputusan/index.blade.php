@extends('layouts.admin')

@section('title', 'Matriks Keputusan — Ngafein Admin')

@section('content')
<div class="flex flex-col h-full space-y-6 pb-12">

    {{-- page header --}}
    <div class="flex flex-col">
        <h1 class="text-[1.5rem] font-black text-gray-900 tracking-tight">Matriks Keputusan</h1>
        <p class="text-gray-500 text-[13px] font-medium mt-1">Nilai setiap alternatif berdasarkan kriteria yang ada.</p>
    </div>

    {{-- main card --}}
    <div class="bg-[#F5ECD7] rounded-[2rem] p-6 shadow-sm">

        {{-- card header --}}
        <div class="mb-6">
            <h2 class="text-[1.2rem] font-black text-gray-800 tracking-tight">Tabel Matriks Keputusan ( Nilai Awal)</h2>
        </div>

        {{-- table --}}
        <div class="bg-[#EFE0C2] rounded-2xl overflow-hidden border border-[#D4B896] overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-[#C9A876] border-b-2 border-[#B89060]">
                        <th class="py-4 px-5 text-[12px] font-bold text-white border-r border-[#B89060] text-center">No</th>
                        <th class="py-4 px-5 text-[12px] font-bold text-white border-r border-[#B89060]">Nama Kafe</th>
                        <th class="py-4 px-5 text-[12px] font-bold text-white border-r border-[#B89060] text-center">Harga<br>(Cost)</th>
                        <th class="py-4 px-5 text-[12px] font-bold text-white border-r border-[#B89060] text-center">Rating<br>(Benefit)</th>
                        <th class="py-4 px-5 text-[12px] font-bold text-white border-r border-[#B89060] text-center">Jarak<br>(Cost)</th>
                        <th class="py-4 px-5 text-[12px] font-bold text-white border-r border-[#B89060] text-center">Fasilitas<br>(Benefit)</th>
                        <th class="py-4 px-5 text-[12px] font-bold text-white border-r border-[#B89060] text-center">Menu<br>(Benefit)</th>
                        <th class="py-4 px-5 text-[12px] font-bold text-white text-center">Durasi<br>(Benefit)</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $dummyData = [
                            ['no' => 1, 'nama' => 'KAF Cafe',          'harga' => 37.5, 'rating' => 4.4, 'jarak' => 0.55, 'fasilitas' => 8,  'menu' => 5, 'durasi' => 19],
                            ['no' => 2, 'nama' => 'Nakoa Cafe Suhat',   'harga' => 37.5, 'rating' => 4.8, 'jarak' => 2.1,  'fasilitas' => 8,  'menu' => 4, 'durasi' => 15],
                            ['no' => 3, 'nama' => 'Nakoa Cafe Panjaitan',   'harga' => 37.5, 'rating' => 4.9, 'jarak' => 1.4,  'fasilitas' => 9,  'menu' => 4, 'durasi' => 15],
                            ['no' => 4, 'nama' => 'Semusim Cafe',       'harga' => 13,   'rating' => 4.5, 'jarak' => 0.6,  'fasilitas' => 10, 'menu' => 5, 'durasi' => 19],
                            ['no' => 5, 'nama' => 'Roketto Coffee & Co',    'harga' => 37.5, 'rating' => 4.5, 'jarak' => 1.3,  'fasilitas' => 8,  'menu' => 4, 'durasi' => 24],
                            ['no' => 6, 'nama' => 'Pesenkopi Plus Betek',       'harga' => 37.5, 'rating' => 4.8, 'jarak' => 0.8,  'fasilitas' => 8,  'menu' => 5, 'durasi' => 12.8],
                            ['no' => 7, 'nama' => 'Swara Bungur',     'harga' => 13,   'rating' => 4.1, 'jarak' => 2.7,  'fasilitas' => 8,  'menu' => 5, 'durasi' => 24],
                        ];
                    @endphp

                    @foreach($dummyData as $item)
                    <tr class="border-b border-[#D4B896] hover:bg-[#E8D5B5]/50 transition-colors">
                        <td class="py-4 px-5 text-[13px] font-bold text-gray-500 border-r border-[#D4B896] text-center">{{ $item['no'] }}.</td>
                        <td class="py-4 px-5 text-[13px] font-semibold text-gray-800 border-r border-[#D4B896]">{{ $item['nama'] }}</td>
                        <td class="py-4 px-5 text-[13px] text-gray-700 border-r border-[#D4B896] text-center">{{ $item['harga'] }}</td>
                        <td class="py-4 px-5 text-[13px] text-gray-700 border-r border-[#D4B896] text-center">{{ $item['rating'] }}</td>
                        <td class="py-4 px-5 text-[13px] text-gray-700 border-r border-[#D4B896] text-center">{{ $item['jarak'] }}</td>
                        <td class="py-4 px-5 text-[13px] text-gray-700 border-r border-[#D4B896] text-center">{{ $item['fasilitas'] }}</td>
                        <td class="py-4 px-5 text-[13px] text-gray-700 border-r border-[#D4B896] text-center">{{ $item['menu'] }}</td>
                        <td class="py-4 px-5 text-[13px] text-gray-700 text-center">{{ $item['durasi'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- showing entries --}}
        <p class="text-[12px] text-gray-500 mt-3 px-1">Showing 1 to 7 of 110 entries</p>

        {{-- footer keterangan --}}
        <div class="mt-6 space-y-1">
            <p class="text-[13px] font-bold text-gray-700">Keterangan Jenis Kriteria :</p>
            <p class="text-[13px] text-gray-600">
                <span class="font-bold">Benefit</span>
                &nbsp;&nbsp;: Semakin besar nilai semakin baik
            </p>
            <p class="text-[13px] text-gray-600">
                <span class="font-bold">Cost</span>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: Semakin kecil nilai semakin baik
            </p>
        </div>

    </div>

</div>

@push('scripts')
<script src="https://unpkg.com/lucide@latest"></script>
<script>lucide.createIcons();</script>
@endpush

@endsection