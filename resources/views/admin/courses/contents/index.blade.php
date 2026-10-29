@extends('layouts.app')

@section('title', 'Manage Course Content - ' . $course->title)

@section('content')

<style>
/* ================= PIXEL CONTENT LIST ================= */
.pixel-wrapper {
    max-width: 1200px;
    margin: 0 auto;
}

/* HEADER */
.pixel-head {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 24px;
}

.pixel-title h1 {
    font-size: 16px;
    color: var(--accent);
}

.pixel-title p {
    font-size: 9px;
    color: var(--muted);
}

.pixel-btn {
    border: 3px solid var(--border);
    background: var(--bg);
    padding: 8px 14px;
    font-size: 9px;
    box-shadow: 3px 3px 0 var(--shadow);
}

.pixel-btn:hover {
    border-color: var(--accent);
    color: var(--accent);
}

/* CARD */
.pixel-card {
    background: var(--card);
    border: 3px solid var(--border);
    box-shadow: 4px 4px 0 var(--shadow);
    padding: 14px;
    margin-bottom: 14px;
    display: grid;
    grid-template-columns: 60px 1fr auto;
    gap: 14px;
}

.pixel-order {
    width: 48px;
    height: 48px;
    border: 3px solid var(--border);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 11px;
    background: var(--bg);
}

.pixel-body h3 {
    font-size: 11px;
    margin-bottom: 4px;
}

.pixel-type {
    font-size: 8px;
    padding: 2px 6px;
    border: 2px solid;
    display: inline-block;
    margin-bottom: 6px;
}

.pixel-type.story {
    border-color: #3b82f6;
    color: #3b82f6;
}

.pixel-type.question {
    border-color: #22c55e;
    color: #22c55e;
}

.pixel-type.coding {
    border-color: var(--yellow);
    color: var(--yellow);
    background: rgba(245, 158, 11, 0.1);
}

.pixel-type.video {
    border-color: #ec4899;
    color: #ec4899;
    background: rgba(236, 72, 153, 0.1);
}

.pixel-type.html {
    border-color: #06b6d4;
    color: #06b6d4;
    background: rgba(6, 182, 212, 0.1);
}

.pixel-preview {
    font-size: 9px;
    color: var(--muted);
}

/* ACTIONS */
.pixel-actions a,
.pixel-actions button {
    display: block;
    border: 3px solid var(--border);
    background: var(--bg);
    padding: 6px 8px;
    font-size: 8px;
    margin-bottom: 6px;
    text-align: center;
}

.pixel-actions a:hover {
    border-color: var(--accent);
    color: var(--accent);
}

.pixel-danger {
    border-color: #ff5555;
    color: #ff5555;
}

/* EMPTY */
.pixel-empty {
    text-align: center;
    padding: 40px;
    font-size: 10px;
    color: var(--muted);
}

/* RESPONSIVE */
@media(max-width:800px){
    .pixel-card {
        grid-template-columns: 1fr;
    }
    .pixel-order {
        width: 100%;
        height: auto;
    }
}
</style>

<div class="pixel-wrapper">

    <!-- HEADER -->
    <div class="pixel-head">
        <div class="pixel-title">
            <h1>COURSE CONTENT</h1>
            <p>{{ $course->title }}</p>
        </div>

        <a href="{{ route('admin.courses.contents.create', $course) }}" class="pixel-btn">
            ➕ ADD CONTENT
        </a>
    </div>


    @if($contents->count())

        @foreach($contents as $content)
            <div class="pixel-card">

                <!-- ORDER -->
                <div class="pixel-order">
                    {{ $content->order }}
                </div>

                <!-- BODY -->
                <div class="pixel-body">
                    <h3>{{ $content->title }}</h3>

                    @php
                        $displayType = $content->type;
                        $isCodingQ = $content->type === 'question' && isset($content->question_type) && $content->question_type === 'coding';
                        if ($isCodingQ) $displayType = 'coding';
                    @endphp

                    <span class="pixel-type {{ $displayType }}">
                        @if($isCodingQ)
                            <i class="fas fa-terminal mr-1"></i> CODING
                        @elseif($content->type === 'question')
                            <i class="fas fa-question-circle mr-1"></i> QUESTION
                        @elseif($content->type === 'video')
                            <i class="fas fa-play-circle mr-1"></i> VIDEO
                        @elseif($content->type === 'html')
                            <i class="fas fa-globe mr-1"></i> HTML PREVIEW
                        @else
                            <i class="fas fa-book-open mr-1"></i> STORY
                        @endif
                    </span>

                    @if($content->type === 'question')
                        @php
                            $levelStyles = [
                                'beginner' => 'border-color:#10b981;color:#059669;background:rgba(16,185,129,.08)',
                                'intermediate' => 'border-color:#f59e0b;color:#d97706;background:rgba(245,158,11,.08)',
                                'advanced' => 'border-color:#f43f5e;color:#e11d48;background:rgba(244,63,94,.08)',
                            ];
                        @endphp
                        <span class="pixel-type" style="{{ $levelStyles[$content->difficulty ?? 'beginner'] }}">
                            LEVEL {{ strtoupper($content->difficulty_label) }}
                        </span>
                    @endif

                    <div class="pixel-preview">
                        {!! \App\Services\ModuleMarkdownParser::parseInlinePreview(Str::limit($content->content, 90)) !!}
                        @if($isCodingQ)
                            <br>({{ count($content->coding_rules ?? []) }} rules)
                        @elseif($content->type === 'question' && isset($content->options))
                            <br>({{ count($content->options) }} options)
                        @elseif($content->type === 'video')
                            <br>URL: {{ $content->video_url }}
                        @elseif($content->type === 'html')
                            <br>(HTML, CSS, JS live preview)
                        @endif
                    </div>
                </div>

                <!-- ACTIONS -->
                <div class="pixel-actions">
                    <a href="{{ route('admin.courses.contents.show', [$course, $content->type, $content->id]) }}">
                        👁 VIEW
                    </a>

                    <a href="{{ route('admin.courses.contents.edit', [$course, $content->type, $content->id]) }}">
                        ✏ EDIT
                    </a>

                    <form action="{{ route('admin.courses.contents.destroy', [$course, $content->type, $content->id]) }}"
                          method="POST"
                          onsubmit="return confirm('Delete this content?')">
                        @csrf
                        @method('DELETE')
                        <button class="pixel-danger">
                            🗑 DELETE
                        </button>
                    </form>
                </div>

            </div>
        @endforeach

    @else
        <div class="pixel-card pixel-empty">
            NO CONTENT YET<br><br>
            <a href="{{ route('admin.courses.contents.create', $course) }}" class="pixel-btn">
                ➕ CREATE FIRST CONTENT
            </a>
        </div>
    @endif

</div>

@endsection
