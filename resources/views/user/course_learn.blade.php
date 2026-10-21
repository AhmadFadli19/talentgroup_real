@extends('layouts.app')

@section('title', 'Modul Belajar: ' . $course->title)

@section('content')
@php
    $totalNodes = $contents->count();
    $completedNodes = count($userAnswers);
    $completionPercentage = $totalNodes > 0 ? round(($completedNodes / $totalNodes) * 100) : 0;
@endphp

<div class="max-w-6xl mx-auto py-8 px-4 flex flex-col gap-8 relative items-start">
    
    <!-- Quick Matrix Overview Header -->
    <div class="cyber-card w-full mb-2 relative overflow-hidden bg-[var(--bg2)] border-[var(--accent)]" style="border-left-width: 4px;">
        <div class="absolute inset-0 opacity-5" style="background: repeating-linear-gradient(45deg, transparent, transparent 10px, var(--accent) 10px, var(--accent) 20px);"></div>
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 relative z-10 p-2">
            <div class="flex-1">
                <span class="text-[9px] uppercase tracking-wider text-[var(--cyan)] font-bold font-mono">Modul Belajar</span>
                <h1 class="text-2xl font-black mb-2 text-white" style="font-family: 'Outfit', sans-serif;">{{ $course->title }}</h1>
                <p class="text-xs text-[var(--text2)] leading-relaxed max-w-2xl">{{ $course->description }}</p>
            </div>
            
            <!-- Conic Progress Meter -->
            <div class="relative w-24 h-24 flex-shrink-0 flex items-center justify-center rounded-full border-4 border-white/5 bg-black/20">
                <div class="absolute inset-0 rounded-full" style="background: conic-gradient(var(--cyan) {{ $completionPercentage }}%, transparent 0);"></div>
                <div class="absolute inset-1.5 rounded-full flex flex-col items-center justify-center font-bold text-sm bg-[var(--bg2)] text-[var(--cyan)] font-mono">
                    <span>{{ $completionPercentage }}%</span>
                    <span class="text-[8px] text-[var(--text3)] uppercase">Selesai</span>
                </div>
            </div>
        </div>
    </div>

    @if($contents->isEmpty())
        <!-- Empty State -->
        <div class="cyber-card w-full text-center py-16 bg-[var(--bg2)] border-[var(--border)]">
            <div class="text-5xl mb-6 opacity-40 animate-pulse">📡</div>
            <h3 class="text-base font-bold text-white mb-2">Belum Ada Materi Belajar</h3>
            <p class="text-xs text-[var(--text3)] font-mono">Modul ini belum memiliki materi belajar terpasang. Hubungi admin untuk informasi lebih lanjut.</p>
        </div>
    @else
        <!-- Stats Widgets -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 w-full mb-2">
            <div class="cyber-card p-4 flex items-center gap-4 bg-[var(--bg2)] border-[var(--border)]" style="border-top: 3px solid var(--cyan);">
                <div class="text-2xl">📹</div>
                <div>
                    <div class="text-[8px] uppercase tracking-wider text-[var(--text3)] font-mono font-bold">Video</div>
                    <div class="text-lg font-black text-white font-mono">{{ $contents->where('type', 'video')->count() }} Node</div>
                </div>
            </div>
            <div class="cyber-card p-4 flex items-center gap-4 bg-[var(--bg2)] border-[var(--border)]" style="border-top: 3px solid var(--php);">
                <div class="text-2xl">📘</div>
                <div>
                    <div class="text-[8px] uppercase tracking-wider text-[var(--text3)] font-mono font-bold">Story</div>
                    <div class="text-lg font-black text-white font-mono">{{ $contents->where('type', 'story')->count() }} Node</div>
                </div>
            </div>
            <div class="cyber-card p-4 flex items-center gap-4 bg-[var(--bg2)] border-[var(--border)]" style="border-top: 3px solid var(--yellow);">
                <div class="text-2xl">❓</div>
                <div>
                    <div class="text-[8px] uppercase tracking-wider text-[var(--text3)] font-mono font-bold">Kuis</div>
                    <div class="text-lg font-black text-white font-mono">{{ $contents->where('type', 'question')->where('question_type', '!=', 'coding')->count() }} Node</div>
                </div>
            </div>
            <div class="cyber-card p-4 flex items-center gap-4 bg-[var(--bg2)] border-[var(--border)]" style="border-top: 3px solid var(--green);">
                <div class="text-2xl">💻</div>
                <div>
                    <div class="text-[8px] uppercase tracking-wider text-[var(--text3)] font-mono font-bold">Coding</div>
                    <div class="text-lg font-black text-white font-mono">{{ $contents->where('type', 'question')->where('question_type', 'coding')->count() }} Node</div>
                </div>
            </div>
        </div>

        <!-- Contents List (Coursera Inspired Node Timeline) -->
        <div class="w-full flex flex-col gap-4">
            <h2 class="text-xs font-extrabold uppercase tracking-widest text-[var(--text2)] font-mono border-b border-[var(--border)] pb-2 mb-2">
                <i class="fas fa-list-ol mr-1 text-[var(--cyan)]"></i> Kurikulum & Garis Waktu Pelajaran
            </h2>
            
            <div class="flex flex-col gap-3 w-full">
                @foreach($contents as $index => $content)
                    @php
                        $isAnswered = in_array($content->type . ':' . $content->id, $userAnswers);
                        $isQuestion = $content->type === 'question';
                        $isCoding = $isQuestion && isset($content->question_type) && $content->question_type === 'coding';
                        
                        // Select border color based on completion & type
                        if ($isAnswered) {
                            $nodeColor = 'var(--green)';
                            $badgeText = 'Selesai';
                            $badgeBorder = 'border-[var(--green)] text-[var(--green)] bg-green-500/5';
                        } elseif ($isCoding) {
                            $nodeColor = 'var(--cyan)';
                            $badgeText = 'Coding';
                            $badgeBorder = 'border-[var(--cyan)] text-[var(--cyan)] bg-cyan-500/5';
                        } elseif ($content->type === 'video') {
                            $nodeColor = 'var(--pink)';
                            $badgeText = 'Video';
                            $badgeBorder = 'border-[var(--pink)] text-[var(--pink)] bg-pink-500/5';
                        } elseif ($isQuestion) {
                            $nodeColor = 'var(--yellow)';
                            $badgeText = 'Kuis';
                            $badgeBorder = 'border-[var(--yellow)] text-[var(--yellow)] bg-yellow-500/5';
                        } else {
                            $nodeColor = 'var(--php)';
                            $badgeText = 'Story';
                            $badgeBorder = 'border-[var(--php)] text-[var(--php)] bg-purple-500/5';
                        }
                    @endphp
                    
                    <div class="cyber-card flex gap-4 md:gap-6 p-5 bg-[var(--bg2)] border-[var(--border)] transition-all hover:translate-x-1" 
                         style="border-left-width: 4px; border-left-color: {{ $nodeColor }};">
                        
                        <!-- Number Icon Badge -->
                        <div class="w-12 h-12 rounded-xl border flex items-center justify-center flex-shrink-0 text-xl font-bold font-mono" 
                             style="background: rgba(0,0,0,0.2); border-color: {{ $nodeColor }}; color: {{ $nodeColor }};">
                            @if($isAnswered)
                                <i class="fas fa-check-circle text-base"></i>
                            @elseif($isCoding)
                                💻
                            @elseif($content->type === 'video')
                                📹
                            @elseif($isQuestion)
                                ❓
                            @else
                                📘
                            @endif
                        </div>

                        <!-- Info details -->
                        <div class="flex-1 flex flex-col justify-center min-w-0">
                            <div class="flex justify-between items-start gap-4 mb-2">
                                <h3 class="font-extrabold text-sm md:text-base text-white truncate" title="{{ $content->title }}">
                                    {{ $content->title }}
                                </h3>
                                <span class="px-2 py-0.5 text-[8px] uppercase tracking-wider font-extrabold rounded border flex-shrink-0 {{ $badgeBorder }}">
                                    {{ $badgeText }}
                                </span>
                            </div>

                            @if($content->content)
                                <p class="text-[11px] text-[var(--text2)] leading-relaxed truncate max-w-3xl mb-2 font-mono">
                                    {{ strip_tags($content->content) }}
                                </p>
                            @endif
                            
                            <div class="flex items-center gap-4 text-[9px] text-[var(--text3)] font-mono uppercase">
                                <span><i class="fas fa-layer-group mr-1 text-[var(--cyan)]"></i> Urutan ke-{{ $content->order }}</span>
                                @if($isAnswered)
                                    <span class="text-[var(--green)]"><i class="fas fa-check-double mr-1"></i> Data Tersinkron</span>
                                @endif
                            </div>
                        </div>

                        <!-- Action play button -->
                        <div class="flex items-center justify-center pl-4 border-l border-[var(--border)]">
                            <a href="{{ route('user.courses.content', [$course->id, $content->type . ':' . $content->id]) }}" 
                               class="w-10 h-10 rounded-full border border-[var(--border)] hover:border-white flex items-center justify-center text-sm transition-all hover:scale-105"
                               style="color: {{ $nodeColor }}; border-color: {{ $nodeColor }}60; background: {{ $nodeColor }}10;">
                                @if($isAnswered)
                                    <i class="fas fa-eye"></i>
                                @else
                                    <i class="fas fa-play pl-0.5"></i>
                                @endif
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Course Sync Completed Panel -->
        @if($completionPercentage === 100)
            <div class="cyber-card w-full mt-6 p-6 border-[var(--green)] bg-green-500/5 text-center flex flex-col items-center justify-center">
                <div class="text-4xl mb-4 animate-bounce">🏆</div>
                <h3 class="text-sm md:text-base font-extrabold text-[var(--green)] uppercase tracking-wider mb-1">Seluruh Modul Sinkron!</h3>
                <p class="text-xs text-[var(--text2)] font-mono max-w-md">Selamat! Anda telah menyelesaikan semua tahapan pembelajaran dalam modul ini dengan sukses.</p>
            </div>
        @else
            <div class="cyber-card w-full mt-6 p-6 border-[var(--accent)] bg-[var(--accent)]/5 text-center flex flex-col items-center justify-center">
                <div class="text-3xl mb-3 opacity-80 animate-pulse">⚡</div>
                <h3 class="text-sm md:text-base font-extrabold text-[var(--cyan)] uppercase tracking-wider mb-1">Modul Pembelajaran Aktif</h3>
                <p class="text-xs text-[var(--text2)] font-mono max-w-md">Lanjutkan belajar node berikutnya untuk mencapai sinkronisasi pembelajaran 100%.</p>
            </div>
        @endif
    @endif
</div>
@endsection
