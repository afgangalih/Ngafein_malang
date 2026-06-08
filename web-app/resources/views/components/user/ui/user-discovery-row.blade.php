<div class="relative">
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-3 mb-4 sm:mb-8">
        <div class="max-w-xl">
            <h2 class="text-lg sm:text-2xl font-black text-gray-900 tracking-tight mb-1 sm:mb-2">{{ $title }}</h2>
            <p class="text-xs sm:text-sm text-gray-400 font-medium leading-relaxed">{{ $subtitle }}</p>
        </div>
        <a href="{{ route('user.explore.index', ['category' => $category]) }}" class="inline-flex items-center gap-1.5 text-[10px] sm:text-xs font-bold text-[#b87c39] hover:text-[#9a662e] transition-all group shrink-0 uppercase tracking-widest mt-1 md:mt-0">
            Lihat Semua 
            <i data-lucide="arrow-right" class="w-3.5 h-3.5 group-hover:translate-x-1 transition-transform"></i>
        </a>
    </div>

    @if($cafes->isEmpty())
        <div class="bg-white border border-gray-100 rounded-2xl sm:rounded-3xl p-6 sm:p-10 text-center">
            <p class="text-gray-400 text-xs sm:text-sm font-medium">Belum ada kafe di kategori ini.</p>
        </div>
    @else
        <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-3.5 sm:gap-6">
            @foreach($cafes as $k)
                @include('components.user.ui.user-cafe-card', ['k' => $k])
            @endforeach
        </div>
    @endif
</div>

