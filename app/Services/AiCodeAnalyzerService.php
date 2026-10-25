<?php

namespace App\Services;

use App\Models\AiSetting;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Exception;

class AiCodeAnalyzerService
{
    protected AiSetting $settings;

    public function __construct()
    {
        $this->settings = AiSetting::getSettings();
    }

    /**
     * Analyze code payload using the configured AI provider.
     *
     * @param string $html
     * @param string $css
     * @param string $js
     * @return array [
     *    'provider' => string,
     *    'score' => int,
     *    'is_approved' => bool,
     *    'report' => array
     * ]
     */
    public function analyze(string $html, string $css = '', string $js = ''): array
    {
        $provider = $this->settings->active_provider ?: 'openai';
        $report = null;
        $usedProvider = $provider;

        try {
            switch ($provider) {
                case 'openai':
                case 'chatgpt':
                    $report = $this->analyzeWithOpenAi($html, $css, $js);
                    break;

                case 'gemini':
                    $report = $this->analyzeWithGemini($html, $css, $js);
                    break;

                case 'deepseek':
                    $report = $this->analyzeWithDeepSeek($html, $css, $js);
                    break;

                case 'qwen':
                    $report = $this->analyzeWithQwen($html, $css, $js);
                    break;

                default:
                    $report = $this->analyzeWithOpenAi($html, $css, $js) ?: $this->analyzeWithGemini($html, $css, $js);
                    break;
            }
        } catch (Exception $e) {
            Log::warning("AI Provider '{$provider}' failed: " . $e->getMessage());
            $report = null;
        }

        // If primary provider (e.g. OpenAI) had quota exhausted or returned null, try secondary failovers
        if (!$report || !isset($report['overall_score'])) {
            if ($provider !== 'gemini' && !empty($this->settings->gemini_api_key ?: env('GEMINI_API_KEY'))) {
                try {
                    $geminiReport = $this->analyzeWithGemini($html, $css, $js);
                    if ($geminiReport && isset($geminiReport['overall_score'])) {
                        $report = $geminiReport;
                        $usedProvider = 'gemini (Failover from ' . $provider . ')';
                    }
                } catch (Exception $e) {
                    // Ignore failover error
                }
            }
        }

        // If provider returned null or failed, use smart heuristic fallback engine
        if (!$report || !isset($report['overall_score'])) {
            $report = $this->heuristicAnalysis($html, $css, $js);
            $usedProvider = $provider . ' (Fallback Heuristic Engine)';
        }

        $minScore = $this->settings->min_passing_score ?: 75;
        $overallScore = intval($report['overall_score'] ?? 0);
        $isApproved = ($overallScore >= $minScore);

        // Ensure is_approved_for_hosting matches min_score threshold
        $report['is_approved_for_hosting'] = $isApproved;
        $report['min_passing_score'] = $minScore;

        return [
            'provider' => $usedProvider,
            'score' => $overallScore,
            'is_approved' => $isApproved,
            'report' => $report,
        ];
    }

