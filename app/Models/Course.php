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
        'quiz_answer_visibility',
        'quiz_navigation_mode',
        'shuffle_questions',
        'shuffle_options',
        'created_by',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_active' => 'boolean',
        'shuffle_questions' => 'boolean',
        'shuffle_options' => 'boolean',
    ];

    public function isShuffleQuestions(): bool
    {
        return $this->shuffle_questions ?? true;
    }

    public function isShuffleOptions(): bool
    {
        return $this->shuffle_options ?? true;
    }

    public function isInstantQuizFeedback(): bool
    {
        return $this->quiz_answer_visibility === 'instant';
    }

    public function isEndQuizFeedback(): bool
    {
        return $this->quiz_answer_visibility === 'end' || empty($this->quiz_answer_visibility);
    }

    public function isNoneQuizFeedback(): bool
    {
        return $this->quiz_answer_visibility === 'none';
    }

    public function isNextOnlyNavigation(): bool
    {
        return $this->quiz_navigation_mode === 'next_only';
    }

    public function isFreeNavigation(): bool
    {
        return !$this->isNextOnlyNavigation();
    }

    /**
     * Get secure URL for course image with fallback capability.
     */
    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return null;
        }

        if (str_starts_with($this->image, 'http://') || str_starts_with($this->image, 'https://')) {
            return $this->image;
        }

        if (str_starts_with($this->image, 'tg/') || str_starts_with($this->image, 'assets/')) {
            return asset($this->image);
        }

        return route('storage.stream', $this->image);
    }

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

    public function videos()
    {
        return $this->hasMany(CourseVideo::class)->orderBy('order');
    }

    public function htmls()
    {
        return $this->hasMany(CourseHtml::class)->orderBy('order');
    }

    public function allContents($forUser = null)
    {
        $stories = $this->stories()->get()->map(function($story) {
            $story->type = 'story';
            return $story;
        });
        
        $questions = $this->questions()->get()->map(function($question) {
            $question->type = 'question';
            return $question;
        });

        $videos = $this->videos()->get()->map(function($video) {
            $video->type = 'video';
            return $video;
        });

        $htmls = $this->htmls()->get()->map(function($html) {
            $html->type = 'html';
            return $html;
        });
        
        $all = $stories->concat($questions)->concat($videos)->concat($htmls)->sortBy('order')->values();

        if ($this->isShuffleQuestions() && $forUser) {
            $userId = is_object($forUser) ? $forUser->id : $forUser;
            $courseId = $this->id;
            $all = $all->sortBy(function ($item) use ($courseId, $userId) {
                return md5($courseId . '_' . $userId . '_' . $item->type . '_' . $item->id);
            })->values();
        }

        return $all;
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
