@extends('layouts.app')

@section('title', 'Edit Modul: ' . $module->title)

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/themes/prism-tomorrow.min.css">
<style>
    /* Prism.js Tailwind Docs Custom Colors in Live Preview */
    #previewContent code[class*="language-"], #previewContent pre[class*="language-"] {
        background: transparent !important;
        font-family: 'Fira Code', monospace !important;
        font-size: 13.5px !important;
        text-shadow: none !important;
    }
    #previewContent .token.tag, #previewContent .token.selector, #previewContent .token.deleted { color: #f43f5e !important; }
    #previewContent .token.attr-name { color: #38bdf8 !important; }
    #previewContent .token.attr-value, #previewContent .token.string, #previewContent .token.char, #previewContent .token.inserted { color: #34d399 !important; }
    #previewContent .token.property, #previewContent .token.variable, #previewContent .token.constant { color: #22d3ee !important; }
    #previewContent .token.keyword, #previewContent .token.atrule { color: #c084fc !important; font-weight: 600 !important; }
    #previewContent .token.comment, #previewContent .token.prolog, #previewContent .token.doctype, #previewContent .token.cdata { color: #64748b !important; font-style: italic !important; }
    #previewContent .token.punctuation { color: #94a3b8 !important; }
    #previewContent .token.class-name, #previewContent .token.function { color: #f472b6 !important; }
</style>

<div class="max-w-[96rem] mx-auto px-4 py-6">

    <form id="moduleForm" method="POST" action="{{ route('admin.modules.update', $module->id) }}">
        @csrf
        @method('PUT')

        <!-- Top Header & Save Actions -->
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4 mb-6 pb-6 border-b border-[var(--border)]">
            <div>
                <div class="flex items-center gap-2 text-xs font-mono text-[var(--cyan)] uppercase tracking-wider mb-1">
                    <a href="{{ route('admin.modules.index') }}" class="hover:underline">Modul</a>
                    <i class="fas fa-chevron-right text-[10px]"></i>
                    <span>Edit Modul</span>
                </div>
                <h1 class="text-2xl font-extrabold text-white tracking-tight flex items-center gap-3">
                    <span>Edit: {{ $module->title }}</span>
                    @if($module->is_published)
                        <span class="px-2 py-0.5 rounded text-[11px] font-mono bg-emerald-500/10 text-emerald-400 border border-emerald-500/30">Published</span>
                    @else
                        <span class="px-2 py-0.5 rounded text-[11px] font-mono bg-amber-500/10 text-amber-400 border border-amber-500/30">Draft</span>
                    @endif
                </h1>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <a href="{{ route('modules.show', $module->slug) }}" target="_blank"
                   class="px-3.5 py-1.5 rounded-xl border border-cyan-500/30 bg-cyan-500/10 hover:bg-cyan-500/20 text-cyan-400 text-xs font-bold transition flex items-center gap-2">
                    <i class="fas fa-external-link-alt"></i>
                    <span>Buka di Reader</span>
                </a>

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

                <a href="{{ route('admin.modules.index') }}" class="px-4 py-2 rounded-xl border border-[var(--border)] text-slate-300 hover:text-white text-xs font-semibold">
                    Batal
                </a>

                <button type="submit" class="cyber-btn text-xs flex items-center gap-2">
                    <i class="fas fa-save"></i>
                    <span>Perbarui Modul</span>
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

        <!-- Meta Information Card -->
        <div class="cyber-card p-5 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-5">
                <!-- Title -->
                <div class="md:col-span-6">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">
                        Judul Modul <span class="text-rose-400">*</span>
                    </label>
                    <input type="text" 
                           name="title" 
                           id="moduleTitleInput" 
                           value="{{ old('title', $module->title) }}"
                           required 
                           placeholder="Contoh: Theme variables, Installation" 
                           class="cyber-input font-semibold text-white">
                </div>

                <!-- Category -->
                <div class="md:col-span-4">
                    <div class="flex items-center justify-between mb-2">
                        <label class="text-xs font-bold uppercase tracking-wider text-slate-400">
                            Kategori Sidebar <span class="text-rose-400">*</span>
                        </label>
                        <button type="button" onclick="openInlineCategoryModal()" class="text-[11px] text-cyan-400 hover:underline font-medium">
                            + Kategori Baru
                        </button>
                    </div>
                    <select name="category_id" id="categorySelect" required class="cyber-input">
                        <option value="">Pilih Kategori...</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $module->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Order -->
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">
                        Urutan (Order)
                    </label>
                    <input type="number" 
                           name="order" 
                           value="{{ old('order', $module->order) }}" 
                           min="0"
                           class="cyber-input font-mono">
                </div>

                <!-- Slug -->
                <div class="md:col-span-6">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">
                        Slug URL
                    </label>
                    <input type="text" 
                           name="slug" 
                           id="moduleSlugInput" 
                           value="{{ old('slug', $module->slug) }}"
                           required
                           class="cyber-input font-mono text-xs text-cyan-300">
                </div>

                <!-- Short Excerpt -->
                <div class="md:col-span-6">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">
                        Ringkasan / Excerpt (Opsional)
                    </label>
                    <input type="text" 
                           name="excerpt" 
                           value="{{ old('excerpt', $module->excerpt) }}"
                           placeholder="Deskripsi singkat modul untuk meta & pencarian..." 
                           class="cyber-input">
                </div>

                <!-- Settings Toggles -->
                <div class="md:col-span-12 flex flex-wrap items-center gap-8 pt-3 border-t border-[var(--border)]">
                    <!-- Published Toggle -->
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="is_published" value="1" {{ old('is_published', $module->is_published) ? 'checked' : '' }} class="w-4 h-4 rounded text-cyan-500 bg-slate-800 border-slate-700">
                        <span class="text-xs font-bold text-white uppercase tracking-wider">Publikasikan Modul (Tampil di Website)</span>
                    </label>

                    <!-- Anti-Screenshot & Inspect Toggle -->
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="enable_protection" value="1" {{ old('enable_protection', $module->enable_protection) ? 'checked' : '' }} class="w-4 h-4 rounded text-cyan-500 bg-slate-800 border-slate-700">
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
                <!-- Left Buttons -->
                <div class="flex flex-wrap items-center gap-1.5 text-xs">
                    <!-- Headings -->
                    <div class="flex items-center bg-slate-900/90 rounded-lg p-0.5 border border-slate-800">
                        <button type="button" onclick="insertHeading(1)" class="px-2.5 py-1 text-slate-300 hover:text-white hover:bg-slate-800 rounded font-bold" title="Judul Utama (#)"># H1</button>
                        <button type="button" onclick="insertHeading(2)" class="px-2.5 py-1 text-slate-300 hover:text-white hover:bg-slate-800 rounded font-bold" title="Sub Judul (##)">## H2</button>
                        <button type="button" onclick="insertHeading(3)" class="px-2.5 py-1 text-slate-300 hover:text-white hover:bg-slate-800 rounded font-bold" title="Sub Bagian (###)">### H3</button>
                    </div>

                    <!-- Text Formats -->
                    <div class="flex items-center bg-slate-900/90 rounded-lg p-0.5 border border-slate-800">
                        <button type="button" onclick="wrapText('**', '**')" class="px-2.5 py-1 text-slate-300 hover:text-white hover:bg-slate-800 rounded font-bold" title="Tebal (Bold)"><i class="fas fa-bold"></i></button>
                        <button type="button" onclick="wrapText('*', '*')" class="px-2.5 py-1 text-slate-300 hover:text-white hover:bg-slate-800 rounded italic" title="Miring (Italic)"><i class="fas fa-italic"></i></button>
                        <button type="button" onclick="wrapText('`', '`')" class="px-2.5 py-1 text-cyan-400 hover:text-cyan-300 hover:bg-slate-800 rounded font-mono" title="Inline Code">`code`</button>
                    </div>

                    <!-- Code Block Generator (Kerangka Codingan) -->
                    <button type="button" 
                            onclick="openCodeModal()" 
                            class="px-3 py-1.5 rounded-lg bg-cyan-500/15 hover:bg-cyan-500/25 text-cyan-300 border border-cyan-500/30 font-semibold flex items-center gap-1.5 transition">
                        <i class="fas fa-code"></i>
                        <span>Kerangka Code Block</span>
                    </button>

                    <!-- Table Generator (Kerangka Tabel) -->
                    <button type="button" 
                            onclick="insertTableTemplate()" 
                            class="px-3 py-1.5 rounded-lg bg-purple-500/15 hover:bg-purple-500/25 text-purple-300 border border-purple-500/30 font-semibold flex items-center gap-1.5 transition">
                        <i class="fas fa-table"></i>
                        <span>Buat Tabel</span>
                    </button>

                    <!-- Image Inserter / Upload -->
                    <button type="button" 
                            onclick="openImageModal()" 
                            class="px-3 py-1.5 rounded-lg bg-emerald-500/15 hover:bg-emerald-500/25 text-emerald-300 border border-emerald-500/30 font-semibold flex items-center gap-1.5 transition">
                        <i class="fas fa-image"></i>
                        <span>Sisipkan Gambar</span>
                    </button>

                    <!-- Callout Alert (Catatan / Tips / Peringatan) -->
                    <button type="button" 
                            onclick="insertCallout('NOTE')" 
                            class="px-2.5 py-1.5 rounded-lg bg-slate-900 hover:bg-slate-800 text-slate-300 hover:text-white border border-slate-800 transition" title="Sisipkan Kotak Catatan">
                        <i class="fas fa-info-circle text-sky-400 mr-1"></i> Catatan
                    </button>
                    <button type="button" 
                            onclick="insertCallout('TIP')" 
                            class="px-2.5 py-1.5 rounded-lg bg-slate-900 hover:bg-slate-800 text-slate-300 hover:text-white border border-slate-800 transition" title="Sisipkan Kotak Tips">
                        <i class="fas fa-lightbulb text-emerald-400 mr-1"></i> Tips
                    </button>

                    <!-- Lists & Divider -->
                    <button type="button" onclick="insertLinePrefix('- ')" class="px-2 py-1.5 text-slate-400 hover:text-white" title="Daftar Poin"><i class="fas fa-list-ul"></i></button>
                    <button type="button" onclick="insertLinePrefix('1. ')" class="px-2 py-1.5 text-slate-400 hover:text-white" title="Daftar Nomor"><i class="fas fa-list-ol"></i></button>
                    <button type="button" onclick="insertContent('\n---\n')" class="px-2 py-1.5 text-slate-400 hover:text-white" title="Garis Pemisah"><i class="fas fa-minus"></i></button>
                </div>

                <!-- Right Hint -->
                <div class="text-[11px] text-slate-500 hidden xl:flex items-center gap-2">
                    <i class="fab fa-markdown text-slate-400"></i>
                    <span>Markdown & Framework Code Support</span>
                </div>
            </div>

            <!-- Workspace: Editor & Live Preview -->
            <div id="editorWorkspace" class="grid grid-cols-1 lg:grid-cols-2 divide-y lg:divide-y-0 lg:divide-x divide-slate-800 min-h-[600px]">
                
                <!-- Left Pane: Markdown Editor -->
                <div id="editorPane" class="flex flex-col bg-[#070c18]">
                    <div class="px-4 py-2 bg-slate-950/60 border-b border-slate-800 text-xs font-mono text-slate-400 flex items-center justify-between">
                        <span>Markdown Input</span>
                        <span id="wordCountBadge" class="text-[11px] text-slate-500">0 kata</span>
                    </div>
                    <textarea name="content" 
                              id="markdownTextarea" 
                              rows="24"
                              required
                              placeholder="Ketik konten modul di sini..." 
                              class="w-full flex-1 p-5 bg-transparent text-slate-200 font-mono text-sm leading-relaxed outline-none resize-y selection:bg-cyan-500/30 selection:text-cyan-200">{{ old('content', $module->content) }}</textarea>
                </div>

                <!-- Right Pane: Live Rendered Tailwind Docs Preview -->
                <div id="previewPane" class="flex flex-col bg-[#0b1120] overflow-y-auto max-h-[800px]">
                    <div class="px-4 py-2 bg-slate-950/60 border-b border-slate-800 text-xs font-mono text-cyan-400 flex items-center justify-between">
                        <span class="flex items-center gap-2">
                            <i class="fas fa-desktop"></i>
                            <span>Live Reader Preview</span>
                        </span>
                        <span class="text-[11px] text-slate-500 font-sans">Otomatis Terupdate</span>
                    </div>

                    <div class="p-6 md:p-8 flex-1">
                        <!-- Breadcrumbs Preview -->
                        <div class="flex items-center gap-2 text-xs font-medium text-slate-400 pb-4 mb-4 border-b border-slate-800">
                            <span id="previewCategory">{{ $module->category ? $module->category->name : 'Kategori' }}</span>
                            <i class="fas fa-chevron-right text-[9px] text-slate-600"></i>
                            <span id="previewBreadcrumbTitle" class="text-cyan-400 font-semibold">{{ $module->title }}</span>
                        </div>

                        <!-- Main Rendered Output -->
                        <div id="previewContent" class="module-body text-[15px] leading-relaxed text-slate-300">
                            <!-- Populated via live preview JS -->
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </form>

