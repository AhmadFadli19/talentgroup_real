<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\CourseQuestion;
use App\Models\User;
use Illuminate\Database\Seeder;
use RuntimeException;

class FigmaPracticeSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('role_id', 1)->orderBy('id')->first();

        if (!$admin) {
            throw new RuntimeException('FigmaPracticeSeeder membutuhkan minimal satu akun admin.');
        }

        $course = Course::updateOrCreate(
            ['title' => 'Latihan Figma: Dasar hingga Lanjutan'],
            [
                'description' => 'Tiga puluh latihan pilihan ganda bertahap tentang frame, Auto Layout, components, variants, prototyping, variables, library, dan Dev Mode di Figma.',
                'price' => 0,
                'image' => 'tg/assets/quiz-figma.png',
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

    /**
     * Materi mengacu pada konsep inti Figma: frames, constraints, Auto Layout,
     * components, variants, prototypes, variables, libraries, dan Dev Mode.
     */
    private function questions(): array
    {
        return [
            $this->question('Fungsi Frame dalam Desain', 'beginner', 1,
                'Apa fungsi utama **Frame** saat menyusun layar aplikasi di Figma?',
                [
                    'Menjadi wadah layer dengan ukuran dan aturan layout sendiri',
                    'Mengubah semua layer menjadi gambar raster tanpa struktur utuh',
                    'Menyimpan riwayat komentar dari seluruh anggota tim desain',
                    'Menjalankan kode aplikasi langsung dari area canvas Figma',
                ], 0, 'Frame berperan seperti layar atau container.'),

            $this->question('Tujuan Membuat Component', 'beginner', 2,
                'Mengapa tombol yang dipakai berulang sebaiknya dijadikan **Component**?',
                [
                    'Agar elemen dapat dipakai ulang dan diperbarui secara konsisten',
                    'Agar tombol terkunci permanen dan tidak bisa diberi override',
                    'Agar seluruh tombol otomatis berubah menjadi alur prototype baru',
                    'Agar setiap tombol langsung diekspor sebagai video interaktif',
                ], 0, 'Component menjaga konsistensi elemen berulang.'),

            $this->question('Mengenal Instance', 'beginner', 3,
                'Apa yang dimaksud dengan **Instance** di Figma?',
                [
                    'Salinan terhubung dari component yang dapat menerima override',
                    'Cadangan file otomatis yang tersimpan setiap pergantian jam kerja',
                    'Layer lepas yang tidak mempunyai hubungan dengan component',
                    'Halaman khusus untuk mengarsipkan komentar dari reviewer',
                ], 0, 'Instance berasal dari main component.'),

            $this->question('Peran Constraints', 'beginner', 4,
                'Apa kegunaan **Constraints** pada layer di dalam sebuah Frame?',
                [
                    'Menentukan respons posisi layer saat ukuran parent berubah',
                    'Menentukan anggota tim yang diizinkan membuka file desain',
                    'Mengunci seluruh warna agar tidak digunakan pada halaman lain',
                    'Menggabungkan beberapa component menjadi satu library publik',
                ], 0, 'Constraints mengatur hubungan layer dengan parent.'),

            $this->question('Trigger Prototype Dasar', 'beginner', 5,
                'Trigger mana yang tepat untuk menjalankan aksi ketika pengguna menekan tombol pada prototype?',
                [
                    'On click atau On tap',
                    'After export atau On save',
                    'Before component atau On load',
                    'While editing atau After share',
                ], 0, 'Trigger mengikuti tindakan pengguna.'),

            $this->question('Fungsi Section', 'beginner', 6,
                'Kapan **Section** paling tepat digunakan di canvas Figma?',
                [
                    'Saat mengelompokkan frame berdasarkan alur atau bagian proyek',
                    'Saat membuat container responsif dengan padding otomatis',
                    'Saat mengubah layer menjadi aset yang siap diekspor ke PNG final',
                    'Saat menentukan nilai warna untuk beberapa mode tampilan',
                ], 0, 'Section membantu mengorganisasi area kerja.'),

            $this->question('Urutan Layer', 'beginner', 7,
                'Jika dua layer saling menumpuk, apa yang biasanya menentukan layer yang terlihat di depan?',
                [
                    'Posisinya yang lebih tinggi pada susunan panel Layers',
                    'Jumlah karakter yang terdapat pada nama layer tersebut',
                    'Warna fill yang mempunyai nilai kontras paling tinggi',
                    'Ukuran frame yang paling besar di seluruh halaman desain',
                ], 0, 'Urutan layer memengaruhi tumpukan visual.'),

            $this->question('Manfaat Text Style', 'beginner', 8,
                'Apa manfaat utama menggunakan **Text Style** untuk judul dan isi desain?',
                [
                    'Menjaga tipografi konsisten dan mudah diperbarui bersama',
                    'Membuat semua teks otomatis berubah menjadi gambar vektor',
                    'Mencegah teks menerima perubahan isi pada setiap instance',
                    'Menghubungkan setiap teks langsung ke database aplikasi',
                ], 0, 'Style menyatukan aturan tipografi yang berulang.'),

            $this->question('Starting Point Prototype', 'beginner', 9,
                'Apa fungsi **Flow starting point** dalam sebuah prototype?',
                [
                    'Menentukan frame awal ketika sebuah alur prototype dijalankan',
                    'Menentukan component terakhir yang boleh diedit oleh developer',
                    'Menentukan format file saat seluruh frame hendak diekspor',
                    'Menentukan pengguna yang menjadi pemilik utama sebuah file',
                ], 0, 'Setiap flow memerlukan titik awal.'),

            $this->question('Ekspor Aset', 'beginner', 10,
                'Apa langkah yang tepat ketika ikon perlu diserahkan sebagai aset PNG atau SVG?',
                [
                    'Tambahkan pengaturan Export pada layer lalu pilih formatnya',
                    'Ubah ikon menjadi komentar lalu bagikan tautan komentarnya saja',
                    'Masukkan ikon ke prototype lalu aktifkan pilihan Present',
                    'Pindahkan ikon ke Drafts lalu kunci seluruh properti layer',
                ], 0, 'Panel Export mengatur format dan skala keluaran.'),

            $this->question('Manfaat Auto Layout', 'intermediate', 11,
                'Apa manfaat utama **Auto Layout** pada card atau tombol?',
                [
                    'Mengatur arah, jarak, padding, dan ukuran mengikuti isi',
                    'Mengubah susunan desain menjadi tabel database otomatis',
                    'Menghapus semua ruang kosong yang terdapat pada canvas',
                    'Membuat setiap child selalu memakai posisi absolut tetap',
                ], 0, 'Auto Layout membuat container adaptif.'),

            $this->question('Perilaku Hug Contents', 'intermediate', 12,
                'Apa yang terjadi saat ukuran container Auto Layout diatur ke **Hug contents**?',
                [
                    'Ukuran container mengikuti konten beserta padding di dalamnya',
                    'Ukuran container selalu memenuhi seluruh lebar layar perangkat',
                    'Semua child otomatis keluar dari alur Auto Layout parent',
                    'Container dikunci agar tidak dapat menerima layer tambahan',
                ], 0, 'Hug membuat ukuran container memeluk isinya.'),

            $this->question('Penggunaan Fill Container', 'intermediate', 13,
                'Kapan **Fill container** tepat digunakan pada child dalam Auto Layout?',
                [
                    'Saat child perlu memakai ruang tersedia pada sumbu parent',
                    'Saat child harus mempertahankan ukuran nol pada semua sumbu',
                    'Saat child harus dilepas sepenuhnya dari susunan Auto Layout',
                    'Saat child hanya disiapkan untuk proses ekspor dokumen PDF',
                ], 0, 'Fill memakai ruang yang disediakan parent.'),

            $this->question('Penggunaan Variants', 'intermediate', 14,
                'Apa penggunaan **Variants** yang paling tepat dalam component set?',
                [
                    'Mengelompokkan state, ukuran, atau gaya dari satu component',
                    'Menyimpan seluruh riwayat versi file secara manual terpisah',
                    'Mengonversi setiap component menjadi format video bergerak',
                    'Menghubungkan component langsung ke database lingkungan produksi',
                ], 0, 'Variants mewakili kondisi dalam satu keluarga component.'),

            $this->question('Overlay untuk Modal', 'intermediate', 15,
                'Action prototype apa yang tepat untuk menampilkan modal di atas layar aktif?',
                [
                    'Open overlay',
                    'Swap library',
                    'Flatten selection',
                    'Outline stroke',
                ], 0, 'Modal tampil di atas frame saat ini.'),

            $this->question('Auto Layout Bersarang', 'intermediate', 16,
                'Mengapa card kompleks sering memakai beberapa Auto Layout yang saling bersarang?',
                [
                    'Agar tiap kelompok punya arah dan aturan jaraknya sendiri',
                    'Agar seluruh isi card berubah menjadi satu gambar tanpa layer',
                    'Agar setiap teks memakai ukuran tetap pada semua perangkat',
                    'Agar prototype dapat berjalan tanpa frame tujuan tambahan',
                ], 0, 'Setiap kelompok dapat memiliki susunan berbeda.'),

            $this->question('Absolute Position di Auto Layout', 'intermediate', 17,
                'Kapan **Absolute position** berguna untuk child di dalam Auto Layout?',
                [
                    'Saat badge perlu menumpuk tanpa memengaruhi alur sibling',
                    'Saat seluruh child harus membagi ruang parent secara merata',
                    'Saat teks harus membuat ukuran parent mengikuti panjang isi',
                    'Saat component perlu diterbitkan ke library milik organisasi',
                ], 0, 'Posisi absolut mengeluarkan child dari alur layout.'),

            $this->question('Component Properties', 'intermediate', 18,
                'Apa manfaat **Component properties** bagi pengguna sebuah instance?',
                [
                    'Menyediakan kontrol terarah untuk teks, boolean, atau instance',
                    'Membuat instance tidak lagi menerima perubahan component utama',
                    'Menghapus semua override setelah file desain dipublikasikan',
                    'Menyimpan data pengguna aplikasi pada component yang dipilih',
                ], 0, 'Properties mengekspos bagian yang memang boleh diubah.'),

            $this->question('Syarat Smart Animate', 'intermediate', 19,
                'Apa yang membantu **Smart Animate** mengenali layer yang sama di dua frame?',
                [
                    'Nama dan hierarki layer yang konsisten pada kedua frame',
                    'Warna background frame yang sama persis pada setiap layar',
                    'Jumlah komentar reviewer yang sama pada kedua halaman file',
                    'Ukuran canvas keseluruhan yang tidak pernah mengalami perubahan',
                ], 0, 'Smart Animate mencocokkan layer antarkeadaan.'),

            $this->question('Constraints dan Auto Layout', 'intermediate', 20,
                'Pernyataan mana yang paling tepat tentang Constraints dan Auto Layout?',
                [
                    'Keduanya dapat dipakai sesuai hubungan layer dan parent-nya',
                    'Constraints selalu menggantikan seluruh fungsi Auto Layout',
                    'Auto Layout hanya berguna untuk aset yang akan diekspor',
                    'Keduanya tidak boleh digunakan pada halaman desain yang sama',
                ], 0, 'Pilih alat berdasarkan struktur parent dan kebutuhan responsif.'),

            $this->question('Variables dan Modes', 'advanced', 21,
                'Bagaimana **Variables** dan **Modes** membantu membuat tema terang dan gelap?',
                [
                    'Satu collection menyimpan nilai berbeda untuk tiap mode tema',
                    'Setiap tema wajib berada dalam file Figma yang benar-benar terpisah',
                    'Mode hanya dapat dipakai untuk mengubah nama seluruh layer',
                    'Variables hanya dapat menampung gambar dan video hasil ekspor',
                ], 0, 'Satu token dapat memiliki nilai sesuai mode.'),

            $this->question('Interactive Components', 'advanced', 22,
                'Bagaimana membuat tombol berpindah dari state Default ke Pressed dalam component set?',
                [
                    'Hubungkan variant dengan interaction beraksi Change to',
                    'Detach semua instance lalu ekspor tiap state menjadi PNG',
                    'Ubah setiap variant menjadi section pada halaman terpisah',
                    'Gabungkan seluruh state memakai perintah Flatten selection',
                ], 0, 'Interactive component menghubungkan variant.'),

            $this->question('Tujuan Dev Mode', 'advanced', 23,
                'Apa tujuan utama **Dev Mode** dalam proses handoff desain?',
                [
                    'Meninjau spesifikasi, aset, variables, dan detail implementasi',
                    'Menggantikan layanan backend yang berjalan pada server produksi',
                    'Menghapus kebutuhan pengujian antarmuka pada perangkat nyata',
                    'Menyulap desain menjadi aplikasi final tanpa proses coding',
                ], 0, 'Dev Mode mendukung inspeksi dan handoff.'),

            $this->question('Variables sebagai Design Tokens', 'advanced', 24,
                'Mengapa nama semantik seperti `color/background/brand` baik untuk sistem multi-tema?',
                [
                    'Nama menjelaskan fungsi walau nilainya berubah antar-mode',
                    'Nama membuat semua gambar terkompresi saat file dipublikasikan',
                    'Nama menghilangkan kebutuhan interaction dalam setiap prototype',
                    'Nama otomatis mengganti seluruh component menjadi instance baru',
                ], 0, 'Nama token sebaiknya menjelaskan tujuan pemakaian.'),

            $this->question('Strategi Card Responsif', 'advanced', 25,
                'Strategi mana yang tepat agar card tetap responsif saat teks memanjang?',
                [
                    'Gunakan Auto Layout serta Hug dan Fill sesuai kebutuhan',
                    'Posisikan semua elemen absolut dan kunci seluruh ukuran teks',
                    'Flatten card sebelum mengubah ukuran frame induk desain',
                    'Gunakan satu screenshot untuk menggantikan seluruh isi card',
                ], 0, 'Responsivitas memerlukan struktur dan resizing yang tepat.'),

            $this->question('Alias pada Variable', 'advanced', 26,
                'Apa keuntungan membuat semantic variable sebagai alias dari primitive color variable?',
                [
                    'Peran token terpisah dari nilai dasar dan mudah diganti',
                    'Semua warna otomatis lolos setiap pemeriksaan aksesibilitas',
                    'Prototype langsung tersambung ke API tanpa konfigurasi lain',
                    'File desain tidak lagi membutuhkan component atau text style',
                ], 0, 'Alias memisahkan fungsi token dari nilai mentah.'),

            $this->question('Branch untuk Eksperimen', 'advanced', 27,
                'Apa alasan menggunakan branch ketika mengerjakan perubahan besar pada library?',
                [
                    'Menguji perubahan terpisah sebelum digabung ke file utama',
                    'Menghapus seluruh versi lama saat perubahan mulai dikerjakan',
                    'Membuat file tidak dapat dibuka oleh anggota tim lainnya',
                    'Mengubah semua instance menjadi layer biasa secara otomatis',
                ], 0, 'Branch memisahkan pekerjaan sampai siap ditinjau.'),

            $this->question('Pembaruan Library', 'advanced', 28,
                'Apa yang sebaiknya diperiksa sebelum menerima pembaruan component dari library?',
                [
                    'Dampak perubahan pada instance dan override yang sudah dipakai',
                    'Jumlah halaman kosong yang terdapat pada file library sumber',
                    'Warna avatar milik editor terakhir yang memublikasikan update baru',
                    'Ukuran seluruh komentar yang pernah ditulis oleh reviewer',
                ], 0, 'Update library dapat memengaruhi instance yang digunakan.'),

            $this->question('Prototype dengan Variable', 'advanced', 29,
                'Untuk apa variable dapat digunakan dalam prototype yang lebih kompleks?',
                [
                    'Menyimpan state sederhana yang memengaruhi alur interaction',
                    'Menjalankan query database produksi dari frame yang sedang aktif',
                    'Mengganti seluruh component menjadi gambar ketika Present dibuka',
                    'Merekam suara pengguna tanpa izin perangkat atau browser',
                ], 0, 'Variable prototype dapat menyimpan nilai keadaan.'),

            $this->question('Wrapping pada Auto Layout', 'advanced', 30,
                'Kapan opsi **Wrap** pada Auto Layout berguna?',
                [
                    'Saat item perlu pindah baris ketika ruang horizontal berkurang',
                    'Saat seluruh layer harus bertumpuk tepat pada satu koordinat tetap',
                    'Saat setiap child wajib keluar dari alur layout parent',
                    'Saat component akan diubah menjadi satu gambar raster tetap',
                ], 0, 'Wrap menyusun ulang item ketika ruang tidak cukup.'),
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
