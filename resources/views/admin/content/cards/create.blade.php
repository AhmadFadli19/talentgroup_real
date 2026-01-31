<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Card</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">
    <div class="max-w-2xl mx-auto bg-white p-6 rounded shadow">
        <h1 class="text-2xl font-bold mb-4">Tambah Card Baru</h1>

        <form action="{{ route('cards.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <!-- Judul -->
            <div>
                <label class="block font-medium">Judul</label>
                <input type="text" name="judul" class="w-full border p-2 rounded" required>
            </div>

            <!-- Harga -->
            <div>
                <label class="block font-medium">Harga</label>
                <input type="text" name="price" class="w-full border p-2 rounded">
            </div>

            <!-- Slug / View Name -->
            <div>
                <label class="block font-medium">Nama View (slug)</label>
                <input type="text" name="create_view" placeholder="htmldasar" class="w-full border p-2 rounded" required>
            </div>

            <!-- Sertifikat -->
            <div>
                <label class="block font-medium">Sertifikat</label>
                <select name="certificate" class="w-full border p-2 rounded" required>
                    <option value="tidak" selected>Tidak</option>
                    <option value="ya">Ya</option>
                </select>
            </div>

            <!-- Best Seller -->
            <div class="flex items-center space-x-2">
                <input type="checkbox" name="best_seller" id="best_seller" class="rounded">
                <label for="best_seller" class="font-medium">Best Seller</label>
            </div>

            <!-- Gambar -->
            <div>
                <label class="block font-medium">Gambar</label>
                <input type="file" name="image" accept="image/*" class="w-full border p-2 rounded" required>
            </div>

            <!-- Tombol Simpan -->
            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Simpan</button>
        </form>
    </div>
</body>
</html>
