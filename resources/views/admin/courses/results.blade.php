@extends('layouts.app')

@section('title', 'Course Results - ' . $course->title)

@section('content')

<style>
/* ================= PIXEL COURSE RESULT ================= */
.pixel-result-container {
    max-width: 1200px;
    margin: 0 auto;
}

/* HEADER */
.pixel-result-header {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 24px;
}

.pixel-back-btn {
    border: 3px solid var(--border);
    background: var(--bg);
    padding: 6px 8px;
    box-shadow: 3px 3px 0 var(--shadow);
}

.pixel-back-btn:hover {
    border-color: var(--accent);
    color: var(--accent);
}

.pixel-result-title h1 {
    font-size: 16px;
    color: var(--accent);
}

.pixel-result-title p {
    font-size: 9px;
    color: var(--muted);
}

/* STATS */
.pixel-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit,minmax(220px,1fr));
    gap: 14px;
    margin-bottom: 24px;
}

.pixel-stat {
    background: var(--card);
    border: 3px solid var(--border);
    box-shadow: 4px 4px 0 var(--shadow);
    padding: 14px;
}

.pixel-stat h3 {
    font-size: 9px;
    color: var(--muted);
}

.pixel-stat-value {
    font-size: 16px;
    margin-top: 6px;
}

/* LIST */
.pixel-user-list {
    display: grid;
    grid-template-columns: 1fr;
    gap: 14px;
}

/* USER CARD */
.pixel-user-card {
    background: var(--card);
    border: 3px solid var(--border);
    box-shadow: 4px 4px 0 var(--shadow);
    padding: 16px;
    display: grid;
    grid-template-columns: 1fr auto;
    gap: 14px;
}

.pixel-user-info {
    display: flex;
    gap: 12px;
}

.pixel-avatar {
    width: 42px;
    height: 42px;
    background: var(--bg);
    border: 2px solid var(--border);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 10px;
}

.pixel-user-text h4 {
    font-size: 10px;
}

.pixel-user-text p {
    font-size: 8px;
    color: var(--muted);
}

/* META */
.pixel-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    font-size: 8px;
    color: var(--muted);
    margin-top: 6px;
}

.pixel-badge {
    border: 2px solid;
    padding: 2px 6px;
    font-size: 8px;
}

.pixel-done {
    border-color: #22c55e;
    color: #22c55e;
}

.pixel-progress {
    border-color: #facc15;
    color: #facc15;
}

/* PROGRESS BAR */
.pixel-progress-bar {
    background: var(--bg);
    border: 2px solid var(--border);
    height: 14px;
    position: relative;
    margin-top: 6px;
}

.pixel-progress-fill {
    background: var(--accent);
    height: 100%;
}

/* ACTION */
.pixel-action a {
    font-size: 8px;
    border: 2px solid var(--border);
    padding: 6px;
    display: inline-block;
}

.pixel-action a:hover {
    border-color: var(--accent);
    color: var(--accent);
}

/* EMPTY */
.pixel-empty {
    background: var(--card);
    border: 3px dashed var(--border);
    padding: 40px 20px;
    text-align: center;
}

.pixel-empty h3 {
    font-size: 12px;
}

.pixel-empty p {
    font-size: 9px;
    color: var(--muted);
}

/* RESPONSIVE */
@media (max-width: 640px) {
    .pixel-user-card {
        grid-template-columns: 1fr;
    }
}
</style>

<div class="pixel-result-container">

    <!-- HEADER -->
    <div class="pixel-result-header">
        <a href="{{ route('admin.courses.show', $course) }}" class="pixel-back-btn">◀</a>
        <div class="pixel-result-title">
            <h1>COURSE RESULTS</h1>
            <p>{{ $course->title }}</p>
        </div>
    </div>

    <!-- STATS -->
    <div class="pixel-stats">
        <div class="pixel-stat">
            <h3>TOTAL ENROLLED</h3>
            <div class="pixel-stat-value">{{ $enrolledUsers->count() }}</div>
        </div>

        <div class="pixel-stat">
            <h3>COMPLETED</h3>
            <div class="pixel-stat-value">
                {{ $enrolledUsers->where('is_completed', true)->count() }}
            </div>
        </div>

        <div class="pixel-stat">
            <h3>IN PROGRESS</h3>
            <div class="pixel-stat-value">
                {{ $enrolledUsers->where('is_completed', false)->count() }}
            </div>
        </div>

        <div class="pixel-stat">
            <h3>COMPLETION RATE</h3>
            <div class="pixel-stat-value">
                {{ $enrolledUsers->count() > 0 ? round(($enrolledUsers->where('is_completed', true)->count() / $enrolledUsers->count()) * 100, 1) : 0 }}%
            </div>
        </div>
    </div>

    <!-- USERS -->
    @if ($enrolledUsers->count() > 0)

        <div class="pixel-user-list">
            @foreach ($enrolledUsers as $userCourse)

                @php
                    $totalQuestions = $course->questions()->count();
                    $answeredQuestions = \App\Models\UserAnswer::where('user_id', $userCourse->user_id)
                        ->where('content_type', 'question')
                        ->whereIn('content_id', $course->questions()->pluck('id'))
                        ->distinct()
                        ->count('content_id');

                    $progress = $totalQuestions > 0
                        ? round(($answeredQuestions / $totalQuestions) * 100)
                        : 0;
                @endphp

                <div class="pixel-user-card">

                    <div>
                        <div class="pixel-user-info">
                            <div class="pixel-avatar">
                                {{ strtoupper(substr($userCourse->user->name,0,1)) }}
                            </div>

                            <div class="pixel-user-text">
                                <h4>{{ $userCourse->user->name }}</h4>
                                <p>{{ $userCourse->user->email }}</p>

                                <div class="pixel-meta">
                                    <span>📅 {{ $userCourse->created_at->format('M d, Y') }}</span>

                                    <span class="pixel-badge {{ $userCourse->is_completed ? 'pixel-done' : 'pixel-progress' }}">
                                        {{ $userCourse->is_completed ? 'COMPLETED' : 'IN PROGRESS' }}
                                    </span>

                                    <span>{{ $progress }}%</span>
                                </div>

                                <div class="pixel-progress-bar">
                                    <div class="pixel-progress-fill" style="width: {{ $progress }}%"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pixel-action">
                        <a href="{{ route('admin.users.course.results', [$userCourse->user, $course]) }}">
                            VIEW
                        </a>
                    </div>

                </div>

            @endforeach
        </div>

    @else

        <div class="pixel-empty">
            <h3>NO ENROLLMENTS</h3>
            <p>Belum ada user yang mengambil course ini</p>
        </div>

    @endif

</div>

@endsection
