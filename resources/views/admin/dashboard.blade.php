@extends('layouts.app')

@section('title', 'Admin Command Center')

@section('content')

<style>
/* ================= CYBER ADMIN OVERRIDES ================= */
/* Use theme accent variables dynamically */
:root {
    --admin-accent: var(--accent);
    --admin-accent2: var(--accent2);
}

.admin-dashboard {
    max-width: 1200px;
    margin: 0 auto;
}

.admin-card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 12px;
    position: relative;
    transition: all 0.3s;
    overflow: hidden;
}

body.light .admin-card {
    background: #ffffff;
    box-shadow: 0 4px 20px rgba(15, 23, 42, 0.03);
}

.admin-card::after {
    content: '';
    position: absolute;
    top: 0; left: 0;
    width: 100%; height: 2px;
    background: linear-gradient(90deg, var(--php), var(--cyan));
}

.admin-stat-icon {
    width: 48px;
    height: 48px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    background: rgba(124, 92, 191, 0.1);
    border: 1px solid rgba(124, 92, 191, 0.2);
    color: var(--accent);
}

body.light .admin-stat-icon {
    background: rgba(0, 86, 210, 0.05) !important;
    border-color: rgba(0, 86, 210, 0.1) !important;
    color: #0056d2 !important;
}

.admin-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    background: rgba(124, 92, 191, 0.05);
    border: 1px solid var(--border);
    color: var(--text);
    padding: 10px 16px;
    font-size: 10px;
    text-transform: uppercase;
    letter-spacing: 2px;
    font-weight: bold;
    transition: all 0.3s;
}

body.light .admin-btn {
    background: #ffffff;
    border-color: #cbd5e1;
    color: #4a5b78;
}

.admin-btn:hover {
    border-color: var(--accent);
    background: rgba(124, 92, 191, 0.1);
    color: var(--accent);
}

body.light .admin-btn:hover {
    border-color: var(--php);
    color: var(--php);
    background: rgba(0, 86, 210, 0.04);
}

.admin-btn.primary {
    background: rgba(124, 92, 191, 0.1);
    border-color: var(--accent);
    color: var(--accent);
}

body.light .admin-btn.primary {
    background: rgba(0, 86, 210, 0.05);
    border-color: var(--php);
    color: var(--php);
}

.admin-btn.primary:hover {
    background: rgba(124, 92, 191, 0.2);
    box-shadow: 0 0 20px rgba(124, 92, 191, 0.2);
}

body.light .admin-btn.primary:hover {
    background: rgba(0, 86, 210, 0.1);
    box-shadow: 0 0 20px rgba(0, 86, 210, 0.15);
}
</style>

