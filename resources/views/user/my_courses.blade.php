@extends('layouts.app')

@section('title', 'Kursus Saya | TalentGroup')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 py-8">
    
    <!-- Hero Header -->
    <div class="rounded-2xl p-6 sm:p-8 mb-8 bg-gradient-to-r from-blue-900 to-indigo-900 text-white shadow-md relative overflow-hidden">
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-2xl bg-white/10 backdrop-blur-md flex items-center justify-center text-white border border-white/20 shadow-sm">
                    <svg class="w-8 h-8 text-white" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 3L1 9L12 15L21 10.09V17H23V9L12 3Z"/>
                        <path d="M5 13.18V17.18C5 19.57 8.13 21.5 12 21.5C15.87 21.5 19 19.57 19 17.18V13.18L12 17L5 13.18Z" opacity="0.85"/>
                    </svg>
                </div>
                <div>
                    <span class="text-xs font-mono uppercase tracking-wider text-blue-200 font-bold">Workspace Pembelajaran</span>
                    <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight mt-0.5">Kursus & Modul Aktif Saya</h1>
                    <p class="text-xs sm:text-sm text-blue-100 mt-1">Lanjutkan progres belajar, selesaikan tantangan coding, dan raih sertifikat kompetensi Anda.</p>
                </div>
            </div>
            <div>
                <a href="{{ route('user.courses.index') }}" class="px-5 py-2.5 rounded-xl bg-white text-[var(--blue)] hover:bg-blue-50 font-bold text-xs shadow transition inline-flex items-center gap-2">
                    <i class="fas fa-search"></i> Jelajahi Kursus Lain
                </a>
            </div>
        </div>
    </div>

    @if ($courses->isEmpty())
        <!-- Empty State -->
        <div class="empty-prototype-box py-16 px-6 text-center shadow-sm">
            <div class="w-16 h-16 rounded-2xl empty-icon-wrap flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-[var(--blue)]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>
                    <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>
                    <path d="M8 7h8"/>
                    <path d="M8 11h6"/>
                </svg>
            </div>
            <h3 class="text-lg font-bold text-[var(--ink)] mb-2">Belum Ada Kursus yang Diikuti</h3>
            <p class="text-xs text-[var(--muted)] mb-6 max-w-md mx-auto leading-relaxed">
                Anda belum mendaftar di kursus mana pun. Kunjungi katalog kursus dan mulai langkah pertama peningkatan skill Anda sekarang!
            </p>
            <a href="{{ route('user.courses.index') }}" class="btn-gradient px-6 py-3 rounded-xl text-white font-bold text-xs shadow-md inline-flex items-center gap-2">
                <i class="fas fa-compass"></i> Buka Katalog Kursus
            </a>
        </div>
    @else
        <!-- Courses Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($courses as $index => $course)
                <div class="bg-white border border-[var(--border)] rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition-all duration-200 flex flex-col group">
                    
                    <!-- Card Cover -->
                    <div class="h-44 relative bg-slate-100 overflow-hidden border-b border-[var(--border)]">
                        @if($course->image)
                            <img src="{{ $course->image_url }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" alt="{{ $course->title }}">
                        @else
                            @php
                                $coverSvgs = [
                                    '<svg class="w-12 h-12 text-blue-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/><path d="m10 9-2 2 2 2"/><path d="m14 9 2 2-2 2"/></svg>',
                                    '<svg class="w-12 h-12 text-amber-500" viewBox="0 0 24 24" fill="currentColor"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>',
                                    '<svg class="w-12 h-12 text-emerald-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>',
                                    '<svg class="w-12 h-12 text-purple-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M4.5 16.5c-1.5 1.26-2 5-2 5s3.74-.5 5-2c.71-.84.7-2.13-.09-2.91a2.18 2.18 0 0 0-2.91-.09z"/><path d="m12 15-3-3a22 22 0 0 1 2-3.95A12.88 12.88 0 0 1 22 2c0 2.72-.78 7.5-6 11a22.35 22.35 0 0 1-4 2z"/></svg>',
                                    '<svg class="w-12 h-12 text-rose-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="13.5" cy="6.5" r=".5" fill="currentColor"/><circle cx="17.5" cy="10.5" r=".5" fill="currentColor"/><circle cx="8.5" cy="7.5" r=".5" fill="currentColor"/><path d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10c.926 0 1.648-.746 1.648-1.688 0-.437-.18-.835-.437-1.125-.29-.289-.438-.652-.438-1.125a1.64 1.64 0 0 1 1.668-1.668h1.996c3.051 0 5.563-2.512 5.563-5.563C22 6.5 17.5 2 12 2z"/></svg>',
                                    '<svg class="w-12 h-12 text-orange-500" viewBox="0 0 24 24" fill="currentColor"><path d="M8.5 14.5A2.5 2.5 0 0 0 11 17c1.38 0 2.5-1.12 2.5-2.5 0-1.63-1.04-2.52-1.92-3.76-.7-1-1.33-2.19-1.33-3.74 0-1.12.35-2.07.92-2.92C7.38 5.72 5 9.06 5 13c0 3.87 3.13 7 7 7s7-3.13 7-7c0-2.61-1.07-4.5-2.25-5.91-.4.84-.75 1.73-.75 2.66 0 1.79 1.15 3.05 1.15 4.75 0 2.21-1.79 4-4 4-1.76 0-3.23-1.14-3.76-2.72-.08-.24-.26-.43-.5-.48-.25-.05-.5.05-.67.24-.13.15-.22.33-.22.56z"/></svg>'
                                ];
                            @endphp
                            <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-blue-50 to-indigo-100/70">
                                <div class="w-20 h-20 rounded-2xl bg-white/70 backdrop-blur-sm border border-white flex items-center justify-center shadow-sm">
                                    {!! $coverSvgs[$index % count($coverSvgs)] !!}
                                </div>
                            </div>
                        @endif

                        <div class="absolute top-3 right-3">
                            @if($course->is_completed ?? false)
                                <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-emerald-500 text-white shadow-sm flex items-center gap-1.5">
                                    <i class="fas fa-check-circle"></i> Selesai
                                </span>
                            @else
                                <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-[var(--blue)] text-white shadow-sm flex items-center gap-1.5">
                                    <i class="fas fa-play-circle"></i> Sedang Belajar
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Card Body -->
                    <div class="p-5 flex-1 flex flex-col justify-between">
                        <div>
                            <h2 class="text-base font-bold text-[var(--ink)] leading-snug mb-2 group-hover:text-[var(--blue)] transition-colors">
                                {{ $course->title }}
                            </h2>
                            <p class="text-xs text-[var(--muted)] line-clamp-2 leading-relaxed mb-4">
                                {{ $course->description }}
                            </p>
                        </div>

                        <!-- Progress Bar -->
                        <div class="pt-3 border-t border-[var(--border)]">
                            <div class="flex justify-between items-center text-xs mb-1.5 font-mono">
                                <span class="text-[var(--muted)] font-semibold text-[11px]">Progres Pembelajaran</span>
                                <span class="font-bold text-[var(--blue)]">{{ $course->progress ?? 0 }}%</span>
                            </div>
                            <div class="w-full h-2 rounded-full overflow-hidden bg-slate-100">
                                <div class="h-full rounded-full bg-[var(--blue)] transition-all duration-300" style="width: {{ $course->progress ?? 0 }}%;"></div>
                            </div>

                            @if($course->enrolled_at)
                                <div class="text-[10px] text-[var(--muted)] flex items-center gap-1.5 mt-3">
                                    <i class="fas fa-calendar-alt text-slate-400"></i>
                                    Terdaftar: {{ $course->enrolled_at->format('d M Y') }}
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Card Actions -->
                    <div class="p-4 bg-slate-50 border-t border-[var(--border)]">
                        @if($course->is_completed ?? false)
                            <div class="grid grid-cols-2 gap-2 mb-2">
                                <a href="{{ route('user.courses.learn', $course->id) }}" class="btn-outline text-center py-2 text-xs font-bold rounded-xl">
                                    <i class="fas fa-book-open mr-1"></i> Review
                                </a>
                                <a href="{{ route('user.courses.results', $course->id) }}" class="px-3 py-2 rounded-xl bg-emerald-50 hover:bg-emerald-100 text-emerald-700 border border-emerald-200 text-center text-xs font-bold transition">
                                    <i class="fas fa-certificate mr-1"></i> Sertifikat
                                </a>
                            </div>
                            <form action="{{ route('user.courses.retake', $course->id) }}" method="POST" onsubmit="return confirm('Mulai ulang kursus? Progres materi Anda akan direset.')">
                                @csrf
                                <button type="submit" class="w-full py-1.5 text-[11px] font-semibold text-[var(--muted)] hover:text-rose-600 transition flex items-center justify-center gap-1">
                                    <i class="fas fa-redo text-[9px]"></i> Reset Progres Belajar
                                </button>
                            </form>
                        @else
                            <a href="{{ route('user.courses.learn', $course->id) }}" class="btn-gradient w-full text-center py-2.5 text-xs font-bold text-white rounded-xl shadow-sm block">
                                <i class="fas fa-play mr-1.5"></i> Lanjutkan Belajar
                            </a>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
