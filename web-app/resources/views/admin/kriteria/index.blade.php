@extends('layouts.admin')

@section('title', 'Data Kriteria — Ngafein Admin')

@section('content')
<div class="flex flex-col h-full space-y-6 pb-12">

    {{-- page header --}}
    <div class="flex flex-col">
        <h1 class="text-[1.5rem] font-black text-gray-900 tracking-tight">Data Kriteria</h1>
        <p class="text-gray-500 text-[13px] font-medium mt-1">Kriteria yang digunakan dalam metode SAW (Simple Additive Weighting) untuk pemilihan kafe.</p>
    </div>

    {{-- main card --}}
    <div class="bg-[#F5ECD7] rounded-[2rem] p-6 shadow-sm">

        {{-- card header --}}
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-[1.4rem] font-black text-gray-800 tracking-tight">Daftar  Kriteria</h2>
        </div>

        {{-- table --}}
        <div class="bg-[#EFE0C2] rounded-2xl overflow-hidden border border-[#D4B896]">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-[#C9A876] border-b-2 border-[#B89060]">
                        <th class="py-4 px-6 text-[13px] font-bold text-white border-r border-[#B89060]">Nama Kriteria</th>
                        <th class="py-4 px-6 text-[13px] font-bold text-white text-center border-r border-[#B89060]">Bobot</th>
                        <th class="py-4 px-6 text-[13px] font-bold text-white text-center border-r border-[#B89060]">Tipe</th>
                        <th class="py-4 px-6 text-[13px] font-bold text-white text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $dummyKriteria = [
                            ['nama' => 'Jarak'],
                            ['nama' => 'Harga'],
                            ['nama' => 'Fasilitas'],
                            ['nama' => 'Rating'],
                            ['nama' => 'Menu'],
                            ['nama' => 'Jam'],
                        ];
                    @endphp

                    @foreach($dummyKriteria as $index => $item)
                    <tr class="border-b border-[#D4B896]">
                        <td class="py-4 px-6 text-[14px] font-semibold text-gray-800 border-r border-[#D4B896]">
                            {{ $item['nama'] }}
                        </td>
                        <td class="py-4 px-6 text-center border-r border-[#D4B896]">
                            <div class="flex justify-center">
                                <div class="w-14 h-7 bg-[#C9A876] rounded-full shadow-inner"></div>
                            </div>
                        </td>
                        <td class="py-4 px-6 text-center border-r border-[#D4B896]">
                            <div class="flex justify-center">
                                <div class="w-14 h-7 bg-[#C9A876] rounded-full shadow-inner"></div>
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            <div class="flex justify-center items-center gap-3">
                                <button class="w-9 h-9 flex items-center justify-center bg-[#C9A876] hover:bg-[#B87A3D] rounded-xl transition-all">
                                    <i data-lucide="pencil" class="w-4 h-4 text-white"></i>
                                </button>
                                <button class="w-9 h-9 flex items-center justify-center bg-[#C9A876] hover:bg-red-500 rounded-xl transition-all">
                                    <i data-lucide="trash-2" class="w-4 h-4 text-white"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- footer penjelasan --}}
        <div class="mt-6 space-y-1">
            <p class="text-[13px] font-bold text-gray-700">Penjelasan Tipe Kriteria:</p>
            <p class="text-[13px] text-gray-600">
                <span class="font-bold">Benefit</span>
                &nbsp;&nbsp;: Semakin besar nilai semakin baik (Contoh : Rating dan Jam)
            </p>
            <p class="text-[13px] text-gray-600">
                <span class="font-bold">Cost</span>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: Semakin kecil nilai semakin baik (Contoh : Harga dan Jarak)
            </p>
            <p class="text-[13px] text-gray-600">
                <span class="font-bold">Total Bobot</span>
                &nbsp;&nbsp;: <span class="font-bold">1.00</span> (harus = 1.00)
            </p>
        </div>

    </div>

</div>

@push('scripts')
<script src="https://unpkg.com/lucide@latest"></script>
<script>lucide.createIcons();</script>
@endpush

@endsection