<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Laporan SAW - Ngafein</title>
    <style>
        @page {
            size: A4 portrait;
            margin: 1.5cm 1.5cm 2cm 1.5cm;
        }
        body {
            font-family: "Times New Roman", Times, serif;
            color: #000;
            background: #fff;
            margin: 0;
            padding: 0;
            line-height: 1.4;
        }
        
        h1, h2, h3, h4, h5, h6, p { margin: 0; padding: 0; }
        .text-center { text-align: center; }
        .text-left { text-align: left; }
        .font-bold { font-weight: bold; }
        
        .kop-surat {
            border-bottom: 3px double #000;
            padding-bottom: 15px;
            margin-bottom: 25px;
            text-align: center;
        }
        .kop-surat h1 {
            font-size: 16pt;
            letter-spacing: 1px;
            margin-bottom: 5px;
        }
        .kop-surat h2 {
            font-size: 14pt;
            margin-bottom: 8px;
        }
        .kop-surat p {
            font-size: 11pt;
            color: #333;
        }

        .section-title {
            font-size: 12pt;
            font-weight: bold;
            border-bottom: 1px solid #000;
            padding-bottom: 4px;
            margin-bottom: 12px;
        }
        .summary-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 11pt;
        }
        .summary-table td {
            padding: 5px 8px;
            vertical-align: top;
        }
        
        .bobot-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
            font-size: 11pt;
        }
        .bobot-table th, .bobot-table td {
            border: 1px solid #000;
            padding: 6px 8px;
            text-align: center;
        }
        .bobot-table th { background-color: #f0f0f0; }

        .ranking-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 40px;
            font-size: 11pt;
        }
        .ranking-table th {
            border: 1px solid #000;
            background-color: #f0f0f0;
            padding: 8px 10px;
            text-align: center;
            font-weight: bold;
        }
        .ranking-table td {
            border: 1px solid #000;
            padding: 7px 10px;
        }
        
        .ttd-container {
            width: 100%;
            margin-top: 50px;
        }
        .ttd-box {
            float: right;
            text-align: center;
            width: 250px;
        }
        .ttd-box .tanggal { margin-bottom: 60px; }
        .ttd-box .nama {
            font-weight: bold;
            text-decoration: underline;
        }
        
        .clear { clear: both; }
    </style>
</head>
<body onload="window.print();">

    <div class="kop-surat">
        <h1>LAPORAN HASIL PEMERINGKATAN REKOMENDASI KAFE</h1>
        <h2>METODE SIMPLE ADDITIVE WEIGHTING (SAW)</h2>
        <p>Sistem Pakar Ngafein - Kota Malang</p>
    </div>

    <div class="section-title">1. Ringkasan Eksekutif</div>
    <table class="summary-table">
        <tr>
            <td style="width: 25%;"><strong>Total Alternatif</strong></td>
            <td style="width: 25%;">: {{ $totalKafe }} kafe</td>
            <td style="width: 25%;"><strong>Rata-rata Skor (V)</strong></td>
            <td style="width: 25%;">: {{ number_format($rataRataSkor, 3) }}</td>
        </tr>
        <tr>
            <td><strong>Peringkat #1</strong></td>
            <td colspan="3">: {{ $topCafe ? $topCafe['nama_kafe'] : '-' }} (Skor: {{ $topCafe ? number_format($topCafe['skor'], 3) : '0.000' }})</td>
        </tr>
    </table>

    <div class="section-title" style="border:none; margin-bottom:5px;">2. Distribusi Bobot Kriteria Acuan</div>
    <table class="bobot-table">
        <tr>
            <th>Harga</th>
            <th>Jarak</th>
            <th>Fasilitas</th>
            <th>Menu</th>
            <th>Jam Buka</th>
            <th>Rating</th>
        </tr>
        <tr>
            <td>{{ intval($bobot['harga']*100) }}%</td>
            <td>{{ intval($bobot['jarak']*100) }}%</td>
            <td>{{ intval($bobot['fasilitas']*100) }}%</td>
            <td>{{ intval($bobot['menu']*100) }}%</td>
            <td>{{ intval($bobot['jam_operasional']*100) }}%</td>
            <td>{{ intval($bobot['rating']*100) }}%</td>
        </tr>
    </table>

    <div class="section-title">3. Hasil Pemeringkatan Akhir</div>
    <table class="ranking-table">
        <thead>
            <tr>
                <th style="width: 5%;">No.</th>
                <th style="width: 28%; text-align: left;">Nama Kafe</th>
                <th style="width: 29%; text-align: left;">Alamat</th>
                <th style="width: 10%;">Rating</th>
                <th style="width: 13%;">Skor SAW (V)</th>
                <th style="width: 15%;">Predikat</th>
            </tr>
        </thead>
        <tbody>
            @forelse($hasil as $index => $item)
                @php
                    $skor = $item['skor'];
                    $predikat = 'Cukup';
                    if ($skor >= 0.85) $predikat = 'Sangat Direkomendasikan';
                    elseif ($skor >= 0.70) $predikat = 'Direkomendasikan';
                @endphp
                <tr>
                    <td class="text-center font-bold">{{ $index + 1 }}</td>
                    <td class="font-bold">{{ $item['nama_kafe'] }}</td>
                    <td style="font-size: 10.5pt;">{{ $item['alamat'] ?: '-' }}</td>
                    <td class="text-center">{{ number_format($item['rating'], 1) }}</td>
                    <td class="text-center font-bold">{{ number_format($skor, 3) }}</td>
                    <td class="text-center">{{ $predikat }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center" style="padding: 20px;">Tidak ada data kafe.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="ttd-container">
        <div style="float: left; width: 50%; font-size: 10pt; color: #555; font-style: italic; margin-top: 40px;">
            * Dokumen ini dicetak otomatis dari sistem.<br>
            * Hasil bersifat dinamis sesuai kondisi data saat cetak.
        </div>
        <div class="ttd-box">
            <div class="tanggal">Malang, {{ \Carbon\Carbon::now()->isoFormat('D MMMM YYYY') }}</div>
            <div class="nama">Administrator Ngafein</div>
            <div style="font-size: 10pt; color: #333; margin-top: 3px;">DSS Officer</div>
        </div>
        <div class="clear"></div>
    </div>

</body>
</html>
