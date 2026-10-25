# TalentGroup.id — HTML, CSS, dan JavaScript

Implementasi frontend dari file Figma TG. Dibuat dengan HTML, CSS biasa, dan JavaScript murni; tidak memerlukan React, Tailwind, npm, atau proses build.

## Cara membuka

1. Ekstrak seluruh isi ZIP.
2. Buka folder `tg-website`.
3. Klik dua kali `index.html` untuk membukanya di Chrome atau browser modern lainnya.

Semua gambar dan font sudah disimpan di folder `assets`, sehingga tampilan dapat digunakan tanpa koneksi internet. Jangan memindahkan `index.html` sendirian dari folder proyek.

Untuk mengedit, buka folder dengan VS Code. Kamu juga bisa menggunakan ekstensi Live Server, atau menjalankan `python3 -m http.server 8000` di folder ini dan membuka `http://localhost:8000`.

## Halaman

| Halaman | Alamat setelah index.html |
| --- | --- |
| Landing page lengkap | `#home` |
| Pengenalan platform | `#our-works` |
| Game edukasi | `#game-edu` |
| Katalog kursus | `#courses` |
| Keunggulan platform | `#about` |
| Kelas / modul | `#kelas` |
| Tanya jawab | `#pertanyaan` |
| Upload prototype | `#upload` |
| Contoh hasil review | `#review` |

Seluruh halaman menggunakan satu file HTML. JavaScript mengubah halaman sesuai alamat hash, sehingga tetap bekerja saat dibuka langsung tanpa server.

## Isi proyek

- `index.html`: struktur landing page dan halaman dashboard.
- `style.css`: warna, komponen, layout desktop, dan layout responsif.
- `script.js`: navigasi, dialog, filter, pertanyaan, voting, draf, serta validasi form.
- `art.css`: gaya untuk ilustrasi kode dan logo yang diterjemahkan dari struktur Figma.
- `motion.css`: keyframe animasi asli dari timeline Figma, termasuk pengaturan reduced motion.
- `fonts.css`: deklarasi font lokal Outfit, Inter, Fira Code, dan IBM Plex Mono.
- `assets/`: aset Figma dan file font lokal.

## Interaksi yang tersedia

- Navigasi landing page, menu HP, serta perpindahan halaman dashboard.
- Dialog detail kursus dan modul.
- Tantangan output teks sederhana pada bagian Game Edu; tidak menjalankan kode pengguna.
- Filter pertanyaan, tambah pertanyaan, dan voting.
- Pertanyaan dan voting disimpan secara lokal di browser.
- Pilih atau drag-and-drop file ZIP; validasi ekstensi dan batas ukuran 20 MB.
- Input repo GitHub, nama prototype, deskripsi, tech stack, dan subdomain.
- Simpan draf secara lokal, serta validasi sebelum membuka contoh hasil review.
- Salin alamat contoh prototype.

## Bagian yang perlu backend / konten tambahan

Ini adalah implementasi frontend. Tombol Masuk dan Daftar membuka ruang belajar demo tanpa autentikasi. Pertanyaan belum dikirim ke tutor; newsletter belum mengirim atau menyimpan langganan ke server. File ZIP tidak diunggah. Review AI, pembayaran, penerbitan sertifikat, dan hosting sungguhan belum terhubung. Skor 86 dan SmartKasir adalah data contoh yang ada pada desain, bukan hasil penilaian file pengguna.

Tautan video, slide, halaman informasi tambahan, dan URL media sosial tidak disertakan dalam desain yang dibaca. Tombol terkait menampilkan keterangan yang sesuai; hubungkan tujuan sebenarnya saat kontennya tersedia.

File Figma memiliki frame form upload yang berada terpisah dari frame dashboard upload. Implementasi ini menempatkan form tersebut ke area konten upload agar alurnya dapat dicoba. Penyesuaian layout HP menggunakan struktur responsif karena desain yang tersedia berukuran desktop.

## Validasi

Diperiksa di Chromium pada ukuran desktop 1440 × 1000 dan HP 390 × 844. Tidak ditemukan gambar hilang, error JavaScript, atau overflow horizontal. Filter pertanyaan, penambahan dan persistensi pertanyaan, voting, validasi sumber upload, draf, navigasi hasil review, tantangan teks, dan menu HP sudah diuji. Animasi mengikuti keyframe Figma; pengguna dengan preferensi reduced motion mendapatkan tampilan statis.

## Catatan aset

Gambar dan elemen vektor berasal dari desain Figma yang diberikan. Font diambil dari distribusi Google Fonts; informasi lisensi yang tertanam pada font disertakan di `assets/fonts/LICENSES.txt`. Hak penggunaan logo, gambar, dan konten desain mengikuti izin pemilik desain.
