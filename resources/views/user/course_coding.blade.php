@extends('layouts.app')

@section('title', 'Coding Challenge: ' . $content->title)

@section('content')

@php
    $allContents = $course->allContents();
    $currentIndex = $allContents->search(function ($item) use ($content) {
        return $item->type === $content->type && $item->id === $content->id;
    });
    $progress = $allContents->count() > 0 ? round((($currentIndex + 1) / $allContents->count()) * 100) : 0;
    $hasTestCases = !empty($content->test_cases) && count($content->test_cases) > 0;
@endphp

<style>
    .main-content {
        padding: 0 !important;
    }
</style>

<div id="coding-root" x-data="codingChallenge()" class="flex flex-col h-[calc(100vh-64px)] overflow-hidden bg-[#05070a]">

    {{-- Full Screen Loading Overlay --}}
    <div x-show="isRunning || isTesting || isChecking || isSubmitting" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center bg-black/80 backdrop-blur-sm">
        <div class="cyber-card flex flex-col items-center justify-center p-8 max-w-sm text-center" style="border-color: var(--accent);">
            <div class="w-16 h-16 border-4 rounded-full border-t-[var(--accent)] border-r-[var(--accent)] border-b-transparent border-l-transparent animate-spin mb-6"></div>
            <h3 class="text-lg font-bold mb-2 uppercase tracking-widest" style="color: var(--accent);">Processing Code...</h3>
            <p class="text-xs font-mono" style="color: var(--text2);">Please wait while the server compiles and executes your instructions.</p>
        </div>
    </div>

    {{-- Top Bar --}}
    <div class="flex-shrink-0 flex items-center justify-between px-6 py-4 border-b relative" style="background: rgba(0,0,0,0.5); border-color: var(--accent);">
        <div class="absolute inset-0 opacity-10" style="background: repeating-linear-gradient(45deg, transparent, transparent 10px, var(--accent) 10px, var(--accent) 20px);"></div>
        <div class="flex items-center gap-4 relative z-10">
            <a href="{{ route('user.courses.learn', $course->id) }}" class="cyber-btn flex items-center justify-center w-10 h-10 p-0" style="border-color: var(--accent); color: var(--accent);">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h1 class="text-lg font-bold" style="color: var(--text); font-family: 'Outfit', sans-serif;">{{ $content->title }}</h1>
                <p class="text-[10px] uppercase tracking-widest font-mono" style="color: var(--text3);">{{ $course->title }} — Node {{ $currentIndex + 1 }} / {{ $allContents->count() }}</p>
            </div>
        </div>
        <div class="flex items-center gap-4 relative z-10 w-48">
            <div class="flex-1 h-2 rounded overflow-hidden" style="background: var(--bg);">
                <div class="h-full relative" style="width: {{ $progress }}%; background: var(--accent); box-shadow: 0 0 10px var(--accent);">
                    <div class="absolute inset-0 opacity-30" style="background: repeating-linear-gradient(45deg, transparent, transparent 5px, #fff 5px, #fff 10px);"></div>
                </div>
            </div>
            <span class="text-[10px] font-bold font-mono" style="color: var(--accent);">{{ $progress }}%</span>
        </div>
    </div>

    {{-- Main IDE Layout --}}
    <div class="flex flex-1 min-h-0 relative">

        {{-- Left Panel: Problem Description --}}
        <div class="flex flex-col border-r transition-all duration-300" :class="problemCollapsed ? 'w-12 min-w-12' : 'w-96 min-w-96'" style="background: rgba(0,0,0,0.3); border-color: var(--border);">
            <div class="flex-shrink-0 flex items-center justify-between px-4 py-3 border-b" style="border-color: var(--border); background: rgba(0,0,0,0.5);">
                <span x-show="!problemCollapsed" class="text-[10px] font-bold uppercase tracking-widest flex items-center gap-2" style="color: var(--text);">
                    <i class="fas fa-book-open" style="color: var(--accent);"></i> Problem Spec
                </span>
                <button @click="problemCollapsed = !problemCollapsed" class="text-xs transition-colors hover:text-[var(--accent)] mx-auto" style="color: var(--text3);">
                    <i :class="problemCollapsed ? 'fas fa-chevron-right' : 'fas fa-chevron-left'"></i>
                </button>
            </div>
            <div class="flex-1 overflow-y-auto custom-scrollbar p-5 flex flex-col gap-6" x-show="!problemCollapsed">
                {{-- Problem Description --}}
                <div class="text-[11px] leading-relaxed font-mono" style="color: var(--text2);">
                    {!! nl2br(e($content->content)) !!}
                </div>

                {{-- Hint --}}
                @if($content->hint)
                <div x-data="{ showHint: false }" class="border rounded" style="border-color: var(--yellow)40; background: rgba(245,158,11,0.05);">
                    <button @click="showHint = !showHint" class="w-full flex items-center gap-2 px-4 py-3 text-[10px] uppercase tracking-widest font-bold transition-colors" style="color: var(--yellow);">
                        <i class="fas fa-lightbulb"></i>
                        <span x-text="showHint ? 'Hide Intelligence' : 'Request Intelligence'"></span>
                    </button>
                    <div x-show="showHint" x-transition class="p-4 border-t text-[11px] font-mono leading-relaxed" style="border-color: var(--yellow)20; color: var(--yellow);">
                        {{ $content->hint }}
                    </div>
                </div>
                @endif

                {{-- Expected Output --}}
                <div>
                    <h4 class="text-[10px] font-bold uppercase tracking-widest mb-3 flex items-center gap-2" style="color: var(--cyan);">
                        <i class="fas fa-bullseye"></i> Expected Output Signature
                    </h4>
                    <pre class="p-4 rounded border text-[10px] font-mono whitespace-pre-wrap break-all" style="background: rgba(0,0,0,0.5); border-color: var(--cyan)40; color: var(--cyan);">{{ $content->expected_output }}</pre>
                </div>

                {{-- Test Cases --}}
                @if($hasTestCases)
                <div>
                    <h4 class="text-[10px] font-bold uppercase tracking-widest mb-3 flex items-center gap-2" style="color: var(--yellow);">
                        <i class="fas fa-flask"></i> Evaluation Matrices
                    </h4>
                    <div class="flex flex-col gap-3">
                        @foreach($content->test_cases as $i => $tc)
                            <div class="p-3 rounded border transition-colors" 
                                 :class="testCaseResults[{{ $i }}] === true ? 'bg-green-500/10 border-green-500/50' : (testCaseResults[{{ $i }}] === false ? 'bg-red-500/10 border-red-500/50' : 'bg-black/20 border-[var(--border)]')">
                                <div class="flex justify-between items-center mb-2">
                                    <span class="text-[10px] font-bold uppercase tracking-widest" style="color: var(--yellow);">Test {{ $i + 1 }}</span>
                                    <span class="text-[10px]">
                                        <template x-if="testCaseResults[{{ $i }}] === true"><i class="fas fa-check-circle" style="color: var(--green);"></i></template>
                                        <template x-if="testCaseResults[{{ $i }}] === false"><i class="fas fa-times-circle" style="color: #ff4d4d;"></i></template>
                                        <template x-if="testCaseResults[{{ $i }}] === null"><i class="fas fa-circle" style="color: var(--text3);"></i></template>
                                    </span>
                                </div>
                                <div class="grid grid-cols-2 gap-3">
                                    <div>
                                        <span class="block text-[8px] uppercase tracking-widest mb-1" style="color: var(--text3);">Input:</span>
                                        <pre class="p-2 rounded border text-[9px] font-mono whitespace-pre-wrap min-h-[30px]" style="background: rgba(0,0,0,0.3); border-color: var(--border); color: var(--text);">{{ $tc['input'] }}</pre>
                                    </div>
                                    <div>
                                        <span class="block text-[8px] uppercase tracking-widest mb-1" style="color: var(--text3);">Expected:</span>
                                        <pre class="p-2 rounded border text-[9px] font-mono whitespace-pre-wrap min-h-[30px]" style="background: rgba(0,0,0,0.3); border-color: var(--border); color: var(--green);">{{ $tc['expected_output'] }}</pre>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- Coding Rules --}}
                <div>
                    <h4 class="text-[10px] font-bold uppercase tracking-widest mb-3 flex items-center gap-2" style="color: var(--text);">
                        <i class="fas fa-shield-alt" style="color: var(--accent);"></i> Syntax Constraints
                    </h4>
                    <div class="flex flex-col gap-2">
                        @foreach($content->coding_rules ?? [] as $rule)
                            <div class="flex items-center gap-3 p-3 rounded border text-[9px] font-mono transition-colors" 
                                 :class="rulesStatus['{{ $rule }}'] ? 'bg-green-500/10 border-green-500/50 text-[var(--green)]' : 'bg-red-500/10 border-red-500/50 text-[#ff4d4d]'">
                                <i :class="rulesStatus['{{ $rule }}'] ? 'fas fa-check-circle' : 'fas fa-times-circle'"></i>
                                <span>{{ $codingRules[$rule] ?? $rule }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Status Summary --}}
                <div class="flex gap-2 pt-4 mt-auto border-t" style="border-color: var(--border);">
                    <div class="flex-1 flex flex-col items-center justify-center gap-1 p-2 border rounded" :class="allRulesPassed ? 'border-green-500/50 bg-green-500/10 text-[var(--green)]' : 'border-red-500/50 bg-red-500/10 text-[#ff4d4d]'">
                        <i :class="allRulesPassed ? 'fas fa-check text-[10px]' : 'fas fa-times text-[10px]'"></i>
                        <span class="text-[8px] uppercase tracking-widest font-bold">Rules</span>
                    </div>
                    <div class="flex-1 flex flex-col items-center justify-center gap-1 p-2 border rounded" :class="outputMatches ? 'border-green-500/50 bg-green-500/10 text-[var(--green)]' : 'border-red-500/50 bg-red-500/10 text-[#ff4d4d]'">
                        <i :class="outputMatches ? 'fas fa-check text-[10px]' : 'fas fa-times text-[10px]'"></i>
                        <span class="text-[8px] uppercase tracking-widest font-bold">Output</span>
                    </div>
                    @if($hasTestCases)
                    <div class="flex-1 flex flex-col items-center justify-center gap-1 p-2 border rounded" :class="allTestsPassed ? 'border-green-500/50 bg-green-500/10 text-[var(--green)]' : 'border-red-500/50 bg-red-500/10 text-[#ff4d4d]'">
                        <i :class="allTestsPassed ? 'fas fa-check text-[10px]' : 'fas fa-times text-[10px]'"></i>
                        <span class="text-[8px] uppercase tracking-widest font-bold">Tests</span>
                    </div>
                    @endif
                    <div class="flex-1 flex flex-col items-center justify-center gap-1 p-2 border rounded" :class="canSubmit ? 'border-green-500/50 bg-green-500/10 text-[var(--green)] shadow-[0_0_10px_rgba(0,255,136,0.2)]' : 'border-red-500/50 bg-red-500/10 text-[#ff4d4d]'">
                        <i :class="canSubmit ? 'fas fa-check-double text-[10px]' : 'fas fa-times text-[10px]'"></i>
                        <span class="text-[8px] uppercase tracking-widest font-bold">Ready</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right Panel: Editor + Terminal --}}
        <div class="flex-1 flex flex-col min-w-0">
            {{-- Editor --}}
            <div class="flex flex-col relative" :style="'height:' + editorHeight + '%'">
                <div class="flex-shrink-0 flex items-center justify-between px-4 py-2 border-b flex-wrap gap-3" style="background: rgba(0,0,0,0.5); border-color: var(--border);">
                    <div class="flex items-center">
                        <span class="text-[10px] uppercase tracking-widest font-bold px-3 py-1 border-b-2" style="border-color: var(--accent); color: var(--accent);">
                            <i class="fas fa-code mr-1"></i> {{ $content->language ?? 'go' }}
                        </span>
                    </div>
                    <div class="flex gap-2 flex-wrap">
                        <button @click="validateRulesNow()" class="cyber-btn text-[9px] px-3 py-1" style="border-color: var(--cyan); color: var(--cyan);" :disabled="isValidating">
                            <i :class="isValidating ? 'fas fa-spinner fa-spin' : 'fas fa-clipboard-check'"></i>
                            <span class="ml-1 hidden sm:inline">Check Syntax</span>
                        </button>
                        <button @click="runCode()" class="cyber-btn text-[9px] px-3 py-1" style="border-color: var(--green); color: var(--green);" :disabled="isRunning">
                            <i :class="isRunning ? 'fas fa-spinner fa-spin' : 'fas fa-play'"></i>
                            <span class="ml-1 hidden sm:inline" x-text="isRunning ? 'Compiling...' : 'Run Output'"></span>
                        </button>
                        @if($hasTestCases)
                        <button @click="runAllTests()" class="cyber-btn text-[9px] px-3 py-1" style="border-color: var(--yellow); color: var(--yellow);" :disabled="isTesting">
                            <i :class="isTesting ? 'fas fa-spinner fa-spin' : 'fas fa-flask'"></i>
                            <span class="ml-1 hidden sm:inline" x-text="isTesting ? 'Testing...' : 'Run Tests'"></span>
                        </button>
                        @endif
                        <button @click="checkAll()" class="btn-primary text-[9px] px-3 py-1" :disabled="isChecking">
                            <i :class="isChecking ? 'fas fa-spinner fa-spin' : 'fas fa-check-double'"></i>
                            <span class="ml-1 hidden sm:inline" x-text="isChecking ? 'Verifying...' : 'Full Verification'"></span>
                        </button>
                    </div>
                </div>
                <div class="flex-1 relative">
                    <textarea id="codeEditor" x-ref="codeEditor">{{ $userAnswer ? $userAnswer->code_submitted : ($content->starter_code ?? "package main\n\nimport \"fmt\"\n\nfunc main() {\n\t// Tulis kode kamu di sini\n\tfmt.Println(\"Hello, World!\")\n}") }}</textarea>
                </div>
            </div>

            {{-- Resize Handle --}}
            <div class="h-2 flex items-center justify-center cursor-row-resize flex-shrink-0 transition-colors hover:bg-[var(--accent)]/20 border-y" style="background: rgba(0,0,0,0.8); border-color: var(--border);" @mousedown="startResize($event)">
                <div class="text-[10px] tracking-[3px]" style="color: var(--text3);">⋯</div>
            </div>

            {{-- Terminal --}}
            <div class="flex flex-col flex-1" :style="'height:' + (100 - editorHeight) + '%'">
                <div class="flex-shrink-0 flex items-center justify-between px-2 bg-black border-b" style="border-color: var(--border);">
                    <div class="flex gap-1 overflow-x-auto custom-scrollbar">
                        <button @click="terminalTab = 'output'" class="px-4 py-2 text-[10px] font-bold uppercase tracking-widest border-b-2 transition-colors flex items-center gap-2" :class="terminalTab === 'output' ? 'text-[var(--text)] border-[var(--accent)] bg-white/5' : 'text-[var(--text3)] border-transparent hover:text-[var(--text)]'">
                            <i class="fas fa-terminal" style="color: var(--accent);"></i> Output Log
                        </button>
                        <button @click="terminalTab = 'input'" class="px-4 py-2 text-[10px] font-bold uppercase tracking-widest border-b-2 transition-colors flex items-center gap-2" :class="terminalTab === 'input' ? 'text-[var(--text)] border-[var(--accent)] bg-white/5' : 'text-[var(--text3)] border-transparent hover:text-[var(--text)]'">
                            <i class="fas fa-keyboard" style="color: var(--cyan);"></i> Input Stream
                        </button>
                        <button @click="terminalTab = 'errors'" class="px-4 py-2 text-[10px] font-bold uppercase tracking-widest border-b-2 transition-colors flex items-center gap-2" :class="terminalTab === 'errors' ? 'text-[var(--text)] border-[var(--accent)] bg-white/5' : 'text-[var(--text3)] border-transparent hover:text-[var(--text)]'">
                            <i class="fas fa-bug" style="color: #ff4d4d;"></i> Error Log
                            <span x-show="terminalErrors" class="px-1.5 py-0.5 rounded text-[8px] bg-red-500 text-white font-bold ml-1">!</span>
                        </button>
                        @if($hasTestCases)
                        <button @click="terminalTab = 'tests'" class="px-4 py-2 text-[10px] font-bold uppercase tracking-widest border-b-2 transition-colors flex items-center gap-2" :class="terminalTab === 'tests' ? 'text-[var(--text)] border-[var(--accent)] bg-white/5' : 'text-[var(--text3)] border-transparent hover:text-[var(--text)]'">
                            <i class="fas fa-flask" style="color: var(--yellow);"></i> Test Matrix
                            <span x-show="testResultsSummary" class="px-1.5 py-0.5 rounded text-[8px] font-bold ml-1" :class="allTestsPassed ? 'bg-green-500 text-black' : 'bg-red-500 text-white'" x-text="testResultsSummary"></span>
                        </button>
                        @endif
                    </div>
                    <button @click="clearTerminal()" class="text-[9px] uppercase tracking-widest px-3 py-1 border rounded transition-colors hover:bg-red-500/10 hover:border-red-500 hover:text-red-500" style="color: var(--text3); border-color: var(--border);">
                        <i class="fas fa-trash-alt"></i> Clear
                    </button>
                </div>
                <div class="flex-1 overflow-y-auto bg-[#0a0a0a] p-3 font-mono text-[11px] custom-scrollbar">
                    {{-- Output Tab --}}
                    <div x-show="terminalTab === 'output'" class="h-full">
                        <template x-for="(line, index) in terminalOutput" :key="index">
                            <div class="flex gap-2 py-0.5 hover:bg-white/5">
                                <span class="w-4 text-center flex-shrink-0" :class="line.type === 'system' ? 'text-[var(--accent)]' : (line.type === 'error' ? 'text-[#ff4d4d]' : 'text-[var(--text3)]')" x-text="line.type === 'system' ? '⚡' : (line.type === 'error' ? '✗' : '>')"></span>
                                <span class="whitespace-pre-wrap break-all" :class="line.type === 'error' ? 'text-[#ff4d4d]' : (line.type === 'system' ? 'text-[var(--cyan)]' : 'text-[var(--text)]')" x-text="line.text"></span>
                            </div>
                        </template>
                        <div x-show="terminalOutput.length === 0" class="h-full flex flex-col items-center justify-center gap-2" style="color: var(--text3);">
                            <i class="fas fa-terminal text-2xl"></i>
                            <span>Awaiting execution instructions...</span>
                        </div>
                    </div>

                    {{-- Input Tab --}}
                    <div x-show="terminalTab === 'input'" class="h-full flex flex-col gap-3 p-2">
                        <div>
                            <label class="text-[10px] uppercase tracking-widest font-bold flex items-center gap-2 mb-1" style="color: var(--cyan);">
                                <i class="fas fa-keyboard"></i> Program Input Stream (stdin)
                            </label>
                            <div class="text-[9px] mb-3" style="color: var(--text3);">Inject data for the program to consume. One input per line.</div>
                        </div>
                        <textarea x-model="userInput" class="flex-1 bg-black border p-3 font-mono text-xs rounded outline-none focus:border-[var(--accent)]" style="border-color: var(--border); color: var(--text);" placeholder="Enter stream sequence here...&#10;Example:&#10;5&#10;John&#10;Hello World"></textarea>
                        <button @click="runCodeWithInput()" class="cyber-btn w-full flex items-center justify-center gap-2 text-[10px]" style="border-color: var(--cyan); color: var(--cyan);" :disabled="isRunning">
                            <i :class="isRunning ? 'fas fa-spinner fa-spin' : 'fas fa-play'"></i>
                            <span x-text="isRunning ? 'Compiling...' : 'Execute with Input Stream'"></span>
                        </button>
                    </div>

                    {{-- Errors Tab --}}
                    <div x-show="terminalTab === 'errors'" class="h-full">
                        <template x-if="terminalErrors">
                            <div class="flex gap-2 p-3 bg-red-500/10 border border-red-500/50 rounded">
                                <span class="w-4 text-center flex-shrink-0 text-[#ff4d4d]">✗</span>
                                <pre class="whitespace-pre-wrap break-all text-[#ff4d4d]" x-text="terminalErrors"></pre>
                            </div>
                        </template>
                        <div x-show="!terminalErrors" class="h-full flex flex-col items-center justify-center gap-2" style="color: var(--green);">
                            <i class="fas fa-check-circle text-2xl"></i>
                            <span>No anomalies detected.</span>
                        </div>
                    </div>

                    {{-- Tests Tab --}}
                    @if($hasTestCases)
                    <div x-show="terminalTab === 'tests'" class="h-full flex flex-col gap-3 p-2">
                        <template x-for="(result, index) in testResultsDetail" :key="index">
                            <div class="border rounded p-3" :class="result.passed ? 'border-green-500/50 bg-green-500/5' : 'border-red-500/50 bg-red-500/5'">
                                <div class="flex justify-between items-center mb-3">
                                    <span class="text-[10px] uppercase tracking-widest font-bold flex items-center gap-2" :class="result.passed ? 'text-[var(--green)]' : 'text-[#ff4d4d]'">
                                        <i :class="result.passed ? 'fas fa-check-circle' : 'fas fa-times-circle'"></i>
                                        Test <span x-text="result.test_number"></span>
                                    </span>
                                    <span class="text-[8px] font-bold px-2 py-0.5 border" :class="result.passed ? 'border-green-500 text-[var(--green)]' : 'border-red-500 text-[#ff4d4d]'" x-text="result.passed ? 'PASS' : 'FAIL'"></span>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                                    <div>
                                        <span class="block text-[8px] uppercase tracking-widest mb-1" style="color: var(--text3);">Input Stream:</span>
                                        <pre class="bg-black/50 border p-2 text-[10px] min-h-[30px] whitespace-pre-wrap break-all" style="border-color: var(--border); color: var(--text);" x-text="result.input || '(none)'"></pre>
                                    </div>
                                    <div>
                                        <span class="block text-[8px] uppercase tracking-widest mb-1" style="color: var(--text3);">Expected Output:</span>
                                        <pre class="bg-black/50 border p-2 text-[10px] min-h-[30px] whitespace-pre-wrap break-all" style="border-color: var(--border); color: var(--green);" x-text="result.expected_output"></pre>
                                    </div>
                                    <div>
                                        <span class="block text-[8px] uppercase tracking-widest mb-1" style="color: var(--text3);">Actual Output:</span>
                                        <pre class="bg-black/50 border p-2 text-[10px] min-h-[30px] whitespace-pre-wrap break-all" style="border-color: var(--border);" :class="result.passed ? 'color: var(--text)' : 'text-[#ff4d4d]'" x-text="result.actual_output || '(no output)'"></pre>
                                    </div>
                                </div>
                                <div x-show="result.errors" class="mt-3 p-2 bg-red-500/10 border border-red-500/50">
                                    <pre class="text-[9px] text-[#ff4d4d] whitespace-pre-wrap break-all" x-text="result.errors"></pre>
                                </div>
                            </div>
                        </template>
                        <div x-show="testResultsDetail.length === 0" class="h-full flex flex-col items-center justify-center gap-2" style="color: var(--text3);">
                            <i class="fas fa-flask text-2xl"></i>
                            <span>Awaiting test execution instructions...</span>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Bottom Action Bar --}}
    <div class="flex-shrink-0 flex items-center justify-between px-6 py-3 border-t" style="background: rgba(0,0,0,0.5); border-color: var(--accent);">
        <div class="flex gap-2">
            @if($previousContent)
                <a href="{{ route('user.courses.content', [$course->id, $previousContent->type . ':' . $previousContent->id]) }}" class="cyber-btn flex items-center gap-2 px-3 py-1 text-[10px]" style="border-color: var(--text3); color: var(--text3);">
                    <i class="fas fa-chevron-left"></i> Prev Node
                </a>
            @endif
        </div>
        
        <div class="flex items-center gap-4">
            <div class="px-4 py-1.5 border rounded text-[10px] uppercase tracking-widest font-bold flex items-center gap-2 transition-colors" :class="canSubmit ? 'border-green-500/50 bg-green-500/10 text-[var(--green)]' : 'border-red-500/50 bg-red-500/10 text-[#ff4d4d]'">
                <i :class="canSubmit ? 'fas fa-check' : 'fas fa-times'"></i>
                <span x-text="canSubmit ? 'Ready for Transmission' : 'Requirements Unmet'"></span>
            </div>
        </div>
        
        <div class="flex gap-2">
            <form id="submitForm" method="POST" action="{{ route('user.courses.answer', [$course->id, $content->type . ':' . $content->id]) }}" class="m-0">
                @csrf
                <input type="hidden" name="code" :value="currentCode">
                <input type="hidden" name="output" :value="lastOutput">
                <input type="hidden" name="language" :value="language">
                
                @if($userAnswer && $userAnswer->is_correct)
                    <a href="{{ route('user.courses.learn', $course->id) }}" class="cyber-btn px-4 py-1.5 text-[10px] flex items-center gap-2 border-green-500 bg-green-500/20 text-[var(--green)] hover:bg-green-500/30 hover:shadow-[0_0_15px_rgba(0,255,136,0.3)]">
                        <i class="fas fa-check-circle"></i> Selesai
                    </a>
                @else
                    <button type="submit" class="cyber-btn px-4 py-1.5 text-[10px] flex items-center gap-2 transition-all" :class="canSubmit ? 'border-green-500 bg-green-500/20 text-[var(--green)] hover:bg-green-500/30 hover:shadow-[0_0_15px_rgba(0,255,136,0.3)]' : 'opacity-50 cursor-not-allowed border-[var(--border)] text-[var(--text3)]'" :disabled="!canSubmit" @click.prevent="submitAnswer()">
                        <i class="fas fa-paper-plane"></i> Transmit Source
                    </button>
                @endif
            </form>
            @if($nextContent)
                <a href="{{ route('user.courses.content', [$course->id, $nextContent->type . ':' . $nextContent->id]) }}" class="cyber-btn flex items-center gap-2 px-3 py-1 text-[10px]" style="border-color: var(--text3); color: var(--text3);">
                    Next Node <i class="fas fa-chevron-right"></i>
                </a>
            @endif
        </div>
    </div>
