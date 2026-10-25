@extends('layouts.app')

@section('title', 'Hasil Evaluasi Kursus - ' . $course->title)

@section('content')
<div class="max-w-6xl mx-auto px-3.5 sm:px-6 py-4 sm:py-8 space-y-6 sm:space-y-8">
    
    <!-- Hero Results Header -->
    <div class="cyber-card p-5 sm:p-7 relative overflow-hidden rounded-2xl border border-[var(--border)]">
        <div class="absolute inset-0 opacity-5 pointer-events-none" style="background: repeating-linear-gradient(45deg, transparent, transparent 10px, var(--accent) 10px, var(--accent) 20px);"></div>
        
        <div class="relative z-10 flex flex-col lg:flex-row items-center justify-between gap-6">
            <!-- Course Info -->
            <div class="flex flex-col sm:flex-row items-center sm:items-start text-center sm:text-left gap-4 sm:gap-5 flex-1 min-w-0">
                <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-2xl bg-amber-500/10 border border-amber-500/30 flex items-center justify-center text-3xl sm:text-4xl shadow-lg shadow-amber-500/10 flex-shrink-0">
                    🏆
                </div>
                <div class="flex-1 min-w-0">
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider bg-blue-500/10 text-[var(--blue)] border border-blue-500/20 mb-1.5">
                        <i class="fas fa-chart-pie text-[9px]"></i> Evaluasi & Ringkasan Kursus
                    </span>
                    <h1 class="text-xl sm:text-2xl md:text-3xl font-extrabold text-[var(--text)] tracking-tight leading-snug break-words">
                        {{ $course->title }}
                    </h1>
                    <p class="text-xs sm:text-sm text-[var(--text2)] mt-1 leading-relaxed">
                        Laporan penyelesaian materi, evaluasi latihan kuis, dan pencapaian kompetensi Anda.
                    </p>
                </div>
            </div>
            
            <!-- Final Score Card (Mobile Responsive) -->
            <div class="w-full sm:w-auto min-w-[200px] p-4 sm:p-5 rounded-2xl bg-black/20 border border-[var(--border)] text-center shadow-lg">
                <div class="text-[10px] sm:text-xs font-black uppercase tracking-wider text-[var(--text3)] mb-1">
                    Skor Akhir Evaluasi
                </div>
                <div class="text-4xl sm:text-5xl font-black text-cyan-400 tracking-tight my-1">
                    {{ $score }}%
                </div>
                <div class="w-full max-w-[180px] mx-auto h-2 rounded-full overflow-hidden bg-slate-800/60 mt-2">
                    <div class="h-full rounded-full bg-cyan-400 transition-all duration-500" style="width: {{ $score }}%;"></div>
                </div>
                <div class="text-[10px] text-[var(--text3)] font-medium mt-1.5">
                    {{ $correctAnswers }} dari {{ $totalQuestions }} soal terjawab benar
                </div>
            </div>
        </div>

        <!-- Action Buttons (Responsive Grid on Mobile) -->
        <div class="relative z-10 grid grid-cols-1 sm:grid-cols-2 md:flex md:flex-wrap items-center gap-2.5 sm:gap-3.5 mt-6 pt-5 border-t border-[var(--border)]">
            <a href="{{ route('user.courses.learn', $course->id) }}" class="btn-outline px-4 py-2.5 rounded-xl text-xs font-bold inline-flex items-center justify-center gap-2">
                <i class="fas fa-arrow-left"></i> Kembali ke Modul
            </a>
            
            @if($syncedNodes < $totalNodes)
                <a href="{{ route('user.courses.learn', $course->id) }}" class="btn-gradient px-5 py-2.5 rounded-xl text-white text-xs font-bold inline-flex items-center justify-center gap-2 shadow-md">
                    <i class="fas fa-play"></i> Lanjutkan Belajar ({{ $totalNodes - $syncedNodes }} Materi Tersisa)
                </a>
            @endif
            
            @if($syncedNodes >= $totalNodes && $totalNodes > 0)
                <a href="{{ route('user.courses.certificate', $course->id) }}" target="_blank" class="px-5 py-2.5 rounded-xl text-xs font-bold inline-flex items-center justify-center gap-2 border border-yellow-500 bg-yellow-500/10 text-yellow-500 hover:bg-yellow-500/20 transition shadow-md shadow-yellow-500/10">
                    <i class="fas fa-certificate"></i> Unduh Sertifikat Resmi
                </a>
            @endif

            <form action="{{ route('user.courses.retake', $course->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin mengulang kursus ini? Seluruh progres jawaban kuis akan direset agar Anda dapat mengerjakan ulang.')" class="inline m-0">
                @csrf
                <button type="submit" class="btn-outline px-4 py-2.5 rounded-xl text-xs font-bold inline-flex items-center justify-center gap-2 hover:border-amber-500 hover:text-amber-400 transition w-full sm:w-auto">
                    <i class="fas fa-rotate-left"></i> Ulangi Kursus (Retake)
                </button>
            </form>
            
            <button onclick="window.print()" class="btn-outline px-4 py-2.5 rounded-xl text-xs font-bold inline-flex items-center justify-center gap-2 text-[var(--text3)]">
                <i class="fas fa-print"></i> Cetak / Simpan PDF
            </button>
        </div>
    </div>

    <!-- Statistics Cards: 2 Columns on Mobile, 4 Columns on Desktop (Compact & Balanced) -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 md:gap-5">
        <!-- Card 1: Total Modul -->
        <div class="cyber-card p-3.5 sm:p-5 rounded-2xl border border-[var(--border)] flex flex-col sm:flex-row items-center sm:items-start text-center sm:text-left gap-2.5 sm:gap-4">
            <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-blue-500/10 text-[var(--blue)] flex items-center justify-center text-lg sm:text-xl flex-shrink-0">
                <i class="fas fa-layer-group"></i>
            </div>
            <div class="min-w-0">
                <div class="text-[10px] sm:text-xs font-bold text-[var(--text3)] uppercase tracking-wider">Total Modul</div>
                <div class="text-xl sm:text-2xl font-black text-[var(--text)] mt-0.5">{{ $totalNodes }}</div>
            </div>
        </div>
        
        <!-- Card 2: Modul Diselesaikan -->
        <div class="cyber-card p-3.5 sm:p-5 rounded-2xl border border-[var(--border)] flex flex-col sm:flex-row items-center sm:items-start text-center sm:text-left gap-2.5 sm:gap-4">
            <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-cyan-500/10 text-cyan-400 flex items-center justify-center text-lg sm:text-xl flex-shrink-0">
                <i class="fas fa-tasks"></i>
            </div>
            <div class="min-w-0">
                <div class="text-[10px] sm:text-xs font-bold text-[var(--text3)] uppercase tracking-wider">Modul Tuntas</div>
                <div class="text-xl sm:text-2xl font-black text-cyan-400 mt-0.5">{{ $syncedNodes }}</div>
            </div>
        </div>
        
        <!-- Card 3: Soal Benar -->
        <div class="cyber-card p-3.5 sm:p-5 rounded-2xl border border-emerald-500/30 flex flex-col sm:flex-row items-center sm:items-start text-center sm:text-left gap-2.5 sm:gap-4 shadow-sm shadow-emerald-500/5">
            <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-emerald-500/10 text-emerald-400 flex items-center justify-center text-lg sm:text-xl flex-shrink-0">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="min-w-0">
                <div class="text-[10px] sm:text-xs font-bold text-[var(--text3)] uppercase tracking-wider">Jawaban Benar</div>
                <div class="text-xl sm:text-2xl font-black text-emerald-400 mt-0.5">{{ $correctAnswers }}</div>
            </div>
        </div>
        
        <!-- Card 4: Total Poin -->
        <div class="cyber-card p-3.5 sm:p-5 rounded-2xl border border-[var(--border)] flex flex-col sm:flex-row items-center sm:items-start text-center sm:text-left gap-2.5 sm:gap-4">
            <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-amber-500/10 text-amber-400 flex items-center justify-center text-lg sm:text-xl flex-shrink-0">
                <i class="fas fa-star"></i>
            </div>
            <div class="min-w-0">
                <div class="text-[10px] sm:text-xs font-bold text-[var(--text3)] uppercase tracking-wider">Total Skor Pts</div>
                <div class="text-xl sm:text-2xl font-black text-amber-400 mt-0.5">{{ $totalPoints }}</div>
            </div>
        </div>
    </div>

    <!-- Performance Analysis (Mobile Friendly Breakdown & Protocol) -->
    <div class="cyber-card p-5 sm:p-7 rounded-2xl border border-[var(--border)]">
        <h2 class="text-base sm:text-lg font-black text-[var(--text)] mb-5 flex items-center gap-2.5">
            <i class="fas fa-chart-line text-[var(--blue)]"></i> Analisis Performa Belajar
        </h2>
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6">
            <!-- Score Breakdown -->
            <div class="p-4 sm:p-6 rounded-2xl border border-[var(--border)] bg-black/15 flex flex-col justify-center gap-4">
                <h3 class="text-xs font-black uppercase tracking-wider text-[var(--text)] mb-1">
                    Metrik Penyelesaian & Akurasi
                </h3>
                
                <div class="space-y-4">
                    <div>
                        <div class="flex justify-between items-center text-xs mb-1.5 font-semibold">
                            <span class="text-[var(--text2)]">Akurasi Jawaban Kuis & Coding:</span>
                            <span class="font-bold text-emerald-400">{{ $totalQuestions > 0 ? round(($correctAnswers / $totalQuestions) * 100) : 0 }}%</span>
                        </div>
                        <div class="w-full h-2.5 rounded-full overflow-hidden bg-slate-800">
                            <div class="h-full rounded-full bg-emerald-400 transition-all duration-500" style="width: {{ $totalQuestions > 0 ? round(($correctAnswers / $totalQuestions) * 100) : 0 }}%;"></div>
                        </div>
                    </div>
                    
                    <div>
                        <div class="flex justify-between items-center text-xs mb-1.5 font-semibold">
                            <span class="text-[var(--text2)]">Kemajuan Total Modul (Progress):</span>
                            <span class="font-bold text-cyan-400">{{ $totalNodes > 0 ? round(($syncedNodes / $totalNodes) * 100) : 0 }}%</span>
                        </div>
                        <div class="w-full h-2.5 rounded-full overflow-hidden bg-slate-800">
                            <div class="h-full rounded-full bg-cyan-400 transition-all duration-500" style="width: {{ $totalNodes > 0 ? round(($syncedNodes / $totalNodes) * 100) : 0 }}%;"></div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Grade Assessment (Responsive Fix for Screenshot 3) -->
            @php
                $grade = 'E';
                $gradeColor = '#ef4444';
                $gradeMessage = 'Perlu Peningkatan';
                $gradeAdvice = 'Akurasi kuis belum memenuhi standar kelulusan minimal. Disarankan untuk mempelajari kembali materi pelajaran dan mencoba evaluasi ulang.';
                
                if ($score >= 90) {
                    $grade = 'A';
                    $gradeColor = '#10b981';
                    $gradeMessage = 'Sangat Memuaskan (Optimal)';
                    $gradeAdvice = 'Luar biasa! Pemahaman Anda terhadap materi kursus ini sangat sempurna dan telah menguasai setiap konsep dengan baik.';
                } elseif ($score >= 80) {
                    $grade = 'B';
                    $gradeColor = '#06b6d4';
                    $gradeMessage = 'Baik & Kompeten';
                    $gradeAdvice = 'Performa belajar yang solid! Pemahaman konsep materi stabil dan Anda siap melangkah ke materi tingkat berikutnya.';
                } elseif ($score >= 70) {
                    $grade = 'C';
                    $gradeColor = '#eab308';
                    $gradeMessage = 'Cukup (Kompeten Standar)';
                    $gradeAdvice = 'Pemahaman materi sudah cukup baik. Tinjau kembali beberapa soal yang belum tepat untuk menyempurnakan keahlian Anda.';
                } elseif ($score >= 60) {
                    $grade = 'D';
                    $gradeColor = '#f97316';
                    $gradeMessage = 'Kurang Memuaskan';
                    $gradeAdvice = 'Tingkat pemahaman masih di bawah standar. Sangat dianjurkan untuk membaca materi dan berlatih kembali.';
                }
            @endphp
            <div class="p-4 sm:p-6 rounded-2xl border border-[var(--border)] bg-black/15 flex flex-col sm:flex-row items-center sm:items-start text-center sm:text-left gap-4 sm:gap-5">
                <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-2xl border-2 flex items-center justify-center flex-shrink-0 shadow-lg" style="border-color: {{ $gradeColor }}; background: {{ $gradeColor }}15;">
                    <span class="text-3xl sm:text-4xl font-black" style="color: {{ $gradeColor }};">{{ $grade }}</span>
                </div>
                
                <div class="flex-1 min-w-0">
                    <span class="text-[10px] font-black uppercase tracking-wider text-[var(--text3)] block mb-0.5">Predikat Kelulusan</span>
                    <h4 class="text-base sm:text-lg font-black mb-1.5" style="color: {{ $gradeColor }};">{{ $gradeMessage }}</h4>
                    <p class="text-xs text-[var(--text2)] leading-relaxed font-normal">{{ $gradeAdvice }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Detailed Results Log -->
    <div class="cyber-card p-0 overflow-hidden rounded-2xl border border-[var(--border)]">
        <div class="p-4 sm:p-5 border-b border-[var(--border)] flex flex-wrap items-center justify-between gap-3 bg-black/20">
            <div class="flex items-center gap-2.5">
                <i class="fas fa-list-check text-[var(--blue)] text-base"></i>
                <h2 class="text-sm sm:text-base font-black text-[var(--text)]">Daftar Evaluasi Seluruh Soal & Tantangan</h2>
            </div>
            <div class="flex items-center gap-2 text-[11px] font-bold">
                <span class="px-2.5 py-1 rounded-lg bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                    ✔ {{ $correctAnswers }} Benar
                </span>
                <span class="px-2.5 py-1 rounded-lg bg-rose-500/10 text-rose-400 border border-rose-500/20">
                    ✖ {{ max(0, $answeredCount - $correctAnswers) }} Salah
                </span>
                @if($totalQuestions > $answeredCount)
                    <span class="px-2.5 py-1 rounded-lg bg-amber-500/10 text-amber-400 border border-amber-500/20">
                        ⏳ {{ $totalQuestions - $answeredCount }} Belum Dikerjakan
                    </span>
                @endif
            </div>
        </div>
        
        @if($evaluatedQuestions->isEmpty())
            <div class="p-10 sm:p-14 text-center">
                <div class="text-4xl sm:text-5xl mb-3 opacity-60">📚</div>
                <h3 class="text-sm font-bold text-[var(--text)] mb-1">Kursus Materi Pembelajaran</h3>
                <p class="text-xs text-[var(--text3)] mb-4">Kursus ini fokus pada penyampaian modul materi, bacaan, dan video tanpa ujian soal kuis.</p>
                <a href="{{ route('user.courses.learn', $course->id) }}" class="btn-gradient px-4 py-2 rounded-xl text-xs font-bold text-white inline-flex items-center gap-1.5">
                    <i class="fas fa-book-open text-[10px]"></i> Buka Modul Kursus
                </a>
            </div>
        @else
            <div class="divide-y divide-[var(--border)]">
                @foreach($evaluatedQuestions as $index => $item)
                    @php
                        $q = $item['question'];
                        $ans = $item['user_answer'];
                        $isAnswered = $item['is_answered'];
                        $isCorrect = $item['is_correct'];
                        $points = $item['points'];
                        $isSecret = $course->isNoneQuizFeedback();
                        $isCoding = $q->isCoding();

                        $bgCard = 'transparent';
                        if ($isAnswered && !$isSecret) {
                            $bgCard = $isCorrect ? 'rgba(16, 185, 129, 0.03)' : 'rgba(239, 68, 68, 0.03)';
                        } elseif (!$isAnswered) {
                            $bgCard = 'rgba(245, 158, 11, 0.02)';
                        }
                    @endphp
                    <div class="p-4 sm:p-6 transition-colors hover:bg-white/[0.02]" style="background: {{ $bgCard }};">
                        <div class="flex flex-col sm:flex-row items-start gap-3.5 sm:gap-5">
                            
                            <!-- Status Indicator Badge -->
                            @if(!$isAnswered)
                                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl border border-amber-500/40 bg-amber-500/10 text-amber-400 flex items-center justify-center text-base sm:text-lg flex-shrink-0" title="Belum Dikerjakan">
                                    <i class="fas fa-hourglass-half"></i>
                                </div>
                            @elseif($isSecret)
                                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl border border-blue-500/40 bg-blue-500/10 text-[var(--blue)] flex items-center justify-center text-base sm:text-lg flex-shrink-0" title="Jawaban Tersimpan">
                                    <i class="fas fa-file-shield"></i>
                                </div>
                            @elseif($isCorrect)
                                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl border border-emerald-500/40 bg-emerald-500/10 text-emerald-400 flex items-center justify-center text-lg sm:text-xl flex-shrink-0" title="Jawaban Benar">
                                    <i class="fas fa-check"></i>
                                </div>
                            @else
                                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl border border-rose-500/40 bg-rose-500/10 text-rose-400 flex items-center justify-center text-lg sm:text-xl flex-shrink-0" title="Jawaban Salah">
                                    <i class="fas fa-times"></i>
                                </div>
                            @endif
                            
                            <!-- Question Info & Options -->
                            <div class="flex-1 min-w-0 w-full">
                                <div class="flex flex-wrap items-center justify-between gap-2 mb-2">
                                    <div class="flex items-center gap-2">
                                        <h3 class="text-xs sm:text-sm font-bold text-[var(--text)]">
                                            {{ $q->title }}
                                        </h3>
                                        @if($isCoding)
                                            <span class="px-2 py-0.5 rounded text-[9px] font-mono font-bold uppercase bg-blue-500/10 text-cyan-400 border border-blue-500/20">
                                                <i class="fas fa-terminal text-[8px] mr-1"></i> {{ $q->language ?? 'Go' }} Lab
                                            </span>
                                        @else
                                            <span class="px-2 py-0.5 rounded text-[9px] font-mono font-bold uppercase bg-amber-500/10 text-amber-400 border border-amber-500/20">
                                                <i class="fas fa-list-check text-[8px] mr-1"></i> Pilihan Ganda
                                            </span>
                                        @endif
                                    </div>
                                    <span class="px-2 py-0.5 rounded text-[10px] font-mono font-bold bg-slate-800 text-slate-300 border border-[var(--border)]">
                                        Soal #{{ $index + 1 }}
                                    </span>
                                </div>
                                
                                <div class="flex flex-wrap items-center gap-3 text-[11px] font-medium mb-3">
                                    @if(!$isAnswered)
                                        <span class="text-amber-400 font-bold flex items-center gap-1">
                                            <i class="fas fa-circle-exclamation text-[10px]"></i> Belum Dijawab / Dilewati
                                        </span>
                                    @elseif($isSecret)
                                        <span class="text-cyan-400 font-bold flex items-center gap-1">
                                            <i class="fas fa-check text-[10px]"></i> Jawaban Tersimpan (Kunci Dirahasiakan)
                                        </span>
                                    @elseif($isCorrect)
                                        <span class="text-emerald-400 font-bold flex items-center gap-1">
                                            <i class="fas fa-check-circle text-[10px]"></i> Jawaban Benar (+{{ $points }} Pts)
                                        </span>
                                    @else
                                        <span class="text-rose-400 font-bold flex items-center gap-1">
                                            <i class="fas fa-times-circle text-[10px]"></i> Jawaban Masih Belum Tepat (0 Pts)
                                        </span>
                                    @endif

                                    @if($ans)
                                        <span class="text-[var(--text3)]">
                                            <i class="far fa-clock mr-1"></i> {{ $ans->created_at->format('d M Y, H:i') }}
                                        </span>
                                    @endif
                                </div>

                                <div class="p-3.5 sm:p-4 rounded-xl border border-[var(--border)] bg-black/25 mb-3.5">
                                    <p class="text-xs sm:text-[13px] text-[var(--text)] leading-relaxed mb-3.5">
                                        {!! nl2br(e($q->content)) !!}
                                    </p>
                                    
                                    <!-- Multiple Choice Options Breakdown -->
                                    @if(!$isCoding && is_array($q->options))
                                        @php
                                            $optionsList = $q->options;
                                            if ($course->isShuffleOptions() && count($optionsList) > 1) {
                                                $uId = auth()->id() ?? 0;
                                                $seededOpts = [];
                                                foreach ($optionsList as $opt) {
                                                    $seededOpts[] = [
                                                        'val' => $opt,
                                                        'hash' => md5($course->id . '_' . $uId . '_' . $q->id . '_' . $opt)
                                                    ];
                                                }
                                                usort($seededOpts, fn($a, $b) => strcmp($a['hash'], $b['hash']));
                                                $optionsList = array_column($seededOpts, 'val');
                                            }
                                        @endphp
                                        <div class="space-y-2">
                                            @foreach($optionsList as $optIdx => $option)
                                                @php
                                                    $isCorrectOpt = $option === $q->correct_answer;
                                                    $isUserOpt = $ans && $option === $ans->answer;
                                                    
                                                    $optBg = 'bg-black/10';
                                                    $optBorder = 'border-[var(--border)]';
                                                    $optIcon = '<i class="far fa-circle text-[10px] text-slate-500"></i>';
                                                    $optColor = 'text-[var(--text2)]';
                                                    
                                                    if (!$isSecret) {
                                                        if ($isCorrectOpt) {
                                                            $optBg = 'bg-emerald-500/10';
                                                            $optBorder = 'border-emerald-500/40';
                                                            $optIcon = '<i class="fas fa-check text-xs text-emerald-400"></i>';
                                                            $optColor = 'text-emerald-300 font-bold';
                                                        } elseif ($isUserOpt && !$isCorrect) {
                                                            $optBg = 'bg-rose-500/10';
                                                            $optBorder = 'border-rose-500/40';
                                                            $optIcon = '<i class="fas fa-times text-xs text-rose-400"></i>';
                                                            $optColor = 'text-rose-300 font-semibold';
                                                        } elseif ($isUserOpt) {
                                                            $optIcon = '<i class="fas fa-dot-circle text-xs text-[var(--cyan)]"></i>';
                                                        }
                                                    } else {
                                                        if ($isUserOpt) {
                                                            $optBg = 'bg-blue-500/10';
                                                            $optBorder = 'border-blue-500/40';
                                                            $optIcon = '<i class="fas fa-dot-circle text-xs text-blue-400"></i>';
                                                            $optColor = 'text-blue-300 font-semibold';
                                                        }
                                                    }
                                                @endphp
                                                <div class="p-2.5 sm:p-3 border rounded-xl flex items-center justify-between gap-3 transition-colors {{ $optBg }} {{ $optBorder }}">
                                                    <div class="flex items-center gap-2.5 min-w-0">
                                                        <span class="w-6 h-6 rounded flex items-center justify-center text-[11px] font-black font-mono border border-white/10 bg-white/5 flex-shrink-0">
                                                            {{ chr(65 + $optIdx) }}.
                                                        </span>
                                                        <div class="w-4 flex justify-center flex-shrink-0">{!! $optIcon !!}</div>
                                                        <span class="text-xs leading-relaxed {{ $optColor }} break-words">{{ $option }}</span>
                                                    </div>
                                                    <div class="flex items-center gap-1.5 flex-shrink-0">
                                                        @if($isUserOpt)
                                                            <span class="text-[9px] uppercase tracking-wider font-bold px-2 py-0.5 rounded bg-blue-500/10 text-cyan-400 border border-blue-500/20">
                                                                Pilihan Anda
                                                            </span>
                                                        @endif
                                                        @if(!$isSecret && $isCorrectOpt)
                                                            <span class="text-[9px] uppercase tracking-wider font-bold px-2 py-0.5 rounded bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                                                                Kunci Benar
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @elseif($isCoding)
                                        <!-- Coding Challenge Submission Breakdown -->
                                        <div class="grid grid-cols-1 {{ $isSecret ? '' : 'sm:grid-cols-2' }} gap-3">
                                            <div class="p-3.5 rounded-xl border border-[var(--border)] bg-black/40">
                                                <div class="text-[10px] font-bold uppercase tracking-wider text-cyan-400 mb-1 flex items-center gap-1.5">
                                                    <i class="fas fa-code"></i> Kode Solusi yang Ditransmisikan:
                                                </div>
                                                @if($ans && ($ans->code_submitted || $ans->answer))
                                                    <pre class="text-xs font-mono text-[var(--text)] whitespace-pre-wrap break-all max-h-48 overflow-y-auto custom-scrollbar p-2 bg-black/50 rounded border border-white/5">{{ $ans->code_submitted ?? $ans->answer }}</pre>
                                                @else
                                                    <div class="text-xs text-slate-500 italic p-2">Belum ada kode yang dikirimkan.</div>
                                                @endif

                                                @if($ans && $ans->code_output)
                                                    <div class="mt-2.5 pt-2 border-t border-white/10">
                                                        <div class="text-[9px] font-bold uppercase tracking-wider text-[var(--text3)] mb-0.5">Output Eksekusi Anda:</div>
                                                        <pre class="text-[11px] font-mono text-slate-300 whitespace-pre-wrap break-all p-1.5 bg-black/50 rounded">{{ $ans->code_output }}</pre>
                                                    </div>
                                                @endif
                                            </div>

                                            @if(!$isSecret && $q->expected_output)
                                                <div class="p-3.5 rounded-xl border border-emerald-500/30 bg-emerald-500/5">
                                                    <div class="text-[10px] font-bold uppercase tracking-wider text-emerald-400 mb-1 flex items-center gap-1.5">
                                                        <i class="fas fa-bullseye"></i> Output Kunci yang Diharapkan:
                                                    </div>
                                                    <pre class="text-xs font-mono text-emerald-300 whitespace-pre-wrap break-all max-h-48 overflow-y-auto custom-scrollbar p-2 bg-black/50 rounded border border-emerald-500/20">{{ $q->expected_output }}</pre>
                                                    
                                                    @if(!empty($q->test_cases))
                                                        <div class="mt-2.5 pt-2 border-t border-emerald-500/20 text-[10px] text-emerald-400/80 font-mono">
                                                            <i class="fas fa-flask mr-1"></i> Dilengkapi {{ count($q->test_cases) }} Automated Test Cases
                                                        </div>
                                                    @endif
                                                </div>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                                
                                <div class="flex items-center gap-3">
                                    <a href="{{ route('user.courses.content', [$course->id, 'question:' . $q->id]) }}" 
                                       class="{{ !$isAnswered ? 'btn-gradient text-white' : 'btn-outline' }} px-4 py-2 rounded-xl text-xs font-bold inline-flex items-center gap-1.5 shadow-sm">
                                        @if(!$isAnswered)
                                            <i class="fas fa-bolt text-[11px]"></i> Kerjakan Soal Ini
                                        @else
                                            <i class="fas fa-eye text-[11px]"></i> Kaji Ulang Soal
                                        @endif
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Completion Celebration Banner (When Completed) -->
    @if($syncedNodes === $totalNodes && $totalNodes > 0)
        <div class="cyber-card p-5 sm:p-7 rounded-2xl border border-emerald-500/30 bg-gradient-to-r from-emerald-500/10 via-cyan-500/5 to-transparent flex flex-col md:flex-row items-center justify-between gap-5">
            <div class="flex items-center gap-4 text-center sm:text-left">
                <div class="text-4xl sm:text-5xl animate-bounce">🎉</div>
                <div>
                    <h3 class="text-lg sm:text-xl font-black text-emerald-400">Selamat! Kursus Berhasil Diselesaikan</h3>
                    <p class="text-xs text-[var(--text2)] mt-0.5">Seluruh modul pembelajaran telah Anda tuntaskan dengan baik.</p>
                </div>
            </div>
            
            <a href="{{ route('user.courses.certificate', $course->id) }}" target="_blank" class="w-full sm:w-auto px-6 py-3 rounded-xl text-xs font-bold text-white bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 shadow-lg shadow-emerald-500/20 inline-flex items-center justify-center gap-2 transition">
                <i class="fas fa-award text-sm"></i> Klaim Sertifikat Kompetensi
            </a>
        </div>
    @endif

</div>
@endsection

