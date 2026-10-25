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
        'content_type',
        'excerpt',
        'content',
        'file_path',
        'file_name',
        'file_size',
        'order',
        'is_published',
        'is_public',
        'referral_code',
        'enable_protection',
        'enable_anti_screenshot',
        'enable_anti_copy',
        'views_count',
    ];

    protected $casts = [
        'order' => 'integer',
        'is_published' => 'boolean',
        'is_public' => 'boolean',
        'enable_protection' => 'boolean',
        'enable_anti_screenshot' => 'boolean',
        'enable_anti_copy' => 'boolean',
        'views_count' => 'integer',
        'file_size' => 'integer',
    ];

    /**
     * Check if anti-screenshot protection is enabled for this lesson.
     */
    public function isAntiScreenshotEnabled(): bool
    {
        if (isset($this->attributes['enable_anti_screenshot']) && $this->attributes['enable_anti_screenshot'] !== null) {
            return (bool) $this->attributes['enable_anti_screenshot'];
        }
        return (bool) ($this->attributes['enable_protection'] ?? true);
    }

    /**
     * Check if anti-copy protection is enabled for this lesson.
     */
    public function isAntiCopyEnabled(): bool
    {
        if (isset($this->attributes['enable_anti_copy']) && $this->attributes['enable_anti_copy'] !== null) {
            return (bool) $this->attributes['enable_anti_copy'];
        }
        return (bool) ($this->attributes['enable_protection'] ?? true);
    }

    /**
     * Helper methods for document / content types
     */
    public function isMarkdown(): bool
    {
        return empty($this->content_type) || $this->content_type === 'markdown';
    }

    public function isPdf(): bool
    {
        return $this->content_type === 'pdf' || (
            !empty($this->file_path) && str_ends_with(strtolower($this->file_path), '.pdf')
        );
    }

    public function isWord(): bool
    {
        return $this->content_type === 'word' || (
            !empty($this->file_path) && (
                str_ends_with(strtolower($this->file_path), '.docx') || 
                str_ends_with(strtolower($this->file_path), '.doc')
            )
        );
    }

    public function isPpt(): bool
    {
        return $this->content_type === 'ppt' || (
            !empty($this->file_path) && (
                str_ends_with(strtolower($this->file_path), '.pptx') || 
                str_ends_with(strtolower($this->file_path), '.ppt')
            )
        );
    }

    public function isDocument(): bool
    {
        return $this->isPdf() || $this->isWord() || $this->isPpt();
    }

    public function getFileUrlAttribute(): ?string
    {
        return $this->file_path ? asset('storage/' . $this->file_path) : null;
    }

    public function getFormattedFileSizeAttribute(): string
    {
        if (!$this->file_size) return '0 KB';
        if ($this->file_size >= 1048576) {
            return number_format($this->file_size / 1048576, 2) . ' MB';
        }
        return number_format($this->file_size / 1024, 0) . ' KB';
    }

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
        if ($this->isDocument()) {
            return [];
        }
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
