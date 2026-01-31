@extends('layouts.app')

@section('title', $course->title)

@section('content')
    <div class="max-w-2xl mx-auto bg-white p-8 rounded shadow">
        <h1 class="text-2xl font-bold mb-4">{{ $course->title }}</h1>
        <p class="text-gray-700 mb-4">{{ $course->description }}</p>
        <p class="text-blue-700 font-bold mb-6">Rp {{ number_format($course->price, 0, ',', '.') }}</p>

        @if ($isEnrolled)
            <a href="{{ route('user.courses.learn', $course->id) }}"
                class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Mulai Belajar</a>
        @else
            <form method="POST" action="{{ route('user.courses.purchase', $course->id) }}">
                @csrf
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Beli Kursus</button>
            </form>
        @endif
    </div>
@endsection
