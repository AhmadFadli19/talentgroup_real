@extends('layouts.app')

@section('title', 'Upload Prototype & Free Hosting | TalentGroup')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 py-8">
    
    <!-- Upload Heading -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-5 mb-6">
        <div>
            <div class="flex flex-wrap items-center gap-3 mb-2">
                <h1 class="text-3xl sm:text-4xl font-black text-[var(--ink)] tracking-tight">
                    Upload Prototype
                </h1>
                <span class="pill success-outline text-xs sm:text-sm px-3.5 py-1 font-bold">Hosting 100% Gratis</span>
            </div>
            <p class="text-sm sm:text-base text-[var(--text2)] max-w-3xl leading-relaxed">
                Unggah prototype website Anda. AI Agent akan memindai & mereview otomatis kualitas, struktur, kerapihan, dan keamanan kode. Jika dinilai layak (skor minimal <strong class="text-[var(--blue)] font-mono font-bold">{{ $settings->min_passing_score }}</strong>), prototype langsung aktif di-hosting gratis dengan URL publik!
            </p>
        </div>
        <a href="{{ route('user.prototypes.index') }}" class="btn btn-outline self-start md:self-auto text-sm font-bold py-2.5 px-4 shadow-sm inline-flex items-center gap-2">
            <i class="fas fa-layer-group text-[var(--blue)] text-base"></i> Prototipe Saya
        </a>
    </div>

    <!-- Stepper matching tg-website (Ukuran Lebih Besar & Jelas) -->
    <ol class="stepper mb-8">
        <li class="active" id="step-nav-1"><span>1</span>Upload File</li>
        <li id="step-nav-2"><span>2</span>Scan AI Agent</li>
        <li id="step-nav-3"><span>3</span>Lolos Review</li>
        <li id="step-nav-4"><span>4</span>Prototype Live</li>
    </ol>

    <!-- Main Container -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        
        <!-- Form / Content Column -->
        <div class="lg:col-span-8" id="upload-section">
            <div class="cyber-card p-6 sm:p-9 bg-white border border-[var(--border)] shadow-sm rounded-2xl">
                
                <div class="border-b border-[var(--border)] pb-4 mb-6">
                    <h2 class="text-xl sm:text-2xl font-black text-[var(--ink)]">Detail Berkas Prototype</h2>
                    <p class="text-sm text-[var(--muted)] mt-1">Unggah satu paket ZIP dan lengkapi detail aplikasi web statis Anda.</p>
                </div>

                <form id="prototype-upload-form" enctype="multipart/form-data">
                    @csrf

                    <!-- ZIP Dropzone -->
                    <div class="mb-6">
                        <label class="block text-xs sm:text-sm font-extrabold uppercase tracking-wider text-[var(--ink)] mb-2.5">
                            Berkas Proyek Web (.ZIP)
                        </label>
                        <div class="border-2 border-dashed border-[#94a3b8] hover:border-[var(--blue)] rounded-2xl p-8 sm:p-12 text-center bg-[var(--bg3)] hover:bg-[var(--blue-light)]/30 transition-all cursor-pointer relative group"
                            id="zip-dropzone" onclick="document.getElementById('zip_file').click()">
                            <input type="file" name="zip_file" id="zip_file" accept=".zip" class="hidden" onchange="handleZipSelected(this)">
                            
                            <div class="w-16 h-16 rounded-2xl bg-[var(--blue-light)] text-[var(--blue)] flex items-center justify-center mx-auto text-3xl mb-4 border border-[#bfdbfe]">
                                <i class="fas fa-cloud-upload-alt"></i>
                            </div>
                            
                            <strong class="text-base sm:text-lg font-bold text-[var(--ink)] block mb-1.5" id="zip-drop-text">
                                Tarik & lepaskan file .ZIP ke sini, atau klik untuk memilih
                            </strong>
                            <span class="text-sm text-[var(--muted)] block mb-4" id="zip-file-info">
                                Arsip .zip berisi index.html, file CSS, dan JS &middot; Maksimal 40 MB
                            </span>

                            <div class="flex flex-wrap items-center justify-center gap-2 text-xs font-semibold">
                                <span class="pill blue-soft py-1 px-3">Anti-ZipSlip Proteksi</span>
                                <span class="pill blue-soft py-1 px-3">Ekstraksi Otomatis</span>
                                <span class="pill blue-soft py-1 px-3">Auto-Sanitasi Kode</span>
                            </div>
                        </div>
                        <div class="mt-3 p-4 rounded-xl bg-[var(--blue-light)] border border-[#bfdbfe] text-xs sm:text-sm text-[var(--blue-dark)] flex items-start gap-3">
                            <i class="fas fa-info-circle text-[var(--blue)] text-base mt-0.5"></i>
                            <div class="leading-relaxed">
                                <strong>Struktur folder otomatis dibaca:</strong> ZIP boleh berisi folder proyek. Pastikan hasil website statis memiliki <code>index.html</code>; file CSS, JavaScript, gambar, dan halaman lain ikut disimpan. Backend Node seperti <code>server.js</code> tidak dijalankan oleh hosting prototype.
                            </div>
                        </div>
                    </div>

                    <!-- Form Inputs -->
                    <div class="space-y-5 pt-2">
                        <div>
                            <label class="block text-xs sm:text-sm font-extrabold uppercase tracking-wider text-[var(--ink)] mb-2" for="project_name">
                                Nama Prototype <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" name="project_name" id="project_name" required
                                placeholder="Contoh: Portofolio Web Interaktif, Dashboard Kasir Modern"
                                class="cyber-input text-sm py-3 px-4 font-medium rounded-xl">
                        </div>

                        <div>
                            <label class="block text-xs sm:text-sm font-extrabold uppercase tracking-wider text-[var(--ink)] mb-2" for="tech_stack">
                                Teknologi yang Digunakan (Tech Stack)
                            </label>
                            <input type="text" name="tech_stack" id="tech_stack"
                                placeholder="Contoh: HTML5, CSS3, JavaScript ES6, TailwindCSS"
                                class="cyber-input text-sm py-3 px-4 font-medium rounded-xl">
                        </div>

                        <div>
                            <label class="block text-xs sm:text-sm font-extrabold uppercase tracking-wider text-[var(--ink)] mb-2" for="prototype_description">
                                Deskripsi Singkat Prototype
                            </label>
                            <textarea name="prototype_description" id="prototype_description" rows="3"
                                placeholder="Jelaskan fungsi utama, fitur unggulan, atau tujuan dari prototype ini..."
                                class="cyber-input text-sm py-3 px-4 font-medium rounded-xl leading-relaxed"></textarea>
                        </div>
                    </div>

                    <!-- Submit Action -->
                    <div class="mt-8 pt-5 border-t border-[var(--border)] flex flex-col sm:flex-row items-center justify-between gap-4">
                        <label class="inline-flex items-center gap-2.5 text-sm text-[var(--ink)] font-semibold cursor-pointer select-none">
                            <input type="checkbox" id="prototype-consent" required class="rounded text-[var(--blue)] w-4 h-4">
                            <span>Karya asli saya sendiri & bersedia di-scan oleh AI Reviewer</span>
                        </label>
                        <button type="submit" id="btn-submit-analyze" class="btn btn-gradient text-sm sm:text-base py-3 px-6 font-bold w-full sm:w-auto shadow-md flex items-center justify-center gap-2">
                            <i class="fas fa-wand-magic-sparkles text-base"></i> Upload & Mulai Scan AI
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Right Column / Information Sidebars -->
        <div class="lg:col-span-4 flex flex-col gap-6" id="upload-sidebar">
            <!-- AI Panel -->
            <article class="cyber-card p-6 bg-white border border-[var(--border)] rounded-2xl shadow-sm">
                <div class="flex items-center gap-3.5 mb-4">
                    <span class="w-10 h-10 rounded-xl bg-[var(--blue-light)] text-[var(--blue)] font-black text-sm flex items-center justify-center border border-[#bfdbfe]">
                        AI
                    </span>
                    <div>
                        <h3 class="text-base font-extrabold text-[var(--ink)]">AI Agent Reviewer</h3>
                        <p class="text-xs font-mono text-[var(--muted)]">Hasil scan lengkap dalam &plusmn;15 detik</p>
                    </div>
                </div>
                <p class="text-sm text-[var(--text2)] mb-5 leading-relaxed">
                    AI Agent memindai prototype dari 5 indikator kualitas kode. Skor minimal <strong class="text-[var(--blue)] font-mono font-bold">{{ $settings->min_passing_score }}</strong> untuk lolos dan langsung aktif di-hosting.
                </p>
                <div class="space-y-2.5 text-sm">
                    <div class="flex justify-between items-center py-1.5 border-b border-[var(--border)]">
                        <span class="text-[var(--ink)] font-semibold flex items-center gap-2">
                            <i class="fas fa-code text-indigo-500 w-4"></i> Kerapihan & Kualitas Kode
                        </span>
                        <span class="text-xs font-mono font-bold text-[var(--blue)] bg-blue-500/10 px-2.5 py-0.5 rounded">25%</span>
                    </div>
                    <div class="flex justify-between items-center py-1.5 border-b border-[var(--border)]">
                        <span class="text-[var(--ink)] font-semibold flex items-center gap-2">
                            <i class="fas fa-bolt text-amber-500 w-4"></i> Kecepatan & Performa
                        </span>
                        <span class="text-xs font-mono font-bold text-[var(--blue)] bg-blue-500/10 px-2.5 py-0.5 rounded">20%</span>
                    </div>
                    <div class="flex justify-between items-center py-1.5 border-b border-[var(--border)]">
                        <span class="text-[var(--ink)] font-semibold flex items-center gap-2">
                            <i class="fas fa-shield-alt text-emerald-500 w-4"></i> Keamanan & Anti-Malware
                        </span>
                        <span class="text-xs font-mono font-bold text-[var(--blue)] bg-blue-500/10 px-2.5 py-0.5 rounded">20%</span>
                    </div>
                    <div class="flex justify-between items-center py-1.5 border-b border-[var(--border)]">
                        <span class="text-[var(--ink)] font-semibold flex items-center gap-2">
                            <i class="fas fa-desktop text-sky-500 w-4"></i> UI / UX & Responsif
                        </span>
                        <span class="text-xs font-mono font-bold text-[var(--blue)] bg-blue-500/10 px-2.5 py-0.5 rounded">20%</span>
                    </div>
                    <div class="flex justify-between items-center py-1.5">
                        <span class="text-[var(--ink)] font-semibold flex items-center gap-2">
                            <i class="fas fa-check-double text-purple-500 w-4"></i> Best Practices & Standar
                        </span>
                        <span class="text-xs font-mono font-bold text-[var(--blue)] bg-blue-500/10 px-2.5 py-0.5 rounded">15%</span>
                    </div>
                </div>
            </article>

            <!-- Hosting Info Panel -->
            <article class="cyber-card p-6 bg-white border border-[var(--border)] rounded-2xl shadow-sm">
                <span class="pill success-outline text-xs font-bold mb-3 inline-block">100% GRATIS SELAMANYA</span>
                <h3 class="text-base font-extrabold text-[var(--ink)] mb-2">Hosting Tanpa Biaya</h3>
                <p class="text-sm text-[var(--text2)] leading-relaxed">
                    Setelah lolos review, prototype otomatis online dengan URL publik resmi di <strong>talentgroup.id/p/slug</strong> tanpa biaya langganan apa pun.
                </p>
            </article>

            <!-- Guidelines Panel -->
            <article class="cyber-card p-6 bg-white border border-[var(--border)] rounded-2xl shadow-sm">
                <h3 class="text-base font-extrabold text-[var(--ink)] mb-3 flex items-center gap-2">
                    <i class="fas fa-list-check text-[var(--blue)]"></i> Ketentuan Upload
                </h3>
                <ul class="text-sm text-[var(--text2)] space-y-2.5 list-disc list-inside leading-relaxed">
                    <li>Hanya berkas website statis berbasis HTML, CSS, JavaScript, dan aset gambar.</li>
                    <li>Bebas dari skrip berbahaya, exploit, crypto-miner, atau tindakan phishing.</li>
                    <li>Jika belum lolos (skor di bawah 75), AI menyediakan diagnosa dan saran lengkap agar bisa diunggah ulang kapan saja.</li>
                </ul>
            </article>
        </div>

        <!-- PROGRESS & LOADING OVERLAY (Hidden by default) -->
        <div id="loading-overlay" class="fixed inset-0 bg-slate-900/70 backdrop-blur-md z-50 flex items-center justify-center p-4 hidden">
            <div class="max-w-lg w-full bg-white border border-[var(--border)] rounded-2xl p-8 sm:p-10 text-center shadow-2xl relative">
                <div class="w-20 h-20 mx-auto rounded-2xl bg-[var(--blue-light)] text-[var(--blue)] flex items-center justify-center text-3xl mb-5 border border-[#bfdbfe] animate-pulse">
                    <i class="fas fa-brain"></i>
                </div>

                <h3 class="text-xl font-black text-[var(--ink)] mb-2" id="loading-title">AI Agent Sedang Memindai Kode...</h3>
                <p class="text-sm text-[var(--text2)] mb-8 leading-relaxed" id="loading-subtitle">Memeriksa struktur kerapihan, kecepatan performa, UI/UX, dan keamanan prototype Anda secara menyeluruh.</p>

                <div class="space-y-4 text-left">
                    <div class="flex items-center gap-3.5 text-sm" id="step-1">
                        <div class="w-8 h-8 rounded-full bg-[var(--blue-light)] text-[var(--blue)] flex items-center justify-center font-bold text-xs step-icon">
                            <i class="fas fa-spinner fa-spin"></i>
                        </div>
                        <span class="text-[var(--ink)] font-bold">1. Ekstraksi berkas & validasi integritas struktur</span>
                    </div>
                    <div class="flex items-center gap-3.5 text-sm" id="step-2">
                        <div class="w-8 h-8 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center font-bold text-xs step-icon">
                            2
                        </div>
                        <span class="text-slate-400 font-medium">2. Membaca & parsing kode HTML, CSS, dan JavaScript</span>
                    </div>
                    <div class="flex items-center gap-3.5 text-sm" id="step-3">
                        <div class="w-8 h-8 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center font-bold text-xs step-icon">
                            3
                        </div>
                        <span class="text-slate-400 font-medium">3. AI Agent menganalisa kerapihan, kecepatan & keamanan</span>
                    </div>
                    <div class="flex items-center gap-3.5 text-sm" id="step-4">
                        <div class="w-8 h-8 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center font-bold text-xs step-icon">
                            4
                        </div>
                        <span class="text-slate-400 font-medium">4. Mengkalkulasi skor & menyiapkan slot hosting</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- ANALYSIS REPORT & CLAIM HOSTING SECTION (Shown after analysis) -->
        <div id="report-section" class="lg:col-span-12 hidden space-y-8">
            
            <!-- Verdict Banner -->
            <div id="verdict-banner" class="cyber-card p-6 sm:p-9 bg-white border border-[var(--border)] shadow-sm rounded-2xl">
                <div class="flex flex-col md:flex-row items-center gap-8 justify-between">
                    <div class="flex flex-col sm:flex-row items-center sm:items-start gap-8 text-center sm:text-left">
                        
                        <!-- Score Ring -->
                        <div class="relative w-36 h-36 flex-shrink-0">
                            <svg class="w-36 h-36 transform -rotate-90" viewBox="0 0 100 100">
                                <circle cx="50" cy="50" r="40" stroke="#e2e8f0" stroke-width="8" fill="transparent"/>
                                <circle id="score-circle" cx="50" cy="50" r="40" stroke="currentColor" stroke-width="8" fill="transparent"
                                    stroke-dasharray="251.2" stroke-dashoffset="251.2" class="text-[var(--blue)] transition-all duration-1000 ease-out"/>
                            </svg>
                            <div class="absolute inset-0 flex flex-col items-center justify-center">
                                <span id="score-text" class="text-4xl sm:text-5xl font-black text-[var(--ink)] font-mono leading-none">0</span>
                                <span class="text-xs uppercase font-bold text-[var(--muted)] mt-1.5 tracking-wider">dari 100</span>
                            </div>
                        </div>

                        <div>
                            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-sm font-bold mb-3 shadow-sm" id="verdict-badge"></div>
                            <h2 class="text-2xl sm:text-3xl font-black text-[var(--ink)] tracking-tight" id="verdict-title">
                                Hasil Review AI Agent
                            </h2>
                            <p class="text-base sm:text-lg text-[var(--text2)] mt-2 max-w-2xl leading-relaxed font-medium" id="verdict-summary"></p>
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        <button type="button" onclick="resetToUpload()" class="btn btn-outline text-sm font-bold py-3 px-5 shadow-sm inline-flex items-center gap-2">
                            <i class="fas fa-redo-alt text-base"></i> Upload Ulang / Berkas Baru
                        </button>
                    </div>
                </div>
            </div>

            <!-- 5-ASPECT OVERVIEW INDICATORS DASHBOARD -->
            <div class="cyber-card p-6 sm:p-8 bg-white border border-[var(--border)] shadow-sm rounded-2xl">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-[var(--border)] pb-4 mb-6">
                    <div>
                        <h3 class="text-lg sm:text-xl font-black text-[var(--ink)] flex items-center gap-2.5">
                            <i class="fas fa-chart-pie text-[var(--blue)] text-xl"></i> Ringkasan Indikator Scan AI
                        </h3>
                        <p class="text-xs sm:text-sm text-[var(--muted)] mt-1 font-mono">Hasil audit komprehensif dari 5 indikator utama kualitas kode</p>
                    </div>
                    <span class="pill blue-soft text-xs font-mono font-bold self-start sm:self-auto py-1 px-3">
                        Standar Kelulusan: Skor &ge; 75
                    </span>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4" id="overview-metrics-bars"></div>
            </div>

            <!-- CLAIM FREE HOSTING FORM (If Approved) -->
            <div id="claim-hosting-card" class="cyber-card p-6 sm:p-9 bg-white border-2 border-emerald-500/50 shadow-md rounded-2xl hidden">
                <div class="flex items-center gap-2 text-xs sm:text-sm font-extrabold uppercase tracking-wider text-emerald-600 mb-2">
                    <i class="fas fa-rocket text-base"></i> Lolos Uji Kelayakan Hosting 100% Gratis
                </div>
                <h3 class="text-2xl sm:text-3xl font-black text-[var(--ink)] mb-2">
                    Aktifkan Hosting Gratis Sekarang!
                </h3>
                <p class="text-sm sm:text-base text-[var(--text2)] max-w-2xl mb-6 leading-relaxed">
                    Kode Anda memenuhi standar mutu dan siap dipublikasikan. Tentukan <strong>URL Slug</strong> unik agar prototype Anda dapat dibuka langsung oleh siapa saja di seluruh dunia.
                </p>

                <form id="deploy-form" class="space-y-5">
                    <input type="hidden" id="deploy_temp_token" name="temp_token">
                    <input type="hidden" id="deploy_project_name" name="project_name">

                    <div>
                        <label class="block text-xs sm:text-sm font-extrabold uppercase tracking-wider text-[var(--ink)] mb-2">
                            Alamat URL Prototype Anda
                        </label>
                        <div class="flex items-center">
                            <span class="px-4 py-3.5 bg-[var(--bg3)] border border-r-0 border-[var(--border)] rounded-l-xl text-[var(--muted)] text-sm font-mono font-bold select-none">
                                {{ url('/p') }}/
                            </span>
                            <input type="text" id="deploy_slug" name="slug" required
                                placeholder="nama-prototype-anda"
                                class="flex-1 py-3.5 px-4 bg-white border border-[var(--border)] text-[var(--ink)] text-sm font-mono font-bold focus:border-[var(--blue)] focus:outline-none transition">
                            <button type="button" onclick="checkCustomSlug()"
                                class="px-5 py-3.5 bg-[var(--blue-light)] border border-l-0 border-[var(--border)] rounded-r-xl text-sm font-bold text-[var(--blue)] hover:bg-[var(--blue)] hover:text-white transition flex items-center gap-1.5">
                                <i class="fas fa-check-circle"></i> Cek URL
                            </button>
                        </div>
                        <p id="slug-feedback" class="text-xs sm:text-sm mt-2 font-mono font-medium"></p>
                    </div>

                    <button type="submit" id="btn-deploy-now" class="btn btn-gradient text-sm sm:text-base w-full py-4 font-bold shadow-lg flex items-center justify-center gap-2">
                        <i class="fas fa-globe text-lg"></i> Publikasikan Prototype ke Server Live Sekarang
                    </button>
                </form>
            </div>

            <!-- HOSTED SUCCESS BANNER -->
            <div id="deployment-success-banner" class="cyber-card p-8 sm:p-10 bg-emerald-50 border-2 border-emerald-500 text-center shadow-lg rounded-2xl hidden">
                <div class="w-16 h-16 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center mx-auto text-3xl mb-4 border border-emerald-300">
                    <i class="fas fa-check-double"></i>
                </div>
                <h3 class="text-2xl sm:text-3xl font-black text-emerald-900 mb-2">Prototype Berhasil Online! 🎉</h3>
                <p class="text-sm sm:text-base text-emerald-700 max-w-lg mx-auto mb-6 leading-relaxed">
                    Website statis Anda sekarang aktif dan dapat diakses langsung secara gratis oleh siapa saja di internet.
                </p>

                <div class="max-w-xl mx-auto flex items-center gap-2 p-2.5 bg-white border border-emerald-300 rounded-xl mb-6 shadow-sm">
                    <input type="text" id="live-url-input" readonly
                        class="flex-1 bg-transparent border-0 text-[var(--blue)] font-mono text-sm px-3 focus:outline-none select-all font-bold">
                    <button type="button" onclick="copyLiveUrl()"
                        class="btn btn-small btn-outline text-xs sm:text-sm font-bold py-2 px-3">
                        <i class="fas fa-copy"></i> Salin
                    </button>
                    <a href="#" id="live-open-link" target="_blank"
                        class="btn btn-small btn-gradient text-xs sm:text-sm font-bold py-2 px-4">
                        <i class="fas fa-external-link-alt"></i> Buka Website
                    </a>
                </div>

                <div class="flex justify-center gap-3">
                    <a href="{{ route('user.prototypes.index') }}" class="btn btn-outline text-sm font-bold py-2.5 px-5">
                        Lihat Daftar Prototipe Saya
                    </a>
                </div>
            </div>

            <!-- CATEGORY AUDIT DETAILS -->
            <div class="space-y-6">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-[var(--border)] pb-4">
                    <div>
                        <h3 class="text-lg sm:text-xl font-black text-[var(--ink)] flex items-center gap-2.5">
                            <i class="fas fa-clipboard-check text-[var(--blue)] text-xl"></i> Rincian & Temuan Audit Aspek AI
                        </h3>
                        <p class="text-xs sm:text-sm text-[var(--muted)] font-mono mt-1">Analisa mendalam indikator kode beserta saran solusi konkret</p>
                    </div>
                    <span class="text-xs sm:text-sm text-[var(--muted)] font-mono self-start sm:self-auto" id="ai-provider-badge">AI Engine: Google Gemini</span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6" id="categories-container"></div>
        </div>
    </div>
