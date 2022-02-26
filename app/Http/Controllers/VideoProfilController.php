<?php

namespace App\Http\Controllers;

use App\Models\AplikasiIntegrasi;
use App\Models\Kontak;
use App\Models\InformasiTerbaru;
use App\Models\HimpunanMahasiswa;
use App\Models\Laboratorium;
use App\Models\ProfilSingkat;
use App\Models\VideoProfil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VideoProfilController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $session_user = Auth::user();
        $videoProfil = VideoProfil::all()->first();
        return view('admin.video_profil.index',  compact('videoProfil', 'session_user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\VideoProfil  $videoProfil
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, VideoProfil $videoProfil)
    {
        $this->validate($request, [
            'judul' => 'required',
            'url' => 'required',
            'teks'     => 'required'
        ]);

        VideoProfil::where('id', $videoProfil->id)
            ->update([
                'judul' => $request->judul,
                'url' => $request->url,
                'teks' => $request->teks
            ]);

        return redirect('admin/video_profil')->with('status', 'Video Profil Berhasil Diubah!');
    }

    public function menuVideoProfil()
    {
        $videoProfil = VideoProfil::all()
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

        return view('portal.video_profil.index',  compact('videoProfil', 'informasiTerbarus',  'aplikasiIntegrasis', 'profilSingkat', 'kontak', 'laboratoriumHeaders'));
    }
}
