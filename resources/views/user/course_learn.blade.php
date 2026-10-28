@extends('layouts.app')

@section('title', 'Modul Belajar: ' . $course->title . ' | TalentGroup')

@section('content')
@php
    $totalNodes = $contents->count();
    $completedNodes = count($userAnswers);
    $completionPercentage = $totalNodes > 0 ? round(($completedNodes / $totalNodes) * 100) : 0;
@endphp

<div class="max-w-6xl mx-auto py-8 px-4 flex flex-col gap-8 items-start">
    
    <!-- Quick Course Overview Header -->
    <div class="w-full bg-white border border-[var(--border)] rounded-2xl p-6 sm:p-8 shadow-sm">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
            <div class="flex-1">
                <div class="flex items-center gap-2 text-xs font-mono uppercase tracking-wider text-[var(--blue)] font-bold mb-1">
                    <a href="{{ route('user.my-courses') }}" class="hover:underline">KURSUS SAYA</a>
                    <i class="fas fa-chevron-right text-[9px]"></i>
                    <span>KURIKULUM</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-[var(--ink)] tracking-tight">{{ $course->title }}</h1>
                <p class="text-xs sm:text-sm text-[var(--muted)] leading-relaxed max-w-2xl mt-1">{{ $course->description }}</p>
            </div>
            
            <!-- Progress Gauge -->
            <div class="flex items-center gap-4 bg-slate-50 border border-[var(--border)] rounded-2xl p-4 flex-shrink-0">
                <div class="relative w-16 h-16 flex items-center justify-center rounded-full bg-slate-200">
                    <div class="absolute inset-0 rounded-full" style="background: conic-gradient(var(--blue) {{ $completionPercentage }}%, #e2e8f0 0);"></div>
                    <div class="absolute inset-1.5 rounded-full flex flex-col items-center justify-center font-bold text-xs bg-white text-[var(--blue)] font-mono">
                        <span>{{ $completionPercentage }}%</span>
                    </div>
                </div>
                <div>
                    <div class="text-[11px] font-bold text-[var(--ink)]">Progres Belajar</div>
                    <div class="text-[11px] text-[var(--muted)]">{{ $completedNodes }} dari {{ $totalNodes }} materi selesai</div>
                </div>
            </div>
        </div>
    </div>

    @if($contents->isEmpty())
        <!-- Empty State -->
        <div class="w-full bg-white border border-[var(--border)] rounded-2xl text-center py-16 px-6 shadow-sm">
            <div class="w-14 h-14 rounded-full bg-blue-50 text-[var(--blue)] flex items-center justify-center text-2xl mx-auto mb-3 border border-blue-100">
                📡
            </div>
            <h3 class="text-base font-bold text-[var(--ink)] mb-1">Belum Ada Materi Belajar</h3>
            <p class="text-xs text-[var(--muted)] font-mono max-w-md mx-auto">Modul ini belum memiliki materi belajar terpasang. Hubungi admin atau instruktur untuk info lebih lanjut.</p>
        </div>
    @else
        <!-- Stats Widgets -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 w-full">
            <div class="bg-white border border-[var(--border)] rounded-2xl p-4 shadow-sm flex items-center gap-3.5 border-l-4 border-l-pink-500">
                <div class="w-10 h-10 rounded-xl bg-pink-50 text-pink-600 flex items-center justify-center text-base"><i class="fas fa-play-circle"></i></div>
                <div>
                    <div class="text-[10px] uppercase tracking-wider text-[var(--muted)] font-bold">Video</div>
                    <div class="text-base font-black text-[var(--ink)] font-mono">{{ $contents->where('type', 'video')->count() }} Bab</div>
                </div>
            </div>
            <div class="bg-white border border-[var(--border)] rounded-2xl p-4 shadow-sm flex items-center gap-3.5 border-l-4 border-l-indigo-500">
                <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-base"><i class="fas fa-book-open"></i></div>
                <div>
                    <div class="text-[10px] uppercase tracking-wider text-[var(--muted)] font-bold">Artikel/Story</div>
                    <div class="text-base font-black text-[var(--ink)] font-mono">{{ $contents->where('type', 'story')->count() }} Bab</div>
                </div>
            </div>
            <div class="bg-white border border-[var(--border)] rounded-2xl p-4 shadow-sm flex items-center gap-3.5 border-l-4 border-l-amber-500">
                <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-base"><i class="fas fa-question-circle"></i></div>
                <div>
                    <div class="text-[10px] uppercase tracking-wider text-[var(--muted)] font-bold">Kuis Interaktif</div>
                    <div class="text-base font-black text-[var(--ink)] font-mono">{{ $contents->where('type', 'question')->where('question_type', '!=', 'coding')->count() }} Bab</div>
                </div>
            </div>
            <div class="bg-white border border-[var(--border)] rounded-2xl p-4 shadow-sm flex items-center gap-3.5 border-l-4 border-l-blue-500">
                <div class="w-10 h-10 rounded-xl bg-blue-50 text-[var(--blue)] flex items-center justify-center text-base"><i class="fas fa-laptop-code"></i></div>
                <div>
                    <div class="text-[10px] uppercase tracking-wider text-[var(--muted)] font-bold">Coding Lab</div>
                    <div class="text-base font-black text-[var(--ink)] font-mono">{{ $contents->where('type', 'question')->where('question_type', 'coding')->count() }} Bab</div>
                </div>
            </div>
        </div>

        <!-- Contents List -->
        <div class="w-full flex flex-col gap-4">
            <h2 class="text-xs font-extrabold uppercase tracking-widest text-[var(--muted)] font-mono border-b border-[var(--border)] pb-2 mb-1 flex items-center gap-2">
                <i class="fas fa-list-ol text-[var(--blue)]"></i> Kurikulum & Garis Waktu Pelajaran
            </h2>
            
            <div class="flex flex-col gap-3 w-full">
                @foreach($contents as $index => $content)
                    @php
                        $isAnswered = in_array($content->type . ':' . $content->id, $userAnswers);
                        $isQuestion = $content->type === 'question';
                        $isCoding = $isQuestion && isset($content->question_type) && $content->question_type === 'coding';
                        
                        if ($isAnswered) {
                            $badgeText = 'Selesai';
                            $badgeStyle = 'bg-emerald-50 text-emerald-700 border-emerald-200';
                            $iconColor = 'text-emerald-600 bg-emerald-50 border-emerald-200';
                        } elseif ($isCoding) {
                            $badgeText = 'Coding Lab';
                            $badgeStyle = 'bg-blue-50 text-[var(--blue)] border-blue-200';
                            $iconColor = 'text-[var(--blue)] bg-blue-50 border-blue-200';
                        } elseif ($content->type === 'video') {
                            $badgeText = 'Video';
                            $badgeStyle = 'bg-pink-50 text-pink-700 border-pink-200';
                            $iconColor = 'text-pink-600 bg-pink-50 border-pink-200';
                        } elseif ($isQuestion) {
                            $badgeText = 'Kuis';
                            $badgeStyle = 'bg-amber-50 text-amber-700 border-amber-200';
                            $iconColor = 'text-amber-600 bg-amber-50 border-amber-200';
                        } else {
                            $badgeText = 'Story';
                            $badgeStyle = 'bg-indigo-50 text-indigo-700 border-indigo-200';
                            $iconColor = 'text-indigo-600 bg-indigo-50 border-indigo-200';
                        }
                    @endphp
                    
                    <div class="bg-white border border-[var(--border)] rounded-2xl p-4 sm:p-5 flex items-center justify-between gap-4 hover:shadow-sm transition group">
                        
                        <!-- Left Icon -->
                        <div class="w-12 h-12 rounded-xl border flex items-center justify-center flex-shrink-0 text-lg font-bold font-mono {{ $iconColor }}">
                            @if($isAnswered)
                                <i class="fas fa-check-circle text-base"></i>
                            @elseif($isCoding)
                                <i class="fas fa-laptop-code text-base"></i>
                            @elseif($content->type === 'video')
                                <i class="fas fa-play-circle text-base"></i>
                            @elseif($isQuestion)
                                <i class="fas fa-question-circle text-base"></i>
                            @else
                                <i class="fas fa-book-open text-base"></i>
                            @endif
                        </div>

                        <!-- Info details -->
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-3 mb-1">
                                <h3 class="font-bold text-sm md:text-base text-[var(--ink)] truncate group-hover:text-[var(--blue)] transition-colors" title="{{ $content->title }}">
                                    {{ $content->title }}
                                </h3>
                                <span class="px-2.5 py-0.5 text-[9px] uppercase tracking-wider font-extrabold rounded-full border {{ $badgeStyle }}">
                                    {{ $badgeText }}
                                </span>
                                @if($isQuestion)
                                    @php
                                        $difficultyClasses = match ($content->difficulty ?? 'beginner') {
                                            'intermediate' => 'bg-amber-50 text-amber-700 border-amber-200',
                                            'advanced' => 'bg-rose-50 text-rose-700 border-rose-200',
                                            default => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                        };
                                    @endphp
                                    <span class="px-2.5 py-0.5 text-[9px] uppercase tracking-wider font-extrabold rounded-full border {{ $difficultyClasses }}">
                                        {{ $content->difficulty_label }}
                                    </span>
                                @endif
                            </div>

                            @if($content->content)
                                <p class="text-xs text-[var(--muted)] leading-relaxed truncate max-w-2xl mb-1.5">
                                    {{ strip_tags($content->content) }}
                                </p>
                            @endif
                            
                            <div class="flex items-center gap-4 text-[10px] text-[var(--muted)] font-mono">
                                <span><i class="fas fa-layer-group mr-1 text-[var(--blue)]"></i> Materi #{{ $content->order }}</span>
                                @if($isAnswered)
                                    <span class="text-emerald-600 font-bold"><i class="fas fa-check-double mr-1"></i> Telah Diselesaikan</span>
                                @endif
                            </div>
                        </div>

                        <!-- Action play button -->
                        <div class="flex items-center justify-center pl-3 border-l border-[var(--border)]">
                            <a href="{{ route('user.courses.content', [$course->id, $content->type . ':' . $content->id]) }}" 
                               class="px-4 py-2 rounded-xl text-xs font-bold transition flex items-center gap-1.5 {{ $isAnswered ? 'bg-slate-100 hover:bg-slate-200 text-[var(--ink)]' : 'btn-gradient text-white shadow-sm' }}">
                                @if($isAnswered)
                                    <i class="fas fa-redo text-[10px]"></i> Review
                                @else
                                    <i class="fas fa-play text-[10px]"></i> Mulai
                                @endif
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Course Sync Completed Panel -->
        @if($completionPercentage === 100)
            <div class="w-full bg-emerald-50 border border-emerald-200 rounded-2xl p-6 text-center flex flex-col items-center justify-center shadow-sm">
                <div class="text-4xl mb-2">🏆</div>
                <h3 class="text-base font-extrabold text-emerald-800 uppercase tracking-wider mb-1">Semua Materi Selesai!</h3>
                <p class="text-xs text-emerald-700 max-w-md leading-relaxed">Selamat! Anda telah menyelesaikan seluruh bab pembelajaran dalam kursus ini dengan sukses.</p>
                <a href="{{ route('user.courses.results', $course->id) }}" class="mt-4 px-5 py-2.5 rounded-xl bg-emerald-600 text-white font-bold text-xs hover:bg-emerald-700 shadow-sm transition">
                    <i class="fas fa-certificate mr-1.5"></i> Lihat Hasil & Sertifikat
                </a>
            </div>
        @endif
    @endif
</div>
@endsection
