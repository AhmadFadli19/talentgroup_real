<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'phone',
        'password',
        'role_id',
        'google_id',
        'email_verified_at',
        'email_verification_code',
        'reset_code',
        'reset_code_expired_at',
        'avatar',
        'balance',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var list<string>
     */
    protected $appends = [
        'avatar_url',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'email_verification_code',
        'reset_code',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'reset_code_expired_at' => 'datetime',
            'password' => 'hashed'
        ];
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function isAdmin()
    {
        return $this->role_id === 1;
    }

    public function isUser()
    {
        return $this->role_id === 2;
    }

    public function isDeveloper()
    {
        return $this->role_id === 3;
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'user_courses')->withPivot('purchased_at', 'is_completed', 'current_content_id')->withTimestamps();
    }

    public function userCourses()
    {
        return $this->hasMany(UserCourse::class);
    }

    public function userAnswers()
    {
        return $this->hasMany(UserAnswer::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function balanceHistories()
    {
        return $this->hasMany(BalanceHistory::class);
    }

    public function auditLogs()
    {
        return $this->hasMany(AuditLog::class);
    }

    public function processedTransactions()
    {
        return $this->hasMany(Transaction::class, 'processed_by');
    }

    public function moduleAccesses()
    {
        return $this->hasMany(UserModuleAccess::class);
    }

    public function isBank()
    {
        return $this->role && $this->role->name === 'bank';
    }

    public function prototypes()
    {
        return $this->hasMany(Prototype::class);
    }

    /**
     * Get avatar URL safely supporting Google OAuth URLs, local storage, and fallback Gravatar.
     */
    public function getAvatarUrlAttribute(): string
    {
        if (empty($this->avatar)) {
            $hash = md5(strtolower(trim($this->email ?? 'user@talentgroup.id')));
            return 'https://www.gravatar.com/avatar/' . $hash . '?d=mp&s=150';
        }

        if (str_starts_with($this->avatar, 'http://') || str_starts_with($this->avatar, 'https://')) {
            return $this->avatar;
        }

        return asset('storage/' . $this->avatar);
    }
}

