@extends('layouts.app')

@section('title', 'Tambah Bab Materi: ' . $module->name . ' | Admin TalentGroup')

@section('content')
<div class="max-w-[96rem] mx-auto px-4 py-6">

    <form action="{{ route('admin.modules.contents.store', $module->id) }}" method="POST" enctype="multipart/form-data" id="moduleForm">
        @csrf

        <!-- Top Header & Action Buttons -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6 pb-4 border-b border-[var(--border)]">
            <div>
                <div class="flex items-center gap-2 text-xs font-mono text-[var(--blue)] uppercase tracking-wider mb-1">
                    <a href="{{ route('admin.modules.index') }}" class="hover:underline">MODULE MANAGER</a>
                    <i class="fas fa-chevron-right text-[10px]"></i>
                    <a href="{{ route('admin.modules.contents.index', $module->id) }}" class="hover:underline">{{ $module->name }}</a>
                    <i class="fas fa-chevron-right text-[10px]"></i>
                    <span class="text-[var(--ink)]">TAMBAH BAB</span>
                </div>
                <h1 class="text-xl sm:text-2xl font-extrabold text-[var(--ink)] tracking-tight">
                    Tambah Bab Baru: <span class="text-[var(--blue)]">{{ $module->name }}</span>
                </h1>
            </div>

            <div class="flex items-center gap-3">
                <!-- View Mode Buttons -->
                <div id="viewModeButtonsGroup" class="hidden sm:inline-flex p-1 rounded-xl bg-slate-100 border border-[var(--border)] text-xs font-semibold text-[var(--muted)]">
                    <button type="button" onclick="setViewMode('split')" id="btnViewSplit" class="px-3 py-1.5 rounded-lg bg-white text-[var(--blue)] font-bold shadow-xs">
                        <i class="fas fa-columns mr-1"></i> Split View
                    </button>
                    <button type="button" onclick="setViewMode('editor')" id="btnViewEditor" class="px-3 py-1.5 rounded-lg hover:text-[var(--ink)]">
                        <i class="fas fa-code mr-1"></i> Editor
                    </button>
                    <button type="button" onclick="setViewMode('preview')" id="btnViewPreview" class="px-3 py-1.5 rounded-lg hover:text-[var(--ink)]">
                        <i class="fas fa-eye mr-1"></i> Preview
                    </button>
                </div>

                <a href="{{ route('admin.modules.contents.index', $module->id) }}" class="btn-outline px-4 py-2 rounded-xl text-xs font-bold">
                    Batal
                </a>

                <button type="submit" class="btn-gradient px-5 py-2.5 rounded-xl text-white text-xs font-bold flex items-center gap-2 shadow-sm">
                    <i class="fas fa-save"></i>
                    <span>Simpan Bab Materi</span>
                </button>
            </div>
        </div>

        @if(isset($errors) && $errors->any())
            <div class="mb-6 p-4 rounded-xl border border-rose-200 bg-rose-50 text-rose-800 text-sm">
                <ul class="list-disc pl-5 space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Pilihan Format Konten Bab Materi (Markdown / PDF / Word / PPT) -->
        <input type="hidden" name="content_type" id="contentTypeInput" value="{{ old('content_type', 'markdown') }}">

        <div class="mb-6">
            <label class="block text-xs font-bold uppercase tracking-wider text-[var(--ink)] mb-3 flex items-center gap-2">
                <i class="fas fa-shapes text-[var(--blue)]"></i>
                <span>Pilih Format Penyajian Bab Materi Ini (4 Format Tersedia):</span>
            </label>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Option 1: Markdown (.md) / Manual -->
                <div onclick="selectContentType('markdown')" 
                     id="typeCardMarkdown" 
                     class="p-4 rounded-2xl border-2 cursor-pointer transition-all bg-white border-[var(--blue)] shadow-sm">
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-200 text-[var(--blue)] flex items-center justify-center text-lg shrink-0">
                            <i class="fab fa-markdown"></i>
                        </div>
                        <div>
                            <div class="flex items-center gap-2">
                                <h3 class="text-sm font-bold text-[var(--ink)]">1. Markdown (.md)</h3>
                                <span class="text-[9px] font-mono px-1.5 py-0.5 rounded bg-blue-50 text-[var(--blue)] border border-blue-200 font-bold">INTERAKTIF</span>
                            </div>
                            <p class="text-xs text-[var(--muted)] mt-1 leading-relaxed">
                                Tulis manual dengan markdown, tabel, code block, atau import <code class="text-[var(--blue)]">.md</code>.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Option 2: PDF Document -->
                <div onclick="selectContentType('pdf')" 
                     id="typeCardPdf" 
                     class="p-4 rounded-2xl border-2 cursor-pointer transition-all bg-slate-50 border-[var(--border)] opacity-80 hover:opacity-100">
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 rounded-xl bg-rose-50 border border-rose-200 text-rose-600 flex items-center justify-center text-lg shrink-0">
                            <i class="fas fa-file-pdf"></i>
                        </div>
                        <div>
                            <div class="flex items-center gap-2">
                                <h3 class="text-sm font-bold text-[var(--ink)]">2. Dokumen PDF (.pdf)</h3>
                                <span class="text-[9px] font-mono px-1.5 py-0.5 rounded bg-rose-50 text-rose-600 border border-rose-200 font-bold">DIGITAL</span>
                            </div>
                            <p class="text-xs text-[var(--muted)] mt-1 leading-relaxed">
                                Upload berkas PDF. Pembaca digital interaktif langsung di browser.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Option 3: Word Document -->
                <div onclick="selectContentType('word')" 
                     id="typeCardWord" 
                     class="p-4 rounded-2xl border-2 cursor-pointer transition-all bg-slate-50 border-[var(--border)] opacity-80 hover:opacity-100">
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 rounded-xl bg-sky-50 border border-sky-200 text-sky-600 flex items-center justify-center text-lg shrink-0">
                            <i class="fas fa-file-word"></i>
                        </div>
                        <div>
                            <div class="flex items-center gap-2">
                                <h3 class="text-sm font-bold text-[var(--ink)]">3. Word (.docx/.doc)</h3>
                                <span class="text-[9px] font-mono px-1.5 py-0.5 rounded bg-sky-50 text-sky-600 border border-sky-200 font-bold">OFFICE</span>
                            </div>
                            <p class="text-xs text-[var(--muted)] mt-1 leading-relaxed">
                                Upload dokumen Microsoft Word materi bab lengkap.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Option 4: PowerPoint Presentation -->
                <div onclick="selectContentType('ppt')" 
                     id="typeCardPpt" 
                     class="p-4 rounded-2xl border-2 cursor-pointer transition-all bg-slate-50 border-[var(--border)] opacity-80 hover:opacity-100">
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 rounded-xl bg-amber-50 border border-amber-200 text-amber-600 flex items-center justify-center text-lg shrink-0">
                            <i class="fas fa-file-powerpoint"></i>
                        </div>
                        <div>
                            <div class="flex items-center gap-2">
                                <h3 class="text-sm font-bold text-[var(--ink)]">4. PowerPoint (.pptx/.ppt)</h3>
                                <span class="text-[9px] font-mono px-1.5 py-0.5 rounded bg-amber-50 text-amber-600 border border-amber-200 font-bold">SLIDE</span>
                            </div>
                            <p class="text-xs text-[var(--muted)] mt-1 leading-relaxed">
                                Upload materi slide presentasi PowerPoint untuk peserta.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Document File Upload Box (Shown for PDF & Word, or optional companion) -->
        <div id="documentUploadSection" class="bg-white border border-[var(--border)] rounded-2xl p-6 mb-6 hidden shadow-sm">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 pb-3 mb-4 border-b border-[var(--border)]">
                <div>
                    <h3 class="text-sm font-bold text-[var(--ink)] flex items-center gap-2" id="docUploadTitle">
                        <i class="fas fa-cloud-upload-alt text-[var(--blue)]"></i>
                        <span>Unggah Berkas Dokumen Materi</span>
                    </h3>
                    <p class="text-xs text-[var(--muted)] mt-0.5" id="docUploadDesc">Pilih berkas PDF atau Word dari komputer Anda.</p>
                </div>
                <span class="text-[11px] font-mono text-[var(--muted)] px-3 py-1 rounded-lg bg-slate-100 border border-[var(--border)]">Maks: 50 MB</span>
            </div>

            <div class="relative border-2 border-dashed border-[var(--border)] hover:border-[var(--blue)] rounded-2xl p-8 text-center bg-slate-50/60 transition-all cursor-pointer"
                 onclick="document.getElementById('documentFileInput').click()">
                <input type="file" 
                       name="document_file" 
                       id="documentFileInput" 
                       accept=".pdf,.doc,.docx,.md,.txt" 
                       class="hidden" 
                       onchange="handleDocumentFileSelected(this)">
                
                <div class="flex flex-col items-center justify-center gap-2">
                    <div class="w-12 h-12 rounded-2xl bg-blue-50 text-[var(--blue)] flex items-center justify-center text-xl mb-1" id="docUploadIcon">
                        <i class="fas fa-file-upload"></i>
                    </div>
                    <div class="text-sm font-bold text-[var(--ink)]" id="docUploadLabel">Klik untuk memilih berkas atau Drag & Drop ke sini</div>
                    <div class="text-xs text-[var(--muted)] font-mono" id="docUploadHint">Mendukung format: .PDF, .DOCX, .DOC</div>
                </div>

                <div id="fileSelectedBadge" class="hidden mt-4 inline-flex items-center gap-3 px-4 py-2 rounded-xl bg-blue-50 border border-blue-200 text-[var(--blue)] text-xs font-mono font-bold">
                    <i class="fas fa-check-circle text-emerald-600"></i>
                    <span id="fileSelectedName">Nama file</span>
                    <span id="fileSelectedSize" class="text-[var(--muted)] font-normal">0 KB</span>
                </div>
            </div>
        </div>

        <!-- Meta Information Card -->
        <div class="bg-white border border-[var(--border)] rounded-2xl p-6 mb-6 shadow-sm">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-5">
                <!-- Title -->
                <div class="md:col-span-5">
                    <label class="block text-xs font-bold uppercase tracking-wider text-[var(--ink)] mb-2">
                        Judul Bab Materi <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" 
                           name="title" 
                           id="moduleTitleInput" 
                           value="{{ old('title') }}" 
                           required 
                           placeholder="Contoh: Installation, Editor setup, Styling with utility classes" 
                           class="w-full px-4 py-2.5 bg-slate-50 border border-[var(--border)] rounded-xl font-semibold text-xs text-[var(--ink)] focus:bg-white focus:border-[var(--blue)] focus:outline-none transition">
                </div>

                <!-- Section / Kategori Sidebar -->
                <div class="md:col-span-3">
                    <label class="block text-xs font-bold uppercase tracking-wider text-[var(--ink)] mb-2">
                        Section Sidebar (Grup)
                    </label>
                    <input type="text" 
                           name="section" 
                           list="sectionOptions"
                           value="{{ old('section', 'GETTING STARTED') }}" 
                           placeholder="Contoh: GETTING STARTED, CORE CONCEPTS" 
                           class="w-full px-4 py-2.5 bg-slate-50 border border-[var(--border)] rounded-xl uppercase font-mono text-xs text-amber-700 font-bold focus:bg-white focus:border-[var(--blue)] focus:outline-none transition">
                    <datalist id="sectionOptions">
                        <option value="GETTING STARTED">
                        <option value="CORE CONCEPTS">
                        <option value="BASE STYLES">
                        <option value="LAYOUT">
                        @if(isset($existingSections))
                            @foreach($existingSections as $sec)
                                <option value="{{ $sec }}">
                            @endforeach
                        @endif
                    </datalist>
                </div>

                <!-- Slug -->
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold uppercase tracking-wider text-[var(--ink)] mb-2">
                        Slug URL Bab (Otomatis)
                    </label>
                    <input type="text" 
                           name="slug" 
                           id="moduleSlugInput" 
                           value="{{ old('slug') }}" 
                           placeholder="installation" 
                           class="w-full px-4 py-2.5 bg-slate-50 border border-[var(--border)] rounded-xl font-mono text-xs text-[var(--blue)] focus:bg-white focus:border-[var(--blue)] focus:outline-none transition">
                </div>

                <!-- Order -->
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold uppercase tracking-wider text-[var(--ink)] mb-2">
                        Urutan (Order)
                    </label>
                    <input type="number" 
                           name="order" 
                           value="{{ old('order', ($module->modules()->max('order') ?? 0) + 1) }}" 
                           min="0"
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-[var(--border)] rounded-xl font-mono text-xs text-[var(--ink)] focus:bg-white focus:border-[var(--blue)] focus:outline-none transition">
                </div>

                <!-- Short Excerpt -->
                <div class="md:col-span-12">
                    <label class="block text-xs font-bold uppercase tracking-wider text-[var(--ink)] mb-2">
                        Ringkasan / Excerpt Singkat (Opsional)
                    </label>
                    <input type="text" 
                           name="excerpt" 
                           value="{{ old('excerpt') }}" 
                           placeholder="Deskripsi singkat bab untuk rangkuman dan SEO..." 
                           class="w-full px-4 py-2.5 bg-slate-50 border border-[var(--border)] rounded-xl text-xs text-[var(--ink)] focus:bg-white focus:border-[var(--blue)] focus:outline-none transition">
                </div>

                <!-- Settings Section -->
                <div class="md:col-span-12 pt-4 border-t border-[var(--border)]">
                    <div class="mb-3">
                        <span class="text-[11px] font-extrabold text-[var(--muted)] uppercase tracking-wider flex items-center gap-1.5">
                            <i class="fas fa-sliders-h text-[var(--blue)]"></i> Pengaturan Publikasi & Keamanan Materi
                        </span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <!-- Published Toggle -->
                        <label class="flex items-start gap-3 p-3.5 rounded-xl border border-[var(--border)] bg-slate-50/60 hover:bg-slate-50 cursor-pointer transition select-none">
                            <input type="hidden" name="is_published" value="0">
                            <input type="checkbox" name="is_published" value="1" {{ old('is_published', true) ? 'checked' : '' }} class="mt-0.5 w-4 h-4 rounded text-[var(--blue)] accent-[var(--blue)]">
                            <div>
                                <span class="block text-xs font-bold text-[var(--ink)]">Publikasikan Materi</span>
                                <span class="text-[11px] text-[var(--muted)]">Tampilkan materi di daftar pelajaran modul.</span>
                            </div>
                        </label>

                        <!-- Anti-Screenshot Toggle (Default: Nyala) -->
                        <label class="flex items-start gap-3 p-3.5 rounded-xl border border-emerald-200/80 bg-emerald-50/40 hover:bg-emerald-50/80 cursor-pointer transition select-none">
                            <input type="hidden" name="enable_anti_screenshot" value="0">
                            <input type="checkbox" name="enable_anti_screenshot" value="1" {{ old('enable_anti_screenshot', true) ? 'checked' : '' }} class="mt-0.5 w-4 h-4 rounded text-emerald-600 accent-emerald-600">
                            <div>
                                <span class="block text-xs font-bold text-emerald-800 flex items-center gap-1.5">
                                    <i class="fas fa-camera text-emerald-600"></i> Proteksi Anti-Screenshot
                                </span>
                                <span class="text-[11px] text-emerald-700/80">Blackout otomatis saat PrtScn, Win+Shift+S, Snipping Tool, atau screenshot HP. (Default: Nyala)</span>
                            </div>
                        </label>

                        <!-- Anti-Copy Toggle (Default: Nyala) -->
                        <label class="flex items-start gap-3 p-3.5 rounded-xl border border-sky-200/80 bg-sky-50/40 hover:bg-sky-50/80 cursor-pointer transition select-none">
                            <input type="hidden" name="enable_anti_copy" value="0">
                            <input type="checkbox" name="enable_anti_copy" value="1" {{ old('enable_anti_copy', true) ? 'checked' : '' }} class="mt-0.5 w-4 h-4 rounded text-sky-600 accent-sky-600">
                            <div>
                                <span class="block text-xs font-bold text-sky-800 flex items-center gap-1.5">
                                    <i class="fas fa-copy text-sky-600"></i> Proteksi Anti-Salin Teks
                                </span>
                                <span class="text-[11px] text-sky-700/80">Cegah seleksi teks, blokir klik kanan, dan cegah copy/cut materi (salin kode tetap bisa). (Default: Nyala)</span>
                            </div>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- CMS Editor & Preview Area (Only shown for Markdown) -->
        <div id="cmsEditorContainer" class="bg-white border border-[var(--border)] rounded-2xl p-0 overflow-hidden shadow-sm">

            <!-- CMS Toolbar -->
            <div class="p-3 bg-slate-50 border-b border-[var(--border)] flex flex-wrap items-center justify-between gap-2">
                <div class="flex flex-wrap items-center gap-1.5 text-xs">
                    <div class="flex items-center bg-white rounded-lg p-0.5 border border-[var(--border)] shadow-xs">
                        <button type="button" onclick="insertHeading(1)" class="px-2.5 py-1 text-[var(--body)] hover:text-[var(--ink)] hover:bg-slate-100 rounded font-bold"># H1</button>
                        <button type="button" onclick="insertHeading(2)" class="px-2.5 py-1 text-[var(--body)] hover:text-[var(--ink)] hover:bg-slate-100 rounded font-bold">## H2</button>
                        <button type="button" onclick="insertHeading(3)" class="px-2.5 py-1 text-[var(--body)] hover:text-[var(--ink)] hover:bg-slate-100 rounded font-bold">### H3</button>
                    </div>

                    <div class="flex items-center bg-white rounded-lg p-0.5 border border-[var(--border)] shadow-xs">
                        <button type="button" onclick="wrapText('**', '**')" class="px-2.5 py-1 text-[var(--body)] hover:text-[var(--ink)] hover:bg-slate-100 rounded font-bold"><i class="fas fa-bold"></i></button>
                        <button type="button" onclick="wrapText('*', '*')" class="px-2.5 py-1 text-[var(--body)] hover:text-[var(--ink)] hover:bg-slate-100 rounded italic"><i class="fas fa-italic"></i></button>
                        <button type="button" onclick="wrapText('`', '`')" class="px-2.5 py-1 text-[var(--blue)] hover:bg-slate-100 rounded font-mono">`code`</button>
                    </div>

                    <button type="button" onclick="openCodeModal()" class="px-3 py-1.5 rounded-lg bg-blue-50 hover:bg-blue-100 text-[var(--blue)] border border-blue-200 font-bold flex items-center gap-1.5 transition">
                        <i class="fas fa-code"></i> Kerangka Code Block
                    </button>

                    <button type="button" onclick="insertTableTemplate()" class="px-3 py-1.5 rounded-lg bg-indigo-50 hover:bg-indigo-100 text-indigo-700 border border-indigo-200 font-bold flex items-center gap-1.5 transition">
                        <i class="fas fa-table"></i> Tabel
                    </button>

                    <button type="button" onclick="insertCallout('NOTE')" class="px-2.5 py-1.5 rounded-lg bg-white hover:bg-slate-100 text-[var(--body)] border border-[var(--border)] shadow-xs transition">
                        <i class="fas fa-info-circle text-[var(--blue)] mr-1"></i> Catatan
                    </button>
                    <button type="button" onclick="insertCallout('TIP')" class="px-2.5 py-1.5 rounded-lg bg-white hover:bg-slate-100 text-[var(--body)] border border-[var(--border)] shadow-xs transition">
                        <i class="fas fa-lightbulb text-amber-500 mr-1"></i> Tips
                    </button>

                    <!-- Import .md File Button -->
                    <input type="file" id="mdImportInput" accept=".md,.markdown,.txt" class="hidden" onchange="importMarkdownFile(this)">
                    <button type="button" onclick="document.getElementById('mdImportInput').click()" class="px-3 py-1.5 rounded-lg bg-emerald-50 hover:bg-emerald-100 text-emerald-700 border border-emerald-200 font-bold flex items-center gap-1.5 transition ml-auto">
                        <i class="fas fa-file-import"></i>
                        <span>Import Berkas .md</span>
                    </button>
                </div>
            </div>

            <!-- Main Editor Panes (Split / Full) -->
            <div class="grid grid-cols-1 lg:grid-cols-2 divide-y lg:divide-y-0 lg:divide-x divide-[var(--border)] min-h-[580px]" id="editorSplitGrid">
                
                <!-- Left: Markdown Input Textarea -->
                <div class="flex flex-col bg-slate-900 text-slate-100" id="editorPane">
                    <div class="px-4 py-2 border-b border-slate-800 bg-slate-950 text-[11px] font-mono text-slate-400 flex items-center justify-between">
                        <span id="editorPaneLabel">MARKDOWN SOURCE</span>
                        <span id="charCount">0 Karakter</span>
                    </div>
                    <textarea name="content" 
                              id="markdownInput" 
                              class="flex-1 w-full bg-transparent p-4 font-mono text-[13.5px] leading-relaxed text-slate-100 resize-none focus:outline-none border-none selection:bg-blue-600/40 min-h-[500px]"
                              placeholder="# Tuliskan judul bab materi Anda di sini...&#10;&#10;Jelaskan materi dengan format markdown, sisipkan kerangka kode menggunakan tombol di toolbar, atau import berkas .md langsung.">{{ old('content') }}</textarea>
                </div>

                <!-- Right: Live Formatted Preview (Tailwind Docs Aesthetic) -->
                <div class="flex flex-col bg-slate-950" id="previewPane">
                    <div class="px-4 py-2 border-b border-slate-800 bg-slate-900 text-[11px] font-mono text-cyan-400 flex items-center justify-between">
                        <span>LIVE PREVIEW DOKUMENTASI</span>
                        <span class="text-xs text-slate-400 flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span> Sinkronisasi Real-time
                        </span>
                    </div>
                    <div id="previewContent" class="flex-1 p-6 overflow-y-auto max-h-[700px] module-body text-[14.5px] leading-relaxed text-slate-300">
                        <div class="text-slate-500 italic text-sm">Preview tampilan bab akan muncul di sini secara langsung...</div>
                    </div>
                </div>

            </div>
        </div>
    </form>
