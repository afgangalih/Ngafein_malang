@props(['kafe', 'isDetail' => false])

@php
    $isBlacklisted = Auth::check() && Auth::user()->blacklistedCafes->contains('id_kafe', $kafe->id_kafe);
@endphp

<div x-data="{ 
        blacklisted: {{ $isBlacklisted ? 'true' : 'false' }}, 
        loading: false 
     }" 
     @click.prevent.stop=""
     class="{{ $isDetail ? '' : 'absolute top-5 right-17 z-20' }}">
    <button @click.prevent.stop="
        @if(!Auth::check())
            $dispatch('open-login-modal');
        @else
            if (loading) return;
            loading = true;
            fetch('{{ route('user.kafe.blacklist', $kafe->id_kafe) }}', {
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
                    blacklisted = data.blacklisted;
                    $dispatch('blacklist-toggled', { id: {{ $kafe->id_kafe }}, blacklisted: blacklisted });
                    
                    // Auto reload if user is on favorit page to instantly move items between tabs
                    if (window.location.pathname.includes('/favorit')) {
                        window.location.reload();
                    }
                }
            })
            .catch(() => loading = false);
        @endif
     "
     :disabled="loading"
     class="w-10 h-10 rounded-xl bg-black/40 backdrop-blur-md border border-white/20 hover:border-red-500 hover:bg-red-500/20 flex items-center justify-center text-white transition-all duration-300 group cursor-pointer focus:outline-none"
     :class="blacklisted ? 'bg-red-500/80 border-red-500 text-white shadow-lg shadow-red-500/25 scale-105' : ''"
     title="Kecualikan dari Rekomendasi (Blacklist)">
        <svg xmlns="http://www.w3.org/2000/svg" 
             width="18" 
             height="18" 
             viewBox="0 0 24 24" 
             fill="none" 
             stroke="currentColor" 
             stroke-width="2" 
             stroke-linecap="round" 
             stroke-linejoin="round"
             class="transition-transform duration-300 group-hover:scale-110"
             :class="blacklisted ? 'text-white' : 'text-white/80 group-hover:text-white'">
            <circle cx="12" cy="12" r="10"/>
            <line x1="4.93" y1="4.93" x2="19.07" y2="19.07"/>
        </svg>
    </button>
</div>
