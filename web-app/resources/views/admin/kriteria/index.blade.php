@extends('layouts.admin')

@section('title', 'Data Kriteria — Ngafein Admin')

@section('content')
<div class="flex flex-col h-full space-y-6 pb-12" x-data="{ showForm: false }">

    {{-- page header --}}
    <div class="flex flex-col">
        <h1 class="text-[1.5rem] font-black text-gray-900 tracking-tight">Data Kriteria</h1>
        <p class="text-gray-500 text-[13px] font-medium mt-1">Kriteria yang digunakan dalam metode SAW (Simple Additive Weighting) untuk pemilihan kafe.</p>
    </div>

    {{-- content area --}}
    <div class="flex gap-6 items-start">

        {{-- main card --}}
        <div class="bg-[#F5ECD7] rounded-[2rem] p-6 shadow-sm flex-1">

            {{-- card header --}}
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-[1.4rem] font-black text-gray-800 tracking-tight">Daftar  Kriteria</h2>
                <button @click="showForm = true"
                   class="flex items-center gap-2 px-6 py-3 bg-[#B87A3D] hover:bg-[#A36A32] text-white rounded-xl font-bold text-[13px] transition-all shadow-md">
                    <i data-lucide="plus" class="w-4 h-4"></i>
                    Tambah Kriteria
                </button>
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

        {{-- panel form tambah kriteria --}}
        <div x-show="showForm"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 translate-x-4"
             x-transition:enter-end="opacity-100 translate-x-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-x-0"
             x-transition:leave-end="opacity-0 translate-x-4"
             class="w-72 shrink-0"
             style="display: none;">

            <div class="bg-[#F5ECD7] rounded-[2rem] p-6 shadow-sm">

                {{-- form header --}}
                <div class="flex items-center gap-2 mb-6">
                    <div class="w-8 h-8 flex items-center justify-center bg-[#C9A876] rounded-lg">
                        <i data-lucide="layout-grid" class="w-4 h-4 text-white"></i>
                    </div>
                    <h3 class="text-[15px] font-black text-gray-800">Tambah Kriteria Baru</h3>
                </div>

                <div class="space-y-4">

                    {{-- Nama Kriteria --}}
                    <div class="flex flex-col gap-1.5">
                        <label class="text-[12px] font-bold text-gray-600">Nama Kriteria</label>
                        <input type="text"
                               class="w-full px-4 py-3 bg-[#E8D5B5] border-none rounded-xl text-[13px] text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#B87A3D]/30 transition-all font-medium">
                    </div>

                    {{-- Bobot --}}
                    <div class="flex flex-col gap-1.5">
                        <label class="text-[12px] font-bold text-gray-600">Bobot Kepentingan</label>
                        <input type="number"
                               step="0.01" min="0" max="1"
                               class="w-full px-4 py-3 bg-[#E8D5B5] border-none rounded-xl text-[13px] text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#B87A3D]/30 transition-all font-medium">
                    </div>

                    {{-- Tipe --}}
                    <div class="flex flex-col gap-1.5" x-data="{ tipe: '' }">
                        <label class="text-[12px] font-bold text-gray-600">Tipe Kriteria</label>
                        <div class="flex gap-2">
                            <button type="button"
                                    @click="tipe = 'benefit'"
                                    :class="tipe === 'benefit' ? 'bg-[#B87A3D] text-white' : 'bg-[#E8D5B5] text-gray-700'"
                                    class="flex-1 py-3 rounded-xl text-[13px] font-bold transition-all">
                                Benefit
                            </button>
                            <button type="button"
                                    @click="tipe = 'cost'"
                                    :class="tipe === 'cost' ? 'bg-[#B87A3D] text-white' : 'bg-[#E8D5B5] text-gray-700'"
                                    class="flex-1 py-3 rounded-xl text-[13px] font-bold transition-all">
                                Cost
                            </button>
                        </div>
                    </div>

                    {{-- Simpan --}}
                    <button type="button"
                            class="w-full py-3 bg-[#B87A3D] hover:bg-[#A36A32] text-white rounded-xl font-bold text-[13px] transition-all shadow-md mt-2">
                        Simpan Kriteria
                    </button>

                    {{-- Batalkan --}}
                    <button type="button"
                            @click="showForm = false"
                            class="w-full py-2 text-[13px] font-bold text-gray-500 hover:text-gray-700 transition-colors text-center">
                        Batalkan
                    </button>

                </div>
            </div>
        </div>

    </div>

</div>

@push('scripts')
<script src="https://unpkg.com/lucide@latest"></script>
<script>lucide.createIcons();</script>
@endpush

@endsection