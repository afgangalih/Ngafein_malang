@props(['name', 'score', 'maxScore' => 1, 'color' => 'bg-[#B87A3D]', 'highlight' => false])

@php
    $percentage = ($score / $maxScore) * 100;
@endphp

<div class="flex flex-col gap-1.5 group cursor-default">
    <div class="flex justify-between items-center text-[13px]">
        <span class="font-bold {{ $highlight ? 'text-gray-900' : 'text-gray-600 group-hover:text-gray-900' }} transition-colors">
            {{ $name }}
        </span>
        <div class="flex items-center gap-2">
            @if($highlight)
                <i data-lucide="star" class="w-3 h-3 fill-[#B87A3D] text-[#B87A3D]"></i>
            @endif
            <span class="font-black {{ $highlight ? 'text-[#B87A3D]' : 'text-gray-800' }}">
                {{ number_format($score, 3) }}
            </span>
        </div>
    </div>
    <div class="w-full bg-gray-100 rounded-full h-3 overflow-hidden relative">
        <div class="absolute inset-0 opacity-20 pointer-events-none" 
             style="background-image: linear-gradient(90deg, transparent 99%, #000 100%); background-size: 10% 100%;">
        </div>
        <div class="h-full rounded-full {{ $color }} transition-all duration-1000 ease-out relative" 
             style="width: {{ $percentage }}%">
            @if($highlight)
                <div class="absolute top-0 right-0 bottom-0 w-8 bg-gradient-to-r from-transparent to-white/30 rounded-r-full"></div>
            @endif
        </div>
    </div>
</div>
