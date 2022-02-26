<?php

namespace App\Http\Controllers;

use App\Models\Kontak;

use App\Models\ProfilSingkat;
use App\Models\AplikasiIntegrasi;
use App\Models\InformasiTerbaru;
use App\Models\HimpunanMahasiswa;
use App\Models\Laboratorium;
use App\Models\ProfilLulusan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProfilLulusanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $session_user = Auth::user();
        $profilLulusans = ProfilLulusan::withTrashed()->get()
            ->sortDesc();
        return view('admin.profil_lulusan.index', compact('profilLulusans', 'session_user'));
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
            'nim' => 'required',
            'angkatan' => 'required',
            'tahun_lulus' => 'required'
        ]);

        ProfilLulusan::create($request->all());

        return redirect('/admin/profil_lulusan')->with('status', 'Profil Lulusan Berhasil Ditambah');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProfilLulusan  $profilLulusan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProfilLulusan $profilLulusan)
    {
        $request->validate([
            'nama' => 'required',
            'nim' => 'required',
            'angkatan' => 'required',
            'tahun_lulus' => 'required'
        ]);

        ProfilLulusan::where('id', $request->id)
            ->update([
                'nama' => $request->nama,
                'nim' => $request->nim,
                'angkatan' => $request->angkatan,
                'tahun_lulus' => $request->tahun_lulus
            ]);

        return redirect('/admin/profil_lulusan')->with('status', 'Profil Lulusan Berhasil Diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProfilLulusan  $profilLulusan
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProfilLulusan $profilLulusan)
    {
        ProfilLulusan::destroy($profilLulusan->id);

        return redirect('/admin/profil_lulusan')->with('status', 'Profil Lulusan Berhasil Dihapus');
    }

    public function restore($id)
    {
        $profilLulusan = ProfilLulusan::withTrashed()
            ->where('id', $id)
            ->first();

        $profilLulusan->restore();
        return redirect('/admin/profil_lulusan')->with('status', 'Profil Lulusan Berhasil Direstore');
    }

    public function delete($id)
    {
        $profilLulusan = ProfilLulusan::withTrashed()
            ->where('id', $id)
            ->first();

        $profilLulusan->forceDelete();
        return redirect('/admin/profil_lulusan')->with('status', 'Profil Lulusan Berhasil Dihapus Permanen');
    }

    public function menuProfilLulusan()
    {
        $kontak = Kontak::all()->first();

        $profilSingkat = ProfilSingkat::all()->first();
        $profilLulusans = ProfilLulusan::orderBy('tahun_lulus', 'DESC')
            ->paginate(25);
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

        return view('portal.profil_lulusan.index',  compact('profilLulusans', 'aplikasiIntegrasis', 'informasiTerbarus', 'profilSingkat', 'kontak', 'laboratoriumHeaders'));
    }
}
