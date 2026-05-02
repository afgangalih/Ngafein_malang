<div>
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-xs font-bold text-gray-900 uppercase tracking-widest">Filter Jarak</h3>
        <span class="text-[10px] font-bold text-[#b87c39] bg-amber-50 px-2 py-0.5 rounded">Maks 10km</span>
    </div>
    <input type="range" min="0" max="10" step="0.5" class="w-full h-1.5 bg-gray-100 rounded-lg appearance-none cursor-pointer accent-[#b87c39]">
    <div class="flex justify-between mt-2 text-[10px] font-bold text-gray-400">
        <span>0 KM</span>
        <span>10 KM</span>
    </div>
</div>

<div class="border-t border-gray-50 pt-6">
    <h3 class="text-xs font-bold text-gray-900 uppercase tracking-widest mb-4">Jam Operasional</h3>
    <label class="flex items-center gap-3 cursor-pointer group">
        <input type="checkbox" class="w-5 h-5 rounded-lg border-gray-200 text-[#b87c39] focus:ring-[#b87c39]/20 transition-all">
        <span class="text-sm font-semibold text-gray-600 group-hover:text-gray-900">Buka Sekarang</span>
    </label>
</div>

<div class="border-t border-gray-50 pt-6">
    <h3 class="text-xs font-bold text-gray-900 uppercase tracking-widest mb-4">Rentang Harga</h3>
    <div class="space-y-3">
        @php $prices = ['Budget ( < 20rb )', 'Medium ( 20rb - 50rb )', 'Premium ( > 50rb )']; @endphp
        @foreach($prices as $p)
        <label class="flex items-center gap-3 cursor-pointer group">
            <input type="checkbox" class="w-5 h-5 rounded-lg border-gray-200 text-[#b87c39] focus:ring-[#b87c39]/20 transition-all">
            <span class="text-sm font-semibold text-gray-600 group-hover:text-gray-900">{{ $p }}</span>
        </label>
        @endforeach
    </div>
</div>

<div class="border-t border-gray-50 pt-6">
    <details class="group" open>
        <summary class="flex items-center justify-between cursor-pointer list-none">
            <h3 class="text-xs font-bold text-gray-900 uppercase tracking-widest">Fasilitas</h3>
            <i class="fa-solid fa-chevron-down text-[10px] text-gray-400 group-open:rotate-180 transition-transform"></i>
        </summary>
        <div class="mt-4 grid grid-cols-1 gap-3">
            @foreach($allFasilitas as $fas)
            <label class="flex items-center gap-3 cursor-pointer group">
                <input type="checkbox" class="w-5 h-5 rounded-lg border-gray-200 text-[#b87c39] focus:ring-[#b87c39]/20 transition-all">
                <span class="text-sm font-semibold text-gray-600 group-hover:text-gray-900 capitalize">{{ str_replace('_', ' ', $fas->nama_fasilitas) }}</span>
            </label>
            @endforeach
        </div>
    </details>
</div>

<div class="border-t border-gray-50 pt-6 pb-2">
    <details class="group">
        <summary class="flex items-center justify-between cursor-pointer list-none">
            <h3 class="text-xs font-bold text-gray-900 uppercase tracking-widest">Variasi Menu</h3>
            <i class="fa-solid fa-chevron-down text-[10px] text-gray-400 group-open:rotate-180 transition-transform"></i>
        </summary>
        <div class="mt-4 grid grid-cols-1 gap-3">
            @foreach($allMenus as $menu)
            <label class="flex items-center gap-3 cursor-pointer group">
                <input type="checkbox" class="w-5 h-5 rounded-lg border-gray-200 text-[#b87c39] focus:ring-[#b87c39]/20 transition-all">
                <span class="text-sm font-semibold text-gray-600 group-hover:text-gray-900 capitalize">{{ $menu->nama_menu }}</span>
            </label>
            @endforeach
        </div>
    </details>
</div>