</div>

{{-- CodeMirror CDN --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.18/codemirror.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.18/theme/dracula.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.18/codemirror.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.18/mode/go/go.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.18/mode/javascript/javascript.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.18/mode/python/python.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.18/mode/clike/clike.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.18/mode/php/php.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.18/mode/ruby/ruby.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.18/addon/edit/closebrackets.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.18/addon/edit/matchbrackets.min.js"></script>

<style>
/* Reset specific CodeMirror styles for the theme */
.CodeMirror { 
    position: absolute !important;
    top: 0; left: 0; right: 0; bottom: 0;
    height: 100% !important; 
    font-size: 13px; 
    font-family: 'Fira Code', 'Fira Code', monospace;
    background: transparent !important;
}
.CodeMirror-gutters {
    background: rgba(0,0,0,0.3) !important;
    border-right: 1px solid var(--border) !important;
}

/* Custom Scrollbar */
.custom-scrollbar::-webkit-scrollbar { width: 6px; height: 6px; }
.custom-scrollbar::-webkit-scrollbar-track { background: rgba(0,0,0,0.2); }
.custom-scrollbar::-webkit-scrollbar-thumb { background: var(--border); border-radius: 3px; }
.custom-scrollbar:hover::-webkit-scrollbar-thumb { background: var(--accent2); }

/* Animation overrides */
@keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
.animate-spin { animation: spin 1s linear infinite; }

/* Coursera-style Light Mode overrides */
body.light #coding-root {
    background: #f8fafc !important;
    color: #0f172a !important;
}
body.light #coding-root .cyber-btn {
    border-color: #cbd5e1 !important;
    color: #334155 !important;
    background: #ffffff !important;
}
body.light #coding-root .cyber-btn:hover {
    border-color: var(--php) !important;
    color: var(--php) !important;
    background: rgba(124, 92, 191, 0.05) !important;
}
body.light #coding-root .border-b,
body.light #coding-root .border-r,
body.light #coding-root .border-t,
body.light #coding-root .border-y,
body.light #coding-root .border {
    border-color: #cbd5e1 !important;
}
body.light #coding-root .bg-black\/50,
body.light #coding-root .bg-black\/30,
body.light #coding-root .bg-black\/20,
body.light #coding-root .bg-black\/10,
body.light #coding-root .bg-black\/5,
body.light #coding-root .bg-\[\#0a0a0a\],
body.light #coding-root .bg-black {
    background: #ffffff !important;
}
body.light #coding-root .CodeMirror-gutters {
    background: #f1f5f9 !important;
    border-right: 1px solid #cbd5e1 !important;
}
body.light #coding-root .text-\[var\(--text2\)\] {
    color: #475569 !important;
}
body.light #coding-root .text-white {
    color: #0f172a !important;
}
body.light #coding-root .CodeMirror {
    color: #0f172a !important;
}
body.light #coding-root textarea {
    background: #ffffff !important;
    color: #0f172a !important;
    border-color: #cbd5e1 !important;
}
body.light #coding-root .flex-shrink-0 {
    background: #f1f5f9 !important;
}
body.light #coding-root .CodeMirror-cursor {
    border-left: 1px solid black !important;
}

