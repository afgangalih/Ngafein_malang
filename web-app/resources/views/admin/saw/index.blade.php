@extends('layouts.admin')

@section('title', 'Proses SAW — Ngafein Admin')

@section('content')

@php $tab = request('tab', 'matriks'); @endphp

<style>
/* ── DataTables reset ── */
.dt-wrap .dataTables_wrapper { padding: 0; font-family: inherit; }
.dt-toolbar {
    display: flex; align-items: center; justify-content: space-between;
    padding: 14px 20px; border-bottom: 1px solid #D4B896; gap: 12px;
}
.dt-wrap .dataTables_length label {
    display: flex; align-items: center; gap: 8px;
    font-size: 13px; font-weight: 600; color: #5a4a35; margin: 0; white-space: nowrap;
}
.dt-wrap .dataTables_length select {
    appearance: none; -webkit-appearance: none; background-color: #fff;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%23999' stroke-width='2.5'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
    background-repeat: no-repeat; background-position: right 9px center;
    border: 1.5px solid #D4B896; border-radius: 10px; padding: 5px 30px 5px 11px;
    font-size: 13px; font-weight: 600; color: #5a4a35; cursor: pointer; outline: none;
}
.dt-wrap .dataTables_length select:focus { border-color: #B87A3D; box-shadow: 0 0 0 3px rgba(184,122,61,.15); }
.dt-wrap .dataTables_filter label { font-size: 0; display: block; }
.dt-search-wrap { position: relative; display: inline-flex; align-items: center; }
.dt-search-wrap .srch-icon {
    position: absolute; left: 11px; top: 50%; transform: translateY(-50%);
    pointer-events: none; width: 14px; height: 14px; color: #b0957a;
}
.dt-wrap .dataTables_filter input[type="search"] {
    background: #fff; border: 1.5px solid #D4B896; border-radius: 999px;
    padding: 7px 14px 7px 34px; font-size: 13px; font-weight: 500; color: #3d2f1f;
    width: 220px; outline: none; box-sizing: border-box; -webkit-appearance: none;
}
.dt-wrap .dataTables_filter input[type="search"]:focus { border-color: #B87A3D; box-shadow: 0 0 0 3px rgba(184,122,61,.15); }
.dt-wrap .dataTables_filter input[type="search"]::placeholder { color: #b0957a; font-size: 13px; }
.dt-wrap table.dataTable { width: 100% !important; border-collapse: collapse; }
.dt-wrap table.dataTable.no-footer { border-bottom: none; }
.dt-wrap table.dataTable thead th {
    background: #C9A876 !important; color: #fff !important;
    font-size: 13px; font-weight: 700; padding: 12px 16px; border: none; white-space: nowrap;
}
.dt-wrap table.dataTable thead .sorting::after,
.dt-wrap table.dataTable thead .sorting_asc::after,
.dt-wrap table.dataTable thead .sorting_desc::after { color: rgba(255,255,255,.6); }
.dt-wrap table.dataTable tbody td {
    padding: 10px 16px; font-size: 13px; color: #3d2f1f;
    border-bottom: 1px solid #D4B896; vertical-align: middle;
}
.dt-wrap table.dataTable tbody tr:nth-child(even) td { background: #EFE0C2; }
.dt-wrap table.dataTable tbody tr:nth-child(odd) td { background: #F5ECD7; }
.dt-wrap table.dataTable tbody tr:hover td { background: #DFC9A0 !important; }
.dt-bottom {
    display: flex; align-items: center; justify-content: space-between;
    padding: 12px 20px; border-top: 1px solid #D4B896;
}
.dt-wrap .dataTables_info { font-size: 13px; font-weight: 600; color: #7a6248; margin: 0; padding: 0; }
.dt-wrap .dataTables_paginate .paginate_button {
    display: inline-flex !important; align-items: center; justify-content: center;
    min-width: 30px; height: 30px; border-radius: 8px !important; font-size: 13px !important;
    font-weight: 700; color: #7a6248 !important; cursor: pointer;
    margin: 0 2px !important; border: 1px solid transparent !important;
    background: transparent !important; padding: 0 6px !important; box-shadow: none !important;
}
.dt-wrap .dataTables_paginate .paginate_button:hover { background: #E8D5B5 !important; border-color: #D4B896 !important; color: #5a4a35 !important; }
.dt-wrap .dataTables_paginate .paginate_button.current,
.dt-wrap .dataTables_paginate .paginate_button.current:hover { background: #B87A3D !important; border-color: #B87A3D !important; color: #fff !important; }
.dt-wrap .dataTables_paginate .paginate_button.disabled,
.dt-wrap .dataTables_paginate .paginate_button.disabled:hover { color: #c9b99a !important; background: transparent !important; cursor: default; }

/* step */
.step-line { flex: 1; height: 2px; background: #D4B896; margin: 0 4px; margin-top: 15px; }
</style>

<div class="flex flex-col space-y-6 pb-14">

    {{-- ── JUDUL ── --}}
    <div>
        <h1 class="text-2xl font-extrabold text-gray-900 tracking-tight">Proses SAW</h1>
        <p class="text-gray-400 text-sm mt-1">Simple Additive Weighting</p>
    </div>

    {{-- ── STEP INDICATOR ── --}}
    <div class="flex items-start">
        @php
            $steps = [
                ['tab'=>'matriks',     'label'=>'Matriks Keputusan'],
                ['tab'=>'normalisasi', 'label'=>'Normalisasi'],
                ['tab'=>'saw',         'label'=>'Perhitungan SAW'],
            ];
            $order = ['matriks'=>1,'normalisasi'=>2,'saw'=>3];
            $current = $order[$tab];
        @endphp
        @foreach($steps as $idx => $step)
            @php $num = $idx+1; $isActive = $tab === $step['tab']; $isDone = $num < $current; @endphp
            <a href="{{ route('admin.saw.index') }}?tab={{ $step['tab'] }}" class="flex flex-col items-center min-w-0">
                <div class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-black transition-all
                    {{ $isActive ? 'bg-[#B87A3D] text-white' : ($isDone ? 'bg-[#C9A876] text-white' : 'bg-[#EFE0C2] text-[#9a8068]') }}">
                    {{ $isDone ? '✓' : $num }}
                </div>
                <span class="text-[11px] font-semibold mt-1.5 text-center
                    {{ $isActive ? 'text-[#B87A3D]' : ($isDone ? 'text-[#C9A876]' : 'text-gray-400') }}">
                    {{ $step['label'] }}
                </span>
            </a>
            @if($idx < count($steps)-1)
                <div class="step-line"></div>
            @endif
        @endforeach
    </div>

    {{-- ==================== MATRIKS ==================== --}}
    @if($tab === 'matriks')

    @php
        $bobotList = [
            ['label'=>'Harga',     'key'=>'harga',           'type'=>'Cost'],
            ['label'=>'Jarak',     'key'=>'jarak',           'type'=>'Cost'],
            ['label'=>'Fasilitas', 'key'=>'fasilitas',       'type'=>'Benefit'],
            ['label'=>'Durasi',    'key'=>'jam_operasional', 'type'=>'Benefit'],
            ['label'=>'Rating',    'key'=>'rating',          'type'=>'Benefit'],
            ['label'=>'Menu',      'key'=>'menu',            'type'=>'Benefit'],
        ];
        $bobotDefault = ['harga'=>0.20,'jarak'=>0.20,'fasilitas'=>0.20,'jam_operasional'=>0.15,'rating'=>0.10,'menu'=>0.15];
        $skalaRows = [
            5 => ['≤ Rp 25rb',   '< 1 km',    '≥ 4.8',    '9–10 fas', '7+ menu',  '21–24 jam'],
            4 => ['Rp 25–37.5rb','1–2 km',    '4.6–4.79', '7–8 fas',  '6 menu',   '16–20 jam'],
            3 => ['Rp 37.5–50rb','2–4 km',    '4.4–4.59', '5–6 fas',  '5 menu',   '11–15 jam'],
            2 => ['Rp 50–75rb',  '4–6 km',    '4.2–4.39', '3–4 fas',  '3–4 menu', '6–10 jam' ],
            1 => ['> Rp 75rb',   '> 6 km',    '< 4.2',    '1–2 fas',  '1–2 menu', '1–5 jam'  ],
        ];
    @endphp

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">

        {{-- Bobot Kriteria --}}
        <div class="bg-white border border-[#E8D9C0] rounded-2xl overflow-hidden">
            <div class="px-5 py-3 border-b border-[#E8D9C0]">
                <p class="text-xs font-black text-gray-500 uppercase tracking-widest">Bobot Kriteria</p>
            </div>
            <div class="divide-y divide-[#F0E4CC]">
                @foreach($bobotList as $b)
                @php
                    $w = isset($bobot) ? $bobot[$b['key']] : $bobotDefault[$b['key']];
                    $pct = round($w * 100);
                @endphp
                <div class="flex items-center gap-4 px-5 py-2.5">
                    <span class="w-20 text-sm font-semibold text-gray-700">{{ $b['label'] }}</span>
                    <span class="w-14 text-[10px] font-semibold text-gray-400">{{ $b['type'] }}</span>
                    <div class="flex-1 bg-[#F5ECD7] rounded-full h-1.5 overflow-hidden">
                        <div class="h-full rounded-full bg-[#C9A876]" style="width:{{ $pct * 4 }}%"></div>
                    </div>
                    <span class="w-8 text-sm font-black text-[#B87A3D] text-right">{{ $pct }}%</span>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Keterangan Skala --}}
        <div class="bg-white border border-[#E8D9C0] rounded-2xl overflow-hidden">
            <div class="px-5 py-3 border-b border-[#E8D9C0]">
                <p class="text-xs font-black text-gray-500 uppercase tracking-widest">Keterangan Skala (1–5)</p>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-xs">
                    <thead>
                        <tr class="bg-[#F5ECD7] text-gray-600">
                            <th class="px-4 py-2 text-left font-bold w-10">Skala</th>
                            <th class="px-3 py-2 text-left font-bold">Harga</th>
                            <th class="px-3 py-2 text-left font-bold">Jarak</th>
                            <th class="px-3 py-2 text-left font-bold">Rating</th>
                            <th class="px-3 py-2 text-left font-bold">Fasilitas</th>
                            <th class="px-3 py-2 text-left font-bold">Menu</th>
                            <th class="px-3 py-2 text-left font-bold">Durasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($skalaRows as $s => $cols)
                        <tr class="{{ $s % 2 === 0 ? 'bg-white' : 'bg-[#FAF5EC]' }}">
                            <td class="px-4 py-2 border-b border-[#EEE4D0] font-black text-gray-700">{{ $s }}</td>
                            @foreach($cols as $c)
                            <td class="px-3 py-2 border-b border-[#EEE4D0] text-gray-500">{{ $c }}</td>
                            @endforeach
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    {{-- Tabel matriks --}}
    <div class="bg-[#F5ECD7] rounded-3xl shadow-sm overflow-hidden dt-wrap">
        <div class="dt-toolbar">
            <div id="len-m"></div>
            <div class="dt-search-wrap">
                <svg class="srch-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                <div id="srch-m"></div>
            </div>
        </div>
        <table id="tabel-matriks" class="w-full text-sm">
            <thead>
                <tr>
                    <th class="text-center" style="width:48px">No</th>
                    <th>Nama Kafe</th>
                    <th class="text-center">Harga<br><span style="font-size:10px;font-weight:400;opacity:.8">(Cost)</span></th>
                    <th class="text-center">Jarak<br><span style="font-size:10px;font-weight:400;opacity:.8">(Cost)</span></th>
                    <th class="text-center">Fasilitas<br><span style="font-size:10px;font-weight:400;opacity:.8">(Benefit)</span></th>
                    <th class="text-center">Durasi<br><span style="font-size:10px;font-weight:400;opacity:.8">(Benefit)</span></th>
                    <th class="text-center">Rating<br><span style="font-size:10px;font-weight:400;opacity:.8">(Benefit)</span></th>
                    <th class="text-center">Menu<br><span style="font-size:10px;font-weight:400;opacity:.8">(Benefit)</span></th>
                </tr>
            </thead>
            <tbody>
                @foreach($matriks as $i => $item)
                <tr>
                    <td class="text-center">{{ $i + 1 }}</td>
                    <td class="font-medium">{{ $item['nama_kafe'] }}</td>
                    @foreach(['harga','jarak','fasilitas','durasi','rating','menu'] as $k)
                    <td class="text-center font-semibold text-gray-700">{{ $item[$k] }}</td>
                    @endforeach
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="dt-bottom"><div id="info-m"></div><div id="page-m"></div></div>
    </div>

    @endif


    {{-- ==================== NORMALISASI ==================== --}}
    @if($tab === 'normalisasi')

    {{-- Info normalisasi: 3 card sejajar --}}
    <div class="grid grid-cols-3 gap-3">
        {{-- Tujuan --}}
        <div class="bg-white border border-[#E8D9C0] rounded-2xl px-4 py-3">
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Tujuan Normalisasi</p>
            <p class="text-xs text-gray-500 leading-relaxed">
                Menyeragamkan skala nilai antar kriteria agar dapat dibandingkan secara adil dalam rentang <span class="font-semibold text-gray-700">0 hingga 1</span>, tanpa bias satuan.
            </p>
        </div>
        {{-- Benefit --}}
        <div class="bg-white border border-[#E8D9C0] rounded-2xl px-4 py-3">
            <div class="flex items-center gap-2 mb-2">
                <span class="w-5 h-5 rounded-md bg-emerald-100 text-emerald-700 font-black text-[10px] flex items-center justify-center flex-shrink-0">B</span>
                <p class="text-[10px] font-black text-gray-500 uppercase tracking-widest">Benefit</p>
            </div>
            <p class="font-mono text-sm font-black text-[#B87A3D] mb-1">Rij = Xij ÷ Max(Xij)</p>
            <p class="text-[11px] text-gray-400">Nilai <span class="text-gray-600 font-semibold">lebih tinggi = lebih baik</span>. Dibagi nilai maksimum kolom. Berlaku untuk: Fasilitas, Durasi, Rating, Menu.</p>
        </div>
        {{-- Cost --}}
        <div class="bg-white border border-[#E8D9C0] rounded-2xl px-4 py-3">
            <div class="flex items-center gap-2 mb-2">
                <span class="w-5 h-5 rounded-md bg-red-50 text-red-500 font-black text-[10px] flex items-center justify-center flex-shrink-0">C</span>
                <p class="text-[10px] font-black text-gray-500 uppercase tracking-widest">Cost</p>
            </div>
            <p class="font-mono text-sm font-black text-[#B87A3D] mb-1">Rij = Min(Xij) ÷ Xij</p>
            <p class="text-[11px] text-gray-400">Nilai <span class="text-gray-600 font-semibold">lebih rendah = lebih baik</span>. Dibagi ke nilai minimum kolom. Berlaku untuk: Harga, Jarak.</p>
        </div>
    </div>

    <div class="bg-[#F5ECD7] rounded-3xl shadow-sm overflow-hidden dt-wrap">
        <div class="dt-toolbar">
            <div id="len-n"></div>
            <div class="dt-search-wrap">
                <svg class="srch-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                <div id="srch-n"></div>
            </div>
        </div>
        <table id="tabel-normalisasi" class="w-full text-sm">
            <thead>
                <tr>
                    <th class="text-center" style="width:48px">No</th>
                    <th>Nama Kafe</th>
                    <th class="text-center">Harga<br><span style="font-size:10px;font-weight:400;opacity:.8">(Cost)</span></th>
                    <th class="text-center">Jarak<br><span style="font-size:10px;font-weight:400;opacity:.8">(Cost)</span></th>
                    <th class="text-center">Fasilitas<br><span style="font-size:10px;font-weight:400;opacity:.8">(Benefit)</span></th>
                    <th class="text-center">Durasi<br><span style="font-size:10px;font-weight:400;opacity:.8">(Benefit)</span></th>
                    <th class="text-center">Rating<br><span style="font-size:10px;font-weight:400;opacity:.8">(Benefit)</span></th>
                    <th class="text-center">Menu<br><span style="font-size:10px;font-weight:400;opacity:.8">(Benefit)</span></th>
                </tr>
            </thead>
            <tbody>
                @foreach($normalisasi as $i => $item)
                <tr>
                    <td class="text-center">{{ $i + 1 }}</td>
                    <td class="font-medium">{{ $item['nama'] }}</td>
                    @foreach(['harga','jarak','fasilitas','durasi','rating','menu'] as $k)
                    <td class="text-center font-mono text-xs">{{ number_format($item[$k], 2) }}</td>
                    @endforeach
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="dt-bottom"><div id="info-n"></div><div id="page-n"></div></div>
    </div>

    @endif


    {{-- ==================== PERHITUNGAN SAW ==================== --}}
    @if($tab === 'saw')

    @php
        $wLabel = ['Harga'=>'0.20','Jarak'=>'0.20','Fasilitas'=>'0.20','Durasi'=>'0.15','Rating'=>'0.10','Menu'=>'0.15'];
        if(isset($bobot)) {
            $wLabel = [
                'Harga'    => number_format($bobot['harga'],2),
                'Jarak'    => number_format($bobot['jarak'],2),
                'Fasilitas'=> number_format($bobot['fasilitas'],2),
                'Durasi'   => number_format($bobot['jam_operasional'],2),
                'Rating'   => number_format($bobot['rating'],2),
                'Menu'     => number_format($bobot['menu'],2),
            ];
        }
    @endphp

    {{-- Info SAW: formula + bobot sejajar --}}
    <div class="grid grid-cols-2 gap-3">
        {{-- Formula --}}
        <div class="bg-white border border-[#E8D9C0] rounded-2xl px-5 py-4">
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3">Formula Perhitungan</p>
            <div class="flex items-center gap-3 mb-3">
                <div class="bg-[#F5ECD7] rounded-xl px-4 py-2 font-mono font-black text-[#B87A3D] text-base whitespace-nowrap">
                    Vi = Σ (Wj × Rij)
                </div>
            </div>
            <div class="flex flex-col gap-1 text-xs text-gray-500">
                <div class="flex items-center gap-2">
                    <span class="w-5 h-5 rounded bg-[#F5ECD7] font-black text-[#B87A3D] text-[10px] flex items-center justify-center flex-shrink-0">Vi</span>
                    <span>Skor akhir kafe ke-<em>i</em> — dipakai untuk menentukan ranking</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-5 h-5 rounded bg-[#F5ECD7] font-black text-[#B87A3D] text-[10px] flex items-center justify-center flex-shrink-0">Wj</span>
                    <span>Bobot kriteria ke-<em>j</em> — total seluruh bobot = 1.00</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-5 h-5 rounded bg-[#F5ECD7] font-black text-[#B87A3D] text-[10px] flex items-center justify-center flex-shrink-0">Rij</span>
                    <span>Nilai normalisasi kafe <em>i</em> pada kriteria <em>j</em></span>
                </div>
            </div>
        </div>
        {{-- Bobot yang digunakan --}}
        <div class="bg-white border border-[#E8D9C0] rounded-2xl px-5 py-4">
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3">Bobot (Wj) yang Digunakan</p>
            <div class="grid grid-cols-3 gap-2">
                @foreach($wLabel as $nama => $w)
                <div class="bg-[#FAF5EC] border border-[#EEE4D0] rounded-xl px-3 py-2 flex flex-col items-center gap-0.5">
                    <span class="text-[10px] font-bold text-gray-500">{{ $nama }}</span>
                    <span class="text-sm font-black text-[#B87A3D]">{{ $w }}</span>
                </div>
                @endforeach
            </div>
            <p class="text-[10px] text-gray-400 mt-2">Setiap kolom W×R = Wj dikali nilai normalisasi kafe pada kriteria tersebut. Skor Vi = jumlah semua kolom W×R.</p>
        </div>
    </div>

    {{-- Tabel hasil --}}
    <div class="bg-[#F5ECD7] rounded-3xl shadow-sm overflow-hidden dt-wrap">
        <div class="dt-toolbar">
            <div id="len-s"></div>
            <div class="dt-search-wrap">
                <svg class="srch-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                <div id="srch-s"></div>
            </div>
        </div>
        <table id="tabel-saw" class="w-full text-sm">
            <thead>
                <tr>
                    <th class="text-center" style="width:48px">No</th>
                    <th>Nama Kafe</th>
                    <th class="text-center">Harga<br><span style="font-size:10px;font-weight:400;opacity:.8">W×R</span></th>
                    <th class="text-center">Jarak<br><span style="font-size:10px;font-weight:400;opacity:.8">W×R</span></th>
                    <th class="text-center">Fasilitas<br><span style="font-size:10px;font-weight:400;opacity:.8">W×R</span></th>
                    <th class="text-center">Durasi<br><span style="font-size:10px;font-weight:400;opacity:.8">W×R</span></th>
                    <th class="text-center">Rating<br><span style="font-size:10px;font-weight:400;opacity:.8">W×R</span></th>
                    <th class="text-center">Menu<br><span style="font-size:10px;font-weight:400;opacity:.8">W×R</span></th>
                    <th class="text-center">Skor (Vi)</th>
                    <th class="text-center" style="width:80px">Ranking</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $hasilSorted = collect($hasil)->sortByDesc('skor')->values();
                @endphp
                @foreach($hasil as $i => $item)
                @php
                    $rank = $hasilSorted->search(fn($d) => $d['nama_kafe'] === $item['nama_kafe']) + 1;

                    preg_match_all('/\(([\d.]+)×([\d.]+)\)/', $item['perhitungan'], $matches);
                    $komponen = [];
                    foreach ($matches[1] as $idx2 => $w) {
                        $r = $matches[2][$idx2];
                        $komponen[] = round((float)$w * (float)$r, 4);
                    }
                    $reorder = [0, 2, 3, 5, 1, 4];
                @endphp
                <tr>
                    <td class="text-center">{{ $i + 1 }}</td>
                    <td class="font-medium">{{ $item['nama_kafe'] }}</td>
                    @foreach($reorder as $ri)
                    <td class="text-center font-mono text-xs text-gray-600">
                        {{ isset($komponen[$ri]) ? number_format($komponen[$ri], 4) : '-' }}
                    </td>
                    @endforeach
                    <td class="text-center font-semibold text-gray-700">{{ number_format($item['skor'], 3) }}</td>
                    <td class="text-center font-semibold text-gray-700">{{ $rank }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="dt-bottom"><div id="info-s"></div><div id="page-s"></div></div>
    </div>

    @endif

</div>
@endsection

@push('scripts')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script>
$(function () {
    function buildTable(tableId, lenId, srchId, infoId, pageId) {
        if (!$(tableId).length) return;
        var dt = $(tableId).DataTable({
            pageLength : 10,
            lengthMenu : [10, 25, 50, 100],
            dom        : 'lrtip',
            language   : {
                search      : '',
                lengthMenu  : 'Tampilkan _MENU_ data',
                info        : 'Menampilkan _START_ - _END_ dari _TOTAL_ data',
                infoEmpty   : 'Menampilkan 0 data',
                infoFiltered: '(difilter dari _MAX_ data)',
                zeroRecords : 'Data tidak ditemukan',
                paginate    : { next: '›', previous: '‹' }
            }
        });
        var w = dt.table().container();
        $('#' + lenId ).append($(w).find('.dataTables_length'));
        $('#' + srchId).append($(w).find('.dataTables_filter input'));
        $('#' + infoId).append($(w).find('.dataTables_info'));
        $('#' + pageId).append($(w).find('.dataTables_paginate'));
        $('#' + srchId + ' input').attr('placeholder', 'Cari cafe...');
    }
    buildTable('#tabel-matriks',     'len-m', 'srch-m', 'info-m', 'page-m');
    buildTable('#tabel-normalisasi', 'len-n', 'srch-n', 'info-n', 'page-n');
    buildTable('#tabel-saw',         'len-s', 'srch-s', 'info-s', 'page-s');
});
</script>
@endpush