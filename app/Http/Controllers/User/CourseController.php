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
use Illuminate\Validation\Rule;

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
            $htmlIds = $course->htmls()->pluck('id');

            UserAnswer::where('user_id', $user->id)
                ->where(function($query) use ($questionIds, $storyIds, $videoIds, $htmlIds) {
                    $query->where(fn($q) => $q->where('content_type', 'question')->whereIn('content_id', $questionIds))
                        ->orWhere(fn($q) => $q->where('content_type', 'story')->whereIn('content_id', $storyIds))
                        ->orWhere(fn($q) => $q->where('content_type', 'video')->whereIn('content_id', $videoIds))
                        ->orWhere(fn($q) => $q->where('content_type', 'html')->whereIn('content_id', $htmlIds));
                })
                ->delete();

            $firstContent = $course->allContents($user)->first();
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
                'payment_method' => $finalPrice > 0
                    ? 'balance'
                    : ($referralCode ? 'referral_code_free' : 'free_course'),
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

            $firstContent = $course->allContents($user)->first();
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
            ? ($referralCode
                ? 'Selamat! Kursus berhasil dibuka GRATIS menggunakan kode referral!'
                : 'Latihan gratis berhasil dibuka. Selamat belajar!')
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

        $contents = $course->allContents($user);

        return view('user.course_learn', compact('course', 'userCourse', 'userAnswers', 'contents'));
    }

    public function content($courseId, $contentId)
    {
        $course = Course::findOrFail($courseId);
        $user = Auth::user();

        $userCourse = UserCourse::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->first();

        if (!$userCourse) {
            return redirect()->route('user.courses.show', $course->id)
                ->with('error', 'Anda belum membeli kursus ini.');
        }

        [$type, $id] = explode(':', $contentId);

        abort_unless(in_array($type, ['story', 'video', 'html', 'question'], true), 404);

        if ($type === 'story') {
            $content = $course->stories()->findOrFail($id);
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
            $content = $course->videos()->findOrFail($id);
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
            $content = $course->htmls()->findOrFail($id);
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
            $content = $course->questions()->findOrFail($id);
            $content->type = 'question';
        }

        $userAnswer = UserAnswer::where('user_id', $user->id)
            ->where('content_type', 'question')
            ->where('content_id', $content->id)
            ->first();

        $allContents = $course->allContents($user);
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

        $userCourse = UserCourse::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->first();

        if (!$userCourse) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda belum terdaftar pada kursus ini.',
                ], 403);
            }

            return redirect()->route('user.courses.show', $course->id)
                ->with('error', 'Anda belum membeli kursus ini.');
        }

        // Jika kuis sudah dikumpulkan (is_completed), jawaban dikunci dan tidak bisa diedit/dihapus
        if ($userCourse && $userCourse->is_completed) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Kuis ini sudah dikumpulkan secara final. Jawaban telah dikunci dan tidak dapat diubah lagi.',
                    'is_locked' => true,
                ], 403);
            }
            return redirect()->back()->with('error', 'Kuis ini sudah dikumpulkan secara final. Jawaban telah dikunci.');
        }

        $content = $course->questions()->findOrFail($id);

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

            $showFeedback = $course->isInstantQuizFeedback();
            if ($showFeedback) {
                $codeMsg = $isCorrect ? 'Jawaban benar! Kode kamu sesuai!' : 'Jawaban masih belum tepat.';
            } elseif ($course->isNoneQuizFeedback()) {
                $codeMsg = 'Kode Anda berhasil dikirim dan tersimpan!';
            } else {
                $codeMsg = 'Kode Anda berhasil dikirim dan tersimpan! Hasil evaluasi lengkap akan tersedia setelah Anda menyelesaikan seluruh materi kursus.';
            }

            if ($request->ajax()) {
                $userCourse = UserCourse::where('user_id', $user->id)->where('course_id', $course->id)->first();
                $isCompleted = $userCourse ? (bool)$userCourse->is_completed : false;

                $allContents = $course->allContents($user);
                $currentIndex = $allContents->search(fn($c) => $c->type === $content->type && $c->id === $content->id);
                $nextContent = ($currentIndex !== false && $currentIndex < $allContents->count() - 1) ? $allContents[$currentIndex + 1] : null;

                $nextUrl = ($isCompleted || !$nextContent)
                    ? route('user.courses.results', $course->id)
                    : route('user.courses.content', [$course->id, $nextContent->type . ':' . $nextContent->id]);

                return response()->json([
                    'success' => true,
                    'is_correct' => $showFeedback ? $isCorrect : null,
                    'is_completed' => $isCompleted,
                    'message' => $codeMsg,
                    'next_url' => $nextUrl,
                ]);
            }

            return redirect()->route('user.courses.content', [$course->id, $contentId])
                ->with($showFeedback ? ($isCorrect ? 'success' : 'error') : 'info', $codeMsg);
        }

        // Handle multiple choice question
        $request->validate([
            'answer' => ['required', 'string', Rule::in($content->options ?? [])],
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

        if ($course->isInstantQuizFeedback()) {
            $message = $isCorrect ? 'Jawaban benar! Selamat!' : 'Jawaban salah. Coba lagi!';
            $flashType = $isCorrect ? 'success' : 'error';
        } elseif ($course->isNoneQuizFeedback()) {
            $message = 'Jawaban Anda berhasil disimpan!';
            $flashType = 'info';
        } else {
            // Default: 'end'
            $message = 'Jawaban Anda berhasil disimpan! Hasil evaluasi dan kunci jawaban akan ditampilkan setelah Anda menyelesaikan seluruh materi kursus.';
            $flashType = 'info';
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'answer' => $request->input('answer'),
                'is_correct' => $course->isInstantQuizFeedback() ? $isCorrect : null,
                'reveal_answers' => $course->isInstantQuizFeedback(),
            ]);
        }

        return redirect()->route('user.courses.content', [$course->id, $contentId])
            ->with($flashType, $message);
    }

    private function updateProgress($user, $course, $content)
    {
        $userCourse = UserCourse::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->first();

        if ($userCourse) {
            $allContents = $course->allContents($user);
            $totalNodes = $allContents->count();
            $allRefs = $allContents->map(fn($c) => $c->type . ':' . $c->id)->toArray();

            $completedRefs = UserAnswer::where('user_id', $user->id)
                ->whereIn('content_reference', $allRefs)
                ->pluck('content_reference')
                ->unique()
                ->toArray();

            $completedCount = count($completedRefs);
            $isAllCompleted = ($totalNodes > 0 && $completedCount >= $totalNodes);

            if ($isAllCompleted) {
                $userCourse->update([
                    'is_completed' => true,
                ]);

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
            } else {
                // Tentukan modul berikutnya yang belum selesai
                $currentIndex = $allContents->search(function ($item) use ($content) {
                    return $item->type === $content->type && $item->id === $content->id;
                });

                $nextUncompleted = null;
                if ($currentIndex !== false) {
                    for ($i = $currentIndex + 1; $i < $totalNodes; $i++) {
                        $candidate = $allContents[$i];
                        if (!in_array($candidate->type . ':' . $candidate->id, $completedRefs)) {
                            $nextUncompleted = $candidate;
                            break;
                        }
                    }
                }

                if (!$nextUncompleted) {
                    $nextUncompleted = $allContents->first(function ($candidate) use ($completedRefs) {
                        return !in_array($candidate->type . ':' . $candidate->id, $completedRefs);
                    });
                }

                $nextContentId = $nextUncompleted ? ($nextUncompleted->type . ':' . $nextUncompleted->id) : null;
                $userCourse->update([
                    'current_content_id' => $nextContentId,
                    'is_completed' => false,
                ]);
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

        if (!$userCourse) {
            return redirect()->route('user.courses.show', $course->id)
                ->with('error', 'Anda belum membeli kursus ini.');
        }

        // Cek apakah seluruh node sudah selesai
        $allContents = $course->allContents($user);
        $totalNodes = $allContents->count();
        $allRefs = $allContents->map(fn($c) => $c->type . ':' . $c->id)->toArray();
        $syncedNodes = UserAnswer::where('user_id', $user->id)
            ->whereIn('content_reference', $allRefs)
            ->distinct('content_reference')
            ->count();

        $isCompleted = $userCourse->is_completed || ($totalNodes > 0 && $syncedNodes >= $totalNodes);

        if (!$isCompleted) {
            return redirect()->route('user.courses.results', $course->id)
                ->with('error', 'Selesaikan seluruh materi kursus terlebih dahulu untuk mendapatkan sertifikat.');
        }

        if (!$userCourse->is_completed) {
            $userCourse->update(['is_completed' => true]);
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

        $allContents = $course->allContents($user);
        $totalNodes = $allContents->count();
        $allRefs = $allContents->map(fn($c) => $c->type . ':' . $c->id)->toArray();
        
        $userAnswersAll = UserAnswer::where('user_id', $user->id)
            ->whereIn('content_reference', $allRefs)
            ->with(['courseQuestion', 'courseStory'])
            ->get();
            
        $completedRefs = $userAnswersAll->pluck('content_reference')->unique()->toArray();
        $syncedNodes = count($completedRefs);

        // Jika seluruh materi sudah selesai, sinkronkan is_completed dan sertifikat
        if ($totalNodes > 0 && $syncedNodes >= $totalNodes) {
            if (!$userCourse->is_completed) {
                $userCourse->update(['is_completed' => true]);
            }

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

        // Ambil seluruh pertanyaan (Kuis & Coding) sesuai urutan materi
        $questions = $allContents->where('type', 'question')->values();
        $totalQuestions = $questions->count();
        $answersMap = $userAnswersAll->keyBy('content_reference');

        $evaluatedQuestions = $questions->map(function ($q) use ($answersMap) {
            $ref = 'question:' . $q->id;
            $userAns = $answersMap->get($ref);
            return [
                'question' => $q,
                'user_answer' => $userAns,
                'is_answered' => $userAns !== null,
                'is_correct' => $userAns ? (bool) $userAns->is_correct : false,
                'points' => $userAns ? (int) $userAns->points : 0,
            ];
        });

        $answeredCount = $evaluatedQuestions->where('is_answered', true)->count();
        $correctAnswers = $evaluatedQuestions->where('is_correct', true)->count();

        if ($totalQuestions > 0) {
            $score = round(($correctAnswers / $totalQuestions) * 100, 1);
        } else {
            $score = $totalNodes > 0 ? round(($syncedNodes / $totalNodes) * 100, 1) : 100;
        }

        $totalPoints = $evaluatedQuestions->sum('points');

        return view('user.course_results', compact(
            'course',
            'userCourse',
            'allContents',
            'evaluatedQuestions',
            'totalNodes',
            'syncedNodes',
            'totalQuestions',
            'answeredCount',
            'correctAnswers',
            'score',
            'totalPoints'
        ));
    }
}
