<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kontak extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'email',
        'fax',
        'alamat',
        'nomor_telepon',
        'youtube',
        'url_youtube',
        'twitter',
        'url_twitter',
        'facebook',
        'url_facebook',
        'instagram',
        'url_instagram',
        'whatsapp'
    ];
}
