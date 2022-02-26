<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JadwalUjian extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'tipe_ujian',
        'semester',
        'tahun_ajaran',
        'nama_file',
        'release_date',
        'slug'
    ];
}
