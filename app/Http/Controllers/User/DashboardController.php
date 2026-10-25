<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\UserCourse;
use App\Models\UserAnswer;
use App\Models\Transaction;
use App\Models\CourseQuestion;
use App\Models\CourseVideo;
use App\Models\Prototype;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Get enrolled courses with progress calculation
        $enrolledCourses = UserCourse::where('user_id', $user->id)
            ->with(['course.stories', 'course.questions', 'course.videos'])
            ->get()
            ->map(function ($userCourse) use ($user) {
                $course = $userCourse->course;
                $totalLessons = $course->stories->count() + $course->questions->count() + $course->videos->count();
                
                $storyRefs = $course->stories->map(fn($s) => "story:{$s->id}")->toArray();
                $questionRefs = $course->questions->map(fn($q) => "question:{$q->id}")->toArray();
                $videoRefs = $course->videos->map(fn($v) => "video:{$v->id}")->toArray();
                $allRefs = array_merge($storyRefs, $questionRefs, $videoRefs);

                $completedLessons = UserAnswer::where('user_id', $user->id)
                    ->whereIn('content_reference', $allRefs)
                    ->distinct('content_reference')
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

        // Get user's hosted web prototypes with AI scan reports
        $userPrototypes = Prototype::where('user_id', $user->id)
            ->latest()
            ->get();

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
            'overallScore',
            'userPrototypes'
        ));
    }

    public function profile()
    {
        $user = Auth::user();
        $transactions = Transaction::where('user_id', $user->id)
            ->latest()
            ->paginate(10);
            
        return view('user.profile', compact('user', 'transactions'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $rules = [
            'name' => 'sometimes|required|string|max:255',
            'username' => 'sometimes|required|string|alpha_dash|max:255|unique:users,username,' . $user->id,
            'email' => 'sometimes|required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'sometimes|required|string|max:20|unique:users,phone,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];

        $messages = [
            'name.required' => 'Nama lengkap wajib diisi.',
            'username.required' => 'Username wajib diisi.',
            'username.alpha_dash' => 'Username hanya boleh berisi huruf, angka, tanda hubung (-), dan garis bawah (_).',
            'username.unique' => 'Username ini sudah digunakan oleh akun lain.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email ini sudah terdaftar pada akun lain.',
            'phone.required' => 'Nomor WhatsApp / telepon wajib diisi.',
            'phone.unique' => 'Nomor telepon ini sudah digunakan oleh akun lain.',
            'password.min' => 'Kata sandi minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
            'avatar.image' => 'File avatar harus berupa gambar.',
            'avatar.max' => 'Ukuran file avatar maksimal 2MB.',
        ];

        $request->validate($rules, $messages);

        if ($request->has('name')) {
            $user->name = $request->name;
        }

        if ($request->has('username')) {
            $user->username = $request->username;
        }

        if ($request->has('email')) {
            $user->email = $request->email;
        }

        if ($request->has('phone')) {
            $user->phone = $request->phone;
        }

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        if ($request->hasFile('avatar')) {
            // Delete old avatar if exists
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }

            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path;
        }

        $user->save();

        return redirect()->back()->with('success', 'Profil Anda berhasil diperbarui!');
    }
}