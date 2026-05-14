<section id="tk-kenapa">
  <div class="tk-container">
    <span class="section-label r">Kenapa Memilih ngafein.</span>
    <h2 class="section-title r d1">Bukan Sekadar <em>Daftar Kafe Biasa</em></h2>
    <div class="kenapa-layout">
      <div class="r d1">
        <p class="section-body">Di balik tampilan yang sederhana, terdapat sistem penilaian yang serius yang berbasis data, bukan opini atau endorse berbayar.</p>
        <div class="tk-divider"></div>
        <p class="section-body">Kami percaya teknologi seharusnya membuat keputusan sehari-hari lebih mudah dan bermakna, termasuk memilih tempat untuk secangkir kopi.</p>
        <div class="kenapa-big">"Teknologi cerdas untuk pengalaman kopi yang lebih bermakna."</div>
      </div>
      <div class="kenapa-list r d2">
        <div class="kenapa-item">
          <div class="k-icon"><i data-lucide="scale" class="w-5 h-5"></i></div>
          <div><h4>Penilaian Berbasis Data</h4><p>Bukan opini subjektif. Setiap skor dihasilkan dari perhitungan matematis yang bisa dipertanggungjawabkan.</p></div>
        </div>
        <div class="kenapa-item">
          <div class="k-icon"><i data-lucide="refresh-cw" class="w-5 h-5"></i></div>
          <div><h4>Selalu Diperbarui</h4><p>Database kafe diperbarui rutin. Kafe tutup dihapus, kafe baru ditambahkan setelah verifikasi lapangan.</p></div>
        </div>
        <div class="kenapa-item">
          <div class="k-icon"><i data-lucide="map-pin" class="w-5 h-5"></i></div>
          <div><h4>Fokus Lokal Malang</h4><p>Kami mengenal Malang secara mendalam, bukan sekadar agregator nasional yang hanya lihat permukaan.</p></div>
        </div>
        <div class="kenapa-item">
          <div class="k-icon"><i data-lucide="sliders-horizontal" class="w-5 h-5"></i></div>
          <div><h4>Filter Sesuai Situasi</h4><p>Cari kafe untuk kerja, nongkrong, atau kencan? Filter kami menyesuaikan hasil dengan situasimu.</p></div>
        </div>
        <div class="kenapa-item">
          <div class="k-icon"><i data-lucide="microscope" class="w-5 h-5"></i></div>
          <div><h4>Metode Ilmiah, Antarmuka Mudah</h4><p>Algoritma SPK yang serius di balik tampilan yang ramah dan intuitif untuk semua pengguna.</p></div>
        </div>
      </div>
    </div>
  </div>
</section>

@push('styles')
<style>
  #tk-kenapa {
    padding: clamp(5rem, 9vw, 8rem) 0;
  }

  .kenapa-layout {
    display: grid;
    grid-template-columns: minmax(0, 0.82fr) minmax(360px, 1fr);
    gap: clamp(2rem, 6vw, 5rem);
    align-items: start;
    margin-top: 3rem;
  }

  .kenapa-big {
    font-family: var(--font-playfair);
    font-size: clamp(1.45rem, 2.4vw, 2rem);
    font-style: italic;
    color: var(--color-espresso);
    line-height: 1.42;
    margin-top: 2.4rem;
    padding: 1.6rem;
    border-radius: var(--radius-md);
    background: rgba(184, 124, 57, 0.08);
    border: 1px solid rgba(184, 124, 57, 0.16);
  }

  .kenapa-list {
    display: grid;
    gap: 0.9rem;
  }

  .kenapa-item {
    background: #fff;
    border: 1px solid rgba(110, 74, 47, 0.08);
    box-shadow: 0 4px 20px -10px rgba(36, 20, 9, 0.08);
    border-radius: var(--radius-md);
    padding: 1.3rem;
    display: flex;
    gap: 1rem;
    align-items: flex-start;
    transition: all 0.35s cubic-bezier(.2,.8,.2,1);
  }

  .kenapa-item:hover {
    transform: translateY(-6px);
    border-color: rgba(184, 124, 57, 0.34);
    box-shadow: 0 28px 70px -34px rgba(110, 74, 47, 0.46);
  }

  .k-icon {
    width: 46px;
    height: 46px;
    min-width: 46px;
    border: 1px solid rgba(184, 124, 57, 0.2);
    border-radius: 16px;
    background: rgba(184, 124, 57, 0.1);
    color: var(--color-brand-deep);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
    overflow: hidden;
  }

  @media (max-width: 980px) {
    .kenapa-layout {
      grid-template-columns: 1fr;
    }
  }

  @media (max-width: 640px) {
    .kenapa-item {
      padding: 1.15rem;
    }
  }
</style>
@endpush