</div>

<!-- Modal 1: Code Block Generator Framework -->
<div id="codeModal" class="fixed inset-0 z-50 hidden bg-black/80 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-slate-900 border border-slate-700/80 rounded-2xl w-full max-w-lg shadow-2xl overflow-hidden animate-in fade-in zoom-in-95 duration-200">
        <div class="p-5 border-b border-slate-800 flex items-center justify-between">
            <h3 class="text-base font-bold text-white flex items-center gap-2">
                <i class="fas fa-code text-cyan-400"></i>
                <span>Sisipkan Kerangka Code Block</span>
            </h3>
            <button type="button" onclick="closeCodeModal()" class="text-slate-400 hover:text-white">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <div class="p-5 space-y-4">
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">Nama File / Tab Header</label>
                <input type="text" 
                       id="codeFileName" 
                       placeholder="Contoh: app.css, HTML, index.blade.php, main.js" 
                       value="app.css"
                       class="cyber-input font-mono text-sm">
                <p class="text-[11px] text-slate-500 mt-1">Nama ini akan muncul pada pill di atas kotak code (seperti pada Tailwind docs).</p>
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">Bahasa Pemrograman</label>
                <select id="codeLang" class="cyber-input">
                    <option value="css">CSS</option>
                    <option value="html">HTML</option>
                    <option value="javascript">JavaScript</option>
                    <option value="php">PHP</option>
                    <option value="json">JSON</option>
                    <option value="sql">SQL</option>
                    <option value="bash">Bash / Terminal</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">Isi Codingan</label>
                <textarea id="codeSampleInput" 
                          rows="6" 
                          placeholder="Masukkan codingan di sini..."
                          class="cyber-input font-mono text-xs"></textarea>
            </div>
        </div>

        <div class="p-5 border-t border-slate-800 bg-black/20 flex items-center justify-end gap-3">
            <button type="button" onclick="closeCodeModal()" class="px-4 py-2 rounded-lg bg-slate-800 text-slate-300 hover:text-white text-xs font-semibold">
                Batal
            </button>
            <button type="button" onclick="applyCodeBlock()" class="cyber-btn text-xs">
                <i class="fas fa-plus mr-1.5"></i>
                <span>Sisipkan Code Block</span>
            </button>
        </div>
    </div>
