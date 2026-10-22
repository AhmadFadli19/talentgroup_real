@extends('layouts.app')

@section('title', 'Katalog Modul Pembelajaran | talentgroup.id')

@section('content')
<style>
/* ================= MODULE CATALOG ================= */
.catalog-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 24px 16px 60px;
}

/* TOP FILTER & SEARCH BAR */
.filter-search-box {
    background: #080d1a;
    border: 1px solid #1e293b;
    border-radius: 16px;
    padding: 20px 24px;
    margin-bottom: 32px;
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.4);
}

.filter-group {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.filter-label {
    font-size: 11px;
    font-weight: 800;
    letter-spacing: 1px;
    color: #94a3b8;
    display: flex;
    align-items: center;
    gap: 6px;
    text-transform: uppercase;
}

.filter-pills {
    display: flex;
    align-items: center;
    gap: 8px;
    flex-wrap: wrap;
}

.filter-pill {
    padding: 6px 18px;
    border-radius: 8px;
    font-size: 12px;
    font-weight: 700;
    transition: all 0.2s ease;
    text-decoration: none;
    display: inline-block;
}

.filter-pill.active {
    background: #8b5cf6;
    color: #ffffff;
    box-shadow: 0 4px 14px rgba(139, 92, 246, 0.4);
}

.filter-pill.inactive {
    background: #0f172a;
    border: 1px solid #1e293b;
    color: #94a3b8;
}

.filter-pill.inactive:hover {
    background: #1e293b;
    color: #ffffff;
}

.search-group {
    flex: 1;
    max-width: 460px;
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.search-input-wrap {
    display: flex;
    align-items: stretch;
    background: #030712;
    border: 1px solid #1e293b;
    border-radius: 10px;
    overflow: hidden;
}

.search-input {
    flex: 1;
    background: transparent;
    border: none;
    padding: 10px 14px;
    font-size: 12px;
    color: #e2e8f0;
    outline: none;
}

.search-input::placeholder {
    color: #64748b;
}

.search-btn {
    background: #8b5cf6;
    border: none;
    color: #ffffff;
    padding: 0 16px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background 0.2s;
}

.search-btn:hover {
    background: #7c3aed;
}

/* CARDS GRID */
.module-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
    gap: 24px;
    margin-bottom: 40px;
}

.module-card {
    background: #0c1322;
    border: 1px solid #1e293b;
    border-radius: 18px;
    padding: 22px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    transition: transform 0.25s ease, border-color 0.25s ease, box-shadow 0.25s ease;
    box-shadow: 0 12px 24px -8px rgba(0, 0, 0, 0.5);
    position: relative;
    overflow: hidden;
}

.module-card:hover {
    transform: translateY(-4px);
    border-color: #38bdf8;
    box-shadow: 0 20px 30px -10px rgba(56, 189, 248, 0.15);
}

.card-top {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 14px;
    margin-bottom: 16px;
}

.card-thumb {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    background: #030712;
    border: 1px solid #1e293b;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    flex-shrink: 0;
    box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.4);
}

.card-badge {
    padding: 4px 10px;
    border-radius: 6px;
    font-size: 10px;
    font-weight: 800;
    letter-spacing: 0.5px;
    text-transform: uppercase;
    display: inline-flex;
    align-items: center;
    gap: 5px;
}

.badge-free {
    background: rgba(34, 197, 94, 0.12);
    border: 1px solid rgba(34, 197, 94, 0.4);
    color: #4ade80;
}

.badge-premium {
    background: rgba(245, 158, 11, 0.12);
    border: 1px solid rgba(245, 158, 11, 0.4);
    color: #fbbf24;
}

.card-title {
    font-size: 16px;
    font-weight: 800;
    color: #ffffff;
    margin-bottom: 8px;
    line-height: 1.35;
}

