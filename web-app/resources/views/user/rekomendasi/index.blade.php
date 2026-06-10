{{-- resources/views/user/rekomendasi/index.blade.php --}}

@extends('layouts.user')

@section('title', 'Rekomendasi Cafe — Ngafein')
@section('navbar-dark-text', 'true')

@push('styles')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;0,800;1,700&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;1,9..40,400&display=swap');

    .rec-root   { font-family: 'Plus Jakarta Sans', sans-serif; background: #ffffff; }
    .rec-serif  { font-family: 'Plus Jakarta Sans', sans-serif; }
    [x-cloak] { display: none !important; }

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

    @media (max-width: 639px) {
        .desktop-only-table { display: none !important; }
        .mobile-only-cards { display: block !important; }
    }
    @media (min-width: 640px) {
        .desktop-only-table { display: block !important; }
        .mobile-only-cards { display: none !important; }
    }
</style>
@endpush

@section('content')
<div class="rec-root min-h-screen"
     x-data="{ 
        selectedCafes: [], 
        showModal: false, 
        errorMsg: '',
        showError: false,
        triggerError(msg) {
            this.errorMsg = msg;
            this.showError = true;
            setTimeout(() => { this.showError = false; }, 3000);
        },
        toggleCafe(cafe) {
            if (this.selectedCafes.some(c => c.id === cafe.id)) {
                this.selectedCafes = this.selectedCafes.filter(c => c.id !== cafe.id);
            } else {
                if (this.selectedCafes.length >= 3) {
                    this.triggerError('Maksimal membandingkan 3 kafe!');
                    return;
                }
                this.selectedCafes.push(cafe);
            }
        }
     }">

    <!-- Modern Notification Toast -->
    <div x-show="showError" 
         x-transition:enter="transition ease-out duration-300 transform"
         x-transition:enter-start="opacity-0 -translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200 transform"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-4"
         class="fixed top-24 left-1/2 -translate-x-1/2 z-50 bg-[#2B1A09] text-white border border-[#B87C39]/30 px-6 py-3.5 rounded-2xl shadow-2xl flex items-center gap-3 text-xs font-bold"
         x-cloak>
        <div class="w-5 h-5 rounded-lg bg-[#B87C39]/20 text-[#B87C39] flex items-center justify-center shrink-0">
            <i data-lucide="alert-circle" class="w-4 h-4"></i>
        </div>
        <span x-text="errorMsg"></span>
    </div>

