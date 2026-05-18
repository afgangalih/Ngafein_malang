@extends('layouts.admin')

@section('title', 'Dashboard — Ngafein Admin')

@section('content')
<div class="space-y-6 pb-12">

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">
        @include('admin.dashboard.components.stat-card', ['icon' => 'coffee', 'title' => 'Total Alternatif Kafe', 'value' => $stats['total_kafe']])
        @include('admin.dashboard.components.stat-card', ['icon' => 'layers', 'title' => 'Total Kriteria', 'value' => $stats['total_kriteria']])
        @include('admin.dashboard.components.stat-card', ['icon' => 'calculator', 'title' => 'Jumlah Perhitungan', 'value' => $stats['total_perhitungan']])
        @include('admin.dashboard.components.stat-card', ['icon' => 'award', 'title' => 'Rekomendasi', 'value' => $stats['total_rekomendasi'], 'highlight' => true])
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

        <div class="xl:col-span-2 bg-gradient-to-br from-[#FEF6E7] to-[#FFFBF5] rounded-[2rem] p-8 md:p-10 shadow-sm flex flex-col md:flex-row items-center justify-between relative overflow-hidden border border-[#F3E8D5]/60 group">
            <div class="absolute right-[-5%] top-[-10%] w-64 h-64 bg-[#B87A3D]/5 rounded-full blur-3xl pointer-events-none group-hover:scale-110 transition-transform duration-700"></div>
            <div class="w-full md:w-2/3 pr-0 md:pr-6 z-10 relative">
                <div class="text-[#B87A3D] text-[11px] font-bold uppercase tracking-[0.2em] mb-4 flex items-center gap-2">
                    <i data-lucide="trending-up" class="w-4 h-4"></i>
                    <span>Analisis Metode SAW</span>
                </div>
                <h2 class="text-3xl font-black text-gray-900 mb-4 tracking-tight leading-tight">
                    Rekomendasi Cafe <span class="text-[#B87A3D]">Terbaik</span>
                </h2>
                <p class="text-gray-600 leading-relaxed mb-8 font-medium text-[15px]">
                    Sistem akan melakukan perhitungan otomatis untuk menentukan cafe terbaik berdasarkan kriteria yang telah divalidasi.
                </p>
                <a href="{{ route('admin.saw.index') }}"
                   class="inline-flex items-center gap-2 bg-[#B87A3D] hover:bg-[#A36A32] text-white font-bold py-3.5 px-7 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-0.5 active:scale-95 group/btn">
                    <span>Lihat Hasil Rangking</span>
                    <i data-lucide="chevron-right" class="w-4 h-4 group-hover/btn:translate-x-1 transition-transform"></i>
                </a>
            </div>
            <div class="hidden md:flex w-1/3 justify-center items-center z-10 relative">
                <i data-lucide="coffee" class="w-40 h-40 text-[#B87A3D] opacity-20 transform group-hover:scale-110 transition-transform duration-700"></i>
            </div>
        </div>

        <div class="bg-[#FEF6E7] rounded-[2rem] p-8 shadow-sm border border-[#F3E8D5] flex flex-col relative overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-[#B87A3D]/5 rounded-bl-full pointer-events-none"></div>
            <div class="flex items-center justify-between mb-6 relative z-10">
                <h3 class="text-lg font-black text-gray-900 flex items-center gap-2">
                    <i data-lucide="award" class="text-[#B87A3D] w-5 h-5"></i>
                    Top 4 Cafe
                </h3>
                <span class="text-[10px] font-bold text-[#B87A3D] bg-[#B87A3D]/10 px-2.5 py-1 rounded-md uppercase tracking-wider">Realtime</span>
            </div>
            <div class="space-y-3 flex-1 relative z-10">
                @forelse($topCafes as $index => $cafe)
                    @include('admin.dashboard.components.ranking-item', [
                        'rank' => $index + 1,
                        'name' => $cafe->nama_kafe,
                        'score' => $cafe->skor
                    ])
                @empty
                    <div class="flex flex-col items-center justify-center py-10 text-center opacity-50">
                        <div class="w-12 h-12 rounded-full bg-white flex items-center justify-center mb-3">
                            <i data-lucide="clipboard-list" class="text-[#B87A3D] w-6 h-6"></i>
                        </div>
                        <p class="text-sm font-bold text-gray-500">Belum Ada Data</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

        <div class="xl:col-span-2 bg-white rounded-[2rem] p-8 shadow-sm border border-gray-100 flex flex-col relative">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                        <i data-lucide="bar-chart-2" class="text-[#B87A3D] w-5 h-5"></i>
                        Perbandingan Nilai Preferensi (V)
                    </h3>
                    <p class="text-[12px] text-gray-500 mt-1">Skor akhir hasil perhitungan matriks ternormalisasi</p>
                </div>
                @if($chartData->count() > 4)
                    <button
                        id="btn-detail-matriks"
                        onclick="toggleChartExpand(this)"
                        data-expanded="false"
                        class="text-[#B87A3D] bg-[#FEF6E7] px-4 py-2 rounded-xl text-[11px] font-bold hover:bg-[#F3E8D5] transition-colors flex items-center gap-1.5">
                        <i data-lucide="chevrons-down" class="w-3.5 h-3.5" id="icon-detail-matriks"></i>
                        <span id="label-detail-matriks">Detail Matriks</span>
                    </button>
                @endif
            </div>

            @php
                $barColors = [
                    'bg-[#B87A3D]', 'bg-[#C8945D]', 'bg-[#DAB894]', 'bg-[#E4CBAF]',
                    'bg-[#EDD8C0]', 'bg-[#F0DFC8]', 'bg-gray-300',  'bg-gray-200',
                    'bg-gray-200',  'bg-gray-200',
                ];
            @endphp

            <div class="flex flex-col gap-5" id="chart-container">
                @forelse($chartData as $index => $item)
                    @php
                        $color = $barColors[$index] ?? 'bg-gray-200';
                        $label = $item->ranking . '. ' . $item->nama_kafe;
                    @endphp
                    <div class="{{ $index >= 4 ? 'chart-extra hidden' : '' }}"
                         @if($index >= 4) style="opacity:0; transform: translateY(8px);" @endif>
                        @include('admin.dashboard.components.score-bar', [
                            'name' => $label,
                            'score' => $item->skor,
                            'color' => $color,
                            'highlight' => $index === 0
                        ])
                    </div>
                @empty
                    <div class="flex flex-col items-center justify-center py-10 text-center opacity-50">
                        <div class="w-12 h-12 rounded-full bg-gray-50 flex items-center justify-center mb-3">
                            <i data-lucide="bar-chart-2" class="text-gray-400 w-6 h-6"></i>
                        </div>
                        <p class="text-sm font-bold text-gray-500">Belum Ada Data Perhitungan</p>
                    </div>
                @endforelse
            </div>
        </div>

        <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-gray-100 flex flex-col">
            <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2">
                <i data-lucide="zap" class="text-[#B87A3D] w-5 h-5"></i>
                Aksi Cepat
            </h3>
            <div class="flex flex-col gap-3">

                <a href="{{ route('admin.saw.index') }}"
                   class="flex items-center gap-4 p-4 rounded-2xl bg-[#FEF6E7] border border-[#F3E8D5] hover:bg-[#B87A3D] group transition-all duration-300">
                    <div class="w-10 h-10 rounded-xl bg-white flex items-center justify-center text-[#B87A3D] group-hover:bg-white/20 group-hover:text-white transition-colors">
                        <i data-lucide="refresh-cw" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-900 group-hover:text-white text-sm">Hitung SAW</h4>
                        <p class="text-[10px] text-gray-500 group-hover:text-white/70">Update ranking</p>
                    </div>
                </a>

                <a href="{{ route('admin.cafe.index') }}?action=create"
                   class="flex items-center gap-4 p-4 rounded-2xl bg-[#FEF6E7] border border-[#F3E8D5] hover:bg-[#B87A3D] group transition-all duration-300">
                    <div class="w-10 h-10 rounded-xl bg-white flex items-center justify-center text-[#B87A3D] group-hover:bg-white/20 group-hover:text-white transition-colors">
                        <i data-lucide="plus" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-900 group-hover:text-white text-sm">Tambah Kafe</h4>
                        <p class="text-[10px] text-gray-500 group-hover:text-white/70">Data alternatif</p>
                    </div>
                </a>

                <a href="{{ route('admin.laporan.print') }}" target="_blank"
                   class="flex items-center gap-4 p-4 rounded-2xl bg-[#FEF6E7] border border-[#F3E8D5] hover:bg-[#B87A3D] group transition-all duration-300">
                    <div class="w-10 h-10 rounded-xl bg-white flex items-center justify-center text-[#B87A3D] group-hover:bg-white/20 group-hover:text-white transition-colors">
                        <i data-lucide="printer" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-900 group-hover:text-white text-sm">Ekspor Laporan</h4>
                        <p class="text-[10px] text-gray-500 group-hover:text-white/70">Hasil ranking PDF</p>
                    </div>
                </a>

            </div>
        </div>
    </div>

    <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-gray-100 flex flex-col relative overflow-hidden">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                    <i data-lucide="pie-chart" class="text-[#B87A3D] w-5 h-5"></i>
                    Distribusi Bobot Kriteria
                </h3>
                <p class="text-[12px] text-gray-500 mt-1">Persentase pengaruh kriteria terhadap hasil akhir perhitungan</p>
            </div>
            <a href="{{ route('admin.kriteria.index') }}"
               class="text-[#B87A3D] text-[12px] font-bold hover:underline flex items-center gap-1">
                <i data-lucide="settings-2" class="w-3.5 h-3.5"></i>
                Kelola Kriteria
            </a>
        </div>

        @if($kriterias->isEmpty() || $totalBobot == 0)
            <div class="flex flex-col items-center justify-center py-12 text-center bg-gray-50/50 rounded-[1.5rem] border border-dashed border-gray-200">
                <div class="w-14 h-14 bg-white rounded-full shadow-sm flex items-center justify-center mb-4">
                    <i data-lucide="settings-2" class="text-gray-300 w-7 h-7"></i>
                </div>
                <h4 class="text-gray-900 font-bold text-[15px]">Bobot Belum Diatur</h4>
                <p class="text-gray-400 text-[12px] max-w-xs mt-1">
                    Silahkan tentukan nilai bobot untuk setiap kriteria di menu Data Kriteria untuk melihat distribusi di sini.
                </p>
                <a href="{{ route('admin.kriteria.index') }}"
                   class="mt-5 inline-flex items-center gap-2 bg-[#B87A3D] text-white text-[12px] font-bold px-5 py-2.5 rounded-xl hover:bg-[#A36A32] transition-colors">
                    <i data-lucide="plus" class="w-3.5 h-3.5"></i>
                    Tambah Kriteria
                </a>
            </div>
        @else
            @php
                $paletteColors = [
                    '#B87A3D', '#C8945D', '#DAB894', '#E4CBAF',
                    '#A36A2E', '#8C5A25', '#D4A574', '#EDD8C0',
                    '#F0DFC8', '#6B4423',
                ];
                $isBobotValid = abs($totalBobot - 1) < 0.001;

                $kriteriaJs = $kriterias->map(function ($k, $i) use ($paletteColors, $totalBobot) {
                    return [
                        'nama'  => $k->nama_kriteria,
                        'bobot' => (float) $k->bobot,
                        'tipe'  => strtolower($k->tipe),
                        'pct'   => $totalBobot > 0 ? round(($k->bobot / $totalBobot) * 100, 1) : 0,
                        'color' => $paletteColors[$i % count($paletteColors)],
                    ];
                })->values();
            @endphp

            <div class="grid grid-cols-1 md:grid-cols-2 gap-10 items-center">

                <div class="flex flex-col items-center justify-center">
                    <div class="relative" style="width:224px; height:224px;">
                        <canvas id="donutKriteria" width="224" height="224"></canvas>
                        <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none">
                            <span id="donut-center-value"
                                  class="font-black text-gray-900 transition-all duration-200"
                                  style="font-size:1.875rem; line-height:1.1;">
                                {{ $kriterias->count() }}
                            </span>
                            <span id="donut-center-sub"
                                  class="text-[11px] text-gray-400 font-semibold mt-1 transition-all duration-200 text-center px-2">
                                Kriteria
                            </span>
                        </div>
                    </div>

                    <div class="mt-5 flex items-center gap-2 rounded-2xl px-5 py-2.5 border
                        {{ $isBobotValid ? 'bg-green-50 border-green-200' : 'bg-red-50 border-red-200' }}">
                        <span class="text-[11px] font-semibold {{ $isBobotValid ? 'text-green-600' : 'text-red-500' }}">
                            Total Bobot:
                        </span>
                        <span class="text-[14px] font-black {{ $isBobotValid ? 'text-green-700' : 'text-red-600' }}">
                            {{ number_format($totalBobot, 2) }}
                        </span>
                        @if($isBobotValid)
                            <i data-lucide="check-circle" class="w-4 h-4 text-green-500"></i>
                        @else
                            <i data-lucide="alert-circle" class="w-4 h-4 text-red-400"></i>
                        @endif
                    </div>

                    @if(!$isBobotValid)
                        <p class="text-[11px] text-red-400 mt-2 text-center max-w-[180px]">
                            Total bobot harus = 1.00 agar hasil SAW akurat.
                        </p>
                    @endif
                </div>

                <div class="flex flex-col gap-3">
                    @foreach($kriterias as $i => $kriteria)
                        @php
                            $pct       = $totalBobot > 0 ? round(($kriteria->bobot / $totalBobot) * 100, 1) : 0;
                            $color     = $paletteColors[$i % count($paletteColors)];
                            $isBenefit = strtolower($kriteria->tipe) === 'benefit';
                        @endphp
                        <div class="kriteria-item flex flex-col gap-1.5 cursor-pointer rounded-xl px-3 py-2
                                    transition-all duration-200 hover:bg-amber-50/60 border border-transparent"
                             data-index="{{ $i }}"
                             onmouseenter="donutHover({{ $i }})"
                             onmouseleave="donutReset()">
                            <div class="flex items-center justify-between gap-2">
                                <div class="flex items-center gap-2 min-w-0">
                                    <span class="w-2.5 h-2.5 rounded-full flex-shrink-0 transition-transform duration-200"
                                          style="background-color:{{ $color }}"
                                          id="ldot-{{ $i }}"></span>
                                    <span class="text-[13px] font-semibold text-gray-700 truncate">
                                        {{ $kriteria->nama_kriteria }}
                                    </span>
                                    <span class="flex-shrink-0 text-[9px] font-bold px-1.5 py-0.5 rounded-md
                                        {{ $isBenefit ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-600' }}">
                                        {{ $isBenefit ? 'Benefit' : 'Cost' }}
                                    </span>
                                </div>
                                <div class="flex items-center gap-3 flex-shrink-0">
                                    <span class="text-[11px] text-gray-400 font-medium">
                                        {{ number_format($kriteria->bobot, 2) }}
                                    </span>
                                    <span class="text-[12px] font-black text-gray-900 w-12 text-right"
                                          id="lpct-{{ $i }}">
                                        {{ $pct }}%
                                    </span>
                                </div>
                            </div>
                            <div class="h-2 bg-gray-100 rounded-full overflow-hidden">
                                <div class="h-full rounded-full transition-all duration-700"
                                     id="lbar-{{ $i }}"
                                     style="width:0%; background-color:{{ $color }}">
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <script>
                window._kriteriaData = @json($kriteriaJs);
            </script>
        @endif
    </div>

    <div class="bg-[#FEF6E7] rounded-[2rem] p-8 shadow-sm border border-[#F3E8D5] relative overflow-hidden group">
        <div class="absolute top-0 right-0 w-32 h-32 bg-white/40 rounded-bl-full pointer-events-none"></div>
        <div class="relative z-10 flex flex-col md:flex-row items-center gap-6">
            <div class="w-14 h-14 bg-white rounded-2xl shadow-sm flex-shrink-0 flex items-center justify-center group-hover:-translate-y-1 transition-transform duration-300">
                <i data-lucide="info" class="text-[#B87A3D] w-7 h-7"></i>
            </div>
            <div class="flex-1 text-center md:text-left">
                <h3 class="text-[17px] font-black text-gray-900 mb-1">Informasi Sistem</h3>
                <p class="text-gray-500 font-medium text-[13px] leading-relaxed">
                    Sistem ini menggunakan metode
                    <strong class="text-[#B87A3D]">Simple Additive Weighting (SAW)</strong>
                    untuk menjamin objektivitas pemilihan kafe. Proses melibatkan normalisasi matriks keputusan
                    dan perhitungan nilai preferensi setiap alternatif berdasarkan kriteria yang telah ditentukan.
                </p>
            </div>
        </div>
    </div>

</div>

@push('scripts')
<script src="https://unpkg.com/lucide@latest"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
lucide.createIcons();

/* ============================================================
   DONUT CHART — Distribusi Bobot Kriteria
============================================================ */
(function () {
    if (typeof window._kriteriaData === 'undefined') return;

    const data   = window._kriteriaData;
    const canvas = document.getElementById('donutKriteria');
    if (!canvas) return;

    const total  = data.length;
    const labels = data.map(d => d.nama);
    const values = data.map(d => d.pct);
    const colors = data.map(d => d.color);

    const donut = new Chart(canvas, {
        type: 'doughnut',
        data: {
            labels,
            datasets: [{
                data: values,
                backgroundColor: colors,
                hoverBackgroundColor: colors,
                borderWidth: 3,
                borderColor: '#ffffff',
                hoverBorderColor: '#ffffff',
                hoverOffset: 14,
            }]
        },
        options: {
            cutout: '70%',
            animation: {
                animateRotate: true,
                duration: 1000,
                easing: 'easeInOutQuart',
                onComplete() {
                    data.forEach((d, i) => {
                        const bar = document.getElementById('lbar-' + i);
                        if (bar) setTimeout(() => { bar.style.width = d.pct + '%'; }, i * 90);
                    });
                }
            },
            plugins: {
                legend: { display: false },
                tooltip: { enabled: false }
            },
            onHover(event, elements) {
                canvas.style.cursor = elements.length ? 'pointer' : 'default';
            }
        },
        plugins: [{
            id: 'centerText',
            afterDraw(chart) {
                const active = chart.getActiveElements();
                const valEl  = document.getElementById('donut-center-value');
                const subEl  = document.getElementById('donut-center-sub');
                if (!valEl || !subEl) return;

                if (active.length) {
                    const d = data[active[0].index];
                    valEl.textContent      = d.pct.toFixed(1) + '%';
                    valEl.style.fontSize   = '1.5rem';
                    valEl.style.color      = d.color;
                    subEl.textContent      = d.nama.length > 16 ? d.nama.slice(0, 15) + '…' : d.nama;
                    subEl.style.color      = '#6b7280';
                } else {
                    valEl.textContent      = total;
                    valEl.style.fontSize   = '1.875rem';
                    valEl.style.color      = '#111827';
                    subEl.textContent      = 'Kriteria';
                    subEl.style.color      = '#9ca3af';
                }
            }
        }]
    });

    window.donutHover = function (index) {
        donut.setActiveElements([{ datasetIndex: 0, index }]);
        donut.update('none');

        const dot = document.getElementById('ldot-' + index);
        if (dot) dot.style.transform = 'scale(1.7)';

        document.querySelectorAll('.kriteria-item').forEach((row, i) => {
            row.style.opacity = i === index ? '1' : '0.45';
        });
    };

    window.donutReset = function () {
        donut.setActiveElements([]);
        donut.update('none');

        data.forEach((_, i) => {
            const dot = document.getElementById('ldot-' + i);
            if (dot) dot.style.transform = 'scale(1)';
        });
        document.querySelectorAll('.kriteria-item').forEach(row => {
            row.style.opacity = '1';
        });
    };

    canvas.addEventListener('click', function (evt) {
        const points = donut.getElementsAtEventForMode(
            evt, 'nearest', { intersect: true }, false
        );
        if (!points.length) return;

        const idx  = points[0].index;
        const rows = document.querySelectorAll('.kriteria-item');

        rows.forEach((row, i) => {
            if (i === idx) {
                row.classList.add('border-[#B87A3D]/30', 'bg-amber-50');
                row.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            } else {
                row.classList.remove('border-[#B87A3D]/30', 'bg-amber-50');
            }
        });

        setTimeout(() => {
            rows.forEach(row => row.classList.remove('border-[#B87A3D]/30', 'bg-amber-50'));
        }, 2000);
    });

})();

/* ============================================================
   TOGGLE CHART EXPAND / COLLAPSE (nilai preferensi)
============================================================ */
function toggleChartExpand(btn) {
    const isExpanded = btn.dataset.expanded === 'true';
    const extras     = document.querySelectorAll('.chart-extra');
    const hint       = document.getElementById('chart-more-hint');
    const label      = document.getElementById('label-detail-matriks');
    const icon       = document.getElementById('icon-detail-matriks');

    if (isExpanded) {
        extras.forEach(el => {
            el.style.transition = 'opacity 0.2s ease, transform 0.2s ease';
            el.style.opacity    = '0';
            el.style.transform  = 'translateY(8px)';
            setTimeout(() => el.classList.add('hidden'), 200);
        });
        if (hint) hint.classList.remove('hidden');
        label.textContent = 'Detail Matriks';
        icon.setAttribute('data-lucide', 'chevrons-down');
    } else {
        extras.forEach((el, i) => {
            el.classList.remove('hidden');
            el.style.opacity   = '0';
            el.style.transform = 'translateY(8px)';
            setTimeout(() => {
                el.style.transition = 'opacity 0.35s ease, transform 0.35s ease';
                el.style.opacity    = '1';
                el.style.transform  = 'translateY(0)';
            }, i * 60);
        });
        if (hint) hint.classList.add('hidden');
        label.textContent = 'Sembunyikan';
        icon.setAttribute('data-lucide', 'chevrons-up');
    }

    btn.dataset.expanded = !isExpanded;
    setTimeout(() => lucide.createIcons(), 50);
}
</script>
@endpush

@endsection