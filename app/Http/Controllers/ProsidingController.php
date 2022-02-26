<?php

namespace App\Http\Controllers;

use App\Models\Kontak;

use App\Models\ProfilSingkat;
use App\Models\AplikasiIntegrasi;
use App\Models\HimpunanMahasiswa;
use App\Models\InformasiTerbaru;
use App\Models\Prosiding;
use App\Models\User;
use App\Models\Laboratorium;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Validator;

class ProsidingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $session_user = Auth::user();
        $prosidings = Prosiding::withTrashed()->get()
            ->sortDesc();
        return view('admin/prosiding.index', compact('prosidings', 'session_user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $session_user = Auth::user();
        return view('admin/prosiding.create', compact('session_user'));
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
            'author' => 'required',
            'tahun' => 'required',
            'nomor_volume' => 'required',
            'url' => 'required',
            'release_date' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('/admin/prosiding')->with('alert', 'Ada kesalahan data, coba lagi.');
        } else {
            if ($request->nama_file == "") {

                Prosiding::create([
                    'judul' => $request->judul,
                    'author' => $request->author,
                    'tahun' => $request->tahun,
                    'nomor_volume' => $request->nomor_volume,
                    'url' => $request->url,
                    'release_date' => $request->release_date,
                ]);

                return redirect('/admin/prosiding')->with('status', 'Dokumen Prodi Berhasil Diubah');
            } else {
                $path_url = 'files/prosiding/';

                $originName = $request->nama_file->getClientOriginalName();
                $fileName = pathinfo($originName, PATHINFO_FILENAME);
                $extension = $request->nama_file->getClientOriginalExtension();
                $fileName = Str::slug($fileName) . '_' . time() . '.' . $extension;
                $request->nama_file->move(public_path($path_url), $fileName);

                Prosiding::create([
                    'nama_file' => 'files/prosiding/' . $fileName,
                    'judul' => $request->judul,
                    'author' => $request->author,
                    'tahun' => $request->tahun,
                    'nomor_volume' => $request->nomor_volume,
                    'url' => $request->url,
                    'release_date' => $request->release_date,
                ]);
                return redirect('/admin/prosiding')->with('status', 'Dokumen Prodi Berhasil Ditambahkan');
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Prosiding  $prosidings
     * @return \Illuminate\Http\Response
     */
    public function show(Prosiding $prosidings)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Prosiding  $prosidings
     * @return \Illuminate\Http\Response
     */
    public function edit(Prosiding $prosiding)
    {
        $session_user = Auth::user();
        $prosiding = Prosiding::all()->firstWhere('slug', $prosiding->slug);

        return view('admin.prosiding.edit', compact('prosiding', 'session_user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Prosiding  $prosidings
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'judul' => 'required',
            'author' => 'required',
            'tahun' => 'required',
            'nomor_volume' => 'required',
            'url' => 'required',
            'release_date' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('/admin/prosiding')->with('alert', 'Ada kesalahan data, coba lagi.');
        } else {
            $prosidings = Prosiding::all()
                ->where('id', $request->id)
                ->first();

            if ($request->nama_file == "") {
                $fileName = $prosidings->nama_file;

                Prosiding::where('id', $request->id)
                    ->update([
                        'nama_file' => $fileName,
                        'judul' => $request->judul,
                        'author' => $request->author,
                        'tahun' => $request->tahun,
                        'nomor_volume' => $request->nomor_volume,
                        'url' => $request->url,
                        'release_date' => $request->release_date,
                    ]);

                return redirect('/admin/prosiding')->with('status', 'Dokumen Prodi Berhasil Diubah');
            } else {
                $file = $prosidings->nama_file;
                if (file_exists($file)) {
                    @unlink($file);
                }

                $path_url = 'files/prosiding/';

                $originName = $request->nama_file->getClientOriginalName();
                $fileName = pathinfo($originName, PATHINFO_FILENAME);
                $extension = $request->nama_file->getClientOriginalExtension();
                $fileName = Str::slug($fileName) . '_' . time() . '.' . $extension;
                $request->nama_file->move(public_path($path_url), $fileName);

                Prosiding::where('id', $request->id)
                    ->update([
                        'nama_file' => 'files/prosiding/' . $fileName,
                        'judul' => $request->judul,
                        'author' => $request->author,
                        'tahun' => $request->tahun,
                        'nomor_volume' => $request->nomor_volume,
                        'url' => $request->url,
                        'release_date' => $request->release_date,
                    ]);

                return redirect('/admin/prosiding')->with('status', 'Dokumen Prodi Berhasil Diubah');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Prosiding  $prosidings
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Prosiding::destroy($id);
        return redirect('/admin/prosiding')->with('status', 'Dokumen Prodi Berhasil Dihapus');
    }

    public function restore($id)
    {
        $prosiding = Prosiding::withTrashed()
            ->where('id', $id)
            ->first();

        $prosiding->restore();
        return redirect('/admin/prosiding')->with('status', 'Dokumen Prodi Berhasil Direstore');
    }

    public function delete($id)
    {
        $prosiding = Prosiding::withTrashed()
            ->where('id', $id)
            ->first();

        $file = $prosiding->nama_file;

        if (file_exists($file)) {
            @unlink($file);
        }

        $prosiding->forceDelete();
        return redirect('/admin/prosiding')->with('status', 'Dokumen Prodi Berhasil Dihapus Permanen');
    }

    public function menuProsiding()
    {
        $prosidings = Prosiding::where('release_date', '<=', date('Y-m-d'))
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
        return view('portal.prosiding.index',  compact('prosidings', 'informasiTerbarus',  'aplikasiIntegrasis', 'profilSingkat', 'kontak','laboratoriumHeaders'));
    }

    public function menuDetailProsiding($slug)
    {
        $kontak = Kontak::all()->first();

        $profilSingkat = ProfilSingkat::all()->first();
        $prosiding = Prosiding::all()
            ->where('slug', 'prosiding/' . $slug)
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
        return view('portal.prosiding.detail',  compact('prosiding', 'aplikasiIntegrasis', 'informasiTerbarus',  'profilSingkat', 'kontak','laboratoriumHeaders'));
    }
}
