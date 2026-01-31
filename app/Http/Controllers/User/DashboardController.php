<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\UserCourse;
use App\Models\UserAnswer;
use App\Models\Transaction;
use App\Models\CourseQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Get enrolled courses with progress calculation
        $enrolledCourses = UserCourse::where('user_id', $user->id)
            ->with(['course.stories', 'course.questions'])
            ->get()
            ->map(function ($userCourse) use ($user) {
                $course = $userCourse->course;
                $totalLessons = $course->stories->count() + $course->questions->count();
                
                $questionIds = $course->questions()->pluck('id');
                $completedLessons = UserAnswer::where('user_id', $user->id)
                    ->where('content_type', 'question')
                    ->whereIn('content_id', $questionIds)
                    ->distinct('content_id')
                    ->count();
                
                $progress = $totalLessons > 0 ? round(($completedLessons / $totalLessons) * 100) : 0;
                
                return (object) [
                    'id' => $course->id,
                    'title' => $course->title,
                    'progress' => $progress,
                    'completed_lessons' => $completedLessons,
                    'total_lessons' => $totalLessons,
                    'is_completed' => $userCourse->is_completed
                ];
            });

        // Statistics for dashboard cards
        $totalCourses = $enrolledCourses->count();
        $activeCourses = $enrolledCourses->where('is_completed', false)->count();
        $completedCourses = $enrolledCourses->where('is_completed', true)->count();

        // Recent activities
        $recentActivities = collect();

        // Add recent course enrollments
        $recentEnrollments = UserCourse::where('user_id', $user->id)
            ->with('course')
            ->latest()
            ->take(3)
            ->get()
            ->map(function ($enrollment) {
                return [
                    'title' => 'Mendaftar kursus: ' . $enrollment->course->title,
                    'time' => $enrollment->created_at->diffForHumans(),
                    'type' => 'enrollment'
                ];
            });

        // Add recent transactions
        $recentTransactions = Transaction::where('user_id', $user->id)
            ->where('status', 'success')
            ->latest()
            ->take(2)
            ->get()
            ->map(function ($transaction) {
                $title = '';
                switch ($transaction->type) {
                    case 'course_purchase':
                        $title = 'Pembelian kursus berhasil';
                        break;
                    case 'topup':
                        $title = 'Top up saldo sebesar Rp ' . number_format($transaction->amount, 0, ',', '.');
                        break;
                    default:
                        $title = 'Transaksi ' . $transaction->type;
                }
                
                return [
                    'title' => $title,
                    'time' => $transaction->created_at->diffForHumans(),
                    'type' => 'transaction'
                ];
            });

        // Add recent quiz completions
        $recentAnswers = UserAnswer::where('user_id', $user->id)
            ->where('content_type', 'question')
            ->with(['courseQuestion.course'])
            ->latest()
            ->take(2)
            ->get()
            ->map(function ($answer) {
                if (!$answer->courseQuestion || !$answer->courseQuestion->course) {
                    return null;
                }
                return [
                    'title' => 'Menyelesaikan soal: ' . $answer->courseQuestion->course->title,
                    'time' => $answer->created_at->diffForHumans(),
                    'type' => 'quiz'
                ];
            })->filter();

        // Combine and sort activities
        $recentActivities = $recentEnrollments
            ->concat($recentTransactions)
            ->concat($recentAnswers)
            ->sortByDesc(function ($activity) {
                return Carbon::parse($activity['time']);
            })
            ->take(5)
            ->values();

        // Additional statistics for legacy compatibility
        $stats = [
            'enrolled_courses' => $totalCourses,
            'completed_courses' => $completedCourses,
            'total_answers' => UserAnswer::where('user_id', $user->id)->count(),
            'correct_answers' => UserAnswer::where('user_id', $user->id)->where('is_correct', true)->count(),
            'current_balance' => $user->balance,
            'total_spent' => Transaction::where('user_id', $user->id)
                ->where('type', 'course_purchase')
                ->where('status', 'success')
                ->sum('amount'),
        ];

        // Get recent enrollments for legacy compatibility
        $recentCourses = UserCourse::where('user_id', $user->id)
            ->with('course')
            ->latest()
            ->take(5)
            ->get();

        // Get courses in progress for legacy compatibility
        $inProgressCourses = UserCourse::where('user_id', $user->id)
            ->where('is_completed', false)
            ->with('course')
            ->take(3)
            ->get();

        // Get recent transactions for legacy compatibility
        $recentTransactionsList = Transaction::where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        // Calculate overall progress for legacy compatibility
        $totalQuestions = CourseQuestion::count();
        $correctAnswers = UserAnswer::where('user_id', $user->id)
            ->where('content_type', 'question')
            ->where('is_correct', true)
            ->count();

        $overallScore = $totalQuestions > 0 ? round(($correctAnswers / $totalQuestions) * 100, 1) : 0;

        return view('user.dashboard', compact(
            'enrolledCourses',
            'totalCourses',
            'activeCourses', 
            'completedCourses',
            'recentActivities',
            'stats',
            'recentCourses',
            'inProgressCourses',
            'recentTransactions',
            'overallScore'
        ));
    }
}