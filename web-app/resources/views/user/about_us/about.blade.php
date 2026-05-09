@extends('layouts.user')

@section('title', 'Tentang Kami — ngafein.')
@section('navbar-dark-text', 'true')

@push('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,500;0,600;1,400;1,600&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500&display=swap" rel="stylesheet">
<style>
  :root {
    --white: #ffffff;
    --off-white: #F9F8F6;
    --espresso: #1C0F05;
    --brown: #5C3317;
    --amber: #C8813A;
    --amber-pale: #F5DDB8;
    --text-body: #3D2A1E;
    --text-muted: #8A7566;
    --border: rgba(92,51,23,0.12);
    --border-med: rgba(92,51,23,0.22);
  }

  body {
    font-family: 'DM Sans', sans-serif;
    background: var(--white);
    color: var(--text-body);
    line-height: 1.7;
    overflow-x: hidden;
  }

  /* COMMON */
  .tk-container { max-width: 1080px; margin: 0 auto; padding: 0 2rem; }
  .section-label { display: block; font-size: 0.68rem; font-weight: 500; letter-spacing: 0.2em; text-transform: uppercase; color: var(--amber); margin-bottom: 0.65rem; }
  .section-title { font-family: 'Playfair Display', serif; font-size: clamp(1.9rem, 3.2vw, 2.8rem); font-weight: 600; line-height: 1.15; color: var(--espresso); }
  .section-title em { font-style: italic; font-weight: 400; }
  .section-body { font-size: 0.95rem; color: var(--text-muted); line-height: 1.8; }
  .tk-divider { width: 40px; height: 2px; background: var(--amber); margin: 1.25rem 0; }

  /* REVEAL */
  .r { opacity: 0; transform: translateY(18px); transition: opacity 0.55s ease, transform 0.55s ease; }
  .r.on { opacity: 1; transform: none; }
  .d1 { transition-delay: 0.08s; } .d2 { transition-delay: 0.16s; } .d3 { transition-delay: 0.24s; }

  /* 1. HERO */
  #tk-hero {
    padding: 7rem 2rem 6rem; max-width: 1080px; margin: 0 auto;
    display: grid; grid-template-columns: 1.1fr 1fr; gap: 5rem; align-items: center;
  }
  .hero-eyebrow {
    display: inline-block; font-size: 0.7rem; font-weight: 500; letter-spacing: 0.18em;
    text-transform: uppercase; color: var(--amber);
    border: 1px solid var(--amber-pale); padding: 0.3rem 0.9rem; border-radius: 50px; margin-bottom: 1.25rem;
  }
  .tk-hero-title {
    font-family: 'Playfair Display', serif; font-size: clamp(2.6rem, 4.5vw, 4rem);
    font-weight: 600; line-height: 1.08; color: var(--espresso); margin-bottom: 1.4rem;
  }
  .tk-hero-title em { font-style: italic; color: var(--brown); }
  .tk-hero-desc { font-size: 1rem; color: var(--text-muted); line-height: 1.8; }
  .hero-right { display: flex; flex-direction: column; gap: 1.5rem; }
  .hero-stats {
    display: grid; grid-template-columns: 1fr 1fr; gap: 1px;
    background: var(--border); border: 1px solid var(--border); border-radius: 16px; overflow: hidden;
  }
  .hero-stat { background: var(--white); padding: 1.5rem; }
  .hero-stat-num { font-family: 'Playfair Display', serif; font-size: 2.2rem; font-weight: 600; color: var(--espresso); line-height: 1; }
  .hero-stat-num span { color: var(--amber); }
  .hero-stat-label { font-size: 0.78rem; color: var(--text-muted); margin-top: 0.2rem; }
  .hero-note { font-size: 0.82rem; color: var(--text-muted); line-height: 1.6; border-left: 2px solid var(--amber-pale); padding-left: 1rem; }

  /* 2. LATAR */
  #tk-latar { background: var(--white); padding: 6rem 0; }
  .latar-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 5rem; align-items: start; margin-top: 3rem; }
  .latar-text p { font-size: 0.95rem; color: var(--text-muted); line-height: 1.85; margin-bottom: 1rem; }
  .latar-quote-block { border-left: 3px solid var(--espresso); padding: 1.5rem 1.75rem; margin-bottom: 2rem; }
  .latar-quote { font-family: 'Playfair Display', serif; font-size: 1.25rem; font-style: italic; color: var(--espresso); line-height: 1.5; }
  .latar-quote-attr { font-size: 0.78rem; color: var(--text-muted); margin-top: 0.75rem; }
  .latar-facts { display: flex; flex-direction: column; gap: 0.65rem; }
  .latar-fact { display: flex; align-items: flex-start; gap: 0.75rem; font-size: 0.875rem; color: var(--text-muted); line-height: 1.6; }
  .lf-dot { width: 5px; height: 5px; min-width: 5px; background: var(--amber); border-radius: 50%; margin-top: 0.55rem; }

  /* 3. TUJUAN */
  #tk-tujuan { padding: 6rem 0; }
  .tujuan-grid {
    display: grid; grid-template-columns: repeat(3, 1fr);
    gap: 1px; background: var(--border);
    border: 1px solid var(--border); border-radius: 16px; overflow: hidden; margin-top: 2.5rem;
  }
  .tujuan-item { background: var(--white); padding: 2rem 1.75rem; transition: background 0.2s; }
  .tujuan-item:hover { background: var(--off-white); }
  .t-num { font-family: 'Playfair Display', serif; font-size: 1rem; color: var(--amber); margin-bottom: 0.7rem; }
  .tujuan-item h3 { font-size: 0.93rem; font-weight: 500; color: var(--espresso); margin-bottom: 0.45rem; }
  .tujuan-item p { font-size: 0.82rem; color: var(--text-muted); line-height: 1.7; }

  /* 4. KRITERIA */
  #tk-kriteria { background: var(--white); padding: 6rem 0; }
  .kriteria-header { display: grid; grid-template-columns: 1fr 1fr; gap: 4rem; margin-bottom: 3rem; align-items: end; }
  .kriteria-grid {
    display: grid; grid-template-columns: 1fr 1fr;
    gap: 1px; background: var(--border);
    border: 1px solid var(--border); border-radius: 16px; overflow: hidden;
  }
  .k-cell { background: var(--white); padding: 1.5rem 1.75rem; display: flex; gap: 1.25rem; align-items: flex-start; transition: background 0.2s; }
  .k-cell:hover { background: #fdfaf7; }
  .k-num { font-family: 'Playfair Display', serif; font-size: 1.35rem; font-weight: 600; color: var(--amber); line-height: 1; min-width: 1.8rem; }
  .k-body h4 { font-size: 0.88rem; font-weight: 500; color: var(--espresso); margin-bottom: 0.25rem; }
  .k-body p { font-size: 0.78rem; color: var(--text-muted); line-height: 1.55; }
  .k-tag { display: inline-block; font-size: 0.62rem; font-weight: 500; letter-spacing: 0.06em; text-transform: uppercase; padding: 0.15rem 0.5rem; border-radius: 50px; background: var(--amber-pale); color: var(--brown); margin-top: 0.4rem; }

  /* 5. ALUR */
  #tk-alur { padding: 6rem 0; }
  .alur-header { text-align: center; margin-bottom: 4rem; }
  .alur-header .section-body { margin: 0.75rem auto 0; max-width: 480px; }
  .alur-row { display: grid; grid-template-columns: repeat(5,1fr); gap: 0; position: relative; }
  .alur-row::before { content: ''; position: absolute; top: 27px; left: 10%; right: 10%; height: 1px; background: var(--border-med); }
  .alur-step { display: flex; flex-direction: column; align-items: center; text-align: center; padding: 0 0.75rem; }
  .alur-circle {
    width: 54px; height: 54px; border-radius: 50%;
    border: 1.5px solid var(--border-med); background: var(--white);
    display: flex; align-items: center; justify-content: center;
    font-family: 'Playfair Display', serif; font-size: 1rem; font-weight: 600; color: var(--espresso);
    margin-bottom: 1rem; position: relative; z-index: 1;
  }
  .alur-step.active .alur-circle { background: var(--espresso); color: var(--amber-pale); border-color: var(--espresso); }
  .alur-step h4 { font-size: 0.82rem; font-weight: 500; color: var(--espresso); margin-bottom: 0.3rem; }
  .alur-step p { font-size: 0.75rem; color: var(--text-muted); line-height: 1.6; }

  /* 6. KENAPA */
  #tk-kenapa { background: var(--white); padding: 6rem 0; }
  .kenapa-layout { display: grid; grid-template-columns: 1fr 1fr; gap: 5rem; align-items: start; margin-top: 3rem; }
  .kenapa-big { font-family: 'Playfair Display', serif; font-size: 1.45rem; font-style: italic; color: var(--espresso); line-height: 1.4; margin-top: 2.5rem; padding-top: 2rem; border-top: 1px solid var(--border); }
  .kenapa-list { display: flex; flex-direction: column; gap: 1.5rem; }
  .kenapa-item { display: flex; gap: 1.25rem; align-items: flex-start; }
  .k-icon { width: 36px; height: 36px; min-width: 36px; border: 1px solid var(--border-med); border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 1rem; }
  .kenapa-item h4 { font-size: 0.9rem; font-weight: 500; color: var(--espresso); margin-bottom: 0.25rem; }
  .kenapa-item p { font-size: 0.82rem; color: var(--text-muted); line-height: 1.65; }

  /* 8. VISI MISI */
  #tk-visimisi { background: var(--white); padding: 6rem 0; }
  .vm-header { text-align: center; margin-bottom: 3rem; }
  .vm-grid {
    display: grid; grid-template-columns: 1fr 1fr;
    gap: 1px; background: var(--border);
    border: 1px solid var(--border); border-radius: 16px; overflow: hidden;
  }
  .vm-cell { background: var(--white); padding: 2.5rem; }
  .vm-cell.dark { background: var(--espresso); }
  .vm-tag { font-size: 0.65rem; font-weight: 500; letter-spacing: 0.18em; text-transform: uppercase; color: var(--amber); margin-bottom: 1rem; display: block; }
  .vm-cell.dark .vm-tag { color: rgba(245,221,184,0.6); }
  .vm-cell h3 { font-family: 'Playfair Display', serif; font-size: 1.35rem; font-weight: 600; color: var(--espresso); margin-bottom: 1rem; line-height: 1.3; }
  .vm-cell.dark h3 { color: #fff; }
  .vm-cell p { font-size: 0.875rem; color: var(--text-muted); line-height: 1.8; }
  .vm-cell.dark p { color: rgba(255, 255, 255, 0.78); }
  .misi-items { list-style: none; display: flex; flex-direction: column; gap: 0.75rem; margin-top: 1rem; }
  .misi-items li { display: flex; gap: 0.75rem; font-size: 0.85rem; color: var(--brown); line-height: 1.6; align-items: flex-start; }
  .mi-dot { width: 5px; height: 5px; min-width: 5px; background: var(--amber); border-radius: 50%; margin-top: 0.55rem; }

  /* 9. CTA */
  #tk-cta { padding: 6rem 0; text-align: center; }
  .cta-inner { max-width: 560px; margin: 0 auto; padding: 0 2rem; }
  .cta-title { font-family: 'Playfair Display', serif; font-size: clamp(2rem, 3.5vw, 3rem); font-weight: 600; color: var(--espresso); line-height: 1.15; margin-bottom: 1rem; }
  .cta-title em { font-style: italic; }
  .cta-desc { font-size: 0.95rem; color: var(--text-muted); line-height: 1.8; margin-bottom: 2.25rem; }
  .cta-btns { display: flex; gap: 0.75rem; justify-content: center; flex-wrap: wrap; }
  .tk-btn-primary { display: inline-block; background: var(--espresso); color: #fff; font-size: 0.875rem; font-weight: 500; padding: 0.8rem 1.75rem; border-radius: 50px; text-decoration: none; transition: opacity 0.2s; }
  .tk-btn-primary:hover { opacity: 0.82; color: #fff; }
  .tk-btn-outline { display: inline-block; background: transparent; color: var(--espresso); font-size: 0.875rem; padding: 0.8rem 1.75rem; border-radius: 50px; border: 1px solid var(--border-med); text-decoration: none; transition: border-color 0.2s; }
  .tk-btn-outline:hover { border-color: var(--espresso); color: var(--espresso); }
</style>
@endpush

@section('content')

{{-- 1. HERO --}}
<section>
  <div id="tk-hero">
    <div>
      <span class="hero-eyebrow r">Tentang Kami</span>
      <h1 class="tk-hero-title r d1">Sistem Rekomendasi<br>Kafe <em>Terbaik</em><br>di Malang</h1>
      <p class="tk-hero-desc r d2">ngafein. hadir untuk membantu kamu menemukan tempat ngopi yang benar-benar sesuai — bukan sekadar yang paling viral, tapi yang paling tepat untukmu.</p>
    </div>
    <div class="hero-right r d2">
      <div class="hero-stats">
        <div class="hero-stat">
          <div class="hero-stat-num">110<span>+</span></div>
          <div class="hero-stat-label">Kafe di Malang Raya</div>
        </div>
        <div class="hero-stat">
          <div class="hero-stat-num">6</div>
          <div class="hero-stat-label">Kriteria penilaian</div>
        </div>
        <div class="hero-stat">
          <div class="hero-stat-num">SAW</div>
          <div class="hero-stat-label">Metode perangkingan</div>
        </div>
        <div class="hero-stat">
          <div class="hero-stat-num">4.6<span>★</span></div>
          <div class="hero-stat-label">Rating rata-rata</div>
        </div>
      </div>
      <p class="hero-note r d3">Dibangun sebagai proyek riset Sistem Pendukung Keputusan (SPK) — terbuka, transparan, dan terus berkembang.</p>
    </div>
  </div>
</section>

{{-- 2. LATAR BELAKANG --}}
<section id="tk-latar">
  <div class="tk-container">
    <span class="section-label r">Latar Belakang</span>
    <h2 class="section-title r d1">Mengapa Malang <em>Butuh</em><br>Sistem Seperti Ini?</h2>
    <div class="latar-grid">
      <div class="latar-text r d1">
        <p>Malang adalah salah satu kota dengan pertumbuhan kafe paling pesat di Jawa Timur. Dalam beberapa tahun terakhir, ratusan kafe baru bermunculan — dari kedai kopi minimalis di gang sempit hingga coffee shop mewah di pusat kota.</p>
        <p>Masalahnya, memilih kafe yang tepat jadi semakin sulit. Rekomendasi di media sosial seringkali bias popularitas — yang paling viral belum tentu yang paling nyaman buat kamu.</p>
        <p>ngafein. lahir dari keresahan itu. Kami membangun sistem yang menilai kafe secara objektif berdasarkan data nyata, bukan sekadar jumlah followers atau besarnya anggaran promosi.</p>
      </div>
      <div class="r d2">
        <div class="latar-quote-block">
          <div class="latar-quote">"Kopi yang baik bukan soal tempat yang paling terkenal, tapi soal momen yang paling tepat."</div>
          <div class="latar-quote-attr">— Filosofi di balik ngafein.</div>
        </div>
        <div class="latar-facts">
          <div class="latar-fact"><div class="lf-dot"></div>Lebih dari 110 kafe aktif di area Kota Malang</div>
          <div class="latar-fact"><div class="lf-dot"></div>Mayoritas pengguna merasa kesulitan memilih kafe sesuai kebutuhan spesifik mereka</div>
          <div class="latar-fact"><div class="lf-dot"></div>Rekomendasi berbasis popularitas tidak selalu relevan secara personal</div>
        </div>
      </div>
    </div>
  </div>
</section>

{{-- 3. TUJUAN --}}
<section id="tk-tujuan">
  <div class="tk-container">
    <span class="section-label r">Tujuan Website</span>
    <h2 class="section-title r d1">Apa yang Ingin <em>Kami Capai?</em></h2>
    <div class="tujuan-grid r d2">
      <div class="tujuan-item">
        <div class="t-num">01</div>
        <h3>Rekomendasi Objektif</h3>
        <p>Penilaian berbasis multi-kriteria yang terukur, bebas dari bias popularitas atau endorsement berbayar.</p>
      </div>
      <div class="tujuan-item">
        <div class="t-num">02</div>
        <h3>Pengalaman Personal</h3>
        <p>Membantu setiap pengguna menemukan kafe sesuai preferensi dan situasi unik mereka.</p>
      </div>
      <div class="tujuan-item">
        <div class="t-num">03</div>
        <h3>Data Terpercaya</h3>
        <p>Mengumpulkan dan memperbarui data kafe secara berkala agar rekomendasi selalu relevan.</p>
      </div>
      <div class="tujuan-item">
        <div class="t-num">04</div>
        <h3>Peta Kafe Malang</h3>
        <p>Menjadi referensi lengkap ekosistem kafe di Kota Malang, dari pusat kota hingga kafe tersembunyi.</p>
      </div>
      <div class="tujuan-item">
        <div class="t-num">05</div>
        <h3>Dukung UMKM Lokal</h3>
        <p>Memberi visibilitas adil kepada kafe lokal berdasarkan kualitas, bukan besarnya anggaran promosi.</p>
      </div>
      <div class="tujuan-item">
        <div class="t-num">06</div>
        <h3>Inovasi Riset SPK</h3>
        <p>Menerapkan metode pengambilan keputusan ilmiah dalam konteks kehidupan sehari-hari.</p>
      </div>
    </div>
  </div>
</section>

{{-- 4. KRITERIA PENILAIAN --}}
<section id="tk-kriteria">
  <div class="tk-container">
    <div class="kriteria-header">
      <div>
        <span class="section-label r">Kriteria Penilaian</span>
        <h2 class="section-title r d1">Kami Menilai<br>dari <em>6 Sisi</em></h2>
      </div>

      <p class="section-body r d2">
        Enam kriteria ini digunakan dalam sistem rekomendasi untuk menentukan kafe terbaik sesuai preferensi pengguna.
      </p>
    </div>

    <div class="kriteria-grid r d2">

      <div class="k-cell">
        <div class="k-num">01</div>
        <div class="k-body">
          <h4>Harga</h4>
          <p>Kesesuaian harga menu dengan budget dan value yang didapat pengguna.</p>
          <span class="k-tag">Cost</span>
        </div>
      </div>

      <div class="k-cell">
        <div class="k-num">02</div>
        <div class="k-body">
          <h4>Jarak</h4>
          <p>Kemudahan akses lokasi kafe dari posisi pengguna.</p>
          <span class="k-tag">Cost</span>
        </div>
      </div>

      <div class="k-cell">
        <div class="k-num">03</div>
        <div class="k-body">
          <h4>Rating</h4>
          <p>Penilaian dan ulasan pengguna terhadap kualitas keseluruhan kafe.</p>
          <span class="k-tag">Benefit</span>
        </div>
      </div>

      <div class="k-cell">
        <div class="k-num">04</div>
        <div class="k-body">
          <h4>Variasi Menu</h4>
          <p>Keberagaman pilihan makanan dan minuman yang tersedia.</p>
          <span class="k-tag">Benefit</span>
        </div>
      </div>

      <div class="k-cell">
        <div class="k-num">05</div>
        <div class="k-body">
          <h4>Fasilitas</h4>
          <p>Kelengkapan fasilitas seperti Wi-Fi, stop kontak, parkir, dan area duduk.</p>
          <span class="k-tag">Benefit</span>
        </div>
      </div>

      <div class="k-cell">
        <div class="k-num">06</div>
        <div class="k-body">
          <h4>Jam Operasional</h4>
          <p>Fleksibilitas jam buka kafe untuk berbagai kebutuhan pengguna.</p>
          <span class="k-tag">Benefit</span>
        </div>
      </div>

    </div>
  </div>
</section>

{{-- 5. ALUR PERANGKINGAN --}}
<section id="tk-alur">
  <div class="tk-container">
    <div class="alur-header">
      <span class="section-label r">Alur Sistem</span>

      <h2 class="section-title r d1">
        Bagaimana Sistem Kami <em>Bekerja?</em>
      </h2>

      <p class="section-body r d2">
        Proses rekomendasi dilakukan secara bertahap agar hasil yang diberikan lebih relevan dan mudah dipahami pengguna.
      </p>
    </div>

    <div class="alur-row r d2">

      <div class="alur-step">
        <div class="alur-circle">1</div>
        <h4>Kumpulkan Data</h4>
        <p>Mengambil data kafe dan informasi penting lainnya</p>
      </div>

      <div class="alur-step">
        <div class="alur-circle">2</div>
        <h4>Tentukan Kriteria</h4>
        <p>Menentukan aspek penilaian seperti harga, rating, dan lainnya</p>
      </div>

      <div class="alur-step active">
        <div class="alur-circle">3</div>
        <h4>Proses Penilaian</h4>
        <p>Setiap kafe dinilai berdasarkan kriteria yang digunakan</p>
      </div>

      <div class="alur-step">
        <div class="alur-circle">4</div>
        <h4>Hitung Hasil</h4>
        <p>Sistem menghitung nilai akhir untuk tiap kafe</p>
      </div>

      <div class="alur-step">
        <div class="alur-circle">5</div>
        <h4>Tampilkan Rekomendasi</h4>
        <p>Kafe terbaik ditampilkan sesuai hasil perhitungan</p>
      </div>

    </div>
  </div>
</section>

{{-- 6. KENAPA NGAFEIN --}}
<section id="tk-kenapa">
  <div class="tk-container">
    <span class="section-label r">Kenapa Memilih ngafein.</span>
    <h2 class="section-title r d1">Bukan Sekadar <em>Daftar Kafe Biasa</em></h2>
    <div class="kenapa-layout">
      <div class="r d1">
        <p class="section-body">Di balik tampilan yang sederhana, terdapat sistem penilaian yang serius — berbasis data, bukan opini atau endorse berbayar.</p>
        <div class="tk-divider"></div>
        <p class="section-body">Kami percaya teknologi seharusnya membuat keputusan sehari-hari lebih mudah dan bermakna — termasuk memilih tempat untuk secangkir kopi.</p>
        <div class="kenapa-big">"Teknologi cerdas untuk pengalaman kopi yang lebih bermakna."</div>
      </div>
      <div class="kenapa-list r d2">
        <div class="kenapa-item">
          <div class="k-icon">⚖️</div>
          <div><h4>Penilaian Berbasis Data</h4><p>Bukan opini subjektif. Setiap skor dihasilkan dari perhitungan matematis yang bisa dipertanggungjawabkan.</p></div>
        </div>
        <div class="kenapa-item">
          <div class="k-icon">🔄</div>
          <div><h4>Selalu Diperbarui</h4><p>Database kafe diperbarui rutin. Kafe tutup dihapus, kafe baru ditambahkan setelah verifikasi lapangan.</p></div>
        </div>
        <div class="kenapa-item">
          <div class="k-icon">🏠</div>
          <div><h4>Fokus Lokal Malang</h4><p>Kami mengenal Malang secara mendalam — bukan sekadar agregator nasional yang hanya lihat permukaan.</p></div>
        </div>
        <div class="kenapa-item">
          <div class="k-icon">🎛️</div>
          <div><h4>Filter Sesuai Situasi</h4><p>Cari kafe untuk kerja, nongkrong, atau kencan? Filter kami menyesuaikan hasil dengan situasimu.</p></div>
        </div>
        <div class="kenapa-item">
          <div class="k-icon">🔬</div>
          <div><h4>Metode Ilmiah, Antarmuka Mudah</h4><p>Algoritma SPK yang serius di balik tampilan yang ramah dan intuitif untuk semua pengguna.</p></div>
        </div>
      </div>
    </div>
  </div>
</section>

{{-- 8. VISI & MISI --}}
<section id="tk-visimisi">
  <div class="tk-container">
    <div class="vm-header">
      <span class="section-label r">Visi & Misi</span>
      <h2 class="section-title r d1">Arah yang Kami <em>Tuju</em></h2>
    </div>
    <div class="vm-grid r d2">
      <div class="vm-cell dark">
        <span class="vm-tag">Visi</span>
        <h3>Menjadi platform rekomendasi kafe paling terpercaya di Malang</h3>
        <p>Kami bermimpi tentang dunia di mana setiap orang bisa menemukan kafe yang benar-benar cocok — tempat di mana kopi dan cerita yang baik bisa bertemu.</p>
      </div>
      <div class="vm-cell">
        <span class="vm-tag">Misi</span>
        <h3>Langkah nyata menuju tujuan kami</h3>
        <ul class="misi-items">
          <li><div class="mi-dot"></div>Mengembangkan sistem SPK berbasis SAW yang akurat dan transparan</li>
          <li><div class="mi-dot"></div>Memperbarui data kafe secara berkala dan bertanggung jawab</li>
          <li><div class="mi-dot"></div>Mendengarkan kebutuhan pengguna dan terus meningkatkan fitur</li>
          <li><div class="mi-dot"></div>Mendukung pertumbuhan kafe lokal Malang secara berkelanjutan</li>
          <li><div class="mi-dot"></div>Mengedepankan transparansi dalam setiap aspek penilaian</li>
        </ul>
      </div>
    </div>
  </div>
</section>

{{-- 9. CTA --}}
<section id="tk-cta">
  <div class="cta-inner">
    <h2 class="cta-title r">Siap Menemukan Kafe <em>Favoritmu?</em></h2>
    <p class="cta-desc r d1">Biarkan ngafein. membantu kamu menemukan tempat ngopi yang paling pas — berdasarkan data, bukan hype.</p>
    <div class="cta-btns r d2">
      <a href="{{ route('user.kafe.rekomendasi') }}" class="tk-btn-primary">Cari Kafe Sekarang</a>
      <a href="{{ route('user.explore.index') }}" class="tk-btn-outline">Lihat Semua Kafe →</a>
    </div>
  </div>
</section>

@endsection

@push('scripts')
<script>
  const els = document.querySelectorAll('.r');
  const obs = new IntersectionObserver(entries => {
    entries.forEach(e => { if (e.isIntersecting) e.target.classList.add('on'); });
  }, { threshold: 0.08, rootMargin: '0px 0px -30px 0px' });
  els.forEach(el => obs.observe(el));
</script>
@endpush