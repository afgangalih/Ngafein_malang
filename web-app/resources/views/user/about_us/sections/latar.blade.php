<section id="tk-latar">
  <div class="tk-container">
    <span class="section-label r">Latar Belakang</span>
    <h2 class="section-title r d1">Mengapa Malang <em>Butuh</em><br>Sistem Seperti Ini?</h2>
    <div class="latar-grid">
      <div class="latar-text r d1">
        <p>Malang adalah salah satu kota dengan pertumbuhan kafe paling pesat di Jawa Timur. Dalam beberapa tahun terakhir, ratusan kafe baru bermunculan, mulai dari kedai kopi minimalis di gang sempit hingga coffee shop mewah di pusat kota.</p>
        <p>Masalahnya, memilih kafe yang tepat jadi semakin sulit. Rekomendasi di media sosial seringkali bias popularitas, di mana yang paling viral belum tentu yang paling nyaman buat kamu.</p>
        <p>ngafein. lahir dari keresahan itu. Kami membangun sistem yang menilai kafe secara objektif berdasarkan data nyata, bukan sekadar jumlah followers atau besarnya anggaran promosi.</p>
      </div>
      <div class="r d2">
        <div class="latar-quote-block">
          <div class="latar-quote">"Kopi yang baik bukan soal tempat yang paling terkenal, tapi soal momen yang paling tepat."</div>
          <div class="latar-quote-attr">Filosofi di balik ngafein.</div>
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

@push('styles')
<style>
  #tk-latar {
    padding: clamp(5rem, 9vw, 8rem) 0;
    border-top: 1px solid rgba(16, 24, 40, 0.08);
    border-bottom: 1px solid rgba(16, 24, 40, 0.08);
  }

  .latar-grid {
    display: grid;
    grid-template-columns: minmax(0, 1.08fr) minmax(320px, 0.92fr);
    gap: clamp(2rem, 5vw, 5.5rem);
    align-items: start;
    margin-top: 3rem;
  }

  .latar-text {
    display: grid;
    gap: 1rem;
  }

  .latar-text p {
    font-size: 1rem;
    color: rgba(16, 24, 40, 0.66);
    line-height: 1.9;
    margin: 0;
    font-family: var(--font-plus-jakarta);
  }

  .latar-quote-block {
    position: relative;
    background: #fff;
    border: 1px solid rgba(16, 24, 40, 0.13);
    border-radius: var(--radius-lg);
    padding: clamp(1.75rem, 4vw, 2.5rem);
    margin-bottom: 1.2rem;
    box-shadow: 0 22px 55px -32px rgba(16, 24, 40, 0.34);
  }

  .latar-quote-block::before {
    content: "";
    position: absolute;
    inset: 0 auto 0 0;
    width: 5px;
    border-radius: 999px;
    background: #B87C39;
  }

  .latar-quote {
    font-family: var(--font-plus-jakarta);
    font-size: clamp(1.2rem, 2.2vw, 1.6rem);
    font-weight: 600;
    font-style: normal;
    color: #101828;
    line-height: 1.5;
  }

  .latar-quote-attr {
    font-size: 0.78rem;
    color: #101828;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    margin-top: 1rem;
    font-family: var(--font-plus-jakarta);
    font-weight: 600;
  }

  .latar-facts {
    display: grid;
    gap: 0.8rem;
  }

  .latar-fact {
    display: flex;
    align-items: flex-start;
    gap: 0.85rem;
    background: rgba(255, 255, 255, 0.72);
    border: 1px solid rgba(16, 24, 40, 0.13);
    border-radius: 18px;
    padding: 1rem 1.1rem;
    font-size: 0.9rem;
    color: rgba(16, 24, 40, 0.66);
    line-height: 1.65;
    font-family: var(--font-plus-jakarta);
  }

  .lf-dot {
    width: 7px;
    height: 7px;
    min-width: 7px;
    background: #B87C39;
    border-radius: 50%;
    margin-top: 0.55rem;
  }

  @media (max-width: 980px) {
    .latar-grid { grid-template-columns: 1fr; }
  }
</style>
@endpush