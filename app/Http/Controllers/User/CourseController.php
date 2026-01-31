<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\CourseContent;
use App\Models\CourseStory;
use App\Models\CourseQuestion;
use App\Models\UserAnswer;
use App\Models\UserCourse;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::where('is_active', true)
            ->withCount('userCourses')
            ->latest()
            ->paginate(12);

        return view('user.courses_index', compact('courses'));
    }

    public function show($id)
    {
        $course = Course::findOrFail($id);

        $user = Auth::user();
        $isEnrolled = $user->courses->contains($course->id);

        // Get course statistics using new relationships
        $totalStories = $course->stories()->count();
        $totalQuestions = $course->questions()->count();
        $totalContents = $totalStories + $totalQuestions;
        $enrolledCount = $course->userCourses->count();

        return view('user.courses_show', compact('course', 'isEnrolled', 'totalContents', 'totalQuestions', 'enrolledCount'));
    }

    public function purchase(Request $request, $id)
    {
        $course = Course::findOrFail($id);
        $user = Auth::user();

        // Check if user already enrolled
        if ($user->courses->contains($course->id)) {
            return redirect()->route('user.courses.show', $course->id)
                ->with('error', 'Anda sudah terdaftar di kursus ini.');
        }

        // Check if user has enough balance
        if ($user->balance < $course->price) {
            return redirect()->route('user.courses.show', $course->id)
                ->with('error', 'Saldo tidak mencukupi. Silakan top up terlebih dahulu.');
        }

        DB::transaction(function () use ($user, $course) {
            // Deduct balance
            User::where('id', $user->id)->decrement('balance', $course->price);

            // Create transaction record
            Transaction::create([
                'user_id' => $user->id,
                'course_id' => $course->id,
                'type' => 'course_purchase',
                'amount' => $course->price,
                'status' => 'success',
                'payment_method' => 'balance',
                'description' => 'Purchase course: ' . $course->title,
            ]);

            // Get first content (story or question with lowest order)
            $firstContent = $course->allContents()->first();
            $firstContentId = null;

            if ($firstContent) {
                // Store as "type:id" format to identify which table
                $firstContentId = $firstContent->type . ':' . $firstContent->id;
            }

            // Enroll user in course
            UserCourse::create([
                'user_id' => $user->id,
                'course_id' => $course->id,
                'purchased_at' => now(),
                'is_completed' => false,
                'current_content_id' => $firstContentId, // Store as "type:id"
            ]);
        });

        return redirect()->route('user.courses.show', $course->id)
            ->with('success', 'Berhasil membeli kursus! Selamat belajar.');
    }

    public function myCourses()
    {
        $user = Auth::user();
        $userCourses = UserCourse::where('user_id', $user->id)
            ->with(['course'])
            ->latest()
            ->get();

        // Calculate progress for each course
        foreach ($userCourses as $userCourse) {
            $course = $userCourse->course;
            $totalQuestions = $course->questions()->count();
            $answeredQuestions = UserAnswer::where('user_id', $user->id)
                ->where('content_type', 'question')
                ->whereIn('content_id', $course->questions()->pluck('id'))
                ->distinct()
                ->count('content_id');

            $userCourse->progress = $totalQuestions > 0 ? round(($answeredQuestions / $totalQuestions) * 100) : 0;
        }

        // Extract courses from userCourses for the view
        $courses = $userCourses->map(function ($userCourse) {
            $course = $userCourse->course;
            $course->progress = $userCourse->progress;
            $course->is_completed = $userCourse->is_completed;
            $course->enrolled_at = $userCourse->created_at;
            return $course;
        });

        return view('user.my_courses', compact('courses'));
    }

    public function learn($courseId)
    {
        $user = Auth::user();
        $course = Course::findOrFail($courseId);

        // Check if user is enrolled
        $userCourse = UserCourse::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->first();

        if (!$userCourse) {
            return redirect()->route('user.courses.show', $course->id)
                ->with('error', 'Anda belum membeli kursus ini.');
        }

        // Get user's answers for this course (only for questions)
        $questionIds = $course->questions()->pluck('id');
        $userAnswers = UserAnswer::where('user_id', $user->id)
            ->where('content_type', 'question')
            ->whereIn('content_id', $questionIds)
            ->pluck('content_id')
            ->toArray();

        // Get course contents from both tables
        $contents = $course->allContents();

        return view('user.course_learn', compact('course', 'userCourse', 'userAnswers', 'contents'));
    }

    public function content($courseId, $contentId)
    {
        $course = Course::findOrFail($courseId);
        $user = Auth::user();

        // Parse content ID to get type and actual ID
        [$type, $id] = explode(':', $contentId);

        if ($type === 'story') {
            $content = CourseStory::findOrFail($id);
            $content->type = 'story';
        } else {
            $content = CourseQuestion::findOrFail($id);
            $content->type = 'question';
        }

        // Check if user is enrolled
        $userCourse = UserCourse::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->first();

        if (!$userCourse) {
            return redirect()->route('user.courses.show', $course->id)
                ->with('error', 'Anda belum membeli kursus ini.');
        }

        // Get user's answer for this content (only for questions)
        $userAnswer = UserAnswer::where('user_id', $user->id)
            ->where('content_type', 'question')
            ->where('content_id', $content->id)
            ->first();

        // Get navigation info
        $allContents = $course->allContents();
        $currentIndex = $allContents->search(function ($item) use ($content) {
            return $item->type === $content->type && $item->id === $content->id;
        });

        $previousContent = $currentIndex > 0 ? $allContents[$currentIndex - 1] : null;
        $nextContent = $currentIndex < $allContents->count() - 1 ? $allContents[$currentIndex + 1] : null;

        return view('user.course_content', compact('course', 'content', 'userAnswer', 'userCourse', 'previousContent', 'nextContent'));
    }

    public function submitAnswer(Request $request, $courseId, $contentId)
    {
        $course = Course::findOrFail($courseId);
        $user = Auth::user();

        // Parse content ID to get type and actual ID
        [$type, $id] = explode(':', $contentId);

        if ($type !== 'question') {
            return redirect()->back()->with('error', 'Hanya bisa menjawab pertanyaan.');
        }

        $content = CourseQuestion::findOrFail($id);

        $request->validate([
            'answer' => 'required',
        ]);

        // Check if answer is correct
        $isCorrect = $content->correct_answer === $request->input('answer');

        // Save or update user answer
        $userAnswer = UserAnswer::updateOrCreate(
            [
                'user_id' => $user->id,
                'content_type' => 'question',
                'content_id' => $content->id,
            ],
            [
                'content_reference' => 'question:' . $content->id,
                'answer' => $request->input('answer'),
                'is_correct' => $isCorrect,
                'points' => $isCorrect ? 10 : 0, // 10 points for correct answer
            ]
        );

        // Update user's current content progress
        $userCourse = UserCourse::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->first();

        if ($userCourse) {
            $allContents = $course->allContents();
            $currentIndex = $allContents->search(function ($item) use ($content) {
                return $item->type === 'question' && $item->id === $content->id;
            });

            if ($currentIndex !== false && $currentIndex < $allContents->count() - 1) {
                $nextContent = $allContents[$currentIndex + 1];
                $nextContentId = $nextContent->type . ':' . $nextContent->id;
                $userCourse->update(['current_content_id' => $nextContentId]);
            } else {
                // Course completed
                $userCourse->update(['is_completed' => true]);
            }
        }

        $message = $isCorrect ? 'Jawaban benar! Selamat!' : 'Jawaban salah. Coba lagi!';

        return redirect()->route('user.courses.content', [$course->id, $contentId])
            ->with($isCorrect ? 'success' : 'error', $message);
    }

    public function results($courseId)
    {
        $user = Auth::user();
        $course = Course::findOrFail($courseId);

        // Check if user is enrolled
        $userCourse = UserCourse::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->first();

        if (!$userCourse) {
            return redirect()->route('user.courses.show', $course->id)
                ->with('error', 'Anda belum membeli kursus ini.');
        }

        // Get user's answers for this course questions
        $questionIds = $course->questions()->pluck('id');
        $answers = UserAnswer::where('user_id', $user->id)
            ->where('content_type', 'question')
            ->whereIn('content_id', $questionIds)
            ->with('courseQuestion') // Eager-load courseQuestion
            ->get();

        // Calculate statistics
        $totalQuestions = $course->questions()->count();
        $answeredQuestions = $answers->count();
        $correctAnswers = $answers->where('is_correct', true)->count();
        $score = $totalQuestions > 0 ? round(($correctAnswers / $totalQuestions) * 100, 1) : 0;
        $totalPoints = $answers->sum('points');

        return view('user.course_results', compact(
            'course',
            'userCourse',
            'answers',
            'totalQuestions',
            'answeredQuestions',
            'correctAnswers',
            'score',
            'totalPoints'
        ));
    }
}
