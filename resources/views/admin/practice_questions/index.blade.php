@extends('layouts.app')

@section('title', 'Kelola Latihan Soal | TalentGroup')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 py-6">
    <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-5 mb-7">
        <div>
            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-50 border border-blue-200 text-[11px] font-extrabold uppercase tracking-wider text-[var(--blue)] mb-3">
                <i class="fas fa-clipboard-list"></i> Bank Latihan
            </span>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-[var(--ink)] tracking-tight">Kelola Latihan Soal</h1>
            <p class="text-xs sm:text-sm text-[var(--text2)] mt-1 max-w-2xl leading-relaxed">
                Kelola paket latihan, level kesulitan, kunci jawaban, dan hasil pengerjaan siswa dari satu tempat.
            </p>
        </div>

        <a href="{{ route('admin.courses.create') }}" class="btn btn-gradient text-xs">
            <i class="fas fa-plus mr-1"></i> Buat Paket Latihan
        </a>
    </div>

    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-5 mb-7">
        @php
            $summaryCards = [
                ['label' => 'Total Soal', 'value' => $totalQuestions, 'icon' => 'fa-list-check', 'icon_classes' => 'bg-blue-50 text-blue-600 border-blue-200'],
                ['label' => 'Level Dasar', 'value' => $levelCounts['beginner'] ?? 0, 'icon' => 'fa-seedling', 'icon_classes' => 'bg-emerald-50 text-emerald-600 border-emerald-200'],
                ['label' => 'Level Menengah', 'value' => $levelCounts['intermediate'] ?? 0, 'icon' => 'fa-layer-group', 'icon_classes' => 'bg-amber-50 text-amber-600 border-amber-200'],
                ['label' => 'Level Lanjutan', 'value' => $levelCounts['advanced'] ?? 0, 'icon' => 'fa-bolt', 'icon_classes' => 'bg-rose-50 text-rose-600 border-rose-200'],
            ];
        @endphp

        @foreach($summaryCards as $card)
            <div class="bg-white border border-[var(--border)] rounded-2xl p-4 sm:p-5 shadow-sm">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <div class="text-[10px] sm:text-xs font-bold uppercase tracking-wider text-[var(--muted)]">{{ $card['label'] }}</div>
                        <div class="text-2xl sm:text-3xl font-black font-mono text-[var(--ink)] mt-1">{{ number_format($card['value']) }}</div>
                    </div>
                    <div class="w-9 h-9 rounded-xl border flex items-center justify-center {{ $card['icon_classes'] }}">
                        <i class="fas {{ $card['icon'] }}"></i>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <form method="GET" action="{{ route('admin.practice-questions.index') }}" class="bg-white border border-[var(--border)] rounded-2xl p-3 sm:p-4 shadow-sm mb-6 flex flex-col sm:flex-row gap-3">
        <div class="relative flex-1">
            <i class="fas fa-search absolute left-3.5 top-1/2 -translate-y-1/2 text-[var(--muted)] text-xs"></i>
            <input type="search" name="search" value="{{ $search }}" placeholder="Cari paket latihan atau topik..."
                   class="w-full pl-10 pr-4 py-2.5 rounded-xl bg-slate-50 border border-[var(--border)] text-xs text-[var(--ink)] focus:bg-white focus:border-[var(--blue)] focus:outline-none">
        </div>
        <button type="submit" class="btn btn-outline text-xs"><i class="fas fa-filter mr-1"></i> Cari</button>
    </form>

    <div class="grid grid-cols-1 xl:grid-cols-2 gap-5">
        @forelse($courses as $course)
            <article class="bg-white border border-[var(--border)] rounded-2xl p-5 shadow-sm hover:border-[var(--blue)] transition">
                <div class="flex items-start justify-between gap-4 mb-4">
                    <div class="min-w-0">
                        <div class="flex items-center gap-2 flex-wrap mb-1.5">
                            <h2 class="text-base font-extrabold text-[var(--ink)]">{{ $course->title }}</h2>
                            <span class="pill {{ $course->is_active ? 'success-outline' : 'pending' }} text-[10px]">
                                {{ $course->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </div>
                        <p class="text-xs text-[var(--text2)] line-clamp-2 leading-relaxed">{{ $course->description }}</p>
                    </div>
                    <div class="w-11 h-11 rounded-xl bg-blue-50 border border-blue-200 text-[var(--blue)] flex items-center justify-center font-black font-mono flex-shrink-0">
                        {{ $course->questions_count }}
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-2 mb-4 text-center">
                    <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-2 py-2.5">
                        <div class="text-[10px] font-bold uppercase text-emerald-700">Dasar</div>
                        <div class="text-lg font-black font-mono text-emerald-800">{{ $course->beginner_questions_count }}</div>
                    </div>
                    <div class="rounded-xl border border-amber-200 bg-amber-50 px-2 py-2.5">
                        <div class="text-[10px] font-bold uppercase text-amber-700">Menengah</div>
                        <div class="text-lg font-black font-mono text-amber-800">{{ $course->intermediate_questions_count }}</div>
                    </div>
                    <div class="rounded-xl border border-rose-200 bg-rose-50 px-2 py-2.5">
                        <div class="text-[10px] font-bold uppercase text-rose-700">Lanjutan</div>
                        <div class="text-lg font-black font-mono text-rose-800">{{ $course->advanced_questions_count }}</div>
                    </div>
                </div>

                <div class="flex flex-wrap gap-2 pt-4 border-t border-[var(--border)]">
                    <a href="{{ route('admin.courses.contents.index', $course) }}" class="btn btn-gradient text-xs">
                        <i class="fas fa-list-check mr-1"></i> Kelola Soal
                    </a>
                    <a href="{{ route('admin.courses.contents.create', $course) }}" class="btn btn-outline text-xs">
                        <i class="fas fa-plus mr-1"></i> Tambah Soal
                    </a>
                    <a href="{{ route('admin.courses.results', $course) }}" class="btn btn-outline text-xs">
                        <i class="fas fa-chart-simple mr-1"></i> Hasil Siswa
                    </a>
                </div>
            </article>
        @empty
            <div class="xl:col-span-2 bg-white border border-dashed border-[var(--border)] rounded-2xl py-14 px-6 text-center">
                <div class="w-14 h-14 rounded-2xl bg-blue-50 text-[var(--blue)] flex items-center justify-center mx-auto mb-4 text-xl">
                    <i class="fas fa-clipboard-list"></i>
                </div>
                <h2 class="text-base font-extrabold text-[var(--ink)]">Belum Ada Paket Latihan</h2>
                <p class="text-xs text-[var(--muted)] mt-1 mb-5">Buat kursus, lalu tambahkan konten bertipe kuis pilihan ganda.</p>
                <a href="{{ route('admin.courses.create') }}" class="btn btn-gradient text-xs">Buat Paket Pertama</a>
            </div>
        @endforelse
    </div>

    @if($courses->hasPages())
        <div class="mt-7">{{ $courses->links() }}</div>
    @endif
</div>
@endsection
