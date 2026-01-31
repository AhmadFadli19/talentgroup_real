<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCourse extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'course_id',
        'purchased_at',
        'is_completed',
        'current_content_id',
    ];

    protected $casts = [
        'purchased_at' => 'datetime',
        'is_completed' => 'boolean',
        'current_content_id' => 'string',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
