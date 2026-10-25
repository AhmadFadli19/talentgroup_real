@extends('layouts.app')

@section('title', 'Pembelajaran: ' . $content->title)

@section('content')

@php
    $allContents = $course->allContents();
    
    // Get current index based on database order
    $currentIndex = $allContents->search(function ($item) use ($content) {
        return $item->type === $content->type && $item->id === $content->id;
    });
    
    // Get previous and next content based on database order
    $previousContent = $currentIndex > 0 ? $allContents[$currentIndex - 1] : null;
    $nextContent = $currentIndex < $allContents->count() - 1 ? $allContents[$currentIndex + 1] : null;
    $progress = $allContents->count() > 0 ? round((($currentIndex + 1) / $allContents->count()) * 100) : 0;
    
    // Video Embed Link Parser
    $embedUrl = '';
    if ($content->type === 'video') {
        if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/ ]{11})/', $content->video_url, $matches)) {
            $embedUrl = 'https://www.youtube.com/embed/' . $matches[1] . '?autoplay=0&rel=0';
        } elseif (preg_match('/drive\.google\.com\/file\/d\/([a-zA-Z0-9_-]+)/', $content->video_url, $matches)) {
            $embedUrl = 'https://drive.google.com/file/d/' . $matches[1] . '/preview';
        }
    }
@endphp

<!-- Prism Syntax Highlighting Themes -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/themes/prism-tomorrow.min.css">

<style>
/* Clean typography and responsive design for course reading articles */
.course-story-article {
    word-break: break-word;
    overflow-wrap: break-word;
    color: var(--text2) !important;
}
.course-story-article p {
    color: var(--text2) !important;
    margin-bottom: 1.25rem;
    line-height: 1.8;
    font-size: 15px;
}
.course-story-article strong {
    color: var(--text) !important;
    font-weight: 700;
}
.course-story-article em {
    color: var(--text2) !important;
}
.course-story-article h1, 
.course-story-article h2, 
.course-story-article h3, 
.course-story-article h4 {
    font-family: 'Outfit', sans-serif;
    color: var(--text) !important;
    letter-spacing: -0.015em;
    font-weight: 800;
}
.course-story-article h1 { font-size: 1.85rem; margin-top: 1.5rem; margin-bottom: 1rem; }
.course-story-article h2 { font-size: 1.45rem; margin-top: 2rem; margin-bottom: 0.85rem; border-top: 1px solid var(--border); padding-top: 1.25rem; }
.course-story-article h3 { font-size: 1.2rem; margin-top: 1.75rem; margin-bottom: 0.75rem; }
.course-story-article h4 { font-size: 1.05rem; margin-top: 1.25rem; margin-bottom: 0.5rem; }

.course-story-article ul, 
.course-story-article ol {
    color: var(--text2) !important;
    margin-bottom: 1.25rem;
    padding-left: 1.5rem;
    font-size: 14.5px;
}
.course-story-article li {
    margin-bottom: 0.6rem;
    line-height: 1.7;
}
.course-story-article code:not(pre code) {
    background: rgba(6, 182, 212, 0.12) !important;
    color: var(--cyan) !important;
    border: 1px solid rgba(6, 182, 212, 0.25) !important;
    border-radius: 0.375rem;
    padding: 0.15rem 0.45rem;
    font-family: 'Fira Code', monospace !important;
    font-size: 13px !important;
    font-weight: 600;
}
.course-story-article pre {
    background: #070c18 !important;
    border-radius: 0 0 0.75rem 0.75rem;
    margin: 0 !important;
    padding: 1.1rem !important;
}
.course-story-article pre code {
    font-family: 'Fira Code', monospace !important;
    font-size: 13.5px !important;
    line-height: 1.65 !important;
    color: #e2e8f0 !important;
    text-shadow: none !important;
    background: transparent !important;
    padding: 0 !important;
    border: none !important;
}
.course-story-article .code-frame-block {
    margin-top: 1.5rem;
    margin-bottom: 1.5rem;
}
</style>

