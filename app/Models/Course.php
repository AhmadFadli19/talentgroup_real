<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'price',
        'image',
        'is_active',
        'created_by',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function contents()
    {
        return $this->hasMany(CourseContent::class)->orderBy('order');
    }

    public function stories()
    {
        return $this->hasMany(CourseStory::class)->orderBy('order');
    }

    public function questions()
    {
        return $this->hasMany(CourseQuestion::class)->orderBy('order');
    }

    public function allContents()
    {
        $stories = $this->stories()->get()->map(function($story) {
            $story->type = 'story';
            return $story;
        });
        
        $questions = $this->questions()->get()->map(function($question) {
            $question->type = 'question';
            return $question;
        });
        
        return $stories->concat($questions)->sortBy('order');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_courses')->withPivot('purchased_at', 'is_completed', 'current_content_id')->withTimestamps();
    }

    public function userCourses()
    {
        return $this->hasMany(UserCourse::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}