{{-- ════════════ HERO ════════════ --}}
<section class="relative overflow-hidden bg-white" style="padding-top:clamp(6.5rem,13vw,10rem);padding-bottom:4rem;">
    <div class="absolute top-0 right-0 w-[600px] h-[600px] pointer-events-none"
         style="background:radial-gradient(circle at 80% 20%,rgba(184,124,57,.055),transparent 60%)"></div>
    <div class="absolute bottom-0 left-0 w-[400px] h-[400px] pointer-events-none"
         style="background:radial-gradient(circle at 10% 90%,rgba(184,124,57,.04),transparent 60%)"></div>

    <div class="max-w-7xl mx-auto px-5 md:px-8 relative z-10">

        <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-10">
            <div class="fu">
                <div class="inline-flex items-center gap-2 mb-5 px-3.5 py-1.5 rounded-full border text-[11px] font-semibold tracking-[.14em] uppercase"
                     style="color:#101828;border-color:rgba(184,124,57,.2);background:rgba(184,124,57,.05)">
                    <i data-lucide="cpu" class="w-3.5 h-3.5"></i>
                    Rekomendasi berbasis SAW
                </div>
                <h1
                    class="font-bold tracking-tight leading-none"
                    style="font-size:clamp(3rem,6vw,5rem); color:#0F172A;">
                    Pilihan Bikin<br>
                    <span style="color:#B87C39;">Betah.</span>
                </h1>

                <p class="mt-5 max-w-md"
                style="font-size:1rem;font-weight:500;color:#6A7282;">
                    Setiap rekomendasi dihitung dengan mempertimbangkan harga,
                    jarak, fasilitas, dan hal-hal yang paling kamu butuhkan.
                </p>
            </div>

            <div class="fu d2 hidden lg:block shrink-0">
                <p class="text-[14px] font-semibold tracking-[.2em] uppercase text-gray-500 mb-3 text-right"
                style="font-family:'Plus Jakarta Sans', sans-serif;">Bobot Kriteria
                </p>
                <div class="flex flex-wrap gap-2 justify-end max-w-xs">
                    @foreach([['Harga','20%','banknote'],['Jarak','20%','map-pin'],['Fasilitas','20%','wifi'],['Menu','15%','utensils'],['Jam','15%','clock'],['Rating','10%','star']] as [$lbl,$pct,$ico])
                    <div class="flex items-center gap-1.5 bg-white border border-gray-100 rounded-full px-3 py-1.5 text-[14px] font-medium text-gray-600 shadow-sm">
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
@include('user.rekomendasi.partials.filter-form')

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
            <strong class="font-semibold text-gray-600">            Pilih harga, jarak, rating, atau fasilitas di atas,
            lalu klik Cari Rekomendasi</strong>.
        </p>
        <div class="flex flex-wrap justify-center gap-2">
            @foreach([['banknote','Harga'],['map-pin','Jarak'],['star','Rating'],['wifi','Fasilitas'],['utensils','Menu'],['clock','Jam Operasional']] as [$ico,$lbl])
            <div class="inline-flex items-center gap-2 bg-white border border-gray-100 rounded-full px-4 py-2 text-sm font-medium text-gray-500 shadow-sm">
                <i data-lucide="{{ $ico }}" class="w-4 h-4" style="color:#b87c39"></i>
                {{ $lbl }}
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

            $minK = $kafe['harga_min'] >= 1000 ? ($kafe['harga_min'] / 1000) . 'k' : $kafe['harga_min'];
            $maxK = $kafe['harga_max'] >= 1000 ? ($kafe['harga_max'] / 1000) . 'k' : $kafe['harga_max'];
            $rangeK = "{$minK} - {$maxK}";
        @endphp

        @include('user.rekomendasi.partials.card-rekomendasi')
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

    <!-- Floating Comparison Tray -->
    <div x-show="selectedCafes.length > 0"
         x-transition:enter="transition ease-out duration-300 transform"
         x-transition:enter-start="translate-y-full opacity-0"
         x-transition:enter-end="translate-y-0 opacity-100"
         x-transition:leave="transition ease-in duration-200 transform"
         x-transition:leave-start="translate-y-0 opacity-100"
         x-transition:leave-end="translate-y-full opacity-0"
         class="fixed bottom-6 inset-x-4 max-w-xl mx-auto z-40 bg-[#2B1A09]/95 backdrop-blur-md rounded-3xl border border-[#B87C39]/30 shadow-2xl p-3 sm:p-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 sm:gap-4"
         x-cloak>
        <div class="flex items-center gap-2.5 sm:gap-3">
            <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-lg sm:rounded-xl bg-[#B87C39]/20 text-[#B87C39] flex items-center justify-center shrink-0">
                <i data-lucide="git-compare" class="w-4.5 h-4.5 sm:w-5 sm:h-5"></i>
            </div>
            <div>
                <p class="text-[11px] sm:text-xs font-bold text-white uppercase tracking-wider">Perbandingan Kafe</p>
                <p class="text-[10px] sm:text-[11px] text-white/60 font-light mt-0.5"><span x-text="selectedCafes.length" class="font-bold text-[#B87C39]"></span> dari maks 3 kafe terpilih</p>
            </div>
        </div>
        <div class="flex items-center justify-end gap-2.5 sm:gap-3 w-full sm:w-auto">
            <button @click="selectedCafes = []" class="text-[10px] sm:text-xs text-white/60 hover:text-white transition-colors py-1.5 px-3 rounded-lg border border-white/10 hover:bg-white/5 font-semibold">
                Batal
            </button>
            <button @click="if (selectedCafes.length < 2) { triggerError('Pilih minimal 2 kafe untuk dibandingkan!'); } else { showModal = true; }" 
                    class="bg-[#B87C39] hover:bg-[#a66c2e] text-white font-bold text-[10px] sm:text-xs px-4 py-2 sm:px-5 sm:py-2.5 rounded-lg sm:rounded-xl transition-all shadow-md shadow-[#B87C39]/20 flex items-center gap-1.5 animate-pulse">
                Bandingkan <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
            </button>
        </div>
    </div>

    <!-- Comparison Modal -->
    @include('user.rekomendasi.partials.comparison-modal')

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
function syncFilterBodyHeight() {
    if (!filterBody || !filterOpen) return;
    filterBody.style.maxHeight = filterBody.scrollHeight + 'px';
}
filterBody.style.transition = 'max-height .35s cubic-bezier(.4,0,.2,1)';
filterBody.style.overflow   = 'hidden';
syncFilterBodyHeight();
function toggleFilter() {
    filterOpen = !filterOpen;
    filterBody.style.maxHeight  = filterOpen ? filterBody.scrollHeight + 'px' : '0';
    chevronIcon.style.transform = filterOpen ? 'rotate(180deg)' : 'rotate(0deg)';
}
window.addEventListener('resize', syncFilterBodyHeight);
window.addEventListener('load', syncFilterBodyHeight);

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
            syncFilterBodyHeight();
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
    requestAnimationFrame(syncFilterBodyHeight);
});
</script>
@endpush
