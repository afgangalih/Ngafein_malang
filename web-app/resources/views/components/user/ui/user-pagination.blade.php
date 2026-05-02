@if ($paginator->hasPages())
    <nav class="flex items-center justify-between w-full mt-10 px-2 select-none">
        
        {{-- Previous Page Link --}}
        <div class="flex-1 flex justify-start">
            @if ($paginator->onFirstPage())
                <span class="flex items-center gap-2 text-gray-300 text-xs font-bold cursor-not-allowed uppercase tracking-widest">
                    <i class="fa-solid fa-arrow-left-long text-[10px]"></i> Prev
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="flex items-center gap-2 text-gray-500 hover:text-[#452610] text-xs font-bold transition-all uppercase tracking-widest group">
                    <i class="fa-solid fa-arrow-left-long text-[10px] group-hover:-translate-x-1 transition-transform"></i> Prev
                </a>
            @endif
        </div>

        {{-- Page Numbers --}}
        <div class="hidden md:flex items-center gap-6">
            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.2em]">Page:</span>
            <div class="flex items-center gap-2">
                @foreach ($elements as $element)
                    @if (is_string($element))
                        <span class="text-gray-300 px-2">{{ $element }}</span>
                    @endif

                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <span class="w-8 h-8 flex items-center justify-center rounded-lg bg-gray-100 text-[#452610] text-xs font-black shadow-sm border border-gray-200/50">
                                    {{ $page }}
                                </span>
                            @else
                                <a href="{{ $url }}" class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-400 text-xs font-bold hover:text-[#452610] hover:bg-gray-50 transition-all">
                                    {{ $page }}
                                </a>
                            @endif
                        @endforeach
                    @endif
                @endforeach
            </div>
        </div>

        {{-- Mobile Indicator --}}
        <div class="md:hidden text-[10px] font-bold text-gray-400 uppercase tracking-widest">
            {{ $paginator->currentPage() }} / {{ $paginator->lastPage() }}
        </div>

        {{-- Next Page Link --}}
        <div class="flex-1 flex justify-end">
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="flex items-center gap-2 text-gray-500 hover:text-[#452610] text-xs font-bold transition-all uppercase tracking-widest group">
                    Next <i class="fa-solid fa-arrow-right-long text-[10px] group-hover:translate-x-1 transition-transform"></i>
                </a>
            @else
                <span class="flex items-center gap-2 text-gray-300 text-xs font-bold cursor-not-allowed uppercase tracking-widest">
                    Next <i class="fa-solid fa-arrow-right-long text-[10px]"></i>
                </span>
            @endif
        </div>

    </nav>
@endif
