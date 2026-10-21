@extends('layouts.app')

@section('title', 'Manage Courses')

@section('content')

<style>
/* ================= PIXEL COURSE ADMIN ================= */
.pixel-admin-container {
    max-width: 1200px;
    margin: 0 auto;
}

/* HEADER */
.pixel-admin-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    flex-wrap: wrap;
    gap: 16px;
    margin-bottom: 28px;
}

.pixel-admin-title h1 {
    font-size: 18px;
    color: var(--accent);
    margin-bottom: 6px;
}

.pixel-admin-title p {
    font-size: 9px;
    color: var(--muted);
}

.pixel-create-btn {
    background: var(--accent);
    border: 3px solid var(--accent);
    color: #fff;
    font-size: 9px;
    padding: 10px 14px;
    box-shadow: 4px 4px 0 var(--shadow);
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

.pixel-create-btn:hover {
    transform: translate(-2px,-2px);
    box-shadow: 6px 6px 0 var(--shadow);
}

/* ALERT */
.pixel-alert {
    border: 2px solid #22c55e;
    background: #002a12;
    color: #86efac;
    padding: 12px;
    font-size: 9px;
    margin-bottom: 20px;
}

/* LIST */
.pixel-course-list {
    display: grid;
    grid-template-columns: 1fr;
    gap: 14px;
}

/* COURSE CARD */
.pixel-course-card {
    background: var(--card);
    border: 3px solid var(--border);
    box-shadow: 4px 4px 0 var(--shadow);
    padding: 16px;
    display: grid;
    grid-template-columns: 1fr auto;
    gap: 14px;
}

.pixel-course-info {
    display: flex;
    gap: 12px;
}

.pixel-course-thumb {
    width: 56px;
    height: 56px;
    background: var(--bg);
    border: 2px solid var(--border);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.pixel-course-thumb img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.pixel-course-text h3 {
    font-size: 11px;
    color: var(--text);
    margin-bottom: 4px;
}

.pixel-course-text p {
    font-size: 9px;
    color: var(--muted);
    max-width: 420px;
}

/* META */
.pixel-course-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-top: 8px;
    font-size: 9px;
    color: var(--muted);
}

.pixel-badge {
    border: 2px solid;
    padding: 2px 6px;
    font-size: 8px;
}

.pixel-active {
    border-color: #22c55e;
    color: #22c55e;
}

.pixel-inactive {
    border-color: #ff5555;
    color: #ff5555;
}

/* ACTIONS */
.pixel-course-actions {
    display: grid;
    gap: 6px;
}

.pixel-action-btn {
    border: 2px solid var(--border);
    background: var(--bg);
    font-size: 8px;
    padding: 6px;
    color: var(--text);
}

.pixel-action-btn:hover {
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
    margin-bottom: 8px;
}

.pixel-empty p {
    font-size: 9px;
    color: var(--muted);
    margin-bottom: 14px;
}

/* PAGINATION */
.pixel-pagination {
    margin-top: 20px;
}

/* RESPONSIVE */
@media (max-width: 640px) {
    .pixel-course-card {
        grid-template-columns: 1fr;
    }

    .pixel-course-actions {
        grid-template-columns: repeat(3,1fr);
    }
}
</style>

<div class="pixel-admin-container">

    <!-- HEADER -->
    <div class="pixel-admin-header">
        <div class="pixel-admin-title">
            <h1>COURSE MANAGER</h1>
            <p>Kelola course English Brain & Vocabulary</p>
        </div>

        <a href="{{ route('admin.courses.create') }}" class="pixel-create-btn">
            ➕ CREATE COURSE
        </a>
    </div>

    <!-- SUCCESS -->
    @if(session('success'))
        <div class="pixel-alert">
            {{ session('success') }}
        </div>
    @endif

    <!-- LIST -->
    <div class="pixel-course-list">

        @forelse($courses as $course)

        <div class="pixel-course-card">

            <!-- INFO -->
            <div>
                <div class="pixel-course-info">
                    <div class="pixel-course-thumb">
                        @if($course->image)
                             <img src="{{ $course->image_url }}" alt="{{ $course->title }}">
                        @else
                            📘
                        @endif
                    </div>

                    <div class="pixel-course-text">
                        <h3>{{ $course->title }}</h3>
                        <p>{{ Str::limit($course->description, 60) }}</p>

                        <div class="pixel-course-meta">
                            <span>💰 Rp {{ number_format($course->price) }}</span>
                            <span>👥 {{ $course->user_courses_count }} users</span>
                            <span>📅 {{ $course->created_at->format('M d, Y') }}</span>

                            <span class="pixel-badge {{ $course->is_active ? 'pixel-active' : 'pixel-inactive' }}">
                                {{ $course->is_active ? 'ACTIVE' : 'INACTIVE' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ACTIONS -->
            <div class="pixel-course-actions">
                <a href="{{ route('admin.courses.show', $course) }}" class="pixel-action-btn">VIEW</a>
                <a href="{{ route('admin.courses.contents.index', $course) }}" class="pixel-action-btn">CONTENT</a>
                <a href="{{ route('admin.courses.edit', $course) }}" class="pixel-action-btn">EDIT</a>
                <a href="{{ route('admin.courses.results', $course) }}" class="pixel-action-btn">RESULT</a>

                <form action="{{ route('admin.courses.destroy', $course) }}" method="POST"
                      onsubmit="return confirm('Are you sure you want to delete this course?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="pixel-action-btn" style="color:#ff5555">
                        DELETE
                    </button>
                </form>
            </div>

        </div>

        @empty

        <div class="pixel-empty">
            <h3>NO COURSES FOUND</h3>
            <p>Mulai dengan membuat course pertama</p>
            <a href="{{ route('admin.courses.create') }}" class="pixel-create-btn">
                CREATE COURSE
            </a>
        </div>

        @endforelse

    </div>

    <!-- PAGINATION -->
    @if($courses->hasPages())
        <div class="pixel-pagination">
            {{ $courses->links() }}
        </div>
    @endif

</div>

@endsection
