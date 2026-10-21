@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 relative z-10">
    <!-- Hero Section -->
    <div class="text-center py-20 mb-12 relative">
        <div class="inline-block px-4 py-1 mb-6 border border-[var(--accent)] rounded-full text-xs font-bold tracking-widest text-[var(--accent)]" style="background: rgba(0,212,255,0.05); font-family: 'Fira Code', monospace;">
            // WELCOME TO THE FUTURE OF LEARNING
        </div>
        <h1 class="text-4xl sm:text-6xl font-bold mb-6 break-words" style="line-height: 1.1;">
            Master the Code.<br>
            <span style="color: var(--accent2);">Shape the Future.</span>
        </h1>
        <p class="text-lg sm:text-xl mb-10 max-w-2xl mx-auto" style="color: var(--text2); font-family: 'Fira Code', monospace;">
            Platform pembelajaran online interaktif untuk mengembangkan skill programming dan design Anda.
        </p>
        
        @guest
            <div class="flex flex-col sm:flex-row justify-center gap-6">
                <a href="{{ route('register') }}" class="btn-primary">
                    Start Learning
                </a>
                <a href="{{ route('login') }}" class="cyber-btn">
                    System Login
                </a>
                <a href="{{ route('bank.login') }}" class="btn-ghost">
                    Bank Access
                </a>
            </div>
        @endguest
        @auth
            @if (auth()->user()->isUser())
                <div class="text-center">
                    <a href="{{ route('user.courses.index') }}" class="btn-primary">
                        [ Explore Courses ]
                    </a>
                </div>
            @endif
        @endauth
    </div>

    <!-- Features Section with SVGs -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-20">
        <div class="cyber-card">
            <div class="card-title text-[var(--accent)] mb-4 flex items-center gap-2 font-bold" style="font-family: 'Fira Code', monospace;">
                <i class="fas fa-code"></i> MATERI BERKUALITAS
            </div>
            <div class="svg-container mb-4 py-6 text-center flex justify-center">
                <svg viewBox="0 0 100 100" class="w-24 h-24 inline-block">
                    <defs>
                        <linearGradient id="grad1" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" style="stop-color:var(--accent);stop-opacity:1" />
                            <stop offset="100%" style="stop-color:var(--accent2);stop-opacity:1" />
                        </linearGradient>
                    </defs>
                    <path d="M50 10 L90 30 L90 70 L50 90 L10 70 L10 30 Z" fill="none" stroke="url(#grad1)" stroke-width="4"/>
                    <circle cx="50" cy="50" r="15" fill="rgba(0,212,255,0.2)" stroke="var(--accent)" stroke-width="2"/>
                </svg>
            </div>
            <p style="color: var(--text2); font-family: 'Fira Code', monospace; font-size: 0.9rem; line-height: 1.6;">
                Akses materi pembelajaran dari para ahli. Disusun secara terstruktur untuk memudahkan pemahaman dari dasar hingga mahir.
            </p>
        </div>

        <div class="cyber-card">
            <div class="card-title text-[var(--accent2)] mb-4 flex items-center gap-2 font-bold" style="font-family: 'Fira Code', monospace;">
                <i class="fas fa-microchip"></i> EVALUASI REAL-TIME
            </div>
            <div class="svg-container mb-4 py-6 text-center flex justify-center">
                <svg viewBox="0 0 100 100" class="w-24 h-24 inline-block">
                    <circle cx="50" cy="50" r="40" fill="none" stroke="rgba(124,58,237,0.3)" stroke-width="4" stroke-dasharray="10 5"/>
                    <circle cx="50" cy="50" r="25" fill="none" stroke="var(--accent2)" stroke-width="3"/>
                    <circle cx="50" cy="50" r="10" fill="var(--accent2)"/>
                    <path d="M50 50 L80 20" stroke="var(--accent2)" stroke-width="2"/>
                </svg>
            </div>
            <p style="color: var(--text2); font-family: 'Fira Code', monospace; font-size: 0.9rem; line-height: 1.6;">
                Uji kemampuan Anda dengan sistem evaluasi cerdas yang memberikan feedback instan pada setiap kode yang Anda tulis.
            </p>
        </div>

        <div class="cyber-card">
            <div class="card-title text-[var(--accent3)] mb-4 flex items-center gap-2 font-bold" style="font-family: 'Fira Code', monospace;">
                <i class="fas fa-bolt"></i> AKSES SUPER CEPAT
            </div>
            <div class="svg-container mb-4 py-6 text-center flex justify-center">
                <svg viewBox="0 0 100 100" class="w-24 h-24 inline-block">
                    <path d="M30 90 L50 50 L20 50 L70 10 L50 50 L80 50 Z" fill="var(--accent3)" opacity="0.8"/>
                    <path d="M30 90 L50 50 L20 50 L70 10 L50 50 L80 50 Z" fill="none" stroke="var(--accent3)" stroke-width="2" transform="translate(4,4)"/>
                </svg>
            </div>
            <p style="color: var(--text2); font-family: 'Fira Code', monospace; font-size: 0.9rem; line-height: 1.6;">
                Platform dirancang untuk kecepatan tinggi dan efisiensi, memastikan pengalaman belajar Anda bebas hambatan.
            </p>
        </div>
    </div>

    <!-- How It Works -->
    <div class="mb-20">
        <h2 class="text-3xl font-bold text-center mb-12" style="font-family: 'Outfit', sans-serif;">System Workflow <span style="color: var(--text3); font-family: 'Fira Code', monospace; font-size: 1rem; vertical-align: middle;">// Execution Path</span></h2>
        
        <div class="cyber-card p-8 md:p-12">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
                <div class="step-list">
                    @foreach ([
                        ['title' => 'INITIALIZE', 'desc' => 'Buat akun dan login ke dalam sistem.'], 
                        ['title' => 'ALLOCATE FUNDS', 'desc' => 'Top up saldo akun Anda via Bank.'], 
                        ['title' => 'SELECT MODULE', 'desc' => 'Pilih kursus terbaik sesuai roadmap Anda.'], 
                        ['title' => 'EXECUTE', 'desc' => 'Mulai belajar dan jalankan tugas pemrograman.']
                    ] as $index => $step)
                        <div class="step">
                            <div class="step-num">0{{ $index + 1 }}</div>
                            <div class="step-content">
                                <div class="step-title" style="color: var(--text); font-family: 'Fira Code', monospace;">{{ $step['title'] }}</div>
                                <div class="step-desc">{{ $step['desc'] }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <div class="svg-container h-full flex items-center justify-center min-h-[300px]">
                    <svg viewBox="0 0 200 200" width="100%" height="100%" style="max-width: 300px;">
                        <defs>
                            <style>
                                @keyframes dash { to { stroke-dashoffset: 0; } }
                                .flow-line { stroke-dasharray: 10; stroke-dashoffset: 100; animation: dash 2s linear infinite; }
                            </style>
                        </defs>
                        <!-- Nodes -->
                        <rect x="20" y="20" width="60" height="40" rx="4" fill="rgba(0,212,255,0.1)" stroke="var(--accent)"/>
                        <text x="50" y="44" fill="var(--accent)" font-size="10" text-anchor="middle">INIT</text>
                        
                        <rect x="120" y="20" width="60" height="40" rx="4" fill="rgba(245,158,11,0.1)" stroke="var(--accent4)"/>
                        <text x="150" y="44" fill="var(--accent4)" font-size="10" text-anchor="middle">FUND</text>
                        
                        <rect x="120" y="140" width="60" height="40" rx="4" fill="rgba(124,58,237,0.1)" stroke="var(--accent2)"/>
                        <text x="150" y="164" fill="var(--accent2)" font-size="10" text-anchor="middle">SELECT</text>
                        
                        <rect x="20" y="140" width="60" height="40" rx="4" fill="rgba(16,185,129,0.1)" stroke="var(--accent3)"/>
                        <text x="50" y="164" fill="var(--accent3)" font-size="10" text-anchor="middle">EXEC</text>
                        
                        <!-- Connecting Lines -->
                        <path d="M80 40 L120 40" fill="none" stroke="var(--text3)" stroke-width="2" class="flow-line"/>
                        <path d="M150 60 L150 140" fill="none" stroke="var(--text3)" stroke-width="2" class="flow-line"/>
                        <path d="M120 160 L80 160" fill="none" stroke="var(--text3)" stroke-width="2" class="flow-line"/>
                        <path d="M50 140 L50 60" fill="none" stroke="var(--accent3)" stroke-width="2" stroke-dasharray="5"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

