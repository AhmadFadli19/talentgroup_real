<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Talent Group</title>

  <!-- Bootstrap CSS CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <!-- Vite assets removed: not needed, Bootstrap & styles loaded via CDN -->
</head>
<body>

  <!-- ===== NAVBAR ===== -->
  <nav class="navbar navbar-expand-lg">
    <div class="container">
      <a href="#" class="navbar-brand-text">
        <div class="brand-logo">
          <img src="{{ asset('images/logo.png') }}" alt="Talent Group" class="logo-img" />
        </div>
      </a>

      <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
        <span class="navbar-toggler-icon" style="filter: invert(1);"></span>
      </button>

      <div class="collapse navbar-collapse" id="navMenu">
        <ul class="navbar-nav mx-auto gap-1">
          <li class="nav-item"><a class="nav-link active" href="#">Home</a></li>
          <li class="nav-item"><a class="nav-link" href="#">Our Works</a></li>
          <li class="nav-item"><a class="nav-link" href="#">Game Edu</a></li>
          <li class="nav-item"><a class="nav-link" href="#">Class</a></li>
          <li class="nav-item"><a class="nav-link" href="#">About Us</a></li>
        </ul>
        <a href="#" class="btn-login-nav">LOGIN</a>
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
        <br>
        <a href="#" class="btn-hashtag">#GrowWithTalent</a>
      </div>
    </div>
  </section>

  <!-- ===== OUR WORKS ===== -->
  <section class="our-works">
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
            <img src="{{ asset('images/logo.png') }}" alt="Talent Group" class="logo-img" />
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
            <a href="#" class="btn-apply">Apply Now</a>
          </div>
        </div>
      </div>

    </div>
  </section>

  <!-- ===== GAME EDU SECTION ===== -->
<section class="game-edu">
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
            <a href="#" class="tech-btn">
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
<section class="class-section">
  <div class="class-bg-overlay"></div>
  <div class="container position-relative" style="z-index:2;">
    <div class="section-title-box mb-4"><h2>Class</h2></div>

    <div class="class-carousel-wrapper">
      <button class="carousel-nav prev" id="prevBtn">&#8249;</button>
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
            <a href="#" class="btn-detail">Lihat Detail</a>
          </div>
        </div>
        @endforeach

      </div>
      <button class="carousel-nav next" id="nextBtn">&#8250;</button>
    </div>
  </div>
</section>

<!-- ===== ABOUT US ===== -->
<section class="about-us">
  <div class="container">
    <h2 class="about-title">About Us</h2>
    <hr class="about-hr" />

    <div class="row g-4">

      <!-- Card 1 -->
      <div class="col-lg-4 col-md-6">
        <div class="about-card">
          <div class="about-card-icon">📋</div>
          <h5>Kurikulum Berdasarkan Kebutuhan Industri</h5>
          <p>Hemat waktu dan biaya! Kurikulum Skilvul dibuat agar lebih mudah dimengerti dan sesuai dengan kebutuhan industri.</p>
        </div>
      </div>

      <!-- Card 2 -->
      <div class="col-lg-4 col-md-6">
        <div class="about-card">
          <div class="about-card-icon">🎓</div>
          <h5>Personalisasi Proses Pembelajaran</h5>
          <p>Dengan adanya SkilPath, kamu bebas memilih spesialisasi yang diinginkan agar dapat disesuaikan dengan kebutuhan industri saat ini.</p>
        </div>
      </div>

      <!-- Card 3 -->
      <div class="col-lg-4 col-md-6">
        <div class="about-card">
          <div class="about-card-icon">💻</div>
          <h5>Metode "Blended-Learning"</h5>
          <p>Proses pembelajaran menggunakan metode blended-learning yaitu secara online dan offline. Lebih efektif karena dua arah.</p>
        </div>
      </div>

      <!-- Card 4 -->
      <div class="col-lg-4 col-md-6">
        <div class="about-card">
          <div class="about-card-icon">🏅</div>
          <h5>Sertifikasi</h5>
          <p>Kamu akan mendapatkan SkilBadge setiap kali berhasil menyelesaikan sebuah kelas. SkilBadge tersebut dapat digunakan sebagai sertifikasi saat job hunting.</p>
        </div>
      </div>

      <!-- Card 5 -->
      <div class="col-lg-4 col-md-6">
        <div class="about-card">
          <div class="about-card-icon">⭐</div>
          <h5>Penilaian "Auto-grading"</h5>
          <p>Kamu akan langsung mendapatkan feedback pada saat proses pembelajaran tanpa harus menunggu tanggapan mentor.</p>
        </div>
      </div>

      <!-- Card 6 -->
      <div class="col-lg-4 col-md-6">
        <div class="about-card">
          <div class="about-card-icon">💼</div>
          <h5>Siap Kerja</h5>
          <p>Terhubung dengan lebih dari 150+ hiring partners, kamu berpeluang besar mendapatkan pekerjaan setelah lulus dari program kami.</p>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- ===== FOOTER ===== -->
