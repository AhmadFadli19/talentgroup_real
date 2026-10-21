<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prototype extends Model
{
    use HasFactory;

    protected $table = 'prototypes';

    protected $fillable = [
        'user_id',
        'project_name',
        'slug',
        'upload_type',
        'storage_path',
        'ai_provider_used',
        'ai_score',
        'ai_report_json',
        'is_approved',
        'is_hosted',
        'is_active',
    ];

    protected $casts = [
        'ai_report_json' => 'array',
        'ai_score' => 'integer',
        'is_approved' => 'boolean',
        'is_hosted' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getUrlAttribute(): string
    {
        return url('/p/' . $this->slug);
    }
}
