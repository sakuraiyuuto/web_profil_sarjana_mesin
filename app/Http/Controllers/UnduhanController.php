<?php

namespace App\Http\Controllers;

use App\Models\Kontak;

use App\Models\ProfilSingkat;
use App\Models\AplikasiIntegrasi;
use App\Models\HimpunanMahasiswa;
use App\Models\InformasiTerbaru;
use App\Models\Unduhan;
use App\Models\Laboratorium;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Validator;

class UnduhanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $session_user = Auth::user();
        $unduhans = Unduhan::withTrashed()->get()
            ->sortDesc();
        return view('admin/unduhan.index', compact('unduhans', 'session_user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $session_user = Auth::user();
        return view('admin/unduhan.create', compact('session_user'));
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
            return redirect('/admin/unduhan')->with('alert', 'Ada kesalahan data, coba lagi.');
        } else {
            $path_url = 'files/unduhan/';

            $originName = $request->nama_file->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->nama_file->getClientOriginalExtension();
            $fileName = Str::slug($fileName) . '_' . time() . '.' . $extension;
            $request->nama_file->move(public_path($path_url), $fileName);

            $slug = Str::slug($request->judul) . '_' . time();

            Unduhan::create([
                'nama_file' => 'files/unduhan/' . $fileName,
                'judul' => $request->judul,
                'slug' => 'unduhan/',
                'release_date' => $request->release_date,
            ]);
            return redirect('/admin/unduhan')->with('status', 'Dokumen Prodi Berhasil Ditambahkan');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Unduhan  $unduhans
     * @return \Illuminate\Http\Response
     */
    public function show(Unduhan $unduhans)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Unduhan  $unduhans
     * @return \Illuminate\Http\Response
     */
    public function edit(Unduhan $unduhan)
    {
        $session_user = Auth::user();
        $unduhan = Unduhan::all()->firstWhere('slug', $unduhan->slug);

        return view('admin.unduhan.edit', compact('unduhan', 'session_user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Unduhan  $unduhans
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
            return redirect('/admin/unduhan')->with('alert', 'Ada kesalahan data, coba lagi.');
        } else {
            $unduhans = Unduhan::all()
                ->where('id', $request->id)
                ->first();

            if ($request->nama_file == "") {
                $fileName = $unduhans->nama_file;

                Unduhan::where('id', $request->id)
                    ->update([
                        'nama_file' => $fileName,
                        'judul' => $request->judul,
                        'release_date' => $request->release_date,
                    ]);

                return redirect('/admin/unduhan')->with('status', 'Dokumen Prodi Berhasil Diubah');
            } else {
                $file = $unduhans->nama_file;
                if (file_exists($file)) {
                    @unlink($file);
                }

                $path_url = 'files/unduhan/';

                $originName = $request->nama_file->getClientOriginalName();
                $fileName = pathinfo($originName, PATHINFO_FILENAME);
                $extension = $request->nama_file->getClientOriginalExtension();
                $fileName = Str::slug($fileName) . '_' . time() . '.' . $extension;
                $request->nama_file->move(public_path($path_url), $fileName);

                Unduhan::where('id', $request->id)
                    ->update([
                        'nama_file' => 'files/unduhan/' . $fileName,
                        'judul' => $request->judul,
                        'release_date' => $request->release_date,
                    ]);

                return redirect('/admin/unduhan')->with('status', 'Dokumen Prodi Berhasil Diubah');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Unduhan  $unduhans
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Unduhan::destroy($id);
        return redirect('/admin/unduhan')->with('status', 'Dokumen Prodi Berhasil Dihapus');
    }

    public function restore($id)
    {
        $unduhan = Unduhan::withTrashed()
            ->where('id', $id)
            ->first();

        $unduhan->restore();
        return redirect('/admin/unduhan')->with('status', 'Dokumen Prodi Berhasil Direstore');
    }

    public function delete($id)
    {
        $unduhan = Unduhan::withTrashed()
            ->where('id', $id)
            ->first();

        $file = $unduhan->nama_file;

        if (file_exists($file)) {
            @unlink($file);
        }

        $unduhan->forceDelete();
        return redirect('/admin/unduhan')->with('status', 'Dokumen Prodi Berhasil Dihapus Permanen');
    }

    public function menuUnduhan()
    {
        $unduhans = Unduhan::where('release_date', '<=', date('Y-m-d'))
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

        return view('portal.unduhan.index',  compact('unduhans', 'informasiTerbarus',  'aplikasiIntegrasis', 'profilSingkat', 'kontak', 'laboratoriumHeaders'));
    }
}
