<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KerjaPraktik extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'teks',
        'nama_file',
    ];
}
