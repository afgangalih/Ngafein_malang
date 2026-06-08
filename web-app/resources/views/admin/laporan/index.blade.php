@extends('layouts.admin')

@section('title', 'Laporan Peringkat Rekomendasi SAW — Ngafein')

@section('breadcrumb')
    <x-admin.breadcrumb :links="[['label' => 'Laporan']]" />
@endsection

@section('content')
<div class="pb-16" x-data="{ showExcelPreview: false, showPdfPreview: false }">
    <div class="no-print mb-7">
        <h1 class="text-3xl font-black tracking-tight leading-tight" style="color:#111;">Laporan Hasil Peringkat Rekomendasi Kafe</h1>
        <p class="text-sm mt-1.5" style="color:#111;">Hasil akhir perhitungan Simple Additive Weighting (SAW) — dokumen siap cetak dan ekspor.</p>
    </div>

    @include('admin.laporan.partials.filter-bar')

    <div id="printable-paper" class="mt-6 bg-white max-w-5xl mx-auto" style="border-radius:1.25rem; padding:3rem 3.5rem; border:1.5px solid #F3D9B5;">
        @include('admin.laporan.partials.paper-header')
        @include('admin.laporan.partials.paper-summary')
        @include('admin.laporan.partials.ranking-table')
    </div>

    {{-- Modal Excel Preview --}}
    <template x-teleport="body">
        <div x-show="showExcelPreview" x-cloak
             class="fixed inset-0 z-[99999] flex items-center justify-center px-4"
             style="display: none;">
            
            <!-- Backdrop with full blur and smooth transition -->
            <div class="absolute inset-0 bg-black/60 backdrop-blur-md"
                 x-show="showExcelPreview"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 @click="showExcelPreview = false"></div>
            
            <!-- Modal Card with smooth scale transition -->
            <div class="relative w-full max-w-4xl bg-white rounded-[2rem] border border-[#B87C39]/15 shadow-2xl p-8 z-10 flex flex-col max-h-[85vh]"
                x-show="showExcelPreview"
                x-transition:enter="transition ease-out duration-300 transform"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-200 transform"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95">
                
                <!-- Close Button -->
                <button @click="showExcelPreview = false" 
                        class="absolute top-6 right-6 text-[#2B1A09]/40 hover:text-[#2B1A09] transition-colors cursor-pointer">
                    <svg viewBox="0 0 24 24" class="w-5.5 h-5.5 fill-none stroke-current" stroke-width="2.5"><line x1="18" x2="6" y1="6" y2="18"/><line x1="6" x2="18" y1="6" y2="18"/></svg>
                </button>

                <!-- Header -->
                <div class="flex flex-col items-center mb-6">
                    <div class="w-12 h-12 rounded-2xl bg-[#B87C39]/10 text-[#B87C39] flex items-center justify-center mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                    </div>
                    <h3 class="font-serif font-bold text-2xl text-[#2B1A09] text-center tracking-tight">Pratinjau Dokumen Excel</h3>
                    <p class="text-xs text-[#2B1A09]/60 mt-1.5 text-center font-medium">Pratinjau isi lembar kerja (spreadsheet) sebelum diekspor ke file Excel</p>
                </div>

                <!-- Content Area (Excel Spreadsheet Interface) -->
                <div class="flex-1 overflow-x-auto mb-6 rounded-t-lg border border-[#c8c6c4] bg-white max-h-[45vh] custom-scrollbar">
                    <table class="w-full text-left border-collapse min-w-[850px]" style="table-layout: fixed; border-spacing: 0; font-family: Calibri, Arial, sans-serif;">
                        <thead>
                            <!-- Column Letters Row (A, B, C...) -->
                            <tr style="background: #f3f2f1; user-select: none;">
                                <th style="width: 40px; border: 1px solid #d2d0ce; background: #e1dfdd; text-align: center; font-size: 11px; font-weight: normal; color: #323130; padding: 4px 0;"></th>
                                <th style="border: 1px solid #d2d0ce; text-align: center; font-size: 11px; font-weight: normal; color: #323130; padding: 4px 0; width: 80px;">A</th>
                                <th style="border: 1px solid #d2d0ce; text-align: center; font-size: 11px; font-weight: normal; color: #323130; padding: 4px 0; width: 220px;">B</th>
                                <th style="border: 1px solid #d2d0ce; text-align: center; font-size: 11px; font-weight: normal; color: #323130; padding: 4px 0; width: 250px;">C</th>
                                <th style="border: 1px solid #d2d0ce; text-align: center; font-size: 11px; font-weight: normal; color: #323130; padding: 4px 0; width: 80px;">D</th>
                                <th style="border: 1px solid #d2d0ce; text-align: center; font-size: 11px; font-weight: normal; color: #323130; padding: 4px 0; width: 100px;">E</th>
                                <th style="border: 1px solid #d2d0ce; text-align: center; font-size: 11px; font-weight: normal; color: #323130; padding: 4px 0; width: 180px;">F</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Row 1: Header Row in Excel sheet -->
                            <tr style="background: white;">
                                <td style="border: 1px solid #d2d0ce; background: #f3f2f1; text-align: center; font-size: 11px; color: #323130; font-weight: normal; padding: 6px 0;">1</td>
                                <td style="border: 1px solid #d2d0ce; font-weight: bold; font-size: 12px; color: black; padding: 6px 10px;">Peringkat</td>
                                <td style="border: 1px solid #d2d0ce; font-weight: bold; font-size: 12px; color: black; padding: 6px 10px;">Nama Kafe</td>
                                <td style="border: 1px solid #d2d0ce; font-weight: bold; font-size: 12px; color: black; padding: 6px 10px;">Alamat</td>
                                <td style="border: 1px solid #d2d0ce; font-weight: bold; font-size: 12px; color: black; padding: 6px 10px; text-align: center;">Rating</td>
                                <td style="border: 1px solid #d2d0ce; font-weight: bold; font-size: 12px; color: black; padding: 6px 10px; text-align: center;">Skor SAW (V)</td>
                                <td style="border: 1px solid #d2d0ce; font-weight: bold; font-size: 12px; color: black; padding: 6px 10px;">Kategori Rekomendasi</td>
                            </tr>
                            
                            <!-- Data Rows (Spreadsheet Rows 2, 3, 4...) -->
                            @foreach($hasil as $index => $item)
                                @php
                                    $skor = $item['skor'];
                                    $kategori = 'Cukup';
                                    if ($skor >= 0.85) {
                                        $kategori = 'Sangat Direkomendasikan';
                                    } elseif ($skor >= 0.70) {
                                        $kategori = 'Direkomendasikan';
                                    }
                                @endphp
                                <tr style="background: white;">
                                    <td style="border: 1px solid #d2d0ce; background: #f3f2f1; text-align: center; font-size: 11px; color: #323130; padding: 6px 0; user-select: none;">{{ $index + 2 }}</td>
                                    <td style="border: 1px solid #d2d0ce; font-size: 12px; color: #333; padding: 6px 10px; text-align: center;">{{ $index + 1 }}</td>
                                    <td style="border: 1px solid #d2d0ce; font-size: 12px; color: #333; padding: 6px 10px;">{{ $item['nama_kafe'] }}</td>
                                    <td style="border: 1px solid #d2d0ce; font-size: 12px; color: #333; padding: 6px 10px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $item['alamat'] ?: '—' }}</td>
                                    <td style="border: 1px solid #d2d0ce; font-size: 12px; color: #333; padding: 6px 10px; text-align: center;">{{ number_format($item['rating'], 1) }}</td>
                                    <td style="border: 1px solid #d2d0ce; font-size: 12px; color: #333; padding: 6px 10px; text-align: center;">{{ number_format($skor, 3) }}</td>
                                    <td style="border: 1px solid #d2d0ce; font-size: 12px; color: #333; padding: 6px 10px;">{{ $kategori }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Simple Sheet Tab Bar like Excel -->
                <div class="flex items-center bg-[#f3f2f1] border-x border-b border-[#c8c6c4] px-4 py-1.5 -mt-6 mb-6 rounded-b-lg text-xs font-medium text-[#323130] gap-4" style="font-family: 'Segoe UI', sans-serif; user-select: none;">
                    <div class="flex items-center gap-1 bg-white border border-[#c8c6c4] border-b-transparent px-3 py-1 text-[#107c41] font-bold rounded-t-sm" style="margin-bottom: -7px; border-bottom: 2px solid #107c41;">
                        <span>Laporan SAW</span>
                    </div>
                    <div class="text-gray-400">|</div>
                    <div class="text-gray-500 hover:text-black">+ Ready</div>
                </div>

                <!-- Modal Footer Actions -->
                <div class="flex justify-end gap-3 pt-2">
                    <button @click="showExcelPreview = false" type="button"
                        class="px-5 py-2.5 text-xs font-bold text-gray-500 hover:text-[#2B1A09] hover:bg-gray-100/60 rounded-xl transition-all cursor-pointer">
                        Batal
                    </button>
                    <a href="{{ route('admin.laporan.excel', ['limit' => $limit]) }}" @click="showExcelPreview = false"
                        class="px-6 py-3 bg-[#B87C39] hover:bg-[#9a662e] text-white font-bold text-xs rounded-xl shadow-md shadow-[#B87C39]/10 transition-all flex items-center gap-2 cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                        <span>Download Excel</span>
                    </a>
                </div>
            </div>
        </div>
    </template>

    {{-- Modal PDF/Document Preview --}}
    <template x-teleport="body">
        <div x-show="showPdfPreview" x-cloak
             class="fixed inset-0 z-[99999] flex items-center justify-center px-4"
             style="display: none;">
            
            <!-- Backdrop with full blur and smooth transition -->
            <div class="absolute inset-0 bg-black/60 backdrop-blur-md"
                 x-show="showPdfPreview"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 @click="showPdfPreview = false"></div>
            
            <!-- Modal Card with smooth scale transition -->
            <div class="relative w-full max-w-4xl bg-white rounded-[2rem] border border-[#B87C39]/15 shadow-2xl p-8 z-10 flex flex-col max-h-[90vh]"
                x-show="showPdfPreview"
                x-transition:enter="transition ease-out duration-300 transform"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-200 transform"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95">
                
                <!-- Close Button -->
                <button @click="showPdfPreview = false" 
                        class="absolute top-6 right-6 text-[#2B1A09]/40 hover:text-[#2B1A09] transition-colors cursor-pointer">
                    <svg viewBox="0 0 24 24" class="w-5.5 h-5.5 fill-none stroke-current" stroke-width="2.5"><line x1="18" x2="6" y1="6" y2="18"/><line x1="6" x2="18" y1="6" y2="18"/></svg>
                </button>

                <!-- Header -->
                <div class="flex flex-col items-center mb-6">
                    <div class="w-12 h-12 rounded-2xl bg-[#6E4A22]/10 text-[#6E4A22] flex items-center justify-center mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 01-2-2v-5a2 2 0 012-2h16a2 2 0 012 2v5a2 2 0 01-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
                    </div>
                    <h3 class="font-serif font-bold text-2xl text-[#2B1A09] text-center tracking-tight">Pratinjau Dokumen Cetak / PDF</h3>
                    <p class="text-xs text-[#2B1A09]/60 mt-1.5 text-center font-medium">Pratinjau tata letak kertas A4 (Word/PDF) sebelum dicetak atau disimpan</p>
                </div>

                <!-- Document Page Layout Area (A4 Simulation) -->
                <div class="flex-1 overflow-y-auto mb-6 p-6 bg-[#f3f2f1] rounded-2xl border border-gray-200 max-h-[50vh] custom-scrollbar">
                    <!-- A4 Sheet Container -->
                    <div class="bg-white shadow-md border border-gray-300 max-w-2xl mx-auto p-12 text-black" style="font-family: 'Times New Roman', Times, serif; min-height: 800px;">
                        
                        <!-- Paper Header -->
                        <div style="border-bottom: 2px solid #000; padding-bottom: 12px; margin-bottom: 20px; text-align: center;">
                            <p style="font-size: 14pt; font-weight: bold; text-transform: uppercase; margin: 0 0 4px; letter-spacing: 0.5px;">LAPORAN HASIL PEMERINGKATAN REKOMENDASI KAFE</p>
                            <p style="font-size: 11pt; font-weight: bold; margin: 0 0 4px;">METODE SIMPLE ADDITIVE WEIGHTING (SAW)</p>
                            <p style="font-size: 10pt; color: #333; margin: 4px 0 0;">Sistem Ngafein &nbsp;·&nbsp; Kota Malang</p>
                            <p style="font-size: 9pt; color: #555; margin: 2px 0 0;">Dicetak: {{ \Carbon\Carbon::now()->isoFormat('D MMMM YYYY, HH:mm') }} WIB</p>
                        </div>

                        <!-- Content Summary (Weights) -->
                        <div style="font-size: 10pt; margin-bottom: 15px; line-height: 1.4; color: #333;">
                            <p style="margin: 0 0 8px; font-weight: bold;">Kriteria & Bobot Perhitungan:</p>
                            <table style="width: 100%; border-collapse: collapse; font-size: 9.5pt; margin-bottom: 15px;">
                                <thead>
                                    <tr style="border-bottom: 1px solid #000; border-top: 1px solid #000;">
                                        <th style="padding: 4px 0; text-align: left; width: 60%;">Nama Kriteria</th>
                                        <th style="padding: 4px 0; text-align: center; width: 20%;">Jenis</th>
                                        <th style="padding: 4px 0; text-align: right; width: 20%;">Bobot (W)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr style="border-bottom: 1px dashed #ccc;">
                                        <td style="padding: 4px 0;">Harga Menu (C1)</td>
                                        <td style="padding: 4px 0; text-align: center;">Cost</td>
                                        <td style="padding: 4px 0; text-align: right;">{{ number_format($bobot['harga'] ?? 0.20, 2) }}</td>
                                    </tr>
                                    <tr style="border-bottom: 1px dashed #ccc;">
                                        <td style="padding: 4px 0;">Rating Pengunjung (C2)</td>
                                        <td style="padding: 4px 0; text-align: center;">Benefit</td>
                                        <td style="padding: 4px 0; text-align: right;">{{ number_format($bobot['rating'] ?? 0.10, 2) }}</td>
                                    </tr>
                                    <tr style="border-bottom: 1px dashed #ccc;">
                                        <td style="padding: 4px 0;">Jarak Lokasi (C3)</td>
                                        <td style="padding: 4px 0; text-align: center;">Cost</td>
                                        <td style="padding: 4px 0; text-align: right;">{{ number_format($bobot['jarak'] ?? 0.20, 2) }}</td>
                                    </tr>
                                    <tr style="border-bottom: 1px dashed #ccc;">
                                        <td style="padding: 4px 0;">Ketersediaan Fasilitas (C4)</td>
                                        <td style="padding: 4px 0; text-align: center;">Benefit</td>
                                        <td style="padding: 4px 0; text-align: right;">{{ number_format($bobot['fasilitas'] ?? 0.20, 2) }}</td>
                                    </tr>
                                    <tr style="border-bottom: 1px dashed #ccc;">
                                        <td style="padding: 4px 0;">Variasi Menu (C5)</td>
                                        <td style="padding: 4px 0; text-align: center;">Benefit</td>
                                        <td style="padding: 4px 0; text-align: right;">{{ number_format($bobot['menu'] ?? 0.15, 2) }}</td>
                                    </tr>
                                    <tr style="border-bottom: 1px solid #000;">
                                        <td style="padding: 4px 0;">Jam Operasional (C6)</td>
                                        <td style="padding: 4px 0; text-align: center;">Benefit</td>
                                        <td style="padding: 4px 0; text-align: right;">{{ number_format($bobot['jam_operasional'] ?? 0.15, 2) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Formal Ranking Table -->
                        <table style="width: 100%; border-collapse: collapse; font-size: 10pt; margin-bottom: 25px;">
                            <thead>
                                <tr style="background: #f0f0f0; border-top: 1px solid #000; border-bottom: 1px solid #000;">
                                    <th style="border: 1px solid #333; padding: 6px; text-align: center; width: 8%;">No.</th>
                                    <th style="border: 1px solid #333; padding: 6px; text-align: left; width: 32%;">Nama Kafe</th>
                                    <th style="border: 1px solid #333; padding: 6px; text-align: left; width: 28%;">Alamat</th>
                                    <th style="border: 1px solid #333; padding: 6px; text-align: center; width: 10%;">Rating</th>
                                    <th style="border: 1px solid #333; padding: 6px; text-align: center; width: 10%;">Skor SAW</th>
                                    <th style="border: 1px solid #333; padding: 6px; text-align: center; width: 12%;">Predikat</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($hasil as $index => $item)
                                    @php
                                        $skor = $item['skor'];
                                        $predikat = 'Cukup';
                                        if ($skor >= 0.85)     $predikat = 'Sangat Direkomendasikan';
                                        elseif ($skor >= 0.70) $predikat = 'Direkomendasikan';
                                    @endphp
                                    <tr>
                                        <td style="border: 1px solid #999; padding: 5px; text-align: center; font-weight: bold;">{{ $index + 1 }}</td>
                                        <td style="border: 1px solid #999; padding: 5px; font-weight: bold;">{{ $item['nama_kafe'] }}</td>
                                        <td style="border: 1px solid #999; padding: 5px; font-size: 9pt;">{{ $item['alamat'] ?: '—' }}</td>
                                        <td style="border: 1px solid #999; padding: 5px; text-align: center;">{{ number_format($item['rating'], 1) }}</td>
                                        <td style="border: 1px solid #999; padding: 5px; text-align: center; font-weight: bold;">{{ number_format($skor, 3) }}</td>
                                        <td style="border: 1px solid #999; padding: 5px; text-align: center; font-size: 9pt;">{{ $predikat }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <!-- Signature Section -->
                        <div style="margin-top: 35px; border-top: 1px solid #999; padding-top: 10px;">
                            <table style="width: 100%; font-size: 10pt;">
                                <tr>
                                    <td style="width: 55%; vertical-align: top; color: #444; font-style: italic;">
                                        * Laporan dicetak menggunakan format dokumen A4 resmi.<br>
                                        * Hasil bersifat final dan valid pada tanggal cetak.
                                    </td>
                                    <td style="width: 45%; text-align: center; vertical-align: top;">
                                        <p style="margin: 0 0 50px;">Malang, {{ \Carbon\Carbon::now()->isoFormat('D MMMM YYYY') }}</p>
                                        <p style="margin: 0; font-weight: bold; border-top: 1px solid #000; display: inline-block; padding-top: 4px;">Administrator Ngafein</p>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Modal Footer Actions -->
                <div class="flex justify-end gap-3 pt-2">
                    <button @click="showPdfPreview = false" type="button"
                        class="px-5 py-2.5 text-xs font-bold text-gray-500 hover:text-[#2B1A09] hover:bg-gray-100/60 rounded-xl transition-all cursor-pointer">
                        Batal
                    </button>
                    <a href="{{ route('admin.laporan.print') }}" target="_blank" @click="showPdfPreview = false"
                        class="px-6 py-3 bg-[#B87C39] hover:bg-[#9a662e] text-white font-bold text-xs rounded-xl shadow-md shadow-[#B87C39]/10 transition-all flex items-center gap-2 cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 01-2-2v-5a2 2 0 012-2h16a2 2 0 012 2v5a2 2 0 01-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
                        <span>Cetak / PDF</span>
                    </a>
                </div>
            </div>
        </div>
    </template>
</div>

@endsection

@push('styles')
<style>
    @media print {
        aside, header, nav, footer, #sidebar, #navbar, .no-print, .screen-only {
            display: none !important;
        }

        html, body {
            background-color: white !important;
            margin: 0 !important;
            padding: 0 !important;
            color: black !important;
        }

        body > div,
        .flex, 
        .flex-col, 
        .min-h-screen, 
        .flex-1, 
        .xl\:ml-\[280px\], 
        .xl\:ml-\[80px\] {
            display: block !important;
            position: static !important;
            height: auto !important;
            min-height: 0 !important;
            margin: 0 !important;
            padding: 0 !important;
            transform: none !important;
            overflow: visible !important;
        }

        #printable-paper {
            display: block !important;
            width: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
            border: none !important;
            box-shadow: none !important;
            border-radius: 0 !important;
        }

        #printable-paper, #printable-paper * {
            font-family: 'Times New Roman', Times, serif !important;
            color: black !important;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }

        .print-only { display: block !important; }
        .print-only-table { display: table !important; }
        .print-only-row   { display: table-row !important; }
        .print-only-cell  { display: table-cell !important; }
    }

    .print-only { display: none; }
    .print-only-table { display: none; }
</style>
@endpush
