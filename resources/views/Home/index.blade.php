<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>talentgroup.id — Raih Ilmu Tanpa Batas, Kuasai Kode</title>
<meta name="description" content="talentgroup.id — Platform edukasi digital interaktif untuk pengembangan keterampilan pemrograman. Belajar PHP, Python, JavaScript, Go, dan banyak lagi secara praktis dan menyenangkan.">
<meta name="keywords" content="belajar coding, belajar pemrograman, tutorial php, belajar python, javascript indonesia, belajar go golang, sertifikat coding, akademi pemrograman">
<meta name="robots" content="index, follow">
<meta name="author" content="talentgroup.id">
<link rel="canonical" href="{{ url()->current() }}">

<!-- Open Graph / Facebook / WhatsApp -->
<meta property="og:type" content="website">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:title" content="talentgroup.id — Raih Ilmu Tanpa Batas, Kuasai Kode">
<meta property="og:description" content="Platform edukasi digital interaktif untuk pengembangan keterampilan pemrograman. Belajar PHP, Python, JavaScript, Go, dan lainnya dengan sistem imersif.">
<meta property="og:image" content="{{ asset('assets/images/logo.png') }}">
<meta property="og:site_name" content="talentgroup.id">
<meta property="og:locale" content="id_ID">

<!-- Twitter Card -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:url" content="{{ url()->current() }}">
<meta name="twitter:title" content="talentgroup.id — Raih Ilmu Tanpa Batas, Kuasai Kode">
<meta name="twitter:description" content="Platform edukasi digital interaktif untuk pengembangan keterampilan pemrograman. Belajar PHP, Python, JavaScript, Go, dan lainnya dengan sistem imersif.">
<meta name="twitter:image" content="{{ asset('assets/images/logo.png') }}">

<!-- Performance Preconnects -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&family=Fira+Code:wght@300;400;500;600&display=swap" rel="stylesheet">

<!-- Structured Data Schema Markup (JSON-LD) for Organization & Website -->
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "Organization",
  "name": "talentgroup.id",
  "url": "{{ url('/') }}",
  "logo": "{{ asset('assets/images/logo.png') }}",
  "contactPoint": {
    "@@type": "ContactPoint",
    "telephone": "+6282323450242",
    "contactType": "customer service",
    "email": "info@talentgroup.academy",
    "areaServed": "ID",
    "availableLanguage": "Indonesian"
  },
  "sameAs": [
    "https://twitter.com/talentgroup_id",
    "https://www.linkedin.com/company/talentgroup-id",
    "https://www.instagram.com/talentgroup.id"
  ]
}
</script>
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "WebSite",
  "name": "talentgroup.id",
  "url": "{{ url('/') }}",
  "potentialAction": {
    "@@type": "SearchAction",
    "target": "{{ url('/') }}/search?q={search_term_string}",
    "query-input": "required name=search_term_string"
  }
}
</script>
<style>
/* ===================== VARIABLES ===================== */
:root {
  --bg: #05080f;
  --bg2: #080d18;
  --bg3: #0c1220;
  --surface: #111827;
  --surface2: #1a2436;
  --php: #7c5cbf;
  --php2: #9b78e0;
  --cyan: #06b6d4;
  --cyan2: #22d3ee;
  --orange: #f97316;
  --orange2: #fb923c;
  --green: #10b981;
  --pink: #ec4899;
  --yellow: #eab308;
  --red: var(--red);
  --text: #f1f5f9;
  --text2: #94a3b8;
  --text3: #475569;
  --border: #1e2d40;
  --glow-php: 0 0 40px rgba(124,92,191,0.3);
  --glow-cyan: 0 0 40px rgba(6,182,212,0.25);
}

*{margin:0;padding:0;box-sizing:border-box;}

html{scroll-behavior:smooth;}

body{
  font-family:'Outfit',sans-serif;
  background:var(--bg);
  color:var(--text);
  overflow-x:hidden;
}

::-webkit-scrollbar{width:5px;}
::-webkit-scrollbar-track{background:var(--bg);}
::-webkit-scrollbar-thumb{background:var(--php);border-radius:4px;}

/* ===================== CURSOR ===================== */
.cursor{
  width:12px;height:12px;
  background:var(--cyan);
  border-radius:50%;
  position:fixed;pointer-events:none;
  z-index:9999;transform:translate(-50%,-50%);
  transition:transform 0.1s,background 0.2s;
  mix-blend-mode:screen;
}
.cursor-ring{
  width:36px;height:36px;
  border:1.5px solid rgba(6,182,212,0.4);
  border-radius:50%;
  position:fixed;pointer-events:none;
  z-index:9998;transform:translate(-50%,-50%);
  transition:all 0.15s ease;
}

/* ===================== PARTICLES ===================== */
#particles{position:fixed;inset:0;z-index:0;pointer-events:none;overflow:hidden;}

/* ===================== NAVBAR ===================== */
nav{
  position:fixed;top:0;left:0;right:0;
  z-index:1000;
  height:66px;
  display:flex;align-items:center;justify-content:space-between;
  padding:0 5%;
  background:rgba(5,8,15,0.85);
  backdrop-filter:blur(20px);
  border-bottom:1px solid rgba(124,92,191,0.15);
  transition:all 0.3s;
}

nav.scrolled{
  background:rgba(5,8,15,0.97);
  border-bottom-color:rgba(124,92,191,0.3);
  box-shadow:0 4px 30px rgba(0,0,0,0.6);
}

.logo{display:flex;align-items:center;gap:12px;text-decoration:none;}

.logo-mark{
  width:40px;height:40px;flex-shrink:0;
  filter:drop-shadow(0 0 8px rgba(124,92,191,0.6));
}

.logo-text-wrap{display:flex;flex-direction:column;line-height:1.1;}
.logo-name{
  font-size:17px;font-weight:900;
  background:linear-gradient(135deg,#fff,var(--php2));
  -webkit-background-clip:text;-webkit-text-fill-color:transparent;
  letter-spacing:-0.5px;
}
.logo-sub{font-size:9px;font-weight:500;color:var(--cyan);letter-spacing:2px;text-transform:uppercase;}

.nav-links{display:flex;align-items:center;gap:30px;list-style:none;}
.nav-links a{
  color:var(--text2);text-decoration:none;
  font-size:13.5px;font-weight:600;
  transition:color 0.2s;letter-spacing:0.2px;
  position:relative;
}
.nav-links a::after{
  content:'';position:absolute;bottom:-4px;left:0;
  width:0;height:1.5px;
  background:linear-gradient(90deg,var(--php),var(--cyan));
  transition:width 0.3s;border-radius:2px;
}
.nav-links a:hover{color:var(--text);}
.nav-links a:hover::after{width:100%;}

.nav-actions{display:flex;align-items:center;gap:10px;}

.btn-ghost{
  background:transparent;
  border:1px solid rgba(255,255,255,0.15);
  color:var(--text2);
  padding:7px 18px;border-radius:8px;
  font-size:13px;font-weight:600;
  cursor:pointer;font-family:inherit;
  transition:all 0.2s;text-decoration:none;display:inline-block;
}
.btn-ghost:hover{border-color:var(--php);color:var(--text);background:rgba(124,92,191,0.1);}

.btn-primary{
  background:linear-gradient(135deg,var(--php),var(--php2));
  border:none;color:#fff;
  padding:8px 20px;border-radius:8px;
  font-size:13px;font-weight:700;
  cursor:pointer;font-family:inherit;
  transition:all 0.25s;text-decoration:none;display:inline-block;
  box-shadow:0 0 16px rgba(124,92,191,0.35);
}
.btn-primary:hover{
  transform:translateY(-2px);
  box-shadow:0 4px 24px rgba(124,92,191,0.5);
}

.burger{
  display:none;flex-direction:column;gap:5px;
  cursor:pointer;background:none;border:none;padding:4px;
}
.burger span{display:block;width:24px;height:2px;background:var(--text);border-radius:2px;transition:all 0.3s;}
.burger.open span:nth-child(1){transform:translateY(7px) rotate(45deg);}
.burger.open span:nth-child(2){opacity:0;}
.burger.open span:nth-child(3){transform:translateY(-7px) rotate(-45deg);}

.mobile-nav{
  position:fixed;top:66px;left:0;right:0;
  background:rgba(8,13,24,0.98);
  backdrop-filter:blur(20px);
  border-bottom:1px solid var(--border);
  z-index:999;padding:0 5%;
  max-height:0;overflow:hidden;
  transition:max-height 0.4s ease,padding 0.3s;
}
.mobile-nav.open{max-height:400px;padding:20px 5%;}
.mobile-nav a{
  display:block;color:var(--text2);text-decoration:none;
  font-size:15px;font-weight:600;
  padding:13px 0;border-bottom:1px solid rgba(255,255,255,0.05);
  transition:color 0.2s;
}
.mobile-nav a:hover{color:var(--php2);}
.mobile-nav-btns{display:flex;gap:10px;margin-top:16px;padding-bottom:20px;}
.mobile-nav-btns a,.mobile-nav-btns button{flex:1;text-align:center;padding:10px;}

/* ===================== HERO ===================== */
#home{
  position:relative;min-height:100vh;
  display:flex;align-items:center;
  overflow:hidden;
  padding-top:66px;
}

.hero-grid{
  position:absolute;inset:0;
  background-image:
    linear-gradient(rgba(124,92,191,0.05) 1px,transparent 1px),
    linear-gradient(90deg,rgba(124,92,191,0.05) 1px,transparent 1px);
  background-size:60px 60px;
  animation:gridDrift 30s linear infinite;
}
@keyframes gridDrift{from{transform:translate(0,0);}to{transform:translate(60px,60px);}}

.hero-glow1{
  position:absolute;top:-20%;left:-10%;
  width:700px;height:700px;
  background:radial-gradient(circle,rgba(124,92,191,0.12) 0%,transparent 70%);
  animation:floatGlow 8s ease-in-out infinite;
}
.hero-glow2{
  position:absolute;bottom:-20%;right:-10%;
  width:600px;height:600px;
  background:radial-gradient(circle,rgba(6,182,212,0.08) 0%,transparent 70%);
  animation:floatGlow 10s ease-in-out infinite reverse;
}
@keyframes floatGlow{0%,100%{transform:scale(1) translate(0,0);}50%{transform:scale(1.08) translate(20px,-20px);}}

