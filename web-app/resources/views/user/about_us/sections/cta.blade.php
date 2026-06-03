<section id="tk-cta">
  <div class="tk-container">
    <div class="cta-block r">
      <span class="cta-label">Mulai Sekarang</span>
      <h2 class="cta-title">Siap Menemukan Kafe <em>Favoritmu?</em></h2>
      <div class="cta-btns">
        <a href="{{ route('user.kafe.rekomendasi') }}" class="cta-btn-primary">Cari Kafe Sekarang</a>
        <a href="{{ route('user.explore.index') }}" class="cta-btn-ghost">Jelajahi Semua Kafe</a>
      </div>
    </div>
  </div>
</section>

@push('styles')
<style>
  #tk-cta {
    padding: clamp(5rem, 9vw, 8rem) 0;
  }

  .cta-block {
    background: #2B1A09;
    border-radius: 32px;
    padding: clamp(4rem, 8vw, 6rem) clamp(2rem, 6vw, 4rem);
    text-align: center;
    max-width: 860px;
    margin: 0 auto;
  }

  .cta-label {
    display: inline-block;
    font-size: 0.65rem;
    font-weight: 700;
    letter-spacing: 0.22em;
    text-transform: uppercase;
    color: #B87C39;
    margin-bottom: 1.1rem;
    font-family: var(--font-plus-jakarta);
  }

  .cta-title {
    font-family: var(--font-plus-jakarta);
    font-size: clamp(2.2rem, 5vw, 3.5rem);
    font-weight: 700;
    color: #fff;
    line-height: 1.05;
    margin-bottom: 2.5rem;
    letter-spacing: -0.02em;
  }

  .cta-title em {
    color: #B87C39;
    font-style: normal;
    font-weight: 800;
  }

  .cta-btns {
    display: flex;
    gap: 0.75rem;
    justify-content: center;
    flex-wrap: wrap;
  }

  .cta-btn-primary,
  .cta-btn-ghost {
    display: inline-flex;
    align-items: center;
    padding: 1rem 2.2rem;
    border-radius: 999px;
    font-size: 0.95rem;
    font-weight: 700;
    text-decoration: none;
    transition: all 0.24s cubic-bezier(.2,.8,.2,1);
    font-family: var(--font-plus-jakarta);
  }

  .cta-btn-primary {
    background: #B87C39;
    color: #fff;
  }

  .cta-btn-primary:hover {
    background: #fff;
    color: #101828;
  }

  .cta-btn-ghost {
    color: rgba(255, 255, 255, 0.55);
    border: 1px solid rgba(255, 255, 255, 0.12);
  }

  .cta-btn-ghost:hover {
    color: #fff;
    border-color: rgba(255, 255, 255, 0.3);
  }

  @media (max-width: 480px) {
    .cta-block { padding: 2.5rem 1.75rem; }
    .cta-btns { flex-direction: column; }
    .cta-btn-primary,
    .cta-btn-ghost { justify-content: center; }
  }
</style>
@endpush