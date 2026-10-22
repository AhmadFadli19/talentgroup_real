@extends('layouts.app')

@section('title', 'Manage Modules | Flow Academy')

@section('content')

<style>
/* ================= PIXEL / CYBER MODULE ADMIN ================= */
.pixel-admin-container {
    max-width: 1200px;
    margin: 0 auto;
}

/* HEADER */
.pixel-admin-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    flex-wrap: wrap;
    gap: 16px;
    margin-bottom: 28px;
}

.pixel-admin-title h1 {
    font-size: 18px;
    color: var(--accent);
    margin-bottom: 6px;
    font-weight: 800;
    letter-spacing: 0.5px;
}

.pixel-admin-title p {
    font-size: 9px;
    color: var(--muted);
}

.pixel-create-btn {
    background: #8b5cf6;
    border: 3px solid #8b5cf6;
    color: #fff;
    font-size: 9px;
    font-weight: 700;
    padding: 10px 14px;
    box-shadow: 4px 4px 0 var(--shadow);
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: transform 0.15s ease, box-shadow 0.15s ease;
}

.pixel-create-btn:hover {
    transform: translate(-2px,-2px);
    box-shadow: 6px 6px 0 var(--shadow);
    background: #7c3aed;
}

/* ALERT */
.pixel-alert {
    border: 2px solid #22c55e;
    background: #002a12;
    color: #86efac;
    padding: 12px;
    font-size: 9px;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 8px;
}

/* LIST */
.pixel-course-list {
    display: grid;
    grid-template-columns: 1fr;
    gap: 14px;
}

/* MODULE CARD */
.pixel-course-card {
    background: var(--card);
    border: 3px solid var(--border);
    box-shadow: 4px 4px 0 var(--shadow);
    padding: 16px;
    display: grid;
    grid-template-columns: 1fr auto;
    gap: 14px;
    align-items: center;
}

.pixel-course-info {
    display: flex;
    gap: 14px;
    align-items: flex-start;
}

.pixel-course-thumb {
    width: 60px;
    height: 60px;
    background: var(--bg);
    border: 2px solid var(--border);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    font-size: 24px;
}

.pixel-course-text h3 {
    font-size: 13px;
    color: var(--text);
    margin-bottom: 4px;
    font-weight: 700;
}

.pixel-course-text p {
    font-size: 10px;
    color: var(--muted);
    max-width: 550px;
    line-height: 1.5;
}

/* META */
.pixel-course-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
    margin-top: 8px;
    font-size: 9px;
    color: var(--muted);
    align-items: center;
}

.pixel-badge {
    border: 2px solid;
    padding: 2px 6px;
    font-size: 8px;
    font-weight: 700;
}

.pixel-active {
    border-color: #22c55e;
    color: #22c55e;
}

.pixel-inactive {
    border-color: #ff5555;
    color: #ff5555;
}

.pixel-public {
    border-color: #38bdf8;
    color: #38bdf8;
}

.pixel-private {
    border-color: #f59e0b;
    color: #f59e0b;
}

/* ACTIONS */
.pixel-course-actions {
    display: grid;
    gap: 6px;
    min-width: 90px;
}

.pixel-action-btn {
    border: 2px solid var(--border);
    background: var(--bg);
    font-size: 9px;
    font-weight: 700;
    padding: 6px 10px;
    color: var(--text);
    text-align: center;
    transition: all 0.15s ease;
    display: block;
}

.pixel-action-btn:hover {
    border-color: var(--accent);
    color: var(--accent);
}

/* EMPTY */
.pixel-empty {
    background: var(--card);
    border: 3px dashed var(--border);
    padding: 40px 20px;
    text-align: center;
}

.pixel-empty h3 {
    font-size: 12px;
    margin-bottom: 8px;
    color: var(--text);
}

.pixel-empty p {
    font-size: 9px;
    color: var(--muted);
    margin-bottom: 14px;
}

/* RESPONSIVE */
@media (max-width: 640px) {
    .pixel-course-card {
        grid-template-columns: 1fr;
    }

    .pixel-course-actions {
        grid-template-columns: repeat(3, 1fr);
    }
}
</style>

