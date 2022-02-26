<?php

namespace App\Http\Controllers;

use App\Models\Kontak;

use App\Models\ProfilSingkat;
use App\Models\AplikasiIntegrasi;
use App\Models\HimpunanMahasiswa;
use App\Models\InformasiTerbaru;
use App\Models\Haki;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use App\Models\Laboratorium;
use Illuminate\Support\Facades\Validator;

class HakiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $session_user = Auth::user();
        $hakis = Haki::withTrashed()->get()
            ->sortDesc();
        return view('admin/haki.index', compact('hakis', 'session_user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $session_user = Auth::user();
        return view('admin/haki.create', compact('session_user'));
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
            return redirect('/admin/haki')->with('alert', 'Ada kesalahan data, coba lagi.');
        } else {
            if ($request->nama_file == "") {

                Haki::create([
                    'judul' => $request->judul,
                    'author' => $request->author,
                    'tahun' => $request->tahun,
                    'nomor_volume' => $request->nomor_volume,
                    'url' => $request->url,
                    'release_date' => $request->release_date,
                ]);

                return redirect('/admin/haki')->with('status', 'Dokumen Prodi Berhasil Diubah');
            } else {
                $path_url = 'files/haki/';

                $originName = $request->nama_file->getClientOriginalName();
                $fileName = pathinfo($originName, PATHINFO_FILENAME);
                $extension = $request->nama_file->getClientOriginalExtension();
                $fileName = Str::slug($fileName) . '_' . time() . '.' . $extension;
                $request->nama_file->move(public_path($path_url), $fileName);

                Haki::create([
                    'nama_file' => 'files/haki/' . $fileName,
                    'judul' => $request->judul,
                    'author' => $request->author,
                    'tahun' => $request->tahun,
                    'nomor_volume' => $request->nomor_volume,
                    'url' => $request->url,
                    'release_date' => $request->release_date,
                ]);
                return redirect('/admin/haki')->with('status', 'Dokumen Prodi Berhasil Ditambahkan');
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Haki  $hakis
     * @return \Illuminate\Http\Response
     */
    public function show(Haki $hakis)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Haki  $hakis
     * @return \Illuminate\Http\Response
     */
    public function edit(Haki $haki)
    {
        $session_user = Auth::user();
        $haki = Haki::all()->firstWhere('slug', $haki->slug);

        return view('admin.haki.edit', compact('haki', 'session_user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Haki  $hakis
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
            return redirect('/admin/haki')->with('alert', 'Ada kesalahan data, coba lagi.');
        } else {
            $hakis = Haki::all()
                ->where('id', $request->id)
                ->first();

            if ($request->nama_file == "") {
                $fileName = $hakis->nama_file;

                Haki::where('id', $request->id)
                    ->update([
                        'nama_file' => $fileName,
                        'judul' => $request->judul,
                        'author' => $request->author,
                        'tahun' => $request->tahun,
                        'nomor_volume' => $request->nomor_volume,
                        'url' => $request->url,
                        'release_date' => $request->release_date,
                    ]);

                return redirect('/admin/haki')->with('status', 'Dokumen Prodi Berhasil Diubah');
            } else {
                $file = $hakis->nama_file;
                if (file_exists($file)) {
                    @unlink($file);
                }

                $path_url = 'files/haki/';

                $originName = $request->nama_file->getClientOriginalName();
                $fileName = pathinfo($originName, PATHINFO_FILENAME);
                $extension = $request->nama_file->getClientOriginalExtension();
                $fileName = Str::slug($fileName) . '_' . time() . '.' . $extension;
                $request->nama_file->move(public_path($path_url), $fileName);

                Haki::where('id', $request->id)
                    ->update([
                        'nama_file' => 'files/haki/' . $fileName,
                        'judul' => $request->judul,
                        'author' => $request->author,
                        'tahun' => $request->tahun,
                        'nomor_volume' => $request->nomor_volume,
                        'url' => $request->url,
                        'release_date' => $request->release_date,
                    ]);

                return redirect('/admin/haki')->with('status', 'Dokumen Prodi Berhasil Diubah');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Haki  $hakis
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Haki::destroy($id);
        return redirect('/admin/haki')->with('status', 'Dokumen Prodi Berhasil Dihapus');
    }

    public function restore($id)
    {
        $haki = Haki::withTrashed()
            ->where('id', $id)
            ->first();

        $haki->restore();
        return redirect('/admin/haki')->with('status', 'Dokumen Prodi Berhasil Direstore');
    }

    public function delete($id)
    {
        $haki = Haki::withTrashed()
            ->where('id', $id)
            ->first();

        $file = $haki->nama_file;

        if (file_exists($file)) {
            @unlink($file);
        }

        $haki->forceDelete();
        return redirect('/admin/haki')->with('status', 'Dokumen Prodi Berhasil Dihapus Permanen');
    }

    public function menuHaki()
    {
        $hakis = Haki::where('release_date', '<=', date('Y-m-d'))
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

        return view('portal.haki.index',  compact('hakis', 'informasiTerbarus',  'aplikasiIntegrasis', 'profilSingkat', 'kontak','laboratoriumHeaders'));
    }

    public function menuDetailHaki($slug)
    {
        $kontak = Kontak::all()->first();

        $profilSingkat = ProfilSingkat::all()->first();
        $haki = Haki::all()
            ->where('slug', 'haki/' . $slug)
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
        return view('portal.haki.detail',  compact('haki', 'aplikasiIntegrasis', 'informasiTerbarus',  'profilSingkat', 'kontak','laboratoriumHeaders'));
    }
}
