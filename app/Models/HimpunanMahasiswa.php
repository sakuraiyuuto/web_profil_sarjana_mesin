<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HimpunanMahasiswa extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'nama',
        'thumbnail',
        'teks',
        'facebook',
        'url_facebook',
        'instagram',
        'url_instagram',
        'youtube',
        'url_youtube',
        'twitter',
        'url_twitter',
    ];
}
