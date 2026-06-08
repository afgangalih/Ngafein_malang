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

    <div class="bg-[#F5ECD7] rounded-[2rem] p-8 shadow-sm">
        <form method="GET" action="{{ route('admin.user.index') }}" class="mb-5 flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
            <div class="relative">
                <svg class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-[#b0957a]"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama atau email..." class="pl-9 pr-4 py-2 rounded-xl border border-[#D4B896] bg-white text-[13px] font-medium text-[#3d2f1f] placeholder-[#b0957a] outline-none focus:border-[#B87A3D] focus:ring-2 focus:ring-[#B87A3D]/20 transition-all w-56">
            </div>
            
            <div class="flex items-center gap-2">
                <label class="text-[13px] font-semibold text-[#5a4a35] whitespace-nowrap">
                    Tampilkan
                </label>
                <div class="relative">
                    <select name="per_page" onchange="this.form.submit()" class="bg-white border border-[#D4B896] rounded-xl pl-3 pr-8 py-2 text-[13px] font-semibold text-[#5a4a35] outline-none focus:border-[#B87A3D] focus:ring-2 focus:ring-[#B87A3D]/20 transition-all cursor-pointer appearance-none">
                        @foreach ([10, 25, 50] as $size)
                            <option value="{{ $size }}" @selected((int) request('per_page', 10) === $size)>{{ $size }}</option>
                        @endforeach
                    </select>
                    <svg class="pointer-events-none absolute right-2.5 top-1/2 -translate-y-1/2 w-3 h-3 text-gray-400"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <polyline points="6 9 12 15 18 9"/>
                    </svg>
                </div>
                <span class="text-[13px] font-semibold text-[#5a4a35] whitespace-nowrap">
                    data
                </span>
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
