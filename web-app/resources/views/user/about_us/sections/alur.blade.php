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

@push('styles')
<style>
  #tk-alur {
    padding: clamp(5rem, 9vw, 8rem) 0;
  }

  .alur-header {
    text-align: center;
    margin-bottom: 3.5rem;
  }

  .alur-header .section-label { justify-content: center; }
  .alur-header .section-label::after {
    content: "";
    width: 34px;
    height: 1px;
    background: currentColor;
    opacity: 0.7;
  }

  .alur-header .section-body {
    margin: 1rem auto 0;
    max-width: 560px;
  }

  .alur-row {
    display: grid;
    grid-template-columns: repeat(5, minmax(0, 1fr));
    gap: 1rem;
    position: relative;
  }

  .alur-row::before {
    content: "";
    position: absolute;
    top: 33px;
    left: 8%;
    right: 8%;
    height: 1px;
    background: #101828;
    opacity: 0.15;
  }

  .alur-step {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    padding: 0 0.4rem;
    position: relative;
  }

  .alur-circle {
    width: 66px;
    height: 66px;
    border-radius: 22px;
    border: 1px solid rgba(16, 24, 40, 0.22);
    background: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-family: var(--font-plus-jakarta);
    font-size: 1.2rem;
    font-weight: 700;
    color: #101828;
    margin-bottom: 1.15rem;
    position: relative;
    z-index: 1;
    transition: transform 0.35s cubic-bezier(.2,.8,.2,1), background 0.35s cubic-bezier(.2,.8,.2,1);
  }

  .alur-step:hover .alur-circle {
    transform: translateY(-5px);
    background: rgba(16, 24, 40, 0.05);
  }

  .alur-step.active .alur-circle {
    background: #B87C39;
    color: #fff;
    border-color: #B87C39;
  }

  .alur-step h4 {
    font-size: 0.9rem;
    font-weight: 700;
    color: #101828;
    margin-bottom: 0.45rem;
    font-family: var(--font-plus-jakarta);
  }

  .alur-step p {
    font-size: 0.8rem;
    color: rgba(16, 24, 40, 0.66);
    line-height: 1.65;
    font-family: var(--font-plus-jakarta);
  }

  @media (max-width: 980px) {
    .alur-row {
      grid-template-columns: 1fr;
      gap: 1rem;
    }
    .alur-row::before { display: none; }
    .alur-step {
      display: grid;
      grid-template-columns: 66px 1fr;
      column-gap: 1rem;
      text-align: left;
      align-items: start;
      background: rgba(255,255,255,0.84);
      border: 1px solid rgba(16, 24, 40, 0.13);
      border-radius: var(--radius-md);
      padding: 1rem;
    }
    .alur-circle { margin-bottom: 0; }
  }
</style>
@endpush