@extends('layouts.app')

@section('title', 'Top Up Saldo')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center space-x-4">
                <a href="{{ route('user.transactions.index') }}" class="text-gray-600 hover:text-gray-900">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Top Up Saldo</h1>
                    <p class="text-gray-600 mt-2">Tambahkan saldo untuk membeli kursus</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Top Up Form -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-6">Pilih Jumlah Top Up</h2>
                    
                    <form action="{{ route('user.transactions.topup.process') }}" method="POST" id="topupForm">
                        @csrf
                        
                        <!-- Amount Selection -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-3">Jumlah Top Up</label>
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-3 mb-4">
                                <button type="button" onclick="selectAmount(50000)" class="amount-btn p-4 border-2 border-gray-200 rounded-lg text-center hover:border-blue-500 hover:bg-blue-50 transition-colors">
                                    <div class="font-semibold text-gray-900">Rp 50.000</div>
                                </button>
                                <button type="button" onclick="selectAmount(100000)" class="amount-btn p-4 border-2 border-gray-200 rounded-lg text-center hover:border-blue-500 hover:bg-blue-50 transition-colors">
                                    <div class="font-semibold text-gray-900">Rp 100.000</div>
                                </button>
                                <button type="button" onclick="selectAmount(250000)" class="amount-btn p-4 border-2 border-gray-200 rounded-lg text-center hover:border-blue-500 hover:bg-blue-50 transition-colors">
                                    <div class="font-semibold text-gray-900">Rp 250.000</div>
                                </button>
                                <button type="button" onclick="selectAmount(500000)" class="amount-btn p-4 border-2 border-gray-200 rounded-lg text-center hover:border-blue-500 hover:bg-blue-50 transition-colors">
                                    <div class="font-semibold text-gray-900">Rp 500.000</div>
                                </button>
                                <button type="button" onclick="selectAmount(1000000)" class="amount-btn p-4 border-2 border-gray-200 rounded-lg text-center hover:border-blue-500 hover:bg-blue-50 transition-colors">
                                    <div class="font-semibold text-gray-900">Rp 1.000.000</div>
                                </button>
                                <button type="button" onclick="selectCustomAmount()" class="amount-btn p-4 border-2 border-gray-200 rounded-lg text-center hover:border-blue-500 hover:bg-blue-50 transition-colors">
                                    <div class="font-semibold text-gray-900">Jumlah Lain</div>
                                </button>
                            </div>
                            
                            <div class="relative">
                                <input type="number" 
                                       name="amount" 
                                       id="customAmount" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                                       placeholder="Masukkan jumlah (min. Rp 10.000)"
                                       min="10000"
                                       max="10000000"
                                       required>
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 text-sm">Rp</span>
                                </div>
                            </div>
                            @error('amount')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Payment Method -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-3">Metode Pembayaran</label>
                            <img src="{{ asset('error.png') }}" alt="Gopay" class="w-1/2 mx-auto">

                            {{-- <div class="space-y-3">
                                <label class="flex items-center p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-blue-500 hover:bg-blue-50 transition-colors">
                                    <input type="radio" name="payment_method" value="bank_transfer" class="text-blue-600 focus:ring-blue-500" required>
                                    <div class="ml-3 flex items-center">
                                        <div class="p-2 bg-blue-100 rounded-lg mr-3">
                                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="font-medium text-gray-900">Transfer Bank</div>
                                            <div class="text-sm text-gray-500">BCA Virtual Account</div>
                                        </div>
                                    </div>
                                </label>

                                <label class="flex items-center p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-blue-500 hover:bg-blue-50 transition-colors">
                                    <input type="radio" name="payment_method" value="e_wallet" class="text-blue-600 focus:ring-blue-500">
                                    <div class="ml-3 flex items-center">
                                        <div class="p-2 bg-green-100 rounded-lg mr-3">
                                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="font-medium text-gray-900">E-Wallet</div>
                                            <div class="text-sm text-gray-500">GoPay, OVO, DANA (Instan)</div>
                                        </div>
                                    </div>
                                </label>

                                <label class="flex items-center p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-blue-500 hover:bg-blue-50 transition-colors">
                                    <input type="radio" name="payment_method" value="credit_card" class="text-blue-600 focus:ring-blue-500">
                                    <div class="ml-3 flex items-center">
                                        <div class="p-2 bg-purple-100 rounded-lg mr-3">
                                            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="font-medium text-gray-900">Kartu Kredit</div>
                                            <div class="text-sm text-gray-500">Visa, Mastercard (Instan)</div>
                                        </div>
                                    </div>
                                </label>
                            </div> --}}
                            @error('payment_method')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        {{-- <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-4 rounded-lg transition-colors">
                            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Proses Top Up
                        </button> --}}
                    </form>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <!-- Current Balance -->
                <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-lg shadow-lg p-6 text-white mb-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-blue-100 text-sm">Saldo Saat Ini</p>
                            <p class="text-2xl font-bold">Rp {{ number_format(auth()->user()->balance, 0, ',', '.') }}</p>
                        </div>
                        <div class="p-3 bg-white bg-opacity-20 rounded-full">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Information -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Top Up</h3>
                    <div class="space-y-4">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-blue-600 mt-0.5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Minimum Top Up</p>
                                <p class="text-xs text-gray-500">Rp 10.000</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-green-600 mt-0.5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Proses Instan</p>
                                <p class="text-xs text-gray-500">E-Wallet & Kartu Kredit</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-yellow-600 mt-0.5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Aman & Terpercaya</p>
                                <p class="text-xs text-gray-500">Transaksi dilindungi SSL</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Transactions -->
                <div class="bg-white rounded-lg shadow-md p-6 mt-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Transaksi Terakhir</h3>
                    <div class="space-y-3">
                        @php
                            $recentTransactions = auth()->user()->transactions()->latest()->take(3)->get();
                        @endphp
                        @forelse($recentTransactions as $transaction)
                            <div class="flex items-center justify-between py-2 border-b border-gray-100 last:border-b-0">
                                <div>
                                    <p class="text-sm font-medium text-gray-900">
                                        @if($transaction->type === 'topup')
                                            Top Up
                                        @else
                                            {{ ucfirst($transaction->type) }}
                                        @endif
                                    </p>
                                    <p class="text-xs text-gray-500">{{ $transaction->created_at->format('d/m/Y') }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-medium {{ $transaction->type === 'topup' ? 'text-green-600' : 'text-red-600' }}">
                                        {{ $transaction->type === 'topup' ? '+' : '-' }}Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                                    </p>
                                    <p class="text-xs {{ $transaction->status === 'success' ? 'text-green-500' : ($transaction->status === 'pending' ? 'text-yellow-500' : 'text-red-500') }}">
                                        {{ ucfirst($transaction->status) }}
                                    </p>
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500 text-center py-4">Belum ada transaksi</p>
                        @endforelse
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('user.transactions.index') }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                            Lihat Semua →
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function selectAmount(amount) {
    // Remove active class from all buttons
    document.querySelectorAll('.amount-btn').forEach(btn => {
        btn.classList.remove('border-blue-500', 'bg-blue-50');
        btn.classList.add('border-gray-200');
    });
    
    // Add active class to clicked button
    event.target.closest('.amount-btn').classList.remove('border-gray-200');
    event.target.closest('.amount-btn').classList.add('border-blue-500', 'bg-blue-50');
    
    // Set the amount in input
    document.getElementById('customAmount').value = amount;
}

function selectCustomAmount() {
    // Remove active class from all buttons
    document.querySelectorAll('.amount-btn').forEach(btn => {
        btn.classList.remove('border-blue-500', 'bg-blue-50');
        btn.classList.add('border-gray-200');
    });
    
    // Add active class to custom button
    event.target.closest('.amount-btn').classList.remove('border-gray-200');
    event.target.closest('.amount-btn').classList.add('border-blue-500', 'bg-blue-50');
    
    // Clear and focus input
    document.getElementById('customAmount').value = '';
    document.getElementById('customAmount').focus();
}

// Format number input
document.getElementById('customAmount').addEventListener('input', function(e) {
    // Remove active class from preset buttons when typing custom amount
    if (e.target.value) {
        document.querySelectorAll('.amount-btn').forEach(btn => {
            btn.classList.remove('border-blue-500', 'bg-blue-50');
            btn.classList.add('border-gray-200');
        });
        
        // Activate custom amount button
        document.querySelectorAll('.amount-btn')[5].classList.remove('border-gray-200');
        document.querySelectorAll('.amount-btn')[5].classList.add('border-blue-500', 'bg-blue-50');
    }
});
</script>
@endsection