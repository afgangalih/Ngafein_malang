@props(['icon', 'title', 'value', 'highlight' => false])

<div {{ $attributes->merge(['class' => 'relative overflow-hidden rounded-[1.5rem] p-6 border transition-all duration-300 hover:-translate-y-1 group cursor-default ' . ($highlight ? 'bg-[#FEF6E7] border-[#F3E8D5] shadow-sm' : 'bg-white border-gray-100 shadow-[0_4px_20px_rgb(0,0,0,0.03)]')]) }}>
    
    <div class="absolute -right-4 -bottom-4 opacity-[0.03] text-gray-900 group-hover:scale-110 group-hover:-rotate-12 transition-all duration-500 pointer-events-none">
        <i data-lucide="{{ $icon }}" style="width: 100px; height: 100px;"></i>
    </div>

    <div class="flex items-start justify-between relative z-10">
        <div class="flex flex-col">
            <p class="text-gray-500 text-[11px] font-bold uppercase tracking-wider mb-2">{{ $title }}</p>
            <p class="text-4xl font-black text-gray-900 tracking-tight">{{ $value }}</p>
        </div>
        <div class="w-12 h-12 rounded-xl flex items-center justify-center shadow-sm {{ $highlight ? 'bg-[#B87A3D] text-white' : 'bg-[#FEF6E7] text-[#B87A3D] border border-[#F3E8D5]' }}">
            <i data-lucide="{{ $icon }}" class="w-6 h-6"></i>
        </div>
    </div>
</div>
