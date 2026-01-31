<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction Details - TalentGroup Bank</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="min-h-screen">
        <!-- Header -->
        <header class="bg-blue-600 text-white p-4">
            <div class="container mx-auto flex justify-between items-center">
                <h1 class="text-2xl font-bold">Transaction Details</h1>
                <div class="flex items-center space-x-4">
                    <span>Welcome, {{ auth()->user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="bg-red-500 hover:bg-red-600 px-4 py-2 rounded">Logout</button>
                    </form>
                </div>
            </div>
        </header>

        <!-- Navigation -->
        <nav class="bg-blue-500 text-white p-4">
            <div class="container mx-auto">
                <ul class="flex space-x-6">
                    <li><a href="{{ route('bank.dashboard') }}" class="hover:underline">Dashboard</a></li>
                    <li><a href="{{ route('bank.transactions.index') }}" class="hover:underline font-semibold">Transactions</a></li>
                    <li><a href="{{ route('bank.reports') }}" class="hover:underline">Reports</a></li>
                    <li><a href="{{ route('bank.audit-logs') }}" class="hover:underline">Audit Logs</a></li>
                </ul>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="container mx-auto p-6">
            <div class="mb-6">
                <a href="{{ route('bank.transactions.index') }}" class="text-blue-600 hover:underline flex items-center">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Back to Transactions
                </a>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Transaction Details -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-semibold mb-6">Transaction Information</h2>
                    
                    <div class="space-y-4">
                        <div class="flex justify-between">
                            <span class="font-medium text-gray-600">Transaction ID:</span>
                            <span class="font-semibold">#{{ $transaction->id }}</span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="font-medium text-gray-600">Reference Number:</span>
                            <span>{{ $transaction->reference_number ?? 'N/A' }}</span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="font-medium text-gray-600">Type:</span>
                            <span class="capitalize">{{ str_replace('_', ' ', $transaction->type) }}</span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="font-medium text-gray-600">Amount:</span>
                            <span class="font-bold text-lg">Rp {{ number_format($transaction->amount) }}</span>
                        </div>
                        
                        @if($transaction->fee_amount)
                        <div class="flex justify-between">
                            <span class="font-medium text-gray-600">Fee:</span>
                            <span>Rp {{ number_format($transaction->fee_amount) }}</span>
                        </div>
                        @endif
                        
                        <div class="flex justify-between">
                            <span class="font-medium text-gray-600">Payment Method:</span>
                            <span class="capitalize">{{ str_replace('_', ' ', $transaction->payment_method) }}</span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="font-medium text-gray-600">Status:</span>
                            <span class="px-2 py-1 rounded-full text-sm font-medium
                                @if($transaction->status == 'pending') bg-yellow-100 text-yellow-800
                                @elseif($transaction->status == 'success') bg-green-100 text-green-800
                                @else bg-red-100 text-red-800 @endif">
                                {{ ucfirst($transaction->status) }}
                            </span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="font-medium text-gray-600">Created:</span>
                            <span>{{ $transaction->created_at->format('M d, Y H:i') }}</span>
                        </div>
                        
                        @if($transaction->processed_at)
                        <div class="flex justify-between">
                            <span class="font-medium text-gray-600">Processed:</span>
                            <span>{{ $transaction->processed_at->format('M d, Y H:i') }}</span>
                        </div>
                        @endif
                        
                        @if($transaction->processedBy)
                        <div class="flex justify-between">
                            <span class="font-medium text-gray-600">Processed By:</span>
                            <span>{{ $transaction->processedBy->name }}</span>
                        </div>
                        @endif
                        
                        @if($transaction->bank_notes)
                        <div>
                            <span class="font-medium text-gray-600">Bank Notes:</span>
                            <p class="mt-2 p-3 bg-gray-50 rounded">{{ $transaction->bank_notes }}</p>
                        </div>
                        @endif
                        
                        @if($transaction->failure_reason)
                        <div>
                            <span class="font-medium text-gray-600">Failure Reason:</span>
                            <p class="mt-2 p-3 bg-red-50 rounded text-red-800">{{ $transaction->failure_reason }}</p>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- User Information -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-semibold mb-6">User Information</h2>
                    
                    <div class="space-y-4">
                        <div class="flex justify-between">
                            <span class="font-medium text-gray-600">Name:</span>
                            <span class="font-semibold">{{ $transaction->user->name }}</span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="font-medium text-gray-600">Email:</span>
                            <span>{{ $transaction->user->email }}</span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="font-medium text-gray-600">Current Balance:</span>
                            <span class="font-bold">Rp {{ number_format($transaction->user->balance) }}</span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="font-medium text-gray-600">Member Since:</span>
                            <span>{{ $transaction->user->created_at->format('M d, Y') }}</span>
                        </div>
                    </div>
                    
                    <div class="mt-6">
                        <a href="{{ route('bank.users.balance-history', $transaction->user) }}" class="text-blue-600 hover:underline">
                            View Balance History
                        </a>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            @if($transaction->status == 'pending')
            <div class="mt-8 bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold mb-6">Actions</h2>
                
                <div class="flex space-x-4">
                    <a href="{{ route('bank.transactions.confirm', $transaction) }}" class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg flex items-center">
                        <i class="fas fa-check mr-2"></i>
                        Confirm Transaction
                    </a>
                    
                    <a href="{{ route('bank.transactions.reject', $transaction) }}" class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-lg flex items-center">
                        <i class="fas fa-times mr-2"></i>
                        Reject Transaction
                    </a>
                </div>
            </div>
            @endif
        </main>
    </div>

    @if(session('success'))
    <div class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg">
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="fixed bottom-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg">
        {{ session('error') }}
    </div>
    @endif
</body>
</html>