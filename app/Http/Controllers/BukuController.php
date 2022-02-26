<?php

namespace App\Http\Controllers;

use App\Models\Kontak;

use App\Models\ProfilSingkat;
use App\Models\AplikasiIntegrasi;
use App\Models\HimpunanMahasiswa;
use App\Models\InformasiTerbaru;
use App\Models\Buku;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Laboratorium;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Validator;

class BukuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $session_user = Auth::user();
        $bukus = Buku::withTrashed()->get()
            ->sortDesc();
        return view('admin/buku.index', compact('bukus', 'session_user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $session_user = Auth::user();
        return view('admin/buku.create', compact('session_user'));
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
            return redirect('/admin/buku')->with('alert', 'Ada kesalahan data, coba lagi.');
        } else {
            if ($request->nama_file == "") {

                Buku::create([
                    'judul' => $request->judul,
                    'author' => $request->author,
                    'tahun' => $request->tahun,
                    'nomor_volume' => $request->nomor_volume,
                    'url' => $request->url,
                    'release_date' => $request->release_date,
                ]);

                return redirect('/admin/buku')->with('status', 'Dokumen Prodi Berhasil Diubah');
            } else {
                $path_url = 'files/buku/';

                $originName = $request->nama_file->getClientOriginalName();
                $fileName = pathinfo($originName, PATHINFO_FILENAME);
                $extension = $request->nama_file->getClientOriginalExtension();
                $fileName = Str::slug($fileName) . '_' . time() . '.' . $extension;
                $request->nama_file->move(public_path($path_url), $fileName);

                Buku::create([
                    'nama_file' => 'files/buku/' . $fileName,
                    'judul' => $request->judul,
                    'author' => $request->author,
                    'tahun' => $request->tahun,
                    'nomor_volume' => $request->nomor_volume,
                    'url' => $request->url,
                    'release_date' => $request->release_date,
                ]);
                return redirect('/admin/buku')->with('status', 'Dokumen Prodi Berhasil Ditambahkan');
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Buku  $bukus
     * @return \Illuminate\Http\Response
     */
    public function show(Buku $bukus)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Buku  $bukus
     * @return \Illuminate\Http\Response
     */
    public function edit(Buku $buku)
    {
        $session_user = Auth::user();
        $buku = Buku::all()->firstWhere('slug', $buku->slug);

        return view('admin.buku.edit', compact('buku', 'session_user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Buku  $bukus
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
            return redirect('/admin/buku')->with('alert', 'Ada kesalahan data, coba lagi.');
        } else {
            $bukus = Buku::all()
                ->where('id', $request->id)
                ->first();

            if ($request->nama_file == "") {
                $fileName = $bukus->nama_file;

                Buku::where('id', $request->id)
                    ->update([
                        'nama_file' => $fileName,
                        'judul' => $request->judul,
                        'author' => $request->author,
                        'tahun' => $request->tahun,
                        'nomor_volume' => $request->nomor_volume,
                        'url' => $request->url,
                        'release_date' => $request->release_date,
                    ]);

                return redirect('/admin/buku')->with('status', 'Dokumen Prodi Berhasil Diubah');
            } else {
                $file = $bukus->nama_file;
                if (file_exists($file)) {
                    @unlink($file);
                }

                $path_url = 'files/buku/';

                $originName = $request->nama_file->getClientOriginalName();
                $fileName = pathinfo($originName, PATHINFO_FILENAME);
                $extension = $request->nama_file->getClientOriginalExtension();
                $fileName = Str::slug($fileName) . '_' . time() . '.' . $extension;
                $request->nama_file->move(public_path($path_url), $fileName);

                Buku::where('id', $request->id)
                    ->update([
                        'nama_file' => 'files/buku/' . $fileName,
                        'judul' => $request->judul,
                        'author' => $request->author,
                        'tahun' => $request->tahun,
                        'nomor_volume' => $request->nomor_volume,
                        'url' => $request->url,
                        'release_date' => $request->release_date,
                    ]);

                return redirect('/admin/buku')->with('status', 'Dokumen Prodi Berhasil Diubah');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Buku  $bukus
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Buku::destroy($id);
        return redirect('/admin/buku')->with('status', 'Dokumen Prodi Berhasil Dihapus');
    }

    public function restore($id)
    {
        $buku = Buku::withTrashed()
            ->where('id', $id)
            ->first();

        $buku->restore();
        return redirect('/admin/buku')->with('status', 'Dokumen Prodi Berhasil Direstore');
    }

    public function delete($id)
    {
        $buku = Buku::withTrashed()
            ->where('id', $id)
            ->first();

        $file = $buku->nama_file;

        if (file_exists($file)) {
            @unlink($file);
        }

        $buku->forceDelete();
        return redirect('/admin/buku')->with('status', 'Dokumen Prodi Berhasil Dihapus Permanen');
    }

    public function menuBuku()
    {
        $bukus = Buku::where('release_date', '<=', date('Y-m-d'))
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

        return view('portal.buku.index',  compact('bukus', 'informasiTerbarus',  'aplikasiIntegrasis', 'profilSingkat', 'kontak','laboratoriumHeaders'));
    }

    public function menuDetailBuku($slug)
    {
        $kontak = Kontak::all()->first();

        $profilSingkat = ProfilSingkat::all()->first();
        $buku = Buku::all()
            ->where('slug', 'buku/' . $slug)
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
        return view('portal.buku.detail',  compact('buku', 'aplikasiIntegrasis', 'informasiTerbarus',  'profilSingkat', 'kontak','laboratoriumHeaders'));
    }
}
