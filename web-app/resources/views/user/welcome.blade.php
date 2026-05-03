<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kopi dan Cerita – Ngafein Malang</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,400;1,700&family=Source+Sans+3:wght@300;400;600&display=swap" rel="stylesheet">
    {{-- Alpine.js untuk live search --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        /* ─── RESET ─────────────────────────────────────────── */
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
        img { display: block; max-width: 100%; }
        a { text-decoration: none; color: inherit; }
        button { font-family: inherit; cursor: pointer; }

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
            min-height: 620px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            text-align: center;
        }

        .hero-bg {
            position: absolute;
            inset: 0;
            background:
                url('https://images.unsplash.com/photo-1469631423273-6995642a6a40?q=80&w=1503&auto=format&fit=crop')
                center 35% / cover no-repeat;
        }

        .hero-bg::after {
            content: '';
            position: absolute;
            inset: 0;
            background:
                radial-gradient(ellipse 70% 80% at 50% 55%, rgba(12,6,1,0.72) 0%, rgba(12,6,1,0.45) 100%),
                linear-gradient(to bottom, rgba(10,5,1,0.30) 0%, rgba(10,5,1,0.88) 100%);
        }

        .hero-bg::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.04'/%3E%3C/svg%3E");
            opacity: 0.18;
            z-index: 1;
            pointer-events: none;
        }

        .hero-body {
            position: relative;
            z-index: 2;
            padding: 0 24px 100px;
            max-width: 760px;
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0;
        }

        /* Eyebrow */
        .hero-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            font-size: 11px;
            font-weight: 500;
            letter-spacing: 3.5px;
            text-transform: uppercase;
            color: #f0b942;
            margin-bottom: 20px;
            opacity: 0;
            animation: fadeUp 0.7s ease 0.1s forwards;
        }

        .hero-eyebrow::before,
        .hero-eyebrow::after {
            content: '';
            display: block;
            width: 28px;
            height: 1px;
            background: #f0b942;
            opacity: 0.60;
        }

        /* Judul */
        .hero-title {
            font-family: 'Playfair Display', serif;
            font-size: clamp(32px, 5vw, 54px);
            font-weight: 700;
            line-height: 1.08;
            color: #fff;
            letter-spacing: -0.5px;
            margin-bottom: 18px;
            opacity: 0;
            animation: fadeUp 0.75s ease 0.22s forwards;
        }

        .hero-title .line-italic {
            font-style: italic;
            font-weight: 300;
            color: var(--cream);
            display: block;
        }

        /* Subtitle */
        .hero-sub {
            font-family: 'Playfair Display', serif;
            font-style: italic;
            font-size: 18px;
            font-weight: 300;
            letter-spacing: 0.8px;
            color: rgba(245,232,208,0.70);
            margin-bottom: 36px;
            opacity: 0;
            animation: fadeUp 0.75s ease 0.36s forwards;
        }

        /* ── SEARCH BAR ── */
        .hero-search {
            width: 100%;
            max-width: 560px;
            position: relative;
            opacity: 0;
            animation: fadeUp 0.80s ease 0.50s forwards;
        }

        .search-wrap {
            display: flex;
            align-items: center;
            background: rgba(255,255,255,0.07);
            border: 1px solid rgba(200,155,60,0.35);
            border-radius: 60px;
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            padding: 6px 6px 6px 22px;
            transition: border-color 0.2s, box-shadow 0.2s;
            box-shadow: 0 8px 32px rgba(0,0,0,0.45), inset 0 1px 0 rgba(255,255,255,0.06);
        }

        .search-wrap:focus-within {
            border-color: rgba(200,155,60,0.70);
            box-shadow: 0 8px 40px rgba(0,0,0,0.50), 0 0 0 3px rgba(201,137,26,0.15);
        }

        .search-icon {
            flex-shrink: 0;
            color: #f0b942;
            opacity: 0.80;
            margin-right: 10px;
        }

        .search-input {
            flex: 1;
            background: none;
            border: none;
            outline: none;
            font-family: 'Source Sans 3', sans-serif;
            font-size: 14px;
            font-weight: 300;
            color: #fff;
            letter-spacing: 0.2px;
            min-width: 0;
        }

        .search-input::placeholder {
            color: rgba(200,175,135,0.55);
            font-style: italic;
        }

        /* Tombol X clear */
        .search-clear {
            flex-shrink: 0;
            background: none;
            border: none;
            color: rgba(180,150,100,0.50);
            padding: 0 10px;
            font-size: 15px;
            line-height: 1;
            transition: color 0.15s;
        }
        .search-clear:hover { color: rgba(240,185,66,0.80); }

        .search-btn {
            flex-shrink: 0;
            background: var(--gold);
            color: #1a0e03;
            border: none;
            border-radius: 50px;
            padding: 10px 22px;
            font-family: 'Source Sans 3', sans-serif;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: 0.3px;
            display: flex;
            align-items: center;
            gap: 7px;
            transition: background 0.18s, transform 0.12s;
            white-space: nowrap;
        }

        .search-btn:hover {
            background: var(--gold-hover);
            transform: scale(1.03);
        }

        /* ── DROPDOWN ── */
        .search-dropdown {
            position: absolute;
            top: calc(100% + 10px);
            left: 0;
            right: 0;
            background: rgba(20,11,3,0.97);
            border: 1px solid rgba(200,155,60,0.20);
            border-radius: 18px;
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            box-shadow: 0 20px 60px rgba(0,0,0,0.72);
            overflow: hidden;
            z-index: 50;
            text-align: left;
        }

        .dropdown-hdr {
            padding: 10px 18px;
            border-bottom: 1px solid rgba(200,155,60,0.10);
            background: rgba(255,255,255,0.02);
        }

        .dropdown-hdr span {
            font-size: 9.5px;
            font-weight: 600;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: rgba(180,145,80,0.55);
        }

        .dropdown-loading {
            padding: 28px 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
        }

        .spinner {
            width: 22px;
            height: 22px;
            border: 2px solid rgba(200,155,60,0.18);
            border-top-color: #f0b942;
            border-radius: 50%;
            animation: spin 0.7s linear infinite;
        }

        @keyframes spin { to { transform: rotate(360deg); } }

        .loading-text {
            font-size: 10px;
            font-weight: 600;
            letter-spacing: 1.8px;
            text-transform: uppercase;
            color: rgba(180,145,80,0.50);
        }

        .dropdown-empty {
            padding: 28px 18px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
            text-align: center;
        }

        .empty-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(255,255,255,0.03);
            border: 1px solid rgba(200,155,60,0.14);
            display: flex;
            align-items: center;
            justify-content: center;
            color: rgba(200,155,60,0.38);
        }

        .dropdown-empty p {
            font-size: 11px;
            color: rgba(180,150,100,0.50);
            line-height: 1.6;
        }
        .dropdown-empty strong { color: rgba(245,232,208,0.70); }

        .result-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 13px 18px;
            border-bottom: 1px solid rgba(200,155,60,0.06);
            transition: background 0.15s;
            cursor: pointer;
            text-decoration: none;
        }

        .result-item:last-child { border-bottom: none; }
        .result-item:hover { background: rgba(200,155,60,0.06); }

        .result-left { display: flex; align-items: center; gap: 13px; }

        .result-icon {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: rgba(200,137,26,0.10);
            border: 1px solid rgba(200,137,26,0.18);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #f0b942;
            flex-shrink: 0;
            transition: background 0.15s, color 0.15s;
        }

        .result-item:hover .result-icon { background: var(--gold); color: #1a0e03; }

        .result-name {
            font-size: 13.5px;
            font-weight: 600;
            color: #fff;
            margin-bottom: 2px;
        }

        .result-meta {
            font-size: 11px;
            color: rgba(180,145,80,0.60);
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .result-rating { color: #f0b942; }

        .result-arrow {
            color: rgba(200,155,60,0.28);
            transition: transform 0.15s, color 0.15s;
            flex-shrink: 0;
        }

        .result-item:hover .result-arrow {
            transform: translateX(3px);
            color: rgba(200,155,60,0.60);
        }

        /* ── ANIMATIONS ── */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(18px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ═══════════════════════════════════════════════════════
        
        ═══════════════════════════════════════════════════════ */
        .panel-wrap {
            padding: 0 28px;
            position: relative;
            z-index: 10;
            margin-top: 0;
        }

        .panel-wrap {
            padding: 0 28px;
            padding-top: 32px; /* ← tambahkan ini */
            position: relative;
            z-index: 10;
            margin-top: 0;
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

        .panel-text h2 em { font-style: italic; color: var(--gold-text); }

        .panel-text p {
            font-size: 12.5px;
            color: var(--muted);
            line-height: 1.65;
            max-width: 320px;
        }

        .panel-stats { display: flex; align-items: center; gap: 24px; }
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

        .pstat-div { width: 1px; height: 40px; background: var(--border); }

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

        .btn-cari:hover { background: var(--gold-hover); transform: translateY(-2px); }

        /* ═══════════════════════════════════════════════════════
           3. SECTION UTILITIES
        ═══════════════════════════════════════════════════════ */
        .sec { padding: 52px 44px; }

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

        .sec-title em { font-style: italic; color: var(--gold-text); }
        .sec-sub { font-size: 12px; color: var(--muted); margin-top: 5px; }

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

        .btn-ghost:hover { background: rgba(200,137,26,0.10); border-color: var(--gold); }

        /* ═══════════════════════════════════════════════════════
           4. KAFE CARDS
        ═══════════════════════════════════════════════════════ */
        .kafe-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 18px; }

        .kafe-card {
            background: var(--page-bg);
            border: 1px solid var(--border);
            border-radius: var(--r-lg);
            overflow: hidden;
            transition: transform .2s, box-shadow .2s;
        }

        .kafe-card:hover { transform: translateY(-4px); box-shadow: 0 16px 42px rgba(0,0,0,0.48); }

        .kafe-thumb { height: 174px; position: relative; overflow: hidden; }
        .kafe-thumb-img { width: 100%; height: 100%; object-fit: cover; }

        .kafe-thumb-ph {
            width: 100%; height: 100%;
            background: linear-gradient(135deg, #2c1a08 0%, #4a2e10 50%, #382010 100%);
            display: flex; align-items: center; justify-content: center;
        }
        .kafe-thumb-ph svg { opacity: 0.22; }

        .kafe-chip {
            position: absolute; top: 10px; left: 10px;
            background: rgba(15,8,2,0.76);
            backdrop-filter: blur(4px);
            border: 1px solid rgba(140,116,89,0.30);
            border-radius: 6px;
            padding: 3px 9px;
            font-size: 10.5px;
            color: rgba(240,224,192,0.78);
            letter-spacing: .3px;
        }

        .kafe-body { padding: 16px 16px 18px; }

        .kafe-name {
            font-family: 'Playfair Display', serif;
            font-size: 15.5px;
            font-weight: 700;
            margin-bottom: 4px;
            color: var(--panel-bg);
        }

        .kafe-alamat {
            font-size: 11.5px; color: var(--muted); line-height: 1.45; margin-bottom: 12px;
            display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
        }

        .kafe-meta { display: flex; gap: 14px; font-size: 11.5px; color: var(--panel-bg); margin-bottom: 5px; flex-wrap: wrap; }
        .kafe-meta-item { display: flex; align-items: center; gap: 4px; }
        .star { color: var(--gold); font-size: 12px; }

        .kafe-price { font-size: 12px; color: var(--panel-bg); margin-bottom: 14px; }
        .kafe-price b { color: var(--panel-bg); font-weight: 600; }

        .btn-detail {
            display: block; width: 100%; padding: 9px 0; text-align: center;
            border: 1px solid rgba(160,110,40,0.32); border-radius: 8px;
            background: transparent; color: var(--gold-text);
            font-size: 12.5px; font-weight: 600; letter-spacing: .3px;
            transition: background .18s, border-color .18s;
        }
        .btn-detail:hover { background: var(--gold); border-color: var(--gold); color: #fff; }

        /* ═══════════════════════════════════════════════════════
           5. PANDUAN WAKTU
        ═══════════════════════════════════════════════════════ */
        .waktu-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 14px; }

        .wk {
            border-radius: var(--r-lg); padding: 20px 18px 42px;
            border: 1px solid var(--border); position: relative; overflow: hidden; transition: transform .18s;
        }
        .wk:hover { transform: translateY(-3px); }

        .wk-pagi    { background: linear-gradient(160deg, #1f1206 0%, #a06a28 100%); }
        .wk-morning { background: linear-gradient(160deg, #c8891a 0%, #f4e2a1 100%); }
        .wk-golden  { background: linear-gradient(160deg, #5a341c 0%, #d6a84a 100%); }
        .wk-night   { background: linear-gradient(160deg, #0f0f0f 0%, #3b1f0f 100%); }

        .wk-active { border-color: var(--gold); box-shadow: 0 0 0 1px rgba(200,137,26,0.20); }
        .wk-active .wk-name { color: #fff; }

        .wk-time { font-size: 10px; letter-spacing: 1.5px; text-transform: uppercase; color: #fff; margin-bottom: 9px; }
        .wk-name { font-family: 'Playfair Display', serif; font-size: 17px; font-weight: 700; margin-bottom: 9px; line-height: 1.2; }
        .wk-desc { font-size: 11.5px; color: #fff; line-height: 1.60; }
        .wk-emoji { position: absolute; bottom: 13px; right: 14px; font-size: 24px; opacity: 0.50; line-height: 1; }

        /* ═══════════════════════════════════════════════════════
           6. FOOTER
        ═══════════════════════════════════════════════════════ */
        .site-footer {
            text-align: center; padding: 20px 24px;
            border-top: 1px solid var(--border);
            font-size: 11.5px; color: #fff;
            background: var(--panel-bg);
        }

        /* ═══════════════════════════════════════════════════════
           7. MODAL
        ═══════════════════════════════════════════════════════ */
        .modal-bg {
            display: none; position: fixed; inset: 0;
            background: rgba(6,3,1,0.90); backdrop-filter: blur(6px);
            z-index: 300; align-items: center; justify-content: center;
        }
        .modal-bg.open { display: flex; }

        .modal {
            background: var(--panel-bg); border: 1px solid var(--border);
            border-radius: var(--r-xl); width: min(980px, 96vw); max-height: 86vh;
            display: flex; flex-direction: column; overflow: hidden;
            box-shadow: 0 24px 72px rgba(0,0,0,0.65);
        }

        .modal-hdr {
            padding: 20px 26px; border-bottom: 1px solid var(--border);
            display: flex; align-items: center; justify-content: space-between;
        }
        .modal-hdr h3 { font-family: 'Playfair Display', serif; font-size: 19px; }

        .modal-close { background: none; border: none; color: var(--muted); font-size: 20px; line-height: 1; transition: color .15s; }
        .modal-close:hover { color: var(--cream); }

        .modal-body { overflow-y: auto; padding: 18px 26px 26px; }

        .tbl { width: 100%; border-collapse: collapse; font-size: 12.5px; }
        .tbl th {
            text-align: left; padding: 8px 11px; font-size: 10.5px;
            letter-spacing: .8px; text-transform: uppercase; color: var(--muted);
            font-weight: 600; border-bottom: 1px solid var(--border); white-space: nowrap;
        }
        .tbl td { padding: 12px 11px; border-bottom: 1px solid rgba(160,110,40,0.07); vertical-align: middle; }
        .tbl tr:last-child td { border-bottom: none; }
        .tbl tr:hover td { background: rgba(200,137,26,0.04); }

        .pill-rating {
            display: inline-block; background: rgba(200,137,26,0.16);
            color: var(--gold-text); border-radius: 20px; padding: 2px 9px;
            font-size: 11.5px; font-weight: 600;
        }

        .maps-a { color: var(--gold); font-size: 11.5px; }
        .maps-a:hover { text-decoration: underline; }

        .btn-sm {
            display: inline-block; border: 1px solid var(--border); color: var(--gold-text);
            background: transparent; padding: 4px 13px; border-radius: 50px;
            font-size: 11px; font-weight: 600; transition: background .15s;
        }
        .btn-sm:hover { background: rgba(200,137,26,0.10); }

        /* ─── RESPONSIVE ─────────────────────────────────────── */
        @media (max-width: 860px) {
            .panel { grid-template-columns: 1fr; gap: 20px; }
            .sec  { padding: 36px 20px; }
            .kafe-grid  { grid-template-columns: 1fr; }
            .waktu-grid { grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 600px) {
            .hero { min-height: 560px; }
            .hero-body { padding: 0 16px 80px; }
            .hero-title { font-size: 32px; }
            .panel-wrap { padding: 0 14px; }
            .search-btn span { display: none; }
            .search-btn { padding: 10px 14px; }
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

        <h1 class="hero-title">
            Kopi dan Cerita
            <span class="line-italic">di Setiap Sudut Kota</span>
        </h1>

        <p class="hero-sub">Di mana moodmu hari ini membawamu?</p>

        {{-- ══════════════════════════════════════════════
             SEARCH BAR – Alpine.js live search
             Route: GET /cafe/search-api?q=...
             Route: GET /cafe/{id}  → user.cafe.detail
        ══════════════════════════════════════════════ --}}
        <div class="hero-search"
             x-data="{
                query: '',
                results: [],
                show: false,
                loading: false,
                timer: null,
                init() {
                    this.$watch('query', (val) => {
                        clearTimeout(this.timer);
                        if (val.trim().length < 2) {
                            this.results = [];
                            this.show = false;
                            return;
                        }
                        this.loading = true;
                        this.show = true;
                        this.timer = setTimeout(() => this.fetch(val), 400);
                    });
                },
                fetch(val) {
                    fetch(`/cafe/search-api?q=${encodeURIComponent(val)}`)
                        .then(r => r.json())
                        .then(data => { this.results = data; this.loading = false; })
                        .catch(() => { this.loading = false; });
                },
                clear() { this.query = ''; this.results = []; this.show = false; }
             }"
             @click.away="show = false"
             @keydown.escape.window="show = false">

            {{-- Input --}}
            <div class="search-wrap">
                <svg class="search-icon" width="16" height="16" viewBox="0 0 20 20" fill="none">
                    <circle cx="9" cy="9" r="6.5" stroke="currentColor" stroke-width="1.8"/>
                    <path d="M14 14l4 4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                </svg>

                <input
                    class="search-input"
                    type="text"
                    x-model="query"
                    @focus="if(results.length > 0) show = true"
                    placeholder="Mau ngopi dimana hari ini?"
                    autocomplete="off"
                    aria-label="Cari kafe"
                >

                <button class="search-clear" x-show="query.length > 0" @click="clear()" x-transition.opacity>✕</button>

                <button class="search-btn" @click="if(query.length >= 2) show = true">
                    <svg width="13" height="13" viewBox="0 0 20 20" fill="none">
                        <circle cx="9" cy="9" r="6.5" stroke="currentColor" stroke-width="2"/>
                        <path d="M14 14l4 4" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                    <span>Cari Kafe</span>
                </button>
            </div>

            {{-- Dropdown --}}
            <div class="search-dropdown"
                 x-show="show && query.length >= 2"
                 x-transition:enter="transition ease-out duration-180"
                 x-transition:enter-start="opacity-0 -translate-y-1"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-120"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0">

                {{-- Loading --}}
                <div class="dropdown-loading" x-show="loading">
                    <div class="spinner"></div>
                    <p class="loading-text">Mencari kafe terbaik…</p>
                </div>

                {{-- Tidak ditemukan --}}
                <div class="dropdown-empty" x-show="!loading && results.length === 0">
                    <div class="empty-icon">
                        <svg width="16" height="16" viewBox="0 0 20 20" fill="none">
                            <circle cx="9" cy="9" r="6.5" stroke="currentColor" stroke-width="1.6"/>
                            <path d="M14 14l4 4" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                        </svg>
                    </div>
                    <p>Kafe <strong x-text="`&quot;${query}&quot;`"></strong> tidak ditemukan.<br>Coba kata kunci lain.</p>
                </div>

                {{-- Hasil – link ke route user.cafe.detail → /cafe/{id_kafe} --}}
                <template x-if="!loading && results.length > 0">
                    <div>
                        <div class="dropdown-hdr">
                            <span x-text="`${results.length} kafe ditemukan`"></span>
                        </div>

                        <template x-for="item in results" :key="item.id_kafe">
                            <a :href="`/cafe/${item.id_kafe}`" class="result-item">
                                <div class="result-left">
                                    <div class="result-icon">
                                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none">
                                            <path d="M18 8h1a4 4 0 010 8h-1M2 8h16v9a4 4 0 01-4 4H6a4 4 0 01-4-4V8zM6 1v3M10 1v3M14 1v3"
                                                  stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="result-name" x-text="item.nama_kafe"></p>
                                        <div class="result-meta">
                                            <span x-text="item.jarak ? item.jarak + ' km' : 'Malang'"></span>
                                        </div>
                                    </div>
                                </div>
                                <svg class="result-arrow" width="14" height="14" viewBox="0 0 20 20" fill="none">
                                    <path d="M7 5l5 5-5 5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </a>
                        </template>
                    </div>
                </template>

            </div>{{-- /dropdown --}}

        </div>{{-- /hero-search --}}

    </div>
</section>

{{-- ══════════════════════════════════════════════════ --}}
{{--  PANEL EKSPLORASI                                  --}}
{{-- ══════════════════════════════════════════════════ --}}
<div class="panel-wrap">
    <div class="panel">

        <div class="panel-text">
            <h2>Siap Jelajahi <em>Kafe Terbaik</em> di Malang?</h2>
            <p>Temukan lebih dari satu kafe untuk dinikmati, dilengkapi foto terkini,
               ulasan terlengkap, filter spot hingga kamu guna kafe favorit kamu.</p>
        </div>

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
            <div class="kafe-thumb">
                <img src="https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?w=900&q=80"
                    alt="Cafe" class="kafe-thumb-img">
                <span class="kafe-chip">{{ $kafe->jarak ?? '–' }} km &middot; Malang</span>
            </div>
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
                <a href="{{ route('user.cafe.detail', $kafe->id_kafe) }}" class="btn-detail">Lihat Detail</a>
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
        <h2 class="sec-title">Kapan Waktu <em>Terbaik</em> Ngopi?</h2>
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
                        <th>#</th><th>Nama Kafe</th><th>Alamat</th><th>Rating</th>
                        <th>Harga</th><th>Jam</th><th>Jarak</th><th>Maps</th><th>Detail</th>
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
                            <a href="{{ route('user.cafe.detail', $k->id_kafe) }}" class="btn-sm">Detail &rarr;</a>
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