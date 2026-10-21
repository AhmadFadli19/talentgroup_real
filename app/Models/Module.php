<?php

namespace App\Models;

use App\Services\ModuleMarkdownParser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Module extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'section',
        'title',
        'slug',
        'excerpt',
        'content',
        'order',
        'is_published',
        'is_public',
        'referral_code',
        'enable_protection',
        'views_count',
    ];

    protected $casts = [
        'order' => 'integer',
        'is_published' => 'boolean',
        'is_public' => 'boolean',
        'enable_protection' => 'boolean',
        'views_count' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($module) {
            if (empty($module->slug)) {
                $module->slug = Str::slug($module->title);
            }
        });
    }

    public function category()
    {
        return $this->belongsTo(ModuleCategory::class, 'category_id');
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc')->orderBy('id', 'asc');
    }

    /**
     * Determine if a user has access to this specific module.
     */
    public function hasAccessForUser($user): bool
    {
        if (!$this->is_public) {
            if (!$user) return false;
            if (method_exists($user, 'isAdmin') && $user->isAdmin()) return true;

            $hasSpecificAccess = UserModuleAccess::where('user_id', $user->id)
                ->where('module_id', $this->id)
                ->exists();

            if ($hasSpecificAccess) return true;
        }

        // If category is set, check category access
        if ($this->category) {
            return $this->category->hasAccessForUser($user);
        }

        return $this->is_public;
    }

    /**
     * Get parsed HTML content.
     */
    public function getRenderedContentAttribute()
    {
        return ModuleMarkdownParser::parse($this->content ?? '');
    }

    /**
     * Get Table of Contents extracted from headings.
     */
    public function getTableOfContentsAttribute()
    {
        return ModuleMarkdownParser::extractTableOfContents($this->content ?? '');
    }

    /**
     * Get the previous published module in reading flow.
     */
    public function getPreviousModuleAttribute()
    {
        // First look in same category with lower order
        $prev = static::published()
            ->where('category_id', $this->category_id)
            ->where(function ($q) {
                $q->where('order', '<', $this->order)
                  ->orWhere(function ($sub) {
                      $sub->where('order', $this->order)->where('id', '<', $this->id);
                  });
            })
            ->orderBy('order', 'desc')
            ->orderBy('id', 'desc')
            ->first();

        if ($prev) {
            return $prev;
        }

        // Otherwise look in previous category
        if ($this->category) {
            $prevCategory = ModuleCategory::active()
                ->where('order', '<', $this->category->order)
                ->orderBy('order', 'desc')
                ->first();

            if ($prevCategory) {
                return $prevCategory->publishedModules()->orderBy('order', 'desc')->first();
            }
        }

        return null;
    }

    /**
     * Get the next published module in reading flow.
     */
    public function getNextModuleAttribute()
    {
        // First look in same category with higher order
        $next = static::published()
            ->where('category_id', $this->category_id)
            ->where(function ($q) {
                $q->where('order', '>', $this->order)
                  ->orWhere(function ($sub) {
                      $sub->where('order', $this->order)->where('id', '>', $this->id);
                  });
            })
            ->orderBy('order', 'asc')
            ->orderBy('id', 'asc')
            ->first();

        if ($next) {
            return $next;
        }

        // Otherwise look in next category
        if ($this->category) {
            $nextCategory = ModuleCategory::active()
                ->where('order', '>', $this->category->order)
                ->orderBy('order', 'asc')
                ->first();

            if ($nextCategory) {
                return $nextCategory->publishedModules()->orderBy('order', 'asc')->first();
            }
        }

        return null;
    }
}