</div>

<!-- Modal: Code Block Inserter -->
<div id="codeModal" class="fixed inset-0 z-50 hidden bg-black/60 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white border border-[var(--border)] rounded-2xl w-full max-w-lg shadow-2xl p-6">
        <h3 class="text-base font-bold text-[var(--ink)] mb-4">Sisipkan Kerangka Code Block</h3>
        <div class="space-y-4">
            <div>
                <label class="block text-xs font-bold text-[var(--ink)] mb-1">Bahasa Pemrograman</label>
                <select id="codeLangSelect" class="w-full px-3.5 py-2 bg-slate-50 border border-[var(--border)] rounded-xl text-xs text-[var(--ink)] focus:bg-white focus:border-[var(--blue)] focus:outline-none transition">
                    <option value="html">HTML</option>
                    <option value="css">CSS</option>
                    <option value="javascript">JavaScript</option>
                    <option value="php">PHP / Blade</option>
                    <option value="go">Go / Golang</option>
                    <option value="python">Python</option>
                    <option value="bash">Terminal (Bash)</option>
                    <option value="json">JSON</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-bold text-[var(--ink)] mb-1">Nama File / Label Header (Opsional)</label>
                <input type="text" id="codeFileNameInput" placeholder="index.html, style.css, script.js" class="w-full px-3.5 py-2 bg-slate-50 border border-[var(--border)] rounded-xl text-xs font-mono text-[var(--ink)] focus:bg-white focus:border-[var(--blue)] focus:outline-none transition">
            </div>
            <div>
                <label class="block text-xs font-bold text-[var(--ink)] mb-1">Kode Sumber</label>
                <textarea id="codeSnippetInput" rows="6" placeholder="// Tuliskan baris kode di sini..." class="w-full p-3 bg-slate-900 border border-slate-700 rounded-xl text-xs font-mono text-slate-100 focus:outline-none"></textarea>
            </div>
        </div>
        <div class="mt-6 flex justify-end gap-3 pt-3 border-t border-[var(--border)]">
            <button type="button" onclick="closeCodeModal()" class="btn-outline px-4 py-2 rounded-xl text-xs font-bold">Batal</button>
            <button type="button" onclick="insertCodeSnippet()" class="btn-gradient px-4 py-2 rounded-xl text-white text-xs font-bold shadow-sm">Sisipkan ke Editor</button>
        </div>
    </div>
