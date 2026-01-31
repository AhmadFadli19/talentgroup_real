<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SlideBloggerDetail extends Model
{
    protected $table = 'slidebloggerdetail';
    protected $fillable = [
        'slideBlogger_id',
        'image',
        'judul',
        'topic',
        'url_kelas',
        'judul_description',
        'description_kelas',
        'target',
        'sasaran',
    ];


    public function SlideBlogger()
    {
        return $this->belongsTo(SlideBlogger::class, 'slideblogger_id');
    }
}
