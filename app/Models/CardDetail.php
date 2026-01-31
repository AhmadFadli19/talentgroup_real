<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CardDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'card_id',
        'image',
        'judul',
        'topic',
        'url_kelas',
        'jam_kelas',
        'judul_description',
        'description_kelas',
        'target',
        'sasaran',
        'metode_pembelajaran',
        'materi_pembelajaran',
        'persiapan_pembelajaran',
    ];


    protected $casts = [
        'jumlah_materi' => 'integer',
    ];

    public function card()
    {
        return $this->belongsTo(Card::class);
    }
}
