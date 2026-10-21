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
        'image_path',
        'audio_path',
        'video_url',
        'use_image',
        'use_audio',
        'use_video',
        'order',
    ];

    protected $casts = [
        'use_image' => 'boolean',
        'use_audio' => 'boolean',
        'use_video' => 'boolean',
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
