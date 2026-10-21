@extends('layouts.app')

@section('title', $course->title)

@section('content')

<style>
/* ================= PIXEL COURSE SHOW ================= */
.pixel-show-container {
    max-width: 1200px;
    margin: 0 auto;
}

/* HEADER */
.pixel-show-header {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 22px;
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

.pixel-show-title h1 {
    font-size: 16px;
    color: var(--accent);
}

.pixel-show-meta {
    font-size: 9px;
    color: var(--muted);
    margin-top: 4px;
}

.pixel-badge {
    border: 2px solid;
    padding: 2px 6px;
    font-size: 8px;
    margin-right: 6px;
}

.pixel-active {
    border-color: #22c55e;
    color: #22c55e;
}

.pixel-inactive {
    border-color: #ff5555;
    color: #ff5555;
}

/* GRID */
.pixel-show-grid {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 18px;
}

/* CARD */
.pixel-card {
    background: var(--card);
    border: 3px solid var(--border);
    box-shadow: 4px 4px 0 var(--shadow);
    padding: 16px;
}

/* COURSE IMAGE */
.pixel-course-image img {
    width: 100%;
    height: 200px;
    object-fit: cover;
    border: 3px solid var(--border);
    margin-bottom: 14px;
}

/* INFO */
.pixel-section-title {
    font-size: 11px;
    margin-bottom: 8px;
    color: var(--accent);
}

.pixel-text {
    font-size: 9px;
    color: var(--muted);
    line-height: 1.6;
}

.pixel-info-grid {
    display: grid;
    grid-template-columns: repeat(2,1fr);
    gap: 14px;
    margin-top: 14px;
}

/* CONTENT LIST */
.pixel-content-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: var(--bg);
    border: 2px solid var(--border);
    padding: 10px;
    font-size: 9px;
}

.pixel-content-type {
    font-size: 8px;
    color: var(--muted);
}

/* ACTIONS */
.pixel-action-btn {
    display: block;
    border: 3px solid var(--border);
    background: var(--bg);
    padding: 10px;
    font-size: 9px;
    margin-bottom: 8px;
}

.pixel-action-btn:hover {
    border-color: var(--accent);
    color: var(--accent);
}

/* ENROLLMENT */
.pixel-user-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 8px;
    margin-bottom: 6px;
}

.pixel-avatar {
    width: 26px;
    height: 26px;
    border: 2px solid var(--border);
    display: flex;
    align-items: center;
    justify-content: center;
}

/* RESPONSIVE */
@media (max-width: 768px) {
    .pixel-show-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<div class="pixel-show-container">

    <!-- HEADER -->
    <div class="pixel-show-header">
        <a href="{{ route('admin.courses.index') }}" class="pixel-back-btn">◀</a>
        <div class="pixel-show-title">
            <h1>{{ $course->title }}</h1>
            <div class="pixel-show-meta">
                <span class="pixel-badge {{ $course->is_active ? 'pixel-active' : 'pixel-inactive' }}">
                    {{ $course->is_active ? 'ACTIVE' : 'INACTIVE' }}
                </span>
                Created {{ $course->created_at->format('M d, Y') }}
            </div>
        </div>
    </div>

    <div class="pixel-show-grid">

        <!-- LEFT -->
        <div>

            <!-- COURSE INFO -->
            <div class="pixel-card">
                @if($course->image)
                    <div class="pixel-course-image">
                         <img src="{{ $course->image_url }}" alt="{{ $course->title }}">
                    </div>
                @endif

                <h3 class="pixel-section-title">DESCRIPTION</h3>
                <p class="pixel-text">{{ $course->description }}</p>

                <div class="pixel-info-grid">
                    <div>
                        <h3 class="pixel-section-title">PRICE</h3>
                        <p>Rp {{ number_format($course->price) }}</p>
                    </div>
                    <div>
                        <h3 class="pixel-section-title">ENROLLMENTS</h3>
                        <p>{{ $course->userCourses->count() }}</p>
                    </div>
                </div>

                <div style="margin-top:14px">
                    <h3 class="pixel-section-title">CREATOR</h3>
                    <p>{{ $course->creator->name }}</p>
                </div>
            </div>

            <!-- CONTENT -->
            <div class="pixel-card" style="margin-top:18px">
                <div style="display:flex;justify-content:space-between;align-items:center">
                    <h3 class="pixel-section-title">COURSE CONTENT</h3>
                    <a href="{{ route('admin.courses.contents.index', $course) }}">MANAGE →</a>
                </div>

                @if($course->contents->count())
                    @foreach($course->contents as $content)
                        <div class="pixel-content-item">
                            <div>
                                <strong>{{ $content->title }}</strong><br>
                                <span class="pixel-content-type">
                                    {{ strtoupper($content->type) }} • ORDER {{ $content->order }}
                                </span>
                            </div>
                            <a href="{{ route('admin.courses.contents.show', [$course, $content]) }}">▶</a>
                        </div>
                    @endforeach
                @else
                    <p class="pixel-text">No content yet</p>
                    <a href="{{ route('admin.courses.contents.create', $course) }}" class="pixel-action-btn">
                        ADD CONTENT
                    </a>
                @endif
            </div>

        </div>

        <!-- RIGHT -->
        <div>

            <!-- ACTIONS -->
            <div class="pixel-card">
                <h3 class="pixel-section-title">QUICK ACTIONS</h3>

                <a href="{{ route('admin.courses.edit', $course) }}" class="pixel-action-btn">
                    ✏ EDIT COURSE
                </a>

                <a href="{{ route('admin.courses.contents.index', $course) }}" class="pixel-action-btn">
                    📚 MANAGE CONTENT
                </a>

                <a href="{{ route('admin.courses.results', $course) }}" class="pixel-action-btn">
                    📊 VIEW RESULTS
                </a>
            </div>

            <!-- ENROLLMENT -->
            <div class="pixel-card" style="margin-top:18px">
                <h3 class="pixel-section-title">RECENT ENROLLMENTS</h3>

                @forelse($course->userCourses->take(5) as $userCourse)
                    <div class="pixel-user-row">
                        <div style="display:flex;align-items:center;gap:6px">
                            <div class="pixel-avatar">
                                {{ strtoupper(substr($userCourse->user->name,0,1)) }}
                            </div>
                            {{ $userCourse->user->name }}
                        </div>
                        <span>
                            {{ $userCourse->is_completed ? 'DONE' : 'PROGRESS' }}
                        </span>
                    </div>
                @empty
                    <p class="pixel-text">No enrollments yet</p>
                @endforelse

                @if($course->userCourses->count() > 5)
                    <a href="{{ route('admin.courses.results', $course) }}" class="pixel-action-btn">
                        VIEW ALL →
                    </a>
                @endif
            </div>

        </div>

    </div>

</div>

@endsection
