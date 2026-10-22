@extends('layouts.app')

@section('title', 'Dashboard User')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-8">
    
    <!-- Hero Welcome Section -->
    <div class="cyber-card mb-8 relative overflow-hidden" style="border-color: var(--accent2);">
        <div class="absolute inset-0 opacity-10" style="background: repeating-linear-gradient(45deg, transparent, transparent 10px, var(--accent2) 10px, var(--accent2) 20px);"></div>
        <div class="relative flex justify-between items-center z-10 flex-wrap gap-6">
            <div class="flex items-center gap-6">
                <div class="text-6xl animate-pulse">👋</div>
                <div>
                    <h1 class="text-3xl font-bold mb-2" style="color: var(--cyan);">System Welcome, {{ auth()->user()->name }}!</h1>
                    <p style="color: var(--text2); font-family: 'Fira Code', monospace; font-size: 0.9rem;">Maintain learning sequence and track module progress.</p>
                </div>
            </div>
            <div class="text-center p-4 border rounded-lg" style="background: rgba(0,0,0,0.2); border-color: var(--accent);">
                <div class="text-4xl font-bold" style="color: var(--cyan); font-family: 'Fira Code', monospace;">{{ now()->format('d') }}</div>
                <div class="text-xs tracking-widest uppercase mt-1" style="color: var(--text2);">{{ now()->format('M Y') }}</div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="cyber-card" style="border-top: 3px solid var(--cyan);">
            <div class="text-4xl mb-4 text-center">📚</div>
            <div class="text-center">
                <div class="text-xs uppercase tracking-widest mb-2" style="color: var(--text3);">Total Modules</div>
                <div class="text-3xl font-bold" style="color: var(--cyan); font-family: 'Fira Code', monospace;">{{ $totalCourses ?? 0 }}</div>
                <div class="text-xs mt-2" style="color: var(--text2);">Available in Matrix</div>
            </div>
        </div>

        <div class="cyber-card" style="border-top: 3px solid var(--green);">
            <div class="text-4xl mb-4 text-center">🎯</div>
            <div class="text-center">
                <div class="text-xs uppercase tracking-widest mb-2" style="color: var(--text3);">Active Synapse</div>
                <div class="text-3xl font-bold" style="color: var(--green); font-family: 'Fira Code', monospace;">{{ $activeCourses ?? 0 }}</div>
                <div class="text-xs mt-2" style="color: var(--text2);">In Progress</div>
            </div>
        </div>

        <div class="cyber-card" style="border-top: 3px solid var(--yellow);">
            <div class="text-4xl mb-4 text-center">⭐</div>
            <div class="text-center">
                <div class="text-xs uppercase tracking-widest mb-2" style="color: var(--text3);">Data Compiled</div>
                <div class="text-3xl font-bold" style="color: var(--yellow); font-family: 'Fira Code', monospace;">{{ $completedCourses ?? 0 }}</div>
                <div class="text-xs mt-2" style="color: var(--text2);">Completed</div>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Left Column: Quick Actions & Activity -->
        <div class="lg:col-span-1 flex flex-col gap-8">
            
            <!-- Quick Actions -->
            <div class="cyber-card p-0">
                <div class="p-4 border-b flex items-center gap-2" style="border-color: var(--border); background: rgba(255,255,255,0.02);">
                    <i class="fas fa-bolt text-lg" style="color: var(--orange);"></i>
                    <h3 class="font-bold">Quick Execution</h3>
                </div>
                <div class="p-4 flex flex-col gap-3">
                    <a href="{{ route('user.courses.index') }}" class="cyber-btn flex justify-between items-center" style="border-color: var(--cyan); color: var(--text); background: rgba(6,182,212,0.1);">
                        <span><i class="fas fa-search mr-2"></i> Explore Modules</span>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                    <a href="{{ route('user.transactions.index') }}" class="cyber-btn flex justify-between items-center" style="border-color: var(--green); color: var(--text); background: rgba(16,185,129,0.1);">
                        <span><i class="fas fa-history mr-2"></i> Transaction Log</span>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="cyber-card p-0">
                <div class="p-4 border-b flex items-center gap-2" style="border-color: var(--border); background: rgba(255,255,255,0.02);">
                    <i class="fas fa-bell text-lg" style="color: var(--cyan);"></i>
                    <h3 class="font-bold">System Activity</h3>
                </div>
                <div class="p-4">
                    @if(isset($recentActivities) && count($recentActivities) > 0)
                        <div class="flex flex-col gap-4">
                            @foreach($recentActivities as $activity)
                                <div class="flex items-start gap-3 p-3 rounded border" style="background: rgba(255,255,255,0.01); border-color: var(--border);">
                                    <div class="mt-1"><i class="fas fa-thumbtack text-sm" style="color: var(--php2);"></i></div>
                                    <div>
                                        <div class="text-sm font-bold mb-1">{{ $activity['title'] }}</div>
                                        <div class="text-xs" style="color: var(--text3); font-family: 'Fira Code', monospace;">{{ $activity['time'] }}</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <div class="text-4xl mb-4 animate-bounce">📭</div>
                            <div class="font-bold text-sm mb-2">No Data Found</div>
                            <p class="text-xs mb-4" style="color: var(--text2);">Execute learning modules to generate logs.</p>
                            <a href="{{ route('user.courses.index') }}" class="btn-primary" style="font-size: 0.75rem; padding: 0.4rem 1rem;">Initialize</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Right Column: Progress Overview -->
        <div class="lg:col-span-2">
            @if(isset($enrolledCourses) && count($enrolledCourses) > 0)
                <div class="cyber-card h-full">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="font-bold flex items-center gap-2">
                            <i class="fas fa-chart-bar text-lg" style="color: var(--green);"></i>
                            Module Progress Matrix
                        </h3>
                        <a href="{{ route('user.courses.index') }}" class="text-xs hover:underline" style="color: var(--cyan); font-family: 'Fira Code', monospace;">View All -></a>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach($enrolledCourses as $index => $course)
                            <div class="p-5 border rounded-lg transition-all hover:-translate-y-1 hover:shadow-[0_0_15px_rgba(0,212,255,0.2)]" style="background: rgba(0,0,0,0.2); border-color: var(--border);">
                                <div class="flex justify-between items-start mb-4">
                                    <div class="text-3xl">{{ ['🎨', '💻', '📊', '🎯', '🚀', '⚡'][($index % 6)] }}</div>
                                    <div class="px-2 py-1 rounded text-xs font-bold" style="background: rgba(0,212,255,0.1); color: var(--accent); border: 1px solid var(--accent);">
                                        {{ $course->progress ?? 0 }}%
                                    </div>
                                </div>
                                <h4 class="font-bold text-sm mb-4 truncate" title="{{ $course->title }}">{{ $course->title }}</h4>
                                
                                <div class="w-full h-2 rounded overflow-hidden mb-2" style="background: var(--bg);">
                                    <div class="h-full relative" style="width: {{ $course->progress ?? 0 }}%; background: var(--accent);">
                                        <div class="absolute inset-0 opacity-20" style="background: repeating-linear-gradient(45deg, transparent, transparent 5px, #fff 5px, #fff 10px);"></div>
                                    </div>
                                </div>
                                
                                <div class="flex justify-between items-center mt-4">
                                    <span class="text-xs" style="color: var(--text3); font-family: 'Fira Code', monospace;">
                                        {{ $course->completed_lessons ?? 0 }}/{{ $course->total_lessons ?? 0 }} Nodes
                                    </span>
                                    <a href="{{ route('user.courses.show', $course->id) }}" class="btn-primary" style="font-size: 0.7rem; padding: 0.3rem 0.8rem;">
                                        Resume <i class="fas fa-play ml-1"></i>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="cyber-card h-full flex flex-col items-center justify-center py-16 text-center">
                    <div class="text-6xl mb-6 opacity-50">🛸</div>
                    <h3 class="text-xl font-bold mb-3" style="color: var(--cyan);">Matrix is Empty</h3>
                    <p class="mb-6 max-w-md" style="color: var(--text2); font-family: 'Fira Code', monospace;">You have not initiated any learning modules. Connect to a module to begin knowledge transfer.</p>
                    <a href="{{ route('user.courses.index') }}" class="btn-primary">Browse Catalog</a>
                </div>
            @endif
        </div>
        
    </div>
</div>
@endsection