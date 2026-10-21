<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\CourseContent;
use App\Models\CourseStory;
use App\Models\CourseVideo;
use App\Models\CourseHtml;
use App\Models\CourseQuestion;
use App\Models\UserAnswer;
use App\Models\UserCourse;
use App\Models\Transaction;
use App\Models\User;
use App\Models\ReferralCode;
use App\Models\ReferralCodeUsage;
use App\Services\CodeExecutionService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CourseController extends Controller
{
    protected CodeExecutionService $codeService;

    public function __construct(CodeExecutionService $codeService)
    {
        $this->codeService = $codeService;
    }

    public function index(Request $request)
    {
        $query = Course::where('is_active', true);

        if ($request->filled('category')) {
            $query->where('title', 'LIKE', $request->category . '%');
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'LIKE', '%' . $request->search . '%')
                    ->orWhere('description', 'LIKE', '%' . $request->search . '%');
            });
        }

        $courses = $query->withCount('userCourses')
            ->latest()
            ->paginate(12);

        $allCourses = Course::where('is_active', true)->get();
        $categories = $allCourses->map(function ($course) {
            preg_match('/^([A-Z]\d+)/', $course->title, $matches);
            return $matches[1] ?? null;
        })->filter()->unique()->sort()->values();

        return view('user.courses_index', compact('courses', 'categories'));
    }

    public function retake($courseId)
    {
        $user = Auth::user();
        $course = Course::findOrFail($courseId);

        $userCourse = UserCourse::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->first();

        if (!$userCourse) {
            return redirect()->route('user.courses.show', $course->id)
                ->with('error', 'Anda belum membeli kursus ini.');
        }

        if (!$userCourse->is_completed) {
            return redirect()->route('user.courses.learn', $course->id)
                ->with('info', 'Selesaikan kursus terlebih dahulu sebelum mengulang.');
        }

        DB::transaction(function () use ($user, $course, $userCourse) {
            $questionIds = $course->questions()->pluck('id');
            $storyIds = $course->stories()->pluck('id');
            $videoIds = $course->videos()->pluck('id');

            UserAnswer::where('user_id', $user->id)
                ->where(function($query) use ($questionIds, $storyIds, $videoIds) {
                    $query->where(fn($q) => $q->where('content_type', 'question')->whereIn('content_id', $questionIds))
                        ->orWhere(fn($q) => $q->where('content_type', 'story')->whereIn('content_id', $storyIds))
                        ->orWhere(fn($q) => $q->where('content_type', 'video')->whereIn('content_id', $videoIds));
                })
                ->delete();

            $firstContent = $course->allContents()->first();
            $firstContentId = null;

            if ($firstContent) {
                $firstContentId = $firstContent->type . ':' . $firstContent->id;
            }

            $userCourse->update([
                'is_completed' => false,
                'current_content_id' => $firstContentId,
            ]);
        });

        return redirect()->route('user.courses.learn', $course->id)
            ->with('success', 'Kursus berhasil direset! Selamat belajar kembali.');
    }

    public function show($id)
    {
        $course = Course::findOrFail($id);
        $user = Auth::user();
        $isEnrolled = $user->courses->contains($course->id);

        $totalStories = $course->stories()->count();
        $totalQuestions = $course->questions()->count();
        $totalVideos = $course->videos()->count();
        $totalHtmls = $course->htmls()->count();
        $totalContents = $totalStories + $totalQuestions + $totalVideos + $totalHtmls;
        $enrolledCount = $course->userCourses->count();

        return view('user.courses_show', compact('course', 'isEnrolled', 'totalContents', 'totalQuestions', 'enrolledCount', 'totalHtmls'));
    }

    /**
     * Check if a referral code is valid for a course and return discount info.
     */
    public function checkReferral(Request $request, $id)
    {
        $course = Course::findOrFail($id);
        $user = Auth::user();
        $codeStr = strtoupper(trim($request->input('code', '')));

        if (empty($codeStr)) {
            return response()->json([
                'valid' => false,
                'message' => 'Silakan masukkan kode referral.',
            ]);
        }

        $referral = ReferralCode::where('code', $codeStr)->first();

        if (!$referral || !$referral->isValidForCourse($course, $user)) {
            return response()->json([
                'valid' => false,
                'message' => 'Kode referral tidak valid, sudah dipakai, atau kedaluwarsa.',
            ]);
        }

        $discount = $referral->calculateDiscount((float) $course->price);
        $finalPrice = max(0, (float) $course->price - $discount);

        return response()->json([
            'valid' => true,
            'code' => $referral->code,
            'description' => $referral->description,
            'discount_type' => $referral->discount_type,
            'discount_value' => (float) $referral->discount_value,
            'discount_amount' => $discount,
            'original_price' => (float) $course->price,
            'final_price' => $finalPrice,
            'is_free' => $finalPrice == 0,
            'formatted_discount' => 'Rp ' . number_format($discount, 0, ',', '.'),
            'formatted_final_price' => $finalPrice == 0 ? 'GRATIS' : 'Rp ' . number_format($finalPrice, 0, ',', '.'),
            'message' => $finalPrice == 0 
                ? 'Kode referral valid! Kursus menjadi 100% GRATIS!' 
                : 'Kode referral valid! Anda hemat Rp ' . number_format($discount, 0, ',', '.') . '.',
        ]);
    }

    public function purchase(Request $request, $id)
    {
        $course = Course::findOrFail($id);
        $user = Auth::user();

        if ($user->courses->contains($course->id)) {
            return redirect()->route('user.courses.show', $course->id)
                ->with('error', 'Anda sudah terdaftar di kursus ini.');
        }

        $referralCode = null;
        $discount = 0;
        $finalPrice = (float) $course->price;

        if ($request->filled('referral_code')) {
            $codeStr = strtoupper(trim($request->referral_code));
            $referralCode = ReferralCode::where('code', $codeStr)->first();

            if (!$referralCode || !$referralCode->isValidForCourse($course, $user)) {
                return redirect()->route('user.courses.show', $course->id)
                    ->with('error', 'Kode referral tidak valid, sudah mencapai batas penggunaan, atau telah kedaluwarsa.');
            }

            $discount = $referralCode->calculateDiscount((float) $course->price);
            $finalPrice = max(0, (float) $course->price - $discount);
        }

        if ($finalPrice > 0 && $user->balance < $finalPrice) {
            return redirect()->route('user.courses.show', $course->id)
                ->with('error', 'Saldo tidak mencukupi (Biaya: Rp ' . number_format($finalPrice, 0, ',', '.') . '). Silakan top up saldo terlebih dahulu.');
        }

        DB::transaction(function () use ($user, $course, $finalPrice, $discount, $referralCode) {
            // Deduct balance only if final price > 0
            if ($finalPrice > 0) {
                User::where('id', $user->id)->decrement('balance', $finalPrice);
            }

            $desc = 'Purchase course: ' . $course->title;
            if ($referralCode) {
                $desc .= ' (Ref: ' . $referralCode->code . ' - Potongan Rp ' . number_format($discount, 0, ',', '.') . ')';
            }

            Transaction::create([
                'user_id' => $user->id,
                'course_id' => $course->id,
                'type' => 'course_purchase',
                'amount' => $finalPrice,
                'status' => 'success',
                'payment_method' => $finalPrice == 0 ? 'referral_code_free' : 'balance',
                'description' => $desc,
            ]);

            // Track referral code usage
            if ($referralCode) {
                $referralCode->increment('used_count');
                ReferralCodeUsage::create([
                    'referral_code_id' => $referralCode->id,
                    'user_id' => $user->id,
                    'course_id' => $course->id,
                    'discount_amount' => $discount,
                ]);
            }

            $firstContent = $course->allContents()->first();
            $firstContentId = null;

            if ($firstContent) {
                $firstContentId = $firstContent->type . ':' . $firstContent->id;
            }

            UserCourse::create([
                'user_id' => $user->id,
                'course_id' => $course->id,
                'purchased_at' => now(),
                'is_completed' => false,
                'current_content_id' => $firstContentId,
            ]);
        });

        $successMsg = $finalPrice == 0 
            ? 'Selamat! Kursus berhasil dibuka GRATIS menggunakan kode referral!' 
            : 'Berhasil membeli kursus dengan potongan harga! Selamat belajar.';

        return redirect()->route('user.courses.show', $course->id)
            ->with('success', $successMsg);
    }

    public function myCourses()
    {
        $user = Auth::user();
        $userCourses = UserCourse::where('user_id', $user->id)
            ->with(['course'])
            ->latest()
            ->get();

        foreach ($userCourses as $userCourse) {
            $course = $userCourse->course;
            
            $totalNodes = $course->stories()->count() + $course->questions()->count() + $course->videos()->count() + $course->htmls()->count();
            
            $storyRefs = $course->stories()->pluck('id')->map(fn($id) => "story:{$id}")->toArray();
            $questionRefs = $course->questions()->pluck('id')->map(fn($id) => "question:{$id}")->toArray();
            $videoRefs = $course->videos()->pluck('id')->map(fn($id) => "video:{$id}")->toArray();
            $htmlRefs = $course->htmls()->pluck('id')->map(fn($id) => "html:{$id}")->toArray();
            $allRefs = array_merge($storyRefs, $questionRefs, $videoRefs, $htmlRefs);

            $syncedNodes = UserAnswer::where('user_id', $user->id)
                ->whereIn('content_reference', $allRefs)
                ->distinct('content_reference')
                ->count();

            $userCourse->progress = $totalNodes > 0 ? round(($syncedNodes / $totalNodes) * 100) : 0;
        }

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

        $userCourse = UserCourse::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->first();

        if (!$userCourse) {
            return redirect()->route('user.courses.show', $course->id)
                ->with('error', 'Anda belum membeli kursus ini.');
        }

        $userAnswers = UserAnswer::where('user_id', $user->id)
            ->pluck('content_reference')
            ->toArray();

        $contents = $course->allContents();

        return view('user.course_learn', compact('course', 'userCourse', 'userAnswers', 'contents'));
    }

    public function content($courseId, $contentId)
    {
        $course = Course::findOrFail($courseId);
        $user = Auth::user();

        [$type, $id] = explode(':', $contentId);

        if ($type === 'story') {
            $content = CourseStory::findOrFail($id);
            $content->type = 'story';

            // Mark as read immediately (User request: story viewed = completed)
            UserAnswer::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'content_type' => 'story',
                    'content_id' => $content->id,
                ],
                [
                    'content_reference' => 'story:' . $content->id,
                    'answer' => 'read',
                    'is_correct' => true,
                    'points' => 0, // No score for story as requested
                ]
            );

            // Update progress to mark this node as visited/completed
            $this->updateProgress($user, $course, $content);
        } elseif ($type === 'video') {
            $content = CourseVideo::findOrFail($id);
            $content->type = 'video';

            // Mark as watched immediately
            UserAnswer::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'content_type' => 'video',
                    'content_id' => $content->id,
                ],
                [
                    'content_reference' => 'video:' . $content->id,
                    'answer' => 'watched',
                    'is_correct' => true,
                    'points' => 0,
                ]
            );

            // Update progress to mark this node as visited/completed
            $this->updateProgress($user, $course, $content);
        } elseif ($type === 'html') {
            $content = CourseHtml::findOrFail($id);
            $content->type = 'html';

            // Mark as viewed immediately
            UserAnswer::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'content_type' => 'html',
                    'content_id' => $content->id,
                ],
                [
                    'content_reference' => 'html:' . $content->id,
                    'answer' => 'viewed',
                    'is_correct' => true,
                    'points' => 0,
                ]
            );

            // Update progress to mark this node as visited/completed
            $this->updateProgress($user, $course, $content);
        } else {
            $content = CourseQuestion::findOrFail($id);
            $content->type = 'question';
        }

        $userCourse = UserCourse::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->first();

        if (!$userCourse) {
            return redirect()->route('user.courses.show', $course->id)
                ->with('error', 'Anda belum membeli kursus ini.');
        }

        $userAnswer = UserAnswer::where('user_id', $user->id)
            ->where('content_type', 'question')
            ->where('content_id', $content->id)
            ->first();

        $allContents = $course->allContents();
        $currentIndex = $allContents->search(function ($item) use ($content) {
            return $item->type === $content->type && $item->id === $content->id;
        });

        $previousContent = $currentIndex > 0 ? $allContents[$currentIndex - 1] : null;
        $nextContent = $currentIndex < $allContents->count() - 1 ? $allContents[$currentIndex + 1] : null;

        // For coding questions, use dedicated view
        if ($type === 'question' && $content->isCoding()) {
            $codingRules = CourseQuestion::availableCodingRules();
            return view('user.course_coding', compact(
                'course', 'content', 'userAnswer', 'userCourse',
                'previousContent', 'nextContent', 'codingRules'
            ));
        }

        return view('user.course_content', compact('course', 'content', 'userAnswer', 'userCourse', 'previousContent', 'nextContent'));
    }

    public function submitAnswer(Request $request, $courseId, $contentId)
    {
        $course = Course::findOrFail($courseId);
        $user = Auth::user();

        [$type, $id] = explode(':', $contentId);

        if ($type !== 'question') {
            return redirect()->back()->with('error', 'Hanya bisa menjawab pertanyaan.');
        }

        $content = CourseQuestion::findOrFail($id);

        // Handle coding question submission
        if ($content->isCoding()) {
            $request->validate([
                'code' => 'required|string',
                'output' => 'nullable|string',
                'language' => 'nullable|string'
            ]);

            $code = $request->input('code');
            $output = $request->input('output', '');
            $language = $request->input('language', $content->language ?? 'go');

            // Validate rules
            $rulesResult = $this->codeService->validateRules($code, $content->coding_rules ?? []);
            $allRulesPassed = !in_array(false, $rulesResult, true);

            // Check output
            $outputMatches = $this->codeService->checkOutput($output, $content->expected_output);

            // Check test cases if they exist
            $allTestsPassed = true;
            if (!empty($content->test_cases)) {
                $testResults = $this->codeService->runTestCases($code, $content->test_cases, $language);
                $allTestsPassed = $testResults['all_passed'];
                $isCorrect = $allRulesPassed && $allTestsPassed;
            } else {
                $isCorrect = $allRulesPassed && $outputMatches;
            }

            // Save answer
            UserAnswer::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'content_type' => 'question',
                    'content_id' => $content->id,
                ],
                [
                    'content_reference' => 'question:' . $content->id,
                    'answer' => $output,
                    'code_submitted' => $code,
                    'code_output' => $output,
                    'rules_passed' => $rulesResult,
                    'is_correct' => $isCorrect,
                    'points' => $isCorrect ? 10 : 0,
                ]
            );

            // Update progress
            $this->updateProgress($user, $course, $content);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'is_correct' => $isCorrect,
                    'message' => $isCorrect ? 'Jawaban benar! Kode kamu sesuai!' : 'Jawaban masih belum tepat.',
                ]);
            }

            $message = $isCorrect ? 'Jawaban benar! Kode kamu sesuai!' : 'Jawaban masih belum tepat.';
            return redirect()->route('user.courses.content', [$course->id, $contentId])
                ->with($isCorrect ? 'success' : 'error', $message);
        }

        // Handle multiple choice question
        $request->validate([
            'answer' => 'required',
        ]);

        $isCorrect = $content->correct_answer === $request->input('answer');

        UserAnswer::updateOrCreate(
            [
                'user_id' => $user->id,
                'content_type' => 'question',
                'content_id' => $content->id,
            ],
            [
                'content_reference' => 'question:' . $content->id,
                'answer' => $request->input('answer'),
                'is_correct' => $isCorrect,
                'points' => $isCorrect ? 10 : 0,
            ]
        );

        $this->updateProgress($user, $course, $content);

        $message = $isCorrect ? 'Jawaban benar! Selamat!' : 'Jawaban salah. Coba lagi!';

        return redirect()->route('user.courses.content', [$course->id, $contentId])
            ->with($isCorrect ? 'success' : 'error', $message);
    }

    private function updateProgress($user, $course, $content)
    {
        $userCourse = UserCourse::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->first();

        if ($userCourse) {
            $allContents = $course->allContents();
            $currentIndex = $allContents->search(function ($item) use ($content) {
                return $item->type === $content->type && $item->id === $content->id;
            });

            if ($currentIndex !== false && $currentIndex < $allContents->count() - 1) {
                $nextContent = $allContents[$currentIndex + 1];
                $nextContentId = $nextContent->type . ':' . $nextContent->id;
                $userCourse->update(['current_content_id' => $nextContentId]);
            } else {
                $userCourse->update(['is_completed' => true]);

                // Auto issue certificate
                \App\Models\Certificate::firstOrCreate(
                    [
                        'user_id' => $user->id,
                        'course_id' => $course->id,
                    ],
                    [
                        'certificate_code' => 'TG-' . strtoupper(uniqid()),
                        'type' => 'automatic',
                        'issued_at' => now(),
                    ]
                );
            }
        }
    }

    /**
     * Show/Download the course certificate
     */
    public function certificate($courseId)
    {
        $user = Auth::user();
        $course = Course::findOrFail($courseId);

        $userCourse = UserCourse::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->first();

        if (!$userCourse || !$userCourse->is_completed) {
            return redirect()->route('user.courses.results', $course->id)
                ->with('error', 'Anda belum menyelesaikan kursus ini untuk mendapatkan sertifikat.');
        }

        $certificate = \App\Models\Certificate::firstOrCreate(
            [
                'user_id' => $user->id,
                'course_id' => $course->id,
            ],
            [
                'certificate_code' => 'TG-' . strtoupper(uniqid()),
                'type' => 'automatic',
                'issued_at' => now(),
            ]
        );

        if ($certificate->isManual() && $certificate->file_path) {
            return response()->file(storage_path('app/public/' . $certificate->file_path));
        }

        return view('user.certificate_view', compact('course', 'user', 'certificate'));
    }

    public function results($courseId)
    {
        $user = Auth::user();
        $course = Course::findOrFail($courseId);

        $userCourse = UserCourse::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->first();

        if (!$userCourse) {
            return redirect()->route('user.courses.show', $course->id)
                ->with('error', 'Anda belum membeli kursus ini.');
        }

        $allContents = $course->allContents();
        $totalNodes = $allContents->count();
        
        $userAnswersAll = UserAnswer::where('user_id', $user->id)
            ->whereIn('content_reference', $allContents->map(fn($c) => $c->type . ':' . $c->id))
            ->get();
            
        $syncedNodes = $userAnswersAll->count();

        $questionIds = $course->questions()->pluck('id');
        $answers = $userAnswersAll->where('content_type', 'question');
        
        $totalQuestions = $questionIds->count();
        $correctAnswers = $answers->where('is_correct', true)->count();
        $score = $totalQuestions > 0 ? round(($correctAnswers / $totalQuestions) * 100, 1) : 0;
        $totalPoints = $answers->sum('points');

        return view('user.course_results', compact(
            'course',
            'userCourse',
            'answers',
            'totalNodes',
            'syncedNodes',
            'totalQuestions',
            'correctAnswers',
            'score',
            'totalPoints'
        ));
    }
}
