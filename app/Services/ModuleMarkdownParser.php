<?php

namespace App\Services;

use Illuminate\Support\Str;

class ModuleMarkdownParser
{
    /**
     * Parse raw markdown string to rich HTML tailored for Tailwind Docs aesthetic.
     */
    public static function parse(string $markdown): string
    {
        if (trim($markdown) === '') {
            return '<div class="text-slate-400 italic py-8">Belum ada konten untuk modul ini.</div>';
        }

        // Normalize newlines
        $text = str_replace(["\r\n", "\r"], "\n", $markdown);

        $tokens = [];
        $tokenIndex = 0;

        // 1. Process custom HTML <code file="..."> ... </code> or <code> ... </code> tags
        $text = preg_replace_callback('/<code(?:\s+file=["\']([^"\']+)["\'])?(?:\s+lang=["\']([^"\']+)["\'])?>([\s\S]*?)<\/code>/i', function ($matches) use (&$tokens, &$tokenIndex) {
            $filename = !empty($matches[1]) ? $matches[1] : (!empty($matches[2]) ? strtoupper($matches[2]) : 'Code');
            $code = htmlspecialchars_decode(trim($matches[3]));
            $token = '___DOC_TOKEN_CODE_' . ($tokenIndex++) . '___';
            $tokens[$token] = self::renderCodeBlock($code, $filename);
            return "\n\n" . $token . "\n\n";
        }, $text);

        // 2. Process Fenced Code Blocks: ```lang:filename or ```lang
        $text = preg_replace_callback('/```([a-zA-Z0-9_\-\.\+]+)?(?::([^\n]+))?\n([\s\S]*?)```/', function ($matches) use (&$tokens, &$tokenIndex) {
            $lang = !empty($matches[1]) ? trim($matches[1]) : 'text';
            $filename = !empty($matches[2]) ? trim($matches[2]) : null;
            
            if (!$filename) {
                if (str_contains($lang, '.')) {
                    $filename = $lang;
                } else {
                    $filename = strtoupper($lang);
                }
            }

            $code = $matches[3];
            $token = '___DOC_TOKEN_CODE_' . ($tokenIndex++) . '___';
            $tokens[$token] = self::renderCodeBlock($code, $filename, $lang);
            return "\n\n" . $token . "\n\n";
        }, $text);

        // 3. Process Tables
        $text = preg_replace_callback('/((?:^\|[^\n]+\|\r?\n?){2,})/m', function ($matches) use (&$tokens, &$tokenIndex) {
            $token = '___DOC_TOKEN_TABLE_' . ($tokenIndex++) . '___';
            $tokens[$token] = self::renderTable($matches[1]);
            return "\n\n" . $token . "\n\n";
        }, $text);

        // 4. Process Callout alerts (> [!NOTE], > [!TIP], > [!WARNING], > [!IMPORTANT])
        $text = preg_replace_callback('/^>\s*\[!(NOTE|TIP|WARNING|IMPORTANT|CAUTION)\]\s*\n((?:^>[^\n]*\n?)*)/mi', function ($matches) use (&$tokens, &$tokenIndex) {
            $type = strtoupper($matches[1]);
            $body = preg_replace('/^>\s?/m', '', $matches[2]);
            $token = '___DOC_TOKEN_CALLOUT_' . ($tokenIndex++) . '___';
            $tokens[$token] = self::renderCallout($type, trim($body));
            return "\n\n" . $token . "\n\n";
        }, $text);

        // 5. Standard Blockquotes
        $text = preg_replace_callback('/((?:^>[^\n]+\n?)+)/m', function ($matches) use (&$tokens, &$tokenIndex) {
            $content = preg_replace('/^>\s?/m', '', $matches[1]);
            $token = '___DOC_TOKEN_QUOTE_' . ($tokenIndex++) . '___';
            $tokens[$token] = '<blockquote class="border-l-4 border-cyan-500 bg-cyan-500/10 px-4 py-3 my-4 rounded-r-lg text-slate-800 dark:text-slate-300 italic">' . nl2br(trim($content)) . '</blockquote>';
            return "\n\n" . $token . "\n\n";
        }, $text);

        // Split into lines for headings, paragraphs, lists
        $lines = explode("\n", $text);
        $output = [];
        $inList = false;
        $listType = 'ul';
        $paragraph = [];

        $flushParagraph = function () use (&$paragraph, &$output) {
            if (!empty($paragraph)) {
                $pText = trim(implode(' ', $paragraph));
                if ($pText !== '') {
                    $pText = self::parseInlineElements($pText);
                    $output[] = '<p class="text-slate-800 dark:text-slate-200 text-[15px] leading-relaxed mb-5 font-normal">' . $pText . '</p>';
                }
                $paragraph = [];
            }
        };

        $closeList = function () use (&$inList, &$listType, &$output) {
            if ($inList) {
                $output[] = "</{$listType}>";
                $inList = false;
            }
        };

        foreach ($lines as $line) {
            $trimmed = trim($line);

            // Check if line is a token placeholder
            if (isset($tokens[$trimmed])) {
                $flushParagraph();
                $closeList();
                $output[] = $tokens[$trimmed];
                continue;
            }

            // Headings
            if (preg_match('/^(#{1,6})\s+(.+)$/', $trimmed, $hMatches)) {
                $flushParagraph();
                $closeList();
                $level = strlen($hMatches[1]);
                $title = trim($hMatches[2]);
                $id = Str::slug(strip_tags($title));

                if ($level === 1) {
                    $output[] = '<h1 id="' . $id . '" class="text-2xl sm:text-3xl md:text-4xl font-extrabold text-slate-900 dark:text-white tracking-tight mt-6 mb-4 scroll-mt-24">' . self::parseInlineElements($title) . '</h1>';
                } elseif ($level === 2) {
                    $output[] = '<h2 id="' . $id . '" class="text-xl sm:text-2xl font-bold text-slate-900 dark:text-white tracking-tight mt-8 mb-4 pt-3 border-t border-slate-200 dark:border-slate-800/80 scroll-mt-24 flex items-center justify-between group">' .
                                '<span>' . self::parseInlineElements($title) . '</span>' .
                                '<a href="#' . $id . '" class="text-slate-400 dark:text-slate-600 hover:text-cyan-500 dark:hover:text-cyan-400 opacity-0 group-hover:opacity-100 transition-opacity ml-2 text-lg">#</a>' .
                                '</h2>';
                } elseif ($level === 3) {
                    $output[] = '<h3 id="' . $id . '" class="text-lg sm:text-xl font-bold text-slate-900 dark:text-slate-100 tracking-tight mt-6 mb-3 scroll-mt-24 flex items-center justify-between group">' .
                                '<span>' . self::parseInlineElements($title) . '</span>' .
                                '<a href="#' . $id . '" class="text-slate-400 dark:text-slate-600 hover:text-cyan-500 dark:hover:text-cyan-400 opacity-0 group-hover:opacity-100 transition-opacity ml-2 text-base">#</a>' .
                                '</h3>';
                } else {
                    $output[] = '<h4 id="' . $id . '" class="text-base font-semibold text-slate-800 dark:text-slate-200 mt-5 mb-2 scroll-mt-24">' . self::parseInlineElements($title) . '</h4>';
                }
                continue;
            }

            // Lists (unordered: -, *, •)
            if (preg_match('/^[\-\*\•]\s+(.+)$/', $trimmed, $liMatches)) {
                $flushParagraph();
                if (!$inList || $listType !== 'ul') {
                    $closeList();
                    $output[] = '<ul class="list-disc pl-5 space-y-2 mb-5 text-slate-800 dark:text-slate-300 text-[15px]">';
                    $inList = true;
                    $listType = 'ul';
                }
                $output[] = '<li class="leading-relaxed">' . self::parseInlineElements($liMatches[1]) . '</li>';
                continue;
            }

            // Lists (ordered: 1. 2.)
            if (preg_match('/^\d+\.\s+(.+)$/', $trimmed, $liMatches)) {
                $flushParagraph();
                if (!$inList || $listType !== 'ol') {
                    $closeList();
                    $output[] = '<ol class="list-decimal pl-5 space-y-2 mb-5 text-slate-800 dark:text-slate-300 text-[15px]">';
                    $inList = true;
                    $listType = 'ol';
                }
                $output[] = '<li class="leading-relaxed">' . self::parseInlineElements($liMatches[1]) . '</li>';
                continue;
            }

            // Images: ![alt](url)
            if (preg_match('/^!\[(.*?)\]\((.*?)\)$/', $trimmed, $imgMatches)) {
                $flushParagraph();
                $closeList();
                $alt = htmlspecialchars($imgMatches[1]);
                $src = htmlspecialchars($imgMatches[2]);
                $output[] = '<figure class="my-6 rounded-xl overflow-hidden border border-slate-800 bg-slate-900/60 p-2 shadow-2xl">' .
                            '<img src="' . $src . '" alt="' . $alt . '" class="w-full h-auto rounded-lg object-contain max-h-[500px] mx-auto" loading="lazy" />' .
                            ($alt ? '<figcaption class="text-xs text-slate-400 mt-2 text-center italic">' . $alt . '</figcaption>' : '') .
                            '</figure>';
                continue;
            }

            // Horizontal Rule: --- or ***
            if (preg_match('/^(?:---|\*\*\*|___)$/', $trimmed)) {
                $flushParagraph();
                $closeList();
                $output[] = '<hr class="my-8 border-slate-800" />';
                continue;
            }

            // Empty line: flush paragraph
            if ($trimmed === '') {
                $flushParagraph();
                $closeList();
                continue;
            }

            // Otherwise, accumulate line to paragraph
            $paragraph[] = $line;
        }

        $flushParagraph();
        $closeList();

        $finalHtml = implode("\n", $output);

        // Fallback safety: replace any residual tokens
        foreach ($tokens as $tokenKey => $tokenVal) {
            $finalHtml = str_replace($tokenKey, $tokenVal, $finalHtml);
        }

        return $finalHtml;
    }

