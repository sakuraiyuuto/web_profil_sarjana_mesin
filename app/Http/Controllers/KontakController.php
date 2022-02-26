<?php

namespace App\Http\Controllers;

use App\Models\AplikasiIntegrasi;
use App\Models\InformasiTerbaru;
use App\Models\HimpunanMahasiswa;
use App\Models\Kontak;
use App\Models\Laboratorium;
use App\Models\ProfilSingkat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class KontakController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $session_user = Auth::user();
        $kontak = Kontak::all()->first();
        return view('admin.kontak.index',  compact('kontak', 'session_user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Kontak  $kontak
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Kontak $kontak)
    {
        $this->validate($request, [
            'email' => 'required',
            'fax' => 'required',
            'alamat' => 'required',
            'nomor_telepon' => 'required',
        ]);

        Kontak::where('id', $kontak->id)
            ->update([
                'email' => $request->email,
                'fax' => $request->fax,
                'alamat' => $request->alamat,
                'nomor_telepon' => $request->nomor_telepon,
                'youtube' => $request->youtube,
                'url_youtube' => $request->url_youtube,
                'twitter' => $request->twitter,
                'url_twitter' => $request->url_twitter,
                'facebook' => $request->facebook,
                'url_facebook' => $request->url_facebook,
                'instagram' => $request->instagram,
                'url_instagram' => $request->url_instagram,
                'whatsapp' => $request->whatsapp,
            ]);

        return redirect('admin/kontak')->with('status', 'Kontak Berhasil Diubah!');
    }

    public function menuKontak()
    {
        $kontak = Kontak::all()->first();

        $profilSingkat = ProfilSingkat::all()->first();
        $informasiTerbarus = InformasiTerbaru::informasiTerbaru()
            ->take(3)
            ->get();
        $aplikasiIntegrasis = AplikasiIntegrasi::where('release_date', '<=', date('Y-m-d'))
            ->orderBy('release_date', 'DESC')
            ->take(3)
            ->get();
        
        $laboratoriumHeaders = Laboratorium::where('release_date', '<=', date('Y-m-d'))
            ->orderBy('release_date', 'DESC')
            ->get();

        return view('portal.kontak.index',  compact('aplikasiIntegrasis', 'informasiTerbarus',  'profilSingkat', 'kontak', 'laboratoriumHeaders'));
    }
}
