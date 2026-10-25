@extends('modules.layout')

@section('title', $module->title)

@section('content')

    <!-- Breadcrumb Bar (Desktop & Mobile) -->
    <div class="flex items-center justify-between gap-2.5 pb-4 mb-6 border-b border-[color:var(--line)] w-full min-w-0">
        <nav class="flex items-center gap-1.5 sm:gap-2 text-xs font-medium text-[color:var(--muted)] overflow-x-auto whitespace-nowrap scrollbar-none py-1 flex-1 min-w-0 pr-2">
            <a href="{{ route('modules.index') }}" class="hover:text-[color:var(--blue)] transition-colors flex items-center gap-1.5 font-semibold shrink-0" title="Katalog Modul">
                <i class="fas fa-layer-group text-[11px] text-[color:var(--blue)]"></i>
                <span class="hidden sm:inline">Katalog Modul</span>
            </a>
            <i class="fas fa-chevron-right text-[9px] text-[color:var(--muted)] shrink-0"></i>
            @if(isset($learningModule))
                <a href="{{ route('modules.module.show', $learningModule->slug) }}" class="text-[color:var(--body)] hover:text-[color:var(--blue)] transition-colors shrink-0">
                    {{ $learningModule->name }}
                </a>
                <i class="fas fa-chevron-right text-[9px] text-[color:var(--muted)] shrink-0"></i>
            @elseif(isset($module->category))
                <a href="{{ route('modules.module.show', $module->category->slug) }}" class="text-[color:var(--body)] hover:text-[color:var(--blue)] transition-colors shrink-0">
                    {{ $module->category->name }}
                </a>
                <i class="fas fa-chevron-right text-[9px] text-[color:var(--muted)] shrink-0"></i>
            @endif
            @if(!empty($module->section))
                <span class="text-[color:var(--muted)] font-mono text-[11px] uppercase shrink-0">{{ $module->section }}</span>
                <i class="fas fa-chevron-right text-[9px] text-[color:var(--muted)] shrink-0"></i>
            @endif
            <span class="text-[color:var(--blue)] font-semibold truncate shrink-0 max-w-[160px] sm:max-w-none">{{ $module->title ?? 'Materi' }}</span>
        </nav>

        <!-- Right status & Admin Quick Actions -->
        <div class="flex items-center gap-2 shrink-0 flex-shrink-0">
            @php
                $isPublicModule = isset($learningModule) ? $learningModule->is_public : (isset($module->category) ? $module->category->is_public : true);
            @endphp
            @if(!$isPublicModule)
                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-mono font-bold bg-amber-500/10 text-amber-400 border border-amber-500/30 shrink-0 shadow-sm">
                    <i class="fas fa-lock text-[9px]"></i> <span>PRIVATE</span>
                </span>
            @else
                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-mono font-bold bg-emerald-500/10 text-emerald-400 border border-emerald-500/30 shrink-0 shadow-sm">
                    <i class="fas fa-globe text-[9px]"></i> <span>PUBLIC</span>
                </span>
            @endif

            @auth
                @if(auth()->user()->isAdmin() && isset($learningModule))
                    <a href="{{ route('admin.modules.contents.index', $learningModule->id) }}" 
                       class="inline-flex items-center gap-1.5 px-2 sm:px-2.5 py-1 rounded-md text-[11px] font-semibold bg-[var(--surface)] hover:bg-[var(--line)] text-[color:var(--body)] hover:text-[color:var(--ink)] border border-[color:var(--line)] transition shrink-0 shadow-sm"
                       title="Kelola Materi Modul">
                        <i class="fas fa-cog text-[color:var(--blue)] text-[10px]"></i>
                        <span class="hidden sm:inline">Kelola</span>
                    </a>
                @endif
            @endauth
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 rounded-xl border border-emerald-500/40 bg-emerald-950/30 text-emerald-300 text-sm flex items-center gap-3">
            <i class="fas fa-check-circle text-emerald-400"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 p-4 rounded-xl border border-rose-500/40 bg-rose-950/30 text-rose-300 text-sm flex items-center gap-3">
            <i class="fas fa-exclamation-triangle text-rose-400"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    @if(isset($isLocked) && $isLocked)
        <!-- ============================================== -->
        <!-- LOCKED CONTENT VIEW (LOCKED PRIVATE MODULE)     -->
        <!-- ============================================== -->
        <div class="rounded-3xl border border-amber-500/30 bg-gradient-to-b from-[var(--surface)] to-[var(--bg)] p-8 sm:p-12 text-center max-w-2xl mx-auto shadow-2xl relative overflow-hidden">
            <div class="absolute -right-16 -top-16 w-60 h-60 rounded-full bg-amber-500/10 blur-3xl pointer-events-none"></div>

            <div class="w-16 h-16 rounded-2xl bg-amber-500/15 border border-amber-500/30 text-amber-400 text-3xl flex items-center justify-center mx-auto mb-6 shadow-inner animate-pulse">
                <i class="fas fa-lock"></i>
            </div>

            <h2 class="text-2xl sm:text-3xl font-extrabold text-[color:var(--ink)] mb-3">
                Modul Ini Terkunci (Private)
            </h2>

            <p class="text-[color:var(--body)] text-sm leading-relaxed mb-6 font-normal">
                Materi <strong class="text-[color:var(--ink)]">{{ $module->title }}</strong> di dalam 
                <strong class="text-[color:var(--blue)]">{{ $module->category ? $module->category->name : 'modul ini' }}</strong> 
                hanya dapat diakses melalui izin manual admin atau dengan memasukkan kode referral pembuka.
            </p>

            @guest
                <div class="p-6 rounded-2xl bg-[var(--bg)] border border-[color:var(--line)] text-center">
                    <p class="text-xs text-[color:var(--muted)] mb-4">Silakan login terlebih dahulu untuk membuka dan menyimpan progres belajar modul ini.</p>
                    <a href="{{ route('login') }}" class="cyber-btn inline-flex items-center gap-2 text-xs">
                        <i class="fas fa-sign-in-alt"></i>
                        <span>Masuk ke Akun Anda</span>
                    </a>
                </div>
            @else
                <!-- Referral Unlock Form -->
                <form action="{{ route('modules.unlock') }}" method="POST" class="p-6 rounded-2xl bg-[var(--bg)] border border-[color:var(--line)] text-left">
                    @csrf
                    @if(isset($learningModule))
                        <input type="hidden" name="module_id" value="{{ $learningModule->id }}">
                    @elseif(isset($module->category))
                        <input type="hidden" name="module_id" value="{{ $module->category->id }}">
                    @else
                        <input type="hidden" name="module_id" value="{{ $module->id }}">
                    @endif

                    <label class="block text-xs font-bold uppercase tracking-wider text-[color:var(--body)] mb-2">
                        Masukkan Kode Referral / Kode Akses:
                    </label>

                    <div class="flex flex-col sm:flex-row gap-3">
                        <input type="text" 
                               name="referral_code" 
                               required 
                               placeholder="Contoh: CSSPRO, JSMASTER, dsb."
                               class="cyber-input flex-1 uppercase font-mono tracking-wider text-[color:var(--blue)]">
                        <button type="submit" class="cyber-btn whitespace-nowrap text-xs flex items-center justify-center gap-2">
                            <i class="fas fa-unlock"></i>
                            <span>Buka Akses</span>
                        </button>
                    </div>

                    <p class="text-[11px] text-[color:var(--muted)] mt-3 flex items-center gap-1.5">
                        <i class="fas fa-info-circle text-[color:var(--muted)]"></i>
                        <span>Admin juga dapat menambahkan akun Anda secara manual melalui panel admin.</span>
                    </p>
                </form>
            @endguest

            <div class="mt-8 pt-6 border-t border-[color:var(--line)] flex items-center justify-center">
                <a href="{{ route('modules.index') }}" class="text-xs text-[color:var(--muted)] hover:text-[color:var(--ink)] transition flex items-center gap-2">
                    <i class="fas fa-arrow-left"></i>
                    <span>Kembali ke Katalog Modul</span>
                </a>
            </div>
        </div>

    @else
        <!-- ============================================== -->
        <!-- UNLOCKED / PUBLIC ARTICLE CONTENT               -->
        <!-- ============================================== -->
        <article class="prose prose-invert max-w-none">
            
            <!-- Main Document Title -->
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-extrabold text-[color:var(--ink)] tracking-tight mb-4 break-words">
                {{ $module->title }}
            </h1>

            <!-- Optional Excerpt / Summary -->
            @if($module->excerpt)
                <div class="text-base sm:text-lg text-[color:var(--body)] font-normal leading-relaxed mb-8 pb-4 border-b border-[color:var(--line)]">
                    {{ $module->excerpt }}
                </div>
            @endif

            <!-- Document / File Viewer Box (PDF, Word, PPT) -->
            @if(!empty($module->file_path))
                <div class="mb-6 p-4 sm:p-5 rounded-2xl border border-[color:var(--line)] bg-gradient-to-r from-[var(--surface)] to-[var(--surface)] shadow-lg flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl flex items-center justify-center text-xl shrink-0 {{ $module->isPdf() ? 'bg-rose-500/15 text-rose-400 border border-rose-500/30' : ($module->isWord() ? 'bg-[var(--blue-light)] text-[color:var(--blue)] border border-[color:var(--blue)]' : ($module->isPpt() ? 'bg-amber-500/15 text-amber-400 border border-amber-500/30' : 'bg-purple-500/15 text-purple-400 border border-purple-500/30')) }}">
                            <i class="{{ $module->isPdf() ? 'fas fa-file-pdf' : ($module->isWord() ? 'fas fa-file-word' : ($module->isPpt() ? 'fas fa-file-powerpoint' : 'fas fa-file-alt')) }}"></i>
                        </div>
                        <div>
                            <div class="flex items-center gap-2">
                                <span class="text-xs uppercase font-mono font-bold px-2 py-0.5 rounded {{ $module->isPdf() ? 'bg-rose-950 text-rose-300 border border-rose-800' : ($module->isWord() ? 'bg-[var(--blue-light)] text-[color:var(--blue)] border border-[color:var(--blue)]' : ($module->isPpt() ? 'bg-amber-950 text-amber-300 border border-amber-800' : 'bg-purple-950 text-purple-300 border border-purple-800')) }}">
                                    {{ strtoupper($module->content_type ?: ($module->isPdf() ? 'PDF' : ($module->isWord() ? 'WORD' : ($module->isPpt() ? 'PPT' : 'DOKUMEN')))) }}
                                </span>
                                <span class="text-xs text-[color:var(--muted)] font-mono">{{ $module->formatted_file_size }}</span>
                            </div>
                            <h4 class="text-[color:var(--ink)] font-bold text-sm mt-1 truncate max-w-xs sm:max-w-xl">
                                {{ $module->file_name ?? basename($module->file_path) }}
                            </h4>
                        </div>
                    </div>

                    <div class="flex items-center gap-2">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-[var(--bg)] border border-[color:var(--line)] text-[color:var(--muted)] text-xs font-mono">
                            <i class="fas fa-lock text-[10px] text-emerald-400"></i>
                            <span>Mode Baca Terproteksi</span>
                        </span>
                    </div>
                </div>

                <!-- Embedded Document Viewers (Full Size & Large) -->
                @if($module->isPdf())
                    <div class="mb-10 rounded-2xl overflow-hidden border border-[color:var(--line)] bg-[var(--bg)] shadow-2xl">
                        <div class="px-4 py-3 bg-[var(--surface)] border-b border-[color:var(--line)] flex items-center justify-between text-xs font-mono text-[color:var(--muted)]">
                            <div class="flex items-center gap-2.5">
                                <i class="fas fa-file-pdf text-rose-400"></i>
                                <span class="text-[color:var(--ink)] font-semibold truncate">{{ $module->file_name ?? $module->title }}</span>
                            </div>
                            <span class="text-[11px] text-[color:var(--muted)] hidden sm:inline">PDF Document Reader</span>
                        </div>
                        <iframe src="{{ $module->file_url }}#toolbar=0&navpanes=0&scrollbar=1" 
                                class="w-full h-[90vh] min-h-[850px] border-0 bg-[var(--bg)]" 
                                title="Pembaca Dokumen PDF">
                        </iframe>
                    </div>
                @elseif($module->isWord())
                    <div class="mb-10 rounded-2xl overflow-hidden border border-[color:var(--line)] bg-[var(--bg)] shadow-2xl">
                        <div class="px-4 py-3 bg-[var(--surface)] border-b border-[color:var(--line)] flex items-center justify-between text-xs font-mono text-[color:var(--muted)]">
                            <div class="flex items-center gap-2.5">
                                <i class="fas fa-file-word text-[color:var(--blue)]"></i>
                                <span class="text-[color:var(--ink)] font-semibold truncate">{{ $module->file_name ?? $module->title }}</span>
                            </div>
                            <span class="text-[11px] text-[color:var(--muted)] hidden sm:inline">Word Document Reader</span>
                        </div>
                        <iframe src="https://view.officeapps.live.com/op/embed.aspx?src={{ urlencode(url($module->file_url)) }}" 
                                class="w-full h-[90vh] min-h-[850px] border-0 bg-[var(--bg)]" 
                                title="Pembaca Dokumen Word">
                        </iframe>
                    </div>
                @elseif($module->isPpt())
                    <div class="mb-10 rounded-2xl overflow-hidden border border-[color:var(--line)] bg-[var(--bg)] shadow-2xl">
                        <div class="px-4 py-3 bg-[var(--surface)] border-b border-[color:var(--line)] flex items-center justify-between text-xs font-mono text-[color:var(--muted)]">
                            <div class="flex items-center gap-2.5">
                                <i class="fas fa-file-powerpoint text-amber-400"></i>
                                <span class="text-[color:var(--ink)] font-semibold truncate">{{ $module->file_name ?? $module->title }}</span>
                            </div>
                            <span class="text-[11px] text-[color:var(--muted)] hidden sm:inline">PowerPoint Slide Reader</span>
                        </div>
                        <iframe src="https://view.officeapps.live.com/op/embed.aspx?src={{ urlencode(url($module->file_url)) }}" 
                                class="w-full h-[90vh] min-h-[850px] border-0 bg-[var(--bg)]" 
                                title="Pembaca Presentasi PowerPoint">
                        </iframe>
                    </div>
                @endif
            @endif

            <!-- Parsed Markdown / Framed Content (Only displayed for Markdown modules) -->
            @if($module->isMarkdown() && !empty($module->content))
                <div class="module-body text-[15px] leading-relaxed text-[color:var(--body)]">
                    {!! $module->rendered_content !!}
                </div>
            @endif

        </article>

        <!-- Bottom Navigation (Previous & Next Lesson within this module) -->
        <div class="mt-16 pt-8 border-t border-[color:var(--line)] flex flex-col sm:flex-row items-center justify-between gap-4">
            @php
                $prevUrl = null;
                if ($previousLesson && isset($learningModule)) {
                    $prevUrl = route('modules.lesson.show', ['moduleSlug' => $learningModule->slug, 'lessonSlug' => $previousLesson->slug]);
                }
                $nextUrl = null;
                if ($nextLesson && isset($learningModule)) {
                    $nextUrl = route('modules.lesson.show', ['moduleSlug' => $learningModule->slug, 'lessonSlug' => $nextLesson->slug]);
                }
            @endphp

            @if($prevUrl)
                <a href="{{ $prevUrl }}" 
                   class="w-full sm:w-auto group flex items-center gap-3 p-3.5 rounded-xl bg-[var(--surface)] hover:bg-[var(--surface)] border border-[color:var(--line)] hover:border-[color:var(--line)] transition text-left">
                    <div class="w-8 h-8 rounded-lg bg-[var(--surface)] flex items-center justify-center text-[color:var(--muted)] group-hover:text-[color:var(--blue)] transition-colors">
                        <i class="fas fa-arrow-left text-xs"></i>
                    </div>
                    <div>
                        <span class="block text-[11px] font-mono text-[color:var(--muted)] uppercase tracking-wider">Materi Sebelumnya</span>
                        <span class="text-sm font-semibold text-[color:var(--ink)] group-hover:text-[color:var(--blue)] transition-colors">{{ $previousLesson->title }}</span>
                    </div>
                </a>
            @else
                <div class="hidden sm:block"></div>
            @endif

            @if($nextUrl)
                <a href="{{ $nextUrl }}" 
                   class="w-full sm:w-auto group flex items-center justify-between sm:justify-end gap-3 p-3.5 rounded-xl bg-[var(--surface)] hover:bg-[var(--surface)] border border-[color:var(--line)] hover:border-[color:var(--line)] transition text-right">
                    <div>
                        <span class="block text-[11px] font-mono text-[color:var(--muted)] uppercase tracking-wider">Materi Selanjutnya</span>
                        <span class="text-sm font-semibold text-[color:var(--ink)] group-hover:text-[color:var(--blue)] transition-colors">{{ $nextLesson->title }}</span>
                    </div>
                    <div class="w-8 h-8 rounded-lg bg-[var(--surface)] flex items-center justify-center text-[color:var(--muted)] group-hover:text-[color:var(--blue)] transition-colors">
                        <i class="fas fa-arrow-right text-xs"></i>
                    </div>
                </a>
            @endif
        </div>
    @endif

@endsection
