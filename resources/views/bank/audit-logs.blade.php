<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Audit Logs - TalentGroup Bank</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="min-h-screen">
        <!-- Header -->
        <header class="bg-blue-600 text-white p-4">
            <div class="container mx-auto flex justify-between items-center">
                <h1 class="text-2xl font-bold">Audit Logs</h1>
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
                    <li><a href="{{ route('bank.transactions.index') }}" class="hover:underline">Transactions</a></li>
                    <li><a href="{{ route('bank.reports') }}" class="hover:underline">Reports</a></li>
                    <li><a href="{{ route('bank.audit-logs') }}" class="hover:underline font-semibold">Audit Logs</a></li>
                </ul>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="container mx-auto p-6">
            <!-- Filters -->
            <div class="bg-white rounded-lg shadow p-6 mb-8">
                <h2 class="text-xl font-semibold mb-4">Filter Audit Logs</h2>
                <form method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Action</label>
                        <select name="action" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                            <option value="">All Actions</option>
                            <option value="transaction_confirmed" {{ request('action') == 'transaction_confirmed' ? 'selected' : '' }}>Transaction Confirmed</option>
                            <option value="transaction_rejected" {{ request('action') == 'transaction_rejected' ? 'selected' : '' }}>Transaction Rejected</option>
                            <option value="manual_topup" {{ request('action') == 'manual_topup' ? 'selected' : '' }}>Manual Top Up</option>
                            <option value="balance_adjustment" {{ request('action') == 'balance_adjustment' ? 'selected' : '' }}>Balance Adjustment</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">User</label>
                        <input type="text" name="user" value="{{ request('user') }}" placeholder="Search user..." class="w-full border border-gray-300 rounded-lg px-3 py-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Date From</label>
                        <input type="date" name="date_from" value="{{ request('date_from') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Date To</label>
                        <input type="date" name="date_to" value="{{ request('date_to') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                    </div>
                    <div class="flex items-end">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg w-full">
                            Filter
                        </button>
                    </div>
                </form>
            </div>

            <!-- Audit Logs Table -->
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="p-6 border-b">
                    <h2 class="text-xl font-semibold">Audit Trail</h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Timestamp</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Action</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">User</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Performed By</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Details</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">IP Address</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($auditLogs as $log)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <div>{{ $log->created_at->format('M d, Y') }}</div>
                                    <div class="text-xs text-gray-500">{{ $log->created_at->format('H:i:s') }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $actionColors = [
                                            'transaction_confirmed' => 'bg-green-100 text-green-800',
                                            'transaction_rejected' => 'bg-red-100 text-red-800',
                                            'manual_topup' => 'bg-blue-100 text-blue-800',
                                            'balance_adjustment' => 'bg-yellow-100 text-yellow-800',
                                        ];
                                        $color = $actionColors[$log->action] ?? 'bg-gray-100 text-gray-800';
                                    @endphp
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $color }}">
                                        {{ str_replace('_', ' ', ucfirst($log->action)) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($log->user)
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-8 w-8">
                                            <div class="h-8 w-8 rounded-full bg-blue-500 flex items-center justify-center text-white text-xs font-semibold">
                                                {{ substr($log->user->name, 0, 1) }}
                                            </div>
                                        </div>
                                        <div class="ml-3">
                                            <div class="text-sm font-medium text-gray-900">{{ $log->user->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $log->user->email }}</div>
                                        </div>
                                    </div>
                                    @else
                                    <span class="text-gray-500">N/A</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($log->performedBy)
                                    <div class="text-sm font-medium text-gray-900">{{ $log->performedBy->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $log->performedBy->role->display_name ?? 'N/A' }}</div>
                                    @else
                                    <span class="text-gray-500">System</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900 max-w-xs">
                                        @if($log->details)
                                            @php
                                                $details = is_string($log->details) ? json_decode($log->details, true) : $log->details;
                                            @endphp
                                            @if(is_array($details))
                                                @foreach($details as $key => $value)
                                                    <div><strong>{{ ucfirst(str_replace('_', ' ', $key)) }}:</strong> {{ $value }}</div>
                                                @endforeach
                                            @else
                                                {{ $log->details }}
                                            @endif
                                        @else
                                            <span class="text-gray-500">No details</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $log->ip_address ?? 'N/A' }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center">
                                        <i class="fas fa-history text-gray-400 text-4xl mb-4"></i>
                                        <p class="text-gray-500 text-lg">No audit logs found</p>
                                        <p class="text-gray-400 text-sm">Try adjusting your filters</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                @if($auditLogs->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $auditLogs->links() }}
                </div>
                @endif
            </div>

            <!-- Export Options -->
            <div class="mt-8 bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold mb-4">Export Audit Logs</h3>
                <div class="flex space-x-4">
                    <button class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center">
                        <i class="fas fa-file-excel mr-2"></i>
                        Export to Excel
                    </button>
                    <button class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg flex items-center">
                        <i class="fas fa-file-pdf mr-2"></i>
                        Export to PDF
                    </button>
                    <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center">
                        <i class="fas fa-file-csv mr-2"></i>
                        Export to CSV
                    </button>
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
</body>
</html>