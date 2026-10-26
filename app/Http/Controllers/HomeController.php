<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index() {
        $courses = \App\Models\Course::where('is_active', true)->withCount('questions')->latest()->take(6)->get();
        return view("Home.index", compact('courses'));
    }

    public function streamFile(?string $path = null)
    {
        if (empty($path)) {
            return redirect('/');
        }

        // Clean requested path to prevent Directory Traversal
        $cleanPath = trim(str_replace(['../', '..\\'], '', $path), '/');
        if (str_starts_with($cleanPath, 'storage/')) {
            $cleanPath = substr($cleanPath, 8);
        }
        if (str_starts_with($cleanPath, 'public/')) {
            $cleanPath = substr($cleanPath, 7);
        }

        // Double-check: remove any remaining traversal attempts after cleaning
        $cleanPath = str_replace(['../', '..\\', '..'], '', $cleanPath);

        // Disallow direct access to sensitive internal storage folders
        if (
            str_starts_with($cleanPath, 'framework') ||
            str_starts_with($cleanPath, 'logs') ||
            str_starts_with($cleanPath, 'private') ||
            str_contains($cleanPath, '.env') ||
            str_contains($cleanPath, '.php')
        ) {
            abort(403, 'Akses ke berkas internal ini dibatasi.');
        }

        // Resolve file path with priority: storage/app/public > storage/app
        $filePath = $this->resolveStorageFile($cleanPath);

        if (!$filePath) {
            abort(404, 'File storage tidak ditemukan: ' . $cleanPath);
        }

        // Serve the file with proper headers (MIME, ETag, Cache)
        return $this->serveFile($filePath);
    }

    /**
     * Resolve the actual file path from storage directories.
     */
    private function resolveStorageFile(string $cleanPath): ?string
    {
        // Priority 1: storage/app/public (main public storage)
        $fullPath = storage_path('app/public/' . $cleanPath);
        if (file_exists($fullPath) && is_file($fullPath)) {
            return $fullPath;
        }

        // Priority 2: Check public disk via Storage facade
        try {
            if (\Illuminate\Support\Facades\Storage::disk('public')->exists($cleanPath)) {
                $absPath = \Illuminate\Support\Facades\Storage::disk('public')->path($cleanPath);
                if (file_exists($absPath) && is_file($absPath)) {
                    return $absPath;
                }
            }
        } catch (\Exception $e) {
            // Storage facade might fail on some hosting configs, continue to fallback
        }

        // Priority 3: Fallback to storage/app (for non-sensitive items)
        $fullLocalPath = storage_path('app/' . $cleanPath);
        if (file_exists($fullLocalPath) && is_file($fullLocalPath)) {
            return $fullLocalPath;
        }

        return null;
    }

    /**
     * Serve a file with proper MIME type, ETag, and cache headers.
     * This replaces the need for symlink-based file serving.
     */
    private function serveFile(string $filePath): \Symfony\Component\HttpFoundation\Response
    {
        $lastModified = filemtime($filePath);
        $etag = md5($filePath . $lastModified);
        $mimeType = $this->getMimeType($filePath);

        // Handle 304 Not Modified (browser cache validation)
        $requestEtag = request()->header('If-None-Match');
        $requestModified = request()->header('If-Modified-Since');

        if ($requestEtag === '"' . $etag . '"') {
            return response('', 304);
        }

        if ($requestModified && strtotime($requestModified) >= $lastModified) {
            return response('', 304);
        }

        return response()->file($filePath, [
            'Content-Type' => $mimeType,
            'Cache-Control' => 'public, max-age=31536000, immutable',
            'ETag' => '"' . $etag . '"',
            'Last-Modified' => gmdate('D, d M Y H:i:s', $lastModified) . ' GMT',
        ]);
    }

    /**
     * Get MIME type for a file, with common type mappings as fallback.
     */
    private function getMimeType(string $filePath): string
    {
        // Try PHP's built-in MIME detection first
        if (function_exists('mime_content_type')) {
            $detected = @mime_content_type($filePath);
            if ($detected && $detected !== 'application/octet-stream') {
                return $detected;
            }
        }

        // Fallback: extension-based mapping
        $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));

        $mimeTypes = [
            // Images
            'jpg' => 'image/jpeg', 'jpeg' => 'image/jpeg',
            'png' => 'image/png', 'gif' => 'image/gif',
            'webp' => 'image/webp', 'svg' => 'image/svg+xml',
            'ico' => 'image/x-icon', 'bmp' => 'image/bmp',
            // Audio
            'mp3' => 'audio/mpeg', 'wav' => 'audio/wav',
            'ogg' => 'audio/ogg', 'aac' => 'audio/aac',
            'm4a' => 'audio/mp4', 'flac' => 'audio/flac',
            // Video
            'mp4' => 'video/mp4', 'webm' => 'video/webm',
            'ogv' => 'video/ogg', 'avi' => 'video/x-msvideo',
            'mov' => 'video/quicktime',
            // Documents
            'pdf' => 'application/pdf',
            'doc' => 'application/msword',
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'xls' => 'application/vnd.ms-excel',
            'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'ppt' => 'application/vnd.ms-powerpoint',
            'pptx' => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
            // Web
            'css' => 'text/css', 'js' => 'application/javascript',
            'json' => 'application/json', 'xml' => 'application/xml',
            'html' => 'text/html', 'txt' => 'text/plain',
            'csv' => 'text/csv',
            // Archives
            'zip' => 'application/zip', 'rar' => 'application/x-rar-compressed',
            'gz' => 'application/gzip', 'tar' => 'application/x-tar',
            // Fonts
            'woff' => 'font/woff', 'woff2' => 'font/woff2',
            'ttf' => 'font/ttf', 'otf' => 'font/otf',
        ];

        return $mimeTypes[$extension] ?? 'application/octet-stream';
    }
}

