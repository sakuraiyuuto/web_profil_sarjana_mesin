<?php

namespace App\Http\Controllers;

use App\Models\AplikasiIntegrasi;
use App\Models\HimpunanMahasiswa;
use App\Models\Kontak;
use Illuminate\Http\Request;
use App\Models\InformasiTerbaru;
use App\Models\Laboratorium;

class InformasiTerbaruController extends Controller
{
    //
    public function menuInformasiTerbaru()
    {
        $informasiTerbarus = InformasiTerbaru::informasiTerbaru()
            ->take(3)
            ->get();

        $kontak = Kontak::all()->first();

        $informasiTerbaruPaginates = InformasiTerbaru::InformasiTerbaru()->paginate(6);
        $aplikasiIntegrasis = AplikasiIntegrasi::where('release_date', '<=', date('Y-m-d'))
            ->orderBy('release_date', 'DESC')
            ->take(3)
            ->get();

        $laboratoriumHeaders = Laboratorium::where('release_date', '<=', date('Y-m-d'))
            ->orderBy('release_date', 'DESC')
            ->get();

        return view('portal.informasi_terbaru.index',  compact(
            'informasiTerbaruPaginates',
            'himpunanMahasiswaHeaders',
            'kontak',
            'informasiTerbarus',
            'aplikasiIntegrasis',
            'laboratoriumHeaders'
        ));
    }
}
