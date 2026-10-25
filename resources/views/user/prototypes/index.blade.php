@extends('layouts.app')

@section('title', 'Hosting Prototype Saya | TalentGroup')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 py-6">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="pill blue-soft text-[10px] uppercase font-bold tracking-wider">
                    Prototype Hosting
                </span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-[var(--ink)] tracking-tight">
                Hosting Prototype Saya
            </h1>
            <p class="text-xs sm:text-sm text-[var(--text2)] mt-1">
                Kelola seluruh website statis yang telah lulus audit AI dan online di TalentGroup.
            </p>
        </div>
        <a href="{{ route('user.prototypes.create') }}" class="btn btn-gradient text-xs self-start md:self-auto">
            <i class="fas fa-plus mr-1"></i> Upload Prototype Baru
        </a>
    </div>

    @if (session('success'))
        <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs flex items-center gap-3 shadow-sm">
            <i class="fas fa-check-circle text-base text-emerald-600"></i>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @endif

    <!-- Content -->
    @if ($prototypes->isEmpty())
        <div class="empty-prototype-box p-10 sm:p-12 text-center max-w-xl mx-auto shadow-sm">
            <div class="w-16 h-16 rounded-2xl empty-icon-wrap flex items-center justify-center mx-auto text-2xl mb-4">
                <i class="fas fa-globe"></i>
            </div>
            <h2 class="text-lg font-bold mb-1.5">Belum Ada Prototype yang Di-hosting</h2>
            <p class="text-xs sm:text-sm mb-6 leading-relaxed max-w-md mx-auto">
                Anda belum memiliki prototype yang di-hosting gratis. Unggah file HTML, CSS, JS atau arsip .ZIP Anda untuk diaudit oleh AI Agent dan dapatkan URL publik instan!
            </p>
            <a href="{{ route('user.prototypes.create') }}" class="btn btn-gradient text-xs">
                <i class="fas fa-cloud-upload-alt mr-1"></i> Upload Prototype Sekarang
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($prototypes as $proto)
                <div class="cyber-card bg-white border border-[var(--border)] hover:border-[var(--blue)] transition-all p-5 shadow-sm flex flex-col justify-between">
                    <div>
                        <!-- Header & Badges -->
                        <div class="flex items-start justify-between gap-3 mb-3">
                            <span class="pill {{ $proto->is_active ? 'success-outline' : 'pending' }} text-[10px]">
                                <i class="fas {{ $proto->is_active ? 'fa-check-circle' : 'fa-pause-circle' }} mr-1"></i>
                                {{ $proto->is_active ? 'Online' : 'Ditangguhkan' }}
                            </span>

                            <span class="pill blue-soft font-mono text-[10px]">
                                Skor: {{ $proto->ai_score }} / 100
                            </span>
                        </div>

                        <!-- Browser Mockup Bar -->
                        <div class="flex items-center gap-1.5 px-3 py-1.5 rounded-t-lg bg-[var(--bg3)] border border-b-0 border-[var(--border)]">
                            <span class="w-2 h-2 rounded-full bg-rose-400"></span>
                            <span class="w-2 h-2 rounded-full bg-amber-400"></span>
                            <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                            <span class="text-[10px] text-[var(--muted)] font-mono ml-1 truncate">{{ $proto->slug }}</span>
                        </div>

                        <!-- Title -->
                        <div class="p-3 border border-[var(--border)] rounded-b-lg mb-3 bg-white">
                            <h2 class="text-base font-bold text-[var(--ink)] truncate" title="{{ $proto->project_name }}">
                                {{ $proto->project_name }}
                            </h2>
                        </div>

                        <!-- Live URL Box -->
                        <div class="p-2.5 rounded-xl bg-[var(--bg3)] border border-[var(--border)] mb-4 flex items-center justify-between text-xs font-mono">
                            <a href="{{ $proto->url }}" target="_blank" class="text-[var(--blue)] font-bold truncate hover:underline" title="{{ $proto->url }}">
                                /p/{{ $proto->slug }}
                            </a>
                            <button type="button" onclick="navigator.clipboard.writeText('{{ $proto->url }}'); alert('Tautan disalin: {{ $proto->url }}')" class="text-[var(--muted)] hover:text-[var(--blue)] ml-2 flex-shrink-0" title="Salin URL">
                                <i class="fas fa-copy"></i>
                            </button>
                        </div>

                        <!-- Meta Info -->
                        <div class="flex items-center justify-between text-[11px] text-[var(--muted)] mb-4 font-mono">
                            <span><i class="fas fa-brain text-[var(--blue)] mr-1"></i> {{ Str::limit($proto->ai_provider_used, 16) }}</span>
                            <span>{{ $proto->created_at->format('d M Y') }}</span>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="pt-3 border-t border-[var(--border)] flex items-center justify-between gap-2">
                        <button type="button" onclick="openAiReportModal({{ $proto->id }})" class="btn btn-small btn-outline text-xs">
                            <i class="fas fa-clipboard-list mr-1"></i> Audit AI
                        </button>

                        <div class="flex items-center gap-1.5">
                            <a href="{{ $proto->url }}" target="_blank" class="btn btn-small btn-gradient text-xs">
                                <i class="fas fa-external-link-alt mr-1"></i> Buka
                            </a>

                            <button type="button" onclick="openEditModal({{ $proto->id }}, '{{ addslashes($proto->project_name) }}', '{{ $proto->slug }}')" class="p-2 rounded-lg text-slate-500 hover:text-[var(--blue)] hover:bg-[var(--blue-light)] transition" title="Edit Prototype">
                                <i class="fas fa-edit text-xs"></i>
                            </button>

                            <form action="{{ route('user.prototypes.destroy', $proto->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus prototype ini? Berkas hosting akan dihapus permanen.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 rounded-lg text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition" title="Hapus Prototype">
                                    <i class="fas fa-trash-alt text-xs"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-8 flex justify-center">
            {{ $prototypes->links() }}
        </div>
    @endif
