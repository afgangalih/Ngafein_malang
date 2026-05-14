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

@push('styles')
<style>
  #tk-tujuan {
    padding: clamp(5rem, 9vw, 8rem) 0;
  }

  .tujuan-grid {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 1rem;
    margin-top: 2.75rem;
  }

  .tujuan-item {
    background: #fff;
    border: 1px solid rgba(110, 74, 47, 0.08);
    box-shadow: 0 4px 20px -10px rgba(36, 20, 9, 0.08);
    transition: all 0.35s cubic-bezier(.2,.8,.2,1);
    min-height: 245px;
    border-radius: var(--radius-md);
    padding: 2rem;
    position: relative;
    overflow: hidden;
  }

  .tujuan-item::after {
    content: "";
    position: absolute;
    left: 2rem;
    right: 2rem;
    bottom: 0;
    height: 3px;
    background: var(--color-brand);
    opacity: 0;
    transition: opacity 0.35s cubic-bezier(.2,.8,.2,1);
  }

  .tujuan-item:hover {
    transform: translateY(-6px);
    border-color: rgba(184, 124, 57, 0.34);
    box-shadow: 0 28px 70px -34px rgba(110, 74, 47, 0.46);
  }

  .tujuan-item:hover::after { opacity: 1; }

  .t-num {
    font-family: var(--font-playfair);
    font-size: 1.35rem;
    color: var(--color-brand);
    margin-bottom: 1.15rem;
  }

  .tujuan-item h3 {
    font-size: 1rem;
    font-weight: 700;
    color: var(--color-espresso);
    margin-bottom: 0.55rem;
  }

  .tujuan-item p {
    font-size: 0.9rem;
    color: rgba(58, 39, 25, 0.66);
    line-height: 1.75;
  }

  @media (max-width: 980px) {
    .tujuan-grid {
      grid-template-columns: repeat(2, minmax(0, 1fr));
    }
  }

  @media (max-width: 640px) {
    .tujuan-grid {
      grid-template-columns: 1fr;
    }
    .tujuan-item {
      min-height: auto;
      padding: 1.55rem;
    }
  }
</style>
@endpush
