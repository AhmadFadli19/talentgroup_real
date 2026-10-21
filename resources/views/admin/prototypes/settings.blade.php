@extends('layouts.app')

@section('title', 'Pengaturan AI & Hosting Prototype | Admin Flow Academy')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-8">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <div class="flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-[var(--cyan)] mb-1">
                <i class="fas fa-sliders-h"></i> Panel Konfigurasi AI & Hosting
            </div>
            <h1 class="text-2xl md:text-3xl font-extrabold text-white tracking-tight">
                Pengaturan AI Engine <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-cyan-400">& Kriteria Analisa</span>
            </h1>
            <p class="text-xs md:text-sm text-slate-400 mt-1">
                Kelola API Key, Provider aktif (Gemini / DeepSeek / Qwen), batas skor minimal kelayakan hosting, dan aturan prompt khusus.
            </p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.prototypes.index') }}" class="px-4 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-750 text-slate-200 text-xs font-bold border border-slate-700 inline-flex items-center gap-2 transition">
                <i class="fas fa-layer-group text-cyan-400"></i> Kelola Prototype
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="mb-6 p-4 rounded-xl bg-emerald-950/40 border border-emerald-500/40 text-emerald-300 text-xs flex items-center gap-3">
            <i class="fas fa-check-circle text-base"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <form action="{{ route('admin.prototype-settings.update') }}" method="POST" class="space-y-8">
        @csrf

        <!-- SECTION 1: AI PROVIDER SELECTION -->
        <div class="rounded-2xl bg-[#0c1220] border border-[#1e2d40] p-6 md:p-8 shadow-2xl">
            <h2 class="text-base font-extrabold text-white uppercase tracking-wider mb-2 flex items-center gap-2">
                <i class="fas fa-microchip text-purple-400"></i> 1. Pilihan Engine AI Aktif
            </h2>
            <p class="text-xs text-slate-400 mb-6">
                Pilih provider AI utama yang bertugas menganalisa kode prototype yang diunggah pengguna.
            </p>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <!-- Gemini -->
                <label class="cursor-pointer">
                    <input type="radio" name="active_provider" value="gemini" class="hidden peer" {{ $settings->active_provider === 'gemini' ? 'checked' : '' }}>
                    <div class="p-5 rounded-xl border border-slate-700 bg-[#05080f] peer-checked:border-cyan-400 peer-checked:bg-cyan-950/20 transition flex flex-col justify-between h-full">
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-sm font-bold text-white flex items-center gap-2">
                                <i class="fab fa-google text-cyan-400"></i> Google Gemini
                            </span>
                            <span class="w-3.5 h-3.5 rounded-full border border-slate-500 peer-checked:bg-cyan-400"></span>
                        </div>
                        <p class="text-[11px] text-slate-400">Direkomendasikan untuk kecepatan audit, analisis kode multimodal, dan respon JSON terstruktur.</p>
                    </div>
                </label>

                <!-- DeepSeek -->
                <label class="cursor-pointer">
                    <input type="radio" name="active_provider" value="deepseek" class="hidden peer" {{ $settings->active_provider === 'deepseek' ? 'checked' : '' }}>
                    <div class="p-5 rounded-xl border border-slate-700 bg-[#05080f] peer-checked:border-purple-400 peer-checked:bg-purple-950/20 transition flex flex-col justify-between h-full">
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-sm font-bold text-white flex items-center gap-2">
                                <i class="fas fa-code text-purple-400"></i> DeepSeek Coder
                            </span>
                            <span class="w-3.5 h-3.5 rounded-full border border-slate-500 peer-checked:bg-purple-400"></span>
                        </div>
                        <p class="text-[11px] text-slate-400">Sangat akurat untuk deteksi bug logika pemrograman dan optimasi syntax JavaScript/CSS.</p>
                    </div>
                </label>

                <!-- Alibaba Qwen -->
                <label class="cursor-pointer">
                    <input type="radio" name="active_provider" value="qwen" class="hidden peer" {{ $settings->active_provider === 'qwen' ? 'checked' : '' }}>
                    <div class="p-5 rounded-xl border border-slate-700 bg-[#05080f] peer-checked:border-amber-400 peer-checked:bg-amber-950/20 transition flex flex-col justify-between h-full">
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-sm font-bold text-white flex items-center gap-2">
                                <i class="fas fa-cube text-amber-400"></i> Alibaba Qwen
                            </span>
                            <span class="w-3.5 h-3.5 rounded-full border border-slate-500 peer-checked:bg-amber-400"></span>
                        </div>
                        <p class="text-[11px] text-slate-400">Model handal untuk evaluasi komprehensif, standar best practices, dan keamanan kode.</p>
                    </div>
                </label>
            </div>

            <!-- Provider Keys & Model Details -->
            <div class="space-y-6 pt-4 border-t border-slate-800">
                <!-- Gemini Details -->
                <div class="p-4 rounded-xl bg-[#05080f] border border-[#1e2d40]">
                    <div class="flex items-center gap-2 text-xs font-bold text-cyan-400 uppercase tracking-wider mb-3">
                        <i class="fab fa-google"></i> Konfigurasi Google Gemini
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[11px] font-bold text-slate-300 uppercase mb-1">API Key Gemini</label>
                            <input type="password" name="gemini_api_key" value="{{ $settings->gemini_api_key }}"
                                placeholder="AIzaSy..."
                                class="w-full px-3 py-2 bg-[#0c1220] border border-[#1e2d40] rounded-lg text-white text-xs font-mono focus:border-cyan-400 focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-300 uppercase mb-1">Model Name</label>
                            <input type="text" name="gemini_model" value="{{ $settings->gemini_model }}" required
                                placeholder="gemini-2.5-flash"
                                class="w-full px-3 py-2 bg-[#0c1220] border border-[#1e2d40] rounded-lg text-white text-xs font-mono focus:border-cyan-400 focus:outline-none">
                        </div>
                    </div>
                </div>

                <!-- DeepSeek Details -->
                <div class="p-4 rounded-xl bg-[#05080f] border border-[#1e2d40]">
                    <div class="flex items-center gap-2 text-xs font-bold text-purple-400 uppercase tracking-wider mb-3">
                        <i class="fas fa-code"></i> Konfigurasi DeepSeek
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[11px] font-bold text-slate-300 uppercase mb-1">API Key DeepSeek</label>
                            <input type="password" name="deepseek_api_key" value="{{ $settings->deepseek_api_key }}"
                                placeholder="sk-..."
                                class="w-full px-3 py-2 bg-[#0c1220] border border-[#1e2d40] rounded-lg text-white text-xs font-mono focus:border-purple-400 focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-300 uppercase mb-1">Model Name</label>
                            <input type="text" name="deepseek_model" value="{{ $settings->deepseek_model }}" required
                                placeholder="deepseek-chat"
                                class="w-full px-3 py-2 bg-[#0c1220] border border-[#1e2d40] rounded-lg text-white text-xs font-mono focus:border-purple-400 focus:outline-none">
                        </div>
                    </div>
                </div>

                <!-- Qwen Details -->
                <div class="p-4 rounded-xl bg-[#05080f] border border-[#1e2d40]">
                    <div class="flex items-center gap-2 text-xs font-bold text-amber-400 uppercase tracking-wider mb-3">
                        <i class="fas fa-cube"></i> Konfigurasi Alibaba Qwen
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[11px] font-bold text-slate-300 uppercase mb-1">API Key Qwen (DashScope)</label>
                            <input type="password" name="qwen_api_key" value="{{ $settings->qwen_api_key }}"
                                placeholder="sk-..."
                                class="w-full px-3 py-2 bg-[#0c1220] border border-[#1e2d40] rounded-lg text-white text-xs font-mono focus:border-amber-400 focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-300 uppercase mb-1">Model Name</label>
                            <input type="text" name="qwen_model" value="{{ $settings->qwen_model }}" required
                                placeholder="qwen-max"
                                class="w-full px-3 py-2 bg-[#0c1220] border border-[#1e2d40] rounded-lg text-white text-xs font-mono focus:border-amber-400 focus:outline-none">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- SECTION 2: PASSING SCORE & CHECKLISTS -->
        <div class="rounded-2xl bg-[#0c1220] border border-[#1e2d40] p-6 md:p-8 shadow-2xl">
            <h2 class="text-base font-extrabold text-white uppercase tracking-wider mb-2 flex items-center gap-2">
                <i class="fas fa-check-double text-emerald-400"></i> 2. Ambang Kelayakan Hosting & Kriteria Audit
            </h2>
            <p class="text-xs text-slate-400 mb-6">
                Tentukan skor kelayakan minimal dan aspek-aspek yang harus diperiksa oleh AI Agent.
            </p>

            <!-- Minimum Passing Score -->
            <div class="mb-6 p-5 rounded-xl bg-[#05080f] border border-[#1e2d40]">
                <div class="flex items-center justify-between mb-3">
                    <label class="text-xs font-bold uppercase tracking-wider text-white">
                        Skor Minimal Lolos Hosting Gratis (Passing Score)
                    </label>
                    <span id="score-display" class="px-3 py-1 rounded-lg bg-emerald-950 text-emerald-300 font-mono font-black text-sm border border-emerald-800/60">
                        {{ $settings->min_passing_score }} / 100
                    </span>
                </div>
                <input type="range" name="min_passing_score" id="min_passing_score" min="50" max="95" step="1"
                    value="{{ $settings->min_passing_score }}"
                    oninput="document.getElementById('score-display').innerText = this.value + ' / 100'"
                    class="w-full accent-cyan-400 cursor-pointer">
                <div class="flex justify-between text-[10px] text-slate-500 mt-1">
                    <span>50 (Sangat Longgar)</span>
                    <span>75 (Standar Direkomendasikan)</span>
                    <span>95 (Sangat Ketat)</span>
                </div>
            </div>

            <!-- Checklists -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <label class="flex items-start gap-3 p-3.5 rounded-xl bg-[#05080f] border border-[#1e2d40] hover:border-slate-700 cursor-pointer transition">
                    <input type="checkbox" name="check_seo" value="1" {{ $settings->check_seo ? 'checked' : '' }} class="mt-0.5 rounded accent-cyan-400">
                    <div>
                        <span class="text-xs font-bold text-white block">Audit SEO & Meta Tags</span>
                        <span class="text-[11px] text-slate-400">Cek tag title, meta description, meta viewport, heading hierarchy, dan alt attribute.</span>
                    </div>
                </label>

                <label class="flex items-start gap-3 p-3.5 rounded-xl bg-[#05080f] border border-[#1e2d40] hover:border-slate-700 cursor-pointer transition">
                    <input type="checkbox" name="check_performance" value="1" {{ $settings->check_performance ? 'checked' : '' }} class="mt-0.5 rounded accent-cyan-400">
                    <div>
                        <span class="text-xs font-bold text-white block">Audit Performa & Script Loading</span>
                        <span class="text-[11px] text-slate-400">Cek script render-blocking, beban file inline CSS, dan efisiensi DOM.</span>
                    </div>
                </label>

                <label class="flex items-start gap-3 p-3.5 rounded-xl bg-[#05080f] border border-[#1e2d40] hover:border-slate-700 cursor-pointer transition">
                    <input type="checkbox" name="check_code_errors" value="1" {{ $settings->check_code_errors ? 'checked' : '' }} class="mt-0.5 rounded accent-cyan-400">
                    <div>
                        <span class="text-xs font-bold text-white block">Audit Syntax & Potensi Bug</span>
                        <span class="text-[11px] text-slate-400">Cek tag HTML yang tidak tertutup, kesalahan properti CSS, dan runtime JS error.</span>
                    </div>
                </label>

                <label class="flex items-start gap-3 p-3.5 rounded-xl bg-[#05080f] border border-[#1e2d40] hover:border-slate-700 cursor-pointer transition">
                    <input type="checkbox" name="check_best_practices" value="1" {{ $settings->check_best_practices ? 'checked' : '' }} class="mt-0.5 rounded accent-cyan-400">
                    <div>
                        <span class="text-xs font-bold text-white block">Audit HTML5 Semantik & Aksesibilitas</span>
                        <span class="text-[11px] text-slate-400">Cek penggunaan tag semantic (main, header, footer, nav) dan struktur hierarki.</span>
                    </div>
                </label>

                <label class="flex items-start gap-3 p-3.5 rounded-xl bg-[#05080f] border border-[#1e2d40] hover:border-slate-700 cursor-pointer transition md:col-span-2">
                    <input type="checkbox" name="check_security" value="1" {{ $settings->check_security ? 'checked' : '' }} class="mt-0.5 rounded accent-cyan-400">
                    <div>
                        <span class="text-xs font-bold text-white block">Audit Keamanan & Pencegahan Phishing (Kritis)</span>
                        <span class="text-[11px] text-slate-400">Mencegah penyusupan form login palsu, malware redirect, atau skrip crypto-mining.</span>
                    </div>
                </label>
            </div>
        </div>

        <!-- SECTION 3: CUSTOM PROMPT RULES -->
        <div class="rounded-2xl bg-[#0c1220] border border-[#1e2d40] p-6 md:p-8 shadow-2xl">
            <h2 class="text-base font-extrabold text-white uppercase tracking-wider mb-2 flex items-center gap-2">
                <i class="fas fa-terminal text-cyan-400"></i> 3. Instruksi Khusus Prompt Admin (Custom System Prompt)
            </h2>
            <p class="text-xs text-slate-400 mb-4">
                Tambahkan aturan khusus yang akan dipatuhi AI Agent saat menganalisa prototype (misalnya: tolak jika tidak responsif, tolak jika bertema judi online, dll).
            </p>

            <textarea name="custom_rules_prompt" rows="4"
                placeholder="Contoh: Pastikan website memiliki media query responsif mobile. Tolak jika mengandung unsur judi online atau penipuan finansial."
                class="w-full px-4 py-3 bg-[#05080f] border border-[#1e2d40] rounded-xl text-white text-xs leading-relaxed focus:border-cyan-400 focus:outline-none transition">{{ $settings->custom_rules_prompt }}</textarea>
        </div>

        <!-- Save Button -->
        <div class="flex justify-end">
            <button type="submit"
                class="px-8 py-3.5 rounded-xl bg-gradient-to-r from-purple-600 to-cyan-500 hover:opacity-95 text-white font-black text-xs uppercase tracking-wider shadow-lg shadow-purple-600/20 inline-flex items-center gap-2 transition">
                <i class="fas fa-save"></i> Simpan Konfigurasi AI & Hosting
            </button>
        </div>
    </form>
</div>
@endsection