<div class="pixel-admin-container py-6">

    <!-- HEADER -->
    <div class="pixel-admin-header">
        <div class="pixel-admin-title">
            <h1>MODULE MANAGER</h1>
            <p>Kelola modul pembelajaran, materi bab, kode referral, dan hak akses pengguna</p>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('admin.referral-codes.index') }}" class="pixel-action-btn flex items-center gap-1.5" style="border-color: #8b5cf6; color: #c4b5fd;">
                <i class="fas fa-ticket-alt"></i>
                <span>REFERRAL CODES</span>
            </a>

            <a href="{{ route('admin.modules.create') }}" class="pixel-create-btn">
                <i class="fas fa-plus"></i>
                <span>CREATE MODULE</span>
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="pixel-alert">
            <i class="fas fa-check-circle"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- FILTER TABS -->
    <div class="flex flex-wrap items-center gap-2 mb-6 text-xs">
        @php
            $currentStatus = request('status');
            $currentVis = request('visibility');
        @endphp
        <a href="{{ route('admin.modules.index') }}" 
           class="px-3 py-1.5 rounded-lg border {{ !$currentStatus && !$currentVis ? 'bg-slate-800 text-cyan-400 border-cyan-500/50 font-bold' : 'bg-slate-900 text-slate-400 border-slate-800 hover:text-white' }} transition">
            Semua Modul
        </a>
        <a href="{{ route('admin.modules.index', ['status' => 'active']) }}" 
           class="px-3 py-1.5 rounded-lg border {{ $currentStatus === 'active' ? 'bg-emerald-950/60 text-emerald-400 border-emerald-500/50 font-bold' : 'bg-slate-900 text-slate-400 border-slate-800 hover:text-white' }} transition">
            ● Aktif (Active)
        </a>
        <a href="{{ route('admin.modules.index', ['status' => 'inactive']) }}" 
           class="px-3 py-1.5 rounded-lg border {{ $currentStatus === 'inactive' ? 'bg-rose-950/60 text-rose-400 border-rose-500/50 font-bold' : 'bg-slate-900 text-slate-400 border-slate-800 hover:text-white' }} transition">
            ○ Nonaktif (Inactive)
        </a>
        <a href="{{ route('admin.modules.index', ['visibility' => 'public']) }}" 
           class="px-3 py-1.5 rounded-lg border {{ $currentVis === 'public' ? 'bg-sky-950/60 text-sky-400 border-sky-500/50 font-bold' : 'bg-slate-900 text-slate-400 border-slate-800 hover:text-white' }} transition">
            🌐 Public
        </a>
        <a href="{{ route('admin.modules.index', ['visibility' => 'private']) }}" 
           class="px-3 py-1.5 rounded-lg border {{ $currentVis === 'private' ? 'bg-amber-950/60 text-amber-400 border-amber-500/50 font-bold' : 'bg-slate-900 text-slate-400 border-slate-800 hover:text-white' }} transition">
            🔒 Private
        </a>
    </div>

    <!-- LIST OF MODULES -->
    <div class="pixel-course-list">

        @forelse($modules as $module)
            <div class="pixel-course-card">

                <!-- INFO -->
                <div>
                    <div class="pixel-course-info">
                        <!-- THUMBNAIL / ICON -->
                        <div class="pixel-course-thumb" style="border-color: {{ $module->color ?: 'var(--border)' }}; color: {{ $module->color ?: 'var(--accent)' }}; overflow: hidden;">
                            @if($module->image_url)
                                <img src="{{ $module->image_url }}" alt="{{ $module->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                            @else
                                <i class="{{ $module->icon ?: 'fas fa-book' }}"></i>
                            @endif
                        </div>

                        <!-- TEXT & METADATA -->
                        <div class="pixel-course-text">
                            <h3>{{ $module->name }}</h3>
                            <p>{{ Str::limit($module->description ?: 'Dokumentasi pembelajaran interaktif dengan contoh kode.', 100) }}</p>

                            <div class="pixel-course-meta">
                                <!-- PUBLIC OR PRIVATE BADGE -->
                                @if($module->is_public)
                                    <span class="pixel-badge pixel-public">🌐 PUBLIC (GRATIS)</span>
                                @else
                                    <span class="pixel-badge pixel-private">🔒 PRIVATE</span>
                                    @if($module->referral_code)
                                        <span class="font-mono" style="color: #fbbf24;">🔑 REF: {{ $module->referral_code }}</span>
                                    @endif
                                @endif

                                <span>📚 {{ $module->modules_count }} Bab Materi</span>
                                <span>📅 {{ $module->created_at ? $module->created_at->format('M d, Y') : '-' }}</span>

                                <!-- Quick Toggle Active / Inactive -->
                                <form action="{{ route('admin.modules.toggle-active', $module->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" 
                                            class="pixel-badge cursor-pointer transition {{ $module->is_active ? 'pixel-active hover:bg-emerald-950/60' : 'pixel-inactive hover:bg-rose-950/60' }}"
                                            title="Klik untuk ubah status aktif/nonaktif">
                                        {{ $module->is_active ? '● ACTIVE (Klik Nonaktifkan)' : '○ INACTIVE (Klik Aktifkan)' }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ACTIONS -->
                <div class="pixel-course-actions">
                    <a href="{{ route('modules.module.show', $module->slug) }}" target="_blank" class="pixel-action-btn">
                        VIEW
                    </a>
                    
                    <a href="{{ route('admin.modules.contents.index', $module->id) }}" class="pixel-action-btn" style="border-color: #38bdf8; color: #38bdf8;">
                        CONTENT
                    </a>
                    
                    <a href="{{ route('admin.modules.edit', $module->id) }}" class="pixel-action-btn">
                        EDIT
                    </a>

                    @if(!$module->is_public)
                        <a href="{{ route('admin.modules.access.index', $module->id) }}" class="pixel-action-btn" style="border-color: #f59e0b; color: #f59e0b;">
                            ACCESS
                        </a>
                    @endif

                    <form action="{{ route('admin.modules.destroy', $module->id) }}" method="POST"
                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus modul {{ $module->name }} beserta seluruh materinya?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="pixel-action-btn w-full" style="color:#ff5555">
                            DELETE
                        </button>
                    </form>
                </div>

            </div>
        @empty
            <div class="pixel-empty">
                <h3>NO MODULES FOUND</h3>
                <p>Belum ada modul yang dibuat. Buat modul pertama Anda sekarang.</p>
                <a href="{{ route('admin.modules.create') }}" class="pixel-create-btn">
                    CREATE MODULE
                </a>
            </div>
        @endforelse

    </div>

    @if($modules->hasPages())
        <div class="pixel-pagination mt-6">
            {{ $modules->links() }}
        </div>
    @endif

</div>
@endsection
