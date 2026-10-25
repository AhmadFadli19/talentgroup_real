@extends('layouts.app')

@section('title', $content->title)

@section('content')

<style>
/* ================= PIXEL CONTENT VIEW ================= */
.pixel-content {
    max-width: 1200px;
    margin: 0 auto;
}

/* HEADER */
.pixel-header {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 22px;
}

.pixel-back {
    border: 3px solid var(--border);
    background: var(--bg);
    padding: 6px 8px;
    box-shadow: 3px 3px 0 var(--shadow);
}

.pixel-back:hover {
    border-color: var(--accent);
    color: var(--accent);
}

.pixel-header h1 {
    font-size: 16px;
    color: var(--accent);
}

.pixel-meta {
    font-size: 9px;
    color: var(--muted);
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
}

/* GRID */
.pixel-grid {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 18px;
}

/* CARD */
.pixel-card {
    background: var(--card);
    border: 3px solid var(--border);
    box-shadow: 4px 4px 0 var(--shadow);
    padding: 18px;
}

.pixel-card h3 {
    font-size: 11px;
    color: var(--accent);
    margin-bottom: 10px;
}

/* CONTENT */
.pixel-text {
    white-space: pre-wrap;
    font-size: 10px;
    line-height: 1.6;
}

/* OPTIONS */
.pixel-option {
    border: 2px solid var(--border);
    padding: 10px;
    margin-bottom: 8px;
    font-size: 9px;
}

.pixel-option.correct {
    border-color: #22c55e;
    color: #22c55e;
}

/* ACTIONS */
.pixel-action {
    display: block;
    border: 3px solid var(--border);
    background: var(--bg);
    padding: 10px;
    font-size: 9px;
    margin-bottom: 8px;
    text-align: left;
}

.pixel-action:hover {
    border-color: var(--accent);
    color: var(--accent);
}

.pixel-danger {
    border-color: #ff5555;
    color: #ff5555;
}

/* INFO */
.pixel-info {
    font-size: 9px;
    color: var(--muted);
    margin-bottom: 6px;
}