</div>

<!-- Modal 2: Image Inserter & Uploader -->
<div id="imageModal" class="fixed inset-0 z-50 hidden bg-black/80 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-slate-900 border border-slate-700/80 rounded-2xl w-full max-w-md shadow-2xl overflow-hidden animate-in fade-in zoom-in-95 duration-200">
        <div class="p-5 border-b border-slate-800 flex items-center justify-between">
            <h3 class="text-base font-bold text-white flex items-center gap-2">
                <i class="fas fa-image text-emerald-400"></i>
                <span>Sisipkan Gambar ke Modul</span>
            </h3>
            <button type="button" onclick="closeImageModal()" class="text-slate-400 hover:text-white">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <div class="p-5 space-y-4">
            <!-- Upload from Device -->
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">Upload dari Komputer</label>
                <div class="border-2 border-dashed border-slate-700 hover:border-cyan-500/50 rounded-xl p-4 text-center cursor-pointer bg-slate-950/40" onclick="document.getElementById('imgFileInput').click()">
                    <i class="fas fa-cloud-upload-alt text-2xl text-slate-400 mb-2"></i>
                    <p class="text-xs text-slate-300 font-medium">Klik untuk memilih file gambar</p>
                    <p class="text-[10px] text-slate-500 mt-1">PNG, JPG, WebP, SVG (Maks 5MB)</p>
                    <input type="file" id="imgFileInput" class="hidden" accept="image/*" onchange="uploadImageFile(this)">
                </div>
                <div id="uploadStatus" class="mt-2 text-xs text-center hidden"></div>
            </div>

            <div class="relative flex py-1 items-center">
                <div class="flex-grow border-t border-slate-800"></div>
                <span class="flex-shrink mx-4 text-slate-600 text-[11px] uppercase">atau gunakan URL</span>
                <div class="flex-grow border-t border-slate-800"></div>
            </div>

            <!-- External URL -->
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">URL Gambar Langsung</label>
                <input type="url" id="imgUrlInput" placeholder="https://example.com/screenshot.png" class="cyber-input text-xs">
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">Keterangan / Alt Text</label>
                <input type="text" id="imgAltInput" placeholder="Tangkapan layar demo..." class="cyber-input text-xs">
            </div>
        </div>

        <div class="p-5 border-t border-slate-800 bg-black/20 flex items-center justify-end gap-3">
            <button type="button" onclick="closeImageModal()" class="px-4 py-2 rounded-lg bg-slate-800 text-slate-300 hover:text-white text-xs font-semibold">
                Batal
            </button>
            <button type="button" onclick="applyImageUrl()" class="cyber-btn text-xs">
                <i class="fas fa-check mr-1.5"></i>
                <span>Sisipkan Gambar</span>
            </button>
        </div>
    </div>
