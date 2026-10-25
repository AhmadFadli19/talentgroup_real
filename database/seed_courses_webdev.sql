-- ===================================================================
-- TalentGroup Academy - Data Seed Kursus & Modul Lengkap Web Dev
-- Kursus: HTML5, CSS3 Modern, dan JavaScript ES6+
-- Modul Dokumentasi: HTML5, CSS3, dan JavaScript
-- Tanggal Pembuatan: 2026-10-25 02:37:53
-- ===================================================================

SET FOREIGN_KEY_CHECKS=0;

-- -------------------------------------------------------------
-- Data untuk tabel `courses` (Total: 3 baris)
-- -------------------------------------------------------------
DELETE FROM `courses`;
INSERT INTO `courses` (`id`, `title`, `description`, `price`, `image`, `is_active`, `quiz_answer_visibility`, `quiz_navigation_mode`, `shuffle_questions`, `shuffle_options`, `created_by`, `created_at`, `updated_at`) VALUES (1, 'A01 - Pemrograman Web: HTML5 Modern & Semantik', 'Pelajari fondasi utama pembangunan website modern menggunakan standar HTML5 semantik, optimasi SEO, formulir interaktif dengan validasi komprehensif, struktur tabel, hingga integrasi multimedia.', 0.00, NULL, 1, 'end', 'free', 1, 1, 1, '2026-10-25 02:37:17', '2026-10-25 02:37:17');
INSERT INTO `courses` (`id`, `title`, `description`, `price`, `image`, `is_active`, `quiz_answer_visibility`, `quiz_navigation_mode`, `shuffle_questions`, `shuffle_options`, `created_by`, `created_at`, `updated_at`) VALUES (2, 'A02 - Desain Web Modern: CSS3, Flexbox & Responsive Layout', 'Kuasai seni menata dan mempercantik antarmuka web modern dengan CSS3. Pelajari konsep Box Model mendalam, Flexbox satu dimensi, CSS Grid dua dimensi, custom properties variabel tema, serta desain responsif mobile-first.', 75000.00, NULL, 1, 'end', 'free', 1, 1, 1, '2026-10-25 02:37:17', '2026-10-25 02:37:17');
INSERT INTO `courses` (`id`, `title`, `description`, `price`, `image`, `is_active`, `quiz_answer_visibility`, `quiz_navigation_mode`, `shuffle_questions`, `shuffle_options`, `created_by`, `created_at`, `updated_at`) VALUES (3, 'A03 - JavaScript Modern ES6+: Logika Pemrograman, DOM & Algoritma', 'Hidupkan website menjadi dinamis dan interaktif! Kuasai sintaks ES6+ terkini (let/const, arrow functions, destructuring), manipulasi Document Object Model (DOM), penanganan event, metode array mutakhir (map, filter, reduce), hingga pemanggilan API Asynchronous.', 99000.00, NULL, 1, 'end', 'free', 1, 1, 1, '2026-10-25 02:37:17', '2026-10-25 02:37:17');

