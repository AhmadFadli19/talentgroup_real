@extends('layouts.app')

@section('title', 'Daftar Akun Baru — TalentGroup')

@section('content')

<div class="max-w-md mx-auto my-8 sm:my-12 px-4">
    <!-- Tombol Back / Navigasi Kembali -->
    <div class="mb-4 flex items-center justify-between">
        <a href="{{ route('home') }}" onclick="if(document.referrer && document.referrer.indexOf(window.location.host) !== -1){ history.back(); return false; }" class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl border border-[var(--border)] bg-white hover:bg-[var(--blue-light)] text-[var(--ink)] hover:text-[var(--blue)] text-xs font-bold shadow-sm transition">
            <i class="fas fa-arrow-left text-[var(--blue)]"></i>
            <span>Kembali</span>
        </a>
        <a href="{{ route('home') }}" class="text-xs font-bold text-[var(--muted)] hover:text-[var(--blue)] transition inline-flex items-center gap-1.5">
            <i class="fas fa-home text-[11px]"></i> Beranda
        </a>
    </div>

    <div class="cyber-card p-8 sm:p-10 bg-white border border-[var(--border)] shadow-sm rounded-2xl">
        
        <!-- Logo Branding Header -->
        <div class="text-center mb-6">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 mb-2">
                <img src="{{ asset('tg/assets/60-2-img-logo.png') }}" class="w-10 h-10 object-contain" alt="TalentGroup">
                <span class="text-xl font-extrabold text-[var(--blue)] tracking-tight">TalentGroup</span>
            </a>
            <h1 class="text-xl font-extrabold text-[var(--ink)] tracking-tight">
                Mulai Petualangan Coding
            </h1>
            <p class="text-xs text-[var(--text2)] mt-1">
                Bergabung dengan 10K+ talenta digital di seluruh Indonesia.
            </p>
        </div>

        <!-- Mode Tabs -->
        <div class="flex gap-1 bg-[var(--bg3)] p-1 rounded-xl border border-[var(--border)] mb-6">
            <a href="{{ route('login') }}" class="flex-1 py-2 text-center text-xs font-bold rounded-lg text-[var(--text2)] hover:text-[var(--blue)] transition">
                <i class="fas fa-sign-in-alt mr-1"></i> Masuk
            </a>
            <a href="{{ route('register') }}" class="flex-1 py-2 text-center text-xs font-bold rounded-lg bg-[var(--blue)] text-white shadow-sm transition">
                <i class="fas fa-user-plus mr-1"></i> Daftar Baru
            </a>
        </div>

        <!-- GOOGLE SIGNUP BUTTON -->
        <a href="{{ route('auth.google') }}" class="w-full flex items-center justify-center gap-3 py-3 px-4 rounded-xl border border-[var(--border)] bg-white hover:bg-slate-50 text-[var(--ink)] text-xs font-bold shadow-sm transition mb-5">
            <svg class="w-4 h-4" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z" fill="#FBBC05"/>
                <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z" fill="#EA4335"/>
            </svg>
            <span>Daftar Cepat dengan Google</span>
        </a>

        <!-- DIVIDER -->
        <div class="flex items-center my-5 text-[10px] uppercase font-bold text-[var(--muted)] tracking-wider">
            <span class="flex-1 border-b border-[var(--border)]"></span>
            <span class="px-3">atau form manual</span>
            <span class="flex-1 border-b border-[var(--border)]"></span>
        </div>

        <!-- ALERTS -->
        @if(session('success'))
            <div class="mb-5 p-3.5 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs flex items-center gap-2.5">
                <i class="fas fa-check-circle text-emerald-600 text-sm"></i>
                <div class="font-medium">{{ session('success') }}</div>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-5 p-3.5 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-xs flex items-center gap-2.5">
                <i class="fas fa-exclamation-triangle text-rose-600 text-sm"></i>
                <div class="font-medium">{{ session('error') }}</div>
            </div>
        @endif

        <!-- FORM -->
        <form action="{{ route('register') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-[var(--muted)] mb-1.5">
                    Nama Lengkap
                </label>
                <input
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    required
                    autofocus
                    placeholder="Nama Lengkap Anda"
                    class="cyber-input text-xs"
                >
                @error('name')
                    <p class="mt-1 text-xs text-rose-600 font-medium"><i class="fas fa-times-circle"></i> {{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-[var(--muted)] mb-1.5">
                    Username
                </label>
                <input
                    type="text"
                    name="username"
                    value="{{ old('username') }}"
                    required
                    placeholder="username123"
                    class="cyber-input text-xs"
                >
                @error('username')
                    <p class="mt-1 text-xs text-rose-600 font-medium"><i class="fas fa-times-circle"></i> {{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-[var(--muted)] mb-1.5">
                    Nomor WhatsApp / HP
                </label>
                <input
                    type="text"
                    name="phone"
                    value="{{ old('phone') }}"
                    required
                    placeholder="08123456789"
                    class="cyber-input text-xs"
                >
                @error('phone')
                    <p class="mt-1 text-xs text-rose-600 font-medium"><i class="fas fa-times-circle"></i> {{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-[var(--muted)] mb-1.5">
                    Alamat Email
                </label>
                <input
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    placeholder="nama@email.com"
                    class="cyber-input text-xs"
                >
                @error('email')
                    <p class="mt-1 text-xs text-rose-600 font-medium"><i class="fas fa-times-circle"></i> {{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-[var(--muted)] mb-1.5">
                    Metode Verifikasi Kode
                </label>
                <select name="verification_method" required class="cyber-input text-xs">
                    <option value="email">Email (Google / Gmail)</option>
                    <option value="whatsapp">WhatsApp</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-[var(--muted)] mb-1.5">
                    Password
                </label>
                <input
                    type="password"
                    name="password"
                    required
                    placeholder="Minimal 8 karakter"
                    class="cyber-input text-xs"
                >
                @error('password')
                    <p class="mt-1 text-xs text-rose-600 font-medium"><i class="fas fa-times-circle"></i> {{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-[var(--muted)] mb-1.5">
                    Konfirmasi Password
                </label>
                <input
                    type="password"
                    name="password_confirmation"
                    required
                    placeholder="Ulangi password"
                    class="cyber-input text-xs"
                >
            </div>

            <button type="submit" class="btn btn-gradient text-xs w-full py-3 mt-2">
                <i class="fas fa-user-check mr-1"></i> Buat Akun TalentGroup Gratis
            </button>
        </form>

        <div class="text-center mt-6 pt-5 border-t border-[var(--border)] text-xs text-[var(--muted)]">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="text-[var(--blue)] font-bold hover:underline ml-1">
                Masuk sekarang
            </a>
        </div>

        <div class="text-center mt-3">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-1.5 text-xs text-[var(--muted)] hover:text-[var(--blue)] font-medium transition">
                <i class="fas fa-arrow-left text-[10px]"></i> Kembali ke Beranda Utama
            </a>
        </div>

    </div>
</div>

@endsection
