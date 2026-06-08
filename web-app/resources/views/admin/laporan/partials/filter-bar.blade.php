<div class="no-print bg-white flex flex-col lg:flex-row items-center justify-between gap-4 mb-0"
     style="border:1.5px solid #F3D9B5; border-radius:1rem; padding:1.1rem 1.5rem;">

    <form action="{{ route('admin.laporan.index') }}" method="GET" class="flex items-center gap-3 flex-wrap">
        <label for="limit" class="text-sm font-bold flex-shrink-0" style="color:#6E4A22;">Tampilkan:</label>
        <select name="limit" id="limit" onchange="this.form.submit()"
            class="text-sm font-semibold bg-white focus:outline-none cursor-pointer transition-colors"
            style="border:1.5px solid #F3D9B5; border-radius:0.5rem; padding:0.5rem 1rem; color:#6E4A22; focus:border-color:#B87C39;">
            <option value="all" {{ $limit === 'all' ? 'selected' : '' }}>Semua Peringkat</option>
            <option value="3"   {{ $limit === '3'   ? 'selected' : '' }}>Top 3 Terbaik</option>
            <option value="5"   {{ $limit === '5'   ? 'selected' : '' }}>Top 5 Terbaik</option>
            <option value="10"  {{ $limit === '10'  ? 'selected' : '' }}>Top 10 Terbaik</option>
        </select>
        @if($limit !== 'all')
            <span class="text-xs font-bold px-3 py-1.5 rounded-lg"
                  style="background:#FBF0E3; border:1.5px solid #F3D9B5; color:#B87C39;">
                Menampilkan Top {{ $limit }}
            </span>
        @endif
    </form>

    <div class="flex items-center gap-3 flex-wrap">
        <button type="button" @click="showPdfPreview = true"
            class="inline-flex items-center gap-2 text-white text-sm font-bold px-5 py-2.5 rounded-lg transition-all duration-200 hover:opacity-90 active:scale-95 cursor-pointer"
            style="background:#B87C39;">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 01-2-2v-5a2 2 0 012-2h16a2 2 0 012 2v5a2 2 0 01-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
            Cetak / PDF
        </button>
        <button type="button" @click="showExcelPreview = true"
            class="inline-flex items-center gap-2 text-white text-sm font-bold px-5 py-2.5 rounded-lg transition-all duration-200 hover:opacity-90 active:scale-95 cursor-pointer"
            style="background:#B87C39;">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
            Ekspor Excel
        </button>
    </div>
</div>