    /**
     * Build the prompt for AI evaluation based on admin criteria.
     */
    protected function buildPrompt(string $html, string $css, string $js): string
    {
        $criteria = [];
        if ($this->settings->check_code_errors) {
            $criteria[] = "- Syntax & Error Detection: Tag HTML tidak tertutup, kesalahan properti CSS, variabel atau error syntax JS.";
        }
        if ($this->settings->check_performance) {
            $criteria[] = "- Performance: Efisiensi kode, ukuran inline asset, render-blocking scripts, selektor CSS efisien.";
        }
        if ($this->settings->check_seo) {
            $criteria[] = "- SEO: Keberadaan <title>, <meta name='description'>, <meta name='viewport'>, struktur heading (h1-h6), atribut alt pada img.";
        }
        if ($this->settings->check_best_practices) {
            $criteria[] = "- Best Practices & Accessibility: Penggunaan Semantic HTML5 (header, nav, main, footer), keterbacaan kode, kontras dasar.";
        }
        if ($this->settings->check_security) {
            $criteria[] = "- Security Check: Tidak ada form phishing mencurigakan, malicious redirect, crypto-miner, atau script berbahaya.";
        }

        $criteriaText = implode("\n", $criteria);
        $customPrompt = $this->settings->custom_rules_prompt ? "\nInstruksi Khusus Admin:\n" . $this->settings->custom_rules_prompt : '';

        return <<<PROMPT
Anda adalah "AI Agent Code Auditor & Hosting Assessor" untuk platform Flow Academy.
Tugas Anda adalah memeriksa kode prototype website (HTML, CSS, JS) berikut dan memberikan penilaian kualitas yang objektif, mendalam, dan terstruktur.

Kriteria Pemeriksaan yang Diaktifkan:
{$criteriaText}
{$customPrompt}

Kode yang Diperiksa:
=== HTML ===
{$html}

=== CSS ===
{$css}

=== JAVASCRIPT ===
{$js}

PENTING: Anda WAJIB memberikan respons HANYA dalam format JSON murni tanpa pembungkus markdown atau penjelasan teks di luar JSON. Format JSON:
{
  "overall_score": 85,
  "is_approved_for_hosting": true,
  "verdict_summary": "Ringkasan penilaian Anda dalam 1-2 kalimat bahasa Indonesia yang ramah dan profesional.",
  "categories": {
    "performance": {
      "score": 85,
      "issues": ["Daftar masalah performa jika ada..."],
      "recommendations": ["Daftar saran peningkatan performa..."]
    },
    "seo": {
      "score": 80,
      "issues": ["Daftar masalah SEO jika ada..."],
      "recommendations": ["Daftar saran optimasi SEO..."]
    },
    "code_errors": {
      "score": 90,
      "issues": ["Daftar bug atau typo syntax jika ada..."],
      "recommendations": ["Daftar perbaikan syntax jika ada..."]
    },
    "best_practices": {
      "score": 85,
      "issues": ["Daftar pelanggaran best practice jika ada..."],
      "recommendations": ["Daftar rekomendasi praktik terbaik..."]
    },
    "security": {
      "score": 95,
      "issues": ["Daftar potensi celah keamanan jika ada..."],
      "recommendations": ["Daftar rekomendasi keamanan..."]
    }
  }
}
PROMPT;
    }

    /**
     * Analyze with OpenAI ChatGPT API (Utama)
     */
    protected function analyzeWithOpenAi(string $html, string $css, string $js): ?array
    {
        $apiKey = $this->settings->openai_api_key ?: env('OPENAI_API_KEY');
        if (empty($apiKey)) {
            return null;
        }

        $model = $this->settings->openai_model ?: env('OPENAI_MODEL', 'gpt-4o-mini');
        $url = 'https://api.openai.com/v1/chat/completions';

        $prompt = $this->buildPrompt($html, $css, $js);

        $response = Http::withHeaders([
            'Authorization' => "Bearer {$apiKey}",
            'Content-Type'  => 'application/json',
        ])->timeout(12)->post($url, [
            'model' => $model,
            'messages' => [
                ['role' => 'system', 'content' => 'You are an expert static web code auditor. Always output pure valid JSON only.'],
                ['role' => 'user', 'content' => $prompt]
            ],
            'response_format' => ['type' => 'json_object'],
            'temperature' => 0.2,
        ]);

        if (!$response->successful()) {
            $errBody = $response->json();
            $errMsg = $errBody['error']['message'] ?? $response->body();
            Log::warning("OpenAI ChatGPT API Error ({$response->status()}): {$errMsg}");
            return null;
        }

        $data = $response->json();
        $text = $data['choices'][0]['message']['content'] ?? '';
        return $this->parseJsonSafely($text);
    }

