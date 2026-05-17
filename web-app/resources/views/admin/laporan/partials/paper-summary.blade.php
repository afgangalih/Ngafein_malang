<div class="screen-only" style="margin-bottom:1.75rem;">
    <p style="font-size:0.65rem; font-weight:800; text-transform:uppercase; letter-spacing:0.2em; color:#B87C39; margin-bottom:0.9rem;">Ringkasan Eksekutif</p>

    <div style="display:grid; grid-template-columns:repeat(3,1fr); gap:1rem; margin-bottom:1.25rem;">
        <div style="border:1.5px solid #F3D9B5; border-radius:0.75rem; padding:1.1rem 1.25rem; background:#FFFAF4;">
            <p style="font-size:0.65rem; font-weight:800; text-transform:uppercase; letter-spacing:0.15em; color:#B87C39; margin:0 0 0.4rem;">Total Alternatif</p>
            <p style="font-size:2rem; font-weight:900; color:#111; margin:0; line-height:1;">{{ $totalKafe }} <span style="font-size:0.8rem; font-weight:700; color:#B87C39;">kafe</span></p>
        </div>
        <div style="border:1.5px solid #F3D9B5; border-radius:0.75rem; padding:1.1rem 1.25rem; background:#FFFAF4;">
            <p style="font-size:0.65rem; font-weight:800; text-transform:uppercase; letter-spacing:0.15em; color:#B87C39; margin:0 0 0.4rem;">Rata-rata Skor SAW</p>
            <p style="font-size:2rem; font-weight:900; color:#111; margin:0; line-height:1;">{{ number_format($rataRataSkor, 3) }}</p>
        </div>
        <div style="border:1.5px solid #6E4A22; border-radius:0.75rem; padding:1.1rem 1.25rem; background:#6E4A22;">
            <p style="font-size:0.65rem; font-weight:800; text-transform:uppercase; letter-spacing:0.15em; color:rgba(255,255,255,0.65); margin:0 0 0.4rem;">Peringkat #1 Terbaik</p>
            <p style="font-size:1rem; font-weight:900; color:white; margin:0; line-height:1.3; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">{{ $topCafe ? $topCafe['nama_kafe'] : '—' }}</p>
            <p style="font-size:0.7rem; font-weight:700; color:rgba(255,255,255,0.75); margin:0.3rem 0 0;">Skor: {{ $topCafe ? number_format($topCafe['skor'], 3) : '0.000' }}</p>
        </div>
    </div>

    <div style="border:1.5px solid #F3D9B5; border-radius:0.75rem; padding:1rem 1.25rem; background:#FFFAF4;">
        <p style="font-size:0.65rem; font-weight:800; text-transform:uppercase; letter-spacing:0.15em; color:#B87C39; margin:0 0 0.75rem;">Distribusi Bobot Kriteria Acuan:</p>
        <div style="display:flex; flex-wrap:wrap; gap:0.5rem;">
            @foreach([
                ['label'=>'Harga',    'key'=>'harga'],
                ['label'=>'Jarak',    'key'=>'jarak'],
                ['label'=>'Fasilitas','key'=>'fasilitas'],
                ['label'=>'Menu',     'key'=>'menu'],
                ['label'=>'Jam Buka', 'key'=>'jam_operasional'],
                ['label'=>'Rating',   'key'=>'rating'],
            ] as $k)
            <div style="display:flex; align-items:center; gap:0.5rem; border:1.5px solid #F3D9B5; border-radius:0.5rem; padding:0.35rem 0.85rem; background:white;">
                <span style="font-size:0.65rem; font-weight:700; text-transform:uppercase; letter-spacing:0.1em; color:#6E4A22;">{{ $k['label'] }}</span>
                <span style="font-size:0.85rem; font-weight:900; color:#B87C39;">{{ intval($bobot[$k['key']] * 100) }}%</span>
            </div>
            @endforeach
        </div>
    </div>
</div>

<div class="print-only" style="margin-bottom:16px;">
    <p style="font-weight:bold; font-size:12pt; border-bottom:1px solid #999; padding-bottom:3px; margin:0 0 8px;">Ringkasan Eksekutif</p>
    <table style="width:100%; border-collapse:collapse; font-size:11pt; margin-bottom:10px;">
        <tr>
            <td style="width:30%; padding:4px 6px; font-weight:bold;">Total Kafe Dievaluasi</td>
            <td style="padding:4px 6px;">: {{ $totalKafe }} kafe</td>
            <td style="width:30%; padding:4px 6px; font-weight:bold;">Rata-rata Skor SAW</td>
            <td style="padding:4px 6px;">: {{ number_format($rataRataSkor, 3) }}</td>
        </tr>
        <tr>
            <td style="padding:4px 6px; font-weight:bold;">Kafe Peringkat #1</td>
            <td colspan="3" style="padding:4px 6px;">: {{ $topCafe ? $topCafe['nama_kafe'] : '—' }} (V = {{ $topCafe ? number_format($topCafe['skor'], 3) : '0.000' }})</td>
        </tr>
    </table>

    <p style="font-weight:bold; font-size:11pt; margin:10px 0 5px;">Bobot Kriteria yang Digunakan:</p>
    <table style="width:100%; border-collapse:collapse; font-size:11pt; border:1px solid #999;">
        <thead>
            <tr style="background:#eee;">
                @foreach(['Harga','Jarak','Fasilitas','Menu','Jam Buka','Rating'] as $label)
                <th style="border:1px solid #999; padding:5px 8px; text-align:center;">{{ $label }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            <tr>
                @foreach(['harga','jarak','fasilitas','menu','jam_operasional','rating'] as $key)
                <td style="border:1px solid #999; padding:5px 8px; text-align:center;">{{ intval($bobot[$key]*100) }}%</td>
                @endforeach
            </tr>
        </tbody>
    </table>
</div>
