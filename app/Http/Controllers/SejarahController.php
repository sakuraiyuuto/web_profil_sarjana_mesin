<?php

namespace App\Http\Controllers;

use App\Models\AplikasiIntegrasi;
use App\Models\Kontak;
use App\Models\InformasiTerbaru;

use App\Models\ProfilSingkat;
use App\Models\Sejarah;
use App\Models\HimpunanMahasiswa;
use App\Models\Laboratorium;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SejarahController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $session_user = Auth::user();
        $sejarah = Sejarah::all()->first();
        return view('admin.sejarah.index',  compact('sejarah', 'session_user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sejarah  $sejarah
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sejarah $sejarah)
    {
        $this->validate($request, [
            'teks'     => 'required'
        ]);

        Sejarah::where('id', $sejarah->id)
            ->update([
                'teks' => $request->teks
            ]);

        return redirect('admin/sejarah')->with('status', 'Sejarah Berhasil Diubah!');
    }

    public function menuSejarah()
    {
        $sejarah = Sejarah::all()
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

        return view('portal.sejarah.index',  compact('sejarah', 'informasiTerbarus',  'aplikasiIntegrasis', 'profilSingkat', 'kontak', 'laboratoriumHeaders'));
    }
}
