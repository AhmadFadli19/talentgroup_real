@extends('layouts.app')

@section('title', 'Buat Kode Referral Baru | Admin TalentGroup')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">

    <!-- Header -->
    <div class="flex items-center justify-between mb-8 pb-4 border-b border-[var(--border)]">
        <div>
            <div class="flex items-center gap-2 text-xs font-mono text-[var(--blue)] uppercase tracking-wider mb-1">
                <a href="{{ route('admin.referral-codes.index') }}" class="hover:underline">REFERRAL CODES</a>
                <i class="fas fa-chevron-right text-[9px]"></i>
                <span>NEW CODE</span>
            </div>
            <h1 class="text-2xl font-extrabold text-[var(--ink)]">Buat Kode Referral Baru</h1>
            <p class="text-xs text-[var(--muted)] mt-1">Buat kode akses gratis (100% OFF) atau kode diskon untuk modul dan kursus</p>
        </div>

        <a href="{{ route('admin.referral-codes.index') }}" class="btn-outline px-4 py-2.5 rounded-xl text-xs font-bold inline-flex items-center gap-2">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    @if($errors->any())
        <div class="mb-6 p-4 rounded-xl border border-rose-200 bg-rose-50 text-rose-800 text-xs">
            <ul class="list-disc pl-5 space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white border border-[var(--border)] rounded-2xl p-6 sm:p-8 shadow-sm">
        <form action="{{ route('admin.referral-codes.store') }}" method="POST">
            @csrf

            <div class="space-y-6">
                <!-- Kode Referral -->
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-[var(--ink)] mb-2">
                        Kode Referral <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" 
                           name="code" 
                           value="{{ old('code') }}" 
                           required 
                           placeholder="Contoh: CSSPRO, GRATIS100, DISKON50, POTONGAN30K"
                           class="w-full px-4 py-3 bg-slate-50 border border-[var(--border)] rounded-xl font-mono uppercase tracking-wider text-[var(--blue)] text-base font-bold focus:bg-white focus:border-[var(--blue)] focus:outline-none transition">
                    <p class="text-[11px] text-[var(--muted)] mt-1">Gunakan huruf kapital tanpa spasi.</p>
                </div>

                <!-- Deskripsi / Catatan -->
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-[var(--ink)] mb-2">
                        Deskripsi / Keterangan (Opsional)
                    </label>
                    <input type="text" 
                           name="description" 
                           value="{{ old('description') }}" 
                           placeholder="Contoh: Kode beasiswa batch 1 / Promo peluncuran modul CSS"
                           class="w-full px-4 py-2.5 bg-slate-50 border border-[var(--border)] rounded-xl text-xs text-[var(--ink)] focus:bg-white focus:border-[var(--blue)] focus:outline-none transition">
                </div>

                <!-- Tipe Diskon & Nilai -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-[var(--ink)] mb-2">
                            Tipe Diskon <span class="text-rose-500">*</span>
                        </label>
                        <select name="discount_type" id="discountTypeSelect" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-[var(--border)] rounded-xl text-xs text-[var(--ink)] focus:bg-white focus:border-[var(--blue)] focus:outline-none transition" onchange="toggleDiscountValueField()">
                            <option value="free" {{ old('discount_type') === 'free' ? 'selected' : '' }}>100% Gratis (Rp 0 - Free Access)</option>
                            <option value="percentage" {{ old('discount_type') === 'percentage' ? 'selected' : '' }}>Persentase (%)</option>
                            <option value="fixed" {{ old('discount_type') === 'fixed' ? 'selected' : '' }}>Potongan Nominal Tetap (Rp)</option>
                        </select>
                    </div>

                    <div id="discountValueWrap" style="display: {{ old('discount_type') === 'percentage' || old('discount_type') === 'fixed' ? 'block' : 'none' }};">
                        <label class="block text-xs font-bold uppercase tracking-wider text-[var(--ink)] mb-2" id="discountValueLabel">
                            Nilai Diskon
                        </label>
                        <input type="number" 
                               name="discount_value" 
                               id="discountValueInput"
                               value="{{ old('discount_value', 0) }}" 
                               min="0" 
                               step="any"
                               placeholder="Contoh: 50 untuk 50%, atau 30000 untuk Rp 30.000"
                               class="w-full px-3.5 py-2.5 bg-slate-50 border border-[var(--border)] rounded-xl font-mono text-xs text-[var(--blue)] font-bold focus:bg-white focus:border-[var(--blue)] focus:outline-none transition">
                    </div>
                </div>

                <!-- Target Produk -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-[var(--ink)] mb-2">
                            Target Penggunaan <span class="text-rose-500">*</span>
                        </label>
                        <select name="target_type" id="targetTypeSelect" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-[var(--border)] rounded-xl text-xs text-[var(--ink)] focus:bg-white focus:border-[var(--blue)] focus:outline-none transition" onchange="toggleTargetProductField()">
                            <option value="all" {{ old('target_type') === 'all' ? 'selected' : '' }}>Semua Kursus & Modul</option>
                            <option value="course" {{ old('target_type') === 'course' ? 'selected' : '' }}>Khusus Kursus Tertentu</option>
                            <option value="module" {{ old('target_type') === 'module' ? 'selected' : '' }}>Khusus Modul Tertentu</option>
                        </select>
                    </div>

                    <div id="targetProductWrap" style="display: {{ old('target_type') === 'course' || old('target_type') === 'module' ? 'block' : 'none' }};">
                        <label class="block text-xs font-bold uppercase tracking-wider text-[var(--ink)] mb-2" id="targetProductLabel">
                            Pilih Produk Tertentu
                        </label>
                        <select name="target_id" id="targetIdSelect" class="w-full px-3.5 py-2.5 bg-slate-50 border border-[var(--border)] rounded-xl text-xs text-[var(--ink)] focus:bg-white focus:border-[var(--blue)] focus:outline-none transition">
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
                        <label class="block text-xs font-bold uppercase tracking-wider text-[var(--ink)] mb-2">
                            Maksimal Penggunaan (Kosongkan jika tak terbatas)
                        </label>
                        <input type="number" 
                               name="max_uses" 
                               value="{{ old('max_uses') }}" 
                               min="1" 
                               placeholder="Contoh: 100"
                               class="w-full px-3.5 py-2.5 bg-slate-50 border border-[var(--border)] rounded-xl font-mono text-xs text-[var(--ink)] focus:bg-white focus:border-[var(--blue)] focus:outline-none transition">
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-[var(--ink)] mb-2">
                            Tanggal Kedaluwarsa (Opsional)
                        </label>
                        <input type="datetime-local" 
                               name="expires_at" 
                               value="{{ old('expires_at') }}" 
                               class="w-full px-3.5 py-2.5 bg-slate-50 border border-[var(--border)] rounded-xl font-mono text-xs text-[var(--ink)] focus:bg-white focus:border-[var(--blue)] focus:outline-none transition">
                    </div>
                </div>

                <!-- Status Aktif -->
                <div class="flex items-center gap-3 pt-2">
                    <input type="checkbox" 
                           name="is_active" 
                           id="isActiveCheckbox" 
                           value="1" 
                           {{ old('is_active', true) ? 'checked' : '' }}
                           class="w-4 h-4 rounded border-[var(--border)] text-[var(--blue)] accent-[var(--blue)]">
                    <label for="isActiveCheckbox" class="text-xs font-semibold text-[var(--ink)] cursor-pointer">
                        Aktifkan kode referral ini sekarang (bisa langsung digunakan peserta)
                    </label>
                </div>

                <!-- Submit Buttons -->
                <div class="flex items-center justify-end gap-3 pt-4 border-t border-[var(--border)]">
                    <a href="{{ route('admin.referral-codes.index') }}" class="btn-outline px-4 py-2.5 rounded-xl text-xs font-bold">
                        Batal
                    </a>
                    <button type="submit" class="btn-gradient px-6 py-2.5 rounded-xl text-white text-xs font-bold shadow-md inline-flex items-center gap-2">
                        <i class="fas fa-check"></i> Simpan Kode Referral
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

    document.addEventListener('DOMContentLoaded', () => {
        toggleDiscountValueField();
        toggleTargetProductField();
    });
</script>
@endsection
