@extends('layouts.app')

@section('title', 'Kelola Kategori Modul | TalentGroup')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 py-6">

    <!-- Header Section -->
    <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4 mb-6">
        <div>
            <div class="flex items-center gap-2 text-xs font-mono font-bold text-[var(--blue)] uppercase tracking-wider mb-1">
                <a href="{{ route('admin.modules.index') }}" class="hover:underline">Modul</a>
                <i class="fas fa-chevron-right text-[10px]"></i>
                <span>Kategori Sidebar</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-[var(--ink)] tracking-tight">
                Kategori Sidebar Modul
            </h1>
            <p class="text-xs sm:text-sm text-[var(--text2)] mt-1">
                Atur grup kategori sidebar modul dokumentasi seperti GETTING STARTED, CORE CONCEPTS, dll.
            </p>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('admin.modules.index') }}" 
               class="btn btn-small btn-outline">
                <i class="fas fa-arrow-left mr-1"></i>
                <span>Kembali ke Daftar Modul</span>
            </a>

            <button type="button" 
                    onclick="openCreateCategoryModal()"
                    class="btn btn-small btn-gradient">
                <i class="fas fa-plus mr-1"></i>
                <span>Tambah Kategori</span>
            </button>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 rounded-xl border border-emerald-500/30 bg-emerald-50 text-emerald-800 text-xs flex items-center gap-2.5 shadow-sm">
            <i class="fas fa-check-circle text-emerald-600 text-base"></i>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @endif

    <!-- Categories List Table -->
    <div class="cyber-card overflow-hidden p-0 bg-white border border-[var(--border)] shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr>
                        <th class="px-5 py-3.5">Urutan</th>
                        <th class="px-5 py-3.5">Nama Kategori</th>
                        <th class="px-5 py-3.5">Slug URL</th>
                        <th class="px-5 py-3.5">Total Modul</th>
                        <th class="px-5 py-3.5">Status</th>
                        <th class="px-5 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[var(--border)]">
                    @forelse($categories as $category)
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="px-5 py-4 font-mono font-bold text-[var(--muted)]">
                                #{{ $category->order }}
                            </td>
                            <td class="px-5 py-4">
                                <span class="font-bold text-[var(--ink)] text-sm">{{ $category->name }}</span>
                                @if($category->description)
                                    <p class="text-xs text-[var(--muted)] mt-0.5">{{ $category->description }}</p>
                                @endif
                            </td>
                            <td class="px-5 py-4 font-mono font-bold text-[var(--blue)]">
                                {{ $category->slug }}
                            </td>
                            <td class="px-5 py-4 font-semibold">
                                <span class="pill blue-soft text-[10px]">
                                    {{ $category->modules_count }} Modul
                                </span>
                            </td>
                            <td class="px-5 py-4">
                                @if($category->is_active)
                                    <span class="pill success-outline text-[10px]">
                                        <i class="fas fa-check text-[9px]"></i> Aktif
                                    </span>
                                @else
                                    <span class="pill pending text-[10px]">
                                        Nonaktif
                                    </span>
                                @endif
                            </td>
                            <td class="px-5 py-4 text-right">
                                <div class="inline-flex items-center gap-1.5">
                                    <button type="button" 
                                            onclick='openEditCategoryModal(@json($category))'
                                            class="btn btn-small btn-outline p-2"
                                            title="Edit Kategori">
                                        <i class="fas fa-edit text-xs"></i>
                                    </button>

                                    <form action="{{ route('admin.module-categories.destroy', $category->id) }}" method="POST" class="inline"
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini beserta seluruh modul di dalamnya?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="p-2 rounded-lg text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition border border-transparent hover:border-rose-200"
                                                title="Hapus Kategori">
                                            <i class="fas fa-trash text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-12 text-center text-[var(--muted)] text-xs">
                                Belum ada kategori yang dibuat. Klik tombol "Tambah Kategori".
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($categories->hasPages())
            <div class="p-4 border-t border-[var(--border)]">
                {{ $categories->links() }}
            </div>
        @endif
    </div>
</div>

