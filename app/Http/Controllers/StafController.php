<?php

namespace App\Http\Controllers;

use App\Models\AplikasiIntegrasi;
use App\Models\Kontak;
use App\Models\InformasiTerbaru;

use App\Models\HimpunanMahasiswa;
use App\Models\Laboratorium;
use App\Models\ProfilSingkat;
use App\Models\Staf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StafController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $session_user = Auth::user();
        $stafs = Staf::all();

        return view('admin.staf.index', compact('stafs', 'session_user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'nip' => 'required',
            'pangkat_golongan' => 'required'
        ]);

        Staf::create($request->all());

        return redirect('/admin/staf')->with('status', 'Data Berhasil Ditambah');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Staf  $staf
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Staf $staf)
    {
        $request->validate([
            'nama' => 'required',
            'nip' => 'required',
            'pangkat_golongan' => 'required'
        ]);

        Staf::where('id', $request->id)
            ->update([
                'nama' => $request->nama,
                'nip' => $request->nip,
                'pangkat_golongan' => $request->pangkat_golongan
            ]);

        return redirect('/admin/staf')->with('status', 'Data Berhasil Diubah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Staf  $staf
     * @return \Illuminate\Http\Response
     */
    public function destroy(Staf $staf)
    {
        Staf::destroy($staf->id);

        return redirect('/admin/staf')->with('status', 'Data Berhasil Dihapus!');
    }

    public function menuStaf()
    {
        $kontak = Kontak::all()->first();



        $profilSingkat = ProfilSingkat::all()->first();

        $stafs = Staf::orderBy('nama', 'asc')
            ->get();

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
        
        return view('portal.staf.index',  compact('stafs', 'kontak', 'informasiTerbarus', 'aplikasiIntegrasis',  'profilSingkat', 'laboratoriumHeaders'));
    }
}
