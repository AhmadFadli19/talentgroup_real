<form action="{{ route('bannercard.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
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
        <label class="block font-medium">Nama View (slug)</label>
        <input type="text" name="create_view" class="w-full border p-2 rounded">
    </div>
    <div>
        <label class="block font-medium">Kategori</label>
        <select name="category" class="w-full border p-2 rounded">
            <option value="freelance">freelance</option>
            <option value="mini_bootcamp">mini_bootcamp</option>
            <option value="ready_bootcamp">ready_bootcamp</option>
        </select>
    </div>
    <div>
        <label class="block font-medium">Gambar</label>
        <input type="file" name="image" class="w-full border p-2 rounded">
    </div>

    <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded">Simpan</button>
</form>
