@extends('layouts.app')

@section('title', 'Materi: ' . $course->title)

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Course Header -->
        <div class="bg-white rounded-2xl shadow-lg p-6 mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $course->title }}</h1>
                    <p class="text-gray-600">{{ $course->description }}</p>
                </div>
                <div class="text-right">
                    <div class="text-sm text-gray-500 mb-1">Progress</div>
                    <div class="text-2xl font-bold text-blue-600">
                        {{ $contents->count() > 0 ? round((count($userAnswers) / $contents->where('type', 'question')->count()) * 100) : 0 }}%
                    </div>
                </div>
            </div>
            
            <!-- Progress Bar -->
            <div class="mt-4">
                <div class="bg-gray-200 rounded-full h-3">
                    <div class="bg-gradient-to-r from-blue-500 to-indigo-600 h-3 rounded-full transition-all duration-500" 
                         style="width: {{ $contents->count() > 0 ? round((count($userAnswers) / $contents->where('type', 'question')->count()) * 100) : 0 }}%"></div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Question Navigator -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-lg p-6 sticky top-8">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-list-ol mr-2 text-blue-600"></i>
                        Question Navigator
                    </h2>
                    
                    <div class="space-y-2 max-h-96 overflow-y-auto">
                        @foreach($contents as $index => $content)
                            @php
                                $isAnswered = in_array($content->id, $userAnswers);
                                $isQuestion = $content->type === 'question';
                            @endphp
                            
                            <div class="relative">
                                <a href="{{ route('user.courses.content', [$course->id, $content->type . ':' . $content->id]) }}" 
                                   class="block p-3 rounded-lg border-2 transition-all duration-200 hover:shadow-md
                                          @if($isQuestion)
                                              @if($isAnswered)
                                                  border-green-200 bg-green-50 hover:bg-green-100
                                              @else
                                                  border-yellow-200 bg-yellow-50 hover:bg-yellow-100
                                              @endif
                                          @else
                                              border-blue-200 bg-blue-50 hover:bg-blue-100
                                          @endif">
                                    
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-3">
                                            <div class="flex-shrink-0">
                                                @if($isQuestion)
                                                    @if($isAnswered)
                                                        <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                                                            <i class="fas fa-check text-white text-sm"></i>
                                                        </div>
                                                    @else
                                                        <div class="w-8 h-8 bg-yellow-500 rounded-full flex items-center justify-center">
                                                            <span class="text-white text-sm font-bold">{{ $index + 1 }}</span>
                                                        </div>
                                                    @endif
                                                @else
                                                    <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center">
                                                        <i class="fas fa-book text-white text-sm"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-medium text-gray-900 truncate">
                                                    {{ $content->title }}
                                                </p>
                                                <p class="text-xs text-gray-500">
                                                    @if($isQuestion)
                                                        @if($isAnswered)
                                                            <span class="text-green-600">✓ Completed</span>
                                                        @else
                                                            <span class="text-yellow-600">⚠ Required</span>
                                                        @endif
                                                    @else
                                                        <span class="text-blue-600">📖 Material</span>
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                        
                                        <div class="flex-shrink-0">
                                            <i class="fas fa-chevron-right text-gray-400"></i>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                    
                    <!-- Legend -->
                    <div class="mt-6 pt-4 border-t border-gray-200">
                        <h3 class="text-sm font-medium text-gray-700 mb-3">Legend:</h3>
                        <div class="space-y-2 text-xs">
                            <div class="flex items-center space-x-2">
                                <div class="w-4 h-4 bg-green-500 rounded-full"></div>
                                <span class="text-gray-600">Completed</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <div class="w-4 h-4 bg-yellow-500 rounded-full"></div>
                                <span class="text-gray-600">Required</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <div class="w-4 h-4 bg-blue-500 rounded-full"></div>
                                <span class="text-gray-600">Material</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content Area -->
            <div class="lg:col-span-3">
                @if($contents->isEmpty())
                    <div class="bg-white rounded-2xl shadow-lg p-12 text-center">
                        <i class="fas fa-book-open text-gray-400 text-6xl mb-4"></i>
                        <h3 class="text-xl font-semibold text-gray-700 mb-2">No Content Available</h3>
                        <p class="text-gray-500">This course doesn't have any content yet. Please check back later.</p>
                    </div>
                @else
                    <!-- Quick Stats -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                        <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-blue-500">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-book text-blue-500 text-2xl"></i>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-600">Total Materials</p>
                                    <p class="text-2xl font-bold text-gray-900">{{ $contents->where('type', 'story')->count() }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-yellow-500">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-question-circle text-yellow-500 text-2xl"></i>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-600">Total Questions</p>
                                    <p class="text-2xl font-bold text-gray-900">{{ $contents->where('type', 'question')->count() }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-green-500">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-check-circle text-green-500 text-2xl"></i>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-600">Completed</p>
                                    <p class="text-2xl font-bold text-gray-900">{{ count($userAnswers) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Content List -->
                    <div class="space-y-6">
                        @foreach($contents as $index => $content)
                            @php
                                $isAnswered = in_array($content->id, $userAnswers);
                                $isQuestion = $content->type === 'question';
                            @endphp
                            
                            <div class="bg-white rounded-2xl shadow-lg overflow-hidden transition-all duration-200 hover:shadow-xl">
                                <div class="p-6">
                                    <div class="flex items-start justify-between">
                                        <div class="flex items-start space-x-4 flex-1">
                                            <!-- Status Icon -->
                                            <div class="flex-shrink-0 mt-1">
                                                @if($isQuestion)
                                                    @if($isAnswered)
                                                        <div class="w-12 h-12 bg-green-500 rounded-full flex items-center justify-center">
                                                            <i class="fas fa-check text-white text-lg"></i>
                                                        </div>
                                                    @else
                                                        <div class="w-12 h-12 bg-yellow-500 rounded-full flex items-center justify-center">
                                                            <span class="text-white text-lg font-bold">{{ $index + 1 }}</span>
                                                        </div>
                                                    @endif
                                                @else
                                                    <div class="w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center">
                                                        <i class="fas fa-book text-white text-lg"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            
                                            <!-- Content Info -->
                                            <div class="flex-1">
                                                <div class="flex items-center space-x-3 mb-2">
                                                    <h3 class="text-xl font-semibold text-gray-900">{{ $content->title }}</h3>
                                                    
                                                    @if($isQuestion)
                                                        @if($isAnswered)
                                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                                <i class="fas fa-check mr-1"></i>
                                                                Completed
                                                            </span>
                                                        @else
                                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                                <i class="fas fa-exclamation-triangle mr-1"></i>
                                                                Required
                                                            </span>
                                                        @endif
                                                    @else
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                            <i class="fas fa-book mr-1"></i>
                                                            Material
                                                        </span>
                                                    @endif
                                                </div>
                                                
                                                @if($content->content)
                                                    <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                                                        {{ Str::limit(strip_tags($content->content), 150) }}
                                                    </p>
                                                @endif
                                                
                                                <div class="flex items-center text-xs text-gray-500 space-x-4">
                                                    <span>
                                                        <i class="fas fa-clock mr-1"></i>
                                                        {{ $content->type === 'question' ? 'Question' : 'Reading Material' }}
                                                    </span>
                                                    @if($isQuestion && $isAnswered)
                                                        <span class="text-green-600">
                                                            <i class="fas fa-check-double mr-1"></i>
                                                            Answered
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Action Button -->
                                        <div class="flex-shrink-0 ml-4">
                                            <a href="{{ route('user.courses.content', [$course->id, $content->type . ':' . $content->id]) }}" 
                                               class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white
                                                      @if($isQuestion)
                                                          @if($isAnswered)
                                                              bg-green-600 hover:bg-green-700
                                                          @else
                                                              bg-yellow-600 hover:bg-yellow-700
                                                          @endif
                                                      @else
                                                          bg-blue-600 hover:bg-blue-700
                                                      @endif
                                                      focus:outline-none focus:ring-2 focus:ring-offset-2 transition-colors duration-200">
                                                @if($isQuestion)
                                                    @if($isAnswered)
                                                        <i class="fas fa-eye mr-2"></i>
                                                        Review
                                                    @else
                                                        <i class="fas fa-play mr-2"></i>
                                                        Start
                                                    @endif
                                                @else
                                                    <i class="fas fa-book-open mr-2"></i>
                                                    Read
                                                @endif
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Course Completion Status -->
                    @if($contents->where('type', 'question')->count() > 0)
                        <div class="mt-8 bg-white rounded-2xl shadow-lg p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Course Completion</h3>
                            
                            @php
                                $totalQuestions = $contents->where('type', 'question')->count();
                                $answeredQuestions = count($userAnswers);
                                $completionPercentage = $totalQuestions > 0 ? round(($answeredQuestions / $totalQuestions) * 100) : 0;
                            @endphp
                            
                            <div class="flex items-center justify-between mb-4">
                                <span class="text-sm text-gray-600">
                                    {{ $answeredQuestions }} of {{ $totalQuestions }} questions completed
                                </span>
                                <span class="text-sm font-medium text-gray-900">{{ $completionPercentage }}%</span>
                            </div>
                            
                            <div class="w-full bg-gray-200 rounded-full h-3 mb-4">
                                <div class="bg-gradient-to-r from-blue-500 to-indigo-600 h-3 rounded-full transition-all duration-500" 
                                     style="width: {{ $completionPercentage }}%"></div>
                            </div>
                            
                            @if($completionPercentage === 100)
                                <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                                    <div class="flex items-center">
                                        <i class="fas fa-trophy text-green-500 text-xl mr-3"></i>
                                        <div>
                                            <h4 class="text-green-800 font-semibold">Congratulations!</h4>
                                            <p class="text-green-700 text-sm">You have completed all questions in this course.</p>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                    <div class="flex items-center">
                                        <i class="fas fa-info-circle text-blue-500 text-xl mr-3"></i>
                                        <div>
                                            <h4 class="text-blue-800 font-semibold">Keep Going!</h4>
                                            <p class="text-blue-700 text-sm">Complete all questions to finish this course.</p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
@endsection