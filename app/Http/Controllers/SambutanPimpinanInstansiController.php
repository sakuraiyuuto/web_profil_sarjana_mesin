<?php

namespace App\Http\Controllers;

use App\Models\AplikasiIntegrasi;
use App\Models\Kontak;
use App\Models\InformasiTerbaru;
use App\Models\HimpunanMahasiswa;
use App\Models\Laboratorium;
use App\Models\ProfilSingkat;
use App\Models\SambutanPimpinanInstansi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SambutanPimpinanInstansiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $session_user = Auth::user();
        $sambutanPimpinanInstansi = SambutanPimpinanInstansi::all()->first();
        return view('admin.sambutan.index',  compact('sambutanPimpinanInstansi', 'session_user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SambutanPimpinanInstansi  $sambutanPimpinanInstansi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SambutanPimpinanInstansi $sambutanPimpinanInstansi)
    {
        $this->validate($request, [
            'teks'     => 'required'
        ]);

        SambutanPimpinanInstansi::where('id', $sambutanPimpinanInstansi->id)
            ->update([
                'teks' => $request->teks
            ]);

        return redirect('admin/sambutan')->with('status', 'SambutanPimpinanInstansi Berhasil Diubah!');
    }

    public function menuSambutanPimpinanInstansi()
    {
        $sambutanPimpinanInstansi = SambutanPimpinanInstansi::all()
            ->first();

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

        return view('portal.sambutan.index',   compact('sambutanPimpinanInstansi', 'informasiTerbarus',  'aplikasiIntegrasis', 'profilSingkat', 'kontak', 'laboratoriumHeaders'));
    }
}