</div>

<!-- AI REPORT MODAL -->
<div id="ai-report-modal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 flex items-center justify-center p-4 hidden">
    <div class="max-w-2xl w-full bg-white border border-[var(--border)] rounded-2xl p-6 sm:p-8 shadow-2xl relative max-h-[85vh] overflow-y-auto">
        <div class="flex items-center justify-between pb-4 border-b border-[var(--border)] mb-4">
            <div class="flex items-center gap-2">
                <i class="fas fa-brain text-[var(--blue)] text-lg"></i>
                <h2 class="text-base font-extrabold text-[var(--ink)]" id="modal-project-name">Laporan Audit AI</h2>
            </div>
            <button type="button" onclick="closeAiReportModal()" class="text-[var(--muted)] hover:text-[var(--ink)] p-1 text-lg">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <div id="modal-content" class="space-y-4">
            <div class="text-center py-8">
                <i class="fas fa-spinner fa-spin text-2xl text-[var(--blue)]"></i>
                <p class="text-xs text-[var(--muted)] mt-2">Memuat laporan audit...</p>
            </div>
        </div>
    </div>
</div>

<!-- EDIT PROTOTYPE MODAL -->
<div id="edit-proto-modal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 flex items-center justify-center p-4 hidden">
    <div class="max-w-lg w-full bg-white border border-[var(--border)] rounded-2xl p-6 sm:p-8 shadow-2xl relative max-h-[85vh] overflow-y-auto">
        <div class="flex items-center justify-between pb-4 border-b border-[var(--border)] mb-4">
            <div class="flex items-center gap-2">
                <i class="fas fa-edit text-[var(--blue)] text-lg"></i>
                <h2 class="text-base font-extrabold text-[var(--ink)]">Edit Prototype</h2>
            </div>
            <button type="button" onclick="closeEditModal()" class="text-[var(--muted)] hover:text-[var(--ink)] p-1 text-lg">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <form id="edit-proto-form" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="space-y-4 mb-5">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-[var(--ink)] mb-1" for="edit_modal_name">
                        Nama Prototype <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="project_name" id="edit_modal_name" required class="cyber-input text-xs sm:text-sm py-2.5 px-3 font-medium rounded-xl">
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-[var(--ink)] mb-1" for="edit_modal_slug">
                        Slug URL <span class="text-rose-500">*</span>
                    </label>
                    <div class="flex items-center border border-[var(--border)] rounded-xl overflow-hidden bg-[var(--bg3)] px-3 py-2 text-xs font-mono">
                        <span class="text-[var(--muted)]">/p/</span>
                        <input type="text" name="slug" id="edit_modal_slug" required class="bg-transparent border-0 outline-none w-full text-[var(--ink)] font-bold font-mono pl-1">
                    </div>
                </div>

                <div class="pt-2 border-t border-[var(--border)]">
                    <label class="block text-xs font-bold uppercase tracking-wider text-[var(--ink)] mb-1">
                        Ganti File (Opsional)
                    </label>
                    <p class="text-[11px] text-[var(--muted)] mb-2">Unggah paket .ZIP baru jika ingin mengganti seluruh konten web.</p>
                    <input type="file" name="zip_file" accept=".zip" class="w-full text-xs text-[var(--text2)]">
                </div>
            </div>

            <div class="pt-3 border-t border-[var(--border)] flex justify-end gap-2">
                <button type="button" onclick="closeEditModal()" class="btn btn-small btn-outline text-xs">Batal</button>
                <button type="submit" class="btn btn-small btn-gradient text-xs">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<script>
    async function openAiReportModal(id) {
        const modal = document.getElementById('ai-report-modal');
        const content = document.getElementById('modal-content');
        modal.classList.remove('hidden');

        try {
            const res = await fetch(`/user/prototypes/${id}/report`);
            const data = await res.json();

            if (!data.success) {
                content.innerHTML = `<p class="text-xs text-rose-600">${data.message || 'Gagal memuat rincian laporan.'}</p>`;
                return;
            }

            document.getElementById('modal-project-name').innerText = `Laporan AI: ${data.project_name}`;
            const rep = data.report || {};
            const categories = rep.categories || {};

            let html = `
                <div class="p-4 rounded-xl bg-[var(--bg3)] border border-[var(--border)] mb-4 flex items-center justify-between">
                    <div>
                        <span class="text-xs text-[var(--muted)]">Skor Audit Akhir</span>
                        <div class="text-2xl font-black text-[var(--blue)] font-mono">${data.score} / 100</div>
                    </div>
                    <span class="pill ${data.score >= 75 ? 'success-outline' : 'pending'}">
                        ${data.score >= 75 ? 'Memenuhi Standar' : 'Perlu Peningkatan'}
                    </span>
                </div>
                <div class="p-3.5 rounded-xl bg-slate-50 border border-[var(--border)] text-xs text-[var(--text2)] leading-relaxed mb-4">
                    <strong>Ringkasan Evaluator:</strong> ${rep.verdict_summary || 'Kode prototype telah memenuhi standar dan layak dipublikasikan.'}
                </div>
            `;

            if (Object.keys(categories).length > 0) {
                html += '<div class="space-y-3">';
                for (const [key, cat] of Object.entries(categories)) {
                    html += `
                        <div class="p-4 rounded-xl border border-[var(--border)] bg-white">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-xs font-bold text-[var(--ink)] uppercase">${key}</span>
                                <span class="pill blue-soft text-[10px] font-mono">${cat.score ?? 80}/100</span>
                            </div>
                    `;
                    if (cat.issues && cat.issues.length) {
                        html += `<ul class="text-xs text-amber-700 space-y-1 mb-2 list-disc list-inside">`;
                        cat.issues.forEach(i => html += `<li>${i}</li>`);
                        html += `</ul>`;
                    }
                    if (cat.recommendations && cat.recommendations.length) {
                        html += `<ul class="text-xs text-[var(--blue)] space-y-1 list-disc list-inside">`;
                        cat.recommendations.forEach(r => html += `<li>${r}</li>`);
                        html += `</ul>`;
                    }
                    html += `</div>`;
                }
                html += '</div>';
            }

            content.innerHTML = html;
        } catch (e) {
            content.innerHTML = `<p class="text-xs text-rose-600">Gagal terhubung ke server.</p>`;
        }
    }

    function closeAiReportModal() {
        document.getElementById('ai-report-modal').classList.add('hidden');
    }

    function openEditModal(id, name, slug) {
        document.getElementById('edit-proto-form').action = `/user/prototypes/${id}`;
        document.getElementById('edit_modal_name').value = name;
        document.getElementById('edit_modal_slug').value = slug;
        document.getElementById('edit-proto-modal').classList.remove('hidden');
    }

    function closeEditModal() {
        document.getElementById('edit-proto-modal').classList.add('hidden');
    }
</script>
@endsection
