<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseQuestion;
use Illuminate\Http\Request;

class PracticeQuestionController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->input('search'));

        $courses = Course::query()
            ->whereHas('questions')
            ->withCount([
                'questions',
                'questions as beginner_questions_count' => fn ($query) => $query->where('difficulty', 'beginner'),
                'questions as intermediate_questions_count' => fn ($query) => $query->where('difficulty', 'intermediate'),
                'questions as advanced_questions_count' => fn ($query) => $query->where('difficulty', 'advanced'),
            ])
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($nested) use ($search) {
                    $nested->where('title', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
                });
            })
            ->orderByDesc('updated_at')
            ->paginate(12)
            ->withQueryString();

        $levelCounts = CourseQuestion::query()
            ->selectRaw('difficulty, COUNT(*) as total')
            ->groupBy('difficulty')
            ->pluck('total', 'difficulty');

        return view('admin.practice_questions.index', [
            'courses' => $courses,
            'search' => $search,
            'totalQuestions' => $levelCounts->sum(),
            'levelCounts' => $levelCounts,
        ]);
    }
}
