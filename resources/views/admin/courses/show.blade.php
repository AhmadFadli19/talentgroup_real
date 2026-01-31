@extends('layouts.app')

@section('title', $course->title)

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <div class="flex items-center mb-4">
            <a href="{{ route('admin.courses.index') }}" class="text-blue-600 hover:text-blue-800 mr-4">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <h1 class="text-3xl font-bold text-gray-800">{{ $course->title }}</h1>
        </div>
        <div class="flex items-center space-x-4">
            <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full {{ $course->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                {{ $course->is_active ? 'Active' : 'Inactive' }}
            </span>
            <span class="text-gray-500">Created {{ $course->created_at->format('M d, Y') }}</span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Course Details -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Course Information</h2>
                
                @if($course->image)
                <div class="mb-6">
                    <img src="{{ Storage::url($course->image) }}" alt="{{ $course->title }}" class="w-full h-48 object-cover rounded-lg">
                </div>
                @endif

                <div class="mb-4">
                    <h3 class="text-lg font-medium text-gray-800 mb-2">Description</h3>
                    <p class="text-gray-600 leading-relaxed">{{ $course->description }}</p>
                </div>

                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div>
                        <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wider">Price</h4>
                        <p class="text-2xl font-bold text-green-600">Rp {{ number_format($course->price) }}</p>
                    </div>
                    <div>
                        <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wider">Enrollments</h4>
                        <p class="text-2xl font-bold text-blue-600">{{ $course->userCourses->count() }}</p>
                    </div>
                </div>

                <div class="mb-4">
                    <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-2">Created by</h4>
                    <p class="text-gray-800">{{ $course->creator->name }}</p>
                </div>
            </div>

            <!-- Course Content -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-semibold text-gray-800">Course Content</h2>
                    <a href="{{ route('admin.courses.contents.index', $course) }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                        Manage Content →
                    </a>
                </div>

                @if($course->contents->count() > 0)
                <div class="space-y-3">
                    @foreach($course->contents as $content)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div class="flex items-center">
                            <div class="w-8 h-8 rounded-full {{ $content->type === 'story' ? 'bg-blue-100 text-blue-600' : 'bg-green-100 text-green-600' }} flex items-center justify-center mr-3">
                                @if($content->type === 'story')
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                                @else
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                @endif
                            </div>
                            <div>
                                <p class="font-medium text-gray-800">{{ $content->title }}</p>
                                <p class="text-sm text-gray-500">{{ ucfirst($content->type) }} • Order: {{ $content->order }}</p>
                            </div>
                        </div>
                        <a href="{{ route('admin.courses.contents.show', [$course, $content]) }}" class="text-blue-600 hover:text-blue-800">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-8">
                    <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No content yet</h3>
                    <p class="text-gray-500 mb-4">Start building your course by adding content.</p>
                    <a href="{{ route('admin.courses.contents.create', $course) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                        Add Content
                    </a>
                </div>
                @endif
            </div>
        </div>

        <!-- Actions & Stats -->
        <div class="space-y-6">
            <!-- Quick Actions -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Quick Actions</h3>
                <div class="space-y-3">
                    <a href="{{ route('admin.courses.edit', $course) }}" class="flex items-center p-3 bg-yellow-50 rounded-lg hover:bg-yellow-100 transition-colors">
                        <svg class="w-5 h-5 text-yellow-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        <span class="text-yellow-700 font-medium">Edit Course</span>
                    </a>
                    <a href="{{ route('admin.courses.contents.index', $course) }}" class="flex items-center p-3 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
                        <svg class="w-5 h-5 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <span class="text-green-700 font-medium">Manage Content</span>
                    </a>
                    <a href="{{ route('admin.courses.results', $course) }}" class="flex items-center p-3 bg-purple-50 rounded-lg hover:bg-purple-100 transition-colors">
                        <svg class="w-5 h-5 text-purple-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        <span class="text-purple-700 font-medium">View Results</span>
                    </a>
                </div>
            </div>

            <!-- Enrolled Users -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Recent Enrollments</h3>
                @if($course->userCourses->count() > 0)
                <div class="space-y-3">
                    @foreach($course->userCourses->take(5) as $userCourse)
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center mr-3">
                                <span class="text-sm font-medium text-gray-600">{{ substr($userCourse->user->name, 0, 1) }}</span>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-800">{{ $userCourse->user->name }}</p>
                                <p class="text-xs text-gray-500">{{ $userCourse->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $userCourse->is_completed ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                            {{ $userCourse->is_completed ? 'Completed' : 'In Progress' }}
                        </span>
                    </div>
                    @endforeach
                </div>
                @if($course->userCourses->count() > 5)
                <div class="mt-4 pt-4 border-t border-gray-200">
                    <a href="{{ route('admin.courses.results', $course) }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                        View all enrollments →
                    </a>
                </div>
                @endif
                @else
                <p class="text-gray-500 text-sm">No enrollments yet</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection