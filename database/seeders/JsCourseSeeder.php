<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\CourseStory;
use App\Models\CourseHtml;
use App\Models\CourseQuestion;
use App\Models\User;
use Illuminate\Database\Seeder;

class JsCourseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::first();
        $adminId = $admin ? $admin->id : 1;

        $course = Course::create([
            'title' => 'A03 - JavaScript ES6+ Komprehensif: Logika Pemrograman, Manipulasi DOM & Aplikasi Web Modern',
            'description' => 'Kuasai bahasa pemrograman inti web dari fondasi fundamental hingga teknik modern. Pelajari variabel let/const, operator perbandingan ketat, struktur logika percabangan, fungsi modern & arrow functions, manipulasi array mutakhir (map, filter, reduce), interaktivitas dokumen DOM, penanganan event dinamis, hingga pemrograman asynchronous dengan Fetch API dan async/await.',
            'price' => 99000.00,
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
            'title' => 'Bab 1: Ekosistem JavaScript, Variabel Modern (let/const) & Tipe Data Primitif',
            'content' => "### 1.1 Peran Vital JavaScript di Era Web Modern
Jika HTML membangun struktur semantik web dan CSS menghadirkan keindahan estetika visual, maka **JavaScript (JS)** adalah otak, saraf, dan sistem perilaku dinamisnya. JavaScript memungkinkan situs web bereaksi seketika terhadap interaksi pengguna—mulai dari memvalidasi formulir saat diketik, melakukan filter data tanpa refresh halaman, hingga membangun aplikasi web berfitur lengkap (Single Page Applications).

### 1.2 Deklarasi Variabel Modern: Hindari 'var', Gunakan 'let' & 'const'
Pada standar ECMAScript 2015 (ES6), JavaScript memperkenalkan kata kunci deklarasi variabel baru yang menyelesaikan banyak kelemahan `var`:
1. **`const` (Konstanta - Default Pilihan Utama)**:
   - Digunakan untuk nilai yang referensinya tidak akan di-assign ulang (*reassigned*).
   - Memiliki sifat **Block Scope** (hanya hidup di dalam kurung kurawal `{}` tempat ia dideklarasikan).
   - Menghindari bug akibat penimpaan variabel tanpa sengaja.
   ```javascript
   const KODE_PAJAK = 0.11;
   const namaPengguna = 'Budi Santoso';
   // KODE_PAJAK = 0.12; // ERROR: Assignment to constant variable!
   ```
2. **`let` (Variabel yang Nilainya Bermutasi)**:
   - Digunakan ketika nilai variabel memang dipastikan akan berubah sepanjang waktu (seperti penghitung perulangan/counter atau nilai penampung akumulasi).
   - Memiliki sifat **Block Scope**.
   ```javascript
   let skorPermainan = 0;
   skorPermainan += 10; // Valid, skor sekarang 10
   ```
3. **Mengapa `var` Ditinggalkan?**:
   - `var` memiliki cakupan **Function Scope** (bukan Block Scope) dan mengalami fenomena **Hoisting** yang membingungkan serta rawan menimpa variabel global secara tidak sengaja (*leaking*).

### 1.3 Sistem Tipe Data Primitif vs Referensi
JavaScript memiliki 7 tipe data primitif utama:
1. **String**: Teks (`'Halo Dunia'`, `\"Belajar JS\"`, atau template literal `` `Halo \${namaPengguna}` ``).
2. **Number**: Bilangan bulat maupun desimal (`42`, `3.14`, `-10`).
3. **BigInt**: Bilangan bulat dengan presisi ekstra besar melebihi batas 2^53 - 1 (`9007199254740991n`).
4. **Boolean**: Nilai logika kebenaran (`true` atau `false`).
5. **Undefined**: Variabel yang telah dideklarasikan namun belum pernah diberikan nilai.
6. **Null**: Representasi nilai kosong yang sengaja dikosongkan secara eksplisit oleh programmer.
7. **Symbol**: Pengenal unik yang tidak dapat diubah (*immutable*).

*Tipe Data Non-Primitif (Referensi)* meliputi **Object**, **Array**, dan **Function**.

### 1.4 Kesetaraan Ketat (===) vs Kesetaraan Longgar (==)
Salah satu jebakan terbesar bagi pemula di JavaScript adalah *Type Coercion* (konversi tipe otomatis):
- **Operator Longgar (`==`)**: Mengubah tipe data kedua operan secara paksa sebelum dibandingkan.
  ```javascript
  5 == '5' // Menghasilkan true (karena string '5' dipaksa dikonversi ke angka 5)
  0 == false // Menghasilkan true
  null == undefined // Menghasilkan true
  ```
- **Operator Ketat (`===` - Sangat Direkomendasikan)**: Memeriksa **nilai DAN tipe data** secara bersamaan tanpa pemaksaan tipe.
  ```javascript
  5 === '5' // Menghasilkan FALSE (tipe data number vs string berbeda!)
  0 === false // Menghasilkan FALSE
  null === undefined // Menghasilkan FALSE
  ```
> **Aturan Emas Industri**: Selalu gunakan `===` dan `!==` dalam setiap evaluasi logika kondisional Anda.",
            'use_image' => false,
            'use_audio' => false,
            'use_video' => false,
            'order' => $order++,
        ]);

        // Bab 2
        CourseStory::create([
            'course_id' => $course->id,
            'title' => 'Bab 2: Kontrol Alur Logika, Short-Circuit Evaluation & Perulangan Modern',
            'content' => "### 2.1 Percabangan Logika (Conditional Statements)
Program cerdas harus mampu mengambil keputusan berbeda berdasarkan kondisi data yang diterima.

#### 1. Percabangan if - else if - else
```javascript
const usia = 17;
const punyaKTP = true;

if (usia >= 17 && punyaKTP) {
    console.log('Memenuhi syarat pembuatan SIM');
} else if (usia >= 17 && !punyaKTP) {
    console.log('Harap rekam data KTP terlebih dahulu');
} else {
    console.log('Belum memenuhi syarat batas usia');
}
```

#### 2. Ternary Operator (Kondisional Ringkas Satu Baris)
Digunakan sebagai alternatif ekspresi `if-else` sederhana untuk mengembalikan nilai:
```javascript
const statusAkses = isLoggedIn ? 'Selamat Datang Kembali!' : 'Silakan Login Terlebih Dahulu';
```

### 2.2 Short-Circuit Evaluation & Nullish Coalescing (??)
Operator logika di JavaScript mengevaluasi dari kiri ke kanan dan dapat berhenti (*short-circuit*) segera setelah hasilnya dipastikan:
- **Logical AND (`&&`)**: Mengembalikan nilai pertama yang *falsy*, atau nilai terakhir jika semua *truthy*.
  ```javascript
  const user = { nama: 'Rian', role: 'admin' };
  user.role === 'admin' && console.log('Akses Panel Admin Terbuka');
  ```
- **Logical OR (`||`)**: Mengembalikan nilai pertama yang *truthy*. Sering digunakan untuk fallback nilai default. Namun hati-hati: nilai `0` dan `\"\"` (string kosong) dianggap *falsy*.
  ```javascript
  const namaInput = '';
  const namaTampilan = namaInput || 'Tamu'; // namaTampilan = 'Tamu'
  ```
- **Nullish Coalescing Operator (`??`)**: Hanya menganggap `null` dan `undefined` sebagai kondisi pemicu fallback. Angka `0` dan string kosong `\"\"` tetap dipertahankan sebagai nilai valid!
  ```javascript
  const jumlahTiket = 0;
  const tiketAktif = jumlahTiket ?? 1; // tiketAktif = 0
  ```

### 2.3 Perulangan Modern: for...of vs for...in
1. **`for...of` (Iterasi Nilai Elemen)**:
   Digunakan untuk menjelajahi elemen dari struktur data yang *iterable* (Array, Set, Map, String):
   ```javascript
   const daftarBahasa = ['HTML', 'CSS', 'JavaScript', 'Go'];
   for (const bahasa of daftarBahasa) {
       console.log(`Materi: \${bahasa}`);
   }
   ```
2. **`for...in` (Iterasi Kunci Objek / Properties)**:
   Digunakan untuk menginspeksi kunci (*keys*) pada objek:
   ```javascript
   const profil = { nama: 'Sarah', level: 'Intermediate', xp: 2400 };
   for (const key in profil) {
       console.log(`\${key}: \${profil[key]}`);
   }
   ```",
            'use_image' => false,
            'use_audio' => false,
            'use_video' => false,
            'order' => $order++,
        ]);

        // Bab 3
        CourseStory::create([
            'course_id' => $course->id,
            'title' => 'Bab 3: Fungsi Modern (Arrow Functions), Scope, Destructuring & Rest/Spread',
            'content' => "### 3.1 Evolusi Fungsi: Dari Regular Function ke Arrow Function
Fungsi adalah blok kode modular yang dapat dipanggil berkali-kali dengan argumen berbeda.

#### Perbandingan Sintaks:
```javascript
// Regular Function Declaration
function hitungLuasPersegi(sisi) {
    return sisi * sisi;
}

// Arrow Function (ES6)
const hitungLuasPersegiModern = (sisi) => {
    return sisi * sisi;
};

// Arrow Function dengan Implicit Return (Satu Baris Ringkas)
const luasRingkas = sisi => sisi * sisi;
```

#### Perbedaan Utama:
1. **Binding `this`**: Regular function membuat konteks `this` baru saat dieksekusi. Arrow function tidak memiliki `this` sendiri, melainkan mewarisi (*lexical scoping*) dari konteks lingkungan tempat ia didefinisikan.
2. Arrow function tidak dapat digunakan sebagai konstruktor objek (`new`).

### 3.2 Destructuring Assignment (Pembongkaran Struktur Data)
Teknik memecah elemen array atau properti objek langsung ke dalam variabel independen secara bersih:
```javascript
// Destructuring Objek
const user = { id: 101, username: 'fadli_dev', email: 'fadli@example.com', role: 'mentor' };
const { username, role } = user;
console.log(username); // 'fadli_dev'

// Destructuring dengan Alias & Default Value
const { email: surelPribadi, status = 'aktif' } = user;
console.log(surelPribadi); // 'fadli@example.com'

// Destructuring Array
const koordinat = [-6.2088, 106.8456];
const [latitude, longitude] = koordinat;
```

### 3.3 Spread Operator (`...`) dan Rest Parameters
1. **Spread Operator (Menyebarkan / Menggandakan)**:
   Menggandakan atau menggabungkan array/objek tanpa memutasi (*immutable*) data asli:
   ```javascript
   const baseArray = [1, 2, 3];
   const extendedArray = [...baseArray, 4, 5]; // [1, 2, 3, 4, 5]

   const userDasar = { nama: 'Fajar', umur: 22 };
   const userLengkap = { ...userDasar, kota: 'Jakarta' };
   ```
2. **Rest Parameters (Mengumpulkan Sisa Argumen)**:
   Menampung sejumlah argumen fleksibel ke dalam satu variabel array terstruktur:
   ```javascript
   function hitungTotalSemuaHarga(...daftarHarga) {
       return daftarHarga.reduce((total, harga) => total + harga, 0);
   }
   console.log(hitungTotalSemuaHarga(10000, 25000, 40000)); // 75000
   ```",
            'use_image' => false,
            'use_audio' => false,
            'use_video' => false,
            'order' => $order++,
        ]);

        // Bab 4
        CourseStory::create([
            'course_id' => $course->id,
            'title' => 'Bab 4: Manipulasi Koleksi Data Array Lanjutan (map, filter, reduce)',
            'content' => "### 4.1 Paradigma Immutability dalam Pengolahan Data
Dalam arsitektur perangkat lunak modern (seperti React, Vue, maupun arsitektur fungsional JS), kita menghindari mengubah array asli (*mutation*). Sebagai gantinya, kita menghasilkan array baru yang telah ditransformasikan secara murni (*pure transformation*).

Tiga serangkai metode array fungsional terpenting di JavaScript adalah:
1. `map()`
2. `filter()`
3. `reduce()`

### 4.2 Array.prototype.map() — Mentransformasi Setiap Elemen
`map()` mengeksekusi fungsi callback pada setiap elemen dan menghasilkan **array baru dengan panjang yang persis sama**, berisi hasil kalkulasi atau modifikasi.
```javascript
const daftarProduk = [
    { id: 1, nama: 'Laptop Gaming', harga: 15000000 },
    { id: 2, nama: 'Mouse Wireless', harga: 250000 },
    { id: 3, nama: 'Mechanical Keyboard', harga: 800000 }
];

// Mengambil hanya nama-nama produk dalam bentuk array string
const namaProduk = daftarProduk.map(produk => produk.nama);
// Hasil: ['Laptop Gaming', 'Mouse Wireless', 'Mechanical Keyboard']
```

### 4.3 Array.prototype.filter() — Menyaring Berdasarkan Kriteria Logika
`filter()` mengevaluasi setiap elemen dengan kondisi boolean. Jika callback mengembalikan `true`, elemen dimasukkan ke array baru.
```javascript
// Menyaring produk dengan harga di bawah 1 juta rupiah
const produkTerjangkau = daftarProduk.filter(produk => produk.harga < 1000000);
// Hasil: Array berisi 2 item (Mouse dan Keyboard)
```

### 4.4 Array.prototype.reduce() — Mengakumulasi Koleksi Menjadi Satu Nilai Tunggal
`reduce()` memproses setiap elemen secara berurutan dan mengumpulkan hasilnya ke dalam satu variabel penampung (*accumulator*).
```javascript
// Menghitung total keseluruhan nilai inventaris barang
const totalNilaiInventaris = daftarProduk.reduce((akumulator, itemSaatIni) => {
    return akumulator + itemSaatIni.harga;
}, 0); // Nilai awal akumulator ditetapkan 0
console.log(totalNilaiInventaris); // 16050000
```",
            'use_image' => false,
            'use_audio' => false,
            'use_video' => false,
            'order' => $order++,
        ]);

        // Bab 5
        CourseStory::create([
            'course_id' => $course->id,
            'title' => 'Bab 5: Arsitektur DOM & Manajemen Interaktivitas Pengguna (Event Listeners)',
            'content' => "### 5.1 Apa itu DOM (Document Object Model)?
Ketika peramban web (*browser*) membaca berkas HTML Anda, ia mengonstruksi struktur pohon berhierarki di memori yang disebut **DOM**. Setiap tag HTML menjadi node objek JavaScript yang dapat diakses, diubah teksnya, dimanipulasi kelas gayanya, bahkan dihapus atau ditambah secara dinamis.

### 5.2 Memilih Elemen DOM Secara Presisi
Gunakan API modern berbasis selektor CSS yang seragam:
```javascript
// Memilih satu elemen pertama yang cocok
const tombolBeli = document.querySelector('#btn-checkout');
const inputKupon = document.querySelector('.input-promo-code');

// Memilih seluruh elemen yang cocok
const semuaItemKartu = document.querySelectorAll('.card-product');
semuaItemKartu.forEach(kartu => {
    console.log(kartu.dataset.productId);
});
```

### 5.3 Memanipulasi Konten & Kelas Tampilan (CSS Classes)
Praktik terbaik adalah menambah atau melepas kelas CSS yang telah disiapkan di stylesheet:
```javascript
const banner = document.querySelector('.alert-notification');

// Mengubah isi teks secara aman (mencegah XSS injection)
banner.textContent = 'Pemesanan Anda berhasil dikonfirmasi!';

// Manipulasi daftar kelas CSS (classList API)
banner.classList.add('alert-success');
banner.classList.remove('d-none');
banner.classList.toggle('is-expanded');
```

### 5.4 Menangani Interaksi Pengguna dengan Event Listener
Gunakan method `addEventListener` untuk mendaftarkan fungsi penangan aksi pengguna:
```javascript
const formulirRegistrasi = document.querySelector('#form-register');

formulirRegistrasi.addEventListener('submit', (event) => {
    // PENTING: Mencegah halaman me-refresh otomatis saat form disubmit!
    event.preventDefault();

    const inputEmail = document.querySelector('#email-field');
    if (!inputEmail.value.includes('@')) {
        alert('Mohon masukkan alamat email yang valid!');
        return;
    }

    console.log('Mengirim payload ke server backend...');
});
```",
            'use_image' => false,
            'use_audio' => false,
            'use_video' => false,
            'order' => $order++,
        ]);

        // Bab 6
        CourseStory::create([
            'course_id' => $course->id,
            'title' => 'Bab 6: Pola Desain Komponen: State Management Sederhana & LocalStorage',
            'content' => "### 6.1 Filosofi State-Driven UI
Dalam pengembangan antarmuka modern, kita memisahkan antara **Data (State)** dan **Tampilan Layar (UI Rendering)**.
- **Prinsip Utama**: Cukup ubah data pusat (*state*), lalu jalankan fungsi render yang memperbarui DOM secara konsisten sesuai isi state saat ini!

### 6.2 Contoh Arsitektur State Sederhana:
```javascript
// 1. Single Source of Truth (State Tunggal)
const aplikasiState = {
    daftarTugas: [
        { id: 1, judul: 'Belajar Sintaks ES6', selesai: true },
        { id: 2, judul: 'Eksplorasi DOM Events', selesai: false }
    ]
};

// 2. Fungsi Rendering Berbasis State
function renderDaftarTugas() {
    const kontainer = document.querySelector('#todo-list-container');
    kontainer.innerHTML = '';

    aplikasiState.daftarTugas.forEach(tugas => {
        const itemEl = document.createElement('li');
        itemEl.className = `todo-item \${tugas.selesai ? 'is-completed' : ''}`;
        itemEl.innerHTML = `<span>\${tugas.judul}</span>`;
        kontainer.appendChild(itemEl);
    });
}
```

### 6.3 Menyimpan Data di Browser dengan Web Storage API (localStorage)
```javascript
// Menyimpan data array ke localStorage
function simpanKeStorage() {
    localStorage.setItem('APLIKASI_TODO_DATA', JSON.stringify(aplikasiState.daftarTugas));
}

// Membaca data saat aplikasi pertama kali dimuat
function muatDariStorage() {
    const rawData = localStorage.getItem('APLIKASI_TODO_DATA');
    if (rawData) {
        aplikasiState.daftarTugas = JSON.parse(rawData);
    }
}
```",
            'use_image' => false,
            'use_audio' => false,
            'use_video' => false,
            'order' => $order++,
        ]);

        // Bab 7
        CourseStory::create([
            'course_id' => $course->id,
            'title' => 'Bab 7: Pemrograman Asynchronous: Promise, Async/Await & Fetch API ke Server',
            'content' => "### 7.1 Mengapa JavaScript Memerlukan Asynchronous?
JavaScript berjalan pada sistem **Single-Threaded** (hanya satu instruksi yang dieksekusi dalam satu waktu). Jika Anda meminta data ke server yang membutuhkan waktu 3 detik, dan operasi tersebut bersifat *synchronous* (blocking), maka seluruh browser pengguna akan membeku seketika.

Untuk mengatasi ini, operasi berat seperti HTTP Request dan timer dijalankan secara **Asynchronous** melalui bantuan *Web APIs* dan *Event Loop*.

### 7.2 Struktur Promise di JavaScript
Promise adalah representasi objek dari suatu proses asynchronous yang dapat berada di 3 status:
1. **Pending**: Operasi sedang berlangsung.
2. **Fulfilled (Resolved)**: Operasi berhasil diselesaikan dan mengembalikan hasil.
3. **Rejected**: Operasi mengalami kegagalan/error.

### 7.3 Gaya Modern: Async / Await dengan Try - Catch
```javascript
async function ambilDataCuaca(kota) {
    const urlApi = `https://api.contoh-cuaca.com/v1/forecast?city=\${kota}`;

    try {
        console.log('Memulai permintaan data jaringan...');
        const response = await fetch(urlApi);

        if (!response.ok) {
            throw new Error(`Gagal memuat data! Status HTTP: \${response.status}`);
        }

        const dataCuaca = await response.json();
        console.log('Data cuaca berhasil diterima:', dataCuaca);
        return dataCuaca;

    } catch (error) {
        console.error('Terjadi kendala saat komunikasi dengan API:', error.message);
        throw error;
    } finally {
        console.log('Proses permintaan selesai dijalankan.');
    }
}
```",
            'use_image' => false,
            'use_audio' => false,
            'use_video' => false,
            'order' => $order++,
        ]);

        // -------------------------------------------------------------
        // LIVE DEMO HTML / JS (CourseHtml)
        // -------------------------------------------------------------
        CourseHtml::create([
            'course_id' => $course->id,
            'title' => 'Live Lab: Mini Web App Task Tracker Interaktif dengan Manipulasi DOM & State',
            'content' => 'Eksplorasi pembuatan aplikasi Todo List interaktif menggunakan manipulasi DOM murni, event delegation, dan manajemen state berbasis data array.',
            'html_code' => '<div class="app-card">
  <div class="app-header">
    <h3>✨ Pro Task Tracker</h3>
    <span id="task-badge" class="badge">0 Tugas</span>
  </div>

  <div class="input-group">
    <input type="text" id="task-input" placeholder="Ketik aktivitas baru lalu tekan enter...">
    <button id="add-btn" class="btn-primary">Tambah</button>
  </div>

  <div class="filter-group">
    <button class="filter-btn active" data-filter="all">Semua</button>
    <button class="filter-btn" data-filter="pending">Aktif</button>
    <button class="filter-btn" data-filter="completed">Selesai</button>
  </div>

  <ul id="task-list" class="task-list"></ul>

  <div class="app-footer">
    <span id="status-summary">Belum ada tugas tercatat.</span>
    <button id="clear-completed-btn" class="btn-text">Hapus Selesai</button>
  </div>
</div>

<style>
.app-card {
  max-width: 480px;
  margin: 1.5rem auto;
  background: #ffffff;
  border-radius: 16px;
  box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
  padding: 1.5rem;
  font-family: system-ui, -apple-system, sans-serif;
  color: #1e293b;
}
.app-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 1.25rem;
}
.app-header h3 {
  margin: 0;
  font-size: 1.25rem;
  font-weight: 700;
  color: #0f172a;
}
.badge {
  background: #e0e7ff;
  color: #4338ca;
  font-size: 0.75rem;
  font-weight: 600;
  padding: 0.25rem 0.6rem;
  border-radius: 9999px;
}
.input-group {
  display: flex;
  gap: 0.5rem;
  margin-bottom: 1rem;
}
.input-group input {
  flex: 1;
  padding: 0.65rem 0.9rem;
  border: 1.5px solid #cbd5e1;
  border-radius: 8px;
  font-size: 0.875rem;
  outline: none;
  transition: border-color 0.2s;
}
.input-group input:focus {
  border-color: #4f46e5;
}
.btn-primary {
  background: #4f46e5;
  color: #ffffff;
  border: none;
  padding: 0.65rem 1.1rem;
  border-radius: 8px;
  font-weight: 600;
  font-size: 0.875rem;
  cursor: pointer;
  transition: background-color 0.2s;
}
.btn-primary:hover {
  background: #4338ca;
}
.filter-group {
  display: flex;
  gap: 0.4rem;
  margin-bottom: 1rem;
}
.filter-btn {
  background: #f1f5f9;
  border: none;
  padding: 0.35rem 0.75rem;
  border-radius: 6px;
  font-size: 0.75rem;
  font-weight: 600;
  color: #64748b;
  cursor: pointer;
}
.filter-btn.active {
  background: #0f172a;
  color: #ffffff;
}
.task-list {
  list-style: none;
  padding: 0;
  margin: 0;
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
  min-height: 120px;
}
.task-item {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 0.65rem 0.85rem;
  background: #f8fafc;
  border: 1px solid #e2e8f0;
  border-radius: 8px;
  transition: all 0.2s;
}
.task-item.completed {
  background: #f1f5f9;
  opacity: 0.7;
}
.task-item.completed .task-text {
  text-decoration: line-through;
  color: #94a3b8;
}
.task-left {
  display: flex;
  align-items: center;
  gap: 0.65rem;
}
.btn-delete {
  background: transparent;
  border: none;
  color: #ef4444;
  cursor: pointer;
  font-size: 1rem;
}
.app-footer {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-top: 1.25rem;
  padding-top: 0.75rem;
  border-top: 1px solid #f1f5f9;
  font-size: 0.75rem;
  color: #64748b;
}
.btn-text {
  background: none;
  border: none;
  color: #6366f1;
  font-size: 0.75rem;
  cursor: pointer;
  font-weight: 600;
}
.btn-text:hover {
  text-decoration: underline;
}
</style>

<script>
(function() {
  const state = {
    tasks: [
      { id: 1, text: "Kuasai selektor querySelector di DOM", done: true },
      { id: 2, text: "Pahami implementasi event listener submit", done: false },
      { id: 3, text: "Latihan Higher-order function array map/filter", done: false }
    ],
    filter: "all"
  };

  const listEl = document.getElementById("task-list");
  const inputEl = document.getElementById("task-input");
  const addBtn = document.getElementById("add-btn");
  const badgeEl = document.getElementById("task-badge");
  const summaryEl = document.getElementById("status-summary");
  const clearBtn = document.getElementById("clear-completed-btn");
  const filterBtns = document.querySelectorAll(".filter-btn");

  function render() {
    listEl.innerHTML = "";
    const filtered = state.tasks.filter(t => {
      if (state.filter === "pending") return !t.done;
      if (state.filter === "completed") return t.done;
      return true;
    });

    if (filtered.length === 0) {
      listEl.innerHTML = `<li style="text-align: center; color: #94a3b8; padding: 1.5rem 0; font-size: 0.875rem;">Tidak ada tugas pada kategori ini.</li>`;
    } else {
      filtered.forEach(task => {
        const li = document.createElement("li");
        li.className = "task-item " + (task.done ? "completed" : "");
        li.innerHTML = `
          <div class="task-left">
            <input type="checkbox" \${task.done ? "checked" : ""} data-id="\${task.id}" class="task-toggle">
            <span class="task-text">\${task.text}</span>
          </div>
          <button class="btn-delete" data-id="\${task.id}" title="Hapus tugas">&times;</button>
        `;
        listEl.appendChild(li);
      });
    }

    const pendingCount = state.tasks.filter(t => !t.done).length;
    badgeEl.textContent = `\${state.tasks.length} Total`;
    summaryEl.textContent = `\${pendingCount} tugas aktif tersisa`;
  }

  function addTask() {
    const val = inputEl.value.trim();
    if (!val) return;
    state.tasks.push({ id: Date.now(), text: val, done: false });
    inputEl.value = "";
    render();
  }

  addBtn.addEventListener("click", addTask);
  inputEl.addEventListener("keypress", (e) => {
    if (e.key === "Enter") addTask();
  });

  listEl.addEventListener("click", (e) => {
    const id = Number(e.target.dataset.id);
    if (!id) return;

    if (e.target.classList.contains("task-toggle")) {
      const item = state.tasks.find(t => t.id === id);
      if (item) item.done = !item.done;
      render();
    } else if (e.target.classList.contains("btn-delete")) {
      state.tasks = state.tasks.filter(t => t.id !== id);
      render();
    }
  });

  filterBtns.forEach(btn => {
    btn.addEventListener("click", () => {
      filterBtns.forEach(b => b.classList.remove("active"));
      btn.classList.add("active");
      state.filter = btn.dataset.filter;
      render();
    });
  });

  clearBtn.addEventListener("click", () => {
    state.tasks = state.tasks.filter(t => !t.done);
    render();
  });

  render();
})();
</script>',
            'order' => $order++,
        ]);

        // -------------------------------------------------------------
        // SOAL KUIS PILIHAN GANDA (10 SOAL)
        // -------------------------------------------------------------
        $questions = [
            [
                'title' => 'Cakupan Variabel const dan let dalam ES6',
                'content' => "Perhatikan cuplikan kode JavaScript modern berikut:\n\n```javascript\nfunction periksaKondisi() {\n    if (true) {\n        let nilaiX = 100;\n        const nilaiY = 200;\n    }\n    console.log(nilaiX, nilaiY);\n}\nperiksaKondisi();\n```\n\nApa yang akan terjadi ketika fungsi di atas dijalankan di console browser?",
                'options' => [
                    '100 200',
                    'undefined undefined',
                    'ReferenceError: nilaiX is not defined',
                    'null null'
                ],
                'correct_answer' => 'ReferenceError: nilaiX is not defined',
                'hint' => 'let dan const memiliki block scope di dalam kurung kurawal {}.',
            ],
            [
                'title' => 'Prinsip Kesetaraan Ketat (Strict Equality)',
                'content' => "Berdasarkan aturan penanganan tipe data JavaScript, ekspresi mana di bawah ini yang akan menghasilkan nilai boolean `true`?",
                'options' => [
                    '0 === false',
                    '5 === "5"',
                    'null === undefined',
                    '5 !== "5"'
                ],
                'correct_answer' => '5 !== "5"',
                'hint' => '!== mengevaluasi ketidaksamaan tipe maupun nilai.',
            ],
            [
                'title' => 'Transformasi Data Menggunakan Array.prototype.map()',
                'content' => "Diberikan sebuah array angka: `const data = [2, 4, 6];`.\n\nJika kita mengeksekusi kode: `const hasil = data.map(n => n * 3);`, apa output dari variabel `hasil` dan status array asli `data`?",
                'options' => [
                    'hasil bernilai [6, 12, 18], dan array data berubah menjadi [6, 12, 18]',
                    'hasil bernilai [6, 12, 18], dan array data tetap [2, 4, 6]',
                    'hasil bernilai 36 (penjumlahan), dan data tetap [2, 4, 6]',
                    'hasil bernilai boolean true'
                ],
                'correct_answer' => 'hasil bernilai [6, 12, 18], dan array data tetap [2, 4, 6]',
                'hint' => 'map() bersifat immutable dan mengembalikan array baru.',
            ],
            [
                'title' => 'Perbedaan Array filter() vs find()',
                'content' => "Jika Anda memiliki daftar objek pengguna dan ingin mengambil SATU objek pengguna pertama yang memiliki properti `id === 42`, metode array manakah yang paling tepat dan efisien digunakan?",
                'options' => [
                    'daftarPengguna.map(u => u.id === 42)',
                    'daftarPengguna.reduce(u => u.id === 42)',
                    'daftarPengguna.find(u => u.id === 42)',
                    'daftarPengguna.filter(u => u.id === 42)'
                ],
                'correct_answer' => 'daftarPengguna.find(u => u.id === 42)',
                'hint' => 'find() langsung berhenti saat menemukan elemen pertama yang cocok.',
            ],
            [
                'title' => 'Kalkulasi Akumulator dengan Array.prototype.reduce()',
                'content' => "Perhatikan kode kalkulasi total belanja berikut:\n\n```javascript\nconst keranjang = [10000, 20000, 30000];\nconst total = keranjang.reduce((acc, curr) => acc + curr, 5000);\n```\n\nBerapakah nilai akhir dari variabel `total`?",
                'options' => [
                    '60000',
                    '65000',
                    '5000',
                    'Error: NaN'
                ],
                'correct_answer' => '65000',
                'hint' => 'Nilai awal akumulator adalah 5000.',
            ],
            [
                'title' => 'Mencegah Reload Halaman pada Event Form Submit',
                'content' => "Saat membuat antarmuka web interaktif berbasis JavaScript, metode event apa yang WAJIB dipanggil di dalam listener submit form agar browser tidak melakukan refresh otomatis ke URL action?",
                'options' => [
                    'event.stopPropagation()',
                    'event.preventDefault()',
                    'document.stopReload()',
                    'window.freezeForm()'
                ],
                'correct_answer' => 'event.preventDefault()',
                'hint' => 'Mencegah aksi bawaan browser.',
            ],
            [
                'title' => 'Keunggulan Nullish Coalescing (??) atas Logical OR (||)',
                'content' => "Diberikan kode pengaturan konfigurasi berikut:\n\n```javascript\nconst kuotaTersisa = 0;\nconst kuotaA = kuotaTersisa || 10;\nconst kuotaB = kuotaTersisa ?? 10;\n```\n\nBerapakah nilai dari `kuotaA` dan `kuotaB` berturut-turut?",
                'options' => [
                    'kuotaA = 0, kuotaB = 0',
                    'kuotaA = 10, kuotaB = 10',
                    'kuotaA = 10, kuotaB = 0',
                    'kuotaA = 0, kuotaB = 10'
                ],
                'correct_answer' => 'kuotaA = 10, kuotaB = 0',
                'hint' => '?? hanya memeriksa null dan undefined, mempertahankan 0.',
            ],
            [
                'title' => 'Karakteristik Lexical Binding this pada Arrow Functions',
                'content' => "Manakah pernyataan yang PALING TEPAT mengenai kata kunci `this` di dalam sebuah Arrow Function?",
                'options' => [
                    'Arrow function selalu membuat konteks this baru yang mengikat objek global window',
                    'Arrow function tidak memiliki this sendiri; ia mewarisi this dari scope leksikal lingkungan tempat ia dibuat',
                    'Kata kunci this di dalam arrow function nilainya selalu undefined',
                    'Nilai this di arrow function dapat diubah secara bebas menggunakan method .bind()'
                ],
                'correct_answer' => 'Arrow function tidak memiliki this sendiri; ia mewarisi this dari scope leksikal lingkungan tempat ia dibuat',
                'hint' => 'Lexical scoping mewarisi konteks pembungkus di luarnya.',
            ],
            [
                'title' => 'Mekanisme Penyebaran Event (Event Bubbling) pada DOM',
                'content' => "Ketika seorang pengguna mengklik sebuah elemen tombol `<button class=\"btn-hapus\">` yang berada di dalam pembungkus `<div class=\"kartu\">`, bagaimanakah alur penjalaran event secara default?",
                'options' => [
                    'Event hanya dieksekusi pada button dan berhenti seketika secara otomatis',
                    'Event pertama kali aktif di window, lalu turun ke body, dan berhenti di div',
                    'Event dipicu pertama kali pada button sasaran, kemudian merembet naik (bubble) ke div induk hingga dokumen terluar',
                    'Event terjadi secara acak pada seluruh elemen di layar'
                ],
                'correct_answer' => 'Event dipicu pertama kali pada button sasaran, kemudian merembet naik (bubble) ke div induk hingga dokumen terluar',
                'hint' => 'Event merambat naik dari target paling dalam ke leluhur (ancestors).',
            ],
            [
                'title' => 'Penanganan Error Asynchronous dengan Async/Await',
                'content' => "Konstruksi standar manakah yang digunakan di JavaScript modern untuk menangkap dan menangani kegagalan jaringan atau parsing saat menggunakan `async/await`?",
                'options' => [
                    'Blok try { ... } catch (error) { ... }',
                    'Fungsi onError() bawaan window',
                    'Pernyataan if (await === error)',
                    'Blok while (isPending) { retry(); }'
                ],
                'correct_answer' => 'Blok try { ... } catch (error) { ... }',
                'hint' => 'Menggunakan blok standar try-catch.',
            ]
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
        // TANTANGAN CODING (CODING CHALLENGES)
        // -------------------------------------------------------------

        // Coding 1: Filter Angka Genap & Kuadrat
        CourseQuestion::create([
            'course_id' => $course->id,
            'question_type' => 'coding',
            'title' => 'Tantangan Algoritma: Saring Bilangan Genap dan Kuadratkan',
            'content' => "Kamu diminta membuat program untuk memproses daftar angka masukan.\n\nAturan Pemrosesan:\n1. Baris pertama input adalah N (jumlah angka).\n2. Baris berikutnya berisi N angka bulat.\n3. Saring dan ambil HANYA angka yang bernilai GENAP.\n4. Kuadratkan setiap angka genap tersebut (angka * angka).\n5. Cetak total penjumlahan dari seluruh hasil kuadrat tersebut.\n\nContoh Input:\n4\n1\n2\n3\n4\n\nPenjelasan:\nAngka genap: 2 dan 4.\nHasil kuadrat: 2^2 = 4, 4^2 = 16.\nTotal penjumlahan: 4 + 16 = 20.\n\nFormat Output:\nCetak satu angka integer hasil penjumlahan.",
            'language' => 'go',
            'starter_code' => "package main\n\nimport (\n\t\"fmt\"\n)\n\nfunc main() {\n\tvar n int\n\tfmt.Scan(&n)\n\n\ttotal := 0\n\tfor i := 0; i < n; i++ {\n\t\tvar val int\n\t\tfmt.Scan(&val)\n\t\t// Lengkapi logika: jika val genap, tambahkan kuadratnya ke total\n\t}\n\n\tfmt.Println(total)\n}\n",
            'admin_code' => "package main\n\nimport (\n\t\"fmt\"\n)\n\nfunc main() {\n\tvar n int\n\tif _, err := fmt.Scan(&n); err != nil {\n\t\treturn\n\t}\n\n\ttotal := 0\n\tfor i := 0; i < n; i++ {\n\t\tvar val int\n\t\tfmt.Scan(&val)\n\t\tif val%2 == 0 {\n\t\t\ttotal += (val * val)\n\t\t}\n\t}\n\n\tfmt.Println(total)\n}\n",
            'test_cases' => [
                [
                    'input' => "4\n1\n2\n3\n4",
                    'expected_output' => "20"
                ],
                [
                    'input' => "5\n2\n4\n6\n8\n10",
                    'expected_output' => "220"
                ],
                [
                    'input' => "3\n1\n3\n5",
                    'expected_output' => "0"
                ]
            ],
            'expected_output' => "20",
            'hint' => 'Gunakan modulus (val % 2 == 0) untuk memeriksa bilangan genap.',
            'order' => $order++,
        ]);

        // Coding 2: Sistem Kasir Diskon Belanja
        CourseQuestion::create([
            'course_id' => $course->id,
            'question_type' => 'coding',
            'title' => 'Kalkulator Diskon Belanja Kasir Otomatis',
            'content' => "Sebuah minimarket membutuhkan program kasir otomatis. Kamu diminta membuat program untuk menjumlahkan semua harga barang yang dibeli oleh pelanggan.\n\nAturan Promo:\nJika total belanja pelanggan LEBIH DARI Rp 100.000, pelanggan berhak mendapatkan diskon sebesar 10% dari total belanja. Jika kurang dari atau sama dengan 100.000, tidak ada diskon.\n\nFormat Input:\nBaris pertama adalah N (jumlah barang).\nN baris berikutnya adalah harga masing-masing barang (angka desimal / float).\n\nFormat Output:\nCetak total harga yang harus dibayar setelah diskon menggunakan format dua angka di belakang koma (contoh: 99000.00).",
            'language' => 'go',
            'starter_code' => "package main\n\nimport (\n\t\"fmt\"\n)\n\nfunc main() {\n\tvar n int\n\tfmt.Scan(&n)\n\n\tvar total float64\n\tfor i := 0; i < n; i++ {\n\t\tvar harga float64\n\t\tfmt.Scan(&harga)\n\t\ttotal += harga\n\t}\n\n\t// Lengkapi aturan diskon 10% jika total > 100000\n\tfmt.Printf(\"%.2f\\n\", total)\n}\n",
            'admin_code' => "package main\n\nimport (\n\t\"fmt\"\n)\n\nfunc main() {\n\tvar n int\n\tif _, err := fmt.Scan(&n); err != nil {\n\t\treturn\n\t}\n\n\tvar total float64\n\tfor i := 0; i < n; i++ {\n\t\tvar harga float64\n\t\tfmt.Scan(&harga)\n\t\ttotal += harga\n\t}\n\n\tif total > 100000.0 {\n\t\ttotal = total * 0.90\n\t}\n\n\tfmt.Printf(\"%.2f\\n\", total)\n}\n",
            'test_cases' => [
                [
                    'input' => "3\n50000\n40000\n20000",
                    'expected_output' => "99000.00"
                ],
                [
                    'input' => "2\n30000\n50000",
                    'expected_output' => "80000.00"
                ],
                [
                    'input' => "1\n200000",
                    'expected_output' => "180000.00"
                ]
            ],
            'expected_output' => "99000.00",
            'hint' => 'Periksa kondisi jika total > 100000 kalikan dengan 0.90.',
            'order' => $order++,
        ]);
    }
}
