<?php

namespace Database\Seeders;

use App\Models\Module;
use App\Models\ModuleCategory;
use App\Models\ReferralCode;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MultiModuleAndReferralSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Modul HTML (PUBLIC - FREE)
        $modulHtml = ModuleCategory::updateOrCreate(
            ['slug' => 'modul-html'],
            [
                'name' => 'Modul HTML Dasar & Modern',
                'description' => 'Pelajari fondasi utama web modern dengan HTML5 semantik, formulir, media, dan struktur dokumen.',
                'is_public' => true,
                'referral_code' => null,
                'icon' => 'fab fa-html5',
                'color' => '#f97316',
                'badge' => 'Pemula',
                'order' => 1,
                'is_active' => true,
            ]
        );

        Module::updateOrCreate(
            ['slug' => 'html-pengenalan-dan-struktur'],
            [
                'category_id' => $modulHtml->id,
                'section' => 'FONDASI HTML',
                'title' => 'Pengenalan HTML5 & Struktur Dasar',
                'order' => 1,
                'is_published' => true,
                'is_public' => true,
                'enable_protection' => true,
                'excerpt' => 'Mengenal anatomi dokumen HTML5, tag pembuka dan penutup, serta doctype declaration.',
                'content' => "# Pengenalan HTML5 & Struktur Dasar Dokumen\n\nHTML (HyperText Markup Language) adalah bahasa standar yang digunakan untuk membuat dan menyusun halaman web.\n\n## Anatomi Dokumen HTML5\n\nSetiap halaman web modern dibangun dengan struktur dasar berikut:\n\n```html:index.html\n<!DOCTYPE html>\n<html lang=\"id\">\n<head>\n    <meta charset=\"UTF-8\">\n    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">\n    <title>Belajar HTML | Flow Academy</title>\n</head>\n<body>\n    <h1>Selamat Datang di Flow Academy</h1>\n    <p>Ini adalah halaman web pertama Anda.</p>\n</body>\n</html>\n```\n\n> [!NOTE]\n> Tag `<!DOCTYPE html>` memberitahu peramban (browser) bahwa dokumen ini menggunakan standar HTML5 modern.\n\n## Elemen & Atribut Dasar\n\nElemen HTML tersusun dari tag pembuka, isi, dan tag penutup. Atribut memberikan informasi tambahan pada elemen:\n\n```html:contoh-elemen.html\n<a href=\"https://flowacademy.fun\" target=\"_blank\" class=\"btn-link\">\n    Kunjungi Website Resmi\n</a>\n```\n",
            ]
        );

        Module::updateOrCreate(
            ['slug' => 'html-form-dan-input'],
            [
                'category_id' => $modulHtml->id,
                'section' => 'FORM & INPUT',
                'title' => 'Formulir & Kontrol Input Interaktif',
                'order' => 2,
                'is_published' => true,
                'is_public' => true,
                'enable_protection' => true,
                'excerpt' => 'Membuat form login, registrasi, validasi input, dan pengiriman data pengguna.',
                'content' => "# Formulir & Kontrol Input Interaktif\n\nFormulir HTML memungkinkan interaksi pengguna melalui pengumpulan data seperti teks, password, email, dan pilihan.\n\n## Contoh Form Registrasi\n\n```html:form-register.html\n<form action=\"/submit\" method=\"POST\">\n    <div class=\"form-group\">\n        <label for=\"nama\">Nama Lengkap:</label>\n        <input type=\"text\" id=\"nama\" name=\"nama\" required placeholder=\"Masukkan nama Anda\">\n    </div>\n    <div class=\"form-group\">\n        <label for=\"email\">Email:</label>\n        <input type=\"email\" id=\"email\" name=\"email\" required placeholder=\"nama@domain.com\">\n    </div>\n    <button type=\"submit\">Daftar Sekarang</button>\n</form>\n```\n\n> [!TIP]\n> Gunakan atribut `required` untuk validasi bawaan browser sebelum formulir dikirim.",
            ]
        );

        // 2. Modul CSS (PRIVATE - Memerlukan Kode Referral: CSSPRO)
        $modulCss = ModuleCategory::updateOrCreate(
            ['slug' => 'modul-css'],
            [
                'name' => 'Modul CSS Layout & Flexbox Mastery',
                'description' => 'Kuasai teknik layouting profesional, Flexbox, CSS Grid, animasi UI, dan responsive design.',
                'is_public' => false,
                'referral_code' => 'CSSPRO',
                'icon' => 'fab fa-css3-alt',
                'color' => '#38bdf8',
                'badge' => 'Eksklusif (Private)',
                'order' => 2,
                'is_active' => true,
            ]
        );

        Module::updateOrCreate(
            ['slug' => 'css-dasar-dan-selektor'],
            [
                'category_id' => $modulCss->id,
                'section' => 'SINTAKS & SELEKTOR',
                'title' => 'Sintaks CSS & Selektor Tingkat Lanjut',
                'order' => 1,
                'is_published' => true,
                'is_public' => false,
                'enable_protection' => true,
                'excerpt' => 'Memahami specificity, inheritance, pseudo-classes, dan kombinator CSS.',
                'content' => "# Sintaks CSS & Selektor Tingkat Lanjut\n\nCSS (Cascading Style Sheets) digunakan untuk mengatur tampilan dan tata letak halaman web.\n\n## Menggunakan Selektor Modern\n\n```css:style.css\n/* Selektor Elemen & Pseudo-class */\n.card-container:hover > .card-title {\n    color: #38bdf8;\n    transform: translateX(4px);\n    transition: all 0.2s ease;\n}\n\n/* Pseudo-element untuk badge */\n.badge-pro::before {\n    content: '★ ';\n    color: #fbbf24;\n}\n```\n\n> [!IMPORTANT]\n> Modul ini adalah materi eksklusif private Flow Academy. Harap menjaga kerahasiaan materi pembelajaran.",
            ]
        );

        Module::updateOrCreate(
            ['slug' => 'css-flexbox-modern-layouts'],
            [
                'category_id' => $modulCss->id,
                'section' => 'FLEXBOX LAYOUT',
                'title' => 'Panduan Lengkap Flexbox Layout',
                'order' => 2,
                'is_published' => true,
                'is_public' => false,
                'enable_protection' => true,
                'excerpt' => 'Teknik penyusunan antarmuka fleksibel satu dimensi horizontal dan vertikal.',
                'content' => "# Panduan Lengkap Flexbox Layout\n\nFlexbox memudahkan penataan elemen secara dinamis dan responsif pada sumbu utama (main axis) dan sumbu silang (cross axis).\n\n```css:flexbox.css\n.navbar {\n    display: flex;\n    justify-content: space-between;\n    align-items: center;\n    padding: 1rem 2rem;\n    background: #0f172a;\n}\n\n.nav-links {\n    display: flex;\n    gap: 1.5rem;\n}\n```\n",
            ]
        );

        // 3. Modul JavaScript (PRIVATE - Memerlukan Kode Referral: JSMASTER)
        $modulJs = ModuleCategory::updateOrCreate(
            ['slug' => 'modul-javascript'],
            [
                'name' => 'Modul JavaScript Modern ES6+',
                'description' => 'Logika pemrograman web interaktif, manipulasi DOM dinamis, asynchronous fetch API, dan event handling.',
                'is_public' => false,
                'referral_code' => 'JSMASTER',
                'icon' => 'fab fa-js-square',
                'color' => '#facc15',
                'badge' => 'Eksklusif (Private)',
                'order' => 3,
                'is_active' => true,
            ]
        );

        Module::updateOrCreate(
            ['slug' => 'js-dasar-dan-dom'],
            [
                'category_id' => $modulJs->id,
                'section' => 'LOGIKA & DOM',
                'title' => 'Manipulasi DOM & Event Listener Modern',
                'order' => 1,
                'is_published' => true,
                'is_public' => false,
                'enable_protection' => true,
                'excerpt' => 'Mengubah elemen HTML dan merespons interaksi klik pengguna secara dinamis.',
                'content' => "# Manipulasi DOM & Event Listener Modern\n\nDOM (Document Object Model) adalah representasi pemrograman dari dokumen HTML.\n\n```javascript:app.js\nconst btnToggle = document.querySelector('#btn-toggle');\nconst targetBox = document.querySelector('.target-box');\n\nbtnToggle.addEventListener('click', (e) => {\n    e.preventDefault();\n    targetBox.classList.toggle('active');\n    console.log('Status diubah pada: ' + new Date().toLocaleTimeString());\n});\n```\n",
            ]
        );

        // 4. Update existing categories order to follow
        ModuleCategory::whereNotIn('slug', ['modul-html', 'modul-css', 'modul-javascript'])->increment('order', 3);

        // 5. Seed Referral Codes for Paid Courses & Modules
        ReferralCode::updateOrCreate(
            ['code' => 'GRATIS100'],
            [
                'description' => 'Voucher 100% Gratis untuk Semua Kursus Berbayar',
                'discount_type' => 'free',
                'discount_value' => 100,
                'target_type' => 'all',
                'max_uses' => 500,
                'is_active' => true,
            ]
        );

        ReferralCode::updateOrCreate(
            ['code' => 'DISKON50'],
            [
                'description' => 'Diskon 50% untuk Semua Kursus',
                'discount_type' => 'percentage',
                'discount_value' => 50,
                'target_type' => 'all',
                'max_uses' => 200,
                'is_active' => true,
            ]
        );

        ReferralCode::updateOrCreate(
            ['code' => 'POTONGAN30K'],
            [
                'description' => 'Potongan Langsung Rp 30.000',
                'discount_type' => 'fixed',
                'discount_value' => 30000,
                'target_type' => 'all',
                'max_uses' => 100,
                'is_active' => true,
            ]
        );

        ReferralCode::updateOrCreate(
            ['code' => 'CSSPRO'],
            [
                'description' => 'Kode Akses Buka Modul CSS & Flexbox',
                'discount_type' => 'free',
                'discount_value' => 100,
                'target_type' => 'module',
                'target_id' => $modulCss->id,
                'max_uses' => null,
                'is_active' => true,
            ]
        );

        ReferralCode::updateOrCreate(
            ['code' => 'JSMASTER'],
            [
                'description' => 'Kode Akses Buka Modul JavaScript Modern',
                'discount_type' => 'free',
                'discount_value' => 100,
                'target_type' => 'module',
                'target_id' => $modulJs->id,
                'max_uses' => null,
                'is_active' => true,
            ]
        );
    }
}
