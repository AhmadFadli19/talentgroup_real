<?php

namespace App\Http\Controllers\Admin;

use App\Models\Course;
use App\Models\CardDetail;
use App\Models\Slidebanner;
use App\Models\SlideBlogger;
use Illuminate\Http\Request;
use App\Models\BannerCardDetail;
use App\Models\KolaborasiDetail;
use App\Models\User; // jika butuh
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        $userCount = User::where('role_id', 2)->count();
        $courses = Course::with('creator')->withCount('userCourses')->latest()->paginate(10);
        // Only count regular users
        return view('admin.courses.index', compact('userCount', 'courses'));
    }
}
