@extends('modules.layout')

@section('title', 'Dokumentasi Modul')

@section('content')
    <div class="py-16 text-center max-w-lg mx-auto">
        <div class="w-16 h-16 rounded-2xl bg-[var(--blue-light)] border border-[color:var(--blue)] text-[color:var(--blue)] flex items-center justify-center mx-auto mb-6 text-2xl shadow-xl shadow-[var(--card-shadow)]">
            <i class="fas fa-book-open"></i>
        </div>
        <h1 class="text-2xl font-bold text-[color:var(--ink)] mb-3">Selamat Datang di Modul Belajar</h1>
        <p class="text-[color:var(--muted)] text-sm leading-relaxed mb-8">
            Belum ada modul yang dipublikasikan saat ini. Silakan kembali lagi nanti atau login sebagai admin untuk membuat modul baru.
        </p>

        @auth
            @if(auth()->user()->isAdmin())
                <a href="{{ route('admin.modules.create') }}" 
                   class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-gradient-to-r from-[var(--blue)] to-[var(--blue-dark)] hover:from-[var(--blue)] hover:to-[var(--blue-dark)] text-white font-bold text-sm shadow-lg shadow-[var(--card-shadow)] transition transform hover:-translate-y-0.5">
                    <i class="fas fa-plus"></i>
                    <span>Buat Modul Pertama</span>
                </a>
            @endif
        @endauth
    </div>
@endsection
