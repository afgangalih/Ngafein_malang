@extends('layouts.admin')
@section('title', 'Batch Upload Foto Kafe — Ngafein Admin')

@section('breadcrumb')
    <x-admin.breadcrumb :links="[['label' => 'Data Alternatif', 'url' => route('admin.cafe.index')], ['label' => 'Batch Upload Foto']]" />
@endsection

@section('content')
<div class="flex flex-col h-full space-y-6 pb-12" x-data="batchUploadManager()" x-init="init()">
    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.cafe.index') }}" class="inline-flex items-center justify-center h-8 w-8 rounded-lg border border-gray-200 bg-white text-gray-500 hover:bg-gray-50 transition shadow-sm">
                    <i data-lucide="chevron-left" class="w-4 h-4"></i>
                </a>
                <h1 class="text-2xl font-black tracking-tight text-gray-900">Batch Upload Foto</h1>
            </div>
            <p class="mt-1 text-sm font-medium text-gray-500">Unggah beberapa foto untuk beberapa kafe sekaligus dalam antrean asinkron.</p>
        </div>
        <div class="flex items-center gap-3">
            <button type="button" @click="addRow()" :disabled="isUploading"
                class="inline-flex items-center justify-center gap-2 rounded-lg border border-gray-200 bg-white px-4 py-2.5 text-sm font-bold text-gray-700 shadow-sm transition hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed">
                <i data-lucide="plus" class="w-4 h-4 text-[#B87C39]"></i>
                Tambah Kafe
            </button>
            <button type="button" @click="startUpload()" :disabled="isUploading || rows.length === 0"
                class="inline-flex items-center justify-center gap-2 rounded-lg bg-[#B87C39] px-4 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-[#6E4A22] disabled:opacity-50 disabled:cursor-not-allowed">
                <template x-if="!isUploading">
                    <span class="flex items-center gap-2">
                        <i data-lucide="upload-cloud" class="w-4 h-4"></i>
                        Mulai Upload
                    </span>
                </template>
                <template x-if="isUploading">
                    <span class="flex items-center gap-2">
                        <svg class="animate-spin -ml-1 mr-3 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Mengunggah...
                    </span>
                </template>
            </button>
        </div>
    </div>

    {{-- Main Content --}}
    <div class="space-y-4">
        {{-- Empty State --}}
        <template x-if="rows.length === 0">
            <div class="flex flex-col items-center justify-center rounded-2xl border-2 border-dashed border-gray-200 bg-white p-12 text-center">
                <div class="w-16 h-16 rounded-full bg-[#B87C39]/10 flex items-center justify-center mb-4 text-[#B87C39]">
                    <i data-lucide="image" class="w-8 h-8"></i>
                </div>
                <h3 class="text-lg font-black text-gray-900 mb-1">Belum Ada Antrean Upload</h3>
                <p class="text-sm text-gray-500 max-w-sm mb-6">Silakan tambahkan baris kafe baru untuk mulai mengunggah foto secara masal.</p>
                <button type="button" @click="addRow()"
                    class="inline-flex items-center justify-center gap-2 rounded-lg bg-[#B87C39] px-4 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-[#6E4A22]">
                    <i data-lucide="plus" class="w-4 h-4"></i>
                    Tambah Baris Pertama
                </button>
            </div>
        </template>

        {{-- Rows List --}}
        <template x-for="(row, index) in rows" :key="row.id">
            <div class="rounded-xl border bg-white p-5 shadow-sm transition-all duration-300"
                :class="{
                    'border-gray-200': row.status === 'idle',
                    'border-amber-400 ring-4 ring-amber-400/10': row.status === 'uploading',
                    'border-green-400 bg-green-50/10': row.status === 'success',
                    'border-red-400 bg-red-50/10': row.status === 'error'
                }">
                <div class="flex flex-col lg:flex-row gap-5 items-start justify-between">
                    {{-- Form inputs --}}
                    <div class="flex-1 w-full grid grid-cols-1 md:grid-cols-12 gap-4">
                        {{-- Select Cafe --}}
                        <div class="md:col-span-4 relative" @click.outside="row.dropdownOpen = false">
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Pilih Kafe</label>
                            
                            <button type="button" @click="row.dropdownOpen = !row.dropdownOpen" :disabled="isUploading || row.status === 'success'"
                                class="w-full flex items-center justify-between rounded-lg border border-gray-200 bg-white px-3 py-2.5 text-sm font-semibold text-gray-850 outline-none transition focus:border-[#B87C39] focus:ring-4 focus:ring-[#B87C39]/10 disabled:bg-gray-50 disabled:text-gray-400">
                                <span x-text="cafes.find(c => c.id_kafe == row.id_kafe)?.nama_kafe || '-- Pilih Kafe --'"></span>
                                <i data-lucide="chevron-down" class="w-4 h-4 text-gray-400"></i>
                            </button>
                            
                            <div x-show="row.dropdownOpen" x-cloak
                                class="absolute z-20 mt-1 w-full rounded-lg border border-gray-200 bg-white shadow-lg py-2">
                                <div class="px-2 pb-2 border-b border-gray-100">
                                    <input type="text" x-model="row.searchQuery" placeholder="Cari kafe..."
                                        class="w-full rounded-md border border-gray-200 px-3 py-1.5 text-xs font-semibold text-gray-800 outline-none focus:border-[#B87C39]">
                                </div>
                                <div class="max-h-48 overflow-y-auto pt-1">
                                    <template x-for="cafe in cafes.filter(c => c.nama_kafe.toLowerCase().includes(row.searchQuery.toLowerCase()))" :key="cafe.id_kafe">
                                        <button type="button" @click="row.id_kafe = cafe.id_kafe; row.dropdownOpen = false; row.searchQuery = ''"
                                            class="w-full text-left px-3 py-2 text-xs font-semibold hover:bg-[#B87C39]/10 hover:text-[#B87C39] transition"
                                            :class="row.id_kafe == cafe.id_kafe ? 'bg-[#B87C39]/5 text-[#B87C39] font-bold' : 'text-gray-700'">
                                            <span x-text="cafe.nama_kafe"></span>
                                        </button>
                                    </template>
                                    <template x-if="cafes.filter(c => c.nama_kafe.toLowerCase().includes(row.searchQuery.toLowerCase())).length === 0">
                                        <div class="px-3 py-2 text-xs text-gray-400 italic">Kafe tidak ditemukan</div>
                                    </template>
                                </div>
                            </div>
                        </div>

                        {{-- Dropzone / File input --}}
                        <div class="md:col-span-8">
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Unggah Foto (Maks 3)</label>
                            <div class="flex flex-col sm:flex-row gap-3 items-start w-full">
                                {{-- Fake Input Button --}}
                                <div class="relative w-full sm:w-auto">
                                    <input type="file" multiple accept="image/*" 
                                        @change="handleFileChange($event, index)"
                                        :disabled="isUploading || row.status === 'success'"
                                        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer disabled:cursor-not-allowed z-10">
                                    <button type="button" :disabled="isUploading || row.status === 'success'"
                                        class="w-full sm:w-auto inline-flex items-center justify-center gap-2 rounded-lg border border-dashed border-gray-300 bg-gray-50 hover:bg-gray-100 px-4 py-2.5 text-sm font-bold text-gray-600 transition disabled:opacity-50">
                                        <i data-lucide="image-plus" class="w-4 h-4 text-gray-500"></i>
                                        Pilih File Gambar
                                    </button>
                                </div>

                                {{-- Image Previews --}}
                                <div class="flex-1 flex flex-wrap gap-2">
                                    <template x-for="(preview, pIdx) in row.previews" :key="pIdx">
                                        <div class="relative w-12 h-12 rounded-lg border border-gray-200 overflow-hidden shadow-sm animate-fade-in group">
                                            <img :src="preview" class="w-full h-full object-cover">
                                            <button type="button" @click="removeImage(index, pIdx)" :disabled="isUploading || row.status === 'success'"
                                                class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition duration-200">
                                                <i data-lucide="x" class="w-3.5 h-3.5 text-white"></i>
                                            </button>
                                        </div>
                                    </template>
                                    <template x-if="row.files.length === 0">
                                        <span class="text-xs text-gray-400 self-center font-medium italic">Belum ada gambar yang dipilih</span>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Actions and Status --}}
                    <div class="flex lg:flex-col items-end justify-between lg:justify-start gap-3 w-full lg:w-auto border-t lg:border-t-0 pt-4 lg:pt-0">
                        {{-- Status Badge --}}
                        <div class="flex items-center gap-2">
                            <template x-if="row.status === 'idle'">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-600">
                                    <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span> Ready
                                </span>
                            </template>
                            <template x-if="row.status === 'uploading'">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-800 animate-pulse">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Mengunggah
                                </span>
                            </template>
                            <template x-if="row.status === 'success'">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-green-100 text-green-800">
                                    <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Sukses
                                </span>
                            </template>
                            <template x-if="row.status === 'error'">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-red-100 text-red-800" :title="row.message">
                                    <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> Gagal
                                </span>
                            </template>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="flex items-center gap-2">
                            <button type="button" @click="removeRow(index)" :disabled="isUploading || row.status === 'success'"
                                class="inline-flex items-center justify-center p-2 rounded-lg border border-red-100 bg-red-50/50 text-red-600 hover:bg-red-100 transition disabled:opacity-50 disabled:cursor-not-allowed">
                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                            </button>
                        </div>
                    </div>
                </div>
                
                {{-- Error Message Display --}}
                <template x-if="row.status === 'error'">
                    <div class="mt-3 text-xs font-semibold text-red-600 flex items-center gap-1">
                        <i data-lucide="alert-circle" class="w-3.5 h-3.5"></i>
                        <span x-text="row.message"></span>
                    </div>
                </template>
            </div>
        </template>
    </div>
