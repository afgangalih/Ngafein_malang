@extends('layouts.admin')

@section('title', 'Data Menu - Ngafein Admin')

@section('breadcrumb')
    <x-admin.breadcrumb :links="[['label' => 'Data Alternatif', 'url' => route('admin.cafe.index')], ['label' => 'Kategori Menu']]" />
@endsection

@section('content')
<div class="space-y-6 pb-12" x-data="menuPage()" x-init="init()">
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-2xl font-black tracking-tight text-gray-900">Data Menu</h1>
            <p class="mt-1 text-sm font-medium text-gray-500">Kelola kategori menu yang tersedia pada data alternatif kafe.</p>
        </div>
        <button type="button" @click="openCreate()" class="inline-flex items-center justify-center gap-2 rounded-lg bg-[#B87C39] px-4 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-[#6E4A22]">
            <i data-lucide="plus" class="h-4 w-4"></i>
            Tambah Kategori Menu
        </button>
    </div>



    <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
        <form method="GET" action="{{ route('admin.menu.index') }}" class="mb-5 flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
            <div class="relative w-full md:max-w-sm">
                <i data-lucide="search" class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400"></i>
                <input type="text" name="search" value="{{ $search }}" placeholder="Cari kategori menu" class="w-full rounded-lg border border-gray-200 bg-white py-2.5 pl-10 pr-4 text-sm font-medium text-gray-800 outline-none transition focus:border-[#B87C39] focus:ring-4 focus:ring-[#B87C39]/10">
            </div>
            <div class="flex items-center gap-2">
                <select name="per_page" onchange="this.form.submit()" class="rounded-lg border border-gray-200 bg-white px-3 py-2.5 text-sm font-semibold text-gray-700 outline-none transition focus:border-[#B87C39] focus:ring-4 focus:ring-[#B87C39]/10">
                    @foreach ([10, 25, 50] as $size)
                        <option value="{{ $size }}" @selected((int) request('per_page', 10) === $size)>{{ $size }} data</option>
                    @endforeach
                </select>
            </div>
        </form>

        <div class="overflow-hidden rounded-lg border border-gray-200">
            <div class="overflow-x-auto">
                <table class="w-full min-w-[680px] text-left">
                    <thead class="bg-[#6E4A22] text-white">
                        <tr>
                            <th class="w-20 px-5 py-3 text-center text-xs font-bold uppercase tracking-wide">No</th>
                            <th class="px-5 py-3 text-xs font-bold uppercase tracking-wide">Nama Kategori Menu</th>
                            <th class="w-56 px-5 py-3 text-center text-xs font-bold uppercase tracking-wide">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white">
                        @forelse ($menus as $item)
                            <tr class="transition hover:bg-[#B87C39]/5">
                                <td class="px-5 py-4 text-center text-sm font-bold text-gray-500">{{ $menus->firstItem() + $loop->index }}</td>
                                <td class="px-5 py-4 text-sm font-bold text-gray-900">{{ $item->nama_menu }}</td>
                                <td class="px-5 py-4">
                                    <div class="flex items-center justify-center gap-2">
                                        <button type="button" @click="openEdit({ id: {{ $item->id_menu }}, nama: @js($item->nama_menu) })" class="inline-flex items-center gap-1.5 rounded-lg border border-[#B87C39]/30 bg-white px-3 py-2 text-xs font-bold text-[#6E4A22] transition hover:border-[#B87C39] hover:bg-[#B87C39] hover:text-white">
                                            <i data-lucide="pencil" class="h-3.5 w-3.5"></i>
                                            Edit
                                        </button>
                                        <button type="button" @click="confirmDelete({{ $item->id_menu }}, @js($item->nama_menu))" class="inline-flex items-center gap-1.5 rounded-lg border border-red-200 bg-white px-3 py-2 text-xs font-bold text-red-600 transition hover:bg-red-600 hover:text-white">
                                            <i data-lucide="trash-2" class="h-3.5 w-3.5"></i>
                                            Hapus
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-5 py-10 text-center text-sm font-semibold text-gray-500">Belum ada data kategori menu.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-5 flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
            <p class="text-sm font-medium text-gray-500">
                Menampilkan {{ $menus->firstItem() ?? 0 }} - {{ $menus->lastItem() ?? 0 }} dari {{ $menus->total() }} data
            </p>
            <div class="flex items-center gap-1">
                @if ($menus->onFirstPage())
                    <span class="px-3 py-1.5 rounded-lg text-sm font-bold text-gray-300 cursor-not-allowed">&lsaquo;</span>
                @else
                    <a href="{{ $menus->previousPageUrl() }}" class="px-3 py-1.5 rounded-lg text-sm font-bold text-[#B87C39] hover:bg-[#B87C39]/10 transition">&lsaquo;</a>
                @endif

                @php
                    $last = $menus->lastPage();
                    $current = $menus->currentPage();
                @endphp

                @if ($last > 0)
                    @for ($i = 1; $i <= min(5, $last); $i++)
                        @if ($i == $current)
                            <span class="px-3 py-1.5 rounded-lg text-sm font-bold bg-[#B87C39] text-white">{{ $i }}</span>
                        @else
                            <a href="{{ $menus->url($i) }}" class="px-3 py-1.5 rounded-lg text-sm font-bold text-gray-600 hover:bg-[#B87C39]/10 hover:text-[#B87C39] transition">{{ $i }}</a>
                        @endif
                    @endfor

                    @if ($last > 5)
                        <span class="px-2 text-gray-400 text-sm">...</span>
                        <a href="{{ $menus->url($last) }}" class="px-3 py-1.5 rounded-lg text-sm font-bold text-gray-600 hover:bg-[#B87C39]/10 hover:text-[#B87C39] transition">{{ $last }}</a>
                    @endif
                @endif

                @if ($menus->hasMorePages())
                    <a href="{{ $menus->nextPageUrl() }}" class="px-3 py-1.5 rounded-lg text-sm font-bold text-[#B87C39] hover:bg-[#B87C39]/10 transition">&rsaquo;</a>
                @else
                    <span class="px-3 py-1.5 rounded-lg text-sm font-bold text-gray-300 cursor-not-allowed">&rsaquo;</span>
                @endif
            </div>
        </div>
    </div>

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
            style="display: none;">

            <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" @click="closeForm()"></div>

            <div
                x-show="showForm"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                class="relative w-full max-w-md rounded-xl bg-white p-6 shadow-2xl z-10">

                <div class="mb-5 flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-black text-gray-900" x-text="formMode === 'create' ? 'Tambah Kategori Menu' : 'Edit Kategori Menu'"></h2>
                        <p class="mt-1 text-sm font-medium text-gray-500">Nama kategori menu wajib unik.</p>
                    </div>
                    <button type="button" @click="closeForm()" class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-gray-200 text-gray-500 transition hover:bg-gray-50">
                        <i data-lucide="x" class="h-4 w-4"></i>
                    </button>
                </div>
                <form method="POST" :action="formAction" class="space-y-5">
                    @csrf
                    <template x-if="formMode === 'edit'">
                        <input type="hidden" name="_method" value="PUT">
                    </template>
                    <div>
                        <label for="nama_menu" class="mb-2 block text-sm font-bold text-gray-700">Nama Kategori Menu</label>
                        <input id="nama_menu" name="nama_menu" type="text" x-model="formNama" required class="w-full rounded-lg border border-gray-200 bg-white px-4 py-3 text-sm font-semibold text-gray-900 outline-none transition focus:border-[#B87C39] focus:ring-4 focus:ring-[#B87C39]/10">
                    </div>
                    <div class="flex justify-end gap-3">
                        <button type="button" @click="closeForm()" class="rounded-lg border border-gray-200 px-4 py-2.5 text-sm font-bold text-gray-600 transition hover:bg-gray-50">Batal</button>
                        <button type="submit" class="rounded-lg bg-[#B87C39] px-4 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-[#6E4A22]">Simpan</button>
                    </div>
                </form>
            </div>
        </div>

        </div>
    </template>
</div>

@push('scripts')
<script>
    function menuPage() {
        return {
            showForm: false,
            showDelete: false,
            formMode: 'create',
            formNama: '',
            formAction: @js(route('admin.menu.store')),
            deleteNama: '',
            deleteAction: '',
            init() {
                this.$nextTick(() => {
                    lucide.createIcons();
                    @if (session('success'))
                        Alpine.store('toast').show(@js(session('success')), 'success');
                    @endif
                    @if ($errors->any())
                        Alpine.store('toast').show(@js($errors->first()), 'error');
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
