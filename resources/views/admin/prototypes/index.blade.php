@extends('layouts.app')

@section('title', 'Manajemen Prototype & Hosting | Admin TalentGroup')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <div class="flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-[var(--blue)] mb-1">
                <i class="fas fa-layer-group"></i> Master Admin Prototype Hub
            </div>
            <h1 class="text-2xl md:text-3xl font-extrabold text-[var(--ink)] tracking-tight">
                Manajemen Prototype <span class="text-[var(--blue)]">& Hosting Pengguna</span>
            </h1>
            <p class="text-xs md:text-sm text-[var(--muted)] mt-1">
                Pantau seluruh prototype yang diunggah pengguna, audit hasil analisa AI, status hosting publik, dan kontrol penangguhan akses.
            </p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.prototype-settings.index') }}" class="btn-gradient px-4 py-2.5 rounded-xl text-white text-xs font-bold shadow-sm inline-flex items-center gap-2">
                <i class="fas fa-sliders-h"></i> Pengaturan AI & Host
            </a>
            <a href="{{ route('user.prototypes.create') }}" target="_blank" class="btn-outline px-4 py-2.5 rounded-xl text-xs font-bold inline-flex items-center gap-2">
                <i class="fas fa-external-link-alt text-[var(--blue)]"></i> Tes Upload User
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs flex items-center gap-3">
            <i class="fas fa-check-circle text-base text-emerald-600"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Stats Cards -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        <div class="p-5 rounded-2xl bg-white border border-[var(--border)] shadow-sm">
            <div class="text-[10px] font-bold uppercase tracking-wider text-[var(--muted)] mb-1">Total Prototype</div>
            <div class="text-2xl font-black text-[var(--ink)] font-mono">{{ $stats['total'] }}</div>
        </div>
        <div class="p-5 rounded-2xl bg-white border border-[var(--border)] shadow-sm">
            <div class="text-[10px] font-bold uppercase tracking-wider text-emerald-600 mb-1">Hosting Aktif</div>
            <div class="text-2xl font-black text-emerald-600 font-mono">{{ $stats['active'] }}</div>
        </div>
        <div class="p-5 rounded-2xl bg-white border border-[var(--border)] shadow-sm">
            <div class="text-[10px] font-bold uppercase tracking-wider text-amber-600 mb-1">Ditangguhkan</div>
            <div class="text-2xl font-black text-amber-600 font-mono">{{ $stats['suspended'] }}</div>
        </div>
        <div class="p-5 rounded-2xl bg-white border border-[var(--border)] shadow-sm">
            <div class="text-[10px] font-bold uppercase tracking-wider text-[var(--blue)] mb-1">Rata-Rata Skor AI</div>
            <div class="text-2xl font-black text-[var(--blue)] font-mono">{{ $stats['avg_score'] }} <span class="text-xs text-[var(--muted)]">/ 100</span></div>
        </div>
    </div>

    <!-- Filter & Search Bar -->
    <div class="p-4 rounded-2xl bg-white border border-[var(--border)] mb-6 shadow-sm">
        <form action="{{ route('admin.prototypes.index') }}" method="GET" class="flex flex-col md:flex-row gap-3">
            <div class="flex-1 relative">
                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-[var(--muted)] text-xs">
                    <i class="fas fa-search"></i>
                </span>
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Cari berdasarkan nama project, slug URL, atau nama pengguna..."
                    class="w-full pl-9 pr-4 py-2.5 bg-slate-50 border border-[var(--border)] rounded-xl text-[var(--ink)] text-xs focus:bg-white focus:border-[var(--blue)] focus:outline-none transition">
            </div>

            <div class="flex items-center gap-2">
                <select name="status" class="px-3 py-2.5 bg-slate-50 border border-[var(--border)] rounded-xl text-[var(--ink)] text-xs focus:bg-white focus:border-[var(--blue)] focus:outline-none transition">
                    <option value="">Semua Status</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktif</option>
                    <option value="suspended" {{ request('status') === 'suspended' ? 'selected' : '' }}>Ditangguhkan (Suspend)</option>
                </select>

                <button type="submit" class="px-5 py-2.5 rounded-xl bg-[var(--blue)] hover:bg-[var(--blue-dark)] text-white font-bold text-xs transition">
                    Filter
                </button>
                @if (request()->hasAny(['search', 'status']))
                    <a href="{{ route('admin.prototypes.index') }}" class="px-3 py-2.5 rounded-xl bg-slate-100 text-[var(--ink)] font-bold text-xs hover:bg-slate-200 transition">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Table -->
    <div class="rounded-2xl bg-white border border-[var(--border)] shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-[var(--border)] bg-slate-50 text-[10px] font-extrabold uppercase tracking-wider text-[var(--muted)]">
                        <th class="py-3.5 px-4">Pengguna</th>
                        <th class="py-3.5 px-4">Project & URL Path</th>
                        <th class="py-3.5 px-4 text-center">Skor AI</th>
                        <th class="py-3.5 px-4">Engine AI</th>
                        <th class="py-3.5 px-4 text-center">Status</th>
                        <th class="py-3.5 px-4">Tanggal Unggah</th>
                        <th class="py-3.5 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[var(--border)] text-xs text-[var(--body)]">
                    @forelse ($prototypes as $proto)
                        <tr class="hover:bg-slate-50/80 transition">
                            <!-- User -->
                            <td class="py-4 px-4">
                                <div class="font-bold text-[var(--ink)]">{{ $proto->user->name ?? 'User #' . $proto->user_id }}</div>
                                <div class="text-[11px] text-[var(--muted)]">{{ $proto->user->email ?? '-' }}</div>
                            </td>

                            <!-- Project & URL -->
                            <td class="py-4 px-4">
                                <div class="font-bold text-[var(--ink)] mb-0.5">{{ $proto->project_name }}</div>
                                <a href="{{ $proto->url }}" target="_blank" class="font-mono text-[11px] text-[var(--blue)] hover:underline inline-flex items-center gap-1 font-semibold">
                                    /p/{{ $proto->slug }} <i class="fas fa-external-link-alt text-[9px]"></i>
                                </a>
                            </td>

                            <!-- AI Score -->
                            <td class="py-4 px-4 text-center">
                                <span class="px-2.5 py-1 rounded-full font-mono text-[11px] font-bold {{ $proto->ai_score >= 80 ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-blue-50 text-[var(--blue)] border border-blue-200' }}">
                                    {{ $proto->ai_score }} / 100
                                </span>
                            </td>

                            <!-- Engine AI -->
                            <td class="py-4 px-4">
                                <span class="px-2.5 py-1 rounded-md bg-slate-100 text-[var(--ink)] text-[11px] font-mono font-medium border border-slate-200">
                                    {{ Str::limit($proto->ai_provider_used, 18) }}
                                </span>
                            </td>

                            <!-- Status -->
                            <td class="py-4 px-4 text-center">
                                @if ($proto->is_active)
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        Aktif
                                    </span>
                                @else
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider bg-amber-50 text-amber-700 border border-amber-200">
                                        Suspend
                                    </span>
                                @endif
                            </td>

                            <!-- Date -->
                            <td class="py-4 px-4 text-[11px] text-[var(--muted)]">
                                {{ $proto->created_at->format('d M Y, H:i') }}
                            </td>

                            <!-- Actions -->
                            <td class="py-4 px-4 text-right">
                                <div class="flex items-center justify-end gap-1.5">
                                    <!-- View Report -->
                                    <button type="button" onclick="showAdminReport({{ json_encode($proto) }})"
                                        class="p-2 rounded-lg bg-blue-50 text-[var(--blue)] hover:bg-blue-100 transition border border-blue-100" title="Lihat Hasil Audit AI">
                                        <i class="fas fa-clipboard-check"></i>
                                    </button>

                                    <!-- Open live -->
                                    <a href="{{ $proto->url }}" target="_blank"
                                        class="p-2 rounded-lg bg-slate-100 text-[var(--ink)] hover:bg-slate-200 transition border border-slate-200" title="Buka Prototype">
                                        <i class="fas fa-external-link-alt"></i>
                                    </a>

                                    <!-- Toggle Active / Suspend -->
                                    <form action="{{ route('admin.prototypes.toggle-active', $proto->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit"
                                            class="p-2 rounded-lg {{ $proto->is_active ? 'bg-amber-50 text-amber-600 hover:bg-amber-100 border border-amber-200' : 'bg-emerald-50 text-emerald-600 hover:bg-emerald-100 border border-emerald-200' }} transition"
                                            title="{{ $proto->is_active ? 'Tangguhkan (Suspend)' : 'Aktifkan Kembali' }}">
                                            <i class="fas {{ $proto->is_active ? 'fa-pause' : 'fa-play' }}"></i>
                                        </button>
                                    </form>

                                    <!-- Delete -->
                                    <form action="{{ route('admin.prototypes.destroy', $proto->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus prototype ini beserta seluruh berkasnya secara permanen?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 rounded-lg bg-rose-50 text-rose-600 hover:bg-rose-100 border border-rose-200 transition" title="Hapus Permanen">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-[var(--muted)]">
                                <i class="fas fa-folder-open text-3xl mb-2 text-slate-300 block"></i>
                                Tidak ada prototype yang cocok dengan pencarian atau filter.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($prototypes->hasPages())
            <div class="p-4 border-t border-[var(--border)]">
                {{ $prototypes->links() }}
            </div>
        @endif
    </div>
