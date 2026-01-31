<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\User;
use App\Models\Transaction;
use App\Models\UserCourse;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::where('role_id', 2)->count(), // Assuming role_id 2 is for users
            'total_courses' => Course::count(),
            'active_courses' => Course::where('is_active', true)->count(),
            'total_enrollments' => UserCourse::count(),
            'total_revenue' => Transaction::where('type', 'course_purchase')->where('status', 'success')->sum('amount'),
            'recent_users' => User::where('role_id', 2)->latest()->take(5)->get(),
            'recent_enrollments' => UserCourse::with(['user', 'course'])->latest()->take(5)->get(),
            'popular_courses' => Course::withCount('userCourses')->orderBy('user_courses_count', 'desc')->take(5)->get(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
