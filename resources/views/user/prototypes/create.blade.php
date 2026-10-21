@extends('layouts.app')

@section('title', 'Upload Prototype & Free Hosting | Flow Academy')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-8">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <div class="flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-[var(--cyan)] mb-1">
                <i class="fas fa-brain"></i> AI Agent Code Auditor & Subdomain Host
            </div>
            <h1 class="text-2xl md:text-3xl font-extrabold text-white tracking-tight">
                Upload Prototype Website <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-cyan-400">& Gratis Hosting</span>
            </h1>
            <p class="text-xs md:text-sm text-slate-400 mt-1 max-w-2xl leading-relaxed">
                Unggah karya statis website Anda (HTML, CSS, JS). AI Agent akan mengevaluasi kualitas kode, performa, SEO, dan keamanan. Jika lolos skor minimal (<span class="text-cyan-400 font-bold font-mono">{{ $settings->min_passing_score }}</span>), Anda berhak mendapatkan hosting gratis selamanya dengan URL kustom!
            </p>
        </div>
        <a href="{{ route('user.prototypes.index') }}" class="self-start md:self-auto px-4 py-2 rounded-xl bg-slate-800/80 hover:bg-slate-750 text-slate-200 text-xs font-bold border border-slate-700/80 inline-flex items-center gap-2 transition">
            <i class="fas fa-layer-group text-purple-400"></i> Prototipe Saya
        </a>
    </div>

    <!-- Main Container -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        <!-- Form Column -->
        <div class="lg:col-span-12" id="upload-section">
            <div class="rounded-2xl bg-[#0c1220] border border-[#1e2d40] p-6 md:p-8 shadow-2xl relative overflow-hidden">
                <div class="absolute -top-24 -right-24 w-60 h-60 bg-purple-600/10 rounded-full blur-3xl pointer-events-none"></div>
                <div class="absolute -bottom-24 -left-24 w-60 h-60 bg-cyan-600/10 rounded-full blur-3xl pointer-events-none"></div>

                <!-- Form -->
                <form id="prototype-upload-form" enctype="multipart/form-data">
                    @csrf
                    <!-- Project Name -->
                    <div class="mb-6">
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-2">
                            Nama Project / Prototype <span class="text-red-400">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400 text-sm">
                                <i class="fas fa-laptop-code"></i>
                            </span>
                            <input type="text" name="project_name" id="project_name" required
                                placeholder="Contoh: Portfolio Modern 2026, Landing Page Flow, Toko Online Statis"
                                class="w-full pl-10 pr-4 py-3 bg-[#05080f] border border-[#1e2d40] rounded-xl text-white text-sm focus:border-cyan-400 focus:outline-none transition">
                        </div>
                    </div>

                    <!-- Mode Tabs -->
                    <div class="mb-6">
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-2">
                            Pilih Metode Unggah Prototype
                        </label>
                        <div class="grid grid-cols-2 gap-3 p-1.5 bg-[#05080f] border border-[#1e2d40] rounded-xl">
                            <button type="button" id="tab-zip" onclick="switchUploadMode('zip_archive')"
                                class="mode-tab-btn py-2.5 px-4 rounded-lg text-xs font-bold flex items-center justify-center gap-2 transition bg-purple-600 text-white shadow-lg">
                                <i class="fas fa-file-archive"></i> Mode A: Upload ZIP (.zip)
                            </button>
                            <button type="button" id="tab-manual" onclick="switchUploadMode('manual_files')"
                                class="mode-tab-btn py-2.5 px-4 rounded-lg text-xs font-bold flex items-center justify-center gap-2 transition text-slate-400 hover:text-white">
                                <i class="fas fa-file-code"></i> Mode B: 3 File Terpisah
                            </button>
                        </div>
                        <input type="hidden" name="upload_type" id="upload_type" value="zip_archive">
                    </div>

                    <!-- MODE A: ZIP ARCHIVE -->
                    <div id="section-zip" class="space-y-4">
                        <div class="border-2 border-dashed border-slate-700 hover:border-cyan-400/70 rounded-2xl p-8 text-center bg-[#05080f]/60 transition-all cursor-pointer relative group"
                            id="zip-dropzone" onclick="document.getElementById('zip_file').click()">
                            <input type="file" name="zip_file" id="zip_file" accept=".zip" class="hidden" onchange="handleZipSelected(this)">
                            
                            <div class="w-16 h-16 rounded-2xl bg-gradient-to-tr from-purple-500/20 to-cyan-500/20 text-cyan-400 flex items-center justify-center mx-auto text-2xl mb-4 group-hover:scale-110 transition duration-300 border border-cyan-500/30">
                                <i class="fas fa-cloud-upload-alt"></i>
                            </div>
                            
                            <h3 class="text-sm md:text-base font-bold text-white mb-1" id="zip-drop-text">
                                Tarik & Lepas file .ZIP ke sini, atau <span class="text-cyan-400 underline">klik untuk memilih</span>
                            </h3>
                            <p class="text-xs text-slate-400 max-w-md mx-auto mb-4" id="zip-file-info">
                                Arsipkan folder proyek Anda ke format <strong>.zip</strong> (Maksimal 40MB). Pastikan terdapat file <code>index.html</code> di dalamnya.
                            </p>

                            <!-- Feature badges -->
                            <div class="flex flex-wrap items-center justify-center gap-2 pt-2 text-[10px] text-slate-400">
                                <span class="px-2.5 py-1 rounded-full bg-slate-800/80 border border-slate-700/60 inline-flex items-center gap-1.5 text-emerald-400">
                                    <i class="fas fa-shield-alt"></i> Anti-ZipSlip Safe
                                </span>
                                <span class="px-2.5 py-1 rounded-full bg-slate-800/80 border border-slate-700/60 inline-flex items-center gap-1.5 text-cyan-300">
                                    <i class="fas fa-folder-tree"></i> Auto-Flatten Root Folder
                                </span>
                                <span class="px-2.5 py-1 rounded-full bg-slate-800/80 border border-slate-700/60 inline-flex items-center gap-1.5 text-purple-300">
                                    <i class="fas fa-broom"></i> Auto-Sanitize Script Berbahaya
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- MODE B: MANUAL 3 FILES -->
                    <div id="section-manual" class="space-y-4 hidden">
                        <div class="p-4 rounded-xl bg-purple-950/20 border border-purple-800/30 text-xs text-purple-300 mb-2 flex items-start gap-2.5">
                            <i class="fas fa-info-circle text-purple-400 mt-0.5 text-sm"></i>
                            <div>
                                <strong>Fleksibel:</strong> Cukup unggah file <code>.html</code> sebagai kerangka utama. File CSS dan JS bersifat opsional (sistem otomatis menghubungkan tag <code>&lt;link&gt;</code> dan <code>&lt;script&gt;</code> jika Anda menyediakannya).
                            </div>
                        </div>

                        <!-- HTML Input -->
                        <div class="p-4 rounded-xl bg-[#05080f] border border-[#1e2d40] hover:border-cyan-500/50 transition">
                            <div class="flex items-center justify-between mb-2">
                                <label class="text-xs font-bold text-white flex items-center gap-2">
                                    <i class="fab fa-html5 text-orange-500 text-base"></i> File HTML Utama (.html) <span class="text-red-400">*</span>
                                </label>
                                <span class="text-[10px] text-emerald-400 font-bold uppercase tracking-wider bg-emerald-950/40 px-2 py-0.5 rounded border border-emerald-800/40">Wajib</span>
                            </div>
                            <input type="file" name="html_file" id="html_file" accept=".html,.htm"
                                class="w-full text-xs text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-orange-500/20 file:text-orange-300 hover:file:bg-orange-500/30 file:cursor-pointer cursor-pointer">
                        </div>

                        <!-- CSS Input -->
                        <div class="p-4 rounded-xl bg-[#05080f] border border-[#1e2d40] hover:border-cyan-500/50 transition">
                            <div class="flex items-center justify-between mb-2">
                                <label class="text-xs font-bold text-white flex items-center gap-2">
                                    <i class="fab fa-css3-alt text-blue-400 text-base"></i> File Stylesheet CSS (.css)
                                </label>
                                <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider bg-slate-800 px-2 py-0.5 rounded">Opsional</span>
                            </div>
                            <input type="file" name="css_file" id="css_file" accept=".css"
                                class="w-full text-xs text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-blue-500/20 file:text-blue-300 hover:file:bg-blue-500/30 file:cursor-pointer cursor-pointer">
                        </div>

                        <!-- JS Input -->
                        <div class="p-4 rounded-xl bg-[#05080f] border border-[#1e2d40] hover:border-cyan-500/50 transition">
                            <div class="flex items-center justify-between mb-2">
                                <label class="text-xs font-bold text-white flex items-center gap-2">
                                    <i class="fab fa-js-square text-yellow-400 text-base"></i> File Script JavaScript (.js)
                                </label>
                                <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider bg-slate-800 px-2 py-0.5 rounded">Opsional</span>
                            </div>
                            <input type="file" name="js_file" id="js_file" accept=".js"
                                class="w-full text-xs text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-yellow-500/20 file:text-yellow-300 hover:file:bg-yellow-500/30 file:cursor-pointer cursor-pointer">
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="mt-8">
                        <button type="submit" id="btn-submit-analyze"
                            class="w-full py-4 px-6 rounded-xl bg-gradient-to-r from-purple-600 via-indigo-600 to-cyan-500 hover:opacity-95 text-white font-extrabold text-sm uppercase tracking-wider shadow-lg shadow-purple-600/20 flex items-center justify-center gap-2.5 transition active:scale-[0.99]">
                            <i class="fas fa-wand-magic-sparkles text-yellow-300"></i> Ekstrak & Analisa Kelayakan dengan AI Agent
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- PROGRESS & LOADING OVERLAY (Hidden by default) -->
        <div id="loading-overlay" class="fixed inset-0 bg-[#05080f]/90 backdrop-blur-md z-50 flex items-center justify-center p-4 hidden">
            <div class="max-w-md w-full bg-[#0c1220] border border-[#1e2d40] rounded-2xl p-8 text-center shadow-2xl relative">
                <!-- Glowing orb -->
                <div class="w-20 h-20 mx-auto rounded-full bg-gradient-to-tr from-purple-500 to-cyan-400 p-0.5 animate-spin mb-6">
                    <div class="w-full h-full bg-[#0c1220] rounded-full flex items-center justify-center">
                        <i class="fas fa-brain text-2xl text-cyan-400 animate-pulse"></i>
                    </div>
                </div>

                <h3 class="text-lg font-bold text-white mb-2" id="loading-title">AI Agent Sedang Menganalisa...</h3>
                <p class="text-xs text-slate-400 mb-6" id="loading-subtitle">Memeriksa struktur kode, performa, SEO, dan keamanan prototype Anda.</p>

                <!-- Steps list -->
                <div class="space-y-3 text-left">
                    <div class="flex items-center gap-3 text-xs" id="step-1">
                        <div class="w-6 h-6 rounded-full bg-purple-500/20 text-purple-400 flex items-center justify-center font-bold text-[10px] step-icon">
                            <i class="fas fa-spinner fa-spin"></i>
                        </div>
                        <span class="text-slate-300">1. Mengekstrak berkas & verifikasi keamanan</span>
                    </div>
                    <div class="flex items-center gap-3 text-xs" id="step-2">
                        <div class="w-6 h-6 rounded-full bg-slate-800 text-slate-500 flex items-center justify-center font-bold text-[10px] step-icon">
                            2
                        </div>
                        <span class="text-slate-500">2. Membaca struktur HTML, CSS, dan JS</span>
                    </div>
                    <div class="flex items-center gap-3 text-xs" id="step-3">
                        <div class="w-6 h-6 rounded-full bg-slate-800 text-slate-500 flex items-center justify-center font-bold text-[10px] step-icon">
                            3
                        </div>
                        <span class="text-slate-500">3. AI Agent mengevaluasi SEO & Performa</span>
                    </div>
                    <div class="flex items-center gap-3 text-xs" id="step-4">
                        <div class="w-6 h-6 rounded-full bg-slate-800 text-slate-500 flex items-center justify-center font-bold text-[10px] step-icon">
                            4
                        </div>
                        <span class="text-slate-500">4. Menghitung skor kelayakan hosting</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- ANALYSIS REPORT & CLAIM HOSTING SECTION (Shown after analysis) -->
        <div id="report-section" class="lg:col-span-12 hidden space-y-8">
            <!-- Verdict Banner -->
            <div id="verdict-banner" class="rounded-2xl p-6 md:p-8 border shadow-xl relative overflow-hidden">
                <div class="flex flex-col md:flex-row items-center gap-6 justify-between">
                    <div class="flex items-center gap-5">
                        <!-- Score Dial -->
                        <div class="relative w-24 h-24 flex-shrink-0">
                            <svg class="w-24 h-24 transform -rotate-90" viewBox="0 0 100 100">
                                <circle cx="50" cy="50" r="40" stroke="currentColor" stroke-width="8" fill="transparent" class="text-slate-800"/>
                                <circle id="score-circle" cx="50" cy="50" r="40" stroke="currentColor" stroke-width="8" fill="transparent"
                                    stroke-dasharray="251.2" stroke-dashoffset="251.2" class="text-cyan-400 transition-all duration-1000 ease-out"/>
                            </svg>
                            <div class="absolute inset-0 flex flex-col items-center justify-center">
                                <span id="score-text" class="text-2xl font-black text-white font-mono leading-none">0</span>
                                <span class="text-[9px] uppercase tracking-wider text-slate-400 font-bold mt-0.5">/ 100</span>
                            </div>
                        </div>

                        <div>
                            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-bold mb-2" id="verdict-badge">
                                <!-- Badge inserted via JS -->
                            </div>
                            <h2 class="text-xl md:text-2xl font-black text-white tracking-tight" id="verdict-title">
                                Hasil Pemeriksaan AI Agent
                            </h2>
                            <p class="text-xs md:text-sm text-slate-300 mt-1 max-w-xl leading-relaxed" id="verdict-summary">
                                <!-- Summary text -->
                            </p>
                        </div>
                    </div>

                    <!-- Action Shortcut -->
                    <div class="flex items-center gap-3">
                        <button type="button" onclick="resetToUpload()" class="px-4 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-200 text-xs font-bold border border-slate-700 transition">
                            <i class="fas fa-redo-alt mr-1"></i> Upload Ulang
                        </button>
                    </div>
                </div>
            </div>

            <!-- CLAIM FREE HOSTING FORM (If Approved) -->
            <div id="claim-hosting-card" class="rounded-2xl bg-[#0c1220] border-2 border-emerald-500/40 p-6 md:p-8 shadow-2xl relative overflow-hidden hidden">
                <div class="flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-emerald-400 mb-1">
                    <i class="fas fa-gift"></i> Hadiah Skor Kelayakan Terpenuhi
                </div>
                <h3 class="text-xl font-black text-white mb-2">
                    Aktifkan Hosting 100% Gratis Sekarang! 🚀
                </h3>
                <p class="text-xs text-slate-300 mb-6 leading-relaxed">
                    Kode Anda telah dinyatakan memenuhi standar. Pilih <strong>URL Slug</strong> yang Anda sukai untuk mempublikasikan website ini ke publik.
                </p>

                <form id="deploy-form" class="space-y-4">
                    <input type="hidden" id="deploy_temp_token" name="temp_token">
                    <input type="hidden" id="deploy_project_name" name="project_name">

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-2">
                            Alamat URL Prototype (Subdomain Path)
                        </label>
                        <div class="flex items-center">
                            <span class="px-4 py-3 bg-[#05080f] border border-r-0 border-[#1e2d40] rounded-l-xl text-slate-400 text-xs font-mono select-none">
                                {{ url('/p') }}/
                            </span>
                            <input type="text" id="deploy_slug" name="slug" required
                                placeholder="nama-project-anda"
                                class="flex-1 py-3 px-3 bg-[#05080f] border border-[#1e2d40] text-white text-xs font-mono focus:border-cyan-400 focus:outline-none transition">
                            <button type="button" onclick="checkCustomSlug()"
                                class="px-4 py-3 bg-slate-800 border border-l-0 border-[#1e2d40] rounded-r-xl text-xs font-bold text-cyan-400 hover:bg-slate-700 transition">
                                <i class="fas fa-check-circle"></i> Cek URL
                            </button>
                        </div>
                        <p id="slug-feedback" class="text-[11px] mt-1.5 font-mono"></p>
                    </div>

                    <button type="submit" id="btn-deploy-now"
                        class="w-full py-4 px-6 rounded-xl bg-gradient-to-r from-emerald-500 to-teal-600 hover:opacity-95 text-white font-black text-sm uppercase tracking-wider shadow-lg shadow-emerald-500/20 flex items-center justify-center gap-2 transition">
                        <i class="fas fa-rocket text-yellow-300"></i> Deploy & Publikasikan Sekarang
                    </button>
                </form>
            </div>

            <!-- HOSTED SUCCESS MODAL / BANNER (Shown After Deployment) -->
            <div id="deployment-success-banner" class="rounded-2xl bg-gradient-to-r from-emerald-950/80 to-teal-950/80 border-2 border-emerald-500 p-6 md:p-8 text-center shadow-2xl hidden">
                <div class="w-16 h-16 rounded-full bg-emerald-500/20 text-emerald-400 flex items-center justify-center mx-auto text-2xl mb-4 border border-emerald-500/40">
                    <i class="fas fa-check-double animate-bounce"></i>
                </div>
                <h3 class="text-2xl font-black text-white mb-2">Prototype Berhasil Di-hosting! 🎉</h3>
                <p class="text-xs text-slate-300 max-w-md mx-auto mb-6">
                    Website statis Anda sekarang aktif dan dapat diakses langsung oleh siapa saja di seluruh dunia.
                </p>

                <div class="max-w-xl mx-auto flex items-center gap-2 p-2 bg-[#05080f] border border-emerald-500/50 rounded-xl mb-6">
                    <input type="text" id="live-url-input" readonly
                        class="flex-1 bg-transparent border-0 text-cyan-300 font-mono text-xs px-2 focus:outline-none select-all">
                    <button type="button" onclick="copyLiveUrl()"
                        class="px-4 py-2 rounded-lg bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs inline-flex items-center gap-1.5 transition">
                        <i class="fas fa-copy"></i> Salin
                    </button>
                    <a href="#" id="live-open-link" target="_blank"
                        class="px-4 py-2 rounded-lg bg-cyan-600 hover:bg-cyan-500 text-white font-bold text-xs inline-flex items-center gap-1.5 transition">
                        <i class="fas fa-external-link-alt"></i> Buka
                    </a>
                </div>

                <div class="flex justify-center gap-3">
                    <a href="{{ route('user.prototypes.index') }}" class="px-5 py-2.5 rounded-xl bg-slate-800 text-white font-bold text-xs hover:bg-slate-700 transition">
                        Lihat Daftar Prototipe Saya
                    </a>
                </div>
            </div>

            <!-- CATEGORY AUDIT DETAILS -->
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <h3 class="text-base font-extrabold text-white uppercase tracking-wider flex items-center gap-2">
                        <i class="fas fa-clipboard-check text-cyan-400"></i> Rincian Audit Kode & Rekomendasi AI
                    </h3>
                    <span class="text-xs text-slate-400" id="ai-provider-badge">AI Engine: Google Gemini</span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4" id="categories-container">
                    <!-- Populated via Javascript -->
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let currentMode = 'zip_archive';
    let currentTempToken = null;

    function switchUploadMode(mode) {
        currentMode = mode;
        document.getElementById('upload_type').value = mode;

        const tabZip = document.getElementById('tab-zip');
        const tabManual = document.getElementById('tab-manual');
        const sectionZip = document.getElementById('section-zip');
        const sectionManual = document.getElementById('section-manual');

        if (mode === 'zip_archive') {
            tabZip.className = "mode-tab-btn py-2.5 px-4 rounded-lg text-xs font-bold flex items-center justify-center gap-2 transition bg-purple-600 text-white shadow-lg";
            tabManual.className = "mode-tab-btn py-2.5 px-4 rounded-lg text-xs font-bold flex items-center justify-center gap-2 transition text-slate-400 hover:text-white";
            sectionZip.classList.remove('hidden');
            sectionManual.classList.add('hidden');
        } else {
            tabManual.className = "mode-tab-btn py-2.5 px-4 rounded-lg text-xs font-bold flex items-center justify-center gap-2 transition bg-purple-600 text-white shadow-lg";
            tabZip.className = "mode-tab-btn py-2.5 px-4 rounded-lg text-xs font-bold flex items-center justify-center gap-2 transition text-slate-400 hover:text-white";
            sectionManual.classList.remove('hidden');
            sectionZip.classList.add('hidden');
        }
    }

    function handleZipSelected(input) {
        if (input.files && input.files[0]) {
            const file = input.files[0];
            const sizeMb = (file.size / (1024 * 1024)).toFixed(2);
            document.getElementById('zip-drop-text').innerHTML = `<span class="text-emerald-400 font-bold"><i class="fas fa-check-circle"></i> File Terpilih: ${file.name}</span>`;
            document.getElementById('zip-file-info').innerHTML = `Ukuran: <strong>${sizeMb} MB</strong>. Klik tombol analisa di bawah untuk memulai audit AI.`;

            // Auto-fill project name if empty
            const nameInput = document.getElementById('project_name');
            if (!nameInput.value.trim()) {
                const cleanName = file.name.replace(/\.zip$/i, '').replace(/[-_]/g, ' ');
                nameInput.value = cleanName.charAt(0).toUpperCase() + cleanName.slice(1);
            }
        }
    }

    // Drag and drop handlers
    const dropzone = document.getElementById('zip-dropzone');
    ['dragenter', 'dragover'].forEach(eventName => {
        dropzone.addEventListener(eventName, (e) => {
            e.preventDefault();
            dropzone.classList.add('border-cyan-400', 'bg-cyan-950/20');
        }, false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dropzone.addEventListener(eventName, (e) => {
            e.preventDefault();
            dropzone.classList.remove('border-cyan-400', 'bg-cyan-950/20');
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

    // Form submission & AI analysis trigger
    document.getElementById('prototype-upload-form').addEventListener('submit', async function(e) {
        e.preventDefault();

        const formData = new FormData(this);
        const projectName = document.getElementById('project_name').value.trim();

        if (currentMode === 'zip_archive') {
            const zipInput = document.getElementById('zip_file');
            if (!zipInput.files || !zipInput.files[0]) {
                alert('Silakan pilih berkas file .ZIP terlebih dahulu.');
                return;
            }
        } else {
            const htmlInput = document.getElementById('html_file');
            if (!htmlInput.files || !htmlInput.files[0]) {
                alert('File HTML (.html) wajib diunggah sebagai halaman utama.');
                return;
            }
        }

        // Show loading overlay and animate steps
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

            // Animate completion
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
        const overlay = document.getElementById('loading-overlay');
        overlay.classList.remove('hidden');

        // Reset steps
        [1, 2, 3, 4].forEach(step => {
            const el = document.getElementById(`step-${step}`);
            const icon = el.querySelector('.step-icon');
            el.querySelector('span').className = 'text-slate-500';
            icon.className = 'w-6 h-6 rounded-full bg-slate-800 text-slate-500 flex items-center justify-center font-bold text-[10px] step-icon';
            icon.innerHTML = step;
        });

        // Simulate step progression
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
            icon.className = 'w-6 h-6 rounded-full bg-emerald-500/20 text-emerald-400 flex items-center justify-center font-bold text-[10px] step-icon';
            icon.innerHTML = '<i class="fas fa-check"></i>';
            text.className = 'text-slate-200 font-semibold';
        } else {
            icon.className = 'w-6 h-6 rounded-full bg-cyan-500/20 text-cyan-400 flex items-center justify-center font-bold text-[10px] step-icon';
            icon.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
            text.className = 'text-cyan-300 font-semibold';
        }
    }

    function hideLoadingOverlay() {
        document.getElementById('loading-overlay').classList.add('hidden');
    }

    function renderReport(data) {
        currentTempToken = data.temp_token;

        document.getElementById('upload-section').classList.add('hidden');
        document.getElementById('report-section').classList.remove('hidden');

        const score = data.score;
        const isApproved = data.is_approved;
        const minScore = data.min_passing_score;
        const report = data.report;

        // Animate score dial
        const circle = document.getElementById('score-circle');
        const circumference = 2 * Math.PI * 40; // ~251.2
        const offset = circumference - (score / 100) * circumference;
        circle.style.strokeDashoffset = offset;

        // Color coding
        if (score >= 80) {
            circle.setAttribute('class', 'text-emerald-400 transition-all duration-1000 ease-out');
        } else if (score >= minScore) {
            circle.setAttribute('class', 'text-cyan-400 transition-all duration-1000 ease-out');
        } else {
            circle.setAttribute('class', 'text-amber-400 transition-all duration-1000 ease-out');
        }

        // Animate count up
        animateCount('score-text', 0, score, 1000);

        // Verdict Banner styling
        const banner = document.getElementById('verdict-banner');
        const badge = document.getElementById('verdict-badge');
        const title = document.getElementById('verdict-title');
        const summary = document.getElementById('verdict-summary');

        if (isApproved) {
            banner.className = "rounded-2xl p-6 md:p-8 border-2 border-emerald-500/40 bg-gradient-to-r from-emerald-950/40 via-[#0c1220] to-[#0c1220] shadow-xl relative overflow-hidden";
            badge.className = "inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-extrabold uppercase tracking-wider bg-emerald-500/20 text-emerald-400 border border-emerald-500/30";
            badge.innerHTML = '<i class="fas fa-check-circle"></i> Lolos Uji Kelayakan Hosting Gratis!';
            title.innerHTML = 'Prototype Anda Memenuhi Standar! 🎉';
            document.getElementById('claim-hosting-card').classList.remove('hidden');
        } else {
            banner.className = "rounded-2xl p-6 md:p-8 border-2 border-amber-500/40 bg-gradient-to-r from-amber-950/40 via-[#0c1220] to-[#0c1220] shadow-xl relative overflow-hidden";
            badge.className = "inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-extrabold uppercase tracking-wider bg-amber-500/20 text-amber-400 border border-amber-500/30";
            badge.innerHTML = `<i class="fas fa-exclamation-triangle"></i> Skor Belum Memenuhi (Minimal: ${minScore})`;
            title.innerHTML = 'Perlu Sedikit Perbaikan Kode ⚠️';
            document.getElementById('claim-hosting-card').classList.add('hidden');
        }

        summary.innerText = report.verdict_summary || 'Pemeriksaan kualitas selesai.';

        // AI Provider badge
        document.getElementById('ai-provider-badge').innerText = `Diperiksa oleh: ${data.provider}`;

        // Fill deploy form values
        document.getElementById('deploy_temp_token').value = data.temp_token;
        document.getElementById('deploy_project_name').value = data.project_name;
        document.getElementById('deploy_slug').value = data.suggested_slug;
        checkCustomSlug();

        // Render categories
        renderCategoryCards(report.categories || {});
    }

    function renderCategoryCards(categories) {
        const container = document.getElementById('categories-container');
        container.innerHTML = '';

        const meta = {
            performance: { name: 'Performa & Kecepatan', icon: 'fa-bolt', color: 'text-yellow-400' },
            seo: { name: 'Search Engine Optimization (SEO)', icon: 'fa-search', color: 'text-cyan-400' },
            code_errors: { name: 'Syntax & Validasi Bug', icon: 'fa-bug', color: 'text-red-400' },
            best_practices: { name: 'Best Practices & HTML5 Semantik', icon: 'fa-award', color: 'text-purple-400' },
            security: { name: 'Keamanan & Integritas Skrip', icon: 'fa-shield-halved', color: 'text-emerald-400' },
        };

        for (const [key, details] of Object.entries(categories)) {
            const info = meta[key] || { name: key.toUpperCase(), icon: 'fa-code', color: 'text-slate-400' };
            const cardScore = details.score ?? 80;
            const issues = details.issues || [];
            const recs = details.recommendations || [];

            const card = document.createElement('div');
            card.className = "rounded-xl bg-[#0c1220] border border-[#1e2d40] p-5 shadow-lg flex flex-col justify-between";

            let issuesHtml = '';
            if (issues.length > 0) {
                issuesHtml += `<div class="mb-3"><span class="text-[10px] font-bold uppercase tracking-wider text-amber-400">Temuan / Catatan:</span><ul class="mt-1 space-y-1">`;
                issues.forEach(iss => {
                    issuesHtml += `<li class="text-xs text-slate-300 flex items-start gap-1.5"><i class="fas fa-exclamation-circle text-amber-400 mt-1 text-[10px]"></i> <span>${iss}</span></li>`;
                });
                issuesHtml += `</ul></div>`;
            } else {
                issuesHtml += `<div class="text-xs text-emerald-400 flex items-center gap-1.5 mb-3"><i class="fas fa-check-circle"></i> Tidak ada masalah kritis terdeteksi.</div>`;
            }

            let recsHtml = '';
            if (recs.length > 0) {
                recsHtml += `<div><span class="text-[10px] font-bold uppercase tracking-wider text-cyan-400">Saran AI:</span><ul class="mt-1 space-y-1">`;
                recs.forEach(rec => {
                    recsHtml += `<li class="text-xs text-slate-400 flex items-start gap-1.5"><i class="fas fa-lightbulb text-cyan-400 mt-1 text-[10px]"></i> <span>${rec}</span></li>`;
                });
                recsHtml += `</ul></div>`;
            }

            card.innerHTML = `
                <div>
                    <div class="flex items-center justify-between mb-3 border-b border-slate-800 pb-3">
                        <div class="flex items-center gap-2">
                            <i class="fas ${info.icon} ${info.color} text-sm"></i>
                            <span class="text-xs font-bold text-white">${info.name}</span>
                        </div>
                        <span class="px-2.5 py-0.5 rounded font-mono text-xs font-bold ${cardScore >= 80 ? 'bg-emerald-950/50 text-emerald-300 border border-emerald-800/50' : 'bg-amber-950/50 text-amber-300 border border-amber-800/50'}">
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
            feedback.innerHTML = '<span class="text-slate-400">Masukkan slug URL.</span>';
            return;
        }

        feedback.innerHTML = '<span class="text-slate-400"><i class="fas fa-spinner fa-spin"></i> Memeriksa ketersediaan...</span>';

        try {
            const res = await fetch(`{{ route('user.prototypes.check-slug') }}?slug=${encodeURIComponent(raw)}`);
            const data = await res.json();
            slugInput.value = data.slug;

            if (data.available) {
                feedback.innerHTML = `<span class="text-emerald-400 font-bold"><i class="fas fa-check"></i> URL Tersedia: <u>{{ url('/p') }}/${data.slug}</u></span>`;
            } else {
                feedback.innerHTML = `<span class="text-red-400 font-bold"><i class="fas fa-times"></i> ${data.message}</span>`;
            }
        } catch (e) {
            feedback.innerHTML = '<span class="text-slate-500">Gagal mengecek URL.</span>';
        }
    }

    // Deploy form submit
    document.getElementById('deploy-form').addEventListener('submit', async function(e) {
        e.preventDefault();

        const btn = document.getElementById('btn-deploy-now');
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mempublikasikan & Menyiapkan Server...';

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
            btn.innerHTML = '<i class="fas fa-rocket text-yellow-300"></i> Deploy & Publikasikan Sekarang';

            if (!res.ok || !data.success) {
                alert(data.message || 'Gagal mempublikasikan prototype.');
                return;
            }

            // Success!
            document.getElementById('claim-hosting-card').classList.add('hidden');
            const successBanner = document.getElementById('deployment-success-banner');
            successBanner.classList.remove('hidden');

            document.getElementById('live-url-input').value = data.url;
            document.getElementById('live-open-link').href = data.url;

            // Scroll to banner
            successBanner.scrollIntoView({ behavior: 'smooth' });

        } catch (err) {
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-rocket text-yellow-300"></i> Deploy & Publikasikan Sekarang';
            console.error(err);
            alert('Terjadi kesalahan jaringan.');
        }
    });

    function copyLiveUrl() {
        const input = document.getElementById('live-url-input');
        input.select();
        navigator.clipboard.writeText(input.value);
        alert('Tautan URL Prototype berhasil disalin ke clipboard!');
    }

    function resetToUpload() {
        document.getElementById('report-section').classList.add('hidden');
        document.getElementById('upload-section').classList.remove('hidden');
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
