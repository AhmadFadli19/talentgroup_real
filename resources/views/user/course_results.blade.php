@extends('layouts.app')

@section('title', 'Matrix Results - ' . $course->title)

@section('content')
<div class="max-w-7xl mx-auto px-6 py-8">
    <!-- Hero Results Header -->
    <div class="cyber-card mb-8 relative overflow-hidden" style="border-color: var(--accent);">
        <div class="absolute inset-0 opacity-10" style="background: repeating-linear-gradient(45deg, transparent, transparent 10px, var(--accent) 10px, var(--accent) 20px);"></div>
        
        <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-8 mb-8">
            <div class="flex items-center gap-6 flex-1">
                <div class="text-6xl animate-pulse">🏆</div>
                <div>
                    <h1 class="text-3xl font-bold mb-2" style="color: var(--accent); font-family: 'Outfit', sans-serif;">{{ $course->title }}</h1>
                    <p class="text-sm font-mono tracking-widest uppercase" style="color: var(--text2);">Performance Analysis & Results</p>
                </div>
            </div>
            
            <div class="flex-shrink-0 bg-black/30 p-6 border-2 rounded-lg text-center min-w-[200px]" style="border-color: var(--accent); box-shadow: 0 0 20px rgba(0,212,255,0.2);">
                <div class="text-xs uppercase tracking-widest font-bold mb-2" style="color: var(--text3);">Final Sync Score</div>
                <div class="text-5xl font-bold mb-4" style="color: var(--accent); font-family: 'Fira Code', monospace;">{{ $score }}%</div>
                <div class="w-full h-2 rounded overflow-hidden" style="background: var(--bg);">
                    <div class="h-full" style="width: {{ $score }}%; background: var(--accent); box-shadow: 0 0 10px var(--accent);"></div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="relative z-10 flex flex-wrap gap-4 mt-6">
            <a href="{{ route('user.courses.learn', $course->id) }}" class="cyber-btn flex items-center justify-center">
                <i class="fas fa-arrow-left mr-2"></i> Return to Matrix
            </a>
            
            @if($syncedNodes < $totalNodes)
                <a href="{{ route('user.courses.learn', $course->id) }}" class="btn-primary flex items-center justify-center">
                    <i class="fas fa-play mr-2"></i> Resume Sync
                </a>
            @endif
            
            @if($syncedNodes === $totalNodes && $totalNodes > 0)
                <a href="{{ route('user.courses.certificate', $course->id) }}" target="_blank" class="cyber-btn flex items-center justify-center border-yellow-500 bg-yellow-500/10 text-yellow-500 hover:bg-yellow-500/20 hover:shadow-[0_0_15px_rgba(234,179,8,0.3)]">
                    <i class="fas fa-certificate mr-2"></i> Unduh Sertifikat
                </a>
            @endif
            
            <button onclick="window.print()" class="cyber-btn flex items-center justify-center" style="border-color: var(--text3); color: var(--text3);">
                <i class="fas fa-print mr-2"></i> Export Data
            </button>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="cyber-card flex items-center gap-4" style="border-color: var(--border);">
            <div class="text-4xl opacity-80 animate-bounce">❓</div>
            <div>
                <div class="text-[10px] uppercase tracking-widest mb-1" style="color: var(--text3);">Total Nodes</div>
                <div class="text-2xl font-bold" style="color: var(--accent); font-family: 'Fira Code', monospace;">{{ $totalNodes }}</div>
            </div>
        </div>
        
        <div class="cyber-card flex items-center gap-4" style="border-color: var(--border);">
            <div class="text-4xl opacity-80 animate-bounce" style="animation-delay: 0.1s;">📝</div>
            <div>
                <div class="text-[10px] uppercase tracking-widest mb-1" style="color: var(--text3);">Synced Nodes</div>
                <div class="text-2xl font-bold" style="color: var(--cyan); font-family: 'Fira Code', monospace;">{{ $syncedNodes }}</div>
            </div>
        </div>
        
        <div class="cyber-card flex items-center gap-4" style="border-color: var(--green); box-shadow: 0 0 15px rgba(0,255,136,0.1);">
            <div class="text-4xl opacity-80 animate-bounce" style="animation-delay: 0.2s;">✅</div>
            <div>
                <div class="text-[10px] uppercase tracking-widest mb-1" style="color: var(--text3);">Valid Data</div>
                <div class="text-2xl font-bold" style="color: var(--green); font-family: 'Fira Code', monospace;">{{ $correctAnswers }}</div>
            </div>
        </div>
        
        <div class="cyber-card flex items-center gap-4" style="border-color: var(--border);">
            <div class="text-4xl opacity-80 animate-bounce" style="animation-delay: 0.3s;">⭐</div>
            <div>
                <div class="text-[10px] uppercase tracking-widest mb-1" style="color: var(--text3);">Total Credits</div>
                <div class="text-2xl font-bold" style="color: var(--yellow); font-family: 'Fira Code', monospace;">{{ $totalPoints }}</div>
            </div>
        </div>
    </div>

    <!-- Performance Analysis -->
    <div class="cyber-card mb-8">
        <h2 class="text-xl font-bold mb-6 flex items-center gap-3" style="color: var(--accent);">
            <i class="fas fa-chart-line"></i> Performance Analytics
        </h2>
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Score Breakdown -->
            <div class="p-6 border rounded" style="background: rgba(0,0,0,0.2); border-color: var(--border);">
                <h3 class="text-xs uppercase tracking-widest font-bold mb-6" style="color: var(--text);">Metric Breakdown</h3>
                
                <div class="flex flex-col gap-6">
                    <div>
                        <div class="flex justify-between items-center text-xs mb-2 font-mono">
                            <span style="color: var(--text2);">Data Accuracy</span>
                            <span class="font-bold" style="color: var(--green);">{{ $totalQuestions > 0 ? round(($correctAnswers / $totalQuestions) * 100) : 0 }}%</span>
                        </div>
                        <div class="w-full h-3 rounded overflow-hidden border" style="background: var(--bg); border-color: var(--border);">
                            <div class="h-full relative" style="width: {{ $totalQuestions > 0 ? round(($correctAnswers / $totalQuestions) * 100) : 0 }}%; background: var(--green);"></div>
                        </div>
                    </div>
                    
                    <div>
                        <div class="flex justify-between items-center text-xs mb-2 font-mono">
                            <span style="color: var(--text2);">Sync Completion</span>
                            <span class="font-bold" style="color: var(--cyan);">{{ $totalNodes > 0 ? round(($syncedNodes / $totalNodes) * 100) : 0 }}%</span>
                        </div>
                        <div class="w-full h-3 rounded overflow-hidden border" style="background: var(--bg); border-color: var(--border);">
                            <div class="h-full relative" style="width: {{ $totalNodes > 0 ? round(($syncedNodes / $totalNodes) * 100) : 0 }}%; background: var(--cyan);"></div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Grade Assessment -->
            <div class="p-6 border rounded flex items-center gap-8" style="background: rgba(0,0,0,0.2); border-color: var(--border);">
                @php
                    $grade = 'F';
                    $gradeColor = '#ff4d4d';
                    $gradeMessage = 'Critical Failure';
                    $gradeAdvice = 'Data sync failed. Recommend complete module re-initialization.';
                    
                    if ($score >= 90) {
                        $grade = 'A';
                        $gradeColor = 'var(--green)';
                        $gradeMessage = 'Optimal Sync';
                        $gradeAdvice = 'Perfect data retention. You have fully mastered this matrix.';
                    } elseif ($score >= 80) {
                        $grade = 'B';
                        $gradeColor = 'var(--cyan)';
                        $gradeMessage = 'High Efficiency';
                        $gradeAdvice = 'Solid performance. Matrix comprehension is highly stable.';
                    } elseif ($score >= 70) {
                        $grade = 'C';
                        $gradeColor = 'var(--yellow)';
                        $gradeMessage = 'Acceptable Sync';
                        $gradeAdvice = 'Adequate performance. Review anomalous data nodes to improve.';
                    } elseif ($score >= 60) {
                        $grade = 'D';
                        $gradeColor = '#ffaa00';
                        $gradeMessage = 'Suboptimal';
                        $gradeAdvice = 'Warning: Low retention detected. Further processing required.';
                    }
                @endphp
                
                <div class="w-24 h-24 border-4 rounded flex items-center justify-center flex-shrink-0" style="border-color: {{ $gradeColor }}; box-shadow: 0 0 20px {{ $gradeColor }}40;">
                    <div class="text-5xl font-bold font-mono" style="color: {{ $gradeColor }};">{{ $grade }}</div>
                </div>
                
                <div>
                    <h3 class="text-xs uppercase tracking-widest font-bold mb-2" style="color: var(--text);">Assessment Protocol</h3>
                    <h4 class="text-lg font-bold mb-2" style="color: {{ $gradeColor }};">{{ $gradeMessage }}</h4>
                    <p class="text-[10px] font-mono leading-relaxed" style="color: var(--muted);">{{ $gradeAdvice }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Detailed Results -->
    <div class="cyber-card p-0 overflow-hidden">
        <div class="p-6 border-b flex items-center gap-3" style="background: rgba(0,0,0,0.3); border-color: var(--border);">
            <i class="fas fa-list-alt text-xl" style="color: var(--accent);"></i>
            <h2 class="text-lg font-bold" style="color: var(--text);">Node Analysis Log</h2>
        </div>
        
        @if($answers->isEmpty())
            <div class="p-16 text-center">
                <div class="text-6xl mb-6 animate-pulse opacity-50">📋</div>
                <h3 class="text-lg font-bold mb-2">Log is Empty</h3>
                <p class="text-xs font-mono mb-6" style="color: var(--muted);">No data synced yet for this module.</p>
                <a href="{{ route('user.courses.learn', $course->id) }}" class="btn-primary">
                    <i class="fas fa-play mr-2"></i> Initialize Sync
                </a>
            </div>
        @else
            <div class="flex flex-col">
                @foreach($answers as $index => $answer)
                    <div class="flex flex-col border-b last:border-0 transition-colors hover:bg-white/5" style="border-color: var(--border); background: {{ $answer->is_correct ? 'rgba(0,255,136,0.02)' : 'rgba(255,77,77,0.02)' }};">
                        
                        <div class="p-6 flex items-start gap-6">
                            <!-- Status Icon -->
                            <div class="w-16 h-16 border-2 flex items-center justify-center text-3xl flex-shrink-0" 
                                 style="border-color: {{ $answer->is_correct ? '#00cc6a' : '#cc0000' }}; background: {{ $answer->is_correct ? 'var(--green)' : '#ff4d4d' }}; color: {{ $answer->is_correct ? '#000' : '#fff' }};">
                                {!! $answer->is_correct ? '✓' : '✗' !!}
                            </div>
                            
                            <!-- Info -->
                            <div class="flex-1 min-w-0">
                                <div class="flex justify-between items-start gap-4 mb-2">
                                    @if ($answer->courseQuestion)
                                        <h3 class="text-sm font-bold" style="color: var(--text);">{{ $answer->courseQuestion->title }}</h3>
                                    @endif
                                    <div class="text-center flex-shrink-0">
                                        <div class="text-[8px] uppercase tracking-widest mb-1" style="color: var(--muted);">Node ID</div>
                                        <div class="text-xl font-bold font-mono" style="color: var(--accent);">#{{ $index + 1 }}</div>
                                    </div>
                                </div>
                                
                                <div class="flex flex-wrap gap-4 text-[10px] font-mono mb-4">
                                    <span class="flex items-center gap-1 font-bold" style="color: {{ $answer->is_correct ? 'var(--green)' : '#ff4d4d' }};">
                                        <i class="fas {{ $answer->is_correct ? 'fa-check-circle' : 'fa-times-circle' }}"></i>
                                        {{ $answer->is_correct ? 'Valid' : 'Invalid' }}
                                    </span>
                                    <span style="color: var(--accent);"><i class="fas fa-coins mr-1"></i> {{ $answer->points }} credits</span>
                                    <span style="color: var(--muted);"><i class="fas fa-clock mr-1"></i> {{ $answer->created_at->format('d M Y H:i:s') }}</span>
                                </div>

                                @if ($answer->courseQuestion)
                                    <div class="p-4 rounded border mb-4" style="background: rgba(0,0,0,0.3); border-color: var(--border);">
                                        <p class="text-[11px] leading-relaxed mb-4" style="color: var(--text); font-family: 'Fira Code', monospace;">{{ $answer->courseQuestion->content }}</p>
                                        
                                        @if(is_array($answer->courseQuestion->options))
                                            <div class="flex flex-col gap-2">
                                                @foreach($answer->courseQuestion->options as $option)
                                                    @php
                                                        $isCorrectOpt = $option === $answer->courseQuestion->correct_answer;
                                                        $isUserOpt = $option === $answer->answer;
                                                        
                                                        $optBg = 'transparent';
                                                        $optBorder = 'var(--border)';
                                                        $optIcon = '<i class="far fa-circle text-[10px]"></i>';
                                                        $optColor = 'var(--text2)';
                                                        
                                                        if ($isCorrectOpt) {
                                                            $optBg = 'rgba(0,255,136,0.1)';
                                                            $optBorder = 'var(--green)';
                                                            $optIcon = '<i class="fas fa-check text-[10px]" style="color: var(--green);"></i>';
                                                            $optColor = 'var(--text)';
                                                        } elseif ($isUserOpt && !$answer->is_correct) {
                                                            $optBg = 'rgba(255,77,77,0.1)';
                                                            $optBorder = '#ff4d4d';
                                                            $optIcon = '<i class="fas fa-times text-[10px]" style="color: #ff4d4d;"></i>';
                                                            $optColor = 'var(--text)';
                                                        } elseif ($isUserOpt) {
                                                            $optIcon = '<i class="fas fa-dot-circle text-[10px]" style="color: var(--accent);"></i>';
                                                        }
                                                    @endphp
                                                    <div class="p-3 border rounded flex items-center gap-3 transition-colors" style="background: {{ $optBg }}; border-color: {{ $optBorder }};">
                                                        <div class="w-4 flex justify-center">{!! $optIcon !!}</div>
                                                        <span class="text-[10px] font-mono flex-1" style="color: {{ $optColor }};">{{ $option }}</span>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                <div class="p-3 border rounded" style="background: rgba(0,0,0,0.5); border-color: var(--border);">
                                                    <div class="text-[9px] uppercase tracking-widest mb-2" style="color: var(--muted);">Your Input:</div>
                                                    <div class="text-[11px] font-mono" style="color: var(--text);">{{ $answer->answer }}</div>
                                                </div>
                                                @if($answer->courseQuestion->correct_answer)
                                                    <div class="p-3 border rounded" style="background: rgba(0,255,136,0.05); border-color: var(--green)40;">
                                                        <div class="text-[9px] uppercase tracking-widest mb-2" style="color: var(--green);">Expected Input:</div>
                                                        <div class="text-[11px] font-mono" style="color: var(--text);">{{ $answer->courseQuestion->correct_answer }}</div>
                                                    </div>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <div>
                                        <a href="{{ route('user.courses.content', [$course->id, 'question:' . $answer->courseQuestion->id]) }}" class="cyber-btn text-[10px] px-4 py-2">
                                            <i class="fas fa-eye mr-2"></i> Review Node
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Completion Banner -->
    @if($syncedNodes === $totalNodes && $totalNodes > 0)
        <div class="cyber-card mt-8 flex flex-col md:flex-row items-center justify-between gap-6 p-8 relative overflow-hidden" style="border-color: var(--green);">
            <div class="absolute inset-0 opacity-10" style="background: repeating-linear-gradient(-45deg, transparent, transparent 15px, var(--green) 15px, var(--green) 30px);"></div>
            
            <div class="relative z-10 flex items-center gap-6">
                <div class="text-6xl animate-bounce">🎉</div>
                <div>
                    <h3 class="text-2xl font-bold mb-1" style="color: var(--green);">Matrix Mastered!</h3>
                    <p class="text-sm font-mono" style="color: var(--text2);">You have successfully processed all data nodes.</p>
                </div>
            </div>
            
            <div class="relative z-10 flex gap-6 p-4 rounded border bg-black/40" style="border-color: var(--green)40;">
                <div class="text-center">
                    <div class="text-2xl font-bold font-mono" style="color: var(--green);">{{ $score }}%</div>
                    <div class="text-[9px] uppercase tracking-widest" style="color: var(--text3);">Score</div>
                </div>
                <div class="w-px bg-white/10"></div>
                <div class="text-center">
                    <div class="text-2xl font-bold font-mono" style="color: var(--green);">{{ $syncedNodes }}/{{ $totalNodes }}</div>
                    <div class="text-[9px] uppercase tracking-widest" style="color: var(--text3);">Synced</div>
                </div>
                <div class="w-px bg-white/10"></div>
                <div class="text-center">
                    <div class="text-2xl font-bold font-mono" style="color: var(--yellow);">{{ $totalPoints }}</div>
                    <div class="text-[9px] uppercase tracking-widest" style="color: var(--text3);">Credits</div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
