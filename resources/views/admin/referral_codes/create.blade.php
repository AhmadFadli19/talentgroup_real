@extends('layouts.app')

@section('title', 'Buat Kode Referral Baru | Flow Academy Admin')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">

    <!-- Header -->
    <div class="flex items-center justify-between mb-8 pb-4 border-b border-slate-800">
        <div>
            <div class="flex items-center gap-2 text-xs font-mono text-[var(--accent)] uppercase tracking-wider mb-1">
                <a href="{{ route('admin.referral-codes.index') }}" class="hover:underline">REFERRAL CODES</a>
                <i class="fas fa-chevron-right text-[9px]"></i>
                <span>NEW CODE</span>
            </div>
            <h1 class="text-2xl font-extrabold text-white">Buat Kode Referral Baru</h1>
            <p class="text-xs text-slate-400 mt-1">Buat kode akses gratis (100% OFF) atau kode diskon untuk modul dan kursus</p>
        </div>

        <a href="{{ route('admin.referral-codes.index') }}" class="cyber-btn text-xs">
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
        <form action="{{ route('admin.referral-codes.store') }}" method="POST">
            @csrf

            <div class="space-y-6">
                <!-- Kode Referral -->
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-2">
                        Kode Referral <span class="text-rose-400">*</span>
                    </label>
                    <input type="text" 
                           name="code" 
                           value="{{ old('code') }}" 
                           required 
                           placeholder="Contoh: CSSPRO, GRATIS100, DISKON50, POTONGAN30K"
                           class="cyber-input font-mono uppercase tracking-wider text-cyan-300 text-base font-bold">
                    <p class="text-[11px] text-slate-400 mt-1">Gunakan huruf kapital tanpa spasi.</p>
                </div>

                <!-- Deskripsi / Catatan -->
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-2">
                        Deskripsi / Keterangan (Opsional)
                    </label>
                    <input type="text" 
                           name="description" 
                           value="{{ old('description') }}" 
                           placeholder="Contoh: Kode beasiswa batch 1 / Promo peluncuran modul CSS"
                           class="cyber-input text-xs">
                </div>

                <!-- Tipe Diskon & Nilai -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-2">
                            Tipe Diskon <span class="text-rose-400">*</span>
                        </label>
                        <select name="discount_type" id="discountTypeSelect" required class="cyber-input text-xs" onchange="toggleDiscountValueField()">
                            <option value="free" {{ old('discount_type') === 'free' ? 'selected' : '' }}>100% Gratis (Rp 0 - Free Access)</option>
                            <option value="percentage" {{ old('discount_type') === 'percentage' ? 'selected' : '' }}>Persentase (%)</option>
                            <option value="fixed" {{ old('discount_type') === 'fixed' ? 'selected' : '' }}>Potongan Nominal Tetap (Rp)</option>
                        </select>
                    </div>

                    <div id="discountValueWrap" style="display: {{ old('discount_type') === 'percentage' || old('discount_type') === 'fixed' ? 'block' : 'none' }};">
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-2" id="discountValueLabel">
                            Nilai Diskon
                        </label>
                        <input type="number" 
                               name="discount_value" 
                               id="discountValueInput"
                               value="{{ old('discount_value', 0) }}" 
                               min="0" 
                               step="any"
                               placeholder="Contoh: 50 untuk 50%, atau 30000 untuk Rp 30.000"
                               class="cyber-input font-mono text-cyan-300">
                    </div>
                </div>

                <!-- Target Produk -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-2">
                            Target Penggunaan <span class="text-rose-400">*</span>
                        </label>
                        <select name="target_type" id="targetTypeSelect" required class="cyber-input text-xs" onchange="toggleTargetProductField()">
                            <option value="all" {{ old('target_type') === 'all' ? 'selected' : '' }}>Semua Kursus & Modul</option>
                            <option value="course" {{ old('target_type') === 'course' ? 'selected' : '' }}>Khusus Kursus Tertentu</option>
                            <option value="module" {{ old('target_type') === 'module' ? 'selected' : '' }}>Khusus Modul Tertentu</option>
                        </select>
                    </div>

                    <div id="targetProductWrap" style="display: {{ old('target_type') === 'course' || old('target_type') === 'module' ? 'block' : 'none' }};">
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-2" id="targetProductLabel">
                            Pilih Produk Tertentu
                        </label>
                        <select name="target_id" id="targetIdSelect" class="cyber-input text-xs">
                            <option value="">-- Pilih Item --</option>
                            <optgroup label="Kursus" id="optgroupCourses">
                                @foreach($courses as $course)
                                    <option value="{{ $course->id }}" {{ old('target_id') == $course->id ? 'selected' : '' }}>
                                        Kursus: {{ $course->title }} (Rp {{ number_format($course->price, 0, ',', '.') }})
                                    </option>
                                @endforeach
                            </optgroup>
                            <optgroup label="Modul Pembelajaran" id="optgroupModules">
                                @foreach($moduleCategories as $mod)
                                    <option value="{{ $mod->id }}" {{ old('target_id') == $mod->id ? 'selected' : '' }}>
                                        Modul: {{ $mod->name }} ({{ $mod->is_public ? 'Public' : 'Private' }})
                                    </option>
                                @endforeach
                            </optgroup>
                        </select>
                    </div>
                </div>

                <!-- Batas Penggunaan & Kedaluwarsa -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-2">
                            Maksimal Penggunaan (Kosongkan jika tak terbatas)
                        </label>
                        <input type="number" 
                               name="max_uses" 
                               value="{{ old('max_uses') }}" 
                               min="1" 
                               placeholder="Contoh: 100"
                               class="cyber-input font-mono">
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-2">
                            Tanggal Kedaluwarsa (Opsional)
                        </label>
                        <input type="datetime-local" 
                               name="expires_at" 
                               value="{{ old('expires_at') }}" 
                               class="cyber-input font-mono text-xs">
                    </div>
                </div>

                <!-- Status Aktif -->
                <div class="flex items-center gap-3 pt-2">
                    <input type="checkbox" 
                           name="is_active" 
                           id="isActiveCheckbox" 
                           value="1" 
                           {{ old('is_active', true) ? 'checked' : '' }}
                           class="w-4 h-4 rounded border-slate-700 bg-slate-900 text-cyan-500 focus:ring-0">
                    <label for="isActiveCheckbox" class="text-xs font-semibold text-slate-300 cursor-pointer">
                        Aktifkan kode referral ini sekarang (bisa langsung digunakan)
                    </label>
                </div>

                <!-- Submit Buttons -->
                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-800">
                    <a href="{{ route('admin.referral-codes.index') }}" class="cyber-btn text-xs">
                        Batal
                    </a>
                    <button type="submit" class="cyber-btn text-xs" style="background: #8b5cf6; border-color: #8b5cf6;">
                        <i class="fas fa-check mr-1.5"></i> Simpan Kode Referral
                    </button>
                </div>

            </div>
        </form>
    </div>

