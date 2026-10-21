@extends('layouts.app')

@section('title', 'Referral Codes Manager | Flow Academy Admin')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">

    <!-- Header -->
    <div class="flex flex-wrap items-center justify-between gap-4 mb-8 pb-4 border-b border-slate-800">
        <div>
            <div class="flex items-center gap-2 text-xs font-mono text-[var(--accent)] uppercase tracking-wider mb-1">
                <span>ADMIN PANEL</span>
                <i class="fas fa-chevron-right text-[9px]"></i>
                <span>REFERRAL CODES</span>
            </div>
            <h1 class="text-2xl font-extrabold text-white">Kelola Kode Referral & Diskon</h1>
            <p class="text-xs text-slate-400 mt-1">Kode referral dapat digunakan untuk membuka modul private atau diskon kursus berbayar</p>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('admin.modules.index') }}" class="cyber-btn text-xs">
                <i class="fas fa-arrow-left mr-1.5"></i> Module Manager
            </a>
            <a href="{{ route('admin.referral-codes.create') }}" class="cyber-btn text-xs" style="background: #8b5cf6; border-color: #8b5cf6;">
                <i class="fas fa-plus mr-1.5"></i> Buat Kode Baru
            </a>
        </div>
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

    <!-- Filters & Search Bar -->
    <div class="cyber-card p-4 mb-6">
        <form action="{{ route('admin.referral-codes.index') }}" method="GET" class="flex flex-wrap items-center justify-between gap-4">
            <div class="flex flex-wrap items-center gap-3 flex-1">
                <!-- Search Input -->
                <div class="w-full sm:w-64">
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}" 
                           placeholder="Cari kode referral..." 
                           class="cyber-input text-xs">
                </div>

                <!-- Discount Type Filter -->
                <select name="type" class="cyber-input text-xs w-auto">
                    <option value="">Semua Tipe Diskon</option>
                    <option value="free" {{ request('type') === 'free' ? 'selected' : '' }}>100% Gratis</option>
                    <option value="percentage" {{ request('type') === 'percentage' ? 'selected' : '' }}>Persentase (%)</option>
                    <option value="fixed" {{ request('type') === 'fixed' ? 'selected' : '' }}>Potongan Tetap (Rp)</option>
                </select>

                <!-- Target Filter -->
                <select name="target" class="cyber-input text-xs w-auto">
                    <option value="">Semua Target</option>
                    <option value="all" {{ request('target') === 'all' ? 'selected' : '' }}>Semua Produk</option>
                    <option value="course" {{ request('target') === 'course' ? 'selected' : '' }}>Kursus Tertentu</option>
                    <option value="module" {{ request('target') === 'module' ? 'selected' : '' }}>Modul Tertentu</option>
                </select>

                <button type="submit" class="cyber-btn text-xs">
                    <i class="fas fa-filter mr-1"></i> Filter
                </button>

                @if(request()->anyFilled(['search', 'type', 'target']))
                    <a href="{{ route('admin.referral-codes.index') }}" class="text-xs text-slate-400 hover:text-white underline">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Table of Codes -->
    <div class="cyber-card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-950/80 border-b border-slate-800 text-slate-400 uppercase font-mono tracking-wider">
                    <tr>
                        <th class="p-4">Kode Referral</th>
                        <th class="p-4">Tipe Diskon</th>
                        <th class="p-4">Target Berlakunya</th>
                        <th class="p-4">Penggunaan</th>
                        <th class="p-4">Kedaluwarsa</th>
                        <th class="p-4">Status</th>
                        <th class="p-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/60">
                    @forelse($referralCodes as $ref)
                        <tr class="hover:bg-slate-900/40 transition">
                            <!-- Code -->
                            <td class="p-4">
                                <div class="flex items-center gap-2">
                                    <span class="font-mono font-bold text-sm text-cyan-400 px-2.5 py-1 rounded-md bg-slate-900 border border-slate-700 select-all">
                                        {{ $ref->code }}
                                    </span>
                                </div>
                                @if($ref->description)
                                    <div class="text-[11px] text-slate-400 mt-1">{{ $ref->description }}</div>
                                @endif
                            </td>

                            <!-- Discount Type -->
                            <td class="p-4">
                                @if($ref->discount_type === 'free')
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-500/10 text-emerald-400 border border-emerald-500/30">
                                        <i class="fas fa-gift text-[9px]"></i> 100% GRATIS (Rp 0)
                                    </span>
                                @elseif($ref->discount_type === 'percentage')
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-bold bg-cyan-500/10 text-cyan-400 border border-cyan-500/30">
                                        <i class="fas fa-percent text-[9px]"></i> DISKON {{ $ref->discount_value }}%
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-bold bg-purple-500/10 text-purple-400 border border-purple-500/30">
                                        <i class="fas fa-tag text-[9px]"></i> -Rp {{ number_format($ref->discount_value, 0, ',', '.') }}
                                    </span>
                                @endif
                            </td>

                            <!-- Target -->
                            <td class="p-4">
                                @if($ref->target_type === 'all')
                                    <span class="text-slate-300 font-semibold">Semua Kursus & Modul</span>
                                @elseif($ref->target_type === 'course')
                                    <span class="text-cyan-300">
                                        <i class="fas fa-graduation-cap mr-1"></i>
                                        Kursus: {{ $courses->firstWhere('id', $ref->target_id)->title ?? 'ID: ' . $ref->target_id }}
                                    </span>
                                @elseif($ref->target_type === 'module')
                                    <span class="text-amber-300">
                                        <i class="fas fa-book mr-1"></i>
                                        Modul: {{ $moduleCategories->firstWhere('id', $ref->target_id)->name ?? 'ID: ' . $ref->target_id }}
                                    </span>
                                @endif
                            </td>

                            <!-- Usage -->
                            <td class="p-4">
                                <span class="font-mono text-white font-bold">{{ $ref->used_count }}</span>
                                <span class="text-slate-500">/ {{ $ref->max_uses ? $ref->max_uses . 'x' : 'Tak Terbatas' }}</span>
                            </td>

                            <!-- Expires At -->
                            <td class="p-4 text-slate-400 font-mono text-[11px]">
                                {{ $ref->expires_at ? $ref->expires_at->format('d M Y H:i') : 'Selamanya' }}
                            </td>

                            <!-- Status -->
                            <td class="p-4">
                                @if($ref->is_active)
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-mono font-bold bg-emerald-500/10 text-emerald-400 border border-emerald-500/30">
                                        ACTIVE
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-mono font-bold bg-rose-500/10 text-rose-400 border border-rose-500/30">
                                        INACTIVE
                                    </span>
                                @endif
                            </td>

                            <!-- Actions -->
                            <td class="p-4 text-right whitespace-nowrap">
                                <div class="inline-flex items-center gap-2">
                                    <a href="{{ route('admin.referral-codes.edit', $ref->id) }}" 
                                       class="px-2.5 py-1 rounded bg-slate-800 hover:bg-slate-700 text-slate-200 border border-slate-700 text-[11px] font-semibold transition">
                                        Edit
                                    </a>

                                    <form action="{{ route('admin.referral-codes.destroy', $ref->id) }}" method="POST"
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus kode referral {{ $ref->code }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-2.5 py-1 rounded bg-rose-950/40 hover:bg-rose-900 text-rose-400 border border-rose-800/60 text-[11px] font-semibold transition">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-8 text-center text-slate-500 italic">
                                Belum ada kode referral yang dibuat.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($referralCodes->hasPages())
            <div class="p-4 border-t border-slate-800">
                {{ $referralCodes->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