</div>

<!-- Modal 3: Inline Category Creator -->
<div id="inlineCategoryModal" class="fixed inset-0 z-50 hidden bg-black/80 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-slate-900 border border-slate-700/80 rounded-2xl w-full max-w-md shadow-2xl overflow-hidden animate-in fade-in zoom-in-95 duration-200">
        <div class="p-5 border-b border-slate-800 flex items-center justify-between">
            <h3 class="text-base font-bold text-white flex items-center gap-2">
                <i class="fas fa-folder-plus text-cyan-400"></i>
                <span>Tambah Kategori Baru</span>
            </h3>
            <button type="button" onclick="closeInlineCategoryModal()" class="text-slate-400 hover:text-white">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <div class="p-5 space-y-4">
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">Nama Kategori</label>
                <input type="text" id="inlineCategoryName" placeholder="Contoh: BASE STYLES, LAYOUT, CORE CONCEPTS" class="cyber-input">
            </div>
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">Urutan Tampil (Order)</label>
                <input type="number" id="inlineCategoryOrder" value="1" min="0" class="cyber-input font-mono">
            </div>
        </div>

        <div class="p-5 border-t border-slate-800 bg-black/20 flex items-center justify-end gap-3">
            <button type="button" onclick="closeInlineCategoryModal()" class="px-4 py-2 rounded-lg bg-slate-800 text-slate-300 hover:text-white text-xs font-semibold">
                Batal
            </button>
            <button type="button" onclick="submitInlineCategory()" id="btnSubmitInlineCat" class="cyber-btn text-xs">
                <span>Simpan Kategori</span>
            </button>
        </div>
    </div>
</div>