</div>

<script>
    const textarea = document.getElementById('markdownInput');
    const preview = document.getElementById('previewContent');
    const charCount = document.getElementById('charCount');
    let previewDebounce = null;

    function updatePreview() {
        clearTimeout(previewDebounce);
        previewDebounce = setTimeout(() => {
            const rawContent = textarea.value;
            charCount.innerText = rawContent.length + ' Karakter';

            fetch("{{ route('admin.modules.preview') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ content: rawContent })
            })
            .then(res => res.json())
            .then(data => {
                preview.innerHTML = data.html || '<div class="text-slate-500 italic text-sm">Preview tampilan bab akan muncul di sini...</div>';
            });
        }, 300);
    }

    textarea.addEventListener('input', updatePreview);
    updatePreview();

    function setViewMode(mode) {
        const grid = document.getElementById('editorSplitGrid');
        const editorPane = document.getElementById('editorPane');
        const previewPane = document.getElementById('previewPane');
        const btnSplit = document.getElementById('btnViewSplit');
        const btnEditor = document.getElementById('btnViewEditor');
        const btnPreview = document.getElementById('btnViewPreview');

        [btnSplit, btnEditor, btnPreview].forEach(b => {
            if (b) b.className = 'px-3 py-1.5 rounded-lg hover:text-[var(--ink)]';
        });

        if (mode === 'split') {
            grid.className = 'grid grid-cols-1 lg:grid-cols-2 divide-y lg:divide-y-0 lg:divide-x divide-[var(--border)] min-h-[580px]';
            editorPane.classList.remove('hidden');
            previewPane.classList.remove('hidden');
            if (btnSplit) btnSplit.className = 'px-3 py-1.5 rounded-lg bg-white text-[var(--blue)] font-bold shadow-xs';
        } else if (mode === 'editor') {
            grid.className = 'grid grid-cols-1 min-h-[580px]';
            editorPane.classList.remove('hidden');
            previewPane.classList.add('hidden');
            if (btnEditor) btnEditor.className = 'px-3 py-1.5 rounded-lg bg-white text-[var(--blue)] font-bold shadow-xs';
        } else if (mode === 'preview') {
            grid.className = 'grid grid-cols-1 min-h-[580px]';
            editorPane.classList.add('hidden');
            previewPane.classList.remove('hidden');
            if (btnPreview) btnPreview.className = 'px-3 py-1.5 rounded-lg bg-white text-[var(--blue)] font-bold shadow-xs';
        }
    }

    function insertHeading(level) {
        insertLinePrefix('#'.repeat(level) + ' ');
    }

    function insertLinePrefix(prefix) {
        const start = textarea.selectionStart;
        const value = textarea.value;
        const lineStart = value.lastIndexOf('\n', start - 1) + 1;
        textarea.value = value.substring(0, lineStart) + prefix + value.substring(lineStart);
        textarea.focus();
        updatePreview();
    }

    function wrapText(before, after) {
        const start = textarea.selectionStart;
        const end = textarea.selectionEnd;
        const selected = textarea.value.substring(start, end) || 'teks';
        textarea.value = textarea.value.substring(0, start) + before + selected + after + textarea.value.substring(end);
        textarea.focus();
        updatePreview();
    }

    function insertContent(text) {
        const start = textarea.selectionStart;
        textarea.value = textarea.value.substring(0, start) + text + textarea.value.substring(start);
        textarea.focus();
        updatePreview();
    }

    function insertCallout(type) {
        insertContent(`\n> [!${type}]\n> Tuliskan catatan penting Anda di sini.\n\n`);
    }

    function insertTableTemplate() {
        const table = `\n| Judul Kolom 1 | Judul Kolom 2 | Judul Kolom 3 |\n| :--- | :--- | :--- |\n| Baris 1 Kolom 1 | Baris 1 Kolom 2 | Baris 1 Kolom 3 |\n| Baris 2 Kolom 1 | Baris 2 Kolom 2 | Baris 2 Kolom 3 |\n\n`;
        insertContent(table);
    }

    function openCodeModal() {
        document.getElementById('codeModal').classList.remove('hidden');
        document.getElementById('codeSnippetInput').focus();
    }

    function closeCodeModal() {
        document.getElementById('codeModal').classList.add('hidden');
    }

    function insertCodeSnippet() {
        const lang = document.getElementById('codeLangSelect').value;
        const filename = document.getElementById('codeFileNameInput').value.trim();
        const code = document.getElementById('codeSnippetInput').value;

        const header = filename ? `\`\`\`${lang}:${filename}\n` : `\`\`\`${lang}\n`;
        insertContent(`\n${header}${code}\n\`\`\`\n\n`);
        closeCodeModal();
    }

    document.getElementById('moduleTitleInput').addEventListener('input', function(e) {
        const slugInput = document.getElementById('moduleSlugInput');
        if (!slugInput.value || slugInput.dataset.manual !== 'true') {
            slugInput.value = e.target.value.toLowerCase().trim()
                .replace(/[^\w\s-]/g, '')
                .replace(/[\s_-]+/g, '-')
                .replace(/^-+|-+$/g, '');
        }
    });

    document.getElementById('moduleSlugInput').addEventListener('input', function() {
        this.dataset.manual = 'true';
    });

    // Content Type Handling (Markdown, PDF, Word, PPT)
    function selectContentType(type) {
        document.getElementById('contentTypeInput').value = type;

        const cardMd = document.getElementById('typeCardMarkdown');
        const cardPdf = document.getElementById('typeCardPdf');
        const cardWord = document.getElementById('typeCardWord');
        const cardPpt = document.getElementById('typeCardPpt');
        const uploadSection = document.getElementById('documentUploadSection');
        const docFileInput = document.getElementById('documentFileInput');
        const cmsEditor = document.getElementById('cmsEditorContainer');
        const viewButtons = document.getElementById('viewModeButtonsGroup');

        const activeClasses = ['border-[var(--blue)]', 'bg-white', 'shadow-sm'];
        const inactiveClasses = ['border-[var(--border)]', 'bg-slate-50', 'opacity-80'];

        [cardMd, cardPdf, cardWord, cardPpt].forEach(card => {
            if (!card) return;
            activeClasses.forEach(c => card.classList.remove(c));
            card.classList.remove('border-rose-400', 'border-sky-400', 'border-amber-400');
            inactiveClasses.forEach(c => card.classList.add(c));
        });

        if (type === 'markdown') {
            inactiveClasses.forEach(c => cardMd.classList.remove(c));
            activeClasses.forEach(c => cardMd.classList.add(c));
            uploadSection.classList.add('hidden');
            if (cmsEditor) cmsEditor.classList.remove('hidden');
            if (viewButtons) viewButtons.classList.remove('hidden');
        } else {
            if (cmsEditor) cmsEditor.classList.add('hidden');
            if (viewButtons) viewButtons.classList.add('hidden');
            uploadSection.classList.remove('hidden');

            if (type === 'pdf') {
                inactiveClasses.forEach(c => cardPdf.classList.remove(c));
                cardPdf.classList.add('border-rose-400', 'bg-white', 'shadow-sm');
                docFileInput.accept = '.pdf';
                document.getElementById('docUploadTitle').innerHTML = '<i class="fas fa-file-pdf text-rose-500"></i><span>Unggah Dokumen PDF Materi</span>';
                document.getElementById('docUploadDesc').innerText = 'Pilih file PDF yang akan ditampilkan melalui Digital PDF Viewer.';
                document.getElementById('docUploadHint').innerText = 'Format berkas: .PDF (Maksimal 50 MB)';
            } else if (type === 'word') {
                inactiveClasses.forEach(c => cardWord.classList.remove(c));
                cardWord.classList.add('border-sky-400', 'bg-white', 'shadow-sm');
                docFileInput.accept = '.doc,.docx';
                document.getElementById('docUploadTitle').innerHTML = '<i class="fas fa-file-word text-sky-500"></i><span>Unggah Berkas Microsoft Word</span>';
                document.getElementById('docUploadDesc').innerText = 'Pilih berkas Word (.docx atau .doc) untuk materi bab ini.';
                document.getElementById('docUploadHint').innerText = 'Format berkas: .DOCX, .DOC (Maksimal 50 MB)';
            } else if (type === 'ppt') {
                inactiveClasses.forEach(c => cardPpt.classList.remove(c));
                cardPpt.classList.add('border-amber-400', 'bg-white', 'shadow-sm');
                docFileInput.accept = '.ppt,.pptx';
                document.getElementById('docUploadTitle').innerHTML = '<i class="fas fa-file-powerpoint text-amber-500"></i><span>Unggah Berkas PowerPoint</span>';
                document.getElementById('docUploadDesc').innerText = 'Pilih berkas PowerPoint (.pptx atau .ppt) untuk slide presentasi materi ini.';
                document.getElementById('docUploadHint').innerText = 'Format berkas: .PPTX, .PPT (Maksimal 50 MB)';
            }
        }
    }

    function handleDocumentFileSelected(input) {
        if (!input.files || input.files.length === 0) return;
        const file = input.files[0];
        
        document.getElementById('fileSelectedBadge').classList.remove('hidden');
        document.getElementById('fileSelectedName').innerText = file.name;
        
        let sizeStr = (file.size / 1024).toFixed(0) + ' KB';
        if (file.size >= 1048576) {
            sizeStr = (file.size / 1048576).toFixed(2) + ' MB';
        }
        document.getElementById('fileSelectedSize').innerText = sizeStr;

        const titleInput = document.getElementById('moduleTitleInput');
        if (!titleInput.value.trim()) {
            const cleanName = file.name.replace(/\.[^/.]+$/, '').replace(/[-_]/g, ' ');
            titleInput.value = cleanName.charAt(0).toUpperCase() + cleanName.slice(1);
            titleInput.dispatchEvent(new Event('input'));
        }
    }

    function importMarkdownFile(input) {
        if (!input.files || input.files.length === 0) return;
        const file = input.files[0];
        const reader = new FileReader();

        reader.onload = function(e) {
            const content = e.target.result;
            const textarea = document.getElementById('markdownInput');
            textarea.value = content;
            textarea.dispatchEvent(new Event('input'));

            const titleInput = document.getElementById('moduleTitleInput');
            if (!titleInput.value.trim()) {
                const headingMatch = content.match(/^#\s+(.+)$/m);
                if (headingMatch && headingMatch[1]) {
                    titleInput.value = headingMatch[1].trim();
                } else {
                    const cleanName = file.name.replace(/\.[^/.]+$/, '').replace(/[-_]/g, ' ');
                    titleInput.value = cleanName.charAt(0).toUpperCase() + cleanName.slice(1);
                }
                titleInput.dispatchEvent(new Event('input'));
            }

            selectContentType('markdown');
            alert('File Markdown "' + file.name + '" berhasil dimuat ke editor!');
        };

        reader.readAsText(file);
    }

    document.getElementById('moduleForm').addEventListener('submit', function() {
        const textarea = document.getElementById('markdownInput');
        if (textarea && textarea.value.trim() && !textarea.value.startsWith('base64:')) {
            try {
                textarea.value = 'base64:' + btoa(unescape(encodeURIComponent(textarea.value)));
            } catch (e) {
                console.error('Encoding error:', e);
            }
        }
    });

    document.addEventListener('DOMContentLoaded', function() {
        const initialType = document.getElementById('contentTypeInput').value || 'markdown';
        selectContentType(initialType);
    });
</script>
@endsection
