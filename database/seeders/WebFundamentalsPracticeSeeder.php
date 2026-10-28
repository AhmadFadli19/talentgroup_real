<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\CourseQuestion;
use App\Models\User;
use Illuminate\Database\Seeder;
use RuntimeException;

class WebFundamentalsPracticeSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('role_id', 1)->orderBy('id')->first();

        if (!$admin) {
            throw new RuntimeException('WebFundamentalsPracticeSeeder membutuhkan minimal satu akun admin.');
        }

        $course = Course::updateOrCreate(
            ['title' => 'Latihan HTML, CSS & JavaScript'],
            [
                'description' => 'Tiga puluh soal bertingkat untuk menguji HTML semantik, aksesibilitas, CSS responsif, DOM, asynchronous JavaScript, keamanan, dan performa web.',
                'price' => 0,
                'image' => 'tg/assets/quiz-web-fundamentals.png',
                'is_active' => true,
                'quiz_answer_visibility' => 'end',
                'quiz_navigation_mode' => 'free',
                'shuffle_questions' => false,
                'shuffle_options' => true,
                'created_by' => $admin->id,
            ]
        );

        $questions = $this->questions();
        $titles = [];

        foreach ($questions as $question) {
            $titles[] = $question['title'];

            CourseQuestion::updateOrCreate(
                [
                    'course_id' => $course->id,
                    'title' => $question['title'],
                ],
                [
                    'question_type' => 'multiple_choice',
                    'difficulty' => $question['difficulty'],
                    'content' => $question['content'],
                    'options' => $question['options'],
                    'correct_answer' => $question['options'][$question['correct_index']],
                    'hint' => $question['hint'],
                    'order' => $question['order'],
                ]
            );
        }

        $course->questions()->whereNotIn('title', $titles)->delete();
    }

    private function questions(): array
    {
        return [
            $this->question('Landmark Konten Utama', 'beginner', 1,
                'Elemen HTML semantik mana yang membungkus konten utama yang unik pada halaman?',
                ['Elemen `<aside>`', 'Elemen `<main>`', 'Elemen `<footer>`', 'Elemen `<nav>`'],
                1, 'Satu halaman umumnya memiliki satu landmark konten utama.'),

            $this->question('Teks Alternatif Gambar', 'beginner', 2,
                'Apa fungsi utama atribut `alt` pada elemen `<img>`?',
                [
                    'Mengatur ukuran gambar saat koneksi pengguna sedang melambat',
                    'Menentukan alamat tujuan ketika gambar sedang diklik',
                    'Memberi deskripsi teks untuk aksesibilitas dan fallback',
                    'Memaksa browser mengunduh gambar dalam format tertentu',
                ], 2, 'Alt menjelaskan makna gambar ketika visual tidak tersedia.'),

            $this->question('Label pada Form', 'beginner', 3,
                'Bagaimana `<label>` dihubungkan dengan input agar nama bidang mudah dikenali?',
                [
                    'Nilai `for` label sama dengan nilai `id` pada input',
                    'Nilai `name` label sama dengan nilai `class` pada input',
                    'Nilai `href` label sama dengan nilai `src` pada input',
                    'Nilai `role` label sama dengan nilai `type` pada input',
                ], 0, 'Atribut for menunjuk id kontrol formulir.'),

            $this->question('CSS Box Model', 'beginner', 4,
                'Urutan lapisan box model dari bagian terdalam ke bagian terluar adalah?',
                [
                    'Margin, border, padding, lalu content',
                    'Border, content, margin, lalu padding',
                    'Padding, margin, content, lalu border',
                    'Content, padding, border, lalu margin',
                ], 3, 'Mulailah dari isi elemen lalu bergerak keluar.'),

            $this->question('Arah Flexbox', 'beginner', 5,
                'Deklarasi mana yang menyusun item Flexbox secara vertikal dari atas ke bawah?',
                [
                    '`align-items: vertical-flow`',
                    '`flex-direction: column`',
                    '`justify-content: down`',
                    '`display: block-column`',
                ], 1, 'Flex direction mengatur arah main axis.'),

            $this->question('Deklarasi let', 'beginner', 6,
                'Pernyataan mana yang tepat tentang variabel JavaScript yang dibuat dengan `let`?',
                [
                    'Nilainya tidak pernah boleh diubah setelah deklarasi',
                    'Variabel selalu menjadi properti global pada window',
                    'Variabel memiliki block scope dan nilainya dapat diubah',
                    'Deklarasi hanya boleh digunakan di dalam fungsi async tertentu',
                ], 2, 'Let menggunakan block scope dan mendukung assignment ulang.'),

            $this->question('Strict Equality', 'beginner', 7,
                'Ekspresi JavaScript mana yang menghasilkan nilai `true`?',
                ['`5 === "5"`', '`0 === false`', '`null === undefined`', '`5 !== "5"`'],
                3, 'Operator strict membandingkan tipe sekaligus nilai.'),

            $this->question('Memilih Elemen DOM', 'beginner', 8,
                'Kode mana yang mengambil elemen pertama dengan class `card`?',
                [
                    '`document.querySelector(".card")`',
                    '`document.querySelectorAll("card")[1]`',
                    '`document.getElementById(".card")`',
                    '`window.findElement("class=card")`',
                ], 0, 'Selector class CSS diawali tanda titik.'),

            $this->question('Mencegah Submit Bawaan', 'beginner', 9,
                'Metode event apa yang mencegah form melakukan submit bawaan browser?',
                ['`event.stopImmediateNow()`', '`event.cancelBubble()`', '`event.preventDefault()`', '`event.removeDefault()`'],
                2, 'Metode ini membatalkan aksi default dari event.'),

            $this->question('Script dengan Defer', 'beginner', 10,
                'Apa efek atribut `defer` pada script eksternal di bagian `<head>`?',
                [
                    'Script berjalan sebelum browser mulai membaca markup HTML',
                    'Script diunduh paralel lalu berjalan setelah HTML selesai diparse',
                    'Script hanya berjalan setelah pengguna melakukan klik pertama kali',
                    'Script otomatis dipindahkan menjadi worker pada thread lain',
                ], 1, 'Defer tidak menghambat parsing HTML dan menunggu parsing selesai.'),

            $this->question('Grid Responsif minmax', 'intermediate', 11,
                'Apa hasil pola `repeat(auto-fit, minmax(240px, 1fr))` pada CSS Grid?',
                [
                    'Kolom responsif terbentuk dengan lebar minimum 240 piksel',
                    'Semua kolom terkunci pada ukuran tepat 240 piksel selamanya',
                    'Grid selalu menghasilkan satu kolom pada seluruh ukuran layar',
                    'Item yang melebihi 240 piksel otomatis disembunyikan browser',
                ], 0, 'Minmax memberi batas minimum dan ruang fleksibel.'),

            $this->question('Specificity Selector', 'intermediate', 12,
                'Tanpa `!important`, selector mana yang memiliki specificity paling tinggi?',
                ['Selector elemen `button`', 'Selector class `.button`', 'Selector atribut `[type]`', 'Selector ID `#button`'],
                3, 'ID memiliki bobot lebih tinggi daripada class dan elemen.'),

            $this->question('Custom Property CSS', 'intermediate', 13,
                'Bagaimana memakai nilai custom property bernama `--brand-color`?',
                ['`color: get(--brand-color)`', '`color: var(--brand-color)`', '`color: $brand-color`', '`color: @brand-color`'],
                1, 'Custom property dibaca melalui fungsi var.'),

            $this->question('Event Delegation', 'intermediate', 14,
                'Mengapa event delegation berguna pada daftar item yang dapat bertambah dinamis?',
                [
                    'Listener parent menangani event child melalui proses bubbling',
                    'Setiap child mendapat listener baru dari browser secara otomatis',
                    'Event pada child tidak pernah bergerak menuju elemen parent',
                    'Semua item diubah menjadi elemen statis sebelum event berjalan',
                ], 0, 'Delegation mengandalkan event yang merambat ke ancestor.'),

            $this->question('Penyimpanan localStorage', 'intermediate', 15,
                'Apa yang perlu dilakukan sebelum menyimpan object biasa ke `localStorage`?',
                [
                    'Mengubah object menjadi string memakai `JSON.stringify`',
                    'Mengubah object menjadi node memakai `document.createElement`',
                    'Mengirim object ke server menggunakan `window.postMessage`',
                    'Membekukan object menggunakan fungsi `Object.freeze`',
                ], 0, 'Web Storage menyimpan pasangan nilai berbentuk string.'),

            $this->question('Pemeriksaan Fetch', 'intermediate', 16,
                'Mengapa kode `fetch()` biasanya memeriksa `response.ok` sebelum membaca JSON?',
                [
                    'Karena fetch menolak Promise pada semua status HTTP 4xx dan 5xx',
                    'Karena response perlu diubah menjadi request sebelum diproses',
                    'Karena status HTTP gagal tidak selalu membuat Promise ditolak',
                    'Karena JSON hanya tersedia untuk response berstatus tepat 200',
                ], 2, 'Fetch dapat resolve walau server memberi status error HTTP.'),

            $this->question('Penanganan Async Await', 'intermediate', 17,
                'Konstruksi apa yang lazim dipakai untuk menangani kegagalan pada `await`?',
                ['Blok `if...else` biasa', 'Blok `try...catch`', 'Loop `for...of`', 'Switch `pending...done`'],
                1, 'Error Promise dari await dapat ditangkap dengan catch.'),

            $this->question('Validasi Form Browser', 'intermediate', 18,
                'Metode mana yang mengecek validitas seluruh kontrol form tanpa langsung mengirimnya?',
                ['`form.submitNow()`', '`form.validateAllInputs()`', '`form.checkValidity()`', '`form.testInputs()`'],
                2, 'Constraint Validation API menyediakan checkValidity.'),

            $this->question('Article dan Section', 'intermediate', 19,
                'Kapan elemen `<article>` lebih tepat daripada `<section>`?',
                [
                    'Ketika konten dapat berdiri sendiri dan didistribusikan ulang',
                    'Ketika container hanya dibutuhkan untuk menerapkan warna latar',
                    'Ketika elemen selalu ditempatkan pada bagian paling atas halaman',
                    'Ketika susunan harus memakai display grid pada semua perangkat',
                ], 0, 'Article mewakili unit konten mandiri.'),

            $this->question('Gambar Responsif Picture', 'intermediate', 20,
                'Apa manfaat elemen `<picture>` dibanding hanya satu `<img>` biasa?',
                [
                    'Memberi beberapa source berdasarkan media atau format gambar',
                    'Menambahkan caption otomatis dari nama file pada server',
                    'Mencegah gambar dimuat pada semua koneksi jaringan pengguna aktif',
                    'Mengubah gambar menjadi canvas yang selalu dapat diedit',
                ], 0, 'Picture mendukung art direction dan pilihan format.'),

            $this->question('Cascade Layers', 'advanced', 21,
                'Apa manfaat utama `@layer` dalam arsitektur CSS yang besar?',
                [
                    'Menentukan urutan prioritas kelompok style secara eksplisit',
                    'Mengubah setiap selector menjadi inline style pada elemen',
                    'Menjalankan proses kompresi CSS langsung dari browser pengguna',
                    'Membuat semua rule mempunyai specificity yang sama persis',
                ], 0, 'Cascade layer mengatur prioritas antar kelompok rule.'),

            $this->question('Stacking Context', 'advanced', 22,
                'Mengapa `z-index: 9999` kadang tetap berada di bawah elemen lain?',
                [
                    'Nilai z-index hanya berfungsi pada elemen dengan warna solid',
                    'Elemen berada dalam stacking context parent yang lebih rendah',
                    'Browser membatasi seluruh nilai z-index maksimum sampai 1000',
                    'Z-index hanya dibandingkan berdasarkan urutan alfabet selector',
                ], 1, 'Z-index dibandingkan di dalam konteks tumpuk masing-masing.'),

            $this->question('Mencegah Layout Thrashing', 'advanced', 23,
                'Strategi mana yang membantu mengurangi layout thrashing saat memanipulasi DOM?',
                [
                    'Selang-seling membaca layout dan menulis style di setiap loop',
                    'Membaca ukuran berulang setelah tiap perubahan class element',
                    'Kelompokkan pembacaan layout lalu kelompokkan perubahan DOM',
                    'Gunakan setInterval nol untuk seluruh perubahan visual halaman',
                ], 2, 'Pisahkan fase read dan write agar reflow tidak berulang.'),

            $this->question('Mencegah XSS pada Teks', 'advanced', 24,
                'Jika data pengguna harus ditampilkan sebagai teks biasa, pilihan DOM mana yang lebih aman?',
                ['Tetapkan melalui `outerHTML`', 'Tetapkan melalui `insertAdjacentHTML`', 'Tetapkan melalui `innerHTML`', 'Tetapkan melalui `textContent`'],
                3, 'TextContent tidak menafsirkan input sebagai markup HTML.'),

            $this->question('Urutan Microtask', 'advanced', 25,
                'Mana yang biasanya dijalankan lebih dahulu setelah call stack JavaScript kosong?',
                ['Callback `setTimeout(..., 0)`', 'Callback `requestIdleCallback`', 'Handler `.then()` Promise', 'Event klik pengguna berikutnya'],
                2, 'Microtask Promise diproses sebelum task timer berikutnya.'),

            $this->question('Membatalkan Fetch', 'advanced', 26,
                'API mana yang digunakan untuk membatalkan request `fetch` yang tidak lagi diperlukan?',
                ['`AbortController` dan signal', '`CancelPromise` dan token', '`Request.stopNow()` dan reason', '`Fetch.terminate()` dan id'],
                0, 'Fetch menerima AbortSignal dari controller.'),

            $this->question('Ruang Lingkup ES Module', 'advanced', 27,
                'Pernyataan mana yang benar tentang variabel top-level pada ES module?',
                [
                    'Variabel selalu menjadi properti langsung pada object window',
                    'Variabel memiliki module scope dan tidak otomatis menjadi global',
                    'Variabel dapat dipakai file lain tanpa export atau import',
                    'Variabel hanya tersedia jika seluruh script memakai atribut async',
                ], 1, 'Setiap module memiliki ruang lingkupnya sendiri.'),

            $this->question('Manajemen Fokus Modal', 'advanced', 28,
                'Apa praktik aksesibilitas penting saat modal dibuka dan kemudian ditutup?',
                [
                    'Pindahkan fokus ke modal lalu kembalikan ke pemicu saat ditutup',
                    'Hapus fokus keyboard sampai pengguna memuat ulang halaman',
                    'Pindahkan fokus ke address bar setiap modal selesai digunakan penuh',
                    'Nonaktifkan tombol Escape agar modal tidak pernah tertutup',
                ], 0, 'Fokus harus masuk ke dialog dan kembali secara terprediksi.'),

            $this->question('Content Security Policy', 'advanced', 29,
                'Apa tujuan utama Content Security Policy pada aplikasi web?',
                [
                    'Mengatur sumber konten yang diizinkan untuk membantu menekan XSS',
                    'Mengompresi HTML dan CSS sebelum dikirim melalui jaringan publik',
                    'Menyimpan seluruh password pengguna di dalam browser secara lokal',
                    'Menggantikan validasi input dan encoding output pada aplikasi',
                ], 0, 'CSP membatasi sumber resource, tetapi bukan pengganti sanitasi.'),

            $this->question('Optimasi Rendering Gambar', 'advanced', 30,
                'Atribut apa yang membantu menunda pemuatan gambar di luar viewport awal?',
                ['`decoding="sync"`', '`fetchpriority="high"`', '`loading="lazy"`', '`rendering="defer"`'],
                2, 'Lazy loading menunda resource yang belum terlihat.'),
        ];
    }

    private function question(
        string $title,
        string $difficulty,
        int $order,
        string $content,
        array $options,
        int $correctIndex,
        string $hint
    ): array {
        return [
            'title' => $title,
            'difficulty' => $difficulty,
            'order' => $order,
            'content' => $content,
            'options' => $options,
            'correct_index' => $correctIndex,
            'hint' => $hint,
        ];
    }
}
