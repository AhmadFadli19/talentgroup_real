<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use ZipArchive;

class PrototypeZipService
{
    /**
     * Dangerous extensions that must never be extracted or served.
     */
    protected array $blacklistedExtensions = [
        'php', 'phtml', 'phar', 'php3', 'php4', 'php5', 'php7', 'php8',
        'exe', 'bat', 'cmd', 'sh', 'py', 'pl', 'cgi', 'env', 'htaccess',
        'jsp', 'asp', 'aspx', 'vbs', 'scr', 'msi', 'com', 'bin', 'dll',
    ];

    /**
     * Allowed frontend static extensions.
     */
    protected array $allowedExtensions = [
        'html', 'htm', 'css', 'js', 'json', 'map', 'txt', 'markdown', 'md',
        'png', 'jpg', 'jpeg', 'gif', 'svg', 'webp', 'ico', 'bmp', 'avif',
        'woff', 'woff2', 'ttf', 'eot', 'otf',
        'mp3', 'wav', 'ogg', 'mp4', 'webm',
        'pdf', 'xml',
    ];

    /**
     * Process an uploaded ZIP file into the destination directory.
     *
     * @param  string  $destinationDir  Absolute path to extract files into
     * @return array [
     *               'success' => bool,
     *               'index_path' => string|null,
     *               'html_code' => string,
     *               'css_code' => string,
     *               'js_code' => string,
     *               'file_count' => int,
     *               'error' => string|null
     *               ]
     */
    public function extractZip(UploadedFile $zipFile, string $destinationDir): array
    {
        if (! class_exists('ZipArchive')) {
            return [
                'success' => false,
                'error' => 'Ekstensi PHP ZipArchive tidak aktif di server ini.',
            ];
        }

        if (! File::exists($destinationDir)) {
            File::makeDirectory($destinationDir, 0755, true);
        }

        $zip = new ZipArchive;
        $openResult = $zip->open($zipFile->getRealPath());

        if ($openResult !== true) {
            return [
                'success' => false,
                'error' => 'Gagal membuka file ZIP (Kode Error: '.$openResult.'). Pastikan file ZIP valid dan tidak rusak.',
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
            $targetPath = rtrim($destinationDir, '/\\').DIRECTORY_SEPARATOR.str_replace('/', DIRECTORY_SEPARATOR, $cleanRelativePath);

            // Safety check: canonical path must stay within destination directory
            $realDest = realpath($destinationDir);
            if ($realDest === false) {
                $realDest = $destinationDir;
            }

            // Directory entry
            if (str_ends_with($entryName, '/')) {
                if (! File::exists($targetPath)) {
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
            if (! File::exists($parentDir)) {
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

        if (! $indexPath || ! File::exists($indexPath)) {
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
        $root = rtrim($dir, '/\\');

        // Unwrap any number of single wrapper folders, such as project/export/dist.
        for ($depth = 0; $depth < 25; $depth++) {
            $items = File::glob($root.DIRECTORY_SEPARATOR.'*') ?: [];

            foreach ($items as $item) {
                if (in_array(strtolower(basename($item)), ['index.html', 'index.htm'], true)) {
                    return;
                }
            }

            $directories = array_values(array_filter($items, 'is_dir'));
            $files = array_values(array_filter($items, 'is_file'));
            if (count($directories) !== 1 || count($files) !== 0) {
                break;
            }

            $wrapper = $directories[0];
            foreach (File::glob(rtrim($wrapper, '/\\').DIRECTORY_SEPARATOR.'*') ?: [] as $item) {
                File::move($item, $root.DIRECTORY_SEPARATOR.basename($item));
            }
            File::deleteDirectory($wrapper);
        }

        // A project ZIP can include source/config files at its root while its static
        // output lives deeper in public/, dist/, build/, or another nested folder.
        $indexCandidates = array_values(array_filter(
            $this->findFilesByExtensions($root, ['html', 'htm']),
            fn (string $path): bool => in_array(strtolower(basename($path)), ['index.html', 'index.htm'], true)
        ));

        usort($indexCandidates, static function (string $left, string $right) use ($root): int {
            $leftRelative = ltrim(str_replace($root, '', $left), '/\\');
            $rightRelative = ltrim(str_replace($root, '', $right), '/\\');
            $leftDepth = substr_count(str_replace('\\', '/', $leftRelative), '/');
            $rightDepth = substr_count(str_replace('\\', '/', $rightRelative), '/');

            return $leftDepth <=> $rightDepth ?: strcmp($leftRelative, $rightRelative);
        });

        if ($indexCandidates === []) {
            return;
        }

        $selectedIndex = $indexCandidates[0];
        $websiteRoot = dirname($selectedIndex);
        if ($websiteRoot === $root) {
            return;
        }

        // Copy the chosen static output to the hosting root while keeping the
        // original extracted tree intact for compatibility and auditing.
        foreach (File::directories($websiteRoot) as $sourceDirectory) {
            File::copyDirectory(
                $sourceDirectory,
                $root.DIRECTORY_SEPARATOR.basename($sourceDirectory)
            );
        }

        foreach (File::files($websiteRoot) as $sourceFile) {
            $targetName = in_array(strtolower($sourceFile->getFilename()), ['index.html', 'index.htm'], true)
                ? 'index.html'
                : $sourceFile->getFilename();
            File::copy($sourceFile->getPathname(), $root.DIRECTORY_SEPARATOR.$targetName);
        }
    }

    /**
     * Ensure an index.html exists in the target directory (case-insensitive search).
     */
    protected function ensureIndexHtml(string $dir): ?string
    {
        $exactIndex = rtrim($dir, '/\\').DIRECTORY_SEPARATOR.'index.html';
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

        return null;
    }

    /**
     * Recursively find files by extension. PHP glob's ** pattern is not recursive,
     * so all nested prototype folders must be traversed explicitly.
     *
     * @param  array<int, string>  $extensions
     * @return array<int, string>
     */
    public function findFilesByExtensions(string $dir, array $extensions): array
    {
        if (! File::isDirectory($dir)) {
            return [];
        }

        $extensions = array_map(
            static fn (string $extension): string => strtolower(ltrim($extension, '.')),
            $extensions
        );
        $matches = [];

        foreach (File::allFiles($dir) as $file) {
            $path = $file->getPathname();
            $normalizedPath = '/'.ltrim(str_replace('\\', '/', $path), '/');

            if (preg_match('#/(?:node_modules|\.git|__MACOSX)/#i', $normalizedPath)) {
                continue;
            }

            if (in_array(strtolower($file->getExtension()), $extensions, true)) {
                $matches[] = $path;
            }
        }

        sort($matches, SORT_STRING);

        return $matches;
    }

    /**
     * Read and gather code content (HTML, CSS, JS) for system inspection.
     */
    protected function gatherCodePayload(string $dir, string $indexPath): array
    {
        $htmlCode = File::exists($indexPath) ? File::get($indexPath) : '';

        // Check for other HTML files (slides, subpages)
        $allHtmlFiles = $this->findFilesByExtensions($dir, ['html', 'htm']);
        foreach ($allHtmlFiles as $otherHtml) {
            if (realpath($otherHtml) === realpath($indexPath)) {
                continue;
            }
            $filename = basename($otherHtml);
            if (strlen($htmlCode) < 45000) {
                $htmlCode .= "\n\n<!-- [Subpage / Slide: {$filename}] -->\n".substr(File::get($otherHtml), 0, 5000);
            }
        }

        // Limit HTML length (first 50,000 chars)
        if (strlen($htmlCode) > 50000) {
            $htmlCode = substr($htmlCode, 0, 50000)."\n<!-- [Truncated Content] -->";
        }

        // Find CSS files
        $cssCode = '';
        $cssFiles = $this->findFilesByExtensions($dir, ['css']);
        foreach ($cssFiles as $cssFile) {
            if (strlen($cssCode) < 30000) {
                $cssCode .= '/* File: '.basename($cssFile)." */\n".File::get($cssFile)."\n\n";
            }
        }
        if (strlen($cssCode) > 30000) {
            $cssCode = substr($cssCode, 0, 30000)."\n/* [Truncated Content] */";
        }

        // Find JS files
        $jsCode = '';
        $jsFiles = $this->findFilesByExtensions($dir, ['js']);
        foreach ($jsFiles as $jsFile) {
            $filename = basename($jsFile);
            // Skip minified vendor libraries to save tokens and focus on user code
            if (str_contains($filename, '.min.js') || str_contains($filename, 'vendor') || str_contains($filename, 'jquery')) {
                continue;
            }
            if (strlen($jsCode) < 30000) {
                $jsCode .= '// File: '.$filename."\n".File::get($jsFile)."\n\n";
            }
        }
        if (strlen($jsCode) > 30000) {
            $jsCode = substr($jsCode, 0, 30000)."\n// [Truncated Content]";
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
        if (! File::exists($indexPath)) {
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
                $content = "{$baseTag}\n".$content;
            }
        }

        File::put($indexPath, $content);
    }
}
