# DESIGN.md — TalentGroup.id

Panduan visual untuk landing page, dashboard (user/admin/bank), dan dokumentasi modul. Semua halaman baru atau yang diedit harus mengikuti aturan di sini. Nilai diambil dari kode yang sudah ada: `resources/views/Home/index.blade.php` (landing), `resources/views/layouts/app.blade.php` (dashboard), dan `resources/views/modules/layout.blade.php` (dokumentasi modul).

## 1. Prinsip

- **Biru adalah identitas.** Biru navy untuk teks utama dan biru `#0047B3` untuk aksen. Oranye hanya untuk penekanan kecil (kata "Group" di logo, status, CTA sekunder).
- **Terang sebagai default, gelap sebagai pasangan.** Setiap warna punya versi terang dan gelap. Jangan membuat halaman yang hanya gelap.
- **Satu sumber warna.** Pakai token CSS (`var(--blue)`, `var(--ink)`, dst.), bukan hex langsung atau kelas Tailwind warna acak (`slate-800`, `cyan-500`).
- **Bersih dan kartu-based.** Konten ditaruh di kartu putih/surface dengan radius sedang dan bayangan lembut.

## 2. Warna

### Token inti (sumber: `layouts/app.blade.php`, `:root`)

| Token | Terang | Gelap | Kegunaan |
|---|---|---|---|
| `--bg` / `--canvas` | `#f8fafc` | `#070e1e` | Latar halaman |
| `--bg2` | `#ffffff` | `#0c1731` | Latar sekunder |
| `--surface` / `--panel` | `#ffffff` | `#0e1c3b` | Kartu, panel |
| `--text` | `#0f172a` | `#f8fafc` | Teks utama (dashboard) |
| `--ink` | `#0b2447` | `#ffffff` | Judul, teks tebal |
| `--body` | `#334155` | `#e2e8f0` | Paragraf |
| `--muted` | `#64748b` | `#94a3b8` | Teks sekunder, label |
| `--line` / `--border` | `#d5deee` | `#1d3768` | Garis, border |
| `--blue` | `#0047b3` | `#38bdf8` | Aksen utama, tautan, tombol |
| `--blue-dark` | `#00408c` | `#7dd3fc` | Hover aksen |
| `--blue-light` | `#e6f0ff` | `rgba(56,189,248,.15)` | Latar chip/badge biru |
| `--orange` | `#ea580c` | `#f97316` | Aksen hangat, CTA sekunder |
| `--yellow` | `#d97706` | `#f59e0b` | Peringatan ringan |
| `--green` | `#0f8a5f` | `#10b981` | Sukses |
| `--red` | `#ef4444` | `#f87171` | Error, hapus |

### Warna logo dan brand

- Wordmark **Talent** dan **.id**: `#0b2447` (terang) / `#f0f6ff` (gelap).
- **Group**: oranye `#f97316` (terang dan gelap, gelap pakai `#fb923c`).
- Latar lingkaran ikon: gradien biru navy dari `#2d35b0` sampai `#0a1838`.

### Aturan
- Tautan dan tombol utama: `--blue`.
- Judul di terang: `--ink`. Jangan pakai hitam murni (`#000`).
- Oranye hanya untuk satu elemen penekanan per layar.

## 3. Tipografi

- **Font utama:** `Plus Jakarta Sans`, fallback `Inter`, `system-ui`, `sans-serif`.
- **Font kode / mono:** `Fira Code`, fallback `monospace`. Dipakai untuk blok kode dan label teknis.
- **Outfit** hanya dipakai di judul hero landing (weight 800–900). Jangan dipakai di tempat lain.
- Bobot: 400 (body), 500–600 (label), 700 (sub-judul, tombol), 800 (judul kartu), 900 (hero).
- Skala yang dipakai: hero 40–56px, judul seksi 28–36px, judul kartu 18–20px, body 15–16px, label/eyebrow 11–12px uppercase dengan letter-spacing lebar.
- Wordmark navbar: 20px, weight 800, `letter-spacing: -0.4px`.

## 4. Bentuk, spasi, bayangan

- **Radius:** 6px (chip kecil), 10px (input, tombol kecil), 12–14px (kartu kecil), 18px (kartu besar, modal), 9999px (pill, badge, tombol pill).
- **Bayangan kartu terang:** `0 4px 16px rgba(11,36,71,0.05)`.
- **Bayangan kartu gelap:** `0 8px 30px rgba(0,15,45,0.55)`.
- **Bayangan tombol:** `0 4px 10px rgba(0,71,179,0.1)`.
- **Border:** 1–1.5px, warna `--line`.
- **Spasi:** kelipatan 4px. Padding kartu 16–24px. Jarak antar kartu 16–24px.
- **Lebar konten:** container landing mengikuti grid; dashboard memakai sidebar 270px dan topbar 68px.

