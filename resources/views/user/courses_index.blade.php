@extends('layouts.app')

@section('title', 'Daftar Kursus')

@section('content')
    <div class="max-w-4xl mx-auto bg-white p-8 rounded shadow">
        <h1 class="text-2xl font-bold mb-6">Daftar Kursus</h1>
        @if ($courses->isEmpty())
            <p class="text-gray-600">Belum ada kursus tersedia.</p>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach ($courses as $course)
                    <div class="border rounded p-4 flex flex-col justify-between">
                        <div>
                            <h2 class="text-lg font-semibold mb-2">{{ $course->title }}</h2>
                            <p class="text-gray-600 mb-2">{{ $course->description }}</p>
                            @if ($course->price < 1)
                            <p class="text-green-400 font-bold mb-4 mt-12 px-2 py-1 rounded-md flex justify-end">GRATIS</p>
                            @else
                            <p class="text-blue-700 font-bold mb-4 mt-12 px-2 py-1 rounded-md flex justify-end">Rp {{ number_format($course->price, 0, ',', '.') }}</p>
                            @endif
                        </div>
                        <a href="{{ route('user.courses.show', $course->id) }}"
                            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-center">Detail</a>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
