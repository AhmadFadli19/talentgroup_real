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

        <form action="{{ route('slideblogger.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div>
                <label class="block font-medium">Judul</label>
                <input type="text" name="judul" class="w-full border p-2 rounded" required>
            </div>
            <div>
                <label class="block font-medium">Blog Author</label>
                <input type="text" name="blog_author" class="w-full border p-2 rounded">
            </div>
            <div>
                <label class="block font-medium">Description</label>
                <input type="text" name="description" class="w-full border p-2 rounded">
            </div>

            <div>
                <label class="block font-medium">Gambar</label>
                <input type="file" name="image" class="w-full border p-2 rounded">
            </div>

            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded">Simpan</button>
        </form>
    </div>
</body>
</html>
