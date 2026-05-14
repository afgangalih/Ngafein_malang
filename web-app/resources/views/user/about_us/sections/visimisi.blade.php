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
        <p>Kami bermimpi tentang dunia di mana setiap orang bisa menemukan kafe yang benar-benar cocok, sebuah tempat di mana kopi dan cerita yang baik bisa bertemu.</p>
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

@push('styles')
<style>
  #tk-visimisi {
    padding: clamp(5rem, 9vw, 8rem) 0;
    border-top: 1px solid rgba(110, 74, 47, 0.08);
    border-bottom: 1px solid rgba(110, 74, 47, 0.08);
  }

  .vm-header {
    text-align: center;
    margin-bottom: 3rem;
  }

  .vm-header .section-label { justify-content: center; }
  .vm-header .section-label::after {
    content: "";
    width: 34px;
    height: 1px;
    background: currentColor;
    opacity: 0.7;
  }

  .vm-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 1rem;
  }

  .vm-cell {
    background: #fff;
    border: 1px solid rgba(110, 74, 47, 0.08);
    box-shadow: 0 4px 20px -10px rgba(36, 20, 9, 0.08);
    border-radius: var(--radius-lg);
    padding: clamp(2rem, 4vw, 3rem);
    min-height: 330px;
    transition: all 0.35s cubic-bezier(.2,.8,.2,1);
  }

  .vm-cell:hover {
    transform: translateY(-6px);
    border-color: rgba(184, 124, 57, 0.34);
    box-shadow: 0 28px 70px -34px rgba(110, 74, 47, 0.46);
  }

  .vm-cell.dark {
    background: var(--color-brand);
    border: none;
  }

  .vm-tag {
    font-size: 0.68rem;
    font-weight: 700;
    letter-spacing: 0.18em;
    text-transform: uppercase;
    color: var(--color-brand);
    margin-bottom: 1.2rem;
    display: block;
  }

  .vm-cell.dark .vm-tag { color: rgba(255, 231, 198, 0.68); }

  .vm-cell h3 {
    font-family: var(--font-playfair);
    font-size: clamp(1.45rem, 2.4vw, 2.15rem);
    font-weight: 600;
    color: var(--color-brand);
    margin-bottom: 1rem;
    line-height: 1.28;
  }

  .vm-cell.dark h3 { color: #fff; }

  .vm-cell p {
    font-size: 0.95rem;
    color: rgba(58, 39, 25, 0.66);
    line-height: 1.85;
  }

  .vm-cell.dark p { color: rgba(255, 255, 255, 0.78); }

  .misi-items {
    list-style: none;
    display: grid;
    gap: 0.9rem;
    margin-top: 1.2rem;
    padding: 0;
  }

  .misi-items li {
    display: flex;
    gap: 0.85rem;
    font-size: 0.92rem;
    color: rgba(58, 39, 25, 0.66);
    line-height: 1.7;
    align-items: flex-start;
  }

  .mi-dot {
    width: 7px;
    height: 7px;
    min-width: 7px;
    background: var(--color-brand);
    border-radius: 50%;
    margin-top: 0.55rem;
  }

  @media (max-width: 980px) {
    .vm-grid {
      grid-template-columns: 1fr;
    }
  }

  @media (max-width: 640px) {
    .vm-cell {
      min-height: auto;
    }
  }
</style>
@endpush
