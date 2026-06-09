{{-- resources/views/user/rekomendasi/partials/filter-form.blade.php --}}
<section class="max-w-7xl mx-auto px-5 md:px-8 pb-6 relative z-20">
    <div class="bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-[0_2px_24px_rgba(0,0,0,.06)]">

        <button type="button" onclick="toggleFilter()"
                class="w-full flex items-center justify-between px-6 py-4 border-b border-gray-50 hover:bg-gray-50/50 transition-colors text-left">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-xl flex items-center justify-center" style="background:rgba(184,124,57,.1)">
                    <i data-lucide="sliders-horizontal" class="w-4 h-4" style="color:#b87c39"></i>
                </div>
                <span class="font-semibold text-gray-800 text-lg">Filter Preferensi</span>
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
                            <option value="1"   @selected(request('jarak_max')=='1')  >Sangat Dekat · ≤ 1 km</option>
                            <option value="2"   @selected(request('jarak_max')=='2')  >Dekat · ≤ 2 km</option>
                            <option value="4"   @selected(request('jarak_max')=='4')  >Cukup Jauh · ≤ 4 km</option>
                            <option value="6"   @selected(request('jarak_max')=='6')  >Jauh · ≤ 6 km</option>
                            <option value="999" @selected(request('jarak_max')=='999')>Sangat Jauh · Semua Jarak</option>
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