    /**
     * Analyze with Google Gemini API
     */
    protected function analyzeWithGemini(string $html, string $css, string $js): ?array
    {
        $apiKey = $this->settings->gemini_api_key ?: env('GEMINI_API_KEY');
        if (empty($apiKey)) {
            return null;
        }

        $primaryModel = $this->settings->gemini_model ?: 'gemini-3.5-flash';
        $modelsToTry = array_unique([$primaryModel, 'gemini-3.8-flash']);

        $prompt = $this->buildPrompt($html, $css, $js);

        foreach ($modelsToTry as $model) {
            $url = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$apiKey}";

            try {
                $response = Http::timeout(6)->post($url, [
                    'contents' => [
                        [
                            'parts' => [
                                ['text' => $prompt]
                            ]
                        ]
                    ],
                    'generationConfig' => [
                        'response_mime_type' => 'application/json',
                        'temperature' => 0.2,
                    ]
                ]);

                if ($response->successful()) {
                    $data = $response->json();
                    $text = $data['candidates'][0]['content']['parts'][0]['text'] ?? '';
                    $parsed = $this->parseJsonSafely($text);
                    if ($parsed && isset($parsed['overall_score'])) {
                        return $parsed;
                    }
                }
            } catch (Exception $e) {
                // Timeout or network error
            }
        }

