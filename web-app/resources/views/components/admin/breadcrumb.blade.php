@props(['links' => []])
<nav class="flex items-center text-[10px] font-black uppercase tracking-[0.15em] overflow-hidden">
    <ol class="flex items-center gap-2 whitespace-nowrap">
        <li>
            <a href="{{ route('admin.dashboard') }}" 
               class="{{ empty($links) ? 'text-[#b87c39]' : 'text-gray-400 hover:text-[#b87c39]' }} transition-colors">
                Dashboard
            </a>
        </li>
        @if(!empty($links))
            @foreach($links as $link)
                <li class="flex items-center gap-2 text-gray-300">
                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
                    @if(isset($link['url']) && $link['url'])
                        <a href="{{ $link['url'] }}" class="text-gray-400 hover:text-[#b87c39] transition-colors">
                            {{ $link['label'] }}
                        </a>
                    @else
                        <span class="text-[#b87c39]">{{ $link['label'] }}</span>
                    @endif
                </li>
            @endforeach
        @endif
    </ol>
</nav>
