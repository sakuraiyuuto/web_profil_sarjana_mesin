<?php

namespace App\Http\Controllers;

use App\Models\Kontak;

use App\Models\ProfilSingkat;
use App\Models\AplikasiIntegrasi;
use App\Models\InformasiTerbaru;
use App\Models\HimpunanMahasiswa;
use App\Models\KelompokKeahlianDosen;
use App\Models\Dosen;
use App\Models\Laboratorium;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class KelompokKeahlianDosenController extends Controller
{
    public function menuKelompokKeahlianDosen()
    {
        $kelompokKeahlianDosens = KelompokKeahlianDosen::orderBy('kelompok_keahlian', 'ASC')
            ->get();
        $dosens = Dosen::all()->sortDesc();
       
        $informasiTerbarus = InformasiTerbaru::informasiTerbaru()
            ->take(3)
            ->get();
        $aplikasiIntegrasis = AplikasiIntegrasi::where('release_date', '<=', date('Y-m-d'))
            ->orderBy('release_date', 'DESC')
            ->take(3)
            ->get();

        $kontak = Kontak::all()->first();
        $profilSingkat = ProfilSingkat::all()->first();

        $laboratoriumHeaders = Laboratorium::where('release_date', '<=', date('Y-m-d'))
            ->orderBy('release_date', 'DESC')
            ->get();

        return view('portal.kelompok_keahlian_dosen.index',  compact('kelompokKeahlianDosens', 'dosens', 'aplikasiIntegrasis', 'informasiTerbarus',  'profilSingkat', 'kontak', 'laboratoriumHeaders'));
    }
}
