@extends('layouts.app')

@section('title', 'Kelola Materi: ' . $module->name)

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8">

    <!-- Header Section -->
    <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4 mb-8">
        <div>
            <div class="flex items-center gap-2 text-xs font-mono text-[var(--accent)] uppercase tracking-wider mb-1">
                <a href="{{ route('admin.modules.index') }}" class="hover:underline">MODULE MANAGER</a>
                <i class="fas fa-chevron-right text-[10px]"></i>
                <span>{{ $module->name }}</span>
                <i class="fas fa-chevron-right text-[10px]"></i>
                <span class="text-white">BAB MATERI</span>
            </div>
            <h1 class="text-2xl md:text-3xl font-extrabold text-white tracking-tight flex items-center gap-3">
                <span class="w-9 h-9 rounded-xl flex items-center justify-center text-lg shadow-inner border border-white/10" style="background: {{ $module->color ?: '#38bdf8' }}20; color: {{ $module->color ?: '#38bdf8' }};">
                    <i class="{{ $module->icon ?: 'fas fa-book' }}"></i>
                </span>
                <span>{{ $module->name }}</span>
            </h1>
            <p class="text-xs text-slate-400 mt-1">
                Kelola bab dan materi khusus untuk modul ini secara independen.
            </p>
        </div>

        <div class="flex flex-wrap items-center gap-3">
            <a href="{{ route('admin.modules.index') }}" 
               class="px-4 py-2.5 rounded-xl border border-[var(--border)] bg-slate-900/50 hover:bg-slate-800 text-slate-300 hover:text-white text-xs font-bold transition flex items-center gap-2">
                <i class="fas fa-arrow-left"></i>
                <span>Daftar Modul</span>
            </a>

            <a href="{{ route('modules.module.show', $module->slug) }}" target="_blank"
               class="px-4 py-2.5 rounded-xl border border-cyan-500/30 bg-cyan-500/10 hover:bg-cyan-500/20 text-cyan-400 text-xs font-bold transition flex items-center gap-2">
                <i class="fas fa-external-link-alt"></i>
                <span>Buka Reader</span>
            </a>

            <a href="{{ route('admin.modules.contents.create', $module->id) }}" 
               class="cyber-btn flex items-center gap-2 text-xs">
                <i class="fas fa-plus"></i>
                <span>Tambah Bab Baru</span>
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 rounded-xl border border-emerald-500/30 bg-emerald-950/20 text-emerald-400 text-sm flex items-center gap-3">
            <i class="fas fa-check-circle text-lg"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Lessons Table -->
    <div class="cyber-card overflow-hidden p-0">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm border-collapse">
                <thead class="bg-black/30 text-xs uppercase tracking-wider text-[var(--text2)] border-b border-[var(--border)]">
                    <tr>
                        <th class="px-5 py-4 font-bold">Urutan</th>
                        <th class="px-5 py-4 font-bold">Section Sidebar</th>
                        <th class="px-5 py-4 font-bold">Judul Bab Materi</th>
                        <th class="px-5 py-4 font-bold">Status</th>
                        <th class="px-5 py-4 font-bold">Anti-SS</th>
                        <th class="px-5 py-4 font-bold">Dilihat</th>
                        <th class="px-5 py-4 font-bold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[var(--border)] text-[var(--text)]">
                    @forelse($lessons as $lesson)
                        <tr class="hover:bg-slate-800/20 transition">
                            <!-- Order -->
                            <td class="px-5 py-4 font-mono text-xs text-slate-400">
                                #{{ $lesson->order }}
                            </td>

                            <!-- Section -->
                            <td class="px-5 py-4">
                                <span class="px-2.5 py-1 rounded-md text-[10px] font-mono font-bold bg-slate-900 border border-slate-700/80 text-cyan-400">
                                    {{ $lesson->section ?: 'GETTING STARTED' }}
                                </span>
                            </td>

                            <!-- Title & Slug -->
                            <td class="px-5 py-4">
                                <div class="font-bold text-white text-sm hover:text-[var(--cyan)] transition">
                                    <a href="{{ route('admin.modules.contents.edit', ['module' => $module->id, 'content' => $lesson->id]) }}">
                                        {{ $lesson->title }}
                                    </a>
                                </div>
                                <div class="text-xs text-[var(--text2)] font-mono mt-0.5">
                                    /modules/{{ $module->slug }}/{{ $lesson->slug }}
                                </div>
                            </td>

                            <!-- Status (Quick Toggle) -->
                            <td class="px-5 py-4">
                                <form action="{{ route('admin.modules.contents.toggle-publish', ['module' => $module->id, 'content' => $lesson->id]) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" 
                                            class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold cursor-pointer transition {{ $lesson->is_published ? 'bg-emerald-500/10 hover:bg-emerald-500/20 text-emerald-400 border border-emerald-500/30' : 'bg-amber-500/10 hover:bg-amber-500/20 text-amber-400 border border-amber-500/30' }}"
                                            title="Klik untuk ubah status publikasi">
                                        @if($lesson->is_published)
                                            <i class="fas fa-check text-[10px]"></i> Published
                                        @else
                                            <i class="fas fa-clock text-[10px]"></i> Draft
                                        @endif
                                    </button>
                                </form>
                            </td>

                            <!-- Anti-SS Protection -->
                            <td class="px-5 py-4">
                                @if($lesson->enable_protection)
                                    <span class="text-xs font-semibold text-emerald-400 flex items-center gap-1">
                                        <i class="fas fa-shield-alt text-[10px]"></i> Aktif
                                    </span>
                                @else
                                    <span class="text-xs text-slate-500">Nonaktif</span>
                                @endif
                            </td>

                            <!-- Views -->
                            <td class="px-5 py-4 text-xs font-mono text-slate-400">
                                {{ number_format($lesson->views_count) }}x
                            </td>

                            <!-- Actions -->
                            <td class="px-5 py-4 text-right">
                                <div class="inline-flex items-center gap-2">
                                    <a href="{{ route('modules.lesson.show', ['moduleSlug' => $module->slug, 'lessonSlug' => $lesson->slug]) }}" target="_blank"
                                       class="p-2 rounded-lg bg-slate-800 hover:bg-cyan-500/20 text-slate-300 hover:text-cyan-400 transition" 
                                       title="Lihat Bab di Reader">
                                        <i class="fas fa-eye text-xs"></i>
                                    </a>

                                    <a href="{{ route('admin.modules.contents.edit', ['module' => $module->id, 'content' => $lesson->id]) }}" 
                                       class="p-2 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-300 hover:text-white transition" 
                                       title="Edit Bab">
                                        <i class="fas fa-edit text-xs"></i>
                                    </a>

                                    <form action="{{ route('admin.modules.contents.destroy', ['module' => $module->id, 'content' => $lesson->id]) }}" method="POST" class="inline" 
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus bab materi ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="p-2 rounded-lg bg-slate-800 hover:bg-rose-500/20 text-slate-300 hover:text-rose-400 transition" 
                                                title="Hapus Bab">
                                            <i class="fas fa-trash text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-12 text-center text-slate-500 text-sm">
                                <div class="max-w-sm mx-auto flex flex-col items-center">
                                    <i class="fas fa-inbox text-4xl text-slate-600 mb-3"></i>
                                    <p class="font-semibold text-slate-400">Belum ada bab materi di modul ini.</p>
                                    <p class="text-xs text-slate-500 mt-1 mb-4">Tambahkan materi pertama untuk {{ $module->name }}.</p>
                                    <a href="{{ route('admin.modules.contents.create', $module->id) }}" class="cyber-btn text-xs">
                                        + Tambah Bab Pertama
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($lessons->hasPages())
            <div class="p-4 border-t border-[var(--border)]">
                {{ $lessons->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
