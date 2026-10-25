<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="theme-color" content="#0047b3">
  <title>TalentGroup.id — Raih Ilmu, Kuasai Kode</title>
  <meta name="description" content="TalentGroup.id — Platform edukasi pemrograman interaktif terdepan di Indonesia. Pelajari PHP, JavaScript, Python, SQL, hingga AI dengan modul dan tantangan game coding modern.">
  <meta name="keywords" content="belajar coding, kursus pemrograman, belajar php, javascript, python, web development, game edukasi, talentgroup">
  <meta name="robots" content="index, follow">
  <link rel="canonical" href="{{ url('/') }}">

  <!-- Open Graph / Facebook -->
  <meta property="og:type" content="website">
  <meta property="og:url" content="{{ url('/') }}">
  <meta property="og:title" content="TalentGroup.id — Raih Ilmu, Kuasai Kode">
  <meta property="og:description" content="Platform belajar pemrograman interaktif dan menyenangkan. Kuasai coding dari dasar hingga mahir siap kerja.">
  <meta property="og:image" content="{{ asset('tg/assets/logo-talentgroup-clean.png') }}">
  <meta property="og:site_name" content="TalentGroup.id">

  <!-- Twitter -->
  <meta property="twitter:card" content="summary_large_image">
  <meta property="twitter:url" content="{{ url('/') }}">
  <meta property="twitter:title" content="TalentGroup.id — Raih Ilmu, Kuasai Kode">
  <meta property="twitter:description" content="Platform belajar pemrograman interaktif dan menyenangkan. Kuasai coding dari dasar hingga mahir siap kerja.">
  <meta property="twitter:image" content="{{ asset('tg/assets/logo-talentgroup-clean.png') }}">

  <!-- Structured Data JSON-LD for Search Engines -->
  <script type="application/ld+json">
  {
    "@@context": "https://schema.org",
    "@@type": "EducationalOrganization",
    "name": "TalentGroup.id",
    "url": "{{ url('/') }}",
    "logo": "{{ asset('tg/assets/logo-talentgroup-clean.png') }}",
    "description": "Platform edukasi pemrograman interaktif dan komunitas belajar digital terkemuka di Indonesia.",
    "sameAs": [
      "https://facebook.com/talentgroup",
      "https://instagram.com/talentgroup.id"
    ]
  }
  </script>

  <!-- Favicon -->
  <link rel="icon" type="image/png" href="{{ asset('tg/assets/logo-talentgroup-clean.png') }}">

  <!-- Fonts & Resource Hints -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Fira+Code:wght@400;500;600;700&family=Outfit:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="{{ asset('tg/fonts.css') }}">
  <link rel="stylesheet" href="{{ asset('tg/style.css') }}?v={{ time() }}">
  <link rel="stylesheet" href="{{ asset('tg/art.css') }}">
  <link rel="stylesheet" href="{{ asset('tg/motion.css') }}">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <script>
    (function() {
      if (localStorage.getItem('theme') === 'dark') {
        document.documentElement.classList.add('dark');
      }
    })();
  </script>

  <style>
    /* High Readability & User-Friendly Modern Aesthetics */
    body {
      color: #0b2447;
      background: #ffffff;
      font-family: 'Outfit', sans-serif;
      transition: background-color 0.3s ease, color 0.3s ease;
    }

    /* Landing Theme Toggle Button */
    .landing-theme-toggle {
      width: 50px;
      height: 26px;
      border-radius: 9999px;
      background: #e2e8f0;
      border: 1.5px solid #cbd5e1;
      position: relative;
      cursor: pointer;
      padding: 0;
      display: inline-flex;
      align-items: center;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      flex-shrink: 0;
      outline: none;
    }
    .landing-toggle-thumb {
      position: absolute;
      top: 1.5px;
      left: 2px;
      width: 20px;
      height: 20px;
      border-radius: 50%;
      background: #0047b3;
      color: #ffffff;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 10px;
      transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1), background 0.3s ease;
      box-shadow: 0 2px 5px rgba(0, 71, 179, 0.3);
    }
    body.dark .landing-theme-toggle {
      background: #112144;
      border-color: #23457d;
    }
    body.dark .landing-toggle-thumb {
      transform: translateX(24px);
      background: #38bdf8;
      color: #070e1e;
      box-shadow: 0 0 10px rgba(56, 189, 248, 0.6);
    }

    /* ==========================================================================
       NIGHT MODE / DARK MODE COMPREHENSIVE LUXURY BLUE PALETTE
       Mengubah seluruh halaman awal agar TIDAK putih, melainkan midnight blue
       elegan dengan aksen icy blue bercahaya & teks putih lembut yang mudah dibaca.
       ========================================================================== */
    body.dark {
      background-color: #070e1e !important;
      color: #f0f6ff !important;
    }

    /* Header in Dark Mode */
    body.dark .site-header {
      background: rgba(9, 19, 43, 0.94) !important;
      border: none !important;
      border-bottom: 1px solid rgba(255, 255, 255, 0.08) !important;
      box-shadow: 0 4px 24px rgba(0, 15, 45, 0.55) !important;
    }
    body.dark .brand-text {
      color: #f0f6ff !important;
    }
    body.dark .brand-accent {
      color: #38bdf8 !important;
    }
    body.dark .brand-tld {
      color: #7dd3fc !important;
    }
    body.dark .site-header nav {
      background: rgba(18, 33, 68, 0.85) !important;
      border: 1px solid #1d3768 !important;
    }
    body.dark .site-header nav a {
      color: #cbd5e1 !important;
    }
    body.dark .site-header nav a:hover {
      color: #38bdf8 !important;
      background: rgba(56, 189, 248, 0.12) !important;
    }
    body.dark .site-header nav a.active {
      background: #0284c7 !important;
      color: #ffffff !important;
      box-shadow: 0 3px 12px rgba(2, 132, 199, 0.4) !important;
    }
    body.dark .header-actions .btn-outline {
      background: #0f203f !important;
      border-color: #23457d !important;
      color: #93c5fd !important;
    }
    body.dark .header-actions .btn-outline:hover {
      background: #1a386a !important;
      border-color: #38bdf8 !important;
      color: #ffffff !important;
      box-shadow: 0 0 14px rgba(56, 189, 248, 0.25) !important;
    }
    body.dark .menu-toggle {
      background: #0f203f !important;
      border-color: #23457d !important;
      color: #38bdf8 !important;
    }
    @media (max-width: 992px) {
      body.dark .site-header nav {
        background: rgba(10, 20, 44, 0.98) !important;
        border-color: #1d3768 !important;
        box-shadow: 0 15px 35px -5px rgba(0, 15, 45, 0.7) !important;
      }
    }

    /* Hero in Dark Mode */
    body.dark .hero {
      background: #070e1e radial-gradient(circle at 50% 15%, rgba(14, 34, 77, 0.65) 0%, #070e1e 75%) !important;
    }
    body.dark .hero h1 {
      color: #ffffff !important;
      text-shadow: 0 2px 14px rgba(0, 0, 0, 0.6) !important;
    }
    body.dark .hero h1 span {
      background: linear-gradient(135deg, #38bdf8 0%, #60a5fa 55%, #93c5fd 100%) !important;
      -webkit-background-clip: text !important;
      -webkit-text-fill-color: transparent !important;
      color: transparent !important;
      filter: drop-shadow(0 2px 20px rgba(56, 189, 248, 0.55)) !important;
      display: inline-block !important;
    }
    body.dark .hero-copy > p {
      color: #cbd5e1 !important;
    }
    body.dark .hero-copy > p strong {
      color: #7dd3fc !important;
    }
    body.dark .hero-stats {
      border-top: 1px solid rgba(255, 255, 255, 0.1) !important;
    }
    body.dark .hero-stats strong {
      color: #38bdf8 !important;
      font-size: 28px !important;
      font-weight: 800 !important;
      letter-spacing: -0.5px !important;
      text-shadow: 0 0 16px rgba(56, 189, 248, 0.35) !important;
    }
    body.dark .hero-stats span {
      color: #94a3b8 !important;
      font-size: 13px !important;
      font-weight: 600 !important;
    }
    body.dark .hero-stats > div {
      background: transparent !important;
      border: none !important;
      box-shadow: none !important;
      padding: 0 !important;
    }
    body.dark .btn-glass {
      background: #0d1b38 !important;
      border-color: #38bdf8 !important;
      color: #38bdf8 !important;
    }
    body.dark .btn-glass:hover {
      background: #152750 !important;
      color: #ffffff !important;
    }

    /* Floating Cards & Visual in Dark Mode - Crisp, High-Tech Glassmorphism Border */
    body.dark .art-5e856f96be,
    body.dark .art-07017a0609,
    body.dark .art-57e19b959a,
    body.dark .art-5dab2957c8 {
      background: linear-gradient(145deg, rgba(14, 28, 59, 0.94) 0%, rgba(8, 17, 38, 0.96) 100%) !important;
      border: 1.5px solid rgba(56, 189, 248, 0.45) !important;
      box-shadow: 0 16px 36px -8px rgba(0, 8, 28, 0.75), 0 0 20px rgba(56, 189, 248, 0.16), inset 0 1px 1px rgba(255, 255, 255, 0.18) !important;
      backdrop-filter: blur(12px) !important;
      -webkit-backdrop-filter: blur(12px) !important;
      border-radius: 14px !important;
    }
    body.dark .art-5e856f96be:hover,
    body.dark .art-07017a0609:hover,
    body.dark .art-57e19b959a:hover,
    body.dark .art-5dab2957c8:hover {
      border-color: #38bdf8 !important;
      box-shadow: 0 20px 42px -6px rgba(0, 15, 45, 0.85), 0 0 25px rgba(56, 189, 248, 0.3) !important;
      transform: translateY(-4px) scale(1.02) !important;
    }
    body.dark .tg-mobile-snippet {
      background: #0d1b38 !important;
      border-color: #1d3768 !important;
    }
    body.dark .tg-msnip-bar {
      background: #0a1733 !important;
      border-bottom-color: #1d3768 !important;
      color: #cbd5e1 !important;
    }
    body.dark .tg-msnip-code {
      background: #060e22 !important;
      color: #f1f5f9 !important;
    }
    body.dark .tg-m-tag {
      background: rgba(13, 27, 56, 0.95) !important;
      border-color: #1d3768 !important;
      color: #f0f6ff !important;
      box-shadow: 0 6px 18px rgba(0, 15, 45, 0.5) !important;
    }

    /* Our Works in Dark Mode */
    body.dark .works {
      background: #09132b !important;
      border-top: 1px solid #1d3768 !important;
      border-bottom: 1px solid #1d3768 !important;
    }
    body.dark .works .section-intro h2 {
      color: #ffffff !important;
    }
    body.dark .works .section-intro p {
      color: #cbd5e1 !important;
    }
    body.dark .technology {
      background: #0d1b38 !important;
      border-color: #1d3768 !important;
      color: #f0f6ff !important;
      box-shadow: 0 6px 18px rgba(0, 15, 45, 0.4) !important;
    }
    body.dark .technology:hover {
      background: #112246 !important;
      border-color: #38bdf8 !important;
      box-shadow: 0 8px 24px rgba(0, 15, 45, 0.6), 0 0 14px rgba(56, 189, 248, 0.2) !important;
    }
    body.dark .technology-symbol {
      background: rgba(56, 189, 248, 0.08) !important;
    }
    body.dark .technology span {
      color: #f0f6ff !important;
    }
    body.dark .works-detail h3 {
      color: #ffffff !important;
    }
    body.dark .works-detail p {
      color: #cbd5e1 !important;
    }
    body.dark .tg-ide-card {
      background: #0d1b38 !important;
      border-color: #1d3768 !important;
      box-shadow: 0 16px 36px -10px rgba(0, 15, 45, 0.6) !important;
    }
    body.dark .tg-ide-header {
      background: #0a1733 !important;
      border-bottom-color: #1d3768 !important;
      color: #cbd5e1 !important;
    }
    body.dark .tg-ide-tab {
      background: #0d1b38 !important;
      border-color: #1d3768 !important;
      color: #f0f6ff !important;
    }
    body.dark .tg-ide-body {
      background: #060e22 !important;
      color: #f1f5f9 !important;
    }
    body.dark .tg-line-numbers {
      border-right-color: #1d3768 !important;
      color: #64748b !important;
    }
    body.dark .tg-code-content {
      color: #f1f5f9 !important;
    }

    /* Game Edu in Dark Mode */
    body.dark .game-section {
      background: linear-gradient(180deg, #09132b 0%, #070e1e 100%) !important;
      border-color: #1d3768 !important;
    }
    body.dark .game-section .section-intro h2 {
      color: #ffffff !important;
    }
    body.dark .game-section .section-intro p {
      color: #cbd5e1 !important;
    }
    body.dark .challenge-window {
      background: #0d1b38 !important;
      border-color: #1d3768 !important;
      box-shadow: 0 16px 36px -10px rgba(0, 15, 45, 0.6) !important;
    }
    body.dark .window-bar {
      background: #0a1733 !important;
      border-bottom-color: #1d3768 !important;
      color: #f0f6ff !important;
    }
    body.dark .challenge-task {
      color: #93c5fd !important;
    }
    body.dark .challenge-code {
      background: #060e22 !important;
      border: 1px solid #1d3768 !important;
      color: #e2e8f0 !important;
    }
    body.dark .game-output {
      background: #050a17 !important;
      border-color: #1d3768 !important;
      color: #38bdf8 !important;
    }
    body.dark .challenge-form input {
      background: #0a1733 !important;
      border-color: #1d3768 !important;
      color: #ffffff !important;
    }
    body.dark .game-copy h3 {
      color: #ffffff !important;
    }
    body.dark .game-copy p {
      color: #cbd5e1 !important;
    }
    body.dark .language-tags span {
      background: #0e1c3b !important;
      border: 1px solid #1d3768 !important;
      color: #cbd5e1 !important;
    }
    body.dark .game-stats > div {
      background: #0d1b38 !important;
      border-color: #1d3768 !important;
    }
    body.dark .game-stats strong {
      color: #38bdf8 !important;
    }
    body.dark .game-stats span {
      color: #94a3b8 !important;
    }
    body.dark .eyebrow-badge {
      background: rgba(56, 189, 248, 0.15) !important;
      color: #38bdf8 !important;
      border-color: rgba(56, 189, 248, 0.3) !important;
    }

    /* Courses in Dark Mode */
    body.dark .courses {
      background: #070e1e !important;
    }
    body.dark .course-heading h2 {
      color: #ffffff !important;
    }
    body.dark .eyebrow {
      color: #38bdf8 !important;
    }
    body.dark .subtle-link {
      color: #38bdf8 !important;
    }
    body.dark .course-card {
      background: #0d1b38 !important;
      border-color: #1d3768 !important;
      box-shadow: 0 8px 24px rgba(0, 15, 45, 0.45) !important;
    }
    body.dark .course-card:hover {
      border-color: #38bdf8 !important;
      box-shadow: 0 14px 34px rgba(0, 15, 45, 0.6), 0 0 16px rgba(56, 189, 248, 0.15) !important;
    }
    body.dark .course-cover {
      background: #0a1733 !important;
      border-bottom-color: #1d3768 !important;
    }
    body.dark .course-body h3 {
      color: #f0f6ff !important;
    }
    body.dark .course-kicker {
      color: #38bdf8 !important;
    }
    body.dark .course-meta {
      color: #94a3b8 !important;
    }
    body.dark .course-price {
      color: #38bdf8 !important;
    }
    body.dark .course-price.free-text {
      color: #34d399 !important;
    }
    body.dark .course-detail-btn {
      background: #0f203f !important;
      color: #38bdf8 !important;
      border-color: #23457d !important;
    }
    body.dark .course-detail-btn:hover {
      background: #1a386a !important;
      color: #ffffff !important;
      border-color: #38bdf8 !important;
    }
    body.dark .carousel-arrow {
      background: #0d1b38 !important;
      border-color: #1d3768 !important;
      color: #38bdf8 !important;
    }
    body.dark .carousel-arrow:hover {
      background: #152750 !important;
      color: #ffffff !important;
    }
    body.dark .tg-mobile-swipe-hint span {
      color: #94a3b8 !important;
    }

    /* About & Benefits in Dark Mode */
    body.dark .about {
      background: #070e1e !important;
      border-top: 1px solid rgba(255, 255, 255, 0.08) !important;
    }
    body.dark .about .section-intro h2 {
      color: #ffffff !important;
      font-size: 38px !important;
      font-weight: 800 !important;
    }
    body.dark .about .section-intro .eyebrow {
      color: #38bdf8 !important;
      font-weight: 700 !important;
    }
    body.dark .about .section-intro p {
      color: #cbd5e1 !important;
    }
    body.dark .benefit {
      background: linear-gradient(165deg, #0d1b38 0%, #09132b 100%) !important;
      border: 1.5px solid rgba(56, 189, 248, 0.25) !important;
      border-radius: 20px !important;
      box-shadow: 0 8px 24px -4px rgba(0, 10, 30, 0.5) !important;
    }
    body.dark .benefit::before {
      background: linear-gradient(90deg, #38bdf8, #818cf8) !important;
    }
    body.dark .benefit:hover {
      border-color: #38bdf8 !important;
      box-shadow: 0 16px 36px -4px rgba(0, 15, 45, 0.75), 0 0 24px rgba(56, 189, 248, 0.25) !important;
    }
    body.dark .benefit>img,
    body.dark .benefit-icon-wrapper {
      border: 1.5px solid rgba(255, 255, 255, 0.25) !important;
      filter: drop-shadow(0 2px 6px rgba(0,0,0,0.4)) !important;
    }
    body.dark .benefit:nth-child(1)>img,
    body.dark .benefit-1 .benefit-icon-wrapper {
      background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%) !important;
      box-shadow: 0 8px 20px -3px rgba(2, 132, 199, 0.5) !important;
    }
    body.dark .benefit:nth-child(2)>img,
    body.dark .benefit-2 .benefit-icon-wrapper {
      background: linear-gradient(135deg, #6366f1 0%, #4338ca 100%) !important;
      box-shadow: 0 8px 20px -3px rgba(99, 102, 241, 0.5) !important;
    }
    body.dark .benefit:nth-child(3)>img,
    body.dark .benefit-3 .benefit-icon-wrapper {
      background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%) !important;
      box-shadow: 0 8px 20px -3px rgba(14, 165, 233, 0.5) !important;
    }
    body.dark .benefit:nth-child(4)>img,
    body.dark .benefit-4 .benefit-icon-wrapper {
      background: linear-gradient(135deg, #f59e0b 0%, #b45309 100%) !important;
      box-shadow: 0 8px 20px -3px rgba(245, 158, 11, 0.5) !important;
    }
    body.dark .benefit:nth-child(5)>img,
    body.dark .benefit-5 .benefit-icon-wrapper {
      background: linear-gradient(135deg, #10b981 0%, #047857 100%) !important;
      box-shadow: 0 8px 20px -3px rgba(16, 185, 129, 0.5) !important;
    }
    body.dark .benefit:nth-child(6)>img,
    body.dark .benefit-6 .benefit-icon-wrapper {
      background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%) !important;
      box-shadow: 0 8px 20px -3px rgba(59, 130, 246, 0.5) !important;
    }
    body.dark .benefit h3 {
      color: #f1f5f9 !important;
      font-weight: 800 !important;
      font-size: 19px !important;
    }
    body.dark .benefit:hover h3 {
      color: #38bdf8 !important;
    }
    body.dark .benefit p {
      color: #94a3b8 !important;
      line-height: 1.65 !important;
      font-size: 14px !important;
    }

    /* Footer in Dark Mode */
    body.dark .site-footer {
      background: #040914 !important;
      border-top: 1px solid #142446 !important;
    }
    body.dark .footer-bottom {
      border-top-color: #142446 !important;
      color: #94a3b8 !important;
    }
    /* === HERO SECTION SPACING & RESPONSIVENESS === */
    .hero {
      min-height: auto !important;
      padding: 85px 0 85px !important;
      background: #eaf2ff url('{{ asset("tg/assets/60-2-img-gradient.svg") }}') center top/cover no-repeat !important;
      overflow: hidden !important;
      position: relative !important;
    }
    .hero-inner {
      min-height: auto !important;
      display: grid !important;
      grid-template-columns: minmax(420px, 1.15fr) 1fr !important;
      gap: 40px !important;
      align-items: center !important;
      padding-top: 20px !important;
      padding-bottom: 20px !important;
    }
    .hero-copy {
      padding-top: 15px !important;
      z-index: 2 !important;
    }
    .hero h1 {
      font-size: clamp(38px, 4.4vw, 62px) !important;
      line-height: 1.12 !important;
      letter-spacing: -1px !important;
      color: #0b2447 !important;
      margin: 0 0 18px 0 !important;
      text-shadow: none !important;
    }
    .hero h1 span {
      color: #ffffff !important;
      background: none !important;
      -webkit-background-clip: initial !important;
      -webkit-text-fill-color: #ffffff !important;
      text-shadow: 0 2px 8px rgba(0, 35, 100, 0.4) !important;
      display: inline-block;
    }
    .hero-copy > p {
      color: #1e3a63 !important;
      font-weight: 500 !important;
      font-size: 16.5px !important;
      line-height: 1.65 !important;
      margin: 0 0 28px 0 !important;
      max-width: 520px !important;
    }
    .hero-copy > p strong {
      color: #00408c !important;
    }
    .hero-buttons {
      display: flex !important;
      gap: 14px !important;
      margin-top: 0 !important;
      margin-bottom: 34px !important;
    }
    .hero-stats {
      display: flex !important;
      gap: 36px !important;
      margin-top: 0 !important;
      padding-top: 22px !important;
      border-top: 1px solid rgba(0, 71, 179, 0.12) !important;
    }
    .hero-stats > div {
      display: flex !important;
      flex-direction: column !important;
      gap: 4px !important;
    }
    .hero-stats strong {
      font-size: 26px !important;
      font-weight: 800 !important;
      color: #00408c !important;
      line-height: 1 !important;
    }
    .hero-stats span {
      color: #2a4365 !important;
      font-weight: 600 !important;
      font-size: 13px !important;
    }
    .hero-visual {
      margin-top: 40px !important;
      width: 480px !important;
      height: 480px !important;
      justify-self: center !important;
    }

    @media (max-width: 1024px) {
      .hero {
        padding: 60px 0 70px !important;
      }
      .hero-inner {
        grid-template-columns: 1fr !important;
        gap: 50px !important;
        text-align: center !important;
      }
      .hero-copy {
        display: flex !important;
        flex-direction: column !important;
        align-items: center !important;
        text-align: center !important;
      }
      .hero-copy > p {
        max-width: 600px !important;
      }
      .hero-buttons {
        justify-content: center !important;
      }
      .hero-stats {
        justify-content: center !important;
      }
      .hero-visual {
        transform: scale(0.9) !important;
        transform-origin: center top !important;
        height: 440px !important;
        margin-top: 45px !important;
      }
    }
    /* === MOBILE RESPONSIVE ENHANCEMENTS (MAX-WIDTH: 768px) === */
    .tg-hero-mobile-wrapper {
      display: none;
    }
    .tg-mobile-swipe-hint {
      display: none;
    }

    @media (max-width: 768px) {
      /* Hero Container & Spacing */
      .hero {
        padding: 30px 0 45px !important;
        background: #eaf2ff url('{{ asset("tg/assets/60-2-img-gradient.svg") }}') center top/cover no-repeat !important;
      }
      .hero-inner {
        grid-template-columns: 1fr !important;
        gap: 24px !important;
        text-align: center !important;
        padding-top: 10px !important;
        padding-bottom: 10px !important;
      }
      .hero-copy {
        display: flex !important;
        flex-direction: column !important;
        align-items: center !important;
        padding-top: 0 !important;
      }
      .hero h1 {
        font-size: 30px !important;
        line-height: 1.22 !important;
        letter-spacing: -0.6px !important;
        margin: 0 0 14px 0 !important;
      }
      .hero h1 span {
        color: #ffffff !important;
        background: none !important;
        -webkit-background-clip: initial !important;
        -webkit-text-fill-color: #ffffff !important;
        text-shadow: 0 2px 8px rgba(0, 35, 100, 0.4) !important;
      }
      .hero-copy > p {
        font-size: 14px !important;
        line-height: 1.6 !important;
        color: #334155 !important;
        margin: 0 0 20px 0 !important;
        max-width: 95% !important;
      }
      .hero-copy > p strong {
        color: #0047b3 !important;
      }

      /* Hero Buttons - Stacked & Finger-Friendly */
      .hero-buttons {
        flex-direction: column !important;
        width: 100% !important;
        max-width: 320px !important;
        gap: 10px !important;
        margin: 0 auto 22px !important;
      }
      .hero-buttons .btn {
        width: 100% !important;
        height: 46px !important;
        padding: 0 18px !important;
        font-size: 14px !important;
        font-weight: 700 !important;
        border-radius: 12px !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
      }

      /* Hero Stats - 3 Modern Clean Glass Cards */
      .hero-stats {
        display: grid !important;
        grid-template-columns: repeat(3, 1fr) !important;
        gap: 8px !important;
        width: 100% !important;
        max-width: 360px !important;
        margin: 0 auto !important;
        padding-top: 16px !important;
        border-top: none !important;
      }
      .hero-stats > div {
        background: rgba(255, 255, 255, 0.9) !important;
        border: 1.5px solid #dbeafe !important;
        border-radius: 12px !important;
        padding: 10px 4px !important;
        text-align: center !important;
        box-shadow: 0 4px 12px rgba(0, 71, 179, 0.05) !important;
      }
      .hero-stats strong {
        font-size: 19px !important;
        font-weight: 800 !important;
        color: #0047b3 !important;
        line-height: 1.1 !important;
      }
      .hero-stats span {
        font-size: 10.5px !important;
        font-weight: 600 !important;
        color: #64748b !important;
        margin-top: 2px !important;
      }

      /* Hero Visual Mobile - Hide Tiny Scaled Desktop Art */
      .tg-desktop-visual {
        display: none !important;
      }
      .hero-visual {
        width: 100% !important;
        max-width: 340px !important;
        height: auto !important;
        transform: none !important;
        margin: 8px auto 0 !important;
      }
      .tg-hero-mobile-wrapper {
        display: flex !important;
        flex-direction: column !important;
        align-items: center !important;
        width: 100% !important;
        position: relative !important;
      }
      .tg-hero-mobile-hub {
        position: relative !important;
        width: 250px !important;
        height: 220px !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
      }
      .tg-mobile-glow {
        position: absolute;
        width: 210px;
        height: 210px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(99, 102, 241, 0.25) 0%, rgba(37, 99, 235, 0.18) 50%, rgba(255, 255, 255, 0) 75%);
        filter: blur(20px);
        pointer-events: none;
      }
      .tg-mobile-orbit {
        position: absolute;
        width: 195px;
        height: 195px;
        border-radius: 50%;
        border: 1.5px dashed rgba(59, 130, 246, 0.45);
        animation: tgSpinClockwise 24s linear infinite;
      }
      .tg-mobile-logo {
        position: relative;
        width: 130px;
        height: 130px;
        display: flex;
        align-items: center;
        justify-content: center;
        animation: tgFloatLogo 3.5s ease-in-out infinite;
        z-index: 5;
      }
      .tg-mobile-logo img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        filter: drop-shadow(0 12px 24px rgba(0, 71, 179, 0.28));
      }
      .tg-m-tag {
        position: absolute;
        background: rgba(255, 255, 255, 0.96);
        border: 1.5px solid #bfdbfe;
        padding: 5px 11px;
        border-radius: 9999px;
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 11px;
        font-weight: 700;
        color: #0b2447;
        box-shadow: 0 6px 16px rgba(0, 71, 179, 0.12);
        z-index: 6;
      }
      .tg-m-tag.tag-left {
        top: 22px;
        left: -8px;
        animation: tgFloatTagLeft 3.5s ease-in-out infinite alternate;
      }
      .tg-m-tag.tag-right {
        bottom: 22px;
        right: -8px;
        animation: tgFloatTagRight 4s ease-in-out infinite alternate;
      }
      .m-dot.live {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: #10b981;
        box-shadow: 0 0 6px #10b981;
      }
      @keyframes tgFloatTagLeft {
        0% { transform: translateY(0); }
        100% { transform: translateY(-5px); }
      }
      @keyframes tgFloatTagRight {
        0% { transform: translateY(0); }
        100% { transform: translateY(5px); }
      }
      .tg-mobile-snippet {
        width: 100%;
        max-width: 310px;
        margin-top: 6px;
        background: #ffffff;
        border: 1.5px solid #cce0ff;
        border-radius: 14px;
        overflow: hidden;
        box-shadow: 0 8px 24px -6px rgba(0, 71, 179, 0.1);
        font-family: 'Fira Code', monospace;
        text-align: left;
      }
      .tg-msnip-bar {
        background: linear-gradient(180deg, #f4f8fe 0%, #e9f2fd 100%);
        padding: 8px 12px;
        display: flex;
        align-items: center;
        gap: 10px;
        border-bottom: 1.5px solid #d4e5fb;
      }
      .tg-msnip-dots {
        display: flex;
        gap: 5px;
      }
      .tg-msnip-dots i {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        display: inline-block;
      }
      .tg-msnip-dots i:nth-child(1) { background: #ef4444; }
      .tg-msnip-dots i:nth-child(2) { background: #f59e0b; }
      .tg-msnip-dots i:nth-child(3) { background: #10b981; }
      .tg-msnip-title {
        font-size: 11px;
        font-weight: 700;
        color: #0b2447;
      }
      .tg-msnip-badge {
        margin-left: auto;
        font-size: 9.5px;
        font-weight: 700;
        color: #0047b3;
        background: #e0edff;
        padding: 2px 6px;
        border-radius: 4px;
        border: 1px solid #bfdbfe;
      }
      .tg-msnip-code {
        padding: 10px 14px;
        background: linear-gradient(180deg, #fbfdff 0%, #f0f6ff 100%);
        font-size: 12px;
        line-height: 1.6;
        color: #1e293b;
      }
      .code-row.indent {
        padding-left: 14px;
      }
      .c-kw { color: #6d28d9; font-weight: 700; }
      .c-cls { color: #d97706; font-weight: 700; }
      .c-var { color: #0047b3; font-weight: 700; }
      .c-str { color: #15803d; font-weight: 600; }
      .c-rose { color: #e11d48; font-weight: 700; }
      .c-cmt { color: #64748b; font-style: italic; }
      .c-slate { color: #334155; }
      .c-brk { color: #334155; font-weight: 700; }

      /* Courses Section & Carousel Mobile */
      .courses {
        padding: 45px 0 55px !important;
      }
      .course-heading {
        display: flex !important;
        flex-direction: column !important;
        align-items: flex-start !important;
        gap: 10px !important;
        margin-bottom: 16px !important;
      }
      .course-heading .eyebrow {
        font-family: 'Fira Code', monospace !important;
        font-size: 11px !important;
        font-weight: 800 !important;
        color: #0047b3 !important;
        letter-spacing: 1.5px !important;
        margin: 0 !important;
      }
      .course-heading h2 {
        font-size: 26px !important;
        font-weight: 900 !important;
        color: #0b2447 !important;
        letter-spacing: -0.5px !important;
        margin: 2px 0 0 0 !important;
      }
      .course-heading .subtle-link {
        display: inline-flex !important;
        align-items: center !important;
        gap: 6px !important;
        font-size: 12.5px !important;
        font-weight: 700 !important;
        color: #0047b3 !important;
        background: #eef5ff !important;
        border: 1.5px solid #bfdbfe !important;
        padding: 7px 16px !important;
        border-radius: 9999px !important;
        text-decoration: none !important;
        transition: all 0.2s ease !important;
        box-shadow: 0 2px 6px rgba(0, 71, 179, 0.05) !important;
      }
      .course-heading .subtle-link:hover {
        background: #0047b3 !important;
        color: #ffffff !important;
      }
      .course-carousel {
        margin-top: 10px !important;
        position: relative !important;
      }
      .carousel-arrow {
        display: none !important;
      }
      .course-track {
        display: flex !important;
        grid-template-columns: none !important;
        gap: 16px !important;
        overflow-x: auto !important;
        scroll-snap-type: x mandatory !important;
        -webkit-overflow-scrolling: touch !important;
        padding: 8px 16px 20px !important;
        margin-inline: -16px !important;
        scrollbar-width: none !important;
      }
      .course-track::-webkit-scrollbar {
        display: none !important;
      }
      .course-card {
        flex: 0 0 280px !important;
        width: 280px !important;
        max-width: 280px !important;
        scroll-snap-align: center !important;
        scroll-snap-stop: always !important;
        background: #ffffff !important;
        border: 1.5px solid #cce0ff !important;
        border-radius: 18px !important;
        overflow: hidden !important;
        box-shadow: 0 8px 22px -4px rgba(0, 71, 179, 0.08) !important;
        transition: transform 0.2s ease !important;
      }
      .course-card:active {
        transform: scale(0.98) !important;
      }
      .course-cover {
        height: 165px !important;
        padding: 0 !important;
        background: #eef4fc !important;
        position: relative !important;
        overflow: hidden !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        border-bottom: 1.5px solid #dbeafe !important;
      }
      .course-cover img, .course-cover > img {
        width: 100% !important;
        height: 100% !important;
        object-fit: cover !important;
        object-position: center !important;
        border-radius: 0 !important;
        filter: none !important;
      }
      .course-body {
        padding: 16px !important;
        display: flex !important;
        flex-direction: column !important;
        gap: 8px !important;
      }
      .course-kicker {
        font-family: 'Fira Code', monospace !important;
        font-size: 10.5px !important;
        font-weight: 700 !important;
        color: #0047b3 !important;
        letter-spacing: 0.8px !important;
      }
      .course-body h3 {
        font-size: 16px !important;
        font-weight: 800 !important;
        line-height: 1.35 !important;
        min-height: 42px !important;
        color: #0b2447 !important;
        margin: 0 !important;
        display: -webkit-box !important;
        -webkit-line-clamp: 2 !important;
        -webkit-box-orient: vertical !important;
        overflow: hidden !important;
        word-break: break-word !important;
      }
      .course-meta {
        font-size: 12px !important;
        color: #64748b !important;
        margin: 0 !important;
      }
      .course-price {
        font-size: 17px !important;
        font-weight: 900 !important;
        color: #0047b3 !important;
        margin: 4px 0 2px !important;
      }
      .course-price.free-text {
        color: #0f8a5f !important;
      }
      .course-detail-btn {
        width: 100% !important;
        padding: 11px 16px !important;
        font-size: 13.5px !important;
        font-weight: 700 !important;
        border-radius: 10px !important;
        text-align: center !important;
        background: #eef5ff !important;
        color: #0047b3 !important;
        border: 1.5px solid #bfdbfe !important;
        display: block !important;
        box-sizing: border-box !important;
        white-space: nowrap !important;
      }
      .tg-mobile-swipe-hint {
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        gap: 6px !important;
        margin-top: 10px !important;
        font-size: 12px !important;
        font-weight: 600 !important;
        color: #64748b !important;
      }
    }
    .btn-gradient {
      background: linear-gradient(136deg, #0047b3, #2563eb);
      color: #ffffff !important;
      box-shadow: 0 4px 14px rgba(0, 71, 179, 0.35);
      border: none;
      transition: all 0.25s ease;
    }
    .btn-gradient:hover {
      box-shadow: 0 8px 22px rgba(0, 71, 179, 0.45);
      filter: brightness(1.06);
      transform: translateY(-2px);
    }
    .btn-glass {
      background: #ffffff;
      color: #0047b3 !important;
      border: 1.5px solid #0047b3;
      box-shadow: 0 4px 10px rgba(0, 71, 179, 0.1);
      font-weight: 700;
      transition: all 0.25s ease;
    }
    .btn-glass:hover {
      background: #e6f0ff;
      transform: translateY(-2px);
    }
    .btn-outline {
      border: 1.5px solid #d5deee;
      color: #0b2447;
      background: #ffffff;
      transition: all 0.25s ease;
    }
    .btn-outline:hover {
      border-color: #0047b3;
      color: #0047b3;
      background: #e6f0ff;
    }

    /* === MODERN GLASS NAVBAR HEADER === */
    .site-header {
      position: sticky !important;
      top: 0 !important;
      left: 0 !important;
      right: 0 !important;
      height: 74px !important;
      z-index: 1000 !important;
      display: flex !important;
      align-items: center !important;
      justify-content: space-between !important;
      padding: 0 max(5%, 24px) !important;
      background: rgba(255, 255, 255, 0.94) !important;
      backdrop-filter: blur(16px) !important;
      -webkit-backdrop-filter: blur(16px) !important;
      border: none !important;
      border-bottom: 1.5px solid #dbeafe !important;
      box-shadow: 0 4px 20px -3px rgba(0, 71, 179, 0.07) !important;
      transition: background 0.3s ease, box-shadow 0.3s ease;
    }
    .landing-brand {
      display: flex !important;
      align-items: center !important;
      gap: 10px !important;
      text-decoration: none !important;
      width: auto !important;
    }
    .landing-brand img {
      width: 40px !important;
      height: 40px !important;
      object-fit: contain !important;
      filter: drop-shadow(0 2px 8px rgba(0, 71, 179, 0.25)) !important;
      transition: transform 0.25s ease;
    }
    .landing-brand:hover img {
      transform: scale(1.06);
    }
    .brand-text {
      font-size: 20px !important;
      font-weight: 800 !important;
      letter-spacing: -0.4px !important;
      color: #0b2447 !important;
    }
    .brand-accent {
      color: #0047b3 !important;
    }
    .brand-tld {
      color: #0284c7 !important;
      font-size: 16px !important;
      font-weight: 700 !important;
    }
    .site-header nav {
      display: flex !important;
      gap: 6px !important;
      align-items: center !important;
      background: rgba(240, 246, 255, 0.75) !important;
      border: 1px solid #dbeafe !important;
      padding: 5px 8px !important;
      border-radius: 9999px !important;
      box-shadow: inset 0 1px 2px rgba(0, 71, 179, 0.04) !important;
    }
    .site-header nav a {
      padding: 7px 16px !important;
      border-radius: 9999px !important;
      font-size: 13.5px !important;
      font-weight: 600 !important;
      color: #334155 !important;
      text-decoration: none !important;
      transition: all 0.2s ease !important;
    }
    .site-header nav a:hover {
      color: #0047b3 !important;
      background: #ffffff !important;
      box-shadow: 0 2px 8px rgba(0, 71, 179, 0.08) !important;
    }
    .site-header nav a.active {
      background: #0047b3 !important;
      color: #ffffff !important;
      font-weight: 700 !important;
      box-shadow: 0 3px 10px rgba(0, 71, 179, 0.3) !important;
    }
    .header-actions {
      display: flex !important;
      gap: 12px !important;
      align-items: center !important;
    }
    .header-actions .btn-outline {
      padding: 8px 18px !important;
      border-radius: 10px !important;
      font-size: 13.5px !important;
      font-weight: 700 !important;
      color: #0047b3 !important;
      background: #ffffff !important;
      border: 1.5px solid #cce0ff !important;
      box-shadow: 0 2px 6px rgba(0, 71, 179, 0.04) !important;
    }
    .header-actions .btn-outline:hover {
      background: #f0f6ff !important;
      border-color: #0047b3 !important;
      transform: translateY(-1px) !important;
    }
    .header-actions .btn-gradient {
      padding: 9px 22px !important;
      border-radius: 10px !important;
      font-size: 13.5px !important;
      font-weight: 700 !important;
      color: #ffffff !important;
      background: linear-gradient(136deg, #0047b3, #2563eb) !important;
      box-shadow: 0 4px 14px rgba(0, 71, 179, 0.3) !important;
    }
    .header-actions .btn-gradient:hover {
      box-shadow: 0 6px 20px rgba(0, 71, 179, 0.42) !important;
      transform: translateY(-1px) !important;
    }
    .menu-toggle {
      display: none;
      align-items: center;
      justify-content: center;
      width: 42px;
      height: 42px;
      border-radius: 10px;
      border: 1.5px solid #dbeafe;
      background: #f0f6ff;
      color: #0047b3;
      font-size: 22px;
      cursor: pointer;
    }
    @media (max-width: 992px) {
      .site-header nav {
        position: fixed !important;
        top: 74px !important;
        left: 16px !important;
        right: 16px !important;
        flex-direction: column !important;
        background: rgba(255, 255, 255, 0.98) !important;
        backdrop-filter: blur(20px) !important;
        border: 1.5px solid #dbeafe !important;
        border-radius: 18px !important;
        padding: 16px !important;
        box-shadow: 0 15px 35px -5px rgba(0, 71, 179, 0.15) !important;
        display: none !important;
      }
      .site-header nav.open {
        display: flex !important;
      }
      .site-header nav a {
        width: 100% !important;
        text-align: center !important;
        padding: 10px !important;
      }
      .menu-toggle {
        display: flex !important;
      }
    }

    /* === HERO FLOATING CARDS (SQL QUERY, PHP, JS, PYTHON) - ICY WHITE-BLUE THEME === */
    .art-5e856f96be, .art-07017a0609, .art-57e19b959a, .art-5dab2957c8 {
      background: linear-gradient(180deg, #ffffff 0%, #f4f8fe 100%) !important;
      border: 1.5px solid #cce0ff !important;
      border-radius: 14px !important;
      box-shadow: 0 14px 34px -8px rgba(0, 71, 179, 0.14), 0 2px 8px rgba(0, 0, 0, 0.03) !important;
      backdrop-filter: blur(8px) !important;
      transition: transform 0.3s ease, box-shadow 0.3s ease !important;
    }
    .art-5e856f96be:hover, .art-07017a0609:hover, .art-57e19b959a:hover, .art-5dab2957c8:hover {
      transform: translateY(-4px) scale(1.02) !important;
      box-shadow: 0 20px 40px -8px rgba(0, 71, 179, 0.22) !important;
    }
    .art-1a0ad38b4a {
      color: #64748b !important;
      font-style: italic !important;
      font-weight: 600 !important;
    }
    .art-ec5553bd5e {
      color: #6d28d9 !important; /* Ungu tema TalentGroup */
      font-weight: 800 !important;
    }
    .art-9ae671e3f9, .art-65a83c15b2 p {
      color: #d97706 !important; /* Warm amber */
      font-weight: 800 !important;
    }
    .art-94e10d5ee6 {
      color: #0d9488 !important; /* Teal */
      font-weight: 800 !important;
    }
    .art-bb7fbb4104 {
      color: #0047b3 !important; /* Royal Blue */
      font-weight: 700 !important;
    }
    .art-4dd31fa272, .art-a480443208 {
      color: #15803d !important; /* Emerald green */
      font-weight: 700 !important;
    }
    .art-4cf005bcca {
      color: #e11d48 !important; /* Rose Red */
      font-weight: 800 !important;
    }
    .art-e3d5bf9d80, .art-7f738de9be {
      color: #334155 !important;
      font-weight: 700 !important;
    }

    /* === HERO CENTER LOGO & ORBIT SYSTEM === */
    .tg-hero-center {
      position: absolute;
      inset: 0;
      display: flex;
      align-items: center;
      justify-content: center;
      pointer-events: none;
      z-index: 2;
    }
    .tg-ambient-glow {
      position: absolute;
      width: 320px;
      height: 320px;
      border-radius: 50%;
      background: radial-gradient(circle, rgba(124, 58, 237, 0.28) 0%, rgba(37, 99, 235, 0.2) 45%, rgba(255, 255, 255, 0) 75%);
      filter: blur(25px);
      animation: tgGlowPulse 4s ease-in-out infinite alternate;
      pointer-events: none;
    }
    .tg-orbit-outer {
      position: absolute;
      width: 330px;
      height: 330px;
      border-radius: 50%;
      border: 1.5px dashed rgba(59, 130, 246, 0.45);
      animation: tgSpinClockwise 28s linear infinite;
      box-shadow: 0 0 30px rgba(59, 130, 246, 0.12);
    }
    .tg-orbit-middle {
      position: absolute;
      width: 270px;
      height: 270px;
      border-radius: 50%;
      border: 1px solid rgba(139, 92, 246, 0.35);
      animation: tgSpinCounter 20s linear infinite;
    }
    .tg-orbit-particle {
      position: absolute;
      border-radius: 50%;
    }
    .tg-dot-1 {
      width: 10px;
      height: 10px;
      top: -5px;
      left: calc(50% - 5px);
      background: #00d2ff;
      box-shadow: 0 0 10px #00d2ff, 0 0 20px #0284c7;
    }
    .tg-dot-2 {
      width: 8px;
      height: 8px;
      bottom: 25px;
      right: 25px;
      background: #a855f7;
      box-shadow: 0 0 10px #a855f7;
    }
    .tg-dot-3 {
      width: 8px;
      height: 8px;
      top: 30px;
      right: 35px;
      background: #3b82f6;
      box-shadow: 0 0 10px #3b82f6;
    }
    .tg-dot-4 {
      width: 6px;
      height: 6px;
      bottom: -3px;
      left: calc(50% - 3px);
      background: #06b6d4;
      box-shadow: 0 0 8px #06b6d4;
    }
    .tg-logo-core {
      position: relative;
      width: 195px;
      height: 195px;
      display: flex;
      align-items: center;
      justify-content: center;
      animation: tgFloatLogo 4s ease-in-out infinite;
      z-index: 5;
    }
    .tg-logo-core img {
      width: 100%;
      height: 100%;
      object-fit: contain;
      filter: drop-shadow(0 16px 30px rgba(67, 56, 202, 0.3)) drop-shadow(0 4px 10px rgba(0, 71, 179, 0.2));
      transition: transform 0.3s;
    }
    @keyframes tgSpinClockwise {
      from { transform: rotate(0deg); }
      to { transform: rotate(360deg); }
    }
    @keyframes tgSpinCounter {
      from { transform: rotate(360deg); }
      to { transform: rotate(0deg); }
    }
    @keyframes tgFloatLogo {
      0%, 100% { transform: translateY(0) scale(1); }
      50% { transform: translateY(-7px) scale(1.02); }
    }
    @keyframes tgGlowPulse {
      0% { opacity: 0.55; transform: scale(0.94); }
      100% { opacity: 0.95; transform: scale(1.06); }
    }

    /* === OUR WORKS & MODERN IDE MOCKUP === */
    .works {
      background: #ffffff;
      padding: 110px 0 100px;
    }
    .works .section-intro h2 {
      color: #0b2447;
      font-size: 38px;
      font-weight: 800;
      letter-spacing: -0.5px;
    }
    .works .section-intro p {
      color: #475569;
      font-size: 16px;
    }
    .works-detail h3 {
      font-size: 30px;
      font-weight: 800;
      color: #0b2447;
      letter-spacing: -0.5px;
      margin-top: 18px;
      margin-bottom: 12px;
      line-height: 1.25;
    }
    .works-detail > p {
      color: #334155;
      font-size: 15px;
      line-height: 1.75;
      margin-bottom: 24px;
    }
    .works-detail .btn {
      font-size: 14px;
      font-weight: 700;
      padding: 13px 26px;
      border-radius: 11px;
      display: inline-flex;
      align-items: center;
      gap: 8px;
    }
    
    /* Modern Icy White-Blue IDE Card (Putih ke agak biruan serasi dengan logo) */
    .tg-ide-card {
      background: #ffffff;
      border: 1.5px solid #cce0ff;
      border-radius: 18px;
      overflow: hidden;
      box-shadow: 0 16px 36px -10px rgba(0, 71, 179, 0.12), 0 2px 10px rgba(0, 0, 0, 0.03);
      margin-bottom: 24px;
      font-family: 'Fira Code', monospace;
      text-align: left;
      transition: transform 0.25s ease, box-shadow 0.25s ease;
    }
    .tg-ide-card:hover {
      box-shadow: 0 22px 45px -10px rgba(0, 71, 179, 0.18);
    }
    .tg-ide-header {
      background: linear-gradient(180deg, #f4f8fe 0%, #e9f2fd 100%);
      padding: 12px 18px;
      display: flex;
      align-items: center;
      gap: 14px;
      border-bottom: 1.5px solid #d4e5fb;
    }
    .tg-ide-dots {
      display: flex;
      gap: 7px;
    }
    .tg-ide-dot {
      width: 11px;
      height: 11px;
      border-radius: 50%;
      display: inline-block;
    }
    .tg-ide-dot.dot-red { background: #ef4444; box-shadow: 0 0 4px rgba(239, 68, 68, 0.3); }
    .tg-ide-dot.dot-yellow { background: #f59e0b; box-shadow: 0 0 4px rgba(245, 158, 11, 0.3); }
    .tg-ide-dot.dot-green { background: #10b981; box-shadow: 0 0 4px rgba(16, 185, 129, 0.3); }
    .tg-ide-tab {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      background: #ffffff;
      color: #0b2447;
      padding: 6px 14px;
      border-radius: 8px 8px 0 0;
      font-size: 12px;
      font-weight: 700;
      border: 1px solid #cce0ff;
      border-bottom: none;
      border-top: 2.5px solid #0047b3;
      box-shadow: 0 -2px 6px rgba(0, 71, 179, 0.04);
    }
    .tg-tab-badge {
      background: #e6f0ff;
      color: #0047b3;
      font-size: 10px;
      font-weight: 700;
      padding: 2px 7px;
      border-radius: 4px;
      border: 1px solid #bfdbfe;
    }
    .tg-ide-status {
      margin-left: auto;
      font-size: 11px;
      font-weight: 700;
      color: #059669;
    }
    .tg-ide-body {
      display: flex;
      padding: 18px 16px;
      background: linear-gradient(180deg, #fbfdff 0%, #f0f6ff 100%);
      color: #1e293b;
      font-size: 13.5px;
      line-height: 1.75;
      overflow-x: auto;
    }
    .tg-line-numbers {
      display: flex;
      flex-direction: column;
      color: #94a3b8;
      padding-right: 18px;
      margin-right: 16px;
      border-right: 1.5px solid #dbeafe;
      user-select: none;
      font-size: 12px;
    }
    .tg-code-content {
      margin: 0;
      padding: 0;
      font-family: inherit;
      color: #1e293b;
      white-space: pre;
    }
    .tg-c-comment { color: #64748b; font-style: italic; }
    .tg-c-tag { color: #e11d48; font-weight: 800; }
    .tg-c-kw { color: #6d28d9; font-weight: 800; }
    .tg-c-ns { color: #0284c7; font-weight: 600; }
    .tg-c-class { color: #d97706; font-weight: 800; }
    .tg-c-type { color: #0284c7; font-weight: 700; }
    .tg-c-var { color: #0047b3; font-weight: 700; }
    .tg-c-fn { color: #0d9488; font-weight: 800; }
    .tg-c-str { color: #15803d; font-weight: 700; }

    /* === GAME EDU & 8 BAHASA ENHANCEMENT (Kebiruan Lembut seperti Hero Content) === */
    .game-section {
      background: radial-gradient(circle at 50% 0%, rgba(2, 132, 199, 0.08) 0%, transparent 65%),
                  linear-gradient(180deg, #e8f1fd 0%, #edf5ff 55%, #f4f8fe 100%) !important;
      border-top: 1px solid #d4e5fb !important;
      border-bottom: 1px solid #d4e5fb !important;
      padding: 95px 0 !important;
      position: relative !important;
    }
    .game-section .section-intro h2 {
      color: #0b2447;
      font-size: 38px;
      font-weight: 800;
      letter-spacing: -0.5px;
      margin-top: 10px;
    }
    .game-section .section-intro p {
      color: #475569;
      font-size: 16px;
      margin-top: 10px;
    }
    .eyebrow-badge {
      display: inline-block;
      padding: 6px 16px;
      border-radius: 9999px;
      background: #e0e7ff;
      color: #4338ca;
      font-family: 'Fira Code', monospace;
      font-size: 11px;
      font-weight: 700;
      letter-spacing: 1.5px;
      border: 1px solid #c7d2fe;
    }
    .challenge-window {
      background: #ffffff;
      border: 1.5px solid #cce0ff;
      border-radius: 20px;
      box-shadow: 0 16px 36px -10px rgba(0, 71, 179, 0.12), 0 2px 10px rgba(0, 0, 0, 0.03);
      overflow: hidden;
      transition: transform 0.25s ease, box-shadow 0.25s ease;
    }
    .challenge-window:hover {
      box-shadow: 0 22px 45px -10px rgba(0, 71, 179, 0.18);
    }
    .window-bar {
      background: linear-gradient(180deg, #f4f8fe 0%, #e9f2fd 100%);
      border-bottom: 1.5px solid #d4e5fb;
      font-size: 12px;
      font-weight: 700;
      color: #0b2447;
      padding: 12px 18px;
    }
    .challenge-task {
      color: #1e3a63;
      font-weight: 600;
      font-size: 12px;
      margin-bottom: 14px;
    }
    .challenge-code {
      background: linear-gradient(180deg, #fbfdff 0%, #f0f6ff 100%);
      border: 1.5px solid #cce0ff;
      color: #1e293b;
      font-size: 13.5px;
      line-height: 1.7;
      border-radius: 12px;
      box-shadow: inset 0 1px 3px rgba(0, 71, 179, 0.04);
      padding: 18px;
    }
    .challenge-code > span { color: #e11d48; font-weight: 800; }
    .challenge-code b { color: #6d28d9; font-weight: 800; }
    .challenge-code em { color: #0047b3; font-weight: 700; font-style: normal; }
    .game-output {
      background: linear-gradient(180deg, #f0fdf4 0%, #e8f9ed 100%);
      border: 1.5px solid #bbf7d0;
      color: #15803d;
      border-radius: 12px;
      font-size: 13px;
      font-weight: 600;
      padding: 16px 18px;
      box-shadow: inset 0 1px 3px rgba(21, 128, 61, 0.04);
    }
    .challenge-form input {
      border: 1.5px solid #cce0ff;
      border-radius: 10px;
      padding: 11px 16px;
      font-size: 12.5px;
      background: #ffffff;
      color: #0b2447;
      font-weight: 600;
      transition: border-color 0.2s, box-shadow 0.2s;
    }
    .challenge-form input:focus {
      outline: none;
      border-color: #0047b3;
      box-shadow: 0 0 0 3px rgba(0, 71, 179, 0.15);
    }
    .challenge-form .btn {
      background: linear-gradient(136deg, #0047b3, #2563eb);
      color: #ffffff;
      border-radius: 10px;
      font-weight: 700;
      padding: 11px 20px;
      box-shadow: 0 4px 14px rgba(0, 71, 179, 0.28);
      transition: all 0.25s ease;
    }
    .challenge-form .btn:hover {
      box-shadow: 0 6px 18px rgba(0, 71, 179, 0.4);
      transform: translateY(-2px);
    }
    .game-copy h3 {
      font-size: 28px;
      font-weight: 800;
      color: #0b2447;
      letter-spacing: -0.3px;
      margin-bottom: 12px;
    }
    .game-copy > p {
      color: #475569;
      font-size: 15px;
      line-height: 1.65;
    }

    /* Vibrant, User-Friendly Language Badges */
    .language-tags {
      display: flex;
      flex-wrap: wrap;
      gap: 10px;
      margin-top: 20px;
      margin-bottom: 28px;
    }
    .language-tags span {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      padding: 7px 16px;
      border-radius: 9999px;
      font-size: 12px;
      font-weight: 700;
      transition: all 0.2s ease;
      cursor: default;
    }
    .language-tags span:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }
    .language-tags .php { background: #eef2ff; border: 1.5px solid #c7d2fe; color: #4338ca; }
    .language-tags .javascript { background: #fefce8; border: 1.5px solid #fef08a; color: #854d0e; }
    .language-tags .python { background: #f0f9ff; border: 1.5px solid #bae6fd; color: #0369a1; }
    .language-tags .java { background: #fff7ed; border: 1.5px solid #fed7aa; color: #c2410c; }
    .language-tags .css { background: #faf5ff; border: 1.5px solid #e9d5ff; color: #7e22ce; }
    .language-tags .sql { background: #ecfdf5; border: 1.5px solid #a7f3d0; color: #047857; }
    .language-tags .cpp { background: #eff6ff; border: 1.5px solid #bfdbfe; color: #1d4ed8; }
    .language-tags .rust { background: #fef2f2; border: 1.5px solid #fecaca; color: #b91c1c; }

    /* Modern Elevated Stat Cards */
    .game-stats {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 16px;
      margin-top: 20px;
    }
    .game-stats > div {
      background: #ffffff;
      border: 1.5px solid #cce0ff;
      border-radius: 16px;
      padding: 16px 12px;
      text-align: center;
      box-shadow: 0 4px 14px rgba(11, 36, 71, 0.04);
      transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;
    }
    .game-stats > div:hover {
      transform: translateY(-3px);
      border-color: #0047b3;
      box-shadow: 0 10px 24px rgba(0, 71, 179, 0.09);
    }
    .game-stats > div:hover {
      transform: translateY(-3px);
      border-color: #0047b3;
      box-shadow: 0 10px 24px rgba(0, 71, 179, 0.09);
    }
    .game-stats strong {
      display: block;
      color: #0047b3;
      font-size: 26px;
      font-weight: 800;
      letter-spacing: -0.5px;
    }
    .game-stats span {
      display: block;
      font-size: 12px;
      font-weight: 600;
      color: #64748b;
      margin-top: 4px;
    }

    /* === COURSES SECTION (Kebiruan Lembut seperti Hero Content) === */
    .courses {
      background: radial-gradient(circle at 50% 0%, rgba(2, 132, 199, 0.08) 0%, transparent 65%),
                  linear-gradient(180deg, #e8f1fd 0%, #edf5ff 55%, #f4f8fe 100%) !important;
      border-top: 1px solid #d4e5fb !important;
      border-bottom: 1px solid #d4e5fb !important;
      padding: 95px 0 90px !important;
      position: relative !important;
    }
    .courses .course-heading h2 {
      color: #0b2447 !important;
      font-size: 38px !important;
      font-weight: 800 !important;
      letter-spacing: -0.5px !important;
    }
    .courses .eyebrow {
      font-family: 'Fira Code', monospace !important;
      font-size: 11px !important;
      font-weight: 800 !important;
      color: #0047b3 !important;
      letter-spacing: 1.5px !important;
    }
    .courses .subtle-link {
      color: #0047b3 !important;
      font-weight: 700 !important;
      transition: color 0.2s ease, transform 0.2s ease !important;
    }
    .courses .subtle-link:hover {
      color: #0284c7 !important;
      transform: translateX(3px) !important;
    }
    .course-card {
      background: #ffffff !important;
      border: 1.5px solid #cce0ff !important;
      border-radius: 18px !important;
      overflow: hidden !important;
      box-shadow: 0 8px 24px -4px rgba(0, 71, 179, 0.08), 0 2px 6px rgba(0, 0, 0, 0.02) !important;
      transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease !important;
    }
    .course-card:hover {
      transform: translateY(-6px) !important;
      border-color: #0047b3 !important;
      box-shadow: 0 18px 36px -6px rgba(0, 71, 179, 0.18) !important;
    }
    .carousel-arrow {
      background: #ffffff !important;
      border: 1.5px solid #cce0ff !important;
      color: #0047b3 !important;
      box-shadow: 0 4px 14px rgba(0, 71, 179, 0.12) !important;
      transition: all 0.2s ease !important;
    }
    .carousel-arrow:hover {
      background: #0047b3 !important;
      color: #ffffff !important;
      border-color: #0047b3 !important;
      box-shadow: 0 8px 20px rgba(0, 71, 179, 0.28) !important;
      transform: scale(1.08) !important;
    }
    .course-cover {
      height: 200px;
      background: linear-gradient(135deg, #f8fafc 0%, #edf4fc 100%);
      position: relative;
      display: flex;
      align-items: center;
      justify-content: center;
      overflow: hidden;
      padding: 14px;
      border-bottom: 1px solid #e2e8f0;
    }
    .course-cover img, .course-cover > img {
      width: 100%;
      height: 100%;
      object-fit: contain !important;
      object-position: center;
      transition: transform 0.3s ease;
      filter: drop-shadow(0 4px 10px rgba(0, 71, 179, 0.08));
    }
    .course-card:hover .course-cover img, .course-card:hover .course-cover > img {
      transform: scale(1.04);
    }
    .course-body {
      padding: 20px;
      display: flex;
      flex-direction: column;
      gap: 10px;
    }
    .course-body h3 {
      font-size: 17px;
      font-weight: 800;
      color: #0b2447;
      line-height: 1.35;
      display: -webkit-box;
      -webkit-line-clamp: 2;
      -webkit-box-orient: vertical;
      overflow: hidden;
      min-height: 44px;
    }
    .course-kicker {
      font-family: 'Fira Code', monospace;
      font-size: 11px;
      color: #0047b3;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }
    .course-meta {
      font-size: 13px;
      color: #5f6f8c;
      display: flex;
      align-items: center;
      gap: 8px;
    }
    .course-price {
      font-size: 16px;
      font-weight: 800;
      color: #00408c;
      margin-top: 4px;
    }
    .course-price.free-text {
      color: #0f8a5f;
    }
    .course-detail-btn {
      width: 100%;
      padding: 10px 16px;
      border-radius: 9px;
      font-weight: 700;
      font-size: 13px;
      background: #e6f0ff;
      color: #0047b3;
      border: 1px solid #bfdbfe;
      text-align: center;
      transition: all 0.2s;
      cursor: pointer;
      display: inline-flex;
      align-items: center;
      justify-content: center;
    }
    .course-detail-btn:hover {
      background: #0047b3;
      color: #ffffff;
      border-color: #0047b3;
    }
    /* === ABOUT SECTION (Kebiruan Lembut seperti Hero Content) === */
    .about {
      background: radial-gradient(circle at 50% 0%, rgba(2, 132, 199, 0.08) 0%, transparent 65%),
                  linear-gradient(180deg, #e8f1fd 0%, #edf5ff 55%, #f4f8fe 100%) !important;
      border-top: 1px solid #d4e5fb !important;
      padding: 95px 0 90px !important;
      position: relative !important;
    }
    .about .section-intro h2 {
      color: #0b2447 !important;
      font-size: 38px !important;
      font-weight: 800 !important;
      letter-spacing: -0.5px !important;
    }
    .about .section-intro .eyebrow {
      font-family: 'Fira Code', monospace !important;
      font-size: 11px !important;
      font-weight: 800 !important;
      color: #0047b3 !important;
      letter-spacing: 1.5px !important;
    }
    .about .section-intro p {
      color: #475569 !important;
      font-size: 16px !important;
    }
    .benefit {
      background: #ffffff !important;
      border: 1.5px solid #e2e8f0 !important;
      border-radius: 20px !important;
      padding: 30px 26px !important;
      box-shadow: 0 4px 20px -2px rgba(11, 36, 71, 0.05), 0 2px 6px -1px rgba(11, 36, 71, 0.03) !important;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
      display: flex !important;
      flex-direction: column !important;
      position: relative !important;
      overflow: hidden !important;
    }
    .benefit::before {
      content: '' !important;
      position: absolute !important;
      top: 0 !important;
      left: 0 !important;
      right: 0 !important;
      height: 3px !important;
      background: linear-gradient(90deg, #0284c7, #38bdf8) !important;
      opacity: 0 !important;
      transition: opacity 0.3s ease !important;
    }
    .benefit:hover {
      transform: translateY(-6px) !important;
      border-color: #0284c7 !important;
      box-shadow: 0 20px 35px -6px rgba(2, 132, 199, 0.18), 0 0 0 1px #0284c7 !important;
    }
    .benefit:hover::before {
      opacity: 1 !important;
    }
    .benefit>img,
    .benefit-icon-wrapper {
      width: 56px !important;
      height: 56px !important;
      padding: 12px !important;
      background: linear-gradient(135deg, #0284c7 0%, #0047b3 100%) !important;
      border: 1.5px solid rgba(255, 255, 255, 0.4) !important;
      border-radius: 16px !important;
      object-fit: contain !important;
      display: inline-flex !important;
      align-items: center !important;
      justify-content: center !important;
      box-shadow: 0 8px 20px -3px rgba(2, 132, 199, 0.42), 0 2px 6px rgba(0, 71, 179, 0.2) !important;
      margin-bottom: 20px !important;
      transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1) !important;
      filter: drop-shadow(0 2px 4px rgba(0,0,0,0.18)) !important;
    }
    .benefit-icon-wrapper img {
      width: 32px !important;
      height: 32px !important;
      object-fit: contain !important;
      filter: drop-shadow(0 1px 3px rgba(0,0,0,0.2)) !important;
      margin-bottom: 0 !important;
      padding: 0 !important;
      border: none !important;
      background: transparent !important;
      box-shadow: none !important;
    }
    .benefit:hover>img,
    .benefit:hover .benefit-icon-wrapper {
      transform: scale(1.08) rotate(-2deg) !important;
    }
    .benefit h3 {
      color: #0f172a !important;
      font-size: 19px !important;
      font-weight: 800 !important;
      letter-spacing: -0.3px !important;
      margin-top: 0 !important;
      margin-bottom: 10px !important;
      transition: color 0.2s ease !important;
    }
    .benefit:hover h3 {
      color: #0284c7 !important;
    }
    .benefit p {
      color: #475569 !important;
      font-size: 14px !important;
      line-height: 1.65 !important;
      margin: 0 !important;
    }
    /* Themed Vibrant Icon Tiles for Light Mode — AAA Contrast & Modern Branding */
    .benefit:nth-child(1)>img,
    .benefit-1 .benefit-icon-wrapper {
      background: linear-gradient(135deg, #0284c7 0%, #0047b3 100%) !important;
      box-shadow: 0 8px 20px -3px rgba(2, 132, 199, 0.45), 0 2px 6px rgba(0, 71, 179, 0.2) !important;
    }
    .benefit:nth-child(2)>img,
    .benefit-2 .benefit-icon-wrapper {
      background: linear-gradient(135deg, #6366f1 0%, #4338ca 100%) !important;
      box-shadow: 0 8px 20px -3px rgba(99, 102, 241, 0.45), 0 2px 6px rgba(67, 56, 202, 0.2) !important;
    }
    .benefit:nth-child(3)>img,
    .benefit-3 .benefit-icon-wrapper {
      background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%) !important;
      box-shadow: 0 8px 20px -3px rgba(14, 165, 233, 0.45), 0 2px 6px rgba(2, 132, 199, 0.2) !important;
    }
    .benefit:nth-child(4)>img,
    .benefit-4 .benefit-icon-wrapper {
      background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%) !important;
      box-shadow: 0 8px 20px -3px rgba(245, 158, 11, 0.45), 0 2px 6px rgba(217, 119, 6, 0.2) !important;
    }
    .benefit:nth-child(5)>img,
    .benefit-5 .benefit-icon-wrapper {
      background: linear-gradient(135deg, #10b981 0%, #047857 100%) !important;
      box-shadow: 0 8px 20px -3px rgba(16, 185, 129, 0.45), 0 2px 6px rgba(4, 120, 87, 0.2) !important;
    }
    .benefit:nth-child(6)>img,
    .benefit-6 .benefit-icon-wrapper {
      background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%) !important;
      box-shadow: 0 8px 20px -3px rgba(59, 130, 246, 0.45), 0 2px 6px rgba(29, 78, 216, 0.2) !important;
    }
    .site-footer {
      background: #0b2447;
      color: #f1f5f9;
      padding: 60px 0 30px;
    }
    .site-footer a, .site-footer button {
      color: #94a3b8;
      transition: color 0.2s ease;
    }
    .site-footer a:hover, .site-footer button:hover {
      color: #ffffff;
    }
    .footer-grid {
      display: flex !important;
      justify-content: space-between !important;
      align-items: flex-start !important;
      gap: 50px !important;
      flex-wrap: wrap !important;
    }
    .footer-brand-column {
      flex: 1 1 420px !important;
      max-width: 520px !important;
    }
    .footer-brand strong {
      color: #ffffff;
    }
    .footer-brand-column p {
      color: #cbd5e1;
      font-size: 14px;
      line-height: 1.7;
    }
    .footer-links {
      flex: 0 0 auto !important;
      min-width: 180px !important;
    }
    .footer-links h3 {
      color: #ffffff;
      font-size: 13px;
      font-weight: 700;
      letter-spacing: 1.2px;
      margin-bottom: 14px;
    }
    .footer-links a {
      font-size: 14px;
      line-height: 2;
    }
    .footer-bottom {
      border-top: 1px solid rgba(255,255,255,0.1);
      color: #94a3b8;
      text-align: center;
      padding-top: 24px;
      margin-top: 40px;
      font-size: 13px;
    }
    @media (max-width: 768px) {
      .footer-grid {
        flex-direction: column !important;
        gap: 32px !important;
      }
      .footer-brand-column {
        flex: 1 1 100% !important;
        max-width: 100% !important;
      }
      .footer-links {
        width: 100% !important;
      }
    }
  </style>
</head>
<body>
  <a href="#main-content" class="skip-link">Lewati ke konten</a>

  <div id="landing-view">
    <header class="site-header">
      <a class="landing-brand" href="{{ route('home') }}" aria-label="TalentGroup.id, beranda">
        <img src="{{ asset('tg/assets/logo-talentgroup-clean.png') }}" alt="Logo TalentGroup" width="40" height="40">
        <span class="brand-text">Talent<span class="brand-accent">Group</span><span class="brand-tld">.id</span></span>
      </a>

      <nav id="site-nav" aria-label="Navigasi utama">
        <a class="active" href="#home">Home</a>
        <a href="#our-works">Our Works</a>
        <a href="#game-edu">Game Edu</a>
        <a href="#courses">Kelas</a>
        <a href="#about">About</a>
        <a href="{{ route('modules.index') }}">Dokumentasi Modul</a>
        @guest
          <div class="mobile-nav-auth" style="display: none; padding-top: 12px; margin-top: 8px; border-top: 1px solid rgba(0, 71, 179, 0.15); width: 100%;">
            <div style="display: flex; gap: 8px;">
              <a href="{{ route('login') }}" class="btn btn-small btn-outline" style="flex: 1; text-align: center;">Masuk</a>
              <a href="{{ route('register') }}" class="btn btn-small btn-gradient" style="flex: 1; text-align: center;">Daftar Gratis</a>
            </div>
          </div>
        @endguest
      </nav>

      <div class="header-actions">
        <!-- Theme Mode Toggle Button -->
        <button id="themeToggleLanding" class="landing-theme-toggle" aria-label="Ganti Tema (Light / Dark)" title="Ganti Mode Tampilan (Night / Day)">
            <div class="landing-toggle-thumb">
                <i class="fas fa-sun landing-sun-icon"></i>
                <i class="fas fa-moon landing-moon-icon" style="display: none;"></i>
            </div>
        </button>

        @guest
          <a href="{{ route('login') }}" class="btn btn-small btn-outline">Masuk</a>
          <a href="{{ route('register') }}" class="btn btn-small btn-gradient">Daftar Gratis</a>
        @else
          @if(auth()->user()->isAdmin())
            <a href="{{ route('admin.dashboard') }}" class="btn btn-small btn-gradient">
              <i class="fas fa-user-shield"></i> Dasbor Admin
            </a>
          @else
            <a href="{{ route('user.dashboard') }}" class="btn btn-small btn-gradient">
              <i class="fas fa-columns"></i> Ruang Belajar
            </a>
          @endif
        @endguest

        <button class="menu-toggle" id="menu-toggle" aria-label="Buka menu navigasi" aria-expanded="false" aria-controls="site-nav">
          <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
        </button>
      </div>
    </header>

    <main id="main-content">
      <!-- HERO SECTION -->
      <section class="hero" id="home">
        <div class="hero-inner container">
          <div class="hero-copy">
            <h1>Raih Ilmu,<br><span>Kuasai Kode.</span></h1>
            <p>talentgroup.id menghadirkan pengalaman belajar pemrograman yang <strong>imersif, interaktif, dan menyenangkan</strong> — dari PHP hingga AI, semua dalam satu platform.</p>
            <div class="hero-buttons">
              @guest
                <a class="btn btn-gradient" href="{{ route('register') }}">Mulai Belajar Gratis</a>
              @else
                <a class="btn btn-gradient" href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('user.dashboard') }}">Buka Ruang Belajar</a>
              @endguest
              <a class="btn btn-glass" href="#courses">▷ Lihat Kelas</a>
            </div>
            <div class="hero-stats">
              <div><strong>10K+</strong><span>Pelajar Aktif</span></div>
              <div><strong>50+</strong><span>Kursus Tersedia</span></div>
              <div><strong>8</strong><span>Bahasa Pemrograman</span></div>
            </div>
          </div>

          <div class="hero-visual" aria-label="Ilustrasi logo TalentGroup dengan kartu kode PHP, JavaScript, Python, dan SQL">
            <!-- Mobile Specific Visual (Clean, Sharp, High Readability & Interactive) -->
            <div class="tg-hero-mobile-wrapper">
              <div class="tg-hero-mobile-hub">
                <div class="tg-mobile-glow"></div>
                <div class="tg-mobile-orbit">
                  <span class="tg-orbit-particle tg-dot-1"></span>
                  <span class="tg-orbit-particle tg-dot-2"></span>
                </div>
                <div class="tg-mobile-logo">
                  <img src="{{ asset('tg/assets/logo-talentgroup-clean.png') }}" alt="Logo TalentGroup.id">
                </div>
                <div class="tg-m-tag tag-left">
                  <span class="m-dot live"></span>
                  <span>100% Interaktif</span>
                </div>
                <div class="tg-m-tag tag-right">
                  <span>🚀</span>
                  <span>Siap Industri</span>
                </div>
              </div>

              <!-- Kartu Snippet Kode Khusus Mobile: Font Jelas & Rapi -->
              <div class="tg-mobile-snippet">
                <div class="tg-msnip-bar">
                  <div class="tg-msnip-dots"><i></i><i></i><i></i></div>
                  <span class="tg-msnip-title">academy.php</span>
                  <span class="tg-msnip-badge">PHP 8.2</span>
                </div>
                <div class="tg-msnip-code">
                  <div class="code-row"><span class="c-kw">class</span> <span class="c-cls">TalentGroup</span> <span class="c-brk">{</span></div>
                  <div class="code-row indent"><span class="c-kw">public</span> <span class="c-var">$skill</span> = <span class="c-str">"Kuasai Kode"</span>;</div>
                  <div class="code-row"><span class="c-brk">}</span> <span class="c-cmt">// ✓ Siap Kerja</span></div>
                </div>
              </div>
            </div>

            <!-- Desktop Visual Container (Hidden on Mobile) -->
            <div class="art-a71a31c5e8 tg-desktop-visual" data-node-id="60:23">
              <div class="art-50f839f91a" data-node-id="60:24">
                <div class="art-853575f8b5">
                  <div class="art-5e856f96be">
                    <div class="art-9e43210fd7" data-node-id="60:25"><p class="art-1a0ad38b4a">// PHP Class</p></div>
                    <div class="art-35d03bfdd5" data-node-id="60:26"><p class="art-da39a3ee5e"><span class="art-ec5553bd5e">class</span><span class="art-7f738de9be"> </span><span class="art-9ae671e3f9">talentgroup</span><span class="art-7f738de9be"> </span><span class="art-e3d5bf9d80">{</span></p></div>
                    <div class="art-8f0736016e" data-node-id="60:27"><p class="art-da39a3ee5e"><span class="art-ec5553bd5e">return</span><span class="art-7f738de9be"> </span><span class="art-4dd31fa272">&quot;mastered&quot;</span><span class="art-e3d5bf9d80">;</span></p></div>
                    <div class="art-fbddea82c8" data-node-id="60:28"><p class="art-ec5553bd5e">}</p></div>
                    <div class="art-b8e02df89b" data-node-id="60:29"><p class="art-ec5553bd5e">}</p></div>
                    <div class="art-328c2ca78f" data-node-id="60:30">
                      <div class="art-698fce0848" data-node-id="60:31">
                        <p class="art-da39a3ee5e"><span class="art-ec5553bd5e">public</span><span class="art-7f738de9be"> </span><span class="art-94e10d5ee6">learn</span><span class="art-e3d5bf9d80">(</span><span class="art-bb7fbb4104">$skill</span><span class="art-e3d5bf9d80">)</span><span class="art-7f738de9be"> </span><span class="art-e3d5bf9d80">{</span></p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="art-096074ece9" data-node-id="60:32">
                <div class="art-98f663a920">
                  <div class="art-07017a0609">
                    <div class="art-d259297e9f" data-node-id="60:33"><p class="art-1a0ad38b4a">// JavaScript</p></div>
                    <div class="art-16eed93197" data-node-id="60:34"><p class="art-da39a3ee5e"><span class="art-ec5553bd5e">const</span><span class="art-7f738de9be"> </span><span class="art-bb7fbb4104">fetch</span><span class="art-7f738de9be"> </span><span class="art-e3d5bf9d80">=</span><span class="art-7f738de9be"> </span><span class="art-ec5553bd5e">async</span><span class="art-7f738de9be"> </span><span class="art-e3d5bf9d80">()</span><span class="art-7f738de9be"> </span><span class="art-e3d5bf9d80">=&gt;</span><span class="art-7f738de9be"> </span><span class="art-e3d5bf9d80">{</span></p></div>
                    <div class="art-603f7d959d" data-node-id="60:35"><p class="art-da39a3ee5e"><span class="art-ec5553bd5e">console</span><span class="art-e3d5bf9d80">.</span><span class="art-ec5553bd5e">log</span><span class="art-e3d5bf9d80">(</span><span class="art-4dd31fa272">&quot;✓ done&quot;</span><span class="art-e3d5bf9d80">);</span></p></div>
                    <div class="art-4845702fbe" data-node-id="60:36"><p class="art-ec5553bd5e">}</p></div>
                    <div class="art-90f8a845d5" data-node-id="60:37">
                      <div class="art-5f80a5fe5d" data-node-id="60:38">
                        <p class="art-da39a3ee5e"><span class="art-ec5553bd5e">await</span><span class="art-7f738de9be"> </span><span class="art-94e10d5ee6">learn</span><span class="art-e3d5bf9d80">(</span><span class="art-4dd31fa272">&#x27;php&#x27;</span><span class="art-e3d5bf9d80">);</span></p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="art-57e19b959a" data-node-id="60:39">
                <div class="art-fd19598061" data-node-id="60:40"><p class="art-1a0ad38b4a">// Python</p></div>
                <div class="art-ae9e064c1e" data-node-id="60:41"><p class="art-da39a3ee5e"><span class="art-ec5553bd5e">def</span><span class="art-7f738de9be"> </span><span class="art-94e10d5ee6">course</span><span class="art-e3d5bf9d80">(</span><span class="art-bb7fbb4104">lang</span><span class="art-e3d5bf9d80">):</span></p></div>
                <div class="art-53df84ccb7" data-node-id="60:42">
                  <p class="art-ef0b7a1148"><span class="art-ec5553bd5e">skills</span><span class="art-e3d5bf9d80">.</span><span class="art-94e10d5ee6">append</span><span class="art-e3d5bf9d80">(</span><span class="art-ec5553bd5e">lang</span><span class="art-e3d5bf9d80">)</span></p>
                  <p class="art-da39a3ee5e"><span class="art-a480443208">return</span><span class="art-7f738de9be"> </span><span class="art-ec5553bd5e">skills</span></p>
                </div>
                <div class="art-a794326f76" data-node-id="60:43">
                  <div class="art-9badc656fb" data-node-id="60:44"><p class="art-da39a3ee5e"><span class="art-ec5553bd5e">skills</span><span class="art-7f738de9be"> </span><span class="art-e3d5bf9d80">=</span><span class="art-7f738de9be"> </span><span class="art-e3d5bf9d80">[]</span></p></div>
                </div>
              </div>
              <div class="art-5b561bd045" data-node-id="60:45">
                <div class="art-3eb2ad3e75">
                  <div class="art-5dab2957c8">
                    <div class="art-9e43210fd7" data-node-id="60:46"><p class="art-1a0ad38b4a">// SQL Query</p></div>
                    <div class="art-264854637e" data-node-id="60:47"><p class="art-da39a3ee5e"><span class="art-ec5553bd5e">SELECT</span><span class="art-7f738de9be"> </span><span class="art-e3d5bf9d80">*</span><span class="art-7f738de9be"> </span><span class="art-ec5553bd5e">FROM</span></p></div>
                    <div class="art-339d943c88" data-node-id="60:48">
                      <p class="art-ef0b7a1148"><span class="art-ec5553bd5e">WHERE</span><span class="art-7f738de9be"> </span><span class="art-bb7fbb4104">progress</span><span class="art-7f738de9be"> </span><span class="art-e3d5bf9d80">=</span><span class="art-7f738de9be"> </span><span class="art-4cf005bcca">100</span></p>
                      <p class="art-da39a3ee5e"><span class="art-ec5553bd5e">ORDER BY</span><span class="art-7f738de9be"> </span><span class="art-bb7fbb4104">skill</span><span class="art-7f738de9be"> </span><span class="art-ec5553bd5e">DESC</span><span class="art-e3d5bf9d80">;</span></p>
                    </div>
                    <div class="art-a794326f76" data-node-id="60:49">
                      <div class="art-65a83c15b2" data-node-id="60:50"><p class="art-ec5553bd5e">students</p></div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="art-b5a23e4bda tg-hero-center" data-node-id="60:120">
                <!-- Ambient Glow Behind Logo -->
                <div class="tg-ambient-glow"></div>

                <!-- Outer Orbit Ring (Smooth clockwise rotation) -->
                <div class="tg-orbit-outer">
                  <span class="tg-orbit-particle tg-dot-1"></span>
                  <span class="tg-orbit-particle tg-dot-2"></span>
                </div>

                <!-- Middle Orbit Ring (Smooth counter-clockwise rotation) -->
                <div class="tg-orbit-middle">
                  <span class="tg-orbit-particle tg-dot-3"></span>
                  <span class="tg-orbit-particle tg-dot-4"></span>
                </div>

                <!-- Center Core Logo Badge (Clean, Floating, Upright & Crisp) -->
                <div class="tg-logo-core">
                  <img src="{{ asset('tg/assets/logo-talentgroup-clean.png') }}" alt="Logo TalentGroup.id">
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- OUR WORKS SECTION -->
      <section class="works section" id="our-works">
        <div class="container">
          <div class="section-intro">
            <span class="eyebrow-badge">OUR WORKS</span>
            <h2 style="margin-top: 14px;">Mengenal talentgroup.id<br>Lebih Dekat</h2>
            <p>Platform edukasi digital modern yang dirancang untuk mempersiapkan talenta digital<br class="desktop-br"> Indonesia menghadapi era industri 4.0.</p>
          </div>
          <div class="works-grid">
            <div class="technology-grid" aria-label="Bahasa pemrograman yang tersedia">
              <a href="#courses" class="technology php">
                <div class="technology-symbol"><img src="{{ asset('tg/assets/60-2-img-vector15.svg') }}" alt="" width="52" height="32"><b>php</b></div>
                <span>PHP</span>
              </a>
              <a href="#courses" class="technology javascript">
                <div class="technology-symbol"><img src="{{ asset('tg/assets/60-2-img-svg.svg') }}" alt="" width="54" height="54"></div>
                <span>JavaScript</span>
              </a>
              <a href="#courses" class="technology python">
                <div class="technology-symbol"><img src="{{ asset('tg/assets/60-2-img-vector16.svg') }}" alt="" width="50" height="50"><b>Python</b></div>
                <span>Python</span>
              </a>
              <a href="#courses" class="technology java">
                <div class="technology-symbol"><img src="{{ asset('tg/assets/60-2-img-vector17.svg') }}" alt="" width="48" height="48"><b>Java</b></div>
                <span>Java</span>
              </a>
              <a href="#courses" class="technology css">
                <div class="technology-symbol"><img src="{{ asset('tg/assets/60-2-img-svg1.svg') }}" alt="" width="54" height="54"></div>
                <span>CSS</span>
              </a>
              <a href="#courses" class="technology sql">
                <div class="technology-symbol"><img src="{{ asset('tg/assets/60-2-img-vector18.svg') }}" alt="" width="50" height="50"><b>SQL</b></div>
                <span>SQL</span>
              </a>
            </div>

            <div class="works-detail">
              <!-- Modern IDE Preview Card -->
              <div class="tg-ide-card" aria-label="Contoh kode kelas Student dalam PHP">
                <div class="tg-ide-header">
                  <div class="tg-ide-dots">
                    <span class="tg-ide-dot dot-red"></span>
                    <span class="tg-ide-dot dot-yellow"></span>
                    <span class="tg-ide-dot dot-green"></span>
                  </div>
                  <div class="tg-ide-tab">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line></svg>
                    <span>talentgroup.php</span>
                    <span class="tg-tab-badge">PHP 8.2</span>
                  </div>
                  <span class="tg-ide-status">● Live Active</span>
                </div>
                <div class="tg-ide-body">
                  <div class="tg-line-numbers">
                    <span>1</span><span>2</span><span>3</span><span>4</span><span>5</span><span>6</span><span>7</span><span>8</span><span>9</span><span>10</span><span>11</span><span>12</span><span>13</span><span>14</span>
                  </div>
                  <pre class="tg-code-content"><code><span class="tg-c-comment">// talentgroup.id — Platform Coding #1</span>
<span class="tg-c-tag">&lt;?php</span>

<span class="tg-c-kw">namespace</span> <span class="tg-c-ns">talentgroup\Academy</span>;

<span class="tg-c-kw">class</span> <span class="tg-c-class">StudentCareer</span> {
    <span class="tg-c-kw">protected</span> <span class="tg-c-type">array</span> <span class="tg-c-var">$skills</span> = [];

    <span class="tg-c-kw">public function</span> <span class="tg-c-fn">enroll</span>(<span class="tg-c-class">Course</span> <span class="tg-c-var">$course</span>): <span class="tg-c-type">void</span> {
        <span class="tg-c-var">$this</span>-&gt;<span class="tg-c-var">skills</span>[] = <span class="tg-c-var">$course</span>-&gt;<span class="tg-c-fn">getSkill</span>();
        <span class="tg-c-var">$this</span>-&gt;<span class="tg-c-fn">notify</span>(<span class="tg-c-str">'enrolled'</span>);
    }
}</code></pre>
                </div>
              </div>

              <h3>Platform Edukasi Coding Terbaik</h3>
              <p>talentgroup.id menyediakan kursus pemrograman interaktif, game edukatif, dan komunitas belajar yang aktif. Mulai dari PHP hingga Machine Learning — semua tersedia dengan kurikulum berbasis industri.</p>
              @guest
                <a href="{{ route('register') }}" class="btn btn-gradient">
                  <span>Bergabung Sekarang</span>
                  <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                </a>
              @else
                <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('user.dashboard') }}" class="btn btn-gradient">
                  <span>Buka Ruang Belajar</span>
                  <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                </a>
              @endguest
            </div>
          </div>
        </div>
      </section>

      <!-- GAME EDU SECTION -->
      <section class="game-section section" id="game-edu">
        <div class="container">
          <div class="section-intro centered">
            <span class="eyebrow-badge">GAME EDU</span>
            <h2>Belajar Lewat Game Seru</h2>
            <p>Tantang dirimu dengan game coding interaktif — selesaikan misi, kumpulkan poin, dan naiki leaderboard!</p>
          </div>
          <div class="game-grid">
            <div class="challenge-window">
              <div class="window-bar">
                <span class="traffic-lights"><i></i><i></i><i></i></span>
                <span>talentgroup.id — Code Challenge</span>
                <span class="live-label">● Live</span>
              </div>
              <div class="challenge-body">
                <p class="challenge-task">Tantangan: Cetak 'Hello, World!' menggunakan PHP</p>
                <div class="challenge-code"><span>&lt;?php</span><br><b>echo</b> <em>"talentgroup.id"</em>;</div>
                <output id="game-output" class="game-output">$ talentgroup.id</output>
                <form id="challenge-form" class="challenge-form">
                  <label class="sr-only" for="challenge-answer">Output tantangan</label>
                  <input id="challenge-answer" placeholder="Ketik: Hello, World!" autocomplete="off" required>
                  <button class="btn" type="submit">▶ Jalankan</button>
                </form>
                <p id="challenge-feedback" class="challenge-feedback" aria-live="polite"></p>
              </div>
            </div>

            <div class="game-copy">
              <h3>8 Bahasa, Satu Platform</h3>
              <p>Kuasai berbagai bahasa pemrograman melalui tantangan interaktif, kuis, dan game yang dirancang oleh instruktur berpengalaman di industri.</p>
              <div class="language-tags">
                <span class="php">PHP</span>
                <span class="javascript">JavaScript</span>
                <span class="python">Python</span>
                <span class="java">Java</span>
                <span class="css">HTML/CSS</span>
                <span class="sql">SQL</span>
                <span class="cpp">C++</span>
                <span class="rust">Rust</span>
              </div>
              <div class="game-stats">
                <div><strong>500+</strong><span>Tantangan Tersedia</span></div>
                <div><strong>24/7</strong><span>Akses Online</span></div>
                <div><strong>Free</strong><span>Mulai Gratis</span></div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- COURSES SECTION -->
      <section class="courses section" id="courses">
        <div class="container">
          <div class="course-heading">
            <div>
              <p class="eyebrow">KELAS TERSEDIA</p>
              <h2>Kursus Pilihan Terbaik</h2>
            </div>
            @auth
              <a href="{{ route('user.courses.index') }}" class="subtle-link">Lihat Semua Katalog →</a>
            @else
              <a href="{{ route('login') }}" class="subtle-link">Lihat Semua Katalog →</a>
            @endauth
          </div>

          <div class="course-carousel">
            <button class="carousel-arrow previous" id="carouselPrev" aria-label="Geser kelas ke kiri">‹</button>
            <div class="course-track" id="course-track">
              @forelse($courses as $course)
                <article class="course-card">
                  <div class="course-cover">
                    @if($course->image)
                      <img src="{{ asset('storage/' . $course->image) }}" alt="{{ $course->title }}" onerror="this.src='{{ asset('tg/assets/60-2-img-ssda.png') }}'">
                    @else
                      <img src="{{ asset('tg/assets/60-2-img-ssda.png') }}" alt="{{ $course->title }}">
                    @endif
                    @if($course->price == 0)
                      <span class="course-label free-label" style="background: #0f8a5f; color: #fff; position: absolute; top: 12px; right: 12px; padding: 4px 10px; border-radius: 6px; font-size: 11px; font-weight: 800;">FREE</span>
                    @else
                      <span class="course-label" style="background: #0047b3; color: #fff; position: absolute; top: 12px; right: 12px; padding: 4px 10px; border-radius: 6px; font-size: 11px; font-weight: 800;">PREMIUM</span>
                    @endif
                  </div>
                  <div class="course-body">
                    <p class="course-kicker">Course Module</p>
                    <h3>{{ $course->title }}</h3>
                    <p class="course-meta">
                      <span>{{ $course->questions_count ?? 0 }} Materi</span>
                      <span>·</span>
                      <span>{{ ucfirst($course->level ?? 'Semua Level') }}</span>
                    </p>
                    <strong class="course-price {{ $course->price == 0 ? 'free-text' : '' }}">
                      {{ $course->price == 0 ? 'GRATIS' : 'Rp ' . number_format($course->price, 0, ',', '.') }}
                    </strong>
                    @auth
                      <a href="{{ route('user.courses.show', $course->id) }}" class="course-detail-btn">Lihat Detail & Mulai</a>
                    @else
                      <a href="{{ route('login') }}" class="course-detail-btn">Masuk untuk Belajar</a>
                    @endauth
                  </div>
                </article>
              @empty
                <!-- Fallback to Figma featured sample courses if no course in DB yet -->
                <article class="course-card">
                  <div class="course-cover">
                    <img src="{{ asset('tg/assets/60-2-img-ssda.png') }}" alt="Pratinjau materi kelas ssda">
                    <span class="course-label free-label" style="background: #0f8a5f; color: #fff; position: absolute; top: 12px; right: 12px; padding: 4px 10px; border-radius: 6px; font-size: 11px; font-weight: 800;">FREE</span>
                  </div>
                  <div class="course-body">
                    <p class="course-kicker">Course Module</p>
                    <h3>ssda</h3>
                    <p class="course-meta">1 Materi <span>· All Levels</span></p>
                    <strong class="course-price free-text">GRATIS</strong>
                    <a href="{{ route('login') }}" class="course-detail-btn">Lihat Detail</a>
                  </div>
                </article>
                <article class="course-card">
                  <div class="course-cover" style="background: linear-gradient(135deg, #0047b3, #002266);">
                    <span class="course-label" style="background: #0047b3; color: #fff; position: absolute; top: 12px; right: 12px; padding: 4px 10px; border-radius: 6px; font-size: 11px; font-weight: 800;">PREMIUM</span>
                  </div>
                  <div class="course-body">
                    <p class="course-kicker">Course Module</p>
                    <h3>Mastering Golang & Python: Panduan Komprehensif</h3>
                    <p class="course-meta">4 Materi <span>· All Levels</span></p>
                    <strong class="course-price">Rp 99.000</strong>
                    <a href="{{ route('login') }}" class="course-detail-btn">Lihat Detail</a>
                  </div>
                </article>
                <article class="course-card">
                  <div class="course-cover" style="background: linear-gradient(135deg, #00408c, #0b2447);">
                    <span class="course-label" style="background: #0047b3; color: #fff; position: absolute; top: 12px; right: 12px; padding: 4px 10px; border-radius: 6px; font-size: 11px; font-weight: 800;">PREMIUM</span>
                  </div>
                  <div class="course-body">
                    <p class="course-kicker">Course Module</p>
                    <h3>Mastering Golang: Dari Nol Hingga Mahir</h3>
                    <p class="course-meta">4 Materi <span>· All Levels</span></p>
                    <strong class="course-price">Rp 99.000</strong>
                    <a href="{{ route('login') }}" class="course-detail-btn">Lihat Detail</a>
                  </div>
                </article>
              @endforelse
            </div>
            <button class="carousel-arrow next" id="carouselNext" aria-label="Geser kelas ke kanan">›</button>
          </div>
          <div class="tg-mobile-swipe-hint">
            <span>👉 Geser untuk melihat kelas lainnya</span>
          </div>
        </div>
      </section>

      <!-- ABOUT SECTION -->
      <section class="about section" id="about">
        <div class="container">
          <div class="section-intro centered">
            <p class="eyebrow">WHY TALENTGROUP.ID</p>
            <h2>Kenapa Pilih talentgroup.id?</h2>
            <p>Kami membangun platform dengan satu tujuan: mencetak developer handal Indonesia.</p>
          </div>
          <div class="benefit-grid">
            <article class="benefit benefit-1">
              <div class="benefit-icon-wrapper">
                <img src="{{ asset('tg/assets/60-2-img-book.png') }}" alt="Kurikulum Industri" width="34" height="34">
              </div>
              <h3>Kurikulum Industri</h3>
              <p>Kurikulum didesain bersama praktisi industri sehingga relevan dengan kebutuhan pasar kerja terkini.</p>
            </article>
            <article class="benefit benefit-2">
              <div class="benefit-icon-wrapper">
                <img src="{{ asset('tg/assets/60-2-img-ps-controller.png') }}" alt="Belajar Lewat Game" width="34" height="34">
              </div>
              <h3>Belajar Lewat Game</h3>
              <p>Metode gamifikasi membuat belajar coding lebih menyenangkan, menantang, dan tidak membosankan.</p>
            </article>
            <article class="benefit benefit-3">
              <div class="benefit-icon-wrapper">
                <img src="{{ asset('tg/assets/60-2-img-ai.png') }}" alt="Auto-Grading AI" width="34" height="34">
              </div>
              <h3>Auto-Grading AI</h3>
              <p>Sistem AI langsung menilai kode kamu dan memberikan feedback real-time tanpa perlu menunggu mentor.</p>
            </article>
            <article class="benefit benefit-4">
              <div class="benefit-icon-wrapper">
                <img src="{{ asset('tg/assets/60-2-img-prize.png') }}" alt="Sertifikasi Resmi" width="34" height="34">
              </div>
              <h3>Sertifikasi Resmi</h3>
              <p>Raih sertifikat setiap menyelesaikan kelas — bisa langsung dipakai saat job hunting di perusahaan ternama.</p>
            </article>
            <article class="benefit benefit-5">
              <div class="benefit-icon-wrapper">
                <img src="{{ asset('tg/assets/60-2-img-internet.png') }}" alt="Blended Learning" width="34" height="34">
              </div>
              <h3>Blended Learning</h3>
              <p>Fleksibel belajar online maupun offline, sinkron dan asinkron sesuai ritme hidupmu.</p>
            </article>
            <article class="benefit benefit-6">
              <div class="benefit-icon-wrapper">
                <img src="{{ asset('tg/assets/60-2-img-new-job.png') }}" alt="Job-Ready" width="34" height="34">
              </div>
              <h3>Job-Ready</h3>
              <p>Terhubung langsung dengan 50+ hiring partners. Peluang kerja terbuka lebar setelah lulus program.</p>
            </article>
          </div>
        </div>
      </section>
    </main>

    <!-- FOOTER -->
    <footer class="site-footer">
      <div class="footer-grid container">
        <div class="footer-brand-column">
          <a href="{{ route('home') }}" class="footer-brand" style="display: flex; align-items: center; gap: 10px; margin-bottom: 16px;">
            <img src="{{ asset('tg/assets/60-2-img-logo.png') }}" alt="TalentGroup.id" width="36" height="36">
            <strong style="color: #ffffff; font-size: 19px;">TalentGroup.id</strong>
          </a>
          <p>Platform edukasi digital untuk pengembangan keterampilan pemrograman. Belajar coding interaktif dengan PHP, Python, JavaScript, Go, dan banyak lagi secara terarah.</p>
          <ul class="contact-list" style="margin-top: 20px;">
            <li><img src="{{ asset('tg/assets/60-2-img-email.png') }}" alt="" width="20" height="20"><a href="mailto:info@talentgroup.academy">info@talentgroup.academy</a></li>
            <li><img src="{{ asset('tg/assets/60-2-img-phone.png') }}" alt="" width="20" height="20"><a href="tel:+6282323450242">+62 823 2345 0242</a></li>
            <li><img src="{{ asset('tg/assets/60-2-img-location.png') }}" alt="" width="20" height="20">Jakarta, Indonesia</li>
          </ul>
        </div>
        <div class="footer-links">
          <h3>LAYANAN</h3>
          <a href="#courses">Kelas Coding</a>
          <a href="#game-edu">Game Edu</a>
          <a href="{{ route('user.prototypes.create') }}">Upload Prototype AI</a>
          <a href="{{ route('modules.index') }}">Modul Interaktif</a>
        </div>
      </div>
      <div class="footer-bottom">
        © {{ date('Y') }} TalentGroup.id · Seluruh hak cipta dilindungi.
      </div>
    </footer>
  </div>

  <script>
    // Responsive Navbar Menu Toggle
    const menuToggle = document.getElementById('menu-toggle');
    const siteNav = document.getElementById('site-nav');
    if (menuToggle && siteNav) {
      menuToggle.addEventListener('click', () => {
        const isOpen = siteNav.classList.toggle('open');
        menuToggle.setAttribute('aria-expanded', String(isOpen));
      });
    }

    // Carousel Slider for Courses
    const track = document.getElementById('course-track');
    const prevBtn = document.getElementById('carouselPrev');
    const nextBtn = document.getElementById('carouselNext');
    if (track && prevBtn && nextBtn) {
      prevBtn.addEventListener('click', () => {
        track.scrollBy({ left: -360, behavior: 'smooth' });
      });
      nextBtn.addEventListener('click', () => {
        track.scrollBy({ left: 360, behavior: 'smooth' });
      });
    }

    // Interactive Code Challenge
    const challengeForm = document.getElementById('challenge-form');
    const challengeAnswer = document.getElementById('challenge-answer');
    const gameOutput = document.getElementById('game-output');
    const challengeFeedback = document.getElementById('challenge-feedback');

    if (challengeForm) {
      challengeForm.addEventListener('submit', (e) => {
        e.preventDefault();
        const ans = challengeAnswer.value.trim();
        const isCorrect = ans.toLowerCase() === 'hello, world!' || ans.toLowerCase() === 'hello, world' || ans.toLowerCase() === 'hello world';
        
        gameOutput.textContent = `$ ${ans}`;
        if (isCorrect) {
          challengeFeedback.textContent = '✓ Benar! Output berhasil dicetak.';
          challengeFeedback.style.color = '#0f8a5f';
        } else {
          challengeFeedback.textContent = 'Coba lagi: tulis "Hello, World!" sesuai instruksi.';
          challengeFeedback.style.color = '#eab308';
        }
      });
    }

    // Theme Mode Switching (Light & Dark)
    (function() {
      function updateThemeUI(isDark) {
        if (isDark) {
          document.body.classList.add('dark');
          document.documentElement.classList.add('dark');
          document.querySelectorAll('.landing-sun-icon').forEach(el => el.style.display = 'none');
          document.querySelectorAll('.landing-moon-icon').forEach(el => el.style.display = 'inline-block');
        } else {
          document.body.classList.remove('dark');
          document.documentElement.classList.remove('dark');
          document.querySelectorAll('.landing-sun-icon').forEach(el => el.style.display = 'inline-block');
          document.querySelectorAll('.landing-moon-icon').forEach(el => el.style.display = 'none');
        }
      }

      // Sync with localStorage
      const savedTheme = localStorage.getItem('theme') || 'light';
      updateThemeUI(savedTheme === 'dark');

      const themeBtn = document.getElementById('themeToggleLanding');
      if (themeBtn) {
        themeBtn.addEventListener('click', function(e) {
          e.preventDefault();
          const isDark = document.body.classList.contains('dark');
          const next = !isDark;
          updateThemeUI(next);
          localStorage.setItem('theme', next ? 'dark' : 'light');
        });
      }
    })();
  </script>
</body>
</html>
