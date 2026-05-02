@props(['area'])

<div {{ $attributes->merge(['class' => 'flex items-center gap-2 text-[12px] text-gray-600 font-bold bg-gray-100/80 w-max px-3 py-1.5 rounded-lg border border-gray-200 group-hover:bg-white transition-colors']) }}>
    <i data-lucide="map-pin" class="w-3.5 h-3.5 text-[#B87A3D]"></i>
    <span>{{ $area }}</span>
</div>