<div class="admin-dashboard px-4 py-8">

    <!-- HEADER -->
    <div class="cyber-card p-6 md:p-8 mb-8 overflow-hidden relative" style="border-left-width: 4px; border-left-color: var(--accent);">
        <div class="absolute inset-0 opacity-5" style="background: linear-gradient(135deg, var(--php), var(--cyan));"></div>
        
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="flex items-center gap-6">
                <div class="text-5xl" style="color: var(--accent);">👁️‍🗨️</div>
                <div>
                    <h1 class="text-3xl font-bold mb-2 uppercase tracking-wider" style="color: var(--text); font-family: 'Outfit', sans-serif;">Command Center</h1>
                    <p class="text-xs font-mono uppercase tracking-widest" style="color: var(--accent2);">Root Access Established // System Overview</p>
                </div>
            </div>
            <div class="text-right">
                <div class="text-[10px] font-mono uppercase tracking-widest" style="color: var(--text3);">System Status</div>
                <div class="text-sm font-bold mt-1 flex items-center justify-end gap-2" style="color: var(--green);">
                    <div class="w-2 h-2 rounded-full bg-[var(--green)] animate-pulse"></div>
                    Online & Secure
                </div>
            </div>
        </div>
    </div>

    <!-- STATS -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="admin-card p-6 rounded-lg">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <h3 class="text-[10px] font-mono uppercase tracking-widest mb-1" style="color: var(--text3);">Total Subjects</h3>
                    <div class="text-3xl font-bold font-mono" style="color: var(--text);">{{ number_format($stats['total_users']) }}</div>
                </div>
                <div class="admin-stat-icon">
                    <i class="fas fa-users"></i>
                </div>
            </div>
            <div class="text-[9px] font-mono uppercase tracking-widest mt-2" style="color: var(--green);">
                <i class="fas fa-arrow-up mr-1"></i> Active Database
            </div>
        </div>

        <div class="admin-card p-6 rounded-lg">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <h3 class="text-[10px] font-mono uppercase tracking-widest mb-1" style="color: var(--text3);">Data Matrices</h3>
                    <div class="text-3xl font-bold font-mono" style="color: var(--text);">{{ number_format($stats['total_courses']) }}</div>
                </div>
                <div class="admin-stat-icon" style="color: var(--admin-accent2); background: rgba(176, 38, 255, 0.1); border-color: rgba(176, 38, 255, 0.3);">
                    <i class="fas fa-database"></i>
                </div>
            </div>
            <div class="text-[9px] font-mono uppercase tracking-widest mt-2" style="color: var(--admin-accent2);">
                {{ number_format($stats['active_courses']) }} Operational
            </div>
        </div>

        <div class="admin-card p-6 rounded-lg">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <h3 class="text-[10px] font-mono uppercase tracking-widest mb-1" style="color: var(--text3);">Total Links</h3>
                    <div class="text-3xl font-bold font-mono" style="color: var(--text);">{{ number_format($stats['total_enrollments']) }}</div>
                </div>
                <div class="admin-stat-icon" style="color: var(--cyan); background: rgba(0, 217, 255, 0.1); border-color: rgba(0, 217, 255, 0.3);">
                    <i class="fas fa-link"></i>
                </div>
            </div>
            <div class="text-[9px] font-mono uppercase tracking-widest mt-2" style="color: var(--text3);">
                Cross-referenced
            </div>
        </div>

        <div class="admin-card p-6 rounded-lg">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <h3 class="text-[10px] font-mono uppercase tracking-widest mb-1" style="color: var(--text3);">Acquisitions</h3>
                    <div class="text-xl font-bold font-mono mt-2" style="color: var(--admin-accent);">Rp {{ number_format($stats['total_revenue']) }}</div>
                </div>
                <div class="admin-stat-icon" style="color: var(--yellow); background: rgba(255, 215, 0, 0.1); border-color: rgba(255, 215, 0, 0.3);">
                    <i class="fas fa-coins"></i>
                </div>
            </div>
            <div class="text-[9px] font-mono uppercase tracking-widest mt-2" style="color: var(--green);">
                <i class="fas fa-shield-check mr-1"></i> Secured
            </div>
        </div>
    </div>

    <!-- GRID -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">

        <!-- ACTIONS -->
        <div class="admin-card p-6 rounded-lg flex flex-col gap-4">
            <h3 class="text-sm font-bold uppercase tracking-widest border-b pb-3 mb-2 flex items-center gap-2" style="color: var(--admin-accent); border-color: var(--border);">
                <i class="fas fa-terminal"></i> Terminal Commands
            </h3>
            <a href="{{ route('admin.courses.create') }}" class="admin-btn primary">
                <i class="fas fa-plus-square"></i> Initialize New Matrix
            </a>
            <a href="{{ route('admin.courses.index') }}" class="admin-btn">
                <i class="fas fa-folder-open"></i> Access Matrix Records
            </a>
        </div>

        <!-- USERS -->
        <div class="admin-card p-0 rounded-lg lg:col-span-1 flex flex-col">
            <div class="p-6 pb-4 border-b" style="border-color: var(--border);">
                <h3 class="text-sm font-bold uppercase tracking-widest flex items-center gap-2" style="color: var(--admin-accent2);">
                    <i class="fas fa-user-shield"></i> Recent Subjects
                </h3>
            </div>
            <div class="p-4 flex-1 flex flex-col gap-2 overflow-y-auto max-h-[300px] custom-scrollbar">
                @forelse($stats['recent_users'] as $user)
                    <div class="flex items-center justify-between p-3 rounded bg-black/40 border border-transparent hover:border-[var(--border)] transition-colors">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded border flex items-center justify-center font-bold text-[10px]" style="border-color: var(--admin-accent2); color: var(--admin-accent2); background: rgba(176, 38, 255, 0.1);">
                                {{ strtoupper(substr($user->name,0,1)) }}
                            </div>
                            <div class="text-xs font-mono truncate max-w-[120px]" style="color: var(--text);">{{ $user->name }}</div>
                        </div>
                        <span class="text-[9px] font-mono uppercase tracking-widest" style="color: var(--muted);">
                            {{ $user->created_at->diffForHumans() }}
                        </span>
                    </div>
                @empty
                    <div class="text-center p-4 text-[10px] font-mono uppercase tracking-widest" style="color: var(--muted);">No new subjects detected</div>
                @endforelse
            </div>
        </div>

        <!-- POPULAR COURSES -->
        <div class="admin-card p-0 rounded-lg lg:col-span-1 flex flex-col">
            <div class="p-6 pb-4 border-b" style="border-color: var(--border);">
                <h3 class="text-sm font-bold uppercase tracking-widest flex items-center gap-2" style="color: var(--cyan);">
                    <i class="fas fa-fire"></i> High-Traffic Matrices
                </h3>
            </div>
            <div class="p-4 flex-1 flex flex-col gap-2 overflow-y-auto max-h-[300px] custom-scrollbar">
                @forelse($stats['popular_courses'] as $course)
                    <div class="flex items-center justify-between p-3 rounded bg-black/40 border border-transparent hover:border-[var(--border)] transition-colors">
                        <div>
                            <div class="text-xs font-mono font-bold mb-1" style="color: var(--text);">{{ Str::limit($course->title, 22) }}</div>
                            <div class="text-[9px] font-mono uppercase tracking-widest" style="color: var(--muted);">
                                <i class="fas fa-link mr-1" style="color: var(--cyan);"></i> {{ $course->user_courses_count }} Links
                            </div>
                        </div>
                        <a href="{{ route('admin.courses.show', $course) }}" class="w-8 h-8 flex items-center justify-center rounded border transition-colors hover:bg-[rgba(0,217,255,0.1)]" style="border-color: var(--border); color: var(--cyan);">
                            <i class="fas fa-chevron-right text-[10px]"></i>
                        </a>
                    </div>
                @empty
                    <div class="text-center p-4 text-[10px] font-mono uppercase tracking-widest" style="color: var(--muted);">No data matrices found</div>
                @endforelse
            </div>
        </div>

    </div>

    <!-- ENROLLMENTS -->
    <div class="admin-card p-0 rounded-lg overflow-hidden">
        <div class="p-6 border-b" style="border-color: var(--border); background: rgba(0,0,0,0.5);">
            <h3 class="text-sm font-bold uppercase tracking-widest flex items-center gap-2" style="color: var(--text);">
                <i class="fas fa-network-wired" style="color: var(--admin-accent);"></i> Recent Network Links (Enrollments)
            </h3>
        </div>

        <div class="overflow-x-auto custom-scrollbar">
            <table class="w-full text-left whitespace-nowrap text-[11px] font-mono">
                <thead>
                    <tr style="background: rgba(255,255,255,0.02); border-bottom: 2px solid var(--border);">
                        <th class="p-4 uppercase tracking-widest" style="color: var(--text3);">Subject</th>
                        <th class="p-4 uppercase tracking-widest" style="color: var(--text3);">Matrix</th>
                        <th class="p-4 uppercase tracking-widest" style="color: var(--text3);">Timestamp</th>
                        <th class="p-4 uppercase tracking-widest" style="color: var(--text3);">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($stats['recent_enrollments'] as $enrollment)
                        <tr class="border-b transition-colors hover:bg-white/5" style="border-color: var(--border);">
                            <td class="p-4" style="color: var(--text);">{{ $enrollment->user->name }}</td>
                            <td class="p-4" style="color: var(--text2);">{{ Str::limit($enrollment->course->title, 30) }}</td>
                            <td class="p-4" style="color: var(--muted);">{{ $enrollment->created_at->format('M d, Y H:i') }}</td>
                            <td class="p-4">
                                @if($enrollment->is_completed)
                                    <span class="px-2 py-1 rounded border text-[9px] uppercase tracking-widest font-bold" style="border-color: var(--green); color: var(--green); background: rgba(0,255,136,0.1);">
                                        Synchronized
                                    </span>
                                @else
                                    <span class="px-2 py-1 rounded border text-[9px] uppercase tracking-widest font-bold" style="border-color: var(--yellow); color: var(--yellow); background: rgba(255,215,0,0.1);">
                                        In Progress
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="p-12 text-center text-[10px] uppercase tracking-widest" style="color: var(--muted);">
                                No recent link activity detected in the network.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

@endsection

