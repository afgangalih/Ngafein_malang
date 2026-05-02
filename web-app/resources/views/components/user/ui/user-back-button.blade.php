@props(['href' => url()->previous(), 'label' => 'Kembali'])

<a href="{{ $href }}" {{ $attributes->merge(['class' => 'inline-flex items-center gap-2 text-[10px] font-black text-gray-400 hover:text-[#b87c39] uppercase tracking-[0.2em] transition-all group']) }}>
    <i class="fa-solid fa-arrow-left-long group-hover:-translate-x-1 transition-transform"></i>
    {{ $label }}
</a>
