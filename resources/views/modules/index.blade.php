@extends('layouts.app')

@section('title', 'Katalog Modul Pembelajaran | TalentGroup')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 py-8">

    <!-- Top Navigation & Return Button -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
        <div>
            <button type="button" 
                    onclick="handleSmartGoBack()" 
                    class="btn-outline px-3.5 py-1.5 rounded-xl text-xs font-bold inline-flex items-center gap-2 group mb-2">
                <i class="fas fa-arrow-left text-[var(--blue)] group-hover:-translate-x-1 transition-transform"></i>
                <span>Kembali ke Halaman Sebelumnya</span>
            </button>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-[var(--ink)] tracking-tight">Katalog Modul Pembelajaran</h1>
            <p class="text-xs sm:text-sm text-[var(--muted)] mt-1">Eksplorasi dokumentasi, modul panduan praktis, dan materi kurikulum pemrograman.</p>
        </div>

        @auth
            @if(auth()->user()->isAdmin())
                <div>
                    <a href="{{ route('admin.modules.index') }}" 
                       class="px-4 py-2 rounded-xl bg-blue-50 text-[var(--blue)] border border-blue-200 text-xs font-bold hover:bg-blue-100 transition inline-flex items-center gap-2">
                        <i class="fas fa-cog"></i>
                        <span>MODUL MANAGER (ADMIN)</span>
                    </a>
                </div>
            @endif
        @endauth
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 rounded-xl border border-emerald-200 bg-emerald-50 text-emerald-800 text-xs flex items-center gap-3">
            <i class="fas fa-check-circle text-emerald-600 text-base"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 p-4 rounded-xl border border-rose-200 bg-rose-50 text-rose-800 text-xs flex items-center gap-3">
            <i class="fas fa-exclamation-triangle text-rose-600 text-base"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <!-- CATEGORY FILTER & SEARCH -->
    <div class="bg-white border border-[var(--border)] rounded-2xl p-6 mb-8 shadow-sm flex flex-col md:flex-row items-stretch md:items-center justify-between gap-6">
        <!-- Category Filter -->
        <div class="flex flex-col gap-2">
            <div class="text-[11px] font-extrabold uppercase tracking-wider text-[var(--muted)] flex items-center gap-2">
                <i class="fas fa-filter text-[var(--blue)]"></i>
                <span>Filter Akses</span>
            </div>
            <div class="flex flex-wrap items-center gap-2">
                <a href="{{ route('modules.index') }}" 
                   class="px-4 py-2 rounded-xl text-xs font-bold transition {{ !request()->filled('type') ? 'bg-[var(--blue)] text-white shadow-sm' : 'bg-slate-50 text-[var(--muted)] hover:bg-slate-100 border border-[var(--border)]' }}">
                    Semua Modul
                </a>
                <a href="{{ route('modules.index', ['type' => 'free']) }}" 
                   class="px-4 py-2 rounded-xl text-xs font-bold transition {{ request('type') === 'free' ? 'bg-[var(--blue)] text-white shadow-sm' : 'bg-slate-50 text-[var(--muted)] hover:bg-slate-100 border border-[var(--border)]' }}">
                    Gratis (Free)
                </a>
                <a href="{{ route('modules.index', ['type' => 'premium']) }}" 
                   class="px-4 py-2 rounded-xl text-xs font-bold transition {{ request('type') === 'premium' ? 'bg-[var(--blue)] text-white shadow-sm' : 'bg-slate-50 text-[var(--muted)] hover:bg-slate-100 border border-[var(--border)]' }}">
                    Premium / Private
                </a>
            </div>
        </div>

        <!-- Search Query -->
        <div class="flex-1 max-w-md flex flex-col gap-2">
            <div class="text-[11px] font-extrabold uppercase tracking-wider text-[var(--muted)] flex items-center gap-2">
                <i class="fas fa-search text-[var(--blue)]"></i>
                <span>Cari Modul</span>
            </div>
            <form action="{{ route('modules.index') }}" method="GET" class="flex items-center gap-2">
                @if(request()->filled('type'))
                    <input type="hidden" name="type" value="{{ request('type') }}">
                @endif
                <div class="relative flex-1">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-[var(--muted)] text-xs">
                        <i class="fas fa-search"></i>
                    </span>
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}" 
                           placeholder="Ketik topik atau nama modul..." 
                           class="w-full pl-9 pr-4 py-2.5 bg-slate-50 border border-[var(--border)] rounded-xl text-xs text-[var(--ink)] focus:bg-white focus:border-[var(--blue)] focus:outline-none transition">
                </div>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-[var(--blue)] hover:bg-[var(--blue-dark)] text-white text-xs font-bold shadow-sm transition">
                    Cari
                </button>
            </form>
        </div>
    </div>

    <!-- MODULE CARDS GRID -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        @forelse($modules as $item)
            @php
                $hasAccess = $item->hasAccessForUser(auth()->user());
                $accentColor = $item->color ?: 'var(--blue)';
                $lessonsCount = $item->lessons_count ?? $item->publishedModules->count();
            @endphp
            <div class="bg-white border border-[var(--border)] rounded-2xl p-6 shadow-sm hover:shadow-md transition-all duration-200 flex flex-col justify-between group">
                <div>
                    <!-- Top Icon & Badge -->
                    <div class="flex items-start justify-between gap-4 mb-4">
                        <div class="w-12 h-12 rounded-xl flex items-center justify-center text-xl bg-blue-50 border border-blue-100 text-[var(--blue)] flex-shrink-0">
                            @if($item->image_url)
                                <img src="{{ $item->image_url }}" alt="{{ $item->name }}" class="w-full h-full object-cover rounded-xl">
                            @else
                                <i class="{{ $item->icon ?: 'fas fa-book' }}"></i>
                            @endif
                        </div>

                        <div>
                            @if($item->is_public)
                                <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-emerald-50 text-emerald-700 border border-emerald-200 inline-flex items-center gap-1">
                                    <i class="fas fa-star text-[9px]"></i> FREE
                                </span>
                            @else
                                <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-amber-50 text-amber-700 border border-amber-200 inline-flex items-center gap-1">
                                    <i class="fas fa-lock text-[9px]"></i> PRIVATE
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Title -->
                    <h3 class="text-base font-bold text-[var(--ink)] leading-snug mb-2 group-hover:text-[var(--blue)] transition-colors">
                        {{ $item->name }}
                    </h3>

                    <!-- Description -->
                    <p class="text-xs text-[var(--muted)] line-clamp-3 leading-relaxed mb-4">
                        {{ $item->description ?: 'Dokumentasi pembelajaran mandiri dengan penjelasan interaktif dan contoh nyata.' }}
                    </p>

                    <!-- Features -->
                    <div class="space-y-2 mb-6 pt-3 border-t border-[var(--border)]">
                        <div class="flex items-center gap-2 text-xs text-[var(--body)]">
                            <i class="fas fa-book-bookmark text-[var(--blue)] text-xs"></i>
                            <span>Akses Materi Lengkap ({{ $lessonsCount }} Bab)</span>
                        </div>
                        <div class="flex items-center gap-2 text-xs text-[var(--body)]">
                            <i class="fas fa-shield-halved text-emerald-600 text-xs"></i>
                            <span>Proteksi Konten Digital</span>
                        </div>
                        <div class="flex items-center gap-2 text-xs text-[var(--body)]">
                            <i class="fas fa-certificate text-indigo-600 text-xs"></i>
                            <span>Sertifikat Pelatihan</span>
                        </div>
                    </div>
                </div>

                <!-- Bottom Cost & Button -->
                <div class="pt-4 border-t border-[var(--border)]">
                    <div class="flex items-center justify-between text-xs mb-3">
                        <span class="text-[10px] font-extrabold uppercase tracking-wider text-[var(--muted)]">BIAYA AKSES</span>
                        @if($item->is_public)
                            <span class="text-emerald-600 font-extrabold text-sm">GRATIS</span>
                        @else
                            <span class="text-amber-600 font-extrabold text-xs font-mono">KODE REFERRAL</span>
                        @endif
                    </div>

                    @if($hasAccess)
                        <a href="{{ route('modules.module.show', $item->slug) }}" class="btn-gradient w-full py-2.5 rounded-xl text-white text-xs font-bold text-center shadow-sm flex items-center justify-center gap-2">
                            <span>Buka Modul</span>
                            <i class="fas fa-arrow-right text-xs"></i>
                        </a>
                    @else
                        <!-- Private module locked: prompt referral unlock modal -->
                        <button type="button" 
                                onclick="openUnlockModal({{ $item->id }}, '{{ addslashes($item->name) }}')"
                                class="w-full py-2.5 rounded-xl bg-amber-500 hover:bg-amber-600 text-white text-xs font-bold text-center shadow-sm flex items-center justify-center gap-2 transition">
                            <i class="fas fa-key text-xs"></i>
                            <span>Buka dengan Kode Akses</span>
                            <i class="fas fa-arrow-right text-xs"></i>
                        </button>
                    @endif
                </div>
            </div>
        @empty
            <div class="col-span-full py-16 px-6 text-center bg-white rounded-2xl border border-[var(--border)] shadow-sm">
                <i class="fas fa-search text-3xl text-slate-300 mb-3 block"></i>
                <h3 class="text-sm font-bold text-[var(--ink)] mb-1">Tidak Ada Modul Ditemukan</h3>
                <p class="text-xs text-[var(--muted)]">Coba ubah kata kunci pencarian atau filter kategori di atas.</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($modules->hasPages())
        <div class="mt-8 flex justify-center">
            {{ $modules->links() }}
        </div>
    @endif

