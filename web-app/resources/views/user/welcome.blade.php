<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kopi dan Cerita – Ngafein Malang</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,400;1,700&family=Source+Sans+3:wght@300;400;600&display=swap" rel="stylesheet">

    <style>
        /* ─── RESET ─────────────────────────────────────────── */
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
        img { display: block; max-width: 100%; }
        a { text-decoration: none; color: inherit; }
        button { font-family: inherit; cursor: pointer; }

        /* ─── TOKENS ──────────────────────────────────────────
           Referensi warna dari desain:
           bg utama   : #1a1008  (coklat sangat gelap)
           panel      : #2b1a09  (coklat gelap)
           card       : #221306  (lebih gelap)
           gold       : #c9891a  (oranye-emas tombol)
           gold-text  : #e2a53a  (emas lebih terang untuk teks)
           krem       : #f0e0c0  (teks utama)
           muted      : #8c7459  (teks sekunder)
        ─────────────────────────────────────────────────────── */
        :root {
            --page-bg   : #FFFFFF;
            --panel-bg  : #2b1a09;
            --card-bg   : #221306;
            --card-bg2  : #1e1106;
            --gold      : #c9891a;
            --gold-hover: #dda030;
            --gold-text : #e2a53a;
            --cream     : #f0e0c0;
            --muted     : #8c7459;
            --border    : rgba(160,110,40,0.22);
            --r-lg      : 14px;
            --r-xl      : 18px;
        }

        /* ─── BASE ───────────────────────────────────────────── */
        html, body { min-height: 100vh; }
        body {
            font-family: 'Source Sans 3', sans-serif;
            background: var(--page-bg);
            color: var(--cream);
            font-size: 15px;
            line-height: 1.6;
        }

        /* ═══════════════════════════════════════════════════════
           1. HERO
        ═══════════════════════════════════════════════════════ */
        .hero {
            position: relative;
            height: 600px;
            display: flex;
            align-items: center;
            overflow: hidden;
        }

        /* foto kafe sebagai background */
        .hero-bg {
            position: absolute;
            inset: 0;
            background:
                url('https://images.unsplash.com/photo-1469631423273-6995642a6a40?q=80&w=1503&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D')
                center 35% / cover no-repeat;
        }

        /* gradien gelap dari bawah – persis seperti desain */
        .hero-bg::after {
            content: '';
            position: absolute;
            inset: 0;
            background:
                linear-gradient(to right,  rgba(20,11,3,0.78) 40%, rgba(20,11,3,0.20) 100%),
                linear-gradient(to bottom, rgba(20,11,3,0.05) 0%,  rgba(20,11,3,0.90) 100%);
        }

        .hero-body {
            position: relative;
            z-index: 2;
            padding: 0 44px 80px;
        }

        .hero-eyebrow {
            font-size: 16px;
            letter-spacing: 2.5px;
            text-transform: uppercase;
            color: #fff;
            font-weight: 400;
            margin-bottom: 12px;
        }

        .hero-title {
            font-family: 'Playfair Display', serif;
            font-size: 54px;
            font-weight: 700;
            line-height: 1.2;
            color: #fff;
            margin-bottom: 12px;
        }

        .hero-sub {
            font-family: 'Playfair Display', serif;
            font-style: italic;
            font-size: 16px;
            letter-spacing: 1.5px;
            color: #fff;
            font-weight: 300;
        }

        /* ═══════════════════════════════════════════════════════
           2. PANEL "SIAP JELAJAHI"
        ═══════════════════════════════════════════════════════ */
        .panel-wrap {
            padding: 0 28px;
            position: relative;
            z-index: 10;
            margin-top: -52px;
        }

        .panel {
            background: var(--panel-bg);
            border: 1px solid var(--border);
            border-radius: var(--r-xl);
            padding: 28px 32px;
            display: grid;
            grid-template-columns: 1fr auto auto;
            align-items: center;
            gap: 32px;
            box-shadow: 0 18px 54px rgba(0,0,0,0.55);
        }

        .panel-text h2 {
            font-family: 'Playfair Display', serif;
            font-size: 28px;
            font-weight: 700;
            line-height: 1.3;
            margin-bottom: 8px;
        }

        .panel-text h2 em {
            font-style: italic;
            color: var(--gold-text);
        }

        .panel-text p {
            font-size: 12.5px;
            color: var(--muted);
            line-height: 1.65;
            max-width: 320px;
        }

        .panel-stats {
            display: flex;
            align-items: center;
            gap: 24px;
        }

        .pstat { text-align: center; }

        .pstat-val {
            display: block;
            font-family: 'Playfair Display', serif;
            font-size: 34px;
            font-weight: 700;
            color: var(--gold-text);
            line-height: 1;
        }

        .pstat-lbl {
            font-size: 10.5px;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-top: 4px;
            display: block;
        }

        .pstat-div {
            width: 1px;
            height: 40px;
            background: var(--border);
        }

        /* tombol "Cari Rekomendasimu" – kuning-emas persis di desain */
        .btn-cari {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            background: var(--gold);
            color: #1a0e03;
            font-size: 13px;
            font-weight: 600;
            padding: 12px 22px;
            border-radius: 50px;
            border: none;
            white-space: nowrap;
            transition: background .18s, transform .12s;
            box-shadow: 0 4px 16px rgba(180,120,20,0.32);
        }

        .btn-cari:hover {
            background: var(--gold-hover);
            transform: translateY(-2px);
        }

        /* ═══════════════════════════════════════════════════════
           3. SECTION UTILITIES
        ═══════════════════════════════════════════════════════ */
        .sec {
            padding: 52px 44px;
        }

        .sec-hdr {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-bottom: 28px;
        }

        .sec-label {
            font-size: 11px;
            letter-spacing: 1.8px;
            text-transform: uppercase;
            color: var(--muted);
            margin-bottom: 6px;
        }

        .sec-title {
            font-family: 'Playfair Display', serif;
            font-size: 24px;
            font-weight: 700;
            color: var(--panel-bg);
        }

        .sec-title em {
            font-style: italic;
            color: var(--gold-text);
        }

        .sec-sub {
            font-size: 12px;
            color: var(--muted);
            margin-top: 5px;
        }

        /* tombol "Lihat Semua Kafe →" */
        .btn-ghost {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            border: 1px solid var(--border);
            color: var(--gold-text);
            background: transparent;
            font-size: 12.5px;
            font-weight: 600;
            padding: 8px 18px;
            border-radius: 50px;
            white-space: nowrap;
            transition: background .18s, border-color .18s;
        }

        .btn-ghost:hover {
            background: rgba(200,137,26,0.10);
            border-color: var(--gold);
        }

        /* ═══════════════════════════════════════════════════════
           4. KAFE CARDS  (grid 3 kolom persis desain)
        ═══════════════════════════════════════════════════════ */
        .kafe-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 18px;
        }

        .kafe-card {
            background: var(--page-bg);
            border: 1px solid var(--border);
            border-radius: var(--r-lg);
            overflow: hidden;
            transition: transform .2s, box-shadow .2s;
        }

        .kafe-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 16px 42px rgba(0,0,0,0.48);
        }

        /* area foto – pakai placeholder bernuansa coklat seperti desain */
        .kafe-thumb {
            height: 174px;
            position: relative;
            overflow: hidden;
        }

        .kafe-thumb-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* jika tidak ada foto, tampilkan gradient placeholder */
        .kafe-thumb-ph {
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #2c1a08 0%, #4a2e10 50%, #382010 100%);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* icon kopi kecil di dalam placeholder */
        .kafe-thumb-ph svg { opacity: 0.22; }

        /* chip lokasi pojok kiri atas kartu */
        .kafe-chip {
            position: absolute;
            top: 10px;
            left: 10px;
            background: rgba(15,8,2,0.76);
            backdrop-filter: blur(4px);
            border: 1px solid rgba(140,116,89,0.30);
            border-radius: 6px;
            padding: 3px 9px;
            font-size: 10.5px;
            color: rgba(240,224,192,0.78);
            letter-spacing: .3px;
        }

        .kafe-body {
            padding: 16px 16px 18px;
        }

        .kafe-name {
            font-family: 'Playfair Display', serif;
            font-size: 15.5px;
            font-weight: 700;
            margin-bottom: 4px;
            color: var(--panel-bg);
        }

        .kafe-alamat {
            font-size: 11.5px;
            color: var(--muted);
            line-height: 1.45;
            margin-bottom: 12px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* baris meta: rating + jam */
        .kafe-meta {
            display: flex;
            gap: 14px;
            font-size: 11.5px;
            color: var(--panel-bg);
            margin-bottom: 5px;
            flex-wrap: wrap;
        }

        .kafe-meta-item { display: flex; align-items: center; gap: 4px; }

        .star { color: var(--gold); font-size: 12px; }

        /* harga – teks lebih terang */
        .kafe-price {
            font-size: 12px;
            color: var(--panel-bg);
            margin-bottom: 14px;
        }

        .kafe-price b {
            color: var(--panel-bg);
            font-weight: 600;
        }

        /* tombol Lihat Detail – mirip desain: border tipis, teks emas */
        .btn-detail {
            display: block;
            width: 100%;
            padding: 9px 0;
            text-align: center;
            border: 1px solid rgba(160,110,40,0.32);
            border-radius: 8px;
            background: transparent;
            color: var(--gold-text);
            font-size: 12.5px;
            font-weight: 600;
            letter-spacing: .3px;
            transition: background .18s, border-color .18s;
        }

        .btn-detail:hover {
            background: var(--gold);
            border-color: var(--gold);
            color: #fff;
        }

        /* ═══════════════════════════════════════════════════════
           5. PANDUAN WAKTU (4 kartu berwarna)
        ═══════════════════════════════════════════════════════ */
        .waktu-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 14px;
        }

        .wk {
            border-radius: var(--r-lg);
            padding: 20px 18px 42px;
            border: 1px solid var(--border);
            position: relative;
            overflow: hidden;
            transition: transform .18s;
        }

        .wk:hover { transform: translateY(-3px); }

        /* Warna masing-masing kartu – diambil dari referensi gambar */
        .wk-pagi {background: linear-gradient(160deg, #1f1206 0%, #a06a28 100%);}
        .wk-morning {background: linear-gradient(160deg, #c8891a 0%, #f4e2a1 100%);}
        .wk-golden {background: linear-gradient(160deg, #5a341c 0%, #d6a84a 100%);}
        .wk-night {background: linear-gradient(160deg, #0f0f0f 0%, #3b1f0f 100%);}
        
        /* kartu aktif (waktu sekarang): border emas */
        .wk-active { border-color: var(--gold); box-shadow: 0 0 0 1px rgba(200,137,26,0.20); }
        .wk-active .wk-name { color: #fff }

        .wk-time {
            font-size: 10px;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: #fff
            margin-bottom: 9px;
        }

        .wk-name {
            font-family: 'Playfair Display', serif;
            font-size: 17px;
            font-weight: 700;
            margin-bottom: 9px;
            line-height: 1.2;
        }

        .wk-desc {
            font-size: 11.5px;
            color: #fff
            line-height: 1.60;
        }

        /* emoji sudut kanan bawah */
        .wk-emoji {
            position: absolute;
            bottom: 13px;
            right: 14px;
            font-size: 24px;
            opacity: 0.50;
            line-height: 1;
        }

        /* ═══════════════════════════════════════════════════════
           6. FOOTER
        ═══════════════════════════════════════════════════════ */
        .site-footer {
            text-align: center;
            padding: 20px 24px;
            border-top: 1px solid var(--border);
            font-size: 11.5px;
            color: #fff);
            background: var(--panel-bg);
        }

        /* ═══════════════════════════════════════════════════════
           7. MODAL – SEMUA KAFE
        ═══════════════════════════════════════════════════════ */
        .modal-bg {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(6,3,1,0.90);
            backdrop-filter: blur(6px);
            z-index: 300;
            align-items: center;
            justify-content: center;
        }

        .modal-bg.open { display: flex; }

        .modal {
            background: var(--panel-bg);
            border: 1px solid var(--border);
            border-radius: var(--r-xl);
            width: min(980px, 96vw);
            max-height: 86vh;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            box-shadow: 0 24px 72px rgba(0,0,0,0.65);
        }

        .modal-hdr {
            padding: 20px 26px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .modal-hdr h3 {
            font-family: 'Playfair Display', serif;
            font-size: 19px;
        }

        .modal-close {
            background: none;
            border: none;
            color: var(--muted);
            font-size: 20px;
            line-height: 1;
            transition: color .15s;
        }

        .modal-close:hover { color: var(--cream); }

        .modal-body {
            overflow-y: auto;
            padding: 18px 26px 26px;
        }

        .tbl {
            width: 100%;
            border-collapse: collapse;
            font-size: 12.5px;
        }

        .tbl th {
            text-align: left;
            padding: 8px 11px;
            font-size: 10.5px;
            letter-spacing: .8px;
            text-transform: uppercase;
            color: var(--muted);
            font-weight: 600;
            border-bottom: 1px solid var(--border);
            white-space: nowrap;
        }

        .tbl td {
            padding: 12px 11px;
            border-bottom: 1px solid rgba(160,110,40,0.07);
            vertical-align: middle;
        }

        .tbl tr:last-child td { border-bottom: none; }
        .tbl tr:hover td { background: rgba(200,137,26,0.04); }

        .pill-rating {
            display: inline-block;
            background: rgba(200,137,26,0.16);
            color: var(--gold-text);
            border-radius: 20px;
            padding: 2px 9px;
            font-size: 11.5px;
            font-weight: 600;
        }

        .maps-a { color: var(--gold); font-size: 11.5px; }
        .maps-a:hover { text-decoration: underline; }

        .btn-sm {
            display: inline-block;
            border: 1px solid var(--border);
            color: var(--gold-text);
            background: transparent;
            padding: 4px 13px;
            border-radius: 50px;
            font-size: 11px;
            font-weight: 600;
            transition: background .15s;
        }

        .btn-sm:hover { background: rgba(200,137,26,0.10); }

        /* ─── RESPONSIVE ─────────────────────────────────────── */
        @media (max-width: 860px) {
            .hero-title { font-size: 36px; }
            .hero-body  { padding: 0 20px 44px; }
            .panel-wrap { padding: 0 14px; }
            .panel { grid-template-columns: 1fr; gap: 20px; }
            .sec  { padding: 36px 20px; }
            .kafe-grid  { grid-template-columns: 1fr; }
            .waktu-grid { grid-template-columns: repeat(2, 1fr); }
        }
    </style>
</head>
<body>

{{-- ══════════════════════════════════════════════════ --}}
{{--  HERO                                              --}}
{{-- ══════════════════════════════════════════════════ --}}
<section class="hero">
    <div class="hero-bg"></div>
    <div class="hero-body">
        <p class="hero-eyebrow">Temukan Tempat Ngopi Terbaik</p>
        <h1 class="hero-title">Kopi dan Cerita<br>di Setiap Sudut Kota</h1>
        <p class="hero-sub">Di mana moodmu hari ini membawamu?</p>
    </div>
</section>

{{-- ══════════════════════════════════════════════════ --}}
{{--  PANEL EKSPLORASI                                  --}}
{{-- ══════════════════════════════════════════════════ --}}
<div class="panel-wrap">
    <div class="panel">

        {{-- teks kiri --}}
        <div class="panel-text">
            <h2>Siap Jelajahi <em>Kafe Terbaik</em> di Malang?</h2>
            <p>Temukan lebih dari satu kafe untuk dinikmati, dilengkapi foto terkini,
               ulasan terlengkap, filter spot hingga kamu guna kafe favorit kamu.</p>
        </div>

        {{-- statistik tengah --}}
        <div class="panel-stats">
            <div class="pstat">
                <span class="pstat-val">{{ $totalKafe }}+</span>
                <span class="pstat-lbl">Kafe Terdaftar</span>
            </div>
            <div class="pstat-div"></div>
            <div class="pstat">
                <span class="pstat-val">{{ number_format($avgRating, 1) }}</span>
                <span class="pstat-lbl">Rating Rata-rata</span>
            </div>
        </div>

        {{-- tombol → /cafe/explore --}}
        <a href="{{ route('user.cafe.index') }}" class="btn-cari">
            <svg width="14" height="14" viewBox="0 0 20 20" fill="none" aria-hidden="true">
                <circle cx="9" cy="9" r="7" stroke="currentColor" stroke-width="2"/>
                <path d="M14 14l4 4" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
            </svg>
            Cari Rekomendasimu
        </a>

    </div>
</div>

{{-- ══════════════════════════════════════════════════ --}}
{{--  PILIHAN KAFE UNGGULAN                            --}}
{{-- ══════════════════════════════════════════════════ --}}
<section class="sec">
    <div class="sec-hdr">
        <div>
            <p class="sec-label">Rekomendasi tempat pilihan yang sudah dikurasi khusus untuk kamu</p>
            <h2 class="sec-title">Pilihan Kafe yang Bikin Betah</h2>
        </div>
            <a href="{{ route('user.cafe.index') }}" class="btn-ghost">
                Lihat Semua Kafe &rarr;
            </a>
    </div>

    <div class="kafe-grid">
        @foreach($kafeUnggulan as $kafe)
        <div class="kafe-card">

            {{-- Thumbnail --}}
            <div class="kafe-thumb">
                <img src="https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?w=900&q=80" 
                    alt="Cafe"
                    class="kafe-thumb-img">

                <span class="kafe-chip">
                    {{ $kafe->jarak ?? '–' }} km &middot; Malang
                </span>
            </div>

            {{-- Body --}}
            <div class="kafe-body">
                <h3 class="kafe-name">{{ $kafe->nama_kafe }}</h3>
                <p class="kafe-alamat">{{ $kafe->alamat }}</p>

                <div class="kafe-meta">
                    <span class="kafe-meta-item">
                        <span class="star">&#9733;</span>
                        {{ number_format($kafe->rating, 1) }}
                    </span>
                    <span class="kafe-meta-item">
                        &#128336;
                        {{ \Carbon\Carbon::parse($kafe->jam_buka)->format('H:i') }}
                        &ndash;
                        {{ \Carbon\Carbon::parse($kafe->jam_tutup)->format('H:i') }}
                    </span>
                </div>

                <p class="kafe-price">
                    <b>Rp {{ number_format($kafe->harga_min / 1000, 0) }}k &ndash;
                       Rp {{ number_format($kafe->harga_max / 1000, 0) }}k</b>
                </p>

                {{-- → halaman detail kafe --}}
                <a href="{{ route('user.cafe.detail', $kafe->id_kafe) }}"
                   class="btn-detail">Lihat Detail</a>
            </div>

        </div>
        @endforeach
    </div>
</section>

{{-- ══════════════════════════════════════════════════ --}}
{{--  PANDUAN WAKTU NGOPI                              --}}
{{-- ══════════════════════════════════════════════════ --}}
<section class="sec" style="padding-top:0;">
    <div style="margin-bottom:28px;">
        <p class="sec-label">-- Panduan Waktu --</p>
        <h2 class="sec-title">
            Kapan Waktu <em>Terbaik</em> Ngopi?
        </h2>
        <p class="sec-sub">Setiap saat punya karakter yang berbeda. Pilih yang cocok dengan ritme harimu.</p>
    </div>

    @php
        $h = now()->hour;
        $waktu = [
            ['range'=>'06:00 – 10:00','nama'=>'Pagi Sunyi',   'cls'=>'wk-pagi',
             'emoji'=>'🌙',
             'desc'=>'Coffeeshop sepi, udara masih segar. Waktu terbaik untuk kerja fokus atau baca buku tanpa gangguan.',
             'on'=> $h>=6 && $h<10],
            ['range'=>'10:00 – 14:00','nama'=>'Morning Rush', 'cls'=>'wk-morning',
             'emoji'=>'⚡',
             'desc'=>'Coffeeshop mulai ramai. Cocok untuk meeting santai, diskusi ide, dan ngerjain tugas bersama.',
             'on'=> $h>=10 && $h<14],
            ['range'=>'14:00 – 18:00','nama'=>'Golden Hour',  'cls'=>'wk-golden',
             'emoji'=>'🌤️',
             'desc'=>'Sore hari dengan cahaya keemasan. Foto instagramable dan obrolan hangat mengalir begitu saja.',
             'on'=> $h>=14 && $h<18],
            ['range'=>'19:00 – 00:00','nama'=>'Night Mode',   'cls'=>'wk-night',
             'emoji'=>'🌙',
             'desc'=>'Remang lampu, musik soft, aroma kopi. Sempurna untuk refleksi, nulis jurnal, atau kencan santai.',
             'on'=> $h>=19 || $h<6],
        ];
    @endphp

    <div class="waktu-grid">
        @foreach($waktu as $w)
        <div class="wk {{ $w['cls'] }} {{ $w['on'] ? 'wk-active' : '' }}">
            <p class="wk-time">{{ $w['range'] }}</p>
            <h4 class="wk-name">{{ $w['nama'] }}</h4>
            <p class="wk-desc">{{ $w['desc'] }}</p>
            <span class="wk-emoji">{{ $w['emoji'] }}</span>
        </div>
        @endforeach
    </div>
</section>

{{-- ══════════════════════════════════════════════════ --}}
{{--  FOOTER                                            --}}
{{-- ══════════════════════════════════════════════════ --}}
<footer class="site-footer">
    Copyright &copy; {{ date('Y') }} Ngafein Company
</footer>

{{-- ══════════════════════════════════════════════════ --}}
{{--  MODAL – SEMUA KAFE                               --}}
{{-- ══════════════════════════════════════════════════ --}}
<div class="modal-bg" id="mdlSemua">
    <div class="modal">
        <div class="modal-hdr">
            <h3>Semua Kafe di Malang</h3>
            <button class="modal-close"
                    onclick="document.getElementById('mdlSemua').classList.remove('open')">
                &times;
            </button>
        </div>
        <div class="modal-body">
            <table class="tbl">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Kafe</th>
                        <th>Alamat</th>
                        <th>Rating</th>
                        <th>Harga</th>
                        <th>Jam</th>
                        <th>Jarak</th>
                        <th>Maps</th>
                        <th>Detail</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($semuaKafe as $i => $k)
                    <tr>
                        <td style="color:var(--muted);">{{ $i + 1 }}</td>
                        <td style="font-weight:600; white-space:nowrap;">{{ $k->nama_kafe }}</td>
                        <td style="color:var(--muted); max-width:190px; font-size:11.5px;">{{ $k->alamat }}</td>
                        <td><span class="pill-rating">&#9733; {{ number_format($k->rating, 1) }}</span></td>
                        <td style="white-space:nowrap;">
                            Rp{{ number_format($k->harga_min/1000,0) }}k &ndash;
                            Rp{{ number_format($k->harga_max/1000,0) }}k
                        </td>
                        <td style="white-space:nowrap; color:rgba(240,224,192,.70);">
                            {{ \Carbon\Carbon::parse($k->jam_buka)->format('H:i') }}
                            &ndash;
                            {{ \Carbon\Carbon::parse($k->jam_tutup)->format('H:i') }}
                        </td>
                        <td style="color:rgba(240,224,192,.65);">{{ $k->jarak ?? '–' }} km</td>
                        <td>
                            @if($k->link_maps)
                                <a href="{{ $k->link_maps }}" target="_blank" class="maps-a">&#128205; Buka</a>
                            @else
                                <span style="color:var(--muted);">–</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('user.cafe.detail', $k->id_kafe) }}"
                               class="btn-sm">Detail &rarr;</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    document.getElementById('mdlSemua').addEventListener('click', function(e) {
        if (e.target === this) this.classList.remove('open');
    });
</script>

</body>
</html>