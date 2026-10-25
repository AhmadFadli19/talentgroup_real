<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\CourseStory;
use App\Models\CourseHtml;
use App\Models\CourseQuestion;
use App\Models\CourseVideo;
use App\Models\Module;
use App\Models\ModuleCategory;
use App\Models\User;
use App\Models\ReferralCode;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ComprehensiveWebDevCoursesSeeder extends Seeder
{
    /**
     * Seed extensive, end-to-end courses and modules from fundamentals to advanced projects.
     */
    public function run(): void
    {
        $admin = User::first();
        $adminId = $admin ? $admin->id : 1;

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        CourseStory::truncate();
        CourseHtml::truncate();
        CourseQuestion::truncate();
        CourseVideo::truncate();
        Course::truncate();

        Module::truncate();
        ModuleCategory::truncate();

        // =========================================================================
        // 1. KURSUS LENGKAP: HTML5 DARI DASAR HINGGA PROYEK SEMANTIK
        // =========================================================================
        $courseHtml = Course::create([
            'title' => 'A01 - HTML5 Komprehensif: Dari Nol Pengenalan Hingga Mahir Membangun Web Semantik',
            'description' => 'Panduan terstruktur belajar HTML5 dari nol. Kuasai sintaks dasar, anatomi dokumen, pemformatan teks, sistem navigasi dan tautan, tabel data, formulir validasi modern, integrasi multimedia, aksesibilitas (a11y), hingga struktur halaman berstandar industri siap produksi.',
            'price' => 0.00, // FREE Fondasi
            'image' => null,
            'is_active' => true,
            'quiz_answer_visibility' => 'end',
            'quiz_navigation_mode' => 'free',
            'shuffle_questions' => true,
            'shuffle_options' => true,
            'created_by' => $adminId,
        ]);

        $orderHtml = 1;

        // Bab 1: Pengenalan & Anatomi Dasar
        CourseStory::create([
            'course_id' => $courseHtml->id,
            'title' => 'Bab 1: Pengenalan Web, Internet & Anatomi Dokumen HTML5',
            'content' => "Selamat datang di perjalanan menjadi pengembang web profesional! Sebelum kita menulis kode, penting untuk memahami peran fundamental HTML.\n\n### Apa itu HTML?\nHTML singkatan dari **HyperText Markup Language**. HTML bukan bahasa pemrograman berlogika (seperti JS, PHP, atau Python), melainkan bahasa penandaan (*markup*) yang bertugas menentukan **struktur dan makna** dari konten halaman web.\n\n### Anatomi Elemen HTML\nElemen HTML dibangun dari tiga komponen utama:\n1. **Tag Pembuka (Opening Tag)**: Contoh `<p>` menandakan awal elemen paragraf.\n2. **Konten (Content)**: Teks atau elemen anak di dalam tag, misalnya `Halo Dunia`.\n3. **Tag Penutup (Closing Tag)**: Ditandai garis miring, contoh `</p>` menandakan akhir elemen.\n\n### Anatomi Dokumen Lengkap\n```html\n<!DOCTYPE html>\n<html lang=\"id\">\n<head>\n    <meta charset=\"UTF-8\">\n    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">\n    <title>Situs Pertamaku</title>\n</head>\n<body>\n    <h1>Selamat Datang di Dunia Web Development!</h1>\n    <p>Ini adalah langkah pertama membangun antarmuka web modern.</p>\n</body>\n</html>\n```\n\n> [!NOTE]\n> - `<!DOCTYPE html>`: Menginstruksikan browser untuk menggunakan standar render HTML5 modern.\n> - `<head>`: Menyimpan metadata (informasi penting untuk browser dan search engine yang tidak tampak langsung di layar).\n> - `<body>`: Seluruh konten visual yang dilihat dan diinteraksikan langsung oleh pengguna.",
            'use_image' => false,
            'use_audio' => false,
            'use_video' => false,
            'order' => $orderHtml++,
        ]);

        // Bab 2: Hirarki Tipografi, Format Teks & Tautan Navigasi
        CourseStory::create([
            'course_id' => $courseHtml->id,
            'title' => 'Bab 2: Hierarki Judul (Headings), Pemformatan Teks & Tautan (Hyperlinks)',
            'content' => "Sebuah halaman web yang baik memiliki hierarki informasi yang teratur agar pembaca dan mesin pencari (SEO) dapat mencerna konten secara mudah.\n\n### 1. Hierarki Heading (h1 sampai h6)\n- `<h1>`: Judul utama halaman web. **Aturan baku SEO: Hanya boleh ada SATU `<h1>` per halaman!**\n- `<h2>`: Sub-judul dari bab topik utama.\n- `<h3>` s/d `<h6>`: Rincian sub-topik yang lebih spesifik.\n\n### 2. Format Teks Bermakna Semantik\n- `<strong>`: Menandakan teks sangat penting (tebal).\n- `<em>`: Memberikan penekanan intonasi kata (miring).\n- `<mark>`: Menandai teks layaknya stabilo kuning.\n- `<blockquote>`: Kutipan panjang dari sumber eksternal.\n\n### 3. Tautan Hyperlink `<a>`\nTautan adalah inti dari konsep *HyperText* yang menghubungkan seluruh dokumen web di dunia:\n```html\n<!-- Tautan eksternal membuka tab baru dengan atribut keamanan -->\n<a href=\"https://google.com\" target=\"_blank\" rel=\"noopener noreferrer\">\n    Cari di Google\n</a>\n\n<!-- Tautan internal antar bagian halaman (Anchor Link) -->\n<a href=\"#kontak-kami\">Hubungi Kami</a>\n```",
            'use_image' => false,
            'use_audio' => false,
            'use_video' => false,
            'order' => $orderHtml++,
        ]);

        // Bab 3: Daftar (Lists) & Tabel Data Terstruktur
        CourseStory::create([
            'course_id' => $courseHtml->id,
            'title' => 'Bab 3: Daftar Terstruktur (Lists) & Tabel Data Semantik',
            'content' => "Menampilkan kumpulan informasi yang rapi membutuhkan elemen pengelompokan yang tepat.\n\n### 1. Tipe-Tipe Daftar (Lists)\n- **Unordered List `<ul>`**: Daftar dengan tanda titik/bullet. Sangat sering dimanfaatkan sebagai kerangka dasar navigasi menu.\n- **Ordered List `<ol>`**: Daftar bernomor berurutan (1, 2, 3), cocok untuk langkah panduan tutorial.\n- Setiap butir data dibungkus dengan tag `<li>` (List Item).\n\n```html\n<ul>\n    <li>HTML5 Semantik</li>\n    <li>CSS3 Modern</li>\n    <li>JavaScript ES6+</li>\n</ul>\n```\n\n### 2. Tabel Data Semantik Modern\nJangan pernah menggunakan tabel untuk layout halaman! Tabel secara eksklusif diperuntukkan bagi data tabular (misal: laporan keuangan, jadwal, absensi):\n```html\n<table>\n    <thead>\n        <tr>\n            <th>No</th>\n            <th>Nama Modul</th>\n            <th>Tingkat</th>\n        </tr>\n    </thead>\n    <tbody>\n        <tr>\n            <td>1</td>\n            <td>HTML5 Dasar</td>\n            <td>Pemula</td>\n        </tr>\n    </tbody>\n</table>\n```",
            'use_image' => false,
            'use_audio' => false,
            'use_video' => false,
            'order' => $orderHtml++,
        ]);

        // Bab 4: Media, Gambar Responsif & Multimedia
        CourseStory::create([
            'course_id' => $courseHtml->id,
            'title' => 'Bab 4: Pengelolaan Gambar Responsif, Audio, Video & Iframe',
            'content' => "Website modern kaya akan konten multimedia. Namun, jika tidak diatur dengan benar, media dapat memperlambat loading website.\n\n### 1. Tag Gambar `<img>` dengan Best Practice:\n```html\n<img src=\"/assets/hero-banner.webp\" \n     alt=\"Panduan Belajar Pemrograman Web Full-Stack\" \n     loading=\"lazy\" \n     width=\"800\" \n     height=\"450\">\n```\n- `alt`: Wajib diisi! Menjelaskan deskripsi gambar bagi tuna netra dan jika gambar gagal dimuat.\n- `loading=\"lazy\"`: Menghemat bandwidth dengan hanya memuat gambar saat pengunjung menggulir layar mendekati gambar tersebut.\n\n### 2. Video & Audio Native HTML5:\n```html\n<video controls width=\"640\" poster=\"thumbnail.jpg\">\n    <source src=\"tutorial.mp4\" type=\"video/mp4\">\n    Browser Anda tidak mendukung pemutar video HTML5.\n</video>\n```\nAtribut `controls` memunculkan tombol putar, jeda, volume, dan layar penuh secara otomatis.",
            'use_image' => false,
            'use_audio' => false,
            'use_video' => false,
            'order' => $orderHtml++,
        ]);

        // Bab 5: Formulir Interaktif & Validasi Lengkap
        CourseStory::create([
            'course_id' => $courseHtml->id,
            'title' => 'Bab 5: Arsitektur Formulir Interaktif, Tipe Input & Validasi Bawaan',
            'content' => "Formulir adalah pintu masuk pengumpulan data pengguna. HTML5 menyediakan validasi bawaan di peramban tanpa perlu library eksternal.\n\n### Komponen Form Lengkap:\n```html\n<form action=\"/register\" method=\"POST\">\n    <!-- Group Input Nama -->\n    <label for=\"fullname\">Nama Lengkap:</label>\n    <input type=\"text\" id=\"fullname\" name=\"fullname\" required minlength=\"3\" placeholder=\"Contoh: Budi Pratama\">\n\n    <!-- Group Email dengan Validasi Format Otomatis -->\n    <label for=\"email\">Email Aktif:</label>\n    <input type=\"email\" id=\"email\" name=\"email\" required placeholder=\"budi@domain.com\">\n\n    <!-- Input Pilihan Dropdown -->\n    <label for=\"course\">Pilihan Minat:</label>\n    <select id=\"course\" name=\"course\" required>\n        <option value=\"\">-- Pilih Peminatan --</option>\n        <option value=\"frontend\">Frontend Engineering</option>\n        <option value=\"backend\">Backend Engineering</option>\n    </select>\n\n    <!-- Tombol Submit -->\n    <button type=\"submit\">Kirim Pendaftaran</button>\n</form>\n```",
            'use_image' => false,
            'use_audio' => false,
            'use_video' => false,
            'order' => $orderHtml++,
        ]);

        // Bab 6 (HTML Live Preview): Halaman Registrasi Siswa Lengkap
        CourseHtml::create([
            'course_id' => $courseHtml->id,
            'title' => 'Live Demo: Formulir Pendaftaran Kursus Interaktif',
            'content' => 'Simulasi interaktif halaman formulir pendaftaran siswa dengan seluruh validasi HTML5 bawaan, styling kartu modern, dan pesan feedback instan.',
            'html_code' => '<div class="form-container">
    <div class="form-header">
        <span class="badge">REGISTRASI PESERTA</span>
        <h2>Formulir Gabung TalentGroup</h2>
        <p>Isi informasi identitas diri Anda untuk memulai kursus bersertifikasi.</p>
    </div>

    <form class="student-form" onsubmit="event.preventDefault(); document.getElementById(\'alertSuccess\').style.display=\'block\';">
        <div class="form-group">
            <label for="txtName">Nama Lengkap <span class="req">*</span></label>
            <input type="text" id="txtName" required minlength="3" placeholder="Masukkan nama resmi sesuai ijazah" class="form-input">
        </div>

        <div class="form-group">
            <label for="txtEmail">Alamat Email <span class="req">*</span></label>
            <input type="email" id="txtEmail" required placeholder="alamat.anda@email.com" class="form-input">
        </div>

        <div class="form-row">
            <div class="form-group half">
                <label for="txtTrack">Jalur Pelatihan <span class="req">*</span></label>
                <select id="txtTrack" required class="form-input">
                    <option value="">Pilih Jalur</option>
                    <option value="html">HTML5 & Web Semantik</option>
                    <option value="css">CSS3 & Desain UI/UX</option>
                    <option value="js">JavaScript Modern ES6+</option>
                </select>
            </div>
            <div class="form-group half">
                <label for="txtLevel">Level Pengalaman</label>
                <select id="txtLevel" class="form-input">
                    <option value="beginner">Pemula (Belum Pernah Coding)</option>
                    <option value="intermediate">Menengah (Pernah Belajar Dasar)</option>
                </select>
            </div>
        </div>

        <button type="submit" class="submit-btn">Kirim & Konfirmasi Pendaftaran</button>

        <div id="alertSuccess" class="alert-success" style="display: none;">
            ✔ Formulir Berhasil Dikirim! Data Anda telah terverifikasi oleh sistem.
        </div>
    </form>
</div>',
            'css_code' => '.form-container { max-width: 540px; margin: 30px auto; background: #0c1427; border: 1px solid #1e293b; border-radius: 20px; padding: 32px; color: #fff; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; box-shadow: 0 20px 45px rgba(0,0,0,0.6); }
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
.alert-success { background: rgba(16, 185, 129, 0.15); border: 1px solid #10b981; color: #34d399; padding: 12px; border-radius: 10px; font-size: 12px; font-weight: 700; text-align: center; margin-top: 10px; }',
            'js_code' => 'console.log("HTML5 Form Validator Active");',
            'order' => $orderHtml++,
        ]);

        // Bab 7: Elemen Semantik & SEO Tingkat Lanjut
        CourseStory::create([
            'course_id' => $courseHtml->id,
            'title' => 'Bab 7: Arsitektur Semantik Penuh Halaman Web Modern',
            'content' => "Tahap akhir dari penguasaan HTML5 adalah kemampuan merangkai seluruh elemen menjadi satu kesatuan dokumen utuh yang ramah mesin pencari (SEO-friendly) dan mudah dibaca oleh peramban pembaca tuna netra.\n\n### Diagram Struktur Semantik:\n1. `<header>`: Memuat logo brand, nama situs, dan menu navigasi `<nav>`.\n2. `<main>`: Memuat inti konten unik yang dicari pengunjung.\n   - Terbagi dalam beberapa `<section>` tematik.\n   - Setiap artikel mandiri dibungkus `<article>`.\n3. `<aside>`: Sidebar samping berisi daftar kategori, profil penulis, atau artikel terpopuler.\n4. `<footer>`: Penutup halaman memuat hak cipta, peta situs, dan media sosial.\n\nDengan meninggalkan budaya kuno pembungkusan tanpa makna `<div>` berlebihan, kualitas kode Anda setara dengan standar insinyur web di perusahaan teknologi terkemuka.",
            'use_image' => false,
            'use_audio' => false,
            'use_video' => false,
            'order' => $orderHtml++,
        ]);

        // Soal Kuis HTML (4 Soal Variatif)
        CourseQuestion::create([
            'course_id' => $courseHtml->id,
            'question_type' => 'question',
            'title' => 'Aturan Penggunaan Tag Heading Utama (h1)',
            'content' => "Berdasarkan standar praktik terbaik Search Engine Optimization (SEO) dan struktur dokumen semantik HTML5, berapakah jumlah tag `<h1>` yang direkomendasikan berada di dalam satu halaman web tunggal?",
            'options' => [
                'Bebas sesuai kebutuhan desain visual',
                'Tepat SATU tag <h1> per halaman',
                'Minimal 5 tag agar artikel mudah ditemukan Google',
                'Tidak boleh menggunakan <h1> sama sekali jika sudah ada title'
            ],
            'correct_answer' => 'Tepat SATU tag <h1> per halaman',
            'hint' => 'Hanya ada satu topik/judul utama per halaman.',
            'order' => $orderHtml++,
        ]);

        CourseQuestion::create([
            'course_id' => $courseHtml->id,
            'question_type' => 'question',
            'title' => 'Atribut Wajib pada Tag Gambar <img>',
            'content' => "Manakah atribut pada tag `<img>` yang bertugas memberikan teks deskriptif alternatif ketika gambar gagal dimuat atau saat dibaca oleh software pembaca layar (screen reader) penyandang disabilitas?",
            'options' => [
                'title',
                'desc',
                'alt',
                'src'
            ],
            'correct_answer' => 'alt',
            'hint' => 'Singkatan dari alternative text.',
            'order' => $orderHtml++,
        ]);

        CourseQuestion::create([
            'course_id' => $courseHtml->id,
            'question_type' => 'question',
            'title' => 'Tag Semantik untuk Konten Mandiri Independen',
            'content' => "Elemen semantik HTML5 manakah yang paling ideal digunakan untuk membungkus sebuah konten mandiri yang dapat didistribusikan ulang atau berdiri sendiri secara utuh, seperti sebuah postingan artikel blog, berita, atau komentar pembaca?",
            'options' => [
                '<section>',
                '<article>',
                '<aside>',
                '<div>'
            ],
            'correct_answer' => '<article>',
            'hint' => 'Bermakna artikel dalam bahasa Inggris.',
            'order' => $orderHtml++,
        ]);

        CourseQuestion::create([
            'course_id' => $courseHtml->id,
            'question_type' => 'question',
            'title' => 'Atribut Keamanan Tautan Tab Baru',
            'content' => "Ketika membuat tautan eksternal yang membuka tab peramban baru menggunakan `target=\"_blank\"`, pasangan atribut keamanan manakah yang wajib disertakan untuk mencegah celah keamanan tab-nabbing (*window.opener vulnerability*)?",
            'options' => [
                'security=\"safe\"',
                'rel=\"noopener noreferrer\"',
                'sandbox=\"secure\"',
                'mode=\"protected\"'
            ],
            'correct_answer' => 'rel=\"noopener noreferrer\"',
            'hint' => 'Menggunakan atribut rel yang memblokir referer dan opener.',
            'order' => $orderHtml++,
        ]);

        // Coding Challenge HTML 1: Generator Tag Meta SEO
        CourseQuestion::create([
            'course_id' => $courseHtml->id,
            'question_type' => 'coding',
            'title' => 'Tantangan Coding: Generator Tag Meta Deskripsi SEO',
            'content' => "Dalam sistem CMS, admin sering memasukkan deskripsi artikel yang kemudian harus diubah menjadi tag meta HTML: `<meta name=\"description\" content=\"...\">`.\n\n### Instruksi:\nBuatlah program JavaScript yang membaca teks satu baris deskripsi, lalu cetak teks tersebut dalam format tag meta HTML lengkap tanpa spasi berlebih.\n\nContoh Input:\n`Belajar HTML5 dari dasar sampai mahir bersama TalentGroup`\n\nContoh Output:\n`<meta name=\"description\" content=\"Belajar HTML5 dari dasar sampai mahir bersama TalentGroup\">`",
            'language' => 'javascript',
            'starter_code' => "const readline = require('readline');
const rl = readline.createInterface({ input: process.stdin, output: process.stdout });

rl.on('line', (line) => {
    const text = line.trim();
    console.log('<meta name=\"description\" content=\"' + text + '\">');
    process.exit(0);
});",
            'expected_output' => '<meta name=\"description\" content=\"Belajar HTML5 dari dasar sampai mahir bersama TalentGroup\">',
            'test_cases' => [
                [
                    'input' => 'Belajar HTML5 dari dasar sampai mahir bersama TalentGroup',
                    'expected_output' => '<meta name=\"description\" content=\"Belajar HTML5 dari dasar sampai mahir bersama TalentGroup\">'
                ],
                [
                    'input' => 'Panduan Form Web & Aksesibilitas Modern',
                    'expected_output' => '<meta name=\"description\" content=\"Panduan Form Web & Aksesibilitas Modern\">'
                ]
            ],
            'coding_rules' => ['console_log'],
            'hint' => 'Bungkus teks input di dalam tanda petik atribut content.',
            'order' => $orderHtml++,
        ]);


        // =========================================================================
        // 2. KURSUS LENGKAP: CSS3 DARI DASAR HINGGA RESPONSIVE LAYOUT & ANIMASI
        // =========================================================================
        $courseCss = Course::create([
            'title' => 'A02 - CSS3 Komprehensif: Seni Menata Desain Web, Flexbox, Grid & Animasi UI',
            'description' => 'Eksplorasi mendalam desain antarmuka modern. Dari pemahaman selektor CSS, specificity, universal box-sizing, tipografi cairan (clamp), Flexbox 1 dimensi, CSS Grid 2 dimensi, teknik positioning (sticky/fixed), media queries mobile-first, hingga micro-interactions animasi transisi.',
            'price' => 75000.00,
            'image' => null,
            'is_active' => true,
            'quiz_answer_visibility' => 'end',
            'quiz_navigation_mode' => 'free',
            'shuffle_questions' => true,
            'shuffle_options' => true,
            'created_by' => $adminId,
        ]);

        $orderCss = 1;

        // Bab 1: Sintaks, Selektor & Specificity
        CourseStory::create([
            'course_id' => $courseCss->id,
            'title' => 'Bab 1: Anatomi CSS, Selektor Modern & Aturan Specificity',
            'content' => "CSS (**Cascading Style Sheets**) adalah bahasa yang memberikan keindahan, warna, dan tata letak pada dokumen HTML.\n\n### Anatomi Pernyataan CSS\n```css\nselector {\n    property: value;\n}\n```\n- **Selector**: Menunjuk elemen HTML mana yang hendak diwarnai/diatur.\n- **Declaration**: Terdiri dari nama properti dan nilainya, diakhiri titik koma `;`.\n\n### Tingkat Bobot Selektor (Specificity Hierarchy):\n1. **Inline Style** (`style=\"...\"`): Bobot tertinggi (1000 poin).\n2. **ID Selector** (`#header`): Bobot tinggi (100 poin).\n3. **Class, Pseudo-class, Attribute** (`.btn`, `:hover`, `[type=\"text\"]`): Bobot menengah (10 poin).\n4. **Element & Pseudo-element** (`h1`, `p`, `::before`): Bobot dasar (1 poin).\n\n> [!TIP]\n> Hindari menggunakan `!important` untuk memaksakan gaya tampilan! Mengatur kelas CSS secara terstruktur dan menjaga selektor tetap ringkas adalah kunci kode yang mudah dirawat.",
            'use_image' => false,
            'use_audio' => false,
            'use_video' => false,
            'order' => $orderCss++,
        ]);

        // Bab 2: Box Model, Margin Collapsing & Box-Sizing
        CourseStory::create([
            'course_id' => $courseCss->id,
            'title' => 'Bab 2: Menguasai Box Model, Margin Collapsing & Reset Modern',
            'content' => "Setiap elemen pada peramban memiliki 4 lapisan kotak:\n1. **Content**: Ruang teks atau gambar berada.\n2. **Padding**: Ruang kosong di antara konten dan border.\n3. **Border**: Garis batas tepi elemen.\n4. **Margin**: Jarak luar elemen dengan elemen sekelilingnya.\n\n### Fenomena Margin Collapsing:\nKetika dua margin vertikal elemen bertingkat bertemu (misalnya margin-bottom paragraf atas 20px dan margin-top paragraf bawah 30px), nilainya **tidak dijumlahkan** menjadi 50px, melainkan melebur (*collapse*) mengambil nilai terbesar yaitu 30px.\n\n### Standar Reset Universal:\n```css\n*, *::before, *::after {\n    box-sizing: border-box;\n    margin: 0;\n    padding: 0;\n}\n```\nDengan `border-box`, lebar elemen yang Anda tuliskan mencakup border dan padding, mencegah tata letak melebar tak terkendali.",
            'use_image' => false,
            'use_audio' => false,
            'use_video' => false,
            'order' => $orderCss++,
        ]);

        // Bab 3: Tipografi Modern, Google Fonts & Variabel CSS (Custom Properties)
        CourseStory::create([
            'course_id' => $courseCss->id,
            'title' => 'Bab 3: Tipografi Responsif & Variabel Tema (CSS Custom Properties)',
            'content' => "Tipografi menyumbang lebih dari 80% pengalaman membaca di sebuah website.\n\n### 1. Tipografi Responsif dengan `clamp()`\nFungsi `clamp(min, preferred, max)` memungkinkan ukuran teks membesar dan mengecil secara otomatis sesuai lebar layar tanpa perlu menulis media query berulang kali!\n```css\nh1 {\n    font-size: clamp(1.8rem, 4vw + 1rem, 3.5rem);\n}\n```\n\n### 2. Variabel CSS Modern (Custom Properties)\nVariabel mempermudah pembuatan mode terang (Light Mode) dan gelap (Dark Mode):\n```css\n:root {\n    --bg-primary: #0a0f1d;\n    --text-primary: #f8fafc;\n    --accent-color: #38bdf8;\n}\n\n.card {\n    background: var(--bg-primary);\n    color: var(--text-primary);\n    border: 1px solid var(--accent-color);\n}\n```",
            'use_image' => false,
            'use_audio' => false,
            'use_video' => false,
            'order' => $orderCss++,
        ]);

        // Bab 4: Panduan Flexbox Satu Dimensi Komprehensif
        CourseStory::create([
            'course_id' => $courseCss->id,
            'title' => 'Bab 4: Arsitektur Flexbox: Sumbu Utama, Sumbu Silang & Distribusi Ruang',
            'content' => "Flexbox adalah solusi terbaik untuk menyusun elemen-elemen dalam satu baris atau satu kolom.\n\n### Memahami Dua Sumbu Flex:\n1. **Sumbu Utama (Main Axis)**: Ditentukan oleh properti `flex-direction: row` (horizontal ke kanan) atau `column` (vertikal ke bawah).\n   - Diatur dengan `justify-content` (`flex-start`, `center`, `flex-end`, `space-between`, `space-evenly`).\n2. **Sumbu Silang (Cross Axis)**: Sumbu tegak lurus terhadap sumbu utama.\n   - Diatur dengan `align-items` (`stretch`, `center`, `flex-start`, `flex-end`).\n\n### Properti Anak Flex (Flex Item):\n- `flex: 1`: Memerintahkan item untuk tumbuh membesar dan menyerap seluruh sisa ruang kosong yang tersedia secara adil.\n- `gap: 1.5rem`: Menetapkan jarak antar item tanpa perlu mengatur margin secara manual.",
            'use_image' => false,
            'use_audio' => false,
            'use_video' => false,
            'order' => $orderCss++,
        ]);

        // Bab 5: CSS Grid Layout Dua Dimensi
        CourseStory::create([
            'course_id' => $courseCss->id,
            'title' => 'Bab 5: CSS Grid: Arsitektur Tata Letak Dua Dimensi Maju',
            'content' => "Jika Flexbox berfokus pada satu arah baris atau kolom, CSS Grid adalah sistem layout dua dimensi yang mampu mengatur baris dan kolom secara bersamaan.\n\n### Rumus Grid Galeri Responsif Tanpa Media Query:\n```css\n.dashboard-grid {\n    display: grid;\n    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));\n    gap: 24px;\n}\n```\n- `auto-fit`: Secara otomatis mengisi baris dengan jumlah kartu sebanyak mungkin yang muat.\n- `minmax(300px, 1fr)`: Kartu tidak akan mengecil kurang dari 300px, dan akan melebar proporsional (1fr) jika layar bertambah luas.\n\n### Penataan Area dengan `grid-template-areas`:\n```css\n.layout-wrapper {\n    display: grid;\n    grid-template-areas: \n        \"header header\"\n        \"sidebar content\"\n        \"footer footer\";\n}\n```",
            'use_image' => false,
            'use_audio' => false,
            'use_video' => false,
            'order' => $orderCss++,
        ]);

        // Bab 6 (HTML Live Preview): Kartu Statistik Dashboard Interaktif
        CourseHtml::create([
            'course_id' => $courseCss->id,
            'title' => 'Live Demo: Grid Dashboard & Efek Glassmorphism',
            'content' => 'Eksplorasi antarmuka dashboard dengan CSS Grid responsif, efek latar belakang buram (Glassmorphism), dan indikator metrik yang dinamis.',
            'html_code' => '<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon icon-blue">👥</div>
        <div class="stat-info">
            <span class="stat-label">Total Pengguna Aktif</span>
            <span class="stat-value">12.450</span>
            <span class="stat-badge badge-up">▲ +14% bulan ini</span>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon icon-green">🎓</div>
        <div class="stat-info">
            <span class="stat-label">Kelulusan Kursus</span>
            <span class="stat-value">98.2%</span>
            <span class="stat-badge badge-up">▲ Sangat Optimal</span>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon icon-amber">⭐</div>
        <div class="stat-info">
            <span class="stat-label">Rating Rata-Rata</span>
            <span class="stat-value">4.9 / 5.0</span>
            <span class="stat-badge badge-star">★ 2.100 Ulasan</span>
        </div>
    </div>
</div>',
            'css_code' => '.stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 20px; max-width: 900px; margin: 30px auto; padding: 15px; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; }
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
.badge-star { background: rgba(245, 158, 11, 0.12); color: #fbbf24; }',
            'js_code' => 'console.log("CSS Dashboard Grid Loaded");',
            'order' => $orderCss++,
        ]);

        // Bab 7: Animasi Mikro, Transisi & Keyframes
        CourseStory::create([
            'course_id' => $courseCss->id,
            'title' => 'Bab 7: Micro-Interactions: Transisi Halus & Animasi Keyframes',
            'content' => "Antarmuka yang statis terasa kaku. Menambahkan transisi mikro yang halus membuat aplikasi terasa hidup dan responsif terhadap sentuhan jari atau kursor pengguna.\n\n### 1. Transisi CSS (CSS Transitions)\nDigunakan saat elemen berganti status (misal: saat di-hover):\n```css\n.btn-action {\n    background-color: #0284c7;\n    transition: background-color 0.25s ease, transform 0.25s ease;\n}\n\n.btn-action:hover {\n    background-color: #0ea5e9;\n    transform: translateY(-2px);\n}\n```\n\n### 2. Animasi Berulang (@keyframes Animation)\nUntuk animasi otomatis berkelanjutan tanpa interaksi pengguna:\n```css\n@keyframes denyutPulse {\n    0% { transform: scale(1); opacity: 1; }\n    50% { transform: scale(1.08); opacity: 0.8; }\n    100% { transform: scale(1); opacity: 1; }\n}\n\n.status-online {\n    animation: denyutPulse 2s infinite ease-in-out;\n}\n```",
            'use_image' => false,
            'use_audio' => false,
            'use_video' => false,
            'order' => $orderCss++,
        ]);

        // Soal Kuis CSS
        CourseQuestion::create([
            'course_id' => $courseCss->id,
            'question_type' => 'question',
            'title' => 'Selektor dengan Specificity Tertinggi',
            'content' => "Dari daftar selektor CSS berikut, manakah yang memiliki bobot nilai Specificity (prioritas penimpaan gaya) paling tinggi dalam menentukan tampilan elemen?",
            'options' => [
                'Elemen tag standar seperti h1 atau p (1 poin)',
                'Nama Class seperti .btn-primary (10 poin)',
                'Identifier unik ID seperti #main-navbar (100 poin)',
                'Pseudo-class seperti :hover atau :active (10 poin)'
            ],
            'correct_answer' => 'Identifier unik ID seperti #main-navbar (100 poin)',
            'hint' => 'ID Selector memiliki bobot 100 poin.',
            'order' => $orderCss++,
        ]);

        CourseQuestion::create([
            'course_id' => $courseCss->id,
            'question_type' => 'question',
            'title' => 'Properti Distribusi Ruang Flexbox',
            'content' => "Nilai properti `justify-content` manakah yang mendistribusikan item pertama persis menempel di tepi kiri dan item terakhir persis menempel di tepi kanan, sementara sisa ruang dibagi rata di antara item-item tengah?",
            'options' => [
                'space-evenly',
                'space-around',
                'space-between',
                'center'
            ],
            'correct_answer' => 'space-between',
            'hint' => 'Berarti ruang di antara item (antara tepi ke tepi).',
            'order' => $orderCss++,
        ]);

        CourseQuestion::create([
            'course_id' => $courseCss->id,
            'question_type' => 'question',
            'title' => 'Fungsi auto-fit pada CSS Grid',
            'content' => "Apakah keunggulan utama dari penggunaan nilai `auto-fit` dalam deklarasi `grid-template-columns: repeat(auto-fit, minmax(250px, 1fr))`?",
            'options' => [
                'Menyembunyikan kartu jika resolusi layar berada di bawah 600px',
                'Memperluas dan menyesuaikan kolom yang ada secara otomatis mengisi seluruh ruang kosong layar tanpa media query',
                'Memutar orientasi layout dari horizontal menjadi vertikal secara acak',
                'Mengunci ukuran setiap elemen agar tidak pernah berubah sama sekali'
            ],
            'correct_answer' => 'Memperluas dan menyesuaikan kolom yang ada secara otomatis mengisi seluruh ruang kosong layar tanpa media query',
            'hint' => 'Menjadikan layout responsif otomatis mengisi layar.',
            'order' => $orderCss++,
        ]);

        // Coding Challenge CSS: Kalkulator Padding & Content-Box
        CourseQuestion::create([
            'course_id' => $courseCss->id,
            'question_type' => 'coding',
            'title' => 'Tantangan Coding: Hitung Dimensi Total Elemen (Content-Box)',
            'content' => "Pada mode default `box-sizing: content-box`, total lebar elemen dihitung dengan rumus:\n`Total Width = Width + (PaddingLeft + PaddingRight) + (BorderLeft + BorderRight)`\n\n### Instruksi:\nBuatlah program JavaScript yang membaca 3 input angka dalam 1 baris yang dipisahkan spasi berturut-turut:\n1. Width konten (px)\n2. Padding horizontal per sisi (px)\n3. Border horizontal per sisi (px)\n\nHitung total lebar elemen dan cetak angkanya!\n\nContoh Input:\n`200 20 2`\n*(Artinya Width 200, Padding kiri 20, Padding kanan 20, Border kiri 2, Border kanan 2)*\n\nKalkulasi: `200 + (20 * 2) + (2 * 2) = 244`\n\nContoh Output:\n`244`",
            'language' => 'javascript',
            'starter_code' => "const readline = require('readline');
const rl = readline.createInterface({ input: process.stdin, output: process.stdout });

rl.on('line', (line) => {
    const [width, padding, border] = line.trim().split(/\\s+/).map(Number);
    const totalWidth = width + (padding * 2) + (border * 2);
    console.log(totalWidth);
    process.exit(0);
});",
            'expected_output' => '244',
            'test_cases' => [
                [
                    'input' => '200 20 2',
                    'expected_output' => '244'
                ],
                [
                    'input' => '300 15 5',
                    'expected_output' => '340'
                ]
            ],
            'coding_rules' => ['console_log'],
            'hint' => 'Kalikan padding dan border dengan 2, lalu tambahkan ke nilai width.',
            'order' => $orderCss++,
        ]);


        // =========================================================================
        // 3. KURSUS LENGKAP: JAVASCRIPT ES6+ DARI LOGIKA HINGGA APLIKASI WEB
        // =========================================================================
        $courseJs = Course::create([
            'title' => 'A03 - JavaScript ES6+ Komprehensif: Logika Pemrograman, Manipulasi DOM & Aplikasi Web',
            'description' => 'Dari nol logika pemrograman hingga mahir membangun aplikasi dinamis. Menguasai let/const, arrow functions, template literals, destructuring, metode array fungsional (map, filter, reduce), penanganan event, manipulasi DOM real-time, asynchronous promises, async/await, hingga integrasi Fetch API.',
            'price' => 99000.00,
            'image' => null,
            'is_active' => true,
            'quiz_answer_visibility' => 'end',
            'quiz_navigation_mode' => 'free',
            'shuffle_questions' => true,
            'shuffle_options' => true,
            'created_by' => $adminId,
        ]);

        $orderJs = 1;

        // Bab 1: Dasar Variabel, Tipe Data & Operator
        CourseStory::create([
            'course_id' => $courseJs->id,
            'title' => 'Bab 1: Fondasi JavaScript ES6+: Variabel, Tipe Data & Operator',
            'content' => "JavaScript adalah bahasa pemrograman yang memberikan kecerdasan dan interaktivitas pada halaman web.\n\n### 1. Deklarasi Variabel Modern (`const` vs `let`)\n- `const`: Untuk nilai konstan yang tidak akan di-reassign (contoh: konfigurasi, fungsi, array acuan).\n- `let`: Untuk nilai yang akan diperbarui nilainya (contoh: counter perulangan).\n- **Tinggalkan `var`** karena perilakunya yang tidak mematuhi batasan kurung kurawal (*block scope*) dan rentan bug.\n\n### 2. Tipe Data Primitif:\n- `String`: Teks (Gunakan Template Literals: `` `Halo \${nama}` ``).\n- `Number`: Angka bulat maupun desimal (`42`, `3.14`).\n- `Boolean`: Nilai logika kebenaran (`true` atau `false`).\n- `Null` & `Undefined`: Ketiadaan nilai sengaja vs variabel yang belum diinisialisasi.\n\n### 3. Operator Perbandingan Ketat (`===` vs `==`)\nSelalu gunakan `===` (Strict Equality) untuk memeriksa nilai sekaligus tipe datanya. Hindari `==` yang melakukan konversi tipe secara implisit dan berbahaya.",
            'use_image' => false,
            'use_audio' => false,
            'use_video' => false,
            'order' => $orderJs++,
        ]);

        // Bab 2: Struktur Kontrol Logika: Percabangan & Perulangan
        CourseStory::create([
            'course_id' => $courseJs->id,
            'title' => 'Bab 2: Struktur Kontrol: Percabangan Logika & Perulangan Dinamis',
            'content' => "Komputer mengambil keputusan berdasarkan kondisi logika tertentu.\n\n### 1. Percabangan if - else if - else & Ternary Operator:\n```javascript\nconst nilaiUjian = 85;\n\n// Cara standar\nif (nilaiUjian >= 80) {\n    console.log('Lulus dengan Predikat A');\n} else {\n    console.log('Perlu remedial');\n}\n\n// Cara ringkas (Ternary Operator)\nconst status = (nilaiUjian >= 70) ? 'LULUS' : 'REMEDIAL';\n```\n\n### 2. Perulangan Modern `for...of`:\nUntuk menelusuri isi array tanpa perlu pusing dengan index `i++`:\n```javascript\nconst daftarBahasa = ['HTML', 'CSS', 'JavaScript'];\nfor (const bahasa of daftarBahasa) {\n    console.log('Materi:', bahasa);\n}\n```",
            'use_image' => false,
            'use_audio' => false,
            'use_video' => false,
            'order' => $orderJs++,
        ]);

        // Bab 3: Fungsi Modern, Arrow Function & Destructuring
        CourseStory::create([
            'course_id' => $courseJs->id,
            'title' => 'Bab 3: Fungsi Modern (Arrow Functions), Parameter Default & Destructuring',
            'content' => "Fungsi adalah blok kode terstruktur yang dapat dipanggil berulang kali.\n\n### 1. Arrow Functions (Fungsi Panah):\n```javascript\n// Sintaks Ringkas dengan Return Implisit\nconst hitungDiskon = (harga, diskon = 0.1) => harga - (harga * diskon);\n\nconsole.log(hitungDiskon(100000)); // 90000\n```\n\n### 2. Destructuring Assignment:\nMemecah properti objek atau array langsung ke dalam variabel terpisah:\n```javascript\nconst siswa = {\n    nama: 'Reza',\n    kota: 'Bandung',\n    jurusan: 'Web Development'\n};\n\nconst { nama, jurusan } = siswa;\nconsole.log(`\${nama} mengambil jurusan \${jurusan}`);\n```",
            'use_image' => false,
            'use_audio' => false,
            'use_video' => false,
            'order' => $orderJs++,
        ]);

        // Bab 4: Manipulasi Array Modern (map, filter, reduce)
        CourseStory::create([
            'course_id' => $courseJs->id,
            'title' => 'Bab 4: Manipulasi Koleksi Data: map, filter, reduce & find',
            'content' => "Metode array fungsional adalah senjata utama pengembang JavaScript modern:\n\n### 1. `map()`: Mengubah setiap elemen menjadi bentuk baru:\n```javascript\nconst angka = [1, 2, 3, 4];\nconst kuadrat = angka.map(n => n * n); // [1, 4, 9, 16]\n```\n\n### 2. `filter()`: Mengambil hanya elemen yang lolos seleksi:\n```javascript\nconst produk = [\n    { nama: 'Laptop', harga: 8000000 },\n    { nama: 'Mouse', harga: 150000 },\n    { nama: 'Keyboard', harga: 450000 }\n];\nconst barangMurah = produk.filter(p => p.harga < 500000);\n```\n\n### 3. `reduce()`: Menghitung total nilai gabungan:\n```javascript\nconst totalHarga = produk.reduce((total, p) => total + p.harga, 0);\n```",
            'use_image' => false,
            'use_audio' => false,
            'use_video' => false,
            'order' => $orderJs++,
        ]);

        // Bab 5: Manipulasi DOM & Event Listener
        CourseStory::create([
            'course_id' => $courseJs->id,
            'title' => 'Bab 5: Interaktivitas DOM: Seleksi Elemen, Event Listener & State Visual',
            'content' => "DOM (**Document Object Model**) adalah representasi pohon objek dari dokumen HTML yang memungkinkan JavaScript membaca dan memodifikasi halaman web secara langsung.\n\n### 1. Memilih Elemen (`querySelector`)\n```javascript\nconst tombol = document.querySelector('#btn-proses');\nconst kotakPesan = document.querySelector('.alert-box');\n```\n\n### 2. Mendengarkan Interaksi Pengguna (`addEventListener`)\n```javascript\ntombol.addEventListener('click', (event) => {\n    event.preventDefault();\n    kotakPesan.classList.toggle('active');\n    kotakPesan.textContent = 'Permintaan Anda sedang diproses...';\n});\n```\n\n### 3. Memanipulasi Class CSS:\n- `classList.add('aktif')`: Menambahkan kelas tampilan.\n- `classList.remove('aktif')`: Menghapus kelas tampilan.\n- `classList.toggle('aktif')`: Beralih antara ada atau tiada.",
            'use_image' => false,
            'use_audio' => false,
            'use_video' => false,
            'order' => $orderJs++,
        ]);

        // Bab 6 (HTML Live Preview): Mini App Todo List Interaktif
        CourseHtml::create([
            'course_id' => $courseJs->id,
            'title' => 'Live Demo: Aplikasi Mini Catatan Tugas (Todo List) Dinamis',
            'content' => 'Simulasi aplikasi catatan tugas (Todo List) lengkap dengan penambahan item instan, pencoretan tugas selesai, dan kalkulasi otomatis jumlah tugas.',
            'html_code' => '<div class="todo-app">
    <div class="todo-header">
        <span class="badge">DOM MANIPULATION APP</span>
        <h2>Daftar Target Harian</h2>
        <p>Tambahkan dan selesaikan target belajar coding harian Anda.</p>
    </div>

    <div class="input-row">
        <input type="text" id="todoInput" placeholder="Ketik tugas baru (contoh: Belajar Flexbox)..." class="todo-input">
        <button id="addBtn" class="btn-add" onclick="tambahTugas()">+ Tambah</button>
    </div>

    <ul id="todoList" class="todo-items">
        <li class="todo-item done" onclick="toggleTugas(this)">
            <span class="check-box">✔</span>
            <span class="todo-text">Selesaikan Modul HTML5 Semantik</span>
        </li>
        <li class="todo-item" onclick="toggleTugas(this)">
            <span class="check-box"></span>
            <span class="todo-text">Latihan Membuat Flexbox Navigation</span>
        </li>
    </ul>

    <div class="todo-footer">
        <span id="taskCounter">Total 2 tugas tercatat</span>
        <button class="btn-clear" onclick="hapusSelesai()">Bersihkan yang Selesai</button>
    </div>
</div>',
            'css_code' => '.todo-app { max-width: 480px; margin: 30px auto; background: #0b132b; border: 1px solid #1e293b; border-radius: 20px; padding: 28px; color: #fff; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; box-shadow: 0 20px 40px rgba(0,0,0,0.5); }
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
.btn-clear:hover { text-decoration: underline; }',
            'js_code' => 'function tambahTugas() {
    const input = document.getElementById("todoInput");
    const list = document.getElementById("todoList");
    if(!input || !input.value.trim()) return;

    const li = document.createElement("li");
    li.className = "todo-item";
    li.onclick = function() { toggleTugas(this); };
    li.innerHTML = "<span class=\"check-box\"></span><span class=\"todo-text\">" + input.value.trim() + "</span>";
    list.appendChild(li);
    input.value = "";
    updateCount();
}

function toggleTugas(el) {
    el.classList.toggle("done");
    const check = el.querySelector(".check-box");
    if(check) {
        check.innerText = el.classList.contains("done") ? "✔" : "";
    }
}

function hapusSelesai() {
    const dones = document.querySelectorAll(".todo-item.done");
    dones.forEach(item => item.remove());
    updateCount();
}

function updateCount() {
    const count = document.querySelectorAll(".todo-item").length;
    const el = document.getElementById("taskCounter");
    if(el) el.innerText = "Total " + count + " tugas tercatat";
}',
            'order' => $orderJs++,
        ]);

        // Bab 7: Asynchronous, Promises & Fetch API
        CourseStory::create([
            'course_id' => $courseJs->id,
            'title' => 'Bab 7: Asynchronous JavaScript: Promise, Async/Await & Mengambil Data API',
            'content' => "Dunia web bekerja secara dinamis dengan berkomunikasi ke server database backend.\n\n### 1. Mengapa Perlu Asynchronous?\nOperasi seperti mengambil data dari internet membutuhkan waktu jaringan beberapa milidetik hingga detik. Jika dieksekusi secara sinkronus biasa, seluruh halaman web akan membeku (*freeze*). Mekanisme Asynchronous memungkinkan browser tetap responsif selagi data diunduh di latar belakang.\n\n### 2. Standar Modern: `async` dan `await`\n```javascript\nasync function dapatkanKursusTerbaru() {\n    try {\n        const response = await fetch('/api/v1/courses');\n        if (!response.ok) {\n            throw new Error('Jaringan mengalami gangguan');\n        }\n        const data = await response.json();\n        console.log('Kursus diterima:', data);\n        return data;\n    } catch (error) {\n        console.error('Gagal mengambil data:', error.message);\n    }\n}\n```\nDengan `try...catch`, penanganan galat (*error handling*) menjadi sangat jelas dan aman.",
            'use_image' => false,
            'use_audio' => false,
            'use_video' => false,
            'order' => $orderJs++,
        ]);

        // Soal Kuis JavaScript (4 Soal Variatif)
        CourseQuestion::create([
            'course_id' => $courseJs->id,
            'question_type' => 'question',
            'title' => 'Perbedaan Sifat Antara let dan const',
            'content' => "Dalam penulisan kode JavaScript standar ES6+, apakah perbedaan mendasar dalam hal penetapan ulang nilai antara variabel `let` dan `const`?",
            'options' => [
                'Variabel const dapat di-reassign berkali-kali, sedangkan let nilainya permanen',
                'Variabel let dapat di-reassign nilainya, sedangkan const referensinya permanen dan tidak dapat di-reassign',
                'Keduanya sama persis dan hanya perbedaan gaya penulisan sintaks',
                'Variabel const hanya dapat menyimpan nilai berupa angka desimal'
            ],
            'correct_answer' => 'Variabel let dapat di-reassign nilainya, sedangkan const referensinya permanen dan tidak dapat di-reassign',
            'hint' => 'let untuk nilai yang berubah-ubah, const untuk nilai yang konstan.',
            'order' => $orderJs++,
        ]);

        CourseQuestion::create([
            'course_id' => $courseJs->id,
            'question_type' => 'question',
            'title' => 'Metode Array untuk Akumulasi Total Nilai',
            'content' => "Metode array JavaScript manakah yang paling tepat digunakan untuk mengolah deretan nilai objek (misalnya daftar harga barang belanjaan) menjadi satu nilai akumulasi tunggal berupa grand total biaya?",
            'options' => [
                'Array.map()',
                'Array.reduce()',
                'Array.filter()',
                'Array.some()'
            ],
            'correct_answer' => 'Array.reduce()',
            'hint' => 'Berasal dari kata reduce (mengurangi/meringkas kumpulan nilai menjadi satu).',
            'order' => $orderJs++,
        ]);

        CourseQuestion::create([
            'course_id' => $courseJs->id,
            'question_type' => 'question',
            'title' => 'Metode Menambah/Menghapus Class CSS secara Toggle',
            'content' => "Method pada properti `classList` elemen DOM manakah yang secara cerdas akan menambahkan class CSS jika belum ada, atau menghapusnya jika class tersebut sudah ada pada elemen?",
            'options' => [
                'classList.switch()',
                'classList.toggle()',
                'classList.replace()',
                'classList.invert()'
            ],
            'correct_answer' => 'classList.toggle()',
            'hint' => 'Seperti saklar lampu bolak-balik (toggle).',
            'order' => $orderJs++,
        ]);

        CourseQuestion::create([
            'course_id' => $courseJs->id,
            'question_type' => 'question',
            'title' => 'Fungsi Method response.json() pada Fetch API',
            'content' => "Pada saat kita memanggil data server menggunakan `fetch()`, mengapa kita perlu memanggil perintah `await response.json()`?",
            'options' => [
                'Untuk mengompres file HTML menjadi format zip',
                'Untuk mengonversi aliran data respons HTTP (stream) menjadi objek JavaScript yang dapat diakses',
                'Untuk menghapus cache memori lokal browser pengguna',
                'Untuk menutup koneksi internet setelah data terkirim'
            ],
            'correct_answer' => 'Untuk mengonversi aliran data respons HTTP (stream) menjadi objek JavaScript yang dapat diakses',
            'hint' => 'Parsing teks format JSON menjadi Objek/Array JavaScript.',
            'order' => $orderJs++,
        ]);

        // Coding Challenge JS 1: Hitung Diskon Belanja Otomatis
        CourseQuestion::create([
            'course_id' => $courseJs->id,
            'question_type' => 'coding',
            'title' => 'Tantangan Coding: Kalkulator Diskon Belanja Pelanggan',
            'content' => "Sebuah toko online memberikan aturan promo otomatis bagi pelanggan:\n- Jika total belanja lebih besar dari atau sama dengan Rp 100.000, pelanggan berhak mendapatkan diskon sebesar 10%.\n- Jika di bawah Rp 100.000, pelanggan membayar harga normal tanpa diskon.\n\n### Instruksi:\nBuatlah program JavaScript yang membaca 1 baris input angka total belanja (integer/float), lalu hitung dan cetak harga akhir yang harus dibayarkan pelanggan dalam format angka bulat (Math.round).\n\nContoh Input:\n`150000`\n\nKalkulasi: `150000 - (150000 * 0.10) = 135000`\n\nContoh Output:\n`135000`",
            'language' => 'javascript',
            'starter_code' => "const readline = require('readline');
const rl = readline.createInterface({ input: process.stdin, output: process.stdout });

rl.on('line', (line) => {
    const total = parseFloat(line.trim());
    let finalPrice = total;
    
    if (total >= 100000) {
        finalPrice = total - (total * 0.10);
    }
    
    console.log(Math.round(finalPrice));
    process.exit(0);
});",
            'expected_output' => '135000',
            'test_cases' => [
                [
                    'input' => '150000',
                    'expected_output' => '135000'
                ],
                [
                    'input' => '80000',
                    'expected_output' => '80000'
                ],
                [
                    'input' => '200000',
                    'expected_output' => '180000'
                ]
            ],
            'coding_rules' => ['console_log', 'if_statement'],
            'hint' => 'Gunakan percabangan if (total >= 100000) dan hitung potongannya.',
            'order' => $orderJs++,
        ]);

        // Coding Challenge JS 2: Filter Data Angka Genap
        CourseQuestion::create([
            'course_id' => $courseJs->id,
            'question_type' => 'coding',
            'title' => 'Tantangan Coding: Filter Angka Genap Array',
            'content' => "Buatlah program JavaScript yang membaca deretan angka yang dipisahkan dengan spasi, lalu cetak hanya angka yang bernilai genap saja, dipisahkan oleh spasi.\n\nContoh Input:\n`1 2 3 4 5 6 7 8`\n\nContoh Output:\n`2 4 6 8`",
            'language' => 'javascript',
            'starter_code' => "const readline = require('readline');
const rl = readline.createInterface({ input: process.stdin, output: process.stdout });

rl.on('line', (line) => {
    const numbers = line.trim().split(/\\s+/).map(Number);
    const evens = numbers.filter(n => n % 2 === 0);
    console.log(evens.join(' '));
    process.exit(0);
});",
            'expected_output' => '2 4 6 8',
            'test_cases' => [
                [
                    'input' => '1 2 3 4 5 6 7 8',
                    'expected_output' => '2 4 6 8'
                ],
                [
                    'input' => '10 15 20 25 30',
                    'expected_output' => '10 20 30'
                ]
            ],
            'coding_rules' => ['console_log', 'filter_map'],
            'hint' => 'Gunakan .filter(n => n % 2 === 0) dan gabungkan dengan .join(" ")',
            'order' => $orderJs++,
        ]);


        // =========================================================================
        // 4. MODUL DOKUMENTASI LENGKAP & SISTEMATIS (HTML, CSS, JS)
        // =========================================================================

        // --- KATEGORI 1: DOKUMENTASI HTML5 ---
        $catHtml = ModuleCategory::create([
            'name' => 'Modul Dokumentasi HTML5 Komprehensif',
            'slug' => 'modul-html5-komprehensif',
            'description' => 'Buku saku dan panduan lengkap referensi standar HTML5 semantik, optimasi SEO, pembuatan formulir interaktif, tabel data, serta integrasi multimedia.',
            'is_public' => true,
            'icon' => 'fab fa-html5',
            'color' => '#f97316',
            'badge' => 'Fondasi Web',
            'order' => 1,
            'is_active' => true,
        ]);

        Module::create([
            'category_id' => $catHtml->id,
            'section' => '1. FONDASI & ANATOMI',
            'title' => 'Anatomi Dokumen HTML5 & Metadata Head',
            'slug' => 'anatomi-dokumen-html5-dan-metadata',
            'content_type' => 'document',
            'excerpt' => 'Mengenal struktur doctype, elemen root, meta viewport, charset, dan penataan body.',
            'content' => "# Anatomi Dokumen HTML5 & Metadata Head\n\nSetiap halaman web modern berstandar W3C dibangun dengan pondasi dasar berikut:\n\n```html:index.html\n<!DOCTYPE html>\n<html lang=\"id\">\n<head>\n    <meta charset=\"UTF-8\">\n    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">\n    <meta name=\"description\" content=\"Panduan belajar web development terlengkap di TalentGroup\">\n    <title>Dokumentasi HTML5 Standar</title>\n</head>\n<body>\n    <header>\n        <h1>Portal Pembelajaran HTML5</h1>\n    </header>\n    <main>\n        <p>Konten utama aplikasi berada di sini.</p>\n    </main>\n</body>\n</html>\n```\n\n> [!NOTE]\n> Tag `<meta name=\"viewport\">` merupakan keharusan mutlak agar layout website menyesuaikan skala layar ponsel secara proporsional.",
            'order' => 1,
            'is_published' => true,
            'is_public' => true,
        ]);

        Module::create([
            'category_id' => $catHtml->id,
            'section' => '2. TIPOGRAFI & TAUTAN',
            'title' => 'Hierarki Heading, Paragraf & Tautan Aman',
            'slug' => 'hierarki-heading-paragraf-dan-tautan',
            'content_type' => 'document',
            'excerpt' => 'Panduan penataan heading h1-h6 yang SEO-friendly dan tautan rel noopener noreferrer.',
            'content' => "# Hierarki Heading, Paragraf & Tautan Aman\n\n### 1. Aturan Emas Heading:\n- Gunakan hanya **satu tag `<h1>`** per halaman sebagai tajuk utama.\n- Gunakan `<h2>` sampai `<h6>` secara hierarkis bertingkat tanpa melompati level.\n\n### 2. Tautan Aman dengan Tab Baru:\n```html:link-aman.html\n<a href=\"https://talentgroup.id\" target=\"_blank\" rel=\"noopener noreferrer\">\n    Kunjungi Website Resmi\n</a>\n```\nAtribut `rel=\"noopener noreferrer\"` melindungi halaman web dari celah manipulasi objek `window.opener`.",
            'order' => 2,
            'is_published' => true,
            'is_public' => true,
        ]);

        Module::create([
            'category_id' => $catHtml->id,
            'section' => '3. FORMULIR & VALIDASI',
            'title' => 'Formulir Interaktif & Kontrol Validasi Bawaan',
            'slug' => 'formulir-interaktif-dan-kontrol-validasi',
            'content_type' => 'document',
            'excerpt' => 'Pembuatan form input teks, email, kata sandi, dropdown select, dan atribut required.',
            'content' => "# Formulir Interaktif & Kontrol Validasi Bawaan\n\nFormulir HTML5 mampu memvalidasi data pengguna langsung di browser sebelum data dikirim ke server:\n\n```html:form-login.html\n<form action=\"/api/auth/login\" method=\"POST\">\n    <div class=\"input-group\">\n        <label for=\"email\">Email Perusahaan:</label>\n        <input type=\"email\" id=\"email\" name=\"email\" required placeholder=\"nama@perusahaan.com\">\n    </div>\n    <div class=\"input-group\">\n        <label for=\"password\">Kata Sandi:</label>\n        <input type=\"password\" id=\"password\" name=\"password\" required minlength=\"8\">\n    </div>\n    <button type=\"submit\">Masuk ke Akun</button>\n</form>\n```\n\n> [!TIP]\n> Gunakan atribut `autocomplete=\"off\"` jika field memuat data rahasia seperti nomor PIN.",
            'order' => 3,
            'is_published' => true,
            'is_public' => true,
        ]);

        Module::create([
            'category_id' => $catHtml->id,
            'section' => '4. SEMANTIK & SEO',
            'title' => 'Arsitektur Semantik: Header, Nav, Main & Footer',
            'slug' => 'arsitektur-semantik-header-nav-main-footer',
            'content_type' => 'document',
            'excerpt' => 'Menghilangkan kebiasaan div-soup dan menerapkan standar semantik ramah mesin pencari Google.',
            'content' => "# Arsitektur Semantik: Header, Nav, Main & Footer\n\nElemen semantik secara eksplisit mendeskripsikan peran masing-masing bagian halaman:\n\n- `<header>`: Pengantar atau kumpulan menu navigasi atas.\n- `<nav>`: Kumpulan tautan navigasi utama.\n- `<main>`: Area konten unik tunggal pada halaman.\n- `<article>`: Bagian tulisan mandiri (berita, tutorial, postingan).\n- `<aside>`: Sidebar pendukung atau tautan artikel terkait.\n- `<footer>`: Catatan penutup dokumen hak cipta.",
            'order' => 4,
            'is_published' => true,
            'is_public' => true,
        ]);


        // --- KATEGORI 2: DOKUMENTASI CSS3 ---
        $catCss = ModuleCategory::create([
            'name' => 'Modul Dokumentasi CSS3 & Tata Letak Modern',
            'slug' => 'modul-css3-dan-layout-modern',
            'description' => 'Panduan komprehensif penataan antarmuka web modern dengan Universal Box Model, Flexbox satu dimensi, CSS Grid dua dimensi, tipografi cairan, dan animasi mikro.',
            'is_public' => true,
            'icon' => 'fab fa-css3-alt',
            'color' => '#38bdf8',
            'badge' => 'Desain Web',
            'order' => 2,
            'is_active' => true,
        ]);

        Module::create([
            'category_id' => $catCss->id,
            'section' => '1. BOX MODEL & RESET',
            'title' => 'Universal Box-Sizing & CSS Reset Standar',
            'slug' => 'universal-box-sizing-dan-css-reset',
            'content_type' => 'document',
            'excerpt' => 'Mencegah kerusakan tata letak akibat padding dan border dengan reset border-box.',
            'content' => "# Universal Box-Sizing & CSS Reset Standar\n\nSelalu pasang reset universal di baris teratas stylesheet Anda:\n\n```css:reset.css\n*, *::before, *::after {\n    box-sizing: border-box;\n    margin: 0;\n    padding: 0;\n}\n```\n\n### Perbedaan Karakteristik:\n- **content-box**: Nilai `width` hanya menghitung isi konten. Padding dan border akan membuat kotak melebar melebihi ukuran yang ditentukan.\n- **border-box**: Nilai `width` sudah merangkum konten, padding, dan border secara terpadu dan presisi.",
            'order' => 1,
            'is_published' => true,
            'is_public' => true,
        ]);

        Module::create([
            'category_id' => $catCss->id,
            'section' => '2. TATA LETAK FLEXBOX',
            'title' => 'Panduan Praktis Flexbox 1 Dimensi',
            'slug' => 'panduan-praktis-flexbox-satu-dimensi',
            'content_type' => 'document',
            'excerpt' => 'Mengatur navigasi, perataan horizontal & vertikal dengan justify-content, align-items, dan gap.',
            'content' => "# Panduan Praktis Flexbox 1 Dimensi\n\nFlexbox dirancang khusus untuk membagi ruang dan meratakan elemen di sepanjang satu dimensi (baris atau kolom):\n\n```css:navbar.css\n.navbar-container {\n    display: flex;\n    justify-content: space-between;\n    align-items: center;\n    gap: 20px;\n    padding: 16px 32px;\n}\n\n.nav-menu {\n    display: flex;\n    gap: 16px;\n    list-style: none;\n}\n```\n\n> [!TIP]\n> Gunakan properti `gap` alih-alih memberikan `margin-right` pada setiap elemen anak.",
            'order' => 2,
            'is_published' => true,
            'is_public' => true,
        ]);

        Module::create([
            'category_id' => $catCss->id,
            'section' => '3. TATA LETAK CSS GRID',
            'title' => 'Arsitektur CSS Grid 2 Dimensi Responsif',
            'slug' => 'arsitektur-css-grid-dua-dimensi-responsif',
            'content_type' => 'document',
            'excerpt' => 'Membuat galeri kartu responsif otomatis tanpa media query dengan repeat, auto-fit, dan minmax.',
            'content' => "# Arsitektur CSS Grid 2 Dimensi Responsif\n\nCSS Grid mampu mengendalikan baris dan kolom secara simultan:\n\n```css:grid-layout.css\n.cards-wrapper {\n    display: grid;\n    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));\n    gap: 24px;\n}\n```\n\nKode di atas secara cerdas mengubah susunan 4 kolom di monitor desktop menjadi 2 kolom di tablet dan 1 kolom di smartphone secara instan tanpa menulis satu baris pun `@media query`!",
            'order' => 3,
            'is_published' => true,
            'is_public' => true,
        ]);

        Module::create([
            'category_id' => $catCss->id,
            'section' => '4. VARIABEL & ANIMASI',
            'title' => 'CSS Custom Properties (Variabel) & Transisi Halus',
            'slug' => 'css-custom-properties-dan-transisi',
            'content_type' => 'document',
            'excerpt' => 'Membangun sistem tema Dark/Light mode menggunakan variabel CSS dan transisi interaksi hover.',
            'content' => "# CSS Custom Properties (Variabel) & Transisi Halus\n\n```css:theme.css\n:root {\n    --primary-color: #0284c7;\n    --surface-bg: #0f172a;\n    --text-color: #f8fafc;\n}\n\n.action-btn {\n    background-color: var(--primary-color);\n    color: var(--text-color);\n    padding: 12px 24px;\n    border-radius: 8px;\n    transition: transform 0.2s ease, opacity 0.2s ease;\n}\n\n.action-btn:hover {\n    transform: translateY(-3px);\n    opacity: 0.9;\n}\n```",
            'order' => 4,
            'is_published' => true,
            'is_public' => true,
        ]);


        // --- KATEGORI 3: DOKUMENTASI JAVASCRIPT ---
        $catJs = ModuleCategory::create([
            'name' => 'Modul Dokumentasi JavaScript ES6+ & DOM',
            'slug' => 'modul-javascript-es6-dan-dom',
            'description' => 'Buku panduan lengkap logika pemrograman web modern, manipulasi pohon elemen DOM, pengolahan array fungsional (map, filter, reduce), dan integrasi Asynchronous Fetch API.',
            'is_public' => true,
            'icon' => 'fab fa-js-square',
            'color' => '#facc15',
            'badge' => 'Logika Web',
            'order' => 3,
            'is_active' => true,
        ]);

        Module::create([
            'category_id' => $catJs->id,
            'section' => '1. SINTAKS ES6+ MODERN',
            'title' => 'Variabel, Scope, Arrow Functions & Destructuring',
            'slug' => 'variabel-scope-arrow-functions-destructuring',
            'content_type' => 'document',
            'excerpt' => 'Aturan pemilihan let vs const, penulisan fungsi panah ringkas, dan ekstraksi properti objek.',
            'content' => "# Variabel, Scope, Arrow Functions & Destructuring\n\n```javascript:es6-syntax.js\n// 1. Destructuring Objek\nconst profil = { nama: 'Fajar', jabatan: 'Frontend Lead', lokasi: 'Jakarta' };\nconst { nama, jabatan } = profil;\n\n// 2. Arrow Functions Ringkas\nconst kalikan = (a, b) => a * b;\n\n// 3. Template Literals\nconsole.log(`Halo \${nama}, jabatan Anda saat ini: \${jabatan}`);\n```\n\n> [!IMPORTANT]\n> Selalu gunakan `const` kecuali jika nilai variabel tersebut memang direncanakan untuk diubah nilainya.",
            'order' => 1,
            'is_published' => true,
            'is_public' => true,
        ]);

        Module::create([
            'category_id' => $catJs->id,
            'section' => '2. PENGOLAHAN ARRAY',
            'title' => 'Kekuatan Metode Array Fungsional: map, filter & reduce',
            'slug' => 'metode-array-map-filter-reduce',
            'content_type' => 'document',
            'excerpt' => 'Transformasi data koleksi secara deklaratif tanpa perulangan tradisional.',
            'content' => "# Kekuatan Metode Array Fungsional: map, filter & reduce\n\n```javascript:array-ops.js\nconst produk = [\n    { id: 1, nama: 'Buku HTML', harga: 50000, stok: 10 },\n    { id: 2, nama: 'Buku CSS', harga: 60000, stok: 0 },\n    { id: 3, nama: 'Buku JS', harga: 75000, stok: 5 }\n];\n\n// 1. Filter: Hanya produk yang tersedia stoknya\nconst tersedia = produk.filter(p => p.stok > 0);\n\n// 2. Map: Format nama dan harga\nconst labelHarga = tersedia.map(p => `\${p.nama} - Rp \${p.harga}`);\n\n// 3. Reduce: Hitung total nilai stok\nconst totalAset = produk.reduce((total, p) => total + (p.harga * p.stok), 0);\n```",
            'order' => 2,
            'is_published' => true,
            'is_public' => true,
        ]);

        Module::create([
            'category_id' => $catJs->id,
            'section' => '3. MANIPULASI DOM',
            'title' => 'Event Listener & Manipulasi DOM Interaktif',
            'slug' => 'event-listener-dan-manipulasi-dom-interaktif',
            'content_type' => 'document',
            'excerpt' => 'Menghubungkan interaksi tombol pengguna untuk merubah elemen dan tampilan secara instan.',
            'content' => "# Event Listener & Manipulasi DOM Interaktif\n\n```javascript:interaksi.js\nconst btnSubmit = document.querySelector('#btnKirim');\nconst statusBox = document.querySelector('.status-box');\n\nbtnSubmit.addEventListener('click', (event) => {\n    event.preventDefault();\n    statusBox.classList.add('aktif');\n    statusBox.textContent = 'Data pendaftaran berhasil diverifikasi!';\n});\n```\n\n> [!NOTE]\n> Panggil `event.preventDefault()` pada penanganan event submit form agar peramban tidak me-refresh seluruh halaman web.",
            'order' => 3,
            'is_published' => true,
            'is_public' => true,
        ]);

        Module::create([
            'category_id' => $catJs->id,
            'section' => '4. ASYNCHRONOUS & API',
            'title' => 'Asynchronous JavaScript: Promise, Async/Await & Fetch API',
            'slug' => 'asynchronous-promise-async-await-fetch',
            'content_type' => 'document',
            'excerpt' => 'Mengambil dan menampilkan data JSON dari RESTful API server backend secara mulus.',
            'content' => "# Asynchronous JavaScript: Promise, Async/Await & Fetch API\n\n```javascript:fetch-api.js\nasync function muatDataPengguna() {\n    try {\n        const response = await fetch('https://api.talentgroup.id/v1/users');\n        if (!response.ok) {\n            throw new Error(`Koneksi HTTP Error: \${response.status}`);\n        }\n        const users = await response.json();\n        console.log(`Berhasil memuat \${users.length} data pengguna.`);\n        return users;\n    } catch (error) {\n        console.error('Terjadi kendala:', error.message);\n    }\n}\n```",
            'order' => 4,
            'is_published' => true,
            'is_public' => true,
        ]);

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
