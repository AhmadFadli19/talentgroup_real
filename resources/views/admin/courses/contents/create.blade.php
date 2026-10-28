@extends('layouts.app')

@section('title', 'Add Course Content')

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

<div class="pixel-editor" x-data="adminCoding()">

    <div class="pixel-header">
        <a href="{{ route('admin.courses.contents.index', $course) }}" class="pixel-back">◀</a>
        <div>
            <h1>ADD COURSE CONTENT</h1>
            <p>{{ $course->title }}</p>
        </div>
    </div>

    <div class="pixel-card">
        <form action="{{ route('admin.courses.contents.store', $course) }}" method="POST" id="contentForm" enctype="multipart/form-data">
            @csrf

            {{-- TITLE --}}
            <div class="pixel-group">
                <label class="pixel-label">CONTENT TITLE</label>
                <input type="text" name="title" value="{{ old('title') }}" :required="contentType !== 'question'" class="pixel-input @error('title') border-red-500 @enderror">
                @error('title') <div class="pixel-error">{{ $message }}</div> @enderror
                <div class="pixel-help" x-show="contentType === 'question'">Opsional untuk soal pilihan ganda. Jika kosong, judul otomatis diambil dari teks soal.</div>
            </div>

            {{-- TYPE --}}
            <div class="pixel-group">
                <label class="pixel-label">CONTENT TYPE</label>
                <select id="type" name="type" x-model="contentType" required class="pixel-select">
                    <option value="">-- SELECT TYPE --</option>
                    <option value="story" {{ old('type') === 'story' ? 'selected' : '' }}>[STORY] Reading / Artikel</option>
                    <option value="video" {{ old('type') === 'video' ? 'selected' : '' }}>[VIDEO] YouTube / Google Drive</option>
                    <option value="question" {{ old('type') === 'question' ? 'selected' : '' }}>[QUESTION] Kuis Pilihan Ganda</option>
                    <option value="coding" {{ old('type') === 'coding' ? 'selected' : '' }}>[CODING] Interactive Code Lab</option>
                    <option value="html" {{ old('type') === 'html' ? 'selected' : '' }}>[HTML] Live Preview Render</option>
                </select>
                <div class="pixel-help">Story = reading • Video = YT/Drive Embed • Question = MC • Coding = Golang • HTML = live preview layout</div>
            </div>

            {{-- CONTENT --}}
            <div class="pixel-group">
                <label class="pixel-label">CONTENT TEXT / SOAL DESCRIPTION</label>
                <textarea name="content" required class="pixel-textarea">{{ old('content') }}</textarea>
                <div class="pixel-help" x-show="contentType === 'coding'">Tulis deskripsi soal coding, cerita, dan instruksi untuk user</div>
                <div class="pixel-help" x-show="contentType === 'video'">Tulis deskripsi atau catatan tambahan mengenai video pelajaran ini</div>
            </div>

            {{-- ORDER --}}
            <div class="pixel-group">
                <label class="pixel-label">ORDER</label>
                <input type="number" name="order" min="1" value="{{ old('order', $nextOrder ?? 1) }}" class="pixel-input">
                <div class="pixel-help">Terisi otomatis dengan urutan terakhir. Kosongkan untuk tetap memakai urutan otomatis.</div>
            </div>

            {{-- DIFFICULTY LEVEL --}}
            <div class="pixel-group" x-show="contentType === 'question' || contentType === 'coding'" x-cloak>
                <label class="pixel-label">LEVEL KESULITAN</label>
                <select name="difficulty" class="pixel-select">
                    @foreach(\App\Models\CourseQuestion::DIFFICULTIES as $value => $label)
                        <option value="{{ $value }}" {{ old('difficulty', 'beginner') === $value ? 'selected' : '' }}>{{ strtoupper($label) }}</option>
                    @endforeach
                </select>
                <div class="pixel-help">Gunakan Dasar, Menengah, dan Lanjutan agar siswa belajar secara bertahap.</div>
                @error('difficulty') <div class="pixel-error">{{ $message }}</div> @enderror
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
                        <label class="pixel-label">UPLOAD GAMBAR STORY</label>
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
                        <label class="pixel-label">UPLOAD AUDIO STORY</label>
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
                        <input type="url" name="video_url_story" class="pixel-input" placeholder="https://www.youtube.com/watch?v=... atau https://drive.google.com/file/d/.../view">
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
                    <textarea name="html_code" class="pixel-textarea pixel-code-textarea" style="min-height: 150px;" placeholder="Tulis kode HTML di sini...">{{ old('html_code', '<h1>Halo Dunia!</h1>') }}</textarea>
                </div>

                {{-- CSS Code --}}
                <div class="pixel-group mt-4">
                    <label class="pixel-label">CSS CODE</label>
                    <textarea name="css_code" class="pixel-textarea pixel-code-textarea" style="min-height: 150px;" placeholder="Tulis kode CSS di sini...">{{ old('css_code', 'h1 { color: #0056d2; text-align: center; font-family: sans-serif; }') }}</textarea>
                </div>

                {{-- JS Code --}}
                <div class="pixel-group mt-4">
                    <label class="pixel-label">JAVASCRIPT CODE</label>
                    <textarea name="js_code" class="pixel-textarea pixel-code-textarea" style="min-height: 150px;" placeholder="Tulis kode JavaScript di sini...">{{ old('js_code', '// console.log("Hello from HTML preview");') }}</textarea>
                </div>
            </div>

            {{-- VIDEO FIELDS --}}
            <div x-show="contentType === 'video'" class="pixel-question" style="border-color: #ec4899; background: rgba(236, 72, 153, 0.03);">
                <strong style="font-size:10px; color: #ec4899;">📹 VIDEO SETTINGS</strong>
                <div class="pixel-group mt-4">
                    <label class="pixel-label">VIDEO URL</label>
                    <input type="url" name="video_url" value="{{ old('video_url') }}" class="pixel-input" placeholder="https://www.youtube.com/watch?v=... atau https://drive.google.com/file/d/.../view">
                    <div class="pixel-help">Mendukung link YouTube standard/share dan link Google Drive shareable file.</div>
                </div>
            </div>

            {{-- QUESTION FIELDS (Multiple Choice) --}}
            <div x-show="contentType === 'question'" class="pixel-question" style="border-color: #f59e0b; background: rgba(245, 158, 11, 0.03);">
                <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 2px dashed var(--border); padding-bottom: 10px; margin-bottom: 14px;">
                    <div>
                        <strong style="font-size:11px; color: #f59e0b; display: inline-flex; align-items: center; gap: 6px;">
                            <i class="fas fa-list-ul"></i> PILIHAN JAWABAN (A, B, C, D, E...)
                        </strong>
                        <div class="pixel-help" style="margin-top: 3px;">
                            Huruf <strong>A, B, C, D, E</strong> otomatis terpasang. Anda cukup ketik teks jawabannya saja (contoh: <code>golang</code>).
                        </div>
                    </div>
                    <button type="button" @click="addMcOption()" class="pixel-btn" style="border-color: #f59e0b; color: #f59e0b; display: inline-flex; align-items: center; gap: 4px;">
                        ➕ TAMBAH PILIHAN (<span x-text="getLetter(mcOptions.length)"></span>)
                    </button>
                </div>

                <!-- DAFTAR BARIS PILIHAN GANDA -->
                <div style="display: flex; flex-direction: column; gap: 10px;">
                    <template x-for="(opt, idx) in mcOptions" :key="idx">
                        <div class="pixel-option" style="display: flex; align-items: center; gap: 8px; margin-bottom: 0; padding: 6px 8px; border: 2px solid var(--border); background: var(--bg);"
                             :style="correctOptionIndex === idx ? 'border-color: #22c55e; background: rgba(34, 197, 94, 0.05);' : ''">
                            
                            <!-- BADGE HURUF OTOMATIS (A, B, C, D, E) -->
                            <div style="width: 38px; height: 38px; display: flex; align-items: center; justify-content: center; font-weight: 900; font-size: 13px; border: 2px solid var(--border); background: var(--surface2); flex-shrink: 0;"
                                 :style="correctOptionIndex === idx ? 'border-color: #22c55e; background: #22c55e; color: #000;' : 'color: var(--text);'">
                                <span x-text="getLetter(idx) + '.'"></span>
                            </div>

                            <!-- INPUT TEKS PILIHAN -->
                            <div style="flex: 1;">
                                <input type="text" 
                                       name="options[]" 
                                       x-model="mcOptions[idx]" 
                                       class="pixel-input" 
                                       :placeholder="'Ketik jawaban untuk pilihan ' + getLetter(idx) + ' (contoh: golang)'" 
                                       required 
                                       style="padding: 9px; font-weight: bold; width: 100%;">
                            </div>

                            <!-- TOMBOL / RADIO PILIH SEBAGAI JAWABAN BENAR -->
                            <button type="button" 
                                    @click="setCorrectOption(idx)" 
                                    class="pixel-btn" 
                                    style="padding: 8px 12px; font-weight: bold; display: flex; align-items: center; gap: 6px; flex-shrink: 0;"
                                    :style="correctOptionIndex === idx ? 'background: #22c55e; color: #000; border-color: #22c55e; box-shadow: 0 0 8px rgba(34,197,94,0.4);' : 'background: var(--bg); color: var(--text2);'">
                                <i :class="correctOptionIndex === idx ? 'fas fa-check-circle' : 'far fa-circle'"></i>
                                <span x-text="correctOptionIndex === idx ? 'KUNCI BENAR' : 'SET BENAR'"></span>
                            </button>

                            <!-- TOMBOL HAPUS PILIHAN -->
                            <button type="button" 
                                    @click="removeMcOption(idx)" 
                                    class="pixel-btn pixel-danger" 
                                    style="padding: 8px 10px; flex-shrink: 0;" 
                                    title="Hapus baris pilihan ini">
                                ✖
                            </button>
                        </div>
                    </template>
                </div>

                <!-- PREVIEW KUNCI JAWABAN YANG TERPILIH -->
                <div class="pixel-group mt-4" style="padding: 12px; border: 2px solid #22c55e; background: rgba(34, 197, 94, 0.08);">
                    <div style="display: flex; align-items: center; justify-content: space-between; gap: 8px;">
                        <div>
                            <span class="pixel-label" style="color: #22c55e; font-weight: 900; margin-bottom: 2px; font-size: 10px;">
                                <i class="fas fa-key"></i> KUNCI JAWABAN BENAR (TERSIMPAN OTOMATIS)
                            </span>
                            <div style="font-size: 13px; font-weight: 800; color: var(--text);">
                                <span style="background: #22c55e; color: #000; padding: 2px 8px; border-radius: 4px; margin-right: 6px;" x-text="getLetter(correctOptionIndex)"></span>
                                <span x-text="currentCorrectAnswer || '(Pilihan ' + getLetter(correctOptionIndex) + ' masih kosong, silakan ketik teksnya)'" style="color: #22c55e;"></span>
                            </div>
                        </div>
                        <span class="pixel-help" style="color: var(--muted); text-align: right; max-width: 250px;">
                            Sistem akan mencocokkan teks jawaban di atas secara langsung.
                        </span>
                    </div>

                    <!-- Hidden input correct_answer yang dikirim ke server -->
                    <input type="hidden" name="correct_answer" :value="currentCorrectAnswer" required>
                </div>
            </div>

            {{-- CODING FIELDS --}}
            <div x-show="contentType === 'coding'" class="pixel-coding">
                <strong style="font-size:11px; color: #22c55e; display: inline-flex; align-items: center; gap: 6px;"><i class="fas fa-terminal"></i> CODING CHALLENGE SETTINGS</strong>

                {{-- Language Selector --}}
                <div class="pixel-group mt-4">
                    <label class="pixel-label">PROGRAMMING LANGUAGE</label>
                    <div class="pixel-help mb-2">Pilih bahasa pemrograman untuk soal ini</div>
                    <select name="language" x-model="selectedLanguage" class="pixel-select">
                        @foreach(\App\Services\CodeExecutionService::availableLanguages() as $langKey => $langLabel)
                            <option value="{{ $langKey }}" {{ old('language', 'go') === $langKey ? 'selected' : '' }}>{{ $langLabel }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Coding Rules (Dynamic per language) --}}
                <div class="pixel-group mt-4">
                    <label class="pixel-label">CODING RULES (Aturan yang harus diikuti user)</label>
                    <div class="pixel-help mb-2">Pilih construct yang WAJIB digunakan user dalam kodenya (berubah sesuai bahasa)</div>
                    <div class="rules-grid">
                        <template x-for="[ruleKey, ruleLabel] in Object.entries(currentRules)" :key="ruleKey">
                            <label class="rule-checkbox" :class="selectedRules.includes(ruleKey) ? 'checked' : ''">
                                <input type="checkbox" name="coding_rules[]" :value="ruleKey"
                                       x-model="selectedRules">
                                <span x-text="ruleLabel"></span>
                            </label>
                        </template>
                    </div>
                </div>

                {{-- Admin Code --}}
                <div class="pixel-group mt-4">
                    <label class="pixel-label">ADMIN CODE (Kode solusi referensi)</label>
                    <div class="pixel-help mb-2">Tulis kode lengkap sebagai solusi referensi. Kode ini akan dijalankan untuk menentukan expected output.</div>
                    <textarea name="admin_code" x-model="adminCode" class="pixel-textarea pixel-code-textarea" :placeholder="starterTemplates[selectedLanguage] || '// Kode solusi admin'">{{ old('admin_code') }}</textarea>
                </div>

                {{-- Compile Admin Code Button --}}
                <div class="compile-section">
                    <label class="pixel-label">TEST ADMIN CODE</label>
                    <div class="pixel-help mb-2">Klik tombol di bawah untuk menjalankan kode admin dan mengisi Expected Output otomatis</div>

                    {{-- Input for compile test --}}
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
                    <div class="pixel-help mb-2">Output yang harus dihasilkan kode user (otomatis terisi dari compile admin code, atau isi manual)</div>
                    <textarea name="expected_output" x-model="expectedOutput" class="pixel-textarea pixel-code-textarea" style="min-height: 100px;" placeholder="Output yang diharapkan...">{{ old('expected_output') }}</textarea>
                </div>

                {{-- Test Cases --}}
                <div class="pixel-group mt-4">
                    <label class="pixel-label" style="color: var(--yellow);">📋 TEST CASES (Input → Output)</label>
                    <div class="pixel-help mb-2">Tentukan test case: input apa yang diberikan dan output apa yang diharapkan. Admin bisa test setiap case.</div>

                    <template x-for="(testCase, index) in testCases" :key="index">
                        <div style="border: 2px dashed var(--border); padding: 12px; margin-bottom: 10px; position: relative;">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                                <strong style="font-size: 9px; color: var(--accent);">Test Case <span x-text="index + 1"></span></strong>
                                <div style="display: flex; gap: 6px;">
                                    <button type="button" @click="runTestCase(index)" class="pixel-btn" style="font-size: 7px; padding: 3px 8px; background: rgba(34, 197, 94, 0.1); border-color: #22c55e; color: #22c55e;" :disabled="isCompiling">
                                        ▶ Test
                                    </button>
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
                    <div class="pixel-help mb-2">Kode awal yang akan ditampilkan ke user. Boleh kosong — jika kosong akan diisi template default.</div>
                    <textarea name="starter_code" x-model="starterCode" class="pixel-textarea pixel-code-textarea" style="min-height: 120px;" :placeholder="starterTemplates[selectedLanguage] || '// Tulis kode kamu di sini'">{{ old('starter_code') }}</textarea>
                </div>

                {{-- Hint --}}
                <div class="pixel-group mt-4">
                    <label class="pixel-label">HINT (Opsional)</label>
                    <textarea name="hint" class="pixel-textarea" style="min-height: 60px;" placeholder="Petunjuk untuk membantu user...">{{ old('hint') }}</textarea>
                </div>
            </div>

            {{-- ACTIONS --}}
            <div class="pixel-actions">
                <a href="{{ route('admin.courses.contents.index', $course) }}" class="pixel-btn">CANCEL</a>
                <button type="submit" class="pixel-btn" style="background:#4f46e5;color:#fff;border-color:#4f46e5">ADD CONTENT</button>
                <button type="submit" name="action" value="save_and_new" x-show="contentType === 'question'" class="pixel-btn" style="background:#f59e0b;color:#000;border-color:#f59e0b">SIMPAN & TAMBAH LAGI</button>
            </div>
        </form>
    </div>
