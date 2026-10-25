@extends('layouts.app')

@section('title', 'Login Admin | TalentGroup')

@section('content')
<div class="min-h-[75vh] flex items-center justify-center px-4 py-12">
    <div class="max-w-md w-full bg-white border border-[var(--border)] rounded-2xl p-8 shadow-sm">
        
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="w-14 h-14 rounded-2xl bg-blue-50 border border-blue-200 text-[var(--blue)] flex items-center justify-center mx-auto mb-4 text-2xl shadow-xs">
                <i class="fas fa-shield-alt"></i>
            </div>
            <div class="text-[10px] font-mono font-bold uppercase tracking-wider text-[var(--blue)] mb-1">
                Security Gateway
            </div>
            <h2 class="text-2xl font-black text-[var(--ink)] tracking-tight">Admin Portal</h2>
            <p class="text-xs text-[var(--muted)] mt-1">Masuk dengan kredensial administrator sistem</p>
        </div>

        <!-- Success & Error Alert -->
        @if(session('success'))
            <div class="mb-6 p-4 rounded-xl border border-emerald-200 bg-emerald-50 text-emerald-800 text-xs flex items-center gap-3">
                <i class="fas fa-check-circle text-emerald-600 text-base"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 p-4 rounded-xl border border-rose-200 bg-rose-50 text-rose-800 text-xs flex items-center gap-3">
                <i class="fas fa-exclamation-triangle text-rose-600 text-base"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <!-- Form -->
        <form action="{{ route('login.admin') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-[var(--ink)] mb-2">Username / Email</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-[var(--muted)] text-xs">
                        <i class="fas fa-user-shield"></i>
                    </span>
                    <input type="text"
                           name="login"
                           value="{{ old('login') }}"
                           required
                           autofocus
                           placeholder="admin@talentgroup.id"
                           class="w-full pl-9 pr-4 py-2.5 bg-slate-50 border border-[var(--border)] rounded-xl text-xs font-semibold text-[var(--ink)] focus:bg-white focus:border-[var(--blue)] focus:outline-none transition has-icon-left @error('login') border-rose-500 @enderror"
                           style="padding-left: 42px !important;">
                </div>
                @error('login')
                    <p class="text-xs text-rose-600 font-medium mt-1.5">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-[var(--ink)] mb-2">Password</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-[var(--muted)] text-xs">
                        <i class="fas fa-lock"></i>
                    </span>
                    <input type="password"
                           name="password"
                           required
                           placeholder="••••••••"
                           class="w-full pl-9 pr-4 py-2.5 bg-slate-50 border border-[var(--border)] rounded-xl text-xs text-[var(--ink)] focus:bg-white focus:border-[var(--blue)] focus:outline-none transition has-icon-left @error('password') border-rose-500 @enderror"
                           style="padding-left: 42px !important;">
                </div>
                @error('password')
                    <p class="text-xs text-rose-600 font-medium mt-1.5">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-between pt-1 mb-2">
                <label class="inline-flex items-center gap-2 text-xs text-slate-400 cursor-pointer">
                    <input type="checkbox" name="remember" value="1" checked class="rounded text-[var(--blue)] accent-[var(--blue)]">
                    <span>Ingat sesi admin (tetap login 1 minggu)</span>
                </label>
            </div>

            <button type="submit" class="btn-gradient w-full py-3 rounded-xl text-white font-bold text-xs uppercase tracking-wider shadow-sm flex items-center justify-center gap-2">
                <i class="fas fa-sign-in-alt"></i>
                <span>Masuk Administrator</span>
            </button>
        </form>

        <!-- Switch to User Login -->
        <div class="mt-6 pt-5 border-t border-[var(--border)] text-center">
            <a href="{{ route('login.user') }}" class="text-xs text-[var(--blue)] hover:underline font-bold inline-flex items-center gap-1.5">
                <i class="fas fa-arrow-left text-[10px]"></i>
                <span>Kembali ke Login User</span>
            </a>
        </div>

    </div>
</div>
@endsection
