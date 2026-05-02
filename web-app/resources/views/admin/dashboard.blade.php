@extends('layouts.admin')

@section('title', 'Dashboard — Ngafein Admin')

@section('content')
<div class="space-y-6 pb-12">
    
    {{-- stats cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">
        <x-admin.dashboard.stat-card icon="coffee" title="Total Alternatif Kafe" :value="$stats['total_kafe']" />
        <x-admin.dashboard.stat-card icon="layers" title="Total Kriteria" :value="$stats['total_kriteria']" />
        <x-admin.dashboard.stat-card icon="calculator" title="Jumlah Perhitungan" :value="$stats['total_perhitungan']" />
        <x-admin.dashboard.stat-card icon="award" title="Rekomendasi" :value="$stats['total_rekomendasi']" highlight />
    </div>

    {{-- recommendation and ranking --}}
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
                <a href="/admin/perhitungan" class="inline-flex items-center gap-2 bg-[#B87A3D] hover:bg-[#A36A32] text-white font-bold py-3.5 px-7 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-0.5 active:scale-95 group/btn">
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
                    <x-admin.dashboard.ranking-item :rank="$index + 1" :name="$cafe->nama_kafe" :score="$cafe->skor" />
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

    {{-- comparison chart and quick actions --}}
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
                <button class="text-[#B87A3D] bg-[#FEF6E7] px-4 py-2 rounded-xl text-[11px] font-bold hover:bg-[#F3E8D5] transition-colors">
                    Detail Matriks
                </button>
            </div>
            <div class="flex flex-col gap-5">
                <x-admin.dashboard.score-bar name="1. AADK Tlogomas" :score="0.925" color="bg-[#B87A3D]" highlight />
                <x-admin.dashboard.score-bar name="2. Kopi Kenangan Ijen" :score="0.880" color="bg-[#C8945D]" />
                <x-admin.dashboard.score-bar name="3. Machina Cafe" :score="0.845" color="bg-[#DAB894]" />
                <x-admin.dashboard.score-bar name="4. CW Coffee" :score="0.810" color="bg-[#E4CBAF]" />
                <x-admin.dashboard.score-bar name="5. Semusim Cafe" :score="0.765" color="bg-gray-200" />
            </div>
        </div>

        <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-gray-100 flex flex-col">
            <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2">
                <i data-lucide="zap" class="text-[#B87A3D] w-5 h-5"></i>
                Aksi Cepat
            </h3>
            <div class="flex flex-col gap-3">
                <a href="#" class="flex items-center gap-4 p-4 rounded-2xl bg-[#FEF6E7] border border-[#F3E8D5] hover:bg-[#B87A3D] group transition-all duration-300">
                    <div class="w-10 h-10 rounded-xl bg-white flex items-center justify-center text-[#B87A3D] group-hover:bg-white/20 group-hover:text-white transition-colors">
                        <i data-lucide="refresh-cw" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-900 group-hover:text-white text-sm">Hitung SAW</h4>
                        <p class="text-[10px] text-gray-500 group-hover:text-white/70">Update ranking</p>
                    </div>
                </a>
                <a href="#" class="flex items-center gap-4 p-4 rounded-2xl bg-white border border-gray-100 hover:border-[#B87A3D]/40 hover:bg-[#FEF6E7]/40 transition-all duration-300 group">
                    <div class="w-10 h-10 rounded-xl bg-[#FEF6E7] flex items-center justify-center text-[#B87A3D]">
                        <i data-lucide="plus" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-900 text-sm">Tambah Kafe</h4>
                        <p class="text-[10px] text-gray-500">Data alternatif</p>
                    </div>
                </a>
                <a href="#" class="flex items-center gap-4 p-4 rounded-2xl bg-white border border-gray-100 hover:border-[#B87A3D]/40 hover:bg-[#FEF6E7]/40 transition-all duration-300 group">
                    <div class="w-10 h-10 rounded-xl bg-[#FEF6E7] flex items-center justify-center text-[#B87A3D]">
                        <i data-lucide="printer" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-900 text-sm">Ekspor Laporan</h4>
                        <p class="text-[10px] text-gray-500">Hasil ranking PDF</p>
                    </div>
                </a>
            </div>
        </div>
    </div>

    {{-- criteria weights distribution --}}
    <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-gray-100 flex flex-col relative overflow-hidden">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                    <i data-lucide="pie-chart" class="text-[#B87A3D] w-5 h-5"></i>
                    Distribusi Bobot Kriteria
                </h3>
                <p class="text-[12px] text-gray-500 mt-1">Persentase pengaruh kriteria terhadap hasil akhir perhitungan</p>
            </div>
            <a href="/admin/kriteria" class="text-[#B87A3D] text-[12px] font-bold hover:underline">Kelola Kriteria</a>
        </div>

        {{-- empty state for criteria weights --}}
        <div class="flex flex-col items-center justify-center py-12 text-center bg-gray-50/50 rounded-[1.5rem] border border-dashed border-gray-200">
            <div class="w-14 h-14 bg-white rounded-full shadow-sm flex items-center justify-center mb-4">
                <i data-lucide="settings-2" class="text-gray-300 w-7 h-7"></i>
            </div>
            <h4 class="text-gray-900 font-bold text-[15px]">Bobot Belum Diatur</h4>
            <p class="text-gray-400 text-[12px] max-w-xs mt-1">
                Silahkan tentukan nilai bobot untuk setiap kriteria di menu Data Kriteria untuk melihat distribusi di sini.
            </p>
        </div>
    </div>

    {{-- information system --}}
    <div class="bg-[#FEF6E7] rounded-[2rem] p-8 shadow-sm border border-[#F3E8D5] relative overflow-hidden group">
        <div class="absolute top-0 right-0 w-32 h-32 bg-white/40 rounded-bl-full pointer-events-none"></div>
        <div class="relative z-10 flex flex-col md:flex-row items-center gap-6">
            <div class="w-14 h-14 bg-white rounded-2xl shadow-sm flex-shrink-0 flex items-center justify-center group-hover:-translate-y-1 transition-transform duration-300">
                <i data-lucide="info" class="text-[#B87A3D] w-7 h-7"></i>
            </div>
            <div class="flex-1 text-center md:text-left">
                <h3 class="text-[17px] font-black text-gray-900 mb-1">Informasi Sistem</h3>
                <p class="text-gray-500 font-medium text-[13px] leading-relaxed">
                    Sistem ini menggunakan metode <strong class="text-[#B87A3D]">Simple Additive Weighting (SAW)</strong> untuk menjamin objektivitas pemilihan kafe. Proses melibatkan normalisasi matriks keputusan dan perhitungan nilai preferensi setiap alternatif berdasarkan kriteria yang telah ditentukan.
                </p>
            </div>
        </div>
    </div>

</div>

@push('scripts')
<script src="https://unpkg.com/lucide@latest"></script>
<script>
    lucide.createIcons();
</script>
@endpush

@endsection