</div>

<script>
    let currentTempToken = null;

    function handleZipSelected(input) {
        if (input.files && input.files[0]) {
            const file = input.files[0];
            const sizeMb = (file.size / (1024 * 1024)).toFixed(2);
            document.getElementById('zip-drop-text').innerHTML = `<span class="text-emerald-700 font-bold"><i class="fas fa-check-circle"></i> ${file.name}</span>`;
            document.getElementById('zip-file-info').innerHTML = `Ukuran: <strong>${sizeMb} MB</strong>. Klik tombol review untuk memulai audit AI.`;

            const nameInput = document.getElementById('project_name');
            if (!nameInput.value.trim()) {
                const cleanName = file.name.replace(/\.zip$/i, '').replace(/[-_]/g, ' ');
                nameInput.value = cleanName.charAt(0).toUpperCase() + cleanName.slice(1);
            }
        }
    }

    const dropzone = document.getElementById('zip-dropzone');
    if (dropzone) {
        ['dragenter', 'dragover'].forEach(eventName => {
            dropzone.addEventListener(eventName, (e) => {
                e.preventDefault();
                dropzone.classList.add('border-[var(--blue)]', 'bg-[var(--blue-light)]/40');
            }, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropzone.addEventListener(eventName, (e) => {
                e.preventDefault();
                dropzone.classList.remove('border-[var(--blue)]', 'bg-[var(--blue-light)]/40');
            }, false);
        });

        dropzone.addEventListener('drop', (e) => {
            const dt = e.dataTransfer;
            const files = dt.files;
            if (files.length) {
                document.getElementById('zip_file').files = files;
                handleZipSelected(document.getElementById('zip_file'));
            }
        });
    }

    document.getElementById('prototype-upload-form').addEventListener('submit', async function(e) {
        e.preventDefault();

        const formData = new FormData(this);

        const zipInput = document.getElementById('zip_file');
        if (!zipInput.files || !zipInput.files[0]) {
            alert('Silakan pilih berkas file .ZIP terlebih dahulu.');
            return;
        }

        showLoadingOverlay();

        try {
            const response = await fetch("{{ route('user.prototypes.analyze') }}", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Accept": "application/json"
                },
                body: formData
            });

            const data = await response.json();

            if (!response.ok || !data.success) {
                hideLoadingOverlay();
                alert(data.message || 'Terjadi kesalahan saat memproses file prototype.');
                return;
            }

            updateStep(4, true);
            setTimeout(() => {
                hideLoadingOverlay();
                renderReport(data);
            }, 700);

        } catch (error) {
            hideLoadingOverlay();
            console.error(error);
            alert('Terjadi kesalahan jaringan atau server saat mengunggah file.');
        }
    });

    function showLoadingOverlay() {
        document.getElementById('loading-overlay').classList.remove('hidden');
        document.getElementById('step-nav-2').classList.add('active');

        [1, 2, 3, 4].forEach(step => {
            const el = document.getElementById(`step-${step}`);
            const icon = el.querySelector('.step-icon');
            el.querySelector('span').className = 'text-slate-400';
            icon.className = 'w-6 h-6 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center font-bold text-[10px] step-icon';
            icon.innerHTML = step;
        });

        updateStep(1, false);
        setTimeout(() => updateStep(1, true), 1000);
        setTimeout(() => updateStep(2, false), 1100);
        setTimeout(() => updateStep(2, true), 2200);
        setTimeout(() => updateStep(3, false), 2300);
    }

    function updateStep(stepNumber, isDone) {
        const el = document.getElementById(`step-${stepNumber}`);
        if (!el) return;
        const icon = el.querySelector('.step-icon');
        const text = el.querySelector('span');

        if (isDone) {
            icon.className = 'w-6 h-6 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold text-[10px] step-icon';
            icon.innerHTML = '<i class="fas fa-check"></i>';
            text.className = 'text-[var(--ink)] font-bold';
        } else {
            icon.className = 'w-6 h-6 rounded-full bg-[var(--blue-light)] text-[var(--blue)] flex items-center justify-center font-bold text-[10px] step-icon';
            icon.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
            text.className = 'text-[var(--blue)] font-bold';
        }
    }

    function hideLoadingOverlay() {
        document.getElementById('loading-overlay').classList.add('hidden');
    }

    function renderReport(data) {
        currentTempToken = data.temp_token;

        document.getElementById('upload-section').classList.add('hidden');
        const uploadSidebar = document.getElementById('upload-sidebar');
        if (uploadSidebar) uploadSidebar.classList.add('hidden');
        document.getElementById('report-section').classList.remove('hidden');

        const score = data.score;
        const isApproved = data.is_approved;
        const minScore = data.min_passing_score;
        const report = data.report || {};

        const circle = document.getElementById('score-circle');
        const circumference = 2 * Math.PI * 40;
        const offset = circumference - (score / 100) * circumference;
        circle.style.strokeDashoffset = offset;

        if (score >= 80) {
            circle.setAttribute('class', 'text-emerald-500 transition-all duration-1000 ease-out');
        } else if (score >= minScore) {
            circle.setAttribute('class', 'text-[var(--blue)] transition-all duration-1000 ease-out');
        } else {
            circle.setAttribute('class', 'text-amber-500 transition-all duration-1000 ease-out');
        }

        animateCount('score-text', 0, score, 1000);

        const badge = document.getElementById('verdict-badge');
        const title = document.getElementById('verdict-title');
        const summary = document.getElementById('verdict-summary');

        if (isApproved) {
            document.getElementById('step-nav-3').classList.add('active');
            badge.className = "pill success-outline text-sm sm:text-base px-4 py-1.5 font-bold inline-flex items-center gap-2";
            badge.innerHTML = '<i class="fas fa-check-circle text-emerald-500"></i> Lolos review (Skor min. ' + minScore + ')';
            title.innerHTML = 'Prototype Layak Dipublikasikan! 🎉';
            summary.innerHTML = report.verdict_summary || 'Prototype kode Anda berada pada tingkat kualitas yang sangat baik! Struktur rapi, aman, dan siap untuk diaktifkan ke hosting gratis.';
            document.getElementById('claim-hosting-card').classList.remove('hidden');
        } else {
            badge.className = "pill pending text-sm sm:text-base px-4 py-1.5 font-bold inline-flex items-center gap-2";
            badge.innerHTML = `<i class="fas fa-exclamation-triangle text-amber-500"></i> Belum Lolos (Skor min. ${minScore})`;
            title.innerHTML = 'Perlu Sedikit Perbaikan Kode';
            summary.innerHTML = report.verdict_summary || 'Prototype memerlukan sedikit optimasi sebelum memenuhi kriteria hosting gratis. Periksa rekomendasi di bawah untuk meningkatkan skor Anda.';
            document.getElementById('claim-hosting-card').classList.add('hidden');
        }

        document.getElementById('ai-provider-badge').innerText = `AI Reviewer: ${data.provider}`;

        document.getElementById('deploy_temp_token').value = data.temp_token;
        document.getElementById('deploy_project_name').value = data.project_name;
        document.getElementById('deploy_slug').value = data.suggested_slug;
        checkCustomSlug();

        renderOverviewBars(report.categories || {});
        renderCategoryCards(report.categories || {});
    }

    function renderOverviewBars(categories) {
        const container = document.getElementById('overview-metrics-bars');
        if (!container) return;
        container.innerHTML = '';

        const meta = {
            code_errors: { name: 'Kerapihan Kode', icon: 'fa-code', color: 'indigo' },
            performance: { name: 'Kecepatan & Performa', icon: 'fa-bolt', color: 'amber' },
            security: { name: 'Keamanan Skrip', icon: 'fa-shield-alt', color: 'emerald' },
            seo: { name: 'UI / UX & Responsif', icon: 'fa-desktop', color: 'sky' },
            best_practices: { name: 'Best Practices', icon: 'fa-check-double', color: 'purple' }
        };

        const keys = ['code_errors', 'performance', 'security', 'seo', 'best_practices'];
        keys.forEach(key => {
            const details = categories[key] || { score: 85 };
            const info = meta[key];
            const score = details.score ?? 80;
            const barColor = score >= 80 ? 'bg-emerald-500' : (score >= 75 ? 'bg-blue-500' : 'bg-amber-500');

            const item = document.createElement('div');
            item.className = "p-4 rounded-xl border border-[var(--border)] bg-[var(--bg3)] flex flex-col justify-between";
            item.innerHTML = `
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs sm:text-sm font-bold text-[var(--ink)] flex items-center gap-1.5">
                            <i class="fas ${info.icon} text-${info.color}-500"></i> ${info.name}
                        </span>
                        <span class="text-xs sm:text-sm font-mono font-black ${score >= 75 ? 'text-emerald-500' : 'text-amber-500'}">
                            ${score}%
                        </span>
                    </div>
                    <div class="w-full h-2.5 rounded-full bg-slate-200 dark:bg-slate-700 overflow-hidden">
                        <div class="h-full rounded-full ${barColor} transition-all duration-1000" style="width: ${score}%"></div>
                    </div>
                </div>
                <div class="mt-2.5 text-xs font-mono font-bold text-[var(--muted)]">
                    ${score >= 80 ? '<span class="text-emerald-500"><i class="fas fa-check-circle"></i> Sangat Baik</span>' : (score >= 75 ? '<span class="text-blue-500"><i class="fas fa-check"></i> Memenuhi Syarat</span>' : '<span class="text-amber-500"><i class="fas fa-exclamation-circle"></i> Perlu Perbaikan</span>')}
                </div>
            `;
            container.appendChild(item);
        });
    }

    function renderCategoryCards(categories) {
        const container = document.getElementById('categories-container');
        container.innerHTML = '';

        const meta = {
            code_errors: {
                name: 'Kerapihan & Kualitas Kode',
                badge: 'Syntax & Structure',
                icon: 'fa-code',
                color: 'text-indigo-500',
                bg: 'bg-indigo-500/10'
            },
            performance: {
                name: 'Kecepatan & Performa Website',
                badge: 'Speed & Loading',
                icon: 'fa-bolt',
                color: 'text-amber-500',
                bg: 'bg-amber-500/10'
            },
            security: {
                name: 'Keamanan Skrip & Anti-Malware',
                badge: 'Security & Safety',
                icon: 'fa-shield-alt',
                color: 'text-emerald-500',
                bg: 'bg-emerald-500/10'
            },
            seo: {
                name: 'UI / UX, Tampilan & Responsif',
                badge: 'UI/UX & Accessibility',
                icon: 'fa-desktop',
                color: 'text-sky-500',
                bg: 'bg-sky-500/10'
            },
            best_practices: {
                name: 'Best Practices & Standar Modern',
                badge: 'Standards & Modern HTML',
                icon: 'fa-check-double',
                color: 'text-purple-500',
                bg: 'bg-purple-500/10'
            }
        };

        for (const [key, details] of Object.entries(categories)) {
            const info = meta[key] || { name: key.toUpperCase(), badge: 'Audit', icon: 'fa-code', color: 'text-[var(--blue)]', bg: 'bg-blue-500/10' };
            const cardScore = details.score ?? 80;
            const issues = details.issues || [];
            const recs = details.recommendations || [];

            const card = document.createElement('div');
            card.className = "cyber-card p-6 sm:p-7 bg-white border border-[var(--border)] shadow-sm rounded-2xl flex flex-col justify-between";

            let issuesHtml = '';
            if (issues.length > 0) {
                issuesHtml += `
                    <div class="mb-5">
                        <span class="text-xs sm:text-sm font-extrabold uppercase tracking-wider text-amber-500 flex items-center gap-2 mb-2.5">
                            <i class="fas fa-search-plus text-base"></i> Temuan Scan AI:
                        </span>
                        <ul class="space-y-2">`;
                issues.forEach(iss => {
                    issuesHtml += `
                        <li class="text-sm sm:text-base text-[var(--ink)] font-medium flex items-start gap-2.5 leading-relaxed bg-[var(--bg3)] p-3 rounded-xl border border-[var(--border)]">
                            <i class="fas fa-exclamation-triangle text-amber-500 text-sm mt-1 flex-shrink-0"></i>
                            <span>${iss}</span>
                        </li>`;
                });
                issuesHtml += `</ul></div>`;
            } else {
                issuesHtml += `
                    <div class="p-3.5 rounded-xl bg-emerald-500/10 border border-emerald-500/30 text-sm sm:text-base text-emerald-500 font-semibold flex items-center gap-2.5 mb-5">
                        <i class="fas fa-check-circle text-lg"></i>
                        <span>Pemeriksaan bersih &mdash; tidak ditemukan kendala pada aspek ini.</span>
                    </div>`;
            }

            let recsHtml = '';
            if (recs.length > 0) {
                recsHtml += `
                    <div>
                        <span class="text-xs sm:text-sm font-extrabold uppercase tracking-wider text-[var(--blue)] flex items-center gap-2 mb-2.5">
                            <i class="fas fa-lightbulb text-base"></i> Saran Solusi & Peningkatan:
                        </span>
                        <ul class="space-y-2">`;
                recs.forEach(rec => {
                    recsHtml += `
                        <li class="text-sm sm:text-base text-[var(--text2)] flex items-start gap-2.5 leading-relaxed bg-blue-500/5 p-3 rounded-xl border border-blue-500/10">
                            <i class="fas fa-arrow-right text-[var(--blue)] text-xs mt-1.5 flex-shrink-0"></i>
                            <span>${rec}</span>
                        </li>`;
                });
                recsHtml += `</ul></div>`;
            }

            card.innerHTML = `
                <div>
                    <div class="flex items-center justify-between mb-4 border-b border-[var(--border)] pb-3">
                        <div class="flex items-center gap-3">
                            <span class="w-10 h-10 rounded-xl ${info.bg} flex items-center justify-center text-lg flex-shrink-0">
                                <i class="fas ${info.icon} ${info.color}"></i>
                            </span>
                            <div>
                                <h4 class="text-base sm:text-lg font-black text-[var(--ink)]">${info.name}</h4>
                                <span class="text-xs font-mono font-bold text-[var(--muted)] uppercase tracking-wider">${info.badge}</span>
                            </div>
                        </div>
                        <span class="pill ${cardScore >= 75 ? 'blue-soft' : 'pending'} font-mono text-sm sm:text-base font-black px-3.5 py-1">
                            ${cardScore} / 100
                        </span>
                    </div>
                    ${issuesHtml}
                    ${recsHtml}
                </div>
            `;
            container.appendChild(card);
        }
    }

    async function checkCustomSlug() {
        const slugInput = document.getElementById('deploy_slug');
        const feedback = document.getElementById('slug-feedback');
        const raw = slugInput.value.trim();

        if (!raw) {
            feedback.innerHTML = '<span class="text-[var(--muted)]">Masukkan slug URL.</span>';
            return;
        }

        feedback.innerHTML = '<span class="text-[var(--muted)]"><i class="fas fa-spinner fa-spin"></i> Memeriksa ketersediaan...</span>';

        try {
            const res = await fetch(`{{ route('user.prototypes.check-slug') }}?slug=${encodeURIComponent(raw)}`);
            const data = await res.json();
            slugInput.value = data.slug;

            if (data.available) {
                feedback.innerHTML = `<span class="text-emerald-700 dark:text-emerald-400 font-bold"><i class="fas fa-check"></i> URL Tersedia: <u>{{ url('/p') }}/${data.slug}</u></span>`;
            } else {
                feedback.innerHTML = `<span class="text-rose-600 font-bold"><i class="fas fa-times"></i> ${data.message}</span>`;
            }
        } catch (e) {
            feedback.innerHTML = '<span class="text-slate-400">Gagal mengecek URL.</span>';
        }
    }

    document.getElementById('deploy-form').addEventListener('submit', async function(e) {
        e.preventDefault();

        const btn = document.getElementById('btn-deploy-now');
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mempublikasikan ke Server...';

        const payload = {
            temp_token: document.getElementById('deploy_temp_token').value,
            project_name: document.getElementById('deploy_project_name').value,
            slug: document.getElementById('deploy_slug').value,
            _token: "{{ csrf_token() }}"
        };

        try {
            const res = await fetch("{{ route('user.prototypes.deploy') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify(payload)
            });

            const data = await res.json();
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-globe mr-1.5"></i> Publikasikan Prototype ke Server Live';

            if (!res.ok || !data.success) {
                alert(data.message || 'Gagal mempublikasikan prototype.');
                return;
            }

            document.getElementById('step-nav-4').classList.add('active');
            document.getElementById('claim-hosting-card').classList.add('hidden');
            const successBanner = document.getElementById('deployment-success-banner');
            successBanner.classList.remove('hidden');

            document.getElementById('live-url-input').value = data.url;
            document.getElementById('live-open-link').href = data.url;

            successBanner.scrollIntoView({ behavior: 'smooth' });

        } catch (err) {
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-globe mr-1.5"></i> Publikasikan Prototype ke Server Live';
            console.error(err);
            alert('Terjadi kesalahan jaringan.');
        }
    });

    function copyLiveUrl() {
        const input = document.getElementById('live-url-input');
        input.select();
        navigator.clipboard.writeText(input.value);
        alert('Tautan URL Prototype berhasil disalin!');
    }

    function resetToUpload() {
        document.getElementById('report-section').classList.add('hidden');
        document.getElementById('upload-section').classList.remove('hidden');
        const uploadSidebar = document.getElementById('upload-sidebar');
        if (uploadSidebar) uploadSidebar.classList.remove('hidden');
        document.getElementById('step-nav-2').classList.remove('active');
        document.getElementById('step-nav-3').classList.remove('active');
        document.getElementById('step-nav-4').classList.remove('active');
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    function animateCount(id, start, end, duration) {
        const obj = document.getElementById(id);
        const range = end - start;
        let current = start;
        const increment = end > start ? 1 : -1;
        const stepTime = Math.abs(Math.floor(duration / (range || 1)));
        const timer = setInterval(() => {
            current += increment;
            obj.innerText = current;
            if (current === end) {
                clearInterval(timer);
            }
        }, stepTime);
    }
</script>
@endsection