## 5. Komponen

### Tombol
- **Primer (`.btn-primary`):** latar `--blue`, teks putih, pill atau radius 10px, hover naik 2px dengan `translateY(-2px)`.
- **Glass / outline biru (`.btn-glass`):** latar putih, teks dan border `#0047b3`, hover latar `#e6f0ff`.
- **Outline netral (`.btn-outline`):** border `--line`, teks `--ink`.
- Transisi: `all 0.25s ease`.

### Kartu
- Latar `--surface`, border `--line`, radius 12–18px, bayangan `--card-shadow`.
- Hover: naik sedikit dan bayangan lebih tebal (`0 16px 36px -10px rgba(0,71,179,0.12)`).

### Badge / chip
- Pill (`9999px`), latar `--blue-light`, teks `--blue`, font 12px weight 600–700.

### Navbar
- Wordmark sesuai bagian 2 dan 3.
- Latar navbar terang: putih dengan blur. Gelap: `rgba(18,33,68,0.85)` dengan border `#1d3768`.

### Input
- Border `--line`, radius 10px, fokus memakai ring biru `--blue`.

## 6. Mode terang dan gelap

- **Dashboard:** `:root` berisi token terang. Mode gelap aktif lewat `.dark` atau `body.dark`, dan default mengikuti `prefers-color-scheme` jika belum dipilih (lihat `layouts/app.blade.php` baris 33).
- **Landing:** mode gelap lewat `body.dark` dengan override `!important` pada elemen brand.
- **Dokumentasi modul:** **belum** mengikuti sistem ini. Lihat bagian 7.

Setiap komponen baru wajib punya dua versi, terang dan gelap, dengan token yang sama.

## 7. Dokumentasi modul — aturan yang harus diikuti

Halaman dokumentasi modul (`resources/views/modules/*.blade.php`) sudah diselaraskan dengan panduan ini:

- Token dari bagian 2 didefinisikan di `:root` dan `.dark, body.dark` pada `modules/layout.blade.php`. Sebelumnya `index.blade.php` dan `show.blade.php` memakai `var(--blue)`, `var(--muted)`, `var(--border)`, dan `var(--ink)`, tetapi token itu tidak pernah didefinisikan.
- Kelas palet `slate-*`, `cyan-*`, dan `sky-*` serta hex hardcoded (`#0b1120`, `#080d1a`, `#38bdf8`, dll.) sudah diganti token. Latar, panel, teks, border, dan aksen sekarang ikut mode terang dan gelap.
- Tema mengikuti `localStorage('theme')` atau preferensi sistem, sama seperti dashboard.

Yang belum:
- Warna status (`emerald`, `amber`, `rose`, `purple`) masih dipakai langsung untuk badge dan peringatan. Ini perlu token status di bagian 2 dulu. Beberapa kelas bernada gelap (`bg-*-950`) juga perlu diberi versi terang.

Saat mengedit dokumentasi modul berikutnya:
1. Jangan pakai kelas `slate-*`, `cyan-*`, atau `sky-*`. Pakai token.
2. Pakai font dari bagian 3. Blok kode tetap Fira Code.
3. Pakai komponen kartu, tombol, dan badge dari bagian 5.
4. Uji di mode terang dan gelap.

## 8. Ketidakkonsistenan yang sudah ada (catat sebelum mengedit)

- `--orange` dashboard terang `#ea580c`, landing `#f97316`. Pilih satu. Disarankan `#f97316` untuk aksen, `#ea580c` untuk teks di atas putih agar kontras.
- Landing memakai `#0284c7` dan `#38bdf8` sebagai biru muda, dashboard memakai `#0047b3`. Biru muda hanya untuk mode gelap atau ikon.
- Landing mendefinisikan warna langsung di CSS, bukan token. Pelan-pelan pindahkan ke token.
- Modules memakai Tailwind CDN dan kelas acak. Ini sumber utama ketidakkonsistenan.

## 9. Checklist sebelum merge UI

- [ ] Hanya token warna yang dipakai, tanpa hex langsung atau kelas `slate-*`/`cyan-*`.
- [ ] Font Plus Jakarta Sans (Fira Code untuk kode).
- [ ] Radius, bayangan, dan spasi dari bagian 4.
- [ ] Tombol dan kartu memakai komponen bagian 5.
- [ ] Terang dan gelap sama-sama dicek.
- [ ] Tampilan di layar kecil (mobile) tidak rusak.
