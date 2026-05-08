@extends('layouts.admin')

@section('title', 'Proses SAW — Ngafein Admin')

@section('content')
<div x-data="{ tab: 'matriks' }" class="flex flex-col space-y-6 pb-12">

    {{-- HEADER --}}
    <div>
        <h1 class="text-2xl font-extrabold text-gray-900 tracking-tight">
            Proses SAW
        </h1>
        <p class="text-gray-500 text-sm mt-1">
            Matriks Keputusan → Normalisasi → Perhitungan SAW
        </p>
    </div>

    {{-- TAB BUTTON --}}
    <div class="flex gap-3">
        <button @click="tab='matriks'"
            :class="tab==='matriks' ? 'bg-[#B87A3D] text-white' : 'bg-[#EFE0C2] text-gray-700'"
            class="px-4 py-2 rounded-xl text-sm font-semibold">
            Matriks
        </button>

        <button @click="tab='normalisasi'"
            :class="tab==='normalisasi' ? 'bg-[#B87A3D] text-white' : 'bg-[#EFE0C2] text-gray-700'"
            class="px-4 py-2 rounded-xl text-sm font-semibold">
            Normalisasi
        </button>

        <button @click="tab='saw'"
            :class="tab==='saw' ? 'bg-[#B87A3D] text-white' : 'bg-[#EFE0C2] text-gray-700'"
            class="px-4 py-2 rounded-xl text-sm font-semibold">
            SAW
        </button>
    </div>

    {{-- ================= MATRIKS ================= --}}
    <div x-show="tab==='matriks'" x-transition>
        <div class="bg-[#F5ECD7] rounded-3xl p-6">
            <table id="tabel-matriks" class="w-full text-sm">
                <thead class="bg-[#C9A876] text-white">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Harga <span class="text-xs font-normal opacity-75">(Cost)</span></th>
                        <th>Rating <span class="text-xs font-normal opacity-75">(Benefit)</span></th>
                        <th>Jarak <span class="text-xs font-normal opacity-75">(Cost)</span></th>
                        <th>Fasilitas <span class="text-xs font-normal opacity-75">(Benefit)</span></th>
                        <th>Menu <span class="text-xs font-normal opacity-75">(Benefit)</span></th>
                        <th>Durasi <span class="text-xs font-normal opacity-75">(Benefit)</span></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($matriks as $i => $item)
                    <tr>
                        <td>{{ $i+1 }}</td>
                        <td>{{ $item['nama_kafe'] }}</td>
                        <td>{{ $item['harga'] }}</td>
                        <td>{{ $item['rating'] }}</td>
                        <td>{{ $item['jarak'] }}</td>
                        <td>{{ $item['fasilitas'] }}</td>
                        <td>{{ $item['menu'] }}</td>
                        <td>{{ $item['durasi'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{-- KETERANGAN --}}
        <div class="mt-4 bg-[#EFE0C2] rounded-2xl px-5 py-4 text-sm text-gray-700">
            <p class="font-bold mb-2">Keterangan Jenis Kriteria :</p>
            <div class="flex gap-2">
                <span class="w-16 font-semibold">Benefit</span>
                <span>: Semakin besar nilai semakin baik</span>
            </div>
            <div class="flex gap-2 mt-1">
                <span class="w-16 font-semibold">Cost</span>
                <span>: Semakin kecil nilai semakin baik</span>
            </div>
        </div>
    </div>

    {{-- ================= NORMALISASI ================= --}}
    <div x-show="tab==='normalisasi'" x-transition>
        <div class="bg-[#F5ECD7] rounded-3xl p-6">
            <table id="tabel-normalisasi" class="w-full text-sm">
                <thead class="bg-[#C9A876] text-white">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Harga <span class="text-xs font-normal opacity-75">(Cost)</span></th>
                        <th>Rating <span class="text-xs font-normal opacity-75">(Benefit)</span></th>
                        <th>Jarak <span class="text-xs font-normal opacity-75">(Cost)</span></th>
                        <th>Fasilitas <span class="text-xs font-normal opacity-75">(Benefit)</span></th>
                        <th>Menu <span class="text-xs font-normal opacity-75">(Benefit)</span></th>
                        <th>Durasi <span class="text-xs font-normal opacity-75">(Benefit)</span></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($normalisasi as $i => $item)
                    <tr>
                        <td>{{ $i+1 }}</td>
                        <td>{{ $item['nama'] }}</td>
                        <td>{{ number_format($item['harga'],2) }}</td>
                        <td>{{ number_format($item['rating'],2) }}</td>
                        <td>{{ number_format($item['jarak'],2) }}</td>
                        <td>{{ number_format($item['fasilitas'],2) }}</td>
                        <td>{{ number_format($item['menu'],2) }}</td>
                        <td>{{ number_format($item['durasi'],2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- ================= SAW ================= --}}
    <div x-show="tab==='saw'" x-transition>
        <div class="bg-[#F5ECD7] rounded-3xl p-6">
            <div style="overflow-x: auto;">
                <table id="tabel-saw" class="w-full text-sm" style="min-width: max-content;">
                    <thead class="bg-[#C9A876] text-white">
                        <tr>
                            <th>No</th><th>Nama</th><th>Perhitungan</th><th>Skor</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($hasil as $i => $item)
                        <tr>
                            <td>{{ $i+1 }}</td>
                            <td>{{ $item['nama_kafe'] }}</td>
                            <td class="text-xs" style="white-space: nowrap;">{{ $item['perhitungan'] }}</td>
                            <td class="font-bold" style="white-space: nowrap;">{{ number_format($item['skor'],2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>

<style>
.dataTables_wrapper {
    padding: 14px;
}

.dataTables_length {
    float: left;
    margin-bottom: 12px;
    color: #333;
    font-size: 14px;
}

.dataTables_length select {
    background-color: #ffffff !important;
    border-radius: 12px;
    padding: 6px 12px;
    border: 1px solid #ddd;
    outline: none;
}

.dataTables_filter {
    float: right;
    margin-bottom: 12px;
}

.dataTables_filter label {
    font-size: 0;
    display: flex;
    align-items: center;
}

.dataTables_filter input {
    background-color: #ffffff !important;
    border-radius: 999px;
    padding: 8px 16px 8px 34px;
    border: 1px solid #ddd;
    outline: none;
    width: 200px;
    font-size: 13px;
    height: 34px;
    box-sizing: border-box;
}

.dataTables_filter input::placeholder {
    color: #999;
    font-size: 13px;
}

.search-wrapper {
    position: relative;
    display: inline-flex;
    align-items: center;
}

.search-wrapper .search-icon {
    position: absolute;
    left: 10px;
    top: 50%;
    transform: translateY(-50%);
    display: flex;
    align-items: center;
    pointer-events: none;
    z-index: 1;
}

.dataTables_info {
    float: left;
    margin-top: 12px;
    font-size: 13px;
}

.dataTables_paginate {
    float: right;
    margin-top: 12px;
}

.dataTables_wrapper::after {
    content: "";
    display: block;
    clear: both;
}

#tabel-saw td {
    white-space: nowrap;
}

#tabel-saw th {
    white-space: nowrap;
}
</style>

<script>
$(document).ready(function () {

    var svgIcon = '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#999999" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>';

    function initTable(id) {
        if (!$.fn.DataTable.isDataTable(id)) {
            $(id).DataTable({
                pageLength: 10,
                lengthMenu: [10, 25, 50, 100],
                language: {
                    search: "",
                    lengthMenu: "Tampilkan _MENU_ data",
                    info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                    paginate: { next: "›", previous: "‹" }
                },
                initComplete: function () {
                    var filter = $(id + '_filter');
                    var input = filter.find('input');

                    input.attr('placeholder', 'Cari cafe...');
                    input.css('padding-left', '34px');

                    input.wrap('<div class="search-wrapper"></div>');
                    input.before('<span class="search-icon">' + svgIcon + '</span>');
                }
            });
        }
    }

    initTable('#tabel-matriks');
    initTable('#tabel-normalisasi');
    initTable('#tabel-saw');

});
</script>

@endpush