/* Premium high-contrast styles for Rules and Test Cases in Light Mode */
body.light #coding-root .bg-green-500\/10,
body.light #coding-root .bg-green-500\/5 {
    background-color: #d1e7dd !important;
    border-color: #a3cfbb !important;
    color: #0f5132 !important;
}
body.light #coding-root .text-\[var\(--green\)\] {
    color: #0f5132 !important;
}
body.light #coding-root .bg-red-500\/10,
body.light #coding-root .bg-red-500\/5 {
    background-color: #f8d7da !important;
    border-color: #f1aeb5 !important;
    color: #842029 !important;
}
body.light #coding-root .text-\[\#ff4d4d\] {
    color: #842029 !important;
}
body.light #coding-root .bg-black\/20 {
    background-color: #f1f5f9 !important;
    border-color: #cbd5e1 !important;
    color: #334155 !important;
}
body.light #coding-root pre,
body.light #coding-root pre.whitespace-pre-wrap {
    background-color: #f1f5f9 !important;
    border-color: #cbd5e1 !important;
    color: #1f2a44 !important;
}
body.light #coding-root pre.text-\[var\(--cyan\)\] {
    color: #0056d2 !important;
}
body.light #coding-root .text-\[var\(--cyan\)\] {
    color: #0056d2 !important;
}
body.light #coding-root .border-green-500\/50 {
    border-color: #a3cfbb !important;
}
body.light #coding-root .border-red-500\/50 {
    border-color: #f1aeb5 !important;
}
</style>

