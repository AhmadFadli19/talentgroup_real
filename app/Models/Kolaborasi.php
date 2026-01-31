<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kolaborasi extends Model
{
    protected $table = 'kolaborasi';

    protected $fillable = [
        'judul',
        'description',
        'image',
        'create_view',
        'category',
    ];

    public function detail()
    {
        return $this->hasOne(KolaborasiDetail::class, 'kolaborasi_id');
    }
}
