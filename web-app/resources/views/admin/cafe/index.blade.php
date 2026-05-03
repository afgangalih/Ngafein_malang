@extends('layouts.admin')

@section('title', 'Data Alternatif — Ngafein Admin')

@section('content')
<div class="flex flex-col h-full space-y-6 pb-12" x-data="cafeSearch()">

    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-[1.5rem] font-black text-gray-900">Data Alternatif</h1>
            <p class="text-gray-500 text-[13px] mt-1">Daftar cafe untuk perhitungan SAW</p>
        </div>

        <div class="flex gap-2">
            <a href="#"
               class="px-5 py-2.5 bg-[#F5ECD7] text-[#8B5E34] border border-[#E0C9A6] rounded-xl font-bold text-[12px] hover:bg-[#E8D5B5]">
                ⬆ Import Dataset
            </a>

            <a href="#"
               class="px-5 py-2.5 bg-[#B87A3D] text-white rounded-xl font-bold text-[12px] hover:bg-[#9c6531]">
                + Tambah Cafe
            </a>
        </div>
    </div>

    {{-- CARD --}}
    <div class="bg-[#F5ECD7] rounded-[2rem] p-6 shadow-sm">

        {{-- TOP --}}
        <div class="flex flex-col gap-3 mb-6">
            <h2 class="text-[1.2rem] font-black text-gray-800">
                Tabel Alternatif
            </h2>

            <div class="flex justify-between items-center">

                {{-- SHOW --}}
                <div class="flex items-center gap-2 text-[13px] font-bold text-gray-700">
                    <span>Tampilkan</span>

                    <select x-model="perPage" @change="fetchData()"
                        class="px-3 py-2 rounded-xl border bg-white text-[13px]">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>

                    <span>data</span>
                </div>

                {{-- SEARCH --}}
                <input type="text"
                    x-model="search"
                    @input.debounce.300ms="fetchData()"
                    placeholder="Cari cafe..."
                    class="px-4 py-2 rounded-xl border bg-white text-[13px]">
            </div>
        </div>

        {{-- TABLE --}}
        <div id="table-wrapper">
            @include('admin.cafe._table')
        </div>

    </div>
</div>

@push('scripts')
<script src="https://unpkg.com/lucide@latest"></script>

<script>
function cafeSearch() {
    return {
        search: '',
        perPage: 10,

        fetchData() {
            const url = new URL(window.location.href);

            url.searchParams.set('search', this.search);
            url.searchParams.set('per_page', this.perPage);
            url.searchParams.delete('page');

            fetch(url, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(res => res.text())
            .then(html => {
                document.getElementById('table-wrapper').innerHTML = html;

                // 🔥 render ulang icon setelah AJAX
                if (window.lucide) {
                    lucide.createIcons();
                }
            });
        }
    }
}

// 🔥 render icon saat pertama load
document.addEventListener("DOMContentLoaded", function () {
    if (window.lucide) {
        lucide.createIcons();
    }
});
</script>

<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endpush

@endsection