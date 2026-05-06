<template x-teleport="body">
    <div x-show="$store.confirm.open" 
         x-data="{}"
         x-init="$watch('$store.confirm.open', value => { 
            if(value) { 
                $nextTick(() => { if(window.lucide) lucide.createIcons(); }); 
            }
         })"
         class="fixed inset-0 z-[1000000] flex items-center justify-center p-4"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
        <div class="absolute inset-0 bg-gray-900/40 backdrop-blur-[2px]" @click="$store.confirm.open = false"></div>
        <template x-if="$store.confirm.open">
            <div class="relative bg-white rounded-[2.5rem] shadow-2xl max-w-sm w-full p-10 text-center border border-gray-100"
                 x-transition:enter="transition ease-out duration-300 transform"
                 x-transition:enter-start="scale-90 opacity-0"
                 x-transition:enter-end="scale-100 opacity-100">
                <div class="w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6 border-8 border-white shadow-sm"
                     :class="$store.confirm.type === 'danger' ? 'bg-red-50 text-red-600' : 'bg-amber-50 text-[#b87c39]'">
                    <i :data-lucide="$store.confirm.icon" class="w-10 h-10"></i>
                </div>
                <h3 class="text-2xl font-black text-gray-900 mb-2" x-text="$store.confirm.title"></h3>
                <p class="text-gray-500 text-sm leading-relaxed mb-10" x-text="$store.confirm.message"></p>
                <div class="flex gap-4">
                    <button @click="$store.confirm.open = false" 
                            class="flex-1 py-4 bg-gray-50 text-gray-500 rounded-2xl font-bold text-[11px] uppercase tracking-widest hover:bg-gray-100 transition-all active:scale-95 border border-gray-100">
                        Batal
                    </button>
                    <button @click="$store.confirm.onConfirm(); $store.confirm.open = false" 
                            class="flex-1 py-4 text-white rounded-2xl font-bold text-[11px] uppercase tracking-widest shadow-lg hover:brightness-95 transition-all active:scale-95"
                            :style="$store.confirm.type === 'danger' ? 'background-color: #dc2626' : 'background-color: #b87c39'">
                        Lanjutkan
                    </button>
                </div>
            </div>
        </template>
    </div>
</template>
