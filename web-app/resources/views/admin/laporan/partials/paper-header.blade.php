<div style="border-bottom: 2px solid #1a1a1a; padding-bottom: 1.5rem; margin-bottom: 1.75rem;">
    <div class="screen-only flex items-start justify-between gap-6">
        <div class="flex items-center gap-4">
            <img src="{{ asset('assets/images/logo-ngafein.png') }}" alt="Logo Ngafein" style="height:3.5rem; width:auto; object-fit:contain; flex-shrink:0;">
            <div>
                <p style="font-size:0.65rem; font-weight:800; text-transform:uppercase; letter-spacing:0.2em; color:#B87C39; margin-bottom:0.2rem;">Sistem Pendukung Keputusan · Ngafein</p>
                <h2 style="font-size:1.25rem; font-weight:900; color:#111; line-height:1.3; margin:0;">Laporan Pemeringkatan Rekomendasi Kafe</h2>
                <p style="font-size:0.7rem; color:#777; margin-top:0.2rem;">Kota Malang &nbsp;·&nbsp; Metode Simple Additive Weighting (SAW)</p>
            </div>
        </div>
        <div style="text-align:right; flex-shrink:0; border-left:1px solid #e5e7eb; padding-left:1.5rem;">
            <p style="font-size:0.65rem; font-weight:700; text-transform:uppercase; letter-spacing:0.15em; color:#999; margin-bottom:0.25rem;">Dicetak pada</p>
            <p style="font-size:0.9rem; font-weight:900; color:#111; margin:0;">{{ \Carbon\Carbon::now()->isoFormat('D MMMM YYYY') }}</p>
            <p style="font-size:0.75rem; color:#666; margin-top:0.1rem;">{{ \Carbon\Carbon::now()->format('H:i') }} WIB</p>
        </div>
    </div>

    <div class="print-only" style="text-align:center;">
        <p style="font-size:14pt; font-weight:bold; text-transform:uppercase; letter-spacing:1px; margin:0 0 4px;">LAPORAN HASIL PEMERINGKATAN REKOMENDASI KAFE</p>
        <p style="font-size:12pt; font-weight:bold; margin:0 0 4px;">METODE SIMPLE ADDITIVE WEIGHTING (SAW)</p>
        <p style="font-size:11pt; color:#333; margin:6px 0 0;">Sistem Ngafein &nbsp;·&nbsp; Kota Malang</p>
        <p style="font-size:10pt; color:#555; margin:2px 0 0;">Dicetak: {{ \Carbon\Carbon::now()->isoFormat('D MMMM YYYY, HH:mm') }} WIB</p>
    </div>
</div>