    /**
     * Extract headings for Table of Contents ("ON THIS PAGE").
     */
    public static function extractTableOfContents(string $markdown): array
    {
        $toc = [];
        $lines = explode("\n", str_replace(["\r\n", "\r"], "\n", $markdown));
        $inCodeBlock = false;

        foreach ($lines as $line) {
            $trimmed = trim($line);
            if (str_starts_with($trimmed, '```')) {
                $inCodeBlock = !$inCodeBlock;
                continue;
            }
            if ($inCodeBlock) continue;

            if (preg_match('/^(#{1,3})\s+(.+)$/', $trimmed, $matches)) {
                $level = strlen($matches[1]);
                $title = strip_tags(trim($matches[2]));
                $id = Str::slug($title);

                $toc[] = [
                    'level' => $level,
                    'title' => $title,
                    'id' => $id,
                ];
            }
        }

        return $toc;
    }

    /**
     * Parse inline markdown (bold, italic, inline code, links).
     */
    public static function parseInlineElements(string $text): string
    {
        // Inline code: `code`
        $text = preg_replace_callback('/`([^`]+)`/', function ($m) {
            return '<code class="px-1.5 py-0.5 rounded bg-slate-100 dark:bg-slate-800/90 text-cyan-700 dark:text-cyan-300 font-mono text-[13px] border border-slate-300 dark:border-slate-700/70 font-medium">' . htmlspecialchars($m[1]) . '</code>';
        }, $text);

        // Images inline: ![alt](url)
        $text = preg_replace('/!\[(.*?)\]\((.*?)\)/', '<img src="$2" alt="$1" class="rounded max-w-full inline-block my-2" />', $text);

        // Links: [text](url)
        $text = preg_replace('/\[(.*?)\]\((.*?)\)/', '<a href="$2" class="text-cyan-600 dark:text-cyan-400 hover:text-cyan-500 dark:hover:text-cyan-300 underline underline-offset-4 decoration-cyan-500/40 hover:decoration-cyan-400 transition">$1</a>', $text);

        // Bold: **text** or __text__
        $text = preg_replace('/(\*\*|__)(.*?)\1/', '<strong class="font-bold text-slate-900 dark:text-white">$2</strong>', $text);

        // Italic: *text* or _text_
        $text = preg_replace('/(\*|_)(.*?)\1/', '<em class="italic text-slate-800 dark:text-slate-200">$2</em>', $text);

        // Strikethrough: ~~text~~
        $text = preg_replace('/~~(.*?)~~/', '<del class="line-through text-slate-500">$1</del>', $text);

        return $text;
    }