<div id="learning-root" x-data="learningData()" class="max-w-6xl mx-auto py-6 px-4">

    <!-- Top learning bar showing progress -->
    <div class="cyber-card mb-6 p-5 bg-[var(--bg2)] border-[var(--border)] relative overflow-hidden" style="border-left-width: 4px; border-left-color: var(--cyan);">
        <div class="absolute inset-0 opacity-5" style="background: repeating-linear-gradient(45deg, transparent, transparent 10px, var(--cyan) 10px, var(--cyan) 20px);"></div>
        <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-4">
            <div>
                <span class="text-[9px] uppercase tracking-wider text-[var(--text3)] font-mono font-bold">{{ $course->title }}</span>
                <h1 class="text-lg md:text-xl font-black text-white leading-tight" style="font-family: 'Outfit', sans-serif;">{{ $content->title }}</h1>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('user.courses.learn', $course->id) }}" class="cyber-btn text-[10px] py-2 flex items-center gap-1.5 outline">
                    <i class="fas fa-network-wired text-sm"></i> Peta Modul
                </a>
            </div>
        </div>
        
        <!-- Progress track -->
        <div class="relative z-10">
            <div class="flex items-center justify-between text-[10px] uppercase tracking-wider font-mono mb-1.5" style="color: var(--text2);">
                <span>Materi {{ $currentIndex + 1 }} dari {{ $allContents->count() }}</span>
                <span class="text-[var(--cyan)] font-extrabold">{{ $progress }}% Selesai</span>
            </div>
            <div class="w-full h-1.5 rounded-full overflow-hidden" style="background: var(--bg);">
                <div class="h-full relative" style="width: {{ $progress }}%; background: var(--cyan); box-shadow: 0 0 10px var(--cyan);"></div>
            </div>
        </div>
    </div>

    <!-- Mobile Navigation Bar Toggle (Hidden on Desktop) -->
    @if($content->type !== 'html')
        <div class="lg:hidden flex items-center justify-between p-3.5 mb-4 rounded-xl border border-[var(--border)] bg-[var(--bg2)] shadow-sm">
            <div class="flex items-center gap-2">
                <i class="fas fa-compass text-[var(--accent)] text-xs"></i>
                <span class="text-xs font-bold text-[var(--text)]">Materi {{ $currentIndex + 1 }} dari {{ $allContents->count() }}</span>
            </div>
            <button @click="navOpen = true" class="cyber-btn text-[9px] py-1.5 px-3 flex items-center gap-1.5">
                <i class="fas fa-list-ul"></i> Daftar Modul
            </button>
        </div>
    @endif

    <!-- Mobile Backdrop Overlay -->
    @if($content->type !== 'html')
        <div x-show="navOpen" 
             @click="navOpen = false" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="lg:hidden fixed inset-0 bg-black/60 backdrop-blur-sm z-[1001]" 
             style="display: none;"></div>
    @endif

    <!-- main 2-column workspace layout -->
    <div class="@if($content->type === 'html') w-full flex flex-col gap-6 @else grid grid-cols-1 lg:grid-cols-4 gap-6 items-start @endif">
        
        @if($content->type !== 'html')
            <!-- Left: Navigator Sidebar (Desktop Sticky / Mobile Drawer) -->
            <div :class="navOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'" 
                 class="fixed inset-y-0 left-0 w-[290px] lg:w-auto lg:static lg:block lg:col-span-1 z-[1002] lg:z-10 bg-[var(--surface)] lg:bg-transparent border-r lg:border-r-0 border-[var(--border)] p-4 lg:p-0 transition-transform duration-300 ease-in-out flex flex-col">
                
                <!-- Mobile Close Button (Hidden on Desktop) -->
                <div class="lg:hidden flex justify-between items-center mb-4 pb-3 border-b border-[var(--border)]">
                    <span class="text-xs font-bold uppercase tracking-wider text-[var(--text)]">Daftar Modul</span>
                    <button @click="navOpen = false" class="text-[var(--text3)] hover:text-[var(--text)] p-1">
                        <i class="fas fa-times text-sm"></i>
                    </button>
                </div>

                <div class="cyber-card p-4 bg-[var(--bg2)] border-[var(--border)] lg:sticky lg:top-24 max-h-[calc(100vh-140px)] flex flex-col h-full lg:h-auto">
                    <h3 class="text-[10px] font-black uppercase tracking-wider mb-4 flex items-center gap-2 border-b border-[var(--border)] pb-3" style="color: var(--text);">
                        <i class="fas fa-compass" style="color: var(--accent);"></i> Navigator Materi
                    </h3>
                    
                    <div class="flex-1 overflow-y-auto pr-1 flex flex-col gap-2 custom-scrollbar">
                        @foreach($allContents as $index => $navContent)
                            @php
                                $isCurrent = $navContent->type === $content->type && $navContent->id === $content->id;
                                $navAnswer = \App\Models\UserAnswer::where('user_id', auth()->id())
                                    ->where('content_type', $navContent->type)
                                    ->where('content_id', $navContent->id)
                                    ->first();
                                $isNavCompleted = $navAnswer !== null;
                                
                                // In next_only mode, previous modules cannot be navigated back to
                                $isLockedPast = $course->isNextOnlyNavigation() && $index < $currentIndex;

                                // Define clean icon and labels
                                if ($isLockedPast) {
                                    $icon = '<i class="fas fa-lock" style="color: var(--text3); font-size: 11px;"></i>';
                                    $borderStyle = 'border-color: var(--border); opacity: 0.5; pointer-events: none; cursor: not-allowed;';
                                    $bgStyle = 'background: rgba(0, 0, 0, 0.15);';
                                } elseif ($isNavCompleted) {
                                    $icon = '<i class="fas fa-check-circle" style="color: var(--green); font-size: 13px;"></i>';
                                    $borderStyle = 'border-color: rgba(16, 185, 129, 0.25);';
                                    $bgStyle = 'background: rgba(16, 185, 129, 0.03);';
                                } else {
                                    $icon = '<i class="far fa-circle" style="color: var(--text3); font-size: 13px;"></i>';
                                    $borderStyle = 'border-color: var(--border);';
                                    $bgStyle = 'background: transparent;';
                                }
                                
                                if ($isCurrent) {
                                    $borderStyle = 'border-left: 4px solid var(--accent); border-color: rgba(0, 86, 210, 0.4);';
                                    $bgStyle = 'background: rgba(0, 86, 210, 0.04);';
                                }
                            @endphp
                            
                            <a href="{{ $isLockedPast ? 'javascript:void(0)' : route('user.courses.content', [$course->id, $navContent->type . ':' . $navContent->id]) }}" 
                               class="flex items-center gap-3 p-3 border rounded-xl transition-all {{ $isLockedPast ? '' : 'hover:translate-x-1 hover:shadow-sm' }}"
                               style="{{ $borderStyle }} {{ $bgStyle }}">
                                
                                <!-- Status Checkbox Icon -->
                                <div class="w-5 h-5 flex items-center justify-center flex-shrink-0">
                                    {!! $icon !!}
                                </div>
                                
                                <!-- Text content info -->
                                <div class="flex-1 min-w-0">
                                    <div class="text-[11.5px] font-extrabold truncate" style="color: {{ $isCurrent ? 'var(--text)' : 'var(--text2)' }};">{{ $navContent->title }}</div>
                                    <div class="text-[8px] uppercase tracking-wider font-bold mt-0.5 flex items-center gap-1.5" style="font-family: 'Fira Code', monospace;">
                                        @if($isLockedPast)
                                            <span class="text-slate-400"><i class="fas fa-lock mr-0.5"></i> Selesai (Terkunci)</span>
                                        @elseif($navContent->type === 'video')
                                            <span style="color: var(--cyan);"><i class="fas fa-play-circle mr-0.5"></i> Video</span>
                                        @elseif($navContent->type === 'question')
                                            <span style="color: var(--orange);"><i class="fas fa-question-circle mr-0.5"></i> Kuis</span>
                                        @elseif($navContent->type === 'html')
                                            <span style="color: #06b6d4;"><i class="fas fa-code mr-0.5"></i> Live HTML</span>
                                        @else
                                            <span style="color: var(--php);"><i class="fas fa-book-open mr-0.5"></i> Bacaan</span>
                                        @endif
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        <!-- Right: Active Content Display -->
        <div class="@if($content->type === 'html') w-full @else lg:col-span-3 @endif flex flex-col gap-6">
            
            <!-- VIDEO CONTAINER TYPE -->
            @if($content->type === 'video')
                <div class="cyber-card p-0 overflow-hidden bg-[var(--bg2)] border-[var(--border)]">
                    <!-- Video Embed Frame -->
                    @if($embedUrl)
                        <div class="relative w-full aspect-ratio: 16/9 overflow-hidden bg-black" style="aspect-ratio: 16/9;">
                            <iframe src="{{ $embedUrl }}" 
                                    style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: 0;" 
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                                    allowfullscreen></iframe>
                        </div>
                    @else
                        <!-- Fallback empty player placeholder -->
                        <div class="aspect-ratio: 16/9 bg-black/60 flex flex-col items-center justify-center gap-4 text-center p-8" style="aspect-ratio: 16/9;">
                            <div class="w-16 h-16 rounded-full bg-red-500/10 border border-red-500/40 flex items-center justify-center text-red-500 text-2xl">
                                <i class="fas fa-video-slash"></i>
                            </div>
                            <div>
                                <h4 class="font-extrabold text-white text-sm">Pemutar Video Gagal Dimuat</h4>
                                <p class="text-xs text-[var(--text3)] font-mono mt-1">Video URL tidak valid atau tidak didukung.</p>
                            </div>
                        </div>
                    @endif

                    <!-- Video Text Details -->
                    <div class="p-6">
                        <span class="text-[9px] uppercase tracking-wider font-extrabold text-[var(--pink)] font-mono flex items-center gap-1 mb-2">
                            <i class="fas fa-video"></i> Video Deskripsi & Catatan
                        </span>
                        <h2 class="text-base font-extrabold text-white mb-4">{{ $content->title }}</h2>
                        <div class="course-story-article text-[14px] leading-relaxed">
                            {!! \App\Services\ModuleMarkdownParser::parse($content->content) !!}
                        </div>
                    </div>
                </div>
            @endif

            <!-- STORY CONTAINER TYPE -->
            @if($content->type === 'story')
                <div class="cyber-card p-6 bg-[var(--bg2)] border-[var(--border)] flex flex-col gap-6">
                    <span class="text-[9px] uppercase tracking-wider font-extrabold text-[var(--php)] font-mono flex items-center gap-1.5">
                        <i class="fas fa-book-open"></i> Story / Materi Bacaan
                    </span>

                    <!-- Voiceover Speaker Bar Placeholder / Real Player -->
                    @if($content->use_audio)
                        <div class="p-3.5 rounded-xl border border-[var(--border)] bg-black/20 flex items-center justify-between gap-4">
                            <div class="flex items-center gap-3">
                                @if($content->audio_path)
                                    <audio x-ref="audioPlayer" src="{{ route('storage.stream', $content->audio_path) }}" @timeupdate="audioProgress = ($event.target.currentTime / $event.target.duration) * 100" @ended="audioPlaying = false; audioProgress = 0" style="display: none;"></audio>
                                @endif
                                <button @click="togglePlayAudio({{ $content->audio_path ? 'true' : 'false' }})" class="w-8 h-8 rounded-full border border-[var(--border)] hover:border-white bg-black/30 flex items-center justify-center text-xs text-[var(--cyan)] transition-all">
                                    <i class="fas" :class="audioPlaying ? 'fa-pause' : 'fa-play pl-0.5'"></i>
                                </button>
                                <div class="flex flex-col">
                                    <span class="text-[10px] font-bold text-white leading-tight">Dengarkan Materi Suara (AI voice)</span>
                                    <span class="text-[8px] text-[var(--text3)] font-mono uppercase mt-0.5" x-text="audioPlaying ? 'DIPUTAR - AI Voice Active' : 'SIAP - Klik Untuk Memutar'"></span>
                                </div>
                            </div>
                            <div class="flex-1 max-w-[200px] h-1.5 rounded-full bg-black/30 overflow-hidden relative hidden sm:block">
                                <div class="h-full bg-[var(--cyan)]" :style="'width: ' + audioProgress + '%'"></div>
                            </div>
                        </div>
                    @endif

                    <!-- Story Optional Video Embed -->
                    @if($content->use_video && $content->video_url)
                        @php
                            $storyEmbedUrl = '';
                            if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/ ]{11})/', $content->video_url, $storyMatches)) {
                                $storyEmbedUrl = 'https://www.youtube.com/embed/' . $storyMatches[1] . '?autoplay=0&rel=0';
                            } elseif (preg_match('/drive\.google\.com\/file\/d\/([a-zA-Z0-9_-]+)/', $content->video_url, $storyMatches)) {
                                $storyEmbedUrl = 'https://drive.google.com/file/d/' . $storyMatches[1] . '/preview';
                            }
                        @endphp
                        @if($storyEmbedUrl)
                            <div class="relative w-full aspect-ratio: 16/9 overflow-hidden bg-black rounded-xl border border-[var(--border)]" style="aspect-ratio: 16/9;">
                                <iframe src="{{ $storyEmbedUrl }}" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: 0;" allowfullscreen></iframe>
                            </div>
                        @endif
                    @endif

                    <!-- Story Optional Image Upload -->
                    @if($content->use_image && $content->image_path)
                        <div class="rounded-xl overflow-hidden border border-[var(--border)] max-h-[380px] bg-black/10 flex items-center justify-center">
                            <img src="{{ route('storage.stream', $content->image_path) }}" class="w-full h-full object-contain" alt="Story Illustration" style="max-height: 380px;">
                        </div>
                    @endif

                    <!-- Clean reading article content (Parsed from Markdown to Rich HTML) -->
                    <article class="course-story-article text-[14.5px] leading-relaxed border-b border-[var(--border)] pb-8 pt-2">
                        {!! \App\Services\ModuleMarkdownParser::parse($content->content) !!}
                    </article>

                    <!-- Save Notes Block -->
                    <div x-data="{ showNote: false, savedNote: localStorage.getItem('note_{{ $content->id }}') || '' }" class="w-full">
                        <button @click="showNote = !showNote" class="text-[11px] font-bold text-[var(--cyan)] hover:underline flex items-center gap-1 mb-2">
                            <i class="fas fa-edit"></i> <span x-text="showNote ? 'Tutup Catatan' : 'Tulis Catatan Pelajaran'"></span>
                        </button>
                        <div x-show="showNote" x-transition class="flex flex-col gap-3 p-4 rounded-xl border border-[var(--border)] bg-black/20">
                            <label class="text-[9px] uppercase tracking-wider text-[var(--text3)] font-semibold">Tulis catatan belajar anda:</label>
                            <textarea x-model="savedNote" @input="localStorage.setItem('note_{{ $content->id }}', savedNote)" class="cyber-input w-full min-h-[90px] font-mono text-[10px]" placeholder="Ketik ringkasan atau bagian penting di sini untuk disimpan secara otomatis..."></textarea>
                        </div>
                    </div>
                </div>
            @endif

            <!-- QUESTION (QUIZ) TYPE -->
            @if($content->type === 'question' && !$content->isCoding())
                <div class="cyber-card p-6 bg-[var(--bg2)] border-[var(--border)] flex flex-col gap-6">
                    <div class="flex justify-between items-center border-b border-[var(--border)] pb-3">
                        <span class="text-[9px] uppercase tracking-wider font-extrabold text-[var(--yellow)] font-mono flex items-center gap-1.5">
                            <i class="fas fa-question-circle"></i> Evaluasi Kuis Soal
                        </span>
                        
                        <!-- Points badge -->
                        <span class="px-2.5 py-1 rounded-full border border-yellow-500/30 text-[var(--yellow)] font-bold text-[10px] font-mono bg-yellow-500/5">
                            ⚡ 10 Pts
                        </span>
                    </div>

                    <!-- Question content (Parsed Rich Markdown) -->
                    <div class="course-story-article text-xs md:text-sm font-semibold leading-relaxed bg-black/15 p-4 sm:p-5 border border-[var(--border)] rounded-xl">
                        {!! \App\Services\ModuleMarkdownParser::parse($content->content) !!}
                    </div>

                    <!-- Answer Options Form -->
                    <form action="{{ route('user.courses.answer', [$course->id, $content->type . ':' . $content->id]) }}" 
                          method="POST" 
                          class="flex flex-col gap-4">
                        @csrf
                        
                        @php
                            $revealAnswers = $course->isInstantQuizFeedback() || ($course->isEndQuizFeedback() && ($userCourse->is_completed ?? false));
                            $displayOptions = $content->options ?? [];
                            if ($course->isShuffleOptions() && is_array($displayOptions) && count($displayOptions) > 1) {
                                $userId = auth()->id() ?? 0;
                                $seededOptions = [];
                                foreach ($displayOptions as $opt) {
                                    $seededOptions[] = [
                                        'val' => $opt,
                                        'hash' => md5($course->id . '_' . $userId . '_' . $content->id . '_' . $opt)
                                    ];
                                }
                                usort($seededOptions, fn($a, $b) => strcmp($a['hash'], $b['hash']));
                                $displayOptions = array_column($seededOptions, 'val');
                            }
                        @endphp

                        <div class="flex flex-col gap-2.5">
                            @foreach($displayOptions as $index => $option)
                                @php
                                    $isCorrectAnswer = $option === $content->correct_answer;
                                    $isSelected = $userAnswer && $userAnswer->answer === $option;
                                    $isWrongSelection = $isSelected && !$userAnswer->is_correct;
                                    
                                    // Custom colors for option selectors based on checked state and corrections
                                    $borderClass = 'border-[var(--border)]';
                                    $bgClass = 'bg-black/10';
                                    $iconClass = 'fa-circle text-transparent';
                                    
                                    if ($userAnswer) {
                                        if ($revealAnswers) {
                                            if ($isCorrectAnswer) {
                                                $borderClass = 'border-[var(--green)]';
                                                $bgClass = 'bg-green-500/10';
                                                $iconClass = 'fa-check-circle text-[var(--green)]';
                                            } elseif ($isWrongSelection) {
                                                $borderClass = 'border-[var(--red)]';
                                                $bgClass = 'bg-red-500/10';
                                                $iconClass = 'fa-times-circle text-[var(--red)]';
                                            }
                                        } else {
                                            // When answers are hidden until end or none: show selected option neutrally without revealing correctness
                                            if ($isSelected) {
                                                $borderClass = 'border-[var(--cyan)] shadow-sm';
                                                $bgClass = 'bg-cyan-500/10';
                                                $iconClass = 'fa-dot-circle text-[var(--cyan)]';
                                            }
                                        }
                                    }
                                @endphp
                                
                                <label class="flex items-center gap-3 p-3.5 border rounded-xl cursor-pointer transition-all hover:bg-white/[0.02] {{ $borderClass }} {{ $bgClass }}">
                                    <!-- Hidden input if already answered -->
                                    <input type="radio" 
                                           name="answer" 
                                           value="{{ $option }}" 
                                           required 
                                           class="hidden" 
                                           {{ $userAnswer ? 'disabled' : '' }}
                                           {{ $isSelected ? 'checked' : '' }}
                                           @change="selectedAnswer = '{{ $option }}'">
                                    
                                    <!-- Bullet indicator -->
                                    <div class="w-5 h-5 rounded-full border border-white/10 flex items-center justify-center flex-shrink-0 text-xs">
                                        @if($userAnswer)
                                            <i class="fas {{ $iconClass }} text-sm"></i>
                                        @else
                                            <div class="w-2.5 h-2.5 rounded-full transition-all"
                                                 :style="selectedAnswer === '{{ $option }}' ? 'background: var(--yellow);' : 'background: transparent;'"></div>
                                        @endif
                                    </div>

                                    <div class="flex-1 flex items-center justify-between">
                                        <span class="text-xs text-[var(--text2)]">{{ chr(65 + $index) }}. {{ $option }}</span>
                                        @if($userAnswer && $isSelected && !$revealAnswers)
                                            <span class="text-[10px] font-mono text-[var(--cyan)] bg-cyan-500/10 px-2 py-0.5 rounded border border-cyan-500/20 font-bold">Pilihan Anda</span>
                                        @endif
                                    </div>
                                </label>
                            @endforeach
                        </div>

                        <!-- Submit Button / Correction alert -->
                        @if($userAnswer)
                            @if($revealAnswers)
                                @if($userAnswer->is_correct)
                                    <div class="p-4 rounded-xl border border-[var(--green)] bg-green-500/10 text-[var(--green)] text-xs font-semibold flex items-center gap-2">
                                        <i class="fas fa-check-circle text-base"></i> Jawaban Anda Benar! (+10 Pts)
                                    </div>
                                @else
                                    <div class="p-4 rounded-xl border border-[var(--red)] bg-red-500/10 text-[var(--red)] text-xs font-semibold flex items-center gap-2">
                                        <i class="fas fa-times-circle text-base"></i> Jawaban masih salah. Silakan kaji materi kembali sebelum mencoba lagi!
                                    </div>
                                @endif
                            @else
                                <div class="p-4 rounded-xl border border-blue-500/30 bg-blue-500/10 text-cyan-300 text-xs font-semibold flex items-start gap-3">
                                    <i class="fas fa-info-circle text-base mt-0.5 text-[var(--cyan)]"></i>
                                    <div>
                                        <div class="font-bold text-white mb-0.5">Jawaban Anda Berhasil Disimpan</div>
                                        @if($course->isNoneQuizFeedback())
                                            <p class="text-[11px] text-slate-300 font-normal">Kunci jawaban untuk materi/kuis ini dirahasiakan.</p>
                                        @else
                                            <p class="text-[11px] text-slate-300 font-normal">Hasil evaluasi dan kunci jawaban akan ditampilkan secara lengkap setelah Anda menyelesaikan seluruh materi kursus.</p>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        @else
                            <div class="flex justify-end mt-2">
                                <button type="submit" class="cyber-btn font-bold px-6 py-2.5" style="background: linear-gradient(135deg, var(--yellow), var(--orange2)); box-shadow: 0 0 16px rgba(234,179,8,0.25);">
                                    <i class="fas fa-clipboard-check mr-2"></i> Verifikasi Jawaban Kuis
                                </button>
                            </div>
                        @endif
                    </form>
                </div>
            @endif

            <!-- HTML RENDER OVERRIDE CONTAINER -->
            @if($content->type === 'html')
                <div class="w-full flex flex-col gap-6">
                    <!-- Title & Optional Description -->
                    <div class="px-2">
                        <span class="text-[9px] uppercase tracking-wider font-extrabold text-[var(--cyan)] font-mono flex items-center gap-1.5 mb-2">
                            <i class="fas fa-desktop"></i> Materi Interaktif HTML
                        </span>
                        <h2 class="text-xl font-black text-white leading-tight" style="font-family: 'Outfit', sans-serif;">{{ $content->title }}</h2>

                        @if($content->content)
                            <article class="course-story-article text-[13.5px] leading-relaxed mt-3">
                                {!! \App\Services\ModuleMarkdownParser::parse($content->content) !!}
                            </article>
                        @endif
                    </div>

                    <!-- Compiled Live Preview Display (Borderless & Full Screen width) -->
                    @php
                        $compiledHtml = '<!DOCTYPE html><html><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><style>' . ($content->css_code ?? '') . '</style></head><body style="margin:0; padding:0; font-family:sans-serif; background:transparent;">' . ($content->html_code ?? '') . '<script>' . ($content->js_code ?? '') . '<\/script></body></html>';
                    @endphp
                    <div class="w-full bg-[#0d1325] border border-white/5 rounded-2xl overflow-hidden shadow-2xl relative" style="min-height: 750px;">
                        <iframe class="w-full h-full border-0 absolute inset-0" srcdoc="{{ $compiledHtml }}" style="min-height: 750px; width: 100%; border: none;" allowfullscreen></iframe>
                    </div>
                </div>
            @endif

            <!-- Navigation buttons at bottom -->
            <div class="flex justify-between items-center p-4 rounded-xl border border-[var(--border)] bg-[var(--bg2)]">
                @if($previousContent && !$course->isNextOnlyNavigation())
                    <a href="{{ route('user.courses.content', [$course->id, $previousContent->type . ':' . $previousContent->id]) }}" 
                       class="cyber-btn text-[11px] px-4 py-2 outline">
                        <i class="fas fa-arrow-left mr-2"></i> Sebelumnya
                    </a>
                @else
                    <div></div>
                @endif

                @if($nextContent)
                    <a href="{{ route('user.courses.content', [$course->id, $nextContent->type . ':' . $nextContent->id]) }}" 
                       class="cyber-btn text-[11px] px-4 py-2" style="background: linear-gradient(135deg, var(--cyan), var(--cyan2)); box-shadow: 0 0 16px rgba(6,182,212,0.25);">
                        Selanjutnya <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                @else
                    <!-- Final Results Link -->
                    <a href="{{ route('user.courses.results', $course->id) }}" 
                       class="cyber-btn text-[11px] px-4 py-2" style="background: linear-gradient(135deg, var(--green), #059669); box-shadow: 0 0 16px rgba(16,185,129,0.25);">
                        Lihat Hasil Modul <i class="fas fa-trophy ml-2"></i>
                    </a>
                @endif
            </div>

        </div>

    </div>
