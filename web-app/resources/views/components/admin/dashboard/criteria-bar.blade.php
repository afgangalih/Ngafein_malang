@props(['label', 'percentage', 'color' => 'bg-[#B87A3D]'])

<div class="flex flex-col gap-2">
    <div class="flex justify-between items-center text-[13px] font-bold">
        <span class="text-gray-700">{{ $label }}</span>
        <span class="text-gray-900">{{ $percentage }}%</span>
    </div>
    <div class="w-full bg-gray-100 rounded-full h-2.5 overflow-hidden">
        <div class="h-2.5 rounded-full {{ $color }} transition-all duration-1000 ease-out" style="width: {{ $percentage }}%"></div>
    </div>
</div>
