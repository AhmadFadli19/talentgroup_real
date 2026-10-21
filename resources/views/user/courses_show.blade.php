@extends('layouts.app')

@section('title', $course->title)

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 py-8">

    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('user.courses.index') }}" class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl bg-slate-900/80 hover:bg-slate-800 text-slate-300 hover:text-white border border-slate-700/60 text-xs font-bold transition">
            <i class="fas fa-arrow-left text-cyan-400"></i>
            <span>Kembali ke Daftar Kursus</span>
        </a>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 rounded-xl border border-emerald-500/40 bg-emerald-950/30 text-emerald-300 text-sm flex items-center gap-3 shadow-xl">
            <i class="fas fa-check-circle text-lg text-emerald-400"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 p-4 rounded-xl border border-rose-500/40 bg-rose-950/30 text-rose-300 text-sm flex items-center gap-3 shadow-xl">
            <i class="fas fa-exclamation-triangle text-lg text-rose-400"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <div class="cyber-card flex flex-col p-6 sm:p-8 relative overflow-hidden" style="border-color: var(--accent);">
        
        <div class="absolute inset-0 opacity-10" style="background: repeating-linear-gradient(45deg, transparent, transparent 10px, var(--accent) 10px, var(--accent) 20px);"></div>
        
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-6 mb-8 relative z-10">
            <div class="flex items-start gap-4 flex-1">
                <div class="w-20 h-20 rounded-xl border overflow-hidden flex-shrink-0" style="border-color: var(--border); background: var(--bg);">
                    @if($course->image)
                        <img src="{{ $course->image_url }}" class="w-full h-full object-cover" alt="{{ $course->title }}">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-4xl">🎓</div>
                    @endif
                </div>
                <div>
                    <h1 class="text-2xl font-bold mb-2 text-white" style="font-family: 'Outfit', sans-serif;">
                        {{ $course->title }}
                    </h1>
                    <p class="text-xs sm:text-sm text-slate-400 font-mono leading-relaxed">
                        {{ $course->description }}
                    </p>

                    <div class="flex flex-wrap items-center gap-3 mt-4 text-[11px] font-mono text-slate-400">
                        <span class="px-2 py-0.5 rounded bg-slate-900 border border-slate-800">
                            <i class="fas fa-book-open text-cyan-400 mr-1"></i> {{ $totalContents }} Materi
                        </span>
                        <span class="px-2 py-0.5 rounded bg-slate-900 border border-slate-800">
                            <i class="fas fa-users text-cyan-400 mr-1"></i> {{ $enrolledCount }} Peserta Terdaftar
                        </span>
                    </div>
                </div>
            </div>

            <div class="bg-black/30 p-4 rounded-xl border text-right min-w-[170px]" style="border-color: var(--border);">
                <p class="text-[10px] uppercase tracking-widest mb-1 text-slate-400">Biaya Kursus</p>
                <p id="displayPrice" class="text-2xl font-extrabold font-mono" style="color: {{ $course->price > 0 ? 'var(--yellow)' : 'var(--green)' }};">
                    {{ $course->price > 0 ? 'Rp ' . number_format($course->price,0,',','.') : 'FREE' }}
                </p>
                @if($course->price > 0 && !$isEnrolled)
                    <p class="text-[10px] text-cyan-400 mt-1">Saldo Anda: Rp {{ number_format(auth()->user()->balance, 0, ',', '.') }}</p>
                @endif
            </div>
        </div>

        @if (!$isEnrolled && $course->price > 0)
            <!-- ============================================== -->
            <!-- REFERRAL CODE & DISCOUNT PROMO SECTION        -->
            <!-- ============================================== -->
            <div class="mb-8 p-5 rounded-2xl bg-slate-950/90 border border-slate-800 relative z-10 shadow-inner">
                <div class="flex items-center gap-2 mb-3">
                    <i class="fas fa-ticket-alt text-amber-400 text-sm"></i>
                    <span class="text-xs font-bold uppercase tracking-wider text-white">Punya Kode Referral / Voucher Diskon?</span>
                </div>

                <p class="text-xs text-slate-400 mb-4 leading-relaxed">
                    Gunakan kode referral untuk mendapatkan potongan harga spesial atau membuka kursus secara <strong class="text-emerald-400 font-bold">100% GRATIS</strong>.
                </p>

                <div class="flex flex-col sm:flex-row gap-3">
                    <div class="relative flex-1">
                        <input type="text" 
                               id="referralInput" 
                               placeholder="Masukkan kode (contoh: GRATIS100, DISKON50, dll)"
                               class="cyber-input uppercase font-mono tracking-wider text-xs pl-9">
                        <i class="fas fa-tag absolute left-3 top-3 text-slate-500 text-xs"></i>
                    </div>

                    <button type="button" 
                            id="btnApplyReferral"
                            onclick="applyReferralCode()" 
                            class="px-4 py-2.5 rounded-xl bg-cyan-500 hover:bg-cyan-400 text-slate-950 font-bold text-xs transition flex items-center justify-center gap-2 shadow">
                        <i class="fas fa-check"></i>
                        <span>Terapkan Kode</span>
                    </button>
                </div>

                <!-- AJAX Feedback Box -->
                <div id="referralFeedback" class="hidden mt-3 p-3 rounded-xl text-xs font-semibold"></div>

                <!-- Price Breakdown Details (Hidden by default until code applied) -->
                <div id="priceBreakdown" class="hidden mt-4 pt-4 border-t border-slate-800 space-y-1.5 text-xs font-mono">
                    <div class="flex justify-between text-slate-400">
                        <span>Harga Asli:</span>
                        <span>Rp {{ number_format($course->price, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-emerald-400 font-semibold">
                        <span>Potongan Kode Referral:</span>
                        <span id="summaryDiscount">-Rp 0</span>
                    </div>
                    <div class="flex justify-between text-white font-bold pt-2 border-t border-slate-800 text-sm">
                        <span>Total Pembayaran:</span>
                        <span id="summaryFinalPrice" class="text-cyan-400">Rp 0</span>
                    </div>
                </div>
            </div>
        @endif

        <!-- Action Bottom Bar -->
        <div class="border-t pt-6 flex flex-col sm:flex-row gap-4 items-center justify-between relative z-10" style="border-color: var(--border);">
            <div>
                <a href="{{ route('user.courses.index') }}" class="text-xs text-slate-400 hover:text-white transition flex items-center gap-1.5 font-mono">
                    <i class="fas fa-chevron-left text-[10px]"></i>
                    <span>Kembali ke Katalog</span>
                </a>
            </div>
            
            <div class="flex items-center gap-3 w-full sm:w-auto">
                @if ($isEnrolled)
                    <a href="{{ route('user.courses.learn', $course->id) }}" class="btn-primary w-full sm:w-auto text-center">
                        <i class="fas fa-play mr-2"></i> Lanjutkan Belajar
                    </a>
                @else
                    <form method="POST" action="{{ route('user.courses.purchase', $course->id) }}" class="m-0 w-full sm:w-auto" id="purchaseCourseForm">
                        @csrf
                        <input type="hidden" name="referral_code" id="formReferralCode" value="">
                        
                        <button type="submit" 
                                id="purchaseSubmitBtn"
                                class="cyber-btn w-full sm:w-auto flex items-center justify-center gap-2" 
                                style="border-color: {{ $course->price > 0 ? 'var(--yellow)' : 'var(--green)' }}; color: {{ $course->price > 0 ? 'var(--yellow)' : 'var(--green)' }};">
                            <i class="fas fa-unlock mr-1" id="purchaseBtnIcon"></i> 
                            <span id="purchaseBtnText">
                                {{ $course->price > 0 ? 'Beli & Dapatkan Akses (Rp ' . number_format($course->price,0,',','.') . ')' : 'Mulai Belajar Sekarang (Gratis)' }}
                            </span>
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>

@if (!$isEnrolled && $course->price > 0)
<script>
    function applyReferralCode() {
        const input = document.getElementById('referralInput');
        const code = input.value.trim().toUpperCase();
        const feedback = document.getElementById('referralFeedback');
        const breakdown = document.getElementById('priceBreakdown');
        const formRef = document.getElementById('formReferralCode');
        const btn = document.getElementById('btnApplyReferral');
        const purchaseBtn = document.getElementById('purchaseSubmitBtn');
        const purchaseBtnText = document.getElementById('purchaseBtnText');
        const purchaseBtnIcon = document.getElementById('purchaseBtnIcon');

        if (!code) {
            feedback.className = 'mt-3 p-3 rounded-xl text-xs font-semibold bg-rose-950/40 text-rose-400 border border-rose-500/40 flex items-center gap-2';
            feedback.innerHTML = '<i class="fas fa-exclamation-circle"></i> <span>Silakan ketikkan kode referral terlebih dahulu.</span>';
            feedback.classList.remove('hidden');
            return;
        }

        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> <span>Mengecek...</span>';

        fetch("{{ route('user.courses.check-referral', $course->id) }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ code: code })
        })
        .then(response => response.json())
        .then(data => {
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-check"></i> <span>Terapkan Kode</span>';

            feedback.classList.remove('hidden');

            if (data.valid) {
                feedback.className = 'mt-3 p-3 rounded-xl text-xs font-semibold bg-emerald-950/40 text-emerald-300 border border-emerald-500/40 flex items-center gap-2';
                feedback.innerHTML = `<i class="fas fa-check-circle text-emerald-400"></i> <span>${data.message}</span>`;
                
                // Show breakdown
                breakdown.classList.remove('hidden');
                document.getElementById('summaryDiscount').innerText = '-' + data.formatted_discount;
                document.getElementById('summaryFinalPrice').innerText = data.formatted_final_price;

                // Bind to hidden form input
                formRef.value = data.code;

                // Update purchase button text & style
                if (data.is_free) {
                    purchaseBtn.style.borderColor = 'var(--green)';
                    purchaseBtn.style.color = 'var(--green)';
                    purchaseBtnIcon.className = 'fas fa-gift mr-1 text-emerald-400';
                    purchaseBtnText.innerText = 'Klaim Akses GRATIS Sekarang!';
                } else {
                    purchaseBtn.style.borderColor = 'var(--yellow)';
                    purchaseBtn.style.color = 'var(--yellow)';
                    purchaseBtnIcon.className = 'fas fa-shopping-cart mr-1';
                    purchaseBtnText.innerText = `Bayar & Buka Kursus (${data.formatted_final_price})`;
                }
            } else {
                feedback.className = 'mt-3 p-3 rounded-xl text-xs font-semibold bg-rose-950/40 text-rose-400 border border-rose-500/40 flex items-center gap-2';
                feedback.innerHTML = `<i class="fas fa-times-circle text-rose-400"></i> <span>${data.message}</span>`;
                breakdown.classList.add('hidden');
                formRef.value = '';

                // Reset purchase button
                purchaseBtn.style.borderColor = 'var(--yellow)';
                purchaseBtn.style.color = 'var(--yellow)';
                purchaseBtnIcon.className = 'fas fa-unlock mr-1';
                purchaseBtnText.innerText = 'Beli & Dapatkan Akses (Rp {{ number_format($course->price,0,',','.') }})';
            }
        })
        .catch(err => {
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-check"></i> <span>Terapkan Kode</span>';
            feedback.className = 'mt-3 p-3 rounded-xl text-xs font-semibold bg-rose-950/40 text-rose-400 border border-rose-500/40';
            feedback.innerHTML = 'Terjadi kesalahan saat memeriksa kode referral. Silakan coba lagi.';
            feedback.classList.remove('hidden');
        });
    }
</script>
@endif
@endsection
