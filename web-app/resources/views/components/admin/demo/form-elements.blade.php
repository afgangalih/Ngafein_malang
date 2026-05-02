@extends('layouts.admin')

@section('content')
    <x-admin.common.page-breadcrumb pageTitle="From Elements" />
    <div class="grid grid-cols-1 gap-6 xl:grid-cols-2">
        <div class="space-y-6">
            @include('components.admin.form.form-elements.default-inputs')
            @include('components.admin.form.form-elements.select-inputs')
            @include('components.admin.form.form-elements.text-area-inputs')
            @include('components.admin.form.form-elements.input-states')
        </div>
        <div class="space-y-6">
            @include('components.admin.form.form-elements.input-group')
            @include('components.admin.form.form-elements.file-input-example')
            @include('components.admin.form.form-elements.checkbox-component')
            @include('components.admin.form.form-elements.radio-buttons')
            @include('components.admin.form.form-elements.toggle-switch')
            @include('components.admin.form.form-elements.dropzone')
        </div>
    </div>
@endsection