.hero-inner{
  position:relative;z-index:1;
  width:100%;max-width:1300px;margin:0 auto;
  padding:0 5%;
  display:grid;grid-template-columns:1fr 1fr;
  gap:60px;align-items:center;
  min-height:calc(100vh - 66px);
}

.hero-left{}

.hero-badge{
  display:inline-flex;align-items:center;gap:8px;
  background:rgba(124,92,191,0.12);
  border:1px solid rgba(124,92,191,0.3);
  border-radius:100px;
  padding:6px 16px;
  font-size:12px;font-weight:600;
  color:var(--php2);letter-spacing:0.5px;
  margin-bottom:28px;
  animation:fadeInDown 0.8s ease both;
}
.hero-badge-dot{
  width:6px;height:6px;border-radius:50%;
  background:var(--php2);
  animation:blink 1.5s ease-in-out infinite;
}
@keyframes blink{0%,100%{opacity:1;}50%{opacity:0.3;}}

.hero-title{
  font-size:clamp(2.5rem,5.5vw,4.2rem);
  font-weight:900;line-height:1.05;
  margin-bottom:24px;
  animation:fadeInUp 0.8s 0.2s ease both;
}
.hero-title .t1{
  display:block;color:var(--text);letter-spacing:-1px;
}
.hero-title .t2{
  display:block;
  background:linear-gradient(135deg,var(--php),var(--cyan),var(--php2));
  background-size:200% auto;
  -webkit-background-clip:text;-webkit-text-fill-color:transparent;
  animation:gradientShift 4s linear infinite;
  letter-spacing:-1px;
}
@keyframes gradientShift{0%{background-position:0%}100%{background-position:200%}}

.hero-sub{
  font-size:16px;font-weight:400;
  color:var(--text2);line-height:1.75;
  max-width:520px;margin-bottom:36px;
  animation:fadeInUp 0.8s 0.35s ease both;
}

.hero-actions{
  display:flex;gap:14px;flex-wrap:wrap;
  animation:fadeInUp 0.8s 0.5s ease both;
}

