@extends('layouts.user')

@section('title', $cafe->nama_kafe . ' — Ngafein')
@section('navbar-dark-text', 'true')

@section('content')

    <section class="max-w-7xl mx-auto px-4 md:px-8 pt-32 md:pt-40">
        <x-user.ui.user-back-button class="mb-6" />
        @php
            $images = $cafe->gambar->pluck('link_gambar')->toArray();
            $count = count($images);
            $placeholder = "https://images.unsplash.com/photo-1554118811-1e0d58224f24?auto=format&fit=crop&q=80&w=1200";
            $allImages = $count > 0 ? $images : [$placeholder];
            $displayCount = count($allImages);
        @endphp

        @if($count <= 1)
            <div class="h-[380px] md:h-[480px] rounded-2xl overflow-hidden shadow-sm border border-gray-100/50 relative group cursor-pointer"
                 onclick="openLightbox(0)">
                <img src="{{ $allImages[0] }}" alt="Foto {{ $cafe->nama_kafe }}"
                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-in-out">
                <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-all duration-300 flex items-center justify-center">
                    <span class="bg-white/90 backdrop-blur-sm text-gray-900 font-bold px-6 py-2.5 rounded-full opacity-0 group-hover:opacity-100 transition-all shadow-xl flex items-center">
                        <i data-lucide="maximize-2" class="w-4 h-4 mr-2 text-[#b87c39]"></i> Perbesar Foto
                    </span>
                </div>
            </div>

        @elseif($count == 2)
            <div class="grid grid-cols-2 gap-3 h-[380px] md:h-[480px] rounded-2xl overflow-hidden shadow-sm">
                @foreach($allImages as $index => $img)
                    <div class="relative group cursor-pointer overflow-hidden" onclick="openLightbox({{ $index }})">
                        <img src="{{ $img }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-all"></div>
                    </div>
                @endforeach
            </div>

        @elseif($count == 3)
            <div class="grid grid-cols-4 grid-rows-2 gap-3 h-[380px] md:h-[480px] rounded-2xl overflow-hidden shadow-sm">
                <div class="col-span-3 row-span-2 relative group cursor-pointer overflow-hidden" onclick="openLightbox(0)">
                    <img src="{{ $allImages[0] }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                    <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-all"></div>
                </div>
                <div class="col-span-1 row-span-1 relative group cursor-pointer overflow-hidden" onclick="openLightbox(1)">
                    <img src="{{ $allImages[1] }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-all"></div>
                </div>
                <div class="col-span-1 row-span-1 relative group cursor-pointer overflow-hidden" onclick="openLightbox(2)">
                    <img src="{{ $allImages[2] }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-all"></div>
                </div>
            </div>

        @else
            <div class="grid grid-cols-4 grid-rows-2 gap-3 h-[380px] md:h-[480px] rounded-2xl overflow-hidden shadow-sm border border-gray-100/50">
                <div class="col-span-4 md:col-span-2 row-span-2 relative group cursor-pointer overflow-hidden" onclick="openLightbox(0)">
                    <img src="{{ $allImages[0] }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                    <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-all"></div>
                </div>

                <div class="col-span-2 md:col-span-1 row-span-1 overflow-hidden relative group cursor-pointer" onclick="openLightbox(1)">
                    <img src="{{ $allImages[1] }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                </div>

                <div class="col-span-2 md:col-span-1 row-span-1 overflow-hidden relative group cursor-pointer" onclick="openLightbox(2)">
                    <img src="{{ $allImages[2] }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                </div>

                <div class="col-span-4 md:col-span-2 row-span-1 relative group cursor-pointer overflow-hidden" onclick="openLightbox(3)">
                    <img src="{{ $allImages[3] }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 opacity-90">
                    <div class="absolute inset-0 flex items-center justify-center bg-black/30 group-hover:bg-black/40 transition-all">
                        <span class="bg-white/95 backdrop-blur-md text-gray-900 font-bold px-8 py-3 rounded-full shadow-xl flex items-center gap-2">
                            <i data-lucide="images" class="w-5 h-5 text-[#b87c39]"></i>
                            @if($count > 4)
                                +{{ $count - 3 }} Foto Lainnya
                            @else
                                Tampilkan Semua Foto
                            @endif
                        </span>
                    </div>
                </div>
            </div>
        @endif
    </section>

    <div id="lightbox" class="fixed inset-0 z-50 hidden items-center justify-center"
         style="background: rgba(0,0,0,0.92); backdrop-filter: blur(8px);">
        <button onclick="closeLightbox()" class="absolute top-5 right-5 text-white/70 hover:text-white transition-colors z-10">
            <i data-lucide="x" class="w-8 h-8"></i>
        </button>

        <button onclick="prevImage()" class="absolute left-4 md:left-8 text-white/70 hover:text-white transition-colors z-10">
            <i data-lucide="chevron-left" class="w-10 h-10"></i>
        </button>

        <div class="w-full h-full flex flex-col items-center justify-center p-4 md:p-12">
            <div class="relative w-full max-w-5xl h-[80vh] flex items-center justify-center">
                <img id="lightbox-img" src="" alt=""
                     class="w-full h-full object-contain rounded-lg shadow-2xl transition-opacity duration-300">
            </div>
            <div class="flex items-center gap-3 mt-6">
                @foreach($allImages as $idx => $img)
                <button onclick="goToImage({{ $idx }})"
                        class="lightbox-dot w-2.5 h-2.5 rounded-full bg-white/30 hover:bg-white transition-all duration-200"
                        id="dot-{{ $idx }}"></button>
                @endforeach
            </div>
            <p id="lightbox-counter" class="text-white/50 text-xs mt-3 font-medium">1 / {{ count($allImages) }}</p>
        </div>

        <button onclick="nextImage()" class="absolute right-4 md:right-8 text-white/70 hover:text-white transition-colors z-10">
            <i data-lucide="chevron-right" class="w-10 h-10"></i>
        </button>
    </div>

    <section class="max-w-7xl mx-auto px-4 md:px-8 pt-8 md:pt-12">


        <div class="flex flex-col lg:flex-row gap-10">

            <div class="flex-1">

                <div class="flex items-center gap-3 mb-4">
                    <span class="bg-[#b87c39] text-white text-xs font-bold px-4 py-1.5 rounded-full uppercase tracking-widest">
                        {{ $cafe->menus->first()->nama_menu ?? 'Cafe' }}
                    </span>
                    <span class="flex items-center gap-1.5 text-gray-500 text-sm font-medium">
                        <i data-lucide="map-pin" class="w-3.5 h-3.5 text-[#b87c39]"></i>
                        Berjarak <strong class="text-gray-900 ml-1">{{ $cafe->jarak }} km</strong>
                    </span>
                </div>

                <div class="flex items-center justify-between gap-4 mb-4">
                    <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 tracking-tight leading-tight">
                        {{ $cafe->nama_kafe }}
                    </h1>
                    <x-user.ui.bookmark-button :kafe="$cafe" :isDetail="true" />
                </div>

                @php
                    $rating = $cafe->rating;
                    $fullStars = floor($rating);
                    $halfStar = ($rating - $fullStars) >= 0.4;
                    $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);
                    $ratingLabel = match(true) {
                        $rating >= 4.8 => 'Luar Biasa',
                        $rating >= 4.5 => 'Sangat Bagus',
                        $rating >= 4.0 => 'Bagus',
                        $rating >= 3.5 => 'Cukup Bagus',
                        default => 'Biasa',
                    };
                @endphp
                <div class="flex items-center gap-3 mb-8 pb-8 border-b border-[#b87c39]/20">
                    <span class="text-2xl font-extrabold text-gray-900 tabular-nums">{{ number_format($rating, 1) }}</span>
                    <div class="flex items-center gap-0.5">
                        @for($i = 0; $i < $fullStars; $i++)
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="#b87c39" stroke="#b87c39" stroke-width="1">
                                <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                            </svg>
                        @endfor
                        @if($halfStar)
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24">
                                <defs><linearGradient id="half"><stop offset="50%" stop-color="#b87c39"/><stop offset="50%" stop-color="#d1d5db"/></linearGradient></defs>
                                <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" fill="url(#half)" stroke="#b87c39" stroke-width="0.5"/>
                            </svg>
                        @endif
                        @for($i = 0; $i < $emptyStars; $i++)
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="#d1d5db" stroke-width="1.5">
                                <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                            </svg>
                        @endfor
                    </div>
                    <span class="text-sm font-semibold text-[#b87c39] bg-amber-50 px-3 py-1 rounded-full border border-amber-100">
                        {{ $ratingLabel }}
                    </span>
                </div>

                <div class="mb-8">
                    <h3 class="text-sm font-bold mb-2 text-gray-900 flex items-center gap-2">
                        <span class="w-1 h-4 bg-[#b87c39] rounded-full inline-block"></span>
                        Tentang Kafe
                    </h3>
                    <p class="text-gray-500 leading-relaxed text-sm">{{ $cafe->deskripsi ?? 'Belum ada deskripsi untuk kafe ini.' }}</p>
                </div>

                <div class="mb-8">
                    <h3 class="text-sm font-bold mb-4 text-gray-900 flex items-center gap-2">
                        <span class="w-1 h-4 bg-[#b87c39] rounded-full inline-block"></span>
                        Fasilitas
                    </h3>
                    <div class="flex flex-wrap gap-2.5">
                        @php
                        $fasilitasIcons = [
                            'wifi'          => 'wifi',
                            'colokan'       => 'zap',
                            'parkir'        => 'car',
                            'toilet'        => 'bath',
                            'mushola'       => 'moon',
                            'indoor'        => 'home',
                            'outdoor'       => 'sun',
                            'semi_outdoor'  => 'cloud-sun',
                            'rooftop'       => 'mountain',
                            'smoking_area'  => 'cigarette',
                            'smoking_indoor'=> 'cigarette',
                            'workspace'     => 'laptop',
                            'live_music'    => 'music',
                            'meeting_room'  => 'users',
                            'private_room'  => 'key',
                            'vip_room'      => 'crown',
                            'playground'    => 'smile',
                            'shisha'        => 'wind',
                            'garden'        => 'leaf',
                        ];
                        @endphp
                        @foreach($cafe->fasilitas as $fas)
                        @php 
                            $key = strtolower($fas->nama_fasilitas); 
                            $iconClass = $fasilitasIcons[$key] ?? 'fa-check'; 
                        @endphp
                        <span class="inline-flex items-center gap-2.5 text-sm font-semibold text-gray-700 bg-white border border-gray-200 px-4 py-2.5 rounded-xl hover:border-[#b87c39] hover:text-[#b87c39] hover:bg-[#b87c39]/5 transition-all cursor-default capitalize shadow-sm">
                            <i data-lucide="{{ $iconClass }}" class="w-4 h-4 text-[#b87c39]"></i>
                            {{ str_replace('_', ' ', $fas->nama_fasilitas) }}
                        </span>
                        @endforeach
                    </div>
                </div>

                <div class="mb-8">
                    <h3 class="text-sm font-bold mb-4 text-gray-900 flex items-center gap-2">
                        <span class="w-1 h-4 bg-[#b87c39] rounded-full inline-block"></span>
                        Kategori Menu
                    </h3>
                    <div class="flex flex-wrap gap-2.5">
                        @php
                        $menuIcons = [
                            'kopi'          => 'coffee',
                            'coffee'        => 'coffee',
                            'non-kopi'      => 'glass-water',
                            'makanan'       => 'utensils',
                            'food'          => 'utensils',
                            'snack'         => 'cookie',
                            'pastry'        => 'cake',
                            'teh'           => 'leaf',
                            'tea'           => 'leaf',
                            'dessert'       => 'ice-cream',
                        ];
                        @endphp
                        @foreach($cafe->menus as $menu)
                        @php 
                            $mKey = strtolower($menu->nama_menu);
                            $mIcon = $menuIcons[$mKey] ?? 'fa-bowl-food';
                        @endphp
                        <span class="inline-flex items-center gap-2.5 text-sm font-semibold text-gray-700 bg-white border border-gray-200 px-4 py-2.5 rounded-xl hover:border-[#b87c39] hover:text-[#b87c39] hover:bg-[#b87c39]/5 transition-all cursor-pointer capitalize shadow-sm">
                            <i data-lucide="{{ $mIcon }}" class="w-4 h-4 text-[#b87c39]"></i>
                            {{ str_replace('_', ' ', $menu->nama_menu) }}
                        </span>
                        @endforeach
                    </div>
                </div>

            </div>

            <aside class="w-full lg:w-[380px] flex-shrink-0">
                <div class="sticky top-20 space-y-4">

                    <div class="bg-white border border-gray-100 rounded-2xl p-6 shadow-sm space-y-4">
                        <div>
                            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mb-1">Rentang Harga</p>
                            <p class="text-xl font-extrabold text-gray-900">
                                Rp {{ number_format($cafe->harga_min, 0, ',', '.') }}
                                <span class="text-gray-300 font-light mx-1">—</span>
                                Rp {{ number_format($cafe->harga_max, 0, ',', '.') }}
                            </p>
                        </div>

                        <div class="flex items-center gap-3 bg-gray-50 rounded-xl px-4 py-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-[#b87c39] flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                            </svg>
                            <div class="flex-1 min-w-0">
                                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Jam Operasional</p>
                                <p class="font-bold text-gray-800 text-sm">{{ $cafe->jam_buka }} — {{ $cafe->jam_tutup }}</p>
                            </div>
                            <span class="flex items-center gap-1 text-[10px] font-bold text-emerald-600 bg-emerald-50 border border-emerald-100 px-2 py-0.5 rounded-full whitespace-nowrap">
                                <span class="w-1 h-1 rounded-full bg-emerald-500 animate-pulse"></span> Buka
                            </span>
                        </div>

                        <a href="{{ $cafe->link_maps }}" target="_blank" rel="noreferrer"
                           class="group w-full flex items-center justify-between bg-[#b87c39] hover:bg-[#9a662e] text-white text-sm font-semibold px-4 py-3 rounded-xl transition-all duration-200 shadow-sm">
                            <span class="flex items-center gap-2">
                                <i data-lucide="navigation" class="w-4 h-4"></i>
                                Buka Petunjuk Arah
                            </span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 group-hover:translate-x-0.5 transition-transform" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                        </a>
                    </div>

                    <a href="{{ $cafe->link_maps }}" target="_blank" rel="noreferrer"
                       class="group block bg-white border border-gray-100 rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition-all duration-300">
                        <div class="relative h-48 overflow-hidden bg-gray-100">
                            <img
                                src="https://tile.openstreetmap.org/14/6567/4370.png"
                                onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1477959858617-67f85cf4f1df?auto=format&fit=crop&q=80&w=840&h=400';"
                                alt="Peta {{ $cafe->nama_kafe }}"
                                class="w-full h-full object-cover grayscale group-hover:grayscale-0 scale-110 group-hover:scale-105 transition-all duration-700">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>
                            <div class="absolute inset-0 flex items-center justify-center">
                                <div class="bg-white shadow-xl rounded-full p-3 ring-4 ring-white/60 group-hover:scale-110 transition-transform duration-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-[#b87c39]" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                                    </svg>
                                </div>
                            </div>
                            <span class="absolute bottom-3 right-3 text-[10px] font-bold text-white bg-black/40 backdrop-blur-sm px-2 py-1 rounded-full">Klik untuk Maps</span>
                        </div>
                        <div class="p-4 flex items-start gap-2.5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-[#b87c39] flex-shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                                <circle cx="12" cy="10" r="3"/>
                            </svg>
                            <p class="text-gray-500 text-xs leading-relaxed">{{ $cafe->alamat }}</p>
                        </div>
                    </a>

                </div>
            </aside>

        </div>
    </section>

    {{-- Ulasan Pengguna (Modern SaaS-Style) --}}
    <section class="max-w-7xl mx-auto px-4 md:px-8 py-16 border-t border-[#b87c39]/10">
        <div class="mb-10">
            <p class="text-xs font-bold text-[#b87c39] uppercase tracking-widest mb-1">Ulasan Komunitas</p>
            <h2 class="text-2xl md:text-3xl font-extrabold text-gray-900 tracking-tight">Apa Kata Pengunjung?</h2>
        </div>

        @if(session('success_review'))
            <div class="mb-8 p-4 bg-emerald-50 border border-emerald-100 text-emerald-800 text-sm font-semibold rounded-2xl">
                {{ session('success_review') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10 items-start">
            
            {{-- Statistik Rating (Left Column) --}}
            <div class="bg-gray-50/50 rounded-3xl p-8 border border-gray-200/40">
                <h3 class="text-base font-bold text-gray-900 mb-4">Statistik Rating</h3>
                <div class="flex items-baseline gap-2 mb-4">
                    <span class="text-5xl font-black text-gray-900 tracking-tight">{{ number_format($cafe->rating, 1) }}</span>
                    <span class="text-sm font-bold text-gray-400">/ 5.0</span>
                </div>
                
                {{-- Stars --}}
                <div class="flex items-center gap-1 mb-6">
                    @php
                        $fullStars = floor($cafe->rating);
                        $halfStar = ($cafe->rating - $fullStars) >= 0.4;
                    @endphp
                    @for($i = 0; $i < 5; $i++)
                        @if($i < $fullStars)
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 fill-amber-400 text-amber-400" viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                        @elseif($i == $fullStars && $halfStar)
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24"><defs><linearGradient id="half-star"><stop offset="50%" stop-color="#fbbf24"/><stop offset="50%" stop-color="#d1d5db"/></linearGradient></defs><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" fill="url(#half-star)" stroke="#fbbf24" stroke-width="0.5"/></svg>
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-200 fill-gray-200" viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                        @endif
                    @endfor
                </div>

                <div class="space-y-2">
                    @php
                        $totalReviews = $cafe->reviews->count();
                    @endphp
                    @for($stars = 5; $stars >= 1; $stars--)
                        @php
                            $starCount = $cafe->reviews->where('rating', $stars)->count();
                            $percentage = $totalReviews > 0 ? ($starCount / $totalReviews) * 100 : 0;
                        @endphp
                        <div class="flex items-center gap-3 text-xs font-bold text-gray-500">
                            <span class="w-3 text-right">{{ $stars }}</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 fill-amber-400 text-amber-400 shrink-0" viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                            <div class="flex-1 h-2 bg-gray-200 rounded-full overflow-hidden">
                                <div class="bg-[#b87c39] h-full rounded-full" style="width: {{ $percentage }}%"></div>
                            </div>
                            <span class="w-8 text-right text-gray-400">{{ $starCount }}</span>
                        </div>
                    @endfor
                </div>
            </div>

            {{-- Formulir Review (Center Column) --}}
            <div class="lg:col-span-2 space-y-8">
                @auth
                    <div class="bg-white border border-gray-100 rounded-3xl p-6 md:p-8 shadow-sm">
                        <h3 class="text-lg font-extrabold text-gray-900 mb-2">Tulis Ulasan Anda</h3>
                        <p class="text-xs text-gray-400 font-medium mb-6">Bagikan pengalaman Anda tentang {{ $cafe->nama_kafe }} kepada mahasiswa lainnya.</p>
                        
                        <form action="{{ route('user.kafe.review.store', $cafe->id_kafe) }}" 
                              method="POST" 
                              x-data="{ userRating: 5, ulasanText: '', ulasanError: '' }"
                              @submit="if (ulasanText.trim().length < 5) { ulasanError = ulasanText.trim().length === 0 ? 'Isi ulasan wajib ditulis!' : 'Isi ulasan minimal 5 karakter!'; $event.preventDefault(); }">
                            @csrf
                            <input type="hidden" name="rating" :value="userRating">
                            
                            <div class="mb-5">
                                <label class="block text-[10px] font-bold text-[#2B1A09] uppercase tracking-wider mb-2">Rating Anda</label>
                                <div class="flex items-center gap-1.5">
                                    <template x-for="i in 5">
                                        <button type="button" @click="userRating = i" class="cursor-pointer focus:outline-none">
                                            <svg xmlns="http://www.w3.org/2000/svg" 
                                                 class="w-8 h-8 transition-colors duration-200" 
                                                 :class="i <= userRating ? 'fill-amber-400 text-amber-400' : 'text-gray-200 fill-gray-200'" 
                                                 viewBox="0 0 24 24">
                                                <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                                            </svg>
                                        </button>
                                    </template>
                                </div>
                            </div>

                            <div class="mb-5">
                                <label class="block text-[10px] font-bold text-[#2B1A09] uppercase tracking-wider mb-2">Komentar / Ulasan</label>
                                <textarea name="ulasan" rows="4" 
                                          x-model="ulasanText"
                                          @input="if (ulasanText.trim().length >= 5) { ulasanError = ''; }"
                                          class="w-full bg-gray-50 border border-gray-200 rounded-2xl px-5 py-3.5 text-sm outline-none focus:border-[#B87C39] focus:ring-1 focus:ring-[#B87C39] transition-all resize-none"
                                          placeholder="Bagikan pendapat Anda tentang tempat ini (Minimal 5 karakter)..."></textarea>
                                <template x-if="ulasanError">
                                    <p class="text-red-500 text-xs mt-1.5 font-medium" x-text="ulasanError"></p>
                                </template>
                                @error('ulasan') <p class="text-red-500 text-xs mt-1.5 font-medium" x-show="!ulasanError">{{ $message }}</p> @enderror
                            </div>

                            <button type="submit" 
                                    class="bg-[#B87C39] hover:bg-[#2B1A09] text-white font-bold text-xs px-6 py-3.5 rounded-xl transition-all shadow-md shadow-[#B87C39]/10 hover:shadow-[#2B1A09]/20 cursor-pointer">
                                Kirim Ulasan
                            </button>
                        </form>
                    </div>
                @else
                    <div class="bg-gray-50 border border-dashed border-gray-200 rounded-3xl p-8 text-center flex flex-col items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-gray-400 mb-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                        <h4 class="text-sm font-bold text-gray-900 mb-1">Masuk Untuk Menulis Ulasan</h4>
                        <p class="text-xs text-gray-400 max-w-xs mb-5 font-medium">Bantu mahasiswa lain menemukan sudut ternyaman dengan berbagi ulasan jujur Anda.</p>
                        <button @click="$dispatch('open-login-modal')" 
                                class="bg-[#B87C39] hover:bg-[#2B1A09] text-white font-bold text-xs px-5 py-3 rounded-xl transition-all cursor-pointer">
                            Masuk Sekarang
                        </button>
                    </div>
                @endauth

                {{-- Ulasan Lists --}}
                <div class="space-y-4">
                    <h3 class="text-sm font-bold uppercase tracking-wider text-[#2B1A09] flex items-center gap-2">
                        <span class="w-1.5 h-4 bg-[#B87C39] rounded-full"></span>
                        Semua Ulasan ({{ $totalReviews }})
                    </h3>
                    
                    @forelse($cafe->reviews as $rev)
                        <div class="bg-white border border-gray-100 rounded-2xl p-5 shadow-sm space-y-3.5">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-[#B87C39]/10 text-[#B87C39] flex items-center justify-center font-bold text-[10px] uppercase overflow-hidden">
                                        <span>{{ substr($rev->user->name ?? 'U', 0, 2) }}</span>
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold text-gray-900">{{ $rev->user->name ?? 'User Anonim' }}</p>
                                        <p class="text-[10px] text-gray-400 font-medium">{{ $rev->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-0.5">
                                    @for($i = 0; $i < 5; $i++)
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 {{ $i < $rev->rating ? 'fill-amber-400 text-amber-400' : 'text-gray-200 fill-gray-200' }}" viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                                    @endfor
                                </div>
                            </div>
                            <p class="text-xs text-gray-500 font-medium leading-relaxed">{{ $rev->ulasan }}</p>
                        </div>
                    @empty
                        <div class="py-8 text-center text-gray-100/50">
                            <p class="text-xs font-medium text-gray-400">Belum ada ulasan untuk kafe ini. Jadilah yang pertama!</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </section>

    <section class="max-w-7xl mx-auto px-4 md:px-8 py-20">
        <div class="flex items-end justify-between mb-8">
            <div>
                <p class="text-xs font-bold text-[#b87c39] uppercase tracking-widest mb-1">Mungkin Kamu Suka</p>
                <h2 class="text-2xl md:text-3xl font-extrabold text-gray-900 tracking-tight">Jelajahi Kafe Lainnya</h2>
            </div>
            <a href="{{ route('user.explore.index') }}" class="hidden md:flex items-center gap-2 text-sm font-semibold text-[#b87c39] hover:text-[#9a662e] transition-colors group">
                Lihat Semua
                <i data-lucide="arrow-right" class="w-4 h-4 group-hover:translate-x-1 transition-transform"></i>
            </a>
        </div>

        @if($rekomendasi->isEmpty())
            <div class="flex flex-col items-center justify-center py-16 text-gray-400">
                <i data-lucide="coffee" class="w-12 h-12 mb-4 opacity-30"></i>
                <p class="font-medium">Belum ada kafe lain tersedia.</p>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($rekomendasi as $k)
                    @include('components.user.ui.user-cafe-card', ['k' => $k])
                @endforeach
            </div>

            <div class="flex justify-center mt-12 md:hidden">
                <a href="{{ route('user.explore.index') }}" class="flex items-center gap-2 text-sm font-semibold text-[#b87c39] border border-[#b87c39] px-6 py-2.5 rounded-full hover:bg-[#b87c39] hover:text-white transition-all">
                    Lihat Semua Kafe <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </a>
            </div>
        @endif
    </section>

@endsection

@push('scripts')
<script>
    const images = @json($allImages);
    let current = 0;
    const total = images.length;

    function openLightbox(index) {
        current = index;
        updateLightbox();
        document.getElementById('lightbox').classList.remove('hidden');
        document.getElementById('lightbox').classList.add('flex');
        document.body.style.overflow = 'hidden';
    }

    function closeLightbox() {
        document.getElementById('lightbox').classList.add('hidden');
        document.getElementById('lightbox').classList.remove('flex');
        document.body.style.overflow = '';
    }

    function nextImage() {
        current = (current + 1) % total;
        updateLightbox();
    }

    function prevImage() {
        current = (current - 1 + total) % total;
        updateLightbox();
    }

    function goToImage(index) {
        current = index;
        updateLightbox();
    }

    function updateLightbox() {
        const img = document.getElementById('lightbox-img');
        img.style.opacity = '0';
        setTimeout(() => {
            img.src = images[current];
            img.style.opacity = '1';
        }, 150);
        document.getElementById('lightbox-counter').textContent = (current + 1) + ' / ' + total;
        document.querySelectorAll('.lightbox-dot').forEach((dot, i) => {
            dot.style.opacity = i === current ? '1' : '0.4';
            dot.style.transform = i === current ? 'scale(1.3)' : 'scale(1)';
        });
    }

    document.getElementById('lightbox').addEventListener('click', function(e) {
        if (e.target === this) closeLightbox();
    });

    document.addEventListener('keydown', function(e) {
        if (document.getElementById('lightbox').classList.contains('flex')) {
            if (e.key === 'ArrowRight') nextImage();
            if (e.key === 'ArrowLeft') prevImage();
            if (e.key === 'Escape') closeLightbox();
        }
    });
</script>
@endpush