<!-- Modal Form Create / Edit Category -->
<div id="categoryModal" class="fixed inset-0 z-50 hidden bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white border border-[var(--border)] rounded-2xl w-full max-w-lg shadow-2xl overflow-hidden animate-in fade-in zoom-in-95 duration-200">
        <form id="categoryForm" method="POST" action="{{ route('admin.module-categories.store') }}">
            @csrf
            <input type="hidden" name="_method" id="categoryMethod" value="POST">

            <div class="p-5 border-b border-[var(--border)] bg-[var(--bg3)] flex items-center justify-between">
                <h3 id="categoryModalTitle" class="text-sm font-extrabold text-[var(--ink)]">Tambah Kategori Baru</h3>
                <button type="button" onclick="closeCategoryModal()" class="text-[var(--muted)] hover:text-[var(--ink)] text-base">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div class="p-6 space-y-4">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-[var(--muted)] mb-1.5">Nama Kategori</label>
                    <input type="text" 
                           name="name" 
                           id="categoryNameInput" 
                           required 
                           placeholder="Contoh: CORE CONCEPTS, GETTING STARTED"
                           class="cyber-input text-xs font-medium">
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-[var(--muted)] mb-1.5">Urutan Tampil (Order)</label>
                    <input type="number" 
                           name="order" 
                           id="categoryOrderInput" 
                           value="1" 
                           min="0"
                           class="cyber-input text-xs font-mono">
                    <p class="text-[11px] text-[var(--muted)] mt-1">Angka lebih kecil tampil lebih atas di sidebar.</p>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-[var(--muted)] mb-1.5">Deskripsi (Opsional)</label>
                    <textarea name="description" 
                              id="categoryDescInput" 
                              rows="2" 
                              placeholder="Deskripsi kelompok modul ini..."
                              class="cyber-input text-xs font-medium"></textarea>
                </div>

                <div class="flex items-center gap-2 pt-1">
                    <input type="checkbox" name="is_active" id="categoryActiveInput" value="1" checked class="w-4 h-4 rounded text-[var(--blue)] border-[var(--border)]">
                    <label for="categoryActiveInput" class="text-xs text-[var(--text2)] font-medium cursor-pointer">Aktifkan kategori ini di sidebar</label>
                </div>

                <div class="pt-3 border-t border-[var(--border)] space-y-2.5">
                    <p class="text-[10px] font-bold uppercase tracking-wider text-[var(--muted)]">Keamanan Default (Bisa Disesuaikan Tiap Bab)</p>
                    <div class="flex items-center gap-2">
                        <input type="checkbox" name="enable_anti_screenshot" id="categoryAntiScreenshotInput" value="1" checked class="w-4 h-4 rounded text-emerald-600 border-[var(--border)]">
                        <label for="categoryAntiScreenshotInput" class="text-xs text-[var(--text)] font-medium cursor-pointer flex items-center gap-1.5">
                            <i class="fas fa-camera text-emerald-600 text-xs"></i> Proteksi Anti-Screenshot & Blackout (Default Nyala)
                        </label>
                    </div>
                    <div class="flex items-center gap-2">
                        <input type="checkbox" name="enable_anti_copy" id="categoryAntiCopyInput" value="1" checked class="w-4 h-4 rounded text-cyan-600 border-[var(--border)]">
                        <label for="categoryAntiCopyInput" class="text-xs text-[var(--text)] font-medium cursor-pointer flex items-center gap-1.5">
                            <i class="fas fa-copy text-cyan-600 text-xs"></i> Proteksi Anti-Salin & Blok Teks (Default Nyala)
                        </label>
                    </div>
                </div>
            </div>

            <div class="p-5 border-t border-[var(--border)] bg-[var(--bg3)] flex items-center justify-end gap-3">
                <button type="button" onclick="closeCategoryModal()" class="btn btn-small btn-outline text-xs">
                    Batal
                </button>
                <button type="submit" class="btn btn-small btn-gradient text-xs">
                    <i class="fas fa-save mr-1.5"></i>
                    <span id="categorySubmitBtnText">Simpan Kategori</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    const modal = document.getElementById('categoryModal');
    const form = document.getElementById('categoryForm');
    const title = document.getElementById('categoryModalTitle');
    const methodInput = document.getElementById('categoryMethod');
    const nameInput = document.getElementById('categoryNameInput');
    const orderInput = document.getElementById('categoryOrderInput');
    const descInput = document.getElementById('categoryDescInput');
    const activeInput = document.getElementById('categoryActiveInput');
    const antiScreenshotInput = document.getElementById('categoryAntiScreenshotInput');
    const antiCopyInput = document.getElementById('categoryAntiCopyInput');
    const submitBtnText = document.getElementById('categorySubmitBtnText');

    function openCreateCategoryModal() {
        form.action = "{{ route('admin.module-categories.store') }}";
        methodInput.value = "POST";
        title.innerText = "Tambah Kategori Baru";
        submitBtnText.innerText = "Simpan Kategori";
        nameInput.value = "";
        orderInput.value = "{{ ($categories->max('order') ?? 0) + 1 }}";
        descInput.value = "";
        activeInput.checked = true;
        antiScreenshotInput.checked = true;
        antiCopyInput.checked = true;
        modal.classList.remove('hidden');
        nameInput.focus();
    }

    function openEditCategoryModal(category) {
        form.action = `{{ url('admin/module-categories') }}/${category.id}`;
        methodInput.value = "PUT";
        title.innerText = "Edit Kategori: " + category.name;
        submitBtnText.innerText = "Perbarui Kategori";
        nameInput.value = category.name;
        orderInput.value = category.order;
        descInput.value = category.description || "";
        activeInput.checked = !!category.is_active;
        antiScreenshotInput.checked = (category.enable_anti_screenshot === undefined || category.enable_anti_screenshot === null) ? true : !!category.enable_anti_screenshot;
        antiCopyInput.checked = (category.enable_anti_copy === undefined || category.enable_anti_copy === null) ? true : !!category.enable_anti_copy;
        modal.classList.remove('hidden');
        nameInput.focus();
    }

    function closeCategoryModal() {
        modal.classList.add('hidden');
    }

    modal.addEventListener('click', (e) => {
        if (e.target === modal) closeCategoryModal();
    });
</script>
@endsection
