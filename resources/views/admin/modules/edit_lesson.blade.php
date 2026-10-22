@extends('layouts.app')

@section('title', 'Edit Bab: ' . $lesson->title)

@section('content')
<div class="max-w-[96rem] mx-auto px-4 py-6">

    <form action="{{ route('admin.modules.contents.update', ['module' => $module->id, 'content' => $lesson->id]) }}" method="POST" enctype="multipart/form-data" id="moduleForm">
        @csrf
        @method('PUT')

        <!-- Top Header & Action Buttons -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6 pb-4 border-b border-slate-800">
            <div>
                <div class="flex items-center gap-2 text-xs font-mono text-[var(--accent)] uppercase tracking-wider mb-1">
                    <a href="{{ route('admin.modules.index') }}" class="hover:underline">MODULE MANAGER</a>
                    <i class="fas fa-chevron-right text-[10px]"></i>
                    <a href="{{ route('admin.modules.contents.index', $module->id) }}" class="hover:underline">{{ $module->name }}</a>
                    <i class="fas fa-chevron-right text-[10px]"></i>
                    <span class="text-white">EDIT BAB</span>
                </div>
                <h1 class="text-xl sm:text-2xl font-extrabold text-white tracking-tight">
                    Edit Bab: <span class="text-cyan-400">{{ $lesson->title }}</span>
                </h1>
            </div>

            <div class="flex items-center gap-3">
                <!-- View Mode Buttons -->
                <div class="hidden sm:inline-flex p-1 rounded-xl bg-slate-900 border border-slate-800 text-xs font-semibold text-slate-400">
                    <button type="button" onclick="setViewMode('split')" id="btnViewSplit" class="px-3 py-1.5 rounded-lg bg-cyan-500/20 text-cyan-300">
                        <i class="fas fa-columns mr-1"></i> Split View
                    </button>
                    <button type="button" onclick="setViewMode('editor')" id="btnViewEditor" class="px-3 py-1.5 rounded-lg hover:text-white">
                        <i class="fas fa-code mr-1"></i> Editor
                    </button>
                    <button type="button" onclick="setViewMode('preview')" id="btnViewPreview" class="px-3 py-1.5 rounded-lg hover:text-white">
                        <i class="fas fa-eye mr-1"></i> Preview
                    </button>
                </div>

                <a href="{{ route('admin.modules.contents.index', $module->id) }}" class="px-4 py-2 rounded-xl border border-[var(--border)] text-slate-300 hover:text-white text-xs font-semibold">
                    Batal
                </a>

                <button type="submit" class="cyber-btn text-xs flex items-center gap-2">
                    <i class="fas fa-save"></i>
                    <span>Simpan Perubahan</span>
                </button>
            </div>
        </div>

        @if(isset($errors) && $errors->any())
            <div class="mb-6 p-4 rounded-xl border border-rose-500/30 bg-rose-950/20 text-rose-400 text-sm">
                <ul class="list-disc pl-5 space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @php
            $currentType = old('content_type', $lesson->content_type ?: ($lesson->isPdf() ? 'pdf' : ($lesson->isWord() ? 'word' : 'markdown')));
        @endphp

        <!-- Pilihan Format Konten Bab Materi (Markdown / PDF / Word) -->
        <input type="hidden" name="content_type" id="contentTypeInput" value="{{ $currentType }}">

        <div class="mb-6">
            <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-3 flex items-center gap-2">
                <i class="fas fa-shapes text-cyan-400"></i>
                <span>Format Penyajian Bab Materi:</span>
            </label>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Option 1: Markdown (.md) / Manual -->
                <div onclick="selectContentType('markdown')" 
                     id="typeCardMarkdown" 
                     class="p-4 rounded-2xl border-2 cursor-pointer transition-all bg-slate-900/80 hover:bg-slate-900 {{ $currentType === 'markdown' ? 'border-cyan-500/80 shadow-lg shadow-cyan-500/10' : 'border-slate-800 opacity-80' }}">
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 rounded-xl bg-cyan-500/15 border border-cyan-500/30 text-cyan-300 flex items-center justify-center text-lg shrink-0">
                            <i class="fab fa-markdown"></i>
                        </div>
                        <div>
                            <div class="flex items-center gap-2">
                                <h3 class="text-sm font-bold text-white">1. Markdown (.md) / Manual</h3>
                                <span class="text-[9px] font-mono px-1.5 py-0.5 rounded bg-cyan-950 text-cyan-300 border border-cyan-800">INTERAKTIF</span>
                            </div>
                            <p class="text-xs text-slate-400 mt-1 leading-relaxed">
                                Tulis manual dengan syntax markdown, code block, tabel, atau import file <code class="text-cyan-300">.md</code>.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Option 2: PDF Document -->
                <div onclick="selectContentType('pdf')" 
                     id="typeCardPdf" 
                     class="p-4 rounded-2xl border-2 cursor-pointer transition-all bg-slate-900/80 hover:bg-slate-900 {{ $currentType === 'pdf' ? 'border-rose-500/80 shadow-lg shadow-rose-500/10' : 'border-slate-800 opacity-80' }}">
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 rounded-xl bg-rose-500/15 border border-rose-500/30 text-rose-300 flex items-center justify-center text-lg shrink-0">
                            <i class="fas fa-file-pdf"></i>
                        </div>
                        <div>
                            <div class="flex items-center gap-2">
                                <h3 class="text-sm font-bold text-white">2. Dokumen PDF (.pdf)</h3>
                                <span class="text-[9px] font-mono px-1.5 py-0.5 rounded bg-rose-950 text-rose-300 border border-rose-800">DIGITAL VIEWER</span>
                            </div>
                            <p class="text-xs text-slate-400 mt-1 leading-relaxed">
                                Tampilkan dokumen PDF materi dengan pembaca dokumen digital interaktif di browser.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Option 3: Word Document -->
                <div onclick="selectContentType('word')" 
                     id="typeCardWord" 
                     class="p-4 rounded-2xl border-2 cursor-pointer transition-all bg-slate-900/80 hover:bg-slate-900 {{ $currentType === 'word' ? 'border-sky-500/80 shadow-lg shadow-sky-500/10' : 'border-slate-800 opacity-80' }}">
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 rounded-xl bg-sky-500/15 border border-sky-500/30 text-sky-300 flex items-center justify-center text-lg shrink-0">
                            <i class="fas fa-file-word"></i>
                        </div>
                        <div>
                            <div class="flex items-center gap-2">
                                <h3 class="text-sm font-bold text-white">3. Microsoft Word (.docx/.doc)</h3>
                                <span class="text-[9px] font-mono px-1.5 py-0.5 rounded bg-sky-950 text-sky-300 border border-sky-800">OFFICE</span>
                            </div>
                            <p class="text-xs text-slate-400 mt-1 leading-relaxed">
                                Upload materi format Microsoft Word. Peserta dapat membaca rangkuman serta mengunduh dokumen.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Document File Upload Box (Shown for PDF & Word, or optional companion) -->
        <div id="documentUploadSection" class="cyber-card p-5 mb-6 {{ $currentType === 'markdown' && empty($lesson->file_path) ? 'hidden' : '' }}">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 pb-3 mb-4 border-b border-slate-800">
                <div>
                    <h3 class="text-sm font-bold text-white flex items-center gap-2" id="docUploadTitle">
                        <i class="fas fa-cloud-upload-alt text-cyan-400"></i>
                        <span>Berkas Dokumen Materi</span>
                    </h3>
                    <p class="text-xs text-slate-400 mt-0.5" id="docUploadDesc">Ganti atau unggah berkas dokumen PDF / Word untuk bab materi ini.</p>
                </div>
                <span class="text-[11px] font-mono text-slate-400 px-2.5 py-1 rounded bg-slate-900 border border-slate-800">Maks: 50 MB</span>
            </div>

            @if(!empty($lesson->file_path))
                <div class="mb-4 p-3 rounded-xl bg-slate-900 border border-slate-700/80 flex items-center justify-between gap-3">
                    <div class="flex items-center gap-3">
                        <i class="{{ $lesson->isPdf() ? 'fas fa-file-pdf text-rose-400' : ($lesson->isWord() ? 'fas fa-file-word text-sky-400' : 'fas fa-file-alt text-purple-400') }} text-lg"></i>
                        <div>
                            <div class="text-xs font-bold text-white truncate max-w-xs sm:max-w-md">
                                Berkas Terpasang: <span class="text-cyan-300">{{ $lesson->file_name ?? basename($lesson->file_path) }}</span>
                            </div>
                            <div class="text-[10px] text-slate-400 font-mono">{{ $lesson->formatted_file_size }}</div>
                        </div>
                    </div>
                    <a href="{{ $lesson->file_url }}" target="_blank" class="px-2.5 py-1 rounded text-[11px] font-semibold bg-slate-800 hover:bg-slate-700 text-slate-300 hover:text-white border border-slate-700">
                        Pratinjau
                    </a>
                </div>
            @endif

            <div class="relative border-2 border-dashed border-slate-700 hover:border-cyan-500/60 rounded-2xl p-6 text-center bg-slate-950/40 transition-all cursor-pointer"
                 onclick="document.getElementById('documentFileInput').click()">
                <input type="file" 
                       name="document_file" 
                       id="documentFileInput" 
                       accept=".pdf,.doc,.docx,.md,.txt" 
                       class="hidden" 
                       onchange="handleDocumentFileSelected(this)">
                
                <div class="flex flex-col items-center justify-center gap-2">
                    <div class="w-12 h-12 rounded-2xl bg-cyan-500/10 text-cyan-400 flex items-center justify-center text-xl mb-1" id="docUploadIcon">
                        <i class="fas fa-file-upload"></i>
                    </div>
                    <div class="text-sm font-bold text-white" id="docUploadLabel">
                        {{ !empty($lesson->file_path) ? 'Klik untuk mengganti dengan berkas baru' : 'Klik untuk memilih berkas atau Drag & Drop ke sini' }}
                    </div>
                    <div class="text-xs text-slate-400 font-mono" id="docUploadHint">Mendukung format: .PDF, .DOCX, .DOC</div>
                </div>

                <div id="fileSelectedBadge" class="hidden mt-4 inline-flex items-center gap-3 px-4 py-2 rounded-xl bg-cyan-500/15 border border-cyan-500/30 text-cyan-300 text-xs font-mono font-bold">
                    <i class="fas fa-check-circle text-emerald-400"></i>
                    <span id="fileSelectedName">Nama file baru</span>
                    <span id="fileSelectedSize" class="text-slate-400 font-normal">0 KB</span>
                </div>
            </div>
        </div>

        <!-- Meta Information Card -->
        <div class="cyber-card p-5 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-5">
                <!-- Title -->
                <div class="md:col-span-5">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">
                        Judul Bab Materi <span class="text-rose-400">*</span>
                    </label>
                    <input type="text" 
                           name="title" 
                           id="moduleTitleInput" 
                           value="{{ old('title', $lesson->title) }}" 
                           required 
                           class="cyber-input font-semibold text-white">
                </div>

                <!-- Section / Kategori Sidebar -->
                <div class="md:col-span-3">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">
                        Section Sidebar (Grup)
                    </label>
                    <input type="text" 
                           name="section" 
                           list="sectionOptions"
                           value="{{ old('section', $lesson->section ?: 'GETTING STARTED') }}" 
                           placeholder="Contoh: GETTING STARTED, CORE CONCEPTS" 
                           class="cyber-input uppercase font-mono text-xs text-amber-300">
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
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">
                        Slug URL Bab
                    </label>
                    <input type="text" 
                           name="slug" 
                           id="moduleSlugInput" 
                           value="{{ old('slug', $lesson->slug) }}" 
                           required
                           class="cyber-input font-mono text-xs text-cyan-300">
                </div>

                <!-- Order -->
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">
                        Urutan (Order)
                    </label>
                    <input type="number" 
                           name="order" 
                           value="{{ old('order', $lesson->order) }}" 
                           min="0"
                           class="cyber-input font-mono">
                </div>

                <!-- Short Excerpt -->
                <div class="md:col-span-12">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">
                        Ringkasan / Excerpt Singkat (Opsional)
                    </label>
                    <input type="text" 
                           name="excerpt" 
                           value="{{ old('excerpt', $lesson->excerpt) }}" 
                           class="cyber-input">
                </div>

                <!-- Settings Toggles -->
                <div class="md:col-span-12 flex flex-wrap items-center gap-8 pt-3 border-t border-[var(--border)]">
                    <label class="flex items-center gap-3 cursor-pointer select-none">
                        <input type="hidden" name="is_published" value="0">
                        <input type="checkbox" name="is_published" value="1" {{ old('is_published', $lesson->is_published) ? 'checked' : '' }} class="w-4 h-4 rounded text-cyan-500 bg-slate-800 border-slate-700">
                        <span class="text-xs font-bold text-white uppercase tracking-wider">Publikasikan Bab Ini</span>
                    </label>

                    <label class="flex items-center gap-3 cursor-pointer select-none">
                        <input type="hidden" name="enable_protection" value="0">
                        <input type="checkbox" name="enable_protection" value="1" {{ old('enable_protection', $lesson->enable_protection) ? 'checked' : '' }} class="w-4 h-4 rounded text-cyan-500 bg-slate-800 border-slate-700">
                        <span class="text-xs font-bold text-emerald-400 uppercase tracking-wider flex items-center gap-1.5">
                            <i class="fas fa-shield-alt"></i> Proteksi Anti-Screenshot & Anti-Inspect
                        </span>
                    </label>
                </div>
            </div>
        </div>

        <!-- CMS Editor & Preview Area -->
        <div class="cyber-card p-0 overflow-hidden">

            <!-- CMS Toolbar -->
            <div class="p-3 bg-[#0e1628] border-b border-slate-800 flex flex-wrap items-center justify-between gap-2">
                <div class="flex flex-wrap items-center gap-1.5 text-xs">
                    <div class="flex items-center bg-slate-900/90 rounded-lg p-0.5 border border-slate-800">
                        <button type="button" onclick="insertHeading(1)" class="px-2.5 py-1 text-slate-300 hover:text-white hover:bg-slate-800 rounded font-bold"># H1</button>
                        <button type="button" onclick="insertHeading(2)" class="px-2.5 py-1 text-slate-300 hover:text-white hover:bg-slate-800 rounded font-bold">## H2</button>
                        <button type="button" onclick="insertHeading(3)" class="px-2.5 py-1 text-slate-300 hover:text-white hover:bg-slate-800 rounded font-bold">### H3</button>
                    </div>

                    <div class="flex items-center bg-slate-900/90 rounded-lg p-0.5 border border-slate-800">
                        <button type="button" onclick="wrapText('**', '**')" class="px-2.5 py-1 text-slate-300 hover:text-white hover:bg-slate-800 rounded font-bold"><i class="fas fa-bold"></i></button>
                        <button type="button" onclick="wrapText('*', '*')" class="px-2.5 py-1 text-slate-300 hover:text-white hover:bg-slate-800 rounded italic"><i class="fas fa-italic"></i></button>
                        <button type="button" onclick="wrapText('`', '`')" class="px-2.5 py-1 text-cyan-400 hover:text-cyan-300 hover:bg-slate-800 rounded font-mono">`code`</button>
                    </div>

                    <button type="button" onclick="openCodeModal()" class="px-3 py-1.5 rounded-lg bg-cyan-500/15 hover:bg-cyan-500/25 text-cyan-300 border border-cyan-500/30 font-semibold flex items-center gap-1.5 transition">
                        <i class="fas fa-code"></i> Kerangka Code Block
                    </button>

                    <button type="button" onclick="insertTableTemplate()" class="px-3 py-1.5 rounded-lg bg-purple-500/15 hover:bg-purple-500/25 text-purple-300 border border-purple-500/30 font-semibold flex items-center gap-1.5 transition">
                        <i class="fas fa-table"></i> Tabel
                    </button>

                    <button type="button" onclick="insertCallout('NOTE')" class="px-2.5 py-1.5 rounded-lg bg-slate-900 hover:bg-slate-800 text-slate-300 hover:text-white border border-slate-800 transition">
                        <i class="fas fa-info-circle text-sky-400 mr-1"></i> Catatan
                    </button>
                    <button type="button" onclick="insertCallout('TIP')" class="px-2.5 py-1.5 rounded-lg bg-slate-900 hover:bg-slate-800 text-slate-300 hover:text-white border border-slate-800 transition">
                        <i class="fas fa-lightbulb text-emerald-400 mr-1"></i> Tips
                    </button>

                    <!-- Import .md File Button -->
                    <input type="file" id="mdImportInput" accept=".md,.markdown,.txt" class="hidden" onchange="importMarkdownFile(this)">
                    <button type="button" onclick="document.getElementById('mdImportInput').click()" class="px-3 py-1.5 rounded-lg bg-emerald-500/15 hover:bg-emerald-500/25 text-emerald-300 border border-emerald-500/30 font-semibold flex items-center gap-1.5 transition ml-auto">
                        <i class="fas fa-file-import"></i>
                        <span>Import Berkas .md</span>
                    </button>
                </div>
            </div>

            <!-- Main Editor Panes -->
            <div class="grid grid-cols-1 lg:grid-cols-2 divide-y lg:divide-y-0 lg:divide-x divide-slate-800 min-h-[580px]" id="editorSplitGrid">
                
                <!-- Left: Markdown Input Textarea -->
                <div class="flex flex-col bg-[#080d1a]" id="editorPane">
                    <div class="px-4 py-2 border-b border-slate-800/80 bg-slate-950/40 text-[11px] font-mono text-slate-400 flex items-center justify-between">
                        <span id="editorPaneLabel">MARKDOWN SOURCE</span>
                        <span id="charCount">0 Karakter</span>
                    </div>
                    <textarea name="content" 
                              id="markdownInput" 
                              class="flex-1 w-full bg-transparent p-4 font-mono text-[13.5px] leading-relaxed text-slate-200 resize-none focus:outline-none border-none selection:bg-cyan-500/30 selection:text-cyan-200 min-h-[500px]"
                              placeholder="# Tuliskan judul bab materi Anda di sini...&#10;&#10;Jelaskan materi dengan format markdown, sisipkan kerangka kode menggunakan tombol di toolbar, atau import berkas .md langsung.">{{ old('content', $lesson->content) }}</textarea>
                </div>

                <!-- Right: Live Formatted Preview -->
                <div class="flex flex-col bg-[#0b1120]" id="previewPane">
                    <div class="px-4 py-2 border-b border-slate-800/80 bg-slate-950/40 text-[11px] font-mono text-cyan-400 flex items-center justify-between">
                        <span>LIVE PREVIEW DOKUMENTASI</span>
                        <span class="text-xs text-slate-500 flex items-center gap-1.5">
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
<div id="codeModal" class="fixed inset-0 z-50 hidden bg-black/80 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-slate-900 border border-slate-700/80 rounded-2xl w-full max-w-lg shadow-2xl p-6">
        <h3 class="text-base font-bold text-white mb-4">Sisipkan Kerangka Code Block</h3>
        <div class="space-y-4">
            <div>
                <label class="block text-xs font-bold text-slate-300 mb-1">Bahasa Pemrograman</label>
                <select id="codeLangSelect" class="cyber-input text-xs">
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
                <label class="block text-xs font-bold text-slate-300 mb-1">Nama File / Label Header (Opsional)</label>
                <input type="text" id="codeFileNameInput" placeholder="index.html, style.css, script.js" class="cyber-input text-xs font-mono">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-300 mb-1">Kode Sumber</label>
                <textarea id="codeSnippetInput" rows="6" class="cyber-input text-xs font-mono"></textarea>
            </div>
        </div>
        <div class="mt-6 flex justify-end gap-3">
            <button type="button" onclick="closeCodeModal()" class="px-4 py-2 rounded-lg text-xs font-semibold text-slate-400 hover:text-white">Batal</button>
            <button type="button" onclick="insertCodeSnippet()" class="cyber-btn text-xs">Sisipkan ke Editor</button>
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

        if (mode === 'split') {
            grid.className = 'grid grid-cols-1 lg:grid-cols-2 divide-y lg:divide-y-0 lg:divide-x divide-slate-800 min-h-[580px]';
            editorPane.classList.remove('hidden');
            previewPane.classList.remove('hidden');
        } else if (mode === 'editor') {
            grid.className = 'grid grid-cols-1 min-h-[580px]';
            editorPane.classList.remove('hidden');
            previewPane.classList.add('hidden');
        } else if (mode === 'preview') {
            grid.className = 'grid grid-cols-1 min-h-[580px]';
            editorPane.classList.add('hidden');
            previewPane.classList.remove('hidden');
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

    // Content Type Handling (Markdown, PDF, Word)
    function selectContentType(type) {
        document.getElementById('contentTypeInput').value = type;

        const cardMd = document.getElementById('typeCardMarkdown');
        const cardPdf = document.getElementById('typeCardPdf');
        const cardWord = document.getElementById('typeCardWord');
        const uploadSection = document.getElementById('documentUploadSection');
        const docFileInput = document.getElementById('documentFileInput');
        const editorLabel = document.getElementById('editorPaneLabel');
        const textarea = document.getElementById('markdownInput');

        const activeClasses = ['border-cyan-500/80', 'bg-slate-900/80', 'shadow-lg', 'shadow-cyan-500/10'];
        const inactiveClasses = ['border-slate-800', 'bg-slate-900/40', 'opacity-80'];

        [cardMd, cardPdf, cardWord].forEach(card => {
            activeClasses.forEach(c => card.classList.remove(c));
            card.classList.remove('border-rose-500/80', 'shadow-rose-500/10', 'border-sky-500/80', 'shadow-sky-500/10');
            inactiveClasses.forEach(c => card.classList.add(c));
        });

        if (type === 'markdown') {
            inactiveClasses.forEach(c => cardMd.classList.remove(c));
            activeClasses.forEach(c => cardMd.classList.add(c));
            uploadSection.classList.add('hidden');
            editorLabel.innerText = 'MARKDOWN SOURCE';
            textarea.placeholder = "# Tuliskan judul bab materi Anda di sini...\n\nJelaskan materi dengan format markdown, sisipkan kerangka kode menggunakan tombol di toolbar, atau import berkas .md langsung.";
        } else if (type === 'pdf') {
            inactiveClasses.forEach(c => cardPdf.classList.remove(c));
            cardPdf.classList.add('border-rose-500/80', 'bg-slate-900/80', 'shadow-lg', 'shadow-rose-500/10');
            uploadSection.classList.remove('hidden');
            docFileInput.accept = '.pdf';
            document.getElementById('docUploadTitle').innerHTML = '<i class="fas fa-file-pdf text-rose-400"></i><span>Berkas Dokumen PDF Materi</span>';
            document.getElementById('docUploadDesc').innerText = 'Ganti atau unggah berkas PDF baru untuk materi ini.';
            document.getElementById('docUploadHint').innerText = 'Format berkas: .PDF (Maksimal 50 MB)';
            editorLabel.innerText = 'CATATAN / RANGKUMAN MATERI (OPSIONAL)';
            textarea.placeholder = "Tuliskan catatan pendukung, ringkasan, atau instruksi pengerjaan dari dokumen PDF ini...";
        } else if (type === 'word') {
            inactiveClasses.forEach(c => cardWord.classList.remove(c));
            cardWord.classList.add('border-sky-500/80', 'bg-slate-900/80', 'shadow-lg', 'shadow-sky-500/10');
            uploadSection.classList.remove('hidden');
            docFileInput.accept = '.doc,.docx';
            document.getElementById('docUploadTitle').innerHTML = '<i class="fas fa-file-word text-sky-400"></i><span>Berkas Dokumen Microsoft Word</span>';
            document.getElementById('docUploadDesc').innerText = 'Ganti atau unggah berkas Word baru (.docx atau .doc) untuk materi bab ini.';
            document.getElementById('docUploadHint').innerText = 'Format berkas: .DOCX, .DOC (Maksimal 50 MB)';
            editorLabel.innerText = 'CATATAN / RANGKUMAN MATERI (OPSIONAL)';
            textarea.placeholder = "Tuliskan ringkasan pokok bahasan dari dokumen Microsoft Word ini...";
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
            selectContentType('markdown');
            alert('File Markdown "' + file.name + '" berhasil dimuat ke editor!');
        };

        reader.readAsText(file);
    }

    // Initialize content type selection on page load
    document.addEventListener('DOMContentLoaded', function() {
        const initialType = document.getElementById('contentTypeInput').value || 'markdown';
        selectContentType(initialType);
    });
</script>
@endsection