</div>

<!-- AUDIT MODAL -->
<div id="admin-ai-modal" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 flex items-center justify-center p-4 hidden">
    <div class="max-w-2xl w-full bg-white border border-[var(--border)] rounded-2xl p-6 md:p-8 shadow-2xl max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between pb-4 border-b border-[var(--border)] mb-6">
            <h3 class="text-base font-extrabold text-[var(--ink)]" id="admin-modal-title">Hasil Audit AI</h3>
            <button type="button" onclick="document.getElementById('admin-ai-modal').classList.add('hidden')" class="w-8 h-8 rounded-lg bg-slate-100 hover:bg-slate-200 text-[var(--muted)] hover:text-[var(--ink)] flex items-center justify-center transition">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div id="admin-modal-body" class="space-y-4"></div>
    </div>
</div>

<script>
    function showAdminReport(proto) {
        document.getElementById('admin-modal-title').innerText = `Laporan AI: ${proto.project_name} (${proto.ai_score}/100)`;
        const rep = proto.ai_report_json || {};
        const categories = rep.categories || {};

        let catHtml = '';
        for (const [key, details] of Object.entries(categories)) {
            const issues = details.issues || [];
            const recs = details.recommendations || [];

            catHtml += `
                <div class="p-4 rounded-xl bg-slate-50 border border-[var(--border)]">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs font-bold uppercase tracking-wider text-[var(--ink)]">${key.replace('_', ' ')}</span>
                        <span class="font-mono text-xs font-bold text-[var(--blue)]">${details.score ?? 0} / 100</span>
                    </div>
                    ${issues.length ? `<div class="text-xs font-semibold text-amber-700 mb-1">Catatan Evaluasi:</div><ul class="text-xs text-[var(--body)] list-disc list-inside mb-2">${issues.map(i => `<li>${i}</li>`).join('')}</ul>` : ''}
                    ${recs.length ? `<div class="text-xs font-semibold text-[var(--blue)] mb-1">Rekomendasi:</div><ul class="text-xs text-[var(--muted)] list-disc list-inside">${recs.map(r => `<li>${r}</li>`).join('')}</ul>` : ''}
                </div>
            `;
        }

        document.getElementById('admin-modal-body').innerHTML = `
            <div class="p-4 rounded-xl bg-blue-50 border border-blue-200 text-xs text-[var(--ink)] mb-4">
                <strong class="text-[var(--blue)]">Ringkasan AI:</strong> ${rep.verdict_summary || 'Tidak ada ringkasan.'}
            </div>
            <div class="space-y-3">
                ${catHtml || '<p class="text-xs text-[var(--muted)]">Tidak ada rincian kategori.</p>'}
            </div>
        `;

        document.getElementById('admin-ai-modal').classList.remove('hidden');
    }
</script>
@endsection
