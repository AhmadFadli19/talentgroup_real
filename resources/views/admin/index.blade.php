@extends('admin.layouts')

@section('content')
    <!-- Main Content -->
    <main class="flex-1 overflow-y-auto">
        <!-- Top Bar -->
        <div class="bg-white shadow-md p-4 flex justify-between items-center">
            <div class="flex items-center">
                <button id="menuToggle" class="mr-4 lg:hidden">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                <h1 class="text-xl font-bold">Admin Dashboard</h1>
            </div>
            <div class="flex items-center space-x-4">
                <div class="relative">  
                    <button class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                        <span
                            class="bg-red-500 text-white rounded-full h-5 w-5 flex items-center justify-center text-xs absolute -top-1 -right-1">3</span>
                    </button>
                </div>
                <div class="flex items-center">
                    <img src="/api/placeholder/40/40" alt="Admin" class="h-8 w-8 rounded-full mr-2">
                    <span class="text-gray-700">Admin</span>
                </div>
            </div>
        </div>

        


        <!-- Dashboard Content -->
        <div class="p-6">
            <form action="{{ route('slidebanner.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div>
                    <label class="block font-medium">Judul</label>
                    <input type="text" name="title" class="w-full border p-2 rounded" required>
                </div>
    
                <div>
                    <label class="block font-medium">Subjudul</label>
                    <input type="text" name="subtitle" class="w-full border p-2 rounded">
                </div>
                <div>
                    <label class="block font-medium">url</label>
                    <input type="text" name="url" class="w-full border p-2 rounded">
                </div>
    
                <div>
                    <label class="block font-medium">Teks Button</label>
                    <input type="text" name="button_text">
                </div>
    
                <div>
                    <label class="block font-medium">Gambar</label>
                    <input type="file" name="image" class="w-full border p-2 rounded" required>
                </div>
    
                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded">Simpan</button>
            </form>
            <!-- Stats Cards -->
            {{-- <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-4 mb-4">
                    <div class="bg-white rounded-lg shadow-md p-6 flex items-center">
                        <div class="p-3 rounded-full bg-green-100 mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-orange-600" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-gray-500">Total Transaksi</p>
                            <p class="text-2xl font-bold">{{ $TotalTransaksi }}</p>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg shadow-md p-6 flex items-center">
                        <div class="p-3 rounded-full bg-red-100 mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-red-600" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-gray-500">Transaksi di Tolak</p>
                            <p class="text-2xl font-bold">{{ $TransaksiTolak }}</p>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg shadow-md p-6 flex items-center">
                        <div class="p-3 rounded-full bg-green-100 mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-600" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-gray-500">Transaksi Sukses</p>
                            <p class="text-2xl font-bold">{{ $TransaksiSukses }}</p>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg shadow-md p-6 flex items-center">
                        <div class="p-3 rounded-full bg-orange-100 mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-red-600" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-gray-500">Transaksi Pending</p>
                            <p class="text-2xl font-bold">{{ $TransaksiPending }}</p>
                        </div>
                    </div>
                </div> --}}

            <!-- Dashboard Content -->
            <div class="p-6">
                <!-- Search and Export Section -->
                {{-- <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
                        <div class="flex-1">
                            <form action="{{ route('transaksi.search') }}" method="GET" class="flex gap-2">
                                <input type="text" name="search" placeholder="Cari transaksi..."
                                    value="{{ request('search') }}"
                                    class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-blue-500 focus:outline-none" />
                                <button type="submit"
                                    class="rounded-lg bg-blue-500 px-4 py-2 text-white hover:bg-blue-600 focus:outline-none">
                                    <i class="fas fa-search"></i> Cari
                                </button>
                            </form>
                        </div> --}}
                {{-- 
                        <div class="flex flex-wrap gap-2">
                            <!-- PDF Export All -->
                            <a href="{{ route('transaksi.pdf.all') }}"
                                class="rounded-lg bg-green-500 px-4 py-2 text-white hover:bg-green-600 focus:outline-none">
                                <i class="fas fa-file-pdf"></i> Export Semua
                            </a>

                            <!-- PDF Export Date Range -->
                            <button id="dateRangeBtn"
                                class="rounded-lg bg-purple-500 px-4 py-2 text-white hover:bg-purple-600 focus:outline-none">
                                <i class="fas fa-calendar"></i> Export Periode
                            </button>
                        </div> --}}
            </div>

            <!-- Date Range Modal -->
            <div id="dateRangeModal"
                class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center">
                <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
                    <h3 class="text-lg font-semibold mb-4">Export Laporan Transaksi</h3>
                    <form action="#" method="GET">
                        <div class="mb-4">
                            <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal
                                Mulai</label>
                            <input type="date" id="start_date" name="start_date" required
                                class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-blue-500 focus:outline-none">
                        </div>
                        <div class="mb-4">
                            <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal
                                Akhir</label>
                            <input type="date" id="end_date" name="end_date" required
                                class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-blue-500 focus:outline-none">
                        </div>
                        <div class="flex justify-end gap-2">
                            <button type="button" id="cancelDateRange"
                                class="rounded-lg bg-gray-300 px-4 py-2 text-gray-800 hover:bg-gray-400 focus:outline-none">
                                Batal
                            </button>
                            <button type="submit"
                                class="rounded-lg bg-blue-500 px-4 py-2 text-white hover:bg-blue-600 focus:outline-none">
                                Export PDF
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Transactions Table -->
            <div class="responsive-table">
                <table class="min-w-full bg-white border border-gray-200 rounded-lg overflow-hidden">
                    <thead class="bg-gray-50">
                        <tr>
                            <th
                                class="border border-gray-200 px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                ID</th>
                            <th
                                class="border border-gray-200 px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Nama Pengguna</th>
                            <th
                                class="border border-gray-200 px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Email</th>
                            <th
                                class="border border-gray-200 px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tipe</th>
                            <th
                                class="border border-gray-200 px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Saldo</th>
                            <th
                                class="border border-gray-200 px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tanggal</th>
                            <th
                                class="border border-gray-200 px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status</th>
                            <th
                                class="border border-gray-200 px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tindakan</th>
                        </tr>
                    </thead>
                    {{-- <tbody class="divide-y divide-gray-200">
                                @forelse ($saldo_transaksi as $transaksi)
                                    <tr class="hover:bg-gray-50">
                                        <td class="border border-gray-200 px-4 py-3 text-sm text-gray-600">
                                            {{ $transaksi->id }}</td>
                                        <td class="border border-gray-200 px-4 py-3">
                                            <div class="font-semibold text-gray-800">{{ $transaksi->user->name }}
                                            </div>
                                        </td>
                                        <td class="border border-gray-200 px-4 py-3 text-sm text-gray-600">
                                            {{ $transaksi->user->email }}</td>
                                        <td class="border border-gray-200 px-4 py-3">
                                            @if ($transaksi->type == 'top_up')
                                                <span
                                                    class="bg-green-100 text-green-600 py-1 px-2 rounded-full text-xs">Top-Up</span>
                                            @elseif ($transaksi->type == 'withdraw')
                                                <span
                                                    class="bg-red-100 text-red-600 py-1 px-2 rounded-full text-xs">Withdraw</span>
                                            @elseif ($transaksi->type == 'transfer')
                                                <span
                                                    class="bg-blue-100 text-blue-600 py-1 px-2 rounded-full text-xs">Transfer</span>
                                            @endif
                                        </td>
                                        <td class="border border-gray-200 px-4 py-3 font-semibold">
                                            {{ number_format($transaksi->amount, 0, ',', '.') }}</td>
                                        <td class="border border-gray-200 px-4 py-3 text-sm text-gray-600">
                                            {{ $transaksi->created_at }}</td>
                                        <td class="border border-gray-200 px-4 py-2">
                                            @if ($transaksi->confirmed == 'sukses')
                                                <span
                                                    class="bg-green-100 text-green-800 px-2 py-1 rounded">Sukses</span>
                                            @elseif ($transaksi->confirmed == 'tolak')
                                                <span class="bg-red-100 text-red-800 px-2 py-1 rounded">Ditolak</span>
                                            @else
                                                <span
                                                    class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded">Pending</span>
                                            @endif
                                        </td>
                                        <td class="border border-gray-200 px-4 py-2">
                                            <a href="{{ route('transaksi.pdf.single', $transaksi->id) }}"
                                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded text-xs">
                                                <i class="fas fa-file-pdf"></i> PDF
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="border border-gray-200 px-4 py-2 text-center">Tidak
                                            ada transaksi terbaru</td>
                                    </tr>
                                @endforelse
                            </tbody> --}}
                </table>
            </div>
        </div>

        <!-- JavaScript for Date Range Modal -->
        <script>
            // Modal functionality
            const dateRangeBtn = document.getElementById('dateRangeBtn');
            const dateRangeModal = document.getElementById('dateRangeModal');
            const cancelDateRange = document.getElementById('cancelDateRange');

            dateRangeBtn.addEventListener('click', () => {
                dateRangeModal.classList.remove('hidden');
            });

            cancelDateRange.addEventListener('click', () => {
                dateRangeModal.classList.add('hidden');
            });

            // Close modal when clicking outside
            dateRangeModal.addEventListener('click', (e) => {
                if (e.target === dateRangeModal) {
                    dateRangeModal.classList.add('hidden');
                }
            });

            // Set default dates
            const today = new Date();
            const startDate = document.getElementById('start_date');
            const endDate = document.getElementById('end_date');

            // Format date as YYYY-MM-DD
            const formatDate = (date) => {
                return date.toISOString().split('T')[0];
            };

            // Set default start date to 30 days ago
            const thirtyDaysAgo = new Date();
            thirtyDaysAgo.setDate(today.getDate() - 30);

            startDate.value = formatDate(thirtyDaysAgo);
            endDate.value = formatDate(today);
        </script>
    @endsection
