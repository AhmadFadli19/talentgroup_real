@extends('layouts.app')

@section('title', 'Referral Codes Manager | Admin TalentGroup')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">

    <!-- Header -->
    <div class="flex flex-wrap items-center justify-between gap-4 mb-8 pb-4 border-b border-[var(--border)]">
        <div>
            <div class="flex items-center gap-2 text-xs font-mono text-[var(--blue)] uppercase tracking-wider mb-1">
                <span>ADMIN PANEL</span>
                <i class="fas fa-chevron-right text-[9px]"></i>
                <span>REFERRAL CODES</span>
            </div>
            <h1 class="text-2xl font-extrabold text-[var(--ink)]">Kelola Kode Referral & Diskon</h1>
            <p class="text-xs text-[var(--muted)] mt-1">Kode referral dapat digunakan untuk membuka modul private atau diskon kursus berbayar</p>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('admin.modules.index') }}" class="btn-outline px-4 py-2.5 rounded-xl text-xs font-bold inline-flex items-center gap-2">
                <i class="fas fa-arrow-left"></i> Module Manager
            </a>
            <a href="{{ route('admin.referral-codes.create') }}" class="btn-gradient px-4 py-2.5 rounded-xl text-white text-xs font-bold shadow-sm inline-flex items-center gap-2">
                <i class="fas fa-plus"></i> Buat Kode Baru
            </a>
        </div>
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

    <!-- Filters & Search Bar -->
    <div class="rounded-2xl bg-white border border-[var(--border)] p-4 mb-6 shadow-sm">
        <form action="{{ route('admin.referral-codes.index') }}" method="GET" class="flex flex-wrap items-center justify-between gap-4">
            <div class="flex flex-wrap items-center gap-3 flex-1">
                <!-- Search Input -->
                <div class="w-full sm:w-64">
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}" 
                           placeholder="Cari kode referral..." 
                           class="w-full px-3.5 py-2 bg-slate-50 border border-[var(--border)] rounded-xl text-xs text-[var(--ink)] focus:bg-white focus:border-[var(--blue)] focus:outline-none transition">
                </div>

                <!-- Discount Type Filter -->
                <select name="type" class="px-3.5 py-2 bg-slate-50 border border-[var(--border)] rounded-xl text-xs text-[var(--ink)] focus:bg-white focus:border-[var(--blue)] focus:outline-none transition">
                    <option value="">Semua Tipe Diskon</option>
                    <option value="free" {{ request('type') === 'free' ? 'selected' : '' }}>100% Gratis</option>
                    <option value="percentage" {{ request('type') === 'percentage' ? 'selected' : '' }}>Persentase (%)</option>
                    <option value="fixed" {{ request('type') === 'fixed' ? 'selected' : '' }}>Potongan Tetap (Rp)</option>
                </select>

                <!-- Target Filter -->
                <select name="target" class="px-3.5 py-2 bg-slate-50 border border-[var(--border)] rounded-xl text-xs text-[var(--ink)] focus:bg-white focus:border-[var(--blue)] focus:outline-none transition">
                    <option value="">Semua Target</option>
                    <option value="all" {{ request('target') === 'all' ? 'selected' : '' }}>Semua Produk</option>
                    <option value="course" {{ request('target') === 'course' ? 'selected' : '' }}>Kursus Tertentu</option>
                    <option value="module" {{ request('target') === 'module' ? 'selected' : '' }}>Modul Tertentu</option>
                </select>

                <button type="submit" class="px-4 py-2 rounded-xl bg-[var(--blue)] hover:bg-[var(--blue-dark)] text-white font-bold text-xs transition">
                    <i class="fas fa-filter mr-1"></i> Filter
                </button>

                @if(request()->anyFilled(['search', 'type', 'target']))
                    <a href="{{ route('admin.referral-codes.index') }}" class="text-xs text-[var(--muted)] hover:text-[var(--ink)] font-semibold underline">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Table of Codes -->
    <div class="rounded-2xl bg-white border border-[var(--border)] shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 border-b border-[var(--border)] text-[var(--muted)] uppercase font-mono tracking-wider text-[10px]">
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
                <tbody class="divide-y divide-[var(--border)] text-[var(--body)]">
                    @forelse($referralCodes as $ref)
                        <tr class="hover:bg-slate-50/80 transition">
                            <!-- Code -->
                            <td class="p-4">
                                <div class="flex items-center gap-2">
                                    <span class="font-mono font-bold text-xs text-[var(--blue)] px-2.5 py-1 rounded-lg bg-blue-50 border border-blue-200 select-all">
                                        {{ $ref->code }}
                                    </span>
                                </div>
                                @if($ref->description)
                                    <div class="text-[11px] text-[var(--muted)] mt-1">{{ $ref->description }}</div>
                                @endif
                            </td>

                            <!-- Discount Type -->
                            <td class="p-4">
                                @if($ref->discount_type === 'free')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        <i class="fas fa-gift text-[9px]"></i> 100% GRATIS (Rp 0)
                                    </span>
                                @elseif($ref->discount_type === 'percentage')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-bold bg-blue-50 text-[var(--blue)] border border-blue-200">
                                        <i class="fas fa-percent text-[9px]"></i> DISKON {{ $ref->discount_value }}%
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-bold bg-indigo-50 text-indigo-700 border border-indigo-200">
                                        <i class="fas fa-tag text-[9px]"></i> -Rp {{ number_format($ref->discount_value, 0, ',', '.') }}
                                    </span>
                                @endif
                            </td>

                            <!-- Target -->
                            <td class="p-4">
                                @if($ref->target_type === 'all')
                                    <span class="text-[var(--ink)] font-semibold">Semua Kursus & Modul</span>
                                @elseif($ref->target_type === 'course')
                                    <span class="text-[var(--blue)] font-semibold">
                                        <i class="fas fa-graduation-cap mr-1"></i>
                                        Kursus: {{ $courses->firstWhere('id', $ref->target_id)->title ?? 'ID: ' . $ref->target_id }}
                                    </span>
                                @elseif($ref->target_type === 'module')
                                    <span class="text-amber-700 font-semibold">
                                        <i class="fas fa-book mr-1"></i>
                                        Modul: {{ $moduleCategories->firstWhere('id', $ref->target_id)->name ?? 'ID: ' . $ref->target_id }}
                                    </span>
                                @endif
                            </td>

                            <!-- Usage -->
                            <td class="p-4">
                                <span class="font-mono text-[var(--ink)] font-bold">{{ $ref->used_count }}</span>
                                <span class="text-[var(--muted)]">/ {{ $ref->max_uses ? $ref->max_uses . 'x' : 'Tak Terbatas' }}</span>
                            </td>

                            <!-- Expires At -->
                            <td class="p-4 text-[var(--muted)] font-mono text-[11px]">
                                {{ $ref->expires_at ? $ref->expires_at->format('d M Y H:i') : 'Selamanya' }}
                            </td>

                            <!-- Status -->
                            <td class="p-4">
                                @if($ref->is_active)
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-mono font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        ACTIVE
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-mono font-bold bg-rose-50 text-rose-700 border border-rose-200">
                                        INACTIVE
                                    </span>
                                @endif
                            </td>

                            <!-- Actions -->
                            <td class="p-4 text-right whitespace-nowrap">
                                <div class="inline-flex items-center gap-2">
                                    <a href="{{ route('admin.referral-codes.edit', $ref->id) }}" 
                                       class="px-2.5 py-1 rounded-lg bg-slate-100 hover:bg-slate-200 text-[var(--ink)] border border-slate-200 text-[11px] font-semibold transition">
                                        Edit
                                    </a>

                                    <form action="{{ route('admin.referral-codes.destroy', $ref->id) }}" method="POST"
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus kode referral {{ $ref->code }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-2.5 py-1 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-600 border border-rose-200 text-[11px] font-semibold transition">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-8 text-center text-[var(--muted)] italic">
                                Belum ada kode referral yang dibuat.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($referralCodes->hasPages())
            <div class="p-4 border-t border-[var(--border)]">
                {{ $referralCodes->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