<footer class="footer">
  <div class="container">
    <div class="footer-top">

      <!-- Col 1: Logo + Alamat -->
      <div class="footer-brand">
        <div class="footer-logo">
            <img src="{{ asset('images/logo.png') }}" alt="Talent Group" class="logo-img" />
        </div>
        <p class="footer-address">
          Jl. Simprug Golf B No.6, RT.2/RW.8, Grogol Sel., Kec. Kby. Lama,<br>
          Kota Jakarta Selatan, Daerah Khusus Ibukota Jakarta 12220
        </p>
        <a href="https://maps.google.com" target="_blank" class="footer-maps-link">Lihat di Google Maps</a>
        <div class="footer-contact">
          <div>✉ info@TalentGroup.com</div>
          <div>+62823 2345 0242</div>
        </div>
      </div>

      <!-- Col 2: TalentGroup -->
      <div class="footer-col">
        <h6>TalentGroup</h6>
        <ul>
          <li><a href="#">Karir</a></li>
          <li><a href="#">Tentang Kami</a></li>
          <li><a href="#">Partner</a></li>
          <li><a href="#">Blog</a></li>
        </ul>
      </div>

      <!-- Col 3: Layanan -->
      <div class="footer-col">
        <h6>Layanan</h6>
        <ul>
          <li><a href="#">Kelas</a></li>
          <li><a href="#">Beasiswa</a></li>
          <li><a href="#">Challenge</a></li>
          <li><a href="#">SkillPath</a></li>
          <li><a href="#">Webinar</a></li>
          <li><a href="#">Paket</a></li>
        </ul>
      </div>

      <!-- Col 4: Bantuan -->
      <div class="footer-col">
        <h6>Bantuan dan Panduan</h6>
        <ul>
          <li><a href="#">Syarat dan Ketentuan</a></li>
          <li><a href="#">Kebijakan Privasi</a></li>
          <li><a href="#">Bantuan</a></li>
        </ul>
      </div>

    </div>
  </div>

  <!-- Footer Bottom -->
  <div class="footer-bottom">
    <div class="container">
      <p>© 2019 – 2025, PT TALENTGROUP EDUKASI.</p>
      <div class="footer-socials">
        <!-- Instagram -->
        <a href="#" aria-label="Instagram">
          <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24">
            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
          </svg>
        </a>
        <!-- LinkedIn -->
        <a href="#" aria-label="LinkedIn">
          <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24">
            <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
          </svg>
        </a>
        <!-- YouTube -->
        <a href="#" aria-label="YouTube">
          <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24">
            <path d="M23.495 6.205a3.007 3.007 0 0 0-2.088-2.088c-1.87-.501-9.396-.501-9.396-.501s-7.507-.01-9.396.501A3.007 3.007 0 0 0 .527 6.205a31.247 31.247 0 0 0-.522 5.805 31.247 31.247 0 0 0 .522 5.783 3.007 3.007 0 0 0 2.088 2.088c1.868.502 9.396.502 9.396.502s7.506 0 9.396-.502a3.007 3.007 0 0 0 2.088-2.088 31.247 31.247 0 0 0 .5-5.783 31.247 31.247 0 0 0-.5-5.805zM9.609 15.601V8.408l6.264 3.602z"/>
          </svg>
        </a>
      </div>
    </div>
  </div>
</footer>

  <!-- Bootstrap JS CDN -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="{{ asset('js/app.js') }}"></script>

</body>
</html>