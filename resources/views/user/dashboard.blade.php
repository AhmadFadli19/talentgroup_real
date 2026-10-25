@extends('layouts.app')

@section('title', 'Ruang Belajar | TalentGroup')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 py-6">
    
    @if(session('success'))
        <div class="mb-5 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs sm:text-sm flex items-center justify-between shadow-sm">
            <div class="flex items-center gap-3">
                <i class="fas fa-check-circle text-emerald-600 text-base flex-shrink-0"></i>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
            <button type="button" onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700 p-1">
                <i class="fas fa-times"></i>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-5 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-xs sm:text-sm flex items-center justify-between shadow-sm">
            <div class="flex items-center gap-3">
                <i class="fas fa-exclamation-triangle text-rose-600 text-base flex-shrink-0"></i>
                <span class="font-medium">{{ session('error') }}</span>
            </div>
            <button type="button" onclick="this.parentElement.remove()" class="text-rose-500 hover:text-rose-700 p-1">
                <i class="fas fa-times"></i>
            </button>
        </div>
    @endif

    <!-- Hero Welcome Banner -->
    <div class="cyber-card p-4 sm:p-6 md:p-8 mb-5 sm:mb-8 border border-[var(--border)] bg-white relative overflow-hidden" style="background: linear-gradient(135deg, #ffffff, #f0f7ff);">
        <div class="relative flex flex-col md:flex-row justify-between items-start md:items-center gap-4 sm:gap-6 z-10">
            <div class="flex items-start sm:items-center gap-3.5 sm:gap-5 w-full md:w-auto">
                <div class="w-12 h-12 sm:w-16 sm:h-16 rounded-2xl bg-[var(--blue-light)] flex items-center justify-center text-[var(--blue)] flex-shrink-0 shadow-sm border border-[#bfdbfe]">
                    <svg class="w-7 h-7 sm:w-9 sm:h-9" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 3L1 9L12 15L21 10.09V17H23V9L12 3Z"/>
                        <path d="M5 13.18V17.18C5 19.57 8.13 21.5 12 21.5C15.87 21.5 19 19.57 19 17.18V13.18L12 17L5 13.18Z" opacity="0.8"/>
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-center justify-between gap-2 flex-wrap mb-1.5 sm:mb-2">
                        <div class="inline-flex items-center gap-1.5 px-2.5 sm:px-3 py-0.5 sm:py-1 rounded-full text-[11px] sm:text-xs font-bold bg-[var(--blue-light)] text-[var(--blue)] border border-[#bfdbfe]">
                            <span>● Ruang Belajar TalentGroup</span>
                        </div>
                        <!-- Sleek date badge on mobile -->
                        <div class="inline-flex md:hidden items-center gap-1.5 px-2.5 py-0.5 rounded-lg text-[11px] font-bold font-mono bg-[var(--blue-light)] text-[var(--blue)] border border-[#bfdbfe]">
                            <i class="far fa-calendar-alt text-[10px]"></i>
                            <span>{{ now()->format('d M Y') }}</span>
                        </div>
                    </div>
                    <h1 class="text-xl sm:text-3xl font-extrabold text-[var(--ink)] tracking-tight">
                        Selamat Datang, {{ auth()->user()->name }}!
                    </h1>
                    <p class="text-xs sm:text-sm text-[var(--text2)] mt-1 max-w-xl leading-relaxed">
                        Tingkatkan keterampilan coding Anda, pelajari kurikulum industri, dan upload prototype karya Anda untuk di-hosting gratis permanen.
                    </p>
                </div>
            </div>
            
            <!-- Desktop Calendar Widget -->
            <div class="hidden md:flex items-center gap-3 flex-shrink-0">
                <div class="text-center px-5 py-3 rounded-2xl bg-white border border-[var(--border)] shadow-sm">
                    <div class="text-2xl font-black text-[var(--blue)] font-mono">{{ now()->format('d') }}</div>
                    <div class="text-[10px] tracking-wider uppercase font-bold text-[var(--muted)]">{{ now()->format('M Y') }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-2.5 sm:gap-6 mb-6 sm:mb-8">
        <div class="cyber-card bg-white border border-[var(--border)] p-3 sm:p-5 flex flex-col justify-between shadow-sm hover:border-[var(--blue)] transition-all">
            <div class="flex items-center justify-between mb-1.5 sm:mb-3">
                <span class="text-[10px] sm:text-xs font-bold text-[var(--muted)] uppercase tracking-wider truncate">
                    Total Kursus
                </span>
                <span class="w-6 h-6 sm:w-9 sm:h-9 rounded-lg sm:rounded-xl bg-blue-50 text-[var(--blue)] flex items-center justify-center text-[10px] sm:text-sm font-bold flex-shrink-0">
                    <i class="fas fa-book-open"></i>
                </span>
            </div>
            <div class="text-xl sm:text-3xl font-black text-[var(--ink)] font-mono leading-none my-1">{{ $totalCourses ?? 0 }}</div>
            <p class="text-[10px] sm:text-xs text-[var(--text2)] mt-0.5 sm:mt-1 truncate">
                Tersedia di katalog
            </p>
        </div>

        <div class="cyber-card bg-white border border-[var(--border)] p-3 sm:p-5 flex flex-col justify-between shadow-sm hover:border-amber-400 transition-all">
            <div class="flex items-center justify-between mb-1.5 sm:mb-3">
                <span class="text-[10px] sm:text-xs font-bold text-[var(--muted)] uppercase tracking-wider truncate">
                    Sedang Dipelajari
                </span>
                <span class="w-6 h-6 sm:w-9 sm:h-9 rounded-lg sm:rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-[10px] sm:text-sm font-bold flex-shrink-0">
                    <i class="fas fa-spinner"></i>
                </span>
            </div>
            <div class="text-xl sm:text-3xl font-black text-[var(--ink)] font-mono leading-none my-1">{{ $activeCourses ?? 0 }}</div>
            <p class="text-[10px] sm:text-xs text-[var(--text2)] mt-0.5 sm:mt-1 truncate">
                Dalam proses belajar
            </p>
        </div>

        <div class="cyber-card bg-white border border-[var(--border)] p-3 sm:p-5 flex flex-col justify-between shadow-sm hover:border-emerald-400 transition-all">
            <div class="flex items-center justify-between mb-1.5 sm:mb-3">
                <span class="text-[10px] sm:text-xs font-bold text-[var(--muted)] uppercase tracking-wider truncate">
                    Kursus Selesai
                </span>
                <span class="w-6 h-6 sm:w-9 sm:h-9 rounded-lg sm:rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-[10px] sm:text-sm font-bold flex-shrink-0">
                    <i class="fas fa-award"></i>
                </span>
            </div>
            <div class="text-xl sm:text-3xl font-black text-[var(--ink)] font-mono leading-none my-1">{{ $completedCourses ?? 0 }}</div>
            <p class="text-[10px] sm:text-xs text-[var(--text2)] mt-0.5 sm:mt-1 truncate">
                Telah terselesaikan
            </p>
        </div>

        <div class="cyber-card bg-white border border-[var(--border)] p-3 sm:p-5 flex flex-col justify-between shadow-sm hover:border-indigo-400 transition-all">
            <div class="flex items-center justify-between mb-1.5 sm:mb-3">
                <span class="text-[10px] sm:text-xs font-bold text-[var(--muted)] uppercase tracking-wider truncate">
                    Web Deployed
                </span>
                <span class="w-6 h-6 sm:w-9 sm:h-9 rounded-lg sm:rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-[10px] sm:text-sm font-bold flex-shrink-0">
                    <i class="fas fa-globe"></i>
                </span>
            </div>
            <div class="text-xl sm:text-3xl font-black text-[var(--ink)] font-mono leading-none my-1">{{ isset($userPrototypes) ? $userPrototypes->count() : 0 }}</div>
            <p class="text-[10px] sm:text-xs text-indigo-600 font-bold mt-0.5 sm:mt-1 truncate flex items-center gap-1">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span> Online Permanen
            </p>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 sm:gap-8 items-start mb-8">
        
        <!-- Left Column: Quick Actions & Recent Activities -->
        <div class="lg:col-span-1 flex flex-col gap-5 sm:gap-6">
            
            <!-- Quick Actions Panel -->
            <div class="cyber-card p-0 bg-white border border-[var(--border)] overflow-hidden shadow-sm">
                <div class="p-3.5 sm:p-4 border-b border-[var(--border)] bg-[var(--bg3)] flex items-center gap-2">
                    <i class="fas fa-bolt text-[var(--blue)]"></i>
                    <h2 class="text-sm font-bold text-[var(--ink)]">Menu Cepat</h2>
                </div>
                <div class="p-3.5 sm:p-4 flex flex-col gap-2 sm:gap-2.5">
                    <a href="{{ route('user.courses.index') }}" class="flex items-center justify-between p-3 rounded-xl border border-[var(--border)] hover:border-[var(--blue)] hover:bg-[var(--blue-light)] text-[var(--ink)] transition text-xs font-bold">
                        <span class="flex items-center gap-2.5">
                            <i class="fas fa-graduation-cap text-[var(--blue)]"></i> Jelajahi Kursus
                        </span>
                        <i class="fas fa-chevron-right text-xs text-[var(--muted)]"></i>
                    </a>
                    <a href="{{ route('user.prototypes.create') }}" class="flex items-center justify-between p-3 rounded-xl border border-[var(--border)] hover:border-[var(--blue)] hover:bg-[var(--blue-light)] text-[var(--ink)] transition text-xs font-bold">
                        <span class="flex items-center gap-2.5">
                            <i class="fas fa-cloud-upload-alt text-[var(--blue)]"></i> Upload & Deploy Web AI
                        </span>
                        <span class="pill success-outline text-[10px]">Gratis</span>
                    </a>
                    <a href="{{ route('modules.index') }}" class="flex items-center justify-between p-3 rounded-xl border border-[var(--border)] hover:border-[var(--blue)] hover:bg-[var(--blue-light)] text-[var(--ink)] transition text-xs font-bold">
                        <span class="flex items-center gap-2.5">
                            <i class="fas fa-book-reader text-[var(--blue)]"></i> Modul Dokumentasi
                        </span>
                        <i class="fas fa-chevron-right text-xs text-[var(--muted)]"></i>
                    </a>
                    <a href="{{ route('user.transactions.index') }}" class="flex items-center justify-between p-3 rounded-xl border border-[var(--border)] hover:border-[var(--blue)] hover:bg-[var(--blue-light)] text-[var(--ink)] transition text-xs font-bold">
                        <span class="flex items-center gap-2.5">
                            <i class="fas fa-history text-[var(--blue)]"></i> Histori Aktivitas
                        </span>
                        <i class="fas fa-chevron-right text-xs text-[var(--muted)]"></i>
                    </a>
                </div>
            </div>

            <!-- Recent Activity Panel -->
            <div class="cyber-card p-0 bg-white border border-[var(--border)] overflow-hidden shadow-sm">
                <div class="p-3.5 sm:p-4 border-b border-[var(--border)] bg-[var(--bg3)] flex items-center gap-2">
                    <i class="fas fa-clock text-[var(--blue)]"></i>
                    <h2 class="text-sm font-bold text-[var(--ink)]">Aktivitas Terkini</h2>
                </div>
                <div class="p-3.5 sm:p-4">
                    @if(isset($recentActivities) && count($recentActivities) > 0)
                        <div class="flex flex-col gap-2.5 sm:gap-3">
                            @foreach($recentActivities as $activity)
                                <div class="flex items-start gap-3 p-3 rounded-xl border border-[var(--border)] bg-[var(--bg3)]">
                                    <div class="mt-0.5 text-[var(--blue)]"><i class="fas fa-check-circle text-sm"></i></div>
                                    <div class="flex-1 min-w-0">
                                        <div class="text-xs font-bold text-[var(--ink)] truncate">{{ $activity['title'] }}</div>
                                        <div class="text-[10px] text-[var(--muted)] font-mono mt-0.5">{{ $activity['time'] }}</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5 sm:py-6">
                            <div class="text-2xl sm:text-3xl mb-1.5 sm:mb-2">⏱️</div>
                            <div class="text-xs font-bold text-[var(--ink)] mb-0.5">Belum Ada Aktivitas</div>
                            <p class="text-[11px] text-[var(--muted)]">Mulai belajar modul atau ikuti kuis untuk melihat histori.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Right Column: My Courses Progress -->
        <div class="lg:col-span-2">
            @if(isset($enrolledCourses) && count($enrolledCourses) > 0)
                <div class="cyber-card bg-white border border-[var(--border)] p-4 sm:p-6 shadow-sm">
                    <div class="flex justify-between items-center mb-5 sm:mb-6">
                        <div>
                            <h2 class="text-base font-bold text-[var(--ink)] flex items-center gap-2">
                                <i class="fas fa-laptop-code text-[var(--blue)]"></i>
                                Kursus yang Sedang Diikuti
                            </h2>
                            <p class="text-xs text-[var(--muted)] mt-0.5">Lanjutkan progres materi yang belum selesai.</p>
                        </div>
                        <a href="{{ route('user.courses.index') }}" class="text-xs font-bold text-[var(--blue)] hover:underline">
                            Lihat Semua →
                        </a>
                    </div>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-5">
                        @foreach($enrolledCourses as $index => $course)
                            <div class="p-4 sm:p-5 border border-[var(--border)] rounded-2xl bg-white hover:border-[var(--blue)] transition-all shadow-sm flex flex-col justify-between">
                                <div>
                                    <div class="flex justify-between items-start mb-3">
                                        @php
                                            $courseIcons = [
                                                '<svg class="w-5 h-5 text-blue-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/><path d="m10 9-2 2 2 2"/><path d="m14 9 2 2-2 2"/></svg>',
                                                '<svg class="w-5 h-5 text-amber-500" viewBox="0 0 24 24" fill="currentColor"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>',
                                                '<svg class="w-5 h-5 text-emerald-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>',
                                                '<svg class="w-5 h-5 text-purple-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4.5 16.5c-1.5 1.26-2 5-2 5s3.74-.5 5-2c.71-.84.7-2.13-.09-2.91a2.18 2.18 0 0 0-2.91-.09z"/><path d="m12 15-3-3a22 22 0 0 1 2-3.95A12.88 12.88 0 0 1 22 2c0 2.72-.78 7.5-6 11a22.35 22.35 0 0 1-4 2z"/></svg>',
                                                '<svg class="w-5 h-5 text-rose-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="13.5" cy="6.5" r=".5" fill="currentColor"/><circle cx="17.5" cy="10.5" r=".5" fill="currentColor"/><circle cx="8.5" cy="7.5" r=".5" fill="currentColor"/><path d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10c.926 0 1.648-.746 1.648-1.688 0-.437-.18-.835-.437-1.125-.29-.289-.438-.652-.438-1.125a1.64 1.64 0 0 1 1.668-1.668h1.996c3.051 0 5.563-2.512 5.563-5.563C22 6.5 17.5 2 12 2z"/></svg>',
                                                '<svg class="w-5 h-5 text-orange-500" viewBox="0 0 24 24" fill="currentColor"><path d="M8.5 14.5A2.5 2.5 0 0 0 11 17c1.38 0 2.5-1.12 2.5-2.5 0-1.63-1.04-2.52-1.92-3.76-.7-1-1.33-2.19-1.33-3.74 0-1.12.35-2.07.92-2.92C7.38 5.72 5 9.06 5 13c0 3.87 3.13 7 7 7s7-3.13 7-7c0-2.61-1.07-4.5-2.25-5.91-.4.84-.75 1.73-.75 2.66 0 1.79 1.15 3.05 1.15 4.75 0 2.21-1.79 4-4 4-1.76 0-3.23-1.14-3.76-2.72-.08-.24-.26-.43-.5-.48-.25-.05-.5.05-.67.24-.13.15-.22.33-.22.56z"/></svg>'
                                            ];
                                        @endphp
                                        <div class="w-10 h-10 rounded-xl bg-[var(--blue-light)] flex items-center justify-center border border-[var(--border)]">
                                            {!! $courseIcons[$index % count($courseIcons)] !!}
                                        </div>
                                        <span class="pill blue-soft text-[11px]">
                                            {{ $course->progress ?? 0 }}% Selesai
                                        </span>
                                    </div>
                                    <h3 class="font-bold text-sm text-[var(--ink)] mb-2 line-clamp-1" title="{{ $course->title }}">
                                        {{ $course->title }}
                                    </h3>
                                    
                                    <!-- Progress Bar -->
                                    <div class="w-full h-2 rounded-full bg-slate-100 overflow-hidden mb-3">
                                        <div class="h-full rounded-full bg-[var(--blue)] transition-all duration-500" style="width: {{ $course->progress ?? 0 }}%;"></div>
                                    </div>
                                </div>
                                
                                <div class="flex justify-between items-center mt-3 pt-3 border-t border-[var(--border)]">
                                    <span class="text-xs text-[var(--muted)] font-mono">
                                        {{ $course->completed_lessons ?? 0 }}/{{ $course->total_lessons ?? 0 }} Materi
                                    </span>
                                    <a href="{{ route('user.courses.show', $course->id) }}" class="btn btn-small btn-gradient">
                                        Lanjutkan <i class="fas fa-arrow-right text-[10px]"></i>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="empty-prototype-box flex flex-col items-center justify-center py-10 sm:py-16 text-center shadow-sm">
                    <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-2xl empty-icon-wrap flex items-center justify-center mb-3 sm:mb-4">
                        <svg class="w-7 h-7 sm:w-8 sm:h-8 text-[var(--blue)]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>
                            <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>
                            <path d="M8 7h8"/>
                            <path d="M8 11h6"/>
                        </svg>
                    </div>
                    <h2 class="text-base sm:text-lg font-bold text-[var(--ink)] mb-1 sm:mb-2">Belum Mengikuti Kursus</h2>
                    <p class="text-xs text-[var(--text2)] mb-5 sm:mb-6 max-w-sm px-4">
                        Anda belum mendaftar ke kursus apa pun. Jelajahi katalog kursus kami dan mulai belajar sekarang.
                    </p>
                    <a href="{{ route('user.courses.index') }}" class="btn btn-gradient">
                        <i class="fas fa-search mr-1.5"></i> Jelajahi Katalog Kursus
                    </a>
                </div>
            @endif
        </div>
        
    </div>

    <!-- ========================================================================= -->
    <!-- SECTION: WEBSITE PROTOTYPE YANG SUDAH DI-HOSTING / DEPLOY OLEH USER       -->
    <!-- ========================================================================= -->
    <div class="cyber-card p-4 sm:p-6 md:p-8 bg-white border border-[var(--border)] rounded-2xl shadow-sm mb-10">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-5 border-b border-[var(--border)] mb-6">
            <div>
                <div class="flex items-center gap-2 mb-1.5">
                    <span class="pill blue-soft text-[10px] uppercase font-bold tracking-wider">
                        <i class="fas fa-cloud-upload-alt mr-1"></i> Live Web Deployment
                    </span>
                    <span class="pill success-outline text-[10px] font-bold">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse mr-1"></span> Online Permanen
                    </span>
                </div>
                <h2 class="text-lg sm:text-2xl font-extrabold text-[var(--ink)] tracking-tight">
                    Website Prototype yang Anda Hosting
                </h2>
                <p class="text-xs sm:text-sm text-[var(--text2)] mt-0.5">
                    Website Anda online permanen hingga Anda menghapusnya sendiri. Dilengkapi hasil scan AI, audit performa kecepatan, serta tautan publik langsung.
                </p>
            </div>
            
            <a href="{{ route('user.prototypes.create') }}" class="btn btn-gradient text-xs flex items-center gap-1.5 self-start sm:self-auto shadow-sm">
                <i class="fas fa-plus"></i> Upload Web Baru
            </a>
        </div>

        @if(!isset($userPrototypes) || $userPrototypes->isEmpty())
            <!-- Empty State for Deployed Websites -->
            <div class="empty-prototype-box p-8 sm:p-12 text-center">
                <div class="w-16 h-16 rounded-2xl empty-icon-wrap flex items-center justify-center mx-auto text-2xl mb-4">
                    <i class="fas fa-laptop-code"></i>
                </div>
                <h3 class="text-base sm:text-lg font-bold mb-1.5">Belum Ada Website yang Di-hosting</h3>
                <p class="text-xs sm:text-sm max-w-lg mx-auto mb-6 leading-relaxed">
                    Unggah karya web Anda (bisa berupa presentasi slide HTML, portfolio, aplikasi web statis via ZIP maupun berkas terpisah). Sistem AI kami akan otomatis memindai kecepatan & kerapihan kode, lalu memberikan <strong>hosting gratis permanen</strong> dengan tautan publik!
                </p>
                <div class="flex flex-wrap items-center justify-center gap-3">
                    <a href="{{ route('user.prototypes.create') }}" class="btn btn-gradient text-xs">
                        <i class="fas fa-cloud-upload-alt mr-1.5"></i> Mulai Upload & Deploy Sekarang
                    </a>
                </div>
            </div>
        @else
            <!-- Grid of Deployed Prototypes -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5 sm:gap-6">
                @foreach($userPrototypes as $proto)
                    @php
                        $report = $proto->ai_report_json ?? [];
                        $categories = $report['categories'] ?? [];
                        $perfScore = $categories['performance']['score'] ?? $proto->ai_score;
                        $issues = [];
                        $recommendations = [];
                        foreach ($categories as $cat) {
                            if (!empty($cat['issues'])) {
                                $issues = array_merge($issues, $cat['issues']);
                            }
                            if (!empty($cat['recommendations'])) {
                                $recommendations = array_merge($recommendations, $cat['recommendations']);
                            }
                        }
                    @endphp

                    <div class="cyber-card p-4 sm:p-5 bg-white border border-[var(--border)] hover:border-[var(--blue)] transition-all rounded-2xl shadow-sm flex flex-col justify-between group">
                        <div>
                            <!-- Header Badges -->
                            <div class="flex items-center justify-between gap-2 mb-3">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold {{ $proto->is_active ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-rose-50 text-rose-700 border border-rose-200' }}" title="Web ini aktif terus menerus hingga Anda menghapusnya">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $proto->is_active ? 'bg-emerald-500' : 'bg-rose-500' }}"></span>
                                    {{ $proto->is_active ? 'Online Permanen' : 'Ditangguhkan' }}
                                </span>

                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-bold font-mono bg-blue-50 text-[var(--blue)] border border-blue-200">
                                    <i class="fas fa-shield-check text-[9px]"></i> Skor AI: {{ $proto->ai_score }}/100
                                </span>
                            </div>

                            <!-- Mockup Browser Bar (Domain & URL) -->
                            <div class="rounded-xl border border-[var(--border)] overflow-hidden mb-3 bg-[#f8fafc]">
                                <div class="flex items-center gap-1.5 px-3 py-1.5 bg-slate-100 border-b border-[var(--border)]">
                                    <span class="w-2 h-2 rounded-full bg-rose-400"></span>
                                    <span class="w-2 h-2 rounded-full bg-amber-400"></span>
                                    <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                                    <span class="text-[9px] font-mono font-bold text-slate-500 ml-1 truncate">
                                        {{ request()->getHost() }}
                                    </span>
                                </div>
                                <div class="p-2.5 flex items-center justify-between gap-2 text-xs font-mono">
                                    <a href="{{ $proto->url }}" target="_blank" class="text-[var(--blue)] font-bold truncate hover:underline" title="Buka tautan website">
                                        /p/{{ $proto->slug }}
                                    </a>
                                    <button type="button" onclick="copyUrl('{{ $proto->url }}')" class="p-1 rounded text-slate-400 hover:text-[var(--blue)] hover:bg-white transition flex-shrink-0" title="Salin URL Lengkap">
                                        <i class="fas fa-copy"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Project Title & Meta -->
                            <div class="mb-3">
                                <h3 class="text-sm sm:text-base font-extrabold text-[var(--ink)] line-clamp-1" title="{{ $proto->project_name }}">
                                    {{ $proto->project_name }}
                                </h3>
                                <p class="text-[11px] text-[var(--muted)] font-mono mt-0.5">
                                    Deploy: {{ $proto->created_at->format('d M Y') }} &middot; 
                                    <span class="capitalize">{{ $proto->upload_type === 'zip_archive' ? 'Paket .ZIP' : 'Multi-File Manual' }}</span>
                                </p>
                            </div>

                            <!-- Speed & AI Metric Pills -->
                            <div class="p-3 rounded-xl bg-[var(--bg3)] border border-[var(--border)] mb-4 space-y-2">
                                <div class="flex items-center justify-between text-xs">
                                    <span class="font-bold text-[var(--ink)] flex items-center gap-1.5">
                                        <i class="fas fa-tachometer-alt text-amber-500"></i> Kecepatan Web:
                                    </span>
                                    @if($perfScore >= 85)
                                        <span class="text-emerald-700 font-bold font-mono text-[11px]">Sangat Cepat (&lt;0.5s) 🚀</span>
                                    @elseif($perfScore >= 70)
                                        <span class="text-blue-700 font-bold font-mono text-[11px]">Cepat (&lt;1.2s) ⚡</span>
                                    @else
                                        <span class="text-amber-700 font-bold font-mono text-[11px]">Perlu Optimasi ⏳</span>
                                    @endif
                                </div>

                                <!-- AI Scan Summary Alert -->
                                <div class="text-[11px] text-[var(--text2)] leading-relaxed pt-1 border-t border-[var(--border)]">
                                    @if(count($issues) > 0)
                                        <span class="text-amber-700 font-medium flex items-center gap-1">
                                            <i class="fas fa-info-circle text-amber-500 text-[10px]"></i>
                                            Ada {{ count($issues) }} kekurangan kode yang bisa dioptimalkan.
                                        </span>
                                    @else
                                        <span class="text-emerald-700 font-medium flex items-center gap-1">
                                            <i class="fas fa-check-circle text-emerald-500 text-[10px]"></i>
                                            Struktur kode bersih &amp; optimal.
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons Bar -->
                        <div class="pt-3 border-t border-[var(--border)] flex flex-wrap items-center justify-between gap-2">
                            <!-- Detail AI Scan Modal Button -->
                            <button type="button" onclick="openAiScanModal({{ $proto->id }})" class="btn btn-small btn-outline text-xs flex items-center gap-1 py-1.5 px-2.5" title="Lihat penjelasan scan AI, skor kecepatan & kekurangan web">
                                <i class="fas fa-brain text-[var(--blue)]"></i> Scan AI
                            </button>

                            <div class="flex items-center gap-1.5">
                                <!-- View Live Button -->
                                <a href="{{ $proto->url }}" target="_blank" class="btn btn-small btn-gradient text-xs py-1.5 px-3 flex items-center gap-1" title="Buka website di tab baru">
                                    <i class="fas fa-external-link-alt text-[10px]"></i> Buka
                                </a>

                                <!-- Edit Button -->
                                <button type="button" onclick="openEditPrototypeModal({{ $proto->id }}, '{{ addslashes($proto->project_name) }}', '{{ $proto->slug }}')" class="p-2 rounded-lg text-slate-500 hover:text-[var(--blue)] hover:bg-[var(--blue-light)] transition" title="Edit Nama &amp; Slug atau Ganti File">
                                    <i class="fas fa-edit text-xs"></i>
                                </button>

                                <!-- Delete Form -->
                                <form action="{{ route('user.prototypes.destroy', $proto->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus website prototype \'{{ addslashes($proto->project_name) }}\'? Seluruh berkas hosting akan dihapus secara permanen.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 rounded-lg text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition" title="Hapus Website Permanen">
                                        <i class="fas fa-trash-alt text-xs"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

</div>

<!-- ========================================================================= -->
<!-- MODAL 1: DETAIL SCAN AI & AUDIT KECEPATAN LENGKAP                         -->
<!-- ========================================================================= -->
<div id="ai-scan-modal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 flex items-center justify-center p-3 sm:p-4 hidden">
    <div class="max-w-2xl w-full bg-white border border-[var(--border)] rounded-2xl p-5 sm:p-7 shadow-2xl relative max-h-[90vh] overflow-y-auto">
        <!-- Modal Header -->
        <div class="flex items-center justify-between pb-4 border-b border-[var(--border)] mb-4">
            <div class="flex items-center gap-2.5">
                <div class="w-9 h-9 rounded-xl bg-[var(--blue-light)] text-[var(--blue)] flex items-center justify-center text-lg border border-[#bfdbfe]">
                    <i class="fas fa-brain"></i>
                </div>
                <div>
                    <h3 class="text-sm sm:text-base font-extrabold text-[var(--ink)]" id="scan-modal-title">Laporan Scan AI &amp; Kecepatan Web</h3>
                    <p class="text-[11px] text-[var(--muted)] font-mono" id="scan-modal-url"></p>
                </div>
            </div>
            <button type="button" onclick="closeAiScanModal()" class="text-[var(--muted)] hover:text-[var(--ink)] p-1.5 text-base">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <!-- Modal Content Container -->
        <div id="scan-modal-body" class="space-y-4">
            <div class="text-center py-10">
                <i class="fas fa-spinner fa-spin text-2xl text-[var(--blue)]"></i>
                <p class="text-xs text-[var(--muted)] mt-2 font-medium">Memuat data audit AI &amp; kecepatan...</p>
            </div>
        </div>
    </div>
</div>

<!-- ========================================================================= -->
<!-- MODAL 2: EDIT WEBSITE PROTOTYPE (NAMA, SLUG & FILE UPDATE)                -->
<!-- ========================================================================= -->
<div id="edit-prototype-modal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 flex items-center justify-center p-3 sm:p-4 hidden">
    <div class="max-w-lg w-full bg-white border border-[var(--border)] rounded-2xl p-5 sm:p-7 shadow-2xl relative max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between pb-3.5 border-b border-[var(--border)] mb-4">
            <div class="flex items-center gap-2">
                <i class="fas fa-edit text-[var(--blue)] text-base"></i>
                <h3 class="text-sm sm:text-base font-extrabold text-[var(--ink)]">Edit Website Prototype</h3>
            </div>
            <button type="button" onclick="closeEditPrototypeModal()" class="text-[var(--muted)] hover:text-[var(--ink)] p-1 text-base">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <form id="edit-prototype-form" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="space-y-4 mb-5">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-[var(--ink)] mb-1" for="edit_project_name">
                        Nama Prototype <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="project_name" id="edit_project_name" required class="cyber-input text-xs sm:text-sm py-2.5 px-3 font-medium rounded-xl">
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-[var(--ink)] mb-1" for="edit_slug">
                        Slug URL Hosting <span class="text-rose-500">*</span>
                    </label>
                    <div class="flex items-center gap-2">
                        <div class="flex-1 flex items-center border border-[var(--border)] rounded-xl overflow-hidden bg-[var(--bg3)] px-3 py-2 text-xs font-mono">
                            <span class="text-[var(--muted)] flex-shrink-0">/p/</span>
                            <input type="text" name="slug" id="edit_slug" required class="bg-transparent border-0 outline-none w-full text-[var(--ink)] font-bold font-mono pl-1" oninput="checkSlugLive()">
                        </div>
                    </div>
                    <p id="edit-slug-feedback" class="text-[11px] mt-1 text-[var(--muted)] font-mono"></p>
                </div>

                <!-- Optional File Replacement Section -->
                <div class="pt-2 border-t border-[var(--border)]">
                    <label class="block text-xs font-bold uppercase tracking-wider text-[var(--ink)] mb-1">
                        Ganti Berkas / Update Kode (Opsional)
                    </label>
                    <p class="text-[11px] text-[var(--muted)] mb-3 leading-relaxed">
                        Biarkan kosong jika hanya ingin mengubah nama atau slug URL. Unggah file baru jika ingin memperbarui seluruh isi website Anda.
                    </p>

                    <div class="space-y-3 p-3.5 rounded-xl bg-[var(--bg3)] border border-[var(--border)]">
                        <div>
                            <label class="text-[11px] font-bold text-[var(--ink)] block mb-1">
                                Opsi A: Ganti dengan Paket .ZIP Baru
                            </label>
                            <input type="file" name="zip_file" accept=".zip" class="w-full text-xs text-[var(--text2)]">
                        </div>

                        <div class="pt-2 border-t border-[var(--border)]">
                            <label class="text-[11px] font-bold text-[var(--ink)] block mb-1">
                                Opsi B: Ganti dengan HTML Utama (.html)
                            </label>
                            <input type="file" name="html_file" accept=".html,.htm" class="w-full text-xs text-[var(--text2)]">
                        </div>

                        <div>
                            <label class="text-[11px] font-bold text-[var(--ink)] block mb-1">
                                File Slide &amp; Berkas Tambahan (Multi-file)
                            </label>
                            <input type="file" name="additional_files[]" multiple class="w-full text-xs text-[var(--text2)]">
                        </div>
                    </div>
                </div>
            </div>

            <div class="pt-3 border-t border-[var(--border)] flex justify-end items-center gap-2">
                <button type="button" onclick="closeEditPrototypeModal()" class="btn btn-small btn-outline text-xs">
                    Batal
                </button>
                <button type="submit" class="btn btn-small btn-gradient text-xs">
                    <i class="fas fa-save mr-1"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function copyUrl(text) {
        if (navigator.clipboard && window.isSecureContext) {
            navigator.clipboard.writeText(text).then(() => {
                showToast('Tautan disalin ke papan klip: ' + text);
            }).catch(() => fallbackCopy(text));
        } else {
            fallbackCopy(text);
        }
    }

    function fallbackCopy(text) {
        const textarea = document.createElement('textarea');
        textarea.value = text;
        textarea.style.position = 'fixed';
        textarea.style.left = '-9999px';
        document.body.appendChild(textarea);
        textarea.select();
        try {
            document.execCommand('copy');
            showToast('Tautan disalin: ' + text);
        } catch (e) {
            alert('Tautan website: ' + text);
        }
        document.body.removeChild(textarea);
    }

    function showToast(msg) {
        const toast = document.createElement('div');
        toast.className = 'fixed bottom-5 right-5 z-50 px-4 py-2.5 rounded-xl bg-slate-900 text-white text-xs font-bold shadow-2xl flex items-center gap-2 border border-slate-700 animate-bounce';
        toast.innerHTML = `<i class="fas fa-check-circle text-emerald-400"></i> <span>${msg}</span>`;
        document.body.appendChild(toast);
        setTimeout(() => {
            toast.remove();
        }, 3000);
    }

    // AI SCAN MODAL LOGIC
    async function openAiScanModal(id) {
        const modal = document.getElementById('ai-scan-modal');
        const body = document.getElementById('scan-modal-body');
        modal.classList.remove('hidden');

        try {
            const res = await fetch(`/user/prototypes/${id}/report`);
            const data = await res.json();

            if (!data.success) {
                body.innerHTML = `<p class="text-xs text-rose-600 p-4 font-bold">Gagal memuat rincian laporan: ${data.message || 'Data tidak tersedia'}</p>`;
                return;
            }

            document.getElementById('scan-modal-title').innerText = `${data.project_name}`;
            document.getElementById('scan-modal-url').innerText = data.url;

            const rep = data.report || {};
            const categories = rep.categories || {};
            const perf = categories.performance || {};
            const perfScore = perf.score ?? data.score;
            const seo = categories.seo || {};
            const sec = categories.security || {};
            const codeErr = categories.code_errors || {};
            const bestPrac = categories.best_practices || {};

            // Gather all issues and recommendations
            let allIssues = [];
            let allRecs = [];
            for (const [catName, catData] of Object.entries(categories)) {
                if (catData.issues && catData.issues.length) {
                    catData.issues.forEach(issue => allIssues.push({ category: catName, text: issue }));
                }
                if (catData.recommendations && catData.recommendations.length) {
                    catData.recommendations.forEach(rec => allRecs.push({ category: catName, text: rec }));
                }
            }

            let speedText = 'Sangat Cepat (&lt; 0.5s) 🚀';
            let speedColor = 'text-emerald-700 bg-emerald-50 border-emerald-200';
            if (perfScore < 70) {
                speedText = 'Perlu Optimasi ⏳';
                speedColor = 'text-amber-700 bg-amber-50 border-amber-200';
            } else if (perfScore < 85) {
                speedText = 'Cepat (&lt; 1.2s) ⚡';
                speedColor = 'text-blue-700 bg-blue-50 border-blue-200';
            }

            let html = `
                <!-- Top Summary Card -->
                <div class="p-4 rounded-2xl bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 flex flex-wrap items-center justify-between gap-3">
                    <div>
                        <span class="text-[11px] font-bold text-[var(--muted)] uppercase tracking-wider">Skor Audit AI Keseluruhan</span>
                        <div class="text-3xl font-black text-[var(--blue)] font-mono leading-none mt-1">
                            ${data.score} <span class="text-base text-[var(--muted)] font-normal">/ 100</span>
                        </div>
                    </div>
                    <div class="flex flex-col items-end gap-1">
                        <span class="px-3 py-1 rounded-full text-xs font-bold border ${speedColor}">
                            ${speedText}
                        </span>
                        <span class="text-[10px] text-[var(--muted)] font-mono">Evaluator: ${data.provider || 'AI Code Assessor'}</span>
                    </div>
                </div>

                <!-- Evaluator Summary -->
                <div class="p-3.5 rounded-xl bg-slate-50 border border-[var(--border)] text-xs text-[var(--text2)] leading-relaxed">
                    <strong class="text-[var(--ink)] block mb-1"><i class="fas fa-quote-left text-[var(--blue)] mr-1"></i> Ringkasan Evaluasi AI:</strong>
                    ${rep.verdict_summary || 'Kode prototype telah lolos audit standar website modern dan siap diakses publik.'}
                </div>

                <!-- Metrics Grid -->
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-2.5">
                    <div class="p-3 rounded-xl border border-[var(--border)] bg-white text-center">
                        <div class="text-[10px] font-bold text-[var(--muted)] uppercase">Kecepatan</div>
                        <div class="text-lg font-black text-amber-600 font-mono mt-0.5">${perf.score ?? data.score}%</div>
                    </div>
                    <div class="p-3 rounded-xl border border-[var(--border)] bg-white text-center">
                        <div class="text-[10px] font-bold text-[var(--muted)] uppercase">SEO &amp; Meta</div>
                        <div class="text-lg font-black text-blue-600 font-mono mt-0.5">${seo.score ?? 85}%</div>
                    </div>
                    <div class="p-3 rounded-xl border border-[var(--border)] bg-white text-center">
                        <div class="text-[10px] font-bold text-[var(--muted)] uppercase">Keamanan</div>
                        <div class="text-lg font-black text-emerald-600 font-mono mt-0.5">${sec.score ?? 95}%</div>
                    </div>
                    <div class="p-3 rounded-xl border border-[var(--border)] bg-white text-center">
                        <div class="text-[10px] font-bold text-[var(--muted)] uppercase">Standar Kode</div>
                        <div class="text-lg font-black text-indigo-600 font-mono mt-0.5">${bestPrac.score ?? 85}%</div>
                    </div>
                </div>

                <!-- SECTION: APA YANG KURANG (ISSUES) -->
                <div class="p-4 rounded-xl border border-amber-200 bg-amber-50/50">
                    <h4 class="text-xs font-bold text-amber-900 uppercase tracking-wider mb-2 flex items-center gap-1.5">
                        <i class="fas fa-exclamation-circle text-amber-600"></i> Apa yang Kurang dari Web Ini (${allIssues.length} Hal Ditemukan)
                    </h4>
            `;

            if (allIssues.length > 0) {
                html += `<ul class="space-y-1.5 text-xs text-amber-900">`;
                allIssues.forEach(item => {
                    html += `
                        <li class="flex items-start gap-2 bg-white p-2 rounded-lg border border-amber-100">
                            <i class="fas fa-arrow-right text-[10px] text-amber-500 mt-1 flex-shrink-0"></i>
                            <span><strong>[${item.category.toUpperCase()}]:</strong> ${item.text}</span>
                        </li>
                    `;
                });
                html += `</ul>`;
            } else {
                html += `<p class="text-xs text-emerald-700 font-medium">Tidak ada kekurangan signifikan yang terdeteksi. Kode sangat rapi dan memenuhi standar!</p>`;
            }

            html += `
                </div>

                <!-- SECTION: REKOMENDASI PERBAIKAN -->
                <div class="p-4 rounded-xl border border-blue-200 bg-blue-50/40">
                    <h4 class="text-xs font-bold text-[var(--blue)] uppercase tracking-wider mb-2 flex items-center gap-1.5">
                        <i class="fas fa-lightbulb text-amber-500"></i> Rekomendasi Solusi &amp; Peningkatan
                    </h4>
            `;

            if (allRecs.length > 0) {
                html += `<ul class="space-y-1.5 text-xs text-[var(--text2)]">`;
                allRecs.forEach(item => {
                    html += `
                        <li class="flex items-start gap-2 bg-white p-2 rounded-lg border border-blue-100">
                            <i class="fas fa-check text-[10px] text-emerald-500 mt-1 flex-shrink-0"></i>
                            <span>${item.text}</span>
                        </li>
                    `;
                });
                html += `</ul>`;
            } else {
                html += `<p class="text-xs text-[var(--text2)]">Pertahankan struktur kode yang telah dibuat. Web siap diperkenalkan!</p>`;
            }

            html += `</div>`;

            body.innerHTML = html;

        } catch (e) {
            body.innerHTML = `<p class="text-xs text-rose-600 p-4 font-bold">Terjadi kesalahan koneksi saat memuat audit AI.</p>`;
        }
    }

    function closeAiScanModal() {
        document.getElementById('ai-scan-modal').classList.add('hidden');
    }

    // EDIT PROTOTYPE MODAL LOGIC
    let currentEditId = null;

    function openEditPrototypeModal(id, projectName, slug) {
        currentEditId = id;
        const modal = document.getElementById('edit-prototype-modal');
        const form = document.getElementById('edit-prototype-form');
        form.action = `/user/prototypes/${id}`;
        
        document.getElementById('edit_project_name').value = projectName;
        document.getElementById('edit_slug').value = slug;
        document.getElementById('edit-slug-feedback').innerHTML = `<span class="text-emerald-600"><i class="fas fa-check"></i> Slug saat ini aktif</span>`;

        modal.classList.remove('hidden');
    }

    function closeEditPrototypeModal() {
        document.getElementById('edit-prototype-modal').classList.add('hidden');
        currentEditId = null;
    }

    let slugDebounce = null;
    function checkSlugLive() {
        clearTimeout(slugDebounce);
        const slug = document.getElementById('edit_slug').value.trim();
        const feedback = document.getElementById('edit-slug-feedback');
        
        if (!slug) {
            feedback.innerHTML = `<span class="text-rose-600">Slug tidak boleh kosong</span>`;
            return;
        }

        feedback.innerHTML = `<span class="text-slate-400"><i class="fas fa-spinner fa-spin"></i> Memeriksa ketersediaan slug...</span>`;

        slugDebounce = setTimeout(async () => {
            try {
                const res = await fetch(`/user/prototypes/check-slug?slug=${encodeURIComponent(slug)}&current_id=${currentEditId}`);
                const data = await res.json();
                if (data.available) {
                    feedback.innerHTML = `<span class="text-emerald-600 font-bold"><i class="fas fa-check-circle"></i> Slug tersedia untuk web Anda!</span>`;
                } else {
                    feedback.innerHTML = `<span class="text-rose-600 font-bold"><i class="fas fa-times-circle"></i> ${data.message}</span>`;
                }
            } catch (e) {
                feedback.innerHTML = `<span class="text-amber-600">Gagal memeriksa slug.</span>`;
            }
        }, 350);
    }
</script>
@endsection