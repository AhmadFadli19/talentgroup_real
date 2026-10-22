@extends('layouts.app')

@section('title', 'Transaction Logs')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-8">

    <!-- HEADER -->
    <div class="cyber-card mb-8 relative overflow-hidden" style="border-color: var(--accent);">
        <div class="absolute inset-0 opacity-10" style="background: repeating-linear-gradient(45deg, transparent, transparent 10px, var(--accent) 10px, var(--accent) 20px);"></div>
        
        <div class="relative z-10 flex flex-col sm:flex-row items-center justify-between gap-6">
            <div class="flex items-center gap-4">
                <div class="text-4xl">📜</div>
                <div>
                    <h1 class="text-2xl font-bold mb-1" style="color: var(--text); font-family: 'Outfit', sans-serif;">Transaction Logs</h1>
                    <p class="text-[10px] uppercase tracking-widest font-mono" style="color: var(--text3);">
                        History of credits and acquisitions
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- TABLE -->
    <div class="cyber-card p-0 overflow-hidden" style="border-color: var(--border);">
        <div class="overflow-x-auto custom-scrollbar">
            <table class="w-full text-sm font-mono text-left whitespace-nowrap">
                <thead>
                    <tr style="background: rgba(0,0,0,0.5); border-bottom: 2px solid var(--border);">
                        <th class="p-4 uppercase tracking-widest text-[10px]" style="color: var(--text3);">Timestamp</th>
                        <th class="p-4 uppercase tracking-widest text-[10px]" style="color: var(--text3);">Protocol</th>
                        <th class="p-4 uppercase tracking-widest text-[10px]" style="color: var(--text3);">Credit Volume</th>
                        <th class="p-4 uppercase tracking-widest text-[10px]" style="color: var(--text3);">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transactions as $trx)
                    <tr class="border-b transition-colors hover:bg-white/5" style="border-color: var(--border);">
                        <td class="p-4 text-[11px]" style="color: var(--text2);">
                            {{ $trx->created_at->format('d M Y H:i') }}
                        </td>
                        <td class="p-4">
                            <span class="px-2 py-1 rounded border text-[10px] uppercase tracking-widest" 
                                  style="{{ $trx->type === 'topup' ? 'border-color: var(--cyan); color: var(--cyan); background: rgba(0,217,255,0.1);' : 'border-color: var(--yellow); color: var(--yellow); background: rgba(245,158,11,0.1);' }}">
                                {{ $trx->type === 'topup' ? 'Injection' : 'Extraction' }}
                            </span>
                        </td>
                        <td class="p-4 font-bold" style="color: {{ $trx->type === 'topup' ? 'var(--green)' : '#ff4d4d' }}; font-family: 'Fira Code', monospace;">
                            {{ $trx->type === 'topup' ? '+' : '-' }}
                            Rp {{ number_format($trx->amount, 0, ',', '.') }}
                        </td>
                        <td class="p-4">
                            @if($trx->status === 'success')
                                <span class="flex items-center gap-2 text-[11px] uppercase tracking-widest" style="color: var(--green);">
                                    <i class="fas fa-check-circle"></i> Confirmed
                                </span>
                            @elseif($trx->status === 'pending')
                                <span class="flex items-center gap-2 text-[11px] uppercase tracking-widest animate-pulse" style="color: var(--yellow);">
                                    <i class="fas fa-hourglass-half"></i> Processing
                                </span>
                            @else
                                <span class="flex items-center gap-2 text-[11px] uppercase tracking-widest" style="color: #ff4d4d;">
                                    <i class="fas fa-times-circle"></i> Rejected
                                </span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="p-16 text-center">
                            <div class="text-4xl mb-4 opacity-50">📭</div>
                            <p class="text-sm font-mono uppercase tracking-widest" style="color: var(--muted);">No transactions recorded in the matrix.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    @if ($transactions->hasPages())
    <div class="flex justify-center items-center mt-8 gap-4 font-mono">
        {{ $transactions->links() }}
    </div>
    <style>
        /* Quick style override for Laravel pagination in Tailwind */
        nav[role="navigation"] div.hidden.sm\:flex-1 { display: flex; justify-content: center; }
        nav[role="navigation"] p { color: var(--text3); font-size: 0.8rem; }
        nav[role="navigation"] span.relative.inline-flex, nav[role="navigation"] a.relative.inline-flex { 
            background: var(--bg) !important; color: var(--text) !important; border-color: var(--border) !important;
        }
        nav[role="navigation"] span[aria-current="page"] span {
            background: var(--accent) !important; color: white !important; border-color: var(--accent) !important;
        }
    </style>
    @endif
</div>
@endsection

