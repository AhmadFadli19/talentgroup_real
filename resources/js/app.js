import './bootstrap';

// ===== TALENT GROUP - app.js =====

document.addEventListener('DOMContentLoaded', function () {

  // --- 1. Set active nav link sesuai halaman saat ini ---
  const currentPath = window.location.pathname;
  const navLinks = document.querySelectorAll('.nav-link');

  navLinks.forEach(link => {
    link.classList.remove('active');
    const href = link.getAttribute('href');
    if (href && currentPath.endsWith(href)) {
      link.classList.add('active');
    }
  });

  // --- 2. Navbar shadow saat scroll ---
  const navbar = document.querySelector('.navbar');
  if (navbar) {
    window.addEventListener('scroll', function () {
      if (window.scrollY > 10) {
        navbar.style.boxShadow = '0 4px 20px rgba(0,0,0,0.3)';
      } else {
        navbar.style.boxShadow = 'none';
      }
    });
  }

  // --- 3. Smooth scroll untuk anchor link ---
  document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
      const target = document.querySelector(this.getAttribute('href'));
      if (target) {
        e.preventDefault();
        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
      }
    });
  });

  // --- 4. Fade-in animasi elemen saat masuk viewport ---
  const fadeEls = document.querySelectorAll('.works-card, .section-title-box');

  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.style.opacity = '1';
        entry.target.style.transform = 'translateY(0)';
        observer.unobserve(entry.target);
      }
    });
  }, { threshold: 0.15 });

  fadeEls.forEach(el => {
    el.style.opacity = '0';
    el.style.transform = 'translateY(30px)';
    el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
    observer.observe(el);
  });

});

// ===== CLASS CAROUSEL =====
document.addEventListener('DOMContentLoaded', function () {
  const track   = document.getElementById('classTrack');
  const prevBtn = document.getElementById('prevBtn');
  const nextBtn = document.getElementById('nextBtn');

  if (!track || !prevBtn || !nextBtn) return;

  const getScrollAmount = () => {
    const card = track.querySelector('.class-card');
    return card ? card.offsetWidth + 16 : 280;
  };

  nextBtn.addEventListener('click', () => {
    track.scrollBy({ left: getScrollAmount(), behavior: 'smooth' });
  });

  prevBtn.addEventListener('click', () => {
    track.scrollBy({ left: -getScrollAmount(), behavior: 'smooth' });
  });

  // Sembunyiin/tampil tombol sesuai posisi scroll
  const updateButtons = () => {
    prevBtn.style.opacity = track.scrollLeft <= 0 ? '0.4' : '1';
    nextBtn.style.opacity = track.scrollLeft + track.clientWidth >= track.scrollWidth - 4 ? '0.4' : '1';
  };

  track.addEventListener('scroll', updateButtons);
  updateButtons();
});
