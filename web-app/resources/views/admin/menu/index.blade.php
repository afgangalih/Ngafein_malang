@extends('layouts.admin')

@section('title', 'Data Menu - Ngafein Admin')

@section('breadcrumb')
    <x-admin.breadcrumb :links="[['label' => 'Data Alternatif', 'url' => route('admin.cafe.index')], ['label' => 'Kategori Menu']]" />
@endsection

@section('content')
<div class="flex flex-col space-y-6 pb-12" x-data="menuPage()" x-init="init()">

    {{-- page header --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-[1.5rem] font-black text-gray-900 tracking-tight">
                Data Menu
            </h1>

            <p class="text-gray-500 text-[14px] font-medium mt-1">
                Kelola kategori menu yang tersedia pada data alternatif kafe.
            </p>
        </div>

        <button
            type="button"
            @click="openCreate()"
            class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#B87C39] px-5 py-3 text-sm font-bold text-white shadow-sm transition hover:bg-[#6E4A22]">

            <i data-lucide="plus" class="h-4 w-4"></i>
            Tambah Kategori Menu
        </button>
    </div>

    {{-- main card --}}
    <div class="bg-[#F5ECD7] rounded-[2rem] p-8 shadow-sm">

        {{-- HEADER --}}
        <div class="flex items-center justify-between gap-3 mb-5">

            {{-- SEARCH --}}
            <form method="GET" action="{{ route('admin.menu.index') }}">

                <input
                    type="hidden"
                    name="per_page"
                    value="{{ request('per_page', '10') }}">

                <div class="relative">

                    <svg class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-[#b0957a]"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2.5">

                        <circle cx="11" cy="11" r="8"/>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                    </svg>

                    <input
                        type="text"
                        name="search"
                        value="{{ $search }}"
                        placeholder="Cari kategori menu..."
                        onkeyup="clearTimeout(window.searchTimer); window.searchTimer = setTimeout(() => this.form.submit(), 500)"
                        class="pl-9 pr-4 py-2 rounded-xl border border-[#D4B896] bg-white text-[13px] font-medium text-[#3d2f1f] placeholder-[#b0957a] outline-none focus:border-[#B87A3D] focus:ring-2 focus:ring-[#B87A3D]/20 transition-all w-56">
                </div>
            </form>

            {{-- DROPDOWN --}}
            <form method="GET" action="{{ route('admin.menu.index') }}">

                <input
                    type="hidden"
                    name="search"
                    value="{{ $search }}">

                <div class="flex items-center gap-2">

                    <label class="text-[13px] font-semibold text-[#5a4a35] whitespace-nowrap">
                        Tampilkan
                    </label>

                    <div class="relative">

                        <select
                            name="per_page"
                            onchange="this.form.submit()"
                            class="bg-white border border-[#D4B896] rounded-xl pl-3 pr-8 py-2 text-[13px] font-semibold text-[#5a4a35] outline-none focus:border-[#B87A3D] focus:ring-2 focus:ring-[#B87A3D]/20 transition-all cursor-pointer appearance-none">

                            <option value="10" @selected(request('per_page', '10') == '10')>
                                10
                            </option>

                            <option value="all" @selected(request('per_page') == 'all')>
                                Semua
                            </option>

                        </select>

                        <svg class="pointer-events-none absolute right-2.5 top-1/2 -translate-y-1/2 w-3 h-3 text-gray-400"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2.5">

                            <polyline points="6 9 12 15 18 9"/>
                        </svg>
                    </div>

                    <span class="text-[13px] font-semibold text-[#5a4a35] whitespace-nowrap">
                        data
                    </span>
                </div>
            </form>
        </div>

        {{-- TABLE --}}
        <div class="rounded-2xl overflow-hidden border border-[#D4B896]">

            <div class="overflow-x-auto">

                <table
                    class="w-full min-w-[650px] text-left"
                    style="border-collapse:collapse;table-layout:fixed">

                    <thead>
                        <tr>

                            <th class="text-center"
                                style="width:70px;background:#C9A876;color:#fff;font-size:13px;font-weight:700;padding:14px 16px;border:none">
                                No
                            </th>

                            <th
                                style="background:#C9A876;color:#fff;font-size:13px;font-weight:700;padding:14px 16px;border:none">
                                Nama Kategori Menu
                            </th>

                            <th class="text-center"
                                style="width:220px;background:#C9A876;color:#fff;font-size:13px;font-weight:700;padding:14px 16px;border:none">
                                Aksi
                            </th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse ($menus as $index => $item)

                            <tr
                                style="
                                    border-bottom:1px solid #D4B896;
                                    transition:background .15s;
                                    background: {{ $index % 2 == 0 ? '#F5ECD7' : '#EFE0C2' }}
                                "

                                onmouseover="this.style.background='#DFC9A0'"
                                onmouseout="this.style.background='{{ $index % 2 == 0 ? '#F5ECD7' : '#EFE0C2' }}'">

                                {{-- nomor --}}
                                <td class="text-center"
                                    style="padding:12px 16px;font-size:13px;font-weight:700;color:#7a6248;border-bottom:1px solid #D4B896">

                                    {{ $menus->firstItem() + $index }}
                                </td>

                                {{-- nama --}}
                                <td
                                    style="padding:12px 16px;font-size:13px;font-weight:700;color:#3d2f1f;border-bottom:1px solid #D4B896">

                                    {{ $item->nama_menu }}
                                </td>

                                {{-- aksi --}}
                                <td class="py-4 px-6 text-center border-b border-[#D4B896]">

                                    <div class="flex justify-center items-center gap-3">

                                        {{-- EDIT --}}
                                        <button
                                            type="button"
                                            @click="openEdit({
                                                id: {{ $item->id_menu }},
                                                nama: @js($item->nama_menu)
                                            })"
                                            class="flex items-center gap-1.5 px-3 py-1.5 bg-white text-[#B87A3D] hover:bg-[#B87A3D] hover:text-white rounded-xl text-xs font-bold transition-all border border-[#B87A3D] cursor-pointer">

                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="w-3.5 h-3.5"
                                                viewBox="0 0 24 24"
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="2"
                                                stroke-linecap="round"
                                                stroke-linejoin="round">

                                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                            </svg>

                                            Edit
                                        </button>

                                        {{-- HAPUS --}}
                                        <button
                                            type="button"
                                            @click="confirmDelete({{ $item->id_menu }}, @js($item->nama_menu))"
                                            class="flex items-center gap-1.5 px-3 py-1.5 bg-red-50 text-red-500 hover:bg-red-500 hover:text-white rounded-xl text-xs font-bold transition-all border border-red-200 cursor-pointer">

                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="w-3.5 h-3.5"
                                                viewBox="0 0 24 24"
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="2"
                                                stroke-linecap="round"
                                                stroke-linejoin="round">

                                                <polyline points="3 6 5 6 21 6"/>
                                                <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                                                <path d="M10 11v6M14 11v6"/>
                                                <path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/>
                                            </svg>

                                            Hapus
                                        </button>

                                    </div>
                                </td>
                            </tr>

                        @empty

                            <tr>
                                <td colspan="3"
                                    class="text-center py-10 text-sm font-semibold text-gray-500 bg-[#F5ECD7]">

                                    Belum ada data kategori menu.
                                </td>
                            </tr>

                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- PAGINATION --}}
        <div class="mt-5 flex flex-col gap-3 md:flex-row md:items-center md:justify-between">

            <p class="text-[13px] text-gray-500 px-1">
                Menampilkan
                {{ $menus->firstItem() ?? 0 }} -
                {{ $menus->lastItem() ?? 0 }}
                dari
                {{ $menus->total() }} data
            </p>

            <div class="flex items-center gap-1">

                {{-- prev --}}
                @if ($menus->onFirstPage())

                    <span class="px-3 py-1.5 rounded-lg text-sm font-bold text-gray-300 cursor-not-allowed">
                        &lsaquo;
                    </span>

                @else

                    <a href="{{ $menus->previousPageUrl() }}"
                        class="px-3 py-1.5 rounded-lg text-sm font-bold text-[#B87C39] hover:bg-[#B87C39]/10 transition">

                        &lsaquo;
                    </a>

                @endif

                @php
                    $last = $menus->lastPage();
                    $current = $menus->currentPage();
                @endphp

                {{-- page --}}
                @for ($i = 1; $i <= min(5, $last); $i++)

                    @if ($i == $current)

                        <span class="px-3 py-1.5 rounded-lg text-sm font-bold bg-[#B87C39] text-white">
                            {{ $i }}
                        </span>

                    @else

                        <a href="{{ $menus->url($i) }}"
                            class="px-3 py-1.5 rounded-lg text-sm font-bold text-gray-600 hover:bg-[#B87C39]/10 hover:text-[#B87C39] transition">

                            {{ $i }}
                        </a>

                    @endif

                @endfor

                {{-- next --}}
                @if ($menus->hasMorePages())

                    <a href="{{ $menus->nextPageUrl() }}"
                        class="px-3 py-1.5 rounded-lg text-sm font-bold text-[#B87C39] hover:bg-[#B87C39]/10 transition">

                        &rsaquo;
                    </a>

                @else

                    <span class="px-3 py-1.5 rounded-lg text-sm font-bold text-gray-300 cursor-not-allowed">
                        &rsaquo;
                    </span>

                @endif
            </div>
        </div>
    </div>

    {{-- MODAL --}}
    <template x-teleport="body">
        <div
            x-show="showForm"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-[99999] flex items-center justify-center px-4"
            style="display:none;">

            {{-- backdrop --}}
            <div class="absolute inset-0 bg-black/60 backdrop-blur-md" @click="closeForm()"></div>

            {{-- modal --}}
            <div
                x-show="showForm"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                class="relative w-full max-w-md bg-white rounded-[2rem] border border-[#B87C39]/15 shadow-2xl p-8 z-10 animate-fade-up">

                <button type="button" @click="closeForm()" 
                        class="absolute top-6 right-6 text-[#2B1A09]/40 hover:text-[#2B1A09] transition-colors cursor-pointer">
                    <svg viewBox="0 0 24 24" class="w-5.5 h-5.5 fill-none stroke-current" stroke-width="2.5"><line x1="18" x2="6" y1="6" y2="18"/><line x1="6" x2="18" y1="6" y2="18"/></svg>
                </button>

                <div class="flex flex-col items-center mb-6">
                    <div class="w-12 h-12 rounded-2xl bg-[#B87C39]/10 text-[#B87C39] flex items-center justify-center mb-3">
                        <i :data-lucide="formMode === 'create' ? 'plus-circle' : 'pencil'" class="w-5.5 h-5.5"></i>
                    </div>
                    <h3 class="font-serif font-bold text-2xl text-[#2B1A09] text-center tracking-tight" x-text="formMode === 'create' ? 'Tambah Kategori' : 'Edit Kategori'"></h3>
                    <p class="text-xs text-[#2B1A09]/60 mt-1.5 text-center font-medium">Pastikan nama kategori menu yang ditambahkan bersifat unik</p>
                </div>

                <form method="POST" :action="formAction" class="space-y-5">
                    @csrf
                    <template x-if="formMode === 'edit'">
                        <input type="hidden" name="_method" value="PUT">
                    </template>
                    <div>
                        <label for="nama_menu" class="block text-[11px] font-bold text-[#2B1A09] uppercase tracking-wider mb-1.5">Nama Kategori Menu</label>
                        <input
                            id="nama_menu"
                            name="nama_menu"
                            type="text"
                            x-model="formNama"
                            required
                            placeholder="Masukkan nama kategori menu..."
                            class="w-full bg-gray-50/50 border border-gray-200 rounded-xl px-5 py-3 text-sm outline-none focus:border-[#B87C39] focus:ring-1 focus:ring-[#B87C39] transition-all text-[#2B1A09]">
                    </div>
                    <div class="flex justify-end gap-3 pt-2">
                        <button type="button" @click="closeForm()" 
                            class="px-5 py-2.5 text-xs font-bold text-gray-500 hover:text-[#2B1A09] hover:bg-gray-100/60 rounded-xl transition-all cursor-pointer">
                            Batal
                        </button>
                        <button type="submit" 
                            class="px-6 py-3 bg-[#B87C39] hover:bg-[#9a662e] text-white font-bold text-xs rounded-xl shadow-md shadow-[#B87C39]/10 transition-all cursor-pointer">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </template>
