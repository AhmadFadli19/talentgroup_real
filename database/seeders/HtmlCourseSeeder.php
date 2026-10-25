<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\CourseStory;
use App\Models\CourseHtml;
use App\Models\CourseQuestion;
use App\Models\User;
use Illuminate\Database\Seeder;

class HtmlCourseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::first();
        $adminId = $admin ? $admin->id : 1;

        $course = Course::create([
            'title' => 'A01 - HTML5 Komprehensif: Dari Nol Pengenalan Hingga Mahir Membangun Web Semantik',
            'description' => 'Kurikulum terlengkap belajar HTML5 dari tingkat pemula tanpa pengalaman koding hingga mahir merancang arsitektur website semantik modern. Membahas tuntas standar W3C, meta SEO, tipografi, tabel data, formulir validasi, media responsif, dan aksesibilitas WAI-ARIA.',
            'price' => 0.00, // Kursus Fondasi GRATIS
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
            'title' => 'Bab 1: Pengenalan Web, Cara Kerja Browser & Anatomi HTML5',
            'content' => "### 1.1 Apa Sebenarnya HTML Itu?
HTML adalah singkatan dari **HyperText Markup Language**. HTML bukan bahasa pemrograman berlogika yang menghitung rumus matematika, melainkan bahasa penandaan (*markup*) yang bertugas menentukan **struktur, kerangka, dan arti** dari setiap konten di halaman website.

Ketika Anda mengetikkan alamat URL di browser (seperti Chrome, Safari, atau Firefox), browser akan mengirim permintaan ke server dan menerima file teks berisi kode HTML. Browser kemudian membaca tag-tag penanda tersebut dari atas ke bawah dan merendernya menjadi tampilan visual yang indah.

### 1.2 Anatomi Elemen HTML
Sebuah elemen HTML tersusun atas tiga komponen mendasar:
1. **Tag Pembuka (Opening Tag)**: Contoh `<p>` menandai awal mula paragraf.
2. **Isi Konten (Content)**: Teks atau elemen bersarang di dalamnya, misalnya `Belajar Web Bersama TalentGroup`.
3. **Tag Penutup (Closing Tag)**: Ditandai dengan garis miring `</p>`, menandai akhir dari paragraf.

Elemen juga dapat memiliki **Atribut** yang memberikan informasi tambahan. Atribut selalu ditulis di tag pembuka dengan format `nama=\"nilai\"`.
Contoh:
```html
<a href=\"https://talentgroup.id\" target=\"_blank\" class=\"btn-link\">Kunjungi Website</a>
```

### 1.3 Struktur Anatomi Dokumen HTML5 Standar
Berikut adalah kerangka wajib dokumen HTML5 yang memenuhi standar World Wide Web Consortium (W3C):

```html
<!DOCTYPE html>
<html lang=\"id\">
<head>
    <meta charset=\"UTF-8\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
    <meta name=\"description\" content=\"Panduan belajar pemrograman web modern dari nol hingga mahir.\">
    <title>Belajar HTML5 Lengkap | TalentGroup</title>
</head>
<body>
    <h1>Selamat Datang di Dunia Web Development!</h1>
    <p>Ini adalah halaman web resmi pertama Anda.</p>
</body>
</html>
```

### 1.4 Penjelasan Baris Demi Baris:
- `<!DOCTYPE html>`: Deklarasi versi dokumen. Wajib berada di baris pertama agar browser merender dalam mode standar (*standards mode*), bukan mode kompatibilitas kuno (*quirks mode*).
- `<html lang=\"id\">`: Elemen induk (root) dari seluruh halaman. Atribut `lang=\"id\"` memberi tahu search engine dan screen reader bahwa bahasa utama dokumen adalah Bahasa Indonesia.
- `<head>`: Ruang penyimpanan metadata—informasi penting untuk peramban dan mesin pencari yang tidak tampak langsung di layar pengguna.
- `<meta charset=\"UTF-8\">`: Menetapkan pengkodean karakter universal agar dokumen mampu menampilkan seluruh abjad dunia, angka, dan emoji secara sempurna.
- `<meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">`: Elemen terpenting untuk responsivitas layar smartphone.
- `<body>`: Wadah seluruh elemen visual (teks, gambar, tombol, formulir) yang dapat dilihat dan disentuh oleh pengguna.",
            'use_image' => false,
            'use_audio' => false,
            'use_video' => false,
            'order' => $order++,
        ]);

        // Bab 2
        CourseStory::create([
            'course_id' => $course->id,
            'title' => 'Bab 2: Tipografi Semantik, Hierarki Heading & Pemformatan Teks',
            'content' => "### 2.1 Mengapa Hierarki Teks Sangat Penting?
Pengunjung website jarang membaca kata demi kata dari awal hingga akhir; mereka melakukan pemindaian visual (*scanning*). Oleh karena itu, dokumen web harus memiliki struktur judul yang jelas dan logis.

### 2.2 Aturan Baku Heading (h1 sampai h6):
- `<h1>`: Judul utama halaman web. **Aturan Baku SEO: Hanya boleh ada TEPAT SATU tag `<h1>` per halaman!** Menggunakan lebih dari satu `<h1>` akan membingungkan bot mesin pencari Google mengenai topik utama halaman.
- `<h2>`: Sub-judul topik utama atau bagian bab besar.
- `<h3>`: Rincian sub-topik di dalam `<h2>`.
- `<h4>` sampai `<h6>`: Untuk sub-bagian yang lebih mendalam.

### 2.3 Format Teks Semantik vs Gaya Visual Kuno:
Pada era HTML lama, pengembang menggunakan tag presentasional seperti `<b>` (bold) dan `<i>` (italic) hanya untuk mempertebal atau memiringkan huruf. Pada HTML5 modern, kita menggunakan elemen berbobot makna (semantik):
- `<strong>`: Menandakan teks memiliki kepentingan mendesak atau prioritas tinggi (dibaca dengan penekanan suara keras oleh screen reader).
- `<em>`: Memberikan penekanan intonasi kata (*emphasis*).
- `<mark>`: Menandai teks layaknya stabilo kuning untuk hasil pencarian.
- `<blockquote>`: Kutipan panjang dari pihak ketiga, biasanya dilengkapi atribut `cite=\"url\"`.
- `<code>`: Menampilkan potongan kode pemrograman dengan font monospace.
- `<pre>`: Menampilkan teks pre-formatted apa adanya lengkap dengan spasi dan baris baru.

### Contoh Kode Nyata:
```html
<article>
    <h2>Keamanan Akun Digital</h2>
    <p>Pastikan Anda <strong>tidak pernah membagikan kode OTP</strong> kepada siapapun.</p>
    <p>Pengembang web senior pernah berkata:</p>
    <blockquote cite=\"https://talentgroup.id/quotes\">
        Kualitas kode yang baik tercermin dari kejelasan strukturnya, bukan kerumitannya.
    </blockquote>
</article>
```",
            'use_image' => false,
            'use_audio' => false,
            'use_video' => false,
            'order' => $order++,
        ]);

        // Bab 3
        CourseStory::create([
            'course_id' => $course->id,
            'title' => 'Bab 3: Sistem Tautan (Hyperlinks), Navigasi & Keamanan Tab Baru',
            'content' => "### 3.1 Konsep Hyperlink pada Tag `<a>`
Tautan (*hyperlink*) dideklarasikan menggunakan tag jangkar `<a>` (Anchor). Atribut kuncinya adalah `href` (Hypertext Reference) yang berisi alamat tujuan.

### 3.2 Tiga Tipe Tautan Utama:
1. **Tautan Eksternal**: Mengarah ke domain situs web lain.
   ```html
   <a href=\"https://github.com\" target=\"_blank\" rel=\"noopener noreferrer\">Repositori GitHub</a>
   ```
2. **Tautan Internal**: Mengarah ke halaman lain di dalam situs web Anda sendiri.
   ```html
   <a href=\"/tentang-kami\">Tentang Perusahaan</a>
   ```
3. **Tautan Anchor Bagian Halaman (Bookmark)**: Berpindah langsung ke elemen dengan ID tertentu pada halaman yang sama.
   ```html
   <!-- Tombol pemicu -->
   <a href=\"#bagian-kontak\">Gulir ke Kontak</a>

   <!-- Target tujuan -->
   <section id=\"bagian-kontak\">
       <h2>Hubungi Kami</h2>
   </section>
   ```

### 3.3 Bahaya Keamanan `target=\"_blank\"` dan Solusi Wajibnya:
Ketika Anda membuka tab baru dengan `target=\"_blank\"`, halaman tujuan secara default memiliki akses ke objek JavaScript halaman Anda melalui `window.opener`. Hal ini memungkinkan serangan siber berbahaya bernama *Reverse Tabnabbing*, di mana situs tujuan jahat dapat mengganti halaman Anda dengan halaman phising palsu!

> [!IMPORTANT]
> **Selalu sertakan `rel=\"noopener noreferrer\"`** pada seluruh tautan yang menggunakan `target=\"_blank\"` untuk memutus akses `window.opener` dan menyembunyikan informasi perujuk.",
            'use_image' => false,
            'use_audio' => false,
            'use_video' => false,
            'order' => $order++,
        ]);

        // Bab 4
        CourseStory::create([
            'course_id' => $course->id,
            'title' => 'Bab 4: Daftar Terstruktur (Lists) & Tabel Data Semantik',
            'content' => "### 4.1 Daftar Elemen (Lists)
HTML menyediakan tiga jenis daftar data:
1. **Unordered List (`<ul>`)**: Daftar tidak berurutan dengan penanda simbol peluru (*bullet points*). Ini adalah kerangka baku yang digunakan di seluruh industri untuk membuat menu navigasi.
2. **Ordered List (`<ol>`)**: Daftar berurutan numerik (1, 2, 3), cocok untuk langkah prosedur tutorial.
3. **Description List (`<dl>`)**: Daftar istilah (`<dt>`) beserta penjelasannya (`<dd>`), sangat ideal untuk glosarium atau spesifikasi produk.

```html
<!-- Contoh Menu Navigasi Modern -->
<nav>
    <ul>
        <li><a href=\"/\">Beranda</a></li>
        <li><a href=\"/kelas\">Daftar Kursus</a></li>
        <li><a href=\"/kontak\">Kontak</a></li>
    </ul>
</nav>
```

### 4.2 Tabel Data Semantik Modern
Dahulu kala, pengembang nakal menggunakan tabel untuk menyusun tata letak halaman. Praktik tersebut kini **sangat dilarang keras**! Tabel hanya diperuntukkan bagi data tabular murni.

```html
<table border=\"1\">
    <caption>Daftar Nilai Evaluasi Kelas Web</caption>
    <thead>
        <tr>
            <th scope=\"col\">No</th>
            <th scope=\"col\">Nama Siswa</th>
            <th scope=\"col\">Materi</th>
            <th scope=\"col\">Nilai</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>1</td>
            <td>Ahmad Fadli</td>
            <td>HTML5 Semantik</td>
            <td>100</td>
        </tr>
        <tr>
            <td>2</td>
            <td>Siti Nurhaliza</td>
            <td>CSS3 Layout</td>
            <td>95</td>
        </tr>
    </tbody>
    <tfoot>
        <tr>
            <td colspan=\"3\">Rata-Rata Kelas</td>
            <td>97.5</td>
        </tr>
    </tfoot>
</table>
```
- `<caption>`: Judul tabel yang ramah pembaca layar.
- `<thead>`, `<tbody>`, `<tfoot>`: Pemisahan semantik kepala, tubuh, dan kaki tabel.
- `<th scope=\"col\">`: Menandai bahwa sel adalah kepala untuk kolom di bawahnya.",
            'use_image' => false,
            'use_audio' => false,
            'use_video' => false,
            'order' => $order++,
        ]);

        // Bab 5
        CourseStory::create([
            'course_id' => $course->id,
            'title' => 'Bab 5: Pengelolaan Media Responsif, Gambar Modern & Audio/Video',
            'content' => "### 5.1 Tag Gambar `<img>` dengan Best Practice Kinerja
Gambar adalah aset terberat di halaman web. Penggunaan tag gambar yang salah dapat membuat website lemot dan boros kuota pengguna.

```html
<img src=\"/images/banner-kursus.webp\" 
     alt=\"Siswa sedang belajar koding web di laptop\" 
     width=\"1200\" 
     height=\"675\" 
     loading=\"lazy\" 
     decoding=\"async\">
```
**Atribut Wajib Dipahami:**
1. `src`: Jalur file gambar (disarankan format modern seperti `.webp` atau `.avif`).
2. `alt`: Teks alternatif wajib! Menjelaskan gambar jika koneksi terputus dan dibaca oleh screen reader bagi penyandang tuna netra.
3. `width` & `height`: Membantu browser mereservasi ruang kosong sebelum gambar selesai dimuat, mencegah pergeseran layout mendadak (*Cumulative Layout Shift / CLS*).
4. `loading=\"lazy\"`: Gambar baru diunduh ketika pengguna menggulir mendekati posisi gambar.

### 5.2 Elemen `<picture>` untuk Gambar Adaptif:
```html
<picture>
    <source media=\"(min-width: 1024px)\" srcset=\"banner-desktop.webp\">
    <source media=\"(min-width: 640px)\" srcset=\"banner-tablet.webp\">
    <img src=\"banner-mobile.webp\" alt=\"Banner Promo\">
</picture>
```

### 5.3 Pemutar Audio dan Video Bawaan:
```html
<video controls width=\"640\" poster=\"/images/cover-video.jpg\">
    <source src=\"/videos/tutorial-html.mp4\" type=\"video/mp4\">
    <source src=\"/videos/tutorial-html.webm\" type=\"video/webm\">
    Browser Anda tidak mendukung pemutar video HTML5.
</video>
```",
            'use_image' => false,
            'use_audio' => false,
            'use_video' => false,
            'order' => $order++,
        ]);

        // Bab 6
        CourseStory::create([
            'course_id' => $course->id,
            'title' => 'Bab 6: Formulir Interaktif, Tipe Input Lengkap & Validasi Bawaan',
            'content' => "### 6.1 Arsitektur Formulir HTML5
Formulir (`<form>`) mengumpulkan masukan pengguna dan mengirimkannya ke endpoint server melalui metode HTTP (umumnya `GET` atau `POST`).

```html
<form action=\"/api/register\" method=\"POST\">
    <!-- Selalu hubungkan label dengan input via ID -->
    <div class=\"form-group\">
        <label for=\"txtNama\">Nama Lengkap:</label>
        <input type=\"text\" id=\"txtNama\" name=\"nama_lengkap\" required minlength=\"3\" placeholder=\"Budi Santoso\">
    </div>

    <div class=\"form-group\">
        <label for=\"txtEmail\">Alamat Email:</label>
        <input type=\"email\" id=\"txtEmail\" name=\"email\" required placeholder=\"budi@domain.com\">
    </div>

    <div class=\"form-group\">
        <label for=\"txtUsia\">Usia:</label>
        <input type=\"number\" id=\"txtUsia\" name=\"usia\" min=\"17\" max=\"60\" required>
    </div>

    <div class=\"form-group\">
        <label for=\"txtTglLahir\">Tanggal Lahir:</label>
        <input type=\"date\" id=\"txtTglLahir\" name=\"tgl_lahir\" required>
    </div>

    <div class=\"form-group\">
        <label for=\"selKota\">Kota Domisili:</label>
        <select id=\"selKota\" name=\"kota\" required>
            <option value=\"\">-- Pilih Kota --</option>
            <option value=\"jakarta\">DKI Jakarta</option>
            <option value=\"bandung\">Bandung</option>
            <option value=\"surabaya\">Surabaya</option>
        </select>
    </div>

    <div class=\"form-group\">
        <label for=\"txtCatatan\">Catatan Tambahan:</label>
        <textarea id=\"txtCatatan\" name=\"catatan\" rows=\"4\" placeholder=\"Tulis catatan Anda...\"></textarea>
    </div>

    <button type=\"submit\">Kirim Formulir</button>
</form>
```

### 6.2 Kekuatan Validasi Bawaan HTML5:
- `required`: Field tidak boleh dikosongkan.
- `minlength` & `maxlength`: Membatasi jumlah karakter minimal dan maksimal.
- `min` & `max`: Batasan nilai angka atau tanggal.
- `pattern=\"[0-9]{10,13}\"`: Validasi ekspresi reguler (Regex) untuk nomor telepon.
- `type=\"email\"` & `type=\"url\"`: Peramban langsung memvalidasi format string sebelum form diizinkan terkirim.",
            'use_image' => false,
            'use_audio' => false,
            'use_video' => false,
            'order' => $order++,
        ]);

        // Bab 7
        CourseStory::create([
            'course_id' => $course->id,
            'title' => 'Bab 7: Arsitektur Semantik Halaman Web Penuh & Aksesibilitas (WAI-ARIA)',
            'content' => "### 7.1 Menghilangkan Kebiasaan Buruk 'Div-Soup'
Banyak pemula membungkus seluruh elemen dengan tag `<div>` polos:
`<div class=\"header\">`, `<div class=\"nav\">`, `<div class=\"sidebar\">`, `<div class=\"footer\">`.
Hal ini disebut **Div-Soup** yang sangat dibenci oleh bot Google dan screen reader karena mesin tidak mengetahui mana konten berita, mana navigasi, dan mana catatan hak cipta.

### 7.2 Struktur Semantik Baku Industri:
```html
<!DOCTYPE html>
<html lang=\"id\">
<head>
    <meta charset=\"UTF-8\">
    <title>Portal Berita TalentGroup</title>
</head>
<body>
    <!-- 1. Header Utama Situs -->
    <header>
        <div class=\"logo\">TalentGroup Edu</div>
        <nav aria-label=\"Navigasi Utama\">
            <ul>
                <li><a href=\"/\">Beranda</a></li>
                <li><a href=\"/artikel\">Artikel</a></li>
            </ul>
        </nav>
    </header>

    <!-- 2. Konten Inti Halaman -->
    <main>
        <section class=\"hero-section\">
            <h1>Belajar Web Development Modern Berstandar Industri</h1>
            <p>Tingkatkan karir digital Anda dari nol hingga menjadi engineer handal.</p>
        </section>

        <section class=\"daftar-artikel\">
            <h2>Artikel Pilihan</h2>
            
            <article>
                <h3>Panduan Praktis HTML5 Semantik</h3>
                <p>Pelajari cara merancang dokumen website yang ramah mesin pencari.</p>
                <a href=\"/baca/html5-semantik\">Baca Selengkapnya &rarr;</a>
            </article>
        </section>
    </main>

    <!-- 3. Sidebar Pendukung -->
    <aside aria-label=\"Informasi Penulis\">
        <h3>Tentang Instruktur</h3>
        <p>Ditulis oleh praktisi industri teknologi dengan pengalaman 8+ tahun.</p>
    </aside>

    <!-- 4. Footer Penutup -->
    <footer>
        <p>&copy; 2026 TalentGroup. Seluruh hak cipta dilindungi.</p>
    </footer>
</body>
</html>
```

### 7.3 Pengenalan Aksesibilitas WAI-ARIA
ARIA (**Accessible Rich Internet Applications**) memberikan atribut bantuan tambahan:
- `aria-label=\"Deskripsi\"`: Memberi label suara pada tombol yang hanya memiliki ikon.
- `aria-hidden=\"true\"`: Menyembunyikan elemen dekorasi murni dari pembaca layar.
- `role=\"alert\"`: Memberi tahu screen reader untuk segera membacakan pesan error secara instan.",
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
            'title' => 'Live Demo: Komponen Formulir Registrasi & Validasi Real-Time',
            'content' => 'Eksplorasi antarmuka formulir interaktif dengan validasi HTML5 bawaan, styling kartu gelap modern, dan indikator status pengiriman.',
            'html_code' => '<div class="demo-card">
    <div class="demo-header">
        <span class="badge">LIVE FORM VALIDATION</span>
        <h2>Formulir Pendaftaran Siswa</h2>
        <p>Uji validasi HTML5 bawaan dengan mencoba mengosongkan input atau memasukkan format email yang salah.</p>
    </div>

    <form class="student-form" onsubmit="event.preventDefault(); document.getElementById(\'alertSuccess\').style.display=\'block\';">
        <div class="form-group">
            <label for="txtName">Nama Lengkap <span class="req">*</span></label>
            <input type="text" id="txtName" required minlength="3" placeholder="Contoh: Budi Santoso" class="form-input">
        </div>

        <div class="form-group">
            <label for="txtEmail">Email Resmi <span class="req">*</span></label>
            <input type="email" id="txtEmail" required placeholder="budi@kantor.com" class="form-input">
        </div>

        <div class="form-row">
            <div class="form-group half">
                <label for="txtPeminatan">Peminatan <span class="req">*</span></label>
                <select id="txtPeminatan" required class="form-input">
                    <option value="">Pilih Jalur</option>
                    <option value="frontend">Frontend Engineering</option>
                    <option value="backend">Backend Engineering</option>
                    <option value="fullstack">Full-Stack Development</option>
                </select>
            </div>
            <div class="form-group half">
                <label for="txtPengalaman">Pengalaman Coding</label>
                <select id="txtPengalaman" class="form-input">
                    <option value="nol">Pemula (Belum Pernah)</option>
                    <option value="dasar">Pernah Belajar Dasar</option>
                    <option value="mahir">Sudah Menengah</option>
                </select>
            </div>
        </div>

        <button type="submit" class="submit-btn">Kirim Pendaftaran Sekarang</button>

        <div id="alertSuccess" class="alert-success" style="display: none;">
            ✔ Berhasil! Seluruh data input memenuhi validasi standar HTML5 dan siap diproses server.
        </div>
    </form>
</div>',
            'css_code' => '.demo-card { max-width: 560px; margin: 30px auto; background: #0b1329; border: 1px solid #1e293b; border-radius: 20px; padding: 32px; color: #fff; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; box-shadow: 0 20px 45px rgba(0,0,0,0.6); }
.badge { display: inline-block; background: rgba(56, 189, 248, 0.1); color: #38bdf8; border: 1px solid rgba(56, 189, 248, 0.3); font-size: 10px; font-weight: 800; padding: 4px 12px; border-radius: 20px; margin-bottom: 12px; letter-spacing: 1px; }
.demo-header h2 { font-size: 22px; font-weight: 800; margin: 0 0 6px 0; color: #fff; }
.demo-header p { font-size: 12px; color: #94a3b8; margin: 0 0 24px 0; line-height: 1.5; }
.student-form { display: flex; flex-direction: column; gap: 16px; }
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
            'js_code' => 'console.log("HTML5 Demo Form Initialized");',
            'order' => $order++,
        ]);

        // -------------------------------------------------------------
        // KUMPULAN SOAL KUIS PILIHAN GANDA (10 SOAL LENGKAP)
        // -------------------------------------------------------------
        $questions = [
            [
                'title' => 'Tujuan Deklarasi <!DOCTYPE html>',
                'content' => 'Mengapa setiap dokumen web HTML5 wajib diawali dengan baris kode `<!DOCTYPE html>` pada baris pertamanya?',
                'options' => [
                    'Menghubungkan dokumen ke server internet secara otomatis',
                    'Menginstruksikan peramban agar merender halaman dalam mode standar (standards mode) dan mencegah mode kompatibilitas kuno',
                    'Mengimpor pustaka font eksternal dari CDN Google',
                    'Mengaktifkan fitur enkripsi data transaksi perbankan'
                ],
                'correct_answer' => 'Menginstruksikan peramban agar merender halaman dalam mode standar (standards mode) dan mencegah mode kompatibilitas kuno',
                'hint' => 'Fokus pada mode render standar browser.',
            ],
            [
                'title' => 'Aturan Penggunaan Tag Heading h1 untuk SEO',
                'content' => 'Berdasarkan standar praktik terbaik optimasi mesin pencari (SEO) dan struktur semantik HTML5, berapakah jumlah tag `<h1>` yang direkomendasikan berada dalam satu halaman web tunggal?',
                'options' => [
                    'Bebas sebanyak-banyaknya sesuai selera desain',
                    'Tepat SATU tag <h1> per halaman',
                    'Minimal 3 tag agar halaman mudah ditemukan di Google',
                    'Tidak boleh menggunakan <h1> sama sekali jika sudah ada tag title'
                ],
                'correct_answer' => 'Tepat SATU tag <h1> per halaman',
                'hint' => 'Hanya ada satu tajuk utama topik per halaman.',
            ],
            [
                'title' => 'Fungsi Atribut alt pada Tag Gambar <img>',
                'content' => 'Manakah fungsi utama yang paling tepat dari atribut `alt` pada elemen `<img>`?',
                'options' => [
                    'Menentukan efek animasi perputaran gambar saat di-hover',
                    'Memberikan teks deskriptif alternatif saat gambar gagal dimuat dan dibacakan oleh pembaca layar (screen reader) bagi penyandang disabilitas',
                    'Mengubah resolusi gambar secara otomatis menjadi format vector SVG',
                    'Mengompres ukuran byte file gambar sebelum diunggah ke hosting'
                ],
                'correct_answer' => 'Memberikan teks deskriptif alternatif saat gambar gagal dimuat dan dibacakan oleh pembaca layar (screen reader) bagi penyandang disabilitas',
                'hint' => 'alt singkatan dari alternative text untuk aksesibilitas.',
            ],
            [
                'title' => 'Keamanan Tautan Tab Baru (rel noopener)',
                'content' => 'Ketika membuat tautan eksternal yang membuka tab peramban baru menggunakan `target="_blank"`, pasangan atribut keamanan manakah yang wajib disertakan untuk mencegah celah keamanan reverse tabnabbing?',
                'options' => [
                    'security="high"',
                    'rel="noopener noreferrer"',
                    'sandbox="secure-tab"',
                    'protect="window-lock"'
                ],
                'correct_answer' => 'rel="noopener noreferrer"',
                'hint' => 'Menggunakan atribut rel yang memblokir window.opener.',
            ],
            [
                'title' => 'Tag Semantik untuk Konten Mandiri Independen',
                'content' => 'Elemen semantik HTML5 manakah yang paling tepat digunakan untuk membungkus sebuah konten mandiri yang dapat didistribusikan ulang atau berdiri sendiri secara utuh, seperti postingan blog, artikel berita, atau komentar pembaca?',
                'options' => [
                    '<section>',
                    '<article>',
                    '<aside>',
                    '<div>'
                ],
                'correct_answer' => '<article>',
                'hint' => 'Berarti artikel mandiri.',
            ],
            [
                'title' => 'Elemen Semantik Menu Navigasi Utama',
                'content' => 'Elemen semantik HTML5 manakah yang secara resmi ditetapkan oleh standar W3C untuk mengelompokkan tautan navigasi utama pada sebuah website?',
                'options' => [
                    '<menu>',
                    '<nav>',
                    '<navbar>',
                    '<links>'
                ],
                'correct_answer' => '<nav>',
                'hint' => 'Singkatan tiga huruf dari navigation.',
            ],
            [
                'title' => 'Atribut Wajib Isi pada Formulir HTML',
                'content' => 'Atribut HTML5 manakah yang digunakan pada elemen input formulir untuk menandai bahwa bidang tersebut wajib diisi oleh pengguna sebelum formulir diizinkan dikirim?',
                'options' => [
                    'validate',
                    'mandatory',
                    'required',
                    'important'
                ],
                'correct_answer' => 'required',
                'hint' => 'Berasal dari kata required (diwajibkan).',
            ],
            [
                'title' => 'Fungsi Elemen Meta Viewport',
                'content' => 'Apakah tujuan utama menyertakan tag `<meta name="viewport" content="width=device-width, initial-scale=1.0">` pada bagian `<head>` dokumen HTML?',
                'options' => [
                    'Mempercepat kecepatan unduh gambar dari CDN',
                    'Mengatur skala lebar layar agar tampilan responsif di berbagai perangkat ponsel pintar',
                    'Mencegah pengguna melakukan klik kanan pada halaman website',
                    'Menyambungkan file lembar gaya CSS secara otomatis'
                ],
                'correct_answer' => 'Mengatur skala lebar layar agar tampilan responsif di berbagai perangkat ponsel pintar',
                'hint' => 'Mengatur skala lebar viewport layar mobile.',
            ],
            [
                'title' => 'Pengoptimalan Kinerja Gambar dengan loading lazy',
                'content' => 'Apakah fungsi dari atribut `loading="lazy"` pada elemen `<img>` modern?',
                'options' => [
                    'Memberikan efek animasi gambar muncul perlahan (fade-in)',
                    'Menunda pengunduhan gambar sampai pengguna menggulir layar mendekati posisi gambar tersebut untuk menghemat bandwidth',
                    'Mengurangi resolusi warna gambar menjadi hitam putih saat koneksi lambat',
                    'Menghapus gambar dari server setelah dilihat satu kali oleh pengunjung'
                ],
                'correct_answer' => 'Menunda pengunduhan gambar sampai pengguna menggulir layar mendekati posisi gambar tersebut untuk menghemat bandwidth',
                'hint' => 'Lazy loading menunda proses pengunduhan aset yang belum tampak di layar.',
            ],
            [
                'title' => 'Elemen Semantik untuk Konten Sampingan (Sidebar)',
                'content' => 'Manakah elemen semantik HTML5 yang paling tepat digunakan untuk membungkus konten pendukung yang berhubungan secara tidak langsung dengan konten utama, seperti profil singkat penulis, daftar tautan populer, atau banner sponsor?',
                'options' => [
                    '<aside>',
                    '<sidebar>',
                    '<section>',
                    '<nav>'
                ],
                'correct_answer' => '<aside>',
                'hint' => 'Berada di samping (aside).',
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
            'title' => 'Tantangan Coding 1: Generator Tag Meta Deskripsi SEO',
            'content' => "Dalam sistem manajemen konten (CMS), teks deskripsi yang diinput penulis harus diubah menjadi tag meta HTML standar SEO:\n`<meta name=\"description\" content=\"...\">`.\n\n### Instruksi:\nBuatlah program JavaScript yang membaca 1 baris teks deskripsi dari pengguna, lalu cetak teks tersebut dalam format tag meta HTML lengkap tanpa spasi tambahan.\n\nContoh Input:\n`Belajar HTML5 dari dasar sampai mahir bersama TalentGroup`\n\nContoh Output yang Diharapkan:\n`<meta name=\"description\" content=\"Belajar HTML5 dari dasar sampai mahir bersama TalentGroup\">`",
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
            'hint' => 'Gabungkan string pembuka tag meta dengan nilai teks input dan tutup dengan tanda kutip.',
            'order' => $order++,
        ]);

        // Challenge 2
        CourseQuestion::create([
            'course_id' => $course->id,
            'question_type' => 'coding',
            'title' => 'Tantangan Coding 2: Generator Tautan Semantik Ramah SEO',
            'content' => "Dalam pembuatan menu navigasi, kita perlu mengubah teks menu dan URL tujuan menjadi elemen tautan HTML: `<a href=\"URL\">TEKS</a>`.\n\n### Instruksi:\nBuatlah program JavaScript yang membaca 1 baris input berisi URL dan Teks Menu yang dipisahkan oleh tanda koma (`,`), lalu cetak format tag `<a>` HTML lengkap.\n\nContoh Input:\n`/kursus,Daftar Kursus`\n\nContoh Output:\n`<a href=\"/kursus\">Daftar Kursus</a>`",
            'language' => 'javascript',
            'starter_code' => "const readline = require('readline');
const rl = readline.createInterface({ input: process.stdin, output: process.stdout });

rl.on('line', (line) => {
    const parts = line.trim().split(',');
    const url = parts[0].trim();
    const text = parts[1].trim();
    
    console.log('<a href=\"' + url + '\">' + text + '</a>');
    process.exit(0);
});",
            'expected_output' => '<a href=\"/kursus\">Daftar Kursus</a>',
            'test_cases' => [
                [
                    'input' => '/kursus,Daftar Kursus',
                    'expected_output' => '<a href=\"/kursus\">Daftar Kursus</a>'
                ],
                [
                    'input' => 'https://talentgroup.id,Portal Edukasi',
                    'expected_output' => '<a href=\"https://talentgroup.id\">Portal Edukasi</a>'
                ]
            ],
            'coding_rules' => ['console_log'],
            'hint' => 'Gunakan .split(",") untuk memisahkan URL dan Teks, lalu susun tag <a>.',
            'order' => $order++,
        ]);
    }
}
