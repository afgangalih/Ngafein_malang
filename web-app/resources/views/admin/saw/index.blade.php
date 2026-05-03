@extends('layouts.admin')

@section('title', 'Perhitungan SAW — Ngafein Admin')

@section('content')
<div class="flex flex-col h-full space-y-6 pb-12">

    {{-- HEADER --}}
    <div>
        <h1 class="text-2xl font-extrabold text-gray-900 tracking-tight">
            Perhitungan SAW
        </h1>
        <p class="text-gray-500 text-sm mt-1">
            Hasil normalisasi matriks keputusan menggunakan metode SAW (Simple Additive Weighting)
        </p>
    </div>

    {{-- CARD --}}
    <div class="bg-[#F5ECD7] rounded-3xl p-6 shadow-sm">

        <h2 class="text-lg font-extrabold text-gray-800 mb-4">
            Tabel Perhitungan SAW
        </h2>

        <div class="bg-white rounded-2xl overflow-hidden border border-[#E5D3B3]">

            <div class="overflow-x-auto">
                <table id="tabel-saw" class="w-full text-sm">
                    <thead>
                        <tr class="bg-[#C9A876] text-white">
                            <th class="py-3 px-4 text-center w-12">No</th>
                            <th class="py-3 px-4 w-52">Nama Kafe</th>
                            <th class="py-3 px-4 text-center">Perhitungan</th>
                            <th class="py-3 px-4 text-center w-24">Hasil</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($hasil as $index => $item)
                        <tr class="{{ $index % 2 === 0 ? 'bg-white' : 'bg-[#FCF8F2]' }} hover:bg-[#F5ECD7] transition">

                            <td class="py-3 px-4 text-center text-gray-500 font-semibold">
                                {{ $index + 1 }}
                            </td>

                            <td class="py-3 px-4 font-semibold text-gray-800">
                                <span class="truncate block max-w-[180px]" title="{{ $item['nama_kafe'] }}">
                                    {{ Str::limit($item['nama_kafe'], 20) }}
                                </span>
                            </td>

                            <td class="py-3 px-4 text-gray-700 font-mono text-xs leading-relaxed">
                                {{ $item['perhitungan'] }}
                            </td>

                            <td class="py-3 px-4 text-center font-bold text-gray-800">
                                {{ number_format($item['skor'], 2) }}
                            </td>

                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="py-10 text-center text-gray-400">
                                Belum ada data kafe.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection


@push('scripts')

{{-- DataTables CDN --}}
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>

<style>
/* ================= WRAPPER ================= */
#tabel-saw_wrapper {
    margin-top: 10px;
    padding: 12px 14px; /* 🔥 biar nggak mepet card */
}

/* ================= TOP CONTROL (SEARCH & LENGTH) ================= */
#tabel-saw_wrapper .dataTables_length,
#tabel-saw_wrapper .dataTables_filter {
    font-size: 13px;
    color: #6B7280;
    margin-bottom: 14px;
}

/* Biar kiri kanan rapi */
#tabel-saw_wrapper .dataTables_length {
    float: left;
}

#tabel-saw_wrapper .dataTables_filter {
    float: right;
}

/* ================= INPUT & SELECT ================= */
#tabel-saw_wrapper .dataTables_length select,
#tabel-saw_wrapper .dataTables_filter input {
    border: 1px solid #D4B896;
    border-radius: 8px;
    padding: 6px 12px;
    font-size: 13px;
    background-color: #FDF8F1;
    color: #374151;
    outline: none;
    transition: all 0.2s ease;
}

/* Focus effect */
#tabel-saw_wrapper .dataTables_filter input:focus,
#tabel-saw_wrapper .dataTables_length select:focus {
    border-color: #B87A3D;
    box-shadow: 0 0 0 2px rgba(184,122,61,0.15);
}

/* ================= TABLE INFO ================= */
#tabel-saw_wrapper .dataTables_info {
    font-size: 12px;
    color: #9CA3AF;
    margin-top: 12px; /* 🔥 biar nggak nempel */
}

/* ================= PAGINATION ================= */
#tabel-saw_wrapper .dataTables_paginate {
    margin-top: 10px;
}

#tabel-saw_wrapper .dataTables_paginate .paginate_button {
    font-size: 12px;
    padding: 5px 12px;
    border-radius: 8px;
    color: #B87A3D !important;
    transition: all 0.2s ease;
}

/* Active page */
#tabel-saw_wrapper .dataTables_paginate .paginate_button.current {
    background: #B87A3D !important;
    border-color: #B87A3D !important;
    color: white !important;
}

/* Hover */
#tabel-saw_wrapper .dataTables_paginate .paginate_button:hover {
    background: #F5ECD7 !important;
    border-color: #D4B896 !important;
}

/* ================= CLEAR FLOAT ================= */
#tabel-saw_wrapper::after {
    content: "";
    display: block;
    clear: both;
}
</style>

<script>
$(document).ready(function () {
    const table = $('#tabel-saw').DataTable({
        pageLength: 10, // 🔥 default 10 data
        lengthMenu: [10, 25, 50, 100],
        order: [[3, 'desc']],
        language: {
            search: "Cari:",
            lengthMenu: "Tampilkan _MENU_ data",
            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
            infoEmpty: "Tidak ada data",
            zeroRecords: "Data tidak ditemukan",
            paginate: {
                first: "«",
                last: "»",
                next: ">",
                previous: "<"
            }
        },
        drawCallback: function () {
            const api = this.api();
            const info = api.page.info();
            const el = document.getElementById('tabel-saw-info');

            if (el) {
                el.textContent =
                    `Menampilkan ${info.start + 1} sampai ${info.end} dari ${info.recordsTotal} data kafe`;
            }
        }
    });
});
</script>

@endpush