</div>

<!-- Unlock Modal for Private Modules -->
<div id="unlockModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/60 backdrop-blur-sm p-4">
    <div class="relative w-full max-w-md rounded-2xl border border-[var(--border)] bg-white p-6 md:p-8 shadow-2xl">
        <div class="flex items-center justify-between pb-4 mb-4 border-b border-[var(--border)]">
            <div class="flex items-center gap-2.5 text-[var(--ink)] font-bold text-sm">
                <i class="fas fa-key text-amber-500"></i>
                <span>Buka Akses Modul Private</span>
            </div>
            <button type="button" onclick="closeUnlockModal()" class="w-8 h-8 rounded-lg bg-slate-100 hover:bg-slate-200 text-[var(--muted)] hover:text-[var(--ink)] flex items-center justify-center transition">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <form action="{{ route('modules.unlock') }}" method="POST">
            @csrf
            <input type="hidden" name="module_id" id="modalModuleId">

            <div class="mb-4">
                <label class="block text-xs font-mono uppercase text-[var(--muted)] mb-1">Modul yang Dipilih:</label>
                <div id="modalModuleTitle" class="text-[var(--ink)] font-bold text-sm p-3 rounded-xl bg-slate-50 border border-[var(--border)]">
                    -
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-xs font-bold text-[var(--ink)] mb-2">
                    Masukkan Kode Referral / Kode Akses:
                </label>
                <input type="text" 
                       name="referral_code" 
                       required 
                       placeholder="Contoh: CSSPRO, JSMASTER, dsb."
                       class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-[var(--border)] text-[var(--blue)] font-mono uppercase tracking-wider text-sm outline-none focus:bg-white focus:border-[var(--blue)] transition font-bold">
                <p class="text-[11px] text-[var(--muted)] mt-1.5 leading-relaxed">
                    Modul private dapat dibuka menggunakan kode referral resmi atau persetujuan admin.
                </p>
            </div>

            <div class="flex items-center justify-end gap-3 pt-4 border-t border-[var(--border)]">
                <button type="button" onclick="closeUnlockModal()" class="btn-outline px-4 py-2 rounded-xl text-xs font-bold">
                    Batal
                </button>
                <button type="submit" class="btn-gradient px-5 py-2 rounded-xl text-white text-xs font-bold flex items-center gap-2 shadow-sm">
                    <i class="fas fa-unlock"></i>
                    <span>Buka Akses Sekarang</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function handleSmartGoBack() {
        if (document.referrer && document.referrer.indexOf(window.location.host) === -1) {
            window.history.back();
        } else if (window.history.length > 1) {
            window.history.back();
        } else {
            window.location.href = "{{ route('home') }}";
        }
    }

    function openUnlockModal(moduleId, moduleTitle) {
        @guest
            window.location.href = "{{ route('login') }}";
            return;
        @endguest

        document.getElementById('modalModuleId').value = moduleId;
        document.getElementById('modalModuleTitle').innerText = moduleTitle;
        const modal = document.getElementById('unlockModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeUnlockModal() {
        const modal = document.getElementById('unlockModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
</script>
@endsection
