@extends('layouts.admin')

@section('title', 'Data Kriteria — Ngafein Admin')

@section('content')
<div class="flex flex-col space-y-6 pb-12" x-data="kriteriaPage()">

    {{-- page header --}}
    <div class="flex flex-col">
        <h1 class="text-[1.5rem] font-black text-gray-900 tracking-tight">Data Kriteria</h1>
        <p class="text-gray-500 text-[14px] font-medium mt-1">Kriteria yang digunakan dalam metode SAW (Simple Additive Weighting) untuk pemilihan kafe.</p>
    </div>

    {{-- main card --}}
    <div class="bg-[#F5ECD7] rounded-[2rem] p-8 shadow-sm">

        {{-- card header --}}
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-[1.4rem] font-black text-gray-800 tracking-tight">Daftar Kriteria</h2>
        </div>

        {{-- table --}}
        <div class="bg-[#EFE0C2] rounded-2xl overflow-hidden border border-[#D4B896]">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-[#C9A876]">
                        <th class="py-5 px-8 text-[14px] font-bold text-white border-r border-[#B89060] text-center w-20">No</th>
                        <th class="py-5 px-8 text-[14px] font-bold text-white border-r border-[#B89060]">Nama Kriteria</th>
                        <th class="py-5 px-8 text-[14px] font-bold text-white border-r border-[#B89060] text-center">Bobot</th>
                        <th class="py-5 px-8 text-[14px] font-bold text-white border-r border-[#B89060] text-center">Tipe</th>
                        <th class="py-5 px-8 text-[14px] font-bold text-white text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody x-init="$nextTick(() => lucide.createIcons())">
                    <template x-for="(item, index) in kriteria" :key="item.id">
                        <tr class="border-b border-[#D4B896] hover:bg-[#DFC9A0] transition-colors"
                            :class="index % 2 === 0 ? 'bg-[#EFE0C2]' : 'bg-[#E8D5B5]'">

                            <td class="py-5 px-8 text-[15px] font-bold text-gray-500 border-r border-[#D4B896] text-center"
                                x-text="index + 1">
                            </td>

                            <td class="py-5 px-8 text-[15px] font-bold text-gray-800 border-r border-[#D4B896]"
                                x-text="item.nama">
                            </td>

                            <td class="py-5 px-8 text-[15px] text-gray-700 border-r border-[#D4B896] text-center font-semibold"
                                x-text="parseFloat(item.bobot).toFixed(2)">
                            </td>

                            <td class="py-5 px-8 border-r border-[#D4B896] text-center">
                                <span class="px-4 py-1.5 rounded-lg text-[13px] font-bold"
                                    :class="item.tipe === 'Benefit' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-600'"
                                    x-text="item.tipe">
                                </span>
                            </td>

                            <td class="py-5 px-8 text-center">
                                <div class="flex justify-center items-center gap-3">
                                    <button
                                        @click="openEdit(item.id, item.nama, item.bobot, item.tipe)"
                                        class="flex items-center gap-2 px-4 py-2 bg-blue-50 text-blue-500 hover:bg-blue-500 hover:text-white rounded-lg text-[13px] font-bold transition-all border border-blue-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                        </svg>
                                        Edit
                                    </button>
                                    <button
                                        @click="hapus(item.id)"
                                        class="flex items-center gap-2 px-4 py-2 bg-red-50 text-red-500 hover:bg-red-500 hover:text-white rounded-lg text-[13px] font-bold transition-all border border-red-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
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
                    </template>
                </tbody>
            </table>
        </div>

        {{-- showing entries --}}
        <p class="text-[13px] text-gray-500 mt-4 px-1">
            Menampilkan 1 - <span x-text="kriteria.length"></span> dari <span x-text="kriteria.length"></span> data
        </p>

        {{-- footer penjelasan --}}
        <div class="mt-6 space-y-2">
            <p class="text-[16px] font-bold text-gray-700">Penjelasan Tipe Kriteria:</p>
            <p class="text-[16px] text-gray-600">
                <span class="font-bold">Benefit</span>
                &nbsp;&nbsp;: Semakin besar nilai semakin baik (Contoh : Rating dan Jam)
            </p>
            <p class="text-[16px] text-gray-600">
                <span class="font-bold">Cost</span>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: Semakin kecil nilai semakin baik (Contoh : Harga dan Jarak)
            </p>
            <p class="text-[16px] text-gray-600">
                <span class="font-bold">Total Bobot</span>
                &nbsp;&nbsp;: <span class="font-bold" x-text="totalBobot().toFixed(2)"></span>
                <span x-show="totalBobot() < 1" class="text-orange-500 text-[14px] font-semibold ml-2">(kurang dari 1.00)</span>
                <span x-show="totalBobot() == 1" class="text-green-600 text-[14px] font-semibold ml-2">✓ (sudah pas)</span>
            </p>
        </div>

    </div>

    {{-- ======= MODAL EDIT ======= --}}
    <div
        x-show="showModal"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-[99999] flex items-center justify-center"
        style="display: none;">

        {{-- backdrop --}}
        <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" @click="closeModal()"></div>

        {{-- modal box --}}
        <div
            x-show="showModal"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="relative bg-[#F5ECD7] rounded-[2rem] shadow-2xl w-full max-w-md mx-4 p-8 z-10">

            {{-- modal header --}}
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 flex items-center justify-center bg-[#C9A876] rounded-xl">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-[18px] font-black text-gray-800">Edit Kriteria</h3>
                        <p class="text-[12px] text-gray-500 mt-0.5" x-text="'Mengubah data: ' + form.nama"></p>
                    </div>
                </div>
                <button @click="closeModal()"
                        class="w-9 h-9 flex items-center justify-center rounded-xl bg-gray-100 hover:bg-gray-200 transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="6" x2="6" y2="18"/>
                        <line x1="6" y1="6" x2="18" y2="18"/>
                    </svg>
                </button>
            </div>

            {{-- form --}}
            <div class="space-y-5">

                {{-- Nama Kriteria --}}
                <div class="flex flex-col gap-2">
                    <label class="text-[13px] font-bold text-gray-600 uppercase tracking-wider">Nama Kriteria</label>
                    <input
                        type="text"
                        x-model="form.nama"
                        class="w-full px-4 py-3 bg-[#E8D5B5] border-2 border-transparent rounded-xl text-[15px] text-gray-800 focus:outline-none focus:border-[#B87A3D]/50 focus:ring-4 focus:ring-[#B87A3D]/10 transition-all font-medium">
                    <p x-show="errorNama" x-text="errorNama"
                       class="text-[12px] text-red-600 bg-red-50 border border-red-200 rounded-lg px-3 py-2 font-semibold"></p>
                </div>

                {{-- Bobot --}}
                <div class="flex flex-col gap-2">
                    <label class="text-[13px] font-bold text-gray-600 uppercase tracking-wider">Bobot</label>
                    <input
                        type="number"
                        x-model="form.bobot"
                        step="0.01" min="0" max="1"
                        class="w-full px-4 py-3 bg-[#E8D5B5] border-2 border-transparent rounded-xl text-[15px] text-gray-800 focus:outline-none focus:border-[#B87A3D]/50 focus:ring-4 focus:ring-[#B87A3D]/10 transition-all font-medium">
                    <p x-show="errorBobot" x-text="errorBobot"
                       class="text-[12px] text-red-600 bg-red-50 border border-red-200 rounded-lg px-3 py-2 font-semibold"></p>
                    <p class="text-[12px] text-gray-400">
                        Nilai antara 0 dan 1. Sisa bobot tersedia:
                        <span class="font-bold text-gray-600" x-text="sisaBobot().toFixed(2)"></span>
                    </p>
                </div>

                {{-- Tipe --}}
                <div class="flex flex-col gap-2">
                    <label class="text-[13px] font-bold text-gray-600 uppercase tracking-wider">Tipe Kriteria</label>
                    <div class="flex gap-3">
                        <button type="button"
                                @click="form.tipe = 'Benefit'"
                                :class="form.tipe === 'Benefit'
                                    ? 'bg-green-500 text-white border-green-500 shadow-lg'
                                    : 'bg-[#E8D5B5] text-gray-600 border-[#D4B896]'"
                                class="flex-1 py-3 rounded-xl text-[14px] font-bold transition-all border-2">
                            ↑ Benefit
                        </button>
                        <button type="button"
                                @click="form.tipe = 'Cost'"
                                :class="form.tipe === 'Cost'
                                    ? 'bg-red-500 text-white border-red-500 shadow-lg'
                                    : 'bg-[#E8D5B5] text-gray-600 border-[#D4B896]'"
                                class="flex-1 py-3 rounded-xl text-[14px] font-bold transition-all border-2">
                            ↓ Cost
                        </button>
                    </div>
                </div>

                {{-- buttons --}}
                <div class="flex gap-3 pt-2">
                    <button
                        type="button"
                        @click="saveEdit()"
                        class="flex-1 flex items-center justify-center gap-2 py-3 bg-gradient-to-r from-[#B87A3D] to-[#A36A32] text-white rounded-xl font-bold text-[14px] hover:-translate-y-0.5 transition-all shadow-lg shadow-[#B87A3D]/20">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/>
                            <polyline points="17 21 17 13 7 13 7 21"/>
                            <polyline points="7 3 7 8 15 8"/>
                        </svg>
                        Simpan Perubahan
                    </button>
                    <button
                        type="button"
                        @click="closeModal()"
                        class="px-6 py-3 bg-white border border-gray-200 text-gray-600 rounded-xl font-bold text-[14px] hover:bg-gray-50 transition-all">
                        Batal
                    </button>
                </div>

            </div>
        </div>
    </div>

</div>

@push('scripts')
<script src="https://unpkg.com/lucide@latest"></script>
<script>
    lucide.createIcons();

    function kriteriaPage() {
        return {
            showModal: false,
            errorNama: '',
            errorBobot: '',

            form: {
                id: null,
                nama: '',
                bobot: '',
                tipe: ''
            },

            kriteria: @json($kriterias),

            totalBobot() {
                return this.kriteria.reduce((sum, k) => sum + parseFloat(k.bobot), 0);
            },

            sisaBobot() {
                const totalTanpaIni = this.kriteria
                    .filter(k => k.id !== this.form.id)
                    .reduce((sum, k) => sum + parseFloat(k.bobot), 0);
                return parseFloat((1 - totalTanpaIni).toFixed(10));
            },

            openEdit(id, nama, bobot, tipe) {
                this.form.id    = id;
                this.form.nama  = nama;
                this.form.bobot = bobot;
                this.form.tipe  = tipe;
                this.errorNama  = '';
                this.errorBobot = '';
                this.showModal  = true;
            },

            closeModal() {
                this.showModal  = false;
                this.errorNama  = '';
                this.errorBobot = '';
            },

            saveEdit() {
                const nama  = this.form.nama.trim();
                const bobot = parseFloat(this.form.bobot);

                this.errorNama  = '';
                this.errorBobot = '';

                if (!nama) {
                    this.errorNama = 'Nama kriteria tidak boleh kosong.';
                    return;
                }

                if (isNaN(bobot) || bobot < 0 || bobot > 1) {
                    this.errorBobot = 'Bobot harus berupa angka antara 0 dan 1.';
                    return;
                }

                const totalTanpaIni = this.kriteria
                    .filter(k => k.id !== this.form.id)
                    .reduce((sum, k) => sum + parseFloat(k.bobot), 0);

                const totalBaru = totalTanpaIni + bobot;

                if (totalBaru > 1.0001) {
                    const sisa = (1 - totalTanpaIni).toFixed(2);
                    this.errorBobot = `Total bobot akan menjadi ${totalBaru.toFixed(2)}, melebihi 1.00. Maksimal: ${sisa}.`;
                    return;
                }

                // Simpan ke database via AJAX
                fetch(`/admin/kriteria/${this.form.id}`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        nama_kriteria: nama,
                        bobot: bobot,
                        tipe: this.form.tipe.toLowerCase()
                    })
                })
                .then(res => res.json())
                .then(data => {
                    this.kriteria = this.kriteria.map(k =>
                        k.id === this.form.id
                            ? { ...k, nama: nama, bobot: bobot, tipe: this.form.tipe }
                            : k
                    );
                    this.closeModal();
                    // Optional: Tampilkan toast sukses jika ada store toast
                    if (window.Alpine && Alpine.store('toast')) {
                        Alpine.store('toast').show('Kriteria berhasil diperbarui', 'success');
                    }
                })
                .catch(err => {
                    console.error(err);
                    alert('Gagal menyimpan perubahan. Silakan coba lagi.');
                });
            },

            hapus(id) {
                if (!confirm('Yakin ingin menghapus kriteria ini?')) return;
                
                fetch(`/admin/kriteria/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                })
                .then(() => {
                    this.kriteria = this.kriteria.filter(k => k.id !== id);
                    if (window.Alpine && Alpine.store('toast')) {
                        Alpine.store('toast').show('Kriteria berhasil dihapus', 'success');
                    }
                })
                .catch(err => {
                    console.error(err);
                    alert('Gagal menghapus kriteria.');
                });
            }
        }
    }
</script>
@endpush

@endsection