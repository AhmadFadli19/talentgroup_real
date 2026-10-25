@extends('layouts.app')

@section('title', $course->title)

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 py-6">

    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('user.courses.index') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-white hover:bg-slate-50 text-[var(--ink)] border border-[var(--border)] text-xs font-bold transition shadow-sm">
            <i class="fas fa-arrow-left text-[var(--blue)]"></i>
            <span>Kembali ke Katalog Kursus</span>
        </a>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 rounded-xl border border-emerald-500/30 bg-emerald-50 text-emerald-800 text-sm flex items-center gap-3 shadow-sm">
            <i class="fas fa-check-circle text-lg text-emerald-600"></i>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 p-4 rounded-xl border border-rose-500/30 bg-rose-50 text-rose-800 text-sm flex items-center gap-3 shadow-sm">
            <i class="fas fa-exclamation-triangle text-lg text-rose-600"></i>
            <span class="font-medium">{{ session('error') }}</span>
        </div>
    @endif

    <div class="cyber-card flex flex-col p-6 sm:p-8 bg-white border border-[var(--border)] shadow-sm">
        
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-6 mb-8">
            <div class="flex items-start gap-5 flex-1">
                <div class="w-24 h-24 rounded-2xl border border-[var(--border)] overflow-hidden flex-shrink-0 bg-slate-100 shadow-sm flex items-center justify-center">
                    @if($course->image)
                        <img src="{{ $course->image_url }}" class="w-full h-full object-cover" alt="{{ $course->title }}" onerror="this.src='{{ asset('tg/assets/60-2-img-ssda.png') }}'">
                    @else
                        <img src="{{ asset('tg/assets/60-2-img-ssda.png') }}" class="w-full h-full object-cover" alt="{{ $course->title }}">
                    @endif
                </div>
                <div>
                    <span class="pill blue-soft text-[10px] mb-2 uppercase tracking-wider">
                        Course Detail
                    </span>
                    <h1 class="text-2xl sm:text-3xl font-extrabold text-[var(--ink)] tracking-tight mb-2">
                        {{ $course->title }}
                    </h1>
                    <p class="text-xs sm:text-sm text-[var(--text2)] leading-relaxed max-w-xl">
                        {{ $course->description }}
                    </p>

                    <div class="flex flex-wrap items-center gap-3 mt-4 text-xs font-semibold text-[var(--muted)]">
                        <span class="px-2.5 py-1 rounded-lg bg-[var(--bg3)] border border-[var(--border)] inline-flex items-center gap-1.5">
                            <i class="fas fa-book-open text-[var(--blue)]"></i> {{ $totalContents }} Materi
                        </span>
                        <span class="px-2.5 py-1 rounded-lg bg-[var(--bg3)] border border-[var(--border)] inline-flex items-center gap-1.5">
                            <i class="fas fa-users text-[var(--blue)]"></i> {{ $enrolledCount }} Peserta Terdaftar
                        </span>
                        <span class="px-2.5 py-1 rounded-lg bg-[var(--bg3)] border border-[var(--border)] inline-flex items-center gap-1.5">
                            <i class="fas fa-layer-group text-[var(--blue)]"></i> {{ ucfirst($course->level ?? 'Semua Level') }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Price Card Box -->
            <div class="bg-[var(--bg3)] p-5 rounded-2xl border border-[var(--border)] text-left md:text-right min-w-[200px]">
                <p class="text-[11px] uppercase tracking-wider font-bold text-[var(--muted)] mb-1">Biaya Akses</p>
                <p id="displayPrice" class="text-2xl font-black font-mono {{ $course->price > 0 ? 'text-[var(--blue-dark)]' : 'text-emerald-600' }}">
                    {{ $course->price > 0 ? 'Rp ' . number_format($course->price,0,',','.') : 'GRATIS' }}
                </p>
                @if($course->price > 0 && !$isEnrolled)
                    <p class="text-xs text-[var(--muted)] mt-1">Saldo Anda: <strong class="text-[var(--ink)]">Rp {{ number_format(auth()->user()->balance, 0, ',', '.') }}</strong></p>
                @endif
            </div>
        </div>

        @if (!$isEnrolled && $course->price > 0)
            <!-- REFERRAL CODE & DISCOUNT PROMO SECTION -->
            <div class="mb-8 p-6 rounded-2xl bg-[var(--blue-light)]/40 border border-[#bfdbfe]">
                <div class="flex items-center gap-2 mb-2">
                    <i class="fas fa-ticket-alt text-[var(--blue)] text-base"></i>
                    <h2 class="text-xs font-bold uppercase tracking-wider text-[var(--blue-dark)]">Punya Kode Referral / Kupon Diskon?</h2>
                </div>

                <p class="text-xs text-[var(--text2)] mb-4 leading-relaxed">
                    Masukkan kode voucher untuk mendapatkan diskon khusus atau membuka akses materi secara <strong class="text-emerald-700 font-bold">100% GRATIS</strong>.
                </p>

                <div class="flex flex-col sm:flex-row gap-3">
                    <div class="relative flex-1">
                        <input type="text" 
                               id="referralInput" 
                               placeholder="Contoh: DISKON50, GRATIS100"
                               class="cyber-input uppercase font-mono tracking-wider text-xs pl-9 bg-white">
                        <i class="fas fa-tag absolute left-3 top-3.5 text-slate-400 text-xs"></i>
                    </div>

                    <button type="button" 
                            id="btnApplyReferral"
                            onclick="applyReferralCode()" 
                            class="btn btn-gradient text-xs">
                        <i class="fas fa-check"></i>
                        <span>Terapkan Kode</span>
                    </button>
                </div>

                <!-- AJAX Feedback Box -->
                <div id="referralFeedback" class="hidden mt-3 p-3 rounded-xl text-xs font-semibold"></div>

                <!-- Price Breakdown Details (Hidden by default until code applied) -->
                <div id="priceBreakdown" class="hidden mt-4 pt-4 border-t border-[#bfdbfe] space-y-1.5 text-xs font-mono">
                    <div class="flex justify-between text-[var(--muted)]">
                        <span>Harga Normal:</span>
                        <span>Rp {{ number_format($course->price, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-emerald-700 font-bold">
                        <span>Potongan Kode:</span>
                        <span id="summaryDiscount">-Rp 0</span>
                    </div>
                    <div class="flex justify-between text-[var(--ink)] font-bold pt-2 border-t border-[#bfdbfe] text-sm">
                        <span>Total Pembayaran:</span>
                        <span id="summaryFinalPrice" class="text-[var(--blue)]">Rp 0</span>
                    </div>
                </div>
            </div>
        @endif

        <!-- Action Bottom Bar -->
        <div class="border-t border-[var(--border)] pt-6 flex flex-col sm:flex-row gap-4 items-center justify-between">
            <div>
                <a href="{{ route('user.courses.index') }}" class="text-xs font-bold text-[var(--muted)] hover:text-[var(--blue)] transition flex items-center gap-1.5">
                    <i class="fas fa-chevron-left text-[10px]"></i>
                    <span>Kembali ke Katalog</span>
                </a>
            </div>
            
            <div class="flex items-center gap-3 w-full sm:w-auto">
                @if ($isEnrolled)
                    <a href="{{ route('user.courses.learn', $course->id) }}" class="btn btn-gradient w-full sm:w-auto text-center">
                        <i class="fas fa-play mr-2"></i> Lanjutkan Belajar
                    </a>
                @else
                    <form method="POST" action="{{ route('user.courses.purchase', $course->id) }}" class="m-0 w-full sm:w-auto" id="purchaseCourseForm">
                        @csrf
                        <input type="hidden" name="referral_code" id="formReferralCode" value="">
                        
                        <button type="submit" 
                                id="purchaseSubmitBtn"
                                class="btn btn-gradient w-full sm:w-auto flex items-center justify-center gap-2">
                            <i class="fas fa-unlock mr-1" id="purchaseBtnIcon"></i> 
                            <span id="purchaseBtnText">
                                {{ $course->price > 0 ? 'Beli & Akses Kursus (Rp ' . number_format($course->price,0,',','.') . ')' : 'Mulai Belajar Sekarang (Gratis)' }}
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
            feedback.className = 'mt-3 p-3 rounded-xl text-xs font-semibold bg-rose-50 text-rose-800 border border-rose-200 flex items-center gap-2';
            feedback.innerHTML = '<i class="fas fa-exclamation-circle text-rose-600"></i> <span>Silakan ketikkan kode referral terlebih dahulu.</span>';
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
                feedback.className = 'mt-3 p-3 rounded-xl text-xs font-semibold bg-emerald-50 text-emerald-800 border border-emerald-200 flex items-center gap-2';
                feedback.innerHTML = `<i class="fas fa-check-circle text-emerald-600"></i> <span>${data.message}</span>`;
                
                // Show breakdown
                breakdown.classList.remove('hidden');
                document.getElementById('summaryDiscount').innerText = '-' + data.formatted_discount;
                document.getElementById('summaryFinalPrice').innerText = data.formatted_final_price;

                // Bind to hidden form input
                formRef.value = data.code;

                // Update purchase button text & style
                if (data.is_free) {
                    purchaseBtnIcon.className = 'fas fa-gift mr-1 text-emerald-300';
                    purchaseBtnText.innerText = 'Klaim Akses GRATIS Sekarang!';
                } else {
                    purchaseBtnIcon.className = 'fas fa-shopping-cart mr-1';
                    purchaseBtnText.innerText = `Bayar & Buka Kursus (${data.formatted_final_price})`;
                }
            } else {
                feedback.className = 'mt-3 p-3 rounded-xl text-xs font-semibold bg-rose-50 text-rose-800 border border-rose-200 flex items-center gap-2';
                feedback.innerHTML = `<i class="fas fa-times-circle text-rose-600"></i> <span>${data.message}</span>`;
                breakdown.classList.add('hidden');
                formRef.value = '';

                // Reset purchase button
                purchaseBtnIcon.className = 'fas fa-unlock mr-1';
                purchaseBtnText.innerText = 'Beli & Dapatkan Akses (Rp {{ number_format($course->price,0,',','.') }})';
            }
        })
        .catch(err => {
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-check"></i> <span>Terapkan Kode</span>';
            feedback.className = 'mt-3 p-3 rounded-xl text-xs font-semibold bg-rose-50 text-rose-800 border border-rose-200';
            feedback.innerHTML = 'Terjadi kesalahan saat memeriksa kode referral. Silakan coba lagi.';
            feedback.classList.remove('hidden');
        });
    }
</script>
@endif
@endsection
