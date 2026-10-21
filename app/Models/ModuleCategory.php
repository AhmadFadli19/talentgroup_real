<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ModuleCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'is_public',
        'referral_code',
        'image',
        'icon',
        'color',
        'badge',
        'order',
        'is_active',
    ];

    /**
     * Get image url with fallback.
     */
    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return null;
        }

        if (str_starts_with($this->image, 'http://') || str_starts_with($this->image, 'https://')) {
            return $this->image;
        }

        return route('storage.stream', $this->image);
    }

    protected $casts = [
        'is_active' => 'boolean',
        'is_public' => 'boolean',
        'order' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });
    }

    public function modules()
    {
        return $this->hasMany(Module::class, 'category_id')->orderBy('order', 'asc');
    }

    public function publishedModules()
    {
        return $this->hasMany(Module::class, 'category_id')
            ->where('is_published', true)
            ->orderBy('order', 'asc');
    }

    public function userAccess()
    {
        return $this->hasMany(UserModuleAccess::class, 'category_id');
    }

    /**
     * Determine if a user has access to this module category.
     */
    public function hasAccessForUser($user): bool
    {
        // Public module category is accessible to everyone
        if ($this->is_public) {
            return true;
        }

        if (!$user) {
            return false;
        }

        // Admin has access to all modules
        if (method_exists($user, 'isAdmin') && $user->isAdmin()) {
            return true;
        }

        // Check if granted via user_module_access
        return UserModuleAccess::where('user_id', $user->id)
            ->where('category_id', $this->id)
            ->exists();
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc')->orderBy('id', 'asc');
    }
}
