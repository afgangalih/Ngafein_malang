<section class="relative min-h-screen flex items-center justify-center px-4 bg-[#2B1A09]"
         x-data="{
            query: '',
            results: [],
            show: false,
            loading: false,
            timer: null,
            fetchResults() {
                if (this.query.length < 2) {
                    this.results = [];
                    this.show = false;
                    return;
                }
                this.loading = true;
                this.show = true;
                
                clearTimeout(this.timer);
                this.timer = setTimeout(() => {
                    fetch(`/explore/search-api?q=${encodeURIComponent(this.query)}`)
                        .then(r => r.json())
                        .then(data => {
                            this.results = data;
                            this.loading = false;
                        })
                        .catch(() => {
                            this.loading = false;
                        });
                }, 400);
            },
            clear() {
                this.query = '';
                this.results = [];
                this.show = false;
            }
         }"
         @click.away="show = false"
         @keydown.escape.window="show = false">
    
    <div class="absolute inset-0 z-0 overflow-hidden">
        <img src="https://images.unsplash.com/photo-1469631423273-6995642a6a40?auto=format&fit=crop&w=2000&q=80" 
             alt="Cafe Background" 
             class="w-full h-full object-cover opacity-70">
        <div class="absolute inset-0 bg-gradient-to-b from-[#2B1A09]/40 via-[#2B1A09]/30 to-[#2B1A09]/95"></div>
    </div>

    <div class="relative z-30 w-full max-w-4xl mx-auto flex flex-col items-center text-center mt-20">
        
        
        <div class="flex items-center gap-4 mb-6 opacity-90">
            <div class="w-10 sm:w-14 h-[1px] bg-[#B87C39]"></div>
            <span class="text-[#F0B942] text-[10px] sm:text-xs font-bold tracking-[0.25em] uppercase">
                Temukan Tempat Ngopi Terbaik
            </span>
            <div class="w-10 sm:w-14 h-[1px] bg-[#B87C39]"></div>
        </div>
        
        
        <h1 class="text-5xl md:text-6xl lg:text-7xl font-serif font-bold text-white leading-[1.1] mb-6 tracking-tight drop-shadow-lg">
            Kopi dan Cerita <br/>
            <span class="text-[#F0E0C0] italic font-normal tracking-wide">di Setiap Sudut Kota</span>
        </h1>
        
        <p class="text-base md:text-xl text-white/90 font-light mb-12 max-w-2xl leading-relaxed drop-shadow-md">
            Di mana moodmu hari ini membawamu? Temukan kafe yang pas untuk kerja, nongkrong, atau sekadar menyendiri dengan tenang.
        </p>

        
        <div class="w-full max-w-3xl relative">
            <div class="flex items-center bg-white/10 backdrop-blur-lg border border-white/20 rounded-full p-2.5 shadow-2xl transition-all duration-300 focus-within:bg-white/15 focus-within:border-[#B87C39]/50 focus-within:ring-4 focus-within:ring-[#B87C39]/20">
                <i data-lucide="search" class="w-6 h-6 text-[#F0B942] ml-5 mr-3"></i>
                <input 
                    type="text"
                    class="flex-1 bg-transparent border-none text-white placeholder-white/70 focus:outline-none focus:ring-0 text-base md:text-lg px-2 h-14"
                    placeholder="Cari kafe, area, atau suasana..."
                    x-model="query"
                    @input="fetchResults()"
                    @focus="if(results.length > 0) show = true"
                    autocomplete="off"
                >
                
                <button x-show="query.length > 0" @click="clear()" class="p-3 text-white/70 hover:text-white transition-colors" x-cloak>
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>

                <button class="bg-[#B87C39] hover:bg-[#a66c2e] text-white font-bold px-8 h-14 rounded-full transition-all duration-200 flex items-center gap-2 shadow-lg shadow-[#B87C39]/30 ml-2">
                    <i data-lucide="search" class="w-4 h-4 hidden sm:inline"></i>
                    Cari <span class="hidden sm:inline">Kafe</span>
                </button>
            </div>

            
            <div x-show="show && query.length >= 2" 
                 x-cloak
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 class="absolute top-full left-0 right-0 mt-4 bg-[#140b03]/95 backdrop-blur-xl rounded-3xl shadow-2xl border border-[#c89b3c]/20 overflow-hidden text-left z-50 max-h-[420px] overflow-y-auto scrollbar-hide">
                
              
                <div x-show="loading" class="p-8 flex flex-col items-center justify-center gap-4 text-[#c89b3c]/60">
                    <div class="w-8 h-8 border-2 border-[#B87C39]/20 border-t-[#B87C39] rounded-full animate-spin"></div>
                    <span class="text-sm font-medium tracking-widest uppercase">Mencari racikan terbaik...</span>
                </div>

                
                <div x-show="!loading && results.length > 0">
                    <div class="px-6 py-3 bg-white/5 border-b border-white/5 text-[10px] font-bold text-[#c89b3c]/50 uppercase tracking-[0.2em]">
                        <span x-text="results.length"></span> Kafe Ditemukan
                    </div>
                    <template x-for="item in results" :key="item.id_kafe">
                        <a :href="'/explore/' + item.id_kafe" class="flex items-center gap-5 px-6 py-4 hover:bg-white/5 transition-colors group border-b border-white/5 last:border-0">
                            <div class="w-12 h-12 rounded-2xl bg-[#B87C39]/10 flex items-center justify-center text-[#B87C39] group-hover:bg-[#B87C39] group-hover:text-white transition-all duration-300">
                                <svg viewBox="0 0 24 24" class="w-6 h-6 fill-none stroke-current" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M17 8h1a4 4 0 1 1 0 8h-1M3 8h14v9a4 4 0 0 1-4 4H7a4 4 0 0 1-4-4V8z"/>
                                    <path d="M6 2v2M10 2v2M14 2v2"/>
                                </svg>
                            </div>
                            <div class="flex-1 text-left">
                                <h4 class="text-base font-bold text-white group-hover:text-[#B87C39] transition-colors" x-text="item.nama_kafe"></h4>
                                <p class="text-sm text-white/50 flex items-center gap-1.5 mt-1">
                                    <svg viewBox="0 0 24 24" class="w-3.5 h-3.5 text-[#B87C39]/70 fill-none stroke-current" stroke-width="2"><path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0z"/><circle cx="12" cy="10" r="3"/></svg>
                                    <span x-text="item.jarak ? item.jarak + ' km' : 'Malang'"></span>
                                    <span class="text-white/20">•</span>
                                    <span class="line-clamp-1" x-text="item.alamat"></span>
                                </p>
                            </div>
                            <svg viewBox="0 0 24 24" class="w-5 h-5 text-white/20 group-hover:text-[#B87C39] group-hover:translate-x-1 transition-all fill-none stroke-current" stroke-width="2.5"><path d="m9 18 6-6-6-6"/></svg>
                        </a>
                    </template>
                </div>

                
                <div x-show="!loading && results.length === 0" class="p-10 text-center">
                    <div class="w-14 h-14 rounded-full bg-white/5 flex items-center justify-center mx-auto mb-4 border border-white/10">
                        <i data-lucide="search" class="w-6 h-6 text-white/20"></i>
                    </div>
                    <p class="text-base text-white/60">Kafe <strong class="text-white" x-text="'&quot;' + query + '&quot;'"></strong> belum ada di radar kami.</p>
                </div>
            </div>
        </div>
    </div>
</section>
