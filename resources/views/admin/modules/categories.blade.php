@extends('layouts.app')

@section('title', 'Kelola Kategori Modul')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8">

    <!-- Header Section -->
    <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4 mb-8">
        <div>
            <div class="flex items-center gap-2 text-xs font-mono text-[var(--cyan)] uppercase tracking-wider mb-1">
                <a href="{{ route('admin.modules.index') }}" class="hover:underline">Modul</a>
                <i class="fas fa-chevron-right text-[10px]"></i>
                <span>Kategori Sidebar</span>
            </div>
            <h1 class="text-2xl md:text-3xl font-extrabold text-white tracking-tight">
                Kategori Sidebar Modul
            </h1>
            <p class="text-sm text-[var(--text2)] mt-1">
                Atur grup kategori slidebar seperti GETTING STARTED, CORE CONCEPTS, BASE STYLES, LAYOUT dll.
            </p>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('admin.modules.index') }}" 
               class="px-4 py-2.5 rounded-xl border border-[var(--border)] bg-slate-900/50 hover:bg-slate-800 text-slate-300 hover:text-white text-xs font-bold transition flex items-center gap-2">
                <i class="fas fa-arrow-left"></i>
                <span>Kembali ke Daftar Modul</span>
            </a>

            <button type="button" 
                    onclick="openCreateCategoryModal()"
                    class="cyber-btn flex items-center gap-2 text-xs">
                <i class="fas fa-plus"></i>
                <span>Tambah Kategori Baru</span>
            </button>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 rounded-xl border border-emerald-500/30 bg-emerald-950/20 text-emerald-400 text-sm flex items-center gap-3">
            <i class="fas fa-check-circle text-lg"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Categories List Table -->
    <div class="cyber-card overflow-hidden p-0">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm border-collapse">
                <thead class="bg-black/30 text-xs uppercase tracking-wider text-[var(--text2)] border-b border-[var(--border)]">
                    <tr>
                        <th class="px-5 py-4 font-bold">Urutan</th>
                        <th class="px-5 py-4 font-bold">Nama Kategori</th>
                        <th class="px-5 py-4 font-bold">Slug URL</th>
                        <th class="px-5 py-4 font-bold">Total Modul</th>
                        <th class="px-5 py-4 font-bold">Status</th>
                        <th class="px-5 py-4 font-bold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[var(--border)] text-[var(--text)]">
                    @forelse($categories as $category)
                        <tr class="hover:bg-slate-800/20 transition">
                            <td class="px-5 py-4 font-mono text-xs text-slate-400">
                                #{{ $category->order }}
                            </td>
                            <td class="px-5 py-4">
                                <span class="font-bold text-white text-sm">{{ $category->name }}</span>
                                @if($category->description)
                                    <p class="text-xs text-[var(--text2)] mt-0.5">{{ $category->description }}</p>
                                @endif
                            </td>
                            <td class="px-5 py-4 font-mono text-xs text-[var(--cyan)]">
                                {{ $category->slug }}
                            </td>
                            <td class="px-5 py-4 text-xs font-semibold">
                                <span class="px-2.5 py-1 rounded-md bg-slate-800 border border-slate-700/60 text-slate-300">
                                    {{ $category->modules_count }} Modul
                                </span>
                            </td>
                            <td class="px-5 py-4">
                                @if($category->is_active)
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-500/10 text-emerald-400 border border-emerald-500/30">
                                        <i class="fas fa-check text-[10px]"></i> Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-slate-800 text-slate-500 border border-slate-700">
                                        Nonaktif
                                    </span>
                                @endif
                            </td>
                            <td class="px-5 py-4 text-right">
                                <div class="inline-flex items-center gap-2">
                                    <button type="button" 
                                            onclick='openEditCategoryModal(@json($category))'
                                            class="p-2 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-300 hover:text-white transition"
                                            title="Edit Kategori">
                                        <i class="fas fa-edit text-xs"></i>
                                    </button>

                                    <form action="{{ route('admin.module-categories.destroy', $category->id) }}" method="POST" class="inline"
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini beserta seluruh modul di dalamnya?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="p-2 rounded-lg bg-slate-800 hover:bg-rose-500/20 text-slate-300 hover:text-rose-400 transition"
                                                title="Hapus Kategori">
                                            <i class="fas fa-trash text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-12 text-center text-slate-500 text-sm">
                                Belum ada kategori yang dibuat. Klik tombol "Tambah Kategori Baru".
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
<div id="categoryModal" class="fixed inset-0 z-50 hidden bg-black/80 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-slate-900 border border-slate-700/80 rounded-2xl w-full max-w-lg shadow-2xl overflow-hidden animate-in fade-in zoom-in-95 duration-200">
        <form id="categoryForm" method="POST" action="{{ route('admin.module-categories.store') }}">
            @csrf
            <input type="hidden" name="_method" id="categoryMethod" value="POST">

            <div class="p-5 border-b border-slate-800 flex items-center justify-between">
                <h3 id="categoryModalTitle" class="text-base font-bold text-white">Tambah Kategori Baru</h3>
                <button type="button" onclick="closeCategoryModal()" class="text-slate-400 hover:text-white">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div class="p-5 space-y-4">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">Nama Kategori</label>
                    <input type="text" 
                           name="name" 
                           id="categoryNameInput" 
                           required 
                           placeholder="Contoh: CORE CONCEPTS, GETTING STARTED"
                           class="cyber-input">
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">Urutan Tampil (Order)</label>
                    <input type="number" 
                           name="order" 
                           id="categoryOrderInput" 
                           value="1" 
                           min="0"
                           class="cyber-input">
                    <p class="text-[11px] text-slate-500 mt-1">Angka lebih kecil tampil lebih atas di sidebar.</p>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">Deskripsi (Opsional)</label>
                    <textarea name="description" 
                              id="categoryDescInput" 
                              rows="2" 
                              placeholder="Deskripsi singkat mengenai kelompok modul ini..."
                              class="cyber-input"></textarea>
                </div>

                <div class="flex items-center gap-2 pt-2">
                    <input type="checkbox" name="is_active" id="categoryActiveInput" value="1" checked class="w-4 h-4 rounded text-cyan-500 bg-slate-800 border-slate-700 focus:ring-0">
                    <label for="categoryActiveInput" class="text-xs text-slate-300 font-medium cursor-pointer">Aktifkan kategori ini di sidebar</label>
                </div>
            </div>

            <div class="p-5 border-t border-slate-800 bg-black/20 flex items-center justify-end gap-3">
                <button type="button" onclick="closeCategoryModal()" class="px-4 py-2 rounded-lg bg-slate-800 text-slate-300 hover:text-white text-xs font-semibold">
                    Batal
                </button>
                <button type="submit" class="cyber-btn text-xs">
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
