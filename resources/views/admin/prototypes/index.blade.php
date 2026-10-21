@extends('layouts.app')

@section('title', 'Manajemen Prototype & Hosting | Admin Flow Academy')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <div class="flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-[var(--cyan)] mb-1">
                <i class="fas fa-layer-group"></i> Master Admin Prototype Hub
            </div>
            <h1 class="text-2xl md:text-3xl font-extrabold text-white tracking-tight">
                Manajemen Prototype <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-cyan-400">& Hosting Pengguna</span>
            </h1>
            <p class="text-xs md:text-sm text-slate-400 mt-1">
                Pantau seluruh prototype yang diunggah pengguna, audit hasil analisa AI, status hosting publik, dan kontrol penangguhan akses.
            </p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.prototype-settings.index') }}" class="px-4 py-2.5 rounded-xl bg-purple-600/80 hover:bg-purple-600 text-white text-xs font-bold shadow-lg shadow-purple-600/20 inline-flex items-center gap-2 transition">
                <i class="fas fa-robot"></i> Pengaturan AI & Host
            </a>
            <a href="{{ route('user.prototypes.create') }}" target="_blank" class="px-4 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-750 text-slate-200 text-xs font-bold border border-slate-700 inline-flex items-center gap-2 transition">
                <i class="fas fa-external-link-alt text-cyan-400"></i> Tes Upload User
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="mb-6 p-4 rounded-xl bg-emerald-950/40 border border-emerald-500/40 text-emerald-300 text-xs flex items-center gap-3">
            <i class="fas fa-check-circle text-base"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Stats Cards -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        <div class="p-5 rounded-2xl bg-[#0c1220] border border-[#1e2d40] shadow-xl">
            <div class="text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-1">Total Prototype</div>
            <div class="text-2xl font-black text-white font-mono">{{ $stats['total'] }}</div>
        </div>
        <div class="p-5 rounded-2xl bg-[#0c1220] border border-[#1e2d40] shadow-xl">
            <div class="text-[10px] font-bold uppercase tracking-wider text-emerald-400 mb-1">Hosting Aktif</div>
            <div class="text-2xl font-black text-emerald-400 font-mono">{{ $stats['active'] }}</div>
        </div>
        <div class="p-5 rounded-2xl bg-[#0c1220] border border-[#1e2d40] shadow-xl">
            <div class="text-[10px] font-bold uppercase tracking-wider text-amber-400 mb-1">Ditangguhkan</div>
            <div class="text-2xl font-black text-amber-400 font-mono">{{ $stats['suspended'] }}</div>
        </div>
        <div class="p-5 rounded-2xl bg-[#0c1220] border border-[#1e2d40] shadow-xl">
            <div class="text-[10px] font-bold uppercase tracking-wider text-cyan-400 mb-1">Rata-Rata Skor AI</div>
            <div class="text-2xl font-black text-cyan-400 font-mono">{{ $stats['avg_score'] }} <span class="text-xs text-slate-400">/ 100</span></div>
        </div>
    </div>

    <!-- Filter & Search Bar -->
    <div class="p-4 rounded-2xl bg-[#0c1220] border border-[#1e2d40] mb-6 shadow-xl">
        <form action="{{ route('admin.prototypes.index') }}" method="GET" class="flex flex-col md:flex-row gap-3">
            <div class="flex-1 relative">
                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400 text-xs">
                    <i class="fas fa-search"></i>
                </span>
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Cari berdasarkan nama project, slug URL, atau nama pengguna..."
                    class="w-full pl-9 pr-4 py-2 bg-[#05080f] border border-[#1e2d40] rounded-xl text-white text-xs focus:border-cyan-400 focus:outline-none">
            </div>

            <div class="flex items-center gap-2">
                <select name="status" class="px-3 py-2 bg-[#05080f] border border-[#1e2d40] rounded-xl text-white text-xs focus:border-cyan-400 focus:outline-none">
                    <option value="">Semua Status</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktif</option>
                    <option value="suspended" {{ request('status') === 'suspended' ? 'selected' : '' }}>Ditangguhkan (Suspend)</option>
                </select>

                <button type="submit" class="px-4 py-2 rounded-xl bg-cyan-600 hover:bg-cyan-500 text-white font-bold text-xs transition">
                    Filter
                </button>
                @if (request()->hasAny(['search', 'status']))
                    <a href="{{ route('admin.prototypes.index') }}" class="px-3 py-2 rounded-xl bg-slate-800 text-slate-300 font-bold text-xs hover:bg-slate-700 transition">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Table -->
    <div class="rounded-2xl bg-[#0c1220] border border-[#1e2d40] shadow-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-slate-800 bg-[#05080f]/80 text-[10px] font-extrabold uppercase tracking-wider text-slate-400">
                        <th class="py-3.5 px-4">Pengguna</th>
                        <th class="py-3.5 px-4">Project & URL Path</th>
                        <th class="py-3.5 px-4 text-center">Skor AI</th>
                        <th class="py-3.5 px-4">Engine AI</th>
                        <th class="py-3.5 px-4 text-center">Status</th>
                        <th class="py-3.5 px-4">Tanggal Unggah</th>
                        <th class="py-3.5 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800 text-xs text-slate-300">
                    @forelse ($prototypes as $proto)
                        <tr class="hover:bg-slate-900/40 transition">
                            <!-- User -->
                            <td class="py-4 px-4">
                                <div class="font-bold text-white">{{ $proto->user->name ?? 'User #' . $proto->user_id }}</div>
                                <div class="text-[11px] text-slate-500">{{ $proto->user->email ?? '-' }}</div>
                            </td>

                            <!-- Project & URL -->
                            <td class="py-4 px-4">
                                <div class="font-bold text-white mb-0.5">{{ $proto->project_name }}</div>
                                <a href="{{ $proto->url }}" target="_blank" class="font-mono text-[11px] text-cyan-400 hover:underline inline-flex items-center gap-1">
                                    /p/{{ $proto->slug }} <i class="fas fa-external-link-alt text-[9px]"></i>
                                </a>
                            </td>

                            <!-- AI Score -->
                            <td class="py-4 px-4 text-center">
                                <span class="px-2.5 py-1 rounded-full font-mono text-[11px] font-bold {{ $proto->ai_score >= 80 ? 'bg-emerald-950 text-emerald-300 border border-emerald-800/60' : 'bg-cyan-950 text-cyan-300 border border-cyan-800/60' }}">
                                    {{ $proto->ai_score }} / 100
                                </span>
                            </td>

                            <!-- Engine AI -->
                            <td class="py-4 px-4">
                                <span class="px-2.5 py-0.5 rounded bg-slate-800 text-slate-300 text-[10px] font-mono">
                                    {{ Str::limit($proto->ai_provider_used, 18) }}
                                </span>
                            </td>

                            <!-- Status -->
                            <td class="py-4 px-4 text-center">
                                @if ($proto->is_active)
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider bg-emerald-950/80 text-emerald-400 border border-emerald-800/60">
                                        Aktif
                                    </span>
                                @else
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider bg-amber-950/80 text-amber-400 border border-amber-800/60">
                                        Suspend
                                    </span>
                                @endif
                            </td>

                            <!-- Date -->
                            <td class="py-4 px-4 text-[11px] text-slate-400">
                                {{ $proto->created_at->format('d M Y, H:i') }}
                            </td>

                            <!-- Actions -->
                            <td class="py-4 px-4 text-right">
                                <div class="flex items-center justify-end gap-1.5">
                                    <!-- View Report -->
                                    <button type="button" onclick="showAdminReport({{ json_encode($proto) }})"
                                        class="p-2 rounded-lg bg-purple-950/40 text-purple-300 hover:bg-purple-900/40 transition" title="Lihat Hasil Audit AI">
                                        <i class="fas fa-clipboard-check"></i>
                                    </button>

                                    <!-- Open live -->
                                    <a href="{{ $proto->url }}" target="_blank"
                                        class="p-2 rounded-lg bg-cyan-950/40 text-cyan-300 hover:bg-cyan-900/40 transition" title="Buka Prototype">
                                        <i class="fas fa-external-link-alt"></i>
                                    </a>

                                    <!-- Toggle Active / Suspend -->
                                    <form action="{{ route('admin.prototypes.toggle-active', $proto->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit"
                                            class="p-2 rounded-lg {{ $proto->is_active ? 'bg-amber-950/40 text-amber-400 hover:bg-amber-900/40' : 'bg-emerald-950/40 text-emerald-400 hover:bg-emerald-900/40' }} transition"
                                            title="{{ $proto->is_active ? 'Tangguhkan (Suspend)' : 'Aktifkan Kembali' }}">
                                            <i class="fas {{ $proto->is_active ? 'fa-pause' : 'fa-play' }}"></i>
                                        </button>
                                    </form>

                                    <!-- Delete -->
                                    <form action="{{ route('admin.prototypes.destroy', $proto->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus prototype ini beserta seluruh berkasnya secara permanen?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 rounded-lg bg-red-950/40 text-red-400 hover:bg-red-900/40 transition" title="Hapus Permanen">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-slate-500">
                                <i class="fas fa-folder-open text-3xl mb-2 text-slate-600 block"></i>
                                Tidak ada prototype yang cocok dengan pencarian atau filter.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($prototypes->hasPages())
            <div class="p-4 border-t border-slate-800">
                {{ $prototypes->links() }}
            </div>
        @endif
    </div>
