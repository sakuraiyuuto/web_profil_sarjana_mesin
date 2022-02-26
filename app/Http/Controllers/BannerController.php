<?php

namespace App\Http\Controllers;

use App\Models\Kontak;
use App\Models\AplikasiIntegrasi;
use App\Models\InformasiTerbaru;
use App\Models\Banner;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Validator;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $session_user = Auth::user();
        $banners = Banner::withTrashed()->get()
            ->sortDesc();
        return view('admin/banner.index', compact('banners', 'session_user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $session_user = Auth::user();
        return view('admin/banner.create', compact('session_user'));
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
            'teks' => 'required',
            'release_date' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('/admin/banner')->with('alert', 'Ada kesalahan data, coba lagi.');
        } else {
            $path_url = 'images/banner/';

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

            Banner::create([
                'nama_foto' => 'images/banner/' . $fileName,
                'teks' => $request->teks,
                'release_date' => $request->release_date,
            ]);
            return redirect('/admin/banner')->with('status', 'Banner Berhasil Ditambahkan');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Banner  $banners
     * @return \Illuminate\Http\Response
     */
    public function show(Banner $banners)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Banner  $banners
     * @return \Illuminate\Http\Response
     */
    public function edit(Banner $banner)
    {
        $session_user = Auth::user();
        $banner = Banner::all()->firstWhere('slug', $banner->slug);

        return view('admin.banner.edit', compact('banner', 'session_user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Banner  $banners
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'nama_foto' => 'mimes:jpg,jpeg,png,svg,gif',
            'teks' => 'required',
            'release_date' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('/admin/banner')->with('alert', 'Ada kesalahan data, coba lagi.');
        } else {
            $banners = Banner::all()
                ->where('id', $request->id)
                ->first();

            if ($request->nama_foto == "") {
                $fileName = $banners->nama_foto;

                Banner::where('id', $request->id)
                    ->update([
                        'nama_foto' => $fileName,
                        'teks' => $request->teks,
                        'release_date' => $request->release_date,
                    ]);
                return redirect('/admin/banner')->with('status', 'Banner Berhasil Diubah');
            } else {
                $file = $banners->nama_foto;
                if (file_exists($file)) {
                    @unlink($file);
                }

                $path_url = 'images/banner/';

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

                Banner::where('id', $request->id)
                    ->update([
                        'nama_foto' => 'images/banner/' . $fileName,
                        'teks' => $request->teks,
                        'release_date' => $request->release_date,
                    ]);
                return redirect('/admin/banner')->with('status', 'Banner Berhasil Diubah');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Banner  $banners
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Banner::destroy($id);
        return redirect('/admin/banner')->with('status', 'Banner Berhasil Dihapus');
    }

    public function restore($id)
    {
        $banner = Banner::withTrashed()
            ->where('id', $id)
            ->first();

        $banner->restore();
        return redirect('/admin/banner')->with('status', 'Banner Berhasil Direstore');
    }

    public function delete($id)
    {
        $banner = Banner::withTrashed()
            ->where('id', $id)
            ->first();

        $file = $banner->nama_foto;

        if (file_exists($file)) {
            @unlink($file);
        }

        $banner->forceDelete();
        return redirect('/admin/banner')->with('status', 'Banner Berhasil Dihapus Permanen');
    }
}
