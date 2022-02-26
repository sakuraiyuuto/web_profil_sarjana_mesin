<?php

namespace App\Http\Controllers;

use App\Models\Kontak;
use App\Models\AplikasiIntegrasi;
use App\Models\InformasiTerbaru;
use App\Models\ProfilSingkat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Validator;

class ProfilSingkatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $session_user = Auth::user();
        $profilSingkat = ProfilSingkat::all()->first();
        return view('admin/profil_singkat.index', compact('profilSingkat', 'session_user'));
    }

    public function update(Request $request, ProfilSingkat $profilSingkat)
    {
        $validator = Validator::make($request->all(), [
            'nama_foto' => 'mimes:jpg,jpeg,png,svg,gif',
            'teks' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('/admin/profil_singkat')->with('alert', 'Ada kesalahan data, coba lagi.');
        } else {
            $profilSingkats = ProfilSingkat::all()
                ->where('id', $request->id)
                ->first();

            if ($request->nama_foto == "") {
                $fileName = $profilSingkats->nama_foto;

                ProfilSingkat::where('id', $request->id)
                    ->update([
                        'nama_foto' => $fileName,
                        'teks' => $request->teks,
                    ]);
                return redirect('/admin/profil_singkat')->with('status', 'Profil Singkat Berhasil Diubah');
            } else {
                $file = $profilSingkats->nama_foto;
                if (file_exists($file)) {
                    @unlink($file);
                }

                $path_url = 'images/profil_singkat/';

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

                ProfilSingkat::where('id', $request->id)
                    ->update([
                        'nama_foto' => 'images/profil_singkat/' . $fileName,
                        'teks' => $request->teks,
                    ]);
                return redirect('/admin/profil_singkat')->with('status', 'Profil Singkat Berhasil Diubah');
            }
        }
    }
}
