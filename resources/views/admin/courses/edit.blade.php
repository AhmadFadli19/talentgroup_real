@extends('layouts.app')

@section('title', 'Edit Kursus: ' . $course->title . ' | Admin TalentGroup')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">

    <!-- Header -->
    <div class="flex items-center justify-between gap-4 mb-8 pb-4 border-b border-[var(--border)]">
        <div>
            <div class="flex items-center gap-2 text-xs font-mono text-[var(--blue)] uppercase tracking-wider mb-1">
                <a href="{{ route('admin.courses.index') }}" class="hover:underline">COURSES</a>
                <i class="fas fa-chevron-right text-[9px]"></i>
                <span>EDIT COURSE</span>
            </div>
            <h1 class="text-2xl font-extrabold text-[var(--ink)]">Perbarui Kursus</h1>
            <p class="text-xs text-[var(--muted)] mt-1">Ubah informasi kurikulum, harga, foto cover, dan status kursus</p>
        </div>

        <a href="{{ route('admin.courses.index') }}" class="btn-outline px-4 py-2.5 rounded-xl text-xs font-bold inline-flex items-center gap-2">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <!-- Form Card -->
    <div class="bg-white border border-[var(--border)] rounded-2xl p-6 sm:p-8 shadow-sm">
        <form action="{{ route('admin.courses.update', $course) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Title -->
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-[var(--ink)] mb-2">
                    Judul Kursus <span class="text-rose-500">*</span>
                </label>
                <input type="text" name="title" value="{{ old('title', $course->title) }}" required
                       class="w-full px-4 py-3 bg-slate-50 border border-[var(--border)] rounded-xl text-sm font-semibold text-[var(--ink)] focus:bg-white focus:border-[var(--blue)] focus:outline-none transition @error('title') border-rose-500 @enderror">
                @error('title')
                    <p class="text-xs text-rose-500 mt-1.5 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-[var(--ink)] mb-2">
                    Deskripsi Kursus <span class="text-rose-500">*</span>
                </label>
                <textarea name="description" rows="4" required
                          class="w-full px-4 py-3 bg-slate-50 border border-[var(--border)] rounded-xl text-xs leading-relaxed text-[var(--ink)] focus:bg-white focus:border-[var(--blue)] focus:outline-none transition @error('description') border-rose-500 @enderror">{{ old('description', $course->description) }}</textarea>
                @error('description')
                    <p class="text-xs text-rose-500 mt-1.5 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Price & Status Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <!-- Price -->
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-[var(--ink)] mb-2">
                        Harga Kursus (Rp) <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center font-bold text-xs text-[var(--muted)]">Rp</span>
                        <input type="number" name="price" min="0" step="1000"
                               value="{{ old('price', $course->price) }}" required
                               class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-[var(--border)] rounded-xl text-xs font-mono font-bold text-[var(--ink)] focus:bg-white focus:border-[var(--blue)] focus:outline-none transition @error('price') border-rose-500 @enderror">
                    </div>
                    <p class="text-[11px] text-[var(--muted)] mt-1.5">Masukkan 0 jika kursus ingin dibuka secara 100% Gratis.</p>
                    @error('price')
                        <p class="text-xs text-rose-500 mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status Checkbox -->
                <div class="flex flex-col justify-end">
                    <label class="flex items-start gap-3 p-3.5 rounded-xl bg-slate-50 border border-[var(--border)] hover:border-slate-300 cursor-pointer transition">
                        <input type="checkbox" name="is_active" value="1"
                               {{ old('is_active', $course->is_active) ? 'checked' : '' }}
                               class="mt-0.5 rounded accent-[var(--blue)] w-4 h-4">
                        <div>
                            <span class="text-xs font-bold text-[var(--ink)] block">Kursus Aktif & Dipublikasikan</span>
                            <span class="text-[11px] text-[var(--muted)]">Centang agar kursus dapat diakses dan dilihat oleh peserta.</span>
                        </div>
                    </label>
                </div>
            </div>

            <!-- Quiz Rules & Navigation Settings -->
            <div class="p-4 sm:p-5 bg-[var(--surface2)] rounded-2xl border border-[var(--border)] space-y-4">
                <div class="flex items-center gap-2 pb-3 border-b border-[var(--border)]">
                    <div class="w-8 h-8 rounded-xl bg-[var(--blue-light)] text-[var(--blue)] flex items-center justify-center text-sm font-bold border border-[var(--border)]">
                        <i class="fas fa-sliders-h"></i>
                    </div>
                    <div>
                        <h4 class="text-xs font-black uppercase tracking-wider text-[var(--ink)]">Pengaturan Evaluasi & Kuis (Quiz Configuration)</h4>
                        <p class="text-[11px] text-[var(--muted)]">Atur kapan jawaban dibongkar dan bagaimana siswa menavigasi pertanyaan materi & kuis.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Quiz Answer Visibility -->
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-[var(--ink)] mb-2">
                            <i class="fas fa-eye text-[var(--blue)] mr-1"></i> Penyingkapan Kunci Jawaban
                        </label>
                        <div class="space-y-2">
                            <label class="flex items-start gap-3 p-3 rounded-xl border border-[var(--border)] bg-[var(--surface)] cursor-pointer hover:border-[var(--blue)] transition shadow-sm">
                                <input type="radio" name="quiz_answer_visibility" value="end" {{ old('quiz_answer_visibility', $course->quiz_answer_visibility ?? 'end') === 'end' ? 'checked' : '' }} class="mt-1 accent-[var(--blue)]">
                                <div>
                                    <div class="text-xs font-bold text-[var(--ink)] flex items-center gap-1.5">
                                        <span>Setelah Selesai Semua</span>
                                        <span class="px-1.5 py-0.5 rounded bg-blue-50 text-[var(--blue)] text-[10px] font-semibold border border-blue-200">Default</span>
                                    </div>
                                    <p class="text-[11px] text-[var(--muted)] mt-0.5 leading-relaxed">
                                        Jawaban benar/salah tidak langsung dibongkar saat klik simpan, melainkan baru terbuka di halaman hasil setelah siswa menyelesaikan seluruh materi/soal kursus.
                                    </p>
                                </div>
                            </label>

                            <label class="flex items-start gap-3 p-3 rounded-xl border border-[var(--border)] bg-[var(--surface)] cursor-pointer hover:border-[var(--blue)] transition shadow-sm">
                                <input type="radio" name="quiz_answer_visibility" value="instant" {{ old('quiz_answer_visibility', $course->quiz_answer_visibility) === 'instant' ? 'checked' : '' }} class="mt-1 accent-[var(--blue)]">
                                <div>
                                    <div class="text-xs font-bold text-[var(--ink)]">Langsung Ketahuan Tiap Soal</div>
                                    <p class="text-[11px] text-[var(--muted)] mt-0.5 leading-relaxed">
                                        Setiap kali siswa mengirim jawaban soal kuis/coding, status benar/salah dan kunci jawaban langsung tampil seketika di layar.
                                    </p>
                                </div>
                            </label>

                            <label class="flex items-start gap-3 p-3 rounded-xl border border-[var(--border)] bg-[var(--surface)] cursor-pointer hover:border-[var(--blue)] transition shadow-sm">
                                <input type="radio" name="quiz_answer_visibility" value="none" {{ old('quiz_answer_visibility', $course->quiz_answer_visibility) === 'none' ? 'checked' : '' }} class="mt-1 accent-[var(--blue)]">
                                <div>
                                    <div class="text-xs font-bold text-[var(--ink)]">Kunci Jawaban Dirahasiakan (None)</div>
                                    <p class="text-[11px] text-[var(--muted)] mt-0.5 leading-relaxed">
                                        Siswa hanya mendapat skor akhir, namun kunci jawaban benar tidak akan pernah ditampilkan baik saat menjawab maupun di hasil akhir.
                                    </p>
                                </div>
                            </label>
                        </div>
                        @error('quiz_answer_visibility')
                            <p class="text-xs text-rose-500 mt-1.5 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Quiz Navigation Mode -->
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-[var(--ink)] mb-2">
                            <i class="fas fa-arrows-alt-h text-[var(--blue)] mr-1"></i> Mode Navigasi Soal
                        </label>
                        <div class="space-y-2">
                            <label class="flex items-start gap-3 p-3 rounded-xl border border-[var(--border)] bg-[var(--surface)] cursor-pointer hover:border-[var(--blue)] transition shadow-sm">
                                <input type="radio" name="quiz_navigation_mode" value="free" {{ old('quiz_navigation_mode', $course->quiz_navigation_mode ?? 'free') === 'free' ? 'checked' : '' }} class="mt-1 accent-[var(--blue)]">
                                <div>
                                    <div class="text-xs font-bold text-[var(--ink)] flex items-center gap-1.5">
                                        <span>Bebas Pindah (Prev & Next)</span>
                                        <span class="px-1.5 py-0.5 rounded bg-blue-50 text-[var(--blue)] text-[10px] font-semibold border border-blue-200">Default</span>
                                    </div>
                                    <p class="text-[11px] text-[var(--muted)] mt-0.5 leading-relaxed">
                                        Siswa bebas kembali ke soal sebelumnya (Prev), lanjut ke berikutnya (Next), atau melompat antar modul melalui daftar navigator.
                                    </p>
                                </div>
                            </label>

                            <label class="flex items-start gap-3 p-3 rounded-xl border border-[var(--border)] bg-[var(--surface)] cursor-pointer hover:border-[var(--blue)] transition shadow-sm">
                                <input type="radio" name="quiz_navigation_mode" value="next_only" {{ old('quiz_navigation_mode', $course->quiz_navigation_mode) === 'next_only' ? 'checked' : '' }} class="mt-1 accent-[var(--blue)]">
                                <div>
                                    <div class="text-xs font-bold text-[var(--ink)]">Hanya Bisa Next (No Prev / Linear)</div>
                                    <p class="text-[11px] text-[var(--muted)] mt-0.5 leading-relaxed">
                                        Siswa tidak dapat kembali ke soal/materi yang sudah dilewati. Tombol Prev dinonaktifkan untuk mencegah koreksi ulang.
                                    </p>
                                </div>
                            </label>
                        </div>
                        @error('quiz_navigation_mode')
                            <p class="text-xs text-rose-500 mt-1.5 font-medium">{{ $message }}</p>
                        @enderror

                        <!-- Note about score calculation -->
                        <div class="mt-4 p-3 rounded-xl border flex items-start gap-2.5 text-[11px] bg-amber-500/10 border-amber-500/30 text-amber-800 dark:text-amber-200">
                            <i class="fas fa-info-circle text-amber-500 mt-0.5"></i>
                            <div>
                                <strong class="font-bold">Ketentuan Penilaian:</strong> Modul bertipe Video, Cerita / Bacaan tidak menyumbang nilai/skor. Skor hanya dihitung dari soal kuis & latihan coding.
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Fitur Pengacakan Soal & Pilihan (Shuffle) -->
                <div class="pt-4 border-t border-[var(--border)]">
                    <label class="block text-xs font-bold uppercase tracking-wider text-[var(--ink)] mb-2 flex items-center gap-1.5">
                        <i class="fas fa-random text-[var(--blue)]"></i> Pengacakan Soal & Pilihan Ganda (Randomize / Shuffle)
                    </label>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        <label class="flex items-start gap-3 p-3.5 rounded-xl border border-[var(--border)] bg-[var(--surface)] cursor-pointer hover:border-[var(--blue)] transition shadow-sm">
                            <input type="checkbox" name="shuffle_questions" value="1" {{ old('shuffle_questions', $course->shuffle_questions ?? true) ? 'checked' : '' }} class="mt-1 accent-[var(--blue)] w-4 h-4">
                            <div>
                                <div class="text-xs font-bold text-[var(--ink)] flex items-center gap-1.5">
                                    <span>Acak Urutan Soal (Shuffle Questions)</span>
                                    <span class="px-1.5 py-0.5 rounded bg-emerald-50 text-emerald-600 text-[9px] font-bold border border-emerald-200">Default Aktif</span>
                                </div>
                                <p class="text-[11px] text-[var(--muted)] mt-0.5 leading-relaxed">
                                    Urutan soal-soal kuis diacak secara unik dan konsisten untuk masing-masing siswa guna mencegah kecurangan.
                                </p>
                            </div>
                        </label>

                        <label class="flex items-start gap-3 p-3.5 rounded-xl border border-[var(--border)] bg-[var(--surface)] cursor-pointer hover:border-[var(--blue)] transition shadow-sm">
                            <input type="checkbox" name="shuffle_options" value="1" {{ old('shuffle_options', $course->shuffle_options ?? true) ? 'checked' : '' }} class="mt-1 accent-[var(--blue)] w-4 h-4">
                            <div>
                                <div class="text-xs font-bold text-[var(--ink)] flex items-center gap-1.5">
                                    <span>Acak Pilihan Ganda (Shuffle Options)</span>
                                    <span class="px-1.5 py-0.5 rounded bg-emerald-50 text-emerald-600 text-[9px] font-bold border border-emerald-200">Default Aktif</span>
                                </div>
                                <p class="text-[11px] text-[var(--muted)] mt-0.5 leading-relaxed">
                                    Posisi pilihan jawaban A, B, C, D di setiap soal diacak secara dinamis. Penilaian tetap akurat sesuai teks jawaban kunci.
                                </p>
                            </div>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Image File Upload & Current Preview -->
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-[var(--ink)] mb-2">
                    Foto Sampul Kursus (Cover Image)
                </label>

                @if($course->image)
                    <div class="mb-3 p-3 bg-[var(--surface2)] border border-[var(--border)] rounded-xl flex items-center gap-4">
                        <img src="{{ $course->image_url }}" alt="{{ $course->title }}" class="w-20 h-14 object-cover rounded-lg border border-[var(--border)]">
                        <div>
                            <div class="text-xs font-bold text-[var(--ink)]">Sampul Saat Ini</div>
                            <div class="text-[11px] text-[var(--muted)]">Unggah file baru di bawah ini hanya jika ingin menggantinya.</div>
                        </div>
                    </div>
                @endif

                <div class="border-2 border-dashed border-[var(--border)] hover:border-[var(--blue)] rounded-2xl p-6 text-center bg-[var(--surface2)] transition cursor-pointer" onclick="document.getElementById('courseImageInput').click()">
                    <i class="fas fa-image text-3xl text-[var(--blue)] mb-2 block"></i>
                    <p class="text-xs font-bold text-[var(--ink)]">Klik untuk mengganti gambar cover</p>
                    <p class="text-[11px] text-[var(--muted)] mt-1">Kosongkan jika tidak ingin mengganti (Maks 2MB)</p>
                    <input type="file" name="image" id="courseImageInput" accept="image/*" class="hidden" onchange="previewCourseImage(this)">
                </div>
                <div id="imagePreviewContainer" class="hidden mt-3 p-2 bg-[var(--surface2)] rounded-xl inline-flex items-center gap-3 border border-[var(--border)]">
                    <img id="imagePreview" src="#" alt="Preview" class="w-16 h-12 object-cover rounded-lg border border-[var(--border)]">
                    <span id="imageFileName" class="text-xs font-medium text-[var(--ink)] font-mono"></span>
                </div>
                @error('image')
                    <p class="text-xs text-rose-500 mt-1.5 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <!-- Actions -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-[var(--border)]">
                <a href="{{ route('admin.courses.index') }}" class="btn-outline px-5 py-2.5 rounded-xl text-xs font-bold">
                    Batal
                </a>
                <button type="submit" class="btn-gradient px-6 py-2.5 rounded-xl text-white text-xs font-bold shadow-md inline-flex items-center gap-2">
                    <i class="fas fa-save"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

</div>

<script>
    function previewCourseImage(input) {
        if (input.files && input.files[0]) {
            const file = input.files[0];
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('imagePreview').src = e.target.result;
                document.getElementById('imageFileName').innerText = file.name;
                document.getElementById('imagePreviewContainer').classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        }
    }
</script>
@endsection
