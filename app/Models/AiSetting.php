<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AiSetting extends Model
{
    use HasFactory;

    protected $table = 'ai_settings';

    protected $fillable = [
        'active_provider',
        'gemini_api_key',
        'gemini_model',
        'deepseek_api_key',
        'deepseek_model',
        'qwen_api_key',
        'qwen_model',
        'min_passing_score',
        'check_seo',
        'check_performance',
        'check_code_errors',
        'check_best_practices',
        'check_security',
        'custom_rules_prompt',
    ];

    protected $casts = [
        'min_passing_score' => 'integer',
        'check_seo' => 'boolean',
        'check_performance' => 'boolean',
        'check_code_errors' => 'boolean',
        'check_best_practices' => 'boolean',
        'check_security' => 'boolean',
    ];

    /**
     * Get the singleton settings record or initialize defaults.
     */
    public static function getSettings(): self
    {
        return self::firstOrCreate([], [
            'active_provider' => 'gemini',
            'gemini_api_key' => env('GEMINI_API_KEY', ''),
            'gemini_model' => 'gemini-2.5-flash',
            'deepseek_api_key' => env('DEEPSEEK_API_KEY', ''),
            'deepseek_model' => 'deepseek-chat',
            'qwen_api_key' => env('QWEN_API_KEY', ''),
            'qwen_model' => 'qwen-max',
            'min_passing_score' => 75,
            'check_seo' => true,
            'check_performance' => true,
            'check_code_errors' => true,
            'check_best_practices' => true,
            'check_security' => true,
            'custom_rules_prompt' => "Pastikan website memiliki struktur HTML5 semantik, responsif terhadap perangkat mobile, tidak ada broken syntax pada CSS/JS, dan bebas dari script berbahaya (phishing form, malware redirect, atau cryptominer).",
        ]);
    }
}
