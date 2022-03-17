<?php

namespace App\Http\Controllers;

use App\Models\Kontak;

use App\Models\ProfilSingkat;
use App\Models\AplikasiIntegrasi;
use App\Models\HimpunanMahasiswa;
use App\Models\InformasiTerbaru;
use App\Models\Laboratorium;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TracerStudyController extends Controller
{
    public function menuTracerStudy()
    {
        $profilSingkat = ProfilSingkat::all()
        ->first();
         $kontak = Kontak::all()
        ->first();

        $response = Http::get('http://tracerstudyalumni.untan.ac.id/API/getDataJumlah/340');
        $tracerStudy = $response->json($key =null);
        $status =$tracerStudy["status"];
        
        
     
        if ($status=='200') {
            $jumlahPengisi =  $tracerStudy["jumlahPengisi"]; 
            $jumlahPengisiValidasi =  $tracerStudy ["jumlahPengisiValidasi"];
            $jumlahPengisihariini =  $tracerStudy ["jumlahPengisihariini"];
           
         
        } else {
            return redirect('/errors/404.blade.php')->with('alert', 'Aplikasi Sedang Dalam Perbaikan');

                 
            };

        $informasiTerbarus = InformasiTerbaru::informasiTerbaru()
            ->take(3)
            ->get();
        $aplikasiIntegrasis = AplikasiIntegrasi::where('release_date', '<=', date('Y-m-d'))
            ->orderBy('release_date', 'DESC')
            ->take(3)
            ->get();
        $profilSingkat = ProfilSingkat::all()
            ->first();
        $kontak = Kontak::all()
            ->first();

        $laboratoriumHeaders = Laboratorium::where('release_date', '<=', date('Y-m-d'))
            ->orderBy('release_date', 'DESC')
            ->get();

        return view('portal.tracer_study.index',  compact('status','jumlahPengisi','jumlahPengisiValidasi','jumlahPengisihariini','tataTertibPeraturan', 'informasiTerbarus',  'aplikasiIntegrasis', 'profilSingkat', 'kontak', 'laboratoriumHeaders'));
    }
}
