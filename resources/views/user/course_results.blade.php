@extends('layouts.app')

@section('title', 'Course Results - ' . $course->title)

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 py-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="bg-white rounded-2xl shadow-lg p-8 mb-8">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $course->title }}</h1>
                    <p class="text-gray-600">Course Results & Performance Analysis</p>
                </div>
                <div class="text-right">
                    <div class="text-sm text-gray-500 mb-1">Overall Score</div>
                    <div class="text-4xl font-bold text-blue-600">{{ $score }}%</div>
                </div>
            </div>
            
            <!-- Progress Bar -->
            <div class="mb-6">
                <div class="flex items-center justify-between text-sm text-gray-600 mb-2">
                    <span>Course Completion</span>
                    <span>{{ $answeredQuestions }} / {{ $totalQuestions }} Questions</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-4">
                    <div class="bg-gradient-to-r from-blue-500 to-indigo-600 h-4 rounded-full transition-all duration-500" 
                         style="width: {{ $totalQuestions > 0 ? round(($answeredQuestions / $totalQuestions) * 100) : 0 }}%"></div>
                </div>
            </div>
            
            <!-- Quick Actions -->
            <div class="flex items-center space-x-4">
                <a href="{{ route('user.courses.learn', $course->id) }}" 
                   class="inline-flex items-center px-6 py-3 border border-transparent rounded-lg text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 transition-colors duration-200">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Back to Course
                </a>
                
                @if($answeredQuestions < $totalQuestions)
                    <a href="{{ route('user.courses.learn', $course->id) }}" 
                       class="inline-flex items-center px-6 py-3 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors duration-200">
                        <i class="fas fa-play mr-2"></i>
                        Continue Learning
                    </a>
                @endif
                
                <button onclick="window.print()" 
                        class="inline-flex items-center px-6 py-3 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors duration-200">
                    <i class="fas fa-print mr-2"></i>
                    Print Results
                </button>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-blue-500">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-question-circle text-blue-500 text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Questions</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $totalQuestions }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-yellow-500">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-clipboard-check text-yellow-500 text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Answered</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $answeredQuestions }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-green-500">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-check-circle text-green-500 text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Correct Answers</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $correctAnswers }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-purple-500">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-star text-purple-500 text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Points</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $totalPoints }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Performance Analysis -->
        <div class="bg-white rounded-2xl shadow-lg p-8 mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                <i class="fas fa-chart-line mr-3 text-blue-600"></i>
                Performance Analysis
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Score Breakdown -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Score Breakdown</h3>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600">Accuracy Rate</span>
                            <div class="flex items-center">
                                <div class="w-32 bg-gray-200 rounded-full h-2 mr-3">
                                    <div class="bg-green-500 h-2 rounded-full" style="width: {{ $totalQuestions > 0 ? round(($correctAnswers / $totalQuestions) * 100) : 0 }}%"></div>
                                </div>
                                <span class="font-semibold">{{ $totalQuestions > 0 ? round(($correctAnswers / $totalQuestions) * 100) : 0 }}%</span>
                            </div>
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600">Completion Rate</span>
                            <div class="flex items-center">
                                <div class="w-32 bg-gray-200 rounded-full h-2 mr-3">
                                    <div class="bg-blue-500 h-2 rounded-full" style="width: {{ $totalQuestions > 0 ? round(($answeredQuestions / $totalQuestions) * 100) : 0 }}%"></div>
                                </div>
                                <span class="font-semibold">{{ $totalQuestions > 0 ? round(($answeredQuestions / $totalQuestions) * 100) : 0 }}%</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Grade Assessment -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Grade Assessment</h3>
                    <div class="text-center">
                        @php
                            $grade = 'F';
                            $gradeColor = 'text-red-600';
                            $gradeBg = 'bg-red-100';
                            
                            if ($score >= 90) {
                                $grade = 'A';
                                $gradeColor = 'text-green-600';
                                $gradeBg = 'bg-green-100';
                            } elseif ($score >= 80) {
                                $grade = 'B';
                                $gradeColor = 'text-blue-600';
                                $gradeBg = 'bg-blue-100';
                            } elseif ($score >= 70) {
                                $grade = 'C';
                                $gradeColor = 'text-yellow-600';
                                $gradeBg = 'bg-yellow-100';
                            } elseif ($score >= 60) {
                                $grade = 'D';
                                $gradeColor = 'text-orange-600';
                                $gradeBg = 'bg-orange-100';
                            }
                        @endphp
                        
                        <div class="inline-flex items-center justify-center w-24 h-24 rounded-full {{ $gradeBg }} mb-4">
                            <span class="text-4xl font-bold {{ $gradeColor }}">{{ $grade }}</span>
                        </div>
                        
                        <p class="text-lg font-semibold text-gray-900">
                            @if($score >= 90)
                                Excellent Work!
                            @elseif($score >= 80)
                                Good Job!
                            @elseif($score >= 70)
                                Well Done!
                            @elseif($score >= 60)
                                Keep Practicing!
                            @else
                                Need Improvement
                            @endif
                        </p>
                        
                        <p class="text-gray-600 mt-2">
                            @if($score >= 90)
                                Outstanding performance! You've mastered this course.
                            @elseif($score >= 80)
                                Great work! You have a solid understanding of the material.
                            @elseif($score >= 70)
                                Good effort! Consider reviewing some topics for better understanding.
                            @elseif($score >= 60)
                                You're on the right track. More practice will help improve your score.
                            @else
                                Don't give up! Review the material and try again.
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detailed Results -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <div class="p-8 border-b border-gray-200">
                <h2 class="text-2xl font-bold text-gray-900 flex items-center">
                    <i class="fas fa-list-alt mr-3 text-blue-600"></i>
                    Detailed Question Results
                </h2>
            </div>
            
            <div class="p-8">
                @if($answers->isEmpty())
                    <div class="text-center py-12">
                        <i class="fas fa-clipboard-list text-gray-400 text-6xl mb-4"></i>
                        <h3 class="text-xl font-semibold text-gray-700 mb-2">No Answers Yet</h3>
                        <p class="text-gray-500">You haven't answered any questions in this course yet.</p>
                        <a href="{{ route('user.courses.learn', $course->id) }}" 
                           class="inline-flex items-center mt-4 px-6 py-3 border border-transparent rounded-lg text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 transition-colors duration-200">
                            <i class="fas fa-play mr-2"></i>
                            Start Learning
                        </a>
                    </div>
                @else
                    <div class="space-y-6">
                        @foreach($answers as $answer)
                            <div class="border border-gray-200 rounded-xl p-6 hover:shadow-md transition-shadow duration-200">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <div class="flex items-center space-x-3 mb-3">
                                            <div class="flex-shrink-0">
                                                @if($answer->is_correct)
                                                    <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center">
                                                        <i class="fas fa-check text-white"></i>
                                                    </div>
                                                @else
                                                    <div class="w-10 h-10 bg-red-500 rounded-full flex items-center justify-center">
                                                        <i class="fas fa-times text-white"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            
                                            <div class="flex-1">
                                                @if ($answer->courseQuestion)
                                                    <h3 class="text-lg font-semibold text-gray-900">{{ $answer->courseQuestion->title }}</h3>
                                                @endif
                                                <div class="flex items-center space-x-4 text-sm text-gray-500">
                                                    <span>
                                                        @if($answer->is_correct)
                                                            <i class="fas fa-check-circle text-green-500 mr-1"></i>
                                                            Correct
                                                        @else
                                                            <i class="fas fa-times-circle text-red-500 mr-1"></i>
                                                            Incorrect
                                                        @endif
                                                    </span>
                                                    <span>{{ $answer->points }} points</span>
                                                    <span>{{ $answer->created_at->format('M d, Y H:i') }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Question Content -->
                                        <div class="bg-gray-50 rounded-lg p-4 mb-4">
                                            @if ($answer->courseQuestion)
                                            <p class="text-gray-800 mb-3">{{ $answer->courseQuestion->content }}</p>
                                            
                                            @if(is_array($answer->courseQuestion->options))
                                                <div class="space-y-2">
                                                    @foreach($answer->courseQuestion->options as $option)
                                                        <div class="flex items-center p-2 rounded
                                                                    @if($option === $answer->courseQuestion->correct_answer)
                                                                        bg-green-100 border border-green-300
                                                                    @elseif($option === $answer->answer && !$answer->is_correct)
                                                                        bg-red-100 border border-red-300
                                                                    @else
                                                                        bg-white border border-gray-200
                                                                    @endif">
                                                            @if($option === $answer->answer)
                                                                <i class="fas fa-dot-circle mr-2 text-blue-600"></i>
                                                            @else
                                                                <i class="far fa-circle mr-2 text-gray-400"></i>
                                                            @endif
                                                            <span class="text-gray-900">{{ $option }}</span>
                                                            
                                                            @if($option === $answer->courseQuestion->correct_answer)
                                                                <i class="fas fa-check text-green-600 ml-auto"></i>
                                                            @elseif($option === $answer->answer && !$answer->is_correct)
                                                                <i class="fas fa-times text-red-600 ml-auto"></i>
                                                            @endif
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @else
                                                <div class="space-y-3">
                                                    <div>
                                                        <label class="block text-sm font-medium text-gray-700 mb-1">Your Answer:</label>
                                                        <div class="p-3 bg-white border border-gray-200 rounded">{{ $answer->answer }}</div>
                                                    </div>
                                                    
                                                    @if($answer->courseQuestion->correct_answer)
                                                        <div>
                                                            <label class="block text-sm font-medium text-gray-700 mb-1">Correct Answer:</label>
                                                            <div class="p-3 bg-green-50 border border-green-200 rounded">{{ $answer->courseQuestion->correct_answer }}</div>
                                                        </div>
                                                    @endif
                                                </div>
                                            @endif
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <div class="flex-shrink-0 ml-6">
                                        @if ($answer->courseQuestion)
                                        <a href="{{ route('user.courses.content', [$course->id, 'question:' . $answer->courseQuestion->id]) }}" 
                                           class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors duration-200">
                                            <i class="fas fa-eye mr-2"></i>
                                            Review
                                        </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <!-- Course Completion Status -->
        @if($answeredQuestions === $totalQuestions && $totalQuestions > 0)
            <div class="mt-8 bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 rounded-2xl p-8">
                <div class="text-center">
                    <i class="fas fa-trophy text-green-500 text-6xl mb-4"></i>
                    <h3 class="text-2xl font-bold text-green-800 mb-2">Course Completed!</h3>
                    <p class="text-green-700 mb-6">Congratulations! You have successfully completed all questions in this course.</p>
                    
                    <div class="flex items-center justify-center space-x-4">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-green-800">{{ $score }}%</div>
                            <div class="text-sm text-green-600">Final Score</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-green-800">{{ $correctAnswers }}/{{ $totalQuestions }}</div>
                            <div class="text-sm text-green-600">Correct Answers</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-green-800">{{ $totalPoints }}</div>
                            <div class="text-sm text-green-600">Total Points</div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection