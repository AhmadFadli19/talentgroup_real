<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAnswer extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'content_id',
        'content_type',
        'content_reference',
        'answer',
        'is_correct',
        'points',
    ];

    protected $casts = [
        'is_correct' => 'boolean',
        'points' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Simple relationship without additional conditions
    public function courseQuestion()
    {
        return $this->belongsTo(CourseQuestion::class, 'content_id');
    }

    public function courseStory()
    {
        return $this->belongsTo(CourseStory::class, 'content_id');
    }
}
