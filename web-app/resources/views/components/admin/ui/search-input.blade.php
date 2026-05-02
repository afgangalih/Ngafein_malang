@props(['placeholder' => 'Cari sesuatu...'])

<div class="relative w-full sm:w-80 group">
    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
        <i data-lucide="search" class="w-4 h-4 text-gray-400 group-focus-within:text-[#B87A3D] transition-colors"></i>
    </div>
    <input 
        type="text" 
        {{ $attributes->merge(['class' => 'w-full pl-11 pr-4 py-2.5 bg-[#F8F9FA] border border-transparent rounded-xl text-[13px] text-gray-900 placeholder-gray-400 focus:outline-none focus:bg-white focus:border-[#B87A3D]/40 focus:ring-4 focus:ring-[#B87A3D]/10 transition-all font-medium']) }}
        placeholder="{{ $placeholder }}"
    >
</div>