<script>
function codingChallenge() {
    return {
        currentCode: '',
        lastOutput: '',
        userInput: '',
        terminalOutput: [],
        terminalErrors: '',
        terminalTab: 'output',
        editorHeight: 60,
        problemCollapsed: false,
        isRunning: false,
        isValidating: false,
        isChecking: false,
        isTesting: false,
        isResizing: false,
        isSubmitting: false,
        rulesStatus: @json(array_fill_keys($content->coding_rules ?? [], false)),
        allRulesPassed: false,
        outputMatches: false,
        allTestsPassed: false,
        canSubmit: false,
        editor: null,
        language: '{{ $content->language ?? 'go' }}',
        expectedOutput: @json($content->expected_output ?? ''),
        hasTestCases: {{ $hasTestCases ? 'true' : 'false' }},
        testCases: @json($content->test_cases ?? []),
        testCaseResults: @json(array_fill(0, count($content->test_cases ?? []), null)),
        testResultsDetail: [],
        testResultsSummary: '',

        init() {
            this.$nextTick(() => { this.initEditor(); });
            @if($userAnswer && $userAnswer->rules_passed)
                this.rulesStatus = @json($userAnswer->rules_passed);
                this.checkAllRulesPassed();
            @endif
            @if($userAnswer && $userAnswer->is_correct)
                this.canSubmit = true;
                this.allRulesPassed = true;
                this.outputMatches = true;
                this.allTestsPassed = true;
            @endif
        },

        initEditor() {
            const textarea = document.getElementById('codeEditor');
            if (!textarea) return;
            const modeMap = {'go':'text/x-go','javascript':'text/javascript','python':'text/x-python','java':'text/x-java','c':'text/x-csrc','cpp':'text/x-c++src','php':'application/x-httpd-php','ruby':'text/x-ruby','typescript':'text/typescript'};
            
            // Set dynamic theme based on current body mode
            const isLight = document.body.classList.contains('light');
            
            this.editor = CodeMirror.fromTextArea(textarea, {
                mode: modeMap[this.language] || 'text/x-go', 
                theme: isLight ? 'default' : 'dracula', 
                lineNumbers: true,
                matchBrackets: true, autoCloseBrackets: true,
                indentUnit: 4, tabSize: 4, indentWithTabs: true, lineWrapping: false,
                extraKeys: {
                    'Ctrl-Enter': () => this.runCode(),
                    'Shift-Ctrl-Enter': () => this.checkAll(),
                    'Tab': (cm) => { cm.replaceSelection('\t'); }
                }
            });
            
            // Dynamic observer to toggle CodeMirror theme on class change
            const observer = new MutationObserver((mutations) => {
                mutations.forEach((mutation) => {
                    if (mutation.attributeName === 'class') {
                        const isLightNow = document.body.classList.contains('light');
                        this.editor.setOption('theme', isLightNow ? 'default' : 'dracula');
                    }
                });
            });
            observer.observe(document.body, { attributes: true });
            
            this.currentCode = this.editor.getValue();
            this.editor.on('change', () => { this.currentCode = this.editor.getValue(); });
        },

        addTerminalLine(text, type = 'output') {
            this.terminalOutput.push({ text, type });
        },

        clearTerminal() {
            this.terminalOutput = [];
            this.terminalErrors = '';
            this.testResultsDetail = [];
            this.testResultsSummary = '';
            this.testCaseResults = this.testCaseResults.map(() => null);
        },

        async runCode() {
            if (this.isRunning) return;
            this.isRunning = true;
            this.terminalTab = 'output';
            this.addTerminalLine('Compiling and executing...', 'system');

            try {
                const response = await fetch('{{ route("user.code.compile") }}', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'X-Requested-With': 'XMLHttpRequest' },
                    body: JSON.stringify({ code: this.currentCode, input: this.userInput || null, language: this.language }),
                });
                const data = await response.json();
                this.handleCompileResult(data);
            } catch (error) {
                this.addTerminalLine('Network error: ' + error.message, 'error');
                this.terminalErrors = error.message;
            } finally {
                this.isRunning = false;
            }
        },

        async runCodeWithInput() {
            this.terminalTab = 'output';
            await this.runCode();
        },

        handleCompileResult(data) {
            if (data.success) {
                this.addTerminalLine('--- Program Output Stream ---', 'system');
                if (data.output) {
                    data.output.split('\n').forEach(line => this.addTerminalLine(line, 'output'));
                    this.lastOutput = data.output;
                } else {
                    this.addTerminalLine('(no output)', 'system');
                    this.lastOutput = '';
                }
                this.addTerminalLine('--- Process Terminated Successfully ---', 'system');
                this.terminalErrors = '';
                this.outputMatches = this.normalizeOutput(this.lastOutput) === this.normalizeOutput(this.expectedOutput);
                this.updateCanSubmit();
            } else {
                this.addTerminalLine('--- Compilation Failed ---', 'system');
                if (data.errors) data.errors.split('\n').forEach(line => this.addTerminalLine(line, 'error'));
                this.terminalErrors = data.errors || 'Unknown error';
                this.terminalTab = 'errors';
                this.lastOutput = '';
                this.outputMatches = false;
                this.updateCanSubmit();
            }
        },

        async validateRulesNow() {
            if (this.isValidating) return;
            this.isValidating = true;
            try {
                const response = await fetch('{{ route("user.code.validate-rules") }}', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'X-Requested-With': 'XMLHttpRequest' },
                    body: JSON.stringify({ code: this.currentCode, rules: @json($content->coding_rules ?? []) }),
                });
                const data = await response.json();
                this.rulesStatus = data.rules;
                this.allRulesPassed = data.all_passed;
                this.updateCanSubmit();
                this.addTerminalLine('--- Syntax Constraints Check ---', 'system');
                for (const [rule, passed] of Object.entries(data.rules)) {
                    this.addTerminalLine((passed ? '✓ PASS' : '✗ FAIL') + ' - ' + rule, passed ? 'output' : 'error');
                }
            } catch (error) {
                this.addTerminalLine('Constraints check error: ' + error.message, 'error');
            } finally {
                this.isValidating = false;
            }
        },

        async runAllTests() {
            if (this.isTesting) return;
            this.isTesting = true;
            this.terminalTab = 'tests';
            this.testResultsDetail = [];
            this.addTerminalLine('=== Executing Evaluation Matrix ===', 'system');

            try {
                const response = await fetch('{{ route("user.code.run-tests") }}', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'X-Requested-With': 'XMLHttpRequest' },
                    body: JSON.stringify({ code: this.currentCode, test_cases: this.testCases, language: this.language }),
                });
                const data = await response.json();
                this.testResultsDetail = data.test_results || [];
                this.allTestsPassed = data.all_passed;
                this.testResultsSummary = data.passed_count + '/' + data.total;

                // Update sidebar test case indicators
                data.test_results.forEach((r, i) => { this.testCaseResults[i] = r.passed; });

                // Terminal output
                data.test_results.forEach(r => {
                    this.addTerminalLine(
                        (r.passed ? '✓' : '✗') + ' Matrix ' + r.test_number + ': Input="' + r.input + '" Expected="' + r.expected_output + '" Got="' + r.actual_output + '"',
                        r.passed ? 'output' : 'error'
                    );
                });
                this.addTerminalLine('=== Matrices: ' + data.passed_count + '/' + data.total + ' passed ===', 'system');
                this.updateCanSubmit();
            } catch (error) {
                this.addTerminalLine('Evaluation error: ' + error.message, 'error');
            } finally {
                this.isTesting = false;
            }
        },

        async checkAll() {
            if (this.isChecking) return;
            this.isChecking = true;
            this.terminalTab = 'output';
            this.addTerminalLine('=== Full Verification Protocol Started ===', 'system');

            try {
                const response = await fetch('{{ route("user.code.check") }}', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'X-Requested-With': 'XMLHttpRequest' },
                    body: JSON.stringify({
                        code: this.currentCode,
                        rules: @json($content->coding_rules ?? []),
                        expected_output: this.expectedOutput,
                        test_cases: this.testCases,
                        input: this.userInput || null,
                        language: this.language,
                    }),
                });
                const data = await response.json();

                this.rulesStatus = data.rules;
                this.allRulesPassed = data.all_rules_passed;

                this.addTerminalLine('--- Syntax Constraints ---', 'system');
                for (const [rule, passed] of Object.entries(data.rules)) {
                    this.addTerminalLine((passed ? '✓ PASS' : '✗ FAIL') + ' - ' + rule, passed ? 'output' : 'error');
                }

                this.addTerminalLine('--- Compilation Phase ---', 'system');
                if (data.compilation.success) {
                    this.addTerminalLine('✓ Compiled successfully', 'output');
                    if (data.compilation.output) {
                        this.addTerminalLine('--- Output Stream ---', 'system');
                        data.compilation.output.split('\n').forEach(line => this.addTerminalLine(line, 'output'));
                        this.lastOutput = data.compilation.output;
                    }
                    this.terminalErrors = '';
                } else {
                    this.addTerminalLine('✗ Compilation failed', 'error');
                    if (data.compilation.errors) data.compilation.errors.split('\n').forEach(line => this.addTerminalLine(line, 'error'));
                    this.terminalErrors = data.compilation.errors || '';
                    this.lastOutput = '';
                }

                this.outputMatches = data.output_matches;
                this.addTerminalLine('--- Signature Match: ' + (data.output_matches ? '✓ VERIFIED' : '✗ REJECTED') + ' ---', data.output_matches ? 'output' : 'error');

                if (data.test_results) {
                    this.testResultsDetail = data.test_results.test_results || [];
                    this.allTestsPassed = data.all_tests_passed;
                    this.testResultsSummary = (data.test_results.passed_count || 0) + '/' + (data.test_results.total || 0);
                    (data.test_results.test_results || []).forEach((r, i) => { this.testCaseResults[i] = r.passed; });
                    this.addTerminalLine('--- Matrices: ' + this.testResultsSummary + ' passed ---', data.all_tests_passed ? 'output' : 'error');
                }

                this.canSubmit = data.can_submit;
                this.addTerminalLine('=== Protocol Status: ' + (data.can_submit ? '✓ READY FOR TRANSMISSION' : '✗ VERIFICATION FAILED') + ' ===', 'system');
            } catch (error) {
                this.addTerminalLine('Verification error: ' + error.message, 'error');
            } finally {
                this.isChecking = false;
            }
        },

        async submitAnswer() {
            if (!this.canSubmit || this.isSubmitting) return;
            this.isSubmitting = true;
            this.addTerminalLine('Initiating secure transmission...', 'system');
            try {
                const form = document.getElementById('submitForm');
                const formData = new FormData(form);
                const response = await fetch(form.action, { method: 'POST', body: formData, headers: { 'X-Requested-With': 'XMLHttpRequest' } });
                const data = await response.json();
                if (data.success && data.is_correct) {
                    this.addTerminalLine('🎉 ' + data.message, 'system');
                    setTimeout(() => {
                        @if($nextContent)
                            window.location.href = '{{ route("user.courses.content", [$course->id, $nextContent->type . ":" . $nextContent->id]) }}';
                        @else
                            window.location.href = '{{ route("user.courses.learn", $course->id) }}';
                        @endif
                    }, 1500);
                } else {
                    this.addTerminalLine('⚠ ' + (data.message || 'Transmission failed'), 'error');
                }
            } catch (error) {
                this.addTerminalLine('Transmission error: ' + error.message, 'error');
                document.getElementById('submitForm').submit();
            } finally {
                if (!this.canSubmit) this.isSubmitting = false;
            }
        },

        normalizeOutput(text) {
            return text.replace(/\r\n/g, '\n').replace(/\r/g, '\n').split('\n').map(l => l.trimEnd()).filter((l, i, a) => i < a.length - 1 || l !== '').join('\n');
        },

        checkAllRulesPassed() {
            this.allRulesPassed = Object.values(this.rulesStatus).every(v => v === true);
        },

        updateCanSubmit() {
            if (this.hasTestCases) {
                this.canSubmit = this.allRulesPassed && this.allTestsPassed;
            } else {
                this.canSubmit = this.allRulesPassed && this.outputMatches;
            }
        },

        startResize(event) {
            this.isResizing = true;
            const startY = event.clientY;
            const startHeight = this.editorHeight;
            const panel = event.target.closest('.flex-1.flex.flex-col.min-w-0');
            const panelHeight = panel.offsetHeight;
            const onMouseMove = (e) => { const delta = e.clientY - startY; this.editorHeight = Math.max(20, Math.min(80, startHeight + (delta / panelHeight * 100))); };
            const onMouseUp = () => { this.isResizing = false; document.removeEventListener('mousemove', onMouseMove); document.removeEventListener('mouseup', onMouseUp); };
            document.addEventListener('mousemove', onMouseMove);
            document.addEventListener('mouseup', onMouseUp);
        },
    };
}
</script>

@endsection

