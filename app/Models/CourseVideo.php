<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseVideo extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'title',
        'content',
        'video_url',
        'order',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function isQuestion()
    {
        return false;
    }

    public function isStory()
    {
        return false;
    }

    public function isVideo()
    {
        return true;
    }

    public function getTypeAttribute()
    {
        return 'video';
    }
}
