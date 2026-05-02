@extends('layouts.admin')

@section('content')
    <x-admin.common.page-breadcrumb pageTitle="From Elements" />
    <div class="space-y-6">
        <x-admin.common.component-card title="Basic Table 1">
            @include('components.admin.tables.basic-tables.basic-tables-one')
        </x-common.component-card>
        <x-admin.common.component-card title="Basic Table 2">
            @include('components.admin.tables.basic-tables.basic-tables-two')
        </x-common.component-card>
        <x-admin.common.component-card title="Basic Table 3">
            @include('components.admin.tables.basic-tables.basic-tables-three')
        </x-common.component-card>
        <x-admin.common.component-card title="Basic Table 4">
            @include('components.admin.tables.basic-tables.basic-tables-four')
        </x-common.component-card>
        <x-admin.common.component-card title="Basic Table 5">
            @include('components.admin.tables.basic-tables.basic-tables-five')
        </x-common.component-card>
    </div>
@endsection




