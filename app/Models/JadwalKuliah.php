<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JadwalKuliah extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'semester',
        'tahun_ajaran',
        'nama_file',
        'release_date',
        'slug'
    ];
}