/* RESPONSIVE */
@media(max-width:900px){
    .pixel-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<div class="pixel-content">

    <!-- HEADER -->
    <div class="pixel-header">
        <a href="{{ route('admin.courses.contents.index', $course) }}" class="pixel-back">◀</a>
        <div>
            <h1>{{ strtoupper($content->title) }}</h1>
            <div class="pixel-meta">
                <span>{{ strtoupper($content->type) }}</span>
                <span>ORDER {{ $content->order }}</span>
                <span>{{ $course->title }}</span>
            </div>
        </div>
    </div>

    <div class="pixel-grid">

        <!-- MAIN CONTENT -->
        <div>

            <div class="pixel-card">
                <h3>CONTENT PREVIEW</h3>
                <div class="course-story-article text-[14px] leading-relaxed" style="word-break: break-word;">
                    {!! \App\Services\ModuleMarkdownParser::parse($content->content) !!}
                </div>
            </div>

            @if($content->type === 'story' && ($content->use_image || $content->use_audio || $content->use_video))
                {{-- STORY MEDIA DETAILS --}}
                <div class="pixel-card" style="margin-top:16px; border-color: #3b82f6;">
                    <h3 style="color: #3b82f6;">📘 STORY MULTIMEDIA PREVIEW</h3>
                    
                    @if($content->use_image && $content->image_path)
                        <div style="margin-bottom: 16px;">
                            <strong style="font-size: 9px; color: var(--muted); display: block; margin-bottom: 6px;">🖼️ Image Preview:</strong>
                            <img src="{{ asset('storage/' . $content->image_path) }}" style="max-width: 100%; max-height: 250px; border: 2px solid var(--border);" alt="Story Image">
                        </div>
                    @endif

                    @if($content->use_audio && $content->audio_path)
                        <div style="margin-bottom: 16px;">
                            <strong style="font-size: 9px; color: var(--muted); display: block; margin-bottom: 6px;">🔊 Audio Player:</strong>
                            <audio controls src="{{ asset('storage/' . $content->audio_path) }}" style="max-width: 100%;"></audio>
                        </div>
                    @endif

                    @if($content->use_video && $content->video_url)
                        @php
                            $storyEmbedUrl = '';
                            if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/ ]{11})/', $content->video_url, $storyMatches)) {
                                $storyEmbedUrl = 'https://www.youtube.com/embed/' . $storyMatches[1];
                            } elseif (preg_match('/drive\.google\.com\/file\/d\/([a-zA-Z0-9_-]+)/', $content->video_url, $storyMatches)) {
                                $storyEmbedUrl = 'https://drive.google.com/file/d/' . $storyMatches[1] . '/preview';
                            }
                        @endphp

                        <div>
                            <strong style="font-size: 9px; color: var(--muted); display: block; margin-bottom: 6px;">🎥 Video Embed:</strong>
                            @if($storyEmbedUrl)
                                <div style="position: relative; width: 100%; aspect-ratio: 16/9; border: 2px solid var(--border); overflow: hidden; background: #000;">
                                    <iframe src="{{ $storyEmbedUrl }}" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: 0;" allowfullscreen></iframe>
                                </div>
                            @else
                                <div style="font-size: 9px; color: var(--muted);">
                                    Link Video: <a href="{{ $content->video_url }}" target="_blank">{{ $content->video_url }}</a>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            @endif

            @if($content->type === 'question' && isset($content->question_type) && $content->question_type === 'coding')
                {{-- CODING QUESTION DETAILS --}}
                <div class="pixel-card" style="margin-top:16px; border-color: #22c55e;">
                    <h3 style="color: #22c55e;"><i class="fas fa-terminal mr-2"></i>CODING CHALLENGE DETAILS</h3>

                    <div class="pixel-info" style="margin-bottom: 16px;">
                        <strong>Coding Rules:</strong><br>
                        @foreach($content->coding_rules ?? [] as $rule)
                            <span style="display: inline-block; padding: 3px 8px; border: 1px solid #22c55e; color: #22c55e; font-size: 8px; margin: 2px;">
                                {{ $codingRules[$rule] ?? $rule }}
                            </span>
                        @endforeach
                    </div>

                    <div style="margin-bottom: 16px;">
                        <strong style="font-size: 9px; color: var(--muted);">Admin Code:</strong>
                        <pre style="background: #0d1117; border: 2px solid #30363d; padding: 12px; font-size: 11px; color: #7ee787; font-family: Consolas, monospace; white-space: pre-wrap; margin-top: 6px;">{{ $content->admin_code }}</pre>
                    </div>

                    <div style="margin-bottom: 16px;">
                        <strong style="font-size: 9px; color: var(--muted);">Expected Output:</strong>
                        <pre style="background: #0d1117; border: 2px solid #30363d; padding: 12px; font-size: 11px; color: #58a6ff; font-family: Consolas, monospace; white-space: pre-wrap; margin-top: 6px;">{{ $content->expected_output }}</pre>
                    </div>

                    @if($content->starter_code)
                    <div style="margin-bottom: 16px;">
                        <strong style="font-size: 9px; color: var(--muted);">Starter Code:</strong>
                        <pre style="background: #0d1117; border: 2px solid #30363d; padding: 12px; font-size: 11px; color: #c9d1d9; font-family: Consolas, monospace; white-space: pre-wrap; margin-top: 6px;">{{ $content->starter_code }}</pre>
                    </div>
                    @endif

                    @if($content->hint)
                    <div>
                        <strong style="font-size: 9px; color: var(--muted);">Hint:</strong>
                        <div style="font-size: 9px; color: #eab308; padding: 8px; border: 1px solid rgba(234, 179, 8, 0.3); background: rgba(234, 179, 8, 0.05); margin-top: 6px;">
                            {{ $content->hint }}
                        </div>
                    </div>
                    @endif
                </div>
            @elseif($content->type === 'video')
                {{-- VIDEO PREVIEW --}}
                <div class="pixel-card" style="margin-top:16px; border-color: #ec4899;">
                    <h3 style="color: #ec4899;">📹 VIDEO DETAILS</h3>
                    
                    <div style="margin-bottom: 16px;">
                        <strong style="font-size: 9px; color: var(--muted);">Video URL:</strong>
                        <div style="font-size: 10px; color: var(--accent); font-family: monospace; word-break: break-all; margin-top: 4px;">
                            <a href="{{ $content->video_url }}" target="_blank">{{ $content->video_url }}</a>
                        </div>
                    </div>

                    @php
                        // Check if youtube link
                        $embedUrl = '';
                        if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/ ]{11})/', $content->video_url, $matches)) {
                            $embedUrl = 'https://www.youtube.com/embed/' . $matches[1];
                        } elseif (preg_match('/drive\.google\.com\/file\/d\/([a-zA-Z0-9_-]+)/', $content->video_url, $matches)) {
                            $embedUrl = 'https://drive.google.com/file/d/' . $matches[1] . '/preview';
                        }
                    @endphp

                    @if($embedUrl)
                        <div style="margin-top: 14px;">
                            <strong style="font-size: 9px; color: var(--muted); display: block; margin-bottom: 6px;">Video Preview:</strong>
                            <div style="position: relative; width: 100%; aspect-ratio: 16/9; border: 2px solid var(--border); overflow: hidden; background: #000;">
                                <iframe src="{{ $embedUrl }}" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: 0;" allowfullscreen></iframe>
                            </div>
                        </div>
                    @else
                        <div style="margin-top: 14px; font-size: 9px; color: var(--muted);">
                            ℹ Preview tidak tersedia untuk URL ini. Link eksternal dapat diakses langsung.
                        </div>
                    @endif
                </div>
            @elseif($content->type === 'html')
                {{-- HTML PREVIEW DETAILS --}}
                <div class="pixel-card" style="margin-top:16px; border-color: #06b6d4;">
                    <h3 style="color: #06b6d4;">🌐 HTML LIVE PREVIEW</h3>
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px; margin-top: 14px;">
                        <div>
                            <strong style="font-size: 9px; color: var(--muted); display: block; margin-bottom: 4px;">HTML Code:</strong>
                            <pre style="background: #0d1117; border: 2px solid #30363d; padding: 10px; font-size: 11px; color: #ff7b72; font-family: Consolas, monospace; white-space: pre-wrap; max-height: 200px; overflow-y: auto; margin-bottom: 12px;">{{ $content->html_code }}</pre>
                            
                            <strong style="font-size: 9px; color: var(--muted); display: block; margin-bottom: 4px;">CSS Code:</strong>
                            <pre style="background: #0d1117; border: 2px solid #30363d; padding: 10px; font-size: 11px; color: #79c0ff; font-family: Consolas, monospace; white-space: pre-wrap; max-height: 150px; overflow-y: auto; margin-bottom: 12px;">{{ $content->css_code }}</pre>

                            <strong style="font-size: 9px; color: var(--muted); display: block; margin-bottom: 4px;">JavaScript Code:</strong>
                            <pre style="background: #0d1117; border: 2px solid #30363d; padding: 10px; font-size: 11px; color: #d2a8ff; font-family: Consolas, monospace; white-space: pre-wrap; max-height: 150px; overflow-y: auto;">{{ $content->js_code }}</pre>
                        </div>
                        <div>
                            <strong style="font-size: 9px; color: var(--muted); display: block; margin-bottom: 6px;">Live Render Panel:</strong>
                            <div style="border: 3px solid var(--border); background: #fff; width: 100%; aspect-ratio: 1/1; overflow: hidden; position: relative;">
                                <iframe id="html-preview-iframe" style="width:100%; height:100%; border:0;"></iframe>
                            </div>
                        </div>
                    </div>
                </div>

                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const iframe = document.getElementById('html-preview-iframe');
                        if (iframe) {
                            const html = {!! json_encode($content->html_code) !!};
                            const css = {!! json_encode($content->css_code) !!};
                            const js = {!! json_encode($content->js_code) !!};
                            
                            const source = `
                                <!DOCTYPE html>
                                <html>
                                <head>
                                    <style>${css}</style>
                                </head>
                                <body>
                                    ${html}
                                    <script>${js}<\/script>
                                </body>
                                </html>
                            `;
                            iframe.srcdoc = source;
                        }
                    });
                </script>
            @elseif($content->type === 'question')
                <div class="pixel-card" style="margin-top:16px">
                    <h3>QUESTION OPTIONS</h3>

                    @foreach($content->options ?? [] as $index => $option)
                        <div class="pixel-option {{ $option === $content->correct_answer ? 'correct' : '' }}">
                            {{ chr(65 + $index) }}. {{ $option }}
                            @if($option === $content->correct_answer)
                                ✔
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif

        </div>

        <!-- SIDE -->
        <div>

            <!-- ACTIONS -->
            <div class="pixel-card">
                <h3>ACTIONS</h3>

                <a href="{{ route('admin.courses.contents.edit', [$course, $content->type, $content->id]) }}"
                   class="pixel-action">✏ EDIT CONTENT</a>

                <a href="{{ route('admin.courses.contents.create', $course) }}"
                   class="pixel-action">➕ ADD CONTENT</a>

                <form action="{{ route('admin.courses.contents.destroy', [$course, $content->type, $content->id]) }}"
                      method="POST"
                      onsubmit="return confirm('Delete this content?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="pixel-action pixel-danger">
                        🗑 DELETE CONTENT
                    </button>
                </form>
            </div>

            <!-- INFO -->
            <div class="pixel-card" style="margin-top:16px">
                <h3>CONTENT INFO</h3>

                <div class="pixel-info">Type: {{ ucfirst($content->type) }}</div>
                <div class="pixel-info">Order: {{ $content->order }}</div>
                <div class="pixel-info">Course: {{ $course->title }}</div>

                @if($content->type === 'question')
                    <div class="pixel-info">
                        Options: {{ count($content->options ?? []) }}
                    </div>
                @endif

                <div class="pixel-info">
                    Created: {{ $content->created_at->format('M d, Y H:i') }}
                </div>

                <div class="pixel-info">
                    Updated: {{ $content->updated_at->format('M d, Y H:i') }}
                </div>
            </div>

        </div>

    </div>

</div>

@endsection
