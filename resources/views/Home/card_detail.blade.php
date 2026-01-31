<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $card->title }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="max-w-4xl mx-auto p-6">
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if(session('warning'))
            <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded mb-4">
                {{ session('warning') }}
            </div>
        @endif

        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <!-- Header dengan gambar -->
            <div class="relative h-64 bg-gradient-to-r from-blue-500 to-purple-600">
                @if($card->image)
                    <img src="{{ asset('storage/' . $card->image) }}" 
                         alt="{{ $card->title }}" 
                         class="w-full h-full object-cover opacity-80">
                @endif
                <div class="absolute inset-0 bg-black bg-opacity-30 flex items-center justify-center">
                    <h1 class="text-3xl font-bold text-white text-center">{{ $card->title }}</h1>
                </div>
                
                <!-- Badges -->
                <div class="absolute top-4 right-4 flex gap-2">
                    @if($card->best_seller)
                        <span class="bg-red-500 text-white px-3 py-1 rounded-full text-sm font-semibold">
                            Best Seller
                        </span>
                    @endif
                    @if($card->certificate == 'ya')
                        <span class="bg-green-500 text-white px-3 py-1 rounded-full text-sm font-semibold">
                            Sertifikat
                        </span>
                    @endif
                </div>
            </div>

            <!-- Content -->
            <div class="p-8">
                <div class="grid md:grid-cols-2 gap-8">
                    <!-- Detail Kelas -->
                    <div>
                        <h2 class="text-2xl font-bold mb-4 text-gray-800">{{ $card->detail->judul_kelas }}</h2>
                        
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold mb-2 text-gray-700">Deskripsi Kelas</h3>
                            <p class="text-gray-600 leading-relaxed">{{ $card->detail->deskripsi }}</p>
                        </div>

                        <div class="mb-6">
                            <h3 class="text-lg font-semibold mb-2 text-gray-700">Jumlah Materi</h3>
                            <div class="flex items-center">
                                <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full font-semibold">
                                    {{ $card->detail->jumlah_materi }} Materi
                                </span>
                            </div>
                        </div>

                        @if($card->price)
                            <div class="mb-6">
                                <h3 class="text-lg font-semibold mb-2 text-gray-700">Harga</h3>
                                <p class="text-2xl font-bold text-green-600">{{ $card->price }}</p>
                            </div>
                        @endif
                    </div>

                    <!-- Materi dan Persiapan -->
                    <div>
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold mb-2 text-gray-700">Materi Yang Akan Dipelajari</h3>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <p class="text-gray-600 whitespace-pre-line">{{ $card->detail->materi }}</p>
                            </div>
                        </div>

                        <div class="mb-6">
                            <h3 class="text-lg font-semibold mb-2 text-gray-700">Persiapan Kelas</h3>
                            <div class="bg-yellow-50 p-4 rounded-lg">
                                <p class="text-gray-600 whitespace-pre-line">{{ $card->detail->persiapan }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="mt-8 flex gap-4 justify-center">
                    @if($card->buy_link)
                        <a href="{{ $card->buy_link }}" 
                           target="_blank"
                           class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-semibold transition duration-200">
                            Beli Sekarang
                        </a>
                    @endif
                    
                    <a href="{{ route('cards.detail.form', $card->id) }}" 
                       class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold transition duration-200">
                        Edit Detail
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>