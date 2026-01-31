@extends('layouts.app')

@section('title', 'Kerjakan Soal')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 py-8" x-data="questionData()">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header with Navigation -->
        <div class="bg-white rounded-2xl shadow-lg p-6 mb-8">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">{{ $course->title }}</h1>
                    <p class="text-gray-600">{{ $content->title }}</p>
                </div>
                <div class="flex items-center space-x-4">
                    @if($previousContent)
                        <a href="{{ route('user.courses.content', [$course->id, $previousContent->type . ':' . $previousContent->id]) }}" 
                           class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors duration-200">
                            <i class="fas fa-chevron-left mr-2"></i>
                            Previous
                        </a>
                    @endif
                    
                    <a href="{{ route('user.courses.learn', $course->id) }}" 
                       class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors duration-200">
                        <i class="fas fa-list mr-2"></i>
                        All Questions
                    </a>
                    
                    @if($nextContent)
                        <a href="{{ route('user.courses.content', [$course->id, $nextContent->type . ':' . $nextContent->id]) }}" 
                           class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors duration-200">
                            Next
                            <i class="fas fa-chevron-right ml-2"></i>
                        </a>
                    @endif
                </div>
            </div>
            
            <!-- Progress Indicator -->
            @php
                $allContents = $course->allContents();
                $currentIndex = $allContents->search(function ($item) use ($content) {
                    return $item->type === $content->type && $item->id === $content->id;
                });
                $progress = $allContents->count() > 0 ? round((($currentIndex + 1) / $allContents->count()) * 100) : 0;
            @endphp
            
            <div class="flex items-center justify-between text-sm text-gray-600 mb-2">
                <span>Question {{ $currentIndex + 1 }} of {{ $allContents->count() }}</span>
                <span>{{ $progress }}% Complete</span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-2">
                <div class="bg-gradient-to-r from-blue-500 to-indigo-600 h-2 rounded-full transition-all duration-500" 
                     style="width: {{ $progress }}%"></div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Question Navigator Sidebar -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-lg p-6 sticky top-8">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-map mr-2 text-blue-600"></i>
                        Quick Navigator
                    </h3>
                    
                    <div class="space-y-2 max-h-80 overflow-y-auto">
                        @foreach($allContents as $index => $navContent)
                            @php
                                $isCurrentContent = $navContent->type === $content->type && $navContent->id === $content->id;
                                $navUserAnswer = null;
                                if ($navContent->type === 'question') {
                                    $navUserAnswer = \App\Models\UserAnswer::where('user_id', auth()->id())
                                        ->where('content_type', 'question')
                                        ->where('content_id', $navContent->id)
                                        ->first();
                                }
                                $isNavAnswered = $navUserAnswer !== null;
                                $isNavQuestion = $navContent->type === 'question';
                            @endphp
                            
                            <a href="{{ route('user.courses.content', [$course->id, $navContent->type . ':' . $navContent->id]) }}" 
                               class="block p-3 rounded-lg border-2 transition-all duration-200
                                      @if($isCurrentContent)
                                          border-blue-500 bg-blue-100
                                      @elseif($isNavQuestion)
                                          @if($isNavAnswered)
                                              border-green-200 bg-green-50 hover:bg-green-100
                                          @else
                                              border-yellow-200 bg-yellow-50 hover:bg-yellow-100
                                          @endif
                                      @else
                                          border-gray-200 bg-gray-50 hover:bg-gray-100
                                      @endif">
                                
                                <div class="flex items-center space-x-3">
                                    <div class="flex-shrink-0">
                                        @if($isNavQuestion)
                                            @if($isNavAnswered)
                                                <div class="w-6 h-6 bg-green-500 rounded-full flex items-center justify-center">
                                                    <i class="fas fa-check text-white text-xs"></i>
                                                </div>
                                            @else
                                                <div class="w-6 h-6 bg-yellow-500 rounded-full flex items-center justify-center">
                                                    <span class="text-white text-xs font-bold">{{ $index + 1 }}</span>
                                                </div>
                                            @endif
                                        @else
                                            <div class="w-6 h-6 bg-blue-500 rounded-full flex items-center justify-center">
                                                <i class="fas fa-book text-white text-xs"></i>
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <div class="flex-1 min-w-0">
                                        <p class="text-xs font-medium text-gray-900 truncate">
                                            {{ Str::limit($navContent->title, 20) }}
                                        </p>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Main Content Area -->
            <div class="lg:col-span-3">
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                    <!-- Content Header -->
                    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 px-8 py-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <h2 class="text-2xl font-bold text-white mb-2">{{ $content->title }}</h2>
                                <div class="flex items-center space-x-4 text-blue-100">
                                    <span class="inline-flex items-center">
                                        @if($content->type === 'question')
                                            <i class="fas fa-question-circle mr-2"></i>
                                            Question
                                        @else
                                            <i class="fas fa-book mr-2"></i>
                                            Reading Material
                                        @endif
                                    </span>
                                    @if(isset($userAnswer))
                                        <span class="inline-flex items-center">
                                            <i class="fas fa-check-circle mr-2"></i>
                                            Answered
                                        </span>
                                    @endif
                                </div>
                            </div>
                            
                            @if($content->type === 'question')
                                <div class="text-right">
                                    <div class="text-blue-100 text-sm">Status</div>
                                    @if(isset($userAnswer))
                                        <div class="text-white text-lg font-semibold">
                                            @if($userAnswer->is_correct)
                                                <i class="fas fa-check-circle text-green-300 mr-1"></i>
                                                Correct
                                            @else
                                                <i class="fas fa-times-circle text-red-300 mr-1"></i>
                                                Incorrect
                                            @endif
                                        </div>
                                    @else
                                        <div class="text-yellow-300 text-lg font-semibold">
                                            <i class="fas fa-clock mr-1"></i>
                                            Pending
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Content Body -->
                    <div class="p-8">
                        <!-- Content Text -->
                        <div class="prose max-w-none mb-8">
                            <div class="text-gray-800 text-lg leading-relaxed">
                                {!! nl2br(e($content->content)) !!}
                            </div>
                        </div>

                        @if($content->isQuestion())
                            <!-- Question Form -->
                            <div class="bg-gray-50 rounded-xl p-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Your Answer:</h3>
                                
                                <form method="POST" action="{{ route('user.courses.answer', [$course->id, $content->type . ':' . $content->id]) }}" 
                                      x-on:submit="saveToLocalStorage">
                                    @csrf
                                    
                                    @if(is_array($content->options) && count($content->options))
                                        <!-- Multiple Choice -->
                                        <div class="space-y-3 mb-6">
                                            @foreach($content->options as $option)
                                                <label class="flex items-center p-4 border-2 rounded-lg cursor-pointer transition-all duration-200 hover:bg-white
                                                              @if(isset($userAnswer) && $userAnswer->answer == $option)
                                                                  border-blue-500 bg-blue-50
                                                              @else
                                                                  border-gray-200 hover:border-gray-300
                                                              @endif">
                                                    <input type="radio" 
                                                           name="answer" 
                                                           value="{{ $option }}" 
                                                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300"
                                                           x-model="selectedAnswer"
                                                           @if(isset($userAnswer) && $userAnswer->answer == $option) checked @endif>
                                                    <span class="ml-3 text-gray-900">{{ $option }}</span>
                                                </label>
                                            @endforeach
                                        </div>
                                    @else
                                        <!-- Text Input -->
                                        <div class="mb-6">
                                            <textarea name="answer" 
                                                      rows="4"
                                                      class="w-full border-2 border-gray-200 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                                                      placeholder="Type your answer here..."
                                                      x-model="textAnswer">{{ isset($userAnswer) ? $userAnswer->answer : '' }}</textarea>
                                        </div>
                                    @endif
                                    
                                    <!-- Action Buttons -->
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-4">
                                            @if(isset($userAnswer))
                                                <div class="flex items-center text-sm">
                                                    @if($userAnswer->is_correct)
                                                        <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                                        <span class="text-green-700">Correct answer! Well done.</span>
                                                    @else
                                                        <i class="fas fa-times-circle text-red-500 mr-2"></i>
                                                        <span class="text-red-700">Incorrect. Try again to improve your understanding.</span>
                                                    @endif
                                                </div>
                                            @endif
                                        </div>
                                        
                                        <div class="flex items-center space-x-3">
                                            <button type="button" 
                                                    x-on:click="clearAnswer"
                                                    class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors duration-200">
                                                <i class="fas fa-eraser mr-2"></i>
                                                Clear
                                            </button>
                                            
                                            <button type="submit" 
                                                    class="inline-flex items-center px-6 py-2 border border-transparent rounded-lg text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                                                <i class="fas fa-paper-plane mr-2"></i>
                                                Submit Answer
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        @else
                            <!-- Reading Material -->
                            <div class="bg-blue-50 border border-blue-200 rounded-xl p-6">
                                <div class="flex items-center">
                                    <i class="fas fa-info-circle text-blue-500 text-xl mr-3"></i>
                                    <div>
                                        <h4 class="text-blue-800 font-semibold">Reading Material</h4>
                                        <p class="text-blue-700 text-sm">This is educational content. Take your time to read and understand.</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Navigation Footer -->
                    <div class="bg-gray-50 px-8 py-4 border-t border-gray-200">
                        <div class="flex items-center justify-between">
                            <div>
                                @if($previousContent)
                                    <a href="{{ route('user.courses.content', [$course->id, $previousContent->type . ':' . $previousContent->id]) }}" 
                                       class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors duration-200">
                                        <i class="fas fa-chevron-left mr-2"></i>
                                        {{ Str::limit($previousContent->title, 20) }}
                                    </a>
                                @endif
                            </div>
                            
                            <div class="text-sm text-gray-500">
                                Question {{ $currentIndex + 1 }} of {{ $allContents->count() }}
                            </div>
                            
                            <div>
                                @if($nextContent)
                                    <a href="{{ route('user.courses.content', [$course->id, $nextContent->type . ':' . $nextContent->id]) }}" 
                                       class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors duration-200">
                                        {{ Str::limit($nextContent->title, 20) }}
                                        <i class="fas fa-chevron-right ml-2"></i>
                                    </a>
                                @else
                                    <a href="{{ route('user.courses.learn', $course->id) }}" 
                                       class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg text-sm font-medium text-white bg-green-600 hover:bg-green-700 transition-colors duration-200">
                                        <i class="fas fa-flag-checkered mr-2"></i>
                                        Complete Course
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function questionData() {
    return {
        selectedAnswer: @json(isset($userAnswer) && is_array($content->options) ? $userAnswer->answer : ''),
        textAnswer: @json(isset($userAnswer) && !is_array($content->options) ? $userAnswer->answer : ''),
        
        init() {
            // Load from localStorage if no saved answer
            const storageKey = `question_${{{ $content->id }}}_answer`;
            const savedAnswer = localStorage.getItem(storageKey);
            
            if (!@json(isset($userAnswer)) && savedAnswer) {
                if (@json(is_array($content->options))) {
                    this.selectedAnswer = savedAnswer;
                } else {
                    this.textAnswer = savedAnswer;
                }
            }
            
            // Auto-save to localStorage on input change
            this.$watch('selectedAnswer', (value) => {
                if (value) {
                    localStorage.setItem(storageKey, value);
                }
            });
            
            this.$watch('textAnswer', (value) => {
                if (value) {
                    localStorage.setItem(storageKey, value);
                }
            });
        },
        
        clearAnswer() {
            this.selectedAnswer = '';
            this.textAnswer = '';
            const storageKey = `question_${{{ $content->id }}}_answer`;
            localStorage.removeItem(storageKey);
        },
        
        saveToLocalStorage() {
            // Clear localStorage when submitting
            const storageKey = `question_${{{ $content->id }}}_answer`;
            localStorage.removeItem(storageKey);
        }
    }
}

// Auto-save functionality for forms
document.addEventListener('DOMContentLoaded', function() {
    // Save form data every 30 seconds
    setInterval(function() {
        const forms = document.querySelectorAll('form');
        forms.forEach(form => {
            const formData = new FormData(form);
            const answer = formData.get('answer');
            if (answer) {
                const contentId = {{ $content->id }};
                localStorage.setItem(`question_${contentId}_answer`, answer);
            }
        });
    }, 30000); // 30 seconds
});
</script>

@if(session('success'))
<div class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50" id="successMessage">
    <div class="flex items-center">
        <i class="fas fa-check-circle mr-2"></i>
        {{ session('success') }}
    </div>
</div>
@endif

@if(session('error'))
<div class="fixed bottom-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg z-50" id="errorMessage">
    <div class="flex items-center">
        <i class="fas fa-exclamation-circle mr-2"></i>
        {{ session('error') }}
    </div>
</div>
@endif

<script>
// Auto-hide messages after 5 seconds
setTimeout(function() {
    const successMessage = document.getElementById('successMessage');
    const errorMessage = document.getElementById('errorMessage');
    if (successMessage) successMessage.style.display = 'none';
    if (errorMessage) errorMessage.style.display = 'none';
}, 5000);
</script>
@endsection