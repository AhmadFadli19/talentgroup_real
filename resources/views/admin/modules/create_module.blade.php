@extends('layouts.app')

@section('title', 'Buat Modul Baru | TalentGroup.id')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">

    <div class="flex items-center justify-between mb-8 pb-4 border-b border-slate-800">
        <div>
            <div class="flex items-center gap-2 text-xs font-mono text-[var(--accent)] uppercase tracking-wider mb-1">
                <a href="{{ route('admin.modules.index') }}" class="hover:underline">MODULE MANAGER</a>
                <i class="fas fa-chevron-right text-[9px]"></i>
                <span>NEW MODULE</span>
            </div>
            <h1 class="text-2xl font-extrabold text-white">Buat Modul Pembelajaran Baru</h1>
            <p class="text-xs text-slate-400 mt-1">Buat modul baru yang terpisah (misalnya Modul CSS, Modul HTML, Modul Python, dsb)</p>
        </div>

        <a href="{{ route('admin.modules.index') }}" class="cyber-btn text-xs">
            <i class="fas fa-arrow-left mr-1.5"></i> Kembali
        </a>
    </div>

    @if($errors->any())
        <div class="mb-6 p-4 rounded-xl border border-rose-500/40 bg-rose-950/30 text-rose-300 text-xs">
            <ul class="list-disc pl-5 space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="cyber-card p-6 sm:p-8">
        <form action="{{ route('admin.modules.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="space-y-6">
                <!-- Module Name -->
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-2">
                        Nama Modul <span class="text-rose-400">*</span>
                    </label>
                    <input type="text" 
                           name="name" 
                           id="nameInput"
                           value="{{ old('name') }}" 
                           required 
                           placeholder="Contoh: Modul CSS Mastery, Modul HTML Modern, Modul Golang Advanced"
                           class="cyber-input text-white font-semibold">
                </div>

                <!-- Slug URL -->
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-2">
                        Slug URL (Otomatis dibuat jika dikosongkan)
                    </label>
                    <div class="flex items-center">
                        <span class="px-3 py-2 bg-slate-900 border border-r-0 border-slate-700 text-slate-500 font-mono text-xs rounded-l-lg">
                            /modules/
                        </span>
                        <input type="text" 
                               name="slug" 
                               id="slugInput"
                               value="{{ old('slug') }}" 
                               placeholder="modul-css-mastery"
                               class="cyber-input rounded-l-none font-mono text-xs text-cyan-300">
                    </div>
                </div>

                <!-- Description -->
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-2">
                        Deskripsi Singkat Modul
                    </label>
                    <textarea name="description" 
                              rows="3" 
                              placeholder="Penjelasan mengenai apa saja yang akan dipelajari di modul ini..."
                              class="cyber-input leading-relaxed">{{ old('description') }}</textarea>
                </div>

                <!-- Thumbnail Image Upload -->
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-2">
                        Gambar Thumbnail Modul (Opsional, format JPG/PNG/WEBP)
                    </label>
                    <input type="file" 
                           name="image" 
                           id="moduleImageInput"
                           accept="image/*"
                           class="cyber-input text-xs cursor-pointer">
                    <p class="text-[11px] text-slate-400 mt-1">
                        Jika tidak diunggah, modul akan menggunakan Icon FontAwesome di bawah.
                    </p>
                </div>

                <!-- Public vs Private Visibility Selection -->
                <div class="p-5 rounded-2xl bg-slate-950 border border-slate-800">
                    <label class="block text-xs font-bold uppercase tracking-wider text-white mb-3">
                        Tipe Akses Modul (Public / Private)
                    </label>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <label class="relative flex items-start gap-3 p-4 rounded-xl border border-slate-800 bg-slate-900/60 hover:bg-slate-900 cursor-pointer transition">
                            <input type="radio" name="is_public" value="1" {{ old('is_public', '1') == '1' ? 'checked' : '' }} onchange="togglePrivateFields(false)" class="mt-1 text-cyan-500 focus:ring-0">
                            <div>
                                <span class="block text-xs font-bold text-emerald-400">🌐 Public (Gratis Semua Pengguna)</span>
                                <span class="text-[11px] text-slate-400">Bisa diakses dan dibaca langsung oleh semua pengunjung tanpa kode referral.</span>
                            </div>
                        </label>

                        <label class="relative flex items-start gap-3 p-4 rounded-xl border border-slate-800 bg-slate-900/60 hover:bg-slate-900 cursor-pointer transition">
                            <input type="radio" name="is_public" value="0" {{ old('is_public') == '0' ? 'checked' : '' }} onchange="togglePrivateFields(true)" class="mt-1 text-amber-500 focus:ring-0">
                            <div>
                                <span class="block text-xs font-bold text-amber-400">🔒 Private (Terkunci)</span>
                                <span class="text-[11px] text-slate-400">Hanya bisa dibuka jika admin menambahkan manual atau dengan kode referral.</span>
                            </div>
                        </label>
                    </div>

                    <!-- Referral Code field for Private -->
                    <div id="privateSettings" class="mt-4 pt-4 border-t border-slate-800 {{ old('is_public', '1') == '0' ? '' : 'hidden' }}">
                        <label class="block text-xs font-bold uppercase tracking-wider text-amber-400 mb-2">
                            <i class="fas fa-key mr-1"></i> Kode Referral untuk Membuka Modul Ini (Opsional)
                        </label>
                        <input type="text" 
                               name="referral_code" 
                               value="{{ old('referral_code') }}" 
                               placeholder="Contoh: CSSPRO, RAHASIA2026 (Huruf Besar)"
                               class="cyber-input font-mono uppercase tracking-wider text-amber-300">
                        <p class="text-[11px] text-slate-500 mt-1.5">
                            Pengguna yang memasukkan kode ini dapat membuka modul secara otomatis.
                        </p>
                    </div>
                </div>

                <!-- Appearance: Icon, Color, Badge -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">
                            Icon FontAwesome
                        </label>
                        <input type="text" 
                               name="icon" 
                               value="{{ old('icon', 'fas fa-book') }}" 
                               placeholder="fab fa-css3-alt, fab fa-html5, fas fa-code"
                               class="cyber-input font-mono text-xs">
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">
                            Warna Aksen Hex
                        </label>
                        <input type="text" 
                               name="color" 
                               value="{{ old('color', '#38bdf8') }}" 
                               placeholder="#38bdf8, #f59e0b, #ef4444"
                               class="cyber-input font-mono text-xs">
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">
                            Badge Teks
                        </label>
                        <input type="text" 
                               name="badge" 
                               value="{{ old('badge', 'Populer') }}" 
                               placeholder="Pemula, Lanjutan, Eksklusif"
                               class="cyber-input text-xs">
                    </div>
                <!-- Security Settings (Default Anti-Screenshot & Anti-Copy) -->
                <div class="p-5 rounded-2xl bg-slate-950 border border-slate-800">
                    <label class="block text-xs font-bold uppercase tracking-wider text-white mb-2 flex items-center gap-2">
                        <i class="fas fa-shield-alt text-cyan-400"></i> Pengaturan Keamanan Default Modul
                    </label>
                    <p class="text-[11px] text-slate-400 mb-4">
                        Tentukan pengaturan keamanan default untuk seluruh materi di dalam modul pembelajaran ini.
                    </p>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- Anti-Screenshot -->
                        <label class="flex items-start gap-3 p-3.5 rounded-xl border border-emerald-500/30 bg-emerald-950/20 hover:bg-emerald-950/30 cursor-pointer transition select-none">
                            <input type="hidden" name="enable_anti_screenshot" value="0">
                            <input type="checkbox" name="enable_anti_screenshot" value="1" {{ old('enable_anti_screenshot', true) ? 'checked' : '' }} class="mt-0.5 w-4 h-4 rounded text-emerald-500 bg-slate-800 border-slate-700 focus:ring-0">
                            <div>
                                <span class="block text-xs font-bold text-emerald-400 flex items-center gap-1.5">
                                    <i class="fas fa-camera"></i> Proteksi Anti-Screenshot
                                </span>
                                <span class="text-[11px] text-emerald-300/70">Blackout otomatis saat PrtScn, Win+Shift+S, Snipping Tool, atau gesture HP. (Default: Nyala)</span>
                            </div>
                        </label>

                        <!-- Anti-Copy -->
                        <label class="flex items-start gap-3 p-3.5 rounded-xl border border-cyan-500/30 bg-cyan-950/20 hover:bg-cyan-950/30 cursor-pointer transition select-none">
                            <input type="hidden" name="enable_anti_copy" value="0">
                            <input type="checkbox" name="enable_anti_copy" value="1" {{ old('enable_anti_copy', true) ? 'checked' : '' }} class="mt-0.5 w-4 h-4 rounded text-cyan-500 bg-slate-800 border-slate-700 focus:ring-0">
                            <div>
                                <span class="block text-xs font-bold text-cyan-300 flex items-center gap-1.5">
                                    <i class="fas fa-copy"></i> Proteksi Anti-Salin Teks
                                </span>
                                <span class="text-[11px] text-cyan-400/70">Cegah seleksi teks, blokir klik kanan, dan cegah copy/cut materi (salin kode tetap bisa). (Default: Nyala)</span>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Status & Order -->
                <div class="flex flex-wrap items-center justify-between gap-4 pt-4 border-t border-slate-800">
                    <label class="flex items-center gap-2.5 cursor-pointer select-none">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" name="is_active" value="1" checked class="w-4 h-4 rounded text-cyan-500 bg-slate-900 border-slate-700 focus:ring-cyan-500">
                        <span class="text-xs font-bold text-white uppercase tracking-wider">Aktifkan Modul</span>
                        <span class="text-[11px] text-slate-400 font-normal">(Hilangkan centang jika ingin disimpan sebagai draft)</span>
                    </label>

                    <div class="flex items-center gap-3">
                        <a href="{{ route('admin.modules.index') }}" class="px-4 py-2 rounded-xl text-xs font-semibold text-slate-400 hover:text-white">
                            Batal
                        </a>
                        <button type="submit" class="cyber-btn text-xs flex items-center gap-2">
                            <i class="fas fa-save"></i>
                            <span>Simpan & Buat Modul</span>
                        </button>
                    </div>
                </div>

            </div>
        </form>
    </div>
</div>

<script>
    function togglePrivateFields(isPrivate) {
        const box = document.getElementById('privateSettings');
        if (isPrivate) {
            box.classList.remove('hidden');
        } else {
            box.classList.add('hidden');
        }
    }

    document.getElementById('nameInput').addEventListener('input', function(e) {
        const slugInput = document.getElementById('slugInput');
        if (!slugInput.value || slugInput.dataset.manual !== 'true') {
            slugInput.value = e.target.value.toLowerCase().trim()
                .replace(/[^\w\s-]/g, '')
                .replace(/[\s_-]+/g, '-')
                .replace(/^-+|-+$/g, '');
        }
    });

    document.getElementById('slugInput').addEventListener('input', function() {
        this.dataset.manual = 'true';
    });
</script>
@endsection
