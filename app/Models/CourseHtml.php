<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseHtml extends Model
{
    use HasFactory;

    protected $table = 'course_htmls';

    protected $fillable = [
        'course_id',
        'title',
        'content',
        'html_code',
        'css_code',
        'js_code',
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

    public function isHtml()
    {
        return true;
    }

    public function getTypeAttribute()
    {
        return 'html';
    }
}
