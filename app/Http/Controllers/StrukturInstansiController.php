<?php

namespace App\Http\Controllers;

use App\Models\AplikasiIntegrasi;
use App\Models\Kontak;
use App\Models\HimpunanMahasiswa;
use App\Models\InformasiTerbaru;
use App\Models\Laboratorium;
use App\Models\ProfilSingkat;
use App\Models\StrukturInstansi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StrukturInstansiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $session_user = Auth::user();
        $strukturInstansi = StrukturInstansi::all()->first();
        return view('admin.struktur_organisasi.index',  compact('strukturInstansi', 'session_user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\StrukturInstansi  $strukturInstansi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, StrukturInstansi $strukturInstansi)
    {
        $this->validate($request, [
            'teks'     => 'required'
        ]);

        StrukturInstansi::where('id', $strukturInstansi->id)
            ->update([
                'teks' => $request->teks
            ]);

        return redirect('admin/struktur_organisasi')->with('status', 'Struktur Organisasi Berhasil Diubah!');
    }

    public function menuStrukturInstansi()
    {
        $strukturInstansi = StrukturInstansi::all()
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

        return view('portal.struktur_organisasi.index',  compact('strukturInstansi', 'informasiTerbarus',  'aplikasiIntegrasis', 'profilSingkat', 'kontak', 'laboratoriumHeaders'));
    }
}
