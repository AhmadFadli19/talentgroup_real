<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    protected $fillable = [
        'judul',
        'price',
        'create_view',
        'image',
        'best_seller',
        'certificate',
    ];

    public function detail()
    {
        return $this->hasOne(CardDetail::class); // ganti ke hasOne
    }
}
