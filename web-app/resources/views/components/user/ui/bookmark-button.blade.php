@props(['kafe', 'isDetail' => false])

@php
    $isChecked = Auth::check() && Auth::user()->favorites->contains('id_kafe', $kafe->id_kafe);
@endphp

<div x-data="{ 
        bookmarked: {{ $isChecked ? 'true' : 'false' }}, 
        loading: false 
     }" 
     @click.prevent.stop=""
     class="{{ $isDetail ? '' : 'absolute top-5 right-5 z-20' }}">
    <button @click.prevent.stop="
        @if(!Auth::check())
            localStorage.setItem('pending_bookmark_id', '{{ $kafe->id_kafe }}');
            $dispatch('open-login-modal');
        @else
            if (loading) return;
            loading = true;
            fetch('{{ route('user.kafe.bookmark', $kafe->id_kafe) }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(res => res.json())
            .then(data => {
                loading = false;
                if (data.success) {
                    bookmarked = data.bookmarked;
                }
            })
            .catch(() => loading = false);
        @endif
     "
     :disabled="loading"
     class="w-10 h-10 rounded-xl bg-black/40 backdrop-blur-md border border-white/20 hover:border-[#B87C39] hover:bg-[#B87C39]/20 flex items-center justify-center text-white transition-all duration-300 group cursor-pointer focus:outline-none"
     :class="bookmarked ? 'bg-white/95 border-[#B87C39] text-[#B87C39] shadow-lg shadow-[#B87C39]/20 scale-105' : ''"
     title="Simpan ke Favorit">
        <svg xmlns="http://www.w3.org/2000/svg" 
             width="18" 
             height="18" 
             viewBox="0 0 24 24" 
             :fill="bookmarked ? 'currentColor' : 'none'" 
             stroke="currentColor" 
             stroke-width="2" 
             stroke-linecap="round" 
             stroke-linejoin="round"
             class="transition-transform duration-300 group-hover:scale-110"
             :class="bookmarked ? 'text-[#B87C39]' : 'text-white/80 group-hover:text-white'">
            <path d="m19 21-7-4-7 4V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v16z"/>
        </svg>
    </button>
</div>
