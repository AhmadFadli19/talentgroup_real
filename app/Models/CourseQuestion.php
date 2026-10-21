<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'question_type',
        'title',
        'content',
        'options',
        'correct_answer',
        'admin_code',
        'starter_code',
        'expected_output',
        'coding_rules',
        'test_cases',
        'hint',
        'language',
        'order',
    ];

    protected $casts = [
        'options' => 'array',
        'coding_rules' => 'array',
        'test_cases' => 'array',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function userAnswers()
    {
        return $this->hasMany(UserAnswer::class, 'content_id');
    }

    public function isQuestion()
    {
        return true;
    }

    public function isStory()
    {
        return false;
    }

    public function isCoding()
    {
        return $this->question_type === 'coding';
    }

    public function isMultipleChoice()
    {
        return $this->question_type === 'multiple_choice' || $this->question_type === null;
    }

    public function getTypeAttribute()
    {
        return 'question';
    }

    /**
     * Get available coding rules with labels
     */
    public static function availableCodingRules(): array
    {
        return [
            'for_loop' => 'For Loop (for)',
            'if_statement' => 'If Statement (if)',
            'switch_statement' => 'Switch Statement (switch)',
            'function_declaration' => 'Function Declaration (func)',
            'variable_declaration' => 'Variable (var / :=)',
            'array_usage' => 'Array/Slice ([])',
            'map_usage' => 'Map (map[])',
            'struct_usage' => 'Struct (type ... struct)',
            'goroutine' => 'Goroutine (go)',
            'channel' => 'Channel (chan)',
            'pointer' => 'Pointer (*)',
            'interface_usage' => 'Interface (interface)',
            'error_handling' => 'Error Handling (error)',
            'fmt_println' => 'fmt.Println',
            'fmt_printf' => 'fmt.Printf',
            'string_manipulation' => 'String Operations (strings.)',
            'math_operations' => 'Math Operations (+, -, *, /)',
        ];
    }
}
