@extends('layouts.app')

@section('title', 'Profil Saya — TalentGroup')

@section('content')
<div class="max-w-6xl mx-auto py-8 px-4">
    
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-2xl font-black text-[var(--ink)] flex items-center gap-3">
            <i class="fas fa-user-cog text-[var(--blue)]"></i> Pengaturan Profil Saya
        </h1>
        <p class="text-xs text-[var(--muted)] mt-1 font-mono">Kelola informasi data diri, foto avatar, keamanan akun, dan riwayat transaksi Anda.</p>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 rounded-xl border border-emerald-200 bg-emerald-50 text-emerald-800 text-xs font-semibold flex items-center gap-2">
            <i class="fas fa-check-circle text-base text-emerald-600"></i> {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="mb-6 p-4 rounded-xl border border-rose-200 bg-rose-50 text-rose-800 text-xs font-semibold">
            <div class="flex items-center gap-2 mb-2 font-bold text-rose-700">
                <i class="fas fa-exclamation-triangle text-base"></i> Gagal menyimpan perubahan:
            </div>
            <ul class="list-disc list-inside pl-2 space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Left Column: Avatar Card -->
        <div class="lg:col-span-1 flex flex-col gap-6">
            <div class="bg-white border border-[var(--border)] rounded-2xl p-6 shadow-sm flex flex-col items-center text-center">
                <!-- Avatar Preview -->
                <div class="relative group cursor-pointer mb-4">
                    <img id="avatarPreview" 
                         src="{{ $user->avatar_url }}" 
                         class="w-32 h-32 rounded-full object-cover border-4 border-slate-100 group-hover:border-[var(--blue)] transition-all shadow-sm" 
                         alt="Avatar">
                    <div class="absolute inset-0 rounded-full bg-black/50 opacity-0 group-hover:opacity-100 flex items-center justify-center text-white text-xs transition-opacity" 
                         onclick="document.getElementById('avatarInput').click()">
                        <i class="fas fa-camera text-lg"></i>
                    </div>
                </div>

                <h3 class="font-extrabold text-[var(--ink)] text-base">{{ $user->name }}</h3>
                <span class="text-[10px] uppercase font-mono px-3 py-1 rounded-full border border-blue-200 bg-blue-50 text-[var(--blue)] font-bold mt-2">
                    {{ ucfirst($user->role ? $user->role->name : 'User') }}
                </span>

                <!-- Separator -->
                <div class="w-full border-t border-[var(--border)] my-5"></div>

                <!-- Simple Stats List -->
                <div class="w-full flex flex-col gap-3 font-mono text-[11px] text-left">
                    <div class="flex justify-between items-center py-1">
                        <span class="text-[var(--muted)]">USERNAME</span>
                        <span class="text-[var(--ink)] font-bold">{{ $user->username }}</span>
                    </div>
                    <div class="flex justify-between items-center py-1">
                        <span class="text-[var(--muted)]">PHONE</span>
                        <span class="text-[var(--ink)] font-bold">{{ $user->phone ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between items-center py-1">
                        <span class="text-[var(--muted)]">STATUS</span>
                        <span class="text-emerald-600 font-bold bg-emerald-50 px-2 py-0.5 rounded border border-emerald-200">ACTIVE</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Settings Tabs -->
        <div class="lg:col-span-2 flex flex-col gap-6" x-data="{ tab: 'profile' }">
            <!-- Tabs Menu -->
            <div class="flex border-b border-[var(--border)] gap-2">
                <button @click="tab = 'profile'" 
                        :class="tab === 'profile' ? 'border-[var(--blue)] text-[var(--blue)]' : 'border-transparent text-[var(--muted)] hover:text-[var(--ink)]'" 
                        class="pb-3 px-4 font-bold text-xs uppercase tracking-wider border-b-2 transition-all font-mono">
                    <i class="fas fa-id-card mr-1"></i> Data Diri
                </button>
                <button @click="tab = 'password'" 
                        :class="tab === 'password' ? 'border-[var(--blue)] text-[var(--blue)]' : 'border-transparent text-[var(--muted)] hover:text-[var(--ink)]'" 
                        class="pb-3 px-4 font-bold text-xs uppercase tracking-wider border-b-2 transition-all font-mono">
                    <i class="fas fa-shield-alt mr-1"></i> Keamanan
                </button>
                <button @click="tab = 'transactions'" 
                        :class="tab === 'transactions' ? 'border-[var(--blue)] text-[var(--blue)]' : 'border-transparent text-[var(--muted)] hover:text-[var(--ink)]'" 
                        class="pb-3 px-4 font-bold text-xs uppercase tracking-wider border-b-2 transition-all font-mono">
                    <i class="fas fa-receipt mr-1"></i> Riwayat Transaksi
                </button>
            </div>

            <!-- Tab Content: Profile Info Form -->
            <div x-show="tab === 'profile'" class="bg-white border border-[var(--border)] rounded-2xl p-6 sm:p-8 shadow-sm">
                <h3 class="font-extrabold text-[var(--ink)] text-sm mb-5 uppercase tracking-wider border-b border-[var(--border)] pb-3">Informasi Profil</h3>
                
                <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data" class="flex flex-col gap-5">
                    @csrf
                    
                    <!-- Hidden avatar file input -->
                    <input type="file" id="avatarInput" name="avatar" class="hidden" accept="image/*" 
                           onchange="document.getElementById('avatarPreview').src = URL.createObjectURL(this.files[0])">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="flex flex-col gap-1.5">
                            <label class="text-[11px] uppercase font-bold text-[var(--ink)] flex items-center gap-1.5">
                                <i class="fas fa-user text-[var(--blue)]"></i> Nama Lengkap
                            </label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" required 
                                   class="px-4 py-2.5 bg-slate-50 border border-[var(--border)] rounded-xl text-xs font-semibold text-[var(--ink)] focus:bg-white focus:border-[var(--blue)] focus:outline-none transition">
                        </div>
                        <div class="flex flex-col gap-1.5">
                            <label class="text-[11px] uppercase font-bold text-[var(--ink)] flex items-center gap-1.5">
                                <i class="fas fa-envelope text-[var(--blue)]"></i> Alamat Email
                            </label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" required 
                                   class="px-4 py-2.5 bg-slate-50 border border-[var(--border)] rounded-xl text-xs font-semibold text-[var(--ink)] focus:bg-white focus:border-[var(--blue)] focus:outline-none transition">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="flex flex-col gap-1.5">
                            <label class="text-[11px] uppercase font-bold text-[var(--ink)] flex items-center gap-1.5">
                                <i class="fas fa-at text-[var(--blue)]"></i> Username
                            </label>
                            <input type="text" name="username" value="{{ old('username', $user->username) }}" required 
                                   placeholder="username_anda"
                                   class="px-4 py-2.5 bg-slate-50 border border-[var(--border)] rounded-xl text-xs font-mono font-semibold text-[var(--ink)] focus:bg-white focus:border-[var(--blue)] focus:outline-none transition">
                            <span class="text-[10px] text-[var(--muted)] font-mono">Bisa digunakan untuk login ke akun Anda.</span>
                        </div>
                        <div class="flex flex-col gap-1.5">
                            <label class="text-[11px] uppercase font-bold text-[var(--ink)] flex items-center gap-1.5">
                                <i class="fas fa-phone-alt text-[var(--blue)]"></i> Nomor WhatsApp / HP
                            </label>
                            <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" required 
                                   placeholder="08123456789"
                                   class="px-4 py-2.5 bg-slate-50 border border-[var(--border)] rounded-xl text-xs font-mono font-semibold text-[var(--ink)] focus:bg-white focus:border-[var(--blue)] focus:outline-none transition">
                            <span class="text-[10px] text-[var(--muted)] font-mono">Digunakan untuk verifikasi OTP dan notifikasi belajar.</span>
                        </div>
                    </div>

                    <div class="flex justify-end mt-4 pt-4 border-t border-[var(--border)]">
                        <button type="submit" class="btn-gradient px-6 py-2.5 rounded-xl text-white font-bold text-xs shadow-sm inline-flex items-center gap-2">
                            <i class="fas fa-save"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>

            <!-- Tab Content: Password Form -->
            <div x-show="tab === 'password'" class="bg-white border border-[var(--border)] rounded-2xl p-6 sm:p-8 shadow-sm" style="display: none;">
                <h3 class="font-extrabold text-[var(--ink)] text-sm mb-5 uppercase tracking-wider border-b border-[var(--border)] pb-3">Ubah Kata Sandi</h3>
                
                <form action="{{ route('user.profile.update') }}" method="POST" class="flex flex-col gap-5">
                    @csrf
                    
                    <div class="flex flex-col gap-1.5">
                        <label class="text-[11px] uppercase font-bold text-[var(--ink)]">Kata Sandi Baru</label>
                        <input type="password" name="password" required 
                               class="px-4 py-2.5 bg-slate-50 border border-[var(--border)] rounded-xl text-xs text-[var(--ink)] focus:bg-white focus:border-[var(--blue)] focus:outline-none transition" placeholder="Minimal 8 karakter...">
                    </div>

                    <div class="flex flex-col gap-1.5">
                        <label class="text-[11px] uppercase font-bold text-[var(--ink)]">Konfirmasi Kata Sandi Baru</label>
                        <input type="password" name="password_confirmation" required 
                               class="px-4 py-2.5 bg-slate-50 border border-[var(--border)] rounded-xl text-xs text-[var(--ink)] focus:bg-white focus:border-[var(--blue)] focus:outline-none transition" placeholder="Ketik ulang kata sandi baru...">
                    </div>

                    <!-- Carry user info to bypass validation safely -->
                    <input type="hidden" name="name" value="{{ $user->name }}">
                    <input type="hidden" name="username" value="{{ $user->username }}">
                    <input type="hidden" name="email" value="{{ $user->email }}">
                    <input type="hidden" name="phone" value="{{ $user->phone }}">

                    <div class="flex justify-end mt-4 pt-4 border-t border-[var(--border)]">
                        <button type="submit" class="btn-gradient px-6 py-2.5 rounded-xl text-white font-bold text-xs shadow-sm inline-flex items-center gap-2">
                            <i class="fas fa-key"></i> Perbarui Kata Sandi
                        </button>
                    </div>
                </form>
            </div>

            <!-- Tab Content: Transaction Log -->
            <div x-show="tab === 'transactions'" class="bg-white border border-[var(--border)] rounded-2xl p-6 sm:p-8 shadow-sm" style="display: none;">
                <h3 class="font-extrabold text-[var(--ink)] text-sm mb-5 uppercase tracking-wider border-b border-[var(--border)] pb-3">Histori Transaksi Terakhir</h3>

                @if($transactions->count())
                    <div class="flex flex-col gap-3">
                        @foreach($transactions as $tx)
                            @php
                                $isTopup = $tx->type === 'topup';
                                $amountSign = $isTopup ? '+' : '-';
                                $colorClass = $isTopup ? 'text-emerald-600' : 'text-[var(--blue)]';
                            @endphp
                            <div class="p-4 rounded-xl border border-[var(--border)] bg-slate-50 flex justify-between items-center gap-4 hover:bg-slate-100/60 transition">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl flex items-center justify-center text-lg bg-white border border-[var(--border)] shadow-2xs">
                                        @if($isTopup)
                                            💰
                                        @else
                                            📘
                                        @endif
                                    </div>
                                    <div class="min-w-0">
                                        <div class="text-xs font-bold text-[var(--ink)] truncate">{{ $tx->description ?? ($isTopup ? 'Top Up' : 'Pembelian Kursus') }}</div>
                                        <div class="text-[10px] text-[var(--muted)] mt-0.5 font-mono">{{ $tx->created_at->format('d M Y, H:i') }} • Status: <span class="text-emerald-600 uppercase font-extrabold">{{ $tx->status }}</span></div>
                                    </div>
                                </div>
                                <div class="text-xs font-extrabold font-mono {{ $colorClass }}">
                                    {{ $amountSign }} Rp {{ number_format($tx->amount, 0, ',', '.') }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-4">
                        {{ $transactions->links() }}
                    </div>
                @else
                    <div class="text-center py-12 text-[var(--muted)] font-mono text-xs">
                        <div class="text-3xl mb-3">🧾</div>
                        Belum ada riwayat transaksi yang tercatat.
                    </div>
                @endif
            </div>

        </div>

    </div>
</div>
@endsection