<script>
    const textarea = document.getElementById('markdownTextarea');
    const previewContent = document.getElementById('previewContent');
    const moduleTitleInput = document.getElementById('moduleTitleInput');
    const moduleSlugInput = document.getElementById('moduleSlugInput');
    const previewBreadcrumbTitle = document.getElementById('previewBreadcrumbTitle');
    const previewCategory = document.getElementById('previewCategory');
    const categorySelect = document.getElementById('categorySelect');
    const wordCountBadge = document.getElementById('wordCountBadge');

    if (moduleTitleInput && previewBreadcrumbTitle) {
        moduleTitleInput.addEventListener('input', (e) => {
            previewBreadcrumbTitle.innerText = e.target.value || 'Judul Modul';
        });
    }

    if (categorySelect && previewCategory) {
        categorySelect.addEventListener('change', () => {
            const selectedText = categorySelect.options[categorySelect.selectedIndex]?.text;
            previewCategory.innerText = selectedText && selectedText !== 'Pilih Kategori...' ? selectedText : 'Kategori';
        });
    }

    // View Mode Switcher
    function setViewMode(mode) {
        const workspace = document.getElementById('editorWorkspace');
        const editorPane = document.getElementById('editorPane');
        const previewPane = document.getElementById('previewPane');
        const btnSplit = document.getElementById('btnViewSplit');
        const btnEditor = document.getElementById('btnViewEditor');
        const btnPreview = document.getElementById('btnViewPreview');

        [btnSplit, btnEditor, btnPreview].forEach(b => {
            b.className = 'px-3 py-1.5 rounded-lg hover:text-white';
        });

        if (mode === 'split') {
            workspace.className = 'grid grid-cols-1 lg:grid-cols-2 divide-y lg:divide-y-0 lg:divide-x divide-slate-800 min-h-[600px]';
            editorPane.style.display = 'flex';
            previewPane.style.display = 'flex';
            btnSplit.className = 'px-3 py-1.5 rounded-lg bg-cyan-500/20 text-cyan-300 font-bold';
        } else if (mode === 'editor') {
            workspace.className = 'grid grid-cols-1 min-h-[600px]';
            editorPane.style.display = 'flex';
            previewPane.style.display = 'none';
            btnEditor.className = 'px-3 py-1.5 rounded-lg bg-cyan-500/20 text-cyan-300 font-bold';
        } else if (mode === 'preview') {
            workspace.className = 'grid grid-cols-1 min-h-[600px]';
            editorPane.style.display = 'none';
            previewPane.style.display = 'flex';
            btnPreview.className = 'px-3 py-1.5 rounded-lg bg-cyan-500/20 text-cyan-300 font-bold';
        }
    }

    // Live Preview debounced fetch
    let renderTimer = null;
    function triggerLivePreview() {
        const text = textarea.value;
        const words = text.trim() ? text.trim().split(/\s+/).length : 0;
        wordCountBadge.innerText = `${words} kata`;

        clearTimeout(renderTimer);
        renderTimer = setTimeout(() => {
            fetch("{{ route('admin.modules.preview') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ content: text })
            })
            .then(res => res.json())
            .then(data => {
                previewContent.innerHTML = data.html;
                if (window.Prism) {
                    Prism.highlightAllUnder(previewContent);
                }
            })
            .catch(err => {
                console.error(err);
            });
        }, 250);
    }

    textarea.addEventListener('input', triggerLivePreview);
    triggerLivePreview(); // Initial preview on page load

    // Text Editor Insertion Helpers
    function insertContent(textToInsert) {
        const start = textarea.selectionStart;
        const end = textarea.selectionEnd;
        const text = textarea.value;

        textarea.value = text.substring(0, start) + textToInsert + text.substring(end);
        textarea.selectionStart = textarea.selectionEnd = start + textToInsert.length;
        textarea.focus();
        triggerLivePreview();
    }

    function wrapText(prefix, suffix) {
        const start = textarea.selectionStart;
        const end = textarea.selectionEnd;
        const text = textarea.value;
        const selected = text.substring(start, end) || 'teks';

        const replacement = prefix + selected + suffix;
        textarea.value = text.substring(0, start) + replacement + text.substring(end);
        textarea.selectionStart = start + prefix.length;
        textarea.selectionEnd = start + prefix.length + selected.length;
        textarea.focus();
        triggerLivePreview();
    }

    function insertHeading(level) {
        const prefix = '#'.repeat(level) + ' ';
        insertLinePrefix(prefix);
    }

    function insertLinePrefix(prefix) {
        const start = textarea.selectionStart;
        const text = textarea.value;
        const lineStart = text.lastIndexOf('\n', start - 1) + 1;
        textarea.value = text.substring(0, lineStart) + prefix + text.substring(lineStart);
        textarea.selectionStart = textarea.selectionEnd = start + prefix.length;
        textarea.focus();
        triggerLivePreview();
    }

    function insertTableTemplate() {
        const template = `\n| Nama Properti | Deskripsi | Nilai Default |\n| ------------- | --------- | ------------- |\n| \`--color-mint\` | Nilai warna primer mint | \`oklch(0.72 0.11 178)\` |\n| \`--font-sans\`  | Font typography utama   | \`Outfit, sans-serif\` |\n| \`--spacing-lg\` | Ukuran padding besar   | \`2rem\` |\n\n`;
        insertContent(template);
    }

    function insertCallout(type) {
        let template = `\n> [!${type}]\n> Ini adalah pesan ${type.toLowerCase()} penting yang ditampilkan dengan bingkai berwarna elegan.\n\n`;
        insertContent(template);
    }

    // Code Block Modal Logic
    const codeModal = document.getElementById('codeModal');
    function openCodeModal() {
        codeModal.classList.remove('hidden');
        document.getElementById('codeFileName').focus();
    }
    function closeCodeModal() {
        codeModal.classList.add('hidden');
    }

    function applyCodeBlock() {
        const file = document.getElementById('codeFileName').value.trim() || 'app.css';
        const lang = document.getElementById('codeLang').value;
        const sample = document.getElementById('codeSampleInput').value.trim() || `// Ketik kode Anda di sini\nconsole.log("Hello Tailwind Module");`;

        const codeSnippet = `\n\`\`\`${lang}:${file}\n${sample}\n\`\`\`\n\n`;
        insertContent(codeSnippet);
        closeCodeModal();
    }

    // Image Modal & Upload Logic
    const imageModal = document.getElementById('imageModal');
    function openImageModal() {
        imageModal.classList.remove('hidden');
    }
    function closeImageModal() {
        imageModal.classList.add('hidden');
    }

    function applyImageUrl() {
        const url = document.getElementById('imgUrlInput').value.trim();
        const alt = document.getElementById('imgAltInput').value.trim() || 'Gambar Dokumentasi';

        if (!url) {
            alert('Silakan masukkan URL gambar atau upload file terlebih dahulu.');
            return;
        }

        insertContent(`\n![${alt}](${url})\n\n`);
        closeImageModal();
    }

    function uploadImageFile(input) {
        if (!input.files || !input.files[0]) return;
        const file = input.files[0];
        const statusEl = document.getElementById('uploadStatus');

        statusEl.className = 'mt-2 text-xs text-center text-cyan-400 block';
        statusEl.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i> Mengupload gambar...';

        const formData = new FormData();
        formData.append('image', file);

        fetch("{{ route('admin.modules.upload-image') }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                statusEl.className = 'mt-2 text-xs text-center text-emerald-400 block';
                statusEl.innerHTML = '<i class="fas fa-check mr-1"></i> Berhasil diupload!';
                insertContent(`\n${data.markdown}\n\n`);
                setTimeout(() => {
                    closeImageModal();
                    statusEl.className = 'hidden';
                }, 800);
            } else {
                statusEl.className = 'mt-2 text-xs text-center text-rose-400 block';
                statusEl.innerText = data.message || 'Gagal mengupload gambar.';
            }
        })
        .catch(err => {
            statusEl.className = 'mt-2 text-xs text-center text-rose-400 block';
            statusEl.innerText = 'Terjadi kesalahan saat upload gambar.';
        });
    }

    // Inline Category Creator
    const inlineCatModal = document.getElementById('inlineCategoryModal');
    function openInlineCategoryModal() {
        inlineCatModal.classList.remove('hidden');
        document.getElementById('inlineCategoryName').focus();
    }
    function closeInlineCategoryModal() {
        inlineCatModal.classList.add('hidden');
    }

    function submitInlineCategory() {
        const name = document.getElementById('inlineCategoryName').value.trim();
        const order = document.getElementById('inlineCategoryOrder').value;
        const btn = document.getElementById('btnSubmitInlineCat');

        if (!name) {
            alert('Nama kategori tidak boleh kosong.');
            return;
        }

        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i> Menyimpan...';

        fetch("{{ route('admin.module-categories.store') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ name: name, order: order })
        })
        .then(res => res.json())
        .then(data => {
            btn.disabled = false;
            btn.innerText = 'Simpan Kategori';

            if (data.success) {
                const newOption = new Option(data.category.name, data.category.id, true, true);
                categorySelect.add(newOption);
                previewCategory.innerText = data.category.name;
                closeInlineCategoryModal();
                document.getElementById('inlineCategoryName').value = '';
            } else {
                alert(data.message || 'Gagal menambahkan kategori.');
            }
        })
        .catch(err => {
            btn.disabled = false;
            btn.innerText = 'Simpan Kategori';
            alert('Terjadi kesalahan saat menyimpan kategori.');
        });
    }

    function copyCodeBlock(codeId, button) {
        const codeEl = document.getElementById(codeId);
        if (!codeEl) return;
        const textToCopy = codeEl.innerText || codeEl.textContent;
        navigator.clipboard.writeText(textToCopy).then(() => {
            const icon = button.querySelector('i');
            const span = button.querySelector('span');
            const origIcon = icon.className;
            const origText = span.innerText;
            icon.className = 'fas fa-check text-emerald-400';
            span.innerText = 'Tersalin!';
            setTimeout(() => {
                icon.className = origIcon;
                span.innerText = origText;
            }, 2000);
        });
    }
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/prism.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/plugins/autoloader/prism-autoloader.min.js"></script>
@endsection
