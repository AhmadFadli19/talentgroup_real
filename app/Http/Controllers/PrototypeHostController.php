<?php

namespace App\Http\Controllers;

use App\Models\Prototype;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class PrototypeHostController extends Controller
{
    /**
     * Common MIME types for static assets.
     */
    protected array $mimeTypes = [
        'html' => 'text/html; charset=utf-8',
        'htm' => 'text/html; charset=utf-8',
        'css' => 'text/css; charset=utf-8',
        'js' => 'application/javascript; charset=utf-8',
        'mjs' => 'application/javascript; charset=utf-8',
        'json' => 'application/json',
        'map' => 'application/json',
        'webmanifest' => 'application/manifest+json',
        'wasm' => 'application/wasm',
        'png' => 'image/png',
        'jpg' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'gif' => 'image/gif',
        'svg' => 'image/svg+xml',
        'webp' => 'image/webp',
        'ico' => 'image/x-icon',
        'bmp' => 'image/bmp',
        'avif' => 'image/avif',
        'woff' => 'font/woff',
        'woff2' => 'font/woff2',
        'ttf' => 'font/ttf',
        'otf' => 'font/otf',
        'eot' => 'application/vnd.ms-fontobject',
        'mp3' => 'audio/mpeg',
        'wav' => 'audio/wav',
        'ogg' => 'audio/ogg',
        'mp4' => 'video/mp4',
        'webm' => 'video/webm',
        'pdf' => 'application/pdf',
        'txt' => 'text/plain; charset=utf-8',
        'xml' => 'application/xml',
    ];

    /**
     * Serve prototype index or static files at /p/{slug}/{path?}
     */
    public function serve(Request $request, string $slug, ?string $path = null)
    {
        $prototype = Prototype::where('slug', $slug)->first();

        if (! $prototype) {
            return response()->view('errors.prototype_not_found', [
                'slug' => $slug,
                'message' => 'Prototype dengan alamat tersebut tidak ditemukan atau telah dihapus.',
            ], 404);
        }

        if (! $prototype->is_hosted) {
            return response()->view('errors.prototype_not_found', [
                'slug' => $slug,
                'message' => 'Prototype ini belum diaktifkan untuk hosting publik.',
            ], 403);
        }

        if (! $prototype->is_active) {
            return response()->view('errors.prototype_suspended', [
                'prototype' => $prototype,
                'message' => 'Prototype ini saat ini dinonaktifkan sementara oleh Administrator karena peninjauan.',
            ], 403);
        }

        $baseDir = $prototype->storage_path;
        if (! File::exists($baseDir)) {
            $fallbackDir = storage_path('app/hosted_prototypes/'.$slug);
            if (File::exists($fallbackDir)) {
                $baseDir = $fallbackDir;
            } else {
                return response()->view('errors.prototype_not_found', [
                    'slug' => $slug,
                    'message' => 'Berkas direktori prototype tidak ditemukan di server penyimpanan.',
                ], 404);
            }
        }

        // Clean requested path to prevent Directory Traversal
        $cleanPath = trim(str_replace(['../', '..\\'], '', (string) $path), '/');

        // If root request or index.html
        if ($cleanPath === '' || $cleanPath === 'index.html' || $cleanPath === 'index.htm') {
            $indexPath = rtrim($baseDir, '/\\').DIRECTORY_SEPARATOR.'index.html';
            if (! File::exists($indexPath)) {
                $indexPath = rtrim($baseDir, '/\\').DIRECTORY_SEPARATOR.'index.htm';
            }

            if (! File::exists($indexPath)) {
                $anyHtml = File::glob(rtrim($baseDir, '/\\').DIRECTORY_SEPARATOR.'*.html');
                if (! empty($anyHtml)) {
                    $indexPath = $anyHtml[0];
                }
            }

            if (! File::exists($indexPath)) {
                return response()->view('errors.prototype_not_found', [
                    'slug' => $slug,
                    'message' => 'File utama index.html tidak ditemukan dalam prototype ini.',
                ], 404);
            }

            $content = File::get($indexPath);

            // Dynamically ensure base tag and rewrite links so relative assets resolve seamlessly
            $baseHref = url('/p/'.$slug).'/';
            $content = $this->prepareHtmlContent($content, $baseHref, $slug);

            return response($content, 200, [
                'Content-Type' => 'text/html; charset=utf-8',
                'X-Frame-Options' => 'SAMEORIGIN',
                'X-Content-Type-Options' => 'nosniff',
            ]);
        }

        // Requested asset or subpage file
        $filePath = rtrim($baseDir, '/\\').DIRECTORY_SEPARATOR.str_replace('/', DIRECTORY_SEPARATOR, $cleanPath);

        // Fallback if requested path is a sub-directory containing an index.html
        if (File::exists($filePath) && is_dir($filePath)) {
            $subIndex = rtrim($filePath, '/\\').DIRECTORY_SEPARATOR.'index.html';
            if (! File::exists($subIndex)) {
                $subIndex = rtrim($filePath, '/\\').DIRECTORY_SEPARATOR.'index.htm';
            }
            if (File::exists($subIndex)) {
                $filePath = $subIndex;
            }
        }

        // Fallback for extensionless HTML navigation (e.g. href="slide2" -> "slide2.html", href="about" -> "about.html")
        if (! File::exists($filePath) && File::exists($filePath.'.html')) {
            $filePath .= '.html';
        }

        // SPA fallback: client-side routes such as /dashboard or /profile should
        // load the prototype's index.html and be handled by its browser router.
        if (! File::exists($filePath) && pathinfo($cleanPath, PATHINFO_EXTENSION) === '') {
            $spaIndex = rtrim($baseDir, '/\\').DIRECTORY_SEPARATOR.'index.html';
            if (! File::exists($spaIndex)) {
                $spaIndex = rtrim($baseDir, '/\\').DIRECTORY_SEPARATOR.'index.htm';
            }

            if (File::exists($spaIndex)) {
                $content = File::get($spaIndex);
                $baseHref = url('/p/'.$slug).'/';
                $content = $this->prepareHtmlContent($content, $baseHref, $slug);

                return response($content, 200, [
                    'Content-Type' => 'text/html; charset=utf-8',
                    'X-Frame-Options' => 'SAMEORIGIN',
                    'X-Content-Type-Options' => 'nosniff',
                ]);
            }
        }

        // Security check: must reside inside baseDir
        $realBase = realpath($baseDir);
        $realFile = realpath($filePath);

        $isInsidePrototype = $realBase
            && $realFile
            && ($realFile === $realBase || str_starts_with($realFile, $realBase.DIRECTORY_SEPARATOR));

        if (! $isInsidePrototype || ! File::exists($realFile) || is_dir($realFile)) {
            return response("File '{$cleanPath}' tidak ditemukan.", 404, ['Content-Type' => 'text/plain']);
        }

        $ext = strtolower(pathinfo($realFile, PATHINFO_EXTENSION));

        // If serving another HTML file inside prototype (e.g. slide2.html, about.html, page2.html)
        if ($ext === 'html' || $ext === 'htm') {
            $content = File::get($realFile);
            $baseHref = url('/p/'.$slug).'/';
            $content = $this->prepareHtmlContent($content, $baseHref, $slug);

            return response($content, 200, [
                'Content-Type' => 'text/html; charset=utf-8',
                'X-Frame-Options' => 'SAMEORIGIN',
                'X-Content-Type-Options' => 'nosniff',
            ]);
        }

        $mimeType = $this->mimeTypes[$ext] ?? File::mimeType($realFile) ?? 'application/octet-stream';

        return response()->file($realFile, [
            'Content-Type' => $mimeType,
            'Cache-Control' => 'public, max-age=86400',
            'X-Content-Type-Options' => 'nosniff',
        ]);
    }

    /**
     * Prepare HTML content by injecting <base href="..."> and rewriting root-relative links
     */
    protected function prepareHtmlContent(string $html, string $baseHref, string $slug): string
    {
        $html = $this->ensureBaseTag($html, $baseHref);

        // Convert root-relative links like href="/page2.html" or src="/images/pic.png" to relative
        // so that the browser will resolve them against <base href> instead of hitting the domain root
        $html = preg_replace_callback(
            '/\b(href|src)=(["\'])\/([^"\'\/][^"\']*)(\2)/i',
            function ($matches) use ($slug) {
                if (str_starts_with($matches[3], 'p/'.$slug)) {
                    return $matches[0];
                }

                return $matches[1].'='.$matches[2].$matches[3].$matches[4];
            },
            $html
        );

        return $html;
    }

    /**
     * Inject or update <base href="..."> in HTML content
     */
    protected function ensureBaseTag(string $html, string $baseHref): string
    {
        $baseTag = "<base href=\"{$baseHref}\">";

        if (preg_match('/<base\s+href=["\'][^"\']*["\']\s*\/?>/i', $html)) {
            return preg_replace('/<base\s+href=["\'][^"\']*["\']\s*\/?>/i', $baseTag, $html, 1);
        }

        if (stripos($html, '<head>') !== false) {
            return str_ireplace('<head>', "<head>\n    {$baseTag}", $html);
        }

        if (stripos($html, '<head ') !== false) {
            return preg_replace('/(<head[^>]*>)/i', "$1\n    {$baseTag}", $html, 1);
        }

        return "{$baseTag}\n".$html;
    }
}
