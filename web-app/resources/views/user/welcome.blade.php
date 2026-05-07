@extends('layouts.user')

@section('title', 'Beranda')

@section('content')
    <!-- Hero Section -->
    @include('user.landing.hero')

    <!-- Stats Panel -->
    @include('user.landing.stats')

    <!-- Main Content Container -->
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 pb-40 flex flex-col gap-28 md:gap-36">
        
        <!-- Pilihan Kafe -->
        @include('user.landing.featured')

        <!-- Eksplorasi Suasana (Bento) -->
        @include('user.landing.bento-mood')

        <!-- Panduan Waktu -->
        @include('user.landing.time-guide')

        <!-- Tips Ngopi -->
        @include('user.landing.tips')

    </div>
@endsection