    /**
     * Render the Tailwind-style framed code block with filename header pill and copy button.
     */
    public static function renderCodeBlock(string $code, ?string $filename = null, string $lang = 'text'): string
    {
        $rawCode = trim($code);
        $escapedCode = htmlspecialchars($rawCode, ENT_QUOTES, 'UTF-8');
        $displayFile = $filename ?: strtoupper($lang);
        $uniqueId = 'code_' . Str::random(8);

        $cleanLang = strtolower($lang);
        if ($cleanLang === 'js') $cleanLang = 'javascript';
        if ($cleanLang === 'htm') $cleanLang = 'html';
        if ($cleanLang === 'sh') $cleanLang = 'bash';

        return <<<HTML
<div class="code-frame-block my-6 rounded-xl border border-slate-800 bg-[#0b1120] overflow-hidden shadow-2xl transition hover:border-slate-700/80">
    <div class="code-frame-header flex items-center justify-between px-4 py-2.5 bg-[#0e1628] border-b border-slate-800/90 text-xs text-slate-400 font-mono select-none">
        <div class="flex items-center gap-2">
            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-md bg-slate-800/80 text-cyan-300 font-medium border border-slate-700/50 text-[11px] tracking-wide">
                <i class="fas fa-file-code text-[10px] text-cyan-400"></i>
                {$displayFile}
            </span>
        </div>
        <button type="button" 
                onclick="copyCodeBlock('{$uniqueId}', this)" 
                class="copy-code-btn inline-flex items-center gap-1.5 px-2 py-1 rounded-md text-[11px] text-slate-400 hover:text-white bg-slate-800/40 hover:bg-slate-800 border border-transparent hover:border-slate-700 transition">
            <i class="fas fa-copy"></i>
            <span>Salin</span>
        </button>
    </div>
    <div class="code-frame-body relative overflow-x-auto p-4 font-mono text-[13.5px] leading-relaxed text-slate-200 bg-[#070c18]">
        <pre class="m-0 font-mono language-{$cleanLang}"><code id="{$uniqueId}" class="language-{$cleanLang}">{$escapedCode}</code></pre>
    </div>
</div>
HTML;
    }

