@extends('layouts.admin')
@section('title', 'Data Alternatif — Ngafein Admin')
@section('content')
@section('breadcrumb')
    <x-admin.breadcrumb :links="[['label' => 'Data Alternatif']]" />
@endsection
<div class="flex flex-col h-full space-y-6 pb-12" x-data="cafeManager()">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-[1.5rem] font-black text-gray-900">Data Alternatif</h1>
            <p class="text-gray-500 text-[13px] mt-1">Daftar cafe untuk perhitungan SAW</p>
        </div>
        <div class="flex gap-2">
            <button @click="openImportModal()"
                class="px-4 py-2.5 text-[#2B1A09] bg-white border border-[#D4B896] rounded-xl font-bold text-sm hover:bg-[#F5ECD7] flex items-center gap-2 shadow-sm transition-all active:scale-95">
                <i data-lucide="upload" class="w-4 h-4 text-[#B87C39]"></i>
                Import Excel
            </button>
            <button @click="openPanel('{{ route('admin.cafe.create') }}', 'add')"
                style="background-color: #b87c39;"
                class="px-4 py-2.5 text-white rounded-xl font-bold text-sm hover:brightness-90 flex items-center gap-2 shadow-sm transition-all active:scale-95">
                <i data-lucide="plus" class="w-4 h-4"></i>
                Tambah Cafe
            </button>
        </div>
    </div>
    <div class="bg-[#F5ECD7] rounded-[2rem] p-6 shadow-sm">
        <div class="flex flex-col gap-3 mb-6">
            <h2 class="text-[1.2rem] font-black text-gray-800">
                Tabel Alternatif
            </h2>
            <div class="flex justify-between items-center">
                <div class="flex items-center gap-2 text-[13px] font-bold text-gray-700">
                    <span>Tampilkan</span>
                    <select x-model="perPage" @change="fetchData()"
                        class="px-3 py-2 rounded-xl border bg-white text-[13px]">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                    <span>data</span>
                </div>
                <div class="relative">
                    <i data-lucide="search" class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <input type="text"
                        x-model="search"
                        @input.debounce.300ms="fetchData()"
                        placeholder="Cari cafe..."
                        class="pl-9 pr-4 py-2 rounded-xl border bg-white text-[13px] w-64 focus:ring-2 focus:ring-amber-500 outline-none">
                </div>
            </div>
        </div>
        <div id="table-wrapper">
            @include('admin.cafe._table')
        </div>
    </div>
    @include('admin.cafe.partials.side-panel')

    {{-- Modal Import --}}
    <div x-show="importOpen" x-cloak
        class="fixed inset-0 z-[100] flex items-center justify-center bg-black/50 backdrop-blur-sm"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0">
        
        <div class="bg-[#F5ECD7] rounded-3xl p-8 max-w-lg w-full mx-4 shadow-xl border border-[#D4B896]"
            @click.outside="if (!importing) closeImportModal()">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-black text-gray-900 tracking-tight">Import Data Kafe</h3>
                <button @click="closeImportModal()" :disabled="importing" class="text-gray-400 hover:text-gray-700 p-1 rounded-lg">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            <div class="space-y-6">
                <div class="border-2 border-dashed border-[#D4B896] bg-[#EFE0C2]/50 rounded-2xl p-8 text-center hover:border-[#B87C39] transition-colors cursor-pointer relative"
                    @click="$refs.fileInput.click()">
                    <input type="file" id="file-import-input" x-ref="fileInput" accept=".xlsx,.xls,.csv"
                        class="hidden" @change="importFile = $event.target.files[0]">
                    
                    <div class="flex flex-col items-center justify-center space-y-3">
                        <div class="w-12 h-12 rounded-full bg-[#B87C39]/10 flex items-center justify-center text-[#B87C39]">
                            <i data-lucide="file-spreadsheet" class="w-6 h-6"></i>
                        </div>
                        <div class="text-sm font-bold text-gray-800" x-text="importFile ? importFile.name : 'Pilih File Excel (.xlsx, .csv)'"></div>
                        <p class="text-xs font-medium text-gray-500" x-show="!importFile">Seret dan lepas file di sini, atau klik untuk menelusuri</p>
                    </div>
                </div>

                <div class="flex items-center justify-between text-xs text-gray-500 px-1 pt-1">
                    <span>Format file harus sesuai standar Ngafein.</span>
                    <a href="{{ route('admin.cafe.template') }}" class="text-[#B87C39] hover:underline font-bold flex items-center gap-1">
                        <i data-lucide="download" class="w-3.5 h-3.5"></i>
                        Download Template
                    </a>
                </div>

                <div class="flex justify-end gap-3 pt-2">
                    <button @click="closeImportModal()" :disabled="importing" type="button"
                        class="px-5 py-2.5 text-sm font-bold text-gray-600 hover:bg-gray-100 rounded-xl transition-colors">
                        Batal
                    </button>
                    <button @click="submitImport()" :disabled="importing || !importFile" type="button"
                        class="px-6 py-2.5 bg-[#B87C39] text-white font-bold rounded-xl shadow-sm hover:brightness-90 transition-all flex items-center gap-2 disabled:opacity-50">
                        <span x-show="importing" class="animate-spin inline-block w-4 h-4 border-2 border-white border-t-transparent rounded-full"></span>
                        <span x-text="importing ? 'Memproses...' : 'Mulai Import'"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>
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
