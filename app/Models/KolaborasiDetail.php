<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KolaborasiDetail extends Model
{
    protected $table = 'kolaborasidetail';
    protected $fillable = [
        'kolaborasi_id',
        'image',
        'judul',
        'topic',
        'url_kelas',
        'judul_description',
        'description_kelas',
        'target',
        'sasaran',
    ];

    

    public function Kolaborasi()
    {
        return $this->belongsTo(Kolaborasi::class, 'kolaborasi_id');
    }
}