-- -------------------------------------------------------------
-- Data untuk tabel `course_stories` (Total: 9 baris)
-- -------------------------------------------------------------
DELETE FROM `course_stories`;
INSERT INTO `course_stories` (`id`, `course_id`, `title`, `content`, `image_path`, `audio_path`, `video_url`, `use_image`, `use_audio`, `use_video`, `order`, `created_at`, `updated_at`) VALUES (1, 1, 'Anatomi & Struktur Dokumen HTML5 Standar', 'Selamat datang di modul perdana HTML5! HyperText Markup Language (HTML) adalah bahasa penanda standar yang menjadi tulang punggung dari seluruh halaman di internet.

### 1. Deklarasi Dokumen <!DOCTYPE html>
Pada era HTML lama (HTML4), deklarasi doctype sangat panjang dan rumit. Pada HTML5, deklarasi disederhanakan menjadi:
```html
<!DOCTYPE html>
```
Instruksi ini memberi sinyal kepada mesin peramban (browser) untuk merender halaman dalam mode standar (standards mode), mencegah browser beralih ke mode kompatibilitas kuno (quirks mode).

### 2. Elemen Akar & Metadata Head
- `<html lang=\"id\">`: Menentukan bahasa konten untuk mesin pencari dan pembaca layar (screen reader).
- `<meta charset=\"UTF-8\">`: Menetapkan pengkodean karakter universal agar mendukung berbagai karakter alfabet dan simbol dunia.
- `<meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">`: Elemen krusial agar tampilan website dapat menyesuaikan lebar layar perangkat seluler secara responsif.

### 3. Bagian Body
Semua konten visual yang dapat dilihat dan berinteraksi langsung dengan pengguna (teks, gambar, tombol, formulir) diletakkan di dalam tag `<body>`.', NULL, NULL, NULL, 0, 0, 0, 1, '2026-10-25 02:37:17', '2026-10-25 02:37:17');
INSERT INTO `course_stories` (`id`, `course_id`, `title`, `content`, `image_path`, `audio_path`, `video_url`, `use_image`, `use_audio`, `use_video`, `order`, `created_at`, `updated_at`) VALUES (2, 1, 'Elemen Semantik & Optimasi Mesin Pencari (SEO)', 'Sebelum HTML5, pengembang web terbiasa membungkus setiap bagian dengan tag `<div>` yang tidak bermakna (dikenal sebagai istilah \'div-soup\'), misalnya `<div class=\"header\">` atau `<div id=\"footer\">`.

### Mengapa Elemen Semantik Sangat Penting?
Elemen semantik secara jelas mendeskripsikan maknanya kepada browser, mesin pencari (Googlebot), dan teknologi bantu disabilitas (Screen Reader):

1. `<header>`: Mewakili pengantar atau grup tautan navigasi pembuka halaman/artikel.
2. `<nav>`: Bagian khusus yang memuat tautan navigasi utama website.
3. `<main>`: Memuat konten unik dominan pada dokumen. Hanya boleh ada satu tag `<main>` per halaman!
4. `<section>`: Pengelompokan tematik konten yang umumnya memiliki judul tersendiri (heading).
5. `<article>`: Bagian mandiri yang dapat didistribusikan secara independen (contoh: postingan blog, berita, komentar).
6. `<aside>`: Konten pendukung seperti sidebar, tautan terkait, atau iklan.
7. `<footer>`: Catatan penutup dokumen yang memuat hak cipta, kontak, dan tautan sosial media.

Dengan menerapkan semantik, website Anda mendapatkan peringkat SEO yang jauh lebih unggul karena mesin pencari memahami struktur hierarki informasi secara presisi.', NULL, NULL, NULL, 0, 0, 0, 2, '2026-10-25 02:37:17', '2026-10-25 02:37:17');
INSERT INTO `course_stories` (`id`, `course_id`, `title`, `content`, `image_path`, `audio_path`, `video_url`, `use_image`, `use_audio`, `use_video`, `order`, `created_at`, `updated_at`) VALUES (3, 1, 'Formulir Modern, Kontrol Input & Validasi', 'Formulir adalah jembatan utama interaksi dua arah antara pengunjung dengan aplikasi Anda. HTML5 memperkenalkan berbagai tipe kontrol input yang memiliki validasi bawaan tanpa memerlukan kode JavaScript tambahan.

### Tipe Input Populer & Praktis:
1. `type=\"email\"`: Memastikan pengguna memasukkan format alamat surel yang valid dengan simbol `@`.
2. `type=\"password\"`: Menyembunyikan karakter kata sandi demi privasi pengguna.
3. `type=\"number\"`: Hanya mengizinkan karakter angka, didukung atribut `min`, `max`, dan `step`.
4. `type=\"date\"`: Menampilkan pemilih kalender visual bawaan browser.

### Atribut Pengaman & Validasi Penting:
- `required`: Mewajibkan field input diisi sebelum tombol submit dapat dieksekusi.
- `placeholder`: Memberikan petunjuk visual teks bayangan contoh pengisian.
- `autocomplete=\"off\"`: Mencegah peramban menyimpan data sensitif seperti token atau PIN.
- `pattern=\"[0-9]{10,12}\"`: Validasi ekspresi reguler (Regex) untuk nomor telepon atau identitas.', NULL, NULL, NULL, 0, 0, 0, 4, '2026-10-25 02:37:17', '2026-10-25 02:37:17');
INSERT INTO `course_stories` (`id`, `course_id`, `title`, `content`, `image_path`, `audio_path`, `video_url`, `use_image`, `use_audio`, `use_video`, `order`, `created_at`, `updated_at`) VALUES (4, 2, 'Memahami CSS Box Model & Rahasia Box-Sizing', 'Setiap elemen yang dirender pada dokumen web pada dasarnya adalah sebuah kotak persegi panjang. Konsep ini dikenal sebagai CSS Box Model.

### 4 Lapisan Utama Box Model:
1. **Content**: Area inti tempat teks, gambar, atau elemen anak ditampilkan.
2. **Padding**: Ruang transparan di dalam elemen yang memisahkan konten dari garis tepi (border).
3. **Border**: Garis tepi pembungkus yang mengelilingi padding dan konten.
4. **Margin**: Ruang luar transparan yang memisahkan elemen dari elemen tetangga di sekitarnya.

### Masalah `content-box` vs Solusi `border-box`
Secara default browser menggunakan `box-sizing: content-box`. Artinya jika Anda menetapkan `width: 200px` dan menambahkan `padding: 20px`, total lebar elemen menjadi 240px! Hal ini sering membuat tata letak berantakan.

Solusi standar industri modern adalah menggunakan reset universal:
```css
*, *::before, *::after {
    box-sizing: border-box;
}
```
Dengan `border-box`, nilai padding dan border akan dihitung ke dalam total lebar elemen, sehingga dimensi tata letak tetap konsisten dan presisi.', NULL, NULL, NULL, 0, 0, 0, 1, '2026-10-25 02:37:17', '2026-10-25 02:37:17');
INSERT INTO `course_stories` (`id`, `course_id`, `title`, `content`, `image_path`, `audio_path`, `video_url`, `use_image`, `use_audio`, `use_video`, `order`, `created_at`, `updated_at`) VALUES (5, 2, 'Flexbox Layout: Penataan Satu Dimensi Fleksibel', 'Flexbox (Flexible Box Layout) dirancang khusus untuk membagi ruang dan meratakan elemen anak secara konsisten di sepanjang satu dimensi (baik horizontal berupa baris maupun vertikal berupa kolom).

### Properti Penting Kontainer Flex:
- `display: flex`: Mengaktifkan konteks fleksibel pada elemen kontainer.
- `flex-direction`: Menentukan arah sumbu utama (`row`, `row-reverse`, `column`, `column-reverse`).
- `justify-content`: Mengatur perataan item di sepanjang **sumbu utama (main-axis)**: `flex-start`, `center`, `flex-end`, `space-between`, `space-around`.
- `align-items`: Mengatur perataan item di sepanjang **sumbu silang (cross-axis)**: `stretch`, `center`, `flex-start`, `flex-end`.
- `gap`: Memberikan jarak seragam antar elemen anak tanpa perlu repot mengatur margin manual!

### Contoh Kasus Navigasi Bar:
```css
.navbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 1.5rem;
    padding: 1rem 2rem;
}
```', NULL, NULL, NULL, 0, 0, 0, 2, '2026-10-25 02:37:17', '2026-10-25 02:37:17');
INSERT INTO `course_stories` (`id`, `course_id`, `title`, `content`, `image_path`, `audio_path`, `video_url`, `use_image`, `use_audio`, `use_video`, `order`, `created_at`, `updated_at`) VALUES (6, 2, 'CSS Grid Layout: Arsitektur Tata Letak Dua Dimensi', 'Jika Flexbox dirancang untuk susunan satu arah, CSS Grid adalah sistem layout dua dimensi yang mampu mengendalikan kolom (columns) dan baris (rows) secara simultan.

### Sintaks Fundamental Grid:
```css
.gallery-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 20px;
}
```

### Makna Sintaks `repeat(auto-fit, minmax(280px, 1fr))`:
1. `auto-fit`: Secara cerdas memperluas kolom yang ada untuk mengisi seluruh ruang kontainer yang tersedia.
2. `minmax(280px, 1fr)`: Menetapkan batas ukuran kolom minimal sebesar 280px, dan maksimal 1 fraction (1fr) dari sisa ruang kosong.

Dengan pola di atas, Anda telah menciptakan layout galeri responsif sempurna tanpa perlu menulis satupun baris `@media` query!', NULL, NULL, NULL, 0, 0, 0, 4, '2026-10-25 02:37:17', '2026-10-25 02:37:17');
INSERT INTO `course_stories` (`id`, `course_id`, `title`, `content`, `image_path`, `audio_path`, `video_url`, `use_image`, `use_audio`, `use_video`, `order`, `created_at`, `updated_at`) VALUES (7, 3, 'Evolusi Sintaks ES6+: Dari var Menuju let & const', 'JavaScript modern mengalami lonjakan standar sejak diperkenalkannya ECMAScript 2015 (ES6). Salah satu perubahan paling krusial adalah pengelolaan variabel.

### Mengapa Tidak Boleh Lagi Menggunakan `var`?
1. **Function Scope vs Block Scope**: Variabel `var` tidak mengenal cakupan kurung kurawal `{}` (block scope), sehingga rawan bocor (*leak*) dan menimpa variabel di luar perulangan.
2. **Hoisting Membingungkan**: Variabel `var` dapat diakses sebelum dideklarasikan, menghasilkan nilai `undefined` yang menyulitkan proses debugging.

### Aturan Emas JavaScript Modern:
- Gunakan `const` secara default untuk seluruh deklarasi variabel yang referensinya tidak akan diubah.
- Gunakan `let` hanya jika nilai variabel memang perlu di-reassign (misalnya counter perulangan for).

### Arrow Functions (Sintaks Ringkas):
```javascript
// Gaya Lama ES5
function tambah(a, b) {
    return a + b;
}

// Gaya Modern ES6
const tambah = (a, b) => a + b;
```', NULL, NULL, NULL, 0, 0, 0, 1, '2026-10-25 02:37:17', '2026-10-25 02:37:17');
INSERT INTO `course_stories` (`id`, `course_id`, `title`, `content`, `image_path`, `audio_path`, `video_url`, `use_image`, `use_audio`, `use_video`, `order`, `created_at`, `updated_at`) VALUES (8, 3, 'Kekuatan Metode Array Fungsional: map, filter & reduce', 'Dalam pengembangan aplikasi web profesional, pengembang jarang lagi menuliskan perulangan tradisional `for (let i = 0; ...)` untuk mengolah data koleksi. Sebagai gantinya, kita memanfaatkan metode array fungsional yang lebih bersih dan deklaratif:

### 1. `Array.prototype.map()`
Mentransformasi setiap elemen dalam array dan mengembalikan array baru dengan panjang yang identik:
```javascript
const hargaRupiah = [10000, 25000, 50000];
const denganPajak = hargaRupiah.map(h => h * 1.11);
```

### 2. `Array.prototype.filter()`
Menyaring elemen array berdasarkan kondisi pengujian tertentu. Hanya elemen yang menghasilkan `true` yang akan disertakan pada array baru:
```javascript
const produk = [
    { nama: \'Mouse\', stok: 5 },
    { nama: \'Keyboard\', stok: 0 },
    { nama: \'Monitor\', stok: 2 }
];
const produkTersedia = produk.filter(p => p.stok > 0);
```

### 3. `Array.prototype.reduce()`
Akumulasi seluruh nilai elemen array menjadi satu nilai tunggal (misal: menghitung grand total belanjaan).', NULL, NULL, NULL, 0, 0, 0, 2, '2026-10-25 02:37:17', '2026-10-25 02:37:17');
INSERT INTO `course_stories` (`id`, `course_id`, `title`, `content`, `image_path`, `audio_path`, `video_url`, `use_image`, `use_audio`, `use_video`, `order`, `created_at`, `updated_at`) VALUES (9, 3, 'Asynchronous JavaScript, Promises & Fetch API', 'Secara mendasar JavaScript berjalan dalam satu utas tunggal (*single-threaded*). Namun, operasi seperti mengambil data dari server database tidak boleh memblokir antarmuka pengguna.

### Dari Callback Hell Menuju async / await:
Pada masa lalu, penanganan proses asinkronus menggunakan callback bersarang yang rumit. Kini dengan fitur `async` dan `await`, kita dapat menulis kode asinkronus dengan tampilan bersih layaknya kode sinkronus:

```javascript
async function ambilDaftarSiswa() {
    try {
        const response = await fetch(\'https://api.talentgroup.id/v1/students\');
        if (!response.ok) {
            throw new Error(\'Gagal menghubungi server\');
        }
        const data = await response.json();
        console.log(\'Total Siswa:\', data.length);
        return data;
    } catch (error) {
        console.error(\'Terjadi kesalahan:\', error.message);
    }
}
```', NULL, NULL, NULL, 0, 0, 0, 4, '2026-10-25 02:37:17', '2026-10-25 02:37:17');

-- -------------------------------------------------------------
-- Data untuk tabel `course_questions` (Total: 12 baris)
-- -------------------------------------------------------------
DELETE FROM `course_questions`;
INSERT INTO `course_questions` (`id`, `course_id`, `question_type`, `title`, `content`, `options`, `correct_answer`, `admin_code`, `starter_code`, `expected_output`, `coding_rules`, `test_cases`, `hint`, `language`, `order`, `created_at`, `updated_at`) VALUES (1, 1, 'question', 'Tag Semantik untuk Navigasi Utama', 'Dalam standar penyusunan kode HTML5 yang ramah SEO dan aksesibilitas, manakah elemen semantik yang secara resmi direkomendasikan untuk membungkus daftar menu navigasi utama situs web?', '[\"navbar\", \"nav\", \"navigation\", \"menu\"]', 'nav', NULL, NULL, NULL, NULL, NULL, 'Elemen ini disingkat menjadi 3 huruf.', 'go', 5, '2026-10-25 02:37:17', '2026-10-25 02:37:17');
INSERT INTO `course_questions` (`id`, `course_id`, `question_type`, `title`, `content`, `options`, `correct_answer`, `admin_code`, `starter_code`, `expected_output`, `coding_rules`, `test_cases`, `hint`, `language`, `order`, `created_at`, `updated_at`) VALUES (2, 1, 'question', 'Fungsi Elemen Meta Viewport', 'Apakah tujuan utama menyertakan tag `<meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">` pada bagian `<head>` dokumen HTML?', '[\"Mempercepat kecepatan unduhan aset gambar di server\", \"Menghubungkan file lembar gaya CSS eksternal secara otomatis\", \"Mengatur skala lebar layar agar tampilan responsif di berbagai perangkat seluler\", \"Mencegah pengguna melakukan klik kanan pada halaman website\"]', 'Mengatur skala lebar layar agar tampilan responsif di berbagai perangkat seluler', NULL, NULL, NULL, NULL, NULL, 'Fokus pada kata viewport dan skala ukuran layar smartphone.', 'go', 6, '2026-10-25 02:37:17', '2026-10-25 02:37:17');
INSERT INTO `course_questions` (`id`, `course_id`, `question_type`, `title`, `content`, `options`, `correct_answer`, `admin_code`, `starter_code`, `expected_output`, `coding_rules`, `test_cases`, `hint`, `language`, `order`, `created_at`, `updated_at`) VALUES (3, 1, 'question', 'Atribut Wajib Isi pada Formulir HTML', 'Atribut HTML5 manakah yang digunakan untuk menandai bahwa suatu elemen formulir wajib diisi oleh pengguna sebelum data formulir dapat dikirim ke server?', '[\"validate\", \"mandatory\", \"required\", \"important\"]', 'required', NULL, NULL, NULL, NULL, NULL, 'Berasal dari kata kerja bahasa Inggris yang berarti dibutuhkan/diwajibkan.', 'go', 7, '2026-10-25 02:37:17', '2026-10-25 02:37:17');
INSERT INTO `course_questions` (`id`, `course_id`, `question_type`, `title`, `content`, `options`, `correct_answer`, `admin_code`, `starter_code`, `expected_output`, `coding_rules`, `test_cases`, `hint`, `language`, `order`, `created_at`, `updated_at`) VALUES (4, 1, 'coding', 'Tantangan Logika: Generator URL Slug Halaman HTML', 'Dalam pembuatan halaman web, setiap judul artikel HTML harus diubah menjadi format URL ramah SEO (Slug).

### Instruksi:
Buatlah program JavaScript yang menerima teks judul halaman, lalu ubah seluruh karakter menjadi huruf kecil (lowercase) dan gantikan spasi dengan tanda minus `-`.

Contoh Input:
`Belajar HTML5 Semantik`

Contoh Output yang Diharapkan:
`belajar-html5-semantik`', NULL, NULL, NULL, 'const readline = require(\'readline\');
const rl = readline.createInterface({ input: process.stdin, output: process.stdout });

rl.on(\'line\', (line) => {
    const slug = line.trim().toLowerCase().replace(/\\s+/g, \'-\');
    console.log(slug);
    process.exit(0);
});', 'belajar-html5-semantik', '[\"console_log\"]', '[{\"input\": \"Belajar HTML5 Semantik\", \"expected_output\": \"belajar-html5-semantik\"}, {\"input\": \"Panduan Form Web Modern\", \"expected_output\": \"panduan-form-web-modern\"}]', 'Gunakan metode .toLowerCase() dan .replace(/\\s+/g, \"-\") lalu cetak dengan console.log()', 'javascript', 8, '2026-10-25 02:37:17', '2026-10-25 02:37:17');
INSERT INTO `course_questions` (`id`, `course_id`, `question_type`, `title`, `content`, `options`, `correct_answer`, `admin_code`, `starter_code`, `expected_output`, `coding_rules`, `test_cases`, `hint`, `language`, `order`, `created_at`, `updated_at`) VALUES (5, 2, 'question', 'Perataan Item Sumbu Utama pada Flexbox', 'Properti CSS Flexbox manakah yang digunakan secara khusus untuk mengatur perataan elemen anak (flex items) di sepanjang sumbu utama (main axis)?', '[\"align-items\", \"justify-content\", \"align-content\", \"flex-spread\"]', 'justify-content', NULL, NULL, NULL, NULL, NULL, 'Dimulai dengan kata justify yang mengatur posisi horisontal pada orientasi row default.', 'go', 5, '2026-10-25 02:37:17', '2026-10-25 02:37:17');
INSERT INTO `course_questions` (`id`, `course_id`, `question_type`, `title`, `content`, `options`, `correct_answer`, `admin_code`, `starter_code`, `expected_output`, `coding_rules`, `test_cases`, `hint`, `language`, `order`, `created_at`, `updated_at`) VALUES (6, 2, 'question', 'Perilaku Nilai Properti box-sizing: border-box', 'Bagaimanakah peramban (browser) menghitung total dimensi elemen saat dideklarasikan `box-sizing: border-box`?', '[\"Padding dan border akan dihitung di luar ukuran width/height elemen\", \"Nilai margin elemen secara otomatis dikonversi menjadi padding internal\", \"Padding dan border disertakan ke dalam total ukuran width dan height elemen\", \"Elemen secara otomatis berubah format menjadi elemen inline-block\"]', 'Padding dan border disertakan ke dalam total ukuran width dan height elemen', NULL, NULL, NULL, NULL, NULL, 'Border dan padding melebur ke dalam ukuran kotak.', 'go', 6, '2026-10-25 02:37:17', '2026-10-25 02:37:17');
INSERT INTO `course_questions` (`id`, `course_id`, `question_type`, `title`, `content`, `options`, `correct_answer`, `admin_code`, `starter_code`, `expected_output`, `coding_rules`, `test_cases`, `hint`, `language`, `order`, `created_at`, `updated_at`) VALUES (7, 2, 'question', 'Satuan Fractional Unit (fr) pada CSS Grid', 'Dalam sistem tata letak CSS Grid, apakah arti dan fungsi dari satuan unit `fr` (fractional unit)?', '[\"Satuan ukuran frame per detik pada animasi CSS keyframes\", \"Pecahan fraksi yang membagi ruang kosong yang tersedia secara proporsional\", \"Satuan absolut yang setara dengan 16 piksel standar monitor\", \"Persentase tetap dari lebar jendela browser secara keseluruhan\"]', 'Pecahan fraksi yang membagi ruang kosong yang tersedia secara proporsional', NULL, NULL, NULL, NULL, NULL, 'fr singkatan dari fraction (pecahan bagian ruang bebas).', 'go', 7, '2026-10-25 02:37:17', '2026-10-25 02:37:17');
INSERT INTO `course_questions` (`id`, `course_id`, `question_type`, `title`, `content`, `options`, `correct_answer`, `admin_code`, `starter_code`, `expected_output`, `coding_rules`, `test_cases`, `hint`, `language`, `order`, `created_at`, `updated_at`) VALUES (8, 2, 'coding', 'Tantangan Logika: Hitung Ketinggian Kontainer Aspek Rasio 16:9', 'Dalam CSS modern, kita sering menentukan ketinggian elemen media video responsif berdasarkan rasio aspek 16:9 (`aspect-ratio: 16 / 9`).

### Instruksi:
Buatlah program JavaScript yang menerima input satu baris berupa angka lebar layar (Width dalam pixel), lalu hitung dan cetak ketinggian (Height) dengan rasio 16:9 menggunakan format angka bulat (Math.round).

Rumus:
`Height = Math.round((Width * 9) / 16)`

Contoh Input:
`1920`

Contoh Output:
`1080`', NULL, NULL, NULL, 'const readline = require(\'readline\');
const rl = readline.createInterface({ input: process.stdin, output: process.stdout });

rl.on(\'line\', (line) => {
    const width = parseFloat(line.trim());
    const height = Math.round((width * 9) / 16);
    console.log(height);
    process.exit(0);
});', 1080, '[\"console_log\"]', '[{\"input\": \"1920\", \"expected_output\": \"1080\"}, {\"input\": \"1280\", \"expected_output\": \"720\"}]', 'Kalikan width dengan 9, bagi 16, lalu bulatkan dengan Math.round()', 'javascript', 8, '2026-10-25 02:37:17', '2026-10-25 02:37:17');
INSERT INTO `course_questions` (`id`, `course_id`, `question_type`, `title`, `content`, `options`, `correct_answer`, `admin_code`, `starter_code`, `expected_output`, `coding_rules`, `test_cases`, `hint`, `language`, `order`, `created_at`, `updated_at`) VALUES (9, 3, 'question', 'Deklarasi Variabel Tetap pada ES6', 'Kata kunci (keyword) manakah pada standar JavaScript ES6 yang digunakan untuk mendeklarasikan variabel yang referensi nilainya bersifat konstan dan tidak dapat di-reassign kembali?', '[\"var\", \"let\", \"const\", \"static\"]', 'const', NULL, NULL, NULL, NULL, NULL, 'Singkatan dari constant.', 'go', 5, '2026-10-25 02:37:17', '2026-10-25 02:37:17');
INSERT INTO `course_questions` (`id`, `course_id`, `question_type`, `title`, `content`, `options`, `correct_answer`, `admin_code`, `starter_code`, `expected_output`, `coding_rules`, `test_cases`, `hint`, `language`, `order`, `created_at`, `updated_at`) VALUES (10, 3, 'question', 'Metode Array untuk Menyaring Data', 'Metode array JavaScript manakah yang mengeksekusi fungsi callback pada setiap elemen dan menghasilkan array baru yang hanya memuat elemen-elemen dengan kondisi bernilai `true`?', '[\"map()\", \"filter()\", \"find()\", \"reduce()\"]', 'filter()', NULL, NULL, NULL, NULL, NULL, 'Bermakna menyaring dalam bahasa Indonesia.', 'go', 6, '2026-10-25 02:37:17', '2026-10-25 02:37:17');
INSERT INTO `course_questions` (`id`, `course_id`, `question_type`, `title`, `content`, `options`, `correct_answer`, `admin_code`, `starter_code`, `expected_output`, `coding_rules`, `test_cases`, `hint`, `language`, `order`, `created_at`, `updated_at`) VALUES (11, 3, 'question', 'Sintaks Penanganan Promise Modern', 'Pasangan sintaks manakah yang diperkenalkan untuk menyederhanakan penanganan Promise sehingga alur kode asinkronus dapat dibaca secara sekuensial dan rapi?', '[\"try / catch\", \"async / await\", \"then / catch\", \"defer / resolve\"]', 'async / await', NULL, NULL, NULL, NULL, NULL, 'Fungsi diawali kata async dan pemanggilan Promise menggunakan kata await.', 'go', 7, '2026-10-25 02:37:17', '2026-10-25 02:37:17');
INSERT INTO `course_questions` (`id`, `course_id`, `question_type`, `title`, `content`, `options`, `correct_answer`, `admin_code`, `starter_code`, `expected_output`, `coding_rules`, `test_cases`, `hint`, `language`, `order`, `created_at`, `updated_at`) VALUES (12, 3, 'coding', 'Tantangan Coding: Filter Angka Genap', 'Buatlah program JavaScript yang membaca deretan angka yang dipisahkan dengan spasi, lalu cetak hanya angka yang bernilai genap saja, dipisahkan oleh spasi.

Contoh Input:
`1 2 3 4 5 6 7 8`

Contoh Output:
`2 4 6 8`', NULL, NULL, NULL, 'const readline = require(\'readline\');
const rl = readline.createInterface({ input: process.stdin, output: process.stdout });

rl.on(\'line\', (line) => {
    // 1. Pecah string menjadi array angka
    const numbers = line.trim().split(/\\s+/).map(Number);
    
    // 2. Filter angka genap (n % 2 === 0)
    const evens = numbers.filter(n => n % 2 === 0);
    
    // 3. Gabungkan kembali dengan spasi
    console.log(evens.join(\' \'));
    process.exit(0);
});', '2 4 6 8', '[\"console_log\", \"filter_map\"]', '[{\"input\": \"1 2 3 4 5 6 7 8\", \"expected_output\": \"2 4 6 8\"}, {\"input\": \"10 15 20 25 30\", \"expected_output\": \"10 20 30\"}]', 'Gunakan .filter(n => n % 2 === 0) dan gabungkan dengan .join(\" \")', 'javascript', 8, '2026-10-25 02:37:17', '2026-10-25 02:37:17');

-- -------------------------------------------------------------
-- Data untuk tabel `course_htmls` (Total: 3 baris)
-- -------------------------------------------------------------
DELETE FROM `course_htmls`;
INSERT INTO `course_htmls` (`id`, `course_id`, `title`, `content`, `html_code`, `css_code`, `js_code`, `order`, `created_at`, `updated_at`) VALUES (1, 1, 'Live Demo: Layout Portofolio Semantik HTML5', 'Pelajari implementasi nyata susunan tag semantik HTML5 di bawah ini. Elemen-elemen ini telah diatur dengan tata letak modern yang bersih dan responsif.', '<div class=\"profile-container\">
    <header class=\"main-header\">
        <span class=\"badge\">PROFIL PENGEMBANG</span>
        <h1>Ahmad Fauzi Pratama</h1>
        <p class=\"subtitle\">Full-Stack Web Developer & UI/UX Enthusiast</p>
    </header>

    <main class=\"content-body\">
        <section class=\"card\">
            <h3>Tentang Saya</h3>
            <p>Berpengalaman lebih dari 4 tahun dalam merancang antarmuka web yang cepat, responsif, dan ramah aksesibilitas.</p>
        </section>

        <section class=\"card\">
            <h3>Keahlian Utama</h3>
            <div class=\"skills\">
                <span class=\"skill-tag\">HTML5 Semantik</span>
                <span class=\"skill-tag\">CSS3 Grid & Flexbox</span>
                <span class=\"skill-tag\">JavaScript Modern</span>
                <span class=\"skill-tag\">RESTful API</span>
            </div>
        </section>
    </main>

    <footer class=\"footer-note\">
        <p>&copy; 2026 TalentGroup Academy. Dokumen standar HTML5.</p>
    </footer>
</div>', '.profile-container { max-width: 650px; margin: 30px auto; padding: 25px; background: #0f172a; color: #f8fafc; font-family: -apple-system, BlinkMacSystemFont, \"Segoe UI\", Roboto, sans-serif; border-radius: 16px; border: 1px solid #334155; box-shadow: 0 10px 30px rgba(0,0,0,0.5); }
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
.footer-note { text-align: center; border-top: 1px solid #1e293b; padding-top: 15px; font-size: 11px; color: #64748b; }', 'console.log(\"HTML5 Portfolio Demo Loaded Successfully\");', 3, '2026-10-25 02:37:17', '2026-10-25 02:37:17');
INSERT INTO `course_htmls` (`id`, `course_id`, `title`, `content`, `html_code`, `css_code`, `js_code`, `order`, `created_at`, `updated_at`) VALUES (2, 2, 'Live Demo: Komponen Kartu Langganan Responsif', 'Eksplorasi komponen kartu harga dengan layout Flexbox modern, efek transisi melayang (*hover lift*), dan variabel warna bertema neon cyberpunk.', '<div class=\"pricing-wrapper\">
    <div class=\"pricing-card\">
        <div class=\"card-badge\">POPULER</div>
        <h3 class=\"plan-name\">Paket Full-Stack Pro</h3>
        <p class=\"plan-desc\">Akses seluruh modul HTML, CSS, JS hingga sertifikasi resmi.</p>
        <div class=\"price\">
            <span class=\"currency\">Rp</span>
            <span class=\"amount\">99.000</span>
            <span class=\"period\">/bulan</span>
        </div>
        <ul class=\"features\">
            <li>✔ Akses 50+ Modul Interaktif</li>
            <li>✔ Live Compiler Coding Otomatis</li>
            <li>✔ Sertifikat Terverifikasi QR</li>
            <li>✔ Konsultasi Mentor Komunitas</li>
        </ul>
        <button class=\"btn-claim\">Daftar Sekarang</button>
    </div>
</div>', ':root { --primary-accent: #00ff88; --bg-surface: #0a0e1a; --border-color: #1f293d; --text-muted: #94a3b8; }
.pricing-wrapper { display: flex; justify-content: center; padding: 40px 20px; font-family: -apple-system, BlinkMacSystemFont, \"Segoe UI\", Roboto, sans-serif; }
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
.btn-claim:hover { opacity: 0.9; }', 'console.log(\"CSS Pricing Card Demo Ready\");', 3, '2026-10-25 02:37:17', '2026-10-25 02:37:17');
INSERT INTO `course_htmls` (`id`, `course_id`, `title`, `content`, `html_code`, `css_code`, `js_code`, `order`, `created_at`, `updated_at`) VALUES (3, 3, 'Live Demo: Widget Penghitung Interaktif Real-Time', 'Pelajari bagaimana kode JavaScript mengikat event click pada tombol HTML, memperbarui nilai state di memori, dan mengubah tampilan antarmuka secara instan.', '<div class=\"counter-box\">
    <div class=\"counter-header\">
        <span class=\"badge\">MANIPULASI DOM LIVE</span>
        <h2>Penghitung Tiket Seminar</h2>
    </div>

    <div class=\"display-wrap\">
        <span id=\"counterValue\" class=\"counter-number\">1</span>
        <span class=\"ticket-status\" id=\"ticketStatus\">Tiket Tersedia</span>
    </div>

    <div class=\"controls\">
        <button id=\"btnMinus\" class=\"ctrl-btn minus\" onclick=\"updateCounter(-1)\">-</button>
        <button id=\"btnReset\" class=\"ctrl-btn reset\" onclick=\"resetCounter()\">Reset</button>
        <button id=\"btnPlus\" class=\"ctrl-btn plus\" onclick=\"updateCounter(1)\">+</button>
    </div>

    <div class=\"subtotal-note\">
        Total Biaya: <strong id=\"totalCost\">Rp 50.000</strong>
    </div>
</div>', '.counter-box { max-width: 420px; margin: 30px auto; background: #0b1329; border: 2px solid #1e293b; border-radius: 20px; padding: 28px; text-align: center; color: #fff; font-family: -apple-system, BlinkMacSystemFont, \"Segoe UI\", Roboto, sans-serif; box-shadow: 0 20px 40px rgba(0,0,0,0.6); }
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
.subtotal-note strong { color: #facc15; }', 'let count = 1;
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
    const el = document.getElementById(\"counterValue\");
    const totalEl = document.getElementById(\"totalCost\");
    if(el) el.innerText = count;
    if(totalEl) totalEl.innerText = \"Rp \" + (count * pricePerTicket).toLocaleString(\"id-ID\");
}', 3, '2026-10-25 02:37:17', '2026-10-25 02:37:17');

-- -------------------------------------------------------------
-- Data untuk tabel `module_categories` (Total: 3 baris)
-- -------------------------------------------------------------
DELETE FROM `module_categories`;
INSERT INTO `module_categories` (`id`, `name`, `slug`, `description`, `is_public`, `referral_code`, `image`, `icon`, `color`, `badge`, `order`, `is_active`, `enable_anti_screenshot`, `enable_anti_copy`, `created_at`, `updated_at`) VALUES (1, 'Modul Dokumentasi HTML5 Komprehensif', 'modul-html5-komprehensif', 'Referensi lengkap struktur standar HTML5, semantik SEO, formulir validasi, tabel data, dan multimedia.', 1, NULL, NULL, 'fab fa-html5', '#f97316', 'Fondasi Web', 1, 1, 0, 0, '2026-10-25 02:37:17', '2026-10-25 02:37:17');
INSERT INTO `module_categories` (`id`, `name`, `slug`, `description`, `is_public`, `referral_code`, `image`, `icon`, `color`, `badge`, `order`, `is_active`, `enable_anti_screenshot`, `enable_anti_copy`, `created_at`, `updated_at`) VALUES (2, 'Modul Dokumentasi CSS3 & Tata Letak Modern', 'modul-css3-dan-layout-modern', 'Panduan arsitektur antarmuka web dengan Flexbox, CSS Grid, media queries responsif, dan variabel tema.', 1, NULL, NULL, 'fab fa-css3-alt', '#38bdf8', 'Desain Web', 2, 1, 0, 0, '2026-10-25 02:37:17', '2026-10-25 02:37:17');
INSERT INTO `module_categories` (`id`, `name`, `slug`, `description`, `is_public`, `referral_code`, `image`, `icon`, `color`, `badge`, `order`, `is_active`, `enable_anti_screenshot`, `enable_anti_copy`, `created_at`, `updated_at`) VALUES (3, 'Modul Dokumentasi JavaScript ES6+ & DOM', 'modul-javascript-es6-dan-dom', 'Arsitektur pemrograman logika JavaScript modern, manipulasi DOM, event listener, dan penanganan asynchronous.', 1, NULL, NULL, 'fab fa-js-square', '#facc15', 'Logika Web', 3, 1, 0, 0, '2026-10-25 02:37:17', '2026-10-25 02:37:17');

-- -------------------------------------------------------------
-- Data untuk tabel `modules` (Total: 6 baris)
-- -------------------------------------------------------------
DELETE FROM `modules`;
INSERT INTO `modules` (`id`, `category_id`, `section`, `title`, `slug`, `content_type`, `excerpt`, `content`, `file_path`, `file_name`, `file_size`, `order`, `is_published`, `is_public`, `referral_code`, `enable_protection`, `enable_anti_screenshot`, `enable_anti_copy`, `views_count`, `created_at`, `updated_at`) VALUES (1, 1, 'FONDASI & DOKUMEN', 'Struktur Anatomi Dokumen HTML5', 'struktur-anatomi-dokumen-html5', 'document', 'Mengenal hierarki tag DOCTYPE, html, head, meta charset, viewport, dan penataan body.', '# Struktur Anatomi Dokumen HTML5 Standar

HTML5 adalah pondasi utama dalam pembangunan seluruh aplikasi web modern. Setiap dokumen HTML5 diawali dengan deklarasi DOCTYPE yang ringkas:

```html:index.html
<!DOCTYPE html>
<html lang=\"id\">
<head>
    <meta charset=\"UTF-8\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
    <title>Dokumentasi HTML5 | TalentGroup</title>
</head>
<body>
    <header>
        <h1>Selamat Datang di Portal Pengembang</h1>
    </header>
    <main>
        <p>Konten utama aplikasi dimuat di dalam tag main.</p>
    </main>
    <footer>
        <p>&copy; 2026 TalentGroup. Hak cipta dilindungi.</p>
    </footer>
</body>
</html>
```

> [!NOTE]
> Tag `<meta name=\"viewport\">` sangat penting agar tata letak halaman proporsional dan tidak mengecil saat diakses melalui ponsel pintar.', NULL, NULL, NULL, 1, 1, 1, NULL, 1, 1, 1, 0, '2026-10-25 02:37:17', '2026-10-25 02:37:17');
INSERT INTO `modules` (`id`, `category_id`, `section`, `title`, `slug`, `content_type`, `excerpt`, `content`, `file_path`, `file_name`, `file_size`, `order`, `is_published`, `is_public`, `referral_code`, `enable_protection`, `enable_anti_screenshot`, `enable_anti_copy`, `views_count`, `created_at`, `updated_at`) VALUES (2, 1, 'FORM & VALIDASI', 'Formulir Interaktif & Kontrol Validasi', 'formulir-interaktif-dan-validasi', 'document', 'Panduan lengkap pembuatan form login, registrasi, input email, password, file upload, dan validasi pattern.', '# Formulir Interaktif & Kontrol Validasi HTML5

Formulir digunakan untuk mengumpulkan informasi dari pengguna. HTML5 menyediakan kontrol validasi otomatis di sisi browser tanpa perlu JavaScript.

```html:form-login.html
<form action=\"/api/login\" method=\"POST\">
    <div class=\"input-group\">
        <label for=\"email\">Email Perusahaan:</label>
        <input type=\"email\" id=\"email\" name=\"email\" required placeholder=\"nama@kantor.com\">
    </div>
    <div class=\"input-group\">
        <label for=\"password\">Kata Sandi:</label>
        <input type=\"password\" id=\"password\" name=\"password\" required minlength=\"8\">
    </div>
    <button type=\"submit\">Masuk ke Akun</button>
</form>
```

> [!TIP]
> Gunakan atribut `minlength` dan `required` untuk mencegah form dikirim dalam keadaan kosong.', NULL, NULL, NULL, 2, 1, 1, NULL, 1, 1, 1, 0, '2026-10-25 02:37:17', '2026-10-25 02:37:17');
INSERT INTO `modules` (`id`, `category_id`, `section`, `title`, `slug`, `content_type`, `excerpt`, `content`, `file_path`, `file_name`, `file_size`, `order`, `is_published`, `is_public`, `referral_code`, `enable_protection`, `enable_anti_screenshot`, `enable_anti_copy`, `views_count`, `created_at`, `updated_at`) VALUES (3, 2, 'BOX MODEL & RESET', 'Universal Box-Sizing & Reset CSS', 'universal-box-sizing-dan-reset-css', 'document', 'Menghindari inkonsistensi kalkulasi padding dan border dengan reset border-box standar.', '# Universal Box-Sizing & Reset CSS

Sebelum mulai menata halaman, deklarasikan reset box-sizing untuk seluruh elemen:

```css:global.css
*, *::before, *::after {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}
```

### Perbedaan Model:
- **content-box**: Ukuran `width` hanya mencakup isi konten. Padding dan border menambah lebar total.
- **border-box**: Ukuran `width` sudah mencakup konten, padding, dan border secara terpadu.', NULL, NULL, NULL, 1, 1, 1, NULL, 1, 1, 1, 0, '2026-10-25 02:37:17', '2026-10-25 02:37:17');
INSERT INTO `modules` (`id`, `category_id`, `section`, `title`, `slug`, `content_type`, `excerpt`, `content`, `file_path`, `file_name`, `file_size`, `order`, `is_published`, `is_public`, `referral_code`, `enable_protection`, `enable_anti_screenshot`, `enable_anti_copy`, `views_count`, `created_at`, `updated_at`) VALUES (4, 2, 'FLEXBOX & GRID', 'Panduan Praktis Flexbox & CSS Grid', 'panduan-praktis-flexbox-dan-css-grid', 'document', 'Kombinasi Flexbox satu dimensi untuk komponen navigasi dan Grid dua dimensi untuk kartu galeri responsif.', '# Panduan Praktis Flexbox & CSS Grid

### Kapan Menggunakan Flexbox vs CSS Grid?
1. **Flexbox (1 Dimensi)**: Ideal untuk baris navigasi, tombol sejajar, atau pembagian item berurutan.
2. **CSS Grid (2 Dimensi)**: Ideal untuk susunan kartu galeri, dashboard admin, atau halaman majalah berita.

```css:layout.css
/* Navigasi Flexbox */
.nav-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 16px;
}

/* Galeri Kartu Grid */
.cards-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 24px;
}
```', NULL, NULL, NULL, 2, 1, 1, NULL, 1, 1, 1, 0, '2026-10-25 02:37:17', '2026-10-25 02:37:17');
INSERT INTO `modules` (`id`, `category_id`, `section`, `title`, `slug`, `content_type`, `excerpt`, `content`, `file_path`, `file_name`, `file_size`, `order`, `is_published`, `is_public`, `referral_code`, `enable_protection`, `enable_anti_screenshot`, `enable_anti_copy`, `views_count`, `created_at`, `updated_at`) VALUES (5, 3, 'SINTAKS ES6+', 'Variabel, Arrow Function & Destructuring', 'variabel-arrow-function-dan-destructuring', 'document', 'Menulis kode JavaScript yang bersih, modern, dan mudah dipelihara menggunakan standar ES6+.', '# Variabel, Arrow Function & Destructuring ES6+

### Destructuring Array & Objek:
```javascript:app.js
const user = {
    nama: \'Budi Santoso\',
    peran: \'Frontend Engineer\',
    kota: \'Jakarta\'
};

// Ekstraksi langsung variabel properti
const { nama, peran } = user;
console.log(`Halo ${nama}, peran Anda adalah ${peran}.`);
```

### Arrow Functions dengan Nilai Kembalian Implisit:
```javascript
const kuadrat = x => x * x;
console.log(kuadrat(5)); // 25
```', NULL, NULL, NULL, 1, 1, 1, NULL, 1, 1, 1, 0, '2026-10-25 02:37:17', '2026-10-25 02:37:17');
INSERT INTO `modules` (`id`, `category_id`, `section`, `title`, `slug`, `content_type`, `excerpt`, `content`, `file_path`, `file_name`, `file_size`, `order`, `is_published`, `is_public`, `referral_code`, `enable_protection`, `enable_anti_screenshot`, `enable_anti_copy`, `views_count`, `created_at`, `updated_at`) VALUES (6, 3, 'MANIPULASI DOM', 'Event Listener & Manipulasi DOM Real-Time', 'event-listener-dan-manipulasi-dom', 'document', 'Menghubungkan interaksi tombol pengguna untuk menambah, mengubah, atau menghapus elemen dokumen.', '# Event Listener & Manipulasi DOM Real-Time

```javascript:dom.js
const btnSubmit = document.querySelector(\'#btn-kirim\');
const statusBox = document.querySelector(\'.status-box\');

btnSubmit.addEventListener(\'click\', (event) => {
    event.preventDefault();
    statusBox.classList.add(\'aktif\');
    statusBox.textContent = \'Memproses data transaksi...\';
});
```

> [!IMPORTANT]
> Selalu gunakan `event.preventDefault()` pada formulir untuk mencegah peramban me-refresh halaman secara otomatis.', NULL, NULL, NULL, 2, 1, 1, NULL, 1, 1, 1, 0, '2026-10-25 02:37:17', '2026-10-25 02:37:17');

SET FOREIGN_KEY_CHECKS=1;
-- ===================================================================
-- Selesai. Seluruh data berhasil di-generate.
-- ===================================================================
