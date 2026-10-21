@extends('layouts.app')

@section('title', 'Hosting Prototype Saya | Flow Academy')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <div class="flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-[var(--cyan)] mb-1">
                <i class="fas fa-server"></i> Free Static Hosting Manager
            </div>
            <h1 class="text-2xl md:text-3xl font-extrabold text-white tracking-tight">
                Hosting Prototype <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-cyan-400">Saya</span>
            </h1>
            <p class="text-xs md:text-sm text-slate-400 mt-1">
                Kelola seluruh prototype website statis yang telah lulus audit AI dan dipublikasikan di platform Flow Academy.
            </p>
        </div>
        <a href="{{ route('user.prototypes.create') }}" class="px-5 py-3 rounded-xl bg-gradient-to-r from-purple-600 to-cyan-500 hover:opacity-95 text-white font-extrabold text-xs uppercase tracking-wider shadow-lg shadow-purple-600/20 inline-flex items-center gap-2 transition self-start md:self-auto">
            <i class="fas fa-plus"></i> Upload Prototype Baru
        </a>
    </div>

    @if (session('success'))
        <div class="mb-6 p-4 rounded-xl bg-emerald-950/40 border border-emerald-500/40 text-emerald-300 text-xs flex items-center gap-3">
            <i class="fas fa-check-circle text-base"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Content -->
    @if ($prototypes->isEmpty())
        <div class="rounded-2xl bg-[#0c1220] border border-[#1e2d40] p-12 text-center max-w-lg mx-auto shadow-2xl">
            <div class="w-20 h-20 rounded-2xl bg-gradient-to-tr from-purple-500/20 to-cyan-500/20 text-cyan-400 flex items-center justify-center mx-auto text-3xl mb-4 border border-cyan-500/30">
                <i class="fas fa-globe-americas"></i>
            </div>
            <h3 class="text-lg font-bold text-white mb-2">Belum Ada Prototype yang Di-hosting</h3>
            <p class="text-xs text-slate-400 mb-6 leading-relaxed">
                Anda belum memiliki prototype yang di-hosting gratis. Unggah file HTML, CSS, JS atau arsip .ZIP Anda untuk diaudit oleh AI Agent dan dapatkan URL publik instan!
            </p>
            <a href="{{ route('user.prototypes.create') }}" class="px-6 py-3 rounded-xl bg-gradient-to-r from-purple-600 to-cyan-500 text-white font-bold text-xs uppercase tracking-wider inline-flex items-center gap-2 hover:opacity-95 transition">
                <i class="fas fa-cloud-upload-alt"></i> Upload Prototype Sekarang
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($prototypes as $proto)
                <div class="rounded-2xl bg-[#0c1220] border border-[#1e2d40] hover:border-cyan-500/40 transition-all p-6 shadow-xl flex flex-col justify-between relative group">
                    <div>
                        <!-- Header & Badges -->
                        <div class="flex items-start justify-between gap-3 mb-3">
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider {{ $proto->is_active ? 'bg-emerald-950/60 text-emerald-400 border border-emerald-800/60' : 'bg-amber-950/60 text-amber-400 border border-amber-800/60' }}">
                                <i class="fas {{ $proto->is_active ? 'fa-check-circle' : 'fa-pause-circle' }} mr-1"></i>
                                {{ $proto->is_active ? 'Aktif' : 'Ditangguhkan' }}
                            </span>

                            <span class="px-2.5 py-1 rounded-full text-[10px] font-mono font-bold bg-slate-800 text-cyan-300 border border-slate-700">
                                <i class="fas fa-star text-yellow-400 mr-1"></i> {{ $proto->ai_score }} / 100
                            </span>
                        </div>

                        <!-- Title -->
                        <h3 class="text-base font-bold text-white mb-1.5 group-hover:text-cyan-300 transition">
                            {{ $proto->project_name }}
                        </h3>

                        <!-- Live URL -->
                        <div class="p-2.5 rounded-xl bg-[#05080f] border border-[#1e2d40] mb-4 flex items-center justify-between text-xs font-mono">
                            <a href="{{ $proto->url }}" target="_blank" class="text-cyan-400 truncate hover:underline" title="{{ $proto->url }}">
                                /p/{{ $proto->slug }}
                            </a>
                            <button type="button" onclick="navigator.clipboard.writeText('{{ $proto->url }}'); alert('Tautan disalin: {{ $proto->url }}')" class="text-slate-400 hover:text-white ml-2 flex-shrink-0" title="Salin URL">
                                <i class="fas fa-copy"></i>
                            </button>
                        </div>

                        <!-- Meta Info -->
                        <div class="flex items-center justify-between text-[11px] text-slate-400 mb-6">
                            <span><i class="fas fa-brain text-purple-400 mr-1"></i> {{ Str::limit($proto->ai_provider_used, 18) }}</span>
                            <span><i class="far fa-calendar-alt mr-1"></i> {{ $proto->created_at->format('d M Y') }}</span>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="pt-4 border-t border-slate-800/80 flex items-center justify-between gap-2">
                        <button type="button" onclick="openAiReportModal({{ $proto->id }})" class="px-3 py-1.5 rounded-lg bg-purple-950/40 border border-purple-800/40 hover:bg-purple-900/40 text-purple-300 text-xs font-bold transition flex items-center gap-1.5">
                            <i class="fas fa-clipboard-list"></i> Hasil AI
                        </button>

                        <div class="flex items-center gap-2">
                            <a href="{{ $proto->url }}" target="_blank" class="px-3 py-1.5 rounded-lg bg-cyan-600/80 hover:bg-cyan-500 text-white text-xs font-bold transition flex items-center gap-1.5">
                                <i class="fas fa-external-link-alt"></i> Buka
                            </a>

                            <form action="{{ route('user.prototypes.destroy', $proto->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus prototype ini? Berkas hosting akan dihapus permanen.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-1.5 rounded-lg text-slate-500 hover:text-red-400 hover:bg-red-950/30 transition" title="Hapus Prototype">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $prototypes->links() }}
        </div>
    @endif
