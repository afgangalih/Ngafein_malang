@extends('layouts.admin')

@section('title', 'Data Fasilitas - Ngafein Admin')

@section('breadcrumb')
    <x-admin.breadcrumb :links="[['label' => 'Data Alternatif', 'url' => route('admin.cafe.index')], ['label' => 'Fasilitas Kafe']]" />
@endsection

@section('content')
<div class="space-y-6 pb-12" x-data="fasilitasPage()" x-init="init()">

    {{-- ── HEADER ── --}}
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-2xl font-black tracking-tight text-gray-900">Data Fasilitas</h1>
            <p class="mt-1 text-sm font-medium text-gray-500">Kelola fasilitas yang tersedia pada data alternatif kafe.</p>
        </div>
        <button type="button" @click="openCreate()" class="inline-flex items-center justify-center gap-2 rounded-lg bg-[#B87C39] px-4 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-[#6E4A22]">
            <i data-lucide="plus" class="h-4 w-4"></i>
            Tambah Fasilitas
        </button>
    </div>

    {{-- ── MAIN CARD (persis seperti Data Kriteria) ── --}}
    <div class="bg-[#F5ECD7] rounded-[2rem] p-8 shadow-sm">

        {{-- toolbar: search kiri, per-page kanan --}}
        <form method="GET" action="{{ route('admin.fasilitas.index') }}" class="flex items-center justify-between gap-3 mb-5">
            <div class="relative">
                <svg class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-[#b0957a]"
                     xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari fasilitas..."
                    oninput="clearTimeout(this.delay); this.delay = setTimeout(() => this.form.submit(), 500)"
                    class="pl-9 pr-4 py-2 rounded-xl border border-[#D4B896] bg-white text-[13px] font-medium text-[#3d2f1f] placeholder-[#b0957a] outline-none focus:border-[#B87A3D] focus:ring-2 focus:ring-[#B87A3D]/20 transition-all w-56">            
            </div>
                    
            <div class="flex items-center gap-2">
                <label class="text-[13px] font-semibold text-[#5a4a35] whitespace-nowrap">
                    Tampilkan
                </label>

                <div class="relative">
                    <select
                        name="per_page"
                        onchange="this.form.submit()"
                        class="bg-white border border-[#D4B896] rounded-xl pl-3 pr-8 py-2 text-[13px] font-semibold text-[#5a4a35] outline-none focus:border-[#B87A3D] focus:ring-2 focus:ring-[#B87A3D]/20 transition-all cursor-pointer appearance-none">
                        <option value="10"  @selected(request('per_page', '10') === '10')>10</option>
                        <option value="all" @selected(request('per_page') === 'all')>Semua</option>
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

        {{-- table --}}
        <div class="rounded-2xl overflow-hidden border border-[#D4B896]">
            <table class="w-full text-left" style="border-collapse:collapse">
                <thead>
                    <tr>
                        <th class="text-center" style="width:56px;background:#C9A876;color:#fff;font-size:13px;font-weight:700;padding:12px 16px;border:none">No</th>
                        <th style="background:#C9A876;color:#fff;font-size:13px;font-weight:700;padding:12px 16px;border:none">Nama Fasilitas</th>
                        <th class="text-center" style="width:150px;background:#C9A876;color:#fff;font-size:13px;font-weight:700;padding:12px 16px;border:none">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($fasilitas as $index => $item)
                        <tr style="{{ $index % 2 === 0 ? 'background:#F5ECD7' : 'background:#EFE0C2' }};border-bottom:1px solid #D4B896;transition:background .15s"
                            onmouseenter="this.style.background='#DFC9A0'"
                            onmouseleave="this.style.background='{{ $index % 2 === 0 ? '#F5ECD7' : '#EFE0C2' }}'">

                            <td class="text-center"
                                style="padding:10px 16px;font-size:13px;font-weight:700;color:#7a6248;border-bottom:1px solid #D4B896">
                                {{ $fasilitas->firstItem() + $loop->index }}
                            </td>

                            <td style="padding:10px 16px;font-size:13px;font-weight:700;color:#3d2f1f;border-bottom:1px solid #D4B896">
                                {{ $item->nama_fasilitas }}
                            </td>

                            <td class="text-center" style="padding:10px 16px;border-bottom:1px solid #D4B896">
                                <div class="flex justify-center items-center gap-3">
                                    <button
                                        type="button"
                                        @click="openEdit({ id: {{ $item->id_fasilitas }}, nama: @js($item->nama_fasilitas) })"
                                        class="flex items-center gap-1.5 px-3 py-1.5 bg-white text-[#B87C39] hover:bg-[#B87C39] hover:text-white rounded-xl text-xs font-bold transition-all border border-[#B87C39] cursor-pointer">
                                        <i data-lucide="pencil" class="w-3.5 h-3.5"></i>
                                        <span>Edit</span>
                                    </button>
                                    <button
                                        type="button"
                                        @click="confirmDelete({{ $item->id_fasilitas }}, @js($item->nama_fasilitas))"
                                        class="flex items-center gap-1.5 px-3 py-1.5 bg-red-50 text-red-500 hover:bg-red-500 hover:text-white rounded-xl text-xs font-bold transition-all border border-red-200 cursor-pointer">
                                        <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                        <span>Hapus</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" style="padding:40px 16px;text-align:center;font-size:13px;font-weight:600;color:#9a8068">
                                Belum ada data fasilitas.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- showing entries --}}
        <p class="text-[13px] text-gray-500 mt-4 px-1">
            Menampilkan {{ $fasilitas->firstItem() ?? 0 }} - {{ $fasilitas->lastItem() ?? 0 }} dari {{ $fasilitas->total() }} data
        </p>

        {{-- pagination --}}
        @if ($fasilitas->hasPages())
        <div class="mt-3 flex items-center gap-1">
            @if ($fasilitas->onFirstPage())
                <span style="padding:4px 10px;border-radius:8px;font-size:13px;font-weight:700;color:#c9b99a;cursor:not-allowed">‹</span>
            @else
                <a href="{{ $fasilitas->previousPageUrl() }}" style="padding:4px 10px;border-radius:8px;font-size:13px;font-weight:700;color:#7a6248;transition:background .15s" onmouseenter="this.style.background='#E8D5B5'" onmouseleave="this.style.background='transparent'">‹</a>
            @endif

            @foreach ($fasilitas->getUrlRange(1, $fasilitas->lastPage()) as $page => $url)
                @if ($page == $fasilitas->currentPage())
                    <span style="padding:4px 10px;border-radius:8px;font-size:13px;font-weight:700;background:#B87C39;color:#fff">{{ $page }}</span>
                @else
                    <a href="{{ $url }}" style="padding:4px 10px;border-radius:8px;font-size:13px;font-weight:700;color:#7a6248;transition:background .15s" onmouseenter="this.style.background='#E8D5B5'" onmouseleave="this.style.background='transparent'">{{ $page }}</a>
                @endif
            @endforeach

            @if ($fasilitas->hasMorePages())
                <a href="{{ $fasilitas->nextPageUrl() }}" style="padding:4px 10px;border-radius:8px;font-size:13px;font-weight:700;color:#7a6248;transition:background .15s" onmouseenter="this.style.background='#E8D5B5'" onmouseleave="this.style.background='transparent'">›</a>
            @else
                <span style="padding:4px 10px;border-radius:8px;font-size:13px;font-weight:700;color:#c9b99a;cursor:not-allowed">›</span>
            @endif
        </div>
        @endif

    </div>

    {{-- ── MODAL FORM (Create / Edit) — tidak diubah sama sekali ── --}}
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

            <div class="absolute inset-0 bg-black/60 backdrop-blur-md" @click="closeForm()"></div>

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
                    <h3 class="font-serif font-bold text-2xl text-[#2B1A09] text-center tracking-tight" x-text="formMode === 'create' ? 'Tambah Fasilitas' : 'Edit Fasilitas'"></h3>
                    <p class="text-xs text-[#2B1A09]/60 mt-1.5 text-center font-medium">Pastikan nama fasilitas yang ditambahkan bersifat unik</p>
                </div>

                <form method="POST" :action="formAction" class="space-y-5">
                    @csrf
                    <template x-if="formMode === 'edit'">
                        <input type="hidden" name="_method" value="PUT">
                    </template>
                    <div>
                        <label for="nama_fasilitas" class="block text-[11px] font-bold text-[#2B1A09] uppercase tracking-wider mb-1.5">Nama Fasilitas</label>
                        <input
                            id="nama_fasilitas"
                            name="nama_fasilitas"
                            type="text"
                            x-model="formNama"
                            required
                            placeholder="Masukkan nama fasilitas..."
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

        </div>
    </template>
</div>

@push('scripts')
<script>
    function fasilitasPage() {
        return {
            showForm: false,
            showDelete: false,
            formMode: 'create',
            formNama: '',
            formAction: @js(route('admin.fasilitas.store')),
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
                this.formAction = @js(route('admin.fasilitas.store'));
                this.showForm = true;
                this.$nextTick(() => lucide.createIcons());
            },
            openEdit(item) {
                this.formMode = 'edit';
                this.formNama = item.nama;
                this.formAction = `/admin/fasilitas/${item.id}`;
                this.showForm = true;
                this.$nextTick(() => lucide.createIcons());
            },
            closeForm() {
                this.showForm = false;
            },
            confirmDelete(id, nama) {
                Alpine.store('confirm').show(
                    'Hapus Fasilitas?',
                    `Data fasilitas "${nama}" akan dihapus permanen dari sistem.`,
                    () => {
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = `/admin/fasilitas/${id}`;
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