@extends('layouts.app')

@section('title', 'User Results - ' . $user->name)

@section('content')

<style>
/* ================= PIXEL USER RESULT ================= */
.pixel-user-result {
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

.pixel-header h1 {
    font-size: 16px;
    color: var(--accent);
}

.pixel-header p {
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

/* GRID */
.pixel-info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit,minmax(260px,1fr));
    gap: 16px;
    margin-bottom: 24px;
}

/* CARD */
.pixel-card {
    background: var(--card);
    border: 3px solid var(--border);
    box-shadow: 4px 4px 0 var(--shadow);
    padding: 16px;
}

.pixel-card h3 {
    font-size: 11px;
    color: var(--accent);
    margin-bottom: 10px;
}

.pixel-row {
    font-size: 9px;
    color: var(--muted);
    margin-bottom: 8px;
}

/* PROGRESS */
.pixel-progress {
    background: var(--bg);
    border: 2px solid var(--border);
    height: 16px;
    margin-top: 6px;
}

.pixel-progress-fill {
    background: var(--accent);
    height: 100%;
}

/* GRADE */
.pixel-grade {
    font-size: 22px;
    margin-top: 10px;
}

/* ANSWERS */
.pixel-answer {
    background: var(--bg);
    border: 2px solid var(--border);
    padding: 14px;
    margin-bottom: 14px;
}

.pixel-answer h4 {
    font-size: 10px;
    margin-bottom: 6px;
}

.pixel-option {
    font-size: 9px;
    padding: 6px;
    border: 2px solid var(--border);
    margin-bottom: 4px;
}

.pixel-correct {
    border-color: #22c55e;
    color: #22c55e;
}

.pixel-wrong {
    border-color: #ff5555;
    color: #ff5555;
}

/* BADGE */
.pixel-badge {
    border: 2px solid;
    padding: 2px 6px;
    font-size: 8px;
}

