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
                'description' => 'Latihan pilihan ganda bertahap untuk menguji pemahaman frame, Auto Layout, components, variants, prototyping, variables, dan Dev Mode di Figma.',
                'price' => 0,
                'is_active' => true,
                'quiz_answer_visibility' => 'end',
                'quiz_navigation_mode' => 'free',
                'shuffle_questions' => false,
                'shuffle_options' => true,
                'created_by' => $admin->id,
            ]
        );

        foreach ($this->questions() as $question) {
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
                    'correct_answer' => $question['correct_answer'],
                    'hint' => $question['hint'],
                    'order' => $question['order'],
                ]
            );
        }
    }

    /**
     * Materi mengacu pada dokumentasi resmi Figma tentang frames, constraints,
     * Auto Layout, components, variants, prototypes, variables, dan Dev Mode.
     */
    private function questions(): array
    {
        return [
            [
                'title' => 'Fungsi Frame dalam Desain',
                'difficulty' => 'beginner',
                'order' => 1,
                'content' => 'Apa fungsi utama **Frame** ketika menyusun layar aplikasi di Figma?',
                'options' => [
                    'Menjadi wadah layer yang dapat memiliki ukuran, layout, constraints, dan properti desain sendiri',
                    'Mengubah semua layer menjadi gambar raster secara permanen',
                    'Menghapus hubungan antar-layer supaya file lebih ringan',
                    'Menjalankan kode aplikasi langsung dari canvas',
                ],
                'correct_answer' => 'Menjadi wadah layer yang dapat memiliki ukuran, layout, constraints, dan properti desain sendiri',
                'hint' => 'Bayangkan Frame sebagai layar atau container yang menampung elemen desain.',
            ],
            [
                'title' => 'Tujuan Membuat Component',
                'difficulty' => 'beginner',
                'order' => 2,
                'content' => 'Mengapa tombol yang dipakai berulang sebaiknya dibuat menjadi **Component**?',
                'options' => [
                    'Agar elemen dapat digunakan kembali dan perubahan dari main component bisa diterapkan secara konsisten',
                    'Agar tombol tidak dapat diedit lagi oleh siapa pun',
                    'Agar semua tombol otomatis berubah menjadi prototype',
                    'Agar tombol selalu diekspor sebagai video',
                ],
                'correct_answer' => 'Agar elemen dapat digunakan kembali dan perubahan dari main component bisa diterapkan secara konsisten',
                'hint' => 'Component membantu konsistensi elemen berulang dalam sebuah sistem desain.',
            ],
            [
                'title' => 'Mengenal Instance',
                'difficulty' => 'beginner',
                'order' => 3,
                'content' => 'Apa yang dimaksud dengan **Instance** di Figma?',
                'options' => [
                    'Salinan terhubung dari main component yang tetap dapat memiliki override tertentu',
                    'File cadangan yang dibuat otomatis setiap satu jam',
                    'Layer biasa yang tidak memiliki hubungan dengan component',
                    'Halaman khusus untuk menyimpan komentar',
                ],
                'correct_answer' => 'Salinan terhubung dari main component yang tetap dapat memiliki override tertentu',
                'hint' => 'Instance berasal dari main component dan mewarisi pembaruan yang relevan.',
            ],
            [
                'title' => 'Peran Constraints',
                'difficulty' => 'beginner',
                'order' => 4,
                'content' => 'Apa kegunaan **Constraints** pada layer yang berada di dalam Frame?',
                'options' => [
                    'Menentukan bagaimana posisi dan ukuran layer merespons perubahan ukuran parent',
                    'Mengatur siapa yang boleh membuka file Figma',
                    'Mengunci warna agar tidak bisa digunakan ulang',
                    'Mengubah layer menjadi component set',
                ],
                'correct_answer' => 'Menentukan bagaimana posisi dan ukuran layer merespons perubahan ukuran parent',
                'hint' => 'Constraints berkaitan dengan perilaku layer saat ukuran frame induk berubah.',
            ],
            [
                'title' => 'Trigger Prototype Dasar',
                'difficulty' => 'beginner',
                'order' => 5,
                'content' => 'Dalam prototype tombol, trigger mana yang digunakan untuk menjalankan aksi ketika pengguna menekan tombol?',
                'options' => [
                    'On click atau On tap',
                    'While loading only',
                    'After export',
                    'Before component',
                ],
                'correct_answer' => 'On click atau On tap',
                'hint' => 'Trigger menentukan kejadian pengguna yang memulai sebuah interaction.',
            ],
            [
                'title' => 'Manfaat Auto Layout',
                'difficulty' => 'intermediate',
                'order' => 6,
                'content' => 'Apa manfaat utama **Auto Layout** pada card atau tombol?',
                'options' => [
                    'Mengatur susunan, spacing, padding, dan perubahan ukuran berdasarkan isi secara otomatis',
                    'Mengonversi desain menjadi database',
                    'Menghapus seluruh whitespace dari canvas',
                    'Membuat semua layer menjadi fixed position',
                ],
                'correct_answer' => 'Mengatur susunan, spacing, padding, dan perubahan ukuran berdasarkan isi secara otomatis',
                'hint' => 'Auto Layout membantu container beradaptasi ketika isi bertambah, berkurang, atau berubah ukuran.',
            ],
            [
                'title' => 'Hug Contents',
                'difficulty' => 'intermediate',
                'order' => 7,
                'content' => 'Apa yang terjadi ketika ukuran sebuah container Auto Layout diatur ke **Hug contents**?',
                'options' => [
                    'Ukuran container mengikuti ukuran konten dan padding di dalamnya',
                    'Container selalu memenuhi seluruh ukuran layar',
                    'Semua child layer diubah menjadi posisi absolut',
                    'Container tidak dapat menerima konten baru',
                ],
                'correct_answer' => 'Ukuran container mengikuti ukuran konten dan padding di dalamnya',
                'hint' => 'Hug berarti container memeluk isi di dalamnya.',
            ],
            [
                'title' => 'Fill Container',
                'difficulty' => 'intermediate',
                'order' => 8,
                'content' => 'Kapan pengaturan **Fill container** tepat digunakan pada child di dalam Auto Layout?',
                'options' => [
                    'Ketika child perlu memakai ruang tersedia pada sumbu yang diizinkan parent',
                    'Ketika child harus selalu berukuran nol piksel',
                    'Ketika child harus dilepas dari Auto Layout',
                    'Ketika layer akan diekspor menjadi PDF',
                ],
                'correct_answer' => 'Ketika child perlu memakai ruang tersedia pada sumbu yang diizinkan parent',
                'hint' => 'Fill membuat layer mengisi ruang yang tersedia di container induknya.',
            ],
            [
                'title' => 'Penggunaan Variants',
                'difficulty' => 'intermediate',
                'order' => 9,
                'content' => 'Apa penggunaan **Variants** yang paling tepat dalam sebuah component set?',
                'options' => [
                    'Mengelompokkan kondisi terkait seperti size, state, atau style dari satu keluarga component',
                    'Menyimpan riwayat versi file secara manual',
                    'Mengubah component menjadi file video',
                    'Menghubungkan desain langsung ke database produksi',
                ],
                'correct_answer' => 'Mengelompokkan kondisi terkait seperti size, state, atau style dari satu keluarga component',
                'hint' => 'Contohnya button dengan state default, hover, pressed, dan disabled.',
            ],
            [
                'title' => 'Overlay untuk Modal',
                'difficulty' => 'intermediate',
                'order' => 10,
                'content' => 'Untuk menampilkan modal di atas layar yang sedang aktif tanpa berpindah penuh ke layar lain, action prototype apa yang paling sesuai?',
                'options' => [
                    'Open overlay',
                    'Swap library',
                    'Flatten selection',
                    'Outline stroke',
                ],
                'correct_answer' => 'Open overlay',
                'hint' => 'Overlay menempatkan frame lain di atas frame aktif, cocok untuk modal dan popover.',
            ],
            [
                'title' => 'Variables dan Modes',
                'difficulty' => 'advanced',
                'order' => 11,
                'content' => 'Bagaimana **Variables** dan **Modes** dapat membantu membuat tema terang dan gelap?',
                'options' => [
                    'Satu variable collection dapat menyimpan nilai berbeda untuk mode Light dan Dark lalu diterapkan pada properti desain',
                    'Setiap tema wajib disimpan dalam file Figma yang benar-benar terpisah',
                    'Mode hanya dapat digunakan untuk mengganti nama layer',
                    'Variables hanya dapat menyimpan file gambar',
                ],
                'correct_answer' => 'Satu variable collection dapat menyimpan nilai berbeda untuk mode Light dan Dark lalu diterapkan pada properti desain',
                'hint' => 'Modes memungkinkan satu token mempunyai nilai sesuai konteks atau tema.',
            ],
            [
                'title' => 'Interactive Components',
                'difficulty' => 'advanced',
                'order' => 12,
                'content' => 'Bagaimana cara umum membuat tombol berubah dari state Default ke Pressed langsung di dalam component set?',
                'options' => [
                    'Hubungkan variant dengan interaction dan action Change to menuju variant tujuan',
                    'Detach seluruh instance sebelum membuat prototype',
                    'Ekspor setiap state menjadi PNG lalu gabungkan',
                    'Ubah seluruh layer menjadi section',
                ],
                'correct_answer' => 'Hubungkan variant dengan interaction dan action Change to menuju variant tujuan',
                'hint' => 'Interactive components menghubungkan variant melalui prototype interaction.',
            ],
            [
                'title' => 'Tujuan Dev Mode',
                'difficulty' => 'advanced',
                'order' => 13,
                'content' => 'Apa tujuan utama **Dev Mode** dalam proses handoff desain ke developer?',
                'options' => [
                    'Membantu developer meninjau spesifikasi, aset, variables, dan code snippets yang relevan dari desain',
                    'Menggantikan server backend produksi',
                    'Menghapus kebutuhan pengujian aplikasi',
                    'Mengubah semua desain menjadi aplikasi final tanpa implementasi',
                ],
                'correct_answer' => 'Membantu developer meninjau spesifikasi, aset, variables, dan code snippets yang relevan dari desain',
                'hint' => 'Dev Mode berfokus pada inspeksi dan handoff implementasi.',
            ],
            [
                'title' => 'Variables sebagai Design Tokens',
                'difficulty' => 'advanced',
                'order' => 14,
                'content' => 'Mengapa penamaan variable semantik seperti `color/background/brand` lebih kuat daripada nama seperti `blue-500` untuk sistem desain multi-tema?',
                'options' => [
                    'Nama semantik menjelaskan fungsi token sehingga nilainya dapat berubah antar-mode tanpa mengubah maksud penggunaannya',
                    'Nama semantik otomatis mengompres semua gambar',
                    'Nama semantik membuat prototype tidak membutuhkan interaction',
                    'Nama semantik menghapus kebutuhan component',
                ],
                'correct_answer' => 'Nama semantik menjelaskan fungsi token sehingga nilainya dapat berubah antar-mode tanpa mengubah maksud penggunaannya',
                'hint' => 'Pisahkan tujuan penggunaan token dari nilai warna spesifiknya.',
            ],
            [
                'title' => 'Strategi Card Responsif',
                'difficulty' => 'advanced',
                'order' => 15,
                'content' => 'Strategi mana yang paling tepat untuk membuat card Figma tetap responsif ketika teks memanjang dan lebar parent berubah?',
                'options' => [
                    'Gunakan Auto Layout, atur perilaku Hug atau Fill secara tepat, lalu gunakan constraints pada layer yang memerlukannya',
                    'Posisikan semua elemen secara absolut dan kunci ukuran teks',
                    'Flatten seluruh card sebelum mengganti ukuran parent',
                    'Gunakan gambar screenshot untuk seluruh isi card',
                ],
                'correct_answer' => 'Gunakan Auto Layout, atur perilaku Hug atau Fill secara tepat, lalu gunakan constraints pada layer yang memerlukannya',
                'hint' => 'Responsivitas yang baik menggabungkan struktur layout, resizing, dan anchoring yang tepat.',
            ],
        ];
    }
}
