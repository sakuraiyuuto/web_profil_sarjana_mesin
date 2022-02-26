<?php

namespace App\Http\Controllers;

use App\Models\AplikasiIntegrasi;
use App\Models\InformasiTerbaru;
use App\Models\Kontak;
use App\Models\Laboratorium;
use App\Models\ProfilSingkat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PencarianController extends Controller
{
    public function index(Request $request)
    {
        if ($request->search) {
            $kata_kunci = $request->search;
            $kerjasama_mitra_kolaborasis = DB::table('kerjasama_mitra_kolaborasis')
                ->where('release_date', '<=', date('Y-m-d'))
                ->where('deleted_at', null)
                ->where('judul', 'like', '%' . $kata_kunci . '%')
                ->orWhere('teks', 'like', '%' . $kata_kunci . '%');
            $hasil_karyas = DB::table('hasil_karyas')
                ->where('release_date', '<=', date('Y-m-d'))
                ->where('deleted_at', null)
                ->where('judul', 'like', '%' . $kata_kunci . '%')
                ->orWhere('teks', 'like', '%' . $kata_kunci . '%');
            $layanan_mahasiswas = DB::table('layanan_mahasiswas')
                ->where('release_date', '<=', date('Y-m-d'))
                ->where('deleted_at', null)
                ->where('judul', 'like', '%' . $kata_kunci . '%')
                ->orWhere('teks', 'like', '%' . $kata_kunci . '%');
            $informasi_beasiswas = DB::table('informasi_beasiswas')
                ->where('release_date', '<=', date('Y-m-d'))
                ->where('deleted_at', null)
                ->where('judul', 'like', '%' . $kata_kunci . '%')
                ->orWhere('teks', 'like', '%' . $kata_kunci . '%');
            $hasilPencarians = DB::table('beritas')
                ->union($kerjasama_mitra_kolaborasis)
                ->union($hasil_karyas)
                ->union($layanan_mahasiswas)
                ->union($informasi_beasiswas)
                ->where('release_date', '<=', date('Y-m-d'))
                ->where('deleted_at', null)
                ->where('judul', 'like', '%' . $kata_kunci . '%')
                ->orWhere('teks', 'like', '%' . $kata_kunci . '%')
                ->orderBy('release_date', 'DESC');

            if (!$hasilPencarians->get()->isEmpty()) {
                $hasilPencarianPaginates = $hasilPencarians->paginate(6);
                $hasilPencarianPaginates->appends(array('search' => $kata_kunci));
            } else {
                $hasilPencarianPaginates = null;
            }
        } else {
            $hasilPencarianPaginates = null;
        }

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
        return view('portal.pencarian.index',  compact('hasilPencarianPaginates', 'informasiTerbarus',  'aplikasiIntegrasis', 'profilSingkat', 'kontak', 'laboratoriumHeaders'));
    }
}
