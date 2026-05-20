@extends('layouts.admin')

@section('title', 'Data Admin - Ngafein Admin')

@section('breadcrumb')
    <x-admin.breadcrumb :links="[['label' => 'User Admin']]" />
@endsection

@section('content')
<div class="space-y-6 pb-12" x-data="userPage()" x-init="init()">
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-2xl font-black tracking-tight text-gray-900">Data Admin</h1>
            <p class="mt-1 text-sm font-medium text-gray-500">Kelola pengguna dengan hak akses admin pada sistem.</p>
        </div>
        <button type="button" @click="openCreate()" class="inline-flex items-center justify-center gap-2 rounded-lg bg-[#B87C39] px-4 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-[#6E4A22]">
            <i data-lucide="plus" class="h-4 w-4"></i>
            Tambah Admin
        </button>
    </div>

    <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
        <form method="GET" action="{{ route('admin.user.index') }}" class="mb-5 flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
            <div class="relative w-full md:max-w-sm">
                <i data-lucide="search" class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400"></i>
                <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama atau email" class="w-full rounded-lg border border-gray-200 bg-white py-2.5 pl-10 pr-4 text-sm font-medium text-gray-800 outline-none transition focus:border-[#B87C39] focus:ring-4 focus:ring-[#B87C39]/10">
            </div>
            <div class="flex items-center gap-2">
                <select name="per_page" class="rounded-lg border border-gray-200 bg-white px-3 py-2.5 text-sm font-semibold text-gray-700 outline-none transition focus:border-[#B87C39] focus:ring-4 focus:ring-[#B87C39]/10">
                    @foreach ([10, 25, 50] as $size)
                        <option value="{{ $size }}" @selected((int) request('per_page', 10) === $size)>{{ $size }} data</option>
                    @endforeach
                </select>
                <button type="submit" class="inline-flex items-center justify-center rounded-lg border border-[#B87C39] px-4 py-2.5 text-sm font-bold text-[#6E4A22] transition hover:bg-[#B87C39] hover:text-white">
                    Terapkan
                </button>
            </div>
        </form>

        @include('admin.user.partials.table')
    </div>

    @include('admin.user.partials.modal')
</div>

@push('scripts')
<script>
    function userPage() {
        return {
            showForm: false,
            formMode: 'create',
            formName: '',
            formEmail: '',
            formAction: @js(route('admin.user.store')),
            init() {
                this.$nextTick(() => {
                    lucide.createIcons();
                    @if (session('success'))
                        Alpine.store('toast').show(@js(session('success')), 'success');
                    @endif
                    @if (session('error'))
                        Alpine.store('toast').show(@js(session('error')), 'error');
                    @endif
                    @if ($errors->any())
                        Alpine.store('toast').show(@js($errors->first()), 'error');
                    @endif
                });
            },
            openCreate() {
                this.formMode = 'create';
                this.formName = '';
                this.formEmail = '';
                this.formAction = @js(route('admin.user.store'));
                this.showForm = true;
                this.$nextTick(() => lucide.createIcons());
            },
            openEdit(item) {
                this.formMode = 'edit';
                this.formName = item.name;
                this.formEmail = item.email;
                this.formAction = `/admin/user/${item.id}`;
                this.showForm = true;
                this.$nextTick(() => lucide.createIcons());
            },
            closeForm() {
                this.showForm = false;
            },
            confirmDelete(id, nama) {
                Alpine.store('confirm').show(
                    'Hapus Admin?',
                    `Admin "${nama}" akan dihapus permanen dari sistem.`,
                    () => {
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = `/admin/user/${id}`;
                        form.innerHTML = `
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="_method" value="DELETE">
                        `;
                        document.body.appendChild(form);
                        form.submit();
                    },
                    'danger',
                    'trash-2'
                );
            }
        }
    }
</script>
@endpush
@endsection
