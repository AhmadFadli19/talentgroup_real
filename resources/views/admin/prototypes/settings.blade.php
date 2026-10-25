@extends('layouts.app')

@section('title', 'Pengaturan AI & Hosting Prototype | Admin TalentGroup')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-8">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <div class="flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-[var(--blue)] mb-1">
                <i class="fas fa-sliders-h"></i> Panel Konfigurasi AI & Hosting
            </div>
            <h1 class="text-2xl md:text-3xl font-extrabold text-[var(--ink)] tracking-tight">
                Pengaturan AI Engine <span class="text-[var(--blue)]">& Kriteria Analisa</span>
            </h1>
            <p class="text-xs md:text-sm text-[var(--muted)] mt-1">
                Kelola API Key, Provider aktif (Gemini / DeepSeek / Qwen), batas skor minimal kelayakan hosting, dan aturan prompt khusus.
            </p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.prototypes.index') }}" class="btn-outline px-4 py-2.5 rounded-xl text-xs font-bold inline-flex items-center gap-2">
                <i class="fas fa-layer-group text-[var(--blue)]"></i> Kelola Prototype
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs flex items-center gap-3">
            <i class="fas fa-check-circle text-base text-emerald-600"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <form action="{{ route('admin.prototype-settings.update') }}" method="POST" class="space-y-8">
        @csrf

        <!-- SECTION 1: AI PROVIDER SELECTION -->
        <div class="rounded-2xl bg-white border border-[var(--border)] p-6 md:p-8 shadow-sm">
            <h2 class="text-base font-extrabold text-[var(--ink)] uppercase tracking-wider mb-2 flex items-center gap-2">
                <i class="fas fa-microchip text-[var(--blue)]"></i> 1. Pilihan Engine AI Aktif
            </h2>
            <p class="text-xs text-[var(--muted)] mb-6">
                Pilih provider AI utama yang bertugas menganalisa kode prototype yang diunggah pengguna.
            </p>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <!-- Gemini -->
                <label class="cursor-pointer">
                    <input type="radio" name="active_provider" value="gemini" class="hidden peer" {{ $settings->active_provider === 'gemini' ? 'checked' : '' }}>
                    <div class="p-5 rounded-2xl border-2 border-[var(--border)] bg-slate-50 peer-checked:border-[var(--blue)] peer-checked:bg-blue-50/50 transition flex flex-col justify-between h-full shadow-sm">
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-sm font-bold text-[var(--ink)] flex items-center gap-2">
                                <i class="fab fa-google text-[var(--blue)]"></i> Google Gemini
                            </span>
                            <span class="w-4 h-4 rounded-full border-2 border-slate-300 peer-checked:border-[var(--blue)] peer-checked:bg-[var(--blue)]"></span>
                        </div>
                        <p class="text-[11px] text-[var(--muted)] leading-relaxed">Direkomendasikan untuk kecepatan audit, analisis kode multimodal, dan respon JSON terstruktur.</p>
                    </div>
                </label>

                <!-- DeepSeek -->
                <label class="cursor-pointer">
                    <input type="radio" name="active_provider" value="deepseek" class="hidden peer" {{ $settings->active_provider === 'deepseek' ? 'checked' : '' }}>
                    <div class="p-5 rounded-2xl border-2 border-[var(--border)] bg-slate-50 peer-checked:border-[var(--blue)] peer-checked:bg-blue-50/50 transition flex flex-col justify-between h-full shadow-sm">
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-sm font-bold text-[var(--ink)] flex items-center gap-2">
                                <i class="fas fa-code text-indigo-600"></i> DeepSeek Coder
                            </span>
                            <span class="w-4 h-4 rounded-full border-2 border-slate-300 peer-checked:border-[var(--blue)] peer-checked:bg-[var(--blue)]"></span>
                        </div>
                        <p class="text-[11px] text-[var(--muted)] leading-relaxed">Sangat akurat untuk deteksi bug logika pemrograman dan optimasi syntax JavaScript/CSS.</p>
                    </div>
                </label>

                <!-- Alibaba Qwen -->
                <label class="cursor-pointer">
                    <input type="radio" name="active_provider" value="qwen" class="hidden peer" {{ $settings->active_provider === 'qwen' ? 'checked' : '' }}>
                    <div class="p-5 rounded-2xl border-2 border-[var(--border)] bg-slate-50 peer-checked:border-[var(--blue)] peer-checked:bg-blue-50/50 transition flex flex-col justify-between h-full shadow-sm">
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-sm font-bold text-[var(--ink)] flex items-center gap-2">
                                <i class="fas fa-cube text-amber-600"></i> Alibaba Qwen
                            </span>
                            <span class="w-4 h-4 rounded-full border-2 border-slate-300 peer-checked:border-[var(--blue)] peer-checked:bg-[var(--blue)]"></span>
                        </div>
                        <p class="text-[11px] text-[var(--muted)] leading-relaxed">Model handal untuk evaluasi komprehensif, standar best practices, dan keamanan kode.</p>
                    </div>
                </label>
            </div>

            <!-- Provider Keys & Model Details -->
            <div class="space-y-6 pt-4 border-t border-[var(--border)]">
                <!-- Gemini Details -->
                <div class="p-5 rounded-2xl bg-slate-50 border border-[var(--border)]">
                    <div class="flex items-center gap-2 text-xs font-bold text-[var(--blue)] uppercase tracking-wider mb-3">
                        <i class="fab fa-google"></i> Konfigurasi Google Gemini
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[11px] font-bold text-[var(--ink)] uppercase mb-1.5">API Key Gemini</label>
                            <input type="password" name="gemini_api_key" value="{{ $settings->gemini_api_key }}"
                                placeholder="AIzaSy..."
                                class="w-full px-3.5 py-2.5 bg-white border border-[var(--border)] rounded-xl text-[var(--ink)] text-xs font-mono focus:border-[var(--blue)] focus:outline-none transition">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-[var(--ink)] uppercase mb-1.5">Model Name</label>
                            <input type="text" name="gemini_model" value="{{ $settings->gemini_model }}" required
                                placeholder="gemini-2.5-flash"
                                class="w-full px-3.5 py-2.5 bg-white border border-[var(--border)] rounded-xl text-[var(--ink)] text-xs font-mono focus:border-[var(--blue)] focus:outline-none transition">
                        </div>
                    </div>
                </div>

                <!-- DeepSeek Details -->
                <div class="p-5 rounded-2xl bg-slate-50 border border-[var(--border)]">
                    <div class="flex items-center gap-2 text-xs font-bold text-indigo-600 uppercase tracking-wider mb-3">
                        <i class="fas fa-code"></i> Konfigurasi DeepSeek
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[11px] font-bold text-[var(--ink)] uppercase mb-1.5">API Key DeepSeek</label>
                            <input type="password" name="deepseek_api_key" value="{{ $settings->deepseek_api_key }}"
                                placeholder="sk-..."
                                class="w-full px-3.5 py-2.5 bg-white border border-[var(--border)] rounded-xl text-[var(--ink)] text-xs font-mono focus:border-[var(--blue)] focus:outline-none transition">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-[var(--ink)] uppercase mb-1.5">Model Name</label>
                            <input type="text" name="deepseek_model" value="{{ $settings->deepseek_model }}" required
                                placeholder="deepseek-chat"
                                class="w-full px-3.5 py-2.5 bg-white border border-[var(--border)] rounded-xl text-[var(--ink)] text-xs font-mono focus:border-[var(--blue)] focus:outline-none transition">
                        </div>
                    </div>
                </div>

                <!-- Qwen Details -->
                <div class="p-5 rounded-2xl bg-slate-50 border border-[var(--border)]">
                    <div class="flex items-center gap-2 text-xs font-bold text-amber-600 uppercase tracking-wider mb-3">
                        <i class="fas fa-cube"></i> Konfigurasi Alibaba Qwen
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[11px] font-bold text-[var(--ink)] uppercase mb-1.5">API Key Qwen (DashScope)</label>
                            <input type="password" name="qwen_api_key" value="{{ $settings->qwen_api_key }}"
                                placeholder="sk-..."
                                class="w-full px-3.5 py-2.5 bg-white border border-[var(--border)] rounded-xl text-[var(--ink)] text-xs font-mono focus:border-[var(--blue)] focus:outline-none transition">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-[var(--ink)] uppercase mb-1.5">Model Name</label>
                            <input type="text" name="qwen_model" value="{{ $settings->qwen_model }}" required
                                placeholder="qwen-max"
                                class="w-full px-3.5 py-2.5 bg-white border border-[var(--border)] rounded-xl text-[var(--ink)] text-xs font-mono focus:border-[var(--blue)] focus:outline-none transition">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- SECTION 2: PASSING SCORE & CHECKLISTS -->
        <div class="rounded-2xl bg-white border border-[var(--border)] p-6 md:p-8 shadow-sm">
            <h2 class="text-base font-extrabold text-[var(--ink)] uppercase tracking-wider mb-2 flex items-center gap-2">
                <i class="fas fa-check-double text-emerald-600"></i> 2. Ambang Kelayakan Hosting & Kriteria Audit
            </h2>
            <p class="text-xs text-[var(--muted)] mb-6">
                Tentukan skor kelayakan minimal dan aspek-aspek yang harus diperiksa oleh AI Agent.
            </p>

            <!-- Minimum Passing Score -->
            <div class="mb-6 p-5 rounded-2xl bg-slate-50 border border-[var(--border)]">
                <div class="flex items-center justify-between mb-3">
                    <label class="text-xs font-bold uppercase tracking-wider text-[var(--ink)]">
                        Skor Minimal Lolos Hosting Gratis (Passing Score)
                    </label>
                    <span id="score-display" class="px-3.5 py-1 rounded-xl bg-emerald-50 text-emerald-700 font-mono font-black text-sm border border-emerald-200">
                        {{ $settings->min_passing_score }} / 100
                    </span>
                </div>
                <input type="range" name="min_passing_score" id="min_passing_score" min="50" max="95" step="1"
                    value="{{ $settings->min_passing_score }}"
                    oninput="document.getElementById('score-display').innerText = this.value + ' / 100'"
                    class="w-full accent-[var(--blue)] cursor-pointer">
                <div class="flex justify-between text-[11px] text-[var(--muted)] mt-2 font-medium">
                    <span>50 (Sangat Longgar)</span>
                    <span class="text-[var(--blue)] font-bold">75 (Standar Direkomendasikan)</span>
                    <span>95 (Sangat Ketat)</span>
                </div>
            </div>

            <!-- Checklists -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <label class="flex items-start gap-3 p-4 rounded-xl bg-slate-50 border border-[var(--border)] hover:border-slate-300 cursor-pointer transition">
                    <input type="checkbox" name="check_seo" value="1" {{ $settings->check_seo ? 'checked' : '' }} class="mt-0.5 rounded accent-[var(--blue)] w-4 h-4">
                    <div>
                        <span class="text-xs font-bold text-[var(--ink)] block">Audit SEO & Meta Tags</span>
                        <span class="text-[11px] text-[var(--muted)]">Cek tag title, meta description, meta viewport, heading hierarchy, dan alt attribute.</span>
                    </div>
                </label>

                <label class="flex items-start gap-3 p-4 rounded-xl bg-slate-50 border border-[var(--border)] hover:border-slate-300 cursor-pointer transition">
                    <input type="checkbox" name="check_performance" value="1" {{ $settings->check_performance ? 'checked' : '' }} class="mt-0.5 rounded accent-[var(--blue)] w-4 h-4">
                    <div>
                        <span class="text-xs font-bold text-[var(--ink)] block">Audit Performa & Script Loading</span>
                        <span class="text-[11px] text-[var(--muted)]">Cek script render-blocking, beban file inline CSS, dan efisiensi DOM.</span>
                    </div>
                </label>

                <label class="flex items-start gap-3 p-4 rounded-xl bg-slate-50 border border-[var(--border)] hover:border-slate-300 cursor-pointer transition">
                    <input type="checkbox" name="check_code_errors" value="1" {{ $settings->check_code_errors ? 'checked' : '' }} class="mt-0.5 rounded accent-[var(--blue)] w-4 h-4">
                    <div>
                        <span class="text-xs font-bold text-[var(--ink)] block">Audit Syntax & Potensi Bug</span>
                        <span class="text-[11px] text-[var(--muted)]">Cek tag HTML yang tidak tertutup, kesalahan properti CSS, dan runtime JS error.</span>
                    </div>
                </label>

                <label class="flex items-start gap-3 p-4 rounded-xl bg-slate-50 border border-[var(--border)] hover:border-slate-300 cursor-pointer transition">
                    <input type="checkbox" name="check_best_practices" value="1" {{ $settings->check_best_practices ? 'checked' : '' }} class="mt-0.5 rounded accent-[var(--blue)] w-4 h-4">
                    <div>
                        <span class="text-xs font-bold text-[var(--ink)] block">Audit HTML5 Semantik & Aksesibilitas</span>
                        <span class="text-[11px] text-[var(--muted)]">Cek penggunaan tag semantic (main, header, footer, nav) dan struktur hierarki.</span>
                    </div>
                </label>

                <label class="flex items-start gap-3 p-4 rounded-xl bg-slate-50 border border-[var(--border)] hover:border-slate-300 cursor-pointer transition md:col-span-2">
                    <input type="checkbox" name="check_security" value="1" {{ $settings->check_security ? 'checked' : '' }} class="mt-0.5 rounded accent-[var(--blue)] w-4 h-4">
                    <div>
                        <span class="text-xs font-bold text-[var(--ink)] block">Audit Keamanan & Pencegahan Phishing (Kritis)</span>
                        <span class="text-[11px] text-[var(--muted)]">Mencegah penyusupan form login palsu, malware redirect, atau skrip crypto-mining berbahaya.</span>
                    </div>
                </label>
            </div>
        </div>

        <!-- SECTION 3: CUSTOM PROMPT RULES -->
        <div class="rounded-2xl bg-white border border-[var(--border)] p-6 md:p-8 shadow-sm">
            <h2 class="text-base font-extrabold text-[var(--ink)] uppercase tracking-wider mb-2 flex items-center gap-2">
                <i class="fas fa-terminal text-[var(--blue)]"></i> 3. Instruksi Khusus Prompt Admin (Custom System Prompt)
            </h2>
            <p class="text-xs text-[var(--muted)] mb-4">
                Tambahkan aturan khusus yang akan dipatuhi AI Agent saat menganalisa prototype (misalnya: tolak jika tidak responsif, tolak jika bertema judi online, dll).
            </p>

            <textarea name="custom_rules_prompt" rows="4"
                placeholder="Contoh: Pastikan website memiliki media query responsif mobile. Tolak jika mengandung unsur judi online atau penipuan finansial."
                class="w-full px-4 py-3 bg-slate-50 border border-[var(--border)] rounded-xl text-[var(--ink)] text-xs leading-relaxed focus:bg-white focus:border-[var(--blue)] focus:outline-none transition">{{ $settings->custom_rules_prompt }}</textarea>
        </div>

        <!-- Save Button -->
        <div class="flex justify-end">
            <button type="submit"
                class="btn-gradient px-8 py-3.5 rounded-xl text-white font-black text-xs uppercase tracking-wider shadow-md inline-flex items-center gap-2">
                <i class="fas fa-save"></i> Simpan Konfigurasi AI & Hosting
            </button>
        </div>
    </form>
</div>
@endsection
