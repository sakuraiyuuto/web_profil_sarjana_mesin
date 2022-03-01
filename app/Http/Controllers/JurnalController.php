<?php

namespace App\Http\Controllers;

use App\Models\Kontak;

use App\Models\ProfilSingkat;
use App\Models\AplikasiIntegrasi;
use App\Models\InformasiTerbaru;
use App\Models\Jurnal;
use App\Models\Laboratorium;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class JurnalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $session_user = Auth::user();
        $jurnals = Jurnal::withTrashed()->get()
            ->sortDesc();
        return view('admin/jurnal.index', compact('jurnals', 'session_user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $session_user = Auth::user();
        return view('admin/jurnal.create', compact('session_user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'judul' => 'required',
            'tahun' => 'required',
            'nomor_volume' => 'required',
            'url' => 'required',
            'release_date' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('/admin/jurnal')->with('alert', 'Ada kesalahan data, coba lagi.');
        } else {
            Jurnal::create([
                'judul' => $request->judul,
                'tahun' => $request->tahun,
                'nomor_volume' => $request->nomor_volume,
                'url' => $request->url,
                'release_date' => $request->release_date,
            ]);

            return redirect('/admin/jurnal')->with('status', 'Dokumen Prodi Berhasil Diubah');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Jurnal  $jurnals
     * @return \Illuminate\Http\Response
     */
    public function show(Jurnal $jurnals)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Jurnal  $jurnals
     * @return \Illuminate\Http\Response
     */
    public function edit(Jurnal $jurnal)
    {
        $session_user = Auth::user();
        $jurnal = Jurnal::all()->firstWhere('slug', $jurnal->slug);

        return view('admin.jurnal.edit', compact('jurnal', 'session_user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Jurnal  $jurnals
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'judul' => 'required',
            'tahun' => 'required',
            'nomor_volume' => 'required',
            'url' => 'required',
            'release_date' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('/admin/jurnal')->with('alert', 'Ada kesalahan data, coba lagi.');
        } else {
            Jurnal::where('id', $request->id)
                ->update([
                    'judul' => $request->judul,
                    'tahun' => $request->tahun,
                    'nomor_volume' => $request->nomor_volume,
                    'url' => $request->url,
                    'release_date' => $request->release_date,
                ]);

            return redirect('/admin/jurnal')->with('status', 'Dokumen Prodi Berhasil Diubah');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Jurnal  $jurnals
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Jurnal::destroy($id);
        return redirect('/admin/jurnal')->with('status', 'Dokumen Prodi Berhasil Dihapus');
    }

    public function restore($id)
    {
        $jurnal = Jurnal::withTrashed()
            ->where('id', $id)
            ->first();

        $jurnal->restore();
        return redirect('/admin/jurnal')->with('status', 'Dokumen Prodi Berhasil Direstore');
    }

    public function delete($id)
    {
        $jurnal = Jurnal::withTrashed()
            ->where('id', $id)
            ->first();

        $jurnal->forceDelete();
        return redirect('/admin/jurnal')->with('status', 'Dokumen Prodi Berhasil Dihapus Permanen');
    }

    public function menuJurnal()
    {
        $jurnals = Jurnal::where('release_date', '<=', date('Y-m-d'))
            ->orderBy('tahun', 'DESC')
            ->get();

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
        return view('portal.jurnal.index',  compact('jurnals', 'informasiTerbarus',  'aplikasiIntegrasis', 'profilSingkat', 'kontak', 'laboratoriumHeaders'));
    }

    public function menuDetailJurnal($slug)
    {
        $kontak = Kontak::all()->first();

        $profilSingkat = ProfilSingkat::all()->first();
        $jurnal = Jurnal::all()
            ->where('slug', 'jurnal/' . $slug)
            ->firstOrFail();
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

        return view('portal.jurnal.index',  compact('jurnals', 'aplikasiIntegrasis', 'informasiTerbarus',  'profilSingkat', 'kontak', 'laboratoriumHeaders'));
    }
}
