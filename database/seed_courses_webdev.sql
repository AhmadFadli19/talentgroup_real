-- ===================================================================
-- TalentGroup Academy - Data Seed Kursus & Modul Lengkap Web Dev (Full Curriculum)
-- Kursus: HTML5, CSS3 Modern, dan JavaScript ES6+ (Lengkap Nol s/d Proyek)
-- Modul Dokumentasi: HTML5, CSS3, dan JavaScript (4 Bab per Kategori)
-- Tanggal Pembuatan: 2026-10-25 02:45:12
-- ===================================================================

SET FOREIGN_KEY_CHECKS=0;

-- -------------------------------------------------------------
-- Data untuk tabel `courses` (Total: 3 baris)
-- -------------------------------------------------------------
DELETE FROM `courses`;
INSERT INTO `courses` (`id`, `title`, `description`, `price`, `image`, `is_active`, `quiz_answer_visibility`, `quiz_navigation_mode`, `shuffle_questions`, `shuffle_options`, `created_by`, `created_at`, `updated_at`) VALUES (1, 'A01 - HTML5 Komprehensif: Dari Nol Pengenalan Hingga Mahir Membangun Web Semantik', 'Panduan terstruktur belajar HTML5 dari nol. Kuasai sintaks dasar, anatomi dokumen, pemformatan teks, sistem navigasi dan tautan, tabel data, formulir validasi modern, integrasi multimedia, aksesibilitas (a11y), hingga struktur halaman berstandar industri siap produksi.', 0.00, NULL, 1, 'end', 'free', 1, 1, 1, '2026-10-25 02:44:54', '2026-10-25 02:44:54');
INSERT INTO `courses` (`id`, `title`, `description`, `price`, `image`, `is_active`, `quiz_answer_visibility`, `quiz_navigation_mode`, `shuffle_questions`, `shuffle_options`, `created_by`, `created_at`, `updated_at`) VALUES (2, 'A02 - CSS3 Komprehensif: Seni Menata Desain Web, Flexbox, Grid & Animasi UI', 'Eksplorasi mendalam desain antarmuka modern. Dari pemahaman selektor CSS, specificity, universal box-sizing, tipografi cairan (clamp), Flexbox 1 dimensi, CSS Grid 2 dimensi, teknik positioning (sticky/fixed), media queries mobile-first, hingga micro-interactions animasi transisi.', 75000.00, NULL, 1, 'end', 'free', 1, 1, 1, '2026-10-25 02:44:54', '2026-10-25 02:44:54');
INSERT INTO `courses` (`id`, `title`, `description`, `price`, `image`, `is_active`, `quiz_answer_visibility`, `quiz_navigation_mode`, `shuffle_questions`, `shuffle_options`, `created_by`, `created_at`, `updated_at`) VALUES (3, 'A03 - JavaScript ES6+ Komprehensif: Logika Pemrograman, Manipulasi DOM & Aplikasi Web', 'Dari nol logika pemrograman hingga mahir membangun aplikasi dinamis. Menguasai let/const, arrow functions, template literals, destructuring, metode array fungsional (map, filter, reduce), penanganan event, manipulasi DOM real-time, asynchronous promises, async/await, hingga integrasi Fetch API.', 99000.00, NULL, 1, 'end', 'free', 1, 1, 1, '2026-10-25 02:44:54', '2026-10-25 02:44:54');

