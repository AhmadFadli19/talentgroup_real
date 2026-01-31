@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto px-4">
        <!-- Hero Section -->
        <div class="bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-lg p-8 sm:p-12 mb-12">
            <div class="text-center">
                <h1 class="text-3xl sm:text-4xl font-bold mb-4 break-words">
                    Selamat Datang di TalentGroup
                </h1>
                <p class="text-base sm:text-xl mb-6 sm:mb-8 max-w-xl mx-auto">
                    Platform pembelajaran online terbaik untuk mengembangkan skill Anda
                </p>
                @guest
                    <div class="flex flex-col sm:flex-row justify-center gap-4">
                        <a href="{{ route('register') }}"
                            class="bg-white text-blue-600 px-6 py-3 rounded-lg font-semibold hover:bg-gray-100 transition text-center">
                            Daftar Sekarang
                        </a>
                        <a href="{{ route('login') }}"
                            class="border-2 border-white text-white px-6 py-3 rounded-lg font-semibold hover:bg-white hover:text-blue-600 transition text-center">
                            Login
                        </a>
                        <a href="{{ route('bank.login') }}"
                            class="bg-yellow-500 text-white px-6 py-3 rounded-lg font-semibold hover:bg-yellow-600 transition text-center">
                            Bank Login
                        </a>
                    </div>
                @endguest
            </div>
        </div>

        <!-- Features Section -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8 mb-12">
            <div class="text-center p-6 bg-white shadow-md rounded-lg">
                <div class="text-blue-600 mb-4">
                    <svg class="w-12 h-12 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-2">Materi Berkualitas</h3>
                <p class="text-gray-600">Akses materi pembelajaran dari para ahli di bidangnya</p>
            </div>

            <div class="text-center p-6 bg-white shadow-md rounded-lg">
                <div class="text-blue-600 mb-4">
                    <svg class="w-12 h-12 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-2">Sistem Evaluasi</h3>
                <p class="text-gray-600">Uji kemampuan Anda dengan evaluasi real-time</p>
            </div>

            <div class="text-center p-6 bg-white shadow-md rounded-lg">
                <div class="text-blue-600 mb-4">
                    <svg class="w-12 h-12 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-2">Pembelajaran Cepat</h3>
                <p class="text-gray-600">Efisien & fleksibel untuk hasil maksimal</p>
            </div>
        </div>

        <!-- How It Works Section -->
        <div class="bg-white rounded-lg p-6 sm:p-8 mb-12">
            <h2 class="text-2xl sm:text-3xl font-bold text-center mb-8">Cara Kerja Platform</h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
                @foreach ([['title' => 'Daftar & Login', 'desc' => 'Buat akun dan masuk ke platform'], ['title' => 'Top Up Saldo', 'desc' => 'Isi saldo untuk membeli kursus'], ['title' => 'Beli Kursus', 'desc' => 'Pilih dan beli kursus yang diinginkan'], ['title' => 'Mulai Belajar', 'desc' => 'Akses materi dan kerjakan soal']] as $index => $step)
                    <div class="text-center">
                        <div class="bg-blue-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                            <span class="text-2xl font-bold text-blue-600">{{ $index + 1 }}</span>
                        </div>
                        <h3 class="font-semibold mb-2">{{ $step['title'] }}</h3>
                        <p class="text-gray-600 text-sm">{{ $step['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Button Explore -->
        @auth
            @if (auth()->user()->isUser())
                <div class="text-center mb-12">
                    <a href="{{ route('user.courses.index') }}"
                        class="bg-blue-600 text-white text-lg px-8 py-3 rounded-lg hover:bg-blue-700 transition">
                        Jelajahi Kursus
                    </a>
                </div>
            @endif
        @endauth
    </div>
@endsection
