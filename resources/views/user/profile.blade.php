@extends('layouts.app')

@section('title', 'Profil Saya — talentgroup.id')

@section('content')
<div class="max-w-6xl mx-auto py-8 px-4">
    
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-2xl font-black text-white flex items-center gap-3">
            <i class="fas fa-user-cog text-[var(--cyan)]"></i> Pengaturan Profil Saya
        </h1>
        <p class="text-xs text-[var(--text2)] mt-1 font-mono">Kelola informasi data diri, foto avatar, keamanan akun, dan riwayat transaksi anda.</p>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 rounded-xl border border-[var(--green)] bg-green-500/10 text-[var(--green)] text-xs font-semibold flex items-center gap-2">
            <i class="fas fa-check-circle text-base"></i> {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="mb-6 p-4 rounded-xl border border-[var(--red)] bg-red-500/10 text-[var(--red)] text-xs font-semibold">
            <div class="flex items-center gap-2 mb-2 font-bold">
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
            <div class="cyber-card flex flex-col items-center text-center p-6 bg-[var(--bg2)] border-[var(--border)]">
                <!-- Avatar Preview -->
                <div class="relative group cursor-pointer mb-4">
                    <img id="avatarPreview" 
                         src="{{ $user->avatar_url }}" 
                         class="w-32 h-32 rounded-full object-cover border-4 border-[var(--border)] group-hover:border-[var(--cyan)] transition-all" 
                         alt="Avatar">
                    <div class="absolute inset-0 rounded-full bg-black/60 opacity-0 group-hover:opacity-100 flex items-center justify-center text-white text-xs transition-opacity" 
                         onclick="document.getElementById('avatarInput').click()">
                        <i class="fas fa-camera text-lg"></i>
                    </div>
                </div>

                <h3 class="font-extrabold text-white text-base">{{ $user->name }}</h3>
                <span class="text-[10px] uppercase font-mono px-2.5 py-1 rounded-full border border-white/10 bg-white/5 text-[var(--text2)] mt-1.5">
                    {{ ucfirst($user->role ? $user->role->name : 'User') }}
                </span>

                <!-- Separator -->
                <div class="w-full border-t border-[var(--border)] my-5"></div>

                <!-- Simple Stats List -->
                <div class="w-full flex flex-col gap-3 font-mono text-[11px] text-left">
                    <div class="flex justify-between">
                        <span class="text-[var(--text3)]">USERNAME</span>
                        <span class="text-[var(--text2)]">{{ $user->username }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-[var(--text3)]">PHONE</span>
                        <span class="text-[var(--text2)]">{{ $user->phone ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-[var(--text3)]">STATUS</span>
                        <span class="text-[var(--cyan)] font-bold">ACTIVE</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Settings Tabs -->
        <div class="lg:col-span-2 flex flex-col gap-6" x-data="{ tab: 'profile' }">
            <!-- Tabs Menu -->
            <div class="flex border-b border-[var(--border)] gap-2">
                <button @click="tab = 'profile'" 
                        :class="tab === 'profile' ? 'border-[var(--cyan)] text-[var(--cyan)]' : 'border-transparent text-[var(--text3)] hover:text-white'" 
                        class="pb-3 px-4 font-bold text-xs uppercase tracking-wider border-b-2 transition-all font-mono">
                    <i class="fas fa-id-card mr-1"></i> Data Diri
                </button>
                <button @click="tab = 'password'" 
                        :class="tab === 'password' ? 'border-[var(--cyan)] text-[var(--cyan)]' : 'border-transparent text-[var(--text3)] hover:text-white'" 
                        class="pb-3 px-4 font-bold text-xs uppercase tracking-wider border-b-2 transition-all font-mono">
                    <i class="fas fa-shield-alt mr-1"></i> Keamanan
                </button>
                <button @click="tab = 'transactions'" 
                        :class="tab === 'transactions' ? 'border-[var(--cyan)] text-[var(--cyan)]' : 'border-transparent text-[var(--text3)] hover:text-white'" 
                        class="pb-3 px-4 font-bold text-xs uppercase tracking-wider border-b-2 transition-all font-mono">
                    <i class="fas fa-receipt mr-1"></i> Riwayat Transaksi
                </button>
            </div>

            <!-- Tab Content: Profile Info Form -->
            <div x-show="tab === 'profile'" class="cyber-card p-6 bg-[var(--bg2)] border-[var(--border)]">
                <h3 class="font-extrabold text-white text-sm mb-5 uppercase tracking-wider border-b border-[var(--border)] pb-2">Informasi Profil</h3>
                
                <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data" class="flex flex-col gap-4">
                    @csrf
                    
                    <!-- Hidden avatar file input -->
                    <input type="file" id="avatarInput" name="avatar" class="hidden" accept="image/*" 
                           onchange="document.getElementById('avatarPreview').src = URL.createObjectURL(this.files[0])">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="flex flex-col gap-1.5">
                            <label class="text-[10px] uppercase font-mono text-[var(--text2)]">Nama Lengkap</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="cyber-input">
                        </div>
                        <div class="flex flex-col gap-1.5">
                            <label class="text-[10px] uppercase font-mono text-[var(--text2)]">Alamat Email</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="cyber-input">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="flex flex-col gap-1.5">
                            <label class="text-[10px] uppercase font-mono text-[var(--text2)]">Username</label>
                            <input type="text" value="{{ $user->username }}" readonly class="cyber-input opacity-60 cursor-not-allowed" title="Username tidak dapat diubah">
                        </div>
                        <div class="flex flex-col gap-1.5">
                            <label class="text-[10px] uppercase font-mono text-[var(--text2)]">Nomor Telepon</label>
                            <input type="text" value="{{ $user->phone ?? '-' }}" readonly class="cyber-input opacity-60 cursor-not-allowed">
                        </div>
                    </div>

                    <div class="flex justify-end mt-4">
                        <button type="submit" class="cyber-btn font-bold px-6 py-2">
                            <i class="fas fa-save mr-2"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>

            <!-- Tab Content: Password Form -->
            <div x-show="tab === 'password'" class="cyber-card p-6 bg-[var(--bg2)] border-[var(--border)]" style="display: none;">
                <h3 class="font-extrabold text-white text-sm mb-5 uppercase tracking-wider border-b border-[var(--border)] pb-2">Ubah Kata Sandi</h3>
                
                <form action="{{ route('user.profile.update') }}" method="POST" class="flex flex-col gap-4">
                    @csrf
                    
                    <div class="flex flex-col gap-1.5">
                        <label class="text-[10px] uppercase font-mono text-[var(--text2)]">Kata Sandi Baru</label>
                        <input type="password" name="password" required class="cyber-input" placeholder="Minimal 8 karakter...">
                    </div>

                    <div class="flex flex-col gap-1.5">
                        <label class="text-[10px] uppercase font-mono text-[var(--text2)]">Konfirmasi Kata Sandi Baru</label>
                        <input type="password" name="password_confirmation" required class="cyber-input" placeholder="Ketik ulang kata sandi baru...">
                    </div>

                    <!-- Carry name & email to bypass validation -->
                    <input type="hidden" name="name" value="{{ $user->name }}">
                    <input type="hidden" name="email" value="{{ $user->email }}">

                    <div class="flex justify-end mt-4">
                        <button type="submit" class="cyber-btn font-bold px-6 py-2" style="background: linear-gradient(135deg, var(--php), var(--php2))">
                            <i class="fas fa-key mr-2"></i> Perbarui Kata Sandi
                        </button>
                    </div>
                </form>
            </div>

            <!-- Tab Content: Transaction Log -->
            <div x-show="tab === 'transactions'" class="cyber-card p-6 bg-[var(--bg2)] border-[var(--border)]" style="display: none;">
                <h3 class="font-extrabold text-white text-sm mb-5 uppercase tracking-wider border-b border-[var(--border)] pb-2">Histori Transaksi Terakhir</h3>

                @if($transactions->count())
                    <div class="flex flex-col gap-3">
                        @foreach($transactions as $tx)
                            @php
                                $isTopup = $tx->type === 'topup';
                                $amountSign = $isTopup ? '+' : '-';
                                $colorClass = $isTopup ? 'text-[var(--green)]' : 'text-[var(--red)]';
                            @endphp
                            <div class="p-4 rounded-xl border border-white/5 bg-black/10 flex justify-between items-center gap-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg flex items-center justify-center text-sm bg-white/5">
                                        @if($isTopup)
                                            💰
                                        @else
                                            📘
                                        @endif
                                    </div>
                                    <div class="min-w-0">
                                        <div class="text-xs font-bold text-white truncate">{{ $tx->description ?? ($isTopup ? 'Top Up Kredit Saldo' : 'Pembelian Kursus') }}</div>
                                        <div class="text-[9px] text-[var(--text3)] mt-0.5 font-mono">{{ $tx->created_at->format('d M Y, H:i') }} • Status: <span class="text-[var(--green)] uppercase font-extrabold">{{ $tx->status }}</span></div>
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
                    <div class="text-center py-12 text-[var(--text3)] font-mono text-xs">
                        <div class="text-3xl mb-3">🧾</div>
                        Belum ada riwayat transaksi yang tercatat.
                    </div>
                @endif
            </div>

        </div>

    </div>
</div>
@endsection
