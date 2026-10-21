@extends('modules.layout')

@section('title', $module->title)

@section('content')

    <!-- Breadcrumb Bar (Desktop & Mobile) -->
    <div class="flex flex-wrap items-center justify-between gap-3 pb-6 mb-6 border-b border-slate-800/80">
        <nav class="flex items-center gap-2 text-xs font-medium text-slate-400">
            <a href="{{ route('modules.index') }}" class="hover:text-cyan-400 transition-colors flex items-center gap-1.5 font-semibold">
                <i class="fas fa-layer-group text-[11px] text-cyan-400"></i>
                <span>Katalog Modul</span>
            </a>
            <i class="fas fa-chevron-right text-[9px] text-slate-600"></i>
            @if(isset($learningModule))
                <a href="{{ route('modules.module.show', $learningModule->slug) }}" class="text-slate-300 hover:text-cyan-400 transition-colors">
                    {{ $learningModule->name }}
                </a>
                <i class="fas fa-chevron-right text-[9px] text-slate-600"></i>
            @elseif(isset($module->category))
                <a href="{{ route('modules.module.show', $module->category->slug) }}" class="text-slate-300 hover:text-cyan-400 transition-colors">
                    {{ $module->category->name }}
                </a>
                <i class="fas fa-chevron-right text-[9px] text-slate-600"></i>
            @endif
            @if(!empty($module->section))
                <span class="text-slate-500 font-mono text-[11px] uppercase">{{ $module->section }}</span>
                <i class="fas fa-chevron-right text-[9px] text-slate-600"></i>
            @endif
            <span class="text-cyan-400 font-semibold truncate max-w-[200px] sm:max-w-none">{{ $module->title ?? 'Materi' }}</span>
        </nav>

        <!-- Right status & Admin Quick Actions -->
        <div class="flex items-center gap-2">
            @php
                $isPublicModule = isset($learningModule) ? $learningModule->is_public : (isset($module->category) ? $module->category->is_public : true);
            @endphp
            @if(!$isPublicModule)
                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-mono font-bold bg-amber-500/10 text-amber-400 border border-amber-500/30">
                    <i class="fas fa-lock text-[9px]"></i> PRIVATE
                </span>
            @else
                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-mono font-bold bg-emerald-500/10 text-emerald-400 border border-emerald-500/30">
                    <i class="fas fa-globe text-[9px]"></i> PUBLIC
                </span>
            @endif

            @auth
                @if(auth()->user()->isAdmin() && isset($learningModule))
                    <a href="{{ route('admin.modules.contents.index', $learningModule->id) }}" 
                       class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-[11px] font-semibold bg-slate-800/80 hover:bg-slate-700 text-slate-300 hover:text-white border border-slate-700 transition">
                        <i class="fas fa-cog text-cyan-400 text-[10px]"></i>
                        <span>Kelola Materi</span>
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
        <div class="rounded-3xl border border-amber-500/30 bg-gradient-to-b from-slate-900 to-[#080d1a] p-8 sm:p-12 text-center max-w-2xl mx-auto shadow-2xl relative overflow-hidden">
            <div class="absolute -right-16 -top-16 w-60 h-60 rounded-full bg-amber-500/10 blur-3xl pointer-events-none"></div>

            <div class="w-16 h-16 rounded-2xl bg-amber-500/15 border border-amber-500/30 text-amber-400 text-3xl flex items-center justify-center mx-auto mb-6 shadow-inner animate-pulse">
                <i class="fas fa-lock"></i>
            </div>

            <h2 class="text-2xl sm:text-3xl font-extrabold text-white mb-3">
                Modul Ini Terkunci (Private)
            </h2>

            <p class="text-slate-300 text-sm leading-relaxed mb-6 font-normal">
                Materi <strong class="text-white">{{ $module->title }}</strong> di dalam 
                <strong class="text-cyan-400">{{ $module->category ? $module->category->name : 'modul ini' }}</strong> 
                hanya dapat diakses melalui izin manual admin atau dengan memasukkan kode referral pembuka.
            </p>

            @guest
                <div class="p-6 rounded-2xl bg-slate-950 border border-slate-800 text-center">
                    <p class="text-xs text-slate-400 mb-4">Silakan login terlebih dahulu untuk membuka dan menyimpan progres belajar modul ini.</p>
                    <a href="{{ route('login') }}" class="cyber-btn inline-flex items-center gap-2 text-xs">
                        <i class="fas fa-sign-in-alt"></i>
                        <span>Masuk ke Akun Anda</span>
                    </a>
                </div>
            @else
                <!-- Referral Unlock Form -->
                <form action="{{ route('modules.unlock') }}" method="POST" class="p-6 rounded-2xl bg-slate-950 border border-slate-800 text-left">
                    @csrf
                    @if(isset($learningModule))
                        <input type="hidden" name="module_id" value="{{ $learningModule->id }}">
                    @elseif(isset($module->category))
                        <input type="hidden" name="module_id" value="{{ $module->category->id }}">
                    @else
                        <input type="hidden" name="module_id" value="{{ $module->id }}">
                    @endif

                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-2">
                        Masukkan Kode Referral / Kode Akses:
                    </label>

                    <div class="flex flex-col sm:flex-row gap-3">
                        <input type="text" 
                               name="referral_code" 
                               required 
                               placeholder="Contoh: CSSPRO, JSMASTER, dsb."
                               class="cyber-input flex-1 uppercase font-mono tracking-wider text-cyan-300">
                        <button type="submit" class="cyber-btn whitespace-nowrap text-xs flex items-center justify-center gap-2">
                            <i class="fas fa-unlock"></i>
                            <span>Buka Akses</span>
                        </button>
                    </div>

                    <p class="text-[11px] text-slate-500 mt-3 flex items-center gap-1.5">
                        <i class="fas fa-info-circle text-slate-400"></i>
                        <span>Admin juga dapat menambahkan akun Anda secara manual melalui panel admin.</span>
                    </p>
                </form>
            @endguest

            <div class="mt-8 pt-6 border-t border-slate-800/80 flex items-center justify-center">
                <a href="{{ route('modules.index') }}" class="text-xs text-slate-400 hover:text-white transition flex items-center gap-2">
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
            <h1 class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight mb-4">
                {{ $module->title }}
            </h1>

            <!-- Optional Excerpt / Summary -->
            @if($module->excerpt)
                <div class="text-base sm:text-lg text-slate-300 font-normal leading-relaxed mb-8 pb-4 border-b border-slate-800/60">
                    {{ $module->excerpt }}
                </div>
            @endif

            <!-- Parsed Markdown / Framed Content -->
            <div class="module-body text-[15px] leading-relaxed text-slate-300">
                {!! $module->rendered_content !!}
            </div>

        </article>

        <!-- Bottom Navigation (Previous & Next Lesson within this module) -->
        <div class="mt-16 pt-8 border-t border-slate-800 flex flex-col sm:flex-row items-center justify-between gap-4">
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
                   class="w-full sm:w-auto group flex items-center gap-3 p-3.5 rounded-xl bg-slate-900/60 hover:bg-slate-800/80 border border-slate-800 hover:border-slate-700 transition text-left">
                    <div class="w-8 h-8 rounded-lg bg-slate-800 flex items-center justify-center text-slate-400 group-hover:text-cyan-400 transition-colors">
                        <i class="fas fa-arrow-left text-xs"></i>
                    </div>
                    <div>
                        <span class="block text-[11px] font-mono text-slate-500 uppercase tracking-wider">Materi Sebelumnya</span>
                        <span class="text-sm font-semibold text-white group-hover:text-cyan-300 transition-colors">{{ $previousLesson->title }}</span>
                    </div>
                </a>
            @else
                <div class="hidden sm:block"></div>
            @endif

            @if($nextUrl)
                <a href="{{ $nextUrl }}" 
                   class="w-full sm:w-auto group flex items-center justify-between sm:justify-end gap-3 p-3.5 rounded-xl bg-slate-900/60 hover:bg-slate-800/80 border border-slate-800 hover:border-slate-700 transition text-right">
                    <div>
                        <span class="block text-[11px] font-mono text-slate-500 uppercase tracking-wider">Materi Selanjutnya</span>
                        <span class="text-sm font-semibold text-white group-hover:text-cyan-300 transition-colors">{{ $nextLesson->title }}</span>
                    </div>
                    <div class="w-8 h-8 rounded-lg bg-slate-800 flex items-center justify-center text-slate-400 group-hover:text-cyan-400 transition-colors">
                        <i class="fas fa-arrow-right text-xs"></i>
                    </div>
                </a>
            @endif
        </div>
    @endif

@endsection
