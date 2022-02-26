<?php

namespace App\Http\Controllers;

use App\Models\Kontak;

use App\Models\ProfilSingkat;
use App\Models\AplikasiIntegrasi;
use App\Models\HimpunanMahasiswa;
use App\Models\InformasiTerbaru;
use App\Models\DokumenProdi;
use App\Models\Laboratorium;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Validator;

class DokumenProdiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $session_user = Auth::user();
        $dokumenProdis = DokumenProdi::withTrashed()->get()
            ->sortDesc();
        return view('admin/dokumen_prodi.index', compact('dokumenProdis', 'session_user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $session_user = Auth::user();
        return view('admin/dokumen_prodi.create', compact('session_user'));
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
            'nama_file' => 'required',
            'release_date' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('/admin/dokumen_prodi')->with('alert', 'Ada kesalahan data, coba lagi.');
        } else {
            $path_url = 'files/dokumen_prodi/';

            $originName = $request->nama_file->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->nama_file->getClientOriginalExtension();
            $fileName = Str::slug($fileName) . '_' . time() . '.' . $extension;
            $request->nama_file->move(public_path($path_url), $fileName);

            $slug = Str::slug($request->judul) . '_' . time();

            DokumenProdi::create([
                'nama_file' => 'files/dokumen_prodi/' . $fileName,
                'judul' => $request->judul,
                'slug' => 'dokumen_prodi/',
                'release_date' => $request->release_date,
            ]);
            return redirect('/admin/dokumen_prodi')->with('status', 'Dokumen Prodi Berhasil Ditambahkan');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DokumenProdi  $dokumenProdis
     * @return \Illuminate\Http\Response
     */
    public function show(DokumenProdi $dokumenProdis)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DokumenProdi  $dokumenProdis
     * @return \Illuminate\Http\Response
     */
    public function edit(DokumenProdi $dokumenProdi)
    {
        $session_user = Auth::user();
        $dokumenProdi = DokumenProdi::all()->firstWhere('slug', $dokumenProdi->slug);

        return view('admin.dokumen_prodi.edit', compact('dokumenProdi', 'session_user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DokumenProdi  $dokumenProdis
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'judul' => 'required',
            'release_date' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('/admin/dokumen_prodi')->with('alert', 'Ada kesalahan data, coba lagi.');
        } else {
            $dokumenProdis = DokumenProdi::all()
                ->where('id', $request->id)
                ->first();

            if ($request->nama_file == "") {
                $fileName = $dokumenProdis->nama_file;

                DokumenProdi::where('id', $request->id)
                    ->update([
                        'nama_file' => $fileName,
                        'judul' => $request->judul,
                        'release_date' => $request->release_date,
                    ]);

                return redirect('/admin/dokumen_prodi')->with('status', 'Dokumen Prodi Berhasil Diubah');
            } else {
                $file = $dokumenProdis->nama_file;
                if (file_exists($file)) {
                    @unlink($file);
                }

                $path_url = 'files/dokumen_prodi/';

                $originName = $request->nama_file->getClientOriginalName();
                $fileName = pathinfo($originName, PATHINFO_FILENAME);
                $extension = $request->nama_file->getClientOriginalExtension();
                $fileName = Str::slug($fileName) . '_' . time() . '.' . $extension;
                $request->nama_file->move(public_path($path_url), $fileName);

                DokumenProdi::where('id', $request->id)
                    ->update([
                        'nama_file' => 'files/dokumen_prodi/' . $fileName,
                        'judul' => $request->judul,
                        'release_date' => $request->release_date,
                    ]);

                return redirect('/admin/dokumen_prodi')->with('status', 'Dokumen Prodi Berhasil Diubah');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DokumenProdi  $dokumenProdis
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DokumenProdi::destroy($id);
        return redirect('/admin/dokumen_prodi')->with('status', 'Dokumen Prodi Berhasil Dihapus');
    }

    public function restore($id)
    {
        $dokumenProdi = DokumenProdi::withTrashed()
            ->where('id', $id)
            ->first();

        $dokumenProdi->restore();
        return redirect('/admin/dokumen_prodi')->with('status', 'Dokumen Prodi Berhasil Direstore');
    }

    public function delete($id)
    {
        $dokumenProdi = DokumenProdi::withTrashed()
            ->where('id', $id)
            ->first();

        $file = $dokumenProdi->nama_file;

        if (file_exists($file)) {
            @unlink($file);
        }

        $dokumenProdi->forceDelete();
        return redirect('/admin/dokumen_prodi')->with('status', 'Dokumen Prodi Berhasil Dihapus Permanen');
    }

    public function menuDokumenProdi()
    {
        $dokumenProdis = DokumenProdi::where('release_date', '<=', date('Y-m-d'))
            ->orderBy('release_date', 'DESC')
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

        return view('portal.dokumen_prodi.index',  compact('dokumenProdis', 'informasiTerbarus',  'aplikasiIntegrasis', 'profilSingkat', 'kontak', 'laboratoriumHeaders'));
    }
}
