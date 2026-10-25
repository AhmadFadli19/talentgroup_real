<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Talent Group — Raih Ilmu, Kuasai Kode</title>

  <!-- Bootstrap CSS CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />

  <!-- Google Fonts: Poppins & Outfit -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800;900&family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap" rel="stylesheet">

  <style>
    /* === GLOBAL STYLES === */
    :root {
      --primary: #0052FF;
      --primary-dark: #003ECC;
      --accent: #FF7300;
      --dark-navy: #0B132B;
      --navy-card: #1C2541;
      --text-main: #0F172A;
      --text-muted: #64748B;
      --bg-light: #F8FAFC;
      --border-color: #E2E8F0;
    }

    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: 'Poppins', sans-serif;
      color: var(--text-main);
      background-color: #FFFFFF;
      overflow-x: hidden;
      line-height: 1.6;
    }

    /* === NAVBAR === */
    .navbar {
      background: rgba(255, 255, 255, 0.98);
      backdrop-filter: blur(12px);
      box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
      padding: 16px 0;
      position: sticky;
      top: 0;
      z-index: 1000;
      border-bottom: 1px solid var(--border-color);
    }

    .brand-logo .logo-img {
      max-height: 42px;
      width: auto;
      object-fit: contain;
    }

    .navbar-nav .nav-link {
      font-size: 15px;
      font-weight: 600;
      color: #334155 !important;
      padding: 8px 18px !important;
      border-radius: 8px;
      transition: all 0.2s ease;
    }

    .navbar-nav .nav-link:hover,
    .navbar-nav .nav-link.active {
      color: var(--primary) !important;
      background: #F1F5F9;
    }

    .btn-login-nav {
      background: linear-gradient(135deg, var(--primary), var(--primary-dark));
      color: #FFFFFF !important;
      padding: 10px 28px;
      border-radius: 50px;
      font-weight: 700;
      font-size: 14px;
      text-decoration: none;
      box-shadow: 0 4px 14px rgba(0, 82, 255, 0.3);
      transition: all 0.25s ease;
      display: inline-block;
      letter-spacing: 0.5px;
    }

    .btn-login-nav:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(0, 82, 255, 0.45);
      color: #FFFFFF;
    }

    /* === HERO SECTION === */
    .hero {
      position: relative;
      background: var(--dark-navy);
      color: #FFFFFF;
      padding: 100px 0;
      min-height: 80vh;
      display: flex;
      align-items: center;
      overflow: hidden;
    }

    .hero-bg {
      position: absolute;
      inset: 0;
      background: radial-gradient(circle at 80% 20%, rgba(0, 82, 255, 0.35) 0%, transparent 50%),
                  radial-gradient(circle at 10% 80%, rgba(255, 115, 0, 0.2) 0%, transparent 45%);
      z-index: 1;
    }

    .hero-overlay {
      position: absolute;
      inset: 0;
      background: rgba(11, 19, 43, 0.6);
      z-index: 1;
    }

    .hero-content {
      position: relative;
      z-index: 2;
    }

    .hero-eyebrow {
      font-size: 24px;
      font-weight: 600;
      color: #94A3B8;
      line-height: 1.5;
      margin-bottom: 20px;
      letter-spacing: 0.3px;
    }

    .hero-title-box h1 {
      font-size: 64px;
      font-weight: 900;
      font-family: 'Outfit', sans-serif;
      background: linear-gradient(135deg, #FFFFFF 40%, #93C5FD 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      line-height: 1.1;
      margin-bottom: 24px;
      letter-spacing: -1px;
    }

    .btn-hashtag {
      display: inline-block;
      background: rgba(255, 255, 255, 0.08);
      border: 1px solid rgba(255, 255, 255, 0.2);
      color: #38BDF8 !important;
      padding: 10px 24px;
      border-radius: 50px;
      font-weight: 700;
      font-size: 15px;
      text-decoration: none;
      backdrop-filter: blur(10px);
      transition: all 0.25s ease;
    }

    .btn-hashtag:hover {
      background: rgba(56, 189, 248, 0.2);
      border-color: #38BDF8;
      transform: translateY(-2px);
    }

    /* === SECTION TITLE === */
    .section-title-box {
      margin-bottom: 36px;
    }

    .section-title-box h2 {
      font-size: 34px;
      font-weight: 800;
      font-family: 'Outfit', sans-serif;
      color: var(--text-main);
      position: relative;
      display: inline-block;
    }

    .section-title-box h2::after {
      content: '';
      display: block;
      width: 50px;
      height: 4px;
      background: var(--primary);
      border-radius: 4px;
      margin-top: 8px;
    }

    /* === OUR WORKS === */
    .our-works {
      padding: 90px 0;
      background: var(--bg-light);
    }

    .works-card {
      display: flex;
      background: #FFFFFF;
      border-radius: 24px;
      overflow: hidden;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
      border: 1px solid var(--border-color);
    }

    .works-card-img {
      flex: 1;
      min-height: 380px;
      overflow: hidden;
    }

    .works-card-img img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      display: block;
      transition: transform 0.4s ease;
    }

    .works-card:hover .works-card-img img {
      transform: scale(1.03);
    }

    .works-card-content {
      flex: 1.2;
      padding: 48px;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }

    .works-card-logo .logo-img {
      max-height: 36px;
      margin-bottom: 20px;
    }

    .works-card-title {
      font-size: 30px;
      font-weight: 800;
      font-family: 'Outfit', sans-serif;
      color: var(--text-main);
      line-height: 1.3;
      margin-bottom: 16px;
    }

    .works-card-desc {
      font-size: 15px;
      color: var(--text-muted);
      line-height: 1.8;
      margin-bottom: 28px;
    }

    .btn-apply {
      display: inline-block;
      background: var(--primary);
      color: #FFFFFF !important;
      padding: 12px 32px;
      border-radius: 12px;
      font-weight: 700;
      font-size: 14px;
      text-decoration: none;
      box-shadow: 0 4px 14px rgba(0, 82, 255, 0.25);
      transition: all 0.25s ease;
      width: fit-content;
    }

    .btn-apply:hover {
      background: var(--primary-dark);
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(0, 82, 255, 0.4);
    }

    /* === GAME EDU SECTION === */
    .game-edu {
      padding: 90px 0;
      background: #FFFFFF;
    }

    .game-edu-wrapper {
      display: flex;
      gap: 48px;
      align-items: center;
    }

    .game-edu-img {
      flex: 1;
      border-radius: 24px;
      overflow: hidden;
      box-shadow: 0 15px 35px rgba(0, 0, 0, 0.08);
    }

    .game-edu-img img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      display: block;
    }

    .game-edu-content {
      flex: 1.1;
    }

    .game-edu-tab {
      display: inline-block;
      background: #EFF6FF;
      color: var(--primary);
      font-weight: 700;
      font-size: 13px;
      padding: 6px 16px;
      border-radius: 20px;
      margin-bottom: 16px;
      letter-spacing: 0.5px;
    }

    .game-edu-text h3 {
      font-size: 32px;
      font-weight: 800;
      font-family: 'Outfit', sans-serif;
      color: var(--text-main);
      margin-bottom: 16px;
      line-height: 1.3;
    }

    .game-edu-text p {
      font-size: 15px;
      color: var(--text-muted);
      line-height: 1.8;
      margin-bottom: 28px;
    }

    .game-tech-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 12px;
    }

    .tech-btn {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      padding: 14px 10px;
      background: var(--bg-light);
      border: 1px solid var(--border-color);
      border-radius: 14px;
      text-decoration: none;
      color: var(--text-main) !important;
      font-weight: 600;
      font-size: 13px;
      transition: all 0.25s ease;
    }

    .tech-btn:hover {
      background: #FFFFFF;
      border-color: var(--primary);
      transform: translateY(-3px);
      box-shadow: 0 6px 16px rgba(0, 82, 255, 0.12);
      color: var(--primary) !important;
    }

    .tech-btn img {
      width: 28px;
      height: 28px;
      margin-bottom: 8px;
    }

    /* === CLASS SECTION === */
    .class-section {
      padding: 90px 0;
      background: var(--dark-navy);
      color: #FFFFFF;
      position: relative;
      overflow: hidden;
    }

    .class-bg-overlay {
      position: absolute;
      inset: 0;
      background: radial-gradient(circle at 20% 50%, rgba(0, 82, 255, 0.2) 0%, transparent 60%);
      z-index: 1;
    }

    .class-section .section-title-box h2 {
      color: #FFFFFF;
    }

    .class-carousel-wrapper {
      position: relative;
      display: flex;
      align-items: center;
    }

    .class-track {
      display: flex;
      gap: 24px;
      overflow-x: auto;
      scroll-behavior: smooth;
      padding: 16px 4px 28px;
      scrollbar-width: none;
    }

    .class-track::-webkit-scrollbar {
      display: none;
    }

    .class-card {
      min-width: 280px;
      max-width: 280px;
      background: #FFFFFF;
      color: var(--text-main);
      border-radius: 20px;
      overflow: hidden;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.25);
      position: relative;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .class-card:hover {
      transform: translateY(-6px);
      box-shadow: 0 15px 35px rgba(0, 0, 0, 0.35);
    }

    .badge-bestseller {
      position: absolute;
      top: 14px;
      left: 14px;
      background: #EF4444;
      color: #FFFFFF;
      font-size: 11px;
      font-weight: 700;
      padding: 4px 12px;
      border-radius: 20px;
      z-index: 2;
      box-shadow: 0 2px 8px rgba(239, 68, 68, 0.4);
    }

    .class-card-img {
      height: 150px;
      display: flex;
      align-items: center;
      justify-content: center;
      position: relative;
    }

    .class-card-img img {
      width: 64px;
      height: 64px;
      object-fit: contain;
    }

    .html-bg { background: linear-gradient(135deg, #FFE4E6, #FECDD3); }
    .css-bg { background: linear-gradient(135deg, #E0F2FE, #BAE6FD); }
    .js-bg { background: linear-gradient(135deg, #FEF08A, #FDE047); }
    .python-bg { background: linear-gradient(135deg, #E0E7FF, #C7D2FE); }
    .php-bg { background: linear-gradient(135deg, #EDE9FE, #DDD6FE); }
    .java-bg { background: linear-gradient(135deg, #FFEDD5, #FED7AA); }

    .class-card-body {
      padding: 22px;
    }

    .class-meta {
      font-size: 12px;
      color: var(--text-muted);
      font-weight: 600;
      margin-bottom: 6px;
    }

    .class-level {
      font-size: 13px;
      font-weight: 600;
      color: var(--text-main);
      margin-bottom: 6px;
      display: flex;
      align-items: center;
      gap: 6px;
    }

    .dot.green {
      width: 8px;
      height: 8px;
      background: #10B981;
      border-radius: 50%;
      display: inline-block;
    }

    .class-cert {
      font-size: 12px;
      color: var(--text-muted);
      margin-bottom: 14px;
    }

    .x-red {
      color: #EF4444;
      font-weight: 800;
    }

    .class-price {
      font-size: 20px;
      font-weight: 900;
      font-family: 'Outfit', sans-serif;
      color: var(--primary);
      margin-bottom: 16px;
    }

    .btn-detail {
      display: block;
      text-align: center;
      background: #F1F5F9;
      color: var(--text-main) !important;
      padding: 10px 0;
      border-radius: 12px;
      font-weight: 700;
      font-size: 13px;
      text-decoration: none;
      transition: all 0.25s ease;
    }

    .btn-detail:hover {
      background: var(--primary);
      color: #FFFFFF !important;
    }

    .carousel-nav {
      width: 44px;
      height: 44px;
      border-radius: 50%;
      background: #FFFFFF;
      border: none;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 24px;
      color: var(--text-main);
      cursor: pointer;
      z-index: 10;
      position: absolute;
      transition: all 0.25s ease;
    }

    .carousel-nav:hover {
      background: var(--primary);
      color: #FFFFFF;
      transform: scale(1.1);
    }

    .carousel-nav.prev { left: -22px; }
    .carousel-nav.next { right: -22px; }

    /* === ABOUT US === */
    .about-us {
      padding: 90px 0;
      background: var(--bg-light);
    }

    .about-title {
      font-size: 34px;
      font-weight: 800;
      font-family: 'Outfit', sans-serif;
      color: var(--text-main);
      text-align: center;
    }

    .about-hr {
      width: 60px;
      height: 4px;
      background: var(--primary);
      margin: 12px auto 48px;
      border: none;
      border-radius: 4px;
      opacity: 1;
    }

    .about-card {
      background: #FFFFFF;
      padding: 32px 24px;
      border-radius: 20px;
      border: 1px solid var(--border-color);
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
      height: 100%;
      transition: all 0.3s ease;
    }

    .about-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 12px 25px rgba(0, 0, 0, 0.08);
      border-color: #93C5FD;
    }

    .about-card-icon {
      font-size: 32px;
      width: 58px;
      height: 58px;
      background: #EFF6FF;
      border-radius: 16px;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 20px;
    }

    .about-card h5 {
      font-size: 18px;
      font-weight: 700;
      font-family: 'Outfit', sans-serif;
      color: var(--text-main);
      margin-bottom: 12px;
    }

    .about-card p {
      font-size: 14px;
      color: var(--text-muted);
      line-height: 1.7;
      margin: 0;
    }

    /* === FOOTER === */
    .footer {
      background: var(--dark-navy);
      color: #FFFFFF;
      padding: 80px 0 32px;
    }

    .footer-top {
      display: flex;
      flex-wrap: wrap;
      gap: 40px;
      justify-content: space-between;
      margin-bottom: 50px;
    }

    .footer-brand {
      flex: 1.5;
      min-width: 280px;
    }

    .footer-logo img {
      max-height: 40px;
      margin-bottom: 20px;
      filter: brightness(0) invert(1);
    }

    .footer-address {
      font-size: 14px;
      color: #94A3B8;
      line-height: 1.8;
      margin-bottom: 12px;
    }

    .footer-maps-link {
      color: #38BDF8 !important;
      font-size: 13px;
      font-weight: 600;
      text-decoration: none;
      display: inline-block;
      margin-bottom: 18px;
    }

    .footer-contact {
      font-size: 14px;
      color: #CBD5E1;
      display: flex;
      flex-direction: column;
      gap: 6px;
    }

    .footer-col {
      flex: 1;
      min-width: 160px;
    }

    .footer-col h6 {
      font-size: 16px;
      font-weight: 700;
      font-family: 'Outfit', sans-serif;
      color: #FFFFFF;
      margin-bottom: 20px;
    }

    .footer-col ul {
      list-style: none;
      padding: 0;
      margin: 0;
    }

    .footer-col ul li {
      margin-bottom: 10px;
    }

    .footer-col ul li a {
      color: #94A3B8 !important;
      font-size: 14px;
      text-decoration: none;
      transition: color 0.2s ease;
    }

    .footer-col ul li a:hover {
      color: #FFFFFF !important;
    }

    .footer-bottom {
      border-top: 1px solid rgba(255, 255, 255, 0.1);
      padding-top: 24px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
      gap: 16px;
    }

    .footer-bottom p {
      margin: 0;
      font-size: 13px;
      color: #64748B;
    }

    .footer-socials {
      display: flex;
      gap: 16px;
    }

    .footer-socials a {
      color: #94A3B8 !important;
      transition: all 0.2s ease;
    }

    .footer-socials a:hover {
      color: #FFFFFF !important;
      transform: translateY(-2px);
    }

    /* === RESPONSIVE === */
    @media (max-width: 991px) {
      .hero-title-box h1 { font-size: 46px; }
      .works-card { flex-direction: column; }
      .works-card-img { min-height: 260px; }
      .works-card-content { padding: 32px 24px; }
      .game-edu-wrapper { flex-direction: column; }
      .game-tech-grid { grid-template-columns: repeat(2, 1fr); }
      .carousel-nav { display: none; }
    }
  </style>
</head>
<body>

  <!-- ===== NAVBAR ===== -->
  <nav class="navbar navbar-expand-lg">
    <div class="container">
      <a href="#" class="navbar-brand-text d-flex align-items-center text-decoration-none">
        <div class="brand-logo">
          <img src="{{ asset('tg/assets/60-2-img-logo.png') }}" alt="Talent Group" class="logo-img" onerror="this.src='{{ asset('images/logo.png') }}'" />
        </div>
      </a>

      <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navMenu">
        <ul class="navbar-nav mx-auto gap-1">
          <li class="nav-item"><a class="nav-link active" href="#">Home</a></li>
          <li class="nav-item"><a class="nav-link" href="#ourWorks">Our Works</a></li>
          <li class="nav-item"><a class="nav-link" href="#gameEdu">Game Edu</a></li>
          <li class="nav-item"><a class="nav-link" href="#classSection">Class</a></li>
          <li class="nav-item"><a class="nav-link" href="#aboutUs">About Us</a></li>
        </ul>
        <a href="{{ route('login') }}" class="btn-login-nav">LOGIN</a>
      </div>
    </div>
  </nav>

  <!-- ===== HERO ===== -->
  <section class="hero">
    <div class="hero-bg"></div>
    <div class="hero-overlay"></div>
    <div class="container hero-content">
      <div class="col-lg-7">
        <p class="hero-eyebrow">Raih Ilmu Tanpa Batas &<br>Wujudkan Potensi Digital Teratas</p>
        <div class="hero-title-box">
          <h1>Talent Group</h1>
        </div>
        <a href="#classSection" class="btn-hashtag">#GrowWithTalent</a>
      </div>
    </div>
  </section>

  <!-- ===== OUR WORKS ===== -->
  <section class="our-works" id="ourWorks">
    <div class="container">
      <div class="section-title-box">
        <h2>Our Works</h2>
      </div>

      <div class="works-card">
        <div class="works-card-img">
          <img
            src="https://images.unsplash.com/photo-1521791136064-7986c2920216?w=800&q=80"
            alt="Kenali TalentGroup"
          />
        </div>
        <div class="works-card-content">
          <div class="works-card-logo">
            <img src="{{ asset('tg/assets/60-2-img-logo.png') }}" alt="Talent Group" class="logo-img" onerror="this.src='{{ asset('images/logo.png') }}'" />
          </div>
          <div>
            <h3 class="works-card-title">Kenali TalentGroup<br>Lebih Dekat</h3>
            <p class="works-card-desc">
              TalentGroup adalah platform edukasi digital yang berfokus pada pengembangan keterampilan pemrograman.
              Di TalentGroup, pengguna dapat mempelajari berbagai bahasa pemrograman melalui materi interaktif,
              latihan praktik, serta game edukasi yang dirancang untuk membuat proses belajar menjadi lebih menarik
              dan menyenangkan. Platform ini hadir untuk membantu meningkatkan kemampuan digital dan membuka
              peluang karier di bidang teknologi.
            </p>
            <a href="{{ route('login') }}" class="btn-apply">Apply Now</a>
          </div>
        </div>
      </div>

    </div>
  </section>

  <!-- ===== GAME EDU SECTION ===== -->
  <section class="game-edu" id="gameEdu">
    <div class="container">
      <div class="game-edu-wrapper">

        <div class="game-edu-img">
          <img src="https://images.unsplash.com/photo-1498050108023-c5249f4df085?w=600&q=80" alt="Game Edu" />
        </div>

        <div class="game-edu-content">
          <div class="game-edu-tab">Game Edu</div>
          <div class="game-edu-inner">
            <div class="game-edu-text">
              <h3>Belajar Lewat Game<br>Edukatif yang Seru</h3>
              <p>TalentGroup menghadirkan game edukasi interaktif untuk membantu memahami pemrograman dengan cara yang menyenangkan, menantang, dan mudah dipahami, cocok untuk pemula hingga level lanjutan.</p>
            </div>
            <div class="game-tech-grid">
              @foreach([
                ['html5','HTML'],['css3','CSS'],['javascript','JavaScript'],
                ['python','Python'],['cplusplus','C++'],['php','PHP'],
                ['java','Java'],['mysql','SQL']
              ] as [$icon, $label])
              <a href="{{ route('login') }}" class="tech-btn">
                <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/{{ $icon }}/{{ $icon }}-original.svg" alt="{{ $label }}" />
                {{ $label }}
              </a>
              @endforeach
            </div>
          </div>
        </div>

      </div>
    </div>
  </section>

  <!-- ===== CLASS SECTION ===== -->
  <section class="class-section" id="classSection">
    <div class="class-bg-overlay"></div>
    <div class="container position-relative" style="z-index:2;">
      <div class="section-title-box mb-4"><h2>Class</h2></div>

      <div class="class-carousel-wrapper">
        <button class="carousel-nav prev" id="prevBtn" type="button">&#8249;</button>
        <div class="class-track" id="classTrack">

          @foreach([
            ['HTML','html5','html-bg'],
            ['CSS','css3','css-bg'],
            ['JavaScript','javascript','js-bg'],
            ['Python','python','python-bg'],
            ['PHP','php','php-bg'],
            ['Java','java','java-bg'],
          ] as [$name, $icon, $bg])
          <div class="class-card">
            <span class="badge-bestseller">Best Seller</span>
            <div class="class-card-img {{ $bg }}">
              <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/{{ $icon }}/{{ $icon }}-original.svg" alt="{{ $name }}" />
            </div>
            <div class="class-card-body">
              <div class="class-meta">📘 1 Materi</div>
              <div class="class-level"><span class="dot green"></span> Pemula (1815 Ulasan)</div>
              <div class="class-cert"><span class="x-red">✕</span> sertifikat</div>
              <div class="class-price">GRATIS</div>
              <a href="{{ route('login') }}" class="btn-detail">Lihat Detail</a>
            </div>
          </div>
          @endforeach

        </div>
        <button class="carousel-nav next" id="nextBtn" type="button">&#8250;</button>
      </div>
    </div>
  </section>

  <!-- ===== ABOUT US ===== -->
  <section class="about-us" id="aboutUs">
    <div class="container">
      <h2 class="about-title">About Us</h2>
      <hr class="about-hr" />

      <div class="row g-4">

        <div class="col-lg-4 col-md-6">
          <div class="about-card">
            <div class="about-card-icon">📋</div>
            <h5>Kurikulum Berdasarkan Kebutuhan Industri</h5>
            <p>Hemat waktu dan biaya! Kurikulum TalentGroup dibuat agar lebih mudah dimengerti dan sesuai dengan kebutuhan industri.</p>
          </div>
        </div>

        <div class="col-lg-4 col-md-6">
          <div class="about-card">
            <div class="about-card-icon">🎓</div>
            <h5>Personalisasi Proses Pembelajaran</h5>
            <p>Dengan adanya alur belajar terarah, kamu bebas memilih spesialisasi yang diinginkan agar sesuai dengan kebutuhan industri saat ini.</p>
          </div>
        </div>

        <div class="col-lg-4 col-md-6">
          <div class="about-card">
            <div class="about-card-icon">💻</div>
            <h5>Metode Interaktif Modern</h5>
            <p>Proses pembelajaran menggunakan modul interaktif, latihan soal, dan live coding yang efektif dan dua arah.</p>
          </div>
        </div>

        <div class="col-lg-4 col-md-6">
          <div class="about-card">
            <div class="about-card-icon">🏅</div>
            <h5>Sertifikasi Kelulusan</h5>
            <p>Kamu akan mendapatkan sertifikat pencapaian setiap kali berhasil menyelesaikan sebuah kursus sebagai bukti keahlian.</p>
          </div>
        </div>

        <div class="col-lg-4 col-md-6">
          <div class="about-card">
            <div class="about-card-icon">⭐</div>
            <h5>Penilaian Otomatis (Auto-grading)</h5>
            <p>Kamu akan langsung mendapatkan evaluasi seketika pada saat proses pengerjaan kuis dan coding tanpa harus menunggu.</p>
          </div>
        </div>

        <div class="col-lg-4 col-md-6">
          <div class="about-card">
            <div class="about-card-icon">💼</div>
            <h5>Karier Siap Kerja</h5>
            <p>Dibekali portofolio dan proyek riil, kamu berpeluang besar siap bersaing di dunia kerja dan industri teknologi digital.</p>
          </div>
        </div>

      </div>
    </div>
  </section>

  <!-- ===== FOOTER ===== -->
  <footer class="footer">
    <div class="container">
      <div class="footer-top">

        <div class="footer-brand">
          <div class="footer-logo">
            <img src="{{ asset('tg/assets/60-2-img-logo.png') }}" alt="Talent Group" class="logo-img" onerror="this.src='{{ asset('images/logo.png') }}'" />
          </div>
          <p class="footer-address">
            Jl. Simprug Golf B No.6, RT.2/RW.8, Grogol Sel., Kec. Kby. Lama,<br>
            Kota Jakarta Selatan, Daerah Khusus Ibukota Jakarta 12220
          </p>
          <a href="https://maps.google.com" target="_blank" class="footer-maps-link">Lihat di Google Maps</a>
          <div class="footer-contact">
            <div>✉ info@TalentGroup.com</div>
            <div>📞 +62823 2345 0242</div>
          </div>
        </div>

        <div class="footer-col">
          <h6>TalentGroup</h6>
          <ul>
            <li><a href="#">Karir</a></li>
            <li><a href="#aboutUs">Tentang Kami</a></li>
            <li><a href="#">Partner</a></li>
            <li><a href="#">Blog</a></li>
          </ul>
        </div>

        <div class="footer-col">
          <h6>Layanan</h6>
          <ul>
            <li><a href="#classSection">Kelas Pemrograman</a></li>
            <li><a href="#">Beasiswa</a></li>
            <li><a href="#gameEdu">Game Edukasi</a></li>
            <li><a href="#">Webinar</a></li>
          </ul>
        </div>

        <div class="footer-col">
          <h6>Bantuan & Panduan</h6>
          <ul>
            <li><a href="#">Syarat dan Ketentuan</a></li>
            <li><a href="#">Kebijakan Privasi</a></li>
            <li><a href="#">Pusat Bantuan</a></li>
          </ul>
        </div>

      </div>
    </div>

    <div class="footer-bottom">
      <div class="container">
        <p>© 2026 PT TALENTGROUP EDUKASI INDONESIA. All rights reserved.</p>
        <div class="footer-socials">
          <a href="#" aria-label="Instagram">
            <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
          </a>
          <a href="#" aria-label="LinkedIn">
            <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
          </a>
          <a href="#" aria-label="YouTube">
            <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M23.495 6.205a3.007 3.007 0 0 0-2.088-2.088c-1.87-.501-9.396-.501-9.396-.501s-7.507-.01-9.396.501A3.007 3.007 0 0 0 .527 6.205a31.247 31.247 0 0 0-.522 5.805 31.247 31.247 0 0 0 .522 5.783 3.007 3.007 0 0 0 2.088 2.088c1.868.502 9.396.502 9.396.502s7.506 0 9.396-.502a3.007 3.007 0 0 0 2.088-2.088 31.247 31.247 0 0 0 .5-5.783 31.247 31.247 0 0 0-.5-5.805zM9.609 15.601V8.408l6.264 3.602z"/></svg>
          </a>
        </div>
      </div>
    </div>
  </footer>

  <!-- Bootstrap JS CDN -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Carousel Controls Script -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const track = document.getElementById('classTrack');
      const prev = document.getElementById('prevBtn');
      const next = document.getElementById('nextBtn');

      if (track && prev && next) {
        prev.addEventListener('click', function() {
          track.scrollBy({ left: -300, behavior: 'smooth' });
        });
        next.addEventListener('click', function() {
          track.scrollBy({ left: 300, behavior: 'smooth' });
        });
      }
    });
  </script>

</body>
</html>
