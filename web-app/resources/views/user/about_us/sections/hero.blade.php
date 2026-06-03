<section id="tk-hero-section">
  <div class="hero-inner">
    <div class="hero-left">
      <div class="hero-eyebrow r">
        <span class="eyebrow-dot"></span>
        Tentang Kami
      </div>

      <h1 class="tk-hero-title r d1">
        Sistem Rekomendasi<br>
        Kafe <em>Terbaik</em><br>
        di Malang
      </h1>

      <p class="tk-hero-desc r d2">
        ngafein. hadir untuk membantu kamu menemukan tempat ngopi yang benar-benar sesuai, bukan sekadar yang paling viral, tapi yang paling tepat untukmu.
      </p>

      <div class="hero-wordmark r d3" aria-hidden="true">ngafein.</div>
    </div>

    <div class="hero-right r d2">
      <div class="hero-stats">
        <div class="hero-stat hero-stat--accent">
          <div class="hero-stat-num">110<span>+</span></div>
          <div class="hero-stat-label">Kafe di Malang Raya</div>
          <div class="stat-icon"><i data-lucide="coffee" class="w-5 h-5"></i></div>
        </div>
        <div class="hero-stat">
          <div class="hero-stat-num">6</div>
          <div class="hero-stat-label">Kriteria penilaian</div>
          <div class="stat-icon"><i data-lucide="list-checks" class="w-5 h-5"></i></div>
        </div>
        <div class="hero-stat">
          <div class="hero-stat-num">SAW</div>
          <div class="hero-stat-label">Metode perangkingan</div>
          <div class="stat-icon"><i data-lucide="bar-chart-3" class="w-5 h-5"></i></div>
        </div>
        <div class="hero-stat">
          <div class="hero-stat-num">4.6<span><i data-lucide="star" class="w-4 h-4 inline-block fill-current" style="vertical-align:-2px"></i></span></div>
          <div class="hero-stat-label">Rating rata-rata</div>
          <div class="stat-icon"><i data-lucide="trending-up" class="w-5 h-5"></i></div>
        </div>
      </div>

      <div class="hero-note r d3">
        <i data-lucide="flask-conical" class="w-4 h-4 flex-shrink-0 mt-0.5"></i>
        <p>Dibangun sebagai proyek riset Sistem Pendukung Keputusan (SPK) yang terbuka, transparan, dan terus berkembang.</p>
      </div>
    </div>
  </div>
</section>

