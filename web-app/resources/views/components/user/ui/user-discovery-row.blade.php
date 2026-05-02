<div class="relative">
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-8">
        <div class="max-w-xl">
            <h2 class="text-2xl font-black text-gray-900 tracking-tight mb-2">{{ $title }}</h2>
            <p class="text-sm text-gray-400 font-medium leading-relaxed">{{ $subtitle }}</p>
        </div>
        <a href="{{ route('user.cafe.index', ['category' => $category]) }}" class="inline-flex items-center gap-2 text-xs font-bold text-[#b87c39] hover:text-[#9a662e] transition-all group shrink-0">
            LIHAT SEMUA 
            <i class="fa-solid fa-arrow-right-long group-hover:translate-x-1 transition-transform"></i>
        </a>
    </div>

    @if($cafes->isEmpty())
        <div class="bg-white border border-gray-100 rounded-3xl p-10 text-center">
            <p class="text-gray-400 text-sm font-medium">Belum ada kafe di kategori ini.</p>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($cafes as $k)
                @include('components.user.ui.user-cafe-card', ['k' => $k])
            @endforeach
        </div>
    @endif
</div>