</div>

@php
    $defaultTestCases = old('test_cases', [['input' => '', 'expected_output' => '', 'result' => null, 'passed' => false]]);
@endphp
<script>
function adminCoding() {
    const allRules = @json(collect(\App\Services\CodeExecutionService::availableLanguages())->mapWithKeys(fn($label, $key) => [$key => \App\Services\CodeExecutionService::codingRulesForLanguage($key)])->toArray());
    const starterTemplates = @json(collect(\App\Services\CodeExecutionService::availableLanguages())->mapWithKeys(fn($label, $key) => [$key => \App\Services\CodeExecutionService::starterCodeForLanguage($key)])->toArray());

    return {
        contentType: '{{ old('type', '') }}',
        selectedRules: @json(old('coding_rules', [])),
        selectedLanguage: '{{ old('language', 'go') }}',
        adminCode: '',
        expectedOutput: '{{ old('expected_output', '') }}',
        compileInput: '',
        starterCode: '',
        isCompiling: false,
        compileResult: null,
        compileError: false,
        testCases: @json($defaultTestCases),
        allRules: allRules,
        starterTemplates: starterTemplates,
        useImage: {{ old('use_image') ? 'true' : 'false' }},
        useAudio: {{ old('use_audio') ? 'true' : 'false' }},
        useVideoStory: {{ old('use_video_story') ? 'true' : 'false' }},

        // Multiple choice state (A, B, C, D, E...)
        mcOptions: {!! json_encode(old('options', ['Golang', 'Python', 'Java', 'PHP'])) !!},
        correctOptionIndex: 0,
        letters: ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J'],

        getLetter(index) {
            return this.letters[index] || String.fromCharCode(65 + index);
        },

        get currentCorrectAnswer() {
            return (this.mcOptions && this.mcOptions[this.correctOptionIndex]) ? this.mcOptions[this.correctOptionIndex] : '';
        },

        addMcOption() {
            if (this.mcOptions.length < 10) {
                this.mcOptions.push('');
            }
        },

        removeMcOption(index) {
            if (this.mcOptions.length <= 2) {
                alert('Minimal harus ada 2 pilihan jawaban.');
                return;
            }
            this.mcOptions.splice(index, 1);
            if (this.correctOptionIndex >= this.mcOptions.length) {
                this.correctOptionIndex = this.mcOptions.length - 1;
            }
        },

        setCorrectOption(index) {
            this.correctOptionIndex = index;
        },

        get currentRules() {
            return this.allRules[this.selectedLanguage] || this.allRules['go'];
        },

        init() {
            // Inisialisasi multiple choice options
            if (!Array.isArray(this.mcOptions) || this.mcOptions.length < 2) {
                this.mcOptions = ['Golang', 'Python', 'Java', 'PHP'];
            }
            const initialCorrect = '{{ addslashes(old('correct_answer', '')) }}';
            if (initialCorrect) {
                const foundIdx = this.mcOptions.findIndex(opt => opt && opt.trim() === initialCorrect.trim());
                if (foundIdx !== -1) {
                    this.correctOptionIndex = foundIdx;
                }
            }

            // Ensure testCases have result/passed fields
            this.testCases = this.testCases.map(tc => ({
                ...tc,
                result: tc.result ?? null,
                passed: tc.passed ?? false,
            }));

            // Watch language change to update starter code placeholder
            this.$watch('selectedLanguage', (lang) => {
                // Clear selected rules when language changes (different rules per lang)
                this.selectedRules = [];
            });
        },

        addTestCase() {
            this.testCases.push({ input: '', expected_output: '', result: null, passed: false });
        },

        removeTestCase(index) {
            if (this.testCases.length > 1) {
                this.testCases.splice(index, 1);
            }
        },

        async runTestCase(index) {
            if (this.isCompiling || !this.adminCode.trim()) return;
            this.isCompiling = true;
            const tc = this.testCases[index];
            tc.result = null;

            try {
                const response = await fetch('{{ route("admin.code.compile") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    body: JSON.stringify({ code: this.adminCode, input: tc.input, language: this.selectedLanguage }),
                });

                const data = await response.json();

                if (data.success) {
                    const actualOutput = data.output || '';
                    const expectedNorm = tc.expected_output.replace(/\r\n/g, '\n').trim();
                    const actualNorm = actualOutput.replace(/\r\n/g, '\n').trim();
                    tc.passed = actualNorm === expectedNorm;
                    tc.result = tc.passed
                        ? '✓ PASS — Output: ' + actualOutput
                        : '✗ FAIL — Got: "' + actualOutput + '" Expected: "' + tc.expected_output + '"';

                    // Auto-fill expected_output if empty
                    if (!tc.expected_output && data.output) {
                        tc.expected_output = data.output;
                    }
                } else {
                    tc.passed = false;
                    tc.result = '✗ ERROR — ' + (data.errors || 'Compilation failed');
                }
            } catch (error) {
                tc.passed = false;
                tc.result = '✗ Network error: ' + error.message;
            } finally {
                this.isCompiling = false;
            }
        },

        async compileAdminCode() {
            if (this.isCompiling || !this.adminCode.trim()) return;
            this.isCompiling = true;
            this.compileResult = null;

            try {
                const response = await fetch('{{ route("admin.code.compile") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    body: JSON.stringify({ code: this.adminCode, input: this.compileInput, language: this.selectedLanguage }),
                });

                const data = await response.json();

                if (data.success) {
                    this.compileResult = data.output || '(no output)';
                    this.compileError = false;
                    if (data.output) {
                        this.expectedOutput = data.output;
                    }
                } else {
                    this.compileResult = data.errors || 'Compilation failed';
                    this.compileError = true;
                }
            } catch (error) {
                this.compileResult = 'Network error: ' + error.message;
                this.compileError = true;
            } finally {
                this.isCompiling = false;
            }
        }
    };
}
</script>

@endsection
