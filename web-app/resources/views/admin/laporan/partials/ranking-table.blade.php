<p class="screen-only" style="font-size:0.65rem; font-weight:800; text-transform:uppercase; letter-spacing:0.2em; color:#B87C39; margin:0 0 0.9rem;">Tabel Pemeringkatan Akhir</p>
<p class="print-only" style="font-weight:bold; font-size:12pt; border-bottom:1px solid #999; padding-bottom:3px; margin:0 0 10px;">Hasil Pemeringkatan Akhir</p>

<div class="screen-only" style="overflow-x:auto; border:1px solid #e5e7eb; border-radius:0.875rem; margin-bottom:2rem;">
    <table style="width:100%; border-collapse:collapse; min-width:640px;">
        <thead>
            <tr style="background:#6E4A22; color:white;">
                <th style="padding:0.85rem 1rem; text-align:center; font-size:0.7rem; font-weight:800; text-transform:uppercase; letter-spacing:0.12em; width:4rem;">#</th>
                <th style="padding:0.85rem 1rem; text-align:left; font-size:0.7rem; font-weight:800; text-transform:uppercase; letter-spacing:0.12em;">Nama Kafe</th>
                <th style="padding:0.85rem 1rem; text-align:left; font-size:0.7rem; font-weight:800; text-transform:uppercase; letter-spacing:0.12em;">Alamat</th>
                <th style="padding:0.85rem 1rem; text-align:center; font-size:0.7rem; font-weight:800; text-transform:uppercase; letter-spacing:0.12em; width:6rem;">Rating</th>
                <th style="padding:0.85rem 1rem; text-align:center; font-size:0.7rem; font-weight:800; text-transform:uppercase; letter-spacing:0.12em; width:7rem;">Skor (V)</th>
                <th style="padding:0.85rem 1rem; text-align:center; font-size:0.7rem; font-weight:800; text-transform:uppercase; letter-spacing:0.12em; width:11rem;">Predikat</th>
            </tr>
        </thead>
        <tbody>
            @forelse($hasil as $index => $item)
                @php
                    $skor = $item['skor'];
                    if ($skor >= 0.85)     { $predikat = 'Sangat Direkomendasikan'; $pColor = '#6E4A22'; $pBg = '#F9EDD9'; $pBorder = '#B87C39'; }
                    elseif ($skor >= 0.70) { $predikat = 'Direkomendasikan';         $pColor = '#B87C39'; $pBg = '#FDF5E9'; $pBorder = '#D4A265'; }
                    else                   { $predikat = 'Cukup';                     $pColor = '#6E4A22'; $pBg = '#FAF0E2'; $pBorder = '#DEC49A'; }
                    $rowBg = $index % 2 === 0 ? '#fff' : '#FFFAF4';
                @endphp
                <tr style="background:{{ $rowBg }}; border-top:1px solid #f3f4f6;">
                    <td style="padding:0.85rem 1rem; text-align:center; font-weight:900;">
                        @if($index === 0)
                            <span style="display:inline-flex; align-items:center; justify-content:center; width:2rem; height:2rem; border-radius:50%; background:#B87C39; color:white; font-size:0.75rem; font-weight:900;">1</span>
                        @elseif($index === 1)
                            <span style="display:inline-flex; align-items:center; justify-content:center; width:2rem; height:2rem; border-radius:50%; border:2px solid #B87C39; background:white; color:#B87C39; font-size:0.75rem; font-weight:900;">2</span>
                        @elseif($index === 2)
                            <span style="display:inline-flex; align-items:center; justify-content:center; width:2rem; height:2rem; border-radius:50%; background:#6E4A22; color:white; font-size:0.75rem; font-weight:900;">3</span>
                        @else
                            <span style="color:#B87C39; font-size:0.875rem; font-weight:700;">{{ $index + 1 }}</span>
                        @endif
                    </td>
                    <td style="padding:0.85rem 1rem; font-weight:700; color:#111; font-size:0.875rem;">{{ $item['nama_kafe'] }}</td>
                    <td style="padding:0.85rem 1rem; color:#6b7280; font-size:0.75rem; max-width:200px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">{{ $item['alamat'] ?: '—' }}</td>
                    <td style="padding:0.85rem 1rem; text-align:center;">
                        <span style="display:inline-block; background:#FDF5E9; border:1px solid #D4A265; color:#6E4A22; font-size:0.75rem; font-weight:700; padding:0.25rem 0.6rem; border-radius:0.375rem;">
                            &#9733; {{ number_format($item['rating'], 1) }}
                        </span>
                    </td>
                    <td style="padding:0.85rem 1rem; text-align:center; font-weight:900; color:#B87C39; font-size:1rem;">
                        {{ number_format($skor, 3) }}
                    </td>
                    <td style="padding:0.85rem 1rem; text-align:center;">
                        <span class="predikat-badge" style="display:inline-block; background:{{ $pBg }}; border:1px solid {{ $pBorder }}; color:{{ $pColor }}; font-size:0.7rem; font-weight:700; padding:0.3rem 0.7rem; border-radius:0.5rem;">
                            {{ $predikat }}
                        </span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="padding:3rem; text-align:center; color:#9ca3af; font-weight:600;">Belum ada data kafe untuk ditampilkan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<table class="print-only-table" style="width:100%; border-collapse:collapse; font-size:11pt; margin-bottom:20px;">
    <thead>
        <tr style="background:#1a1a1a; color:#fff;">
            <th style="border:1px solid #333; padding:7px 10px; text-align:center; width:5%;">No.</th>
            <th style="border:1px solid #333; padding:7px 10px; text-align:left; width:28%;">Nama Kafe</th>
            <th style="border:1px solid #333; padding:7px 10px; text-align:left; width:29%;">Alamat</th>
            <th style="border:1px solid #333; padding:7px 10px; text-align:center; width:10%;">Rating</th>
            <th style="border:1px solid #333; padding:7px 10px; text-align:center; width:12%;">Skor SAW (V)</th>
            <th style="border:1px solid #333; padding:7px 10px; text-align:center; width:16%;">Predikat</th>
        </tr>
    </thead>
    <tbody>
        @forelse($hasil as $index => $item)
            @php
                $skor = $item['skor'];
                $predikat = 'Cukup';
                if ($skor >= 0.85)     $predikat = 'Sangat Direkomendasikan';
                elseif ($skor >= 0.70) $predikat = 'Direkomendasikan';
                $rowBg = $index % 2 === 0 ? '#ffffff' : '#f5f5f5';
            @endphp
            <tr style="background:{{ $rowBg }};">
                <td style="border:1px solid #bbb; padding:6px 10px; text-align:center; font-weight:bold;">{{ $index + 1 }}</td>
                <td style="border:1px solid #bbb; padding:6px 10px; font-weight:bold;">{{ $item['nama_kafe'] }}</td>
                <td style="border:1px solid #bbb; padding:6px 10px; font-size:10.5pt;">{{ $item['alamat'] ?: '—' }}</td>
                <td style="border:1px solid #bbb; padding:6px 10px; text-align:center;">{{ number_format($item['rating'], 1) }}</td>
                <td style="border:1px solid #bbb; padding:6px 10px; text-align:center; font-weight:bold;">{{ number_format($skor, 3) }}</td>
                <td style="border:1px solid #bbb; padding:6px 10px; text-align:center;">{{ $predikat }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="6" style="padding:12px; text-align:center; color:#888; border:1px solid #bbb;">Tidak ada data.</td>
            </tr>
        @endforelse
    </tbody>
</table>

<div class="screen-only" style="margin-top:2rem; padding-top:1.5rem; border-top:1px solid #f3f4f6; display:flex; justify-content:space-between; align-items:flex-end; gap:1.5rem; flex-wrap:wrap;">
    <p style="font-size:0.75rem; color:#111; max-width:28rem; line-height:1.6; margin:0;">
        <strong style="color:#111;">Catatan:</strong> Peringkat dihitung secara dinamis menggunakan metode SAW berdasarkan kriteria dan bobot aktif pada saat laporan ini dicetak.
    </p>
    <div style="text-align:center;">
        <p style="font-size:0.75rem; color:#9ca3af; margin:0 0 2.5rem;">Malang, {{ \Carbon\Carbon::now()->isoFormat('D MMMM YYYY') }}</p>
        <p style="font-size:0.875rem; font-weight:900; color:#111; text-decoration:underline; text-underline-offset:4px; margin:0;">Administrator Ngafein</p>
        <p style="font-size:0.65rem; color:#9ca3af; margin:0.25rem 0 0;">Sistem Pakar / DSS Officer</p>
    </div>
</div>

<div class="print-only" style="margin-top:28px; padding-top:10px; border-top:1px solid #999;">
    <table style="width:100%; font-size:10.5pt;">
        <tr>
            <td style="width:55%; vertical-align:top; padding-right:20px;">
                <em style="color:#444;">
                    * Perhitungan menggunakan metode Simple Additive Weighting (SAW).<br>
                    * Hasil bersifat dinamis sesuai data pada saat laporan dicetak.
                </em>
            </td>
            <td style="width:45%; text-align:center; vertical-align:top;">
                <p style="margin:0 0 48px;">Malang, {{ \Carbon\Carbon::now()->isoFormat('D MMMM YYYY') }}</p>
                <p style="margin:0; font-weight:bold; border-top:1px solid #000; display:inline-block; padding-top:4px;">Administrator Ngafein</p>
            </td>
        </tr>
    </table>
</div>