    /**
     * Render Markdown Table.
     */
    public static function renderTable(string $tableMarkdown): string
    {
        $lines = array_filter(array_map('trim', explode("\n", $tableMarkdown)));
        if (count($lines) < 2) {
            return $tableMarkdown;
        }

        $headerLine = array_shift($lines);
        $alignLine = array_shift($lines); // separator |---|---|

        $headers = array_filter(array_map('trim', explode('|', trim($headerLine, '|'))));

        $html = '<div class="doc-table-wrapper my-6 overflow-x-auto rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-[#0b1120] shadow-md">';
        $html .= '<table class="w-full text-left text-sm border-collapse">';
        $html .= '<thead class="bg-slate-50 dark:bg-[#0f172a] text-xs uppercase tracking-wider text-slate-700 dark:text-slate-300 border-b border-slate-200 dark:border-slate-800 font-semibold">';
        $html .= '<tr>';
        foreach ($headers as $header) {
            $html .= '<th class="px-5 py-3.5 text-slate-800 dark:text-slate-200">' . self::parseInlineElements($header) . '</th>';
        }
        $html .= '</tr></thead>';
        $html .= '<tbody class="divide-y divide-slate-100 dark:divide-slate-800/80 text-slate-800 dark:text-slate-300 text-[13.5px]">';

        foreach ($lines as $line) {
            if (empty($line) || !str_contains($line, '|')) continue;
            $cells = array_map('trim', explode('|', trim($line, '|')));
            $html .= '<tr class="hover:bg-slate-50/80 dark:hover:bg-slate-800/30 transition-colors">';
            foreach ($cells as $cell) {
                $html .= '<td class="px-5 py-3 font-normal">' . self::parseInlineElements($cell) . '</td>';
            }
            $html .= '</tr>';
        }

        $html .= '</tbody></table></div>';
        return $html;
    }

    /**
     * Render callout box (NOTE, TIP, WARNING, IMPORTANT).
     */
    public static function renderCallout(string $type, string $body): string
    {
        $config = [
            'NOTE' => ['border' => 'border-sky-500/40 dark:border-sky-500/70', 'bg' => 'bg-sky-50 dark:bg-sky-950/20', 'icon' => 'fa-info-circle', 'text' => 'text-sky-600 dark:text-sky-400', 'title' => 'Catatan'],
            'TIP' => ['border' => 'border-emerald-500/40 dark:border-emerald-500/70', 'bg' => 'bg-emerald-50 dark:bg-emerald-950/20', 'icon' => 'fa-lightbulb', 'text' => 'text-emerald-600 dark:text-emerald-400', 'title' => 'Tips'],
            'WARNING' => ['border' => 'border-amber-500/40 dark:border-amber-500/70', 'bg' => 'bg-amber-50 dark:bg-amber-950/20', 'icon' => 'fa-exclamation-triangle', 'text' => 'text-amber-600 dark:text-amber-400', 'title' => 'Peringatan'],
            'IMPORTANT' => ['border' => 'border-purple-500/40 dark:border-purple-500/70', 'bg' => 'bg-purple-50 dark:bg-purple-950/20', 'icon' => 'fa-star', 'text' => 'text-purple-600 dark:text-purple-400', 'title' => 'Penting'],
            'CAUTION' => ['border' => 'border-rose-500/40 dark:border-rose-500/70', 'bg' => 'bg-rose-50 dark:bg-rose-950/20', 'icon' => 'fa-radiation', 'text' => 'text-rose-600 dark:text-rose-400', 'title' => 'Perhatian'],
        ];

        $style = $config[$type] ?? $config['NOTE'];

        $parsedBody = self::parseInlineElements(nl2br($body));

        return <<<HTML
<div class="doc-callout my-6 rounded-xl border {$style['border']} {$style['bg']} p-4 shadow-sm backdrop-blur-sm">
    <div class="flex items-start gap-3">
        <i class="fas {$style['icon']} {$style['text']} mt-0.5 text-base"></i>
        <div class="flex-1">
            <span class="block text-xs font-bold uppercase tracking-wider {$style['text']} mb-1">{$style['title']}</span>
            <div class="text-[14px] text-slate-800 dark:text-slate-200 leading-relaxed font-normal">{$parsedBody}</div>
        </div>
    </div>
</div>
HTML;
    }
}
