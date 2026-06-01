@extends('layouts.user')

@section('title', 'Jelajahi Kafe — Ngafein')
@section('navbar-dark-text', 'true')

@section('content')
<div class="bg-[#FBFBFB] min-h-screen pb-20">
    
    {{-- Hero Section --}}
    <div class="max-w-7xl mx-auto px-4 md:px-8 pt-32 md:pt-48 mb-12">
        <div class="text-center relative">
            <h1 class="text-5xl md:text-8xl font-black text-gray-900 tracking-tighter mb-8 leading-[0.9]">
                Temukan <span class="text-[#b87c39]">Kafe</span> <br class="hidden md:block"> Terbaikmu.
            </h1>
            
            <p class="text-base md:text-xl text-gray-500 font-medium max-w-2xl mx-auto leading-relaxed tracking-tight">
                Pilihan kurasi kafe terbaik di Malang untuk produktivitas <br class="hidden md:block"> 
                dan kenyamanan nongkrong yang tak tertandingi.
            </p>

            <div class="absolute -top-32 left-1/2 -translate-x-1/2 w-96 h-96 bg-amber-50/50 rounded-full blur-[120px] -z-10"></div>
        </div>

        {{-- Interactive Search Bar --}}
        <div class="mt-12 max-w-2xl mx-auto relative z-20" 
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
                            .then(res => res.json())
                            .then(data => {
                                this.results = data;
                                this.loading = false;
                            })
                            .catch(() => {
                                this.loading = false;
                            });
                    }, 400);
                }
             }"
             @click.away="show = false">
            
            <div class="flex items-center bg-white/80 backdrop-blur-lg border border-gray-200/80 rounded-full p-2.5 transition-all duration-300 focus-within:bg-white focus-within:border-[#B87C39]/50 focus-within:ring-4 focus-within:ring-[#B87C39]/10">
                <svg viewBox="0 0 24 24" class="w-6 h-6 text-[#B87C39] ml-5 mr-3 fill-none stroke-current" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                <input 
                    type="text" 
                    x-model="query"
                    @input="fetchResults()"
                    @focus="if(results.length > 0) show = true"
                    placeholder="Cari kafe, area, atau suasana..."
                    class="flex-1 bg-transparent border-none text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-0 text-base px-2 h-14"
                >
                <button x-show="query.length > 0" @click="query = ''; results = []; show = false" class="p-3 text-gray-400 hover:text-gray-600 transition-colors" x-cloak>
                    <svg viewBox="0 0 24 24" class="w-5 h-5 fill-none stroke-current" stroke-width="2.5"><path d="M18 6 6 18M6 6l12 12"/></svg>
                </button>
                <button class="bg-[#B87C39] hover:bg-[#a66c2e] text-white font-bold px-8 h-14 rounded-full transition-all duration-200 flex items-center gap-2 shadow-lg shadow-[#B87C39]/30 ml-2 cursor-pointer">
                    <svg viewBox="0 0 24 24" class="w-4 h-4 hidden sm:inline fill-none stroke-current" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                    Cari <span class="hidden sm:inline">Kafe</span>
                </button>
            </div>

            {{-- Results Dropdown --}}
            <div x-show="show && query.length >= 2"
                 x-cloak
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 class="absolute top-full left-0 right-0 mt-4 bg-white border border-gray-100 rounded-3xl shadow-2xl overflow-hidden min-h-[100px] flex flex-col justify-center z-50 max-h-[420px] overflow-y-auto">
                
                {{-- State: Loading --}}
                <div x-show="loading" class="py-10 flex flex-col items-center justify-center gap-3 text-gray-400">
                    <div class="w-8 h-8 border-2 border-[#B87C39]/20 border-t-[#B87C39] rounded-full animate-spin"></div>
                    <p class="text-[10px] font-bold uppercase tracking-widest animate-pulse">Mencari racikan terbaik...</p>
                </div>

                {{-- State: Not Found --}}
                <div x-show="!loading && results.length === 0" class="py-10 text-center px-6">
                    <div class="w-12 h-12 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 border border-gray-100 text-gray-300">
                        <svg viewBox="0 0 24 24" class="w-6 h-6 fill-none stroke-current" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                    </div>
                    <p class="text-sm text-gray-500">Kafe <strong class="text-gray-900" x-text="'&quot;' + query + '&quot;'"></strong> belum ada di radar kami.</p>
                </div>

                {{-- State: Results Found --}}
                <div x-show="!loading && results.length > 0">
                    <div class="px-6 py-3 bg-gray-50/50 border-b border-gray-100 text-[10px] font-bold text-[#B87C39] uppercase tracking-widest">
                        <span x-text="results.length"></span> Kafe Ditemukan
                    </div>

                    <template x-for="item in results" :key="item.id_kafe">
                        <a :href="'/explore/' + item.id_kafe" class="flex items-center gap-5 px-6 py-4 hover:bg-gray-50 transition-colors group border-b border-gray-50 last:border-0 border-collapse">
                            <div class="w-12 h-12 rounded-2xl bg-[#B87C39]/10 flex items-center justify-center text-[#B87C39] group-hover:bg-[#B87C39] group-hover:text-white transition-all duration-300">
                                <svg viewBox="0 0 24 24" class="w-6 h-6 fill-none stroke-current" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M17 8h1a4 4 0 1 1 0 8h-1M3 8h14v9a4 4 0 0 1-4 4H7a4 4 0 0 1-4-4V8z"/>
                                    <path d="M6 2v2M10 2v2M14 2v2"/>
                                </svg>
                            </div>
                            <div class="flex-1 text-left">
                                <h4 class="text-base font-bold text-gray-900 group-hover:text-[#B87C39] transition-colors" x-text="item.nama_kafe"></h4>
                                <p class="text-sm text-gray-400 flex items-center gap-1.5 mt-1">
                                    <svg viewBox="0 0 24 24" class="w-3.5 h-3.5 text-[#B87C39]/70 fill-none stroke-current" stroke-width="2"><path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0z"/><circle cx="12" cy="10" r="3"/></svg>
                                    <span x-text="item.jarak ? item.jarak + ' km' : 'Malang'"></span>
                                    <span class="text-gray-200">•</span>
                                    <span class="line-clamp-1" x-text="item.alamat"></span>
                                </p>
                            </div>
                            <svg viewBox="0 0 24 24" class="w-5 h-5 text-gray-300 group-hover:text-[#B87C39] group-hover:translate-x-1 transition-all fill-none stroke-current" stroke-width="2.5"><path d="m9 18 6-6-6-6"/></svg>
                        </a>
                    </template>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 md:px-8 space-y-16">
        
        {{-- Section: Kafe Terdekat --}}
        @include('components.user.ui.user-discovery-row', [
            'title' => 'Dekat dari Kampus',
            'subtitle' => 'Hemat waktu, hemat tenaga. Ini kafe yang paling dekat dengan titik kumpulmu.',
            'cafes' => $terdekat,
            'category' => 'terdekat'
        ])

        {{-- Section: Fasilitas Sultan --}}
        @include('components.user.ui.user-discovery-row', [
            'title' => 'Fasilitas Paling Sultan',
            'subtitle' => 'WiFi kencang, banyak colokan, hingga ruang AC. Lengkap semuanya ada di sini.',
            'cafes' => $sultan,
            'category' => 'fasilitas'
        ])

        {{-- Section: Variasi Menu --}}
        @include('components.user.ui.user-discovery-row', [
            'title' => 'Si Paling Lengkap Menunya',
            'subtitle' => 'Lagi pengen banyak pilihan? Kafe-kafe ini punya variasi menu paling melimpah.',
            'cafes' => $menuLengkap,
            'category' => 'menu'
        ])

        {{-- Section: 24 Jam --}}
        @include('components.user.ui.user-discovery-row', [
            'title' => 'Nugas Sampai Pagi (24 Jam)',
            'subtitle' => 'Butuh tempat nugas atau nongkrong saat tengah malam? Cek daftar kafe 24 jam ini.',
            'cafes' => $buka24jam,
            'category' => '24jam'
        ])

    </div>
</div>
@endsection

