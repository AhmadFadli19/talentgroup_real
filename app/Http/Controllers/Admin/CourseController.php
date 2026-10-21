<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\User;
use App\Models\UserCourse;
use App\Models\UserAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courses = Course::with('creator')->withCount('userCourses')->latest()->paginate(10);
        return view('admin.courses.index', compact('courses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.courses.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean',
        ]);

        $data = $request->all();
        $data['created_by'] = Auth::id();
        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = $file->getClientOriginalName();
            $path = $file->storeAs('courses', $filename, 'public');
            $data['image'] = $path;
        }

        Course::create($data);

        return redirect()->route('admin.courses.index')->with('success', 'Course created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        $course->load(['contents', 'creator', 'userCourses.user']);
        return view('admin.courses.show', compact('course'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course)
    {
        return view('admin.courses.edit', compact('course'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Course $course)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean',
        ]);

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('image')) {
            // Delete old image
            if ($course->image) {
                Storage::disk('public')->delete($course->image);
            }
            $data['image'] = $request->file('image')->store('courses', 'public');
        }

        $course->update($data);

        return redirect()->route('admin.courses.index')->with('success', 'Course updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        // Delete image if exists
        if ($course->image) {
            Storage::disk('public')->delete($course->image);
        }

        $course->delete();

        return redirect()->route('admin.courses.index')->with('success', 'Course deleted successfully!');
    }

    /**
     * Show course results
     */
    public function userResults(User $user, Course $course)
    {
        $userCourse = UserCourse::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->first();

        if (!$userCourse) {
            abort(404, 'User is not enrolled in this course');
        }

        $answers = UserAnswer::where('user_id', $user->id)
            ->where('content_type', 'question')
            ->whereIn('content_id', $course->questions()->pluck('id'))
            ->with('courseQuestion')
            ->get();

        // Fix: Use questions() instead of contents()
        $totalQuestions = $course->questions()->count();
        $correctAnswers = $answers->where('is_correct', true)->count();
        $score = $totalQuestions > 0 ? round(($correctAnswers / $totalQuestions) * 100, 2) : 0;

        return view('admin.courses.user-results', compact('user', 'course', 'userCourse', 'answers', 'score', 'totalQuestions', 'correctAnswers'));
    }

    public function results(Course $course)
    {
        $enrolledUsers = UserCourse::where('course_id', $course->id)
            ->with(['user', 'course'])
            ->get();

        foreach ($enrolledUsers as $enrolledUser) {
            $totalNodes = $course->stories()->count() + $course->questions()->count();
            
            $storyRefs = $course->stories()->pluck('id')->map(fn($id) => "story:{$id}")->toArray();
            $questionRefs = $course->questions()->pluck('id')->map(fn($id) => "question:{$id}")->toArray();
            $allRefs = array_merge($storyRefs, $questionRefs);

            $syncedNodes = UserAnswer::where('user_id', $enrolledUser->user_id)
                ->whereIn('content_reference', $allRefs)
                ->distinct('content_reference')
                ->count();

            $enrolledUser->progress = $totalNodes > 0 ? round(($syncedNodes / $totalNodes) * 100) : 0;
        }

        return view('admin.courses.results', compact('course', 'enrolledUsers'));
    }

    /**
     * Upload a manual certificate for a student
     */
    public function uploadCertificate(Request $request, Course $course)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'certificate_file' => 'required|file|mimes:pdf,jpeg,png,jpg|max:5120',
        ]);

        $userId = $request->input('user_id');

        if ($request->hasFile('certificate_file')) {
            $file = $request->file('certificate_file');
            $path = $file->store('certificates', 'public');

            \App\Models\Certificate::updateOrCreate(
                [
                    'user_id' => $userId,
                    'course_id' => $course->id,
                ],
                [
                    'certificate_code' => 'TG-MAN-' . strtoupper(uniqid()),
                    'type' => 'manual',
                    'file_path' => $path,
                    'issued_at' => now(),
                ]
            );

            return redirect()->back()->with('success', 'Sertifikat manual berhasil diunggah!');
        }

        return redirect()->back()->with('error', 'Gagal mengunggah file sertifikat.');
    }

    /**
     * Reset manual certificate back to automatic
     */
    public function resetCertificate(Request $request, Course $course)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $userId = $request->input('user_id');

        $certificate = \App\Models\Certificate::where('user_id', $userId)
            ->where('course_id', $course->id)
            ->first();

        if ($certificate) {
            if ($certificate->file_path) {
                Storage::disk('public')->delete($certificate->file_path);
            }

            $certificate->update([
                'type' => 'automatic',
                'file_path' => null,
                'certificate_code' => 'TG-' . strtoupper(uniqid()),
            ]);

            return redirect()->back()->with('success', 'Sertifikat berhasil di-reset kembali ke otomatis!');
        }

        return redirect()->back()->with('error', 'Sertifikat tidak ditemukan.');
    }
}
