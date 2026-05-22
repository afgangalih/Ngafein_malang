{{-- resources/views/user/rekomendasi/index.blade.php --}}

@extends('layouts.user')

@section('title', 'Rekomendasi Cafe — Ngafein')
@section('navbar-dark-text', 'true')

@push('styles')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;0,800;1,700&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;1,9..40,400&display=swap');

    .rec-root   { font-family: 'DM Sans', sans-serif; background: #ffffff; }
    .rec-serif  { font-family: 'Playfair Display', serif; }

    .kafe-card {
        transition: box-shadow .3s ease, transform .3s ease;
    }
    .kafe-card:hover {
        box-shadow: 0 16px 48px rgba(0,0,0,.09);
        transform: translateY(-4px);
    }
    .kafe-card .kafe-img {
        transition: transform .5s cubic-bezier(.4,0,.2,1);
    }
    .kafe-card:hover .kafe-img { transform: scale(1.05); }

    .saw-bar { transition: width .9s cubic-bezier(.4,0,.2,1); }

    @keyframes fadeUp {
        from { opacity:0; transform:translateY(20px); }
        to   { opacity:1; transform:translateY(0); }
    }
    .fu   { animation: fadeUp .5s ease both; }
    .d1   { animation-delay:.04s; }
    .d2   { animation-delay:.10s; }
    .d3   { animation-delay:.16s; }
    .d4   { animation-delay:.22s; }
    .d5   { animation-delay:.28s; }
    .d6   { animation-delay:.34s; }

    /* ── Card tersembunyi — harus display:none agar tidak tampil ── */
    .card-hidden { display: none !important; }

    /* ── Animasi saat card di-reveal ── */
    @keyframes cardReveal {
        from { opacity:0; transform:translateY(24px); }
        to   { opacity:1; transform:translateY(0); }
    }
    .card-reveal {
        animation: cardReveal .45s ease both;
    }

    .filter-select {
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%239ca3af' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right .85rem center;
        padding-right: 2.25rem !important;
    }

    .medal-1 { background: linear-gradient(135deg,#f59e0b,#d97706); }
    .medal-2 { background: linear-gradient(135deg,#94a3b8,#64748b); }
    .medal-3 { background: linear-gradient(135deg,#fb923c,#ea580c); }
    .medal-n { background: #b87c39; }

    .fas-pill { transition: background .2s, border-color .2s, color .2s; }

    /* ── Load More button ── */
    .btn-load-more {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        border: 1.5px solid #e8e2da;
        border-radius: 14px;
        padding: 14px 32px;
        font-size: .88rem;
        font-weight: 600;
        color: #7a6050;
        background: #fff;
        cursor: pointer;
        transition: border-color .2s, color .2s, box-shadow .2s, transform .2s;
        font-family: 'DM Sans', sans-serif;
    }
    .btn-load-more:hover {
        border-color: #b87c39;
        color: #b87c39;
        box-shadow: 0 4px 20px rgba(184,124,57,.12);
        transform: translateY(-1px);
    }
    .lm-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 24px;
        height: 24px;
        border-radius: 100px;
        background: rgba(184,124,57,.10);
        color: #b87c39;
        font-size: .75rem;
        font-weight: 700;
        padding: 0 7px;
        transition: background .2s;
    }
    .btn-load-more:hover .lm-badge { background: rgba(184,124,57,.18); }
</style>
@endpush

@section('content')
<div class="rec-root min-h-screen">

{{-- ════════════ HERO ════════════ --}}
<section class="relative overflow-hidden bg-white" style="padding-top:clamp(6.5rem,13vw,10rem);padding-bottom:4rem;">
    <div class="absolute top-0 right-0 w-[600px] h-[600px] pointer-events-none"
         style="background:radial-gradient(circle at 80% 20%,rgba(184,124,57,.055),transparent 60%)"></div>
    <div class="absolute bottom-0 left-0 w-[400px] h-[400px] pointer-events-none"
         style="background:radial-gradient(circle at 10% 90%,rgba(184,124,57,.04),transparent 60%)"></div>

    <div class="max-w-7xl mx-auto px-5 md:px-8 relative z-10">
        <x-user.ui.user-back-button class="mb-10" />

        <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-10">
            <div class="fu">
                <div class="inline-flex items-center gap-2 mb-5 px-3.5 py-1.5 rounded-full border text-[11px] font-semibold tracking-[.14em] uppercase"
                     style="color:#b87c39;border-color:rgba(184,124,57,.2);background:rgba(184,124,57,.05)">
                    <i data-lucide="cpu" class="w-3.5 h-3.5"></i>
                    Rekomendasi berbasis SAW
                </div>
                <h1 class="rec-serif font-bold text-gray-900 leading-[1.06] tracking-tight"
                    style="font-size:clamp(2.6rem,5.5vw,4.2rem)">
                    Pilihan Bikin<br>
                    <em style="color:#b87c39;font-style:italic">Betah.</em>
                </h1>
                <p class="mt-5 text-gray-400 leading-relaxed max-w-md" style="font-size:.92rem;font-weight:300">
                    Setiap rekomendasi dihitung dengan mempertimbangkan harga,
                    jarak, fasilitas, dan hal-hal yang paling kamu butuhkan.
                </p>
            </div>

            <div class="fu d2 hidden lg:block shrink-0">
                <p class="text-[10px] font-semibold tracking-[.2em] uppercase text-gray-300 mb-3 text-right">Bobot Kriteria</p>
                <div class="flex flex-wrap gap-2 justify-end max-w-xs">
                    @foreach([['Harga','20%','banknote'],['Jarak','20%','map-pin'],['Fasilitas','20%','wifi'],['Menu','15%','utensils'],['Jam','15%','clock'],['Rating','10%','star']] as [$lbl,$pct,$ico])
                    <div class="flex items-center gap-1.5 bg-white border border-gray-100 rounded-full px-3 py-1.5 text-[11px] font-medium text-gray-500 shadow-sm">
                        <i data-lucide="{{ $ico }}" class="w-3 h-3" style="color:#b87c39"></i>
                        {{ $lbl }} <span class="font-bold" style="color:#b87c39">{{ $pct }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ════════════ FILTER ════════════ --}}
<section class="max-w-7xl mx-auto px-5 md:px-8 pb-6 relative z-20">
    <div class="bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-[0_2px_24px_rgba(0,0,0,.06)]">

        <button type="button" onclick="toggleFilter()"
                class="w-full flex items-center justify-between px-6 py-4 border-b border-gray-50 hover:bg-gray-50/50 transition-colors text-left">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-xl flex items-center justify-center" style="background:rgba(184,124,57,.1)">
                    <i data-lucide="sliders-horizontal" class="w-4 h-4" style="color:#b87c39"></i>
                </div>
                <span class="font-semibold text-gray-800 text-sm">Filter Preferensi</span>
                @if($sudahDicari)
                <span class="text-white text-[10px] font-bold px-2.5 py-0.5 rounded-full tracking-wide" style="background:#b87c39">AKTIF</span>
                @endif
            </div>
            <i data-lucide="chevron-down" id="chevron-icon" class="w-4 h-4 text-gray-300"
               style="transition:transform .3s;transform:rotate(180deg)"></i>
        </button>

        <div id="filter-body">
            <form method="GET" action="{{ route('user.kafe.rekomendasi') }}" class="p-6 md:p-7">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-x-6 gap-y-5">

                    <div>
                        <label class="block text-[10px] font-semibold text-gray-400 uppercase tracking-[.12em] mb-2">
                            <i data-lucide="banknote" class="w-3 h-3 inline mr-1" style="color:#b87c39"></i>Harga Maksimal
                        </label>
                        <select name="harga_max" class="filter-select w-full border border-gray-200 rounded-xl px-3.5 py-2.5 text-sm text-gray-700 font-medium bg-white focus:outline-none focus:ring-2 focus:ring-[#b87c39]/20 focus:border-[#b87c39] transition">
                            <option value="">Semua Harga</option>
                            <option value="25000"  @selected(request('harga_max')=='25000') >Rp 1 – 25.000 · Murah</option>
                            <option value="50000"  @selected(request('harga_max')=='50000') >Rp 25.000 – 50.000 · Sedang</option>
                            <option value="999999" @selected(request('harga_max')=='999999')>≥ Rp 50.000 · Mahal</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-[10px] font-semibold text-gray-400 uppercase tracking-[.12em] mb-2">
                            <i data-lucide="map-pin" class="w-3 h-3 inline mr-1" style="color:#b87c39"></i>Jarak Maksimal
                        </label>
                        <select name="jarak_max" class="filter-select w-full border border-gray-200 rounded-xl px-3.5 py-2.5 text-sm text-gray-700 font-medium bg-white focus:outline-none focus:ring-2 focus:ring-[#b87c39]/20 focus:border-[#b87c39] transition">
                            <option value="">Semua Jarak</option>
                            <option value="1"   @selected(request('jarak_max')=='1')  >Sangat Dekat · &lt; 1 km</option>
                            <option value="2"   @selected(request('jarak_max')=='2')  >Dekat · 1 – 2 km</option>
                            <option value="4"   @selected(request('jarak_max')=='4')  >Cukup Jauh · 2 – 4 km</option>
                            <option value="6"   @selected(request('jarak_max')=='6')  >Jauh · 4 – 6 km</option>
                            <option value="999" @selected(request('jarak_max')=='999')>Sangat Jauh · &gt; 6 km</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-[10px] font-semibold text-gray-400 uppercase tracking-[.12em] mb-2">
                            <i data-lucide="clock" class="w-3 h-3 inline mr-1" style="color:#b87c39"></i>Durasi Buka Minimal
                        </label>
                        <select name="jam_operasional" class="filter-select w-full border border-gray-200 rounded-xl px-3.5 py-2.5 text-sm text-gray-700 font-medium bg-white focus:outline-none focus:ring-2 focus:ring-[#b87c39]/20 focus:border-[#b87c39] transition">
                            <option value="">Semua Durasi</option>
                            <option value="1"  @selected(request('jam_operasional')=='1') >Sangat Singkat · 1–5 Jam</option>
                            <option value="6"  @selected(request('jam_operasional')=='6') >Singkat · 6–10 Jam</option>
                            <option value="11" @selected(request('jam_operasional')=='11')>Cukup Lama · 11–15 Jam</option>
                            <option value="16" @selected(request('jam_operasional')=='16')>Lama · 16–20 Jam</option>
                            <option value="21" @selected(request('jam_operasional')=='21')>Sangat Lama · 21–24 Jam</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-[10px] font-semibold text-gray-400 uppercase tracking-[.12em] mb-2">
                            <i data-lucide="utensils" class="w-3 h-3 inline mr-1" style="color:#b87c39"></i>Variasi Menu Minimal
                        </label>
                        <select name="menu_min" class="filter-select w-full border border-gray-200 rounded-xl px-3.5 py-2.5 text-sm text-gray-700 font-medium bg-white focus:outline-none focus:ring-2 focus:ring-[#b87c39]/20 focus:border-[#b87c39] transition">
                            <option value="">Semua Variasi</option>
                            <option value="1" @selected(request('menu_min')=='1')>Sangat Sedikit · 1–2 Kat.</option>
                            <option value="3" @selected(request('menu_min')=='3')>Sedikit · 3–4 Kat.</option>
                            <option value="5" @selected(request('menu_min')=='5')>Cukup Banyak · 5 Kat.</option>
                            <option value="6" @selected(request('menu_min')=='6')>Banyak · 6 Kat.</option>
                            <option value="7" @selected(request('menu_min')=='7')>Sangat Banyak · ≥ 7 Kat.</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-[10px] font-semibold text-gray-400 uppercase tracking-[.12em] mb-2">
                            <i data-lucide="star" class="w-3 h-3 inline mr-1" style="color:#b87c39"></i>Rating Minimal
                        </label>
                        <div class="flex gap-1.5" id="star-btns">
                            @foreach([[''  ,'Semua'],['4.2','4.2+'],['4.4','4.4+'],['4.6','4.6+'],['4.8','4.8+']] as [$val,$lbl])
                            @php $act = request('rating_min') == $val; @endphp
                            <button type="button" data-val="{{ $val }}"
                                    class="star-btn flex-1 py-2.5 rounded-xl border text-[11px] font-semibold transition-all"
                                    style="{{ $act ? 'background:#b87c39;border-color:#b87c39;color:#fff' : 'background:#fff;border-color:#e5e7eb;color:#6b7280' }}">
                                {{ $lbl }}
                            </button>
                            @endforeach
                        </div>
                        <input type="hidden" name="rating_min" id="rating_min" value="{{ request('rating_min','') }}">
                    </div>

                </div>

                @if($semuaFasilitas->isNotEmpty())
                <div class="mt-5 pt-5 border-t border-gray-50">
                    <label class="block text-[10px] font-semibold text-gray-400 uppercase tracking-[.12em] mb-1">
                        <i data-lucide="wifi" class="w-3 h-3 inline mr-1" style="color:#b87c39"></i>Fasilitas yang Diinginkan
                    </label>
                    <p class="text-[11px] text-gray-400 mb-3" style="font-weight:300">
                        Centang fasilitas yang <strong class="font-semibold text-gray-500">wajib ada</strong>.
                        Semakin banyak yang dimiliki cafe, semakin tinggi skornya.
                    </p>
                    @php
                        $fasIconMap = ['colokan'=>'zap','indoor'=>'home','mushola'=>'moon','outdoor'=>'trees',
                                       'parkir'=>'car','rooftop'=>'building-2','semi_outdoor'=>'wind',
                                       'semi outdoor'=>'wind','toilet'=>'bath','wifi'=>'wifi'];
                    @endphp
                    <div class="flex flex-wrap gap-2">
                        @foreach($semuaFasilitas as $fas)
                        @php
                            $checked = in_array($fas->id_fasilitas,(array)request('fasilitas',[]));
                            $slug    = strtolower(str_replace(' ','_',$fas->nama_fasilitas));
                            $fasIco  = $fasIconMap[$slug] ?? $fasIconMap[strtolower($fas->nama_fasilitas)] ?? 'check-circle';
                        @endphp
                        <label class="fas-label cursor-pointer select-none">
                            <input type="checkbox" name="fasilitas[]" value="{{ $fas->id_fasilitas }}"
                                   class="fas-check sr-only" {{ $checked ? 'checked' : '' }}>
                            <span class="fas-pill inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl border text-xs font-medium capitalize"
                                  style="{{ $checked ? 'background:#b87c39;border-color:#b87c39;color:#fff' : 'background:#fff;border-color:#e5e7eb;color:#374151' }}">
                                <i data-lucide="{{ $fasIco }}" class="w-3.5 h-3.5"></i>
                                <i data-lucide="check" class="fas-check-icon w-3 h-3 {{ $checked ? '' : 'hidden' }}"></i>
                                {{ str_replace('_',' ',$fas->nama_fasilitas) }}
                            </span>
                        </label>
                        @endforeach
                    </div>
                    <p class="mt-3 flex items-center gap-1.5 text-[11px]" style="color:#9ca3af;font-weight:300">
                        <i data-lucide="info" class="w-3 h-3 flex-shrink-0" style="color:#b87c39"></i>
                        <span id="fas-count-label">
                            @php $sc = count((array)request('fasilitas',[])); @endphp
                            @if($sc > 0)
                                <strong style="color:#b87c39">{{ $sc }} fasilitas</strong> dipilih —
                                @if($sc<=2)Tidak Lengkap (skor 1)
                                @elseif($sc<=4)Kurang Lengkap (skor 2)
                                @elseif($sc<=6)Cukup Lengkap (skor 3)
                                @elseif($sc<=8)Lengkap (skor 4)
                                @else Sangat Lengkap (skor 5)
                                @endif
                            @else
                                Pilih fasilitas untuk menyaring cafe
                            @endif
                        </span>
                    </p>
                </div>
                @endif

                <div class="flex items-center gap-3 mt-7 pt-6 border-t border-gray-50">
                    <button type="submit"
                            class="inline-flex items-center gap-2 text-white text-sm font-semibold px-8 py-3 rounded-xl transition-all hover:-translate-y-0.5 hover:shadow-lg"
                            style="background:#b87c39">
                        <i data-lucide="search" class="w-4 h-4"></i>
                        Cari Rekomendasi
                    </button>
                    @if($sudahDicari)
                    <a href="{{ route('user.kafe.rekomendasi') }}"
                       class="inline-flex items-center gap-2 border border-gray-200 text-gray-400 hover:text-gray-600 hover:border-gray-300 text-sm font-medium px-5 py-3 rounded-xl transition-all">
                        <i data-lucide="x" class="w-4 h-4"></i>
                        Reset
                    </a>
                    @endif
                </div>
            </form>
        </div>
    </div>
</section>

{{-- ════════════ HASIL ════════════ --}}
<section class="max-w-7xl mx-auto px-5 md:px-8 py-12">

    @if(!$sudahDicari)
    {{-- Belum dicari --}}
    <div class="py-28 flex flex-col items-center text-center fu">
        <div class="relative mb-8">
            <div class="w-24 h-24 rounded-3xl flex items-center justify-center shadow-sm border border-gray-100" style="background:#fdf8f3">
                <i data-lucide="coffee" class="w-10 h-10" style="color:#b87c39"></i>
            </div>
            <div class="absolute -top-2 -right-2 w-8 h-8 rounded-full bg-white border border-gray-100 shadow-sm flex items-center justify-center">
                <i data-lucide="sparkles" class="w-4 h-4" style="color:#b87c39"></i>
            </div>
        </div>
        <h2 class="rec-serif font-bold text-gray-900 mb-3" style="font-size:clamp(1.6rem,3vw,2.2rem)">
            Atur preferensimu dulu!
        </h2>
        <p class="text-gray-400 text-sm max-w-sm leading-relaxed mb-8" style="font-weight:300">
            Pilih harga, jarak, rating, atau fasilitas di atas,
            lalu klik <strong class="font-semibold text-gray-600">Cari Rekomendasi</strong>.
        </p>
        <div class="flex flex-wrap justify-center gap-2">
            @foreach([['banknote','Harga'],['map-pin','Jarak'],['star','Rating'],['wifi','Fasilitas'],['utensils','Menu'],['clock','Jam Operasional']] as [$ico,$lbl])
            <div class="inline-flex items-center gap-1.5 bg-white border border-gray-100 rounded-full px-3.5 py-1.5 text-xs font-medium text-gray-400 shadow-sm">
                <i data-lucide="{{ $ico }}" class="w-3 h-3" style="color:#b87c39"></i>{{ $lbl }}
            </div>
            @endforeach
        </div>
    </div>

    @elseif($hasil->isEmpty())
    {{-- Tidak ada hasil --}}
    <div class="py-28 flex flex-col items-center text-center fu">
        <div class="w-20 h-20 rounded-2xl bg-gray-50 border border-gray-100 flex items-center justify-center mb-6">
            <i data-lucide="search-x" class="w-9 h-9 text-gray-300"></i>
        </div>
        <h2 class="rec-serif font-bold text-gray-900 mb-2" style="font-size:1.8rem">Tidak ada cafe yang cocok</h2>
        <p class="text-gray-400 text-sm max-w-sm leading-relaxed mb-6" style="font-weight:300">
            Coba perlonggar beberapa filter, misalnya perbesar radius jarak atau naikkan batas harga.
        </p>
        <a href="{{ route('user.kafe.rekomendasi') }}"
           class="inline-flex items-center gap-2 text-sm font-semibold px-5 py-2.5 rounded-xl border transition-all"
           style="color:#b87c39;border-color:rgba(184,124,57,.25)">
            <i data-lucide="refresh-cw" class="w-3.5 h-3.5"></i>Reset & Coba Lagi
        </a>
    </div>

    @else
    {{-- ═══ HASIL SAW ═══ --}}

    @php $total = $hasil->count(); @endphp

    <div class="flex items-end justify-between mb-10 fu">
        <div>
            <p class="text-[11px] font-semibold tracking-[.16em] uppercase mb-2" style="color:#b87c39">Berdasarkan SAW</p>
            <h2 class="rec-serif font-bold text-gray-900 leading-tight" style="font-size:clamp(1.8rem,3.5vw,2.6rem)">
                Hasil Rekomendasi
            </h2>
        </div>
        <div class="flex items-center gap-4">
            <span class="hidden md:inline text-sm text-gray-300 font-medium">
                {{ $total }} cafe ditemukan
            </span>
            <a href="{{ route('user.explore.index') }}"
               class="hidden md:inline-flex items-center gap-1.5 text-sm font-semibold transition-colors group"
               style="color:#b87c39">
                Lihat Semua Kafe
                <i data-lucide="arrow-right" class="w-4 h-4 group-hover:translate-x-1 transition-transform"></i>
            </a>
        </div>
    </div>

    @if(!isset($engineError))
    <div class="mb-8 fu d1 rounded-2xl p-4 flex items-start gap-3.5" style="background: rgba(184, 124, 57, 0.05); border: 1px solid rgba(184, 124, 57, 0.15);">
        <div class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0 text-[#b87c39]" style="background: rgba(184, 124, 57, 0.1);">
            <i data-lucide="cpu" class="w-4 h-4"></i>
        </div>
        <div>
            <h4 class="text-[11px] font-bold uppercase tracking-wider mb-0.5 text-[#b87c39]">Engine Rekomendasi Online</h4>
            <p class="text-xs text-gray-500 leading-relaxed font-light">
                Perangkingan kafe dihitung dan diurutkan secara dinamis menggunakan metode **Simple Additive Weighting (SAW)** melalui server API Python.
            </p>
        </div>
    </div>
    @else
    <div class="mb-8 fu d1 bg-red-50 border border-red-100 rounded-2xl p-4 flex items-start gap-3.5">
        <div class="w-8 h-8 rounded-lg bg-red-100 flex items-center justify-center flex-shrink-0 text-red-600">
            <i data-lucide="wifi-off" class="w-4 h-4"></i>
        </div>
        <div>
            <h4 class="text-[11px] font-bold text-red-800 uppercase tracking-wider mb-0.5">Engine Rekomendasi Offline</h4>
            <p class="text-xs text-red-600/85 leading-relaxed font-light">
                Gagal terhubung ke server API Python. Sistem mendegradasi fungsionalitas secara aman: menampilkan daftar kafe sesuai filter Anda tanpa urutan rekomendasi SAW.
            </p>
        </div>
    </div>
    @endif

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-7" id="kafe-grid">
        @foreach($hasil as $kafe)
        @php
            $idx      = $loop->index;
            $rank     = $kafe['ranking'];
            $pct      = round($kafe['skor'] * 100);
            $medalCls = match($rank){1=>'medal-1',2=>'medal-2',3=>'medal-3',default=>'medal-n'};

            $visibleCls = $idx < 6
                ? 'fu d' . min($idx + 1, 6)
                : 'card-hidden';
        @endphp

        <a href="{{ route('user.explore.detail', $kafe['id_kafe']) }}"
           class="kafe-card group relative bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-sm flex flex-col {{ $visibleCls }}"
           data-card-index="{{ $idx }}">

            <div class="relative h-52 overflow-hidden bg-gray-50 flex-shrink-0">
                @if($kafe['gambar'])
                    <img src="{{ $kafe['gambar'] }}" alt="{{ $kafe['nama_kafe'] }}"
                         class="kafe-img w-full h-full object-cover" loading="lazy">
                @else
                    <div class="w-full h-full flex items-center justify-center" style="background:#fdf8f3">
                        <i data-lucide="coffee" class="w-14 h-14" style="color:#e5d5c0"></i>
                    </div>
                @endif

                @if(!isset($engineError))
                <div class="absolute top-3.5 left-3.5 z-10">
                    <span class="inline-flex items-center justify-center w-9 h-9 rounded-full text-white text-xs font-extrabold shadow-lg ring-[3px] ring-white/50 {{ $medalCls }}">
                        #{{ $rank }}
                    </span>
                </div>

                <div class="absolute top-3.5 right-3.5 z-10">
                    <span class="inline-flex items-center gap-1 bg-white/90 backdrop-blur-sm text-[10px] font-bold px-2.5 py-1 rounded-full shadow-sm border border-white/60"
                          style="color:#b87c39">
                        <i data-lucide="cpu" class="w-2.5 h-2.5"></i>
                        {{ $kafe['skor'] }}
                    </span>
                </div>
                @endif

                <div class="absolute inset-x-0 bottom-0 h-16 pointer-events-none"
                     style="background:linear-gradient(to top,rgba(0,0,0,.28),transparent)"></div>
            </div>

            <div class="p-5 flex flex-col flex-1">
                <h3 class="font-bold text-gray-900 leading-snug mb-1 line-clamp-1 transition-colors group-hover:text-[#b87c39]"
                    style="font-size:.97rem">{{ $kafe['nama_kafe'] }}</h3>
                <p class="text-[11px] text-gray-400 mb-4 line-clamp-1 flex items-center gap-1.5" style="font-weight:300">
                    <i data-lucide="map-pin" class="w-3 h-3 flex-shrink-0" style="color:#b87c39"></i>
                    {{ $kafe['alamat'] ?? '-' }}
                </p>

                <div class="flex items-center gap-3 pb-4 mb-4 border-b border-gray-50 text-xs font-medium text-gray-500">
                    <span class="flex items-center gap-1">
                        <i data-lucide="star" class="w-3.5 h-3.5" style="color:#f59e0b;fill:#f59e0b"></i>
                        {{ $kafe['rating_raw'] }}
                    </span>
                    <span class="h-3 w-px bg-gray-200"></span>
                    <span class="flex items-center gap-1">
                        <i data-lucide="clock" class="w-3.5 h-3.5 text-gray-300"></i>
                        {{ $kafe['jam_buka'] }} – {{ $kafe['jam_tutup'] }}
                    </span>
                    <span class="h-3 w-px bg-gray-200"></span>
                    <span class="flex items-center gap-1">
                        <i data-lucide="map-pin" class="w-3.5 h-3.5 text-gray-300"></i>
                        {{ $kafe['jarak_km'] }} km
                    </span>
                </div>

                @if(!isset($engineError))
                <div class="mb-5">
                    <div class="flex justify-between items-center mb-1.5">
                        <span class="text-[10px] font-semibold text-gray-300 uppercase tracking-wider">Skor SAW</span>
                        <span class="text-[11px] font-bold" style="color:#b87c39">{{ $pct }}%</span>
                    </div>
                    <div class="w-full h-1 rounded-full bg-gray-100 overflow-hidden">
                        <div class="saw-bar h-full rounded-full" data-width="{{ $pct }}"
                             style="width:0%;background:linear-gradient(to right,#e8c98a,#b87c39)"></div>
                    </div>
                </div>
                @endif

                <div class="mt-auto flex items-end justify-between">
                    <div>
                        <p class="text-[10px] text-gray-400 mb-0.5" style="font-weight:300">Mulai dari</p>
                        <p class="font-bold text-gray-900" style="font-size:.97rem">
                            Rp {{ number_format($kafe['harga_min'],0,',','.') }}
                        </p>
                    </div>
                    <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-white px-4 py-2 rounded-xl transition-all group-hover:shadow-md group-hover:opacity-90"
                          style="background:#b87c39">
                        Detail
                        <i data-lucide="arrow-right" class="w-3.5 h-3.5 group-hover:translate-x-0.5 transition-transform"></i>
                    </span>
                </div>
            </div>
        </a>
        @endforeach
    </div>

    {{-- ── Load More ── --}}
    @if($total > 6)
    <div class="flex flex-col items-center gap-4 mt-14" id="load-more-wrap">

        {{-- label: Menampilkan X dari Y --}}
        <p class="text-xs font-medium text-gray-400" id="lm-label">
            Menampilkan <strong class="text-gray-600" id="lm-shown">6</strong>
            dari <strong class="text-gray-600">{{ $total }}</strong> cafe
        </p>

        {{-- Progress bar --}}
        <div class="w-48 h-1 rounded-full bg-gray-100 overflow-hidden">
            <div id="lm-progress" class="h-full rounded-full transition-all duration-500"
                 style="background:#b87c39;width:{{ min(round(6 / $total * 100), 100) }}%"></div>
        </div>

        {{-- Tombol --}}
        <button type="button" onclick="loadMore()" id="btn-load-more" class="btn-load-more mt-1">
            <i data-lucide="chevrons-down" class="w-4 h-4"></i>
            Cafe Lainnya
            <span class="lm-badge" id="lm-remaining">{{ $total - 6 }}</span>
        </button>

    </div>
    @endif

    {{-- Mobile: lihat semua --}}
    <div class="flex justify-center mt-10 md:hidden">
        <a href="{{ route('user.explore.index') }}"
           class="inline-flex items-center gap-2 text-sm font-semibold border px-6 py-3 rounded-full transition-all"
           style="color:#b87c39;border-color:#b87c39">
            Jelajahi Semua Kafe
            <i data-lucide="arrow-right" class="w-4 h-4"></i>
        </a>
    </div>

    @endif
</section>

</div>
@endsection

@push('scripts')
<script>
/* ════════════════════════════════════════
   FILTER TOGGLE
════════════════════════════════════════ */
const filterBody  = document.getElementById('filter-body');
const chevronIcon = document.getElementById('chevron-icon');
let filterOpen = true;
filterBody.style.transition = 'max-height .35s cubic-bezier(.4,0,.2,1)';
filterBody.style.overflow   = 'hidden';
filterBody.style.maxHeight  = filterBody.scrollHeight + 'px';
function toggleFilter() {
    filterOpen = !filterOpen;
    filterBody.style.maxHeight  = filterOpen ? filterBody.scrollHeight + 'px' : '0';
    chevronIcon.style.transform = filterOpen ? 'rotate(180deg)' : 'rotate(0deg)';
}

/* ════════════════════════════════════════
   STAR RATING BUTTONS
════════════════════════════════════════ */
document.querySelectorAll('.star-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        document.querySelectorAll('.star-btn').forEach(b => {
            b.style.background = '#fff'; b.style.borderColor = '#e5e7eb'; b.style.color = '#6b7280';
        });
        btn.style.background = '#b87c39'; btn.style.borderColor = '#b87c39'; btn.style.color = '#fff';
        document.getElementById('rating_min').value = btn.dataset.val;
    });
});

/* ════════════════════════════════════════
   FASILITAS PILLS
════════════════════════════════════════ */
const SKALA = [
    [2,'Tidak Lengkap (skor 1)'],
    [4,'Kurang Lengkap (skor 2)'],
    [6,'Cukup Lengkap (skor 3)'],
    [8,'Lengkap (skor 4)'],
    [Infinity,'Sangat Lengkap (skor 5)']
];
function updateFasLabel() {
    const el = document.getElementById('fas-count-label');
    if (!el) return;
    const n = document.querySelectorAll('.fas-check:checked').length;
    if (!n) { el.textContent = 'Pilih fasilitas untuk menyaring cafe'; return; }
    const txt = SKALA.find(([m]) => n <= m)?.[1] ?? 'Sangat Lengkap (skor 5)';
    el.innerHTML = `<strong style="color:#b87c39">${n} fasilitas</strong> dipilih — ${txt}`;
}
document.querySelectorAll('.fas-label').forEach(lbl => {
    lbl.addEventListener('click', () => {
        setTimeout(() => {
            const cb   = lbl.querySelector('.fas-check');
            const pill = lbl.querySelector('.fas-pill');
            const ico  = lbl.querySelector('.fas-check-icon');
            if (cb.checked) {
                pill.style.background = '#b87c39'; pill.style.borderColor = '#b87c39'; pill.style.color = '#fff';
                ico?.classList.remove('hidden');
            } else {
                pill.style.background = '#fff'; pill.style.borderColor = '#e5e7eb'; pill.style.color = '#374151';
                ico?.classList.add('hidden');
            }
            updateFasLabel();
        }, 0);
    });
});

/* ════════════════════════════════════════
   LOAD MORE — reveal 6 card per klik
════════════════════════════════════════ */
const PER_PAGE   = 6;
const allCards   = Array.from(document.querySelectorAll('[data-card-index]'));
const totalCards = allCards.length;
let   shownCount = Math.min(PER_PAGE, totalCards);   // 6 card pertama sudah visible

function loadMore() {
    /* ambil batch berikutnya */
    const batch = allCards.slice(shownCount, shownCount + PER_PAGE);

    batch.forEach((card, i) => {
        /* hapus hidden, tambah animasi reveal dengan stagger */
        card.classList.remove('card-hidden');
        card.classList.add('card-reveal');
        card.style.animationDelay = (i * 0.08) + 's';

        /* animasikan SAW bar di card yang baru muncul */
        card.querySelectorAll('.saw-bar').forEach(bar => {
            setTimeout(() => {
                bar.style.width = bar.dataset.width + '%';
            }, 300 + i * 80);
        });
    });

    /* re-init lucide icons di card baru */
    if (typeof lucide !== 'undefined') {
        lucide.createIcons({ nodes: batch });
    }

    shownCount += batch.length;

    /* update counter, badge, progress bar */
    const shownEl    = document.getElementById('lm-shown');
    const remainEl   = document.getElementById('lm-remaining');
    const progressEl = document.getElementById('lm-progress');
    const btnEl      = document.getElementById('btn-load-more');

    if (shownEl)    shownEl.textContent  = shownCount;
    if (remainEl)   remainEl.textContent = Math.max(0, totalCards - shownCount);
    if (progressEl) progressEl.style.width = Math.round(shownCount / totalCards * 100) + '%';

    /* scroll ke batch baru secara smooth */
    if (batch.length > 0) {
        setTimeout(() => {
            batch[0].scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }, 100);
    }

    /* sembunyikan tombol load more jika semua sudah tampil */
    if (shownCount >= totalCards) {
        const wrap = document.getElementById('load-more-wrap');
        if (wrap) {
            wrap.style.transition = 'opacity .4s ease';
            wrap.style.opacity    = '0';
            setTimeout(() => { wrap.style.display = 'none'; }, 420);
        }
    }
}

/* ════════════════════════════════════════
   SAW BAR — animate on scroll (6 card pertama)
════════════════════════════════════════ */
document.addEventListener('DOMContentLoaded', () => {
    const io = new IntersectionObserver(entries => {
        entries.forEach(e => {
            if (e.isIntersecting) {
                setTimeout(() => { e.target.style.width = e.target.dataset.width + '%'; }, 150);
                io.unobserve(e.target);
            }
        });
    }, { threshold: 0.1 });

    /* hanya observe card yang sudah visible */
    document.querySelectorAll('.saw-bar').forEach(bar => {
        const card = bar.closest('[data-card-index]');
        if (card && !card.classList.contains('card-hidden')) {
            io.observe(bar);
        }
    });

    if (typeof lucide !== 'undefined') lucide.createIcons();
});
</script>
@endpush