-- -------------------------------------------------------------
-- Data untuk tabel `course_stories` (Total: 18 baris)
-- -------------------------------------------------------------
DELETE FROM `course_stories`;
INSERT INTO `course_stories` (`id`, `course_id`, `title`, `content`, `image_path`, `audio_path`, `video_url`, `use_image`, `use_audio`, `use_video`, `order`, `created_at`, `updated_at`) VALUES (1, 1, 'Bab 1: Pengenalan Web, Internet & Anatomi Dokumen HTML5', 'Selamat datang di perjalanan menjadi pengembang web profesional! Sebelum kita menulis kode, penting untuk memahami peran fundamental HTML.

### Apa itu HTML?
HTML singkatan dari **HyperText Markup Language**. HTML bukan bahasa pemrograman berlogika (seperti JS, PHP, atau Python), melainkan bahasa penandaan (*markup*) yang bertugas menentukan **struktur dan makna** dari konten halaman web.

### Anatomi Elemen HTML
Elemen HTML dibangun dari tiga komponen utama:
1. **Tag Pembuka (Opening Tag)**: Contoh `<p>` menandakan awal elemen paragraf.
2. **Konten (Content)**: Teks atau elemen anak di dalam tag, misalnya `Halo Dunia`.
3. **Tag Penutup (Closing Tag)**: Ditandai garis miring, contoh `</p>` menandakan akhir elemen.

### Anatomi Dokumen Lengkap
```html
<!DOCTYPE html>
<html lang=\"id\">
<head>
    <meta charset=\"UTF-8\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
    <title>Situs Pertamaku</title>
</head>
<body>
    <h1>Selamat Datang di Dunia Web Development!</h1>
    <p>Ini adalah langkah pertama membangun antarmuka web modern.</p>
</body>
</html>
```

> [!NOTE]
> - `<!DOCTYPE html>`: Menginstruksikan browser untuk menggunakan standar render HTML5 modern.
> - `<head>`: Menyimpan metadata (informasi penting untuk browser dan search engine yang tidak tampak langsung di layar).
> - `<body>`: Seluruh konten visual yang dilihat dan diinteraksikan langsung oleh pengguna.', NULL, NULL, NULL, 0, 0, 0, 1, '2026-10-25 02:44:54', '2026-10-25 02:44:54');
INSERT INTO `course_stories` (`id`, `course_id`, `title`, `content`, `image_path`, `audio_path`, `video_url`, `use_image`, `use_audio`, `use_video`, `order`, `created_at`, `updated_at`) VALUES (2, 1, 'Bab 2: Hierarki Judul (Headings), Pemformatan Teks & Tautan (Hyperlinks)', 'Sebuah halaman web yang baik memiliki hierarki informasi yang teratur agar pembaca dan mesin pencari (SEO) dapat mencerna konten secara mudah.

### 1. Hierarki Heading (h1 sampai h6)
- `<h1>`: Judul utama halaman web. **Aturan baku SEO: Hanya boleh ada SATU `<h1>` per halaman!**
- `<h2>`: Sub-judul dari bab topik utama.
- `<h3>` s/d `<h6>`: Rincian sub-topik yang lebih spesifik.

### 2. Format Teks Bermakna Semantik
- `<strong>`: Menandakan teks sangat penting (tebal).
- `<em>`: Memberikan penekanan intonasi kata (miring).
- `<mark>`: Menandai teks layaknya stabilo kuning.
- `<blockquote>`: Kutipan panjang dari sumber eksternal.

### 3. Tautan Hyperlink `<a>`
Tautan adalah inti dari konsep *HyperText* yang menghubungkan seluruh dokumen web di dunia:
```html
<!-- Tautan eksternal membuka tab baru dengan atribut keamanan -->
<a href=\"https://google.com\" target=\"_blank\" rel=\"noopener noreferrer\">
    Cari di Google
</a>

<!-- Tautan internal antar bagian halaman (Anchor Link) -->
<a href=\"#kontak-kami\">Hubungi Kami</a>
```', NULL, NULL, NULL, 0, 0, 0, 2, '2026-10-25 02:44:54', '2026-10-25 02:44:54');
INSERT INTO `course_stories` (`id`, `course_id`, `title`, `content`, `image_path`, `audio_path`, `video_url`, `use_image`, `use_audio`, `use_video`, `order`, `created_at`, `updated_at`) VALUES (3, 1, 'Bab 3: Daftar Terstruktur (Lists) & Tabel Data Semantik', 'Menampilkan kumpulan informasi yang rapi membutuhkan elemen pengelompokan yang tepat.

### 1. Tipe-Tipe Daftar (Lists)
- **Unordered List `<ul>`**: Daftar dengan tanda titik/bullet. Sangat sering dimanfaatkan sebagai kerangka dasar navigasi menu.
- **Ordered List `<ol>`**: Daftar bernomor berurutan (1, 2, 3), cocok untuk langkah panduan tutorial.
- Setiap butir data dibungkus dengan tag `<li>` (List Item).

```html
<ul>
    <li>HTML5 Semantik</li>
    <li>CSS3 Modern</li>
    <li>JavaScript ES6+</li>
</ul>
```

### 2. Tabel Data Semantik Modern
Jangan pernah menggunakan tabel untuk layout halaman! Tabel secara eksklusif diperuntukkan bagi data tabular (misal: laporan keuangan, jadwal, absensi):
```html
<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Modul</th>
            <th>Tingkat</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>1</td>
            <td>HTML5 Dasar</td>
            <td>Pemula</td>
        </tr>
    </tbody>
</table>
```', NULL, NULL, NULL, 0, 0, 0, 3, '2026-10-25 02:44:54', '2026-10-25 02:44:54');
INSERT INTO `course_stories` (`id`, `course_id`, `title`, `content`, `image_path`, `audio_path`, `video_url`, `use_image`, `use_audio`, `use_video`, `order`, `created_at`, `updated_at`) VALUES (4, 1, 'Bab 4: Pengelolaan Gambar Responsif, Audio, Video & Iframe', 'Website modern kaya akan konten multimedia. Namun, jika tidak diatur dengan benar, media dapat memperlambat loading website.

### 1. Tag Gambar `<img>` dengan Best Practice:
```html
<img src=\"/assets/hero-banner.webp\" 
     alt=\"Panduan Belajar Pemrograman Web Full-Stack\" 
     loading=\"lazy\" 
     width=\"800\" 
     height=\"450\">
```
- `alt`: Wajib diisi! Menjelaskan deskripsi gambar bagi tuna netra dan jika gambar gagal dimuat.
- `loading=\"lazy\"`: Menghemat bandwidth dengan hanya memuat gambar saat pengunjung menggulir layar mendekati gambar tersebut.

### 2. Video & Audio Native HTML5:
```html
<video controls width=\"640\" poster=\"thumbnail.jpg\">
    <source src=\"tutorial.mp4\" type=\"video/mp4\">
    Browser Anda tidak mendukung pemutar video HTML5.
</video>
```
Atribut `controls` memunculkan tombol putar, jeda, volume, dan layar penuh secara otomatis.', NULL, NULL, NULL, 0, 0, 0, 4, '2026-10-25 02:44:54', '2026-10-25 02:44:54');
INSERT INTO `course_stories` (`id`, `course_id`, `title`, `content`, `image_path`, `audio_path`, `video_url`, `use_image`, `use_audio`, `use_video`, `order`, `created_at`, `updated_at`) VALUES (5, 1, 'Bab 5: Arsitektur Formulir Interaktif, Tipe Input & Validasi Bawaan', 'Formulir adalah pintu masuk pengumpulan data pengguna. HTML5 menyediakan validasi bawaan di peramban tanpa perlu library eksternal.

### Komponen Form Lengkap:
```html
<form action=\"/register\" method=\"POST\">
    <!-- Group Input Nama -->
    <label for=\"fullname\">Nama Lengkap:</label>
    <input type=\"text\" id=\"fullname\" name=\"fullname\" required minlength=\"3\" placeholder=\"Contoh: Budi Pratama\">

    <!-- Group Email dengan Validasi Format Otomatis -->
    <label for=\"email\">Email Aktif:</label>
    <input type=\"email\" id=\"email\" name=\"email\" required placeholder=\"budi@domain.com\">

    <!-- Input Pilihan Dropdown -->
    <label for=\"course\">Pilihan Minat:</label>
    <select id=\"course\" name=\"course\" required>
        <option value=\"\">-- Pilih Peminatan --</option>
        <option value=\"frontend\">Frontend Engineering</option>
        <option value=\"backend\">Backend Engineering</option>
    </select>

    <!-- Tombol Submit -->
    <button type=\"submit\">Kirim Pendaftaran</button>
</form>
```', NULL, NULL, NULL, 0, 0, 0, 5, '2026-10-25 02:44:54', '2026-10-25 02:44:54');
INSERT INTO `course_stories` (`id`, `course_id`, `title`, `content`, `image_path`, `audio_path`, `video_url`, `use_image`, `use_audio`, `use_video`, `order`, `created_at`, `updated_at`) VALUES (6, 1, 'Bab 7: Arsitektur Semantik Penuh Halaman Web Modern', 'Tahap akhir dari penguasaan HTML5 adalah kemampuan merangkai seluruh elemen menjadi satu kesatuan dokumen utuh yang ramah mesin pencari (SEO-friendly) dan mudah dibaca oleh peramban pembaca tuna netra.

### Diagram Struktur Semantik:
1. `<header>`: Memuat logo brand, nama situs, dan menu navigasi `<nav>`.
2. `<main>`: Memuat inti konten unik yang dicari pengunjung.
   - Terbagi dalam beberapa `<section>` tematik.
   - Setiap artikel mandiri dibungkus `<article>`.
3. `<aside>`: Sidebar samping berisi daftar kategori, profil penulis, atau artikel terpopuler.
4. `<footer>`: Penutup halaman memuat hak cipta, peta situs, dan media sosial.

Dengan meninggalkan budaya kuno pembungkusan tanpa makna `<div>` berlebihan, kualitas kode Anda setara dengan standar insinyur web di perusahaan teknologi terkemuka.', NULL, NULL, NULL, 0, 0, 0, 7, '2026-10-25 02:44:54', '2026-10-25 02:44:54');
INSERT INTO `course_stories` (`id`, `course_id`, `title`, `content`, `image_path`, `audio_path`, `video_url`, `use_image`, `use_audio`, `use_video`, `order`, `created_at`, `updated_at`) VALUES (7, 2, 'Bab 1: Anatomi CSS, Selektor Modern & Aturan Specificity', 'CSS (**Cascading Style Sheets**) adalah bahasa yang memberikan keindahan, warna, dan tata letak pada dokumen HTML.

### Anatomi Pernyataan CSS
```css
selector {
    property: value;
}
```
- **Selector**: Menunjuk elemen HTML mana yang hendak diwarnai/diatur.
- **Declaration**: Terdiri dari nama properti dan nilainya, diakhiri titik koma `;`.

### Tingkat Bobot Selektor (Specificity Hierarchy):
1. **Inline Style** (`style=\"...\"`): Bobot tertinggi (1000 poin).
2. **ID Selector** (`#header`): Bobot tinggi (100 poin).
3. **Class, Pseudo-class, Attribute** (`.btn`, `:hover`, `[type=\"text\"]`): Bobot menengah (10 poin).
4. **Element & Pseudo-element** (`h1`, `p`, `::before`): Bobot dasar (1 poin).

> [!TIP]
> Hindari menggunakan `!important` untuk memaksakan gaya tampilan! Mengatur kelas CSS secara terstruktur dan menjaga selektor tetap ringkas adalah kunci kode yang mudah dirawat.', NULL, NULL, NULL, 0, 0, 0, 1, '2026-10-25 02:44:54', '2026-10-25 02:44:54');
INSERT INTO `course_stories` (`id`, `course_id`, `title`, `content`, `image_path`, `audio_path`, `video_url`, `use_image`, `use_audio`, `use_video`, `order`, `created_at`, `updated_at`) VALUES (8, 2, 'Bab 2: Menguasai Box Model, Margin Collapsing & Reset Modern', 'Setiap elemen pada peramban memiliki 4 lapisan kotak:
1. **Content**: Ruang teks atau gambar berada.
2. **Padding**: Ruang kosong di antara konten dan border.
3. **Border**: Garis batas tepi elemen.
4. **Margin**: Jarak luar elemen dengan elemen sekelilingnya.

### Fenomena Margin Collapsing:
Ketika dua margin vertikal elemen bertingkat bertemu (misalnya margin-bottom paragraf atas 20px dan margin-top paragraf bawah 30px), nilainya **tidak dijumlahkan** menjadi 50px, melainkan melebur (*collapse*) mengambil nilai terbesar yaitu 30px.

### Standar Reset Universal:
```css
*, *::before, *::after {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}
```
Dengan `border-box`, lebar elemen yang Anda tuliskan mencakup border dan padding, mencegah tata letak melebar tak terkendali.', NULL, NULL, NULL, 0, 0, 0, 2, '2026-10-25 02:44:54', '2026-10-25 02:44:54');
INSERT INTO `course_stories` (`id`, `course_id`, `title`, `content`, `image_path`, `audio_path`, `video_url`, `use_image`, `use_audio`, `use_video`, `order`, `created_at`, `updated_at`) VALUES (9, 2, 'Bab 3: Tipografi Responsif & Variabel Tema (CSS Custom Properties)', 'Tipografi menyumbang lebih dari 80% pengalaman membaca di sebuah website.

### 1. Tipografi Responsif dengan `clamp()`
Fungsi `clamp(min, preferred, max)` memungkinkan ukuran teks membesar dan mengecil secara otomatis sesuai lebar layar tanpa perlu menulis media query berulang kali!
```css
h1 {
    font-size: clamp(1.8rem, 4vw + 1rem, 3.5rem);
}
```

### 2. Variabel CSS Modern (Custom Properties)
Variabel mempermudah pembuatan mode terang (Light Mode) dan gelap (Dark Mode):
```css
:root {
    --bg-primary: #0a0f1d;
    --text-primary: #f8fafc;
    --accent-color: #38bdf8;
}

.card {
    background: var(--bg-primary);
    color: var(--text-primary);
    border: 1px solid var(--accent-color);
}
```', NULL, NULL, NULL, 0, 0, 0, 3, '2026-10-25 02:44:54', '2026-10-25 02:44:54');
INSERT INTO `course_stories` (`id`, `course_id`, `title`, `content`, `image_path`, `audio_path`, `video_url`, `use_image`, `use_audio`, `use_video`, `order`, `created_at`, `updated_at`) VALUES (10, 2, 'Bab 4: Arsitektur Flexbox: Sumbu Utama, Sumbu Silang & Distribusi Ruang', 'Flexbox adalah solusi terbaik untuk menyusun elemen-elemen dalam satu baris atau satu kolom.

### Memahami Dua Sumbu Flex:
1. **Sumbu Utama (Main Axis)**: Ditentukan oleh properti `flex-direction: row` (horizontal ke kanan) atau `column` (vertikal ke bawah).
   - Diatur dengan `justify-content` (`flex-start`, `center`, `flex-end`, `space-between`, `space-evenly`).
2. **Sumbu Silang (Cross Axis)**: Sumbu tegak lurus terhadap sumbu utama.
   - Diatur dengan `align-items` (`stretch`, `center`, `flex-start`, `flex-end`).

### Properti Anak Flex (Flex Item):
- `flex: 1`: Memerintahkan item untuk tumbuh membesar dan menyerap seluruh sisa ruang kosong yang tersedia secara adil.
- `gap: 1.5rem`: Menetapkan jarak antar item tanpa perlu mengatur margin secara manual.', NULL, NULL, NULL, 0, 0, 0, 4, '2026-10-25 02:44:54', '2026-10-25 02:44:54');
INSERT INTO `course_stories` (`id`, `course_id`, `title`, `content`, `image_path`, `audio_path`, `video_url`, `use_image`, `use_audio`, `use_video`, `order`, `created_at`, `updated_at`) VALUES (11, 2, 'Bab 5: CSS Grid: Arsitektur Tata Letak Dua Dimensi Maju', 'Jika Flexbox berfokus pada satu arah baris atau kolom, CSS Grid adalah sistem layout dua dimensi yang mampu mengatur baris dan kolom secara bersamaan.

### Rumus Grid Galeri Responsif Tanpa Media Query:
```css
.dashboard-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 24px;
}
```
- `auto-fit`: Secara otomatis mengisi baris dengan jumlah kartu sebanyak mungkin yang muat.
- `minmax(300px, 1fr)`: Kartu tidak akan mengecil kurang dari 300px, dan akan melebar proporsional (1fr) jika layar bertambah luas.

### Penataan Area dengan `grid-template-areas`:
```css
.layout-wrapper {
    display: grid;
    grid-template-areas: 
        \"header header\"
        \"sidebar content\"
        \"footer footer\";
}
```', NULL, NULL, NULL, 0, 0, 0, 5, '2026-10-25 02:44:54', '2026-10-25 02:44:54');
INSERT INTO `course_stories` (`id`, `course_id`, `title`, `content`, `image_path`, `audio_path`, `video_url`, `use_image`, `use_audio`, `use_video`, `order`, `created_at`, `updated_at`) VALUES (12, 2, 'Bab 7: Micro-Interactions: Transisi Halus & Animasi Keyframes', 'Antarmuka yang statis terasa kaku. Menambahkan transisi mikro yang halus membuat aplikasi terasa hidup dan responsif terhadap sentuhan jari atau kursor pengguna.

### 1. Transisi CSS (CSS Transitions)
Digunakan saat elemen berganti status (misal: saat di-hover):
```css
.btn-action {
    background-color: #0284c7;
    transition: background-color 0.25s ease, transform 0.25s ease;
}

.btn-action:hover {
    background-color: #0ea5e9;
    transform: translateY(-2px);
}
```

### 2. Animasi Berulang (@keyframes Animation)
Untuk animasi otomatis berkelanjutan tanpa interaksi pengguna:
```css
@keyframes denyutPulse {
    0% { transform: scale(1); opacity: 1; }
    50% { transform: scale(1.08); opacity: 0.8; }
    100% { transform: scale(1); opacity: 1; }
}

.status-online {
    animation: denyutPulse 2s infinite ease-in-out;
}
```', NULL, NULL, NULL, 0, 0, 0, 7, '2026-10-25 02:44:54', '2026-10-25 02:44:54');
INSERT INTO `course_stories` (`id`, `course_id`, `title`, `content`, `image_path`, `audio_path`, `video_url`, `use_image`, `use_audio`, `use_video`, `order`, `created_at`, `updated_at`) VALUES (13, 3, 'Bab 1: Fondasi JavaScript ES6+: Variabel, Tipe Data & Operator', 'JavaScript adalah bahasa pemrograman yang memberikan kecerdasan dan interaktivitas pada halaman web.

### 1. Deklarasi Variabel Modern (`const` vs `let`)
- `const`: Untuk nilai konstan yang tidak akan di-reassign (contoh: konfigurasi, fungsi, array acuan).
- `let`: Untuk nilai yang akan diperbarui nilainya (contoh: counter perulangan).
- **Tinggalkan `var`** karena perilakunya yang tidak mematuhi batasan kurung kurawal (*block scope*) dan rentan bug.

### 2. Tipe Data Primitif:
- `String`: Teks (Gunakan Template Literals: `` `Halo ${nama}` ``).
- `Number`: Angka bulat maupun desimal (`42`, `3.14`).
- `Boolean`: Nilai logika kebenaran (`true` atau `false`).
- `Null` & `Undefined`: Ketiadaan nilai sengaja vs variabel yang belum diinisialisasi.

### 3. Operator Perbandingan Ketat (`===` vs `==`)
Selalu gunakan `===` (Strict Equality) untuk memeriksa nilai sekaligus tipe datanya. Hindari `==` yang melakukan konversi tipe secara implisit dan berbahaya.', NULL, NULL, NULL, 0, 0, 0, 1, '2026-10-25 02:44:54', '2026-10-25 02:44:54');
INSERT INTO `course_stories` (`id`, `course_id`, `title`, `content`, `image_path`, `audio_path`, `video_url`, `use_image`, `use_audio`, `use_video`, `order`, `created_at`, `updated_at`) VALUES (14, 3, 'Bab 2: Struktur Kontrol: Percabangan Logika & Perulangan Dinamis', 'Komputer mengambil keputusan berdasarkan kondisi logika tertentu.

### 1. Percabangan if - else if - else & Ternary Operator:
```javascript
const nilaiUjian = 85;

// Cara standar
if (nilaiUjian >= 80) {
    console.log(\'Lulus dengan Predikat A\');
} else {
    console.log(\'Perlu remedial\');
}

// Cara ringkas (Ternary Operator)
const status = (nilaiUjian >= 70) ? \'LULUS\' : \'REMEDIAL\';
```

### 2. Perulangan Modern `for...of`:
Untuk menelusuri isi array tanpa perlu pusing dengan index `i++`:
```javascript
const daftarBahasa = [\'HTML\', \'CSS\', \'JavaScript\'];
for (const bahasa of daftarBahasa) {
    console.log(\'Materi:\', bahasa);
}
```', NULL, NULL, NULL, 0, 0, 0, 2, '2026-10-25 02:44:54', '2026-10-25 02:44:54');
INSERT INTO `course_stories` (`id`, `course_id`, `title`, `content`, `image_path`, `audio_path`, `video_url`, `use_image`, `use_audio`, `use_video`, `order`, `created_at`, `updated_at`) VALUES (15, 3, 'Bab 3: Fungsi Modern (Arrow Functions), Parameter Default & Destructuring', 'Fungsi adalah blok kode terstruktur yang dapat dipanggil berulang kali.

### 1. Arrow Functions (Fungsi Panah):
```javascript
// Sintaks Ringkas dengan Return Implisit
const hitungDiskon = (harga, diskon = 0.1) => harga - (harga * diskon);

console.log(hitungDiskon(100000)); // 90000
```

### 2. Destructuring Assignment:
Memecah properti objek atau array langsung ke dalam variabel terpisah:
```javascript
const siswa = {
    nama: \'Reza\',
    kota: \'Bandung\',
    jurusan: \'Web Development\'
};

const { nama, jurusan } = siswa;
console.log(`${nama} mengambil jurusan ${jurusan}`);
```', NULL, NULL, NULL, 0, 0, 0, 3, '2026-10-25 02:44:54', '2026-10-25 02:44:54');
INSERT INTO `course_stories` (`id`, `course_id`, `title`, `content`, `image_path`, `audio_path`, `video_url`, `use_image`, `use_audio`, `use_video`, `order`, `created_at`, `updated_at`) VALUES (16, 3, 'Bab 4: Manipulasi Koleksi Data: map, filter, reduce & find', 'Metode array fungsional adalah senjata utama pengembang JavaScript modern:

### 1. `map()`: Mengubah setiap elemen menjadi bentuk baru:
```javascript
const angka = [1, 2, 3, 4];
const kuadrat = angka.map(n => n * n); // [1, 4, 9, 16]
```

### 2. `filter()`: Mengambil hanya elemen yang lolos seleksi:
```javascript
const produk = [
    { nama: \'Laptop\', harga: 8000000 },
    { nama: \'Mouse\', harga: 150000 },
    { nama: \'Keyboard\', harga: 450000 }
];
const barangMurah = produk.filter(p => p.harga < 500000);
```

### 3. `reduce()`: Menghitung total nilai gabungan:
```javascript
const totalHarga = produk.reduce((total, p) => total + p.harga, 0);
```', NULL, NULL, NULL, 0, 0, 0, 4, '2026-10-25 02:44:54', '2026-10-25 02:44:54');
INSERT INTO `course_stories` (`id`, `course_id`, `title`, `content`, `image_path`, `audio_path`, `video_url`, `use_image`, `use_audio`, `use_video`, `order`, `created_at`, `updated_at`) VALUES (17, 3, 'Bab 5: Interaktivitas DOM: Seleksi Elemen, Event Listener & State Visual', 'DOM (**Document Object Model**) adalah representasi pohon objek dari dokumen HTML yang memungkinkan JavaScript membaca dan memodifikasi halaman web secara langsung.

### 1. Memilih Elemen (`querySelector`)
```javascript
const tombol = document.querySelector(\'#btn-proses\');
const kotakPesan = document.querySelector(\'.alert-box\');
```

### 2. Mendengarkan Interaksi Pengguna (`addEventListener`)
```javascript
tombol.addEventListener(\'click\', (event) => {
    event.preventDefault();
    kotakPesan.classList.toggle(\'active\');
    kotakPesan.textContent = \'Permintaan Anda sedang diproses...\';
});
```

### 3. Memanipulasi Class CSS:
- `classList.add(\'aktif\')`: Menambahkan kelas tampilan.
- `classList.remove(\'aktif\')`: Menghapus kelas tampilan.
- `classList.toggle(\'aktif\')`: Beralih antara ada atau tiada.', NULL, NULL, NULL, 0, 0, 0, 5, '2026-10-25 02:44:54', '2026-10-25 02:44:54');
INSERT INTO `course_stories` (`id`, `course_id`, `title`, `content`, `image_path`, `audio_path`, `video_url`, `use_image`, `use_audio`, `use_video`, `order`, `created_at`, `updated_at`) VALUES (18, 3, 'Bab 7: Asynchronous JavaScript: Promise, Async/Await & Mengambil Data API', 'Dunia web bekerja secara dinamis dengan berkomunikasi ke server database backend.

### 1. Mengapa Perlu Asynchronous?
Operasi seperti mengambil data dari internet membutuhkan waktu jaringan beberapa milidetik hingga detik. Jika dieksekusi secara sinkronus biasa, seluruh halaman web akan membeku (*freeze*). Mekanisme Asynchronous memungkinkan browser tetap responsif selagi data diunduh di latar belakang.

### 2. Standar Modern: `async` dan `await`
```javascript
async function dapatkanKursusTerbaru() {
    try {
        const response = await fetch(\'/api/v1/courses\');
        if (!response.ok) {
            throw new Error(\'Jaringan mengalami gangguan\');
        }
        const data = await response.json();
        console.log(\'Kursus diterima:\', data);
        return data;
    } catch (error) {
        console.error(\'Gagal mengambil data:\', error.message);
    }
}
```
Dengan `try...catch`, penanganan galat (*error handling*) menjadi sangat jelas dan aman.', NULL, NULL, NULL, 0, 0, 0, 7, '2026-10-25 02:44:54', '2026-10-25 02:44:54');

-- -------------------------------------------------------------
-- Data untuk tabel `course_questions` (Total: 15 baris)
-- -------------------------------------------------------------
DELETE FROM `course_questions`;
INSERT INTO `course_questions` (`id`, `course_id`, `question_type`, `title`, `content`, `options`, `correct_answer`, `admin_code`, `starter_code`, `expected_output`, `coding_rules`, `test_cases`, `hint`, `language`, `order`, `created_at`, `updated_at`) VALUES (1, 1, 'question', 'Aturan Penggunaan Tag Heading Utama (h1)', 'Berdasarkan standar praktik terbaik Search Engine Optimization (SEO) dan struktur dokumen semantik HTML5, berapakah jumlah tag `<h1>` yang direkomendasikan berada di dalam satu halaman web tunggal?', '[\"Bebas sesuai kebutuhan desain visual\", \"Tepat SATU tag <h1> per halaman\", \"Minimal 5 tag agar artikel mudah ditemukan Google\", \"Tidak boleh menggunakan <h1> sama sekali jika sudah ada title\"]', 'Tepat SATU tag <h1> per halaman', NULL, NULL, NULL, NULL, NULL, 'Hanya ada satu topik/judul utama per halaman.', 'go', 8, '2026-10-25 02:44:54', '2026-10-25 02:44:54');
INSERT INTO `course_questions` (`id`, `course_id`, `question_type`, `title`, `content`, `options`, `correct_answer`, `admin_code`, `starter_code`, `expected_output`, `coding_rules`, `test_cases`, `hint`, `language`, `order`, `created_at`, `updated_at`) VALUES (2, 1, 'question', 'Atribut Wajib pada Tag Gambar <img>', 'Manakah atribut pada tag `<img>` yang bertugas memberikan teks deskriptif alternatif ketika gambar gagal dimuat atau saat dibaca oleh software pembaca layar (screen reader) penyandang disabilitas?', '[\"title\", \"desc\", \"alt\", \"src\"]', 'alt', NULL, NULL, NULL, NULL, NULL, 'Singkatan dari alternative text.', 'go', 9, '2026-10-25 02:44:54', '2026-10-25 02:44:54');
INSERT INTO `course_questions` (`id`, `course_id`, `question_type`, `title`, `content`, `options`, `correct_answer`, `admin_code`, `starter_code`, `expected_output`, `coding_rules`, `test_cases`, `hint`, `language`, `order`, `created_at`, `updated_at`) VALUES (3, 1, 'question', 'Tag Semantik untuk Konten Mandiri Independen', 'Elemen semantik HTML5 manakah yang paling ideal digunakan untuk membungkus sebuah konten mandiri yang dapat didistribusikan ulang atau berdiri sendiri secara utuh, seperti sebuah postingan artikel blog, berita, atau komentar pembaca?', '[\"<section>\", \"<article>\", \"<aside>\", \"<div>\"]', '<article>', NULL, NULL, NULL, NULL, NULL, 'Bermakna artikel dalam bahasa Inggris.', 'go', 10, '2026-10-25 02:44:54', '2026-10-25 02:44:54');
INSERT INTO `course_questions` (`id`, `course_id`, `question_type`, `title`, `content`, `options`, `correct_answer`, `admin_code`, `starter_code`, `expected_output`, `coding_rules`, `test_cases`, `hint`, `language`, `order`, `created_at`, `updated_at`) VALUES (4, 1, 'question', 'Atribut Keamanan Tautan Tab Baru', 'Ketika membuat tautan eksternal yang membuka tab peramban baru menggunakan `target=\"_blank\"`, pasangan atribut keamanan manakah yang wajib disertakan untuk mencegah celah keamanan tab-nabbing (*window.opener vulnerability*)?', '[\"security=\\\\\\\"safe\\\\\\\"\", \"rel=\\\\\\\"noopener noreferrer\\\\\\\"\", \"sandbox=\\\\\\\"secure\\\\\\\"\", \"mode=\\\\\\\"protected\\\\\\\"\"]', 'rel=\\\"noopener noreferrer\\\"', NULL, NULL, NULL, NULL, NULL, 'Menggunakan atribut rel yang memblokir referer dan opener.', 'go', 11, '2026-10-25 02:44:54', '2026-10-25 02:44:54');
INSERT INTO `course_questions` (`id`, `course_id`, `question_type`, `title`, `content`, `options`, `correct_answer`, `admin_code`, `starter_code`, `expected_output`, `coding_rules`, `test_cases`, `hint`, `language`, `order`, `created_at`, `updated_at`) VALUES (5, 1, 'coding', 'Tantangan Coding: Generator Tag Meta Deskripsi SEO', 'Dalam sistem CMS, admin sering memasukkan deskripsi artikel yang kemudian harus diubah menjadi tag meta HTML: `<meta name=\"description\" content=\"...\">`.

### Instruksi:
Buatlah program JavaScript yang membaca teks satu baris deskripsi, lalu cetak teks tersebut dalam format tag meta HTML lengkap tanpa spasi berlebih.

Contoh Input:
`Belajar HTML5 dari dasar sampai mahir bersama TalentGroup`

Contoh Output:
`<meta name=\"description\" content=\"Belajar HTML5 dari dasar sampai mahir bersama TalentGroup\">`', NULL, NULL, NULL, 'const readline = require(\'readline\');
const rl = readline.createInterface({ input: process.stdin, output: process.stdout });

rl.on(\'line\', (line) => {
    const text = line.trim();
    console.log(\'<meta name=\"description\" content=\"\' + text + \'\">\');
    process.exit(0);
});', '<meta name=\\\"description\\\" content=\\\"Belajar HTML5 dari dasar sampai mahir bersama TalentGroup\\\">', '[\"console_log\"]', '[{\"input\": \"Belajar HTML5 dari dasar sampai mahir bersama TalentGroup\", \"expected_output\": \"<meta name=\\\\\\\"description\\\\\\\" content=\\\\\\\"Belajar HTML5 dari dasar sampai mahir bersama TalentGroup\\\\\\\">\"}, {\"input\": \"Panduan Form Web & Aksesibilitas Modern\", \"expected_output\": \"<meta name=\\\\\\\"description\\\\\\\" content=\\\\\\\"Panduan Form Web & Aksesibilitas Modern\\\\\\\">\"}]', 'Bungkus teks input di dalam tanda petik atribut content.', 'javascript', 12, '2026-10-25 02:44:54', '2026-10-25 02:44:54');
INSERT INTO `course_questions` (`id`, `course_id`, `question_type`, `title`, `content`, `options`, `correct_answer`, `admin_code`, `starter_code`, `expected_output`, `coding_rules`, `test_cases`, `hint`, `language`, `order`, `created_at`, `updated_at`) VALUES (6, 2, 'question', 'Selektor dengan Specificity Tertinggi', 'Dari daftar selektor CSS berikut, manakah yang memiliki bobot nilai Specificity (prioritas penimpaan gaya) paling tinggi dalam menentukan tampilan elemen?', '[\"Elemen tag standar seperti h1 atau p (1 poin)\", \"Nama Class seperti .btn-primary (10 poin)\", \"Identifier unik ID seperti #main-navbar (100 poin)\", \"Pseudo-class seperti :hover atau :active (10 poin)\"]', 'Identifier unik ID seperti #main-navbar (100 poin)', NULL, NULL, NULL, NULL, NULL, 'ID Selector memiliki bobot 100 poin.', 'go', 8, '2026-10-25 02:44:54', '2026-10-25 02:44:54');
INSERT INTO `course_questions` (`id`, `course_id`, `question_type`, `title`, `content`, `options`, `correct_answer`, `admin_code`, `starter_code`, `expected_output`, `coding_rules`, `test_cases`, `hint`, `language`, `order`, `created_at`, `updated_at`) VALUES (7, 2, 'question', 'Properti Distribusi Ruang Flexbox', 'Nilai properti `justify-content` manakah yang mendistribusikan item pertama persis menempel di tepi kiri dan item terakhir persis menempel di tepi kanan, sementara sisa ruang dibagi rata di antara item-item tengah?', '[\"space-evenly\", \"space-around\", \"space-between\", \"center\"]', 'space-between', NULL, NULL, NULL, NULL, NULL, 'Berarti ruang di antara item (antara tepi ke tepi).', 'go', 9, '2026-10-25 02:44:54', '2026-10-25 02:44:54');
INSERT INTO `course_questions` (`id`, `course_id`, `question_type`, `title`, `content`, `options`, `correct_answer`, `admin_code`, `starter_code`, `expected_output`, `coding_rules`, `test_cases`, `hint`, `language`, `order`, `created_at`, `updated_at`) VALUES (8, 2, 'question', 'Fungsi auto-fit pada CSS Grid', 'Apakah keunggulan utama dari penggunaan nilai `auto-fit` dalam deklarasi `grid-template-columns: repeat(auto-fit, minmax(250px, 1fr))`?', '[\"Menyembunyikan kartu jika resolusi layar berada di bawah 600px\", \"Memperluas dan menyesuaikan kolom yang ada secara otomatis mengisi seluruh ruang kosong layar tanpa media query\", \"Memutar orientasi layout dari horizontal menjadi vertikal secara acak\", \"Mengunci ukuran setiap elemen agar tidak pernah berubah sama sekali\"]', 'Memperluas dan menyesuaikan kolom yang ada secara otomatis mengisi seluruh ruang kosong layar tanpa media query', NULL, NULL, NULL, NULL, NULL, 'Menjadikan layout responsif otomatis mengisi layar.', 'go', 10, '2026-10-25 02:44:54', '2026-10-25 02:44:54');
INSERT INTO `course_questions` (`id`, `course_id`, `question_type`, `title`, `content`, `options`, `correct_answer`, `admin_code`, `starter_code`, `expected_output`, `coding_rules`, `test_cases`, `hint`, `language`, `order`, `created_at`, `updated_at`) VALUES (9, 2, 'coding', 'Tantangan Coding: Hitung Dimensi Total Elemen (Content-Box)', 'Pada mode default `box-sizing: content-box`, total lebar elemen dihitung dengan rumus:
`Total Width = Width + (PaddingLeft + PaddingRight) + (BorderLeft + BorderRight)`

### Instruksi:
Buatlah program JavaScript yang membaca 3 input angka dalam 1 baris yang dipisahkan spasi berturut-turut:
1. Width konten (px)
2. Padding horizontal per sisi (px)
3. Border horizontal per sisi (px)

Hitung total lebar elemen dan cetak angkanya!

Contoh Input:
`200 20 2`
*(Artinya Width 200, Padding kiri 20, Padding kanan 20, Border kiri 2, Border kanan 2)*

Kalkulasi: `200 + (20 * 2) + (2 * 2) = 244`

Contoh Output:
`244`', NULL, NULL, NULL, 'const readline = require(\'readline\');
const rl = readline.createInterface({ input: process.stdin, output: process.stdout });

rl.on(\'line\', (line) => {
    const [width, padding, border] = line.trim().split(/\\s+/).map(Number);
    const totalWidth = width + (padding * 2) + (border * 2);
    console.log(totalWidth);
    process.exit(0);
});', 244, '[\"console_log\"]', '[{\"input\": \"200 20 2\", \"expected_output\": \"244\"}, {\"input\": \"300 15 5\", \"expected_output\": \"340\"}]', 'Kalikan padding dan border dengan 2, lalu tambahkan ke nilai width.', 'javascript', 11, '2026-10-25 02:44:54', '2026-10-25 02:44:54');
INSERT INTO `course_questions` (`id`, `course_id`, `question_type`, `title`, `content`, `options`, `correct_answer`, `admin_code`, `starter_code`, `expected_output`, `coding_rules`, `test_cases`, `hint`, `language`, `order`, `created_at`, `updated_at`) VALUES (10, 3, 'question', 'Perbedaan Sifat Antara let dan const', 'Dalam penulisan kode JavaScript standar ES6+, apakah perbedaan mendasar dalam hal penetapan ulang nilai antara variabel `let` dan `const`?', '[\"Variabel const dapat di-reassign berkali-kali, sedangkan let nilainya permanen\", \"Variabel let dapat di-reassign nilainya, sedangkan const referensinya permanen dan tidak dapat di-reassign\", \"Keduanya sama persis dan hanya perbedaan gaya penulisan sintaks\", \"Variabel const hanya dapat menyimpan nilai berupa angka desimal\"]', 'Variabel let dapat di-reassign nilainya, sedangkan const referensinya permanen dan tidak dapat di-reassign', NULL, NULL, NULL, NULL, NULL, 'let untuk nilai yang berubah-ubah, const untuk nilai yang konstan.', 'go', 8, '2026-10-25 02:44:54', '2026-10-25 02:44:54');
INSERT INTO `course_questions` (`id`, `course_id`, `question_type`, `title`, `content`, `options`, `correct_answer`, `admin_code`, `starter_code`, `expected_output`, `coding_rules`, `test_cases`, `hint`, `language`, `order`, `created_at`, `updated_at`) VALUES (11, 3, 'question', 'Metode Array untuk Akumulasi Total Nilai', 'Metode array JavaScript manakah yang paling tepat digunakan untuk mengolah deretan nilai objek (misalnya daftar harga barang belanjaan) menjadi satu nilai akumulasi tunggal berupa grand total biaya?', '[\"Array.map()\", \"Array.reduce()\", \"Array.filter()\", \"Array.some()\"]', 'Array.reduce()', NULL, NULL, NULL, NULL, NULL, 'Berasal dari kata reduce (mengurangi/meringkas kumpulan nilai menjadi satu).', 'go', 9, '2026-10-25 02:44:54', '2026-10-25 02:44:54');
INSERT INTO `course_questions` (`id`, `course_id`, `question_type`, `title`, `content`, `options`, `correct_answer`, `admin_code`, `starter_code`, `expected_output`, `coding_rules`, `test_cases`, `hint`, `language`, `order`, `created_at`, `updated_at`) VALUES (12, 3, 'question', 'Metode Menambah/Menghapus Class CSS secara Toggle', 'Method pada properti `classList` elemen DOM manakah yang secara cerdas akan menambahkan class CSS jika belum ada, atau menghapusnya jika class tersebut sudah ada pada elemen?', '[\"classList.switch()\", \"classList.toggle()\", \"classList.replace()\", \"classList.invert()\"]', 'classList.toggle()', NULL, NULL, NULL, NULL, NULL, 'Seperti saklar lampu bolak-balik (toggle).', 'go', 10, '2026-10-25 02:44:54', '2026-10-25 02:44:54');
INSERT INTO `course_questions` (`id`, `course_id`, `question_type`, `title`, `content`, `options`, `correct_answer`, `admin_code`, `starter_code`, `expected_output`, `coding_rules`, `test_cases`, `hint`, `language`, `order`, `created_at`, `updated_at`) VALUES (13, 3, 'question', 'Fungsi Method response.json() pada Fetch API', 'Pada saat kita memanggil data server menggunakan `fetch()`, mengapa kita perlu memanggil perintah `await response.json()`?', '[\"Untuk mengompres file HTML menjadi format zip\", \"Untuk mengonversi aliran data respons HTTP (stream) menjadi objek JavaScript yang dapat diakses\", \"Untuk menghapus cache memori lokal browser pengguna\", \"Untuk menutup koneksi internet setelah data terkirim\"]', 'Untuk mengonversi aliran data respons HTTP (stream) menjadi objek JavaScript yang dapat diakses', NULL, NULL, NULL, NULL, NULL, 'Parsing teks format JSON menjadi Objek/Array JavaScript.', 'go', 11, '2026-10-25 02:44:54', '2026-10-25 02:44:54');
INSERT INTO `course_questions` (`id`, `course_id`, `question_type`, `title`, `content`, `options`, `correct_answer`, `admin_code`, `starter_code`, `expected_output`, `coding_rules`, `test_cases`, `hint`, `language`, `order`, `created_at`, `updated_at`) VALUES (14, 3, 'coding', 'Tantangan Coding: Kalkulator Diskon Belanja Pelanggan', 'Sebuah toko online memberikan aturan promo otomatis bagi pelanggan:
- Jika total belanja lebih besar dari atau sama dengan Rp 100.000, pelanggan berhak mendapatkan diskon sebesar 10%.
- Jika di bawah Rp 100.000, pelanggan membayar harga normal tanpa diskon.

### Instruksi:
Buatlah program JavaScript yang membaca 1 baris input angka total belanja (integer/float), lalu hitung dan cetak harga akhir yang harus dibayarkan pelanggan dalam format angka bulat (Math.round).

Contoh Input:
`150000`

Kalkulasi: `150000 - (150000 * 0.10) = 135000`

Contoh Output:
`135000`', NULL, NULL, NULL, 'const readline = require(\'readline\');
const rl = readline.createInterface({ input: process.stdin, output: process.stdout });

rl.on(\'line\', (line) => {
    const total = parseFloat(line.trim());
    let finalPrice = total;
    
    if (total >= 100000) {
        finalPrice = total - (total * 0.10);
    }
    
    console.log(Math.round(finalPrice));
    process.exit(0);
});', 135000, '[\"console_log\", \"if_statement\"]', '[{\"input\": \"150000\", \"expected_output\": \"135000\"}, {\"input\": \"80000\", \"expected_output\": \"80000\"}, {\"input\": \"200000\", \"expected_output\": \"180000\"}]', 'Gunakan percabangan if (total >= 100000) dan hitung potongannya.', 'javascript', 12, '2026-10-25 02:44:54', '2026-10-25 02:44:54');
INSERT INTO `course_questions` (`id`, `course_id`, `question_type`, `title`, `content`, `options`, `correct_answer`, `admin_code`, `starter_code`, `expected_output`, `coding_rules`, `test_cases`, `hint`, `language`, `order`, `created_at`, `updated_at`) VALUES (15, 3, 'coding', 'Tantangan Coding: Filter Angka Genap Array', 'Buatlah program JavaScript yang membaca deretan angka yang dipisahkan dengan spasi, lalu cetak hanya angka yang bernilai genap saja, dipisahkan oleh spasi.

Contoh Input:
`1 2 3 4 5 6 7 8`

Contoh Output:
`2 4 6 8`', NULL, NULL, NULL, 'const readline = require(\'readline\');
const rl = readline.createInterface({ input: process.stdin, output: process.stdout });

rl.on(\'line\', (line) => {
    const numbers = line.trim().split(/\\s+/).map(Number);
    const evens = numbers.filter(n => n % 2 === 0);
    console.log(evens.join(\' \'));
    process.exit(0);
});', '2 4 6 8', '[\"console_log\", \"filter_map\"]', '[{\"input\": \"1 2 3 4 5 6 7 8\", \"expected_output\": \"2 4 6 8\"}, {\"input\": \"10 15 20 25 30\", \"expected_output\": \"10 20 30\"}]', 'Gunakan .filter(n => n % 2 === 0) dan gabungkan dengan .join(\" \")', 'javascript', 13, '2026-10-25 02:44:54', '2026-10-25 02:44:54');

-- -------------------------------------------------------------
-- Data untuk tabel `course_htmls` (Total: 3 baris)
-- -------------------------------------------------------------
DELETE FROM `course_htmls`;
INSERT INTO `course_htmls` (`id`, `course_id`, `title`, `content`, `html_code`, `css_code`, `js_code`, `order`, `created_at`, `updated_at`) VALUES (1, 1, 'Live Demo: Formulir Pendaftaran Kursus Interaktif', 'Simulasi interaktif halaman formulir pendaftaran siswa dengan seluruh validasi HTML5 bawaan, styling kartu modern, dan pesan feedback instan.', '<div class=\"form-container\">
    <div class=\"form-header\">
        <span class=\"badge\">REGISTRASI PESERTA</span>
        <h2>Formulir Gabung TalentGroup</h2>
        <p>Isi informasi identitas diri Anda untuk memulai kursus bersertifikasi.</p>
    </div>

    <form class=\"student-form\" onsubmit=\"event.preventDefault(); document.getElementById(\'alertSuccess\').style.display=\'block\';\">
        <div class=\"form-group\">
            <label for=\"txtName\">Nama Lengkap <span class=\"req\">*</span></label>
            <input type=\"text\" id=\"txtName\" required minlength=\"3\" placeholder=\"Masukkan nama resmi sesuai ijazah\" class=\"form-input\">
        </div>

        <div class=\"form-group\">
            <label for=\"txtEmail\">Alamat Email <span class=\"req\">*</span></label>
            <input type=\"email\" id=\"txtEmail\" required placeholder=\"alamat.anda@email.com\" class=\"form-input\">
        </div>

        <div class=\"form-row\">
            <div class=\"form-group half\">
                <label for=\"txtTrack\">Jalur Pelatihan <span class=\"req\">*</span></label>
                <select id=\"txtTrack\" required class=\"form-input\">
                    <option value=\"\">Pilih Jalur</option>
                    <option value=\"html\">HTML5 & Web Semantik</option>
                    <option value=\"css\">CSS3 & Desain UI/UX</option>
                    <option value=\"js\">JavaScript Modern ES6+</option>
                </select>
            </div>
            <div class=\"form-group half\">
                <label for=\"txtLevel\">Level Pengalaman</label>
                <select id=\"txtLevel\" class=\"form-input\">
                    <option value=\"beginner\">Pemula (Belum Pernah Coding)</option>
                    <option value=\"intermediate\">Menengah (Pernah Belajar Dasar)</option>
                </select>
            </div>
        </div>

        <button type=\"submit\" class=\"submit-btn\">Kirim & Konfirmasi Pendaftaran</button>

        <div id=\"alertSuccess\" class=\"alert-success\" style=\"display: none;\">
            ✔ Formulir Berhasil Dikirim! Data Anda telah terverifikasi oleh sistem.
        </div>
    </form>
</div>', '.form-container { max-width: 540px; margin: 30px auto; background: #0c1427; border: 1px solid #1e293b; border-radius: 20px; padding: 32px; color: #fff; font-family: -apple-system, BlinkMacSystemFont, \"Segoe UI\", Roboto, sans-serif; box-shadow: 0 20px 45px rgba(0,0,0,0.6); }
.badge { display: inline-block; background: rgba(56, 189, 248, 0.1); color: #38bdf8; border: 1px solid rgba(56, 189, 248, 0.3); font-size: 10px; font-weight: 800; padding: 4px 12px; border-radius: 20px; margin-bottom: 12px; letter-spacing: 1px; }
.form-header h2 { font-size: 22px; font-weight: 800; margin: 0 0 6px 0; color: #fff; }
.form-header p { font-size: 12px; color: #94a3b8; margin: 0 0 24px 0; line-height: 1.5; }
.student-form { display: flex; flex-direction: column; gap: 18px; }
.form-group { display: flex; flex-direction: column; gap: 6px; }
.form-row { display: flex; gap: 14px; }
.form-group.half { flex: 1; }
label { font-size: 12px; font-weight: 700; color: #cbd5e1; }
.req { color: #ef4444; }
.form-input { background: #030712; border: 1px solid #334155; border-radius: 10px; padding: 12px 14px; color: #fff; font-size: 13px; outline: none; transition: border-color 0.2s; }
.form-input:focus { border-color: #38bdf8; box-shadow: 0 0 0 3px rgba(56, 189, 248, 0.15); }
.submit-btn { margin-top: 8px; background: linear-gradient(135deg, #0284c7, #0369a1); color: #fff; border: none; border-radius: 10px; padding: 13px; font-weight: 800; font-size: 13px; cursor: pointer; transition: all 0.2s; }
.submit-btn:hover { background: linear-gradient(135deg, #0ea5e9, #0284c7); box-shadow: 0 6px 20px rgba(14, 165, 233, 0.3); }
.alert-success { background: rgba(16, 185, 129, 0.15); border: 1px solid #10b981; color: #34d399; padding: 12px; border-radius: 10px; font-size: 12px; font-weight: 700; text-align: center; margin-top: 10px; }', 'console.log(\"HTML5 Form Validator Active\");', 6, '2026-10-25 02:44:54', '2026-10-25 02:44:54');
INSERT INTO `course_htmls` (`id`, `course_id`, `title`, `content`, `html_code`, `css_code`, `js_code`, `order`, `created_at`, `updated_at`) VALUES (2, 2, 'Live Demo: Grid Dashboard & Efek Glassmorphism', 'Eksplorasi antarmuka dashboard dengan CSS Grid responsif, efek latar belakang buram (Glassmorphism), dan indikator metrik yang dinamis.', '<div class=\"stats-grid\">
    <div class=\"stat-card\">
        <div class=\"stat-icon icon-blue\">👥</div>
        <div class=\"stat-info\">
            <span class=\"stat-label\">Total Pengguna Aktif</span>
            <span class=\"stat-value\">12.450</span>
            <span class=\"stat-badge badge-up\">▲ +14% bulan ini</span>
        </div>
    </div>

    <div class=\"stat-card\">
        <div class=\"stat-icon icon-green\">🎓</div>
        <div class=\"stat-info\">
            <span class=\"stat-label\">Kelulusan Kursus</span>
            <span class=\"stat-value\">98.2%</span>
            <span class=\"stat-badge badge-up\">▲ Sangat Optimal</span>
        </div>
    </div>

    <div class=\"stat-card\">
        <div class=\"stat-icon icon-amber\">⭐</div>
        <div class=\"stat-info\">
            <span class=\"stat-label\">Rating Rata-Rata</span>
            <span class=\"stat-value\">4.9 / 5.0</span>
            <span class=\"stat-badge badge-star\">★ 2.100 Ulasan</span>
        </div>
    </div>
</div>', '.stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 20px; max-width: 900px; margin: 30px auto; padding: 15px; font-family: -apple-system, BlinkMacSystemFont, \"Segoe UI\", Roboto, sans-serif; }
.stat-card { background: rgba(15, 23, 42, 0.75); backdrop-filter: blur(12px); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 18px; padding: 22px; display: flex; align-items: center; gap: 18px; box-shadow: 0 15px 35px rgba(0,0,0,0.4); transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1), border-color 0.3s; }
.stat-card:hover { transform: translateY(-5px); border-color: rgba(56, 189, 248, 0.4); box-shadow: 0 20px 40px rgba(56, 189, 248, 0.1); }
.stat-icon { width: 52px; height: 52px; border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 24px; flex-shrink: 0; }
.icon-blue { background: rgba(56, 189, 248, 0.15); border: 1px solid rgba(56, 189, 248, 0.3); }
.icon-green { background: rgba(16, 185, 129, 0.15); border: 1px solid rgba(16, 185, 129, 0.3); }
.icon-amber { background: rgba(245, 158, 11, 0.15); border: 1px solid rgba(245, 158, 11, 0.3); }
.stat-info { display: flex; flex-direction: column; gap: 4px; }
.stat-label { font-size: 11px; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.5px; }
.stat-value { font-size: 24px; font-weight: 900; color: #fff; letter-spacing: -0.5px; }
.stat-badge { font-size: 10px; font-weight: 800; padding: 2px 8px; border-radius: 6px; width: fit-content; margin-top: 2px; }
.badge-up { background: rgba(16, 185, 129, 0.12); color: #34d399; }
.badge-star { background: rgba(245, 158, 11, 0.12); color: #fbbf24; }', 'console.log(\"CSS Dashboard Grid Loaded\");', 6, '2026-10-25 02:44:54', '2026-10-25 02:44:54');
INSERT INTO `course_htmls` (`id`, `course_id`, `title`, `content`, `html_code`, `css_code`, `js_code`, `order`, `created_at`, `updated_at`) VALUES (3, 3, 'Live Demo: Aplikasi Mini Catatan Tugas (Todo List) Dinamis', 'Simulasi aplikasi catatan tugas (Todo List) lengkap dengan penambahan item instan, pencoretan tugas selesai, dan kalkulasi otomatis jumlah tugas.', '<div class=\"todo-app\">
    <div class=\"todo-header\">
        <span class=\"badge\">DOM MANIPULATION APP</span>
        <h2>Daftar Target Harian</h2>
        <p>Tambahkan dan selesaikan target belajar coding harian Anda.</p>
    </div>

    <div class=\"input-row\">
        <input type=\"text\" id=\"todoInput\" placeholder=\"Ketik tugas baru (contoh: Belajar Flexbox)...\" class=\"todo-input\">
        <button id=\"addBtn\" class=\"btn-add\" onclick=\"tambahTugas()\">+ Tambah</button>
    </div>

    <ul id=\"todoList\" class=\"todo-items\">
        <li class=\"todo-item done\" onclick=\"toggleTugas(this)\">
            <span class=\"check-box\">✔</span>
            <span class=\"todo-text\">Selesaikan Modul HTML5 Semantik</span>
        </li>
        <li class=\"todo-item\" onclick=\"toggleTugas(this)\">
            <span class=\"check-box\"></span>
            <span class=\"todo-text\">Latihan Membuat Flexbox Navigation</span>
        </li>
    </ul>

    <div class=\"todo-footer\">
        <span id=\"taskCounter\">Total 2 tugas tercatat</span>
        <button class=\"btn-clear\" onclick=\"hapusSelesai()\">Bersihkan yang Selesai</button>
    </div>
</div>', '.todo-app { max-width: 480px; margin: 30px auto; background: #0b132b; border: 1px solid #1e293b; border-radius: 20px; padding: 28px; color: #fff; font-family: -apple-system, BlinkMacSystemFont, \"Segoe UI\", Roboto, sans-serif; box-shadow: 0 20px 40px rgba(0,0,0,0.5); }
.badge { display: inline-block; background: rgba(250, 204, 21, 0.1); color: #facc15; border: 1px solid rgba(250, 204, 21, 0.3); font-size: 10px; font-weight: 800; padding: 4px 10px; border-radius: 12px; margin-bottom: 8px; }
.todo-header h2 { font-size: 20px; font-weight: 800; margin: 0 0 6px 0; color: #fff; }
.todo-header p { font-size: 12px; color: #94a3b8; margin: 0 0 20px 0; }
.input-row { display: flex; gap: 8px; margin-bottom: 20px; }
.todo-input { flex: 1; background: #030712; border: 1px solid #334155; border-radius: 10px; padding: 12px 14px; color: #fff; font-size: 13px; outline: none; }
.todo-input:focus { border-color: #facc15; }
.btn-add { background: #facc15; color: #000; font-weight: 800; border: none; border-radius: 10px; padding: 0 18px; cursor: pointer; transition: opacity 0.2s; font-size: 13px; }
.btn-add:hover { opacity: 0.9; }
.todo-items { list-style: none; padding: 0; margin: 0 0 20px 0; display: flex; flex-direction: column; gap: 8px; max-height: 240px; overflow-y: auto; }
.todo-item { display: flex; align-items: center; gap: 12px; background: #1e293b; padding: 12px 16px; border-radius: 10px; cursor: pointer; transition: all 0.2s; user-select: none; }
.todo-item:hover { background: #334155; }
.check-box { width: 20px; height: 20px; border: 2px solid #64748b; border-radius: 6px; display: flex; align-items: center; justify-content: center; font-size: 12px; color: transparent; flex-shrink: 0; }
.todo-item.done .check-box { border-color: #10b981; background: #10b981; color: #000; }
.todo-item.done .todo-text { text-decoration: line-through; color: #64748b; }
.todo-footer { display: flex; justify-content: space-between; align-items: center; border-top: 1px solid #1e293b; padding-top: 14px; font-size: 11px; color: #94a3b8; }
.btn-clear { background: transparent; border: none; color: #ef4444; font-weight: 700; cursor: pointer; font-size: 11px; }
.btn-clear:hover { text-decoration: underline; }', 'function tambahTugas() {
    const input = document.getElementById(\"todoInput\");
    const list = document.getElementById(\"todoList\");
    if(!input || !input.value.trim()) return;

    const li = document.createElement(\"li\");
    li.className = \"todo-item\";
    li.onclick = function() { toggleTugas(this); };
    li.innerHTML = \"<span class=\\\"check-box\\\"></span><span class=\\\"todo-text\\\">\" + input.value.trim() + \"</span>\";
    list.appendChild(li);
    input.value = \"\";
    updateCount();
}

function toggleTugas(el) {
    el.classList.toggle(\"done\");
    const check = el.querySelector(\".check-box\");
    if(check) {
        check.innerText = el.classList.contains(\"done\") ? \"✔\" : \"\";
    }
}

function hapusSelesai() {
    const dones = document.querySelectorAll(\".todo-item.done\");
    dones.forEach(item => item.remove());
    updateCount();
}

function updateCount() {
    const count = document.querySelectorAll(\".todo-item\").length;
    const el = document.getElementById(\"taskCounter\");
    if(el) el.innerText = \"Total \" + count + \" tugas tercatat\";
}', 6, '2026-10-25 02:44:54', '2026-10-25 02:44:54');

-- -------------------------------------------------------------
-- Data untuk tabel `module_categories` (Total: 3 baris)
-- -------------------------------------------------------------
DELETE FROM `module_categories`;
INSERT INTO `module_categories` (`id`, `name`, `slug`, `description`, `is_public`, `referral_code`, `image`, `icon`, `color`, `badge`, `order`, `is_active`, `enable_anti_screenshot`, `enable_anti_copy`, `created_at`, `updated_at`) VALUES (1, 'Modul Dokumentasi HTML5 Komprehensif', 'modul-html5-komprehensif', 'Buku saku dan panduan lengkap referensi standar HTML5 semantik, optimasi SEO, pembuatan formulir interaktif, tabel data, serta integrasi multimedia.', 1, NULL, NULL, 'fab fa-html5', '#f97316', 'Fondasi Web', 1, 1, 1, 1, '2026-10-25 02:44:54', '2026-10-25 02:44:54');
INSERT INTO `module_categories` (`id`, `name`, `slug`, `description`, `is_public`, `referral_code`, `image`, `icon`, `color`, `badge`, `order`, `is_active`, `enable_anti_screenshot`, `enable_anti_copy`, `created_at`, `updated_at`) VALUES (2, 'Modul Dokumentasi CSS3 & Tata Letak Modern', 'modul-css3-dan-layout-modern', 'Panduan komprehensif penataan antarmuka web modern dengan Universal Box Model, Flexbox satu dimensi, CSS Grid dua dimensi, tipografi cairan, dan animasi mikro.', 1, NULL, NULL, 'fab fa-css3-alt', '#38bdf8', 'Desain Web', 2, 1, 1, 1, '2026-10-25 02:44:54', '2026-10-25 02:44:54');
INSERT INTO `module_categories` (`id`, `name`, `slug`, `description`, `is_public`, `referral_code`, `image`, `icon`, `color`, `badge`, `order`, `is_active`, `enable_anti_screenshot`, `enable_anti_copy`, `created_at`, `updated_at`) VALUES (3, 'Modul Dokumentasi JavaScript ES6+ & DOM', 'modul-javascript-es6-dan-dom', 'Buku panduan lengkap logika pemrograman web modern, manipulasi pohon elemen DOM, pengolahan array fungsional (map, filter, reduce), dan integrasi Asynchronous Fetch API.', 1, NULL, NULL, 'fab fa-js-square', '#facc15', 'Logika Web', 3, 1, 1, 1, '2026-10-25 02:44:54', '2026-10-25 02:44:54');

-- -------------------------------------------------------------
-- Data untuk tabel `modules` (Total: 12 baris)
-- -------------------------------------------------------------
DELETE FROM `modules`;
INSERT INTO `modules` (`id`, `category_id`, `section`, `title`, `slug`, `content_type`, `excerpt`, `content`, `file_path`, `file_name`, `file_size`, `order`, `is_published`, `is_public`, `referral_code`, `enable_protection`, `enable_anti_screenshot`, `enable_anti_copy`, `views_count`, `created_at`, `updated_at`) VALUES (1, 1, '1. FONDASI & ANATOMI', 'Anatomi Dokumen HTML5 & Metadata Head', 'anatomi-dokumen-html5-dan-metadata', 'document', 'Mengenal struktur doctype, elemen root, meta viewport, charset, dan penataan body.', '# Anatomi Dokumen HTML5 & Metadata Head

Setiap halaman web modern berstandar W3C dibangun dengan pondasi dasar berikut:

```html:index.html
<!DOCTYPE html>
<html lang=\"id\">
<head>
    <meta charset=\"UTF-8\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
    <meta name=\"description\" content=\"Panduan belajar web development terlengkap di TalentGroup\">
    <title>Dokumentasi HTML5 Standar</title>
</head>
<body>
    <header>
        <h1>Portal Pembelajaran HTML5</h1>
    </header>
    <main>
        <p>Konten utama aplikasi berada di sini.</p>
    </main>
</body>
</html>
```

> [!NOTE]
> Tag `<meta name=\"viewport\">` merupakan keharusan mutlak agar layout website menyesuaikan skala layar ponsel secara proporsional.', NULL, NULL, NULL, 1, 1, 1, NULL, 1, 1, 1, 0, '2026-10-25 02:44:54', '2026-10-25 02:44:54');
INSERT INTO `modules` (`id`, `category_id`, `section`, `title`, `slug`, `content_type`, `excerpt`, `content`, `file_path`, `file_name`, `file_size`, `order`, `is_published`, `is_public`, `referral_code`, `enable_protection`, `enable_anti_screenshot`, `enable_anti_copy`, `views_count`, `created_at`, `updated_at`) VALUES (2, 1, '2. TIPOGRAFI & TAUTAN', 'Hierarki Heading, Paragraf & Tautan Aman', 'hierarki-heading-paragraf-dan-tautan', 'document', 'Panduan penataan heading h1-h6 yang SEO-friendly dan tautan rel noopener noreferrer.', '# Hierarki Heading, Paragraf & Tautan Aman

### 1. Aturan Emas Heading:
- Gunakan hanya **satu tag `<h1>`** per halaman sebagai tajuk utama.
- Gunakan `<h2>` sampai `<h6>` secara hierarkis bertingkat tanpa melompati level.

### 2. Tautan Aman dengan Tab Baru:
```html:link-aman.html
<a href=\"https://talentgroup.id\" target=\"_blank\" rel=\"noopener noreferrer\">
    Kunjungi Website Resmi
</a>
```
Atribut `rel=\"noopener noreferrer\"` melindungi halaman web dari celah manipulasi objek `window.opener`.', NULL, NULL, NULL, 2, 1, 1, NULL, 1, 1, 1, 0, '2026-10-25 02:44:54', '2026-10-25 02:44:54');
INSERT INTO `modules` (`id`, `category_id`, `section`, `title`, `slug`, `content_type`, `excerpt`, `content`, `file_path`, `file_name`, `file_size`, `order`, `is_published`, `is_public`, `referral_code`, `enable_protection`, `enable_anti_screenshot`, `enable_anti_copy`, `views_count`, `created_at`, `updated_at`) VALUES (3, 1, '3. FORMULIR & VALIDASI', 'Formulir Interaktif & Kontrol Validasi Bawaan', 'formulir-interaktif-dan-kontrol-validasi', 'document', 'Pembuatan form input teks, email, kata sandi, dropdown select, dan atribut required.', '# Formulir Interaktif & Kontrol Validasi Bawaan

Formulir HTML5 mampu memvalidasi data pengguna langsung di browser sebelum data dikirim ke server:

```html:form-login.html
<form action=\"/api/auth/login\" method=\"POST\">
    <div class=\"input-group\">
        <label for=\"email\">Email Perusahaan:</label>
        <input type=\"email\" id=\"email\" name=\"email\" required placeholder=\"nama@perusahaan.com\">
    </div>
    <div class=\"input-group\">
        <label for=\"password\">Kata Sandi:</label>
        <input type=\"password\" id=\"password\" name=\"password\" required minlength=\"8\">
    </div>
    <button type=\"submit\">Masuk ke Akun</button>
</form>
```

> [!TIP]
> Gunakan atribut `autocomplete=\"off\"` jika field memuat data rahasia seperti nomor PIN.', NULL, NULL, NULL, 3, 1, 1, NULL, 1, 1, 1, 0, '2026-10-25 02:44:54', '2026-10-25 02:44:54');
INSERT INTO `modules` (`id`, `category_id`, `section`, `title`, `slug`, `content_type`, `excerpt`, `content`, `file_path`, `file_name`, `file_size`, `order`, `is_published`, `is_public`, `referral_code`, `enable_protection`, `enable_anti_screenshot`, `enable_anti_copy`, `views_count`, `created_at`, `updated_at`) VALUES (4, 1, '4. SEMANTIK & SEO', 'Arsitektur Semantik: Header, Nav, Main & Footer', 'arsitektur-semantik-header-nav-main-footer', 'document', 'Menghilangkan kebiasaan div-soup dan menerapkan standar semantik ramah mesin pencari Google.', '# Arsitektur Semantik: Header, Nav, Main & Footer

Elemen semantik secara eksplisit mendeskripsikan peran masing-masing bagian halaman:

- `<header>`: Pengantar atau kumpulan menu navigasi atas.
- `<nav>`: Kumpulan tautan navigasi utama.
- `<main>`: Area konten unik tunggal pada halaman.
- `<article>`: Bagian tulisan mandiri (berita, tutorial, postingan).
- `<aside>`: Sidebar pendukung atau tautan artikel terkait.
- `<footer>`: Catatan penutup dokumen hak cipta.', NULL, NULL, NULL, 4, 1, 1, NULL, 1, 1, 1, 0, '2026-10-25 02:44:54', '2026-10-25 02:44:54');
INSERT INTO `modules` (`id`, `category_id`, `section`, `title`, `slug`, `content_type`, `excerpt`, `content`, `file_path`, `file_name`, `file_size`, `order`, `is_published`, `is_public`, `referral_code`, `enable_protection`, `enable_anti_screenshot`, `enable_anti_copy`, `views_count`, `created_at`, `updated_at`) VALUES (5, 2, '1. BOX MODEL & RESET', 'Universal Box-Sizing & CSS Reset Standar', 'universal-box-sizing-dan-css-reset', 'document', 'Mencegah kerusakan tata letak akibat padding dan border dengan reset border-box.', '# Universal Box-Sizing & CSS Reset Standar

Selalu pasang reset universal di baris teratas stylesheet Anda:

```css:reset.css
*, *::before, *::after {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}
```

### Perbedaan Karakteristik:
- **content-box**: Nilai `width` hanya menghitung isi konten. Padding dan border akan membuat kotak melebar melebihi ukuran yang ditentukan.
- **border-box**: Nilai `width` sudah merangkum konten, padding, dan border secara terpadu dan presisi.', NULL, NULL, NULL, 1, 1, 1, NULL, 1, 1, 1, 0, '2026-10-25 02:44:54', '2026-10-25 02:44:54');
INSERT INTO `modules` (`id`, `category_id`, `section`, `title`, `slug`, `content_type`, `excerpt`, `content`, `file_path`, `file_name`, `file_size`, `order`, `is_published`, `is_public`, `referral_code`, `enable_protection`, `enable_anti_screenshot`, `enable_anti_copy`, `views_count`, `created_at`, `updated_at`) VALUES (6, 2, '2. TATA LETAK FLEXBOX', 'Panduan Praktis Flexbox 1 Dimensi', 'panduan-praktis-flexbox-satu-dimensi', 'document', 'Mengatur navigasi, perataan horizontal & vertikal dengan justify-content, align-items, dan gap.', '# Panduan Praktis Flexbox 1 Dimensi

Flexbox dirancang khusus untuk membagi ruang dan meratakan elemen di sepanjang satu dimensi (baris atau kolom):

```css:navbar.css
.navbar-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 20px;
    padding: 16px 32px;
}

.nav-menu {
    display: flex;
    gap: 16px;
    list-style: none;
}
```

> [!TIP]
> Gunakan properti `gap` alih-alih memberikan `margin-right` pada setiap elemen anak.', NULL, NULL, NULL, 2, 1, 1, NULL, 1, 1, 1, 0, '2026-10-25 02:44:54', '2026-10-25 02:44:54');
INSERT INTO `modules` (`id`, `category_id`, `section`, `title`, `slug`, `content_type`, `excerpt`, `content`, `file_path`, `file_name`, `file_size`, `order`, `is_published`, `is_public`, `referral_code`, `enable_protection`, `enable_anti_screenshot`, `enable_anti_copy`, `views_count`, `created_at`, `updated_at`) VALUES (7, 2, '3. TATA LETAK CSS GRID', 'Arsitektur CSS Grid 2 Dimensi Responsif', 'arsitektur-css-grid-dua-dimensi-responsif', 'document', 'Membuat galeri kartu responsif otomatis tanpa media query dengan repeat, auto-fit, dan minmax.', '# Arsitektur CSS Grid 2 Dimensi Responsif

CSS Grid mampu mengendalikan baris dan kolom secara simultan:

```css:grid-layout.css
.cards-wrapper {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 24px;
}
```

Kode di atas secara cerdas mengubah susunan 4 kolom di monitor desktop menjadi 2 kolom di tablet dan 1 kolom di smartphone secara instan tanpa menulis satu baris pun `@media query`!', NULL, NULL, NULL, 3, 1, 1, NULL, 1, 1, 1, 0, '2026-10-25 02:44:54', '2026-10-25 02:44:54');
INSERT INTO `modules` (`id`, `category_id`, `section`, `title`, `slug`, `content_type`, `excerpt`, `content`, `file_path`, `file_name`, `file_size`, `order`, `is_published`, `is_public`, `referral_code`, `enable_protection`, `enable_anti_screenshot`, `enable_anti_copy`, `views_count`, `created_at`, `updated_at`) VALUES (8, 2, '4. VARIABEL & ANIMASI', 'CSS Custom Properties (Variabel) & Transisi Halus', 'css-custom-properties-dan-transisi', 'document', 'Membangun sistem tema Dark/Light mode menggunakan variabel CSS dan transisi interaksi hover.', '# CSS Custom Properties (Variabel) & Transisi Halus

```css:theme.css
:root {
    --primary-color: #0284c7;
    --surface-bg: #0f172a;
    --text-color: #f8fafc;
}

.action-btn {
    background-color: var(--primary-color);
    color: var(--text-color);
    padding: 12px 24px;
    border-radius: 8px;
    transition: transform 0.2s ease, opacity 0.2s ease;
}

.action-btn:hover {
    transform: translateY(-3px);
    opacity: 0.9;
}
```', NULL, NULL, NULL, 4, 1, 1, NULL, 1, 1, 1, 0, '2026-10-25 02:44:54', '2026-10-25 02:44:54');
INSERT INTO `modules` (`id`, `category_id`, `section`, `title`, `slug`, `content_type`, `excerpt`, `content`, `file_path`, `file_name`, `file_size`, `order`, `is_published`, `is_public`, `referral_code`, `enable_protection`, `enable_anti_screenshot`, `enable_anti_copy`, `views_count`, `created_at`, `updated_at`) VALUES (9, 3, '1. SINTAKS ES6+ MODERN', 'Variabel, Scope, Arrow Functions & Destructuring', 'variabel-scope-arrow-functions-destructuring', 'document', 'Aturan pemilihan let vs const, penulisan fungsi panah ringkas, dan ekstraksi properti objek.', '# Variabel, Scope, Arrow Functions & Destructuring

```javascript:es6-syntax.js
// 1. Destructuring Objek
const profil = { nama: \'Fajar\', jabatan: \'Frontend Lead\', lokasi: \'Jakarta\' };
const { nama, jabatan } = profil;

// 2. Arrow Functions Ringkas
const kalikan = (a, b) => a * b;

// 3. Template Literals
console.log(`Halo ${nama}, jabatan Anda saat ini: ${jabatan}`);
```

> [!IMPORTANT]
> Selalu gunakan `const` kecuali jika nilai variabel tersebut memang direncanakan untuk diubah nilainya.', NULL, NULL, NULL, 1, 1, 1, NULL, 1, 1, 1, 0, '2026-10-25 02:44:54', '2026-10-25 02:44:54');
INSERT INTO `modules` (`id`, `category_id`, `section`, `title`, `slug`, `content_type`, `excerpt`, `content`, `file_path`, `file_name`, `file_size`, `order`, `is_published`, `is_public`, `referral_code`, `enable_protection`, `enable_anti_screenshot`, `enable_anti_copy`, `views_count`, `created_at`, `updated_at`) VALUES (10, 3, '2. PENGOLAHAN ARRAY', 'Kekuatan Metode Array Fungsional: map, filter & reduce', 'metode-array-map-filter-reduce', 'document', 'Transformasi data koleksi secara deklaratif tanpa perulangan tradisional.', '# Kekuatan Metode Array Fungsional: map, filter & reduce

```javascript:array-ops.js
const produk = [
    { id: 1, nama: \'Buku HTML\', harga: 50000, stok: 10 },
    { id: 2, nama: \'Buku CSS\', harga: 60000, stok: 0 },
    { id: 3, nama: \'Buku JS\', harga: 75000, stok: 5 }
];

// 1. Filter: Hanya produk yang tersedia stoknya
const tersedia = produk.filter(p => p.stok > 0);

// 2. Map: Format nama dan harga
const labelHarga = tersedia.map(p => `${p.nama} - Rp ${p.harga}`);

// 3. Reduce: Hitung total nilai stok
const totalAset = produk.reduce((total, p) => total + (p.harga * p.stok), 0);
```', NULL, NULL, NULL, 2, 1, 1, NULL, 1, 1, 1, 0, '2026-10-25 02:44:54', '2026-10-25 02:44:54');
INSERT INTO `modules` (`id`, `category_id`, `section`, `title`, `slug`, `content_type`, `excerpt`, `content`, `file_path`, `file_name`, `file_size`, `order`, `is_published`, `is_public`, `referral_code`, `enable_protection`, `enable_anti_screenshot`, `enable_anti_copy`, `views_count`, `created_at`, `updated_at`) VALUES (11, 3, '3. MANIPULASI DOM', 'Event Listener & Manipulasi DOM Interaktif', 'event-listener-dan-manipulasi-dom-interaktif', 'document', 'Menghubungkan interaksi tombol pengguna untuk merubah elemen dan tampilan secara instan.', '# Event Listener & Manipulasi DOM Interaktif

```javascript:interaksi.js
const btnSubmit = document.querySelector(\'#btnKirim\');
const statusBox = document.querySelector(\'.status-box\');

btnSubmit.addEventListener(\'click\', (event) => {
    event.preventDefault();
    statusBox.classList.add(\'aktif\');
    statusBox.textContent = \'Data pendaftaran berhasil diverifikasi!\';
});
```

> [!NOTE]
> Panggil `event.preventDefault()` pada penanganan event submit form agar peramban tidak me-refresh seluruh halaman web.', NULL, NULL, NULL, 3, 1, 1, NULL, 1, 1, 1, 0, '2026-10-25 02:44:54', '2026-10-25 02:44:54');
INSERT INTO `modules` (`id`, `category_id`, `section`, `title`, `slug`, `content_type`, `excerpt`, `content`, `file_path`, `file_name`, `file_size`, `order`, `is_published`, `is_public`, `referral_code`, `enable_protection`, `enable_anti_screenshot`, `enable_anti_copy`, `views_count`, `created_at`, `updated_at`) VALUES (12, 3, '4. ASYNCHRONOUS & API', 'Asynchronous JavaScript: Promise, Async/Await & Fetch API', 'asynchronous-promise-async-await-fetch', 'document', 'Mengambil dan menampilkan data JSON dari RESTful API server backend secara mulus.', '# Asynchronous JavaScript: Promise, Async/Await & Fetch API

```javascript:fetch-api.js
async function muatDataPengguna() {
    try {
        const response = await fetch(\'https://api.talentgroup.id/v1/users\');
        if (!response.ok) {
            throw new Error(`Koneksi HTTP Error: ${response.status}`);
        }
        const users = await response.json();
        console.log(`Berhasil memuat ${users.length} data pengguna.`);
        return users;
    } catch (error) {
        console.error(\'Terjadi kendala:\', error.message);
    }
}
```', NULL, NULL, NULL, 4, 1, 1, NULL, 1, 1, 1, 0, '2026-10-25 02:44:54', '2026-10-25 02:44:54');

SET FOREIGN_KEY_CHECKS=1;
-- ===================================================================
-- Selesai. Seluruh data kurikulum berhasil di-generate.
-- ===================================================================
