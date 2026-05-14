@extends('layouts.user')

@section('title', 'Tentang Kami | ngafein.')
@section('navbar-dark-text', 'true')

@push('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,500;0,600;1,400;1,600&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500&display=swap" rel="stylesheet">
<style>
  :root {
    --color-brand: #B87C39;
    --color-brand-deep: #6E4A2F;
    --color-espresso: #241409;
    --color-dark: #2B1A09;
    --color-canvas: #FCFAF8;
    --color-cream: #F7F0E8;
    --color-text-body: #3A2719;
    --color-text-muted: rgba(58, 39, 25, 0.66);
    --color-line: rgba(110, 74, 47, 0.13);
    --color-line-strong: rgba(110, 74, 47, 0.22);
    --font-playfair: "Playfair Display", serif;
    --font-dm-sans: "DM Sans", sans-serif;
    --radius-lg: 32px;
    --radius-md: 24px;
  }


  body {
    background: #fff;
    overflow-x: hidden;
  }

  .tk-container {
    width: min(1120px, calc(100% - 40px));
    margin: 0 auto;
  }

  .section-label {
    display: inline-flex;
    align-items: center;
    gap: 0.8rem;
    font-size: 0.68rem;
    font-weight: 700;
    letter-spacing: 0.2em;
    text-transform: uppercase;
    color: var(--color-brand);
    margin-bottom: 1rem;
  }

  .section-label::before {
    content: "";
    width: 34px;
    height: 1px;
    background: currentColor;
    opacity: 0.7;
  }

  .section-title {
    font-family: var(--font-playfair);
    font-size: clamp(2rem, 4.2vw, 3.35rem);
    font-weight: 600;
    line-height: 1.08;
    color: var(--color-brand);
    letter-spacing: 0;
  }

  .section-title em {
    color: var(--color-espresso);
    font-style: italic;
    font-weight: 400;
  }

  .section-body {
    font-size: 1rem;
    color: rgba(58, 39, 25, 0.66);
    line-height: 1.85;
  }

  .tk-divider {
    width: 56px;
    height: 2px;
    background: var(--color-brand);
    margin: 1.55rem 0;
  }


  .r {
    opacity: 0;
    transform: translateY(22px);
    transition: opacity 0.7s cubic-bezier(.2,.8,.2,1), transform 0.7s cubic-bezier(.2,.8,.2,1);
  }

  .r.on { opacity: 1; transform: none; }
  .d1 { transition-delay: 0.08s; }
  .d2 { transition-delay: 0.16s; }
  .d3 { transition-delay: 0.24s; }

  @media (max-width: 640px) {
    .tk-container {
      width: min(100% - 28px, 1120px);
    }
  }
</style>
@endpush

@section('content')

  @include('user.about_us.sections.hero')
  @include('user.about_us.sections.latar')
  @include('user.about_us.sections.tujuan')
  @include('user.about_us.sections.kriteria')
  @include('user.about_us.sections.alur')
  @include('user.about_us.sections.kenapa')
  @include('user.about_us.sections.visimisi')
  @include('user.about_us.sections.cta')

@endsection

@push('scripts')
<script>

  const revealElements = document.querySelectorAll('.r');
  const revealObserver = new IntersectionObserver(entries => {
    entries.forEach(entry => { 
      if (entry.isIntersecting) entry.target.classList.add('on'); 
    });
  }, { threshold: 0.08, rootMargin: '0px 0px -30px 0px' });
  
  revealElements.forEach(el => revealObserver.observe(el));
</script>
@endpush