</div>

@push('scripts')
<script>
    function menuPage() {
        return {
            showForm: false,
            formMode: 'create',
            formNama: '',
            formAction: @js(route('admin.menu.store')),

            init() {
                this.$nextTick(() => {
                    lucide.createIcons();

                    @if (session('success'))
                        Alpine.store('toast').show(
                            @js(session('success')),
                            'success'
                        );
                    @endif

                    @if ($errors->any())
                        Alpine.store('toast').show(
                            @js($errors->first()),
                            'error'
                        );
                    @endif
                });
            },

            openCreate() {
                this.formMode = 'create';
                this.formNama = '';
                this.formAction = @js(route('admin.menu.store'));
                this.showForm = true;

                this.$nextTick(() => lucide.createIcons());
            },

            openEdit(item) {
                this.formMode = 'edit';
                this.formNama = item.nama;
                this.formAction = `/admin/menu/${item.id}`;
                this.showForm = true;

                this.$nextTick(() => lucide.createIcons());
            },

            closeForm() {
                this.showForm = false;
            },

            confirmDelete(id, nama) {
                Alpine.store('confirm').show(
                    'Hapus Kategori Menu?',
                    `Data kategori menu "${nama}" akan dihapus permanen dari sistem.`,
                    () => {
                        const form = document.createElement('form');

                        form.method = 'POST';
                        form.action = `/admin/menu/${id}`;

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