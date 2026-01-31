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

        <form action="{{ route('kolaborasi.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <div>
                <label class="block font-medium">Judul</label>
                <input type="text" name="judul" class="w-full border p-2 rounded" required>
            </div>

            <div>
                <label class="block font-medium">Deskripsi</label>
                <input type="text" name="description" class="w-full border p-2 rounded">
            </div>

            <div>
                <label class="block font-medium">Nama View (Slug)</label>
                <input type="text" name="create_view" class="w-full border p-2 rounded" required>
            </div>

            <div>
                <label class="block font-medium">Kategori</label>
                <select name="category" class="w-full border p-2 rounded">
                    <option value="Upbanner">Upbanner</option>
                    <option value="Downbanner">Downbanner</option>
                </select>
            </div>

            <div>
                <label class="block font-medium">Gambar</label>
                <input type="file" name="image" class="w-full border p-2 rounded" required>
            </div>

            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                Simpan
            </button>
        </form>
    </div>
</body>
</html>
