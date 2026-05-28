@extends('layouts.user')

@section('title', 'Beranda')

@section('content')
    <!-- Hero Section -->
    @include('user.landing.sections.hero')

    <!-- Stats Panel -->
    @include('user.landing.sections.stats')

    <!-- Pilihan Kafe -->
    @include('user.landing.sections.featured')

    <!-- Eksplorasi Suasana (Bento) -->
    @include('user.landing.sections.bento-mood')

    <!-- Panduan Waktu -->
    @include('user.landing.sections.time-guide')

    <!-- Tips Ngopi -->
    @include('user.landing.sections.tips')
@endsection
