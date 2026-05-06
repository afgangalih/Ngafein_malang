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
                <tbody>
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
                                    {{-- tombol edit --}}
                                    <button
                                        @click="openEdit(item.id, item.nama, item.bobot, item.tipe)"
                                        class="flex items-center gap-2 px-4 py-2 bg-blue-50 text-blue-500 hover:bg-blue-500 hover:text-white rounded-lg text-[13px] font-bold transition-all border border-blue-200">
                                        <i data-lucide="pencil" class="w-4 h-4"></i>
                                        Edit
                                    </button>
                                    {{-- tombol hapus --}}
                                    <button
                                        @click="hapus(item.id)"
                                        class="flex items-center gap-2 px-4 py-2 bg-red-50 text-red-500 hover:bg-red-500 hover:text-white rounded-lg text-[13px] font-bold transition-all border border-red-200">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
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
                <span x-show="totalBobot() < 1" class="text-orange-500 text-[14px] font-semibold ml-2">
                    (kurang dari 1.00)
                </span>
                <span x-show="totalBobot() == 1" class="text-green-600 text-[14px] font-semibold ml-2">
                    ✓ (sudah pas)
                </span>
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
                        <i data-lucide="pencil" class="w-5 h-5 text-white"></i>
                    </div>
                    <div>
                        <h3 class="text-[18px] font-black text-gray-800">Edit Kriteria</h3>
                        <p class="text-[12px] text-gray-500 mt-0.5" x-text="'Mengubah data: ' + form.nama"></p>
                    </div>
                </div>
                <button @click="closeModal()"
                        class="w-9 h-9 flex items-center justify-center rounded-xl bg-gray-100 hover:bg-gray-200 transition-all">
                    <i data-lucide="x" class="w-4 h-4 text-gray-500"></i>
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
                        Nilai antara 0 dan 1.
                        Sisa bobot tersedia:
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
                        <i data-lucide="save" class="w-4 h-4"></i>
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

            
            kriteria: [
                { id: 1, nama: 'Jarak',     bobot: 0.20, tipe: 'Cost' },
                { id: 2, nama: 'Harga',     bobot: 0.25, tipe: 'Cost' },
                { id: 3, nama: 'Fasilitas', bobot: 0.15, tipe: 'Benefit' },
                { id: 4, nama: 'Rating',    bobot: 0.20, tipe: 'Benefit' },
                { id: 5, nama: 'Menu',      bobot: 0.10, tipe: 'Benefit' },
                { id: 6, nama: 'Jam',       bobot: 0.10, tipe: 'Benefit' },
            ],

            // Hitung total bobot semua kriteria
            totalBobot() {
                return this.kriteria.reduce((sum, k) => sum + parseFloat(k.bobot), 0);
            },

            // Hitung sisa bobot yang tersedia (dikurangi item yang sedang diedit)
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
                this.$nextTick(() => lucide.createIcons());
            },

            closeModal() {
                this.showModal  = false;
                this.errorNama  = '';
                this.errorBobot = '';
            },

            saveEdit() {
                const nama  = this.form.nama.trim();
                const bobot = parseFloat(this.form.bobot);

                // Reset error
                this.errorNama  = '';
                this.errorBobot = '';

                // Validasi nama
                if (!nama) {
                    this.errorNama = 'Nama kriteria tidak boleh kosong.';
                    return;
                }

                // Validasi bobot range
                if (isNaN(bobot) || bobot < 0 || bobot > 1) {
                    this.errorBobot = 'Bobot harus berupa angka antara 0 dan 1.';
                    return;
                }

                // Validasi total bobot tidak melebihi 1
                const totalTanpaIni = this.kriteria
                    .filter(k => k.id !== this.form.id)
                    .reduce((sum, k) => sum + parseFloat(k.bobot), 0);

                const totalBaru = totalTanpaIni + bobot;

                if (totalBaru > 1.0001) {
                    const sisa = (1 - totalTanpaIni).toFixed(2);
                    this.errorBobot = `Total bobot akan menjadi ${totalBaru.toFixed(2)}, melebihi 1.00. Bobot maksimal yang bisa diisi: ${sisa}.`;
                    return;
                }

                // Update data di array (reaktif)
                this.kriteria = this.kriteria.map(k =>
                    k.id === this.form.id
                        ? { ...k, nama: nama, bobot: bobot, tipe: this.form.tipe }
                        : k
                );

                this.closeModal();

               
            },

            hapus(id) {
                if (!confirm('Yakin ingin menghapus kriteria ini?')) return;
                this.kriteria = this.kriteria.filter(k => k.id !== id);

               
            }
        }
    }
</script>
@endpush

@endsection
