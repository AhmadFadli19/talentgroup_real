<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'title',
        'content',
        'options',
        'correct_answer',
        'order',
    ];

    protected $casts = [
        'options' => 'array',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function userAnswers()
    {
        return $this->hasMany(UserAnswer::class, 'course_content_id');
    }

    // Add the missing methods
    public function isQuestion()
    {
        return true;
    }

    public function isStory()
    {
        return false;
    }

    // Add a type attribute for consistency
    public function getTypeAttribute()
    {
        return 'question';
    }
}