@push('styles')
<style>
  #tk-hero-section {
    position: relative;
    overflow: hidden;
    padding: 10rem 0 7rem;
  }

  .hero-inner {
    position: relative;
    z-index: 1;
    width: min(1180px, calc(100% - 48px));
    margin: 0 auto;
    display: grid;
    grid-template-columns: 1.1fr 0.9fr;
    gap: clamp(3rem, 7vw, 7rem);
    align-items: center;
  }

  .hero-left {
    position: relative;
  }

  .hero-eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 0.6rem;
    font-size: 0.68rem;
    font-weight: 700;
    letter-spacing: 0.22em;
    text-transform: uppercase;
    color: #101828;
    background: rgba(16, 24, 40, 0.07);
    border: 1px solid rgba(16, 24, 40, 0.2);
    padding: 0.45rem 1rem 0.45rem 0.75rem;
    border-radius: 999px;
    margin-bottom: 1.6rem;
    font-family: var(--font-plus-jakarta);
  }

  .eyebrow-dot {
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: #B87C39;
    flex-shrink: 0;
    box-shadow: 0 0 0 3px rgba(184, 124, 57, 0.18);
  }

  .tk-hero-title {
    font-family: var(--font-plus-jakarta);
    font-size: clamp(3.4rem, 6.8vw, 6.2rem);
    font-weight: 700;
    line-height: 0.95;
    color: #101828;
    letter-spacing: -0.02em;
    margin-bottom: 1.8rem;
  }

  .tk-hero-title em {
    color: #B87C39;
    font-style: normal;
    font-weight: 800;
  }

  .tk-hero-desc {
    max-width: 520px;
    font-size: clamp(0.98rem, 1.35vw, 1.12rem);
    color: rgba(16, 24, 40, 0.6);
    line-height: 1.95;
    margin-bottom: 0;
    font-family: var(--font-plus-jakarta);
  }

  .hero-wordmark {
    position: absolute;
    bottom: -0.5rem;
    left: -0.4rem;
    font-family: var(--font-plus-jakarta);
    font-size: clamp(5rem, 13vw, 11rem);
    font-weight: 800;
    color: transparent;
    -webkit-text-stroke: 1px rgba(16, 24, 40, 0.07);
    letter-spacing: -0.04em;
    line-height: 1;
    pointer-events: none;
    user-select: none;
    white-space: nowrap;
    z-index: -1;
  }

  .hero-right {
    display: flex;
    flex-direction: column;
    gap: 1rem;
  }

  .hero-stats {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 0.85rem;
  }

  .hero-stat {
    position: relative;
    background: #fff;
    border: 1px solid rgba(16, 24, 40, 0.1);
    border-radius: 20px;
    padding: 1.5rem 1.4rem 1.3rem;
    box-shadow: 0 2px 20px rgba(16, 24, 40, 0.05);
    transition: transform 0.32s cubic-bezier(.2,.8,.2,1),
                box-shadow 0.32s cubic-bezier(.2,.8,.2,1),
                border-color 0.32s cubic-bezier(.2,.8,.2,1);
    overflow: hidden;
  }

  .hero-stat::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 3px;
    height: 0;
    background: #101828;
    border-radius: 0 0 3px 0;
    transition: height 0.4s cubic-bezier(.2,.8,.2,1);
  }

  .hero-stat:hover {
    transform: translateY(-5px);
    border-color: rgba(16, 24, 40, 0.28);
    box-shadow: 0 16px 40px -16px rgba(16, 24, 40, 0.22);
  }

  .hero-stat:hover::before {
    height: 50%;
  }

  .hero-stat--accent {
    background: #2b1a09;
    border: 1px solid rgba(255, 255, 255, 0.08);
    border: none;
  }

  .hero-stat--accent::before {
    background: #B87C39;
  }

  .hero-stat--accent .hero-stat-num { color: #fff; }
  .hero-stat--accent .hero-stat-num span { color: #B87C39; }
  .hero-stat--accent .hero-stat-label { color: rgba(255,255,255,0.55); }
  .hero-stat--accent .stat-icon { color: rgba(255,255,255,0.18); }

  .hero-stat--accent:hover {
    box-shadow: 0 20px 50px -18px rgba(16, 24, 40, 0.7);
  }

  .hero-stat-num {
    font-family: var(--font-plus-jakarta);
    font-size: clamp(2rem, 3.8vw, 2.8rem);
    font-weight: 700;
    color: #101828;
    line-height: 1;
    letter-spacing: -0.02em;
    margin-bottom: 0.5rem;
  }

  .hero-stat-num span {
    color: #B87C39;
  }

  .hero-stat-label {
    font-size: 0.78rem;
    color: rgba(16, 24, 40, 0.55);
    line-height: 1.5;
    font-family: var(--font-plus-jakarta);
  }

  .stat-icon {
    position: absolute;
    bottom: 1.1rem;
    right: 1.2rem;
    color: rgba(16, 24, 40, 0.12);
    transition: color 0.32s cubic-bezier(.2,.8,.2,1), transform 0.32s cubic-bezier(.2,.8,.2,1);
  }

  .hero-stat:hover .stat-icon {
    color: rgba(16, 24, 40, 0.22);
    transform: scale(1.12);
  }

  .hero-note {
    display: flex;
    align-items: flex-start;
    gap: 0.8rem;
    background: #2B1A09;
    border: 1px solid rgba(255, 255, 255, 0.08);
    color: rgba(255, 255, 255, 0.85);
    border-radius: 16px;
    padding: 1.1rem 1.3rem;
    font-size: 0.875rem;
    line-height: 1.7;
    box-shadow: 0 12px 36px -16px rgba(16, 24, 40, 0.5);
    font-family: var(--font-plus-jakarta);
  }

  .hero-note i {
    color: #B87C39;
    flex-shrink: 0;
    margin-top: 2px;
  }

  .hero-note p { margin: 0; }

  @media (max-width: 980px) {
    #tk-hero-section { padding: 8rem 0 5rem; }
    .hero-inner { grid-template-columns: 1fr; gap: 3rem; }
    .hero-wordmark { display: none; }
  }

  @media (max-width: 640px) {
    #tk-hero-section { padding: 7.5rem 0 4rem; }
    .hero-inner { width: min(100% - 28px, 1180px); }
    .tk-hero-title { font-size: clamp(2.6rem, 14vw, 3.8rem); }
    .hero-stats { grid-template-columns: 1fr 1fr; }
    .hero-stat { padding: 1.2rem; }
  }
</style>
@endpush