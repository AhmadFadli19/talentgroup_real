<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\AiSetting;
use App\Models\Prototype;
use App\Services\AiCodeAnalyzerService;
use App\Services\PrototypeZipService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class PrototypeController extends Controller
{
    protected array $reservedSlugs = [
        'admin', 'user', 'bank', 'login', 'register', 'logout', 'verify', 'reset',
        'courses', 'modules', 'code', 'api', 'storage', 'assets', 'home', 'dashboard'
    ];

    /**
     * Display list of user's uploaded & hosted prototypes.
     */
    public function index()
    {
        $prototypes = Prototype::where('user_id', auth()->id())
            ->latest()
            ->paginate(12);

        $settings = AiSetting::getSettings();

        return view('user.prototypes.index', compact('prototypes', 'settings'));
    }

    /**
     * Show upload and AI analysis interface.
     */
    public function create()
    {
        $settings = AiSetting::getSettings();
        return view('user.prototypes.create', compact('settings'));
    }

    /**
     * AJAX Endpoint: Extract and Analyze Prototype with AI Agent.
     */
    public function analyze(Request $request, PrototypeZipService $zipService, AiCodeAnalyzerService $aiService)
    {
        $uploadType = $request->input('upload_type', 'zip_archive');
        $tempToken = (string) Str::uuid();
        $tempDir = storage_path('app/temp_prototypes/' . $tempToken);

        $projectName = trim($request->input('project_name') ?: 'My Web Prototype');

        if ($uploadType === 'zip_archive') {
            $request->validate([
                'zip_file' => 'required|file|mimes:zip|max:40960', // max 40MB
            ], [
                'zip_file.required' => 'Pilih file ZIP project Anda terlebih dahulu.',
                'zip_file.mimes' => 'File harus berformat .zip.',
                'zip_file.max' => 'Ukuran file ZIP maksimal 40MB.',
            ]);

            $extractResult = $zipService->extractZip($request->file('zip_file'), $tempDir);
        } else {
            $request->validate([
                'html_file' => 'required|file|max:15360',
                'css_file' => 'nullable|file|max:15360',
                'js_file' => 'nullable|file|max:15360',
            ], [
                'html_file.required' => 'File HTML (.html) wajib diunggah.',
                'html_file.max' => 'Ukuran file HTML maksimal 15MB.',
            ]);

            $extractResult = $zipService->createFromManualFiles(
                $request->file('html_file'),
                $request->file('css_file'),
                $request->file('js_file'),
                $tempDir
            );
        }

        if (!$extractResult['success']) {
            if (File::exists($tempDir)) {
                File::deleteDirectory($tempDir);
            }
            return response()->json([
                'success' => false,
                'message' => $extractResult['error'] ?? 'Gagal memproses file prototype.',
            ], 422);
        }

        // Run AI Analysis
        $aiResult = $aiService->analyze(
            $extractResult['html_code'],
            $extractResult['css_code'],
            $extractResult['js_code']
        );

        // Store extraction metadata in cache for 3 hours
        Cache::put('proto_temp_' . $tempToken, [
            'user_id' => auth()->id(),
            'project_name' => $projectName,
            'temp_dir' => $tempDir,
            'upload_type' => $uploadType,
            'ai_provider' => $aiResult['provider'],
            'score' => $aiResult['score'],
            'is_approved' => $aiResult['is_approved'],
            'report' => $aiResult['report'],
            'file_count' => $extractResult['file_count'] ?? 1,
        ], now()->addHours(3));

        $suggestedSlug = Str::slug($projectName);
        if ($this->isSlugTaken($suggestedSlug)) {
            $suggestedSlug .= '-' . Str::random(4);
        }

        return response()->json([
            'success' => true,
            'temp_token' => $tempToken,
            'project_name' => $projectName,
            'suggested_slug' => $suggestedSlug,
            'score' => $aiResult['score'],
            'is_approved' => $aiResult['is_approved'],
            'min_passing_score' => $aiResult['report']['min_passing_score'] ?? 75,
            'provider' => $aiResult['provider'],
            'report' => $aiResult['report'],
            'file_count' => $extractResult['file_count'] ?? 1,
        ]);
    }

    /**
     * AJAX Endpoint: Check if URL slug is available.
     */
    public function checkSlug(Request $request)
    {
        $rawSlug = $request->query('slug', '');
        $slug = Str::slug($rawSlug);

        if (empty($slug)) {
            return response()->json(['available' => false, 'message' => 'Slug tidak boleh kosong.']);
        }

        if (in_array(strtolower($slug), $this->reservedSlugs, true)) {
            return response()->json(['available' => false, 'message' => 'Slug ini digunakan oleh sistem dan tidak dapat dipilih.']);
        }

        $exists = Prototype::where('slug', $slug)->exists();

        return response()->json([
            'available' => !$exists,
            'slug' => $slug,
            'message' => $exists ? 'Slug URL sudah digunakan oleh pengguna lain.' : 'Slug URL tersedia!',
        ]);
    }

    /**
     * AJAX Endpoint: Deploy / Claim Free Hosting for an Approved Prototype.
     */
    public function deploy(Request $request, PrototypeZipService $zipService)
    {
        $request->validate([
            'temp_token' => 'required|string',
            'project_name' => 'required|string|max:150',
            'slug' => 'required|string|max:150',
        ]);

        $tempToken = $request->input('temp_token');
        $cacheKey = 'proto_temp_' . $tempToken;
        $tempData = Cache::get($cacheKey);

        if (!$tempData || !File::exists($tempData['temp_dir'])) {
            return response()->json([
                'success' => false,
                'message' => 'Sesi upload telah kedaluwarsa atau file tidak ditemukan. Silakan upload ulang.',
            ], 422);
        }

        if ($tempData['user_id'] !== auth()->id()) {
            return response()->json(['success' => false, 'message' => 'Akses ditolak.'], 403);
        }

        $minScore = AiSetting::getSettings()->min_passing_score ?: 75;
        if ($tempData['score'] < $minScore) {
            return response()->json([
                'success' => false,
                'message' => "Skor prototype Anda ({$tempData['score']}) belum memenuhi batas minimal kelayakan hosting gratis ({$minScore}). Perbaiki kode dan coba lagi.",
            ], 403);
        }

        // Validate slug
        $slug = Str::slug($request->input('slug'));
        if (empty($slug) || in_array(strtolower($slug), $this->reservedSlugs, true)) {
            $slug .= '-' . Str::random(4);
        }

        if (Prototype::where('slug', $slug)->exists()) {
            $slug .= '-' . Str::random(4);
        }

        // Permanent directory for hosted prototype
        $permanentDir = storage_path('app/hosted_prototypes/' . $slug);
        if (File::exists($permanentDir)) {
            File::deleteDirectory($permanentDir);
        }
        File::makeDirectory($permanentDir, 0755, true);

        // Copy files from temp directory to permanent storage
        File::copyDirectory($tempData['temp_dir'], $permanentDir);

        // Inject base tag into permanent index.html
        $indexPath = $permanentDir . DIRECTORY_SEPARATOR . 'index.html';
        if (File::exists($indexPath)) {
            $zipService->injectBaseTag($indexPath, url('/p/' . $slug) . '/');
        }

        // Create Database Record
        $prototype = Prototype::create([
            'user_id' => auth()->id(),
            'project_name' => $request->input('project_name', $tempData['project_name']),
            'slug' => $slug,
            'upload_type' => $tempData['upload_type'],
            'storage_path' => $permanentDir,
            'ai_provider_used' => $tempData['ai_provider'],
            'ai_score' => $tempData['score'],
            'ai_report_json' => $tempData['report'],
            'is_approved' => true,
            'is_hosted' => true,
            'is_active' => true,
        ]);

        // Clean up temp directory & cache
        if (File::exists($tempData['temp_dir'])) {
            File::deleteDirectory($tempData['temp_dir']);
        }
        Cache::forget($cacheKey);

        return response()->json([
            'success' => true,
            'message' => 'Selamat! Prototype Anda berhasil di-hosting gratis!',
            'url' => url('/p/' . $slug),
            'slug' => $slug,
            'prototype_id' => $prototype->id,
        ]);
    }

    /**
     * View full AI Report as JSON or partial.
     */
    public function showReport($id)
    {
        $prototype = Prototype::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        return response()->json([
            'success' => true,
            'prototype' => $prototype,
        ]);
    }

    /**
     * Delete user prototype.
     */
    public function destroy($id)
    {
        $prototype = Prototype::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        if (File::exists($prototype->storage_path)) {
            File::deleteDirectory($prototype->storage_path);
        }

        $prototype->delete();

        return redirect()->route('user.prototypes.index')
            ->with('success', "Prototype '{$prototype->project_name}' berhasil dihapus dari hosting.");
    }

    protected function isSlugTaken(string $slug): bool
    {
        return in_array(strtolower($slug), $this->reservedSlugs, true) || Prototype::where('slug', $slug)->exists();
    }
}
