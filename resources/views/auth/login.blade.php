@extends('layouts.app')

@section('title', 'Masuk ke Akun — TalentGroup')

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
                Selamat Datang Kembali
            </h1>
            <p class="text-xs text-[var(--text2)] mt-1">
                Masuk untuk mengakses materi kursus dan ruang belajar Anda.
            </p>
        </div>

        <!-- Mode Tabs -->
        <div class="flex gap-1 bg-[var(--bg3)] p-1 rounded-xl border border-[var(--border)] mb-6">
            <a href="{{ route('login') }}" class="flex-1 py-2 text-center text-xs font-bold rounded-lg bg-[var(--blue)] text-white shadow-sm transition">
                <i class="fas fa-sign-in-alt mr-1"></i> Masuk
            </a>
            <a href="{{ route('register') }}" class="flex-1 py-2 text-center text-xs font-bold rounded-lg text-[var(--text2)] hover:text-[var(--blue)] transition">
                <i class="fas fa-user-plus mr-1"></i> Daftar Baru
            </a>
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

        <!-- GOOGLE LOGIN BUTTON -->
        <a href="{{ route('auth.google') }}" class="w-full flex items-center justify-center gap-3 py-3 px-4 rounded-xl border border-[var(--border)] bg-white hover:bg-slate-50 text-[var(--ink)] text-xs font-bold shadow-sm transition">
            <svg class="w-4 h-4" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z" fill="#FBBC05"/>
                <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z" fill="#EA4335"/>
            </svg>
            <span>Lanjutkan dengan Google</span>
        </a>

        <!-- DIVIDER -->
        <div class="flex items-center my-5 text-[10px] uppercase font-bold text-[var(--muted)] tracking-wider">
            <span class="flex-1 border-b border-[var(--border)]"></span>
            <span class="px-3">atau dengan email</span>
            <span class="flex-1 border-b border-[var(--border)]"></span>
        </div>

        <!-- FORM -->
        <form action="{{ route('login.post') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-[var(--muted)] mb-1.5">
                    Email atau Username
                </label>
                <div class="relative flex items-center">
                    <span class="absolute left-3.5 text-slate-400 text-xs pointer-events-none flex items-center justify-center w-5">
                        <i class="fas fa-user"></i>
                    </span>
                    <input
                        type="text"
                        name="login"
                        value="{{ old('login') }}"
                        required
                        autofocus
                        placeholder="nama@email.com / username"
                        class="cyber-input text-xs has-icon-left"
                        style="padding-left: 42px !important;"
                    >
                </div>
                @error('login')
                    <p class="mt-1.5 text-xs text-rose-600 flex items-center gap-1 font-medium">
                        <i class="fas fa-times-circle"></i> {{ $message }}
                    </p>
                @enderror
            </div>

            <div>
                <div class="flex justify-between items-center mb-1.5">
                    <label class="text-xs font-bold uppercase tracking-wider text-[var(--muted)]">
                        Password
                    </label>
                    <a href="{{ route('forgot.password') }}" class="text-xs text-[var(--blue)] font-bold hover:underline">
                        Lupa password?
                    </a>
                </div>
                <div class="relative flex items-center">
                    <span class="absolute left-3.5 text-slate-400 text-xs pointer-events-none flex items-center justify-center w-5">
                        <i class="fas fa-lock"></i>
                    </span>
                    <input
                        type="password"
                        name="password"
                        id="login-password"
                        required
                        placeholder="••••••••"
                        class="cyber-input text-xs has-icon-left has-icon-right"
                        style="padding-left: 42px !important; padding-right: 42px !important;"
                    >
                    <button
                        type="button"
                        onclick="togglePasswordVisibility()"
                        class="absolute right-3.5 text-slate-400 hover:text-[var(--ink)] text-xs flex items-center justify-center w-5 h-5 transition-colors cursor-pointer"
                        aria-label="Toggle password visibility"
                    >
                        <i class="fas fa-eye" id="pwd-icon"></i>
                    </button>
                </div>
                @error('password')
                    <p class="mt-1.5 text-xs text-rose-600 flex items-center gap-1 font-medium">
                        <i class="fas fa-times-circle"></i> {{ $message }}
                    </p>
                @enderror
            </div>

            <div class="flex items-center justify-between pt-1">
                <label class="inline-flex items-center gap-2 text-xs text-[var(--text2)] cursor-pointer">
                    <input type="checkbox" name="remember" value="1" checked class="rounded text-[var(--blue)]">
                    <span>Ingat saya (tetap login selama 1 minggu)</span>
                </label>
            </div>

            <button type="submit" class="btn btn-gradient text-xs w-full py-3 mt-2">
                <i class="fas fa-sign-in-alt mr-1"></i> Masuk ke Akun
            </button>
        </form>

        <div class="text-center mt-6 pt-5 border-t border-[var(--border)] text-xs text-[var(--muted)]">
            Belum punya akun TalentGroup?
            <a href="{{ route('register') }}" class="text-[var(--blue)] font-bold hover:underline ml-1">
                Daftar sekarang gratis
            </a>
        </div>

        <div class="text-center mt-3">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-1.5 text-xs text-[var(--muted)] hover:text-[var(--blue)] font-medium transition">
                <i class="fas fa-arrow-left text-[10px]"></i> Kembali ke Beranda Utama
            </a>
        </div>
    </div>
</div>

<script>
function togglePasswordVisibility() {
    const input = document.getElementById('login-password');
    const icon = document.getElementById('pwd-icon');
    if (input.type === 'password') {
        input.type = 'text';
        icon.className = 'fas fa-eye-slash';
    } else {
        input.type = 'password';
        icon.className = 'fas fa-eye';
    }
}
</script>
@endsection