.pixel-good { border-color:#22c55e;color:#22c55e; }
.pixel-mid { border-color:#facc15;color:#facc15; }
.pixel-bad { border-color:#ff5555;color:#ff5555; }

/* RESPONSIVE */
@media(max-width:640px){
    .pixel-header h1 { font-size:14px; }
}
</style>

<div class="pixel-user-result">

    <!-- HEADER -->
    <div class="pixel-header">
        <a href="{{ route('admin.courses.results', $course) }}" class="pixel-back-btn">◀</a>
        <div>
            <h1>USER RESULT</h1>
            <p>{{ $user->name }} • {{ $course->title }}</p>
        </div>
    </div>

    @if(session('success'))
        <div style="margin-bottom: 20px; padding: 12px; border: 2px solid #22c55e; color: #22c55e; background: rgba(34, 197, 94, 0.05); font-size: 10px; font-weight: bold; font-family: 'Fira Code', monospace;">
            ✓ {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div style="margin-bottom: 20px; padding: 12px; border: 2px solid #ef4444; color: #ef4444; background: rgba(239, 68, 68, 0.05); font-size: 10px; font-weight: bold; font-family: 'Fira Code', monospace;">
            ✗ {{ session('error') }}
        </div>
    @endif

    <!-- STATS -->
    <div class="pixel-stats">
        <div class="pixel-stat">
            <h3>STUDENT</h3>
            <div class="pixel-stat-value">{{ $user->name }}</div>
        </div>

        <div class="pixel-stat">
            <h3>SCORE</h3>
            <div class="pixel-stat-value">{{ $score }}%</div>
        </div>

        <div class="pixel-stat">
            <h3>CORRECT</h3>
            <div class="pixel-stat-value">{{ $correctAnswers }}/{{ $totalQuestions }}</div>
        </div>

        <div class="pixel-stat">
            <h3>STATUS</h3>
            <div class="pixel-stat-value">
                {{ $userCourse->is_completed ? 'COMPLETED' : 'IN PROGRESS' }}
            </div>
        </div>
    </div>

    <!-- INFO -->
    <div class="pixel-info-grid">

        <!-- USER -->
        <div class="pixel-card">
            <h3>USER INFO</h3>
            <div class="pixel-row">Name: {{ $user->name }}</div>
            <div class="pixel-row">Email: {{ $user->email }}</div>
            <div class="pixel-row">Enrolled: {{ $userCourse->created_at->format('M d, Y H:i') }}</div>
            @if($userCourse->is_completed)
                <div class="pixel-row">Completed: {{ $userCourse->updated_at->format('M d, Y H:i') }}</div>
            @endif
        </div>

        <!-- COURSE -->
        <div class="pixel-card">
            <h3>COURSE INFO</h3>
            <div class="pixel-row">Title: {{ $course->title }}</div>
            <div class="pixel-row">Total Questions: {{ $totalQuestions }}</div>
            <div class="pixel-row">Price: Rp {{ number_format($course->price) }}</div>
        </div>

        <!-- PERFORMANCE -->
        <div class="pixel-card">
            <h3>PERFORMANCE</h3>
            <div class="pixel-progress">
                <div class="pixel-progress-fill" style="width: {{ $score }}%"></div>
            </div>

            <div class="pixel-grade
                {{ $score >= 80 ? 'pixel-good' : ($score >= 60 ? 'pixel-mid' : 'pixel-bad') }}">
                @if($score >= 80) A
                @elseif($score >= 70) B
                @elseif($score >= 60) C
                @elseif($score >= 50) D
                @else F
                @endif
            </div>
        </div>

        <!-- CERTIFICATE MANAGEMENT -->
        @if($userCourse->is_completed)
            @php
                $certificate = \App\Models\Certificate::where('user_id', $user->id)
                    ->where('course_id', $course->id)
                    ->first();
            @endphp
            <div class="pixel-card" style="grid-column: 1 / -1;">
                <h3>CERTIFICATE MANAGEMENT</h3>
                
                @if($certificate)
                    <div class="pixel-row">Status: 
                        <span class="pixel-badge {{ $certificate->isManual() ? 'pixel-progress' : 'pixel-good' }}" style="font-weight: bold; border-width: 1px;">
                            {{ strtoupper($certificate->type) }}
                        </span>
                    </div>
                    <div class="pixel-row">Code: <span style="font-family: 'Fira Code', monospace; color: var(--accent); font-weight: bold;">{{ $certificate->certificate_code }}</span></div>
                    <div class="pixel-row">Issued At: {{ $certificate->issued_at->format('M d, Y H:i') }}</div>
                    
                    @if($certificate->isManual() && $certificate->file_path)
                        <div class="pixel-row" style="margin-top: 8px;">
                            <a href="{{ Storage::url($certificate->file_path) }}" target="_blank" style="color: var(--accent); text-decoration: underline; font-weight: bold;">
                                🔗 View Uploaded Certificate File
                            </a>
                        </div>
                    @endif
                    
                    @if($certificate->isManual())
                        <form action="{{ route('admin.courses.certificate.reset', $course->id) }}" method="POST" style="margin-top: 14px;">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ $user->id }}">
                            <button type="submit" class="pixel-badge pixel-bad font-bold" style="background: transparent; cursor: pointer; padding: 4px 10px;">
                                🔄 Reset to Automatic Certificate
                            </button>
                        </form>
                    @endif
                @else
                    <div class="pixel-row" style="color: #ff5555; font-weight: bold;">⚠️ Certificate is not yet active. (It will be generated automatically when the user requests it).</div>
                @endif
                
                <!-- Upload Override Form -->
                <div style="margin-top: 20px; padding-top: 16px; border-top: 2px solid var(--border);">
                    <h4 style="font-size: 10px; color: var(--accent); margin-bottom: 10px;" class="font-bold">UPLOAD MANUAL CERTIFICATE OVERRIDE</h4>
                    <form action="{{ route('admin.courses.certificate.upload', $course->id) }}" method="POST" enctype="multipart/form-data" style="display: flex; flex-direction: column; gap: 12px;">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ $user->id }}">
                        
                        <div style="display: flex; flex-direction: column; gap: 6px;">
                            <span style="font-size: 8px; color: var(--muted); font-weight: bold;">SELECT CERTIFICATE FILE (PDF, JPG, PNG):</span>
                            <input type="file" name="certificate_file" required style="font-size: 9px; padding: 6px; border: 2px solid var(--border); background: var(--bg); color: var(--text); width: 100%; max-width: 400px;">
                        </div>
                        
                        <div>
                            <button type="submit" class="pixel-badge pixel-good font-bold" style="background: transparent; cursor: pointer; padding: 6px 14px; border-width: 2px; font-size: 9px;">
                                📤 Upload & Set Manual Override
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @endif

    </div>

    <!-- ANSWERS -->
    <div class="pixel-card">
        <h3>DETAILED ANSWERS</h3>

        @forelse($answers as $answer)

            <div class="pixel-answer">
                <h4>{{ $answer->courseQuestion->title }}</h4>
                <div class="pixel-row">{{ $answer->courseQuestion->content }}</div>

                @if($answer->courseQuestion->isCoding())
                    <div style="margin: 10px 0; font-family: monospace; font-size: 9px; background: rgba(0,0,0,0.3); padding: 10px; border: 1px solid var(--border);">
                        <div style="color: var(--accent); font-weight: bold; margin-bottom: 6px;">💻 CODING CHALLENGE ({{ strtoupper($answer->courseQuestion->language ?? 'GOLANG') }})</div>
                        @if($answer->code_submitted || $answer->answer)
                            <div style="margin-bottom: 8px;">
                                <div style="color: var(--muted); margin-bottom: 3px;">Kode yang Dikirim Siswa:</div>
                                <pre style="background: rgba(0,0,0,0.6); padding: 8px; border-radius: 4px; overflow-x: auto; color: #a5f3fc; border: 1px solid var(--border);">{{ $answer->code_submitted ?? $answer->answer }}</pre>
                            </div>
                        @endif
                        @if($answer->code_output)
                            <div style="margin-bottom: 8px;">
                                <div style="color: var(--muted); margin-bottom: 3px;">Output Eksekusi Siswa:</div>
                                <pre style="background: rgba(0,0,0,0.6); padding: 8px; border-radius: 4px; overflow-x: auto; color: #fef08a; border: 1px solid var(--border);">{{ $answer->code_output }}</pre>
                            </div>
                        @endif
                        @if($answer->courseQuestion->expected_output)
                            <div>
                                <div style="color: #22c55e; margin-bottom: 3px;">Expected Output:</div>
                                <pre style="background: rgba(34,197,94,0.1); padding: 8px; border-radius: 4px; overflow-x: auto; color: #86efac; border: 1px solid rgba(34,197,94,0.3);">{{ $answer->courseQuestion->expected_output }}</pre>
                            </div>
                        @endif
                    </div>
                @else
                    @if($answer->courseQuestion->options)
                        @foreach($answer->courseQuestion->options as $optIdx => $option)
                            @php
                                $optLetter = chr(65 + $optIdx);
                                $isCorrectOpt = ($option === $answer->courseQuestion->correct_answer);
                                $isChosen = ($option === $answer->answer);
                            @endphp
                            <div class="pixel-option {{ $isCorrectOpt ? 'pixel-correct' : ($isChosen ? 'pixel-wrong' : '') }}">
                                <strong>{{ $optLetter }}.</strong> {{ $option }}
                                @if($isCorrectOpt) <span style="font-weight: bold;">(Kunci Benar)</span> @endif
                                @if($isChosen && !$isCorrectOpt) <span style="font-weight: bold;">(Dipilih Siswa)</span> @endif
                            </div>
                        @endforeach
                    @endif

                    <div class="pixel-row {{ $answer->is_correct ? 'pixel-good' : 'pixel-bad' }}">
                        Jawaban Siswa: {{ $answer->answer }}
                    </div>

                    <div class="pixel-row pixel-good">
                        Kunci Benar: {{ $answer->courseQuestion->correct_answer }}
                    </div>
                @endif

                <div class="pixel-row">
                    <span class="pixel-badge {{ $answer->is_correct ? 'pixel-good' : 'pixel-bad' }}">
                        {{ $answer->is_correct ? '✔ BENAR' : '✖ BELUM TEPAT' }}
                    </span>
                    • {{ $answer->created_at->format('M d, Y H:i') }}
                    • Poin: {{ $answer->points }}
                </div>
            </div>

        @empty
            <p class="pixel-row">Belum ada jawaban soal yang tercatat pada kursus ini.</p>
        @endforelse
    </div>

</div>

@endsection
