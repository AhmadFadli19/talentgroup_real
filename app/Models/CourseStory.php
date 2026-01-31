<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseStory extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'title',
        'content',
        'order',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    // Add the missing methods
    public function isQuestion()
    {
        return false;
    }

    public function isStory()
    {
        return true;
    }

    // Add a type attribute for consistency
    public function getTypeAttribute()
    {
        return 'story';
    }
}
