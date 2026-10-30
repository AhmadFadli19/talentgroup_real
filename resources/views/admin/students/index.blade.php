@extends('layouts.app')

@section('title', 'Data Siswa | Admin TalentGroup')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 py-6">
    <div class="flex flex-col xl:flex-row xl:items-end justify-between gap-5 mb-7">
        <div>
            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-50 border border-blue-200 text-[11px] font-extrabold uppercase tracking-wider text-[var(--blue)] mb-3">
                <i class="fas fa-user-graduate"></i> Manajemen Siswa
            </span>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-[var(--ink)] tracking-tight">Daftar Siswa TalentGroup</h1>
            <p class="text-xs sm:text-sm text-[var(--text2)] mt-1 max-w-2xl leading-relaxed">
                Lihat identitas siswa, kursus yang diikuti, dan progres belajarnya dari satu halaman.
            </p>
        </div>

        <div class="flex flex-wrap gap-2">
            <a href="{{ route('admin.students.export.excel', request()->except('page')) }}"
               class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-extrabold transition shadow-sm">
                <i class="fas fa-file-excel"></i> Unduh Excel
            </a>
            <a href="{{ route('admin.students.export.pdf', request()->except('page')) }}"
               class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-xs font-extrabold transition shadow-sm">
                <i class="fas fa-file-pdf"></i> Unduh PDF
            </a>
        </div>
    </div>

    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-5 mb-7">
        @php
            $summaryCards = [
                ['label' => 'Total Siswa', 'value' => $stats['total'], 'icon' => 'fa-users', 'classes' => 'bg-blue-50 text-blue-600 border-blue-200'],
                ['label' => 'Mengikuti Kursus', 'value' => $stats['with_courses'], 'icon' => 'fa-book-open-reader', 'classes' => 'bg-amber-50 text-amber-600 border-amber-200'],
                ['label' => 'Pernah Menyelesaikan', 'value' => $stats['completed'], 'icon' => 'fa-graduation-cap', 'classes' => 'bg-emerald-50 text-emerald-600 border-emerald-200'],
                ['label' => 'Daftar via Google', 'value' => $stats['google'], 'icon' => 'fa-google', 'classes' => 'bg-rose-50 text-rose-600 border-rose-200'],
            ];
        @endphp

        @foreach($summaryCards as $card)
            <div class="bg-white border border-[var(--border)] rounded-2xl p-4 sm:p-5 shadow-sm">
                <div class="flex items-start justify-between gap-3">
                    <div class="min-w-0">
                        <div class="text-[9px] sm:text-[11px] font-extrabold uppercase tracking-wider text-[var(--muted)] truncate">{{ $card['label'] }}</div>
                        <div class="text-2xl sm:text-3xl font-black font-mono text-[var(--ink)] mt-1">{{ number_format($card['value']) }}</div>
                    </div>
                    <div class="w-9 h-9 rounded-xl border flex items-center justify-center flex-shrink-0 {{ $card['classes'] }}">
                        <i class="{{ $card['icon'] === 'fa-google' ? 'fab' : 'fas' }} {{ $card['icon'] }}"></i>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <form method="GET" action="{{ route('admin.students.index') }}" class="bg-white border border-[var(--border)] rounded-2xl p-4 shadow-sm mb-6">
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-5 gap-3">
            <div class="relative xl:col-span-2">
                <i class="fas fa-search absolute left-3.5 top-1/2 -translate-y-1/2 text-[var(--muted)] text-xs"></i>
                <input type="search" name="search" value="{{ request('search') }}" placeholder="Cari nama, username, email, atau telepon..."
                       class="w-full pl-10 pr-4 py-2.5 rounded-xl bg-slate-50 border border-[var(--border)] text-xs text-[var(--ink)] focus:bg-white focus:border-[var(--blue)] focus:outline-none">
            </div>

            <select name="course" class="px-3.5 py-2.5 rounded-xl bg-slate-50 border border-[var(--border)] text-xs text-[var(--ink)] focus:bg-white focus:border-[var(--blue)] focus:outline-none">
                <option value="">Semua kursus</option>
                @foreach($courses as $course)
                    <option value="{{ $course->id }}" @selected((string) request('course') === (string) $course->id)>
                        {{ $course->title }} ({{ $course->user_courses_count }})
                    </option>
                @endforeach
            </select>

            <select name="status" class="px-3.5 py-2.5 rounded-xl bg-slate-50 border border-[var(--border)] text-xs text-[var(--ink)] focus:bg-white focus:border-[var(--blue)] focus:outline-none">
                <option value="">Semua status</option>
                <option value="learning" @selected(request('status') === 'learning')>Sedang belajar</option>
                <option value="completed" @selected(request('status') === 'completed')>Pernah menyelesaikan</option>
                <option value="no_course" @selected(request('status') === 'no_course')>Belum ikut kursus</option>
                <option value="google" @selected(request('status') === 'google')>Daftar via Google</option>
            </select>

            <div class="flex gap-2">
                <select name="sort" class="min-w-0 flex-1 px-3.5 py-2.5 rounded-xl bg-slate-50 border border-[var(--border)] text-xs text-[var(--ink)] focus:bg-white focus:border-[var(--blue)] focus:outline-none">
                    <option value="latest" @selected(request('sort', 'latest') === 'latest')>Terbaru</option>
                    <option value="oldest" @selected(request('sort') === 'oldest')>Terlama</option>
                    <option value="name" @selected(request('sort') === 'name')>Nama A–Z</option>
                </select>
                <button type="submit" class="btn btn-gradient text-xs px-4" title="Terapkan filter">
                    <i class="fas fa-filter"></i>
                </button>
                @if(request()->hasAny(['search', 'course', 'status', 'sort']))
                    <a href="{{ route('admin.students.index') }}" class="btn btn-outline text-xs px-4" title="Hapus filter">
                        <i class="fas fa-rotate-left"></i>
                    </a>
                @endif
            </div>
        </div>
    </form>

    <div class="bg-white border border-[var(--border)] rounded-2xl shadow-sm overflow-hidden">
        <div class="px-4 sm:px-5 py-3.5 border-b border-[var(--border)] bg-slate-50 flex items-center justify-between gap-3">
            <div>
                <h2 class="text-xs font-extrabold uppercase tracking-wider text-[var(--ink)]">Data Siswa</h2>
                <p class="text-[10px] text-[var(--muted)] mt-0.5">Menampilkan {{ number_format($students->total()) }} siswa sesuai filter.</p>
            </div>
            <span class="px-2.5 py-1 rounded-full border border-blue-200 bg-blue-50 text-[10px] font-bold font-mono text-[var(--blue)]">
                Halaman {{ $students->currentPage() }} / {{ max(1, $students->lastPage()) }}
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs min-w-[1050px]">
                <thead>
                    <tr>
                        <th class="w-12 text-center">No.</th>
                        <th>Siswa</th>
                        <th>Kontak</th>
                        <th>Bergabung</th>
                        <th>Progres Kursus</th>
                        <th>Kursus yang Diikuti</th>
                        <th class="text-right">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($students as $student)
                        @php
                            $courseNames = $student->userCourses->pluck('course.title')->filter()->unique()->values();
                            $allFinished = $student->courses_count > 0 && $student->completed_courses_count === $student->courses_count;
                        @endphp
                        <tr>
                            <td class="text-center font-mono text-[var(--muted)]">
                                {{ ($students->firstItem() ?? 1) + $loop->index }}
                            </td>
                            <td>
                                <div class="flex items-center gap-3 min-w-[200px]">
                                    <div class="w-10 h-10 rounded-full bg-[var(--blue-light)] border border-blue-200 text-[var(--blue)] flex items-center justify-center font-black flex-shrink-0">
                                        {{ mb_strtoupper(mb_substr($student->name, 0, 1)) }}
                                    </div>
                                    <div class="min-w-0">
                                        <div class="font-extrabold text-[var(--ink)] truncate max-w-[220px]" title="{{ $student->name }}">{{ $student->name }}</div>
                                        <div class="text-[10px] font-mono text-[var(--muted)] truncate max-w-[220px]">@{{ $student->username }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="font-semibold text-[var(--text2)] max-w-[230px] truncate" title="{{ $student->email }}">{{ $student->email }}</div>
                                <div class="text-[10px] font-mono text-[var(--muted)] mt-0.5">{{ $student->phone ?: 'Telepon belum diisi' }}</div>
                            </td>
                            <td>
                                <div class="font-semibold text-[var(--text2)]">{{ $student->created_at?->setTimezone('Asia/Jakarta')->format('d M Y') ?? '-' }}</div>
                                <div class="text-[10px] font-mono text-[var(--muted)] mt-0.5">{{ $student->created_at?->setTimezone('Asia/Jakarta')->format('H:i') ?? '-' }} WIB</div>
                            </td>
                            <td>
                                <div class="flex items-center gap-2 mb-1.5">
                                    <span class="text-sm font-black font-mono text-[var(--ink)]">{{ $student->completed_courses_count }}/{{ $student->courses_count }}</span>
                                    <span class="text-[10px] text-[var(--muted)]">selesai</span>
                                </div>
                                <div class="w-28 h-1.5 rounded-full bg-slate-200 overflow-hidden">
                                    <div class="h-full bg-emerald-500 rounded-full" style="width: {{ $student->courses_count > 0 ? round(($student->completed_courses_count / $student->courses_count) * 100) : 0 }}%"></div>
                                </div>
                            </td>
                            <td>
                                <div class="flex flex-wrap gap-1 max-w-[300px]">
                                    @forelse($courseNames->take(2) as $courseName)
                                        <span class="px-2 py-1 rounded-md bg-blue-50 border border-blue-100 text-[10px] font-semibold text-[var(--blue)]" title="{{ $courseName }}">
                                            {{ Str::limit($courseName, 24) }}
                                        </span>
                                    @empty
                                        <span class="text-[10px] italic text-[var(--muted)]">Belum mengikuti kursus</span>
                                    @endforelse
                                    @if($courseNames->count() > 2)
                                        <span class="px-2 py-1 rounded-md bg-slate-100 border border-slate-200 text-[10px] font-bold text-[var(--muted)]">+{{ $courseNames->count() - 2 }}</span>
                                    @endif
                                </div>
                            </td>
                            <td class="text-right">
                                <div class="flex flex-col items-end gap-1.5">
                                    @if($student->google_id)
                                        <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full border border-rose-200 bg-rose-50 text-[9px] font-extrabold text-rose-700">
                                            <i class="fab fa-google"></i> GOOGLE
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full border border-slate-200 bg-slate-50 text-[9px] font-extrabold text-slate-600">
                                            <i class="fas fa-envelope"></i> EMAIL
                                        </span>
                                    @endif

                                    <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full border text-[9px] font-extrabold {{ $allFinished ? 'border-emerald-200 bg-emerald-50 text-emerald-700' : ($student->courses_count > 0 ? 'border-blue-200 bg-blue-50 text-blue-700' : 'border-amber-200 bg-amber-50 text-amber-700') }}">
                                        <i class="fas {{ $allFinished ? 'fa-circle-check' : ($student->courses_count > 0 ? 'fa-book-open' : 'fa-clock') }}"></i>
                                        {{ $allFinished ? 'SELESAI' : ($student->courses_count > 0 ? 'BELAJAR' : 'BELUM ADA KURSUS') }}
                                    </span>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-14 text-center">
                                <div class="w-12 h-12 rounded-2xl bg-blue-50 text-[var(--blue)] flex items-center justify-center mx-auto mb-3 text-lg">
                                    <i class="fas fa-user-slash"></i>
                                </div>
                                <div class="font-extrabold text-[var(--ink)]">Siswa tidak ditemukan</div>
                                <p class="text-[11px] text-[var(--muted)] mt-1">Coba ubah atau hapus filter pencarian.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($students->hasPages())
        <div class="mt-7">{{ $students->links() }}</div>
    @endif
</div>
@endsection
