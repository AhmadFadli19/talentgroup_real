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
     * Run the database seeds for HTML, CSS, and JavaScript courses & modules.
     */
    public function run(): void
    {
        // Pastikan admin user ada sebagai pembuat kursus
        $admin = User::first();
        $adminId = $admin ? $admin->id : 1;

        // Bersihkan data dummy kursus lama agar rapi dan fokus
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Hapus kursus dan child tables
        CourseStory::truncate();
        CourseHtml::truncate();
        CourseQuestion::truncate();
        CourseVideo::truncate();
        Course::truncate();

        // =========================================================================
        // 1. COURSE HTML: Pemrograman Web: HTML5 Modern & Semantik
        // =========================================================================
        $courseHtml = Course::create([
            'title' => 'A01 - Pemrograman Web: HTML5 Modern & Semantik',
            'description' => 'Pelajari fondasi utama pembangunan website modern menggunakan standar HTML5 semantik, optimasi SEO, formulir interaktif dengan validasi komprehensif, struktur tabel, hingga integrasi multimedia.',
            'price' => 0.00, // Kursus Fondasi GRATIS
            'image' => null,
            'is_active' => true,
            'quiz_answer_visibility' => 'end', // Kunci jawaban ditampilkan setelah selesai
            'quiz_navigation_mode' => 'free',
            'shuffle_questions' => true,
            'shuffle_options' => true,
            'created_by' => $adminId,
        ]);

        // Materi 1 (Story): Anatomi & Doctype Dokumen HTML5
        CourseStory::create([
            'course_id' => $courseHtml->id,
            'title' => 'Anatomi & Struktur Dokumen HTML5 Standar',
            'content' => "Selamat datang di modul perdana HTML5! HyperText Markup Language (HTML) adalah bahasa penanda standar yang menjadi tulang punggung dari seluruh halaman di internet.\n\n### 1. Deklarasi Dokumen <!DOCTYPE html>\nPada era HTML lama (HTML4), deklarasi doctype sangat panjang dan rumit. Pada HTML5, deklarasi disederhanakan menjadi:\n```html\n<!DOCTYPE html>\n```\nInstruksi ini memberi sinyal kepada mesin peramban (browser) untuk merender halaman dalam mode standar (standards mode), mencegah browser beralih ke mode kompatibilitas kuno (quirks mode).\n\n### 2. Elemen Akar & Metadata Head\n- `<html lang=\"id\">`: Menentukan bahasa konten untuk mesin pencari dan pembaca layar (screen reader).\n- `<meta charset=\"UTF-8\">`: Menetapkan pengkodean karakter universal agar mendukung berbagai karakter alfabet dan simbol dunia.\n- `<meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">`: Elemen krusial agar tampilan website dapat menyesuaikan lebar layar perangkat seluler secara responsif.\n\n### 3. Bagian Body\nSemua konten visual yang dapat dilihat dan berinteraksi langsung dengan pengguna (teks, gambar, tombol, formulir) diletakkan di dalam tag `<body>`.",
            'use_image' => false,
            'use_audio' => false,
            'use_video' => false,
            'order' => 1,
        ]);

        // Materi 2 (Story): Elemen Semantik Modern & SEO
        CourseStory::create([
            'course_id' => $courseHtml->id,
            'title' => 'Elemen Semantik & Optimasi Mesin Pencari (SEO)',
            'content' => "Sebelum HTML5, pengembang web terbiasa membungkus setiap bagian dengan tag `<div>` yang tidak bermakna (dikenal sebagai istilah 'div-soup'), misalnya `<div class=\"header\">` atau `<div id=\"footer\">`.\n\n### Mengapa Elemen Semantik Sangat Penting?\nElemen semantik secara jelas mendeskripsikan maknanya kepada browser, mesin pencari (Googlebot), dan teknologi bantu disabilitas (Screen Reader):\n\n1. `<header>`: Mewakili pengantar atau grup tautan navigasi pembuka halaman/artikel.\n2. `<nav>`: Bagian khusus yang memuat tautan navigasi utama website.\n3. `<main>`: Memuat konten unik dominan pada dokumen. Hanya boleh ada satu tag `<main>` per halaman!\n4. `<section>`: Pengelompokan tematik konten yang umumnya memiliki judul tersendiri (heading).\n5. `<article>`: Bagian mandiri yang dapat didistribusikan secara independen (contoh: postingan blog, berita, komentar).\n6. `<aside>`: Konten pendukung seperti sidebar, tautan terkait, atau iklan.\n7. `<footer>`: Catatan penutup dokumen yang memuat hak cipta, kontak, dan tautan sosial media.\n\nDengan menerapkan semantik, website Anda mendapatkan peringkat SEO yang jauh lebih unggul karena mesin pencari memahami struktur hierarki informasi secara presisi.",
            'use_image' => false,
            'use_audio' => false,
            'use_video' => false,
            'order' => 2,
        ]);

        // Materi 3 (HTML Live Preview): Halaman Profil Semantik Interaktif
        CourseHtml::create([
            'course_id' => $courseHtml->id,
            'title' => 'Live Demo: Layout Portofolio Semantik HTML5',
            'content' => 'Pelajari implementasi nyata susunan tag semantik HTML5 di bawah ini. Elemen-elemen ini telah diatur dengan tata letak modern yang bersih dan responsif.',
            'html_code' => '<div class="profile-container">
    <header class="main-header">
        <span class="badge">PROFIL PENGEMBANG</span>
        <h1>Ahmad Fauzi Pratama</h1>
        <p class="subtitle">Full-Stack Web Developer & UI/UX Enthusiast</p>
    </header>

    <main class="content-body">
        <section class="card">
            <h3>Tentang Saya</h3>
            <p>Berpengalaman lebih dari 4 tahun dalam merancang antarmuka web yang cepat, responsif, dan ramah aksesibilitas.</p>
        </section>

        <section class="card">
            <h3>Keahlian Utama</h3>
            <div class="skills">
                <span class="skill-tag">HTML5 Semantik</span>
                <span class="skill-tag">CSS3 Grid & Flexbox</span>
                <span class="skill-tag">JavaScript Modern</span>
                <span class="skill-tag">RESTful API</span>
            </div>
        </section>
    </main>

    <footer class="footer-note">
        <p>&copy; 2026 TalentGroup Academy. Dokumen standar HTML5.</p>
    </footer>
</div>',
            'css_code' => '.profile-container { max-width: 650px; margin: 30px auto; padding: 25px; background: #0f172a; color: #f8fafc; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; border-radius: 16px; border: 1px solid #334155; box-shadow: 0 10px 30px rgba(0,0,0,0.5); }
.main-header { text-align: center; border-bottom: 1px solid #1e293b; padding-bottom: 20px; }
.badge { display: inline-block; padding: 4px 10px; font-size: 11px; font-weight: 700; color: #38bdf8; background: rgba(56, 189, 248, 0.1); border: 1px solid rgba(56, 189, 248, 0.25); border-radius: 20px; margin-bottom: 10px; }
.main-header h1 { margin: 6px 0; font-size: 24px; font-weight: 800; color: #fff; }
.subtitle { color: #94a3b8; font-size: 13px; margin: 0; }
.content-body { display: flex; flex-direction: column; gap: 14px; margin: 20px 0; }
.card { background: #1e293b; padding: 16px 20px; border-radius: 12px; border: 1px solid #334155; }
.card h3 { margin: 0 0 8px 0; font-size: 14px; color: #38bdf8; }
.card p { margin: 0; font-size: 12px; line-height: 1.6; color: #cbd5e1; }
.skills { display: flex; flex-wrap: wrap; gap: 8px; }
.skill-tag { background: #0f172a; color: #38bdf8; border: 1px solid #38bdf8; padding: 4px 10px; border-radius: 6px; font-size: 11px; font-weight: 600; }
.footer-note { text-align: center; border-top: 1px solid #1e293b; padding-top: 15px; font-size: 11px; color: #64748b; }',
            'js_code' => 'console.log("HTML5 Portfolio Demo Loaded Successfully");',
            'order' => 3,
        ]);

        // Materi 4 (Story): Formulir Interaktif & Validasi Input
        CourseStory::create([
            'course_id' => $courseHtml->id,
            'title' => 'Formulir Modern, Kontrol Input & Validasi',
            'content' => "Formulir adalah jembatan utama interaksi dua arah antara pengunjung dengan aplikasi Anda. HTML5 memperkenalkan berbagai tipe kontrol input yang memiliki validasi bawaan tanpa memerlukan kode JavaScript tambahan.\n\n### Tipe Input Populer & Praktis:\n1. `type=\"email\"`: Memastikan pengguna memasukkan format alamat surel yang valid dengan simbol `@`.\n2. `type=\"password\"`: Menyembunyikan karakter kata sandi demi privasi pengguna.\n3. `type=\"number\"`: Hanya mengizinkan karakter angka, didukung atribut `min`, `max`, dan `step`.\n4. `type=\"date\"`: Menampilkan pemilih kalender visual bawaan browser.\n\n### Atribut Pengaman & Validasi Penting:\n- `required`: Mewajibkan field input diisi sebelum tombol submit dapat dieksekusi.\n- `placeholder`: Memberikan petunjuk visual teks bayangan contoh pengisian.\n- `autocomplete=\"off\"`: Mencegah peramban menyimpan data sensitif seperti token atau PIN.\n- `pattern=\"[0-9]{10,12}\"`: Validasi ekspresi reguler (Regex) untuk nomor telepon atau identitas.",
            'use_image' => false,
            'use_audio' => false,
            'use_video' => false,
            'order' => 4,
        ]);

        // Soal 1 (Kuis Pilihan Ganda): Tag Semantik Navigasi
        CourseQuestion::create([
            'course_id' => $courseHtml->id,
            'question_type' => 'question',
            'title' => 'Tag Semantik untuk Navigasi Utama',
            'content' => "Dalam standar penyusunan kode HTML5 yang ramah SEO dan aksesibilitas, manakah elemen semantik yang secara resmi direkomendasikan untuk membungkus daftar menu navigasi utama situs web?",
            'options' => [
                'navbar',
                'nav',
                'navigation',
                'menu'
            ],
            'correct_answer' => 'nav',
            'hint' => 'Elemen ini disingkat menjadi 3 huruf.',
            'order' => 5,
        ]);

        // Soal 2 (Kuis Pilihan Ganda): Meta Viewport
        CourseQuestion::create([
            'course_id' => $courseHtml->id,
            'question_type' => 'question',
            'title' => 'Fungsi Elemen Meta Viewport',
            'content' => "Apakah tujuan utama menyertakan tag `<meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">` pada bagian `<head>` dokumen HTML?",
            'options' => [
                'Mempercepat kecepatan unduhan aset gambar di server',
                'Menghubungkan file lembar gaya CSS eksternal secara otomatis',
                'Mengatur skala lebar layar agar tampilan responsif di berbagai perangkat seluler',
                'Mencegah pengguna melakukan klik kanan pada halaman website'
            ],
            'correct_answer' => 'Mengatur skala lebar layar agar tampilan responsif di berbagai perangkat seluler',
            'hint' => 'Fokus pada kata viewport dan skala ukuran layar smartphone.',
            'order' => 6,
        ]);

        // Soal 3 (Kuis Pilihan Ganda): Atribut Validasi Input
        CourseQuestion::create([
            'course_id' => $courseHtml->id,
            'question_type' => 'question',
            'title' => 'Atribut Wajib Isi pada Formulir HTML',
            'content' => "Atribut HTML5 manakah yang digunakan untuk menandai bahwa suatu elemen formulir wajib diisi oleh pengguna sebelum data formulir dapat dikirim ke server?",
            'options' => [
                'validate',
                'mandatory',
                'required',
                'important'
            ],
            'correct_answer' => 'required',
            'hint' => 'Berasal dari kata kerja bahasa Inggris yang berarti dibutuhkan/diwajibkan.',
            'order' => 7,
        ]);

        // Soal 4 (Coding Challenge JS/Logic): Generator Slug Judul Artikel Web
        CourseQuestion::create([
            'course_id' => $courseHtml->id,
            'question_type' => 'coding',
            'title' => 'Tantangan Logika: Generator URL Slug Halaman HTML',
            'content' => "Dalam pembuatan halaman web, setiap judul artikel HTML harus diubah menjadi format URL ramah SEO (Slug).\n\n### Instruksi:\nBuatlah program JavaScript yang menerima teks judul halaman, lalu ubah seluruh karakter menjadi huruf kecil (lowercase) dan gantikan spasi dengan tanda minus `-`.\n\nContoh Input:\n`Belajar HTML5 Semantik`\n\nContoh Output yang Diharapkan:\n`belajar-html5-semantik`",
            'language' => 'javascript',
            'starter_code' => "const readline = require('readline');
const rl = readline.createInterface({ input: process.stdin, output: process.stdout });

rl.on('line', (line) => {
    const slug = line.trim().toLowerCase().replace(/\\s+/g, '-');
    console.log(slug);
    process.exit(0);
});",
            'expected_output' => 'belajar-html5-semantik',
            'test_cases' => [
                [
                    'input' => 'Belajar HTML5 Semantik',
                    'expected_output' => 'belajar-html5-semantik'
                ],
                [
                    'input' => 'Panduan Form Web Modern',
                    'expected_output' => 'panduan-form-web-modern'
                ]
            ],
            'coding_rules' => ['console_log'],
            'hint' => 'Gunakan metode .toLowerCase() dan .replace(/\\s+/g, "-") lalu cetak dengan console.log()',
            'order' => 8,
        ]);


        // =========================================================================
        // 2. COURSE CSS: Desain Web Modern: CSS3, Flexbox & Responsive Layout
        // =========================================================================
        $courseCss = Course::create([
            'title' => 'A02 - Desain Web Modern: CSS3, Flexbox & Responsive Layout',
            'description' => 'Kuasai seni menata dan mempercantik antarmuka web modern dengan CSS3. Pelajari konsep Box Model mendalam, Flexbox satu dimensi, CSS Grid dua dimensi, custom properties variabel tema, serta desain responsif mobile-first.',
            'price' => 75000.00,
            'image' => null,
            'is_active' => true,
            'quiz_answer_visibility' => 'end',
            'quiz_navigation_mode' => 'free',
            'shuffle_questions' => true,
            'shuffle_options' => true,
            'created_by' => $adminId,
        ]);

        // Materi 1 (Story): Box Model & Box Sizing
        CourseStory::create([
            'course_id' => $courseCss->id,
            'title' => 'Memahami CSS Box Model & Rahasia Box-Sizing',
            'content' => "Setiap elemen yang dirender pada dokumen web pada dasarnya adalah sebuah kotak persegi panjang. Konsep ini dikenal sebagai CSS Box Model.\n\n### 4 Lapisan Utama Box Model:\n1. **Content**: Area inti tempat teks, gambar, atau elemen anak ditampilkan.\n2. **Padding**: Ruang transparan di dalam elemen yang memisahkan konten dari garis tepi (border).\n3. **Border**: Garis tepi pembungkus yang mengelilingi padding dan konten.\n4. **Margin**: Ruang luar transparan yang memisahkan elemen dari elemen tetangga di sekitarnya.\n\n### Masalah `content-box` vs Solusi `border-box`\nSecara default browser menggunakan `box-sizing: content-box`. Artinya jika Anda menetapkan `width: 200px` dan menambahkan `padding: 20px`, total lebar elemen menjadi 240px! Hal ini sering membuat tata letak berantakan.\n\nSolusi standar industri modern adalah menggunakan reset universal:\n```css\n*, *::before, *::after {\n    box-sizing: border-box;\n}\n```\nDengan `border-box`, nilai padding dan border akan dihitung ke dalam total lebar elemen, sehingga dimensi tata letak tetap konsisten dan presisi.",
            'use_image' => false,
            'use_audio' => false,
            'use_video' => false,
            'order' => 1,
        ]);

        // Materi 2 (Story): Flexbox Layout 1 Dimensi
        CourseStory::create([
            'course_id' => $courseCss->id,
            'title' => 'Flexbox Layout: Penataan Satu Dimensi Fleksibel',
            'content' => "Flexbox (Flexible Box Layout) dirancang khusus untuk membagi ruang dan meratakan elemen anak secara konsisten di sepanjang satu dimensi (baik horizontal berupa baris maupun vertikal berupa kolom).\n\n### Properti Penting Kontainer Flex:\n- `display: flex`: Mengaktifkan konteks fleksibel pada elemen kontainer.\n- `flex-direction`: Menentukan arah sumbu utama (`row`, `row-reverse`, `column`, `column-reverse`).\n- `justify-content`: Mengatur perataan item di sepanjang **sumbu utama (main-axis)**: `flex-start`, `center`, `flex-end`, `space-between`, `space-around`.\n- `align-items`: Mengatur perataan item di sepanjang **sumbu silang (cross-axis)**: `stretch`, `center`, `flex-start`, `flex-end`.\n- `gap`: Memberikan jarak seragam antar elemen anak tanpa perlu repot mengatur margin manual!\n\n### Contoh Kasus Navigasi Bar:\n```css\n.navbar {\n    display: flex;\n    justify-content: space-between;\n    align-items: center;\n    gap: 1.5rem;\n    padding: 1rem 2rem;\n}\n```",
            'use_image' => false,
            'use_audio' => false,
            'use_video' => false,
            'order' => 2,
        ]);

        // Materi 3 (HTML Live Preview): Kartu Pricing Flexbox & CSS Variables
        CourseHtml::create([
            'course_id' => $courseCss->id,
            'title' => 'Live Demo: Komponen Kartu Langganan Responsif',
            'content' => 'Eksplorasi komponen kartu harga dengan layout Flexbox modern, efek transisi melayang (*hover lift*), dan variabel warna bertema neon cyberpunk.',
            'html_code' => '<div class="pricing-wrapper">
    <div class="pricing-card">
        <div class="card-badge">POPULER</div>
        <h3 class="plan-name">Paket Full-Stack Pro</h3>
        <p class="plan-desc">Akses seluruh modul HTML, CSS, JS hingga sertifikasi resmi.</p>
        <div class="price">
            <span class="currency">Rp</span>
            <span class="amount">99.000</span>
            <span class="period">/bulan</span>
        </div>
        <ul class="features">
            <li>✔ Akses 50+ Modul Interaktif</li>
            <li>✔ Live Compiler Coding Otomatis</li>
            <li>✔ Sertifikat Terverifikasi QR</li>
            <li>✔ Konsultasi Mentor Komunitas</li>
        </ul>
        <button class="btn-claim">Daftar Sekarang</button>
    </div>
</div>',
            'css_code' => ':root { --primary-accent: #00ff88; --bg-surface: #0a0e1a; --border-color: #1f293d; --text-muted: #94a3b8; }
.pricing-wrapper { display: flex; justify-content: center; padding: 40px 20px; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; }
.pricing-card { position: relative; max-width: 360px; width: 100%; background: var(--bg-surface); border: 2px solid var(--border-color); border-radius: 20px; padding: 32px 28px; box-shadow: 0 15px 35px rgba(0,0,0,0.6); transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
.pricing-card:hover { transform: translateY(-6px); border-color: var(--primary-accent); box-shadow: 0 20px 40px rgba(0,255,136,0.15); }
.card-badge { position: absolute; top: -12px; right: 24px; background: var(--primary-accent); color: #000; font-size: 10px; font-weight: 800; padding: 4px 12px; border-radius: 20px; letter-spacing: 1px; }
.plan-name { color: #fff; font-size: 20px; font-weight: 800; margin: 0 0 8px 0; }
.plan-desc { color: var(--text-muted); font-size: 12px; line-height: 1.5; margin: 0 0 20px 0; }
.price { display: flex; align-items: baseline; gap: 4px; margin-bottom: 24px; padding-bottom: 20px; border-bottom: 1px solid var(--border-color); }
.currency { color: var(--primary-accent); font-weight: 700; font-size: 16px; }
.amount { color: #fff; font-weight: 900; font-size: 32px; letter-spacing: -1px; }
.period { color: var(--text-muted); font-size: 12px; }
.features { list-style: none; padding: 0; margin: 0 0 28px 0; display: flex; flex-direction: column; gap: 12px; }
.features li { color: #e2e8f0; font-size: 13px; font-weight: 500; }
.btn-claim { width: 100%; padding: 12px; background: linear-gradient(135deg, var(--primary-accent), #059669); color: #000; font-weight: 800; font-size: 13px; border: none; border-radius: 12px; cursor: pointer; transition: opacity 0.2s; }
.btn-claim:hover { opacity: 0.9; }',
            'js_code' => 'console.log("CSS Pricing Card Demo Ready");',
            'order' => 3,
        ]);

        // Materi 4 (Story): CSS Grid Dua Dimensi
        CourseStory::create([
            'course_id' => $courseCss->id,
            'title' => 'CSS Grid Layout: Arsitektur Tata Letak Dua Dimensi',
            'content' => "Jika Flexbox dirancang untuk susunan satu arah, CSS Grid adalah sistem layout dua dimensi yang mampu mengendalikan kolom (columns) dan baris (rows) secara simultan.\n\n### Sintaks Fundamental Grid:\n```css\n.gallery-grid {\n    display: grid;\n    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));\n    gap: 20px;\n}\n```\n\n### Makna Sintaks `repeat(auto-fit, minmax(280px, 1fr))`:\n1. `auto-fit`: Secara cerdas memperluas kolom yang ada untuk mengisi seluruh ruang kontainer yang tersedia.\n2. `minmax(280px, 1fr)`: Menetapkan batas ukuran kolom minimal sebesar 280px, dan maksimal 1 fraction (1fr) dari sisa ruang kosong.\n\nDengan pola di atas, Anda telah menciptakan layout galeri responsif sempurna tanpa perlu menulis satupun baris `@media` query!",
            'use_image' => false,
            'use_audio' => false,
            'use_video' => false,
            'order' => 4,
        ]);

        // Soal 1 (Kuis Pilihan Ganda): Flexbox Main Axis
        CourseQuestion::create([
            'course_id' => $courseCss->id,
            'question_type' => 'question',
            'title' => 'Perataan Item Sumbu Utama pada Flexbox',
            'content' => "Properti CSS Flexbox manakah yang digunakan secara khusus untuk mengatur perataan elemen anak (flex items) di sepanjang sumbu utama (main axis)?",
            'options' => [
                'align-items',
                'justify-content',
                'align-content',
                'flex-spread'
            ],
            'correct_answer' => 'justify-content',
            'hint' => 'Dimulai dengan kata justify yang mengatur posisi horisontal pada orientasi row default.',
            'order' => 5,
        ]);

        // Soal 2 (Kuis Pilihan Ganda): Box-Sizing
        CourseQuestion::create([
            'course_id' => $courseCss->id,
            'question_type' => 'question',
            'title' => 'Perilaku Nilai Properti box-sizing: border-box',
            'content' => "Bagaimanakah peramban (browser) menghitung total dimensi elemen saat dideklarasikan `box-sizing: border-box`?",
            'options' => [
                'Padding dan border akan dihitung di luar ukuran width/height elemen',
                'Nilai margin elemen secara otomatis dikonversi menjadi padding internal',
                'Padding dan border disertakan ke dalam total ukuran width dan height elemen',
                'Elemen secara otomatis berubah format menjadi elemen inline-block'
            ],
            'correct_answer' => 'Padding dan border disertakan ke dalam total ukuran width dan height elemen',
            'hint' => 'Border dan padding melebur ke dalam ukuran kotak.',
            'order' => 6,
        ]);

        // Soal 3 (Kuis Pilihan Ganda): Grid Fractional Unit (fr)
        CourseQuestion::create([
            'course_id' => $courseCss->id,
            'question_type' => 'question',
            'title' => 'Satuan Fractional Unit (fr) pada CSS Grid',
            'content' => "Dalam sistem tata letak CSS Grid, apakah arti dan fungsi dari satuan unit `fr` (fractional unit)?",
            'options' => [
                'Satuan ukuran frame per detik pada animasi CSS keyframes',
                'Pecahan fraksi yang membagi ruang kosong yang tersedia secara proporsional',
                'Satuan absolut yang setara dengan 16 piksel standar monitor',
                'Persentase tetap dari lebar jendela browser secara keseluruhan'
            ],
            'correct_answer' => 'Pecahan fraksi yang membagi ruang kosong yang tersedia secara proporsional',
            'hint' => 'fr singkatan dari fraction (pecahan bagian ruang bebas).',
            'order' => 7,
        ]);

        // Soal 4 (Coding Challenge JS/Logic): Kalkulator Rasio Aspek Layar Responsif
        CourseQuestion::create([
            'course_id' => $courseCss->id,
            'question_type' => 'coding',
            'title' => 'Tantangan Logika: Hitung Ketinggian Kontainer Aspek Rasio 16:9',
            'content' => "Dalam CSS modern, kita sering menentukan ketinggian elemen media video responsif berdasarkan rasio aspek 16:9 (`aspect-ratio: 16 / 9`).\n\n### Instruksi:\nBuatlah program JavaScript yang menerima input satu baris berupa angka lebar layar (Width dalam pixel), lalu hitung dan cetak ketinggian (Height) dengan rasio 16:9 menggunakan format angka bulat (Math.round).\n\nRumus:\n`Height = Math.round((Width * 9) / 16)`\n\nContoh Input:\n`1920`\n\nContoh Output:\n`1080`",
            'language' => 'javascript',
            'starter_code' => "const readline = require('readline');
const rl = readline.createInterface({ input: process.stdin, output: process.stdout });

rl.on('line', (line) => {
    const width = parseFloat(line.trim());
    const height = Math.round((width * 9) / 16);
    console.log(height);
    process.exit(0);
});",
            'expected_output' => '1080',
            'test_cases' => [
                [
                    'input' => '1920',
                    'expected_output' => '1080'
                ],
                [
                    'input' => '1280',
                    'expected_output' => '720'
                ]
            ],
            'coding_rules' => ['console_log'],
            'hint' => 'Kalikan width dengan 9, bagi 16, lalu bulatkan dengan Math.round()',
            'order' => 8,
        ]);


        // =========================================================================
        // 3. COURSE JAVASCRIPT: JavaScript Modern ES6+: Logika, DOM & Aplikasi
        // =========================================================================
        $courseJs = Course::create([
            'title' => 'A03 - JavaScript Modern ES6+: Logika Pemrograman, DOM & Algoritma',
            'description' => 'Hidupkan website menjadi dinamis dan interaktif! Kuasai sintaks ES6+ terkini (let/const, arrow functions, destructuring), manipulasi Document Object Model (DOM), penanganan event, metode array mutakhir (map, filter, reduce), hingga pemanggilan API Asynchronous.',
            'price' => 99000.00,
            'image' => null,
            'is_active' => true,
            'quiz_answer_visibility' => 'end',
            'quiz_navigation_mode' => 'free',
            'shuffle_questions' => true,
            'shuffle_options' => true,
            'created_by' => $adminId,
        ]);

        // Materi 1 (Story): Fondasi ES6 (let, const, arrow function)
        CourseStory::create([
            'course_id' => $courseJs->id,
            'title' => 'Evolusi Sintaks ES6+: Dari var Menuju let & const',
            'content' => "JavaScript modern mengalami lonjakan standar sejak diperkenalkannya ECMAScript 2015 (ES6). Salah satu perubahan paling krusial adalah pengelolaan variabel.\n\n### Mengapa Tidak Boleh Lagi Menggunakan `var`?\n1. **Function Scope vs Block Scope**: Variabel `var` tidak mengenal cakupan kurung kurawal `{}` (block scope), sehingga rawan bocor (*leak*) dan menimpa variabel di luar perulangan.\n2. **Hoisting Membingungkan**: Variabel `var` dapat diakses sebelum dideklarasikan, menghasilkan nilai `undefined` yang menyulitkan proses debugging.\n\n### Aturan Emas JavaScript Modern:\n- Gunakan `const` secara default untuk seluruh deklarasi variabel yang referensinya tidak akan diubah.\n- Gunakan `let` hanya jika nilai variabel memang perlu di-reassign (misalnya counter perulangan for).\n\n### Arrow Functions (Sintaks Ringkas):\n```javascript\n// Gaya Lama ES5\nfunction tambah(a, b) {\n    return a + b;\n}\n\n// Gaya Modern ES6\nconst tambah = (a, b) => a + b;\n```",
            'use_image' => false,
            'use_audio' => false,
            'use_video' => false,
            'order' => 1,
        ]);

        // Materi 2 (Story): Array Methods (map, filter, reduce)
        CourseStory::create([
            'course_id' => $courseJs->id,
            'title' => 'Kekuatan Metode Array Fungsional: map, filter & reduce',
            'content' => "Dalam pengembangan aplikasi web profesional, pengembang jarang lagi menuliskan perulangan tradisional `for (let i = 0; ...)` untuk mengolah data koleksi. Sebagai gantinya, kita memanfaatkan metode array fungsional yang lebih bersih dan deklaratif:\n\n### 1. `Array.prototype.map()`\nMentransformasi setiap elemen dalam array dan mengembalikan array baru dengan panjang yang identik:\n```javascript\nconst hargaRupiah = [10000, 25000, 50000];\nconst denganPajak = hargaRupiah.map(h => h * 1.11);\n```\n\n### 2. `Array.prototype.filter()`\nMenyaring elemen array berdasarkan kondisi pengujian tertentu. Hanya elemen yang menghasilkan `true` yang akan disertakan pada array baru:\n```javascript\nconst produk = [\n    { nama: 'Mouse', stok: 5 },\n    { nama: 'Keyboard', stok: 0 },\n    { nama: 'Monitor', stok: 2 }\n];\nconst produkTersedia = produk.filter(p => p.stok > 0);\n```\n\n### 3. `Array.prototype.reduce()`\nAkumulasi seluruh nilai elemen array menjadi satu nilai tunggal (misal: menghitung grand total belanjaan).",
            'use_image' => false,
            'use_audio' => false,
            'use_video' => false,
            'order' => 2,
        ]);

        // Materi 3 (HTML Live Preview): Aplikasi Mini Counter Interaktif
        CourseHtml::create([
            'course_id' => $courseJs->id,
            'title' => 'Live Demo: Widget Penghitung Interaktif Real-Time',
            'content' => 'Pelajari bagaimana kode JavaScript mengikat event click pada tombol HTML, memperbarui nilai state di memori, dan mengubah tampilan antarmuka secara instan.',
            'html_code' => '<div class="counter-box">
    <div class="counter-header">
        <span class="badge">MANIPULASI DOM LIVE</span>
        <h2>Penghitung Tiket Seminar</h2>
    </div>

    <div class="display-wrap">
        <span id="counterValue" class="counter-number">1</span>
        <span class="ticket-status" id="ticketStatus">Tiket Tersedia</span>
    </div>

    <div class="controls">
        <button id="btnMinus" class="ctrl-btn minus" onclick="updateCounter(-1)">-</button>
        <button id="btnReset" class="ctrl-btn reset" onclick="resetCounter()">Reset</button>
        <button id="btnPlus" class="ctrl-btn plus" onclick="updateCounter(1)">+</button>
    </div>

    <div class="subtotal-note">
        Total Biaya: <strong id="totalCost">Rp 50.000</strong>
    </div>
</div>',
            'css_code' => '.counter-box { max-width: 420px; margin: 30px auto; background: #0b1329; border: 2px solid #1e293b; border-radius: 20px; padding: 28px; text-align: center; color: #fff; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; box-shadow: 0 20px 40px rgba(0,0,0,0.6); }
.badge { display: inline-block; padding: 4px 10px; font-size: 10px; font-weight: 800; color: #facc15; background: rgba(250, 204, 21, 0.1); border: 1px solid rgba(250, 204, 21, 0.3); border-radius: 12px; margin-bottom: 8px; }
.counter-header h2 { margin: 0 0 16px 0; font-size: 18px; font-weight: 800; color: #fff; }
.display-wrap { background: #030712; border: 1px solid #1f2937; border-radius: 16px; padding: 24px; margin-bottom: 20px; }
.counter-number { display: block; font-size: 54px; font-weight: 900; color: #38bdf8; line-height: 1; letter-spacing: -2px; }
.ticket-status { display: inline-block; font-size: 11px; color: #10b981; font-weight: 700; margin-top: 8px; }
.controls { display: flex; justify-content: center; gap: 12px; margin-bottom: 20px; }
.ctrl-btn { border: none; border-radius: 12px; font-size: 16px; font-weight: 800; cursor: pointer; transition: transform 0.15s, opacity 0.2s; }
.ctrl-btn:active { transform: scale(0.95); }
.ctrl-btn.minus, .ctrl-btn.plus { width: 48px; height: 48px; background: #1e293b; color: #fff; font-size: 22px; }
.ctrl-btn.minus:hover, .ctrl-btn.plus:hover { background: #38bdf8; color: #000; }
.ctrl-btn.reset { padding: 0 18px; height: 48px; background: rgba(239, 68, 68, 0.15); color: #ef4444; border: 1px solid rgba(239, 68, 68, 0.3); font-size: 12px; }
.subtotal-note { font-size: 13px; color: #94a3b8; border-top: 1px solid #1e293b; padding-top: 16px; }
.subtotal-note strong { color: #facc15; }',
            'js_code' => 'let count = 1;
const pricePerTicket = 50000;

function updateCounter(change) {
    count = Math.max(1, count + change);
    render();
}

function resetCounter() {
    count = 1;
    render();
}

function render() {
    const el = document.getElementById("counterValue");
    const totalEl = document.getElementById("totalCost");
    if(el) el.innerText = count;
    if(totalEl) totalEl.innerText = "Rp " + (count * pricePerTicket).toLocaleString("id-ID");
}',
            'order' => 3,
        ]);

        // Materi 4 (Story): Asynchronous JavaScript & Fetch API
        CourseStory::create([
            'course_id' => $courseJs->id,
            'title' => 'Asynchronous JavaScript, Promises & Fetch API',
            'content' => "Secara mendasar JavaScript berjalan dalam satu utas tunggal (*single-threaded*). Namun, operasi seperti mengambil data dari server database tidak boleh memblokir antarmuka pengguna.\n\n### Dari Callback Hell Menuju async / await:\nPada masa lalu, penanganan proses asinkronus menggunakan callback bersarang yang rumit. Kini dengan fitur `async` dan `await`, kita dapat menulis kode asinkronus dengan tampilan bersih layaknya kode sinkronus:\n\n```javascript\nasync function ambilDaftarSiswa() {\n    try {\n        const response = await fetch('https://api.talentgroup.id/v1/students');\n        if (!response.ok) {\n            throw new Error('Gagal menghubungi server');\n        }\n        const data = await response.json();\n        console.log('Total Siswa:', data.length);\n        return data;\n    } catch (error) {\n        console.error('Terjadi kesalahan:', error.message);\n    }\n}\n```",
            'use_image' => false,
            'use_audio' => false,
            'use_video' => false,
            'order' => 4,
        ]);

        // Soal 1 (Kuis Pilihan Ganda): Deklarasi Const
        CourseQuestion::create([
            'course_id' => $courseJs->id,
            'question_type' => 'question',
            'title' => 'Deklarasi Variabel Tetap pada ES6',
            'content' => "Kata kunci (keyword) manakah pada standar JavaScript ES6 yang digunakan untuk mendeklarasikan variabel yang referensi nilainya bersifat konstan dan tidak dapat di-reassign kembali?",
            'options' => [
                'var',
                'let',
                'const',
                'static'
            ],
            'correct_answer' => 'const',
            'hint' => 'Singkatan dari constant.',
            'order' => 5,
        ]);

        // Soal 2 (Kuis Pilihan Ganda): Array Filter
        CourseQuestion::create([
            'course_id' => $courseJs->id,
            'question_type' => 'question',
            'title' => 'Metode Array untuk Menyaring Data',
            'content' => "Metode array JavaScript manakah yang mengeksekusi fungsi callback pada setiap elemen dan menghasilkan array baru yang hanya memuat elemen-elemen dengan kondisi bernilai `true`?",
            'options' => [
                'map()',
                'filter()',
                'find()',
                'reduce()'
            ],
            'correct_answer' => 'filter()',
            'hint' => 'Bermakna menyaring dalam bahasa Indonesia.',
            'order' => 6,
        ]);

        // Soal 3 (Kuis Pilihan Ganda): Asynchronous Execution
        CourseQuestion::create([
            'course_id' => $courseJs->id,
            'question_type' => 'question',
            'title' => 'Sintaks Penanganan Promise Modern',
            'content' => "Pasangan sintaks manakah yang diperkenalkan untuk menyederhanakan penanganan Promise sehingga alur kode asinkronus dapat dibaca secara sekuensial dan rapi?",
            'options' => [
                'try / catch',
                'async / await',
                'then / catch',
                'defer / resolve'
            ],
            'correct_answer' => 'async / await',
            'hint' => 'Fungsi diawali kata async dan pemanggilan Promise menggunakan kata await.',
            'order' => 7,
        ]);

        // Soal 4 (Coding Challenge JS): Filter Angka Genap Array
        CourseQuestion::create([
            'course_id' => $courseJs->id,
            'question_type' => 'coding',
            'title' => 'Tantangan Coding: Filter Angka Genap',
            'content' => "Buatlah program JavaScript yang membaca deretan angka yang dipisahkan dengan spasi, lalu cetak hanya angka yang bernilai genap saja, dipisahkan oleh spasi.\n\nContoh Input:\n`1 2 3 4 5 6 7 8`\n\nContoh Output:\n`2 4 6 8`",
            'language' => 'javascript',
            'starter_code' => "const readline = require('readline');
const rl = readline.createInterface({ input: process.stdin, output: process.stdout });

rl.on('line', (line) => {
    // 1. Pecah string menjadi array angka
    const numbers = line.trim().split(/\\s+/).map(Number);
    
    // 2. Filter angka genap (n % 2 === 0)
    const evens = numbers.filter(n => n % 2 === 0);
    
    // 3. Gabungkan kembali dengan spasi
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
            'order' => 8,
        ]);

        // =========================================================================
        // 4. MODUL DOKUMENTASI LENGKAP (HTML, CSS, JS)
        // =========================================================================
        // Bersihkan modul dokumentasi yang tidak relevan agar fokus
        Module::truncate();
        ModuleCategory::truncate();

        // Kategori 1: DOKUMENTASI HTML5 KOMPREHENSIF
        $catHtml = ModuleCategory::create([
            'name' => 'Modul Dokumentasi HTML5 Komprehensif',
            'slug' => 'modul-html5-komprehensif',
            'description' => 'Referensi lengkap struktur standar HTML5, semantik SEO, formulir validasi, tabel data, dan multimedia.',
            'is_public' => true,
            'icon' => 'fab fa-html5',
            'color' => '#f97316',
            'badge' => 'Fondasi Web',
            'order' => 1,
            'is_active' => true,
            'enable_anti_screenshot' => false,
            'enable_anti_copy' => false,
        ]);

        Module::create([
            'category_id' => $catHtml->id,
            'section' => 'FONDASI & DOKUMEN',
            'title' => 'Struktur Anatomi Dokumen HTML5',
            'slug' => 'struktur-anatomi-dokumen-html5',
            'content_type' => 'document',
            'excerpt' => 'Mengenal hierarki tag DOCTYPE, html, head, meta charset, viewport, dan penataan body.',
            'content' => "# Struktur Anatomi Dokumen HTML5 Standar\n\nHTML5 adalah pondasi utama dalam pembangunan seluruh aplikasi web modern. Setiap dokumen HTML5 diawali dengan deklarasi DOCTYPE yang ringkas:\n\n```html:index.html\n<!DOCTYPE html>\n<html lang=\"id\">\n<head>\n    <meta charset=\"UTF-8\">\n    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">\n    <title>Dokumentasi HTML5 | TalentGroup</title>\n</head>\n<body>\n    <header>\n        <h1>Selamat Datang di Portal Pengembang</h1>\n    </header>\n    <main>\n        <p>Konten utama aplikasi dimuat di dalam tag main.</p>\n    </main>\n    <footer>\n        <p>&copy; 2026 TalentGroup. Hak cipta dilindungi.</p>\n    </footer>\n</body>\n</html>\n```\n\n> [!NOTE]\n> Tag `<meta name=\"viewport\">` sangat penting agar tata letak halaman proporsional dan tidak mengecil saat diakses melalui ponsel pintar.",
            'order' => 1,
            'is_published' => true,
            'is_public' => true,
        ]);

        Module::create([
            'category_id' => $catHtml->id,
            'section' => 'FORM & VALIDASI',
            'title' => 'Formulir Interaktif & Kontrol Validasi',
            'slug' => 'formulir-interaktif-dan-validasi',
            'content_type' => 'document',
            'excerpt' => 'Panduan lengkap pembuatan form login, registrasi, input email, password, file upload, dan validasi pattern.',
            'content' => "# Formulir Interaktif & Kontrol Validasi HTML5\n\nFormulir digunakan untuk mengumpulkan informasi dari pengguna. HTML5 menyediakan kontrol validasi otomatis di sisi browser tanpa perlu JavaScript.\n\n```html:form-login.html\n<form action=\"/api/login\" method=\"POST\">\n    <div class=\"input-group\">\n        <label for=\"email\">Email Perusahaan:</label>\n        <input type=\"email\" id=\"email\" name=\"email\" required placeholder=\"nama@kantor.com\">\n    </div>\n    <div class=\"input-group\">\n        <label for=\"password\">Kata Sandi:</label>\n        <input type=\"password\" id=\"password\" name=\"password\" required minlength=\"8\">\n    </div>\n    <button type=\"submit\">Masuk ke Akun</button>\n</form>\n```\n\n> [!TIP]\n> Gunakan atribut `minlength` dan `required` untuk mencegah form dikirim dalam keadaan kosong.",
            'order' => 2,
            'is_published' => true,
            'is_public' => true,
        ]);


        // Kategori 2: DOKUMENTASI CSS3 MODERN
        $catCss = ModuleCategory::create([
            'name' => 'Modul Dokumentasi CSS3 & Tata Letak Modern',
            'slug' => 'modul-css3-dan-layout-modern',
            'description' => 'Panduan arsitektur antarmuka web dengan Flexbox, CSS Grid, media queries responsif, dan variabel tema.',
            'is_public' => true,
            'icon' => 'fab fa-css3-alt',
            'color' => '#38bdf8',
            'badge' => 'Desain Web',
            'order' => 2,
            'is_active' => true,
            'enable_anti_screenshot' => false,
            'enable_anti_copy' => false,
        ]);

        Module::create([
            'category_id' => $catCss->id,
            'section' => 'BOX MODEL & RESET',
            'title' => 'Universal Box-Sizing & Reset CSS',
            'slug' => 'universal-box-sizing-dan-reset-css',
            'content_type' => 'document',
            'excerpt' => 'Menghindari inkonsistensi kalkulasi padding dan border dengan reset border-box standar.',
            'content' => "# Universal Box-Sizing & Reset CSS\n\nSebelum mulai menata halaman, deklarasikan reset box-sizing untuk seluruh elemen:\n\n```css:global.css\n*, *::before, *::after {\n    box-sizing: border-box;\n    margin: 0;\n    padding: 0;\n}\n```\n\n### Perbedaan Model:\n- **content-box**: Ukuran `width` hanya mencakup isi konten. Padding dan border menambah lebar total.\n- **border-box**: Ukuran `width` sudah mencakup konten, padding, dan border secara terpadu.",
            'order' => 1,
            'is_published' => true,
            'is_public' => true,
        ]);

        Module::create([
            'category_id' => $catCss->id,
            'section' => 'FLEXBOX & GRID',
            'title' => 'Panduan Praktis Flexbox & CSS Grid',
            'slug' => 'panduan-praktis-flexbox-dan-css-grid',
            'content_type' => 'document',
            'excerpt' => 'Kombinasi Flexbox satu dimensi untuk komponen navigasi dan Grid dua dimensi untuk kartu galeri responsif.',
            'content' => "# Panduan Praktis Flexbox & CSS Grid\n\n### Kapan Menggunakan Flexbox vs CSS Grid?\n1. **Flexbox (1 Dimensi)**: Ideal untuk baris navigasi, tombol sejajar, atau pembagian item berurutan.\n2. **CSS Grid (2 Dimensi)**: Ideal untuk susunan kartu galeri, dashboard admin, atau halaman majalah berita.\n\n```css:layout.css\n/* Navigasi Flexbox */\n.nav-container {\n    display: flex;\n    justify-content: space-between;\n    align-items: center;\n    gap: 16px;\n}\n\n/* Galeri Kartu Grid */\n.cards-grid {\n    display: grid;\n    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));\n    gap: 24px;\n}\n```",
            'order' => 2,
            'is_published' => true,
            'is_public' => true,
        ]);


        // Kategori 3: DOKUMENTASI JAVASCRIPT ES6+
        $catJs = ModuleCategory::create([
            'name' => 'Modul Dokumentasi JavaScript ES6+ & DOM',
            'slug' => 'modul-javascript-es6-dan-dom',
            'description' => 'Arsitektur pemrograman logika JavaScript modern, manipulasi DOM, event listener, dan penanganan asynchronous.',
            'is_public' => true,
            'icon' => 'fab fa-js-square',
            'color' => '#facc15',
            'badge' => 'Logika Web',
            'order' => 3,
            'is_active' => true,
            'enable_anti_screenshot' => false,
            'enable_anti_copy' => false,
        ]);

        Module::create([
            'category_id' => $catJs->id,
            'section' => 'SINTAKS ES6+',
            'title' => 'Variabel, Arrow Function & Destructuring',
            'slug' => 'variabel-arrow-function-dan-destructuring',
            'content_type' => 'document',
            'excerpt' => 'Menulis kode JavaScript yang bersih, modern, dan mudah dipelihara menggunakan standar ES6+.',
            'content' => "# Variabel, Arrow Function & Destructuring ES6+\n\n### Destructuring Array & Objek:\n```javascript:app.js\nconst user = {\n    nama: 'Budi Santoso',\n    peran: 'Frontend Engineer',\n    kota: 'Jakarta'\n};\n\n// Ekstraksi langsung variabel properti\nconst { nama, peran } = user;\nconsole.log(`Halo \${nama}, peran Anda adalah \${peran}.`);\n```\n\n### Arrow Functions dengan Nilai Kembalian Implisit:\n```javascript\nconst kuadrat = x => x * x;\nconsole.log(kuadrat(5)); // 25\n```",
            'order' => 1,
            'is_published' => true,
            'is_public' => true,
        ]);

        Module::create([
            'category_id' => $catJs->id,
            'section' => 'MANIPULASI DOM',
            'title' => 'Event Listener & Manipulasi DOM Real-Time',
            'slug' => 'event-listener-dan-manipulasi-dom',
            'content_type' => 'document',
            'excerpt' => 'Menghubungkan interaksi tombol pengguna untuk menambah, mengubah, atau menghapus elemen dokumen.',
            'content' => "# Event Listener & Manipulasi DOM Real-Time\n\n```javascript:dom.js\nconst btnSubmit = document.querySelector('#btn-kirim');\nconst statusBox = document.querySelector('.status-box');\n\nbtnSubmit.addEventListener('click', (event) => {\n    event.preventDefault();\n    statusBox.classList.add('aktif');\n    statusBox.textContent = 'Memproses data transaksi...';\n});\n```\n\n> [!IMPORTANT]\n> Selalu gunakan `event.preventDefault()` pada formulir untuk mencegah peramban me-refresh halaman secara otomatis.",
            'order' => 2,
            'is_published' => true,
            'is_public' => true,
        ]);

        // Aktifkan kembali pengecekan Foreign Key
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
