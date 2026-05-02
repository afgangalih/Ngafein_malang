@extends('layouts.admin')

@section('content')
    <x-admin.common.page-breadcrumb pageTitle="User Profile" />
    <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] lg:p-6">
        <h3 class="mb-5 text-lg font-semibold text-gray-800 dark:text-white/90 lg:mb-7">Profile</h3>
        <x-admin.profile.profile-card />
        <x-admin.profile.personal-info-card />
        <x-admin.profile.address-card />
    </div>
@endsection