        return null;
    }

    /**
     * Analyze with DeepSeek API
     */
    protected function analyzeWithDeepSeek(string $html, string $css, string $js): ?array
    {
        $apiKey = $this->settings->deepseek_api_key ?: env('DEEPSEEK_API_KEY');
        if (empty($apiKey)) {
            return null;
        }

        $model = $this->settings->deepseek_model ?: 'deepseek-chat';
        $url = 'https://api.deepseek.com/chat/completions';

        $prompt = $this->buildPrompt($html, $css, $js);

        $response = Http::withHeaders([
            'Authorization' => "Bearer {$apiKey}",
            'Content-Type' => 'application/json',
        ])->timeout(35)->post($url, [
            'model' => $model,
            'messages' => [
                ['role' => 'system', 'content' => 'You are an expert static web code auditor. Always output pure valid JSON.'],
                ['role' => 'user', 'content' => $prompt]
            ],
            'temperature' => 0.2,
        ]);

        if (!$response->successful()) {
            Log::warning('DeepSeek API Error: ' . $response->body());
            return null;
        }

        $data = $response->json();
        $text = $data['choices'][0]['message']['content'] ?? '';
        return $this->parseJsonSafely($text);
    }

    /**
     * Analyze with Alibaba Qwen API (DashScope)
     */
    protected function analyzeWithQwen(string $html, string $css, string $js): ?array
    {
        $apiKey = $this->settings->qwen_api_key ?: env('QWEN_API_KEY');
        if (empty($apiKey)) {
            return null;
        }

        $model = $this->settings->qwen_model ?: 'qwen-max';
        $url = 'https://dashscope-intl.aliyuncs.com/compatible-mode/v1/chat/completions';

        $prompt = $this->buildPrompt($html, $css, $js);

        $response = Http::withHeaders([
            'Authorization' => "Bearer {$apiKey}",
            'Content-Type' => 'application/json',
        ])->timeout(35)->post($url, [
            'model' => $model,
            'messages' => [
                ['role' => 'system', 'content' => 'You are an expert web auditor. Output JSON only.'],
                ['role' => 'user', 'content' => $prompt]
            ],
            'temperature' => 0.2,
        ]);

        if (!$response->successful()) {
            Log::warning('Qwen API Error: ' . $response->body());
            return null;
        }

        $data = $response->json();
        $text = $data['choices'][0]['message']['content'] ?? '';
        return $this->parseJsonSafely($text);
    }

    /**
     * Clean and safely parse JSON from AI models (handling markdown blocks ```json ... ```)
     */
    protected function parseJsonSafely(string $text): ?array
    {
        $text = trim($text);
        if (str_starts_with($text, '```json')) {
            $text = substr($text, 7);
        } elseif (str_starts_with($text, '```')) {
            $text = substr($text, 3);
        }
        if (str_ends_with($text, '```')) {
            $text = substr($text, 0, -3);
        }
        $text = trim($text);

        $parsed = json_decode($text, true);
        return is_array($parsed) ? $parsed : null;
    }

    /**
     * Smart Heuristic Static Analysis Fallback Engine.
     * Evaluates real HTML, CSS, and JS properties when external API key is absent or unreachable.
     */
    public function heuristicAnalysis(string $html, string $css = '', string $js = ''): array
    {
        // 1. SEO Evaluation
        $seoScore = 100;
        $seoIssues = [];
        $seoRecs = [];

        if (!preg_match('/<title[^>]*>(.*?)<\/title>/is', $html, $matches) || empty(trim($matches[1] ?? ''))) {
            $seoScore -= 20;
            $seoIssues[] = "Tag <title> tidak ditemukan atau kosong di dalam <head>.";
            $seoRecs[] = "Tambahkan judul halaman yang deskriptif pada tag <title>...</title>.";
        }
        if (!preg_match('/<meta[^>]+name=["\']description["\'][^>]*>/i', $html)) {
            $seoScore -= 15;
            $seoIssues[] = "Meta description belum didefinisikan.";
            $seoRecs[] = "Tambahkan <meta name=\"description\" content=\"...\"> untuk meningkatkan ranking mesin pencari.";
        }
        if (!preg_match('/<meta[^>]+name=["\']viewport["\'][^>]*>/i', $html)) {
            $seoScore -= 20;
            $seoIssues[] = "Meta viewport tidak ditemukan. Tampilan mobile mungkin tidak responsif.";
            $seoRecs[] = "Tambahkan <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">.";
        }
        if (!preg_match('/<h1[^>]*>/i', $html)) {
            $seoScore -= 10;
            $seoIssues[] = "Halaman tidak memiliki tag <h1> sebagai judul utama konten.";
            $seoRecs[] = "Gunakan setidaknya satu tag <h1> untuk hierarki dokumen yang terstruktur.";
        }
        // Check images without alt
        if (preg_match_all('/<img\s+[^>]*>/i', $html, $imgTags)) {
            $missingAltCount = 0;
            foreach ($imgTags[0] as $imgTag) {
                if (!preg_match('/alt=["\'][^"\']*["\']/i', $imgTag)) {
                    $missingAltCount++;
                }
            }
            if ($missingAltCount > 0) {
                $seoScore -= min(15, $missingAltCount * 5);
                $seoIssues[] = "Ditemukan {$missingAltCount} gambar tanpa atribut alt.";
                $seoRecs[] = "Lengkapi setiap tag <img> dengan atribut alt=\"Deskripsi gambar\" demi aksesibilitas & SEO.";
            }
        }
        $seoScore = max(30, min(100, $seoScore));

        // 2. Performance Evaluation
        $perfScore = 95;
        $perfIssues = [];
        $perfRecs = [];

        // Check for scripts in head without defer or async
        if (preg_match('/<head[^>]*>(.*?)<\/head>/is', $html, $headMatches)) {
            $headContent = $headMatches[1] ?? '';
            if (preg_match_all('/<script\s+[^>]*src=["\'][^"\']+["\'][^>]*>/i', $headContent, $headScripts)) {
                $renderBlocking = 0;
                foreach ($headScripts[0] as $scriptTag) {
                    if (!preg_match('/defer|async/i', $scriptTag)) {
                        $renderBlocking++;
                    }
                }
                if ($renderBlocking > 0) {
                    $perfScore -= 15;
                    $perfIssues[] = "Terdapat {$renderBlocking} script eksternal di <head> tanpa atribut defer/async.";
                    $perfRecs[] = "Gunakan atribut 'defer' pada tag <script src=\"...\"> di bagian <head> untuk mencegah render-blocking.";
                }
            }
        }
        // Huge inline CSS check
        if (preg_match_all('/<style[^>]*>(.*?)<\/style>/is', $html, $styles)) {
            $inlineSize = array_sum(array_map('strlen', $styles[1]));
            if ($inlineSize > 50000) {
                $perfScore -= 15;
                $perfIssues[] = "Ukuran CSS inline di dalam tag <style> sangat besar (" . round($inlineSize / 1024) . " KB).";
                $perfRecs[] = "Pisahkan style inline ke dalam file .css eksternal untuk memanfaatkan cache browser.";
            }
        }
        $perfScore = max(40, min(100, $perfScore));

        // 3. Code Errors & Syntax
        $errorScore = 95;
        $errorIssues = [];
        $errorRecs = [];

        // Check unclosed basic tags
        $essentialTags = ['html', 'head', 'body'];
        foreach ($essentialTags as $tag) {
            if (stripos($html, "<{$tag}") !== false && stripos($html, "</{$tag}>") === false) {
                $errorScore -= 15;
                $errorIssues[] = "Tag penutup </{$tag}> tidak ditemukan pada struktur HTML.";
                $errorRecs[] = "Pastikan seluruh tag pembuka berpasangan dengan tag penutup </{$tag}>.";
            }
        }
        // Check for common console.error or debugger left in JS
        if (preg_match('/debugger\s*;/i', $js)) {
            $errorScore -= 10;
            $errorIssues[] = "Pernyataan 'debugger;' ditemukan pada file JavaScript.";
            $errorRecs[] = "Hapus statement debugger sebelum mempublikasikan kode ke lingkungan produksi.";
        }
        $errorScore = max(40, min(100, $errorScore));

        // 4. Best Practices & Accessibility
        $bpScore = 90;
        $bpIssues = [];
        $bpRecs = [];

        if (!preg_match('/<(header|nav|main|footer|section|article)[^>]*>/i', $html)) {
            $bpScore -= 15;
            $bpIssues[] = "Website belum menggunakan tag Semantic HTML5 (<main>, <header>, <nav>, <footer>).";
            $bpRecs[] = "Gunakan Semantic HTML5 untuk struktur halaman yang lebih rapi dan ramah screen reader.";
        }
        if (!preg_match('/<!DOCTYPE\s+html>/i', $html)) {
            $bpScore -= 10;
            $bpIssues[] = "Deklarasi <!DOCTYPE html> tidak ditemukan di awal dokumen.";
            $bpRecs[] = "Tambahkan <!DOCTYPE html> pada baris paling pertama kode HTML.";
        }
        $bpScore = max(40, min(100, $bpScore));

        // 5. Security Check
        $secScore = 100;
        $secIssues = [];
        $secRecs = [];

        // Phishing & dangerous scripts check
        if (preg_match('/(eval\(|document\.write\(|crypto-loot|coinhive)/i', $js . $html)) {
            $secScore -= 30;
            $secIssues[] = "Terdeteksi pola pemanggilan JavaScript berisiko tinggi (eval/document.write).";
            $secRecs[] = "Hindari penggunaan fungsi eval() demi keamanan integritas aplikasi.";
        }
        if (preg_match('/(form[^>]+action=["\']https?:\/\/(?!localhost|127\.0\.0\.1)[^"\']*paypal|bca|mandiri|bank|login-fake)/i', $html)) {
            $secScore -= 50;
            $secIssues[] = "Terdeteksi form eksternal yang menyerupai aksi phishing.";
            $secRecs[] = "Pastikan target action form mengarah ke endpoint yang sah dan aman.";
        }
        $secScore = max(20, min(100, $secScore));

        // Calculate Overall Score
        $overallScore = round(
            ($seoScore * 0.20) +
            ($perfScore * 0.20) +
            ($errorScore * 0.25) +
            ($bpScore * 0.15) +
            ($secScore * 0.20)
        );

        $summary = "Prototype kode Anda berada pada tingkat kualitas yang sangat baik! Struktur rapi, aman, dan siap untuk diaktifkan ke hosting gratis.";
        if ($overallScore < 75) {
            $summary = "Prototype memerlukan sedikit optimasi sebelum memenuhi kriteria hosting gratis. Periksa rekomendasi di bawah untuk meningkatkan skor Anda.";
        }

        return [
            'overall_score' => $overallScore,
            'is_approved_for_hosting' => ($overallScore >= 75),
            'verdict_summary' => $summary,
            'categories' => [
                'performance' => [
                    'score' => $perfScore,
                    'issues' => $perfIssues,
                    'recommendations' => $perfRecs,
                ],
                'seo' => [
                    'score' => $seoScore,
                    'issues' => $seoIssues,
                    'recommendations' => $seoRecs,
                ],
                'code_errors' => [
                    'score' => $errorScore,
                    'issues' => $errorIssues,
                    'recommendations' => $errorRecs,
                ],
                'best_practices' => [
                    'score' => $bpScore,
                    'issues' => $bpIssues,
                    'recommendations' => $bpRecs,
                ],
                'security' => [
                    'score' => $secScore,
                    'issues' => $secIssues,
                    'recommendations' => $secRecs,
                ],
            ],
        ];
    }
}
