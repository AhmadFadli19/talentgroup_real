<?php

namespace Database\Seeders;

use App\Models\Module;
use App\Models\ModuleCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class WebDevDocumentationModuleSeeder extends Seeder
{
    public function run(): void
    {
        // =========================================================================
        // KATEGORI 1: HTML5 & ARSITEKTUR WEB SEMANTIK
        // =========================================================================
        $catHtml = ModuleCategory::updateOrCreate(
            ['slug' => 'modul-html5-dan-web-semantik'],
            [
                'name' => 'Modul HTML5 & Web Semantik',
                'description' => 'Panduan komprehensif struktur standar industri W3C, meta tag SEO, formulir validasi, dan arsitektur aksesibilitas digital.',
                'order' => 1,
                'is_active' => true,
                'is_public' => true,
                'icon' => 'globe',
                'color' => '#f97316',
                'badge' => 'HTML5 Core',
            ]
        );

        // Modul 1.1
        Module::updateOrCreate(
            ['slug' => 'struktur-fondasi-html5-dan-meta-tag-seo'],
            [
                'category_id' => $catHtml->id,
                'section' => 'Dasar Standar Web',
                'title' => 'Struktur Fondasi HTML5, Dokumen W3C & Meta Tag SEO Komprehensif',
                'order' => 1,
                'is_published' => true,
                'is_public' => true,
                'enable_protection' => false,
                'excerpt' => 'Pelajari anatomi dokumen standar HTML5, deklarasi DOCTYPE W3C, konfigurasi viewport mobile, serta meta tag Open Graph untuk optimasi mesin pencari.',
                'content' => '# Struktur Fondasi HTML5, Dokumen W3C & Meta Tag SEO Komprehensif

Dokumen HTML (HyperText Markup Language) adalah tulang punggung dari setiap aplikasi peramban web. Memahami setiap baris pembentuk dokumen awal bukan hanya soal menampilkan teks di layar, melainkan bagaimana mesin pencari (Google, Bing) dan teknologi asistif (Screen Reader) menafsirkan keabsahan konten Anda.

---

## 1. Anatomi Kerangka Dokumen Standar W3C

Setiap halaman web modern wajib diawali dengan kerangka dasar berikut:

```html:index.html
<!DOCTYPE html>
<html lang="id" dir="ltr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  
  <title>Panduan Pengembang Web Profesional | TalentGroup</title>
  <meta name="description" content="Pelajari arsitektur web semantik modern dari nol hingga mahir bersama kurikulum terstandarisasi.">
  <link rel="canonical" href="https://talentgroup.id/modul/html5">
</head>
<body>
  <header>
    <h1>Selamat Datang di Dunia Web Development</h1>
  </header>
  <main>
    <p>Konten utama aplikasi berada di sini.</p>
  </main>
</body>
</html>
```

### Rincian Elemen Kritis:
1. **`<!DOCTYPE html>`**: Instruksi mutlak bagi peramban agar merender halaman menggunakan mode standar (*Standards Mode*) HTML5 terbaru, bukan mode kompatibilitas lama (*Quirks Mode*) yang dapat merusak tata letak CSS.
2. **`<html lang="id">`**: Mendefinisikan bahasa utama konten. Membantu mesin penerjemah otomatis dan menentukan intonasi pelafalan bagi pembaca layar tunanetra.
3. **`<meta charset="UTF-8">`**: Menjamin seluruh karakter alfabet, angka, aksen, hingga emoji internasional (seperti 🚀, 💻) ditampilkan secara sempurna tanpa distorsi teks (*mojibake*).
4. **`<meta name="viewport" content="width=device-width, initial-scale=1.0">`**: Mewajibkan peramban ponsel pintar merender lebar tampilan sesuai piksel fisik perangkat pada skala rasio 1:1, mencegah fenomena desktop perkecil otomatis (*pinch-to-zoom* yang buruk).

---

## 2. Meta Tag SEO dan Media Sosial (Open Graph & Twitter Cards)

Saat tautan situs Anda dibagikan di WhatsApp, Telegram, LinkedIn, atau Twitter/X, kartu pratinjau (*rich snippet card*) dibentuk oleh tag Open Graph:

```html
<!-- Protokol Facebook & WhatsApp (Open Graph) -->
<meta property="og:type" content="article">
<meta property="og:site_name" content="TalentGroup Academy">
<meta property="og:title" content="Panduan Arsitektur HTML5 Standar Industri">
<meta property="og:description" content="Tingkatkan performa SEO dan struktur situs web Anda menggunakan teknik semantik terkini.">
<meta property="og:image" content="https://talentgroup.id/assets/images/og-html5-cover.jpg">
<meta property="og:url" content="https://talentgroup.id/modul/html5">

<!-- Twitter Cards Protocol -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="Panduan Arsitektur HTML5 Standar Industri">
<meta name="twitter:description" content="Tingkatkan performa SEO dan struktur situs web Anda.">
<meta name="twitter:image" content="https://talentgroup.id/assets/images/og-html5-cover.jpg">
```

> [!IMPORTANT]
> Pastikan rasio gambar `og:image` menggunakan ukuran rekomendasi **1200 x 630 piksel** (rasio 1.91:1) dengan ukuran berkas di bawah 1 MB agar dapat di-cache secara instan oleh crawler media sosial.

---

## 3. Menghubungkan Favicon Multi-Resolusi

Favicon adalah ikon identitas tab peramban dan penanda pintasan layar utama gawai seluler:

```html
<link rel="icon" type="image/svg+xml" href="/favicon.svg">
<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
<link rel="manifest" href="/site.webmanifest">
```

---

## 4. Rangkuman & Praktik Terbaik

- Selalu sertakan satu tag `<title>` yang unik dan deskriptif di setiap halaman (idealnya 50–60 karakter).
- Gunakan `<meta name="description">` dengan panjang 140–160 karakter untuk menarik rasio klik (*Click-Through Rate*) dari halaman pencarian Google.
- Tentukan URL kanonikal menggunakan `<link rel="canonical">` untuk mencegah penalti duplikasi konten jika halaman dapat diakses dari beberapa domain atau parameter kueri berbeda.',
            ]
        );

        // Modul 1.2
        Module::updateOrCreate(
            ['slug' => 'hierarki-tipografi-tautan-dan-tabel-data'],
            [
                'category_id' => $catHtml->id,
                'section' => 'Konten & Navigasi',
                'title' => 'Hierarki Tipografi Semantik, Tautan Hyperlink Aman & Tabel Data',
                'order' => 2,
                'is_published' => true,
                'is_public' => true,
                'enable_protection' => false,
                'excerpt' => 'Aturan penggunaan tag heading h1-h6 untuk SEO, keamanan rel noopener noreferrer saat membuka tab baru, serta struktur tabel semantik thead/tbody.',
                'content' => '# Hierarki Tipografi Semantik, Tautan Hyperlink Aman & Tabel Data

Menyusun konten teks bukan sekadar memilih ukuran huruf yang besar atau kecil, melainkan menciptakan **peta hierarki informasi** yang dapat dipahami oleh mesin dan manusia.

---

## 1. Aturan Baku Heading (H1 hingga H6)

Heading merepresentasikan daftar isi dari sebuah buku. Browser dan crawler Google menggunakannya untuk menyusun struktur topik halaman:

```html
<!-- Judul Utama Dokumen: HANYA BOLEH ADA 1 ELEMEN H1 PER HALAMAN -->
<h1>Belajar Pemrograman Frontend Modern</h1>

<section>
  <!-- Sub-bab Utama -->
  <h2>1. Pengenalan Web Dasar</h2>
  <p>Web dasar dibangun menggunakan kombinasi HTML, CSS, dan JavaScript.</p>
  
  <!-- Sub dari Sub-bab -->
  <h3>1.1 Sejarah Perkembangan HTML</h3>
  <p>HTML pertama kali diciptakan oleh Tim Berners-Lee pada tahun 1991.</p>
  
  <h3>1.2 Konsorsium W3C dan WHATWG</h3>
  <p>Standar web saat ini dikelola sebagai living standard.</p>
</section>

<section>
  <h2>2. Desain Layout Visual</h2>
  <p>Tahap ini melibatkan penataan antarmuka menggunakan CSS.</p>
</section>
```

> [!CAUTION]
> **Jangan Pernah Mengacak Level Heading!** Jangan melompat dari `<h1>` langsung ke `<h3>` hanya karena ingin ukuran teks yang lebih kecil. Gunakan CSS `font-size` untuk mengatur ukuran visual teks, bukan mengganti tag semantik!

---

## 2. Format Teks: Semantik vs Visual Murni

| Tag Semantik | Makna Informasi | Tag Visual Usang | Catatan Praktik Terbaik |
| :--- | :--- | :--- | :--- |
| `<strong>` | Kepentingan krusial / peringatan serius | `<b>` (Bold) | Dibaca dengan intonasi penekanan oleh Screen Reader |
| `<em>` | Penekanan nada bicara (*stress emphasis*) | `<i>` (Italic) | Mengubah makna kalimat saat diucapkan lisan |
| `<mark>` | Teks yang disorot / hasil pencarian | `<span style="...">` | Merepresentasikan relevansi konteks pencarian |
| `<del>` & `<ins>` | Teks revisi yang dihapus dan penggantinya | `<s>` / `<u>` | Sangat berguna untuk riwayat pengeditan dan coretan harga promo |

---

## 3. Tautan Hyperlink & Keamanan Tab Baru (`target="_blank"`)

Ketika membuat tautan yang membuka tab baru, celah keamanan **Tabnabbing** dapat dieksploitasi oleh pihak ketiga jika Anda melupakan atribut `rel`:

```html
<!-- Tautan Internal -->
<a href="/kursus/frontend">Lihat Kurikulum Kami</a>

<!-- Tautan Eksternal Aman -->
<a href="https://developer.mozilla.org" target="_blank" rel="noopener noreferrer">
  Dokumentasi Resmi MDN Web Docs
</a>

<!-- Tautan Protokol Khusus -->
<a href="mailto:halo@talentgroup.id?subject=Konsultasi%20Belajar">Kirim Email</a>
<a href="tel:+6281234567890">Hubungi Hotline</a>
```

### Penjelasan Atribut Keamanan:
- **`noopener`**: Mencegah halaman tujuan mengakses objek `window.opener` dari halaman asal, menutup potensi pengambilalihan tab oleh situs phising.
- **`noreferrer`**: Menyembunyikan header informasi referer HTTP sehingga situs target tidak mengetahui URL asal pengunjung.

---

## 4. Struktur Tabel Data Berstandar W3C

Hindari membuat tabel hanya dengan `<table>` dan `<tr>` polos. Gunakan struktur blok semantik penuh:

```html
<div class="table-responsive">
  <table>
    <caption>Daftar Biaya Kursus dan Durasi Pelatihan 2026</caption>
    <thead>
      <tr>
        <th scope="col">Paket Belajar</th>
        <th scope="col">Durasi</th>
        <th scope="col">Sertifikasi</th>
        <th scope="col">Biaya Investasi</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th scope="row">Frontend Foundation</th>
        <td>6 Minggu</td>
        <td>Kelulusan W3C</td>
        <td>Rp 750.000</td>
      </tr>
      <tr>
        <th scope="row">Fullstack Pro</th>
        <td>14 Minggu</td>
        <td>BNSP Industri</td>
        <td>Rp 1.850.000</td>
      </tr>
    </tbody>
    <tfoot>
      <tr>
        <td colspan="3">Garansi Akses Materi Selamanya</td>
        <td>Termasuk Pembahasan</td>
      </tr>
    </tfoot>
  </table>
</div>
```

- Gunakan `<th scope="col">` untuk kepala kolom dan `<th scope="row">` untuk kepala baris data.
- Sertakan elemen `<caption>` sebagai deskripsi judul tabel yang mudah dipahami.',
            ]
        );

        // Modul 1.3
        Module::updateOrCreate(
            ['slug' => 'formulir-interaktif-dan-validasi-bawaan-html5'],
            [
                'category_id' => $catHtml->id,
                'section' => 'Formulir & Masukan Pengguna',
                'title' => 'Mastering Formulir Modern, Validasi Bawaan & Keamanan Masukan Data',
                'order' => 3,
                'is_published' => true,
                'is_public' => true,
                'enable_protection' => false,
                'excerpt' => 'Panduan lengkap input type HTML5 (email, tel, date), atribut validasi required, minlength, pattern regex, serta asosiasi label for id.',
                'content' => '# Mastering Formulir Modern, Validasi Bawaan & Keamanan Masukan Data

Formulir adalah gerbang utama interaksi dua arah antara pengguna dan server aplikasi. Menyusun formulir yang ramah pengguna, mudah diakses di perangkat ponsel, serta memiliki validasi bawaan yang ketat adalah keterampilan mendasar setiap perekayasa web.

---

## 1. Asosiasi Label dan Kontrol Masukan (`<label for="...">`)

Salah satu kesalahan paling fatal pemula adalah membiarkan tag `<input>` berdiri sendiri tanpa ikatan `<label>`.

```html
<!-- KELIRU: Tidak dapat diklik pada teks dan tidak ramah aksesibilitas -->
Nama Lengkap: <input type="text" name="nama">

<!-- BENAR: Menggunakan atribut for yang terhubung dengan id masukan -->
<div class="form-group">
  <label for="input-nama-lengkap">Nama Lengkap Sesuai KTP:</label>
  <input type="text" id="input-nama-lengkap" name="nama_lengkap" placeholder="Contoh: Budi Pratama" required>
</div>
```

> [!TIP]
> Ketika `<label for="id">` diklik oleh pengguna, peramban secara otomatis memfokuskan kursor ke dalam bidang input terkait. Hal ini memperbesar area sentuh (*hit target*) sebesar 300% pada layar sentuh smartphone!

---

## 2. Ragam Tipe Input Spesifik & Keyboard Seluler

Penggunaan tipe input yang presisi memicu tata letak papan ketik (*virtual keyboard*) yang sesuai di perangkat mobile:

```html
<!-- Memunculkan keyboard numerik langsung di smartphone -->
<label for="input-nohp">Nomor WhatsApp Aktif:</label>
<input type="tel" id="input-nohp" name="telepon" inputmode="tel" placeholder="0812xxxxxxx" required>

<!-- Memunculkan tombol @ dan .com di keyboard -->
<label for="input-surel">Alamat Surel Perusahaan:</label>
<input type="email" id="input-surel" name="email" autocomplete="email" required>

<!-- Memunculkan pemilih tanggal native kalender -->
<label for="input-tgl">Tanggal Mulai Belajar:</label>
<input type="date" id="input-tgl" name="tanggal_mulai" min="2026-01-01" max="2026-12-31">

<!-- Input Angka dengan Batasan Stepping -->
<label for="input-jumlah">Kuantitas Lisensi (1 - 50):</label>
<input type="number" id="input-jumlah" name="kuantitas" min="1" max="50" step="1" value="1">
```

---

## 3. Validasi Masukan Bawaan Tanpa Kode JavaScript

HTML5 menyediakan sistem validasi tangguh langsung di dalam mesin browser:

```html
<form action="/api/v1/registrasi" method="POST" class="auth-form">
  <!-- Validasi Panjang Teks -->
  <label for="user-id">Username Pengembang:</label>
  <input type="text" id="user-id" name="username" minlength="4" maxlength="20" required>

  <!-- Validasi Pola Regex (Pattern): Wajib diawali huruf kapital, min 8 karakter -->
  <label for="user-pass">Kata Sandi Kuat:</label>
  <input 
    type="password" 
    id="user-pass" 
    name="password" 
    pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" 
    title="Harus memuat minimal 8 karakter dengan kombinasi angka, huruf kecil, dan huruf kapital"
    required
  >

  <!-- Validasi Unggah Berkas: Batasi tipe mime ekstensi -->
  <label for="berkas-cv">Unggah Resume / Portofolio (PDF saja, maks 2MB):</label>
  <input type="file" id="berkas-cv" name="dokumen_cv" accept=".pdf,application/pdf" required>

  <button type="submit" class="btn-kirim">Daftar Sekarang</button>
</form>
```

---

## 4. Keamanan Formulir: Melindungi Masukan Pengguna

1. **Selalu Gunakan Metode POST untuk Data Sensitif**: Jangan pernah mengirimkan kata sandi atau data pribadi menggunakan `method="GET"` karena parameter data akan terpampang jelas di bilah alamat peramban dan tercatat di log server.
2. **CSRF Protection**: Dalam aplikasi modern seperti Laravel, setiap formulir POST wajib menyertakan token pencegah pemalsuan permintaan antar-situs (`@csrf`).
3. **Validasi Dua Sisi**: Validasi HTML5 di sisi klien sangat penting untuk kenyamanan pengguna (*user experience*), namun **validasi backend di server tetap mutlak wajib dijalankan** untuk menangkal manipulasi inspeksi elemen browser.',
            ]
        );

        // Modul 1.4
        Module::updateOrCreate(
            ['slug' => 'arsitektur-web-semantik-w3c-dan-aksesibilitas-a11y'],
            [
                'category_id' => $catHtml->id,
                'section' => 'Arsitektur & Aksesibilitas',
                'title' => 'Arsitektur Web Semantik W3C & Aksesibilitas Digital (A11y & ARIA)',
                'order' => 4,
                'is_published' => true,
                'is_public' => true,
                'enable_protection' => false,
                'excerpt' => 'Kuasai tata letak landmark semantik header, nav, main, article, section, aside, footer, serta standar aksesibilitas WCAG dan WAI-ARIA.',
                'content' => '# Arsitektur Web Semantik W3C & Aksesibilitas Digital (A11y & ARIA)

Web semantik adalah praktik menulis kode HTML yang memberikan makna makna kontekstual terhadap isi konten, bukan sekadar menggunakan tag generik `<div>` untuk membungkus segala elemen (*div-soup syndrome*).

---

## 1. Peta Landmark Semantik HTML5

```
+-------------------------------------------------------------+
|                     <header>                                |
|  +-------------------------------------------------------+  |
|  |                   <nav> (Navigasi Utama)              |  |
|  +-------------------------------------------------------+  |
+-------------------------------------------------------------+
|                                                             |
|                         <main>                              |
|  +-----------------------------------+  +----------------+  |
|  |             <article>             |  |    <aside>     |  |
|  |  +-----------------------------+  |  | (Sidebar, Info |  |
|  |  |    <section> Bab 1          |  |  |  Pendukung,    |  |
|  |  +-----------------------------+  |  |  Iklan Relevan)|  |
|  |  |    <section> Bab 2          |  |  |                |  |
|  |  +-----------------------------+  |  |                |  |
|  +-----------------------------------+  +----------------+  |
|                                                             |
+-------------------------------------------------------------+
|                     <footer>                                |
| (Hak Cipta, Tautan Legalitas, Kebijakan Privasi, Kontak)   |
+-------------------------------------------------------------+
```

### Panduan Pemilihan Tag yang Tepat:
- **`<main>`**: Memuat konten unik dari halaman saat ini. Hanya boleh ada **satu `<main>` per halaman** dan tidak boleh berada di dalam `<header>`, `<footer>`, atau `<nav>`.
- **`<article>`**: Mewakili unit konten independen yang dapat berdiri sendiri dan masuk akal jika disindikasikan atau dibagikan secara terpisah (misalnya: postingan artikel blog, ulasan produk, tweet kartu komentar).
- **`<section>`**: Mewakili pengelompokan tematik konten yang umumnya memiliki judul bab (`<h2>`-`<h6>`) tersendiri.
- **`<aside>`**: Konten sekunder yang berhubungan secara tidak langsung dengan materi utama (daftar tautan terkait, profil singkat penulis, banner promosi).
- **`<footer>>`**: Bagian penutup yang memuat informasi hak cipta, kontak bantuan, dan pranala kebijakan privasi.

---

## 2. Fondasi Aksesibilitas Web (A11y & WCAG 2.2)

Aksesibilitas web menjamin bahwa situs Anda dapat dinavigasi dengan mudah oleh penyandang disabilitas (tunanetra, gangguan motorik, buta warna).

### 1. Teks Alternatif Gambar yang Bermakna (`alt`)
```html
<!-- KELIRU: Redundan dan tidak memberikan konteks -->
<img src="grafik.png" alt="gambar grafik">

<!-- BENAR: Menjelaskan data yang disampaikan -->
<img src="grafik-penjualan-2025.png" alt="Grafik batang pertumbuhan penjualan tahun 2025 dengan kenaikan 28% pada kuartal 4">

<!-- DEKORATIF MURNI: Jika gambar hanya hiasan latar, kosongkan alt agar dilewati Screen Reader -->
<img src="dekorasi-lingkaran.svg" alt="" role="presentation">
```

### 2. Atribut WAI-ARIA (Accessible Rich Internet Applications)
Atribut ARIA memberikan informasi tambahan ketika elemen HTML standar tidak mampu mengekspresikan status antarmuka dinamis:
```html
<!-- Tombol Menu Hamburger Responsif -->
<button 
  id="btn-menu" 
  aria-expanded="false" 
  aria-controls="daftar-navigasi-mobile" 
  aria-label="Buka navigasi menu utama"
>
  <svg>...</svg>
</button>

<nav id="daftar-navigasi-mobile" class="hidden">
  <ul>
    <li><a href="/beranda">Beranda</a></li>
  </ul>
</nav>

<!-- Pembaruan Data Real-Time Tanpa Reload (Live Region) -->
<div aria-live="polite" id="notifikasi-keranjang">
  3 barang ditambahkan ke keranjang belanja Anda.
</div>
```

---

## 3. Uji Kepatuhan Aksesibilitas
1. **Navigasi Keyboard Penuh**: Cobalah menekan tombol `Tab`, `Shift + Tab`, dan `Enter` tanpa menyentuh mouse Anda sama sekali. Seluruh tombol interaktif, formulir, dan link wajib menerima indikator fokus (*focus ring indicator*) yang jelas.
2. **Kontras Warna Teks**: Teks normal wajib memiliki rasio kontras minimal **4.5:1** terhadap warna latar belakangnya sesuai standar WCAG AA.',
            ]
        );

        // =========================================================================
        // KATEGORI 2: CSS3, FLEXBOX, GRID & MODERN UI
        // =========================================================================
        $catCss = ModuleCategory::updateOrCreate(
            ['slug' => 'modul-css3-dan-layout-modern'],
            [
                'name' => 'Modul CSS3 & Layout Modern',
                'description' => 'Kuasai seni menata layout web responsif, universal box-sizing, Flexbox 1D, CSS Grid 2D, variabel tema, dan animasi transisi.',
                'order' => 2,
                'is_active' => true,
                'is_public' => true,
                'icon' => 'palette',
                'color' => '#3b82f6',
                'badge' => 'CSS3 Master',
            ]
        );

        // Modul 2.1
        Module::updateOrCreate(
            ['slug' => 'universal-box-sizing-dan-reset-css'],
            [
                'category_id' => $catCss->id,
                'section' => 'Fondasi Tata Letak CSS',
                'title' => 'Sistem Kalkulasi Specificity & Universal Box-Sizing Reset',
                'order' => 1,
                'is_published' => true,
                'is_public' => true,
                'enable_protection' => false,
                'excerpt' => 'Bedah tuntas rumus pembobotan selektor CSS, masalah default content-box, dan teknik modern universal reset menggunakan border-box.',
                'content' => '# Sistem Kalkulasi Specificity & Universal Box-Sizing Reset

Sebelum Anda menyusun tata letak yang rumit dengan Flexbox atau Grid, Anda harus menguasai bagaimana peramban menghitung dimensi fisik elemen serta bagaimana algoritma CSS memutus perselisihan aturan gaya yang saling bertabrakan (*cascading conflict*).

---

## 1. Rumus Matematika Specificity CSS

Ketika dua aturan menargetkan elemen yang sama, selektor dengan **poin Specificity tertinggi** yang akan menang:

| Level | Tipe Selektor | Contoh Penulisan | Bobot Skor |
| :---: | :--- | :--- | :---: |
| **A** | Inline Style | `<div style="color: blue;">` | **1000** |
| **B** | ID Selector | `#hero-banner` | **100** |
| **C** | Class, Attribute & Pseudo-class | `.btn-primary`, `[type="text"]`, `:hover` | **10** |
| **D** | Elemen & Pseudo-element | `h1`, `p`, `::before`, `::after` | **1** |

### Contoh Perhitungan:
```css
/* Specificity: 0, 0, 0, 1 (Skor: 1) */
p {
  color: black;
}

/* Specificity: 0, 0, 1, 1 (Skor: 11) -> MENANG atas p biasa */
article.post-entry p {
  color: #334155;
}

/* Specificity: 0, 1, 1, 1 (Skor: 111) -> MENANG mutlak */
#main-content .post-entry p {
  color: #0f172a;
}
```

> [!WARNING]
> Hindari penggunaan kata kunci `!important`! Kata kunci ini merusak alur alami cascading dan membuat stylesheet Anda hampir mustahil untuk dirawat dan di-override di masa depan. Atasi konflik gaya dengan menstrukturkan kelas CSS yang bersih.

---

## 2. Masalah Besar Standar Lama: `content-box`

Secara bawaan (*default* peramban), elemen HTML menggunakan model perhitungan `box-sizing: content-box`:
- Jika Anda memberi elemen `width: 300px`, `padding: 20px`, dan `border: 5px solid black`, maka total lebar fisik yang memakan tempat di layar menjadi:
  $$\text{Total Width} = 300 + (2 \times 20) + (2 \times 5) = \mathbf{350\text{ piksel!}}$$
- Hal ini menyebabkan tata letak kolom seringkali tiba-tiba meluap (*overflow*) dan patah ke bawah tanpa alasan yang jelas.

---

## 3. Solusi Industri: Universal Border-Box Reset

Solusi baku di industri pengembangan web modern adalah menerapkan aturan reset universal di puncak stylesheet Anda:

```css:reset.css
*,
*::before,
*::after {
  box-sizing: border-box;
  margin: 0;
  padding: 0;
}

html {
  -webkit-text-size-adjust: 100%;
  font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
  line-height: 1.5;
}

img,
picture,
video,
canvas,
svg {
  display: block;
  max-width: 100%;
  height: auto;
}
```

Dengan `box-sizing: border-box`, ketika Anda menetapkan `width: 300px`, nilai padding dan border akan **dikurangi dari dalam**, sehingga lebar fisik elemen tetap konsisten persis 300 piksel!',
            ]
        );

        // Modul 2.2
        Module::updateOrCreate(
            ['slug' => 'panduan-master-flexbox-satu-dimensi'],
            [
                'category_id' => $catCss->id,
                'section' => 'Sistem Tata Letak Modern',
                'title' => 'Panduan Lengkap Flexbox 1 Dimensi (Flex Container & Items)',
                'order' => 2,
                'is_published' => true,
                'is_public' => true,
                'enable_protection' => false,
                'excerpt' => 'Kuasai tata letak fleksibel 1 dimensi: main axis vs cross axis, justify-content, align-items, flex-wrap, serta properti anak flex-grow dan flex-shrink.',
                'content' => '# Panduan Lengkap Flexbox 1 Dimensi (Flex Container & Items)

**Flexbox (Flexible Box Layout)** dirancang khusus untuk mendistribusikan ruang dan meratakan posisi elemen di sepanjang **satu dimensi tunggal** (baik sebagai satu baris horizontal ATAU sebagai satu kolom vertikal).

---

## 1. Dua Sumbu Utama Flexbox

Kunci utama memahami Flexbox adalah menguasai dua sumbu arah:
1. **Main Axis (Sumbu Utama)**: Ditentukan oleh arah `flex-direction`.
   - `row` (default): Sumbu utama bergerak mendatar dari kiri ke kanan.
   - `column`: Sumbu utama bergerak menurun dari atas ke bawah.
2. **Cross Axis (Sumbu Silang)**: Sumbu yang tegak lurus 90 derajat terhadap Main Axis.

---

## 2. Properti untuk Induk Kontainer (`display: flex`)

```css
.navbar-container {
  display: flex;
  flex-direction: row; /* Arah aliran item */
  justify-content: space-between; /* Penataan di sepanjang Main Axis */
  align-items: center; /* Penataan di sepanjang Cross Axis */
  flex-wrap: wrap; /* Izinkan item pindah ke baris baru jika layar sempit */
  gap: 1.5rem; /* Jarak modern antar elemen tanpa margin trik */
}
```

### Opsi Nilai `justify-content` (Main Axis):
- `flex-start`: Merapat ke pangkal awal sumbu.
- `center`: Terpusat di tengah-tengah ruang kosong.
- `flex-end`: Merapat ke ujung akhir sumbu.
- `space-between`: Item pertama di pojok kiri, item terakhir di pojok kanan, sisa ruang dibagi rata di antaranya.
- `space-around`: Seluruh item memiliki spasi yang sama di kedua sisinya.
- `space-evenly`: Seluruh jarak pemisah antar item dan tepian kontainer memiliki ukuran identik.

---

## 3. Properti untuk Elemen Anak (Flex Items)

Setiap elemen yang berada langsung di dalam kontainer flex dapat diatur perilakunya secara individu:

```css
.card-sidebar {
  /* flex: [flex-grow] [flex-shrink] [flex-basis] */
  flex: 0 0 280px; /* Lebar tetap 280px, tidak membesar dan tidak mengecil */
}

.card-main-content {
  flex: 1 1 0%; /* Mengambil sisa ruang kosong yang tersedia */
}

.special-badge {
  align-self: flex-start; /* Override perataan Cross Axis khusus elemen ini */
}
```

### Penjelasan `flex-grow`, `flex-shrink`, dan `flex-basis`:
- **`flex-grow: 1`**: Menentukan kemampuan elemen untuk membesar mengisi sisa ruang kosong yang tersedia di kontainer.
- **`flex-shrink: 0`**: Mencegah elemen agar tidak menciut gepeng jika ukuran layar menyempit.
- **`flex-basis: auto`**: Ukuran patokan awal sebelum sisa ruang didistribusikan.',
            ]
        );

        // Modul 2.3
        Module::updateOrCreate(
            ['slug' => 'arsitektur-css-grid-dua-dimensi'],
            [
                'category_id' => $catCss->id,
                'section' => 'Sistem Tata Letak Modern',
                'title' => 'Arsitektur CSS Grid 2 Dimensi & Tata Letak Responsif Tanpa Media Query',
                'order' => 3,
                'is_published' => true,
                'is_public' => true,
                'enable_protection' => false,
                'excerpt' => 'Pelajari sistem kisi dua dimensi, unit pecahan fr, minmax(), repeat(auto-fit), template area visual, serta kapan memilih Flexbox vs Grid.',
                'content' => '# Arsitektur CSS Grid 2 Dimensi & Tata Letak Responsif Tanpa Media Query

Jika Flexbox menguasai tata letak 1 dimensi (hanya baris ATAU kolom), maka **CSS Grid** adalah raja tata letak **2 dimensi** (mampu mengatur baris DAN kolom secara simultan dalam satu kanvas kisi terpadu).

---

## 1. Kisi Responsif Ajaib Tanpa Perlu Media Queries

Salah satu trik terpopuler di kalangan pengembang modern adalah membuat galeri kartu yang otomatis menyesuaikan jumlah kolom secara dinamis pada berbagai ukuran layar ponsel, tablet, maupun layar 4K menggunakan satu baris sakti:

```css
.product-grid {
  display: grid;
  /* Kolom otomatis menyesuaikan lebar minimum 280px hingga 1 pecahan ruang bebas */
  grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
  gap: 1.5rem;
}
```

### Bedah Logika di Balik Aturan Ini:
1. **`repeat()`**: Menginstruksikan peramban membuat kolom berulang.
2. **`auto-fit`**: Secara cerdas meregangkan kolom yang ada agar memenuhi lebar baris kontainer penuh jika jumlah kartu sedikit.
3. **`minmax(280px, 1fr)`**: Setiap kolom kartu minimal berukuran 280 piksel di layar sempit, namun jika tersedia ruang lebih luas, lebarnya akan berkembang secara proporsional menggunakan unit fraksi (`1fr`).

---

## 2. Tata Letak Dashboard dengan `grid-template-areas`

CSS Grid memungkinkan Anda memetakan arsitektur halaman seperti menggambar sketsa visual langsung di dalam kode:

```css
.dashboard-layout {
  display: grid;
  grid-template-columns: 260px 1fr;
  grid-template-rows: auto 1fr auto;
  grid-template-areas:
    "sidebar header"
    "sidebar main"
    "sidebar footer";
  min-height: 100vh;
  gap: 1rem;
}

/* Memetakan elemen ke zona area kisi */
.app-header  { grid-area: header; }
.app-sidebar { grid-area: sidebar; }
.app-main    { grid-area: main; }
.app-footer  { grid-area: footer; }

/* Mengubah layout di perangkat mobile */
@media (max-width: 768px) {
  .dashboard-layout {
    grid-template-columns: 1fr;
    grid-template-areas:
      "header"
      "main"
      "sidebar"
      "footer";
  }
}
```

---

## 3. Matriks Keputusan: Kapan Menggunakan Flexbox vs CSS Grid?

| Kebutuhan Tata Letak | Solusi Paling Tepat | Alasan Teknis |
| :--- | :---: | :--- |
| Bilah Navigasi Navbar (Logo di kiri, Menu di tengah, Profil di kanan) | **Flexbox** | Aliran 1 dimensi horizontal dengan perataan `justify-content` |
| Galeri Produk E-Commerce / Portofolio Kartu | **CSS Grid** | Menyelaraskan ukuran tinggi dan lebar baris & kolom secara seragam |
| Penataan Formulir Baris & Kolom Kompleks | **CSS Grid** | Presisi penempatan dua dimensi |
| Pemusatan Elemen Tunggal di Tengah Layar | **Flexbox / Grid** | Keduanya sangat mudah (`margin: auto` atau `place-items: center`) |',
            ]
        );

        // Modul 2.4
        Module::updateOrCreate(
            ['slug' => 'variabel-tema-css-dan-animasi-ui'],
            [
                'category_id' => $catCss->id,
                'section' => 'Desain Lanjutan & Animasi',
                'title' => 'Variabel Tema CSS (Custom Properties), Tipografi Cairan & Micro-Animations',
                'order' => 4,
                'is_published' => true,
                'is_public' => true,
                'enable_protection' => false,
                'excerpt' => 'Implementasi sistem tema gelap/terang dengan CSS variables, fungsi kalkulasi tipografi dinamis clamp(), serta animasi halus dengan @keyframes.',
                'content' => '# Variabel Tema CSS (Custom Properties), Tipografi Cairan & Micro-Animations

Situs web modern tidak lagi statis. Pengguna mengharapkan fitur peralihan Tema Gelap (*Dark Mode*), ukuran huruf yang menyesuaikan ukuran monitor secara halus tanpa patahan resolusi, serta umpan balik visual (*micro-animations*) yang memikat.

---

## 1. Arsitektur Tema Gelap dengan CSS Custom Properties

Variabel CSS dideklarasikan dengan awalan dua tanda minus (`--`) dan dapat diwariskan ke seluruh elemen di bawah cakupannya:

```css
/* Token Desain Global (Default Tema Terang) */
:root {
  --warna-latar: #f8fafc;
  --warna-kartu: #ffffff;
  --warna-teks-primer: #0f172a;
  --warna-teks-sekunder: #64748b;
  --warna-aksen: #4f46e5;
  --radius-sudut: 12px;
  --bayangan-kartu: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
}

/* Override Otomatis Jika Sistem OS Pengguna Menggunakan Dark Mode */
@media (prefers-color-scheme: dark) {
  :root {
    --warna-latar: #090d16;
    --warna-kartu: #131b2e;
    --warna-teks-primer: #f1f5f9;
    --warna-teks-sekunder: #94a3b8;
    --bayangan-kartu: 0 10px 15px -3px rgba(0, 0, 0, 0.5);
  }
}

/* Penggunaan di Kelas Komponen */
.card-item {
  background-color: var(--warna-kartu);
  color: var(--warna-teks-primer);
  border-radius: var(--radius-sudut);
  box-shadow: var(--bayangan-kartu);
  padding: 1.5rem;
  transition: background-color 0.3s ease, color 0.3s ease;
}
```

---

## 2. Tipografi Cairan Modern Menggunakan `clamp()`

Lupakan penulisan belasan media query hanya untuk memperbesar `font-size` judul. Gunakan fungsi matematika `clamp(minimum, ideal_fluid, maksimum)`:

```css
h1.hero-title {
  /* 
    Min: 2rem (32px di mobile)
    Ideal: 1.2rem + 3.5vw (menyesuaikan lebar viewport secara halus)
    Max: 4rem (64px di layar desktop besar)
  */
  font-size: clamp(2rem, 1.2rem + 3.5vw, 4rem);
  line-height: 1.15;
  font-weight: 800;
}
```

---

## 3. Micro-Interactions: Transisi Halus dan Keyframe Animasi

Animasi yang baik adalah animasi yang memberikan konteks interaksi tanpa memperlambat performa rendering perangkat pengguna:

```css
/* Efek Hover Tombol Menawan */
.btn-modern {
  background-color: var(--warna-aksen);
  color: #ffffff;
  padding: 0.75rem 1.5rem;
  border-radius: 8px;
  border: none;
  cursor: pointer;
  transform: translateY(0);
  transition: transform 0.2s cubic-bezier(0.4, 0, 0.2, 1), box-shadow 0.2s ease;
}

.btn-modern:hover {
  transform: translateY(-2px);
  box-shadow: 0 10px 20px -5px rgba(79, 70, 229, 0.4);
}

.btn-modern:active {
  transform: translateY(0);
}

/* Animasi Denyut Berulang (Pulse Glow Effect) */
@keyframes denyutHalus {
  0%, 100% {
    transform: scale(1);
    opacity: 1;
  }
  50% {
    transform: scale(1.05);
    opacity: 0.85;
  }
}

.badge-live-promo {
  display: inline-block;
  animation: denyutHalus 2s infinite ease-in-out;
}
```

> [!TIP]
> Prioritaskan menganimasikan properti **`transform`** dan **`opacity`** karena keduanya diproses langsung oleh kartu grafis (GPU) tanpa memicu kalkulasi ulang tata letak (*reflow / layout shift*) yang berat bagi CPU.',
            ]
        );

        // =========================================================================
        // KATEGORI 3: JAVASCRIPT ES6+, MANIPULASI DOM & WEB APIS
        // =========================================================================
        $catJs = ModuleCategory::updateOrCreate(
            ['slug' => 'modul-javascript-modern-dan-dom'],
            [
                'name' => 'Modul JavaScript Modern & DOM',
                'description' => 'Panduan komprehensif sintaks modern ES6+, logika percabangan, manipulasi array fungsional, event handling DOM, dan asynchronous Fetch API.',
                'order' => 3,
                'is_active' => true,
                'is_public' => true,
                'icon' => 'code',
                'color' => '#eab308',
                'badge' => 'JS Modern',
            ]
        );

        // Modul 3.1
        Module::updateOrCreate(
            ['slug' => 'sintaks-modern-es6-scope-dan-destructuring'],
            [
                'category_id' => $catJs->id,
                'section' => 'Fondasi Bahasa JavaScript',
                'title' => 'Fondasi Sintaks Modern ES6+, Scope Variabel & Destructuring',
                'order' => 1,
                'is_published' => true,
                'is_public' => true,
                'enable_protection' => false,
                'excerpt' => 'Pelajari perbedaan deklarasi let/const vs var, konsep block scope leksikal, template literal ekspresi, rest/spread operator, dan teknik destructuring objek.',
                'content' => '# Fondasi Sintaks Modern ES6+, Scope Variabel & Destructuring

JavaScript telah bertransformasi pesat sejak era standardisasi ECMAScript 2015 (ES6). Menulis JavaScript hari ini menuntut pemahaman mendalam tentang keamanan cakupan variabel (*scoping*), kejelasan struktur data, dan kode deklaratif yang bersih.

---

## 1. Deklarasi Variabel Modern: `const` dan `let`

Tinggalkan penggunaan `var` lama dalam kode baru Anda:

```javascript
// 1. const: Digunakan untuk nilai yang tidak akan di-assign ulang
const TINGKAT_PAJAK_PPN = 0.11;
const profilUser = { nama: "Faisal", role: "developer" };

// CATATAN: Properti di dalam objek const TETAP BISA diubah:
profilUser.role = "lead_developer"; // Valid!
// profilUser = { nama: "Rian" }; // TypeError: Assignment to constant variable

// 2. let: Digunakan ketika nilai memang akan bermutasi
let nomorAntrean = 101;
nomorAntrean += 1; // Valid, menjadi 102
```

### Mengapa Block Scope Begitu Penting?
```javascript
function hitungSkor() {
  if (true) {
    var variabelVar = "Saya bisa bocor!";
    let variabelLet = "Saya aman di dalam blok";
  }
  console.log(variabelVar); // Output: "Saya bisa bocor!" (Bahaya kebocoran scope)
  // console.log(variabelLet); // ReferenceError: variabelLet is not defined (Aman!)
}
```

---

## 2. Template Literals & Multi-line String

Lupakan penggabungan string manual dengan tanda plus `+` yang rentan kesalahan spasi:

```javascript
const namaSiswa = "Nurul";
const kursusAktif = "Arsitektur CSS Modern";
const progresNilai = 95;

// Penulisan modern menggunakan karakter backtick (`)
const kartuInfo = `
  <div class="user-card">
    <h3>Halo, \${namaSiswa}!</h3>
    <p>Kursus: \${kursusAktif}</p>
    <span class="badge \${progresNilai >= 80 ? "lulus" : "perlu-revisi"}">
      Nilai Akhir: \${progresNilai}%
    </span>
  </div>
`;
```

---

## 3. Destructuring Assignment (Pembongkaran Struktur Data)

Mengekstrak data dari objek atau array menjadi variabel mandiri dengan sangat elegan:

```javascript
// Destructuring Objek
const pengaturan = {
  tema: "dark",
  resolusi: "1080p",
  volume: 75,
  notifikasi: { suara: true, popup: false }
};

// Mengambil properti dengan default value dan rename alias
const { tema, resolusi, volume: levelAudio, bahasa = "id" } = pengaturan;
console.log(levelAudio); // 75
console.log(bahasa);     // "id" (nilai default)

// Destructuring Array
const warnaPilihan = ["#ef4444", "#3b82f6", "#10b981"];
const [warnaMerah, warnaBiru] = warnaPilihan;
```

---

## 4. Spread Operator (`...`) dan Rest Parameters

```javascript
// 1. Kloning & Penggabungan Immutability (Spread)
const dataLama = { id: 1, nama: "Budi" };
const dataBaru = { ...dataLama, kota: "Surabaya", nama: "Budi Santoso" };

const arrayA = [1, 2, 3];
const arrayB = [...arrayA, 4, 5]; // [1, 2, 3, 4, 5]

// 2. Rest Parameters (Mengumpulkan argumen tak terbatas)
function hitungRataRata(...daftarAngka) {
  const total = daftarAngka.reduce((acc, curr) => acc + curr, 0);
  return total / daftarAngka.length;
}
console.log(hitungRataRata(80, 90, 100, 70)); // 85
```',
            ]
        );

        // Modul 3.2
        Module::updateOrCreate(
            ['slug' => 'pengolahan-data-array-map-filter-reduce'],
            [
                'category_id' => $catJs->id,
                'section' => 'Manipulasi Data Fungsional',
                'title' => 'Pengolahan Data Tingkat Tinggi dengan Map, Filter & Reduce',
                'order' => 2,
                'is_published' => true,
                'is_public' => true,
                'enable_protection' => false,
                'excerpt' => 'Kuasai paradigma pemrograman fungsional tanpa mutasi: transformasi dengan map(), penyaringan dengan filter(), dan akumulasi data kompleks dengan reduce().',
                'content' => '# Pengolahan Data Tingkat Tinggi dengan Map, Filter & Reduce

Dalam rekayasa perangkat lunak modern, pengolahan koleksi data array dihindari menggunakan perulangan imperatif konvensional `for (let i = 0; i < n; i++)`. Sebaliknya, kita mengadopsi metode deklaratif murni yang **tidak mengubah (*immutable*)** array asli.

---

## 1. Array.prototype.map() — Transformasi Elemen

`map()` memetakan setiap elemen pada array asal ke elemen baru sesuai fungsi callback yang Anda berikan, menghasilkan array baru dengan panjang yang sama persis:

```javascript
const daftarSiswa = [
  { nama: "Alif", nilai: 70 },
  { nama: "Bella", nilai: 85 },
  { nama: "Citra", nilai: 92 }
];

// Mengambil hanya array berisi nama-nama siswa
const daftarNama = daftarSiswa.map(siswa => siswa.nama);
// Output: ["Alif", "Bella", "Citra"]

// Menambahkan bonus nilai 5 poin ke setiap siswa
const siswaDenganBonus = daftarSiswa.map(siswa => ({
  ...siswa,
  nilaiAkhir: Math.min(100, siswa.nilai + 5)
}));
```

---

## 2. Array.prototype.filter() — Penyaringan Bersyarat

`filter()` mengevaluasi setiap item dengan predikat kondisi logika boolean. Item yang mengembalikan nilai `true` akan dikumpulkan ke dalam array baru:

```javascript
const transaksi = [
  { id: 101, tipe: "masuk", nominal: 500000 },
  { id: 102, tipe: "keluar", nominal: 120000 },
  { id: 103, tipe: "masuk", nominal: 350000 },
  { id: 104, tipe: "keluar", nominal: 80000 }
];

// Menyaring hanya transaksi pengeluaran
const daftarPengeluaran = transaksi.filter(t => t.tipe === "keluar");
// Hasil: Array berisi 2 item (id 102 dan 104)
```

---

## 3. Array.prototype.reduce() — Akumulasi Menjadi Satu Nilai

`reduce()` memproses setiap elemen secara berurutan dan mengakumulasikannya ke dalam satu variabel penampung (*accumulator*):

```javascript
// Menghitung total seluruh nominal transaksi uang masuk
const totalPemasukan = transaksi
  .filter(t => t.tipe === "masuk")
  .reduce((akumulator, item) => {
    return akumulator + item.nominal;
  }, 0); // 0 adalah nilai awal akumulator

console.log(totalPemasukan); // Output: 850000
```

---

## 4. Rantai Pemanggilan Metode (Method Chaining)

Kekuatan sebenarnya dari metode array modern adalah kemampuannya dirangkai menjadi pipa pengolahan (*pipeline*) yang elegan dan mudah dibaca:

```javascript
const keranjangBelanja = [
  { produk: "Keyboard", harga: 500000, qty: 1, kenaPajak: true },
  { produk: "Mousepad", harga: 75000, qty: 2, kenaPajak: false },
  { produk: "Headset", harga: 300000, qty: 1, kenaPajak: true }
];

// Hitung total pajak PPN (11%) hanya untuk barang yang kena pajak
const totalPajakPPN = keranjangBelanja
  .filter(item => item.kenaPajak)
  .map(item => item.harga * item.qty * 0.11)
  .reduce((total, pajakItem) => total + pajakItem, 0);

console.log(`Total PPN: Rp \${totalPajakPPN.toLocaleString("id-ID")}`);
```',
            ]
        );

        // Modul 3.3
        Module::updateOrCreate(
            ['slug' => 'interaktivitas-dom-dan-event-handling'],
            [
                'category_id' => $catJs->id,
                'section' => 'Manipulasi DOM & Interaktivitas',
                'title' => 'Interaktivitas DOM Dinamis & Event Handling Berkinerja Tinggi',
                'order' => 3,
                'is_published' => true,
                'is_public' => true,
                'enable_protection' => false,
                'excerpt' => 'Pelajari seleksi querySelector, manipulasi classList, penanganan event listener, perbedaan bubbling vs capturing, serta teknik event delegation berkinerja tinggi.',
                'content' => '# Interaktivitas DOM Dinamis & Event Handling Berkinerja Tinggi

Document Object Model (DOM) adalah jembatan antarmuka yang memungkinkan kode JavaScript membaca, mengubah, menambah, atau menghapus elemen HTML secara langsung saat pengguna berinteraksi di halaman web.

---

## 1. Seleksi Elemen Modern Berbasis CSS Query

Gunakan dua API utama yang seragam:
```javascript
// Mengambil satu elemen pertama yang cocok
const tombolBeli = document.querySelector("#btn-checkout");
const inputKupon = document.querySelector(".input-kupon-promo");

// Mengambil seluruh elemen yang cocok dalam bentuk NodeList
const semuaKartuProduk = document.querySelectorAll(".card-item");
semuaKartuProduk.forEach(kartu => {
  kartu.addEventListener("mouseenter", () => kartu.classList.add("hovered"));
});
```

---

## 2. Manipulasi Kelas dan Konten Teks Secara Aman

Hindari manipulasi gaya inline langsung (`el.style.display = "none"`). Gunakan manajemen kelas CSS:

```javascript
const bannerPemberitahuan = document.querySelector("#alert-banner");

// Manipulasi Kelas CSS (classList API)
bannerPemberitahuan.classList.add("show", "alert-success");
bannerPemberitahuan.classList.remove("d-none");
bannerPemberitahuan.classList.toggle("is-active");

// Memperbarui Teks Secara Aman (Mencegah serangan XSS)
bannerPemberitahuan.textContent = "Data formulir Anda berhasil disimpan!";
```

> [!CAUTION]
> **Bahaya Keamanan innerHTML:** Jangan pernah memasukkan teks masukan dari pengguna secara mentah ke dalam `element.innerHTML` tanpa sanitasi, karena dapat dieksploitasi melalui serangan Cross-Site Scripting (XSS). Selalu gunakan `element.textContent` untuk teks biasa!

---

## 3. Penanganan Event: `preventDefault()` dan `stopPropagation()`

```javascript
const formRegistrasi = document.querySelector("#form-daftar");

formRegistrasi.addEventListener("submit", function(event) {
  // PENTING: Mencegah browser me-reload halaman secara default
  event.preventDefault();

  const inputEmail = document.querySelector("#email-pengguna");
  if (!inputEmail.value.includes("@")) {
    alert("Harap masukkan format email yang valid!");
    inputEmail.focus();
    return;
  }

  console.log("Mengirim data pengguna via AJAX...");
});
```

---

## 4. Teknik Event Delegation untuk Performa Tinggi

Jika Anda memiliki daftar berisi 100 item dan setiap item memiliki tombol "Hapus", **jangan memasang 100 event listener secara terpisah**. Cukup pasang **1 event listener tunggal** pada elemen kontainer pembungkusnya:

```html
<ul id="daftar-tugas">
  <li>Belajar HTML <button class="btn-hapus" data-id="1">X</button></li>
  <li>Belajar CSS <button class="btn-hapus" data-id="2">X</button></li>
  <li>Belajar JS <button class="btn-hapus" data-id="3">X</button></li>
</ul>
```

```javascript
const kontainerDaftar = document.querySelector("#daftar-tugas");

// Memanfaatkan Event Bubbling ke elemen induk
kontainerDaftar.addEventListener("click", function(event) {
  // Cek apakah target yang diklik adalah tombol hapus
  if (event.target.classList.contains("btn-hapus")) {
    const idItem = event.target.dataset.id;
    console.log(`Menghapus data dengan ID: \${idItem}`);
    
    // Hapus elemen li induk dari DOM
    event.target.closest("li").remove();
  }
});
```',
            ]
        );

        // Modul 3.4
        Module::updateOrCreate(
            ['slug' => 'asynchronous-javascript-promise-dan-fetch-api'],
            [
                'category_id' => $catJs->id,
                'section' => 'Komunikasi Jaringan & API',
                'title' => 'Asynchronous JavaScript: Promise, Async/Await & Integrasi Fetch API',
                'order' => 4,
                'is_published' => true,
                'is_public' => true,
                'enable_protection' => false,
                'excerpt' => 'Pahami mekanisme non-blocking I/O event loop, penanganan janji Promise, sintaks modern async/await, penanganan error try/catch, dan konsumsi REST API menggunakan Fetch.',
                'content' => '# Asynchronous JavaScript: Promise, Async/Await & Integrasi Fetch API

JavaScript adalah bahasa yang berjalan di atas sistem *Single-Threaded* (hanya mampu mengeksekusi satu instruksi dalam satu waktu). Untuk menjalankan operasi yang memakan waktu lama—seperti memuat data dari server internet tanpa membuat halaman membeku (*freezing*)—JavaScript memanfaatkan mekanisme **Asynchronous** dan **Event Loop**.

---

## 1. Tiga Status Utama Siklus Hidup Promise

Promise adalah representasi nilai yang mungkin tersedia sekarang, nanti di masa depan, atau tidak pernah sama sekali (gagal):
1. **Pending**: Operasi sedang berlangsung di jaringan latar belakang.
2. **Fulfilled (Resolved)**: Operasi berhasil dan mengembalikan data respon.
3. **Rejected**: Operasi mengalami kegagalan (misalnya koneksi putus atau server error).

---

## 2. Pola Penulisan Modern: `async` dan `await`

Sintaks `async/await` memungkinkan kita menulis kode asynchronous yang terlihat dan terasa seringkas kode synchronous berurutan:

```javascript
// Mendeklarasikan fungsi asynchronous dengan kata kunci async
async function muatDataPengguna(userId) {
  const urlApi = `https://jsonplaceholder.typicode.com/users/\${userId}`;

  try {
    console.log("1. Memulai permintaan HTTP ke server...");

    // Menunggu respon HTTP tiba menggunakan await
    const response = await fetch(urlApi);

    // Validasi apakah status kode HTTP berada di rentang sukses (200-299)
    if (!response.ok) {
      throw new Error(`Permintaan gagal dengan status HTTP: \${response.status}`);
    }

    // Parsing stream data JSON menjadi objek JavaScript
    const dataUser = await response.json();
    console.log("2. Data berhasil diterima:", dataUser);

    return dataUser;

  } catch (error) {
    // Blok penanganan error jika internet mati atau URL salah
    console.error("Terjadi kendala jaringan:", error.message);
    throw error;

  } finally {
    console.log("3. Proses pemanggilan API selesai.");
  }
}
```

---

## 3. Mengirim Data ke Server dengan HTTP POST

```javascript
async function kirimDataRegistrasi(payloadData) {
  try {
    const response = await fetch("/api/v1/auth/register", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        "Accept": "application/json"
      },
      body: JSON.stringify(payloadData)
    });

    const hasil = await response.json();

    if (!response.ok) {
      throw new Error(hasil.pesan || "Gagal memproses pendaftaran");
    }

    return hasil;
  } catch (err) {
    console.error("Registrasi gagal:", err.message);
    alert(err.message);
  }
}
```

---

## 4. Menjalankan Banyak Permintaan Paralel dengan `Promise.all()`

Jika Anda perlu memuat 3 data independen (misalnya: Data Profil, Data Keranjang, dan Data Notifikasi), jangan gunakan `await` satu per satu yang memperlambat loading. Jalankan secara serentak bersamaan:

```javascript
async function muatDashboardPengguna() {
  try {
    const [profilRes, keranjangRes, notifikasiRes] = await Promise.all([
      fetch("/api/profil"),
      fetch("/api/keranjang"),
      fetch("/api/notifikasi")
    ]);

    const profil = await profilRes.json();
    const keranjang = await keranjangRes.json();
    const notifikasi = await notifikasiRes.json();

    console.log("Seluruh data dashboard berhasil dimuat secara simultan!");
  } catch (error) {
    console.error("Salah satu permintaan gagal dimuat:", error);
  }
}
```',
            ]
        );
    }
}
