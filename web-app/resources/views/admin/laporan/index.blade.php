@extends('layouts.admin')

@section('title', 'Laporan Peringkat Rekomendasi SAW — Ngafein')

@section('breadcrumb')
    <x-admin.breadcrumb :links="[['label' => 'Laporan']]" />
@endsection

@section('content')
<div class="pb-16">
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
