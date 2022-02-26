<?php

namespace App\Http\Controllers;

use App\Models\Kontak;
use App\Models\AplikasiIntegrasi;
use App\Models\InformasiTerbaru;
use App\Models\Kemitraan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Validator;

class KemitraanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $session_user = Auth::user();
        $kemitraans = Kemitraan::withTrashed()->get()
            ->sortDesc();
        return view('admin/kemitraan.index', compact('kemitraans', 'session_user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $session_user = Auth::user();
        return view('admin/kemitraan.create', compact('session_user'));
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
            return redirect('/admin/kemitraan')->with('alert', 'Ada kesalahan data, coba lagi.');
        } else {
            $path_url = 'images/kemitraan/';

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

            Kemitraan::create([
                'nama_foto' => 'images/kemitraan/' . $fileName,
                'release_date' => $request->release_date,
            ]);
            return redirect('/admin/kemitraan')->with('status', 'Kemitraan Berhasil Ditambahkan');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Kemitraan  $kemitraans
     * @return \Illuminate\Http\Response
     */
    public function show(Kemitraan $kemitraans)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Kemitraan  $kemitraans
     * @return \Illuminate\Http\Response
     */
    public function edit(Kemitraan $kemitraan)
    {
        $session_user = Auth::user();
        $kemitraan = Kemitraan::all()->firstWhere('slug', $kemitraan->slug);

        return view('admin.kemitraan.edit', compact('kemitraan', 'session_user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Kemitraan  $kemitraans
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
            return redirect('/admin/kemitraan')->with('alert', 'Ada kesalahan data, coba lagi.');
        } else {
            $kemitraans = Kemitraan::all()
                ->where('id', $request->id)
                ->first();

            if ($request->nama_foto == "") {
                $fileName = $kemitraans->nama_foto;

                Kemitraan::where('id', $request->id)
                    ->update([
                        'nama_foto' => $fileName,
                        'release_date' => $request->release_date,
                    ]);
                return redirect('/admin/kemitraan')->with('status', 'Kemitraan Berhasil Diubah');
            } else {
                $file = $kemitraans->nama_foto;
                if (file_exists($file)) {
                    @unlink($file);
                }

                $path_url = 'images/kemitraan/';

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

                Kemitraan::where('id', $request->id)
                    ->update([
                        'nama_foto' => 'images/kemitraan/' . $fileName,
                        'release_date' => $request->release_date,
                    ]);
                return redirect('/admin/kemitraan')->with('status', 'Kemitraan Berhasil Diubah');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Kemitraan  $kemitraans
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Kemitraan::destroy($id);
        return redirect('/admin/kemitraan')->with('status', 'Kemitraan Berhasil Dihapus');
    }

    public function restore($id)
    {
        $kemitraan = Kemitraan::withTrashed()
            ->where('id', $id)
            ->first();

        $kemitraan->restore();
        return redirect('/admin/kemitraan')->with('status', 'Kemitraan Berhasil Direstore');
    }

    public function delete($id)
    {
        $kemitraan = Kemitraan::withTrashed()
            ->where('id', $id)
            ->first();

        $file = $kemitraan->nama_foto;

        if (file_exists($file)) {
            @unlink($file);
        }

        $kemitraan->forceDelete();
        return redirect('/admin/kemitraan')->with('status', 'Kemitraan Berhasil Dihapus Permanen');
    }
}
