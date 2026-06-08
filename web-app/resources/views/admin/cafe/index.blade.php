@extends('layouts.admin')
@section('title', 'Data Alternatif — Ngafein Admin')
@section('content')
@section('breadcrumb')
    <x-admin.breadcrumb :links="[['label' => 'Data Alternatif', 'url' => route('admin.cafe.index')], ['label' => 'Daftar Kafe']]" />
@endsection
<div class="flex flex-col h-full space-y-6 pb-12" x-data="cafeManager()">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black tracking-tight text-gray-900">Data Alternatif</h1>
            <p class="mt-1 text-sm font-medium text-gray-500">Daftar cafe untuk perhitungan SAW</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.galeri.batch') }}"
                class="inline-flex items-center justify-center gap-2 rounded-lg border border-gray-200 bg-white px-4 py-2.5 text-sm font-bold text-gray-700 shadow-sm transition hover:bg-gray-50">
                <i data-lucide="image-plus" class="w-4 h-4 text-[#B87C39]"></i>
                Batch Upload Foto
            </a>
            <button @click="openImportModal()"
                class="inline-flex items-center justify-center gap-2 rounded-lg border border-gray-200 bg-white px-4 py-2.5 text-sm font-bold text-gray-700 shadow-sm transition hover:bg-gray-50">
                <i data-lucide="upload" class="w-4 h-4 text-[#B87C39]"></i>
                Import Excel
            </button>
            <button @click="openPanel('{{ route('admin.cafe.create') }}', 'add')"
                class="inline-flex items-center justify-center gap-2 rounded-lg bg-[#B87C39] px-4 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-[#6E4A22]">
                <i data-lucide="plus" class="w-4 h-4"></i>
                Tambah Cafe
            </button>
        </div>
    </div>
    <div class="bg-[#F5ECD7] rounded-[2rem] p-8 shadow-sm">
        <div class="flex items-center justify-between gap-3 mb-5">

            {{-- SEARCH --}}
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
                    x-model="search"
                    @input.debounce.300ms="fetchData()"
                    placeholder="Cari cafe..."
                    class="pl-9 pr-4 py-2 rounded-xl border border-[#D4B896] bg-white text-[13px] font-medium text-[#3d2f1f] placeholder-[#b0957a] outline-none focus:border-[#B87A3D] focus:ring-2 focus:ring-[#B87A3D]/20 transition-all w-56">
            </div>

            {{-- DROPDOWN --}}
            <div class="flex items-center gap-2">

                <label class="text-[13px] font-semibold text-[#5a4a35] whitespace-nowrap">
                    Tampilkan
                </label>

                <div class="relative">
                    <select
                        x-model="perPage"
                        @change="fetchData()"
                        class="bg-white border border-[#D4B896] rounded-xl pl-3 pr-8 py-2 text-[13px] font-semibold text-[#5a4a35] outline-none focus:border-[#B87A3D] focus:ring-2 focus:ring-[#B87A3D]/20 transition-all cursor-pointer appearance-none">

                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="110">semua</option>
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
        </div>        
        <div id="table-wrapper">
            @include('admin.cafe._table')
        </div>
    </div>
    @include('admin.cafe.partials.side-panel')

    {{-- Modal Import --}}
    <template x-teleport="body">
        <div x-show="importOpen" x-cloak
            class="fixed inset-0 z-[99999] flex items-center justify-center px-4"
            style="display: none;">
            
            <!-- Backdrop with full blur and smooth transition -->
            <div class="absolute inset-0 bg-black/60 backdrop-blur-md"
                 x-show="importOpen"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 @click="if (!importing) closeImportModal()"></div>
            
            <!-- Modal Card with smooth scale transition -->
            <div class="relative w-full max-w-md bg-white rounded-[2rem] border border-[#B87C39]/15 shadow-2xl p-8 z-10"
                x-show="importOpen"
                x-transition:enter="transition ease-out duration-300 transform"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-200 transform"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95">
                
                <button @click="closeImportModal()" :disabled="importing" 
                        class="absolute top-6 right-6 text-[#2B1A09]/40 hover:text-[#2B1A09] transition-colors cursor-pointer disabled:opacity-50">
                    <svg viewBox="0 0 24 24" class="w-5.5 h-5.5 fill-none stroke-current" stroke-width="2.5"><line x1="18" x2="6" y1="6" y2="18"/><line x1="6" x2="18" y1="6" y2="18"/></svg>
                </button>

                <div class="flex flex-col items-center mb-6">
                    <div class="w-12 h-12 rounded-2xl bg-[#B87C39]/10 text-[#B87C39] flex items-center justify-center mb-3">
                        <i data-lucide="file-spreadsheet" class="w-5.5 h-5.5"></i>
                    </div>
                    <h3 class="font-serif font-bold text-2xl text-[#2B1A09] text-center tracking-tight">Import Data Kafe</h3>
                    <p class="text-xs text-[#2B1A09]/60 mt-1.5 text-center font-medium">Unggah file Excel Anda untuk menambahkan daftar kafe</p>
                </div>

                <div class="space-y-5">
                    <div class="border-2 border-dashed border-[#B87C39]/20 bg-[#FCFAF8] hover:bg-[#B87C39]/5 rounded-2xl p-8 text-center transition-all duration-300 cursor-pointer relative group"
                        @click="$refs.fileInput.click()">
                        <input type="file" id="file-import-input" x-ref="fileInput" accept=".xlsx,.xls,.csv"
                            class="hidden" @change="importFile = $event.target.files[0]">
                        
                        <div class="flex flex-col items-center justify-center space-y-3">
                            <div class="w-10 h-10 rounded-full bg-white text-[#B87C39] flex items-center justify-center shadow-sm border border-gray-100/50 group-hover:scale-105 transition-transform duration-300">
                                <i data-lucide="upload-cloud" class="w-5 h-5"></i>
                            </div>
                            <div class="text-sm font-bold text-[#2B1A09]" x-text="importFile ? importFile.name : 'Pilih File Excel (.xlsx, .csv)'"></div>
                            <p class="text-[11px] font-medium text-gray-400" x-show="!importFile">Seret dan lepas file di sini, atau klik untuk menelusuri</p>
                        </div>
                    </div>

                    <div class="flex items-center justify-between text-[11px] text-gray-400 px-1">
                        <span>Format file harus sesuai dengan standar.</span>
                        <a href="{{ route('admin.cafe.template') }}" class="text-[#B87C39] hover:underline font-bold flex items-center gap-1">
                            <i data-lucide="download-cloud" class="w-3.5 h-3.5"></i>
                            Download Template
                        </a>
                    </div>

                    <div class="flex justify-end gap-3 pt-2">
                        <button @click="closeImportModal()" :disabled="importing" type="button"
                            class="px-5 py-2.5 text-xs font-bold text-gray-500 hover:text-[#2B1A09] hover:bg-gray-100/60 rounded-xl transition-all cursor-pointer">
                            Batal
                        </button>
                        <button @click="submitImport()" :disabled="importing || !importFile" type="button"
                            class="px-6 py-3 bg-[#B87C39] hover:bg-[#9a662e] text-white font-bold text-xs rounded-xl shadow-md shadow-[#B87C39]/10 transition-all flex items-center gap-2 cursor-pointer disabled:opacity-50">
                            <span x-show="importing" class="animate-spin inline-block w-4 h-4 border-2 border-white border-t-transparent rounded-full"></span>
                            <span x-text="importing ? 'Memproses...' : 'Mulai Import'"></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </template>