</div>

<!-- AI REPORT MODAL -->
<div id="ai-modal" class="fixed inset-0 bg-[#05080f]/80 backdrop-blur-md z-50 flex items-center justify-center p-4 hidden">
    <div class="max-w-2xl w-full bg-[#0c1220] border border-[#1e2d40] rounded-2xl p-6 md:p-8 shadow-2xl max-h-[90vh] overflow-y-auto relative">
        <div class="flex items-center justify-between pb-4 border-b border-slate-800 mb-6">
            <div class="flex items-center gap-2">
                <i class="fas fa-brain text-cyan-400 text-lg"></i>
                <h3 class="text-base font-extrabold text-white" id="modal-project-title">Audit AI Prototype</h3>
            </div>
            <button type="button" onclick="closeAiReportModal()" class="text-slate-400 hover:text-white text-lg">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <div id="modal-content" class="space-y-4">
            <div class="text-center py-8 text-slate-400">
                <i class="fas fa-spinner fa-spin text-2xl text-cyan-400 mb-2"></i>
                <p class="text-xs">Memuat laporan audit AI...</p>
            </div>
        </div>
    </div>
</div>

<script>
    async function openAiReportModal(id) {
        const modal = document.getElementById('ai-modal');
        const modalTitle = document.getElementById('modal-project-title');
        const modalContent = document.getElementById('modal-content');

        modal.classList.remove('hidden');
        modalContent.innerHTML = `
            <div class="text-center py-8 text-slate-400">
                <i class="fas fa-spinner fa-spin text-2xl text-cyan-400 mb-2"></i>
                <p class="text-xs">Memuat laporan audit AI...</p>
            </div>
        `;

        try {
            const res = await fetch(`{{ url('/user/prototypes') }}/${id}/report`);
            const data = await res.json();

            if (!res.ok || !data.success) {
                modalContent.innerHTML = `<p class="text-xs text-red-400">Gagal memuat laporan.</p>`;
                return;
            }

            const p = data.prototype;
            modalTitle.innerText = `Audit AI: ${p.project_name}`;

            const rep = p.ai_report_json || {};
            const categories = rep.categories || {};

            let categoriesHtml = '';
            for (const [key, details] of Object.entries(categories)) {
                const issues = details.issues || [];
                const recs = details.recommendations || [];

                categoriesHtml += `
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

            modalContent.innerHTML = `
                <div class="p-4 rounded-xl bg-purple-950/30 border border-purple-800/40 text-xs text-purple-200 mb-4">
                    <strong>Ringkasan AI:</strong> ${rep.verdict_summary || 'Kode prototype telah diaudit.'}
                </div>
                <div class="space-y-3">
                    ${categoriesHtml || '<p class="text-xs text-slate-400">Tidak ada detail kategori.</p>'}
                </div>
            `;
        } catch (e) {
            modalContent.innerHTML = `<p class="text-xs text-red-400">Terjadi kesalahan.</p>`;
        }
    }

    function closeAiReportModal() {
        document.getElementById('ai-modal').classList.add('hidden');
    }
</script>
@endsection
