<!DOCTYPE html>
<html>
<head>
    <title>Laporan Transaksi {{ $start_date }} - {{ $end_date }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        h1 {
            text-align: center;
            font-size: 18px;
            margin-bottom: 20px;
        }
        .date-range {
            text-align: center;
            margin-bottom: 20px;
            font-weight: bold;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: right;
        }
        .footer {
            margin-top: 30px;
            text-align: right;
            font-style: italic;
        }
        .badge {
            padding: 3px 6px;
            border-radius: 4px;
            font-size: 10px;
        }
        .badge-success {
            background-color: #d4edda;
            color: #155724;
        }
        .badge-warning {
            background-color: #fff3cd;
            color: #856404;
        }
        .badge-danger {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>
    <h1>Laporan Transaksi</h1>
    <div class="date-range">Periode: {{ \Carbon\Carbon::parse($start_date)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($end_date)->format('d/m/Y') }}</div>
    
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Pengguna</th>
                <th>Email</th>
                <th>Tipe</th>
                <th>Jumlah</th>
                <th>Tanggal</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($saldo_transaksi as $transaksi)
                <tr>
                    <td>{{ $transaksi->id }}</td>
                    <td>{{ $transaksi->user->name }}</td>
                    <td>{{ $transaksi->user->email }}</td>
                    <td>
                        @if ($transaksi->type == 'top_up')
                            Top-Up
                        @elseif ($transaksi->type == 'withdraw')
                            Withdraw
                        @elseif ($transaksi->type == 'transfer')
                            Transfer
                        @endif
                    </td>
                    <td class="text-right">{{ number_format($transaksi->amount, 0, ',', '.') }}</td>
                    <td>{{ $transaksi->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        @if ($transaksi->confirmed == 'sukses')
                            <span class="badge badge-success">Sukses</span>
                        @elseif ($transaksi->confirmed == 'tolak')
                            <span class="badge badge-danger">Ditolak</span>
                        @else
                            <span class="badge badge-warning">Pending</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">Tidak ada transaksi pada periode ini</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    
    <div class="footer">
        Dicetak pada: {{ now()->format('d-m-Y H:i:s') }}
    </div>
</body>
</html>