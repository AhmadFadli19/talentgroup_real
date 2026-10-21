@extends('layouts.app')

@section('title', 'Kursus Saya')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-8">
    
    <!-- Hero Header -->
    <div class="cyber-card mb-8 relative overflow-hidden" style="border-color: var(--accent2);">
        <div class="absolute inset-0 opacity-10" style="background: repeating-linear-gradient(-45deg, transparent, transparent 15px, var(--accent2) 15px, var(--accent2) 30px);"></div>
        <div class="relative flex items-center gap-6 z-10 py-4">
            <div class="text-6xl animate-pulse">🎓</div>
            <div>
                <h1 class="text-3xl font-bold mb-2" style="color: var(--accent); font-family: 'Outfit', sans-serif;">My Learning Matrix</h1>
                <p style="color: var(--text2); font-family: 'Fira Code', monospace; font-size: 0.9rem;">Manage and continue your active module connections.</p>
            </div>
        </div>
    </div>

    @if ($courses->isEmpty())
        <!-- Empty State -->
        <div class="cyber-card py-16 text-center">
            <div class="text-6xl mb-6 animate-bounce opacity-50">📚</div>
            <h3 class="text-xl font-bold mb-3" style="color: var(--text);">No Modules Connected</h3>
            <p class="text-sm mb-6 max-w-md mx-auto" style="color: var(--text2); font-family: 'Fira Code', monospace;">
                You haven't initialized any courses yet. Browse the catalog and start your learning journey!
            </p>
            <a href="{{ route('user.courses.index') }}" class="btn-primary">
                <i class="fas fa-search mr-2"></i> Explore Catalog
            </a>
        </div>
    @else
        <!-- Courses Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach ($courses as $index => $course)
                <div class="cyber-card flex flex-col p-0 transition-all hover:-translate-y-2 hover:shadow-[0_0_20px_rgba(124,58,237,0.2)]" style="border-color: var(--border);">
                    
                    <!-- Card Header -->
                    <div class="p-5 border-b relative flex justify-between items-start" style="border-color: var(--border); background: rgba(255,255,255,0.02);">
                        <div class="w-12 h-12 rounded-lg border overflow-hidden flex-shrink-0 relative z-10" style="border-color: var(--border); background: var(--bg);">
                            @if($course->image)
                                <img src="{{ $course->image_url }}" class="w-full h-full object-cover" alt="{{ $course->title }}">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-2xl">
                                    {{ ['🎨', '💻', '📊', '🎯', '🚀', '⚡', '🎮', '📱'][($index % 8)] }}
                                </div>
                            @endif
                        </div>
                        
                        @if($course->is_completed ?? false)
                            <div class="px-2 py-1 rounded text-[10px] font-bold border uppercase tracking-widest relative z-10" style="background: rgba(0,255,136,0.1); color: var(--green); border-color: var(--green);">
                                <i class="fas fa-check-circle mr-1"></i> Completed
                            </div>
                        @else
                            <div class="px-2 py-1 rounded text-[10px] font-bold border uppercase tracking-widest relative z-10" style="background: rgba(0,212,255,0.1); color: var(--accent); border-color: var(--accent);">
                                <i class="fas fa-play-circle mr-1"></i> In Progress
                            </div>
                        @endif
                        
                        <div class="absolute top-0 left-0 w-full h-full overflow-hidden opacity-10">
                            <svg viewBox="0 0 100 100" class="absolute -top-10 -left-10 w-40 h-40">
                                <circle cx="50" cy="50" r="40" fill="none" stroke="var(--accent2)" stroke-width="2" stroke-dasharray="5 5">
                                    <animateTransform attributeName="transform" type="rotate" from="0 50 50" to="360 50 50" dur="20s" repeatCount="indefinite"/>
                                </circle>
                            </svg>
                        </div>
                    </div>

                    <!-- Card Body -->
                    <div class="p-5 flex-1 flex flex-col gap-4">
                        <h2 class="text-lg font-bold leading-tight" style="color: var(--text);">{{ $course->title }}</h2>
                        <p class="text-xs flex-1" style="color: var(--text2); font-family: 'Fira Code', monospace; line-height: 1.6;">
                            {{ Str::limit($course->description, 100) }}
                        </p>

                        <!-- Progress Section -->
                        <div class="p-4 rounded border mt-2" style="background: rgba(0,0,0,0.2); border-color: var(--border);">
                            <div class="flex justify-between items-center text-xs mb-2 font-mono">
                                <span style="color: var(--text3);">SYNC PROGRESS</span>
                                <span class="font-bold" style="color: var(--accent);">{{ $course->progress ?? 0 }}%</span>
                            </div>
                            <div class="w-full h-2 rounded overflow-hidden" style="background: var(--bg);">
                                <div class="h-full relative" style="width: {{ $course->progress ?? 0 }}%; background: var(--accent);">
                                    <div class="absolute inset-0 opacity-20" style="background: repeating-linear-gradient(45deg, transparent, transparent 5px, #fff 5px, #fff 10px);"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Enrollment Info -->
                        @if($course->enrolled_at)
                            <div class="text-[10px] flex items-center gap-2" style="color: var(--text3); font-family: 'Fira Code', monospace;">
                                <i class="fas fa-calendar-alt" style="color: var(--accent2);"></i>
                                Initialized: {{ $course->enrolled_at->format('d M Y') }}
                            </div>
                        @endif
                    </div>

                    <!-- Card Actions -->
                    <div class="p-5 border-t grid grid-cols-1 gap-3" style="border-color: var(--border); background: rgba(0,0,0,0.2);">
                        @if($course->is_completed ?? false)
                            <div class="grid grid-cols-2 gap-3">
                                <a href="{{ route('user.courses.learn', $course->id) }}" class="btn-primary text-center text-[10px]">
                                    <i class="fas fa-book-open mr-1"></i> Review
                                </a>
                                <a href="{{ route('user.courses.results', $course->id) }}" class="cyber-btn text-center text-[10px]" style="border-color: var(--green); color: var(--green);">
                                    <i class="fas fa-chart-bar mr-1"></i> Data
                                </a>
                            </div>
                            <form action="{{ route('user.courses.retake', $course->id) }}" method="POST" onsubmit="return confirm('Warning: Retaking will wipe all current module progress data. Proceed?')">
                                @csrf
                                <button type="submit" class="btn-ghost w-full text-[10px]">
                                    <i class="fas fa-redo mr-1"></i> Reboot Module
                                </button>
                            </form>
                        @else
                            <a href="{{ route('user.courses.learn', $course->id) }}" class="btn-primary text-center">
                                <i class="fas fa-play mr-2"></i> Resume Connection
                            </a>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
