<?php

namespace App\Http\Controllers;

use App\Models\Kontak;

use App\Models\ProfilSingkat;
use App\Models\AplikasiIntegrasi;
use App\Models\InformasiTerbaru;
use App\Models\Laboratorium;
use App\Models\RuangStafDanDosen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RuangStafDanDosenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $session_user = Auth::user();
        $ruangStafDanDosen = RuangStafDanDosen::all()->first();
        return view('admin.ruang_staf_dan_dosen.index',  compact('ruangStafDanDosen', 'session_user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RuangStafDanDosen  $ruangStafDanDosen
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RuangStafDanDosen $ruangStafDanDosen)
    {
        $this->validate($request, [
            'teks'     => 'required'
        ]);

        RuangStafDanDosen::where('id', $ruangStafDanDosen->id)
            ->update([
                'teks' => $request->teks
            ]);

        return redirect('admin/ruang_staf_dan_dosen')->with('status', 'Ruang Staf dan Dosen Berhasil Diubah!');
    }

    public function menuRuangStafDanDosen()
    {
        $ruangStafDanDosen = RuangStafDanDosen::all()
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

        return view('portal.ruang_staf_dan_dosen.index',  compact('ruangStafDanDosen', 'informasiTerbarus',  'aplikasiIntegrasis', 'profilSingkat', 'kontak', 'laboratoriumHeaders'));
    }
}
