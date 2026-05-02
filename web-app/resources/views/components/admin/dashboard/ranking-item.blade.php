@props(['rank', 'name', 'score' => null])

<div class="flex items-center gap-4 bg-white/50 hover:bg-white p-3 rounded-2xl border border-transparent hover:border-[#F3E8D5] hover:shadow-sm transition-all duration-200 cursor-pointer group">
    <div class="bg-[#DAB894]/20 text-[#A36A32] group-hover:bg-[#DAB894]/40 w-10 h-10 rounded-xl flex items-center justify-center font-black text-sm transition-colors">
        {{ $rank }}
    </div>
    <div class="flex-1">
        <h4 class="font-bold text-gray-700 text-[14px] group-hover:text-gray-900 transition-colors">{{ $name }}</h4>
        @if($score)
            <p class="text-[11px] text-gray-400 font-medium">Skor: {{ number_format($score, 3) }}</p>
        @endif
    </div>
    <i data-lucide="chevron-right" class="w-4 h-4 text-gray-300 group-hover:text-[#B87A3D] opacity-0 group-hover:opacity-100 transition-all -translate-x-2 group-hover:translate-x-0"></i>
</div>
