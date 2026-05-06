<template x-teleport="body">
    <div x-show="$store.toast.open" 
         x-transition:enter="transition ease-out duration-500"
         x-transition:enter-start="opacity-0 translate-y-10 scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
         x-transition:leave="transition ease-in duration-500"
         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
         x-transition:leave-end="opacity-0 translate-y-10 scale-95"
         class="fixed bottom-10 left-1/2 -translate-x-1/2 z-[1000001] flex items-center gap-4 px-6 py-4 bg-white rounded-[2rem] shadow-[0_20px_50px_rgba(184,124,57,0.15)] border border-[#b87c39]/20 min-w-[320px]">
        <div class="w-10 h-10 rounded-2xl flex items-center justify-center shrink-0 shadow-sm" 
             :style="'background-color: ' + ($store.toast.type === 'error' ? '#ef4444' : '#b87c39')">
            <i :data-lucide="$store.toast.type === 'error' ? 'alert-circle' : 'check'" class="w-5 h-5 text-white"></i>
        </div>
        <div class="flex flex-col">
            <span class="text-[10px] font-black uppercase tracking-[0.15em]"
                  :class="$store.toast.type === 'error' ? 'text-red-500' : 'text-[#b87c39]'"
                  x-text="$store.toast.type === 'error' ? 'Gagal' : 'Berhasil'">
            </span>
            <span class="text-sm font-bold text-gray-800 tracking-tight" x-text="$store.toast.message"></span>
        </div>
    </div>
</template>
