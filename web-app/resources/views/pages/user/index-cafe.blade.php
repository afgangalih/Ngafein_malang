@extends('layouts.user')

@section('title', 'Jelajahi Kafe — Ngafein')

@section('content')
<div class="bg-[#FBFBFB] min-h-screen pb-20">
    
    {{-- Hero Section --}}
    <div class="max-w-7xl mx-auto px-4 md:px-8 pt-20 mb-12">
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
                init() {
                    this.$watch('query', (value) => {
                        if (value.length < 2) {
                            this.results = [];
                            this.show = false;
                            return;
                        }
                        this.fetchResults();
                    });
                },
                fetchResults() {
                    this.loading = true;
                    fetch(`/cafe/search-api?q=${this.query}`)
                        .then(res => res.json())
                        .then(data => {
                            this.results = data;
                            this.show = true;
                            this.loading = false;
                        })
                        .catch(() => {
                            this.loading = false;
                        });
                }
             }"
             @click.away="show = false">
            
            <div class="flex items-center bg-white border border-gray-100 rounded-2xl shadow-sm hover:shadow-md focus-within:shadow-md focus-within:border-[#b87c39]/30 transition-all duration-300">
                <div class="flex-1 relative flex items-center">
                    <div class="absolute left-7 flex items-center justify-center w-5 h-5">
                        <i class="fa-solid fa-magnifying-glass text-gray-300 text-sm transition-opacity duration-300" :class="loading ? 'opacity-0' : 'opacity-100'"></i>
                        <i class="fa-solid fa-circle-notch fa-spin text-[#b87c39] text-sm absolute transition-opacity duration-300" :class="loading ? 'opacity-100' : 'opacity-0'"></i>
                    </div>
                    <input 
                        type="text" 
                        x-model.debounce.500ms="query"
                        @focus="if(results.length > 0) show = true"
                        placeholder="Mau ngopi di mana hari ini?"
                        class="w-full pl-16 pr-8 py-4 text-sm font-medium text-gray-800 placeholder:text-gray-400 focus:outline-none bg-transparent"
                    >
                    <button x-show="query.length > 0" @click="query = ''; results = []; show = false" class="absolute right-7 text-gray-400 hover:text-gray-600 transition-colors">
                        <i class="fa-solid fa-circle-xmark text-lg"></i>
                    </button>
                </div>
            </div>

            {{-- Results Dropdown --}}
            <div x-show="show && query.length >= 2"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 translate-y-2"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 class="absolute top-full left-0 right-0 mt-3 bg-white border border-gray-100 rounded-2xl shadow-2xl overflow-hidden min-h-[100px] flex flex-col justify-center">
                
                {{-- State: Loading --}}
                <div x-show="loading" class="py-10 flex flex-col items-center justify-center gap-3">
                    <i class="fa-solid fa-circle-notch fa-spin text-[#b87c39] text-2xl"></i>
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest animate-pulse">Mencari Kafe Terbaik...</p>
                </div>

                {{-- State: Not Found --}}
                <div x-show="!loading && results.length === 0" class="py-10 flex flex-col items-center justify-center gap-3">
                    <div class="w-12 h-12 bg-gray-50 rounded-full flex items-center justify-center text-gray-300">
                        <i class="fa-solid fa-magnifying-glass text-lg"></i>
                    </div>
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest text-center px-6 leading-relaxed">
                        Maaf, kafe "<span class="text-gray-900" x-text="query"></span>" tidak ditemukan
                    </p>
                </div>

                {{-- State: Results Found --}}
                <div x-show="!loading && results.length > 0">
                    <div class="px-5 py-3 border-b border-gray-50 bg-gray-50/30">
                        <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest">Hasil Pencarian</p>
                    </div>

                    <template x-for="item in results" :key="item.id_kafe">
                        <a :href="`/cafe/${item.id_kafe}`" class="flex items-center justify-between px-5 py-4 hover:bg-gray-50 transition-colors group">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center text-[#b87c39] group-hover:bg-[#b87c39] group-hover:text-white transition-all">
                                    <i class="fa-solid fa-mug-hot text-xs"></i>
                                </div>
                                <div>
                                    <h4 class="text-sm font-bold text-gray-900" x-text="item.nama_kafe"></h4>
                                    <p class="text-[10px] text-gray-400 font-medium" x-text="`${item.jarak} km dari kampus`"></p>
                                </div>
                            </div>
                            <i class="fa-solid fa-chevron-right text-[10px] text-gray-300 group-hover:translate-x-1 transition-transform"></i>
                        </a>
                    </template>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 md:px-8 space-y-16">
        
        {{-- Section: Kafe Terdekat --}}
        @include('components.ui.user-discovery-row', [
            'title' => 'Dekat dari Kampus',
            'subtitle' => 'Hemat waktu, hemat tenaga. Ini kafe yang paling dekat dengan titik kumpulmu.',
            'cafes' => $terdekat,
            'category' => 'terdekat'
        ])

        {{-- Section: Fasilitas Sultan --}}
        @include('components.ui.user-discovery-row', [
            'title' => 'Fasilitas Paling Sultan',
            'subtitle' => 'WiFi kencang, banyak colokan, hingga ruang AC. Lengkap semuanya ada di sini.',
            'cafes' => $sultan,
            'category' => 'fasilitas'
        ])

        {{-- Section: Variasi Menu --}}
        @include('components.ui.user-discovery-row', [
            'title' => 'Si Paling Lengkap Menunya',
            'subtitle' => 'Lagi pengen banyak pilihan? Kafe-kafe ini punya variasi menu paling melimpah.',
            'cafes' => $menuLengkap,
            'category' => 'menu'
        ])

        {{-- Section: 24 Jam --}}
        @include('components.ui.user-discovery-row', [
            'title' => 'Nugas Sampai Pagi (24 Jam)',
            'subtitle' => 'Butuh tempat nugas atau nongkrong saat tengah malam? Cek daftar kafe 24 jam ini.',
            'cafes' => $buka24jam,
            'category' => '24jam'
        ])

    </div>
</div>
@endsection
