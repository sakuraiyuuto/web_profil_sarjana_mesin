<?php

namespace App\Http\Controllers;

use App\Models\Kontak;

use App\Models\ProfilSingkat;
use App\Models\AplikasiIntegrasi;
use App\Models\InformasiTerbaru;
use App\Models\IkatanAlumni;
use App\Models\Laboratorium;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Validator;

class IkatanAlumniController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $session_user = Auth::user();
        $ikatanAlumni = IkatanAlumni::all()->first();
        return view('admin/ikatan_alumni.index', compact('ikatanAlumni', 'session_user'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\IkatanAlumni  $ikatanAlumni
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'thumbnail' => 'mimes:jpg,jpeg,png,svg,gif',
            'teks' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('/admin/ikatan_alumni')->with('alert', 'Ada kesalahan data, coba lagi.');
        } else {
            $ikatanAlumni = IkatanAlumni::all()
                ->where('id', $id)
                ->first();

            if ($request->thumbnail == "") {

                $fileName = $ikatanAlumni->thumbnail;

                IkatanAlumni::where('id', $ikatanAlumni->id)
                    ->update([
                        'thumbnail' => $fileName,
                        'nama' => $request->nama,
                        'teks' => $request->teks,
                        'facebook' => $request->facebook,
                        'url_facebook' => $request->url_facebook,
                        'instagram' => $request->instagram,
                        'url_instagram' => $request->url_instagram,
                        'youtube' => $request->youtube,
                        'url_youtube' => $request->url_youtube,
                        'twitter' => $request->twitter,
                        'url_twitter' => $request->url_twitter,
                    ]);
                return redirect('/admin/ikatan_alumni')->with('status', 'Ikatan Alumni Berhasil Diubah');
            } else {
                $file = $ikatanAlumni->thumbnail;
                if (file_exists($file)) {
                    @unlink($file);
                }

                $path_url = 'images/ikatan_alumni/';

                $originName = $request->thumbnail->getClientOriginalName();
                $fileName = pathinfo($originName, PATHINFO_FILENAME);
                $extension = $request->thumbnail->getClientOriginalExtension();
                $fileName = Str::slug($fileName) . '_' . time() . '.' . $extension;
                $request->thumbnail->move(public_path($path_url), $fileName);

                //Resize image here
                $thumbnailpath = public_path($path_url) . $fileName;
                $img = Image::make($thumbnailpath)->resize(720, 480, function ($constraint) {
                    $constraint->aspectRatio();
                });

                $img->save($thumbnailpath);

                IkatanAlumni::where('id', $ikatanAlumni->id)
                    ->update([
                        'thumbnail' => 'images/ikatan_alumni/' . $fileName,
                        'nama' => $request->nama,
                        'teks' => $request->teks,
                        'facebook' => $request->facebook,
                        'url_facebook' => $request->url_facebook,
                        'instagram' => $request->instagram,
                        'url_instagram' => $request->url_instagram,
                        'youtube' => $request->youtube,
                        'url_youtube' => $request->url_youtube,
                        'twitter' => $request->twitter,
                        'url_twitter' => $request->url_twitter,
                    ]);
                return redirect('/admin/ikatan_alumni')->with('status', 'Ikatan Alumni Berhasil Diubah');
            }
        }
    }

    public function menuIkatanAlumni()
    {
        $kontak = Kontak::all()->first();

        $profilSingkat = ProfilSingkat::all()->first();
        $ikatanAlumni = IkatanAlumni::all()->first();

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

        return view('portal.ikatan_alumni.detail',  compact('ikatanAlumni', 'aplikasiIntegrasis', 'informasiTerbarus',  'profilSingkat', 'kontak', 'laboratoriumHeaders'));
    }
}
