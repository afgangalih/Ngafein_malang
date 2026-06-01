@extends('layouts.admin')
@section('title', 'Detail Kafe — Ngafein Admin')

@section('breadcrumb')
    <x-admin.breadcrumb :links="[
        ['label' => 'Daftar Kafe', 'url' => route('admin.cafe.index')],
        ['label' => 'Detail Kafe']
    ]" />
@endsection

@section('content')
<div class="max-w-3xl mx-auto bg-white dark:bg-gray-900 rounded-[2rem] border border-gray-150/40 dark:border-gray-800 p-8 shadow-sm">
    <div class="flex items-center justify-between mb-8 pb-4 border-b border-gray-100 dark:border-gray-800">
        <h1 class="text-xl font-bold text-gray-900 dark:text-white">Detail Kafe</h1>
        <a href="{{ url()->previous() }}" class="px-4 py-2 border border-gray-200 rounded-xl text-xs font-bold text-gray-600 hover:bg-gray-50 transition-all">
            Kembali
        </a>
    </div>
    @include('admin.cafe.partials.detail')
</div>
@endsection
