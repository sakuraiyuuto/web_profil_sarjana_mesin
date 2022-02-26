<?php

namespace App\Http\Controllers;

use App\Models\Kontak;

use App\Models\ProfilSingkat;
use App\Models\AplikasiIntegrasi;
use App\Models\HimpunanMahasiswa;
use App\Models\InformasiTerbaru;
use App\Models\Laboratorium;
use App\Models\TataTertibPeraturan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TataTertibPeraturanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $session_user = Auth::user();
        $tataTertibPeraturan = TataTertibPeraturan::all()->first();
        return view('admin.tata_tertib_peraturan.index',  compact('tataTertibPeraturan', 'session_user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TataTertibPeraturan  $tataTertibPeraturan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TataTertibPeraturan $tataTertibPeraturan)
    {
        $this->validate($request, [
            'teks'     => 'required'
        ]);

        TataTertibPeraturan::where('id', $tataTertibPeraturan->id)
            ->update([
                'teks' => $request->teks
            ]);

        return redirect('admin/tata_tertib_peraturan')->with('status', 'Tata Tertib dan Peraturan Berhasil Diubah!');
    }

    public function menuTataTertibPeraturan()
    {
        $tataTertibPeraturan = TataTertibPeraturan::all()
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

        return view('portal.tata_tertib_peraturan.index',  compact('tataTertibPeraturan', 'informasiTerbarus',  'aplikasiIntegrasis', 'profilSingkat', 'kontak', 'laboratoriumHeaders'));
    }
}
