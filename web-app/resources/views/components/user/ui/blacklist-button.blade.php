@props(['kafe', 'isDetail' => false])

@php
    $isBlacklisted = Auth::check() && Auth::user()->blacklistedCafes->contains('id_kafe', $kafe->id_kafe);
@endphp

<div x-data="{ 
        blacklisted: {{ $isBlacklisted ? 'true' : 'false' }}, 
        loading: false,
        showConfirm: false,
        toggleBlacklist() {
            if (this.loading) return;
            this.loading = true;
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
                this.loading = false;
                if (data.success) {
                    this.blacklisted = data.blacklisted;
                    $dispatch('blacklist-toggled', { id: {{ $kafe->id_kafe }}, blacklisted: this.blacklisted });
                    
                    // Auto reload if user is on favorit page to instantly move items between tabs
                    if (window.location.pathname.includes('/favorit')) {
                        window.location.reload();
                    }
                }
            })
            .catch(() => this.loading = false);
        },
        handleBtnClick() {
            @if(!Auth::check())
                $dispatch('open-login-modal');
            @else
                if (this.blacklisted) {
                    // Include back directly without warning
                    this.toggleBlacklist();
                } else {
                    // Show confirmation modal before excluding
                    this.showConfirm = true;
                }
            @endif
        }
     }" 
     @click.prevent.stop=""
     class="{{ $isDetail ? '' : 'absolute top-3 right-11 sm:top-5 sm:right-17 z-20' }}">
    <button @click.prevent.stop="handleBtnClick()"
     :disabled="loading"
     class="w-7.5 h-7.5 sm:w-10 sm:h-10 rounded-lg sm:rounded-xl bg-black/40 backdrop-blur-md border border-white/20 hover:border-red-500 hover:bg-red-500/20 flex items-center justify-center text-white transition-all duration-300 group cursor-pointer focus:outline-none"
     :class="blacklisted ? 'bg-red-500/80 border-red-500 text-white shadow-lg shadow-red-500/25 scale-105' : ''"
     title="Kecualikan dari Rekomendasi (Exclude)">
        <svg xmlns="http://www.w3.org/2000/svg" 
             viewBox="0 0 24 24" 
             fill="none" 
             stroke="currentColor" 
             stroke-width="2" 
             stroke-linecap="round" 
             stroke-linejoin="round"
             class="w-3.5 h-3.5 sm:w-4.5 sm:h-4.5 transition-transform duration-300 group-hover:scale-110"
             :class="blacklisted ? 'text-white' : 'text-white/80 group-hover:text-white'">
            <circle cx="12" cy="12" r="10"/>
            <line x1="4.93" y1="4.93" x2="19.07" y2="19.07"/>
        </svg>
    </button>

    <!-- Premium Confirmation Modal -->
    <template x-teleport="body">
        <div x-show="showConfirm"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm"
             x-cloak>
            <div x-show="showConfirm"
                 x-transition:enter="transition ease-out duration-300 transform"
                 x-transition:enter-start="opacity-0 translate-y-8 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="transition ease-in duration-200 transform"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-8 sm:scale-95"
                 class="bg-white w-full max-w-sm rounded-[2rem] shadow-2xl border border-gray-100 p-6 sm:p-8 flex flex-col items-center text-center relative overflow-hidden"
                 @click.away="showConfirm = false">
                 
                <!-- Amber/Brown Alert Icon -->
                <div class="w-14 h-14 rounded-2xl bg-[#FEF6E7] text-[#B87C39] flex items-center justify-center mb-5 border border-[#F3E8D5]">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-7 h-7"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                </div>
                
                <!-- Text Content -->
                <h3 class="text-base font-black text-[#2B1A09] leading-snug mb-3">
                    Kecualikan "{{ $kafe->nama_kafe }}"?
                </h3>
                
                <!-- Info list -->
                <div class="w-full text-left bg-[#FFFBF5]/90 border border-[#F3E8D5]/80 rounded-2xl p-4.5 mb-6 space-y-3.5">
                    <div class="flex items-start gap-3">
                        <div class="w-5.5 h-5.5 rounded-lg bg-[#B87C39]/10 text-[#B87C39] flex items-center justify-center shrink-0 mt-0.5">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="w-3 h-3"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                        </div>
                        <p class="text-[11px] text-[#5C4D3C] leading-relaxed">
                            <strong>Dikeluarkan sepenuhnya</strong> dari perhitungan algoritma rekomendasi <strong>SAW</strong>.
                        </p>
                    </div>
                    
                    <div class="flex items-start gap-3">
                        <div class="w-5.5 h-5.5 rounded-lg bg-[#B87C39]/10 text-[#B87C39] flex items-center justify-center shrink-0 mt-0.5">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="w-3 h-3"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        </div>
                        <p class="text-[11px] text-[#5C4D3C] leading-relaxed">
                            <strong>Tetap dapat dicari</strong> di halaman eksplorasi, namun tampilannya ditandai dengan warna <strong>abu-abu (redup)</strong>.
                        </p>
                    </div>
                </div>
                
                <!-- Action Buttons -->
                <div class="flex items-center gap-3 w-full">
                    <button type="button" 
                            @click="showConfirm = false" 
                            class="flex-1 py-2.5 px-4 text-xs font-bold text-gray-500 hover:text-[#2B1A09] hover:bg-gray-100/60 rounded-xl transition-all cursor-pointer text-center">
                        Batal
                    </button>
                    <button type="button" 
                            @click="showConfirm = false; toggleBlacklist()" 
                            class="flex-1 py-2.5 px-4 bg-[#B87C39] hover:bg-[#9a662e] text-white font-bold text-xs rounded-xl shadow-md shadow-[#B87C39]/10 transition-all cursor-pointer text-center">
                        Kecualikan Kafe
                    </button>
                </div>
            </div>
        </div>
    </template>
</div>
