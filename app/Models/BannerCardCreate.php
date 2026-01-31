<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BannerCardCreate extends Model
{
    protected $table = 'bannercardcreate';

    protected $fillable = [
        'judul',
        'description',
        'create_view',
        'image',
        'category',
    ];

    public function detail()
    {
        return $this->hasOne(BannerCardDetail::class, 'BannerCard_id');
    }
}
