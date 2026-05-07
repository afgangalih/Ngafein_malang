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
