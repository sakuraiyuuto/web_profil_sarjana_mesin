<?php

namespace App\Http\Controllers;

use App\Models\AplikasiIntegrasi;
use App\Models\Banner;
use App\Models\Galeri;
use App\Models\InformasiTerbaru;
use App\Models\Kemitraan;
use App\Models\Kontak;
use App\Models\Laboratorium;
use App\Models\LaboratoriumSingkat;
use App\Models\PengabdianKeMasyarakat;
use App\Models\Perpustakaan;
use App\Models\ProfilSingkat;
use App\Models\Quote;
use App\Models\RuangLab;
use App\Models\RuangStafDanDosen;
use App\Models\RuangPerkuliahan;

class BerandaController extends Controller
{
    //
    public function index()
    {
        $banners = Banner::where('release_date', '<=', date('Y-m-d'))
            ->orderBy('release_date', 'DESC')
            ->get();

        $quotes = Quote::where('release_date', '<=', date('Y-m-d'))
            ->orderBy('release_date', 'DESC')
            ->get();

        $galeris = Galeri::where('release_date', '<=', date('Y-m-d'))
            ->orderBy('release_date', 'DESC')
            ->get();

        $kemitraans = Kemitraan::where('release_date', '<=', date('Y-m-d'))
            ->orderBy('release_date', 'DESC')
            ->get();

        $profilSingkat = ProfilSingkat::all()
            ->first();
        $kontak = Kontak::all()
            ->first();
        $ruangPerkuliahan = RuangPerkuliahan::all()
            ->first();
        $ruangStafDanDosen = RuangStafDanDosen::all()
            ->first();
        $perpustakaan = Perpustakaan::all()
            ->first();

        $informasiTerbarus = InformasiTerbaru::informasiTerbaru()
            ->take(3)
            ->get();

        $pengabdianKeMasyarakats = PengabdianKeMasyarakat::where('release_date', '<=', date('Y-m-d'))
            ->orderBy('release_date', 'DESC')
            ->take(4)
            ->get();

        $laboratoriumSingkat = LaboratoriumSingkat::all()
            ->first();

        $laboratoriumHeaders = Laboratorium::where('release_date', '<=', date('Y-m-d'))
            ->orderBy('release_date', 'DESC')
            ->get();

        return view('portal.beranda.index',  compact(
            'profilSingkat',
            'kontak',
            'banners',
            'quotes',
            'galeris',
            'kemitraans',
            'ruangLab',
            'ruangPerkuliahan',
            'ruangStafDanDosen',
            'perpustakaan',
            'informasiTerbarus',
            'pengabdianKeMasyarakats',
            'laboratoriumSingkat',
            'laboratoriumHeaders'
        ));
    }
}
