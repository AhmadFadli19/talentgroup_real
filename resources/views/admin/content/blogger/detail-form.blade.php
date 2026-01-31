<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Form - {{ $cardblogger->judul }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 p-6">
    <div class="max-w-3xl mx-auto bg-white p-6 rounded shadow">
        <h2 class="text-xl font-bold mb-4">Isi Detail Konten: {{ $cardblogger->judul }}</h2>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('slideblogger.detail.submit', $cardblogger->id) }}" enctype="multipart/form-data"
            class="space-y-4">
            @csrf

            <div>
                <label class="block mb-1 font-medium">Judul</label>
                <input type="text" name="judul" class="w-full border p-2 rounded" value="{{ old('judul') }}"
                    required>
            </div>
            {{-- 
      <div>
        <label class="block mb-1 font-medium">Gambar</label>
        <input type="file" name="image" class="w-full border p-2 rounded">
      </div> --}}

            <div>
                <label class="block mb-1 font-medium">Topik</label>
                <textarea name="topic" rows="3" class="w-full border p-2 rounded">{{ old('topic') }}</textarea>
            </div>

            <div>
                <label class="block mb-1 font-medium">URL Kelas</label>
                <input type="text" name="url_kelas" class="w-full border p-2 rounded" value="{{ old('url_kelas') }}">
            </div>

            <div>
                <label class="block mb-1 font-medium">Judul Deskripsi</label>
                <input type="text" name="judul_description" class="w-full border p-2 rounded"
                    value="{{ old('judul_description') }}">
            </div>

            <div>
                <label class="block mb-1 font-medium">Deskripsi Kelas</label>
                <textarea name="description_kelas" rows="4" class="w-full border p-2 rounded">{{ old('description_kelas') }}</textarea>
            </div>

            <div>
                <label class="block mb-1 font-medium">Target</label>
                <textarea name="target" rows="3" class="w-full border p-2 rounded">{{ old('target') }}</textarea>
            </div>

            <div>
                <label class="block mb-1 font-medium">Sasaran</label>
                <textarea name="sasaran" rows="3" class="w-full border p-2 rounded">{{ old('sasaran') }}</textarea>
            </div>

            <div class="flex gap-4">
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded">
                    Simpan Konten
                </button>
                <a href="{{ route('slideblogger.dynamic', $cardblogger->create_view) }}"
                    class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
                    Lihat Preview
                </a>
            </div>
        </form>
    </div>
</body>

</html>
