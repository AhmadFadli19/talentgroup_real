<!DOCTYPE html>
<html>
<head>
    <title>Detail Transaksi #{{ $transaksi->id }}</title>
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
        .container {
            width: 100%;
            margin: 0 auto;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .row {
            margin-bottom: 15px;
            clear: both;
        }
        .col-left {
            float: left;
            width: 40%;
            font-weight: bold;
        }
        .col-right {
            float: left;
            width: 60%;
        }
        .box {
            border: 1px solid #ddd;
            padding: 15px;
            margin-bottom: 20px;
        }
        .title {
            font-weight: bold;
            margin-bottom: 10px;
            font-size: 14px;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            font-style: italic;
        }
        .clearfix:after {
            content: "";
            display: table;
            clear: both;
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
    <div class="container">
        <div class="header">
            <h1>Detail Transaksi #{{ $transaksi->id }}</h1>
        </div>
        
        <div class="box">
            <div class="title">Informasi Transaksi</div>
            
            <div class="row clearfix">
                <div class="col-left">ID Transaksi:</div>
                <div class="col-right">{{ $transaksi->id }}</div>
            </div>
            
            <div class="row clearfix">
                <div class="col-left">Jenis Transaksi:</div>
                <div class="col-right">
                    @if ($transaksi->type == 'top_up')
                        Top-Up
                    @elseif ($transaksi->type == 'withdraw')
                        Withdraw
                    @elseif ($transaksi->type == 'transfer')
                        Transfer
                    @endif
                </div>
            </div>
            
            <div class="row clearfix">
                <div class="col-left">Jumlah:</div>
                <div class="col-right">Rp {{ number_format($transaksi->amount, 0, ',', '.') }}</div>
            </div>
            
            <div class="row clearfix">
                <div class="col-left">Tanggal Transaksi:</div>
                <div class="col-right">{{ $transaksi->created_at->format('d/m/Y H:i:s') }}</div>
            </div>
            
            <div class="row clearfix">
                <div class="col-left">Status:</div>
                <div class="col-right">
                    @if ($transaksi->confirmed == 'sukses')
                        <span class="badge badge-success">Sukses</span>
                    @elseif ($transaksi->confirmed == 'tolak')
                        <span class="badge badge-danger">Ditolak</span>
                    @else
                        <span class="badge badge-warning">Pending</span>
                    @endif
                </div>
            </div>
            
            @if ($transaksi->deskripsi)
            <div class="row clearfix">
                <div class="col-left">Deskripsi:</div>
                <div class="col-right">{{ $transaksi->deskripsi }}</div>
            </div>
            @endif
        </div>
        
        <div class="box">
            <div class="title">Informasi Pengguna</div>
            
            <div class="row clearfix">
                <div class="col-left">Nama:</div>
                <div class="col-right">{{ $transaksi->user->name }}</div>
            </div>
            
            <div class="row clearfix">
                <div class="col-left">Email:</div>
                <div class="col-right">{{ $transaksi->user->email }}</div>
            </div>
        </div>
        
        <div class="footer">
            Dokumen ini dicetak pada: {{ now()->format('d-m-Y H:i:s') }}<br>
            Dokumen ini dihasilkan secara otomatis dan tidak memerlukan tanda tangan.
        </div>
    </div>
</body>
</html>