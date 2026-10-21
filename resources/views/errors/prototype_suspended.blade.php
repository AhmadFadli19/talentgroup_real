<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prototype Dinonaktifkan | Flow Academy</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700;800&family=Fira+Code:wght@400;600&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background: #05080f;
            color: #f1f5f9;
            font-family: 'Outfit', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .cyber-card {
            background: #0c1220;
            border: 1px solid #1e2d40;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.6);
        }
    </style>
</head>
<body class="p-4">
    <div class="cyber-card max-w-md w-full rounded-2xl p-8 text-center border-t-4 border-t-amber-500">
        <div class="w-16 h-16 rounded-full bg-amber-500/10 text-amber-400 mx-auto flex items-center justify-center text-2xl mb-4 border border-amber-500/20">
            <i class="fas fa-pause-circle"></i>
        </div>
        <h1 class="text-2xl font-black text-white mb-2">Prototype Ditangguhkan</h1>
        <p class="text-sm text-slate-400 mb-6 leading-relaxed">
            {{ $message ?? 'Prototype ini dinonaktifkan sementara oleh Administrator karena sedang dalam peninjauan kebijakan.' }}
        </p>
        <div class="bg-black/40 rounded-xl p-3 border border-slate-800 text-xs font-mono text-amber-300 mb-6 break-all">
            /p/{{ $prototype->slug ?? 'unknown' }}
        </div>
        <a href="{{ url('/') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-slate-800 text-white font-bold text-xs uppercase tracking-wider hover:bg-slate-700 transition">
            <i class="fas fa-home"></i> Kembali ke Beranda
        </a>
    </div>
</body>
</html>
