@extends('layouts.app')

@section('title', 'User Results - ' . $user->name)

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <div class="flex items-center mb-4">
            <a href="{{ route('admin.courses.results', $course) }}" class="text-blue-600 hover:text-blue-800 mr-4">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <h1 class="text-3xl font-bold text-gray-800">User Results</h1>
        </div>
        <p class="text-gray-600">{{ $user->name }} - {{ $course->title }}</p>
    </div>

    <!-- User Summary -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-800">Student</h3>
                    <p class="text-sm font-medium text-blue-600">{{ $user->name }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-800">Score</h3>
                    <p class="text-2xl font-bold text-green-600">{{ $score }}%</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-800">Correct</h3>
                    <p class="text-2xl font-bold text-yellow-600">{{ $correctAnswers }}/{{ $totalQuestions }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-800">Status</h3>
                    <p class="text-sm font-bold {{ $userCourse->is_completed ? 'text-green-600' : 'text-yellow-600' }}">
                        {{ $userCourse->is_completed ? 'Completed' : 'In Progress' }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- User Information -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">User Information</h3>
            <div class="space-y-3">
                <div>
                    <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wider">Name</h4>
                    <p class="text-gray-800">{{ $user->name }}</p>
                </div>
                <div>
                    <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wider">Email</h4>
                    <p class="text-gray-800">{{ $user->email }}</p>
                </div>
                <div>
                    <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wider">Enrolled Date</h4>
                    <p class="text-gray-800">{{ $userCourse->created_at->format('M d, Y H:i') }}</p>
                </div>
                @if($userCourse->is_completed)
                <div>
                    <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wider">Completed Date</h4>
                    <p class="text-gray-800">{{ $userCourse->updated_at->format('M d, Y H:i') }}</p>
                </div>
                @endif
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Course Information</h3>
            <div class="space-y-3">
                <div>
                    <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wider">Course Title</h4>
                    <p class="text-gray-800">{{ $course->title }}</p>
                </div>
                <div>
                    <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wider">Total Questions</h4>
                    <p class="text-gray-800">{{ $totalQuestions }}</p>
                </div>
                <div>
                    <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wider">Course Price</h4>
                    <p class="text-gray-800">Rp {{ number_format($course->price) }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Performance Summary</h3>
            <div class="space-y-3">
                <div>
                    <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wider">Overall Score</h4>
                    <div class="flex items-center">
                        <div class="w-full bg-gray-200 rounded-full h-3 mr-3">
                            <div class="bg-gradient-to-r from-red-500 via-yellow-500 to-green-500 h-3 rounded-full" style="width: {{ $score }}%"></div>
                        </div>
                        <span class="text-lg font-bold {{ $score >= 70 ? 'text-green-600' : ($score >= 50 ? 'text-yellow-600' : 'text-red-600') }}">{{ $score }}%</span>
                    </div>
                </div>
                <div>
                    <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wider">Grade</h4>
                    <p class="text-2xl font-bold {{ $score >= 80 ? 'text-green-600' : ($score >= 70 ? 'text-blue-600' : ($score >= 60 ? 'text-yellow-600' : 'text-red-600')) }}">
                        @if($score >= 80) A
                        @elseif($score >= 70) B
                        @elseif($score >= 60) C
                        @elseif($score >= 50) D
                        @else F
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Detailed Answers -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200">
        <h2 class="text-xl font-semibold text-gray-800">Detailed Answers</h2>
    </div>
    
    @if($answers->count() > 0)
    <div class="divide-y divide-gray-200">
        @foreach($answers as $answer)
        <div class="p-6">
            <div class="flex items-start justify-between mb-4">
                <div class="flex-1">
                    <!-- Fix: Use courseQuestion instead of courseContent -->
                    <h3 class="text-lg font-medium text-gray-800 mb-2">{{ $answer->courseQuestion->title }}</h3>
                    <div class="text-gray-600 mb-4">{{ $answer->courseQuestion->content }}</div>
                    
                    @if($answer->courseQuestion->options)
                    <div class="mb-4">
                        <h4 class="text-sm font-medium text-gray-700 mb-2">Available Options:</h4>
                        <div class="space-y-2">
                            @foreach($answer->courseQuestion->options as $index => $option)
                            <div class="flex items-center p-2 rounded {{ $option === $answer->courseQuestion->correct_answer ? 'bg-green-50' : 'bg-gray-50' }}">
                                <span class="w-6 h-6 rounded-full {{ $option === $answer->courseQuestion->correct_answer ? 'bg-green-100 text-green-600' : 'bg-gray-200 text-gray-600' }} flex items-center justify-center text-sm font-medium mr-3">
                                    {{ chr(65 + $index) }}
                                </span>
                                <span class="text-gray-800">{{ $option }}</span>
                                @if($option === $answer->courseQuestion->correct_answer)
                                <span class="ml-auto text-green-600 text-sm font-medium">Correct</span>
                                @endif
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
                <div class="ml-6 text-right">
                    <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full {{ $answer->is_correct ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $answer->is_correct ? 'Correct' : 'Incorrect' }}
                    </span>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-1">User's Answer</h4>
                    <p class="text-gray-800 font-medium">{{ $answer->answer }}</p>
                </div>
                <div>
                    <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-1">Correct Answer</h4>
                    <p class="text-green-600 font-medium">{{ $answer->courseQuestion->correct_answer }}</p>
                </div>
            </div>
            
            <div class="mt-4 text-sm text-gray-500">
                Answered on {{ $answer->created_at->format('M d, Y H:i') }}
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="px-6 py-8 text-center">
        <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <h3 class="text-lg font-medium text-gray-900 mb-2">No answers submitted</h3>
        <p class="text-gray-500">This user hasn't answered any questions yet.</p>
    </div>
    @endif
</div>
</div>
@endsection