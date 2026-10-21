@extends('layouts.app')

@section('title', 'Recharge Balance')

@section('content')
<div class="max-w-5xl mx-auto px-6 py-8 grid grid-cols-1 lg:grid-cols-3 gap-8">

    <!-- FORM -->
    <div class="lg:col-span-2">
        <div class="cyber-card p-8">
            <div class="flex items-center gap-4 mb-8 pb-4 border-b" style="border-color: var(--border);">
                <div class="text-4xl text-[var(--accent)]">💳</div>
                <div>
                    <h2 class="text-2xl font-bold" style="color: var(--text); font-family: 'Outfit', sans-serif;">
                        Recharge Balance
                    </h2>
                    <p class="text-[10px] uppercase tracking-widest font-mono" style="color: var(--text3);">Acquire Credits</p>
                </div>
            </div>

            <form method="POST" action="{{ route('user.transactions.topup.process') }}" class="m-0">
                @csrf

                <!-- Preset -->
                <div class="mb-6">
                    <label class="block text-[10px] uppercase tracking-widest font-bold mb-3" style="color: var(--text2);">
                        <i class="fas fa-bolt mr-2" style="color: var(--accent);"></i> Preset Amounts
                    </label>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                        @foreach([50000, 100000, 250000, 500000, 1000000] as $amt)
                            <button type="button"
                                    onclick="document.getElementById('amount').value={{ $amt }}"
                                    class="border p-4 text-center rounded transition-all hover:-translate-y-1 hover:shadow-[0_0_15px_rgba(0,212,255,0.2)] focus:outline-none focus:border-[var(--accent)] focus:bg-[rgba(0,212,255,0.1)]"
                                    style="border-color: var(--border); background: rgba(0,0,0,0.2); color: var(--text); font-family: 'Fira Code', monospace;">
                                Rp {{ number_format($amt,0,',','.') }}
                            </button>
                        @endforeach
                    </div>
                </div>

                <!-- Input -->
                <div class="mb-8">
                    <label class="block text-[10px] uppercase tracking-widest font-bold mb-3" style="color: var(--text2);">
                        <i class="fas fa-keyboard mr-2" style="color: var(--accent);"></i> Custom Amount
                    </label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 font-bold font-mono" style="color: var(--text3);">Rp</span>
                        <input id="amount"
                               name="amount"
                               type="number"
                               min="10000"
                               required
                               placeholder="10000"
                               class="w-full border p-4 pl-12 rounded outline-none transition-all focus:border-[var(--accent)] focus:shadow-[0_0_15px_rgba(0,212,255,0.2)]"
                               style="background: rgba(0,0,0,0.5); border-color: var(--border); color: var(--text); font-family: 'Fira Code', monospace;">
                    </div>
                </div>

                <button class="btn-primary w-full text-center flex justify-center items-center py-4">
                    <i class="fas fa-plus-circle mr-2 text-lg"></i> Initiate Transfer Protocol
                </button>
            </form>
        </div>
    </div>

    <!-- SIDEBAR -->
    <div class="flex flex-col gap-6">
        <div class="cyber-card p-6 border-t-[3px]" style="border-top-color: var(--green);">
            <p class="text-[10px] uppercase tracking-widest font-bold mb-2" style="color: var(--text3);">Current Balance</p>
            <div class="flex items-center gap-3">
                <i class="fas fa-wallet text-2xl" style="color: var(--green);"></i>
                <p class="text-2xl font-bold" style="color: var(--green); font-family: 'Fira Code', monospace;">
                    Rp {{ number_format(auth()->user()->balance,0,',','.') }}
                </p>
            </div>
        </div>

        <div class="cyber-card p-6 bg-blue-900/10 border-[var(--border)]">
            <p class="text-sm font-bold flex items-center gap-2 mb-4" style="color: var(--cyan);">
                <i class="fas fa-info-circle"></i> Protocol Info
            </p>
            <ul class="text-xs space-y-3 font-mono leading-relaxed" style="color: var(--text2);">
                <li class="flex items-start gap-2">
                    <i class="fas fa-angle-right mt-1" style="color: var(--accent);"></i>
                    <span>Minimum transfer amount: Rp 10.000</span>
                </li>
                <li class="flex items-start gap-2">
                    <i class="fas fa-angle-right mt-1" style="color: var(--accent);"></i>
                    <span>Credits will be injected automatically</span>
                </li>
                <li class="flex items-start gap-2">
                    <i class="fas fa-angle-right mt-1" style="color: var(--accent);"></i>
                    <span>Connection is encrypted and secure</span>
                </li>
            </ul>
        </div>
    </div>
</div>
@endsection