</div>

<script>
    function toggleDiscountValueField() {
        const type = document.getElementById('discountTypeSelect').value;
        const wrap = document.getElementById('discountValueWrap');
        const label = document.getElementById('discountValueLabel');
        const input = document.getElementById('discountValueInput');

        if (type === 'free') {
            wrap.style.display = 'none';
        } else if (type === 'percentage') {
            wrap.style.display = 'block';
            label.innerText = 'Persentase Diskon (1 - 100%)';
            input.placeholder = 'Contoh: 50';
        } else if (type === 'fixed') {
            wrap.style.display = 'block';
            label.innerText = 'Nominal Potongan (Rp)';
            input.placeholder = 'Contoh: 25000';
        }
    }

    function toggleTargetProductField() {
        const target = document.getElementById('targetTypeSelect').value;
        const wrap = document.getElementById('targetProductWrap');
        const coursesGroup = document.getElementById('optgroupCourses');
        const modulesGroup = document.getElementById('optgroupModules');

        if (target === 'all') {
            wrap.style.display = 'none';
        } else if (target === 'course') {
            wrap.style.display = 'block';
            coursesGroup.style.display = 'block';
            modulesGroup.style.display = 'none';
        } else if (target === 'module') {
            wrap.style.display = 'block';
            coursesGroup.style.display = 'none';
            modulesGroup.style.display = 'block';
        }
    }

    // Run on load
    document.addEventListener('DOMContentLoaded', () => {
        toggleDiscountValueField();
        toggleTargetProductField();
    });
</script>
@endsection