</div>

@push('scripts')
<script>
    function batchUploadManager() {
        return {
            rows: [],
            cafes: @js($cafes),
            isUploading: false,
            init() {
                // Tambahkan 1 baris pertama secara default
                this.addRow();
                this.$nextTick(() => { if(window.lucide) lucide.createIcons(); });
            },
            addRow() {
                this.rows.push({
                    id: Date.now() + Math.random(),
                    id_kafe: '',
                    dropdownOpen: false,
                    searchQuery: '',
                    files: [],
                    previews: [],
                    status: 'idle',
                    message: ''
                });
                this.$nextTick(() => { if(window.lucide) lucide.createIcons(); });
            },
            removeRow(index) {
                this.rows.splice(index, 1);
            },
            removeImage(rowIndex, imgIndex) {
                const row = this.rows[rowIndex];
                row.files.splice(imgIndex, 1);
                row.previews.splice(imgIndex, 1);
            },
            handleFileChange(event, index) {
                const files = event.target.files;
                const row = this.rows[index];
                if (!files || files.length === 0) return;

                const newFiles = Array.from(files);
                row.files = [...row.files, ...newFiles];

                if (row.files.length > 3) {
                    row.files = row.files.slice(0, 3);
                    if (window.Alpine && Alpine.store('toast')) {
                        Alpine.store('toast').show('Maksimal 3 file gambar per kafe!', 'error');
                    }
                }

                row.previews = [];
                row.files.forEach(file => {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        row.previews.push(e.target.result);
                    };
                    reader.readAsDataURL(file);
                });
            },
            async startUpload() {
                // Validasi data
                if (this.rows.length === 0) {
                    if (window.Alpine && Alpine.store('toast')) {
                        Alpine.store('toast').show('Antrean masih kosong!', 'error');
                    }
                    return;
                }

                const emptyCafe = this.rows.some(r => !r.id_kafe);
                if (emptyCafe) {
                    if (window.Alpine && Alpine.store('toast')) {
                        Alpine.store('toast').show('Harap pilih kafe untuk setiap baris!', 'error');
                    }
                    return;
                }

                const noFiles = this.rows.some(r => r.files.length === 0);
                if (noFiles) {
                    if (window.Alpine && Alpine.store('toast')) {
                        Alpine.store('toast').show('Harap pilih minimal 1 foto untuk setiap kafe!', 'error');
                    }
                    return;
                }

                this.isUploading = true;

                // Upload berurutan (Queue)
                for (let i = 0; i < this.rows.length; i++) {
                    const row = this.rows[i];
                    if (row.status === 'success') continue;

                    row.status = 'uploading';
                    
                    const formData = new FormData();
                    formData.append('id_kafe', row.id_kafe);
                    row.files.forEach(file => {
                        formData.append('images[]', file);
                    });

                    try {
                        const response = await fetch('{{ route("admin.galeri.batch.store") }}', {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        });

                        const data = await response.json();

                        if (response.ok && data.success) {
                            row.status = 'success';
                            row.message = '';
                        } else {
                            row.status = 'error';
                            row.message = data.message || 'Terjadi kesalahan saat mengunggah';
                        }
                    } catch (error) {
                        row.status = 'error';
                        row.message = 'Koneksi gagal atau terputus';
                    }
                }

                this.isUploading = false;
                this.$nextTick(() => { if(window.lucide) lucide.createIcons(); });

                const allSuccess = this.rows.every(r => r.status === 'success');
                if (allSuccess) {
                    if (window.Alpine && Alpine.store('toast')) {
                        Alpine.store('toast').show('Semua foto berhasil diunggah!', 'success');
                    }
                } else {
                    if (window.Alpine && Alpine.store('toast')) {
                        Alpine.store('toast').show('Beberapa unggahan gagal, silakan periksa kembali.', 'error');
                    }
                }
            }
        };
    }
</script>
@endpush
@endsection
