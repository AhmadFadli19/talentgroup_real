@extends('layouts.app')

@section('title', 'Kelola Kursus | TalentGroup')

@section('content')

<div class="max-w-6xl mx-auto px-4 sm:px-6 py-6">

    <!-- HEADER -->
    <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4 mb-6">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="pill blue-soft text-[10px] uppercase font-bold tracking-wider">
                    Katalog Pelatihan
                </span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-[var(--ink)] tracking-tight">
                Kelola Daftar Kursus
            </h1>
            <p class="text-xs sm:text-sm text-[var(--text2)] mt-0.5">
                Atur kurikulum kursus, materi video/teks, kuis interaktif, dan pantau peserta.
            </p>
        </div>

        <a href="{{ route('admin.courses.create') }}" class="btn btn-gradient text-xs">
            <i class="fas fa-plus mr-1"></i> Tambah Kursus Baru
        </a>
    </div>

    <!-- LIST OF COURSES -->
    <div class="space-y-4">
        @forelse($courses as $course)
            <div class="cyber-card p-5 bg-white border border-[var(--border)] rounded-2xl shadow-sm flex flex-col md:flex-row items-start md:items-center justify-between gap-5 hover:border-[var(--blue)] transition-all">

                <!-- INFO -->
                <div class="flex items-start gap-4 flex-1 min-w-0">
                    <div class="w-16 h-16 rounded-2xl bg-[var(--surface2)] border border-[var(--border)] flex items-center justify-center overflow-hidden flex-shrink-0 shadow-sm relative group">
                        @if($course->image)
                            <img src="{{ $course->image_url }}" alt="{{ $course->title }}" class="w-full h-full object-cover" onerror="this.style.display='none'; this.nextElementSibling.classList.remove('hidden'); this.nextElementSibling.classList.add('flex');">
                            <div class="w-full h-full bg-gradient-to-br from-blue-600 via-indigo-600 to-sky-500 hidden items-center justify-center text-white">
                                <svg class="w-7 h-7" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 3L1 9L12 15L21 10.09V17H23V9L12 3Z"/>
                                    <path d="M5 13.18V17.18C5 19.57 8.13 21.5 12 21.5C15.87 21.5 19 19.57 19 17.18V13.18L12 17L5 13.18Z" opacity="0.85"/>
                                </svg>
                            </div>
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-blue-600 via-indigo-600 to-sky-500 flex items-center justify-center text-white shadow-inner">
                                <svg class="w-7 h-7" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 3L1 9L12 15L21 10.09V17H23V9L12 3Z"/>
                                    <path d="M5 13.18V17.18C5 19.57 8.13 21.5 12 21.5C15.87 21.5 19 19.57 19 17.18V13.18L12 17L5 13.18Z" opacity="0.85"/>
                                </svg>
                            </div>
                        @endif
                    </div>

                    <div class="min-w-0 flex-1">
                        <div class="flex items-center gap-2 flex-wrap mb-1">
                            <h2 class="text-base font-extrabold text-[var(--ink)] truncate" title="{{ $course->title }}">
                                {{ $course->title }}
                            </h2>
                            @if ($course->price < 1)
                                <span class="pill success-outline text-[10px]">GRATIS</span>
                            @else
                                <span class="pill blue-soft font-mono text-[10px]">Rp {{ number_format($course->price, 0, ',', '.') }}</span>
                            @endif

                            <span class="pill {{ $course->is_active ? 'success-outline' : 'pending' }} text-[10px]">
                                {{ $course->is_active ? '● Aktif' : '○ Nonaktif' }}
                            </span>
                        </div>

                        <p class="text-xs text-[var(--text2)] line-clamp-1 mb-2">
                            {{ $course->description ?: 'Kursus pemrograman interaktif TalentGroup.' }}
                        </p>

                        <div class="flex items-center gap-3 text-xs text-[var(--muted)] font-medium flex-wrap">
                            <span><i class="fas fa-users text-[var(--blue)] mr-1"></i> {{ $course->user_courses_count }} Siswa Terdaftar</span>
                            <span>·</span>
                            <span><i class="far fa-calendar mr-1"></i> {{ $course->created_at->format('d M Y') }}</span>
                        </div>
                    </div>
                </div>

                <!-- ACTIONS -->
                <div class="flex items-center gap-2 flex-wrap self-end md:self-center">
                    <a href="{{ route('admin.courses.show', $course) }}" class="btn-action btn-action-outline" title="Lihat Detail Kursus">
                        <i class="fas fa-eye text-xs"></i> <span>Detail</span>
                    </a>
                    <a href="{{ route('admin.courses.contents.index', $course) }}" class="btn-action btn-action-primary" title="Kelola Materi & Kuis">
                        <i class="fas fa-list text-xs"></i> <span>Materi & Kuis</span>
                    </a>
                    <a href="{{ route('admin.courses.edit', $course) }}" class="btn-action btn-action-outline p-2.5" title="Edit Kursus">
                        <i class="fas fa-pen text-xs"></i>
                    </a>
                    <a href="{{ route('admin.courses.results', $course) }}" class="btn-action btn-action-amber p-2.5" title="Hasil Nilai Siswa">
                        <i class="fas fa-chart-bar text-xs"></i>
                    </a>

                    <form action="{{ route('admin.courses.destroy', $course) }}" method="POST"
                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus kursus {{ $course->title }}?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-action btn-action-danger p-2.5" title="Hapus / Hilangkan Kursus">
                            <i class="fas fa-trash-alt text-xs"></i>
                        </button>
                    </form>
                </div>

            </div>
        @empty
            <div class="empty-prototype-box py-16 px-6 text-center shadow-sm">
                <div class="w-16 h-16 rounded-2xl empty-icon-wrap flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-[var(--blue)]" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 3L1 9L12 15L21 10.09V17H23V9L12 3Z"/>
                        <path d="M5 13.18V17.18C5 19.57 8.13 21.5 12 21.5C15.87 21.5 19 19.57 19 17.18V13.18L12 17L5 13.18Z" opacity="0.85"/>
                    </svg>
                </div>
                <h3 class="text-base font-bold text-[var(--ink)] mb-1">Belum Ada Kursus</h3>
                <p class="text-xs text-[var(--text2)] mb-5">Mulai dengan membuat kursus pertama Anda.</p>
                <a href="{{ route('admin.courses.create') }}" class="btn btn-gradient text-xs">
                    <i class="fas fa-plus mr-1"></i> Buat Kursus Sekarang
                </a>
            </div>
        @endforelse
    </div>

    <!-- PAGINATION -->
    @if($courses->hasPages())
        <div class="mt-8 flex justify-center">
            {{ $courses->links() }}
        </div>
    @endif

</div>

@endsection