.btn-hero{
  display:inline-flex;align-items:center;gap:8px;
  padding:13px 28px;border-radius:10px;
  font-size:15px;font-weight:700;
  text-decoration:none;border:none;cursor:pointer;font-family:inherit;
  transition:all 0.25s;
}
.btn-hero-main{
  background:linear-gradient(135deg,var(--php),#9b78e0);
  color:#fff;
  box-shadow:0 0 24px rgba(124,92,191,0.4);
}
.btn-hero-main:hover{transform:translateY(-3px);box-shadow:0 8px 32px rgba(124,92,191,0.55);}
.btn-hero-outline{
  background:transparent;
  border:1.5px solid rgba(255,255,255,0.15);
  color:var(--text2);
}
.btn-hero-outline:hover{border-color:var(--cyan);color:var(--text);background:rgba(6,182,212,0.06);}

.hero-stats{
  display:flex;gap:36px;margin-top:44px;
  animation:fadeInUp 0.8s 0.65s ease both;
}
.hero-stat-num{
  font-size:26px;font-weight:800;
  background:linear-gradient(135deg,var(--text),var(--php2));
  -webkit-background-clip:text;-webkit-text-fill-color:transparent;
}
.hero-stat-label{font-size:12px;color:var(--text3);font-weight:500;margin-top:2px;}

/* ===================== 3D PHP SPHERE ===================== */
.hero-right{
  display:flex;align-items:center;justify-content:center;
  animation:fadeInRight 1s 0.3s ease both;
  position:relative;
}

.php-scene{
  position:relative;
  width:480px;height:480px;
}

.php-orbit-ring{
  position:absolute;inset:0;
  animation:rotateRing 20s linear infinite;
}

@keyframes rotateRing{from{transform:rotate(0deg);}to{transform:rotate(360deg);}}
@keyframes rotateRing2{from{transform:rotate(0deg) rotateX(60deg);}to{transform:rotate(-360deg) rotateX(60deg);}}

.php-core{
  position:absolute;
  top:50%;left:50%;transform:translate(-50%,-50%);
  width:220px;height:220px;
}

.code-palette{
  position:absolute;
  background:rgba(10,15,25,0.9);
  border:1px solid;
  border-radius:12px;
  padding:12px 16px;
  font-family:'Fira Code',monospace;
  font-size:11.5px;
  line-height:1.65;
  backdrop-filter:blur(12px);
  box-shadow:0 8px 32px rgba(0,0,0,0.5);
  min-width:180px;
  white-space:nowrap;
}

.cp1{top:-10px;right:-130px;border-color:rgba(124,92,191,0.4);animation:floatCard1 4s ease-in-out infinite;}
.cp2{bottom:20px;left:-140px;border-color:rgba(6,182,212,0.4);animation:floatCard2 5s ease-in-out infinite 0.8s;}
.cp3{top:180px;right:-150px;border-color:rgba(16,185,129,0.4);animation:floatCard3 4.5s ease-in-out infinite 1.5s;}
.cp4{top:-60px;left:-120px;border-color:rgba(249,115,22,0.4);animation:floatCard1 5.5s ease-in-out infinite 2s;}

@keyframes floatCard1{0%,100%{transform:translateY(0) rotate(-2deg);}50%{transform:translateY(-14px) rotate(1deg);}}
@keyframes floatCard2{0%,100%{transform:translateY(0) rotate(2deg);}50%{transform:translateY(-10px) rotate(-1deg);}}
@keyframes floatCard3{0%,100%{transform:translateY(0) rotate(-1deg);}50%{transform:translateY(-18px) rotate(2deg);}}

.code-window{
  background:rgba(8,13,24,0.95);
  border:1px solid var(--border);
  border-radius:14px;
  overflow:hidden;
  box-shadow:0 20px 60px rgba(0,0,0,0.6),0 0 0 1px rgba(124,92,191,0.1);
}
.cw-header{
  background:var(--surface);
  padding:10px 16px;
  display:flex;align-items:center;gap:8px;
  border-bottom:1px solid var(--border);
}
.cw-dot{width:10px;height:10px;border-radius:50%;}
.cw-title{margin-left:8px;font-size:11px;color:var(--text3);font-family:'Fira Code',monospace;}
.cw-body{padding:16px;font-family:'Fira Code',monospace;font-size:12px;line-height:1.7;}

/* CODE COLORS */
.kw{color:#c792ea;} /* keyword */
.fn{color:#82aaff;} /* function */
.str{color:#c3e88d;} /* string */
.num{color:#f78c6c;} /* number */
.cm{color:#546e7a;} /* comment */
.cl{color:#ffcb6b;} /* class */
.op{color:#89ddff;} /* operator */
.var{color:#f07178;} /* variable */
.punct{color:#89ddff;}

/* Typing cursor */
.typing-cursor{
  display:inline-block;width:2px;height:13px;
  background:var(--php2);vertical-align:middle;
  animation:cursorBlink 1s step-end infinite;
}
@keyframes cursorBlink{0%,100%{opacity:1;}50%{opacity:0;}}

/* Running line animation */
.code-run-line{
  position:relative;overflow:hidden;
}
.code-run-line::after{
  content:'';
  position:absolute;top:0;left:-100%;
  width:100%;height:100%;
  background:linear-gradient(90deg,transparent,rgba(124,92,191,0.15),transparent);
  animation:runLine 3s ease-in-out infinite;
}
@keyframes runLine{0%{left:-100%;}100%{left:100%;}}

@keyframes fadeInDown{from{opacity:0;transform:translateY(-20px);}to{opacity:1;transform:translateY(0);}}
@keyframes fadeInUp{from{opacity:0;transform:translateY(20px);}to{opacity:1;transform:translateY(0);}}
@keyframes fadeInRight{from{opacity:0;transform:translateX(40px);}to{opacity:1;transform:translateX(0);}}
@keyframes fadeIn{from{opacity:0;}to{opacity:1;}}

/* ===================== SECTION COMMON ===================== */
.section{padding:90px 0;}
.container{max-width:1260px;margin:0 auto;padding:0 5%;}

.sec-label{
  display:inline-flex;align-items:center;gap:8px;
  font-family:'Fira Code',monospace;
  font-size:11px;font-weight:500;
  color:var(--php2);letter-spacing:0.15em;
  text-transform:uppercase;margin-bottom:14px;
}
.sec-label::before{content:'//';color:var(--text3);}

.sec-title{
  font-size:clamp(1.8rem,3.5vw,2.8rem);
  font-weight:800;line-height:1.15;margin-bottom:16px;
}
.sec-title span{
  background:linear-gradient(135deg,var(--php),var(--cyan));
  -webkit-background-clip:text;-webkit-text-fill-color:transparent;
}

.sec-sub{font-size:15px;color:var(--text2);line-height:1.7;max-width:600px;}

/* ===================== LANGUAGES / OUR WORKS ===================== */
#works{background:var(--bg2);position:relative;overflow:hidden;}

.works-inner{
  display:grid;grid-template-columns:1fr 1fr;
  gap:60px;align-items:center;
}

.works-visual{position:relative;}

.lang-3d-grid{
  display:grid;grid-template-columns:repeat(3,1fr);
  gap:16px;
}

.lang-card{
  background:var(--surface);
  border:1px solid var(--border);
  border-radius:16px;padding:24px 18px;
  text-align:center;
  transition:all 0.35s;
  cursor:pointer;
  position:relative;overflow:hidden;
}
.lang-card::before{
  content:'';position:absolute;inset:0;
  background:var(--card-grad,linear-gradient(135deg,transparent,transparent));
  opacity:0;transition:opacity 0.35s;border-radius:16px;
}
.lang-card:hover::before{opacity:1;}
.lang-card:hover{
  transform:translateY(-8px) scale(1.02);
  border-color:var(--card-accent,var(--php));
  box-shadow:0 20px 40px rgba(0,0,0,0.5),0 0 0 1px var(--card-accent,var(--php));
}

.lang-card.php{--card-accent:#7c5cbf;--card-grad:linear-gradient(135deg,rgba(124,92,191,0.12),rgba(124,92,191,0.02));}
.lang-card.js{--card-accent:#eab308;--card-grad:linear-gradient(135deg,rgba(234,179,8,0.12),transparent);}
.lang-card.py{--card-accent:#3b82f6;--card-grad:linear-gradient(135deg,rgba(59,130,246,0.12),transparent);}
.lang-card.java{--card-accent:#f97316;--card-grad:linear-gradient(135deg,rgba(249,115,22,0.12),transparent);}
.lang-card.css{--card-accent:#06b6d4;--card-grad:linear-gradient(135deg,rgba(6,182,212,0.12),transparent);}
.lang-card.sql{--card-accent:#10b981;--card-grad:linear-gradient(135deg,rgba(16,185,129,0.12),transparent);}

.lang-svg-wrap{
  width:56px;height:56px;margin:0 auto 12px;
  display:flex;align-items:center;justify-content:center;
  position:relative;z-index:1;
  transition:transform 0.35s;
}
.lang-card:hover .lang-svg-wrap{transform:scale(1.15) rotate(-5deg);}

.lang-name{font-size:12px;font-weight:700;color:var(--text2);position:relative;z-index:1;}

/* ===================== GAME EDU ===================== */
#gameedu{background:var(--bg3);position:relative;}

.gameedu-grid{
  display:grid;grid-template-columns:1fr 1fr;gap:50px;align-items:center;
}

.gameedu-visual{
  position:relative;
  border-radius:20px;overflow:hidden;
  background:var(--surface);
  border:1px solid var(--border);
  aspect-ratio:4/3;
}

.game-screen{
  width:100%;height:100%;
  display:flex;flex-direction:column;
  font-family:'Fira Code',monospace;
}

.game-topbar{
  background:var(--surface2);
  padding:12px 20px;
  display:flex;align-items:center;justify-content:space-between;
  border-bottom:1px solid var(--border);
}
.game-dots{display:flex;gap:7px;}
.game-dot{width:11px;height:11px;border-radius:50%;}

.game-body{
  flex:1;padding:20px;display:flex;flex-direction:column;gap:10px;
  overflow:hidden;position:relative;
}

.game-output{
  flex:1;
  background:rgba(0,0,0,0.4);border-radius:10px;
  padding:14px;font-size:12px;color:var(--green);
  overflow:hidden;position:relative;
}
.go-line{animation:slideInLeft 0.4s ease both;}
@keyframes slideInLeft{from{opacity:0;transform:translateX(-10px);}to{opacity:1;transform:translateX(0);}}

.game-input-row{
  display:flex;gap:8px;
}
.game-input{
  flex:1;background:var(--surface);
  border:1px solid var(--border);
  border-radius:8px;padding:8px 14px;
  font-family:'Fira Code',monospace;font-size:12px;
  color:var(--text);outline:none;
}
.game-input:focus{border-color:var(--php);}
.game-run{
  background:linear-gradient(135deg,var(--php),var(--php2));
  border:none;color:#fff;
  padding:8px 18px;border-radius:8px;
  font-size:12px;font-weight:700;cursor:pointer;font-family:inherit;
  transition:all 0.2s;
}
.game-run:hover{transform:scale(1.05);box-shadow:0 0 16px rgba(124,92,191,0.5);}

.lang-pills{display:flex;flex-wrap:wrap;gap:8px;margin-top:24px;}
.lang-pill{
  padding:6px 14px;border-radius:100px;
  font-size:12px;font-weight:700;
  border:1.5px solid;cursor:pointer;
  transition:all 0.2s;
}
.lang-pill:hover{transform:scale(1.05);}

/* ===================== COURSES (CLASS) ===================== */
#class{background:var(--bg2);position:relative;overflow:hidden;}

.courses-showcase{
  display:grid;grid-template-columns:repeat(3,1fr);gap:24px;
  margin-top:48px;
}

.course-card{
  background:var(--surface);
  border:1px solid var(--border);
  border-radius:18px;
  overflow:hidden;
  transition:all 0.35s;
  position:relative;
  cursor:pointer;
}
.course-card:hover{
  transform:translateY(-10px);
  border-color:rgba(124,92,191,0.4);
  box-shadow:0 24px 60px rgba(0,0,0,0.5),0 0 0 1px rgba(124,92,191,0.2);
}

.course-hero{
  height:180px;
  display:flex;align-items:center;justify-content:center;
  position:relative;overflow:hidden;
}

.course-badge{
  position:absolute;top:12px;right:12px;
  background:linear-gradient(135deg,var(--orange),var(--orange2));
  color:#fff;font-size:10px;font-weight:800;
  padding:4px 10px;border-radius:20px;
  letter-spacing:0.5px;
}
.course-badge.hot{background:linear-gradient(135deg,var(--red),#f97316);}
.course-badge.new{background:linear-gradient(135deg,var(--green),#34d399);}

.course-body{padding:20px;}
.course-lang{
  font-family:'Fira Code',monospace;
  font-size:11px;font-weight:600;
  color:var(--text3);letter-spacing:1px;
  text-transform:uppercase;margin-bottom:8px;
}
.course-title{
  font-size:15px;font-weight:800;
  color:var(--text);margin-bottom:8px;line-height:1.3;
}
.course-meta{
  display:flex;gap:14px;font-size:11.5px;
  color:var(--text3);margin-bottom:14px;
}
.course-meta span{display:flex;align-items:center;gap:4px;}
.course-price{
  font-size:18px;font-weight:900;
  background:linear-gradient(135deg,var(--php),var(--php2));
  -webkit-background-clip:text;-webkit-text-fill-color:transparent;
  margin-bottom:14px;
}
.course-price.free{
  background:linear-gradient(135deg,var(--green),#34d399);
  -webkit-background-clip:text;-webkit-text-fill-color:transparent;
}

.btn-course{
  width:100%;
  background:linear-gradient(135deg,var(--surface2),var(--surface2));
  border:1.5px solid rgba(124,92,191,0.3);
  color:var(--php2);
  padding:9px;border-radius:9px;
  font-size:13px;font-weight:700;
  cursor:pointer;font-family:inherit;
  transition:all 0.25s;
}
.btn-course:hover{
  background:linear-gradient(135deg,var(--php),var(--php2));
  border-color:transparent;color:#fff;
  box-shadow:0 4px 16px rgba(124,92,191,0.4);
}

/* Carousel for courses */
.carousel-wrap{position:relative;}
.carousel-overflow{overflow:hidden;}
.carousel-track{
  display:flex;gap:24px;
  transition:transform 0.45s cubic-bezier(0.25,0.46,0.45,0.94);
}
.carousel-track .course-card{
  width: calc(33.333% - 16px);
  min-width: calc(33.333% - 16px);
  flex: 0 0 auto;
}
.car-btn{
  position:absolute;top:50%;
  width:44px;height:44px;
  transform:translateY(-50%);
  background:var(--surface);
  border:1px solid var(--border);
  color:var(--text2);
  border-radius:50%;cursor:pointer;
  font-size:18px;transition:all 0.2s;
  display:flex;align-items:center;justify-content:center;
}
.car-btn:hover{background:var(--php);border-color:var(--php);color:#fff;}
.car-btn.prev{left:-22px;}
.car-btn.next{right:-22px;}

/* ===================== ABOUT ===================== */
#about{background:var(--bg);position:relative;}

.about-grid{
  display:grid;grid-template-columns:repeat(3,1fr);gap:24px;
  margin-top:48px;
}

.about-card{
  background:var(--surface);
  border:1px solid var(--border);
  border-radius:16px;padding:28px 24px;
  transition:all 0.3s;position:relative;overflow:hidden;
}
.about-card::before{
  content:'';position:absolute;
  top:-50%;right:-50%;
  width:120px;height:120px;
  border-radius:50%;
  background:radial-gradient(circle,var(--card-glow,rgba(124,92,191,0.15)),transparent);
  transition:all 0.4s;
}
.about-card:hover::before{transform:scale(2.5);}
.about-card:hover{
  border-color:rgba(124,92,191,0.25);
  transform:translateY(-6px);
  box-shadow:0 16px 40px rgba(0,0,0,0.4);
}
.about-card:nth-child(2n){--card-glow:rgba(6,182,212,0.15);}
.about-card:nth-child(3n){--card-glow:rgba(16,185,129,0.12);}

.about-icon{
  width:52px;height:52px;
  border-radius:12px;
  display:flex;align-items:center;justify-content:center;
  font-size:24px;margin-bottom:18px;
  background:rgba(124,92,191,0.12);
  border:1px solid rgba(124,92,191,0.2);
}
.about-card h3{font-size:16px;font-weight:800;margin-bottom:10px;}
.about-card p{font-size:13.5px;color:var(--text2);line-height:1.7;}

/* ===================== FOOTER ===================== */
footer{
  background:var(--bg2);
  border-top:1px solid var(--border);
  padding:80px 0 0;
  position:relative;overflow:hidden;
}

footer::before{
  content:'';position:absolute;
  top:-200px;left:50%;transform:translateX(-50%);
  width:1000px;height:400px;
  background:radial-gradient(ellipse,rgba(124,92,191,0.08) 0%,transparent 70%);
  pointer-events:none;
}

.footer-top{
  display:grid;grid-template-columns:1.8fr 1fr 1fr 1.8fr;gap:48px;
  padding:0 5% 48px;
}

.footer-brand p{
  font-size:13.5px;color:var(--text2);line-height:1.8;
  margin-top:16px;max-width:320px;
}
.footer-contact{
  margin-top:20px;display:flex;flex-direction:column;gap:10px;
}
.footer-contact a{
  display:flex;align-items:center;gap:10px;
  font-size:13.5px;color:var(--text2);text-decoration:none;
  transition:all 0.3s ease;
}
.footer-contact a:hover{color:var(--php2);transform:translateX(4px);}
.fc-icon{
  width:30px;height:30px;border-radius:8px;
  background:rgba(124,92,191,0.12);
  display:flex;align-items:center;justify-content:center;
  font-size:14px;color:var(--php2);flex-shrink:0;
  border:1px solid rgba(124,92,191,0.15);
}

.footer-col h4{
  font-size:14.5px;font-weight:800;
  color:var(--text);margin-bottom:20px;
  letter-spacing:0.5px;
  text-transform:uppercase;
  position:relative;
}
.footer-col h4::after{
  content:'';position:absolute;bottom:-6px;left:0;
  width:24px;height:2px;background:var(--php);
  border-radius:2px;
}
.footer-col a{
  display:block;font-size:13.5px;
  color:var(--text2);text-decoration:none;
  margin-bottom:12px;transition:all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
}
.footer-col a:hover{
  color:var(--cyan2);
  transform:translateX(6px);
  text-shadow:0 0 10px rgba(34,211,238,0.3);
}

.footer-socials{display:flex;gap:12px;margin-top:24px;}
.social-btn{
  width:40px;height:40px;border-radius:10px;
  background:var(--surface);
  border:1px solid var(--border);
  display:flex;align-items:center;justify-content:center;
  cursor:pointer;
  transition:all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
  text-decoration:none;color:var(--text2);
}
.social-btn svg{
  width:18px;height:18px;
  fill:currentColor;
  transition:fill 0.3s ease;
}
.social-btn:hover{
  transform:translateY(-5px);
  color:#fff;
}
.social-btn.twitter:hover {
  background:#1da1f2;border-color:#1da1f2;
  box-shadow:0 0 15px rgba(29, 161, 242, 0.5);
}
.social-btn.linkedin:hover {
  background:#0077b5;border-color:#0077b5;
  box-shadow:0 0 15px rgba(0, 119, 181, 0.5);
}
.social-btn.instagram:hover {
  background:linear-gradient(45deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%);
  border-color:#e6683c;
  box-shadow:0 0 15px rgba(220, 39, 67, 0.5);
}
.social-btn.youtube:hover {
  background:#ff0000;border-color:#ff0000;
  box-shadow:0 0 15px rgba(255, 0, 0, 0.5);
}

.footer-newsletter p{
  font-size:13.5px;color:var(--text2);line-height:1.75;margin-bottom:16px;
}
.newsletter-form{
  display:flex;gap:8px;width:100%;
}
.newsletter-form input{
  flex:1;background:var(--bg3);
  border:1.5px solid var(--border);
  border-radius:8px;padding:10px 14px;
  font-family:inherit;font-size:13px;
  color:var(--text);outline:none;
  transition:all 0.3s ease;
}
.newsletter-form input:focus{
  border-color:var(--php2);
  box-shadow:0 0 10px rgba(155, 120, 224, 0.3);
}
.newsletter-form button{
  background:linear-gradient(135deg,var(--php),var(--php2));
  border:none;color:#fff;
  padding:10px 18px;border-radius:8px;
  font-size:13px;font-weight:700;cursor:pointer;font-family:inherit;
  transition:all 0.25s;
  box-shadow:0 0 12px rgba(124, 92, 191, 0.3);
}
.newsletter-form button:hover{
  transform:translateY(-2px);
  box-shadow:0 4px 16px rgba(124, 92, 191, 0.5);
}

.footer-divider{height:1px;background:var(--border);margin:0 5%;}

.footer-bottom{
  padding:24px 5%;
  display:flex;align-items:center;justify-content:space-between;
  font-size:13px;color:var(--text2);
  border-top:1px solid var(--border);
  flex-wrap:wrap;gap:10px;
}
.footer-bottom a{color:var(--php2);text-decoration:none;font-weight:600;transition:color 0.2s;}
.footer-bottom a:hover{color:var(--cyan2);}

/* ===================== MODAL ===================== */
.modal-overlay{
  position:fixed;inset:0;
  background:rgba(0,0,0,0.75);
  backdrop-filter:blur(8px);
  z-index:2000;
  display:flex;align-items:center;justify-content:center;
  opacity:0;pointer-events:none;
  transition:opacity 0.3s;
}
.modal-overlay.open{opacity:1;pointer-events:all;}

.modal{
  background:var(--surface);
  border:1px solid var(--border);
  border-radius:20px;
  padding:36px;width:100%;max-width:420px;
  position:relative;
  box-shadow:0 30px 80px rgba(0,0,0,0.6),0 0 0 1px rgba(124,92,191,0.15);
  transform:translateY(20px);
  transition:transform 0.3s;
}
.modal-overlay.open .modal{transform:translateY(0);}

.modal-close{
  position:absolute;top:16px;right:16px;
  width:30px;height:30px;border-radius:50%;
  background:var(--bg3);border:1px solid var(--border);
  color:var(--text2);cursor:pointer;font-size:16px;
  display:flex;align-items:center;justify-content:center;transition:all 0.2s;
}
.modal-close:hover{background:var(--php);border-color:var(--php);color:#fff;}

.modal-tabs2{
  display:flex;gap:0;
  background:var(--bg3);
  border-radius:10px;padding:4px;margin-bottom:28px;
}
.mtab{
  flex:1;padding:8px;border-radius:7px;
  background:none;border:none;
  font-size:13px;font-weight:700;color:var(--text3);
  cursor:pointer;font-family:inherit;transition:all 0.2s;
}
.mtab.active{background:var(--surface2);color:var(--text);box-shadow:0 2px 8px rgba(0,0,0,0.3);}

.modal h2{font-size:22px;font-weight:800;margin-bottom:6px;}
.modal > p,.modal-sub{font-size:13px;color:var(--text2);margin-bottom:24px;}

.form-group{margin-bottom:16px;}
.form-group label{display:block;font-size:11.5px;font-weight:700;color:var(--text2);margin-bottom:6px;letter-spacing:0.3px;}
.form-group input{
  width:100%;padding:10px 14px;
  background:var(--bg3);
  border:1.5px solid var(--border);
  border-radius:9px;font-size:14px;
  font-family:inherit;color:var(--text);outline:none;
  transition:border-color 0.2s;
}
.form-group input:focus{border-color:var(--php);}

.btn-submit2{
  width:100%;
  background:linear-gradient(135deg,var(--php),var(--php2));
  border:none;color:#fff;
  padding:12px;border-radius:10px;
  font-size:14px;font-weight:700;
  cursor:pointer;font-family:inherit;
  margin-top:8px;transition:all 0.25s;
  box-shadow:0 0 20px rgba(124,92,191,0.3);
}
.btn-submit2:hover{transform:translateY(-2px);box-shadow:0 6px 24px rgba(124,92,191,0.5);}

.modal-switch{
  text-align:center;margin-top:18px;
  font-size:12.5px;color:var(--text3);
}
.modal-switch a{color:var(--php2);font-weight:700;text-decoration:none;cursor:pointer;}

.tc-content{display:none;}
.tc-content.active{display:block;}

/* ===================== PROGRESS BAR ===================== */
.progress-bar{position:fixed;top:0;left:0;right:0;height:2px;z-index:1001;}
.progress-fill{height:100%;background:linear-gradient(90deg,var(--php),var(--cyan),var(--php2));width:0%;transition:width 0.1s;}

/* ===================== SCROLL ANIMATIONS ===================== */
.reveal{
  opacity:0;transform:translateY(30px);
  transition:opacity 0.7s ease,transform 0.7s ease;
}
.reveal.revealed{opacity:1;transform:translateY(0);}
.reveal-delay-1{transition-delay:0.1s;}
.reveal-delay-2{transition-delay:0.2s;}
.reveal-delay-3{transition-delay:0.3s;}
.reveal-delay-4{transition-delay:0.4s;}

/* ===================== RESPONSIVE ===================== */
@media(max-width:1024px){
  .hero-inner{grid-template-columns:1fr;}
  .hero-right{display:none;}
  .works-inner,.gameedu-grid{grid-template-columns:1fr;}
  .courses-showcase{display:grid;grid-template-columns:repeat(2,1fr);gap:20px;}
  .carousel-track .course-card{
    width: calc(50% - 12px);
    min-width: calc(50% - 12px);
    flex: 0 0 auto;
  }
  .about-grid{grid-template-columns:1fr 1fr;}
  .footer-top{grid-template-columns:1fr 1fr;}
}
@media(max-width:768px){
  .nav-links,.nav-actions{display:none;}
  .burger{display:flex;}
  .about-grid{grid-template-columns:1fr;}
  .footer-top{grid-template-columns:1fr;}
  .lang-3d-grid{grid-template-columns:repeat(2,1fr);}
  .carousel-track .course-card{
    width: calc(100% - 0px);
    min-width: calc(100% - 0px);
    flex: 0 0 auto;
  }
  .team-cards{flex-direction:column;}
}
</style>
</head>
<body>

<!-- PROGRESS -->
<div class="progress-bar"><div class="progress-fill" id="prog"></div></div>

<!-- CUSTOM CURSOR -->
<div class="cursor" id="cursor"></div>
<div class="cursor-ring" id="cursorRing"></div>

<!-- PARTICLES -->
<canvas id="particles"></canvas>

<!-- ======================== NAVBAR ======================== -->
<nav id="navbar">
  <a href="#home" class="logo">
    <img src="{{ asset('assets/images/logo.png') }}" class="logo-mark" alt="Logo" width="40" height="40" style="width:40px;height:40px;object-fit:contain;filter:drop-shadow(0 0 6px rgba(6,182,212,0.4));">
    <div class="logo-text-wrap">
      <span class="logo-name">talentgroup.id</span>
      <span class="logo-sub">Academy</span>
    </div>
  </a>

  <ul class="nav-links">
    <li><a href="#home">Home</a></li>
    <li><a href="#works">Our Works</a></li>
    <li><a href="#gameedu">Game Edu</a></li>
    <li><a href="#class">Kelas</a></li>
    <li><a href="#about">About</a></li>
  </ul>

  <div class="nav-actions">
    <a href="{{ route('login') }}" class="btn-ghost">Masuk</a>
    <a href="{{ route('register') }}" class="btn-primary">Daftar Gratis</a>
  </div>

  <button class="burger" id="burger" onclick="toggleMobileNav()">
    <span></span><span></span><span></span>
  </button>
</nav>

<div class="mobile-nav" id="mobileNav">
  <a href="#home" onclick="closeMobileNav()">Home</a>
  <a href="#works" onclick="closeMobileNav()">Our Works</a>
  <a href="#gameedu" onclick="closeMobileNav()">Game Edu</a>
  <a href="#class" onclick="closeMobileNav()">Kelas</a>
  <a href="#about" onclick="closeMobileNav()">About</a>
  <div class="mobile-nav-btns">
    <a href="{{ route('login') }}" class="btn-ghost">Masuk</a>
    <a href="{{ route('register') }}" class="btn-primary">Daftar</a>
  </div>
</div>

<!-- ======================== HERO ======================== -->
<section id="home">
  <div class="hero-grid"></div>
  <div class="hero-glow1"></div>
  <div class="hero-glow2"></div>

  <div class="hero-inner">
    <div class="hero-left">
      <div class="hero-badge">
        <div class="hero-badge-dot"></div>
        Platform #1 Belajar Coding Indonesia
      </div>

      <h1 class="hero-title">
        <span class="t1">Raih Ilmu,</span>
        <span class="t2">Kuasai Kode.</span>
      </h1>

      <p class="hero-sub">
        talentgroup.id menghadirkan pengalaman belajar pemrograman yang <strong style="color:var(--text)">imersif, interaktif, dan menyenangkan</strong> — dari PHP hingga AI, semua dalam satu platform.
      </p>

      <div class="hero-actions">
        <a href="{{ route('register') }}" class="btn-hero btn-hero-main">
          🚀 Mulai Belajar Gratis
        </a>
        <a href="#works" class="btn-hero btn-hero-outline">
          ▷ Lihat Kelas
        </a>
      </div>

      <div class="hero-stats">
        <div>
          <div class="hero-stat-num">10K+</div>
          <div class="hero-stat-label">Pelajar Aktif</div>
        </div>
        <div>
          <div class="hero-stat-num">50+</div>
          <div class="hero-stat-label">Kursus Tersedia</div>
        </div>
        <div>
          <div class="hero-stat-num">8</div>
          <div class="hero-stat-label">Bahasa Pemrograman</div>
        </div>
      </div>
    </div>

    <!-- 3D PHP Scene -->
    <div class="hero-right">
      <div class="php-scene">

        <!-- Floating code palette 1: PHP class -->
        <div class="code-palette cp1">
          <div style="color:var(--text3);font-size:10px;margin-bottom:6px;">// PHP Class</div>
          <div><span class="kw">class</span> <span class="cl">talentgroup</span> <span class="punct">{</span></div>
          <div class="code-run-line">&nbsp;&nbsp;<span class="kw">public</span> <span class="fn">learn</span><span class="punct">(</span><span class="var">$skill</span><span class="punct">)</span> <span class="punct">{</span></div>
          <div>&nbsp;&nbsp;&nbsp;&nbsp;<span class="kw">return</span> <span class="str">"mastered"</span><span class="punct">;</span></div>
          <div>&nbsp;&nbsp;<span class="punct">}</span></div>
          <div><span class="punct">}</span></div>
        </div>

        <!-- Floating code palette 2: JS async -->
        <div class="code-palette cp2">
          <div style="color:var(--text3);font-size:10px;margin-bottom:6px;">// JavaScript</div>
          <div><span class="kw">const</span> <span class="var">fetch</span> <span class="op">=</span> <span class="kw">async</span> <span class="punct">()</span> <span class="op">=></span> <span class="punct">{</span></div>
          <div class="code-run-line">&nbsp;&nbsp;<span class="kw">await</span> <span class="fn">learn</span><span class="punct">(</span><span class="str">'php'</span><span class="punct">);</span></div>
          <div>&nbsp;&nbsp;<span class="fn">console</span><span class="punct">.</span><span class="fn">log</span><span class="punct">(</span><span class="str">"✓ done"</span><span class="punct">);</span></div>
          <div><span class="punct">}</span></div>
        </div>

        <!-- Floating code palette 3: Python -->
        <div class="code-palette cp3">
          <div style="color:var(--text3);font-size:10px;margin-bottom:6px;">// Python</div>
          <div><span class="kw">def</span> <span class="fn">course</span><span class="punct">(</span><span class="var">lang</span><span class="punct">):</span></div>
          <div class="code-run-line">&nbsp;&nbsp;<span class="var">skills</span> <span class="op">=</span> <span class="punct">[]</span></div>
          <div>&nbsp;&nbsp;<span class="var">skills</span><span class="punct">.</span><span class="fn">append</span><span class="punct">(</span><span class="var">lang</span><span class="punct">)</span></div>
          <div>&nbsp;&nbsp;<span class="kw">return</span> <span class="var">skills</span></div>
        </div>

        <!-- Floating code palette 4: SQL -->
        <div class="code-palette cp4">
          <div style="color:var(--text3);font-size:10px;margin-bottom:6px;">// SQL Query</div>
          <div><span class="kw">SELECT</span> <span class="op">*</span> <span class="kw">FROM</span></div>
          <div class="code-run-line">&nbsp;&nbsp;<span class="cl">students</span></div>
          <div><span class="kw">WHERE</span> <span class="var">progress</span> <span class="op">=</span> <span class="num">100</span></div>
          <div><span class="kw">ORDER BY</span> <span class="var">skill</span> <span class="kw">DESC</span><span class="punct">;</span></div>
        </div>

        <!-- Central PHP 3D SVG -->
        <div class="php-core">
          <svg viewBox="0 0 220 220" width="220" height="220" xmlns="http://www.w3.org/2000/svg">
            <defs>
              <radialGradient id="phpSphere" cx="40%" cy="35%" r="60%">
                <stop offset="0%" stop-color="#9b78e0"/>
                <stop offset="40%" stop-color="#7c5cbf"/>
                <stop offset="100%" stop-color="#3b1d8a"/>
              </radialGradient>
              <radialGradient id="phpShine" cx="30%" cy="25%" r="40%">
                <stop offset="0%" stop-color="rgba(255,255,255,0.35)"/>
                <stop offset="100%" stop-color="rgba(255,255,255,0)"/>
              </radialGradient>
              <filter id="phpBlur"><feGaussianBlur stdDeviation="8"/></filter>
              <filter id="phpGlow">
                <feGaussianBlur stdDeviation="4" result="blur"/>
                <feMerge><feMergeNode in="blur"/><feMergeNode in="SourceGraphic"/></feMerge>
              </filter>
              <style>
                @keyframes sphereSpin{0%{transform:rotate(0deg);}100%{transform:rotate(360deg);}}
                @keyframes floatSphere{0%,100%{transform:translateY(0);}50%{transform:translateY(-12px);}}
                @keyframes orbitX{0%{transform:rotate(0deg) translateX(90px) rotate(0deg);}100%{transform:rotate(360deg) translateX(90px) rotate(-360deg);}}
                @keyframes orbitY{0%{transform:rotate(90deg) translateX(90px) rotate(-90deg);}100%{transform:rotate(450deg) translateX(90px) rotate(-450deg);}}
                @keyframes orbitZ{0%{transform:rotate(45deg) translateX(85px) rotate(-45deg);}100%{transform:rotate(405deg) translateX(85px) rotate(-405deg);}}
                .sphere-group{animation:floatSphere 4s ease-in-out infinite;}
                .orbit-dot-x{transform-origin:110px 110px;animation:orbitX 5s linear infinite;}
                .orbit-dot-y{transform-origin:110px 110px;animation:orbitY 7s linear infinite;}
                .orbit-dot-z{transform-origin:110px 110px;animation:orbitZ 6s linear infinite;}
                .orbit-ring-1{transform-origin:110px 110px;animation:sphereSpin 8s linear infinite;}
                .orbit-ring-2{transform-origin:110px 110px;animation:sphereSpin 12s linear infinite reverse;}
                .orbit-ring-3{transform-origin:110px 110px;animation:sphereSpin 10s linear infinite;}
              </style>
            </defs>

            <!-- Shadow -->
            <ellipse cx="110" cy="198" rx="55" ry="10" fill="rgba(0,0,0,0.4)" filter="url(#phpBlur)" class="sphere-group"/>

            <!-- Orbit rings -->
            <g class="sphere-group">
              <ellipse class="orbit-ring-1" cx="110" cy="110" rx="90" ry="30" fill="none" stroke="rgba(124,92,191,0.2)" stroke-width="1" stroke-dasharray="6,4"/>
              <ellipse class="orbit-ring-2" cx="110" cy="110" rx="75" ry="75" fill="none" stroke="rgba(6,182,212,0.15)" stroke-width="1" stroke-dasharray="4,6" transform="rotate(60,110,110)"/>
              <ellipse class="orbit-ring-3" cx="110" cy="110" rx="85" ry="28" fill="none" stroke="rgba(16,185,129,0.15)" stroke-width="1" stroke-dasharray="3,5" transform="rotate(-45,110,110)"/>

              <!-- Orbit dots -->
              <circle class="orbit-dot-x" cx="110" cy="110" r="5" fill="var(--cyan)" filter="url(#phpGlow)"/>
              <circle class="orbit-dot-y" cx="110" cy="110" r="4" fill="var(--green)" filter="url(#phpGlow)"/>
              <circle class="orbit-dot-z" cx="110" cy="110" r="4" fill="var(--orange)" filter="url(#phpGlow)"/>

              <!-- Main sphere -->
              <circle cx="110" cy="110" r="68" fill="url(#phpSphere)" filter="url(#phpGlow)"/>
              <circle cx="110" cy="110" r="68" fill="url(#phpShine)"/>

              <!-- PHP text on sphere -->
              <text x="110" y="118" text-anchor="middle" font-family="Outfit,sans-serif" font-weight="900" font-size="28" fill="rgba(255,255,255,0.95)" letter-spacing="-1">PHP</text>
              <text x="110" y="134" text-anchor="middle" font-family="Fira Code,monospace" font-weight="400" font-size="9" fill="rgba(255,255,255,0.45)" letter-spacing="3">&lt;?php echo</text>

              <!-- Sphere grid lines -->
              <ellipse cx="110" cy="110" r="68" fill="none" stroke="rgba(255,255,255,0.06)" stroke-width="1"/>
              <line x1="42" y1="110" x2="178" y2="110" stroke="rgba(255,255,255,0.06)" stroke-width="1"/>
              <line x1="110" y1="42" x2="110" y2="178" stroke="rgba(255,255,255,0.06)" stroke-width="1"/>
              <ellipse cx="110" cy="110" rx="68" ry="28" fill="none" stroke="rgba(255,255,255,0.06)" stroke-width="1"/>
            </g>
          </svg>
        </div>

        <!-- Orbit ring SVG background -->
        <svg style="position:absolute;inset:0;width:100%;height:100%;pointer-events:none;" viewBox="0 0 480 480" xmlns="http://www.w3.org/2000/svg">
          <defs>
            <style>
              @keyframes bigRingRotate{from{transform:rotate(0deg);transform-origin:240px 240px;}to{transform:rotate(360deg);transform-origin:240px 240px;}}
              .bigring1{animation:bigRingRotate 25s linear infinite;transform-origin:240px 240px;}
              .bigring2{animation:bigRingRotate 35s linear infinite reverse;transform-origin:240px 240px;}
            </style>
          </defs>
          <g class="bigring1">
            <circle cx="240" cy="240" r="200" fill="none" stroke="rgba(124,92,191,0.06)" stroke-width="1" stroke-dasharray="8,12"/>
            <circle cx="440" cy="240" r="6" fill="var(--php)" opacity="0.6"/>
          </g>
          <g class="bigring2">
            <circle cx="240" cy="240" r="230" fill="none" stroke="rgba(6,182,212,0.05)" stroke-width="1" stroke-dasharray="4,16"/>
            <circle cx="240" cy="10" r="5" fill="var(--cyan)" opacity="0.5"/>
          </g>
        </svg>

      </div>
    </div>
  </div>
</section>

<!-- ======================== OUR WORKS ======================== -->
<section id="works" class="section" style="background:var(--bg2);">
  <div class="container">
    <div class="reveal">
      <div class="sec-label">Our Works</div>
      <h2 class="sec-title">Mengenal <span>talentgroup.id</span><br>Lebih Dekat</h2>
      <p class="sec-sub">Platform edukasi digital modern yang dirancang untuk mempersiapkan talenta digital Indonesia menghadapi era industri 4.0.</p>
    </div>

    <div class="works-inner" style="margin-top:48px;">
      <div class="lang-3d-grid reveal">
        <!-- PHP -->
        <div class="lang-card php reveal reveal-delay-1">
          <div class="lang-svg-wrap">
            <svg viewBox="0 0 54 54" width="54" height="54">
              <defs><radialGradient id="phpg" cx="40%" cy="35%" r="60%"><stop offset="0%" stop-color="#9b78e0"/><stop offset="100%" stop-color="#5b3fa6"/></radialGradient></defs>
              <ellipse cx="27" cy="27" rx="26" ry="16" fill="url(#phpg)"/>
              <text x="27" y="32" text-anchor="middle" font-family="Outfit" font-weight="900" font-size="13" fill="white">php</text>
            </svg>
          </div>
          <div class="lang-name" style="color:#9b78e0;">PHP</div>
        </div>
        <!-- JS -->
        <div class="lang-card js reveal reveal-delay-2">
          <div class="lang-svg-wrap">
            <svg viewBox="0 0 54 54" width="54" height="54">
              <rect width="54" height="54" rx="8" fill="#eab308"/>
              <text x="27" y="35" text-anchor="middle" font-family="Outfit" font-weight="900" font-size="20" fill="#111">JS</text>
            </svg>
          </div>
          <div class="lang-name" style="color:#eab308;">JavaScript</div>
        </div>
        <!-- Python -->
        <div class="lang-card py reveal reveal-delay-3">
          <div class="lang-svg-wrap">
            <svg viewBox="0 0 54 54" width="54" height="54">
              <defs><linearGradient id="pyg" x1="0" y1="0" x2="54" y2="54"><stop stop-color="#3b82f6"/><stop offset="1" stop-color="var(--yellow)"/></linearGradient></defs>
              <circle cx="27" cy="27" r="25" fill="url(#pyg)"/>
              <text x="27" y="32" text-anchor="middle" font-family="Outfit" font-weight="900" font-size="11" fill="white">Python</text>
            </svg>
          </div>
          <div class="lang-name" style="color:#3b82f6;">Python</div>
        </div>
        <!-- Java -->
        <div class="lang-card java reveal reveal-delay-1">
          <div class="lang-svg-wrap">
            <svg viewBox="0 0 54 54" width="54" height="54">
              <defs><radialGradient id="javag"><stop offset="0%" stop-color="#f97316"/><stop offset="100%" stop-color="#b45309"/></radialGradient></defs>
              <ellipse cx="27" cy="27" rx="24" ry="24" fill="url(#javag)"/>
              <text x="27" y="32" text-anchor="middle" font-family="Outfit" font-weight="900" font-size="11" fill="white">Java</text>
            </svg>
          </div>
          <div class="lang-name" style="color:#f97316;">Java</div>
        </div>
        <!-- CSS -->
        <div class="lang-card css reveal reveal-delay-2">
          <div class="lang-svg-wrap">
            <svg viewBox="0 0 54 54" width="54" height="54">
              <rect width="54" height="54" rx="8" fill="#06b6d4"/>
              <text x="27" y="35" text-anchor="middle" font-family="Outfit" font-weight="900" font-size="14" fill="white">CSS</text>
            </svg>
          </div>
          <div class="lang-name" style="color:#06b6d4;">CSS</div>
        </div>
        <!-- SQL -->
        <div class="lang-card sql reveal reveal-delay-3">
          <div class="lang-svg-wrap">
            <svg viewBox="0 0 54 54" width="54" height="54">
              <defs><linearGradient id="sqlg" x1="0" y1="0" x2="54" y2="54"><stop stop-color="#10b981"/><stop offset="1" stop-color="#065f46"/></linearGradient></defs>
              <circle cx="27" cy="27" r="25" fill="url(#sqlg)"/>
              <text x="27" y="32" text-anchor="middle" font-family="Outfit" font-weight="900" font-size="13" fill="white">SQL</text>
            </svg>
          </div>
          <div class="lang-name" style="color:#10b981;">SQL</div>
        </div>
      </div>

      <div class="reveal reveal-delay-2">
        <!-- 3D Code window -->
        <div class="code-window" style="transform:perspective(800px) rotateY(-6deg) rotateX(3deg);box-shadow:30px 30px 60px rgba(0,0,0,0.5);">
          <div class="cw-header">
            <div class="cw-dot" style="background:var(--red);"></div>
            <div class="cw-dot" style="background:var(--yellow);"></div>
            <div class="cw-dot" style="background:#10b981;"></div>
            <span class="cw-title">talentgroup.php — talentgroup.id</span>
          </div>
          <div class="cw-body">
            <div><span class="cm">// talentgroup.id — Platform Coding #1</span></div>
            <div><span class="kw">&lt;?php</span></div>
            <br>
            <div><span class="kw">namespace</span> <span class="cl">talentgroup\Academy</span><span class="punct">;</span></div>
            <br>
            <div class="code-run-line"><span class="kw">class</span> <span class="cl">Student</span> <span class="kw">extends</span> <span class="cl">User</span> <span class="punct">{</span></div>
            <div>&nbsp;&nbsp;<span class="kw">protected</span> <span class="var">$skills</span> <span class="op">=</span> <span class="punct">[];</span></div>
            <br>
            <div>&nbsp;&nbsp;<span class="kw">public function</span> <span class="fn">enroll</span><span class="punct">(</span><span class="cl">Course</span> <span class="var">$course</span><span class="punct">): </span><span class="cl">void</span></div>
            <div>&nbsp;&nbsp;<span class="punct">{</span></div>
            <div class="code-run-line">&nbsp;&nbsp;&nbsp;&nbsp;<span class="var">$this</span><span class="op">-></span><span class="fn">courses</span><span class="punct">[]</span> <span class="op">=</span> <span class="var">$course</span><span class="punct">;</span></div>
            <div>&nbsp;&nbsp;&nbsp;&nbsp;<span class="var">$this</span><span class="op">-></span><span class="fn">notify</span><span class="punct">(</span><span class="str">'enrolled'</span><span class="punct">);</span></div>
            <div>&nbsp;&nbsp;<span class="punct">}</span></div>
            <br>
            <div>&nbsp;&nbsp;<span class="kw">public function</span> <span class="fn">progress</span><span class="punct">(): </span><span class="cl">int</span></div>
            <div>&nbsp;&nbsp;<span class="punct">{</span></div>
            <div>&nbsp;&nbsp;&nbsp;&nbsp;<span class="kw">return</span> <span class="fn">round</span><span class="punct">(</span><span class="var">$this</span><span class="op">-></span><span class="var">completed</span> <span class="op">/</span> <span class="var">$this</span><span class="op">-></span><span class="var">total</span> <span class="op">*</span> <span class="num">100</span><span class="punct">);</span></div>
            <div>&nbsp;&nbsp;<span class="punct">}</span></div>
            <div><span class="punct">}</span><span class="typing-cursor"></span></div>
          </div>
        </div>

        <div style="margin-top:28px;">
          <h3 style="font-size:1.4rem;font-weight:800;margin-bottom:12px;">Platform Edukasi Coding Terbaik</h3>
          <p style="font-size:14px;color:var(--text2);line-height:1.8;margin-bottom:20px;">talentgroup.id menyediakan kursus pemrograman interaktif, game edukatif, dan komunitas belajar yang aktif. Mulai dari PHP hingga Machine Learning — semua tersedia dengan kurikulum berbasis industri.</p>
          <a href="{{ route('register') }}" class="btn-primary" style="padding:12px 28px;font-size:14px;display:inline-block;text-align:center;">
            Bergabung Sekarang →
          </a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ======================== GAME EDU ======================== -->
<section id="gameedu" class="section">
  <div class="container">
    <div class="reveal" style="text-align:center;margin-bottom:48px;">
      <div class="sec-label" style="justify-content:center;">Game Edu</div>
      <h2 class="sec-title" style="text-align:center;">Belajar Lewat <span>Game Seru</span></h2>
      <p class="sec-sub" style="text-align:center;margin:0 auto;">Tantang dirimu dengan game coding interaktif — selesaikan misi, kumpulkan poin, dan naiki leaderboard!</p>
    </div>

    <div class="gameedu-grid">
      <!-- Game screen visual -->
      <div class="gameedu-visual reveal">
        <div class="game-screen">
          <div class="game-topbar">
            <div class="game-dots">
              <div class="game-dot" style="background:var(--red);"></div>
              <div class="game-dot" style="background:var(--yellow);"></div>
              <div class="game-dot" style="background:#10b981;"></div>
            </div>
            <span style="font-family:'Fira Code',monospace;font-size:11px;color:var(--text3);">talentgroup.id — Code Challenge</span>
            <span style="font-family:'Fira Code',monospace;font-size:11px;color:var(--green);">● Live</span>
          </div>
          <div class="game-body">
            <div style="font-family:'Fira Code',monospace;font-size:11px;color:var(--text3);margin-bottom:8px;">Tantangan: Cetak 'Hello, World!' menggunakan PHP</div>
            <div class="code-window" style="flex:1;margin-bottom:10px;">
              <div class="cw-body" style="font-size:11.5px;">
                <div id="gameCode">
                  <span class="kw">&lt;?php</span><br>
                  <span class="fn">echo</span> <span class="str" id="gameStr">"..."</span><span class="punct">;</span><span class="typing-cursor" id="gameCursor"></span>
                </div>
              </div>
            </div>
            <div class="game-output" id="gameOutput">
              <div id="goLines"></div>
            </div>
            <div class="game-input-row" style="margin-top:8px;">
              <input class="game-input" id="codeInput" placeholder="Ketik output yang diinginkan..." type="text"/>
              <button class="game-run" onclick="runCode()">▶ Jalankan</button>
            </div>
          </div>
        </div>
      </div>

      <div class="reveal reveal-delay-2">
        <h3 style="font-size:1.5rem;font-weight:800;margin-bottom:14px;">8 Bahasa, Satu Platform</h3>
        <p style="font-size:14px;color:var(--text2);line-height:1.75;margin-bottom:24px;">Kuasai berbagai bahasa pemrograman melalui tantangan interaktif, kuis, dan game yang dirancang oleh instruktur berpengalaman di industri.</p>

        <div class="lang-pills">
          <div class="lang-pill" style="color:#7c5cbf;border-color:rgba(124,92,191,0.4);background:rgba(124,92,191,0.08);">🐘 PHP</div>
          <div class="lang-pill" style="color:#eab308;border-color:rgba(234,179,8,0.4);background:rgba(234,179,8,0.08);">⚡ JavaScript</div>
          <div class="lang-pill" style="color:#3b82f6;border-color:rgba(59,130,246,0.4);background:rgba(59,130,246,0.08);">🐍 Python</div>
          <div class="lang-pill" style="color:#f97316;border-color:rgba(249,115,22,0.4);background:rgba(249,115,22,0.08);">☕ Java</div>
          <div class="lang-pill" style="color:#06b6d4;border-color:rgba(6,182,212,0.4);background:rgba(6,182,212,0.08);">🌐 HTML/CSS</div>
          <div class="lang-pill" style="color:#10b981;border-color:rgba(16,185,129,0.4);background:rgba(16,185,129,0.08);">🗃️ SQL</div>
          <div class="lang-pill" style="color:#ec4899;border-color:rgba(236,72,153,0.4);background:rgba(236,72,153,0.08);">⚙️ C++</div>
          <div class="lang-pill" style="color:#94a3b8;border-color:rgba(148,163,184,0.3);background:rgba(148,163,184,0.06);">🦀 Rust</div>
        </div>

        <div style="margin-top:28px;display:flex;gap:16px;">
          <div style="flex:1;background:var(--surface);border:1px solid var(--border);border-radius:12px;padding:16px;text-align:center;">
            <div style="font-size:24px;font-weight:900;color:var(--php2);">500+</div>
            <div style="font-size:11px;color:var(--text3);margin-top:4px;">Tantangan Tersedia</div>
          </div>
          <div style="flex:1;background:var(--surface);border:1px solid var(--border);border-radius:12px;padding:16px;text-align:center;">
            <div style="font-size:24px;font-weight:900;color:var(--cyan);">24/7</div>
            <div style="font-size:11px;color:var(--text3);margin-top:4px;">Akses Online</div>
          </div>
          <div style="flex:1;background:var(--surface);border:1px solid var(--border);border-radius:12px;padding:16px;text-align:center;">
            <div style="font-size:24px;font-weight:900;color:var(--green);">Free</div>
            <div style="font-size:11px;color:var(--text3);margin-top:4px;">Mulai Gratis</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ======================== CLASS / COURSES ======================== -->
<section id="class" class="section" style="background:var(--bg2);">
  <div class="container">
    <div style="display:flex;align-items:flex-end;justify-content:space-between;margin-bottom:48px;" class="reveal">
      <div>
        <div class="sec-label">Kelas Tersedia</div>
        <h2 class="sec-title" style="margin-bottom:0;">Kursus <span>Pilihan Terbaik</span></h2>
      </div>
      <a href="{{ route('register') }}" class="btn-ghost" style="white-space:nowrap;">Lihat Semua →</a>
    </div>

    <div class="carousel-wrap reveal">
      <button class="car-btn prev" id="carPrev" onclick="carSlide(-1)">‹</button>
      <div class="carousel-overflow">
        <div class="carousel-track" id="carTrack">

          @foreach($courses as $course)
          <div class="course-card">
            <div class="course-hero" style="background: var(--bg3);">
                @if($course->image)
                    <img src="{{ route('storage.stream', $course->image) }}" class="w-full h-full object-cover" alt="{{ $course->title }}" loading="lazy" width="360" height="200">
                @else
                    <div class="w-full h-full flex items-center justify-center text-4xl bg-gradient-to-br from-indigo-900 to-purple-900">🎓</div>
                @endif
                @if($course->price < 1)
                    <div class="course-badge new">FREE</div>
                @else
                    <div class="course-badge">PREMIUM</div>
                @endif
            </div>
            <div class="course-body">
              <div class="course-lang">Course Module</div>
              <div class="course-title">{{ $course->title }}</div>
              <div class="course-meta">
                <span>📚 {{ $course->questions_count ?? $course->questions()->count() }} Materi</span>
                <span>🟢 All Levels</span>
              </div>
              <div class="course-price {{ $course->price < 1 ? 'free' : '' }}">
                {{ $course->price < 1 ? 'GRATIS' : 'Rp ' . number_format($course->price, 0, ',', '.') }}
              </div>
              <a href="{{ route('user.courses.show', $course->id) }}" class="btn-course" style="text-align:center;display:block;">Lihat Detail</a>
            </div>
          </div>
          @endforeach

        </div>
      </div>
      <button class="car-btn next" id="carNext" onclick="carSlide(1)">›</button>
    </div>
  </div>
</section>

<!-- ======================== ABOUT ======================== -->
<section id="about" class="section">
  <div class="container">
    <div class="reveal" style="text-align:center;margin-bottom:48px;">
      <div class="sec-label" style="justify-content:center;">Why talentgroup.id</div>
      <h2 class="sec-title" style="text-align:center;">Kenapa Pilih <span>talentgroup.id?</span></h2>
      <p class="sec-sub" style="margin:0 auto;text-align:center;">Kami membangun platform dengan satu tujuan: mencetak developer handal Indonesia.</p>
    </div>

    <div class="about-grid">
      <div class="about-card reveal reveal-delay-1">
        <div class="about-icon">📚</div>
        <h3>Kurikulum Industri</h3>
        <p>Kurikulum didesain bersama praktisi industri sehingga relevan dengan kebutuhan pasar kerja terkini.</p>
      </div>
      <div class="about-card reveal reveal-delay-2">
        <div class="about-icon">🎮</div>
        <h3>Belajar Lewat Game</h3>
        <p>Metode gamifikasi membuat belajar coding lebih menyenangkan, menantang, dan tidak membosankan.</p>
      </div>
      <div class="about-card reveal reveal-delay-3">
        <div class="about-icon">🤖</div>
        <h3>Auto-Grading AI</h3>
        <p>Sistem AI langsung menilai kode kamu dan memberikan feedback real-time tanpa perlu menunggu mentor.</p>
      </div>
      <div class="about-card reveal reveal-delay-1">
        <div class="about-icon">🏅</div>
        <h3>Sertifikasi Resmi</h3>
        <p>Raih sertifikat setiap menyelesaikan kelas — bisa langsung dipakai saat job hunting di perusahaan ternama.</p>
      </div>
      <div class="about-card reveal reveal-delay-2">
        <div class="about-icon">🌐</div>
        <h3>Blended Learning</h3>
        <p>Fleksibel belajar online maupun offline, sinkron dan asinkron sesuai ritme hidupmu.</p>
      </div>
      <div class="about-card reveal reveal-delay-3">
        <div class="about-icon">💼</div>
        <h3>Job-Ready</h3>
        <p>Terhubung langsung dengan 50+ hiring partners. Peluang kerja terbuka lebar setelah lulus program.</p>
      </div>
    </div>
  </div>
</section>

<!-- ======================== FOOTER ======================== -->
<footer>
  <div class="footer-top">
    <div class="footer-brand">
      <a href="#home" class="logo" style="text-decoration:none;">
        <img src="{{ asset('assets/images/logo.png') }}" class="logo-mark" alt="Logo" width="40" height="40" style="width:40px;height:40px;object-fit:contain;filter:drop-shadow(0 0 6px rgba(6,182,212,0.4));">
        <div class="logo-text-wrap" style="margin-left:10px;">
          <span class="logo-name">talentgroup.id</span>
          <span class="logo-sub">Academy</span>
        </div>
      </a>
      <p>Platform edukasi digital untuk pengembangan keterampilan pemrograman. Belajar coding interaktif dengan PHP, Python, JavaScript, Go, dan banyak lagi secara terarah.</p>
      <div class="footer-contact">
        <a href="mailto:info@talentgroup.academy"><div class="fc-icon">✉</div>info@talentgroup.academy</a>
        <a href="tel:+6282323450242"><div class="fc-icon">📞</div>+62 823 2345 0242</a>
        <a href="#"><div class="fc-icon">📍</div>Jakarta, Indonesia</a>
      </div>
      <div class="footer-socials">
        <!-- SVG Icons for socials with brand classes -->
        <a class="social-btn twitter" href="https://twitter.com" target="_blank" rel="noopener noreferrer" aria-label="X / Twitter">
          <svg viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
        </a>
        <a class="social-btn linkedin" href="https://linkedin.com" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn">
          <svg viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
        </a>
        <a class="social-btn instagram" href="https://instagram.com" target="_blank" rel="noopener noreferrer" aria-label="Instagram">
          <svg viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.051.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
        </a>
        <a class="social-btn youtube" href="https://youtube.com" target="_blank" rel="noopener noreferrer" aria-label="YouTube">
          <svg viewBox="0 0 24 24"><path d="M23.498 6.163a3.003 3.003 0 00-2.11-2.11C19.517 3.545 12 3.545 12 3.545s-7.517 0-9.388.507a3.003 3.003 0 00-2.11 2.11C0 8.033 0 12 0 12s0 3.967.502 5.837a3.003 3.003 0 002.11 2.11c1.871.507 9.388.507 9.388.507s7.517 0 9.388-.507a3.003 3.003 0 002.11-2.11C24 15.967 24 12 24 12s0-3.967-.502-5.837zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
        </a>
      </div>
    </div>

    <div class="footer-col">
      <h4>talentgroup.id</h4>
      <a href="#about">Tentang Kami</a>
      <a href="#">Karir Karangan</a>
      <a href="#">Hiring Partner</a>
      <a href="#">Blog Edukasi</a>
      <a href="#">Syarat & Ketentuan</a>
    </div>

    <div class="footer-col">
      <h4>Layanan</h4>
      <a href="#class">Kelas Coding</a>
      <a href="#gameedu">Game Edu</a>
      <a href="#">Beasiswa Digital</a>
      <a href="#">Webinar Tech</a>
      <a href="#">Verifikasi Sertifikat</a>
    </div>

    <div class="footer-col footer-newsletter">
      <h4>Newsletter Kami</h4>
      <p>Dapatkan tutorial pemrograman gratis, berita kelas terupdate, dan penawaran beasiswa khusus langsung di email Anda.</p>
      <form class="newsletter-form" onsubmit="event.preventDefault(); alert('Terima kasih! Anda berhasil berlangganan newsletter kami.');">
        <input type="email" placeholder="Masukkan email aktif..." required id="newsletterEmail" aria-label="Alamat Email">
        <button type="submit" id="btnSubscribe">Langganan</button>
      </form>
    </div>
  </div>

  <div class="footer-divider"></div>

  <div class="footer-bottom">
    <span>© 2026 <a href="#home">talentgroup.id</a> — Akademi Pemrograman Indonesia. All Rights Reserved.</span>
    <span>Made with ❤️ for Indonesia's Digital Future</span>
  </div>
</footer>

<!-- ======================== MODAL ======================== -->
<div class="modal-overlay" id="modalOverlay" onclick="handleOverlayClick(event)">
  <div class="modal">
    <button class="modal-close" onclick="closeModal()">✕</button>

    <div class="modal-tabs2">
      <button class="mtab active" id="mtab-login" onclick="switchModalTab('login')">Masuk</button>
      <button class="mtab" id="mtab-register" onclick="switchModalTab('register')">Daftar</button>
    </div>

    <!-- LOGIN -->
    <div class="tc-content active" id="tc-login">
      <h2>Selamat Datang! 👋</h2>
      <p class="modal-sub">Masuk ke akun talentgroup.id kamu</p>
      <div style="display:flex;gap:10px;margin-bottom:20px;">
        <button class="btn-submit2" style="background:linear-gradient(135deg,#7c5cbf,#9b78e0);">🎓 Masuk sebagai User</button>
        <button class="btn-submit2" style="background:linear-gradient(135deg,#f97316,#fb923c);flex:0.6;">🔑 Admin</button>
      </div>
      <div class="modal-switch">Belum punya akun? <a onclick="switchModalTab('register')">Daftar sekarang</a></div>
    </div>

    <!-- REGISTER -->
    <div class="tc-content" id="tc-register">
      <h2>Buat Akun Baru 🚀</h2>
      <p class="modal-sub">Bergabung dan mulai belajar bersama talentgroup.id</p>
      <div class="form-group">
        <label>Nama Lengkap</label>
        <input type="text" placeholder="Nama kamu"/>
      </div>
      <div class="form-group">
        <label>Email</label>
        <input type="email" placeholder="nama@email.com"/>
      </div>
      <div class="form-group">
        <label>Password</label>
        <input type="password" placeholder="Minimal 8 karakter"/>
      </div>
      <div class="form-group">
        <label>Konfirmasi Password</label>
        <input type="password" placeholder="Ulangi password"/>
      </div>
      <button class="btn-submit2">Daftar Sekarang</button>
      <div class="modal-switch">Sudah punya akun? <a onclick="switchModalTab('login')">Masuk di sini</a></div>
    </div>
  </div>
</div>

<!-- ======================== JAVASCRIPT ======================== -->
<script>
/* ===== PARTICLES ===== */
const canvas = document.getElementById('particles');
const ctx = canvas.getContext('2d');
let W, H, particles = [];

function resizeCanvas(){
  W = canvas.width = window.innerWidth;
  H = canvas.height = window.innerHeight;
}
resizeCanvas();
window.addEventListener('resize', resizeCanvas);

class Particle {
  constructor(){this.reset();}
  reset(){
    this.x = Math.random()*W;
    this.y = Math.random()*H;
    this.r = Math.random()*1.5+0.3;
    this.vx = (Math.random()-0.5)*0.3;
    this.vy = (Math.random()-0.5)*0.3;
    this.alpha = Math.random()*0.4+0.1;
    this.color = ['#7c5cbf','#06b6d4','#10b981','#f97316'][Math.floor(Math.random()*4)];
  }
  update(){
    this.x += this.vx; this.y += this.vy;
    if(this.x<0||this.x>W||this.y<0||this.y>H) this.reset();
  }
  draw(){
    ctx.save();
    ctx.globalAlpha = this.alpha;
    ctx.fillStyle = this.color;
    ctx.beginPath();
    ctx.arc(this.x,this.y,this.r,0,Math.PI*2);
    ctx.fill();
    ctx.restore();
  }
}

for(let i=0;i<80;i++) particles.push(new Particle());

function animParticles(){
  ctx.clearRect(0,0,W,H);
  particles.forEach(p=>{p.update();p.draw();});
  // draw connections
  for(let i=0;i<particles.length;i++){
    for(let j=i+1;j<particles.length;j++){
      const dx = particles[i].x-particles[j].x;
      const dy = particles[i].y-particles[j].y;
      const dist = Math.sqrt(dx*dx+dy*dy);
      if(dist<120){
        ctx.save();
        ctx.globalAlpha = (1-dist/120)*0.08;
        ctx.strokeStyle = '#7c5cbf';
        ctx.lineWidth = 0.5;
        ctx.beginPath();
        ctx.moveTo(particles[i].x,particles[i].y);
        ctx.lineTo(particles[j].x,particles[j].y);
        ctx.stroke();
        ctx.restore();
      }
    }
  }
  requestAnimationFrame(animParticles);
}
animParticles();

/* ===== CURSOR ===== */
const cursorEl = document.getElementById('cursor');
const cursorRingEl = document.getElementById('cursorRing');
let mx=0, my=0, rx=0, ry=0;
document.addEventListener('mousemove', e=>{
  mx = e.clientX; my = e.clientY;
  cursorEl.style.left = mx+'px';
  cursorEl.style.top = my+'px';
});
function animCursor(){
  rx += (mx-rx)*0.12;
  ry += (my-ry)*0.12;
  cursorRingEl.style.left = rx+'px';
  cursorRingEl.style.top = ry+'px';
  requestAnimationFrame(animCursor);
}
animCursor();

/* ===== PROGRESS BAR ===== */
window.addEventListener('scroll',()=>{
  const doc = document.documentElement;
  const pct = window.scrollY/(doc.scrollHeight-doc.clientHeight)*100;
  document.getElementById('prog').style.width = pct+'%';
  // navbar
  document.getElementById('navbar').classList.toggle('scrolled',window.scrollY>60);
  // reveal
  document.querySelectorAll('.reveal:not(.revealed)').forEach(el=>{
    const rect = el.getBoundingClientRect();
    if(rect.top < window.innerHeight*0.9) el.classList.add('revealed');
  });
});

// initial reveal check
setTimeout(()=>{
  document.querySelectorAll('.reveal').forEach(el=>{
    const rect = el.getBoundingClientRect();
    if(rect.top < window.innerHeight*0.95) el.classList.add('revealed');
  });
},100);

/* ===== MOBILE NAV ===== */
function toggleMobileNav(){
  document.getElementById('burger').classList.toggle('open');
  document.getElementById('mobileNav').classList.toggle('open');
}
function closeMobileNav(){
  document.getElementById('burger').classList.remove('open');
  document.getElementById('mobileNav').classList.remove('open');
}

/* ===== MODAL ===== */
function openModal(tab){
  document.getElementById('modalOverlay').classList.add('open');
  switchModalTab(tab||'login');
}
function closeModal(){
  document.getElementById('modalOverlay').classList.remove('open');
}
function handleOverlayClick(e){
  if(e.target===document.getElementById('modalOverlay')) closeModal();
}
function switchModalTab(tab){
  ['login','register'].forEach(t=>{
    document.getElementById('mtab-'+t).classList.toggle('active',t===tab);
    document.getElementById('tc-'+t).classList.toggle('active',t===tab);
  });
}

/* ===== CAROUSEL ===== */
let carIdx=0;
function getCarVisible(){
  return window.innerWidth<=768?1:window.innerWidth<=1100?2:3;
}
function carSlide(dir){
  const track = document.getElementById('carTrack');
  const cards = track.querySelectorAll('.course-card');
  const visible = getCarVisible();
  const max = cards.length - visible;
  carIdx = Math.max(0,Math.min(carIdx+dir,max));
  const cw = cards[0].offsetWidth + 24;
  track.style.transform = `translateX(-${carIdx*cw}px)`;
}
window.addEventListener('resize',()=>{carIdx=0;document.getElementById('carTrack').style.transform='translateX(0)';});

/* ===== GAME CODE DEMO ===== */
const outputs = [
  {code:'"Hello, World!"', out:'Hello, World!', color:'#10b981'},
  {code:'"talentgroup.id"', out:'talentgroup.id', color:'#7c5cbf'},
  {code:'"echo PHP!"', out:'echo PHP!', color:'#06b6d4'},
];
let gameIdx = 0;
let typingInterval;

function typeStr(el, str, cb){
  clearInterval(typingInterval);
  el.textContent = '';
  let i=0;
  typingInterval = setInterval(()=>{
    if(i<str.length){el.textContent += str[i++];}
    else{clearInterval(typingInterval);if(cb)cb();}
  },60);
}

function nextGameSlide(){
  gameIdx = (gameIdx+1)%outputs.length;
  const item = outputs[gameIdx];
  const strEl = document.getElementById('gameStr');
  typeStr(strEl, item.code, ()=>{
    const out = document.getElementById('goLines');
    setTimeout(()=>{
      const div = document.createElement('div');
      div.className='go-line';
      div.innerHTML = `<span style="color:${item.color};">$ </span>${item.out}`;
      out.appendChild(div);
      if(out.children.length>4) out.removeChild(out.children[0]);
    },400);
  });
}

setInterval(nextGameSlide, 3000);

function runCode(){
  const val = document.getElementById('codeInput').value.trim();
  if(!val) return;
  const out = document.getElementById('goLines');
  const div = document.createElement('div');
  div.className='go-line';
  div.innerHTML = `<span style="color:#10b981;">$ </span>${val}`;
  out.appendChild(div);
  if(out.children.length>5) out.removeChild(out.children[0]);
  document.getElementById('codeInput').value='';

  // feedback
  const gameStr = document.getElementById('gameStr');
  typeStr(gameStr, `"${val}"`);
}

/* ===== SMOOTH SCROLL ===== */
document.querySelectorAll('a[href^="#"]').forEach(a=>{
  a.addEventListener('click',e=>{
    const target = document.querySelector(a.getAttribute('href'));
    if(target){
      e.preventDefault();
      target.scrollIntoView({behavior:'smooth',block:'start'});
      closeMobileNav();
    }
  });
});
</script>
</body>
</html>