</div>

<!-- AUDIT MODAL -->
<div id="admin-ai-modal" class="fixed inset-0 bg-[#05080f]/80 backdrop-blur-md z-50 flex items-center justify-center p-4 hidden">
    <div class="max-w-2xl w-full bg-[#0c1220] border border-[#1e2d40] rounded-2xl p-6 md:p-8 shadow-2xl max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between pb-4 border-b border-slate-800 mb-6">
            <h3 class="text-base font-extrabold text-white" id="admin-modal-title">Hasil Audit AI</h3>
            <button type="button" onclick="document.getElementById('admin-ai-modal').classList.add('hidden')" class="text-slate-400 hover:text-white">
                <i class="fas fa-times text-lg"></i>
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
                <div class="p-4 rounded-xl bg-[#05080f] border border-[#1e2d40]">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs font-bold uppercase text-white">${key.replace('_', ' ')}</span>
                        <span class="font-mono text-xs font-bold text-cyan-400">${details.score ?? 0} / 100</span>
                    </div>
                    ${issues.length ? `<div class="text-xs text-amber-400 mb-1">Catatan:</div><ul class="text-xs text-slate-300 list-disc list-inside mb-2">${issues.map(i => `<li>${i}</li>`).join('')}</ul>` : ''}
                    ${recs.length ? `<div class="text-xs text-cyan-400 mb-1">Saran:</div><ul class="text-xs text-slate-400 list-disc list-inside">${recs.map(r => `<li>${r}</li>`).join('')}</ul>` : ''}
                </div>
            `;
        }

        document.getElementById('admin-modal-body').innerHTML = `
            <div class="p-4 rounded-xl bg-purple-950/30 border border-purple-800/40 text-xs text-purple-200 mb-4">
                <strong>Ringkasan AI:</strong> ${rep.verdict_summary || 'Tidak ada ringkasan.'}
            </div>
            <div class="space-y-3">
                ${catHtml || '<p class="text-xs text-slate-400">Tidak ada rincian kategori.</p>'}
            </div>
        `;

        document.getElementById('admin-ai-modal').classList.remove('hidden');
    }
</script>
@endsection
