@extends('layouts.app')

@section('title', 'Kursus Saya')

@section('content')
    <div class="max-w-4xl mx-auto bg-white p-8 rounded shadow">
        <h1 class="text-2xl font-bold mb-6">Kursus Saya</h1>
        @if ($courses->isEmpty())
            <div class="text-center py-8">
                <div class="text-gray-400 text-6xl mb-4">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <p class="text-gray-600 text-lg mb-4">Anda belum memiliki kursus.</p>
                <a href="{{ route('user.courses.index') }}" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors">
                    Jelajahi Kursus
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach ($courses as $course)
                    <div class="border rounded-lg p-6 hover:shadow-lg transition-shadow">
                        <div class="flex justify-between items-start mb-4">
                            <div class="flex-1">
                                <h2 class="text-xl font-semibold mb-2">{{ $course->title }}</h2>
                                <p class="text-gray-600 mb-3">{{ $course->description }}</p>
                                
                                <!-- Progress Bar -->
                                <div class="mb-3">
                                    <div class="flex justify-between text-sm text-gray-600 mb-1">
                                        <span>Progress</span>
                                        <span>{{ $course->progress ?? 0 }}%</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $course->progress ?? 0 }}%"></div>
                                    </div>
                                </div>
                                
                                <!-- Status Badge -->
                                @if($course->is_completed ?? false)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <i class="fas fa-check-circle mr-1"></i>
                                        Selesai
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        <i class="fas fa-play-circle mr-1"></i>
                                        Sedang Belajar
                                    </span>
                                @endif
                                
                                <!-- Enrollment Date -->
                                @if($course->enrolled_at)
                                    <p class="text-xs text-gray-500 mt-2">
                                        Terdaftar: {{ $course->enrolled_at->format('d M Y') }}
                                    </p>
                                @endif
                            </div>
                        </div>
                        
                        <div class="flex space-x-3">
                            <a href="{{ route('user.courses.learn', $course->id) }}"
                                class="flex-1 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 text-center transition-colors">
                                @if($course->is_completed ?? false)
                                    Lihat Ulang
                                @else
                                    Lanjutkan Belajar
                                @endif
                            </a>
                            
                            @if($course->is_completed ?? false)
                                <a href="{{ route('user.courses.results', $course->id) }}"
                                    class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors">
                                    Hasil
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection