<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SlideBlogger extends Model
{
    protected $table = 'slideblogger';

    protected $fillable = [
        'judul',
        'image',
        'blog_author',
        'description',
        'create_view'
    ];

    public function detail()
    {
        return $this->hasOne(SlideBloggerDetail::class, 'slideBlogger_id');
    }
}
