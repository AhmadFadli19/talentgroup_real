<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BannerCardDetail extends Model
{
    protected $table = 'bannercarddetail';
    protected $fillable = [
        'BannerCard_id',
        'judul_kelas',
        'deskripsi',
        'jumlah_materi',
        'materi',
        'persiapan',
        'image',
        'judul',
        'topic',
        'url_kelas',
        'judul_description',
        'description_kelas',
        'target',
        'sasaran',
    ];

    public function bannerCardCreate()
    {
        return $this->belongsTo(BannerCardCreate::class, 'BannerCard_id');
    }
}
