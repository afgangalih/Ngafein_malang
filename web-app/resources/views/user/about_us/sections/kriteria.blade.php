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
      @php
        $kriterias = [
          ['num' => '01', 'title' => 'Harga', 'desc' => 'Kesesuaian harga menu dengan budget dan value yang didapat pengguna.', 'tag' => 'Cost'],
          ['num' => '02', 'title' => 'Jarak', 'desc' => 'Kemudahan akses lokasi kafe dari posisi pengguna.', 'tag' => 'Cost'],
          ['num' => '03', 'title' => 'Rating', 'desc' => 'Penilaian dan ulasan pengguna terhadap kualitas keseluruhan kafe.', 'tag' => 'Benefit'],
          ['num' => '04', 'title' => 'Variasi Menu', 'desc' => 'Keberagaman pilihan makanan dan minuman yang tersedia.', 'tag' => 'Benefit'],
          ['num' => '05', 'title' => 'Fasilitas', 'desc' => 'Kelengkapan fasilitas seperti Wi-Fi, stop kontak, parkir, dan area duduk.', 'tag' => 'Benefit'],
          ['num' => '06', 'title' => 'Jam Operasional', 'desc' => 'Fleksibilitas jam buka kafe untuk berbagai kebutuhan pengguna.', 'tag' => 'Benefit'],
        ];
      @endphp

      @foreach($kriterias as $k)
      <div class="k-cell">
        <div class="k-num">{{ $k['num'] }}</div>
        <div class="k-body">
          <h4>{{ $k['title'] }}</h4>
          <p>{{ $k['desc'] }}</p>
          <span class="k-tag">{{ $k['tag'] }}</span>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</section>

@push('styles')
<style>
  #tk-kriteria {
    padding: clamp(5rem, 9vw, 8rem) 0;
    border-top: 1px solid rgba(16, 24, 40, 0.08);
    border-bottom: 1px solid rgba(16, 24, 40, 0.08);
  }

  .kriteria-header {
    display: grid;
    grid-template-columns: minmax(0, 1fr) minmax(280px, 0.74fr);
    gap: clamp(2rem, 6vw, 5rem);
    margin-bottom: 3rem;
    align-items: end;
  }

  .kriteria-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 1rem;
  }

  .k-cell {
    background: #fff;
    border: 1px solid rgba(16, 24, 40, 0.08);
    box-shadow: 0 4px 20px -10px rgba(16, 24, 40, 0.08);
    border-radius: var(--radius-md);
    padding: 1.55rem;
    display: flex;
    gap: 1.2rem;
    align-items: flex-start;
    transition: all 0.35s cubic-bezier(.2,.8,.2,1);
  }

  .k-cell:hover {
    transform: translateY(-6px);
    border-color: rgba(16, 24, 40, 0.2);
    box-shadow: 0 28px 70px -34px rgba(16, 24, 40, 0.2);
  }

  .k-num {
    display: grid;
    place-items: center;
    width: 46px;
    height: 46px;
    min-width: 46px;
    border-radius: 16px;
    background: rgba(16, 24, 40, 0.07);
    color: #101828;
    font-family: var(--font-plus-jakarta);
    font-size: 1rem;
    font-weight: 700;
    line-height: 1;
  }

  .k-body h4 {
    font-size: 1rem;
    font-weight: 700;
    color: #101828;
    margin-bottom: 0.55rem;
    font-family: var(--font-plus-jakarta);
  }

  .k-body p {
    font-size: 0.9rem;
    color: rgba(16, 24, 40, 0.66);
    line-height: 1.75;
    font-family: var(--font-plus-jakarta);
  }

  .k-tag {
    display: inline-flex;
    align-items: center;
    margin-top: 0.85rem;
    padding: 0.32rem 0.7rem;
    border-radius: 999px;
    background: rgba(184, 124, 57, 0.11);
    color: #B87C39;
    border: 1px solid rgba(184, 124, 57, 0.3);
    font-size: 0.66rem;
    font-weight: 700;
    letter-spacing: 0.09em;
    text-transform: uppercase;
    font-family: var(--font-plus-jakarta);
  }

  @media (max-width: 980px) {
    .kriteria-header { grid-template-columns: 1fr; }
  }

  @media (max-width: 640px) {
    .kriteria-grid { grid-template-columns: 1fr; }
    .k-cell { padding: 1.15rem; gap: 0.95rem; }
  }
</style>
@endpush