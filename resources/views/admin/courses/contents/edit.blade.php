@extends('layouts.app')

@section('title', 'Edit Course Content')

@section('content')

<style>
.pixel-editor { max-width: 960px; margin: 0 auto; }
.pixel-header { display: flex; align-items: center; gap: 12px; margin-bottom: 24px; }
.pixel-back { border: 3px solid var(--border); padding: 6px 8px; background: var(--bg); box-shadow: 3px 3px 0 var(--shadow); text-decoration: none; color: var(--text); }
.pixel-back:hover { border-color: var(--accent); color: var(--accent); }
.pixel-header h1 { font-size: 16px; color: var(--accent); }
.pixel-header p { font-size: 9px; color: var(--muted); }
.pixel-card { background: var(--card); border: 3px solid var(--border); box-shadow: 4px 4px 0 var(--shadow); padding: 20px; }
.pixel-group { margin-bottom: 16px; }
.pixel-label { font-size: 9px; color: var(--muted); margin-bottom: 6px; display: block; }
.pixel-input, .pixel-textarea, .pixel-select { width: 100%; background: var(--bg); border: 3px solid var(--border); padding: 10px; font-size: 10px; color: var(--text); font-family: inherit; }
.pixel-input:focus, .pixel-textarea:focus, .pixel-select:focus { outline: none; border-color: var(--accent); }
.pixel-textarea { min-height: 110px; resize: vertical; }
.pixel-code-textarea { min-height: 200px; font-family: 'Fira Code', 'Cascadia Code', 'Consolas', monospace; font-size: 12px; tab-size: 4; }
.pixel-help { font-size: 8px; color: var(--muted); margin-top: 4px; }
.pixel-error { font-size: 8px; color: #ff5555; margin-top: 4px; }
.pixel-question { border: 3px dashed var(--border); padding: 14px; margin-top: 20px; }
.pixel-coding { border: 3px dashed #22c55e; padding: 14px; margin-top: 20px; background: rgba(34, 197, 94, 0.03); }
.pixel-option { display: flex; gap: 8px; margin-bottom: 8px; }
.pixel-option input { flex: 1; }
.pixel-btn { border: 3px solid var(--border); background: var(--bg); padding: 6px 10px; font-size: 8px; box-shadow: 3px 3px 0 var(--shadow); cursor: pointer; color: var(--text); font-family: inherit; }
.pixel-btn:hover { border-color: var(--accent); color: var(--accent); }
.pixel-danger { border-color: #ff5555; color: #ff5555; }
.pixel-actions { display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px; }
.rules-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 8px; margin-top: 8px; }
.rule-checkbox { display: flex; align-items: center; gap: 8px; padding: 8px 10px; border: 2px solid var(--border); background: var(--bg); cursor: pointer; transition: all 0.2s; font-size: 8px; color: var(--text); }
.rule-checkbox:hover { border-color: var(--accent); }
.rule-checkbox input[type="checkbox"] { accent-color: var(--accent); width: 14px; height: 14px; }
.rule-checkbox.checked { border-color: #22c55e; background: rgba(34, 197, 94, 0.1); }
.compile-section { margin-top: 16px; padding: 12px; border: 2px solid var(--accent); background: rgba(138, 92, 255, 0.05); }
.compile-btn { background: var(--accent); color: #fff; border-color: var(--accent); padding: 8px 16px; }
.compile-output { margin-top: 10px; background: #0d1117; border: 2px solid #30363d; padding: 12px; font-family: 'Consolas', monospace; font-size: 11px; min-height: 60px; white-space: pre-wrap; color: #c9d1d9; }
.compile-output.error { color: #f85149; }
.compile-output.success { color: #7ee787; }
@media(max-width:640px){ .pixel-actions { flex-direction: column; } .rules-grid { grid-template-columns: 1fr; } }
</style>

@php
    $isCoding = $content->type === 'question' && $content->isCoding();
    $isMultipleChoice = $content->type === 'question' && !$content->isCoding();
    $editType = $content->type === 'story' ? 'story' : ($content->type === 'video' ? 'video' : ($content->type === 'html' ? 'html' : ($isCoding ? 'coding' : 'question')));
@endphp

<div class="pixel-editor" x-data="adminCoding()">

    <div class="pixel-header">
        <a href="{{ route('admin.courses.contents.index', $course) }}" class="pixel-back">◀</a>
        <div>
            <h1>EDIT CONTENT</h1>
            <p>{{ $course->title }}</p>
        </div>
    </div>

    <div class="pixel-card">
        <form action="{{ route('admin.courses.contents.update', [$course, $content->type === 'story' ? 'story' : ($content->type === 'video' ? 'video' : ($content->type === 'html' ? 'html' : 'question')), $content->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- TITLE --}}
            <div class="pixel-group">
                <label class="pixel-label">CONTENT TITLE</label>
                <input type="text" name="title" value="{{ old('title', $content->title) }}" required class="pixel-input">
                @error('title') <div class="pixel-error">{{ $message }}</div> @enderror
            </div>

            {{-- TYPE --}}
            <div class="pixel-group">
                <label class="pixel-label">CONTENT TYPE</label>
                <select name="type" x-model="contentType" class="pixel-select" {{ $content->type === 'story' || $content->type === 'video' || $content->type === 'html' ? 'disabled' : '' }}>
                    <option value="story" {{ $editType === 'story' ? 'selected' : '' }}>📘 STORY</option>
                    <option value="video" {{ $editType === 'video' ? 'selected' : '' }}>📹 VIDEO</option>
                    <option value="question" {{ $editType === 'question' ? 'selected' : '' }}>❓ QUESTION</option>
                    <option value="coding" {{ $editType === 'coding' ? 'selected' : '' }}>💻 CODING</option>
                    <option value="html" {{ $editType === 'html' ? 'selected' : '' }}>🌐 HTML PREVIEW</option>
                </select>
                @if($content->type === 'story')
                    <input type="hidden" name="type" value="story">
                @elseif($content->type === 'video')
                    <input type="hidden" name="type" value="video">
                @elseif($content->type === 'html')
                    <input type="hidden" name="type" value="html">
                @endif
            </div>

            {{-- Hidden question_type for backend --}}
            <input type="hidden" name="question_type" :value="contentType === 'coding' ? 'coding' : 'multiple_choice'">

            {{-- CONTENT --}}
            <div class="pixel-group">
                <label class="pixel-label">CONTENT TEXT</label>
                <textarea name="content" required class="pixel-textarea">{{ old('content', $content->content) }}</textarea>
            </div>

            {{-- ORDER --}}
            <div class="pixel-group">
                <label class="pixel-label">ORDER</label>
                <input type="number" name="order" min="1" value="{{ old('order', $content->order) }}" required class="pixel-input">
            </div>

            {{-- STORY FIELDS (Media Options: Image, Audio, Video URL) --}}
            <div x-show="contentType === 'story'" class="pixel-question" style="border-color: #3b82f6; background: rgba(59, 130, 246, 0.03); margin-top: 20px;">
                <strong style="font-size:10px; color: #3b82f6;">📘 STORY MULTIMEDIA OPTIONS</strong>
                <p class="pixel-help mb-4">Pilih dan aktifkan opsi media yang ingin Anda sertakan di story ini. Anda bisa mengaktifkan ketiganya, sebagian, atau tidak sama sekali.</p>

                <!-- IMAGE OPTION -->
                <div style="border: 2px solid var(--border); padding: 12px; margin-bottom: 12px; background: var(--bg);">
                    <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 8px;">
                        <input type="checkbox" name="use_image" id="use_image" value="1" x-model="useImage" style="accent-color: var(--accent); width: 16px; height: 16px;">
                        <label for="use_image" style="font-size: 10px; font-weight: bold; cursor: pointer;">🖼️ SERTAKAN GAMBAR (IMAGE)</label>
                    </div>
                    <div x-show="useImage" style="margin-left: 24px; margin-top: 8px;">
                        @if($content->type === 'story' && $content->image_path)
                            <div style="margin-bottom: 8px;">
                                <span class="pixel-label">GAMBAR SAAT INI:</span>
                                <img src="{{ asset('storage/' . $content->image_path) }}" style="max-height: 80px; border: 2px solid var(--border); display: block;" alt="Current Image">
                            </div>
                        @endif
                        <label class="pixel-label">UPLOAD GAMBAR BARU (Akan menggantikan gambar lama)</label>
                        <input type="file" name="image_file" class="pixel-input" accept="image/*">
                        <div class="pixel-help">Pilih file gambar (JPG, PNG, GIF, WebP). Akan dimuat aman saat di-hosting.</div>
                    </div>
                </div>

                <!-- AUDIO OPTION -->
                <div style="border: 2px solid var(--border); padding: 12px; margin-bottom: 12px; background: var(--bg);">
                    <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 8px;">
                        <input type="checkbox" name="use_audio" id="use_audio" value="1" x-model="useAudio" style="accent-color: var(--accent); width: 16px; height: 16px;">
                        <label for="use_audio" style="font-size: 10px; font-weight: bold; cursor: pointer;">🔊 SERTAKAN AUDIO (AUDIO PLAYER)</label>
                    </div>
                    <div x-show="useAudio" style="margin-left: 24px; margin-top: 8px;">
                        @if($content->type === 'story' && $content->audio_path)
                            <div style="margin-bottom: 8px;">
                                <span class="pixel-label">AUDIO SAAT INI:</span>
                                <audio controls style="height: 30px; max-width: 100%; display: block;" src="{{ asset('storage/' . $content->audio_path) }}"></audio>
                            </div>
                        @endif
                        <label class="pixel-label">UPLOAD AUDIO BARU (Akan menggantikan audio lama)</label>
                        <input type="file" name="audio_file" class="pixel-input" accept="audio/*">
                        <div class="pixel-help">Pilih file audio (MP3, WAV, M4A). Akan diputar menggunakan real audio player.</div>
                    </div>
                </div>

                <!-- VIDEO OPTION -->
                <div style="border: 2px solid var(--border); padding: 12px; margin-bottom: 12px; background: var(--bg);">
                    <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 8px;">
                        <input type="checkbox" name="use_video_story" id="use_video_story" value="1" x-model="useVideoStory" style="accent-color: var(--accent); width: 16px; height: 16px;">
                        <label for="use_video_story" style="font-size: 10px; font-weight: bold; cursor: pointer;">🎥 SERTAKAN VIDEO EMBED</label>
                    </div>
                    <div x-show="useVideoStory" style="margin-left: 24px; margin-top: 8px;">
                        <label class="pixel-label">VIDEO URL (YouTube / Google Drive)</label>
                        <input type="url" name="video_url_story" value="{{ old('video_url_story', $content->type === 'story' ? $content->video_url : '') }}" class="pixel-input" placeholder="https://www.youtube.com/watch?v=... atau https://drive.google.com/file/d/.../view">
                        <div class="pixel-help">Mendukung link YouTube standard/share dan link Google Drive shareable file.</div>
                    </div>
                </div>
            </div>

            {{-- HTML PREVIEW FIELDS --}}
            <div x-show="contentType === 'html'" class="pixel-question" style="border-color: #06b6d4; background: rgba(6, 182, 212, 0.03); margin-top: 20px;">
                <strong style="font-size:10px; color: #06b6d4;">🌐 HTML PREVIEW SETTINGS</strong>
                <p class="pixel-help mb-4">Di bagian ini, Anda dapat memasukkan kode HTML, CSS, dan JS yang akan dirender secara langsung (live render split-screen) di halaman siswa. Ideal untuk materi interaktif dan layout responsif.</p>

                {{-- HTML Code --}}
                <div class="pixel-group mt-4">
                    <label class="pixel-label">HTML CODE</label>
                    <textarea name="html_code" class="pixel-textarea pixel-code-textarea" style="min-height: 150px;" placeholder="Tulis kode HTML di sini...">{{ old('html_code', $content->type === 'html' ? $content->html_code : '<h1>Halo Dunia!</h1>') }}</textarea>
                </div>

                {{-- CSS Code --}}
                <div class="pixel-group mt-4">
                    <label class="pixel-label">CSS CODE</label>
                    <textarea name="css_code" class="pixel-textarea pixel-code-textarea" style="min-height: 150px;" placeholder="Tulis kode CSS di sini...">{{ old('css_code', $content->type === 'html' ? $content->css_code : 'h1 { color: #0056d2; text-align: center; font-family: sans-serif; }') }}</textarea>
                </div>

                {{-- JS Code --}}
                <div class="pixel-group mt-4">
                    <label class="pixel-label">JAVASCRIPT CODE</label>
                    <textarea name="js_code" class="pixel-textarea pixel-code-textarea" style="min-height: 150px;" placeholder="Tulis kode JavaScript di sini...">{{ old('js_code', $content->type === 'html' ? $content->js_code : '// console.log("Hello from HTML preview");') }}</textarea>
                </div>
            </div>

            {{-- VIDEO FIELDS --}}
            <div x-show="contentType === 'video'" class="pixel-question" style="border-color: #ec4899; background: rgba(236, 72, 153, 0.03);">
                <strong style="font-size:10px; color: #ec4899;">📹 VIDEO SETTINGS</strong>
                <div class="pixel-group mt-4">
                    <label class="pixel-label">VIDEO URL</label>
                    <input type="url" name="video_url" value="{{ old('video_url', $content->video_url ?? '') }}" class="pixel-input" placeholder="https://www.youtube.com/watch?v=... atau https://drive.google.com/file/d/.../view">
                    <div class="pixel-help">Mendukung link YouTube standard/share dan link Google Drive shareable file.</div>
                </div>
            </div>

            {{-- QUESTION FIELDS --}}
            <div x-show="contentType === 'question'" class="pixel-question">
                <strong style="font-size:10px;">❓ MULTIPLE CHOICE OPTIONS</strong>

                <div id="options-container" class="mt-3">
                    @php $options = old('options', $content->options ?? []); @endphp
                    @if(is_array($options))
                        @foreach($options as $option)
                            <div class="pixel-option">
                                <input type="text" name="options[]" value="{{ $option }}" class="pixel-input">
                                <button type="button" onclick="removeOption(this)" class="pixel-btn pixel-danger">✖</button>
                            </div>
                        @endforeach
                    @endif
                </div>

                <button type="button" onclick="addOption()" class="pixel-btn mt-2">➕ ADD OPTION</button>

                <div class="pixel-group mt-4">
                    <label class="pixel-label">CORRECT ANSWER</label>
                    <input type="text" name="correct_answer" value="{{ old('correct_answer', $content->correct_answer ?? '') }}" class="pixel-input">
                </div>
            </div>

            {{-- CODING FIELDS --}}
            <div x-show="contentType === 'coding'" class="pixel-coding">
                <strong style="font-size:10px; color: #22c55e;">💻 CODING CHALLENGE SETTINGS</strong>

                {{-- Language Selector --}}
                <div class="pixel-group mt-4">
                    <label class="pixel-label">PROGRAMMING LANGUAGE</label>
                    <select name="language" x-model="selectedLanguage" class="pixel-select">
                        @foreach(\App\Services\CodeExecutionService::availableLanguages() as $langKey => $langLabel)
                            <option value="{{ $langKey }}" {{ old('language', $content->language ?? 'go') === $langKey ? 'selected' : '' }}>{{ $langLabel }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Coding Rules --}}
                <div class="pixel-group mt-4">
                    <label class="pixel-label">CODING RULES</label>
                    <div class="rules-grid">
                        @foreach($codingRules as $ruleKey => $ruleLabel)
                            <label class="rule-checkbox" :class="selectedRules.includes('{{ $ruleKey }}') ? 'checked' : ''">
                                <input type="checkbox" name="coding_rules[]" value="{{ $ruleKey }}"
                                       x-model="selectedRules"
                                       {{ in_array($ruleKey, old('coding_rules', $content->coding_rules ?? [])) ? 'checked' : '' }}>
                                <span>{{ $ruleLabel }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                {{-- Admin Code --}}
                <div class="pixel-group mt-4">
                    <label class="pixel-label">ADMIN CODE (Kode solusi referensi)</label>
                    <textarea name="admin_code" x-model="adminCode" class="pixel-textarea pixel-code-textarea">{{ old('admin_code', $content->admin_code ?? '') }}</textarea>
                </div>

                {{-- Compile Admin Code --}}
                <div class="compile-section">
                    <label class="pixel-label">TEST ADMIN CODE</label>

                    <div class="pixel-group">
                        <label class="pixel-label" style="color: var(--yellow);">INPUT (opsional, untuk program yang membutuhkan input)</label>
                        <textarea x-model="compileInput" class="pixel-textarea" style="min-height: 60px; font-family: Consolas, monospace; font-size: 11px;" placeholder="Masukkan input yang akan diberikan ke program..."></textarea>
                    </div>

                    <button type="button" @click="compileAdminCode()" class="pixel-btn compile-btn" :disabled="isCompiling">
                        <span x-text="isCompiling ? '⏳ Compiling...' : '▶ Run Admin Code'"></span>
                    </button>
                    <div class="compile-output" :class="compileError ? 'error' : 'success'" x-show="compileResult !== null">
                        <span x-text="compileResult"></span>
                    </div>
                </div>

                {{-- Expected Output --}}
                <div class="pixel-group mt-4">
                    <label class="pixel-label">EXPECTED OUTPUT</label>
                    <textarea name="expected_output" x-model="expectedOutput" class="pixel-textarea pixel-code-textarea" style="min-height: 100px;">{{ old('expected_output', $content->expected_output ?? '') }}</textarea>
                </div>

                {{-- Test Cases --}}
                <div class="pixel-group mt-4">
                    <label class="pixel-label" style="color: var(--yellow);">📋 TEST CASES (Input → Output)</label>
                    <div style="font-size: 8px; color: var(--muted); margin-bottom: 8px;">Tentukan test case: input apa yang diberikan dan output apa yang diharapkan.</div>

                    <template x-for="(testCase, index) in testCases" :key="index">
                        <div style="border: 2px dashed var(--border); padding: 12px; margin-bottom: 10px;">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                                <strong style="font-size: 9px; color: var(--accent);">Test Case <span x-text="index + 1"></span></strong>
                                <div style="display: flex; gap: 6px;">
                                    <button type="button" @click="runTestCase(index)" class="pixel-btn" style="font-size: 7px; padding: 3px 8px; background: rgba(34, 197, 94, 0.1); border-color: #22c55e; color: #22c55e;" :disabled="isCompiling">▶ Test</button>
                                    <button type="button" @click="removeTestCase(index)" class="pixel-btn pixel-danger" style="font-size: 7px; padding: 3px 8px;" x-show="testCases.length > 1">✖</button>
                                </div>
                            </div>
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 8px;">
                                <div>
                                    <label class="pixel-label">Input</label>
                                    <textarea :name="'test_cases[' + index + '][input]'" x-model="testCase.input" class="pixel-textarea" style="min-height: 60px; font-family: Consolas, monospace; font-size: 11px;" placeholder="Input data..."></textarea>
                                </div>
                                <div>
                                    <label class="pixel-label">Expected Output</label>
                                    <textarea :name="'test_cases[' + index + '][expected_output]'" x-model="testCase.expected_output" class="pixel-textarea" style="min-height: 60px; font-family: Consolas, monospace; font-size: 11px;" placeholder="Output yang diharapkan..."></textarea>
                                </div>
                            </div>
                            <div x-show="testCase.result !== null" class="compile-output mt-2" :class="testCase.passed ? 'success' : 'error'" style="font-size: 9px;">
                                <span x-text="testCase.result"></span>
                            </div>
                        </div>
                    </template>

                    <button type="button" @click="addTestCase()" class="pixel-btn" style="background: rgba(245, 158, 11, 0.1); border-color: var(--yellow); color: var(--yellow);">
                        ➕ ADD TEST CASE
                    </button>
                </div>

                {{-- Starter Code --}}
                <div class="pixel-group mt-4">
                    <label class="pixel-label">STARTER CODE (Template untuk user)</label>
                    <textarea name="starter_code" class="pixel-textarea pixel-code-textarea">{{ old('starter_code', $content->starter_code ?? '') }}</textarea>
                </div>

                {{-- Hint --}}
                <div class="pixel-group mt-4">
                    <label class="pixel-label">HINT (Opsional)</label>
                    <textarea name="hint" class="pixel-textarea" style="min-height: 60px;">{{ old('hint', $content->hint ?? '') }}</textarea>
                </div>
            </div>

            <div class="pixel-actions">
                <a href="{{ route('admin.courses.contents.index', $course) }}" class="pixel-btn">CANCEL</a>
                <button type="submit" class="pixel-btn" style="background:var(--accent);color:#fff">UPDATE CONTENT</button>
            </div>
        </form>
    </div>
</div>

@php
    $defaultTestCases = old('test_cases', $content->test_cases ?? [['input' => '', 'expected_output' => '']]);
@endphp
<script>
function adminCoding() {
    return {
        contentType: '{{ $editType }}',
        selectedRules: @json(old('coding_rules', $content->coding_rules ?? [])),
        selectedLanguage: '{{ old('language', $content->language ?? 'go') }}',
        adminCode: @json(old('admin_code', $content->admin_code ?? '')),
        expectedOutput: @json(old('expected_output', $content->expected_output ?? '')),
        compileInput: '',
        isCompiling: false,
        compileResult: null,
        compileError: false,
        testCases: @json($defaultTestCases),
        useImage: {{ ($content->type === 'story' && $content->use_image) ? 'true' : 'false' }},
        useAudio: {{ ($content->type === 'story' && $content->use_audio) ? 'true' : 'false' }},
        useVideoStory: {{ ($content->type === 'story' && $content->use_video) ? 'true' : 'false' }},

        init() {
            this.testCases = this.testCases.map(tc => ({ ...tc, result: null, passed: false }));
            if (this.testCases.length === 0) this.testCases.push({ input: '', expected_output: '', result: null, passed: false });
        },

        addTestCase() { this.testCases.push({ input: '', expected_output: '', result: null, passed: false }); },
        removeTestCase(index) { if (this.testCases.length > 1) this.testCases.splice(index, 1); },

        async runTestCase(index) {
            if (this.isCompiling || !this.adminCode.trim()) return;
            this.isCompiling = true;
            const tc = this.testCases[index];
            tc.result = null;
            try {
                const response = await fetch('{{ route("admin.code.compile") }}', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'X-Requested-With': 'XMLHttpRequest' },
                    body: JSON.stringify({ code: this.adminCode, input: tc.input, language: this.selectedLanguage }),
                });
                const data = await response.json();
                if (data.success) {
                    const actual = (data.output || '').replace(/\r\n/g, '\n').trim();
                    const expected = tc.expected_output.replace(/\r\n/g, '\n').trim();
                    tc.passed = actual === expected;
                    tc.result = tc.passed ? '✓ PASS — Output: ' + data.output : '✗ FAIL — Got: "' + data.output + '" Expected: "' + tc.expected_output + '"';
                    if (!tc.expected_output && data.output) tc.expected_output = data.output;
                } else {
                    tc.passed = false;
                    tc.result = '✗ ERROR — ' + (data.errors || 'Compilation failed');
                }
            } catch (error) {
                tc.passed = false;
                tc.result = '✗ Network error: ' + error.message;
            } finally { this.isCompiling = false; }
        },

        async compileAdminCode() {
            if (this.isCompiling || !this.adminCode.trim()) return;
            this.isCompiling = true;
            this.compileResult = null;
            try {
                const response = await fetch('{{ route("admin.code.compile") }}', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'X-Requested-With': 'XMLHttpRequest' },
                    body: JSON.stringify({ code: this.adminCode, input: this.compileInput, language: this.selectedLanguage }),
                });
                const data = await response.json();
                if (data.success) {
                    this.compileResult = data.output || '(no output)';
                    this.compileError = false;
                    if (data.output) this.expectedOutput = data.output;
                } else {
                    this.compileResult = data.errors || 'Compilation failed';
                    this.compileError = true;
                }
            } catch (error) {
                this.compileResult = 'Network error: ' + error.message;
                this.compileError = true;
            } finally { this.isCompiling = false; }
        }
    };
}

function addOption() {
    const c = document.getElementById('options-container');
    const d = document.createElement('div');
    d.className = 'pixel-option';
    d.innerHTML = `<input type="text" name="options[]" class="pixel-input" required><button type="button" onclick="removeOption(this)" class="pixel-btn pixel-danger">✖</button>`;
    c.appendChild(d);
}

function removeOption(btn) {
    const c = document.getElementById('options-container');
    if (c.children.length > 2) btn.parentElement.remove();
}
</script>

@endsection

