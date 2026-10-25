@extends('layouts.app')

@section('title', $course->title . ' | Admin TalentGroup')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8 pb-4 border-b border-[var(--border)]">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.courses.index') }}" class="btn-outline px-3.5 py-2 rounded-xl text-xs font-bold inline-flex items-center gap-2">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <div class="flex items-center gap-2 text-xs font-mono text-[var(--blue)] uppercase tracking-wider mb-1">
                    <a href="{{ route('admin.courses.index') }}" class="hover:underline">COURSES</a>
                    <i class="fas fa-chevron-right text-[9px]"></i>
                    <span>DETAIL</span>
                </div>
                <h1 class="text-2xl font-extrabold text-[var(--ink)] tracking-tight">{{ $course->title }}</h1>
                <div class="flex items-center gap-2 mt-1 text-xs text-[var(--muted)]">
                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider {{ $course->is_active ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-rose-50 text-rose-700 border border-rose-200' }}">
                        {{ $course->is_active ? 'Aktif' : 'Non-aktif' }}
                    </span>
                    <span>•</span>
                    <span>Dibuat {{ $course->created_at->format('d M Y') }}</span>
                </div>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('admin.courses.edit', $course) }}" class="btn-outline px-4 py-2.5 rounded-xl text-xs font-bold inline-flex items-center gap-2">
                <i class="fas fa-edit"></i> Edit Kursus
            </a>
            <a href="{{ route('admin.courses.contents.index', $course) }}" class="btn-gradient px-4 py-2.5 rounded-xl text-white text-xs font-bold shadow-sm inline-flex items-center gap-2">
                <i class="fas fa-layer-group"></i> Kelola Materi
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- LEFT (2 cols) -->
        <div class="lg:col-span-2 space-y-6">

            <!-- COURSE INFO -->
            <div class="bg-white border border-[var(--border)] rounded-2xl p-6 shadow-sm">
                @if($course->image)
                    <div class="h-56 rounded-xl overflow-hidden border border-[var(--border)] mb-5">
                        <img src="{{ $course->image_url }}" alt="{{ $course->title }}" class="w-full h-full object-cover">
                    </div>
                @endif

                <h3 class="text-xs font-bold uppercase tracking-wider text-[var(--muted)] mb-2">Deskripsi Kursus</h3>
                <p class="text-xs sm:text-sm text-[var(--body)] leading-relaxed mb-6">{{ $course->description }}</p>

                <div class="grid grid-cols-3 gap-4 p-4 rounded-xl bg-slate-50 border border-[var(--border)]">
                    <div>
                        <div class="text-[10px] font-bold uppercase tracking-wider text-[var(--muted)]">Harga</div>
                        <div class="text-base font-extrabold text-[var(--ink)] mt-0.5">
                            {{ $course->price > 0 ? 'Rp ' . number_format($course->price, 0, ',', '.') : 'Gratis' }}
                        </div>
                    </div>
                    <div>
                        <div class="text-[10px] font-bold uppercase tracking-wider text-[var(--muted)]">Peserta</div>
                        <div class="text-base font-extrabold text-[var(--blue)] font-mono mt-0.5">{{ $course->userCourses->count() }} Orang</div>
                    </div>
                    <div>
                        <div class="text-[10px] font-bold uppercase tracking-wider text-[var(--muted)]">Instruktur / Pembuat</div>
                        <div class="text-xs font-bold text-[var(--ink)] mt-1 truncate">{{ $course->creator->name ?? 'Admin' }}</div>
                    </div>
                </div>
            </div>

            <!-- CONTENT LIST -->
            <div class="bg-white border border-[var(--border)] rounded-2xl p-6 shadow-sm">
                <div class="flex justify-between items-center mb-4 pb-3 border-b border-[var(--border)]">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-[var(--ink)]">Daftar Bab & Materi Kursus</h3>
                    <a href="{{ route('admin.courses.contents.index', $course) }}" class="text-xs font-bold text-[var(--blue)] hover:underline">
                        Kelola Semua ({{ $course->contents->count() }}) →
                    </a>
                </div>

                @if($course->contents->count())
                    <div class="space-y-2.5">
                        @foreach($course->contents as $content)
                            <div class="p-3.5 rounded-xl bg-slate-50 border border-[var(--border)] flex items-center justify-between gap-3 hover:bg-slate-100/60 transition">
                                <div class="min-w-0">
                                    <div class="font-bold text-xs text-[var(--ink)] truncate">{{ $content->title }}</div>
                                    <div class="text-[10px] text-[var(--muted)] font-mono uppercase mt-0.5">
                                        Tipe: {{ strtoupper($content->type) }} • Urutan #{{ $content->order }}
                                    </div>
                                </div>
                                <a href="{{ route('admin.courses.contents.show', [$course, $content]) }}" class="px-3 py-1.5 rounded-lg bg-white hover:bg-blue-50 text-[var(--blue)] border border-[var(--border)] text-xs font-bold transition">
                                    Detail
                                </a>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8 text-[var(--muted)] text-xs">
                        <i class="fas fa-file-circle-plus text-2xl mb-2 text-slate-300 block"></i>
                        Belum ada materi pembelajaran dalam kursus ini.
                        <div class="mt-3">
                            <a href="{{ route('admin.courses.contents.create', $course) }}" class="btn-gradient px-4 py-2 rounded-xl text-white text-xs font-bold shadow-sm inline-flex items-center gap-1.5">
                                <i class="fas fa-plus"></i> Tambah Materi Pertama
                            </a>
                        </div>
                    </div>
                @endif
            </div>

        </div>

        <!-- RIGHT (1 col) -->
        <div class="space-y-6">

            <!-- ACTIONS -->
            <div class="bg-white border border-[var(--border)] rounded-2xl p-6 shadow-sm">
                <h3 class="text-xs font-bold uppercase tracking-wider text-[var(--ink)] mb-4">Aksi Cepat</h3>

                <div class="space-y-2.5">
                    <a href="{{ route('admin.courses.edit', $course) }}" class="w-full btn-outline py-2.5 px-4 rounded-xl text-xs font-bold flex items-center gap-2">
                        <i class="fas fa-edit text-[var(--blue)]"></i> Edit Info Kursus
                    </a>

                    <a href="{{ route('admin.courses.contents.index', $course) }}" class="w-full btn-outline py-2.5 px-4 rounded-xl text-xs font-bold flex items-center gap-2">
                        <i class="fas fa-book-open text-indigo-600"></i> Kelola Materi ({{ $course->contents->count() }})
                    </a>

                    <a href="{{ route('admin.courses.results', $course) }}" class="w-full btn-outline py-2.5 px-4 rounded-xl text-xs font-bold flex items-center gap-2">
                        <i class="fas fa-poll text-emerald-600"></i> Hasil Ujian & Peserta
                    </a>
                </div>
            </div>

            <!-- ENROLLMENT -->
            <div class="bg-white border border-[var(--border)] rounded-2xl p-6 shadow-sm">
                <h3 class="text-xs font-bold uppercase tracking-wider text-[var(--ink)] mb-4 pb-2 border-b border-[var(--border)]">Pendaftar Terbaru</h3>

                @forelse($course->userCourses->take(5) as $userCourse)
                    <div class="flex items-center justify-between py-2.5 border-b border-slate-100 last:border-0">
                        <div class="flex items-center gap-2.5 min-w-0">
                            <div class="w-7 h-7 rounded-full bg-blue-50 text-[var(--blue)] font-bold text-xs flex items-center justify-center flex-shrink-0 border border-blue-100">
                                {{ strtoupper(substr($userCourse->user->name ?? 'U', 0, 1)) }}
                            </div>
                            <span class="text-xs font-semibold text-[var(--ink)] truncate">{{ $userCourse->user->name ?? 'User #' . $userCourse->user_id }}</span>
                        </div>
                        <span class="text-[9px] font-bold uppercase font-mono px-2 py-0.5 rounded-full {{ $userCourse->is_completed ? 'bg-emerald-50 text-emerald-700' : 'bg-blue-50 text-[var(--blue)]' }}">
                            {{ $userCourse->is_completed ? 'Selesai' : 'Aktif' }}
                        </span>
                    </div>
                @empty
                    <p class="text-xs text-[var(--muted)] text-center py-4">Belum ada peserta yang mendaftar.</p>
                @endforelse

                @if($course->userCourses->count() > 5)
                    <a href="{{ route('admin.courses.results', $course) }}" class="mt-4 block text-center text-xs font-bold text-[var(--blue)] hover:underline">
                        Lihat Semua Peserta ({{ $course->userCourses->count() }}) →
                    </a>
                @endif
            </div>

        </div>

    </div>

</div>
@endsection
