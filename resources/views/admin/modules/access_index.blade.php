@extends('layouts.app')

@section('title', 'Hak Akses Modul: ' . $module->name)

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8">

    <!-- Header Section -->
    <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4 mb-8">
        <div>
            <div class="flex items-center gap-2 text-xs font-mono text-[var(--accent)] uppercase tracking-wider mb-1">
                <a href="{{ route('admin.modules.index') }}" class="hover:underline">MODULE MANAGER</a>
                <i class="fas fa-chevron-right text-[10px]"></i>
                <span>{{ $module->name }}</span>
                <i class="fas fa-chevron-right text-[10px]"></i>
                <span class="text-white">USER ACCESS</span>
            </div>
            <h1 class="text-2xl md:text-3xl font-extrabold text-white tracking-tight flex items-center gap-3">
                <i class="fas fa-user-lock text-amber-400"></i>
                <span>Akses Pengguna: {{ $module->name }}</span>
            </h1>
            <p class="text-xs text-slate-400 mt-1">
                Kelola izin akses pengguna untuk modul private ini. Tambahkan pengguna secara manual atau lihat pengguna yang membuka via kode referral.
            </p>
        </div>

        <a href="{{ route('admin.modules.index') }}" 
           class="px-4 py-2.5 rounded-xl border border-[var(--border)] bg-slate-900/50 hover:bg-slate-800 text-slate-300 hover:text-white text-xs font-bold transition flex items-center gap-2">
            <i class="fas fa-arrow-left"></i>
            <span>Kembali ke Module Manager</span>
        </a>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 rounded-xl border border-emerald-500/30 bg-emerald-950/20 text-emerald-400 text-sm flex items-center gap-3">
            <i class="fas fa-check-circle text-lg"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Grant Access Card -->
    <div class="cyber-card p-6 mb-8">
        <h3 class="text-sm font-bold text-white mb-2 flex items-center gap-2">
            <i class="fas fa-user-plus text-cyan-400"></i>
            <span>Beri Akses Manual ke Pengguna</span>
        </h3>
        <p class="text-xs text-slate-400 mb-4">
            Pilih akun pengguna yang ingin diberikan izin akses untuk membaca modul private ini.
        </p>

        <form action="{{ route('admin.modules.access.grant', $module->id) }}" method="POST" class="flex flex-col sm:flex-row gap-4 items-end">
            @csrf

            <div class="flex-1 w-full">
                <label class="block text-xs font-bold text-slate-300 mb-1.5">Pilih Pengguna:</label>
                <select name="user_id" required class="cyber-input text-xs">
                    <option value="">-- Pilih Pengguna --</option>
                    @foreach($users as $u)
                        <option value="{{ $u->id }}">{{ $u->name }} ({{ $u->email }})</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="cyber-btn text-xs whitespace-nowrap h-[42px] flex items-center gap-2">
                <i class="fas fa-check"></i>
                <span>Beri Akses</span>
            </button>
        </form>
    </div>

    <!-- Access List Table -->
    <div class="cyber-card overflow-hidden p-0">
        <div class="p-4 bg-black/20 border-b border-[var(--border)] flex items-center justify-between">
            <span class="text-xs font-bold text-white uppercase tracking-wider">
                Daftar Pengguna yang Memiliki Akses ({{ $accessList->total() }})
            </span>
            @if($module->referral_code)
                <span class="text-xs font-mono text-amber-400">
                    <i class="fas fa-key mr-1"></i> Kode Referral Modul: <strong>{{ $module->referral_code }}</strong>
                </span>
            @endif
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm border-collapse">
                <thead class="bg-black/30 text-xs uppercase tracking-wider text-[var(--text2)] border-b border-[var(--border)]">
                    <tr>
                        <th class="px-5 py-4 font-bold">Nama Pengguna</th>
                        <th class="px-5 py-4 font-bold">Email</th>
                        <th class="px-5 py-4 font-bold">Metode Akses</th>
                        <th class="px-5 py-4 font-bold">Kode Referral</th>
                        <th class="px-5 py-4 font-bold">Diberikan Pada</th>
                        <th class="px-5 py-4 font-bold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[var(--border)] text-[var(--text)]">
                    @forelse($accessList as $item)
                        <tr class="hover:bg-slate-800/20 transition">
                            <td class="px-5 py-4 font-bold text-white text-xs">
                                {{ $item->user ? $item->user->name : 'User #' . $item->user_id }}
                            </td>
                            <td class="px-5 py-4 text-xs font-mono text-slate-300">
                                {{ $item->user ? $item->user->email : '-' }}
                            </td>
                            <td class="px-5 py-4">
                                @if($item->access_method === 'admin_manual')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded text-[11px] font-semibold bg-cyan-500/10 text-cyan-400 border border-cyan-500/30">
                                        <i class="fas fa-user-shield text-[10px]"></i> Admin Manual
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded text-[11px] font-semibold bg-amber-500/10 text-amber-400 border border-amber-500/30">
                                        <i class="fas fa-ticket-alt text-[10px]"></i> Kode Referral
                                    </span>
                                @endif
                            </td>
                            <td class="px-5 py-4 text-xs font-mono text-amber-300">
                                {{ $item->referral_code ?: '-' }}
                            </td>
                            <td class="px-5 py-4 text-xs text-slate-400 font-mono">
                                {{ $item->created_at ? $item->created_at->format('M d, Y H:i') : '-' }}
                            </td>
                            <td class="px-5 py-4 text-right">
                                <form action="{{ route('admin.modules.access.revoke', ['module' => $module->id, 'accessId' => $item->id]) }}" method="POST" class="inline"
                                      onsubmit="return confirm('Apakah Anda yakin ingin mencabut akses pengguna ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 rounded-lg bg-slate-800 hover:bg-rose-500/20 text-slate-300 hover:text-rose-400 transition" title="Cabut Akses">
                                        <i class="fas fa-user-slash text-xs"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-10 text-center text-slate-500 text-xs">
                                Belum ada pengguna yang memiliki akses manual atau referral untuk modul ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($accessList->hasPages())
            <div class="p-4 border-t border-[var(--border)]">
                {{ $accessList->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
