<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class InformasiTerbaru extends Model
{
    use HasFactory;

    public static function  informasiTerbaru()
    {
        $kerjasama_mitra_kolaborasis = DB::table('kerjasama_mitra_kolaborasis')
            ->where('release_date', '<=', date('Y-m-d'))
            ->where('deleted_at', null);
        $hasil_karyas = DB::table('hasil_karyas')
            ->where('release_date', '<=', date('Y-m-d'))
            ->where('deleted_at', null);
        $layanan_mahasiswas = DB::table('layanan_mahasiswas')
            ->where('release_date', '<=', date('Y-m-d'))
            ->where('deleted_at', null);
        $informasi_beasiswas = DB::table('informasi_beasiswas')
            ->where('release_date', '<=', date('Y-m-d'))
            ->where('deleted_at', null);

        $informasiTerbaru = DB::table('beritas')
            ->union($kerjasama_mitra_kolaborasis)
            ->union($hasil_karyas)
            ->union($layanan_mahasiswas)
            ->union($informasi_beasiswas)
            ->where('release_date', '<=', date('Y-m-d'))
            ->where('deleted_at', null)
            ->orderBy('release_date', 'DESC');
        return $informasiTerbaru;
    }
}
