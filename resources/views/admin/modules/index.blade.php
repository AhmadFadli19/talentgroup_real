@extends('layouts.app')

@section('title', 'Kelola Modul Dokumentasi | TalentGroup')

@section('content')

<div class="max-w-6xl mx-auto px-4 sm:px-6 py-6">

    <!-- HEADER -->
    <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4 mb-6">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="pill blue-soft text-[10px] uppercase font-bold tracking-wider">
                    Dokumentasi Platform
                </span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-[var(--ink)] tracking-tight">
                Kelola Modul Dokumentasi
            </h1>
            <p class="text-xs sm:text-sm text-[var(--text2)] mt-0.5">
                Atur buku modul materi, bab pembelajaran interaktif, dan hak akses pembaca.
            </p>
        </div>

        <div class="flex items-center gap-2 flex-wrap">
            <a href="{{ route('admin.module-categories.index') }}" class="btn btn-small btn-outline text-xs">
                <i class="fas fa-folder-tree text-[var(--blue)] mr-1"></i> Kategori Sidebar
            </a>
            <a href="{{ route('admin.referral-codes.index') }}" class="btn btn-small btn-outline text-xs">
                <i class="fas fa-ticket-alt text-[var(--blue)] mr-1"></i> Kode Referral
            </a>
            <a href="{{ route('admin.modules.create') }}" class="btn btn-small btn-gradient text-xs">
                <i class="fas fa-plus mr-1"></i> Tambah Modul Baru
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 rounded-xl border border-emerald-500/30 bg-emerald-50 text-emerald-800 text-xs flex items-center gap-2.5 shadow-sm">
            <i class="fas fa-check-circle text-emerald-600 text-base"></i>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @endif

    <!-- FILTER TABS -->
    <div class="flex flex-wrap items-center gap-2 mb-6 text-xs">
        @php
            $currentStatus = request('status');
            $currentVis = request('visibility');
        @endphp
        <a href="{{ route('admin.modules.index') }}" 
           class="px-3.5 py-1.5 rounded-lg border font-bold transition {{ !$currentStatus && !$currentVis ? 'bg-[var(--blue)] text-white border-[var(--blue)]' : 'bg-white text-[var(--text2)] border-[var(--border)] hover:border-[var(--blue)]' }}">
            Semua Modul
        </a>
        <a href="{{ route('admin.modules.index', ['status' => 'active']) }}" 
           class="px-3.5 py-1.5 rounded-lg border font-bold transition {{ $currentStatus === 'active' ? 'bg-emerald-600 text-white border-emerald-600' : 'bg-white text-emerald-700 border-emerald-200 hover:bg-emerald-50' }}">
            ● Aktif
        </a>
        <a href="{{ route('admin.modules.index', ['status' => 'inactive']) }}" 
           class="px-3.5 py-1.5 rounded-lg border font-bold transition {{ $currentStatus === 'inactive' ? 'bg-rose-600 text-white border-rose-600' : 'bg-white text-rose-700 border-rose-200 hover:bg-rose-50' }}">
            ○ Nonaktif
        </a>
        <a href="{{ route('admin.modules.index', ['visibility' => 'public']) }}" 
           class="px-3.5 py-1.5 rounded-lg border font-bold transition {{ $currentVis === 'public' ? 'bg-[var(--blue)] text-white border-[var(--blue)]' : 'bg-white text-[var(--blue)] border-[var(--border)] hover:bg-[var(--blue-light)]' }}">
            🌐 Publik (Gratis)
        </a>
        <a href="{{ route('admin.modules.index', ['visibility' => 'private']) }}" 
           class="px-3.5 py-1.5 rounded-lg border font-bold transition {{ $currentVis === 'private' ? 'bg-amber-600 text-white border-amber-600' : 'bg-white text-amber-700 border-amber-200 hover:bg-amber-50' }}">
            🔒 Privat
        </a>
    </div>

    <!-- LIST OF MODULES -->
    <div class="space-y-4">
        @forelse($modules as $module)
            <div class="cyber-card p-5 bg-white border border-[var(--border)] rounded-2xl shadow-sm flex flex-col md:flex-row items-start md:items-center justify-between gap-5 hover:border-[var(--blue)] transition-all">

                <!-- INFO -->
                <div class="flex items-start gap-4 flex-1 min-w-0">
                    <div class="w-14 h-14 rounded-2xl bg-[var(--blue-light)] text-[var(--blue)] border border-[#bfdbfe] flex items-center justify-center text-xl flex-shrink-0 overflow-hidden shadow-sm">
                        @if($module->image_url)
                            <img src="{{ $module->image_url }}" alt="{{ $module->name }}" class="w-full h-full object-cover">
                        @else
                            <i class="{{ $module->icon ?: 'fas fa-book' }}"></i>
                        @endif
                    </div>

                    <div class="min-w-0 flex-1">
                        <div class="flex items-center gap-2 flex-wrap mb-1">
                            <h2 class="text-base font-extrabold text-[var(--ink)] truncate" title="{{ $module->name }}">
                                {{ $module->name }}
                            </h2>
                            @if($module->is_public)
                                <span class="pill blue-soft text-[10px]">🌐 Publik</span>
                            @else
                                <span class="pill pending text-[10px]">🔒 Privat</span>
                                @if($module->referral_code)
                                    <span class="text-[10px] font-mono font-bold text-amber-700 bg-amber-50 px-2 py-0.5 rounded border border-amber-200">
                                        REF: {{ $module->referral_code }}
                                    </span>
                                @endif
                            @endif
                        </div>

                        <p class="text-xs text-[var(--text2)] line-clamp-1 mb-2">
                            {{ $module->description ?: 'Dokumentasi pembelajaran interaktif dengan contoh kode praktis.' }}
                        </p>

                        <div class="flex items-center gap-3 text-xs text-[var(--muted)] font-medium flex-wrap">
                            <span><i class="fas fa-layer-group text-[var(--blue)] mr-1"></i> {{ $module->modules_count }} Bab Materi</span>
                            <span>·</span>
                            <span>{{ $module->created_at ? $module->created_at->format('d M Y') : '-' }}</span>
                            <span>·</span>
                            <!-- Toggle Active Form -->
                            <form action="{{ route('admin.modules.toggle-active', $module->id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" 
                                        class="pill {{ $module->is_active ? 'success-outline' : 'pending' }} text-[10px] cursor-pointer hover:opacity-80 transition"
                                        title="Klik untuk ubah status aktif/nonaktif">
                                    {{ $module->is_active ? '● Aktif' : '○ Nonaktif' }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- ACTIONS BUTTONS -->
                <div class="flex items-center gap-2 flex-wrap self-end md:self-center">
                    <a href="{{ route('modules.module.show', $module->slug) }}" target="_blank" class="btn btn-small btn-outline text-xs">
                        <i class="fas fa-external-link-alt mr-1"></i> Buka
                    </a>
                    
                    <a href="{{ route('admin.modules.contents.index', $module->id) }}" class="btn btn-small btn-gradient text-xs">
                        <i class="fas fa-list mr-1"></i> Materi ({{ $module->modules_count }})
                    </a>
                    
                    <a href="{{ route('admin.modules.edit', $module->id) }}" class="btn btn-small btn-outline text-xs p-2.5" title="Edit Modul">
                        <i class="fas fa-edit text-xs"></i>
                    </a>

                    @if(!$module->is_public)
                        <a href="{{ route('admin.modules.access.index', $module->id) }}" class="btn btn-small btn-outline text-xs p-2.5 text-amber-600" title="Hak Akses Siswa">
                            <i class="fas fa-key text-xs"></i>
                        </a>
                    @endif

                    <form action="{{ route('admin.modules.destroy', $module->id) }}" method="POST"
                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus modul {{ $module->name }} beserta seluruh materinya?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="p-2 rounded-lg text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition border border-transparent hover:border-rose-200" title="Hapus Modul">
                            <i class="fas fa-trash text-xs"></i>
                        </button>
                    </form>
                </div>

            </div>
        @empty
            <div class="cyber-card py-16 text-center bg-white border border-[var(--border)]">
                <div class="text-5xl mb-3">📖</div>
                <h3 class="text-base font-bold text-[var(--ink)] mb-1">Belum Ada Modul</h3>
                <p class="text-xs text-[var(--text2)] mb-5">Buat modul dokumentasi pertama untuk platform Anda.</p>
                <a href="{{ route('admin.modules.create') }}" class="btn btn-gradient text-xs">
                    <i class="fas fa-plus mr-1"></i> Tambah Modul Sekarang
                </a>
            </div>
        @endforelse
    </div>

    @if($modules->hasPages())
        <div class="mt-8 flex justify-center">
            {{ $modules->links() }}
        </div>
    @endif

</div>
@endsection
