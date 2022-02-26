<?php

namespace App\Http\Controllers;

use App\Models\AplikasiIntegrasi;
use App\Models\Dosen;
use App\Models\Kontak;
use App\Models\InformasiTerbaru;

use App\Models\HimpunanMahasiswa;
use App\Models\KelompokKeahlianDosen;
use App\Models\Laboratorium;
use App\Models\ProfilSingkat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use League\CommonMark\Extension\CommonMark\Node\Inline\Link;
use Illuminate\Support\Facades\Validator;

class DosenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $session_user = Auth::user();
        $kelompokKeahlianDosens = KelompokKeahlianDosen::withTrashed()->get()->sortByDesc('id');
        $kelompokKeahlianDosenPilihans = KelompokKeahlianDosen::all()->sortByDesc('id');
        $dosens = Dosen::withTrashed()->with('kelompokKeahlianDosen')
            ->orderBy('id', 'desc')
            ->get();

        return view('admin.dosen.index', compact('dosens', 'kelompokKeahlianDosens', 'kelompokKeahlianDosenPilihans', 'session_user'));
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
            'pangkat_golongan' => 'required',
            'kelompok_keahlian_dosen_id' => 'required'
        ]);

        Dosen::create($request->all());

        return redirect('/admin/dosen')->with('status', 'Data Berhasil Ditambah!');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Dosen  $dosen
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Dosen $dosen)
    {
        $request->validate([
            'nama' => 'required',
            'nip' => 'required',
            'pangkat_golongan' => 'required',
            'kelompok_keahlian_dosen_id' => 'required'
        ]);

        Dosen::where('id', $request->id)
            ->update([
                'nama' => $request->nama,
                'nip' => $request->nip,
                'pangkat_golongan' => $request->pangkat_golongan,
                'url' => $request->url,
                'kelompok_keahlian_dosen_id' => $request->kelompok_keahlian_dosen_id
            ]);

        return redirect('/admin/dosen')->with('status', 'Data Berhasil Diubah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Dosen  $dosen
     * @return \Illuminate\Http\Response
     */
    public function destroy(Dosen $dosen)
    {
        Dosen::destroy($dosen->id);

        return redirect('/admin/dosen')->with('status', 'Data Berhasil Dihapus!');
    }

    public function restore($id)
    {
        $dosen = Dosen::withTrashed()
            ->where('id', $id)
            ->first();

        $dosen->restore();
        return redirect('/admin/dosen')->with('status', 'Dosen Berhasil Direstore');
    }

    public function delete($id)
    {
        $dosen = Dosen::withTrashed()
            ->where('id', $id)
            ->first();

        $dosen->forceDelete();
        return redirect('/admin/dosen')->with('status', 'Dosen Berhasil Dihapus Permanen');
    }

    public function menuDosen()
    {
        $kontak = Kontak::all()->first();

        $profilSingkat = ProfilSingkat::all()->first();
        $dosens = Dosen::orderBy('nama', 'ASC')
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

        return view('portal.dosen.index',  compact('dosens', 'kontak', 'informasiTerbarus', 'aplikasiIntegrasis',  'profilSingkat', 'laboratoriumHeaders'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeKelompoKeahlianDosen(Request $request)
    {
        $request->validate([
            'kelompok_keahlian' => 'required',
        ]);

        KelompokKeahlianDosen::create($request->all());

        return redirect('/admin/dosen')->with('status', 'Kelompok Keahlian Dosen Berhasil Ditambah');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\KelompokKeahlianDosen  $kelompokKeahlianDosen
     * @return \Illuminate\Http\Response
     */
    public function updateKelompoKeahlianDosen(Request $request, KelompokKeahlianDosen $kelompokKeahlianDosen)
    {
        $request->validate([
            'kelompok_keahlian' => 'required',
        ]);

        KelompokKeahlianDosen::where('id', $request->id)
            ->update([
                'kelompok_keahlian' => $request->kelompok_keahlian,
            ]);

        return redirect('/admin/dosen')->with('status', 'Kelompok Keahlian Dosen Berhasil Diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\KelompokKeahlianDosen  $kelompokKeahlianDosen
     * @return \Illuminate\Http\Response
     */
    public function destroyKelompoKeahlianDosen(KelompokKeahlianDosen $kelompokKeahlianDosen)
    {
        KelompokKeahlianDosen::destroy($kelompokKeahlianDosen->id);

        return redirect('/admin/dosen')->with('status', 'Kelompok Keahlian Dosen Berhasil Dihapus');
    }

    public function restoreKelompoKeahlianDosen($id)
    {
        $kelompokKeahlianDosen = KelompokKeahlianDosen::withTrashed()
            ->where('id', $id)
            ->first();

        $kelompokKeahlianDosen->restore();
        return redirect('/admin/dosen')->with('status', 'Kelompok Keahlian Dosen Berhasil Direstore');
    }

    public function deleteKelompoKeahlianDosen($id)
    {
        $kelompokKeahlianDosen = KelompokKeahlianDosen::withTrashed()
            ->where('id', $id)
            ->first();

        $kelompokKeahlianDosen->forceDelete();
        return redirect('/admin/dosen')->with('status', 'Kelompok Keahlian Dosen Berhasil Dihapus Permanen');
    }
}