</div>

<script>
function learningData() {
    return {
        navOpen: false,
        selectedAnswer: '',
        audioPlaying: false,
        audioProgress: 0,
        audioInterval: null,

        togglePlayAudio(hasRealFile = false) {
            if (hasRealFile) {
                const player = this.$refs.audioPlayer;
                if (!player) return;
                if (this.audioPlaying) {
                    player.pause();
                    this.audioPlaying = false;
                } else {
                    player.play();
                    this.audioPlaying = true;
                }
            } else {
                this.audioPlaying = !this.audioPlaying;
                if (this.audioPlaying) {
                    this.audioInterval = setInterval(() => {
                        this.audioProgress += 2;
                        if (this.audioProgress >= 100) {
                            clearInterval(this.audioInterval);
                            this.audioPlaying = false;
                            this.audioProgress = 0;
                        }
                    }, 200);
                } else {
                    clearInterval(this.audioInterval);
                }
            }
        }
    };
}

// Global Copy Code Block Helper
function copyCodeBlock(codeId, button) {
    const codeEl = document.getElementById(codeId);
    if (!codeEl) return;

    const textToCopy = codeEl.innerText || codeEl.textContent;
    navigator.clipboard.writeText(textToCopy).then(() => {
        const icon = button.querySelector('i');
        const text = button.querySelector('span');
        const origIcon = icon ? icon.className : '';
        const origText = text ? text.innerText : '';

        if (icon) icon.className = 'fas fa-check text-emerald-400';
        if (text) text.innerText = 'Tersalin!';
        button.classList.add('border-emerald-500/50', 'text-emerald-400');

        setTimeout(() => {
            if (icon) icon.className = origIcon;
            if (text) text.innerText = origText;
            button.classList.remove('border-emerald-500/50', 'text-emerald-400');
        }, 2000);
    }).catch(err => {
        console.error('Failed to copy: ', err);
    });
}
</script>

<!-- Prism.js Syntax Highlighting Engine -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/prism.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/plugins/autoloader/prism-autoloader.min.js"></script>
@endsection
