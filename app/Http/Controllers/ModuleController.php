<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\ModuleCategory;
use App\Models\ReferralCode;
use App\Models\ReferralCodeUsage;
use App\Models\UserModuleAccess;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    /**
     * Display the module catalog (matching Screenshot 2 course catalog style).
     */
    public function index(Request $request)
    {
        $query = ModuleCategory::active()->withCount(['publishedModules as lessons_count'])->ordered();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('type')) {
            if ($request->type === 'free') {
                $query->where('is_public', true);
            } elseif ($request->type === 'premium') {
                $query->where('is_public', false);
            }
        }

        $modules = $query->paginate(12)->withQueryString();

        $user = auth()->user();
        $unlockedModuleIds = [];
        if ($user) {
            $unlockedModuleIds = UserModuleAccess::where('user_id', $user->id)
                ->pluck('category_id')
                ->filter()
                ->toArray();
        }

        return view('modules.index', compact('modules', 'unlockedModuleIds'));
    }

    /**
     * Show a specific module (redirects to first lesson or shows locked view).
     */
    public function showModule($moduleSlug)
    {
        $module = ModuleCategory::where('slug', $moduleSlug)->firstOrFail();

        // If inactive, only allow admin to preview
        if (!$module->is_active && (!auth()->check() || !auth()->user()->isAdmin())) {
            abort(404, 'Modul pembelajaran ini sedang tidak aktif.');
        }

        $user = auth()->user();
        $isLocked = !$module->hasAccessForUser($user);

        // Fetch ONLY lessons of this specific module
        $lessons = $module->publishedModules()->orderBy('id', 'asc')->get();
        $firstLesson = $lessons->first();

        $groupedLessons = $lessons->groupBy(function ($lesson) {
            return !empty($lesson->section) ? strtoupper(trim($lesson->section)) : 'GETTING STARTED';
        });

        if ($isLocked) {
            $dummyModule = (object)[
                'id' => 0,
                'title' => $module->name,
                'slug' => '',
                'excerpt' => $module->description,
                'rendered_content' => '',
                'category' => $module,
                'enable_protection' => true,
            ];

            return view('modules.show', [
                'learningModule' => $module,
                'currentLesson' => $firstLesson,
                'module' => $firstLesson ?? $dummyModule,
                'lessons' => $lessons,
                'groupedLessons' => $groupedLessons,
                'tableOfContents' => [],
                'previousLesson' => null,
                'nextLesson' => null,
                'previousModule' => null,
                'nextModule' => null,
                'isLocked' => true,
            ]);
        }

        if ($firstLesson) {
            return redirect()->route('modules.lesson.show', [
                'moduleSlug' => $module->slug,
                'lessonSlug' => $firstLesson->slug
            ]);
        }

        return view('modules.empty', [
            'learningModule' => $module,
            'lessons' => collect(),
            'groupedLessons' => collect(),
        ]);
    }

    /**
     * Show a specific lesson within a specific module.
     */
    public function showLesson($moduleSlug, $lessonSlug)
    {
        $learningModule = ModuleCategory::where('slug', $moduleSlug)->firstOrFail();

        // If inactive, only allow admin to preview
        if (!$learningModule->is_active && (!auth()->check() || !auth()->user()->isAdmin())) {
            abort(404, 'Modul pembelajaran ini sedang tidak aktif.');
        }

        $currentLesson = Module::where('category_id', $learningModule->id)
            ->where('slug', $lessonSlug)
            ->firstOrFail();

        // If lesson is draft/unpublished, only allow admin to preview
        if (!$currentLesson->is_published && (!auth()->check() || !auth()->user()->isAdmin())) {
            abort(404, 'Materi pembelajaran ini belum dipublikasikan.');
        }

        // Increment views safely
        $currentLesson->increment('views_count');

        $user = auth()->user();
        $isLocked = !$learningModule->hasAccessForUser($user) || !$currentLesson->hasAccessForUser($user);

        // Fetch ONLY lessons of this specific module for the sidebar
        $lessons = $learningModule->publishedModules()
            ->orderBy('id', 'asc')
            ->get();

        $groupedLessons = $lessons->groupBy(function ($lesson) {
            return !empty($lesson->section) ? strtoupper(trim($lesson->section)) : 'GETTING STARTED';
        });

        $tableOfContents = $isLocked ? [] : $currentLesson->table_of_contents;

        // Calculate previous and next lesson within sequential lesson list
        $currentIndex = $lessons->search(function ($item) use ($currentLesson) {
            return $item->id === $currentLesson->id;
        });

        $previousLesson = ($currentIndex !== false && $currentIndex > 0) ? $lessons->get($currentIndex - 1) : null;
        $nextLesson = ($currentIndex !== false && $currentIndex < $lessons->count() - 1) ? $lessons->get($currentIndex + 1) : null;

        return view('modules.show', [
            'learningModule' => $learningModule,
            'currentLesson' => $currentLesson,
            'module' => $currentLesson,
            'lessons' => $lessons,
            'groupedLessons' => $groupedLessons,
            'tableOfContents' => $tableOfContents,
            'previousLesson' => $previousLesson,
            'nextLesson' => $nextLesson,
            'previousModule' => $previousLesson,
            'nextModule' => $nextLesson,
            'isLocked' => $isLocked,
        ]);
    }

    /**
     * Live search for documentation & topics (Ctrl+K).
     */
    public function search(Request $request)
    {
        $query = $request->get('q', '');
        if (strlen($query) < 2) {
            return response()->json([]);
        }

        $results = Module::where('is_published', true)
            ->whereHas('category', function ($q) {
                $q->where('is_active', true);
            })
            ->where(function ($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                  ->orWhere('excerpt', 'like', "%{$query}%")
                  ->orWhere('content', 'like', "%{$query}%");
            })
            ->with('category')
            ->limit(10)
            ->get()
            ->map(function ($item) {
                $categorySlug = $item->category ? $item->category->slug : 'general';
                return [
                    'title' => $item->title,
                    'excerpt' => $item->excerpt,
                    'category' => $item->category ? $item->category->name : 'Modul',
                    'url' => route('modules.lesson.show', ['moduleSlug' => $categorySlug, 'lessonSlug' => $item->slug]),
                ];
            });

        return response()->json($results);
    }

    /**
     * Unlock a private module using a referral code.
     */
    public function unlock(Request $request)
    {
        if ($request->has('category_id') && !$request->has('module_id')) {
            $request->merge(['module_id' => $request->category_id]);
        }

        $request->validate([
            'module_id' => 'required|exists:module_categories,id',
            'referral_code' => 'required|string',
        ]);

        if (!auth()->check()) {
            return redirect()->route('login')->with('info', 'Silakan masuk terlebih dahulu untuk membuka akses modul.');
        }

        $user = auth()->user();
        $module = ModuleCategory::findOrFail($request->module_id);
        $code = strtoupper(trim($request->referral_code));

        $matchesDirectCode = $module->referral_code && strtoupper(trim($module->referral_code)) === $code;

        $referralCodeRecord = ReferralCode::where('code', $code)
            ->where('is_active', true)
            ->first();

        $isValidTableCode = $referralCodeRecord && $referralCodeRecord->isValidForModule($module, $user);

        if ($matchesDirectCode || $isValidTableCode) {
            UserModuleAccess::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'category_id' => $module->id,
                ],
                [
                    'access_method' => 'referral_code',
                    'referral_code' => $code,
                ]
            );

            if ($isValidTableCode) {
                $referralCodeRecord->increment('used_count');
                ReferralCodeUsage::create([
                    'referral_code_id' => $referralCodeRecord->id,
                    'user_id' => $user->id,
                    'category_id' => $module->id,
                ]);
            }

            $firstLesson = $module->publishedModules()->first();
            $targetUrl = $firstLesson 
                ? route('modules.lesson.show', ['moduleSlug' => $module->slug, 'lessonSlug' => $firstLesson->slug])
                : route('modules.module.show', $module->slug);

            return redirect($targetUrl)->with('success', 'Selamat! Akses ke "' . $module->name . '" berhasil dibuka!');
        }

        return back()->with('error', 'Kode referral tidak valid atau telah kedaluwarsa.');
    }

    /**
     * Legacy redirect handler.
     */
    public function showLegacy($slug)
    {
        $lesson = Module::where('slug', $slug)->first();
        if ($lesson && $lesson->category) {
            return redirect()->route('modules.lesson.show', [
                'moduleSlug' => $lesson->category->slug,
                'lessonSlug' => $lesson->slug,
            ]);
        }
        return redirect()->route('modules.index');
    }
}