.card-desc {
    font-size: 11.5px;
    color: #94a3b8;
    line-height: 1.55;
    margin-bottom: 16px;
    min-height: 36px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.card-features {
    display: flex;
    flex-direction: column;
    gap: 6px;
    padding-bottom: 16px;
    margin-bottom: 16px;
    border-bottom: 1px solid #1e293b;
    font-size: 11px;
    color: #cbd5e1;
}

.card-feature-item {
    display: flex;
    align-items: center;
    gap: 8px;
}

.card-bottom {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.cost-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: 11px;
}

.cost-label {
    font-weight: 800;
    letter-spacing: 1px;
    color: #64748b;
    text-transform: uppercase;
}

.cost-val-free {
    color: #22c55e;
    font-weight: 800;
    font-size: 14px;
}

.cost-val-premium {
    color: #fbbf24;
    font-weight: 800;
    font-size: 14px;
}

/* INITIALIZE VIEW BUTTON */
.btn-initialize {
    background: linear-gradient(135deg, #8b5cf6 0%, #6d28d9 100%);
    color: #ffffff;
    font-size: 12px;
    font-weight: 700;
    padding: 11px 18px;
    border-radius: 10px;
    text-align: center;
    text-decoration: none;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    transition: all 0.2s ease;
    border: none;
    cursor: pointer;
    box-shadow: 0 4px 14px rgba(109, 40, 217, 0.4);
}

.btn-initialize:hover {
    background: linear-gradient(135deg, #9333ea 0%, #7e22ce 100%);
    transform: translateY(-1px);
    box-shadow: 0 6px 18px rgba(109, 40, 217, 0.6);
}

.btn-initialize-locked {
    background: linear-gradient(135deg, #d97706 0%, #b45309 100%);
    box-shadow: 0 4px 14px rgba(217, 119, 6, 0.4);
}

.btn-initialize-locked:hover {
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    box-shadow: 0 6px 18px rgba(217, 119, 6, 0.6);
}
</style>

<div class="catalog-container">

    <!-- Top Navigation & Return Button (Handles Google / History Navigation smoothly) -->
    <div class="flex items-center justify-between gap-4 mb-6">
        <button type="button" 
                onclick="handleSmartGoBack()" 
                class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-lg bg-slate-900 hover:bg-slate-800 text-slate-300 hover:text-white border border-slate-800 text-xs font-semibold transition group">
            <i class="fas fa-arrow-left text-cyan-400 group-hover:-translate-x-1 transition-transform"></i>
            <span>Kembali ke Halaman Sebelumnya</span>
        </button>

        @auth
            @if(auth()->user()->isAdmin())
                <a href="{{ route('admin.modules.index') }}" 
                   class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-cyan-500/10 text-cyan-400 border border-cyan-500/30 text-xs font-semibold hover:bg-cyan-500/20 transition">
                    <i class="fas fa-cog"></i>
                    <span>MODULE MANAGER (ADMIN)</span>
                </a>
            @endif
        @endauth
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 rounded-xl border border-emerald-500/40 bg-emerald-950/30 text-emerald-300 text-xs flex items-center gap-3">
            <i class="fas fa-check-circle text-emerald-400 text-base"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 p-4 rounded-xl border border-rose-500/40 bg-rose-950/30 text-rose-300 text-xs flex items-center gap-3">
            <i class="fas fa-exclamation-triangle text-rose-400 text-base"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <!-- CATEGORY FILTER & SEARCH -->
    <div class="filter-search-box">
        <!-- Category Filter -->
        <div class="filter-group">
            <div class="filter-label">
                <i class="fas fa-filter text-purple-400"></i>
                <span>CATEGORY FILTER</span>
            </div>
            <div class="filter-pills">
                <a href="{{ route('modules.index') }}" 
                   class="filter-pill {{ !request()->filled('type') ? 'active' : 'inactive' }}">
                    All
                </a>
                <a href="{{ route('modules.index', ['type' => 'free']) }}" 
                   class="filter-pill {{ request('type') === 'free' ? 'active' : 'inactive' }}">
                    Free
                </a>
                <a href="{{ route('modules.index', ['type' => 'premium']) }}" 
                   class="filter-pill {{ request('type') === 'premium' ? 'active' : 'inactive' }}">
                    Premium / Private
                </a>
            </div>
        </div>

        <!-- Search Query -->
        <div class="search-group">
            <div class="filter-label">
                <i class="fas fa-search text-purple-400"></i>
                <span>SEARCH QUERY</span>
            </div>
            <form action="{{ route('modules.index') }}" method="GET" class="search-input-wrap">
                @if(request()->filled('type'))
                    <input type="hidden" name="type" value="{{ request('type') }}">
                @endif
                <input type="text" 
                       name="search" 
                       value="{{ request('search') }}" 
                       placeholder="Enter module name or topic ..." 
                       class="search-input">
                <button type="submit" class="search-btn" title="Cari Modul">
                    <i class="fas fa-search text-xs"></i>
                </button>
            </form>
        </div>
    </div>

    <!-- MODULE CARDS GRID -->
    <div class="module-grid">
        @forelse($modules as $item)
            @php
                $hasAccess = $item->hasAccessForUser(auth()->user());
                $accentColor = $item->color ?: '#8b5cf6';
                $lessonsCount = $item->lessons_count ?? $item->publishedModules->count();
            @endphp
            <div class="module-card">
                <div>
                    <!-- Top Icon & Badge -->
                    <div class="card-top">
                        <div class="card-thumb" style="color: {{ $accentColor }}; border-color: {{ $accentColor }}40; overflow: hidden;">
                            @if($item->image_url)
                                <img src="{{ $item->image_url }}" alt="{{ $item->name }}" class="w-full h-full object-cover">
                            @else
                                <i class="{{ $item->icon ?: 'fas fa-code' }}"></i>
                            @endif
                        </div>

                        <div>
                            @if($item->is_public)
                                <span class="card-badge badge-free">
                                    <i class="fas fa-star text-[9px]"></i> FREE
                                </span>
                            @else
                                <span class="card-badge badge-premium">
                                    <i class="fas fa-gem text-[9px]"></i> PREMIUM
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Title -->
                    <h3 class="card-title">
                        {{ $item->name }}
                    </h3>

                    <!-- Description -->
                    <p class="card-desc">
                        {{ $item->description ?: 'Dokumentasi pembelajaran mandiri dengan penjelasan interaktif dan contoh nyata.' }}
                    </p>

                    <!-- Features -->
                    <div class="card-features">
                        <div class="card-feature-item">
                            <i class="fas fa-book-bookmark text-purple-400 text-xs"></i>
                            <span>Full Material Access ({{ $lessonsCount }} Bab)</span>
                        </div>
                        <div class="card-feature-item">
                            <i class="fas fa-shield-halved text-cyan-400 text-xs"></i>
                            <span>Anti-Screenshot Content Protection</span>
                        </div>
                        <div class="card-feature-item">
                            <i class="fas fa-certificate text-purple-400 text-xs"></i>
                            <span>Certificate Provided</span>
                        </div>
                    </div>
                </div>

                <!-- Bottom Cost & Button -->
                <div class="card-bottom">
                    <div class="cost-row">
                        <span class="cost-label">COST</span>
                        @if($item->is_public)
                            <span class="cost-val-free">FREE</span>
                        @else
                            <span class="cost-val-premium">Rp 0 (KODE REFERRAL)</span>
                        @endif
                    </div>

                    @if($hasAccess)
                        <a href="{{ route('modules.module.show', $item->slug) }}" class="btn-initialize">
                            <span>Initialize View</span>
                            <i class="fas fa-arrow-right text-xs"></i>
                        </a>
                    @else
                        <!-- Private module locked: prompt referral unlock modal -->
                        <button type="button" 
                                onclick="openUnlockModal({{ $item->id }}, '{{ addslashes($item->name) }}')"
                                class="btn-initialize btn-initialize-locked">
                            <i class="fas fa-key text-xs"></i>
                            <span>Initialize View (Enter Code)</span>
                            <i class="fas fa-arrow-right text-xs"></i>
                        </button>
                    @endif
                </div>
            </div>
        @empty
            <div class="col-span-full py-16 text-center bg-slate-900/60 rounded-2xl border border-slate-800">
                <i class="fas fa-search text-3xl text-slate-600 mb-3"></i>
                <h3 class="text-sm font-bold text-white mb-1">Tidak Ada Modul Ditemukan</h3>
                <p class="text-xs text-slate-400">Coba ubah kata kunci pencarian atau filter kategori di atas.</p>
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
<div id="unlockModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/85 backdrop-blur-md p-4">
    <div class="relative w-full max-w-md rounded-2xl border border-slate-700 bg-slate-900 p-6 shadow-2xl">
        <div class="flex items-center justify-between pb-4 mb-4 border-b border-slate-800">
            <div class="flex items-center gap-2.5 text-amber-400 font-bold text-sm">
                <i class="fas fa-key text-base"></i>
                <span>Buka Akses Modul Private</span>
            </div>
            <button type="button" onclick="closeUnlockModal()" class="text-slate-400 hover:text-white text-sm">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <form action="{{ route('modules.unlock') }}" method="POST">
            @csrf
            <input type="hidden" name="module_id" id="modalModuleId">

            <div class="mb-4">
                <label class="block text-xs font-mono uppercase text-slate-400 mb-1">Modul yang Dipilih:</label>
                <div id="modalModuleTitle" class="text-white font-bold text-sm p-3 rounded-xl bg-slate-950 border border-slate-800">
                    -
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-xs font-bold text-white mb-2">
                    Masukkan Kode Referral / Kode Akses:
                </label>
                <input type="text" 
                       name="referral_code" 
                       required 
                       placeholder="Contoh: CSSPRO, JSMASTER, dsb."
                       class="w-full px-3.5 py-2.5 rounded-xl bg-slate-950 border border-slate-700 text-cyan-300 font-mono uppercase tracking-wider text-sm outline-none focus:border-cyan-400 transition">
                <p class="text-[11px] text-slate-400 mt-1.5">
                    Modul private dapat dibuka menggunakan kode referral atau persetujuan admin.
                </p>
            </div>

            <div class="flex items-center justify-end gap-3">
                <button type="button" onclick="closeUnlockModal()" class="px-4 py-2 rounded-xl text-xs font-semibold text-slate-400 hover:text-white">
                    Batal
                </button>
                <button type="submit" class="btn-initialize text-xs flex items-center gap-2">
                    <i class="fas fa-unlock"></i>
                    <span>Buka Akses Sekarang</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Smart Go Back supporting Google Referrer or Browser History
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