</div>
@push('scripts')
<script src="https://unpkg.com/lucide@latest"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function cafeManager() {
    return {
        search: '',
        perPage: 10,
        panelOpen: false,
        panelTitle: '',
        panelMode: 'add',
        loading: false,
        saving: false,
        importOpen: false,
        importing: false,
        importFile: null,
        openImportModal() {
            this.importOpen = true;
            this.importFile = null;
            if (document.getElementById('file-import-input')) {
                document.getElementById('file-import-input').value = '';
            }
        },
        closeImportModal() {
            this.importOpen = false;
            this.importing = false;
        },
        submitImport() {
            const input = document.getElementById('file-import-input');
            if (!input || !input.files[0]) {
                Alpine.store('toast').show('Silakan pilih file terlebih dahulu', 'error');
                return;
            }
            this.importing = true;
            const formData = new FormData();
            formData.append('file', input.files[0]);
            
            fetch('{{ route("admin.cafe.import") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(res => res.json())
            .then(data => {
                this.importing = false;
                if (data.success) {
                    this.closeImportModal();
                    this.fetchData();
                    Alpine.store('toast').show(data.message);
                } else {
                    Alpine.store('toast').show(data.message || 'Gagal mengimpor file', 'error');
                }
            })
            .catch(err => {
                this.importing = false;
                console.error(err);
                Swal.fire('Error', 'Terjadi kesalahan saat mengirim file', 'error');
            });
        },
        fetchData() {
            const url = new URL(window.location.href);
            url.searchParams.set('search', this.search);
            url.searchParams.set('per_page', this.perPage);
            url.searchParams.delete('page');
            fetch(url, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(res => res.text())
            .then(html => {
                document.getElementById('table-wrapper').innerHTML = html;
                if (window.lucide) lucide.createIcons();
            });
        },
        openPanel(url, mode) {
            this.panelMode = mode;
            this.panelOpen = true;
            this.loading = true;
            this.panelTitle = mode === 'add' ? 'Tambah Cafe Baru' : (mode === 'edit' ? 'Edit Data Cafe' : 'Detail Cafe');
            document.getElementById('panel-body-inner').innerHTML = '';
            fetch(url, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(res => res.text())
            .then(html => {
                document.getElementById('panel-body-inner').innerHTML = html;
                this.loading = false;
                if (window.lucide) lucide.createIcons();
            })
            .catch(err => {
                console.error(err);
                this.closePanel();
                Swal.fire('Error', 'Gagal memuat data', 'error');
            });
        },
        closePanel() {
            this.panelOpen = false;
        },
        submitForm() {
            const form = document.getElementById('form-cafe-panel');
            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }
            this.saving = true;
            const formData = new FormData(form);
            const mode = this.panelMode;
            let url = mode === 'add' ? '{{ route("admin.cafe.store") }}' : `{{ url("admin/cafe") }}/${formData.get('id_kafe')}`;
            if (mode === 'edit') {
                formData.append('_method', 'PUT');
            }
            fetch(url, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(res => res.json())
            .then(data => {
                this.saving = false;
                if (data.success) {
                    this.closePanel();
                    this.fetchData();
                    const msg = this.panelMode === 'add' ? 'Data Berhasil Disimpan!' : 'Data Berhasil Diubah!';
                    Alpine.store('toast').show(msg);
                } else {
                    Alpine.store('toast').show(data.message || 'Terjadi kesalahan sistem', 'error');
                }
            })
            .catch(err => {
                this.saving = false;
                console.error(err);
                Swal.fire('Error', 'Gagal mengirim data', 'error');
            });
        },
        deleteImage(id) {
            Alpine.store('confirm').show(
                'Hapus Foto?',
                'Foto akan dihapus permanen dari server dan tidak dapat dikembalikan.',
                () => {
                    fetch(`{{ url('admin/cafe/image') }}/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            document.getElementById(`img-container-${id}`).remove();
                            Alpine.store('toast').show('Foto Berhasil Dihapus!');
                        }
                    });
                },
                'danger',
                'trash-2'
            );
        },
        confirmDelete(id) {
            Alpine.store('confirm').show(
                'Hapus Kafe?', 
                'Semua data terkait termasuk gambar akan hilang secara permanen dari sistem.', 
                () => {
                    fetch(`{{ url('admin/cafe') }}/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            this.fetchData();
                            Alpine.store('toast').show('Cafe Berhasil Dihapus!');
                        }
                    });
                },
                'danger',
                'trash-2'
            );
        }
    }
}
function previewImages(event) {
    const previewContainer = document.getElementById('preview-gambar-baru');
    if (!previewContainer) return;
    previewContainer.innerHTML = ''; 
    const files = event.target.files;
    if (files) {
        [...files].forEach(file => {
            const reader = new FileReader();
            reader.onload = (e) => {
                const div = document.createElement('div');
                div.className = "relative aspect-square rounded-2xl overflow-hidden border border-[#b87c39]/30 shadow-sm animate-fade-in";
                div.innerHTML = `
                    <img src="${e.target.result}" class="w-full h-full object-cover">
                    <div class="absolute top-1 right-1 bg-[#b87c39] text-white p-1 rounded-full shadow-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>
                    </div>
                `;
                previewContainer.appendChild(div);
            };
            reader.readAsDataURL(file);
        });
    }
}
document.addEventListener("DOMContentLoaded", function () {
    if (window.lucide) lucide.createIcons();
});
</script>
@endpush
@endsection
