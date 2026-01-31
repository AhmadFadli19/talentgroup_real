@extends('layouts.app')

@section('title', $content->title)

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <div class="flex items-center mb-4">
            <a href="{{ route('admin.courses.contents.index', $course) }}" class="text-blue-600 hover:text-blue-800 mr-4">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <h1 class="text-3xl font-bold text-gray-800">{{ $content->title }}</h1>
        </div>
        <div class="flex items-center space-x-4">
            <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full {{ $content->type === 'story' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                {{ ucfirst($content->type) }}
            </span>
            <span class="text-gray-500">Order: {{ $content->order }}</span>
            <span class="text-gray-500">Course: {{ $course->title }}</span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Content Details -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Content</h2>
                <div class="prose max-w-none">
                    <div class="whitespace-pre-wrap text-gray-700 leading-relaxed">{{ $content->content }}</div>
                </div>
            </div>

            @if($content->type === 'question')
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Question Options</h2>
                <div class="space-y-3">
                    @if($content->options)
                        @foreach($content->options as $index => $option)
                        <div class="flex items-center p-3 rounded-lg {{ $option === $content->correct_answer ? 'bg-green-50 border border-green-200' : 'bg-gray-50' }}">
                            <div class="w-8 h-8 rounded-full {{ $option === $content->correct_answer ? 'bg-green-100 text-green-600' : 'bg-gray-200 text-gray-600' }} flex items-center justify-center mr-3 font-medium">
                                {{ chr(65 + $index) }}
                            </div>
                            <span class="text-gray-800">{{ $option }}</span>
                            @if($option === $content->correct_answer)
                            <span class="ml-auto text-green-600 font-medium">
                                <svg class="w-5 h-5 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Correct Answer
                            </span>
                            @endif
                        </div>
                        @endforeach
                    @endif
                </div>
            </div>
            @endif
        </div>

        <!-- Actions & Info -->
        <div class="space-y-6">
            <!-- Quick Actions -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Quick Actions</h3>
                <div class="space-y-3">
                    <a href="{{ route('admin.courses.contents.edit', [$course, $content->type, $content->id]) }}" class="flex items-center p-3 bg-yellow-50 rounded-lg hover:bg-yellow-100 transition-colors">
                        <svg class="w-5 h-5 text-yellow-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        <span class="text-yellow-700 font-medium">Edit Content</span>
                    </a>
                    <a href="{{ route('admin.courses.contents.create', $course) }}" class="flex items-center p-3 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                        <svg class="w-5 h-5 text-blue-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        <span class="text-blue-700 font-medium">Add New Content</span>
                    </a>
                    <form action="{{ route('admin.courses.contents.destroy', [$course, $content->type, $content->id]) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this content?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full flex items-center p-3 bg-red-50 rounded-lg hover:bg-red-100 transition-colors">
                            <svg class="w-5 h-5 text-red-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            <span class="text-red-700 font-medium">Delete Content</span>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Content Info -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Content Information</h3>
                <div class="space-y-3">
                    <div>
                        <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wider">Type</h4>
                        <p class="text-gray-800 capitalize">{{ $content->type }}</p>
                    </div>
                    <div>
                        <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wider">Order</h4>
                        <p class="text-gray-800">{{ $content->order }}</p>
                    </div>
                    <div>
                        <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wider">Course</h4>
                        <p class="text-gray-800">{{ $course->title }}</p>
                    </div>
                    @if($content->type === 'question')
                    <div>
                        <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wider">Options Count</h4>
                        <p class="text-gray-800">{{ count($content->options ?? []) }}</p>
                    </div>
                    @endif
                    <div>
                        <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wider">Created</h4>
                        <p class="text-gray-800">{{ $content->created_at->format('M d, Y H:i') }}</p>
                    </div>
                    <div>
                        <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wider">Last Updated</h4>
                        <p class="text-gray-800">{{ $content->updated_at->format('M d, Y H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection