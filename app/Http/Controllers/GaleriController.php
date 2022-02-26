<?php

namespace App\Http\Controllers;

use App\Models\Kontak;
use App\Models\AplikasiIntegrasi;
use App\Models\InformasiTerbaru;
use App\Models\Galeri;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Validator;

class GaleriController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $session_user = Auth::user();
        $galeris = Galeri::withTrashed()->get()
            ->sortDesc();
        return view('admin/galeri.index', compact('galeris', 'session_user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $session_user = Auth::user();
        return view('admin/galeri.create', compact('session_user'));
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
            'nama_foto' => 'required|mimes:jpg,jpeg,png,svg,gif',
            'release_date' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('/admin/galeri')->with('alert', 'Ada kesalahan data, coba lagi.');
        } else {
            $path_url = 'images/galeri/';

            $originName = $request->nama_foto->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->nama_foto->getClientOriginalExtension();
            $fileName = Str::slug($fileName) . '_' . time() . '.' . $extension;
            $request->nama_foto->move(public_path($path_url), $fileName);

            //Resize image here
            $nama_fotopath = public_path($path_url) . $fileName;
            $img = Image::make($nama_fotopath)->resize(720, 480, function ($constraint) {
                $constraint->aspectRatio();
            });

            $img->save($nama_fotopath);

            Galeri::create([
                'nama_foto' => 'images/galeri/' . $fileName,
                'release_date' => $request->release_date,
            ]);
            return redirect('/admin/galeri')->with('status', 'Galeri Berhasil Ditambahkan');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Galeri  $galeris
     * @return \Illuminate\Http\Response
     */
    public function show(Galeri $galeris)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Galeri  $galeris
     * @return \Illuminate\Http\Response
     */
    public function edit(Galeri $galeri)
    {
        $session_user = Auth::user();
        $galeri = Galeri::all()->firstWhere('slug', $galeri->slug);

        return view('admin.galeri.edit', compact('galeri', 'session_user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Galeri  $galeris
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'nama_foto' => 'mimes:jpg,jpeg,png,svg,gif',
            'release_date' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('/admin/galeri')->with('alert', 'Ada kesalahan data, coba lagi.');
        } else {
            $galeris = Galeri::all()
                ->where('id', $request->id)
                ->first();

            if ($request->nama_foto == "") {
                $fileName = $galeris->nama_foto;

                Galeri::where('id', $request->id)
                    ->update([
                        'nama_foto' => $fileName,
                        'release_date' => $request->release_date,
                    ]);
                return redirect('/admin/galeri')->with('status', 'Galeri Berhasil Diubah');
            } else {
                $file = $galeris->nama_foto;
                if (file_exists($file)) {
                    @unlink($file);
                }

                $path_url = 'images/galeri/';

                $originName = $request->nama_foto->getClientOriginalName();
                $fileName = pathinfo($originName, PATHINFO_FILENAME);
                $extension = $request->nama_foto->getClientOriginalExtension();
                $fileName = Str::slug($fileName) . '_' . time() . '.' . $extension;
                $request->nama_foto->move(public_path($path_url), $fileName);

                //Resize image here
                $nama_fotopath = public_path($path_url) . $fileName;
                $img = Image::make($nama_fotopath)->resize(720, 480, function ($constraint) {
                    $constraint->aspectRatio();
                });

                $img->save($nama_fotopath);

                Galeri::where('id', $request->id)
                    ->update([
                        'nama_foto' => 'images/galeri/' . $fileName,
                        'release_date' => $request->release_date,
                    ]);
                return redirect('/admin/galeri')->with('status', 'Galeri Berhasil Diubah');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Galeri  $galeris
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Galeri::destroy($id);
        return redirect('/admin/galeri')->with('status', 'Galeri Berhasil Dihapus');
    }

    public function restore($id)
    {
        $galeri = Galeri::withTrashed()
            ->where('id', $id)
            ->first();

        $galeri->restore();
        return redirect('/admin/galeri')->with('status', 'Galeri Berhasil Direstore');
    }

    public function delete($id)
    {
        $galeri = Galeri::withTrashed()
            ->where('id', $id)
            ->first();

        $file = $galeri->nama_foto;

        if (file_exists($file)) {
            @unlink($file);
        }

        $galeri->forceDelete();
        return redirect('/admin/galeri')->with('status', 'Galeri Berhasil Dihapus Permanen');
    }
}
