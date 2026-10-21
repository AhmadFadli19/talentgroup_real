<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReferralCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'description',
        'discount_type',
        'discount_value',
        'target_type',
        'target_id',
        'max_uses',
        'used_count',
        'is_active',
        'expires_at',
        'created_by',
    ];

    protected $casts = [
        'discount_value' => 'decimal:2',
        'max_uses' => 'integer',
        'used_count' => 'integer',
        'is_active' => 'boolean',
        'expires_at' => 'datetime',
    ];

    public function usages()
    {
        return $this->hasMany(ReferralCodeUsage::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Check if the code is currently valid.
     */
    public function isValid(?User $user = null): bool
    {
        if (!$this->is_active) {
            return false;
        }

        if ($this->expires_at && $this->expires_at->isPast()) {
            return false;
        }

        if ($this->max_uses !== null && $this->used_count >= $this->max_uses) {
            return false;
        }

        if ($user) {
            $alreadyUsed = $this->usages()->where('user_id', $user->id)->exists();
            if ($alreadyUsed) {
                return false;
            }
        }

        return true;
    }

    /**
     * Check validity for a specific Course.
     */
    public function isValidForCourse(Course $course, ?User $user = null): bool
    {
        if (!$this->isValid($user)) {
            return false;
        }

        if ($this->target_type === 'course' && $this->target_id != $course->id) {
            return false;
        }

        if ($this->target_type === 'module') {
            return false;
        }

        return true;
    }

    /**
     * Check validity for a specific Module or Category.
     */
    public function isValidForModule($categoryOrModule, ?User $user = null): bool
    {
        if (!$this->isValid($user)) {
            return false;
        }

        if ($this->target_type === 'module') {
            if ($this->target_id && $this->target_id != $categoryOrModule->id) {
                return false;
            }
        }

        return true;
    }

    /**
     * Calculate discount amount for a given price.
     */
    public function calculateDiscount(float $price): float
    {
        if ($this->discount_type === 'free') {
            return $price;
        }

        if ($this->discount_type === 'percentage') {
            $discount = ($this->discount_value / 100) * $price;
            return min($price, max(0, $discount));
        }

        if ($this->discount_type === 'fixed') {
            return min($price, max(0, (float) $this->discount_value));
        }

        return 0;
    }
}
