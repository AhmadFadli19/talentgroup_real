<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reject Transaction - TalentGroup Bank</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="min-h-screen">
        <!-- Header -->
        <header class="bg-blue-600 text-white p-4">
            <div class="container mx-auto flex justify-between items-center">
                <h1 class="text-2xl font-bold">Reject Transaction</h1>
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
                <a href="{{ route('bank.transactions.show', $transaction) }}" class="text-blue-600 hover:underline flex items-center">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Back to Transaction Details
                </a>
            </div>

            <div class="max-w-2xl mx-auto">
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="text-center mb-6">
                        <div class="bg-red-100 rounded-full w-16 h-16 mx-auto flex items-center justify-center mb-4">
                            <i class="fas fa-times text-red-600 text-2xl"></i>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-800">Reject Transaction</h2>
                        <p class="text-gray-600 mt-2">Please provide a reason for rejecting this transaction</p>
                    </div>

                    <!-- Transaction Summary -->
                    <div class="bg-gray-50 rounded-lg p-6 mb-6">
                        <h3 class="text-lg font-semibold mb-4">Transaction Summary</h3>
                        
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Transaction ID:</span>
                                <span class="font-semibold">#{{ $transaction->id }}</span>
                            </div>
                            
                            <div class="flex justify-between">
                                <span class="text-gray-600">User:</span>
                                <span class="font-semibold">{{ $transaction->user->name }}</span>
                            </div>
                            
                            <div class="flex justify-between">
                                <span class="text-gray-600">Type:</span>
                                <span class="capitalize">{{ str_replace('_', ' ', $transaction->type) }}</span>
                            </div>
                            
                            <div class="flex justify-between">
                                <span class="text-gray-600">Amount:</span>
                                <span class="font-bold text-lg text-red-600">Rp {{ number_format($transaction->amount) }}</span>
                            </div>
                            
                            <div class="flex justify-between">
                                <span class="text-gray-600">Payment Method:</span>
                                <span class="capitalize">{{ str_replace('_', ' ', $transaction->payment_method) }}</span>
                            </div>
                            
                            <div class="flex justify-between">
                                <span class="text-gray-600">Created:</span>
                                <span>{{ $transaction->created_at->format('M d, Y H:i') }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Rejection Form -->
                    <form method="POST" action="{{ route('bank.transactions.process-rejection', $transaction) }}">
                        @csrf
                        <input type="hidden" name="confirm" value="1">
                        
                        <div class="mb-6">
                            <label for="reason" class="block text-sm font-medium text-gray-700 mb-2">
                                Rejection Reason <span class="text-red-500">*</span>
                            </label>
                            <textarea 
                                id="reason" 
                                name="reason" 
                                rows="4" 
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-red-500 focus:border-red-500"
                                placeholder="Please provide a detailed reason for rejecting this transaction..."
                                required>{{ old('reason') }}</textarea>
                            @error('reason')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="bank_notes" class="block text-sm font-medium text-gray-700 mb-2">
                                Additional Bank Notes (Optional)
                            </label>
                            <textarea 
                                id="bank_notes" 
                                name="bank_notes" 
                                rows="3" 
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-red-500 focus:border-red-500"
                                placeholder="Add any additional notes...">{{ old('bank_notes') }}</textarea>
                            @error('bank_notes')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Common Rejection Reasons -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Common Rejection Reasons (Click to use)
                            </label>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                                <button type="button" onclick="setReason('Insufficient payment proof')" 
                                        class="text-left p-2 border border-gray-200 rounded hover:bg-gray-50 text-sm">
                                    Insufficient payment proof
                                </button>
                                <button type="button" onclick="setReason('Invalid payment method')" 
                                        class="text-left p-2 border border-gray-200 rounded hover:bg-gray-50 text-sm">
                                    Invalid payment method
                                </button>
                                <button type="button" onclick="setReason('Duplicate transaction')" 
                                        class="text-left p-2 border border-gray-200 rounded hover:bg-gray-50 text-sm">
                                    Duplicate transaction
                                </button>
                                <button type="button" onclick="setReason('Fraudulent activity suspected')" 
                                        class="text-left p-2 border border-gray-200 rounded hover:bg-gray-50 text-sm">
                                    Fraudulent activity suspected
                                </button>
                                <button type="button" onclick="setReason('Incorrect amount')" 
                                        class="text-left p-2 border border-gray-200 rounded hover:bg-gray-50 text-sm">
                                    Incorrect amount
                                </button>
                                <button type="button" onclick="setReason('User account verification required')" 
                                        class="text-left p-2 border border-gray-200 rounded hover:bg-gray-50 text-sm">
                                    User account verification required
                                </button>
                            </div>
                        </div>

                        <!-- Warning Message -->
                        <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                            <div class="flex items-start">
                                <i class="fas fa-exclamation-triangle text-red-600 mt-1 mr-3"></i>
                                <div>
                                    <h4 class="text-red-800 font-semibold">Important Notice</h4>
                                    <p class="text-red-700 text-sm mt-1">
                                        By rejecting this transaction, the payment will be marked as failed and the user will be notified. 
                                        This action cannot be undone.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex justify-end space-x-4">
                            <a href="{{ route('bank.transactions.show', $transaction) }}" 
                               class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                                Cancel
                            </a>
                            
                            <button type="submit" 
                                    class="px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors duration-200 flex items-center">
                                <i class="fas fa-times mr-2"></i>
                                Reject Transaction
                            </button>
                        </div>
                    </form>
                </div>
            </div>
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

    <script>
        function setReason(reason) {
            document.getElementById('reason').value = reason;
        }
    </script>
</body>
</html>