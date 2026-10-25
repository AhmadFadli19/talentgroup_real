<?php

namespace App\Services;

use Exception;
use ZipArchive;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class PrototypeZipService
{
    /**
     * Dangerous extensions that must never be extracted or served.
     */
    protected array $blacklistedExtensions = [
        'php', 'phtml', 'phar', 'php3', 'php4', 'php5', 'php7', 'php8',
        'exe', 'bat', 'cmd', 'sh', 'py', 'pl', 'cgi', 'env', 'htaccess',
        'jsp', 'asp', 'aspx', 'vbs', 'scr', 'msi', 'com', 'bin', 'dll'
    ];

    /**
     * Allowed frontend static extensions.
     */
    protected array $allowedExtensions = [
        'html', 'htm', 'css', 'js', 'json', 'map', 'txt', 'markdown', 'md',
        'png', 'jpg', 'jpeg', 'gif', 'svg', 'webp', 'ico', 'bmp', 'avif',
        'woff', 'woff2', 'ttf', 'eot', 'otf',
        'mp3', 'wav', 'ogg', 'mp4', 'webm',
        'pdf', 'xml'
    ];

    /**
     * Process an uploaded ZIP file into the destination directory.
     *
     * @param UploadedFile $zipFile
     * @param string $destinationDir Absolute path to extract files into
     * @return array [
     *    'success' => bool,
     *    'index_path' => string|null,
     *    'html_code' => string,
     *    'css_code' => string,
     *    'js_code' => string,
     *    'file_count' => int,
     *    'error' => string|null
     * ]
     */
    public function extractZip(UploadedFile $zipFile, string $destinationDir): array
    {
        if (!class_exists('ZipArchive')) {
            return [
                'success' => false,
                'error' => 'Ekstensi PHP ZipArchive tidak aktif di server ini.',
            ];
        }

        if (!File::exists($destinationDir)) {
            File::makeDirectory($destinationDir, 0755, true);
        }

        $zip = new ZipArchive();
        $openResult = $zip->open($zipFile->getRealPath());

        if ($openResult !== true) {
            return [
                'success' => false,
                'error' => 'Gagal membuka file ZIP (Kode Error: ' . $openResult . '). Pastikan file ZIP valid dan tidak rusak.',
            ];
        }

        $extractedFiles = 0;
        $ignoredFiles = 0;

        // Iterate through all entries to safely extract valid files and prevent ZipSlip
        for ($i = 0; $i < $zip->numFiles; $i++) {
            $entryName = $zip->getNameIndex($i);

            // Normalize slashes
            $entryName = str_replace('\\', '/', $entryName);

            // Skip MacOS metadata, Git folders, and hidden system files
            if (
                str_contains($entryName, '__MACOSX/') ||
                str_contains($entryName, '/.git/') ||
                str_starts_with($entryName, '.git/') ||
                str_contains($entryName, '/.env') ||
                str_starts_with($entryName, '.env') ||
                str_contains($entryName, '/.DS_Store') ||
                str_starts_with($entryName, '.DS_Store')
            ) {
                continue;
            }

            // Path Traversal / ZipSlip Prevention
            // Remove any leading slashes and ../ segments
            $cleanRelativePath = $this->sanitizeEntryPath($entryName);
            if (empty($cleanRelativePath)) {
                continue;
            }

            // Full target path
            $targetPath = rtrim($destinationDir, '/\\') . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $cleanRelativePath);

            // Safety check: canonical path must stay within destination directory
            $realDest = realpath($destinationDir);
            if ($realDest === false) {
                $realDest = $destinationDir;
            }

            // Directory entry
            if (str_ends_with($entryName, '/')) {
                if (!File::exists($targetPath)) {
                    File::makeDirectory($targetPath, 0755, true);
                }
                continue;
            }

            // File extension check
            $ext = strtolower(pathinfo($cleanRelativePath, PATHINFO_EXTENSION));

            // Disallow blacklisted files immediately
            if (in_array($ext, $this->blacklistedExtensions, true)) {
                $ignoredFiles++;
                continue;
            }

            // Ensure parent directory exists
            $parentDir = dirname($targetPath);
            if (!File::exists($parentDir)) {
                File::makeDirectory($parentDir, 0755, true);
            }

            // Extract file stream safely
            $content = $zip->getFromIndex($i);
            if ($content !== false) {
                file_put_contents($targetPath, $content);
                $extractedFiles++;
            }
        }

        $zip->close();

        if ($extractedFiles === 0) {
            return [
                'success' => false,
                'error' => 'File ZIP kosong atau tidak berisi file statis yang diizinkan.',
            ];
        }

        // CRITICAL: Handle nested folder wrapping (e.g. ZIP contains a single folder like "project/index.html")
        $this->flattenNestedRootFolder($destinationDir);

        // Normalize / find index.html
        $indexPath = $this->ensureIndexHtml($destinationDir);

        if (!$indexPath || !File::exists($indexPath)) {
            return [
                'success' => false,
                'error' => 'File index.html tidak ditemukan di dalam ZIP. Pastikan file HTML utama Anda bernama index.html.',
            ];
        }

        // Read code assets
        $codePayload = $this->gatherCodePayload($destinationDir, $indexPath);

        return [
            'success' => true,
            'index_path' => $indexPath,
            'html_code' => $codePayload['html'],
            'css_code' => $codePayload['css'],
            'js_code' => $codePayload['js'],
            'file_count' => $extractedFiles,
            'ignored_files' => $ignoredFiles,
            'error' => null,
        ];
    }

    /**
     * Process manual file uploads (HTML required, CSS/JS/Slides/Assets optional).
     *
     * @param UploadedFile|null $htmlFile Primary HTML file (saved as index.html)
     * @param UploadedFile|null $cssFile Optional single CSS file (saved as style.css)
     * @param UploadedFile|null $jsFile Optional single JS file (saved as script.js)
     * @param string $destinationDir
     * @param array $additionalFiles Optional array of UploadedFile (e.g. slide1.html, slide2.html, images, etc.)
     * @return array
     */
    public function createFromManualFiles(
        ?UploadedFile $htmlFile,
        ?UploadedFile $cssFile,
        ?UploadedFile $jsFile,
        string $destinationDir,
        array $additionalFiles = []
    ): array
    {
        if (!File::exists($destinationDir)) {
            File::makeDirectory($destinationDir, 0755, true);
        }

        if (!$htmlFile) {
            return [
                'success' => false,
                'error' => 'File HTML (.html) wajib diunggah sebagai halaman utama (index.html) prototype.',
            ];
        }

        // Read and save HTML
        $htmlContent = file_get_contents($htmlFile->getRealPath());
        $cssContent = '';
        $jsContent = '';

        // Handle CSS if provided
        if ($cssFile && $cssFile->isValid()) {
            $cssContent = file_get_contents($cssFile->getRealPath());
            file_put_contents($destinationDir . DIRECTORY_SEPARATOR . 'style.css', $cssContent);

            // Automatically inject <link rel="stylesheet" href="style.css"> if not already linked
            if (!str_contains($htmlContent, 'style.css')) {
                if (stripos($htmlContent, '</head>') !== false) {
                    $htmlContent = str_ireplace('</head>', "    <link rel=\"stylesheet\" href=\"style.css\">\n</head>", $htmlContent);
                } else {
                    $htmlContent = "<link rel=\"stylesheet\" href=\"style.css\">\n" . $htmlContent;
                }
            }
        }

        // Handle JS if provided
        if ($jsFile && $jsFile->isValid()) {
            $jsContent = file_get_contents($jsFile->getRealPath());
            file_put_contents($destinationDir . DIRECTORY_SEPARATOR . 'script.js', $jsContent);

            // Automatically inject <script src="script.js"></script> if not already linked
            if (!str_contains($htmlContent, 'script.js')) {
                if (stripos($htmlContent, '</body>') !== false) {
                    $htmlContent = str_ireplace('</body>', "    <script src=\"script.js\"></script>\n</body>", $htmlContent);
                } else {
                    $htmlContent .= "\n<script src=\"script.js\"></script>";
                }
            }
        }

        // Save index.html
        $indexPath = $destinationDir . DIRECTORY_SEPARATOR . 'index.html';
        file_put_contents($indexPath, $htmlContent);

        // Process any additional files (slides, secondary HTML, CSS, JS, images, etc.)
        foreach ($additionalFiles as $file) {
            if (!$file || !($file instanceof UploadedFile) || !$file->isValid()) {
                continue;
            }

            $originalName = $file->getClientOriginalName();
            $cleanRelativePath = $this->sanitizeEntryPath($originalName);
            if (empty($cleanRelativePath)) {
                continue;
            }

            $ext = strtolower(pathinfo($cleanRelativePath, PATHINFO_EXTENSION));
            if (in_array($ext, $this->blacklistedExtensions, true)) {
                continue;
            }

            $targetPath = rtrim($destinationDir, '/\\') . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $cleanRelativePath);
            $parentDir = dirname($targetPath);
            if (!File::exists($parentDir)) {
                File::makeDirectory($parentDir, 0755, true);
            }

            file_put_contents($targetPath, file_get_contents($file->getRealPath()));
        }

        $allFiles = File::allFiles($destinationDir);
        $fileCount = count($allFiles);

        $codePayload = $this->gatherCodePayload($destinationDir, $indexPath);

        return [
            'success' => true,
            'index_path' => $indexPath,
            'html_code' => $codePayload['html'],
            'css_code' => $codePayload['css'],
            'js_code' => $codePayload['js'],
            'file_count' => $fileCount,
            'error' => null,
        ];
    }

    /**
     * Sanitize entry path to prevent ZipSlip and directory traversal.
     */
    protected function sanitizeEntryPath(string $entry): string
    {
        $parts = explode('/', $entry);
        $safeParts = [];

        foreach ($parts as $part) {
            $part = trim($part);
            if ($part === '' || $part === '.' || $part === '..') {
                continue;
            }
            // Strip any remaining colon or drive letters (e.g. C:)
            $part = str_replace([':', '\\'], '', $part);
            $safeParts[] = $part;
        }

        return implode('/', $safeParts);
    }

    /**
     * If user compressed a folder and all extracted items are inside a single root subdirectory,
     * promote all contents to the root of the destination directory.
     */
    protected function flattenNestedRootFolder(string $dir): void
    {
        $items = File::glob(rtrim($dir, '/\\') . DIRECTORY_SEPARATOR . '*');

        // Check if index.html already exists at top level
        foreach ($items as $item) {
            if (strtolower(basename($item)) === 'index.html' || strtolower(basename($item)) === 'index.htm') {
                return; // Already has index at root!
            }
        }

        // If exactly 1 directory at root level and no files
        $dirsOnly = array_filter($items, 'is_dir');
        $filesOnly = array_filter($items, 'is_file');

        if (count($dirsOnly) === 1 && count($filesOnly) === 0) {
            $singleSubDir = reset($dirsOnly);
            $subItems = File::allFiles($singleSubDir, true);
            $subDirs = File::directories($singleSubDir);

            // Move all files and directories up one level
            foreach (File::glob(rtrim($singleSubDir, '/\\') . DIRECTORY_SEPARATOR . '*') as $subItem) {
                $targetName = basename($subItem);
                $destination = rtrim($dir, '/\\') . DIRECTORY_SEPARATOR . $targetName;
                File::move($subItem, $destination);
            }

            // Remove the empty subdirectory
            @rmdir($singleSubDir);
            return;
        }

        // Alternative scan: If index.html is located somewhere in a subfolder (e.g. "dist/index.html" or "src/index.html")
        $allHtmlFiles = File::glob(rtrim($dir, '/\\') . '/**/index.html');
        if (empty($allHtmlFiles)) {
            $allHtmlFiles = File::glob(rtrim($dir, '/\\') . '/**/*.html');
        }

        if (!empty($allHtmlFiles)) {
            $firstHtml = reset($allHtmlFiles);
            $parentFolder = dirname($firstHtml);

            // If index is in a nested folder and root has no index, copy or promote
            if ($parentFolder !== $dir && File::exists($firstHtml)) {
                // If the parent folder has the website assets, move items to root
                foreach (File::glob(rtrim($parentFolder, '/\\') . DIRECTORY_SEPARATOR . '*') as $subItem) {
                    $targetDest = rtrim($dir, '/\\') . DIRECTORY_SEPARATOR . basename($subItem);
                    if (!File::exists($targetDest)) {
                        @File::copyDirectory($subItem, $targetDest);
                        if (is_file($subItem)) {
                            @copy($subItem, $targetDest);
                        }
                    }
                }
            }
        }
    }

    /**
     * Ensure an index.html exists in the target directory (case-insensitive search).
     */
    protected function ensureIndexHtml(string $dir): ?string
    {
        $exactIndex = rtrim($dir, '/\\') . DIRECTORY_SEPARATOR . 'index.html';
        if (File::exists($exactIndex)) {
            return $exactIndex;
        }

        // Check for index.htm, Index.html, INDEX.HTML
        $files = File::files($dir);
        foreach ($files as $file) {
            $filename = strtolower($file->getFilename());
            if ($filename === 'index.html' || $filename === 'index.htm') {
                // Rename or copy to standard index.html
                if ($file->getFilename() !== 'index.html') {
                    File::copy($file->getRealPath(), $exactIndex);
                }
                return $exactIndex;
            }
        }

        // If no index.html, look for any .html file and copy it as index.html
        foreach ($files as $file) {
            if (strtolower($file->getExtension()) === 'html' || strtolower($file->getExtension()) === 'htm') {
                File::copy($file->getRealPath(), $exactIndex);
                return $exactIndex;
            }
        }

        return null;
    }

    /**
     * Read and gather code content (HTML, CSS, JS) for system inspection.
     */
    protected function gatherCodePayload(string $dir, string $indexPath): array
    {
        $htmlCode = File::exists($indexPath) ? File::get($indexPath) : '';

        // Check for other HTML files (slides, subpages)
        $allHtmlFiles = File::glob(rtrim($dir, '/\\') . '/**/*.html');
        foreach ($allHtmlFiles as $otherHtml) {
            if (realpath($otherHtml) === realpath($indexPath)) {
                continue;
            }
            $filename = basename($otherHtml);
            if (strlen($htmlCode) < 45000) {
                $htmlCode .= "\n\n<!-- [Subpage / Slide: {$filename}] -->\n" . substr(File::get($otherHtml), 0, 5000);
            }
        }

        // Limit HTML length (first 50,000 chars)
        if (strlen($htmlCode) > 50000) {
            $htmlCode = substr($htmlCode, 0, 50000) . "\n<!-- [Truncated Content] -->";
        }

        // Find CSS files
        $cssCode = '';
        $cssFiles = File::glob(rtrim($dir, '/\\') . '/**/*.css');
        foreach ($cssFiles as $cssFile) {
            if (strlen($cssCode) < 30000) {
                $cssCode .= "/* File: " . basename($cssFile) . " */\n" . File::get($cssFile) . "\n\n";
            }
        }
        if (strlen($cssCode) > 30000) {
            $cssCode = substr($cssCode, 0, 30000) . "\n/* [Truncated Content] */";
        }

        // Find JS files
        $jsCode = '';
        $jsFiles = File::glob(rtrim($dir, '/\\') . '/**/*.js');
        foreach ($jsFiles as $jsFile) {
            $filename = basename($jsFile);
            // Skip minified vendor libraries to save tokens and focus on user code
            if (str_contains($filename, '.min.js') || str_contains($filename, 'vendor') || str_contains($filename, 'jquery')) {
                continue;
            }
            if (strlen($jsCode) < 30000) {
                $jsCode .= "// File: " . $filename . "\n" . File::get($jsFile) . "\n\n";
            }
        }
        if (strlen($jsCode) > 30000) {
            $jsCode = substr($jsCode, 0, 30000) . "\n// [Truncated Content]";
        }

        return [
            'html' => $htmlCode,
            'css' => $cssCode,
            'js' => $jsCode,
        ];
    }

    /**
     * Inject base tag into index.html so relative paths resolve cleanly at /p/{slug}/
     */
    public function injectBaseTag(string $indexPath, string $baseHref): void
    {
        if (!File::exists($indexPath)) {
            return;
        }

        $content = File::get($indexPath);
        $baseTag = "<base href=\"{$baseHref}\">";

        // If <base> tag already exists, replace or retain
        if (preg_match('/<base\s+href=["\'][^"\']*["\']\s*\/?>/i', $content)) {
            $content = preg_replace('/<base\s+href=["\'][^"\']*["\']\s*\/?>/i', $baseTag, $content, 1);
        } else {
            // Inject right after <head> or at top of file
            if (stripos($content, '<head>') !== false) {
                $content = str_ireplace('<head>', "<head>\n    {$baseTag}", $content);
            } elseif (stripos($content, '<head ') !== false) {
                $content = preg_replace('/(<head[^>]*>)/i', "$1\n    {$baseTag}", $content, 1);
            } else {
                $content = "{$baseTag}\n" . $content;
            }
        }

        File::put($indexPath, $content);
    }
}
