@extends('layouts.app')

@section('title', 'Register — talentgroup.id')

@section('content')

<style>
/* ================= CYBER REGISTER ================= */
.cyber-login-wrapper {
    max-width: 420px;
    margin: 80px auto;
    position: relative;
    padding: 0 16px;
}

/* Glowing orb effect behind the login card */
.cyber-login-wrapper::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 300px;
    height: 300px;
    background: radial-gradient(circle, rgba(6,182,212,0.15) 0%, transparent 70%);
    z-index: -1;
    border-radius: 50%;
    filter: blur(20px);
}

.modal-tabs2 {
    display: flex; gap: 0;
    background: var(--bg3);
    border-radius: 10px; padding: 4px; margin-bottom: 28px;
}
.mtab {
    flex: 1; padding: 8px; border-radius: 7px;
    background: none; border: none; text-align: center;
    font-size: 13px; font-weight: 700; color: var(--text3);
    cursor: pointer; font-family: inherit; transition: all 0.2s;
    text-decoration: none; display: block;
}
.mtab.active {
    background: var(--surface2); color: var(--text);
    box-shadow: 0 2px 8px rgba(0,0,0,0.3);
}

.form-group { margin-bottom: 16px; }
.form-group label {
    display: block; font-size: 11.5px; font-weight: 700;
    color: var(--text2); margin-bottom: 6px; letter-spacing: 0.3px;
}
</style>

<div class="cyber-login-wrapper">

    <div class="cyber-card" style="padding: 36px;">
        
        <div class="modal-tabs2">
            <a href="{{ route('login') }}" class="mtab">Masuk</a>
            <a href="{{ route('register') }}" class="mtab active">Daftar Baru</a>
        </div>

        <h2 style="font-size:22px;font-weight:800;margin-bottom:6px;">Mulai Petualanganmu</h2>
        <p style="font-size:13px;color:var(--text2);margin-bottom:20px;">Bergabung dengan 10K+ pelajar lainnya sekarang.</p>

        <!-- GOOGLE SIGNUP BUTTON -->
        <a href="{{ route('auth.google') }}" style="width:100%;display:flex;align-items:center;justify-content:center;gap:12px;padding:12px 16px;border-radius:12px;background:#ffffff;color:#1f2937;font-size:13px;font-weight:700;text-decoration:none;border:1px solid #e5e7eb;box-shadow:0 2px 8px rgba(0,0,0,0.15);transition:all 0.2s ease;margin-bottom:18px;">
            <svg class="w-5 h-5" viewBox="0 0 24 24" width="18" height="18" xmlns="http://www.w3.org/2000/svg">
                <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z" fill="#FBBC05"/>
                <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z" fill="#EA4335"/>
            </svg>
            <span>Daftar Cepat dengan Google</span>
        </a>

        <div style="display:flex;align-items:center;text-align:center;margin:18px 0;color:var(--text3);font-size:10px;font-weight:700;letter-spacing:1px;text-transform:uppercase;">
            <span style="flex:1;border-bottom:1px solid var(--border);"></span>
            <span style="padding:0 10px;">atau form manual</span>
            <span style="flex:1;border-bottom:1px solid var(--border);"></span>
        </div>

        <!-- ALERTS -->
        @if(session('success'))
            <div style="margin-bottom:24px;padding:12px;border-radius:8px;background:rgba(16,185,129,0.1);border:1px solid rgba(16,185,129,0.3);color:var(--green);font-size:12px;display:flex;align-items:center;gap:8px;">
                <i class="fas fa-check-circle"></i>
                <div>{{ session('success') }}</div>
            </div>
        @endif

        @if(session('error'))
            <div style="margin-bottom:24px;padding:12px;border-radius:8px;background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.3);color:var(--red);font-size:12px;display:flex;align-items:center;gap:8px;">
                <i class="fas fa-exclamation-triangle"></i>
                <div>{{ session('error') }}</div>
            </div>
        @endif

        <!-- FORM -->
        <form action="{{ route('register') }}" method="POST">
            @csrf

            <div class="form-group">
                <label>Nama Lengkap</label>
                <input
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    required
                    autofocus
                    placeholder="John Doe"
                    class="cyber-input"
                    style="border-color: {{ $errors->has('name') ? 'var(--red)' : 'var(--border)' }};"
                >
                @error('name')
                    <p style="margin-top:8px;font-size:11px;color:var(--red);"><i class="fas fa-times"></i> {{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label>Username</label>
                <input
                    type="text"
                    name="username"
                    value="{{ old('username') }}"
                    required
                    placeholder="johndoe123"
                    class="cyber-input"
                    style="border-color: {{ $errors->has('username') ? 'var(--red)' : 'var(--border)' }};"
                >
                @error('username')
                    <p style="margin-top:8px;font-size:11px;color:var(--red);"><i class="fas fa-times"></i> {{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label>Nomor Telepon</label>
                <input
                    type="text"
                    name="phone"
                    value="{{ old('phone') }}"
                    required
                    placeholder="0812xxxxxx"
                    class="cyber-input"
                    style="border-color: {{ $errors->has('phone') ? 'var(--red)' : 'var(--border)' }};"
                >
                @error('phone')
                    <p style="margin-top:8px;font-size:11px;color:var(--red);"><i class="fas fa-times"></i> {{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label>Email</label>
                <input
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    placeholder="john@example.com"
                    class="cyber-input"
                    style="border-color: {{ $errors->has('email') ? 'var(--red)' : 'var(--border)' }};"
                >
                @error('email')
                    <p style="margin-top:8px;font-size:11px;color:var(--red);"><i class="fas fa-times"></i> {{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label>Metode Verifikasi</label>
                <select
                    name="verification_method"
                    required
                    class="cyber-input"
                    style="border-color: var(--border);"
                >
                    <option value="email">EMAIL (Gmail)</option>
                    <option value="whatsapp">WHATSAPP</option>
                </select>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input
                    type="password"
                    name="password"
                    required
                    placeholder="Minimal 8 karakter"
                    class="cyber-input"
                    style="border-color: {{ $errors->has('password') ? 'var(--red)' : 'var(--border)' }};"
                >
                @error('password')
                    <p style="margin-top:8px;font-size:11px;color:var(--red);"><i class="fas fa-times"></i> {{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label>Konfirmasi Password</label>
                <input
                    type="password"
                    name="password_confirmation"
                    required
                    placeholder="Minimal 8 karakter"
                    class="cyber-input"
                    style="border-color: var(--border);"
                >
            </div>

            <button type="submit" class="btn-primary" style="width:100%;padding:12px;font-size:14px;display:block;text-align:center;margin-top:8px;">
                Buat Akun Gratis
            </button>
        </form>

        <div style="text-align:center;margin-top:18px;font-size:12.5px;color:var(--text3);">
            Sudah punya akun? <a href="{{ route('login') }}" style="color:var(--cyan);font-weight:700;text-decoration:none;">Masuk sekarang</a>
        </div>

    </div>
</div>

@endsection
