<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\CourseStory;
use App\Models\CourseHtml;
use App\Models\CourseQuestion;
use App\Models\User;
use Illuminate\Database\Seeder;

class CssCourseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::first();
        $adminId = $admin ? $admin->id : 1;

        $course = Course::create([
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

        $order = 1;

        // -------------------------------------------------------------
        // MATERI PEMBELAJARAN (STORIES)
        // -------------------------------------------------------------

        // Bab 1
        CourseStory::create([
            'course_id' => $course->id,
            'title' => 'Bab 1: Anatomi Aturan CSS, Selektor Modern & Kalkulasi Specificity',
            'content' => "### 1.1 Peran CSS dalam Pengembangan Web Modern
Jika HTML adalah tulang dan organ tubuh, maka **CSS (Cascading Style Sheets)** adalah kulit, pakaian, dan daya tarik visualnya. CSS bertanggung jawab penuh atas warna, tata letak, ukuran font, spasi, hingga animasi interaktif di layar pengguna.

### 1.2 Anatomi Pernyataan CSS (CSS Rule)
```css
selektor {
    properti: nilai;
}
```
- **Selector (Selektor)**: Menunjuk elemen HTML mana yang hendak diatur gayanya.
- **Declaration Block**: Blok kurung kurawal `{}` yang memuat satu atau lebih deklarasi pasangan `properti: nilai;` yang diakhiri tanda titik koma `;`.

### 1.3 Sistem Pembobotan Selektor (Specificity Hierarchy):
Seringkali beberapa aturan CSS menargetkan elemen yang sama secara bersamaan. Browser menggunakan algoritma matematika **Specificity** untuk menentukan aturan mana yang paling berhak menang:
1. **Inline Style** (`<h1 style=\"color: red;\">`): **1000 Poin** (Sangat kuat menimpa file eksternal).
2. **ID Selector** (`#navbar-utama`): **100 Poin** (Prioritas tinggi).
3. **Class, Attribute & Pseudo-class** (`.btn-card`, `[type=\"text\"]`, `:hover`): **10 Poin** (Paling direkomendasikan untuk arsitektur yang mudah dirawat).
4. **Elemen & Pseudo-element** (`h1`, `p`, `::before`, `::after`): **1 Poin** (Selektor dasar).

> [!WARNING]
> Hindari kebiasaan buruk memaksakan gaya dengan keyword `!important`! Penggunaan `!important` merusak sistem alami hierarki cascade CSS dan menyulitkan proses pemeliharaan kode di masa depan.",
            'use_image' => false,
            'use_audio' => false,
            'use_video' => false,
            'order' => $order++,
        ]);

        // Bab 2
        CourseStory::create([
            'course_id' => $course->id,
            'title' => 'Bab 2: Menguasai CSS Box Model, Margin Collapsing & Universal Reset',
            'content' => "### 2.1 Konsep Segiempat Box Model
Setiap elemen yang dirender pada dokumen web pada hakikatnya adalah sebuah kotak segiempat. Box Model terdiri dari 4 lapisan berlapis dari dalam ke luar:
1. **Content**: Area tempat teks, gambar, atau elemen anak ditampilkan.
2. **Padding**: Ruang transparan internal di antara konten dan garis tepi (border).
3. **Border**: Garis tepi pembungkus yang mengelilingi padding dan konten.
4. **Margin**: Ruang luar transparan yang memisahkan elemen dari elemen tetangga di sekitarnya.

### 2.2 Fenomena Margin Collapsing:
Saat dua margin vertikal dari elemen bertingkat bertemu (misalnya `margin-bottom: 24px` pada paragraf atas dan `margin-top: 32px` pada paragraf bawah), nilainya **tidak dijumlahkan** menjadi 56px! Keduanya melebur (*collapse*) mengambil nilai terbesar yaitu **32px**.

### 2.3 Standar Industri: Universal Box-Sizing
Secara default browser menggunakan `box-sizing: content-box`. Artinya jika Anda menetapkan `width: 200px` dan menambahkan `padding: 20px`, total lebar elemen membengkak menjadi 240px!
Solusi standar industri modern adalah menggunakan reset universal:
```css
*, *::before, *::after {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}
```
Dengan `border-box`, nilai padding dan border akan dihitung ke dalam total lebar elemen, sehingga dimensi tata letak tetap konsisten dan presisi.",
            'use_image' => false,
            'use_audio' => false,
            'use_video' => false,
            'order' => $order++,
        ]);

        // Bab 3
        CourseStory::create([
            'course_id' => $course->id,
            'title' => 'Bab 3: Tipografi Responsif, Fluid Typography & Variabel Tema (Custom Properties)',
            'content' => "### 3.1 Satuan Ukuran: px vs rem vs em
- **Pixel (`px`)**: Satuan absolut statis. Kurang ramah aksesibilitas jika pengguna mengubah ukuran font default browser.
- **Root EM (`rem`)**: Satuan relatif terhadap ukuran font elemen akar `<html>` (standar default browser: `1rem = 16px`). Sangat disarankan untuk seluruh padding, margin, dan tipografi!
- **EM (`em`)**: Relatif terhadap ukuran font elemen induk terdekatnya.

### 3.2 Tipografi Mengalir dengan Fungsi `clamp()`
Fungsi `clamp(minimum, ideal, maksimum)` memungkinkan teks membesar dan mengecil secara otomatis dan mulus (*fluid*) mengikuti lebar layar peramban tanpa perlu menulis lusinan baris media queries:
```css
h1 {
    font-size: clamp(1.75rem, 4vw + 1rem, 3.5rem);
}
```

### 3.3 Variabel Tema CSS (Custom Properties)
Variabel memungkinkan Anda mendefinisikan palet warna terpusat untuk kemudahan implementasi tema Gelap (Dark Mode) dan Terang (Light Mode):
```css
:root {
    --bg-surface: #0a0f1d;
    --text-main: #f8fafc;
    --primary-neon: #00ff88;
}

body.light {
    --bg-surface: #ffffff;
    --text-main: #0f172a;
    --primary-neon: #0284c7;
}

.card {
    background-color: var(--bg-surface);
    color: var(--text-main);
    border: 1px solid var(--primary-neon);
}
```",
            'use_image' => false,
            'use_audio' => false,
            'use_video' => false,
            'order' => $order++,
        ]);

        // Bab 4
        CourseStory::create([
            'course_id' => $course->id,
            'title' => 'Bab 4: Teknik Positioning Lanjutan (Relative, Absolute, Fixed & Sticky)',
            'content' => "CSS Positioning menentukan bagaimana posisi kotak elemen dipetakan di atas dokumen alur normal (*normal flow*).

### 1. Static (Default)
Elemen mengikuti alur dokumen alami dari atas ke bawah. Properti koordinat `top`, `bottom`, `left`, `right`, dan `z-index` tidak berpengaruh.

### 2. Relative
Elemen tetap mempertahankan ruang fisiknya dalam dokumen, tetapi posisinya dapat digeser sedikit menggunakan `top`, `left`, dll. Sangat sering dijadikan **titik acuan induk (*reference context*)** bagi elemen anak yang berposisi absolute.

### 3. Absolute
Elemen dicabut sepenuhnya dari alur dokumen normal (elemen lain akan menempati ruang bekasnya). Elemen absolute diposisikan relatif terhadap elemen induk terdekat yang memiliki posisi non-static (`relative`, `absolute`, atau `fixed`).
```css
.card-parent {
    position: relative; /* Induk Acuan */
}

.badge-diskon {
    position: absolute;
    top: 10px;
    right: 10px;
}
```

### 4. Fixed
Elemen menempel absolut terhadap jendela peramban (*viewport*). Elemen tidak akan bergeser meskipun halaman digulir ke bawah (cocok untuk tombol WhatsApp melayang).

### 5. Sticky
Perpaduan cerdas antara relative dan fixed. Elemen mengalir normal sampai halaman digulir menyentuh koordinat ambang batas tertentu (misal: `top: 0`), lalu elemen akan 'menempel' di atas layar selama masih berada di dalam kontainer induknya (sangat cocok untuk sticky header).",
            'use_image' => false,
            'use_audio' => false,
            'use_video' => false,
            'order' => $order++,
        ]);

        // Bab 5
        CourseStory::create([
            'course_id' => $course->id,
            'title' => 'Bab 5: Arsitektur Flexbox: Penataan Satu Dimensi Fleksibel',
            'content' => "Flexbox (**Flexible Box Layout**) adalah standar baku untuk meratakan dan mendistribusikan elemen dalam satu arah garis lurus (apakah mendatar horizontal atau menurun vertikal).

### 5.1 Properti Utama Kontainer Flex (`display: flex`):
1. **`flex-direction`**:
   - `row` (default): Sumbu utama mengalir horizontal ke kanan.
   - `column`: Sumbu utama mengalir menurun vertikal ke bawah.
2. **`justify-content` (Mengatur Sumbu Utama / Main Axis)**:
   - `flex-start`: Merapat ke awal.
   - `center`: Rata tengah sempurna.
   - `flex-end`: Merapat ke ujung akhir.
   - `space-between`: Menempel di ujung tepi kiri dan kanan, sisa ruang dibagi rata di tengah.
   - `space-evenly`: Seluruh jarak spasi antar elemen dan dinding pembatas dibagi sama rata.
3. **`align-items` (Mengatur Sumbu Silang / Cross Axis)**:
   - `stretch` (default): Meregang mengisi tinggi/lebar kontainer.
   - `center`: Rata tengah vertikal sumbu silang.
4. **`gap`**: Memberikan jarak konsisten antar item anak (contoh: `gap: 1.5rem`).

### 5.2 Contoh Rata Tengah Vertikal dan Horizontal Sempurna:
```css
.hero-banner {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
}
```",
            'use_image' => false,
            'use_audio' => false,
            'use_video' => false,
            'order' => $order++,
        ]);

        // Bab 6
        CourseStory::create([
            'course_id' => $course->id,
            'title' => 'Bab 6: CSS Grid: Arsitektur Tata Letak Dua Dimensi Maju',
            'content' => "Jika Flexbox dirancang untuk satu baris atau satu kolom, **CSS Grid Layout** adalah sistem arsitektur dua dimensi yang mampu mengendalikan kolom dan baris secara simultan.

### 6.1 Rumus Emas Grid Galeri Responsif:
```css
.product-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 24px;
}
```
**Analisis Rumus:**
- `repeat(...)`: Mengulang pola kolom.
- `auto-fit`: Memerintahkan browser untuk membuat kolom sebanyak mungkin yang muat dalam lebar kontainer saat itu.
- `minmax(280px, 1fr)`: Lebar kolom tidak boleh mengecil kurang dari 280px. Jika ada sisa ruang berlebih, kolom akan melebar secara merata dengan fraksi `1fr`.

### 6.2 Tata Letak Halaman Penuh dengan `grid-template-areas`:
```css
.site-layout {
    display: grid;
    grid-template-columns: 260px 1fr;
    grid-template-rows: auto 1fr auto;
    grid-template-areas:
        \"header header\"
        \"sidebar main\"
        \"footer footer\";
    min-height: 100vh;
}

header { grid-area: header; }
aside  { grid-area: sidebar; }
main   { grid-area: main; }
footer { grid-area: footer; }
```",
            'use_image' => false,
            'use_audio' => false,
            'use_video' => false,
            'order' => $order++,
        ]);

        // Bab 7
        CourseStory::create([
            'course_id' => $course->id,
            'title' => 'Bab 7: Micro-Interactions: Transisi Halus & Animasi Keyframes',
            'content' => "Website yang modern memanjakan mata dengan respons visual saat pengguna berinteraksi (mengklik tombol, mengarahkan kursor, membuka menu).

### 7.1 Transisi CSS (CSS Transitions)
Transisi menciptakan pergeseran visual halus ketika properti elemen berubah status (seperti saat `:hover`):
```css
.card-feature {
    background-color: #0f172a;
    transform: translateY(0);
    transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1), box-shadow 0.3s ease;
}

.card-feature:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 35px rgba(0, 255, 136, 0.2);
}
```

### 7.2 Animasi Berkelanjutan (@keyframes Animation)
Untuk animasi dinamis tanpa perlu menunggu interaksi pengguna:
```css
@keyframes denyutGlow {
    0% {
        box-shadow: 0 0 5px rgba(56, 189, 248, 0.3);
    }
    50% {
        box-shadow: 0 0 25px rgba(56, 189, 248, 0.8);
    }
    100% {
        box-shadow: 0 0 5px rgba(56, 189, 248, 0.3);
    }
}

.badge-live {
    animation: denyutGlow 2.5s infinite ease-in-out;
}
```",
            'use_image' => false,
            'use_audio' => false,
            'use_video' => false,
            'order' => $order++,
        ]);

        // -------------------------------------------------------------
        // LIVE DEMO HTML INTERAKTIF
        // -------------------------------------------------------------
        CourseHtml::create([
            'course_id' => $course->id,
            'title' => 'Live Demo: Dashboard Statistik Glassmorphism & Grid Responsif',
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
            'order' => $order++,
        ]);

        // -------------------------------------------------------------
        // KUMPULAN SOAL KUIS PILIHAN GANDA (10 SOAL LENGKAP)
        // -------------------------------------------------------------
        $questions = [
            [
                'title' => 'Selektor dengan Bobot Specificity Tertinggi',
                'content' => 'Dari keempat jenis selektor CSS berikut, manakah yang memiliki bobot Specificity (prioritas penimpaan gaya) paling tinggi dalam menentukan tampilan elemen?',
                'options' => [
                    'Elemen tag standar seperti h1 atau p (1 poin)',
                    'Class Selector seperti .card-container (10 poin)',
                    'Identifier unik ID Selector seperti #navbar-utama (100 poin)',
                    'Pseudo-class seperti :hover atau :focus (10 poin)'
                ],
                'correct_answer' => 'Identifier unik ID Selector seperti #navbar-utama (100 poin)',
                'hint' => 'ID Selector memiliki bobot 100 poin.',
            ],
            [
                'title' => 'Perilaku Properti box-sizing: border-box',
                'content' => 'Bagaimanakah browser menghitung total dimensi elemen saat dideklarasikan properti `box-sizing: border-box`?',
                'options' => [
                    'Padding dan border akan dihitung di luar ukuran width/height yang ditetapkan',
                    'Nilai margin elemen secara otomatis dikonversi menjadi padding internal',
                    'Nilai padding dan border disertakan ke dalam total ukuran width dan height elemen',
                    'Elemen secara otomatis berubah format menjadi elemen inline murni'
                ],
                'correct_answer' => 'Nilai padding dan border disertakan ke dalam total ukuran width dan height elemen',
                'hint' => 'Padding dan border melebur ke dalam ukuran kotak.',
            ],
            [
                'title' => 'Properti Distribusi Ruang Flexbox (Main Axis)',
                'content' => 'Nilai properti `justify-content` manakah yang mendistribusikan item pertama persis menempel di tepi kiri dan item terakhir persis menempel di tepi kanan, sementara sisa ruang dibagi rata di antara item-item tengah?',
                'options' => [
                    'space-evenly',
                    'space-around',
                    'space-between',
                    'center'
                ],
                'correct_answer' => 'space-between',
                'hint' => 'Bermakna ruang di antara item (antara tepi ke tepi).',
            ],
            [
                'title' => 'Fungsi auto-fit pada CSS Grid Layout',
                'content' => 'Apakah keunggulan utama dari penggunaan nilai `auto-fit` dalam deklarasi `grid-template-columns: repeat(auto-fit, minmax(280px, 1fr))`?',
                'options' => [
                    'Menyembunyikan kartu jika resolusi layar berada di bawah 600px',
                    'Memperluas dan menyesuaikan kolom yang ada secara otomatis mengisi seluruh ruang kosong layar tanpa media query',
                    'Memutar orientasi layout dari horizontal menjadi vertikal secara acak',
                    'Mengunci ukuran setiap elemen agar tidak pernah berubah sama sekali'
                ],
                'correct_answer' => 'Memperluas dan menyesuaikan kolom yang ada secara otomatis mengisi seluruh ruang kosong layar tanpa media query',
                'hint' => 'Membuat layout responsif otomatis mengisi layar.',
            ],
            [
                'title' => 'Perilaku Position: Sticky',
                'content' => 'Bagaimanakah karakteristik elemen yang diberi deklarasi `position: sticky; top: 0;` saat halaman digulir (scroll)?',
                'options' => [
                    'Elemen langsung menghilang dari dokumen',
                    'Elemen mengalir normal di dalam dokumen sampai posisi scroll menyentuh batas top 0, lalu menempel di bagian atas layar selama masih berada di dalam kontainer induknya',
                    'Elemen selalu melayang di tengah layar kapanpun dan dimanapun',
                    'Elemen terkunci secara permanen dan tidak dapat digulir sama sekali'
                ],
                'correct_answer' => 'Elemen mengalir normal di dalam dokumen sampai posisi scroll menyentuh batas top 0, lalu menempel di bagian atas layar selama masih berada di dalam kontainer induknya',
                'hint' => 'Perpaduan sifat relative dan fixed.',
            ],
            [
                'title' => 'Satuan Ukuran rem vs px',
                'content' => 'Mengapa para profesional web lebih menyukai menggunakan satuan `rem` daripada `px` untuk ukuran font dan spasi?',
                'options' => [
                    'Karena satuan rem membuat file CSS berukuran lebih kecil',
                    'Karena satuan rem bersifat relatif terhadap ukuran font akar (root html) sehingga otomatis menyesuaikan preferensi aksesibilitas pengguna',
                    'Karena satuan px tidak lagi didukung oleh browser modern',
                    'Karena satuan rem hanya dapat digunakan pada perangkat iPhone'
                ],
                'correct_answer' => 'Karena satuan rem bersifat relatif terhadap ukuran font akar (root html) sehingga otomatis menyesuaikan preferensi aksesibilitas pengguna',
                'hint' => 'rem relatif terhadap root html.',
            ],
            [
                'title' => 'Properti Flexbox untuk Sumbu Silang (Cross Axis)',
                'content' => 'Properti CSS Flexbox manakah yang digunakan untuk mengatur perataan elemen-elemen anak di sepanjang sumbu silang (cross-axis)?',
                'options' => [
                    'justify-content',
                    'align-items',
                    'flex-direction',
                    'flex-wrap'
                ],
                'correct_answer' => 'align-items',
                'hint' => 'align-items mengatur posisi vertikal pada flex row default.',
            ],
            [
                'title' => 'Satuan Fractional Unit (fr) pada CSS Grid',
                'content' => 'Dalam sistem tata letak CSS Grid, apakah fungsi dari unit pecahan `fr` (fractional unit)?',
                'options' => [
                    'Satuan kecepatan animasi frame per detik',
                    'Membagi sisa ruang kosong kontainer yang tersedia secara proporsional',
                    'Mengatur tingkat transparansi latar belakang elemen',
                    'Menentukan jumlah baris maksimum dalam satu dokumen'
                ],
                'correct_answer' => 'Membagi sisa ruang kosong kontainer yang tersedia secara proporsional',
                'hint' => 'Membagi sisa ruang kosong secara fraksional.',
            ],
            [
                'title' => 'Fungsi CSS clamp() untuk Tipografi Cairan',
                'content' => 'Apakah parameter yang diterima oleh fungsi CSS `clamp(A, B, C)` secara berurutan?',
                'options' => [
                    'Maksimum, Ideal, Minimum',
                    'Minimum, Nilai Ideal (Preferred), Maksimum',
                    'Warna, Ketebalan, Gaya Garis',
                    'Padding, Border, Margin'
                ],
                'correct_answer' => 'Minimum, Nilai Ideal (Preferred), Maksimum',
                'hint' => 'clamp(min, preferred, max).',
            ],
            [
                'title' => 'Mekanisme CSS Custom Properties (Variabel)',
                'content' => 'Bagaimanakah sintaks baku untuk memanggil nilai dari variabel CSS yang dideklarasikan dengan nama `--primary-color`?',
                'options' => [
                    '$primary-color',
                    '@primary-color',
                    'var(--primary-color)',
                    'get(--primary-color)'
                ],
                'correct_answer' => 'var(--primary-color)',
                'hint' => 'Menggunakan fungsi var().',
            ],
        ];

        foreach ($questions as $q) {
            CourseQuestion::create([
                'course_id' => $course->id,
                'question_type' => 'question',
                'title' => $q['title'],
                'content' => $q['content'],
                'options' => $q['options'],
                'correct_answer' => $q['correct_answer'],
                'hint' => $q['hint'],
                'order' => $order++,
            ]);
        }

        // -------------------------------------------------------------
        // TANTANGAN CODING CHALLENGE (2 SOAL REALISTIS)
        // -------------------------------------------------------------

        // Challenge 1
        CourseQuestion::create([
            'course_id' => $course->id,
            'question_type' => 'coding',
            'title' => 'Tantangan Coding 1: Hitung Dimensi Total Elemen (Content-Box)',
            'content' => "Pada mode bawaan `box-sizing: content-box`, total lebar elemen dihitung dengan rumus:\n`Total Width = Width + (Padding * 2) + (Border * 2)`\n\n### Instruksi:\nBuatlah program JavaScript yang membaca 3 input angka dalam 1 baris dipisahkan spasi:\n`Width Padding Border`\n\nHitung dan cetak angka total lebar elemen!\n\nContoh Input:\n`200 20 2`\n\nKalkulasi: `200 + (20 * 2) + (2 * 2) = 244`\n\nContoh Output:\n`244`",
            'language' => 'javascript',
            'starter_code' => "const readline = require('readline');
const rl = readline.createInterface({ input: process.stdin, output: process.stdout });

rl.on('line', (line) => {
    const [width, padding, border] = line.trim().split(/\\s+/).map(Number);
    const total = width + (padding * 2) + (border * 2);
    console.log(total);
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
            'hint' => 'Kalikan padding dan border dengan 2, lalu tambahkan ke width.',
            'order' => $order++,
        ]);

        // Challenge 2
        CourseQuestion::create([
            'course_id' => $course->id,
            'question_type' => 'coding',
            'title' => 'Tantangan Coding 2: Hitung Ketinggian Video Rasio Aspek 16:9',
            'content' => "Dalam CSS responsif, kita menentukan ketinggian video dengan rasio 16:9 menggunakan rumus:\n`Height = Math.round((Width * 9) / 16)`\n\n### Instruksi:\nBuatlah program JavaScript yang membaca input 1 angka lebar (Width dalam pixel), lalu cetak ketinggian elemen 16:9 dalam angka bulat!\n\nContoh Input:\n`1920`\n\nContoh Output:\n`1080`",
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
            'hint' => 'Kalikan width dengan 9, bagi 16, lalu bulatkan dengan Math.round().',
            'order' => $order++,
        ]);
    }
}
