@extends('layouts.app')

@section('title', 'Add Course Content')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <div class="flex items-center mb-4">
            <a href="{{ route('admin.courses.contents.index', $course) }}" class="text-blue-600 hover:text-blue-800 mr-4">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <h1 class="text-3xl font-bold text-gray-800">Add Course Content</h1>
        </div>
        <p class="text-gray-600">{{ $course->title }}</p>
    </div>

    <div class="max-w-2xl">
        <form action="{{ route('admin.courses.contents.store', $course) }}" method="POST" class="bg-white rounded-lg shadow-md p-6">
            @csrf

            <div class="mb-6">
                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Content Title</label>
                <input type="text" id="title" name="title" value="{{ old('title') }}" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('title') border-red-500 @enderror"
                       placeholder="Enter content title" required>
                @error('title')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="type" class="block text-sm font-medium text-gray-700 mb-2">Content Type</label>
                <select id="type" name="type" onchange="toggleQuestionFields()" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('type') border-red-500 @enderror" required>
                    <option value="">Select content type</option>
                    <option value="story" {{ old('type') === 'story' ? 'selected' : '' }}>Story (Explanation/Reading Material)</option>
                    <option value="question" {{ old('type') === 'question' ? 'selected' : '' }}>Question (Multiple Choice Quiz)</option>
                </select>
                <div class="mt-2 text-sm text-gray-600">
                    <p><strong>Story:</strong> Use for explanations, reading material, or educational content without questions.</p>
                    <p><strong>Question:</strong> Use for multiple choice questions that require student answers.</p>
                </div>
                @error('type')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="content" class="block text-sm font-medium text-gray-700 mb-2">Content</label>
                <textarea id="content" name="content" rows="6" 
                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('content') border-red-500 @enderror"
                          placeholder="Enter your content here..." required>{{ old('content') }}</textarea>
                @error('content')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="order" class="block text-sm font-medium text-gray-700 mb-2">Order</label>
                <input type="number" id="order" name="order" value="{{ old('order', 1) }}" min="1"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('order') border-red-500 @enderror"
                       placeholder="1" required>
                <p class="text-sm text-gray-500 mt-1">The order in which this content appears in the course</p>
                @error('order')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Question-specific fields -->
            <div id="question-fields" class="hidden">
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Answer Options</label>
                    <div id="options-container">
                        @if(old('options'))
                            @foreach(old('options') as $index => $option)
                            <div class="option-group mb-3">
                                <div class="flex items-center space-x-2">
                                    <input type="text" name="options[]" value="{{ $option }}" 
                                           class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                           placeholder="Enter option {{ $index + 1 }}">
                                    <button type="button" onclick="removeOption(this)" class="text-red-600 hover:text-red-800">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            @endforeach
                        @else
                        <div class="option-group mb-3">
                            <div class="flex items-center space-x-2">
                                <input type="text" name="options[]" 
                                       class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                       placeholder="Enter option 1">
                                <button type="button" onclick="removeOption(this)" class="text-red-600 hover:text-red-800">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <div class="option-group mb-3">
                            <div class="flex items-center space-x-2">
                                <input type="text" name="options[]" 
                                       class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                       placeholder="Enter option 2">
                                <button type="button" onclick="removeOption(this)" class="text-red-600 hover:text-red-800">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        @endif
                    </div>
                    <button type="button" onclick="addOption()" class="mt-2 text-blue-600 hover:text-blue-800 text-sm font-medium">
                        + Add Option
                    </button>
                    @error('options')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="correct_answer" class="block text-sm font-medium text-gray-700 mb-2">Correct Answer</label>
                    <input type="text" id="correct_answer" name="correct_answer" value="{{ old('correct_answer') }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('correct_answer') border-red-500 @enderror"
                           placeholder="Enter the correct answer exactly as it appears in the options">
                    <p class="text-sm text-gray-500 mt-1">Must match exactly one of the options above</p>
                    @error('correct_answer')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex justify-end space-x-4">
                <a href="{{ route('admin.courses.contents.index', $course) }}" class="px-6 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition-colors">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                    Add Content
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function toggleQuestionFields() {
    const type = document.getElementById('type').value;
    const questionFields = document.getElementById('question-fields');
    
    if (type === 'question') {
        questionFields.classList.remove('hidden');
        // Make question fields required and enabled
        const correctAnswerField = document.getElementById('correct_answer');
        if (correctAnswerField) {
            correctAnswerField.required = true;
            correctAnswerField.disabled = false;
        }
        document.querySelectorAll('input[name="options[]"]').forEach(input => {
            input.required = true;
            input.disabled = false;
        });
    } else {
        questionFields.classList.add('hidden');
        // Remove required attribute for story type and clear values
        const correctAnswerField = document.getElementById('correct_answer');
        if (correctAnswerField) {
            correctAnswerField.required = false;
            correctAnswerField.value = ''; // Clear the value
            correctAnswerField.disabled = false; // Keep enabled for toggling
        }
        document.querySelectorAll('input[name="options[]"]').forEach(input => {
            input.required = false;
            input.value = ''; // Clear the values
            input.disabled = false; // Keep enabled for toggling
        });
    }
}

function addOption() {
    const container = document.getElementById('options-container');
    const optionCount = container.children.length + 1;
    
    const optionGroup = document.createElement('div');
    optionGroup.className = 'option-group mb-3';
    optionGroup.innerHTML = `
        <div class="flex items-center space-x-2">
            <input type="text" name="options[]" 
                   class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                   placeholder="Enter option ${optionCount}">
            <button type="button" onclick="removeOption(this)" class="text-red-600 hover:text-red-800">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
            </button>
        </div>
    `;
    
    container.appendChild(optionGroup);
    
    // Update required attribute based on current type
    const type = document.getElementById('type').value;
    if (type === 'question') {
        optionGroup.querySelector('input[name="options[]"]').required = true;
    }
}

function removeOption(button) {
    const container = document.getElementById('options-container');
    if (container.children.length > 2) {
        button.closest('.option-group').remove();
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    toggleQuestionFields();
    
    // Also trigger when the form is about to be submitted
    document.querySelector('form').addEventListener('submit', function(e) {
        const type = document.getElementById('type').value;
        if (type === 'story') {
            // For story content, disable the question fields so they won't be submitted
            const correctAnswerField = document.getElementById('correct_answer');
            if (correctAnswerField) {
                correctAnswerField.required = false;
                correctAnswerField.disabled = true; // Disable instead of removing name
            }
            document.querySelectorAll('input[name="options[]"]').forEach(input => {
                input.required = false;
                input.disabled = true; // Disable instead of removing name
            });
        }
    });
});
</script>
@endsection