<template x-teleport="body">
    <div>
        <div x-show="panelOpen" 
             x-transition:enter="transition ease-in-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in-out duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="closePanel()"
             class="fixed inset-0 bg-gray-900/60 backdrop-blur-md z-[999998]" 
             style="display: none;">
        </div>
        <div x-show="panelOpen" 
             x-transition:enter="transition ease-in-out duration-300 transform"
             x-transition:enter-start="translate-x-full"
             x-transition:enter-end="translate-x-0"
             x-transition:leave="transition ease-in-out duration-300 transform"
             x-transition:leave-start="translate-x-0"
             x-transition:leave-end="translate-x-full"
             class="fixed top-0 right-0 h-full w-full max-w-lg bg-white shadow-2xl z-[999999] flex flex-col" 
             style="display: none;">
            <div class="px-6 py-5 border-b flex justify-between items-center bg-white">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-[#b87c39]/10 rounded-lg text-[#b87c39]">
                        <i :data-lucide="panelMode === 'add' ? 'plus-circle' : (panelMode === 'edit' ? 'edit-3' : 'eye')" class="w-5 h-5"></i>
                    </div>
                    <h3 class="text-xl font-black text-gray-900" x-text="panelTitle">Tambah Cafe</h3>
                </div>
                <button @click="closePanel()" class="p-2 hover:bg-gray-100 rounded-full transition-colors text-gray-400 hover:text-gray-900">
                    <i data-lucide="x" class="w-6 h-6"></i>
                </button>
            </div>
            <div class="flex-1 overflow-y-auto p-8 custom-scrollbar" id="panel-content">
                <div x-show="loading" class="flex flex-col items-center justify-center h-full space-y-4">
                    <div class="relative flex items-center justify-center">
                        <div class="w-12 h-12 border-4 border-[#b87c39]/10 rounded-full"></div>
                        <div class="absolute w-12 h-12 border-4 border-[#b87c39] border-t-transparent rounded-full animate-spin"></div>
                    </div>
                    <p class="text-gray-500 text-sm font-bold tracking-tight">Menyiapkan Data...</p>
                </div>
                <div id="panel-body-inner" x-show="!loading"></div>
            </div>
            <div class="p-6 border-t bg-gray-50 flex gap-3 sticky bottom-0">
                <button @click="closePanel()" 
                        class="flex-1 px-4 py-2.5 border border-gray-300 bg-white rounded-xl text-sm font-bold text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-all active:scale-95"
                        x-show="panelMode === 'detail'">
                    Tutup Detail
                </button>
                <button @click="closePanel()" 
                        class="flex-1 px-4 py-2.5 border border-gray-300 bg-white rounded-xl text-sm font-bold text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-all active:scale-95"
                        x-show="panelMode !== 'detail'">
                    Batal
                </button>
                <button @click="$store.confirm.show('Simpan Data?', 'Pastikan seluruh data kafe sudah sesuai sebelum disimpan ke sistem.', () => submitForm(), 'primary', panelMode === 'add' ? 'save' : 'edit-3')" 
                        x-show="panelMode !== 'detail'"
                        id="btn-save-panel"
                        style="background-color: #b87c39;"
                        class="flex-1 px-4 py-2.5 text-white rounded-xl font-bold text-sm hover:brightness-90 shadow-md transition-all active:scale-95 flex items-center justify-center gap-2">
                    <template x-if="saving">
                        <div class="w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin"></div>
                    </template>
                    <span x-text="panelMode === 'add' ? 'Simpan Cafe' : 'Simpan Perubahan'"></span>
                </button>
            </div>
        </div>
    </div>
</template>
