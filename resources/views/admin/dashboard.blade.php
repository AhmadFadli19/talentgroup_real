@extends('layouts.app')

@section('title', 'Dashboard Admin | TalentGroup')

@section('content')

<div class="max-w-7xl mx-auto px-4 sm:px-6 py-6">

    <!-- HEADER BANNER -->
    <div class="cyber-card p-4 sm:p-6 md:p-8 mb-5 sm:mb-8 admin-header-banner border border-[var(--border)] shadow-sm rounded-2xl">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 sm:gap-6">
            <div class="flex items-start sm:items-center gap-3.5 sm:gap-5">
                <div class="w-12 h-12 sm:w-16 sm:h-16 rounded-2xl bg-[var(--blue-light)] text-[var(--blue)] flex items-center justify-center text-2xl sm:text-3xl flex-shrink-0 border border-[#bfdbfe] shadow-sm">
                    <i class="fas fa-user-shield"></i>
                </div>
                <div>
                    <div class="inline-flex items-center gap-1.5 px-2.5 sm:px-3 py-0.5 sm:py-1 rounded-full text-[11px] sm:text-xs font-bold bg-[var(--blue-light)] text-[var(--blue)] border border-[#bfdbfe] mb-1.5 sm:mb-2">
                        <span>● Panel Kendali Administrator</span>
                    </div>
                    <h1 class="text-xl sm:text-3xl font-extrabold text-[var(--ink)] tracking-tight">
                        Dashboard Admin TalentGroup
                    </h1>
                    <p class="text-xs sm:text-sm text-[var(--text2)] mt-0.5 max-w-2xl leading-relaxed">
                        Kelola kursus, modul dokumentasi, prototype peserta, dan pantau metrik platform secara real-time.
                    </p>
                </div>
            </div>
            
            <div class="text-left md:text-right flex items-center justify-between md:block pt-2 md:pt-0 border-t md:border-t-0 border-[var(--border)]">
                <div class="text-[10px] sm:text-[11px] uppercase tracking-wider font-bold text-[var(--muted)]">Status Server</div>
                <div class="text-[11px] sm:text-xs font-bold mt-1 inline-flex items-center gap-2 text-emerald-700 bg-emerald-50 px-2.5 sm:px-3 py-1 rounded-full border border-emerald-200">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    Sistem Online & Terproteksi
                </div>
            </div>
        </div>
    </div>

    <!-- STATS METRICS -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-6 mb-6 sm:mb-8">
        <div class="cyber-card p-3.5 sm:p-5 bg-white border border-[var(--border)] shadow-sm rounded-2xl flex flex-col justify-between hover:border-[var(--blue)] transition-all">
            <div class="flex justify-between items-start mb-2 sm:mb-3">
                <div class="min-w-0 pr-1">
                    <span class="text-[10px] sm:text-xs font-bold text-[var(--muted)] uppercase tracking-wider block mb-0.5 sm:mb-1 truncate">Total Siswa</span>
                    <div class="text-xl sm:text-3xl font-black font-mono text-[var(--ink)] leading-none">{{ number_format($stats['total_users']) }}</div>
                </div>
                <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-xl bg-blue-50 text-[var(--blue)] flex items-center justify-center text-xs sm:text-base border border-blue-100 flex-shrink-0">
                    <i class="fas fa-users"></i>
                </div>
            </div>
            <div class="text-[10px] sm:text-[11px] font-bold text-emerald-700 flex items-center gap-1 mt-1 truncate">
                <i class="fas fa-check-circle text-[10px]"></i> Terdaftar di database
            </div>
        </div>

        <div class="cyber-card p-3.5 sm:p-5 bg-white border border-[var(--border)] shadow-sm rounded-2xl flex flex-col justify-between hover:border-purple-400 transition-all">
            <div class="flex justify-between items-start mb-2 sm:mb-3">
                <div class="min-w-0 pr-1">
                    <span class="text-[10px] sm:text-xs font-bold text-[var(--muted)] uppercase tracking-wider block mb-0.5 sm:mb-1 truncate">Total Kursus</span>
                    <div class="text-xl sm:text-3xl font-black font-mono text-[var(--ink)] leading-none">{{ number_format($stats['total_courses']) }}</div>
                </div>
                <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center text-xs sm:text-base border border-purple-100 flex-shrink-0">
                    <i class="fas fa-book-open"></i>
                </div>
            </div>
            <div class="text-[10px] sm:text-[11px] font-bold text-[var(--blue)] mt-1 truncate">
                {{ number_format($stats['active_courses']) }} Kursus Aktif
            </div>
        </div>

        <div class="cyber-card p-3.5 sm:p-5 bg-white border border-[var(--border)] shadow-sm rounded-2xl flex flex-col justify-between hover:border-amber-400 transition-all">
            <div class="flex justify-between items-start mb-2 sm:mb-3">
                <div class="min-w-0 pr-1">
                    <span class="text-[10px] sm:text-xs font-bold text-[var(--muted)] uppercase tracking-wider block mb-0.5 sm:mb-1 truncate">Pendaftaran Siswa</span>
                    <div class="text-xl sm:text-3xl font-black font-mono text-[var(--ink)] leading-none">{{ number_format($stats['total_enrollments']) }}</div>
                </div>
                <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-xs sm:text-base border border-amber-100 flex-shrink-0">
                    <i class="fas fa-graduation-cap"></i>
                </div>
            </div>
            <div class="text-[10px] sm:text-[11px] font-bold text-[var(--muted)] mt-1 truncate">
                Akses Materi Aktif
            </div>
        </div>

        <div class="cyber-card p-3.5 sm:p-5 bg-white border border-[var(--border)] shadow-sm rounded-2xl flex flex-col justify-between hover:border-emerald-400 transition-all">
            <div class="flex justify-between items-start mb-2 sm:mb-3">
                <div class="min-w-0 pr-1">
                    <span class="text-[10px] sm:text-xs font-bold text-[var(--muted)] uppercase tracking-wider block mb-0.5 sm:mb-1 truncate">Total Transaksi</span>
                    <div class="text-lg sm:text-2xl font-black font-mono text-emerald-700 leading-none truncate">Rp {{ number_format($stats['total_revenue']) }}</div>
                </div>
                <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xs sm:text-base border border-emerald-100 flex-shrink-0">
                    <i class="fas fa-wallet"></i>
                </div>
            </div>
            <div class="text-[10px] sm:text-[11px] font-bold text-emerald-700 flex items-center gap-1 mt-1 truncate">
                <i class="fas fa-shield-alt text-[10px]"></i> Terverifikasi
            </div>
        </div>
    </div>

    <!-- MAIN GRID SECTION -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8 items-start">

        <!-- QUICK ACTION SHORTCUTS -->
        <div class="cyber-card p-6 bg-white border border-[var(--border)] shadow-sm flex flex-col gap-3">
            <h2 class="text-xs font-bold uppercase tracking-wider text-[var(--muted)] pb-2 border-b border-[var(--border)] flex items-center gap-2">
                <i class="fas fa-cogs text-[var(--blue)]"></i> Menu Manajemen
            </h2>
            <a href="{{ route('admin.courses.create') }}" class="btn btn-gradient text-xs justify-start py-3">
                <i class="fas fa-plus mr-1"></i> Tambah Kursus Baru
            </a>
            <a href="{{ route('admin.courses.index') }}" class="btn btn-outline text-xs justify-start py-2.5">
                <i class="fas fa-layer-group text-[var(--blue)] mr-1"></i> Kelola Daftar Kursus
            </a>
            <a href="{{ route('admin.modules.index') }}" class="btn btn-outline text-xs justify-start py-2.5">
                <i class="fas fa-book-reader text-[var(--blue)] mr-1"></i> Kelola Modul (Docs)
            </a>
            <a href="{{ route('admin.prototypes.index') }}" class="btn btn-outline text-xs justify-start py-2.5">
                <i class="fas fa-cube text-[var(--blue)] mr-1"></i> Kelola Prototype Siswa
            </a>
            <a href="{{ route('admin.referral-codes.index') }}" class="btn btn-outline text-xs justify-start py-2.5">
                <i class="fas fa-ticket-alt text-[var(--blue)] mr-1"></i> Kelola Kode Referral
            </a>
        </div>

        <!-- RECENT REGISTERED USERS -->
        <div class="cyber-card p-0 bg-white border border-[var(--border)] shadow-sm overflow-hidden flex flex-col">
            <div class="p-4 border-b border-[var(--border)] bg-[var(--bg3)] flex items-center justify-between">
                <h2 class="text-xs font-bold uppercase tracking-wider text-[var(--ink)] flex items-center gap-2">
                    <i class="fas fa-users text-[var(--blue)]"></i> Siswa Terdaftar Baru
                </h2>
                <span class="text-[10px] text-[var(--muted)] font-mono font-bold">{{ count($stats['recent_users']) }} Data</span>
            </div>
            <div class="p-4 flex-1 flex flex-col gap-2 overflow-y-auto max-h-[300px]">
                @forelse($stats['recent_users'] as $user)
                    <div class="flex items-center justify-between p-2.5 rounded-xl border border-[var(--border)] bg-slate-50/50 hover:bg-[var(--blue-light)]/40 transition">
                        <div class="flex items-center gap-3 min-w-0">
                            <div class="w-8 h-8 rounded-full bg-[var(--blue-light)] text-[var(--blue)] border border-[#bfdbfe] flex items-center justify-center font-bold text-xs flex-shrink-0">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <div class="min-w-0">
                                <div class="text-xs font-bold text-[var(--ink)] truncate">{{ $user->name }}</div>
                                <div class="text-[10px] text-[var(--muted)] truncate font-mono">{{ $user->email }}</div>
                            </div>
                        </div>
                        <span class="text-[10px] font-mono text-[var(--muted)] ml-2 flex-shrink-0">
                            {{ $user->created_at->diffForHumans() }}
                        </span>
                    </div>
                @empty
                    <div class="text-center py-8 text-xs text-[var(--muted)]">Belum ada siswa terdaftar baru.</div>
                @endforelse
            </div>
        </div>

        <!-- POPULAR COURSES -->
        <div class="cyber-card p-0 bg-white border border-[var(--border)] shadow-sm overflow-hidden flex flex-col">
            <div class="p-4 border-b border-[var(--border)] bg-[var(--bg3)] flex items-center justify-between">
                <h2 class="text-xs font-bold uppercase tracking-wider text-[var(--ink)] flex items-center gap-2">
                    <i class="fas fa-fire text-amber-500"></i> Kursus Terpopuler
                </h2>
                <a href="{{ route('admin.courses.index') }}" class="text-[10px] font-bold text-[var(--blue)] hover:underline">Semua →</a>
            </div>
            <div class="p-4 flex-1 flex flex-col gap-2 overflow-y-auto max-h-[300px]">
                @forelse($stats['popular_courses'] as $course)
                    <div class="flex items-center justify-between p-2.5 rounded-xl border border-[var(--border)] bg-slate-50/50 hover:bg-[var(--blue-light)]/40 transition">
                        <div class="min-w-0 flex-1">
                            <div class="text-xs font-bold text-[var(--ink)] truncate" title="{{ $course->title }}">{{ $course->title }}</div>
                            <div class="text-[10px] text-[var(--muted)] font-mono mt-0.5">
                                <i class="fas fa-users text-[var(--blue)] mr-1"></i> {{ $course->user_courses_count }} Siswa
                            </div>
                        </div>
                        <a href="{{ route('admin.courses.show', $course) }}" class="btn btn-small btn-outline text-xs ml-2 p-2">
                            <i class="fas fa-chevron-right text-[10px]"></i>
                        </a>
                    </div>
                @empty
                    <div class="text-center py-8 text-xs text-[var(--muted)]">Belum ada data kursus.</div>
                @endforelse
            </div>
        </div>

    </div>

    <!-- RECENT ENROLLMENTS TABLE -->
    <div class="cyber-card p-0 bg-white border border-[var(--border)] shadow-sm overflow-hidden">
        <div class="p-4 border-b border-[var(--border)] bg-[var(--bg3)] flex items-center justify-between">
            <h2 class="text-xs font-bold uppercase tracking-wider text-[var(--ink)] flex items-center gap-2">
                <i class="fas fa-clipboard-list text-[var(--blue)]"></i> Pendaftaran Kursus Terkini
            </h2>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr>
                        <th>Siswa</th>
                        <th>Kursus</th>
                        <th>Tanggal Terdaftar</th>
                        <th class="text-right">Status Belajar</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($stats['recent_enrollments'] as $enrollment)
                        <tr>
                            <td class="font-bold text-[var(--ink)]">
                                {{ $enrollment->user->name ?? 'User #' . $enrollment->user_id }}
                            </td>
                            <td class="text-[var(--text2)]">
                                {{ Str::limit($enrollment->course->title ?? '-', 35) }}
                            </td>
                            <td class="font-mono text-[var(--muted)]">
                                {{ $enrollment->created_at->format('d M Y, H:i') }}
                            </td>
                            <td class="text-right">
                                @if($enrollment->is_completed)
                                    <span class="pill success-outline text-[10px]">
                                        <i class="fas fa-check mr-1"></i> Selesai
                                    </span>
                                @else
                                    <span class="pill blue-soft text-[10px]">
                                        <i class="fas fa-spinner mr-1"></i> Sedang Belajar
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="p-8 text-center text-xs text-[var(--muted)]">
                                Belum ada riwayat pendaftaran kursus terbaru.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

@endsection
